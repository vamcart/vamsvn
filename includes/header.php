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
<html lang="<?php echo $_SESSION['language_code']; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>" />
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<link rel="apple-touch-icon" href="<?php echo DIR_WS_CATALOG; ?>images/icons/vamshop-box-apple.png" />
<?php
if (DARK_THEME == 'true') {
?>
<link rel="manifest" href="<?php echo DIR_WS_CATALOG; ?>manifest.json" data-href-light="<?php echo DIR_WS_CATALOG; ?>manifest-light.json" data-href-dark="<?php echo DIR_WS_CATALOG; ?>manifest-dark.json">
<link rel="icon" href="<?php echo DIR_WS_CATALOG; ?>images/icons/vamshop-box-256.png" data-href-light="<?php echo DIR_WS_CATALOG; ?>images/icons/vamshop-box-256.png" data-href-dark="<?php echo DIR_WS_CATALOG; ?>images/icons/vamshop-box-256-dark.png" sizes="256x256">
<?php
} else {
?>
<link rel="manifest" href="<?php echo DIR_WS_CATALOG; ?>manifest.json">
<link rel="icon" href="<?php echo DIR_WS_CATALOG; ?>images/icons/vamshop-box-256.png" sizes="256x256">
<?php
}
?>
<?php include(DIR_WS_MODULES.FILENAME_METATAGS); ?>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />
<?php
if (file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/templates/'.CURRENT_TEMPLATE.'/css/css.php')) include('templates/'.CURRENT_TEMPLATE.'/css/css.php');
if (file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/templates/'.CURRENT_TEMPLATE.'/javascript/script.php')) include('templates/'.CURRENT_TEMPLATE.'/javascript/script.php');
?>
</head>
<body>
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
$vamTemplate->assign('main_current',' class="current"');
}

if (strstr($PHP_SELF, FILENAME_ACCOUNT) or strstr($PHP_SELF, FILENAME_ACCOUNT_EDIT) or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK)or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS) or strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY) or strstr($PHP_SELF, FILENAME_ACCOUNT_HISTORY_INFO) or strstr($PHP_SELF, FILENAME_ACCOUNT_PASSWORD) or strstr($PHP_SELF, FILENAME_NEWSLETTER)) {
$vamTemplate->assign('account_current',' class="current"');
}

if (strstr($PHP_SELF, FILENAME_SHOPPING_CART)) {
$vamTemplate->assign('cart_current',' class="current"');
}

if (strstr($PHP_SELF, FILENAME_WISHLIST)) {
$vamTemplate->assign('wishlist_current',' class="current"');
}

if (strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING) or strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT) or strstr($PHP_SELF, FILENAME_CHECKOUT_CONFIRMATION) or strstr($PHP_SELF, FILENAME_CHECKOUT_SUCCESS)) {
$vamTemplate->assign('checkout_current',' class="current"');
}

if (strstr($PHP_SELF, FILENAME_LOGOFF)) {
$vamTemplate->assign('logoff_current',' class="current"');
}

if (strstr($PHP_SELF, FILENAME_LOGIN)) {
$vamTemplate->assign('login_current',' class="current"');
}

if ($_SESSION['customers_status']['customers_status_id'] == 0) {
$vamTemplate->assign('admin_area_link', vam_href_link_admin(FILENAME_START,'', 'SSL'));
}

$vamTemplate->assign('cart_count', $_SESSION['cart']->count_contents());
$vamTemplate->assign('cart_total', $_SESSION['cart']->show_total());

$vamTemplate->assign('wishlist_count', $_SESSION['wishlist']->count_contents());
$vamTemplate->assign('wishlist_total', $_SESSION['wishlist']->show_total());

$vamTemplate->assign('current_category_id', $current_category_id);
	
// /Метки для закладок

  include(DIR_WS_INCLUDES.FILENAME_BANNER);
?>