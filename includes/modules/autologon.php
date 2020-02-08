<?php
/*
  $Id: autologon.php,v 1.11 2003/01/18 20:00:00  Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Copyright (c) 2003 HMCservices
  Released under the GNU General Public License
*/
$cookie_url_array = parse_url((ENABLE_SSL == true ? HTTPS_SERVER : HTTP_SERVER) . substr(DIR_WS_CATALOG, 0, -1));
$cookie_path = $cookie_url_array['path'];	

if (($email_address != "") && ($password != "")) {
  $check_customer_query = tep_db_query("select customers_id, customers_firstname, customers_lastname, customers_password, customers_email_address, customers_default_address_id from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
  if (tep_db_num_rows($check_customer_query)) {
    $check_customer = tep_db_fetch_array($check_customer_query);
    if (tep_validate_password($password, $check_customer['customers_password'])) {
       if (SESSION_RECREATE == 'True') {
          tep_session_recreate();
        }
      $check_country_query = tep_db_query("select entry_country_id, entry_zone_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . $check_customer['customers_id'] . "' and address_book_id = '" . (int)$check_customer['customers_default_address_id'] . "'");
      $check_country = tep_db_fetch_array($check_country_query);

      $customer_id = $check_customer['customers_id'];
      $customer_default_address_id = $check_customer['customers_default_address_id'];
      $customer_first_name = $check_customer['customers_firstname'];
      $customer_country_id = $check_country['entry_country_id'];
      $customer_zone_id = $check_country['entry_zone_id'];
      if(!tep_session_is_registered('customer_id'))
          tep_session_register('customer_id');
      if(!tep_session_is_registered('customer_default_address_id'))
          tep_session_register('customer_default_address_id');
      if(!tep_session_is_registered('customer_first_name'))
	  tep_session_register('customer_first_name');
      if(!tep_session_is_registered('customer_country_id'))
          tep_session_register('customer_country_id');
      if(!tep_session_is_registered('customer_zone_id'))
          tep_session_register('customer_zone_id');

      setcookie('email_address', $email_address, time()+ (365 * 24 * 3600), $cookie_path, '', ((getenv('HTTPS') == 'on') ? 1 : 0));
      setcookie('password', $check_customer['customers_password'], time()+ (365 * 24 * 3600), $cookie_path, '', ((getenv('HTTPS') == 'on') ? 1 : 0));
      $date_now = date('Y-m-d');
      $qr = "update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_of_last_logon = now(), customers_info_number_of_logons = customers_info_number_of_logons+1 where customers_info_id = '" . $customer_id . "'";
      tep_db_query($qr);
      $cart->restore_contents();    // restore cart contents
    }
  }
} else {
// chande due to bug fix from the   fix.txt addded on 11/01/07
/*  if($autologon_executed != 'true'){
    $autologon_page = '<html><head><meta http-equiv="Refresh" content="0;URL=' . tep_href_link(FILENAME_LOGOFF, '', 'SSL') . '"></head><body></body></html>';
    $autologon_link = ((getenv('HTTPS') == 'on') ? 'https://' : 'http://') . $SERVER_NAME . $REQUEST_URI . (strpos($REQUEST_URI, "?") ? '&' : '?') . SID;
    $autologon_executed = 'true';
    if(!tep_session_is_registered('autologon_link'))
        tep_session_register('autologon_link');
    if(!tep_session_is_registered('autologon_executed'))
	tep_session_register('autologon_executed');
    tep_session_close();
    exit($autologon_page);
  }*/
}
if (tep_session_is_registered('autologon_link')) {
  $x = $autologon_link;
  tep_session_unregister('autologon_link');
  tep_redirect($x);
}
?>