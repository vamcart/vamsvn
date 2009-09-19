<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_redirect.inc.php 1261 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_redirect.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_redirect.inc.php,v 1.5 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  // include needed functions
  
  require_once(DIR_FS_INC . 'vam_exit.inc.php');
  
  function vam_redirect($url) {

if (AJAX_CART == 'true') {
  global $_GET, $PHP_SELF, $_RESULT;
    if ( strpos( basename($PHP_SELF), 'ajax_shopping_cart.php')!==FALSE ) {
      if ( $url == vam_href_link(FILENAME_SSL_CHECK) ||
           $url == vam_href_link(FILENAME_LOGIN) ||
           $url == vam_href_link(FILENAME_COOKIE_USAGE) ||
           ( $_GET['action'] === 'buy_now' && vam_has_product_attributes($_GET['BUYproducts_id']) )
         ) {
        $_RESULT['ajax_redirect'] = $url;
//        vam_exit();
      }
      return;
    }
}

    if ( (ENABLE_SSL == true) && (getenv('HTTPS') == 'on' || getenv('HTTPS') == '1') ) { // We are loading an SSL page
	if (substr($url, 0, strlen(HTTP_SERVER)) == HTTP_SERVER) { // NONSSL url
	    $url = HTTPS_SERVER . substr($url, strlen(HTTP_SERVER)); // Change it to SSL
	}
    }
    
    header('Location: ' . preg_replace("/[\r\n]+(.*)$/i", "", $url));

    vam_exit();
    
  }
?>