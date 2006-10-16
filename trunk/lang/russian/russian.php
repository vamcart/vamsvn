<?php
/* -----------------------------------------------------------------------------------------
   $Id: russian.php 1260 2005-09-29 17:48:04Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(german.php,v 1.119 2003/05/19); www.oscommerce.com
   (c) 2003  nextcommerce (german.php,v 1.25 2003/08/25); www.nextcommerce.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

/*
 *
 *  DATE / TIME
 *
 */

define('TITLE', STORE_NAME);
define('HEADER_TITLE_TOP', '������');     
define('HEADER_TITLE_CATALOG', '�������');

define('HTML_PARAMS','dir="ltr" lang="ru"');

@setlocale(LC_TIME, 'ru_RU.CP1251', 'Russian');

define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('DOB_FORMAT_STRING', 'dd.mm.jjjj');

function xtc_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2); 
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'USD');

define('MALE', '���������');
define('FEMALE', '���������');

/*
 *
 *  BOXES
 *
 */

// text for gift voucher redeeming
define('IMAGE_REDEEM_GIFT','������������ ����������!');

define('BOX_TITLE_STATISTICS','����������:');
define('BOX_ENTRY_CUSTOMERS','�������');
define('BOX_ENTRY_PRODUCTS','������');
define('BOX_ENTRY_REVIEWS','������');
define('TEXT_VALIDATING','�� ���������');

// manufacturer box text
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '����������� ���� %s');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', '������ ������ ������� �������������');

define('BOX_HEADING_ADD_PRODUCT_ID','�������� � �������');
  
define('BOX_LOGINBOX_STATUS','������:');     
define('BOX_LOGINBOX_DISCOUNT','������');
define('BOX_LOGINBOX_DISCOUNT_TEXT','������');
define('BOX_LOGINBOX_DISCOUNT_OT','');

// reviews box text in includes/boxes/reviews.php
define('BOX_REVIEWS_WRITE_REVIEW', '�������� �����!');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s �� 5 ����!');

// pull down default text
define('PULL_DOWN_DEFAULT', '��������');

// javascript messages
define('JS_ERROR', '�� ������� ����������� ����������!\n����������, ��������� ���������� ������.\n\n');

define('JS_REVIEW_TEXT', '* ���� ����� ������ ������ ��������� �� ����� ' . REVIEW_TEXT_MIN_LENGTH . ' ��������.\n');
define('JS_REVIEW_RATING', '* �� �� ������� �������.\n');
define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* �������� ������ ������ ��� ������ ������.\n');
define('JS_ERROR_SUBMITTED', '��� ����� ��� ���������. ��������� Ok.');
define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* �������� ������ ������ ��� ������ ������.\n');

/*
 *
 * ACCOUNT FORMS
 *
 */

define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER_ERROR', '�� ������ ������� ���� ���.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME_ERROR', '���� ��� ������ ��������� ��� ������� ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' �������.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME_ERROR', '���� ������� ������ ��������� ��� ������� ' . ENTRY_LAST_NAME_MIN_LENGTH . ' �������.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH_ERROR', '���� �������� ���������� ������� � ��������� �������: DD/MM/YYYY (������ 21/05/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (������ 21/05/1970)');
define('ENTRY_EMAIL_ADDRESS_ERROR', '���� E-Mail ������ ��������� ��������� � ��������� ��� ������� ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' ��������.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', '��� E-Mail ����� ������ �����������, ���������� ��� ���.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', '�������� ���� E-Mail ��� ��������������� � ����� ��������, ���������� ������� ������ E-Mail �����.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS_ERROR', '���� ����� � ����� ���� ������ ��������� ��� ������� ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' ��������.');
define('ENTRY_STREET_ADDRESS_TEXT', '* ������: ��. ���� 346, ��. 78');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE_ERROR', '���� �������� ������ ������ ��������� ��� ������� ' . ENTRY_POSTCODE_MIN_LENGTH . ' �������.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY_ERROR', '���� ����� ������ ��������� ��� ������� ' . ENTRY_CITY_MIN_LENGTH . ' �������.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE_ERROR', '���� ������ ������ ��������� ��� ������� ' . ENTRY_STATE_MIN_LENGTH . ' �������.');
define('ENTRY_STATE_ERROR_SELECT', '������� ������.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY_ERROR', '������� ������.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER_ERROR', '���� ������� ������ ��������� ��� ������� ' . ENTRY_TELEPHONE_MIN_LENGTH . ' �������.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_PASSWORD_ERROR', '��� ������ ������ ��������� ��� ������� ' . ENTRY_PASSWORD_MIN_LENGTH . ' ��������.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', '���� ����������� ������ ������ ��������� � ����� ������.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', '���� ������ ������ ��������� ��� ������� ' . ENTRY_PASSWORD_MIN_LENGTH . ' ��������.');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', '��� ����� ������ ������ ��������� ��� ������� ' . ENTRY_PASSWORD_MIN_LENGTH . ' ��������.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', '���� ����������� ������ � ����� ������ ������ ���������.');

