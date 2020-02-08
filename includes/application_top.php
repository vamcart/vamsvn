<?php
/* -----------------------------------------------------------------------------------------
   $Id: application_top.php 1323 2007-02-06 20:14:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_top.php,v 1.273 2003/05/19); www.oscommerce.com
   (c) 2003	 nextcommerce (application_top.php,v 1.54 2003/08/25); www.nextcommerce.org
   (c) 2004	 xt:Commerce (application_top.php,v 1.54 2005-10-27); www.xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:
   Add A Quickie v1.0 Autor  Harald Ponce de Leon

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
header('Content-Type: text/html; charset=utf-8');   
   
// start the timer for the page parse time log
define('PAGE_PARSE_START_TIME', microtime());
define('DEBUG', false);

define('CFG_TIME_ZONE', 'Europe/Moscow');

define('RTN_404', '1');
define('RTN_410', '2');
define('RTN_GOOD', '100');

// set the level of error reporting
error_reporting(0);
//ini_set('display_errors',1);
//error_reporting(E_ALL);

// Set the local configuration parameters - mainly for developers - if exists else the mainconfigure
if (file_exists('includes/local/configure.php')) {
	include ('includes/local/configure.php');
} else {
	include ('includes/configure.php');
}

// Redirect to install if configure.php is empty
if (defined('DIR_WS_INCLUDES') === false) header('Location: install');

$php4_3_10 = (0 == version_compare(phpversion(), "4.3.10"));
define('PHP4_3_10', $php4_3_10);
// define the project version
define('PROJECT_VERSION', 'VamShop 1.99.12');

// set the type of request (secure or not)
$request_type = (getenv('HTTPS') == '1' || getenv('HTTPS') == 'on') ? 'SSL' : 'NONSSL';

// set php_self in the local scope
if (!isset($PHP_SELF)) $PHP_SELF = $_SERVER['PHP_SELF'];

// include the list of project filenames
require (DIR_WS_INCLUDES.'filenames.php');

// include the list of project database tables
require (DIR_WS_INCLUDES.'database_tables.php');

// SQL caching dir
define('SQL_CACHEDIR', DIR_FS_CATALOG.'cache/');

// Below are some defines which affect the way the discount coupon/gift voucher system work
// Be careful when editing them.
//
// Set the length of the redeem code, the longer the more secure
define('SECURITY_CODE_LENGTH', '10');
//
// The settings below determine whether a new customer receives an incentive when they first signup
//
// Set the amount of a Gift Voucher that the new signup will receive, set to 0 for none
//  define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT', '10');  // placed in the admin configuration mystore
//
// Set the coupon ID that will be sent by email to a new signup, if no id is set then no email :)
//  define('NEW_SIGNUP_DISCOUNT_COUPON', '3'); // placed in the admin configuration mystore

// graduated prices model or products assigned ?
define('GRADUATED_ASSIGN', 'true');

// include used functions

//UTF8 functions
require_once (DIR_FS_INC.'vam_mb_utf8.inc.php');

// Database
require_once (DIR_FS_INC.'vam_db_connect.inc.php');
require_once (DIR_FS_INC.'vam_db_close.inc.php');
require_once (DIR_FS_INC.'vam_db_error.inc.php');
require_once (DIR_FS_INC.'vam_db_perform.inc.php');
require_once (DIR_FS_INC.'vam_db_query.inc.php');
require_once (DIR_FS_INC.'vam_db_queryCached.inc.php');
require_once (DIR_FS_INC.'vam_db_fetch_array.inc.php');
require_once (DIR_FS_INC.'vam_db_num_rows.inc.php');
require_once (DIR_FS_INC.'vam_db_data_seek.inc.php');
require_once (DIR_FS_INC.'vam_db_insert_id.inc.php');
require_once (DIR_FS_INC.'vam_db_free_result.inc.php');
require_once (DIR_FS_INC.'vam_db_fetch_fields.inc.php');
require_once (DIR_FS_INC.'vam_db_output.inc.php');
require_once (DIR_FS_INC.'vam_db_input.inc.php');
require_once (DIR_FS_INC.'vam_db_prepare_input.inc.php');
require_once (DIR_FS_INC.'vam_get_top_level_domain.inc.php');
require_once (DIR_FS_INC.'vam_get_cookie_info.inc.php');

// html basics
require_once (DIR_FS_INC.'vam_href_link.inc.php');
require_once (DIR_FS_INC.'vam_draw_separator.inc.php');
require_once (DIR_FS_INC.'vam_php_mail.inc.php');

require_once (DIR_FS_INC.'vam_product_link.inc.php');
require_once (DIR_FS_INC.'vam_category_link.inc.php');
require_once (DIR_FS_INC.'vam_manufacturer_link.inc.php');

// html functions
require_once (DIR_FS_INC.'vam_draw_checkbox_field.inc.php');
require_once (DIR_FS_INC.'vam_draw_form.inc.php');
require_once (DIR_FS_INC.'vam_draw_hidden_field.inc.php');
require_once (DIR_FS_INC.'vam_draw_input_field.inc.php');
require_once (DIR_FS_INC.'vam_draw_password_field.inc.php');
require_once (DIR_FS_INC.'vam_draw_pull_down_menu.inc.php');
require_once (DIR_FS_INC.'vam_draw_radio_field.inc.php');
require_once (DIR_FS_INC.'vam_draw_selection_field.inc.php');
require_once (DIR_FS_INC.'vam_draw_separator.inc.php');
require_once (DIR_FS_INC.'vam_draw_textarea_field.inc.php');
require_once (DIR_FS_INC.'vam_image_button.inc.php');

require_once (DIR_FS_INC.'vam_not_null.inc.php');
require_once (DIR_FS_INC.'vam_update_whos_online.inc.php');
require_once (DIR_FS_INC.'vam_activate_banners.inc.php');
require_once (DIR_FS_INC.'vam_expire_banners.inc.php');
require_once (DIR_FS_INC.'vam_expire_specials.inc.php');
require_once (DIR_FS_INC.'vam_parse_category_path.inc.php');
require_once (DIR_FS_INC.'vam_get_product_path.inc.php');

require_once (DIR_FS_INC.'vam_get_category_path.inc.php');

require_once (DIR_FS_INC.'vam_get_parent_categories.inc.php');
require_once (DIR_FS_INC.'vam_redirect.inc.php');
require_once (DIR_FS_INC.'vam_get_uprid.inc.php');
require_once (DIR_FS_INC.'vam_get_all_get_params.inc.php');
require_once (DIR_FS_INC.'vam_has_product_attributes.inc.php');
require_once (DIR_FS_INC.'vam_image.inc.php');
require_once (DIR_FS_INC.'vam_check_stock_attributes.inc.php');
require_once (DIR_FS_INC.'vam_currency_exists.inc.php');
require_once (DIR_FS_INC.'vam_remove_non_numeric.inc.php');
require_once (DIR_FS_INC.'vam_get_ip_address.inc.php');
require_once (DIR_FS_INC.'vam_setcookie.inc.php');
require_once (DIR_FS_INC.'vam_check_agent.inc.php');
require_once (DIR_FS_INC.'vam_count_cart.inc.php');
require_once (DIR_FS_INC.'vam_get_qty.inc.php');
require_once (DIR_FS_INC.'create_coupon_code.inc.php');
require_once (DIR_FS_INC.'vam_gv_account_update.inc.php');
require_once (DIR_FS_INC.'vam_get_tax_rate_from_desc.inc.php');
require_once (DIR_FS_INC.'vam_get_tax_rate.inc.php');
require_once (DIR_FS_INC.'vam_add_tax.inc.php');
require_once (DIR_FS_INC.'vam_cleanName.inc.php');
require_once (DIR_FS_INC.'vam_calculate_tax.inc.php');
require_once (DIR_FS_INC.'vam_input_validation.inc.php');
require_once (DIR_FS_INC.'vam_js_lang.php');
require_once (DIR_FS_INC.'vam_date_short.inc.php');
require_once (DIR_FS_INC.'vam_break_string.inc.php');
require_once (DIR_FS_INC.'vam_my_sorting_products.inc.php');
require_once (DIR_FS_INC.'vam_output_string.inc.php');
require_once (DIR_FS_INC.'vam_get_products_quantity_order_min.inc.php');
require_once (DIR_FS_INC.'vam_get_products_quantity_order_max.inc.php');
require_once (DIR_FS_INC.'vam_hide_session_id.inc.php');
require_once (DIR_FS_INC.'vam_get_spsr_zone_id.inc.php');
require_once (DIR_FS_INC . 'vam_get_subcategories.inc.php');
require_once (DIR_FS_INC.'vam_get_label_name.inc.php');

// make a connection to the database... now
vam_db_connect() or die('Unable to connect to database server!');

$configuration_query = vam_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from '.TABLE_CONFIGURATION);
while ($configuration = vam_db_fetch_array($configuration_query)) {
	define($configuration['cfgKey'], $configuration['cfgValue']);
}

require_once (DIR_WS_INCLUDES . 'external/phpmailer/class.phpmailer.php');
if (EMAIL_TRANSPORT == 'smtp')
	require_once (DIR_WS_INCLUDES . 'external/phpmailer/class.smtp.php');
require_once (DIR_FS_INC.'vam_Security.inc.php');

// set the application parameters

function vamDBquery($query) {
	if (DB_CACHE == 'true') {
//			echo  'cached query: '.$query.'<br>';
		$result = vam_db_queryCached($query);
	} else {
//				echo '::'.$query .'<br>';
		$result = vam_db_query($query);

	}
	return $result;
}

function CacheCheck() {
	if (USE_CACHE == 'false') return false;
	if (!isset($_COOKIE['sid'])) return false;
	return true;
}

// if gzip_compression is enabled, start to buffer the output
if ((GZIP_COMPRESSION == 'true') && ($ext_zlib_loaded = extension_loaded('zlib')) && (PHP_VERSION >= '4')) {
	if (($ini_zlib_output_compression = (int) ini_get('zlib.output_compression')) < 1) {
		ob_start('ob_gzhandler');
	} else {
		ini_set('zlib.output_compression_level', GZIP_LEVEL);
	}
}

// set the HTTP GET parameters manually if search_engine_friendly_urls is enabled
if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') {
	if (strlen(getenv('PATH_INFO')) > 1) {
		$GET_array = array ();
		 $PHP_SELF = str_replace(getenv('PATH_INFO'), '', $_SERVER['PHP_SELF']);
		$vars = explode('/', substr(getenv('PATH_INFO'), 1));
		for ($i = 0, $n = sizeof($vars); $i < $n; $i ++) {
			if (strpos($vars[$i], '[]')) {
				$GET_array[substr($vars[$i], 0, -2)][] = $vars[$i +1];
			} else {
				$_GET[$vars[$i]] = htmlspecialchars($vars[$i +1]);
				if(get_magic_quotes_gpc()) $_GET[$vars[$i]] = addslashes($_GET[$vars[$i]]);
			}
			$i ++;
		}

		if (sizeof($GET_array) > 0) {
			foreach ($GET_array as $key => $value) {
				$_GET[$key] = htmlspecialchars($value);
				if(get_magic_quotes_gpc()) $_GET[$key] = addslashes($_GET[$key]);
			}
		}
	}
}
// check GET/POST/COOKIE VARS
require (DIR_WS_CLASSES.'class.inputfilter.php');
$InputFilter = new InputFilter();
$_GET = $InputFilter->process($_GET);
$_POST = $InputFilter->process($_POST);
$_COOKIE = $InputFilter->process($_COOKIE);
$_SERVER = $InputFilter->process($_SERVER);

// set the top level domains
$http_domain = vam_get_top_level_domain(HTTP_SERVER);
$https_domain = vam_get_top_level_domain(HTTPS_SERVER);
$cookie_info = vam_get_cookie_info();

// include shopping cart class
require (DIR_WS_CLASSES.'shopping_cart.php');

// include navigation history class
require (DIR_WS_CLASSES.'navigation_history.php');

// some code to solve compatibility issues
require (DIR_WS_FUNCTIONS.'compatibility.php');

// define how the session functions will be used
require (DIR_WS_FUNCTIONS.'sessions.php');

// set the session name and save path
session_name('sid');
session_save_path(SESSION_WRITE_DIRECTORY);

// HMCS: Begin Autologon	******************************************************************
  // Determine if cookies are enabled
  vam_setcookie("TEMPCOOKIE", "CookieOn", time() + 60 * 60);
  $cookieinfo = $_COOKIE["TEMPCOOKIE"];
  if ($cookieinfo == "CookieOn") {
    global $cookies_on;
    $cookies_on = true;
  }
// HMCS: End Autologon

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
if (isset ($_POST[session_name()])) {
	session_id($_POST[session_name()]);
}
elseif (($request_type == 'SSL') && isset ($_GET[session_name()])) {
	session_id($_GET[session_name()]);
}

// start the session
$session_started = false;
if (SESSION_FORCE_COOKIE_USE == 'True') {
	vam_setcookie('cookie_test', 'please_accept_for_session', time() + 60 * 60 * 24 * 30, $cookie_info['cookie_path'], $cookie_info['cookie_domain']);

	if (isset ($_COOKIE['cookie_test'])) {
		session_start();
		include (DIR_WS_INCLUDES.'tracking.php');
		$session_started = true;
	}
} else {
	session_start();
	include (DIR_WS_INCLUDES.'tracking.php');
	$session_started = true;
}

// check the Agent
$truncate_session_id = false;
if (CHECK_CLIENT_AGENT) {
	if (vam_check_agent() == 1) {
		$truncate_session_id = true;
	}
}

  if ( ($session_started == true) && (PHP_VERSION >= 4.3) && function_exists('ini_get') && (ini_get('register_globals') == false) ) {
    extract($_SESSION, EXTR_OVERWRITE+EXTR_REFS);
  }
  
// initialize a session token
  if (!vam_session_is_registered('sessiontoken')) {
    $sessiontoken = md5(vam_rand() . vam_rand() . vam_rand() . vam_rand());
    vam_session_register('sessiontoken');
  }
  
// set SID once, even if empty
  $SID = (defined('SID') ? SID : '');  
  
// verify the ssl_session_id if the feature is enabled
if (($request_type == 'SSL') && (SESSION_CHECK_SSL_SESSION_ID == 'True') && (ENABLE_SSL == true) && ($session_started == true)) {
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
	if (!isset ($_SESSION['SESSION_USER_AGENT'])) {
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
	if (!isset ($_SESSION['SESSION_IP_ADDRESS'])) {
		$_SESSION['SESSION_IP_ADDRESS'] = $ip_address;
	}

	if ($_SESSION['SESSION_IP_ADDRESS'] != $ip_address) {
		session_destroy();
		vam_redirect(vam_href_link(FILENAME_LOGIN));
	}
}

// set the language
if (!isset ($_SESSION['language']) || isset ($_GET['language']) || empty($language)) {

	include (DIR_WS_CLASSES.'language.php');
	$lng = new language(vam_input_validation($_GET['language'], 'char', ''));

	if (!isset ($_GET['language']))
		$lng = new language(DEFAULT_LANGUAGE);

	$_SESSION['language'] = $lng->language['directory'];
	$_SESSION['languages_id'] = $lng->language['id'];
	$_SESSION['language_charset'] = $lng->language['language_charset'];
	$_SESSION['language_code'] = $lng->language['code'];
}

if (isset($_SESSION['language']) && !isset($_SESSION['language_charset'])) {
	
	include (DIR_WS_CLASSES.'language.php');
	$lng = new language(vam_input_validation($_SESSION['language'], 'char', ''));


	$_SESSION['language'] = $lng->language['directory'];
	$_SESSION['languages_id'] = $lng->language['id'];
	$_SESSION['language_charset'] = $lng->language['language_charset'];
	$_SESSION['language_code'] = $lng->language['code'];
	
}
// include the language translations
require_once (DIR_WS_LANGUAGES.$_SESSION['language'].'/'.$_SESSION['language'].'.php');
require_once (DIR_WS_LANGUAGES.$_SESSION['language'].'/'.$_SESSION['language'].'.inc.php');

// currency
if (!isset ($_SESSION['currency']) || isset ($_GET['currency']) || ((USE_DEFAULT_LANGUAGE_CURRENCY == 'true') && (LANGUAGE_CURRENCY != $_SESSION['currency']))) {

	if (isset ($_GET['currency'])) {
		if (!$_SESSION['currency'] = vam_currency_exists($_GET['currency']))
			$_SESSION['currency'] = (USE_DEFAULT_LANGUAGE_CURRENCY == 'true') ? LANGUAGE_CURRENCY : DEFAULT_CURRENCY;
	} else {
		$_SESSION['currency'] = (USE_DEFAULT_LANGUAGE_CURRENCY == 'true') ? LANGUAGE_CURRENCY : DEFAULT_CURRENCY;
	}
}
if (isset ($_SESSION['currency']) && $_SESSION['currency'] == '') {
	$_SESSION['currency'] = DEFAULT_CURRENCY;
}

// write customers status in session
require (DIR_WS_INCLUDES.'write_customers_status.php');

// testing new price class

require (DIR_WS_CLASSES.'main.php');
$main = new main();

require (DIR_WS_CLASSES.'vam_price.php');
$vamPrice = new vamPrice($_SESSION['currency'], $_SESSION['customers_status']['customers_status_id'],$_SESSION['customer_id']);

if ($_SESSION['customers_status']['customers_status_id'] != 0) {
if (!strstr($PHP_SELF,FILENAME_LOGIN)) {
if (EXCLUDE_ADMIN_IP_FOR_MAINTENANCE != getenv('REMOTE_ADDR')){
	if (DOWN_FOR_MAINTENANCE=='true' and !strstr($PHP_SELF,DOWN_FOR_MAINTENANCE_FILENAME)) { vam_redirect(vam_href_link(DOWN_FOR_MAINTENANCE_FILENAME)); }
	}
// do not let people get to down for maintenance page if not turned on
if (DOWN_FOR_MAINTENANCE=='false' and strstr($PHP_SELF,DOWN_FOR_MAINTENANCE_FILENAME)) {
    vam_redirect(vam_href_link(FILENAME_DEFAULT));
}
}
}

require (DIR_WS_INCLUDES.FILENAME_CART_ACTIONS);
// create the shopping cart & fix the cart if necesary
if (!is_object($_SESSION['cart'])) {
	$_SESSION['cart'] = new shoppingCart();
}

// include the who's online functions
vam_update_whos_online();

// split-page-results
require (DIR_WS_CLASSES.'split_page_results.php');

// auto activate and expire banners
vam_activate_banners();
vam_expire_banners();

// auto expire special products
vam_expire_specials();
require (DIR_WS_CLASSES.'product.php');
// new p URLS
if (isset ($_GET['info'])) {
	$site = explode('_', $_GET['info']);
	$pID = $site[0];
	$actual_products_id = (int) str_replace('p', '', $pID);
	$product = new product($actual_products_id);
} // also check for old 3.0.3 URLS
elseif (isset($_GET['products_id'])) {
	$actual_products_id = (int) $_GET['products_id'];
	$product = new product($actual_products_id);
	
} elseif (isset($_GET['BUYproducts_id'])) {
	$actual_products_id = (int) $_GET['BUYproducts_id'];
	$product = new product($actual_products_id);
	
}
if (!is_object($product)) {
	$product = new product();	
}

// new c URLS
if (isset ($_GET['cat'])) {
	$site = explode('_', $_GET['cat']);
	$cID = $site[0];
	$cID = str_replace('c', '', $cID);
	$_GET['cPath'] = vam_get_category_path($cID);
}
// new m URLS
if (isset ($_GET['manu'])) {
	$site = explode('_', $_GET['manu']);
	$mID = $site[0];
	$mID = (int)str_replace('m', '', $mID);
	$_GET['manufacturers_id'] = $mID;
}

// calculate category path
if (isset ($_GET['cPath'])) {
	$cPath = vam_input_validation($_GET['cPath'], 'cPath', '');
}
elseif (is_object($product) && !isset ($_GET['manufacturers_id'])) {
	if ($product->isProduct()) {
		$cPath = vam_get_product_path($actual_products_id);
	} else {
		$cPath = '';
	}
} else {
	$cPath = '';
}

if (vam_not_null($cPath)) {
	$cPath_array = vam_parse_category_path($cPath);
	$cPath = implode('_', $cPath_array);
	$current_category_id = $cPath_array[(sizeof($cPath_array) - 1)];
} else {
	$current_category_id = 0;
}

// include the breadcrumb class and start the breadcrumb trail
require (DIR_WS_CLASSES.'breadcrumb.php');
$breadcrumb = new breadcrumb;

if ($current_category_id > 0 or !strstr($PHP_SELF, FILENAME_DEFAULT)) $breadcrumb->add(TITLE_DEFAULT_PAGE, HTTP_SERVER);
//$breadcrumb->add(HEADER_TITLE_CATALOG, HTTP_SERVER . DIR_WS_CATALOG);

// add category names or the manufacturer name to the breadcrumb trail
if (isset ($cPath_array)) {
	for ($i = 0, $n = sizeof($cPath_array); $i < $n; $i ++) {
		if (GROUP_CHECK == 'true') {
			$group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
		} else {
		   $group_check='';
		}
		$categories_query = vamDBquery("select
				                                        cd.categories_name
				                                        from ".TABLE_CATEGORIES_DESCRIPTION." cd,
				                                        ".TABLE_CATEGORIES." c
				                                        where cd.categories_id = '".$cPath_array[$i]."'
				                                        and c.categories_id=cd.categories_id
				                                        ".$group_check."
				                                        and cd.language_id='".(int) $_SESSION['languages_id']."'");
		if (vam_db_num_rows($categories_query,true) > 0) {
			$categories = vam_db_fetch_array($categories_query,true);

            if ($i < $n-1){
                        $breadcrumb->add($categories['categories_name'], vam_href_link(FILENAME_DEFAULT, vam_category_link($cPath_array[$i], $categories['categories_name'])));
                        }else {
                if ($product->isProduct()) {$breadcrumb->add($categories['categories_name'], vam_href_link(FILENAME_DEFAULT, vam_category_link($cPath_array[$i], $categories['categories_name'])));} else {
                	$breadcrumb->add($categories['categories_name']);
                	}
                }

		} else {
			break;
		}
	}
}
elseif (vam_not_null($_GET['manufacturers_id'])) {
	$manufacturers_query = vamDBquery("select manufacturers_name from ".TABLE_MANUFACTURERS." where manufacturers_id = '".(int) $_GET['manufacturers_id']."'");
	$manufacturers = vam_db_fetch_array($manufacturers_query, true);

	$breadcrumb->add($manufacturers['manufacturers_name'], vam_href_link(FILENAME_DEFAULT, vam_manufacturer_link((int) $_GET['manufacturers_id'], $manufacturers['manufacturers_name'])));

}

// add the products model/name to the breadcrumb trail
if ($product->isProduct()) {
                $breadcrumb->add($product->getBreadcrumbName());
}


// Start product/catalog variables set fot template

$product_name_tpl = '';

if (isset ($_GET['info']))
{
    $site = explode('_', $_GET['info']);
    $pID = $site[0];

    $products_category_tpl_path_query  = vam_db_query( "select products_name from "
      . TABLE_PRODUCTS_DESCRIPTION
      . " where products_id = '" . (int) str_replace('p', '', $pID)
      . "' and language_id = '" . $_SESSION['languages_id'] . "'" );
    $products_category_tpl_path_result = vam_db_fetch_array( $products_category_tpl_path_query );

    $product_name_tpl = $products_category_tpl_path_result[ 'products_name' ];

} // also check for old 3.0.3 URLS
elseif (isset($_GET['products_id']))
{
    $products_category_tpl_path_query  = vam_db_query( "select products_name from "
      . TABLE_PRODUCTS_DESCRIPTION
      . " where products_id = '" . (int)$_GET['products_id']
      . "' and language_id = '" . $_SESSION['languages_id'] . "'" 
    );
    $products_category_tpl_path_result = vam_db_fetch_array( $products_category_tpl_path_query );

    $product_name_tpl = $products_category_tpl_path_result[ 'products_name' ];
};


$products_category_tpl_arr = array();

$products_category_tpl_path_current_id = $current_category_id;

while ( $products_category_tpl_path_current_id )
{
    $products_category_tpl_path_query = vam_db_query( "select categories_name from  " . TABLE_CATEGORIES_DESCRIPTION . " where language_id = '" . $_SESSION['languages_id'] . "' and categories_id = '" . $products_category_tpl_path_current_id . "'" );
    $products_category_tpl_path_result = vam_db_fetch_array( $products_category_tpl_path_query );
    
    $products_category_tpl_arr[ $products_category_tpl_path_current_id ] = $products_category_tpl_path_result[ 'categories_name' ];

    $products_category_tpl_path_query = vam_db_query( "select parent_id from  " . TABLE_CATEGORIES . " where categories_id = '" . $products_category_tpl_path_current_id . "'" );
    $products_category_tpl_path_result = vam_db_fetch_array( $products_category_tpl_path_query );
    $products_category_tpl_path_current_id = $products_category_tpl_path_result[ 'parent_id' ];

};  // while ( $products_category_tpl_path_current_id )

$products_category_tpl_arr = array_reverse( $products_category_tpl_arr, true );
$category_path_tpl_arr = array_values( $products_category_tpl_arr );


// End product/catalog variables set fot template



// initialize the message stack for output messages
require (DIR_WS_CLASSES.'message_stack.php');
$messageStack = new messageStack;

// set which precautions should be checked
define('WARN_INSTALL_EXISTENCE', 'true');
define('WARN_CONFIG_WRITEABLE', 'false');
define('WARN_SESSION_DIRECTORY_NOT_WRITEABLE', 'true');
define('WARN_SESSION_AUTO_START', 'true');
define('WARN_DOWNLOAD_DIRECTORY_NOT_READABLE', 'true');

if (isset ($_SESSION['customer_id'])) {
	$account_type_query = vam_db_query("SELECT
		                                    account_type,
		                                    customers_default_address_id
		                                    FROM
		                                    ".TABLE_CUSTOMERS."
		                                    WHERE customers_id = '".(int) $_SESSION['customer_id']."'");
	$account_type = vam_db_fetch_array($account_type_query);

	// check if zone id is unset bug #0000169
	if (!isset ($_SESSION['customer_country_id'])) {
		$zone_query = vam_db_query("SELECT  entry_country_id
				                                     FROM ".TABLE_ADDRESS_BOOK."
				                                     WHERE customers_id='".(int) $_SESSION['customer_id']."'
				                                     and address_book_id='".$account_type['customers_default_address_id']."'");

		$zone = vam_db_fetch_array($zone_query);
		$_SESSION['customer_country_id'] = $zone['entry_country_id'];
	}
	$_SESSION['account_type'] = $account_type['account_type'];
} else {
	$_SESSION['account_type'] = '0';
}

// modification for nre graduated system
unset ($_SESSION['actual_content']);
vam_count_cart();

// include the articles functions
  require(DIR_WS_FUNCTIONS . 'articles.php');

// calculate topic path
  if (isset($_GET['tPath'])) {
    $tPath = $_GET['tPath'];
  } elseif (isset($_GET['articles_id']) && !isset($_GET['authors_id'])) {
    $tPath = vam_get_article_path($_GET['articles_id']);
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

// add topic names or the author name to the breadcrumb trail
  if (isset($tPath_array)) {
    for ($i=0, $n=sizeof($tPath_array); $i<$n; $i++) {
      $topics_query = vamDBquery("select topics_name from " . TABLE_TOPICS_DESCRIPTION . " where topics_id = '" . (int)$tPath_array[$i] . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'");
      if (vam_db_num_rows($topics_query,true) > 0) {
        $topics = vam_db_fetch_array($topics_query,true);

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&category='.vam_cleanName($topics['topics_name']);

        if ($current_topic_id == $tPath_array[$i] && (isset($_GET['articles_id']) or isset($_GET['authors_id'])))
        $breadcrumb->add($topics['topics_name'], vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath_array[$i].$SEF_parameter));
      } else {
        break;
      }
    }
  } elseif (isset($_GET['authors_id'])) {
    $authors_query = vamDBquery("select authors_name from " . TABLE_AUTHORS . " where authors_id = '" . (int)$_GET['authors_id'] . "'");
    if (vam_db_num_rows($authors_query,true)) {
      $authors = vam_db_fetch_array($authors_query,true);
      $breadcrumb->add(ARTICLES_BY . $authors['authors_name'], vam_href_link(FILENAME_ARTICLES, 'authors_id=' . $_GET['authors_id']));
    }
  }

// add the articles name to the breadcrumb trail
  if (isset($_GET['articles_id'])) {
    $article_query = vamDBquery("select articles_name from " . TABLE_ARTICLES_DESCRIPTION . " where articles_id = '" . (int)$_GET['articles_id'] . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'");

   if (vam_db_num_rows($article_query,true)) {
      $article = vam_db_fetch_array($article_query,true);

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&article='.vam_cleanName($article['articles_name']);

      if (isset($_GET['authors_id'])) {
        $breadcrumb->add($article['articles_name']);
      } else {
        $breadcrumb->add($article['articles_name']);
      }
    }
  }

  if (strstr($PHP_SELF, FILENAME_NEWS)) {   
       $breadcrumb->add(NAVBAR_TITLE_NEWS, vam_href_link(FILENAME_NEWS));
  } 

  if (isset($_GET['news_id'])) {
    $news_query = vamDBquery("select news_id, headline from " . TABLE_LATEST_NEWS . " where news_id = '" . (int)$_GET['news_id'] . "' and language = '" . (int)$_SESSION['languages_id'] . "'");
    if (vam_db_num_rows($news_query,true)) {
      $news = vam_db_fetch_array($news_query,true);

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&headline='.vam_cleanName($news['headline']);
			
      if (isset($_GET['news_id'])) {
        $breadcrumb->add($news['headline']);
      } else {
        $breadcrumb->add($news['headline']);
      }
    }
  }

if (isset($_SESSION['tracking']['http_referer'])) $html_referer = $_SESSION['tracking']['http_referer']['scheme'] . '://' . $_SESSION['tracking']['http_referer']['host'] . $_SESSION['tracking']['http_referer']['path'] . '?' . $_SESSION['tracking']['http_referer']['query'];
  
require('includes/local_modules.php');

require_once(DIR_FS_CATALOG.'includes/classes/vam_template.php');

require_once(DIR_WS_INCLUDES . 'affiliate_application_top.php');

require(DIR_WS_FUNCTIONS . 'customers_extra_fields.php');

define('TAX_DECIMAL_PLACES','2');

// starts canonical tag function
function CanonicalUrl() {
$domain = substr((($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER), 0); // gets the base URL minus the trailing slash
$string = $_SERVER['REQUEST_URI']; // gets the url
$search = '/\&sid.[^\&\?]*|\?sid.[^\&\?]*|\?sort.[^\&\?]*|\&sort.[^\&\?]*|\?direction.[^\&\?]*|\&direction.[^\&\?]*|\?on_page.[^\&\?]*|\&on_page.[^\&\?]*|\?page.[^\&\?]*|\&page.[^\&\?]*|\?page==1|\&page==1|\&cat.[^\&\?]*|\&filter_id.[^\&\?]*|\&manufacturers_id.[^\&\?]*|\&params.[^\&\?]*|\?q.[^\&\?]*|\&q.[^\&\?]*|\?price_min.[^\&\?]*|\&price_min.[^\&\?]*|\?price_max.[^\&\?]*|\&price_max.[^\&\?]*/'; // searches for the session id in the url
$replace = ''; // replaces with nothing i.e. deletes
echo $domain . preg_replace( $search, $replace, $string ); // merges the variables and echoing them
}
// eof - canonical tag

