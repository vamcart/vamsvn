<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_cod_fee.php 914 2005-04-30 02:54:02Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_cod_fee.php,v 1.02 2003/02/24); www.oscommerce.com
   (C) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Pl�nkers ; http://www.themedia.at & http://www.oscommerce.at

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


  define('MODULE_ORDER_TOTAL_COD_FEE_TITLE', '��������� ��������');
  define('MODULE_ORDER_TOTAL_COD_FEE_DESCRIPTION', '���������� ��������� ��������');

  define('MODULE_ORDER_TOTAL_COD_FEE_STATUS_TITLE','��������� ��������');
  define('MODULE_ORDER_TOTAL_COD_FEE_STATUS_DESC','���������� ��������� ��������');

  define('MODULE_ORDER_TOTAL_COD_FEE_SORT_ORDER_TITLE','������� ����������');
  define('MODULE_ORDER_TOTAL_COD_FEE_SORT_ORDER_DESC','������� ���������� ������');

  define('MODULE_ORDER_TOTAL_COD_FEE_FLAT_TITLE','������� ������');
  define('MODULE_ORDER_TOTAL_COD_FEE_FLAT_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_COD_FEE_ITEM_TITLE','������ �� �������');
  define('MODULE_ORDER_TOTAL_COD_FEE_ITEM_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_COD_FEE_TABLE_TITLE','��������� ������');
  define('MODULE_ORDER_TOTAL_COD_FEE_TABLE_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_COD_FEE_ZONES_TITLE','������ ��� ���');
  define('MODULE_ORDER_TOTAL_COD_FEE_ZONES_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_COD_FEE_AP_TITLE','����������� �����');
  define('MODULE_ORDER_TOTAL_COD_FEE_AP_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_COD_FEE_CHP_TITLE','����������� �����');
  define('MODULE_ORDER_TOTAL_COD_FEE_CHP_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_COD_FEE_CHRONOPOST_TITLE','���������');
  define('MODULE_ORDER_TOTAL_COD_FEE_CHRONOPOST_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_COD_FEE_DHL_TITLE','DHL �������');
  define('MODULE_ORDER_TOTAL_COD_FEE_DHL_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_COD_FEE_DP_TITLE','�������� �����');
  define('MODULE_ORDER_TOTAL_COD_FEE_DP_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_COD_FEE_UPS_TITLE','UPS');
  define('MODULE_ORDER_TOTAL_COD_FEE_UPS_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');
  
  define('MODULE_ORDER_TOTAL_COD_FEE_UPSE_TITLE','UPS ��������');
  define('MODULE_ORDER_TOTAL_COD_FEE_UPSE_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');

  define('MODULE_ORDER_TOTAL_COD_FEE_FREE_TITLE','���������� �������� (������ ����� ���������� ��������)');
  define('MODULE_ORDER_TOTAL_COD_FEE_FREE_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');
  
  define('MODULE_ORDER_TOTAL_FREEAMOUNT_FREE_TITLE','���������� �������� (������ �������� ���������� ��������)');
  define('MODULE_ORDER_TOTAL_FREEAMOUNT_FREE_DESC','&lt;��� ������ ISO2&gt;:&lt;���������&gt;, ....<br />
  ���� ������� 00, �� �������� ��������� �� ��� ������. 00 ����� ��������� � �������� ���������� ���������. ���� �� ������� 00:9.99, �������� � ���������� ������ ��������� �� ����� (����������).');  

  define('MODULE_ORDER_TOTAL_COD_FEE_TAX_CLASS_TITLE','�����');
  define('MODULE_ORDER_TOTAL_COD_FEE_TAX_CLASS_DESC','�������� �����.');
?>