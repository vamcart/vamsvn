<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//
// Autologin Secure 2.2
//
// 30 Sept 2014  - Updated by mark@electronicDNA.co.uk
// 11-05-2014    - Chaveiro at catus dot net

// What this does is to allow client to set a checkbox and will be remembered in that pc for up to 10 years of inactivity.
// The information is saved client side in a cookie with an md5 hash from the username, encrypted password, userid and current user ip.
// This hash warrants an highly security mode even if someone steals your cookie hash as he will have to use a connection from the same ip address as you did.
// If client changes email or password on other computer will have to login again on other computer he might use.
// Module follows osCommerce coding style and use tep functions when available.

function vam_autologincookie ($on)
{
	if ($on)
    {
        global $customer_id ;
        if (vam_session_is_registered('customer_id'))
        {
            $customer_id_match_query = vam_db_query("select 1 from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$_SESSION['customer_id'] . "'");
		    if (vam_db_num_rows($customer_id_match_query) > 0)
            { // COOKIE ON
                $check_customer_query = vam_db_query("select customers_id, customers_password, customers_email_address from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$_SESSION['customer_id'] . "'");
				$check_customer = vam_db_fetch_array($check_customer_query);
				//$ip_address = vam_get_ip_address();                                                                                                                                 // expires in 10 years
				//vam_setcookie( "autologin", md5($check_customer['customers_id'].$check_customer['customers_email_address'].$check_customer['customers_password'].$ip_address), time()+60*60*24*3650, "/",  "", 0 );
				vam_setcookie( "autologin", md5($check_customer['customers_id'].$check_customer['customers_email_address'].$check_customer['customers_password']), time()+60*60*24*3650, "/",  "", 0 );
			}
		}
	}else{ // COOKIE OFF
	    vam_setcookie( "autologin", "", 0, "/",  "", 0 );
	}
}


function vam_doautologin () 
{
    global $customer_default_address_id, $customer_first_name, $customer_country_id, $customer_zone_id , $navigation;

	if (strlen($_COOKIE['autologin']))
	{
		//$ip_address = vam_get_ip_address();

        //$session_match_query = vam_db_query("select 1 from " . TABLE_CUSTOMERS . " where md5(CONCAT(customers_id,customers_email_address,customers_password,'" . $ip_address . "'))= '" . $_COOKIE['autologin'] . "'");
        $session_match_query = vam_db_query("select 1 from " . TABLE_CUSTOMERS . " where md5(CONCAT(customers_id,customers_email_address,customers_password))= '" . $_COOKIE['autologin'] . "'");

        if (vam_db_num_rows($session_match_query) > 0)
        {

            //$check_customer_query = vam_db_query("select customers_id, customers_vat_id, customers_firstname,customers_lastname, customers_gender, customers_password, customers_email_address, login_tries, login_time, customers_default_address_id from " . TABLE_CUSTOMERS . " where md5(CONCAT(customers_id,customers_email_address,customers_password,'" . $ip_address . "'))= '" . $_COOKIE['autologin'] . "'");
            $check_customer_query = vam_db_query("select customers_id, customers_status, customers_vat_id, customers_firstname,customers_lastname, customers_gender, customers_password, customers_email_address, login_tries, login_time, customers_default_address_id from " . TABLE_CUSTOMERS . " where md5(CONCAT(customers_id,customers_email_address,customers_password))= '" . $_COOKIE['autologin'] . "'");
            $check_customer = vam_db_fetch_array($check_customer_query);

            if (SESSION_RECREATE == 'True')
            {
                vam_session_recreate();
            }

            $check_country_query = vam_db_query("select entry_country_id, entry_zone_id from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . $check_customer['customers_id'] . "' and address_book_id = '" . (int)$check_customer['customers_default_address_id'] . "'");
            $check_country = vam_db_fetch_array($check_country_query);

            $customer_id = $check_customer['customers_id'];
            $customer_default_address_id = $check_customer['customers_default_address_id'];
            $customer_first_name = $check_customer['customers_firstname'];
            $customer_country_id = $check_country['entry_country_id'];
            $customer_zone_id = $check_country['entry_zone_id'];

            if (!vam_session_is_registered('customer_id')) vam_session_register('customer_id');
            if (!vam_session_is_registered('customer_default_address_id')) vam_session_register('customer_default_address_id');
            if (!vam_session_is_registered('customer_first_name')) vam_session_register('customer_first_name');
            if (!vam_session_is_registered('customer_country_id')) vam_session_register('customer_country_id');
            if (!vam_session_is_registered('customer_zone_id')) vam_session_register('customer_zone_id');

            $_SESSION['customer_gender'] = $check_customer['customers_gender'];
            $_SESSION['customer_first_name'] = $check_customer['customers_firstname'];
            $_SESSION['customer_last_name'] = $check_customer['customers_lastname'];
            $_SESSION['customer_email_address'] = $check_customer['customers_email_address'];
            $_SESSION['customer_id'] = $check_customer['customers_id'];
            $_SESSION['customers_status']['customers_status_id'] = $check_customer['customers_status'];
            $_SESSION['customer_vat_id'] = $check_customer['customers_vat_id'];
            $_SESSION['customer_default_address_id'] = $check_customer['customers_default_address_id'];
            $_SESSION['customer_country_id'] = $check_country['entry_country_id'];
            $_SESSION['customer_zone_id'] = $check_country['entry_zone_id'];

            vam_autologincookie(true); // Save cookie

            vam_db_query("update " . TABLE_CUSTOMERS_INFO . " set customers_info_date_of_last_logon = now(), customers_info_number_of_logons = customers_info_number_of_logons+1 where customers_info_id = '" . (int)$customer_id . "'");

            if (method_exists($_SESSION['cart'], 'restore_contents'))
            {
                $_SESSION['cart']->restore_contents(); // restore cart contents
            }
            else
            {
                $hour = date('G');
                if( $hour > 7  and $hour < 25 )
                {
                    error_log('@@hack 87 $cart->restore_contents() method fail fix');
                }
            }

            /*  Trying to get back to the users last page can cause page loop, add if your site doesn't change much and also lower cookie expire time to 14 days
if (sizeof($navigation->snapshot) > 0) {
  $origin_href = vam_href_link($navigation->snapshot['page'], vam_array_to_string($navigation->snapshot['get'], array(vam_session_name())), $navigation->snapshot['mode']);
  $navigation->clear_snapshot();
  vam_redirect($origin_href);
} else {
//			    vam_redirect(vam_href_link(FILENAME_DEFAULT));
  vam_redirect(substr(vam_href_link(getenv('REQUEST_URI')), strlen(HTTP_SERVER . DIR_WS_HTTP_CATALOG)));  ;
}
            */
        }
    }
}

