<?php
/* --------------------------------------------------------------
   $Id: recover_cart_sales.php 899 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2003	 JM Ivler (recover_cart_sales.php,v 1.4 2003/08/14); oscommerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('MESSAGE_STACK_CUSTOMER_ID', '������������� ����� ���������� (id ��� ');
define('MESSAGE_STACK_DELETE_SUCCESS', ') ������� �����.');
define('HEADING_TITLE_RECOVER', '������������� ������');
define('HEADING_EMAIL_SENT', '����� �� �������� �����');
define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', '��������� �� ��������-�������� '.  STORE_NAME );
define('DAYS_FIELD_PREFIX', '�������� ������ �� ��������� ');
define('DAYS_FIELD_POSTFIX', ' ���� ');
define('DAYS_FIELD_BUTTON', '��������');
define('TABLE_HEADING_DATE', '����');
define('TABLE_HEADING_CONTACT', '��������');
define('TABLE_HEADING_CUSTOMER', '��� ����������');
define('TABLE_HEADING_EMAIL', 'E-mail �����');
define('TABLE_HEADING_PHONE', '�������');
define('TABLE_HEADING_MODEL', '���');
define('TABLE_HEADING_DESCRIPTION', '�����');
define('TABLE_HEADING_QUANTY', '����������');
define('TABLE_HEADING_PRICE', '���������');
define('TABLE_HEADING_TOTAL', '�����');
define('TABLE_GRAND_TOTAL', '����� ��������� ������������� �������: ');
define('TABLE_CART_TOTAL', '��������� ������: ');
define('TEXT_CURRENT_CUSTOMER', '����������');
define('TEXT_SEND_EMAIL', '��������� E-mail');
define('TEXT_RETURN', '��������� �����');
define('TEXT_NOT_CONTACTED', '�� ��������');
define('PSMSG', '�������������� ���������: ');
?>