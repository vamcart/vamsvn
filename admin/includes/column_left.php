<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'true') { ?>
<?php
/* --------------------------------------------------------------
   $Id: column_left.php 1231 2007-02-08 12:09:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(column_left.php,v 1.15 2002/01/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (column_left.php,v 1.25 2003/08/19); www.nextcommerce.org
   (c) 2004	 xt:Commerce (column_left.php,v 1.25 2003/08/19); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  $admin_access_query = vam_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . $_SESSION['customer_id'] . "'");
  $admin_access = vam_db_fetch_array($admin_access_query); 

  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_CUSTOMERS.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customers'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CUSTOMERS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CUSTOMERS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customers_status'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CUSTOMERS_STATUS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CUSTOMERS_STATUS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['orders'] == '1')) echo '<a href="' . vam_href_link(FILENAME_ORDERS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_ORDERS . '</a><br>';
  
  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_MARKETING.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['specials'] == '1')) echo '<a href="' . vam_href_link(FILENAME_SPECIALS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_SPECIALS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['category_specials'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . TEXT_CATEGORY_DISCOUNT . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['manufacturer_specials'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MANUFACTURER_SPECIALS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . TEXT_MANUFACTURER_DISCOUNT . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['featured'] == '1')) echo '<a href="' . vam_href_link(FILENAME_FEATURED, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_FEATURED . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal&module=ot_discountpayment', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_MERKETING_1 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal&module=ot_discountshipping', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_MERKETING_2 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal&module=ot_surcharge', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_MERKETING_3 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal&module=ot_surchargeshipping', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_MERKETING_4 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal&module=ot_lev_discount', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_MERKETING_5 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal&module=ot_discount_quant', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_MERKETING_6 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CUSTOMERS, 'cID=1&action=edit', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_MERKETING_7 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CUSTOMERS, 'cID=1&action=edit', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_MERKETING_8 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="http://manual.vamshop.ru/ch07.html#idp19112040" class="menuBoxContentLink"> -' . BOX_MERKETING_9 . '</a></dd>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="http://manual.vamshop.ru/ch07s02.html" class="menuBoxContentLink"> -' . BOX_MERKETING_10 . '</a></dd>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="http://manual.vamshop.ru/ch07s03.html" class="menuBoxContentLink"> -' . BOX_MERKETING_11 . '</a></dd>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="http://manual.vamshop.ru/ch07s04.html" class="menuBoxContentLink"> -' . BOX_MERKETING_12 . '</a></dd>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="http://manual.vamshop.ru/ch05s03.html#idp16858336" class="menuBoxContentLink"> -' . BOX_MERKETING_13 . '</a></dd>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="http://manual.vamshop.ru/ch09s02.html" class="menuBoxContentLink"> -' . BOX_MERKETING_14 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="http://manual.vamshop.ru/ch09.html" class="menuBoxContentLink"> -' . BOX_MERKETING_15 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="http://manual.vamshop.ru/ch10.html" class="menuBoxContentLink"> -' . BOX_MERKETING_16 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['module_newsletter'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MODULE_NEWSLETTER) . ' class="menuBoxContentLink"> -' . BOX_MODULE_NEWSLETTER . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['ship2pay'] == '1')) echo '<a href="' . vam_href_link(FILENAME_SHIP2PAY) . ' class="menuBoxContentLink"> -' . BOX_MODULES_SHIP2PAY . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['recover_cart_sales'] == '1')) echo '<a href="' . vam_href_link(FILENAME_RECOVER_CART_SALES) . ' class="menuBoxContentLink"> -' . BOX_TOOLS_RECOVER_CART . '</a><br>';

  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_PRODUCTS.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['categories'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CATEGORIES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CATEGORIES . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_options'] == '1')) echo '<a href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_PRODUCTS_OPTIONS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_attributes'] == '1')) echo '<a href="' . vam_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_PRODUCTS_ATTRIBUTES . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['new_attributes'] == '1')) echo '<a href="' . vam_href_link(FILENAME_NEW_ATTRIBUTES, '', 'NONSSL') . '" class="menuBoxContentLink"> -'.BOX_ATTRIBUTES_MANAGER.'</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['manufacturers'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MANUFACTURERS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_MANUFACTURERS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['reviews'] == '1')) echo '<a href="' . vam_href_link(FILENAME_REVIEWS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_REVIEWS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['company_reviews'] == '1')) echo '<a href="' . vam_href_link(FILENAME_COMPANY_REVIEWS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_COMPANY_REVIEWS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['article_reviews'] == '1')) echo '<a href="' . vam_href_link(FILENAME_ARTICLE_REVIEWS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_ARTICLE_REVIEWS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['author_reviews'] == '1')) echo '<a href="' . vam_href_link(FILENAME_AUTHOR_REVIEWS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_AUTHOR_REVIEWS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=16', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_16 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['manufacturer_specials'] == '1')) echo '<a href="' . vam_href_link(FILENAME_SPECIALS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_SPECIALS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['specials'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . TEXT_CATEGORY_DISCOUNT . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['category_specials'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MANUFACTURER_SPECIALS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . TEXT_MANUFACTURER_DISCOUNT . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['featured'] == '1')) echo '<a href="' . vam_href_link(FILENAME_FEATURED, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_FEATURED . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_specifications'] == '1')) echo '<a href="' . vam_href_link(FILENAME_PRODUCTS_SPECIFICATIONS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CATALOG_PRODUCTS_SPECIFICATIONS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['pin_loader'] == '1')) echo '<a href="' . vam_href_link(FILENAME_PIN_LOADER, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CATALOG_PIN_LOADER . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_expected'] == '1')) echo '<a href="' . vam_href_link(FILENAME_PRODUCTS_EXPECTED, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_PRODUCTS_EXPECTED . '</a><br>';

  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_MODULES.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MODULES, 'set=payment', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_PAYMENT . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MODULES, 'set=shipping', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_SHIPPING . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_ORDER_TOTAL . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['module_export'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MODULE_EXPORT) . '" class="menuBoxContentLink"> -' . BOX_MODULE_EXPORT . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['cip_manager'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CIP_MANAGER) . '" class="menuBoxContentLink"> -' . BOX_CONTRIBUTION_INSTALLER . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['ship2pay'] == '1')) echo '<a href="' . vam_href_link(FILENAME_SHIP2PAY) . '" class="menuBoxContentLink"> -' . BOX_MODULES_SHIP2PAY . '</a><br>';

  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_STATISTICS.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_products_viewed'] == '1')) echo '<a href="' . vam_href_link(FILENAME_STATS_PRODUCTS_VIEWED, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_PRODUCTS_VIEWED . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_products_purchased'] == '1')) echo '<a href="' . vam_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_PRODUCTS_PURCHASED . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_customers'] == '1')) echo '<a href="' . vam_href_link(FILENAME_STATS_CUSTOMERS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_STATS_CUSTOMERS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_sales_report'] == '1')) echo '<a href="' . vam_href_link(FILENAME_SALES_REPORT, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_SALES_REPORT . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_sales_report2'] == '1')) echo '<a href="' . vam_href_link(FILENAME_STATS_SALES_REPORT2, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_SALES_REPORT2 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_campaigns'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CAMPAIGNS_REPORT, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CAMPAIGNS_REPORT . '</a><br>';

  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_ARTICLES.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['articles'] == '1')) echo '<a href="' . vam_href_link(FILENAME_ARTICLES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_TOPICS_ARTICLES . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['articles_config'] == '1')) echo '<a href="' . vam_href_link(FILENAME_ARTICLES_CONFIG, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_ARTICLES_CONFIG . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['authors'] == '1')) echo '<a href="' . vam_href_link(FILENAME_AUTHORS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_ARTICLES_AUTHORS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['articles_xsell'] == '1')) echo '<a href="' . vam_href_link(FILENAME_ARTICLES_XSELL, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_ARTICLES_XSELL . '</a><br>';
  
  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_TOOLS.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['module_newsletter'] == '1')) echo '<a href="' . vam_href_link(FILENAME_MODULE_NEWSLETTER) . '" class="menuBoxContentLink"> -' . BOX_MODULE_NEWSLETTER . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['content_manager'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONTENT_MANAGER) . '" class="menuBoxContentLink"> -' . BOX_CONTENT . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['backup'] == '1')) echo '<a href="' . vam_href_link(FILENAME_BACKUP) . '" class="menuBoxContentLink"> -' . BOX_BACKUP . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['product_extra_fields'] == '1')) echo '<a href="' . vam_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS) . '" class="menuBoxContentLink"> -' . BOX_PRODUCT_EXTRA_FIELDS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customer_extra_fields'] == '1')) echo '<a href="' . vam_href_link(FILENAME_EXTRA_FIELDS) . '" class="menuBoxContentLink"> -' . BOX_HEADING_CUSTOMER_EXTRA_FIELDS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['banner_manager'] == '1')) echo '<a href="' . vam_href_link(FILENAME_BANNER_MANAGER) . '" class="menuBoxContentLink"> -' . BOX_BANNER_MANAGER . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['server_info'] == '1')) echo '<a href="' . vam_href_link(FILENAME_SERVER_INFO) . '" class="menuBoxContentLink"> -' . BOX_SERVER_INFO . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['whos_online'] == '1')) echo '<a href="' . vam_href_link(FILENAME_WHOS_ONLINE) . '" class="menuBoxContentLink"> -' . BOX_WHOS_ONLINE . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['easypopulate'] == '1')) echo '<a href="' . vam_href_link(FILENAME_EASYPOPULATE, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_EASY_POPULATE . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['yml_import'] == '1')) echo '<a href="' . vam_href_link(FILENAME_YML_IMPORT, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_YML_IMPORT . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['quick_updates'] == '1')) echo '<a href="' . vam_href_link(FILENAME_QUICK_UPDATES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CATALOG_QUICK_UPDATES . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['latest_news'] == '1')) echo '<a href="' . vam_href_link(FILENAME_LATEST_NEWS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CATALOG_LATEST_NEWS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['faq'] == '1')) echo '<a href="' . vam_href_link(FILENAME_FAQ, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CATALOG_FAQ . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['recover_cart_sales'] == '1')) echo '<a href="' . vam_href_link(FILENAME_RECOVER_CART_SALES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_TOOLS_RECOVER_CART . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['email_manager'] == '1')) echo '<a href="' . vam_href_link(FILENAME_EMAIL_MANAGER, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_TOOLS_EMAIL_MANAGER . '</a><br>';

if (ACTIVATE_GIFT_SYSTEM=='true') {
  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_GV_ADMIN.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['coupon_admin'] == '1')) echo '<a href="' . vam_href_link(FILENAME_COUPON_ADMIN, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_COUPON_ADMIN . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_queue'] == '1')) echo '<a href="' . vam_href_link(FILENAME_GV_QUEUE, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_GV_ADMIN_QUEUE . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_mail'] == '1')) echo '<a href="' . vam_href_link(FILENAME_GV_MAIL, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_GV_ADMIN_MAIL . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_sent'] == '1')) echo '<a href="' . vam_href_link(FILENAME_GV_SENT, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_GV_ADMIN_SENT . '</a><br>';
  }

  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_ZONE.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['languages'] == '1')) echo '<a href="' . vam_href_link(FILENAME_LANGUAGES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_LANGUAGES . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['countries'] == '1')) echo '<a href="' . vam_href_link(FILENAME_COUNTRIES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_COUNTRIES . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['currencies'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CURRENCIES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CURRENCIES. '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['zones'] == '1')) echo '<a href="' . vam_href_link(FILENAME_ZONES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_ZONES . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['geo_zones'] == '1')) echo '<a href="' . vam_href_link(FILENAME_GEO_ZONES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_GEO_ZONES . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['tax_classes'] == '1')) echo '<a href="' . vam_href_link(FILENAME_TAX_CLASSES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_TAX_CLASSES . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['tax_rates'] == '1')) echo '<a href="' . vam_href_link(FILENAME_TAX_RATES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_TAX_RATES . '</a><br>';


  echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_CONFIGURATION.'</b></div>');
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=1', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_1 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=100', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_100 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=2', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_2 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=3', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_3 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=4', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_4 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=5', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_5 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=7', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_7 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=8', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_8 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=9', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_9 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=10', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_10 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=11', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_11 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['cache'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CACHE, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CACHE_FILES . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=12', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_12 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=13', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_13 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=14', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_14 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=15', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_15 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=16', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_16 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=17', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_17 . '</a><br>';
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=18', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_18 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=19', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_19 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=22', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_22 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=23', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_23 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=24', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_24 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=25', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_25 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=27', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_27 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=72', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_72 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=80', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_80 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=1610', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_1610 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=90', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_90 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=29', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CONFIGURATION_29 . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['orders_status'] == '1')) echo '<a href="' . vam_href_link(FILENAME_ORDERS_STATUS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_ORDERS_STATUS . '</a><br>';
  if (ACTIVATE_SHIPPING_STATUS=='true') {
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['shipping_status'] == '1')) echo '<a href="' . vam_href_link(FILENAME_SHIPPING_STATUS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_SHIPPING_STATUS . '</a><br>';
  }
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_vpe'] == '1')) echo '<a href="' . vam_href_link(FILENAME_PRODUCTS_VPE, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_PRODUCTS_VPE . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['campaigns'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CAMPAIGNS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_CAMPAIGNS . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['cross_sell_groups'] == '1')) echo '<a href="' . vam_href_link(FILENAME_XSELL_GROUPS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_ORDERS_XSELL_GROUP . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['answer_templates'] == '1')) echo '<a href="' . vam_href_link(FILENAME_ANSWER_TEMPLATES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_ANSWER_TEMPLATES . '</a><br>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['product_labels'] == '1')) echo '<a href="' . vam_href_link(FILENAME_PRODUCT_LABELS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_PRODUCT_LABELS . '</a><br>';

  require(DIR_WS_INCLUDES . 'affiliate_column_left.php');
 
?>
<?php } ?>