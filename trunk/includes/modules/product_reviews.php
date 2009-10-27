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
// include boxes
// include needed functions
require_once (DIR_FS_INC.'vam_row_number_format.inc.php');
require_once (DIR_FS_INC.'vam_date_short.inc.php');

require_once (DIR_WS_CLASSES.'split_page_results_reviews.php');

if (!$_GET['type']) {
	$info->assign('options', $products_options_data);
}

if ($product->getReviewsCount() > 0) {

if ($_SESSION['customers_status']['customers_status_write_reviews'] != 0) {
	$module->assign('BUTTON_WRITE', '<a href="'.vam_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, vam_product_link($product->data['products_id'],$product->data['products_name'])).'">'.vam_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW).'</a>');
}
   
	$module->assign('language', $_SESSION['language']);
	//$module->assign('module_content', $product->getReviews());
	////////////////////////// kpoxas
	
	 	$data_reviews = array ();
		$reviews_query = "select
									                                 r.reviews_rating,
									                                 r.reviews_id,
									                                 r.customers_name,
									                                 r.date_added,
									                                 r.last_modified,
									                                 r.reviews_read,
									                                 rd.reviews_text
									                                 from ".TABLE_REVIEWS." r,
									                                 ".TABLE_REVIEWS_DESCRIPTION." rd
									                                 where r.products_id = '".$product->data['products_id']."'
									                                 and  r.reviews_id=rd.reviews_id
									                                 and rd.languages_id = '".$_SESSION['languages_id']."'
									                                 order by reviews_id DESC";
		
		$reviews_split = new splitPageResultsReviews($reviews_query, $_GET['page'], PRODUCT_REVIEWS_VIEW);
		
		if (($reviews_split->number_of_rows > 0)) {
			$module->assign('NAVIGATION_BAR', TEXT_RESULT_PAGE.' '.$reviews_split->display_links(PRODUCT_REVIEWS_VIEW, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
			$module->assign('NAVIGATION_BAR_PAGES', $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS));		   		
		}
		$module_content = '';
				
		    $reviews_query = vamDBquery($reviews_split->sql_query);
			$row = 0;
			$data_reviews = array ();
			while ($reviews = vam_db_fetch_array($reviews_query, true)) {
				$row ++;
				
				$data_reviews[] = array ('AUTHOR' => $reviews['customers_name'], 'DATE' => vam_date_short($reviews['date_added']), 'RATING' => vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.$reviews['reviews_rating'].'.gif', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])), 'TEXT' => vam_break_string(htmlspecialchars($reviews['reviews_text']), 60, '-<br />'));
				
			}			
		
	
	$module->assign('module_content', $data_reviews);
	///////////////////////
	$module->caching = 0;
	$module = $module->fetch(CURRENT_TEMPLATE.'/module/products_reviews.html');
	$reviews_ajax=$module;

if ($_SESSION['customers_status']['customers_status_read_reviews'] != 0 and !$_GET['type']) {
	$info->assign('MODULE_products_reviews', $module);
}

} else {

if ($_SESSION['customers_status']['customers_status_write_reviews'] != 0) {
	$module->assign('BUTTON_WRITE', '<a href="'.vam_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, vam_product_link($product->data['products_id'],$product->data['products_name'])).'">'.vam_image_button('button_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW).'</a>');
}

	$module->assign('TEXT_FIRST_REVIEW', TEXT_FIRST_REVIEW);
	$module->assign('language', $_SESSION['language']);
	$module->caching = 0;
	$module = $module->fetch(CURRENT_TEMPLATE.'/module/products_reviews.html');

if ($_SESSION['customers_status']['customers_status_read_reviews'] != 0 and !$_GET['type']) {
	$info->assign('MODULE_products_reviews', $module);
}

}

?>