<?php
/* -----------------------------------------------------------------------------------------
   $Id: compatibility.php 899 2007-02-06 02:40:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(compatibility.php,v 1.19 2003/04/09); www.oscommerce.com 
   (c) 2003	 nextcommerce (compatibility.php,v 1.5 2003/08/13); www.nextcommerce.org 
   (c) 2004	 xt:Commerce (compatibility.php,v 1.5 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License
   Modified by Marco Canini, <m.canini@libero.it>
   Fixed a bug with arrays in $HTTP_xxx_VARS
   ---------------------------------------------------------------------------------------*/

  ////
  // Recursively handle magic_quotes_gpc turned off.
  // This is due to the possibility of have an array in
  // $HTTP_xxx_VARS
  // Ie, products attributes
  function do_magic_quotes_gpc(&$ar) {
    if (!is_array($ar)) return false;

    foreach ($ar as $key => $value) {
      if (is_array($value)) {
        do_magic_quotes_gpc($value);
      } else {
        $ar[$key] = addslashes($value);
      }
    }
  }

  // $HTTP_xxx_VARS are always set on php4
  if (!is_array($_GET)) $_GET = array();
  if (!is_array($_POST)) $_POST = array();
  if (!is_array($_COOKIE)) $_COOKIE = array();

  // handle magic_quotes_gpc turned off.
  if (!get_magic_quotes_gpc()) {
    do_magic_quotes_gpc($_GET);
    do_magic_quotes_gpc($_POST);
    do_magic_quotes_gpc($_COOKIE);
  }

