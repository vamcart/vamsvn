<?php
/* -----------------------------------------------------------------------------------------
   $Id: english.php 1260 2005-09-29 17:48:04Z gwinger $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(german.php,v 1.119 2003/05/19); www.oscommerce.com
   (c) 2003  nextcommerce (german.php,v 1.25 2003/08/25); www.nextcommerce.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

/*
 *
 *  DATE / TIME
 *
 */

define('TITLE', STORE_NAME);
define('HEADER_TITLE_TOP', 'Main page');     
define('HEADER_TITLE_CATALOG', 'Catalogue');

define('HTML_PARAMS','dir="ltr" lang="en"');

@setlocale(LC_TIME, 'en_EN@euro', 'en_US', 'en-US', 'en', 'en_US.ISO_8859-1', 'English','en_US.ISO_8859-15');

define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('DOB_FORMAT_STRING', 'dd.mm.jjjj');

function xtc_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'USD');

define('MALE', 'Mr.');
define('FEMALE', 'Miss/Ms./Mrs.');

/*
 *
 *  BOXES
 *
 */

// text for gift voucher redeeming
define('IMAGE_REDEEM_GIFT','Redeem Gift Voucher!');

define('BOX_TITLE_STATISTICS','Statistics:');
define('BOX_ENTRY_CUSTOMERS','Customers');
define('BOX_ENTRY_PRODUCTS','Products');
define('BOX_ENTRY_REVIEWS','Reviews');
define('TEXT_VALIDATING','Not validated');

// manufacturer box text
define('BOX_MANUFACTURER_INFO_HOMEPAGE', '%s Homepage');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'More Products');

define('BOX_HEADING_ADD_PRODUCT_ID','Add To Cart');
  
define('BOX_LOGINBOX_STATUS','Customer group:');     
define('BOX_LOGINBOX_DISCOUNT','Product discount');
define('BOX_LOGINBOX_DISCOUNT_TEXT','Discount');
define('BOX_LOGINBOX_DISCOUNT_OT','');

// reviews box text in includes/boxes/reviews.php
define('BOX_REVIEWS_WRITE_REVIEW', 'Review this product!');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s of 5 stars!');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Please choose');

// javascript messages
define('JS_ERROR', 'Missing necessary information!\nPlease fill in correctly.\n\n');

define('JS_REVIEW_TEXT', '* The text must consist at least of ' . REVIEW_TEXT_MIN_LENGTH . ' alphabetic characters..\n');
define('JS_REVIEW_RATING', '* Enter your review.\n');
define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Please choose a method of payment for your order.\n');
define('JS_ERROR_SUBMITTED', 'This page has already been confirmed. Please click okay and wait until the process has finished.');
define('ERROR_NO_PAYMENT_MODULE_SELECTED', 'Please choose a method of payment for your order.');

/*
 *
 * ACCOUNT FORMS
 *
 */

define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER_ERROR', 'Please select your gender.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME_ERROR', 'Your firstname must consist of at least  ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' characters.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME_ERROR', 'Your e-mail address must consist of at least ' . ENTRY_LAST_NAME_MIN_LENGTH . ' characters.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Your date of birth has to be entered in the following form DD.MM.YYYY (e.g. 21.05.1970) ');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (e.g. 21.05.1970)');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Your e-mail address must consist of at least  ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' characters.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'The e-mail address your entered is incorrect - please check it');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'The e-mail address your entered already exists in our database - please check it');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS_ERROR', 'Street/Nr must consist of at least ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' characters.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE_ERROR', 'Your zip code must consist of at least ' . ENTRY_POSTCODE_MIN_LENGTH . ' characters.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY_ERROR', 'City must consist of at least ' . ENTRY_CITY_MIN_LENGTH . ' characters.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE_ERROR', 'Your state must consist of at least ' . ENTRY_STATE_MIN_LENGTH . ' characters.');
define('ENTRY_STATE_ERROR_SELECT', 'Please choose your state out of the list..');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY_ERROR', 'Please choose your country.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Your phone number must consist of at least ' . ENTRY_TELEPHONE_MIN_LENGTH . ' characters.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_PASSWORD_ERROR', 'Your password must consist of at least ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Your passwords do not match.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR','Your password must consist of at least ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Your new password must consist of at least ' . ENTRY_PASSWORD_MIN_LENGTH . ' characters.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Your passwords do not match.');

/*
 *
 *  RESTULTPAGES
 *
 */

