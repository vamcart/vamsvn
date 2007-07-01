<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_geo_zone_code.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_get_zone_code.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_zone_code.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function vam_get_geo_zone_code($country_id) {
    $geo_zone_query = vam_db_query("select geo_zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where zone_country_id = '" . $country_id . "'");
    $geo_zone = vam_db_fetch_array($geo_zone_query);
    return $geo_zone['geo_zone_id'];
    }
 ?>