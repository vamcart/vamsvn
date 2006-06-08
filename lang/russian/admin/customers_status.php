<?php
/* --------------------------------------------------------------
   $Id: customers_status.php 1062 2006-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(customers.php,v 1.76 2003/05/04); www.oscommerce.com
   (c) 2003	 nextcommerce (customers_status.php,v 1.12 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License
   --------------------------------------------------------------*/

define('HEADING_TITLE', '������ ��������');

define('ENTRY_CUSTOMERS_FSK18','����������� ������� ������� FSK18?');
define('ENTRY_CUSTOMERS_FSK18_DISPLAY','����������� ������� ������� FSK18?');
define('ENTRY_CUSTOMERS_STATUS_ADD_TAX','���������� ����� �� �������� ������������� ������');
define('ENTRY_CUSTOMERS_STATUS_MIN_ORDER','����������� ����� ������:');
define('ENTRY_CUSTOMERS_STATUS_MAX_ORDER','������������ ����� ������:');
define('ENTRY_CUSTOMERS_STATUS_BT_PERMISSION','������ ����� ���������� �������');
define('ENTRY_CUSTOMERS_STATUS_CC_PERMISSION','������ ���������');
define('ENTRY_CUSTOMERS_STATUS_COD_PERMISSION','������ ���������');
define('ENTRY_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES','������');
define('ENTRY_CUSTOMERS_STATUS_PAYMENT_UNALLOWED','������� ������������� ������ ������');
define('ENTRY_CUSTOMERS_STATUS_PUBLIC','���������� � �������� ���� ���� (������ ������ public)<br />');
define('ENTRY_CUSTOMERS_STATUS_SHIPPING_UNALLOWED','������� ������������� ������ ��������');
define('ENTRY_CUSTOMERS_STATUS_SHOW_PRICE','����');
define('ENTRY_CUSTOMERS_STATUS_SHOW_PRICE_TAX','���� ������� ������');
define('ENTRY_CUSTOMERS_STATUS_WRITE_REVIEWS','��������� ���� ������ �������� ������ ������?');
define('ENTRY_CUSTOMERS_STATUS_READ_REVIEWS','��������� ���� ������ �������� ������ ������?');
define('ENTRY_CUSTOMERS_STATUS_READ_REVIEWS_DISPLAY','��������� ���� ������ �������� ������ ������?');
define('ENTRY_GRADUATED_PRICES','���� �� ����������');
define('ENTRY_NO','���');
define('ENTRY_OT_XMEMBER', '���������� ������ ������� �� �������� ������������� ������ ? :');
define('ENTRY_YES','��');

define('ERROR_REMOVE_DEFAULT_CUSTOMER_STATUS', '������: ������ �� ��������� �� ����� ���� �������. ���������� ������ ������ �� ��������� � ���������� �����.');
define('ERROR_REMOVE_DEFAULT_CUSTOMERS_STATUS','������! �� �� ������ ������� ����������� ������');
define('ERROR_STATUS_USED_IN_CUSTOMERS', '������: ��� ������ ������� � � ��� ���� �������.');
define('ERROR_STATUS_USED_IN_HISTORY', '������: ��� ������ ������������ � ������� �������.');

define('YES','��');
define('NO','���');

define('TABLE_HEADING_ACTION','��������');
define('TABLE_HEADING_CUSTOMERS_GRADUATED','���� �� ����������');
define('TABLE_HEADING_CUSTOMERS_STATUS','������');
define('TABLE_HEADING_CUSTOMERS_UNALLOW','������������� ������ ������');
define('TABLE_HEADING_CUSTOMERS_UNALLOW_SHIPPING','������������� ������ ��������');
define('TABLE_HEADING_DISCOUNT','������');
define('TABLE_HEADING_TAX_PRICE','���������� ���� / ������� �����');

define('TAX_NO','���');
define('TAX_YES','��');

define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS_STATUS', '������������ ������ ��������:');

define('TEXT_INFO_CUSTOMERS_FSK18_DISPLAY_INTRO','<b>FSK18 ������</b>');
define('TEXT_INFO_CUSTOMERS_FSK18_INTRO','<b>FSK18 ������������</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_ADD_TAX_INTRO','<b>���� ���� �������� �����, ���������� ����� � = "���"</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_MIN_ORDER_INTRO','���������� ����������� ����� ������ ��� �������� ���� ������.');
define('TEXT_INFO_CUSTOMERS_STATUS_MAX_ORDER_INTRO','���������� ������������ ����� ������ ��� �������� ���� ������.');
define('TEXT_INFO_CUSTOMERS_STATUS_BT_PERMISSION_INTRO', '<b>��������� ����������� ���� ������ ������ ����� ���������� �������?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_CC_PERMISSION_INTRO', '<b>��������� ����������� ���� ������ ������ ���������� �������?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_COD_PERMISSION_INTRO', '<b>��������� ����������� ���� ������ ������ ���������?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES_INTRO','<b>������ ��� ��������� ������</b><br />(����. % ������ �� ������� ������)');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_OT_XMEMBER_INTRO','<b>���������� ������ �� �������� ������������� ������</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE', '������ (�� 0 �� 100%):');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE_INTRO', '������� ������ �� 0 �� 100%, ������� ����� ��������� � ������� ������.');
define('TEXT_INFO_CUSTOMERS_STATUS_GRADUATED_PRICES_INTRO','<b>���� �� ����������</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_IMAGE','�������� ������');
define('TEXT_INFO_CUSTOMERS_STATUS_NAME','<b>�������� ������</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_PAYMENT_UNALLOWED_INTRO','<b>������������� ������ ������</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_PUBLIC_INTRO','<b>���������� ���� � ��������?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_SHIPPING_UNALLOWED_INTRO','<b>������������� ������ ��������</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_INTRO','<b>���������� ���� � ��������</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_TAX_INTRO','<b>���������� ���� � ������� ��� ���</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_WRITE_REVIEWS_INTRO','<b>��������� �������</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_READ_REVIEWS_INTRO', '<b>������ �������</b>');

define('TEXT_INFO_DELETE_INTRO', '�� ������������� ������ ������� ��� ������?');
define('TEXT_INFO_EDIT_INTRO', '����������, ������� ����������� ���������');
define('TEXT_INFO_INSERT_INTRO', '�������� ����� ������.');

define('TEXT_INFO_HEADING_DELETE_CUSTOMERS_STATUS', '�������� ������');
define('TEXT_INFO_HEADING_EDIT_CUSTOMERS_STATUS','�������������� ������');
define('TEXT_INFO_HEADING_NEW_CUSTOMERS_STATUS', '����� ������');

define('TEXT_INFO_CUSTOMERS_STATUS_BASE', '<b>���� ��� ������</b>');
define('ENTRY_CUSTOMERS_STATUS_BASE', '����� ���� ����� ������������ ������ ������ (�����, ����� ���������� ��� ������). ���� ������ �����, �� ���� �� ������������.');

?>