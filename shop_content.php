<?php

/* -----------------------------------------------------------------------------------------
   $Id: shop_content.php 1303 2005-10-12 16:47:31Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(conditions.php,v 1.21 2003/02/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (shop_content.php,v 1.1 2003/08/19); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require ('includes/application_top.php');
// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// include needed functions
require_once (DIR_FS_INC.'xtc_validate_email.inc.php');

if (GROUP_CHECK == 'true') {
	$group_check = "and group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
}

$shop_content_query = xtc_db_query("SELECT
                     content_id,
                     content_title,
                     content_heading,
                     content_text,
                     content_file
                     FROM ".TABLE_CONTENT_MANAGER."
                     WHERE content_group='".(int) $_GET['coID']."' ".$group_check."
                     AND languages_id='".(int) $_SESSION['languages_id']."'");
$shop_content_data = xtc_db_fetch_array($shop_content_query);

$breadcrumb->add($shop_content_data['content_title'], xtc_href_link(FILENAME_CONTENT.'?coID='.(int) $_GET['coID']));

if ($_GET['coID'] != 7) {
	require (DIR_WS_INCLUDES.'header.php');
}
if ($_GET['coID'] == 7 && $_GET['action'] == 'success') {
	require (DIR_WS_INCLUDES.'header.php');
}

$smarty->assign('CONTENT_HEADING', $shop_content_data['content_heading']);

if ($_GET['coID'] == 7) {

	$error = false;
	if (isset ($_GET['action']) && ($_GET['action'] == 'send')) {
		if (xtc_validate_email(trim($_POST['email']))) {

			xtc_php_mail($_POST['email'], $_POST['name'], CONTACT_US_EMAIL_ADDRESS, CONTACT_US_NAME, CONTACT_US_FORWARDING_STRING, $_POST['email'], $_POST['name'], '', '', CONTACT_US_EMAIL_SUBJECT, nl2br($_POST['message_body']), $_POST['message_body']);

			if (!isset ($mail_error)) {
				xtc_redirect(xtc_href_link(FILENAME_CONTENT, 'action=success&coID='.(int) $_GET['coID']));
			} else {
				$smarty->assign('error_message', $mail_error);

			}
		} else {
			// error report hier einbauen
			$smarty->assign('error_message', ERROR_MAIL);
			$error = true;
		}

	}

	$smarty->assign('CONTACT_HEADING', $shop_content_data['content_title']);
	if (isset ($_GET['action']) && ($_GET['action'] == 'success')) {
		$smarty->assign('success', '1');
		$smarty->assign('BUTTON_CONTINUE', '<a href="'.xtc_href_link(FILENAME_DEFAULT).'">'.xtc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE).'</a>');

	} else {
		if ($shop_content_data['content_file'] != '') {
			ob_start();
			if (strpos($shop_content_data['content_file'], '.txt'))
				echo '<pre>';
			include (DIR_FS_CATALOG.'media/content/'.$shop_content_data['content_file']);
			if (strpos($shop_content_data['content_file'], '.txt'))
				echo '</pre>';
		$contact_content = ob_get_contents();
		ob_end_clean();
		} else {
			$contact_content = $shop_content_data['content_text'];
		}
		require (DIR_WS_INCLUDES.'header.php');
		$smarty->assign('CONTACT_CONTENT', $contact_content);
		$smarty->assign('FORM_ACTION', xtc_draw_form('contact_us', xtc_href_link(FILENAME_CONTENT, 'action=send&coID='.(int) $_GET['coID'])));
		$smarty->assign('INPUT_NAME', xtc_draw_input_field('name', ($error ? $_POST['name'] : $first_name)));
		$smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', ($error ? $_POST['email'] : $email_address)));
		$smarty->assign('INPUT_TEXT', xtc_draw_textarea_field('message_body', 'soft', 50, 15, $_POST[''],'style="width:90%"'));
		$smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
		$smarty->assign('FORM_END', '</form>');
	}

	$smarty->assign('language', $_SESSION['language']);

	$smarty->caching = 0;
	$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/contact_us.html');

} else {

	if ($shop_content_data['content_file'] != '') {

		ob_start();

		if (strpos($shop_content_data['content_file'], '.txt'))
			echo '<pre>';
		include (DIR_FS_CATALOG.'media/content/'.$shop_content_data['content_file']);
		if (strpos($shop_content_data['content_file'], '.txt'))
			echo '</pre>';
		$smarty->assign('file', ob_get_contents());
		ob_end_clean();

	} else {
		$content_body = $shop_content_data['content_text'];
	}
	$smarty->assign('CONTENT_BODY', $content_body);

	$smarty->assign('BUTTON_CONTINUE', '<a href="javascript:history.back(1)">'.xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK).'</a>');
	$smarty->assign('language', $_SESSION['language']);

	// set cache ID
	 if (!CacheCheck()) {
		$smarty->caching = 0;
		$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/content.html');
	} else {
		$smarty->caching = 1;
		$smarty->cache_lifetime = CACHE_LIFETIME;
		$smarty->cache_modified_check = CACHE_CHECK;
		$cache_id = $_SESSION['language'].$shop_content_data['content_id'];
		$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/content.html', $cache_id);
	}

}

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>