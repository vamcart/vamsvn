<?php
/* -----------------------------------------------------------------------------------------
   $Id: advanced_search.php 988 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(advanced_search.php,v 1.49 2003/02/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (advanced_search.php,v 1.13 2003/08/21); www.nextcommerce.org
   (c) 2004	 xt:Commerce (advanced_search.php,v 1.13 2003/08/21); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create smarty elements
$smarty = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'vam_get_categories.inc.php');
require_once (DIR_FS_INC.'vam_get_manufacturers.inc.php');
require_once (DIR_FS_INC.'vam_checkdate.inc.php');

$breadcrumb->add(NAVBAR_TITLE_ADVANCED_SEARCH, vam_href_link(FILENAME_ADVANCED_SEARCH));

require (DIR_WS_INCLUDES.'header.php');

$smarty->assign('FORM_ACTION', vam_draw_form('advanced_search', vam_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get', 'onsubmit="return check_form(this);"').vam_hide_session_id());

$smarty->assign('INPUT_KEYWORDS', vam_draw_input_field('keywords', '', ''));
$smarty->assign('HELP_LINK', 'javascript:popupWindow(\''.vam_href_link(FILENAME_POPUP_SEARCH_HELP).'\')');
$smarty->assign('BUTTON_SUBMIT', vam_image_submit('button_search.gif', IMAGE_BUTTON_SEARCH));


$smarty->assign('SELECT_CATEGORIES',vam_draw_pull_down_menu('categories_id', vam_get_categories(array (array ('id' => '', 'text' => TEXT_ALL_CATEGORIES)))));
$smarty->assign('ENTRY_SUBCAT',vam_draw_checkbox_field('inc_subcat', '1', true));
$smarty->assign('SELECT_MANUFACTURERS',vam_draw_pull_down_menu('manufacturers_id', vam_get_manufacturers(array (array ('id' => '', 'text' => TEXT_ALL_MANUFACTURERS)))));
$smarty->assign('SELECT_PFROM',vam_draw_input_field('pfrom'));
$smarty->assign('SELECT_PTO',vam_draw_input_field('pto'));


$error = '';
if (isset ($_GET['errorno'])) {
	if (($_GET['errorno'] & 1) == 1) {
		$error .= str_replace('\n', '<br />', JS_AT_LEAST_ONE_INPUT);
	}
	if (($_GET['errorno'] & 10) == 10) {
		$error .= str_replace('\n', '<br />', JS_INVALID_FROM_DATE);
	}
	if (($_GET['errorno'] & 100) == 100) {
		$error .= str_replace('\n', '<br />', JS_INVALID_TO_DATE);
	}
	if (($_GET['errorno'] & 1000) == 1000) {
		$error .= str_replace('\n', '<br />', JS_TO_DATE_LESS_THAN_FROM_DATE);
	}
	if (($_GET['errorno'] & 10000) == 10000) {
		$error .= str_replace('\n', '<br />', JS_PRICE_FROM_MUST_BE_NUM);
	}
	if (($_GET['errorno'] & 100000) == 100000) {
		$error .= str_replace('\n', '<br />', JS_PRICE_TO_MUST_BE_NUM);
	}
	if (($_GET['errorno'] & 1000000) == 1000000) {
		$error .= str_replace('\n', '<br />', JS_PRICE_TO_LESS_THAN_PRICE_FROM);
	}
	if (($_GET['errorno'] & 10000000) == 10000000) {
		$error .= str_replace('\n', '<br />', JS_INVALID_KEYWORDS);
	}
}

$smarty->assign('error', $error);
$smarty->assign('language', $_SESSION['language']);
$smarty->assign('FORM_END', '</form>');

$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/advanced_search.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>