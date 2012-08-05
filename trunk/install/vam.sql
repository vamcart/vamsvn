# -----------------------------------------------------------------------------------------
#  $Id: vamshop.sql,v 1.62 2009/04/26 20:24:16 VaM Exp $
#
#  VamShop - open source ecommerce solution
#  http://vamshop.com 
#  http://vamshop.ru 
#
#  Copyright (c) 2012 VamShop
#  -----------------------------------------------------------------------------------------
#  based on:
#  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
#  (c) 2002-2003 osCommerce (oscommerce.sql,v 1.83); www.oscommerce.com
#  (c) 2003  nextcommerce (nextcommerce.sql,v 1.76 2003/08/25); www.nextcommerce.org
#  (c) 2005  xt:Commerce (nextcommerce.sql,v 1.76 2005/08/25); www.xt-commerce.com
#
#  Released under the GNU General Public License
#
#  --------------------------------------------------------------
# NOTE: * Please make any modifications to this file by hand!
#       * DO NOT use a mysqldump created file for new changes!
#       * Please take note of the table structure, and use this
#         structure as a standard for future modifications!
#       * To see the 'diff'erence between MySQL databases, use
#         the mysqldiff perl script located in the extras
#         directory of the 'catalog' module.
#       * Comments should be like these, full line comments.
#         (don't use inline comments)
#  --------------------------------------------------------------


