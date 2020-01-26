<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2008 osCommerce

  Released under the GNU General Public License
*/

  require('../includes/database_tables.php');

  define('DIR_FS_CATALOG', trim($_POST['DIR_FS_DOCUMENT_ROOT']));
  define('DIR_FS_INC', trim($_POST['DIR_FS_DOCUMENT_ROOT']).'inc/');
  
  require_once(DIR_FS_INC . 'vam_encrypt_password.inc.php');
  require_once(DIR_FS_INC . 'vam_db_query.inc.php');
  require_once(DIR_FS_INC .'vam_db_perform.inc.php');
  require_once(DIR_FS_INC .'vam_db_input.inc.php');
  require_once(DIR_FS_INC .'vam_db_num_rows.inc.php');

  osc_db_connect(trim($_POST['DB_SERVER']), trim($_POST['DB_SERVER_USERNAME']), trim($_POST['DB_SERVER_PASSWORD']), trim($_POST['DB_DATABASE']));

  osc_db_query('update ' . TABLE_CONFIGURATION . ' set configuration_value = "' . trim($_POST['CFG_STORE_NAME']) . '" where configuration_key = "STORE_NAME"');
  osc_db_query('update ' . TABLE_CONFIGURATION . ' set configuration_value = "' . trim($_POST['CFG_STORE_NAME']) . '" where configuration_key = "STORE_OWNER"');
  osc_db_query('update ' . TABLE_CONFIGURATION . ' set configuration_value = "' . trim($_POST['CFG_STORE_OWNER_EMAIL_ADDRESS']) . '" where configuration_key = "STORE_OWNER_EMAIL_ADDRESS"');

  if (!empty($_POST['CFG_STORE_OWNER_NAME']) && !empty($_POST['CFG_STORE_OWNER_EMAIL_ADDRESS'])) {
    osc_db_query('update ' . TABLE_CONFIGURATION . ' set configuration_value = "\"' . trim($_POST['CFG_STORE_OWNER_NAME']) . '\" <' . trim($_POST['CFG_STORE_OWNER_EMAIL_ADDRESS']) . '>" where configuration_key = "EMAIL_FROM"');
  } else {
    osc_db_query('update ' . TABLE_CONFIGURATION . ' set configuration_value = "' . trim($_POST['CFG_STORE_OWNER_EMAIL_ADDRESS']) . '" where configuration_key = "EMAIL_FROM"');
  }

	    if ($error == false) {
$customer_query = vam_db_query("select c.customers_id, ci.customers_info_id, ab.customers_id from " . TABLE_CUSTOMERS . " c, " . TABLE_CUSTOMERS_INFO . " ci, " . TABLE_ADDRESS_BOOK . " ab ");
if (vam_db_num_rows($customer_query) >= 1) {
  $db_action = "update";
} else {
    $db_action = "insert";
  }

vam_db_perform(TABLE_CUSTOMERS, array(
              'customers_id' => '1',
              'customers_status' => '0',
              'customers_firstname' => 'admin',
              'customers_lastname' => 'admin',
              'customers_email_address' => trim($_POST['CFG_STORE_OWNER_EMAIL_ADDRESS']),
              'customers_default_address_id' => '1',
              'customers_telephone' => 'telephone',
              'customers_password' => vam_encrypt_password(trim($_POST['CFG_ADMINISTRATOR_PASSWORD'])),
              'delete_user' => '0',
              'customers_date_added' => 'now()',
              'customers_last_modified' => 'now()',),
              $db_action, 'customers_id = 1'
              );

vam_db_perform(TABLE_CUSTOMERS_INFO, array(
              'customers_info_id' => '1',
              'customers_info_date_of_last_logon' => 'now()',
              'customers_info_number_of_logons' => '0',
              'customers_info_date_account_created' => 'now()',
              'customers_info_date_account_last_modified' => 'now()',
              'global_product_notifications' => '0'),
              $db_action, 'customers_info_id = 1'
              );

vam_db_perform(TABLE_ADDRESS_BOOK, array(
              'customers_id' => '1',
              'entry_company' => trim($_POST['CFG_STORE_NAME']),
              'entry_firstname' => 'admin',
              'entry_lastname' => 'admin',
              'entry_street_address' => 'Street Address',
              'entry_postcode' => '123456',
              'entry_city' => 'Москва',
              'entry_state' => 'Москва',
              'entry_country_id' => '176',
              'entry_zone_id' => '98',
              'address_date_added' => 'now()',
              'address_last_modified' => 'now()'),
              $db_action, 'customers_id = 1'
              );



vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". (trim($_POST['CFG_STORE_OWNER_EMAIL_ADDRESS'])). "' WHERE configuration_key = 'STORE_OWNER_EMAIL_ADDRESS'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". (trim($_POST['CFG_STORE_NAME'])). "' WHERE configuration_key = 'STORE_NAME'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". (trim($_POST['CFG_STORE_OWNER_EMAIL_ADDRESS'])). "' WHERE configuration_key = 'EMAIL_FROM'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='176' WHERE configuration_key = 'SHIPPING_ORIGIN_COUNTRY'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='123456' WHERE configuration_key = 'SHIPPING_ORIGIN_ZIP'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". (trim($_POST['STORE_OWNER'])). "' WHERE configuration_key = 'STORE_OWNER'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". (trim($_POST['CFG_STORE_OWNER_EMAIL_ADDRESS'])). "' WHERE configuration_key = 'EMAIL_BILLING_FORWARDING_STRING'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". (trim($_POST['CFG_STORE_OWNER_EMAIL_ADDRESS'])). "' WHERE configuration_key = 'EMAIL_BILLING_ADDRESS'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". (trim($_POST['CFG_STORE_OWNER_EMAIL_ADDRESS'])). "' WHERE configuration_key = 'CONTACT_US_EMAIL_ADDRESS'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". (trim($_POST['CFG_STORE_OWNER_EMAIL_ADDRESS'])). "' WHERE configuration_key = 'EMAIL_SUPPORT_ADDRESS'");

		}


