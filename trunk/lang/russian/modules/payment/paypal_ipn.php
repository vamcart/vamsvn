<?php
/* -----------------------------------------------------------------------------------------
   $Id: paypal_ipn.php v1.0 998 2005-08-16 14:18:20Z VaM $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2005 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(paypal.php,v 1.39 2003/01/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (paypal.php,v 1.8 2003/08/24); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
	 
define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_TITLE', 'PayPal IPN');
define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_DESCRIPTION', 'Sie werden nach der Best&auml;tigung auf die PayPal Website umgeleitet.<br />Bitte warten Sie den erneuten R&uuml;cksprung zu uns zur&uuml;ck ab.<br />Ihre Bestellung wird nach erfolgter Zahlung bearbeitet.');
define('MODULE_PAYMENT_PAYPAL_IPN_TEXT_EMAIL_FOOTER', 'Ihre Bestellung wird nach erfolgter Zahlung bearbeitet.');  
	 
define('MODULE_PAYMENT_PAYPAL_IPN_STATUS_TITLE', 'PayPal-IPN-Modul aktivieren');
define('MODULE_PAYMENT_PAYPAL_IPN_STATUS_DESC', 'Wollen Sie PayPal-IPN-Zahlungen aktzeptieren?');
define('MODULE_PAYMENT_PAYPAL_IPN_ID_TITLE', 'EMail-Adresse');
define('MODULE_PAYMENT_PAYPAL_IPN_ID_DESC', 'Die EMail-Adresse, die f&uuml;r PayPal-IPN-Dienste verwendet wird.');
define('MODULE_PAYMENT_PAYPAL_IPN_CURRENCY_TITLE', 'Transaktionsw&auml;hrung');
define('MODULE_PAYMENT_PAYPAL_IPN_CURRENCY_DESC', 'Die W&auml;hrung, die f&uuml;r die Transaktionen verwendet wird.');
define('MODULE_PAYMENT_PAYPAL_IPN_SORT_ORDER_TITLE', 'ѕор€док сортировки');
define('MODULE_PAYMENT_PAYPAL_IPN_SORT_ORDER_DESC', 'ѕор€док сортировки модул€.');
define('MODULE_PAYMENT_PAYPAL_IPN_ZONE_TITLE', '«она');
define('MODULE_PAYMENT_PAYPAL_IPN_ZONE_DESC', '≈сли выбрана зона, то данный модуль оплаты будет виден только покупател€м из выбранной зоны.');
define('MODULE_PAYMENT_PAYPAL_IPN_PREPARE_ORDER_STATUS_ID_TITLE', 'Vorbereitender / Offener PayPal-Bestellstatus');
define('MODULE_PAYMENT_PAYPAL_IPN_PREPARE_ORDER_STATUS_ID_DESC', 'Setzt den Bestellstatus von vorbereiteten oder offenen IPN Bestellungen, die mit diesem Zahlungsmodul gemacht wurden, auf diesen Wert.');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID_TITLE', '—татус заказа');
define('MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID_DESC', '«аказы, оформленные с использованием данного модул€ оплаты будут принимать указанный статус.');
define('MODULE_PAYMENT_PAYPAL_IPN_DENIED_ORDER_STATUS_ID_TITLE', 'Verweigerter / R&uuml;ckgebuchter Bestellstatus');
define('MODULE_PAYMENT_PAYPAL_IPN_DENIED_ORDER_STATUS_ID_DESC', 'Setzt den Bestellstatus von verweigerten, fehlgeschlagenen, zur&uuml;ckgebuchten oder abgebrochenen IPN Bestellungen, die mit diesem Zahlungsmodul gemacht wurden, auf diesen Wert.');
define('MODULE_PAYMENT_PAYPAL_IPN_GATEWAY_SERVER_TITLE', 'Gateway-Server');
define('MODULE_PAYMENT_PAYPAL_IPN_GATEWAY_SERVER_DESC', 'Die Testumgebung (sandbox)  oder den Live-Gateway-Server f&uuml;r Transaktionen verwenden?');
define('MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE_TITLE', 'Seitenstil');
define('MODULE_PAYMENT_PAYPAL_IPN_PAGE_STYLE_DESC', 'Der Stil der Seite f&uuml;r den Transaktionsablauf (Wird auf Ihrer PayPal-Profil-Seite definiert).');
define('MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL_TITLE', 'Fehlerbehebungs-EMail-Adresse');
define('MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL_DESC', 'Alle Parameter einer ung&uuml;ltigen IPN-Eintragung werden an diese EMail-Adresse geschickt, wenn eine angegeben wird.');
define('MODULE_PAYMENT_PAYPAL_IPN_EWP_STATUS_TITLE', 'Verschl&uuml;sselt Web-Zahlung aktivieren');
define('MODULE_PAYMENT_PAYPAL_IPN_EWP_STATUS_DESC', 'Wollen Sie Verschl&uuml;sselte Web-Zahlung (encrypted web payment) aktivieren?');
define('MODULE_PAYMENT_PAYPAL_IPN_EWP_PRIVATE_KEY_TITLE', 'Ihr privater Schl&uuml;ssel');
define('MODULE_PAYMENT_PAYPAL_IPN_EWP_PRIVATE_KEY_DESC', 'Der Ort, wo Ihr privater Schl&uuml;ssel zum Signieren der Daten liegt (*.pem).');
define('MODULE_PAYMENT_PAYPAL_IPN_EWP_PUBLIC_KEY_TITLE', 'Ihr &ouml;ffentliches Zertifikat');
define('MODULE_PAYMENT_PAYPAL_IPN_EWP_PUBLIC_KEY_DESC', 'Der Ort, wo Ihr &ouml;ffentliches Zertifikat zum Signieren der Daten liegt (*.pem).');
define('MODULE_PAYMENT_PAYPAL_IPN_EWP_PAYPAL_KEY_TITLE', 'PayPals &ouml;ffentliches Zertifikat');
define('MODULE_PAYMENT_PAYPAL_IPN_EWP_PAYPAL_KEY_DESC', 'Der Ort, wo PayPals &ouml;ffentliches Zertifikat zum Signieren der Daten liegt.');
define('MODULE_PAYMENT_PAYPAL_IPN_EWP_CERT_ID_TITLE', 'Die ID Ihres &ouml;ffentlichen PayPal-Zertifikats');
define('MODULE_PAYMENT_PAYPAL_IPN_EWP_CERT_ID_DESC', 'Die Zertifikat-ID, die von Ihrem Verschl&uuml;sselte-Zahlungen-PayPal-Einstellungsprofil aus verwendet wird.');
define('MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY_TITLE', 'Arbeitsverzeichnis');
define('MODULE_PAYMENT_PAYPAL_IPN_EWP_WORKING_DIRECTORY_DESC', 'Das Arbeitsverzeichnis f&uuml;r tempor&auml;re Dateien. (angeh&auml;ngter Slash n&ouml;tig)');
define('MODULE_PAYMENT_PAYPAL_IPN_EWP_OPENSSL_TITLE', 'Ort von OpenSSL');
define('MODULE_PAYMENT_PAYPAL_IPN_EWP_OPENSSL_DESC', 'Der Ort, wo das OpenSSL-Binary liegt.');
define('MODULE_PAYMENT_PAYPAL_IPN_ALLOWED_TITLE' , '–азрешЄнные страны');
define('MODULE_PAYMENT_PAYPAL_IPN_ALLOWED_DESC' , '”кажите коды стран, дл€ которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупател€м из любых стран))');

?>