<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_affiliate.php,v 1.2 2004/04/05 18:59:11 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_affiliate.php, v 1.8 2003/02/19);
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

// include boxes
require(DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes.php');

// include needed functions
require_once(DIR_FS_INC . 'vam_draw_password_field.inc.php');
require_once(DIR_FS_INC . 'vam_image_button.inc.php');
require_once(DIR_FS_INC . 'vam_validate_password.inc.php');

if (isset($_SESSION['affiliate_id'])) {
    vam_redirect(vam_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'SSL'));
}

if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $affiliate_username = vam_db_prepare_input($_POST['affiliate_username']);
    $affiliate_password = vam_db_prepare_input($_POST['affiliate_password']);
    
    // Check if username exists
    $check_affiliate_query = vam_db_query("select affiliate_id, affiliate_firstname, affiliate_password, affiliate_email_address from " . TABLE_AFFILIATE . " where affiliate_email_address = '" . vam_db_input($affiliate_username) . "'");
    if (!vam_db_num_rows($check_affiliate_query)) {
        $_GET['login'] = 'fail';
    }
    else {
        $check_affiliate = vam_db_fetch_array($check_affiliate_query);
        // Check that password is good
        if (!vam_validate_password($affiliate_password, $check_affiliate['affiliate_password'])) {
            $_GET['login'] = 'fail';
        }
        else {
            $_SESSION['affiliate_id'] = $check_affiliate['affiliate_id'];

            $date_now = date('Ymd');
            
            vam_db_query("update " . TABLE_AFFILIATE . " set affiliate_date_of_last_logon = now(), affiliate_number_of_logons = affiliate_number_of_logons + 1 where affiliate_id = '" . $_SESSION['affiliate_id'] . "'");
            vam_redirect(vam_href_link(FILENAME_AFFILIATE_SUMMARY,'','SSL'));
        }
    }
}

$breadcrumb->add(NAVBAR_TITLE, vam_href_link(FILENAME_AFFILIATE, '', 'SSL'));

require(DIR_WS_INCLUDES . 'header.php');

if (isset($_GET['login']) && ($_GET['login'] == 'fail')) {
    $info_message = 'true';
}
else {
    $info_message = 'false';
}

$vamTemplate->assign('info_message', $info_message);

$vamTemplate->assign('FORM_ACTION', vam_draw_form('login', vam_href_link(FILENAME_AFFILIATE, 'action=process', 'SSL')));
$vamTemplate->assign('LINK_TERMS', '<a  href="' . vam_href_link(FILENAME_CONTENT,'coID=9', 'SSL') . '">');
$vamTemplate->assign('INPUT_AFFILIATE_USERNAME', vam_draw_input_field('affiliate_username'));
$vamTemplate->assign('INPUT_AFFILIATE_PASSWORD', vam_draw_password_field('affiliate_password'));
$vamTemplate->assign('LINK_PASSWORD_FORGOTTEN', '<a href="' . vam_href_link(FILENAME_AFFILIATE_PASSWORD_FORGOTTEN, '', 'SSL') . '">');
$vamTemplate->assign('LINK_SIGNUP', '<a class="button" href="' . vam_href_link(FILENAME_AFFILIATE_SIGNUP, '', 'SSL') . '">' . vam_image_button('submit.png', IMAGE_BUTTON_CONTINUE) . '</a>');
$vamTemplate->assign('BUTTON_LOGIN', vam_image_submit('button_login.gif', IMAGE_BUTTON_LOGIN));

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content=$vamTemplate->fetch(CURRENT_TEMPLATE . '/module/affiliate_affiliate.html');
$vamTemplate->assign('main_content',$main_content);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$vamTemplate->display(CURRENT_TEMPLATE . '/index.html');?>
