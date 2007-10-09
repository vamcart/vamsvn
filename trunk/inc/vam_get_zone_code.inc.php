<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_zone_code.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_get_zone_code.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_zone_code.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function vam_get_zone_code($country_id, $zone_id, $default_zone) {
    $zone_query = vam_db_query("select zone_code from " . TABLE_ZONES . " where zone_country_id = '" . $country_id . "' and zone_id = '" . $zone_id . "'");
    if (vam_db_num_rows($zone_query)) {
      $zone = vam_db_fetch_array($zone_query);
      return $zone['zone_code'];
    } else {
      return $default_zone;
    }
  }
 ?>