<?php
/*------------------------------------------------------------------------------
  $Id: qiwi.php 2588 2010/04/13 13:24:46 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2010 VaMSoft Ltd.
  -----------------------------------------------------------------------------
   based on:
   (c) 2005 Vetal (robox.php,v 1.48 2003/05/27); metashop.ru

  Released under the GNU General Public License
------------------------------------------------------------------------------*/

require('includes/application_top.php');

require_once(DIR_WS_CLASSES . 'nusoap/nusoap.php');
        
$server = new nusoap_server;
$server->register('updateBill');
$server->service($HTTP_RAW_POST_DATA);

function updateBill($login, $password, $txn, $status) {

//обработка возможных ошибок авторизации
if ( $login != MODULE_PAYMENT_QIWI_ID )
return 150;

if ( !empty($password) && $password != md5(MODULE_PAYMENT_QIWI_SECRET_KEY) )
return 150;

// получаем номер заказа
$transaction = intval($txn);

// меняем статус заказа при условии оплаты счёта
if ( $status == 60 ) {
	
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_QIWI_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$transaction."'");

  $sql_data_arrax = array('orders_id' => $transaction,
                          'orders_status_id' => MODULE_PAYMENT_QIWI_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'QIWI accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);
	
}

}
?>