?>

<div class="mainBlock">
  <div class="stepsBox">
    <ol>
      <li>База данных</li>
      <li>Веб Сервер</li>
      <li>Настройки магазина</li>
      <li style="font-weight: bold;">Установка завершена!</li>
    </ol>
  </div>

  <h1>Установка VamShop</h1><br /><br /><br />

</div>

<div class="contentBlock">
  <div class="infoPane">
    <h3>Шаг 4: Установка завершена!</h3>

    <div class="infoPaneContents">
      <p>Поздравляем, установка интернет-магазина VamShop успешно завершена!</p>
    </div>
  </div>

  <div class="contentPane">
    <h2>Установка завершена!</h2>

<?php
  $dir_fs_document_root = $_POST['DIR_FS_DOCUMENT_ROOT'];
  if ((substr($dir_fs_document_root, -1) != '\\') && (substr($dir_fs_document_root, -1) != '/')) {
    if (strrpos($dir_fs_document_root, '\\') !== false) {
      $dir_fs_document_root .= '\\';
    } else {
      $dir_fs_document_root .= '/';
    }
  }

  //osc_db_query('update ' . TABLE_CONFIGURATION . ' set configuration_value = "' . $dir_fs_document_root . 'includes/work/" where configuration_key = "DIR_FS_CACHE"');
  //osc_db_query('update ' . TABLE_CONFIGURATION . ' set configuration_value = "' . $dir_fs_document_root . 'tmp/" where configuration_key = "SESSION_WRITE_DIRECTORY"');

  //if ($handle = opendir($dir_fs_document_root . 'includes/work/')) {
    //while (false !== ($filename = readdir($handle))) {
      //if (substr($filename, strrpos($filename, '.')) == '.cache') {
        //@unlink($dir_fs_document_root . 'includes/work/' . $filename);
      //}
    //}

    //closedir($handle);
  //}

  $http_url = parse_url($_POST['HTTP_WWW_ADDRESS']);
  $http_server = $http_url['scheme'] . '://' . $http_url['host'];
  $http_catalog = $http_url['path'];
  if (isset($http_url['port']) && !empty($http_url['port'])) {
    $http_server .= ':' . $http_url['port'];
  }

  if (substr($http_catalog, -1) != '/') {
    $http_catalog .= '/';
  }

  $admin_folder = 'admin';
  if (isset($_POST['CFG_ADMIN_DIRECTORY']) && !empty($_POST['CFG_ADMIN_DIRECTORY']) && osc_is_writable($dir_fs_document_root) && osc_is_writable($dir_fs_document_root . 'admin')) {
    $admin_folder = preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['CFG_ADMIN_DIRECTORY']));

    if (empty($admin_folder)) {
      $admin_folder = 'admin';
    }
  }

    $file_contents = '<?php' . "\n" .
                     '/* --------------------------------------------------------------' . "\n" .
                     '' . "\n" .
                     '  VamShop - open source ecommerce solution' . "\n" .
                     '  http://vamshop.ru' . "\n" .
                     '  http://vamshop.com' . "\n" .
                     '' . "\n" .
                     '   Copyright (c) 2012 VamShop' . "\n" .
                     '  --------------------------------------------------------------' . "\n" .
                     '  based on:' . "\n" . 
                     '  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)' . "\n" . 
                     '  (c) 2002-2003 osCommerce (configure.php,v 1.13 2003/02/10); www.oscommerce.com' . "\n" . 
                     '  (c) 2004 xt:Commerce (configure.php,v 1.13 2003/02/10); xt-commerce.com' . "\n" . 
                     '' . "\n" .
                     '  Released under the GNU General Public License' . "\n" . 
                     '  --------------------------------------------------------------*/' . "\n" .
                     '' . "\n" .
                     '// Define the webserver and path parameters' . "\n" .
                     '// * DIR_FS_* = Filesystem directories (local/physical)' . "\n" .
                     '// * DIR_WS_* = Webserver directories (virtual/URL)' . "\n" .
                     '  define(\'HTTP_SERVER\', \'' . $http_server . '\'); // eg, http://localhost - should not be empty for productive servers' . "\n" .
                     '  define(\'HTTPS_SERVER\', \'' . $http_server . '\'); // eg, https://localhost - should not be empty for productive servers' . "\n" .
                     '  define(\'ENABLE_SSL\', ' .  'false' . '); // secure webserver for checkout procedure?' . "\n" .
                     '  define(\'DIR_WS_CATALOG\', \'' . $http_catalog . '\'); // absolute path required' . "\n" .
                     '  define(\'DIR_WS_HTTPS_CATALOG\', \'' . $http_catalog . '\'); // absolute path required' . "\n" .
                     '  define(\'DIR_FS_DOCUMENT_ROOT\', \'' . $dir_fs_document_root  . '\');' . "\n" .
                     '  define(\'DIR_FS_CATALOG\', \'' . $dir_fs_document_root  . '\');' . "\n" .
                     '  define(\'DIR_WS_IMAGES\', \'images/\');' . "\n" .
                     '  define(\'DIR_WS_ORIGINAL_IMAGES\', DIR_WS_IMAGES .\'product_images/original_images/\');' . "\n" .
                     '  define(\'DIR_WS_THUMBNAIL_IMAGES\', DIR_WS_IMAGES .\'product_images/thumbnail_images/\');' . "\n" .
                     '  define(\'DIR_WS_INFO_IMAGES\', DIR_WS_IMAGES .\'product_images/info_images/\');' . "\n" .
                     '  define(\'DIR_WS_POPUP_IMAGES\', DIR_WS_IMAGES .\'product_images/popup_images/\');' . "\n" .
                     '  define(\'DIR_WS_ICONS\', DIR_WS_IMAGES . \'icons/\');' . "\n" .
                     '  define(\'DIR_WS_INCLUDES\',DIR_FS_DOCUMENT_ROOT. \'includes/\');' . "\n" .
                     '  define(\'DIR_WS_FUNCTIONS\', DIR_WS_INCLUDES . \'functions/\');' . "\n" .
                     '  define(\'DIR_WS_CLASSES\', DIR_WS_INCLUDES . \'classes/\');' . "\n" .
                     '  define(\'DIR_WS_MODULES\', DIR_WS_INCLUDES . \'modules/\');' . "\n" .
                     '  define(\'DIR_WS_LANGUAGES\', DIR_FS_CATALOG . \'lang/\');' . "\n" .
                     '' . "\n" .
                     '  define(\'DIR_WS_DOWNLOAD_PUBLIC\', DIR_WS_CATALOG . \'pub/\');' . "\n" .
                     '  define(\'DIR_FS_DOWNLOAD\', DIR_FS_CATALOG . \'download/\');' . "\n" .
                     '  define(\'DIR_FS_DOWNLOAD_PUBLIC\', DIR_FS_CATALOG . \'pub/\');' . "\n" .
                     '  define(\'DIR_FS_INC\', DIR_FS_CATALOG . \'inc/\');' . "\n" .
                     '' . "\n" .
                     '  define(\'DIR_FS_FORUM_ROOT\', \'\');' . "\n" .
                     '  define(\'DIR_FS_SITE_ROOT\', \'\');' . "\n" .
                     '  define(\'VAM_COOKIE_NAME\', \'VAMCookie\');' . "\n" .
                     '' . "\n" .
                     '  define(\'SESSION_WRITE_DIRECTORY\', DIR_FS_CATALOG . \'tmp/\');' . "\n" .
                     '' . "\n" .
                     '// define our database connection' . "\n" .
                     '  define(\'DB_SERVER\', \'' . trim($_POST['DB_SERVER']) . '\'); // eg, localhost - should not be empty for productive servers' . "\n" .
                     '  define(\'DB_SERVER_USERNAME\', \'' . trim($_POST['DB_SERVER_USERNAME']) . '\');' . "\n" .
                     '  define(\'DB_SERVER_PASSWORD\', \'' . trim($_POST['DB_SERVER_PASSWORD']). '\');' . "\n" .
                     '  define(\'DB_DATABASE\', \'' . trim($_POST['DB_DATABASE']). '\');' . "\n" .
                     '  define(\'USE_PCONNECT\', \'false\'); // use persistent connections?' . "\n" .
                     '  define(\'STORE_SESSIONS\', \'\'); // leave empty \'\' for default handler or set to \'mysql\'' . "\n" .                     '?>';


  $fp = fopen($dir_fs_document_root . 'includes/configure.php', 'w');
  fputs($fp, $file_contents);
  fclose($fp);

  @chmod($dir_fs_document_root . 'includes/configure.php', 0644);

  $fp = fopen($dir_fs_document_root . 'includes/configure.org.php', 'w');
  fputs($fp, $file_contents);
  fclose($fp);

  @chmod($dir_fs_document_root . 'includes/configure.org.php', 0644);

    $file_contents = '<?php' . "\n" .
                     '/* --------------------------------------------------------------' . "\n" .
                     '' . "\n" .
                     '  VamShop - open source ecommerce solution' . "\n" .
                     '  http://vamshop.ru' . "\n" .
                     '  http://vamshop.com' . "\n" .
                     '' . "\n" .
                     '   Copyright (c) 2012 VamShop' . "\n" .
                     '  --------------------------------------------------------------' . "\n" .
                     '  based on:' . "\n" . 
                     '  (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   
  
