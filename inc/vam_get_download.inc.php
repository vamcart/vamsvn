<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_download.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (vam_get_download.inc.php,v 1.4 2003/08/25); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_download.inc.php,v 1.4 2004/08/25); xt-commerce.com
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// safe download function, file get renamed bevor sending to browser!!
function vam_get_download($content_id) {
	
	$content_query=vam_db_query("SELECT
					content_file,
					content_read
					FROM ".TABLE_PRODUCTS_CONTENT."
					WHERE content_id='".$content_id."'");
					
	$content_data=vam_db_fetch_array($content_query);
	// update file counter
	
	vam_db_query("UPDATE 
			".TABLE_PRODUCTS_CONTENT." 
			SET content_read='".($content_data['content_read']+1)."'
			WHERE content_id='".$content_id."'");
	
	// original filename
	$filename = DIR_FS_CATALOG.'media/products/'.$content_data['content_file'];
	$backup_filename = DIR_FS_CATALOG.'media/products/backup/'.$content_data['content_file'];
	// create md5 hash id from original file
	$orign_hash_id=md5_file($filename);
	
	clearstatcache();
	
	// create new filename with timestamp
	$timestamp=str_replace('.','',microtime());
        $timestamp=str_replace(' ','',$timestamp);
        $new_filename=DIR_FS_CATALOG.'media/products/'.$timestamp.strstr($content_data['content_file'],'.');
        
        // rename file
        rename($filename,$new_filename);
  	
	
	if (file_exists($new_filename)) {
		
	
	header("Content-type: application/force-download");
	header("Content-Disposition: attachment; filename=".$new_filename);
	@readfile($new_filename);	
	// rename file to original name
	rename($new_filename,$filename);
	$new_hash_id=md5_file($filename);
	clearstatcache();	
	
	// check hash id of file again, if not same, get backup!
	if ($new_hash_id!=$orign_hash_id) copy($backup_filename,$filename);
	}
	
	
}
?>