<?php
/* -----------------------------------------------------------------------------------------
   $Id: liberecobanktransfer.php 998 2005-07-07 14:18:20Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banktransfer.php,v 1.9 2003/02/18 19:22:15); www.oscommerce.com
   (c) 2003         nextcommerce (banktransfer.php,v 1.5 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   OSC German Banktransfer v0.85a               Autor:        Dominik Guder <osc@guder.org>

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_TITLE', 'Lastschriftverfahren');
  define('MODULE_PAYMENT_LIBERECOBANKTRANSFER_TEXT_TITLE', 'Lastschriftverfahren');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_DESCRIPTION', 'liberECO Lastschriftverfahren Modul<br />http://www.liberECO.net<br />');
    define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_INFO','');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK', 'Bankeinzug');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_EMAIL_FOOTER', 'Hinweis: Sie können sich unser Faxformular unter ' . HTTP_SERVER . DIR_WS_CATALOG . MODULE_PAYMENT_BANKTRANSFER_URL_NOTE . ' herunterladen und es ausgefüllt an uns zurücksenden.');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_INFO', 'Bitte beachten Sie, dass das Lastschriftverfahren <b>nur</b> von einem <b>deutschen Girokonto</b> aus möglich ist');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_OWNER', 'Kontoinhaber:');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_NUMBER', 'Kontonummer:');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_BLZ', 'BLZ:');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_NAME', 'Bank:');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_FAX', 'Einzugsermächtigung wird per Fax bestätigt');

  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR', '<font color="#FF0000">FEHLER: </font>');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_1', 'Kontonummer und BLZ stimmen nicht überein!\nBitte überprüfen Sie Ihre Angaben nochmals.');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_2', 'Für diese Kontonummer ist kein Prüfziffernverfahren definiert!');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_3', 'Kontonummer nicht prüfbar!');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_4', 'Kontonummer nicht prüfbar!\nBitte überprüfen Sie Ihre Angaben nochmals.');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_5', 'Bankleitzahl nicht gefunden!\nBitte überprüfen Sie Ihre Angaben nochmals.');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_8', 'Fehler bei der Bankleitzahl oder keine Bankleitzahl angegeben!');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_9', 'Keine Kontonummer angegeben!');

  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_NOTE', 'Hinweis:');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_NOTE2', 'Wenn Sie aus Sicherheitsbedenken keine Bankdaten über das Internet<br />übertragen wollen, können Sie sich unser ');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_NOTE3', 'Faxformular');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_NOTE4', ' herunterladen und uns ausgefüllt zusenden.');

  define('JS_BANK_BLZ', 'Bitte geben Sie die BLZ Ihrer Bank ein!\n');
  define('JS_BANK_NAME', 'Bitte geben Sie den Namen Ihrer Bank ein!\n');
  define('JS_BANK_NUMBER', 'Bitte geben Sie Ihre Kontonummer ein!\n');
  define('JS_BANK_OWNER', 'Bitte geben Sie den Namen des Kontobesitzers ein!\n');


  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_STATUS_TITLE','Allow Banktranfer Payments');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_STATUS_DESC','Do you want to accept banktransfer payments?');

  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_ZONE_TITLE','Payment Zone');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_ZONE_DESC','If a zone is selected, only enable this payment method for that zone.');

  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_SORT_ORDER_TITLE','Sort order of display.');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_SORT_ORDER_DESC','Sort order of display. Lowest is displayed first.');

  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_ORDER_STATUS_ID_TITLE','Set Order Status');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_ORDER_STATUS_ID_DESC','Set the status of orders made with this payment module to this value');

  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_FAX_CONFIRMATION_TITLE','Allow Fax Confirmation');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_FAX_CONFIRMATION_DESC','Do you want to allow fax confirmation?');

  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_DATABASE_BLZ_TITLE','Use database lookup for BLZ?');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_DATABASE_BLZ_DESC','Do you want to use database lookup for BLZ? Ensure that the table banktransfer_blz exists and is set up properly!');

  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_URL_NOTE_TITLE','Fax-URL');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_URL_NOTE_DESC','The fax-confirmation file. It must located in catalog-dir');

  define('MODULE_PAYMENT_LIBERECOBANKTRANSFER_ALLOWED_TITLE' , 'Erlaubte Zonen');
  define('MODULE_PAYMENT_LIBERECOBANKTRANSFER_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');

  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_PAGENUMBER_TITLE','Kennung');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_PAGENUMBER_DESC','Die Kennung (fünf Buchstaben/Zahlen) die Ihrer Webseite von liberECO zugeteilt wird. ');

?>
