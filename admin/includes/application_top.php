<?php
/* --------------------------------------------------------------
   $Id: application_top.php 1323 2007-02-08 12:09:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_top.php,v 1.158 2003/03/22); www.oscommerce.com
   (c) 2003	 nextcommerce (application_top.php,v 1.46 2003/08/24); www.nextcommerce.org 
   (c) 2004	 xt:Commerce (application_top.php,v 1.46 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------
   Third Party contribution:

   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  header('Content-Type: text/html; charset=utf-8');

  // Start the clock for the page parse time log
  define('PAGE_PARSE_START_TIME', microtime());

  define('CFG_TIME_ZONE', 'Europe/Moscow');
    
  // security
  define('_VALID_VAM',true);

  // set the level of error reporting
  error_reporting(0);
  //ini_set('display_errors',1);
  //error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

  // Disable use_trans_sid as vam_href_link() does this manually
  if (function_exists('ini_set')) {
    ini_set('session.use_trans_sid', 0);
  }

  // Set the local configuration parameters - mainly for developers or the main-configure
  if (file_exists('includes/local/configure.php')) {
    include('includes/local/configure.php');
  } else {
    require('includes/configure.php');
  }

  define('SQL_CACHEDIR',DIR_FS_CATALOG.'cache/');

  // Define the project version
  define('PROJECT_VERSION', 'VamShop 1.99.25');

  // Set the length of the redeem code, the longer the more secure
  define('SECURITY_CODE_LENGTH', '6');

  // Used in the "Backup Manager" to compress backups
  define('LOCAL_EXE_GZIP', '/usr/bin/gzip');
  define('LOCAL_EXE_GUNZIP', '/usr/bin/gunzip');
  define('LOCAL_EXE_ZIP', '/usr/local/bin/zip');
  define('LOCAL_EXE_UNZIP', '/usr/local/bin/unzip');

  // define the filenames used in the project
  define('FILENAME_ACCOUNTING', 'accounting.php');
  define('FILENAME_BACKUP', 'backup.php');
  define('FILENAME_BANNER_MANAGER', 'banner_manager.php');
  define('FILENAME_BANNER_STATISTICS', 'banner_statistics.php');
  define('FILENAME_CACHE', 'cache.php');
  define('FILENAME_CAMPAIGNS', 'campaigns.php');
  define('FILENAME_CATALOG_ACCOUNT_HISTORY_INFO', 'account_history_info.php');
  define('FILENAME_CATALOG_NEWSLETTER', 'newsletter.php');
  define('FILENAME_CATEGORIES', 'categories.php');
  define('FILENAME_CONFIGURATION', 'configuration.php');
  define('FILENAME_COUNTRIES', 'countries.php');
  define('FILENAME_CURRENCIES', 'currencies.php');
  define('FILENAME_CUSTOMERS', 'customers.php');
  define('FILENAME_CUSTOMERS_STATUS', 'customers_status.php');
  define('FILENAME_DEFAULT', 'start.php');
  define('FILENAME_DEFINE_LANGUAGE', 'define_language.php');
  define('FILENAME_FORMS', 'forms.php');
  define('FILENAME_FORM_VALUES', 'form_values.php');
  define('FILENAME_GEO_ZONES', 'geo_zones.php');
  define('FILENAME_LANGUAGES', 'languages.php');
  define('FILENAME_MAIL', 'mail.php');
  define('FILENAME_MANUFACTURERS', 'manufacturers.php');
  define('FILENAME_MODULES', 'modules.php');
  define('FILENAME_ORDERS', 'orders.php');
  define('FILENAME_ORDERS_INVOICE', 'invoice.php');
  define('FILENAME_ORDERS_PACKINGSLIP', 'packingslip.php');
  define('FILENAME_ORDERS_STATUS', 'orders_status.php');
  define('FILENAME_POPUP_IMAGE', 'popup_image.php');
  define('FILENAME_PRODUCTS_ATTRIBUTES', 'products_attributes.php');
  define('FILENAME_PRODUCTS_EXPECTED', 'products_expected.php');
  define('FILENAME_REVIEWS', 'reviews.php');
  define('FILENAME_SERVER_INFO', 'server_info.php');
  define('FILENAME_SHIPPING_MODULES', 'shipping_modules.php');
  define('FILENAME_SPECIALS', 'specials.php');
  define('FILENAME_STATS_CUSTOMERS', 'stats_customers.php');
  define('FILENAME_STATS_PRODUCTS_PURCHASED', 'stats_products_purchased.php');
  define('FILENAME_STATS_PRODUCTS_VIEWED', 'stats_products_viewed.php');
  define('FILENAME_TAX_CLASSES', 'tax_classes.php');
  define('FILENAME_TAX_RATES', 'tax_rates.php');
  define('FILENAME_WHOS_ONLINE', 'whos_online.php');
  define('FILENAME_ZONES', 'zones.php');
  define('FILENAME_START', 'start.php');
  define('FILENAME_STATS_STOCK_WARNING', 'stats_stock_warning.php');
  define('FILENAME_TPL_BOXES','templates_boxes.php');
  define('FILENAME_TPL_MODULES','templates_modules.php');
  define('FILENAME_NEW_ATTRIBUTES','new_attributes.php');
  define('FILENAME_LOGOUT','../logoff.php');
  define('FILENAME_LOGIN','../login.php');
  define('FILENAME_CREATE_ACCOUNT','create_account.php');
  define('FILENAME_CREATE_ACCOUNT_SUCCESS','create_account_success.php');
  define('FILENAME_CUSTOMER_MEMO','customer_memo.php');
  define('FILENAME_CUSTOMER_TO_MANUFACTURER_DISCOUNT','customer_to_manufacturer_discount.php');
  define('FILENAME_CONTENT_MANAGER','content_manager.php');
  define('FILENAME_CONTENT_PREVIEW','content_preview.php');
  define('FILENAME_SECURITY_CHECK','security_check.php');
  define('FILENAME_PRINT_ORDER','print_order.php');
  define('FILENAME_PRINT_PACKINGSLIP','print_packingslip.php');
  define('FILENAME_MODULE_NEWSLETTER','module_newsletter.php');
  define('FILENAME_GV_QUEUE', 'gv_queue.php');
  define('FILENAME_GV_MAIL', 'gv_mail.php');
  define('FILENAME_GV_SENT', 'gv_sent.php');
  define('FILENAME_COUPON_ADMIN', 'coupon_admin.php');
  define('FILENAME_POPUP_MEMO', 'popup_memo.php');
  define('FILENAME_SHIPPING_STATUS', 'shipping_status.php');
  define('FILENAME_SALES_REPORT','stats_sales_report.php');
  define('FILENAME_MODULE_EXPORT','module_export.php');
  define('FILENAME_EASY_POPULATE','easypopulate.php');
  define('FILENAME_QUICK_UPDATES', 'quick_updates.php');
  define('FILENAME_BLACKLIST', 'blacklist.php');
  define('FILENAME_PRODUCTS_VPE','products_vpe.php');
  define('FILENAME_CAMPAIGNS_REPORT','stats_campaigns.php');
  define('FILENAME_XSELL_GROUPS','cross_sell_groups.php');
  define('FILENAME_CSV_BACKEND','csv_backend.php');
  define('FILENAME_EASYPOPULATE', 'easypopulate.php');
  define('FILENAME_LATEST_NEWS', 'latest_news.php');
  define('FILENAME_RECOVER_CART_SALES', 'recover_cart_sales.php');
  define('FILENAME_FEATURED', 'featured.php');
  define('FILENAME_CACHE', 'cache.php');
  define('CONTENT_CIP_MANAGER','cip_manager');
  define('FILENAME_CIP_MANAGER',CONTENT_CIP_MANAGER.'.php');

  // define the database table names used in the project
  define('TABLE_ADDRESS_BOOK', 'address_book');
  define('TABLE_ADDRESS_FORMAT', 'address_format');
  define('TABLE_ADMIN_ACCESS', 'admin_access');
  define('TABLE_BANNERS', 'banners');
  define('TABLE_BANNERS_HISTORY', 'banners_history');
  define('TABLE_CAMPAIGNS', 'campaigns');
  define('TABLE_CATEGORIES', 'categories');
  define('TABLE_CATEGORIES_DESCRIPTION', 'categories_description');
  define('TABLE_CONFIGURATION', 'configuration');
  define('TABLE_CONFIGURATION_GROUP', 'configuration_group');
  define('TABLE_TPL_MODULES_CONFIGURATION', 'tpl_modules_configuration ');
  define('TABLE_COUNTRIES', 'countries');
  define('TABLE_CURRENCIES', 'currencies');
  define('TABLE_CUSTOMERS', 'customers');
  define('TABLE_CUSTOMERS_BASKET', 'customers_basket');
  define('TABLE_CUSTOMERS_BASKET_ATTRIBUTES', 'customers_basket_attributes');
  define('TABLE_CUSTOMERS_WISHLIST', 'customers_wishlist');
  define('TABLE_CUSTOMERS_WISHLIST_ATTRIBUTES', 'customers_wishlist_attributes');
  define('TABLE_CUSTOMERS_INFO', 'customers_info');
  define('TABLE_CUSTOMERS_IP', 'customers_ip');
  define('TABLE_CUSTOMERS_STATUS', 'customers_status');
  define('TABLE_CUSTOMERS_STATUS_HISTORY', 'customers_status_history');
  define('TABLE_FORMS', 'forms');
  define('TABLE_LANGUAGES', 'languages');
  define('TABLE_MANUFACTURERS', 'manufacturers');
  define('TABLE_MANUFACTURERS_INFO', 'manufacturers_info');
  define('TABLE_NEWSLETTERS', 'newsletters');
  define('TABLE_NEWSLETTERS_HISTORY', 'newsletters_history');
  define('TABLE_NEWSLETTER_RECIPIENTS', 'newsletter_recipients');
  define('TABLE_ORDERS', 'orders');
  define('TABLE_ORDERS_PRODUCTS', 'orders_products');
  define('TABLE_ORDERS_PRODUCTS_ATTRIBUTES', 'orders_products_attributes');
  define('TABLE_ORDERS_PRODUCTS_DOWNLOAD', 'orders_products_download');
  define('TABLE_ORDERS_STATUS', 'orders_status');
  define('TABLE_ORDERS_STATUS_HISTORY', 'orders_status_history');
  define('TABLE_ORDERS_TOTAL', 'orders_total');
  define('TABLE_ORDERS_RECALCULATE', 'orders_recalculate');
  define('TABLE_PERSONAL_OFFERS_BY','personal_offers_by_customers_status_');
  define('TABLE_PRODUCTS', 'products');
  define('TABLE_PRODUCTS_ATTRIBUTES', 'products_attributes');
  define('TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD', 'products_attributes_download');
  define('TABLE_PRODUCTS_CONTENT','products_content');
  define('TABLE_PRODUCTS_DESCRIPTION', 'products_description');
  define('TABLE_PRODUCTS_NOTIFICATIONS', 'products_notifications');
  define('TABLE_PRODUCTS_IMAGES', 'products_images');
  define('TABLE_PRODUCTS_OPTIONS', 'products_options');
  define('TABLE_PRODUCTS_OPTIONS_VALUES', 'products_options_values');
  define('TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS', 'products_options_values_to_products_options');
  define('TABLE_PRODUCTS_TO_CATEGORIES', 'products_to_categories');
  define('TABLE_PRODUCTS_VPE','products_vpe');
  define('TABLE_PRODUCTS_XSELL','products_xsell');
  define('TABLE_PRODUCTS_XSELL_GROUPS','products_xsell_grp_name');
  define('TABLE_REVIEWS', 'reviews');
  define('TABLE_REVIEWS_DESCRIPTION', 'reviews_description');
  define('TABLE_SESSIONS', 'sessions');
  define('TABLE_SPECIALS', 'specials');
  define('TABLE_TAX_CLASS', 'tax_class');
  define('TABLE_TAX_RATES', 'tax_rates');
  define('TABLE_TPL_MODULES_CONFIGURATION', 'tpl_modules_configuration');
  define('TABLE_GEO_ZONES', 'geo_zones');
  define('TABLE_ZONES_TO_GEO_ZONES', 'zones_to_geo_zones');
  define('TABLE_WHOS_ONLINE', 'whos_online');
  define('TABLE_ZONES', 'zones');
  define('TABLE_BOX_ALIGN','box_align');
  define('TABLE_CUSTOMERS_MEMO','customers_memo');
  define('TABLE_CUSTOMERS_TO_MANUFACTURERS_DISCOUNT','customers_to_manufacturers_discount');
  define('TABLE_CONTENT_MANAGER','content_manager');
  define('TABLE_MEDIA_CONTENT','media_content');
  define('TABLE_MODULE_NEWSLETTER','module_newsletter');
  define('TABLE_CM_FILE_FLAGS', 'cm_file_flags');
  define('TABLE_COUPON_GV_QUEUE', 'coupon_gv_queue');
  define('TABLE_COUPON_GV_CUSTOMER', 'coupon_gv_customer');
  define('TABLE_COUPON_EMAIL_TRACK', 'coupon_email_track');
  define('TABLE_COUPON_REDEEM_TRACK', 'coupon_redeem_track');
  define('TABLE_COUPONS', 'coupons');
  define('TABLE_COUPONS_DESCRIPTION', 'coupons_description');
  define('TABLE_SERVER_TRACKING', 'server_tracking');
  define('TABLE_SHIPPING_STATUS', 'shipping_status');
  define('TABLE_BLACKLIST', 'card_blacklist'); 
  define('TABLE_CAMPAIGNS_IP','campaigns_ip');
  define('TABLE_LATEST_NEWS', 'latest_news');
  define('TABLE_SCART', 'scart');
  define('TABLE_FEATURED', 'featured');
  define('TABLE_CIP_DEPEND', 'cip_depend');
  define('TABLE_CIP', 'cip');
  define('TABLE_CUSTOMERS_STATUS_ORDERS_STATUS', 'customers_status_orders_status');
  define('TABLE_MONEYBOOKERS','payment_moneybookers');
  define('TABLE_MONEYBOOKERS_COUNTRIES','payment_moneybookers_countries');
  define('TABLE_MONEYBOOKERS_CURRENCIES','payment_moneybookers_currencies');
  define('TABLE_BANKTRANSFER','banktransfer');
  define('TABLE_NEWSLETTER_TEMP','module_newsletter_temp_');
  define('TABLE_PERSONAL_OFFERS','personal_offers_by_customers_status_');
  define('TABLE_CIP_FILE_INTEGRITY','contrib_installer_files_integrity');
  define('TABLE_COMPANIES','companies');
  define('TABLE_PERSONS','persons');

  // include needed functions

  //UTF8 functions
  require_once (DIR_FS_INC.'vam_mb_utf8.inc.php');

  require_once(DIR_FS_INC . 'vam_db_connect.inc.php');
  require_once(DIR_FS_INC . 'vam_db_close.inc.php');
  require_once(DIR_FS_INC . 'vam_db_error.inc.php');
  require_once(DIR_FS_INC . 'vam_db_query.inc.php');
  require_once(DIR_FS_INC . 'vam_db_queryCached.inc.php');
  require_once(DIR_FS_INC . 'vam_db_perform.inc.php');
  require_once(DIR_FS_INC . 'vam_db_fetch_array.inc.php');
  require_once(DIR_FS_INC . 'vam_db_num_rows.inc.php');
  require_once(DIR_FS_INC . 'vam_db_data_seek.inc.php');
  require_once(DIR_FS_INC . 'vam_db_insert_id.inc.php');
  require_once(DIR_FS_INC . 'vam_db_free_result.inc.php');
  require_once(DIR_FS_INC . 'vam_db_fetch_fields.inc.php');
  require_once(DIR_FS_INC . 'vam_db_output.inc.php');
  require_once(DIR_FS_INC . 'vam_db_input.inc.php');
  require_once(DIR_FS_INC . 'vam_db_prepare_input.inc.php');
  require_once(DIR_FS_INC . 'vam_get_ip_address.inc.php');
  require_once(DIR_FS_INC . 'vam_setcookie.inc.php');
  require_once(DIR_FS_INC . 'vam_validate_email.inc.php');
  require_once(DIR_FS_INC . 'vam_not_null.inc.php');
  require_once(DIR_FS_INC . 'vam_add_tax.inc.php');
  require_once(DIR_FS_INC . 'vam_get_tax_rate.inc.php');
  require_once(DIR_FS_INC . 'vam_get_qty.inc.php');
  require_once(DIR_FS_INC . 'vam_product_link.inc.php');
  require_once(DIR_FS_INC . 'vam_cleanName.inc.php');
  require_once(DIR_FS_INC . 'vam_make_alias.inc.php');
  require_once(DIR_FS_INC . 'vam_parse_input_field_data.inc.php');
  require_once (DIR_FS_INC.'vam_input_validation.inc.php');
  
  // customization for the design layout
if (ADMIN_DROP_DOWN_NAVIGATION == 'true') {  
  define('BOX_WIDTH', 125); // how wide the boxes should be in pixels (default: 125)
} else {
  define('BOX_WIDTH', 0); // how wide the boxes should be in pixels (default: 125)
}

  // Define how do we update currency exchange rates
  // Possible values are 'oanda' 'xe' or ''
  define('CURRENCY_SERVER_PRIMARY', 'cbr');
  define('CURRENCY_SERVER_BACKUP', 'xe');
  
  // include the database functions
//  require(DIR_WS_FUNCTIONS . 'database.php');

  // make a connection to the database... now
  vam_db_connect() or die('Unable to connect to database server!');

  // set application wide parameters
  $configuration_query = vam_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION . '');
  while ($configuration = vam_db_fetch_array($configuration_query)) {
    define($configuration['cfgKey'], $configuration['cfgValue']);
  }

require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.phpmailer.php');
if (EMAIL_TRANSPORT == 'smtp')
	require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.smtp.php');

  define('FILENAME_IMAGEMANIPULATOR',IMAGE_MANIPULATOR);
    function vamDBquery($query) {
       if (DB_CACHE=='true') {
             $result=vam_db_queryCached($query);
             //echo 'cached query: '.$query.'<br>';
          } else {
             $result=vam_db_query($query);
    }
    return $result;
  }


  // initialize the logger class
  require(DIR_WS_CLASSES . 'logger.php');

  // include shopping cart class
  require(DIR_WS_CLASSES . 'shopping_cart.php');

  // some code to solve compatibility issues
  require(DIR_WS_FUNCTIONS . 'compatibility.php');

  require(DIR_WS_FUNCTIONS . 'general.php');


  // define how the session functions will be used
  require(DIR_WS_FUNCTIONS . 'sessions.php');

    // define our general functions used application-wide
  require(DIR_WS_FUNCTIONS . 'html_output.php');

  // set the session name and save path
  session_name('sid');
  session_save_path(SESSION_WRITE_DIRECTORY);

  require_once (DIR_FS_INC.'vam_get_cookie_info.inc.php');  // get the session cookie parameters
  $cookie_info = vam_get_cookie_info();
  // set the session cookie parameters
  if (function_exists('session_set_cookie_params')) {
   	session_set_cookie_params(0, $cookie_info['cookie_path'], $cookie_info['cookie_domain']);
  }
  elseif (function_exists('ini_set')) {
   	ini_set('session.cookie_lifetime', '0');
   	ini_set('session.cookie_path', $cookie_info['cookie_path']);
   	ini_set('session.cookie_domain', $cookie_info['cookie_domain']);
  }
  // set the session ID if it exists
  if (isset($_POST[session_name()])) {
    session_id($_POST[session_name()]);
  } elseif ( ($request_type == 'SSL') && isset($_GET[session_name()]) ) {
    session_id($_GET[session_name()]);
  }

  // start the session
  $session_started = false;
  if (SESSION_FORCE_COOKIE_USE == 'True') {
	vam_setcookie('cookie_test', 'please_accept_for_session', time() + 60 * 60 * 24 * 30, 
	           $cookie_info['cookie_path'], $cookie_info['cookie_domain']);

    if (isset($_COOKIE['cookie_test'])) {
      session_start();
      $session_started = true;
    }
  } elseif (CHECK_CLIENT_AGENT == 'True') {
    $user_agent = strtolower(getenv('HTTP_USER_AGENT'));
    $spider_flag = false;

    if ($spider_flag == false) {
      session_start();
      $session_started = true;
    }
  } else {
    session_start();
    $session_started = true;
  }

  // verify the ssl_session_id if the feature is enabled
  if ( ($request_type == 'SSL') && (SESSION_CHECK_SSL_SESSION_ID == 'True') && (ENABLE_SSL == true) && ($session_started == true) ) {
    $ssl_session_id = getenv('SSL_SESSION_ID');
    if (!vam_session_is_registered('SSL_SESSION_ID')) {
      $_SESSION['SESSION_SSL_ID'] = $ssl_session_id;
    }

    if ($_SESSION['SESSION_SSL_ID'] != $ssl_session_id) {
      session_destroy();
      vam_redirect(vam_href_link(FILENAME_SSL_CHECK));
    }
  }

  // verify the browser user agent if the feature is enabled
if (SESSION_CHECK_USER_AGENT == 'True') {
	$http_user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	$http_user_agent2 = strtolower(getenv("HTTP_USER_AGENT"));
	$http_user_agent = ($http_user_agent == $http_user_agent2) ? $http_user_agent : $http_user_agent.';'.$http_user_agent2;
	if (!isset($_SESSION['SESSION_USER_AGENT'])) {
		$_SESSION['SESSION_USER_AGENT'] = $http_user_agent;
	}

	if ($_SESSION['SESSION_USER_AGENT'] != $http_user_agent) {
		session_destroy();
		vam_redirect(vam_href_link(FILENAME_LOGIN));
	} 
}


  // verify the IP address if the feature is enabled
  if (SESSION_CHECK_IP_ADDRESS == 'True') {
    $ip_address = vam_get_ip_address();
    if (!vam_session_is_registered('SESSION_IP_ADDRESS')) {
      $_SESSION['SESSION_IP_ADDRESS'] = $ip_address;
    }

    if ($_SESSION['SESSION_IP_ADDRESS'] != $ip_address) {
      session_destroy();
      vam_redirect(vam_href_link(FILENAME_LOGIN));
    }
  }

  // set the language
  if (!isset($_SESSION['language']) || isset($_GET['language']) || empty($language)) {

	include (DIR_WS_CLASSES.'language.php');
	$lng = new language(vam_input_validation($_GET['language'], 'char', ''));

	if (!isset ($_GET['language']))
		$lng = new language(DEFAULT_LANGUAGE);

    $_SESSION['language'] = $lng->language['directory'];
    $_SESSION['languages_id'] = $lng->language['id'];
  }

  // include the language translations
  require_once (DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/'.$_SESSION['language'] . '.php');
  require_once (DIR_WS_LANGUAGES.$_SESSION['language'].'/'.$_SESSION['language'].'.inc.php');
  require_once (DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/buttons.php');
  $current_page = preg_split('/\?/', basename($_SERVER['PHP_SELF'])); $current_page = $current_page[0]; // for BadBlue(Win32) webserver compatibility
  if (file_exists(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/'.$current_page)) {
    include(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/'.  $current_page);
  }

  // write customers status in session
  require('../' . DIR_WS_INCLUDES . 'write_customers_status.php');


  // for tracking of customers
  $_SESSION['user_info'] = array();
  if (!$_SESSION['user_info']['user_ip']) {
    $_SESSION['user_info']['user_ip'] = $_SERVER['REMOTE_ADDR'];
//    $user_info['user_ip_date'] =  value will be in fact added when login ;
    //$_SESSION['user_info']['user_host'] = gethostbyaddr( $_SERVER['REMOTE_ADDR'] );;
    $_SESSION['user_info']['advertiser'] = $_GET['ad'];
    $_SESSION['user_info']['referer_url'] = $_SERVER['HTTP_REFERER'];
  }


  // define our localization functions
  require(DIR_WS_FUNCTIONS . 'localization.php');

  // Include validation functions (right now only email address)
  //require(DIR_WS_FUNCTIONS . 'validations.php');

  // setup our boxes
  require(DIR_WS_CLASSES . 'table_block.php');
  require(DIR_WS_CLASSES . 'box.php');

  // initialize the message stack for output messages
  require(DIR_WS_CLASSES . 'message_stack.php');
  $messageStack = new messageStack;

  // split-page-results
  require(DIR_WS_CLASSES . 'split_page_results.php');

  // entry/item info classes
  require(DIR_WS_CLASSES . 'object_info.php');


  // file uploading class
  require(DIR_WS_CLASSES . 'upload.php');

  // calculate category path
  if (isset($_GET['cPath'])) {
    $cPath = $_GET['cPath'];
  } else {
    $cPath = '';
  }
  if (strlen($cPath) > 0) {
    $cPath_array = explode('_', $cPath);
    $current_category_id = $cPath_array[(sizeof($cPath_array)-1)];
  } else {
    $current_category_id = 0;
  }

  // default open navigation box
  if (!isset($_SESSION['selected_box'])) {
    $_SESSION['selected_box'] = 'configuration';
  }
  if (isset($_GET['selected_box'])) {
    $_SESSION['selected_box'] = $_GET['selected_box'];
  }

  // the following cache blocks are used in the Tools->Cache section
  // ('language' in the filename is automatically replaced by available languages)
  $cache_blocks = array(array('title' => TEXT_CACHE_CATEGORIES, 'code' => 'categories', 'file' => 'categories_box-language.cache', 'multiple' => true),
                        array('title' => TEXT_CACHE_MANUFACTURERS, 'code' => 'manufacturers', 'file' => 'manufacturers_box-language.cache', 'multiple' => true),
                        array('title' => TEXT_CACHE_ALSO_PURCHASED, 'code' => 'also_purchased', 'file' => 'also_purchased-language.cache', 'multiple' => true)
                       );

  // check if a default currency is set
  if (!defined('DEFAULT_CURRENCY')) {
    $messageStack->add(ERROR_NO_DEFAULT_CURRENCY_DEFINED, 'error');
  }

  // check if a default language is set
  if (!defined('DEFAULT_LANGUAGE')) {
    $messageStack->add(ERROR_NO_DEFAULT_LANGUAGE_DEFINED, 'error');
  }

  // for Customers Status
  vam_get_customers_statuses();



  $pagename = strtok($current_page, '.');
  if (!isset($_SESSION['customer_id'])) {
    vam_redirect(vam_href_link(FILENAME_LOGIN));
  }

  if (vam_check_permission($pagename) == '0') {
    vam_redirect(vam_href_link(FILENAME_LOGIN));
  }

  define('FILENAME_ARTICLES', 'articles.php');
  define('FILENAME_ARTICLES_CONFIG', 'articles_config.php');
  define('FILENAME_AUTHORS', 'authors.php');
  define('FILENAME_ARTICLES_XSELL', 'articles_xsell.php');

  define('TABLE_ARTICLES', 'articles');
  define('TABLE_ARTICLES_DESCRIPTION', 'articles_description');
  define('TABLE_ARTICLES_TO_TOPICS', 'articles_to_topics');
  define('TABLE_AUTHORS', 'authors');
  define('TABLE_AUTHORS_INFO', 'authors_info');
  define('TABLE_TOPICS', 'topics');
  define('TABLE_TOPICS_DESCRIPTION', 'topics_description');
  define('TABLE_ARTICLES_XSELL', 'articles_xsell');

// include the articles functions
  require(DIR_WS_FUNCTIONS . 'articles.php');

// Article Manager
  if (isset($_GET['tPath'])) {
    $tPath = $_GET['tPath'];
  } else {
    $tPath = '';
  }

  if (vam_not_null($tPath)) {
    $tPath_array = vam_parse_topic_path($tPath);
    $tPath = implode('_', $tPath_array);
    $current_topic_id = $tPath_array[(sizeof($tPath_array)-1)];
  } else {
    $current_topic_id = 0;
  }

    require('includes/local_modules.php');
    define('DIR_FS_CIP', DIR_FS_ADMIN . 'contributions');

require_once(DIR_FS_CATALOG.'includes/classes/vam_template.php');

define('FILENAME_STATS_SALES_REPORT2','stats_sales_report2.php');
define('FILENAME_EMAIL_MANAGER','email_manager.php');

  define('TABLE_SPECIAL_CATEGORY', 'special_category');
  define('TABLE_SPECIAL_MANUFACTURER', 'special_manufacturer');
  define('TABLE_SPECIAL_PRODUCT', 'special_product');
  define('FILENAME_CATEGORY_SPECIALS', 'category_specials.php');
  define('FILENAME_MANUFACTURER_SPECIALS', 'manufacturer_specials.php');

  define('FILENAME_PRODUCTS_OPTIONS', 'products_options.php');
  define('TABLE_PRODUCTS_OPTIONS_IMAGES','products_options_images');

define('FILENAME_SHIP2PAY', 'ship2pay.php');
define('TABLE_SHIP2PAY', 'ship2pay');

define('FILENAME_PRODUCTS_EXTRA_FIELDS', 'product_extra_fields.php'); 
define('TABLE_PRODUCTS_EXTRA_FIELDS', 'products_extra_fields'); 
define('TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS', 'products_to_products_extra_fields'); 

define('FILENAME_FAQ', 'faq.php');
define('TABLE_FAQ', 'faq');

require_once(DIR_WS_INCLUDES . 'affiliate_application_top.php');

  define('TABLE_EXTRA_FIELDS','extra_fields');
  define('TABLE_EXTRA_FIELDS_INFO','extra_fields_info');
  define('TABLE_CUSTOMERS_TO_EXTRA_FIELDS','customers_to_extra_fields');
  define('FILENAME_EXTRA_FIELDS','customer_extra_fields.php');

define('FILENAME_SELECT_FEATURED', 'select_featured.php'); 
define('FILENAME_SELECT_SPECIAL', 'select_special.php'); 

define('TABLE_SPSR_ZONES', 'spsr_zones');

  define('FILENAME_YML_IMPORT','yml_import.php');
  
define('FILENAME_CUSTOMERS_EXPORT', 'customer_export.php');
define('FILENAME_EXPORTORDERS', 'exportorders.php');

define('TABLE_PRODUCTS_PINS', 'products_pins');
define('FILENAME_PIN_LOADER', 'pin_loader.php');

// BOF: Added for Order_edit MOD
  define('FILENAME_CREATE_ACCOUNT', 'create_account.php');
  define('FILENAME_CREATE_ACCOUNT_PROCESS', 'create_account_process.php');
  define('FILENAME_CREATE_ACCOUNT_SUCCESS', 'create_account_success.php');
  define('FILENAME_CREATE_ORDER_PROCESS', 'create_order_process.php');
  define('FILENAME_CREATE_ORDER', 'create_order.php');
  define('FILENAME_EDIT_ORDERS', 'edit_orders.php');
  define('FILENAME_ORDERS_EDIT', 'edit_orders.php');
  define('FILENAME_ORDERS_EDIT_ADD_PRODUCT', 'edit_orders_add_product.php');
  define('FILENAME_ORDERS_EDIT_AJAX', 'edit_orders_ajax.php');
// EOF: Added for Order_edit MOD

// Start Product Specifications
  define('FILENAME_PRODUCTS_SPECIFICATIONS', 'products_specifications.php');
  define('FILENAME_PRODUCTS_SPECIFICATIONS_INPUT', 'products_specifications_input.php');
  define('FILENAME_PRODUCTS_TABS', 'products_tabs.php');

  define('TABLE_PRODUCTS_SPECIFICATIONS', 'products_specifications');
  define('TABLE_SPECIFICATION', 'specifications');
  define('TABLE_SPECIFICATION_DESCRIPTION', 'specification_description');
  define('TABLE_SPECIFICATION_GROUPS', 'specification_groups');
  define('TABLE_SPECIFICATIONS_FILTERS', 'specification_filters');
  define('TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION', 'specification_filters_description');
  define('TABLE_SPECIFICATIONS_TO_CATEGORIES', 'specification_groups_to_categories');
  define('TABLE_SPECIFICATIONS_VALUES', 'specification_values');
  define('TABLE_SPECIFICATIONS_VALUES_DESCRIPTION', 'specification_values_description');
// End Product Specifications
  
  define('FILENAME_ANSWER_TEMPLATES', 'answer_templates.php');
  define('TABLE_ANSWER_TEMPLATES', 'answer_templates');

  define('FILENAME_PRODUCT_LABELS', 'product_labels.php');
  define('TABLE_PRODUCT_LABELS', 'product_labels');

  define('FILENAME_ARTICLE_REVIEWS', 'article_reviews.php');

  define('TABLE_ARTICLE_REVIEWS', 'article_reviews');
  define('TABLE_ARTICLE_REVIEWS_DESCRIPTION', 'article_reviews_description');

  define('FILENAME_AUTHOR_REVIEWS', 'author_reviews.php');

  define('TABLE_AUTHOR_REVIEWS', 'author_reviews');
  define('TABLE_AUTHOR_REVIEWS_DESCRIPTION', 'author_reviews_description');

  define('FILENAME_COMPANY_REVIEWS', 'company_reviews.php');
  
  define('TABLE_COMPANY_REVIEWS', 'company_reviews');
  define('TABLE_COMPANY_REVIEWS_DESCRIPTION', 'company_reviews_description');

  define('FILENAME_REVIEWS_ADD', 'reviews_add.php');
  define('FILENAME_COMPANY_REVIEWS_ADD', 'company_reviews_add.php');
  define('FILENAME_AUTHOR_REVIEWS_ADD', 'author_reviews_add.php');
  define('FILENAME_ARTICLE_REVIEWS_ADD', 'article_reviews_add.php');

  define('FILENAME_SITE_REVIEWS', 'site_reviews.php');
  define('FILENAME_SITE_REVIEWS_ADD', 'site_reviews_add.php');

  define('TABLE_SITE_REVIEWS', 'site_reviews');
  define('TABLE_SITE_REVIEWS_DESCRIPTION', 'site_reviews_description');
  
// include composer autoload
  require(DIR_FS_CATALOG . '/vendor/autoload.php');

  define('TABLE_PRODUCTS_BUNDLES', 'products_bundles');

  define('TABLE_ARTICLES_TO_CATEGORIES', 'articles_to_categories');
  define('TABLE_ARTICLES_TO_PRODUCTS', 'articles_to_products');
  define('TABLE_FAQ_TO_CATEGORIES', 'faq_to_categories');
  define('TABLE_FAQ_TO_PRODUCTS', 'faq_to_products');
  define('TABLE_LATEST_NEWS_TO_CATEGORIES', 'latest_news_to_categories');
  define('TABLE_LATEST_NEWS_TO_PRODUCTS', 'latest_news_to_products');

  define('FILENAME_TAGS', 'tags.php');

  define('TABLE_TAGS', 'tags');
  define('TABLE_TAGS_TO_CATEGORIES', 'tags_to_categories');
  define('TABLE_TAGS_TO_PRODUCTS', 'tags_to_products');

  define('TABLE_REVIEWS_IMAGES', 'reviews_images');
  
  define('FILENAME_PRODUCTS_NEW', 'products_new.php');

  define('FILENAME_FAQ1', 'faq1.php');
  define('TABLE_FAQ1', 'faq1');

  define('FILENAME_ACCOUNT', 'account.php');
  define('FILENAME_ACCOUNT_HISTORY', 'account_history.php');
      
?>