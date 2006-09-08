<?php
/*
  $Id: easypopulate.php,v 1.4 2004/09/21  zip1 Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 20042 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', '��������� ������ Excel ������/�������');
define('EASY_VERSION_A', 'Excel ������/������� ');
define('EASY_DEFAULT_LANGUAGE', '  -  ���� �� ��������� - ');
define('EASY_UPLOAD_FILE', '���� ��������. ');
define('EASY_UPLOAD_TEMP', '��� ���������� �����: ');
define('EASY_UPLOAD_USER_FILE', '��� ����� ������������: ');
define('EASY_SIZE', '������: ');
define('EASY_FILENAME', '��� �����: ');
define('EASY_SPLIT_DOWN', '�� ������ ������������� ���������� ����� �� ����� temp');
define('EASY_UPLOAD_EP_FILE', '������������� ����');
define('EASY_SPLIT_EP_FILE', '��������� � ��������� ���� �� �����');
define('EASY_INSERT', '�������������');
define('EASY_SPLIT', '���������');
define('EASY_LIMIT', '��������� ��������:');

define('TEXT_IMPORT_TEMP', '�������������� ������ �� ����� %s<br>');
define('TEXT_INSERT_INTO_DB', '�������������');
define('TEXT_SELECT_ONE', '�������� ���� ��� ��������������');
define('TEXT_SPLIT_FILE', '�������� ����');
define('EASY_LABEL_CREATE', '�������:');
define('EASY_LABEL_IMPORT', '������:');
define('EASY_LABEL_CREATE_SELECT', '������ ���������� ��������������� �����: ');
define('EASY_LABEL_CREATE_SAVE', '��������� � ����� temp �� �������');
define('EASY_LABEL_SELECT_DOWN', '�������� ���� ��� ��������: ');
define('EASY_LABEL_SORT', '�������� ������� ����������: ');
define('EASY_LABEL_PRODUCT_RANGE', '�������������� ������ � ID ������� ');
define('EASY_LABEL_LIMIT_CAT', '�������������� ������ �� ���������: ');
define('EASY_LABEL_LIMIT_MAN', '�������������� ������ �������������: ');

define('EASY_LABEL_PRODUCT_AVAIL', '��������� �������� ID �������: ');
define('EASY_LABEL_PRODUCT_FROM', ' �� ');
define('EASY_LABEL_PRODUCT_TO', ' �� ');
define('EASY_LABEL_PRODUCT_RECORDS', '����� �������: ');
define('EASY_LABEL_PRODUCT_BEGIN', '��: ');
define('EASY_LABEL_PRODUCT_END', '��: ');
define('EASY_LABEL_PRODUCT_START', '��������������');

define('EASY_FILE_LOCATE', '�� ������ ����� ��� ���� � ����� ');
define('EASY_FILE_LOCATE_2', '');
define('EASY_FILE_RETURN', ' �� ������ ���������, ����� �� ��� ������.');
define('EASY_IMPORT_TEMP_DIR', '������������� � ����� temp ');
define('EASY_LABEL_DOWNLOAD', '������� ����');
define('EASY_LABEL_COMPLETE', '��� ����');
define('EASY_LABEL_TAB', 'tab-delimited .txt file to edit');
define('EASY_LABEL_MPQ', '��� ������/����/����������');
define('EASY_LABEL_EP_MC', '��� ������/���������');
define('EASY_LABEL_EP_FROGGLE', '���� � ������� ��� ������� �����');
define('EASY_LABEL_EP_ATTRIB', '�������� ������');
define('EASY_LABEL_NONE', '���');
define('EASY_LABEL_CATEGORY', '�������� ������');
define('PULL_DOWN_MANUFACTURES', '��� �������������');
define('EASY_LABEL_PRODUCT', 'ID ����� ������');
define('EASY_LABEL_MANUFACTURE', 'ID ����� �������������');
define('EASY_LABEL_EP_FROGGLE_HEADER', '������� ���� � ������� ��� ����� ����');
define('EASY_LABEL_EP_MA', '��� ������/��������');
define('EASY_LABEL_EP_FR_TITLE', '������� ���� � ������� ��� ����� ���� � ����� temp ');
define('EASY_LABEL_EP_DOWN_TAB', 'Create <b>Complete</b> tab-delimited .txt file in temp dir');
define('EASY_LABEL_EP_DOWN_MPQ', 'Create <b>Model/Price/Qty</b> tab-delimited .txt file in temp dir');
define('EASY_LABEL_EP_DOWN_MC', 'Create <b>Model/Category</b> tab-delimited .txt file in temp dir');
define('EASY_LABEL_EP_DOWN_MA', 'Create <b>Model/Attributes</b> tab-delimited .txt file in temp dir');
define('EASY_LABEL_EP_DOWN_FROOGLE', 'Create <b>Froogle</b> tab-delimited .txt file in temp dir');

define('EASY_LABEL_NEW_PRODUCT', '<font color=blue> ����� ��������</font><br>');
define('EASY_LABEL_UPDATED', "<font color=green> ����� �������</font><br>");
define('EASY_LABEL_DELETE_STATUS_1', '<font color=red>�����</font><font color=black> ');
define('EASY_LABEL_DELETE_STATUS_2', ' </font><font color=red> �����!</font>');
define('EASY_LABEL_LINE_COUNT_1', '��������� ');
define('EASY_LABEL_LINE_COUNT_2', ' ������� � ���� ������... ');
define('EASY_LABEL_FILE_COUNT_1', '������� ���� EP_Split ');
define('EASY_LABEL_FILE_COUNT_2', '.txt ...  ');
define('EASY_LABEL_FILE_CLOSE_1', '��������� ');
define('EASY_LABEL_FILE_CLOSE_2', ' ������� � ���� ������...');
//errormessages
define('EASY_ERROR_1', '�������, �� ���� �� ��������� �� ����������... ������ ���������, ������ ��������������... ');
define('EASY_ERROR_2', '... ������! - ������� ����� �������� � ���� ��� ������.<br>
			12 �������� ��� ������������ ���������� � ����������� OsCommerce.<br>
			������������ ����� ���� product_model, ������������� � ���������� ������: ');
define('EASY_ERROR_2A', ' <br>�� ������ ���� ��������� ��� ������, ���� ��������� ����� ���� � ���� ������.</font>');
define('EASY_ERROR_2B',  "<font color='red'>");
define('EASY_ERROR_3', '<p class=smallText>�� ��������� ���� products_id. ������ ������ �� ���� �������������. <br><br>');
define('EASY_ERROR_4', '<font color=red>������! - v_customer_group_id and v_customer_price must occur in pairs</font>');
define('EASY_ERROR_5', '</b><font color=red>������! - You are trying to use a file created with EP Advanced, please try with Easy Populate Advanced </font>');
define('EASY_ERROR_5a', '<font color=red><b><u>  Click here to return to Easy Populate Basic </u></b></font>');
define('EASY_ERROR_6', '</b><font color=red>������! - You are trying to use a file created with EP Basic, please try with Easy Populate Basic </font>');
define('EASY_ERROR_6a', '<font color=red><b><u>  Click here to return to Easy Populate Advanced </u></b></font>');

define('EASY_LABEL_FILE_COUNT_1A', '������ ���� EPA_Split ');

?>
