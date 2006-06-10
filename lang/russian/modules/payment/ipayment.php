<?php
/* -----------------------------------------------------------------------------------------
   $Id: ipayment.php 998 2005-07-07 14:18:20Z VaM $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ipayment.php,v 1.6 2002/11/01); www.oscommerce.com 
   (c) 2003	 nextcommerce (ipayment.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_IPAYMENT_TEXT_TITLE', 'iPayment');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_DESCRIPTION', 'Credit Card Test Info:<br /><br />CC#: 4111111111111111<br />Expiry: Any');
  define('IPAYMENT_ERROR_HEADING', 'There has been an error processing your credit card:');
  define('IPAYMENT_ERROR_MESSAGE', 'Please check your credit card details!');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_OWNER', 'Credit Card Owner:');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_NUMBER', 'Credit Card Number:');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_EXPIRES', 'Credit Card Expiry Date:');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_CHECKNUMBER', 'Credit Card Checknumber');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '(located at the back of the credit card)');
define('MODULE_PAYMENT_IPAYMENT_TEXT_INFO','');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_JS_CC_OWNER', '* The owner\'s name of the credit card must be at least ' . CC_OWNER_MIN_LENGTH . ' characters.\n');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_JS_CC_NUMBER', '* The credit card number must be at least ' . CC_NUMBER_MIN_LENGTH . ' characters.\n');

  define('MODULE_PAYMENT_IPAYMENT_ALLOWED_TITLE' , '–азрешЄнные страны');
define('MODULE_PAYMENT_IPAYMENT_ALLOWED_DESC' , '”кажите коды стран, дл€ которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупател€м из любых стран))');
define('MODULE_PAYMENT_IPAYMENT_ID_TITLE' , 'Account Number');
define('MODULE_PAYMENT_IPAYMENT_ID_DESC' , 'The account number used for the iPayment service');
define('MODULE_PAYMENT_IPAYMENT_STATUS_TITLE' , 'Enable iPayment Module');
define('MODULE_PAYMENT_IPAYMENT_STATUS_DESC' , 'Do you want to accept iPayment payments?');
define('MODULE_PAYMENT_IPAYMENT_PASSWORD_TITLE' , 'User Password');
define('MODULE_PAYMENT_IPAYMENT_PASSWORD_DESC' , 'The user password for the iPayment service');
define('MODULE_PAYMENT_IPAYMENT_USER_ID_TITLE' , 'User ID');
define('MODULE_PAYMENT_IPAYMENT_USER_ID_DESC' , 'The user ID for the iPayment service');
define('MODULE_PAYMENT_IPAYMENT_CURRENCY_TITLE' , 'Transaction Currency');
define('MODULE_PAYMENT_IPAYMENT_CURRENCY_DESC' , 'The currency to use for credit card transactions');
define('MODULE_PAYMENT_IPAYMENT_SORT_ORDER_TITLE' , 'ѕор€док сортировки');
define('MODULE_PAYMENT_IPAYMENT_SORT_ORDER_DESC' , 'ѕор€док сортировки модул€.');
define('MODULE_PAYMENT_IPAYMENT_ZONE_TITLE' , '«она');
define('MODULE_PAYMENT_IPAYMENT_ZONE_DESC' , '≈сли выбрана зона, то данный модуль оплаты будет виден только покупател€м из выбранной зоны.');
define('MODULE_PAYMENT_IPAYMENT_ORDER_STATUS_ID_TITLE' , '—татус заказа');
define('MODULE_PAYMENT_IPAYMENT_ORDER_STATUS_ID_DESC' , '«аказы, оформленные с использованием данного модул€ оплаты будут принимать указанный статус.');
?>