/*
 *
 *  RESTULTPAGES
 *
 */

define('TEXT_RESULT_PAGE', '��������:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> �������)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> �������)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> �������)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> �������)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ����������� �����������)');
define('TEXT_DISPLAY_NUMBER_OF_FEATURED', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ������������� �������)');

/*
 *
 * SITE NAVIGATION
 *
 */

define('PREVNEXT_TITLE_PREVIOUS_PAGE', '���������� ��������');
define('PREVNEXT_TITLE_NEXT_PAGE', '��������� ��������');
define('PREVNEXT_TITLE_PAGE_NO', '�������� %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', '���������� %d �������');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', '��������� %d �������');

/*
 *
 * PRODUCT NAVIGATION
 *
 */

define('PREVNEXT_BUTTON_PREV', '����������');
define('PREVNEXT_BUTTON_NEXT', '���������');

/*
 *
 * IMAGE BUTTONS
 *
 */

define('IMAGE_BUTTON_ADD_ADDRESS', '�������� �����');
define('IMAGE_BUTTON_BACK', '�����');
define('IMAGE_BUTTON_CHANGE_ADDRESS', '�������� �����');
define('IMAGE_BUTTON_CHECKOUT', '�������� �����');
define('IMAGE_BUTTON_CONFIRM_ORDER', '����������� �����');
define('IMAGE_BUTTON_CONTINUE', '����������');
define('IMAGE_BUTTON_DELETE', '�������');
define('IMAGE_BUTTON_LOGIN', '����������');
define('IMAGE_BUTTON_IN_CART', '�������� � �������');
define('IMAGE_BUTTON_SEARCH', '������');
define('IMAGE_BUTTON_UPDATE', '��������');
define('IMAGE_BUTTON_UPDATE_CART', '�����������');
define('IMAGE_BUTTON_WRITE_REVIEW', '�������� �����');
define('IMAGE_BUTTON_ADMIN', '�������');
define('IMAGE_BUTTON_PRODUCT_EDIT', '������������� �����');

define('SMALL_IMAGE_BUTTON_DELETE', '�������');
define('SMALL_IMAGE_BUTTON_EDIT', '��������');
define('SMALL_IMAGE_BUTTON_VIEW', '��������');

define('ICON_ARROW_RIGHT', '�������');
define('ICON_CART', '� �������');
define('ICON_SUCCESS', '���������');
define('ICON_WARNING', '��������');

/*
 *
 *  GREETINGS
 *
 */

define('TEXT_GREETING_PERSONAL', '����� ����������, <span class="greetUser">%s!</span> �� ������ ���������� ����� <a style="text-decoration:underline;" href="%s">����� ������</a> ��������� � ��� �������?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>���� �� �� %s, ����������, <a style="text-decoration:underline;" href="%s">�������</a> ���� ������ ��� �����.</small>');
define('TEXT_GREETING_GUEST', '����� ����������, <span class="greetUser">��������� �����!</span><br /> ���� �� ��� ���������� ������, <a style="text-decoration:underline;" href="%s">������� ���� ������������ ������</a> ��� �����. ���� �� � ��� ������� � ������ ������� �������, ��� ���������� <a style="text-decoration:underline;" href="%s">������������������</a>.');

define('TEXT_SORT_PRODUCTS', '����������� ����� �� ');
define('TEXT_DESCENDINGLY', '��������');
define('TEXT_ASCENDINGLY', '�����������');
define('TEXT_BY', ' �� ');

