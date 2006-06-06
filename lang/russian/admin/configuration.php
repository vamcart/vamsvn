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

define('TABLE_HEADING_CONFIGURATION_TITLE', '���������');
define('TABLE_HEADING_CONFIGURATION_VALUE', '��������');
define('TABLE_HEADING_ACTION', '��������');

define('TEXT_INFO_EDIT_INTRO', '����������, ������� ����������� ���������');
define('TEXT_INFO_DATE_ADDED', '���� ����������:');
define('TEXT_INFO_LAST_MODIFIED', '��������� ���������:');

// language definitions for config
define('STORE_NAME_TITLE' , '�������� ��������');
define('STORE_NAME_DESC' , '�������� ����� ��������');
define('STORE_OWNER_TITLE' , '��������');
define('STORE_OWNER_DESC' , '��� ���������');
define('STORE_OWNER_EMAIL_ADDRESS_TITLE' , 'E-Mail �����');
define('STORE_OWNER_EMAIL_ADDRESS_DESC' , 'E-mail ����� ��������� ��������');

define('EMAIL_FROM_TITLE' , 'E-Mail ��');
define('EMAIL_FROM_DESC' , 'E-mail Adress � ���������� �������.');

define('STORE_COUNTRY_TITLE' , '������');
define('STORE_COUNTRY_DESC' , '������ ��� ��������� ������� <br /><br /><b>�������: �� �������� �������� ����.</b>');
define('STORE_ZONE_TITLE' , '����');
define('STORE_ZONE_DESC' , '���� ��� ��������� �������.');

define('EXPECTED_PRODUCTS_SORT_TITLE' , '������� ���������� ��������� �������');
define('EXPECTED_PRODUCTS_SORT_DESC' , '���� ������� ���������� ��������������� � ������� ��������� �������.');
define('EXPECTED_PRODUCTS_FIELD_TITLE' , '������ ��������� �������');
define('EXPECTED_PRODUCTS_FIELD_DESC' , '����� �������� ��� ����������.');

define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE' , '������������ �� ������ �����');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC' , '�������������� ������������ �� ������ ���������� �����.');

define('SEND_EXTRA_ORDER_EMAILS_TO_TITLE' , '�������������� E-mail � ��������:');
define('SEND_EXTRA_ORDER_EMAILS_TO_DESC' , '������� �������������� ������ � �������� �� �������������� �������, � ����� �������: ��� 1 &lt;email@adress1&gt;, ��� 2 &lt;email@adress2&gt;');

define('SEARCH_ENGINE_FRIENDLY_URLS_TITLE' , '������������ �������� URL ����������� � ������������?');
define('SEARCH_ENGINE_FRIENDLY_URLS_DESC' , '������������ �������� URL ����������� � ������������. ������� �������� (:');

define('DISPLAY_CART_TITLE' , '���������� ������� ����� ���������� ������?');
define('DISPLAY_CART_DESC' , '���������� ������� ����� ���������� ������ ��� ������������ �� �������� ������?');

define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE' , '��������� ������ ������ �������?');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC' , '��������� ������ ������ ������� � ������?');

define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE' , '�������� ������ �� ���������');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC' , '�������� ������ �� ���������.');

define('STORE_NAME_ADDRESS_TITLE' , '����� �������� � �������');
define('STORE_NAME_ADDRESS_DESC' , '���������� ���������� ������� ������������ �� �����.');

define('SHOW_COUNTS_TITLE' , '���������� ������� �������?');
define('SHOW_COUNTS_DESC' , '���������� ������� ������� � ���������� � ����� ���������?');

define('DISPLAY_PRICE_WITH_TAX_TITLE' , '���������� ���� � ��������?');
define('DISPLAY_PRICE_WITH_TAX_DESC' , '����� �������� � ���� (true) ��� ��������� � ����� ��� ����������? (false)');

define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_TITLE' , '������ ����� �� �������������');
define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_DESC' , '�������� ������ ����� �� ������� �������������!');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_TITLE' , '������ ���������� �����');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_DESC' , '����� ����� �� ��������� ������ ����� ����� ������������');
define('DEFAULT_CUSTOMERS_STATUS_ID_TITLE' , '������ ���������� ��� ������ �������');
define('DEFAULT_CUSTOMERS_STATUS_ID_DESC' , '����� ����� �� ��������� ������ ������ ������� ����� �����������');

define('ALLOW_ADD_TO_CART_TITLE' , '��������� ��������� � �������');
define('ALLOW_ADD_TO_CART_DESC' , '��������� ���������� ��������� � ������� ���� ��� ������ &quot;���������� ����&quot; ��������� �  0');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_TITLE' , '��������� ������ �� �������� ������?');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_DESC' , '��������� ���������� �������� ������ �� ����� � ���������� (���� �������� ����� �� ��������� � ������� &quot;����.����&quot;?)');
define('CURRENT_TEMPLATE_TITLE' , '�������');
define('CURRENT_TEMPLATE_DESC' , '�������� �������� ������ ��� ������ ��������. ������� ���������: www.Your-Domain.com/templates/');

define('CC_KEYCHAIN_TITLE','�� ������');
define('CC_KEYCHAIN_DESC','������ ��� ���������� ��������� ����� (CC number) (����������, ��������!)');

define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE' , '���');
define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC' , '����������� ����� ��� �����');
define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE' , '�������');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC' , '����������� ����� ��� �������');
define('ENTRY_DOB_MIN_LENGTH_TITLE' , '���� ��������');
define('ENTRY_DOB_MIN_LENGTH_DESC' , '����������� ����� ��� ���� ��������');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE' , 'E-Mail �����');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC' , '����������� ����� ��� E-Mail ������');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE' , '�����');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC' , '����������� ����� ��� ������');
define('ENTRY_COMPANY_MIN_LENGTH_TITLE' , '��������');
define('ENTRY_COMPANY_MIN_LENGTH_DESC' , '����������� ����� ��� �������� ��������');
define('ENTRY_POSTCODE_MIN_LENGTH_TITLE' , '������');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC' , '����������� ����� ��� �������. ���� �������� ������, �� ���� ����� �� ������������.');
define('ENTRY_CITY_MIN_LENGTH_TITLE' , '�����');
define('ENTRY_CITY_MIN_LENGTH_DESC' , '����������� ����� ��� ������. ���� �������� ������, �� ���� ����� �� ������������.');
define('ENTRY_STATE_MIN_LENGTH_TITLE' , '�������');
define('ENTRY_STATE_MIN_LENGTH_DESC' , '����������� ����� ��� �������');
define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE' , '�������');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC' , '����������� ����� ��� ��������');
define('ENTRY_PASSWORD_MIN_LENGTH_TITLE' , '������');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC' , '����������� ����� ��� ������');

