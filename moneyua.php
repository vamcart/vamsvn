<?php
/*------------------------------------------------------------------------------
  $Id: moneyua.php 1310 2009-02-06 19:20:03 VaM $

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
//$fp = fopen('webmoney.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_REQUEST as $vn=>$vv) {
//  $str.=$vn.'='.$vv.';';
//}

//fwrite($fp, $str."\n");
//fclose($fp);
// variables prepearing
$crc = get_var('RETURN_HASH');

$inv_id = get_var('PAYMENT_ADDVALUE');
$order = new order($inv_id);
$order_sum = $order->info['total'];

$hash = md5(get_var('RETURN_MERCHANT').':'.get_var('RETURN_ADDVALUE').':'.get_var('RETURN_CLIENTORDER').':'.get_var('RETURN_AMOUNT').':'.get_var('RETURN_COMISSION').':'.get_var('RETURN_UNIQ_ID').':'.get_var('TEST_MODE').':'.get_var('PAYMENT_DATE').':'.MODULE_PAYMENT_MONEYUA_SECRET_KEY.':'.get_var('RETURN_RESULT')); 

// checking and handling
if ($hash == $crc) {
if (number_format($_POST['RETURN_AMOUNT'],0, '.','') == number_format($order->info['total']*100, 0, '.','')) {
if (get_var('RETURN_RESULT') == 20) {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_MONEYUA_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");

  $sql_data_arrax = array('orders_id' => $inv_id,
                          'orders_status_id' => MODULE_PAYMENT_MONEYUA_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'MoneyUA accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);

  echo 'OK';
}
}
}

?>