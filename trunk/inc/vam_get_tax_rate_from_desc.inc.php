<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_tax_rate_from_desc.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_top.php,v 1.273 2003/05/19); www.oscommerce.com
   (c) 2003     nextcommerce (application_top.php,v 1.54 2003/08/25); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_tax_rate_from_desc.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// Get tax rate from tax description
  function vam_get_tax_rate_from_desc($tax_desc) {
    $tax_query = vam_db_query("select tax_rate from " . TABLE_TAX_RATES . " where tax_description = '" . $tax_desc . "'");
    $tax = vam_db_fetch_array($tax_query);
    return $tax['tax_rate'];
  }
?>