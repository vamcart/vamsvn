<?php
/* -----------------------------------------------------------------------------------------
   $Id: pm2checkout.php 998 2005-07-07 14:18:20Z VaM $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(pm2checkout.php,v 1.4 2002/11/01); www.oscommerce.com 
   (c) 2003	 nextcommerce (pm2checkout.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_TITLE', '2CheckOut');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_DESCRIPTION', '���������� � ��������� �������� ��� �����:<br><br>����� ��������: 4111111111111111<br>������������� ��: ����� ����');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_TYPE', '���:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_OWNER', '�������� ��������� ��������:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_OWNER_FIRST_NAME', '��� ��������� ��������� ��������:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_OWNER_LAST_NAME', '������� ��������� ��������� ��������:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_NUMBER', '����� ��������� ��������:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_EXPIRES', '������������� ��:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER', '����������� ����� ��������� ��������:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '(�� �������� ������� ��������� �������� ����� � ��������)');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_JS_CC_NUMBER', '* ����� ��������� �������� ������ ���� �� ������� ���� ' . CC_NUMBER_MIN_LENGTH . ' ��������.\n');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_ERROR_MESSAGE', '������ ��� ��������� ��������� ��������. ���������� ������ ������ �����.');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_ERROR', 'Credit Card Error!');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_INFO','');
  define('MODULE_PAYMENT_PM2CHECKOUT_STATUS_TITLE' , 'Enable 2CheckOut Module');
define('MODULE_PAYMENT_PM2CHECKOUT_STATUS_DESC' , 'Do you want to accept 2CheckOut payments?');
define('MODULE_PAYMENT_PM2CHECKOUT_ALLOWED_TITLE' , '����������� ������');
define('MODULE_PAYMENT_PM2CHECKOUT_ALLOWED_DESC' , '������� ���� �����, ��� ������� ����� �������� ������ ������ (�������� RU,DE (�������� ���� ������, ���� ������ ��� � ������ ��� �������� ����������� �� ����� �����))');
define('MODULE_PAYMENT_PM2CHECKOUT_LOGIN_TITLE' , 'Login/Store Number');
define('MODULE_PAYMENT_PM2CHECKOUT_LOGIN_DESC' , 'Login/Store Number used for the 2CheckOut service');
define('MODULE_PAYMENT_PM2CHECKOUT_TESTMODE_TITLE' , 'Transaction Mode');
define('MODULE_PAYMENT_PM2CHECKOUT_TESTMODE_DESC' , 'Transaction mode used for the 2Checkout service');
define('MODULE_PAYMENT_PM2CHECKOUT_EMAIL_MERCHANT_TITLE' , 'Merchant Notifications');
define('MODULE_PAYMENT_PM2CHECKOUT_EMAIL_MERCHANT_DESC' , 'Should 2CheckOut eMail a receipt to the store owner?');
define('MODULE_PAYMENT_PM2CHECKOUT_SORT_ORDER_TITLE' , '������� ����������');
define('MODULE_PAYMENT_PM2CHECKOUT_SORT_ORDER_DESC' , '������� ���������� ������.');
define('MODULE_PAYMENT_PM2CHECKOUT_ZONE_TITLE' , '����');
define('MODULE_PAYMENT_PM2CHECKOUT_ZONE_DESC' , '���� ������� ����, �� ������ ������ ������ ����� ����� ������ ����������� �� ��������� ����.');
define('MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID_TITLE' , '������ ������');
define('MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID_DESC' , '������, ����������� � �������������� ������� ������ ������ ����� ��������� ��������� ������.');
?>