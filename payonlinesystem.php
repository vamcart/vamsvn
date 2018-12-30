<?php
/*------------------------------------------------------------------------------
  $Id: payonlinesystem.php 1310 2010-06-19 19:20:03 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2010 VaMSoft Ltd.
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
require_once (DIR_FS_INC.'vam_send_answer_template.inc.php');

// logging
//$fp = fopen('payonline.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_REQUEST as $vn=>$vv) {
//  $str.=$vn.'='.$vv.';';
//}

//fwrite($fp, $str."\n");
//fclose($fp);
// variables prepearing
$crc = get_var('SecurityKey');

$inv_id = get_var('OrderId');
$order = new order($inv_id);
$order_sum = $order->info['total'];

$hash = md5('DateTime='.get_var('DateTime').'&TransactionID='.get_var('TransactionID').'&OrderId='.get_var('OrderId').'&Amount='.get_var('Amount').'&Currency=RUB&PrivateSecurityKey='.MODULE_PAYMENT_PAYONLINESYSTEM_SECRET_KEY);

// checking and handling
if ($hash == $crc) {
if (number_format($_POST['Amount'],2,'.','') == number_format($order->info['total'],2,'.','')) {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_PAYONLINESYSTEM_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");

  $sql_data_arrax = array('orders_id' => $inv_id,
                          'orders_status_id' => MODULE_PAYMENT_PAYONLINESYSTEM_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'PayOnline System accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);

  echo 'OK'.$inv_id;
  
	//Send answer template
	vam_send_answer_template($inv_id,MODULE_PAYMENT_PAYONLINESYSTEM_ORDER_STATUS_ID,'on','on');
  
}
}

?>