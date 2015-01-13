<?php

class kaznachey
{
	var $code, $title, $description, $enabled;

	function kaznachey()
	{
		global $order;

		$this->code = 'kaznachey';
		
		$this->title = MODULE_PAYMENT_KAZNACHEY_TEXT_TITLE;
		$this->public_title = MODULE_PAYMENT_KAZNACHEY_TEXT_PUBLIC_TITLE;
		$this->description = MODULE_PAYMENT_KAZNACHEY_TEXT_DESCRIPTION;
		$this->info = MODULE_PAYMENT_KAZNACHEY_TEXT_INFO;
		
		$this->sort_order = MODULE_PAYMENT_KAZNACHEY_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_KAZNACHEY_STATUS == 'True') ? true : false);
		
		$this->form_action_url = 'kaznachey.processing.php';
	}

    function javascript_validation(){

    }
	
	function keys()
	{
		return array (
		'MODULE_PAYMENT_KAZNACHEY_STATUS',
		'MODULE_PAYMENT_KAZNACHEY_ALLOWED',
		'MODULE_PAYMENT_KAZNACHEY_ZONE',
		'MODULE_PAYMENT_KAZNACHEY_GUID',
		'MODULE_PAYMENT_KAZNACHEY_SECRET_KEY',
		'MODULE_PAYMENT_KAZNACHEY_ORDER_STATUS',
		'MODULE_PAYMENT_KAZNACHEY_REDIRECT_PAGE',
		'MODULE_PAYMENT_KAZNACHEY_SORT_ORDER',
		);
	}
	
	function install()
	{
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_KAZNACHEY_STATUS', 'True', '6', '1', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now());");
		
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KAZNACHEY_ALLOWED', '', '6', '0', now())");
		
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_KAZNACHEY_ZONE', '0','6', '2', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
		
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KAZNACHEY_GUID', '', '6', '1', now());");
		
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KAZNACHEY_SECRET_KEY', '', '6', '1', now());");
		
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KAZNACHEY_REDIRECT_PAGE', '', '6', '1', now());");
		
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_KAZNACHEY_ORDER_STATUS', '0', '6', '0', 'vam_cfg_pull_down_order_statuses(', 'vam_get_order_status_name', now())");
		
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KAZNACHEY_SORT_ORDER', '0', '6', '0', now())");
	}
	
	function remove()
	{
		vam_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
	}
	
	function check()
	{
		if (!isset ($this->_check)) {
			$check_query = vam_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_KAZNACHEY_STATUS'");
			$this->_check = vam_db_num_rows($check_query);
		}
		return $this->_check;
	}
	
	function sendRequestKaznachey($url,$data)
	{
		$curl =curl_init();
		if (!$curl) return false;
		curl_setopt($curl, CURLOPT_URL,$url );
		curl_setopt($curl, CURLOPT_POST,true);
		curl_setopt($curl, CURLOPT_HTTPHEADER,array("Expect: ","Content-Type: application/json; charset=UTF-8",'Content-Length: '. strlen($data)));
		curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,True);
		$res =curl_exec($curl);
		curl_close($curl);
		return $res;
	}
	
	function selection()
	{
		$requestMerchantInfo = Array(
		"MerchantGuid"=>MODULE_PAYMENT_KAZNACHEY_GUID,
		"Signature"=>md5(MODULE_PAYMENT_KAZNACHEY_GUID.MODULE_PAYMENT_KAZNACHEY_SECRET_KEY)
		);
		
		$resMerchantInfo = json_decode($this->sendRequestKaznachey('http://payment.kaznachey.net/api/PaymentInterface/GetMerchantInformation', json_encode($requestMerchantInfo)),true);
		
		$html = "<div>";
		foreach ($resMerchantInfo['PaySystems'] as $value)
		{
			if ($checked != 1) $checked_text = 'checked';
			$html .="&nbsp&nbsp&nbsp&nbsp&nbsp<input type='radio' name='pay_system' value='$value[Id]' ".$checked_text.">$value[PaySystemName] <br />";
			$checked = 1;
		}
		$html .= "</div>";
		
		return array ('id' => $this->code,
		'module' => $this->public_title,
		'description' => $html,
		);
	}

	function process_button()
	{
		global $customer_id, $order, $sendto, $vamPrice, $currencies, $shipping;
		
		$order_id = substr($_SESSION['cart_kaznachey_id'], strpos($_SESSION['cart_kaznachey_id'], '-')+1);
		$process_button_string = vam_draw_hidden_field('pay_system', $_POST['pay_system']) . vam_draw_hidden_field('order', $order_id);

		return $process_button_string;
}
	
	function pre_confirmation_check()
	{
		global $cartID, $cart;

		if (empty($_SESSION['cart']->cartID))
		{
			$_SESSION['cartID'] = $_SESSION['cart']->cartID = $_SESSION['cart']->generate_cart_id();
		}

		if (!isset($_SESSION['cartID']))
		{
			$_SESSION['cartID'] = $_SESSION['cart']->generate_cart_id();
		}
}
	
	function confirmation()
	{
		global $cartID, $customer_id, $languages_id, $order, $order_total_modules;

		if (isset($_SESSION['cartID']))
		{
			$insert_order = false;

			if (isset($_SESSION['cart_kaznachey_id']))
			{
				$order_id = substr($_SESSION['cart_kaznachey_id'], strpos($_SESSION['cart_kaznachey_id'], '-')+1);
				$curr_check = vam_db_query("select currency from " . TABLE_ORDERS . " where orders_id = '" . (int)$order_id . "'");
				$curr = vam_db_fetch_array($curr_check);

				if ( ($curr['currency'] != $order->info['currency']) || ($_SESSION['cartID'] != substr($_SESSION['cart_kaznachey_id'], 0, strlen($_SESSION['cartID']))) )
				{
					$check_query = vam_db_query('select orders_id from ' . TABLE_ORDERS_STATUS_HISTORY . ' where orders_id = "' . (int)$order_id . '" limit 1');

					if (vam_db_num_rows($check_query) < 1)
					{
						vam_db_query('delete from ' . TABLE_ORDERS . ' where orders_id = "' . (int)$order_id . '"');
						vam_db_query('delete from ' . TABLE_ORDERS_TOTAL . ' where orders_id = "' . (int)$order_id . '"');
						vam_db_query('delete from ' . TABLE_ORDERS_STATUS_HISTORY . ' where orders_id = "' . (int)$order_id . '"');
						vam_db_query('delete from ' . TABLE_ORDERS_PRODUCTS . ' where orders_id = "' . (int)$order_id . '"');
						vam_db_query('delete from ' . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . ' where orders_id = "' . (int)$order_id . '"');
						vam_db_query('delete from ' . TABLE_ORDERS_PRODUCTS_DOWNLOAD . ' where orders_id = "' . (int)$order_id . '"');
					}

				$insert_order = true;
				}
			}
			else
			{
				$insert_order = true;
			}

			if ($insert_order == true)
			{
				$order_totals = array();
				if (is_array($order_total_modules->modules))
				{
					reset($order_total_modules->modules);
					while (list(, $value) = each($order_total_modules->modules))
					{
						$class = substr($value, 0, strrpos($value, '.'));
						if ($GLOBALS[$class]->enabled)
						{
							for ($i=0, $n=sizeof($GLOBALS[$class]->output); $i<$n; $i++)
							{
								if (vam_not_null($GLOBALS[$class]->output[$i]['title']) && vam_not_null($GLOBALS[$class]->output[$i]['text']))
								{
									$order_totals[] = array('code' => $GLOBALS[$class]->code,
									'title' => $GLOBALS[$class]->output[$i]['title'],
									'text' => $GLOBALS[$class]->output[$i]['text'],
									'value' => $GLOBALS[$class]->output[$i]['value'],
									'sort_order' => $GLOBALS[$class]->sort_order);
								}
							}
						}
					}
				}

if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
	$discount = $_SESSION['customers_status']['customers_status_ot_discount'];
} else {
	$discount = '0.00';
}

if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
	$customers_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
} else {
	$customers_ip = $_SERVER["REMOTE_ADDR"];
}

$sql_data_array = array('customers_id' => $_SESSION['customer_id'],
'customers_name' => $order->customer['firstname'] . ' ' . $order->customer['lastname'],
'customers_cid' => $order->customer['csID'],
'customers_vat_id' => $_SESSION['customer_vat_id'],
'customers_company' => $order->customer['company'],
'customers_status' => $_SESSION['customers_status']['customers_status_id'],
'customers_status_name' => $_SESSION['customers_status']['customers_status_name'],
'customers_status_image' => $_SESSION['customers_status']['customers_status_image'],
'customers_status_discount' => $discount,
'customers_street_address' => $order->customer['street_address'],
'customers_suburb' => $order->customer['suburb'],
'customers_city' => $order->customer['city'],
'customers_postcode' => $order->customer['postcode'],
'customers_state' => $order->customer['state'],
'customers_country' => $order->customer['country']['title'],
'customers_telephone' => $order->customer['telephone'],
'customers_email_address' => $order->customer['email_address'],
'customers_address_format_id' => $order->customer['format_id'],
'delivery_name' => $order->delivery['firstname'] . ' ' . $order->delivery['lastname'],
'delivery_company' => $order->delivery['company'],
'delivery_street_address' => $order->delivery['street_address'],
'delivery_suburb' => $order->delivery['suburb'],
'delivery_city' => $order->delivery['city'],
'delivery_postcode' => $order->delivery['postcode'],
'delivery_state' => $order->delivery['state'],
'delivery_country' => $order->delivery['country']['title'],
'delivery_address_format_id' => $order->delivery['format_id'],
'billing_name' => $order->billing['firstname'] . ' ' . $order->billing['lastname'],
'billing_company' => $order->billing['company'],
'billing_street_address' => $order->billing['street_address'],
'billing_suburb' => $order->billing['suburb'],
'billing_city' => $order->billing['city'],
'billing_postcode' => $order->billing['postcode'],
'billing_state' => $order->billing['state'],
'billing_country' => $order->billing['country']['title'],
'billing_address_format_id' => $order->billing['format_id'],
'payment_method' => $order->info['payment_method'],
'payment_class' => $order->info['payment_class'],
'shipping_method' => $order->info['shipping_method'],
'shipping_class' => $order->info['shipping_class'],
'language' => $_SESSION['language'],
'comments' => $order->info['comments'],
'customers_ip' => $customers_ip,
'orig_reference' => $order->customer['orig_reference'],
'login_reference' => $order->customer['login_reference'],
'cc_type' => $order->info['cc_type'],
'cc_owner' => $order->info['cc_owner'],
'cc_number' => $order->info['cc_number'],
'cc_expires' => $order->info['cc_expires'],
'date_purchased' => 'now()',
'orders_status' => $order->info['order_status'],
'currency' => $order->info['currency'],
'currency_value' => $order->info['currency_value']);

vam_db_perform(TABLE_ORDERS, $sql_data_array);

$insert_id = vam_db_insert_id();

			$customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';
			$sql_data_array = array ('orders_id' => $insert_id, 'orders_status_id' => $order->info['order_status'], 'date_added' => 'now()', 'customer_notified' => $customer_notification, 'comments' => $order->info['comments']);
			vam_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) {
$sql_data_array = array('orders_id' => $insert_id,
'title' => $order_totals[$i]['title'],
'text' => $order_totals[$i]['text'],
'value' => $order_totals[$i]['value'],
'class' => $order_totals[$i]['code'],
'sort_order' => $order_totals[$i]['sort_order']);

vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
}

