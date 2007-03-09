<?php
/* --------------------------------------------------------------
   $Id: articles_config.php 1125 2007-03-09 11:13:01Z VaM $   

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

define('HEADING_TITLE', '��������� ������ ������');

define('TABLE_HEADING_CONFIGURATION_TITLE', '�����');
define('TABLE_HEADING_CONFIGURATION_VALUE', '��������');
define('TABLE_HEADING_ACTION', '��������');

define('TEXT_INFO_EDIT_INTRO', '������� ����������� ���������');
define('TEXT_INFO_DATE_ADDED', '���� ����������:');
define('TEXT_INFO_LAST_MODIFIED', '��������� ���������:');

// ������ - ��������� 

define('DISPLAY_NEW_ARTICLES_TITLE', '���������� ������ ����� ������');
define('NEW_ARTICLES_DAYS_DISPLAY_TITLE', '���������� ����, � ������� ������� ������ ��������� �����');
define('MAX_NEW_ARTICLES_PER_PAGE_TITLE', '���������� ������ �� ����� �������� ����� ������');
define('DISPLAY_ALL_ARTICLES_TITLE', '���������� ������ ��� ������');
define('MAX_ARTICLES_PER_PAGE_TITLE', '���������� ������ �� ����� ��������');
define('MAX_DISPLAY_UPCOMING_ARTICLES_TITLE', '������������ ���������� ����������� � ���������� ������');
define('ENABLE_ARTICLE_REVIEWS_TITLE', '��������� ������ � �������');
define('ENABLE_TELL_A_FRIEND_ARTICLE_TITLE', '��������� ������� ���������� ���������');
define('MIN_DISPLAY_ARTICLES_XSELL_TITLE', '����������� ���������� ������, ���������� � ����� ��������� ������');
define('MAX_DISPLAY_ARTICLES_XSELL_TITLE', '������������ ���������� ������, ���������� � ����� ��������� ������');
define('SHOW_ARTICLE_COUNTS_TITLE', '���������� ������� ������');
define('MAX_DISPLAY_AUTHOR_NAME_LEN_TITLE', '������������ ����� ���� �����');
define('MAX_DISPLAY_AUTHORS_IN_A_LIST_TITLE', '������ ������ ������ �������');
define('MAX_AUTHORS_LIST_TITLE', '������ � ���� ����������� ����');
define('DISPLAY_AUTHOR_ARTICLE_LISTING_TITLE', '���������� ������ � ������ ������');
define('DISPLAY_TOPIC_ARTICLE_LISTING_TITLE', '���������� ������ � ������ ������');
define('DISPLAY_ABSTRACT_ARTICLE_LISTING_TITLE', '���������� Meta Description � ������ ������');
define('DISPLAY_DATE_ADDED_ARTICLE_LISTING_TITLE', '���������� ���� ���������� � ������ ������');
define('MAX_ARTICLE_ABSTRACT_LENGTH_TITLE', '������������ ����� ���� Meta Description');
define('ARTICLE_LIST_FILTER_TITLE', '���������� ������ ������/������');
define('ARTICLE_PREV_NEXT_BAR_LOCATION_TITLE', '������������ ��������� ���������/���������� ��������');
define('ARTICLE_WYSIWYG_ENABLE_TITLE', '������������ HTML �������� ��� ��������� ������?');
define('ARTICLE_MANAGER_WYSIWYG_BASIC_TITLE', '����������� HTML ���������');
define('ARTICLE_MANAGER_WYSIWYG_WIDTH_TITLE', '������ HTML ���������');
define('ARTICLE_MANAGER_WYSIWYG_HEIGHT_TITLE', '������ HTML ���������');
define('ARTICLE_MANAGER_WYSIWYG_FONT_TYPE_TITLE', '�����, ������������ � ���������� HTML ���������');
define('ARTICLE_MANAGER_WYSIWYG_FONT_SIZE_TITLE', '������ ������, ������������� � ���������� HTML ���������');
define('ARTICLE_MANAGER_WYSIWYG_FONT_COLOUR_TITLE', '���� ������, ������������� � ���������� HTML ���������');
define('ARTICLE_MANAGER_WYSIWYG_BG_COLOUR_TITLE', '���� ���� � ���������� HTML ���������');
define('ARTICLE_MANAGER_WYSIWYG_DEBUG_TITLE', '��������� ����� �������?');

define('DISPLAY_NEW_ARTICLES_DESC', '���������� ������ ����� ������ � ����� ������?');
define('NEW_ARTICLES_DAYS_DISPLAY_DESC', '����� ���������� ���� ����� ����������, ������ ��������� ����� � ������������ �� �������� ����� ������.');
define('MAX_NEW_ARTICLES_PER_PAGE_DESC', '������������ ���������� ������, ��������� �� ����� �������� ����� ������.');
define('DISPLAY_ALL_ARTICLES_DESC', '���������� ������ ��� ������ � ����� ������?');
define('MAX_ARTICLES_PER_PAGE_DESC', '������������ ���������� ������, ��������� �� ����� ��������.');
define('MAX_DISPLAY_UPCOMING_ARTICLES_DESC', '������������ ���������� ������, ��������� � ����� ��������� � ����������');
define('ENABLE_ARTICLE_REVIEWS_DESC', '��������� ����������� ��������� ���� ������ � �������.');
define('ENABLE_TELL_A_FRIEND_ARTICLE_DESC', '��������� ����������� ����������� ������� ���������� ���������.');
define('MIN_DISPLAY_ARTICLES_XSELL_DESC', '����������� ���������� ������, ���������� � ����� ��������� ������.');
define('MAX_DISPLAY_ARTICLES_XSELL_DESC', '������������ ���������� ������, ���������� � ����� ��������� ������.');
define('SHOW_ARTICLE_COUNTS_DESC', '���������� ���������� ������ � ������ �������.');
define('MAX_DISPLAY_AUTHOR_NAME_LEN_DESC', '������������ ���������� ��������, ��������� � ����� ������.');
define('MAX_DISPLAY_AUTHORS_IN_A_LIST_DESC', '���� ����� ������� ������ ��������� �����, ����� � ����� ������ ��������� ������� ������, ���� ����� ������� ������ ��������� �����, ����� ��������� drop-down ������ �������.');
define('MAX_AUTHORS_LIST_DESC', '������ ����� ������������ ��� ��������� ����� ������, ���� ������� ����� 1, �� ������ ������� ��������� � ���� ������������ drop-down ������. ���� ������� ����� ������ �����, �� ��������� ������ X �������������� � ���� ����������� ����.');
define('DISPLAY_AUTHOR_ARTICLE_LISTING_DESC', '���������� ������ � ������ ������?');
define('DISPLAY_TOPIC_ARTICLE_LISTING_DESC', '���������� ������ � ������ ������?');
define('DISPLAY_ABSTRACT_ARTICLE_LISTING_DESC', '���������� Meta Description � ������ ������?');
define('DISPLAY_DATE_ADDED_ARTICLE_LISTING_DESC', '���������� ���� ���������� � ������ ������?');
define('MAX_ARTICLE_ABSTRACT_LENGTH_DESC', '������������ ���������� �������� ���� Meta Description.');
define('ARTICLE_LIST_FILTER_DESC', '���������� ������ ������/������?');
define('ARTICLE_PREV_NEXT_BAR_LOCATION_DESC', '������������ ��������� ���������/���������� ��������<br><br>top - ����<br>bottom - ���<br>both - (����+���)');
define('ARTICLE_WYSIWYG_ENABLE_DESC', '������������ HTML �������� ��� ��������� ������?');
define('ARTICLE_MANAGER_WYSIWYG_BASIC_DESC', 'Basic - ������� HTML �������� � ����������� ����������� ������������.<br>Advanced - ����������� HTML ��������, ������������ ���������� ������������.');
define('ARTICLE_MANAGER_WYSIWYG_WIDTH_DESC', '������ HTML ��������� � �������� (�� ���������: 605)');
define('ARTICLE_MANAGER_WYSIWYG_HEIGHT_DESC', '������ HTML ��������� � �������� (�� ���������: 300)');
define('ARTICLE_MANAGER_WYSIWYG_FONT_TYPE_DESC', '����� ���������� HTML ���������, ����� �� ������� � ���� �������, ������� �� ������ ������� � ������� HTML ���������.');
define('ARTICLE_MANAGER_WYSIWYG_FONT_SIZE_DESC', '������ ������ ���������� HTML ���������, ����� �� ������� � ���� �������, ������� �� ������ ������� � ������� HTML ���������.');
define('ARTICLE_MANAGER_WYSIWYG_FONT_COLOUR_DESC', '���� ������ ���������� HTML ���������, ����� �� ������� � ���� �������, ������� �� ������ ������� � ������� HTML ���������. �� ������ ������� ���� ��� �����, �������� #FFFFFF, ���� �������� �����, �������� black.');
define('ARTICLE_MANAGER_WYSIWYG_BG_COLOUR_DESC', '���� ���� ���������� HTML ���������, ����� �� ������� � ���� �������, ������� �� ������ ������� � ������� HTML ���������. �� ������ ������� ���� ��� �����, �������� #FFFFFF, ���� �������� �����, �������� black.');
define('ARTICLE_MANAGER_WYSIWYG_DEBUG_DESC', '������� �� ������������ HTML-�����, �.�. �� ������ ������, ����� HTML-��� �������� ��� ������������� HTML ���������.<br><br>0 - ���������.<br>1 - ��������<br>�� ��������� ����� 0');

?>