' . "\n" . 
                     '  (c) 2002-2003 osCommerce (configure.php,v 1.14 2003/02/21); www.oscommerce.com' . "\n" . 
                     '  (c) 2004 xt:Commerce (configure.php,v 1.13 2003/02/10); xt-commerce.com' . "\n" . 
                     '' . "\n" .
                     '  Released under the GNU General Public License' . "\n" . 
                     '  --------------------------------------------------------------*/' . "\n" .
                     '' . "\n" .
                     '// Define the webserver and path parameters' . "\n" .
                     '// * DIR_FS_* = Filesystem directories (local/physical)' . "\n" .
                     '// * DIR_WS_* = Webserver directories (virtual/URL)' . "\n" .
                     '  define(\'HTTP_SERVER\', \'' . $http_server . '\'); // eg, http://localhost or - https://localhost should not be empty for productive servers' . "\n" .
                     '  define(\'HTTP_CATALOG_SERVER\', \'' . $http_server . '\');' . "\n" .
                     '  define(\'HTTPS_CATALOG_SERVER\', \'' . $http_server . '\');' . "\n" .
                     '  define(\'ENABLE_SSL_CATALOG\', \'false\'); // secure webserver for catalog module' . "\n" .
                     '  define(\'DIR_FS_DOCUMENT_ROOT\', \'' . $dir_fs_document_root  . '\'); // where the pages are located on the server' . "\n" .
                     '  define(\'DIR_WS_ADMIN\', \'' . $http_catalog .'admin/' . '\'); // absolute path required' . "\n" .
                     '  define(\'DIR_FS_ADMIN\', \'' . $dir_fs_document_root .'admin/' . '\'); // absolute pate required' . "\n" .
                     '  define(\'DIR_WS_CATALOG\', \'' . $http_catalog . '\'); // absolute path required' . "\n" .
                     '  define(\'DIR_WS_HTTPS_CATALOG\', \'' . $http_catalog . '\'); // absolute path required' . "\n" .
                     '  define(\'DIR_FS_CATALOG\', \'' . $dir_fs_document_root  . '\'); // absolute path required' . "\n" .
                     '  define(\'DIR_WS_IMAGES\', \'images/\');' . "\n" .
                     '  define(\'DIR_FS_CATALOG_IMAGES\', DIR_FS_CATALOG . \'images/\');' . "\n" .
                     '  define(\'DIR_FS_CATALOG_ORIGINAL_IMAGES\', DIR_FS_CATALOG_IMAGES .\'product_images/original_images/\');' . "\n" .
                     '  define(\'DIR_FS_CATALOG_THUMBNAIL_IMAGES\', DIR_FS_CATALOG_IMAGES .\'product_images/thumbnail_images/\');' . "\n" .
                     '  define(\'DIR_FS_CATALOG_INFO_IMAGES\', DIR_FS_CATALOG_IMAGES .\'product_images/info_images/\');' . "\n" .
                     '  define(\'DIR_FS_CATALOG_POPUP_IMAGES\', DIR_FS_CATALOG_IMAGES .\'product_images/popup_images/\');' . "\n" .
                     '  define(\'DIR_WS_ICONS\', DIR_WS_IMAGES . \'icons/\');' . "\n" .
                     '  define(\'DIR_WS_CATALOG_IMAGES\', DIR_WS_CATALOG . \'images/\');' . "\n" .
                     '  define(\'DIR_WS_CATALOG_ORIGINAL_IMAGES\', DIR_WS_CATALOG_IMAGES .\'product_images/original_images/\');' . "\n" .
                     '  define(\'DIR_WS_CATALOG_THUMBNAIL_IMAGES\', DIR_WS_CATALOG_IMAGES .\'product_images/thumbnail_images/\');' . "\n" .
                     '  define(\'DIR_WS_CATALOG_INFO_IMAGES\', DIR_WS_CATALOG_IMAGES .\'product_images/info_images/\');' . "\n" .
                     '  define(\'DIR_WS_CATALOG_POPUP_IMAGES\', DIR_WS_CATALOG_IMAGES .\'product_images/popup_images/\');' . "\n" .
                     '  define(\'DIR_WS_INCLUDES\', \'includes/\');' . "\n" .
                     '  define(\'DIR_WS_BOXES\', DIR_WS_INCLUDES . \'boxes/\');' . "\n" .
                     '  define(\'DIR_WS_FUNCTIONS\', DIR_WS_INCLUDES . \'functions/\');' . "\n" .
                     '  define(\'DIR_WS_CLASSES\', DIR_WS_INCLUDES . \'classes/\');' . "\n" .
                     '  define(\'DIR_WS_MODULES\', DIR_WS_INCLUDES . \'modules/\');' . "\n" .
                     '  define(\'DIR_WS_LANGUAGES\', DIR_FS_CATALOG. \'lang/\');' . "\n" .
                     '  define(\'DIR_FS_LANGUAGES\', DIR_FS_CATALOG. \'lang/\');' . "\n" .
                     '  define(\'DIR_FS_CATALOG_MODULES\', DIR_FS_CATALOG . \'includes/modules/\');' . "\n" .
                     '  define(\'DIR_FS_BACKUP\', DIR_FS_ADMIN . \'backups/\');' . "\n" .
                     '  define(\'DIR_FS_INC\', DIR_FS_CATALOG . \'inc/\');' . "\n" .
                     '  define(\'DIR_WS_FILEMANAGER\', DIR_WS_MODULES . \'fckeditor/editor/filemanager/browser/default/\');' . "\n" .
                     '' . "\n" .
                     '  define(\'DIR_FS_FORUM_ROOT\', \'\');' . "\n" .
                     '  define(\'DIR_FS_SITE_ROOT\', \'\');' . "\n" .
                     '  define(\'VAM_COOKIE_NAME\', \'VAMCookie\');' . "\n" .
                     '' . "\n" .
                     '  define(\'SESSION_WRITE_DIRECTORY\', DIR_FS_CATALOG . \'tmp/\');' . "\n" .
                     '' . "\n" .
                     '// define our database connection' . "\n" .
                     '  define(\'DB_SERVER\', \'' . trim($_POST['DB_SERVER']) . '\'); // eg, localhost - should not be empty for productive servers' . "\n" .
                     '  define(\'DB_SERVER_USERNAME\', \'' . trim($_POST['DB_SERVER_USERNAME']) . '\');' . "\n" .
                     '  define(\'DB_SERVER_PASSWORD\', \'' . trim($_POST['DB_SERVER_PASSWORD']). '\');' . "\n" .
                     '  define(\'DB_DATABASE\', \'' . trim($_POST['DB_DATABASE']). '\');' . "\n" .
                     '  define(\'USE_PCONNECT\', \'false\'); // use persisstent connections?' . "\n" .
                     '  define(\'STORE_SESSIONS\', \'\'); // leave empty \'\' for default handler or set to \'mysql\'' . "\n" .
                     '' . "\n" .
 '?>';

  $fp = fopen($dir_fs_document_root . 'admin/includes/configure.php', 'w');
  fputs($fp, $file_contents);
  fclose($fp);

  @chmod($dir_fs_document_root . 'admin/includes/configure.php', 0644);

  $fp = fopen($dir_fs_document_root . 'admin/includes/configure.org.php', 'w');
  fputs($fp, $file_contents);
  fclose($fp);

  @chmod($dir_fs_document_root . 'admin/includes/configure.org.php', 0644);
  
  if ($admin_folder != 'admin') {
    @rename($dir_fs_document_root . 'admin', $dir_fs_document_root . $admin_folder);
  }