define('TEXT_RESULT_PAGE', 'Sites:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Show <span class="bold">%d</span> to <span class="bold">%d</span> (of in total <span class="bold">%d</span> products)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Show <span class="bold">%d</span> to <span class="bold">%d</span> (of in total <span class="bold">%d</span> orders)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Show <span class="bold">%d</span> to <span class="bold">%d</span> (of in total <span class="bold">%d</span> reviews)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Show <span class="bold">%d</span> to <span class="bold">%d</span> (of in total <span class="bold">%d</span> new products)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Show <span class="bold">%d</span> to <span class="bold">%d</span> (of in total <span class="bold">%d</span> special offers)');
define('TEXT_DISPLAY_NUMBER_OF_FEATURED', 'Show <span class="bold">%d</span> to <span class="bold">%d</span> (of in total <span class="bold">%d</span> featured products)');

/*
 *
 * SITE NAVIGATION
 *
 */

define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'previous page');
define('PREVNEXT_TITLE_NEXT_PAGE', 'next page');
define('PREVNEXT_TITLE_PAGE_NO', 'page %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Previous %d pages');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Next %d pages');

/*
 *
 * PRODUCT NAVIGATION
 *
 */

define('PREVNEXT_BUTTON_PREV', '[&lt;&lt;&nbsp;previous]');
define('PREVNEXT_BUTTON_NEXT', '[next&nbsp;&gt;&gt;]');

/*
 *
 * IMAGE BUTTONS
 *
 */

define('IMAGE_BUTTON_ADD_ADDRESS', 'New address');
define('IMAGE_BUTTON_BACK', 'Back');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Change address');
define('IMAGE_BUTTON_CHECKOUT', 'Checkout');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Confirm order');
define('IMAGE_BUTTON_CONTINUE', 'Next');
define('IMAGE_BUTTON_DELETE', 'Delete');
define('IMAGE_BUTTON_LOGIN', 'Login');
define('IMAGE_BUTTON_IN_CART', 'Into the cart');
define('IMAGE_BUTTON_SEARCH', 'Search');
define('IMAGE_BUTTON_UPDATE', 'Update');
define('IMAGE_BUTTON_UPDATE_CART', 'Update shopping cart');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Write Evaluation');
define('IMAGE_BUTTON_ADMIN', 'Admin');
define('IMAGE_BUTTON_PRODUCT_EDIT', 'Edit product');
define('IMAGE_BUTTON_LOGIN', 'Login');

define('SMALL_IMAGE_BUTTON_DELETE', 'Delete');
define('SMALL_IMAGE_BUTTON_EDIT', 'Edit');
define('SMALL_IMAGE_BUTTON_VIEW', 'View');

define('ICON_ARROW_RIGHT', 'Show more');
define('ICON_CART', 'Into the cart');
define('ICON_SUCCESS', 'Success');
define('ICON_WARNING', 'Warning');

/*
 *
 *  GREETINGS
 *
 */

define('TEXT_GREETING_PERSONAL', 'Nice to see you again <span class="greetUser">%s!</span> Would you like to view our <a href="%s">new products</a> ?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>If you are not %s , please  <a href="%s">login</a>  with your account.</small>');
define('TEXT_GREETING_GUEST', 'Welcome  <span class="greetUser">visitor!</span> Would you like to <a href="%s">login</a>? Or would you like to create a new <a href="%s">account</a> ?');

define('TEXT_SORT_PRODUCTS', 'Sorting of the items is ');
define('TEXT_DESCENDINGLY', 'descending');
define('TEXT_ASCENDINGLY', 'ascending');
define('TEXT_BY', ' after ');

define('TEXT_REVIEW_BY', 'from %s');
define('TEXT_REVIEW_WORD_COUNT', '%s words');
define('TEXT_REVIEW_RATING', 'Review: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Date added: %s');
define('TEXT_NO_REVIEWS', 'There are no reviews yet.');
define('TEXT_NO_NEW_PRODUCTS', 'There are no new products at the moment.');
define('TEXT_UNKNOWN_TAX_RATE', 'Unknown tax rate');

/*
 *
 * WARNINGS
 *
 */

