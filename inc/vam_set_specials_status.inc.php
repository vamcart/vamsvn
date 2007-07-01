<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_set_specials_status.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(specials.php,v 1.5 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_set_specials_status.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_set_specials_status.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// Sets the status of a special product
  function vam_set_specials_status($specials_id, $status) {
    return vam_db_query("update " . TABLE_SPECIALS . " set status = '" . $status . "', date_status_change = now() where specials_id = '" . $specials_id . "'");
  }
 ?>