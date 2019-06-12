<?php
/*
  redirector.php

  Copyright (c) 2008 Andrew Yermakov ( andrew@cti.org.ua ) 
  Released under the BSD License
*/

  require_once('includes/configure.php');

  if (defined('DIR_WS_INCLUDES') === false) {
    header('Location: install');
    exit();
  }

  if (strpos($_SERVER['REQUEST_URI'], '?') === FALSE ) {
    require_once('includes/database_tables.php');
    require_once('inc/vam_db_prepare_input.inc.php');

    $root_depth = count_chars(DIR_WS_CATALOG, 0);
    $root_depth = $root_depth[ord('/')] - 1;

    $db_l = mysqli_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
   
    $URI = array();

    if (preg_match('/(((.*)\/)*)(.*)\.php/', $_SERVER['REQUEST_URI'], $URI)) {

      $GET_array = array ();
      $vars = explode('/', $_SERVER['REQUEST_URI']);

      for ($i = $root_depth + 2, $n = sizeof($vars); $i < $n; $i ++) {
        if (strpos($vars[$i], '[]')) {
          $GET_array[substr($vars[$i], 0, -2)][] = $vars[$i +1];
        } else {
          $_GET[$vars[$i]] = htmlspecialchars($vars[$i +1]);
        }
        $i++;
      }

      if (sizeof($GET_array) > 0) {
        foreach ($GET_array as $key => $value) {
          $_GET[$key] = htmlspecialchars($value);
        }
      }

      switch ($URI[sizeof($URI) - 1]) {
        case 'index':
          $cat = array();
          if (preg_match('/\/cat\/c(.*)_/', $_SERVER['REQUEST_URI'], $cat)) {
            $cURL = '';
            $query = 'select categories_url from ' . TABLE_CATEGORIES . ' where categories_id="' . (int)$cat[1] . '"';
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $cURL = $row['categories_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($cURL) && $cURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG . $cURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          if (preg_match('/\/manufacturers_id\/(.*)\//', $_SERVER['REQUEST_URI'], $manid)) {
            $cURL = '';
            $query = 'select manufacturers_seo_url from ' . TABLE_MANUFACTURERS . ' where manufacturers_id="' . (int)$manid[1] . '"';
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $mURL = $row['manufacturers_seo_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($mURL) && $mURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG . $mURL;
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
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $pURL = $row['products_page_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($pURL) && $pURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG . $pURL;
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
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $iURL = $row['content_page_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($iURL) && $iURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG . $iURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/shop_content.php';
          include('shop_content.php');
          break;
        case 'article_info':
          $articleid = array();
          if (preg_match('/\/articles_id\/(.*)\//', $_SERVER['REQUEST_URI'], $articleid)) {
            $query = 'select articles_page_url from ' . TABLE_ARTICLES . ' where articles_id="' . (int)$articleid[1] . '"';
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $aURL = $row['articles_page_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($aURL) && $aURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG . $aURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/article_info.php';
          include('article_info.php');
          break;

        case 'news':
          $newsid = array();
          if (preg_match('/\/news_id\/(.*)\//', $_SERVER['REQUEST_URI'], $newsid)) {
            $query = 'select news_page_url from ' . TABLE_LATEST_NEWS . ' where news_id="' . (int)$newsid[1] . '"';
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $nURL = $row['news_page_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($nURL) && $nURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG . $nURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/news.php';
          include('news.php');
          break;

        case 'faq':
          $faqid = array();
          if (preg_match('/\/faq_id\/(.*)\//', $_SERVER['REQUEST_URI'], $faqid)) {
            $query = 'select faq_page_url from ' . TABLE_FAQ . ' where faq_id="' . (int)$faqid[1] . '"';
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $fURL = $row['faq_page_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($fURL) && $fURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG . $fURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/faq.php';
          include('faq.php');
          break;

        case 'articles':
          $topicid = array();
          if (preg_match('/\/tPath\/(.*)\//', $_SERVER['REQUEST_URI'], $topicid)) {
            $topicid = explode("_",$topicid[1]);
            $topicid = $topicid[1];
            $query = 'select topics_page_url from ' . TABLE_TOPICS . ' where topics_id="' . (int)$topicid[1] . '"';
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $tURL = $row['topics_page_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($tURL) && $tURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG . $tURL;
              //header("HTTP/1.1 301 Moved Permanently");
              //header('Location: ' . $url);
              //exit();
            }
          }
          $PHP_SELF = '/articles.php';
          include('articles.php');
          break;

        default:
          break;
      }
    } else {
      $PHP_SELF = '/index.php';
      include('index.php');
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

      require_once('includes/database_tables.php');
      require_once('inc/vam_db_prepare_input.inc.php');

      $db_l = mysqli_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

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
          case 'article_info':
            $URI_elements[0] = 'article_info.php';
            break;
          case 'articles':
            $URI_elements[0] = 'articles.php';
            break;
          case 'news':
            $URI_elements[0] = 'news.php';
            break;
          case 'faq':
            $URI_elements[0] = 'faq.php';
            break;
          default:
            break;
        }
      }

      preg_match('/(((.*)\/)*)(.*)\.php/', $URI_elements[0], $URI);

      switch ($URI[sizeof($URI) - 1]) {
        case 'index':
          if (isset($_GET['cat']) && $_GET['cat'] != '') {
            $cURL = '';
            $query = 'select categories_url from ' . TABLE_CATEGORIES . ' where categories_id="' . vam_db_prepare_input($_GET['cat']) . '"';
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $cURL = $row['categories_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($cURL) && $cURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG. $cURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          if (isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] != '') {
            $mURL = '';
            $query = 'select manufacturers_seo_url from ' . TABLE_MANUFACTURERS . ' where manufacturers_id="' . vam_db_prepare_input($_GET['manufacturers_id']) . '"';
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $mURL = $row['manufacturers_seo_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($mURL) && $mURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG. $mURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/index.php';
          include('index.php');
          break;
        case 'product_info':
          if (isset($_GET['products_id']) && $_GET['products_id'] != '') {
            $query = 'select products_page_url from ' . TABLE_PRODUCTS . ' where products_id="' . vam_db_prepare_input($_GET['products_id']) . '"';
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $pURL = $row['products_page_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($pURL) && $pURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG . $pURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/product_info.php';
          include('product_info.php');
          break;
        case 'shop_content':
          if (isset($_GET['coID']) && $_GET['coID'] != '') {
            $query = 'select content_page_url from ' . TABLE_CONTENT_MANAGER . ' where content_id="' . vam_db_prepare_input($_GET['coID']) . '"';
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $iURL = $row['content_page_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($iURL) && $iURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG. $iURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/shop_content.php';
          include('shop_content.php');
          break;
        case 'article_info':
          if (isset($_GET['articles_id']) && $_GET['articles_id'] != '') {
            $query = 'select articles_page_url from ' . TABLE_ARTICLES . ' where articles_id="' . vam_db_prepare_input($_GET['articles_id']) . '"';
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $aURL = $row['articles_page_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($aURL) && $aURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG. $aURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/article_info.php';
          include('article_info.php');
          break;
        case 'news':
          if (isset($_GET['news_id']) && $_GET['news_id'] != '') {
            $query = 'select news_page_url from ' . TABLE_LATEST_NEWS . ' where news_id="' . vam_db_prepare_input($_GET['news_id']) . '"';
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $nURL = $row['news_page_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($nURL) && $nURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG. $nURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/news.php';
          include('news.php');
          break;
        case 'faq':
          if (isset($_GET['faq_id']) && $_GET['faq_id'] != '') {
            $query = 'select faq_page_url from ' . TABLE_FAQ . ' where faq_id="' . vam_db_prepare_input($_GET['faq_id']) . '"';
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $fURL = $row['faq_page_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($fURL) && $fURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG. $fURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/faq.php';
          include('faq.php');
          break;
        case 'articles':
          if (isset($_GET['tPath']) && $_GET['tPath'] != '') {
            $query = 'select topics_page_url from ' . TABLE_TOPICS . ' where topics_id="' . vam_db_prepare_input($_GET['tPath']) . '"';
            $result = mysqli_query($db_l, $query);   
            if (mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $tURL = $row['topics_page_url'];
            }
            mysqli_free_result($result);
            mysqli_close($db_l);
            if (isset($tURL) && $tURL != '') {
              $url = HTTP_SERVER . DIR_WS_CATALOG. $tURL;
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: ' . $url);
              exit();
            }
          }
          $PHP_SELF = '/articles.php';
          include('articles.php');
          break;
        default:
          break;
      }
    } else {
      $PHP_SELF = '/index.php';
      include('index.php');
    }
  }
