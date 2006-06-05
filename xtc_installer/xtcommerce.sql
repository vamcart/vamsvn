# -----------------------------------------------------------------------------------------
#  $Id: xtcommerce.sql,v 1.62 2004/06/06 18:21:16 novalis Exp $
#
#  XT-Commerce - community made shopping
#  http://www.xt-commerce.com 
#
#  Copyright (c) 2003 XT-Commerce
#  -----------------------------------------------------------------------------------------
#  Third Party Contributions:
#  Customers status v3.x (c) 2002-2003 Elari elari@free.fr
#  Download area : www.unlockgsm.com/dload-osc/
#  CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
#  BMC 2003 for the CC CVV Module
#  qenta v1.0          Andreas Oberzier <xtc@netz-designer.de>
#  --------------------------------------------------------------
#  based on:
#  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
#  (c) 2002-2003 osCommerce (oscommerce.sql,v 1.83); www.oscommerce.com
#  (c) 2003  nextcommerce (nextcommerce.sql,v 1.76 2003/08/25); www.nextcommerce.org
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
  entry_company varchar(32),
  entry_firstname varchar(32) NOT NULL,
  entry_lastname varchar(32) NOT NULL,
  entry_street_address varchar(64) NOT NULL,
  entry_suburb varchar(32),
  entry_postcode varchar(10) NOT NULL,
  entry_city varchar(32) NOT NULL,
  entry_state varchar(32),
  entry_country_id int DEFAULT '0' NOT NULL,
  entry_zone_id int DEFAULT '0' NOT NULL,
  address_date_added datetime DEFAULT '0000-00-00 00:00:00',
  address_last_modified datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (address_book_id),
  KEY idx_address_book_customers_id (customers_id)
);

DROP TABLE IF EXISTS customers_memo;
CREATE TABLE customers_memo (
  memo_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  memo_date date NOT NULL default '0000-00-00',
  memo_title text NOT NULL,
  memo_text text NOT NULL,
  poster_id int(11) NOT NULL default '0',
  PRIMARY KEY  (memo_id)
);

DROP TABLE IF EXISTS products_xsell;
CREATE TABLE products_xsell (
  ID int(10) NOT NULL auto_increment,
  products_id int(10) unsigned NOT NULL default '1',
  products_xsell_grp_name_id int(10) unsigned NOT NULL default '1',
  xsell_id int(10) unsigned NOT NULL default '1',
  sort_order int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (ID)
);

DROP TABLE IF EXISTS products_xsell_grp_name;
CREATE TABLE products_xsell_grp_name (
  products_xsell_grp_name_id int(10) NOT NULL,
  xsell_sort_order int(10) NOT NULL default '0',
  language_id smallint(6) NOT NULL default '0',
  groupname varchar(255) NOT NULL default ''
);

DROP TABLE IF EXISTS campaigns;
CREATE TABLE campaigns (
  campaigns_id int(11) NOT NULL auto_increment,
  campaigns_name varchar(32) NOT NULL default '',
  campaigns_refID varchar(64) default NULL,
  campaigns_leads int(11) NOT NULL default '0',
  date_added datetime default NULL,
  last_modified datetime default NULL,
  PRIMARY KEY  (campaigns_id),
  KEY IDX_CAMPAIGNS_NAME (campaigns_name)
);

DROP TABLE IF EXISTS campaigns_ip;
CREATE TABLE  campaigns_ip (
 user_ip VARCHAR( 15 ) NOT NULL ,
 time DATETIME NOT NULL ,
 campaign VARCHAR( 32 ) NOT NULL
);

DROP TABLE IF EXISTS address_format;
CREATE TABLE address_format (
  address_format_id int NOT NULL auto_increment,
  address_format varchar(128) NOT NULL,
  address_summary varchar(48) NOT NULL,
  PRIMARY KEY (address_format_id)
);


DROP TABLE IF EXISTS database_version;
CREATE TABLE database_version (
  version varchar(32) NOT NULL
);

DROP TABLE IF EXISTS admin_access;
CREATE TABLE admin_access (
  customers_id varchar(32) NOT NULL default '0',

  configuration int(1) NOT NULL default '0',
  modules int(1) NOT NULL default '0',
  countries int(1) NOT NULL default '0',
  currencies int(1) NOT NULL default '0',
  zones int(1) NOT NULL default '0',
  geo_zones int(1) NOT NULL default '0',
  tax_classes int(1) NOT NULL default '0',
  tax_rates int(1) NOT NULL default '0',
  accounting int(1) NOT NULL default '0',
  backup int(1) NOT NULL default '0',
  cache int(1) NOT NULL default '0',
  server_info int(1) NOT NULL default '0',
  whos_online int(1) NOT NULL default '0',
  languages int(1) NOT NULL default '0',
  define_language int(1) NOT NULL default '0',
  orders_status int(1) NOT NULL default '0',
  shipping_status int(1) NOT NULL default '0',
  module_export int(1) NOT NULL default '0',

  customers int(1) NOT NULL default '0',
  create_account int(1) NOT NULL default '0',
  customers_status int(1) NOT NULL default '0',
  orders int(1) NOT NULL default '0',
  campaigns int(1) NOT NULL default '0',
  print_packingslip int(1) NOT NULL default '0',
  print_order int(1) NOT NULL default '0',
  popup_memo int(1) NOT NULL default '0',
  coupon_admin int(1) NOT NULL default '0',
  listcategories int(1) NOT NULL default '0',
  gv_queue int(1) NOT NULL default '0',
  gv_mail int(1) NOT NULL default '0',
  gv_sent int(1) NOT NULL default '0',
  validproducts int(1) NOT NULL default '0',
  validcategories int(1) NOT NULL default '0',
  mail int(1) NOT NULL default '0',

  categories int(1) NOT NULL default '0',
  new_attributes int(1) NOT NULL default '0',
  products_attributes int(1) NOT NULL default '0',
  manufacturers int(1) NOT NULL default '0',
  reviews int(1) NOT NULL default '0',
  specials int(1) NOT NULL default '0',

  stats_products_expected int(1) NOT NULL default '0',
  stats_products_viewed int(1) NOT NULL default '0',
  stats_products_purchased int(1) NOT NULL default '0',
  stats_customers int(1) NOT NULL default '0',
  stats_sales_report int(1) NOT NULL default '0',
  stats_campaigns int(1) NOT NULL default '0',

  banner_manager int(1) NOT NULL default '0',
  banner_statistics int(1) NOT NULL default '0',

  module_newsletter int(1) NOT NULL default '0',
  start int(1) NOT NULL default '0',

  content_manager int(1) NOT NULL default '0',
  content_preview int(1) NOT NULL default '0',
  credits int(1) NOT NULL default '0',
  blacklist int(1) NOT NULL default '0',

  orders_edit int(1) NOT NULL default '0',
  popup_image int(1) NOT NULL default '0',
  csv_backend int(1) NOT NULL default '0',
  products_vpe int(1) NOT NULL default '0',
  cross_sell_groups int(1) NOT NULL default '0',
  
  fck_wrapper int(1) NOT NULL default '0',
  
  PRIMARY KEY  (customers_id)
);


DROP TABLE IF EXISTS banktransfer;
CREATE TABLE banktransfer (
  orders_id int(11) NOT NULL default '0',
  banktransfer_owner varchar(64) default NULL,
  banktransfer_number varchar(24) default NULL,
  banktransfer_bankname varchar(255) default NULL,
  banktransfer_blz varchar(8) default NULL,
  banktransfer_status int(11) default NULL,
  banktransfer_prz char(2) default NULL,
  banktransfer_fax char(2) default NULL,
  KEY orders_id(orders_id)
);


DROP TABLE IF EXISTS banners;
CREATE TABLE banners (
  banners_id int NOT NULL auto_increment,
  banners_title varchar(64) NOT NULL,
  banners_url varchar(255) NOT NULL,
  banners_image varchar(64) NOT NULL,
  banners_group varchar(10) NOT NULL,
  banners_html_text text,
  expires_impressions int(7) DEFAULT '0',
  expires_date datetime DEFAULT NULL,
  date_scheduled datetime DEFAULT NULL,
  date_added datetime NOT NULL,
  date_status_change datetime DEFAULT NULL,
  status int(1) DEFAULT '1' NOT NULL,
  PRIMARY KEY  (banners_id)
);

DROP TABLE IF EXISTS banners_history;
CREATE TABLE banners_history (
  banners_history_id int NOT NULL auto_increment,
  banners_id int NOT NULL,
  banners_shown int(5) NOT NULL DEFAULT '0',
  banners_clicked int(5) NOT NULL DEFAULT '0',
  banners_history_date datetime NOT NULL,
  PRIMARY KEY  (banners_history_id)
);

DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
  categories_id int NOT NULL auto_increment,
  categories_image varchar(64),
  parent_id int DEFAULT '0' NOT NULL,
  categories_status TINYint (1)  UNSIGNED DEFAULT "1" NOT NULL,
  categories_template varchar(64),
  group_permission_0 tinyint(1) NOT NULL,
  group_permission_1 tinyint(1) NOT NULL,
  group_permission_2 tinyint(1) NOT NULL,
  group_permission_3 tinyint(1) NOT NULL,
  listing_template varchar(64),
  sort_order int(3) DEFAULT "0" NOT NULL,
  products_sorting varchar(32),
  products_sorting2 varchar(32),
  date_added datetime,
  last_modified datetime,
  PRIMARY KEY (categories_id),
  KEY idx_categories_parent_id (parent_id)
);

DROP TABLE IF EXISTS categories_description;
CREATE TABLE categories_description (
  categories_id int DEFAULT '0' NOT NULL,
  language_id int DEFAULT '1' NOT NULL,
  categories_name varchar(32) NOT NULL,
  categories_heading_title varchar(255) NOT NULL,
  categories_description text NOT NULL,
  categories_meta_title varchar(100) NOT NULL,
  categories_meta_description varchar(255) NOT NULL,
  categories_meta_keywords varchar(255) NOT NULL,
  PRIMARY KEY (categories_id, language_id),
  KEY idx_categories_name (categories_name)
);

DROP TABLE IF EXISTS configuration;
CREATE TABLE configuration (
  configuration_id int NOT NULL auto_increment,
  configuration_key varchar(64) NOT NULL,
  configuration_value varchar(255) NOT NULL,
  configuration_group_id int NOT NULL,
  sort_order int(5) NULL,
  last_modified datetime NULL,
  date_added datetime NOT NULL,
  use_function varchar(255) NULL,
  set_function varchar(255) NULL,
  PRIMARY KEY (configuration_id),
  KEY idx_configuration_group_id (configuration_group_id)
);

DROP TABLE IF EXISTS configuration_group;
CREATE TABLE configuration_group (
  configuration_group_id int NOT NULL auto_increment,
  configuration_group_title varchar(64) NOT NULL,
  configuration_group_description varchar(255) NOT NULL,
  sort_order int(5) NULL,
  visible int(1) DEFAULT '1' NULL,
  PRIMARY KEY (configuration_group_id)
);

DROP TABLE IF EXISTS counter;
CREATE TABLE counter (
  startdate char(8),
  counter int(12)
);

DROP TABLE IF EXISTS counter_history;
CREATE TABLE counter_history (
  month char(8),
  counter int(12)
);

DROP TABLE IF EXISTS countries;
CREATE TABLE countries (
  countries_id int NOT NULL auto_increment,
  countries_name varchar(64) NOT NULL,
  countries_iso_code_2 char(2) NOT NULL,
  countries_iso_code_3 char(3) NOT NULL,
  address_format_id int NOT NULL,
  status int(1) DEFAULT '1' NULL,  
  PRIMARY KEY (countries_id),
  KEY IDX_COUNTRIES_NAME (countries_name)
);

DROP TABLE IF EXISTS currencies;
CREATE TABLE currencies (
  currencies_id int NOT NULL auto_increment,
  title varchar(32) NOT NULL,
  code char(3) NOT NULL,
  symbol_left varchar(12),
  symbol_right varchar(12),
  decimal_point char(1),
  thousands_point char(1),
  decimal_places char(1),
  value float(13,8),
  last_updated datetime NULL,
  PRIMARY KEY (currencies_id)
);

DROP TABLE IF EXISTS customers;
CREATE TABLE customers (
  customers_id int NOT NULL auto_increment,
  customers_cid varchar(32),
  customers_vat_id varchar (20),
  customers_vat_id_status int(2) DEFAULT '0' NOT NULL,
  customers_warning varchar(32),
  customers_status int(5) DEFAULT '1' NOT NULL,
  customers_gender char(1) NOT NULL,
  customers_firstname varchar(32) NOT NULL,
  customers_lastname varchar(32) NOT NULL,
  customers_dob datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  customers_email_address varchar(96) NOT NULL,
  customers_default_address_id int NOT NULL,
  customers_telephone varchar(32) NOT NULL,
  customers_fax varchar(32),
  customers_password varchar(40) NOT NULL,
  customers_newsletter char(1),
  customers_newsletter_mode char( 1 ) DEFAULT '0' NOT NULL,
  member_flag char(1) DEFAULT '0' NOT NULL,
  delete_user char(1) DEFAULT '1' NOT NULL,
  account_type int(1) NOT NULL default '0',
  password_request_key varchar(32) NOT NULL,
  payment_unallowed varchar(255) NOT NULL,
  shipping_unallowed varchar(255) NOT NULL,
  refferers_id int(5) DEFAULT '0' NOT NULL,
  customers_date_added datetime DEFAULT '0000-00-00 00:00:00',
  customers_last_modified datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (customers_id)
);

DROP TABLE IF EXISTS customers_basket;
CREATE TABLE customers_basket (
  customers_basket_id int NOT NULL auto_increment,
  customers_id int NOT NULL,
  products_id tinytext NOT NULL,
  customers_basket_quantity int(2) NOT NULL,
  final_price decimal(15,4) NOT NULL,
  customers_basket_date_added char(8),
  PRIMARY KEY (customers_basket_id)
);

DROP TABLE IF EXISTS customers_basket_attributes;
CREATE TABLE customers_basket_attributes (
  customers_basket_attributes_id int NOT NULL auto_increment,
  customers_id int NOT NULL,
  products_id tinytext NOT NULL,
  products_options_id int NOT NULL,
  products_options_value_id int NOT NULL,
  PRIMARY KEY (customers_basket_attributes_id)
);

DROP TABLE IF EXISTS customers_info;
CREATE TABLE customers_info (
  customers_info_id int NOT NULL,
  customers_info_date_of_last_logon datetime,
  customers_info_number_of_logons int(5),
  customers_info_date_account_created datetime,
  customers_info_date_account_last_modified datetime,
  global_product_notifications int(1) DEFAULT '0',
  PRIMARY KEY (customers_info_id)
);

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
);

DROP TABLE IF EXISTS customers_status;
CREATE TABLE customers_status (
  customers_status_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL DEFAULT '1',
  customers_status_name VARCHAR(32) NOT NULL DEFAULT '',
  customers_status_public int(1) NOT NULL DEFAULT '1',
  customers_status_min_order int(7) DEFAULT NULL,
  customers_status_max_order int(7) DEFAULT NULL,
  customers_status_image varchar(64) DEFAULT NULL,
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
  PRIMARY KEY  (customers_status_id,language_id),
  KEY idx_orders_status_name (customers_status_name)
);

DROP TABLE IF EXISTS customers_status_history;
CREATE TABLE customers_status_history (
  customers_status_history_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  new_value int(5) NOT NULL default '0',
  old_value int(5) default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  customer_notified int(1) default '0',
  PRIMARY KEY  (customers_status_history_id)
);

DROP TABLE IF EXISTS languages;
CREATE TABLE languages (
  languages_id int NOT NULL auto_increment,
  name varchar(32)  NOT NULL,
  code char(2) NOT NULL,
  image varchar(64),
  directory varchar(32),
  sort_order int(3),
  language_charset text NOT NULL,
  PRIMARY KEY (languages_id),
  KEY IDX_LANGUAGES_NAME (name)
);


DROP TABLE IF EXISTS manufacturers;
CREATE TABLE manufacturers (
  manufacturers_id int NOT NULL auto_increment,
  manufacturers_name varchar(32) NOT NULL,
  manufacturers_image varchar(64),
  date_added datetime NULL,
  last_modified datetime NULL,
  PRIMARY KEY (manufacturers_id),
  KEY IDX_MANUFACTURERS_NAME (manufacturers_name)
);

