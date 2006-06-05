<?php
/* -----------------------------------------------------------------------------------------
   $Id: coupon_admin.php 899 2005-04-29 02:40:57Z hhgag $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(Kupon_admin.php,v 1.1.2.2 2003/05/15); www.oscommerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:

   Credit Class/Gift Vouchers/Discount Kupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('TOP_BAR_TITLE', 'Statistik');
define('HEADING_TITLE', 'Rabatt Kupons');
define('HEADING_TITLE_STATUS', 'Status : ');
define('TEXT_CUSTOMER', 'Kunde:');
define('TEXT_COUPON', 'Kupon Name');
define('TEXT_COUPON_ALL', 'Alle Kupons');
define('TEXT_COUPON_ACTIVE', 'Aktive Kupons');
define('TEXT_COUPON_INACTIVE', 'Inaktive Kupons');
define('TEXT_SUBJECT', 'Betreff:');
define('TEXT_FROM', 'von:');
define('TEXT_FREE_SHIPPING', 'Versandkostenfrei');
define('TEXT_MESSAGE', 'Nachricht:');
define('TEXT_SELECT_CUSTOMER', 'Kunde ausw&auml;hlen');
define('TEXT_ALL_CUSTOMERS', 'Alle Kunden');
define('TEXT_NEWSLETTER_CUSTOMERS', 'Alle Newsletter Abonnenten');
define('TEXT_CONFIRM_DELETE', 'Soll dieser Kupon wirklich gel&ouml;scht werden?');

define('TEXT_TO_REDEEM', 'Sie k&ouml;nnen den Gutschein bei Ihrer Bestellung einl&ouml;sen. Dazu geben Sie Ihren Gutschein-Code in das daf&uuml;r vorgesehene Feld ein, und klicken Sie den "Einl&ouml;sen"-Button.');
define('TEXT_IN_CASE', ' Falls es wider Erwarten zu Problemen beim verbuchen kommen sollte.');
define('TEXT_VOUCHER_IS', 'Ihr Gutschein-Code lautet: ');
define('TEXT_REMEMBER', 'Bewahren Sie Ihren Gutschein-Code gut auf, damit Sie von diesem Angebot profitieren k&ouml;nnen');
define('TEXT_VISIT', 'wenn Sie uns das n&auml;chste mal unter ' . HTTP_SERVER . DIR_WS_CATALOG. ' besuchen.');
define('TEXT_ENTER_CODE', ' und den Code eingeben ');

define('TABLE_HEADING_ACTION', 'Aktion');

define('CUSTOMER_ID', 'Kunden Nr.');
define('CUSTOMER_NAME', 'Kunden Name');
define('REDEEM_DATE', 'eingel&ouml;st am');
define('IP_ADDRESS', 'IP Adresse');

define('TEXT_REDEMPTIONS', 'Einl&ouml;sung');
define('TEXT_REDEMPTIONS_TOTAL', 'Insgesamt');
define('TEXT_REDEMPTIONS_CUSTOMER', 'F&uuml;r diesen Kunden');
define('TEXT_NO_FREE_SHIPPING', 'Nicht Versandkostenfrei');

define('NOTICE_EMAIL_SENT_TO', 'Notiz: eMail versendet an: %s');
define('ERROR_NO_CUSTOMER_SELECTED', 'Fehler: Kein Kunde ausgew&auml;hlt.');
define('COUPON_NAME', 'Kupon Name');
//define('Kupon_VALUE', 'Kupon Wert');
define('COUPON_AMOUNT', 'Kupon Wert');
define('COUPON_CODE', 'Kupon Code');
define('COUPON_STARTDATE', 'g&uuml;ltig ab');
define('COUPON_FINISHDATE', 'g&uuml;ltig bis');
define('COUPON_FREE_SHIP', 'Versandkostenfrei');
define('COUPON_DESC', 'Kupon Beschreibung');
define('COUPON_MIN_ORDER', 'Kupon Mindestbestellwert');
define('COUPON_USES_COUPON', 'Anzahl/Verwendungen pro Kupon');
define('COUPON_USES_USER', 'Anzahl/Verwendungen pro Kunde');
define('COUPON_PRODUCTS', 'Liste der g&uuml;ltigen Artikel');
define('COUPON_CATEGORIES', 'Liste der g&uuml;ltigen Kategorien');
define('VOUCHER_NUMBER_USED', 'Anzahl Verwendet');
define('DATE_CREATED', 'erstellt am');
define('DATE_MODIFIED', 'ge&auml;ndert am');
define('TEXT_HEADING_NEW_COUPON', 'Neuen Kupon erstellen');
define('TEXT_NEW_INTRO', 'Bitte geben Sie die folgende Informationen f&uuml;r den neuen Kupon an.<br>');


define('COUPON_NAME_HELP', 'Eine Kurzbezeichnung f&uuml;r den Kupon');
define('COUPON_AMOUNT_HELP', 'Tragen Sie hier den Rabatt für diesen Kupon ein. Entweder einen festen Betrag oder einen prozentualen Rabatt wie z.B. 10%');
define('COUPON_CODE_HELP', 'Hier k&ouml;nnen Sie einen eigenen Code eintragen (max. 16 Zeichen). Lassen Sie das Feld frei, dann wird dieser Code automatisch generiert.');
define('COUPON_STARTDATE_HELP', 'Das Datum ab dem der Kupon g&uuml;ltig ist');
define('COUPON_FINISHDATE_HELP', 'Das Datium an dem der Kupon abl&auml;uft');
define('COUPON_FREE_SHIP_HELP', 'Kupon für eine versandkostenfreie Lieferung. <b>Achtung:</b> Der Kupon Wert wird dabei nicht mehr ber&uuml;cksichtigt! Der Mindestbestellwert bleibt g&uuml;ltig.');
define('COUPON_DESC_HELP', 'Beschreibung des Kupons für den Kunden');
define('COUPON_MIN_ORDER_HELP', 'Mindestbestellwert ab dem dieser Kupon g&uuml;ltig ist');
define('COUPON_USES_COUPON_HELP', 'Tragen Sie hier ein wie oft dieser Kupon eingel&ouml;st werden darf. Lassen Sie das Feld frei, dann ist die Benutzung unlimitiert.');
define('COUPON_USES_USER_HELP', 'Tragen Sie hier ein wie oft ein Kunde diesen Kupon einl&ouml;sen darf. Lassen Sie das Feld frei, dann ist die Benutzung unlimitiert.');
define('COUPON_PRODUCTS_HELP', 'Eine durch Komma getrennte Liste von product_ids für die dieser Kupon g&uuml;ltig ist. Ein leeres Feld bedeutet keine Einschr&auml;nkung.');
define('COUPON_CATEGORIES_HELP', 'Eine durch Komma getrennte Liste von Kategorien (cpaths) für die dieser Kupon g&uuml;ltig ist. Ein leeres Feld bedeutet keine Einschr&auml;nkung.');
?>