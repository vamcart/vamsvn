<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_password_forgotten.php,v 1.4 2004/11/16 13:34:56 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_passord_forgotten.php, v 1.7 2003/03/04);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

require('includes/application_top.php');

// create smarty elements
$vamTemplate = new vamTemplate;

// include needed functions
require_once(DIR_FS_INC . 'vam_image_button.inc.php');
require_once(DIR_FS_INC . 'vam_draw_input_field.inc.php');
require_once(DIR_FS_INC . 'vam_encrypt_password.inc.php');
require_once(DIR_FS_INC . 'vam_php_mail.inc.php');

// include boxes
require(DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes.php');

// include the mailer-class
require_once(DIR_WS_INCLUDES . 'external/phpmailer/class.phpmailer.php');

if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
	$check_affiliate_query = vam_db_query("select affiliate_firstname, affiliate_lastname, affiliate_password, affiliate_id from " . TABLE_AFFILIATE . " where affiliate_email_address = '" . $_POST['email_address'] . "'");
    if (vam_db_num_rows($check_affiliate_query)) {
    	$check_affiliate = vam_db_fetch_array($check_affiliate_query);
    	// Crypted password mods - create a new password, update the database and mail it to them
    	$newpass = vam_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);
    	$crypted_password = vam_encrypt_password($newpass);
    	vam_db_query("update " . TABLE_AFFILIATE . " set affiliate_password = '" . $crypted_password . "' where affiliate_id = '" . $check_affiliate['affiliate_id'] . "'");
    	
    	vam_php_mail(AFFILIATE_EMAIL_ADDRESS, STORE_OWNER, $_POST['email_address'], $check_affiliate['affiliate_firstname'] . " " . $check_affiliate['affiliate_lastname'], '', AFFILIATE_EMAIL_ADDRESS, STORE_OWNER, '', '', EMAIL_PASSWORD_REMINDER_SUBJECT, nl2br(sprintf(EMAIL_PASSWORD_REMINDER_BODY, $newpass)), nl2br(sprintf(EMAIL_PASSWORD_REMINDER_BODY, $newpass)));
        if (!isset($mail_error)) {
            vam_redirect(vam_href_link(FILENAME_AFFILIATE, 'info_message=' . urlencode(TEXT_PASSWORD_SENT), 'SSL', true, false));
        }
        else {
            echo $mail_error;
        }
    }
	else {
		vam_redirect(vam_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, 'email=nonexistent', 'SSL'));
    }
}
else {
	$breadcrumb->add(NAVBAR_TITLE, vam_href_link(FILENAME_AFFILIATE, '', 'SSL'));
	$breadcrumb->add(NAVBAR_TITLE_PASSWORD_FORGOTTEN, vam_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, '', 'SSL'));

	require(DIR_WS_INCLUDES . 'header.php');

	$vamTemplate->assign('FORM_ACTION', vam_draw_form('password_forgotten', vam_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, 'action=process', 'SSL')));
	$vamTemplate->assign('INPUT_EMAIL', vam_draw_input_field('email_address', '', 'maxlength="96"'));
	$vamTemplate->assign('LINK_AFFILIATE', '<a class="button" href="' . vam_href_link(FILENAME_AFFILIATE, '', 'SSL') . '">' . vam_image_button('back.png', IMAGE_BUTTON_BACK) . '</a>');
	$vamTemplate->assign('BUTTON_SUBMIT', vam_image_submit('submit.png',  IMAGE_BUTTON_CONTINUE));
	
	if (isset($_GET['email']) && ($_GET['email'] == 'nonexistent')) {
		$vamTemplate->assign('email_nonexistent', 'true');
	}
}
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content=$vamTemplate->fetch(CURRENT_TEMPLATE . '/module/affiliate_password_forgotten.html');
$vamTemplate->assign('main_content',$main_content);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$vamTemplate->display(CURRENT_TEMPLATE . '/index.html');?>