$url = vam_href_link(basename($PHP_SELF), vam_get_all_get_params(array ('page', 'cPath', 'info', 'x', 'y')));

if ($cID && PRODUCT_LIST_RECURSIVE == 'false') {

$listing_sql = "select p.products_fsk18, p.products_shippingtime, p.products_model, p.products_ean, pd.products_name, m.manufacturers_name, p.products_quantity, p.products_image, p.products_weight, pd.products_short_description, pd.products_description, p.products_id, p.manufacturers_id, p.products_price, p.products_vpe, p.products_vpe_status, p.products_vpe_value, p.products_discount_allowed, p.products_tax_class_id from products_description pd, products_to_categories p2c, products p left join manufacturers m on p.manufacturers_id = m.manufacturers_id left join specials s on p.products_id = s.products_id where p.products_status = '1' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '1' and p2c.categories_id = '".$cID."' ORDER BY p.products_price DESC";
$max_result = MAX_DISPLAY_SEARCH_RESULTS;
$listing_split = new splitPageResults($listing_sql, (int)$_GET['page'], $max_result, 'p.products_id');
$number_of_pages = ceil($listing_split->number_of_rows / $max_result);

if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') {
$end_page_url = $url.'/page/'.$number_of_pages;
} else {
$end_page_url = $url.'?page='.$number_of_pages;
}
	  if($number_of_pages < $_GET['page']){
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: $end_page_url");
			exit();
	  }
}
	  
