<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_logout.php,v 1.2 2004/04/05 18:59:11 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_logout.php, v 1.3 2003/02/17);
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

// include boxes
require(DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes.php');

$breadcrumb->add(NAVBAR_TITLE, vam_href_link(FILENAME_AFFILIATE, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_LOGOUT);

require(DIR_WS_INCLUDES . 'header.php');

$old_user = $_SESSION['affiliate_id'];  // store  to test if they *were* logged in
unset($_SESSION['affiliate_id']);
if (isset($_SESSION['affiliate_id'])) {
	$result = 0;
}
else {
	$result = 1;
}

//session_destroy();

if (!empty($old_user)) {
	if ($result) { // if they were logged in and are not logged out
	    $info = 0;
	}
	else { // they were logged in and could not be logged out
    	$info = 1;
    }
}
else { // if they weren't logged in but came to this page somehow
	$info = 2;
}

$vamTemplate->assign('info', $info);

$vamTemplate->assign('LINK_DEFAULT', '<a class="button" href="' . vam_href_link(FILENAME_DEFAULT) . '">' . vam_image_button('submit.png', IMAGE_BUTTON_CONTINUE) . '</a>');
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content=$vamTemplate->fetch(CURRENT_TEMPLATE . '/module/affiliate_logout.html');
$vamTemplate->assign('main_content',$main_content);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$vamTemplate->display(CURRENT_TEMPLATE . '/index.html');?>
