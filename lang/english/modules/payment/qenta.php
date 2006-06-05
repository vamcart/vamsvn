<?php
/* -----------------------------------------------------------------------------------------
   $Id: qenta.php

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   qenta v1.0          Andreas Oberzier <xtc@netz-designer.de>

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_QENTA_TEXT_TITLE', 'qenta.at');
  define('MODULE_PAYMENT_QENTA_TEXT_DESCRIPTION', 'qenta.at');
  define('MODULE_PAYMENT_QENTA_TEXT_ERROR', 'Zahlungsfehler!');
  define('MODULE_PAYMENT_QENTA_ERROR', 'Ihre Zahlung war leider ungültig!');
define('MODULE_PAYMENT_QENTA_TEXT_INFO','');
  define('MODULE_PAYMENT_QENTA_STATUS_TITLE','Enable Qenta Module');
  define('MODULE_PAYMENT_QENTA_STATUS_DESC','Do you want to accept qenta.at payments?');
  define('MODULE_PAYMENT_QENTA_MERCHANTKEY_TITLE','Your MerchantKey');
  define('MODULE_PAYMENT_QENTA_MERCHANTKEY_DESC','Merchant\'s Key you received from qenta.at');
  define('MODULE_PAYMENT_QENTA_PAYMENTTYPE_TITLE','qenta\'s paymenttype');
  define('MODULE_PAYMENT_QENTA_PAYMENTTYPE_DESC','Enter the qenta-paymenttype you want to offer your customers.');
  define('MODULE_PAYMENT_QENTA_IMAGEURL_TITLE','Image URL');
  define('MODULE_PAYMENT_QENTA_IMAGEURL_DESC','Enter the image URL of your logo you want to add to your qenta-pamentsite. Mak shure your image exists');
  define('MODULE_PAYMENT_QENTA_SECRET_TITLE','Secret');
  define('MODULE_PAYMENT_QENTA_SECRET_DESC','Enter the secret string you confirmed with qenta for the fingerprint-hash.');
  define('MODULE_PAYMENT_QENTA_SORT_ORDER_TITLE','Sort order of display.');
  define('MODULE_PAYMENT_QENTA_SORT_ORDER_DESC','Sort order of display. Lowest is displayed first.');
  define('MODULE_PAYMENT_QENTA_CURRENCY_TITLE','Transaction Currency');
  define('MODULE_PAYMENT_QENTA_CURRENCY_DESC','Select the default currency for the payment transactions. If the user selected currency is not available at moneybookers.com, this currency will be the payment currency.');
  define('MODULE_PAYMENT_QENTA_LANGUAGE_TITLE','Transaction Language');
  define('MODULE_PAYMENT_QENTA_LANGUAGE_DESC','Select the default language for the payment transactions. If the user selected language is not available at moneybookers.com, this currency will be the payment language.');
  define('MODULE_PAYMENT_QENTA_ZONE_TITLE','Payment Zone');
  define('MODULE_PAYMENT_QENTA_ZONE_DESC','If a zone is selected, only enable this payment method for that zone.');
  define('MODULE_PAYMENT_QENTA_ORDER_STATUS_ID_TITLE','Set Order Status');
  define('MODULE_PAYMENT_QENTA_ORDER_STATUS_ID_DESC','Set the status of orders made with this payment module to this value');
  ?>