if(trim($_GET['page']) == '1' && $url != ''){
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: $url");
			exit();
}

if($_SERVER['REQUEST_URI'] != DIR_WS_CATALOG && $PHP_SELF == DIR_WS_CATALOG.'index.php' && !$_GET ){
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".DIR_WS_CATALOG."");
			exit();
}
 
if (strpos($PHP_SELF, FILENAME_PRODUCT_INFO) !== FALSE || strpos($PHP_SELF, FILENAME_PRODUCT_REVIEWS) !== FALSE) {
    require('includes/modules/headerstatushandler.php');
}

// include composer autoload
  require(DIR_FS_CATALOG . '/vendor/autoload.php');

  // HMCS: Begin Autologon	******************************************************************
  if ($cookies_on == true) {
    if (ALLOW_AUTOLOGON == 'true') {                                // Is Autologon enabled?
      if (basename($_SERVER['PHP_SELF']) != FILENAME_LOGIN) {                  // yes
        if (!isset ($_SESSION['customer_id'])) {
          include(DIR_WS_MODULES.FILENAME_AUTOLOGON);
    	}
      }
    } else {
      vam_setcookie("email_address", "", time() - 3600, $cookie_path);  //no, delete email_address cookie
      vam_setcookie("password", "", time() - 3600, $cookie_path);       //no, delete password cookie
    }
  }
  // HMCS: End Autologon		******************************************************************
  
?>