DROP TABLE IF EXISTS manufacturers_info;
CREATE TABLE manufacturers_info (
  manufacturers_id int NOT NULL,
  languages_id int NOT NULL,
  manufacturers_meta_title varchar(100) NOT NULL,
  manufacturers_meta_description varchar(255) NOT NULL,
  manufacturers_meta_keywords varchar(255) NOT NULL,
  manufacturers_url varchar(255) NOT NULL,
  url_clicked int(5) NOT NULL default '0',
  date_last_click datetime NULL,
  PRIMARY KEY (manufacturers_id, languages_id)
);

DROP TABLE IF EXISTS newsletters;
CREATE TABLE newsletters (
  newsletters_id int NOT NULL auto_increment,
  title varchar(255) NOT NULL,
  content text NOT NULL,
  module varchar(255) NOT NULL,
  date_added datetime NOT NULL,
  date_sent datetime,
  status int(1),
  locked int(1) DEFAULT '0',
  PRIMARY KEY (newsletters_id)
);

DROP TABLE IF EXISTS newsletter_recipients;
CREATE TABLE newsletter_recipients (
  mail_id int(11) NOT NULL auto_increment,
  customers_email_address varchar(96) NOT NULL default '',
  customers_id int(11) NOT NULL default '0',
  customers_status int(5) NOT NULL default '0',
  customers_firstname varchar(32) NOT NULL default '',
  customers_lastname varchar(32) NOT NULL default '',
  mail_status int(1) NOT NULL default '0',
  mail_key varchar(32) NOT NULL default '',
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (mail_id)
);

DROP TABLE IF EXISTS newsletters_history;
CREATE TABLE newsletters_history (
  news_hist_id int(11) NOT NULL default '0',
  news_hist_cs int(11) NOT NULL default '0',
  news_hist_cs_date_sent date default NULL,
  PRIMARY KEY  (news_hist_id)
);

DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
  orders_id int NOT NULL auto_increment,
  customers_id int NOT NULL,
  customers_cid varchar(32),
  customers_vat_id varchar (20),
  customers_status int(11),
  customers_status_name varchar(32) NOT NULL,
  customers_status_image varchar (64),
  customers_status_discount decimal (4,2),
  customers_name varchar(64) NOT NULL,
  customers_firstname varchar(64) NOT NULL,
  customers_lastname varchar(64) NOT NULL,
  customers_company varchar(32),
  customers_street_address varchar(64) NOT NULL,
  customers_suburb varchar(32),
  customers_city varchar(32) NOT NULL,
  customers_postcode varchar(10) NOT NULL,
  customers_state varchar(32),
  customers_country varchar(32) NOT NULL,
  customers_telephone varchar(32) NOT NULL,
  customers_email_address varchar(96) NOT NULL,
  customers_address_format_id int(5) NOT NULL,
  delivery_name varchar(64) NOT NULL,
  delivery_firstname varchar(64) NOT NULL,
  delivery_lastname varchar(64) NOT NULL,
  delivery_company varchar(32),
  delivery_street_address varchar(64) NOT NULL,
  delivery_suburb varchar(32),
  delivery_city varchar(32) NOT NULL,
  delivery_postcode varchar(10) NOT NULL,
  delivery_state varchar(32),
  delivery_country varchar(32) NOT NULL,
  delivery_country_iso_code_2 char(2) NOT NULL,
  delivery_address_format_id int(5) NOT NULL,
  billing_name varchar(64) NOT NULL,
  billing_firstname varchar(64) NOT NULL,
  billing_lastname varchar(64) NOT NULL,
  billing_company varchar(32),
  billing_street_address varchar(64) NOT NULL,
  billing_suburb varchar(32),
  billing_city varchar(32) NOT NULL,
  billing_postcode varchar(10) NOT NULL,
  billing_state varchar(32),
  billing_country varchar(32) NOT NULL,
  billing_country_iso_code_2 char(2) NOT NULL,
  billing_address_format_id int(5) NOT NULL,
  payment_method varchar(32) NOT NULL,
  cc_type varchar(20),
  cc_owner varchar(64),
  cc_number varchar(64),
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
  payment_class VARCHAR(32) NOT NULL,
  shipping_method VARCHAR(32) NOT NULL,
  shipping_class VARCHAR(32) NOT NULL,
  customers_ip VARCHAR(32) NOT NULL,
  language VARCHAR(32) NOT NULL,
  afterbuy_success INT(1) DEFAULT'0' NOT NULL,
  afterbuy_id INT(32) DEFAULT '0' NOT NULL,
  refferers_id VARCHAR(32) NOT NULL,
  conversion_type INT(1) DEFAULT '0' NOT NULL,
  orders_ident_key varchar(128),
  PRIMARY KEY (orders_id)
);

DROP TABLE IF EXISTS card_blacklist;
CREATE TABLE card_blacklist (
  blacklist_id int(5) NOT NULL auto_increment,
  blacklist_card_number varchar(20) NOT NULL default '',
  date_added datetime default NULL,
  last_modified datetime default NULL,
  KEY blacklist_id (blacklist_id)
);

DROP TABLE IF EXISTS orders_products;
CREATE TABLE orders_products (
  orders_products_id int NOT NULL auto_increment,
  orders_id int NOT NULL,
  products_id int NOT NULL,
  products_model varchar(64),
  products_name varchar(64) NOT NULL,
  products_price decimal(15,4) NOT NULL,
  products_discount_made decimal(4,2) DEFAULT NULL,
  final_price decimal(15,4) NOT NULL,
  products_tax decimal(7,4) NOT NULL,
  products_quantity int(2) NOT NULL,
  allow_tax int(1) NOT NULL,
  PRIMARY KEY (orders_products_id)
);

DROP TABLE IF EXISTS orders_status;
CREATE TABLE orders_status (
  orders_status_id int DEFAULT '0' NOT NULL,
  language_id int DEFAULT '1' NOT NULL,
  orders_status_name varchar(32) NOT NULL,
  PRIMARY KEY (orders_status_id, language_id),
  KEY idx_orders_status_name (orders_status_name)
);

DROP TABLE IF EXISTS shipping_status;
CREATE TABLE shipping_status (
  shipping_status_id int DEFAULT '0' NOT NULL,
  language_id int DEFAULT '1' NOT NULL,
  shipping_status_name varchar(32) NOT NULL,
  shipping_status_image varchar(32) NOT NULL,
  PRIMARY KEY (shipping_status_id, language_id),
  KEY idx_shipping_status_name (shipping_status_name)
);

DROP TABLE IF EXISTS orders_status_history;
CREATE TABLE orders_status_history (
  orders_status_history_id int NOT NULL auto_increment,
  orders_id int NOT NULL,
  orders_status_id int(5) NOT NULL,
  date_added datetime NOT NULL,
  customer_notified int(1) DEFAULT '0',
  comments text,
  PRIMARY KEY (orders_status_history_id)
);

DROP TABLE IF EXISTS orders_products_attributes;
CREATE TABLE orders_products_attributes (
  orders_products_attributes_id int NOT NULL auto_increment,
  orders_id int NOT NULL,
  orders_products_id int NOT NULL,
  products_options varchar(32) NOT NULL,
  products_options_values varchar(64) NOT NULL,
  options_values_price decimal(15,4) NOT NULL,
  price_prefix char(1) NOT NULL,
  PRIMARY KEY (orders_products_attributes_id)
);

DROP TABLE IF EXISTS orders_products_download;
CREATE TABLE orders_products_download (
  orders_products_download_id int NOT NULL auto_increment,
  orders_id int NOT NULL default '0',
  orders_products_id int NOT NULL default '0',
  orders_products_filename varchar(255) NOT NULL default '',
  download_maxdays int(2) NOT NULL default '0',
  download_count int(2) NOT NULL default '0',
  PRIMARY KEY  (orders_products_download_id)
);

DROP TABLE IF EXISTS orders_total;
CREATE TABLE orders_total (
  orders_total_id int unsigned NOT NULL auto_increment,
  orders_id int NOT NULL,
  title varchar(255) NOT NULL,
  text varchar(255) NOT NULL,
  value decimal(15,4) NOT NULL,
  class varchar(32) NOT NULL,
  sort_order int NOT NULL,
  PRIMARY KEY (orders_total_id),
  KEY idx_orders_total_orders_id (orders_id)
);

DROP TABLE IF EXISTS orders_recalculate;
CREATE TABLE orders_recalculate (
  orders_recalculate_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  n_price decimal(15,4) NOT NULL default '0.0000',
  b_price decimal(15,4) NOT NULL default '0.0000',
  tax decimal(15,4) NOT NULL default '0.0000',
  tax_rate decimal(7,4) NOT NULL default '0.0000',
  class varchar(32) NOT NULL default '',
  PRIMARY KEY  (orders_recalculate_id)
);

DROP TABLE IF EXISTS products;
CREATE TABLE products (
  products_id int NOT NULL auto_increment,
  products_ean varchar(128),
  products_quantity int(4) NOT NULL,
  products_shippingtime int(4) NOT NULL,
  products_model varchar(64),
  group_permission_0 tinyint(1) NOT NULL,
  group_permission_1 tinyint(1) NOT NULL,
  group_permission_2 tinyint(1) NOT NULL,
  group_permission_3 tinyint(1) NOT NULL,
  products_sort int(4) NOT NULL DEFAULT '0',
  products_image varchar(64),
  products_price decimal(15,4) NOT NULL,
  products_discount_allowed decimal(3,2) DEFAULT '0' NOT NULL,
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
  PRIMARY KEY (products_id),
  KEY idx_products_date_added (products_date_added)
);



DROP TABLE IF EXISTS products_attributes;
CREATE TABLE products_attributes (
  products_attributes_id int NOT NULL auto_increment,
  products_id int NOT NULL,
  options_id int NOT NULL,
  options_values_id int NOT NULL,
  options_values_price decimal(15,4) NOT NULL,
  price_prefix char(1) NOT NULL,
  attributes_model varchar(64) NULL,
  attributes_stock int(4) NULL,
  options_values_weight decimal(15,4) NOT NULL,
  weight_prefix char(1) NOT NULL,
  sortorder int(11) NULL,
  PRIMARY KEY (products_attributes_id)
);

DROP TABLE IF EXISTS products_attributes_download;
CREATE TABLE products_attributes_download (
  products_attributes_id int NOT NULL,
  products_attributes_filename varchar(255) NOT NULL default '',
  products_attributes_maxdays int(2) default '0',
  products_attributes_maxcount int(2) default '0',
  PRIMARY KEY  (products_attributes_id)
);

DROP TABLE IF EXISTS products_description;
CREATE TABLE products_description (
  products_id int NOT NULL auto_increment,
  language_id int NOT NULL default '1',
  products_name varchar(64) NOT NULL default '',
  products_description text,
  products_short_description text,
  products_keywords VARCHAR(255) DEFAULT NULL,
  products_meta_title text NOT NULL,
  products_meta_description text NOT NULL,
  products_meta_keywords text NOT NULL,
  products_url varchar(255) default NULL,
  products_viewed int(5) default '0',
  PRIMARY KEY  (products_id,language_id),
  KEY products_name (products_name)
);

DROP TABLE IF EXISTS products_images;
CREATE TABLE products_images (
  image_id INT NOT NULL auto_increment,
  products_id INT NOT NULL ,
  image_nr SMALLINT NOT NULL ,
  image_name VARCHAR( 254 ) NOT NULL ,
  PRIMARY KEY ( image_id )
);

DROP TABLE IF EXISTS products_notifications;
CREATE TABLE products_notifications (
  products_id int NOT NULL,
  customers_id int NOT NULL,
  date_added datetime NOT NULL,
  PRIMARY KEY (products_id, customers_id)
);

DROP TABLE IF EXISTS products_options;
CREATE TABLE products_options (
  products_options_id int NOT NULL default '0',
  language_id int NOT NULL default '1',
  products_options_name varchar(32) NOT NULL default '',
  PRIMARY KEY  (products_options_id,language_id)
);

DROP TABLE IF EXISTS products_options_values;
CREATE TABLE products_options_values (
  products_options_values_id int NOT NULL default '0',
  language_id int NOT NULL default '1',
  products_options_values_name varchar(64) NOT NULL default '',
  PRIMARY KEY  (products_options_values_id,language_id)
);

DROP TABLE IF EXISTS products_options_values_to_products_options;
CREATE TABLE products_options_values_to_products_options (
  products_options_values_to_products_options_id int NOT NULL auto_increment,
  products_options_id int NOT NULL,
  products_options_values_id int NOT NULL,
  PRIMARY KEY (products_options_values_to_products_options_id)
);

DROP TABLE IF EXISTS products_graduated_prices;
CREATE TABLE products_graduated_prices (
  products_id int(11) NOT NULL default '0',
  quantity int(11) NOT NULL default '0',
  unitprice decimal(15,4) NOT NULL default '0.0000',
  KEY products_id (products_id)
);

DROP TABLE IF EXISTS products_to_categories;
CREATE TABLE products_to_categories (
  products_id int NOT NULL,
  categories_id int NOT NULL,
  PRIMARY KEY (products_id,categories_id)
);

DROP TABLE IF EXISTS products_vpe;
CREATE TABLE products_vpe (
  products_vpe_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '0',
  products_vpe_name varchar(32) NOT NULL default ''
);

DROP TABLE IF EXISTS reviews;
CREATE TABLE reviews (
  reviews_id int NOT NULL auto_increment,
  products_id int NOT NULL,
  customers_id int,
  customers_name varchar(64) NOT NULL,
  reviews_rating int(1),
  date_added datetime,
  last_modified datetime,
  reviews_read int(5) NOT NULL default '0',
  PRIMARY KEY (reviews_id)
);

DROP TABLE IF EXISTS reviews_description;
CREATE TABLE reviews_description (
  reviews_id int NOT NULL,
  languages_id int NOT NULL,
  reviews_text text NOT NULL,
  PRIMARY KEY (reviews_id, languages_id)
);

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions (
  sesskey varchar(32) NOT NULL,
  expiry int(11) unsigned NOT NULL,
  value text NOT NULL,
  PRIMARY KEY (sesskey)
);

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
  PRIMARY KEY (specials_id)
);

DROP TABLE IF EXISTS tax_class;
CREATE TABLE tax_class (
  tax_class_id int NOT NULL auto_increment,
  tax_class_title varchar(32) NOT NULL,
  tax_class_description varchar(255) NOT NULL,
  last_modified datetime NULL,
  date_added datetime NOT NULL,
  PRIMARY KEY (tax_class_id)
);

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
);

DROP TABLE IF EXISTS geo_zones;
CREATE TABLE geo_zones (
  geo_zone_id int NOT NULL auto_increment,
  geo_zone_name varchar(32) NOT NULL,
  geo_zone_description varchar(255) NOT NULL,
  last_modified datetime NULL,
  date_added datetime NOT NULL,
  PRIMARY KEY (geo_zone_id)
);

DROP TABLE IF EXISTS whos_online;
CREATE TABLE whos_online (
  customer_id int,
  full_name varchar(64) NOT NULL,
  session_id varchar(128) NOT NULL,
  ip_address varchar(15) NOT NULL,
  time_entry varchar(14) NOT NULL,
  time_last_click varchar(14) NOT NULL,
  last_page_url varchar(255) NOT NULL
);

DROP TABLE IF EXISTS zones;
CREATE TABLE zones (
  zone_id int NOT NULL auto_increment,
  zone_country_id int NOT NULL,
  zone_code varchar(32) NOT NULL,
  zone_name varchar(32) NOT NULL,
  PRIMARY KEY (zone_id)
);

DROP TABLE IF EXISTS zones_to_geo_zones;
CREATE TABLE zones_to_geo_zones (
   association_id int NOT NULL auto_increment,
   zone_country_id int NOT NULL,
   zone_id int NULL,
   geo_zone_id int NULL,
   last_modified datetime NULL,
   date_added datetime NOT NULL,
   PRIMARY KEY (association_id)
);


