<?php
/* --------------------------------------------------------------
   $Id: categories.php 1249 2006-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.22 2002/08/17); www.oscommerce.com
   (c) 2003	 nextcommerce (categories.php,v 1.10 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License
   --------------------------------------------------------------*/
 
define('TEXT_EDIT_STATUS', '������');
define('HEADING_TITLE', '��������� / ������');
define('HEADING_TITLE_SEARCH', '�����:');
define('HEADING_TITLE_GOTO', '������� �:');

define('TABLE_HEADING_ID', 'ID ���');
define('TABLE_HEADING_CATEGORIES_PRODUCTS', '��������� / ������');
define('TABLE_HEADING_ACTION', '��������');
define('TABLE_HEADING_STATUS', '������');
define('TABLE_HEADING_STARTPAGE', '���������� �� �������');
define('TABLE_HEADING_STOCK','���������� �� ������');
define('TABLE_HEADING_SORT','�������');
define('TABLE_HEADING_EDIT','�������� ��');

define('TEXT_ACTIVE_ELEMENT','�������� �������');
define('TEXT_INFORMATIONS','����������');
define('TEXT_MARKED_ELEMENTS','���������� ��������');
define('TEXT_INSERT_ELEMENT','����� �������');

define('TEXT_WARN_MAIN','��������');
define('TEXT_NEW_PRODUCT', '����� ����� � &quot;%s&quot;');
define('TEXT_CATEGORIES', '���������:');
define('TEXT_PRODUCTS', '������:');
define('TEXT_PRODUCTS_PRICE_INFO', '����:');
define('TEXT_PRODUCTS_TAX_CLASS', '����� �������:');
define('TEXT_PRODUCTS_AVERAGE_RATING', '������� �������:');
define('TEXT_PRODUCTS_QUANTITY_INFO', '����������:');
define('TEXT_PRODUCTS_DISCOUNT_ALLOWED_INFO', '������������ ������');
define('TEXT_DATE_ADDED', '���������:');
define('TEXT_DATE_AVAILABLE', '��������:');
define('TEXT_LAST_MODIFIED', '��������:');
define('TEXT_IMAGE_NONEXISTENT', '�������� �����������');
define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', '����������, �������� ��������� ��� ����� � <br />&nbsp;<br /><b>%s</b>');
define('TEXT_PRODUCT_MORE_INFORMATION', '��� ��������� �������������� ����������, ����������, �������� ��� <a href="http://%s" target="blank"><u>��������</u></a>.');
define('TEXT_PRODUCT_DATE_ADDED', '���� ����� �������� � ��� ������� %s.');
define('TEXT_PRODUCT_DATE_AVAILABLE', '���� ����� �������� � ������� %s.');
define('TEXT_CHOOSE_INFO_TEMPLATE', '������ �������� ������:');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE', '������ ��������� ������:');
define('TEXT_SELECT', '��������:');

define('TEXT_EDIT_INTRO', '����������, ������� ����������� ���������');
define('TEXT_EDIT_CATEGORIES_ID', 'ID ���������:');
define('TEXT_EDIT_CATEGORIES_NAME', '�������� ���������:');
define('TEXT_EDIT_CATEGORIES_HEADING_TITLE', '��������� ���������:');
define('TEXT_EDIT_CATEGORIES_DESCRIPTION', '�������� ���������:');
define('TEXT_EDIT_CATEGORIES_IMAGE', '�������� ���������:');

define('TEXT_EDIT_SORT_ORDER', '������� ����������:');

define('TEXT_INFO_COPY_TO_INTRO', '����������, �������� ����� ���������, � ������� �� ������� ����������� ���� �����');
define('TEXT_INFO_CURRENT_CATEGORIES', '������� ���������:');

define('TEXT_INFO_HEADING_NEW_CATEGORY', '����� ���������');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', '������������� ���������');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', '������� ���������');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', '��������� ���������');
define('TEXT_INFO_HEADING_DELETE_PRODUCT', '������� �����');
define('TEXT_INFO_HEADING_MOVE_PRODUCT', '����������� �����');
define('TEXT_INFO_HEADING_COPY_TO', '���������� �');
define('TEXT_INFO_HEADING_MOVE_ELEMENTS', '����������� ��������');
define('TEXT_INFO_HEADING_DELETE_ELEMENTS', '������� ��������');