define('CC_OWNER_MIN_LENGTH_TITLE' , '�������� ��������� �����');
define('CC_OWNER_MIN_LENGTH_DESC' , '����������� ����� ��� ����� ���������');
define('CC_NUMBER_MIN_LENGTH_TITLE' , '����� ��������� �����');
define('CC_NUMBER_MIN_LENGTH_DESC' , '����������� ����� ��� ������ ��������� �����');

define('REVIEW_TEXT_MIN_LENGTH_TITLE' , '����� ������');
define('REVIEW_TEXT_MIN_LENGTH_DESC' , '����������� ����� ��� ������');

define('MIN_DISPLAY_BESTSELLERS_TITLE' , '������ ������');
define('MIN_DISPLAY_BESTSELLERS_DESC' , '����������� �������� ��� ������ ������');
define('MIN_DISPLAY_ALSO_PURCHASED_TITLE' , '����� ��������');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC' , '����������� ����� ��� �������� � ����� &quot;���� ������� ����� ��������&quot;');

define('MAX_ADDRESS_BOOK_ENTRIES_TITLE' , '������ � �������� �����');
define('MAX_ADDRESS_BOOK_ENTRIES_DESC' , '������������ ���������� ������� � �������� ����� ����������');
define('MAX_DISPLAY_SEARCH_RESULTS_TITLE' , '���������� ������');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC' , '����� ���������� ������� ����� ������ �� ��������');
define('MAX_DISPLAY_PAGE_LINKS_TITLE' , '������ �� ��������');
define('MAX_DISPLAY_PAGE_LINKS_DESC' , '���������� ������ �� ������ ��������');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE' , '����������� ����');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC' , '������������ ���������� ������ ��� ������');
define('MAX_DISPLAY_NEW_PRODUCTS_TITLE' , '�������');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC' , '������������ ���������� ������� �� �������');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE' , '��������� ������');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC' , '������������ ���������� ��������� ������� ��� ������');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE' , '�������������');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC' , '������������ � ����� �������������; ���� ����� ����������� ��������� ������������� �����, ����� ����� ��������� &quot;����-����&quot; ���� ������ ������');
define('MAX_MANUFACTURERS_LIST_TITLE' , '����������� ��������������');
define('MAX_MANUFACTURERS_LIST_DESC' , '������������ � ����� ��������������, ����� &quot;����-����&quot; ����. ������ �������� ����� ������ �� ������ ���� &lt;select&gt;, � ��������� size=&quot;�����&quot;.');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE' , '�������� �������������');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC' , '������������ ����� �������� � ����� �������������. ���� ����� ����� ���������, �� �������� ���������.');
define('MAX_DISPLAY_NEW_REVIEWS_TITLE' , '����� ������');
define('MAX_DISPLAY_NEW_REVIEWS_DESC' , '������������ ���������� ������������ �������');
define('MAX_RANDOM_SELECT_REVIEWS_TITLE' , '����� ���������� ������ �������');
define('MAX_RANDOM_SELECT_REVIEWS_DESC' , '�� ������ ���������� �������� ��������� ����� �������');
define('MAX_RANDOM_SELECT_NEW_TITLE' , '����� ���������� ������ �������');
define('MAX_RANDOM_SELECT_NEW_DESC' , '�� ������ ���������� �������� ��������� ����� �������');
define('MAX_RANDOM_SELECT_SPECIALS_TITLE' , '����� ���������� ������ ������');
define('MAX_RANDOM_SELECT_SPECIALS_DESC' , '�� ������ ���������� �������� ��������� ����� ������');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE' , '���������� ��������� � ������');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC' , '������������ ���������� ��������� � ������');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE' , '������� �������');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC' , '������������ ���������� ������� �� �������� �������');
define('MAX_DISPLAY_BESTSELLERS_TITLE' , '������ ������');
define('MAX_DISPLAY_BESTSELLERS_DESC' , '������������ ���������� ������� � ����� ������� ������');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE' , '����� ��������');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC' , '������������ ���������� ������� � ����� &quot;���� ���������� ����� ��������&quot;');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE' , '���� ������� ������� ���������� ');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC' , '������������ ���������� ������� � ����� �������');
define('MAX_DISPLAY_ORDER_HISTORY_TITLE' , '������� �������');
define('MAX_DISPLAY_ORDER_HISTORY_DESC' , '������������ ���������� ������� �� �������� ������� �������');
define('MAX_PRODUCTS_QTY_TITLE', '������������ ���������� �������');
define('MAX_PRODUCTS_QTY_DESC', '������������ ���������� ���������� ������� � ������� ����������');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_TITLE' , '������������ ���������� ���� ��� ������ ������');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_DESC' , '������� ���� ����� ����� ��������� ����� � ����� ������������ � ����� �������');


define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_TITLE' , '������ ��������� �� �������� ������');
define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_DESC' , '������ ��������� �� �������� ������ � �������� ');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_TITLE' , '������ ��������� �� �������� ������');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_DESC' , '������ ��������� �� �������� ������ � ��������');

define('PRODUCT_IMAGE_INFO_WIDTH_TITLE' , '������ �������� �� �������� ������');
define('PRODUCT_IMAGE_INFO_WIDTH_DESC' , '������ �������� �� �������� ������ � ��������');
define('PRODUCT_IMAGE_INFO_HEIGHT_TITLE' , '������ �������� �� �������� ������');
define('PRODUCT_IMAGE_INFO_HEIGHT_DESC' , '������ �������� �� �������� ������ � ��������');

