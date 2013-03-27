<?php
/* --------------------------------------------------------------
   $Id: sessions.php 950 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(sessions.php,v 1.16 2003/04/02); www.oscommerce.com 
   (c) 2003	 nextcommerce (sessions.php,v 1.7 2003/08/18); www.nextcommerce.org
   (c) 2004 xt:Commerce (sessions.php,v 1.7 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

  if (STORE_SESSIONS == 'mysqli') {

    function _sess_open($save_path, $session_name) {
      return true;
    }

    function _sess_close() {
      return true;
    }

    function _sess_read($key) {
      $qid = vam_db_query("select value from " . TABLE_SESSIONS . " where sesskey = '" . $key . "' and expiry > '" . time() . "'");

      $value = vam_db_fetch_array($qid);
      if ($value['value']) {
        return $value['value'];
      }

      return false;
    }

    function _sess_write($key, $val) {

      $expiry = time() + SESSION_TIMEOUT_ADMIN;
      $value = addslashes($val);

      $qid = vam_db_query("select count(*) as total from " . TABLE_SESSIONS . " where sesskey = '" . $key . "'");
      $total = vam_db_fetch_array($qid);

      if ($total['total'] > 0) {
        return vam_db_query("update " . TABLE_SESSIONS . " set expiry = '" . $expiry . "', value = '" . $value . "' where sesskey = '" . $key . "'");
      } else {
        return vam_db_query("insert into " . TABLE_SESSIONS . " values ('" . $key . "', '" . $expiry . "', '" . $value . "')");
      }
    }

    function _sess_destroy($key) {
      return vam_db_query("delete from " . TABLE_SESSIONS . " where sesskey = '" . $key . "'");
    }

    function _sess_gc($maxlifetime) {
      vam_db_query("delete from " . TABLE_SESSIONS . " where expiry < '" . time() . "'");

      return true;
    }

    session_set_save_handler('_sess_open', '_sess_close', '_sess_read', '_sess_write', '_sess_destroy', '_sess_gc');
  }

  function vam_session_start() {
	@ini_set('session.gc_maxlifetime', SESSION_TIMEOUT_ADMIN);
    return session_start();
  }

  function vam_session_register($variable) {
    global $session_started;

    if ($session_started == true) {
      return $_SESSION[$variable];
    }
  }

  function vam_session_is_registered($variable) {
    return isset($_SESSION[$variable]);
  }

  function vam_session_unregister($variable) {
    unset($_SESSION[$variable]);
  }

  function vam_session_id($sessid = '') {
    if (!empty($sessid)) {
      return session_id($sessid);
    } else {
      return session_id();
    }
  }

  function vam_session_name($name = '') {
    if (!empty($name)) {
      return session_name($name);
    } else {
      return session_name();
    }
  }

  function vam_session_close() {
    if (function_exists('session_close')) {
      return session_close();
    }
  }

  function vam_session_destroy() {
    return session_destroy();
  }

  function vam_session_save_path($path = '') {
    if (!empty($path)) {
      return session_save_path($path);
    } else {
      return session_save_path();
    }
  }

  function vam_session_recreate() {
    if (PHP_VERSION >= 4.1) {
      $session_backup = $_SESSION;

      unset($_COOKIE[vam_session_name()]);

      vam_session_destroy();

      if (STORE_SESSIONS == 'mysqli') {
        session_set_save_handler('_sess_open', '_sess_close', '_sess_read', '_sess_write', '_sess_destroy', '_sess_gc');
      }

      vam_session_start();

      $_SESSION = $session_backup;
      unset($session_backup);
    }
  }
?>