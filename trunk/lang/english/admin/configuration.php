<?php
/* -----------------------------------------------------------------------------------------
   $Id: configuration.php 1286 2005-10-07 10:10:18Z mz $   

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

define('TABLE_HEADING_CONFIGURATION_TITLE', 'Title');
define('TABLE_HEADING_CONFIGURATION_VALUE', 'Value');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
define('TEXT_INFO_DATE_ADDED', 'Date Added:');
define('TEXT_INFO_LAST_MODIFIED', 'Last Modified:');

// language definitions for config
define('STORE_NAME_TITLE' , 'Store Name');
define('STORE_NAME_DESC' , 'The name of my store');
define('STORE_OWNER_TITLE' , 'Store Owner');
define('STORE_OWNER_DESC' , 'The name of my store owner');
define('STORE_OWNER_EMAIL_ADDRESS_TITLE' , 'eMail Adress');
define('STORE_OWNER_EMAIL_ADDRESS_DESC' , 'The eMail Adress of my store owner');

define('EMAIL_FROM_TITLE' , 'eMail from');
define('EMAIL_FROM_DESC' , 'The eMail Adress used in (sent) eMails.');

define('STORE_COUNTRY_TITLE' , 'Country');
define('STORE_COUNTRY_DESC' , 'The country my store is located in <br /><br /><b>Note: Please remember to update the store zone.</b>');
define('STORE_ZONE_TITLE' , 'Zone');
define('STORE_ZONE_DESC' , 'The zone my store is located in.');

define('EXPECTED_PRODUCTS_SORT_TITLE' , 'Expected sort order');
define('EXPECTED_PRODUCTS_SORT_DESC' , 'This is the sort order used in the expected products box.');
define('EXPECTED_PRODUCTS_FIELD_TITLE' , 'Expexted sort field');
define('EXPECTED_PRODUCTS_FIELD_DESC' , 'The column to sort by in the expected products box.');

define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE' , 'Switch to default language currency');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC' , 'Automatically switch to the languages currency when it is changed.');

define('SEND_EXTRA_ORDER_EMAILS_TO_TITLE' , 'Send extra order eMails to:');
define('SEND_EXTRA_ORDER_EMAILS_TO_DESC' , 'Send extra order eMails to the following eMail adresses, in this format: Name1 &lt;eMail@adress1&gt;, Name2 &lt;eMail@adress2&gt;');

define('SEARCH_ENGINE_FRIENDLY_URLS_TITLE' , 'Use Search-Engine Safe URLs?');
define('SEARCH_ENGINE_FRIENDLY_URLS_DESC' , 'Use search-engine safe urls for all site links.');

define('DISPLAY_CART_TITLE' , 'Display Cart After Adding a Product?');
define('DISPLAY_CART_DESC' , 'Display the shopping cart after adding a product or return back to their origin?');

define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE' , 'Allow Guest To Tell a Friend?');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC' , 'Allow guests to tell a friend about a product?');

define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE' , 'Default Search Operator');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC' , 'Default search operators.');

define('STORE_NAME_ADDRESS_TITLE' , 'Store Adress and Phone');
define('STORE_NAME_ADDRESS_DESC' , 'This is the Store Name, Adress and Phone used on printable documents and displayed online.');

define('SHOW_COUNTS_TITLE' , 'Show Category Counts');
define('SHOW_COUNTS_DESC' , 'Count recursively how many products are in each category');

define('DISPLAY_PRICE_WITH_TAX_TITLE' , 'Display Prices with Tax');
define('DISPLAY_PRICE_WITH_TAX_DESC' , 'Display prices with tax included (true) or add the tax at the end (false)');

define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_TITLE' , 'Customers Status of Administration Members');
define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_DESC' , 'Choose the customers status for Members of the Administration Team!');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_TITLE' , 'Customers Status Guest');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_DESC' , 'What would be the default customers status for a guest before logged in?');
define('DEFAULT_CUSTOMERS_STATUS_ID_TITLE' , 'Customers Status for New Customers');
define('DEFAULT_CUSTOMERS_STATUS_ID_DESC' , 'What would be the default customers status for a new customer?');

define('ALLOW_ADD_TO_CART_TITLE' , 'Allow add to cart');
define('ALLOW_ADD_TO_CART_DESC' , 'Allow customers to add products into cart if groupsetting for "show prices" is set to 0');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_TITLE' , 'Allow discount on products attribute?');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_DESC' , 'Allow customers to get discount on attribute price (if main product is not a "special" product)');
define('CURRENT_TEMPLATE_TITLE' , 'Templateset (Theme)');
define('CURRENT_TEMPLATE_DESC' , 'Choose a Templateset (Theme). The Theme must be saved before in the following folder: www.Your-Domain.com/templates/');

define('CC_KEYCHAIN_TITLE','CC String');
define('CC_KEYCHAIN_DESC','String to encrypt CC number (please change!)');

define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE' , 'First Name');
define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC' , 'Minimum length of first name');
define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE' , 'Last Name');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC' , 'Minimum length of last name');
define('ENTRY_DOB_MIN_LENGTH_TITLE' , 'Date of Birth');
define('ENTRY_DOB_MIN_LENGTH_DESC' , 'Minimum length of date of birth');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE' , 'eMail Adress');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC' , 'Minimum length of eMail adress');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE' , 'Street Adress');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC' , 'Minimum length of street adress');
define('ENTRY_COMPANY_MIN_LENGTH_TITLE' , 'Company');
define('ENTRY_COMPANY_MIN_LENGTH_DESC' , 'Minimum length of company name');
define('ENTRY_POSTCODE_MIN_LENGTH_TITLE' , 'Post Code');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC' , 'Minimum length of post code');
define('ENTRY_CITY_MIN_LENGTH_TITLE' , 'City');
define('ENTRY_CITY_MIN_LENGTH_DESC' , 'Minimum length of city');
define('ENTRY_STATE_MIN_LENGTH_TITLE' , 'State');
define('ENTRY_STATE_MIN_LENGTH_DESC' , 'Minimum length of state');
define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE' , 'Telephone Number');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC' , 'Minimum length of telephone number');
define('ENTRY_PASSWORD_MIN_LENGTH_TITLE' , 'Password');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC' , 'Minimum length of password');

define('CC_OWNER_MIN_LENGTH_TITLE' , 'Credit Card Owner Name');
define('CC_OWNER_MIN_LENGTH_DESC' , 'Minimum length of credit card owner name');
define('CC_NUMBER_MIN_LENGTH_TITLE' , 'Credit Card Number');
define('CC_NUMBER_MIN_LENGTH_DESC' , 'Minimum length of credit card number');

define('REVIEW_TEXT_MIN_LENGTH_TITLE' , 'Reviews');
define('REVIEW_TEXT_MIN_LENGTH_DESC' , 'Minimum length of review text');

define('MIN_DISPLAY_BESTSELLERS_TITLE' , 'Best Sellers');
define('MIN_DISPLAY_BESTSELLERS_DESC' , 'Minimum number of best sellers to display');
define('MIN_DISPLAY_ALSO_PURCHASED_TITLE' , 'Also Purchased');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC' , 'Minimum number of products to display in the "This Customer Also Purchased" box');

define('MAX_ADDRESS_BOOK_ENTRIES_TITLE' , 'Address Book Entries');
define('MAX_ADDRESS_BOOK_ENTRIES_DESC' , 'Maximum address book entries a customer is allowed to have');
define('MAX_DISPLAY_SEARCH_RESULTS_TITLE' , 'Search Results');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC' , 'Amount of products to list');
define('MAX_DISPLAY_PAGE_LINKS_TITLE' , 'Page Links');
define('MAX_DISPLAY_PAGE_LINKS_DESC' , 'Number of "number" links use for page-sets');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE' , 'Special Products');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC' , 'Maximum number of products on special to display');
define('MAX_DISPLAY_NEW_PRODUCTS_TITLE' , 'New Products Module');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC' , 'Maximum number of new products to display in a category');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE' , 'Products Expected');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC' , 'Maximum number of products expected to display');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE' , 'Manufacturers List');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC' , 'Used in manufacturers box; when the number of manufacturers exceeds this number, a drop-down list will be displayed instead of the default list');
define('MAX_MANUFACTURERS_LIST_TITLE' , 'Manufacturers Select Size');
define('MAX_MANUFACTURERS_LIST_DESC' , 'Used in manufacturers box; when this value is "1" the classic drop-down list will be used for the manufacturers box. Otherwise, a list-box with the specified number of rows will be displayed.');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE' , 'Length of Manufacturers Name');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC' , 'Used in manufacturers box; maximum length of manufacturers name to display');
define('MAX_DISPLAY_NEW_REVIEWS_TITLE' , 'New Reviews');
define('MAX_DISPLAY_NEW_REVIEWS_DESC' , 'Maximum number of new reviews to display');
define('MAX_RANDOM_SELECT_REVIEWS_TITLE' , 'Selection of Random Reviews');
define('MAX_RANDOM_SELECT_REVIEWS_DESC' , 'How many records to select from to choose one random product review');
define('MAX_RANDOM_SELECT_NEW_TITLE' , 'Selection of Random New Products');
define('MAX_RANDOM_SELECT_NEW_DESC' , 'How many records to select from to choose one random new product to display');
define('MAX_RANDOM_SELECT_SPECIALS_TITLE' , 'Selection of Products on Special');
define('MAX_RANDOM_SELECT_SPECIALS_DESC' , 'How many records to select from to choose one random product special to display');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE' , 'Categories To List Per Row');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC' , 'How many categories to list per row');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE' , 'New Products Listing');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC' , 'Maximum number of new products to display in new products page');
define('MAX_DISPLAY_BESTSELLERS_TITLE' , 'Best Sellers');
define('MAX_DISPLAY_BESTSELLERS_DESC' , 'Maximum number of best sellers to display');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE' , 'Also Purchased');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC' , 'Maximum number of products to display in the "This Customer Also Purchased" box');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE' , 'Customer Order History Box');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC' , 'Maximum number of products to display in the customer order history box');
define('MAX_DISPLAY_ORDER_HISTORY_TITLE' , 'Order History');
define('MAX_DISPLAY_ORDER_HISTORY_DESC' , 'Maximum number of orders to display in the order history page');
define('MAX_PRODUCTS_QTY_TITLE', 'Maximum Quantity');
define('MAX_PRODUCTS_QTY_DESC', 'Maximum quantity input length');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_TITLE' , 'Maximum days for new products');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_DESC' , 'Maximum quantity of days new products to display');


define('PRODUCT_IMAGE_THUMBNAIL_ACTIVE_TITLE' , 'Allow to use GD library for Product-Thumbnails');
define('PRODUCT_IMAGE_THUMBNAIL_ACTIVE_DESC' , 'Allow to use GD library for Product-Thumbnails. If false, upload product images into images directory manually by ftp.');
define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_TITLE' , 'Width of Product-Thumbnails');
define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_DESC' , 'Maximal Width of Product-Thumbnails in Pixel');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_TITLE' , 'Height of Product-Thumbnails');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_DESC' , 'Maximal Height of Product-Thumbnails in Pixel');

define('PRODUCT_IMAGE_INFO_ACTIVE_TITLE' , 'Allow to use GD library for Product-Info Images');
define('PRODUCT_IMAGE_INFO_ACTIVE_DESC' , 'Allow to use GD library for Product-Info Images. If false, upload product images into images directory manually by ftp.');
define('PRODUCT_IMAGE_INFO_WIDTH_TITLE' , 'Width of Product-Info Images');
define('PRODUCT_IMAGE_INFO_WIDTH_DESC' , 'Maximal Width of Product-Info Images in Pixel');
define('PRODUCT_IMAGE_INFO_HEIGHT_TITLE' , 'Height of Product-Info Images');
define('PRODUCT_IMAGE_INFO_HEIGHT_DESC' , 'Maximal Height of Product-Info Images in Pixel');

define('PRODUCT_IMAGE_POPUP_ACTIVE_TITLE' , 'Allow to use GD library for Popup Images');
define('PRODUCT_IMAGE_POPUP_ACTIVE_DESC' , 'Allow to use GD library for Popup Images. If false, upload product images into images directory manually by ftp.');
define('PRODUCT_IMAGE_POPUP_WIDTH_TITLE' , 'Width of Popup Images');
define('PRODUCT_IMAGE_POPUP_WIDTH_DESC' , 'Maximal Width of Popup Images in Pixel');
define('PRODUCT_IMAGE_POPUP_HEIGHT_TITLE' , 'Height of Popup Images');
define('PRODUCT_IMAGE_POPUP_HEIGHT_DESC' , 'Maximal Height of Popup Images in Pixel');

define('SMALL_IMAGE_WIDTH_TITLE' , 'Small Image Width');
define('SMALL_IMAGE_WIDTH_DESC' , 'The pixel width of small images');
define('SMALL_IMAGE_HEIGHT_TITLE' , 'Small Image Height');
define('SMALL_IMAGE_HEIGHT_DESC' , 'The pixel height of small images');

define('HEADING_IMAGE_WIDTH_TITLE' , 'Heading Image Width');
define('HEADING_IMAGE_WIDTH_DESC' , 'The pixel width of heading images');
define('HEADING_IMAGE_HEIGHT_TITLE' , 'Heading Image Height');
define('HEADING_IMAGE_HEIGHT_DESC' , 'The pixel height of heading images');

define('SUBCATEGORY_IMAGE_WIDTH_TITLE' , 'Subcategory Image Width');
define('SUBCATEGORY_IMAGE_WIDTH_DESC' , 'The pixel width of subcategory images');
define('SUBCATEGORY_IMAGE_HEIGHT_TITLE' , 'Subcategory Image Height');
define('SUBCATEGORY_IMAGE_HEIGHT_DESC' , 'The pixel height of subcategory images');

define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE' , 'Calculate Image Size');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC' , 'Calculate the size of images?');

define('IMAGE_REQUIRED_TITLE' , 'Image Required');
define('IMAGE_REQUIRED_DESC' , 'Enable to display broken images. Good for development.');

//This is for the Images showing your products for preview. All the small stuff.

define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_TITLE' , 'Products-Thumbnails:Bevel<br /><img src="images/config_bevel.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_DESC' , 'Products-Thumbnails:Bevel<br /><br />Default-values: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Usage:<br />(edge width,hex light colour,hex dark colour)');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_TITLE' , 'Products-Thumbnails:Greyscale<br /><img src="images/config_greyscale.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_DESC' , 'Products-Thumbnails:Greyscale<br /><br />Default-values: (32,22,22)<br /><br />basic black n white<br />Usage:<br />(int red,int green,int blue)');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_TITLE' , 'Products-Thumbnails:Ellipse<br /><img src="images/config_eclipse.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_DESC' , 'Products-Thumbnails:Ellipse<br /><br />Default-values: (FFFFFF)<br /><br />ellipse on bg colour<br />Usage:<br />(hex background colour)');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_TITLE' , 'Products-Thumbnails:Round-edges<br /><img src="images/config_edge.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_DESC' , 'Products-Thumbnails:Round-edges<br /><br />Default-values: (5,FFFFFF,3)<br /><br />corner trimming<br />Usage:<br />(edge_radius,background colour,anti-alias width)');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_TITLE' , 'Products-Thumbnails:Merge<br /><img src="images/config_merge.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_DESC' , 'Products-Thumbnails:Merge<br /><br />Default-values: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Usage:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity, transparent colour on merge image)');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_TITLE' , 'Products-Thumbnails:Frame<br /><img src="images/config_frame.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_DESC' , 'Products-Thumbnails:Frame<br /><br />Default-values: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Usage:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_TITLE' , 'Products-Thumbnails:Drop-Shadow<br /><img src="images/config_shadow.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_DESC' , 'Products-Thumbnails:Drop-Shadow<br /><br />Default-values: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Usage:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_TITLE' , 'Products-Thumbnails:Motion-Blur<br /><img src="images/config_motion.gif">');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_DESC' , 'Products-Thumbnails:Motion-Blur<br /><br />Default-values: (4,FFFFFF)<br /><br />fading parallel lines<br />Usage:<br />(int number of lines,hex background colour)');

//And this is for the Images showing your products in single-view

define('PRODUCT_IMAGE_INFO_BEVEL_TITLE' , 'Product-Images:Bevel');
define('PRODUCT_IMAGE_INFO_BEVEL_DESC' , 'Product-Images:Bevel<br /><br />Default-values: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Usage:<br />(edge width, hex light colour, hex dark colour)');
define('PRODUCT_IMAGE_INFO_GREYSCALE_TITLE' , 'Product-Images:Greyscale');
define('PRODUCT_IMAGE_INFO_GREYSCALE_DESC' , 'Product-Images:Greyscale<br /><br />Default-values: (32,22,22)<br /><br />basic black n white<br />Usage:<br />(int red, int green, int blue)');
define('PRODUCT_IMAGE_INFO_ELLIPSE_TITLE' , 'Product-Images:Ellipse');
define('PRODUCT_IMAGE_INFO_ELLIPSE_DESC' , 'Product-Images:Ellipse<br /><br />Default-values: (FFFFFF)<br /><br />ellipse on bg colour<br />Usage:<br />(hex background colour)');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_TITLE' , 'Product-Images:Round-edges');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_DESC' , 'Product-Images:Round-edges<br /><br />Default-values: (5,FFFFFF,3)<br /><br />corner trimming<br />Usage:<br />( edge_radius, background colour, anti-alias width)');
define('PRODUCT_IMAGE_INFO_MERGE_TITLE' , 'Product-Images:Merge');
define('PRODUCT_IMAGE_INFO_MERGE_DESC' , 'Product-Images:Merge<br /><br />Default-values: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Usage:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('PRODUCT_IMAGE_INFO_FRAME_TITLE' , 'Product-Images:Frame');
define('PRODUCT_IMAGE_INFO_FRAME_DESC' , 'Product-Images:Frame<br /><br />Default-values: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Usage:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_TITLE' , 'Product-Images:Drop-Shadow');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_DESC' , 'Product-Images:Drop-Shadow<br /><br />Default-values: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Usage:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_TITLE' , 'Product-Images:Motion-Blur');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_DESC' , 'Product-Images:Motion-Blur<br /><br />Default-values: (4,FFFFFF)<br /><br />fading parallel lines<br />Usage:<br />(int number of lines,hex background colour)');

//so this image is the biggest in the shop this

define('PRODUCT_IMAGE_POPUP_BEVEL_TITLE' , 'Product-Popup-Images:Bevel');
define('PRODUCT_IMAGE_POPUP_BEVEL_DESC' , 'Product-Popup-Images:Bevel<br /><br />Default-values: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Usage:<br />(edge width,hex light colour,hex dark colour)');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_TITLE' , 'Product-Popup-Images:Greyscale');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_DESC' , 'Product-Popup-Images:Greyscale<br /><br />Default-values: (32,22,22)<br /><br />basic black n white<br />Usage:<br />(int red,int green,int blue)');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_TITLE' , 'Product-Popup-Images:Ellipse');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_DESC' , 'Product-Popup-Images:Ellipse<br /><br />Default-values: (FFFFFF)<br /><br />ellipse on bg colour<br />Usage:<br />(hex background colour)');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_TITLE' , 'Product-Popup-Images:Round-edges');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_DESC' , 'Product-Popup-Images:Round-edges<br /><br />Default-values: (5,FFFFFF,3)<br /><br />corner trimming<br />Usage:<br />(edge_radius,background colour,anti-alias width)');
define('PRODUCT_IMAGE_POPUP_MERGE_TITLE' , 'Product-Popup-Images:Merge');
define('PRODUCT_IMAGE_POPUP_MERGE_DESC' , 'Product-Popup-Images:Merge<br /><br />Default-values: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Usage:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('PRODUCT_IMAGE_POPUP_FRAME_TITLE' , 'Product-Popup-Images:Frame');
define('PRODUCT_IMAGE_POPUP_FRAME_DESC' , 'Product-Popup-Images:Frame<br /><br />Default-values: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Usage:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_TITLE' , 'Product-Popup-Images:Drop-Shadow');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_DESC' , 'Product-Popup-Images:Drop-Shadow<br /><br />Default-values: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Usage:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_TITLE' , 'Product-Popup-Images:Motion-Blur');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_DESC' , 'Product-Popup-Images:Motion-Blur<br /><br />Default-values: (4,FFFFFF)<br /><br />fading parallel lines<br />Usage:<br />(int number of lines,hex background colour)');

define('MO_PICS_TITLE','Number of products images');
define('MO_PICS_DESC','if this number is set > 0 , you will be able to upload/display more images per product');

define('IMAGE_MANIPULATOR_TITLE','GDlib processing');
define('IMAGE_MANIPULATOR_DESC','Image Manipulator for GD2 or GD1');

define('ACCOUNT_GENDER_TITLE' , 'Gender');
define('ACCOUNT_GENDER_DESC' , 'Display gender in the customers account');
define('ACCOUNT_DOB_TITLE' , 'Date of Birth');
define('ACCOUNT_DOB_DESC' , 'Display date of birth in the customers account');
define('ACCOUNT_COMPANY_TITLE' , 'Company');
define('ACCOUNT_COMPANY_DESC' , 'Display company in the customers account');
define('ACCOUNT_STREET_ADDRESS_TITLE' , 'Street address');
define('ACCOUNT_STREET_ADDRESS_DESC', 'Display street address in the customers account');
define('ACCOUNT_CITY_TITLE' , 'City');
define('ACCOUNT_CITY_DESC', 'Display city in the customers account');
define('ACCOUNT_POSTCODE_TITLE' , 'Postcode/ZIP');
define('ACCOUNT_POSTCODE_DESC', 'Display postcode/ZIP in the customers account');
define('ACCOUNT_COUNTRY_TITLE' , 'Country');
define('ACCOUNT_COUNTRY_DESC', 'Display country in the customers account');
define('ACCOUNT_TELE_TITLE' , 'Telephone');
define('ACCOUNT_TELE_DESC', 'Display telephone in the customers account');
define('ACCOUNT_FAX_TITLE' , 'Fax');
define('ACCOUNT_FAX_DESC', 'Display fax in the customers account');
define('ACCOUNT_SUBURB_TITLE' , 'Suburb');
define('ACCOUNT_SUBURB_DESC' , 'Display suburb in the customers account');
define('ACCOUNT_STATE_TITLE' , 'State');
define('ACCOUNT_STATE_DESC' , 'Display state in the customers account');

define('DEFAULT_CURRENCY_TITLE' , 'Default Currency');
define('DEFAULT_CURRENCY_DESC' , 'Currency which is used as default');
define('DEFAULT_LANGUAGE_TITLE' , 'Default Language');
define('DEFAULT_LANGUAGE_DESC' , 'Language which is used as default');
define('DEFAULT_ORDERS_STATUS_ID_TITLE' , 'Default Order Status');
define('DEFAULT_ORDERS_STATUS_ID_DESC' , 'Default order status when a new order is placed.');

define('SHIPPING_ORIGIN_COUNTRY_TITLE' , 'Country of Origin');
define('SHIPPING_ORIGIN_COUNTRY_DESC' , 'Select the country of origin to be used in shipping quotes.');
define('SHIPPING_ORIGIN_ZIP_TITLE' , 'Postal Code');
define('SHIPPING_ORIGIN_ZIP_DESC' , 'Enter the Postal Code (ZIP) of the Store to be used in shipping quotes.');
define('SHIPPING_MAX_WEIGHT_TITLE' , 'Enter the Maximum Package Weight you will ship');
define('SHIPPING_MAX_WEIGHT_DESC' , 'Carriers have a max weight limit for a single package. This is a common one for all.');
define('SHIPPING_BOX_WEIGHT_TITLE' , 'Package Tare weight.');
define('SHIPPING_BOX_WEIGHT_DESC' , 'What is the weight of typical packaging of small to medium packages?');
define('SHIPPING_BOX_PADDING_TITLE' , 'Larger packages - percentage increase.');
define('SHIPPING_BOX_PADDING_DESC' , 'For 10% enter 10');
define('SHOW_SHIPPING_DESC' , 'Show shippingcosts link in product infos');
define('SHOW_SHIPPING_TITLE' , 'Shippingcosts in product infos');
define('SHIPPING_INFOS_DESC' , 'Group ID of shippingcosts content.');
define('SHIPPING_INFOS_TITLE' , 'Group ID');

define('PRODUCT_LIST_FILTER_TITLE' , 'Display Category/Manufacturer Filter (0=disable; 1=enable)');
define('PRODUCT_LIST_FILTER_DESC' , 'Do you want to display the Category/Manufacturer Filter?');

define('STOCK_CHECK_TITLE' , 'Check stock level');
define('STOCK_CHECK_DESC' , 'Check to see if sufficent stock is available');

define('ATTRIBUTE_STOCK_CHECK_TITLE' , 'Check attribute-stock level');
define('ATTRIBUTE_STOCK_CHECK_DESC' , 'Check to see if sufficent attribute-stock is available');

define('STOCK_LIMITED_TITLE' , 'Subtract stock');
define('STOCK_LIMITED_DESC' , 'Subtract product in stock by product orders');
define('STOCK_ALLOW_CHECKOUT_TITLE' , 'Allow Checkout');
define('STOCK_ALLOW_CHECKOUT_DESC' , 'Allow customer to checkout even if there is insufficient stock');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE' , 'Mark product out of stock');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC' , 'Display something on screen so customer can see which product has insufficient stock');
define('STOCK_REORDER_LEVEL_TITLE' , 'Stock Re-order level');
define('STOCK_REORDER_LEVEL_DESC' , 'Define when stock needs to be re-ordered');

define('STORE_PAGE_PARSE_TIME_TITLE' , 'Store Page Parse Time');
define('STORE_PAGE_PARSE_TIME_DESC' , 'Store the time it takes to parse a page');
define('STORE_PAGE_PARSE_TIME_LOG_TITLE' , 'Log Destination');
define('STORE_PAGE_PARSE_TIME_LOG_DESC' , 'Directory and filename of the page parse time log');
define('STORE_PARSE_DATE_TIME_FORMAT_TITLE' , 'Log Date Format');
define('STORE_PARSE_DATE_TIME_FORMAT_DESC' , 'The date format');

define('DISPLAY_PAGE_PARSE_TIME_TITLE' , 'Display The Page Parse Time');
define('DISPLAY_PAGE_PARSE_TIME_DESC' , 'Display the page parse time (store page parse time must be enabled)');

define('STORE_DB_TRANSACTIONS_TITLE' , 'Store Database Queries');
define('STORE_DB_TRANSACTIONS_DESC' , 'Store the database queries in the page parse time log (PHP4 only)');

define('USE_CACHE_TITLE' , 'Use Cache');
define('USE_CACHE_DESC' , 'Use caching features');

define('DB_CACHE_TITLE','Database Caching');
define('DB_CACHE_TITLE','If set to true, Shop can cache SELECT Queries for a period of time, to increase speed');

define('DIR_FS_CACHE_TITLE' , 'Cache Directory');
define('DIR_FS_CACHE_DESC' , 'The directory where the cached files are saved');

define('ACCOUNT_OPTIONS_TITLE','Account Options');
define('ACCOUNT_OPTIONS_DESC','How do you want to manage the login management of your store ?<br />You can choose between Customer Accounts and "One Time Orders" without creating a Customer Account (an account will be created but the customer won\'t be informed about that)');

define('EMAIL_TRANSPORT_TITLE' , 'eMail Transport Method');
define('EMAIL_TRANSPORT_DESC' , 'Defines if this server uses a local connection to sendmail or uses an SMTP connection via TCP/IP. Servers running on Windows and MacOS should change this setting to SMTP.');

define('EMAIL_LINEFEED_TITLE' , 'eMail Linefeeds');
define('EMAIL_LINEFEED_DESC' , 'Defines the character sequence used to separate mail headers.');
define('EMAIL_USE_HTML_TITLE' , 'Use MIME HTML When Sending eMails');
define('EMAIL_USE_HTML_DESC' , 'Send eMails in HTML format');
define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE' , 'Verify eMail Addresses Through DNS');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC' , 'Verify eMail address through a DNS server');
define('SEND_EMAILS_TITLE' , 'Send eMails');
define('SEND_EMAILS_DESC' , 'Send out eMails');
define('SENDMAIL_PATH_TITLE' , 'The Path to sendmail');
define('SENDMAIL_PATH_DESC' , 'If you use sendmail, you should give us the right path (default: /usr/bin/sendmail):');
define('SMTP_MAIN_SERVER_TITLE' , 'Adress of the SMTP Server');
define('SMTP_MAIN_SERVER_DESC' , 'Please enter the adress of your main SMTP Server.');
define('SMTP_BACKUP_SERVER_TITLE' , 'Adress of the SMTP Backup Server');
define('SMTP_BACKUP_SERVER_DESC' , 'Please enter the adress of your Backup SMTP Server.');
define('SMTP_USERNAME_TITLE' , 'SMTP Username');
define('SMTP_USERNAME_DESC' , 'Please enter the username of your SMTP Account.');
define('SMTP_PASSWORD_TITLE' , 'SMTP Password');
define('SMTP_PASSWORD_DESC' , 'Please enter the password of your SMTP Account.');
define('SMTP_AUTH_TITLE' , 'SMTP AUTH');
define('SMTP_AUTH_DESC' , 'Does your SMTP Server needs secure authentication?');
define('SMTP_PORT_TITLE' , 'SMTP Port');
define('SMTP_PORT_DESC' , 'Please enter the SMTP port of your SMTP server(default: 25)?');

//Constants for contact_us
define('CONTACT_US_EMAIL_ADDRESS_TITLE' , 'Contact Us - eMail address');
define('CONTACT_US_EMAIL_ADDRESS_DESC' , 'Please enter an eMail Address used for normal "Contact Us" messages via shop to your office');
define('CONTACT_US_NAME_TITLE' , 'Contact Us - eMail address, name');
define('CONTACT_US_NAME_DESC' , 'Please Enter a name used for normal "Contact Us" messages sentded via shop to your office');
define('CONTACT_US_FORWARDING_STRING_TITLE' , 'Contact Us - forwaring addresses');
define('CONTACT_US_FORWARDING_STRING_DESC' , 'Please enter eMail addresses (seperated by , ) where "Contact Us" messages, sent via shop to your office, should be forwarded to.');
define('CONTACT_US_REPLY_ADDRESS_TITLE' , 'Contact Us - reply address');
define('CONTACT_US_REPLY_ADDRESS_DESC' , 'Please enter an eMail address where customers can reply to.');
define('CONTACT_US_REPLY_ADDRESS_NAME_TITLE' , 'Contact Us - reply address , name');
define('CONTACT_US_REPLY_ADDRESS_NAME_DESC' , 'Sender name for reply eMails.');
define('CONTACT_US_EMAIL_SUBJECT_TITLE' , 'Contact Us - eMail subject');
define('CONTACT_US_EMAIL_SUBJECT_DESC' , 'Please enter an eMail Subject for the contact-us messages via shop to your office.');

//Constants for support system
define('EMAIL_SUPPORT_ADDRESS_TITLE' , 'Technical Support - eMail adress');
define('EMAIL_SUPPORT_ADDRESS_DESC' , 'Please enter an eMail adress for sending eMails over the <b>Support System</b> (account creation, password changes).');
define('EMAIL_SUPPORT_NAME_TITLE' , 'Technical Support - eMail adress, name');
define('EMAIL_SUPPORT_NAME_DESC' , 'Please enter a name for sending eMails over the <b>Support System</b> (account creation, password changes).');
define('EMAIL_SUPPORT_FORWARDING_STRING_TITLE' , 'Technical Support - Forwarding adresses');
define('EMAIL_SUPPORT_FORWARDING_STRING_DESC' , 'Please enter forwarding adresses for the mails of the <b>Support System</b> (seperated by , )');
define('EMAIL_SUPPORT_REPLY_ADDRESS_TITLE' , 'Technical Support - reply adress');
define('EMAIL_SUPPORT_REPLY_ADDRESS_DESC' , 'Please enter an eMail adress for replies of your customers.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_TITLE' , 'Technical Support - reply adress, name');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_DESC' , 'Please enter a sender name for the eMail adress for replies of your customers.');
define('EMAIL_SUPPORT_SUBJECT_TITLE' , 'Technical Support - eMail subject');
define('EMAIL_SUPPORT_SUBJECT_DESC' , 'Please enter an eMail subject for the <b>Support System</b> messages via shop to your office.');

//Constants for Billing system
define('EMAIL_BILLING_ADDRESS_TITLE' , 'Billing - eMail adress');
define('EMAIL_BILLING_ADDRESS_DESC' , 'Please enter an eMail adress for sending eMails over the <b>Billing system</b> (order confirmations, status changes,..).');
define('EMAIL_BILLING_NAME_TITLE' , 'Billing - eMail adress, name');
define('EMAIL_BILLING_NAME_DESC' , 'Please enter a name for sending eMails over the <b>Billing System</b> (order confirmations, status changes,..).');
define('EMAIL_BILLING_FORWARDING_STRING_TITLE' , 'Billing - Forwarding adresses');
define('EMAIL_BILLING_FORWARDING_STRING_DESC' , 'Please enter forwarding adresses for the mails of the <b>Billing System</b> (seperated by , )');
define('EMAIL_BILLING_REPLY_ADDRESS_TITLE' , 'Billing - reply adress');
define('EMAIL_BILLING_REPLY_ADDRESS_DESC' , 'Please enter an eMail adress for replies of your customers.');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_TITLE' , 'Billing - reply adress, name');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_DESC' , 'Please enter a name for the eMail adress for replies of your customers.');
define('EMAIL_BILLING_SUBJECT_TITLE' , 'Billing - eMail subject');
define('EMAIL_BILLING_SUBJECT_DESC' , 'Please enter an eMail Subject for the <b>Billing</b> messages via shop to your office.');
define('EMAIL_BILLING_SUBJECT_ORDER_TITLE','Billing - Ordermail subject');
define('EMAIL_BILLING_SUBJECT_ORDER_DESC','Please enter a subject for ordermails generated from xtc. (like <b>our order {$nr},{$date}</b>) ps: you can use, {$nr},{$date},{$firstname},{$lastname}');


define('DOWNLOAD_ENABLED_TITLE' , 'Enable download');
define('DOWNLOAD_ENABLED_DESC' , 'Enable the products download functions.');
define('DOWNLOAD_BY_REDIRECT_TITLE' , 'Download by redirect');
define('DOWNLOAD_BY_REDIRECT_DESC' , 'Use browser redirection for download. Disable on non-Unix systems.');
define('DOWNLOAD_MAX_DAYS_TITLE' , 'Expiry delay (days)');
define('DOWNLOAD_MAX_DAYS_DESC' , 'Set number of days before the download link expires. 0 means no limit.');
define('DOWNLOAD_MAX_COUNT_TITLE' , 'Maximum number of downloads');
define('DOWNLOAD_MAX_COUNT_DESC' , 'Set the maximum number of downloads. 0 means no download authorized.');

define('GZIP_COMPRESSION_TITLE' , 'Enable GZip Compression');
define('GZIP_COMPRESSION_DESC' , 'Enable HTTP GZip compression.');
define('GZIP_LEVEL_TITLE' , 'Compression Level');
define('GZIP_LEVEL_DESC' , 'Use a compression level from 0-9 (0 = minimum, 9 = maximum).');

define('SESSION_WRITE_DIRECTORY_TITLE' , 'Session Directory');
define('SESSION_WRITE_DIRECTORY_DESC' , 'If sessions are file based, store them in this directory.');
define('SESSION_FORCE_COOKIE_USE_TITLE' , 'Force Cookie Use');
define('SESSION_FORCE_COOKIE_USE_DESC' , 'Force the use of sessions when cookies are only enabled.');
define('SESSION_CHECK_SSL_SESSION_ID_TITLE' , 'Check SSL Session ID');
define('SESSION_CHECK_SSL_SESSION_ID_DESC' , 'Validate the SSL_SESSION_ID on every secure HTTPS page request.');
define('SESSION_CHECK_USER_AGENT_TITLE' , 'Check User Agent');
define('SESSION_CHECK_USER_AGENT_DESC' , 'Validate the clients browser user agent on every page request.');
define('SESSION_CHECK_IP_ADDRESS_TITLE' , 'Check IP Address');
define('SESSION_CHECK_IP_ADDRESS_DESC' , 'Validate the clients IP address on every page request.');
define('SESSION_RECREATE_TITLE' , 'Recreate Session');
define('SESSION_RECREATE_DESC' , 'Recreate the session to generate a new session ID when the customer logs on or creates an account (PHP >=4.1 needed).');

define('DISPLAY_CONDITIONS_ON_CHECKOUT_TITLE' , 'Display conditions check on checkout');
define('DISPLAY_CONDITIONS_ON_CHECKOUT_DESC' , 'Display and Signing the Conditions in the Order Process');

define('META_MIN_KEYWORD_LENGTH_TITLE' , 'Min. meta-keyword lenght');
define('META_MIN_KEYWORD_LENGTH_DESC' , 'min. length of a single keyword (generated from products description)');
define('META_KEYWORDS_NUMBER_TITLE' , 'Number of meta-keywords');
define('META_KEYWORDS_NUMBER_DESC' , 'number of keywords');
define('META_AUTHOR_TITLE' , 'author');
define('META_AUTHOR_DESC' , '<meta name="author">');
define('META_PUBLISHER_TITLE' , 'publisher');
define('META_PUBLISHER_DESC' , '<meta name="publisher">');
define('META_COMPANY_TITLE' , 'company');
define('META_COMPANY_DESC' , '<meta name="conpany">');
define('META_TOPIC_TITLE' , 'page-topic');
define('META_TOPIC_DESC' , '<meta name="page-topic">');
define('META_REPLY_TO_TITLE' , 'reply-to');
define('META_REPLY_TO_DESC' , '<meta name="reply-to">');
define('META_REVISIT_AFTER_TITLE' , 'revisit-after');
define('META_REVISIT_AFTER_DESC' , '<meta name="revisit-after">');
define('META_ROBOTS_TITLE' , 'robots');
define('META_ROBOTS_DESC' , '<meta name="robots">');
define('META_DESCRIPTION_TITLE' , 'Description');
define('META_DESCRIPTION_DESC' , '<meta name="description">');
define('META_KEYWORDS_TITLE' , 'Keywords');
define('META_KEYWORDS_DESC' , '<meta name="keywords">');

define('MODULE_PAYMENT_INSTALLED_TITLE' , 'Installed Payment Modules');
define('MODULE_PAYMENT_INSTALLED_DESC' , 'List of payment module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: cc.php;cod.php;paypal.php)');
define('MODULE_ORDER_TOTAL_INSTALLED_TITLE' , 'Installed OrderTotal-Modules');
define('MODULE_ORDER_TOTAL_INSTALLED_DESC' , 'List of order_total module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)');
define('MODULE_SHIPPING_INSTALLED_TITLE' , 'Installed Shipping Modules');
define('MODULE_SHIPPING_INSTALLED_DESC' , 'List of shipping module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ups.php;flat.php;item.php)');

define('CACHE_LIFETIME_TITLE','Cache Lifetime');
define('CACHE_LIFETIME_DESC','This is the number of seconds cached content will persist');
define('CACHE_CHECK_TITLE','Check if cache modified');
define('CACHE_CHECK_DESC','If true, then If-Modified-Since headers are respected with cached content, and appropriate HTTP headers are sent. This way repeated hits to a cached page do not send the entire page to the client every time.');

define('DB_CACHE_TITLE','DB Cache');
define('DB_CACHE_DESC','Cache SELECT query results in files to gain more speed for slow databases.');

define('DB_CACHE_EXPIRE_TITLE','DB Cache lifetime');
define('DB_CACHE_EXPIRE_DESC','Time in seconds to rebuld cached resulst.');

define('PRODUCT_REVIEWS_VIEW_TITLE','Reviews in Productdetails');
define('PRODUCT_REVIEWS_VIEW_DESC','Number of displayed reviews in the productdetails page');

define('DELETE_GUEST_ACCOUNT_TITLE','Deleting Guest Accounts');
define('DELETE_GUEST_ACCOUNT_DESC','Shold guest accounts be deleted after placing orders ? (Order data will be saved)');

define('USE_WYSIWYG_TITLE','activate WYSIWYG Editor');
define('USE_WYSIWYG_DESC','activate WYSIWYG Editor for CMS and products');

define('PRICE_IS_BRUTTO_TITLE','Gross Admin');
define('PRICE_IS_BRUTTO_DESC','Usage of prices with tax in Admin');

define('PRICE_PRECISION_TITLE','Gross/Net precision');
define('PRICE_PRECISION_DESC','Gross/Net precision');
define('CHECK_CLIENT_AGENT_TITLE','Prevent Spider Sessions');
define('CHECK_CLIENT_AGENT_DESC','Prevent known spiders from starting a session.');
define('SHOW_IP_LOG_TITLE','IP-Log in Checkout?');
define('SHOW_IP_LOG_DESC','Show Text "Your IP will be saved", in checkout?');

define('ACTIVATE_GIFT_SYSTEM_TITLE','Activate Gift Voucher System');
define('ACTIVATE_GIFT_SYSTEM_DESC','Activate Gift Voucher System');

define('ACTIVATE_SHIPPING_STATUS_TITLE','Display Shippingstatus');
define('ACTIVATE_SHIPPING_STATUS_DESC','Show shippingstatus? (Different dispatch times can be specified for individual products. After activation appear a new point <b>Delivery Status</b> at product input)');

define('SECURITY_CODE_LENGTH_TITLE','Security Code Lenght');
define('SECURITY_CODE_LENGTH_DESC','Security code lenght (Gift voucher)');

define('IMAGE_QUALITY_TITLE','Image Quality');
define('IMAGE_QUALITY_DESC','Image quality (0= highest compression, 100=best quality)');

define('GROUP_CHECK_TITLE','Customerstatus Check');
define('GROUP_CHECK_DESC','Only allow specified customergroups access to individual categories,products and Contentelements (after activation, input fields in categories, products and in Contentmanager will appear');

define('ACTIVATE_REVERSE_CROSS_SELLING_TITLE','Reverse Cross-selling');
define('ACTIVATE_REVERSE_CROSS_SELLING_DESC','Activate reverse Cross-selling?');

define('ACTIVATE_NAVIGATOR_TITLE','activate productnavigator?');
define('ACTIVATE_NAVIGATOR_DESC','activate/deactivate productnavigator in product_info, (deaktivate for better performance with lots of articles in system)');

define('QUICKLINK_ACTIVATED_TITLE','activate multilink/copyfunction');
define('QUICKLINK_ACTIVATED_DESC','The multilink/copyfunction, changes the handling for the "copy product to" action, it allows to select multiple categories to copy/link a product with 1 click');

define('DOWNLOAD_UNALLOWED_PAYMENT_TITLE', 'Download Paymentmodules');
define('DOWNLOAD_UNALLOWED_PAYMENT_DESC', 'Not allowed Payment modules for downloads. List, seperated by comma, e.g. {banktransfer,cod,invoice,moneyorder}');
define('DOWNLOAD_MIN_ORDERS_STATUS_TITLE', 'Min. Orderstatus');
define('DOWNLOAD_MIN_ORDERS_STATUS_DESC', 'Min. orderstatus to allow download of files.');

// Vat Check
define('STORE_OWNER_VAT_ID_TITLE' , 'VAT ID of Shop Owner');
define('STORE_OWNER_VAT_ID_DESC' , 'The VAT ID of the Shop Owner');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_TITLE' , 'Customer-group - correct VAT ID (Foreign country)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_DESC' , 'Customers-group for customers with correct VAT ID, Shop country != customers country');
define('ACCOUNT_COMPANY_VAT_CHECK_TITLE' , 'Validate VAT ID');
define('ACCOUNT_COMPANY_VAT_CHECK_DESC' , 'Validate VAT ID (check correct syntax)');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_TITLE' , 'Validate VAT ID Live');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_DESC' , 'Validate VAT ID live (if no syntax check available for country), live check will use validation gateway of germans "Bundesamt fпїЅr Finanzen"');
define('ACCOUNT_COMPANY_VAT_GROUP_TITLE' , 'automatic pruning ?');
define('ACCOUNT_COMPANY_VAT_GROUP_DESC' , 'Set to true, the customer-group will be changed automatically if a correct VAT ID is used.');
define('ACCOUNT_VAT_BLOCK_ERROR_TITLE' , 'Allow wrong UST ID?');
define('ACCOUNT_VAT_BLOCK_ERROR_DESC' , 'Set to true, only validated VAT IDs are acceptet.');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_TITLE','Customer-group - correct VAT ID (Shop country)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_DESC','Customers-group for customers with correct VAT ID, Shop country = customers country');
// Google Conversion
define('GOOGLE_CONVERSION_TITLE','Google Conversion-Tracking');
define('GOOGLE_CONVERSION_DESC','Track the Conversion Keywords at orders');
define('GOOGLE_CONVERSION_ID_TITLE','Conversion ID');
define('GOOGLE_CONVERSION_ID_DESC','Your Google Conversion ID');
define('GOOGLE_LANG_TITLE','Google Language');
define('GOOGLE_LANG_DESC','ISO Code of used Language');

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
define('SEARCH_IN_DESC_TITLE','Search in Products Descriptions');
define('SEARCH_IN_DESC_DESC','Activate to enable search in Products Descriptions');
define('SEARCH_IN_ATTR_TITLE','Search in Products Attributes');
define('SEARCH_IN_ATTR_DESC','Activate to enable search in Products Attributes');

define('SEARCH_ENGINE_FRIENDLY_URLSX_TITLE' , 'Allow to use URL SEFLT');
define('SEARCH_ENGINE_FRIENDLY_URLSX_DESC' , 'Allow to use URL SEFLT');

// Сборка VaM

// Яндекс маркет

define('YML_NAME_TITLE' , 'Store name');
define('YML_COMPANY_TITLE' , 'Store owner');
define('YML_DELIVERYINCLUDED_TITLE' , 'Delivery included');
define('YML_AVAILABLE_TITLE' , 'Product availability');
define('YML_AUTH_USER_TITLE' , 'Login');
define('YML_AUTH_PW_TITLE' , 'Password');
define('YML_REFERER_TITLE' , 'Referer');
define('YML_STRIP_TAGS_TITLE' , 'Strip tags');
define('YML_UTF8_TITLE' , 'Encode to UTF-8');

define('YML_NAME_DESC' , 'Store name for Yandex-Market. STORE_NAME used if this field empty.');
define('YML_COMPANY_DESC' , 'Store owner for Yandex-Market. STORE_OWNER used if this field empty.');
define('YML_DELIVERYINCLUDED_DESC' , 'Delivery included?');
define('YML_AVAILABLE_DESC' , 'Product availability?');
define('YML_AUTH_USER_DESC' , 'Login for YML');
define('YML_AUTH_PW_DESC' , 'Password for YML');
define('YML_REFERER_DESC' , 'Add referer to product link (ip or user agent)?');
define('YML_STRIP_TAGS_DESC' , 'Strip html tags?');
define('YML_UTF8_DESC' , 'Encode to UTF-8?');

// Изменение цен

define('DISPLAY_MODEL_TITLE' , 'Display the model');
define('MODIFY_MODEL_TITLE' , 'Modify the model');
define('MODIFY_NAME_TITLE' , 'Modify the name of the products');
define('DISPLAY_STATUT_TITLE' , 'Modify the statut of the products');
define('DISPLAY_WEIGHT_TITLE' , 'Modify the weight of the products');
define('DISPLAY_QUANTITY_TITLE' , 'Modify the quantity of the products');
define('DISPLAY_IMAGE_TITLE' , 'Modify the image of the products');
define('DISPLAY_MANUFACTURER_TITLE' , 'Display the manufacturer');
define('MODIFY_MANUFACTURER_TITLE' , 'Modify the manufacturer of the products');
define('DISPLAY_TAX_TITLE' , 'Display the tax');
define('MODIFY_TAX_TITLE' , 'Modify the class of tax of the products');
define('DISPLAY_TVA_OVER_TITLE' , 'Display price with all included of tax');
define('DISPLAY_TVA_UP_TITLE' , 'Display price with all included of tax');
define('DISPLAY_PREVIEW_TITLE' , 'Display the link towards the products information page');
define('DISPLAY_EDIT_TITLE' , 'Display the link towards the page where you will be able to edit the product');
define('ACTIVATE_COMMERCIAL_MARGIN_TITLE' , 'Activate or desactivate the commercial margin');

define('DISPLAY_MODEL_DESC', 'Enable/Disable the model displaying');
define('MODIFY_MODEL_DESC', 'Allow/Disallow the model modification');
define('MODIFY_NAME_DESC', 'Allow/Disallow the name modification?');
define('DISPLAY_STATUT_DESC', 'Allow/Disallow the Statut displaying and modification');
define('DISPLAY_WEIGHT_DESC', 'Allow/Disallow the Weight displaying and modification?');
define('DISPLAY_QUANTITY_DESC', 'Allow/Disallow the Quantity displaying and modification?');
define('DISPLAY_IMAGE_DESC', 'Allow/Disallow the Image displaying and modification?');
define('MODIFY_MANUFACTURER_DESC', 'Allow/Disallow the Manufacturer displaying and modification');
define('MODIFY_TAX_DESC', 'Allow/Disallow the Class of tax displaying and modification');
define('DISPLAY_TVA_OVER_DESC', 'Enable/Disable the displaying of the Price with all tax included when your mouse is over a product');
define('DISPLAY_TVA_UP_DESC', 'Enable/Disable the displaying of the Price with all tax included when you are typing the price?');
define('DISPLAY_PREVIEW_DESC', 'Enable/Disable the display of the link towards the products information page');
define('DISPLAY_EDIT_DESC', 'Enable/Disable the display of the link towards the page where you will be able to edit the product');
define('DISPLAY_MANUFACTURER_DESC', 'Do you want just display the manufacturer ?');
define('DISPLAY_TAX_DESC', 'Do you want just display the tax ?');
define('ACTIVATE_COMMERCIAL_MARGIN_DESC', 'Do you want taht the commercial margin be activate or not ?');

define('REVOCATION_ID_TITLE','Revocation ID');
define('REVOCATION_ID_DESC','Revocation content ID');
define('DISPLAY_REVOCATION_ON_CHECKOUT_TITLE','Display revocation on checkout confirmation page?');
define('DISPLAY_REVOCATION_ON_CHECKOUT_DESC','Display revocation on checkout confirmation page?');

define('MAX_DISPLAY_LATEST_NEWS_TITLE' , 'News box');
define('MAX_DISPLAY_LATEST_NEWS_DESC' , 'Maximum number of news in news box');
define('MAX_DISPLAY_LATEST_NEWS_PAGE_TITLE' , 'News per page');
define('MAX_DISPLAY_LATEST_NEWS_PAGE_DESC' , 'Maximum number of news per page');
define('MAX_DISPLAY_LATEST_NEWS_CONTENT_TITLE' , 'Short description');
define('MAX_DISPLAY_LATEST_NEWS_CONTENT_DESC' , 'Number of symbols displayed in news preview');
?>