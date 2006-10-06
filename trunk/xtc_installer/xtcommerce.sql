# -----------------------------------------------------------------------------------------
#  $Id: xtcommerce.sql,v 1.62 2004/06/06 18:21:16 novalis Exp $
#
#  xt:Commerce Vam Edition - community made shopping
#  http://www.xt-commerce.com 
#
#  Copyright (c) 2003 xt:Commerce
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
  entry_company varchar(255),
  entry_firstname varchar(255) NOT NULL,
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
  campaigns_name varchar(255) NOT NULL default '',
  campaigns_refID varchar(255) default NULL,
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
  address_format varchar(255) NOT NULL,
  address_summary varchar(255) NOT NULL,
  PRIMARY KEY (address_format_id)
);


DROP TABLE IF EXISTS database_version;
CREATE TABLE database_version (
  version varchar(255) NOT NULL
);

DROP TABLE IF EXISTS admin_access;
CREATE TABLE admin_access (
  customers_id varchar(255) NOT NULL default '0',

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
  easypopulate int(1) NOT NULL default '0',
  quick_updates int(1) NOT NULL default '0',
  latest_news int(1) NOT NULL default '0',
  recover_cart_sales int(1) NOT NULL default '0',
  featured int(1) NOT NULL default '0',
  
  PRIMARY KEY  (customers_id)
);


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
);


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
  PRIMARY KEY (categories_id),
  KEY idx_categories_parent_id (parent_id)
);

DROP TABLE IF EXISTS categories_description;
CREATE TABLE categories_description (
  categories_id int DEFAULT '0' NOT NULL,
  language_id int DEFAULT '1' NOT NULL,
  categories_name varchar(255) NOT NULL,
  categories_heading_title varchar(255) NOT NULL,
  categories_description text NOT NULL,
  categories_meta_title varchar(255) NOT NULL,
  categories_meta_description varchar(255) NOT NULL,
  categories_meta_keywords varchar(255) NOT NULL,
  PRIMARY KEY (categories_id, language_id),
  KEY idx_categories_name (categories_name)
);

DROP TABLE IF EXISTS configuration;
CREATE TABLE configuration (
  configuration_id int NOT NULL auto_increment,
  configuration_key varchar(255) NOT NULL,
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
  configuration_group_title varchar(255) NOT NULL,
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
  countries_name varchar(255) NOT NULL,
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
);

DROP TABLE IF EXISTS customers;
CREATE TABLE customers (
  customers_id int NOT NULL auto_increment,
  customers_cid varchar(255),
  customers_vat_id varchar (20),
  customers_vat_id_status int(2) DEFAULT '0' NOT NULL,
  customers_warning varchar(255),
  customers_status int(5) DEFAULT '1' NOT NULL,
  customers_gender char(1) NOT NULL,
  customers_firstname varchar(255) NOT NULL,
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
  name varchar(255)  NOT NULL,
  code char(2) NOT NULL,
  image varchar(255),
  directory varchar(255),
  sort_order int(3),
  language_charset text NOT NULL,
  PRIMARY KEY (languages_id),
  KEY IDX_LANGUAGES_NAME (name)
);

DROP TABLE IF EXISTS latest_news;
CREATE TABLE latest_news (
   news_id int(11) NOT NULL AUTO_INCREMENT,
   headline varchar(255) NOT NULL,
   content text NOT NULL,
   date_added datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   language int(11) NOT NULL default '1',
   status tinyint(1) DEFAULT '0' NOT NULL,
   PRIMARY KEY (news_id)
);

DROP TABLE IF EXISTS manufacturers;
CREATE TABLE manufacturers (
  manufacturers_id int NOT NULL auto_increment,
  manufacturers_name varchar(255) NOT NULL,
  manufacturers_image varchar(255),
  date_added datetime NULL,
  last_modified datetime NULL,
  PRIMARY KEY (manufacturers_id),
  KEY IDX_MANUFACTURERS_NAME (manufacturers_name)
);

