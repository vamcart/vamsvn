<?php
/* --------------------------------------------------------------
   $Id: products_images.php 1166 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2004	 xt:Commerce (products_images.php,v 1.2 2003/08/23); www.nextcommerce.org

   Released under the GNU General Public License
   --------------------------------------------------------------*/
defined('_VALID_VAM') or die('Direct Access to this location is not allowed.');

//include needed functions
require_once (DIR_FS_INC.'vam_get_products_mo_images.inc.php');
// BOF Add existing image
require_once(DIR_WS_FUNCTIONS . 'trumbnails_add_funcs.php');
// EOF Add existing image

// show images
if ($_GET['action'] == 'new_product') {

// BOF Add existing image
$dir_list = vam_array_merge(array('0' => array('id' => '', 'text' => TEXT_SELECT_DIRECTORY)),vam_get_files_in_dir(DIR_FS_CATALOG_ORIGINAL_IMAGES, '', true));
//$file_list = vam_array_merge(array('0' => array('id' => '', 'text' => TEXT_SELECT_IMAGE)),vam_get_files_in_dir(DIR_FS_CATALOG_ORIGINAL_IMAGES));
// EOF Add existing image

	// display images fields:
	echo '<tr><td colspan="4">'.vam_draw_separator('pixel_trans.gif', '1', '10').'</td></tr>';
	if ($pInfo->products_image) {
		echo '<tr><td colspan="4"><table><tr><td align="center" class="main" width="'. (PRODUCT_IMAGE_THUMBNAIL_WIDTH + 15).'">'.vam_image(DIR_WS_CATALOG_THUMBNAIL_IMAGES.$pInfo->products_image, TEXT_STANDART_IMAGE).'</td>';
	}
	echo '<td class="main">'.TEXT_PRODUCTS_IMAGE.'<br />'.vam_draw_file_field('products_image').'<br />'.vam_draw_separator('pixel_trans.gif', '24', '15').'&nbsp;'.$pInfo->products_image.vam_draw_hidden_field('products_previous_image_0', $pInfo->products_image);
// BOF Add existing image
	echo '<br />' . TEXT_PRODUCTS_IMAGE_UPLOAD_DIRECTORY . '<br />' . vam_draw_pull_down_menu('upload_dir_image_0',$dir_list, dirname($pInfo->products_image).'/'). '</td>';
	echo '<td class="main">'.TEXT_IMAGE_DESCRIPTION.'<br />' . vam_draw_textarea_field('main_pics_descr', 'hard', 76, 7, $pInfo->products_image_description);
//	echo '<br /><br />' . TEXT_PRODUCTS_IMAGE_GET_FILE . '<br />' . vam_draw_pull_down_menu('get_file_image_0',$file_list,$pInfo->products_image);
// EOF Add existing image
	if ($pInfo->products_image != '') {
		echo '</tr><tr><td align="center" class="main" valign="middle">'.vam_draw_selection_field('del_pic', 'checkbox', $pInfo->products_image).' '.TEXT_DELETE.'</td></tr></table>';
	} else {
		echo '</td></tr>';
	}

	// display MO PICS
	if (MO_PICS > 0) {
		$mo_images = vam_get_products_mo_images($pInfo->products_id);
		for ($i = 0; $i < MO_PICS; $i ++) {
			echo '<tr><td colspan="4">'.vam_draw_separator('pixel_black.gif', '100%', '1').'</td></tr>';
			echo '<tr><td colspan="4">'.vam_draw_separator('pixel_trans.gif', '1', '10').'</td></tr>';
			if ($mo_images[$i]["image_name"]) {
				echo '<tr><td colspan="4"><table><tr><td align="center" class="main" width="'. (PRODUCT_IMAGE_THUMBNAIL_WIDTH + 15).'">'.vam_image(DIR_WS_CATALOG_THUMBNAIL_IMAGES.$mo_images[$i]["image_name"], TEXT_STANDART_IMAGE . ' '. ($i +1)).'</td>';
			} else {
				echo '<tr>';
			}
			echo '<td class="main">'.TEXT_PRODUCTS_IMAGE.' '. ($i +1).'<br />'.vam_draw_file_field('mo_pics_'.$i).'<br />'.vam_draw_separator('pixel_trans.gif', '24', '15').'&nbsp;'.$mo_images[$i]["image_name"].vam_draw_hidden_field('products_previous_image_'. ($i +1), $mo_images[$i]["image_name"]);
// BOF Add existing image
	echo '<br />' . TEXT_PRODUCTS_IMAGE_UPLOAD_DIRECTORY . '<br />' . vam_draw_pull_down_menu('mo_pics_upload_dir_image_'.$i,$dir_list, dirname($mo_images[$i]["image_name"]).'/'). '</td>';
echo '<td class="main">'.TEXT_IMAGE_DESCRIPTION.' '. ($i +1).'<br />' . vam_draw_textarea_field('mo_pics_descr_'.$i, 'hard', 76, 7, $mo_images[$i]["image_description"]);
	//echo '<br /><br />' . TEXT_PRODUCTS_IMAGE_GET_FILE . '<br />' . vam_draw_pull_down_menu('mo_pics_get_file_image_'.$i,$file_list,$mo_images[$i]["image_name"]);
// EOF Add existing image
			if (isset ($mo_images[$i]["image_name"])) {
				echo '</tr><tr><td align="center" class="main" valign="middle">'.vam_draw_selection_field('del_mo_pic[]', 'checkbox', $mo_images[$i]["image_name"]).' '.TEXT_DELETE.'</td></tr></table>';
			} else {
				echo '</td></tr>';
			}
		}
	}

}
?>