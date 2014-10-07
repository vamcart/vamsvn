<?php
require('includes/application_top.php');
require (DIR_WS_CLASSES.'order.php');
header("Content-type: text/html; charset=UTF-8");
function hmac($key, $data) {
	$b = 64;
	if ( strlen($key) > $b ) {$key = pack("H*",md5($key));}
	$key = str_pad($key, $b, chr(0x00));
	$k_ipad = $key ^ str_pad(null, $b, chr(0x36));
	$k_opad = $key ^ str_pad(null, $b, chr(0x5c));
	return md5($k_opad . pack("H*",md5($k_ipad . $data)));
}
$inv_id = $_REQUEST['ext_transact'];
$order = new order($inv_id);
$order_sum = $order->info['total'];
if($_REQUEST['check']=="1"){
	$param =  $_REQUEST['ext_transact'].$_REQUEST['num_shop'].$_REQUEST['keyt_shop'].$_REQUEST['identified'].$_REQUEST['sum'].$_REQUEST['comment'];
	$sign = hmac(MODULE_PAYMENT_DELTAKEY_MERCHANT_SECRET_KEY, $param);
}else{
	$param = $_REQUEST['transact'].$_REQUEST['status'].$_REQUEST['result'].$_REQUEST['ext_transact'].$_REQUEST['num_shop'].$_REQUEST['keyt_shop'].'1'.$_REQUEST['sum'].$_REQUEST['comment'];
	$sign = hmac(MODULE_PAYMENT_DELTAKEY_MERCHANT_SECRET_KEY,$param);
}
if ( $_REQUEST['sign'] == $sign) {
	if (number_format($_REQUEST['sum'],0) == number_format($order->info['total'],0)) {
		if($_REQUEST['check']=="1"){
			die('OK');
		}else{
			if($_REQUEST['result']=="0"){
				$sql_data_array = array('orders_status' => MODULE_PAYMENT_DELTAKEY_MERCHANT_ORDER_STATUS);
				vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");
				$sql_data_arrax = array('orders_id' => $inv_id,
										'orders_status_id' => MODULE_PAYMENT_DELTAKEY_MERCHANT_ORDER_STATUS_ID,
										'date_added' => 'now()',
										'customer_notified' => '0',
										'comments' => 'DeltaKey accepted this order payment'
				);
				vam_db_perform('orders_status_history', $sql_data_arrax);
			}
		}
	}
}
header('location:http://'.$_SERVER['SERVER_NAME'].'/checkout_process.php');
?>