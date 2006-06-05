<?php
/* -----------------------------------------------------------------------------------------
   $Id: ipayment.php 998 2005-07-07 14:18:20Z mz $   

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
  define('MODULE_PAYMENT_IPAYMENT_TEXT_DESCRIPTION', 'Kreditkarten Test Info:<br /><br />CC#: 4111111111111111<br />G&uuml;ltig bis: Any');
    define('MODULE_PAYMENT_IPAYMENT_TEXT_INFO','');
  define('IPAYMENT_ERROR_HEADING', 'Folgender Fehler wurde von iPayment w&auml;hrend des Prozesses gemeldet:');
  define('IPAYMENT_ERROR_MESSAGE', 'Bitte kontrollieren Sie die Daten Ihrer Kreditkarte!');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_OWNER', 'Kreditkarteninhaber');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_NUMBER', 'Kreditkarten-Nr.:');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_EXPIRES', 'G&uuml;ltig bis:');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_CHECKNUMBER', 'Karten-Pr&uuml;fnummer');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '(Auf der Kartenr&uuml;ckseite im Unterschriftsfeld)');

  define('MODULE_PAYMENT_IPAYMENT_TEXT_JS_CC_OWNER', '* Der Name des Kreditkarteninhabers mss mindestens aus  ' . CC_OWNER_MIN_LENGTH . ' Zeichen bestehen.\n');
  define('MODULE_PAYMENT_IPAYMENT_TEXT_JS_CC_NUMBER', '* Die \'Kreditkarten-Nr.\' muss mindestens aus ' . CC_NUMBER_MIN_LENGTH . ' Zahlen bestehen.\n');
  
  define('MODULE_PAYMENT_IPAYMENT_ALLOWED_TITLE' , 'Erlaubte Zonen');
define('MODULE_PAYMENT_IPAYMENT_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
define('MODULE_PAYMENT_IPAYMENT_ID_TITLE' , 'Kundennummer');
define('MODULE_PAYMENT_IPAYMENT_ID_DESC' , 'Kundennummer, welche f&uuml;r iPayment verwendet wird');
define('MODULE_PAYMENT_IPAYMENT_STATUS_TITLE' , 'iPayment Modul aktivieren');
define('MODULE_PAYMENT_IPAYMENT_STATUS_DESC' , 'M&ouml;chten Sie Zahlungen per iPayment akzeptieren?');
define('MODULE_PAYMENT_IPAYMENT_PASSWORD_TITLE' , 'Benutzer-Passwort');
define('MODULE_PAYMENT_IPAYMENT_PASSWORD_DESC' , 'Benutzer-Passwort welches f&uuml;r iPayment verwendet wird');
define('MODULE_PAYMENT_IPAYMENT_USER_ID_TITLE' , 'Benutzer ID');
define('MODULE_PAYMENT_IPAYMENT_USER_ID_DESC' , 'Benutzer ID welche f&uuml;r iPayment verwendet wird');
define('MODULE_PAYMENT_IPAYMENT_CURRENCY_TITLE' , 'Transaktionswährung');
define('MODULE_PAYMENT_IPAYMENT_CURRENCY_DESC' , 'W&auml;hrung, welche f&uuml;r Kreditkartentransaktionen verwendet wird');
define('MODULE_PAYMENT_IPAYMENT_SORT_ORDER_TITLE' , 'Anzeigereihenfolge');
define('MODULE_PAYMENT_IPAYMENT_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_IPAYMENT_ZONE_TITLE' , 'Zahlungszone');
define('MODULE_PAYMENT_IPAYMENT_ZONE_DESC' , 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');
define('MODULE_PAYMENT_IPAYMENT_ORDER_STATUS_ID_TITLE' , 'Bestellstatus festlegen');
define('MODULE_PAYMENT_IPAYMENT_ORDER_STATUS_ID_DESC' , 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
?>