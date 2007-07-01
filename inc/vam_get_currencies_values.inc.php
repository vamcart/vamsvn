<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_currencies_values.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (vam_get_currencies_values.inc.php,v 1.1 2003/08/213); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_currencies_values.inc.php,v 1.1 2004/08/25); xt-commerce.com
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


function vam_get_currencies_values($code) {
    $currency_values = vam_db_query("select * from " . TABLE_CURRENCIES . " where code = '" . $code . "'");
    $currencie_data=vam_db_fetch_array($currency_values);
    return $currencie_data;
  }

 ?>