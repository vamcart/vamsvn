<?php
/* --------------------------------------------------------------
   $Id: orders.php 1193 2006-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders.php,v 1.27 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (orders.php,v 1.7 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
define('TEXT_BANK', '������ ������');
define('TEXT_BANK_OWNER', '�������� �����:');
define('TEXT_BANK_NUMBER', '����� �����:');
define('TEXT_BANK_BLZ', '��� �����:');
define('TEXT_BANK_NAME', '����:');
define('TEXT_BANK_FAX', 'Collect Authorization will be approved via Fax');
define('TEXT_BANK_STATUS', '�������� �������:');
define('TEXT_BANK_PRZ', '����� ��������:');

define('TEXT_BANK_ERROR_1', 'Accountnumber and Bank Code are not compatible!<br />Please try again!');
define('TEXT_BANK_ERROR_2', 'Sorry, we are unable to proof this account number!');
define('TEXT_BANK_ERROR_3', 'Account number not proofable! Method of Verify not implemented');
define('TEXT_BANK_ERROR_4', 'Account number technically not proofable!<br />Please try again!');
define('TEXT_BANK_ERROR_5', 'Bank Code not found!<br />Please try again.!');
define('TEXT_BANK_ERROR_8', 'No match for your Bank Code or Bank Code not given!');
define('TEXT_BANK_ERROR_9', 'No account number given!');
define('TEXT_BANK_ERRORCODE', '��� ������:');

define('HEADING_TITLE', '������ �������');
define('HEADING_TITLE_SEARCH', '����� �� ������ ������');
define('HEADING_TITLE_STATUS', '������:');

define('TABLE_HEADING_COMMENTS', '�����������');
define('TABLE_HEADING_CUSTOMERS', '�������');
define('TABLE_HEADING_ORDER_TOTAL', '����� ������');
define('TABLE_HEADING_DATE_PURCHASED', '���� �������');
define('TABLE_HEADING_STATUS', '���������');
define('TABLE_HEADING_ACTION', '��������');
define('TABLE_HEADING_QUANTITY', '����������');
define('TABLE_HEADING_PRODUCTS_MODEL', '��� ������');
define('TABLE_HEADING_PRODUCTS', '������');
define('TABLE_HEADING_TAX', '�����');
define('TABLE_HEADING_TOTAL', '�����');
define('TABLE_HEADING_STATUS', '������');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', '���� (�� ������� �����)');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', '����');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', '����� (�� ������� �����)');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', '�����');
define('TABLE_HEADING_AFTERBUY','Afterbuy');

define('TABLE_HEADING_STATUS', '������');
define('TABLE_HEADING_CUSTOMER_NOTIFIED', '������ ��������');
define('TABLE_HEADING_DATE_ADDED', '��������');

define('ENTRY_CUSTOMER', '������:');
define('ENTRY_SOLD_TO', '����������:');
define('ENTRY_STREET_ADDRESS', '�����:');
define('ENTRY_SUBURB', '�����:');
define('ENTRY_CITY', '�����:');
define('ENTRY_POST_CODE', '�������� ������:');
define('ENTRY_STATE', '������:');
define('ENTRY_COUNTRY', '������:');
define('ENTRY_TELEPHONE', '�������:');
define('ENTRY_EMAIL_ADDRESS', 'Email:');
define('ENTRY_DELIVERY_TO', '�����:');
define('ENTRY_SHIP_TO', '����� ��������:');
define('ENTRY_SHIPPING_ADDRESS', '����� ��������:');
define('ENTRY_BILLING_ADDRESS', '����� ����������:');
define('ENTRY_PAYMENT_METHOD', '������ ������:');
define('ENTRY_CREDIT_CARD_TYPE', '��� ��������� ��������:');
define('ENTRY_CREDIT_CARD_OWNER', '�������� ��������� ��������:');
define('ENTRY_CREDIT_CARD_NUMBER', '����� ��������� ��������:');
define('ENTRY_CREDIT_CARD_CVV', '��� (CVV)):');
define('ENTRY_CREDIT_CARD_EXPIRES', '�������� ������������� ��:');
define('ENTRY_SUB_TOTAL', '��������� ������:');
define('ENTRY_TAX', '�����:');
define('ENTRY_SHIPPING', '��������:');
define('ENTRY_TOTAL', '�����:');
define('ENTRY_DATE_PURCHASED', '���� �������:');
define('ENTRY_STATUS', '���������:');
define('ENTRY_DATE_LAST_UPDATED', '��������� ���������:');
define('ENTRY_NOTIFY_CUSTOMER', '��������� �������:'); 
define('ENTRY_NOTIFY_COMMENTS', '�������� �����������:');
define('ENTRY_PRINTABLE', '���������� ����');

define('TEXT_INFO_HEADING_DELETE_ORDER', '������� ����');
define('TEXT_INFO_DELETE_INTRO', '�� ������������� ������ ������� ���� �����?');
define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', '����������� ���������� ������ �� ������');
define('TEXT_DATE_ORDER_CREATED', '���� ��������:');
define('TEXT_DATE_ORDER_LAST_MODIFIED', '��������� ���������:');
define('TEXT_INFO_PAYMENT_METHOD', '������ ������:');

define('TEXT_ALL_ORDERS', '��� ������');
define('TEXT_NO_ORDER_HISTORY', '������� ������ �����������');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', '������ ������ ������ ������');
define('EMAIL_TEXT_ORDER_NUMBER', '����� ������:');
define('EMAIL_TEXT_INVOICE_URL', '���������� � ������:');
define('EMAIL_TEXT_DATE_ORDERED', '���� ������:');
define('EMAIL_TEXT_STATUS_UPDATE', '������ ������ ������ ������.' . "\n\n" . '����� ������: %s' . "\n\n" . '���� � ��� �������� �������, ������ ������� ��� �� � �������� ������.' . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', '����������� � ������ ������' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', '������: ����� �� ����������.');
define('SUCCESS_ORDER_UPDATED', '���������: ����� ������� �������.');
define('WARNING_ORDER_NOT_UPDATED', '��������: �������� ������. ����� �� �������.');

define('TABLE_HEADING_DISCOUNT','������');
define('ENTRY_CUSTOMERS_GROUP','������ ��������:');
define('ENTRY_CUSTOMERS_VAT_ID','VAT-ID:');
define('TEXT_VALIDATING','�� ��������');

// VaM ������

define('TEXT_NUMBER',', ����� ����� ');
define('TABLE_HEADING_NUMBER','�����');
define('TEXT_PRODUCTS',' ����� (��) ');

define('ENTRY_ORIGINAL_REFERER', '��������� �������:');
define('ENTRY_LOGIN_REFERER', '����� �������:');

?>