define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Warning: The installation directory is still available on: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/install. Please delete this directory for security reasons!');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Warning: XT-Commerce is able to write to the configuration directory: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. That represents a possible safety hazard - please correct the user access rights for this directory!');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Warning: Directory for sesssions doesn&acute;t exist: ' . xtc_session_save_path() . '. Sessions will not work until this directory has been created!');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Warning: XT-Commerce is not able to write into the session directory: ' . xtc_session_save_path() . '. Sessions will not work until the user access rights for this directory have been changed!');
define('WARNING_SESSION_AUTO_START', 'Warning: session.auto_start is activated (enabled) - Please deactivate (disable) this PHP feature in php.ini and restart your web server!');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Warning: Directory for article download does not exist: ' . DIR_FS_DOWNLOAD . '. This feature will not work until this directory has been created!');

define('SUCCESS_ACCOUNT_UPDATED', 'Your account has been updated successfully.');
define('SUCCESS_PASSWORD_UPDATED', 'Your password has been changed successfully!');
define('ERROR_CURRENT_PASSWORD_NOT_MATCHING', 'The entered password does not match with the stored password. Please try again.');
define('TEXT_MAXIMUM_ENTRIES', '<span class="bold">Reference:</span> You are able to choose out of %s entries in you address book!');
define('SUCCESS_ADDRESS_BOOK_ENTRY_DELETED', 'The selected entry has been deleted successfully.');
define('SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED', 'Your address book has been updated sucessfully!');
define('WARNING_PRIMARY_ADDRESS_DELETION', 'The standard postal address can not be deleted. Please create another address and define it as standard postal address first. Than this entry can be deleted.');
define('ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY', 'This address book entry is not available.');
define('ERROR_ADDRESS_BOOK_FULL', 'Your adressbook is full and you have to delete one adress first, before you can save another.');

//  conditions check

define('ERROR_CONDITIONS_NOT_ACCEPTED', 'If you do not accept our General Business Conditions, we are not able to accept your order!');

define('SUB_TITLE_OT_DISCOUNT','Discount:');

define('TAX_ADD_TAX','incl. ');
define('TAX_NO_TAX','plus ');

define('NOT_ALLOWED_TO_SEE_PRICES','You do not have the permission to see the prices ');
define('NOT_ALLOWED_TO_SEE_PRICES_TEXT','You do not have the permission to see the prices, please create an account.');

define('TEXT_DOWNLOAD','Download');
define('TEXT_VIEW','View');

define('TEXT_BUY', '1 x \'');
define('TEXT_NOW', '\' order');
define('TEXT_GUEST','Visitor');

/*
 *
 * ADVANCED SEARCH
 *
 */

define('TEXT_ALL_CATEGORIES', 'All categories');
define('TEXT_ALL_MANUFACTURERS', 'All manufacturers');
define('JS_AT_LEAST_ONE_INPUT', '* One of the following fields must be filled:\n    Keywords\n    Date added from\n    Date added to\n    Price over\n    Price up to\n');
define('AT_LEAST_ONE_INPUT', 'One of the following fields must be filled:<br />keywords consisting at least 3 characters<br />Price over<br />Price up to<br />');
define('JS_INVALID_FROM_DATE', '* Invalid from date\n');
define('JS_INVALID_TO_DATE', '* Invalid up to Date\n');
define('JS_TO_DATE_LESS_THAN_FROM_DATE', '* The from date must be larger or same size as up to now\n');
define('JS_PRICE_FROM_MUST_BE_NUM', '* Price over, must be a number\n');
define('JS_PRICE_TO_MUST_BE_NUM', '* Price up to, must be a number\n');
define('JS_PRICE_TO_LESS_THAN_PRICE_FROM', '* Price up to must be larger or same size as Price over.\n');
define('JS_INVALID_KEYWORDS', '* Invalid search key\n');
define('TEXT_LOGIN_ERROR', '<span class="bold">ERROR:</span> The entered \'eMail-address\' and/or the \'password\' do not match.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', '<span class="bold">WARNING:</span> The entered e-mail address is not registered. Please try again.');
define('TEXT_PASSWORD_SENT', 'A new password was sent by e-mail.');
define('TEXT_PRODUCT_NOT_FOUND', 'Product not found!');
define('TEXT_MORE_INFORMATION', 'For further information, please visit the <a href="%s" onclick="window.open(this.href); return false;">homepage</a> of this product.');
define('TEXT_DATE_ADDED', 'This Product was added to our catalogue on %s.');
define('TEXT_DATE_AVAILABLE', 'This Product is expected to be on stock again on %s');
define('SUB_TITLE_SUB_TOTAL', 'Sub-total:');