define('TEXT_DELETE_CATEGORY_INTRO', '�� �������� ������� ��� ���������?');
define('TEXT_DELETE_PRODUCT_INTRO', '�������� ��������� �� ������� ���� ������� ������ �����. �� �������� �������� ������� ��� ������?');

define('TEXT_DELETE_WARNING_CHILDS', '<b>��������:</b> � ������ ��������� ������� %s ������������!');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>��������:</b> � ������ ��������� ������� %s �������!');

define('TEXT_MOVE_WARNING_CHILDS', '<b>����������:</b> � ������ ��������� ������� %s ������������!');
define('TEXT_MOVE_WARNING_PRODUCTS', '<b>����������:</b> � ������ ��������� ������� %s �������!');

define('TEXT_MOVE_PRODUCTS_INTRO', '�������� ���������, � ������� �� ������ ����������� <b>%s</b>');
define('TEXT_MOVE_CATEGORIES_INTRO', '�������� ���������, � ������� �� ������ ����������� <b>%s</b>');
define('TEXT_MOVE', '��������� <b>%s</b> �:');
define('TEXT_MOVE_ALL', '����������� �� �:');

define('TEXT_NEW_CATEGORY_INTRO', '������� ��� ����������� ���������� ��� ����� ���������.');
define('TEXT_CATEGORIES_NAME', '�������� ���������:');
define('TEXT_CATEGORIES_IMAGE', '�������� ���������:');

define('TEXT_META_TITLE', 'Meta Title:');
define('TEXT_META_DESCRIPTION', 'Meta Description:');
define('TEXT_META_KEYWORDS', 'Meta Keywords:');

define('TEXT_SORT_ORDER', '������� ����������:');

define('TEXT_PRODUCTS_STATUS', '������:');
define('TEXT_PRODUCTS_STARTPAGE', '�� ������� ��������:');
define('TEXT_PRODUCTS_STARTPAGE_YES', '��');
define('TEXT_PRODUCTS_STARTPAGE_NO', '���');
define('TEXT_PRODUCTS_STARTPAGE_SORT', '���������� (�� �������):');
define('TEXT_PRODUCTS_DATE_AVAILABLE', '���� �����������:');
define('TEXT_PRODUCT_AVAILABLE', '�������');
define('TEXT_PRODUCT_NOT_AVAILABLE', '���������');
define('TEXT_PRODUCTS_MANUFACTURER', '�������������:');
define('TEXT_PRODUCTS_NAME', '�������� ������:');
define('TEXT_PRODUCTS_DESCRIPTION', '�������� ������:');
define('TEXT_PRODUCTS_QUANTITY', '���������� ������:');
define('TEXT_PRODUCTS_MODEL', '��� ������:');
define('TEXT_PRODUCTS_IMAGE', '�������� ������');
define('TEXT_PRODUCTS_URL', 'URL ������:');
define('TEXT_PRODUCTS_URL_WITHOUT_HTTP', '(��� http://)');
define('TEXT_PRODUCTS_PRICE', '���� ������:');
define('TEXT_PRODUCTS_WEIGHT', '��� ������:');
define('TEXT_PRODUCTS_EAN','�����-���:');
define('TEXT_PRODUCT_LINKED_TO','���������� ��:');

define('TEXT_DELETE', '�������');

define('EMPTY_CATEGORY', '������ ���������');

define('TEXT_HOW_TO_COPY', '������ �����������:');
define('TEXT_COPY_AS_LINK', '������ �� �����');
define('TEXT_COPY_AS_DUPLICATE', '����� ������');

define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', '������: �� �� ������ ��������� ������ �� ����� � ��� �� ���������, ��� � ��� �����.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', '������: ���������� �������� ������� �� ������: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', '������: ���������� �������� �����������: ' . DIR_FS_CATALOG_IMAGES);

