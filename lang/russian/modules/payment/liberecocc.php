<?php
/*------------------------------------------------------------------------------
  $Id: liberecocc.php 998 2005-07-07 14:18:20Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
  -----------------------------------------------------------------------------
  based on:
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_TITLE', 'Credit Card');
  define('MODULE_PAYMENT_LIBERECOCC_TEXT_TITLE','Credit Card');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_DESCRIPTION', 'liberECO CC-Payment Modul<br />http://www.liberECO.net<br /><br />Credit Card Test Info:<br /><br />CC#: 4111111111111111<br />Expiry: Any');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_TYPE', 'Credit Card Type:');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_OWNER', 'Credit Card Owner:');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_NUMBER', 'Credit Card Number:');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_CVV_NUMBER', 'Cvv Number:');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_EXPIRES', 'Credit Card Expiry Date:');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_JS_CC_OWNER', '* The owner\'s name of the credit card must be at least ' . CC_OWNER_MIN_LENGTH . ' characters.\n');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_JS_CC_NUMBER', '* The credit card number must be at least ' . CC_NUMBER_MIN_LENGTH . ' characters.\n');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_JS_CVV_NUMBER', '* The cvv number must be at least ' . CVV_NUMBER_MIN_LENGTH . ' characters.\n');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_JS_MAX_CVV_NUMBER', '* The cvv number must be less than ' . CVV_NUMBER_MAX_LENGTH . ' characters.\n');
  define('TEXT_CVV_LINK', '<u>[help?]</u>');
  define('HEADING_CVV', 'Security Code Help Screen');
  define('TEXT_CVV', '<table align="center" cellspacing="2" cellpadding="5" width="400"><tr><td><span class="fancyText"><b>Visa, Mastercard, Discover 3 Digit Card Verification Number</b></span></td></tr><tr><td><span class="fancyText">For your safety and security, we require that you enter your card\'s verification number. The verification number is a 3-digit number printed on the back of your card. It appears after and to the right of your card number\'s last four digits.</span></td></tr><tr><td align="center"><IMG src="images/cv_card.gif"></td></tr></table><hr /><table align="center" cellspacing="2" cellpadding="5" width="400"><tr><td><span class="fancyText"><b>American Express 4 Digit Card Verification Number</b> </span></td></tr><tr><td><span class="fancyText">For your safety and security, we require that you enter your card\'s verification number. The American Express verification number is a 4-digit number printed on the front of your card. It appears after and to the right of your card number.</span></td></tr><tr><td align="center"><IMG src="images/cv_amex_card.gif"></td></tr></table>');
  define('TEXT_CLOSE_WINDOW', '<u>Close Window</u> [x]');
define('MODULE_PAYMENT_LIBERECCO_CC_TEXT_INFO','');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_ERROR', 'Credit Card Error!');

  define('TEXT_LIBERECO_CCVAL_ERROR_INVALID_DATE','Wrong Expiry Date!');


  define('MODULE_PAYMENT_LIBERECO_CC_STATUS_TITLE','Enable Credit Card Module');
  define('MODULE_PAYMENT_LIBERECO_CC_STATUS_DESC','Do you want to accept credit card payments?');

  define('MODULE_PAYMENT_LIBERECO_CC_EMAIL_TITLE','Split Credit Card E-Mail Address');
  define('MODULE_PAYMENT_LIBERECO_CC_EMAIL_DESC','If an e-mail address is entered, the middle digits of the credit card number will be sent to the e-mail address (the outside digits are stored in the database with the middle digits censored)');

  define('MODULE_PAYMENT_LIBERECO_CC_SORT_ORDER_TITLE','ѕор€док сортировки');
  define('MODULE_PAYMENT_LIBERECO_CC_SORT_ORDER_DESC','ѕор€док сортировки модул€.');

  define('MODULE_PAYMENT_LIBERECO_CC_ZONE_TITLE','«она');
  define('MODULE_PAYMENT_LIBERECO_CC_ZONE_DESC','≈сли выбрана зона, то данный модуль оплаты будет виден только покупател€м из выбранной зоны.');

  define('MODULE_PAYMENT_LIBERECO_CC_ORDER_STATUS_ID_TITLE','—татус заказа');
  define('MODULE_PAYMENT_LIBERECO_CC_ORDER_STATUS_ID_DESC','«аказы, оформленные с использованием данного модул€ оплаты будут принимать указанный статус.');

  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_TITLE', 'Creditcart');

  define('MODULE_PAYMENT_LIBERECOCC_ALLOWED_TITLE' , '–азрешЄнные страны');
  define('MODULE_PAYMENT_LIBERECOCC_ALLOWED_DESC' , '”кажите коды стран, дл€ которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупател€м из любых стран))');

  define('MODULE_PAYMENT_LIBERECO_CC_PAGENUMBER_TITLE','liberECO ID');
  define('MODULE_PAYMENT_LIBERECO_CC_PAGENUMBER_DESC','ID (5 Letters/Digits).');




?>
