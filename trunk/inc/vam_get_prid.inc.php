<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_prid.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com
   (c) 2003	 nextcommerce (vam_get_prid.inc.php,v 1.3 2003/08/13); www.nextcommerce.org 
   (c) 2004 xt:Commerce (vam_get_prid.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// Return a product ID from a product ID with attributes

  function vam_get_prid($uprid) {
  $pieces = explode('{', $uprid);

  if (is_numeric($pieces[0])) {
    return $pieces[0];
  } else {
    return false;
  }
}
 ?>