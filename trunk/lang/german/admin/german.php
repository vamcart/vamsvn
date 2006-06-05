<?php
/* --------------------------------------------------------------
   $Id: german.php 905 2005-04-29 13:02:06Z novalis $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(german.php,v 1.99 2003/05/28); www.oscommerce.com 
   (c) 2003  nextcommerce (german.php,v 1.24 2003/08/24); www.nextcommerce.org

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contributions:
   Customers Status v3.x (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

// look in your $PATH_LOCALE/locale directory for available locales..
// on RedHat6.0 I used 'de_DE'
// on FreeBSD 4.0 I use 'de_DE.ISO_8859-1'
// this may not work under win32 environments..
setlocale(LC_TIME, 'de_DE@euro', 'de_DE', 'de-DE', 'de', 'ge', 'de_DE.ISO_8859-1', 'German','de_DE.ISO_8859-15');
define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
define('PHP_DATE_TIME_FORMAT', 'd.m.Y H:i:s'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function xtc_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
  }
}

// Global entries for the <html> tag
define('HTML_PARAMS','dir="ltr" lang="de"');


// page title
define('TITLE', 'XT-Commerce');

// header text in includes/header.php
define('HEADER_TITLE_TOP', 'Administration');
define('HEADER_TITLE_SUPPORT_SITE', 'Supportseite');
define('HEADER_TITLE_ONLINE_CATALOG', 'Online Katalog');
define('HEADER_TITLE_ADMINISTRATION', 'Administration');

// text for gender
define('MALE', 'Herr');
define('FEMALE', 'Frau');

// text for date of birth example
define('DOB_FORMAT_STRING', 'tt.mm.jjjj');

// configuration box text in includes/boxes/configuration.php

define('BOX_HEADING_CONFIGURATION','Konfiguration');
define('BOX_HEADING_MODULES','Module');
define('BOX_HEADING_ZONE','Land / Steuer');
define('BOX_HEADING_CUSTOMERS','Kunden');
define('BOX_HEADING_PRODUCTS','Artikelkatalog');
define('BOX_HEADING_STATISTICS','Statistiken');
define('BOX_HEADING_TOOLS','Hilfsprogramme');

define('BOX_CONTENT','Content Manager');
define('TEXT_ALLOWED', 'Erlaubnis');
define('TEXT_ACCESS', 'Zugriffsbereich');
define('BOX_CONFIGURATION', 'Grundeinstellungen');
define('BOX_CONFIGURATION_1', 'Mein Shop');
define('BOX_CONFIGURATION_2', 'Minumum Werte');
define('BOX_CONFIGURATION_3', 'Maximum Werte');
define('BOX_CONFIGURATION_4', 'Bild Optionen');
define('BOX_CONFIGURATION_5', 'Kunden Details');
define('BOX_CONFIGURATION_6', 'Modul Optionen');
define('BOX_CONFIGURATION_7', 'Versand Optionen');
define('BOX_CONFIGURATION_8', 'Artikel Listen Optionen');
define('BOX_CONFIGURATION_9', 'Lagerverwaltungs Optionen');
define('BOX_CONFIGURATION_10', 'Logging Optionen');
define('BOX_CONFIGURATION_11', 'Cache Optionen');
define('BOX_CONFIGURATION_12', 'eMail Optionen');
define('BOX_CONFIGURATION_13', 'Download Optionen');
define('BOX_CONFIGURATION_14', 'Gzip Kompression');
define('BOX_CONFIGURATION_15', 'Sessions');
define('BOX_CONFIGURATION_16', 'Meta-Tags/Suchmaschinen');
define('BOX_CONFIGURATION_17', 'Zusatzmodule');
define('BOX_CONFIGURATION_18', 'UST ID');
define('BOX_CONFIGURATION_19', 'xt:C Partner');
define('BOX_CONFIGURATION_22', 'Such-Optionen');

define('BOX_MODULES', 'Zahlungs-/Versand-/Verrechnungs-Module');
define('BOX_PAYMENT', 'Zahlungsoptionen');
define('BOX_SHIPPING', 'Versandart');
define('BOX_ORDER_TOTAL', 'Zusammenfassung');
define('BOX_CATEGORIES', 'Kategorien / Artikel');
define('BOX_PRODUCTS_ATTRIBUTES', 'Artikelmerkmale');
define('BOX_MANUFACTURERS', 'Hersteller');
define('BOX_REVIEWS', 'Artikelbewertungen');
define('BOX_CAMPAIGNS', 'Kampagnen');
define('BOX_XSELL_PRODUCTS', 'Cross Marketing');
define('BOX_SPECIALS', 'Sonderangebote');
define('BOX_PRODUCTS_EXPECTED', 'Erwartete Artikel');
define('BOX_CUSTOMERS', 'Kunden');
define('BOX_ACCOUNTING', 'Adminrechte Verwaltung');
define('BOX_CUSTOMERS_STATUS','Kundengruppen');
define('BOX_ORDERS', 'Bestellungen');
define('BOX_COUNTRIES', 'Land');
define('BOX_ZONES', 'Bundesl&auml;nder');
define('BOX_GEO_ZONES', 'Steuerzonen');
define('BOX_TAX_CLASSES', 'Steuerklassen');
define('BOX_TAX_RATES', 'Steuers&auml;tze');
define('BOX_HEADING_REPORTS', 'Berichte');
define('BOX_PRODUCTS_VIEWED', 'Besuchte Artikel');
define('BOX_STOCK_WARNING','Lager Bericht');
define('BOX_PRODUCTS_PURCHASED', 'Verkaufte Artikel');
define('BOX_STATS_CUSTOMERS', 'Kunden-<br />&nbsp;Bestellstatistik');
define('BOX_BACKUP', 'Datenbank Manager');
define('BOX_BANNER_MANAGER', 'Banner Manager');
define('BOX_CACHE', 'Cache Steuerung');
define('BOX_DEFINE_LANGUAGE', 'Sprachen definieren');
define('BOX_FILE_MANAGER', 'Datei-Manager');
define('BOX_MAIL', 'eMail versenden');
define('BOX_NEWSLETTERS', 'Rundschreiben Manager');
define('BOX_SERVER_INFO', 'Server Info');
define('BOX_WHOS_ONLINE', 'Wer ist Online');
define('BOX_TPL_BOXES','Box Reihenfolge');
define('BOX_CURRENCIES', 'W&auml;hrungen');
define('BOX_LANGUAGES', 'Sprachen');
define('BOX_ORDERS_STATUS', 'Bestellstatus');
define('BOX_ATTRIBUTES_MANAGER','Attribut Verwaltung');
define('BOX_PRODUCTS_ATTRIBUTES','Optionsgruppen');
define('BOX_ORDERS_STATUS','Bestellstatus');
define('BOX_SHIPPING_STATUS','Lieferstatus');
define('BOX_SALES_REPORT','Umsatzstatistik');
define('BOX_MODULE_EXPORT','XT-Module');
define('BOX_HEADING_GV_ADMIN', 'Gutscheine/Kupons');
define('BOX_GV_ADMIN_QUEUE', 'Gutschein Queue');
define('BOX_GV_ADMIN_MAIL', 'Gutschein eMail');
define('BOX_GV_ADMIN_SENT', 'Gutscheine versandt');
define('BOX_HEADING_COUPON_ADMIN','Rabattkupons');
define('BOX_COUPON_ADMIN','Kupon Admin');
define('BOX_TOOLS_BLACKLIST','-CC-Blacklist');
define('BOX_IMPORT','Import/Export');
define('BOX_PRODUCTS_VPE','Verpackungseinheit');
define('BOX_CAMPAIGNS_REPORT','Kampagnen Report');
define('BOX_ORDERS_XSELL_GROUP','Cross-Marketing Gruppen');

define('TXT_GROUPS','<b>Gruppen</b>:');
define('TXT_SYSTEM','System');
define('TXT_CUSTOMERS','Kunden/Bestellungen');
define('TXT_PRODUCTS','Artikel/Kategorien');
define('TXT_STATISTICS','Statistiktools');
define('TXT_TOOLS','Zusatzprogramme');
define('TEXT_ACCOUNTING','Zugriffseinstellungen f&uuml;r:');

//Dividers text for menu

define('BOX_HEADING_MODULES', 'Module');
define('BOX_HEADING_LOCALIZATION', 'Sprachen/W&auml;hrungen');
define('BOX_HEADING_TEMPLATES','Templates');
define('BOX_HEADING_TOOLS', 'Hilfsprogramme');
define('BOX_HEADING_LOCATION_AND_TAXES', 'Land / Steuer');
define('BOX_HEADING_CUSTOMERS', 'Kunden');
define('BOX_HEADING_CATALOG', 'Katalog');
define('BOX_MODULE_NEWSLETTER','Rundschreiben');

// javascript messages
define('JS_ERROR', 'W&auml;hrend der Eingabe sind Fehler aufgetreten!\nBitte korrigieren Sie folgendes:\n\n');

define('JS_OPTIONS_VALUE_PRICE', '* Sie m&uuml;ssen diesem Wert einen Preis zuordnen\n');
define('JS_OPTIONS_VALUE_PRICE_PREFIX', '* Sie m&uuml;ssen ein Vorzeichen f&uuml;r den Preis angeben (+/-)\n');

define('JS_PRODUCTS_NAME', '* Der neue Artikel muss einen Namen haben\n');
define('JS_PRODUCTS_DESCRIPTION', '* Der neue Artikel muss eine Beschreibung haben\n');
define('JS_PRODUCTS_PRICE', '* Der neue Artikel muss einen Preis haben\n');
define('JS_PRODUCTS_WEIGHT', '* Der neue Artikel muss eine Gewichtsangabe haben\n');
define('JS_PRODUCTS_QUANTITY', '* Sie m&uuml;ssen dem neuen Artikel eine verf&uuml;gbare Anzahl zuordnen\n');
define('JS_PRODUCTS_MODEL', '* Sie m&uuml;ssen dem neuen Artikel eine Artikel-Nr. zuordnen\n');
define('JS_PRODUCTS_IMAGE', '* Sie m&uuml;ssen dem Artikel ein Bild zuordnen\n');

define('JS_SPECIALS_PRODUCTS_PRICE', '* Es muss ein neuer Preis f&uuml;r diesen Artikel festgelegt werden\n');

define('JS_GENDER', '* Die \'Anrede\' muss ausgew&auml;hlt werden.\n');
define('JS_FIRST_NAME', '* Der \'Vorname\' muss mindestens aus ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_LAST_NAME', '* Der \'Nachname\' muss mindestens aus ' . ENTRY_LAST_NAME_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_DOB', '* Das \'Geburtsdatum\' muss folgendes Format haben: xx.xx.xxxx (Tag/Jahr/Monat).\n');
define('JS_EMAIL_ADDRESS', '* Die \'eMail-Adresse\' muss mindestens aus ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_ADDRESS', '* Die \'Strasse\' muss mindestens aus ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_POST_CODE', '* Die \'Postleitzahl\' muss mindestens aus ' . ENTRY_POSTCODE_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_CITY', '* Die \'Stadt\' muss mindestens aus ' . ENTRY_CITY_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_STATE', '* Das \'Bundesland\' muss ausgew&uuml;hlt werden.\n');
define('JS_STATE_SELECT', '-- W&auml;hlen Sie oberhalb --');
define('JS_ZONE', '* Das \'Bundesland\' muss aus der Liste f&uuml;r dieses Land ausgew&auml;hlt werden.');
define('JS_COUNTRY', '* Das \'Land\' muss ausgew&auml;hlt werden.\n');
define('JS_TELEPHONE', '* Die \'Telefonnummer\' muss aus mindestens ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Zeichen bestehen.\n');
define('JS_PASSWORD', '* Das \'Passwort\' sowie die \'Passwortbest&auml;tigung\' m&uuml;ssen &uuml;bereinstimmen und aus mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen bestehen.\n');

define('JS_ORDER_DOES_NOT_EXIST', 'Auftragsnummer %s existiert nicht!');

define('CATEGORY_PERSONAL', 'Pers&ouml;nliche Daten');
define('CATEGORY_ADDRESS', 'Adresse');
define('CATEGORY_CONTACT', 'Kontakt');
define('CATEGORY_COMPANY', 'Firma');
define('CATEGORY_OPTIONS', 'Weitere Optionen');

define('ENTRY_GENDER', 'Anrede:');
define('ENTRY_GENDER_ERROR', '&nbsp;<span class="errorText">notwendige Eingabe</span>');
define('ENTRY_FIRST_NAME', 'Vorname:');
define('ENTRY_FIRST_NAME_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_LAST_NAME', 'Nachname:');
define('ENTRY_LAST_NAME_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_LAST_NAME_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_DATE_OF_BIRTH', 'Geburtsdatum:');
define('ENTRY_DATE_OF_BIRTH_ERROR', '&nbsp;<span class="errorText">(z.B. 21.05.1970)</span>');
define('ENTRY_EMAIL_ADDRESS', 'eMail Adresse:');
define('ENTRY_EMAIL_ADDRESS_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', '&nbsp;<span class="errorText">ung&uuml;ltige eMail Adresse!</span>');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', '&nbsp;<span class="errorText">Diese eMail Adresse existiert schon!</span>');
define('ENTRY_COMPANY', 'Firmenname:');
define('ENTRY_STREET_ADDRESS', 'Strasse:');
define('ENTRY_STREET_ADDRESS_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_SUBURB', 'weitere Anschrift:');
define('ENTRY_POST_CODE', 'Postleitzahl:');
define('ENTRY_POST_CODE_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_POSTCODE_MIN_LENGTH . ' Zahlen</span>');
define('ENTRY_CITY', 'Stadt:');
define('ENTRY_CITY_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_CITY_MIN_LENGTH . ' Buchstaben</span>');
define('ENTRY_STATE', 'Bundesland:');
define('ENTRY_STATE_ERROR', '&nbsp;<span class="errorText">notwendige Eingabe</font></small>');
define('ENTRY_COUNTRY', 'Land:');
define('ENTRY_TELEPHONE_NUMBER', 'Telefonnummer:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', '&nbsp;<span class="errorText">mindestens ' . ENTRY_TELEPHONE_MIN_LENGTH . ' Zahlen</span>');
define('ENTRY_FAX_NUMBER', 'Telefaxnummer:');
define('ENTRY_NEWSLETTER', 'Rundschreiben:');
define('ENTRY_CUSTOMERS_STATUS', 'Kundengruppe:');
define('ENTRY_NEWSLETTER_YES', 'abonniert');
define('ENTRY_NEWSLETTER_NO', 'nicht abonniert');
define('ENTRY_MAIL_ERROR','&nbsp;<span class="errorText">Bitte treffen sie eine Auswahl</span>');
define('ENTRY_PASSWORD','Passwort (autom. erstellt)');
define('ENTRY_PASSWORD_ERROR','&nbsp;<span class="errorText">Ihr Passwort muss aus mindestens ' . ENTRY_PASSWORD_MIN_LENGTH . ' Zeichen bestehen.</span>');
define('ENTRY_MAIL_COMMENTS','Zus&auml;tzlicher eMailtext:');

define('ENTRY_MAIL','eMail mit Passwort an Kunden versenden?');
define('YES','ja');
define('NO','nein');
define('SAVE_ENTRY','&Auml;nderungen Speichern?');
define('TEXT_CHOOSE_INFO_TEMPLATE','Vorlage f&uuml;r Artikeldetails');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE','Vorlage f&uuml;r Artikeloptionen');
define('TEXT_SELECT','-- Bitte w&auml;hlen Sie --');

// Icons
define('ICON_CROSS', 'Falsch');
define('ICON_CURRENT_FOLDER', 'Aktueller Ordner');
define('ICON_DELETE', 'L&ouml;schen');
define('ICON_ERROR', 'Fehler');
define('ICON_FILE', 'Datei');
define('ICON_FILE_DOWNLOAD', 'Herunterladen');
define('ICON_FOLDER', 'Ordner');
define('ICON_LOCKED', 'Gesperrt');
define('ICON_PREVIOUS_LEVEL', 'Vorherige Ebene');
define('ICON_PREVIEW', 'Vorschau');
define('ICON_STATISTICS', 'Statistik');
define('ICON_SUCCESS', 'Erfolg');
define('ICON_TICK', 'Wahr');
define('ICON_UNLOCKED', 'Entsperrt');
define('ICON_WARNING', 'Warnung');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', 'Seite %s von %d');
define('TEXT_DISPLAY_NUMBER_OF_BANNERS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Bannern)');
define('TEXT_DISPLAY_NUMBER_OF_COUNTRIES', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> L&auml;ndern)');
define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Kunden)');
define('TEXT_DISPLAY_NUMBER_OF_CURRENCIES', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> W&auml;hrungen)');
define('TEXT_DISPLAY_NUMBER_OF_LANGUAGES', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Sprachen)');
define('TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Herstellern)');
define('TEXT_DISPLAY_NUMBER_OF_NEWSLETTERS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Rundschreiben)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Bestellungen)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS_STATUS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Bestellstatus)');
define('TEXT_DISPLAY_NUMBER_OF_XSELL_GROUP', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Cross-Marketing Gruppen)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_VPE', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Verpackungseinheiten)');
define('TEXT_DISPLAY_NUMBER_OF_SHIPPING_STATUS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Lieferstatus)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Artikeln)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_EXPECTED', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> erwarteten Artikeln)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Bewertungen)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Sonderangeboten)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_CLASSES', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Steuerklassen)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_ZONES', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Steuerzonen)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_RATES', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Steuers&auml;tzen)');
define('TEXT_DISPLAY_NUMBER_OF_ZONES', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Bundesl&auml;ndern)');

define('PREVNEXT_BUTTON_PREV', '&lt;&lt;');
define('PREVNEXT_BUTTON_NEXT', '&gt;&gt;');

define('TEXT_DEFAULT', 'Standard');
define('TEXT_SET_DEFAULT', 'als Standard definieren');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">* Erforderlich</span>');

define('ERROR_NO_DEFAULT_CURRENCY_DEFINED', 'Fehler: Es wurde keine Standardw&auml;hrung definiert. Bitte definieren Sie unter Adminstration -> Sprachen/W&auml;hrungen -> W&auml;hrungen eine Standardw&auml;hrung.');

define('TEXT_CACHE_CATEGORIES', 'Kategorien Box');
define('TEXT_CACHE_MANUFACTURERS', 'Hersteller Box');
define('TEXT_CACHE_ALSO_PURCHASED', 'Ebenfalls gekauft Modul');

define('TEXT_NONE', '--keine--');
define('TEXT_TOP', 'Top');

define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Fehler: Speicherort existiert nicht.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Fehler: Speicherort ist nicht beschreibbar.');
define('ERROR_FILE_NOT_SAVED', 'Fehler: Datei wurde nicht gespeichert.');
define('ERROR_FILETYPE_NOT_ALLOWED', 'Fehler: Dateityp ist nicht erlaubt.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Erfolg: Hochgeladene Datei wurde erfolgreich gespeichert.');
define('WARNING_NO_FILE_UPLOADED', 'Warnung: Es wurde keine Datei hochgeladen.');

define('DELETE_ENTRY','Eintrag l&ouml;schen?');
define('TEXT_PAYMENT_ERROR','<b>WARNUNG:</b><br />Bitte Aktivieren Sie ein Zahlungsmodul!');
define('TEXT_SHIPPING_ERROR','<b>WARNUNG:</b><br />Bitte Aktivieren Sie ein Versandmodul!');

define('TEXT_NETTO','Netto: ');

define('ENTRY_CID','Kundennummer:');
define('IP','Bestell IP:');
define('CUSTOMERS_MEMO','Memos:');
define('DISPLAY_MEMOS','Anzeigen/Schreiben');
define('TITLE_MEMO','Kunden MEMO');
define('ENTRY_LANGUAGE','Sprache:');
define('CATEGORIE_NOT_FOUND','Kategorie nicht vorhanden');

define('IMAGE_RELEASE', 'Gutschein einl&ouml;sen');

define('_JANUARY', 'Januar');
define('_FEBRUARY', 'Februar');
define('_MARCH', 'M&auml;rz');
define('_APRIL', 'April');
define('_MAY', 'Mai');
define('_JUNE', 'Juni');
define('_JULY', 'Juli');
define('_AUGUST', 'August');
define('_SEPTEMBER', 'September');
define('_OCTOBER', 'Oktober');
define('_NOVEMBER', 'November');
define('_DECEMBER', 'Dezember');

// Beschreibung f&uuml;r Abmeldelink im Newsletter
define('TEXT_NEWSLETTER_REMOVE', 'Um sich von unserem Newsletter abzumelden klicken Sie hier:');


define('TEXT_DISPLAY_NUMBER_OF_GIFT_VOUCHERS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> (von insgesamt <b>%d</b> Gutscheinen)');
define('TEXT_DISPLAY_NUMBER_OF_COUPONS', 'Angezeigt werden <b>%d</b> bis <b>%d</b> ((von insgesamt <b>%d</b> Kupons)');

define('TEXT_VALID_PRODUCTS_LIST', 'Artikelliste');
define('TEXT_VALID_PRODUCTS_ID', 'Artikelnummer');
define('TEXT_VALID_PRODUCTS_NAME', 'Artikelname');
define('TEXT_VALID_PRODUCTS_MODEL', 'Artikelmodell');

define('TEXT_VALID_CATEGORIES_LIST', 'Kategorieliste');
define('TEXT_VALID_CATEGORIES_ID', 'Kategorienummer');
define('TEXT_VALID_CATEGORIES_NAME', 'Kategoriename');

define('SECURITY_CODE_LENGTH_TITLE', 'L&auml;nge des Gutscheincodes');
define('SECURITY_CODE_LENGTH_DESC', 'Geben Sie hier die L&auml;nge des Gutscheincode ein. (max. 16 Zeichen)');

define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_TITLE', 'Willkommens-Geschenk Gutschein Wert');
define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_DESC', 'Willkommens-Geschenk Gutschein Wert: Wenn Sie keinen Gutschein in Ihrer Willkommens-eMail versenden wollen, tragen Sie hier 0 ein, ansonsten geben Sie den Wert des Gutscheins an, zB. 10.00 oder 50.00, aber keine W&auml;hrungszeichen');
define('NEW_SIGNUP_DISCOUNT_COUPON_TITLE', 'Willkommens-Rabatt Kupon Code');
define('NEW_SIGNUP_DISCOUNT_COUPON_DESC', 'Willkommens-Rabatt Kupon Code: Wenn Sie keinen Kupon in Ihrer Willkommens-eMail versenden wollen, lassen Sie dieses Feld leer, ansonsten tragen Sie den Kupon Code ein, den Sie verwenden wollen');

define('TXT_ALL','Alle');

// UST ID
define('HEADING_TITLE_VAT','Ust-ID');
define('HEADING_TITLE_VAT','Ust-ID');
define('ENTRY_VAT_ID','Ust-ID:');
define('ENTRY_CUSTOMERS_VAT_ID', 'UstID:');
define('TEXT_VAT_FALSE','<font color="FF0000">Gepr&uuml;ft/Falsch!</font>');
define('TEXT_VAT_TRUE','<font color="FF0000">Gepr&uuml;ft/OK!</font>');
define('TEXT_VAT_UNKNOWN_COUNTRY','<font color="FF0000">Nicht Gepr&uuml;ft/Land unbekannt!</font>');
define('TEXT_VAT_UNKNOWN_ALGORITHM','<font color="FF0000">Nicht Gepr&uuml;ft/Keine &Uuml;berpr&uuml;fung m&ouml;glich!</font>');
define('ENTRY_VAT_ID_ERROR', '<font color="FF0000">* Die Eingegebene UST ID Nummer ist Falsch oder kann derzeit nicht gepr&uuml;ft werden!</font>');

define('ERROR_GIF_MERGE','Fehlender GDlib Gif Support, kein Wasserzeichen (Merge) m&ouml;glich');
define('ERROR_GIF_UPLOAD','Fehlender GDlib Gif Support, kein Upload von GIF Bildern m&ouml;glich');

define('TEXT_REFERER','Referer: ');
?>