define('TEXT_REVIEW_BY', '- %s');
define('TEXT_REVIEW_WORD_COUNT', '%s ����');
define('TEXT_REVIEW_RATING', '�������: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', '����� ��������: %s');
define('TEXT_NO_REVIEWS', '� ���������� ������� ��� �������.');
define('TEXT_NO_NEW_PRODUCTS', '�� ������ ������ ��� ����� �������.');
define('TEXT_UNKNOWN_TAX_RATE', '����������� ��������� ������');

/*
 *
 * WARNINGS
 *
 */

define('WARNING_INSTALL_DIRECTORY_EXISTS', '��������������: �� ������� ���������� ��������� ��������: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/install. ����������, ������� ��� ���������� � ����� ������������.');
define('WARNING_CONFIG_FILE_WRITEABLE', '��������������: ���� ������������ �������� ��� ������: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. ��� - ������������� ���� ������������ - ����������, ���������� ����������� ����� ������� � ����� �����.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', '��������������: ���������� ������ �� ����������: ' . xtc_session_save_path() . '. ������ �� ����� �������� ���� ��� ���������� �� ����� �������.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', '��������������: ��� ������� � ���������� ������: ' . xtc_session_save_path() . '. ������ �� ����� �������� ���� �� ����������� ����������� ����� �������.');
define('WARNING_SESSION_AUTO_START', '��������������: ����� session.auto_start �������� - ����������, ��������� ������ ����� � ����� php.ini � ������������� ���-������.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', '��������������: ���������� �����������: ' . DIR_FS_DOWNLOAD . '. �������� ����������.');

define('SUCCESS_ACCOUNT_UPDATED', '���� ������ ���������!');
define('SUCCESS_PASSWORD_UPDATED', '��� ������ ������!');
define('ERROR_CURRENT_PASSWORD_NOT_MATCHING', '��������� ������ �� ��������� � ������� �������. ���������� ��� ���.');
define('TEXT_MAXIMUM_ENTRIES', '<font color="#ff0000"><b>���������:</b></font> ������������ ����� �������� ����� - <b>%s</b> �������');
define('SUCCESS_ADDRESS_BOOK_ENTRY_DELETED', '��������� ����� ����� �� �������� �����.');
define('SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED', '���� �������� ����� ���������.');
define('WARNING_PRIMARY_ADDRESS_DELETION', '�����, ������������� �� ���������, �� ����� ���� �����. ���������� ������ �� ��������� �� ������ ����� � ���������� ��� ���.');
define('ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY', '�������� ����� �� �������.');
define('ERROR_ADDRESS_BOOK_FULL', '���� �������� ����� ��������� ���������. ������� �������� ��� ����� � ������ ����� ����� �� ������� �������� ����� �����.');

//  conditions check

define('ERROR_CONDITIONS_NOT_ACCEPTED', '�� �� ������ ������� ��� ����� ���� �� �� ����������� � ���������!');

define('SUB_TITLE_OT_DISCOUNT','������:');

define('TAX_ADD_TAX','������� ');
define('TAX_NO_TAX','���� ');

define('NOT_ALLOWED_TO_SEE_PRICES','� ��� ��� ������� ��� ��������� ��� ');
define('NOT_ALLOWED_TO_SEE_PRICES_TEXT','� ��� ��� ������� ��� ��������� ���, ����������, �����������������.');

define('TEXT_DOWNLOAD','��������');
define('TEXT_VIEW','��������');

define('TEXT_BUY', '������ \'');
define('TEXT_NOW', '\'');
define('TEXT_GUEST','����������');

/*
 *
 * ADVANCED SEARCH
 *
 */

