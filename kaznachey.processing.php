<?
header("Content-Type: text/html;charset=utf-8");
require ('includes/application_top.php');

//проверка платежа
$HTTP_RAW_POST_DATA = @$HTTP_RAW_POST_DATA ? $HTTP_RAW_POST_DATA : file_get_contents('php://input');
$hrpd = json_decode($HTTP_RAW_POST_DATA);
$callback_array = (array)$hrpd;

if (isset($callback_array['ErrorCode']) AND $callback_array['ErrorCode']==0)
{
	$c_user_id = intval($callback_array['MerchantInternalUserId']);
	$c_order_id = intval($callback_array['MerchantInternalPaymentId']);
	$c_sum = number_format($callback_array['Sum']/97*100,2,'.','');
	$c_sign = $callback_array['Signature'];
	$c_curr = $callback_array['Currency'];
	
	$sum=0;
	
	$order_query = vam_db_fetch_array(vam_db_query("select * from ".TABLE_ORDERS." where orders_id = '$c_order_id'"));
	$user_id = $order_query['customers_id'];
	$curr = $order_query['currency'];
	
	$total_query = vam_db_fetch_array(vam_db_query("select value from ".TABLE_ORDERS_TOTAL." where orders_id = '$c_order_id' AND class='ot_total'"));
	$sum = number_format($total_query['value']*$order_query['currency_value'],2,'.','');
	
	$sign = md5($callback_array['ErrorCode'].$c_order_id.$c_user_id.number_format($callback_array['Sum'], 2, '.', '').$callback_array['CustomMerchantInfo'].MODULE_PAYMENT_KAZNACHEY_SECRET_KEY);
	
	$check_sum = abs($sum-$c_sum);
	
	if ($c_sign == $sign AND $c_user_id == $user_id AND $check_sum < 0.01 AND $c_curr == $curr)
	{
		//изменение статуса
		$sql_data_array = array(
		'orders_id'=>$c_order_id,
		'orders_status_id'=>MODULE_PAYMENT_KAZNACHEY_ORDER_STATUS,
		'date_added'=>'now()',
		'customer_notified'=>((SEND_EMAILS == 'true')?'1':'0'),
		'comments'=>"Kaznachey::Оплачено"
		);
		
		vam_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
		vam_db_query("update ".TABLE_ORDERS." set orders_status = '".MODULE_PAYMENT_KAZNACHEY_ORDER_STATUS."', last_modified = now() where orders_id = '".$c_order_id."'");
		
		//изменение стока и тп
		require (DIR_WS_CLASSES.'order.php');
		$order = new order($order_id);
		for ($i = 0, $n = sizeof($order->products); $i < $n; $i++)
		{
			if (STOCK_LIMITED == 'true')
			{
				$stock_query = vam_db_query("select products_quantity from ".TABLE_PRODUCTS." where products_id = '".vam_get_prid($order->products[$i]['id'])."'");

				if (vam_db_num_rows($stock_query) > 0)
				{
					$stock_values = vam_db_fetch_array($stock_query);
					$stock_left = $stock_values['products_quantity'];
					vam_db_query("update ".TABLE_PRODUCTS." set products_quantity = '".$stock_left."' where products_id = '".vam_get_prid($order->products[$i]['id'])."'");
					if (($stock_left < 1) && (STOCK_ALLOW_CHECKOUT == 'false'))
					{
						vam_db_query("update ".TABLE_PRODUCTS." set products_status = '0' where products_id = '".vam_get_prid($order->products[$i]['id'])."'");
					}
				}
			}
			vam_db_query("update ".TABLE_PRODUCTS." set products_ordered = products_ordered + ".sprintf('%d', $order->products[$i]['qty'])." where products_id = '".vam_get_prid($order->products[$i]['id'])."'");
		}
		
		//очистка корзины
		vam_db_query("DELETE FROM ".TABLE_CUSTOMERS_BASKET." WHERE customers_id = '$c_user_id'");
		vam_db_query("DELETE FROM ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." WHERE customers_id = '$c_user_id'");
		die();
	}
}

if ($_POST['order'] != '')
{
	$order_id = intval($_POST['order']);
	$pay_system = intval($_POST['pay_system']);
	$sum = 0;
	$count = 0;
	
	require (DIR_WS_CLASSES.'order.php');
	$order = new order($order_id);
	
	$user_id = $order->customer['id'];
	
	foreach ($order->products as $product)
	{
		$count+=$product['qty'];
		$this_product['ProductItemsNum']=number_format($product['qty'],2,'.','');
		$this_product['ProductName']=$product['name'];
		$this_product['ProductId']=$product['id'];
		$this_product['ProductPrice']=number_format($product['final_price']*$order->info['currency_value'],2,'.','');
		$sum+=$this_product['ProductPrice']*$this_product['ProductItemsNum'];
		
		$p_image_query = vam_db_fetch_array(vam_db_query("select products_image from ".TABLE_PRODUCTS." where products_id = '".$product['id']."'"));
		$this_product['ImageUrl'] = $p_image_query['products_image'] ? $p_image_query['products_image'] : '';
		
		$img_path = str_replace('kaznachey.processing.php','images/product_images/original_images/',$_SERVER['PHP_SELF']);
		$this_product['ImageUrl'] = 'http://'.$_SERVER['HTTP_HOST'].$img_path.$this_product['ImageUrl'];
		
		$products[]=$this_product;
	}
	
	$shipping_query = vam_db_fetch_array(vam_db_query("select value from ".TABLE_ORDERS_TOTAL." where orders_id = '$order_id' AND class='ot_shipping'"));
	if ($shipping_query['value'] > 0)
	{
		$this_product['ProductItemsNum']=number_format(1,2,'.','');
		$this_product['ProductName']='Доставка';
		$this_product['ProductId']='0';
		$this_product['ProductPrice']=number_format($shipping_query['value']*$order->info['currency_value'],2,'.','');
		$this_product['ImageUrl']='';

		$sum+=$this_product['ProductPrice'];
		
		$products[]=$this_product;
		$count++;
	}
	
	$order_query = vam_db_fetch_array(vam_db_query("select * from ".TABLE_ORDERS." where orders_id = '".$order_id."'"));
	$customer_query = vam_db_fetch_array(vam_db_query("select * from ".TABLE_CUSTOMERS." where customers_id = '".$user_id."'"));
	
	$return_url = MODULE_PAYMENT_KAZNACHEY_REDIRECT_PAGE ? MODULE_PAYMENT_KAZNACHEY_REDIRECT_PAGE : str_replace('processing','success','http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
	
	$paymentDetails = Array(
	"MerchantInternalPaymentId"=>$order_id,
	"MerchantInternalUserId"=>$user_id,
	
	"EMail"=>$order->customer['email_address'],
	"PhoneNumber"=>$order->customer['telephone'],
	"Description"=>$order->info['comments'],
	"CustomMerchantInfo"=>'',
	
	"BuyerFirstname"=>$customer_query['customers_firstname'],
	"BuyerLastname"=>$customer_query['customers_lastname'],
	"BuyerPatronymic"=>$customer_query['customers_secondname'],
	"Fio"=>$customer_query['customers_firstname'].' '.$customer_query['customers_lastname'].' '.$customer_query['customers_secondname'],
	
	"BuyerZip"=>$order->customer['postcode'],
	"BuyerCountry"=>$order->customer['country'],
	"BuyerZone"=>$order->customer['state'],
	"BuyerCity"=>$order->customer['city'],
	"BuyerStreet"=>$order->customer['street_address'],
	"Address"=>$order->customer['postcode'].','.$order->customer['country'].','.$order->customer['state'].','.$order->customer['city'].','.$order->customer['street_address'],

	"DeliveryType"=>$order_query['shipping_method'],
	"DeliveryFirstname"=>$order_query['delivery_firstname'],
	"DeliveryLastname"=>$order_query['delivery_lastname'],
	"DeliveryPatronymic"=>$order_query['delivery_secondname'],

	"DeliveryZip"=>$order->delivery['postcode'],
	"DeliveryCountry"=>$order->delivery['country'],
	"DeliveryZone"=>$order->delivery['state'],
	"DeliveryCity"=>$order->delivery['city'],
	"DeliveryStreet"=>$order->delivery['street_address'],

	"StatusUrl"=>'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'],
	"ReturnUrl"=>$return_url    
	);
	
	function sendRequestKaznachey($url,$data)
	{
		$curl =curl_init();
		if (!$curl) return false;
		curl_setopt($curl, CURLOPT_URL,$url );
		curl_setopt($curl, CURLOPT_POST,true);
		curl_setopt($curl, CURLOPT_HTTPHEADER,array("Expect: ","Content-Type: application/json; charset=UTF-8",'Content-Length: '. strlen($data)));
		curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,True);
		$res =  curl_exec($curl);
		curl_close($curl);
		return $res;
	}
	
	$lang_query = vam_db_fetch_array(vam_db_query("select code from ".TABLE_LANGUAGES." where directory = '".$order_query['language']."'"));
	
	$signature = md5(strtoupper(MODULE_PAYMENT_KAZNACHEY_GUID).number_format($sum,2,'.','').$pay_system.$order->customer['email_address'].$order->customer['telephone'].$user_id.$order_id.strtoupper($lang_query['code']));

	$requestMerchantInfo = array(
	"Currency"=>$order->info['currency'],
	"Language"=>strtoupper($lang_query['code']),
	"SelectedPaySystemId"=>$pay_system,
	"Products"=>$products,
	"Fields"=>'',
	"PaymentDetails"=>$paymentDetails,
	"MerchantGuid"=>MODULE_PAYMENT_KAZNACHEY_GUID,
	"Signature"=>$signature
	);
	
	$resMerchantPayment = json_decode(sendRequestKaznachey('http://payment.kaznachey.net/api/PaymentInterface/CreatePaymentEX', json_encode($requestMerchantInfo)),true);
	
	vam_session_unregister('cart');
	vam_session_unregister('cart_kaznachey_id');
    vam_session_unregister('sendto');
    vam_session_unregister('billto');
	vam_session_unregister('shipping');
    vam_session_unregister('payment');
    vam_session_unregister('comments');
	
	echo base64_decode($resMerchantPayment[ExternalForm]);
}
require ('includes/application_bottom.php');
?>