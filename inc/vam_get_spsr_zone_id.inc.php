<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_spsr_zone_id.inc.php 1129 2010-05-29 10:51:57 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (vam_php_mail.inc.php,v 1.17 2003/08/24); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_php_mail.inc.php,v 1.17 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

function vam_get_spsr_zone_id($zone_id) {
    $spsr_zone_query = vam_db_query("select spsr_zone_id from " . TABLE_SPSR_ZONES . " where zone_id = '" . $zone_id . "'");
    if (vam_db_num_rows($spsr_zone_query)) {
      $spsr_zone = vam_db_fetch_array($spsr_zone_query);
	  $spsr_zone_id = $spsr_zone['spsr_zone_id'];
	  return $spsr_zone_id;
    } else {
	  return false;
    }
   }
?>