define('OUT_OF_STOCK_CANT_CHECKOUT', 'The products marked with ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' , are not on stock in the quantity you requested.<br />Please reduce your purchase order quantity for the marked products. Thank you');
define('OUT_OF_STOCK_CAN_CHECKOUT', 'The products marked with ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' , are not on stock in the quantity you requested.<br />The entered quantity will be supplied in a short period of time by us. On request, we can do part delivery.');

define('MINIMUM_ORDER_VALUE_NOT_REACHED_1', 'You need to reach the minimum order value of: ');
define('MINIMUM_ORDER_VALUE_NOT_REACHED_2', ' <br />Please increase your order for more: ');
define('MAXIMUM_ORDER_VALUE_REACHED_1', 'You ordered more than the allowed amount of: ');
define('MAXIMUM_ORDER_VALUE_REACHED_2', '<br /> Please decrease your order for less than: ');

define('ERROR_INVALID_PRODUCT', 'The product chosen was not found!');

/*
 *
 * NAVBAR Titel
 *
 */

define('NAVBAR_TITLE_ACCOUNT', 'Your account');
define('NAVBAR_TITLE_1_ACCOUNT_EDIT', 'Your account');
define('NAVBAR_TITLE_2_ACCOUNT_EDIT', 'Changing your personal data');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY', 'Your account');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY', 'Your completed orders');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY_INFO', 'Your account');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY_INFO', 'Completed orders');
define('NAVBAR_TITLE_3_ACCOUNT_HISTORY_INFO', 'Order number %s');
define('NAVBAR_TITLE_1_ACCOUNT_PASSWORD', 'Your account');
define('NAVBAR_TITLE_2_ACCOUNT_PASSWORD', 'Change password');
define('NAVBAR_TITLE_1_ADDRESS_BOOK', 'Your account');
define('NAVBAR_TITLE_2_ADDRESS_BOOK', 'Address book');
define('NAVBAR_TITLE_1_ADDRESS_BOOK_PROCESS', 'Your account');
define('NAVBAR_TITLE_2_ADDRESS_BOOK_PROCESS', 'Address book');
define('NAVBAR_TITLE_ADD_ENTRY_ADDRESS_BOOK_PROCESS', 'New entry');
define('NAVBAR_TITLE_MODIFY_ENTRY_ADDRESS_BOOK_PROCESS', 'Change entry');
define('NAVBAR_TITLE_DELETE_ENTRY_ADDRESS_BOOK_PROCESS', 'Delete Entry');
define('NAVBAR_TITLE_ADVANCED_SEARCH', 'Advanced Search');
define('NAVBAR_TITLE1_ADVANCED_SEARCH', 'Advanced Search');
define('NAVBAR_TITLE2_ADVANCED_SEARCH', 'Search results');
define('NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION', 'Confirmation');
define('NAVBAR_TITLE_1_CHECKOUT_PAYMENT', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_PAYMENT', 'Method of payment');
define('NAVBAR_TITLE_1_PAYMENT_ADDRESS', 'Checkout');
define('NAVBAR_TITLE_2_PAYMENT_ADDRESS', 'Change billing address');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING', 'Shipping information');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING_ADDRESS', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING_ADDRESS', 'Change shipping address');
define('NAVBAR_TITLE_1_CHECKOUT_SUCCESS', 'Checkout');
define('NAVBAR_TITLE_2_CHECKOUT_SUCCESS', 'Success');
define('NAVBAR_TITLE_CREATE_ACCOUNT', 'Create account');
if ($navigation->snapshot['page'] == FILENAME_CHECKOUT_SHIPPING) {
  define('NAVBAR_TITLE_LOGIN', 'Order');
} else {
  define('NAVBAR_TITLE_LOGIN', 'Login');
}
define('NAVBAR_TITLE_LOGOFF','Good bye');
define('NAVBAR_TITLE_PRODUCTS_NEW', 'New products');
define('NAVBAR_TITLE_SHOPPING_CART', 'Shopping cart');
define('NAVBAR_TITLE_SPECIALS', 'Special offers');
define('NAVBAR_TITLE_FEATURED', 'Featured products');
define('NAVBAR_TITLE_COOKIE_USAGE', 'Cookie Usage');
define('NAVBAR_TITLE_PRODUCT_REVIEWS', 'Reviews');
define('NAVBAR_TITLE_REVIEWS_WRITE', 'Opinions');
define('NAVBAR_TITLE_REVIEWS','Reviews');
define('NAVBAR_TITLE_SSL_CHECK', 'Note on safety');
define('NAVBAR_TITLE_CREATE_GUEST_ACCOUNT','Create account');
define('NAVBAR_TITLE_PASSWORD_DOUBLE_OPT','Password forgotten?');
define('NAVBAR_TITLE_NEWSLETTER','Newsletter');
define('NAVBAR_GV_REDEEM', 'Redeem Voucher');
define('NAVBAR_GV_SEND', 'Send Voucher');

/*
 *
 *  MISC
 *
 */

define('TEXT_NEWSLETTER','You want to stay up to date?<br />No problem, receiveour Newsletter and we can inform you always up to date.');
define('TEXT_EMAIL_INPUT','Your e-Mail adress has been registered by our system.<br />Therefore you will receive an E-Mail with your personally confirmation-code-link.  Please click after the receipt of the Mail on the Hyperlink inside. Otherwise no Newsletter will be send to you!');

define('TEXT_WRONG_CODE','Please fill out the e-Mail field and the Security-Code again. <br />Be aware of Typos!');
define('TEXT_EMAIL_EXIST_NO_NEWSLETTER','This e-Mail address is registered but not yet activated!');
define('TEXT_EMAIL_EXIST_NEWSLETTER','This e-Mail address is registered is also activated for the newsletter!');
define('TEXT_EMAIL_NOT_EXIST','This e-Mail address is not registered for Newsletters!');
define('TEXT_EMAIL_DEL','Your e-Mail adress was deleted successfully in our newsletter-database.');
define('TEXT_EMAIL_DEL_ERROR','An Error occured, your e-Mailaddress has not been deletet!');
define('TEXT_EMAIL_ACTIVE','Your e-Mail address was successfully integrated in our Newsletter Service!');
define('TEXT_EMAIL_ACTIVE_ERROR','An error occured, your e-Mail address has not been activated for Newsletter!');
define('TEXT_EMAIL_SUBJECT','Your Newsletter Account');

define('TEXT_CUSTOMER_GUEST','Guest');

define('TEXT_LINK_MAIL_SENDED','Your inquiry for a new password must be confirmed by you peronally.<br />Therefore you will receive an E-Mail with your personally confirmation-code-link.  Please click after the receipt of the Mail on the Hyperlink inside. A further Mail with your new Login password will receive you afterwards.  Otherwise no new password will be set or sended to you!');
define('TEXT_PASSWORD_MAIL_SENDED','You will receive an e-Mail with your new password in between minutes.<br />Please change your password after your first login like you want.');
define('TEXT_CODE_ERROR','Please fill out the e-Mail field and the Security-Code again. <br />Be aware of Typos!');
define('TEXT_EMAIL_ERROR','Please fill out the e-Mail field and the Security-Code again. <br />Be aware of Typos!');
define('TEXT_NO_ACCOUNT','Unfortunately we must communicate to you that your inquiry for a new Login password was either invalid or run out off time.<br />Please try it again.');
define('HEADING_PASSWORD_FORGOTTEN','Password renewal?');
define('TEXT_PASSWORD_FORGOTTEN','Change your password in three easy steps.');
define('TEXT_EMAIL_PASSWORD_FORGOTTEN','Confirmation Mail for password renewal');
define('TEXT_EMAIL_PASSWORD_NEW_PASSWORD','Your new password');
define('ERROR_MAIL','Please check the data entered in the form');

define('CATEGORIE_NOT_FOUND','Category was not found');

define('GV_FAQ', 'Gift Voucher FAQ');
define('ERROR_NO_REDEEM_CODE', 'You did not enter a redeem code.');
define('ERROR_NO_INVALID_REDEEM_GV', 'Invalid Gift Voucher Code');
define('TABLE_HEADING_CREDIT', 'Credits Available');
define('EMAIL_GV_TEXT_SUBJECT', 'A gift from %s');
define('MAIN_MESSAGE', 'You have decided to send a gift voucher worth %s to %s who\'s eMail address is %s<br /><br />The text accompanying the eMail will read<br /><br />Dear %s<br /><br />You have been sent a Gift Voucher worth %s by %s');
define('REDEEMED_AMOUNT','Your gift voucher was successfully added to your account. Gift voucher ammount:');
define('REDEEMED_COUPON','Your coupon was successfully booked and will be redeemed automatically with your next order.');

define('ERROR_INVALID_USES_USER_COUPON','Customers can redeem this coupon only ');
define('ERROR_INVALID_USES_COUPON','Customers can redeem this coupon only ');
define('TIMES',' times.');
define('ERROR_INVALID_STARTDATE_COUPON','Your coupon is not aviable yet.');
define('ERROR_INVALID_FINISDATE_COUPON','Your coupon is out of date.');
define('PERSONAL_MESSAGE', '%s says:');

//Popup Window
define('TEXT_CLOSE_WINDOW', 'Close Window.');

/*
 *
 * CUOPON POPUP
 *
 */

define('TEXT_CLOSE_WINDOW', 'Close Window [x]');
define('TEXT_COUPON_HELP_HEADER', 'Congratulations, you have redeemed a Discount Coupon.');
define('TEXT_COUPON_HELP_NAME', '<br /><br />Coupon Name : %s');
define('TEXT_COUPON_HELP_FIXED', '<br /><br />The coupon is worth %s discount against your order');
define('TEXT_COUPON_HELP_MINORDER', '<br /><br />You need to spend %s to use this coupon');
define('TEXT_COUPON_HELP_FREESHIP', '<br /><br />This coupon gives you free shipping on your order');
define('TEXT_COUPON_HELP_DESC', '<br /><br />Coupon Description : %s');
define('TEXT_COUPON_HELP_DATE', '<br /><br />The coupon is valid between %s and %s');
define('TEXT_COUPON_HELP_RESTRICT', '<br /><br />Product / Category Restrictions');
define('TEXT_COUPON_HELP_CATEGORIES', 'Category');
define('TEXT_COUPON_HELP_PRODUCTS', 'Product');

// VAT ID
define('ENTRY_VAT_TEXT','* for Germany and EU-Countries only');
define('ENTRY_VAT_ERROR', 'The chosen VatID is not valid or not proofable at this moment! Please fill in a valid ID or leave the field empty.');
define('MSRP','MSRP');
define('YOUR_PRICE','your price ');
define('ONLY',' only ');
define('FROM','from ');
define('YOU_SAVE','you save ');
define('INSTEAD','instead ');
define('TXT_PER',' per ');
define('TAX_INFO_INCL','incl. %s Tax');
define('TAX_INFO_EXCL','excl. %s Tax');
define('TAX_INFO_ADD','plus. %s Tax');
define('SHIPPING_EXCL','excl.');
define('SHIPPING_COSTS','Shipping costs');

// —борка VaM

define('BOX_HEADING_SEARCH', 'Go');
define('ICON_ERROR', 'Error');

// RSS2 Info
define('NAVBAR_TITLE_RSS2_INFO','RSS channels');
define('TEXT_RSS2_INFO', '
<h3>Main channels</h3>
News - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=news' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=news</a><br />
Categories - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=categories' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=categories</a><br />
Products - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;limit=10</a><br />
Product with id 43 - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;products_id=43' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;products_id=43</a><br />
Products in categories - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;cPath=25&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;cPath=25&amp;limit=10</a><br />
<br />
<h3>Additional channels</h3>
New products - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products&amp;limit=10</a><br />
Best sellers - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers&amp;limit=10</a><br />
Featured - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured&amp;limit=10</a><br />
Specials - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials&amp;limit=10</a><br />
Upcoming products - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming&amp;limit=10</a><br />
<br />
<h3>Random product channels</h3>
Random new product - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products_random</a><br />
Random best sellers - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers_random</a><br />
Random featured - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured_random</a><br />
Random specials - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials_random</a><br />
Random upcoming - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming_random</a><br />
<br />
<h3>Limit parameter</h3>
<p>You can use limit parameter.<br />
For example, you can display only 10 items from new products rss2.php?feed=new_products&amp;limit=10</p>
');

define('ENTRY_STATE_RELOAD', 'Click <span class="bold">"Update"</span> button to fill State field');
define('ENTRY_NOSTATE_AVAILIABLE', 'States not available for selecter country');
define('ENTRY_STATEXML_LOADING', 'Loading states ...');

define('SHIPPING_TIME','Shipping time: ');
define('MORE_INFO','[More]');

define('TABLE_HEADING_LATEST_NEWS', 'Latest news');
define('NAVBAR_TITLE_NEWS', 'News');

define('TEXT_DISPLAY_NUMBER_OF_LATEST_NEWS', 'Show <span class="bold">%d</span> to <span class="bold">%d</span> (of in total <span class="bold">%d</span> new products)');
define('TEXT_NO_NEWS', 'No news.');

define('TEXT_INFO_SHOW_PRICE_NO','You do not have the permission to see the prices ');

define('TEXT_OF_5_STARS', '%s of 5 stars!');

define('IMAGE_BUTTON_PRINT', 'Print');

?>