for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
$sql_data_array = array('orders_id' => $insert_id,
'products_id' => vam_get_prid($order->products[$i]['id']),
'products_model' => $order->products[$i]['model'],
'products_name' => $order->products[$i]['name'],
'products_price' => $order->products[$i]['price'],
'final_price' => $order->products[$i]['final_price'],
'products_tax' => $order->products[$i]['tax'],
'products_quantity' => $order->products[$i]['qty']);

vam_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);

$order_products_id = vam_db_insert_id();

$attributes_exist = '0';
if (isset($order->products[$i]['attributes'])) {
$attributes_exist = '1';
for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
if (DOWNLOAD_ENABLED == 'true') {
$attributes_query = "select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix, pad.products_attributes_maxdays, pad.products_attributes_maxcount , pad.products_attributes_filename, pad.products_attributes_is_pin
 from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa
 left join " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
 on pa.products_attributes_id=pad.products_attributes_id
 where pa.products_id = '" . $order->products[$i]['id'] . "'
 and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "'
 and pa.options_id = popt.products_options_id
 and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "'
 and pa.options_values_id = poval.products_options_values_id
 and popt.language_id = '" . $_SESSION['languages_id'] . "'
 and poval.language_id = '" . $_SESSION['languages_id'] . "'";
$attributes = vam_db_query($attributes_query);
} else {
$attributes = vam_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . $order->products[$i]['id'] . "' and pa.options_id = '" . $order->products[$i]['attributes'][$j]['option_id'] . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . $order->products[$i]['attributes'][$j]['value_id'] . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . $_SESSION['languages_id'] . "' and poval.language_id = '" . $_SESSION['languages_id'] . "'");
}

			// update attribute stock
			vam_db_query("UPDATE ".TABLE_PRODUCTS_ATTRIBUTES." set
						 attributes_stock=attributes_stock - '".$order->products[$i]['qty']."'
						 where
						 products_id='".$order->products[$i]['id']."'
						 and options_values_id='".$order->products[$i]['attributes'][$j]['value_id']."'
						 and options_id='".$order->products[$i]['attributes'][$j]['option_id']."'
						 ");

$attributes_values = vam_db_fetch_array($attributes);

$sql_data_array = array('orders_id' => $insert_id,
'orders_products_id' => $order_products_id,
'products_options' => $attributes_values['products_options_name'],
'products_options_values' => $attributes_values['products_options_values_name'],
'options_values_price' => $attributes_values['options_values_price'],
'price_prefix' => $attributes_values['price_prefix']);

vam_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);

