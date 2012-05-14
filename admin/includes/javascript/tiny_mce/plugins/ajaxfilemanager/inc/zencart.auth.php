<?php
/**
 * Verify authorization zen-cart admin
 *
 * @package Admin
 * @copyright Copyright 2005-2010 Andrew Berezin eCommerce-Service.com
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: zencart.auth.php 1.6 20.02.2011 13:33:52 AndrewBerezin $
 */

$_SESSION['customers_status_id'] = 1;

  if (isset($_GET['sid']) && isset($_GET['vam'])) {
    $dir_ws_admin = preg_replace('/[^a-zA-Z0-9\-_]/', '', $_GET['vam']) . '/';
    $dir_fs_admin = str_replace('\\', '/', __FILE__);
    $dir_fs_admin = substr($dir_fs_admin, 0, strpos($dir_fs_admin, '/includes/javascript/tiny_mce/plugins/ajaxfilemanager/')) . '/';
    $cwd = getcwd();
    chdir($dir_fs_admin);
    if (file_exists('includes/local/configure.php')) {
      include('includes/local/configure.php');
    }
    if (file_exists('includes/configure.php')) {
      include('includes/configure.php');
    }
    if (!defined('SESSION_WRITE_DIRECTORY')) define('SESSION_WRITE_DIRECTORY', session_save_path());
    if (defined('DB_DATABASE')) {
      if (($zen_mysql_link = @mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD)) && (@mysql_select_db(DB_DATABASE, $zen_mysql_link))) {
        if (!defined('DB_PREFIX')) define('DB_PREFIX', '');
    // Modified piece of code from whos_online.php
        $info = $_GET['sid'];

        $session_data = '';
        if (STORE_SESSIONS == 'mysql') {
          $session_data_query = mysql_query("select value from " . DB_PREFIX . "sessions
                                        WHERE sesskey = '" . $info . "'", $zen_mysql_link);

          if ($session_data = mysql_fetch_array($session_data_query, MYSQL_ASSOC)) {
            $session_data = trim($session_data['value']);
          }
        } else {
          if (!defined('SESSION_WRITE_DIRECTORY')) {
            $session_write_directory_query = mysql_query("SELECT * FROM " . DB_PREFIX . "configuration WHERE configuration_key='SESSION_WRITE_DIRECTORY'", $zen_mysql_link);
            if (mysql_num_rows($session_write_directory_query) > 0) {
              $session_write_directory = mysql_fetch_array($session_write_directory_query, MYSQL_ASSOC);
              $session_write_directory = $session_write_directory['configuration_value'];
            }
          } else {
            $session_write_directory = SESSION_WRITE_DIRECTORY;
          }

          $session_file = $session_write_directory . '/sess_' . $info;
          if ( (file_exists($session_file)) && (filesize($session_file) > 0) ) {
            $session_data = file($session_file);
            $session_data = trim(implode('', $session_data));
          }
        }

        $hardenedStatus = FALSE;
        $suhosinExtension = extension_loaded('suhosin');
        $suhosinSetting = strtoupper(@ini_get('suhosin.session.encrypt'));

        //if (!$suhosinExtension) {
          if (strpos($session_data, 'customers_status_id') == 0) $session_data = base64_decode($session_data);
          if (strpos($session_data, 'customers_status_id') == 0) $session_data = '';
        //}
        // uncomment the following line if you have suhosin enabled and see errors on the cart-contents sidebar
        //$hardenedStatus = ($suhosinExtension == TRUE || $suhosinSetting == 'On' || $suhosinSetting == 1) ? TRUE : FALSE;
        if ($session_data != '' && $hardenedStatus == TRUE) $session_data = '';

        if ($length = strlen($session_data) && strpos($session_data, 'customers_status_id') !== false) {
          $start_id = (int)strpos($session_data, 'customers_status_id');
          $session_data_id = substr($session_data, $start_id, (strpos($session_data, ';', $start_id) - $start_id + 7));
          $session_data_id = str_replace('customers_status_id";s:1:"0','customers_status_id|0',$session_data_id);

    //      session_decode($session_data_id);
          $session_data_id = explode('|', $session_data_id);

          if (isset($session_data_id[1])) {
            $_SESSION[$session_data_id[0]] = $session_data_id[1];
          }

        }
/*
        if (isset($_SESSION['admin_id'])) {
          $admin_name_query = mysql_query("SELECT * FROM " . DB_PREFIX . "admin WHERE admin_id=" . (int)$_SESSION['admin_id'], $zen_mysql_link);
          if (mysql_num_rows($admin_name_query) > 0) {
            $admin_name = mysql_fetch_array($admin_name_query, MYSQL_ASSOC);
            $user = $admin_name['admin_name'];
            if (ENABLE_SSL_ADMIN == 'true') {
              $zen_link = HTTPS_SERVER . DIR_WS_HTTPS_ADMIN;
            } else {
              $zen_link = HTTP_SERVER . DIR_WS_ADMIN;
            }
          }
        }
*/
      }
      if (isset($zen_mysql_link) && is_resource($zen_mysql_link)) {
        mysql_close($zen_mysql_link);
        unset($zen_mysql_link);
      }
    }
    chdir($cwd);
  }

  if ($_SESSION['customers_status_id'] == 0) {
    $_SESSION[$auth->__loginIndexInSession] = true;
  } else {
//    header('HTTP/1.1 406 Not Acceptable');
    header('HTTP/1.1 403 Forbidden');
    echo 'Forbidden';
    exit(0);
  }