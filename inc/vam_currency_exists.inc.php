<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_currency_exists.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_currency_exists.inc.php); www.nextcommerce.org
   (c) 2004 xt:Commerce (tc_currency_exists.inc.php 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


function vam_currency_exists($code) {
    $currency_code = vam_db_query("select currencies_id from " . TABLE_CURRENCIES . " where code = '" . $code . "'");
    if (vam_db_num_rows($currency_code)) {
      return $code;
    } else {
      return false;
    }
  }

 ?>