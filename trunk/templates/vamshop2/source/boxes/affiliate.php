<?php
/*------------------------------------------------------------------------------
   $Id: affiliate.php,v 1.1 2004/11/16 13:42:13 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate.php, v 1.6 2003/02/22);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

$box = new vamTemplate;
$box_content='';
$box->assign('tpl_path',DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/');

if (isset($_SESSION['affiliate_id'])) {
    $box_content .= '<li><a href="' . vam_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'SSL') . '">' . BOX_AFFILIATE_SUMMARY . '</a></li>';
    $box_content .= '<li><a href="' . vam_href_link(FILENAME_AFFILIATE_ACCOUNT, '', 'SSL'). '">' . BOX_AFFILIATE_ACCOUNT . '</a></li>';
    $box_content .= '<li><a href="' . vam_href_link(FILENAME_AFFILIATE_PAYMENT, '', 'SSL'). '">' . BOX_AFFILIATE_PAYMENT . '</a></li>';
    $box_content .= '<li><a href="' . vam_href_link(FILENAME_AFFILIATE_CLICKS, '', 'SSL'). '">' . BOX_AFFILIATE_CLICKRATE . '</a></li>';
    $box_content .= '<li><a href="' . vam_href_link(FILENAME_AFFILIATE_SALES, '', 'SSL'). '">' . BOX_AFFILIATE_SALES . '</a></li>';
    $box_content .= '<li><a href="' . vam_href_link(FILENAME_AFFILIATE_BANNERS). '">' . BOX_AFFILIATE_BANNERS . '</a></li>';
    $box_content .= '<li><a href="' . vam_href_link(FILENAME_AFFILIATE_CONTACT). '">' . BOX_AFFILIATE_CONTACT . '</a></li>';
    $box_content .= '<li><a href="' . vam_href_link(FILENAME_CONTENT, 'coID=11'). '">' . BOX_AFFILIATE_FAQ . '</a></li>';
    $box_content .= '<li><a href="' . vam_href_link(FILENAME_AFFILIATE_LOGOUT). '">' . BOX_AFFILIATE_LOGOUT . '</a></li>';
}
else {
	$box_content .= '<li><a href="' . vam_href_link(FILENAME_CONTENT,'coID=10'). '">' . BOX_AFFILIATE_INFO . '</a></li>';
	$box_content .= '<li><a href="' . vam_href_link(FILENAME_AFFILIATE, '', 'SSL') . '">' . BOX_AFFILIATE_LOGIN . '</a></li>';
}
//$box->assign('BOX_TITLE', BOX_HEADING_ADD_PRODUCT_ID);
$box->assign('BOX_CONTENT', $box_content);
$box->assign('language', $_SESSION['language']);

// set cache ID
$box->caching = 0;
$box_affiliate = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_affiliate.html');
$vamTemplate->assign('box_AFFILIATE',$box_affiliate);
?>