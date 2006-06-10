<?php
/* -----------------------------------------------------------------------------------------
   $Id: zones.php 899 2005-04-29 02:40:57Z VaM $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(zones.php,v 1.3 2002/04/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (zones.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
   // CUSTOMIZE THIS SETTING
define('NUMBER_OF_ZONES',10);

define('MODULE_SHIPPING_ZONES_TEXT_TITLE', '������ ��� ����');
define('MODULE_SHIPPING_ZONES_TEXT_DESCRIPTION', '��������� ������� �����');
define('MODULE_SHIPPING_ZONES_TEXT_WAY', '�������� ��');
define('MODULE_SHIPPING_ZONES_TEXT_UNITS', '��.');
define('MODULE_SHIPPING_ZONES_INVALID_ZONE', '��� ��������� ������ ��� ����������� �������� ');
define('MODULE_SHIPPING_ZONES_UNDEFINED_RATE', '��������� ��������� ������ �� ����� ���� ���������� ');

define('MODULE_SHIPPING_ZONES_STATUS_TITLE' , '��������� ������ ������ ��� ����');
define('MODULE_SHIPPING_ZONES_STATUS_DESC' , '�� ������ ��������� ������ ������ ��� ����?');
define('MODULE_SHIPPING_ZONES_ALLOWED_TITLE' , '����������� ������');
define('MODULE_SHIPPING_ZONES_ALLOWED_DESC' , '������� ���� �����, ��� ������� ����� �������� ������ ������ (�������� RU,DE (�������� ���� ������, ���� ������ ��� � ������ ��� �������� ����������� �� ����� �����))');
define('MODULE_SHIPPING_ZONES_TAX_CLASS_TITLE' , '�����');
define('MODULE_SHIPPING_ZONES_TAX_CLASS_DESC' , '������������ �����.');
define('MODULE_SHIPPING_ZONES_SORT_ORDER_TITLE' , '������� ����������');
define('MODULE_SHIPPING_ZONES_SORT_ORDER_DESC' , '������� ���������� ������.');

for ($ii=0;$ii<NUMBER_OF_ZONES;$ii++) {
define('MODULE_SHIPPING_ZONES_COUNTRIES_'.$ii.'_TITLE' , '������ ���� '.$ii.'');
define('MODULE_SHIPPING_ZONES_COUNTRIES_'.$ii.'_DESC' , '������ ����� ����� ������� ��� ���� '.$ii.'.');
define('MODULE_SHIPPING_ZONES_COST_'.$ii.'_TITLE' , '��������� �������� ��� '.$ii.' ����');
define('MODULE_SHIPPING_ZONES_COST_'.$ii.'_DESC' , '��������� �������� ��� ���� '.$ii.' �� ���� ������������ ��������� ������. ��������: 3:8.50,7:10.50,... ��� ������, ��� ��������� �������� ��� �������, ����� �� 3 ��. ����� ������ 8.50 ��� ����������� �� ����� '.$ii.' ����.');
define('MODULE_SHIPPING_ZONES_HANDLING_'.$ii.'_TITLE' , '��������� ������������� ������ ��� '.$ii.' ����');
define('MODULE_SHIPPING_ZONES_HANDLING_'.$ii.'_DESC' , '��������� ������������� ������� ������� ��������.');
}
?>
