<?php
/* -----------------------------------------------------------------------------------------
   $Id: moneyorder.php 998 2005-07-07 14:18:20Z VaM $   

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

  define('MODULE_PAYMENT_MONEYORDER_TEXT_TITLE', '������ �����');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', '���������� ��� ������:&nbsp;' . MODULE_PAYMENT_MONEYORDER_PAYTO . '<br />�������� �����:<br /><br />' . nl2br(STORE_NAME_ADDRESS) . '<br /><br />' . '��� ����� ����� ��������� ������ ����� ��������� ������!');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', "���������� ��� ������: ". MODULE_PAYMENT_MONEYORDER_PAYTO . "\n\n�������� �����:\n" . STORE_NAME_ADDRESS . "\n\n" . '��� ����� ����� ��������� ������ ����� ��������� ������!');
define('MODULE_PAYMENT_MONEYORDER_TEXT_INFO','');
  define('MODULE_PAYMENT_MONEYORDER_STATUS_TITLE' , '��������� ������ ������ �����');
define('MODULE_PAYMENT_MONEYORDER_STATUS_DESC' , '�� ������ ��������� ������������� ������ ��� ���������� �������?');
define('MODULE_PAYMENT_MONEYORDER_ALLOWED_TITLE' , '����������� ������');
define('MODULE_PAYMENT_MONEYORDER_ALLOWED_DESC' , '������� ���� �����, ��� ������� ����� �������� ������ ������ (�������� RU,DE (�������� ���� ������, ���� ������ ��� � ������ ��� �������� ����������� �� ����� �����))');
define('MODULE_PAYMENT_MONEYORDER_PAYTO_TITLE' , '���������� ��� ������:');
define('MODULE_PAYMENT_MONEYORDER_PAYTO_DESC' , '��� ������ �������� ������?');
define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_TITLE' , '������� ����������');
define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_DESC' , '������� ���������� ������.');
define('MODULE_PAYMENT_MONEYORDER_ZONE_TITLE' , '����');
define('MODULE_PAYMENT_MONEYORDER_ZONE_DESC' , '���� ������� ����, �� ������ ������ ������ ����� ����� ������ ����������� �� ��������� ����.');
define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_TITLE' , '������ ������');
define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_DESC' , '������, ����������� � �������������� ������� ������ ������ ����� ��������� ��������� ������.');
?>
