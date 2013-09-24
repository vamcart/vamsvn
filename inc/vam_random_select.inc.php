<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_random_select.inc.php 1108 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_random_select.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_random_select.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function vam_random_select($query) {
    $random_product = '';
    $random_query = vam_db_query($query);
    $num_rows = vam_db_num_rows($random_query);
    if ($num_rows > 0) {
      $random_row = vam_rand(0, ($num_rows - 1));
      vam_db_data_seek($random_query, $random_row);
      $random_product = vam_db_fetch_array($random_query);
    }

	if (is_array($random_product)) { 
    return $random_product;
   }
  }
 ?>