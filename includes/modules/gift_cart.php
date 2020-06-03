<?php
/* -----------------------------------------------------------------------------------------
   $Id: gift_cart.php 842 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(shopping_cart.php,v 1.32 2003/02/11); www.oscommerce.com
   (c) 2003     nextcommerce (shopping_cart.php,v 1.21 2003/08/17); www.nextcommerce.org
   (c) 2004     xt:Commerce (shopping_cart.php,v 1.21 2003/08/17); xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:


   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$gift = new vamTemplate;
$gift->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

if (ACTIVATE_GIFT_SYSTEM == 'true') {
	$gift->assign('ACTIVATE_GIFT', 'true');
}

if (isset ($_SESSION['customer_id'])) {
	$gv_query = vam_db_query("select amount from ".TABLE_COUPON_GV_CUSTOMER." where customer_id = '".$_SESSION['customer_id']."'");
	$gv_result = vam_db_fetch_array($gv_query);
	if ($gv_result['amount'] > 0) {
		$gift->assign('GV_AMOUNT', $vamPrice->Format($gv_result['amount'], true, 0, true));
		$gift->assign('GV_SEND_TO_FRIEND_LINK', vam_href_link(FILENAME_GV_SEND));
	} else {
		$gift->assign('GV_AMOUNT', 0);
	}
}
if (isset ($_SESSION['gv_id'])) {
	$gv_query = vam_db_query("select coupon_amount from ".TABLE_COUPONS." where coupon_id = '".$_SESSION['gv_id']."'");
	$coupon = vam_db_fetch_array($gv_query);
	$gift->assign('COUPON_AMOUNT2', $vamPrice->Format($coupon['coupon_amount'], true, 0, true));
}
if (isset ($_SESSION['cc_id'])) {
	$gift->assign('COUPON_HELP_LINK', '<a style="cursor: pointer" onclick="javascript:window.open(\''.vam_href_link(FILENAME_POPUP_COUPON_HELP, 'cID='.$_SESSION['cc_id']).'\', \'popup\', \'toolbar=0,scrollbars=yes, width=350, height=350\')">');

}
//if (isset ($_SESSION['customer_id'])) {
	$gift->assign('C_FLAG', 'true');
//}
$gift->assign('LINK_ACCOUNT', vam_href_link(FILENAME_CREATE_ACCOUNT));
$gift->assign('FORM_ACTION', vam_draw_form('gift_coupon', vam_href_link(FILENAME_SHOPPING_CART, 'action=check_gift', 'NONSSL'), 'post', ''));
$gift->assign('INPUT_CODE', vam_draw_input_field('gv_redeem_code', '', 'class="input-small"'));
$gift->assign('BUTTON_SUBMIT', vam_image_submit('submit.png', IMAGE_REDEEM_GIFT));
$gift->assign('language', $_SESSION['language']);
$gift->assign('FORM_END', '</form>');
$gift->caching = 0;

$vamTemplate->assign('MODULE_gift_cart', $gift->fetch(CURRENT_TEMPLATE.'/module/gift_cart.html'));
?>