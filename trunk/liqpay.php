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

// logging

//$fp = fopen('liqpay.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_REQUEST as $vn=>$vv) {
//  $str.=$vn.'='.$vv.';';
//}

//fwrite($fp, $str."\n");
//fclose($fp);

// variables prepearing
$crc = get_var('signature');

$inv_id = get_var('order_id');
$order = new order($inv_id);
$order_sum = $order->info['total'];

$hash_source = "|".$_POST['version']."|".MODULE_PAYMENT_LIQPAY_SECRET_KEY."|".$_POST['action_name']."|".$_POST['sender_phone']."|".MODULE_PAYMENT_LIQPAY_ID."|".$_POST['amount']."|".$_POST['currency']."|".$_POST['order_id']."|".$_POST['transaction_id']."|".$_POST['status']."|".$_POST['code']."|";
$hash = base64_encode(sha1($hash_source,1));

// checking and handling
if ($_POST['status'] == 'success') {
if ($hash == $crc) {
if (number_format($_POST['amount'],0) == number_format($order->info['total'],0)) {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_LIQPAY_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");

  $sql_data_arrax = array('orders_id' => $inv_id,
                          'orders_status_id' => MODULE_PAYMENT_LIQPAY_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'LiqPAY accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);

  echo 'OK'.$inv_id;
}
}
}

?>