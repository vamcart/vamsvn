<?php
/* -----------------------------------------------------------------------------------------
   $Id: send_order.php 1029 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (send_order.php,v 1.1 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (send_order.php,v 1.1 2003/08/24); xt-commerce.com
   
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require_once (DIR_FS_INC.'vam_get_order_data.inc.php');
require_once (DIR_FS_INC.'vam_get_attributes_model.inc.php');
require_once (DIR_FS_INC.'get_cross_sell_name.inc.php');
// check if customer is allowed to send this order!
$order_query_check = vam_db_query("SELECT
  					customers_id
  					FROM ".TABLE_ORDERS."
  					WHERE orders_id='".$insert_id."'");

$order_check = vam_db_fetch_array($order_query_check);
//if ($_SESSION['customer_id'] == $order_check['customers_id']) {

// Modified by IGonza
//    global $order;
	$order = new order($insert_id);
// End Modified by IGonza

	$vamTemplate->assign('address_label_customer', vam_address_format($order->customer['format_id'], $order->customer, 1, '', '<br />'));
	$vamTemplate->assign('address_label_shipping', vam_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br />'));
	if ($_SESSION['credit_covers'] != '1') {
		$vamTemplate->assign('address_label_payment', vam_address_format($order->billing['format_id'], $order->billing, 1, '', '<br />'));
	}
	$vamTemplate->assign('csID', $order->customer['csID']);

  $it=0;
	$semextrfields = vamDBquery("select * from " . TABLE_EXTRA_FIELDS . " where fields_required_email = '1' and fields_status = '1'");
	while($dataexfes = vam_db_fetch_array($semextrfields,true)) {
	$cusextrfields = vamDBquery("select * from " . TABLE_CUSTOMERS_TO_EXTRA_FIELDS . " where customers_id = '" . (int)$_SESSION['customer_id'] . "' and fields_id = '" . $dataexfes['fields_id'] . "'");
	$rescusextrfields = vam_db_fetch_array($cusextrfields,true);

	$extrfieldsinf = vamDBquery("select fields_name from " . TABLE_EXTRA_FIELDS_INFO . " where fields_id = '" . $dataexfes['fields_id'] . "' and languages_id = '" . $_SESSION['languages_id'] . "'");

	$extrfieldsres = vam_db_fetch_array($extrfieldsinf,true);
	$extra_fields .= $extrfieldsres['fields_name'] . ': ' .
	$rescusextrfields['value'] . "\n";
	$vamTemplate->assign('customer_extra_fields', $extra_fields);
  }
	
	$order_total = $order->getTotalData($insert_id);
		$vamTemplate->assign('order_data', $order->getOrderData($insert_id));
		$vamTemplate->assign('order_total', $order_total['data']);

	// assign language to template for caching
	$vamTemplate->assign('language', $_SESSION['language']);
	$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
	$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
	$vamTemplate->assign('oID', $insert_id);
	if ($order->info['payment_method'] != '' && $order->info['payment_method'] != 'no_payment') {
		include (DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/payment/'.$order->info['payment_method'].'.php');
		$payment_method = constant(strtoupper('MODULE_PAYMENT_'.$order->info['payment_method'].'_TEXT_TITLE'));
	}
	$vamTemplate->assign('PAYMENT_METHOD', $payment_method);
	if ($order->info['shipping_method'] != '') {
		$shipping_method = $order->info['shipping_method'];
	}
	$vamTemplate->assign('SHIPPING_METHOD', $shipping_method);
	$vamTemplate->assign('DATE', vam_date_long($order->info['date_purchased']));

	$vamTemplate->assign('NAME', $order->customer['firstname']);
	$vamTemplate->assign('COMMENTS', $order->info['comments']);
	$vamTemplate->assign('EMAIL', $order->customer['email_address']);
	$vamTemplate->assign('PHONE',$order->customer['telephone']);

	$vamTemplate->assign('PAYMENT_INFO_HTML', constant(MODULE_PAYMENT_.strtoupper($order->info['payment_method'])._TEXT_DESCRIPTION));
	$vamTemplate->assign('PAYMENT_INFO_TXT', str_replace("<br />", "\n", constant(MODULE_PAYMENT_.strtoupper($order->info['payment_method'])._TEXT_DESCRIPTION)));

// Cross Sells In Email
if (XSELL_CART == 'true') {
		if ($insert_id > 0) {

		$cross_sell_products = $order->products;
		
		foreach ($cross_sell_products AS $in_cart) {
		$ids[] = intval($in_cart['id']);
		}
		
		$cross_sell_products_ids = implode(",",$ids);
		
		//echo var_dump($ids);
		//echo var_dump($cross_sell_products_ids);

  foreach ($cross_sell_products AS $product_id_in_cart) {

		$cs_groups = "SELECT products_xsell_grp_name_id FROM ".TABLE_PRODUCTS_XSELL." WHERE products_id in (".$cross_sell_products_ids.") GROUP BY products_xsell_grp_name_id";
		$cs_groups = vamDBquery($cs_groups);
		$cross_sell_data = array ();
		if (vam_db_num_rows($cs_groups, true)>0) {
		while ($cross_sells = vam_db_fetch_array($cs_groups, true)) {

			$fsk_lock = '';
			if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
				$fsk_lock = ' and p.products_fsk18!=1';
			}
			$group_check = "";
			if (GROUP_CHECK == 'true') {
				$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
			}

				$cross_query = vamDBquery("select p.products_fsk18,
												p.products_tax_class_id,
												p.products_id,
												p.label_id,
												p.products_image,
												p.products_quantity,
												pd.products_name,
												pd.products_short_description,
												p.products_fsk18,p.products_price,p.products_vpe,
												p.products_vpe_status,
												p.products_vpe_value,  
												xp.sort_order from ".TABLE_PRODUCTS_XSELL." xp, ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd
												where xp.products_id in (".$cross_sell_products_ids.") and xp.xsell_id not in (".$cross_sell_products_ids.") and xp.xsell_id = p.products_id ".$fsk_lock.$group_check."
												and p.products_id = pd.products_id 
												and xp.products_xsell_grp_name_id = ".$cross_sells['products_xsell_grp_name_id']."
												and pd.language_id = '".$_SESSION['languages_id']."'
												and p.products_status = '1'
												and p.products_quantity > '0'
												group by p.products_id
												order by xp.sort_order asc limit ".MAX_DISPLAY_ALSO_PURCHASED."");
												
			if (vam_db_num_rows($cross_query, true) > 0)
				$cross_sell_data[$cross_sells['products_xsell_grp_name_id']] = array ('GROUP' => vam_get_cross_sell_name($cross_sells['products_xsell_grp_name_id']), 'PRODUCTS' => array ());

			while ($xsell = vam_db_fetch_array($cross_query, true)) {

				$cross_sell_data[$cross_sells['products_xsell_grp_name_id']]['PRODUCTS'][] = $product->buildDataArray($xsell);
			}

		}
		}

		}
		
	   $vamTemplate->assign('cross_sell', $cross_sell_data);
	   
		}
}

	// dont allow cache
	$vamTemplate->caching = false;

	$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/order_mail.html');
	$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/order_mail.txt');

	// create subject
	$order_subject = str_replace('{$nr}', $insert_id, EMAIL_BILLING_SUBJECT_ORDER);
	$order_subject = str_replace('{$date}', strftime(DATE_FORMAT_LONG), $order_subject);
	$order_subject = str_replace('{$lastname}', $order->customer['lastname'], $order_subject);
	$order_subject = str_replace('{$firstname}', $order->customer['firstname'], $order_subject);

	// send mail to customer
if (isset($order->customer['email_address'])) {
	vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $order->customer['email_address'], $order->customer['firstname'].' '.$order->customer['lastname'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $order_subject, $html_mail, $txt_mail);
}

	// send mail to admin

	$recipients = '';
	
	if (EMAIL_BILLING_FORWARDING_STRING) $recipients = explode(',',EMAIL_BILLING_FORWARDING_STRING);
	
	foreach($recipients as $key => $value)
	{
		vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $value, STORE_NAME, '', $order->customer['email_address'], $order->customer['firstname'], '', '', $order_subject, $html_mail, $txt_mail);
	}

	if (defined('AVISOSMS_EMAIL') && AVISOSMS_EMAIL != '') {
		
	$html_mail_sms = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/order_mail_sms.html');
	$txt_mail_sms = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/order_mail_sms.txt');
		
	// sms to customer
	vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, AVISOSMS_EMAIL, $order->customer['firstname'].' '.$order->customer['lastname'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $order->customer['telephone'], $html_mail_sms, $txt_mail_sms);
	}


	if (AFTERBUY_ACTIVATED == 'true') {
		require_once (DIR_WS_CLASSES.'afterbuy.php');
		$aBUY = new vam_afterbuy_functions($insert_id);
		if ($aBUY->order_send())
			$aBUY->process_order();
	}

//} else {
	//$vamTemplate->assign('ERROR', 'You are not allowed to view this order!');
	//$vamTemplate->display(CURRENT_TEMPLATE.'/module/error_message.html');
//}
?>