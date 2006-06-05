<?php
/* -----------------------------------------------------------------------------------------
   $Id: pm2checkout.php 998 2005-07-07 14:18:20Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(pm2checkout.php,v 1.4 2002/11/01); www.oscommerce.com 
   (c) 2003	 nextcommerce (pm2checkout.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_TITLE', '2CheckOut');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_DESCRIPTION', 'Kreditkarten Test Info:<br /><br />CC#: 4111111111111111<br />G&uuml;ltig bis: Any');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_TYPE', 'Typ:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_INFO','');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_OWNER', 'Kreditkarteninhaber:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_OWNER_FIRST_NAME', 'Kreditkarteninhaber Vorname:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_OWNER_LAST_NAME', 'Kreditkarteninhaber Nachname:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_NUMBER', 'Kreditkarten-Nr.:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_EXPIRES', 'G&uuml;ltig bis:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER', 'Karten-Pr&uuml;fnummer:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '(Auf der Kartenr&uuml;ckseite im Unterschriftsfeld)');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_JS_CC_NUMBER', '* Die \'Kreditkarten-Nr.\' muss mindestens aus ' . CC_NUMBER_MIN_LENGTH . ' Zahlen bestehen.\n');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_ERROR_MESSAGE', 'Bei der &Uuml;berp&uuml;fung Ihrer Kreditkarte ist ein Fehler aufgetreten! Bitte versuchen Sie es nochmal.');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_ERROR', 'Fehler bei der &Uuml;berp&uuml;fung der Kreditkarte!');
  
  define('MODULE_PAYMENT_PM2CHECKOUT_STATUS_TITLE' , '2CheckOut Modul aktivieren');
define('MODULE_PAYMENT_PM2CHECKOUT_STATUS_DESC' , 'M&ouml;chten Sie Zahlungen per 2CheckOut akzeptieren?');
define('MODULE_PAYMENT_PM2CHECKOUT_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_PM2CHECKOUT_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_PM2CHECKOUT_LOGIN_TITLE' , 'Anmelde/Shop Nummer');
define('MODULE_PAYMENT_PM2CHECKOUT_LOGIN_DESC' , 'Anmelde/Shop Nummer welche f&uuml;r 2CheckOut verwendet wird');
define('MODULE_PAYMENT_PM2CHECKOUT_TESTMODE_TITLE' , 'Transaktionsmodus');
define('MODULE_PAYMENT_PM2CHECKOUT_TESTMODE_DESC' , 'Transaktionsmodus, welcher f&uuml;r dieses Modul verwendet werden soll');
define('MODULE_PAYMENT_PM2CHECKOUT_EMAIL_MERCHANT_TITLE' , 'Merchant Benachrichtigungen');
define('MODULE_PAYMENT_PM2CHECKOUT_EMAIL_MERCHANT_DESC' , 'Soll 2CheckOut eine Best&auml;tigungs-eMail an den Shop-Besitzer senden?');
define('MODULE_PAYMENT_PM2CHECKOUT_SORT_ORDER_TITLE' , 'Anzeigereihenfolge');
define('MODULE_PAYMENT_PM2CHECKOUT_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_PM2CHECKOUT_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_PM2CHECKOUT_ZONE_DESC' , 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');
define('MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
?>