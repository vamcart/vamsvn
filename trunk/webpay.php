<?php
/*------------------------------------------------------------------------------
  $Id: robox.php 1310 2007-02-06 19:20:03 VaM $

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

// logging
//$fp = fopen(DIR_WS_IMAGES.'.ht-robox.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_REQUEST as $vn=>$vv) {
//  $str.=$vn.'='.$vv.';';
//}
//fwrite($fp, $str."\n");
//fclose($fp);

// variables prepearing
$inv_id = get_var('order_id');
$out_summ = get_var('amount');
$crc = get_var('wsb_signature');
$signature = md5(get_var('batch_timestamp').get_var('currency_id').get_var('amount').get_var('payment_method').get_var('order_id').get_var('site_order_id').get_var('transaction_id').get_var('payment_type').get_var('rrn').MODULE_PAYMENT_WEBPAY_SECRET_KEY);

// checking and handling
if (get_var('payment_type') == 1 or get_var('payment_type') == 4) {
if (strtoupper($signature) == strtoupper($crc)) {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_WEBPAY_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");

  $sql_data_arrax = array('orders_id' => $inv_id,
                          'orders_status_id' => MODULE_PAYMENT_WEBPAY_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'WebPay accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);

  echo 'OK';
}
}

?>