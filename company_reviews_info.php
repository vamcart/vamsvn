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


// lets retrieve all $HTTP_GET_VARS keys and values..
$get_params = vam_get_all_get_params(array ('reviews_id'));
$get_params = substr($get_params, 0, -1); //remove trailing &

$reviews_query = "select rd.reviews_text, rd.reviews_answer, r.reviews_rating, r.reviews_id, r.manufacturers_id, r.customers_name, r.date_added, r.last_modified, r.reviews_read, p.manufacturers_id, p.manufacturers_name, p.manufacturers_image from ".TABLE_COMPANY_REVIEWS." r left join ".TABLE_MANUFACTURERS." p on (r.manufacturers_id = p.manufacturers_id) left join ".TABLE_MANUFACTURERS_INFO." pd on (p.manufacturers_id = pd.manufacturers_id and pd.languages_id = '".(int) $_SESSION['languages_id']."'), ".TABLE_COMPANY_REVIEWS_DESCRIPTION." rd where r.reviews_id = '".(int) $_GET['reviews_id']."' and r.reviews_id = rd.reviews_id";
$reviews_query = vam_db_query($reviews_query);

if (!vam_db_num_rows($reviews_query))
	vam_redirect(vam_href_link(FILENAME_REVIEWS));
$reviews = vam_db_fetch_array($reviews_query);

$breadcrumb->add(NAVBAR_TITLE_PRODUCT_REVIEWS, vam_href_link(FILENAME_COMPANY_REVIEWS, $get_params));

vam_db_query("update ".TABLE_REVIEWS." set reviews_read = reviews_read+1 where reviews_id = '".$reviews['reviews_id']."'");

$reviews_text = vam_break_string(htmlspecialchars($reviews['reviews_text']), 60, '-<br />');

require (DIR_WS_INCLUDES.'header.php');

$SEF_parameter = '';
if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
$SEF_parameter = '&manu='.vam_cleanName($company['manufacturers_name']);

$vamTemplate->assign('PRODUCTS_NAME', $reviews['manufacturers_name']);
$vamTemplate->assign('AUTHOR', $reviews['customers_name']);
$vamTemplate->assign('DATE', vam_date_long($reviews['date_added']));
$vamTemplate->assign('REVIEWS_TEXT', nl2br($reviews_text));
$vamTemplate->assign('REVIEWS_ANSWER', nl2br($reviews['reviews_answer']));
$vamTemplate->assign('RATING', vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.$reviews['reviews_rating'].'.png', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])));
$vamTemplate->assign('PRODUCTS_LINK', vam_href_link(FILENAME_COMPANY_REVIEWS, 'manufacturers_id=' . $reviews['manufacturers_id'] . $SEF_parameter));
$vamTemplate->assign('BUTTON_BACK', '<a class="button" href="'.vam_href_link(FILENAME_COMPANY_REVIEWS, $get_params).'">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');
$vamTemplate->assign('BUTTON_BUY_NOW', '<a class="button" href="'.vam_href_link(FILENAME_DEFAULT, 'action=buy_now&BUYmanufacturers_id='.$reviews['manufacturers_id']).'">'.vam_image_button('buy.png', IMAGE_BUTTON_IN_CART) . '</a>');

$vamTemplate->assign('BUTTON_WRITE', '<a class="button" href="'.vam_href_link(FILENAME_COMPANY_REVIEWS_WRITE, $get_params).'">'.vam_image_button('add.png', IMAGE_BUTTON_WRITE_REVIEW).'</a>');

$products_image = DIR_FS_CATALGO.DIR_WS_IMAGES.'manufacturers/'.$reviews['manufacturers_image'];
if (!is_file($products_image)) $products_image = DIR_WS_THUMBNAIL_IMAGES.'../noimage.png';
$image = vam_image($products_image, $reviews['manufacturers_name'], '', '', 'hspace="5" vspace="5"');
$vamTemplate->assign('IMAGE', $image);

$vamTemplate->assign('language', $_SESSION['language']);

// set cache ID
 if (!CacheCheck()) {
	$vamTemplate->caching = 0;
	$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/company_reviews_info.html');
} else {
	$vamTemplate->caching = 1;
	$vamTemplate->cache_lifetime = CACHE_LIFETIME;
	$vamTemplate->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'].$reviews['reviews_id'];
	$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/company_reviews_info.html', $cache_id);
}

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_COMPANY_REVIEWS_INFO.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_COMPANY_REVIEWS_INFO.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>