define('PRODUCT_IMAGE_POPUP_WIDTH_TITLE' , '������ POP-UP ��������');
define('PRODUCT_IMAGE_POPUP_WIDTH_DESC' , '������ POP-UP �������� � �������� (����. <b>300</b>). ���� �������� �������� ������, �� �������� �� ����� ������� ������!');
define('PRODUCT_IMAGE_POPUP_HEIGHT_TITLE' , '������ POP-UP ��������');
define('PRODUCT_IMAGE_POPUP_HEIGHT_DESC' , '������ POP-UP �������� � ��������');

define('SMALL_IMAGE_WIDTH_TITLE' , '������ ������ ��������');
define('SMALL_IMAGE_WIDTH_DESC' , '������ ������ �������� (� ��������)');
define('SMALL_IMAGE_HEIGHT_TITLE' , '������ ������ ��������');
define('SMALL_IMAGE_HEIGHT_DESC' , '������ ������ �������� (� ��������)');

define('HEADING_IMAGE_WIDTH_TITLE' , '������ �������� ���������');
define('HEADING_IMAGE_WIDTH_DESC' , '������ �������� ��������� (� ��������)');
define('HEADING_IMAGE_HEIGHT_TITLE' , '������ �������� ���������');
define('HEADING_IMAGE_HEIGHT_DESC' , '������ �������� ��������� (� ��������)');

define('SUBCATEGORY_IMAGE_WIDTH_TITLE' , '������ �������� ������������');
define('SUBCATEGORY_IMAGE_WIDTH_DESC' , '������ �������� ������������ (� ��������)');
define('SUBCATEGORY_IMAGE_HEIGHT_TITLE' , '������ �������� ������������');
define('SUBCATEGORY_IMAGE_HEIGHT_DESC' , '������ �������� ������������ (� ��������)');

define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE' , '��������� ������ ��������');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC' , '��������� ������ ��������?');

define('IMAGE_REQUIRED_TITLE' , '�������� �������� � ����� ������');
define('IMAGE_REQUIRED_DESC' , '������������ ��� ����������.');

//This is for the Images showing your products for preview. All the small stuff.

define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_TITLE' , '��������� ������:Bevel<br /><img src="images/config_bevel.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_DESC' , '��������� ������:Bevel<br /><br />�� ���������: (8,FFCCCC,330000)<br /><br />���������� ��������� ����<br />������������:<br />(���� ������,hex ������ ����,hex ������ ����)');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_TITLE' , '��������� ������:Greyscale<br /><img src="images/config_greyscale.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_DESC' , '��������� ������:Greyscale<br /><br />�� ���������: (32,22,22)<br /><br />basic black n white<br />������������:<br />(int red,int green,int blue)');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_TITLE' , '��������� ������:Ellipse<br /><img src="images/config_eclipse.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_DESC' , '��������� ������:Ellipse<br /><br />�� ���������: (FFFFFF)<br /><br />ellipse on bg colour<br />������������:<br />(hex background colour)');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_TITLE' , '��������� ������:Round-edges<br /><img src="images/config_edge.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_DESC' , '��������� ������:Round-edges<br /><br />�� ���������: (5,FFFFFF,3)<br /><br />corner trimming<br />������������:<br />(edge_radius,background colour,anti-alias width)');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_TITLE' , '��������� ������:Merge<br /><img src="images/config_merge.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_DESC' , '��������� ������:Merge<br /><br />�� ���������: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />������������:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity, transparent colour on merge image)');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_TITLE' , '��������� ������:Frame<br /><img src="images/config_frame.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_DESC' , '��������� ������:Frame<br /><br />�� ���������: <br /><br />plain raised border<br />������������:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_TITLE' , '��������� ������:Drop-Shadow<br /><img src="images/config_shadow.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_DESC' , '��������� ������:Drop-Shadow<br /><br />�� ���������: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />������������:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_TITLE' , '��������� ������:Motion-Blur<br /><img src="images/config_motion.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_DESC' , '��������� ������:Motion-Blur<br /><br />�� ���������: (4,FFFFFF)<br /><br />fading parallel lines<br />������������:<br />(int number of lines,hex background colour)');

//And this is for the Images showing your products in single-view

define('PRODUCT_IMAGE_INFO_BEVEL_TITLE' , '�������� ������-��������:Bevel');
define('PRODUCT_IMAGE_INFO_BEVEL_DESC' , '�������� ������-��������:Bevel<br /><br />�� ���������: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />������������:<br />(edge width, hex light colour, hex dark colour)');
define('PRODUCT_IMAGE_INFO_GREYSCALE_TITLE' , '�������� ������-��������:Greyscale');
define('PRODUCT_IMAGE_INFO_GREYSCALE_DESC' , '�������� ������-��������:Greyscale<br /><br />�� ���������: (32,22,22)<br /><br />basic black n white<br />������������:<br />(int red, int green, int blue)');
define('PRODUCT_IMAGE_INFO_ELLIPSE_TITLE' , '�������� ������-��������:Ellipse');
define('PRODUCT_IMAGE_INFO_ELLIPSE_DESC' , '�������� ������-��������:Ellipse<br /><br />�� ���������: (FFFFFF)<br /><br />ellipse on bg colour<br />������������:<br />(hex background colour)');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_TITLE' , '�������� ������-��������:Round-edges');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_DESC' , '�������� ������-��������:Round-edges<br /><br />�� ���������: (5,FFFFFF,3)<br /><br />corner trimming<br />������������:<br />( edge_radius, background colour, anti-alias width)');
define('PRODUCT_IMAGE_INFO_MERGE_TITLE' , '�������� ������-��������:Merge');
define('PRODUCT_IMAGE_INFO_MERGE_DESC' , '�������� ������-��������:Merge<br /><br />�� ���������: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />������������:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('PRODUCT_IMAGE_INFO_FRAME_TITLE' , '�������� ������-��������:Frame');
define('PRODUCT_IMAGE_INFO_FRAME_DESC' , '�������� ������-��������:Frame<br /><br />�� ���������: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />������������:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_TITLE' , '�������� ������-��������:Drop-Shadow');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_DESC' , '�������� ������-��������:Drop-Shadow<br /><br />�� ���������: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />������������:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_TITLE' , '�������� ������-��������:Motion-Blur');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_DESC' , '�������� ������-��������s:Motion-Blur<br /><br />�� ���������: (4,FFFFFF)<br /><br />fading parallel lines<br />������������:<br />(int number of lines,hex background colour)');

