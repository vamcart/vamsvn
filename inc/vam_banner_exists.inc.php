<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_banner_exists.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_banner_exists.inc.php,v 1.4 2003/08/13); www.nextcommerce.org 
   (c) 2004 xt:Commerce (vam_banner_exists.inc.php,v 1.4 2003/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
require_once(DIR_FS_INC.'vam_random_select.inc.php');   
  function vam_banner_exists($action, $identifier) {
    if ($action == 'dynamic') {
      return vam_random_select("select * from " . TABLE_BANNERS . " where status = '1' and banners_group = '" . $identifier . "'");
    } elseif ($action == 'static') {
      $banner_query = vam_db_query("select * from " . TABLE_BANNERS . " where status = '1' and banners_id = '" . $identifier . "'");
      return vam_db_fetch_array($banner_query);
    } else {
      return false;
    }
  }
 ?>