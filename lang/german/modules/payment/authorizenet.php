<?php

/* -----------------------------------------------------------------------------------------
   $Id: authorizenet.php 1003 2005-07-10 18:58:52Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(authorizenet.php,v 1.15 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (authorizenet.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------*/
define('MODULE_PAYMENT_TYPE_PERMISSION', 'cod');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_TITLE', 'Authorize.net');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_DESCRIPTION', 'Kreditkarten Test Info:<br /><br />CC#: 4111111111111111<br />G&uuml;ltig bis: Jederzeit');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_INFO', '');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_TYPE', 'Typ:');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_OWNER', 'Kreditkarteninhaber:');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_NUMBER', 'Kreditkarten-Nr.:');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_EXPIRES', 'G&uuml;ltig bis:');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_JS_CC_OWNER', '* Der Name des Kreditkarteninhabers muss mindestens aus  '.CC_OWNER_MIN_LENGTH.' Zeichen bestehen.\n');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_JS_CC_NUMBER', '* Die \'Kreditkarten-Nr.\' muss mindestens aus '.CC_NUMBER_MIN_LENGTH.' Zahlen bestehen.\n');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_ERROR_MESSAGE', 'Bei der &Uuml;berp&uuml;fung Ihrer Kreditkarte ist ein Fehler aufgetreten! Bitte versuchen Sie es nochmal.');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_DECLINED_MESSAGE', 'Ihre Kreditkarte wurde abgelehnt. Bitte versuchen Sie es mit einer anderen Karte oder kontaktieren Sie Ihre Bank f&uuml;r weitere Informationen.');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_ERROR', 'Fehler bei der &Uuml;berp&uuml;fung der Kreditkarte!');
define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Das "G&uuml;ltig bis" Datum ist ung&uuml;ltig. Bitte korrigieren Sie Ihre Angaben.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Die "Kreditkarten-Nummer", die Sie angegeben haben, ist ung&uuml;ltig. Bitte korrigieren Sie Ihre Angaben.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Die ersten 4 Ziffern Ihrer Kreditkarte sind: %s Wenn diese Angaben stimmen, wird dieser Kartentyp leider nicht akzeptiert. Bitte korrigieren Sie Ihre Angaben gegebenfalls.');

define('MODULE_PAYMENT_AUTHORIZENET_TXNKEY_TITLE', 'Transaktionschl&uuml;ssel');
define('MODULE_PAYMENT_AUTHORIZENET_TXNKEY_DESC', 'Transaktionschl&uuml;ssel welcher zum Verschl&uuml;sseln von TP Daten verwendet wird');
define('MODULE_PAYMENT_AUTHORIZENET_TESTMODE_TITLE', 'Transaktionsmodus');
define('MODULE_PAYMENT_AUTHORIZENET_TESTMODE_DESC', 'Transaktionsmodus, welcher f&uuml;r dieses Modul verwendet werden soll');
define('MODULE_PAYMENT_AUTHORIZENET_METHOD_TITLE', 'Transaktions Methode');
define('MODULE_PAYMENT_AUTHORIZENET_METHOD_DESC', 'Transaktions Methode, welche f&uuml;r dieses Modul verwendet werden soll');
define('MODULE_PAYMENT_AUTHORIZENET_EMAIL_CUSTOMER_TITLE', 'Kundenbenachrichtigungen');
define('MODULE_PAYMENT_AUTHORIZENET_EMAIL_CUSTOMER_DESC', 'Soll Authorize.Net eine Best&auml;tigungs-eMail an den Kunden senden?');
define('MODULE_PAYMENT_AUTHORIZENET_STATUS_TITLE', 'Authorize.net Modul aktivieren');
define('MODULE_PAYMENT_AUTHORIZENET_STATUS_DESC', 'M&ouml;chten Sie Zahlungen per Authorize.net akzeptieren?');
define('MODULE_PAYMENT_AUTHORIZENET_LOGIN_TITLE', 'Anmelde-Benutzernamename');
define('MODULE_PAYMENT_AUTHORIZENET_LOGIN_DESC', 'Anmelde-Benutzernamename, welcher f&uuml;r das Authorize.net Service verwendet wird');
define('MODULE_PAYMENT_AUTHORIZENET_ORDER_STATUS_ID_TITLE', 'Bestellstatus festlegen');
define('MODULE_PAYMENT_AUTHORIZENET_ORDER_STATUS_ID_DESC', 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
define('MODULE_PAYMENT_AUTHORIZENET_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_AUTHORIZENET_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_AUTHORIZENET_ZONE_TITLE', 'Zahlungszone');
define('MODULE_PAYMENT_AUTHORIZENET_ZONE_DESC', 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');
define('MODULE_PAYMENT_AUTHORIZENET_ALLOWED_TITLE', 'Erlaubte Zonen');
define('MODULE_PAYMENT_AUTHORIZENET_ALLOWED_DESC', 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
?>