//so this image is the biggest in the shop this

define('PRODUCT_IMAGE_POPUP_BEVEL_TITLE' , '�������� ������-�O�UP ��������:Bevel');
define('PRODUCT_IMAGE_POPUP_BEVEL_DESC' , '�������� ������-�O�UP ��������:Bevel<br /><br />�� ���������: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />������������:<br />(edge width,hex light colour,hex dark colour)');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_TITLE' , '�������� ������-�O�UP ��������:Greyscale');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_DESC' , '�������� ������-�O�UP ��������:Greyscale<br /><br />�� ���������: (32,22,22)<br /><br />basic black n white<br />������������:<br />(int red,int green,int blue)');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_TITLE' , '�������� ������-�O�UP ��������:Ellipse');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_DESC' , '�������� ������-�O�UP ��������:Ellipse<br /><br />�� ���������: (FFFFFF)<br /><br />ellipse on bg colour<br />������������:<br />(hex background colour)');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_TITLE' , '�������� ������-�O�UP ��������:Round-edges');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_DESC' , '�������� ������-�O�UP ��������:Round-edges<br /><br />�� ���������: (5,FFFFFF,3)<br /><br />corner trimming<br />������������:<br />(edge_radius,background colour,anti-alias width)');
define('PRODUCT_IMAGE_POPUP_MERGE_TITLE' , '�������� ������-�O�UP ��������:Merge');
define('PRODUCT_IMAGE_POPUP_MERGE_DESC' , '�������� ������-�O�UP ��������:Merge<br /><br />�� ���������: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />������������:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('PRODUCT_IMAGE_POPUP_FRAME_TITLE' , '�������� ������-�O�UP ��������:Frame');
define('PRODUCT_IMAGE_POPUP_FRAME_DESC' , '�������� ������-�O�UP ��������:Frame<br /><br />�� ���������: <br /><br />plain raised border<br />������������:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_TITLE' , '�������� ������-�O�UP ��������:Drop-Shadow');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_DESC' , '�������� ������-�O�UP ��������:Drop-Shadow<br /><br />�� ���������: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Usage:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_TITLE' , '�������� ������-�O�UP ��������:Motion-Blur');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_DESC' , '�������� ������-�O�UP ��������:Motion-Blur<br /><br />�� ���������: (4,FFFFFF)<br /><br />fading parallel lines<br />������������:<br />(int number of lines,hex background colour)');

define('MO_PICS_TITLE','���-�� �������� � ��������');
define('MO_PICS_DESC','���� ���-�� ������������ > 0 (����� ����), �� ������� ��������� � ���������� ������ �������� � ������');

define('IMAGE_MANIPULATOR_TITLE','GDlib ���������');
define('IMAGE_MANIPULATOR_DESC','����������� ����������� ��� ���������� GD2 ��� GD1');

define('ACCOUNT_GENDER_TITLE' , '���');
define('ACCOUNT_GENDER_DESC' , '���������� ��� � ���������� ������');
define('ACCOUNT_DOB_TITLE' , '���� ��������');
define('ACCOUNT_DOB_DESC' , '���������� ���� �������� � ���������� ������');
define('ACCOUNT_COMPANY_TITLE' , '��������');
define('ACCOUNT_COMPANY_DESC' , '���������� �������� � ���������� ������');
define('ACCOUNT_SUBURB_TITLE' , '����� (Suburb)');
define('ACCOUNT_SUBURB_DESC' , '����������/����������� ����� (Suburb) � ���������� ������');
define('ACCOUNT_STATE_TITLE' , '������ (State)');
define('ACCOUNT_STATE_DESC' , '����������/������ (State) � ���������� ������');

define('DEFAULT_CURRENCY_TITLE' , '������ �� ���������');
define('DEFAULT_CURRENCY_DESC' , '������ ������������ �� ���������');
define('DEFAULT_LANGUAGE_TITLE' , '���� �� ���������');
define('DEFAULT_LANGUAGE_DESC' , '���� ������������ �� ���������');
define('DEFAULT_ORDERS_STATUS_ID_TITLE' , '������ ������ �� ���������');
define('DEFAULT_ORDERS_STATUS_ID_DESC' , '������ ������ ������ �� ���������');

define('SHIPPING_ORIGIN_COUNTRY_TITLE' , '������ ��������');
define('SHIPPING_ORIGIN_COUNTRY_DESC' , '�������� ������ ��� ��������� �������. ������������ ��� ��������.');
define('SHIPPING_ORIGIN_ZIP_TITLE' , '�������� ������ ��������');
define('SHIPPING_ORIGIN_ZIP_DESC' , '������� �������� ������ ��������. ������������ ��� ��������.');
define('SHIPPING_MAX_WEIGHT_TITLE' , '������������ ��� ��������');
define('SHIPPING_MAX_WEIGHT_DESC' , '�������� ������ ����� ����������� �� ��� ��� ��������� �������. ���� �������� ����� ����� �� ��� ������. (��. <a href="http://www.russianpost.ru/resp_engine.asp?Path=RU/Home/Tariffs/localmes" target="_blank" title="� ����� ���� www.russianpost.ru...">����� ������. ���������� �������� �����������</a>)');
define('SHIPPING_BOX_WEIGHT_TITLE' , '��� ��������');
define('SHIPPING_BOX_WEIGHT_DESC' , '������� ��� �� ��������� �� ������� ��������?');
define('SHIPPING_BOX_PADDING_TITLE' , '���������� ���������� �����');
define('SHIPPING_BOX_PADDING_DESC' , '���������� ���������� �����. ��� 10% �������� 10');
define('SHOW_SHIPPING_DESC' , '���������� ���� ��������� �������� �� ���. ������');
define('SHOW_SHIPPING_TITLE' , '��������� �������� �� ���. ������');
define('SHIPPING_INFOS_DESC' , 'Group ID of shippingcosts content.');
define('SHIPPING_INFOS_TITLE' , 'Group ID');

