<?php
/* --------------------------------------------------------------
   $Id: orders_edit.php,v 1.0 

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders.php,v 1.27 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (orders.php,v 1.7 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

// Allgemeine Texte
define('TABLE_HEADING', 'Bestelldaten bearbeiten');
define('TABLE_HEADING_ORDER', 'Bestellung Nr:&nbsp;');
define('TEXT_SAVE_ORDER', 'Bestellungsbearbeitung beenden und Bestellung neu berechnen.');

define('TEXT_EDIT_ADDRESS', 'Adressdaten und Kundendaten bearbeiten und einfügen.');
define('TEXT_EDIT_PRODUCTS', 'Artikel und Artikeloptionen bearbeiten und einfügen.');
define('TEXT_EDIT_OTHER', 'Versandkosten, Zahlungsweisen, Währungen, Sprachen usw bearbeiten und einfügen.');

define('IMAGE_EDIT_ADDRESS', 'Adressen bearbeiten oder einfügen');
define('IMAGE_EDIT_PRODUCTS', 'Artikel und Optionen bearbeiten oder einfügen');
define('IMAGE_EDIT_OTHER', 'Versandkosten Zahlung Gutscheine usw. bearbeiten oder einfügen');

// Adressänderung
define('TEXT_INVOICE_ADDRESS', 'Kundenadresse');
define('TEXT_SHIPPING_ADDRESS', 'Versandadresse');
define('TEXT_BILLING_ADDRESS', 'Rechnungsadresse');


define('TEXT_COMPANY', 'Firma:');
define('TEXT_NAME', 'Name:');
define('TEXT_STREET', 'Straße');
define('TEXT_ZIP', 'Plz:');
define('TEXT_CITY', 'Stadt:');
define('TEXT_COUNTRY', 'Land:');
define('TEXT_CUSTOMER_GROUP', 'Kundengruppe in der Bestellung');
define('TEXT_CUSTOMER_EMAIL', 'eMail:');
define('TEXT_CUSTOMER_TELEPHONE', 'Telefon:');
define('TEXT_CUSTOMER_UST', 'UstID:');

// Artikelbearbeitung

define('TEXT_EDIT_GIFT', 'Gutscheine und Rabatt bearbeiten oder einfügen');
define('TEXT_EDIT_ADDRESS_SUCCESS', 'Adressänderung wurde gespeichert.');
define('TEXT_SMALL_NETTO', '(Netto)');
define('TEXT_PRODUCT_ID', 'pID:');
define('TEXT_PRODUCTS_MODEL', 'Art.Nr:');
define('TEXT_QUANTITY', 'Anzahl:');
define('TEXT_PRODUCT', 'Artikel:');
define('TEXT_TAX', 'MWSt.:');
define('TEXT_PRICE', 'Preis:');
define('TEXT_FINAL', 'Gesamt:');
define('TEXT_PRODUCT_SEARCH', 'Artikelsuche:');

define('TEXT_PRODUCT_OPTION', 'Artikelmerkmale:');
define('TEXT_PRODUCT_OPTION_VALUE', 'Optionswert:');
define('TEXT_PRICE', 'Preis:');
define('TEXT_PRICE_PREFIX', 'Price Prefix:');

// Sonstiges

define('TEXT_PAYMENT', 'Zahlungsweise:');
define('TEXT_SHIPPING', 'Versandart:');
define('TEXT_LANGUAGE', 'Sprache:');
define('TEXT_CURRENCIES', 'Währungen:');
define('TEXT_ORDER_TOTAL', 'Zusammenfassung:');
define('TEXT_SAVE', 'Speichern');
define('TEXT_ACTUAL', 'Aktuell: ');
define('TEXT_NEW', 'Neu: ');
define('TEXT_PRICE', 'Kosten: ');
define('TEXT_ACTUAL', 'aktuell:');
define('TEXT_NEW', 'neu:');
?>