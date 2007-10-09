<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_unlink_temp_dir.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (vam_unlink_temp_dir.inc.php,v 1.1 2003/08/18); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_unlink_temp_dir.inc.php,v 1.1 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  // Unlinks all subdirectories and files in $dir
  // Works only on one subdir level, will not recurse
  function vam_unlink_temp_dir($dir) {
    $h1 = opendir($dir);
    while ($subdir = readdir($h1)) {
      // Ignore non directories
      if (!is_dir($dir . $subdir)) continue;
      // Ignore . and .. and CVS
      if ($subdir == '.' || $subdir == '..' || $subdir == 'CVS') continue;
      // Loop and unlink files in subdirectory
      $h2 = opendir($dir . $subdir);
      while ($file = readdir($h2)) {
        if ($file == '.' || $file == '..') continue;
        @unlink($dir . $subdir . '/' . $file);
      }
      closedir($h2); 
      @rmdir($dir . $subdir);
    }
    closedir($h1);
  }
 ?>