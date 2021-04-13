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
  function vam_display_banner($action, $identifier) {
    if ($action == 'dynamic') {
      $banners_query = vamDBquery("select count(*) as count from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
      $banners = vam_db_fetch_array($banners_query,true);
      if ($banners['count'] > 0) {
        $banner = vam_random_select("select * from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
      } else {
        return '<b>VaM Shop ERROR! (vam_display_banner(' . $action . ', ' . $identifier . ') -> No banners with group \'' . $identifier . '\' found!</b>';
      }
    } elseif ($action == 'static') {
      if (is_array($identifier)) {
        $banner = $identifier;
      } else {
        $banner_query = vamDBquery("select * from " . TABLE_BANNERS . " where status = '1' and banners_id = '" . $identifier . "'");
        if (vam_db_num_rows($banner_query,true)) {
          $banner = vam_db_fetch_array($banner_query,true);
        } else {
          return '<b>VaM Shop ERROR! (vam_display_banner(' . $action . ', ' . $identifier . ') -> Banner with ID \'' . $identifier . '\' not found, or status inactive</b>';
        }
      }
    } else {
      return '<b>VaM Shop ERROR! (vam_display_banner(' . $action . ', ' . $identifier . ') -> Unknown $action parameter value - it must be either \'dynamic\' or \'static\'</b>';
    }

    if (vam_not_null($banner['banners_html_text'])) {
      $banner_string = $banner['banners_html_text'];
    } else {
      $banner_string = '<a href="' . vam_href_link(FILENAME_REDIRECT, 'action=banner&goto=' . $banner['banners_id']) . '" onclick="window.open(this.href); return false;">' . vam_image(DIR_WS_IMAGES.'banner/' . $banner['banners_image'], $banner['banners_title']) . '</a>';
    }

    vam_update_banner_display_count($banner['banners_id']);

    return $banner_string;
  }
 ?>