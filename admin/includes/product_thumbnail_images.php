<?php
/* --------------------------------------------------------------
   $Id: product_thumbnail_images.php 899 2007-02-08 12:09:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2004	 xt:Commerce (product_thumbnail_images.php,v 1.17 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
if(PRODUCT_IMAGE_THUMBNAIL_ACTIVE == 'true') {

	require_once(DIR_WS_FUNCTIONS . 'trumbnails_add_funcs.php');

	vam_mkdir_recursive(DIR_FS_CATALOG_THUMBNAIL_IMAGES, dirname($products_image_name));

	list($width, $height) = vam_get_image_size(DIR_FS_CATALOG_ORIGINAL_IMAGES . $products_image_name, PRODUCT_IMAGE_THUMBNAIL_WIDTH, PRODUCT_IMAGE_THUMBNAIL_HEIGHT);

//$a = new image_manipulation(DIR_FS_CATALOG_ORIGINAL_IMAGES . $products_image_name, PRODUCT_IMAGE_THUMBNAIL_WIDTH, PRODUCT_IMAGE_THUMBNAIL_HEIGHT, DIR_FS_CATALOG_THUMBNAIL_IMAGES . $products_image_name, IMAGE_QUALITY, '');
  $a = new image_manipulation(DIR_FS_CATALOG_ORIGINAL_IMAGES . $products_image_name, $width, $height, DIR_FS_CATALOG_THUMBNAIL_IMAGES . $products_image_name, IMAGE_QUALITY, '');

$array=clear_string(PRODUCT_IMAGE_THUMBNAIL_BEVEL);
if (PRODUCT_IMAGE_THUMBNAIL_BEVEL != ''){
$a->bevel($array[0],$array[1],$array[2]);}

$array=clear_string(PRODUCT_IMAGE_THUMBNAIL_GREYSCALE);
if (PRODUCT_IMAGE_THUMBNAIL_GREYSCALE != ''){
$a->greyscale($array[0],$array[1],$array[2]);}

$array=clear_string(PRODUCT_IMAGE_THUMBNAIL_ELLIPSE);
if (PRODUCT_IMAGE_THUMBNAIL_ELLIPSE !== ''){
$a->ellipse($array[0]);}

$array=clear_string(PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES);
if (PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES != ''){
$a->round_edges($array[0],$array[1],$array[2]);}

$string=str_replace("'",'',PRODUCT_IMAGE_THUMBNAIL_MERGE);
$string=str_replace(')','',$string);
$string=str_replace('(',DIR_FS_CATALOG_IMAGES,$string);
$array=explode(',',$string);
//$array=clear_string();
if (PRODUCT_IMAGE_THUMBNAIL_MERGE != ''){
$a->merge($array[0],$array[1],$array[2],$array[3],$array[4]);}

$array=clear_string(PRODUCT_IMAGE_THUMBNAIL_FRAME);
if (PRODUCT_IMAGE_THUMBNAIL_FRAME != ''){
$a->frame($array[0],$array[1],$array[2],$array[3]);}

$array=clear_string(PRODUCT_IMAGE_THUMBNAIL_DROP_SHADOW);
if (PRODUCT_IMAGE_THUMBNAIL_DROP_SHADOW != ''){
$a->drop_shadow($array[0],$array[1],$array[2]);}

$array=clear_string(PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR);
if (PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR != ''){
$a->motion_blur($array[0],$array[1]);}

	  $a->create();
}
?>