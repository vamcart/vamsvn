<?php
/* -----------------------------------------------------------------------------------------
   $Id: header.php 1140 2011-02-06 20:14:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(header.php,v 1.40 2003/03/14); www.oscommerce.com
   (c) 2003	 nextcommerce (header.php,v 1.13 2003/08/17); www.nextcommerce.org
   (c) 20054 xt:Commerce (header.php,v 1.13 2005/08/10); xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>" />

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png"/>
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png"/>
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png"/>
<link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png"/>
<link rel="shortcut icon" href="favicon.ico"/>

<?php include(DIR_WS_MODULES.FILENAME_METATAGS); ?>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />
<script type="text/javascript" src="jscript/jquery/jquery.js"></script>
<?php
if (file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/templates/'.CURRENT_TEMPLATE.'/css/css.php')) include('templates/'.CURRENT_TEMPLATE.'/css/css.php');
if (file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/templates/'.CURRENT_TEMPLATE.'/javascript/script.php')) include('templates/'.CURRENT_TEMPLATE.'/javascript/script.php');
?>
<link rel="stylesheet" type="text/css" href="<?php echo 'templates/'.CURRENT_TEMPLATE.'/stylesheet.css'; ?>" />
<?php
if (isset($_GET['products_id']) && strstr($PHP_SELF, FILENAME_PRODUCT_INFO)) {
?>
<link rel="canonical" href="<?php echo CanonicalUrl(); ?>" />
<?php
 }
?>
<?php
if (isset($_GET['cat']) && isset($current_category_id) && strstr($PHP_SELF, FILENAME_DEFAULT)) {
?>
<link rel="canonical" href="<?php echo CanonicalUrl(); ?>" />
<?php
 }
?>
<?php
if (isset($_GET['articles_id']) && strstr($PHP_SELF, FILENAME_ARTICLE_INFO)) {
?>
<link rel="canonical" href="<?php echo CanonicalUrl(); ?>" />
<?php
 }
?>
<?php
if (isset($tPath) && strstr($PHP_SELF, FILENAME_ARTICLES)) {
?>
<link rel="canonical" href="<?php echo CanonicalUrl(); ?>" />
<?php
 }
?>
<?php
if (isset($_GET['news_id']) && strstr($PHP_SELF, FILENAME_NEWS)) {
?>
<link rel="canonical" href="<?php echo CanonicalUrl(); ?>" />
<?php
 }
?>
<?php
if (isset($_GET['faq_id']) && strstr($PHP_SELF, FILENAME_FAQ)) {
?>
<link rel="canonical" href="<?php echo CanonicalUrl(); ?>" />
<?php
 }
?>
<link rel="alternate" type="application/rss+xml" title="<?php echo TEXT_RSS_NEWS; ?>" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=news'; ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php echo TEXT_RSS_ARTICLES; ?>" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=articles'; ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php echo TEXT_RSS_CATEGORIES; ?>" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=categories'; ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php echo TEXT_RSS_NEW_PRODUCTS; ?>" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products&amp;limit=10'; ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php echo TEXT_RSS_FEATURED_PRODUCTS; ?>" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured&amp;limit=10'; ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php echo TEXT_RSS_BEST_SELLERS; ?>" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers&amp;limit=10'; ?>" />
<?php if (AJAX_CART == 'true') { ?>
<script type="text/javascript" src="jscript/jscript_ajax_cart.js"></script>
<?php } ?>
<?php
if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO)) {
?>
<link rel="stylesheet" type="text/css" href="jscript/jquery/plugins/colorbox/colorbox.css" media="screen" />
<script type="text/javascript" src="jscript/jquery/plugins/colorbox/jquery.colorbox-min.js"></script>
<?php
if (file_exists(DIR_FS_CATALOG.'jscript/jquery/plugins/colorbox/i18n/jquery.colorbox-'.$_SESSION['language_code'].'.js')) {
?>
<script type="text/javascript" src="jscript/jquery/plugins/colorbox/i18n/jquery.colorbox-ru.js"></script>
<?php } ?>
<script type="text/javascript">
// Make ColorBox responsive
	jQuery.colorbox.settings.maxWidth  = '95%';
	jQuery.colorbox.settings.maxHeight = '95%';

	// ColorBox resize function
	var resizeTimer;
	function resizeColorBox()
	{
		if (resizeTimer) clearTimeout(resizeTimer);
		resizeTimer = setTimeout(function() {
				if (jQuery('#cboxOverlay').is(':visible')) {
						jQuery.colorbox.load(true);
				}
		}, 300);
	}

	// Resize ColorBox when resizing window or changing mobile device orientation
	jQuery(window).resize(resizeColorBox);
	
$(document).ready(function(){
  $(".lightbox").colorbox({rel:"lightbox", title: false});
  $(".iframe").colorbox({iframe:true, width:"30%", height:"80%"});
});
</script>
<?php
 }
?>
<?php
// require theme based javascript
require('templates/'.CURRENT_TEMPLATE.'/javascript/general.js.php');

if (strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT)) {
 echo $payment_modules->javascript_validation();
}

if (strstr($PHP_SELF, FILENAME_CREATE_ACCOUNT)) {
require(DIR_WS_INCLUDES.'form_check.js.php');
}

if (strstr($PHP_SELF, FILENAME_CHECKOUT)) {
require(DIR_WS_INCLUDES.'form_check.js.php');
require(DIR_WS_INCLUDES.'checkout.js.php');
}

if (strstr($PHP_SELF, FILENAME_CREATE_GUEST_ACCOUNT )) {
require(DIR_WS_INCLUDES.'form_check.js.php');
}
if (strstr($PHP_SELF, FILENAME_ACCOUNT_PASSWORD )) {
require(DIR_WS_INCLUDES.'form_check.js.php');
}
if (strstr($PHP_SELF, FILENAME_ACCOUNT_EDIT )) {
require(DIR_WS_INCLUDES.'form_check.js.php');
}
if (strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS )) {
  if (isset($_GET['delete']) == false) {
    include(DIR_WS_INCLUDES.'form_check.js.php');
  }
  }
  if (strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT)) {
require(DIR_WS_INCLUDES.'form_check.js.php');
}
if (strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING_ADDRESS )or strstr($PHP_SELF,FILENAME_CHECKOUT_PAYMENT_ADDRESS)) {
require(DIR_WS_INCLUDES.'form_check.js.php');
?>
<script type="text/javascript"><!--
function check_form_optional(form_name) {
  var form = form_name;

  var firstname = form.elements['firstname'].value;
  var lastname = form.elements['lastname'].value;
  var street_address = form.elements['street_address'].value;

  if (firstname == '' && lastname == '' && street_address == '') {
    return true;
  } else {
    return check_form(form_name);
  }
}
//--></script>
<?php
}

if (strstr($PHP_SELF, FILENAME_ADVANCED_SEARCH )) {
?>
<script type="text/javascript" src="includes/general.js"></script>
<script type="text/javascript"><!--
function check_form() {
  var error_message = unescape("<?php echo vam_js_lang(JS_ERROR); ?>");
  var error_found = false;
  var error_field;
  var keywords = document.getElementById("advanced_search").keywords.value;
  var pfrom = document.getElementById("advanced_search").pfrom.value;
  var pto = document.getElementById("advanced_search").pto.value;
  var pfrom_float;
  var pto_float;

  if ( (keywords == '' || keywords.length < 1) && (pfrom == '' || pfrom.length < 1) && (pto == '' || pto.length < 1) ) {
    error_message = error_message + unescape("<?php echo vam_js_lang(JS_AT_LEAST_ONE_INPUT); ?>");
    error_field = document.getElementById("advanced_search").keywords;
    error_found = true;
  }

  if (pfrom.length > 0) {
    pfrom_float = parseFloat(pfrom);
    if (isNaN(pfrom_float)) {
      error_message = error_message + unescape("<?php echo vam_js_lang(JS_PRICE_FROM_MUST_BE_NUM); ?>");
      error_field = document.getElementById("advanced_search").pfrom;
      error_found = true;
    }
  } else {
    pfrom_float = 0;
  }

  if (pto.length > 0) {
    pto_float = parseFloat(pto);
    if (isNaN(pto_float)) {
      error_message = error_message + unescape("<?php echo vam_js_lang(JS_PRICE_TO_MUST_BE_NUM); ?>");
      error_field = document.getElementById("advanced_search").pto;
      error_found = true;
    }
  } else {
    pto_float = 0;
  }

  if ( (pfrom.length > 0) && (pto.length > 0) ) {
    if ( (!isNaN(pfrom_float)) && (!isNaN(pto_float)) && (pto_float < pfrom_float) ) {
      error_message = error_message + unescape("<?php echo vam_js_lang(JS_PRICE_TO_LESS_THAN_PRICE_FROM); ?>");
      error_field = document.getElementById("advanced_search").pto;
      error_found = true;
    }
  }

  if (error_found == true) {
    alert(error_message);
    error_field.focus();
    return false;
  }
}

function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
<?php
}

if (strstr($PHP_SELF, FILENAME_PRODUCT_REVIEWS_WRITE )) {
?>

<script type="text/javascript"><!--
function checkForm() {
  var error = 0;
  var error_message = unescape("<?php echo vam_js_lang(JS_ERROR); ?>");

  var review = document.getElementById("product_reviews_write").review.value;

  if (review.length < <?php echo REVIEW_TEXT_MIN_LENGTH; ?>) {
    error_message = error_message + unescape("<?php echo vam_js_lang(JS_REVIEW_TEXT); ?>");
    error = 1;
  }

  var captcha = document.getElementById("product_reviews_write").captcha.value;

  if (captcha.length < 4) {
    error_message = error_message + unescape("<?php echo vam_js_lang(JS_REVIEW_CAPTCHA); ?>");
    error = 1;
  }

  if (!((document.getElementById("product_reviews_write").rating[0].checked) || (document.getElementById("product_reviews_write").rating[1].checked) || (document.getElementById("product_reviews_write").rating[2].checked) || (document.getElementById("product_reviews_write").rating[3].checked) || (document.getElementById("product_reviews_write").rating[4].checked))) {
    error_message = error_message + unescape("<?php echo vam_js_lang(JS_REVIEW_RATING); ?>");
    error = 1;
  }

  if (error == 1) {
    alert(error_message);
    return false;
  } else {
    return true;
  }
}
//--></script>
<?php
}
?>
</head>
<body>
<?php
if (!strstr($PHP_SELF, FILENAME_CHECKOUT_SUCCESS)) {
require(DIR_WS_INCLUDES.'google_conversiontracking.js.php');
}
?>
<?php

  // include needed functions
  require_once(DIR_FS_INC.'vam_output_warning.inc.php');
  require_once(DIR_FS_INC.'vam_image.inc.php');
  require_once(DIR_FS_INC.'vam_parse_input_field_data.inc.php');
  require_once(DIR_FS_INC.'vam_draw_separator.inc.php');

//  require_once('inc/vam_draw_form.inc.php');
//  require_once('inc/vam_draw_pull_down_menu.inc.php');

  // check if the 'install' directory exists, and warn of its existence
  if (WARN_INSTALL_EXISTENCE == 'true') {
    if (file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/install')) {
      vam_output_warning(WARNING_INSTALL_DIRECTORY_EXISTS);
    }
  }

  // check if the configure.php file is writeable
  if (WARN_CONFIG_WRITEABLE == 'true') {
    if ( (file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/includes/configure.php')) && (is_writeable(dirname($_SERVER['SCRIPT_FILENAME']) . '/includes/configure.php')) ) {

      vam_output_warning(WARNING_CONFIG_FILE_WRITEABLE);
    }
  }

    if ((!file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/vamshop.key')) && (!file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/vamshop.key.txt'))) {

      vam_output_warning(WARNING_VAMSHOP_KEY);
    }
  
  // check if the session folder is writeable
  if (WARN_SESSION_DIRECTORY_NOT_WRITEABLE == 'true') {
    if (STORE_SESSIONS == '') {
      if (!is_dir(vam_session_save_path())) {
        vam_output_warning(WARNING_SESSION_DIRECTORY_NON_EXISTENT);
      } elseif (!is_writeable(vam_session_save_path())) {
        vam_output_warning(WARNING_SESSION_DIRECTORY_NOT_WRITEABLE);
      }
    }
  }

  // check session.auto_start is disabled
  if ( (function_exists('ini_get')) && (WARN_SESSION_AUTO_START == 'true') ) {
    if (ini_get('session.auto_start') == '1') {
      vam_output_warning(WARNING_SESSION_AUTO_START);
    }
  }

  if ( (WARN_DOWNLOAD_DIRECTORY_NOT_READABLE == 'true') && (DOWNLOAD_ENABLED == 'true') ) {
    if (!is_dir(DIR_FS_DOWNLOAD)) {
      vam_output_warning(WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT);
    }
  }


$vamTemplate->assign('navtrail',$breadcrumb->trail(' &raquo; '));
if (isset($_SESSION['customer_id'])) {

$vamTemplate->assign('logoff',vam_href_link(FILENAME_LOGOFF, '', 'SSL'));
}
if ( $_SESSION['account_type']=='0') {
$vamTemplate->assign('account',vam_href_link(FILENAME_ACCOUNT, '', 'SSL'));
}
$vamTemplate->assign('cart',vam_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
$vamTemplate->assign('checkout',vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
$vamTemplate->assign('store_name',TITLE);
$vamTemplate->assign('login',vam_href_link(FILENAME_LOGIN, '', 'SSL'));
$vamTemplate->assign('mainpage',HTTP_SERVER . DIR_WS_CATALOG);


// Start product/catalog variables set fot template

$vamTemplate->assign( 'product_name_tpl', $product_name_tpl );
$vamTemplate->assign( 'products_category_tpl', $products_category_tpl_arr );
$vamTemplate->assign( 'category_path_tpl', $category_path_tpl_arr );

// End product/catalog variables set fot template



  if (isset($_GET['error_message']) && vam_not_null($_GET['error_message'])) {

$vamTemplate->assign('error','
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr class="headerError">
        <td class="headerError">'. htmlspecialchars(urldecode($_GET['error_message'])).'</td>
      </tr>
    </table>');

  }

  if (isset($_GET['info_message']) && vam_not_null($_GET['info_message'])) {

$vamTemplate->assign('error','
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr class="headerInfo">
        <td class="headerInfo">'.htmlspecialchars($_GET['info_message']).'</td>
      </tr>
    </table>');

  }

// Метки для закладок

if (strstr($PHP_SELF, FILENAME_DEFAULT) && !$_GET['cat']) {
$vamTemplate->assign('1',' class="current"');
}

if (strstr($PHP_SELF, FILENAME_ACCOUNT) or strstr($PHP_SELF, FILENAME_ACCOUNT_EDIT) or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK)or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS) or strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY) or strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO) or strstr($PHP_SELF, FILENAME_ACCOUNT_PASSWORD) or strstr($PHP_SELF, FILENAME_NEWSLETTER)) {
$vamTemplate->assign('2',' class="current"');
}

if (strstr($PHP_SELF, FILENAME_SHOPPING_CART)) {
$vamTemplate->assign('3',' class="current"');
}

if (strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING) or strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT) or strstr($PHP_SELF, FILENAME_CHECKOUT_CONFIRMATION) or strstr($PHP_SELF, FILENAME_CHECKOUT_SUCCESS)) {
$vamTemplate->assign('4',' class="current"');
}

if (strstr($PHP_SELF, FILENAME_LOGOFF)) {
$vamTemplate->assign('5',' class="current"');
}

if (strstr($PHP_SELF, FILENAME_LOGIN)) {
$vamTemplate->assign('6',' class="current"');
}

if ($_SESSION['customers_status']['customers_status_id'] == 0) {
$vamTemplate->assign('admin_area_link', vam_href_link_admin(FILENAME_START,'', 'SSL'));
}

$vamTemplate->assign('cart_count', $_SESSION['cart']->count_contents());
$vamTemplate->assign('cart_total', $_SESSION['cart']->show_total());
	
// /Метки для закладок

  include(DIR_WS_INCLUDES.FILENAME_BANNER);
?>