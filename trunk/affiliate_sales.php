<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_sales.php,v 1.3 2004/11/16 13:34:56 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_sales.php, v 1.16 2003/09/22);
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
require_once(DIR_FS_INC . 'affiliate_get_status_list.inc.php');
require_once(DIR_FS_INC . 'affiliate_get_status_array.inc.php');
require_once(DIR_FS_INC . 'affiliate_get_level_list.inc.php');
require_once(DIR_FS_INC . 'vam_date_short.inc.php');

// include boxes
require(DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes.php');

if (!isset($_SESSION['affiliate_id'])) {
    vam_redirect(vam_href_link(FILENAME_AFFILIATE, '', 'SSL'));
}

$breadcrumb->add(NAVBAR_TITLE, vam_href_link(FILENAME_AFFILIATE, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_SALES, vam_href_link(FILENAME_AFFILIATE_SALES, '', 'SSL'));

if (!isset($_GET['page'])) $_GET['page'] = 1;

if (vam_not_null($_GET['a_period'])) {
    $period_split = preg_split('/-/', vam_db_prepare_input( $_GET['a_period'] ) );
    $period_clause = " AND year(a.affiliate_date) = " . $period_split[0] . " and month(a.affiliate_date) = " . $period_split[1];
}
if (vam_not_null($_GET['a_status'])) {
    $a_status = vam_db_prepare_input( $_GET['a_status'] );
    $status_clause = " AND o.orders_status = '" . $a_status . "'";
}
if ( is_numeric( $_GET['a_level'] )  ) {
      $a_level = vam_db_prepare_input( $_GET['a_level'] );
      $level_clause = " AND a.affiliate_level = '" . $a_level . "'";
}
$affiliate_sales_raw = "select a.affiliate_payment, a.affiliate_date, a.affiliate_value, a.affiliate_percent,
    a.affiliate_payment, a.affiliate_level AS level,
    o.orders_status as orders_status_id, os.orders_status_name as orders_status, 
    MONTH(aa.affiliate_date_account_created) as start_month, YEAR(aa.affiliate_date_account_created) as start_year
    from " . TABLE_AFFILIATE . " aa
    left join " . TABLE_AFFILIATE_SALES . " a on (aa.affiliate_id = a.affiliate_id )
    left join " . TABLE_ORDERS . " o on (a.affiliate_orders_id = o.orders_id) 
    left join " . TABLE_ORDERS_STATUS . " os on (o.orders_status = os.orders_status_id and language_id = '" . $_SESSION['languages_id'] . "')
    where a.affiliate_id = '" . $_SESSION['affiliate_id'] . "' " .
    $period_clause . $status_clause . $level_clause . " 
    group by aa.affiliate_date_account_created, o.orders_status, os.orders_status_name, 
        a.affiliate_payment, a.affiliate_date, a.affiliate_value, a.affiliate_percent, 
        o.orders_status, os.orders_status_name
    order by affiliate_date DESC";

$count_key = 'aa.affiliate_date_account_created, o.orders_status, os.orders_status_name, a.affiliate_payment, a.affiliate_date, a.affiliate_value, a.affiliate_percent, o.orders_status, os.orders_status_name';
        
$affiliate_sales_split = new splitPageResults($affiliate_sales_raw, $_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $count_key);
if ($affiliate_sales_split->number_of_rows > 0) {
    $affiliate_sales_values = vam_db_query($affiliate_sales_split->sql_query);
    $affiliate_sales = vam_db_fetch_array($affiliate_sales_values);
}
else {
    $affiliate_sales_values = vam_db_query( "select MONTH(affiliate_date_account_created) as start_month,
                                      YEAR(affiliate_date_account_created) as start_year
                                      FROM " . TABLE_AFFILIATE . " WHERE affiliate_id = '" . $_SESSION['affiliate_id'] . "'" );
    $affiliate_sales = vam_db_fetch_array( $affiliate_sales_values );
}

$vamTemplate->assign('period_selector', affiliate_period('a_period', $affiliate_sales['start_year'], $affiliate_sales['start_month'], true, vam_db_prepare_input($_GET['a_period'] ), 'onchange="this.form.submit();"' ));
$vamTemplate->assign('status_selector', affiliate_get_status_list('a_status', vam_db_prepare_input($_GET['a_status']), 'onchange="this.form.submit();"' ));
$vamTemplate->assign('level_selector', affiliate_get_level_list('a_level', vam_db_prepare_input($_GET['a_level']), 'onchange="this.form.submit();"'));

require(DIR_WS_INCLUDES . 'header.php');

$vamTemplate->assign('affiliate_sales_split_numbers', $affiliate_sales_split->number_of_rows);
$vamTemplate->assign('FORM_ACTION', vam_draw_form('params', vam_href_link(FILENAME_AFFILIATE_SALES ), 'get'));

$affiliate_sales_table = '';

if ($affiliate_sales_split->number_of_rows > 0) {
    $number_of_sales = 0;
    $sum_of_earnings = 0;

    do {
    	$number_of_sales++;
    	if ($affiliate_sales['orders_status_id'] >= AFFILIATE_PAYMENT_ORDER_MIN_STATUS) $sum_of_earnings += $affiliate_sales['affiliate_payment'];
    	if (($number_of_sales / 2) == floor($number_of_sales / 2)) {
    		$affiliate_sales_table .= '<tr class="productListing-even">';
    	}
		else {
			$affiliate_sales_table .= '<tr class="productListing-odd">';
		}
		$affiliate_sales_table .= '<td class="smallText" align="center">' . vam_date_short($affiliate_sales['affiliate_date']) . '</td>';
		$affiliate_sales_table .= '<td class="smallText" align="right">' . $vamPrice->Format($affiliate_sales['affiliate_value'], true) . '</td>';
		$affiliate_sales_table .= '<td class="smallText" align="right">' . $affiliate_sales['affiliate_percent'] . " %" . '</td>';
		$affiliate_sales_table .= '<td class="smallText" align="right">' . (($affiliate_sales['level'] > 0) ? $affiliate_sales['level'] : TEXT_AFFILIATE_PERSONAL_LEVEL_SHORT) . '</td>';
		$affiliate_sales_table .= '<td class="smallText" align="right">' . $vamPrice->Format($affiliate_sales['affiliate_payment'], true) . '</td>';
		$affiliate_sales_table .= '<td class="smallText" align="right">' . (($affiliate_sales['orders_status'] != '')?$affiliate_sales['orders_status']:TEXT_DELETED_ORDER_BY_ADMIN) . '</td>';
		$affiliate_sales_table .= '</tr>';
	} while ( $affiliate_sales = vam_db_fetch_array($affiliate_sales_values) );
	$vamTemplate->assign('affiliate_sales_table', $affiliate_sales_table);
}

if ($affiliate_sales_split->number_of_rows > 0) {
	$vamTemplate->assign('affiliate_sales_count', $affiliate_sales_split->display_count(TEXT_DISPLAY_NUMBER_OF_SALES));
	$vamTemplate->assign('affiliate_sales_links', $affiliate_sales_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array('page', 'info', 'x', 'y'))));
}

$vamTemplate->assign('affiliate_sales_total', $vamPrice->Format($sum_of_earnings,true));
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content=$vamTemplate->fetch(CURRENT_TEMPLATE . '/module/affiliate_sales.html');
$vamTemplate->assign('main_content',$main_content);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$vamTemplate->display(CURRENT_TEMPLATE . '/index.html');?>
