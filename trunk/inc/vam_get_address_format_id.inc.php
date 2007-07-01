<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_address_format_id.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
   (c) 2003	 nextcommerce (vam_get_address_format_id.inc.php,v 1.3 2003/08/13); www.nextcommerce.org 
   (c) 2004 xt:Commerce (vam_get_address_format_id.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function vam_get_address_format_id($country_id) {
    $address_format_query = vam_db_query("select address_format_id as format_id from " . TABLE_COUNTRIES . " where countries_id = '" . $country_id . "'");
    if (vam_db_num_rows($address_format_query)) {
      $address_format = vam_db_fetch_array($address_format_query);
      return $address_format['format_id'];
    } else {
      return '1';
    }
  }
 ?>