DROP TABLE IF EXISTS content_manager;
CREATE TABLE content_manager (
  content_id int(11) NOT NULL auto_increment,
  categories_id int(11) NOT NULL default '0',
  parent_id int(11) NOT NULL default '0',
  group_ids TEXT,
  languages_id int(11) NOT NULL default '0',
  content_title text NOT NULL,
  content_heading text NOT NULL,
  content_text text NOT NULL,
  sort_order int(4) NOT NULL default '0',
  file_flag int(1) NOT NULL default '0',
  content_file varchar(64) NOT NULL default '',
  content_status int(1) NOT NULL default '0',
  content_group int(11) NOT NULL,
  content_delete int(1) NOT NULL default '1',
  PRIMARY KEY  (content_id)
);

DROP TABLE IF EXISTS media_content;
CREATE TABLE media_content (
  file_id int(11) NOT NULL auto_increment,
  old_filename text NOT NULL,
  new_filename text NOT NULL,
  file_comment text NOT NULL,
  PRIMARY KEY  (file_id)
);

DROP TABLE IF EXISTS products_content;
CREATE TABLE products_content (
  content_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  group_ids TEXT,
  content_name varchar(32) NOT NULL default '',
  content_file varchar(64) NOT NULL,
  content_link text NOT NULL,
  languages_id int(11) NOT NULL default '0',
  content_read int(11) NOT NULL default '0',
  file_comment text NOT NULL,
  PRIMARY KEY  (content_id)
);

DROP TABLE IF EXISTS module_newsletter;
CREATE TABLE module_newsletter (
  newsletter_id int(11) NOT NULL auto_increment,
  title text NOT NULL,
  bc text NOT NULL,
  cc text NOT NULL,
  date datetime default NULL,
  status int(1) NOT NULL default '0',
  body text NOT NULL,
  PRIMARY KEY  (newsletter_id)
);

DROP TABLE if exists cm_file_flags;
CREATE TABLE cm_file_flags (
  file_flag int(11) NOT NULL,
  file_flag_name varchar(32) NOT NULL,
  PRIMARY KEY (file_flag)
);



DROP TABLE if EXISTS payment_moneybookers_currencies;
CREATE TABLE payment_moneybookers_currencies (
  mb_currID char(3) NOT NULL default '',
  mb_currName varchar(255) NOT NULL default '',
  PRIMARY KEY  (mb_currID)
);


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
);


DROP TABLE if EXISTS payment_moneybookers_countries;
CREATE TABLE payment_moneybookers_countries (
  osc_cID int(11) NOT NULL default '0',
  mb_cID char(3) NOT NULL default '',
  PRIMARY KEY  (osc_cID)
);

DROP TABLE if EXISTS coupon_email_track;
CREATE TABLE coupon_email_track (
  unique_id int(11) NOT NULL auto_increment,
  coupon_id int(11) NOT NULL default '0',
  customer_id_sent int(11) NOT NULL default '0',
  sent_firstname varchar(32) default NULL,
  sent_lastname varchar(32) default NULL,
  emailed_to varchar(32) default NULL,
  date_sent datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (unique_id)
);

DROP TABLE if EXISTS coupon_gv_customer;
CREATE TABLE coupon_gv_customer (
  customer_id int(5) NOT NULL default '0',
  amount decimal(8,4) NOT NULL default '0.0000',
  PRIMARY KEY  (customer_id),
  KEY customer_id (customer_id)
);

DROP TABLE if EXISTS coupon_gv_queue;
CREATE TABLE coupon_gv_queue (
  unique_id int(5) NOT NULL auto_increment,
  customer_id int(5) NOT NULL default '0',
  order_id int(5) NOT NULL default '0',
  amount decimal(8,4) NOT NULL default '0.0000',
  date_created datetime NOT NULL default '0000-00-00 00:00:00',
  ipaddr varchar(32) NOT NULL default '',
  release_flag char(1) NOT NULL default 'N',
  PRIMARY KEY  (unique_id),
  KEY uid (unique_id,customer_id,order_id)
);

DROP TABLE if EXISTS coupon_redeem_track;
CREATE TABLE coupon_redeem_track (
  unique_id int(11) NOT NULL auto_increment,
  coupon_id int(11) NOT NULL default '0',
  customer_id int(11) NOT NULL default '0',
  redeem_date datetime NOT NULL default '0000-00-00 00:00:00',
  redeem_ip varchar(32) NOT NULL default '',
  order_id int(11) NOT NULL default '0',
  PRIMARY KEY  (unique_id)
);

DROP TABLE if EXISTS coupons;
CREATE TABLE coupons (
  coupon_id int(11) NOT NULL auto_increment,
  coupon_type char(1) NOT NULL default 'F',
  coupon_code varchar(32) NOT NULL default '',
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
);

DROP TABLE if EXISTS coupons_description;
CREATE TABLE coupons_description (
  coupon_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '0',
  coupon_name varchar(32) NOT NULL default '',
  coupon_description text,
  KEY coupon_id (coupon_id)
);

DROP TABLE if exists payment_qenta;
CREATE TABLE payment_qenta (
  q_TRID varchar(255) NOT NULL default '',
  q_DATE datetime NOT NULL default '0000-00-00 00:00:00',
  q_QTID bigint(18) unsigned NOT NULL default '0',
  q_ORDERDESC varchar(255) NOT NULL default '',
  q_STATUS tinyint(1) NOT NULL default '0',
  q_ORDERID int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (q_TRID)
);

DROP TABLE if EXISTS personal_offers_by_customers_status_0;
DROP TABLE if EXISTS personal_offers_by_customers_status_1;
DROP TABLE if EXISTS personal_offers_by_customers_status_2;
DROP TABLE if EXISTS personal_offers_by_customers_status_3;


#database Version
INSERT INTO database_version(version) VALUES ('3.0.4.0');

INSERT INTO cm_file_flags (file_flag, file_flag_name) VALUES ('0', 'information');
INSERT INTO cm_file_flags (file_flag, file_flag_name) VALUES ('1', 'content');

INSERT INTO shipping_status VALUES (1, 1, '3-4 Days', '');
INSERT INTO shipping_status VALUES (1, 2, '3-4 Tage', '');
INSERT INTO shipping_status VALUES (2, 1, '1 Week', '');
INSERT INTO shipping_status VALUES (2, 2, '1 Woche', '');
INSERT INTO shipping_status VALUES (3, 1, '2 Weeks', '');
INSERT INTO shipping_status VALUES (3, 2, '2 Wochen', '');

# data

INSERT INTO `content_manager` VALUES (1, 0, 0, '', 1, 'Shipping & Returns', 'Shipping & Returns', 'Put here your Shipping & Returns information.', 0, 1, '', 1, 1, 0);
INSERT INTO `content_manager` VALUES (2, 0, 0, '', 1, 'Privacy Notice', 'Privacy Notice', 'Put here your Privacy Notice information.', 0, 1, '', 1, 2, 0);
INSERT INTO `content_manager` VALUES (3, 0, 0, '', 1, 'Conditions of Use', 'Conditions of Use', 'Conditions of Use<br />Put here your Conditions of Use information. <br />1. Validity<br />2. Offers<br />3. Price<br />4. Dispatch and passage of the risk<br />5. Delivery<br />6. Terms of payment<br />7. Retention of title<br />8. Notices of defect, guarantee and compensation<br />9. Fair trading cancelling / non-acceptance<br />10. Place of delivery and area of jurisdiction<br />11. Final clauses', 0, 1, '', 1, 3, 0);
INSERT INTO `content_manager` VALUES (4, 0, 0, '', 1, 'Impressum', 'Impressum', 'Put here your Company information.', 0, 1, '', 1, 4, 0);
INSERT INTO `content_manager` VALUES (5, 0, 0, '', 1, 'Index', 'Welcome', '{$greeting}<br /><br /> Dies ist die Standardinstallation des osCommerce Forking Projektes - xt:Commerce. Alle dargestellten Produkte dienen zur Demonstration der Funktionsweise. Wenn Sie Produkte bestellen, so werden diese weder ausgeliefert, noch in Rechnung gestellt. Alle Informationen zu den verschiedenen Produkten sind erfunden und daher kann kein Anspruch daraus abgeleitet werden.<br /><br />Sollten Sie daran interessiert sein das Programm, welches die Grundlage für diesen Shop bildet, einzusetzen, so besuchen Sie bitte die Supportseite von xt:Commerce. Dieser Shop basiert auf der xt:Commerce Version v3.0.4<br /><br />Der hier dargestellte Text kann im AdminInterface unter dem Punkt <b>Content Manager</b> - Eintrag Index bearbeitet werden.', 0, 1, '', 0, 5, 0);
INSERT INTO `content_manager` VALUES (6, 0, 0, '', 2, 'Liefer- und Versandkosten', 'Liefer- und Versandkosten', 'F&uuml;gen Sie hier Ihre Informationen &uuml;ber Liefer- und Versandkosten ein.', 0, 1, '', 1, 1, 0);
INSERT INTO `content_manager` VALUES (7, 0, 0, '', 2, 'Privatsphäre und Datenschutz', 'Privatsphäre und Datenschutz', 'F&uuml;gen Sie hier Ihre Informationen &uuml;ber Privatsph&auml;re und Datenschutz ein.', 0, 1, '', 1, 2, 0);
INSERT INTO `content_manager` VALUES (8, 0, 0, '', 2, 'Unsere AGB\'s', 'Allgemeine Geschäftsbedingungen', '<strong>Allgemeine Gesch&auml;ftsbedingungen<br /></strong><br />F&uuml;gen Sie hier Ihre allgemeinen Gesch&auml;ftsbedingungen ein.<br />1. Geltung<br />2. Angebote<br />3. Preis<br />4. Versand und Gefahr&uuml;bergang<br />5. Lieferung<br />6. Zahlungsbedingungen<br />7. Eigentumsvorbehalt <br />8. M&auml;ngelr&uuml;gen, Gew&auml;hrleistung und Schadenersatz<br />9. Kulanzr&uuml;cknahme / Annahmeverweigerung<br />10. Erf&uuml;llungsort und Gerichtsstand<br />11. Schlussbestimmungen', 0, 1, '', 1, 3, 0);
INSERT INTO `content_manager` VALUES (9, 0, 0, '', 2, 'Impressum', 'Impressum', 'Fügen Sie hier Ihr Impressum ein.', 0, 1, '', 1, 4, 0);
INSERT INTO `content_manager` VALUES (10, 0, 0, '', 2, 'Index', 'Willkommen', '<p>{$greeting}<br /><br />Dies ist die Standardinstallation des osCommerce Forking Projektes - xt:Commerce. Alle dargestellten Produkte dienen zur Demonstration der Funktionsweise. Wenn Sie Produkte bestellen, so werden diese weder ausgeliefert, noch in Rechnung gestellt. Alle Informationen zu den verschiedenen Produkten sind erfunden und daher kann kein Anspruch daraus abgeleitet werden.<br /><br />Sollten Sie daran interessiert sein das Programm, welches die Grundlage für diesen Shop bildet, einzusetzen, so besuchen Sie bitte die Supportseite von xt:Commerce. Dieser Shop basiert auf der xt:Commerce Version v3.0.4<br /><br />Der hier dargestellte Text kann im AdminInterface unter dem Punkt <b>Content Manager</b> - Eintrag Index bearbeitet werden.</p>', 0, 1, '', 0, 5, 0);
INSERT INTO `content_manager` VALUES (11, 0, 0, '', 2, 'Gutscheine', 'Gutscheine - Fragen und Antworte', '<table cellSpacing=0 cellPadding=0>\r\n<tbody>\r\n<tr>\r\n<td class=main><STRONG>Gutscheine kaufen </STRONG></td></tr>\r\n<tr>\r\n<td class=main>Gutscheine können, falls sie im Shop angeboten werden, wie normale Artikel gekauft werden. Sobald Sie einen Gutschein gekauft haben und dieser nach erfolgreicher Zahlung freigeschaltet wurde, erscheint der Betrag unter Ihrem Warenkorb. Nun können Sie über den Link " Gutschein versenden " den gewünschten Betrag per E-Mail versenden. </td></tr></tbody></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<tbody>\r\n<tr>\r\n<td class=main><STRONG>Wie man Gutscheine versendet </STRONG></td></tr>\r\n<tr>\r\n<td class=main>Um einen Gutschein zu versenden, klicken Sie bitte auf den Link "Gutschein versenden" in Ihrem Einkaufskorb. Um einen Gutschein zu versenden, benötigen wir folgende Angaben von Ihnen: Vor- und Nachname des Empfängers. Eine gültige E-Mail Adresse des Empfängers. Den gewünschten Betrag (Sie können auch Teilbeträge Ihres Guthabens versenden). Eine kurze Nachricht an den Empfänger. Bitte überprüfen Sie Ihre Angaben noch einmal vor dem Versenden. Sie haben vor dem Versenden jederzeit die Möglichkeit Ihre Angaben zu korrigieren. </td></tr></tbody></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<tbody>\r\n<tr>\r\n<td class=main><STRONG>Mit Gutscheinen Einkaufen. </STRONG></td></tr>\r\n<tr>\r\n<td class=main>Sobald Sie über ein Guthaben verfügen, können Sie dieses zum Bezahlen Ihrer Bestellung verwenden. Während des Bestellvorganges haben Sie die Möglichkeit Ihr Guthaben einzulösen. Falls das Guthaben unter dem Warenwert liegt müssen Sie Ihre bevorzugte Zahlungsweise für den Differenzbetrag wählen. Übersteigt Ihr Guthaben den Warenwert, steht Ihnen das Restguthaben selbstverständlich für Ihre nächste Bestellung zur Verfügung. </td></tr></tbody></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<tbody>\r\n<tr>\r\n<td class=main><STRONG>Gutscheine verbuchen. </STRONG></td></tr>\r\n<tr>\r\n<td class=main>Wenn Sie einen Gutschein per E-Mail erhalten haben, können Sie den Betrag wie folgt verbuchen:. <br />1. Klicken Sie auf den in der E-Mail angegebenen Link. Falls Sie noch nicht über ein persönliches Kundenkonto verfügen, haben Sie die Möglichkeit ein Konto zu eröffnen. <br />2. Nachdem Sie ein Produkt in den Warenkorb gelegt haben, können Sie dort Ihren Gutscheincode eingeben.</td></tr></tbody></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<tbody>\r\n<tr>\r\n<td class=main><STRONG>Falls es zu Problemen kommen sollte: </STRONG></td></tr>\r\n<tr>\r\n<td class=main>Falls es wider Erwarten zu Problemen mit einem Gutschein kommen sollte, kontaktieren Sie uns bitte per E-Mail : you@yourdomain.com. Bitte beschreiben Sie möglichst genau das Problem, wichtige Angaben sind unter anderem: Ihre Kundennummer, der Gutscheincode, Fehlermeldungen des Systems sowie der von Ihnen benutzte Browser. </td></tr></tbody></table>', 0, 1, '', 0, 6, 1);
INSERT INTO `content_manager` VALUES (12, 0, 0, '', 1, 'Gutscheine', 'Gutscheine - Fragen und Antworte', '<table cellSpacing=0 cellPadding=0>\r\n<tbody>\r\n<tr>\r\n<td class=main><STRONG>Gutscheine kaufen </STRONG></td></tr>\r\n<tr>\r\n<td class=main>Gutscheine können, falls sie im Shop angeboten werden, wie normale Artikel gekauft werden. Sobald Sie einen Gutschein gekauft haben und dieser nach erfolgreicher Zahlung freigeschaltet wurde, erscheint der Betrag unter Ihrem Warenkorb. Nun können Sie über den Link " Gutschein versenden " den gewünschten Betrag per E-Mail versenden. </td></tr></tbody></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<tbody>\r\n<tr>\r\n<td class=main><STRONG>Wie man Gutscheine versendet </STRONG></td></tr>\r\n<tr>\r\n<td class=main>Um einen Gutschein zu versenden, klicken Sie bitte auf den Link "Gutschein versenden" in Ihrem Einkaufskorb. Um einen Gutschein zu versenden, benötigen wir folgende Angaben von Ihnen: Vor- und Nachname des Empfängers. Eine gültige E-Mail Adresse des Empfängers. Den gewünschten Betrag (Sie können auch Teilbeträge Ihres Guthabens versenden). Eine kurze Nachricht an den Empfänger. Bitte überprüfen Sie Ihre Angaben noch einmal vor dem Versenden. Sie haben vor dem Versenden jederzeit die Möglichkeit Ihre Angaben zu korrigieren. </td></tr></tbody></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<tbody>\r\n<tr>\r\n<td class=main><STRONG>Mit Gutscheinen Einkaufen. </STRONG></td></tr>\r\n<tr>\r\n<td class=main>Sobald Sie über ein Guthaben verfügen, können Sie dieses zum Bezahlen Ihrer Bestellung verwenden. Während des Bestellvorganges haben Sie die Möglichkeit Ihr Guthaben einzulösen. Falls das Guthaben unter dem Warenwert liegt müssen Sie Ihre bevorzugte Zahlungsweise für den Differenzbetrag wählen. Übersteigt Ihr Guthaben den Warenwert, steht Ihnen das Restguthaben selbstverständlich für Ihre nächste Bestellung zur Verfügung. </td></tr></tbody></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<tbody>\r\n<tr>\r\n<td class=main><STRONG>Gutscheine verbuchen. </STRONG></td></tr>\r\n<tr>\r\n<td class=main>Wenn Sie einen Gutschein per E-Mail erhalten haben, können Sie den Betrag wie folgt verbuchen:. <br />1. Klicken Sie auf den in der E-Mail angegebenen Link. Falls Sie noch nicht über ein persönliches Kundenkonto verfügen, haben Sie die Möglichkeit ein Konto zu eröffnen. <br />2. Nachdem Sie ein Produkt in den Warenkorb gelegt haben, können Sie dort Ihren Gutscheincode eingeben.</td></tr></tbody></table>\r\n<table cellSpacing=0 cellPadding=0>\r\n<tbody>\r\n<tr>\r\n<td class=main><STRONG>Falls es zu Problemen kommen sollte: </STRONG></td></tr>\r\n<tr>\r\n<td class=main>Falls es wider Erwarten zu Problemen mit einem Gutschein kommen sollte, kontaktieren Sie uns bitte per E-Mail : you@yourdomain.com. Bitte beschreiben Sie möglichst genau das Problem, wichtige Angaben sind unter anderem: Ihre Kundennummer, der Gutscheincode, Fehlermeldungen des Systems sowie der von Ihnen benutzte Browser. </td></tr></tbody></table>', 0, 1, '', 0, 6, 1);
INSERT INTO `content_manager` VALUES (13, 0, 0, '', 2, 'Kontakt', 'Kontakt', '<p>Ihre Kontaktinformationen</p>', 0, 1, '', 1, 7, 0);
INSERT INTO `content_manager` VALUES (14, 0, 0, '', 1, 'Contact', 'Contact', 'Please enter your contact informations.', 0, 1, '', 1, 7, 0);
INSERT INTO `content_manager` VALUES (15, 0, 0, '', 1, 'Sitemap', '', '', 0, 0, 'sitemap.php', 1, 8, 0);
INSERT INTO `content_manager` VALUES (16, 0, 0, '', 2, 'Sitemap', '', '', 0, 0, 'sitemap.php', 1, 8, 0);

