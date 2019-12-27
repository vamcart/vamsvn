<?php
/* -----------------------------------------------------------------------------------------
   $Id: product_reviews_info.php 1238 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_reviews_info.php,v 1.47 2003/02/13); www.oscommerce.com
   (c) 2003	 nextcommerce (product_reviews_info.php,v 1.12 2003/08/17); www.nextcommerce.org 
   (c) 2004	 xt:Commerce (product_reviews_info.php,v 1.12 2003/08/17); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'vam_break_string.inc.php');
require_once (DIR_FS_INC.'vam_date_long.inc.php');
require_once (DIR_FS_INC.'vam_word_count.inc.php');
require_once (DIR_FS_INC.'vam_date_long.inc.php');

// lets retrieve all $HTTP_GET_VARS keys and values..
$get_params = vam_get_all_get_params(array ('reviews_id'));
$get_params = substr($get_params, 0, -1); //remove trailing &

$breadcrumb->add(NAVBAR_TITLE_PRODUCT_REVIEWS, vam_href_link(FILENAME_PRODUCT_REVIEWS, $get_params));

if (!is_object($product) || !$product->isProduct() OR !$product->data['products_id'] ) { // product not found in database

	$error = TEXT_PRODUCT_NOT_FOUND;
	include (DIR_WS_MODULES.FILENAME_ERROR_HANDLER);

} 

vam_db_query("update ".TABLE_REVIEWS." set reviews_read = reviews_read+1 where reviews_id = '".$reviews['reviews_id']."'");

$module_content = array();

require (DIR_WS_INCLUDES.'header.php');

$reviews_query = "select rd.*, r.*, p.*, pd.* from ".TABLE_REVIEWS." r left join ".TABLE_PRODUCTS." p on (r.products_id = p.products_id) left join ".TABLE_PRODUCTS_DESCRIPTION." pd on (p.products_id = pd.products_id and pd.language_id = '".(int) $_SESSION['languages_id']."'), ".TABLE_REVIEWS_DESCRIPTION." rd where r.reviews_id = '".(int) $_GET['reviews_id']."' and rd.languages_id = '".(int) $_SESSION['languages_id']."' and r.reviews_id = rd.reviews_id and p.products_status = '1'";

$reviews_query = vamDBquery($reviews_query);

if (!vam_db_num_rows($reviews_query))
	vam_redirect(vam_href_link(FILENAME_REVIEWS));
$reviews = vam_db_fetch_array($reviews_query, true);

		$star_rating = '';
		for($i=0;$i<number_format($reviews['reviews_rating']);$i++)	{
		$star_rating .= '<span class="rating"><i class="fa fa-star"></i></span> ';
		}
				
		$module_content[] = array ( 
		
		'PRODUCT' => $product->buildDataArray($reviews),

		'REVIEW' => array(

		'PRODUCTS_LINK' => vam_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$reviews['products_id']), 
		'REVIEWS_LINK' => vam_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id='.$reviews['products_id'].'&reviews_id='.$reviews['reviews_id']), 
		'REVIEWS_ALL_LINK' => vam_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id='.$reviews['products_id']), 
		'PRODUCTS_NAME' => $reviews['products_name'], 
		'AUTHOR' => $reviews['customers_name'], 
		'ID' => $reviews['reviews_id'], 
		'URL' => vam_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id='.$reviews['products_id'].'&reviews_id='.$reviews['reviews_id']), 
		'DATE' => vam_date_short($reviews['date_added']), 
		'TEXT_COUNT' => '('.sprintf(TEXT_REVIEW_WORD_COUNT, vam_word_count($reviews['reviews_text'], ' ')).')<br />'.vam_break_string(htmlspecialchars($reviews['reviews_text']), 60, '-<br />').'..', 
		'TEXT' => $reviews['reviews_text'], 
		'RATING' => $reviews['reviews_rating'],
		'STAR_RATING' => $star_rating,
		'RATING_IMG' => vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.$reviews['reviews_rating'].'.gif', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating']))
		
		)
		);	

$vamTemplate->assign('PRODUCTS_NAME', $reviews['products_name']);
$vamTemplate->assign('language', $_SESSION['language']);

$vamTemplate->assign('module_content', $module_content);

$vamTemplate->assign('REVIEWS_ALL_LINK', vam_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id='.$reviews['products_id']));
$vamTemplate->assign('REVIEWS_TOTAL', vam_db_num_rows($reviews_query));

$vamTemplate->assign('BUTTON_BACK', '<a class="btn btn-inverse" href="'.vam_href_link(FILENAME_PRODUCT_REVIEWS, $get_params).'">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');

// set cache ID
 if (!CacheCheck()) {
	$vamTemplate->caching = 0;
	$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/product_reviews_info.html');
} else {
	$vamTemplate->caching = 1;
	$vamTemplate->cache_lifetime = CACHE_LIFETIME;
	$vamTemplate->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'].$reviews['reviews_id'];
	$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/product_reviews_info.html', $cache_id);
}

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_PRODUCT_REVIEWS_INFO.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_PRODUCT_REVIEWS_INFO.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>