define('PRODUCT_LIST_FILTER_TITLE' , '���������� ������ ���������/�������������');
define('PRODUCT_LIST_FILTER_DESC' , '���������� � ����������/�������������� ������ �� ����������/��������������?<br />1=��; 0=���');

define('STOCK_CHECK_TITLE' , '�������� ������');
define('STOCK_CHECK_DESC' , '��������� ������� ������ �� ������');

define('ATTRIBUTE_STOCK_CHECK_TITLE' , '�������� ��������� �� ������');
define('ATTRIBUTE_STOCK_CHECK_DESC' , '��������� ������� ��������� ������ �� ������');

define('STOCK_LIMITED_TITLE' , '�������� �� ������');
define('STOCK_LIMITED_DESC' , '�������� ����� �� ������');
define('STOCK_ALLOW_CHECKOUT_TITLE' , '��������� ����������');
define('STOCK_ALLOW_CHECKOUT_DESC' , '��������� ���������� ������ �� ������');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE' , '�������� ������ ������� ��� �� ������');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC' , '����� ����� ������, ��� ����� ���������� ������, ������� ��� �� ������');
define('STOCK_REORDER_LEVEL_TITLE' , '���-�� ������ ����� ����������');
define('STOCK_REORDER_LEVEL_DESC' , '���-�� ������ �� ������ ����� ����������');

define('STORE_PAGE_PARSE_TIME_TITLE' , '��������� ����� �������� �������');
define('STORE_PAGE_PARSE_TIME_DESC' , '��������� ����� �������� �������');
define('STORE_PAGE_PARSE_TIME_LOG_TITLE' , '���-����');
define('STORE_PAGE_PARSE_TIME_LOG_DESC' , '������ (����������) ���� �� ���-�����');
define('STORE_PARSE_DATE_TIME_FORMAT_TITLE' , '������ ���� ����');
define('STORE_PARSE_DATE_TIME_FORMAT_DESC' , '������ ����');

define('DISPLAY_PAGE_PARSE_TIME_TITLE' , '���������� ����� �������� �������');
define('DISPLAY_PAGE_PARSE_TIME_DESC' , '���������� ����� �������� ������� (����� ��������� ����� �������� ������ ���� ��������).');

define('STORE_DB_TRANSACTIONS_TITLE' , '��������� ������� � ���� ������');
define('STORE_DB_TRANSACTIONS_DESC' , '��������� ������� � ���� ������ � ���� �������� ������� (������ ��� PHP4)');

define('USE_CACHE_TITLE' , '������������ ���');
define('USE_CACHE_DESC' , '������������ ����������� �������. ���� ���� ���������� �����, ������������� ���������� ���� ����������� ��������.');

define('DB_CACHE_TITLE','����������� �������� � ��');
define('DB_CACHE_DESC','���� ���������� true, ������� ����� ���������� ������� SELECT, ��� �������� �������� ��������� � ��');

define('DIR_FS_CACHE_TITLE' , '��������� ���');
define('DIR_FS_CACHE_DESC' , '������� ��� ����� ����������� ��� �����. ���� � �������� ���������� � '. DIR_FS_DOCUMENT_ROOT);

define('ACCOUNT_OPTIONS_TITLE','��� �����������');
define('ACCOUNT_OPTIONS_DESC','��� ����� ���������������� ����������?<br />�� ������ ������� ����� ������������ ������� � ����������� ������ � �� (<b>account</b>) ���� ����������� �������� ����� (<b>guest</b>) ��� ���������� ������ (������ � ������� ����������, �� ������ �� ����� ������������).<br />����� ������� ��� (<b>both</b>) �������.');

define('EMAIL_TRANSPORT_TITLE' , '������ E-Mail ��������');
define('EMAIL_TRANSPORT_DESC' , '����� ������ sendmail. �������� ����� ����� ������� �� Windows � MacOS ����������� ����� SMTP.');

define('EMAIL_LINEFEED_TITLE' , '������� ������ � ������� (E-Mail)');
define('EMAIL_LINEFEED_DESC' , '���������� ����������� ��� ���������� ����� (LF ��� ��� Unix, CRLF ��� Windows).');
define('EMAIL_USE_HTML_TITLE' , '������������ HTML ��� �������� �����');
define('EMAIL_USE_HTML_DESC' , '������� e-mail � HTML �������');
define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE' , '��������� E-Mail ������ ����� DNS');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC' , '��������� E-Mail ������ ����� DNS');
define('SEND_EMAILS_TITLE' , '�������� E-Mail');
define('SEND_EMAILS_DESC' , '���������� ������');
define('SENDMAIL_PATH_TITLE' , '���� � sendmail');
define('SENDMAIL_PATH_DESC' , '���� �� ����������� ����� sendmail, �� ��������� ���������� ���� (�� ���������: /usr/bin/sendmail):');
define('SMTP_MAIN_SERVER_TITLE' , '����� SMTP �������');
define('SMTP_MAIN_SERVER_DESC' , '');
define('SMTP_BACKUP_SERVER_TITLE' , '����� SMTP Backup Server�');
define('SMTP_BACKUP_SERVER_DESC' , '');
define('SMTP_USERNAME_TITLE' , 'SMTP Username');
define('SMTP_USERNAME_DESC' , '');
define('SMTP_PASSWORD_TITLE' , 'SMTP Password');
define('SMTP_PASSWORD_DESC' , '');
define('SMTP_AUTH_TITLE' , 'SMTP AUTH');
define('SMTP_AUTH_DESC' , '����� �� �������������� �� SMTP?');
define('SMTP_PORT_TITLE' , 'SMTP ����');
define('SMTP_PORT_DESC' , '(�� ���������: 25)');

