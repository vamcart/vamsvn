<?php
/* -----------------------------------------------------------------------------------------
   $Id: configuration.php 1286 2006-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.8 2002/01/04); www.oscommerce.com
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/25); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('TABLE_HEADING_CONFIGURATION_TITLE', '��������');
define('TABLE_HEADING_CONFIGURATION_VALUE', '��������');
define('TABLE_HEADING_ACTION', '��������');

define('TEXT_INFO_EDIT_INTRO', '����������, ������� ����������� ���������');
define('TEXT_INFO_DATE_ADDED', '���� ����������:');
define('TEXT_INFO_LAST_MODIFIED', '��������� ���������:');

// language definitions for config
define('STORE_NAME_TITLE' , '�������� ��������');
define('STORE_NAME_DESC' , '�������� ������ ��������');
define('STORE_OWNER_TITLE' , '��������');
define('STORE_OWNER_DESC' , '�������� ��������-��������');
define('STORE_OWNER_EMAIL_ADDRESS_TITLE' , 'Email �����');
define('STORE_OWNER_EMAIL_ADDRESS_DESC' , 'Email ����� ��������� ��������');

define('EMAIL_FROM_TITLE' , 'E-Mail ��');
define('EMAIL_FROM_DESC' , 'E-mail � ������������ �� �������� �������.');

define('STORE_COUNTRY_TITLE' , '������');
define('STORE_COUNTRY_DESC' , '��������������� ��������.<br /><br /><b>���������: �� �������� ������� ������.</b>');
define('STORE_ZONE_TITLE' , '������');
define('STORE_ZONE_DESC' , '������ ��������.');

define('EXPECTED_PRODUCTS_SORT_TITLE' , '������� ���������� ��������� �������');
define('EXPECTED_PRODUCTS_SORT_DESC' , '������� ������� ���������� ��� ��������� �������, �� ����������� - asc ��� �� �������� - desc.');
define('EXPECTED_PRODUCTS_FIELD_TITLE' , '���������� ��������� �������');
define('EXPECTED_PRODUCTS_FIELD_DESC' , '�� ������ �������� ����� ������������� ��������� ������.');

define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE' , '������������ �� ������ �������� �����');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC' , '�������������� ������������ ��� � �������� �� ������ �������� �����.');

define('SEND_EXTRA_ORDER_EMAILS_TO_TITLE' , '�������� ����� ����� � �������:');
define('SEND_EXTRA_ORDER_EMAILS_TO_DESC' , '���� �� ������ �������� ������ � ��������, �.�. ����� �� ������, ��� � �������� ������ ����� ���������� ������, ������� e-mail ����� ��� ��������� ����� ����� � ��������� �������: ��� 1 &lt;email@address1&gt;, ��� 2 &lt;email@address2&gt;');

define('SEARCH_ENGINE_FRIENDLY_URLS_TITLE' , '������������ �������� URL ������');
define('SEARCH_ENGINE_FRIENDLY_URLS_DESC' , '������������ �������� URL ������ � ��������');

define('DISPLAY_CART_TITLE' , '���������� � ������� ����� ���������� ������');
define('DISPLAY_CART_DESC' , '���������� � ������� ����� ���������� ������ � ������� ��� ���������� �� ��� �� ��������.');

define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE' , '��������� ������ ������������ ������� ���������� �����');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC' , '��������� ������ ������������ ������� �������� ���������� �����, ���� ���, �� ������ �������� ����� ������������ ������ ������������������ ������������ ��������.');

define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE' , '�������� ������ �� ���������');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC' , '�������, ����� �������� ����� �������������� �� ��������� ��� ������������� ����������� ������ � ��������.');

define('STORE_NAME_ADDRESS_TITLE' , '����� � ������� ��������');
define('STORE_NAME_ADDRESS_DESC' , '����� �� ������ ������� ����� � ������� ��������.');

define('SHOW_COUNTS_TITLE' , '���������� ������� �������');
define('SHOW_COUNTS_DESC' , '���������� ���������� ������ � ������ ���������. ��� ������� ���������� ������ � �������� ������������� ��������� ������� - false, ����� ������� �������� �� MySQL ������, ��� ����� �������� �������� �������� ������ �������� ����������.');

define('DISPLAY_PRICE_WITH_TAX_TITLE' , '���������� ���� � ��������');
define('DISPLAY_PRICE_WITH_TAX_DESC' , '���������� ���� � �������� � �������� (true) ��� ���������� ����� ������ �� �������������� ����� ���������� ������ (false)');

define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_TITLE' , '������ ����� �� �������������');
define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_DESC' , '�������� ������ ����� �� ������� �������������!');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_TITLE' , '������ ���������� ����������');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_DESC' , '����� ����� �� ��������� ������ ���������� ����� ������������');
define('DEFAULT_CUSTOMERS_STATUS_ID_TITLE' , '������ ���������� ��� ����������');
define('DEFAULT_CUSTOMERS_STATUS_ID_DESC' , '����� ����� �� ��������� ������ ���������� ����� �����������');

define('ALLOW_ADD_TO_CART_TITLE' , '��������� ��������� � �������');
define('ALLOW_ADD_TO_CART_DESC' , '��������� ���������� ��������� ����� � ������� ���� ��� ������ &quot;���������� ����&quot; ��������� � 0');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_TITLE' , '��������� ������ �� �������� ������');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_DESC' , '��������� ���������� �������� ������ �� ����� � ���������� (���� �������� ����� �� ��������� � ������� &quot;����. ����&quot;)');
define('CURRENT_TEMPLATE_TITLE' , '�������');
define('CURRENT_TEMPLATE_DESC' , '�������� ������ �� ���������. ������� ��������� � ����� /templates');

define('CC_KEYCHAIN_TITLE','���������� ������ ��������� �����');
define('CC_KEYCHAIN_DESC','������ ��� ���������� ������ ��������� ����� (����������, ��������!)');

define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE' , '���');
define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC', '����������� ���������� �������� ���� ���');
define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE' , '�������');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC', '����������� ���������� �������� ���� �������');
define('ENTRY_DOB_MIN_LENGTH_TITLE' , '���� ��������');
define('ENTRY_DOB_MIN_LENGTH_DESC', '����������� ���������� �������� ���� ���� ��������');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE' , 'E-Mail �����');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC', '����������� ���������� �������� ���� E-Mail �����');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE' , '�����');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC', '����������� ���������� �������� ���� �����');
define('ENTRY_COMPANY_MIN_LENGTH_TITLE' , '��������');
define('ENTRY_COMPANY_MIN_LENGTH_DESC', '����������� ���������� �������� ���� ��������');
define('ENTRY_POSTCODE_MIN_LENGTH_TITLE' , '�������� ������');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC', '����������� ���������� �������� ���� �������� ������');
define('ENTRY_CITY_MIN_LENGTH_TITLE' , '�����');
define('ENTRY_CITY_MIN_LENGTH_DESC', '����������� ���������� �������� ���� �����');
define('ENTRY_STATE_MIN_LENGTH_TITLE' , '������');
define('ENTRY_STATE_MIN_LENGTH_DESC', '����������� ���������� �������� ���� ������');
define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE' , '�������');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC', '����������� ���������� �������� ���� �������');
define('ENTRY_PASSWORD_MIN_LENGTH_TITLE' , '������');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC', '����������� ���������� �������� ���� ������');

define('CC_OWNER_MIN_LENGTH_TITLE' , '�������� ��������� ��������');
define('CC_NUMBER_MIN_LENGTH_TITLE' , '����� ��������� ��������');
define('CC_OWNER_MIN_LENGTH_DESC', '����������� ���������� �������� ���� �������� ��������� ��������');
define('CC_NUMBER_MIN_LENGTH_DESC', '����������� ���������� �������� ���� ����� ��������� ��������');

define('REVIEW_TEXT_MIN_LENGTH_TITLE' , '����� ������');
define('REVIEW_TEXT_MIN_LENGTH_DESC', '����������� ���������� �������� ��� ������');

define('MIN_DISPLAY_BESTSELLERS_TITLE' , '������ ������');
define('MIN_DISPLAY_BESTSELLERS_DESC', '����������� ���������� ������, ���������� � ����� ������ ������');
define('MIN_DISPLAY_ALSO_PURCHASED_TITLE' , '����� ��������');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC', '����������� ���������� ������, ���������� � ����� ����� ��������');

define('MAX_ADDRESS_BOOK_ENTRIES_TITLE' , '������ � �������� �����');
define('MAX_ADDRESS_BOOK_ENTRIES_DESC', '������������ ���������� �������, ������� ����� ������� ���������� � ����� �������� �����');
define('MAX_DISPLAY_SEARCH_RESULTS_TITLE' , '������� �� ����� �������� � ��������');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC', '���������� ������, ���������� �� ����� ��������');
define('MAX_DISPLAY_PAGE_LINKS_TITLE' , '������ �� ��������');
define('MAX_DISPLAY_PAGE_LINKS_DESC', '���������� ������ �� ������ ��������');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE' , '����������� ����');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC', '������������ ���������� ������, ���������� �� �������� ������');
define('MAX_DISPLAY_NEW_PRODUCTS_TITLE' , '�������');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC', '������������ ���������� ������, ��������� � ����� �������');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE' , '��������� ������');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC', '������������ ���������� ������, ���������� � ����� ��������� ������');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE' , '������ ��������������');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC', '������ ����� ������������ ��� ��������� ����� ��������������, ���� ����� �������������� ��������� ��������� � ������ �����, ������ �������������� ����� ���������� � ���� drop-down ������, ���� ����� �������������� ������ ���������� � ������ �����, ������������� ����� ���������� � ���� ������.');
define('MAX_MANUFACTURERS_LIST_TITLE' , '������������� � ���� ����������� ����');
define('MAX_MANUFACTURERS_LIST_DESC', '������ ����� ������������ ��� ��������� ����� ��������������, ���� ������� ����� \'1\', �� ������ �������������� ��������� � ���� ������������ drop-down ������. ���� ������� ����� ������ �����, �� ��������� ������ X �������������� � ���� ����������� ����.');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE' , '����������� ����� �������� �������������');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC', '������ ����� ������������ ��� ��������� ����� ��������������, �� ���������� ���������� ��������, ���������� � ����� ��������������, ���� �������� ������������� ����� �������� �� �������� ���������� ��������, �� ����� �������� ������ X �������� ��������');
define('MAX_DISPLAY_NEW_REVIEWS_TITLE' , '����� ������');
define('MAX_DISPLAY_NEW_REVIEWS_DESC', '������������ ���������� ��������� ����� �������');
define('MAX_RANDOM_SELECT_REVIEWS_TITLE' , '����� ��������� �������');
define('MAX_RANDOM_SELECT_REVIEWS_DESC', '���������� �������, ������� ����� �������������� ��� ������ ����������, �.�. ���� ������� X - ����� �������, �� ��������� ����� ����� ������ �� ���� X �������');
define('MAX_RANDOM_SELECT_NEW_TITLE' , '����� ���������� ������ � ����� �������');
define('MAX_RANDOM_SELECT_NEW_DESC', '���������� ������, ����� �������� ����� ������ ��������� ����� � ������� � ���� �������, �.�. ���� ������� ����� X, �� ����� �����, ������� ����� ������� � ����� ������� ����� ������ �� ���� X ����� �������');
define('MAX_RANDOM_SELECT_SPECIALS_TITLE' , '����� ���������� ������ � ����� ������');
define('MAX_RANDOM_SELECT_SPECIALS_DESC', '���������� ������, ����� �������� ����� ������ ��������� ����� � ������� � ���� ������, �.�. ���� ������� ����� X, �� �����, ������� ����� ������� � ����� ������ ����� ������ �� ���� X �������');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE' , '���������� ��������� � ������');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC', '������� ��������� �������� � ����� ������');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE' , '���������� ������� �� ��������');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC', '������������ ���������� �������, ��������� �� ����� �������� � ������� �������');
define('MAX_DISPLAY_BESTSELLERS_TITLE' , '������ ������');
define('MAX_DISPLAY_BESTSELLERS_DESC', '������������ ���������� ������� ������, ��������� � ����� ������ ������');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE' , '����� ��������');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC', '������������ ���������� ������� � ����� ���� ���������� ����� ��������');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE' , '���� ������� �������');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC', '������������ ���������� �������, ��������� � ����� ������� �������');
define('MAX_DISPLAY_ORDER_HISTORY_TITLE' , '������� �������');
define('MAX_DISPLAY_ORDER_HISTORY_DESC', '������������ ���������� �������, ��������� �� �������� ������� �������');
define('MAX_PRODUCTS_QTY_TITLE', '������������ ���������� �������');
define('MAX_PRODUCTS_QTY_DESC', '������������ ���������� ���������� ������� � ������� ����������');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_TITLE' , '������������ ���������� ���� ��� ������ ������');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_DESC' , '������� ���� ����� ����� ��������� ����� � ����� ������������ � ����� �������');


define('PRODUCT_IMAGE_THUMBNAIL_ACTIVE_TITLE' , '��������� ��������� �������� �� �������� ������ ������� � ���������');
define('PRODUCT_IMAGE_THUMBNAIL_ACTIVE_DESC' , '��������� ������������� ���������� GD ��� �������� �� �������� ������ ������� � ���������. ���� ����������� false, �� �� �������� ������� ��������� �������� ����� ftp.');
define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_TITLE' , '������ ��������� �� �������� ������ ������� � ���������');
define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_DESC' , '������ ��������� �� �������� ������ ������� � ��������� � ��������');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_TITLE' , '������ ��������� �� �������� ������ ������� � ���������');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_DESC' , '������ ��������� �� �������� ������ ������� � ��������� � ��������');

define('PRODUCT_IMAGE_INFO_ACTIVE_TITLE' , '��������� ��������� �������� �� �������� �������� ������');
define('PRODUCT_IMAGE_INFO_ACTIVE_DESC' , '��������� ������������� ���������� GD ��� �������� �� �������� �������� ������. ���� ����������� false, �� �� �������� ������� ��������� �������� ����� ftp.');
define('PRODUCT_IMAGE_INFO_WIDTH_TITLE' , '������ �������� �� �������� �������� ������');
define('PRODUCT_IMAGE_INFO_WIDTH_DESC' , '������ �������� �� �������� �������� ������ � ��������');
define('PRODUCT_IMAGE_INFO_HEIGHT_TITLE' , '������ �������� �� �������� �������� ������');
define('PRODUCT_IMAGE_INFO_HEIGHT_DESC' , '������ �������� �� �������� �������� ������ � ��������');

define('PRODUCT_IMAGE_POPUP_ACTIVE_TITLE' , '��������� ��������� �������� � pop-up ����');
define('PRODUCT_IMAGE_POPUP_ACTIVE_DESC' , '��������� ������������� ���������� GD ��� �������� � pop-up ����. ���� ����������� false, �� �� �������� ������� ��������� �������� ����� ftp.');
define('PRODUCT_IMAGE_POPUP_WIDTH_TITLE' , '������ �������� � pop-up ����');
define('PRODUCT_IMAGE_POPUP_WIDTH_DESC' , '������ �������� � pop-up ���� � �������� (�������� 300). ���� �������� �������� ������, �� �������� �� ����� ������� ������!');
define('PRODUCT_IMAGE_POPUP_HEIGHT_TITLE' , '������ �������� � pop-up ����');
define('PRODUCT_IMAGE_POPUP_HEIGHT_DESC' , '������ �������� � pop-up ���� � ��������');

define('SMALL_IMAGE_WIDTH_TITLE' , '������ ��������� ��������');
define('SMALL_IMAGE_WIDTH_DESC' , '������ ��������� �������� (� ��������)');
define('SMALL_IMAGE_HEIGHT_TITLE' , '������ ��������� ��������');
define('SMALL_IMAGE_HEIGHT_DESC' , '������ ��������� �������� (� ��������)');

define('HEADING_IMAGE_WIDTH_TITLE' , '������ �������� ���������');
define('HEADING_IMAGE_WIDTH_DESC' , '������ �������� ��������� (� ��������)');
define('HEADING_IMAGE_HEIGHT_TITLE' , '������ �������� ���������');
define('HEADING_IMAGE_HEIGHT_DESC' , '������ �������� ��������� (� ��������)');

define('SUBCATEGORY_IMAGE_WIDTH_TITLE' , '������ �������� ������������');
define('SUBCATEGORY_IMAGE_WIDTH_DESC' , '������ �������� ������������ (� ��������)');
define('SUBCATEGORY_IMAGE_HEIGHT_TITLE' , '������ �������� ������������');
define('SUBCATEGORY_IMAGE_HEIGHT_DESC' , '������ �������� ������������ (� ��������)');

define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE' , '��������� ������ ��������');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC' , '��������� ������ ��������');

define('IMAGE_REQUIRED_TITLE' , '���������� �������� � ����� ������');
define('IMAGE_REQUIRED_DESC' , '���������� ��� ������ ������, � ������, ���� �������� �� ���������.');

//This is for the Images showing your products for preview. All the small stuff.

define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_TITLE' , '��������� �������� ������:Bevel<br /><img src="images/config_bevel.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_DESC' , '��������� �������� ������:Bevel<br /><br />�� ���������: (8,FFCCCC,330000)<br /><br />���������� ��������� ����<br />������������:<br />(���� ������,hex ������ ����,hex ������ ����)');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_TITLE' , '��������� �������� ������:Greyscale<br /><img src="images/config_greyscale.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_DESC' , '��������� �������� ������:Greyscale<br /><br />�� ���������: (32,22,22)<br /><br />basic black n white<br />������������:<br />(int red,int green,int blue)');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_TITLE' , '��������� �������� ������:Ellipse<br /><img src="images/config_eclipse.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_DESC' , '��������� �������� ������:Ellipse<br /><br />�� ���������: (FFFFFF)<br /><br />ellipse on bg colour<br />������������:<br />(hex background colour)');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_TITLE' , '��������� �������� ������:Round-edges<br /><img src="images/config_edge.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_DESC' , '��������� �������� ������:Round-edges<br /><br />�� ���������: (5,FFFFFF,3)<br /><br />corner trimming<br />������������:<br />(edge_radius,background colour,anti-alias width)');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_TITLE' , '��������� �������� ������:Merge<br /><img src="images/config_merge.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_DESC' , '��������� �������� ������:Merge<br /><br />�� ���������: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />������������:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity, transparent colour on merge image)');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_TITLE' , '��������� �������� ������:Frame<br /><img src="images/config_frame.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_DESC' , '��������� �������� ������:Frame<br /><br />�� ���������: <br /><br />plain raised border<br />������������:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_TITLE' , '��������� �������� ������:Drop-Shadow<br /><img src="images/config_shadow.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_DESC' , '��������� �������� ������:Drop-Shadow<br /><br />�� ���������: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />������������:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_TITLE' , '��������� �������� ������:Motion-Blur<br /><img src="images/config_motion.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_DESC' , '��������� �������� ������:Motion-Blur<br /><br />�� ���������: (4,FFFFFF)<br /><br />fading parallel lines<br />������������:<br />(int number of lines,hex background colour)');

//And this is for the Images showing your products in single-view

define('PRODUCT_IMAGE_INFO_BEVEL_TITLE' , '�������� �� �������� ������:Bevel');
define('PRODUCT_IMAGE_INFO_BEVEL_DESC' , '�������� �� �������� ������:Bevel<br /><br />�� ���������: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />������������:<br />(edge width, hex light colour, hex dark colour)');
define('PRODUCT_IMAGE_INFO_GREYSCALE_TITLE' , '�������� �� �������� ������:Greyscale');
define('PRODUCT_IMAGE_INFO_GREYSCALE_DESC' , '�������� �� �������� ������:Greyscale<br /><br />�� ���������: (32,22,22)<br /><br />basic black n white<br />������������:<br />(int red, int green, int blue)');
define('PRODUCT_IMAGE_INFO_ELLIPSE_TITLE' , '�������� �� �������� ������:Ellipse');
define('PRODUCT_IMAGE_INFO_ELLIPSE_DESC' , '�������� �� �������� ������:Ellipse<br /><br />�� ���������: (FFFFFF)<br /><br />ellipse on bg colour<br />������������:<br />(hex background colour)');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_TITLE' , '�������� �� �������� ������:Round-edges');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_DESC' , '�������� �� �������� ������:Round-edges<br /><br />�� ���������: (5,FFFFFF,3)<br /><br />corner trimming<br />������������:<br />( edge_radius, background colour, anti-alias width)');
define('PRODUCT_IMAGE_INFO_MERGE_TITLE' , '�������� �� �������� ������:Merge');
define('PRODUCT_IMAGE_INFO_MERGE_DESC' , '�������� �� �������� ������:Merge<br /><br />�� ���������: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />������������:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('PRODUCT_IMAGE_INFO_FRAME_TITLE' , '�������� �� �������� ������:Frame');
define('PRODUCT_IMAGE_INFO_FRAME_DESC' , '�������� �� �������� ������:Frame<br /><br />�� ���������: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />������������:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_TITLE' , '�������� �� �������� ������:Drop-Shadow');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_DESC' , '�������� �� �������� ������:Drop-Shadow<br /><br />�� ���������: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />������������:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_TITLE' , '�������� �� �������� ������:Motion-Blur');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_DESC' , '�������� �� �������� ������:Motion-Blur<br /><br />�� ���������: (4,FFFFFF)<br /><br />fading parallel lines<br />������������:<br />(int number of lines,hex background colour)');

//so this image is the biggest in the shop this

define('PRODUCT_IMAGE_POPUP_BEVEL_TITLE' , '�������� � pop-up ����:Bevel');
define('PRODUCT_IMAGE_POPUP_BEVEL_DESC' , '�������� � pop-up ����:Bevel<br /><br />�� ���������: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />������������:<br />(edge width,hex light colour,hex dark colour)');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_TITLE' , '�������� � pop-up ����:Greyscale');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_DESC' , '�������� � pop-up ����:Greyscale<br /><br />�� ���������: (32,22,22)<br /><br />basic black n white<br />������������:<br />(int red,int green,int blue)');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_TITLE' , '�������� � pop-up ����:Ellipse');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_DESC' , '�������� � pop-up ����:Ellipse<br /><br />�� ���������: (FFFFFF)<br /><br />ellipse on bg colour<br />������������:<br />(hex background colour)');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_TITLE' , '�������� � pop-up ����:Round-edges');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_DESC' , '�������� � pop-up ����:Round-edges<br /><br />�� ���������: (5,FFFFFF,3)<br /><br />corner trimming<br />������������:<br />(edge_radius,background colour,anti-alias width)');
define('PRODUCT_IMAGE_POPUP_MERGE_TITLE' , '�������� � pop-up ����:Merge');
define('PRODUCT_IMAGE_POPUP_MERGE_DESC' , '�������� � pop-up ����:Merge<br /><br />�� ���������: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />������������:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('PRODUCT_IMAGE_POPUP_FRAME_TITLE' , '�������� � pop-up ����:Frame');
define('PRODUCT_IMAGE_POPUP_FRAME_DESC' , '�������� � pop-up ����:Frame<br /><br />�� ���������: <br /><br />plain raised border<br />������������:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_TITLE' , '�������� � pop-up ����:Drop-Shadow');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_DESC' , '�������� � pop-up ����:Drop-Shadow<br /><br />�� ���������: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Usage:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_TITLE' , '�������� � pop-up ����:Motion-Blur');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_DESC' , '�������� � pop-up ����:Motion-Blur<br /><br />�� ���������: (4,FFFFFF)<br /><br />fading parallel lines<br />������������:<br />(int number of lines,hex background colour)');

define('MO_PICS_TITLE','���������� �������������� �������� ������');
define('MO_PICS_DESC','���������� �������������� �������� ������, �� ������ ����������� ��������.');

define('IMAGE_MANIPULATOR_TITLE','��������� �������� ����������� GD');
define('IMAGE_MANIPULATOR_DESC','�������������� ������� �������� � ����. ������� � �������������� ���������� GD');

define('ACCOUNT_GENDER_TITLE' , '���');
define('ACCOUNT_GENDER_DESC', '���������� ���� ��� ��� ����������� ���������� � �������� � � �������� �����');
define('ACCOUNT_DOB_TITLE' , '���� ��������');
define('ACCOUNT_DOB_DESC', '���������� ���� ���� �������� ��� ����������� ���������� � �������� � � �������� �����');
define('ACCOUNT_COMPANY_TITLE' , '��������');
define('ACCOUNT_COMPANY_DESC', '���������� ���� �������� ��� ����������� ���������� � �������� � � �������� �����');
define('ACCOUNT_STREET_ADDRESS_TITLE' , '�����');
define('ACCOUNT_STREET_ADDRESS_DESC', '���������� ���� ����� ��� ����������� ���������� � �������� � � �������� �����');
define('ACCOUNT_CITY_TITLE' , '�����');
define('ACCOUNT_CITY_DESC', '���������� ���� ����� ��� ����������� ���������� � �������� � � �������� �����');
define('ACCOUNT_POSTCODE_TITLE' , '�������� ������');
define('ACCOUNT_POSTCODE_DESC', '���������� ���� �������� ������ ��� ����������� ���������� � �������� � � �������� �����');
define('ACCOUNT_COUNTRY_TITLE' , '������');
define('ACCOUNT_COUNTRY_DESC', '���������� ���� ������ ��� ����������� ���������� � �������� � � �������� �����');
define('ACCOUNT_TELE_TITLE' , '�������');
define('ACCOUNT_TELE_DESC', '���������� ���� ������� ��� ����������� ���������� � �������� � � �������� �����');
define('ACCOUNT_FAX_TITLE' , '����');
define('ACCOUNT_FAX_DESC', '���������� ���� ���� ��� ����������� ���������� � �������� � � �������� �����');
define('ACCOUNT_SUBURB_TITLE' , '�����');
define('ACCOUNT_SUBURB_DESC', '���������� ���� ����� ��� ����������� ���������� � �������� � � �������� �����');
define('ACCOUNT_STATE_TITLE' , '������');
define('ACCOUNT_STATE_DESC', '���������� ���� ������ ��� ����������� ���������� � �������� � � �������� �����');

define('DEFAULT_CURRENCY_TITLE' , '������ �� ���������');
define('DEFAULT_CURRENCY_DESC' , '������, ������������ �� ���������, ��� ���� ������ ��������� � ������ �� ���������');
define('DEFAULT_LANGUAGE_TITLE' , '���� �� ���������');
define('DEFAULT_LANGUAGE_DESC' , '����, ������������ � �������� �� ���������');
define('DEFAULT_ORDERS_STATUS_ID_TITLE' , '������ ������ �� ���������');
define('DEFAULT_ORDERS_STATUS_ID_DESC' , '������, ������� ���������� ������ ����� ����� ����������');

define('SHIPPING_ORIGIN_COUNTRY_TITLE' , '������ ��������');
define('SHIPPING_ORIGIN_COUNTRY_DESC', '������, ��� ��������� �������. ���������� ��� ��������� ������� ��������.');
define('SHIPPING_ORIGIN_ZIP_TITLE' , '�������� ������ ��������');
define('SHIPPING_ORIGIN_ZIP_DESC', '������� �������� ������ ��������. ���������� ��� ��������� ������� ��������.');
define('SHIPPING_MAX_WEIGHT_TITLE' , '������������ ��� ��������');
define('SHIPPING_MAX_WEIGHT_DESC', '�� ������ ������� ������������ ��� ��������, ����� �������� ������ �� ������������. ���������� ��� ��������� ������� ��������.');
define('SHIPPING_BOX_WEIGHT_TITLE' , '����������� ��� ��������');
define('SHIPPING_BOX_WEIGHT_DESC', '�� ������ ������� ��� ��������.');
define('SHIPPING_BOX_PADDING_TITLE' , '��� �������� � ���������'); 
define('SHIPPING_BOX_PADDING_DESC', '�������� �������, ��� ������� ������ ���������� � ���������� ������������ ��� ��������, ������������� �� ��������� �������. ���� �� ������ ������� ��������� �� 10%, ������ - 10');
define('SHOW_SHIPPING_DESC' , '���������� ������ ��������� �������� �� �������� ������');
define('SHOW_SHIPPING_TITLE' , '��������� �������� �� �������� ������');
define('SHIPPING_INFOS_DESC' , 'ID ��� ������ ��������� ��������.');
define('SHIPPING_INFOS_TITLE' , 'ID ��� ������');

define('PRODUCT_LIST_FILTER_TITLE' , '���������� ������ ���������/������������� (0=�� ����������; 1=����������)');
define('PRODUCT_LIST_FILTER_DESC', '���������� ����(drop-down) ����, � ������� �������� ����� ����������� ����� � �����-���� ��������� �������� �� �������������.');

define('STOCK_CHECK_TITLE' , '��������� ������� ������ �� ������');
define('STOCK_CHECK_DESC', '���������, ���� �� ����������� ���������� ������ �� ������ ��� ���������� ������');

define('ATTRIBUTE_STOCK_CHECK_TITLE' , '�������� ��������� �� ������');
define('ATTRIBUTE_STOCK_CHECK_DESC' , '��������� ������� ��������� ������ �� ������');

define('STOCK_LIMITED_TITLE' , '�������� ����� �� ������');
define('STOCK_LIMITED_DESC', '�������� �� ������ �� ���������� ������, ������� ����� ������������ � ��������-��������');
define('STOCK_ALLOW_CHECKOUT_TITLE' , '��������� ���������� ������');
define('STOCK_ALLOW_CHECKOUT_DESC', '��������� ����������� ��������� �����, ���� ���� �� ������ ��� ������������ ���������� ������ ������������� ������');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE' , '�������� �����, ������������� �� ������');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC', '���������� ���������� ������ �������� ������ ��� ���������� ������, ���� �� ������ ��� ������������ ���������� ������ ������������� ������');
define('STOCK_REORDER_LEVEL_TITLE' , '����� ���������� ������ �� ������');
define('STOCK_REORDER_LEVEL_DESC', '���� ���������� ������ �� ������ ������, ��� ��������� ����� � ������ ����������, �� � ������� ��������� �������������� � ������������� ���������� ������ �� ������ ��� ���������� ������.');

define('STORE_PAGE_PARSE_TIME_TITLE' , '��������� ����� �������� �������');
define('STORE_PAGE_PARSE_TIME_DESC', '������� �����, ����������� �� ���������(�������) ������� ��������.');
define('STORE_PAGE_PARSE_TIME_LOG_TITLE' , '���������� �������� �����');
define('STORE_PAGE_PARSE_TIME_LOG_DESC', '������ ���� �� ���������� � �����, � ������� ����� ������������ ��� �������� �������.');
define('STORE_PARSE_DATE_TIME_FORMAT_TITLE' , '������ ���� �����');
define('STORE_PARSE_DATE_TIME_FORMAT_DESC', '������ ����');

define('DISPLAY_PAGE_PARSE_TIME_TITLE' , '���������� ����� �������� �������');
define('DISPLAY_PAGE_PARSE_TIME_DESC', '���������� ����� �������� �������� � ��������-�������� (����� ��������� ����� �������� ������� ������ ���� ��������)');

define('STORE_DB_TRANSACTIONS_TITLE' , '��������� ������� � ���� ������');
define('STORE_DB_TRANSACTIONS_DESC', '��������� ��� ������� � ���� ������ � �����, ��������� � ���������� ���������� �������� ����� (������ ��� PHP4 � ����)');

define('USE_CACHE_TITLE' , '������������ ���');
define('USE_CACHE_DESC', '������������ ����������� ����������.');

define('DB_CACHE_TITLE','����������� �������� � ��');
define('DB_CACHE_DESC','���� ���������� true, ������� ����� ���������� ������� SELECT, ��� �������� �������� ������ ��������.');

define('DIR_FS_CACHE_TITLE' , '��� ����������');
define('DIR_FS_CACHE_DESC', '����������, ���� ����� ������������ � ����������� ���-�����.');

define('ACCOUNT_OPTIONS_TITLE','��� �����������');
define('ACCOUNT_OPTIONS_DESC','��� ����� ���������������� ����������?<br />�� ������ ������� ����� ������������ ������� � ����������� ������ � �� (<b>account</b>), ���� ����������� �������� ����� (<b>guest</b>) ��� ���������� ������ (������ � ������� ����������, �� ������ �� ����� ������������).<br />����� ������� ��� (<b>both</b>) �������.');

define('EMAIL_TRANSPORT_TITLE' , '������ �������� E-Mail');
define('EMAIL_TRANSPORT_DESC', '�������, ����� ������ �������� ����� �� �������� ����� ��������������.');

define('EMAIL_LINEFEED_TITLE' , '����������� ����� � E-Mail');
define('EMAIL_LINEFEED_DESC', '������������ ������������������ �������� ��� ���������� ���������� � ������.');
define('EMAIL_USE_HTML_TITLE' , '������������ HTML ������ ��� �������� �����');
define('EMAIL_USE_HTML_DESC', '���������� ������ �� �������� � HTML �������.');
define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE' , '��������� E-Mail ����� ����� DNS');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC', '���������, ������ �� e-mail ������ ����������� ��� ����������� � ��������-��������. ��� �������� ������������ DNS.');
define('SEND_EMAILS_TITLE' , '���������� ������ �� ��������');
define('SEND_EMAILS_DESC', '���������� ������ �� ��������.');
define('SENDMAIL_PATH_TITLE' , '���� � sendmail');
define('SENDMAIL_PATH_DESC' , '���� �� ����������� ����� sendmail, ������� ���������� ���� �� sendmail (�� ���������: /usr/bin/sendmail):');
define('SMTP_MAIN_SERVER_TITLE' , '����� SMTP �������');
define('SMTP_MAIN_SERVER_DESC' , '���� �� ����������� ����� smtp, ������� ���������� smtp ������.');
define('SMTP_BACKUP_SERVER_TITLE' , '����� ���������� SMTP �������');
define('SMTP_BACKUP_SERVER_DESC' , '���� �� ����������� ����� smtp, �� ������ ������� ����� ���������� smtp �������.');
define('SMTP_USERNAME_TITLE' , '��� ������������ smtp');
define('SMTP_USERNAME_DESC' , '��� ������������ ��� ����������� � smtp �������');
define('SMTP_PASSWORD_TITLE' , '������ smtp');
define('SMTP_PASSWORD_DESC' , '������ ��� ����������� � smtp �������');
define('SMTP_AUTH_TITLE' , '�������������� smtp');
define('SMTP_AUTH_DESC' , '����� �� �������������� �� smtp?');
define('SMTP_PORT_TITLE' , '���� smtp �������');
define('SMTP_PORT_DESC' , '������� ���� smtp ������� (�� ��������� 25)');

//Constants for contact_us
define('CONTACT_US_EMAIL_ADDRESS_TITLE' , '��������� � ���� - Email �����');
define('CONTACT_US_EMAIL_ADDRESS_DESC' , '����������, ������� Email �����, �� ������� ����� ������������ ������ �� ��������, �� �������� ��������� � ����.<br />��� ���� ���������� ���������!');
define('CONTACT_US_NAME_TITLE' , '��������� � ���� - ��� ����������');
define('CONTACT_US_NAME_DESC' , '����������, ������� ��� (����: ����), �� ������� ����� ������������ ������ �� ��������, �� �������� ��������� � ����.<br />����� �������� �������� �������� ���, ��������, ���������� ���� (���). � �������� ��������� ���� ���� ����� ��������� ���: <b>�������� �������� (email@�����)</b><br />��� ���� ����� �������� ������.');
define('CONTACT_US_FORWARDING_STRING_TITLE' , '��������� � ���� - ������ ������������� (����� �������)');
define('CONTACT_US_FORWARDING_STRING_DESC' , '������� �mail ������ (����: ������� �����) ����������� ������� �� ������� ����� ����� ������������ ������ �� ��������, �� �������� ��������� � ����.<br />��� ���� ����� �������� ������.');
define('CONTACT_US_REPLY_ADDRESS_TITLE' , '��������� � ���� - ����� ��� �������');
define('CONTACT_US_REPLY_ADDRESS_DESC' , '����������, ������� E-Mail �����, �� ������� ������� ����� ��������. � �������� ��������� ��� ���� <b>�������� �����</b>.<br />��� ���� �� ������������� ���������.');
define('CONTACT_US_REPLY_ADDRESS_NAME_TITLE' , '��������� � ���� - ��� �����������');
define('CONTACT_US_REPLY_ADDRESS_NAME_DESC' , '��� � �������� ������. ����� ������� �������� ��������.<br />��� ���� �� ���� ��������� ���� �� ��������� ���� ����� ��� �������.');
define('CONTACT_US_EMAIL_SUBJECT_TITLE' , '��������� � ���� - ���� ������');
define('CONTACT_US_EMAIL_SUBJECT_DESC' , '������� ����, ������� ����� � ������� ��� �������� ��������� �� ��������, �� �������� ��������� � ����.<br />��� ���� ������������� ���������.');

//Constants for support system
define('EMAIL_SUPPORT_ADDRESS_TITLE' , '������ ��������� - E-Mail �����');
define('EMAIL_SUPPORT_ADDRESS_DESC' , '������� email ����� ��� ����� � <b>������ ���������</b> (�������� ��� ���������� ������, ������ ������).');
define('EMAIL_SUPPORT_NAME_TITLE' , '������ ��������� - ��� ����������');
define('EMAIL_SUPPORT_NAME_DESC' , '������� ��������  <b>������ ���������</b> (������� ��� ���������� ������, ������ ������).');
define('EMAIL_SUPPORT_FORWARDING_STRING_TITLE' , '������ ��������� - ������ ������������� (����� �������)');
define('EMAIL_SUPPORT_FORWARDING_STRING_DESC' , '������� �mail ������ (����: ������� �����) ����������� ������� �� ������� ����� ����� ������������ ������ � <b>������ ���������</b>.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_TITLE' , '������ ��������� - ����� ��� �������');
define('EMAIL_SUPPORT_REPLY_ADDRESS_DESC' , '����������, ������� E-Mail �����, �� ������� ������� ����� ��������. � �������� ��������� ��� ���� <b>�������� �����</b>.<br />��� ���� �� ������������� ���������.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_TITLE' , '������ ��������� - ��� �����������');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_DESC' , '��� � �������� ������. ����� ������� �������� ��������.');
define('EMAIL_SUPPORT_SUBJECT_TITLE' , '������ ��������� - ���� ������');
define('EMAIL_SUPPORT_SUBJECT_DESC' , '������� ���� ��� ����� � <b>������ ���������</b> �� ��������.');

//Constants for Billing system
define('EMAIL_BILLING_ADDRESS_TITLE' , '������ ��������� ������ - E-Mail �����');
define('EMAIL_BILLING_ADDRESS_DESC' , '������� email ����� ��� <b>������ ��������� ������</b> (������������ ������, ��������� �������...).');
define('EMAIL_BILLING_NAME_TITLE' , '������ ��������� ������ - ��� ����������');
define('EMAIL_BILLING_NAME_DESC' , '������� ��������  <b>������ ��������� ������</b> (������������� ������, ��������� �������...).');
define('EMAIL_BILLING_FORWARDING_STRING_TITLE' , '������ ��������� ������ - ����� �� ������� ���������� ����� ������ � �������');
define('EMAIL_BILLING_FORWARDING_STRING_DESC' , '������� �������������� ������ ��� <b>������ ��������� ������</b> (������������ ������, ��������� �������..) ����� �������<br /> ������� Email ������ ������.');
define('EMAIL_BILLING_REPLY_ADDRESS_TITLE' , '������ ��������� ������ - ����� �� ��������������� ������');
define('EMAIL_BILLING_REPLY_ADDRESS_DESC' , '������� ��������������  email ����� ���������� ������ ��� ��������');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_TITLE' , '������ ��������� ������ - ������ �� �������������� �������, ���');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_DESC' , '������� ��� ��� ��������������� ������, ����������� ������ ��� ��������.');
define('EMAIL_BILLING_SUBJECT_TITLE' , '������ ��������� ������ - ���� ������');
define('EMAIL_BILLING_SUBJECT_DESC' , '������� ���� ��� ������ � <b>������ ��������� ������</b>');
define('EMAIL_BILLING_SUBJECT_ORDER_TITLE','������ ��������� ������ - ���� � ��������� ������');
define('EMAIL_BILLING_SUBJECT_ORDER_DESC','������� ���� � ��������� ��� ������ � <b>������ ��������� ������</b>, ������������ �� ��������. (�������� <b>��� ����� {$nr}, {$date}</b>) ����������: �� ������ ������������, {$nr},{$date},{$firstname},{$lastname}');


define('DOWNLOAD_ENABLED_TITLE' , '��������� ������� ���������� �������');
define('DOWNLOAD_ENABLED_DESC', '��������� ������� ���������� �������.');
define('DOWNLOAD_BY_REDIRECT_TITLE' , '������������ ��������������� ��� ����������');
define('DOWNLOAD_BY_REDIRECT_DESC', '������������ ��������������� � �������� ��� ���������� ������. ��� �� Unix ������(Windows, Mac OS � �.�.) ������ ������ false.');
define('DOWNLOAD_MAX_DAYS_TITLE' , '���� ������������� ������ ��� ���������� (����)');
define('DOWNLOAD_MAX_DAYS_DESC', '���������� ���������� ����, � ������� ������� ���������� ����� ������� ���� �����. ���� ������� 0, ����� ���� ������������� ������ ��� ���������� ��������� �� �����.');
define('DOWNLOAD_MAX_COUNT_TITLE' , '������������ ���������� ����������');
define('DOWNLOAD_MAX_COUNT_DESC', '���������� ������������ ���������� ���������� ��� ������ ������. ���� ������� 0, ����� ������� ����������� �� ���������� ���������� �� �����.');

define('GZIP_COMPRESSION_TITLE' , '��������� GZip ����������');
define('GZIP_COMPRESSION_DESC', '��������� HTTP GZip ����������.');
define('GZIP_LEVEL_TITLE' , '������� ����������');
define('GZIP_LEVEL_DESC', '�� ������ ������� ������� ���������� �� 0 �� 9 (0 = �������, 9 = ��������).');

define('SESSION_WRITE_DIRECTORY_TITLE' , '���������� ������');
define('SESSION_WRITE_DIRECTORY_DESC', '���� ������ �������� � ������, �� ����� ���������� ������� ����������, � ������� ����� ��������� ����� ������, ���������� ������ ���� �� ����� ������ � ������������ �������� (admin, images � �.�.), �� ��������� tmp, ��� ������, ��� ����� tmp ������ ���������� � �������� ���������� ��������.');
define('SESSION_FORCE_COOKIE_USE_TITLE' , '�������������� ������������� Cookie');
define('SESSION_FORCE_COOKIE_USE_DESC', '������������� ������������ ������, ������ ����� � �������� ������������ cookies.');
define('SESSION_CHECK_SSL_SESSION_ID_TITLE' , '��������� ID SSL ������');
define('SESSION_CHECK_SSL_SESSION_ID_DESC', '���������  SSL_SESSION_ID ��� ������ ��������� � ��������, ���������� ���������� HTTPS.');
define('SESSION_CHECK_USER_AGENT_TITLE' , '��������� ���������� User Agent');
define('SESSION_CHECK_USER_AGENT_DESC', '��������� ���������� ������� user agent ��� ������ ��������� � ��������� ��������-��������.');
define('SESSION_CHECK_IP_ADDRESS_TITLE' , '��������� IP �����');
define('SESSION_CHECK_IP_ADDRESS_DESC', '��������� IP ������ �������� ��� ������ ��������� � ��������� ��������-��������.');
define('SESSION_RECREATE_TITLE' , '������������ ������');
define('SESSION_RECREATE_DESC', '������������ ������ ��� ��������� ������ ID ���� ������ ��� ����� ������������������� ���������� � �������, ���� ��� ����������� ������ ���������� (������ ��� PHP 4.1 � ����).');

define('DISPLAY_CONDITIONS_ON_CHECKOUT_TITLE' , '���������� ������� ��� ���������� ������?');
define('DISPLAY_CONDITIONS_ON_CHECKOUT_DESC' , '��� ���������� ������, ������� ����� �������� �������, ������� ���������� ����� �����������, ����� �� �� ������ �������� �����.');

define('META_MIN_KEYWORD_LENGTH_TITLE' , '����������� meta-keyword �����');
define('META_MIN_KEYWORD_LENGTH_DESC' , '����������� ����� ������ ����� (������������� �� �������� ������)');
define('META_KEYWORDS_NUMBER_TITLE' , '���������� meta-keywords');
define('META_KEYWORDS_NUMBER_DESC' , '���������� �������� ����');
define('META_AUTHOR_TITLE' , 'author');
define('META_AUTHOR_DESC' , '&lt;meta name=&quot;author&quot;&gt;');
define('META_PUBLISHER_TITLE' , 'publisher');
define('META_PUBLISHER_DESC' , '&lt;meta name=&quot;publisher&quot;&gt;');
define('META_COMPANY_TITLE' , 'company');
define('META_COMPANY_DESC' , '&lt;meta name=&quot;company&quot;&gt;');
define('META_TOPIC_TITLE' , 'page-topic');
define('META_TOPIC_DESC' , '&lt;meta name=&quot;page-topic&quot;&gt;');
define('META_REPLY_TO_TITLE' , 'reply-to');
define('META_REPLY_TO_DESC' , '&lt;meta name=&quot;reply-to&quot;&gt;');
define('META_REVISIT_AFTER_TITLE' , 'revisit-after');
define('META_REVISIT_AFTER_DESC' , '&lt;meta name=&quot;revisit-after&quot;&gt;');
define('META_ROBOTS_TITLE' , 'robots');
define('META_ROBOTS_DESC' , '&lt;meta name=&quot;robots&quot;&gt;');
define('META_DESCRIPTION_TITLE' , 'Description');
define('META_DESCRIPTION_DESC' , '&lt;meta name=&quot;description&quot;&gt;');
define('META_KEYWORDS_TITLE' , 'Keywords');
define('META_KEYWORDS_DESC' , '&lt;meta name=&quot;keywords&quot;&gt;');

define('MODULE_PAYMENT_INSTALLED_TITLE' , '������������� ������ ������');
define('MODULE_PAYMENT_INSTALLED_DESC' , '������ ������� ������, ������ ������, ����������� ������ � �������. ������ ����������� ������������� � ����������� �� ������������� �������. (������: cc.php;cod.php;paypal.php)');
define('MODULE_ORDER_TOTAL_INSTALLED_TITLE' , '������������� ������ �����');
define('MODULE_ORDER_TOTAL_INSTALLED_DESC' , '������ ������� ����� �� ������ ������, ����������� ������ � �������. ������ ����������� ������������� � ����������� �� ������������� ������� (������: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)');
define('MODULE_SHIPPING_INSTALLED_TITLE' , '������������� ������ ��������');
define('MODULE_SHIPPING_INSTALLED_DESC' , '������ ������� ��������, ������ ������, ����������� ������ � �������. ������ ����������� ������������� � ����������� �� ������������� �������. (������: ups.php;flat.php;item.php)');

define('CACHE_LIFETIME_TITLE','���� ����� ����');
define('CACHE_LIFETIME_DESC','��� ����� ���������� �������� (� ��������).');
define('CACHE_CHECK_TITLE','��������� ��������� ����');
define('CACHE_CHECK_DESC','���� true, ����� �����������, ���� �� �������� ��������� If-Modified-Since headers ������ � �������� ����������� ��������, � �������������� HTTP ��������� ������������ � ���. � ���� ������ ���������� ������ ������� �� ���� ������� �������� � �����������, � ������ �������� �����, ��� ��������� ����� ��������.');

define('DB_CACHE_EXPIRE_TITLE','���� ����� ���� ���� ������');
define('DB_CACHE_EXPIRE_DESC','��� ����� ���������� ������� � ���� ������ (� ��������).');

define('PRODUCT_REVIEWS_VIEW_TITLE','������ �� �������� �������� ������');
define('PRODUCT_REVIEWS_VIEW_DESC','���������� ������� �� �������� �������� ������');

define('DELETE_GUEST_ACCOUNT_TITLE','������� �������� ������');
define('DELETE_GUEST_ACCOUNT_DESC','������� ������ ����� ����� ������ (���� ������ ����� ���������).');

define('USE_WYSIWYG_TITLE','HTML-��������');
define('USE_WYSIWYG_DESC','�������� HTML-�������� FCKEditor ��� �������������� �������, ���������, �������.');

define('PRICE_IS_BRUTTO_TITLE','������ ���� � �������');
define('PRICE_IS_BRUTTO_DESC','������������ ���� � ������� � �������.');

define('PRICE_PRECISION_TITLE','�������� ���');
define('PRICE_PRECISION_DESC','�������� ��� �� X ������ ����� �����������.');
define('CHECK_CLIENT_AGENT_TITLE','�� ���������� ������ � ������ ������ ��������� �����');
define('CHECK_CLIENT_AGENT_DESC','�� ���������� ������ ��������� ��������� ������. ������ ������ � /inc/xtc_check_agent.inc.php');
define('SHOW_IP_LOG_TITLE','���������� IP ����� ���������� ��� ���������� ������');
define('SHOW_IP_LOG_DESC','�������� ����� &quot;��� IP �����:&quot;, ��� ���������� ������');

define('ACTIVATE_GIFT_SYSTEM_TITLE','������������ ������� ���������� ������������ / �������');
define('ACTIVATE_GIFT_SYSTEM_DESC','��������� ��������, ������������ ��� ���������� ������� ���������� ����������� � ������');

define('ACTIVATE_SHIPPING_STATUS_TITLE','����� ��������');
define('ACTIVATE_SHIPPING_STATUS_DESC','���������� ������ ��������? ����� ��������� �� �������� ������ �������� ����� <b>����� ��������</b>');

define('SECURITY_CODE_LENGTH_TITLE','����� ���������� ����');
define('SECURITY_CODE_LENGTH_DESC','����� ���������� ���� (� ���������� �����������)');

define('IMAGE_QUALITY_TITLE','�������� ������������ ��������');
define('IMAGE_QUALITY_DESC','�� ������ ������� �������� �� 0 �� 100 (0 - ������������ ������, 100 - ������������ ��������)');

define('GROUP_CHECK_TITLE','�������� ������� ���������� ��� ���������');
define('GROUP_CHECK_DESC','��������� ������ ����������������� ����������� � ������� ������ � ���������� ���������� ������������� �� (����� ��������� �������� ������ � ���������');

define('ACTIVATE_REVERSE_CROSS_SELLING_TITLE','�������� ����������� ������');
define('ACTIVATE_REVERSE_CROSS_SELLING_DESC','������������ ������� �������� ������������ ������ ����� ��������');

define('ACTIVATE_NAVIGATOR_TITLE','�������� ��������� �� ������');
define('ACTIVATE_NAVIGATOR_DESC','��������/��������� ��������� �� ������ �� �������� ������, (��� ������� ���������� ������ � �������, ���������� ������ ����������� �������� ������� �������� �������� ������)');

define('QUICKLINK_ACTIVATED_TITLE','�������� ������� �������������� �����������');
define('QUICKLINK_ACTIVATED_DESC','������� �������������� ����������� � ������.');

define('DOWNLOAD_UNALLOWED_PAYMENT_TITLE', '����������� ������ ������ ��� ����������� �������');
define('DOWNLOAD_UNALLOWED_PAYMENT_DESC', '����������� ������ ������ ��� ����������� ������� (�.�. ��� �������, ������� ����� ����� ��� ��������). ������ ���������� ��������, ��������: cod,cc');
define('DOWNLOAD_MIN_ORDERS_STATUS_TITLE', '����������� c����� ������');
define('DOWNLOAD_MIN_ORDERS_STATUS_DESC', '���������� ����������� ������ �������, ������� ��������� ������ � ����. ��� ����� ��� ���� ��� � �������� ������� ���� �������� ������ ���������� �������.');

// Vat Check
define('STORE_OWNER_VAT_ID_TITLE' , 'VAT ��� ��������� ��������');
define('STORE_OWNER_VAT_ID_DESC' , 'VAT ��� ��������� ��������');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_TITLE' , '������ ����������� - ���������� VAT ��� (������, �������� �� ������ ��������)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_DESC' , '������ ��� ����������� � ��������� ��������� VAT �����, ������ �������� != ������ ����������');
define('ACCOUNT_COMPANY_VAT_CHECK_TITLE' , '��������� VAT ���');
define('ACCOUNT_COMPANY_VAT_CHECK_DESC' , '��������� ��������� �� ������ VAT ��� (�������� ����������)');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_TITLE' , '��������� VAT ��� ����� ������� ������');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_DESC' , '��������� VAT ��� ����� ������� ������');
define('ACCOUNT_COMPANY_VAT_GROUP_TITLE' , '�������������� ����� ������');
define('ACCOUNT_COMPANY_VAT_GROUP_DESC' , '���������� � true, ���� �� ������, ��� � ������ ���������� ���������� ������������� ��� ��������� ��������� VAT ����.');
define('ACCOUNT_VAT_BLOCK_ERROR_TITLE' , '��������� ������������ UST ����');
define('ACCOUNT_VAT_BLOCK_ERROR_DESC' , '���������� � true, �� ������ ������ ����������� ������ VAT ����.');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_TITLE','������ ����������� - ���������� VAT ��� (������, ����������� ������ ��������)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_DESC','������ ��� ����������� � ��������� ��������� VAT �����, ������ �������� = ������ ����������');
// Google Conversion
define('GOOGLE_CONVERSION_TITLE','Google ������������� �����������');
define('GOOGLE_CONVERSION_DESC','����������� ������������� �������� ����� � �������');
define('GOOGLE_CONVERSION_ID_TITLE','ID ��������������');
define('GOOGLE_CONVERSION_ID_DESC','��� Google ������������� ID');
define('GOOGLE_LANG_TITLE','Google ����');
define('GOOGLE_LANG_DESC','ISO ��� �������������� ����� (ru, en, fr, de...)');

// Afterbuy
define('AFTERBUY_ACTIVATED_TITLE','������������');
define('AFTERBUY_ACTIVATED_DESC','������������ ������ afterbuy');
define('AFTERBUY_PARTNERID_TITLE','ID ��� �������');
define('AFTERBUY_PARTNERID_DESC','��� ���������� afterbuy id ���');
define('AFTERBUY_PARTNERPASS_TITLE','������ �������');
define('AFTERBUY_PARTNERPASS_DESC','��� ������ ��� ������ Afterbuy XML');
define('AFTERBUY_USERID_TITLE','ID ��� ������������');
define('AFTERBUY_USERID_DESC','��� ID ��� ������������');
define('AFTERBUY_ORDERSTATUS_TITLE','������ ������');
define('AFTERBUY_ORDERSTATUS_DESC','������ ������, ��������������� ��� �������������� �������');
define('AFTERBUY_URL','��������� ���������� � ������ Afterbuy �������� �� ������: <a href="http://www.xt-commerce.com/modules/wfsection/dossier-65.html" target="new">http://www.xt-commerce.com/modules/wfsection/dossier-65.html</a>');

// Search-Options
define('SEARCH_IN_DESC_TITLE','����� � �������� �������');
define('SEARCH_IN_DESC_DESC','��������� ����� � �������� �������');
define('SEARCH_IN_ATTR_TITLE','����� � ��������� �������');
define('SEARCH_IN_ATTR_DESC','��������� ����� � ��������� �������');

define('SEARCH_ENGINE_FRIENDLY_URLSX_TITLE' , '������������ �������� URL SEFLT?');
define('SEARCH_ENGINE_FRIENDLY_URLSX_DESC' , '������������ �������� URL SEFLT');

// ������ VaM

// ������ ������

define('YML_NAME_TITLE' , '�������� ��������');
define('YML_COMPANY_TITLE' , '�������� ��������');
define('YML_DELIVERYINCLUDED_TITLE' , '�������� ��������');
define('YML_AVAILABLE_TITLE' , '����� � �������');
define('YML_AUTH_USER_TITLE' , '�����');
define('YML_AUTH_PW_TITLE' , '������');
define('YML_REFERER_TITLE' , '������');
define('YML_STRIP_TAGS_TITLE' , '����');
define('YML_UTF8_TITLE' , '������������� � UTF-8');

define('YML_NAME_DESC' , '�������� �������� ��� ������-������. ���� ���� ������, �� ������������ STORE_NAME.');
define('YML_COMPANY_DESC' , '�������� �������� ��� ������-������. ���� ���� ������, �� ������������ STORE_OWNER.');
define('YML_DELIVERYINCLUDED_DESC' , '�������� �������� � ��������� ������?');
define('YML_AVAILABLE_DESC' , '����� � ������� ��� ��� �����?');
define('YML_AUTH_USER_DESC' , '����� ��� ������� � YML');
define('YML_AUTH_PW_DESC' , '������ ��� ������� � YML');
define('YML_REFERER_DESC' , '�������� � ����� ������ �������� � ������� �� User agent ��� ip?');
define('YML_STRIP_TAGS_DESC' , '������� html-���� � �������?');
define('YML_UTF8_DESC' , '�������������� � UTF-8?');

// ��������� ���

define('DISPLAY_MODEL_TITLE' , '���������� ��� ������');
define('MODIFY_MODEL_TITLE' , '���������� ��� ������');
define('MODIFY_NAME_TITLE' , '���������� �������� ������');
define('DISPLAY_STATUT_TITLE' , '���������� ������ ������');
define('DISPLAY_WEIGHT_TITLE' , '���������� ��� ������');
define('DISPLAY_QUANTITY_TITLE' , '���������� ���������� ������');
define('DISPLAY_IMAGE_TITLE' , '���������� �������� ������');
define('DISPLAY_MANUFACTURER_TITLE' , '���������� �������������');
define('MODIFY_MANUFACTURER_TITLE' , '��������� ������������� ������');
define('DISPLAY_TAX_TITLE' , '���������� �����');
define('MODIFY_TAX_TITLE' , '���������� �����');
define('DISPLAY_TVA_OVER_TITLE' , '���������� ���� � ��������');
define('DISPLAY_TVA_UP_TITLE' , '���������� ���� � �������� ��� ��������� ����');
define('DISPLAY_PREVIEW_TITLE' , '���������� ������ �� �������� ������');
define('DISPLAY_EDIT_TITLE' , '���������� ������ �� �������������� ������');
define('ACTIVATE_COMMERCIAL_MARGIN_TITLE' , '���������� ����������� ��������� ��������� ���');

define('DISPLAY_MODEL_DESC', '����������/�� ���������� ��� ������');
define('MODIFY_MODEL_DESC', '����������/�� ���������� ��� ������');
define('MODIFY_NAME_DESC', '����������/�� ���������� �������� ������');
define('DISPLAY_STATUT_DESC', '����������/�� ���������� ������ ������');
define('DISPLAY_WEIGHT_DESC', '����������/�� ���������� ��� ������');
define('DISPLAY_QUANTITY_DESC', '����������/�� ���������� ���������� ������');
define('DISPLAY_IMAGE_DESC', '����������/�� ���������� �������� ������');
define('MODIFY_MANUFACTURER_DESC', '����������/�� ���������� ��������� ������������� ������');
define('MODIFY_TAX_DESC', '����������/�� ���������� �����');
define('DISPLAY_TVA_OVER_DESC', '����������/�� ���������� ���� � ��������');
define('DISPLAY_TVA_UP_DESC', '����������/�� ���������� ���� � �������� ��� ��������� ����');
define('DISPLAY_PREVIEW_DESC', '����������/�� ���������� ������ �� �������� ������');
define('DISPLAY_EDIT_DESC', '����������/�� ���������� ������ �� �������������� ������');
define('DISPLAY_MANUFACTURER_DESC', '����������/�� ���������� �������������');
define('DISPLAY_TAX_DESC', '����������/�� ���������� �����');
define('ACTIVATE_COMMERCIAL_MARGIN_DESC', '����������/�� ���������� ����������� ���������  ��������� ���');

define('REVOCATION_ID_TITLE','ID ��� �������������� �������� � ��������� �������� ������');
define('REVOCATION_ID_DESC','ID ��� �������������� �������� � ����������� � �������� ������, ������� ����� �������� �� �������� ������������� ������');
define('DISPLAY_REVOCATION_ON_CHECKOUT_TITLE','���������� ����� � ����������� � �������� ������ �� �������� �������������?');
define('DISPLAY_REVOCATION_ON_CHECKOUT_DESC','���������� ����� � ����������� � �������� ������ �� �������� �������������?');

define('MAX_DISPLAY_LATEST_NEWS_TITLE' , '���� ��������');
define('MAX_DISPLAY_LATEST_NEWS_DESC' , '���������� ��������, ������������ � �����');
define('MAX_DISPLAY_LATEST_NEWS_PAGE_TITLE' , '�������� �� ����� ��������');
define('MAX_DISPLAY_LATEST_NEWS_PAGE_DESC' , '���������� ��������, ������������ �� ����� �������');
define('MAX_DISPLAY_LATEST_NEWS_CONTENT_TITLE' , '������� ������');
define('MAX_DISPLAY_LATEST_NEWS_CONTENT_DESC' , '���������� ��������, ������������ ��� ��������������� ��������� �������');

?>