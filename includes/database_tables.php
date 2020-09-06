<?php
/* -----------------------------------------------------------------------------------------
   $Id: database_tables.php 1316 2007-02-06 20:14:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database_tables.php,v 1.1 2003/03/14); www.oscommerce.com 
   (c) 2003  nextcommerce (database_tables.php,v 1.8 2003/08/24); www.nextcommerce.org 
   (c) 2004  xt:Commerce (database_tables.php,v 1.8 2003/08/24); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


  // define the database table names used in the project
  define('TABLE_ADDRESS_BOOK', 'address_book');
  define('TABLE_ADDRESS_FORMAT', 'address_format');
  define('TABLE_BANNERS', 'banners');
  define('TABLE_BANNERS_HISTORY', 'banners_history');
  define('TABLE_CAMPAIGNS', 'campaigns');
  define('TABLE_CATEGORIES', 'categories');
  define('TABLE_CATEGORIES_DESCRIPTION', 'categories_description');
  define('TABLE_CONFIGURATION', 'configuration');
  define('TABLE_CONFIGURATION_GROUP', 'configuration_group');
  define('TABLE_COUNTER', 'counter');
  define('TABLE_COUNTER_HISTORY', 'counter_history');
  define('TABLE_COUNTRIES', 'countries');
  define('TABLE_CURRENCIES', 'currencies');
  define('TABLE_CUSTOMERS', 'customers');
  define('TABLE_CUSTOMERS_BASKET', 'customers_basket');
  define('TABLE_CUSTOMERS_BASKET_ATTRIBUTES', 'customers_basket_attributes');
  define('TABLE_CUSTOMERS_INFO', 'customers_info');
  define('TABLE_CUSTOMERS_IP', 'customers_ip');
  define('TABLE_CUSTOMERS_STATUS', 'customers_status');
  define('TABLE_CUSTOMERS_STATUS_HISTORY', 'customers_status_history');
  define('TABLE_CUSTOMERS_TO_MANUFACTURERS_DISCOUNT', 'customers_to_manufacturers_discount');
  define('TABLE_LANGUAGES', 'languages');
  define('TABLE_MANUFACTURERS', 'manufacturers');
  define('TABLE_MANUFACTURERS_INFO', 'manufacturers_info');
  define('TABLE_NEWSLETTER_RECIPIENTS', 'newsletter_recipients');
  define('TABLE_ORDERS', 'orders');
  define('TABLE_ORDERS_PRODUCTS', 'orders_products');
  define('TABLE_ORDERS_PRODUCTS_ATTRIBUTES', 'orders_products_attributes');
  define('TABLE_ORDERS_PRODUCTS_DOWNLOAD', 'orders_products_download');
  define('TABLE_ORDERS_STATUS', 'orders_status');
  define('TABLE_ORDERS_STATUS_HISTORY', 'orders_status_history');
  define('TABLE_ORDERS_TOTAL', 'orders_total');
  define('TABLE_SHIPPING_STATUS', 'shipping_status');
  define('TABLE_PERSONAL_OFFERS_BY','personal_offers_by_customers_status_');
  define('TABLE_PRODUCTS', 'products');
  define('TABLE_PRODUCTS_ATTRIBUTES', 'products_attributes');
  define('TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD', 'products_attributes_download');
  define('TABLE_PRODUCTS_DESCRIPTION', 'products_description');
  define('TABLE_PRODUCTS_NOTIFICATIONS', 'products_notifications');
  define('TABLE_PRODUCTS_IMAGES', 'products_images');
  define('TABLE_PRODUCTS_OPTIONS', 'products_options');
  define('TABLE_PRODUCTS_OPTIONS_VALUES', 'products_options_values');
  define('TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS', 'products_options_values_to_products_options');
  define('TABLE_PRODUCTS_TO_CATEGORIES', 'products_to_categories');
  define('TABLE_PRODUCTS_VPE','products_vpe');
  define('TABLE_REVIEWS', 'reviews');
  define('TABLE_REVIEWS_DESCRIPTION', 'reviews_description');
  define('TABLE_SESSIONS', 'sessions');
  define('TABLE_SPECIALS', 'specials');
  define('TABLE_TAX_CLASS', 'tax_class');
  define('TABLE_TAX_RATES', 'tax_rates');
  define('TABLE_GEO_ZONES', 'geo_zones');
  define('TABLE_ZONES_TO_GEO_ZONES', 'zones_to_geo_zones');
  define('TABLE_WHOS_ONLINE', 'whos_online');
  define('TABLE_ZONES', 'zones');
  define('TABLE_PRODUCTS_XSELL', 'products_xsell');
  define('TABLE_PRODUCTS_XSELL_GROUPS','products_xsell_grp_name');
  define('TABLE_CONTENT_MANAGER', 'content_manager');  
  define('TABLE_PRODUCTS_CONTENT','products_content');
  define('TABLE_COUPON_GV_CUSTOMER', 'coupon_gv_customer');
  define('TABLE_COUPON_GV_QUEUE', 'coupon_gv_queue');
  define('TABLE_COUPON_REDEEM_TRACK', 'coupon_redeem_track');
  define('TABLE_COUPON_EMAIL_TRACK', 'coupon_email_track');
  define('TABLE_COUPONS', 'coupons');
  define('TABLE_COUPONS_DESCRIPTION', 'coupons_description');
  define('TABLE_BLACKLIST', 'card_blacklist');
  define('TABLE_CAMPAIGNS_IP','campaigns_ip');
  
// Сборка VaM

  define('TABLE_LATEST_NEWS', 'latest_news');
  define('TABLE_FEATURED', 'featured');

  define('TABLE_ARTICLES', 'articles');
  define('TABLE_ARTICLES_DESCRIPTION', 'articles_description');
  define('TABLE_ARTICLES_TO_TOPICS', 'articles_to_topics');
  define('TABLE_AUTHORS', 'authors');
  define('TABLE_AUTHORS_INFO', 'authors_info');
  define('TABLE_TOPICS', 'topics');
  define('TABLE_TOPICS_DESCRIPTION', 'topics_description');
  define('TABLE_ARTICLES_XSELL', 'articles_xsell');

  define('TABLE_MONEYBOOKERS','payment_moneybookers');
  define('TABLE_MONEYBOOKERS_COUNTRIES','payment_moneybookers_countries');
  define('TABLE_MONEYBOOKERS_CURRENCIES','payment_moneybookers_currencies');
  define('TABLE_BANKTRANSFER','banktransfer');
  define('TABLE_NEWSLETTER_TEMP','module_newsletter_temp_');
  define('TABLE_PERSONAL_OFFERS','personal_offers_by_customers_status_');

  define('TABLE_SHIP2PAY','ship2pay');

  define('TABLE_PRODUCTS_EXTRA_FIELDS', 'products_extra_fields'); 
  define('TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS', 'products_to_products_extra_fields'); 

  define('TABLE_FAQ', 'faq');

  define('TABLE_COMPANIES', 'companies');
  define('TABLE_PERSONS', 'persons');

  define('TABLE_EXTRA_FIELDS','extra_fields');
  define('TABLE_EXTRA_FIELDS_INFO','extra_fields_info');
  define('TABLE_CUSTOMERS_TO_EXTRA_FIELDS','customers_to_extra_fields');

define('TABLE_SPSR_ZONES', 'spsr_zones');

define('TABLE_PRODUCTS_PINS', 'products_pins');  

// Start Products Specifications
  define('TABLE_PRODUCTS_SPECIFICATIONS', 'products_specifications');
  define('TABLE_SPECIFICATION', 'specifications');
  define('TABLE_SPECIFICATION_DESCRIPTION', 'specification_description');
  define('TABLE_SPECIFICATION_GROUPS', 'specification_groups');
  define('TABLE_SPECIFICATIONS_FILTERS', 'specification_filters');
  define('TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION', 'specification_filters_description');
  define('TABLE_SPECIFICATIONS_TO_CATEGORIES', 'specification_groups_to_categories');
  define('TABLE_SPECIFICATIONS_VALUES', 'specification_values');
  define('TABLE_SPECIFICATIONS_VALUES_DESCRIPTION', 'specification_values_description');
// End Products Specifications
  
  define('TABLE_PRODUCT_LABELS', 'product_labels');

  define('TABLE_ARTICLE_REVIEWS', 'article_reviews');
  define('TABLE_ARTICLE_REVIEWS_DESCRIPTION', 'article_reviews_description');

  define('TABLE_AUTHOR_REVIEWS', 'author_reviews');
  define('TABLE_AUTHOR_REVIEWS_DESCRIPTION', 'author_reviews_description');

  define('TABLE_COMPANY_REVIEWS', 'company_reviews');
  define('TABLE_COMPANY_REVIEWS_DESCRIPTION', 'company_reviews_description');

  define('TABLE_SITE_REVIEWS', 'site_reviews');
  define('TABLE_SITE_REVIEWS_DESCRIPTION', 'site_reviews_description');

  define('TABLE_ANSWER_TEMPLATES', 'answer_templates');

  define('TABLE_PRODUCTS_BUNDLES', 'products_bundles');

  define('TABLE_ARTICLES_TO_CATEGORIES', 'articles_to_categories');
  define('TABLE_ARTICLES_TO_PRODUCTS', 'articles_to_products');
  define('TABLE_FAQ_TO_CATEGORIES', 'faq_to_categories');
  define('TABLE_FAQ_TO_PRODUCTS', 'faq_to_products');
  define('TABLE_LATEST_NEWS_TO_CATEGORIES', 'latest_news_to_categories');
  define('TABLE_LATEST_NEWS_TO_PRODUCTS', 'latest_news_to_products');

  define('TABLE_TAGS', 'tags');
  define('TABLE_TAGS_TO_CATEGORIES', 'tags_to_categories');
  define('TABLE_TAGS_TO_PRODUCTS', 'tags_to_products');

  define('TABLE_REVIEWS_IMAGES', 'reviews_images');
      
?>