if ((DOWNLOAD_ENABLED == 'true') && ((isset($attributes_values['products_attributes_filename']) && vam_not_null($attributes_values['products_attributes_filename'])) or $attributes_values['products_attributes_is_pin'])) {
				
		//PIN add
		for($pincycle=0;$pincycle<$order->products[$i]['qty'];$pincycle++) {
if($attributes_values['products_attributes_is_pin']) {
	$pin_query=vam_db_query("SELECT products_pin_id, products_pin_code FROM ".TABLE_PRODUCTS_PINS." WHERE products_id = '".$order->products[$i]['id']."' AND products_pin_used='0' LIMIT 1");

	if(vam_db_num_rows($pin_query)=='0') { // We have no PIN for this product
		// insert some error notifying here
		$pin=PIN_NOT_AVAILABLE;
	} else {
		$pin_res=vam_db_fetch_array($pin_query);
		$pin=$pin_res['products_pin_code'];
		vam_db_query("UPDATE ".TABLE_PRODUCTS_PINS." SET products_pin_used='".$insert_id."' WHERE products_pin_id = '".$pin_res['products_pin_id']."'");
	}
}
//PIN				
$sql_data_array = array('orders_id' => $insert_id,
'orders_products_id' => $order_products_id,
'orders_products_filename' => $attributes_values['products_attributes_filename'],
'download_maxdays' => $attributes_values['products_attributes_maxdays'],
'download_count' => $attributes_values['products_attributes_maxcount'],
'download_is_pin' => $attributes_values['products_attributes_is_pin'],
'download_pin_code' => $pin
 );

vam_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
}
}
}
}
}

$_SESSION['cart_kaznachey_id'] = $_SESSION['cartID'] . '-' . $insert_id;
}
}

return array('title' => '');
}
	
	
	
	
	
	
}
?>