<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_count_customer_address_book_entries.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_count_customer_address_book_entries.inc.php,v 1.3 2003/08/13); www.nextcommerce.org 
   (c) 2004 xt:Commerce (vam_count_customer_address_book_entries.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
function vam_count_customer_address_book_entries($id = '', $check_session = true) {

    if (is_numeric($id) == false) {
      if (isset($_SESSION['customer_id'])) {
        $id = $_SESSION['customer_id'];
      } else {
        return 0;
      }
    }

    if ($check_session == true) {
      if ( (isset($_SESSION['customer_id']) == false) || ($id != $_SESSION['customer_id']) ) {
        return 0;
      }
    }

    $addresses_query = vam_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$id . "'");
    $addresses = vam_db_fetch_array($addresses_query);

    return $addresses['total'];
  }
 ?>