# 1 - Default, 2 - USA, 3 - Spain, 4 - Singapore, 5 - Germany
INSERT INTO address_format VALUES (1, '$firstname $lastname$cr$streets$cr$city, $postcode$cr$statecomma$country','$city / $country');
INSERT INTO address_format VALUES (2, '$firstname $lastname$cr$streets$cr$city, $state    $postcode$cr$country','$city, $state / $country');
INSERT INTO address_format VALUES (3, '$firstname $lastname$cr$streets$cr$city$cr$postcode - $statecomma$country','$state / $country');
INSERT INTO address_format VALUES (4, '$firstname $lastname$cr$streets$cr$city ($postcode)$cr$country', '$postcode / $country');
INSERT INTO address_format VALUES (5, '$firstname $lastname$cr$streets$cr$postcode $city$cr$country','$city / $country');

INSERT  INTO admin_access VALUES ( 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT  INTO admin_access VALUES ( 'groups', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 2, 4, 2, 2, 2, 2, 5, 5, 5, 5, 5, 5, 5, 5, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 1, 1);

# configuration_group_id 1
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_NAME', 'xt:Commerce',  1, 1, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_OWNER', 'xt:Commerce', 1, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_OWNER_EMAIL_ADDRESS', 'owner@your-shop.com', 1, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_FROM', 'xt:Commerce owner@your-shop.com',  1, 4, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_COUNTRY', '81',  1, 6, NULL, '', 'xtc_get_country_name', 'xtc_cfg_pull_down_country_list(');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_ZONE', '', 1, 7, NULL, '', 'xtc_cfg_get_zone_name', 'xtc_cfg_pull_down_zone_list(');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EXPECTED_PRODUCTS_SORT', 'desc',  1, 8, NULL, '', NULL, 'xtc_cfg_select_option(array(\'asc\', \'desc\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EXPECTED_PRODUCTS_FIELD', 'date_expected',  1, 9, NULL, '', NULL, 'xtc_cfg_select_option(array(\'products_name\', \'date_expected\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'USE_DEFAULT_LANGUAGE_CURRENCY', 'false', 1, 10, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SEARCH_ENGINE_FRIENDLY_URLS', 'false',  16, 12, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DISPLAY_CART', 'true',  1, 13, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ADVANCED_SEARCH_DEFAULT_OPERATOR', 'and', 1, 15, NULL, '', NULL, 'xtc_cfg_select_option(array(\'and\', \'or\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_NAME_ADDRESS', 'Store Name\nAddress\nCountry\nPhone',  1, 16, NULL, '', NULL, 'xtc_cfg_textarea(');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SHOW_COUNTS', 'false',  1, 17, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DEFAULT_CUSTOMERS_STATUS_ID_ADMIN', '0',  1, 20, NULL, '', 'xtc_get_customers_status_name', 'xtc_cfg_pull_down_customers_status_list(');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DEFAULT_CUSTOMERS_STATUS_ID_GUEST', '1',  1, 21, NULL, '', 'xtc_get_customers_status_name', 'xtc_cfg_pull_down_customers_status_list(');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DEFAULT_CUSTOMERS_STATUS_ID', '2',  1, 23, NULL, '', 'xtc_get_customers_status_name', 'xtc_cfg_pull_down_customers_status_list(');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ALLOW_ADD_TO_CART', 'false',  1, 24, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CURRENT_TEMPLATE', 'xtc4', 1, 26, NULL, '', NULL, 'xtc_cfg_pull_down_template_sets(');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'PRICE_IS_BRUTTO', 'false', 1, 27, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'PRICE_PRECISION', '4', 1, 28, NULL, '', NULL, '');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CC_KEYCHAIN', 'changeme', 1, 29, NULL, '', NULL, '');


# configuration_group_id 2
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ENTRY_FIRST_NAME_MIN_LENGTH', '2',  2, 1, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ENTRY_LAST_NAME_MIN_LENGTH', '2',  2, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ENTRY_DOB_MIN_LENGTH', '10',  2, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ENTRY_EMAIL_ADDRESS_MIN_LENGTH', '6',  2, 4, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ENTRY_STREET_ADDRESS_MIN_LENGTH', '5',  2, 5, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ENTRY_COMPANY_MIN_LENGTH', '2',  2, 6, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ENTRY_POSTCODE_MIN_LENGTH', '4',  2, 7, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ENTRY_CITY_MIN_LENGTH', '3',  2, 8, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ENTRY_STATE_MIN_LENGTH', '2', 2, 9, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ENTRY_TELEPHONE_MIN_LENGTH', '3',  2, 10, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ENTRY_PASSWORD_MIN_LENGTH', '5',  2, 11, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CC_OWNER_MIN_LENGTH', '3',  2, 12, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CC_NUMBER_MIN_LENGTH', '10',  2, 13, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'REVIEW_TEXT_MIN_LENGTH', '50',  2, 14, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MIN_DISPLAY_BESTSELLERS', '1',  2, 15, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MIN_DISPLAY_ALSO_PURCHASED', '1', 2, 16, NULL, '', NULL, NULL);

# configuration_group_id 3
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_ADDRESS_BOOK_ENTRIES', '5',  3, 1, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_SEARCH_RESULTS', '20',  3, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_PAGE_LINKS', '5',  3, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_SPECIAL_PRODUCTS', '9', 3, 4, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_NEW_PRODUCTS', '9',  3, 5, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_UPCOMING_PRODUCTS', '10',  3, 6, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_MANUFACTURERS_IN_A_LIST', '0', 3, 7, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_MANUFACTURERS_LIST', '1',  3, 7, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_MANUFACTURER_NAME_LEN', '15',  3, 8, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_NEW_REVIEWS', '6', 3, 9, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_RANDOM_SELECT_REVIEWS', '10',  3, 10, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_RANDOM_SELECT_NEW', '10',  3, 11, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_RANDOM_SELECT_SPECIALS', '10',  3, 12, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_CATEGORIES_PER_ROW', '3',  3, 13, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_PRODUCTS_NEW', '10',  3, 14, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_BESTSELLERS', '10',  3, 15, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_ALSO_PURCHASED', '6',  3, 16, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX', '6',  3, 17, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_ORDER_HISTORY', '10',  3, 18, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'PRODUCT_REVIEWS_VIEW', '5',  3, 19, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_PRODUCTS_QTY', '1000', 3, 21, 'NULL', '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_NEW_PRODUCTS_DAYS', '30', 3, 22, 'NULL', '', NULL, NULL);

# configuration_group_id 4
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'CONFIG_CALCULATE_IMAGE_SIZE', 'true', 4, 1, NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'IMAGE_QUALITY', '80', 4, 2, '2003-12-15 12:10:45', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_WIDTH', '120', 4, 7, '2003-12-15 12:10:45', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_HEIGHT', '80', 4, 8, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_WIDTH', '200', 4, 9, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_HEIGHT', '160', 4, 10, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_POPUP_WIDTH', '300', 4, 11, '2003-12-15 12:11:00', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_POPUP_HEIGHT', '240', 4, 12, '2003-12-15 12:11:09', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_BEVEL', '', 4, 13, '2003-12-15 13:14:39', '0000-00-00 00:00:00', '', '');
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_GREYSCALE', '', 4, 14, '2003-12-15 13:13:37', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_ELLIPSE', '', 4, 15, '2003-12-15 13:14:57', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES', '', 4, 16, '2003-12-15 13:19:45', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_MERGE', '', 4, 17, '2003-12-15 12:01:43', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_FRAME', '(FFFFFF,000000,3,EEEEEE)', 4, 18, '2003-12-15 13:19:37', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW', '', 4, 19, '2003-12-15 13:15:14', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR', '(4,FFFFFF)', 4, 20, '2003-12-15 12:02:19', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_BEVEL', '', 4, 21, '2003-12-15 13:42:09', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_GREYSCALE', '', 4, 22, '2003-12-15 13:18:00', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_ELLIPSE', '', 4, 23, '2003-12-15 13:41:53', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_ROUND_EDGES', '', 4, 24, '2003-12-15 13:21:55', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_MERGE', '(overlay.gif,10,-50,60,FF0000)', 4, 25, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_FRAME', '(FFFFFF,000000,3,EEEEEE)', 4, 26, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_DROP_SHADDOW', '(3,333333,FFFFFF)', 4, 27, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_MOTION_BLUR', '', 4, 28, '2003-12-15 13:21:18', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_POPUP_BEVEL', '(8,FFCCCC,330000)', 4, 29, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_POPUP_GREYSCALE', '', 4, 30, '2003-12-15 13:22:58', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_POPUP_ELLIPSE', '', 4, 31, '2003-12-15 13:22:51', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_POPUP_ROUND_EDGES', '', 4, 32, '2003-12-15 13:23:17', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_POPUP_MERGE', '(overlay.gif,10,-50,60,FF0000)', 4, 33, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_POPUP_FRAME', '', 4, 34, '2003-12-15 13:22:43', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_POPUP_DROP_SHADDOW', '', 4, 35, '2003-12-15 13:22:26', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_POPUP_MOTION_BLUR', '', 4, 36, '2003-12-15 13:22:32', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'MO_PICS', '0', '4', '3', '', '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'IMAGE_MANIPULATOR', 'image_manipulator_GD2.php', '4', '3', '', '0000-00-00 00:00:00', NULL , 'xtc_cfg_select_option(array(\'image_manipulator_GD2.php\', \'image_manipulator_GD1.php\'),');

# configuration_group_id 5
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_GENDER', 'true',  5, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_DOB', 'true',  5, 2, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_COMPANY', 'true',  5, 3, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_SUBURB', 'true', 5, 4, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_STATE', 'true',  5, 5, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_OPTIONS', 'account',  5, 6, NULL, '', NULL, 'xtc_cfg_select_option(array(\'account\', \'guest\', \'both\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DELETE_GUEST_ACCOUNT', 'true',  5, 7, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');

# configuration_group_id 6
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_PAYMENT_INSTALLED', '', 6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_INSTALLED', 'ot_subtotal.php;ot_shipping.php;ot_tax.php;ot_total.php', 6, 0, '2003-07-18 03:31:55', '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_SHIPPING_INSTALLED', '',  6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DEFAULT_CURRENCY', 'EUR',  6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DEFAULT_LANGUAGE', 'de',  6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DEFAULT_ORDERS_STATUS_ID', '1',  6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DEFAULT_PRODUCTS_VPE_ID', '',  6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DEFAULT_SHIPPING_STATUS_ID', '1',  6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_SHIPPING_STATUS', 'true',  6, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER', '30',  6, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING', 'false', 6, 3, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER', '50',  6, 4, NULL, '', 'currencies->format', NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_SHIPPING_DESTINATION', 'national', 6, 5, NULL, '', NULL, 'xtc_cfg_select_option(array(\'national\', \'international\', \'both\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_SUBTOTAL_STATUS', 'true',  6, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER', '10',  6, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_TAX_STATUS', 'true',  6, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_TAX_SORT_ORDER', '50',  6, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_TOTAL_STATUS', 'true',  6, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER', '99',  6, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_DISCOUNT_STATUS', 'true',  6, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_DISCOUNT_SORT_ORDER', '20', 6, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_STATUS', 'true',  6, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_SUBTOTAL_NO_TAX_SORT_ORDER','40',  6, 2, NULL, '', NULL, NULL);


# configuration_group_id 7
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SHIPPING_ORIGIN_COUNTRY', '81',  7, 1, NULL, '', 'xtc_get_country_name', 'xtc_cfg_pull_down_country_list(');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SHIPPING_ORIGIN_ZIP', '',  7, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SHIPPING_MAX_WEIGHT', '50',  7, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SHIPPING_BOX_WEIGHT', '3',  7, 4, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SHIPPING_BOX_PADDING', '10',  7, 5, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SHOW_SHIPPING', 'true',  7, 6, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SHIPPING_INFOS', '1',  7, 5, NULL, '', NULL, NULL);

# configuration_group_id 8
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'PRODUCT_LIST_FILTER', '1', 8, 1, NULL, '', NULL, NULL);

# configuration_group_id 9
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STOCK_CHECK', 'true',  9, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ATTRIBUTE_STOCK_CHECK', 'true',  9, 2, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STOCK_LIMITED', 'true', 9, 3, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STOCK_ALLOW_CHECKOUT', 'true',  9, 4, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STOCK_MARK_PRODUCT_OUT_OF_STOCK', '***',  9, 5, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STOCK_REORDER_LEVEL', '5',  9, 6, NULL, '', NULL, NULL);

# configuration_group_id 10
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_PAGE_PARSE_TIME', 'false',  10, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_PAGE_PARSE_TIME_LOG', '/var/log/www/tep/page_parse_time.log',  10, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_PARSE_DATE_TIME_FORMAT', '%d/%m/%Y %H:%M:%S', 10, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DISPLAY_PAGE_PARSE_TIME', 'true',  10, 4, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_DB_TRANSACTIONS', 'false',  10, 5, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');

# configuration_group_id 11
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'USE_CACHE', 'false',  11, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DIR_FS_CACHE', 'cache',  11, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CACHE_LIFETIME', '3600',  11, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CACHE_CHECK', 'true',  11, 4, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DB_CACHE', 'false',  11, 5, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DB_CACHE_EXPIRE', '3600',  11, 6, NULL, '', NULL, NULL);

