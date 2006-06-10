<?php

/* -----------------------------------------------------------------------------------------
   $Id: authorizenet.php 1003 2005-07-10 18:58:52Z VaM $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(authorizenet.php,v 1.15 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (authorizenet.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------*/
define('MODULE_PAYMENT_TYPE_PERMISSION', 'cod');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_TITLE', 'Authorize.net');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_DESCRIPTION', '���������� � ��������� �������� ��� �����:<br><br>����� ��������: 4111111111111111<br>������������� ��: ����� ����');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_TYPE', '���:');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_OWNER', '�������� ��������� ��������:');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_NUMBER', '����� ��������� ��������:');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_CREDIT_CARD_EXPIRES', '������������� ��:');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_JS_CC_OWNER', '* ��� ��������� ��������� �������� ������ ��������� �� ������� ���� ' . CC_OWNER_MIN_LENGTH . ' ��������.\n');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_JS_CC_NUMBER', '* ����� ��������� �������� ������ ���� �� ������� ���� ' . CC_NUMBER_MIN_LENGTH . ' ��������.\n');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_ERROR_MESSAGE', '������ ��� ��������� ����� ��������� ��������, ����������, ����������� �����.');
  define('MODULE_PAYMENT_AUTHORIZENET_TEXT_DECLINED_MESSAGE', '���� ��������� �������� ���������������. ���������� ��������������� ������ ��������� ���������.');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_ERROR', 'Credit Card Error!');
define('MODULE_PAYMENT_AUTHORIZENET_TEXT_INFO', '');
define('TEXT_CCVAL_ERROR_INVALID_DATE', 'The "valid to" date ist invalid.<br />Please correct your information.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'The "Credit card number", you entered, is invalid.<br />Please correct your information.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'The first 4 digits of your Credit Card are: %s<br />If this information is correct, your type of card is not accepted.<br />Please correct your information.');

define('MODULE_PAYMENT_AUTHORIZENET_TXNKEY_TITLE', 'Transaction Key');
define('MODULE_PAYMENT_AUTHORIZENET_TXNKEY_DESC', 'Transaction Key used for encrypting TP data');
define('MODULE_PAYMENT_AUTHORIZENET_TESTMODE_TITLE', 'Transaction Mode');
define('MODULE_PAYMENT_AUTHORIZENET_TESTMODE_DESC', 'Transaction mode used for processing orders');
define('MODULE_PAYMENT_AUTHORIZENET_METHOD_TITLE', 'Transaction Method');
define('MODULE_PAYMENT_AUTHORIZENET_METHOD_DESC', 'Transaction method used for processing orders');
define('MODULE_PAYMENT_AUTHORIZENET_EMAIL_CUSTOMER_TITLE', 'Customer Notifications');
define('MODULE_PAYMENT_AUTHORIZENET_EMAIL_CUSTOMER_DESC', 'Should Authorize.Net eMail a receipt to the customer?');
define('MODULE_PAYMENT_AUTHORIZENET_STATUS_TITLE', 'Enable Authorize.net Module');
define('MODULE_PAYMENT_AUTHORIZENET_STATUS_DESC', 'Do you want to accept Authorize.net payments?');
define('MODULE_PAYMENT_AUTHORIZENET_LOGIN_TITLE', 'Login Username');
define('MODULE_PAYMENT_AUTHORIZENET_LOGIN_DESC', 'The login username used for the Authorize.net service');
define('MODULE_PAYMENT_AUTHORIZENET_ORDER_STATUS_ID_TITLE', '������ ������');
define('MODULE_PAYMENT_AUTHORIZENET_ORDER_STATUS_ID_DESC', '������, ����������� � �������������� ������� ������ ������ ����� ��������� ��������� ������.');
define('MODULE_PAYMENT_AUTHORIZENET_SORT_ORDER_TITLE', '������� ����������');
define('MODULE_PAYMENT_AUTHORIZENET_SORT_ORDER_DESC', '������� ���������� ������.');
define('MODULE_PAYMENT_AUTHORIZENET_ZONE_TITLE', '����');
define('MODULE_PAYMENT_AUTHORIZENET_ZONE_DESC', '���� ������� ����, �� ������ ������ ������ ����� ����� ������ ����������� �� ��������� ����.');
define('MODULE_PAYMENT_AUTHORIZENET_ALLOWED_TITLE', '����������� ������');
define('MODULE_PAYMENT_AUTHORIZENET_ALLOWED_DESC', '������� ���� �����, ��� ������� ����� �������� ������ ������ (�������� RU,DE (�������� ���� ������, ���� ������ ��� � ������ ��� �������� ����������� �� ����� �����))');
?>

