<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_display_banner.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_display_banner.inc.php,v 1.3 2003/08/1); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_display_banner.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// Display a banner from the specified group or banner id ($identifier)
  function vam_display_banners($action, $identifier) {

      $banners_query = vamDBquery("select count(*) as count from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
      $banners = vam_db_fetch_array($banners_query,true);
      if ($banners['count'] > 0) {


      $banners_data = vamDBquery("select banners_id, banners_title, banners_description, banners_image, banners_url, banners_html_text from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "' order by rand()");

		$banners_array = array ();

      while ($banner = vam_db_fetch_array($banners_data, true)) {      	

	   $banner_image = DIR_WS_IMAGES . 'banner/' . $banner['banners_image'];
	   $banner_image_path = DIR_FS_CATALOG . DIR_WS_IMAGES . 'banner/' . $banner['banners_image'];
	 
		if(file_exists($banner_image_path) && is_file($banner_image_path)) {
			list($width, $height, $type, $attr) = getimagesize($banner_image);
		}


			$banners_array[] = array (
			
			'id' => $banner['banners_id'], 
			'title' => $banner['banners_title'], 
			'description' => $banner['banners_description'], 
			'html' => $banner['banners_html_text'], 
			'image' => $banner['banners_image'],
			'image_width' => $width,
			'image_height' => $height,
			'link' => $banner['banners_url'],
			'url' => vam_href_link(FILENAME_REDIRECT, 'action=banner&goto=' . $banner['banners_id'])
			);

			vam_update_banner_display_count($banner['banners_id']);

		}

      }

    return $banners_array;
  }
 ?>