# configuration_group_id 12
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_TRANSPORT', 'mail',  12, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'sendmail\', \'smtp\', \'mail\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SENDMAIL_PATH', '/usr/sbin/sendmail', 12, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SMTP_MAIN_SERVER', 'localhost', 12, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SMTP_Backup_Server', 'localhost', 12, 4, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SMTP_PORT', '25', 12, 5, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SMTP_USERNAME', 'Please Enter', 12, 6, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SMTP_PASSWORD', 'Please Enter', 12, 7, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SMTP_AUTH', 'false', 12, 8, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_LINEFEED', 'LF',  12, 9, NULL, '', NULL, 'xtc_cfg_select_option(array(\'LF\', \'CRLF\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_USE_HTML', 'true',  12, 10, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ENTRY_EMAIL_ADDRESS_CHECK', 'false',  12, 11, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SEND_EMAILS', 'true',  12, 12, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');

# Constants for contact_us
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CONTACT_US_EMAIL_ADDRESS', 'contact@your-shop.com', 12, 20, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CONTACT_US_NAME', 'Mail send by Contact_us Form',  12, 21, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CONTACT_US_REPLY_ADDRESS',  '', 12, 22, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CONTACT_US_REPLY_ADDRESS_NAME',  '', 12, 23, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CONTACT_US_EMAIL_SUBJECT',  '', 12, 24, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CONTACT_US_FORWARDING_STRING',  '', 12, 25, NULL, '', NULL, NULL);

# Constants for support system
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_SUPPORT_ADDRESS', 'support@your-shop.com', 12, 26, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_SUPPORT_NAME', 'Mail send by support systems',  12, 27, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_SUPPORT_REPLY_ADDRESS',  '', 12, 28, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_SUPPORT_REPLY_ADDRESS_NAME',  '', 12, 29, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_SUPPORT_SUBJECT',  '', 12, 30, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_SUPPORT_FORWARDING_STRING',  '', 12, 31, NULL, '', NULL, NULL);

# Constants for billing system
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_BILLING_ADDRESS', 'billing@your-shop.com', 12, 32, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_BILLING_NAME', 'Mail send by billing systems',  12, 33, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_BILLING_REPLY_ADDRESS',  '', 12, 34, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_BILLING_REPLY_ADDRESS_NAME',  '', 12, 35, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_BILLING_SUBJECT',  '', 12, 36, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_BILLING_FORWARDING_STRING',  '', 12, 37, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_BILLING_SUBJECT_ORDER',  'Your order Nr:{$nr} / {$date}', 12, 38, NULL, '', NULL, NULL);

# configuration_group_id 13
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DOWNLOAD_ENABLED', 'false',  13, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DOWNLOAD_BY_REDIRECT', 'false',  13, 2, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DOWNLOAD_UNALLOWED_PAYMENT', 'banktransfer,cod,invoice,moneyorder',  13, 5, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DOWNLOAD_MIN_ORDERS_STATUS', '1',  13, 5, NULL, '', NULL, NULL);


# configuration_group_id 14
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'GZIP_COMPRESSION', 'false',  14, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'GZIP_LEVEL', '5',  14, 2, NULL, '', NULL, NULL);

# configuration_group_id 15
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SESSION_WRITE_DIRECTORY', '/tmp',  15, 1, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SESSION_FORCE_COOKIE_USE', 'False',  15, 2, NULL, '', NULL, 'xtc_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SESSION_CHECK_SSL_SESSION_ID', 'False',  15, 3, NULL, '', NULL, 'xtc_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SESSION_CHECK_USER_AGENT', 'False',  15, 4, NULL, '', NULL, 'xtc_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SESSION_CHECK_IP_ADDRESS', 'False',  15, 5, NULL, '', NULL, 'xtc_cfg_select_option(array(\'True\', \'False\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SESSION_RECREATE', 'False',  15, 7, NULL, '', NULL, 'xtc_cfg_select_option(array(\'True\', \'False\'),');

# configuration_group_id 16
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'META_MIN_KEYWORD_LENGTH', '6', 16, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'META_KEYWORDS_NUMBER', '5',  16, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'META_AUTHOR', '',  16, 4, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'META_PUBLISHER', '',  16, 5, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'META_COMPANY', '',  16, 6, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'META_TOPIC', 'shopping',  16, 7, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'META_REPLY_TO', 'xx@xx.com',  16, 8, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'META_REVISIT_AFTER', '14',  16, 9, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'META_ROBOTS', 'index,follow',  16, 10, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'META_DESCRIPTION', '',  16, 11, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'META_KEYWORDS', '',  16, 12, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CHECK_CLIENT_AGENT', 'false',16, 13, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');

# configuration_group_id 17
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'USE_WYSIWYG', 'true', 17, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACTIVATE_GIFT_SYSTEM', 'false', 17, 2, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SECURITY_CODE_LENGTH', '10', 17, 3, NULL, '2003-12-05 05:01:41', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'NEW_SIGNUP_GIFT_VOUCHER_AMOUNT', '0', 17, 4, NULL, '2003-12-05 05:01:41', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'NEW_SIGNUP_DISCOUNT_COUPON', '', 17, 5, NULL, '2003-12-05 05:01:41', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACTIVATE_SHIPPING_STATUS', 'true', 17, 6, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DISPLAY_CONDITIONS_ON_CHECKOUT', 'true',17, 7, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SHOW_IP_LOG', 'false',17, 8, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'GROUP_CHECK', 'false',  17, 9, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACTIVATE_NAVIGATOR', 'false',  17, 10, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'QUICKLINK_ACTIVATED', 'true',  17, 11, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACTIVATE_REVERSE_CROSS_SELLING', 'true', 17, 12, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');

#configuration_group_id 18
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_COMPANY_VAT_CHECK', 'true', 18, 4, '', '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_OWNER_VAT_ID', '', 18, 3, '', '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DEFAULT_CUSTOMERS_VAT_STATUS_ID', '1', 18, 23, '', '', 'xtc_get_customers_status_name', 'xtc_cfg_pull_down_customers_status_list(');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_COMPANY_VAT_LIVE_CHECK', 'true', 18, 4, '', '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_COMPANY_VAT_GROUP', 'true', 18, 4, '', '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_VAT_BLOCK_ERROR', 'true', 18, 4, '', '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL', '3', '18', '24', NULL , '', 'xtc_get_customers_status_name', 'xtc_cfg_pull_down_customers_status_list(');

#configuration_group_id 19
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'GOOGLE_CONVERSION_ID', '', '19', '2', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'GOOGLE_LANG', 'de', '19', '3', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'GOOGLE_CONVERSION', 'false', '19', '0', NULL , '0000-00-00 00:00:00', NULL , 'xtc_cfg_select_option(array(\'true\', \'false\'),');

#configuration_group_id 20
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CSV_TEXTSIGN', '"', '20', '1', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CSV_SEPERATOR', '\t', '20', '2', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'COMPRESS_EXPORT', 'false', '20', '3', NULL , '0000-00-00 00:00:00', NULL , 'xtc_cfg_select_option(array(\'true\', \'false\'),');

#configuration_group_id 21, Afterbuy
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'AFTERBUY_PARTNERID', '', '21', '2', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'AFTERBUY_PARTNERPASS', '', '21', '3', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'AFTERBUY_USERID', '', '21', '4', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'AFTERBUY_ORDERSTATUS', '1', '21', '5', NULL , '0000-00-00 00:00:00', 'xtc_get_order_status_name' , 'xtc_cfg_pull_down_order_statuses(');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'AFTERBUY_ACTIVATED', 'false', '21', '6', NULL , '0000-00-00 00:00:00', NULL , 'xtc_cfg_select_option(array(\'true\', \'false\'),');

#configuration_group_id 22, Search Options
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'SEARCH_IN_DESC', 'true', '22', '2', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'SEARCH_IN_ATTR', 'true', '22', '3', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');

INSERT INTO configuration_group VALUES ('1', 'My Store', 'General information about my store', '1', '1');
INSERT INTO configuration_group VALUES ('2', 'Minimum Values', 'The minimum values for functions / data', '2', '1');
INSERT INTO configuration_group VALUES ('3', 'Maximum Values', 'The maximum values for functions / data', '3', '1');
INSERT INTO configuration_group VALUES ('4', 'Images', 'Image parameters', '4', '1');
INSERT INTO configuration_group VALUES ('5', 'Customer Details', 'Customer account configuration', '5', '1');
INSERT INTO configuration_group VALUES ('6', 'Module Options', 'Hidden from configuration', '6', '0');
INSERT INTO configuration_group VALUES ('7', 'Shipping/Packaging', 'Shipping options available at my store', '7', '1');
INSERT INTO configuration_group VALUES ('8', 'Product Listing', 'Product Listing    configuration options', '8', '1');
INSERT INTO configuration_group VALUES ('9', 'Stock', 'Stock configuration options', '9', '1');
INSERT INTO configuration_group VALUES ('10', 'Logging', 'Logging configuration options', '10', '1');
INSERT INTO configuration_group VALUES ('11', 'Cache', 'Caching configuration options', '11', '1');
INSERT INTO configuration_group VALUES ('12', 'E-Mail Options', 'General setting for E-Mail transport and HTML E-Mails', '12', '1');
INSERT INTO configuration_group VALUES ('13', 'Download', 'Downloadable products options', '13', '1');
INSERT INTO configuration_group VALUES ('14', 'GZip Compression', 'GZip compression options', '14', '1');
INSERT INTO configuration_group VALUES ('15', 'Sessions', 'Session options', '15', '1');
INSERT INTO configuration_group VALUES ('16', 'Meta-Tags/Search engines', 'Meta-tags/Search engines', '16', '1');
INSERT INTO configuration_group VALUES ('18', 'Vat ID', 'Vat ID', '18', '1');
INSERT INTO configuration_group VALUES ('19', 'Google Conversion', 'Google Conversion-Tracking', '19', '1');
INSERT INTO configuration_group VALUES ('20', 'Import/Export', 'Import/Export', '20', '1');
INSERT INTO configuration_group VALUES ('21', 'Afterbuy', 'Afterbuy.de', '21', '1');
INSERT INTO configuration_group VALUES ('22', 'Search Options', 'Additional Options for search function', '22', '1');

