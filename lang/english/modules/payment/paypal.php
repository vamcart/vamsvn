<?php
/* -----------------------------------------------------------------------------------------
   $Id: paypal.php 998 2005-07-07 14:18:20Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(paypal.php,v 1.7 2002/04/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (paypal.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_PAYPAL_TEXT_TITLE', 'PayPal');
  define('MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', 'PayPal');
  define('MODULE_PAYMENT_PAYPAL_TEXT_INFO','');
  define('MODULE_PAYMENT_PAYPAL_ALLOWED_TITLE' , 'Allowed zones');
define('MODULE_PAYMENT_PAYPAL_ALLOWED_DESC' , 'Please enter the zones <b>separately</b> which should be allowed to use this modul (e. g. AT,DE (leave empty if you want to allow all zones))');
define('MODULE_PAYMENT_PAYPAL_STATUS_TITLE' , 'Enable PayPal Module');
define('MODULE_PAYMENT_PAYPAL_STATUS_DESC' , 'Do you want to accept PayPal payments?');
define('MODULE_PAYMENT_PAYPAL_ID_TITLE' , 'eMail Address');
define('MODULE_PAYMENT_PAYPAL_ID_DESC' , 'The eMail address to use for the PayPal service');
define('MODULE_PAYMENT_PAYPAL_CURRENCY_TITLE' , 'Transaction Currency');
define('MODULE_PAYMENT_PAYPAL_CURRENCY_DESC' , 'The currency to use for credit card transactions');
define('MODULE_PAYMENT_PAYPAL_SORT_ORDER_TITLE' , 'Sort order of display');
define('MODULE_PAYMENT_PAYPAL_SORT_ORDER_DESC' , 'Sort order of display. Lowest is displayed first.');
define('MODULE_PAYMENT_PAYPAL_ZONE_TITLE' , 'Payment Zone');
define('MODULE_PAYMENT_PAYPAL_ZONE_DESC' , 'If a zone is selected, only enable this payment method for that zone.');
define('MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID_TITLE' , 'Set Order Status');
define('MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID_DESC' , 'Set the status of orders made with this payment module to this value');
?>
