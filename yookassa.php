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

require('includes/application_top.php');
require (DIR_WS_CLASSES.'order.php');
require_once (DIR_FS_INC.'vam_send_answer_template.inc.php');

// logging
//$fp = fopen('yandex.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_POST as $vn=>$vv) {
  //$str.=$vn.'='.$vv.';';
//}

//fwrite($fp, $str."\n");
//fclose($fp);

$data = file_get_contents('php://input');
$json = json_decode($data, true);

$inv_id = $json['object']['description'];
$order = new order($inv_id);
$order_sum = $order->info['total'];

// checking and handling
if ($json['event'] == 'payment.succeeded' && $json['object']['status'] == 'succeeded') {
if ($json['object']['paid'] == 'true') {
if (number_format($json['object']['amount']['value'],0) == number_format($order->info['total'],0)) {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_YOOKASSA_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");

  $sql_data_array = array('orders_id' => $inv_id,
                          'orders_status_id' => MODULE_PAYMENT_YOOKASSA_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'Yandex.Kassa accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_array);

	//Send answer template
	vam_send_answer_template($inv_id,MODULE_PAYMENT_YOOKASSA_ORDER_STATUS_ID,'on','on');

}
}
}

?>