DROP TABLE IF EXISTS countries;
CREATE TABLE countries (
  countries_id int NOT NULL auto_increment,
  countries_name varchar(64) NOT NULL,
  countries_iso_code_2 char(2) NOT NULL,
  countries_iso_code_3 char(3) NOT NULL,
  address_format_id int NOT NULL,
  status int(1) DEFAULT '1' NULL,  
  PRIMARY KEY (countries_id),
  KEY IDX_COUNTRIES_NAME (countries_name)
);
INSERT INTO countries VALUES (1,'Afghanistan','AF','AFG','1','1');
INSERT INTO countries VALUES (2,'Albania','AL','ALB','1','1');
INSERT INTO countries VALUES (3,'Algeria','DZ','DZA','1','1');
INSERT INTO countries VALUES (4,'American Samoa','AS','ASM','1','1');
INSERT INTO countries VALUES (5,'Andorra','AD','AND','1','1');
INSERT INTO countries VALUES (6,'Angola','AO','AGO','1','1');
INSERT INTO countries VALUES (7,'Anguilla','AI','AIA','1','1');
INSERT INTO countries VALUES (8,'Antarctica','AQ','ATA','1','1');
INSERT INTO countries VALUES (9,'Antigua and Barbuda','AG','ATG','1','1');
INSERT INTO countries VALUES (10,'Argentina','AR','ARG','1','1');
INSERT INTO countries VALUES (11,'Armenia','AM','ARM','1','1');
INSERT INTO countries VALUES (12,'Aruba','AW','ABW','1','1');
INSERT INTO countries VALUES (13,'Australia','AU','AUS','1','1');
INSERT INTO countries VALUES (14,'Austria','AT','AUT','5','1');
INSERT INTO countries VALUES (15,'Azerbaijan','AZ','AZE','1','1');
INSERT INTO countries VALUES (16,'Bahamas','BS','BHS','1','1');
INSERT INTO countries VALUES (17,'Bahrain','BH','BHR','1','1');
INSERT INTO countries VALUES (18,'Bangladesh','BD','BGD','1','1');
INSERT INTO countries VALUES (19,'Barbados','BB','BRB','1','1');
INSERT INTO countries VALUES (20,'Belarus','BY','BLR','1','1');
INSERT INTO countries VALUES (21,'Belgium','BE','BEL','1','1');
INSERT INTO countries VALUES (22,'Belize','BZ','BLZ','1','1');
INSERT INTO countries VALUES (23,'Benin','BJ','BEN','1','1');
INSERT INTO countries VALUES (24,'Bermuda','BM','BMU','1','1');
INSERT INTO countries VALUES (25,'Bhutan','BT','BTN','1','1');
INSERT INTO countries VALUES (26,'Bolivia','BO','BOL','1','1');
INSERT INTO countries VALUES (27,'Bosnia and Herzegowina','BA','BIH','1','1');
INSERT INTO countries VALUES (28,'Botswana','BW','BWA','1','1');
INSERT INTO countries VALUES (29,'Bouvet Island','BV','BVT','1','1');
INSERT INTO countries VALUES (30,'Brazil','BR','BRA','1','1');
INSERT INTO countries VALUES (31,'British Indian Ocean Territory','IO','IOT','1','1');
INSERT INTO countries VALUES (32,'Brunei Darussalam','BN','BRN','1','1');
INSERT INTO countries VALUES (33,'Bulgaria','BG','BGR','1','1');
INSERT INTO countries VALUES (34,'Burkina Faso','BF','BFA','1','1');
INSERT INTO countries VALUES (35,'Burundi','BI','BDI','1','1');
INSERT INTO countries VALUES (36,'Cambodia','KH','KHM','1','1');
INSERT INTO countries VALUES (37,'Cameroon','CM','CMR','1','1');
INSERT INTO countries VALUES (38,'Canada','CA','CAN','1','1');
INSERT INTO countries VALUES (39,'Cape Verde','CV','CPV','1','1');
INSERT INTO countries VALUES (40,'Cayman Islands','KY','CYM','1','1');
INSERT INTO countries VALUES (41,'Central African Republic','CF','CAF','1','1');
INSERT INTO countries VALUES (42,'Chad','TD','TCD','1','1');
INSERT INTO countries VALUES (43,'Chile','CL','CHL','1','1');
INSERT INTO countries VALUES (44,'China','CN','CHN','1','1');
INSERT INTO countries VALUES (45,'Christmas Island','CX','CXR','1','1');
INSERT INTO countries VALUES (46,'Cocos (Keeling) Islands','CC','CCK','1','1');
INSERT INTO countries VALUES (47,'Colombia','CO','COL','1','1');
INSERT INTO countries VALUES (48,'Comoros','KM','COM','1','1');
INSERT INTO countries VALUES (49,'Congo','CG','COG','1','1');
INSERT INTO countries VALUES (50,'Cook Islands','CK','COK','1','1');
INSERT INTO countries VALUES (51,'Costa Rica','CR','CRI','1','1');
INSERT INTO countries VALUES (52,'Cote D\'Ivoire','CI','CIV','1','1');
INSERT INTO countries VALUES (53,'Croatia','HR','HRV','1','1');
INSERT INTO countries VALUES (54,'Cuba','CU','CUB','1','1');
INSERT INTO countries VALUES (55,'Cyprus','CY','CYP','1','1');
INSERT INTO countries VALUES (56,'Czech Republic','CZ','CZE','1','1');
INSERT INTO countries VALUES (57,'Denmark','DK','DNK','1','1');
INSERT INTO countries VALUES (58,'Djibouti','DJ','DJI','1','1');
INSERT INTO countries VALUES (59,'Dominica','DM','DMA','1','1');
INSERT INTO countries VALUES (60,'Dominican Republic','DO','DOM','1','1');
INSERT INTO countries VALUES (61,'East Timor','TP','TMP','1','1');
INSERT INTO countries VALUES (62,'Ecuador','EC','ECU','1','1');
INSERT INTO countries VALUES (63,'Egypt','EG','EGY','1','1');
INSERT INTO countries VALUES (64,'El Salvador','SV','SLV','1','1');
INSERT INTO countries VALUES (65,'Equatorial Guinea','GQ','GNQ','1','1');
INSERT INTO countries VALUES (66,'Eritrea','ER','ERI','1','1');
INSERT INTO countries VALUES (67,'Estonia','EE','EST','1','1');
INSERT INTO countries VALUES (68,'Ethiopia','ET','ETH','1','1');
INSERT INTO countries VALUES (69,'Falkland Islands (Malvinas)','FK','FLK','1','1');
INSERT INTO countries VALUES (70,'Faroe Islands','FO','FRO','1','1');
INSERT INTO countries VALUES (71,'Fiji','FJ','FJI','1','1');
INSERT INTO countries VALUES (72,'Finland','FI','FIN','1','1');
INSERT INTO countries VALUES (73,'France','FR','FRA','1','1');
INSERT INTO countries VALUES (74,'France, Metropolitan','FX','FXX','1','1');
INSERT INTO countries VALUES (75,'French Guiana','GF','GUF','1','1');
INSERT INTO countries VALUES (76,'French Polynesia','PF','PYF','1','1');
INSERT INTO countries VALUES (77,'French Southern Territories','TF','ATF','1','1');
INSERT INTO countries VALUES (78,'Gabon','GA','GAB','1','1');
INSERT INTO countries VALUES (79,'Gambia','GM','GMB','1','1');
INSERT INTO countries VALUES (80,'Georgia','GE','GEO','1','1');
INSERT INTO countries VALUES (81,'Germany','DE','DEU','5','1');
INSERT INTO countries VALUES (82,'Ghana','GH','GHA','1','1');
INSERT INTO countries VALUES (83,'Gibraltar','GI','GIB','1','1');
INSERT INTO countries VALUES (84,'Greece','GR','GRC','1','1');
INSERT INTO countries VALUES (85,'Greenland','GL','GRL','1','1');
INSERT INTO countries VALUES (86,'Grenada','GD','GRD','1','1');
INSERT INTO countries VALUES (87,'Guadeloupe','GP','GLP','1','1');
INSERT INTO countries VALUES (88,'Guam','GU','GUM','1','1');
INSERT INTO countries VALUES (89,'Guatemala','GT','GTM','1','1');
INSERT INTO countries VALUES (90,'Guinea','GN','GIN','1','1');
INSERT INTO countries VALUES (91,'Guinea-bissau','GW','GNB','1','1');
INSERT INTO countries VALUES (92,'Guyana','GY','GUY','1','1');
INSERT INTO countries VALUES (93,'Haiti','HT','HTI','1','1');
INSERT INTO countries VALUES (94,'Heard and Mc Donald Islands','HM','HMD','1','1');
INSERT INTO countries VALUES (95,'Honduras','HN','HND','1','1');
INSERT INTO countries VALUES (96,'Hong Kong','HK','HKG','1','1');
INSERT INTO countries VALUES (97,'Hungary','HU','HUN','1','1');
INSERT INTO countries VALUES (98,'Iceland','IS','ISL','1','1');
INSERT INTO countries VALUES (99,'India','IN','IND','1','1');
INSERT INTO countries VALUES (100,'Indonesia','ID','IDN','1','1');
INSERT INTO countries VALUES (101,'Iran (Islamic Republic of)','IR','IRN','1','1');
INSERT INTO countries VALUES (102,'Iraq','IQ','IRQ','1','1');
INSERT INTO countries VALUES (103,'Ireland','IE','IRL','1','1');
INSERT INTO countries VALUES (104,'Israel','IL','ISR','1','1');
INSERT INTO countries VALUES (105,'Italy','IT','ITA','1','1');
INSERT INTO countries VALUES (106,'Jamaica','JM','JAM','1','1');
INSERT INTO countries VALUES (107,'Japan','JP','JPN','1','1');
INSERT INTO countries VALUES (108,'Jordan','JO','JOR','1','1');
INSERT INTO countries VALUES (109,'Kazakhstan','KZ','KAZ','1','1');
INSERT INTO countries VALUES (110,'Kenya','KE','KEN','1','1');
INSERT INTO countries VALUES (111,'Kiribati','KI','KIR','1','1');
INSERT INTO countries VALUES (112,'Korea, Democratic People\'s Republic of','KP','PRK','1','1');
INSERT INTO countries VALUES (113,'Korea, Republic of','KR','KOR','1','1');
INSERT INTO countries VALUES (114,'Kuwait','KW','KWT','1','1');
INSERT INTO countries VALUES (115,'Kyrgyzstan','KG','KGZ','1','1');
INSERT INTO countries VALUES (116,'Lao People\'s Democratic Republic','LA','LAO','1','1');
INSERT INTO countries VALUES (117,'Latvia','LV','LVA','1','1');
INSERT INTO countries VALUES (118,'Lebanon','LB','LBN','1','1');
INSERT INTO countries VALUES (119,'Lesotho','LS','LSO','1','1');
INSERT INTO countries VALUES (120,'Liberia','LR','LBR','1','1');
INSERT INTO countries VALUES (121,'Libyan Arab Jamahiriya','LY','LBY','1','1');
INSERT INTO countries VALUES (122,'Liechtenstein','LI','LIE','1','1');
INSERT INTO countries VALUES (123,'Lithuania','LT','LTU','1','1');
INSERT INTO countries VALUES (124,'Luxembourg','LU','LUX','1','1');
INSERT INTO countries VALUES (125,'Macau','MO','MAC','1','1');
INSERT INTO countries VALUES (126,'Macedonia, The Former Yugoslav Republic of','MK','MKD','1','1');
INSERT INTO countries VALUES (127,'Madagascar','MG','MDG','1','1');
INSERT INTO countries VALUES (128,'Malawi','MW','MWI','1','1');
INSERT INTO countries VALUES (129,'Malaysia','MY','MYS','1','1');
INSERT INTO countries VALUES (130,'Maldives','MV','MDV','1','1');
INSERT INTO countries VALUES (131,'Mali','ML','MLI','1','1');
INSERT INTO countries VALUES (132,'Malta','MT','MLT','1','1');
INSERT INTO countries VALUES (133,'Marshall Islands','MH','MHL','1','1');
INSERT INTO countries VALUES (134,'Martinique','MQ','MTQ','1','1');
INSERT INTO countries VALUES (135,'Mauritania','MR','MRT','1','1');
INSERT INTO countries VALUES (136,'Mauritius','MU','MUS','1','1');
INSERT INTO countries VALUES (137,'Mayotte','YT','MYT','1','1');
INSERT INTO countries VALUES (138,'Mexico','MX','MEX','1','1');
INSERT INTO countries VALUES (139,'Micronesia, Federated States of','FM','FSM','1','1');
INSERT INTO countries VALUES (140,'Moldova, Republic of','MD','MDA','1','1');
INSERT INTO countries VALUES (141,'Monaco','MC','MCO','1','1');
INSERT INTO countries VALUES (142,'Mongolia','MN','MNG','1','1');
INSERT INTO countries VALUES (143,'Montserrat','MS','MSR','1','1');
INSERT INTO countries VALUES (144,'Morocco','MA','MAR','1','1');
INSERT INTO countries VALUES (145,'Mozambique','MZ','MOZ','1','1');
INSERT INTO countries VALUES (146,'Myanmar','MM','MMR','1','1');
INSERT INTO countries VALUES (147,'Namibia','NA','NAM','1','1');
INSERT INTO countries VALUES (148,'Nauru','NR','NRU','1','1');
INSERT INTO countries VALUES (149,'Nepal','NP','NPL','1','1');
INSERT INTO countries VALUES (150,'Netherlands','NL','NLD','1','1');
INSERT INTO countries VALUES (151,'Netherlands Antilles','AN','ANT','1','1');
INSERT INTO countries VALUES (152,'New Caledonia','NC','NCL','1','1');
INSERT INTO countries VALUES (153,'New Zealand','NZ','NZL','1','1');
INSERT INTO countries VALUES (154,'Nicaragua','NI','NIC','1','1');
INSERT INTO countries VALUES (155,'Niger','NE','NER','1','1');
INSERT INTO countries VALUES (156,'Nigeria','NG','NGA','1','1');
INSERT INTO countries VALUES (157,'Niue','NU','NIU','1','1');
INSERT INTO countries VALUES (158,'Norfolk Island','NF','NFK','1','1');
INSERT INTO countries VALUES (159,'Northern Mariana Islands','MP','MNP','1','1');
INSERT INTO countries VALUES (160,'Norway','NO','NOR','1','1');
INSERT INTO countries VALUES (161,'Oman','OM','OMN','1','1');
INSERT INTO countries VALUES (162,'Pakistan','PK','PAK','1','1');
INSERT INTO countries VALUES (163,'Palau','PW','PLW','1','1');
INSERT INTO countries VALUES (164,'Panama','PA','PAN','1','1');
INSERT INTO countries VALUES (165,'Papua New Guinea','PG','PNG','1','1');
INSERT INTO countries VALUES (166,'Paraguay','PY','PRY','1','1');
INSERT INTO countries VALUES (167,'Peru','PE','PER','1','1');
INSERT INTO countries VALUES (168,'Philippines','PH','PHL','1','1');
INSERT INTO countries VALUES (169,'Pitcairn','PN','PCN','1','1');
INSERT INTO countries VALUES (170,'Poland','PL','POL','1','1');
INSERT INTO countries VALUES (171,'Portugal','PT','PRT','1','1');
INSERT INTO countries VALUES (172,'Puerto Rico','PR','PRI','1','1');
INSERT INTO countries VALUES (173,'Qatar','QA','QAT','1','1');
INSERT INTO countries VALUES (174,'Reunion','RE','REU','1','1');
INSERT INTO countries VALUES (175,'Romania','RO','ROM','1','1');
INSERT INTO countries VALUES (176,'Russian Federation','RU','RUS','1','1');
INSERT INTO countries VALUES (177,'Rwanda','RW','RWA','1','1');
INSERT INTO countries VALUES (178,'Saint Kitts and Nevis','KN','KNA','1','1');
INSERT INTO countries VALUES (179,'Saint Lucia','LC','LCA','1','1');
INSERT INTO countries VALUES (180,'Saint Vincent and the Grenadines','VC','VCT','1','1');
INSERT INTO countries VALUES (181,'Samoa','WS','WSM','1','1');
INSERT INTO countries VALUES (182,'San Marino','SM','SMR','1','1');
INSERT INTO countries VALUES (183,'Sao Tome and Principe','ST','STP','1','1');
INSERT INTO countries VALUES (184,'Saudi Arabia','SA','SAU','1','1');
INSERT INTO countries VALUES (185,'Senegal','SN','SEN','1','1');
INSERT INTO countries VALUES (186,'Seychelles','SC','SYC','1','1');
INSERT INTO countries VALUES (187,'Sierra Leone','SL','SLE','1','1');
INSERT INTO countries VALUES (188,'Singapore','SG','SGP', '4','1');
INSERT INTO countries VALUES (189,'Slovakia (Slovak Republic)','SK','SVK','1','1');
INSERT INTO countries VALUES (190,'Slovenia','SI','SVN','1','1');
INSERT INTO countries VALUES (191,'Solomon Islands','SB','SLB','1','1');
INSERT INTO countries VALUES (192,'Somalia','SO','SOM','1','1');
INSERT INTO countries VALUES (193,'South Africa','ZA','ZAF','1','1');
INSERT INTO countries VALUES (194,'South Georgia and the South Sandwich Islands','GS','SGS','1','1');
INSERT INTO countries VALUES (195,'Spain','ES','ESP','3','1');
INSERT INTO countries VALUES (196,'Sri Lanka','LK','LKA','1','1');
INSERT INTO countries VALUES (197,'St. Helena','SH','SHN','1','1');
INSERT INTO countries VALUES (198,'St. Pierre and Miquelon','PM','SPM','1','1');
INSERT INTO countries VALUES (199,'Sudan','SD','SDN','1','1');
INSERT INTO countries VALUES (200,'Suriname','SR','SUR','1','1');
INSERT INTO countries VALUES (201,'Svalbard and Jan Mayen Islands','SJ','SJM','1','1');
INSERT INTO countries VALUES (202,'Swaziland','SZ','SWZ','1','1');
INSERT INTO countries VALUES (203,'Sweden','SE','SWE','1','1');
INSERT INTO countries VALUES (204,'Switzerland','CH','CHE','1','1');
INSERT INTO countries VALUES (205,'Syrian Arab Republic','SY','SYR','1','1');
INSERT INTO countries VALUES (206,'Taiwan','TW','TWN','1','1');
INSERT INTO countries VALUES (207,'Tajikistan','TJ','TJK','1','1');
INSERT INTO countries VALUES (208,'Tanzania, United Republic of','TZ','TZA','1','1');
INSERT INTO countries VALUES (209,'Thailand','TH','THA','1','1');
INSERT INTO countries VALUES (210,'Togo','TG','TGO','1','1');
INSERT INTO countries VALUES (211,'Tokelau','TK','TKL','1','1');
INSERT INTO countries VALUES (212,'Tonga','TO','TON','1','1');
INSERT INTO countries VALUES (213,'Trinidad and Tobago','TT','TTO','1','1');
INSERT INTO countries VALUES (214,'Tunisia','TN','TUN','1','1');
INSERT INTO countries VALUES (215,'Turkey','TR','TUR','1','1');
INSERT INTO countries VALUES (216,'Turkmenistan','TM','TKM','1','1');
INSERT INTO countries VALUES (217,'Turks and Caicos Islands','TC','TCA','1','1');
INSERT INTO countries VALUES (218,'Tuvalu','TV','TUV','1','1');
INSERT INTO countries VALUES (219,'Uganda','UG','UGA','1','1');
INSERT INTO countries VALUES (220,'Ukraine','UA','UKR','1','1');
INSERT INTO countries VALUES (221,'United Arab Emirates','AE','ARE','1','1');
INSERT INTO countries VALUES (222,'United Kingdom','GB','GBR','1','1');
INSERT INTO countries VALUES (223,'United States','US','USA', '2','1');
INSERT INTO countries VALUES (224,'United States Minor Outlying Islands','UM','UMI','1','1');
INSERT INTO countries VALUES (225,'Uruguay','UY','URY','1','1');
INSERT INTO countries VALUES (226,'Uzbekistan','UZ','UZB','1','1');
INSERT INTO countries VALUES (227,'Vanuatu','VU','VUT','1','1');
INSERT INTO countries VALUES (228,'Vatican City State (Holy See)','VA','VAT','1','1');
INSERT INTO countries VALUES (229,'Venezuela','VE','VEN','1','1');
INSERT INTO countries VALUES (230,'Viet Nam','VN','VNM','1','1');
INSERT INTO countries VALUES (231,'Virgin Islands (British)','VG','VGB','1','1');
INSERT INTO countries VALUES (232,'Virgin Islands (U.S.)','VI','VIR','1','1');
INSERT INTO countries VALUES (233,'Wallis and Futuna Islands','WF','WLF','1','1');
INSERT INTO countries VALUES (234,'Western Sahara','EH','ESH','1','1');
INSERT INTO countries VALUES (235,'Yemen','YE','YEM','1','1');
INSERT INTO countries VALUES (236,'Yugoslavia','YU','YUG','1','1');
INSERT INTO countries VALUES (237,'Zaire','ZR','ZAR','1','1');
INSERT INTO countries VALUES (238,'Zambia','ZM','ZMB','1','1');
INSERT INTO countries VALUES (239,'Zimbabwe','ZW','ZWE','1','1');

INSERT INTO currencies VALUES (1,'Euro','EUR','','EUR',',','.','2','1.0000', now());


INSERT INTO languages VALUES (1,'Ðóññêèé','ru','icon.gif','russian',1,'windows-1251');
INSERT INTO languages VALUES (2,'English','en','icon.gif','english',2,'iso-8859-15');


INSERT INTO orders_status VALUES ( '1', '1', 'Îæèäàåò ïðîâåðêè');
INSERT INTO orders_status VALUES ( '1', '2', 'Pending');
INSERT INTO orders_status VALUES ( '2', '1', 'Æä¸ì îïëàòû');
INSERT INTO orders_status VALUES ( '2', '2', 'Waiting approval');
INSERT INTO orders_status VALUES ( '3', '1', 'Âûïîëíÿåòñÿ');
INSERT INTO orders_status VALUES ( '3', '2', 'Processing');
INSERT INTO orders_status VALUES ( '4', '1', 'Äîñòàâëÿåòñÿ');
INSERT INTO orders_status VALUES ( '4', '2', 'Delivering');
INSERT INTO orders_status VALUES ( '5', '1', 'Äîñòàâëåí');
INSERT INTO orders_status VALUES ( '5', '2', 'Delivered');
INSERT INTO orders_status VALUES ( '6', '1', 'Îòìåí¸í');
INSERT INTO orders_status VALUES ( '6', '2', 'Canceled');



