<?php
/* --------------------------------------------------------------
   $Id: backup.php 899 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(backup.php,v 1.21 2002/06/15); www.oscommerce.com
   (c) 2003	 nextcommerce (backup.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2004	 xt:Commerce (backup.php,v 1.4 2003/08/14); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/

define('TEXT_DUMPER_SUBMIT', '���������');
define('TEXT_DUMPER_SEC', ' ���.');
define('TEXT_DUMPER_DIR_ERROR', '�� ������� ������� ������� ��� ������');
define('TEXT_DUMPER_DOWNLOAD', '������� ����');
define('TEXT_DUMPER_BACK', '���������');
define('TEXT_DUMPER_CREATE', '��������� ��������� ����� ��');
define('TEXT_DUMPER_NAME_ERROR', '������! �� ������� ���� ������!');
define('TEXT_DUMPER_CONNECT', '����������� � �� ');
define('TEXT_DUMPER_CONNECT_ERROR', '�� ������� ������� ���� ������.');
define('TEXT_DUMPER_CREATE_FILE', '�������� ����� � ��������� ������ ��:');
define('TEXT_DUMPER_CHARSET_ERROR', '�� ������� �������� ��������� ����������.');
define('TEXT_DUMPER_CHARSET', '����������� ��������� ���������� ');
define('TEXT_DUMPER_CHARSET_COLLATION', '��������� ���������� � ������� �� ���������:');
define('TEXT_DUMPER_TABLE', '������� ');
define('TEXT_DUMPER_CONNECT1', '���������� ');
define('TEXT_DUMPER_PROCESS', '��������� ������� ');
define('TEXT_DUMPER_MAKE', '��������� ����� �� ');
define('TEXT_DUMPER_MAKE1', ' �������.');
define('TEXT_DUMPER_SIZE', '������ ��:       ');
define('TEXT_DUMPER_MB', ' ��');
define('TEXT_DUMPER_FILE_SIZE', '������ �����: ');
define('TEXT_DUMPER_TABLES_COUNT', '������ ����������: ');
define('TEXT_DUMPER_STRING_COUNT', '����� ����������:   ');
define('TEXT_DUMPER_RESTORE', '�������������� �� �� ��������� �����');
define('TEXT_DUMPER_FILE_ERROR', '������! ���� �� ������!');
define('TEXT_DUMPER_FILE_READ', '������ ����� ');
define('TEXT_DUMPER_FILE_ERROR1', '������! �� ������ ����!');
define('TEXT_DUMPER_QUERY_ERROR', '������������ ������.');
define('TEXT_DUMPER_RESTORED', '�� ������������� �� ��������� �����.');
define('TEXT_DUMPER_DATE', '���� �������� �����: ');
define('TEXT_DUMPER_QUERY_COUNT', '�������� � ��: ');
define('TEXT_DUMPER_TABLES_CREATED', '������ �������: ');
define('TEXT_DUMPER_STRINGS_CREATED', '����� ���������: ');
define('TEXT_DUMPER_MAX', '9 (������������)');
define('TEXT_DUMPER_MED', '5 (�������)');
define('TEXT_DUMPER_MIN', '1 (�����������)');
define('TEXT_DUMPER_NO', '��� ������');

define('TEXT_DUMPER_BACKUP', '�������� ��������� ����� ��&nbsp;');
define('TEXT_DUMPER_DB', '��:');
define('TEXT_DUMPER_FILTER', '������ ������:');
define('TEXT_DUMPER_COMPRESS', '����� ������:');
define('TEXT_DUMPER_COMPRESS_LEVEL', '������� ������:');

define('TEXT_DUMPER_RESTORE_DB', '�������������� �� �� ��������� �����&nbsp;');
define('TEXT_DUMPER_FILE', '����:');

define('TEXT_DUMPER_TABLE_STATUS', '������ �������:');
define('TEXT_DUMPER_TOTAL_STATUS', '����� ������:');

define('TEXT_DUMPER_ERROR', '������');
define('TEXT_DUMPER_BROWSER_ERROR', '��� ������ Sypex Dumper Lite ���������:<br /> - Internet Explorer 5.5+, Mozilla ���� Opera 8+ (<span id=sie>-</span>)<br /> - �������� ���������� JavaScript �������� (<span id=sjs>-</span>)');

define('TEXT_DUMPER_LOGIN_HEADER', '������� ����� � ������');
define('TEXT_DUMPER_LOGIN', '�����:');
define('TEXT_DUMPER_PASSWORD', '������:');

define('TEXT_DUMPER_FORBIDDEN', '� ��� ��� ���� ��� ��������� ����� ��������');
define('TEXT_DUMPER_DB_CONNECT', '������ ��� ����������� � ��');
define('TEXT_DUMPER_DB_ERROR', '�������� ������!');

?>