<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_ps_fee.php,v 1.0 2007/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_ps_fee.php,v 1.02 2003/02/24); www.oscommerce.com
   (c) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Pl�nkers ; http://www.themedia.at & http://www.oscommerce.at
   (c) 2004	 xt:Commerce (ot_ps_fee.php,v 1.02 2003/02/24); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  define('MODULE_ORDER_TOTAL_PS_FEE_TITLE', '�������������� ��������');
  define('MODULE_ORDER_TOTAL_PS_FEE_DESCRIPTION', '���������� �������������� ��������');

  define('MODULE_ORDER_TOTAL_PS_FEE_STATUS_TITLE','�������������� ��������');
  define('MODULE_ORDER_TOTAL_PS_FEE_STATUS_DESC','���������� �������������� ��������');

  define('MODULE_ORDER_TOTAL_PS_FEE_SORT_ORDER_TITLE','������� ����������');
  define('MODULE_ORDER_TOTAL_PS_FEE_SORT_ORDER_DESC','������� ���������� ������');

  define('MODULE_ORDER_TOTAL_PS_FEE_FLAT_TITLE','������� ������');
  define('MODULE_ORDER_TOTAL_PS_FEE_FLAT_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_PS_FEE_ITEM_TITLE','������ �� �������');
  define('MODULE_ORDER_TOTAL_PS_FEE_ITEM_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_PS_FEE_TABLE_TITLE','��������� ������');
  define('MODULE_ORDER_TOTAL_PS_FEE_TABLE_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_PS_FEE_ZONES_TITLE','������ ��� ���');
  define('MODULE_ORDER_TOTAL_PS_FEE_ZONES_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_PS_FEE_AP_TITLE','����������� �����');
  define('MODULE_ORDER_TOTAL_PS_FEE_AP_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_PS_FEE_DP_TITLE','�������� �����');
  define('MODULE_ORDER_TOTAL_PS_FEE_DP_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_PS_FEE_TAX_CLASS_TITLE','�����');
  define('MODULE_ORDER_TOTAL_PS_FEE_TAX_CLASS_DESC','�������� �����.');
?>
