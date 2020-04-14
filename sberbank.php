<?php
/*------------------------------------------------------------------------------
  $Id: sberbank.php 1310 2017-12-12 00:00:08 dependab1e $
------------------------------------------------------------------------------*/
if(1 != $_REQUEST['status'] || $_REQUEST['operation'] != 'deposited') die('');
require('includes/application_top.php');
require (DIR_WS_CLASSES.'order.php');
$order = new order($_REQUEST['orderNumber']);
$order_sum = $order->info['total'];
if($_REQUEST['checksum'])
{
	$data = 'amount;'.$order_sum.';mdOrder;'.$_REQUEST['mOrder'].';operation;deposited;orderNumber;'.$_REQUEST['orderNumber'].';status;1;';
	$hmac = hash_hmac ( 'sha256' , $data , MODULE_PAYMENT_SBERBANK_SECRET);
	if($hmac != $_REQUEST['checksum']) die('');
}
echo '';

$sql_data_array = array('orders_status' => MODULE_PAYMENT_SBERBANK_STATUS);
vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$_REQUEST['orderNumber']."'");
$sql_data_arrax = array(
	'orders_id' => $_REQUEST['orderNumber'],
	'orders_status_id' => MODULE_PAYMENT_PAYONLINESYSTEM_ORDER_STATUS_ID,
	'date_added' => 'now()',
	'customer_notified' => '0',
	'comments' => 'Sberbank System accepted this order payment'
);
vam_db_perform('orders_status_history', $sql_data_arrax);

?>