<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_summary.php,v 1.3 2004/11/16 13:34:56 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_summary.php, v 1.17 2003/09/17);
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
require_once(DIR_FS_INC . 'affiliate_period.inc.php');
require_once(DIR_FS_INC . 'affiliate_level_statistics_query.inc.php');
require_once(DIR_FS_INC . 'vam_image_button.inc.php');
require_once(DIR_FS_INC . 'vam_round.inc.php');

// include boxes
require(DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes.php');

if (!isset($_SESSION['affiliate_id'])) {
    vam_redirect(vam_href_link(FILENAME_AFFILIATE, '', 'SSL'));
}

$breadcrumb->add(NAVBAR_TITLE, vam_href_link(FILENAME_AFFILIATE, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_SUMMARY, vam_href_link(FILENAME_AFFILIATE_SUMMARY));
  
$affiliate_raw = "select sum(affiliate_banners_shown) as banner_count, "
                   . "count(affiliate_clickthrough_id) as clickthrough_count, "
                   . "MONTH(affiliate_date_account_created) as start_month, "
                   . "YEAR(affiliate_date_account_created) as start_year, "
                   . "a.affiliate_commission_percent, a.affiliate_firstname, a.affiliate_id, affiliate_lastname "
                   . "from " . TABLE_AFFILIATE . " AS a "
                   . "LEFT JOIN " . TABLE_AFFILIATE_CLICKTHROUGHS . " AS ac ON ( a.affiliate_id = ac.affiliate_id )"
                   . "LEFT JOIN " . TABLE_AFFILIATE_BANNERS_HISTORY . " AS ab ON ( a.affiliate_id = ab.affiliate_banners_affiliate_id )"
                   . " where a.affiliate_id  = '" . $_SESSION['affiliate_id'] . "'"
                   . " GROUP BY a.affiliate_date_account_created, a.affiliate_commission_percent, a.affiliate_firstname, affiliate_lastname ";
$affiliate_query = vam_db_query( $affiliate_raw );
$affiliate = vam_db_fetch_array($affiliate_query);
$vamTemplate->assign('affiliate', $affiliate);

$affiliate_impressions = $affiliate['banner_count'];
if ($affiliate_impressions == 0) $affiliate_impressions="n/a";
$vamTemplate->assign('affiliate_impressions', $affiliate_impressions);

$vamTemplate->assign('period_selector', affiliate_period( 'a_period', $affiliate['start_year'], $affiliate['start_month'], true, vam_db_prepare_input( $_GET['a_period'] ), 'onchange="this.form.submit();"' ));

$affiliate_percent = 0;
$affiliate_percent = $affiliate['affiliate_commission_percent'];
if ($affiliate_percent < AFFILIATE_PERCENT) $affiliate_percent = AFFILIATE_PERCENT;
$vamTemplate->assign('affiliate_percent', vam_round($affiliate_percent, 2));

$affiliate_percent_tier = preg_split("/;/", AFFILIATE_TIER_PERCENTAGE, AFFILIATE_TIER_LEVELS );

if ( (empty($_GET['a_period'])) or ( $_GET['a_period'] == "all" ) ) {
    $affiliate_sales = affiliate_level_statistics_query( $_SESSION['affiliate_id'] );
}
else {
    $affiliate_sales = affiliate_level_statistics_query( $_SESSION['affiliate_id'], vam_db_prepare_input( $_GET['a_period'] ) );
}

$vamTemplate->assign('affiliate_transactions', vam_not_null($affiliate_sales['count']) ? $affiliate_sales['count'] : 0);

if ($affiliate_clickthroughs > 0) {
	$affiliate_conversions = vam_round(($affiliate_transactions / $affiliate_clickthroughs) * 100, 2) . "%";
}
else {
    $affiliate_conversions = "n/a";
}
$vamTemplate->assign('affiliate_conversions', $affiliate_conversions);

$vamTemplate->assign('affiliate_amount', $vamPrice->Format($affiliate_sales['total'], true));

if ($affiliate_transactions > 0) {
	$affiliate_average = vam_round($affiliate_amount / $affiliate_transactions, 2);
	$affiliate_average = $vamPrice->Format($affiliate_average, true);
}
else {
	$affiliate_average = "n/a";
}
$vamTemplate->assign('affiliate_average', $affiliate_average);

$vamTemplate->assign('affiliate_commission', $vamPrice->Format($affiliate_sales['payment'], true));;

require(DIR_WS_INCLUDES . 'header.php');

$vamTemplate->assign('FORM_ACTION', vam_draw_form('period', vam_href_link(FILENAME_AFFILIATE_SUMMARY ), 'get'));

$vamTemplate->assign('LINK_IMPRESSION', '<a href="javascript:popupAffWindow(\'' . vam_href_link(FILENAME_AFFILIATE_HELP_1) . '\')">');
$vamTemplate->assign('LINK_VISIT', '<a href="javascript:popupAffWindow(\'' . vam_href_link(FILENAME_AFFILIATE_HELP_2) . '\')">');
$vamTemplate->assign('LINK_TRANSACTIONS', '<a href="javascript:popupAffWindow(\'' . vam_href_link(FILENAME_AFFILIATE_HELP_3) . '\')">');
$vamTemplate->assign('LINK_CONVERSION', '<a href="javascript:popupAffWindow(\'' . vam_href_link(FILENAME_AFFILIATE_HELP_4) . '\')">');
$vamTemplate->assign('LINK_AMOUNT', '<a href="javascript:popupAffWindow(\'' . vam_href_link(FILENAME_AFFILIATE_HELP_5) . '\')">');
$vamTemplate->assign('LINK_AVERAGE', '<a href="javascript:popupAffWindow(\'' . vam_href_link(FILENAME_AFFILIATE_HELP_6) . '\')">');
$vamTemplate->assign('LINK_COMISSION_RATE', '<a href="javascript:popupAffWindow(\'' . vam_href_link(FILENAME_AFFILIATE_HELP_7) . '\')">');
$vamTemplate->assign('LINK_COMISSION', '<a href="javascript:popupAffWindow(\'' . vam_href_link(FILENAME_AFFILIATE_HELP_8) . '\')">');

if ( AFFILATE_USE_TIER == 'true' ) {
	$vamTemplate->assign('AFFILIATE_USE_TIER', 'true');
	
    for ($tier_number = 0; $tier_number <= AFFILIATE_TIER_LEVELS; $tier_number++ ) {
    	if (is_null($affiliate_percent_tier[$tier_number - 1])) {
    		$affiliate_percent_tier[$tier_number - 1] = $affiliate_percent;
    	}
    	$affiliate_percent_tier_table .= '<tr>';
    	$affiliate_percent_tier_table .= '<td width="15%" class="boxtext"><a href=' . vam_href_link(FILENAME_AFFILIATE_SALES, 'a_level=' . $tier_number . '&a_period=' . $a_period, 'SSL') . '>' . TEXT_COMMISSION_LEVEL_TIER . $tier_number . '</a></td>';
    	$affiliate_percent_tier_table .= '<td width="15%" align="right" class="boxtext"><a href=' . vam_href_link(FILENAME_AFFILIATE_SALES, 'a_level=' . $tier_number . '&a_period=' . $a_period, 'SSL') . '>' . TEXT_COMMISSION_RATE_TIER . '</a></td>';
    	$affiliate_percent_tier_table .= '<td width="5%" class="boxtext">' . vam_round($affiliate_percent_tier[$tier_number - 1], 2). '%' . '</td>';
    	$affiliate_percent_tier_table .= '<td width="15%" align="right" class="boxtext"><a href=' . vam_href_link(FILENAME_AFFILIATE_SALES, 'a_level=' . $tier_number . '&a_period=' . $a_period, 'SSL') . '>' . TEXT_COMMISSION_TIER_COUNT . '</a></td>';
    	$affiliate_percent_tier_table .= '<td width="5%" class="boxtext">' . ($affiliate_sales[$tier_number]['count'] > 0 ? $affiliate_sales[$tier_number]['count'] : '0') . '</td>';
    	$affiliate_percent_tier_table .= '<td width="15%" align="right" class="boxtext"><a href=' . vam_href_link(FILENAME_AFFILIATE_SALES, 'a_level=' . $tier_number . '&a_period=' . $a_period, 'SSL') . '>' . TEXT_COMMISSION_TIER_TOTAL . '</a></td>';
    	$affiliate_percent_tier_table .= '<td width="5%" class="boxtext">' . $vamPrice->Format($affiliate_sales[$tier_number]['total'], true) . '</td>';
    	$affiliate_percent_tier_table .= '<td width="20%" align="right" class="boxtext"><a href=' . vam_href_link(FILENAME_AFFILIATE_SALES, 'a_level=' . $tier_number . '&a_period=' . $a_period, 'SSL') . '>' . TEXT_COMMISSION_TIER . '</a></td>';
    	$affiliate_percent_tier_table .= '<td width="5%" class="boxtext">' . $vamPrice->Format($affiliate_sales[$tier_number]['payment'],true) . '</td>';
    	$affiliate_percent_tier_table .= '</tr>';
	}
	$vamTemplate->assign('affiliate_percent_tier_table', $affiliate_percent_tier_table);
}
$vamTemplate->assign('LINK_BANNER', '<a class="button" href="' . vam_href_link(FILENAME_AFFILIATE_BANNERS) . '">' . vam_image_button('submit.png', IMAGE_BANNERS) . '</a>');
$vamTemplate->assign('LINK_CLICKS', '<a class="button" href="' . vam_href_link(FILENAME_AFFILIATE_CLICKS, '', 'SSL') . '">' . vam_image_button('submit.png', IMAGE_CLICKTHROUGHS) . '</a>');
$vamTemplate->assign('LINK_SALES', '<a class="button" href="' . vam_href_link(FILENAME_AFFILIATE_SALES, 'a_period=' . $a_period, 'SSL') . '">' . vam_image_button('submit.png', IMAGE_SALES) . '</a>');
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content=$vamTemplate->fetch(CURRENT_TEMPLATE . '/module/affiliate_summary.html');
$vamTemplate->assign('main_content',$main_content);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$vamTemplate->display(CURRENT_TEMPLATE . '/index.html');?>
