<?php
/*------------------------------------------------------------------------------
  $Id: aviso.php 1310 2009-02-06 19:20:03 VaM $

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

// checking and handling
$aviso_data = json_decode(implode("", file('php://input')),true);

if ($aviso_data['access_key'] == MODULE_PAYMENT_AVISO_ACCESS_KEY) {
if ($aviso_data['order_status'] == 'success') {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_AVISO_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$aviso_data['merchant_order_id']."'");

  $sql_data_arrax = array('orders_id' => $aviso_data['merchant_order_id'],
                          'orders_status_id' => MODULE_PAYMENT_AVISO_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'AvisoSMS accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);
  
	//Send answer template
	vam_send_answer_template($aviso_data['merchant_order_id'],MODULE_PAYMENT_AVISO_ORDER_STATUS_ID,'on','on');
  

}
}

?>