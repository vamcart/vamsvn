<?php
/* -----------------------------------------------------------------------------------------
   $Id: secpay.php 998 2005-07-07 14:18:20Z VaM $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce 
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(secpay.php,v 1.8 2002/11/01); www.oscommerce.com 
   (c) 2003	 nextcommerce (secpay.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_SECPAY_TEXT_TITLE', 'SECPay');
  define('MODULE_PAYMENT_SECPAY_TEXT_DESCRIPTION', '���������� � ��������� �������� ��� �����:<br><br>����� ��������: 4111111111111111<br>������������� ��: ����� ����');
  define('MODULE_PAYMENT_SECPAY_TEXT_ERROR', '������, ���������� ��� ���!');
  define('MODULE_PAYMENT_SECPAY_TEXT_ERROR_MESSAGE', '������ ��� ��������� ����� ��������� ��������, ����������, ����������� �����.');
define('MODULE_PAYMENT_SECPAY_TEXT_INFO','');
  define('MODULE_PAYMENT_SECPAY_MERCHANT_ID_TITLE' , 'Merchant ID');
define('MODULE_PAYMENT_SECPAY_MERCHANT_ID_DESC' , 'Merchant ID to use for the SECPay service');
define('MODULE_PAYMENT_SECPAY_ALLOWED_TITLE' , '����������� ������');
define('MODULE_PAYMENT_SECPAY_ALLOWED_DESC' , '������� ���� �����, ��� ������� ����� �������� ������ ������ (�������� RU,DE (�������� ���� ������, ���� ������ ��� � ������ ��� �������� ����������� �� ����� �����))');
define('MODULE_PAYMENT_SECPAY_STATUS_TITLE' , 'Enable SECpay Module');
define('MODULE_PAYMENT_SECPAY_STATUS_DESC' , 'Do you want to accept SECPay payments?');
define('MODULE_PAYMENT_SECPAY_CURRENCY_TITLE' , 'Transaction Currency');
define('MODULE_PAYMENT_SECPAY_CURRENCY_DESC' , 'The currency to use for credit card transactions');
define('MODULE_PAYMENT_SECPAY_TEST_STATUS_TITLE' , 'Transaction Mode');
define('MODULE_PAYMENT_SECPAY_TEST_STATUS_DESC' , 'Transaction mode to use for the SECPay service');
define('MODULE_PAYMENT_SECPAY_SORT_ORDER_TITLE' , '������� ����������');
define('MODULE_PAYMENT_SECPAY_SORT_ORDER_DESC' , '������� ���������� ������.');
define('MODULE_PAYMENT_SECPAY_ZONE_TITLE' , '����');
define('MODULE_PAYMENT_SECPAY_ZONE_DESC' , '���� ������� ����, �� ������ ������ ������ ����� ����� ������ ����������� �� ��������� ����.');
define('MODULE_PAYMENT_SECPAY_ORDER_STATUS_ID_TITLE' , '������ ������');
define('MODULE_PAYMENT_SECPAY_ORDER_STATUS_ID_DESC' , '������, ����������� � �������������� ������� ������ ������ ����� ��������� ��������� ������.');
?>
