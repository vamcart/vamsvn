<?php
/* -----------------------------------------------------------------------------------------
   $Id: banners.php 899 2007-02-06 20:14:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2004	 xt:Commerce (banners.php,v 1.54 2003/08/25); xt-commerce.com 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


  require_once(DIR_FS_INC . 'vam_banner_exists.inc.php');
  require_once(DIR_FS_INC . 'vam_display_banner.inc.php');
  require_once(DIR_FS_INC . 'vam_display_banners.inc.php');
  require_once(DIR_FS_INC . 'vam_update_banner_display_count.inc.php');


  if ($banner = vam_banner_exists('dynamic', 'banner')) {
  $vamTemplate->assign('BANNER',vam_display_banner('static', $banner));
  }
  
  if ($banner = vam_banner_exists('dynamic', 'slider_pop_slide')) {
  $vamTemplate->assign('slider_pop_slide',vam_display_banners('dynamic', 'slider_pop_slide'));
  }

  if ($banner = vam_banner_exists('dynamic', 'slider_basic')) {
  $vamTemplate->assign('slider_basic',vam_display_banners('static', 'slider_basic'));
  }
    
?>