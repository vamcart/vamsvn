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

// create smarty elements
$module_smarty = new Smarty;
$module_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
// include boxes
// include needed functions
require_once (DIR_FS_INC.'vam_row_number_format.inc.php');
require_once (DIR_FS_INC.'vam_date_short.inc.php');

$info_smarty->assign('options', $products_options_data);
if ($product->getReviewsCount() > 0) {


	$module_smarty->assign('BUTTON_WRITE', '<a href="'.vam_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, vam_product_link($product->data['products_id'],$product->data['products_name'])).'">'.vam_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW).'</a>');

	$module_smarty->assign('language', $_SESSION['language']);
	$module_smarty->assign('module_content', $product->getReviews());
	$module_smarty->caching = 0;
	$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/products_reviews.html');

	$info_smarty->assign('MODULE_products_reviews', $module);

} else {
	$module_smarty->assign('BUTTON_WRITE', '<a href="'.vam_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, vam_product_link($product->data['products_id'],$product->data['products_name'])).'">'.vam_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW).'</a>');
	$module_smarty->assign('TEXT_FIRST_REVIEW', TEXT_FIRST_REVIEW);

	$module_smarty->assign('language', $_SESSION['language']);
	$module_smarty->assign('module_content', $product->getReviews());
	$module_smarty->caching = 0;
	$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/products_reviews.html');

	$info_smarty->assign('MODULE_products_reviews', $module);
}
?>