define('TEXT_ALL_CATEGORIES', '��� ���������');
define('TEXT_ALL_MANUFACTURERS', '��� �������������');
define('JS_AT_LEAST_ONE_INPUT', '* ���� �� ����� ������ ���� ���������:\n    �������� �����\n    ���� ���������� ��:\n    ���� ���������� ��:\n    ���� �� \n    ���� ��\n');
define('AT_LEAST_ONE_INPUT', '���� �� ����� ������ ���� ���������:<br />�������� ����� ��� ������� 3 �������<br />���� ��<br />���� ��<br />');
define('JS_INVALID_FROM_DATE', '* ���� ������� � �������� �������\n');
define('JS_INVALID_TO_DATE', '* ������������ ���� ���������� ��\n');
define('JS_TO_DATE_LESS_THAN_FROM_DATE', '* ���� �� ������ ���� ������ ���� ��\n');
define('JS_PRICE_FROM_MUST_BE_NUM', '* ���� �� ������ ���� �������\n');
define('JS_PRICE_TO_MUST_BE_NUM', '* ���� �� ������ ���� �������\n');
define('JS_PRICE_TO_LESS_THAN_PRICE_FROM', '* ���� �� ������ ���� ������ ���� ��.\n');
define('JS_INVALID_KEYWORDS', '* �������� �������� �����\n');
define('TEXT_LOGIN_ERROR', '<font color="#ff0000"><b>������:</b></font> ��������� \'Email\' �/��� \'������\' ��������.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', '<font color="#ff0000"><b>��������������:</b></font> ��������� Email �� ������. ���������� ��� ���.');
define('TEXT_PASSWORD_SENT', '����� ������ ��� ��������� �� Email.');
define('TEXT_PRODUCT_NOT_FOUND', '����� �� ������!');
define('TEXT_MORE_INFORMATION', '��� ��������� �������������� ���������� �������� <a style="text-decoration:underline;" href="%s" onclick="window.open(this.href); return false;">����</a> ������.');

define('TEXT_DATE_ADDED', '����� ��� �������� � ��� ������� %s');
define('TEXT_DATE_AVAILABLE', '<font color="#ff0000">����� ����� � ������� %s</font>');
define('SUB_TITLE_SUB_TOTAL', '��������� ������:');

