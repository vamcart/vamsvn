<?php
/* -----------------------------------------------------------------------------------------
   $Id: moneybookers.php 998 2005-07-07 14:18:20Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneybookers.php,v 1.01 2003/01/20); www.oscommerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Moneybookers v1.0                       Autor:    Gabor Mate  <gabor(at)jamaga.hu>

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_MONEYBOOKERS_TEXT_TITLE', 'Moneybookers.com');
  define('MODULE_PAYMENT_MONEYBOOKERS_TEXT_DESCRIPTION', 'Moneybookers.com');
    define('MODULE_PAYMENT_MONEYBOOKERS_TEXT_INFO','');
   define('MODULE_PAYMENT_MONEYBOOKERS_NOCURRENCY_ERROR', 'Es ist keine von moneybookers.com akzeptierte Währung installiert!');
  define('MODULE_PAYMENT_MONEYBOOKERS_ERRORTEXT1', 'payment_error=');
  define('MODULE_PAYMENT_MONEYBOOKERS_ERRORTEXT2', '&error=Fehler w&auml;hrend Ihrer Bezahlung bei moneybookers.com!');
  define('MODULE_PAYMENT_MONEYBOOKERS_ORDER_TEXT', 'Bestelldatum: ');
  define('MODULE_PAYMENT_MONEYBOOKERS_TEXT_ERROR', 'Fehler bei Zahlung!');
  define('MODULE_PAYMENT_MONEYBOOKERS_CONFIRMATION_TEXT', 'Danke f&uuml;r Ihre Bestellung!');
  define('MODULE_PAYMENT_MONEYBOOKERS_TRANSACTION_FAILED_TEXT', 'Ihre Zahlungstransaktion bei moneybookers.com ist fehlgeschlagen. Bitte versuchen Sie es nochmal, oder w&auml;hlen Sie eine andere Zahlungsm&ouml;glichkeit!');
  define('MODULE_PAYMENT_MONEYBOOKERS_ORDER_COMMENT1', 'Die Transaktions ID f&uuml;r diese Bestellung lautet: ');
  define('MODULE_PAYMENT_MONEYBOOKERS_ORDER_COMMENT2', 'Bitte notieren Sie sich diese Transaktionen zur Referenz, und nennen Sie diese gemeinsam mit Ihrer Bestellnummer in Ihren zuk&uuml;nftigen Support-Anfragen. Dies erm&ouml;glicht uns, Ihnen schneller und effizienter zu helfen. Vielen Dank! PS: Sie k&ouml;nnen die Transaktions ID jederzeit in Ihrer Konto/Bestell&uuml;bersicht, und zwar im Kommentarfeld der Bestellung.');

  define('MODULE_PAYMENT_MONEYBOOKERS_STATUS_TITLE','Moneybookers.com Modul aktivieren');
  define('MODULE_PAYMENT_MONEYBOOKERS_STATUS_DESC','M&ouml;chten Sie Zahlungen per Moneybookers.com akzeptieren?');
  define('MODULE_PAYMENT_MONEYBOOKERS_EMAILID_TITLE','eMail Adresse');
  define('MODULE_PAYMENT_MONEYBOOKERS_EMAILID_DESC','Merchant\'s eMail Adresse, die bei Moneybookers.com registriert ist');
  define('MODULE_PAYMENT_MONEYBOOKERS_PWD_TITLE','Moneybookers Passwort');
  define('MODULE_PAYMENT_MONEYBOOKERS_PWD_DESC','Geben Sie Ihr Moneybookers Passwort ein (dieses ist notwendig, un die Transaktion durchzuf&uuml;hren!)');
  define('MODULE_PAYMENT_MONEYBOOKERS_REFID_TITLE','Verweis ID');
  define('MODULE_PAYMENT_MONEYBOOKERS_REFID_DESC','Ihre pers&ouml;nliche Verweis ID von Moneybookers.com');
  define('MODULE_PAYMENT_MONEYBOOKERS_SORT_ORDER_TITLE','Anzeigereihenfolge');
  define('MODULE_PAYMENT_MONEYBOOKERS_SORT_ORDER_DESC','Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
  define('MODULE_PAYMENT_MONEYBOOKERS_CURRENCY_TITLE','Transaktionsw&auml;hrung');
  define('MODULE_PAYMENT_MONEYBOOKERS_CURRENCY_DESC','Die W&auml;hrung für die Zahlungstransaktion. Wenn Ihre gew&auml;hlte W&auml;hrung nicht bei Moneybookers.com verfügbar ist, wird diese W&auml;hrung zur Bezahlw&auml;hrung.');
  define('MODULE_PAYMENT_MONEYBOOKERS_LANGUAGE_TITLE','Transaktionssprache');
  define('MODULE_PAYMENT_MONEYBOOKERS_LANGUAGE_DESC','Die Sprache für die Zahlungstransaktion. Wenn Ihre gew&auml;hlte Sprache nicht bei Moneybookers.com verfügbar ist, wird diese Sprache zur Bezahlsprache.');
  define('MODULE_PAYMENT_MONEYBOOKERS_ZONE_TITLE','Zahlungszone');
  define('MODULE_PAYMENT_MONEYBOOKERS_ZONE_DESC','Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');
  define('MODULE_PAYMENT_MONEYBOOKERS_ORDER_STATUS_ID_TITLE','Bestellstatus festlegen');
  define('MODULE_PAYMENT_MONEYBOOKERS_ORDER_STATUS_ID_DESC','Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen');
  ?>