DROP TABLE IF EXISTS manufacturers_info;
CREATE TABLE manufacturers_info (
  manufacturers_id int NOT NULL,
  languages_id int NOT NULL,
  manufacturers_meta_title varchar(255) NOT NULL,
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
  customers_firstname varchar(255) NOT NULL default '',
  customers_lastname varchar(255) NOT NULL default '',
  mail_status int(1) NOT NULL default '0',
  mail_key varchar(255) NOT NULL default '',
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
  customers_cid varchar(255),
  customers_vat_id varchar (20),
  customers_status int(11),
  customers_status_name varchar(255) NOT NULL,
  customers_status_image varchar (64),
  customers_status_discount decimal (4,2),
  customers_name varchar(255) NOT NULL,
  customers_firstname varchar(255) NOT NULL,
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
);

DROP TABLE IF EXISTS orders_status;
CREATE TABLE orders_status (
  orders_status_id int DEFAULT '0' NOT NULL,
  language_id int DEFAULT '1' NOT NULL,
  orders_status_name varchar(255) NOT NULL,
  PRIMARY KEY (orders_status_id, language_id),
  KEY idx_orders_status_name (orders_status_name)
);

DROP TABLE IF EXISTS shipping_status;
CREATE TABLE shipping_status (
  shipping_status_id int DEFAULT '0' NOT NULL,
  language_id int DEFAULT '1' NOT NULL,
  shipping_status_name varchar(255) NOT NULL,
  shipping_status_image varchar(255) NOT NULL,
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
  products_options varchar(255) NOT NULL,
  products_options_values varchar(255) NOT NULL,
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
  class varchar(255) NOT NULL,
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
  class varchar(255) NOT NULL default '',
  PRIMARY KEY  (orders_recalculate_id)
);

DROP TABLE IF EXISTS products;
CREATE TABLE products (
  products_id int NOT NULL auto_increment,
  products_ean varchar(255),
  products_quantity int(4) NOT NULL,
  products_shippingtime int(4) NOT NULL,
  products_model varchar(255),
  group_permission_0 tinyint(1) NOT NULL,
  group_permission_1 tinyint(1) NOT NULL,
  group_permission_2 tinyint(1) NOT NULL,
  group_permission_3 tinyint(1) NOT NULL,
  products_sort int(4) NOT NULL DEFAULT '0',
  products_image varchar(255),
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
  products_to_xml tinyint(1) NOT NULL DEFAULT '1',
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
  attributes_model varchar(255) NULL,
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
  products_name varchar(255) NOT NULL default '',
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
  products_options_name varchar(255) NOT NULL default '',
  PRIMARY KEY  (products_options_id,language_id)
);

DROP TABLE IF EXISTS products_options_values;
CREATE TABLE products_options_values (
  products_options_values_id int NOT NULL default '0',
  language_id int NOT NULL default '1',
  products_options_values_name varchar(255) NOT NULL default '',
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
  products_vpe_name varchar(255) NOT NULL default ''
);

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
);

DROP TABLE IF EXISTS reviews_description;
CREATE TABLE reviews_description (
  reviews_id int NOT NULL,
  languages_id int NOT NULL,
  reviews_text text NOT NULL,
  PRIMARY KEY (reviews_id, languages_id)
);

DROP TABLE IF EXISTS scart;
CREATE TABLE scart (
  scartid INT(11) NOT NULL AUTO_INCREMENT,
  customers_id INT(11) NOT NULL ,
  dateadded VARCHAR(8) NOT NULL ,
  PRIMARY KEY (scartid)
);

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions (
  sesskey varchar(255) NOT NULL,
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
);

DROP TABLE IF EXISTS tax_class;
CREATE TABLE tax_class (
  tax_class_id int NOT NULL auto_increment,
  tax_class_title varchar(255) NOT NULL,
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
  geo_zone_name varchar(255) NOT NULL,
  geo_zone_description varchar(255) NOT NULL,
  last_modified datetime NULL,
  date_added datetime NOT NULL,
  PRIMARY KEY (geo_zone_id)
);

