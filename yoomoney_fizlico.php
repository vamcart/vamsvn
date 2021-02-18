<?php
/*------------------------------------------------------------------------------
  $Id: yoomoney_fizlico.php 1310 2009-02-06 19:20:03 VaM $

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
require_once (DIR_FS_INC.'vam_send_answer_template.inc.php');

header('Content-type: text/xml; charset=utf-8');

// logging
//$fp = fopen('yandex.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_POST as $vn=>$vv) {
  //$str.=$vn.'='.$vv.';';
//}

//fwrite($fp, $str."\n");
//fclose($fp);

$crc = $_POST['sha1_hash'];

$inv_id = $_POST['label'];
$order = new order($inv_id);
$order_sum = $order->info['total'];

$hash = sha1($_POST['notification_type'].'&'.$_POST['operation_id'].'&'.$_POST['amount'].'&'.$_POST['currency'].'&'.$_POST['datetime'].'&'.$_POST['sender'].'&'.$_POST['codepro'].'&'.MODULE_PAYMENT_YOOMONEY_FIZLICO_SECRET_KEY.'&'.$_POST['label']); 

// checking and handling
if ($hash == $crc) {
if (number_format($_POST['withdraw_amount'],2) == number_format($order->info['total'],2) && $_POST['codepro'] == 'false' && $_POST['unaccepted'] == 'false') {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_YOOMONEY_FIZLICO_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");

  $sql_data_arrax = array('orders_id' => $inv_id,
                          'orders_status_id' => MODULE_PAYMENT_YOOMONEY_FIZLICO_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'ЮMoney accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);

  //echo 'OK'.$inv_id;

	//Send answer template
	vam_send_answer_template($inv_id,MODULE_PAYMENT_YOOMONEY_FIZLICO_ORDER_STATUS_ID,'on','on');

}
}

?>