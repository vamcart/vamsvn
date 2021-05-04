<?php
/* -----------------------------------------------------------------------------------------
   $Id: product_reviews.php 1243 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_reviews.php,v 1.47 2003/02/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (product_reviews.php,v 1.12 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (product_reviews.php,v 1.12 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

// create template elements
$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');


// Start product/catalog variables set fot template
$module->assign( 'product_name_tpl', $product_name_tpl );
$module->assign( 'products_category_tpl', $products_category_tpl_arr );
$module->assign( 'category_path_tpl', $category_path_tpl_arr );
// End product/catalog variables set fot template


// include boxes
// include needed functions
require_once (DIR_FS_INC.'vam_row_number_format.inc.php');
require_once (DIR_FS_INC.'vam_date_short.inc.php');

$info->assign('options', $products_options_data);

$module->assign('PRODUCTS_NAME', $product->data['products_name']);
$module->assign('PRODUCTS_ID', $product->data['products_id']);
$module->assign('PRODUCTS_LINK', vam_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$product->data['products_id'])); 

global $current_category_id;
$module->assign('CATEGORY_ID', $current_category_id);

$module->assign('PRODUCTS_REVIEWS_COUNT', $product->getReviewsCount());
$module->assign('PRODUCTS_REVIEWS_RATING', $product->getReviewsRating());

$module->assign('PRODUCTS_REVIEWS_WRITE', vam_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, vam_product_link($product->data['products_id'],$product->data['products_name'])));
$module->assign('PRODUCTS_REVIEWS', vam_href_link(FILENAME_PRODUCT_REVIEWS, vam_product_link($product->data['products_id'],$product->data['products_name'])));

$rating_count = 0;

if ($product->getReviewsCount() > 0) {

$star_rating = '';
for($i=0;$i<number_format($product->getReviewsRating());$i++)	{
$star_rating .= '<span class="rating"><i class="fa fa-star"></i></span> ';
}

$module->assign('PRODUCTS_STAR_RATING', $star_rating);

$rating_count = $product->getReviewsCount();

$one_star_query = vamDBquery("select count(*) as total from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd where r.products_id = '".(int)$product->data['products_id']."' and r.reviews_rating = 1 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
$one_star = vam_db_fetch_array($one_star_query,true);
$one_star_count = $one_star['total'];

$module->assign('PRODUCTS_RATING_ONE', $one_star_count);
$module->assign('PRODUCTS_RATING_ONE_PERCENT', number_format(($one_star_count*100)/$rating_count));

$two_star_query = vamDBquery("select count(*) as total from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd where r.products_id = '".(int)$product->data['products_id']."' and r.reviews_rating = 2 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
$two_star = vam_db_fetch_array($two_star_query,true);
$two_star_count = $two_star['total'];

$module->assign('PRODUCTS_RATING_TWO', $two_star_count);
$module->assign('PRODUCTS_RATING_TWO_PERCENT', number_format(($two_star_count*100)/$rating_count));

$three_star_query = vamDBquery("select count(*) as total from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd where r.products_id = '".(int)$product->data['products_id']."' and r.reviews_rating = 3 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
$three_star = vam_db_fetch_array($three_star_query,true);
$three_star_count = $three_star['total'];

$module->assign('PRODUCTS_RATING_THREE', $three_star_count);
$module->assign('PRODUCTS_RATING_THREE_PERCENT', number_format(($three_star_count*100)/$rating_count));

$four_star_query = vamDBquery("select count(*) as total from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd where r.products_id = '".(int)$product->data['products_id']."' and r.reviews_rating = 4 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
$four_star = vam_db_fetch_array($four_star_query,true);
$four_star_count = $four_star['total'];

$module->assign('PRODUCTS_RATING_FOUR', $four_star_count);
$module->assign('PRODUCTS_RATING_FOUR_PERCENT', number_format(($four_star_count*100)/$rating_count));

$five_star_query = vamDBquery("select count(*) as total from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd where r.products_id = '".(int)$product->data['products_id']."' and r.reviews_rating = 5 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
$five_star = vam_db_fetch_array($five_star_query,true);
$five_star_count = $five_star['total'];
		
$module->assign('PRODUCTS_RATING_FIVE', $five_star_count);
$module->assign('PRODUCTS_RATING_FIVE_PERCENT', number_format(($five_star_count*100)/$rating_count));
		
if ($_SESSION['customers_status']['customers_status_write_reviews'] != 0) {
	$module->assign('BUTTON_WRITE', '<a class="btn btn-inverse btn-block" href="'.vam_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, vam_product_link($product->data['products_id'],$product->data['products_name'])).'">'.vam_image_button('add.png', IMAGE_BUTTON_WRITE_REVIEW).'</a>');
}

	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $product->getReviews());
	
	$module->caching = 0;
	$module = $module->fetch(CURRENT_TEMPLATE.'/module/products_reviews.html');

if ($_SESSION['customers_status']['customers_status_read_reviews'] != 0) {
	$info->assign('MODULE_products_reviews', $module);
}

} else {

if ($_SESSION['customers_status']['customers_status_write_reviews'] != 0) {
	$module->assign('BUTTON_WRITE', '<a class="btn btn-inverse" href="'.vam_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, vam_product_link($product->data['products_id'],$product->data['products_name'])).'">'.vam_image_button('add.png', IMAGE_BUTTON_WRITE_REVIEW).'</a>');
}

	$module->assign('TEXT_FIRST_REVIEW', TEXT_FIRST_REVIEW);

	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $product->getReviews());
	$module->caching = 0;
	$module = $module->fetch(CURRENT_TEMPLATE.'/module/products_reviews.html');

if ($_SESSION['customers_status']['customers_status_read_reviews'] != 0) {
	$info->assign('MODULE_products_reviews', $module);
}

}
?>