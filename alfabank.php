<?php
/*------------------------------------------------------------------------------
  $Id: webmoney.php 1310 2009-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
  -----------------------------------------------------------------------------
   based on:
   (c) 2005 Vetal (robox.php,v 1.48 2003/05/27); metashop.ru

  Released under the GNU General Public License
------------------------------------------------------------------------------*/

function get_var($name, $default = 'none') {
  return (isset($_GET[$name])) ? $_GET[$name] : ((isset($_POST[$name])) ? $_POST[$name] : $default);
}

require('includes/application_top.php');
require (DIR_WS_CLASSES.'order.php');

//header('Content-type: text/xml; charset=utf-8');

// logging
//$fp = fopen('yandex.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_POST as $vn=>$vv) {
  //$str.=$vn.'='.$vv.';';
//}

//fwrite($fp, $str."\n");
//fclose($fp);

        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['orderId'])){
        
            $_sgateway = ((MODULE_PAYMENT_ALFABANK_TEST == 'test') ? 'https://web.rbsuat.com/ab/rest/' : 'https://engine.paymentgate.ru/payment/rest/');
            $_slogin = MODULE_PAYMENT_ALFABANK_API_LOGIN;
            $_spassword = MODULE_PAYMENT_ALFABANK_API_PASS;
            $_qdata = array(
                'userName' => $_slogin,
                'password' => $_spassword,
                'orderId' => $_GET['orderId']
            );
            
            $response = gateway('getOrderStatus.do', $_qdata, $_sgateway, false);
            $order_id = (isset($response['OrderNumber']))?$response['OrderNumber']:0;
            if (($response['OrderStatus'] == 1 || $response['OrderStatus'] == 2) && $response['ErrorCode'] == 0) {


  $sql_data_array = array('orders_status' => MODULE_PAYMENT_ALFABANK_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$order_id."'");

  $sql_data_arrax = array('orders_id' => $order_id,
                          'orders_status_id' => MODULE_PAYMENT_ALFABANK_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'Alfabank accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);

	$_SESSION['cart']->reset(true);

	// unregister session variables used during checkout
	unset ($_SESSION['sendto']);
	unset ($_SESSION['billto']);
	unset ($_SESSION['shipping']);
	unset ($_SESSION['payment']);
	unset ($_SESSION['comments']);
	unset ($_SESSION['last_order']);
	unset ($_SESSION['tmp_oID']);
	unset ($_SESSION['cc']);

                vam_redirect(vam_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL'));

            }else{
                unset($_SESSION['cart_alfabank_id']);
                $error_text = 'Ошибка проведения платежа #'.$response['ErrorCode'].', Статус операции #'.$response['OrderStatus'];
                vam_redirect(vam_href_link(FILENAME_CHECKOUT, 'payment_error='.$error_text, 'SSL'));
            }
        }else{
                unset($_SESSION['cart_alfabank_id']);
            $error_text = 'Сервер получил неверные данные. Попробуйте повторить ваш запрос немного позже.';
                vam_redirect(vam_href_link(FILENAME_DEFAULT, 'payment_error='.$error_text, 'SSL'));
        }


function gateway($method, $data, $url, $log = false) {
	$curl = curl_init();
	curl_setopt_array($curl, array(
	    CURLOPT_URL => $url.$method,
	    CURLOPT_RETURNTRANSFER => true,
	    CURLOPT_POST => true,
	    CURLOPT_POSTFIELDS => http_build_query($data)
	));
	$response = curl_exec($curl);
	$response = json_decode($response, true);
	if ($log == true) {
		logger('Request: ' . $url . $method . ': ' . print_r($data, true).'Response: ' . $response);
	}
	curl_close($curl);
	return $response;
}

function logger($var) {
    $date = '====== '.date('Y-m-d H:i:s')." =====\n";
    $result = $var;
    if (is_array($var) || is_object($var)) {
        $result = print_r($var, true);
    }
    $result .= "\n";
    return error_log($date.$result, 0);
}        


?>