DROP TABLE IF EXISTS address_book;
CREATE TABLE address_book (
  address_book_id int NOT NULL auto_increment,
  customers_id int NOT NULL,
  entry_gender char(1) NOT NULL,
  entry_company varchar(255),
  entry_firstname varchar(255) NOT NULL,
  entry_secondname varchar(255) NOT NULL,
  entry_lastname varchar(255) NOT NULL,
  entry_street_address varchar(255) NOT NULL,
  entry_suburb varchar(255),
  entry_postcode varchar(10) NOT NULL,
  entry_city varchar(255) NOT NULL,
  entry_state varchar(255),
  entry_country_id int DEFAULT '0' NOT NULL,
  entry_zone_id int DEFAULT '0' NOT NULL,
  address_date_added datetime DEFAULT '0000-00-00 00:00:00',
  address_last_modified datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (address_book_id),
  KEY idx_address_book_customers_id (customers_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS affiliate_affiliate;
CREATE TABLE affiliate_affiliate (
  affiliate_id int(11) NOT NULL auto_increment,
  affiliate_lft int(11) NOT NULL,
  affiliate_rgt int(11) NOT NULL,
  affiliate_root int(11) NOT NULL,
  affiliate_gender char(1) NOT NULL default '',
  affiliate_firstname varchar(32) NOT NULL default '',
  affiliate_lastname varchar(32) NOT NULL default '',
  affiliate_dob datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_email_address varchar(96) NOT NULL default '',
  affiliate_telephone varchar(32) NOT NULL default '',
  affiliate_fax varchar(32) NOT NULL default '',
  affiliate_password varchar(40) NOT NULL default '',
  affiliate_homepage varchar(96) NOT NULL default '',
  affiliate_street_address varchar(64) NOT NULL default '',
  affiliate_suburb varchar(64) NOT NULL default '',
  affiliate_city varchar(32) NOT NULL default '',
  affiliate_postcode varchar(10) NOT NULL default '',
  affiliate_state varchar(32) NOT NULL default '',
  affiliate_country_id int(11) NOT NULL default '0',
  affiliate_zone_id int(11) NOT NULL default '0',
  affiliate_agb tinyint(4) NOT NULL default '0',
  affiliate_company varchar(60) NOT NULL default '',
  affiliate_company_taxid varchar(64) NOT NULL default '',
  affiliate_commission_percent DECIMAL(4,2) NOT NULL default '0.00',
  affiliate_payment_check varchar(100) NOT NULL default '',
  affiliate_payment_paypal varchar(64) NOT NULL default '',
  affiliate_payment_bank_name varchar(64) NOT NULL default '',
  affiliate_payment_bank_branch_number varchar(64) NOT NULL default '',
  affiliate_payment_bank_swift_code varchar(64) NOT NULL default '',
  affiliate_payment_bank_account_name varchar(64) NOT NULL default '',
  affiliate_payment_bank_account_number varchar(64) NOT NULL default '',
  affiliate_date_of_last_logon datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_number_of_logons int(11) NOT NULL default '0',
  affiliate_date_account_created datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_date_account_last_modified datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (affiliate_id),
  KEY `affiliate_root` (`affiliate_root`),
  KEY `affiliate_rgt` (`affiliate_rgt`),
  KEY `affiliate_lft` (`affiliate_lft`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS affiliate_banners;
CREATE TABLE affiliate_banners (
  affiliate_banners_id int(11) NOT NULL auto_increment,
  affiliate_banners_title varchar(64) NOT NULL default '',
  affiliate_products_id int(11) NOT NULL default '0',
  affiliate_banners_image varchar(64) NOT NULL default '',
  affiliate_banners_group varchar(10) NOT NULL default '',
  affiliate_banners_html_text text,
  affiliate_expires_impressions int(7) default '0',
  affiliate_expires_date datetime default NULL,
  affiliate_date_scheduled datetime default NULL,
  affiliate_date_added datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_date_status_change datetime default NULL,
  affiliate_status int(1) NOT NULL default '1',
  PRIMARY KEY  (affiliate_banners_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS affiliate_banners_history;
CREATE TABLE affiliate_banners_history (
  affiliate_banners_history_id int(11) NOT NULL auto_increment,
  affiliate_banners_products_id int(11) NOT NULL default '0',
  affiliate_banners_id int(11) NOT NULL default '0',
  affiliate_banners_affiliate_id int(11) NOT NULL default '0',
  affiliate_banners_shown int(11) NOT NULL default '0',
  affiliate_banners_clicks tinyint(4) NOT NULL default '0',
  affiliate_banners_history_date date NOT NULL default '0000-00-00',
  PRIMARY KEY  (affiliate_banners_history_id,affiliate_banners_products_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS affiliate_clickthroughs;
CREATE TABLE affiliate_clickthroughs (
  affiliate_clickthrough_id int(11) NOT NULL auto_increment,
  affiliate_id int(11) NOT NULL default '0',
  affiliate_clientdate datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_clientbrowser varchar(200) default 'Нет данных',
  affiliate_clientip varchar(50) default 'Нет данных',
  affiliate_clientreferer varchar(200) default 'не определено (возможно прямая ссылка)',
  affiliate_products_id int(11) default '0',
  affiliate_banner_id int(11) NOT NULL default '0',
  PRIMARY KEY  (affiliate_clickthrough_id),
  KEY refid (affiliate_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS affiliate_payment;
CREATE TABLE affiliate_payment (
  affiliate_payment_id int(11) NOT NULL auto_increment,
  affiliate_id int(11) NOT NULL default '0',
  affiliate_payment decimal(15,2) NOT NULL default '0.00',
  affiliate_payment_tax decimal(15,2) NOT NULL default '0.00',
  affiliate_payment_total decimal(15,2) NOT NULL default '0.00',
  affiliate_payment_date datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_payment_last_modified datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_payment_status int(5) NOT NULL default '0',
  affiliate_firstname varchar(32) NOT NULL default '',
  affiliate_lastname varchar(32) NOT NULL default '',
  affiliate_street_address varchar(64) NOT NULL default '',
  affiliate_suburb varchar(64) NOT NULL default '',
  affiliate_city varchar(32) NOT NULL default '',
  affiliate_postcode varchar(10) NOT NULL default '',
  affiliate_country varchar(32) NOT NULL default '0',
  affiliate_company varchar(60) NOT NULL default '',
  affiliate_state varchar(32) NOT NULL default '0',
  affiliate_address_format_id int(5) NOT NULL default '0',
  affiliate_last_modified datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (affiliate_payment_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS affiliate_payment_status;
CREATE TABLE affiliate_payment_status (
  affiliate_payment_status_id int(11) NOT NULL default '0',
  affiliate_language_id int(11) NOT NULL default '1',
  affiliate_payment_status_name varchar(32) NOT NULL default '',
  PRIMARY KEY  (affiliate_payment_status_id,affiliate_language_id),
  KEY idx_affiliate_payment_status_name (affiliate_payment_status_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS affiliate_payment_status_history;
CREATE TABLE affiliate_payment_status_history (
  affiliate_status_history_id int(11) NOT NULL auto_increment,
  affiliate_payment_id int(11) NOT NULL default '0',
  affiliate_new_value int(5) NOT NULL default '0',
  affiliate_old_value int(5) default NULL,
  affiliate_date_added datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_notified int(1) default '0',
  PRIMARY KEY  (affiliate_status_history_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS affiliate_sales;
CREATE TABLE affiliate_sales (
  affiliate_id int(11) NOT NULL default '0',
  affiliate_date datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_browser varchar(100) NOT NULL default '',
  affiliate_ipaddress varchar(20) NOT NULL default '',
  affiliate_orders_id int(11) NOT NULL default '0',
  affiliate_value decimal(15,2) NOT NULL default '0.00',
  affiliate_payment decimal(15,2) NOT NULL default '0.00',
  affiliate_clickthroughs_id int(11) NOT NULL default '0',
  affiliate_billing_status int(5) NOT NULL default '0',
  affiliate_payment_date datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_payment_id int(11) NOT NULL default '0',
  affiliate_percent  DECIMAL(4,2)  NOT NULL default '0.00',
  affiliate_salesman int(11) NOT NULL default '0',
  affiliate_level tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (affiliate_id,affiliate_orders_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS topics;
CREATE TABLE topics (
  topics_id int(11) NOT NULL auto_increment,
  topics_image varchar(64) default NULL,
  parent_id int(11) NOT NULL default '0',
  sort_order int(3) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  topics_page_url varchar(255),
  PRIMARY KEY  (topics_id),
  KEY idx_topics_parent_id (parent_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS topics_description;
CREATE TABLE topics_description (
  topics_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  topics_name varchar(255) NOT NULL default '',
  topics_heading_title varchar(255) default NULL,
  topics_description text,
  PRIMARY KEY  (topics_id,language_id),
  KEY idx_topics_name (topics_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS articles;
CREATE TABLE articles (
  articles_id int(11) NOT NULL auto_increment,
  articles_date_added datetime NOT NULL default '0000-00-00 00:00:00',
  articles_last_modified datetime default NULL,
  articles_date_available datetime default NULL,
  articles_status tinyint(1) NOT NULL default '0',
  authors_id int(11) default NULL,
  articles_page_url varchar(255),
  sort_order int(4) NOT NULL default '0',
  PRIMARY KEY  (articles_id),
  KEY idx_articles_date_added (articles_date_added)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS articles_description;
CREATE TABLE articles_description (
  articles_id int(11) NOT NULL auto_increment,
  language_id int(11) NOT NULL default '1',
  articles_name varchar(255) NOT NULL default '',
  articles_description text,
  articles_url varchar(255) default NULL,
  articles_viewed int(5) default '0',
  articles_head_title_tag varchar(80) default NULL,
  articles_head_desc_tag text,
  articles_head_keywords_tag text,
  PRIMARY KEY  (articles_id,language_id),
  KEY articles_name (articles_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS articles_to_topics;
CREATE TABLE articles_to_topics (
  articles_id int(11) NOT NULL default '0',
  topics_id int(11) NOT NULL default '0',
  PRIMARY KEY  (articles_id,topics_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

drop table if exists articles_xsell;
create table articles_xsell (
  ID int(10) not null auto_increment,
  articles_id int(10) unsigned default '1' not null ,
  xsell_id int(10) unsigned default '1' not null ,
  sort_order int(10) unsigned default '1' not null ,
  PRIMARY KEY (ID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS authors;
CREATE TABLE authors (
  authors_id int(11) NOT NULL auto_increment,
  authors_name varchar(255) NOT NULL default '',
  authors_image varchar(64) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  PRIMARY KEY  (authors_id),
  KEY IDX_AUTHORS_NAME (authors_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS authors_info;
CREATE TABLE authors_info (
  authors_id int(11) NOT NULL default '0',
  languages_id int(11) NOT NULL default '0',
  authors_description text,
  authors_url varchar(255) NOT NULL default '',
  url_clicked int(5) NOT NULL default '0',
  date_last_click datetime default NULL,
  PRIMARY KEY  (authors_id,languages_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS customers_memo;
CREATE TABLE customers_memo (
  memo_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  memo_date date NOT NULL default '0000-00-00',
  memo_title text,
  memo_text text,
  poster_id int(11) NOT NULL default '0',
  PRIMARY KEY  (memo_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products_xsell;

create table products_extra_fields (
  products_extra_fields_id int(11) not null auto_increment,
  products_extra_fields_name varchar(255) not null ,
  products_extra_fields_order int(3) default '0' not null ,
  products_extra_fields_status tinyint(1) default '1' not null ,
  languages_id int(11) default '0' not null ,
  PRIMARY KEY (products_extra_fields_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

create table products_to_products_extra_fields (
  products_id int(11) default '0' not null ,
  products_extra_fields_id int(11) default '0' not null ,
  products_extra_fields_value varchar(255) ,
  PRIMARY KEY (products_id, products_extra_fields_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE products_xsell (
  ID int(10) NOT NULL auto_increment,
  products_id int(10) unsigned NOT NULL default '1',
  products_xsell_grp_name_id int(10) unsigned NOT NULL default '1',
  xsell_id int(10) unsigned NOT NULL default '1',
  sort_order int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (ID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products_xsell_grp_name;
CREATE TABLE products_xsell_grp_name (
  products_xsell_grp_name_id int(10) NOT NULL,
  xsell_sort_order int(10) NOT NULL default '0',
  language_id smallint(6) NOT NULL default '0',
  groupname varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS campaigns;
CREATE TABLE campaigns (
  campaigns_id int(11) NOT NULL auto_increment,
  campaigns_name varchar(255) NOT NULL default '',
  campaigns_refID varchar(255) default NULL,
  campaigns_leads int(11) NOT NULL default '0',
  date_added datetime default NULL,
  last_modified datetime default NULL,
  PRIMARY KEY  (campaigns_id),
  KEY IDX_CAMPAIGNS_NAME (campaigns_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS campaigns_ip;
CREATE TABLE  campaigns_ip (
 user_ip VARCHAR( 15 ) NOT NULL ,
 time DATETIME NOT NULL ,
 campaign VARCHAR( 32 ) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS address_format;
CREATE TABLE address_format (
  address_format_id int NOT NULL auto_increment,
  address_format varchar(255) NOT NULL,
  address_summary varchar(255) NOT NULL,
  PRIMARY KEY (address_format_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;


DROP TABLE IF EXISTS database_version;
CREATE TABLE database_version (
  version varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS admin_access;
CREATE TABLE `admin_access` (
  `customers_id` varchar(255) NOT NULL default '0',
  `configuration` int(1) NOT NULL default '0',
  `modules` int(1) NOT NULL default '0',
  `countries` int(1) NOT NULL default '0',
  `currencies` int(1) NOT NULL default '0',
  `zones` int(1) NOT NULL default '0',
  `geo_zones` int(1) NOT NULL default '0',
  `tax_classes` int(1) NOT NULL default '0',
  `tax_rates` int(1) NOT NULL default '0',
  `accounting` int(1) NOT NULL default '0',
  `backup` int(1) NOT NULL default '0',
  `cache` int(1) NOT NULL default '0',
  `server_info` int(1) NOT NULL default '0',
  `whos_online` int(1) NOT NULL default '0',
  `languages` int(1) NOT NULL default '0',
  `define_language` int(1) NOT NULL default '0',
  `orders_status` int(1) NOT NULL default '0',
  `shipping_status` int(1) NOT NULL default '0',
  `module_export` int(1) NOT NULL default '0',
  `customers` int(1) NOT NULL default '0',
  `create_account` int(1) NOT NULL default '0',
  `customers_status` int(1) NOT NULL default '0',
  `orders` int(1) NOT NULL default '0',
  `campaigns` int(1) NOT NULL default '0',
  `print_packingslip` int(1) NOT NULL default '0',
  `print_order` int(1) NOT NULL default '0',
  `popup_memo` int(1) NOT NULL default '0',
  `coupon_admin` int(1) NOT NULL default '0',
  `listcategories` int(1) NOT NULL default '0',
  `gv_queue` int(1) NOT NULL default '0',
  `gv_mail` int(1) NOT NULL default '0',
  `gv_sent` int(1) NOT NULL default '0',
  `validproducts` int(1) NOT NULL default '0',
  `validcategories` int(1) NOT NULL default '0',
  `mail` int(1) NOT NULL default '0',
  `categories` int(1) NOT NULL default '0',
  `new_attributes` int(1) NOT NULL default '0',
  `products_attributes` int(1) NOT NULL default '0',
  `manufacturers` int(1) NOT NULL default '0',
  `reviews` int(1) NOT NULL default '0',
  `specials` int(1) NOT NULL default '0',
  `stats_products_expected` int(1) NOT NULL default '0',
  `stats_products_viewed` int(1) NOT NULL default '0',
  `stats_products_purchased` int(1) NOT NULL default '0',
  `stats_customers` int(1) NOT NULL default '0',
  `stats_sales_report` int(1) NOT NULL default '0',
  `stats_campaigns` int(1) NOT NULL default '0',
  `banner_manager` int(1) NOT NULL default '0',
  `banner_statistics` int(1) NOT NULL default '0',
  `module_newsletter` int(1) NOT NULL default '0',
  `start` int(1) NOT NULL default '0',
  `content_manager` int(1) NOT NULL default '0',
  `content_preview` int(1) NOT NULL default '0',
  `credits` int(1) NOT NULL default '0',
  `blacklist` int(1) NOT NULL default '0',
  `orders_edit` int(1) NOT NULL default '0',
  `popup_image` int(1) NOT NULL default '0',
  `csv_backend` int(1) NOT NULL default '0',
  `products_vpe` int(1) NOT NULL default '0',
  `cross_sell_groups` int(1) NOT NULL default '0',
  `fck_wrapper` int(1) NOT NULL default '0',
  `easypopulate` int(1) NOT NULL default '0',
  `quick_updates` int(1) NOT NULL default '0',
  `latest_news` int(1) NOT NULL default '0',
  `recover_cart_sales` int(1) NOT NULL default '0',
  `featured` int(1) NOT NULL default '0',
  `cip_manager` int(1) NOT NULL default '0',
  `authors` int(1) NOT NULL default '0',
  `articles` int(1) NOT NULL default '0',
  `articles_config` int(1) NOT NULL default '0',
  `stats_sales_report2` int(1) NOT NULL default '0',
  `chart_data` int(1) NOT NULL default '0',
  `articles_xsell` int(1) NOT NULL default '0',
  `email_manager` int(1) NOT NULL default '0',
  `category_specials` int(1) NOT NULL default '0',
  `products_options` int(1) NOT NULL default '0',
  `product_extra_fields` int(1) NOT NULL default '0',
  `ship2pay` int(1) NOT NULL default '0',
  `faq` int(1) NOT NULL default '0',
  `affiliate_affiliates` int(1) NOT NULL default '0',
  `affiliate_banners` int(1) NOT NULL default '0',
  `affiliate_clicks` int(1) NOT NULL default '0',
  `affiliate_contact` int(1) NOT NULL default '0',
  `affiliate_invoice` int(1) NOT NULL default '0',
  `affiliate_payment` int(1) NOT NULL default '0',
  `affiliate_popup_image` int(1) NOT NULL default '0',
  `affiliate_sales` int(1) NOT NULL default '0',
  `affiliate_statistics` int(1) NOT NULL default '0',
  `affiliate_summary` int(1) NOT NULL default '0',
  `customer_extra_fields` int(1) NOT NULL default '0',
  `select_featured` int(1) NOT NULL default '0',
  `select_special` int(1) NOT NULL default '0',
  `yml_import` int(1) NOT NULL default '0',
  `customer_export` int(1) NOT NULL default '0',
  `exportorders` int(1) NOT NULL default '0',
  `pin_loader` int(1) NOT NULL default '0',
  `edit_orders` int(1) NOT NULL default '0',
  `edit_orders_add_product` int(1) NOT NULL default '0',
  `edit_orders_ajax` int(1) NOT NULL default '0',
  `products_specifications` int(1) NOT NULL default '0',
  `attributeManager` int(1) NOT NULL default '0',
  PRIMARY KEY  (`customers_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;


DROP TABLE IF EXISTS banktransfer;
CREATE TABLE banktransfer (
  orders_id int(11) NOT NULL default '0',
  banktransfer_owner varchar(255) default NULL,
  banktransfer_number varchar(24) default NULL,
  banktransfer_bankname varchar(255) default NULL,
  banktransfer_blz varchar(8) default NULL,
  banktransfer_status int(11) default NULL,
  banktransfer_prz char(2) default NULL,
  banktransfer_fax char(2) default NULL,
  KEY orders_id(orders_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS companies;
CREATE TABLE companies (
  orders_id int(11) NOT NULL default '0',
  customers_id int(11) NOT NULL default '0',
  name varchar(255) default NULL,
  inn varchar(255) default NULL,
  kpp varchar(255) default NULL,
  ogrn varchar(255) default NULL,
  okpo varchar(255) default NULL,
  rs varchar(255) default NULL,
  bank_name varchar(255) default NULL,
  bik varchar(255) default NULL,
  ks varchar(255) default NULL,
  address varchar(255) default NULL,
  yur_address varchar(255) default NULL,
  fakt_address varchar(255) default NULL,
  telephone varchar(255) default NULL,
  fax varchar(255) default NULL,
  email varchar(255) default NULL,
  director varchar(255) default NULL,
  accountant varchar(255) default NULL,
  KEY orders_id(orders_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS persons;
CREATE TABLE persons (
  orders_id int(11) NOT NULL default '0',
  customers_id int(11) NOT NULL default '0',
  name varchar(255) default NULL,
  address varchar(255) default NULL,
  KEY orders_id(orders_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS banners;
CREATE TABLE banners (
  banners_id int NOT NULL auto_increment,
  banners_title varchar(255) NOT NULL,
  banners_url varchar(255) NOT NULL,
  banners_image varchar(255) NOT NULL,
  banners_group varchar(10) NOT NULL,
  banners_html_text text,
  expires_impressions int(7) DEFAULT '0',
  expires_date datetime DEFAULT NULL,
  date_scheduled datetime DEFAULT NULL,
  date_added datetime NOT NULL,
  date_status_change datetime DEFAULT NULL,
  status int(1) DEFAULT '1' NOT NULL,
  PRIMARY KEY  (banners_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS banners_history;
CREATE TABLE banners_history (
  banners_history_id int NOT NULL auto_increment,
  banners_id int NOT NULL,
  banners_shown int(5) NOT NULL DEFAULT '0',
  banners_clicked int(5) NOT NULL DEFAULT '0',
  banners_history_date datetime NOT NULL,
  PRIMARY KEY  (banners_history_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
  categories_id int NOT NULL auto_increment,
  categories_image varchar(255),
  parent_id int DEFAULT '0' NOT NULL,
  categories_status TINYint (1)  UNSIGNED DEFAULT "1" NOT NULL,
  categories_template varchar(255),
  group_permission_0 tinyint(1) NOT NULL,
  group_permission_1 tinyint(1) NOT NULL,
  group_permission_2 tinyint(1) NOT NULL,
  group_permission_3 tinyint(1) NOT NULL,
  listing_template varchar(255),
  sort_order int(3) DEFAULT "0" NOT NULL,
  products_sorting varchar(255),
  products_sorting2 varchar(255),
  date_added datetime,
  last_modified datetime,
  yml_bid varchar(4) NOT NULL DEFAULT '0',
  yml_cbid varchar(4) NOT NULL DEFAULT '0',
  categories_url varchar(255),
  yml_enable tinyint(1) NOT NULL default '1',
  PRIMARY KEY (categories_id),
  KEY idx_categories_parent_id (parent_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS categories_description;
CREATE TABLE categories_description (
  categories_id int DEFAULT '0' NOT NULL,
  language_id int DEFAULT '1' NOT NULL,
  categories_name varchar(255) NOT NULL,
  categories_heading_title varchar(255) NOT NULL,
  categories_description text,
  categories_meta_title varchar(255) NOT NULL,
  categories_meta_description varchar(255) NOT NULL,
  categories_meta_keywords varchar(255) NOT NULL,
  PRIMARY KEY (categories_id, language_id),
  KEY idx_categories_name (categories_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS configuration;
CREATE TABLE `configuration` (
  `configuration_id` int(11) NOT NULL auto_increment,
  `configuration_key` varchar(255) NOT NULL default '',
  `configuration_value` text,
  `configuration_group_id` int(11) NOT NULL default '0',
  `sort_order` int(5) default NULL,
  `last_modified` datetime default NULL,
  `date_added` datetime NOT NULL default '0000-00-00 00:00:00',
  `use_function` varchar(255) default NULL,
  `set_function` varchar(255) default NULL,
  PRIMARY KEY  (`configuration_id`),
  KEY `idx_configuration_group_id` (`configuration_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS configuration_group;
CREATE TABLE configuration_group (
  configuration_group_id int NOT NULL auto_increment,
  configuration_group_key varchar(255) NOT NULL,
  configuration_group_title varchar(255) NOT NULL,
  configuration_group_description varchar(255) NOT NULL,
  sort_order int(5) NULL,
  visible int(1) DEFAULT '1' NULL,
  PRIMARY KEY (configuration_group_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS counter;
CREATE TABLE counter (
  startdate char(8),
  counter int(12)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS counter_history;
CREATE TABLE counter_history (
  month char(8),
  counter int(12)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS countries;
CREATE TABLE countries (
  countries_id int NOT NULL auto_increment,
  countries_name varchar(255) NOT NULL,
  countries_iso_code_2 char(2) NOT NULL,
  countries_iso_code_3 char(3) NOT NULL,
  address_format_id int NOT NULL,
  status int(1) DEFAULT '1' NULL,  
  PRIMARY KEY (countries_id),
  KEY IDX_COUNTRIES_NAME (countries_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS currencies;
CREATE TABLE currencies (
  currencies_id int NOT NULL auto_increment,
  title varchar(255) NOT NULL,
  code char(3) NOT NULL,
  symbol_left varchar(12),
  symbol_right varchar(12),
  decimal_point char(1),
  thousands_point char(1),
  decimal_places char(1),
  value float(13,8),
  last_updated datetime NULL,
  PRIMARY KEY (currencies_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS customers;
CREATE TABLE customers (
  customers_id int NOT NULL auto_increment,
  customers_cid varchar(255),
  customers_vat_id varchar (20) DEFAULT NULL,
  customers_vat_id_status int(2) DEFAULT '0' NOT NULL,
  customers_warning varchar(255),
  customers_status int(5) DEFAULT '1' NOT NULL,
  customers_gender char(1) NOT NULL,
  customers_firstname varchar(255) NOT NULL,
  customers_secondname varchar(255) NOT NULL,
  customers_lastname varchar(255) NOT NULL,
  customers_dob datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  customers_email_address varchar(96) NOT NULL,
  customers_default_address_id int NOT NULL,
  customers_telephone varchar(255) NOT NULL,
  customers_fax varchar(255),
  customers_password varchar(40) NOT NULL,
  customers_newsletter char(1),
  customers_newsletter_mode char( 1 ) DEFAULT '0' NOT NULL,
  member_flag char(1) DEFAULT '0' NOT NULL,
  delete_user char(1) DEFAULT '1' NOT NULL,
  account_type int(1) NOT NULL default '0',
  password_request_key varchar(255) NOT NULL,
  payment_unallowed varchar(255) NOT NULL,
  shipping_unallowed varchar(255) NOT NULL,
  refferers_id int(5) DEFAULT '0' NOT NULL,
  customers_date_added datetime DEFAULT '0000-00-00 00:00:00',
  customers_last_modified datetime DEFAULT '0000-00-00 00:00:00',
  orig_reference text,
  login_reference text,
  login_tries char(2) NOT NULL default '0',
  login_time datetime NOT NULL default '0000-00-00 00:00:00',
  customers_username VARCHAR(64) DEFAULT NULL,
  customers_fid INT(5) DEFAULT NULL,
  customers_sid INT(5) DEFAULT NULL,
  customers_personal_discount decimal(4,2) DEFAULT '0',
  PRIMARY KEY (customers_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE customers_to_manufacturers_discount (
  discount_id int(11) NOT NULL auto_increment,
  customers_id int(11) default NULL,
  manufacturers_id int(11) default NULL,
  discount decimal(4,2) default NULL,
  PRIMARY KEY  (discount_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS customers_basket;
CREATE TABLE customers_basket (
  customers_basket_id int NOT NULL auto_increment,
  customers_id int NOT NULL,
  products_id tinytext,
  customers_basket_quantity int(2) NOT NULL,
  final_price decimal(15,4) NOT NULL,
  customers_basket_date_added char(8),
  PRIMARY KEY (customers_basket_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS customers_basket_attributes;
CREATE TABLE customers_basket_attributes (
  customers_basket_attributes_id int NOT NULL auto_increment,
  customers_id int NOT NULL,
  products_id tinytext,
  products_options_id int NOT NULL,
  products_options_value_id int NOT NULL,
  products_options_value_text text,
  PRIMARY KEY (customers_basket_attributes_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS customers_info;
CREATE TABLE customers_info (
  customers_info_id int NOT NULL,
  customers_info_date_of_last_logon datetime,
  customers_info_number_of_logons int(5),
  customers_info_date_account_created datetime,
  customers_info_date_account_last_modified datetime,
  global_product_notifications int(1) DEFAULT '0',
  PRIMARY KEY (customers_info_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS customers_ip;
CREATE TABLE customers_ip (
  customers_ip_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  customers_ip varchar(15) NOT NULL default '',
  customers_ip_date datetime NOT NULL default '0000-00-00 00:00:00',
  customers_host varchar(255) NOT NULL default '',
  customers_advertiser varchar(30) default NULL,
  customers_referer_url varchar(255) default NULL,
  PRIMARY KEY  (customers_ip_id),
  KEY customers_id (customers_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS customers_status;
CREATE TABLE customers_status (
  customers_status_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL DEFAULT '1',
  customers_status_name varchar(255) NOT NULL DEFAULT '',
  customers_status_public int(1) NOT NULL DEFAULT '1',
  customers_status_min_order int(7) DEFAULT NULL,
  customers_status_max_order int(7) DEFAULT NULL,
  customers_status_image varchar(255) DEFAULT NULL,
  customers_status_discount decimal(4,2) DEFAULT '0',
  customers_status_ot_discount_flag char(1) NOT NULL DEFAULT '0',
  customers_status_ot_discount decimal(4,2) DEFAULT '0',
  customers_status_graduated_prices varchar(1) NOT NULL DEFAULT '0',
  customers_status_show_price int(1) NOT NULL DEFAULT '1',
  customers_status_show_price_tax int(1) NOT NULL DEFAULT '1',
  customers_status_add_tax_ot  int(1) NOT NULL DEFAULT '0',
  customers_status_payment_unallowed varchar(255) NOT NULL,
  customers_status_shipping_unallowed varchar(255) NOT NULL,
  customers_status_discount_attributes  int(1) NOT NULL DEFAULT '0',
  customers_fsk18 int(1) NOT NULL DEFAULT '1',
  customers_fsk18_display int(1) NOT NULL DEFAULT '1',
  customers_status_write_reviews int(1) NOT NULL DEFAULT '1',
  customers_status_read_reviews int(1) NOT NULL DEFAULT '1',
  customers_status_accumulated_limit decimal(15,4) DEFAULT '0' ,
  PRIMARY KEY  (customers_status_id,language_id),
  KEY idx_orders_status_name (customers_status_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS customers_status_orders_status;
CREATE TABLE customers_status_orders_status (
  customers_status_id int(11) default '0' not null ,
  orders_status_id int(11) default '0' not null
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS customers_status_history;
CREATE TABLE customers_status_history (
  customers_status_history_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  new_value int(5) NOT NULL default '0',
  old_value int(5) default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  customer_notified int(1) default '0',
  PRIMARY KEY  (customers_status_history_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS customers_to_extra_field;
CREATE TABLE customers_to_extra_fields (
  customers_id int(11) NOT NULL default '0',
  fields_id int(11) NOT NULL default '0',
  value text
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS extra_fields;
CREATE TABLE extra_fields (
  fields_id int(11) not null auto_increment,
  fields_input_type int(11) default '0' not null ,
  fields_input_value text,
  fields_status tinyint(2) default '0' not null ,
  fields_required_status tinyint(2) default '0' not null ,
  fields_size int(5) default '0' not null ,
  fields_required_email tinyint(2) default '0' not null ,
  PRIMARY KEY (fields_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS extra_fields_info;
CREATE TABLE extra_fields_info (
  fields_id int(11) NOT NULL default '0',
  languages_id int(11) NOT NULL default '0',
  fields_name varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS faq;
CREATE TABLE faq (
   faq_id int(11) NOT NULL AUTO_INCREMENT,
   question varchar(255) NOT NULL,
   answer text,
   date_added datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   language int(11) NOT NULL default '1',
   status tinyint(1) DEFAULT '0' NOT NULL,
   faq_page_url varchar(255),
   PRIMARY KEY (faq_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS languages;
CREATE TABLE languages (
  languages_id int NOT NULL auto_increment,
  name varchar(255)  NOT NULL,
  code char(2) NOT NULL,
  image varchar(255),
  directory varchar(255),
  sort_order int(3),
  language_charset text,
  PRIMARY KEY (languages_id),
  KEY IDX_LANGUAGES_NAME (name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS latest_news;
CREATE TABLE latest_news (
   news_id int(11) NOT NULL AUTO_INCREMENT,
   headline varchar(255) NOT NULL,
   content text,
   date_added datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   language int(11) NOT NULL default '1',
   status tinyint(1) DEFAULT '0' NOT NULL,
   news_page_url varchar(255),
   PRIMARY KEY (news_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS manufacturers;
CREATE TABLE manufacturers (
  manufacturers_id int NOT NULL auto_increment,
  manufacturers_name varchar(255) NOT NULL,
  manufacturers_image varchar(255),
  date_added datetime NULL,
  last_modified datetime NULL,
  PRIMARY KEY (manufacturers_id),
  KEY IDX_MANUFACTURERS_NAME (manufacturers_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS manufacturers_info;
CREATE TABLE manufacturers_info (
  manufacturers_id int NOT NULL,
  languages_id int NOT NULL,
  manufacturers_meta_title varchar(255) NOT NULL,
  manufacturers_meta_description varchar(255) NOT NULL,
  manufacturers_meta_keywords varchar(255) NOT NULL,
  manufacturers_url varchar(255) NOT NULL,
  manufacturers_description varchar(255) NOT NULL,
  url_clicked int(5) NOT NULL default '0',
  date_last_click datetime NULL,
  PRIMARY KEY (manufacturers_id, languages_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS newsletters;
CREATE TABLE newsletters (
  newsletters_id int NOT NULL auto_increment,
  title varchar(255) NOT NULL,
  content text,
  module varchar(255) NOT NULL,
  date_added datetime NOT NULL,
  date_sent datetime,
  status int(1),
  locked int(1) DEFAULT '0',
  PRIMARY KEY (newsletters_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS newsletter_recipients;
CREATE TABLE newsletter_recipients (
  mail_id int(11) NOT NULL auto_increment,
  customers_email_address varchar(96) NOT NULL default '',
  customers_id int(11) NOT NULL default '0',
  customers_status int(5) NOT NULL default '0',
  customers_firstname varchar(255) NOT NULL default '',
  customers_lastname varchar(255) NOT NULL default '',
  mail_status int(1) NOT NULL default '0',
  mail_key varchar(255) NOT NULL default '',
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (mail_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS newsletters_history;
CREATE TABLE newsletters_history (
  news_hist_id int(11) NOT NULL default '0',
  news_hist_cs int(11) NOT NULL default '0',
  news_hist_cs_date_sent date default NULL,
  PRIMARY KEY  (news_hist_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
  orders_id int NOT NULL auto_increment,
  customers_id int NOT NULL,
  customers_cid varchar(255),
  customers_vat_id varchar (20) DEFAULT NULL,
  customers_status int(11),
  customers_status_name varchar(255) NOT NULL,
  customers_status_image varchar (64),
  customers_status_discount decimal (4,2),
  customers_name varchar(255) NOT NULL,
  customers_firstname varchar(255) NOT NULL,
  customers_secondname varchar(255) NOT NULL,
  customers_lastname varchar(255) NOT NULL,
  customers_company varchar(255),
  customers_street_address varchar(255) NOT NULL,
  customers_suburb varchar(255),
  customers_city varchar(255) NOT NULL,
  customers_postcode varchar(10) NOT NULL,
  customers_state varchar(255),
  customers_country varchar(255) NOT NULL,
  customers_telephone varchar(255) NOT NULL,
  customers_email_address varchar(96) NOT NULL,
  customers_address_format_id int(5) NOT NULL,
  delivery_name varchar(255) NOT NULL,
  delivery_firstname varchar(255) NOT NULL,
  delivery_secondname varchar(255) NOT NULL,
  delivery_lastname varchar(255) NOT NULL,
  delivery_company varchar(255),
  delivery_street_address varchar(255) NOT NULL,
  delivery_suburb varchar(255),
  delivery_city varchar(255) NOT NULL,
  delivery_postcode varchar(10) NOT NULL,
  delivery_state varchar(255),
  delivery_country varchar(255) NOT NULL,
  delivery_country_iso_code_2 char(2) NOT NULL,
  delivery_address_format_id int(5) NOT NULL,
  billing_name varchar(255) NOT NULL,
  billing_firstname varchar(255) NOT NULL,
  billing_secondname varchar(255) NOT NULL,
  billing_lastname varchar(255) NOT NULL,
  billing_company varchar(255),
  billing_street_address varchar(255) NOT NULL,
  billing_suburb varchar(255),
  billing_city varchar(255) NOT NULL,
  billing_postcode varchar(10) NOT NULL,
  billing_state varchar(255),
  billing_country varchar(255) NOT NULL,
  billing_country_iso_code_2 char(2) NOT NULL,
  billing_address_format_id int(5) NOT NULL,
  payment_method varchar(255) NOT NULL,
  cc_type varchar(20),
  cc_owner varchar(255),
  cc_number varchar(255),
  cc_expires varchar(4),
  cc_start varchar(4) default NULL,
  cc_issue varchar(3) default NULL,
  cc_cvv varchar(4) default NULL,
  comments varchar (255),
  last_modified datetime,
  date_purchased datetime,
  orders_status int(5) NOT NULL,
  orders_date_finished datetime,
  currency char(3),
  currency_value decimal(14,6),
  account_type int(1) DEFAULT '0' NOT NULL,
  payment_class varchar(255) NOT NULL,
  shipping_method varchar(255) NOT NULL,
  shipping_class varchar(255) NOT NULL,
  customers_ip varchar(255) NOT NULL,
  language varchar(255) NOT NULL,
  afterbuy_success INT(1) DEFAULT'0' NOT NULL,
  afterbuy_id INT(32) DEFAULT '0' NOT NULL,
  refferers_id varchar(255) NOT NULL,
  conversion_type INT(1) DEFAULT '0' NOT NULL,
  orders_ident_key varchar(255),
  orig_reference text,
  login_reference text,
  PRIMARY KEY (orders_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS card_blacklist;
CREATE TABLE card_blacklist (
  blacklist_id int(5) NOT NULL auto_increment,
  blacklist_card_number varchar(20) NOT NULL default '',
  date_added datetime default NULL,
  last_modified datetime default NULL,
  KEY blacklist_id (blacklist_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS orders_products;
CREATE TABLE orders_products (
  orders_products_id int NOT NULL auto_increment,
  orders_id int NOT NULL,
  products_id int NOT NULL,
  products_model varchar(255),
  products_name varchar(255) NOT NULL,
  products_price decimal(15,4) NOT NULL,
  products_discount_made decimal(4,2) DEFAULT NULL,
  products_shipping_time varchar(255) DEFAULT NULL,
  final_price decimal(15,4) NOT NULL,
  products_tax decimal(7,4) NOT NULL,
  products_quantity int(2) NOT NULL,
  allow_tax int(1) NOT NULL,
  PRIMARY KEY (orders_products_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS orders_status;
CREATE TABLE orders_status (
  orders_status_id int DEFAULT '0' NOT NULL,
  language_id int DEFAULT '1' NOT NULL,
  orders_status_name varchar(255) NOT NULL,
  PRIMARY KEY (orders_status_id, language_id),
  KEY idx_orders_status_name (orders_status_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS shipping_status;
CREATE TABLE shipping_status (
  shipping_status_id int DEFAULT '0' NOT NULL,
  language_id int DEFAULT '1' NOT NULL,
  shipping_status_name varchar(255) NOT NULL,
  shipping_status_image varchar(255) NOT NULL,
  PRIMARY KEY (shipping_status_id, language_id),
  KEY idx_shipping_status_name (shipping_status_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE ship2pay (
s2p_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
shipment VARCHAR( 100 ) NOT NULL ,
payments_allowed VARCHAR( 250 ) NOT NULL ,
zones_id int(11) default '0' not null ,
status TINYINT NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS orders_status_history;
CREATE TABLE orders_status_history (
  orders_status_history_id int NOT NULL auto_increment,
  orders_id int NOT NULL,
  orders_status_id int(5) NOT NULL,
  date_added datetime NOT NULL,
  customer_notified int(1) DEFAULT '0',
  comments text,
  PRIMARY KEY (orders_status_history_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS orders_products_attributes;
CREATE TABLE orders_products_attributes (
  orders_products_attributes_id int NOT NULL auto_increment,
  orders_id int NOT NULL,
  orders_products_id int NOT NULL,
  products_options varchar(255) NOT NULL,
  products_options_values varchar(255) NOT NULL,
  options_values_price decimal(15,4) NOT NULL,
  price_prefix char(1) NOT NULL,
  PRIMARY KEY (orders_products_attributes_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS orders_products_download;
CREATE TABLE orders_products_download (
  orders_products_download_id int NOT NULL auto_increment,
  orders_id int NOT NULL default '0',
  orders_products_id int NOT NULL default '0',
  orders_products_filename varchar(255) NOT NULL default '',
  download_maxdays int(2) NOT NULL default '0',
  download_count int(2) NOT NULL default '0',
  download_is_pin tinyint(1) default '0' not null ,
  download_pin_code varchar(255) not null ,
  PRIMARY KEY  (orders_products_download_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS orders_total;
CREATE TABLE orders_total (
  orders_total_id int unsigned NOT NULL auto_increment,
  orders_id int NOT NULL,
  title varchar(255) NOT NULL,
  text varchar(255) NOT NULL,
  value decimal(15,4) NOT NULL,
  class varchar(255) NOT NULL,
  sort_order int NOT NULL,
  PRIMARY KEY (orders_total_id),
  KEY idx_orders_total_orders_id (orders_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS orders_recalculate;
CREATE TABLE orders_recalculate (
  orders_recalculate_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  n_price decimal(15,4) NOT NULL default '0.0000',
  b_price decimal(15,4) NOT NULL default '0.0000',
  tax decimal(15,4) NOT NULL default '0.0000',
  tax_rate decimal(7,4) NOT NULL default '0.0000',
  class varchar(255) NOT NULL default '',
  PRIMARY KEY  (orders_recalculate_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products;
CREATE TABLE products (
  products_id int NOT NULL auto_increment,
  products_ean varchar(255),
  products_quantity int(4) NOT NULL,
  products_quantity_min int(4) NOT NULL DEFAULT '1',
  products_quantity_max int(4) NOT NULL DEFAULT '1000',
  products_shippingtime int(4) NOT NULL,
  products_model varchar(255),
  group_permission_0 tinyint(1) NOT NULL,
  group_permission_1 tinyint(1) NOT NULL,
  group_permission_2 tinyint(1) NOT NULL,
  group_permission_3 tinyint(1) NOT NULL,
  products_sort int(4) NOT NULL DEFAULT '0',
  products_image varchar(255),
  products_price decimal(15,4) NOT NULL,
  products_discount_allowed decimal(15,4) DEFAULT '0' NOT NULL,
  products_date_added datetime NOT NULL,
  products_last_modified datetime,
  products_date_available datetime,
  products_weight decimal(5,2) NOT NULL,
  products_status tinyint(1) NOT NULL,
  products_tax_class_id int NOT NULL,
  product_template varchar (64),
  options_template varchar (64),
  manufacturers_id int NULL,
  products_ordered int NOT NULL default '0',
  products_fsk18 int(1) NOT NULL DEFAULT '0',
  products_vpe int(11) NOT NULL,
  products_vpe_status int(1) NOT NULL DEFAULT '0',
  products_vpe_value decimal(15,4) NOT NULL,
  products_startpage int(1) NOT NULL DEFAULT '0',
  products_startpage_sort int(4) NOT NULL DEFAULT '0',
  products_to_xml tinyint(1) NOT NULL DEFAULT '1',
  yml_bid varchar(4) NOT NULL DEFAULT '0',
  yml_cbid varchar(4) NOT NULL DEFAULT '0',
  products_page_url varchar(255),
  PRIMARY KEY (products_id),
  KEY idx_products_date_added (products_date_added)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;



DROP TABLE IF EXISTS products_attributes;
CREATE TABLE products_attributes (
  products_attributes_id int NOT NULL auto_increment,
  products_id int NOT NULL,
  options_id int NOT NULL,
  options_values_id int NOT NULL,
  options_values_price decimal(15,4) NOT NULL,
  price_prefix char(1) NOT NULL,
  attributes_model varchar(255) NULL,
  attributes_stock int(4) NULL,
  options_values_weight decimal(15,4) NOT NULL,
  weight_prefix char(1) NOT NULL,
  sortorder int(11) NULL,
  PRIMARY KEY  (products_attributes_id),
  KEY PRODUCTS_ID_INDEX (products_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products_attributes_download;
CREATE TABLE products_attributes_download (
  products_attributes_id int NOT NULL,
  products_attributes_filename varchar(255) NOT NULL default '',
  products_attributes_maxdays int(2) default '0',
  products_attributes_maxcount int(2) default '0',
  products_attributes_is_pin tinyint(1) null default '0' ,
  PRIMARY KEY  (products_attributes_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products_description;
CREATE TABLE products_description (
  products_id int NOT NULL auto_increment,
  language_id int NOT NULL default '1',
  products_name varchar(255) NOT NULL default '',
  products_description text,
  products_short_description text,
  products_keywords VARCHAR(255) DEFAULT NULL,
  products_meta_title text,
  products_meta_description text,
  products_meta_keywords text,
  products_url varchar(255) default NULL,
  products_viewed int(5) default '0',
  PRIMARY KEY  (products_id,language_id),
  KEY products_name (products_name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products_pins;
CREATE TABLE products_pins (
  products_pin_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL,
  products_pin_code char(250) NOT NULL,
  products_pin_used tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (products_pin_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products_images;
CREATE TABLE products_images (
  image_id INT NOT NULL auto_increment,
  products_id INT NOT NULL ,
  image_nr SMALLINT NOT NULL ,
  image_name VARCHAR( 254 ) NOT NULL ,
  PRIMARY KEY ( image_id )
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products_notifications;
CREATE TABLE products_notifications (
  products_id int NOT NULL,
  customers_id int NOT NULL,
  date_added datetime NOT NULL,
  PRIMARY KEY (products_id, customers_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products_options;
CREATE TABLE products_options (
  products_options_id int NOT NULL default '0',
  language_id int NOT NULL default '1',
  products_options_name varchar(255) NOT NULL default '',
  products_options_length INT( 11 ) DEFAULT '32' NOT NULL ,
  products_options_size INT( 11 ) DEFAULT '32' NOT NULL ,
  products_options_rows INT( 11 ) DEFAULT '4' NOT NULL,
  products_options_type INT( 11 ) NOT NULL,
  PRIMARY KEY  (products_options_id,language_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products_options_values;
CREATE TABLE products_options_values (
  products_options_values_id int NOT NULL default '0',
  language_id int NOT NULL default '1',
  products_options_values_name varchar(255) NOT NULL default '',
  products_options_values_description text,
  products_options_values_text varchar(255) NOT NULL default '',
  products_options_values_image varchar(255) NOT NULL default '',
  products_options_values_link varchar(255) NOT NULL default '',
  PRIMARY KEY  (products_options_values_id,language_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products_options_values_to_products_options;
CREATE TABLE products_options_values_to_products_options (
  products_options_values_to_products_options_id int NOT NULL auto_increment,
  products_options_id int NOT NULL,
  products_options_values_id int NOT NULL,
  PRIMARY KEY (products_options_values_to_products_options_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products_graduated_prices;
CREATE TABLE products_graduated_prices (
  products_id int(11) NOT NULL default '0',
  quantity int(11) NOT NULL default '0',
  unitprice decimal(15,4) NOT NULL default '0.0000',
  KEY products_id (products_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products_to_categories;
CREATE TABLE products_to_categories (
  products_id int NOT NULL,
  categories_id int NOT NULL,
  PRIMARY KEY (products_id,categories_id),
  KEY idx_categories_id (categories_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products_vpe;
CREATE TABLE products_vpe (
  products_vpe_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '0',
  products_vpe_name varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS reviews;
CREATE TABLE reviews (
  reviews_id int NOT NULL auto_increment,
  products_id int NOT NULL,
  customers_id int,
  customers_name varchar(255) NOT NULL,
  reviews_rating int(1),
  date_added datetime,
  last_modified datetime,
  reviews_read int(5) NOT NULL default '0',
  PRIMARY KEY (reviews_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS reviews_description;
CREATE TABLE reviews_description (
  reviews_id int NOT NULL,
  languages_id int NOT NULL,
  reviews_text text,
  PRIMARY KEY (reviews_id, languages_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS scart;
CREATE TABLE scart (
  scartid INT(11) NOT NULL AUTO_INCREMENT,
  customers_id INT(11) NOT NULL ,
  dateadded VARCHAR(8) NOT NULL ,
  PRIMARY KEY (scartid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions (
  sesskey varchar(255) NOT NULL,
  expiry int(11) unsigned NOT NULL,
  value text,
  PRIMARY KEY (sesskey)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS specials;
CREATE TABLE specials (
  specials_id int NOT NULL auto_increment,
  products_id int NOT NULL,
  specials_quantity int(4) NOT NULL,
  specials_new_products_price decimal(15,4) NOT NULL,
  specials_date_added datetime,
  specials_last_modified datetime,
  expires_date datetime,
  date_status_change datetime,
  status int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (specials_id),
  KEY idx_products_id (products_id),
  KEY PRODUCTS_ID_INDEX (products_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

drop table if exists special_category;
create table special_category (
  special_id int(11) unsigned NOT NULL auto_increment,
  categ_id int(11) unsigned NOT NULL default '0',
  discount decimal(5,2) NOT NULL default '0.00',
  discount_type enum('p','f') NOT NULL default 'f',
  special_date_added datetime NOT NULL default '0000-00-00 00:00:00',
  special_last_modified datetime NOT NULL default '0000-00-00 00:00:00',
  expire_date datetime NOT NULL default '0000-00-00 00:00:00',
  date_status_change datetime NOT NULL default '0000-00-00 00:00:00',
  status tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (special_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

drop table if exists special_product;
create table special_product (
  special_product_id int(11) unsigned NOT NULL auto_increment,
  special_id int(11) unsigned NOT NULL default '0',
  product_id int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (special_product_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS featured;
CREATE TABLE featured (
  featured_id int NOT NULL auto_increment,
  products_id int NOT NULL,
  featured_quantity int(4) NOT NULL,
  featured_date_added datetime,
  featured_last_modified datetime,
  expires_date datetime,
  date_status_change datetime,
  status int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (featured_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS tax_class;
CREATE TABLE tax_class (
  tax_class_id int NOT NULL auto_increment,
  tax_class_title varchar(255) NOT NULL,
  tax_class_description varchar(255) NOT NULL,
  last_modified datetime NULL,
  date_added datetime NOT NULL,
  PRIMARY KEY (tax_class_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS tax_rates;
CREATE TABLE tax_rates (
  tax_rates_id int NOT NULL auto_increment,
  tax_zone_id int NOT NULL,
  tax_class_id int NOT NULL,
  tax_priority int(5) DEFAULT 1,
  tax_rate decimal(7,4) NOT NULL,
  tax_description varchar(255) NOT NULL,
  last_modified datetime NULL,
  date_added datetime NOT NULL,
  PRIMARY KEY (tax_rates_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS geo_zones;
CREATE TABLE geo_zones (
  geo_zone_id int NOT NULL auto_increment,
  geo_zone_name varchar(255) NOT NULL,
  geo_zone_description varchar(255) NOT NULL,
  last_modified datetime NULL,
  date_added datetime NOT NULL,
  PRIMARY KEY (geo_zone_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS whos_online;
CREATE TABLE whos_online (
  customer_id int,
  full_name varchar(255) NOT NULL,
  session_id varchar(255) NOT NULL,
  ip_address varchar(15) NOT NULL,
  time_entry varchar(14) NOT NULL,
  time_last_click varchar(14) NOT NULL,
  last_page_url varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS zones;
CREATE TABLE zones (
  zone_id int NOT NULL auto_increment,
  zone_country_id int NOT NULL,
  zone_code varchar(255) NOT NULL,
  zone_name varchar(255) NOT NULL,
  PRIMARY KEY (zone_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS zones_to_geo_zones;
CREATE TABLE zones_to_geo_zones (
   association_id int NOT NULL auto_increment,
   zone_country_id int NOT NULL,
   zone_id int NULL,
   geo_zone_id int NULL,
   last_modified datetime NULL,
   date_added datetime NOT NULL,
   PRIMARY KEY (association_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;


DROP TABLE IF EXISTS content_manager;
CREATE TABLE content_manager (
  content_id int(11) NOT NULL auto_increment,
  categories_id int(11) NOT NULL default '0',
  parent_id int(11) NOT NULL default '0',
  group_ids TEXT,
  languages_id int(11) NOT NULL default '0',
  content_title text,
  content_heading text,
  content_text text,
  content_url text,
  sort_order int(4) NOT NULL default '0',
  file_flag int(1) NOT NULL default '0',
  content_file varchar(255) NOT NULL default '',
  content_status int(1) NOT NULL default '0',
  content_group int(11) NOT NULL,
  content_delete int(1) NOT NULL default '1',
  content_meta_title TEXT,
  content_meta_description TEXT,
  content_meta_keywords TEXT,
  content_page_url varchar(255),
  PRIMARY KEY  (content_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS media_content;
CREATE TABLE media_content (
  file_id int(11) NOT NULL auto_increment,
  old_filename text,
  new_filename text,
  file_comment text,
  PRIMARY KEY  (file_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS products_content;
CREATE TABLE products_content (
  content_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  group_ids TEXT,
  content_name varchar(255) NOT NULL default '',
  content_file varchar(255) NOT NULL,
  content_link text,
  languages_id int(11) NOT NULL default '0',
  content_read int(11) NOT NULL default '0',
  file_comment text,
  PRIMARY KEY  (content_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS module_newsletter;
CREATE TABLE module_newsletter (
  newsletter_id int(11) NOT NULL auto_increment,
  title text,
  bc text,
  cc text,
  date datetime default NULL,
  status int(1) NOT NULL default '0',
  body text,
  PRIMARY KEY  (newsletter_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE if exists cm_file_flags;
CREATE TABLE cm_file_flags (
  file_flag int(11) NOT NULL,
  file_flag_name varchar(255) NOT NULL,
  PRIMARY KEY (file_flag)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;



DROP TABLE if EXISTS payment_moneybookers_currencies;
CREATE TABLE payment_moneybookers_currencies (
  mb_currID char(3) NOT NULL default '',
  mb_currName varchar(255) NOT NULL default '',
  PRIMARY KEY  (mb_currID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;


DROP TABLE if EXISTS payment_moneybookers;
CREATE TABLE payment_moneybookers (
  mb_TRID varchar(255) NOT NULL default '',
  mb_ERRNO smallint(3) unsigned NOT NULL default '0',
  mb_ERRTXT varchar(255) NOT NULL default '',
  mb_DATE datetime NOT NULL default '0000-00-00 00:00:00',
  mb_MBTID bigint(18) unsigned NOT NULL default '0',
  mb_STATUS tinyint(1) NOT NULL default '0',
  mb_ORDERID int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (mb_TRID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;


DROP TABLE if EXISTS payment_moneybookers_countries;
CREATE TABLE payment_moneybookers_countries (
  osc_cID int(11) NOT NULL default '0',
  mb_cID char(3) NOT NULL default '',
  PRIMARY KEY  (osc_cID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE if EXISTS coupon_email_track;
CREATE TABLE coupon_email_track (
  unique_id int(11) NOT NULL auto_increment,
  coupon_id int(11) NOT NULL default '0',
  customer_id_sent int(11) NOT NULL default '0',
  sent_firstname varchar(255) default NULL,
  sent_lastname varchar(255) default NULL,
  emailed_to varchar(255) default NULL,
  date_sent datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (unique_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE if EXISTS coupon_gv_customer;
CREATE TABLE coupon_gv_customer (
  customer_id int(5) NOT NULL default '0',
  amount decimal(8,4) NOT NULL default '0.0000',
  PRIMARY KEY  (customer_id),
  KEY customer_id (customer_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE if EXISTS coupon_gv_queue;
CREATE TABLE coupon_gv_queue (
  unique_id int(5) NOT NULL auto_increment,
  customer_id int(5) NOT NULL default '0',
  order_id int(5) NOT NULL default '0',
  amount decimal(8,4) NOT NULL default '0.0000',
  date_created datetime NOT NULL default '0000-00-00 00:00:00',
  ipaddr varchar(255) NOT NULL default '',
  release_flag char(1) NOT NULL default 'N',
  PRIMARY KEY  (unique_id),
  KEY uid (unique_id,customer_id,order_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE if EXISTS coupon_redeem_track;
CREATE TABLE coupon_redeem_track (
  unique_id int(11) NOT NULL auto_increment,
  coupon_id int(11) NOT NULL default '0',
  customer_id int(11) NOT NULL default '0',
  redeem_date datetime NOT NULL default '0000-00-00 00:00:00',
  redeem_ip varchar(255) NOT NULL default '',
  order_id int(11) NOT NULL default '0',
  PRIMARY KEY  (unique_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE if EXISTS coupons;
CREATE TABLE coupons (
  coupon_id int(11) NOT NULL auto_increment,
  coupon_type char(1) NOT NULL default 'F',
  coupon_code varchar(255) NOT NULL default '',
  coupon_amount decimal(8,4) NOT NULL default '0.0000',
  coupon_minimum_order decimal(8,4) NOT NULL default '0.0000',
  coupon_start_date datetime NOT NULL default '0000-00-00 00:00:00',
  coupon_expire_date datetime NOT NULL default '0000-00-00 00:00:00',
  uses_per_coupon int(5) NOT NULL default '1',
  uses_per_user int(5) NOT NULL default '0',
  restrict_to_products varchar(255) default NULL,
  restrict_to_categories varchar(255) default NULL,
  restrict_to_customers text,
  coupon_active char(1) NOT NULL default 'Y',
  date_created datetime NOT NULL default '0000-00-00 00:00:00',
  date_modified datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (coupon_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE if EXISTS coupons_description;
CREATE TABLE coupons_description (
  coupon_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '0',
  coupon_name varchar(255) NOT NULL default '',
  coupon_description text,
  KEY coupon_id (coupon_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE if exists payment_qenta;
CREATE TABLE payment_qenta (
  q_TRID varchar(255) NOT NULL default '',
  q_DATE datetime NOT NULL default '0000-00-00 00:00:00',
  q_QTID bigint(18) unsigned NOT NULL default '0',
  q_ORDERDESC varchar(255) NOT NULL default '',
  q_STATUS tinyint(1) NOT NULL default '0',
  q_ORDERID int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (q_TRID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

DROP TABLE if EXISTS personal_offers_by_customers_status_0;
DROP TABLE if EXISTS personal_offers_by_customers_status_1;
DROP TABLE if EXISTS personal_offers_by_customers_status_2;
DROP TABLE if EXISTS personal_offers_by_customers_status_3;

CREATE TABLE personal_offers_by_customers_status_0 (
  price_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL,
  quantity int(11) default NULL,
  personal_offer decimal(15,4) default NULL,
  PRIMARY KEY  (price_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE personal_offers_by_customers_status_1 (
  price_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL,
  quantity int(11) default NULL,
  personal_offer decimal(15,4) default NULL,
  PRIMARY KEY  (price_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;


CREATE TABLE personal_offers_by_customers_status_2 (
  price_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL,
  quantity int(11) default NULL,
  personal_offer decimal(15,4) default NULL,
  PRIMARY KEY  (price_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE personal_offers_by_customers_status_3 (
  price_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL,
  quantity int(11) default NULL,
  personal_offer decimal(15,4) default NULL,
  PRIMARY KEY  (price_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

#Contribution Installer Tables

drop table if exists cip;
create table cip (
  cip_id int(11) not null auto_increment,
  cip_folder_name varchar(255) not null ,
  cip_downloads int(11) default '0' not null ,
  cip_uploader_id int(11) default '0' not null ,
  cip_installed int(1) default '0' not null ,
  cip_ident varchar(255) not null ,
  cip_version varchar(255) not null ,
  PRIMARY KEY (cip_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

drop table if exists cip_depend;
create table cip_depend (
  cip_ident varchar(255) not null ,
  cip_ident_req varchar(255) not null ,
  cip_req_type int(2) default '0' not null ,
  PRIMARY KEY (cip_ident)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

#database Version
INSERT INTO database_version(version) VALUES ('1.68');

INSERT INTO cm_file_flags (file_flag, file_flag_name) VALUES ('0', 'information');
INSERT INTO cm_file_flags (file_flag, file_flag_name) VALUES ('1', 'content');
INSERT INTO cm_file_flags VALUES ('2', 'affiliate');

INSERT INTO affiliate_payment_status VALUES (0, 1, 'Ожидает оплаты');
INSERT INTO affiliate_payment_status VALUES (1, 1, 'Оплачен');

INSERT INTO shipping_status VALUES (1, 1, '3-4 дня', '');
INSERT INTO shipping_status VALUES (2, 1, '1 неделя', '');
INSERT INTO shipping_status VALUES (3, 1, '2 недели', '');

# data

INSERT INTO `content_manager` VALUES (1, 0, 0, '', 1, 'Доставка', 'Доставка', 'Условия доставки.', '', 0, 1, '', 1, 1, 0,'','','','');
INSERT INTO `content_manager` VALUES (2, 0, 0, '', 1, 'Безопасность магазина', 'Безопасность магазина', 'Ваш текст.', '', 0, 1, '', 1, 2, 0,'','','','');
INSERT INTO `content_manager` VALUES (3, 0, 0, '', 1, 'Условия использования', 'Условия использования', 'Ваш текст', '', 0, 1, '', 1, 3, 0,'','','','');
INSERT INTO `content_manager` VALUES (4, 0, 0, '', 1, 'Информация о магазине', 'Информация о магазине', 'Текст страницы информация о магазине.', '', 0, 1, '', 1, 4, 0,'','','','');
INSERT INTO `content_manager` VALUES (5, 0, 0, '', 1, 'Главная страница', 'Добро пожаловать', 'Вы установили интернет-магазин VamShop<br /><br />Данный текст можно изменить в Админке - Разное - Инструменты - Информационные страницы<br /><br />', '', 0, 1, '', 0, 5, 0,'','','','');
INSERT INTO `content_manager` VALUES (6, 0, 0, '', 1, 'Пример страницы', 'Пример страницы', 'Текст страницы', '', 0, 1, '', 0, 6, 1,'','','','');
INSERT INTO `content_manager` VALUES (7, 0, 0, '', 1, 'Свяжитесь с нами', 'Свяжитесь с нами', 'Форма обратной связи', '', 0, 1, '', 1, 7, 0,'','','','');
INSERT INTO `content_manager` VALUES (8, 0, 0, '', 1, 'Карта сайта', 'Карта сайта', '', '', 0, 0, 'sitemap.php', 1, 8, 0,'','','','');

INSERT INTO content_manager VALUES (9, 0, 0, '', 1, 'Правила партнёрской программы', 'Правила и условия партнёрской программы', '<b>1. Участники партнёрской программы.</b>
<br />
Участниками партнёрской программы могут быть физические лица. Под физическими лицами понимаются граждане РФ, иностранные граждане, лица без гражданства, а так же предприниматели без образования юридического лица.
<br />
<br />
<b>2. Оплата услуг партнёра.</b>
<br />
Мы будем выплачивать Вам комиссию, установленную в размере <b>15%</b> от стоимости <b>оплаченного</b> заказа.
<br />
<br />
<b>3. Способы оплаты.</b>
<br />
Все партнёрские выплаты производятся в доларах США через электронную платёжную систему <b>WebMoney</b>, Вы можете ознакомиться с данной системой по адресу <b><a href="http://www.webmoney.ru" target="_blank">http://www.webmoney.ru</a></b>
<br />
<br />
<b>4. Минимальная сумма к оплате.</b>
<br />
Минимальная сумма к оплате установлена в размере <b>30$</b>. В случае, если заработанная Вами партнёрская комиссия не превышает <b>30$</b>, деньги остаются на Вашем аккаунте до тех пор, пока сумма комиссии не достигнет по крайней мере <b>30$</b>. Оплата партнёрских комиссий производится каждые <b>2 недели</b>.
<br />
<br />
<b>5. Партнёрская комиссия.</b>
<br />
Партнёрская комиссия будет выплачена только если заказ оформлен и оплачен покупателем, которого привели Вы.
<br /><br />
Партнёрская комиссия начисляется только за <b>оплаченные заказы.</b>
<br /><br />
Партнёрская комиссия не будет выплачена, если:
<br />
&nbsp;<b>а)</b> Посетитель, пришедший с Вашего сайта не будет учтён нашей системой по техническим причинам (отключены "Cookies" и т.д.).
<br />
&nbsp;<b>б)</b> Посетитель перешёл в магазин по партнёрской ссылке другого партнёра.
<br />
&nbsp;<b>в)</b> Посетиитель, оформивший заказ через Вашу партнёрскую ссылку не оплатил его.
<br />
<br />
<b>6. Условия.</b>
<br />
Покупатели, совершающие заказы через партнёров считаются нашими покупателями и подчиняются правилам нашего магазина. Правила работы магазина могут быть изменены нами без предварительного уведомления.
<br />
<br />
<b>7. Разногласия</b>
<br />
В случае возникновения разногласий, стороны будут стремиться урегулировать возникшие разногласия путем переговоров. В случае, если стороны не придут к соглашению, то спор подлежит рассмотрению в суде РФ.
<br />
<br />', '', 0, 2, '', 1, 9, 0,'','','','');
INSERT INTO content_manager VALUES (10, 0, 0, '', 1, 'Информация', 'Информация о партнёрской программе', '<b>1. Участники партнёрской программы.</b>
<br />
Участниками партнёрской программы могут быть физические лица. Под физическими лицами понимаются граждане РФ, иностранные граждане, лица без гражданства, а так же предприниматели без образования юридического лица.
<br />
<br />
<b>2. Оплата услуг партнёра.</b>
<br />
Мы будем выплачивать Вам комиссию, установленную в размере <b>15%</b> от стоимости <b>оплаченного</b> заказа.
<br />
<br />
<b>3. Способы оплаты.</b>
<br />
Все партнёрские выплаты производятся в доларах США через электронную платёжную систему <b>WebMoney</b>, Вы можете ознакомиться с данной системой по адресу <b><a href="http://www.webmoney.ru" target="_blank">http://www.webmoney.ru</a></b>
<br />
<br />
<b>4. Минимальная сумма к оплате.</b>
<br />
Минимальная сумма к оплате установлена в размере <b>30$</b>. В случае, если заработанная Вами партнёрская комиссия не превышает <b>30$</b>, деньги остаются на Вашем аккаунте до тех пор, пока сумма комиссии не достигнет по крайней мере <b>30$</b>. Оплата партнёрских комиссий производится каждые <b>2 недели</b>.
<br />
<br />
<b>5. Партнёрская комиссия.</b>
<br />
Партнёрская комиссия будет выплачена только если заказ оформлен и оплачен покупателем, которого привели Вы.
<br /><br />
Партнёрская комиссия начисляется только за <b>оплаченные заказы.</b>
<br /><br />
Партнёрская комиссия не будет выплачена, если:
<br />
&nbsp;<b>а)</b> Посетитель, пришедший с Вашего сайта не будет учтён нашей системой по техническим причинам (отключены "Cookies" и т.д.).
<br />
&nbsp;<b>б)</b> Посетитель перешёл в магазин по партнёрской ссылке другого партнёра.
<br />
&nbsp;<b>в)</b> Посетиитель, оформивший заказ через Вашу партнёрскую ссылку не оплатил его.
<br />
<br />
<b>6. Условия.</b>
<br />
Покупатели, совершающие заказы через партнёров считаются нашими покупателями и подчиняются правилам нашего магазина. Правила работы магазина могут быть изменены нами без предварительного уведомления.
<br />
<br />
<b>7. Разногласия</b>
<br />
В случае возникновения разногласий, стороны будут стремиться урегулировать возникшие разногласия путем переговоров. В случае, если стороны не придут к соглашению, то спор подлежит рассмотрению в суде РФ.
<br />
<br />', '', 0, 2, '', 1, 10, 0,'','','','');
INSERT INTO content_manager VALUES (11, 0, 0, '', 1, 'Вопросы и ответы', 'Вопросы и ответы', 'Список частозадаваемых вопросов по партнёрской программе.<br>
<br>
<ul>
<li>Как мне получить заработанные у вас деньги?</a>
<li>Как и в каком месте лучше всего рамещать партнёрские ссылки?</a>
<li>Могу ли я изменять HTML-код, который мне нужно ставить на сайт?</a>
<li>Что будет если покупатель, который пришёл с моего сайте не оплатит заказ?</a>
</ul>
<hr width="90%">
<BR>
<FONT COLOR="#000000" size="4"><B><U>FAQ</U></B></FONT>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="maroon">Как мне получить заработанные у вас деньги?</font><br>
Чтобы получить выплату партнёрской комиссии, на Вашем аккаунте должно быть как минимум <b>30$</b>. В случае, если заработанная Вами партнёрская комиссия не превышает <b>30$</b>, деньги остаются на Вашем аккаунте до тех пор, пока сумма комиссии не достигнет по крайней мере <b>30$</b>. Оплата партнёрских комиссий производится каждые <b>2 недели</b>. Выплаты производятся на Ваш кошелёк в системе WebMoney.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="maroon">Как и в каком месте лучше всего рамещать партнёрские ссылки?</font><a name="2"></a><br>
Лучше всего размещать партнёрские ссылки сразу на всех страницах Вашего сайта, в ниболее заметных местах, используйте различные партнёрские ссылки: баннеры, ссылки на конкретные товары и т.д. Размещать рекламу в верхней части страниц всегда эффективнее, чем в нижней. Вы можете размещать партнёрские ссылки не только у себя на сайте, а так же в баннеробменных сетях, почтовых рассылках и т.д.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="maroon">Могу ли я изменять HTML-код, который мне нужно ставить на сайт?</font><a name="3"></a><br>
Да, Вы можете изменять HTML-код по своему усмотрению, можете создавать свои ссылки самостоятельно на разные страницы нашего магазина, главное чтобы в адресе ссылки был указан ваш Партнёрский ID. Например: <b>http://адресмагазина/?ref=yourid</b>, где <b>yourid</b> это Ваш партнёрский номер.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>
<p style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"><font color="maroon">Что будет если покупатель, который пришёл с моего сайта не оплатит заказ?</font><a name="4"></a><br>
Вы не получите свою комиссию, т.к. комиссия начисляется только за <b>оплаченные</b> заказы.</p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0"></p>
<p align="right" style="line-height: 100%; word-spacing: 0; text-indent: 0; margin: 0">&nbsp;</p>', '', 0, 2, '', 1, 11, 0,'','','','');

# 1 - Default, 2 - USA, 3 - Spain, 4 - Singapore, 5 - Germany
INSERT INTO address_format VALUES (1, '$firstname $secondname $lastname$cr$streets$cr$city, $postcode$cr$statecomma$country','$city / $country');
INSERT INTO address_format VALUES (2, '$firstname $secondname $lastname$cr$streets$cr$city, $state    $postcode$cr$country','$city, $state / $country');
INSERT INTO address_format VALUES (3, '$firstname $secondname $lastname$cr$streets$cr$city$cr$postcode - $statecomma$country','$state / $country');
INSERT INTO address_format VALUES (4, '$firstname $secondname $lastname$cr$streets$cr$city ($postcode)$cr$country', '$postcode / $country');
INSERT INTO address_format VALUES (5, '$firstname $secondname $lastname$cr$streets$cr$postcode $city$cr$country','$city / $country');

INSERT  INTO admin_access VALUES ( 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT  INTO admin_access VALUES ( 'groups', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 2, 4, 2, 2, 2, 2, 5, 5, 5, 5, 5, 5, 5, 5, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

# configuration_group_id 1
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_NAME', 'VamShop',  1, 1, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_OWNER', 'VamShop', 1, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_OWNER_EMAIL_ADDRESS', 'owner@your-shop.com', 1, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_TELEPHONE', '', 1, 3, NULL, '', NULL, 'vam_cfg_textarea(');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_ICQ', '', 1, 3, NULL, '', NULL, 'vam_cfg_textarea(');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_SKYPE', '', 1, 3, NULL, '', NULL, 'vam_cfg_textarea(');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_FROM', 'VamShop owner@your-shop.com',  1, 4, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_COUNTRY', '176',  1, 6, NULL, '', 'vam_get_country_name', 'vam_cfg_pull_down_country_list(');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_ZONE', '98', 1, 7, NULL, '', 'vam_cfg_get_zone_name', 'vam_cfg_pull_down_zone_list(');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EXPECTED_PRODUCTS_SORT', 'desc',  1, 8, NULL, '', NULL, 'vam_cfg_select_option(array(\'asc\', \'desc\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EXPECTED_PRODUCTS_FIELD', 'date_expected',  1, 9, NULL, '', NULL, 'vam_cfg_select_option(array(\'products_name\', \'date_expected\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('USE_DEFAULT_LANGUAGE_CURRENCY', 'false', 1, 10, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SEARCH_ENGINE_FRIENDLY_URLS', 'false',  16, 12, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_CART', 'true',  1, 13, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ADVANCED_SEARCH_DEFAULT_OPERATOR', 'and', 1, 15, NULL, '', NULL, 'vam_cfg_select_option(array(\'and\', \'or\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_NAME_ADDRESS', 'Store Name\nAddress\nCountry\nPhone',  1, 16, NULL, '', NULL, 'vam_cfg_textarea(');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHOW_COUNTS', 'false',  1, 17, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN', '0',  1, 20, NULL, '', 'vam_get_customers_status_name', 'vam_cfg_pull_down_customers_status_list(');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_CUSTOMERS_STATUS_ID_GUEST', '1',  1, 21, NULL, '', 'vam_get_customers_status_name', 'vam_cfg_pull_down_customers_status_list(');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_CUSTOMERS_STATUS_ID', '2',  1, 23, NULL, '', 'vam_get_customers_status_name', 'vam_cfg_pull_down_customers_status_list(');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ALLOW_ADD_TO_CART', 'false',  1, 24, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CURRENT_TEMPLATE', 'vamshop2', 1, 26, NULL, '', NULL, 'vam_cfg_pull_down_template_sets(');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRICE_IS_BRUTTO', 'false', 1, 27, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRICE_PRECISION', '4', 1, 28, NULL, '', NULL, '');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CC_KEYCHAIN', 'changeme', 1, 29, NULL, '', NULL, '');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ADMIN_DROP_DOWN_NAVIGATION', 'true', 1, 30, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('AJAX_CART', 'false', 1, 31, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ENABLE_TABS', 'true', 1, 32, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MASTER_PASS', '', 1, 33, NULL, '', NULL, '');

# configuration_group_id 2
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ENTRY_FIRST_NAME_MIN_LENGTH', '2',  2, 1, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ENTRY_LAST_NAME_MIN_LENGTH', '2',  2, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ENTRY_DOB_MIN_LENGTH', '10',  2, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ENTRY_EMAIL_ADDRESS_MIN_LENGTH', '6',  2, 4, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ENTRY_STREET_ADDRESS_MIN_LENGTH', '5',  2, 5, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ENTRY_COMPANY_MIN_LENGTH', '2',  2, 6, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ENTRY_POSTCODE_MIN_LENGTH', '4',  2, 7, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ENTRY_CITY_MIN_LENGTH', '3',  2, 8, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ENTRY_STATE_MIN_LENGTH', '2', 2, 9, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ENTRY_TELEPHONE_MIN_LENGTH', '3',  2, 10, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ENTRY_PASSWORD_MIN_LENGTH', '5',  2, 11, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CC_OWNER_MIN_LENGTH', '3',  2, 12, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CC_NUMBER_MIN_LENGTH', '10',  2, 13, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('REVIEW_TEXT_MIN_LENGTH', '10',  2, 14, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MIN_DISPLAY_BESTSELLERS', '1',  2, 15, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MIN_DISPLAY_ALSO_PURCHASED', '1', 2, 16, NULL, '', NULL, NULL);

# configuration_group_id 3
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_ADDRESS_BOOK_ENTRIES', '5',  3, 1, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_SEARCH_RESULTS', '20',  3, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_ADMIN_PAGE', '20',  3, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_PAGE_LINKS', '5',  3, 4, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_SPECIAL_PRODUCTS', '9', 3, 5, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_NEW_PRODUCTS', '10',  3, 6, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_UPCOMING_PRODUCTS', '10',  3, 7, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST', '0', 3, 8, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_MANUFACTURERS_LIST', '1',  3, 9, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_MANUFACTURER_NAME_LEN', '15',  3, 10, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_NEW_REVIEWS', '6', 3, 11, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_RANDOM_SELECT_REVIEWS', '10',  3, 12, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_RANDOM_SELECT_NEW', '10',  3, 13, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_RANDOM_SELECT_SPECIALS', '10',  3, 14, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_CATEGORIES_PER_ROW', '3',  3, 15, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_PRODUCTS_NEW', '10',  3, 16, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_BESTSELLERS', '10',  3, 17, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_ALSO_PURCHASED', '6',  3, 18, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX', '6',  3, 19, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_ORDER_HISTORY', '10',  3, 20, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_REVIEWS_VIEW', '5',  3, 21, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_PRODUCTS_QTY', '1000', 3, 22, 'NULL', '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_NEW_PRODUCTS_DAYS', '30', 3, 23, 'NULL', '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_RANDOM_SELECT_FEATURED', '10',  3, 24, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_FEATURED_PRODUCTS', '10', 3, 25, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('MAX_DISPLAY_FAQ', '2', 3, 26, 'NULL', '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('MAX_DISPLAY_FAQ_PAGE', '20', 3, 27, 'NULL', '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('MAX_DISPLAY_FAQ_ANSWER', '150', 3, 28, 'NULL', '', NULL, NULL);

# Новости

INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_LATEST_NEWS', '2', 3, 23, 'NULL', '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_LATEST_NEWS_PAGE', '20', 3, 24, 'NULL', '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_LATEST_NEWS_CONTENT', '150', 3, 25, 'NULL', '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_CART', '50', 3, 26, 'NULL', '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_SHORT_DESCRIPTION', '80', 3, 27, 'NULL', '', NULL, NULL);


# configuration_group_id 4
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CONFIG_CALCULATE_IMAGE_SIZE', 'true', 4, 1, NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('IMAGE_QUALITY', '80', 4, 2, '2003-12-15 12:10:45', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_THUMBNAIL_WIDTH', '120', 4, 7, '2003-12-15 12:10:45', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_THUMBNAIL_HEIGHT', '80', 4, 8, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_INFO_WIDTH', '240', 4, 9, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_INFO_HEIGHT', '160', 4, 10, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_POPUP_WIDTH', '600', 4, 11, '2003-12-15 12:11:00', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_POPUP_HEIGHT', '480', 4, 12, '2003-12-15 12:11:09', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_THUMBNAIL_BEVEL', '', 4, 13, '2003-12-15 13:14:39', '0000-00-00 00:00:00', '', '');
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_THUMBNAIL_ACTIVE', 'true', 4, 14, '2003-12-15 13:14:39', '0000-00-00 00:00:00', '', 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE', '', 4, 15, '2003-12-15 13:13:37', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE', '', 4, 16, '2003-12-15 13:14:57', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES', '', 4, 17, '2003-12-15 13:19:45', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_THUMBNAIL_MERGE', '', 4, 18, '2003-12-15 12:01:43', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_THUMBNAIL_FRAME', '', 4, 19, '2003-12-15 13:19:37', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW', '', 4, 20, '2003-12-15 13:15:14', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR', '', 4, 21, '2003-12-15 12:02:19', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_INFO_ACTIVE', 'true', 4, 22, '2003-12-15 13:14:39', '0000-00-00 00:00:00', '', 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_INFO_BEVEL', '', 4, 23, '2003-12-15 13:42:09', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_INFO_GREYSCALE', '', 4, 24, '2003-12-15 13:18:00', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_INFO_ELLIPSE', '', 4, 25, '2003-12-15 13:41:53', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_INFO_ROUND_EDGES', '', 4, 26, '2003-12-15 13:21:55', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_INFO_MERGE', '(overlay.gif,10,-50,60,FF0000)', 4, 27, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_INFO_FRAME', '', 4, 28, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_INFO_DROP_SHADDOW', '(0,FFFFFF,FFFFFF)', 4, 29, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_INFO_MOTION_BLUR', '', 4, 30, '2003-12-15 13:21:18', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_POPUP_BEVEL', '(0,FFFFFF,FFFFFF)', 4, 31, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_POPUP_ACTIVE', 'true', 4, 32, '2003-12-15 13:14:39', '0000-00-00 00:00:00', '', 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_POPUP_GREYSCALE', '', 4, 33, '2003-12-15 13:22:58', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_POPUP_ELLIPSE', '', 4, 34, '2003-12-15 13:22:51', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_POPUP_ROUND_EDGES', '', 4, 35, '2003-12-15 13:23:17', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_POPUP_MERGE', '(overlay.gif,10,-50,60,FF0000)', 4, 36, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_POPUP_FRAME', '', 4, 37, '2003-12-15 13:22:43', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_POPUP_DROP_SHADDOW', '', 4, 38, '2003-12-15 13:22:26', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_IMAGE_POPUP_MOTION_BLUR', '', 4, 39, '2003-12-15 13:22:32', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CATEGORIES_IMAGE_THUMBNAIL_ACTIVE', 'true', 4, 40, '2003-12-15 13:14:39', '0000-00-00 00:00:00', '', 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CATEGORIES_IMAGE_THUMBNAIL_WIDTH', '120', 4, 41, '2003-12-15 12:10:45', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CATEGORIES_IMAGE_THUMBNAIL_HEIGHT', '80', 4, 42, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CATEGORIES_IMAGE_THUMBNAIL_BEVEL', '', 4, 43, '2003-12-15 13:14:39', '0000-00-00 00:00:00', '', '');
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CATEGORIES_IMAGE_THUMBNAIL_GREYSCALE', '', 4, 44, '2003-12-15 13:13:37', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CATEGORIES_IMAGE_THUMBNAIL_ELLIPSE', '', 4, 45, '2003-12-15 13:14:57', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CATEGORIES_IMAGE_THUMBNAIL_ROUND_EDGES', '', 4, 46, '2003-12-15 13:19:45', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CATEGORIES_IMAGE_THUMBNAIL_MERGE', '', 4, 47, '2003-12-15 12:01:43', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CATEGORIES_IMAGE_THUMBNAIL_FRAME', '', 4, 48, '2003-12-15 13:19:37', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CATEGORIES_IMAGE_THUMBNAIL_DROP_SHADDOW', '', 4, 49, '2003-12-15 13:15:14', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CATEGORIES_IMAGE_THUMBNAIL_MOTION_BLUR', '', 4, 50, '2003-12-15 12:02:19', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('USE_EP_IMAGE_MANIPULATOR', 'false', 4, 51, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MO_PICS', '0', '4', '3', '', '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('IMAGE_MANIPULATOR', 'image_manipulator_GD2.php', '4', '3', '', '0000-00-00 00:00:00', NULL , 'vam_cfg_select_option(array(\'image_manipulator_GD2.php\', \'image_manipulator_GD1.php\'),');

INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_THUMB_WIDTH', '120', 4, 52, '2003-12-15 12:10:45', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_THUMB_HEIGHT', '100', 4, 53, '2003-12-15 12:10:45', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_ADMIN_WIDTH', '100', 4, 54, '2003-12-15 12:10:45', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_ADMIN_HEIGHT', '80', 4, 55, '2003-12-15 12:10:45', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_BYTE_SIZE', '1000000', 4, 56, '2003-12-15 12:10:45', '0000-00-00 00:00:00', NULL, NULL);

# configuration_group_id 5
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_SECOND_NAME', 'false',  5, 1, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_GENDER', 'false',  5, 2, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_DOB', 'false',  5, 3, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_COMPANY', 'false',  5, 4, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_STREET_ADDRESS', 'true', 5, 5, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_CITY', 'true', 5, 6, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_POSTCODE', 'true', 5, 7, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_COUNTRY', 'true', 5, 8, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_TELE', 'true', 5, 9, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_FAX', 'true', 5, 10, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_SUBURB', 'false', 5, 11, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_STATE', 'true',  5, 12, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_OPTIONS', 'both',  5, 13, NULL, '', NULL, 'vam_cfg_select_option(array(\'account\', \'guest\', \'both\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DELETE_GUEST_ACCOUNT', 'false',  5, 14, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');

# configuration_group_id 6
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_PAYMENT_INSTALLED', '', 6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_INSTALLED', 'ot_subtotal.php;ot_shipping.php;ot_tax.php;ot_total.php', 6, 0, '2003-07-18 03:31:55', '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_SHIPPING_INSTALLED', '',  6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_CURRENCY', 'RUR',  6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_LANGUAGE', 'ru',  6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_ORDERS_STATUS_ID', '1',  6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_PRODUCTS_VPE_ID', '',  6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_SHIPPING_STATUS_ID', '1',  6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_SHIPPING_STATUS', 'true',  6, 1, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER', '30',  6, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING', 'false', 6, 3, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER', '50',  6, 4, NULL, '', 'currencies->format', NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION', 'national', 6, 5, NULL, '', NULL, 'vam_cfg_select_option(array(\'national\', \'international\', \'both\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_SUBTOTAL_STATUS', 'true',  6, 1, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER', '10',  6, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_TAX_STATUS', 'true',  6, 1, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_TAX_SORT_ORDER', '50',  6, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_TOTAL_STATUS', 'true',  6, 1, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER', '99',  6, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_DISCOUNT_STATUS', 'true',  6, 1, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_DISCOUNT_SORT_ORDER', '20', 6, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_STATUS', 'true',  6, 1, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_SORT_ORDER','40',  6, 2, NULL, '', NULL, NULL);


# configuration_group_id 7
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHIPPING_ORIGIN_COUNTRY', '81',  7, 1, NULL, '', 'vam_get_country_name', 'vam_cfg_pull_down_country_list(');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHIPPING_ORIGIN_ZIP', '',  7, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHIPPING_MAX_WEIGHT', '50',  7, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHIPPING_BOX_WEIGHT', '',  7, 4, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHIPPING_BOX_PADDING', '',  7, 5, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHOW_SHIPPING', 'true',  7, 6, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHIPPING_INFOS', '1',  7, 7, NULL, '', NULL, NULL);

# configuration_group_id 8
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_LIST_FILTER', '1', 8, 1, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_LIST_RECURSIVE', 'false',  8, 2, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');

# configuration_group_id 9
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STOCK_CHECK', 'false',  9, 1, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ATTRIBUTE_STOCK_CHECK', 'false',  9, 2, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STOCK_LIMITED', 'false', 9, 3, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STOCK_ALLOW_CHECKOUT', 'true',  9, 4, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STOCK_MARK_PRODUCT_OUT_OF_STOCK', '***',  9, 5, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STOCK_REORDER_LEVEL', '5',  9, 6, NULL, '', NULL, NULL);

# configuration_group_id 10
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_PAGE_PARSE_TIME', 'false',  10, 1, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_PAGE_PARSE_TIME_LOG', '/var/log/www/tep/page_parse_time.log',  10, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_PARSE_DATE_TIME_FORMAT', '%d/%m/%Y %H:%M:%S', 10, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_PAGE_PARSE_TIME', 'false',  10, 4, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_DB_TRANSACTIONS', 'false',  10, 5, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');

# configuration_group_id 11
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('USE_CACHE', 'false',  11, 1, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DIR_FS_CACHE', 'cache',  11, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CACHE_LIFETIME', '3600',  11, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CACHE_CHECK', 'true',  11, 4, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DB_CACHE', 'false',  11, 5, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DB_CACHE_EXPIRE', '3600',  11, 6, NULL, '', NULL, NULL);

# configuration_group_id 12
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_TRANSPORT', 'mail',  12, 1, NULL, '', NULL, 'vam_cfg_select_option(array(\'sendmail\', \'smtp\', \'mail\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SENDMAIL_PATH', '/usr/sbin/sendmail', 12, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SMTP_MAIN_SERVER', 'localhost', 12, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SMTP_Backup_Server', 'localhost', 12, 4, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SMTP_PORT', '25', 12, 5, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SMTP_USERNAME', 'Please Enter', 12, 6, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SMTP_PASSWORD', 'Please Enter', 12, 7, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SMTP_AUTH', 'false', 12, 8, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_LINEFEED', 'LF',  12, 9, NULL, '', NULL, 'vam_cfg_select_option(array(\'LF\', \'CRLF\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_USE_HTML', 'false',  12, 10, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ENTRY_EMAIL_ADDRESS_CHECK', 'false',  12, 11, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SEND_EMAILS', 'true',  12, 12, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');

# Constants for contact_us
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CONTACT_US_EMAIL_ADDRESS', 'contact@your-shop.com', 12, 20, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CONTACT_US_NAME', 'Mail send by Contact_us Form',  12, 21, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CONTACT_US_REPLY_ADDRESS',  '', 12, 22, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CONTACT_US_REPLY_ADDRESS_NAME',  '', 12, 23, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CONTACT_US_EMAIL_SUBJECT',  '', 12, 24, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CONTACT_US_FORWARDING_STRING',  '', 12, 25, NULL, '', NULL, NULL);

# Constants for support system
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_SUPPORT_ADDRESS', 'support@your-shop.com', 12, 26, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_SUPPORT_NAME', 'Mail send by support systems',  12, 27, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_SUPPORT_REPLY_ADDRESS',  '', 12, 28, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_SUPPORT_REPLY_ADDRESS_NAME',  '', 12, 29, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_SUPPORT_SUBJECT',  '', 12, 30, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_SUPPORT_FORWARDING_STRING',  '', 12, 31, NULL, '', NULL, NULL);

# Constants for billing system
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_BILLING_ADDRESS', 'billing@your-shop.com', 12, 32, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_BILLING_NAME', 'Mail send by billing systems',  12, 33, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_BILLING_REPLY_ADDRESS',  '', 12, 34, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_BILLING_REPLY_ADDRESS_NAME',  '', 12, 35, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_BILLING_SUBJECT',  'Ваш заказ номер {$nr}', 12, 36, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_BILLING_FORWARDING_STRING',  '', 12, 37, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_BILLING_SUBJECT_ORDER',  'Ваш заказ номер {$nr}', 12, 38, NULL, '', NULL, NULL);

# configuration_group_id 13
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DOWNLOAD_ENABLED', 'false',  13, 1, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DOWNLOAD_BY_REDIRECT', 'false',  13, 2, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DOWNLOAD_UNALLOWED_PAYMENT', 'banktransfer,cod,invoice,moneyorder',  13, 5, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DOWNLOAD_MIN_ORDERS_STATUS', '4',  13, 5, NULL, '', NULL, NULL);


# configuration_group_id 14
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('GZIP_COMPRESSION', 'false',  14, 1, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('GZIP_LEVEL', '5',  14, 2, NULL, '', NULL, NULL);

# configuration_group_id 15
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SESSION_WRITE_DIRECTORY', 'tmp',  15, 1, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SESSION_FORCE_COOKIE_USE', 'True',  15, 2, NULL, '', NULL, 'vam_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SESSION_CHECK_SSL_SESSION_ID', 'False',  15, 3, NULL, '', NULL, 'vam_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SESSION_CHECK_USER_AGENT', 'False',  15, 4, NULL, '', NULL, 'vam_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SESSION_CHECK_IP_ADDRESS', 'False',  15, 5, NULL, '', NULL, 'vam_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SESSION_RECREATE', 'False',  15, 7, NULL, '', NULL, 'vam_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SESSION_TIMEOUT_ADMIN', '14400',  15, 8, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SESSION_TIMEOUT_CATALOG', '1440',  15, 9, NULL, '', NULL, NULL);

# configuration_group_id 16
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('META_ROBOTS', 'index,follow',  16, 10, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('META_DESCRIPTION', '',  16, 11, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('META_KEYWORDS', '',  16, 12, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CHECK_CLIENT_AGENT', 'true',16, 13, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');

# configuration_group_id 17
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACTIVATE_GIFT_SYSTEM', 'false', 17, 2, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SECURITY_CODE_LENGTH', '10', 17, 3, NULL, '2003-12-05 05:01:41', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT', '0', 17, 4, NULL, '2003-12-05 05:01:41', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('NEW_SIGNUP_DISCOUNT_COUPON', '', 17, 5, NULL, '2003-12-05 05:01:41', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACTIVATE_SHIPPING_STATUS', 'true', 17, 6, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_CONDITIONS_ON_CHECKOUT', 'false',17, 7, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHOW_IP_LOG', 'false',17, 8, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('GROUP_CHECK', 'false',  17, 9, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACTIVATE_NAVIGATOR', 'false',  17, 10, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('QUICKLINK_ACTIVATED', 'true',  17, 11, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACTIVATE_REVERSE_CROSS_SELLING', 'false', 17, 12, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_REVOCATION_ON_CHECKOUT', 'true', 17, 13, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('REVOCATION_ID', '', 17, 14, NULL, '2003-12-05 05:01:41', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('LOGIN_NUM', '3', '17', '16', NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('LOGIN_TIME', '300',  '17', '17', NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('QUICK_CHECKOUT', 'false',  17, 18, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('XSELL_CART', 'false',  17, 19, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ENABLE_MAP_TAB', 'true',  17, 20, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAP_API_KEY', '', '17', '21', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('AUTOMATIC_SEO_URL', 'false',  17, 22, NULL, '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');

#configuration_group_id 18
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_COMPANY_VAT_CHECK', 'false', 18, 4, '', '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_OWNER_VAT_ID', '', 18, 3, '', '', NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_CUSTOMERS_VAT_STATUS_ID', '1', 18, 23, '', '', 'vam_get_customers_status_name', 'vam_cfg_pull_down_customers_status_list(');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_COMPANY_VAT_LIVE_CHECK', 'true', 18, 4, '', '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_COMPANY_VAT_GROUP', 'true', 18, 4, '', '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_VAT_BLOCK_ERROR', 'true', 18, 4, '', '', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL', '3', '18', '24', NULL , '', 'vam_get_customers_status_name', 'vam_cfg_pull_down_customers_status_list(');

#configuration_group_id 19
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('GOOGLE_CONVERSION_ID', 'UA-XXXXXX-X', '19', '2', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('GOOGLE_LANG', 'ru', '19', '3', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('GOOGLE_CONVERSION', 'false', '19', '0', NULL , '0000-00-00 00:00:00', NULL , 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YANDEX_METRIKA_ID', '', '19', '4', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YANDEX_METRIKA', 'false', '19', '5', NULL , '0000-00-00 00:00:00', NULL , 'vam_cfg_select_option(array(\'true\', \'false\'),');

#configuration_group_id 20
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CSV_TEXTSIGN', '"', '20', '1', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('CSV_SEPERATOR', '\t', '20', '2', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('COMPRESS_EXPORT', 'false', '20', '3', NULL , '0000-00-00 00:00:00', NULL , 'vam_cfg_select_option(array(\'true\', \'false\'),');

#configuration_group_id 21, Afterbuy
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('AFTERBUY_PARTNERID', '', '21', '2', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('AFTERBUY_PARTNERPASS', '', '21', '3', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('AFTERBUY_USERID', '', '21', '4', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('AFTERBUY_ORDERSTATUS', '1', '21', '5', NULL , '0000-00-00 00:00:00', 'vam_get_order_status_name' , 'vam_cfg_pull_down_order_statuses(');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('AFTERBUY_ACTIVATED', 'false', '21', '6', NULL , '0000-00-00 00:00:00', NULL , 'vam_cfg_select_option(array(\'true\', \'false\'),');

#configuration_group_id 22, Search Options
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SEARCH_IN_DESC', 'true', '22', '2', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SEARCH_IN_ATTR', 'true', '22', '3', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');

#configuration_group_id 23, Яндекс-маркет
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YML_NAME', '', '23', '1', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YML_COMPANY', '', '23', '2', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YML_DELIVERYINCLUDED', 'false', '23', '3', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YML_AVAILABLE', 'stock', '23', '4', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\', \'stock\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YML_AUTH_USER', '', '23', '5', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YML_AUTH_PW', '', '23', '6', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YML_REFERER', 'false', '23', '7', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'false\', \'ip\', \'agent\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YML_STRIP_TAGS', 'true', '23', '8', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YML_UTF8', 'false', '23', '9', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YML_VENDOR', 'false', '23', '10', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YML_REF_ID', '&amp;ref=yml', '23', '11', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YML_REF_IP', 'true', '23', '12', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YML_USE_CDATA', 'false', '23', '13', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('YML_SALES_NOTES', '', '23', '14', NULL , '0000-00-00 00:00:00', NULL , NULL);

#configuration_group_id 24, Изменение цен
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_MODEL', 'true', '24', '1', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODIFY_MODEL', 'true', '24', '2', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODIFY_NAME', 'true', '24', '3', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_STATUT', 'true', '24', '4', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_WEIGHT', 'true', '24', '5', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_QUANTITY', 'true', '24', '6', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_IMAGE', 'false', '24', '7', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_XML', 'true', '24', '8', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_START_PAGE', 'true', '24', '9', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_SORT', 'true', '24', '10', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODIFY_MANUFACTURER', 'true', '24', '11', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODIFY_TAX', 'true', '24', '12', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_TVA_OVER', 'true', '24', '13', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_TVA_UP', 'true', '24', '14', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_PREVIEW', 'true', '24', '15', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_EDIT', 'true', '24', '16', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_MANUFACTURER', 'true', '24', '17', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_TAX', 'true', '24', '18', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACTIVATE_COMMERCIAL_MARGIN', 'true', '24', '19', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');

#configuration_group_id 25, Установка модулей
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ALLOW_SQL_BACKUP', 'true', '25', '2', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ALLOW_SQL_RESTORE', 'false', '25', '3', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ALLOW_FILES_BACKUP', 'true', '25', '4', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ALLOW_FILES_RESTORE', 'false', '25', '5', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ALLOW_OVERWRITE_MODIFIED', 'false', '25', '6', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('TEXT_LINK_FORUM', 'http://vamshop.ru/forum/index.php?topic=', '25', '7', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('TEXT_LINK_CONTR', 'http://vamshop.ru/product_info.php?products_id=', '25', '8', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ALWAYS_DISPLAY_REMOVE_BUTTON', 'false', '25', '9', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ALWAYS_DISPLAY_INSTALL_BUTTON', 'false', '25', '10', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHOW_PERMISSIONS_COLUMN', 'false', '25', '11', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHOW_USER_GROUP_COLUMN', 'false', '25', '12', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHOW_UPLOADER_COLUMN', 'false', '25', '13', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHOW_UPLOADED_COLUMN', 'false', '25', '14', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHOW_SIZE_COLUMN', 'false', '25', '15', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('USE_LOG_SYSTEM', 'false', '25', '16', NULL, '0000-00-00 00:00:00', NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_UPLOADED_FILESIZE', '2524288', '25', '17', NULL , '0000-00-00 00:00:00', NULL , NULL);

#configuration_group_id 26

INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_NEW_ARTICLES', 'true', '26', '1', now(), now(), NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('NEW_ARTICLES_DAYS_DISPLAY', '30', 26, '2', now(), now(), NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_NEW_ARTICLES_PER_PAGE', '10', '26', '3', now(), now(), NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DISPLAY_ALL_ARTICLES', 'true', '26', '4', now(), now(), NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_ARTICLES_PER_PAGE', '10', '26', '5', now(), now(), NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SHOW_ARTICLE_COUNTS', 'true', '26', '11', now(), now(), NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_AUTHOR_NAME_LEN', '20', '26', '12', now(), now(), NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_AUTHORS_IN_A_LIST', '1', '26', '13', now(), now(), NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_AUTHORS_LIST', '1', '26', '14', now(), now(), NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_ARTICLES_CONTENT', '150', 26, 15, 'NULL', '', NULL, NULL);

#configuration_group_id 27

INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added, use_function) VALUES ('DOWN_FOR_MAINTENANCE', 'false', '27', '1', 'vam_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EXCLUDE_ADMIN_IP_FOR_MAINTENANCE', 'ip-address', '27', '1', NULL , '0000-00-00 00:00:00', NULL , NULL);

#configuration_group_id 28

INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('AFFILIATE_EMAIL_ADDRESS', 'affiliate@localhost.com', '28', '1', NULL, now(), NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('AFFILIATE_PERCENT', '15.0000', '28', '2', NULL, now(), NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('AFFILIATE_THRESHOLD', '30.00', '28', '3', NULL, now(), NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('AFFILIATE_COOKIE_LIFETIME', '7200', '28', '4', NULL, now(), NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('AFFILIATE_BILLING_TIME', '30', '28', '5', NULL, now(), NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('AFFILIATE_PAYMENT_ORDER_MIN_STATUS', '3', '28', '6', NULL, now(), NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('AFFILIATE_USE_CHECK', 'true', '28', '7', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('AFFILIATE_USE_PAYPAL', 'false', '28', '8', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('AFFILIATE_USE_BANK', 'false', '28', '9', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('AFFILATE_INDIVIDUAL_PERCENTAGE', 'true', '28', '10', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('AFFILATE_USE_TIER', 'false', '28', '11', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('AFFILIATE_TIER_LEVELS', '0', '28', '12', NULL, now(), NULL, NULL);
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('AFFILIATE_TIER_PERCENTAGE', '8.00;5.00;1.00', '28', '13', NULL, now(), NULL, NULL);

#configuration_group_id 29

INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_CATEGORIES', 'true', '29', '1', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_FILTERS', 'true', '29', '2', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_CONTENT', 'true', '29', '3', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_INFORMATION', 'true', '29', '4', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_ADD_QUICKIE', 'true', '29', '5', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_LAST_VIEWED', 'true', '29', '6', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_REVIEWS', 'true', '29', '7', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_SEARCH', 'true', '29', '8', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_SPECIALS', 'true', '29', '9', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_FEATURED', 'true', '29', '10', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_LATESTNEWS', 'true', '29', '11', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_ARTICLES', 'true', '29', '12', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_ARTICLESNEW', 'true', '29', '13', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_AUTHORS', 'true', '29', '14', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_CART', 'true', '29', '15', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_LOGIN', 'true', '29', '16', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_ADMIN', 'true', '29', '17', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_DOWNLOADS', 'true', '29', '18', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_AFFILIATE', 'true', '29', '19', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_WHATSNEW', 'true', '29', '20', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_NEWSLETTER', 'true', '29', '21', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_BESTSELLERS', 'true', '29', '22', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_INFOBOX', 'true', '29', '23', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_CURRENCIES', 'true', '29', '24', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_LANGUAGES', 'true', '29', '25', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_MANUFACTURERS', 'true', '29', '26', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_MANUFACTURERS_INFO', 'true', '29', '27', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('SET_BOX_FAQ', 'true', '29', '28', NULL, now(), NULL,'vam_cfg_select_option(array(\'true\', \'false\'), ');

#configuration_group_id 72
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('ORDER_EDITOR_PAYMENT_DROPDOWN', 'true', '72', '1', now(), now(), NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('ORDER_EDITOR_USE_SPPC', 'false', '72', '3', now(), now(), NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('ORDER_EDITOR_USE_AJAX', 'true', '72', '4', now(), now(), NULL, 'vam_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) values ('ORDER_EDITOR_CREDIT_CARD', 'Credit Card', '72', '5', now(), now(), NULL, 'vam_cfg_pull_down_payment_methods(');

INSERT INTO configuration_group VALUES ('1', 'CG_MY_SHOP', 'My Store', 'General information about my store', '1', '1');
INSERT INTO configuration_group VALUES ('2', 'CG_MINIMAL_VALUES', 'Minimum Values', 'The minimum values for functions / data', '2', '1');
INSERT INTO configuration_group VALUES ('3', 'CG_MAXIMAL_VALUES', 'Maximum Values', 'The maximum values for functions / data', '3', '1');
INSERT INTO configuration_group VALUES ('4', 'CG_PICTURES_PARAMETERS', 'Images', 'Image parameters', '4', '1');
INSERT INTO configuration_group VALUES ('5', 'CG_CUSTOMERS', 'Customer Details', 'Customer account configuration', '5', '1');
INSERT INTO configuration_group VALUES ('6', 'CG_MODULES', 'Module Options', 'Hidden from configuration', '6', '0');
INSERT INTO configuration_group VALUES ('7', 'CG_SHIPPING', 'Shipping/Packaging', 'Shipping options available at my store', '7', '1');
INSERT INTO configuration_group VALUES ('8', 'CG_PRODUCTS', 'Product Listing', 'Product Listing    configuration options', '8', '1');
INSERT INTO configuration_group VALUES ('9', 'CG_WAREHOUSE', 'Stock', 'Stock configuration options', '9', '1');
INSERT INTO configuration_group VALUES ('10', 'CG_LOGGING', 'Logging', 'Logging configuration options', '10', '1');
INSERT INTO configuration_group VALUES ('11', 'CG_CACHE', 'Cache', 'Caching configuration options', '11', '1');
INSERT INTO configuration_group VALUES ('12', 'CG_EMAIL', 'E-Mail Options', 'General setting for E-Mail transport and HTML E-Mails', '12', '1');
INSERT INTO configuration_group VALUES ('13', 'CG_DOWNLOAD', 'Download', 'Downloadable products options', '13', '1');
INSERT INTO configuration_group VALUES ('14', 'CG_MY_GZIP', 'GZip Compression', 'GZip compression options', '14', '1');
INSERT INTO configuration_group VALUES ('15', 'CG_MY_SESSIONS', 'Sessions', 'Session options', '15', '1');
INSERT INTO configuration_group VALUES ('16', 'CG_META_TAGS', 'Meta-Tags/Search engines', 'Meta-tags/Search engines', '16', '1');
INSERT INTO configuration_group VALUES ('18', 'CG_VAT_ID', 'Vat ID', 'Vat ID', '18', '1');
INSERT INTO configuration_group VALUES ('19', 'CG_GOOGLE', 'Google Conversion', 'Google Conversion-Tracking', '19', '1');
INSERT INTO configuration_group VALUES ('20', 'CG_IMPORT_EXPORT', 'Import/Export', 'Import/Export', '20', '1');
INSERT INTO configuration_group VALUES ('21', 'CG_AFTER_BUY', 'Afterbuy', 'Afterbuy.de', '21', '1');
INSERT INTO configuration_group VALUES ('22', 'CG_SEARCH', 'Search Options', 'Additional Options for search function', '22', '1');
INSERT INTO configuration_group VALUES ('23', 'CG_YANDEX_MARKET', 'Яндекс-Маркет', 'Конфигурирование Яндекс-Маркет', '23', '1');
INSERT INTO configuration_group VALUES ('24', 'CG_QUICK_PRICE_UPDATES', 'Изменение цен', 'Настройки модуля изменения цен', '24', '1');
INSERT INTO configuration_group VALUES ('25', 'CG_CIP_MANAGER', 'Установка модулей', 'Настройки модуля', '25', '1');
INSERT INTO configuration_group VALUES ('27', 'CG_MAINTENANCE', 'Site Maintenance', 'Site Maintenance', '27', '1');

INSERT INTO configuration_group VALUES ('28', 'CG_AFFILIATE_PROGRAM', 'Партнёрская программа', 'Настройки партнёрской программы', '28', '1');
INSERT INTO configuration_group VALUES ('29', 'CG_BOXES', 'Боксы', 'Боксы', '29', '1');

INSERT INTO configuration_group VALUES ('72', 'CG_EDIT_ORDERS', 'Order Editor', 'Order Editor Settings', '1', '1');

INSERT INTO countries VALUES (1,'Afghanistan','AF','AFG','1','0');
INSERT INTO countries VALUES (2,'Albania','AL','ALB','1','0');
INSERT INTO countries VALUES (3,'Algeria','DZ','DZA','1','0');
INSERT INTO countries VALUES (4,'American Samoa','AS','ASM','1','0');
INSERT INTO countries VALUES (5,'Andorra','AD','AND','1','0');
INSERT INTO countries VALUES (6,'Angola','AO','AGO','1','0');
INSERT INTO countries VALUES (7,'Anguilla','AI','AIA','1','0');
INSERT INTO countries VALUES (8,'Antarctica','AQ','ATA','1','0');
INSERT INTO countries VALUES (9,'Antigua and Barbuda','AG','ATG','1','0');
INSERT INTO countries VALUES (10,'Argentina','AR','ARG','1','0');
INSERT INTO countries VALUES (11, 'Армения', 'AM', 'ARM', '1','1');
INSERT INTO countries VALUES (12,'Aruba','AW','ABW','1','0');
INSERT INTO countries VALUES (13,'Australia','AU','AUS','1','0');
INSERT INTO countries VALUES (14,'Austria','AT','AUT','5','0');
INSERT INTO countries VALUES (15, 'Азербайджан', 'AZ', 'AZE', '1','1');
INSERT INTO countries VALUES (16,'Bahamas','BS','BHS','1','0');
INSERT INTO countries VALUES (17,'Bahrain','BH','BHR','1','0');
INSERT INTO countries VALUES (18,'Bangladesh','BD','BGD','1','0');
INSERT INTO countries VALUES (19,'Barbados','BB','BRB','1','0');
INSERT INTO countries VALUES (20, 'Белоруссия', 'BY', 'BLR', '1','1');
INSERT INTO countries VALUES (21,'Belgium','BE','BEL','1','0');
INSERT INTO countries VALUES (22,'Belize','BZ','BLZ','1','0');
INSERT INTO countries VALUES (23,'Benin','BJ','BEN','1','0');
INSERT INTO countries VALUES (24,'Bermuda','BM','BMU','1','0');
INSERT INTO countries VALUES (25,'Bhutan','BT','BTN','1','0');
INSERT INTO countries VALUES (26,'Bolivia','BO','BOL','1','0');
INSERT INTO countries VALUES (27,'Bosnia and Herzegowina','BA','BIH','1','0');
INSERT INTO countries VALUES (28,'Botswana','BW','BWA','1','0');
INSERT INTO countries VALUES (29,'Bouvet Island','BV','BVT','1','0');
INSERT INTO countries VALUES (30,'Brazil','BR','BRA','1','0');
INSERT INTO countries VALUES (31,'British Indian Ocean Territory','IO','IOT','1','0');
INSERT INTO countries VALUES (32,'Brunei Darussalam','BN','BRN','1','0');
INSERT INTO countries VALUES (33,'Bulgaria','BG','BGR','1','0');
INSERT INTO countries VALUES (34,'Burkina Faso','BF','BFA','1','0');
INSERT INTO countries VALUES (35,'Burundi','BI','BDI','1','0');
INSERT INTO countries VALUES (36,'Cambodia','KH','KHM','1','0');
INSERT INTO countries VALUES (37,'Cameroon','CM','CMR','1','0');
INSERT INTO countries VALUES (38,'Canada','CA','CAN','1','0');
INSERT INTO countries VALUES (39,'Cape Verde','CV','CPV','1','0');
INSERT INTO countries VALUES (40,'Cayman Islands','KY','CYM','1','0');
INSERT INTO countries VALUES (41,'Central African Republic','CF','CAF','1','0');
INSERT INTO countries VALUES (42,'Chad','TD','TCD','1','0');
INSERT INTO countries VALUES (43,'Chile','CL','CHL','1','0');
INSERT INTO countries VALUES (44,'China','CN','CHN','1','0');
INSERT INTO countries VALUES (45,'Christmas Island','CX','CXR','1','0');
INSERT INTO countries VALUES (46,'Cocos (Keeling) Islands','CC','CCK','1','0');
INSERT INTO countries VALUES (47,'Colombia','CO','COL','1','0');
INSERT INTO countries VALUES (48,'Comoros','KM','COM','1','0');
INSERT INTO countries VALUES (49,'Congo','CG','COG','1','0');
INSERT INTO countries VALUES (50,'Cook Islands','CK','COK','1','0');
INSERT INTO countries VALUES (51,'Costa Rica','CR','CRI','1','0');
INSERT INTO countries VALUES (52,'Cote D\'Ivoire','CI','CIV','1','0');
INSERT INTO countries VALUES (53,'Croatia','HR','HRV','1','0');
INSERT INTO countries VALUES (54,'Cuba','CU','CUB','1','0');
INSERT INTO countries VALUES (55,'Cyprus','CY','CYP','1','0');
INSERT INTO countries VALUES (56,'Czech Republic','CZ','CZE','1','0');
INSERT INTO countries VALUES (57,'Denmark','DK','DNK','1','0');
INSERT INTO countries VALUES (58,'Djibouti','DJ','DJI','1','0');
INSERT INTO countries VALUES (59,'Dominica','DM','DMA','1','0');
INSERT INTO countries VALUES (60,'Dominican Republic','DO','DOM','1','0');
INSERT INTO countries VALUES (61,'East Timor','TP','TMP','1','0');
INSERT INTO countries VALUES (62,'Ecuador','EC','ECU','1','0');
INSERT INTO countries VALUES (63,'Egypt','EG','EGY','1','0');
INSERT INTO countries VALUES (64,'El Salvador','SV','SLV','1','0');
INSERT INTO countries VALUES (65,'Equatorial Guinea','GQ','GNQ','1','0');
INSERT INTO countries VALUES (66,'Eritrea','ER','ERI','1','0');
INSERT INTO countries VALUES (67, 'Эстония', 'EE', 'EST', '1','1');
INSERT INTO countries VALUES (68,'Ethiopia','ET','ETH','1','0');
INSERT INTO countries VALUES (69,'Falkland Islands (Malvinas)','FK','FLK','1','0');
INSERT INTO countries VALUES (70,'Faroe Islands','FO','FRO','1','0');
INSERT INTO countries VALUES (71,'Fiji','FJ','FJI','1','0');
INSERT INTO countries VALUES (72,'Finland','FI','FIN','1','0');
INSERT INTO countries VALUES (73,'France','FR','FRA','1','0');
INSERT INTO countries VALUES (74,'France, Metropolitan','FX','FXX','1','0');
INSERT INTO countries VALUES (75,'French Guiana','GF','GUF','1','0');
INSERT INTO countries VALUES (76,'French Polynesia','PF','PYF','1','0');
INSERT INTO countries VALUES (77,'French Southern Territories','TF','ATF','1','0');
INSERT INTO countries VALUES (78,'Gabon','GA','GAB','1','0');
INSERT INTO countries VALUES (79,'Gambia','GM','GMB','1','0');
INSERT INTO countries VALUES (80, 'Грузия', 'GE', 'GEO', '1','1');
INSERT INTO countries VALUES (81,'Germany','DE','DEU','5','0');
INSERT INTO countries VALUES (82,'Ghana','GH','GHA','1','0');
INSERT INTO countries VALUES (83,'Gibraltar','GI','GIB','1','0');
INSERT INTO countries VALUES (84,'Greece','GR','GRC','1','0');
INSERT INTO countries VALUES (85,'Greenland','GL','GRL','1','0');
INSERT INTO countries VALUES (86,'Grenada','GD','GRD','1','0');
INSERT INTO countries VALUES (87,'Guadeloupe','GP','GLP','1','0');
INSERT INTO countries VALUES (88,'Guam','GU','GUM','1','0');
INSERT INTO countries VALUES (89,'Guatemala','GT','GTM','1','0');
INSERT INTO countries VALUES (90,'Guinea','GN','GIN','1','0');
INSERT INTO countries VALUES (91,'Guinea-bissau','GW','GNB','1','0');
INSERT INTO countries VALUES (92,'Guyana','GY','GUY','1','0');
INSERT INTO countries VALUES (93,'Haiti','HT','HTI','1','0');
INSERT INTO countries VALUES (94,'Heard and Mc Donald Islands','HM','HMD','1','0');
INSERT INTO countries VALUES (95,'Honduras','HN','HND','1','0');
INSERT INTO countries VALUES (96,'Hong Kong','HK','HKG','1','0');
INSERT INTO countries VALUES (97,'Hungary','HU','HUN','1','0');
INSERT INTO countries VALUES (98,'Iceland','IS','ISL','1','0');
INSERT INTO countries VALUES (99,'India','IN','IND','1','0');
INSERT INTO countries VALUES (100,'Indonesia','ID','IDN','1','0');
INSERT INTO countries VALUES (101,'Iran (Islamic Republic of)','IR','IRN','1','0');
INSERT INTO countries VALUES (102,'Iraq','IQ','IRQ','1','0');
INSERT INTO countries VALUES (103,'Ireland','IE','IRL','1','0');
INSERT INTO countries VALUES (104,'Israel','IL','ISR','1','0');
INSERT INTO countries VALUES (105,'Italy','IT','ITA','1','0');
INSERT INTO countries VALUES (106,'Jamaica','JM','JAM','1','0');
INSERT INTO countries VALUES (107,'Japan','JP','JPN','1','0');
INSERT INTO countries VALUES (108,'Jordan','JO','JOR','1','0');
INSERT INTO countries VALUES (109, 'Казахстан', 'KZ', 'KAZ', '1','1');
INSERT INTO countries VALUES (110,'Kenya','KE','KEN','1','0');
INSERT INTO countries VALUES (111,'Kiribati','KI','KIR','1','0');
INSERT INTO countries VALUES (112,'Korea, Democratic People\'s Republic of','KP','PRK','1','0');
INSERT INTO countries VALUES (113,'Korea, Republic of','KR','KOR','1','0');
INSERT INTO countries VALUES (114,'Kuwait','KW','KWT','1','0');
INSERT INTO countries VALUES (115, 'Кыргызстан', 'KG', 'KGZ', '1','1');
INSERT INTO countries VALUES (116,'Lao People\'s Democratic Republic','LA','LAO','1','0');
INSERT INTO countries VALUES (117, 'Латвия', 'LV', 'LVA', '1','1');
INSERT INTO countries VALUES (118,'Lebanon','LB','LBN','1','0');
INSERT INTO countries VALUES (119,'Lesotho','LS','LSO','1','0');
INSERT INTO countries VALUES (120,'Liberia','LR','LBR','1','0');
INSERT INTO countries VALUES (121,'Libyan Arab Jamahiriya','LY','LBY','1','0');
INSERT INTO countries VALUES (122,'Liechtenstein','LI','LIE','1','0');
INSERT INTO countries VALUES (123, 'Литва', 'LT', 'LTU', '1','1');
INSERT INTO countries VALUES (124,'Luxembourg','LU','LUX','1','0');
INSERT INTO countries VALUES (125,'Macau','MO','MAC','1','0');
INSERT INTO countries VALUES (126,'Macedonia, The Former Yugoslav Republic of','MK','MKD','1','0');
INSERT INTO countries VALUES (127,'Madagascar','MG','MDG','1','0');
INSERT INTO countries VALUES (128,'Malawi','MW','MWI','1','0');
INSERT INTO countries VALUES (129,'Malaysia','MY','MYS','1','0');
INSERT INTO countries VALUES (130,'Maldives','MV','MDV','1','0');
INSERT INTO countries VALUES (131,'Mali','ML','MLI','1','0');
INSERT INTO countries VALUES (132,'Malta','MT','MLT','1','0');
INSERT INTO countries VALUES (133,'Marshall Islands','MH','MHL','1','0');
INSERT INTO countries VALUES (134,'Martinique','MQ','MTQ','1','0');
INSERT INTO countries VALUES (135,'Mauritania','MR','MRT','1','0');
INSERT INTO countries VALUES (136,'Mauritius','MU','MUS','1','0');
INSERT INTO countries VALUES (137,'Mayotte','YT','MYT','1','0');
INSERT INTO countries VALUES (138,'Mexico','MX','MEX','1','0');
INSERT INTO countries VALUES (139,'Micronesia, Federated States of','FM','FSM','1','0');
INSERT INTO countries VALUES (140, 'Молдавия', 'MD', 'MDA', '1','1');
INSERT INTO countries VALUES (141,'Monaco','MC','MCO','1','0');
INSERT INTO countries VALUES (142,'Mongolia','MN','MNG','1','0');
INSERT INTO countries VALUES (143,'Montserrat','MS','MSR','1','0');
INSERT INTO countries VALUES (144,'Morocco','MA','MAR','1','0');
INSERT INTO countries VALUES (145,'Mozambique','MZ','MOZ','1','0');
INSERT INTO countries VALUES (146,'Myanmar','MM','MMR','1','0');
INSERT INTO countries VALUES (147,'Namibia','NA','NAM','1','0');
INSERT INTO countries VALUES (148,'Nauru','NR','NRU','1','0');
INSERT INTO countries VALUES (149,'Nepal','NP','NPL','1','0');
INSERT INTO countries VALUES (150,'Netherlands','NL','NLD','1','0');
INSERT INTO countries VALUES (151,'Netherlands Antilles','AN','ANT','1','0');
INSERT INTO countries VALUES (152,'New Caledonia','NC','NCL','1','0');
INSERT INTO countries VALUES (153,'New Zealand','NZ','NZL','1','0');
INSERT INTO countries VALUES (154,'Nicaragua','NI','NIC','1','0');
INSERT INTO countries VALUES (155,'Niger','NE','NER','1','0');
INSERT INTO countries VALUES (156,'Nigeria','NG','NGA','1','0');
INSERT INTO countries VALUES (157,'Niue','NU','NIU','1','0');
INSERT INTO countries VALUES (158,'Norfolk Island','NF','NFK','1','0');
INSERT INTO countries VALUES (159,'Northern Mariana Islands','MP','MNP','1','0');
INSERT INTO countries VALUES (160,'Norway','NO','NOR','1','0');
INSERT INTO countries VALUES (161,'Oman','OM','OMN','1','0');
INSERT INTO countries VALUES (162,'Pakistan','PK','PAK','1','0');
INSERT INTO countries VALUES (163,'Palau','PW','PLW','1','0');
INSERT INTO countries VALUES (164,'Panama','PA','PAN','1','0');
INSERT INTO countries VALUES (165,'Papua New Guinea','PG','PNG','1','0');
INSERT INTO countries VALUES (166,'Paraguay','PY','PRY','1','0');
INSERT INTO countries VALUES (167,'Peru','PE','PER','1','0');
INSERT INTO countries VALUES (168,'Philippines','PH','PHL','1','0');
INSERT INTO countries VALUES (169,'Pitcairn','PN','PCN','1','0');
INSERT INTO countries VALUES (170,'Poland','PL','POL','1','0');
INSERT INTO countries VALUES (171,'Portugal','PT','PRT','1','0');
INSERT INTO countries VALUES (172,'Puerto Rico','PR','PRI','1','0');
INSERT INTO countries VALUES (173,'Qatar','QA','QAT','1','0');
INSERT INTO countries VALUES (174,'Reunion','RE','REU','1','0');
INSERT INTO countries VALUES (175,'Romania','RO','ROM','1','0');
INSERT INTO countries VALUES (176, 'Российская Федерация', 'RU', 'RUS', '1','1');
INSERT INTO countries VALUES (177,'Rwanda','RW','RWA','1','0');
INSERT INTO countries VALUES (178,'Saint Kitts and Nevis','KN','KNA','1','0');
INSERT INTO countries VALUES (179,'Saint Lucia','LC','LCA','1','0');
INSERT INTO countries VALUES (180,'Saint Vincent and the Grenadines','VC','VCT','1','0');
INSERT INTO countries VALUES (181,'Samoa','WS','WSM','1','0');
INSERT INTO countries VALUES (182,'San Marino','SM','SMR','1','0');
INSERT INTO countries VALUES (183,'Sao Tome and Principe','ST','STP','1','0');
INSERT INTO countries VALUES (184,'Saudi Arabia','SA','SAU','1','0');
INSERT INTO countries VALUES (185,'Senegal','SN','SEN','1','0');
INSERT INTO countries VALUES (186,'Seychelles','SC','SYC','1','0');
INSERT INTO countries VALUES (187,'Sierra Leone','SL','SLE','1','0');
INSERT INTO countries VALUES (188,'Singapore','SG','SGP', '4','0');
INSERT INTO countries VALUES (189,'Slovakia (Slovak Republic)','SK','SVK','1','0');
INSERT INTO countries VALUES (190,'Slovenia','SI','SVN','1','0');
INSERT INTO countries VALUES (191,'Solomon Islands','SB','SLB','1','0');
INSERT INTO countries VALUES (192,'Somalia','SO','SOM','1','0');
INSERT INTO countries VALUES (193,'South Africa','ZA','ZAF','1','0');
INSERT INTO countries VALUES (194,'South Georgia and the South Sandwich Islands','GS','SGS','1','0');
INSERT INTO countries VALUES (195,'Spain','ES','ESP','3','0');
INSERT INTO countries VALUES (196,'Sri Lanka','LK','LKA','1','0');
INSERT INTO countries VALUES (197,'St. Helena','SH','SHN','1','0');
INSERT INTO countries VALUES (198,'St. Pierre and Miquelon','PM','SPM','1','0');
INSERT INTO countries VALUES (199,'Sudan','SD','SDN','1','0');
INSERT INTO countries VALUES (200,'Suriname','SR','SUR','1','0');
INSERT INTO countries VALUES (201,'Svalbard and Jan Mayen Islands','SJ','SJM','1','0');
INSERT INTO countries VALUES (202,'Swaziland','SZ','SWZ','1','0');
INSERT INTO countries VALUES (203,'Sweden','SE','SWE','1','0');
INSERT INTO countries VALUES (204,'Switzerland','CH','CHE','1','0');
INSERT INTO countries VALUES (205,'Syrian Arab Republic','SY','SYR','1','0');
INSERT INTO countries VALUES (206,'Taiwan','TW','TWN','1','0');
INSERT INTO countries VALUES (207, 'Таджикистан', 'TJ', 'TJK', '1','1');
INSERT INTO countries VALUES (208,'Tanzania, United Republic of','TZ','TZA','1','0');
INSERT INTO countries VALUES (209,'Thailand','TH','THA','1','0');
INSERT INTO countries VALUES (210,'Togo','TG','TGO','1','0');
INSERT INTO countries VALUES (211,'Tokelau','TK','TKL','1','0');
INSERT INTO countries VALUES (212,'Tonga','TO','TON','1','0');
INSERT INTO countries VALUES (213,'Trinidad and Tobago','TT','TTO','1','0');
INSERT INTO countries VALUES (214,'Tunisia','TN','TUN','1','0');
INSERT INTO countries VALUES (215,'Turkey','TR','TUR','1','0');
INSERT INTO countries VALUES (216, 'Туркменистан', 'TM', 'TKM', '1','1');
INSERT INTO countries VALUES (217,'Turks and Caicos Islands','TC','TCA','1','0');
INSERT INTO countries VALUES (218,'Tuvalu','TV','TUV','1','0');
INSERT INTO countries VALUES (219,'Uganda','UG','UGA','1','0');
INSERT INTO countries VALUES (220, 'Украина', 'UA', 'UKR', '1','1');
INSERT INTO countries VALUES (221,'United Arab Emirates','AE','ARE','1','0');
INSERT INTO countries VALUES (222,'United Kingdom','GB','GBR','1','0');
INSERT INTO countries VALUES (223,'United States','US','USA', '2','0');
INSERT INTO countries VALUES (224,'United States Minor Outlying Islands','UM','UMI','1','0');
INSERT INTO countries VALUES (225,'Uruguay','UY','URY','1','0');
INSERT INTO countries VALUES (226, 'Узбекистан', 'UZ', 'UZB', '1','1');
INSERT INTO countries VALUES (227,'Vanuatu','VU','VUT','1','0');
INSERT INTO countries VALUES (228,'Vatican City State (Holy See)','VA','VAT','1','0');
INSERT INTO countries VALUES (229,'Venezuela','VE','VEN','1','0');
INSERT INTO countries VALUES (230,'Viet Nam','VN','VNM','1','0');
INSERT INTO countries VALUES (231,'Virgin Islands (British)','VG','VGB','1','0');
INSERT INTO countries VALUES (232,'Virgin Islands (U.S.)','VI','VIR','1','0');
INSERT INTO countries VALUES (233,'Wallis and Futuna Islands','WF','WLF','1','0');
INSERT INTO countries VALUES (234,'Western Sahara','EH','ESH','1','0');
INSERT INTO countries VALUES (235,'Yemen','YE','YEM','1','0');
INSERT INTO countries VALUES (236,'Yugoslavia','YU','YUG','1','0');
INSERT INTO countries VALUES (237,'Zaire','ZR','ZAR','1','0');
INSERT INTO countries VALUES (238,'Zambia','ZM','ZMB','1','0');
INSERT INTO countries VALUES (239,'Zimbabwe','ZW','ZWE','1','0');

INSERT INTO currencies VALUES (1,'Рубль','RUR','','руб.',',','.','2','1.0000', now());


INSERT INTO languages VALUES (1,'Русский','ru','icon.gif','russian',1,'utf-8');


INSERT INTO orders_status VALUES ( '1', '1', 'Ожидает проверки');
INSERT INTO orders_status VALUES ( '2', '1', 'Ждём оплаты');
INSERT INTO orders_status VALUES ( '3', '1', 'Отменён');
INSERT INTO orders_status VALUES ( '4', '1', 'Выполняется');
INSERT INTO orders_status VALUES ( '5', '1', 'Доставляется');
INSERT INTO orders_status VALUES ( '6', '1', 'Доставлен');



INSERT INTO zones VALUES ('1', '109', 'Акмолинская область', 'Акмолинская область');
INSERT INTO zones VALUES ('2', '109', 'Актюбинская область', 'Актюбинская область');
INSERT INTO zones VALUES ('3', '109', 'Алматинская область', 'Алматинская область');
INSERT INTO zones VALUES ('4', '109', 'Атырауская область', 'Атырауская область');
INSERT INTO zones VALUES ('5', '109', 'Восточно-Казахстанская область', 'Восточно-Казахстанская область');
INSERT INTO zones VALUES ('6', '109', 'Жамбылская область', 'Жамбылская область');
INSERT INTO zones VALUES ('7', '109', 'Западно-Казахстанская область', 'Западно-Казахстанская область');
INSERT INTO zones VALUES ('8', '109', 'Карагандинская область', 'Карагандинская область');
INSERT INTO zones VALUES ('9', '109', 'Кзылординская область', 'Кзылординская область');
INSERT INTO zones VALUES ('10', '109', 'Костанайская область', 'Костанайская область');
INSERT INTO zones VALUES ('11', '109', 'Мангистауская область', 'Мангистауская область');
INSERT INTO zones VALUES ('12', '109', 'Павлодарская область', 'Павлодарская область');
INSERT INTO zones VALUES ('13', '109', 'Северо-Казахстанская область', 'Северо-Казахстанская область');
INSERT INTO zones VALUES ('14', '109', 'Южно-Казахстанская область', 'Южно-Казахстанская область');
INSERT INTO zones VALUES ('15', '115', 'Баткенская область', 'Баткенская область');
INSERT INTO zones VALUES ('16', '115', 'Джалал-Абадская область', 'Джалал-Абадская область');
INSERT INTO zones VALUES ('17', '115', 'Иссык-Кульская область', 'Иссык-Кульская область');
INSERT INTO zones VALUES ('18', '115', 'Таласская область', 'Таласская область');
INSERT INTO zones VALUES ('19', '115', 'Нарынская область', 'Нарынская область');
INSERT INTO zones VALUES ('20', '115', 'Ошская область', 'Ошская область');
INSERT INTO zones VALUES ('21', '115', 'Чуйская область', 'Чуйская область');
INSERT INTO zones VALUES ('22', '176', 'Адыгея', 'Адыгея');
INSERT INTO zones VALUES ('23', '176', 'Башкирия', 'Башкирия');
INSERT INTO zones VALUES ('24', '176', 'Бурятия', 'Бурятия');
INSERT INTO zones VALUES ('25', '176', 'Горный Алтай', 'Горный Алтай');
INSERT INTO zones VALUES ('26', '176', 'Дагестан', 'Дагестан');
INSERT INTO zones VALUES ('27', '176', 'Ингушетия', 'Ингушетия');
INSERT INTO zones VALUES ('28', '176', 'Кабардино-Балкария', 'Кабардино-Балкария');
INSERT INTO zones VALUES ('29', '176', 'Калмыкия', 'Калмыкия');
INSERT INTO zones VALUES ('30', '176', 'Карачаево-Черкесия', 'Карачаево-Черкесия');
INSERT INTO zones VALUES ('31', '176', 'Карелия', 'Карелия');
INSERT INTO zones VALUES ('32', '176', 'Коми', 'Коми');
INSERT INTO zones VALUES ('33', '176', 'Марийская Республика', 'Марийская Республика');
INSERT INTO zones VALUES ('34', '176', 'Мордовская Республика', 'Мордовская Республика');
INSERT INTO zones VALUES ('35', '176', 'Якутия', 'Якутия');
INSERT INTO zones VALUES ('36', '176', 'Северная Осетия', 'Северная Осетия');
INSERT INTO zones VALUES ('37', '176', 'Татарстан', 'Татарстан');
INSERT INTO zones VALUES ('38', '176', 'Тува', 'Тува');
INSERT INTO zones VALUES ('39', '176', 'Удмуртия', 'Удмуртия');
INSERT INTO zones VALUES ('40', '176', 'Хакасия', 'Хакасия');
INSERT INTO zones VALUES ('41', '176', 'Чечня', 'Чечня');
INSERT INTO zones VALUES ('42', '176', 'Чувашия', 'Чувашия');
INSERT INTO zones VALUES ('43', '176', 'Алтайский край', 'Алтайский край');
INSERT INTO zones VALUES ('44', '176', 'Краснодарский край', 'Краснодарский край');
INSERT INTO zones VALUES ('45', '176', 'Красноярский край', 'Красноярский край');
INSERT INTO zones VALUES ('46', '176', 'Приморский край', 'Приморский край');
INSERT INTO zones VALUES ('47', '176', 'Ставропольский край', 'Ставропольский край');
INSERT INTO zones VALUES ('48', '176', 'Хабаровский край', 'Хабаровский край');
INSERT INTO zones VALUES ('49', '176', 'Амурская область', 'Амурская область');
INSERT INTO zones VALUES ('50', '176', 'Архангельская область', 'Архангельская область');
INSERT INTO zones VALUES ('51', '176', 'Астраханская область', 'Астраханская область');
INSERT INTO zones VALUES ('52', '176', 'Белгородская область', 'Белгородская область');
INSERT INTO zones VALUES ('53', '176', 'Брянская область', 'Брянская область');
INSERT INTO zones VALUES ('54', '176', 'Владимирская область', 'Владимирская область');
INSERT INTO zones VALUES ('55', '176', 'Волгоградская область', 'Волгоградская область');
INSERT INTO zones VALUES ('56', '176', 'Вологодская область', 'Вологодская область');
INSERT INTO zones VALUES ('57', '176', 'Воронежская область', 'Воронежская область');
INSERT INTO zones VALUES ('58', '176', 'Ивановская область', 'Ивановская область');
INSERT INTO zones VALUES ('59', '176', 'Иркутская область', 'Иркутская область');
INSERT INTO zones VALUES ('60', '176', 'Калининградская область', 'Калининградская область');
INSERT INTO zones VALUES ('61', '176', 'Калужская область', 'Калужская область');
INSERT INTO zones VALUES ('62', '176', 'Камчатский край', 'Камчатский край');
INSERT INTO zones VALUES ('63', '176', 'Кемеровская область', 'Кемеровская область');
INSERT INTO zones VALUES ('64', '176', 'Кировская область', 'Кировская область');
INSERT INTO zones VALUES ('65', '176', 'Костромская область', 'Костромская область');
INSERT INTO zones VALUES ('66', '176', 'Курганская область', 'Курганская область');
INSERT INTO zones VALUES ('67', '176', 'Курская область', 'Курская область');
INSERT INTO zones VALUES ('68', '176', 'Ленинградская область', 'Ленинградская область');
INSERT INTO zones VALUES ('69', '176', 'Липецкая область', 'Липецкая область');
INSERT INTO zones VALUES ('70', '176', 'Магаданская область', 'Магаданская область');
INSERT INTO zones VALUES ('71', '176', 'Московская область', 'Московская область');
INSERT INTO zones VALUES ('72', '176', 'Мурманская область', 'Мурманская область');
INSERT INTO zones VALUES ('73', '176', 'Нижегородская область', 'Нижегородская область');
INSERT INTO zones VALUES ('74', '176', 'Новгородская область', 'Новгородская область');
INSERT INTO zones VALUES ('75', '176', 'Новосибирская область', 'Новосибирская область');
INSERT INTO zones VALUES ('76', '176', 'Омская область', 'Омская область');
INSERT INTO zones VALUES ('77', '176', 'Оренбургская область', 'Оренбургская область');
INSERT INTO zones VALUES ('78', '176', 'Орловская область', 'Орловская область');
INSERT INTO zones VALUES ('79', '176', 'Пензенская область', 'Пензенская область');
INSERT INTO zones VALUES ('80', '176', 'Пермский край', 'Пермский край');
INSERT INTO zones VALUES ('81', '176', 'Псковская область', 'Псковская область');
INSERT INTO zones VALUES ('82', '176', 'Ростовская область', 'Ростовская область');
INSERT INTO zones VALUES ('83', '176', 'Рязанская область', 'Рязанская область');
INSERT INTO zones VALUES ('84', '176', 'Самарская область', 'Самарская область');
INSERT INTO zones VALUES ('85', '176', 'Саратовская область', 'Саратовская область');
INSERT INTO zones VALUES ('86', '176', 'Сахалинская область', 'Сахалинская область');
INSERT INTO zones VALUES ('87', '176', 'Свердловская область', 'Свердловская область');
INSERT INTO zones VALUES ('88', '176', 'Смоленская область', 'Смоленская область');
INSERT INTO zones VALUES ('89', '176', 'Тамбовская область', 'Тамбовская область');
INSERT INTO zones VALUES ('90', '176', 'Тверская область', 'Тверская область');
INSERT INTO zones VALUES ('91', '176', 'Томская область', 'Томская область');
INSERT INTO zones VALUES ('92', '176', 'Тульская область', 'Тульская область');
INSERT INTO zones VALUES ('93', '176', 'Тюменская область', 'Тюменская область');
INSERT INTO zones VALUES ('94', '176', 'Ульяновская область', 'Ульяновская область');
INSERT INTO zones VALUES ('95', '176', 'Челябинская область', 'Челябинская область');
INSERT INTO zones VALUES ('96', '176', 'Читинская область', 'Читинская область');
INSERT INTO zones VALUES ('97', '176', 'Ярославская область', 'Ярославская область');
INSERT INTO zones VALUES ('98', '176', 'Москва', 'Москва');
INSERT INTO zones VALUES ('99', '176', 'Санкт-Петербург', 'Санкт-Петербург');
INSERT INTO zones VALUES ('100', '176', 'Еврейская автономная область', 'Еврейская автономная область');
INSERT INTO zones VALUES ('101', '176', 'Агинский Бурятский АО', 'Агинский Бурятский АО');
INSERT INTO zones VALUES ('104', '176', 'Ненецкий АО', 'Ненецкий АО');
INSERT INTO zones VALUES ('105', '176', 'Таймырский АО', 'Таймырский АО');
INSERT INTO zones VALUES ('106', '176', 'Усть-Ордынский Бурятский АО', 'Усть-Ордынский Бурятский АО');
INSERT INTO zones VALUES ('107', '176', 'Ханты-Мансийский АО', 'Ханты-Мансийский АО');
INSERT INTO zones VALUES ('108', '176', 'Чукотский АО', 'Чукотский АО');
INSERT INTO zones VALUES ('109', '176', 'Эвенкийский АО', 'Эвенкийский АО');
INSERT INTO zones VALUES ('110', '176', 'Ямало-Ненецкий АО', 'Ямало-Ненецкий АО');
INSERT INTO zones VALUES ('111', '207', 'Мухтори-Кухистони-Бадахшони', 'Мухтори-Кухистони-Бадахшони');
INSERT INTO zones VALUES ('112', '207', 'Хатлонская область', 'Хатлонская область');
INSERT INTO zones VALUES ('113', '207', 'Ленинабадская область', 'Ленинабадская область');
INSERT INTO zones VALUES ('114', '216', 'Ахал', 'Ахал');
INSERT INTO zones VALUES ('115', '216', 'Балкан', 'Балкан');
INSERT INTO zones VALUES ('116', '216', 'Дашховуз', 'Дашховуз');
INSERT INTO zones VALUES ('117', '216', 'Лебап', 'Лебап');
INSERT INTO zones VALUES ('118', '216', 'Мары', 'Мары');
INSERT INTO zones VALUES ('119', '220', 'Республика Крым', 'Республика Крым');
INSERT INTO zones VALUES ('120', '220', 'Винницкая область', 'Винницкая область');
INSERT INTO zones VALUES ('121', '220', 'Волынская область', 'Волынская область');
INSERT INTO zones VALUES ('122', '220', 'Днепропетровская область', 'Днепропетровская область');
INSERT INTO zones VALUES ('123', '220', 'Донецкая область', 'Донецкая область');
INSERT INTO zones VALUES ('124', '220', 'Житомирская область', 'Житомирская область');
INSERT INTO zones VALUES ('125', '220', 'Закарпатская область', 'Закарпатская область');
INSERT INTO zones VALUES ('126', '220', 'Запорожская область', 'Запорожская область');
INSERT INTO zones VALUES ('127', '220', 'Ивано-Франковская область', 'Ивано-Франковская область');
INSERT INTO zones VALUES ('128', '220', 'Киевская область', 'Киевская область');
INSERT INTO zones VALUES ('129', '220', 'Кировоградская область', 'Кировоградская область');
INSERT INTO zones VALUES ('130', '220', 'Луганская область', 'Луганская область');
INSERT INTO zones VALUES ('131', '220', 'Львовская область', 'Львовская область');
INSERT INTO zones VALUES ('132', '220', 'Николаевская область', 'Николаевская область');
INSERT INTO zones VALUES ('133', '220', 'Одесская область', 'Одесская область');
INSERT INTO zones VALUES ('134', '220', 'Полтавская область', 'Полтавская область');
INSERT INTO zones VALUES ('135', '220', 'Ровенская область', 'Ровенская область');
INSERT INTO zones VALUES ('136', '220', 'Сумская область', 'Сумская область');
INSERT INTO zones VALUES ('137', '220', 'Тернопольская область', 'Тернопольская область');
INSERT INTO zones VALUES ('138', '220', 'Харьковская область', 'Харьковская область');
INSERT INTO zones VALUES ('139', '220', 'Херсонская область', 'Херсонская область');
INSERT INTO zones VALUES ('140', '220', 'Хмельницкая область', 'Хмельницкая область');
INSERT INTO zones VALUES ('141', '220', 'Черкасская область', 'Черкасская область');
INSERT INTO zones VALUES ('142', '220', 'Черниговская область', 'Черниговская область');
INSERT INTO zones VALUES ('143', '220', 'Черновицкая область', 'Черновицкая область');
INSERT INTO zones VALUES ('144', '226', 'Андижанский', 'Андижанский');
INSERT INTO zones VALUES ('145', '226', 'Бухарский', 'Бухарский');
INSERT INTO zones VALUES ('146', '226', 'Джизакский', 'Джизакский');
INSERT INTO zones VALUES ('147', '226', 'Каракалпакия', 'Каракалпакия');
INSERT INTO zones VALUES ('148', '226', 'Кашкадарьинский', 'Кашкадарьинский');
INSERT INTO zones VALUES ('149', '226', 'Навоийский', 'Навоийский');
INSERT INTO zones VALUES ('150', '226', 'Наманганский', 'Наманганский');
INSERT INTO zones VALUES ('151', '226', 'Самаркандский', 'Самаркандский');
INSERT INTO zones VALUES ('152', '226', 'Сурхандарьинский', 'Сурхандарьинский');
INSERT INTO zones VALUES ('153', '226', 'Сырдарьинский', 'Сырдарьинский');
INSERT INTO zones VALUES ('154', '226', 'Ташкентский', 'Ташкентский');
INSERT INTO zones VALUES ('155', '226', 'Ферганский', 'Ферганский');
INSERT INTO zones VALUES ('156', '226', 'Хорезмский', 'Хорезмский');
INSERT INTO zones VALUES ('157', '15', 'Апшеронский район', 'Апшеронский район');
INSERT INTO zones VALUES ('158', '15', 'Агдамский район', 'Агдамский район');
INSERT INTO zones VALUES ('159', '15', 'Агдашский район', 'Агдашский район');
INSERT INTO zones VALUES ('160', '15', 'Агджабединский район', 'Агджабединский район');
INSERT INTO zones VALUES ('161', '15', 'Акстафинский район', 'Акстафинский район');
INSERT INTO zones VALUES ('162', '15', 'Агсуинский район', 'Агсуинский район');
INSERT INTO zones VALUES ('163', '15', 'Астаринский район', 'Астаринский район');
INSERT INTO zones VALUES ('164', '15', 'Балакенский район', 'Балакенский район');
INSERT INTO zones VALUES ('165', '15', 'Бейлаганский район', 'Бейлаганский район');
INSERT INTO zones VALUES ('166', '15', 'Бардинский район', 'Бардинский район');
INSERT INTO zones VALUES ('167', '15', 'Билясуварский район', 'Билясуварский район');
INSERT INTO zones VALUES ('168', '15', 'Джебраильский район', 'Джебраильский район');
INSERT INTO zones VALUES ('169', '15', 'Джалилабадский район', 'Джалилабадский район');
INSERT INTO zones VALUES ('170', '15', 'Дашкесанский район', 'Дашкесанский район');
INSERT INTO zones VALUES ('171', '15', 'Дивичинский район', 'Дивичинский район');
INSERT INTO zones VALUES ('172', '15', 'Физулинский район', 'Физулинский район');
INSERT INTO zones VALUES ('173', '15', 'Кедабекский район', 'Кедабекский район');
INSERT INTO zones VALUES ('174', '15', 'Геранбойский район', 'Геранбойский район');
INSERT INTO zones VALUES ('175', '15', 'Геокчайский район', 'Геокчайский район');
INSERT INTO zones VALUES ('176', '15', 'Гаджигабульский район', 'Гаджигабульский район');
INSERT INTO zones VALUES ('177', '15', 'Хачмазский район', 'Хачмазский район');
INSERT INTO zones VALUES ('178', '15', 'Ханларский район', 'Ханларский район');
INSERT INTO zones VALUES ('179', '15', 'Хызынский район', 'Хызынский район');
INSERT INTO zones VALUES ('180', '15', 'Ходжавендский район', 'Ходжавендский район');
INSERT INTO zones VALUES ('181', '15', 'Ходжалинский район', 'Ходжалинский район');
INSERT INTO zones VALUES ('182', '15', 'Имишлинский район', 'Имишлинский район');
INSERT INTO zones VALUES ('183', '15', 'Исмаиллинский район', 'Исмаиллинский район');
INSERT INTO zones VALUES ('184', '15', 'Кельбаджарский район', 'Кельбаджарский район');
INSERT INTO zones VALUES ('185', '15', 'Кюрдамирский район', 'Кюрдамирский район');
INSERT INTO zones VALUES ('186', '15', 'Гахский район', 'Гахский район');
INSERT INTO zones VALUES ('187', '15', 'Газахский район', 'Газахский район');
INSERT INTO zones VALUES ('188', '15', 'Габалинский район', 'Габалинский район');
INSERT INTO zones VALUES ('189', '15', 'Гобустанский район', 'Гобустанский район');
INSERT INTO zones VALUES ('190', '15', 'Губинский район', 'Губинский район');
INSERT INTO zones VALUES ('191', '15', 'Губадлинский район', 'Губадлинский район');
INSERT INTO zones VALUES ('192', '15', 'Гусарский район', 'Гусарский район');
INSERT INTO zones VALUES ('193', '15', 'Лачинский район', 'Лачинский район');
INSERT INTO zones VALUES ('194', '15', 'Ленкоранский район', 'Ленкоранский район');
INSERT INTO zones VALUES ('195', '15', 'Лерикский район', 'Лерикский район');
INSERT INTO zones VALUES ('196', '15', 'Масаллинский район', 'Масаллинский район');
INSERT INTO zones VALUES ('197', '15', 'Нефтчалинский район', 'Нефтчалинский район');
INSERT INTO zones VALUES ('198', '15', 'Огузский район', 'Огузский район');
INSERT INTO zones VALUES ('199', '15', 'Саатлинский район', 'Саатлинский район');
INSERT INTO zones VALUES ('200', '15', 'Сабирабадский район', 'Сабирабадский район');
INSERT INTO zones VALUES ('201', '15', 'Сальянский район', 'Сальянский район');
INSERT INTO zones VALUES ('202', '15', 'Самухский район', 'Самухский район');
INSERT INTO zones VALUES ('203', '15', 'Сиязаньский район', 'Сиязаньский район');
INSERT INTO zones VALUES ('204', '15', 'Шемахинский район', 'Шемахинский район');
INSERT INTO zones VALUES ('205', '15', 'Шемкирский район', 'Шемкирский район');
INSERT INTO zones VALUES ('206', '15', 'Шекинский район', 'Шекинский район');
INSERT INTO zones VALUES ('207', '15', 'Шушинский район', 'Шушинский район');
INSERT INTO zones VALUES ('208', '15', 'Тертерский район', 'Тертерский район');
INSERT INTO zones VALUES ('209', '15', 'Товузский район', 'Товузский район');
INSERT INTO zones VALUES ('210', '15', 'Уджарский район', 'Уджарский район');
INSERT INTO zones VALUES ('211', '15', 'Ярдымлинский район', 'Ярдымлинский район');
INSERT INTO zones VALUES ('212', '15', 'Евлахский район', 'Евлахский район');
INSERT INTO zones VALUES ('213', '15', 'Закатальский район', 'Закатальский район');
INSERT INTO zones VALUES ('214', '15', 'Зангеланский район', 'Зангеланский район');
INSERT INTO zones VALUES ('215', '15', 'Зардабский район', 'Зардабский район');
INSERT INTO zones VALUES ('216', '15', 'Нахичеванская Автономная Республика', 'Нахичеванская Автономная Республика');
INSERT INTO zones VALUES ('217', '15', 'Бабекский район', 'Бабекский район');
INSERT INTO zones VALUES ('218', '15', 'Джульфинский район', 'Джульфинский район');
INSERT INTO zones VALUES ('219', '15', 'Ордубадский район', 'Ордубадский район');
INSERT INTO zones VALUES ('220', '15', 'Садаракский район', 'Садаракский район');
INSERT INTO zones VALUES ('221', '15', 'Шахбузский район', 'Шахбузский район');
INSERT INTO zones VALUES ('222', '15', 'Шарурский район', 'Шарурский район');
INSERT INTO zones VALUES ('223', '67', 'Харьюский уезд', 'Харьюский уезд');
INSERT INTO zones VALUES ('224', '67', 'Хийумааский уезд', 'Хийумааский уезд');
INSERT INTO zones VALUES ('225', '67', 'Ида-Вирумааский уезд', 'Ида-Вирумааский уезд');
INSERT INTO zones VALUES ('226', '67', 'Ярвамаамааский уезд', 'Ярвамаамааский уезд');
INSERT INTO zones VALUES ('227', '67', 'Йыгевамааский уезд', 'Йыгевамааский уезд');
INSERT INTO zones VALUES ('228', '67', 'Ляэнемааский уезд', 'Ляэнемааский уезд');
INSERT INTO zones VALUES ('229', '67', 'Ляэне-Вирумааский уезд', 'Ляэне-Вирумааский уезд');
INSERT INTO zones VALUES ('230', '67', 'Пылвамааский уезд', 'Пылвамааский уезд');
INSERT INTO zones VALUES ('231', '67', 'Пярнумааский уезд', 'Пярнумааский уезд');
INSERT INTO zones VALUES ('232', '67', 'Рапламааский уезд', 'Рапламааский уезд');
INSERT INTO zones VALUES ('233', '67', 'Сааремааский уезд', 'Сааремааский уезд');
INSERT INTO zones VALUES ('234', '67', 'Тартумааский уезд', 'Тартумааский уезд');
INSERT INTO zones VALUES ('235', '67', 'Валгамааский уезд', 'Валгамааский уезд');
INSERT INTO zones VALUES ('236', '67', 'Вильяндимааский уезд', 'Вильяндимааский уезд');
INSERT INTO zones VALUES ('237', '67', 'Вырумааский уезд', 'Вырумааский уезд');
INSERT INTO zones VALUES ('238', '20', 'Витебская область', 'Витебская область');
INSERT INTO zones VALUES ('239', '20', 'Могилевская область', 'Могилевская область');
INSERT INTO zones VALUES ('240', '20', 'Минская область', 'Минская область');
INSERT INTO zones VALUES ('241', '20', 'Гродненская область', 'Гродненская область');
INSERT INTO zones VALUES ('242', '20', 'Гомельская область', 'Гомельская область');
INSERT INTO zones VALUES ('243', '20', 'Брестская область', 'Брестская область');
INSERT INTO zones VALUES ('244', '11', 'Область Арагацотн', 'Область Арагацотн');
INSERT INTO zones VALUES ('245', '11', 'Араратская область', 'Араратская область');
INSERT INTO zones VALUES ('246', '11', 'Армавирская область', 'Армавирская область');
INSERT INTO zones VALUES ('247', '11', 'Гегаркуникская область', 'Гегаркуникская область');
INSERT INTO zones VALUES ('248', '11', 'Ереван', 'Ереван');
INSERT INTO zones VALUES ('249', '11', 'Лорийская область', 'Лорийская область');
INSERT INTO zones VALUES ('250', '11', 'Котайкская область', 'Котайкская область');
INSERT INTO zones VALUES ('251', '11', 'Ширакская область', 'Ширакская область');
INSERT INTO zones VALUES ('252', '11', 'Сюникская область', 'Сюникская область');
INSERT INTO zones VALUES ('253', '11', 'Область Вайоц Дзор', 'Область Вайоц Дзор');
INSERT INTO zones VALUES ('254', '11', 'Тавушская область', 'Тавушская область');
INSERT INTO zones VALUES ('255', '80', 'Гурия', 'Гурия');
INSERT INTO zones VALUES ('256', '80', 'Имерети', 'Имерети');
INSERT INTO zones VALUES ('257', '80', 'Кахети', 'Кахети');
INSERT INTO zones VALUES ('258', '80', 'Квемо-Картли', 'Квемо-Картли');
INSERT INTO zones VALUES ('259', '80', 'Мцхета-Тианети', 'Мцхета-Тианети');
INSERT INTO zones VALUES ('260', '80', 'Рача-Лечхуми - Квемо Сванети', 'Рача-Лечхуми - Квемо Сванети');
INSERT INTO zones VALUES ('261', '80', 'Самегрело - Земо-Сванети', 'Самегрело - Земо-Сванети');
INSERT INTO zones VALUES ('262', '80', 'Самцхе-Джавахети', 'Самцхе-Джавахети');
INSERT INTO zones VALUES ('263', '80', 'Тбилиси', 'Тбилиси');
INSERT INTO zones VALUES ('264', '80', 'Шида - Картли', 'Шида - Картли');
INSERT INTO zones VALUES ('265', '80', 'Аджарская автономная республика', 'Аджарская автономная республика');
INSERT INTO zones VALUES ('266', '80', 'Абхазская автономная республика', 'Абхазская автономная республика');
INSERT INTO zones VALUES ('267', '80', 'Республика Южная Осетия', 'Республика Южная Осетия');
INSERT INTO zones VALUES ('268', '140', 'Балти', 'Балти');
INSERT INTO zones VALUES ('269', '140', 'Единет', 'Единет');
INSERT INTO zones VALUES ('270', '140', 'Кагул', 'Кагул');
INSERT INTO zones VALUES ('271', '140', 'Кишенёв', 'Кишенёв');
INSERT INTO zones VALUES ('272', '140', 'Лапушна', 'Лапушна');
INSERT INTO zones VALUES ('273', '140', 'Оргей', 'Оргей');
INSERT INTO zones VALUES ('274', '140', 'Сорока', 'Сорока');
INSERT INTO zones VALUES ('275', '140', 'Тараклия', 'Тараклия');
INSERT INTO zones VALUES ('276', '140', 'Тигина', 'Тигина');
INSERT INTO zones VALUES ('277', '140', 'Унгены', 'Унгены');
INSERT INTO zones VALUES ('278', '123', 'Алитусский уезд', 'Алитусский уезд');
INSERT INTO zones VALUES ('279', '123', 'Каунасский уезд', 'Каунасский уезд');
INSERT INTO zones VALUES ('280', '123', 'Kлайпедский уезд', 'Kлайпедский уезд');
INSERT INTO zones VALUES ('281', '123', 'Maриямпольский уезд', 'Maриямпольский уезд');
INSERT INTO zones VALUES ('282', '123', 'Панявежский уезд', 'Панявежский уезд');
INSERT INTO zones VALUES ('283', '123', 'Шяуляйский уезд', 'Шяуляйский уезд');
INSERT INTO zones VALUES ('284', '123', 'Таурагский уезд', 'Таурагский уезд');
INSERT INTO zones VALUES ('285', '123', 'Tяльшяйский уезд', 'Tяльшяйский уезд');
INSERT INTO zones VALUES ('286', '123', 'Утянский уезд', 'Утянский уезд');
INSERT INTO zones VALUES ('287', '123', 'Вильнюсский уезд', 'Вильнюсский уезд');
INSERT INTO zones VALUES ('288', '117', 'Аизкраукленский', 'Аизкраукленский');
INSERT INTO zones VALUES ('289', '117', 'Алуксненский', 'Алуксненский');
INSERT INTO zones VALUES ('290', '117', 'Балвский', 'Балвский');
INSERT INTO zones VALUES ('291', '117', 'Бауский', 'Бауский');
INSERT INTO zones VALUES ('292', '117', 'Валкский', 'Валкский');
INSERT INTO zones VALUES ('293', '117', 'Валмиерский', 'Валмиерский');
INSERT INTO zones VALUES ('294', '117', 'Вентспилсский', 'Вентспилсский');
INSERT INTO zones VALUES ('295', '117', 'Гулбенский', 'Гулбенский');
INSERT INTO zones VALUES ('296', '117', 'Давгавпилский', 'Давгавпилский');
INSERT INTO zones VALUES ('297', '117', 'Добелский', 'Добелский');
INSERT INTO zones VALUES ('298', '117', 'Екабпилский', 'Екабпилский');
INSERT INTO zones VALUES ('299', '117', 'Елгавский', 'Елгавский');
INSERT INTO zones VALUES ('300', '117', 'Краславский', 'Краславский');
INSERT INTO zones VALUES ('301', '117', 'Кулдигский', 'Кулдигский');
INSERT INTO zones VALUES ('302', '117', 'Лепайский', 'Лепайский');
INSERT INTO zones VALUES ('303', '117', 'Лимбажский', 'Лимбажский');
INSERT INTO zones VALUES ('304', '117', 'Ледзенский', 'Ледзенский');
INSERT INTO zones VALUES ('305', '117', 'Мадонский', 'Мадонский');
INSERT INTO zones VALUES ('306', '117', 'Огрский', 'Огрский');
INSERT INTO zones VALUES ('307', '117', 'Прейльский', 'Прейльский');
INSERT INTO zones VALUES ('308', '117', 'Резекненский', 'Резекненский');
INSERT INTO zones VALUES ('309', '117', 'Рижский', 'Рижский');
INSERT INTO zones VALUES ('310', '117', 'Салдуский', 'Салдуский');
INSERT INTO zones VALUES ('311', '117', 'Талсинский', 'Талсинский');
INSERT INTO zones VALUES ('312', '117', 'Тукумский', 'Тукумский');
INSERT INTO zones VALUES ('313', '117', 'Цесиский', 'Цесиский');
INSERT INTO zones VALUES ('314', '117', 'Вентспилс', 'Вентспилс');
INSERT INTO zones VALUES ('315', '117', 'Даугавпилс', 'Даугавпилс');
INSERT INTO zones VALUES ('316', '117', 'Елгава', 'Елгава');
INSERT INTO zones VALUES ('317', '117', 'Лиепая', 'Лиепая');
INSERT INTO zones VALUES ('318', '117', 'Резекне', 'Резекне');
INSERT INTO zones VALUES ('319', '117', 'Рига', 'Рига');
INSERT INTO zones VALUES ('320', '117', 'Юрмала', 'Юрмала');

# USA
INSERT INTO zones VALUES ('321','223','AL','Alabama');
INSERT INTO zones VALUES ('322','223','AK','Alaska');
INSERT INTO zones VALUES ('323','223','AS','American Samoa');
INSERT INTO zones VALUES ('324','223','AZ','Arizona');
INSERT INTO zones VALUES ('325','223','AR','Arkansas');
INSERT INTO zones VALUES ('326','223','AF','Armed Forces Africa');
INSERT INTO zones VALUES ('327','223','AA','Armed Forces Americas');
INSERT INTO zones VALUES ('328','223','AC','Armed Forces Canada');
INSERT INTO zones VALUES ('329','223','AE','Armed Forces Europe');
INSERT INTO zones VALUES ('330','223','AM','Armed Forces Middle East');
INSERT INTO zones VALUES ('331','223','AP','Armed Forces Pacific');
INSERT INTO zones VALUES ('332','223','CA','California');
INSERT INTO zones VALUES ('333','223','CO','Colorado');
INSERT INTO zones VALUES ('334','223','CT','Connecticut');
INSERT INTO zones VALUES ('335','223','DE','Delaware');
INSERT INTO zones VALUES ('336','223','DC','District of Columbia');
INSERT INTO zones VALUES ('337','223','FM','Federated States Of Micronesia');
INSERT INTO zones VALUES ('338','223','FL','Florida');
INSERT INTO zones VALUES ('339','223','GA','Georgia');
INSERT INTO zones VALUES ('340','223','GU','Guam');
INSERT INTO zones VALUES ('341','223','HI','Hawaii');
INSERT INTO zones VALUES ('342','223','ID','Idaho');
INSERT INTO zones VALUES ('343','223','IL','Illinois');
INSERT INTO zones VALUES ('344','223','IN','Indiana');
INSERT INTO zones VALUES ('345','223','IA','Iowa');
INSERT INTO zones VALUES ('346','223','KS','Kansas');
INSERT INTO zones VALUES ('347','223','KY','Kentucky');
INSERT INTO zones VALUES ('348','223','LA','Louisiana');
INSERT INTO zones VALUES ('349','223','ME','Maine');
INSERT INTO zones VALUES ('350','223','MH','Marshall Islands');
INSERT INTO zones VALUES ('351','223','MD','Maryland');
INSERT INTO zones VALUES ('352','223','MA','Massachusetts');
INSERT INTO zones VALUES ('353','223','MI','Michigan');
INSERT INTO zones VALUES ('354','223','MN','Minnesota');
INSERT INTO zones VALUES ('355','223','MS','Mississippi');
INSERT INTO zones VALUES ('356','223','MO','Missouri');
INSERT INTO zones VALUES ('357','223','MT','Montana');
INSERT INTO zones VALUES ('358','223','NE','Nebraska');
INSERT INTO zones VALUES ('359','223','NV','Nevada');
INSERT INTO zones VALUES ('360','223','NH','New Hampshire');
INSERT INTO zones VALUES ('361','223','NJ','New Jersey');
INSERT INTO zones VALUES ('362','223','NM','New Mexico');
INSERT INTO zones VALUES ('363','223','NY','New York');
INSERT INTO zones VALUES ('364','223','NC','North Carolina');
INSERT INTO zones VALUES ('365','223','ND','North Dakota');
INSERT INTO zones VALUES ('366','223','MP','Northern Mariana Islands');
INSERT INTO zones VALUES ('367','223','OH','Ohio');
INSERT INTO zones VALUES ('368','223','OK','Oklahoma');
INSERT INTO zones VALUES ('369','223','OR','Oregon');
INSERT INTO zones VALUES ('370','223','PW','Palau');
INSERT INTO zones VALUES ('371','223','PA','Pennsylvania');
INSERT INTO zones VALUES ('372','223','PR','Puerto Rico');
INSERT INTO zones VALUES ('373','223','RI','Rhode Island');
INSERT INTO zones VALUES ('374','223','SC','South Carolina');
INSERT INTO zones VALUES ('375','223','SD','South Dakota');
INSERT INTO zones VALUES ('376','223','TN','Tennessee');
INSERT INTO zones VALUES ('377','223','TX','Texas');
INSERT INTO zones VALUES ('378','223','UT','Utah');
INSERT INTO zones VALUES ('379','223','VT','Vermont');
INSERT INTO zones VALUES ('380','223','VI','Virgin Islands');
INSERT INTO zones VALUES ('381','223','VA','Virginia');
INSERT INTO zones VALUES ('382','223','WA','Washington');
INSERT INTO zones VALUES ('383','223','WV','West Virginia');
INSERT INTO zones VALUES ('384','223','WI','Wisconsin');
INSERT INTO zones VALUES ('385','223','WY','Wyoming');

INSERT INTO zones VALUES ('386', '115', 'Бишкек', 'Бишкек');

#
# Dumping data for table `payment_moneybookers_countries`
#

INSERT INTO payment_moneybookers_countries VALUES (2, 'ALB');
INSERT INTO payment_moneybookers_countries VALUES (3, 'ALG');
INSERT INTO payment_moneybookers_countries VALUES (4, 'AME');
INSERT INTO payment_moneybookers_countries VALUES (5, 'AND');
INSERT INTO payment_moneybookers_countries VALUES (6, 'AGL');
INSERT INTO payment_moneybookers_countries VALUES (7, 'ANG');
INSERT INTO payment_moneybookers_countries VALUES (9, 'ANT');
INSERT INTO payment_moneybookers_countries VALUES (10, 'ARG');
INSERT INTO payment_moneybookers_countries VALUES (11, 'ARM');
INSERT INTO payment_moneybookers_countries VALUES (12, 'ARU');
INSERT INTO payment_moneybookers_countries VALUES (13, 'AUS');
INSERT INTO payment_moneybookers_countries VALUES (14, 'AUT');
INSERT INTO payment_moneybookers_countries VALUES (15, 'AZE');
INSERT INTO payment_moneybookers_countries VALUES (16, 'BMS');
INSERT INTO payment_moneybookers_countries VALUES (17, 'BAH');
INSERT INTO payment_moneybookers_countries VALUES (18, 'BAN');
INSERT INTO payment_moneybookers_countries VALUES (19, 'BAR');
INSERT INTO payment_moneybookers_countries VALUES (20, 'BLR');
INSERT INTO payment_moneybookers_countries VALUES (21, 'BGM');
INSERT INTO payment_moneybookers_countries VALUES (22, 'BEL');
INSERT INTO payment_moneybookers_countries VALUES (23, 'BEN');
INSERT INTO payment_moneybookers_countries VALUES (24, 'BER');
INSERT INTO payment_moneybookers_countries VALUES (26, 'BOL');
INSERT INTO payment_moneybookers_countries VALUES (27, 'BOS');
INSERT INTO payment_moneybookers_countries VALUES (28, 'BOT');
INSERT INTO payment_moneybookers_countries VALUES (30, 'BRA');
INSERT INTO payment_moneybookers_countries VALUES (32, 'BRU');
INSERT INTO payment_moneybookers_countries VALUES (33, 'BUL');
INSERT INTO payment_moneybookers_countries VALUES (34, 'BKF');
INSERT INTO payment_moneybookers_countries VALUES (35, 'BUR');
INSERT INTO payment_moneybookers_countries VALUES (36, 'CAM');
INSERT INTO payment_moneybookers_countries VALUES (37, 'CMR');
INSERT INTO payment_moneybookers_countries VALUES (38, 'CAN');
INSERT INTO payment_moneybookers_countries VALUES (39, 'CAP');
INSERT INTO payment_moneybookers_countries VALUES (40, 'CAY');
INSERT INTO payment_moneybookers_countries VALUES (41, 'CEN');
INSERT INTO payment_moneybookers_countries VALUES (42, 'CHA');
INSERT INTO payment_moneybookers_countries VALUES (43, 'CHL');
INSERT INTO payment_moneybookers_countries VALUES (44, 'CHN');
INSERT INTO payment_moneybookers_countries VALUES (47, 'COL');
INSERT INTO payment_moneybookers_countries VALUES (49, 'CON');
INSERT INTO payment_moneybookers_countries VALUES (51, 'COS');
INSERT INTO payment_moneybookers_countries VALUES (52, 'COT');
INSERT INTO payment_moneybookers_countries VALUES (53, 'CRO');
INSERT INTO payment_moneybookers_countries VALUES (54, 'CUB');
INSERT INTO payment_moneybookers_countries VALUES (55, 'CYP');
INSERT INTO payment_moneybookers_countries VALUES (56, 'CZE');
INSERT INTO payment_moneybookers_countries VALUES (57, 'DEN');
INSERT INTO payment_moneybookers_countries VALUES (58, 'DJI');
INSERT INTO payment_moneybookers_countries VALUES (59, 'DOM');
INSERT INTO payment_moneybookers_countries VALUES (60, 'DRP');
INSERT INTO payment_moneybookers_countries VALUES (62, 'ECU');
INSERT INTO payment_moneybookers_countries VALUES (64, 'EL_');
INSERT INTO payment_moneybookers_countries VALUES (65, 'EQU');
INSERT INTO payment_moneybookers_countries VALUES (66, 'ERI');
INSERT INTO payment_moneybookers_countries VALUES (67, 'EST');
INSERT INTO payment_moneybookers_countries VALUES (68, 'ETH');
INSERT INTO payment_moneybookers_countries VALUES (70, 'FAR');
INSERT INTO payment_moneybookers_countries VALUES (71, 'FIJ');
INSERT INTO payment_moneybookers_countries VALUES (72, 'FIN');
INSERT INTO payment_moneybookers_countries VALUES (73, 'FRA');
INSERT INTO payment_moneybookers_countries VALUES (75, 'FRE');
INSERT INTO payment_moneybookers_countries VALUES (78, 'GAB');
INSERT INTO payment_moneybookers_countries VALUES (79, 'GAM');
INSERT INTO payment_moneybookers_countries VALUES (80, 'GEO');
INSERT INTO payment_moneybookers_countries VALUES (81, 'GER');
INSERT INTO payment_moneybookers_countries VALUES (82, 'GHA');
INSERT INTO payment_moneybookers_countries VALUES (83, 'GIB');
INSERT INTO payment_moneybookers_countries VALUES (84, 'GRC');
INSERT INTO payment_moneybookers_countries VALUES (85, 'GRL');
INSERT INTO payment_moneybookers_countries VALUES (87, 'GDL');
INSERT INTO payment_moneybookers_countries VALUES (88, 'GUM');
INSERT INTO payment_moneybookers_countries VALUES (89, 'GUA');
INSERT INTO payment_moneybookers_countries VALUES (90, 'GUI');
INSERT INTO payment_moneybookers_countries VALUES (91, 'GBS');
INSERT INTO payment_moneybookers_countries VALUES (92, 'GUY');
INSERT INTO payment_moneybookers_countries VALUES (93, 'HAI');
INSERT INTO payment_moneybookers_countries VALUES (95, 'HON');
INSERT INTO payment_moneybookers_countries VALUES (96, 'HKG');
INSERT INTO payment_moneybookers_countries VALUES (97, 'HUN');
INSERT INTO payment_moneybookers_countries VALUES (98, 'ICE');
INSERT INTO payment_moneybookers_countries VALUES (99, 'IND');
INSERT INTO payment_moneybookers_countries VALUES (101, 'IRN');
INSERT INTO payment_moneybookers_countries VALUES (102, 'IRA');
INSERT INTO payment_moneybookers_countries VALUES (103, 'IRE');
INSERT INTO payment_moneybookers_countries VALUES (104, 'ISR');
INSERT INTO payment_moneybookers_countries VALUES (105, 'ITA');
INSERT INTO payment_moneybookers_countries VALUES (106, 'JAM');
INSERT INTO payment_moneybookers_countries VALUES (107, 'JAP');
INSERT INTO payment_moneybookers_countries VALUES (108, 'JOR');
INSERT INTO payment_moneybookers_countries VALUES (109, 'KAZ');
INSERT INTO payment_moneybookers_countries VALUES (110, 'KEN');
INSERT INTO payment_moneybookers_countries VALUES (112, 'SKO');
INSERT INTO payment_moneybookers_countries VALUES (113, 'KOR');
INSERT INTO payment_moneybookers_countries VALUES (114, 'KUW');
INSERT INTO payment_moneybookers_countries VALUES (115, 'KYR');
INSERT INTO payment_moneybookers_countries VALUES (116, 'LAO');
INSERT INTO payment_moneybookers_countries VALUES (117, 'LAT');
INSERT INTO payment_moneybookers_countries VALUES (141, 'MCO');
INSERT INTO payment_moneybookers_countries VALUES (119, 'LES');
INSERT INTO payment_moneybookers_countries VALUES (120, 'LIB');
INSERT INTO payment_moneybookers_countries VALUES (121, 'LBY');
INSERT INTO payment_moneybookers_countries VALUES (122, 'LIE');
INSERT INTO payment_moneybookers_countries VALUES (123, 'LIT');
INSERT INTO payment_moneybookers_countries VALUES (124, 'LUX');
INSERT INTO payment_moneybookers_countries VALUES (125, 'MAC');
INSERT INTO payment_moneybookers_countries VALUES (126, 'F.Y');
INSERT INTO payment_moneybookers_countries VALUES (127, 'MAD');
INSERT INTO payment_moneybookers_countries VALUES (128, 'MLW');
INSERT INTO payment_moneybookers_countries VALUES (129, 'MLS');
INSERT INTO payment_moneybookers_countries VALUES (130, 'MAL');
INSERT INTO payment_moneybookers_countries VALUES (131, 'MLI');
INSERT INTO payment_moneybookers_countries VALUES (132, 'MLT');
INSERT INTO payment_moneybookers_countries VALUES (134, 'MAR');
INSERT INTO payment_moneybookers_countries VALUES (135, 'MRT');
INSERT INTO payment_moneybookers_countries VALUES (136, 'MAU');
INSERT INTO payment_moneybookers_countries VALUES (138, 'MEX');
INSERT INTO payment_moneybookers_countries VALUES (140, 'MOL');
INSERT INTO payment_moneybookers_countries VALUES (142, 'MON');
INSERT INTO payment_moneybookers_countries VALUES (143, 'MTT');
INSERT INTO payment_moneybookers_countries VALUES (144, 'MOR');
INSERT INTO payment_moneybookers_countries VALUES (145, 'MOZ');
INSERT INTO payment_moneybookers_countries VALUES (76, 'PYF');
INSERT INTO payment_moneybookers_countries VALUES (147, 'NAM');
INSERT INTO payment_moneybookers_countries VALUES (149, 'NEP');
INSERT INTO payment_moneybookers_countries VALUES (150, 'NED');
INSERT INTO payment_moneybookers_countries VALUES (151, 'NET');
INSERT INTO payment_moneybookers_countries VALUES (152, 'CDN');
INSERT INTO payment_moneybookers_countries VALUES (153, 'NEW');
INSERT INTO payment_moneybookers_countries VALUES (154, 'NIC');
INSERT INTO payment_moneybookers_countries VALUES (155, 'NIG');
INSERT INTO payment_moneybookers_countries VALUES (69, 'FLK');
INSERT INTO payment_moneybookers_countries VALUES (160, 'NWY');
INSERT INTO payment_moneybookers_countries VALUES (161, 'OMA');
INSERT INTO payment_moneybookers_countries VALUES (162, 'PAK');
INSERT INTO payment_moneybookers_countries VALUES (164, 'PAN');
INSERT INTO payment_moneybookers_countries VALUES (165, 'PAP');
INSERT INTO payment_moneybookers_countries VALUES (166, 'PAR');
INSERT INTO payment_moneybookers_countries VALUES (167, 'PER');
INSERT INTO payment_moneybookers_countries VALUES (168, 'PHI');
INSERT INTO payment_moneybookers_countries VALUES (170, 'POL');
INSERT INTO payment_moneybookers_countries VALUES (171, 'POR');
INSERT INTO payment_moneybookers_countries VALUES (172, 'PUE');
INSERT INTO payment_moneybookers_countries VALUES (173, 'QAT');
INSERT INTO payment_moneybookers_countries VALUES (175, 'ROM');
INSERT INTO payment_moneybookers_countries VALUES (176, 'RUS');
INSERT INTO payment_moneybookers_countries VALUES (177, 'RWA');
INSERT INTO payment_moneybookers_countries VALUES (178, 'SKN');
INSERT INTO payment_moneybookers_countries VALUES (179, 'SLU');
INSERT INTO payment_moneybookers_countries VALUES (180, 'ST.');
INSERT INTO payment_moneybookers_countries VALUES (181, 'WES');
INSERT INTO payment_moneybookers_countries VALUES (182, 'SAN');
INSERT INTO payment_moneybookers_countries VALUES (183, 'SAO');
INSERT INTO payment_moneybookers_countries VALUES (184, 'SAU');
INSERT INTO payment_moneybookers_countries VALUES (185, 'SEN');
INSERT INTO payment_moneybookers_countries VALUES (186, 'SEY');
INSERT INTO payment_moneybookers_countries VALUES (187, 'SIE');
INSERT INTO payment_moneybookers_countries VALUES (188, 'SIN');
INSERT INTO payment_moneybookers_countries VALUES (189, 'SLO');
INSERT INTO payment_moneybookers_countries VALUES (190, 'SLV');
INSERT INTO payment_moneybookers_countries VALUES (191, 'SOL');
INSERT INTO payment_moneybookers_countries VALUES (192, 'SOM');
INSERT INTO payment_moneybookers_countries VALUES (193, 'SOU');
INSERT INTO payment_moneybookers_countries VALUES (195, 'SPA');
INSERT INTO payment_moneybookers_countries VALUES (196, 'SRI');
INSERT INTO payment_moneybookers_countries VALUES (199, 'SUD');
INSERT INTO payment_moneybookers_countries VALUES (200, 'SUR');
INSERT INTO payment_moneybookers_countries VALUES (202, 'SWA');
INSERT INTO payment_moneybookers_countries VALUES (203, 'SWE');
INSERT INTO payment_moneybookers_countries VALUES (204, 'SWI');
INSERT INTO payment_moneybookers_countries VALUES (205, 'SYR');
INSERT INTO payment_moneybookers_countries VALUES (206, 'TWN');
INSERT INTO payment_moneybookers_countries VALUES (207, 'TAJ');
INSERT INTO payment_moneybookers_countries VALUES (208, 'TAN');
INSERT INTO payment_moneybookers_countries VALUES (209, 'THA');
INSERT INTO payment_moneybookers_countries VALUES (210, 'TOG');
INSERT INTO payment_moneybookers_countries VALUES (212, 'TON');
INSERT INTO payment_moneybookers_countries VALUES (213, 'TRI');
INSERT INTO payment_moneybookers_countries VALUES (214, 'TUN');
INSERT INTO payment_moneybookers_countries VALUES (215, 'TUR');
INSERT INTO payment_moneybookers_countries VALUES (216, 'TKM');
INSERT INTO payment_moneybookers_countries VALUES (217, 'TCI');
INSERT INTO payment_moneybookers_countries VALUES (219, 'UGA');
INSERT INTO payment_moneybookers_countries VALUES (231, 'BRI');
INSERT INTO payment_moneybookers_countries VALUES (221, 'UAE');
INSERT INTO payment_moneybookers_countries VALUES (222, 'GBR');
INSERT INTO payment_moneybookers_countries VALUES (223, 'UNI');
INSERT INTO payment_moneybookers_countries VALUES (225, 'URU');
INSERT INTO payment_moneybookers_countries VALUES (226, 'UZB');
INSERT INTO payment_moneybookers_countries VALUES (227, 'VAN');
INSERT INTO payment_moneybookers_countries VALUES (229, 'VEN');
INSERT INTO payment_moneybookers_countries VALUES (230, 'VIE');
INSERT INTO payment_moneybookers_countries VALUES (232, 'US_');
INSERT INTO payment_moneybookers_countries VALUES (235, 'YEM');
INSERT INTO payment_moneybookers_countries VALUES (236, 'YUG');
INSERT INTO payment_moneybookers_countries VALUES (238, 'ZAM');
INSERT INTO payment_moneybookers_countries VALUES (239, 'ZIM');

#
# Dumping data for table `payment_moneybookers_currencies`
#

INSERT INTO payment_moneybookers_currencies VALUES ('AUD', 'Australian Dollar');
INSERT INTO payment_moneybookers_currencies VALUES ('BGN', 'Bulgarian Lev');
INSERT INTO payment_moneybookers_currencies VALUES ('CAD', 'Canadian Dollar');
INSERT INTO payment_moneybookers_currencies VALUES ('CHF', 'Swiss Franc');
INSERT INTO payment_moneybookers_currencies VALUES ('CZK', 'Czech Koruna');
INSERT INTO payment_moneybookers_currencies VALUES ('DKK', 'Danish Krone');
INSERT INTO payment_moneybookers_currencies VALUES ('EEK', 'Estonian Koruna');
INSERT INTO payment_moneybookers_currencies VALUES ('EUR', 'Euro');
INSERT INTO payment_moneybookers_currencies VALUES ('GBP', 'Pound Sterling');
INSERT INTO payment_moneybookers_currencies VALUES ('HKD', 'Hong Kong Dollar');
INSERT INTO payment_moneybookers_currencies VALUES ('HUF', 'Forint');
INSERT INTO payment_moneybookers_currencies VALUES ('ILS', 'Shekel');
INSERT INTO payment_moneybookers_currencies VALUES ('ISK', 'Iceland Krona');
INSERT INTO payment_moneybookers_currencies VALUES ('JPY', 'Yen');
INSERT INTO payment_moneybookers_currencies VALUES ('KRW', 'South-Korean Won');
INSERT INTO payment_moneybookers_currencies VALUES ('LVL', 'Latvian Lat');
INSERT INTO payment_moneybookers_currencies VALUES ('MYR', 'Malaysian Ringgit');
INSERT INTO payment_moneybookers_currencies VALUES ('NOK', 'Norwegian Krone');
INSERT INTO payment_moneybookers_currencies VALUES ('NZD', 'New Zealand Dollar');
INSERT INTO payment_moneybookers_currencies VALUES ('PLN', 'Zloty');
INSERT INTO payment_moneybookers_currencies VALUES ('SEK', 'Swedish Krona');
INSERT INTO payment_moneybookers_currencies VALUES ('SGD', 'Singapore Dollar');
INSERT INTO payment_moneybookers_currencies VALUES ('SKK', 'Slovak Koruna');
INSERT INTO payment_moneybookers_currencies VALUES ('THB', 'Baht');
INSERT INTO payment_moneybookers_currencies VALUES ('TWD', 'New Taiwan Dollar');
INSERT INTO payment_moneybookers_currencies VALUES ('USD', 'US Dollar');
INSERT INTO payment_moneybookers_currencies VALUES ('ZAR', 'South-African Rand');

INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_min_order, customers_status_max_order, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax, customers_status_add_tax_ot, customers_status_payment_unallowed, customers_status_shipping_unallowed, customers_status_discount_attributes, customers_fsk18, customers_fsk18_display, customers_status_write_reviews, customers_status_read_reviews, customers_status_accumulated_limit) VALUES (0, 1, 'Админ', 1, NULL, NULL, 'admin_status.gif', 0.00, '1', 0.00, '1', 1, 1, 0, '', '', 0, 1, 1, 1, 1, 0.00);

INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_min_order, customers_status_max_order, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax, customers_status_add_tax_ot, customers_status_payment_unallowed, customers_status_shipping_unallowed, customers_status_discount_attributes, customers_fsk18, customers_fsk18_display, customers_status_write_reviews, customers_status_read_reviews, customers_status_accumulated_limit) VALUES (1, 1, 'Посетитель', 1, NULL, NULL, 'guest_status.gif', 0.00, '0', 0.00, '0', 1, 1, 0, '', '', 0, 1, 1, 1, 1, 0.00);

INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_min_order, customers_status_max_order, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax, customers_status_add_tax_ot, customers_status_payment_unallowed, customers_status_shipping_unallowed, customers_status_discount_attributes, customers_fsk18, customers_fsk18_display, customers_status_write_reviews, customers_status_read_reviews, customers_status_accumulated_limit) VALUES (2, 1, 'Покупатель', 1, NULL, NULL, 'customer_status.gif', 0.00, '0', 0.00, '1', 1, 1, 0, '', '', 0, 1, 1, 1, 1, 0.00);

INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_min_order, customers_status_max_order, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax, customers_status_add_tax_ot, customers_status_payment_unallowed, customers_status_shipping_unallowed, customers_status_discount_attributes, customers_fsk18, customers_fsk18_display, customers_status_write_reviews, customers_status_read_reviews, customers_status_accumulated_limit) VALUES (3, 1, 'Оптовый покупатель', 1, NULL, NULL, 'merchant_status.gif', 0.00, '0', 0.00, '1', 1, 0, 0, '', '', 0, 1, 1, 1, 1, 0.00);

drop table if exists spsr_zones;
create table spsr_zones (
  id int(11) not null auto_increment,
  zone_id int(11) default '0' not null ,
  spsr_zone_id int(11) default '0' not null,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

insert into spsr_zones values ('1', '22', '53');
insert into spsr_zones values ('2', '23', '55');
insert into spsr_zones values ('3', '24', '56');
insert into spsr_zones values ('4', '25', '54');
insert into spsr_zones values ('5', '26', '57');
insert into spsr_zones values ('6', '27', '101');
insert into spsr_zones values ('7', '28', '19');
insert into spsr_zones values ('8', '29', '58');
insert into spsr_zones values ('9', '30', '24');
insert into spsr_zones values ('10', '31', '59');
insert into spsr_zones values ('11', '32', '60');
insert into spsr_zones values ('12', '33', '61');
insert into spsr_zones values ('13', '34', '62');
insert into spsr_zones values ('14', '35', '63');
insert into spsr_zones values ('15', '36', '64');
insert into spsr_zones values ('16', '37', '65');
insert into spsr_zones values ('17', '38', '66');
insert into spsr_zones values ('18', '39', '84');
insert into spsr_zones values ('19', '40', '67');
insert into spsr_zones values ('20', '41', '92');
insert into spsr_zones values ('21', '42', '94');
insert into spsr_zones values ('22', '43', '3');
insert into spsr_zones values ('23', '44', '30');
insert into spsr_zones values ('24', '45', '31');
insert into spsr_zones values ('25', '46', '51');
insert into spsr_zones values ('26', '47', '75');
insert into spsr_zones values ('27', '48', '89');
insert into spsr_zones values ('28', '49', '4');
insert into spsr_zones values ('29', '50', '6');
insert into spsr_zones values ('30', '51', '7');
insert into spsr_zones values ('31', '52', '8');
insert into spsr_zones values ('32', '53', '10');
insert into spsr_zones values ('33', '54', '11');
insert into spsr_zones values ('34', '55', '12');
insert into spsr_zones values ('35', '56', '13');
insert into spsr_zones values ('36', '57', '14');
insert into spsr_zones values ('37', '58', '17');
insert into spsr_zones values ('38', '59', '18');
insert into spsr_zones values ('39', '60', '21');
insert into spsr_zones values ('40', '61', '22');
insert into spsr_zones values ('41', '62', '23');
insert into spsr_zones values ('42', '63', '25');
insert into spsr_zones values ('43', '64', '27');
insert into spsr_zones values ('44', '65', '29');
insert into spsr_zones values ('45', '66', '32');
insert into spsr_zones values ('46', '67', '33');
insert into spsr_zones values ('47', '68', '35');
insert into spsr_zones values ('48', '69', '36');
insert into spsr_zones values ('49', '70', '38');
insert into spsr_zones values ('50', '71', '40');
insert into spsr_zones values ('51', '72', '41');
insert into spsr_zones values ('52', '73', '43');
insert into spsr_zones values ('53', '74', '44');
insert into spsr_zones values ('54', '75', '45');
insert into spsr_zones values ('55', '76', '46');
insert into spsr_zones values ('56', '77', '47');
insert into spsr_zones values ('57', '78', '48');
insert into spsr_zones values ('58', '79', '49');
insert into spsr_zones values ('59', '80', '50');
insert into spsr_zones values ('60', '81', '52');
insert into spsr_zones values ('61', '82', '68');
insert into spsr_zones values ('62', '83', '69');
insert into spsr_zones values ('63', '84', '70');
insert into spsr_zones values ('64', '85', '71');
insert into spsr_zones values ('65', '86', '72');
insert into spsr_zones values ('66', '87', '73');
insert into spsr_zones values ('67', '88', '74');
insert into spsr_zones values ('68', '89', '78');
insert into spsr_zones values ('69', '90', '79');
insert into spsr_zones values ('70', '91', '80');
insert into spsr_zones values ('71', '92', '81');
insert into spsr_zones values ('72', '93', '83');
insert into spsr_zones values ('73', '94', '87');
insert into spsr_zones values ('74', '95', '91');
insert into spsr_zones values ('75', '97', '100');
insert into spsr_zones values ('76', '100', '16');
insert into spsr_zones values ('77', '104', '42');
insert into spsr_zones values ('78', '106', '88');
insert into spsr_zones values ('79', '107', '90');
insert into spsr_zones values ('80', '108', '95');
insert into spsr_zones values ('81', '109', '97');
insert into spsr_zones values ('82', '110', '99');

INSERT INTO configuration_group VALUES ('1610', 'CG_PRODUCTS_SPECIFICATIONS', 'Products Specifications', 'Products Specifications configuration options', '1610', '1');

##
## Table structure for table `specification_groups_to_categories`
##   This table links the specification_groups table
##   to the categories table. It allows multiple categories 
##   to have the same specification set
##
DROP TABLE IF EXISTS `specification_groups_to_categories`;
CREATE TABLE IF NOT EXISTS `specification_groups_to_categories` (
  `specification_group_id` int(11) NOT NULL DEFAULT '0',
  `categories_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`specification_group_id`,`categories_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;


##
## Table structure for table `specification_groups`
##   This table relates to the store Categories through
##   the specifications_to_categories table
##
DROP TABLE IF EXISTS `specification_groups`;
CREATE TABLE IF NOT EXISTS `specification_groups` (
  `specification_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `specification_group_name` varchar(255) NOT NULL,
  `show_comparison` set('True','False') NOT NULL DEFAULT 'True',
  `show_products` set('True','False') NOT NULL DEFAULT 'True',
  `show_filter` set('True','False') NOT NULL DEFAULT 'True',
  PRIMARY KEY (`specification_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

##
## Table structure for table `specifications`
##
##
DROP TABLE IF EXISTS `specifications`;
CREATE TABLE IF NOT EXISTS `specifications` (
  `specifications_id` int(11) NOT NULL AUTO_INCREMENT,
  `specification_group_id` int(11) NOT NULL DEFAULT '0',
  `specification_sort_order` int(11) NOT NULL DEFAULT '0',
  `show_comparison` set('True','False') NOT NULL DEFAULT 'True',
  `show_products` set('True','False') NOT NULL DEFAULT 'True',
  `show_filter` set('True','False') NOT NULL DEFAULT 'True',
  `products_column_name` varchar(255) NOT NULL,
  `column_justify` set('Left','Center','Right') NOT NULL DEFAULT 'Left',
  `filter_class` set('none','exact','multiple','range','reverse','start','partial','like') NOT NULL DEFAULT 'none',
  `filter_display` set('pulldown','multi','checkbox','radio','links','text','image','multiimage') NOT NULL DEFAULT 'pulldown',
  `filter_show_all` set('True','False') NOT NULL DEFAULT 'True',
  `enter_values` set('pulldown','multi','checkbox','radio','links','text','image','multiimage') NOT NULL DEFAULT 'text',
  PRIMARY KEY (`specifications_id`),
  KEY `specification_group_id` (`specification_group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;


##
## Table structure for table `specification_description`
##   This table defines the Specification(s) for a given Specification Group
##   There can be multiple Specifications for each Group
##   All products in a Group use the same specification set
##
DROP TABLE IF EXISTS `specification_description`;
CREATE TABLE IF NOT EXISTS `specification_description` (
  `specification_description_id` int(11) NOT NULL AUTO_INCREMENT,
  `specifications_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '1',
  `specification_name` varchar(255) NOT NULL DEFAULT '',
  `specification_description` varchar(255) NOT NULL,
  `specification_prefix` varchar(255) NOT NULL DEFAULT '',
  `specification_suffix` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`specification_description_id`,`language_id`),
  KEY `specifications_id` (`specifications_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;


##
## Table structure for table `specification_filters`
##   This table sets up filters that can be used to search for products
##
DROP TABLE IF EXISTS `specification_filters`;
CREATE TABLE IF NOT EXISTS `specification_filters` (
  `specification_filters_id` int(11) NOT NULL AUTO_INCREMENT,
  `specifications_id` int(11) NOT NULL DEFAULT '0',
  `filter_sort_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`specification_filters_id`),
  KEY `specifications_id` (`specifications_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;


##
## Table structure for table `specification_filters_description`
##   This table sets up filters that can be used to search for products
##
DROP TABLE IF EXISTS `specification_filters_description`;
CREATE TABLE IF NOT EXISTS `specification_filters_description` (
  `specification_filters_description_id` int(11) NOT NULL AUTO_INCREMENT,
  `specification_filters_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '1',
  `filter` varchar(255) NOT NULL,
  PRIMARY KEY (`specification_filters_description_id`),
  KEY `language_id` (`language_id`),
  KEY `specification_filters_id` (`specification_filters_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;


##
## Table structure for table `specification_values`
##   Sets up the values that can be used in product specifications
##
DROP TABLE IF EXISTS `specification_values`;
CREATE TABLE IF NOT EXISTS `specification_values` (
  `specification_values_id` int(11) NOT NULL AUTO_INCREMENT,
  `specifications_id` int(11) NOT NULL DEFAULT '0',
  `value_sort_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`specification_values_id`),
  KEY `specifications_id` (`specifications_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;


##
## Table structure for table `specification_values_description`
##   Sets up the values that can be used in product specifications
##
DROP TABLE IF EXISTS `specification_values_description`;
CREATE TABLE IF NOT EXISTS `specification_values_description` (
  `specification_values_description_id` int(11) NOT NULL AUTO_INCREMENT,
  `specification_values_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '1',
  `specification_value` varchar(255) NOT NULL,
  PRIMARY KEY (`specification_values_description_id`),
  KEY `specification_values_id` (`specification_values_id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;


##
## Table structure for table `products_specifications`
##   This table contains the specification data for each Product
##
DROP TABLE IF EXISTS `products_specifications`;
CREATE TABLE IF NOT EXISTS `products_specifications` (
  `products_specification_id` int(11) NOT NULL AUTO_INCREMENT,
  `products_id` int(11) NOT NULL DEFAULT '0',
  `specifications_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '1',
  `specification` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`products_specification_id`),
  KEY `products_id` (`products_id`,`specifications_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci;

## 
## Add the configuration options to table `configuration` 
## 
INSERT INTO `configuration` (`configuration_key`, `configuration_value`, `configuration_group_id`, `sort_order`, `last_modified`, `date_added`, `use_function`, `set_function`) VALUES
('SPECIFICATIONS_PRODUCTS_HEAD', 'Subhead', 1610, 1, '2009-08-25 10:03:37', '2009-06-18 12:07:30', NULL, 'vam_cfg_select_option(array(''Subhead''), '),
('SPECIFICATIONS_MINIMUM_PRODUCTS', '1', 1610, 5, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, NULL),
('SPECIFICATIONS_SHOW_NAME_PRODUCTS', 'False', 1610, 10, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, 'vam_cfg_select_option(array(''True'', ''False''), '),
('SPECIFICATIONS_SHOW_TITLE_PRODUCTS', 'True', 1610, 15, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, 'vam_cfg_select_option(array(''True'', ''False''), '),
('SPECIFICATIONS_BOX_FRAME_STYLE', 'Plain', 1610, 20, '2009-08-13 21:28:59', '2009-06-18 12:07:30', NULL, 'vam_cfg_select_option(array(''Stock'', ''Simple'', ''Plain'',''Tabs''), '),
('SPECIFICATIONS_REVIEWS_TAB', 'True', 1610, 21, '2009-06-18 12:07:30', '2009-09-09 12:07:30', NULL, 'vam_cfg_select_option(array(''True'', ''False''), '),
('SPECIFICATIONS_MAX_REVIEWS', '3', 1610, 22, '2009-09-09 12:07:30', '2009-06-18 12:07:30', NULL, NULL),
('SPECIFICATIONS_QUESTION_TAB', 'True', 1610, 23, '2009-06-18 12:07:30', '2009-09-09 12:07:30', NULL, 'vam_cfg_select_option(array(''True'', ''False''), '),

('SPECIFICATIONS_COMPARISON_HEAD', 'Subhead', 1610, 24, '2009-08-25 10:03:37', '2009-06-18 12:07:30', NULL, 'vam_cfg_select_option(array(''Subhead''), '),
('SPECIFICATIONS_MINIMUM_COMPARISON', '2', 1610, 25, '2009-07-19 19:52:33', '2009-06-18 12:07:30', NULL, NULL),
('SPECIFICATIONS_COMP_LINK', 'True', 1610, 30, '0000-00-00 00:00:00', '2009-06-26 12:07:30', NULL, 'vam_cfg_select_option(array(''True'', ''False''), '),
('SPECIFICATIONS_COMP_TABLE_ROW', 'both', 1610, 35, '2009-06-26 18:24:00', '2009-06-26 12:07:30', NULL, 'vam_cfg_select_option(array(''top'', ''bottom'', ''both'', ''none''), '),
('SPECIFICATIONS_BOX_COMPARISON', 'True', 1610, 40, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, 'vam_cfg_select_option(array(''True'', ''False''), '),
('SPECIFICATIONS_BOX_COMP_INDEX', 'False', 1610, 45, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, 'vam_cfg_select_option(array(''True'', ''False''), '),
('SPECIFICATIONS_COMP_SUFFIX', 'True', 1610, 50, '2009-07-18 22:11:04', '2009-06-18 12:07:30', NULL, 'vam_cfg_select_option(array(''True'', ''False''), '),
('SPECIFICATIONS_COMPARISON_STYLE', 'Simple', 1610, 52, '2009-07-18 22:11:04', '2009-06-18 12:07:30', NULL, 'vam_cfg_select_option(array(''Stock'', ''Simple'', ''Plain''), '),
('SPECIFICATIONS_COMBO_MFR', '0', 1610, 55, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, NULL),
('SPECIFICATIONS_COMBO_WEIGHT', '0', 1610, 60, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, NULL),
('SPECIFICATIONS_COMBO_PRICE', '0', 1610, 65, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, NULL),
('SPECIFICATIONS_COMBO_MODEL', '2', 1610, 70, '2009-06-18 15:31:23', '2009-06-18 12:07:30', NULL, NULL),
('SPECIFICATIONS_COMBO_IMAGE', '1', 1610, 75, '2009-06-18 15:31:10', '2009-06-18 12:07:30', NULL, NULL),
('SPECIFICATIONS_COMBO_NAME', '0', 1610, 80, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, NULL),
('SPECIFICATIONS_COMBO_BUY_NOW', '0', 1610, 85, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, NULL),

('SPECIFICATIONS_FILTERS_HEAD', 'Subhead', 1610, 89, '2009-08-25 10:03:37', '2009-06-18 12:07:30', NULL, 'vam_cfg_select_option(array(''Subhead''), '),
('SPECIFICATIONS_FILTERS_MODULE', 'True', 1610, 90, NULL, '2009-09-09 09:09:09', NULL, 'vam_cfg_select_option(array(''True'', ''False''), '),
('SPECIFICATIONS_FILTERS_BOX', 'True', 1610, 95, NULL, '2009-07-06 00:19:30', NULL, 'vam_cfg_select_option(array(''True'', ''False''), '),
('SPECIFICATIONS_FILTER_MINIMUM', '1', 1610, 100, '2009-06-18 12:07:30', '2009-06-18 12:07:30', NULL, NULL),
('SPECIFICATIONS_FILTER_SUBCATEGORIES', 'True', 1610, 105, '2009-08-12 15:16:55', '2009-06-18 12:07:30', NULL, 'vam_cfg_select_option(array(''True'', ''False''), '),
('SPECIFICATIONS_FILTER_SHOW_COUNT', 'True', 1610, 110, '2009-09-21 00:00:00', '2009-09-21 00:00:00', NULL, 'vam_cfg_select_option(array(''True'', ''False''), '),
('SPECIFICATIONS_FILTER_NO_RESULT', 'grey', 1610, 115, '2009-08-23 22:00:43', '2009-07-15 19:15:14', NULL, 'vam_cfg_select_option(array(''none'', ''grey'', ''normal''), '),
('SPECIFICATIONS_FILTER_BREADCRUMB', 'True', 1610, 120, '2009-07-15 19:15:07', '2009-07-15 19:15:14', NULL, 'vam_cfg_select_option(array(''True'', ''False''), '),
('SPECIFICATIONS_FILTER_IMAGE_WIDTH', '20', 1610, 125, '2009-07-15 18:46:21', '2009-07-15 18:46:30', NULL, NULL),
('SPECIFICATIONS_FILTER_IMAGE_HEIGHT', '20', 1610, 130, '2009-07-15 18:46:37', '2009-07-15 18:46:45', NULL, NULL),
('FILTERS_MAIN_PAGE', 'False', 1610, 135, NULL, '2009-07-06 00:19:30', NULL, 'vam_cfg_select_option(array(''True'', ''False''), ');
