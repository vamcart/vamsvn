<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_delete_file.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   by Mario Zanier <webmaster@zanier.at>
   based on: 
   (c) 2003	 nextcommerce (xtc_delete_file.inc.php,v 1.1 2003/08/24); www.nextcommerce.org
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

function xtc_delete_file($file){ 
	
	$delete= @unlink($file);
	clearstatcache();
	if (@file_exists($file)) {
		$filesys=eregi_replace("/","\\",$file);
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