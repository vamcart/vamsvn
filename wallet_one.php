<?php
/*------------------------------------------------------------------------------
  $Id: wallet_one.php 1310 2009-02-06 19:20:03 VaM $

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

$inv_id = get_var('WMI_PAYMENT_NO');
$order = new order($inv_id);

// checking and handling
if ($_POST['WMI_ORDER_STATE'] == 'Accepted') {
if (number_format($_POST['WMI_PAYMENT_AMOUNT'],2) == number_format($order->info['total'],2)) {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_WALLET_ONE_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");

  $sql_data_arrax = array('orders_id' => $inv_id,
                          'orders_status_id' => MODULE_PAYMENT_WALLET_ONE_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'W1 accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);

  echo 'OK'.$inv_id;
}
}

?>