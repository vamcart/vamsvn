<?php
/* --------------------------------------------------------------
   $Id: database.php 950 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.22 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (database.php,v 1.6 2003/08/18); www.nextcommerce.org
   (c) 2004 xt:Commerce (database.php,v 1.6 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );
  function vam_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global $$link;

    $$link = mysqli_connect($server, $username, $password, $database);

      //@mysqli_query($$link, "SET SQL_MODE= ''");
      //@mysqli_query($$link, "SET NAMES 'utf8' COLLATE 'utf8_general_ci'");

    return $$link;
  }

  function vam_db_close($link = 'db_link') {
    global $$link;

    return mysqli_close($$link);
  }

  // db connection for Servicedatabase  
  function service_vam_db_close($link_service = 'db_link_service') {
    global $$link_service;

    return mysqli_close($$link_service);
  }


  function vam_db_error($query, $errno, $error) { 
    die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br><br>' . $query . '<br><br><small><font color="#ff0000">[TEP STOP]</font></small><br><br></b></font>');
  }

  function vam_db_query($query, $link = 'db_link') {
    global $$link, $logger;

    if (STORE_DB_TRANSACTIONS == 'true') {
      if (!is_object($logger)) $logger = new logger;
      $logger->write($query, 'QUERY');
    }

    $result = mysqli_query($$link, $query) or vam_db_error($query, mysqli_errno($$link), mysqli_error($$link));

    if (STORE_DB_TRANSACTIONS == 'true') {
      if (mysqli_error($$link)) $logger->write(mysqli_error($$link), 'ERROR');
    }

    return $result;
  }

  function vam_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link') {
    reset($data);
    if ($action == 'insert') {
      $query = 'insert into ' . $table . ' (';
      while (list($columns, ) = each($data)) {
        $query .= $columns . ', ';
      }
      $query = substr($query, 0, -2) . ') values (';
      reset($data);
      while (list(, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= 'now(), ';
            break;
          case 'null':
            $query .= 'null, ';
            break;
          default:
            $query .= '\'' . vam_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ')';
    } elseif ($action == 'update') {
      $query = 'update ' . $table . ' set ';
      while (list($columns, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= $columns . ' = now(), ';
            break;
          case 'null':
            $query .= $columns .= ' = null, ';
            break;
          default:
            $query .= $columns . ' = \'' . vam_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ' where ' . $parameters;
    }

    return vam_db_query($query, $link);
  }

  function vam_db_fetch_array($db_query) {
    return mysqli_fetch_array($db_query, MYSQLI_ASSOC);
  }

  function vam_db_result($result, $row, $field = '') {
    if ( $field === '' ) {
      $field = 0;
    }

    tep_db_data_seek($result, $row);
    $data = tep_db_fetch_array($result);

    return $data[$field];
  }

  function vam_db_num_rows($db_query) {
    return mysqli_num_rows($db_query);
  }

  function vam_db_data_seek($db_query, $row_number) {
    return mysqli_data_seek($db_query, $row_number);
  }

  function vam_db_insert_id() {
    return mysqli_insert_id();
  }

  function vam_db_free_result($db_query) {
    return mysqli_free_result($db_query);
  }

  function vam_db_fetch_fields($db_query) {
    return mysqli_fetch_field($db_query);
  }

  function vam_db_output($string) {
    return htmlspecialchars($string);
  }

  function vam_db_input($string) {
    return addslashes($string);
  }

  function vam_db_prepare_input($string) {
    if (is_string($string)) {
      return trim(stripslashes($string));
    } elseif (is_array($string)) {
      reset($string);
      while (list($key, $value) = each($string)) {
        $string[$key] = vam_db_prepare_input($value);
      }
      return $string;
    } else {
      return $string;
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
  
function mysqli_result($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
}     
?>