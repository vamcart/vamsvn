<?php
/* -----------------------------------------------------------------------------------------
   $Id: configuration.php 1286 2005-10-07 10:10:18Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.8 2002/01/04); www.oscommerce.com
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/25); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('TABLE_HEADING_CONFIGURATION_TITLE', 'Name');
define('TABLE_HEADING_CONFIGURATION_VALUE', 'Wert');
define('TABLE_HEADING_ACTION', 'Aktion');

define('TEXT_INFO_EDIT_INTRO', 'Bitte f&uuml;hren Sie alle notwendigen &Auml;nderungen durch');
define('TEXT_INFO_DATE_ADDED', 'hinzugef&uuml;gt am:');
define('TEXT_INFO_LAST_MODIFIED', 'letzte &Auml;nderung:');

// language definitions for config
define('STORE_NAME_TITLE' , 'Name des Shops');
define('STORE_NAME_DESC' , 'Der Name dieses Online Shops');
define('STORE_OWNER_TITLE' , 'Inhaber');
define('STORE_OWNER_DESC' , 'Der Name des Shop-Betreibers');
define('STORE_OWNER_EMAIL_ADDRESS_TITLE' , 'eMail Adresse');
define('STORE_OWNER_EMAIL_ADDRESS_DESC' , 'Die eMail Adresse des Shop-Betreibers');

define('EMAIL_FROM_TITLE' , 'eMail von');
define('EMAIL_FROM_DESC' , 'eMail Adresse die beim versenden (send mail)benutzt werden soll.');

define('STORE_COUNTRY_TITLE' , 'Land');
define('STORE_COUNTRY_DESC' , 'Das Land aus dem der Versand erfolgt <br /><br /><b>Hinweis: Bitte nicht vergessen die Region richtig anzupassen.</b>');
define('STORE_ZONE_TITLE' , 'Region');
define('STORE_ZONE_DESC' , 'Die Region des Landes aus dem der Versand erfolgt.');

define('EXPECTED_PRODUCTS_SORT_TITLE' , 'Reihenfolge f&uuml;r Artikelank&uuml;ndigungen');
define('EXPECTED_PRODUCTS_SORT_DESC' , 'Das ist die Reihenfolge wie angek&uuml;ndigte Artikel angezeigt werden.');
define('EXPECTED_PRODUCTS_FIELD_TITLE' , 'Sortierfeld f&uuml;r Artikelank&uuml;ndigungen');
define('EXPECTED_PRODUCTS_FIELD_DESC' , 'Das ist die Spalte die zum Sortieren angek&uuml;ndigter Artikel benutzt wird.');

define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE' , 'Auf die Landesw&auml;hrung automatisch umstellen');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC' , 'Wenn die Spracheinstellung gewechselt wird automatisch die W&auml;hrung anpassen.');

define('SEND_EXTRA_ORDER_eMailS_TO_TITLE' , 'Senden einer extra Bestell-eMail an:');
define('SEND_EXTRA_ORDER_eMailS_TO_DESC' , 'Wenn zus&auml;tzlich eine Kopie des Bestell-eMails versendet werden soll, bitte in dieser Weise die Empfangs-Adressen auflisten: Name 1 &lt;eMail@adresse1&gt;, Name 2 &lt;eMail@adresse2&gt;');

define('SEARCH_ENGINE_FRIENDLY_URLS_TITLE' , 'Suchmaschinenfreundliche URLs benutzen?');
define('SEARCH_ENGINE_FRIENDLY_URLS_DESC' , 'Die Seiten URLs k&ouml;nnen automatisch f&uuml;r Suchmaschinen optimiert angezeigt werden.');

define('DISPLAY_CART_TITLE' , 'Soll Warenkorb nach dem einf&uuml;gen Angezeigt werden?');
define('DISPLAY_CART_DESC' , 'Nach dem hinzuf&uuml;gen eines Artikels zum Warenkorb, oder zur&uuml;ck zum Artikel?');

define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE' , 'G&auml;sten erlauben, ihre Bekannten per eMail zu informieren?');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC' , 'G&auml;sten erlauben, ihre Bekannten per eMail &uuml;ber Artikel zu informieren?');

define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE' , 'Suchverkn&uuml;pfungen');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC' , 'Standard Operator zum Verkn&uuml;pfen von Suchw&ouml;rtern.');

define('STORE_NAME_ADDRESS_TITLE' , 'Gesch&auml;ftsadresse und Telefonnummer etc');
define('STORE_NAME_ADDRESS_DESC' , 'Tragen Sie hier Ihre Gesch&auml;ftsadresse wie in einem Briefkopf ein.');

define('SHOW_COUNTS_TITLE' , 'Artikelanzahl hinter Kategorienamen?');
define('SHOW_COUNTS_DESC' , 'Z&auml;hlt rekursiv die Anzahl der verschiedenen Artikel pro Warengruppe, und zeigt die anzahl (x) hinter jedem Kategorienamen');

define('DISPLAY_PRICE_WITH_TAX_TITLE' , 'Preis inkl. MwSt. anzeigen');
define('DISPLAY_PRICE_WITH_TAX_DESC' , 'Preise inklusive Steuer anzeigen (true) oder am Ende aufrechnen (false)');

define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_TITLE' , 'Kundenstatus(Kundengruppe) f&uuml;r Administratoren');
define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_DESC' , 'W&auml;hlen Sie den Kundenstatus(Gruppe) f&uuml;r Administratoren anhand der jeweiligen ID!');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_TITLE' , 'Kundenstatus(Kundengruppe) f&uuml;r G&auml;ste');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_DESC' , 'W&auml;hlen Sie den Kundenstatus(Gruppe) f&uuml;r G&auml;ste anhand der jeweiligen ID!');
define('DEFAULT_CUSTOMERS_STATUS_ID_TITLE' , 'Kundenstatus f&uuml;r Neukunden');
define('DEFAULT_CUSTOMERS_STATUS_ID_DESC' , 'W&auml;hlen Sie den Kundenstatus(Gruppe) f&uuml;r G&auml;ste anhand der jeweiligen ID!<br />TIPP: Sie k&ouml;nnen im Men&uuml; Kundengruppen weitere Gruppen einrichten und zb Aktionswochen machen: Diese Woche 10 % Rabatt f&uuml;r alle Neukunden?');

define('ALLOW_ADD_TO_CART_TITLE' , 'Erlaubt, Artikel in den Einkaufswagen zu legen');
define('ALLOW_ADD_TO_CART_DESC' , 'Erlaubt das Einf&uuml;gen von Artikeln in den Warenkorb auch dann, wenn "Preise anzeigen" in der Kundengruppe auf "Nein" steht');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_TITLE' , 'Rabatte auch auf die Artikelattribute verwenden?');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_DESC' , 'Erlaubt, den eingestellten Rabatt der Kundengruppe auch auf die Artikelattribute anzuwenden (Nur wenn der Artikel nicht als "Sonderangebot" ausgewiesen ist)');
define('CURRENT_TEMPLATE_TITLE' , 'Templateset (Theme)');
define('CURRENT_TEMPLATE_DESC' , 'W&auml;hlen Sie ein Templateset (Theme) aus. Das Theme muss sich im Ordner www.Ihre-Domain.com/templates/ befinden.<br /><br />Weiter Themes finden sie unter <a href="http://shop.xtcommerce.com">http://shop.xtcommerce.com</a>');
define('CC_KEYCHAIN_TITLE','CC String');
define('CC_KEYCHAIN_DESC','String zur verschl&uuml;sselung der CC Informationen (Bitte umbedingt &auml;ndern!)');

define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE' , 'Vorname');
define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC' , 'Minimum L&auml;nge des Vornamens');
define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE' , 'Nachname');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC' , 'Minimum L&auml;nge des Nachnamens');
define('ENTRY_DOB_MIN_LENGTH_TITLE' , 'Geburtsdatum');
define('ENTRY_DOB_MIN_LENGTH_DESC' , 'Minimum L&auml;nge des Geburtsdatums');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE' , 'eMail Adresse');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC' , 'Minimum L&auml;nge der eMail Adresse');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE' , 'Strasse');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC' , 'Minimum L&auml;nge der Strassenanschrift');
define('ENTRY_COMPANY_MIN_LENGTH_TITLE' , 'Firma');
define('ENTRY_COMPANY_MIN_LENGTH_DESC' , 'Minimuml&auml;nge des Firmennamens');
define('ENTRY_POSTCODE_MIN_LENGTH_TITLE' , 'Postleitzahl');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC' , 'Minimum L&auml;nge der Postleitzahl');
define('ENTRY_CITY_MIN_LENGTH_TITLE' , 'Stadt');
define('ENTRY_CITY_MIN_LENGTH_DESC' , 'Minimum L&auml;nge des St&auml;dtenamens');
define('ENTRY_STATE_MIN_LENGTH_TITLE' , 'Bundesland');
define('ENTRY_STATE_MIN_LENGTH_DESC' , 'Minimum L&auml;nge des Bundeslandes');
define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE' , 'Telefon Nummer');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC' , 'Minimum L&auml;nge der Telefon Nummer');
define('ENTRY_PASSWORD_MIN_LENGTH_TITLE' , 'Passwort');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC' , 'Minimum L&auml;nge des Passwort');

define('CC_OWNER_MIN_LENGTH_TITLE' , 'Kreditkarteninhaber');
define('CC_OWNER_MIN_LENGTH_DESC' , 'Minimum L&auml;nge des Namens des Kreditkarteninhabers');
define('CC_NUMBER_MIN_LENGTH_TITLE' , 'Kreditkartennummer');
define('CC_NUMBER_MIN_LENGTH_DESC' , 'Minimum L&auml;nge von Kreditkartennummern');

define('REVIEW_TEXT_MIN_LENGTH_TITLE' , 'Bewertungen');
define('REVIEW_TEXT_MIN_LENGTH_DESC' , 'Minimum L&auml;nge der Texteingabe bei Bewertungen');

define('MIN_DISPLAY_BESTSELLERS_TITLE' , 'Bestseller');
define('MIN_DISPLAY_BESTSELLERS_DESC' , 'Minimum Anzahl der Bestseller, die angezeigt werden sollen');
define('MIN_DISPLAY_ALSO_PURCHASED_TITLE' , 'Ebenfalls gekauft');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC' , 'Minimum Anzahl der ebenfalls gekauften Artikel, die bei der Artikelansicht angezeigt werden sollen');
 
define('MAX_ADDRESS_BOOK_ENTRIES_TITLE' , 'Adressbuch Eintr&auml;ge');
define('MAX_ADDRESS_BOOK_ENTRIES_DESC' , 'Maximum erlaubte Anzahl an Adressbucheintr&auml;gen');
define('MAX_DISPLAY_SEARCH_RESULTS_TITLE' , 'Suchergebnisse');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC' , 'Anzahl der Artikel die als Suchergebnis angezeigt werden sollen');
define('MAX_DISPLAY_PAGE_LINKS_TITLE' , 'Seiten bl&auml;ttern');
define('MAX_DISPLAY_PAGE_LINKS_DESC' , 'Anzahl der Einzelseiten, f&uuml;r die ein Link angezeigt werden soll im Seitennavigationsmen&uuml;');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE' , 'Sonderangebote');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC' , 'Maximum Anzahl an Sonderangeboten, die angezeigt werden sollen');
define('MAX_DISPLAY_NEW_PRODUCTS_TITLE' , 'Neue Artikel Anzeigemodul');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC' , 'Maximum Anzahl an neuen Artikeln, die bei den Warenkategorien angezeigt werden sollen');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE' , 'Erwartete Artikel Anzeigemodul');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC' , 'Maximum Anzahl an erwarteten Artikeln die auf der Startseite angezeigt werden sollen');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE' , 'Hersteller-Liste Schwellenwert');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC' , 'In der Hersteller Box; Wenn die Anzahl der Hersteller diese Schwelle &uuml;bersteigt wird anstatt der &uuml;blichen Liste eine Popup Liste angezeigt');
define('MAX_MANUFACTURERS_LIST_TITLE' , 'Hersteller Liste');
define('MAX_MANUFACTURERS_LIST_DESC' , 'In der Hersteller Box; Wenn der Wert auf "1" gesetzt wird, wird die Herstellerbox als Drop Down Liste angezeigt. Andernfalls als Liste.');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE' , 'L&auml;nge des Herstellernamens');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC' , 'In der Hersteller Box; Maximum L&auml;nge von Namen in der Herstellerbox');
define('MAX_DISPLAY_NEW_REVIEWS_TITLE' , 'Neue Bewertungen');
define('MAX_DISPLAY_NEW_REVIEWS_DESC' , 'Maximum Anzahl an neuen Bewertungen die angezeigt werden sollen');
define('MAX_RANDOM_SELECT_REVIEWS_TITLE' , 'Auswahlpool der Bewertungen');
define('MAX_RANDOM_SELECT_REVIEWS_DESC' , 'Aus wieviel Bewertungen sollen die zuf&auml;llig angezeigten Bewertungen in der Box ausgew&auml;hlt werden?');
define('MAX_RANDOM_SELECT_NEW_TITLE' , 'Auswahlpool der Neuen Artikel');
define('MAX_RANDOM_SELECT_NEW_DESC' , 'Aus wieviel neuen Artikeln sollen die zuf&auml;llig angezeigten neuen Artikel in der Box ausgew&auml;hlt werden?');
define('MAX_RANDOM_SELECT_SPECIALS_TITLE' , 'Auswahlpool der Sonderangebote');
define('MAX_RANDOM_SELECT_SPECIALS_DESC' , 'Aus wieviel Sonderangeboten sollen die zuf&auml;llig angezeigten Sonderangebote in der Box ausgew&auml;hlt werden?');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE' , 'Anzahl an Warengruppen');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC' , 'Anzahl an Warengruppen die pro Zeile in den &Uuml;bersichten angezeigt werden sollen.');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE' , 'Neue Artikel Liste');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC' , 'Maximum Anzahl neuer Artikel die in der Liste angezeigt werden sollen.');
define('MAX_DISPLAY_BESTSELLERS_TITLE' , 'Bestsellers');
define('MAX_DISPLAY_BESTSELLERS_DESC' , 'Maximum Anzahl an Bestsellern die angezeigt werden sollen');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE' , 'Ebenfalls gekauft');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC' , 'Maximum Anzahl der ebenfalls gekauften Artikel, die bei der Artikelansicht angezeigt werden sollen');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE' , 'Bestell&uuml;bersichts Box');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC' , 'Maximum Anzahl an Artikeln die in der pers&ouml;nlichen Bestell&uuml;bersichts Box des Kunden angezeigt werden sollen.');
define('MAX_DISPLAY_ORDER_HISTORY_TITLE' , 'Bestell&uuml;bersicht');
define('MAX_DISPLAY_ORDER_HISTORY_DESC' , 'Maximum Anzahl an Bestellungen die in der &Uuml;bersicht im Kundenbereich des Shop angezeigt werden sollen.');
define('MAX_PRODUCTS_QTY_TITLE', 'Maximale Produktanzahl');
define('MAX_PRODUCTS_QTY_DESC', 'Maximale Produktanzahl, die man eingeben kann');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_TITLE' , 'Anzahl der Tage f&uuml;r Neue Produkte');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_DESC' , 'Maximum Anzahl an Tagen die neue Artikel angezeigt werden sollen');

define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_TITLE' , 'Breite der Artikel-Thumbnails');
define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_DESC' , 'Maximale Breite der Artikel-Thumbnails in Pixel');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_TITLE' , 'H&ouml;he der Artikel-Thumbnails');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_DESC' , 'Maximale H&ouml;he der Artikel-Thumbnails in Pixel');

define('PRODUCT_IMAGE_INFO_WIDTH_TITLE' , 'Breite der Artikel-Info Bilder');
define('PRODUCT_IMAGE_INFO_WIDTH_DESC' , 'Maximale Breite der Artikel-Info Bilder in Pixel');
define('PRODUCT_IMAGE_INFO_HEIGHT_TITLE' , 'H&ouml;he der Artikel-Info Bilder');
define('PRODUCT_IMAGE_INFO_HEIGHT_DESC' , 'Maximale H&ouml;he der Artikel-Info Bilder in Pixel');

define('PRODUCT_IMAGE_POPUP_WIDTH_TITLE' , 'Breite der Artikel-Popup Bilder');
define('PRODUCT_IMAGE_POPUP_WIDTH_DESC' , 'Maximale Breite der Artikel-Popup Bilder in Pixel');
define('PRODUCT_IMAGE_POPUP_HEIGHT_TITLE' , 'H&ouml;he der Artikel-Popup Bilder');
define('PRODUCT_IMAGE_POPUP_HEIGHT_DESC' , 'Maximale H&ouml;he der Artikel-Popup Bilder in Pixel');

define('SMALL_IMAGE_WIDTH_TITLE' , 'Breite der Artikel Bilder');
define('SMALL_IMAGE_WIDTH_DESC' , 'Maximale Breite der Artikel Bilder in Pixel');
define('SMALL_IMAGE_HEIGHT_TITLE' , 'H&ouml;he der Artikel Bilder');
define('SMALL_IMAGE_HEIGHT_DESC' , 'Maximale H&ouml;he der Artikel Bilderin Pixel');

define('HEADING_IMAGE_WIDTH_TITLE' , 'Breite der &Uuml;berschrift Bilder');
define('HEADING_IMAGE_WIDTH_DESC' , 'Maximale Breite der &Uuml;berschrift Bilder in Pixel');
define('HEADING_IMAGE_HEIGHT_TITLE' , 'H&ouml;he der &Uuml;berschrift Bilder');
define('HEADING_IMAGE_HEIGHT_DESC' , 'Maximale H&ouml;he der &Uuml;berschriftbilder in Pixel');

define('SUBCATEGORY_IMAGE_WIDTH_TITLE' , 'Breite der Subkategorie-(Warengruppen-) Bilder');
define('SUBCATEGORY_IMAGE_WIDTH_DESC' , 'Maximale Breite der Subkategorie-(Warengruppen-) Bilder in Pixel');
define('SUBCATEGORY_IMAGE_HEIGHT_TITLE' , 'H&ouml;he der Subkategorie-(Warengruppen-) Bilder');
define('SUBCATEGORY_IMAGE_HEIGHT_DESC' , 'Maximale H&ouml;he der Subkategorie-(Warengruppen-) Bilder in Pixel');

define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE' , 'Bildgr&ouml;sse berechnen');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC' , 'Sollen die Bildgr&ouml;ssen berechnet werden?');

define('IMAGE_REQUIRED_TITLE' , 'Bilder werden ben&ouml;tigt?');
define('IMAGE_REQUIRED_DESC' , 'Wenn Sie hier auf "1" setzen, werden nicht vorhandene Bilder als Rahmen angezeigt. Gut f&uuml;r Entwickler.');

define('MO_PICS_TITLE', 'Anzahl zus&auml;tzlicher Produktbilder');
define('MO_PICS_DESC', 'Anzahl der Produktbilder die zus&auml;tzlich zum Haupt-Produktbild zur Verf&uuml;gung stehen sollen.');

//This is for the Images showing your products for preview. All the small stuff.

define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_TITLE' , 'Artikel-Thumbnails:Bevel<br /><img src="images/config_bevel.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_DESC' , 'Artikel-Thumbnails:Bevel<br /><br />Default Wert: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Verwendung:<br />(edge width,hex light colour,hex dark colour)');

define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_TITLE' , 'Artikel-Thumbnails:Greyscale<br /><img src="images/config_greyscale.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_DESC' , 'Artikel-Thumbnails:Greyscale<br /><br />Default Wert: (32,22,22)<br /><br />basic black n white<br />Verwendung:<br />(int red,int green,int blue)');

define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_TITLE' , 'Artikel-Thumbnails:Ellipse<br /><img src="images/config_eclipse.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_DESC' , 'Artikel-Thumbnails:Ellipse<br /><br />Default Wert: (FFFFFF)<br /><br />ellipse on bg colour<br />Verwendung:<br />(hex background colour)');

define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_TITLE' , 'Artikel-Thumbnails:Round-edges<br /><img src="images/config_edge.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_DESC' , 'Artikel-Thumbnails:Round-edges<br /><br />Default Wert: (5,FFFFFF,3)<br /><br />corner trimming<br />Verwendung:<br />(edge_radius,background colour,anti-alias width)');

define('PRODUCT_IMAGE_THUMBNAIL_MERGE_TITLE' , 'Artikel-Thumbnails:Merge<br /><img src="images/config_merge.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_DESC' , 'Artikel-Thumbnails:Merge<br /><br />Default Wert: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Verwendung:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity, transparent colour on merge image)');

define('PRODUCT_IMAGE_THUMBNAIL_FRAME_TITLE' , 'Artikel-Thumbnails:Frame<br /><img src="images/config_frame.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_DESC' , 'Artikel-Thumbnails:Frame<br /><br />Default Wert: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Verwendung:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');

define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_TITLE' , 'Artikel-Thumbnails:Drop-Shadow<br /><img src="images/config_shadow.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_DESC' , 'Artikel-Thumbnails:Drop-Shadow<br /><br />Default Wert: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Verwendung:<br />(shadow width,hex shadow colour,hex background colour)');

define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_TITLE' , 'Artikel-Thumbnails:Motion-Blur<br /><img src="images/config_motion.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_DESC' , 'Artikel-Thumbnails:Motion-Blur<br /><br />Default Wert: (4,FFFFFF)<br /><br />fading parallel lines<br />Verwendung:<br />(int number of lines,hex background colour)');

//And this is for the Images showing your products in single-view

define('PRODUCT_IMAGE_INFO_BEVEL_TITLE' , 'Artikel-Info Bilder:Bevel');
define('PRODUCT_IMAGE_INFO_BEVEL_DESC' , 'Artikel-Info Bilder:Bevel<br /><br />Default Wert: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Verwendung:<br />(edge width, hex light colour, hex dark colour)');

define('PRODUCT_IMAGE_INFO_GREYSCALE_TITLE' , 'Artikel-Info Bilder:Greyscale');
define('PRODUCT_IMAGE_INFO_GREYSCALE_DESC' , 'Artikel-Info Bilder:Greyscale<br /><br />Default Wert: (32,22,22)<br /><br />basic black n white<br />Verwendung:<br />(int red, int green, int blue)');

define('PRODUCT_IMAGE_INFO_ELLIPSE_TITLE' , 'Artikel-Info Bilder:Ellipse');
define('PRODUCT_IMAGE_INFO_ELLIPSE_DESC' , 'Artikel-Info Bilder:Ellipse<br /><br />Default Wert: (FFFFFF)<br /><br />ellipse on bg colour<br />Verwendung:<br />(hex background colour)');

define('PRODUCT_IMAGE_INFO_ROUND_EDGES_TITLE' , 'Artikel-Info Bilder:Round-edges');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_DESC' , 'Artikel-Info Bilder:Round-edges<br /><br />Default Wert: (5,FFFFFF,3)<br /><br />corner trimming<br />Verwendung:<br />( edge_radius, background colour, anti-alias width)');

define('PRODUCT_IMAGE_INFO_MERGE_TITLE' , 'Artikel-Info Bilder:Merge');
define('PRODUCT_IMAGE_INFO_MERGE_DESC' , 'Artikel-Info Bilder:Merge<br /><br />Default Wert: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Verwendung:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');

define('PRODUCT_IMAGE_INFO_FRAME_TITLE' , 'Artikel-Info Bilder:Frame');
define('PRODUCT_IMAGE_INFO_FRAME_DESC' , 'Artikel-Info Bilder:Frame<br /><br />Default Wert: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Verwendung:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');

define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_TITLE' , 'Artikel-Info Bilder:Drop-Shadow');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_DESC' , 'Artikel-Info Bilder:Drop-Shadow<br /><br />Default Wert: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Verwendung:<br />(shadow width,hex shadow colour,hex background colour)');

define('PRODUCT_IMAGE_INFO_MOTION_BLUR_TITLE' , 'Artikel-Info Bilder:Motion-Blur');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_DESC' , 'Artikel-Info Bilder:Motion-Blur<br /><br />Default Wert: (4,FFFFFF)<br /><br />fading parallel lines<br />Verwendung:<br />(int number of lines,hex background colour)');

//so this image is the biggest in the shop this 

define('PRODUCT_IMAGE_POPUP_BEVEL_TITLE' , 'Artikel-Popup Bilder:Bevel');
define('PRODUCT_IMAGE_POPUP_BEVEL_DESC' , 'Artikel-Popup Bilder:Bevel<br /><br />Default Wert: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Verwendung:<br />(edge width,hex light colour,hex dark colour)');

define('PRODUCT_IMAGE_POPUP_GREYSCALE_TITLE' , 'Artikel-Popup Bilder:Greyscale');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_DESC' , 'Artikel-Popup Bilder:Greyscale<br /><br />Default Wert: (32,22,22)<br /><br />basic black n white<br />Verwendung:<br />(int red,int green,int blue)');

define('PRODUCT_IMAGE_POPUP_ELLIPSE_TITLE' , 'Artikel-Popup Bilder:Ellipse');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_DESC' , 'Artikel-Popup Bilder:Ellipse<br /><br />Default Wert: (FFFFFF)<br /><br />ellipse on bg colour<br />Verwendung:<br />(hex background colour)');

define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_TITLE' , 'Artikel-Popup Bilder:Round-edges');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_DESC' , 'Artikel-Popup Bilder:Round-edges<br /><br />Default Wert: (5,FFFFFF,3)<br /><br />corner trimming<br />Verwendung:<br />(edge_radius,background colour,anti-alias width)');

define('PRODUCT_IMAGE_POPUP_MERGE_TITLE' , 'Artikel-Popup Bilder:Merge');
define('PRODUCT_IMAGE_POPUP_MERGE_DESC' , 'Artikel-Popup Bilder:Merge<br /><br />Default Wert: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Verwendung:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');

define('PRODUCT_IMAGE_POPUP_FRAME_TITLE' , 'Artikel-Popup Bilder:Frame');
define('PRODUCT_IMAGE_POPUP_FRAME_DESC' , 'Artikel-Popup Bilder:Frame<br /><br />Default Wert: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Verwendung:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');

define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_TITLE' , 'Artikel-Popup Bilder:Drop-Shadow');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_DESC' , 'Artikel-Popup Bilder:Drop-Shadow<br /><br />Default Wert: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Verwendung:<br />(shadow width,hex shadow colour,hex background colour)');

define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_TITLE' , 'Artikel-Popup Bilder:Motion-Blur');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_DESC' , 'Artikel-Popup Bilder:Motion-Blur<br /><br />Default Wert: (4,FFFFFF)<br /><br />fading parallel lines<br />Verwendung:<br />(int number of lines,hex background colour)');

define('IMAGE_MANIPULATOR_TITLE','GDlib processing');
define('IMAGE_MANIPULATOR_DESC','Image Manipulator f&uuml;r GD2 oder GD1');


define('ACCOUNT_GENDER_TITLE' , 'Anrede');
define('ACCOUNT_GENDER_DESC' , 'Die Abfrage f&uuml;r die Anrede im Account benutzen');
define('ACCOUNT_DOB_TITLE' , 'Geburtsdatum');
define('ACCOUNT_DOB_DESC' , 'Die Abfrage f&uuml;r das Geburtsdatum im Account benutzen');
define('ACCOUNT_COMPANY_TITLE' , 'Firma');
define('ACCOUNT_COMPANY_DESC' , 'Die Abfrage f&uuml;r die Firma im Account benutzen');
define('ACCOUNT_SUBURB_TITLE' , 'Vorort');
define('ACCOUNT_SUBURB_DESC' , 'Die Abfrage f&uuml;r den Vorort im Account benutzen');
define('ACCOUNT_STATE_TITLE' , 'Bundesland');
define('ACCOUNT_STATE_DESC' , 'Die Abfrage f&uuml;r das Bundesland im Account benutzen');


define('DEFAULT_CURRENCY_TITLE' , 'Standard W&auml;hrung');
define('DEFAULT_CURRENCY_DESC' , 'W&auml;hrung die standardm&auml;ssig benutzt wird');
define('DEFAULT_LANGUAGE_TITLE' , 'Standard Sprache');
define('DEFAULT_LANGUAGE_DESC' , 'Sprache die standardm&auml;ssig benutzt wird');
define('DEFAULT_ORDERS_STATUS_ID_TITLE' , 'Standard Bestellstatus bei neuen Bestellungen');
define('DEFAULT_ORDERS_STATUS_ID_DESC' , 'Wenn eine neue Bestellung eingeht, wird dieser Status als Bestellstatus gesetzt.');

define('SHIPPING_ORIGIN_COUNTRY_TITLE' , 'Versandland');
define('SHIPPING_ORIGIN_COUNTRY_DESC' , 'W&auml;hlen Sie das Versandland aus, zur Berechnung korrekter Versandgeb&uuml;hren.');
define('SHIPPING_ORIGIN_ZIP_TITLE' , 'Postleitzahl des Versandstandortes');
define('SHIPPING_ORIGIN_ZIP_DESC' , 'Bitte geben Sie die Postleitzahl des Versandstandortes ein, der zur Berechnung der Versandkosten in Frage kommt.');
define('SHIPPING_MAX_WEIGHT_TITLE' , 'Maximalgewicht, dass als ein Paket versendet werden kann');
define('SHIPPING_MAX_WEIGHT_DESC' , 'Versandpartner(Post/UPS etc haben ein maximales Paketgewicht. Geben Sie einen Wert daf&uuml;r ein.');
define('SHIPPING_BOX_WEIGHT_TITLE' , 'Paketleergewicht.');
define('SHIPPING_BOX_WEIGHT_DESC' , 'Wie hoch ist das Gewicht eines durchschnittlichen kleinen bis mittleren Leerpaketes?');
define('SHIPPING_BOX_PADDING_TITLE' , 'Bei gr&ouml;sseren Leerpaketen - Gewichtszuwachs in %.');
define('SHIPPING_BOX_PADDING_DESC' , 'F&uuml;r etwa 10% geben Sie 10 ein');
define('SHOW_SHIPPING_DESC' , 'Verlinkte Anzeige von "zzgl. Versandkosten" in den Produktinformationen.');
define('SHOW_SHIPPING_TITLE' , 'Versandkosten in Produktinfos');
define('SHIPPING_INFOS_DESC' , 'Sprachgruppen ID der Versandkosten (Default 1) f&uuml;r die Verlinkung.');
define('SHIPPING_INFOS_TITLE' , 'Versandkosten ID');

define('PRODUCT_LIST_FILTER_TITLE' , 'Anzeige der Sortierungsfilter in Artikellisten?');
define('PRODUCT_LIST_FILTER_DESC' , 'Anzeige der Sortierungsfilter f&uuml;r Warengruppen/Hersteller etc Filter (0=inaktiv; 1=aktiv)');

define('STOCK_CHECK_TITLE' , '&Uuml;berpr&uuml;fen des Warenbestandes');
define('STOCK_CHECK_DESC' , 'Pr&uuml;fen ob noch genug Ware zum Ausliefern von Bestellungen verf&uuml;gbar ist.');

define('ATTRIBUTE_STOCK_CHECK_TITLE' , '&Uuml;berpr&uuml;fen des Artikelattribut Bestandes');
define('ATTRIBUTE_STOCK_CHECK_DESC' , '&Uuml;berpr&uuml;fen des Bestandes an Ware mit bestimmten Artikelattributen');

define('STOCK_LIMITED_TITLE' , 'Warenmenge abziehen');
define('STOCK_LIMITED_DESC' , 'Warenmenge im Warenbestand abziehen, wenn die Ware bestellt wurde');
define('STOCK_ALLOW_CHECKOUT_TITLE' , 'Einkaufen nicht vorr&auml;tiger Ware erlauben');
define('STOCK_ALLOW_CHECKOUT_DESC' , 'M&ouml;chten Sie auch dann erlauben zu bestellen, wenn bestimmte Ware laut Warenbestand nicht verf&uuml;gbar ist?');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE' , 'Kennzeichnung vergriffener Artikel');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC' , 'Dem Kunden kenntlich machen, welche Artikel nicht mehr verf&uuml;gbar sind.');
define('STOCK_REORDER_LEVEL_TITLE' , 'Meldung an den Admin dass ein Artikel nachbestellt werden muss');
define('STOCK_REORDER_LEVEL_DESC' , 'Ab welcher St&uuml;ckzahl soll diese Meldung erscheinen?');

define('STORE_PAGE_PARSE_TIME_TITLE' , 'Speichern der Berechnungszeit der Seite');
define('STORE_PAGE_PARSE_TIME_DESC' , 'Speicher der Zeit die ben&ouml;tigt wird, um Skripte bis zum Output der Seite zu berechnen');
define('STORE_PAGE_PARSE_TIME_LOG_TITLE' , 'Speicherort des Logfile der Berechnungszeit');
define('STORE_PAGE_PARSE_TIME_LOG_DESC' , 'Ordner und Filenamen eintragen f&uuml;r den Logfile f&uuml;r Berechnung der Parsing Dauer');
define('STORE_PARSE_DATE_TIME_FORMAT_TITLE' , 'Log Datum Format');
define('STORE_PARSE_DATE_TIME_FORMAT_DESC' , 'Das Datumsformat f&uuml;r Logging');

define('DISPLAY_PAGE_PARSE_TIME_TITLE' , 'Berechnungszeiten der Seiten anzeigen');
define('DISPLAY_PAGE_PARSE_TIME_DESC' , 'Wenn das Speichern der Berechnungszeiten f&uuml;r Seiten eingeschaltet ist, k&ouml;nnen diese im Footer angezeigt werden.');

define('STORE_DB_TRANSACTIONS_TITLE' , 'Speichern der Database Queries');
define('STORE_DB_TRANSACTIONS_DESC' , 'Speichern der einzelnen Datenbank Queries im Logfile f&uuml;r Berechnungszeiten (PHP4 only)');

define('USE_CACHE_TITLE' , 'Cache benutzen');
define('USE_CACHE_DESC' , 'Die Cache Features verwenden');

define('DB_CACHE_TITLE','DB Cache');
define('DB_CACHE_DESC','SELECT Abfragen k&ouml;nnen von xt:Commerce gecached werden, um die Datenbankabfragen zu veringern, und die Geschwindigkeit zu erh&ouml;hen');

define('DB_CACHE_EXPIRE_TITLE','DB Cache Lebenszeit');
define('DB_CACHE_EXPIRE_DESC','Zeit in Sekunden, bevor Cache Datein mit Daten aus der Datenbank automatisch &Uuml;berschrieben werden.');

define('DIR_FS_CACHE_TITLE' , 'Cache Ordner');
define('DIR_FS_CACHE_DESC' , 'Der Ordner wo die gecachten Files gespeichert werden sollen');

define('ACCOUNT_OPTIONS_TITLE','Art der Kontoerstellung');
define('ACCOUNT_OPTIONS_DESC','Wie m&ouml;chten Sie die Anmeldeprozedur in Ihrem Shop gestallten ?<br />Sie haben die Wahl zwischen Kundenkonten und "einmal Bestellungen" ohne erstellung eines Kundenkontos (es wird ein Konto erstellt, aber dies ist f&uuml;r den Kunden nicht ersichtlich)');

define('EMAIL_TRANSPORT_TITLE' , 'eMail Transport Methode');
define('EMAIL_TRANSPORT_DESC' , 'Definiert ob der Server eine lokale Verbindung zum "Sendmail-Programm" benutzt oder ob er eine SMTP Verbindung &uuml;ber TCP/IP ben&ouml;tigt. Server die auf Windows oder MacOS laufen sollten SMTP verwenden.');

define('EMAIL_LINEFEED_TITLE' , 'eMail Linefeeds');
define('EMAIL_LINEFEED_DESC' , 'Definiert die Zeichen die benutzt werden sollen um die Mail Header zu trennen.');
define('EMAIL_USE_HTML_TITLE' , 'Benutzen von MIME HTML beim Versand von eMails');
define('EMAIL_USE_HTML_DESC' , 'eMails im HTML Format versenden');
define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE' , '&Uuml;berpr&uuml;fen der eMail Adressen &uuml;ber DNS');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC' , 'Die eMail Adressen k&ouml;nnen &uuml;ber einen DNS Server gepr&uuml;ft werden');
define('SEND_EMAILS_TITLE' , 'Senden von eMails');
define('SEND_EMAILS_DESC' , 'eMails an Kunden versenden (bei Bestellungen etc)');
define('SENDMAIL_PATH_TITLE' , 'Der Pfad zu Sendmail');
define('SENDMAIL_PATH_DESC' , 'Wenn Sie Sendmail benutzen, geben Sie hier den Pfad zum Sendmail Programm an(normalerweise: /usr/bin/sendmail):');
define('SMTP_MAIN_SERVER_TITLE' , 'Adresse des SMTP Servers');
define('SMTP_MAIN_SERVER_DESC' , 'Geben Sie die Adresse Ihres Haupt SMTP Servers ein.');
define('SMTP_BACKUP_SERVER_TITLE' , 'Adresse des SMTP Backup Servers');
define('SMTP_BACKUP_SERVER_DESC' , 'Geben Sie die Adresse Ihres Backup SMTP Servers ein.');
define('SMTP_USERNAME_TITLE' , 'SMTP Username');
define('SMTP_USERNAME_DESC' , 'Bitte geben Sie hier den Usernamen Ihres SMTP Accounts ein.');
define('SMTP_PASSWORD_TITLE' , 'SMTP Passwort');
define('SMTP_PASSWORD_DESC' , 'Bitte geben Sie hier das Passwort Ihres SMTP Accounts ein.');
define('SMTP_AUTH_TITLE' , 'SMTP AUTH');
define('SMTP_AUTH_DESC' , 'Erfordert der SMTP Server eine sichere Authentifizierung?');
define('SMTP_PORT_TITLE' , 'SMTP Port');
define('SMTP_PORT_DESC' , 'Geben sie den SMTP Port Ihres SMTP Servers ein (default: 25)?');

//Constants for contact_us
define('CONTACT_US_EMAIL_ADDRESS_TITLE' , 'Kontakt - eMail Adresse');
define('CONTACT_US_EMAIL_ADDRESS_DESC' , 'Bitte geben Sie eine korrekte Absender Adresse f&uuml;r das Versenden der eMails &uuml;ber das "Kontakt" Formular ein.');
define('CONTACT_US_NAME_TITLE' , 'Kontakt - eMail Adresse, Name');
define('CONTACT_US_NAME_DESC' , 'Bitte geben Sie einen Absender Namen f&uuml;r das Versenden der eMails &uuml;ber das "Kontakt" Formular ein.');
define('CONTACT_US_FORWARDING_STRING_TITLE' , 'Kontakt - Weiterleitungsadressen');
define('CONTACT_US_FORWARDING_STRING_DESC' , 'Geben Sie weitere Mailadressen ein, an welche die eMails des "Kontakt" Formulares noch versendet werden sollen (mit , getrennt)');
define('CONTACT_US_REPLY_ADDRESS_TITLE' , 'Kontakt - Antwortadresse');
define('CONTACT_US_REPLY_ADDRESS_DESC' , 'Bitte geben Sie eine eMailadresse ein, an die Ihre Kunden Antworten k&ouml;nnen.');
define('CONTACT_US_REPLY_ADDRESS_NAME_TITLE' , 'Kontakt - Antwortadresse, Name');
define('CONTACT_US_REPLY_ADDRESS_NAME_DESC' , 'Absendername f&uuml;r Antwortmails.');
define('CONTACT_US_EMAIL_SUBJECT_TITLE' , 'Kontakt - eMail Betreff');
define('CONTACT_US_EMAIL_SUBJECT_DESC' , 'Betreff f&uuml;r eMails vom Kontaktformular des Shops');

//Constants for support system
define('EMAIL_SUPPORT_ADDRESS_TITLE' , 'Technischer Support - eMail Adresse');
define('EMAIL_SUPPORT_ADDRESS_DESC' , 'Bitte geben Sie eine korrekte Absender Adresse f&uuml;r das Versenden der eMails &uuml;ber das <b>Support System</b> ein (Kontoerstellung,Password&auml;nderung).');
define('EMAIL_SUPPORT_NAME_TITLE' , 'Technischer Support - eMail Adresse, Name');
define('EMAIL_SUPPORT_NAME_DESC' , 'Bitte geben Sie einen Absender Namen f&uuml;r das Versenden der mails &uuml;ber das <b>Support System</b> ein (Kontoerstellung,Password&auml;nderung).');
define('EMAIL_SUPPORT_FORWARDING_STRING_TITLE' , 'Technischer Support - Weiterleitungsadressen');
define('EMAIL_SUPPORT_FORWARDING_STRING_DESC' , 'Geben Sie weitere eMailadressen ein, an welche die eMails des <b>Support Systems</b> noch versendet werden sollen (mit , getrennt)');
define('EMAIL_SUPPORT_REPLY_ADDRESS_TITLE' , 'Technischer Support - Antwortadresse');
define('EMAIL_SUPPORT_REPLY_ADDRESS_DESC' , 'Bitte geben Sie eine eMailadresse ein, an die Ihre Kunden Antworten k&ouml;nnen.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_TITLE' , 'Technischer Support - Antwortadresse, Name');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_DESC' , 'Absendername f&uuml;r Antwortmails.');
define('EMAIL_SUPPORT_SUBJECT_TITLE' , 'Technischer Support - eMail Betreff');
define('EMAIL_SUPPORT_SUBJECT_DESC' , 'Betreff f&uuml;r eMails des <b>Support Systems</b>.');

//Constants for Billing system
define('EMAIL_BILLING_ADDRESS_TITLE' , 'Verrechnung - eMail Adresse');
define('EMAIL_BILLING_ADDRESS_DESC' , 'Bitte geben Sie eine korrekte Absenderadresse f&uuml;r das Versenden der mails &uuml;ber das <b>Verrechnungssystem</b> ein (Bestellbest&auml;tigung,Status&auml;nderungen,..).');
define('EMAIL_BILLING_NAME_TITLE' , 'Verrechnung - Mail Adresse, Name');
define('EMAIL_BILLING_NAME_DESC' , 'Bitte geben Sie einen Absendernamen f&uuml;r das Versenden der eMails &uuml;ber das <b>Verrechnungssystem</b> ein (Bestellbest&auml;tigung,Status&auml;nderungen,..).');
define('EMAIL_BILLING_FORWARDING_STRING_TITLE' , 'Verrechnung - Weiterleitungsadressen');
define('EMAIL_BILLING_FORWARDING_STRING_DESC' , 'Geben Sie weitere Mailadressen ein, wohin die eMails des <b>Verrechnungssystem</b> noch versendet werden sollen (mit , getrennt)');
define('EMAIL_BILLING_REPLY_ADDRESS_TITLE' , 'Verrechnung - Antwortadresse');
define('EMAIL_BILLING_REPLY_ADDRESS_DESC' , 'Bitte geben Sie eine eMailadresse ein, an die Ihre Kunden Antworten k&ouml;nnen.');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_TITLE' , 'Verrechnung - Antwortadresse, Name');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_DESC' , 'Absendername f&uuml;r replay eMails.');
define('EMAIL_BILLING_SUBJECT_TITLE' , 'Verrechnung - eMail Betreff');
define('EMAIL_BILLING_SUBJECT_DESC' , 'Geben Sie bitte einen eMailbetreff f&uuml;r eMails des <b>Verrechnungs-Systems</b> Ihres Shops ein.');
define('EMAIL_BILLING_SUBJECT_ORDER_TITLE','Verrechnung - eMail Betreff');
define('EMAIL_BILLING_SUBJECT_ORDER_DESC','Geben Sie bitte einen eMailbetreff f&uuml;r Ihre Bestellmails an. (zb: <b>Ihre Bestellung {$nr},am {$date}</b>) ps: folgende Variablen stehen zur Verf&uuml;gung, {$nr},{$date},{$firstname},{$lastname}');


define('DOWNLOAD_ENABLED_TITLE' , 'Download von Artikeln erlauben');
define('DOWNLOAD_ENABLED_DESC' , 'Die Artikel Download Funktionen einschalten (Software etc).');
define('DOWNLOAD_BY_REDIRECT_TITLE' , 'Download durch Redirection');
define('DOWNLOAD_BY_REDIRECT_DESC' , 'Browser-Umleitung f&uuml;r Artikeldownloads benutzen. Auf nicht Linux/Unix Systemen ausschalten.');
define('DOWNLOAD_MAX_DAYS_TITLE' , 'Verfallsdatum der Download Links(Tage)');
define('DOWNLOAD_MAX_DAYS_DESC' , 'Anzahl an Tagen, die ein Download Link f&uuml;r den Kunden aktiv bleibt. 0 bedeutet ohne Limit.');
define('DOWNLOAD_MAX_COUNT_TITLE' , 'Maximale Anzahl der Downloads eines gekauften Medienproduktes');
define('DOWNLOAD_MAX_COUNT_DESC' , 'Stellen Sie die maximale Anzahl an Downloads ein, die Sie dem Kunden erlauben, der einen Artikel dieser Art erworben hat. 0 bedeutet kein Download.');

define('GZIP_COMPRESSION_TITLE' , 'GZip Kompression einschalten');
define('GZIP_COMPRESSION_DESC' , 'Schalten Sie HTTP GZip Kompression ein um die Seitenaufbaugeschwindigkeit zu optimieren.');
define('GZIP_LEVEL_TITLE' , 'Kompressions Level');
define('GZIP_LEVEL_DESC' , 'W&auml;hlen Sie einen Kompressionslevel zwischen 0-9 (0 = Minimum, 9 = Maximum).');

define('SESSION_WRITE_DIRECTORY_TITLE' , 'Session Speicherort');
define('SESSION_WRITE_DIRECTORY_DESC' , 'Wenn Sessions als Files gespeichert werden sollen, benutzen Sie folgenden Ordner.');
define('SESSION_FORCE_COOKIE_USE_TITLE' , 'Cookie Benutzung bevorzugen');
define('SESSION_FORCE_COOKIE_USE_DESC' , 'Session starten falls Cookies vom Browser erlaubt werden.');
define('SESSION_CHECK_SSL_SESSION_ID_TITLE' , 'Checken der SSL Session ID');
define('SESSION_CHECK_SSL_SESSION_ID_DESC' , '&Uuml;berpr&uuml;fen der SSL_SESSION_ID bei jedem HTTPS Seitenaufruf.');
define('SESSION_CHECK_USER_AGENT_TITLE' , 'Checken des User Browsers');
define('SESSION_CHECK_USER_AGENT_DESC' , '&Uuml;berpr&uuml;fen des Browsers den der User benutzt, bei jedem Seitenaufruf.');
define('SESSION_CHECK_IP_ADDRESS_TITLE' , 'Checken der IP Adresse');
define('SESSION_CHECK_IP_ADDRESS_DESC' , '&Uuml;berpr&uuml;fen der IP Adresse des Users bei jedem Seitenaufruf.');
define('SESSION_RECREATE_TITLE' , 'Session erneuern');
define('SESSION_RECREATE_DESC' , 'Erneuern der Session und Zuweisung einer neuen Session ID sobald ein User einloggt oder sich registriert (PHP >=4.1 needed).');

define('DISPLAY_CONDITIONS_ON_CHECKOUT_TITLE' , 'Unterzeichnen der AGB');
define('DISPLAY_CONDITIONS_ON_CHECKOUT_DESC' , 'Anzeigen und Unterzeichnen der AGB beim Bestellvorgang');

define('META_MIN_KEYWORD_LENGTH_TITLE' , 'Minimum L&auml;nge Meta-Keywords');
define('META_MIN_KEYWORD_LENGTH_DESC' , 'Minimum L&auml;nge der automatisch erzeugten Meta-Keywords (Artikelbeschreibung)');
define('META_KEYWORDS_NUMBER_TITLE' , 'Anzahl der Meta-Keywords');
define('META_KEYWORDS_NUMBER_DESC' , 'Anzahl der Meta-Keywords');
define('META_AUTHOR_TITLE' , 'author');
define('META_AUTHOR_DESC' , '<meta name="author">');
define('META_PUBLISHER_TITLE' , 'publisher');
define('META_PUBLISHER_DESC' , '<meta name="publisher">');
define('META_COMPANY_TITLE' , 'company');
define('META_COMPANY_DESC' , '<meta name="company">');
define('META_TOPIC_TITLE' , 'page-topic');
define('META_TOPIC_DESC' , '<meta name="page-topic">');
define('META_REPLY_TO_TITLE' , 'reply-to');
define('META_REPLY_TO_DESC' , '<meta name="reply-to">');
define('META_REVISIT_AFTER_TITLE' , 'revisit-after');
define('META_REVISIT_AFTER_DESC' , '<meta name="revisit-after">');
define('META_ROBOTS_TITLE' , 'robots');
define('META_ROBOTS_DESC' , '<meta name="robots">');
define('META_DESCRIPTION_TITLE' , 'Description');
define('META_DESCRIPTION_DESC' , '<meta name="description">');
define('META_KEYWORDS_TITLE' , 'Keywords');
define('META_KEYWORDS_DESC' , '<meta name="keywords">');

define('MODULE_PAYMENT_INSTALLED_TITLE' , 'Installierte Zahlungsmodule');
define('MODULE_PAYMENT_INSTALLED_DESC' , 'Liste der Zahlungsmodul-Dateinamen (getrennt durch einen Strichpunkt (;)). Diese wird automatisch aktualisiert, daher ist es nicht notwendig diese zu editieren. (Beispiel: cc.php;cod.php;paypal.php)');
define('MODULE_ORDER_TOTAL_INSTALLED_TITLE' , 'Installierte Order Total-Module');
define('MODULE_ORDER_TOTAL_INSTALLED_DESC' , 'Liste der Order-Total-Modul-Dateinamen (getrennt durch einen Strichpunkt (;)). Diese wird automatisch aktualisiert, daher ist es nicht notwendig diese zu editieren. (Beispiel: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)');
define('MODULE_SHIPPING_INSTALLED_TITLE' , 'Installierte Versand Module');
define('MODULE_SHIPPING_INSTALLED_DESC' , 'Liste der Versandmodul-Dateinamen (getrennt durch einen Strichpunkt (;)). Diese wird automatisch aktualisiert, daher ist es nicht notwendig diese zu editieren. (Beispiel: ups.php;flat.php;item.php)');

define('CACHE_LIFETIME_TITLE','Cache Lebenszeit');
define('CACHE_LIFETIME_DESC','Zeit in Sekunden, bevor Cache Datein automatisch &uuml;berschrieben werden.');
define('CACHE_CHECK_TITLE','Pr&uuml;fe ob Cache modifiziert');
define('CACHE_CHECK_DESC','Wenn "true", dann werden If-Modified-Since headers bei ge-cache-tem Content ber&uuml;cksichtigt, und passende HTTP headers werden ausgegeben. Somit werden regelm&auml;ssig aufgerufene Seiten nicht jedesmal neu an den Client versandt.');

define('PRODUCT_REVIEWS_VIEW_TITLE','Bewertungen in Artikeldetails');
define('PRODUCT_REVIEWS_VIEW_DESC','Anzahl der angezeigten Bewertungen in der Artikeldetailansicht');

define('DELETE_GUEST_ACCOUNT_TITLE','L&ouml;schen von Gast-Konten');
define('DELETE_GUEST_ACCOUNT_DESC','Sollen Gast-Konten nach erfolgter Bestellung gel&ouml;scht werden ? (Bestelldaten bleiben erhalten)');

define('USE_WYSIWYG_TITLE','WYSIWYG-Editor aktivieren');
define('USE_WYSIWYG_DESC','WYSIWYG-Editor f&uuml;r CMS und Artikel aktivieren ?');

define('PRICE_IS_BRUTTO_TITLE','Brutto Admin');
define('PRICE_IS_BRUTTO_DESC','Erm&ouml;glicht die Eingabe der Bruttopreise im Admin');

define('PRICE_PRECISION_TITLE','Brutto/Netto Dezimalstellen');
define('PRICE_PRECISION_DESC','Umrechnungsgenauigkeit');

define('CHECK_CLIENT_AGENT_TITLE','Spider Sessions vermeiden?');
define('CHECK_CLIENT_AGENT_DESC','Bekannte Suchmaschinen Spider ohne Session auf die Seite lassen.');
define('SHOW_IP_LOG_TITLE','IP-Log im Checkout?');
define('SHOW_IP_LOG_DESC','Text "Ihre IP wird aus Sicherheitsgr&uuml;nden gespeichert", beim Checkout anzeigen?');

define('ACTIVATE_GIFT_SYSTEM_TITLE','Gutscheinsystem aktivieren?');
define('ACTIVATE_GIFT_SYSTEM_DESC','Gutscheinsystem aktivieren?');

define('ACTIVATE_SHIPPING_STATUS_TITLE','Versandstatusanzeige aktivieren?');
define('ACTIVATE_SHIPPING_STATUS_DESC','Versandstatusanzeige aktivieren? (Verschiedene Versandzeiten k&ouml;nnen f&uuml;r einzelne Artikel festgelegt werden. Nach Aktivierung erscheint ein neuer Punkt <b>Lieferstatus</b> bei der Artikeleingabe)');

define('SECURITY_CODE_LENGTH_TITLE','L&auml;nge des Sicherheitscodes');
define('SECURITY_CODE_LENGTH_DESC','L&auml;nge des Sicherheitscodes (Geschenk-Gutschein)');

define('IMAGE_QUALITY_TITLE','Bildqualit&auml;t');
define('IMAGE_QUALITY_DESC','Bildqualit&auml;t (0= h&ouml;chste Kompression, 100=beste Qualit&auml;t)');

define('GROUP_CHECK_TITLE','Kundengruppencheck');
define('GROUP_CHECK_DESC','Nur bestimmten Kundengruppen Zugang zu einzelnen Kategorien,Produkten,Contentelementen erlauben ? (Nach Aktivierung erscheinen Eingabem&ouml;glichkeiten bei Artikeln,Kategorien und im Contentmanager)');

define('ACTIVATE_NAVIGATOR_TITLE','Artikelnavigator aktivieren?');
define('ACTIVATE_NAVIGATOR_DESC','Artikelnavigator in der Artikeldetailansicht aktivieren/deaktivieren (aus performancegr&uuml;nden bei hoher Artikelanzahl)');

define('QUICKLINK_ACTIVATED_TITLE','Multilink/Kopierfunktion aktivieren');
define('QUICKLINK_ACTIVATED_DESC','Die Multilink/Kopierfunktion erleichtert das Kopieren/Verlinken eines Artikels in mehrere Kategorien, durch die M&ouml;glichkeit einzelne Kategorien per Checkbox zu selektieren');

define('ACTIVATE_REVERSE_CROSS_SELLING_TITLE','Reverse Cross-Marketing');
define('ACTIVATE_REVERSE_CROSS_SELLING_DESC','Reverse Cross-Marketing Funktion aktivieren?');

define('DOWNLOAD_UNALLOWED_PAYMENT_TITLE', 'Download Zahlungsmodule');
define('DOWNLOAD_UNALLOWED_PAYMENT_DESC', 'Nicht Erlaubte Zahlungsweisen f&uuml;r Downloadprodukte durch Komma getrennt. Z.B. {banktransfer,cod,invoice,moneyorder}');
define('DOWNLOAD_MIN_ORDERS_STATUS_TITLE', 'Min. Bestellstatus');
define('DOWNLOAD_MIN_ORDERS_STATUS_DESC', 'Min. Bestellstatus, ab dem bestellte Downloads freigegeben sind.');

// Vat ID
define('STORE_OWNER_VAT_ID_TITLE' , 'UST ID des Shopbetreibers');
define('STORE_OWNER_VAT_ID_DESC' , 'Die UST ID des Shopbetreibers');
define('STORE_OWNER_VAT_ID_TITLE' , 'Umsatzsteuer ID');
define('STORE_OWNER_VAT_ID_DESC' , 'Die Umsatzsteuer ihres Unternehmens');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_TITLE' , 'Kundenstatus f&uuml;r UST ID gepr&uuml;fte Kunden (Ausland)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_DESC' , 'W&auml;hlen Sie den Kundenstatus(Gruppe) f&uuml;r UST ID gepr&uuml;fte Kunden aus!');
define('ACCOUNT_COMPANY_VAT_CHECK_TITLE' , 'Umsatzsteuer ID &Uuml;berpr&uuml;fen');
define('ACCOUNT_COMPANY_VAT_CHECK_DESC' , 'Die Umsatzsteuer ID auf Plausibilit&auml;t &Uuml;berpr&uuml;fen');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_TITLE' , 'Umsatzsteuer ID Live &Uuml;berpr&uuml;fen');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_DESC' , 'Die Umsatzsteuer ID auf Live Plausibilit&ouml;t &Uuml;berpr&uuml;fen falls keine Berechnungsgrundlage vorhanden? (Gateway des Bundesamt f�r Finanzen)');
define('ACCOUNT_COMPANY_VAT_GROUP_TITLE' , 'Kundengruppe nach UST ID Check anpassen?');
define('ACCOUNT_COMPANY_VAT_GROUP_DESC' , 'Durch einschalten dieser Option wird die Kundengruppe nach einen postiven UST ID Check ge&auml;ndert');
define('ACCOUNT_VAT_BLOCK_ERROR_TITLE' , 'Eintragung falscher oder ungepr&uuml;fter UstID Nummern sperren?');
define('ACCOUNT_VAT_BLOCK_ERROR_DESC' , 'Durch einschalten dieser Option werden nur gepr&uuml;fte und richtige UstIDs eingetragen');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_TITLE','Kundenstatus f&uuml;r UST ID Gepr�&uuml;fte Kunden (Innland)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_DESC','W&auml;hlen Sie den Kundenstatus(Gruppe) f&uuml;r UST ID gepr&uuml;fte Kunden aus!');
// Google Conversion
define('GOOGLE_CONVERSION_TITLE','Google Conversion-Tracking');
define('GOOGLE_CONVERSION_DESC','Die Aufzeichnung von Conversions-Keywords bei Bestellungen');
define('GOOGLE_CONVERSION_ID_TITLE','Conversion ID');
define('GOOGLE_CONVERSION_ID_DESC','Ihre Google Conversion ID');
define('GOOGLE_LANG_TITLE','Google Sprache');
define('GOOGLE_LANG_DESC','ISO Code der verwendeten Sprache');
// Afterbuy
define('AFTERBUY_ACTIVATED_TITLE','Aktiv');
define('AFTERBUY_ACTIVATED_DESC','Afterbuyschnittstelle aktivieren');
define('AFTERBUY_PARTNERID_TITLE','Partner ID');
define('AFTERBUY_PARTNERID_DESC','Ihre Afterbuy Partner ID');
define('AFTERBUY_PARTNERPASS_TITLE','Partner Passwort');
define('AFTERBUY_PARTNERPASS_DESC','Ihr Partner Passwort f&uuml;r die Afterbuy XML Schnittstelle');
define('AFTERBUY_USERID_TITLE','User ID');
define('AFTERBUY_USERID_DESC','Ihre Afterbuy User ID');
define('AFTERBUY_ORDERSTATUS_TITLE','Bestellstatus');
define('AFTERBUY_ORDERSTATUS_DESC','Bestellstatus nach erfolgreicher &Uuml;betragung der Bestelldaten');
define('AFTERBUY_URL','Eine Beschreibung von Afterbuy finden Sie hier: <a href="http://www.xt-commerce.com/modules/wfsection/dossier-65.html" target="new">http://www.xt-commerce.com/modules/wfsection/dossier-65.html</a>');

// Search-Options
define('SEARCH_IN_DESC_TITLE','Suche in Produktbeschreibungen');
define('SEARCH_IN_DESC_DESC','Aktivieren um die Suche in den Produktbeschreibungen (Kurz + Lang) zu erm&ouml;glichen');
define('SEARCH_IN_ATTR_TITLE','Suche in Produkt- Attributen');
define('SEARCH_IN_ATTR_DESC','Aktivieren um die Suche in den Produktattributen (z.B. Farbe, L&auml;nge) zu erm&ouml;glichen');

?>