//Constants for contact_us
define('CONTACT_US_EMAIL_ADDRESS_TITLE' , '�������� (Contact Us) - E-Mail �����');
define('CONTACT_US_EMAIL_ADDRESS_DESC' , '����������, ������� E-Mail �����, �� ������� ����� ���������� ������ �� �������� ��� �������� � �����, ����� ����������� ����� Contact Us � ��� ����. <p>��� ���� ���������� ���������!');
define('CONTACT_US_NAME_TITLE' , '�������� (Contact Us) - ��� ����������');
define('CONTACT_US_NAME_DESC' , '����������, ������� ��� (����: ����) �� ������� ����� ���������� ������ �� �������� ��� �������� � �����, ����� ����������� ����� Contact Us. <p>����� �������� �������� �������� ���, �������� ���������� ���� (���). � �������� ��������� ���� ���� ����� ��������� ���: <b>Name of Shop (info@your_site.com)</b> <p>��� ���� ����� �������� ������.');
define('CONTACT_US_FORWARDING_STRING_TITLE' , '�������� - ������ ������������� (����� �������)');
define('CONTACT_US_FORWARDING_STRING_DESC' , '������� �mail ������ (����: ������� �����) ����������� ������� �� ������� ����� ����� ������������ ������ �� �������� ��� �������� � �����, ����� ����������� ����� Contact Us. <p>��� ���� ����� �������� ������.');
define('CONTACT_US_REPLY_ADDRESS_TITLE' , '�������� (Contact Us) - ����� ��� �������');
define('CONTACT_US_REPLY_ADDRESS_DESC' , '����������, ������� E-Mail �����, �� ������� ������� ����� ��������. � �������� ��������� ��� ���� <b>�������� �����</b>. <p>��� ���� �� ������������� ���������.');
define('CONTACT_US_REPLY_ADDRESS_NAME_TITLE' , '�������� (Contact Us) - ��� �����������');
define('CONTACT_US_REPLY_ADDRESS_NAME_DESC' , '��� � �������� ������. ����� ������� �������� ��������. <p>��� ���� ������ ��������� ���� �� ��������� ���� ����� ��� �������.');
define('CONTACT_US_EMAIL_SUBJECT_TITLE' , '�������� (Contact Us) - ���� ������');
define('CONTACT_US_EMAIL_SUBJECT_DESC' , '������� ���� ������� ����� � ������� ��� �������� � �����, ����� ����������� ����� Contact Us � ��� ����. <p>��� ���� ������������� ���������.');

//Constants for support system
define('EMAIL_SUPPORT_ADDRESS_TITLE' , '������ ��������� - E-Mail �����');
define('EMAIL_SUPPORT_ADDRESS_DESC' , '������� email ����� ��� ����� � <b>������ ���������</b> (�������� ��� �������� ������, ������ ������).');
define('EMAIL_SUPPORT_NAME_TITLE' , '������ ��������� - ��� ����������');
define('EMAIL_SUPPORT_NAME_DESC' , '������� ��������  <b>������ ���������</b> (�������� ��� �������� ������ , ������ ������).');
define('EMAIL_SUPPORT_FORWARDING_STRING_TITLE' , '������ ��������� - ������ ������������� (����� �������)');
define('EMAIL_SUPPORT_FORWARDING_STRING_DESC' , '������� �mail ������ (����: ������� �����) ����������� ������� �� ������� ����� ����� ������������ ������ � <b>������ ���������</b>.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_TITLE' , '������ ��������� - ����� ��� �������');
define('EMAIL_SUPPORT_REPLY_ADDRESS_DESC' , 'Please enter an eMail adress for replies of your customers.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_TITLE' , '������ ��������� - ����� �� ��������������� ������, ���');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_DESC' , 'Please enter a sender name for the eMail adress for replies of your customers.');
define('EMAIL_SUPPORT_SUBJECT_TITLE' , '������ ��������� - ���� ������');
define('EMAIL_SUPPORT_SUBJECT_DESC' , '������� ���� ��� ����� � <b>������ ���������</b> �� ��������.');

//Constants for Billing system
define('EMAIL_BILLING_ADDRESS_TITLE' , 'Billing ������ ��������� ������ - E-Mail �����');
define('EMAIL_BILLING_ADDRESS_DESC' , '������� email ����� ��� <b>������ ��������� ������</b> (������������ ������, ��������� �������,..).');
define('EMAIL_BILLING_NAME_TITLE' , 'Billing ������ ��������� ������ - ��� ����������');
define('EMAIL_BILLING_NAME_DESC' , '������� ��������  <b>������ ��������� ������</b> (������������� ������, ��������� �������...).');
define('EMAIL_BILLING_FORWARDING_STRING_TITLE' , 'Billing ������ ��������� ������ - ����� �� ���. �����. ����� ������ � �������');
define('EMAIL_BILLING_FORWARDING_STRING_DESC' , '������� �������������� ������ ��� <b>������ ��������� ������</b> (������������ ������, ��������� �������,..) ����� �������<p>� ���� ��� �����, �� ������� ���������� ����� ������, �.�. ����� �������� ������ � �������. ������� email ������ ������.');
define('EMAIL_BILLING_REPLY_ADDRESS_TITLE' , 'Billing ������ ��������� ������ - ����� �� ��������������� ������');
define('EMAIL_BILLING_REPLY_ADDRESS_DESC' , '������� ��������������  email ����� ���������� ������ ��� ��������');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_TITLE' , 'Billing ������ ��������� ������ - ������ �� �������������� �������, ���');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_DESC' , '������� ��� ��� ��������������� ������, ����������� ������ ��� ��������.');
define('EMAIL_BILLING_SUBJECT_TITLE' , 'Billing ������ ��������� ������ - ���� ������');
define('EMAIL_BILLING_SUBJECT_DESC' , '������� ���� ��� ������ � <b>������ ��������� ������</b>');
define('EMAIL_BILLING_SUBJECT_ORDER_TITLE','Billing ������ ��������� ������ - ���� � ��������� ������');
define('EMAIL_BILLING_SUBJECT_ORDER_DESC','������� ���� � ��������� ��� ������ � <b>������ ��������� ������</b> ������������ �� ��������. (�������� <b>��� ����� {$nr},{$date}</b>) ����������: �� ������ ������������, {$nr},{$date},{$firstname},{$lastname}');


