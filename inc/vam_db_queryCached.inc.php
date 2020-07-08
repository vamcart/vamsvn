<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_db_queryCached.inc.php 782 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com
   (c) 2004 xt:Commerce (database.php,v 1.19 2004/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/



  function vam_db_queryCached($query, $link = 'db_link') {
    global $$link;

    // get HASH ID for filename
    $id=md5($query);


    // cache File Name
    $file=SQL_CACHEDIR.$id.'.vam';
    $gzfile=SQL_CACHEDIR.$id.'.gz';

    // file life time
    $expire = DB_CACHE_EXPIRE; // 24 hours

    if (STORE_DB_TRANSACTIONS == 'true') {
      error_log('QUERY ' . $query . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }

    if (file_exists($file) && filemtime($file) > (time() - $expire)) {

     // get cached resulst
        $result = unserialize(implode('',file($file)));

        } elseif (file_exists($gzfile) && filemtime($gzfile) > (time() - $expire)) {
			
		// get GZIP cached resulst
        $result = unserialize(implode('',gzfile($gzfile)));
		} 
		else {

         if (file_exists($file)) @unlink($file);
         if (file_exists($gzfile)) @unlink($gzfile);

        // get result from DB and create new file
        $result = mysqli_query($$link, $query) or vam_db_error($query, mysqli_errno($$link), mysqli_error($$link));

        if (STORE_DB_TRANSACTIONS == 'true') {
                $result_error = mysqli_error($$link);
                error_log('RESULT ' . $result . ' ' . $result_error . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
        }

        // fetch data into array
        while ($record = vam_db_fetch_array($result))
                $records[]=$record;


        if ($records && strlen($query) > 256) { 
        // safe result into file.		
		$stream = serialize($records);
		
		if (strlen($stream) > 300) {
		$fp2 = gzopen ($gzfile, 'w6');
		gzwrite ($fp2, $stream);
		gzclose($fp2);
		} else {			
		$fp = fopen($file,"w");
        fwrite($fp, $stream);
        fclose($fp);
		}
		
		}
        $result = $records;

   }

    return $result;
  }
?>