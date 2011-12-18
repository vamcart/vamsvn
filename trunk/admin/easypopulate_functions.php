<?php
/* --------------------------------------------------------------
   $Id: easypopulate_functions.php 899 2011-02-07 17:36:57 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2011 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2003	 osCommerce (easypopulate.php,v 1.4 2003/08/14); oscommerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
   
if (!function_exists(vam_get_uploaded_file)){
function vam_get_uploaded_file($filename) {
	if (isset($_FILES[$filename])) {
		$uploaded_file = array('name' => $_FILES[$filename]['name'],
		'type' => $_FILES[$filename]['type'],
		'size' => $_FILES[$filename]['size'],
		'tmp_name' => $_FILES[$filename]['tmp_name']);
	} elseif (isset($GLOBALS['HTTP_POST_FILES'][$filename])) {
		global $HTTP_POST_FILES;

		$uploaded_file = array('name' => $HTTP_POST_FILES[$filename]['name'],
		'type' => $HTTP_POST_FILES[$filename]['type'],
		'size' => $HTTP_POST_FILES[$filename]['size'],
		'tmp_name' => $HTTP_POST_FILES[$filename]['tmp_name']);
	} else {
		$uploaded_file = array('name' => $GLOBALS[$filename . '_name'],
		'type' => $GLOBALS[$filename . '_type'],
		'size' => $GLOBALS[$filename . '_size'],
		'tmp_name' => $GLOBALS[$filename]);
	}

return $uploaded_file;
}
}

// the $filename parameter is an array with the following elements:
// name, type, size, tmp_name
function vam_copy_uploaded_file($filename, $target) {
	if (substr($target, -1) != '/') $target .= '/';

	$target .= $filename['name'];

	move_uploaded_file($filename['tmp_name'], $target);
}

////
// Recursively go through the categories and retreive all sub-categories IDs
// TABLES: categories
if (!function_exists(vam_get_sub_categories)) {
  function vam_get_sub_categories(&$categories, $categories_id) {
    $sub_categories_query = vam_db_query("select categories_id from " . TABLE_CATEGORIES . " where parent_id = '" . (int)$categories_id . "'");
    while ($sub_categories = vam_db_fetch_array($sub_categories_query)) {
      if ($sub_categories['categories_id'] == 0) return true;
      $categories[sizeof($categories)] = $sub_categories['categories_id'];
      if ($sub_categories['categories_id'] != $categories_id) {
        vam_get_sub_categories($categories, $sub_categories['categories_id']);
      }
    }
  }
}

if (!function_exists(vam_get_tax_class_rate)){
function vam_get_tax_class_rate($tax_class_id) {
	$tax_multiplier = 0;
	$tax_query = vam_db_query("select SUM(tax_rate) as tax_rate from " . TABLE_TAX_RATES . " WHERE  tax_class_id = '" . $tax_class_id . "' GROUP BY tax_priority");
	if (vam_db_num_rows($tax_query)) {
		while ($tax = vam_db_fetch_array($tax_query)) {
			$tax_multiplier += $tax['tax_rate'];
		}
	}
	return $tax_multiplier;
}
}

if (!function_exists(vam_get_tax_title_class_id)){
function vam_get_tax_title_class_id($tax_class_title) {
	$classes_query = vam_db_query("select tax_class_id from " . TABLE_TAX_CLASS . " WHERE tax_class_title = '" . $tax_class_title . "'" );
	$tax_class_array = vam_db_fetch_array($classes_query);
	$tax_class_id = $tax_class_array['tax_class_id'];
	return $tax_class_id ;
}
}

if (!function_exists(print_el)){
function print_el( $item2 ) {
	echo " | " . utf8_substr(strip_tags($item2), 0, 10);
}
}

if (!function_exists(print_el1)){
function print_el1( $item2 ) {
	echo sprintf("| %'.4s ", utf8_substr(strip_tags($item2), 0, 80));
}
}

function prepare_image($image) {
	$products_image_name = vam_db_prepare_input($image);
	if(!is_file(DIR_FS_CATALOG_ORIGINAL_IMAGES . $products_image_name))
		return false;
	require_once(DIR_WS_CLASSES . FILENAME_IMAGEMANIPULATOR);
	require(DIR_WS_INCLUDES . 'product_thumbnail_images.php');
	require(DIR_WS_INCLUDES . 'product_info_images.php');
	require(DIR_WS_INCLUDES . 'product_popup_images.php');
	return $products_image_name;
}

// utf8cp1251 and cp1251toutf8 functions

function Utf8ToWin($fcontents) {

    if (function_exists('iconv')) {
       return iconv('UTF-8', 'CP1251', $fcontents); 
    } else {

    $out = $c1 = '';
    $byte2 = false;
    for ($c = 0;$c < strlen($fcontents);$c++) {
        $i = ord($fcontents[$c]);
        if ($i <= 127) {
            $out .= $fcontents[$c];
        }
        if ($byte2) {
            $new_c2 = ($c1 & 3) * 64 + ($i & 63);
            $new_c1 = ($c1 >> 2) & 5;
            $new_i = $new_c1 * 256 + $new_c2;
            if ($new_i == 1025) {
                $out_i = 168;
            } else {
                if ($new_i == 1105) {
                    $out_i = 184;
                } else {
                    $out_i = $new_i - 848;
                }
            }
            $out .= chr($out_i);
            $byte2 = false;
        }
        if (($i >> 5) == 6) {
            $c1 = $i;
            $byte2 = true;
        }
    }
    return $out;


    }

}

function CP1251toUTF8($str){

    if (function_exists('iconv')) {
       return iconv('CP1251', 'UTF-8', $str); 
    } else {

static $table = array("\xA8" => "\xD0\x81", 
"\xB8" => "\xD1\x91", 
// украинские символы
"\xA1" => "\xD0\x8E", 
"\xA2" => "\xD1\x9E", 
"\xAA" => "\xD0\x84", 
"\xAF" => "\xD0\x87", 
"\xB2" => "\xD0\x86", 
"\xB3" => "\xD1\x96", 
"\xBA" => "\xD1\x94", 
"\xBF" => "\xD1\x97", 
// чувашские символы
"\x8C" => "\xD3\x90", 
"\x8D" => "\xD3\x96", 
"\x8E" => "\xD2\xAA", 
"\x8F" => "\xD3\xB2", 
"\x9C" => "\xD3\x91", 
"\x9D" => "\xD3\x97", 
"\x9E" => "\xD2\xAB", 
"\x9F" => "\xD3\xB3", 
);
return preg_replace('#[\x80-\xFF]#se',
' "$0" >= "\xF0" ? "\xD1".chr(ord("$0")-0x70) :
("$0" >= "\xC0" ? "\xD0".chr(ord("$0")-0x30) :
(isset($table["$0"]) ? $table["$0"] : "")
)',
$str
);

    }

}

// utf8cp1251 and cp1251toutf8 functions

?>