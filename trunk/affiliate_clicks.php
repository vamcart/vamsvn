<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_clicks.php,v 1.2 2004/04/05 18:59:11 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_clicks.php, v 1.12 2003/09/22);
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
require_once(DIR_FS_INC . 'vam_date_short.inc.php');

// include boxes
require(DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes.php');

if (!isset($_SESSION['affiliate_id'])) {
    vam_redirect(vam_href_link(FILENAME_AFFILIATE, '', 'SSL'));
}

$breadcrumb->add(NAVBAR_TITLE, vam_href_link(FILENAME_AFFILIATE, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_CLICKS, vam_href_link(FILENAME_AFFILIATE_CLICKS, '', 'SSL'));

if (!isset($_GET['page'])) $_GET['page'] = 1;

$affiliate_clickthroughs_raw = "select a.*, pd.products_name from " . TABLE_AFFILIATE_CLICKTHROUGHS . " a
                                    left join " . TABLE_PRODUCTS . " p on (p.products_id = a.affiliate_products_id)
                                    left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on (pd.products_id = p.products_id and pd.language_id = '" . $_SESSION['languages_id'] . "')
                                    where a.affiliate_id = '" . $_SESSION['affiliate_id'] . "'  ORDER BY a.affiliate_clientdate desc";
$affiliate_clickthroughs_split = new splitPageResults($affiliate_clickthroughs_raw, $_GET['page'], MAX_DISPLAY_SEARCH_RESULTS);

require(DIR_WS_INCLUDES . 'header.php');

$vamTemplate->assign('affiliate_clickthroughs_split_number', $affiliate_clickthroughs_split->number_of_rows);

$affiliate_clickthrough_table = '';

if ($affiliate_clickthroughs_split->number_of_rows > 0) {
    $affiliate_clickthroughs_values = vam_db_query($affiliate_clickthroughs_split->sql_query);
    $number_of_clickthroughs = '0';
    while ($affiliate_clickthroughs = vam_db_fetch_array($affiliate_clickthroughs_values)) {
        $number_of_clickthroughs++;
        
        if (($number_of_clickthroughs / 2) == floor($number_of_clickthroughs / 2)) {
            $affiliate_clickthrough_table .= '<tr class="productListing-even">';
        }
        else {
            $affiliate_clickthrough_table .= '<tr class="productListing-odd">';
        }
        $affiliate_clickthrough_table .= '<td class="smallText">' . vam_date_short($affiliate_clickthroughs['affiliate_clientdate']) . '</td>';
        if ($affiliate_clickthroughs['affiliate_products_id'] > 0) {
            $link_to = '<a href="' . vam_href_link (FILENAME_PRODUCT_INFO, 'products_id=' . $affiliate_clickthroughs['affiliate_products_id']) . '" target="_blank">' . $affiliate_clickthroughs['products_name'] . '</a>';
        }
        else {
            $link_to = "Startpage";
        }
        $affiliate_clickthrough_table .= '<td class="smallText">' . $link_to . '</td>';
        $affiliate_clickthrough_table .= '<td class="smallText">' . $affiliate_clickthroughs['affiliate_clientreferer'] . '</td></tr>';
    }
    $vamTemplate->assign('affiliate_clickthrough_table', $affiliate_clickthrough_table);
}

if ($affiliate_clickthroughs_split->number_of_rows > 0) {
    $vamTemplate->assign('affiliate_clickthroughs_split_count', $affiliate_clickthroughs_split->display_count(TEXT_DISPLAY_NUMBER_OF_CLICKS));
    $vamTemplate->assign('affiliate_clickthroughs_split_links', $affiliate_clickthroughs_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array('page', 'info', 'x', 'y'))));
}
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content=$vamTemplate->fetch(CURRENT_TEMPLATE . '/module/affiliate_clicks.html');
$vamTemplate->assign('main_content',$main_content);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$vamTemplate->display(CURRENT_TEMPLATE . '/index.html');?>
