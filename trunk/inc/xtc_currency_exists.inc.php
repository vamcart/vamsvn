<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_currency_exists.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_currency_exists.inc.php); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


function xtc_currency_exists($code) {
    $currency_code = xtc_db_query("select currencies_id from " . TABLE_CURRENCIES . " where code = '" . $code . "'");
    if (xtc_db_num_rows($currency_code)) {
      return $code;
    } else {
      return false;
    }
  }

 ?>