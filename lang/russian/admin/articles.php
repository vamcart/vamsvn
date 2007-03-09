<?php
/* --------------------------------------------------------------
   $Id: articles.php 1125 2007-03-09 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.40 2002/12/29); www.oscommerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', '������� / ������');
define('HEADING_TITLE_SEARCH', '�����:');
define('HEADING_TITLE_GOTO', '�������:');

define('TABLE_HEADING_ID', 'ID');
define('TABLE_HEADING_TOPICS_ARTICLES', '������� / ������');
define('TABLE_HEADING_ACTION', '��������');
define('TABLE_HEADING_STATUS', '������');

define('TEXT_ARTICLES_CURRENT', '������� ������:');

define('TEXT_NEW_ARTICLE', '���������� ����� ������ � ������ &quot;%s&quot;');
define('TEXT_TOPICS', '�������:');
define('TEXT_SUBTOPICS', '����������:');
define('TEXT_ARTICLES', '������:');
define('TEXT_ARTICLES_AVERAGE_RATING', '������� �������:');
define('TEXT_ARTICLES_HEAD_TITLE_TAG', 'Meta Title:');
define('TEXT_ARTICLES_HEAD_DESC_TAG', 'Meta Description:<br><small>(�� ������ %s ��������)</small>');
define('TEXT_ARTICLES_HEAD_KEYWORDS_TAG', 'Meta Keywords:');
define('TEXT_DATE_ADDED', '���� ����������:');
define('TEXT_DATE_AVAILABLE', '�������� �:');
define('TEXT_LAST_MODIFIED', '��������� ���������:');
define('TEXT_NO_CHILD_TOPICS_OR_ARTICLES', '�������� ������ ��� ������.');
define('TEXT_ARTICLE_MORE_INFORMATION', '����� ������ ������, ������� <a href="http://%s" target="blank"><u>����</u></a>.');
define('TEXT_ARTICLE_DATE_ADDED', '������ ���� ��������� %s.');
define('TEXT_ARTICLE_DATE_AVAILABLE', '������ ����� �������� � %s.');

define('TEXT_EDIT_INTRO', '������� ����������� ���������');
define('TEXT_EDIT_TOPICS_ID', 'ID:');
define('TEXT_EDIT_TOPICS_NAME', '�������� �������:');
define('TEXT_EDIT_SORT_ORDER', '������� ����������:');

define('TEXT_INFO_COPY_TO_INTRO', '�������� ������, � ������� �� ������ ����������� ������');
define('TEXT_INFO_CURRENT_TOPICS', '������� �������:');

define('TEXT_INFO_HEADING_NEW_TOPIC', '����� ������');
define('TEXT_INFO_HEADING_EDIT_TOPIC', '������������� ������');
define('TEXT_INFO_HEADING_DELETE_TOPIC', '������� ������');
define('TEXT_INFO_HEADING_MOVE_TOPIC', '����������� ������');
define('TEXT_INFO_HEADING_DELETE_ARTICLE', '������� ������');
define('TEXT_INFO_HEADING_MOVE_ARTICLE', '����������� ������');
define('TEXT_INFO_HEADING_COPY_TO', '���������� �');

define('TEXT_DELETE_TOPIC_INTRO', '�� ������������� ������ ������� ������ ������?');
define('TEXT_DELETE_ARTICLE_INTRO', '�� ������������� ������ ������� ������ ������?');

define('TEXT_DELETE_WARNING_CHILDS', '<b>��������:</b> � ������ ������� ��������� %s �����������!');
define('TEXT_DELETE_WARNING_ARTICLES', '<b>��������:</b> � ������ ������� ��������� %s ������!');

define('TEXT_MOVE_ARTICLES_INTRO', '�������� ������, � ������� �� ������ ����������� ������ <b>%s</b>');
define('TEXT_MOVE_TOPICS_INTRO', '�������� ������, � ������� �� ������ ����������� ������ <b>%s</b>');
define('TEXT_MOVE', '����������� <b>%s</b> �:');

define('TEXT_NEW_TOPIC_INTRO', '��������� ������ �����, ����� �������� ����� ������');
define('TEXT_TOPICS_NAME', '�������� �������:');
define('TEXT_SORT_ORDER', '������� ����������:');

define('TEXT_EDIT_TOPICS_HEADING_TITLE', '�������� ������� ��������:');
define('TEXT_EDIT_TOPICS_DESCRIPTION', '�������� �������:');

define('TEXT_ARTICLES_STATUS', '������:');
define('TEXT_ARTICLES_DATE_AVAILABLE', '�������� �:');
define('TEXT_ARTICLE_AVAILABLE', '�������');
define('TEXT_ARTICLE_NOT_AVAILABLE', '�� �������');
define('TEXT_ARTICLES_AUTHOR', '�����:');
define('TEXT_ARTICLES_NAME', '�������� ������:');
define('TEXT_ARTICLES_DESCRIPTION', '����� ������:');
define('TEXT_ARTICLES_URL', 'URL �����:');
define('TEXT_ARTICLES_URL_WITHOUT_HTTP', '<small>(��� http://)</small>');

define('EMPTY_TOPIC', '������ ����.');

define('TEXT_HOW_TO_COPY', '������ �����������:');
define('TEXT_COPY_AS_LINK', '������');
define('TEXT_COPY_AS_DUPLICATE', '�����������');

define('ERROR_CANNOT_LINK_TO_SAME_TOPIC', '������: ������ ��������� ������ �� ������ � ��� �� �������, ��� ��������� ������.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', '������: ������� �������� ������� �� ������. ���������� ����� ������� �� ������ ��� ������� ��������: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', '������: ������� �������� �����������: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CANNOT_MOVE_TOPIC_TO_PARENT', '������: ������ �� ����� ���� ��������� � ���������.');

define('BUTTON_NEW_TOPIC','�������� ���������');
define('BUTTON_NEW_ARTICLE','�������� ������');
define('BUTTON_COPY_TO', '���������� �');

?>