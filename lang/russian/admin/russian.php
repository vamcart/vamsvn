<?php
/* --------------------------------------------------------------
   $Id: russian.php 1231 2006-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(german.php,v 1.99 2003/05/28); www.oscommerce.com 
   (c) 2003	 nextcommerce (german.php,v 1.24 2003/08/24); www.nextcommerce.org

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contributions:
   Customers Status v3.x (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

// look in your $PATH_LOCALE/locale directory for available locales..
// on RedHat6.0 I used 'en_US'
// on FreeBSD 4.0 I use 'en_US.ISO_8859-1'
// this may not work under win32 environments..

setlocale(LC_TIME, 'ru_RU.CP1251', 'Russian');
define('DATE_FORMAT_SHORT', '%d/%m/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd/m/Y'); // this is used for date()
define('PHP_DATE_TIME_FORMAT', 'd/m/Y H:i:s'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

////
// Return date in raw format
// $date should be in format mm/dd/yyyy
// raw date is in format YYYYMMDD, or DDMMYYYY
function xtc_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2); 
  }
}

// Global entries for the <html> tag
define('HTML_PARAMS','dir="ltr" lang="ru"');


// page title
define('TITLE', 'VaM Shop');

// header text in includes/header.php
define('HEADER_TITLE_TOP', '�����������������');
define('HEADER_TITLE_SUPPORT_SITE', '���� ���������');
define('HEADER_TITLE_ONLINE_CATALOG', '�������');
define('HEADER_TITLE_ADMINISTRATION', '�������������');

// text for gender
define('MALE', '�������');
define('FEMALE', '�������');

// text for date of birth example
define('DOB_FORMAT_STRING', 'dd/mm/yyyy');

// configuration box text in includes/boxes/configuration.php

define('BOX_HEADING_CONFIGURATION','���������');
define('BOX_HEADING_MODULES','������');
define('BOX_HEADING_ZONE','�������/������');
define('BOX_HEADING_CUSTOMERS','����������');
define('BOX_HEADING_PRODUCTS','�������');
define('BOX_HEADING_STATISTICS','����������');
define('BOX_HEADING_TOOLS','�����������');
define('BOX_HEADING_LOGOFF','�����');
define('BOX_HEADING_HELP','������');

define('BOX_CONTENT','�������������� ��������');
define('TEXT_ALLOWED', '���������');
define('TEXT_ACCESS', '������');
define('BOX_CONFIGURATION', '���������');
define('BOX_CONFIGURATION_1', '��� �������');
define('BOX_CONFIGURATION_2', '����������� ��������');
define('BOX_CONFIGURATION_3', '������������ ��������');
define('BOX_CONFIGURATION_4', '��������');
define('BOX_CONFIGURATION_5', '������ ����������');
define('BOX_CONFIGURATION_6', '������');
define('BOX_CONFIGURATION_7', '��������/��������');
define('BOX_CONFIGURATION_8', '����� ������');
define('BOX_CONFIGURATION_9', '�����');
define('BOX_CONFIGURATION_10', '����');
define('BOX_CONFIGURATION_11', '���');
define('BOX_CONFIGURATION_12', '��������� Email');
define('BOX_CONFIGURATION_13', '����������');
define('BOX_CONFIGURATION_14', 'GZip ����������');
define('BOX_CONFIGURATION_15', '������');
define('BOX_CONFIGURATION_16', '���� ���� / ����������');
define('BOX_CONFIGURATION_17', '��������� ������ �������');
define('BOX_CONFIGURATION_19', 'xt:C �������');
define('BOX_CONFIGURATION_22', '��������� ������');
define('BOX_CONFIGURATION_23', '������-������');
define('BOX_CONFIGURATION_24', '��������� ���');

define('BOX_MODULES', '������/��������/�����');
define('BOX_PAYMENT', '������ ������');
define('BOX_SHIPPING', '������ ��������');
define('BOX_ORDER_TOTAL', '������ �����');
define('BOX_CATEGORIES', '��������� / ������');
define('BOX_PRODUCTS_ATTRIBUTES', '�������� - ���������');
define('BOX_MANUFACTURERS', '�������������');
define('BOX_REVIEWS', '������ � �������');
define('BOX_CAMPAIGNS', '��������');
define('BOX_XSELL_PRODUCTS', '������������� ������');
define('BOX_SPECIALS', '������');
define('BOX_PRODUCTS_EXPECTED', '��������� ������');
define('BOX_CUSTOMERS', '�������');
define('BOX_ACCOUNTING', '������ ������');
define('BOX_CUSTOMERS_STATUS','������ ��������');
define('BOX_ORDERS', '������');
define('BOX_COUNTRIES', '������');
define('BOX_ZONES', '�������');
define('BOX_GEO_ZONES', '�������������� ����');
define('BOX_TAX_CLASSES', '���� �������');
define('BOX_TAX_RATES', '������ �������');
define('BOX_HEADING_REPORTS', '������');
define('BOX_PRODUCTS_VIEWED', '������������� ������');
define('BOX_STOCK_WARNING','���������� � ������');
define('BOX_PRODUCTS_PURCHASED', '���������� ������');
define('BOX_STATS_CUSTOMERS', '������ �������');
define('BOX_BACKUP', '��������� �����������');
define('BOX_BANNER_MANAGER', '���������� ��������');
define('BOX_CACHE', '���');
define('BOX_DEFINE_LANGUAGE', '�������� ���������');
define('BOX_FILE_MANAGER', '���� ��������');
define('BOX_MAIL', 'E-Mail �����');
define('BOX_NEWSLETTERS', '�������� �����������');
define('BOX_SERVER_INFO', '������ ����');
define('BOX_WHOS_ONLINE', '��� � �n-line?');
define('BOX_TPL_BOXES','������� ���������� ������');
define('BOX_CURRENCIES', '������');
define('BOX_LANGUAGES', '�����');
define('BOX_ORDERS_STATUS', '������� ������');
define('BOX_ATTRIBUTES_MANAGER','�������� - ���������');
define('BOX_PRODUCTS_ATTRIBUTES','������-�����');
define('BOX_MODULE_NEWSLETTER','������ � ���������');
define('BOX_ORDERS_STATUS','������ ������');
define('BOX_SHIPPING_STATUS','����� ��������');
define('BOX_SALES_REPORT','���������� ������');
define('BOX_MODULE_EXPORT','XT-������');
define('BOX_HEADING_GV_ADMIN', '�����������/������');
define('BOX_GV_ADMIN_QUEUE', '��������� ������������');
define('BOX_GV_ADMIN_MAIL', '��������� ����������');
define('BOX_GV_ADMIN_SENT', '������������ �����������');
define('BOX_COUPON_ADMIN','���������� ��������');
define('BOX_TOOLS_BLACKLIST','��������� ����� (CC) ������ ������');
define('BOX_IMPORT','������/�������');
define('BOX_PRODUCTS_VPE','������� ��������');
define('BOX_CAMPAIGNS_REPORT','����� �� ���������');
define('BOX_ORDERS_XSELL_GROUP','������ ������������� �������');
define('BOX_SUPPORT_SITE','���� ���������');

define('TXT_GROUPS','<b>������</b>:');
define('TXT_SYSTEM','�������');
define('TXT_CUSTOMERS','�������/������');
define('TXT_PRODUCTS','������/���������');
define('TXT_STATISTICS','����������');
define('TXT_TOOLS','�����������');
define('TEXT_ACCOUNTING','������ ������:');

//Dividers text for menu

define('BOX_HEADING_MODULES', '������');
define('BOX_HEADING_LOCALIZATION', '�����/������');
define('BOX_HEADING_TEMPLATES','�������');
define('BOX_HEADING_TOOLS', '�����������');
define('BOX_HEADING_LOCATION_AND_TAXES', '����� / ������');
define('BOX_HEADING_CUSTOMERS', '�������');
define('BOX_HEADING_CATALOG', '�������');
define('BOX_MODULE_NEWSLETTER','��������');

// javascript messages
define('JS_ERROR', '��� ���������� ����� �� ��������� ������!\n��������, ����������, ��������� �����������:\n\n');

define('JS_OPTIONS_VALUE_PRICE', '* ����� ������� ������ ����� ����� ����\n');
define('JS_OPTIONS_VALUE_PRICE_PREFIX', '* ����� ������� ������ ����� ����� ������� �������\n');

define('JS_PRODUCTS_NAME', '* ��� ������ ������ ������ ���� ������� ������������\n');
define('JS_PRODUCTS_DESCRIPTION', '* ��� ������ ������ ������ ���� ������� ��������\n');
define('JS_PRODUCTS_PRICE', '* ��� ������ ������ ������ ���� ������� ����\n');
define('JS_PRODUCTS_WEIGHT', '* ��� ������ ������ ������ ���� ������ ���\n');
define('JS_PRODUCTS_QUANTITY', '* ��� ������ ������ ������ ���� ������� ����������\n');
define('JS_PRODUCTS_MODEL', '* ��� ������ ������ ������ ���� ������ ��� ������\n');
define('JS_PRODUCTS_IMAGE', '* ��� ������ ������ ������ ���� ��������\n');

define('JS_SPECIALS_PRODUCTS_PRICE', '* ��� ����� ������ ������ ���� ����������� ����� ����\n');

define('JS_GENDER', '* ���� \'���\' ������ ���� �������.\n');
define('JS_FIRST_NAME', '* ���� \'���\' ������ ��������� �� ����� ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' ��������.\n');
define('JS_LAST_NAME', '* ���� \'�������\' ������ ��������� �� ����� ' . ENTRY_LAST_NAME_MIN_LENGTH . ' ��������.\n');
define('JS_DOB', '* ���� \'���� ��������\' ������ ����� ������: xx/xx/xxxx (����/�����/���).\n');
define('JS_EMAIL_ADDRESS', '* ���� \'E-Mail �����\' ������ ��������� �� ����� ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' ��������.\n');
define('JS_ADDRESS', '* ���� \'�����\' ������ ��������� �� ����� ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' ��������.\n');
define('JS_POST_CODE', '* ���� \'������\' ������ ��������� �� ����� ' . ENTRY_POSTCODE_MIN_LENGTH . ' ��������.\n');
define('JS_CITY', '* ���� \'�����\' ������ ��������� �� ����� ' . ENTRY_CITY_MIN_LENGTH . ' ��������.\n');
define('JS_STATE', '* ���� \'������\' ������ ���� �������.\n');
define('JS_STATE_SELECT', '-- �������� ���� --');
define('JS_ZONE', '* ���� \'������\' ������ ��������������� �������� ������.');
define('JS_COUNTRY', '* ���� \'������\' ����� ���� ���������.\n');
define('JS_TELEPHONE', '* ���� \'�������\' ������ ��������� �� ����� ' . ENTRY_TELEPHONE_MIN_LENGTH . ' ��������.\n');
define('JS_PASSWORD', '* ���� \'������\' � \'�������������\' ������ ��������� � ��������� �� ����� ' . ENTRY_PASSWORD_MIN_LENGTH . ' ��������.\n');

define('JS_ORDER_DOES_NOT_EXIST', '����� ����� %s �� ������!');

define('CATEGORY_PERSONAL', '������������ ������');
define('CATEGORY_ADDRESS', '�����');
define('CATEGORY_CONTACT', '��� ��������');
define('CATEGORY_COMPANY', '��������');
define('CATEGORY_OPTIONS', '���������');

define('ENTRY_GENDER', '���:');
define('ENTRY_GENDER_ERROR', '&nbsp;<span class="errorText">�����������</span>');
define('ENTRY_FIRST_NAME', '���:');
define('ENTRY_FIRST_NAME_ERROR', '&nbsp;<span class="errorText">������� ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' ��������</span>');
define('ENTRY_LAST_NAME', '�������:');
define('ENTRY_LAST_NAME_ERROR', '&nbsp;<span class="errorText">������� ' . ENTRY_LAST_NAME_MIN_LENGTH . ' ��������</span>');
define('ENTRY_DATE_OF_BIRTH', '���� ��������:');
define('ENTRY_DATE_OF_BIRTH_ERROR', '&nbsp;<span class="errorText">(������ 21/05/1970)</span>');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail �����:');
define('ENTRY_EMAIL_ADDRESS_ERROR', '&nbsp;<span class="errorText">������� ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' ��������</span>');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', '&nbsp;<span class="errorText">�� ����� �������� email �����!</span>');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', '&nbsp;<span class="errorText">������ email ����� ��� ���������������!</span>');
define('ENTRY_COMPANY', '��������:');
define('ENTRY_STREET_ADDRESS', '�����:');
define('ENTRY_STREET_ADDRESS_ERROR', '&nbsp;<span class="errorText">������� ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' ��������</span>');
define('ENTRY_SUBURB', '�����:');
define('ENTRY_POST_CODE', '������:');
define('ENTRY_POST_CODE_ERROR', '&nbsp;<span class="errorText">������� ' . ENTRY_POSTCODE_MIN_LENGTH . ' ��������</span>');
define('ENTRY_CITY', '�����:');
define('ENTRY_CITY_ERROR', '&nbsp;<span class="errorText">������� ' . ENTRY_CITY_MIN_LENGTH . ' ��������</span>');
define('ENTRY_STATE', '������:');
define('ENTRY_STATE_ERROR', '&nbsp;<span class="errorText">�����������</span>');
define('ENTRY_COUNTRY', '������:');
define('ENTRY_TELEPHONE_NUMBER', '�������:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', '&nbsp;<span class="errorText">������� ' . ENTRY_TELEPHONE_MIN_LENGTH . ' ��������</span>');
define('ENTRY_FAX_NUMBER', '����:');
define('ENTRY_NEWSLETTER', '��������:');
define('ENTRY_CUSTOMERS_STATUS', '������ �������:');
define('ENTRY_NEWSLETTER_YES', '��������');
define('ENTRY_NEWSLETTER_NO', '�� ��������');
define('ENTRY_MAIL_ERROR','&nbsp;<span class="errorText">�������� �����</span>');
define('ENTRY_PASSWORD','������ (������������)');
define('ENTRY_PASSWORD_ERROR','&nbsp;<span class="errorText">������� ' . ENTRY_PASSWORD_MIN_LENGTH . ' ��������</span>');
define('ENTRY_MAIL_COMMENTS','�������������� ����� � Email:');

define('ENTRY_MAIL','��������� ������ � ������� �������?');
define('YES','��');
define('NO','���');
define('SAVE_ENTRY','��������� ���������?');
define('TEXT_CHOOSE_INFO_TEMPLATE','������ ��� �������� ������');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE','������ ��� ��������� ������');
define('TEXT_SELECT','-- �������� --');

// Icons
define('ICON_CROSS', '���������������');
define('ICON_CURRENT_FOLDER', '������� ����������');
define('ICON_DELETE', '�������');
define('ICON_ERROR', '������:');
define('ICON_FILE', '����');
define('ICON_FILE_DOWNLOAD', '��������');
define('ICON_FOLDER', '�����');
define('ICON_LOCKED', '�������������');
define('ICON_PREVIOUS_LEVEL', '���������� �������');
define('ICON_PREVIEW', '�������������');
define('ICON_STATISTICS', '����������');
define('ICON_SUCCESS', '���������');
define('ICON_TICK', '������');
define('ICON_UNLOCKED', '��������������');
define('ICON_WARNING', '��������');

// constants for use in tep_prev_next_display function
define('TEXT_RESULT_PAGE', '�������� %s �� %d');
define('TEXT_DISPLAY_NUMBER_OF_BANNERS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ��������)');
define('TEXT_DISPLAY_NUMBER_OF_COUNTRIES', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> �����)');
define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ��������)');
define('TEXT_DISPLAY_NUMBER_OF_CURRENCIES', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> �����)');
define('TEXT_DISPLAY_NUMBER_OF_LANGUAGES', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ������)');
define('TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ��������������)');
define('TEXT_DISPLAY_NUMBER_OF_NEWSLETTERS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> �����)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> �������)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS_STATUS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> �������� �������)');
define('TEXT_DISPLAY_NUMBER_OF_XSELL_GROUP', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ����� ������������� �������)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_VPE', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ����������� ������)');
define('TEXT_DISPLAY_NUMBER_OF_SHIPPING_STATUS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> �������� ��������)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> �������)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_EXPECTED', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ��������� �������)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> �������)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ������)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_CLASSES', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ��������� �������)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_ZONES', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ��������� ���)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_RATES', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ��������� ������)');
define('TEXT_DISPLAY_NUMBER_OF_ZONES', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ��������)');
define('TEXT_DISPLAY_NUMBER_OF_FEATURED', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ������������� �������)');

define('PREVNEXT_BUTTON_PREV', '����������');
define('PREVNEXT_BUTTON_NEXT', '���������');

define('TEXT_DEFAULT', '�� ���������');
define('TEXT_SET_DEFAULT', '���������� �� ���������');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">* �����������</span>');

define('ERROR_NO_DEFAULT_CURRENCY_DEFINED', '������: � ���������� ������� �� ���� ������ �� ���� ����������� �� ���������. ����������, ���������� ���� �� ��� �: ����������� -> ������');

define('TEXT_CACHE_CATEGORIES', '���� ���������');
define('TEXT_CACHE_MANUFACTURERS', '���� ��������������');
define('TEXT_CACHE_ALSO_PURCHASED', '���� ����� ����������'); 

define('TEXT_NONE', '--���--');
define('TEXT_TOP', '������');

define('ERROR_DESTINATION_DOES_NOT_EXIST', '������: ������� �� ����������.');
define('ERROR_DESTINATION_NOT_WRITEABLE', '������: ������� ������� �� ������, ���������� ����������� ����� �������.');
define('ERROR_FILE_NOT_SAVED', '������: ���� �� ��� ��������.');
define('ERROR_FILETYPE_NOT_ALLOWED', '������: ������ ���������� ����� ������� ����.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', '���������: ���� ������� ��������.');
define('WARNING_NO_FILE_UPLOADED', '��������������: �� ������ ����� �� ���������.');

define('DELETE_ENTRY','������� ������?');
define('TEXT_PAYMENT_ERROR','<b>��������������:</b><br />����������� ������ ������!');
define('TEXT_SHIPPING_ERROR','<b>��������������:</b><br />����������� ������ ��������!');

define('TEXT_NETTO','��� �������.');

define('ENTRY_CID','ID �������:');
define('IP','IP ������:');
define('CUSTOMERS_MEMO','�������:');
define('DISPLAY_MEMOS','��������/��������');
define('TITLE_MEMO','�������');
define('ENTRY_LANGUAGE','����:');
define('CATEGORIE_NOT_FOUND','��������� �� �������!');

define('IMAGE_RELEASE', '������������ ����������');

define('_JANUARY', '������');
define('_FEBRUARY', '�������');
define('_MARCH', '����');
define('_APRIL', '������');
define('_MAY', '���');
define('_JUNE', '����');
define('_JULY', '����');
define('_AUGUST', '������');
define('_SEPTEMBER', '��������');
define('_OCTOBER', '�������');
define('_NOVEMBER', '������');
define('_DECEMBER', '�������');

define('TEXT_DISPLAY_NUMBER_OF_GIFT_VOUCHERS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ���������� ������������)');
define('TEXT_DISPLAY_NUMBER_OF_COUPONS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> �������)');

define('TEXT_VALID_PRODUCTS_LIST', '������ �������');
define('TEXT_VALID_PRODUCTS_ID', 'ID ������');
define('TEXT_VALID_PRODUCTS_NAME', '��������  ������');
define('TEXT_VALID_PRODUCTS_MODEL', '������ ������');

define('TEXT_VALID_CATEGORIES_LIST', '������ ���������');
define('TEXT_VALID_CATEGORIES_ID', 'ID ���������');
define('TEXT_VALID_CATEGORIES_NAME', '�������� ���������');

define('SECURITY_CODE_LENGTH_TITLE', '����� ���� ����������� �����������');
define('SECURITY_CODE_LENGTH_DESC', '������� ����� ���� ����������� ������');

define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_TITLE', '���������� ����������');
define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_DESC', '���� �� �� ����������� ���������� ����������� ����� ����������� � �������� ���������� ����������, ������� 0, ���� ������� ������� ����������� �����������, ������� ����� �������� ���������� ����� ����������� � ��������-��������, �������� 10.00 ��� 50.00.');
define('NEW_SIGNUP_DISCOUNT_COUPON_TITLE', '��� ������');
define('NEW_SIGNUP_DISCOUNT_COUPON_DESC', '���� �� �� ������ ���������� ����������� ����� ����������� � �������� �����, �� ���������� ������ ����. ���� �� ������, ��� � ���������� ����� ����������� ������� �����, ������� ��� ������������� ������, ������� ������� ������ ������������������ � ��������-�������� ����������.');

define('TXT_ALL','���');

// UST ID
define('BOX_CONFIGURATION_18', 'Vat ���');
define('HEADING_TITLE_VAT','Vat ���');
define('HEADING_TITLE_VAT','Vat ���');
define('ENTRY_VAT_ID','Vat ���');
define('TEXT_VAT_FALSE','<font color="FF0000">��������/������!</font>');
define('TEXT_VAT_TRUE','<font color="FF0000">��������/�� ���������!</font>');
define('TEXT_VAT_UNKNOWN_COUNTRY','<font color="FF0000">�� ��������/����������� ������!</font>');
define('TEXT_VAT_UNKNOWN_ALGORITHM','<font color="FF0000">�� ��������/�������� ����������!</font>');
define('ENTRY_VAT_ID_ERROR', '<font color="FF0000">* ��� Vat ��� ������������!</font>');

define('ERROR_GIF_MERGE','����������� GDlib GIF-���������, ��������� �������� ���������');
define('ERROR_GIF_UPLOAD','����������� GDlib Gif-���������, ��������� �������� GIF ���������');

define('TEXT_REFERER','�������: ');

define('IMAGE_ICON_INFO','');
define('ERROR_IMAGE_DIRECTORY_CREATE', '������: ������ ��� �������� ���������� ');
define('TEXT_IMAGE_DIRECTORY_CREATE', '����������: ������� ���������� ');

//������ VaM

define('BOX_EASY_POPULATE','Excel ������/�������');
define('BOX_CATALOG_QUICK_UPDATES', '��������� ���');

define('BOX_CATALOG_LATEST_NEWS', '�������');
define('IMAGE_NEW_NEWS_ITEM', '�������� �������');

define('TABLE_HEADING_CUSTOMERS', '��������� ����������');
define('TABLE_HEADING_LASTNAME', '�������');
define('TABLE_HEADING_FIRSTNAME', '���');
define('TABLE_HEADING_DATE', '����');

define('TABLE_HEADING_ORDERS', '��������� ������');
define('TABLE_HEADING_CUSTOMER', '����������');
define('TABLE_HEADING_NUMBER', '����� ������');
define('TABLE_HEADING_ORDER_TOTAL', '�����');
define('TABLE_HEADING_STATUS', '������');

define('TABLE_HEADING_PRODUCTS', '��������� ������');
define('TABLE_HEADING_PRODUCT_NAME', '������');
define('TABLE_HEADING_PRODUCT_PRICE', '���������');

define('TABLE_HEADING_NEWS', '��������� �������');

define('BOX_TOOLS_RECOVER_CART', '������������� ������');

define('BOX_FEATURED', '������������� ������');

define('TEXT_HEADER_DEFAULT','�������');
define('TEXT_HEADER_SUPPORT','���������');
define('TEXT_HEADER_SHOP','�������');
define('TEXT_HEADER_LOGOFF','�����');

?>