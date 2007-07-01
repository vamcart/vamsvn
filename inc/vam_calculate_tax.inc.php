<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_calculate_tax.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_calculate_tax.inc.php,v 1.4 2003/08/13); www.nextcommerce.org 
   (c) 2004 xt:Commerce (vam_calculate_tax.inc.php,v 1.3 2003/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function vam_calculate_tax($price, $tax) {
    //global $currencies;
	return $price * $tax / 100;
    //return vam_round($price * $tax / 100, $currencies->currencies[DEFAULT_CURRENCY]['decimal_places']);
  }
 ?>