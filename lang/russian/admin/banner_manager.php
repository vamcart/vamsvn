<?php
/* --------------------------------------------------------------
   $Id: banner_manager.php 899 2006-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner_manager.php,v 1.25 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (banner_manager.php,v 1.4 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', '�������� ��������');

define('TABLE_HEADING_BANNERS', '�������');
define('TABLE_HEADING_GROUPS', '������');
define('TABLE_HEADING_STATISTICS', '������ / �����');
define('TABLE_HEADING_STATUS', '������');
define('TABLE_HEADING_ACTION', '��������');

define('TEXT_BANNERS_TITLE', '�������� �������:');
define('TEXT_BANNERS_URL', 'URL �������:');
define('TEXT_BANNERS_GROUP', '������ �������:');
define('TEXT_BANNERS_NEW_GROUP', ', �������� ������ ��� �������� ����� ����');
define('TEXT_BANNERS_IMAGE', '������:');
define('TEXT_BANNERS_IMAGE_LOCAL', ', ��� ������� ��������� ���� ����');
define('TEXT_BANNERS_IMAGE_TARGET', '������ (��������� ���):');
define('TEXT_BANNERS_HTML_TEXT', 'HTML ���:');
define('TEXT_BANNERS_EXPIRES_ON', '������ ������������ ��:');
define('TEXT_BANNERS_OR_AT', ', ��� �����');
define('TEXT_BANNERS_IMPRESSIONS', '�������/������.');
define('TEXT_BANNERS_SCHEDULED_AT', '������ ������������ �:');
define('TEXT_BANNERS_BANNER_NOTE', '<b>����������:</b><ul><li>����������� ��� ������� ������ ����������� ��� HTML ���, �� �� ������������ ��� �������.</li><li>HTML ��� ����� ��������� ��� ������������</li></ul>');
define('TEXT_BANNERS_INSERT_NOTE', '<b>���������� � �������� �������:</b><ul><li>����������, � ������� ����������� ������� ������ ����� ��������������� ����� �������!</li><li>�� ���������� ������� \'��������� ���\' ���� �� �� ���������� ����������� �� ������ (�.�., �� ����������� ������ � ���������� �����).</li><li>����������, ��������� � ���� \'��������� ���\' ������ ���� ������� �� ������� � ������ ������������� ����� ������ (��������, banners/).</li></ul>');
define('TEXT_BANNERS_EXPIRCY_NOTE', '<b>���������� � ������ �������:</b><ul><li>������ ���� �� ����� "������ ������������ ��" ��� "������ ������������ �" ������ ���� ���������, �.�. 2 ���� ������������ ��������� ���� �� �����</li><li>���� ������ ������ ������������ ���������, ������ �������� ��� ���� �������</li></ul>');
define('TEXT_BANNERS_SCHEDULE_NOTE', '<b>���������� � ���� "������ ������������ �":</b><ul><li>���� �� ���������� ���� � ���� ����, �� ������ ����� ������������ � ��� ����, ������� �� �������.</li><li>��� �������, � ������� ��������� ���� "������ ������������ �" �� ��������� ���������, ����� ���� ��� �������� ��������� ����, ������ ����� �������.</li></ul>');

define('TEXT_BANNERS_DATE_ADDED', '���� ����������:');
define('TEXT_BANNERS_SCHEDULED_AT_DATE', '����� ������� �: <b>%s</b>');
define('TEXT_BANNERS_EXPIRES_AT_DATE', '������������ ��: <b>%s</b>');
define('TEXT_BANNERS_EXPIRES_AT_IMPRESSIONS', '��������: <b>%s</b> �������');
define('TEXT_BANNERS_STATUS_CHANGE', '��������� �������: %s');

define('TEXT_BANNERS_DATA', '�<br>�<br>�<br>�');
define('TEXT_BANNERS_LAST_3_DAYS', '��������� 3 ���');
define('TEXT_BANNERS_BANNER_VIEWS', '������');
define('TEXT_BANNERS_BANNER_CLICKS', '�����');

define('TEXT_INFO_DELETE_INTRO', '�� ������������� ������ ������� ���� ������?');
define('TEXT_INFO_DELETE_IMAGE', '������� ������');

define('SUCCESS_BANNER_INSERTED', '���������: ������ ��������.');
define('SUCCESS_BANNER_UPDATED', '���������: ������ ������.');
define('SUCCESS_BANNER_REMOVED', '���������: ������ �����.');
define('SUCCESS_BANNER_STATUS_UPDATED', '���������: ������ ������� ������.');

define('ERROR_BANNER_TITLE_REQUIRED', '������: ������� �������� �������.');
define('ERROR_BANNER_GROUP_REQUIRED', '������: ������� ������ �������.');
define('ERROR_IMAGE_DIRECTORY_DOES_NOT_EXIST', '������: ��������� ���������� �����������: %s');
define('ERROR_IMAGE_DIRECTORY_NOT_WRITEABLE', '������: ���������� ����� �������� ����� �������: %s');
define('ERROR_IMAGE_DOES_NOT_EXIST', '������: ������ �����������.');
define('ERROR_IMAGE_IS_NOT_WRITEABLE', '������: ������ �� ����� ���� �����.');
define('ERROR_UNKNOWN_STATUS_FLAG', '������: ����������� ������.');

define('ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST', '������: ���������� ��� �������� �����������. �������� ������������� \'graphs\' � ���������� \'images\'.');
define('ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE', '������: ���������� ����� �������� ����� �������.');
?>