define('TEXT_PRODUCTS_DISCOUNT_ALLOWED','����������� ��������� ������:');
define('HEADING_PRICES_OPTIONS','<b>����</b>');
define('HEADING_PRODUCT_IMAGES','<b>�������� ������</b>');
define('TEXT_PRODUCTS_WEIGHT_INFO','<small>(��.)</small>');
define('TEXT_PRODUCTS_SHORT_DESCRIPTION','������� ��������:');
define('TEXT_PRODUCTS_KEYWORDS', '�������������� ����� ��� ������:');
define('TXT_STK','����������: ');
define('TXT_PRICE','����:');
define('TXT_NETTO','���� � �������: ');
define('TEXT_NETTO','�����: ');
define('TXT_STAFFELPREIS','���� �� ����������');

define('HEADING_PRODUCTS_MEDIA','<b>�������� ������</b>');
define('TABLE_HEADING_PRICE','����');

define('TEXT_CHOOSE_INFO_TEMPLATE','������ ���������� � ������');
define('TEXT_SELECT','--��������--');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE','������ ��������� ������');
define('SAVE_ENTRY','��������� ?');

define('TEXT_FSK18','����� �� 18 ���:');
define('TEXT_CHOOSE_INFO_TEMPLATE_CATEGORIE','������ ��� ������ ���������');
define('TEXT_CHOOSE_INFO_TEMPLATE_LISTING','������ ��� ������ �������');
define('TEXT_PRODUCTS_SORT','�������:');
define('TEXT_EDIT_PRODUCT_SORT_ORDER','���������� ������');
define('TXT_PRICES','����');
define('TXT_NAME','�������� ������');
define('TXT_ORDERED','���������� ���������� ������');
define('TXT_SORT','�������');
define('TXT_WEIGHT','���');
define('TXT_QTY','���������� �� ������');

define('TEXT_MULTICOPY','�������� �����������');
define('TEXT_MULTICOPY_DESC','���������� �������� � ��������� ��������� (���� �������, ��������� ���� ����� ������������.)');
define('TEXT_SINGLECOPY','����');
define('TEXT_SINGLECOPY_DESC','���������� �������� � ��������� ���������');
define('TEXT_SINGLECOPY_CATEGORY','���������:');

define('TEXT_PRODUCTS_VPE','�������: ');
define('TEXT_PRODUCTS_VPE_VISIBLE','���� �� �������: ');
define('TEXT_PRODUCTS_VPE_VALUE',' ��������: ');

define('CROSS_SELLING','������������� ������ ������');
define('CROSS_SELLING_SEARCH','����� ������:');
define('BUTTON_EDIT_CROSS_SELLING','������������� ������');
define('HEADING_DEL','�������');
define('HEADING_SORTING','�����������');
define('HEADING_MODEL','���');
define('HEADING_NAME','������');
define('HEADING_CATEGORY','���������');
define('HEADING_ADD','��������?');
define('HEADING_GROUP','������');

// ������ VaM

define('IMAGE_ICON_STATUS_GREEN', '�������');
define('IMAGE_ICON_STATUS_GREEN_STOCK', '������ �� ������');
define('IMAGE_ICON_STATUS_GREEN_LIGHT', '��������������');
define('IMAGE_ICON_STATUS_RED', '���������');
define('IMAGE_ICON_STATUS_RED_LIGHT', '������� ����������');
define('TABLE_HEADING_MAX_DISCOUNT', '����������� ��������� ������');

define('TEXT_PRODUCTS_IMAGE_UPLOAD_DIRECTORY', '���������� ��������:');
define('TEXT_PRODUCTS_IMAGE_GET_FILE', '������������ ����������� ����:');
define('TEXT_STANDART_IMAGE', '��������');
define('TEXT_SELECT_DIRECTORY', '-- �������� ������������� --');
define('TEXT_SELECT_IMAGE', '-- �������� ���� --');

define('TABLE_HEADING_XML', 'XML');
define('TEXT_PRODUCTS_TO_XML', '������-������:');
define('TEXT_PRODUCT_AVAILABLE_TO_XML', '��������');
define('TEXT_PRODUCT_NOT_AVAILABLE_TO_XML', '�� ��������');

define('TEXT_EDIT','[�������������]');
define('TEXT_PRODUCTS_DATA','�������������');
define('TEXT_TAB_CATEGORIES_IMAGE', '�������� ���������');

?>