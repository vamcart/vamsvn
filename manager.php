<?php
/*
  manager.php

  Copyright (c) 2008 Andrew Yermakov ( andrew@cti.org.ua ) 
  Released under the BSD License
*/

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

    $categories_array = array();

    $path_elements = explode("/", $URI_elements[0]);
    //$URI_elements[0] = $path_elements[sizeof($path_elements) - 1];
    
    $db_l = mysqli_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);

    $query = 'select categories_id from ' . TABLE_CATEGORIES . ' where BINARY categories_url="' . vam_db_prepare_input($URI_elements[0]) . '"';
    $result = mysqli_query($db_l, $query);
    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $cId = $row['categories_id'];
      $matched = true;
    } else {
      $matched = false;
    }

    if ($matched) {
      $HTTP_GET_VARS['cat'] = $cId;
      $_GET['cat'] = $cId;

      mysqli_free_result($result);
      mysqli_close($db_l);
      $PHP_SELF = '/index.php';
      include('index.php');
    } else {
      mysqli_free_result($result);
      $query = 'select products_id from ' . TABLE_PRODUCTS . ' where BINARY products_page_url="' . vam_db_prepare_input($URI_elements[0]) . '"';
      $result = mysqli_query($db_l, $query);
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $pId = $row['products_id'];
        $matched = true;
      } else {
        $matched = false;
      }
      if ($matched) {
        $HTTP_GET_VARS['products_id']  = $pId;
        $_GET['products_id']  = $pId;
        
        mysqli_free_result($result);
        mysqli_close($db_l);
        $PHP_SELF = '/product_info.php';
        include('product_info.php');
      } else {
        mysqli_free_result($result);

      $query = 'select manufacturers_id from ' . TABLE_MANUFACTURERS . ' where BINARY manufacturers_seo_url="' . vam_db_prepare_input($URI_elements[0]) . '"';
      $result = mysqli_query($db_l, $query);
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $mId = $row['manufacturers_id'];
        $matched = true;
      } else {
        $matched = false;
      }
      if ($matched) {
        $HTTP_GET_VARS['manufacturers_id']  = $mId;
        $_GET['manufacturers_id']  = $mId;
        
        mysqli_free_result($result);
        mysqli_close($db_l);
        $PHP_SELF = '/index.php';
        include('index.php');
      } else {
        mysqli_free_result($result);


        $query = 'select content_id from ' . TABLE_CONTENT_MANAGER . ' where BINARY content_page_url="' . vam_db_prepare_input($URI_elements[0]) . '"';
        $result = mysqli_query($db_l, $query);
        if (mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          $coID = $row['content_id'];
          $matched = true;
        } else {
          $matched = false;
        }
        if ($matched) {
          $HTTP_GET_VARS['coID']  = $coID;
          $_GET['coID']  = $coID;
          mysqli_free_result($result);
          mysqli_close($db_l);
          $PHP_SELF = '/shop_content.php';
          include('shop_content.php');
        } else {
        
        mysqli_free_result($result);
        $query = 'select articles_id from ' . TABLE_ARTICLES . ' where BINARY articles_page_url="' . vam_db_prepare_input($URI_elements[0]) . '"';
        $result = mysqli_query($db_l, $query);
        if (mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          $aID = $row['articles_id'];
          $matched = true;
        } else {
          $matched = false;
        }
        if ($matched) {
          $HTTP_GET_VARS['articles_id']  = $aID;
          $_GET['articles_id']  = $aID;
          mysqli_free_result($result);
          mysqli_close($db_l);
          $PHP_SELF = '/article_info.php';
          include('article_info.php');
        } else {
        

        mysqli_free_result($result);
        $query = 'select topics_id from ' . TABLE_TOPICS . ' where BINARY topics_page_url="' . vam_db_prepare_input($URI_elements[0]) . '"';
        $result = mysqli_query($db_l, $query);
        if (mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          $tID = $row['topics_id'];
          $matched = true;
        } else {
          $matched = false;
        }
        if ($matched) {
          $HTTP_GET_VARS['tPath']  = $tID;
          $_GET['tPath']  = $tID;
          mysqli_free_result($result);
          mysqli_close($db_l);
          $PHP_SELF = '/articles.php';
          include('articles.php');
        } else {

        mysqli_free_result($result);
        $query = 'select news_id from ' . TABLE_LATEST_NEWS . ' where BINARY news_page_url="' . vam_db_prepare_input($URI_elements[0]) . '"';
        $result = mysqli_query($db_l, $query);
        if (mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          $nID = $row['news_id'];
          $matched = true;
        } else {
          $matched = false;
        }
        if ($matched) {
          $HTTP_GET_VARS['news_id']  = $nID;
          $_GET['news_id']  = $nID;
          mysqli_free_result($result);
          mysqli_close($db_l);
          $PHP_SELF = '/news.php';
          include('news.php');
        } else {

        $query = 'select faq_id from ' . TABLE_FAQ . ' where BINARY faq_page_url="' . vam_db_prepare_input($URI_elements[0]) . '"';
        $result = mysqli_query($db_l, $query);
        if (mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
          $fID = $row['faq_id'];
          $matched = true;
        } else {
          $matched = false;
        }
        if ($matched) {
          $HTTP_GET_VARS['faq_id']  = $fID;
          $_GET['faq_id']  = $fID;
          mysqli_free_result($result);
          mysqli_close($db_l);
          $PHP_SELF = '/faq.php';
          include('faq.php');
        } else {
       
          mysqli_free_result($result);
          mysqli_close($db_l);

          $PHP_SELF = '/index.php';
          //header("HTTP/1.1 301 Moved Permanently");
          //header("Location: ".DIR_WS_CATALOG."404.html");
          
				header('HTTP/1.1 404 Not Found');
				$_GET['coID'] = '12'; // 12 - это id нужной информационной страницы
				include __DIR__ . '/shop_content.php';
				exit();          
          
          }
        }        
      }
     }
    }  
        }
      }
    }
  } else {
    $PHP_SELF = '/index.php';
    include('index.php');
  }



  function get_parent_categories(&$categories, $categories_id) {
    $parent_categories_query = "select parent_id
                                from " . TABLE_CATEGORIES . "
                                where categories_id = '" . (int)$categories_id . "'";

    $result = mysqli_query($db_l, $parent_categories_query);

    while ($parent_categories = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      if ($parent_categories['parent_id'] == 0) return true;
      $categories[sizeof($categories)] = $parent_categories['parent_id'];
      if ($parent_categories['parent_id'] != $categories_id) {
        get_parent_categories($categories, $parent_categories['parent_id']);
      }
    }
  }



  function product_path($products_id) {
    $cPath = '';

    $category_query = "select p2c.categories_id
                       from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
                       where p.products_id = '" . (int)$products_id . "'
                       and p.products_status = '1'
                       and p.products_id = p2c.products_id limit 1";

    $category = mysqli_query($db_l, $category_query);

    if (mysqli_num_rows($category) > 0) {

      $category = mysqli_fetch_array($category, MYSQLI_ASSOC);

      $categories = array();
      get_parent_categories($categories, $category['categories_id']);

      $categories = array_reverse($categories);

      $cPath = implode('_', $categories);

      if (not_null($cPath)) $cPath .= '_';
      $cPath .= $category['categories_id'];
    }

    return $cPath;
  }


  function not_null($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
        return true;
      } else {
        return false;
      }
    }
  }
