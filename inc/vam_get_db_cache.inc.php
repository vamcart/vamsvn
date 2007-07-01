<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_db_cache.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cache.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_get_db_cache.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_db_cache.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
//! Get data from the cache or the database.
//  get_db_cache checks the cache for cached SQL data in $filename
//  or retreives it from the database is the cache is not present.
//  $SQL      -  The SQL query to exectue if needed.
//  $filename -  The name of the cache file.
//  $var      -  The variable to be filled.
//  $refresh  -  Optional.  If true, do not read from the cache.
  function get_db_cache($sql, &$var, $filename, $refresh = false){
    $var = array();

// check for the refresh flag and try to the data
    if (($refresh == true)|| !read_cache($var, $filename)) {
// Didn' get cache so go to the database.
//      $conn = mysql_connect("localhost", "apachecon", "apachecon");
      $res = vam_db_query($sql);
//      if ($err = mysql_error()) trigger_error($err, E_USER_ERROR);
// loop through the results and add them to an array
      while ($rec = vam_db_fetch_array($res)) {
        $var[] = $rec;
      }
// write the data to the file
      write_cache($var, $filename);
    }
  }

 ?>