DROP TABLE IF EXISTS whos_online;
CREATE TABLE whos_online (
  customer_id int,
  full_name varchar(255) NOT NULL,
  session_id varchar(255) NOT NULL,
  ip_address varchar(15) NOT NULL,
  time_entry varchar(14) NOT NULL,
  time_last_click varchar(14) NOT NULL,
  last_page_url varchar(255) NOT NULL
);

DROP TABLE IF EXISTS zones;
CREATE TABLE zones (
  zone_id int NOT NULL auto_increment,
  zone_country_id int NOT NULL,
  zone_code varchar(255) NOT NULL,
  zone_name varchar(255) NOT NULL,
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
  content_file varchar(255) NOT NULL default '',
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
  content_name varchar(255) NOT NULL default '',
  content_file varchar(255) NOT NULL,
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
  file_flag_name varchar(255) NOT NULL,
  PRIMARY KEY (file_flag)
);



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
  ipaddr varchar(255) NOT NULL default '',
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
  redeem_ip varchar(255) NOT NULL default '',
  order_id int(11) NOT NULL default '0',
  PRIMARY KEY  (unique_id)
);

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
);

DROP TABLE if EXISTS coupons_description;
CREATE TABLE coupons_description (
  coupon_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '0',
  coupon_name varchar(255) NOT NULL default '',
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

INSERT INTO shipping_status VALUES (1, 1, '3-4 дня', '');
INSERT INTO shipping_status VALUES (1, 2, '3-4 Days', '');
INSERT INTO shipping_status VALUES (2, 1, '1 неделя', '');
INSERT INTO shipping_status VALUES (2, 2, '1 Week', '');
INSERT INTO shipping_status VALUES (3, 1, '2 недели', '');
INSERT INTO shipping_status VALUES (3, 2, '2 Weeks', '');

# data

INSERT INTO `content_manager` VALUES (1, 0, 0, '', 1, 'Доставка', 'Доставка', 'Условия доставки.', 0, 1, '', 1, 1, 0);
INSERT INTO `content_manager` VALUES (2, 0, 0, '', 1, 'Безопасность магазина', 'Безопасность магазина', 'Ваш текст.', 0, 1, '', 1, 2, 0);
INSERT INTO `content_manager` VALUES (3, 0, 0, '', 1, 'Условия использования', 'Условия использования', 'Ваш текст', 0, 1, '', 1, 3, 0);
INSERT INTO `content_manager` VALUES (4, 0, 0, '', 1, 'Информация о магазине', 'Информация о магазине', 'Текст страницы информация о магазине.', 0, 1, '', 1, 4, 0);
INSERT INTO `content_manager` VALUES (5, 0, 0, '', 1, 'Главная страница', 'Добро пожаловать', 'Вы установили интернет-магазин xt:Commerce VaM Edition<br /><br />Данный текст можно изменить в Админке - Инструменты - Информационные страницы<br />', 0, 1, '', 0, 5, 0);
INSERT INTO `content_manager` VALUES (6, 0, 0, '', 2, 'Shipping & Returns', 'Shipping & Returns', 'Put here your Shipping & Returns information.', 0, 1, '', 1, 1, 0);
INSERT INTO `content_manager` VALUES (7, 0, 0, '', 2, 'Privacy Notice', 'Privacy Notice', 'Put here your Privacy Notice information.', 0, 1, '', 1, 2, 0);
INSERT INTO `content_manager` VALUES (8, 0, 0, '', 2, 'Conditions of Use', 'Conditions of Use', 'Conditions of Use<br />Put here your Conditions of Use information. <br />1. Validity<br />2. Offers<br />3. Price<br />4. Dispatch and passage of the risk<br />5. Delivery<br />6. Terms of payment<br />7. Retention of title<br />8. Notices of defect, guarantee and compensation<br />9. Fair trading cancelling / non-acceptance<br />10. Place of delivery and area of jurisdiction<br />11. Final clauses', 0, 1, '', 1, 3, 0);
INSERT INTO `content_manager` VALUES (9, 0, 0, '', 2, 'Impressum', 'Impressum', 'Put here your Company information.', 0, 1, '', 1, 4, 0);
INSERT INTO `content_manager` VALUES (10, 0, 0, '', 2, 'Main page', 'Welcome', 'Sample text.<br /><br /> You can change it in Admin - Tools - Content manager<br />', 0, 1, '', 0, 5, 0);
INSERT INTO `content_manager` VALUES (11, 0, 0, '', 2, 'Sample page', 'Sample page', 'Sample text', 0, 1, '', 0, 6, 1);
INSERT INTO `content_manager` VALUES (12, 0, 0, '', 1, 'Пример страницы', 'Пример страницы', 'Текст страницы', 0, 1, '', 0, 6, 1);
INSERT INTO `content_manager` VALUES (13, 0, 0, '', 2, 'Contact us', 'Contact us', 'Contact us page', 0, 1, '', 1, 7, 0);
INSERT INTO `content_manager` VALUES (14, 0, 0, '', 1, 'Свяжитесь с нами', 'Свяжитесь с нами', 'Форма обратной связи', 0, 1, '', 1, 7, 0);
INSERT INTO `content_manager` VALUES (15, 0, 0, '', 1, 'Карта сайта', '', '', 0, 0, 'sitemap.php', 1, 8, 0);
INSERT INTO `content_manager` VALUES (16, 0, 0, '', 2, 'Sitemap', '', '', 0, 0, 'sitemap.php', 1, 8, 0);

# 1 - Default, 2 - USA, 3 - Spain, 4 - Singapore, 5 - Germany
INSERT INTO address_format VALUES (1, '$firstname $lastname$cr$streets$cr$city, $postcode$cr$statecomma$country','$city / $country');
INSERT INTO address_format VALUES (2, '$firstname $lastname$cr$streets$cr$city, $state    $postcode$cr$country','$city, $state / $country');
INSERT INTO address_format VALUES (3, '$firstname $lastname$cr$streets$cr$city$cr$postcode - $statecomma$country','$state / $country');
INSERT INTO address_format VALUES (4, '$firstname $lastname$cr$streets$cr$city ($postcode)$cr$country', '$postcode / $country');
INSERT INTO address_format VALUES (5, '$firstname $lastname$cr$streets$cr$postcode $city$cr$country','$city / $country');

INSERT  INTO admin_access VALUES ( 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
INSERT  INTO admin_access VALUES ( 'groups', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 2, 4, 2, 2, 2, 2, 5, 5, 5, 5, 5, 5, 5, 5, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1);

# configuration_group_id 1
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_NAME', 'xt:Commerce',  1, 1, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_OWNER', 'xt:Commerce', 1, 2, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_OWNER_EMAIL_ADDRESS', 'owner@your-shop.com', 1, 3, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_FROM', 'xt:Commerce owner@your-shop.com',  1, 4, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_COUNTRY', '176',  1, 6, NULL, '', 'xtc_get_country_name', 'xtc_cfg_pull_down_country_list(');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'STORE_ZONE', '98', 1, 7, NULL, '', 'xtc_cfg_get_zone_name', 'xtc_cfg_pull_down_zone_list(');
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
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CURRENT_TEMPLATE', 'vam', 1, 26, NULL, '', NULL, 'xtc_cfg_pull_down_template_sets(');
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
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_RANDOM_SELECT_FEATURED', '10',  3, 23, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_FEATURED_PRODUCTS', '9', 3, 24, NULL, '', NULL, NULL);

# Новости

INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_LATEST_NEWS', '3', 3, 23, 'NULL', '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_LATEST_NEWS_PAGE', '20', 3, 24, 'NULL', '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MAX_DISPLAY_LATEST_NEWS_CONTENT', '150', 3, 25, 'NULL', '', NULL, NULL);


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
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_ACTIVE', 'true', 4, 13, '2003-12-15 13:14:39', '0000-00-00 00:00:00', '', 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_GREYSCALE', '', 4, 14, '2003-12-15 13:13:37', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_ELLIPSE', '', 4, 15, '2003-12-15 13:14:57', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES', '', 4, 16, '2003-12-15 13:19:45', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_MERGE', '', 4, 17, '2003-12-15 12:01:43', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_FRAME', '(FFFFFF,000000,3,EEEEEE)', 4, 18, '2003-12-15 13:19:37', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW', '', 4, 19, '2003-12-15 13:15:14', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR', '(4,FFFFFF)', 4, 20, '2003-12-15 12:02:19', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_ACTIVE', 'true', 4, 20, '2003-12-15 13:14:39', '0000-00-00 00:00:00', '', 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_BEVEL', '', 4, 21, '2003-12-15 13:42:09', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_GREYSCALE', '', 4, 22, '2003-12-15 13:18:00', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_ELLIPSE', '', 4, 23, '2003-12-15 13:41:53', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_ROUND_EDGES', '', 4, 24, '2003-12-15 13:21:55', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_MERGE', '(overlay.gif,10,-50,60,FF0000)', 4, 25, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_FRAME', '(FFFFFF,000000,3,EEEEEE)', 4, 26, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_DROP_SHADDOW', '(3,333333,FFFFFF)', 4, 27, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_INFO_MOTION_BLUR', '', 4, 28, '2003-12-15 13:21:18', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_POPUP_BEVEL', '(8,FFCCCC,330000)', 4, 29, NULL, '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO  configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'PRODUCT_IMAGE_POPUP_ACTIVE', 'true', 4, 29, '2003-12-15 13:14:39', '0000-00-00 00:00:00', '', 'xtc_cfg_select_option(array(\'true\', \'false\'),');
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
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_GENDER', 'false',  5, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_DOB', 'false',  5, 2, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_COMPANY', 'false',  5, 3, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_STREET_ADDRESS', 'true', 5, 4, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_CITY', 'true', 5, 5, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_POSTCODE', 'true', 5, 6, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_COUNTRY', 'true', 5, 7, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_TELE', 'true', 5, 8, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_FAX', 'true', 5, 9, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_SUBURB', 'false', 5, 10, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_STATE', 'true',  5, 11, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_OPTIONS', 'both',  5, 12, NULL, '', NULL, 'xtc_cfg_select_option(array(\'account\', \'guest\', \'both\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DELETE_GUEST_ACCOUNT', 'false',  5, 13, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');

# configuration_group_id 6
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_PAYMENT_INSTALLED', '', 6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_ORDER_TOTAL_INSTALLED', 'ot_subtotal.php;ot_shipping.php;ot_tax.php;ot_total.php', 6, 0, '2003-07-18 03:31:55', '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'MODULE_SHIPPING_INSTALLED', '',  6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DEFAULT_CURRENCY', 'USD',  6, 0, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DEFAULT_LANGUAGE', 'ru',  6, 0, NULL, '', NULL, NULL);
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
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DISPLAY_PAGE_PARSE_TIME', 'false',  10, 4, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
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
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'EMAIL_BILLING_SUBJECT_ORDER',  'Ваш заказ номер {$nr} / {$date}', 12, 38, NULL, '', NULL, NULL);

# configuration_group_id 13
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DOWNLOAD_ENABLED', 'false',  13, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DOWNLOAD_BY_REDIRECT', 'false',  13, 2, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DOWNLOAD_UNALLOWED_PAYMENT', 'banktransfer,cod,invoice,moneyorder',  13, 5, NULL, '', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DOWNLOAD_MIN_ORDERS_STATUS', '3',  13, 5, NULL, '', NULL, NULL);


# configuration_group_id 14
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'GZIP_COMPRESSION', 'false',  14, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'GZIP_LEVEL', '5',  14, 2, NULL, '', NULL, NULL);

# configuration_group_id 15
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SESSION_WRITE_DIRECTORY', 'tmp',  15, 1, NULL, '', NULL, NULL);
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
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'CHECK_CLIENT_AGENT', 'true',16, 13, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');

# configuration_group_id 17
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'USE_WYSIWYG', 'false', 17, 1, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACTIVATE_GIFT_SYSTEM', 'false', 17, 2, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SECURITY_CODE_LENGTH', '10', 17, 3, NULL, '2003-12-05 05:01:41', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'NEW_SIGNUP_GIFT_VOUCHER_AMOUNT', '0', 17, 4, NULL, '2003-12-05 05:01:41', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'NEW_SIGNUP_DISCOUNT_COUPON', '', 17, 5, NULL, '2003-12-05 05:01:41', NULL, NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACTIVATE_SHIPPING_STATUS', 'true', 17, 6, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DISPLAY_CONDITIONS_ON_CHECKOUT', 'false',17, 7, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'SHOW_IP_LOG', 'false',17, 8, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'GROUP_CHECK', 'false',  17, 9, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACTIVATE_NAVIGATOR', 'false',  17, 10, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'QUICKLINK_ACTIVATED', 'true',  17, 11, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACTIVATE_REVERSE_CROSS_SELLING', 'true', 17, 12, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'DISPLAY_REVOCATION_ON_CHECKOUT', 'true', 17, 13, NULL, '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'REVOCATION_ID', '', 17, 14, NULL, '2003-12-05 05:01:41', NULL, NULL);

#configuration_group_id 18
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'ACCOUNT_COMPANY_VAT_CHECK', 'false', 18, 4, '', '', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
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

#configuration_group_id 23, Яндекс-маркет
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'YML_NAME', '', '23', '1', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'YML_COMPANY', '', '23', '2', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'YML_DELIVERYINCLUDED', 'true', '23', '3', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'YML_AVAILABLE', 'stock', '23', '4', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\', \'stock\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'YML_AUTH_USER', '', '23', '5', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES   ('', 'YML_AUTH_PW', '', '23', '6', NULL , '0000-00-00 00:00:00', NULL , NULL);
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'YML_REFERER', 'false', '23', '7', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'false\', \'ip\', \'agent\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'YML_STRIP_TAGS', 'true', '23', '8', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'YML_UTF8', 'false', '23', '9', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');

#configuration_group_id 24, Изменение цен
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'DISPLAY_MODEL', 'true', '24', '1', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'MODIFY_MODEL', 'true', '24', '2', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'MODIFY_NAME', 'true', '24', '3', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'DISPLAY_STATUT', 'true', '24', '4', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'DISPLAY_WEIGHT', 'true', '24', '5', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'DISPLAY_QUANTITY', 'true', '24', '6', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'DISPLAY_IMAGE', 'true', '24', '7', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'MODIFY_MANUFACTURER', 'true', '24', '8', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'MODIFY_TAX', 'true', '24', '9', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'DISPLAY_TVA_OVER', 'true', '24', '10', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'DISPLAY_TVA_UP', 'true', '24', '11', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'DISPLAY_PREVIEW', 'true', '24', '12', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'DISPLAY_EDIT', 'true', '24', '13', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'DISPLAY_MANUFACTURER', 'true', '24', '14', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'DISPLAY_TAX', 'true', '24', '15', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (configuration_id,  configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('', 'ACTIVATE_COMMERCIAL_MARGIN', 'true', '24', '16', NULL, '0000-00-00 00:00:00', NULL, 'xtc_cfg_select_option(array(\'true\', \'false\'),');

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
INSERT INTO configuration_group VALUES ('23', 'Яндекс-Маркет', 'Конфигурирование Яндекс-Маркет', '23', '1');
INSERT INTO configuration_group VALUES ('23', 'Изменение цен', 'Настройки модуля изменения цен', '23', '1');

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
);
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

INSERT INTO currencies VALUES (1,'Доллар США','USD','$','',',','.','2','1.0000', now());


INSERT INTO languages VALUES (1,'Русский','ru','icon.gif','russian',1,'windows-1251');
INSERT INTO languages VALUES (2,'English','en','icon.gif','english',2,'iso-8859-15');


INSERT INTO orders_status VALUES ( '1', '1', 'Ожидает проверки');
INSERT INTO orders_status VALUES ( '1', '2', 'Pending');
INSERT INTO orders_status VALUES ( '2', '1', 'Ждём оплаты');
INSERT INTO orders_status VALUES ( '2', '2', 'Waiting approval');
INSERT INTO orders_status VALUES ( '3', '1', 'Выполняется');
INSERT INTO orders_status VALUES ( '3', '2', 'Processing');
INSERT INTO orders_status VALUES ( '4', '1', 'Доставляется');
INSERT INTO orders_status VALUES ( '4', '2', 'Delivering');
INSERT INTO orders_status VALUES ( '5', '1', 'Доставлен');
INSERT INTO orders_status VALUES ( '5', '2', 'Delivered');
INSERT INTO orders_status VALUES ( '6', '1', 'Отменён');
INSERT INTO orders_status VALUES ( '6', '2', 'Canceled');



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
INSERT INTO zones VALUES ('62', '176', 'Камчатская область', 'Камчатская область');
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
INSERT INTO zones VALUES ('80', '176', 'Пермская область', 'Пермская область');
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
INSERT INTO zones VALUES ('102', '176', 'Коми-Пермяцкий АО', 'Коми-Пермяцкий АО');
INSERT INTO zones VALUES ('103', '176', 'Корякский АО', 'Корякский АО');
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
INSERT INTO zones VALUES ('288', '117', 'Айзкраульский', 'Айзкраульский');
INSERT INTO zones VALUES ('289', '117', 'Алуксненский', 'Алуксненский');
INSERT INTO zones VALUES ('290', '117', 'Балвский', 'Балвский');
INSERT INTO zones VALUES ('291', '117', 'Баускский', 'Баускский');
INSERT INTO zones VALUES ('292', '117', 'Валкаский', 'Валкаский');
INSERT INTO zones VALUES ('293', '117', 'Валмиерский', 'Валмиерский');
INSERT INTO zones VALUES ('294', '117', 'Вентспилсский', 'Вентспилсский');
INSERT INTO zones VALUES ('295', '117', 'Гулбенеский', 'Гулбенеский');
INSERT INTO zones VALUES ('296', '117', 'Даугавпилсский', 'Даугавпилсский');
INSERT INTO zones VALUES ('297', '117', 'Добелеский', 'Добелеский');
INSERT INTO zones VALUES ('298', '117', 'Екабпилсский', 'Екабпилсский');
INSERT INTO zones VALUES ('299', '117', 'Елгавский', 'Елгавский');
INSERT INTO zones VALUES ('300', '117', 'Краславский', 'Краславский');
INSERT INTO zones VALUES ('301', '117', 'Кулдигский', 'Кулдигский');
INSERT INTO zones VALUES ('302', '117', 'Лиепайский', 'Лиепайский');
INSERT INTO zones VALUES ('303', '117', 'Лимбажский', 'Лимбажский');
INSERT INTO zones VALUES ('304', '117', 'Лудзский', 'Лудзский');
INSERT INTO zones VALUES ('305', '117', 'Мадонский', 'Мадонский');
INSERT INTO zones VALUES ('306', '117', 'Огреский', 'Огреский');
INSERT INTO zones VALUES ('307', '117', 'Прейльский', 'Прейльский');
INSERT INTO zones VALUES ('308', '117', 'Резекнеский', 'Резекнеский');
INSERT INTO zones VALUES ('309', '117', 'Рижский', 'Рижский');
INSERT INTO zones VALUES ('310', '117', 'Салдусский', 'Салдусский');
INSERT INTO zones VALUES ('311', '117', 'Талсинский', 'Талсинский');
INSERT INTO zones VALUES ('312', '117', 'Тукумсский', 'Тукумсский');
INSERT INTO zones VALUES ('313', '117', 'Цесиский', 'Цесиский');
INSERT INTO zones VALUES ('314', '117', 'Вентспилс', 'Вентспилс');
INSERT INTO zones VALUES ('315', '117', 'Даугавпилс', 'Даугавпилс');
INSERT INTO zones VALUES ('316', '117', 'Елгава', 'Елгава');
INSERT INTO zones VALUES ('317', '117', 'Лиепая', 'Лиепая');
INSERT INTO zones VALUES ('318', '117', 'Резекне', 'Резекне');
INSERT INTO zones VALUES ('319', '117', 'Рига', 'Рига');
INSERT INTO zones VALUES ('320', '117', 'Юрмала', 'Юрмала');