?>

<?php

//create .htaccess
    $file_contents = 
'AddDefaultCharset utf-8'. "\n" .
'' . "\n" .
'ErrorDocument 400 '.$http_catalog.'404.html' . "\n" .
'ErrorDocument 401 '.$http_catalog.'404.html' . "\n" .
'ErrorDocument 403 '.$http_catalog.'404.html' . "\n" .
'ErrorDocument 404 '.$http_catalog.'404.html' . "\n" .
'ErrorDocument 500 '.$http_catalog.'404.html' . "\n" .
'' . "\n" .
'RewriteEngine On' . "\n" .
'RewriteBase '.$http_catalog. "\n" .
'' . "\n" .
'RewriteRule ^product_reviews_write\.php\/info\/p(.*)_.*\.html product_reviews_write\.php\?products_id=$1 [L]'. "\n" .
'RewriteRule ^product_reviews_write\.php\/action\/process\/info\/p([0-9]*)_.*\.html product_reviews_write\.php\?action=process\&products_id=$1 [L]'. "\n" .
'' . "\n" .
'RewriteRule ^product_info\.php\/info\/p(.*)_.*\/action\/add_product product_info\.php\?products_id=$1\&action=add_product\ [L]'. "\n" .
'RewriteRule ^shopping_cart\.php\/products_id\/([0-9]*)\/info\/p([0-9]*)_.*\.html shopping_cart\.php\?products_id=$1 [L]'. "\n" .
'' . "\n" .
'RewriteRule ^(product_info|index|shop_content|news|faq|articles|article_info).php(.*)$ redirector.php [L]'. "\n" .
'' . "\n" .
'RewriteRule ^.*\.gif|\.jpg|\.jpeg|\.png|\.css|\.php|\.js$ - [L]'. "\n" .
'RewriteCond %{REQUEST_FILENAME} !-f'. "\n" .
'RewriteCond %{REQUEST_FILENAME} !-d'. "\n" .
'RewriteCond %{REQUEST_FILENAME} !-l'. "\n" .
'RewriteRule ^(.*).html(.*)$ manager.php [L]'. "\n" .
'' . "\n" .
'# PHP 5, Apache 1 and 2.'. "\n" .
'<IfModule mod_php5.c>'. "\n" .
'php_value magic_quotes_gpc                0'. "\n" .
'php_value register_globals                0'. "\n" .
'php_value session.auto_start              0'. "\n" .
'php_value mbstring.http_input             pass'. "\n" .
'php_value mbstring.http_output            pass'. "\n" .
'php_value mbstring.encoding_translation   0'. "\n" .
'php_value default_charset UTF-8'. "\n" .
'php_value mbstring.internal_encoding UTF-8'. "\n" .
'</IfModule>    '. "\n" .
'<IfModule mod_deflate.c>'. "\n" .
'    AddOutputFilterByType DEFLATE text/html text/plain text/css text/javascript text/json application/json application/x-javascript application/font-woff application/font-woff2'. "\n" .
'' . "\n" .
'<FilesMatch "\\\.(js|json|css|woff|woff2|ttf|eot|otf)$">'. "\n" .
'  SetOutputFilter DEFLATE'. "\n" .
'</FilesMatch>'. "\n" .
'</IfModule>'. "\n" .
'' . "\n" .
'<IfModule mod_expires.c>'. "\n" .
'  AddType application/vnd.ms-fontobject .eot'. "\n" .
'  AddType application/x-font-ttf .ttf'. "\n" .
'  AddType application/x-font-opentype .otf'. "\n" .
'  AddType application/x-font-woff .woff'. "\n" .
'  AddType application/x-font-woff2 .woff2'. "\n" .
'  AddType image/svg+xml .svg'. "\n" .
'  ExpiresActive On'. "\n" .
'  ExpiresByType text/css "access plus 10 years"'. "\n" .
'  ExpiresByType text/js "access plus 10 years"'. "\n" .
'  ExpiresByType text/javascript "access plus 10 years"'. "\n" .
'  ExpiresByType text/json "access plus 10 years"'. "\n" .
'  ExpiresByType application/json "access plus 10 years"'. "\n" .
'  ExpiresByType application/x-javascript "access plus 10 years"'. "\n" .
'  ExpiresByType application/javascript "access plus 10 years"'. "\n" .
'  ExpiresByType application/font-woff "access plus 10 years"'. "\n" .
'  ExpiresByType application/font-woff2 "access plus 10 years"'. "\n" .
'  ExpiresByType application/vnd.ms-fontobject "access plus 10 years"'. "\n" .
'  ExpiresByType application/x-font-ttf "access plus 10 years"'. "\n" .
'  ExpiresByType application/x-font-opentype "access plus 10 years"'. "\n" .
'  ExpiresByType application/x-font-woff "access plus 10 years"'. "\n" .
'  ExpiresByType application/x-font-woff2 "access plus 10 years"'. "\n" .
'  ExpiresByType image/svg+xml "access plus 10 years"'. "\n" .
'  ExpiresByType image/png "access plus 10 years"'. "\n" .
'  ExpiresByType image/x-icon "access plus 10 years"'. "\n" .
'  ExpiresByType image/vnd.microsoft.icon "access plus 10 years"'. "\n" .
'  ExpiresByType image/gif "access plus 10 years"'. "\n" .
'  ExpiresByType image/jpeg "access plus 10 years"'. "\n" .
'</IfModule>'. "\n" .
'' . "\n" .
'FileETag none'. "\n" .
'';

    $fp = fopen(DIR_FS_CATALOG . 'install/htaccess.txt', 'w');
    fputs($fp, $file_contents);
    fclose($fp);
    copy(DIR_FS_CATALOG . 'install/htaccess.txt', DIR_FS_CATALOG . '.htaccess');
    //@ unlink(DIR_FS_CATALOG . 'install/htaccess.txt');

