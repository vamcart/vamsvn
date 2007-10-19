<?php
/* -----------------------------------------------------------------------------------------
   $Id: application_bottom.php 1239 2007-10-19 20:14:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_bottom.php,v 1.14 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (application_bottom.php,v 1.6 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (application_bottom.php,v 1.6 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

if (STORE_PAGE_PARSE_TIME == 'true') {
	$time_start = explode(' ', PAGE_PARSE_START_TIME);
	$time_end = explode(' ', microtime());
	$parse_time = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);
	error_log(strftime(STORE_PARSE_DATE_TIME_FORMAT) . ' - ' . getenv('REQUEST_URI') . ' (' . $parse_time . 's)' . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);

}

    if (DISPLAY_PAGE_PARSE_TIME == 'true') {
    	$time_start = explode(' ', PAGE_PARSE_START_TIME);
    $time_end = explode(' ', microtime());
    $parse_time = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);
      echo '<div id="parseTime">Время генерации: ' . $parse_time . ', запросов: ' . $query_counts . '</div>';
    }

if ((GZIP_COMPRESSION == 'true') && ($ext_zlib_loaded == true) && ($ini_zlib_output_compression < 1)) {
	if ((PHP_VERSION < '4.0.4') && (PHP_VERSION >= '4')) {
		vam_gzip_output(GZIP_LEVEL);
	}
}
?>