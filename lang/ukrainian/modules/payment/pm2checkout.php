<?php
/*
  $Id: pm2checkout.php 1793 2011-01-11 13:48:20Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2008 osCommerce

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_TITLE', '2Checkout');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_PUBLIC_TITLE', '2Checkout');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_PUBLIC_DESCRIPTION', 'Credit Cards and Alternatives');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_DESCRIPTION', '<img src="images/icon_popup.gif" border="0">&nbsp;<a href="https://www.2checkout.com/2co/signup" target="_blank" style="text-decoration: underline; font-weight: bold;">Visit 2Checkout Website</a>&nbsp;<a href="javascript:toggleDivBlock(\'pm2checkoutInfo\');">(info)</a><span id="pm2checkoutInfo" style="display: none;"><br><i>Using the above link to signup at 2Checkout grants osCommerce a small financial bonus for referring a customer.</i></span><br><br>Credit Card Test Info:<br><br>CC#: 4111111111111111<br>Expiry: Any');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_ERROR_MESSAGE', 'There has been an error processing your credit card. Please try again.');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_WARNING_DEMO_MODE', 'In Review: Transaction performed in demo mode.');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_WARNING_TRANSACTION_ORDER', 'In Review: Transaction total did not match order total.');
  
  define('MODULE_PAYMENT_PM2CHECKOUT_STATUS_TITLE', 'Enable 2CheckOut');
  define('MODULE_PAYMENT_PM2CHECKOUT_STATUS_DESC', 'Do you want to accept 2CheckOut payments?');
  define('MODULE_PAYMENT_PM2CHECKOUT_ALLOWED_TITLE', 'Разрешённые страны');
  define('MODULE_PAYMENT_PM2CHECKOUT_ALLOWED_DESC', 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
  define('MODULE_PAYMENT_PM2CHECKOUT_LOGIN_TITLE', 'Seller ID');
  define('MODULE_PAYMENT_PM2CHECKOUT_LOGIN_DESC', 'Seller ID used for the 2CheckOut service');
  define('MODULE_PAYMENT_PM2CHECKOUT_TESTMODE_TITLE', 'Transaction Mode');
  define('MODULE_PAYMENT_PM2CHECKOUT_TESTMODE_DESC', 'Transaction mode used for the 2Checkout service');
  define('MODULE_PAYMENT_PM2CHECKOUT_SECRET_WORD_TITLE', 'Secret Word');
  define('MODULE_PAYMENT_PM2CHECKOUT_SECRET_WORD_DESC', 'The secret word to confirm transactions with (must be the same as defined on the merchat account configuration page');
  define('MODULE_PAYMENT_PM2CHECKOUT_SORT_ORDER_TITLE', 'Sort Order');
  define('MODULE_PAYMENT_PM2CHECKOUT_SORT_ORDER_DESC', 'Sort order of display (lowest is displayed first)');
  define('MODULE_PAYMENT_PM2CHECKOUT_ZONE_TITLE', 'Payment Zone');
  define('MODULE_PAYMENT_PM2CHECKOUT_ZONE_DESC', 'If a zone is selected, only enable this payment method for that zone');
  define('MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID_TITLE', 'Set Order Status');
  define('MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID_DESC', 'Set the status of orders made with this payment module to this value');
  
  
?>