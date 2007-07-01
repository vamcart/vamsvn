<?php
/* -----------------------------------------------------------------------------------------
   $Id: account_password.php 1218 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(account_password.php,v 1.1 2003/05/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (account_password.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (account_password.php,v 1.14 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'vam_validate_password.inc.php');
require_once (DIR_FS_INC.'vam_encrypt_password.inc.php');


if (!isset ($_SESSION['customer_id']))
	vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL'));

if (isset ($_POST['action']) && ($_POST['action'] == 'process')) {
	$password_current = vam_db_prepare_input($_POST['password_current']);
	$password_new = vam_db_prepare_input($_POST['password_new']);
	$password_confirmation = vam_db_prepare_input($_POST['password_confirmation']);

	$error = false;

	if (strlen($password_current) < ENTRY_PASSWORD_MIN_LENGTH) {
		$error = true;

		$messageStack->add('account_password', ENTRY_PASSWORD_CURRENT_ERROR);
	}
	elseif (strlen($password_new) < ENTRY_PASSWORD_MIN_LENGTH) {
		$error = true;

		$messageStack->add('account_password', ENTRY_PASSWORD_NEW_ERROR);
	}
	elseif ($password_new != $password_confirmation) {
		$error = true;

		$messageStack->add('account_password', ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING);
	}

	if ($error == false) {
		$check_customer_query = vam_db_query("select customers_password from ".TABLE_CUSTOMERS." where customers_id = '".(int) $_SESSION['customer_id']."'");
		$check_customer = vam_db_fetch_array($check_customer_query);

		if (vam_validate_password($password_current, $check_customer['customers_password'])) {
			vam_db_query("UPDATE ".TABLE_CUSTOMERS." SET customers_password = '".vam_encrypt_password($password_new)."', customers_last_modified=now() WHERE customers_id = '".(int) $_SESSION['customer_id']."'");

			vam_db_query("UPDATE ".TABLE_CUSTOMERS_INFO." SET customers_info_date_account_last_modified = now() WHERE customers_info_id = '".(int) $_SESSION['customer_id']."'");

			$messageStack->add_session('account', SUCCESS_PASSWORD_UPDATED, 'success');

			vam_redirect(vam_href_link(FILENAME_ACCOUNT, '', 'SSL'));
		} else {
			$error = true;

			$messageStack->add('account_password', ERROR_CURRENT_PASSWORD_NOT_MATCHING);
		}
	}
}

$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_PASSWORD, vam_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_PASSWORD, vam_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'));

require (DIR_WS_INCLUDES.'header.php');

if ($messageStack->size('account_password') > 0)
	$smarty->assign('error', $messageStack->output('account_password'));

$smarty->assign('FORM_ACTION', vam_draw_form('account_password', vam_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'), 'post', 'onsubmit="return checkform(this);"').vam_draw_hidden_field('action', 'process') . vam_draw_hidden_field('required', 'password_current,password_new,password_confirmation', 'id="required"'));

$smarty->assign('INPUT_ACTUAL', vam_draw_password_fieldNote(array ('name' => 'password_current', 'text' => '&nbsp;'. (vam_not_null(ENTRY_PASSWORD_CURRENT_TEXT) ? '<span class="Requirement">'.ENTRY_PASSWORD_CURRENT_TEXT.'</span>' : '')), '', 'id="password_current"'));
$smarty->assign('ENTRY_PASSWORD_CURRENT_ERROR', ENTRY_PASSWORD_CURRENT_ERROR);
$smarty->assign('INPUT_NEW', vam_draw_password_fieldNote(array ('name' => 'password_new', 'text' => '&nbsp;'. (vam_not_null(ENTRY_PASSWORD_NEW_TEXT) ? '<span class="Requirement">'.ENTRY_PASSWORD_NEW_TEXT.'</span>' : '')), '', 'id="password_new"'));
$smarty->assign('ENTRY_PASSWORD_NEW_ERROR', ENTRY_PASSWORD_NEW_ERROR);
$smarty->assign('INPUT_CONFIRM', vam_draw_password_fieldNote(array ('name' => 'password_confirmation', 'text' => '&nbsp;'. (vam_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="Requirement">'.ENTRY_PASSWORD_CONFIRMATION_TEXT.'</span>' : '')), '', 'id="password_confirmation"'));
$smarty->assign('ENTRY_PASSWORD_ERROR_NOT_MATCHING', ENTRY_PASSWORD_ERROR_NOT_MATCHING);

$smarty->assign('BUTTON_BACK', '<a href="'.vam_href_link(FILENAME_ACCOUNT, '', 'SSL').'">'.vam_image_button('button_back.gif', IMAGE_BUTTON_BACK).'</a>');
$smarty->assign('BUTTON_SUBMIT', vam_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
$smarty->assign('FORM_END', '</form>');

$smarty->assign('language', $_SESSION['language']);

$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/account_password.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>