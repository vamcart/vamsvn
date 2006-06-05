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

  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_TITLE', 'Banktransfer');
  define('MODULE_PAYMENT_LIBERECOBANKTRANSFER_TEXT_TITLE', 'Banktransfer');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_DESCRIPTION', 'liberECO Banktransfer Modul<br />http://www.liberECO.net<br />');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK', 'Banktransfer');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_EMAIL_FOOTER', 'Note: You can download our Fax Confirmation form from here: ' . HTTP_SERVER . DIR_WS_CATALOG . MODULE_PAYMENT_LIBERECO_BANKTRANSFER_URL_NOTE . '');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_INFO', 'Please note that Banktransfer Payments are <b>only</b> available from a <b>german</b> bank account!');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_OWNER', 'Account Owner:');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_NUMBER', 'Account Number:');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_BLZ', 'Bank Code:');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_NAME', 'Bank:');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_FAX', 'Banktransfer Payment will be confirmed by fax');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_INFO','');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR', '<font color="#FF0000">FEHLER: </font>');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_1', 'Accountnumber and Bank Code are not compatible!<br />Please try again.');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_2', 'Sorry, we are unable to proof this account number!');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_3', 'Account number not proofable!');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_4', 'Account number not proofable!<br />Please try again.');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_5', 'Bank Code not found!\nPlease try again.');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_8', 'No match for your Bank Code or Bank Code not given!');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_9', 'No account number given!');

  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_NOTE', 'Note:');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_NOTE2', 'If you do not want to send your<br />account data over the internet you can download our ');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_NOTE3', 'Fax form');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_NOTE4', ' and sent it back to us.');

  define('JS_BANK_BLZ', 'Please ente the BLZ or your bank!\n');
  define('JS_BANK_NAME', 'Please enter your name and bank!\n');
  define('JS_BANK_NUMBER', 'Please enter your account number!\n');
  define('JS_BANK_OWNER', 'Please enter the name of the account owner!\n');



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

  define('MODULE_PAYMENT_LIBERECOBANKTRANSFER_ALLOWED_TITLE' , 'Allowed Zones');
  define('MODULE_PAYMENT_LIBERECOBANKTRANSFER_ALLOWED_DESC' , 'Enter single Zones IDs (ISO), if you want to restrict the usage of the modul to several Zones (eg. AT,DE,NL)');

  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_PAGENUMBER_TITLE','liberECO ID');
  define('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_PAGENUMBER_DESC','ID (5 Letters/Digits).');

?>
