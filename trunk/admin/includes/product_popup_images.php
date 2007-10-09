<?php
/* --------------------------------------------------------------
   $Id: product_popup_images.php 899 2007-02-08 12:09:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2004	 xt:Commerce (product_popup_images.php,v 1.17 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

if(PRODUCT_IMAGE_POPUP_ACTIVE == 'true') {

	require_once(DIR_WS_FUNCTIONS . 'trumbnails_add_funcs.php');

	vam_mkdir_recursive(DIR_FS_CATALOG_POPUP_IMAGES, dirname($products_image_name));

	list($width, $height) = vam_get_image_size(DIR_FS_CATALOG_ORIGINAL_IMAGES . $products_image_name, PRODUCT_IMAGE_POPUP_WIDTH, PRODUCT_IMAGE_POPUP_HEIGHT);

//$a = new image_manipulation(DIR_FS_CATALOG_ORIGINAL_IMAGES . $products_image_name,PRODUCT_IMAGE_POPUP_WIDTH,PRODUCT_IMAGE_POPUP_HEIGHT,DIR_FS_CATALOG_POPUP_IMAGES . $products_image_name,IMAGE_QUALITY,'');
//	$a = new image_manipulation(DIR_FS_CATALOG_ORIGINAL_IMAGES . $products_image_name, $width, $height, DIR_FS_CATALOG_POPUP_IMAGES . $products_image_name, IMAGE_QUALITY, '');

########## start Andreaz
# если оригинал картинки меньше поп-апа, то размер поп-апа равен оригиналу

$size = getimagesize(DIR_FS_CATALOG_ORIGINAL_IMAGES . $products_image_name);
    if ($size['0'] >= PRODUCT_IMAGE_POPUP_WIDTH || $size['1'] >= PRODUCT_IMAGE_POPUP_HEIGHT) {
        $a = new image_manipulation(DIR_FS_CATALOG_ORIGINAL_IMAGES . $products_image_name, PRODUCT_IMAGE_POPUP_WIDTH, PRODUCT_IMAGE_POPUP_HEIGHT, DIR_FS_CATALOG_POPUP_IMAGES . $products_image_name, IMAGE_QUALITY,'');
    }
    else {
        $a = new image_manipulation(DIR_FS_CATALOG_ORIGINAL_IMAGES . $products_image_name, $size['0'], $size['1'],DIR_FS_CATALOG_POPUP_IMAGES . $products_image_name, IMAGE_QUALITY,'');
    }
########## end Andreaz


$array=clear_string(PRODUCT_IMAGE_POPUP_BEVEL);
if (PRODUCT_IMAGE_POPUP_BEVEL != ''){
$a->bevel($array[0],$array[1],$array[2]);}

$array=clear_string(PRODUCT_IMAGE_POPUP_GREYSCALE);
if (PRODUCT_IMAGE_POPUP_GREYSCALE != ''){
$a->greyscale($array[0],$array[1],$array[2]);}

$array=clear_string(PRODUCT_IMAGE_POPUP_ELLIPSE);
if (PRODUCT_IMAGE_POPUP_ELLIPSE != ''){
$a->ellipse($array[0]);}

$array=clear_string(PRODUCT_IMAGE_POPUP_ROUND_EDGES);
if (PRODUCT_IMAGE_POPUP_ROUND_EDGES != ''){
$a->round_edges($array[0],$array[1],$array[2]);}

$string=str_replace("'",'',PRODUCT_IMAGE_POPUP_MERGE);
$string=str_replace(')','',$string);
$string=str_replace('(',DIR_FS_CATALOG_IMAGES,$string);
$array=explode(',',$string);
//$array=clear_string();
if (PRODUCT_IMAGE_POPUP_MERGE != ''){
$a->merge($array[0],$array[1],$array[2],$array[3],$array[4]);}

$array=clear_string(PRODUCT_IMAGE_POPUP_FRAME);
if (PRODUCT_IMAGE_POPUP_FRAME != ''){
$a->frame($array[0],$array[1],$array[2],$array[3]);}

$array=clear_string(PRODUCT_IMAGE_POPUP_DROP_SHADOW);
if (PRODUCT_IMAGE_POPUP_DROP_SHADOW != ''){
$a->drop_shadow($array[0],$array[1],$array[2]);}

$array=clear_string(PRODUCT_IMAGE_POPUP_MOTION_BLUR);
if (PRODUCT_IMAGE_POPUP_MOTION_BLUR != ''){
$a->motion_blur($array[0],$array[1]);}
	  $a->create();
}
?>