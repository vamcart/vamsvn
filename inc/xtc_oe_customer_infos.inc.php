<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_oe_customer_infos.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (vam_get_products_price.inc.php,v 1.13 2003/08/20); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_oe_customer_infos.inc.php,v 1.3 2003/08/13); xt-commerce.com
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  function  vam_oe_customer_infos($customers_id) {

    $customer_query = vam_db_query("select a.entry_country_id, a.entry_zone_id from " . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " a where c.customers_id  = '" . $customers_id . "' and c.customers_id = a.customers_id and c.customers_default_address_id = a.address_book_id");
    $customer = vam_db_fetch_array($customer_query);


	$customer_info_array = array('country_id' => $customer['entry_country_id'],
                                 'zone_id' => $customer['entry_zone_id']);

return $customer_info_array;
  }
 ?>