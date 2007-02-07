<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_get_tax_class_id.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (xtc_get_tax_class_id.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (xtc_get_tax_class_id.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  function xtc_get_tax_class_id($products_id) {


    $tax_query = xtc_db_query("SELECT
                               products_tax_class_id
                               FROM ".TABLE_PRODUCTS."
                               where products_id='".$products_id."'");
    $tax_query_data=xtc_db_fetch_array($tax_query);

    return $tax_query_data['products_tax_class_id'];
  }
 ?>