define('OUT_OF_STOCK_CANT_CHECKOUT', '������, ���������� ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' ������� �� ����� ������ � ������������� ��� ������ ������ ����������.<br />����������, �������� ���������� ��������� ���������� (' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '), ���������� ���.');
define('OUT_OF_STOCK_CAN_CHECKOUT', '������, ���������� ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' ������� �� ����� ������ � ������������� ��� ������ ������ ����������.<br />��� �� �����, �� ������ �������� ����� ��� ��������� �������� ����������� ������.');

define('MINIMUM_ORDER_VALUE_NOT_REACHED_1', '����������� ����� ������ ������ ����: ');
define('MINIMUM_ORDER_VALUE_NOT_REACHED_2', ' <br />��������� ��� ����� ��� ������� ��: ');
define('MAXIMUM_ORDER_VALUE_REACHED_1', '�� ��������� ����������� ����������� ����� ������, ������������� �: ');
define('MAXIMUM_ORDER_VALUE_REACHED_2', '<br /> ��������� ��� ����� ��� ������� ��: ');

define('ERROR_INVALID_PRODUCT', '����� �� ������!');

/*
 *
 * NAVBAR Titel
 *
 */

define('NAVBAR_TITLE_ACCOUNT', '���� ������');
define('NAVBAR_TITLE_1_ACCOUNT_EDIT', '���� ������');
define('NAVBAR_TITLE_2_ACCOUNT_EDIT', '�������������� ������');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY', '���� ������');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY', '���� ������');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY_INFO', '���� ������');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY_INFO', '����������� ������');
define('NAVBAR_TITLE_3_ACCOUNT_HISTORY_INFO', '����� ����� %s');
define('NAVBAR_TITLE_1_ACCOUNT_PASSWORD', '���� ������');
define('NAVBAR_TITLE_2_ACCOUNT_PASSWORD', '�������� ������');
define('NAVBAR_TITLE_1_ADDRESS_BOOK', '���� ������');
define('NAVBAR_TITLE_2_ADDRESS_BOOK', '�������� �����');
define('NAVBAR_TITLE_1_ADDRESS_BOOK_PROCESS', '���� ������');
define('NAVBAR_TITLE_2_ADDRESS_BOOK_PROCESS', '�������� �����');
define('NAVBAR_TITLE_ADD_ENTRY_ADDRESS_BOOK_PROCESS', '�������� ������');
define('NAVBAR_TITLE_MODIFY_ENTRY_ADDRESS_BOOK_PROCESS', '�������� ������');
define('NAVBAR_TITLE_DELETE_ENTRY_ADDRESS_BOOK_PROCESS', '������� ������');
define('NAVBAR_TITLE_ADVANCED_SEARCH', '����������� �����');
define('NAVBAR_TITLE1_ADVANCED_SEARCH', '����������� �����');
define('NAVBAR_TITLE2_ADVANCED_SEARCH', '���������� ������');
define('NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION', '���������� ������');
define('NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION', '�������������');
define('NAVBAR_TITLE_1_CHECKOUT_PAYMENT', '���������� ������');
define('NAVBAR_TITLE_2_CHECKOUT_PAYMENT', '������ ������');
define('NAVBAR_TITLE_1_PAYMENT_ADDRESS', '���������� ������');
define('NAVBAR_TITLE_2_PAYMENT_ADDRESS', '�������� ����� ����������');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING', '���������� ������');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING', '������ ��������');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING_ADDRESS', '���������� ������');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING_ADDRESS', '�������� ����� ��������');
define('NAVBAR_TITLE_1_CHECKOUT_SUCCESS', '���������� ������');
define('NAVBAR_TITLE_2_CHECKOUT_SUCCESS', '����� ������� ��������');
define('NAVBAR_TITLE_CREATE_ACCOUNT', '�����������');
if ($navigation->snapshot['page'] == FILENAME_CHECKOUT_SHIPPING) {
  define('NAVBAR_TITLE_LOGIN', '�����');
} else {
  define('NAVBAR_TITLE_LOGIN', '����');
}
define('NAVBAR_TITLE_LOGOFF','�����');
define('NAVBAR_TITLE_PRODUCTS_NEW', '����� ������');
define('NAVBAR_TITLE_SHOPPING_CART', '�������');
define('NAVBAR_TITLE_SPECIALS', '������');
define('NAVBAR_TITLE_FEATURED', '������������� ������');
define('NAVBAR_TITLE_COOKIE_USAGE', '������ cookies');
define('NAVBAR_TITLE_PRODUCT_REVIEWS', '������');
define('NAVBAR_TITLE_REVIEWS_WRITE', '�������� �����');
define('NAVBAR_TITLE_REVIEWS','������');
define('NAVBAR_TITLE_SSL_CHECK', '���������� �����');
define('NAVBAR_TITLE_CREATE_GUEST_ACCOUNT','�����������');
define('NAVBAR_TITLE_PASSWORD_DOUBLE_OPT','������ ������?');
define('NAVBAR_TITLE_NEWSLETTER','��������');
define('NAVBAR_GV_REDEEM', '������������ ����������');
define('NAVBAR_GV_SEND', '��������� ����������');

/*
 *
 *  MISC
 *
 */

define('TEXT_NEWSLETTER','������ �������� � �������� ������?<br />����������� �� ���� ������� � �� ������ ������� ��� ���� ���������� � ��������.');
define('TEXT_EMAIL_INPUT','��� E-Mail ����� ��� ������� ��������������� � ����� �������.<br />��� ���� ���������� ������ � ������������ ������� �� �������������. ����������, ��������� �� ������, �������� � ������. � ��������� ������ �� �� ������ �������� �������� ��������!');

define('TEXT_WRONG_CODE','<font color="FF0000">��������� ���� E-mail � ��������� ���.<br />����������, ������ �����������!<br />���������� �������, ���� �� �������� ��������� �����, �� ����� ������ ������ ��������� �����, � �� ��������.');
define('TEXT_EMAIL_EXIST_NO_NEWSLETTER','<font color="FF0000">��������� Email ����� ���������������, �� �� �����������!</font>');
define('TEXT_EMAIL_EXIST_NEWSLETTER','<font color="FF0000">��������� Email ����� ��������������� � �����������!</font>');
define('TEXT_EMAIL_NOT_EXIST','<font color="FF0000">��������� Email ����� �� ���������������!</font>');
define('TEXT_EMAIL_DEL','��������� Email ����� ��� ������� �����.');
define('TEXT_EMAIL_DEL_ERROR','<font color="FF0000">��������� ������, Email ����� �� ��� �����!</font>');
define('TEXT_EMAIL_ACTIVE','<font color="FF0000">��� Email ����� ��� �������� � ������ ��������!</font>');
define('TEXT_EMAIL_ACTIVE_ERROR','<font color="FF0000">��������� ������, Email ����� �� ��� �����������!</font>');
define('TEXT_EMAIL_SUBJECT','�������� ��������');

