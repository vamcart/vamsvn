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
if ($product->getReviewsCount() > 0) {

if ($_SESSION['customers_status']['customers_status_write_reviews'] != 0) {
	$module->assign('BUTTON_WRITE', '<a class="button" href="'.vam_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, vam_product_link($product->data['products_id'],$product->data['products_name'])).'">'.vam_image_button('add.png', IMAGE_BUTTON_WRITE_REVIEW).'</a>');
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
	$module->assign('BUTTON_WRITE', '<a class="button" href="'.vam_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, vam_product_link($product->data['products_id'],$product->data['products_name'])).'">'.vam_image_button('add.png', IMAGE_BUTTON_WRITE_REVIEW).'</a>');
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