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
  $default->assign('BANNER',vam_display_banner('static', $banner));
  }

  if ($banner = vam_banner_exists('dynamic', 'slider_bootstrap')) {
  $default->assign('slider_bootstrap',vam_display_banners('dynamic', 'slider_bootstrap'));
  }
  
  if ($banner = vam_banner_exists('dynamic', 'slider_pop_slide')) {
  $default->assign('slider_pop_slide',vam_display_banners('dynamic', 'slider_pop_slide'));
  }

  if ($banner = vam_banner_exists('dynamic', 'slider_basic')) {
  $default->assign('slider_basic',vam_display_banners('dynamic', 'slider_basic'));
  }
    
  if ($banner = vam_banner_exists('dynamic', 'slider_modern_slide_in')) {
  $default->assign('slider_modern_slide_in',vam_display_banners('dynamic', 'slider_modern_slide_in'));
  }

  if ($banner = vam_banner_exists('dynamic', 'slider_parallax_basic')) {
  $default->assign('slider_parallax_basic',vam_display_banners('dynamic', 'slider_parallax_basic'));
  }

  if ($banner = vam_banner_exists('dynamic', 'slider_starter_basic')) {
  $default->assign('slider_starter_basic',vam_display_banners('dynamic', 'slider_starter_basic'));
  }

  if ($banner = vam_banner_exists('dynamic', 'slider_mono')) {
  $default->assign('slider_mono',vam_display_banners('dynamic', 'slider_mono'));
  }

  if ($banner = vam_banner_exists('dynamic', 'slider_two_up')) {
  $default->assign('slider_two_up',vam_display_banners('dynamic', 'slider_two_up'));
  }

  //if ($banner = vam_banner_exists('dynamic', 'vamshop5')) {
  //$default->assign('vamshop5',vam_display_banners('dynamic', 'vamshop5'));
  //}

  if ($banner = vam_banner_exists('dynamic', 'vamshop5_ad_1')) {
  $default->assign('vamshop5_ad_1',vam_display_banner('dynamic', 'vamshop5_ad_1'));
  }

  if ($banner = vam_banner_exists('dynamic', 'vamshop5_ad_2')) {
  $default->assign('vamshop5_ad_2',vam_display_banner('dynamic', 'vamshop5_ad_2'));
  }

  if ($banner = vam_banner_exists('dynamic', 'vamshop5_ad_3')) {
  $default->assign('vamshop5_ad_3',vam_display_banner('dynamic', 'vamshop5_ad_3'));
  }

?>