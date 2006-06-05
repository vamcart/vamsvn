<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_validate_vatid_status.inc.php 899 2005-04-29 02:40:57Z hhgag $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// Return all status info values for a customer_id in catalog, need to check session registered customer or will return dafault guest customer status value !
function xtc_validate_vatid_status($customer_id) {

    $customer_status_query = xtc_db_query("select customers_vat_id_status FROM " . TABLE_CUSTOMERS . " where customers_id='" . $customer_id . "'");
    $customer_status_value = xtc_db_fetch_array($customer_status_query);

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