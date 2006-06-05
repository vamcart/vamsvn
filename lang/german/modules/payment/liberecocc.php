<?php
/*------------------------------------------------------------------------------
  $Id: liberecocc.php 998 2005-07-07 14:18:20Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
  -----------------------------------------------------------------------------
  based on:
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
------------------------------------------------------------------------------*/


  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_TITLE', 'Kreditkarte');
  define('MODULE_PAYMENT_LIBERECOCC_TEXT_TITLE','Kreditkarte');
    define('MODULE_PAYMENT_LIBERECOCC_TEXT_INFO','');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_DESCRIPTION', 'liberECO CC-Payment Modul<br />http://www.liberECO.net<br /><br />Kreditkarte Testinfo:<br /><br />LIBERECO_CC#: 4111111111111111<br />G&uuml;ltig bis: Jederzeit');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_TYPE', 'Kreditkarten-Typ:');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_OWNER', 'Kreditkarten-Inhaber:');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_NUMBER', 'Kreditkarten-Nummer:');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_START', 'Kreditkarten-Startdatum:');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_EXPIRES', 'Kreditkarten-G&uuml;ltigkeitsdatum:');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_ISSUE', 'Kreditkarten-Vorgangsnummer:');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_CVV_NUMBER', '3-  oder 4-stelliger Sicherheitscode:');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_JS_LIBERECO_CC_OWNER', '* Der Name des Karteninhabers muss aus mindestens ' . CC_OWNER_MIN_LENGTH . ' Zeichen bestehen.\n\n');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_JS_LIBERECO_CC_NUMBER', '* Die Kreditkartennummer muss aus mindestens ' . CC_NUMBER_MIN_LENGTH . ' Ziffern bestehen.\n\n');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_ERROR', 'Kreditkartenfehler!');
  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_JS_LIBERECO_CC_CVV', '* Der CVV Sicherheitscode ist ein Pflichtfeld und muss ausgef\u00fcllt werden.\n\u00A0\u00A0\u00A0Bestellungen k\u00f6nnen ohne diesen Code nicht ausgef\u00fchrt werden.\n\u00A0\u00A0\u00A0Der CVV Code besteht aus 3 Ziffern und ist im Unterschriftsfeld\n\u00A0\u00A0\u00A0auf der R\u00fcckseite Ihrer Karte gedruckt.\n\n');
  define('TEXT_CVV_LINK', '<u>[Hilfe?]</u>');
  define('HEADING_CVV', 'Sicherheitscode Infoseite');
  define('TEXT_CVV', '<table align="center" cellspacing="2" cellpadding="5" width="400"><tr><td><span class="tableHeading"><b>Visa, Mastercard, Discover und Andere mit 3-stelligem CVV-Code</b></span></td></tr><tr><td><span class="boxText">F&uuml;r Ihre eigene Sicherheit ist die Angabe Ihres Sicherheitscodes verpflichtend. Die Sicherheitsnummer ist eine dreistellige Nummer, die im Unterschriftsfeld auf der R&uuml;ckseite Ihrer Kreditkarte gedruckt ist. Sie erscheint nach den letzten vier Stellen Ihrer Kartennummer auf der rechten Seite.</span></td></tr><tr><td align="center"><IMG src="images/cv_card.gif"></td></tr></table><hr /><table align="center" cellspacing="2" cellpadding="5" width="400"><tr><td><span class="main"><b>American Express 4-stelliger CVV-Code</b> </span></td></tr><tr><td><span class="boxText">F&uuml;r Ihre eigene Sicherheit ist die Angabe Ihres Sicherheitscodes verpflichtend. Der American Express Sicherheitscode ist eine 4-stellige Nummer auf Ihrer Kartenvorderseite. Sie erscheint nach den letzten vier Stellen Ihrer Kartennummer auf der rechten Seite.</span></td></tr><tr><td align="center"><IMG src="images/cv_amex_card.gif"></td></tr></table>');
  define('TEXT_CLOSE_WINDOW', '<u>Fenster schliessen</u> [x]');


  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_ERROR', 'Credit Card Error!');

  define('TEXT_LIBERECO_CCVAL_ERROR_INVALID_DATE','Gültigkeitsdatum Falsch');


  define('MODULE_PAYMENT_LIBERECO_CC_STATUS_TITLE','Enable Credit Card Module');
  define('MODULE_PAYMENT_LIBERECO_CC_STATUS_DESC','Do you want to accept credit card payments?');

  define('MODULE_PAYMENT_LIBERECO_CC_EMAIL_TITLE','Split Credit Card E-Mail Address');
  define('MODULE_PAYMENT_LIBERECO_CC_EMAIL_DESC','If an e-mail address is entered, the middle digits of the credit card number will be sent to the e-mail address (the outside digits are stored in the database with the middle digits censored)');

  define('MODULE_PAYMENT_LIBERECO_CC_SORT_ORDER_TITLE','Sort order of display.');
  define('MODULE_PAYMENT_LIBERECO_CC_SORT_ORDER_DESC','Sort order of display. Lowest is displayed first.');

  define('MODULE_PAYMENT_LIBERECO_CC_ZONE_TITLE','Payment Zone');
  define('MODULE_PAYMENT_LIBERECO_CC_ZONE_DESC','If a zone is selected, only enable this payment method for that zone.');

  define('MODULE_PAYMENT_LIBERECO_CC_ORDER_STATUS_ID_TITLE','Set Order Status');
  define('MODULE_PAYMENT_LIBERECO_CC_ORDER_STATUS_ID_DESC','Set the status of orders made with this payment module to this value');

  define('MODULE_PAYMENT_LIBERECO_CC_TEXT_TITLE', 'Kreditkarte');

  define('MODULE_PAYMENT_LIBERECOCC_ALLOWED_TITLE' , 'Erlaubte Zonen');
  define('MODULE_PAYMENT_LIBERECOCC_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');

  define('MODULE_PAYMENT_LIBERECO_CC_PAGENUMBER_TITLE','Kennung');
  define('MODULE_PAYMENT_LIBERECO_CC_PAGENUMBER_DESC','Die Kennung (fünf Buchstaben/Zahlen) die Ihrer Webseite von liberECO zugeteilt wird. ');



?>
