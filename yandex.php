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

header('Content-type: text/xml; charset=utf-8');

// logging
//$fp = fopen('yandex.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_POST as $vn=>$vv) {
  //$str.=$vn.'='.$vv.';';
//}

//fwrite($fp, $str."\n");
//fclose($fp);

$crc = $_POST['md5'];

$inv_id = $_POST['orderNumber'];
$order = new order($inv_id);
$order_sum = $order->info['total'];

$hash = strtoupper(md5($_POST['action'].';'.$_POST['orderSumAmount'].';'.$_POST['orderSumCurrencyPaycash'].';'.$_POST['orderSumBankPaycash'].';'.$_POST['shopId'].';'.$_POST['invoiceId'].';'.$_POST['customerNumber'].';'.MODULE_PAYMENT_YANDEX_MERCHANT_SECRET_KEY));

if ($_POST['action'] == 'process' or $_POST['action'] == 'checkOrder') {
if ($hash == $crc) {
echo '<?xml version="1.0" encoding="UTF-8"?>
<checkOrderResponse performedDatetime="'.$_POST['requestDatetime'].'"
                    code="0" invoiceId="'.$_POST['invoiceId'].'"
                    shopId="'.MODULE_PAYMENT_YANDEX_MERCHANT_SHOP_ID.'"/>';
}
}

if ($_POST['action'] == 'paymentAviso') {
if ($hash == $crc) {
echo '<?xml version="1.0" encoding="UTF-8"?>
<paymentAvisoResponse
    performedDatetime="'.$_POST['requestDatetime'].'"
    code="0" invoiceId="'.$_POST['invoiceId'].'"
    shopId="'.MODULE_PAYMENT_YANDEX_MERCHANT_SHOP_ID.'"/>';
}
}

// checking and handling
if ($_POST['action'] == 'paymentAviso') {
if ($hash == $crc) {
if (number_format($_POST['orderSumAmount'],0) == number_format($order->info['total'],0)) {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_YANDEX_MERCHANT_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");

  $sql_data_arrax = array('orders_id' => $inv_id,
                          'orders_status_id' => MODULE_PAYMENT_YANDEX_MERCHANT_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'Yandex Money accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);

}
}
}

?>