?>

    <p>Установка и настройка успешно завершены!</p>

    <br />

    <table border="0" width="99%" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center"><a class="button" href="<?php echo $http_server . $http_catalog . 'index.php'; ?>" target="_blank"><span><img src="images/icons/buttons/catalog.png" alt="Catalog" title="Перейти в магазин" width="12" height="12"  />&nbsp;Перейти в магазин</span></a></td>
      </tr>
    </table>

    <br />

    <h3>Первые шаги после установки</h3>

    <p>Рекомендуем сразу после установки сделать следующее:</p>

    <ol>
      <li>Удалить директорию <?php echo $dir_fs_document_root . 'install'; ?></li>

<?php

  if (file_exists($dir_fs_document_root . 'includes/configure.php') && osc_is_writable($dir_fs_document_root . 'includes/configure.php')) {
?>

      <li>Установить на файл <?php echo $dir_fs_document_root . 'includes/configure.php'; ?> права доступа 644 (или 444).</li>

<?php
  }

  if (file_exists($dir_fs_document_root .  $admin_folder . '/includes/configure.php') && osc_is_writable($dir_fs_document_root . $admin_folder . '/includes/configure.php')) {
?>

      <li>Установить на файл <?php echo $dir_fs_document_root . $admin_folder . '/includes/configure.php'; ?> права доступа 644 (или 444).</li>

<?php
  }
?>

      <li>Установить на файл /admin/sxd/cfg.php права доступа 777.</li>
      <li>Установить на файл /admin/sxd/ses.php права доступа 777.</li>
      <li>Установить на директорию /admin/backups/ права доступа 777.</li>
      <li>Установить на директорию /images/product_images/ права доступа 777 и на поддиректории внутри.</li>
      <li>Установить на директорию /images/categories/ права доступа 777.</li>
      <li>Установить на директорию /cache/ права доступа 777.</li>
      <li>Установить на директорию /templates/vamshop/cache/ права доступа 777.</li>
      <li>Установить на директорию /templates/vamshop1/cache/ права доступа 777.</li>
      <li>Установить на директорию /templates/vamshop2/cache/ права доступа 777.</li>
      <li>Установить на директорию /templates/vamshop3/cache/ права доступа 777.</li>
      <li>Установить на директорию /templates/vamshop4/cache/ права доступа 777.</li>
      <li>Установить на директорию /import/ права доступа 777.</li>
      <li>Установить на директорию /export/ права доступа 777.</li>
      <li>Установить на директорию /tmp/ права доступа 777.</li>

    </ol>
  </div>
</div>