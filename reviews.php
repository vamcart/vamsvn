<?php
/* -----------------------------------------------------------------------------------------
   $Id: reviews.php 1238 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(reviews.php,v 1.48 2003/05/27); www.oscommerce.com
   (c) 2003	 nextcommerce (reviews.php,v 1.12 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (reviews.php,v 1.12 2003/08/17); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'vam_word_count.inc.php');
require_once (DIR_FS_INC.'vam_date_long.inc.php');

$breadcrumb->add(NAVBAR_TITLE_REVIEWS, vam_href_link(FILENAME_REVIEWS));

require (DIR_WS_INCLUDES.'header.php');

if ($_SESSION['customers_status']['customers_status_read_reviews'] == 0) {
             vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL'));
}

$reviews_query_raw = "select r.reviews_id, left(rd.reviews_text, 250) as reviews_text, r.reviews_rating, r.date_added, p.products_id, pd.products_name, p.products_image, r.customers_name from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd, ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd where p.products_status = '1' and p.products_id = r.products_id and r.reviews_id = rd.reviews_id and p.products_id = pd.products_id and pd.language_id = '".(int) $_SESSION['languages_id']."' and rd.languages_id = '".(int) $_SESSION['languages_id']."' order by r.reviews_id DESC";
$reviews_split = new splitPageResults($reviews_query_raw, $_GET['page'], MAX_DISPLAY_NEW_REVIEWS);

if ($reviews_split->number_of_rows > 0) {

	$smarty->assign('NAVBAR', '<span class="right">'.TEXT_RESULT_PAGE.' '.$reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))) . '</span>' . $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS));

}

$module_data = array ();
if ($reviews_split->number_of_rows > 0) {
	$reviews_query = vam_db_query($reviews_split->sql_query);
	while ($reviews = vam_db_fetch_array($reviews_query)) {
	   $products_image = DIR_WS_THUMBNAIL_IMAGES.$reviews['products_image'];
if (!is_file($products_image)) $products_image = DIR_WS_THUMBNAIL_IMAGES.'../noimage.gif';
		$module_data[] = array ('PRODUCTS_IMAGE' => $products_image, $reviews['products_name'], 'PRODUCTS_LINK' => vam_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id='.$reviews['products_id'].'&reviews_id='.$reviews['reviews_id']), 'PRODUCTS_NAME' => $reviews['products_name'], 'AUTHOR' => $reviews['customers_name'], 'TEXT' => '('.sprintf(TEXT_REVIEW_WORD_COUNT, vam_word_count($reviews['reviews_text'], ' ')).')<br />'.htmlspecialchars($reviews['reviews_text']).'..', 'RATING' => vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.$reviews['reviews_rating'].'.gif', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])));

	}
	$smarty->assign('module_content', $module_data);
}

$smarty->assign('language', $_SESSION['language']);

// set cache ID
 if (!CacheCheck()) {
	$smarty->caching = 0;
	$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/reviews.html');
} else {
	$smarty->caching = 1;
	$smarty->cache_lifetime = CACHE_LIFETIME;
	$smarty->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/reviews.html', $cache_id);
}

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>