# USA
INSERT INTO zones VALUES (1,223,'AL','Alabama');
INSERT INTO zones VALUES (2,223,'AK','Alaska');
INSERT INTO zones VALUES (3,223,'AS','American Samoa');
INSERT INTO zones VALUES (4,223,'AZ','Arizona');
INSERT INTO zones VALUES (5,223,'AR','Arkansas');
INSERT INTO zones VALUES (6,223,'AF','Armed Forces Africa');
INSERT INTO zones VALUES (7,223,'AA','Armed Forces Americas');
INSERT INTO zones VALUES (8,223,'AC','Armed Forces Canada');
INSERT INTO zones VALUES (9,223,'AE','Armed Forces Europe');
INSERT INTO zones VALUES (10,223,'AM','Armed Forces Middle East');
INSERT INTO zones VALUES (11,223,'AP','Armed Forces Pacific');
INSERT INTO zones VALUES (12,223,'CA','California');
INSERT INTO zones VALUES (13,223,'CO','Colorado');
INSERT INTO zones VALUES (14,223,'CT','Connecticut');
INSERT INTO zones VALUES (15,223,'DE','Delaware');
INSERT INTO zones VALUES (16,223,'DC','District of Columbia');
INSERT INTO zones VALUES (17,223,'FM','Federated States Of Micronesia');
INSERT INTO zones VALUES (18,223,'FL','Florida');
INSERT INTO zones VALUES (19,223,'GA','Georgia');
INSERT INTO zones VALUES (20,223,'GU','Guam');
INSERT INTO zones VALUES (21,223,'HI','Hawaii');
INSERT INTO zones VALUES (22,223,'ID','Idaho');
INSERT INTO zones VALUES (23,223,'IL','Illinois');
INSERT INTO zones VALUES (24,223,'IN','Indiana');
INSERT INTO zones VALUES (25,223,'IA','Iowa');
INSERT INTO zones VALUES (26,223,'KS','Kansas');
INSERT INTO zones VALUES (27,223,'KY','Kentucky');
INSERT INTO zones VALUES (28,223,'LA','Louisiana');
INSERT INTO zones VALUES (29,223,'ME','Maine');
INSERT INTO zones VALUES (30,223,'MH','Marshall Islands');
INSERT INTO zones VALUES (31,223,'MD','Maryland');
INSERT INTO zones VALUES (32,223,'MA','Massachusetts');
INSERT INTO zones VALUES (33,223,'MI','Michigan');
INSERT INTO zones VALUES (34,223,'MN','Minnesota');
INSERT INTO zones VALUES (35,223,'MS','Mississippi');
INSERT INTO zones VALUES (36,223,'MO','Missouri');
INSERT INTO zones VALUES (37,223,'MT','Montana');
INSERT INTO zones VALUES (38,223,'NE','Nebraska');
INSERT INTO zones VALUES (39,223,'NV','Nevada');
INSERT INTO zones VALUES (40,223,'NH','New Hampshire');
INSERT INTO zones VALUES (41,223,'NJ','New Jersey');
INSERT INTO zones VALUES (42,223,'NM','New Mexico');
INSERT INTO zones VALUES (43,223,'NY','New York');
INSERT INTO zones VALUES (44,223,'NC','North Carolina');
INSERT INTO zones VALUES (45,223,'ND','North Dakota');
INSERT INTO zones VALUES (46,223,'MP','Northern Mariana Islands');
INSERT INTO zones VALUES (47,223,'OH','Ohio');
INSERT INTO zones VALUES (48,223,'OK','Oklahoma');
INSERT INTO zones VALUES (49,223,'OR','Oregon');
INSERT INTO zones VALUES (50,223,'PW','Palau');
INSERT INTO zones VALUES (51,223,'PA','Pennsylvania');
INSERT INTO zones VALUES (52,223,'PR','Puerto Rico');
INSERT INTO zones VALUES (53,223,'RI','Rhode Island');
INSERT INTO zones VALUES (54,223,'SC','South Carolina');
INSERT INTO zones VALUES (55,223,'SD','South Dakota');
INSERT INTO zones VALUES (56,223,'TN','Tennessee');
INSERT INTO zones VALUES (57,223,'TX','Texas');
INSERT INTO zones VALUES (58,223,'UT','Utah');
INSERT INTO zones VALUES (59,223,'VT','Vermont');
INSERT INTO zones VALUES (60,223,'VI','Virgin Islands');
INSERT INTO zones VALUES (61,223,'VA','Virginia');
INSERT INTO zones VALUES (62,223,'WA','Washington');
INSERT INTO zones VALUES (63,223,'WV','West Virginia');
INSERT INTO zones VALUES (64,223,'WI','Wisconsin');
INSERT INTO zones VALUES (65,223,'WY','Wyoming');

# Canada
INSERT INTO zones VALUES (66,38,'AB','Alberta');
INSERT INTO zones VALUES (67,38,'BC','British Columbia');
INSERT INTO zones VALUES (68,38,'MB','Manitoba');
INSERT INTO zones VALUES (69,38,'NF','Newfoundland');
INSERT INTO zones VALUES (70,38,'NB','New Brunswick');
INSERT INTO zones VALUES (71,38,'NS','Nova Scotia');
INSERT INTO zones VALUES (72,38,'NT','Northwest Territories');
INSERT INTO zones VALUES (73,38,'NU','Nunavut');
INSERT INTO zones VALUES (74,38,'ON','Ontario');
INSERT INTO zones VALUES (75,38,'PE','Prince Edward Island');
INSERT INTO zones VALUES (76,38,'QC','Quebec');
INSERT INTO zones VALUES (77,38,'SK','Saskatchewan');
INSERT INTO zones VALUES (78,38,'YT','Yukon Territory');

# Germany
INSERT INTO zones VALUES (79,81,'NDS','Niedersachsen');
INSERT INTO zones VALUES (80,81,'BAW','Baden-Württemberg');
INSERT INTO zones VALUES (81,81,'BAY','Bayern');
INSERT INTO zones VALUES (82,81,'BER','Berlin');
INSERT INTO zones VALUES (83,81,'BRG','Brandenburg');
INSERT INTO zones VALUES (84,81,'BRE','Bremen');
INSERT INTO zones VALUES (85,81,'HAM','Hamburg');
INSERT INTO zones VALUES (86,81,'HES','Hessen');
INSERT INTO zones VALUES (87,81,'MEC','Mecklenburg-Vorpommern');
INSERT INTO zones VALUES (88,81,'NRW','Nordrhein-Westfalen');
INSERT INTO zones VALUES (89,81,'RHE','Rheinland-Pfalz');
INSERT INTO zones VALUES (90,81,'SAR','Saarland');
INSERT INTO zones VALUES (91,81,'SAS','Sachsen');
INSERT INTO zones VALUES (92,81,'SAC','Sachsen-Anhalt');
INSERT INTO zones VALUES (93,81,'SCN','Schleswig-Holstein');
INSERT INTO zones VALUES (94,81,'THE','Thüringen');

# Austria
INSERT INTO zones VALUES (95,14,'WI','Wien');
INSERT INTO zones VALUES (96,14,'NO','Niederösterreich');
INSERT INTO zones VALUES (97,14,'OO','Oberösterreich');
INSERT INTO zones VALUES (98,14,'SB','Salzburg');
INSERT INTO zones VALUES (99,14,'KN','Kärnten');
INSERT INTO zones VALUES (100,14,'ST','Steiermark');
INSERT INTO zones VALUES (101,14,'TI','Tirol');
INSERT INTO zones VALUES (102,14,'BL','Burgenland');
INSERT INTO zones VALUES (103,14,'VB','Voralberg');

# Swizterland
INSERT INTO zones VALUES (104,204,'AG','Aargau');
INSERT INTO zones VALUES (105,204,'AI','Appenzell Innerrhoden');
INSERT INTO zones VALUES (106,204,'AR','Appenzell Ausserrhoden');
INSERT INTO zones VALUES (107,204,'BE','Bern');
INSERT INTO zones VALUES (108,204,'BL','Basel-Landschaft');
INSERT INTO zones VALUES (109,204,'BS','Basel-Stadt');
INSERT INTO zones VALUES (110,204,'FR','Freiburg');
INSERT INTO zones VALUES (111,204,'GE','Genf');
INSERT INTO zones VALUES (112,204,'GL','Glarus');
INSERT INTO zones VALUES (113,204,'JU','Graubünden');
INSERT INTO zones VALUES (114,204,'JU','Jura');
INSERT INTO zones VALUES (115,204,'LU','Luzern');
INSERT INTO zones VALUES (116,204,'NE','Neuenburg');
INSERT INTO zones VALUES (117,204,'NW','Nidwalden');
INSERT INTO zones VALUES (118,204,'OW','Obwalden');
INSERT INTO zones VALUES (119,204,'SG','St. Gallen');
INSERT INTO zones VALUES (120,204,'SH','Schaffhausen');
INSERT INTO zones VALUES (121,204,'SO','Solothurn');
INSERT INTO zones VALUES (122,204,'SZ','Schwyz');
INSERT INTO zones VALUES (123,204,'TG','Thurgau');
INSERT INTO zones VALUES (124,204,'TI','Tessin');
INSERT INTO zones VALUES (125,204,'UR','Uri');
INSERT INTO zones VALUES (126,204,'VD','Waadt');
INSERT INTO zones VALUES (127,204,'VS','Wallis');
INSERT INTO zones VALUES (128,204,'ZG','Zug');
INSERT INTO zones VALUES (129,204,'ZH','Zürich');

# Spain
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'A Coruña','A Coruña');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Alava','Alava');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Albacete','Albacete');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Alicante','Alicante');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Almeria','Almeria');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Asturias','Asturias');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Avila','Avila');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Badajoz','Badajoz');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Baleares','Baleares');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Barcelona','Barcelona');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Burgos','Burgos');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Caceres','Caceres');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Cadiz','Cadiz');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Cantabria','Cantabria');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Castellon','Castellon');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Ceuta','Ceuta');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Ciudad Real','Ciudad Real');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Cordoba','Cordoba');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Cuenca','Cuenca');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Girona','Girona');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Granada','Granada');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Guadalajara','Guadalajara');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Guipuzcoa','Guipuzcoa');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Huelva','Huelva');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Huesca','Huesca');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Jaen','Jaen');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'La Rioja','La Rioja');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Las Palmas','Las Palmas');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Leon','Leon');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Lleida','Lleida');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Lugo','Lugo');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Madrid','Madrid');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Malaga','Malaga');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Melilla','Melilla');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Murcia','Murcia');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Navarra','Navarra');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Ourense','Ourense');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Palencia','Palencia');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Pontevedra','Pontevedra');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Salamanca','Salamanca');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Santa Cruz de Tenerife','Santa Cruz de Tenerife');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Segovia','Segovia');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Sevilla','Sevilla');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Soria','Soria');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Tarragona','Tarragona');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Teruel','Teruel');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Toledo','Toledo');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Valencia','Valencia');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Valladolid','Valladolid');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Vizcaya','Vizcaya');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Zamora','Zamora');
INSERT INTO zones (zone_country_id, zone_code, zone_name) VALUES (195,'Zaragoza','Zaragoza');

#Australia
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',13,'NSW','New South Wales');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',13,'VIC','Victoria');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',13,'QLD','Queensland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',13,'NT','Northern Territory');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',13,'WA','Western Australia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',13,'SA','South Australia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',13,'TAS','Tasmania');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',13,'ACT','Australian Capital Territory');

#New Zealand
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Northland','Northland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Auckland','Auckland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Waikato','Waikato');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Bay of Plenty','Bay of Plenty');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Gisborne','Gisborne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Hawkes Bay','Hawkes Bay');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Taranaki','Taranaki');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Manawatu-Wanganui','Manawatu-Wanganui');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Wellington','Wellington');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'West Coast','West Coast');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Canterbury','Canterbury');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Otago','Otago');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Southland','Southland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Tasman','Tasman');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Nelson','Nelson');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',153,'Marlborough','Marlborough');

#Brazil
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'SP', 'São Paulo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'RJ', 'Rio de Janeiro');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'PE', 'Pernanbuco');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'BA', 'Bahia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'AM', 'Amazonas');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'MG', 'Minas Gerais');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'ES', 'Espirito Santo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'RS', 'Rio Grande do Sul');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'PR', 'Paraná');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'SC', 'Santa Catarina');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'RG', 'Rio Grande do Norte');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'MS', 'Mato Grosso do Sul');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'MT', 'Mato Grosso');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'GO', 'Goias');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'TO', 'Tocantins');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'DF', 'Distrito Federal');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'RO', 'Rondonia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'AC', 'Acre');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'AP', 'Amapa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'RO', 'Roraima');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'AL', 'Alagoas');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'CE', 'Ceará');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'MA', 'Maranhão');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'PA', 'Pará');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'PB', 'Paraíba');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'PI', 'Piauí');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '30', 'SE', 'Sergipe');

#Chile
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '43', 'I', 'I Región de Tarapacá');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '43', 'II', 'II Región de Antofagasta');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '43', 'III', 'III Región de Atacama');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '43', 'IV', 'IV Región de Coquimbo');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '43', 'V', 'V Región de Valaparaíso');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '43', 'RM', 'Región Metropolitana');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '43', 'VI', 'VI Región de L. B. O´higgins');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '43', 'VII', 'VII Región del Maule');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '43', 'VIII', 'VIII Región del Bío Bío');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '43', 'IX', 'IX Región de la Araucanía');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '43', 'X', 'X Región de los Lagos');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '43', 'XI', 'XI Región de Aysén');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '43', 'XII', 'XII Región de Magallanes');

#Columbia
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'AMA','Amazonas');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'ANT','Antioquia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'ARA','Arauca');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'ATL','Atlantico');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'BOL','Bolivar');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'BOY','Boyaca');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'CAL','Caldas');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'CAQ','Caqueta');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'CAS','Casanare');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'CAU','Cauca');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'CES','Cesar');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'CHO','Choco');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'COR','Cordoba');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'CUN','Cundinamarca');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'HUI','Huila');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'GUA','Guainia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'GUA','Guajira');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'GUV','Guaviare');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'MAG','Magdalena');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'MET','Meta');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'NAR','Narino');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'NDS','Norte de Santander');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'PUT','Putumayo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'QUI','Quindio');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'RIS','Risaralda');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'SAI','San Andres Islas');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'SAN','Santander');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'SUC','Sucre');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'TOL','Tolima');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'VAL','Valle');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'VAU','Vaupes');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',47,'VIC','Vichada');

#France
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'Et','Etranger');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'01','Ain');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'02','Aisne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'03','Allier');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'04','Alpes de Haute Provence');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'05','Hautes-Alpes');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'06','Alpes Maritimes');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'07','Ard?che');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'08','Ardennes');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'09','Ari?ge');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'10','Aube');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'11','Aude');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'12','Aveyron');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'13','Bouches du RhÃ´ne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'14','Calvados');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'15','Cantal');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'16','Charente');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'17','Charente Maritime');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'18','Cher');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'19','Corr?ze');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'2A','Corse du Sud');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'2B','Haute Corse');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'21','C™te d\'or');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'22','C™tes d\'Armor');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'23','Creuse');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'24','Dordogne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'25','Doubs');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'26','Dr™me');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'27','Eure');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'28','Eure et Loir');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'29','Finist?re');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'30','Gard');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'31','Haute Garonne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'32','Gers');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'33','Gironde');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'34','HŽrault');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'35','Ille et Vilaine');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'36','Indre');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'37','Indre et Loire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'38','Is?re');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'39','Jura');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'40','Landes');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'41','Loir et Cher');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'42','Loire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'43','Haute Loire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'44','Loire Atlantique');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'45','Loiret');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'46','Lot');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'47','Lot et Garonne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'48','Loz?re');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'49','Maine et Loire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'50','Manche');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'51','Marne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'52','Haute Marne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'53','Mayenne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'54','Meurthe et Moselle');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'55','Meuse');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'56','Morbihan');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'57','Moselle');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'58','Ni?vre');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'59','Nord');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'60','Oise');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'61','Orne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'62','Pas de Calais');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'63','Puy de D™me');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'64','PyrŽnŽes Atlantiques');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'65','Hautes PyrŽnŽes');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'66','PyrŽnŽes Orientales');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'67','Bas Rhin');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'68','Haut Rhin');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'69','Rh™ne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'70','Haute Sa™ne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'71','Sa™ne et Loire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'72','Sarthe');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'73','Savoie');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'74','Haute Savoie');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'75','Paris');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'76','Seine Maritime');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'77','Seine et Marne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'78','Yvelines');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'79','Deux S?vres');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'80','Somme');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'81','Tarn');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'82','Tarn et Garonne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'83','Var');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'84','Vaucluse');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'85','VendŽe');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'86','Vienne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'87','Haute Vienne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'88','Vosges');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'89','Yonne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'90','Territoire de Belfort');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'91','Essonne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'92','Hauts de Seine');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'93','Seine St-Denis');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'94','Val de Marne');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'95','Val d\'Oise');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'971 (DOM)','Guadeloupe');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'972 (DOM)','Martinique');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'973 (DOM)','Guyane');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'974 (DOM)','Saint Denis');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'975 (DOM)','St-Pierre de Miquelon');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'976 (TOM)','Mayotte');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'984 (TOM)','Terres australes et Antartiques fran?aises');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'985 (TOM)','Nouvelle CalŽdonie');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'986 (TOM)','Wallis et Futuna');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',73,'987 (TOM)','PolynŽsie fran?aise');

