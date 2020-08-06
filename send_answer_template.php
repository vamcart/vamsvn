<?php
/* --------------------------------------------------------------
   $Id: send_answer_template.php 1189 2011-04-24 11:13:01Z VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders.php,v 1.109 2003/05/28); www.oscommerce.com
   (c) 2003	 nextcommerce (orders.php,v 1.19 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (orders.php,v 1.19 2003/08/24); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contribution:
   OSC German Banktransfer v0.85a       	Autor:	Dominik Guder <osc@guder.org>
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   credit card encryption functions for the catalog module
   BMC 2003 for the CC CVV Module

   Released under the GNU General Public License
   --------------------------------------------------------------*/
include_once('includes/application_top.php');

require_once(DIR_WS_CLASSES.'order.php');

		$order_number = (int)$_GET['oID'];
		$order_status = (int)$_GET['status'];

global $order_id, $oStatus;

		if ($order_id > 0) $order_number = $order_id;
		if ($oStatus > 0) $order_status = $oStatus;

		if ($order_number == 0) return;

		$order = new order($order_number);


		if (!isset($lang)) $lang=$_SESSION['languages_id'];
		$orders_statuses = array ();
		$orders_status_array = array ();
		$orders_status_query = vam_db_query("select orders_status_id, orders_status_name from ".TABLE_ORDERS_STATUS." where language_id = '".(int)$lang."'");
		while ($orders_status = vam_db_fetch_array($orders_status_query)) {
			$orders_statuses[] = array ('id' => $orders_status['orders_status_id'], 'text' => $orders_status['orders_status_name']);
			$orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
		}

		$oID = vam_db_prepare_input($order_number);
		$status = vam_db_prepare_input($order_status);

		$check_status_query = vam_db_query("select * from ".TABLE_ORDERS." where orders_id = '".vam_db_input($oID)."'");
		$check_status = vam_db_fetch_array($check_status_query);

		$check_answer_template_query = vam_db_query("select * from ".TABLE_ORDERS_STATUS." where orders_status_id = '".vam_db_input($check_status['orders_status'])."' and language_id = '".(int)$_SESSION['languages_id']."'");
		$check_answer_template_status = vam_db_fetch_array($check_answer_template_query);
		
		if ($check_answer_template_status['answer_templates_id'] > 0) {		
		$answer_template_query = vam_db_query("select * from " . TABLE_ANSWER_TEMPLATES . " where id = '" . vam_db_input($check_answer_template_status['answer_templates_id']) . "'");
		$answer_template = vam_db_fetch_array($answer_template_query);
		
		if ($answer_template['content'] != "") {

		$vamTemplate = new vamTemplate;


		$comments = $answer_template['content'];
		
				  require_once(DIR_WS_LANGUAGES . $check_status['language'] . '/modules/payment/' . $check_status['payment_class'] .'.php');
				  $order_payment_text = constant(MODULE_PAYMENT_.strtoupper($check_status['payment_class'])._TEXT_TITLE);
				
				      $shipping_method_query = vam_db_query("select title from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . vam_db_input($oID) . "' and class = 'ot_shipping'");
				      $shipping_method = vam_db_fetch_array($shipping_method_query);
				
				  $order_shipping_text = ((substr($shipping_method['title'], -1) == ':') ? substr(strip_tags($shipping_method['title']), 0, -1) : strip_tags($shipping_method['title']));

				$vamTemplate->assign('PAYMENT_METHOD', $order_payment_text);
				$vamTemplate->assign('SHIPPING_METHOD', $order_shipping_text);

		$comments = str_replace('{$NAME}', $check_status['customers_name'], $comments);
		$fio = explode(" ", $check_status['customers_name']);		
		$comments = str_replace('{$FIRST_NAME}', isset($fio[0]) ? $fio[0] : $check_status['customers_name'], $comments);
		$comments = str_replace('{$LAST_NAME}', isset($fio[1]) ? $fio[1] : $check_status['customers_name'], $comments);
		$comments = str_replace('{$ORDER_NR}', $oID, $comments);
		$comments = str_replace('{$ORDER_LINK}', vam_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id='.$oID, 'SSL'), $comments);
		$comments = str_replace('{$ORDER_DATE}', vam_date_short($check_status['date_purchased']), $comments);
		$comments = str_replace('{$ORDER_STATUS}', $orders_status_array[$status], $comments);
		$comments = str_replace('{$DELIVERY_NAME}', $check_status['delivery_name'], $comments);
		$comments = str_replace('{$DELIVERY_STREET_ADDRESS}', $check_status['delivery_street_address'], $comments);
		$comments = str_replace('{$DELIVERY_CITY}', $check_status['delivery_city'], $comments);
		$comments = str_replace('{$DELIVERY_POSTCODE}', $check_status['delivery_postcode'], $comments);
		$comments = str_replace('{$DELIVERY_STATE}', $check_status['delivery_state'], $comments);
		$comments = str_replace('{$DELIVERY_COUNTRY}', $check_status['delivery_country'], $comments);
		$comments = str_replace('{$CUSTOMERS_TELEPHONE}', $check_status['customers_telephone'], $comments);
		$comments = str_replace('{$CUSTOMERS_EMAIL_ADDRESS}', $check_status['customers_email_address'], $comments);
		$comments = str_replace('{$PAYMENT_METHOD}', $order_payment_text, $comments);
		$comments = str_replace('{$SHIPPING_METHOD}', $order_shipping_text, $comments);

		if ($check_status['orders_status'] != $status || $comments != '') {
			//vam_db_query("update ".TABLE_ORDERS." set orders_status = '".vam_db_input($status)."', last_modified = now() where orders_id = '".vam_db_input($oID)."'");
			$customer_notified = '0';
			global $notify;
			if ($notify == 'on' && !$_GET['notify']) $_GET['notify'] = $notify;
			if ($notify_comments == 'on' && !$_GET['notify_comments']) $_GET['notify_comments'] = $notify_comments;
			$_POST['notify'] = $_GET['notify'];
			$_POST['notify_comments'] = $_GET['notify_comments'];
			if ($_POST['notify'] == 'on') {
				$notify_comments = '';
				if ($_POST['notify_comments'] == 'on') {
					//$notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $comments)."\n\n";
					$notify_comments = $comments;
				} else {
					$notify_comments = '';
				}


				// assign language to template for caching
				$vamTemplate->assign('language', $_SESSION['language']);
				$vamTemplate->caching = false;

				$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
				$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

				$vamTemplate->assign('NAME', $check_status['customers_name']);
				$fio = explode(" ", $check_status['customers_name']);		
				$vamTemplate->assign('FIRST_NAME', isset($fio[0]) ? $fio[0] : $check_status['customers_name']);
				$vamTemplate->assign('LAST_NAME', isset($fio[1]) ? $fio[1] : $check_status['customers_name']);
				$vamTemplate->assign('ORDER_NR', $oID);
				$vamTemplate->assign('ORDER_TOTAL', $order->info['total']);
				$vamTemplate->assign('ORDER_LINK', vam_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id='.$oID, 'SSL'));
				$vamTemplate->assign('ORDER_DATE', vam_date_short($check_status['date_purchased']));
				$vamTemplate->assign('NOTIFY_COMMENTS', $notify_comments);
				$vamTemplate->assign('ORDER_STATUS', $orders_status_array[$status]);

				$vamTemplate->assign('DELIVERY_NAME', $check_status['delivery_name']);
				$vamTemplate->assign('DELIVERY_STREET_ADDRESS', $check_status['delivery_street_address']);
				$vamTemplate->assign('DELIVERY_CITY', $check_status['delivery_city']);
				$vamTemplate->assign('DELIVERY_POSTCODE', $check_status['delivery_postcode']);
				$vamTemplate->assign('DELIVERY_STATE', $check_status['delivery_state']);
				$vamTemplate->assign('DELIVERY_COUNTRY', $check_status['delivery_country']);
				$vamTemplate->assign('CUSTOMERS_TELEPHONE', $check_status['customers_telephone']);
				$vamTemplate->assign('CUSTOMERS_EMAIL_ADDRESS', $check_status['customers_email_address']);

				$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/change_order_mail_answer_template.html');
				$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/change_order_mail_answer_template.txt');

            // create subject
           $billing_subject = str_replace('{$nr}', $oID, EMAIL_BILLING_SUBJECT);

				vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $check_status['customers_email_address'], $check_status['customers_name'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '',  $billing_subject, $html_mail, $txt_mail);

				//if (defined('AVISOSMS_EMAIL') && AVISOSMS_EMAIL != '') {

				//$html_mail_sms = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/change_order_mail_answer_template_sms.html');
				//$txt_mail_sms = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/change_order_mail_answer_template_sms.txt');

				// sms to customer
				//vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, AVISOSMS_EMAIL, $order->customer['firstname'].' '.$order->customer['lastname'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $order->customer['telephone'], $html_mail_sms, $txt_mail_sms);
				//}
	
				$customer_notified = '1';
			}
		}
		
		}

		}
