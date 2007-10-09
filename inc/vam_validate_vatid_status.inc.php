<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_validate_vatid_status.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (vam_validate_vatid_status.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_validate_vatid_status.inc.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

// Return all status info values for a customer_id in catalog, need to check session registered customer or will return dafault guest customer status value !
function vam_validate_vatid_status($customer_id) {

    $customer_status_query = vam_db_query("select customers_vat_id_status FROM " . TABLE_CUSTOMERS . " where customers_id='" . $customer_id . "'");
    $customer_status_value = vam_db_fetch_array($customer_status_query);

    if ($customer_status_value['customers_vat_id_status'] == '0'){
    $value = TEXT_VAT_FALSE;
    }

    if ($customer_status_value['customers_vat_id_status'] == '1'){
    $value = TEXT_VAT_TRUE;
    }

    if ($customer_status_value['customers_vat_id_status'] == '8'){
    $value = TEXT_VAT_UNKNOWN_COUNTRY;
    }

    if ($customer_status_value['customers_vat_id_status'] == '9'){
    $value = TEXT_VAT_UNKNOWN_ALGORITHM;
    }

   return $value;
}
 ?>