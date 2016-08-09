<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_contact.php,v 1.3 2005/05/25 18:20:23 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_contact.php, v 1.3 2003/02/15);
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
require_once(DIR_FS_INC . 'vam_draw_input_field.inc.php');
require_once(DIR_FS_INC . 'vam_draw_textarea_field.inc.php');
require_once(DIR_FS_INC . 'vam_validate_email.inc.php');
require_once(DIR_FS_INC . 'vam_image_button.inc.php');

// include boxes
require(DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes.php');

// include the mailer-class
require_once(DIR_WS_INCLUDES . 'external/phpmailer/class.phpmailer.php');

// include all for the mails
require_once(DIR_FS_INC . 'vam_php_mail.inc.php');

if (!isset($_SESSION['affiliate_id'])) {
    vam_redirect(vam_href_link(FILENAME_AFFILIATE, '', 'SSL'));
}

$error = false;
if (isset($_GET['action']) && ($_GET['action'] == 'send')) {
    if (vam_validate_email(trim($_POST['email']))) {
        vam_php_mail($_POST['email'], $_POST['name'], AFFILIATE_EMAIL_ADDRESS, STORE_OWNER, '', $_POST['email'], $_POST['name'], '', '', EMAIL_SUBJECT, $_POST['enquiry'], $_POST['enquiry']);
        if (!isset($mail_error)) {
            vam_redirect(vam_href_link(FILENAME_AFFILIATE_CONTACT, 'action=success'));
        }
        else {
            echo $mail_error;
        }
    }
    else {
        $error = true;
    }
}

$breadcrumb->add(NAVBAR_TITLE, vam_href_link(FILENAME_AFFILIATE, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_CONTACT, vam_href_link(FILENAME_AFFILIATE_CONTACT));

require(DIR_WS_INCLUDES . 'header.php');

if (isset($_GET['action']) && ($_GET['action'] == 'success')) {
    $vamTemplate->assign('SUMMARY_LINK', '<a class="button" href="' . vam_href_link(FILENAME_AFFILIATE_SUMMARY) . '">' . vam_image_button('submit.png', IMAGE_BUTTON_CONTINUE) . '</a>');
}
else {
	// Get some values of the Affiliate
	$affili_sql = vam_db_query("SELECT affiliate_firstname, affiliate_lastname, affiliate_email_address FROM " . TABLE_AFFILIATE . " WHERE affiliate_id = " . $_SESSION['affiliate_id']);
	$affili_res = vam_db_fetch_array($affili_sql);
	
    $vamTemplate->assign('FORM_ACTION', vam_draw_form('contact_us', vam_href_link(FILENAME_AFFILIATE_CONTACT, 'action=send')));
    $vamTemplate->assign('INPUT_NAME', vam_draw_input_field('name', $affili_res['affiliate_firstname'] . ' ' . $affili_res['affiliate_lastname']));
    $vamTemplate->assign('INPUT_EMAIL', vam_draw_input_field('email', $affili_res['affiliate_email_address']));
    $vamTemplate->assign('error', $error);
    $vamTemplate->assign('TEXTAREA_ENQUIRY', vam_draw_textarea_field('enquiry', 'soft', 50, 15, $_POST['enquiry']));
    $vamTemplate->assign('BUTTON_SUBMIT', vam_image_submit('submit.png',  IMAGE_BUTTON_CONTINUE));
}
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content=$vamTemplate->fetch(CURRENT_TEMPLATE . '/module/affiliate_contact.html');
$vamTemplate->assign('main_content',$main_content);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$vamTemplate->display(CURRENT_TEMPLATE . '/index.html');?>