define('DOWNLOAD_ENABLED_TITLE' , '���������� ���������');
define('DOWNLOAD_ENABLED_DESC' , '��������� ������� ������� ����������.');
define('DOWNLOAD_BY_REDIRECT_TITLE' , '�������� ����� ��������');
define('DOWNLOAD_BY_REDIRECT_DESC' , '������������ �������� ��� ����������. �� �������� � ��-Unix ��������.');
define('DOWNLOAD_MAX_DAYS_TITLE' , '��������� ����� ������ ��� ���������� (���)');
define('DOWNLOAD_MAX_DAYS_DESC' , '���������� ���/�� ���� ����������� ��� ����������. 0 - ��������.');
define('DOWNLOAD_MAX_COUNT_TITLE' , '������������ ���/�� ����������');
define('DOWNLOAD_MAX_COUNT_DESC' , '���������� ������������ ���/�� ����������. 0 - ��������');

define('GZIP_COMPRESSION_TITLE' , '��������� GZip ����������');
define('GZIP_COMPRESSION_DESC' , '��������� HTTP GZip ����������.');
define('GZIP_LEVEL_TITLE' , '������� ���������');
define('GZIP_LEVEL_DESC' , '������ ������ �� 0 �� 9 (0 = �������, 9 = ��������).');

define('SESSION_WRITE_DIRECTORY_TITLE' , '���������� ������');
define('SESSION_WRITE_DIRECTORY_DESC' , '���� ������ �������� � ������ �� ������� ���� � ���� ����������. ����. <b>tmp_sess</b>');
define('SESSION_FORCE_COOKIE_USE_TITLE' , '�������������� Cookie �������������');
define('SESSION_FORCE_COOKIE_USE_DESC' , '�������������� ������������� cookies �� �������� ������. ���� ������ ��� ���, �� ������ �� ������. ��������� ������ ���� ���� ��� �������.');
define('SESSION_CHECK_SSL_SESSION_ID_TITLE' , '�������� SSL ������ ID');
define('SESSION_CHECK_SSL_SESSION_ID_DESC' , '��������� SSL_SESSION_ID ��� ������ ���������� ������� �������� HTTPS.');
define('SESSION_CHECK_USER_AGENT_TITLE' , '�������� ���� ������ � ������');
define('SESSION_CHECK_USER_AGENT_DESC' , '��������� ���������� ������� ��� ������ ������� ��������. ��������� ������������� ������������, �� ������ ���� ������������ ���������� ������ ����� ����������� � ����-�����.');
define('SESSION_CHECK_IP_ADDRESS_TITLE' , '�������� IP ������ � ������');
define('SESSION_CHECK_IP_ADDRESS_DESC' , '��������� ���������� IP ����� ��� ������ ������� ��������. ��������� ������������� ������������, �� ������ ���� ������������ ���������� ������ ����� ����������� � IP-����� �������.');
define('SESSION_RECREATE_TITLE' , '������������ ������');
define('SESSION_RECREATE_DESC' , '������������ ������ ��� ����� ������� � ������� ���� ��� ����������� (������ ��� PHP >=4.1).');

define('DISPLAY_CONDITIONS_ON_CHECKOUT_TITLE' , '���������� ���������� � ��������� ��� ���������� ������?');
define('DISPLAY_CONDITIONS_ON_CHECKOUT_DESC' , '��� ���������� ������, ������� ����� �������� ���������� � ���������, ������� ���������� ����� �����������, ����� �� �� ������ ������� �����.');

define('META_MIN_KEYWORD_LENGTH_TITLE' , '����������� meta-keyword �����');
define('META_MIN_KEYWORD_LENGTH_DESC' , '����������� ����� ������ ����� (������������� �� products description)');
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
define('MODULE_PAYMENT_INSTALLED_DESC' , '������ ������� ������ �� ������ ������ ����������� ������ � �������. ��� ����������� �������������. ��� ������������� �������������. (������: cc.php;cod.php;paypal.php)');
define('MODULE_ORDER_TOTAL_INSTALLED_TITLE' , '������������� ������');
define('MODULE_ORDER_TOTAL_INSTALLED_DESC' , '������ ������� order_total �� ������ ������ ����������� ������ � �������. ��� ����������� �������������. ��� ������������� �������������. (������: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)');
define('MODULE_SHIPPING_INSTALLED_TITLE' , '������������� ������ ��������');
define('MODULE_SHIPPING_INSTALLED_DESC' , '������ �������(������: ups.php;flat.php;item.php)');

define('CACHE_LIFETIME_TITLE','����� ����� HTML ����');
define('CACHE_LIFETIME_DESC','����� HTML ���� � ��������. �.�. ���� �� ����. �������� �������, �� �� ������� � �� ����� ���� ����� ����� ��������� ���� � ��������.');
define('CACHE_CHECK_TITLE','��������� ��������� ����');
define('CACHE_CHECK_DESC','���� true, ����� ����������� ���� �� �������� ��������� If-Modified-Since headers ������ � �������� ����������� ��������, � �������������� HTTP ��������� ���������� � ���. � ���� ������ ���������� ������ �������� �� ���� ������� �������� � �����������, � ������ �������� �����, ��� ��������� ����� ��������.');

define('DB_CACHE_EXPIRE_TITLE','����� �� ����');
define('DB_CACHE_EXPIRE_DESC','����� ����� �� ���� � ��������.');

define('PRODUCT_REVIEWS_VIEW_TITLE','������ �� �������� �������� ������');
define('PRODUCT_REVIEWS_VIEW_DESC','���������� ������� �� �������� �������� ������');

define('DELETE_GUEST_ACCOUNT_TITLE','���������� �������� �������');
define('DELETE_GUEST_ACCOUNT_DESC','���������� ������� ����� ����� ������? (���� ������ ����� ���������)');

define('USE_WYSIWYG_TITLE','WYSIWYG ��������');
define('USE_WYSIWYG_DESC','�������� WYSIWYG �������� ��� CMS � �������� �������. true=���.; false=����.');

define('PRICE_IS_BRUTTO_TITLE','������ ���� � ������');
define('PRICE_IS_BRUTTO_DESC','������������ ���� � ������� � ������');

define('PRICE_PRECISION_TITLE','�������� ���');
define('PRICE_PRECISION_DESC','�������� ��� �� X ������ ����� ����������� (����� | �������)');
define('CHECK_CLIENT_AGENT_TITLE','�� ���������� ������ � ������ ������');
define('CHECK_CLIENT_AGENT_DESC','�� ���������� ������ ��������� ��������� ������. ������ ������ � /inc/xtc_check_agent.inc.php � � /includes/spiders.txt');
define('SHOW_IP_LOG_TITLE','IP-Log ��� ���������� ������?');
define('SHOW_IP_LOG_DESC','�������� ����� &quot;��� IP-����� ��������&quot;, ��� ��������� ������?');

