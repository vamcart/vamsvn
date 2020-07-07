<?php
/* -----------------------------------------------------------------------------------------
   $Id: boxes.php 1298 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2004	 xt:Commerce (boxes.php,v 1.4 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('DIR_WS_BOXES',DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes/');

  if (SET_BOX_FILTERS == 'true') if (!strstr($PHP_SELF, FILENAME_PRODUCTS_FILTER)) if ($current_category_id > 0)  include(DIR_WS_BOXES . 'products_filter.php');

  if (SET_BOX_AFFILIATE == 'true') include(DIR_WS_BOXES . 'affiliate.php');
  if (SET_BOX_CATEGORIES == 'true' && DEFAULT_NAVIGATION == "fullscreen_menu") include(DIR_WS_BOXES . 'categories.php');
  require(DIR_WS_BOXES . 'categories2.php');
  if (DEFAULT_NAVIGATION == 'slide_menu') require(DIR_WS_BOXES . 'categories3.php');
  if (SET_BOX_AUTHORS == 'true') include(DIR_WS_BOXES . 'authors.php');
  if (SET_BOX_ARTICLES == 'true') include(DIR_WS_BOXES . 'articles.php');
  if (SET_BOX_ARTICLESNEW == 'true') include(DIR_WS_BOXES . 'articles_new.php');
  include(DIR_WS_BOXES . 'articles_new_dropdown.php');
  if (SET_BOX_MANUFACTURERS == 'true') include(DIR_WS_BOXES . 'manufacturers.php');
  if ($_SESSION['customers_status']['customers_status_show_price']!='0') {
  if (SET_BOX_ADD_QUICKIE == 'true') require(DIR_WS_BOXES . 'add_a_quickie.php');
  }
  if (SET_BOX_LAST_VIEWED == 'true') require(DIR_WS_BOXES . 'last_viewed.php');
   if (substr(basename($PHP_SELF), 0,8) != 'advanced') { if (SET_BOX_WHATSNEW == 'true') require(DIR_WS_BOXES . 'whats_new.php'); }
  if (SET_BOX_SEARCH == 'true') require(DIR_WS_BOXES . 'search.php');
  if (SET_BOX_CONTENT == 'true') require(DIR_WS_BOXES . 'content.php');
  require(DIR_WS_BOXES . 'content_pull.php');
  if (SET_BOX_INFORMATION == 'true') require(DIR_WS_BOXES . 'information.php');
  if (SET_BOX_LATESTNEWS == 'true') include(DIR_WS_BOXES . 'news.php');
  include(DIR_WS_BOXES . 'news_dropdown.php');
  if (SET_BOX_FAQ == 'true') include(DIR_WS_BOXES . 'faq.php');
  if (SET_BOX_LANGUAGES == 'true') include(DIR_WS_BOXES . 'languages.php');
  if ($_SESSION['customers_status']['customers_status_id'] == 0) { if (SET_BOX_ADMIN == 'true') include(DIR_WS_BOXES . 'admin.php'); }
  if (SET_BOX_INFOBOX == 'true') require(DIR_WS_BOXES . 'infobox.php');
  if (SET_BOX_LOGIN == 'true') require(DIR_WS_BOXES . 'loginbox.php');
  if (SET_BOX_NEWSLETTER == 'true')  include(DIR_WS_BOXES . 'newsletter.php');
  if ($_SESSION['customers_status']['customers_status_show_price'] == 1) { if (SET_BOX_CART == 'true') include(DIR_WS_BOXES . 'shopping_cart.php'); }
  if ($product->isProduct()) { if (SET_BOX_MANUFACTURERS_INFO == 'true') include(DIR_WS_BOXES . 'manufacturer_info.php'); }

  if (isset($_SESSION['customer_id'])) { include(DIR_WS_BOXES . 'order_history.php'); }

  if (!$product->isProduct()) {
    if (SET_BOX_BESTSELLERS == 'true') include(DIR_WS_BOXES . 'best_sellers.php');
  }

  if (!$product->isProduct()) {
    if (SET_BOX_SPECIALS == 'true') include(DIR_WS_BOXES . 'specials.php');
  }

  if (!$product->isProduct()) {
    if (SET_BOX_FEATURED == 'true') include(DIR_WS_BOXES . 'featured.php');
  }

  if ($_SESSION['customers_status']['customers_status_read_reviews'] == 1) { if (SET_BOX_REVIEWS == 'true') require(DIR_WS_BOXES . 'reviews.php'); }

  if (substr(basename($PHP_SELF), 0, 8) != 'checkout') {

    if (SET_BOX_CURRENCIES == 'true') include(DIR_WS_BOXES . 'currencies.php');
  }

  if (SET_BOX_DOWNLOADS == 'true') include(DIR_WS_BOXES . 'download.php');

$vamTemplate->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
?>