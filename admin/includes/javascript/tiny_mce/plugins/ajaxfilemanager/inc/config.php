<?php
  /**
   * sysem  config setting
   * @author Logan Cai (cailongqun [at] yahoo [dot] com [dot] cn)
   * @link www.phpletter.com
   * @version 1.0
   * @since 22/April/2007
   *
   */

  //FILESYSTEM CONFIG <br>
  require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "class.auth.php");
  define('CONFIG_QUERY_STRING_ENABLE', true); //Enable passed query string to setting the system configuration
  if(!isset($_SESSION))
  {
    session_start();
  }
  if(!headers_sent())
  {
    header('Content-Type: text/html; charset=utf-8');
  }

  /**
   * secure file name which retrieve from query string
   *
   * @param string $input
   * @return string
   */
  function secureFileName($input)
  {
    return preg_replace('/[^a-zA-Z0-9\-_]/', '', $input);
  }
  //Directories Declarations

  define('DIR_AJAX_ROOT', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR) ; // the path to ajax file manager
  define('DIR_AJAX_INC', DIR_AJAX_ROOT . "inc" . DIRECTORY_SEPARATOR);
  define('DIR_AJAX_CLASSES', DIR_AJAX_ROOT .  "classes" . DIRECTORY_SEPARATOR);
  define("DIR_AJAX_LANGS", DIR_AJAX_ROOT . "langs" . DIRECTORY_SEPARATOR);
  define('DIR_AJAX_JS', DIR_AJAX_ROOT . 'jscripts' . DIRECTORY_SEPARATOR);
  define('DIR_AJAX_EDIT_AREA', DIR_AJAX_JS . 'edit_area' . DIRECTORY_SEPARATOR);
  define('DIR_LANG', DIR_AJAX_ROOT . 'langs' . DIRECTORY_SEPARATOR);


  //Class Declarations
  define('CLASS_FILE', DIR_AJAX_INC .'class.file.php');
  define("CLASS_UPLOAD", DIR_AJAX_INC .  'class.upload.php');
  define('CLASS_MANAGER', DIR_AJAX_INC . 'class.manager.php');
  define('CLASS_IMAGE', DIR_AJAX_INC . "class.image.php");
  define('CLASS_HISTORY', DIR_AJAX_INC . "class.history.php");
  define('CLASS_SESSION_ACTION', DIR_AJAX_INC . "class.sessionaction.php");
  define('CLASS_PAGINATION', DIR_AJAX_INC . 'class.pagination.php');
  define('CLASS_SEARCH', DIR_AJAX_INC . "class.search.php");
  //SCRIPT FILES declarations
  define('SPT_FUNCTION_BASE', DIR_AJAX_INC . 'function.base.php');
  //include different config base file according to query string "config"
  $configBaseFileName = 'config.base.php';

  if(CONFIG_QUERY_STRING_ENABLE && !empty($_GET['config']) && file_exists(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'config.' . secureFileName($_GET['config']) . ".php")
  {
    $configBaseFileName = 'config.' . secureFileName($_GET['config']) . ".php";
  }
  require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . $configBaseFileName);


  require_once(DIR_AJAX_LANGS . CONFIG_LANG_DEFAULT . ".php");
  require_once(DIR_AJAX_INC . "function.base.php");

  require_once(dirname(__FILE__) .  DIRECTORY_SEPARATOR . "class.session.php");
  $session = new Session();
  $auth = new Auth();
// BOF zen-cart integration

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
    define('SESSION_WRITE_DIRECTORY', DIR_FS_CATALOG . 'tmp');
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

        if (!$suhosinExtension) {
          if (strpos($session_data, 'customers_status_id') == 0) $session_data = base64_decode($session_data);
          if (strpos($session_data, 'customers_status_id') == 0) $session_data = '';
        }
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
// EOF zen-cart integration

  if(CONFIG_ACCESS_CONTROL_MODE == 1)
  {//access control enabled
    if(!$auth->isLoggedIn() && strtolower(basename($_SERVER['PHP_SELF'])) != strtolower(basename(CONFIG_LOGIN_PAGE)))
    {//
      header('Location: ' . appendQueryString(CONFIG_LOGIN_PAGE, makeQueryString()));
      exit;
    }
  }
  addNoCacheHeaders();
  //URL Declartions
  define('CONFIG_URL_IMAGE_PREVIEW', 'ajax_image_preview.php');
  define('CONFIG_URL_CREATE_FOLDER', 'ajax_create_folder.php');
  define('CONFIG_URL_DELETE', 'ajax_delete_file.php');
  define('CONFIG_URL_HOME', 'ajaxfilemanager.php');
  define("CONFIG_URL_UPLOAD", 'ajax_file_upload.php');
  define('CONFIG_URL_PREVIEW', 'ajax_preview.php');
  define('CONFIG_URL_SAVE_NAME', 'ajax_save_name.php');
  define('CONFIG_URL_IMAGE_EDITOR', 'ajax_image_editor.php');
  define('CONFIG_URL_IMAGE_SAVE', 'ajax_image_save.php');
  define('CONFIG_URL_IMAGE_RESET', 'ajax_editor_reset.php');
  define('CONFIG_URL_IMAGE_UNDO', 'ajax_image_undo.php');
  define('CONFIG_URL_CUT', 'ajax_file_cut.php');
  define('CONFIG_URL_COPY', 'ajax_file_copy.php');
  define('CONFIG_URL_LOAD_FOLDERS', '_ajax_load_folders.php');

  define('CONFIG_URL_DOWNLOAD', 'ajax_download.php');
  define('CONFIG_URL_TEXT_EDITOR', 'ajax_text_editor.php');
  define('CONFIG_URL_GET_FOLDER_LIST', 'ajax_get_folder_listing.php');
  define('CONFIG_URL_SAVE_TEXT', 'ajax_save_text.php');
  define('CONFIG_URL_LIST_LISTING', 'ajax_get_file_listing.php');
  define('CONFIG_URL_IMG_THUMBNAIL', 'ajax_image_thumbnail.php');
  define('CONFIG_URL_FILEnIMAGE_MANAGER', 'ajaxfilemanager.php');
  define('CONFIG_URL_FILE_PASTE', 'ajax_file_paste.php');


?>