<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_gzip_output.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(gzip_compression.php,v 1.3 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_gzip_output.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_gzip_output.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
/* $level = compression level 0-9, 0=none, 9=max */
  function vam_gzip_output($level = 5) {
    if ($encoding = vam_check_gzip()) {
      $contents = ob_get_contents();
      ob_end_clean();

      header('Content-Encoding: ' . $encoding);

      $size = strlen($contents);
      $crc = crc32($contents);

      $contents = gzcompress($contents, $level);
      $contents = substr($contents, 0, strlen($contents) - 4);

      echo "\x1f\x8b\x08\x00\x00\x00\x00\x00";
      echo $contents;
      echo pack('V', $crc);
      echo pack('V', $size);
    } else {
      ob_end_flush();
    }
  }
 ?>