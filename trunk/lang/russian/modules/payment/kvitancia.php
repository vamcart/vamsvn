<?php
/* -----------------------------------------------------------------------------------------
   $Id: eustandardtransfer.php 998 2007/02/07 13:24:46 VaM $
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

  define('MODULE_PAYMENT_KVITANCIA_TEXT_TITLE', '��������� �� ��');
  define('MODULE_PAYMENT_KVITANCIA_TEXT_DESCRIPTION', '<br /><strong>��������� ��� ������ �� ������� ����������� �� ��������� ��������.</strong><br /><br />���������� ��� ������:<br />' .
                                                         '<br />�������� �����: ' . MODULE_PAYMENT_KVITANCIA_1 .
                                                         '<br />��������� ����: ' . MODULE_PAYMENT_KVITANCIA_2 .
                                                         '<br />���: ' . MODULE_PAYMENT_KVITANCIA_3 .
                                                         '<br />���./����: ' . MODULE_PAYMENT_KVITANCIA_4 .
                                                         '<br />���: ' . MODULE_PAYMENT_KVITANCIA_5 .
                                                         '<br />����������: ' . MODULE_PAYMENT_KVITANCIA_6 .
                                                         '<br />���: ' . MODULE_PAYMENT_KVITANCIA_7 .
                                                         '<br /><br />��� ����� ����� �������� ������ ����� ��������� ������.<br />');
  define('MODULE_PAYMENT_KVITANCIA_TEXT_EMAIL_FOOTER', str_replace('<br />','\n',MODULE_PAYMENT_KVITANCIA_TEXT_DESCRIPTION));

  define('MODULE_PAYMENT_KVITANCIA_STATUS_TITLE','��������� ������ ��������� �� ��');
  define('MODULE_PAYMENT_KVITANCIA_STATUS_DESC','��������� ������������� ������ ��������� �� �� ��� ���������� ������ � ��������?');

  define('MODULE_PAYMENT_KVITANCIA_TEXT_INFO','');

  define('MODULE_PAYMENT_KVITANCIA_1_TITLE','�������� �����');
  define('MODULE_PAYMENT_KVITANCIA_1_DESC','������� �������� �����.');

  define('MODULE_PAYMENT_KVITANCIA_2_TITLE','��������� ����');
  define('MODULE_PAYMENT_KVITANCIA_2_DESC','������� ��� ��������� ����.');

  define('MODULE_PAYMENT_KVITANCIA_3_TITLE','���');
  define('MODULE_PAYMENT_KVITANCIA_3_DESC','������� ���.');

  define('MODULE_PAYMENT_KVITANCIA_4_TITLE','���./����');
  define('MODULE_PAYMENT_KVITANCIA_4_DESC','������� ���./����.');

  define('MODULE_PAYMENT_KVITANCIA_5_TITLE','���');
  define('MODULE_PAYMENT_KVITANCIA_5_DESC','������� ���.');

  define('MODULE_PAYMENT_KVITANCIA_6_TITLE','����������');
  define('MODULE_PAYMENT_KVITANCIA_6_DESC','������� ���������� �������.');

  define('MODULE_PAYMENT_KVITANCIA_7_TITLE','���');
  define('MODULE_PAYMENT_KVITANCIA_7_DESC','������� ���.');

  define('MODULE_PAYMENT_KVITANCIA_8_TITLE','���������� �������');
  define('MODULE_PAYMENT_KVITANCIA_8_DESC','������� �������� �������.');

  define('MODULE_PAYMENT_KVITANCIA_SORT_ORDER_TITLE','������� ����������');
  define('MODULE_PAYMENT_KVITANCIA_SORT_ORDER_DESC','������� ������� ���������� ������.');

  define('MODULE_PAYMENT_KVITANCIA_ALLOWED_TITLE' , '����������� ������');
  define('MODULE_PAYMENT_KVITANCIA_ALLOWED_DESC' , '������� ���� �����, ��� ������� ����� �������� ������ ������ (�������� RU,DE (�������� ���� ������, ���� ������ ��� � ������ ��� �������� ����������� �� ����� �����))');

  define('MODULE_PAYMENT_KVITANCIA_ZONE_TITLE' , '����');
  define('MODULE_PAYMENT_KVITANCIA_ZONE_DESC' , '���� ������� ����, �� ������ ������ ������ ����� ����� ������ ����������� �� ��������� ����.');

  define('MODULE_PAYMENT_KVITANCIA_ORDER_STATUS_ID_TITLE' , '������ ������');
  define('MODULE_PAYMENT_KVITANCIA_ORDER_STATUS_ID_DESC' , '������, ����������� � �������������� ������� ������ ������ ����� ��������� ��������� ������.');

?>