#India
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'DL', 'Delhi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'MH', 'Maharashtra');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'TN', 'Tamil Nadu');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'KL', 'Kerala');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'AP', 'Andhra Pradesh');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'KA', 'Karnataka');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'GA', 'Goa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'MP', 'Madhya Pradesh');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'PY', 'Pondicherry');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'GJ', 'Gujarat');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'OR', 'Orrisa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'CA', 'Chhatisgarh');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'JH', 'Jharkhand');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'BR', 'Bihar');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'WB', 'West Bengal');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'UP', 'Uttar Pradesh');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'RJ', 'Rajasthan');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'PB', 'Punjab');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'HR', 'Haryana');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'CH', 'Chandigarh');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'JK', 'Jammu & Kashmir');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'HP', 'Himachal Pradesh');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'UA', 'Uttaranchal');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'LK', 'Lakshadweep');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'AN', 'Andaman & Nicobar');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'MG', 'Meghalaya');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'AS', 'Assam');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'DR', 'Dadra & Nagar Haveli');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'DN', 'Daman & Diu');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'SK', 'Sikkim');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'TR', 'Tripura');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'MZ', 'Mizoram');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'MN', 'Manipur');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'NL', 'Nagaland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'AR', 'Arunachal Pradesh');

#Italy
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'AG','Agrigento');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'AL','Alessandria');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'AN','Ancona');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'AO','Aosta');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'AR','Arezzo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'AP','Ascoli Piceno');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'AT','Asti');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'AV','Avellino');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'BA','Bari');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'BL','Belluno');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'BN','Benevento');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'BG','Bergamo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'BI','Biella');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'BO','Bologna');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'BZ','Bolzano');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'BS','Brescia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'BR','Brindisi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'CA','Cagliari');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'CL','Caltanissetta');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'CB','Campobasso');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'CE','Caserta');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'CT','Catania');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'CZ','Catanzaro');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'CH','Chieti');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'CO','Como');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'CS','Cosenza');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'CR','Cremona');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'KR','Crotone');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'CN','Cuneo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'EN','Enna');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'FE','Ferrara');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'FI','Firenze');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'FG','Foggia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'FO','Forlì');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'FR','Frosinone');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'GE','Genova');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'GO','Gorizia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'GR','Grosseto');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'IM','Imperia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'IS','Isernia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'AQ','Aquila');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'SP','La Spezia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'LT','Latina');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'LE','Lecce');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'LC','Lecco');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'LI','Livorno');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'LO','Lodi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'LU','Lucca');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'MC','Macerata');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'MN','Mantova');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'MS','Massa-Carrara');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'MT','Matera');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'ME','Messina');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'MI','Milano');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'MO','Modena');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'NA','Napoli');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'NO','Novara');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'NU','Nuoro');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'OR','Oristano');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'PD','Padova');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'PA','Palermo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'PR','Parma');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'PG','Perugia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'PV','Pavia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'PS','Pesaro e Urbino');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'PE','Pescara');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'PC','Piacenza');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'PI','Pisa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'PT','Pistoia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'PN','Pordenone');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'PZ','Potenza');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'PO','Prato');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'RG','Ragusa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'RA','Ravenna');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'RC','Reggio di Calabria');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'RE','Reggio Emilia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'RI','Rieti');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'RN','Rimini');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'RM','Roma');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'RO','Rovigo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'SA','Salerno');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'SS','Sassari');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'SV','Savona');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'SI','Siena');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'SR','Siracusa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'SO','Sondrio');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'TA','Taranto');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'TE','Teramo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'TR','Terni');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'TO','Torino');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'TP','Trapani');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'TN','Trento');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'TV','Treviso');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'TS','Trieste');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'UD','Udine');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'VA','Varese');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'VE','Venezia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'VB','Verbania');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'VC','Vercelli');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'VR','Verona');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'VV','Vibo Valentia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'VI','Vicenza');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',105,'VT','Viterbo');

#Japan
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Niigata', 'Niigata');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Toyama', 'Toyama');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Ishikawa', 'Ishikawa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Fukui', 'Fukui');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Yamanashi', 'Yamanashi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Nagano', 'Nagano');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Gifu', 'Gifu');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Shizuoka', 'Shizuoka');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Aichi', 'Aichi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Mie', 'Mie');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Shiga', 'Shiga');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Kyoto', 'Kyoto');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Osaka', 'Osaka');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Hyogo', 'Hyogo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Nara', 'Nara');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Wakayama', 'Wakayama');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Tottori', 'Tottori');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Shimane', 'Shimane');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Okayama', 'Okayama');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Hiroshima', 'Hiroshima');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Yamaguchi', 'Yamaguchi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Tokushima', 'Tokushima');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Kagawa', 'Kagawa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Ehime', 'Ehime');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Kochi', 'Kochi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Fukuoka', 'Fukuoka');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Saga', 'Saga');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Nagasaki', 'Nagasaki');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Kumamoto', 'Kumamoto');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Oita', 'Oita');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Miyazaki', 'Miyazaki');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '107', 'Kagoshima', 'Kagoshima');

#Malaysia
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'JOH','Johor');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'KDH','Kedah');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'KEL','Kelantan');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'KL','Kuala Lumpur');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'MEL','Melaka');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'NS','Negeri Sembilan');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'PAH','Pahang');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'PRK','Perak');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'PER','Perlis');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'PP','Pulau Pinang');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'SAB','Sabah');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'SWK','Sarawak');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'SEL','Selangor');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'TER','Terengganu');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',129,'LAB','W.P.Labuan');

#Mexico
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'AGS', 'Aguascalientes');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'BC', 'Baja California');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'BCS', 'Baja California Sur');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'CAM', 'Campeche');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'COA', 'Coahuila');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'COL', 'Colima');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'CHI', 'Chiapas');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'CHIH', 'Chihuahua');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'DF', 'Distrito Federal');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'DGO', 'Durango');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'MEX', 'Estado de Mexico');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'GTO', 'Guanajuato');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'GRO', 'Guerrero');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'HGO', 'Hidalgo');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'JAL', 'Jalisco');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'MCH', 'Michoacan');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'MOR', 'Morelos');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'NAY', 'Nayarit');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'NL', 'Nuevo Leon');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'OAX', 'Oaxaca');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'PUE', 'Puebla');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'QRO', 'Queretaro');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'QR', 'Quintana Roo');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'SLP', 'San Luis Potosi');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'SIN', 'Sinaloa');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'SON', 'Sonora');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'TAB', 'Tabasco');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'TMPS', 'Tamaulipas');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'TLAX', 'Tlaxcala');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'VER', 'Veracruz');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'YUC', 'Yucatan');
insert into zones (zone_id, zone_country_id, zone_code, zone_name) values ('', '138', 'ZAC', 'Zacatecas');

#Norway
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'OSL','Oslo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'AKE','Akershus');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'AUA','Aust-Agder');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'BUS','Buskerud');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'FIN','Finnmark');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'HED','Hedmark');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'HOR','Hordaland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'MOR','Møre og Romsdal');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'NOR','Nordland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'NTR','Nord-Trøndelag');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'OPP','Oppland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'ROG','Rogaland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'SOF','Sogn og Fjordane');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'STR','Sør-Trøndelag');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'TEL','Telemark');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'TRO','Troms');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'VEA','Vest-Agder');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'OST','Østfold');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('',160,'SVA','Svalbard');

#Pakistan
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'KHI', 'Karachi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'LH', 'Lahore');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'ISB', 'Islamabad');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'QUE', 'Quetta');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'PSH', 'Peshawar');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'GUJ', 'Gujrat');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'SAH', 'Sahiwal');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'FSB', 'Faisalabad');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 99, 'RIP', 'Rawal Pindi');

#Romania
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'AB','Alba');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'AR','Arad');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'AG','Arges');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'BC','Bacau');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'BH','Bihor');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'BN','Bistrita-Nasaud');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'BT','Botosani');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'BV','Brasov');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'BR','Braila');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'B','Bucuresti');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'BZ','Buzau');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'CS','Caras-Severin');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'CL','Calarasi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'CJ','Cluj');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'CT','Constanta');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'CV','Covasna');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'DB','Dimbovita');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'DJ','Dolj');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'GL','Galati');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'GR','Giurgiu');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'GJ','Gorj');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'HR','Harghita');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'HD','Hunedoara');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'IL','Ialomita');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'IS','Iasi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'IF','Ilfov');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'MM','Maramures');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'MH','Mehedint');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'MS','Mures');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'NT','Neamt');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'OT','Olt');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'PH','Prahova');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'SM','Satu-Mare');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'SJ','Salaj');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'SB','Sibiu');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'SV','Suceava');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'TR','Teleorman');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'TM','Timis');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'TL','Tulcea');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'VS','Vaslui');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'VL','Valcea');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 175,'VN','Vrancea');

#South Africa
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '193', 'WP', 'Western Cape');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '193', 'GP', 'Gauteng');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '193', 'KZN', 'Kwazulu-Natal');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '193', 'NC', 'Northern-Cape');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '193', 'EC', 'Eastern-Cape');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '193', 'MP', 'Mpumalanga');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '193', 'NW', 'North-West');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '193', 'FS', 'Free State');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '193', 'NP', 'Northern Province');

#Turkey
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ADANA','ADANA');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ADIYAMAN','ADIYAMAN');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'AFYON','AFYON');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'AGRI','AGRI');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'AMASYA','AMASYA');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ANKARA','ANKARA');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ANTALYA','ANTALYA');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ARTVIN','ARTVIN');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'AYDIN','AYDIN');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'BALIKESIR','BALIKESIR');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'BILECIK','BILECIK');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'BINGÖL','BINGÖL');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'BITLIS','BITLIS');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'BOLU','BOLU');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'BURDUR','BURDUR');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'BURSA','BURSA');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ÇANAKKALE','ÇANAKKALE');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ÇANKIRI','ÇANKIRI');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ÇORUM','ÇORUM');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'DENIZLI','DENIZLI');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'DIYARBAKIR','DIYARBAKIR');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'EDIRNE','EDIRNE');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ELAZIG','ELAZIG');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ERZINCAN','ERZINCAN');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ERZURUM','ERZURUM');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ESKISEHIR','ESKISEHIR');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'GAZIANTEP','GAZIANTEP');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'GIRESUN','GIRESUN');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'GÜMÜSHANE','GÜMÜSHANE');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'HAKKARI','HAKKARI');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'HATAY','HATAY');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ISPARTA','ISPARTA');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'IÇEL','IÇEL');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ISTANBUL','ISTANBUL');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'IZMIR','IZMIR');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'KARS','KARS');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'KASTAMONU','KASTAMONU');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'KAYSERI','KAYSERI');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'KIRKLARELI','KIRKLARELI');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'KIRSEHIR','KIRSEHIR');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'KOCAELI','KOCAELI');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'KONYA','KONYA');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'KÜTAHYA','KÜTAHYA');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'MALATYA','MALATYA');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'MANISA','MANISA');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'KAHRAMANMARAS','KAHRAMANMARAS');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'MARDIN','MARDIN');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'MUGLA','MUGLA');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'MUS','MUS');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'NEVSEHIR','NEVSEHIR');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'NIGDE','NIGDE');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ORDU','ORDU');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'RIZE','RIZE');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'SAKARYA','SAKARYA');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'SAMSUN','SAMSUN');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'SIIRT','SIIRT');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'SINOP','SINOP');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'SIVAS','SIVAS');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'TEKIRDAG','TEKIRDAG');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'TOKAT','TOKAT');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'TRABZON','TRABZON');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'TUNCELI','TUNCELI');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'SANLIURFA','SANLIURFA');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'USAK','USAK');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'VAN','VAN');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'YOZGAT','YOZGAT');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ZONGULDAK','ZONGULDAK');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'AKSARAY','AKSARAY');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'BAYBURT','BAYBURT');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'KARAMAN','KARAMAN');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'KIRIKKALE','KIRIKKALE');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'BATMAN','BATMAN');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'SIRNAK','SIRNAK');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'BARTIN','BARTIN');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'ARDAHAN','ARDAHAN');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'IGDIR','IGDIR');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'YALOVA','YALOVA');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'KARABÜK','KARABÜK');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'KILIS','KILIS');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'OSMANIYE','OSMANIYE');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', 215, 'DÜZCE','DÜZCE');

#Venezuela
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'AM', 'Amazonas');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'AN', 'Anzoátegui');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'AR', 'Aragua');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'AP', 'Apure');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'BA', 'Barinas');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'BO', 'Bolívar');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'CA', 'Carabobo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'CO', 'Cojedes');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'DA', 'Delta Amacuro');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'DC', 'Distrito Capital');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'FA', 'Falcón');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'GA', 'Guárico');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'GU', 'Guayana');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'LA', 'Lara');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'ME', 'Mérida');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'MI', 'Miranda');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'MO', 'Monagas');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'NE', 'Nueva Esparta');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'PO', 'Portuguesa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'SU', 'Sucre');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'TA', 'Táchira');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'TU', 'Trujillo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'VA', 'Vargas');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'YA', 'Yaracuy');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '229', 'ZU', 'Zulia');

#UK
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','AVON','Avon');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','BEDS','Bedfordshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','BERK','Berkshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','BIRM','Birmingham');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','BORD','Borders');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','BUCK','Buckinghamshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','CAMB','Cambridgeshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','CENT','Central');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','CHES','Cheshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','CLEV','Cleveland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','CLWY','Clwyd');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','CORN','Cornwall');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','CUMB','Cumbria');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','DERB','Derbyshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','DEVO','Devon');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','DORS','Dorset');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','DUMF','Dumfries & Galloway');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','DURH','Durham');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','DYFE','Dyfed');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','ESUS','East Sussex');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','ESSE','Essex');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','FIFE','Fife');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','GLAM','Glamorgan');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','GLOU','Gloucestershire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','GRAM','Grampian');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','GWEN','Gwent');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','GWYN','Gwynedd');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','HAMP','Hampshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','HERE','Hereford & Worcester');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','HERT','Hertfordshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','HUMB','Humberside');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','KENT','Kent');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','LANC','Lancashire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','LEIC','Leicestershire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','LINC','Lincolnshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','LOND','London');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','LOTH','Lothian');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','MANC','Manchester');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','MERS','Merseyside');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','NORF','Norfolk');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','NYOR','North Yorkshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','NWHI','North west Highlands');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','NHAM','Northamptonshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','NUMB','Northumberland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','NOTT','Nottinghamshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','OXFO','Oxfordshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','POWY','Powys');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','SHRO','Shropshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','SOME','Somerset');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','SYOR','South Yorkshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','STAF','Staffordshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','STRA','Strathclyde');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','SUFF','Suffolk');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','SURR','Surrey');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','WSUS','West Sussex');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','TAYS','Tayside');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','TYWE','Tyne & Wear');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','WARW','Warwickshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','WISL','West Isles');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','WYOR','West Yorkshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES ('', '222','WILT','Wiltshire');


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