define('TEXT_CUSTOMER_GUEST','�����');

define('TEXT_LINK_MAIL_SENDED','��� ���������� ������ � ������������ ������� �� ������������� � �������������� ������. <br />��� ���������� ������� �� ������, ��������� � ������. ����� ������������� ������� �� �������������� ������ �� �������� ��� ����� ������ ��� ����� � �������. ���� �� �� �������� �� ��������� ������, ����� ������ �� ����� ���������!');
define('TEXT_PASSWORD_MAIL_SENDED','��� ���������� ������ � ����� ������� � ����� ������������ ����������.<br />����������, �� �������� �������� ��� ����� ������ ����� ������� ����� � �������.');
define('TEXT_CODE_ERROR','��������� ���� EMail � ��������� ��� ��� ���. <br />����������, ������ �����������!');
define('TEXT_EMAIL_ERROR','��������� ���� E-Mail � ��������� ��� ��� ���. <br />����������, ������ �����������!');
define('TEXT_NO_ACCOUNT','� ���������, ������-������������� �� ����� ������ �������� ���� �������. ��������, �� ����������� ������ ������, � �� ����� ��� ���� ���������� ����� �����. ����������, ���������� ��� ���.');

define('HEADING_PASSWORD_FORGOTTEN','������ ������?');
define('TEXT_PASSWORD_FORGOTTEN','�������� ������ � ��� ����.');
define('TEXT_EMAIL_PASSWORD_FORGOTTEN','������������� email ��� �������� ������ ������');
define('TEXT_EMAIL_PASSWORD_NEW_PASSWORD','��� ����� ������');
define('ERROR_MAIL','����������, ��������� ��������� � ����� ������');

define('CATEGORIE_NOT_FOUND','��������� �� �������');

