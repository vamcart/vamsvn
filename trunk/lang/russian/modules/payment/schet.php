<?php
/* -----------------------------------------------------------------------------------------
   $Id: schet.php 998 2007/02/07 13:24:46 VaM $
������
   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ptebanktransfer.php,v 1.4.1 2003/09/25 19:57:14); www.oscommerce.com
   (c) 2004	 xt:Commerce (eustandardtransfer.php,v 1.5 2003/08/13); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_SCHET_TEXT_TITLE', '������ �� �����');
  define('MODULE_PAYMENT_SCHET_TEXT_DESCRIPTION', '<br /><strong>���� �� ������� ����������� �� ��������� ��������.</strong><br /><br />���������� ��� ������:<br />' .
                                                         '<br />���������: ' . MODULE_PAYMENT_SCHET_1 .
                                                         '<br />�����: ' . MODULE_PAYMENT_SCHET_2 .
                                                         '<br />�������: ' . MODULE_PAYMENT_SCHET_3 .
                                                         '<br />����: ' . MODULE_PAYMENT_SCHET_4 .
                                                         '<br />�/c: ' . MODULE_PAYMENT_SCHET_5 .
                                                         '<br />�������� �����: ' . MODULE_PAYMENT_SCHET_6 .
                                                         '<br />�/c: ' . MODULE_PAYMENT_SCHET_7 .
                                                         '<br />���: ' . MODULE_PAYMENT_SCHET_8 .
                                                         '<br />���: ' . MODULE_PAYMENT_SCHET_9 .
                                                         '<br />���: ' . MODULE_PAYMENT_SCHET_10 .
                                                         '<br />����: ' . MODULE_PAYMENT_SCHET_11 .
                                                         '<br />����: ' . MODULE_PAYMENT_SCHET_12 .
                                                         '<br /><br />��� ����� ����� �������� ������ ����� ��������� ������.<br />');
  define('MODULE_PAYMENT_SCHET_TEXT_EMAIL_FOOTER', str_replace('<br />','\n',MODULE_PAYMENT_SCHET_TEXT_DESCRIPTION));

  define('MODULE_PAYMENT_SCHET_STATUS_TITLE','��������� ������ ������ �� �����');
  define('MODULE_PAYMENT_SCHET_STATUS_DESC','��������� ������������� ������ ������ �� ����� ��� ���������� ������ � ��������?');

  define('MODULE_PAYMENT_SCHET_TEXT_INFO','');

  define('MODULE_PAYMENT_SCHET_1_TITLE','���������');
  define('MODULE_PAYMENT_SCHET_1_DESC','������� �������� �����������.');

  define('MODULE_PAYMENT_SCHET_2_TITLE','�����');
  define('MODULE_PAYMENT_SCHET_2_DESC','������� ����� �����������.');

  define('MODULE_PAYMENT_SCHET_3_TITLE','�������');
  define('MODULE_PAYMENT_SCHET_3_DESC','������� �������.');

  define('MODULE_PAYMENT_SCHET_4_TITLE','����');
  define('MODULE_PAYMENT_SCHET_4_DESC','������� ����.');

  define('MODULE_PAYMENT_SCHET_5_TITLE','�/�');
  define('MODULE_PAYMENT_SCHET_5_DESC','������� �/�.');

  define('MODULE_PAYMENT_SCHET_6_TITLE','�������� �����');
  define('MODULE_PAYMENT_SCHET_6_DESC','������� �������� �����.');

  define('MODULE_PAYMENT_SCHET_7_TITLE','�/c');
  define('MODULE_PAYMENT_SCHET_7_DESC','������� �/c.');

  define('MODULE_PAYMENT_SCHET_8_TITLE','���');
  define('MODULE_PAYMENT_SCHET_8_DESC','������� ���.');

  define('MODULE_PAYMENT_SCHET_9_TITLE','���');
  define('MODULE_PAYMENT_SCHET_9_DESC','������� ���.');

  define('MODULE_PAYMENT_SCHET_10_TITLE','���');
  define('MODULE_PAYMENT_SCHET_10_DESC','������� ���.');

  define('MODULE_PAYMENT_SCHET_11_TITLE','����');
  define('MODULE_PAYMENT_SCHET_11_DESC','������� ����.');

  define('MODULE_PAYMENT_SCHET_12_TITLE','����');
  define('MODULE_PAYMENT_SCHET_12_DESC','������� ����.');

  define('MODULE_PAYMENT_SCHET_SORT_ORDER_TITLE','������� ����������');
  define('MODULE_PAYMENT_SCHET_SORT_ORDER_DESC','������� ������� ���������� ������.');

  define('MODULE_PAYMENT_SCHET_ALLOWED_TITLE' , '����������� ������');
  define('MODULE_PAYMENT_SCHET_ALLOWED_DESC' , '������� ���� �����, ��� ������� ����� �������� ������ ������ (�������� RU,DE (�������� ���� ������, ���� ������ ��� � ������ ��� �������� ����������� �� ����� �����))');

  define('MODULE_PAYMENT_SCHET_ZONE_TITLE' , '����');
  define('MODULE_PAYMENT_SCHET_ZONE_DESC' , '���� ������� ����, �� ������ ������ ������ ����� ����� ������ ����������� �� ��������� ����.');

  define('MODULE_PAYMENT_SCHET_ORDER_STATUS_ID_TITLE' , '������ ������');
  define('MODULE_PAYMENT_SCHET_ORDER_STATUS_ID_DESC' , '������, ����������� � �������������� ������� ������ ������ ����� ��������� ��������� ������.');

?>