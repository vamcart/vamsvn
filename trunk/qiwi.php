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

include('includes/application_top.php');

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

// Отправляем письмо клиенту и админу о смене статуса заказа

	require_once(DIR_WS_CLASSES . 'order.php');
  
  	$order = new order($transaction);
  	$vamTemplate = new vamTemplate;

				// assign language to template for caching
				$vamTemplate->assign('language', $_SESSION['language']);
				$vamTemplate->caching = false;

				$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
				$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

				$vamTemplate->assign('NAME', $order->customer['firstname'].' '.$order->customer['lastname']);
				$vamTemplate->assign('ORDER_NR', $transaction);
				$vamTemplate->assign('ORDER_LINK', vam_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id='.$transaction, 'SSL'));
				$vamTemplate->assign('ORDER_DATE', vam_date_long($order->info['date_purchased']));

			  $lang_query = vam_db_query("select languages_id from " . TABLE_LANGUAGES . " where directory = '" . $_SESSION['language'] . "'");
			  $lang = vam_db_fetch_array($lang_query);
			  $lang=$lang['languages_id'];
			
			  if (!isset($lang)) $lang=$_SESSION['languages_id'];

				$orders_status_array = array ();
				$orders_status_query = vam_db_query("select orders_status_id, orders_status_name from ".TABLE_ORDERS_STATUS." where language_id = '".$lang."'");
				while ($orders_status = vam_db_fetch_array($orders_status_query)) {
					$orders_statuses[] = array ('id' => $orders_status['orders_status_id'], 'text' => $orders_status['orders_status_name']);
					$orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
				}

				$vamTemplate->assign('ORDER_STATUS', $orders_status_array[MODULE_PAYMENT_QIWI_ORDER_STATUS_ID]);

				$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/change_order_mail.html');
				$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/change_order_mail.txt');

				include_once (DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/payment/qiwi.php');

            // create subject
           $order_subject = str_replace('{$nr}', $transaction, MODULE_PAYMENT_QIWI_EMAIL_SUBJECT);

	// send mail to admin
	vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, EMAIL_BILLING_ADDRESS, STORE_NAME, EMAIL_BILLING_FORWARDING_STRING, $order->customer['email_address'], $order->customer['firstname'], '', '', $order_subject, $html_mail, $txt_mail);

	// send mail to customer
	vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $order->customer['email_address'], $order->customer['firstname'].' '.$order->customer['lastname'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $order_subject, $html_mail, $txt_mail);

	
}

}
?>