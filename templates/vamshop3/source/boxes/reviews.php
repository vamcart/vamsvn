<?php
/* -----------------------------------------------------------------------------------------
   $Id: reviews.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(reviews.php,v 1.36 2003/02/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (reviews.php,v 1.9 2003/08/17 22:40:08); www.nextcommerce.org
   (c) 2004	 xt:Commerce (reviews.php,v 1.9 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
$box = new vamTemplate;
$box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/'); 
$box_content='';
  // include needed functions
  require_once(DIR_FS_INC . 'vam_random_select.inc.php');
  require_once(DIR_FS_INC . 'vam_break_string.inc.php');

      //fsk18 lock
  $fsk_lock='';
  if ($_SESSION['customers_status']['customers_fsk18_display']=='0') {
  $fsk_lock=' and p.products_fsk18!=1';
  }
  $random_select = "select r.reviews_id, r.reviews_rating, p.products_id, p.products_image, pd.products_name from " . TABLE_REVIEWS . " r, " . TABLE_REVIEWS_DESCRIPTION . " rd, " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = r.products_id ".$fsk_lock." and r.reviews_id = rd.reviews_id and rd.languages_id = '" . (int)$_SESSION['languages_id'] . "' and p.products_id = pd.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'";
  if ($product->isProduct()) {
    $random_select .= " and p.products_id = '" . $product->data['products_id'] . "'";
  }
  $random_select .= " order by r.reviews_id desc limit " . MAX_RANDOM_SELECT_REVIEWS;
  $random_product = vam_random_select($random_select);


  if ($random_product) {
    // display random review box
    $review_query = "select substring(reviews_text, 1, 60) as reviews_text from " . TABLE_REVIEWS_DESCRIPTION . " where reviews_id = '" . $random_product['reviews_id'] . "' and languages_id = '" . $_SESSION['languages_id'] . "'";
    $review_query = vamDBquery($review_query);
    $review = vam_db_fetch_array($review_query,true);

    $review = htmlspecialchars($review['reviews_text']);
    $review = vam_break_string($review, 15, '-<br />');

$products_image = DIR_WS_THUMBNAIL_IMAGES . $random_product['products_image'];
if (!file_exists($products_image)) $products_image = DIR_WS_THUMBNAIL_IMAGES.'../noimage.gif';

$box_content = '<p><a href="' . vam_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $random_product['products_id'] . '&reviews_id=' . $random_product['reviews_id']) . '">' . vam_image($products_image, $random_product['products_name']) . '</a></p><a href="' . vam_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $random_product['products_id'] . '&reviews_id=' . $random_product['reviews_id']) . '">' . $review . ' ..</a><p>' . vam_image('templates/' . CURRENT_TEMPLATE . '/img/stars_' . $random_product['reviews_rating'] . '.gif' , sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, $random_product['reviews_rating'])) . '</p>';

  } elseif ($product->isProduct()) {
    // display 'write a review' box
    $box_content = '<p><a href="' . vam_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, vam_product_link($product->data['products_id'],$product->data['products_name'])) . '">' . vam_image('templates/' . CURRENT_TEMPLATE . '/img/box_write_review.gif', IMAGE_BUTTON_WRITE_REVIEW) . '</a></p><p><a href="' . vam_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, vam_product_link($product->data['products_id'],$product->data['products_name'])) . '">' . BOX_REVIEWS_WRITE_REVIEW .'</a></p>';
   }

  if ($box_content!='') {
  $box->assign('REVIEWS_LINK',vam_href_link(FILENAME_REVIEWS)); 
  $box->assign('BOX_CONTENT', $box_content);
  $box->assign('language', $_SESSION['language']);
  // set cache ID
 if (!CacheCheck()) {
  $box->caching = 0;
  $box_reviews= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_reviews.html');
  } else {
  $box->caching = 1;
  $box->cache_lifetime=CACHE_LIFETIME;
  $box->cache_modified_check=CACHE_CHECK;
  (!isset($random_product['reviews_id'])) ? $random_product['reviews_id'] = 0 : $random_product['reviews_id'];
  $cache_id = $_SESSION['language'].$random_product['reviews_id'].$product->data['products_id'].$_SESSION['language'];
  $box_reviews= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_reviews.html',$cache_id);
  }
  $vamTemplate->assign('box_REVIEWS',$box_reviews);

  } 

?>