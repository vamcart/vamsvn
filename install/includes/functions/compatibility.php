<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

  if (PHP_VERSION >= 4.1) {
    $_GET =& $_GET;
    $_POST =& $_POST;
    $HTTP_COOKIE_VARS =& $_COOKIE;
    $HTTP_SESSION_VARS =& $_SESSION;
    $HTTP_SERVER_VARS =& $_SERVER;
  } else {
    if (!is_array($_GET)) $_GET = array();
    if (!is_array($_POST)) $_POST = array();
    if (!is_array($HTTP_COOKIE_VARS)) $HTTP_COOKIE_VARS = array();
  }

  if (!function_exists('is_numeric')) {
    function is_numeric($param) {
      return ereg('^[0-9]{1,50}.?[0-9]{0,50}$', $param);
    }
  }
     
?>