define('GV_FAQ', '������� � ������ �� ������������');
define('ERROR_NO_REDEEM_CODE', '�� �� ������� ��� ����������� ');  
define('ERROR_NO_INVALID_REDEEM_GV', '�������� ��� ����������� '); 
define('TABLE_HEADING_CREDIT', '����� �� ������ ������� ����� �����������/������, ���� �� � ��� ����:<br />(���� � ��� ��� �����������/������, ������ ����������� ��������� �����, ����� ����� �������� ������ "����������")');
define('EMAIL_GV_TEXT_SUBJECT', '������� �� %s');
define('MAIN_MESSAGE', '�� ������ ��������� ���������� �� ����� %s ������ ��������� %s, ��� Email �����: %s<br /><br />���������� ����������� ������� ��������� ���������:<br /><br />��������� %s<br /><br />
                        ��� ��������� ���������� �� ����� %s, �����������: %s');
define('ERROR_REDEEMED_AMOUNT', '��� ���������� ����������� ');
define('REDEEMED_COUPON','��� ����� ������� � ����� ����������� ��� ���������� ���������� ������.');

define('ERROR_INVALID_USES_USER_COUPON','������ ����� ������������ ������ ������ ����� ');
define('ERROR_INVALID_USES_COUPON','���������� ����� ������������ ������ ����� ');
define('TIMES',' ���.');
define('ERROR_INVALID_STARTDATE_COUPON','��� ����� ��� ����������.');
define('ERROR_INVALID_FINISDATE_COUPON','��� ����� �������.');
define('PERSONAL_MESSAGE', '%s �����:');

//Popup Window
define('TEXT_CLOSE_WINDOW', '������� ����.');

/*
 *
 * CUOPON POPUP
 *
 */

define('TEXT_CLOSE_WINDOW', '������� ���� [x]');
define('TEXT_COUPON_HELP_HEADER', '�����������, �� ������������ �����.');
define('TEXT_COUPON_HELP_NAME', '<br /><br />�������� ������: %s');
define('TEXT_COUPON_HELP_FIXED', '<br /><br />����� ������������� ������ � ������� %s');
define('TEXT_COUPON_HELP_MINORDER', '<br /><br />����� ������ ���� ������� �� ����� %s ����� � ��� ��������� ����������� ������������ �����');
define('TEXT_COUPON_HELP_FREESHIP', '<br /><br />������ ����� ������������� ����������� ���������� �������� ������ ������');
define('TEXT_COUPON_HELP_DESC', '<br /><br />�������� ������: %s');
define('TEXT_COUPON_HELP_DATE', '<br /><br />������ ����� ������������ � %s �� %s');
define('TEXT_COUPON_HELP_RESTRICT', '<br /><br />����������� ������ / ���������');
define('TEXT_COUPON_HELP_CATEGORIES', '���������');
define('TEXT_COUPON_HELP_PRODUCTS', '�����');

// VAT ID
define('ENTRY_VAT_TEXT','* ������ ��� �������� � ����� ���������');
define('ENTRY_VAT_ERROR', '��������� VatID ��������! ������� ��������� ID ��� �������� ������ ���� ������.');
define('MSRP','��������� ���� ');
define('YOUR_PRICE','���� ���� ');
define('ONLY',' ����� ');
define('FROM','�� ');
define('YOU_SAVE','�� ��������� ');
define('INSTEAD','������ ');
define('TXT_PER',' �� ');
define('TAX_INFO_INCL','������� %s �����');
define('TAX_INFO_EXCL','�������� %s �����');
define('TAX_INFO_ADD','���� %s �����');
define('SHIPPING_EXCL','+');
define('SHIPPING_COSTS','��������');

// ������ VaM

define('BOX_HEADING_SEARCH', '�����');
define('ICON_ERROR', '������');

// RSS2 Info
define('NAVBAR_TITLE_RSS2_INFO','RSS ������');
define('TEXT_RSS2_INFO', '
<h2>�������� �������</h2>
<dl>
<dt>���������</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=categories' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=categories</a>
<dt>������</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;limit=10</a>
<dt>����� � id ����� 43</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;products_id=43' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;products_id=43</a>
<dt>������ � ���������</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;cPath=25&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;cPath=25&amp;limit=10</a><br />
		������ � ��������� (25 ��� ������������� ���������, �������������� ����� ������, � ������� � ?feed=categories, � ������ ���������, �.�. �� ������ ���������� ������ ������ �� ����������� ���������).
</dl>

<h2>�������������� �������</h2>
<dl>
<dt>�������</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products&amp;limit=10</a></dd>
<dt>������ ������</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers&amp;limit=10</a></dd>
<dt>�������������</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured&amp;limit=10</a></dd>
<dt>������</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials&amp;limit=10</a></dd>
<dt>��������� ������</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming&amp;limit=10</a></dd>
</dl>

<h2>��������� ������</h2>
<dl>
<dt>��������� ����� �� ����� �������</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products_random</a></dd>
<dt>��������� ����� �� ������ �������</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers_random</a></dd>
<dt>��������� ����� �� �������������</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured_random</a></dd>
<dt>��������� ����� �� ������</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials_random</a></dd>
<dt>��������� ����� �� ��������� �������</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming_random</a></dd>
</dl>

<h2>����� ��������</h2>
<p>�������� �������� �� �������� limit.<br />
����� ��������, � �������, �� ��� ������� (rss2.php?feed=new_products), � ������ 10, ������ ���������� �������� limit (rss2.php?feed=new_products&amp;limit=10)</p>
');

define('ENTRY_STATE_RELOAD', '������� �� ������ <b>"��������"</b> ����� ��������� ���� ������');
define('ENTRY_NOSTATE_AVAILIABLE', '� ��������� ������ ��� ��������');
define('ENTRY_STATEXML_LOADING', '�������� �������� ...');

define('SHIPPING_TIME','����� ��������: ');
define('MORE_INFO','[���������]');

define('TABLE_HEADING_LATEST_NEWS', '��������� �������');
define('NAVBAR_TITLE_NEWS', '�������');

define('TEXT_DISPLAY_NUMBER_OF_LATEST_NEWS', '�������� <b>%d</b> - <b>%d</b> (����� <b>%d</b> ��������)');
define('TEXT_NO_NEWS', '��� ��������.');

define('TEXT_INFO_SHOW_PRICE_NO','� ��� ��� ������� ��� ��������� ���');

define('TEXT_OF_5_STARS', '%s �� 5 ����!');

?>