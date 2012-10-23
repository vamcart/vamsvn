<?php
/*------------------------------------------------------------------------------
   $Id: easypay.php 998 2012/09/16 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2012 VamShop
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

	#Сбор параметров
	$status		= 2;
	$web_key	= MODULE_PAYMENT_EASYPAY_WEBKEY;

	$params		= array(
		"date"				=> date("d-m-Y H:i:s"),
		"ip"				=> $_SERVER["REMOTE_ADDR"],
		"order_mer_code"	=> $_POST["order_mer_code"],
		"sum"				=> $_POST["sum"],
		"mer_no"			=> $_POST["mer_no"],
		"card"				=> $_POST["card"],
		"purch_date"		=> $_POST["purch_date"],
		"notify_signature"	=> $_POST["notify_signature"]
	);

	#сравнение электронных подписей
	$check = md5(
		$params["order_mer_code"].
		$params["sum"].
		$params["mer_no"].
		$params["card"].
		$params["purch_date"].
		$web_key
	) == $params["notify_signature"];

	$check = true;

	if($check){
		
// checking and handling
if (number_format($params["sum"],0) == number_format($order->info['total_value'],0)) {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_EASYPAY_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");

  $sql_data_arrax = array('orders_id' => $inv_id,
                          'orders_status_id' => MODULE_PAYMENT_EASYPAY_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'EasyPay accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);

  echo 'OK'.$inv_id;

}

}

?>