// set default timezone if none exists (PHP 5.3 throws an E_WARNING)
  if (PHP_VERSION >= '5.2') {
    date_default_timezone_set(defined('CFG_TIME_ZONE') ? CFG_TIME_ZONE : date_default_timezone_get());
  }

  if (!function_exists('array_splice')) {
    function array_splice(&$array, $maximum) {
      if (sizeof($array) >= $maximum) {
        for ($i=0; $i<$maximum; $i++) {
          $new_array[$i] = $array[$i];
        }
        $array = $new_array;
      }
    }
  }

  if (!function_exists('in_array')) {
    function in_array($lookup_value, $lookup_array) {
      reset($lookup_array);
      while (list($key, $value) = each($lookup_array)) {
        if ($value == $lookup_value) return true;
      }

      return false;
    }
  }

  if (!function_exists('array_reverse')) {
    function array_reverse($array) {
      for ($i=0, $n=sizeof($array); $i<$n; $i++) $array_reversed[$i] = $array[($n-$i-1)];

      return $array_reversed;
    }
  }

  if (!function_exists('constant')) {
    function constant($constant) {
      eval("\$temp=$constant;");

      return $temp;
    }
  }

  if (!function_exists('is_null')) {
    function is_null($value) {
      if (is_array($value)) {
        if (sizeof($value) > 0) {
          return false;
        } else {
          return true;
        }
      } else {
        if (($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0)) {
          return false;
        } else {
          return true;
        }
      }
    }
  }

  if (!function_exists('array_merge')) {
    function array_merge($array1, $array2, $array3 = '') {
      if (empty($array3) && !is_array($array3)) $array3 = array();
      while (list($key, $val) = each($array1)) $array_merged[$key] = $val;
      while (list($key, $val) = each($array2)) $array_merged[$key] = $val;
      if (sizeof($array3) > 0) while (list($key, $val) = each($array3)) $array_merged[$key] = $val;

      return (array) $array_merged;
    }
  }

  if (!function_exists('is_numeric')) {
    function is_numeric($param) {
      return preg_match('/^[0-9]{1,50}.?[0-9]{0,50}$/i', $param);
    }
  }

  if (!function_exists('array_slice')) {
    function array_slice($array, $offset, $length = 0) {
      if ($offset < 0 ) {
        $offset = sizeof($array) + $offset;
      }
      $length = ((!$length) ? sizeof($array) : (($length < 0) ? sizeof($array) - $length : $length + $offset));
      for ($i = $offset; $i<$length; $i++) {
        $tmp[] = $array[$i];
      }

      return $tmp;
    }
  }

  if (!function_exists('array_map')) {
    function array_map($callback, $array) {
      if (is_array($array)) {
        $_new_array = array();
        reset($array);
        while (list($key, $value) = each($array)) {
          $_new_array[$key] = array_map($callback, $array[$key]);
        }
        return $_new_array;
      } else {
        return $callback($array);
      }
    }
  }

  if (!function_exists('str_repeat')) {
    function str_repeat($string, $number) {
      $repeat = '';

      for ($i=0; $i<$number; $i++) {
        $repeat .= $string;
      }

      return $repeat;
    }
  }

  if (!function_exists('checkdnsrr')) {
    function checkdnsrr($host, $type) {
      if(vam_not_null($host) && vam_not_null($type)) {
        @exec("nslookup -type=$type $host", $output);
        while(list($k, $line) = each($output)) {
          if(preg_match("/^$host/i", $line)) {
            return true;
          }
        }
      }
      return false;
    }
  }
  
 if ( !function_exists('mysqli_connect') ) {
    define('MYSQLI_ASSOC', MYSQL_ASSOC);

    function mysqli_connect($server, $username, $password, $database) {
      if ( substr($server, 0, 2) == 'p:' ) {
        $link = mysql_pconnect(substr($server, 2), $username, $password);
      } else {
        $link = mysql_connect($server, $username, $password);
      }

      if ( $link ) {
        mysql_select_db($database, $link);
      }

      return $link;
    }

    function mysqli_close($link) {
      return mysql_close($link);
    }

    function mysqli_query($link, $query) {
      return mysql_query($query, $link);
    }

    function mysqli_errno($link) {
      return mysql_errno($link);
    }

    function mysqli_error($link) {
      return mysql_error($link);
    }

    function mysqli_fetch_array($query, $type) {
      return mysql_fetch_array($query, $type);
    }

    function mysqli_num_rows($query) {
      return mysql_num_rows($query);
    }

    function mysqli_data_seek($query, $offset) {
      return mysql_data_seek($query, $offsetr);
    }

    function mysqli_insert_id($link) {
      return mysql_insert_id($link);
    }

    function mysqli_free_result($query) {
      return mysql_free_result($query);
    }

    function mysqli_fetch_field($query) {
      return mysql_fetch_field($query);
    }

    function mysqli_real_escape_string($link, $string) {
      if ( function_exists('mysql_real_escape_string') ) {
        return mysql_real_escape_string($string, $link);
      } elseif ( function_exists('mysql_escape_string') ) {
        return mysql_escape_string($string);
      }

      return addslashes($string);
    }
  }
  
  function IsvalidCatOrMan($cID, $mID, $languages_id) {
    
      if (isset($mID)) {
          $db_query = vam_db_query("select * from " . TABLE_MANUFACTURERS_INFO . "  where manufacturers_id = '" . (int)$mID . "' and languages_id = " . (int)$languages_id);
          return vam_db_num_rows($db_query);
      }

      if (isset($cID)) {
          $db_query = vam_db_query("select * from " . TABLE_CATEGORIES . "  where categories_id = '" . (int)$cID . "' and categories_status = 1");
          return vam_db_num_rows($db_query);
      }

      return 1;  //neither category or manufacturer so return good
  }

  function IsProduct($pID, $pageType = FILENAME_PRODUCT_INFO, $languages_id) {
      if (strpos($pageType, FILENAME_PRODUCT_INFO) !== FALSE) {
          $db_query = vam_db_query("select p.products_status as status from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id where p.products_id = '" . (int)$pID . "' and pd.language_id = " . (int)$languages_id);
      } else { //it's a review page
          $db_query = vam_db_query("select * from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id where p.products_status = 1 and p.products_id = '" . (int)$pID . "' and pd.language_id = " . (int)$languages_id);
          if (vam_db_num_rows($db_query)) {
              $db_query = vam_db_query("select * from " . TABLE_REVIEWS . " r left join " . TABLE_REVIEWS_DESCRIPTION . " rd on r.reviews_id = rd.reviews_id where r.products_id = '" . (int)$pID . "' and rd.languages_id = " . (int)$languages_id);
              
              if (vam_db_num_rows($db_query) == 0 && $pageType == FILENAME_PRODUCT_REVIEWS) {
                  return RTN_GOOD;  //a review doesn't exist but allow page to load so one can be written
              }
          } else {
              return RTN_410;  //doesn't exist so marks as not found for good
          }
      }

      if (vam_db_num_rows($db_query) == 0) {
          return RTN_410;  //doesn't exist so marks as not found for good
      }

      $db = vam_db_fetch_array($db_query);

      if ($db['status'] == 0) {
          return RTN_404;  //in database and may be shown again
      }
      
      return RTN_GOOD;  //product was found and can be shown
  }    