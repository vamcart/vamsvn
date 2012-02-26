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
//$fp = fopen('1.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_REQUEST as $vn=>$vv) {
//  $str.=$vn.'='.$vv.';';
//}

//fwrite($fp, $str."\n");
//fclose($fp);

// variables prepearing

$crc = get_var('hash');

$inv_id = get_var('orderId');
$order = new order($inv_id);
$order_sum = $order->info['total'];

$hash = md5(get_var('eshopId').'::'.get_var('orderId').'::'.get_var('serviceName').'::'.get_var('eshopAccount').'::'.get_var('recipientAmount').'::'.get_var('recipientCurrency').'::'.get_var('paymentStatus').'::'.get_var('userName').'::'.get_var('userEmail').'::'.get_var('paymentData').'::'.MODULE_PAYMENT_INTELLECTMONEY_SECRET_KEY);

// checking and handling
if ($hash == $crc) {
if (number_format($_POST['recipientAmount'],0) == number_format($order->info['total'],0)) {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_INTELLECTMONEY_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");

  $sql_data_arrax = array('orders_id' => $inv_id,
                          'orders_status_id' => MODULE_PAYMENT_INTELLECTMONEY_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'IntellectMoney accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);

  echo 'OK';
}
}

?>