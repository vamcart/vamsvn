<?php
/* -----------------------------------------------------------------------------------------
   $Id: eustandardtransfer.php 998 2005-07-07 14:18:20Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ptebanktransfer.php,v 1.4.1 2003/09/25 19:57:14); www.oscommerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


  define('MODULE_PAYMENT_EUTRANSFER_TEXT_TITLE', 'EU-Standard Bank Transfer');
  define('MODULE_PAYMENT_EUSTANDARDTRANSFER_TEXT_TITLE', 'EU-Standard Bank Transfer');
  define('MODULE_PAYMENT_EUTRANSFER_TEXT_DESCRIPTION', '<br />Die billigste und einfachste Zahlungsmethode innerhalb der EU ist die &Uuml;berweisung mittels IBAN und BIC.' .
													   '<br />Bitte verwenden Sie folgende Daten f&uuml;r die &Uuml;berweisung des Gesamtbetrages:<br />' .
                                                       '<br />Name der Bank: ' . MODULE_PAYMENT_EUTRANSFER_BANKNAM .
                                                       '<br />Zweigstelle: ' . MODULE_PAYMENT_EUTRANSFER_BRANCH .
                                                       '<br />Kontoname: ' . MODULE_PAYMENT_EUTRANSFER_ACCNAM .
                                                       '<br />Kontonummer: ' . MODULE_PAYMENT_EUTRANSFER_ACCNUM .
                                                       '<br />IBAN: ' . MODULE_PAYMENT_EUTRANSFER_ACCIBAN .
                                                       '<br />BIC/SWIFT: ' . MODULE_PAYMENT_EUTRANSFER_BANKBIC .
//                                                     '<br />Sort Code: ' . MODULE_PAYMENT_EUTRANSFER_SORTCODE .
                                                       '<br /><br />Die Ware wird ausgeliefert wenn der Betrag auf unserem Konto eingegangen ist.<br />');

  define('MODULE_PAYMENT_EUTRANSFER_TEXT_INFO','&Uuml;berweisen Sie den Rechnungsbetrag auf unser Konto. Die Kontodaten erhalten Sie nach Bestellannahme per E-Mail');
  define('MODULE_PAYMENT_EUTRANSFER_STATUS_TITLE','Allow Bank Transfer Payment');
  define('MODULE_PAYMENT_EUTRANSFER_STATUS_DESC','Do you want to accept bank transfer order payments?');

  define('MODULE_PAYMENT_EUTRANSFER_BRANCH_TITLE','Branch Location');
  define('MODULE_PAYMENT_EUTRANSFER_BRANCH_DESC','The brach where you have your account.');

  define('MODULE_PAYMENT_EUTRANSFER_BANKNAM_TITLE','Bank Name');
  define('MODULE_PAYMENT_EUTRANSFER_BANKNAM_DESC','Your full bank name');

  define('MODULE_PAYMENT_EUTRANSFER_ACCNAM_TITLE','Bank Account Name');
  define('MODULE_PAYMENT_EUTRANSFER_ACCNAM_DESC','The name associated with the account.');

  define('MODULE_PAYMENT_EUTRANSFER_ACCNUM_TITLE','Bank Account No.');
  define('MODULE_PAYMENT_EUTRANSFER_ACCNUM_DESC','Your account number.');

  define('MODULE_PAYMENT_EUTRANSFER_ACCIBAN_TITLE','Bank Account IBAN');
  define('MODULE_PAYMENT_EUTRANSFER_ACCIBAN_DESC','International account id.<br />(ask your bank if you don\'t know it)');

  define('MODULE_PAYMENT_EUTRANSFER_BANKBIC_TITLE','Bank Bic');
  define('MODULE_PAYMENT_EUTRANSFER_BANKBIC_DESC','International bank id.<br />(ask your bank if you don\'t know it)');

  define('MODULE_PAYMENT_EUTRANSFER_SORT_ORDER_TITLE','Module Sort order of display.');
  define('MODULE_PAYMENT_EUTRANSFER_SORT_ORDER_DESC','Sort order of display. Lowest is displayed first.');

  define('MODULE_PAYMENT_EUSTANDARDTRANSFER_ALLOWED_TITLE' , 'Erlaubte Zonen');
 define('MODULE_PAYMENT_EUSTANDARDTRANSFER_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');


?>
