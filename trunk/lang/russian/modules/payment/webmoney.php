<?php
/* -----------------------------------------------------------------------------------------
   $Id: webmoney.php 998 2005-07-07 14:18:20Z VaM $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneyorder.php,v 1.8 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
  define('MODULE_PAYMENT_WEBMONEY_TEXT_TITLE', 'WebMoney');
  define('MODULE_PAYMENT_WEBMONEY_TEXT_DESCRIPTION', '���������� ��� ������:<br /><br />WM �������������: ' . MODULE_PAYMENT_WEBMONEY_WMID . '<br />������ WMZ: ' . MODULE_PAYMENT_WEBMONEY_WMZ . '<br />������ WMR: ' . MODULE_PAYMENT_WEBMONEY_WMR . '<br /><br />' . '��� ����� ����� �������� ������ ����� ��������� ������!');
  define('MODULE_PAYMENT_WEBMONEY_TEXT_EMAIL_FOOTER', "���������� ��� ������:\n\n��� WM �������������: ". MODULE_PAYMENT_WEBMONEY_WMID . "\n\n������ WMZ: ". MODULE_PAYMENT_WEBMONEY_WMZ . "\n\n������ WMR: ". MODULE_PAYMENT_WEBMONEY_WMR . "\n\n" . '��� ����� ����� �������� ������ ����� ��������� ������!');
define('MODULE_PAYMENT_WEBMONEY_TEXT_INFO','');
  define('MODULE_PAYMENT_WEBMONEY_STATUS_TITLE' , '��������� ������ WebMoney');
define('MODULE_PAYMENT_WEBMONEY_STATUS_DESC' , '�� ������ ��������� ������������� ������ ��� ���������� �������?');
define('MODULE_PAYMENT_WEBMONEY_ALLOWED_TITLE' , '����������� ������');
define('MODULE_PAYMENT_WEBMONEY_ALLOWED_DESC' , '������� ���� �����, ��� ������� ����� �������� ������ ������ (�������� RU,DE (�������� ���� ������, ���� ������ ��� � ������ ��� �������� ����������� �� ����� �����))');
define('MODULE_PAYMENT_WEBMONEY_WMID_TITLE' , 'WM ID:');
define('MODULE_PAYMENT_WEBMONEY_WMID_DESC' , '������� ��� WM ID');
define('MODULE_PAYMENT_WEBMONEY_WMZ_TITLE' , '��� WMZ ������:');
define('MODULE_PAYMENT_WEBMONEY_WMZ_DESC' , '������� ����� ������ WMZ ��������');
define('MODULE_PAYMENT_WEBMONEY_WMR_TITLE' , '��� WMR ������:');
define('MODULE_PAYMENT_WEBMONEY_WMR_DESC' , '������� ����� ������ WMR ��������');
define('MODULE_PAYMENT_WEBMONEY_SORT_ORDER_TITLE' , '������� ����������');
define('MODULE_PAYMENT_WEBMONEY_SORT_ORDER_DESC' , '������� ���������� ������.');
define('MODULE_PAYMENT_WEBMONEY_ZONE_TITLE' , '����');
define('MODULE_PAYMENT_WEBMONEY_ZONE_DESC' , '���� ������� ����, �� ������ ������ ������ ����� ����� ������ ����������� �� ��������� ����.');
define('MODULE_PAYMENT_WEBMONEY_ORDER_STATUS_ID_TITLE' , '������ ������');
define('MODULE_PAYMENT_WEBMONEY_ORDER_STATUS_ID_DESC' , '������, ����������� � �������������� ������� ������ ������ ����� ��������� ��������� ������.');
?>
