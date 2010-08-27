<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_update_whos_online.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(whos_online.php,v 1.8 2003/02/21); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_update_whos_online.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_update_whos_online.inc.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  function vam_update_whos_online() {
    if (isset($_SESSION['customer_id'])) {
      $wo_customer_id = $_SESSION['customer_id'];

      $wo_full_name = addslashes($_SESSION['customer_first_name'] . ' ' . $_SESSION['customer_last_name']);
    } else {
      $wo_customer_id = 0;
      $wo_full_name = TEXT_GUEST;
    }

    $wo_session_id = vam_session_id();
    $wo_ip_address = vam_get_ip_address();
    $wo_last_page_url = addslashes(getenv('REQUEST_URI'));

    $current_time = time();
    $xx_mins_ago = ($current_time - 900);

    // remove entries that have expired
    vam_db_query("delete from " . TABLE_WHOS_ONLINE . " where time_last_click < '" . $xx_mins_ago . "'");

    $stored_customer_query = vam_db_query("select count(*) as count from " . TABLE_WHOS_ONLINE . " where session_id = '" . $wo_session_id . "'");
    $stored_customer = vam_db_fetch_array($stored_customer_query);

    if ($stored_customer['count'] > 0) {
      vam_db_query("update " . TABLE_WHOS_ONLINE . " set customer_id = '" . $wo_customer_id . "', full_name = '" . $wo_full_name . "', ip_address = '" . $wo_ip_address . "', time_last_click = '" . $current_time . "', last_page_url = '" . $wo_last_page_url . "' where session_id = '" . $wo_session_id . "'");
    } else {
      vam_db_query("insert into " . TABLE_WHOS_ONLINE . " (customer_id, full_name, session_id, ip_address, time_entry, time_last_click, last_page_url) values ('" . $wo_customer_id . "', '" . $wo_full_name . "', '" . $wo_session_id . "', '" . $wo_ip_address . "', '" . $current_time . "', '" . $current_time . "', '" . $wo_last_page_url . "')");
    }
  }
?>