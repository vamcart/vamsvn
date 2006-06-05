<?php
/* -----------------------------------------------------------------------------------------
   $Id: secpay.php 998 2005-07-07 14:18:20Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce 
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(secpay.php,v 1.8 2002/11/01); www.oscommerce.com 
   (c) 2003	 nextcommerce (secpay.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_SECPAY_TEXT_TITLE', 'SECPay');
  define('MODULE_PAYMENT_SECPAY_TEXT_DESCRIPTION', 'Kreditkarten Test Info:<br /><br />CC#: 4444333322221111<br />G&uuml;ltig bis: Jederzeit');
  define('MODULE_PAYMENT_SECPAY_TEXT_ERROR', 'Fehler bei der &Uuml;berp&uuml;fung der Kreditkarte!');
  define('MODULE_PAYMENT_SECPAY_TEXT_ERROR_MESSAGE', 'Bei der &Uuml;berp&uuml;fung Ihrer Kreditkarte ist ein Fehler aufgetreten! Bitte versuchen Sie es nochmal.');
  define('MODULE_PAYMENT_SECPAY_TEXT_INFO','');
  define('MODULE_PAYMENT_SECPAY_MERCHANT_ID_TITLE' , 'Merchant ID');
define('MODULE_PAYMENT_SECPAY_MERCHANT_ID_DESC' , 'Merchant ID f&uuml;r den SECPay Service');
define('MODULE_PAYMENT_SECPAY_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_SECPAY_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_SECPAY_STATUS_TITLE' , 'SECpay Modul aktivieren');
define('MODULE_PAYMENT_SECPAY_STATUS_DESC' , 'M&ouml;chten Sie Zahlungen per SECPay akzeptieren?');
define('MODULE_PAYMENT_SECPAY_CURRENCY_TITLE' , 'Transaktionsw&auml;hrung');
define('MODULE_PAYMENT_SECPAY_CURRENCY_DESC' , 'Die W&auml;hrung, die f&uuml;r Kreditkartentransaktionen verwendet wird');
define('MODULE_PAYMENT_SECPAY_TEST_STATUS_TITLE' , 'Transaktionsmodus');
define('MODULE_PAYMENT_SECPAY_TEST_STATUS_DESC' , 'Transaktionsmodus, welcher f&uuml;r dieses Modul verwendet werden soll');
define('MODULE_PAYMENT_SECPAY_SORT_ORDER_TITLE' , 'Anzeigereihenfolge');
define('MODULE_PAYMENT_SECPAY_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_SECPAY_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_SECPAY_ZONE_DESC' , 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');
define('MODULE_PAYMENT_SECPAY_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_SECPAY_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen.');
?>