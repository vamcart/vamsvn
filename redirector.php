<?php
/*
  redirector.php

  Copyright (c) 2008 Andrew Yermakov ( andrew@cti.org.ua ) 
  Released under the BSD License
*/

  if (strpos($_SERVER['REQUEST_URI'], '?') === FALSE ) {
    require_once('includes/configure.php');
    require_once('includes/database_tables.php');
    require_once('inc/vam_db_prepare_input.inc.php');

    $db_l = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
    mysql_select_db(DB_DATABASE);
   
    $URI = array();

    if (preg_match('/\/(.*)\.php/', $_SERVER['REQUEST_URI'], $URI)) {

      $GET_array = array ();
      $vars = explode('/', $_SERVER['REQUEST_URI']);

      for ($i = 2, $n = sizeof($vars); $i < $n; $i ++) {
        if (strpos($vars[$i], '[]')) {
          $GET_array[substr($vars[$i], 0, -2)][] = $vars[$i +1];
        } else {
          $_GET[$vars[$i]] = htmlspecialchars($vars[$i +1]);
        }
        $i++;
      }

      if (sizeof($GET_array) > 0) {
        while (list ($key, $value) = each($GET_array)) {
          $_GET[$key] = htmlspecialchars($value);
        }
      }

      switch ($URI[1]) {
        case 'index':
          $cat = array();
          if (preg_match('/\/cat\/c(.*)_/', $_SERVER['REQUEST_URI'], $cat)) {
            $cURL = '';
            $query = 'select categories_url from ' . TABLE_CATEGORIES . ' where categories_id="' . (int)$cat[1] . '"';
            $result = mysql_query($query);   
            if (mysql_num_rows($result) > 0) {
              $row = mysql_fetch_array($result, MYSQL_ASSOC);
              $cURL = $row['categories_url'];
            }
            mysql_free_result($result);
            mysql_close();
            if (isset($cURL) && $cURL != '') {
              $url = HTTP_SERVER . '/'. $cURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/index.php';
          include('index.php');
          break;
        case 'product_info':
          $pi = array();
          if (preg_match('/\/info\/p(.*)_/', $_SERVER['REQUEST_URI'], $pi)) {
            $query = 'select products_page_url from ' . TABLE_PRODUCTS . ' where products_id="' . (int)$pi[1] . '"';
            $result = mysql_query($query);   
            if (mysql_num_rows($result) > 0) {
              $row = mysql_fetch_array($result, MYSQL_ASSOC);
              $pURL = $row['products_page_url'];
            }
            mysql_free_result($result);
            mysql_close();
            if (isset($pURL) && $pURL != '') {
              $url = HTTP_SERVER . '/' . $pURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/product_info.php';
          include('product_info.php');
          break;
        case 'shop_content':
          $coid = array();
          if (preg_match('/\/coID\/(.*)\//', $_SERVER['REQUEST_URI'], $coid)) {
            $query = 'select content_page_url from ' . TABLE_CONTENT_MANAGER . ' where content_id="' . (int)$coid[1] . '"';
            $result = mysql_query($query);   
            if (mysql_num_rows($result) > 0) {
              $row = mysql_fetch_array($result, MYSQL_ASSOC);
              $iURL = $row['content_page_url'];
            }
            mysql_free_result($result);
            mysql_close();
            if (isset($iURL) && $iURL != '') {
              $url = HTTP_SERVER . '/'. $iURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/shop_content.php';
          include('shop_content.php');
          break;
        default:
          break;
      }
    }
   
  } else { 
    $URI_elements = explode("?", ltrim($_SERVER['REQUEST_URI'], '/'));

    $requests = array();
    if (isset($URI_elements[1]) && (strlen($URI_elements[1]) > 0)) {
      $requests = explode("&", $URI_elements[1]);
    }

    if (sizeof($requests) > 0) {
      for ($i = 0, $n = sizeof($requests); $i < $n; $i++) {
        $param = explode("=", $requests[$i]);
        $_GET[$param[0]] = $param[1];
      } 
    }

    if (isset($URI_elements[0]) && (strlen($URI_elements[0]) > 0)) {

      require_once('includes/configure.php');
      require_once('includes/database_tables.php');
      require_once('inc/vam_db_prepare_input.inc.php');

      $db_l = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
      mysql_select_db(DB_DATABASE);

      if (isset($_GET['page'])) {
        switch ($_GET['page']) {
          case 'index':
            $URI_elements[0] = 'index.php';
            break;
          case 'product_info':
            $URI_elements[0] = 'product_info.php';
            break;
          case 'information':
            $URI_elements[0] = 'information.php';
            break;
          default:
            break;
        }
      }

      switch ($URI_elements[0]) {
        case 'index.php':
          if (isset($_GET['cat']) && $_GET['cat'] != '') {
            $cURL = '';
            $query = 'select categories_url from ' . TABLE_CATEGORIES . ' where categories_id="' . vam_db_prepare_input($_GET['cat']) . '"';
            $result = mysql_query($query);   
            if (mysql_num_rows($result) > 0) {
              $row = mysql_fetch_array($result, MYSQL_ASSOC);
              $cURL = $row['categories_url'];
            }
            mysql_free_result($result);
            mysql_close();
            if (isset($cURL) && $cURL != '') {
              $url = HTTP_SERVER . '/'. $cURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/index.php';
          include('index.php');
          break;
        case 'product_info.php':
          if (isset($_GET['products_id']) && $_GET['products_id'] != '') {
            $query = 'select products_page_url from ' . TABLE_PRODUCTS . ' where products_id="' . vam_db_prepare_input($_GET['products_id']) . '"';
            $result = mysql_query($query);   
            if (mysql_num_rows($result) > 0) {
              $row = mysql_fetch_array($result, MYSQL_ASSOC);
              $pURL = $row['products_page_url'];
            }
            mysql_free_result($result);
            mysql_close();
            if (isset($pURL) && $pURL != '') {
              $url = HTTP_SERVER . '/' . $pURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/product_info.php';
          include('product_info.php');
          break;
        case 'shop_content.php':
          if (isset($_GET['coID']) && $_GET['coID'] != '') {
            $query = 'select content_page_url from ' . TABLE_CONTENT_MANAGER . ' where content_id="' . vam_db_prepare_input($_GET['coID']) . '"';
            $result = mysql_query($query);   
            if (mysql_num_rows($result) > 0) {
              $row = mysql_fetch_array($result, MYSQL_ASSOC);
              $iURL = $row['content_page_url'];
            }
            mysql_free_result($result);
            mysql_close();
            if (isset($iURL) && $iURL != '') {
              $url = HTTP_SERVER . '/'. $iURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/shop_content.php';
          include('shop_content.php');
          break;
        default:
          break;
      }
    } else {
      $PHP_SELF = '/index.php';
      include('index.php');
    }
  }
