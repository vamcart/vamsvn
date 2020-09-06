<?php
/* -----------------------------------------------------------------------------------------
   $Id: ajaxQuickFind.php 1243 2009-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 Andrew Berezin (ajaxQuickFind.php,v 1.9 2003/08/17); zen-cart.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

if (filter_var($_REQUEST['products_id'], FILTER_VALIDATE_INT)) {

require_once(DIR_WS_CLASSES.'upload.php');

function vam_try_upload($file = '', $destination = '', $permissions = '777', $extensions = '', $prefix = '') {
	$file_object = new upload($file, $destination, $permissions, $extensions, $prefix);
	if ($file_object->filename != '') {
		return $file_object;
	} else {
		return false;
	}
}

$r = vam_db_query("SHOW TABLE STATUS LIKE 'reviews'");
$row = vam_db_fetch_array($r);
$insert_id = $row['Auto_increment'];

	// загрузка картинок
	$dir_otzyvy = DIR_FS_CATALOG . "images/reviews";		
		
   if ($review_images = &vam_try_upload('myfile', $dir_otzyvy)) {

		$sql_data_array = array ('reviews_id' => $insert_id, 'products_id' => $_REQUEST['products_id'], 'customers_id' => (($_SESSION['customer_id'] > 0) ? $_SESSION['customer_id'] : 0), 'image' => $review_images->filename, 'created' => 'now()', 'modified' => 'now()');

		vam_db_perform(TABLE_REVIEWS_IMAGES, $sql_data_array);
		
		$_SESSION['temp_reviews_id'] = $insert_id;


   }

  
}   
