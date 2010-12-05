<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_delete_file.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (vam_delete_file.inc.php,v 1.1 2003/08/24); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_delete_file.inc.php,v 1.1 2004/08/25); xt-commerce.com
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

function vam_delete_file($file){ 
	
	$delete= @unlink($file);
	clearstatcache();
	if (@file_exists($file)) {
		$filesys = preg_replace("//","\\",$file);
		$delete = @system("del $filesys");
		clearstatcache();
		if (@file_exists($file)) {
			$delete = @chmod($file,0775);
			$delete = @unlink($file);
			$delete = @system("del $filesys");
		}
	}
	clearstatcache();
	if (@file_exists($file)) {
		return false;
	}
	else {
	return true;
} // end function
}
?>