define('ACTIVATE_GIFT_SYSTEM_TITLE','������������ ������� ������� (GIFT_SYSTEM)');
define('ACTIVATE_GIFT_SYSTEM_DESC','������������ ������� ���������� ������� / ������������?');

define('ACTIVATE_SHIPPING_STATUS_TITLE','������ ��������');
define('ACTIVATE_SHIPPING_STATUS_DESC','���������� ������ ��������? ����� ��������� � �������� ������ �������� ����� <b>���� ��������</b>');

define('SECURITY_CODE_LENGTH_TITLE','����� ���������� ����');
define('SECURITY_CODE_LENGTH_DESC','����� ���������� ���� (� ���������� �������)');

define('IMAGE_QUALITY_TITLE','�������� ���������� ��������');
define('IMAGE_QUALITY_DESC','(0 = ������������ ������, 100 = ������ ��������, �� � ������ �������� ����� ������)');

define('GROUP_CHECK_TITLE','�������� ������� ���������� ��� ���������');
define('GROUP_CHECK_DESC','��������� ������ ����������������� ����������� � ������� ������ � ���������� ���������� ������������� �� (����� ��������� �������� ������ � ���������');

define('ACTIVATE_REVERSE_CROSS_SELLING_TITLE','�������� �����-������');
define('ACTIVATE_REVERSE_CROSS_SELLING_DESC','������������ ������� �������� ������������ ������ ����� ��������?');

define('ACTIVATE_NAVIGATOR_TITLE','�������� ��������� �� ������?');
define('ACTIVATE_NAVIGATOR_DESC','��������/��������� ��������� �� ������ �� �������� ������, (��� ������� ���������� ������ � ������� ���������� �������� ������� �������� �������� ������)');

define('QUICKLINK_ACTIVATED_TITLE','�������� ������� �������������� �����������?');
define('QUICKLINK_ACTIVATED_DESC','������� �������������� ����������� � ������.');

define('DOWNLOAD_UNALLOWED_PAYMENT_TITLE', '�� ���������� ������ ������ ��� ��������');
define('DOWNLOAD_UNALLOWED_PAYMENT_DESC', '�� ���������� ������ ������ ��� ����������. ������ ����������� ��������, ����. {banktransfer,cod,invoice,moneyorder}');
define('DOWNLOAD_MIN_ORDERS_STATUS_TITLE', '����������� ������ ������');
define('DOWNLOAD_MIN_ORDERS_STATUS_DESC', '����������� ������ ������, ����� ��������� �������.');

// Vat Check
define('STORE_OWNER_VAT_ID_TITLE' , 'VAT ID of Shop Owner');
define('STORE_OWNER_VAT_ID_DESC' , 'The VAT ID of the Shop Owner');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_TITLE' , 'Customer-group - correct VAT ID (Foreign country)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_DESC' , 'Customers-group for customers with correct VAT ID, Shop country != customers country');
define('ACCOUNT_COMPANY_VAT_CHECK_TITLE' , 'Validate VAT ID');
define('ACCOUNT_COMPANY_VAT_CHECK_DESC' , 'Validate VAT ID (check correct syntax)');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_TITLE' , 'Validate VAT ID Live');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_DESC' , 'Validate VAT ID live (if no syntax check available for country), live check will use validation gateway of germans "Bundesamt f�r Finanzen"');
define('ACCOUNT_COMPANY_VAT_GROUP_TITLE' , 'automatic pruning ?');
define('ACCOUNT_COMPANY_VAT_GROUP_DESC' , 'Set to true, the customer-group will be changed automatically if a correct VAT ID is used.');
define('ACCOUNT_VAT_BLOCK_ERROR_TITLE' , 'Allow wrong UST ID?');
define('ACCOUNT_VAT_BLOCK_ERROR_DESC' , 'Set to true, only validated VAT IDs are acceptet.');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_TITLE','Customer-group - correct VAT ID (Shop country)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_DESC','Customers-group for customers with correct VAT ID, Shop country = customers country');
// Google Conversion
define('GOOGLE_CONVERSION_TITLE','Google ������������� �����������');
define('GOOGLE_CONVERSION_DESC','����������� ������������� �������� ����� � �������');
define('GOOGLE_CONVERSION_ID_TITLE','ID ��������������');
define('GOOGLE_CONVERSION_ID_DESC','��� Google ������������� ID');
define('GOOGLE_LANG_TITLE','Google ����');
define('GOOGLE_LANG_DESC','ISO ��� �������������� ����� (ru, en, fr, de...)');

// Afterbuy
define('AFTERBUY_ACTIVATED_TITLE','Activ');
define('AFTERBUY_ACTIVATED_DESC','Activate afterbuy module');
define('AFTERBUY_PARTNERID_TITLE','Partner ID');
define('AFTERBUY_PARTNERID_DESC','Your Afterbuy Partner ID');
define('AFTERBUY_PARTNERPASS_TITLE','Partner Password');
define('AFTERBUY_PARTNERPASS_DESC','Your Partner Password for Afterbuy XML Module');
define('AFTERBUY_USERID_TITLE','User ID');
define('AFTERBUY_USERID_DESC','Your Afterbuy User ID');
define('AFTERBUY_ORDERSTATUS_TITLE','Orderstatus');
define('AFTERBUY_ORDERSTATUS_DESC','Orderstatus for exported orders');
define('AFTERBUY_URL','You will find a detailed Afterbuy info here: <a href="http://www.xt-commerce.com/modules/wfsection/dossier-65.html" target="new">http://www.xt-commerce.com/modules/wfsection/dossier-65.html</a>');

// Search-Options
define('SEARCH_IN_DESC_TITLE','����� � �������� �������');
define('SEARCH_IN_DESC_DESC','��������� ����� � �������� �������');
define('SEARCH_IN_ATTR_TITLE','����� � ��������� �������');
define('SEARCH_IN_ATTR_DESC','��������� ����� � ��������� �������');

?>