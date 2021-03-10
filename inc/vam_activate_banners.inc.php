<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_activate_banners.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com
   (c) 2003     nextcommerce (vam_activate_banners.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_activate_banners.inc.php,v 1.3 2003/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// Auto activate banners
  function vam_activate_banners() {
    $banners_query = vam_db_query("select banners_id, date_scheduled from " . TABLE_BANNERS . " where date_scheduled != '0000-00-00'");
    if (vam_db_num_rows($banners_query)) {
      while ($banners = vam_db_fetch_array($banners_query)) {
        if (date('Y-m-d H:i:s') >= $banners['date_scheduled']) {
          vam_set_banner_status($banners['banners_id'], '1');
        }
      }
    }
  }
 ?>
