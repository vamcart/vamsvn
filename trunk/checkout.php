<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce
  Copyright (c) 2012 STRUB

  Released under the GNU General Public License
*/

//description
//$sendto = is from db table ADRESS_BOOK the adress_book_id


require('includes/application_top.php');
//used for shipping
require('includes/classes/http_client.php');

require_once (DIR_FS_INC.'vam_address_label.inc.php');
require_once (DIR_FS_INC.'vam_get_address_format_id.inc.php');
require_once (DIR_FS_INC.'vam_count_shipping_modules.inc.php');
require_once (DIR_FS_INC.'vam_draw_radio_field.inc.php');
require_once (DIR_FS_INC.'vam_get_country_list.inc.php');
require_once (DIR_FS_INC.'vam_draw_checkbox_field.inc.php');
require_once (DIR_FS_INC.'vam_draw_password_field.inc.php');
require_once (DIR_FS_INC.'vam_validate_email.inc.php');
require_once (DIR_FS_INC.'vam_encrypt_password.inc.php');
require_once (DIR_FS_INC.'vam_create_password.inc.php');
require_once (DIR_FS_INC.'vam_draw_hidden_field.inc.php');
require_once (DIR_FS_INC.'vam_draw_pull_down_menu.inc.php');
require_once (DIR_FS_INC.'vam_get_geo_zone_code.inc.php');
require_once (DIR_FS_INC.'vam_get_zone_name.inc.php');
require_once (DIR_FS_INC.'vam_random_charcode.inc.php');

// create smarty elements
$vamTemplate = new vamTemplate;

//START functions specific
function vam_get_sc_titles_number() {
	if (SC_COUNTER_ENABLED == 'true') {
		static $sc_count = 0;
		$sc_count++;
		return $sc_count . '.&nbsp;&nbsp;';
	}
}
//END functions specific


if (isset($_POST['sc_shipping_address_show'])) { 
$sc_shipping_address_show = $_POST['sc_shipping_address_show'];
} else {
$sc_shipping_address_show = true;
}

if (isset($_POST['sc_shipping_modules_show'])) { 
$sc_shipping_modules_show = $_POST['sc_shipping_modules_show'];
} else {
$sc_shipping_modules_show = true; 
}


//used for the validation
if (isset($_POST['create_account'])) { 
	$create_account = $_POST['create_account'];
} else {
	$create_account = false; 
}

if (isset($_POST['sc_payment_address_show'])) { 
$sc_payment_address_show = $_POST['sc_payment_address_show'];
} else {
$sc_payment_address_show = true;
}

if (isset($_POST['sc_payment_modules_show'])) { 
$sc_payment_modules_show = $_POST['sc_payment_modules_show'];
} else {
$sc_payment_modules_show = true;
}


$checkout_possible = true;
$sc_is_virtual_product = false; //used to change Title Shipping Address to Payment Address and add text (you need to create account...) to create account
$sc_is_mixed_product = false; //virtul and normal products
$sc_is_free_virtual_product = false; // is free virtual product - used to change title shipping address to account information
$sc_payment_modules_process = true; //used to avoid runing payment selection()




//session are used if a visitor cancel during checkout process and returns again he does not need to type his data again
$sc_guest_gender = $_SESSION['sc_customers_gender'];
$sc_guest_firstname = $_SESSION['sc_customers_firstname'];
$sc_guest_lastname = $_SESSION['sc_customers_lastname'];
$sc_guest_dob = $_SESSION['sc_customers_dob'];
$sc_guest_email_address = $_SESSION['sc_customers_email_address'];
$sc_guest_default_address_id = $_SESSION['sc_customers_default_address_id'];
$sc_guest_telephone = $_SESSION['sc_customers_telephone'];
$sc_guest_fax = $_SESSION['sc_customers_fax'];
$sc_guest_company = $_SESSION['sc_customers_company'];
$sc_guest_street_address = $_SESSION['sc_customers_street_address'];
$sc_guest_suburb = $_SESSION['sc_customers_suburb'];
$sc_guest_city = $_SESSION['sc_customers_city'];
$sc_guest_postcode = $_SESSION['sc_customers_postcode'];

//load languages files
require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . FILENAME_CHECKOUT);

////////////  Check Things  ////////////////////
// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() < 1) {
   vam_redirect(vam_href_link(FILENAME_SHOPPING_CART));
}
 
 
 // Stock Check
  if ( (STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true') ) {
    $products = $_SESSION['cart']->get_products();
    for ($i=0, $n=sizeof($products); $i<$n; $i++) {
      if (vam_check_stock($products[$i]['id'], $products[$i]['quantity'])) {
        vam_redirect(vam_href_link(FILENAME_SHOPPING_CART));
        break;
      }
    }
  }



//////////////////  End Check //////////////////////////////

$payment_address_selected = $_POST['payment_adress']; //init if checkbox for payment address is checked or not
$shipping_count_modules = $_POST['shipping_count']; //needed for validation

if (!isset ($_SESSION['customer_id'])) { //only for not logged in user
	if (!isset($_POST['action'])) {
		$password_selected = true; 
	} else {
		if (SC_CREATE_ACCOUNT_CHECKOUT_PAGE != 'true') {
			$password_selected = true;
		} else {
			$password_selected = $_POST['password_checkbox']; 
		}
	}
	
	if ($password_selected != '1') { //not selected 
		$create_account = true;
	} else { //is selected
		$create_account = false; //set to false in order to avoid validation
	}
}



############################# Validate start - NOT LOGGED ON #######################################

  $process = false;
  if (isset($_POST['action']) && ($_POST['action'] == 'not_logged_on') && isset($_POST['formid']) && ($_POST['formid'] == $sessiontoken)) {
    $process = true;
	
	if ($sc_shipping_address_show == true) { //show shipping otpions 
    if (ACCOUNT_GENDER == 'true') {
      if (isset($_POST['gender'])) {
        $gender = vam_db_prepare_input($_POST['gender']);
      } else {
        $gender = false;
      }
    }
    $firstname = vam_db_prepare_input($_POST['firstname']);
    $lastname = vam_db_prepare_input($_POST['lastname']);
    if (ACCOUNT_DOB == 'true') $dob = vam_db_prepare_input($_POST['dob']);
    $email_address = vam_db_prepare_input($_POST['email_address']);
    if (ACCOUNT_COMPANY == 'true') $company = vam_db_prepare_input($_POST['company']);
    $street_address = vam_db_prepare_input($_POST['street_address']);
    if (ACCOUNT_SUBURB == 'true') $suburb = vam_db_prepare_input($_POST['suburb']);
    $postcode = vam_db_prepare_input($_POST['postcode']);
    $city = vam_db_prepare_input($_POST['city']);
    if (ACCOUNT_STATE == 'true') {
      $state = vam_db_prepare_input($_POST['state']);
      if (isset($_POST['zone_id'])) {
        $zone_id = vam_db_prepare_input($_POST['zone_id']);
      } else {
        $zone_id = false;
      }
    }
    $country = vam_db_prepare_input($_POST['country']);
    $telephone = vam_db_prepare_input($_POST['telephone']);
    $fax = vam_db_prepare_input($_POST['fax']);
    if (isset($_POST['newsletter'])) {
      $newsletter = vam_db_prepare_input($_POST['newsletter']);
    } else {
      $newsletter = false;
    }
    $password = vam_db_prepare_input($_POST['password']);
    $confirmation = vam_db_prepare_input($_POST['confirmation']);
	
	//start with input validation for shipping address /////////
    $error = false;
	
		
    if (ACCOUNT_GENDER == 'true') {
      if ( ($gender != 'm') && ($gender != 'f') ) {
        $error = true;

        $messageStack->add('smart_checkout', ENTRY_GENDER_ERROR);
      }
    }

    if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('smart_checkout', ENTRY_FIRST_NAME_ERROR);
    }

    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('smart_checkout', ENTRY_LAST_NAME_ERROR);
    }

    if (ACCOUNT_DOB == 'true') {
      if ((is_numeric(vam_date_raw($dob)) == false) || (@checkdate(substr(vam_date_raw($dob), 4, 2), substr(vam_date_raw($dob), 6, 2), substr(vam_date_raw($dob), 0, 4)) == false)) {
        $error = true;

        $messageStack->add('smart_checkout', ENTRY_DATE_OF_BIRTH_ERROR);
      }
    }


	if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('smart_checkout', ENTRY_EMAIL_ADDRESS_ERROR);
    } elseif (vam_validate_email($email_address) == false) {
      $error = true;

      $messageStack->add('smart_checkout', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    } else {
      //org
	  $check_email_query = vam_db_query("select count(*) as total from " . TABLE_CUSTOMERS . " where customers_email_address = '" . vam_db_input($email_address) . "'");
	  
	  //new
      //$check_email_query = vam_db_query("select count(*) as total from " . TABLE_CUSTOMERS . " where customers_email_address = '" . vam_db_input($email_address) . "' and guest_account != '1'");
     
	  
	 

  
      $check_email = vam_db_fetch_array($check_email_query);
      if ($check_email['total'] > 0) {
        $error = true;
		

        $messageStack->add('smart_checkout', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
      }
    }
    
    if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('smart_checkout', ENTRY_STREET_ADDRESS_ERROR);
    }

    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
      $error = true;

      $messageStack->add('smart_checkout', ENTRY_POST_CODE_ERROR);
    }

    if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
      $error = true;

      $messageStack->add('smart_checkout', ENTRY_CITY_ERROR);
    }

    if (is_numeric($country) == false) {
      $error = true;

      $messageStack->add('smart_checkout', ENTRY_COUNTRY_ERROR);
    }

    if (ACCOUNT_STATE == 'true') {
      $zone_id = 0;
      $check_query = vam_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "'");
      $check = vam_db_fetch_array($check_query);
      $entry_state_has_zones = ($check['total'] > 0);
      if ($entry_state_has_zones == true) {
        $zone_query = vam_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' and (zone_name = '" . vam_db_input($state) . "' or zone_code = '" . vam_db_input($state) . "')");
        if (vam_db_num_rows($zone_query) == 1) {
          $zone = vam_db_fetch_array($zone_query);
          $zone_id = $zone['zone_id'];
        } else {
          $error = true;

          $messageStack->add('smart_checkout', ENTRY_STATE_ERROR_SELECT);
        }
      } else {
        if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
          $error = true;

          $messageStack->add('smart_checkout', ENTRY_STATE_ERROR);
        }
      }
    }

    if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
      $error = true;

      $messageStack->add('smart_checkout', ENTRY_TELEPHONE_NUMBER_ERROR);
    }
	
	//password validation
	$password = vam_db_prepare_input($_POST['password']);
    $confirmation = vam_db_prepare_input($_POST['confirmation']);
	if ($create_account == true) {
		if (!isset ($_SESSION['customer_id'])) { //validate only for unregistered user
		 if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
			  $error = true;
	
			  $messageStack->add('smart_checkout', ENTRY_PASSWORD_ERROR);
			} elseif ($password != $confirmation) {
			  $error = true;
	
			  $messageStack->add('smart_checkout', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
			}
		}
	}	
	
	//shipping validation
	$shipping_validation = $_POST['shipping'];
	if ($sc_shipping_modules_show == true) {
		if (($shipping_validation == '') && ($shipping_count_modules > 1)) {
			$error = true;
			$messageStack->add('smart_checkout', SHIPPING_ERROR);
		}
	}
	
	
		
	/*if ($sc_shipping_modules_show == true) {
		if (($shipping_validation == '') && ($shipping_count_modules == 1)) {
			$error = true;
			$messageStack->add('smart_checkout', SHIPPING_ERROR);
		}
	}*/
	
	//payment validation
	$payment_validation = $_POST['payment'];
	if ($sc_payment_modules_show == true) { 
		if ($payment_validation == '') {
			$error = true;
			$messageStack->add('smart_checkout', PAYMENT_ERROR);
		}
	}

	//conditions validation
	$conditions_validation = $_POST['TermsAgree'];
	if (($conditions_validation == '') && (SC_CONDITIONS == 'true')) {
		$error = true;
		$messageStack->add('smart_checkout', CONDITIONS_ERROR);
    }
	
	
	//End with input validation for shipping address /////////	
	} //End show shipping otpions


	// start new payment address input validation /////
	if ($payment_address_selected != '1') { //is unchecked - so payment address is different or if we have virtual products
	  
	 if ($sc_payment_address_show == true) { //validate only if not free payment 
		
      if (ACCOUNT_GENDER == 'true') $gender_payment = vam_db_prepare_input($_POST['gender_payment']);
      if (ACCOUNT_COMPANY == 'true') $company_payment = vam_db_prepare_input($_POST['company_payment']);
      $firstname_payment = vam_db_prepare_input($_POST['firstname_payment']);
      $lastname_payment = vam_db_prepare_input($_POST['lastname_payment']);
      $street_address_payment = vam_db_prepare_input($_POST['street_address_payment']);
      if (ACCOUNT_SUBURB == 'true') $suburb_payment = vam_db_prepare_input($_POST['suburb_payment']);
      $postcode_payment = vam_db_prepare_input($_POST['postcode_payment']);
      $city_payment = vam_db_prepare_input($_POST['city_payment']);
      $country_payment = vam_db_prepare_input($_POST['country_payment']);
      if (ACCOUNT_STATE == 'true') {
        if (isset($_POST['zone_id'])) {
          $zone_id_payment = vam_db_prepare_input($_POST['zone_id_payment']);
        } else {
          $zone_id_payment = false;
        }
        $state_payment = vam_db_prepare_input($_POST['state_payment']);
      }

      if (ACCOUNT_GENDER == 'true') {
        if ( ($gender_payment != 'm') && ($gender_payment != 'f') ) {
          $error = true;

          $messageStack->add('smart_checkout', ENTRY_GENDER_ERROR);
        }
      }


		
		
      if (strlen($firstname_payment) < ENTRY_FIRST_NAME_MIN_LENGTH) {
        $error = true;

        $messageStack->add('smart_checkout', ENTRY_FIRST_NAME_ERROR);
      }

      if (strlen($lastname_payment) < ENTRY_LAST_NAME_MIN_LENGTH) {
        $error = true;

        $messageStack->add('smart_checkout', ENTRY_LAST_NAME_ERROR);
      }

      if (strlen($street_address_payment) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
        $error = true;

        $messageStack->add('smart_checkout', ENTRY_STREET_ADDRESS_ERROR);
      }

      if (strlen($postcode_payment) < ENTRY_POSTCODE_MIN_LENGTH) {
        $error = true;

        $messageStack->add('smart_checkout', ENTRY_POST_CODE_ERROR);
      }

      if (strlen($city_payment) < ENTRY_CITY_MIN_LENGTH) {
        $error = true;

        $messageStack->add('smart_checkout', ENTRY_CITY_ERROR);
      }

      if (ACCOUNT_STATE == 'true') {
        $zone_id_payment = 0;
        $check_query = vam_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country_payment . "'");
        $check = vam_db_fetch_array($check_query);
        $entry_state_has_zones = ($check['total'] > 0);
        if ($entry_state_has_zones == true) {
          $zone_query = vam_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country_payment . "' and (zone_name = '" . vam_db_input($state_payment) . "' or zone_code = '" . vam_db_input($state_payment) . "')");
          if (vam_db_num_rows($zone_query) == 1) {
            $zone_payment = vam_db_fetch_array($zone_query);
            $zone_id_payment = $zone_payment['zone_id'];
          } else {
            $error = true;

            $messageStack->add('smart_checkout', ENTRY_STATE_ERROR_SELECT);
          }
        } else {
          if (strlen($state_payment) < ENTRY_STATE_MIN_LENGTH) {
            $error = true;

            $messageStack->add('smart_checkout', ENTRY_STATE_ERROR);
          }
        }
      }

      if ( (is_numeric($country_payment) == false) || ($country_payment < 1) ) {
        $error = true;

        $messageStack->add('smart_checkout', ENTRY_COUNTRY_ERROR);
      }
	 }
	} //END validate only if not free payment 
	 // End new payment address input validation /////

}
//////////////////////////  Validation END - NOT LOGGED ON//////////////////////////////////



/////////////////// Validation for LOGGED ON ////////////////////////////////////////////
if (isset($_POST['action']) && ($_POST['action'] == 'logged_on') && isset($_POST['formid']) && ($_POST['formid'] == $sessiontoken)) {


	// start with input validation /////////
    $error = false;
	
	//shipping validation
	$shipping_validation = $_POST['shipping'];
	if ($sc_shipping_modules_show == true) {
		if (($shipping_validation == '') && ($shipping_count_modules > 1)) {
			$error = true;
			$messageStack->add('smart_checkout', SHIPPING_ERROR);
		}
	}
	
	//payment validation
	$payment_validation = $_POST['payment'];
	if ($sc_payment_modules_show == true) { 
		if ($payment_validation == '') {
			$error = true;
			$messageStack->add('smart_checkout', PAYMENT_ERROR);
		}
	}
	
	//conditions validation
	$conditions_validation = $_POST['TermsAgree'];
	if (($conditions_validation == '') && (SC_CONDITIONS == 'true')) {
		$error = true;
		$messageStack->add('smart_checkout', CONDITIONS_ERROR);
    }
	
}	

/////////// end with input validation for LOOGED ON /////////

//load Classes 
require(DIR_WS_CLASSES.'shipping.php');
require(DIR_WS_CLASSES.'payment.php'); 
require(DIR_WS_CLASSES.'order.php');
require(DIR_WS_CLASSES.'order_total.php');






if (!isset($_SESSION['payment'])) {vam_session_register('payment');}
if (!isset($_SESSION['sendto'])) {vam_session_register('sendto');} //need to set it otherwise in checkout_process.php we get redirected to checkout_shipping.php
if (!isset($_SESSION['billto'])) {vam_session_register('billto');} //need to set it otherwise in checkout_process.php we get redirected to payment_shipping.php
if (isset($_SESSION['free_payment'])) {vam_session_unregister('free_payment');} //hack for free payment unregister it if changing products

if (isset($_SESSION['noaccount'])) {vam_session_unregister('noaccount');} //used for order class - order.php
if (isset($_SESSION['show_account_data'])) {vam_session_unregister('show_account_data');} //used for confirmation page to show account data
if (isset($_SESSION['create_account'])) {vam_session_unregister('create_account');} //used for confirmation page to send email if account is created
if (isset($_SESSION['hide_shipping_data'])) {vam_session_unregister('hide_shipping_data');} //used for confirmation page to hide shipping data
if (isset($_SESSION['hide_payment_data'])) {vam_session_unregister('hide_payment_data');} //used for confirmation page to hide payment data





//Classes init need to set here
$order = new order;  



//set $selected_country_id
//if logged in set $selected_country_id from order class else from selected Post
if (isset ($_SESSION['customer_id'])) {
$selected_country_id = $order->delivery['country']['id'];
} else {
//$selected_country_id = $_POST['country'];
if (isset($_POST['country'])) {
  $selected_country_id = $_POST['country'];
} else {
  $selected_country_id = STORE_COUNTRY; //here you can set your default country ID
}

}



// country is selected
        $country_info = vam_get_countriesList($selected_country_id,true);
        $cache_state_prov_values = vam_db_fetch_array(vam_db_query("select zone_code from " . TABLE_ZONES . " where zone_country_id = '" . $selected_country_id . "' and zone_id = '" . $_POST['state'] . "'"));
        $cache_state_prov_code = $cache_state_prov_values['zone_code'];
        $order->delivery = array('postcode' => $_POST['zip_code'],
                                 'state' => $cache_state_prov_code,
                                 'country' => array('id' => $selected_country_id, 'title' => $country_info['countries_name'], 'iso_code_2' => $country_info['countries_iso_code_2'], 'iso_code_3' =>  $country_info['countries_iso_code_3']),
                                 'country_id' => $selected_country_id,
//add state zone_id
                                 'zone_id' => $_POST['state'],
                                 'format_id' => vam_get_address_format_id($selected_country_id));
// country is selected End								 	  


  


$shipping_modules = new shipping; //set it after getting country_info otherwise it won't update shipping methods with jquery

$total_weight = $_SESSION['cart']->show_weight(); //set before $shipping is defined

//used for post data for validation
$shipping_count = vam_count_shipping_modules();




// Free Shipping module
  if ( defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'true') ) {
    $pass = false;

    switch (MODULE_ORDER_TOTAL_SHIPPING_DESTINATION) {
      case 'national':
        if ($order->delivery['country_id'] == STORE_COUNTRY) {
          $pass = true;
        }
        break;
      case 'international':
        if ($order->delivery['country_id'] != STORE_COUNTRY) {
          $pass = true;
        }
        break;
      case 'both':
        $pass = true;
        break;
    }

    $free_shipping = false;
    if ( ($pass == true) && ($order->info['total'] >= MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER) ) {
      $free_shipping = true;

      include(DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/order_total/ot_shipping.php');
    }
  } else {
    $free_shipping = false;
  }

		
// Free Shipping module End





// START calculation if 0 shipping method is active ////
if (vam_count_shipping_modules() == 0) {
// get all available shipping quotes
		$shipping = array	('id' => '', 'title' => '<span class="errorText">' . TEXT_NO_SHIPPING_AVAILABLE . '</span>', 'cost' => '');
		$checkout_possible = false;
		
}
// END calculation if 0 shipping method is active ////

// calculation if only 1 shipping method is set ////
  if (vam_count_shipping_modules() == 1) {
  		
		// get all available shipping quotes
		$quotes = $shipping_modules->quote();

		$ship_id = $quotes[0]['id'] . '_' . $quotes[0]['methods'][0]['id'];
		  
		if ($quotes[0]['error'] == '') {
		  	$ship_title = $quotes[0]['module'] . ' (' . $quotes[0]['methods'][0]['title'] . ')';
			
		} elseif ($quotes[0]['methods'][0]['title'] == 'u') {
		  	$ship_title = '<span class="errorText">adsfdsfsdf</span>';
			$checkout_possible = false; //checkout not possible
		} else {
		  	$ship_title = '<span class="errorText">' . $quotes[0]['error'] . '</span>';
			$checkout_possible = false; //checkout not possible
			
			
		}
		
		
		$ship_cost = $quotes[0]['methods'][0]['cost'];
		
		if ($free_shipping == true) {
			$shipping = array	('id' => '', 'title' => FREE_SHIPPING_TITLE, 'cost' => 0); 
		} else {
			$shipping = array	('id' => $ship_id, 'title' => $ship_title, 'cost' => $ship_cost);
			if ($ship_cost == 0) {
				$checkout_possible = false;
			} 
			
		}	  
  		
		//calculation for Jquery Post
		if (isset($_POST['shipping']) && vam_not_null($_POST['shipping'])){  //$shipping start test
			//no calculation yet
			
		} else {
		  //calculation first time ////////////
		  
			if ($order->content_type == 'virtual') {
				$shipping = false; //set it also in this case if only one shipping method is set
			}
			
			$order = new order;  //set it here again to calculate shipping method after $shipping is defined
			
			
			// country info for country change
					$country_info = vam_get_countries($selected_country_id,true);
					$cache_state_prov_values = vam_db_fetch_array(vam_db_query("select zone_code from " . TABLE_ZONES . " where zone_country_id = '" . $selected_country_id . "' and zone_id = '" . $_POST['state'] . "'"));
					$cache_state_prov_code = $cache_state_prov_values['zone_code'];
					$order->delivery = array('postcode' => $_POST['zip_code'],
											 'state' => $cache_state_prov_code,
											 'country' => array('id' => $selected_country_id, 'title' => $country_info['countries_name'], 'iso_code_2' => $country_info['countries_iso_code_2'], 'iso_code_3' =>  $country_info['countries_iso_code_3']),
											 'country_id' => $selected_country_id,
			//add state zone_id
											 'zone_id' => $_POST['state'],
											 'format_id' => vam_get_address_format_id($selected_country_id));
			// end country info for country change								 	  
			  
		} //$shipping end test
  } 
// END - if only 1 shipping method is set ////  
  
 
//Classes init ##########################################
$total_count = $_SESSION['cart']->count_contents();  

if (isset($_POST['payment'])){ $payment = $_POST['payment'];} //payment post data assignment

//payment class
if ((!isset($_POST['payment'])) || ($error == true)) {
	$payment_modules = new payment();
} elseif (isset($_POST['payment'])) {
	$payment_modules = new payment($payment);
}


$order_total_modules = new order_total;
$order_total_modules->process();

//Classes init end ##########################################



############# Shipping specific  ####################
/*
 // if no shipping destination address was selected, use the customers own address as default
  if (!isset($_SESSION['sendto'])) {
    vam_session_register('sendto');
    $sendto = $customer_default_address_id;
  } else {
// verify the selected shipping address
    if ( (is_array($sendto) && empty($sendto)) || is_numeric($sendto) ) {
      $check_address_query = vam_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' and address_book_id = '" . (int)$sendto . "'");
      $check_address = vam_db_fetch_array($check_address_query);

      if ($check_address['total'] != '1') {
        $sendto = $customer_default_address_id;
        if (isset($_SESSION['shipping'])) vam_session_unregister('shipping');
      }
    }
  }
*/

  
// register a random ID in the session to check throughout the checkout procedure
// against alterations in the shopping cart contents
  if (!isset($_SESSION['cartID'])) vam_session_register('cartID');
  $cartID = $_SESSION['cart']->cartID;

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($_SESSION['cart']->cartID) && isset($_SESSION['cartID'])) {
    if ($_SESSION['cart']->cartID != $cartID) {
      vam_redirect(vam_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
    }
  }

############## START definition of product types #######################################################   
  //normal product
  if ($order->content_type == 'physical') {
  	//define
  }
  
  // in this case we need to hide shipping address and only payment address is shown as there is no shipping 
  if ($order->content_type == 'virtual') {
    if (!isset($_SESSION['shipping'])) vam_session_register('shipping');
    $shipping = false;
    $sendto = false;
	$checkout_possible = true; //avoid shipping validation
	
	$payment_address_selected = '1'; //hide payemt address validation
	$sc_is_virtual_product = true; // change Title
	if (!isset($_SESSION['hide_shipping_data'])) vam_session_register('hide_shipping_data'); //hide shipping data
	$sc_payment_address_show = false; // hide payemt address as shipping address is used for payment address
	$sc_shipping_modules_show = false; //hide shipping modules
	$create_account = true; //you need to create an account
	
	if (isset ($_SESSION['customer_id'])) { //IS LOGGED ON - change shipping address to payment address
		$sc_payment_address_show = true;
		$sc_shipping_address_show = false;
		$create_account = false;
		//if (isset($_SESSION['create_account'])) {vam_session_unregister('create_account');} //is not possible
		if (!isset($_SESSION['hide_shipping_data'])) vam_session_register('hide_shipping_data'); //hide shipping data
	}
  }

//Mixed virtual products
  if ($order->content_type == 'mixed') {
	$create_account = true; //you need to create an account
	if (!isset($_SESSION['create_account'])) {vam_session_register('create_account');}
	$sc_is_mixed_product = true;
	if (isset ($_SESSION['customer_id'])) { //IS LOGGED ON
		$create_account = false;
	}
  }

//Free products - could have shipping costs so payment is needed
  if ($order->info['subtotal'] == '0') {
	if (isset ($_SESSION['customer_id'])) { //IS LOGGED ON
		$sendto = $customer_default_address_id; 
	}
  }


//Free products and free shipping
  /*if ($order->info['total'] == '0') {
	$payment_address_selected = '1'; //hide payemt address validation
	$sc_payment_address_show = false; // hide payemt address as shipping address is used for payment address
	$sc_payment_modules_show = false; //hide payment modules
	if (!vam_session_is_registered('free_payment')) {vam_session_register('free_payment');} //hack for free payment
	
	if (isset ($_SESSION['customer_id'])) { //IS LOGGED ON
		$sendto = $customer_default_address_id; 
	}
  }*/


//Free Virtual Products
  if (($order->info['subtotal'] == '0') && ($order->content_type == 'virtual')) {
	  
	  $sc_is_free_virtual_product = true; // is free virtual product
	  $sc_payment_address_show = false;
	  $sc_payment_modules_show = false; //hide payment modules
	  if (!vam_session_is_registered('hide_payment_data')) vam_session_register('hide_payment_data');
	  if (!vam_session_is_registered('show_account_data')) vam_session_register('show_account_data');
	  if (!vam_session_is_registered('free_payment')) {vam_session_register('free_payment');} //hack for free payment
	  
	  if (isset ($_SESSION['customer_id'])) { //IS LOGGED ON
		$sendto = $customer_default_address_id;
	  }
  }
  

//  

  
	
	
  if (SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true') {
  	//$create_account = true; //you need to create an account
	//if (!vam_session_is_registered('create_account')) {vam_session_register('create_account');}
	if (isset ($_SESSION['customer_id'])) { //IS LOGGED ON
	//	if (vam_session_is_registered('create_account')) {vam_session_unregister('create_account');} //is not possible
	}
  }
  
  if (SC_CREATE_ACCOUNT_REQUIRED == 'true') {
  	$create_account = true; //you need to create an account
	if (!vam_session_is_registered('create_account')) {vam_session_register('create_account');}
	if (isset ($_SESSION['customer_id'])) { //IS LOGGED ON
		$create_account = false;
	}
  }
  
  
  //register session to create account
  if (SC_CONFIRMATION_PAGE == 'true') {
  	if (isset ($_SESSION['customer_id'])) {
		if (vam_session_is_registered('create_account')) {vam_session_unregister('create_account');} //is not possible
	} else { //is not looged on
		if ($create_account == true) {
			if (!vam_session_is_registered('create_account')) {vam_session_register('create_account');}
		} else {
			if (vam_session_is_registered('create_account')) {vam_session_unregister('create_account');}
		}
	}
	//after session set, if confirmation page always set to false as it will be created in confirmation_page.php 
	$create_account = false;
  } 
  
############## END definition of product types #######################################################  


//bugfix
if ($sendto == '') {
	$new_address_query = vam_db_query("select customers_default_address_id from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
	$new_address = vam_db_fetch_array($new_address_query);   // Hole Language aus orders DB
	$sendto = $new_address['customers_default_address_id'];
}
//bugfix end


if (!vam_session_is_registered('shipping')){ vam_session_register('shipping');}


if (isset($_POST['shipping']) && vam_not_null($_POST['shipping'])){ //used THAT IT IS not 0 again
  if ($_POST['shipping'] != 'undefined') { //to avoid setting Jquery send data which is undefined
    if ( (vam_count_shipping_modules() > 1) || ($free_shipping == true) ) { //set (vam_count_shipping_modules() > 1) to 1 instead of 0 because only one shipping method is calculated below
      
		$shipping = $_POST['shipping']; //shipping post data assignement
		//here is the selected shipping module defined
		
        list($module, $method) = explode('_', $shipping);
        if ( is_object($$module) || ($shipping == 'free_free') ) {
          if ($shipping == 'free_free') {
            $quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
            $quote[0]['methods'][0]['cost'] = '0';
          } else {
            $quote = $shipping_modules->quote($method, $module);
          }
          if (isset($quote['error'])) {
            vam_session_unregister('shipping');
          } else {
            if ( (isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost'])) ) {
				
              $shipping = array('id' => $shipping,
                                'title' => (($free_shipping == true) ?  $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
                                'cost' => $quote[0]['methods'][0]['cost']);

              //vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
            }
          }
        } else {
          vam_session_unregister('shipping');
        }
     
    }
	}
  }	
################## Shipping specific END  #####################


################## Payment specific   #####################
// if no billing destination address was selected, use the customers own address as default
  if (!vam_session_is_registered('billto')) {
    vam_session_register('billto');
    $billto = $customer_default_address_id;
  } else {
 
// verify the selected billing address
    if ( (is_array($billto) && empty($billto)) || is_numeric($billto) ) {
      $check_billto_query = vam_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' and address_book_id = '" . (int)$billto . "'");
      $check_billto = vam_db_fetch_array($check_billto_query);
      if ($check_billto['total'] != '1') {
        $billto = $customer_default_address_id;
        if (vam_session_is_registered('payment')) vam_session_unregister('payment');
      } 
    }
  }

//solves bug for no payment address
if (($billto == '') && (!vam_session_is_registered('changed_adress'))) {
	$new_address_query = vam_db_query("select customers_default_address_id from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
	$new_address = vam_db_fetch_array($new_address_query);   // Hole Language aus orders DB
	$billto = $new_address['customers_default_address_id'];
}
if (vam_session_is_registered('changed_adress')) vam_session_unregister('changed_adress');
// end bug

################## Payment specific END  #####################



//CHECK if checkout is possible here after all calculations for noaccount and logged on user/////
if (isset($_POST['action'])) {
if ($checkout_possible != true) {
		$error = true;
		$messageStack->add('smart_checkout', SC_ERROR_NO_SHIPPING_POSSIBLE);
	}
}
//END CHECK if checkout is possible here after all calculations /////	
	

///////////////////  START PROCESS Button pressed for NO ACCOUNT onepage and confirmation page  ////////////////////////////////////////////
if (isset($_POST['action']) && (($_POST['action'] == 'not_logged_on') && ($create_account != true)) && isset($_POST['formid']) && ($_POST['formid'] == $sessiontoken)) {
//if no errors
//checkout not possible used for shipping method or whatever
	
	
	
    if ($error == false) {
		
		$dbPass = vam_encrypt_password($password);
		
      	if (!vam_session_is_registered('noaccount')) {vam_session_register('noaccount');} //used for order class - order.php
        //create sessions
		$_SESSION['sc_payment_address_selected'] = $payment_address_selected; //payment address selected
		
		//customer data is also shipping data
    	$_SESSION['sc_customers_gender'] = $gender;
		$_SESSION['sc_customers_firstname'] = $firstname;
		$_SESSION['sc_customers_lastname'] = $lastname;
		$_SESSION['sc_customers_email_address'] = $email_address;
		$_SESSION['sc_customers_telephone'] = $telephone;
		$_SESSION['sc_customers_fax'] = $fax;
		$_SESSION['sc_customers_company'] = $company;
		$_SESSION['sc_customers_street_address'] = $street_address;
		$_SESSION['sc_customers_suburb'] = $suburb;
		$_SESSION['sc_customers_city'] = $city;
		$_SESSION['sc_customers_postcode'] = $postcode;
		$_SESSION['sc_customers_state'] = $state;
		$_SESSION['sc_customers_country'] = $country;
		
		//for account
		$_SESSION['sc_customers_newsletter'] = $newsletter;
		$_SESSION['sc_customers_password'] = $dbPass;
		$_SESSION['sc_customers_dob'] = $dob;
		
		if (ACCOUNT_STATE == 'true') {
			if ($zone_id > 0) {
			  $_SESSION['sc_customers_zone_id'] = $zone_id;
			  $_SESSION['sc_customers_state'] = '';
			} else {
			  $_SESSION['sc_customers_zone_id'] = '0';
			  $_SESSION['sc_customers_state'] = $state;
			}
     	}
		
		
		
		//payment data only if different
		if ($payment_address_selected != '1') { //is unchecked - so payment address is different
		
			$_SESSION['sc_payment_gender'] = $gender_payment;
			$_SESSION['sc_payment_firstname'] = $firstname_payment;
			$_SESSION['sc_payment_lastname'] = $lastname_payment;
			$_SESSION['sc_payment_company'] = $company_payment;
			$_SESSION['sc_payment_street_address'] = $street_address_payment;
			$_SESSION['sc_payment_suburb'] = $suburb_payment;
			$_SESSION['sc_payment_city'] = $city_payment;
			$_SESSION['sc_payment_postcode'] = $postcode_payment;
			$_SESSION['sc_payment_state'] = $state_payment;
			$_SESSION['sc_payment_country'] = $country_payment;
			
			if (ACCOUNT_STATE == 'true') {
				if ($zone_id > 0) {
				  $_SESSION['sc_payment_zone_id'] = $zone_id_payment;
				  $_SESSION['sc_payment_state'] = '';
				} else {
				  $_SESSION['sc_payment_zone_id'] = '0';
				  $_SESSION['sc_payment_state'] = $state_payment;
				}
			}
		}
				  

		if (SESSION_RECREATE == 'True') {
	    	vam_session_recreate();
		}	
		
		  
		############################# process the selected shipping method ######################################
		if (!vam_session_is_registered('comments')) vam_session_register('comments');
		if (vam_not_null($_POST['comments'])) {
		  //$comments = vam_db_prepare_input($_POST['comments']);
		}


		/// This we ne to process also for updating jquery shipping value
		if (!vam_session_is_registered('shipping')) vam_session_register('shipping');
		if (isset($_POST['shipping']) && vam_not_null($_POST['shipping'])){ //used THAT IT IS not 0 again
	
		if ( (vam_count_shipping_modules() > 1) || ($free_shipping == true) ) {
			//here is the selected shipping module defined
			$shipping = $_POST['shipping']; 
		

		
			list($module, $method) = explode('_', $shipping);
			if ( is_object($$module) || ($shipping == 'free_free') ) {
			  if ($shipping == 'free_free') {
				$quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
				$quote[0]['methods'][0]['cost'] = '0';
			  } else {
				$quote = $shipping_modules->quote($method, $module);
			  }
			  if (isset($quote['error'])) {
				vam_session_unregister('shipping');
			  } else {
				if ( (isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost'])) ) {
				  $shipping = array('id' => $shipping,
									'title' => (($free_shipping == true) ?  $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
									'cost' => $quote[0]['methods'][0]['cost']);
	
				  //vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
				}
			  }
			} else {
			  vam_session_unregister('shipping');
			}
		  }
		}	  
		############################# process the selected shipping method END ######################################
	
	
		############################# process the selected payment method ######################################
		if (isset($_POST['payment'])) $payment = $_POST['payment'];
		############################# process the selected payment method END ######################################
	
	
		
		//if everything is OK process the order
		$sc_payment_url = false;
		if (isset($$payment->form_action_url)) {
			if (SC_CONFIRMATION_PAGE == 'true') {
				$sc_payment_url = false;
				$form_action_url = vam_href_link(FILENAME_SC_CHECKOUT_CONFIRMATION, '', 'SSL');
				vam_redirect($form_action_url); //redirect to checkout_pocess.php
				//$order = new order;  //set new order for post data
			} else {
				//$form_action_url = $$payment->form_action_url;
				$sc_payment_url = true;
				$sc_payment_modules_process = false; //set to false in order not to load payment selection()
				$order = new order;  //set new order for post data
			}
		} else { //process for non-url payment modules
			if (SC_CONFIRMATION_PAGE == 'true') {
				//if confimation is true
				$form_action_url = vam_href_link(FILENAME_SC_CHECKOUT_CONFIRMATION, '', 'SSL');
			} else {
				$form_action_url = vam_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
			}
			vam_redirect($form_action_url); //redirect to checkout_pocess.php
		}
	
	}
}
///////////////////  END PROCESS Button pressed for NO ACCOUNT onepage and no confirmation page  ////////////////////////////////////////////



///////////////////  START PROCESS Button pressed for ACCOUNT CREATION - only onepage ////////////////////////////////////////////
if (isset($_POST['action']) && (($_POST['action'] == 'not_logged_on') && ($create_account == true)) && isset($_POST['formid']) && ($_POST['formid'] == $sessiontoken)) {
//if no errors
    if ($error == false) {
		
	  $dbPass = vam_encrypt_password($password);

      $sql_data_array = array('customers_firstname' => $firstname,
                              'customers_lastname' => $lastname,
                              'customers_email_address' => $email_address,
                              'customers_telephone' => $telephone,
                              'customers_fax' => $fax,
                              'customers_newsletter' => $newsletter,
                              'customers_password' => $dbPass);
                              

      if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;
      if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = vam_date_raw($dob);

      vam_db_perform(TABLE_CUSTOMERS, $sql_data_array);

      $customer_id = vam_db_insert_id();

      $sql_data_array = array('customers_id' => $customer_id,
                              'entry_firstname' => $firstname,
                              'entry_lastname' => $lastname,
                              'entry_street_address' => $street_address,
                              'entry_postcode' => $postcode,
                              'entry_city' => $city,
                              'entry_country_id' => $country);

      if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender;
      if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $company;
      if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $suburb;
      if (ACCOUNT_STATE == 'true') {
        if ($zone_id > 0) {
          $sql_data_array['entry_zone_id'] = $zone_id;
          $sql_data_array['entry_state'] = '';
        } else {
          $sql_data_array['entry_zone_id'] = '0';
          $sql_data_array['entry_state'] = $state;
        }
      }
	  

      vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

      $address_id = vam_db_insert_id();

      vam_db_query("update " . TABLE_CUSTOMERS . " set customers_default_address_id = '" . (int)$address_id . "' where customers_id = '" . (int)$customer_id . "'");

      vam_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$customer_id . "', '0', now())");

      if (SESSION_RECREATE == 'True') {
        vam_session_recreate();
      }

      $customer_first_name = $firstname;
      $customer_default_address_id = $address_id;
      $customer_country_id = $country;
      $customer_zone_id = $zone_id;
      vam_session_register('customer_id');  
      vam_session_register('customer_first_name');
      vam_session_register('customer_default_address_id');
      vam_session_register('customer_country_id');
      vam_session_register('customer_zone_id');
	  // Customers Data are stored into to DB table "customers" and "Adress_book"
############################# create_account End process #######################################

      if ($payment_address_selected != '1') { //is unchecked - so payment address is different or if virtual product
        $sql_data_array = array('customers_id' => $customer_id,
                                'entry_firstname' => $firstname_payment,
                                'entry_lastname' => $lastname_payment,
                                'entry_street_address' => $street_address_payment,
                                'entry_postcode' => $postcode_payment,
                                'entry_city' => $city_payment,
                                'entry_country_id' => $country_payment);

        if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender_payment;
        if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $company_payment;
        if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $suburb_payment;
        if (ACCOUNT_STATE == 'true') {
          if ($zone_id > 0) {
            $sql_data_array['entry_zone_id'] = $zone_id_payment;
            $sql_data_array['entry_state'] = '';
          } else {
            $sql_data_array['entry_zone_id'] = '0';
            $sql_data_array['entry_state'] = $state_payment;
          }
        }

        if (!vam_session_is_registered('billto')) vam_session_register('billto');

        vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

        $billto_payment = vam_db_insert_id();
      }
	
############################# end new payment address #######################################



############################# process the selected shipping method ######################################
    if (!vam_session_is_registered('comments')) vam_session_register('comments');
    if (vam_not_null($_POST['comments'])) {
      $comments = vam_db_prepare_input($_POST['comments']);
    }


/// This we ne to process also for updating jquery shipping value
if (!vam_session_is_registered('shipping')) vam_session_register('shipping');
if (isset($_POST['shipping']) && vam_not_null($_POST['shipping'])){ //used THAT IT IS not 0 again

    if ( (vam_count_shipping_modules() > 1) || ($free_shipping == true) ) {
		//here is the selected shipping module defined
		$shipping = $_POST['shipping']; 
		

		
        list($module, $method) = explode('_', $shipping);
        if ( is_object($$module) || ($shipping == 'free_free') ) {
          if ($shipping == 'free_free') {
            $quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
            $quote[0]['methods'][0]['cost'] = '0';
          } else {
            $quote = $shipping_modules->quote($method, $module);
          }
          if (isset($quote['error'])) {
            vam_session_unregister('shipping');
          } else {
            if ( (isset($quote[0]['methods'][0]['title'])) && (isset($quote[0]['methods'][0]['cost'])) ) {
              $shipping = array('id' => $shipping,
                                'title' => (($free_shipping == true) ?  $quote[0]['methods'][0]['title'] : $quote[0]['module'] . ' (' . $quote[0]['methods'][0]['title'] . ')'),
                                'cost' => $quote[0]['methods'][0]['cost']);

              //vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
            }
          }
        } else {
          vam_session_unregister('shipping');
        }
    }
  }	  
############################# process the selected shipping method END ######################################


############################# process the selected payment method ######################################
if (isset($_POST['payment'])) $payment = $_POST['payment'];
############################# process the selected payment method END ######################################

// set them here after $customer_default_address_id is created (ca. line 491)
$sendto = $customer_default_address_id;



//if unchecked checkbox "Billing address is the same as shipping address" we need to change $billto


if ($payment_address_selected == '1') { //is selected - payment address is same as shipping address
	$billto = $customer_default_address_id; 
} else { //not selected - so a new address is being created
	$billto = $billto_payment; 
}



	
//if everything is OK process the order
$sc_payment_url = false;
if (isset($$payment->form_action_url)) {
	if (SC_CONFIRMATION_PAGE == 'true') {
		$sc_payment_url = false;
		$form_action_url = vam_href_link(FILENAME_SC_CHECKOUT_CONFIRMATION, '', 'SSL');
		vam_redirect($form_action_url); //redirect to checkout_pocess.php
		//$order = new order;  //set new order for post data
	} else {
		//START send create account mail
		//if ($create_account == true) {
			  $name = $firstname . ' ' . $lastname;
		
			  if (ACCOUNT_GENDER == 'true') {
				 if ($gender == 'm') {
				   $email_text = sprintf(EMAIL_GREET_MR, $lastname);
				 } else {
				   $email_text = sprintf(EMAIL_GREET_MS, $lastname);
				 }
			  } else {
				$email_text = sprintf(EMAIL_GREET_NONE, $firstname);
			  }
			  
			  if (SC_EMAIL_LOGIN_DATA == 'true') {
				  $email_text .= EMAIL_WELCOME . EMAIL_USERNAME . EMAIL_PASSWORD . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_WARNING;
			  } else {
			  	  $email_text .= EMAIL_WELCOME . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_WARNING;
			  }
			  
			  vam_mail($name, $email_address, EMAIL_SUBJECT, $email_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
			  
		
		//} //END send create account mail
		
		$sc_payment_url = true;
		$sc_payment_modules_process = false; //set to false in order not to load payment selection()
		$order = new order;  //set new order for post data
	}
} else { //process for non-url payment modules
	
	
	if (SC_CONFIRMATION_PAGE == 'true') {
		//if confimation is true
		$form_action_url = vam_href_link(FILENAME_SC_CHECKOUT_CONFIRMATION, '', 'SSL');
	} else {
		//START send create account mail
		//if ($create_account == true) {
			  $name = $firstname . ' ' . $lastname;
		
			  if (ACCOUNT_GENDER == 'true') {
				 if ($gender == 'm') {
				   $email_text = sprintf(EMAIL_GREET_MR, $lastname);
				 } else {
				   $email_text = sprintf(EMAIL_GREET_MS, $lastname);
				 }
			  } else {
				$email_text = sprintf(EMAIL_GREET_NONE, $firstname);
			  }
		
			  if (SC_EMAIL_LOGIN_DATA == 'true') {
				  $email_text .= EMAIL_WELCOME . EMAIL_USERNAME . EMAIL_PASSWORD . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_WARNING;
			  } else {
			  	  $email_text .= EMAIL_WELCOME . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_WARNING;
			  }
			  
			  vam_mail($name, $email_address, EMAIL_SUBJECT, $email_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
		
		//} //END send create account mail
		
		$form_action_url = vam_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
		
	}
	vam_redirect($form_action_url); //redirect to checkout_pocess.php
}
  
  
  


//reset session token
//$sessiontoken = md5(vam_rand() . vam_rand() . vam_rand() . vam_rand());

// restore cart contents
//$_SESSION['cart']->restore_contents();
    }
  }
/////////////////// END PROCESS Button pressed for ACCOUNT CREATION - only onepage ////////////////////////////////////////////


/////////////////// START PROCESS Button pressed for LOGGED ON ////////////////////////////////////////////
if (isset($_POST['action']) && ($_POST['action'] == 'logged_on') && isset($_POST['formid']) && ($_POST['formid'] == $sessiontoken)) {

	if ($error == false) {
	
	
	############################# process the selected payment method ######################################
	if (isset($_POST['payment'])) $payment = $_POST['payment'];
	############################# process the selected payment method END ######################################
	
	
	
	//just to be sure - we are a logged in user so don't delete customer account
	if (vam_session_is_registered('noaccount')){ vam_session_unregister('noaccount');}
	
	
	
	
	//if everything is OK process the order
	$sc_payment_url = false;
	if (isset($$payment->form_action_url)) {
		if (SC_CONFIRMATION_PAGE == 'true') {
			$form_action_url = vam_href_link(FILENAME_SC_CHECKOUT_CONFIRMATION, '', 'SSL');
			vam_redirect($form_action_url); //redirect to checkout_pocess.php
		} else {
			//$form_action_url = $$payment->form_action_url;
			$sc_payment_url = true;
			$sc_payment_modules_process = false; //set to false in order not to load payment selection()
			$order = new order;  //set new order for post data
		}
	  } else { //non-url payment modules
	  	if (SC_CONFIRMATION_PAGE == 'true') {
			$form_action_url = vam_href_link(FILENAME_SC_CHECKOUT_CONFIRMATION, '', 'SSL');
		} else {
			$form_action_url = vam_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
		}
		vam_redirect($form_action_url); //redirect to checkout_pocess.php
	  }

	} //error end
}
/////////////////// END PROCESS Button pressed for LOGGED ON ////////////////////////////////////////////


// get all available shipping quotes
  $quotes = $shipping_modules->quote();


// if no shipping method has been selected, automatically select the cheapest method.
// if the modules status was changed when none were available, to save on implementing
// a javascript force-selection method, also automatically select the cheapest shipping
// method if more than one module is now enabled

// don't use this as it will not get the toal correct the first time
 // if ( !vam_session_is_registered('shipping') || ( vam_session_is_registered('shipping') && ($shipping == false) && (vam_count_shipping_modules() > 1) ) ) $shipping = $shipping_modules->cheapest();
 



###################### payment url redirection START ###################################
//if payment method such as paypal is choosen,  repost process_button data
  if ((isset($$payment->form_action_url)) && ($sc_payment_url == true)) {
		
    $form_action_url = $$payment->form_action_url;
	echo vam_draw_form('checkoutUrl', $form_action_url, 'post');
  } 
  
  
    
  if (is_array($payment_modules->modules)) {
	$payment_modules->pre_confirmation_check();
  }
  
  
  if (is_array($payment_modules->modules)) {
  echo $payment_modules->process_button();
  }
?>

<?php
//////////  START  redirection page for payment modules such as paypal if no confirmation page ////////////
if ((isset($$payment->form_action_url)) && ($sc_payment_url == true)) { 

require(DIR_WS_INCLUDES . 'header.php');

if (is_array($payment_modules->modules)) {
    if ($confirmation = $payment_modules->confirmation()) {
	
?>

  <h2><?php echo HEADING_PAYMENT_INFORMATION; ?></h2>

  <div class="contentText">
    <table border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td colspan="4"><?php 
		
		
		echo $confirmation['title']; ?></td>
      </tr>

<?php
      for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++) {
	  
?>

      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main"><?php echo $confirmation['fields'][$i]['title']; ?></td>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main"><?php echo $confirmation['fields'][$i]['field']; ?></td>
      </tr>

<?php
      }
?>

    </table>
  </div>

<?php
    }
  }
 
?>

<p><?php echo SC_TEXT_REDIRECT; ?></p>



</form>
<?php 
require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
<script type="text/javascript">
    document.checkoutUrl.submit();
</script>
<noscript><input type="submit" value="verify submit"></noscript>

   
<?php 
}
//////////  END  redirection page for payment modules such as paypal if no confirmation page ////////////


  $breadcrumb->add(NAVBAR_TITLE_1, vam_href_link(FILENAME_CHECKOUT, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2, vam_href_link(FILENAME_CHECKOUT, '', 'SSL'));

require(DIR_WS_INCLUDES . 'header.php');

  require('includes/form_check.js.php');  
  
?>

<?php
// if the customer is logged on - show this javascript
if (isset ($_SESSION['customer_id'])) { ?>
<script type="text/javascript">

$(init);
function init()
	{

var url='checkout.php';          

	
$('#box')

.on('refresh', '#shipping_modules_box', function(){$('#order_total_modules').load(url +' #order_total_modules > *', {'shipping': $('input[name=shipping]:checked').val()});})	



.on('change', 'input[name=shipping]', function(){$('#shipping_options').load(url +' #shipping_options > *', {'shipping': $('input[name=shipping]:checked').val()}, function(){$('#shipping_modules_box').trigger('refresh');});})

;}
</script>  
   
<?php } else { //not logged in javascript ?>



<script type="text/javascript">

//not yet finished
/*$(hideFirm);		
	function hideFirm()	{
		
		//Hide div w/id extra
	$("#extra").css("display","none");
	$("#checkme1").click(function(){

// If checked
        
        if ($("#checkme1").is(":checked"))
		{
            //show the hidden div
            $("#extra").show("fast");
        }
	});
	

		// Add onclick handler to checkbox w/id checkme
	   $("#checkme").click(function(){

// If checked
        if ($("#checkme").is(":checked"))
        {
            //show the hidden div
            $("#extra").hide("fast");
        }
		        
	});
	
	$("#checkme2").click(function(){

// If checked
        if ($("#checkme2").is(":checked"))
        {
            //show the hidden div
            $("#extra").hide("fast");
        }
		        
	});
;}*/






/*$(document).ready(function(){
window.alert($('input[name=checkout_possible]').val());

//$('#order_total_modules').load(url +' #order_total_modules > *', {'shipping': $('input[name=shipping]:checked').val() });

});*/







$(hidePay);		
	function hidePay()	{
	if ($("#pay_show").is(":checked") == '1')
		{
	$("#pay_show").attr('checked', true);
	$("#payment_address").css("display","none");
	}
	else
	{
	$("#pay_show").attr('checked', false);
	}
	

	$("#pay_show").click(function(){
// If checked
        if ($("#pay_show").is(":checked"))
		{
            //show the hidden div
            $("#payment_address").hide("fast");
        }
		else
		{
		$("#payment_address").show("fast");
		}
	});
	;}


$(init);
function init()
	{

var url='checkout.php';          

	
$('#box')
.on('refresh', '#shipping_modules_box', function(){$('#shipping_options').load(url +' #shipping_options > *', {'country': $('select[name=country]').val()});})	
.on('refresh', '#shipping_modules_box', function(){$('#payment_options').load(url +' #payment_options > *', {'country': $('select[name=country]').val()});})	
.on('refresh', '#shipping_modules_box', function(){$('#order_total_modules').load(url +' #order_total_modules > *', {'shipping': $('input[name=shipping]:checked').val()});})	


//.on('refresh', '#shipping_modules_box', function(('input[name=checkout_possible]').val());})	
//.on$('input[name=checkout_possible]').val()

.on('change', 'input[name=shipping], select[name=country]', function(){$('#shipping_country_box').load(url +' #shipping_country', {'shipping': $('input[name=shipping]:checked').val(), 'country': $('select[name=country]').val()}, function(){$('#shipping_modules_box').trigger('refresh');});})
;}
</script>


<?php if ((SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true') && (($sc_is_virtual_product != true) || ($sc_is_mixed_product != true))) { ?>  
<script type="text/javascript">
$(hidePw);		
	function hidePw()	{
	if ($("#pw_show").is(":checked") == '1')
		{
	$("#pw_show").attr('checked', true);
	$("#password_fields").css("display","none");
	}
	else
	{
	$("#pw_show").attr('checked', false);
	}
	

	$("#pw_show").click(function(){
// If checked
        if ($("#pw_show").is(":checked"))
		{
            //show the hidden div
            $("#password_fields").hide("fast");
        }
		else
		{
		$("#password_fields").show("fast");
		}
	});
	;}
</script>    
<?php 
	} // END password optional
} //END not logged in javascript ?>

<script type="text/javascript"><!--
var selected;

function selectRowEffect(object, buttonSelect) {
  if (!selected) {
    if (document.getElementById) {
      selected = document.getElementById('defaultSelected');
    } else {
      selected = document.all['defaultSelected'];
    }
  }

  if (selected) selected.className = 'moduleRow';
  object.className = 'moduleRowSelected';
  selected = object;

// one button is not an array
  if (document.checkout_payment.payment[0]) {
    document.checkout_payment.payment[buttonSelect].checked=true;
  } else {
    document.checkout_payment.payment.checked=true;
  }
}

function rowOverEffect(object) {
  if (object.className == 'moduleRow') object.className = 'moduleRowOver';
}

function rowOutEffect(object) {
  if (object.className == 'moduleRowOver') object.className = 'moduleRow';
}
//--></script>
<?php echo $payment_modules->javascript_validation(); ?>


<h1><?php echo HEADING_TITLE; ?></h1>

<?php
//show progress bar only if confirmation page is true
if (SC_CONFIRMATION_PAGE == 'true') { ?>
<div class="top_space">
    <ul id="myProgressBar">
        <li class="current">1. <?php echo SC_PROGRESS_CHECKOUT_PAGE; ?></li>
        <li>2. <?php echo SC_PROGRESS_CONFIRMATION_PAGE; ?></li>
    </ul>
</div><!-- dive end myProgressBar -->
<?php } ?>


<div id="box">
<div id="checkout">
            

<?php
  if ($messageStack->size('smart_checkout') > 0) {
    echo $messageStack->output('smart_checkout');
  }
?>


<p><?php echo sprintf(TEXT_ORIGIN_LOGIN, vam_href_link(FILENAME_LOGIN, vam_get_all_get_params(), 'SSL')); ?></p>


<?php 
//Draw form for pressing button "confirm order"
//first check input fields and check for payment choosen
$form_action_url = vam_href_link(FILENAME_CHECKOUT, '', 'SSL');
echo vam_draw_form('smart_checkout', $form_action_url, 'post', 'onsubmit="return check_form(smart_checkout);"', true);
 
 
// draw process hidden field
if (isset ($_SESSION['customer_id'])) {  //logged on - process another action = 'logged_on'
	echo vam_draw_hidden_field('action', 'logged_on');
} else { //is not logged on - process another action = 'process'
	//not logged on
	echo vam_draw_hidden_field('action', 'not_logged_on');
}

echo vam_draw_hidden_field('shipping_count', $shipping_count); //need to post it for validation
echo vam_draw_hidden_field('sc_payment_address_show', $sc_payment_address_show); //need to post it for validation
echo vam_draw_hidden_field('sc_payment_modules_show', $sc_payment_modules_show); //need to post it for validation
echo vam_draw_hidden_field('create_account', $create_account); //need to post it for validation
echo vam_draw_hidden_field('sc_shipping_modules_show', $sc_shipping_modules_show); //need to post it for validation
echo vam_draw_hidden_field('sc_shipping_address_show', $sc_shipping_address_show); //need to post it for validation
echo vam_draw_hidden_field('checkout_possible', $checkout_possible); //need to post it for validation
?>

   

  <div class="contentText">
    <span class="inputRequirement" style="float: right;"><?php echo FORM_REQUIRED_INFORMATION; ?></span>
  </div>


<?php if ($sc_shipping_address_show == true) { //show shipping otpions ?>
<div id="shipping_box" class="sm_layout_box">


<h2><?php if (($sc_is_virtual_product == true) && ($sc_is_free_virtual_product == false)) { 
echo vam_get_sc_titles_number() . TABLE_HEADING_BILLING_ADDRESS; 
} elseif (($sc_is_virtual_product == true) && ($sc_is_free_virtual_product == true)) {
echo vam_get_sc_titles_number(). SC_HEADING_CREATE_ACCOUNT_INFORMATION; 
} else {
echo vam_get_sc_titles_number() . TABLE_HEADING_SHIPPING_ADDRESS; 
} ?></h2> 


<?php ################ START Shipping Information - LOGGED ON ######################################## ?>
<?php if (isset ($_SESSION['customer_id'])) { ?>
    	<div>
          <p><?php echo vam_address_label($customer_id, $sendto, true, ' ', '<br />'); ?></p>
          <p><?php echo '<a class="button" href="' . vam_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL') . '">' . vam_image_button('edit.png', IMAGE_BUTTON_CHANGE_ADDRESS) . '</a>'; ?></p>
        </div>
<?php } else { //no account ?>
<?php ################ END Shipping Information - LOGGED ON ######################################## ?> 


<?php ################ START Shipping Information - NO ACCOUNT ######################################## ?>  
	
    <table border="0" cellspacing="2" cellpadding="2" width="100%">

<?php
  if (ACCOUNT_GENDER == 'true') {
?>

      <tr>
        <td class="fieldKey"><?php echo ENTRY_GENDER; ?></td>
        <td class="fieldValue">
		<?php 
		//not yet finished
		 //echo vam_draw_radio_field('gender', 'm', '', 'id="checkme"') . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . vam_draw_radio_field('gender', 'f', '', 'id="checkme2"') . '&nbsp;&nbsp;' . FEMALE . '&nbsp;&nbsp;'. vam_draw_radio_field('gender', 'a', '', 'id="checkme1"') . '&nbsp;&nbsp;' . FIRMA . '&nbsp;' . (vam_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); 
        
		echo vam_draw_radio_field('gender', 'm') . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . vam_draw_radio_field('gender', 'f') . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . (vam_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); ?></td>
      </tr>
</table>
<?php
  }
?>



<?php
  if (ACCOUNT_COMPANY == 'true') {
?>
<div id="extra">
     <table border="0" cellspacing="2" cellpadding="2" width="100%">
      <tr>
        <td class="fieldKey"><?php echo ENTRY_COMPANY; ?></td>
        <td class="fieldValue"><?php echo vam_draw_input_field('company', $sc_guest_company, 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?></td>
      </tr>
    </table>
</div>  

<?php
  }
?>
 <table border="0" cellspacing="2" cellpadding="2" width="100%">
      <tr>
        <td class="fieldKey"><?php echo ENTRY_FIRST_NAME; ?></td>
        <td class="fieldValue">
		<?php if (SC_LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_draw_input_field('firstname', $sc_guest_firstname, 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_draw_input_field('firstname', $sc_guest_firstname, 'class="text" id="ent_first_name"') . '&nbsp;' . (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?>
        <script type="text/javascript">
		  var ent_first_name = new LiveValidation('ent_first_name');
		  ent_first_name.add(Validate.Length, { minimum: 4 } );
		</script>
		<?php } ?>
        
        </td>
      </tr>
      <tr> 
        <td class="fieldKey"><?php echo ENTRY_LAST_NAME; ?></td>
        <td class="fieldValue">
		<?php if (SC_LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_draw_input_field('lastname', $sc_guest_lastname, 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_draw_input_field('lastname', $sc_guest_lastname, 'class="text" id="ent_last_name"') . '&nbsp;' . (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?>
        <script type="text/javascript">
		  var ent_last_name = new LiveValidation('ent_last_name');
		  ent_last_name.add(Validate.Length, { minimum: 4 } );
		</script>
        <?php } ?>
        </td>
      </tr>

<?php
  if (ACCOUNT_DOB == 'true') {
?>

      <tr>
        <td class="fieldKey"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
        <td class="fieldValue"><?php echo vam_draw_input_field('dob', $sc_guest_dob, 'class="text" id="dob"') . '&nbsp;' . (vam_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="inputRequirement">' . ENTRY_DATE_OF_BIRTH_TEXT . '</span>': ''); ?><script type="text/javascript">$('#dob').datepicker({dateFormat: '<?php echo JQUERY_DATEPICKER_FORMAT; ?>', changeMonth: true, changeYear: true, yearRange: '-100:+0'});</script></td>
      </tr>

<?php
  }
?>

      
    </table>
 





 <div id="shipping_address">
    <table border="0" cellspacing="2" cellpadding="2" width="100%">
      <tr>
        <td class="fieldKey"><?php echo ENTRY_STREET_ADDRESS; ?></td>
        <td class="fieldValue">
		<?php if (SC_LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_draw_input_field('street_address', $sc_guest_street_address, 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_draw_input_field('street_address', $sc_guest_street_address, 'class="text" id="ent_street_address"') . '&nbsp;' . (vam_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?>
        <script type="text/javascript">
		    var ent_street_address = new LiveValidation('ent_street_address');
		    ent_street_address.add(Validate.Length, { minimum: 4 } );
		</script>
		<?php } ?>
        </td>
      </tr>

<?php
  if (ACCOUNT_SUBURB == 'true') {
?>

      <tr>
        <td class="fieldKey"><?php echo ENTRY_SUBURB; ?></td>
        <td class="fieldValue"><?php echo vam_draw_input_field('suburb', $sc_guest_suburb, 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?></td>
      </tr>

<?php
  }
?>

      <tr>
        <td class="fieldKey"><?php echo ENTRY_POST_CODE; ?></td>
        <td class="fieldValue">
		<?php if (SC_LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_draw_input_field('postcode', $sc_guest_postcode, 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_draw_input_field('postcode', $sc_guest_postcode, 'class="text" id="ent_postcode"') . '&nbsp;' . (vam_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?>
        <script type="text/javascript">
		    var ent_postcode = new LiveValidation('ent_postcode');
		    ent_postcode.add(Validate.Length, { minimum: 4 } );
		</script>
		<?php } ?>
            
        </td>
      </tr>
      <tr>
        <td class="fieldKey"><?php echo ENTRY_CITY; ?></td>
        <td class="fieldValue">
		<?php if (SC_LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_draw_input_field('city', $sc_guest_city, 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_draw_input_field('city', $sc_guest_city, 'class="text" id="ent_city"') . '&nbsp;' . (vam_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?>
        <script type="text/javascript">
		    var ent_city = new LiveValidation('ent_city');
		    ent_city.add(Validate.Length, { minimum: 4 } );
		</script>
		<?php } ?>
        </td>
      </tr>
</table>
<?php
  if (ACCOUNT_STATE == 'true') {
?>
<table border="0" cellspacing="2" cellpadding="2" width="100%">
      <tr>
        <td class="fieldKey"><?php echo ENTRY_STATE; ?></td>
        <td class="fieldValue">
<?php
    if ($process == true) {
      if ($entry_state_has_zones == true) {
        $zones_array = array();
        $zones_query = vam_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' order by zone_name");
        while ($zones_values = vam_db_fetch_array($zones_query)) {
          $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
        }
        echo vam_draw_pull_down_menu('state', $zones_array, '', 'class="text"');
      } else {
        echo vam_draw_input_field('state', '', 'class="text"');
      }
    } else {
      echo vam_draw_input_field('state', '', 'class="text"');
    }

    if (vam_not_null(ENTRY_STATE_TEXT)) echo '&nbsp;<span class="inputRequirement">' . ENTRY_STATE_TEXT . '</span>';
?>
        </td>
      </tr>
</table>
<?php
  }
?>
<div id="shipping_country_box">
<div id="shipping_country">

<table border="0" cellspacing="2" cellpadding="2" width="100%">
	<tr>
        <td class="fieldKey"><?php echo ENTRY_COUNTRY; ?></td>
        <td class="fieldValue">
		<?php if (SC_LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_get_country_list('country', $selected_country_id, 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_get_country_list('country', $selected_country_id, 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?>
        <?php //echo vam_get_country_list('country', '', 'class="text" id="ent_country"') . '&nbsp;' . (vam_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?>
        <!--<script type="text/javascript">
		    var ent_country = new LiveValidation('ent_country');
		    ent_country.add( Validate.Acceptance );
		</script>-->
		<?php } ?>
        </td>
      </tr>
      
      
      
    </table>
  </div><!--div end shipping_country -->
  </div><!--div end shipping_country_box -->
</div> <!--div end shipping_address -->
<?php } //end no account ?>
<?php ################ END Shipping Information - NO ACCOUNT ######################################## ?> 

</div> <!--div end shipping_box --> 
<?php } //END show shipping otpions ?> 
 
  
 
 
 
 
<?php if ($sc_payment_address_show == true) { // hide payment if there is a virtual product because we use shipping address for payment address ?>
<div id="payment_address_box"  class="sm_layout_box">
 <h2><?php echo vam_get_sc_titles_number() . TABLE_HEADING_BILLING_ADDRESS; ?></h2>
<?php ################ START Payment Information - LOGGED ON ######################################## ?>
<?php if (isset ($_SESSION['customer_id'])) { ?>
    	<div>
           <p><?php echo vam_address_label($customer_id, $billto, true, ' ', '<br />'); ?></p>
           <p><?php echo '<a class="button" href="' . vam_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL') . '">' . vam_image_button('edit.png', IMAGE_BUTTON_CHANGE_ADDRESS) . '</a>'; ?></p>
        </div>
<?php } else { //no account ?>
<?php ################ END Payment Information - LOGGED ON ######################################## ?> 


<?php ################ START Payment Information - NO ACCOUNT ######################################## ?> 

 <div id="payment_address_checkbox">
 <table border="0" cellspacing="2" cellpadding="2" width="100%">
 <tr>
        
   <?php if (($error == '1') && ($payment_address_selected != '1')) { //is not selected - otherwise payment address is same as shipping address ?>
        
        <td><?php echo vam_draw_checkbox_field('payment_adress', '1', false, 'id="pay_show"') . '&nbsp;' . (vam_not_null(ENTRY_NEWSLETTER_TEXT) ? '<span class="inputRequirement">' . ENTRY_NEWSLETTER_TEXT . '</span>': ''). '&nbsp;&nbsp;' . TEXT_SHIPPING_SAME_AS_PAYMENT; ?></td>
        
        <?php } else { //is selected ?>
        
        <td><?php echo vam_draw_checkbox_field('payment_adress', '1', true, 'id="pay_show"') . '&nbsp;' . (vam_not_null(ENTRY_NEWSLETTER_TEXT) ? '<span class="inputRequirement">' . ENTRY_NEWSLETTER_TEXT . '</span>': ''). '&nbsp;&nbsp;' . TEXT_SHIPPING_SAME_AS_PAYMENT; ?></td>
        
        <?php } ?>
        
      </tr>
      </table>
</div>



<div id="payment_address">

<table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
  if (ACCOUNT_GENDER == 'true') {
    if (isset($gender)) {
      $male = ($gender == 'm') ? true : false;
      $female = ($gender == 'f') ? true : false;
    } else {
      $male = false;
      $female = false;
    }
?>



    <tr>
      <td class="fieldKey"><?php echo ENTRY_GENDER; ?></td>
      <td class="fieldValue">
	  
	  <?php echo vam_draw_radio_field('gender_payment', 'm', $male) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . vam_draw_radio_field('gender_payment', 'f', $female) . '&nbsp;&nbsp;' . FEMALE . '&nbsp;' . (vam_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">' . ENTRY_GENDER_TEXT . '</span>': ''); ?>
      
      </td>
    </tr>

<?php
  }
?>

<?php
  if (ACCOUNT_COMPANY == 'true') {
?>

    <tr>
      <td class="fieldKey"><?php echo ENTRY_COMPANY; ?></td>
      <td class="fieldValue"><?php echo vam_draw_input_field('company_payment', '',  'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': ''); ?></td>
    </tr>

<?php
  }
?>

      
    <tr>
      <td class="fieldKey"><?php echo ENTRY_FIRST_NAME; ?></td>
      <td class="fieldValue">
	  <?php if (SC_LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_draw_input_field('firstname_payment', '', 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_draw_input_field('firstname_payment', '', 'class="text" id="pay_first_name"') . '&nbsp;' . (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': ''); ?>
        <script type="text/javascript">
		  var ent_first_name = new LiveValidation('pay_first_name');
		  ent_first_name.add(Validate.Length, { minimum: 4 } );
		</script>
		<?php } ?>
	  </td>
    </tr>
    <tr>
      <td class="fieldKey"><?php echo ENTRY_LAST_NAME; ?></td>
      <td class="fieldValue">
	  <?php if (SC_LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_draw_input_field('lastname_payment', '', 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_draw_input_field('lastname_payment', '', 'class="text" id="pay_last_name"') . '&nbsp;' . (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': ''); ?>
        <script type="text/javascript">
		  var ent_last_name = new LiveValidation('pay_last_name');
		  ent_last_name.add(Validate.Length, { minimum: 4 } );
		</script>
        <?php } ?>
		</td>
    </tr>


    <tr>
      <td class="fieldKey"><?php echo ENTRY_STREET_ADDRESS; ?></td>
      <td class="fieldValue"><?php if (SC_LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_draw_input_field('street_address_payment', '', 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_draw_input_field('street_address_payment', '', 'class="text" id="pay_street_address"') . '&nbsp;' . (vam_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': ''); ?>
        <script type="text/javascript">
		    var ent_street_address = new LiveValidation('pay_street_address');
		    ent_street_address.add(Validate.Length, { minimum: 4 } );
		</script>
		<?php } ?>
		</td>
    </tr>

<?php
  if (ACCOUNT_SUBURB == 'true') {
?>

    <tr>
      <td class="fieldKey"><?php echo ENTRY_SUBURB; ?></td>
      <td class="fieldValue"><?php echo vam_draw_input_field('suburb_payment', '', 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': ''); ?></td>
    </tr>

<?php
  }
?>

    <tr>
      <td class="fieldKey"><?php echo ENTRY_POST_CODE; ?></td>
      <td class="fieldValue">
	  <?php if (SC_LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_draw_input_field('postcode_payment', '', 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_draw_input_field('postcode_payment', '', 'class="text" id="pay_postcode"') . '&nbsp;' . (vam_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': ''); ?>
        <script type="text/javascript">
		    var ent_postcode = new LiveValidation('pay_postcode');
		    ent_postcode.add(Validate.Length, { minimum: 4 } );
		</script>
		<?php } ?>
		</td>
    </tr>
    <tr>
      <td class="fieldKey"><?php echo ENTRY_CITY; ?></td>
      <td class="fieldValue">
	  <?php if (SC_LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_draw_input_field('city_payment', '', 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_draw_input_field('city_payment', '', 'class="text" id="pay_city"') . '&nbsp;' . (vam_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': ''); ?>
        <script type="text/javascript">
		    var ent_city = new LiveValidation('pay_city');
		    ent_city.add(Validate.Length, { minimum: 4 } );
		</script>
		<?php } ?>
	</td>
    </tr>

<?php
  if (ACCOUNT_STATE == 'true') {
?>

    <tr>
      <td class="fieldKey"><?php echo ENTRY_STATE; ?></td>
      <td class="fieldValue">

<?php
    if ($process == true) {
      if ($entry_state_has_zones == true) {
        $zones_array = array();
        $zones_query = vam_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' order by zone_name");
        while ($zones_values = vam_db_fetch_array($zones_query)) {
          $zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
        }
        echo vam_draw_pull_down_menu('state_payment', $zones_array, '', 'class="text"');
      } else {
        echo vam_draw_input_field('state_payment', '', 'class="text"');
      }
    } else {
      echo vam_draw_input_field('state_payment', '', 'class="text"');
    }

    if (vam_not_null(ENTRY_STATE_TEXT)) echo '&nbsp;<span class="inputRequirement">' . ENTRY_STATE_TEXT . '</span>';
?>

      </td>
    </tr>

<?php
  }
?>

    <tr>
      <td class="fieldKey"><?php echo ENTRY_COUNTRY; ?></td>
      <td class="fieldValue"><?php echo vam_get_country_list('country_payment', '', 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
    </tr>
  </table>

 </div><!--div end payment_address-->
<?php } //end no account ?> 
</div><!--div end payment_address_box-->
<?php } //END hide payment if there is a virtual product because we use shipping address for payment address ?>
<?php ################ END Payment Information - NO ACCOUNT ######################################## ?> 




<?php if (!isset ($_SESSION['customer_id'])) { //IS NOT LOGGED ON ?>
<?php ################ START Contact Information - NO ACCOUNT ######################################## ?> 
<div id="contact_box" class="sm_layout_box">

  <h2><?php echo vam_get_sc_titles_number() . CATEGORY_CONTACT; ?></h2>

  
    <table border="0" cellspacing="2" cellpadding="2" width="100%">
    <tr>
        <td class="fieldKey"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
        <td class="fieldValue">
		<?php if (SC_LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_draw_input_field('email_address', $sc_guest_email_address, 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_draw_input_field('email_address', $sc_guest_email_address, 'class="text" id="ent_email_address"') . '&nbsp;' . (vam_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_EMAIL_ADDRESS_TEXT . '</span>': ''); ?>
        <script type="text/javascript">
		  var ent_email_address = new LiveValidation('ent_email_address');
		  ent_email_address.add(Validate.Email );
		</script>
        <?php } ?>
        </td>
      </tr>
      
      <tr>
        <td class="fieldKey"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
        <td class="fieldValue">
		<?php if (SC_LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_draw_input_field('telephone', $sc_guest_telephone, 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_draw_input_field('telephone', $sc_guest_telephone, 'class="text" id="ent_telephone"') . '&nbsp;' . (vam_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_TELEPHONE_NUMBER_TEXT . '</span>': ''); ?>
        <script type="text/javascript">
		    var ent_telephone = new LiveValidation('ent_telephone');
		    ent_telephone.add(Validate.Length, { minimum: 4 } );
		</script>
		<?php } ?>
        </td>
      </tr>
      <tr>
        <td class="fieldKey"><?php echo ENTRY_FAX_NUMBER; ?></td>
        <td class="fieldValue"><?php echo vam_draw_input_field('fax', $sc_guest_fax, 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="inputRequirement">' . ENTRY_FAX_NUMBER_TEXT . '</span>': ''); ?></td>
      </tr>
      

      
 
     <tr>
       <td><?php echo vam_draw_hidden_field('guest', 'guest'); //do we need this??? ?></td>
     </tr>
  </table>
</div> <!--div end contact_box -->    
<?php ################ END Contact Information - NO ACCOUNT ######################################## ?>   
<?php } //End IS NOT LOGGED ON ?>


<div class="line_space"></div>  


 



<?php ################ START Password - NO ACCOUNT ######################################## ?>
<?php
//if ($create_account == true) { 
 if (!isset ($_SESSION['customer_id'])) { //IS NOT LOGGED ON 
  if (($sc_is_virtual_product == true) || ($sc_is_mixed_product == true) || (SC_CREATE_ACCOUNT_REQUIRED == 'true') || (SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true')) { ?>
<div id="password_box" class="sm_layout_box">

<h2><?php echo vam_get_sc_titles_number() . SC_HEADING_CREATE_ACCOUNT; ?></h2>

<?php 
if (SC_CREATE_ACCOUNT_REQUIRED == 'true') {
	echo '<p>' . SC_TEXT_PASSWORD_REQUIRED . '</p>'; //show message that you need to create an account
} elseif (($sc_is_virtual_product == true) || ($sc_is_mixed_product == true)) {
	echo '<p>' . SC_TEXT_VIRTUAL_PRODUCT . '</p>';  //show message that you need to create an account if virtual product
}
?>

<?php ################ START Password - optional ######################################## 
if (SC_CREATE_ACCOUNT_REQUIRED == 'true') {
	//show nothing
//} elseif ((SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true') && (($sc_is_virtual_product != true) || ($sc_is_mixed_product != true))) {
} elseif (SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true') {
	if (($sc_is_virtual_product == true) || ($sc_is_mixed_product == true)) {
	} else { ?>   
<div id="password_checkbox">
 <table border="0" cellspacing="2" cellpadding="2" width="100%">
 <tr>
        
   <?php if (($error == '1') && ($password_selected != '1')) { //is not selected ?>
        
        <td><?php echo vam_draw_checkbox_field('password_checkbox', '1', false, 'id="pw_show"') . '&nbsp;&nbsp;' . TEXT_CREATE_ACCOUNT_OPTIONAL; ?></td>
        
        <?php } else { //is selected ?>
        
        <td><?php echo vam_draw_checkbox_field('password_checkbox', '1', true, 'id="pw_show"') . '&nbsp;&nbsp;' . TEXT_CREATE_ACCOUNT_OPTIONAL; ?></td>
        
        <?php } ?>
        
     </tr>
  </table>
</div>    
<?php }
} ################ End Password - optional ######################################## ?>


<div id="password_fields">
    <table border="0" cellspacing="2" cellpadding="2" width="100%">
      <tr>
        <td class="fieldKey"><?php echo ENTRY_PASSWORD; ?></td>
        <td class="fieldValue">
		<?php if (LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_draw_password_field('password', '', 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_draw_password_field('password', '', 'class="text" id="ent_password"') . '&nbsp;' . (vam_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_TEXT . '</span>': ''); ?>
        <?php } ?>        
        </td>
      </tr>
      <tr>
        <td class="fieldKey"><?php echo ENTRY_PASSWORD_CONFIRMATION; ?></td>
        <td class="fieldValue">
		<?php if (LIVE_VALIDATION == 'false') { ?>
		<?php echo vam_draw_password_field('confirmation', '', 'class="text"') . '&nbsp;' . (vam_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>': ''); ?>
        <?php } else { ?>
        <?php echo vam_draw_password_field('confirmation', '', 'class="text" id="ent_confirmation"') . '&nbsp;' . (vam_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="inputRequirement">' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '</span>': ''); ?>
        <script type="text/javascript">
		    var ent_confirmation = new LiveValidation('ent_confirmation');
		    ent_confirmation.add( Validate.Confirmation, { match: 'ent_password' } );
		</script>
        <?php } ?>
        </td>
      </tr>
   </table>
   </div> <!--div end password_fields --> 
</div> <!--div end password_box -->  
<?php
 } //end (($sc_is_virtual_product == true) || ($sc_is_mixed_product == true))
} //End IS NOT LOGGED ON ?> 
<?php ################ END Password - NO ACCOUNT ######################################## ?>
  



<?php ################ START Shipping Modules ######################################## ?>     
<?php if ($sc_shipping_modules_show == true) { //hide shipping modules - used for virtual products ?>

<?php if ((SC_HIDE_SHIPPING == 'true') && (vam_count_shipping_modules() <= 1)) { 
//if 0 or 1 shipping method and in admin hide shipping is set to true, hide shipping box 
//but we still need the divs in order to work with jquery update ?>
<div id="shipping_modules_box">
    <div id="shipping_options">
        <!--<p>shipping hidden as only 1 method</p>--> 
    </div>
</div>

<?php } //end hide shipping modules
else { // show shipping modules ?>


<div id="shipping_modules_box" class="sm_layout_box">
<div id="shipping_options"> 
<?php
  if (vam_count_shipping_modules() > 0) {
?>



  <h2><?php echo vam_get_sc_titles_number() . TABLE_HEADING_SHIPPING_METHOD; ?></h2>


<?php
if (sizeof($quotes) > 1 && sizeof($quotes[0]) > 1) {
?>

  <div class="contentText">
    <div style="float: right;">
      <?php echo '<h5>' . TITLE_PLEASE_SELECT . '</h5>'; ?>
    </div>

   <p><?php echo TEXT_CHOOSE_SHIPPING_METHOD; ?></p>
  </div>

<?php
    } elseif ($free_shipping == false) {
?>

  
    <p><?php echo TEXT_ENTER_SHIPPING_INFORMATION; ?></p>
  

<?php
    }
?>

    <table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
    if ($free_shipping == true) {
?>

      <tr>
        <td><h5><?php echo FREE_SHIPPING_TITLE; ?></h5>&nbsp;<?php echo $quotes[$i]['icon']; ?></td>
      </tr>
      <tr id="defaultSelected" class="moduleRowSelected" onMouseOver="rowOverEffect(this)" onMouseOut="rowOutEffect(this)" onClick="selectRowEffect(this, 0)">
        <td style="padding-left: 15px;"><?php echo sprintf(FREE_SHIPPING_DESCRIPTION, $vamPrice->Format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER, true)) . vam_draw_hidden_field('shipping', 'free_free'); ?></td>
      </tr>

<?php
    } else {
      $radio_buttons = 0;
      for ($i=0, $n=sizeof($quotes); $i<$n; $i++) {
?>

      <tr>
        <td colspan="3"><h5><?php echo $quotes[$i]['module']; ?></h5>&nbsp;<?php if (isset($quotes[$i]['icon']) && vam_not_null($quotes[$i]['icon'])) { echo $quotes[$i]['icon']; } ?></td>
      </tr>

<?php


        if (isset($quotes[$i]['error'])) {
?>

      <tr>
        <td colspan="3"><span class="errorText"><?php echo $quotes[$i]['error']; ?></span></td>
      </tr>

<?php
	
        } else {
          for ($j=0, $n2=sizeof($quotes[$i]['methods']); $j<$n2; $j++) {
// set the radio button to be checked if it is the method chosen
            $checked = (($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $shipping['id']) ? true : false);
			
            if ( ($checked == true) || ($n == 1 && $n2 == 1) ) {
              echo '      <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
            } else {
              echo '      <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
            }
?>

        <td width="75%" style="padding-left: 15px;"><?php echo $quotes[$i]['methods'][$j]['title']; ?></td>

<?php
            if ( ($n > 1) || ($n2 > 1) ) {


?>

        <td class="product_price"><?php echo $vamPrice->Format(vam_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0)),true); ?></td>
        <td align="right"><?php echo vam_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked); ?></td>

<?php
            } else {
?>

        <td class="product_price" align="right" colspan="2"><?php echo $vamPrice->Format(vam_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0)),true) . vam_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']); ?></td>

<?php
            }
?>

      </tr>

<?php
            $radio_buttons++;
          }
        }
      }
    }
?>

    </table>




<?php
  } //end (vam_count_shipping_modules()
?>
</div> <!--div end shipping_options-->
</div> <!--div end shipping_modules_box --> 
<?php
   } // end hide shipping 
?>  
<?php } //END hide shipping modules - used for virtual products ?>
<?php ################ END Shipping Modules ######################################## ?> 



<?php ################ START Payment Modules ######################################## ?> 
<?php if ($sc_payment_modules_show == true) { // hide payment modules ?>
<div id="payment_options" class="sm_layout_box"> 
<h2><?php echo vam_get_sc_titles_number() . TABLE_HEADING_PAYMENT_METHOD; ?></h2>

<?php
if ($sc_payment_modules_process == true) {
  $selection = $payment_modules->selection();


  if (sizeof($selection) > 1) {
?>

  
    
    <?php //echo '<strong>' . TITLE_PLEASE_SELECT . '</strong>'; ?>
  

    <p><?php echo TEXT_SELECT_PAYMENT_METHOD; ?></p>
  	

<?php
    } elseif ($free_shipping == false) {
?>

  
    <p><?php echo TEXT_ENTER_PAYMENT_INFORMATION; ?></p>
 

<?php
    }
?>

  

<?php
  $radio_buttons = 0;
  for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
?>

    <table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
    if ( ($selection[$i]['id'] == $payment) || ($n == 1) ) {
      echo '      <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
    } else {
      echo '      <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
    }
?>

        <td><h5><?php echo $selection[$i]['module']; ?></h5></td>
        <td align="right">

<?php
    if (sizeof($selection) > 1) {
      echo vam_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $payment));
    } else {
      echo vam_draw_hidden_field('payment', $selection[$i]['id']);
    }
?>

        </td>
      </tr>

<?php
    if (isset($selection[$i]['error'])) {
?>

      <tr>
        <td colspan="2"><?php echo $selection[$i]['error']; ?></td>
      </tr>

<?php

    } elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])) {
	
	
?>

      <tr>
        <td colspan="2"><table border="0" cellspacing="0" cellpadding="2">

<?php
      for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
	  
?>

          <tr>
            <td><?php echo $selection[$i]['fields'][$j]['title']; ?></td>
            <td><?php echo $selection[$i]['fields'][$j]['field']; ?></td>
          </tr>

<?php
      }
?>

        </table></td>
      </tr>

<?php
    }
?>

    </table>

<?php
    $radio_buttons++;
  }
}
?>


<?php
  // Discount Code 2.6 - start
  if (MODULE_ORDER_TOTAL_DISCOUNT_STATUS == 'true') {
?>

  <h2><?php echo vam_get_sc_titles_number() . TEXT_DISCOUNT_CODE; ?></h2>

  
  <?php echo vam_draw_input_field('discount_code', $sess_discount_code, 'class="text" size="10"'); ?>
  
  
<?php
  }
  // Discount Code 2.6 - end
?>
</div> <!--div end payment_options-->
<?php } //End hide payment modules ?>
<?php ################ END Payment Modules ######################################## ?> 





<?php ################ START Comment box ######################################## ?> 
<?php if (SC_HIDE_COMMENT != 'true') { ?>
<div id="comment_box" class="sm_layout_box">
	<h2><?php echo vam_get_sc_titles_number() . TABLE_HEADING_COMMENTS; ?></h2>

     <div class="contentText">
        <?php echo vam_draw_textarea_field('comments', 'soft', '60', '5', $comments); ?>
     </div>    
</div><!--div end comment_box--> 
<?php } ?>
<?php ################ END Comment box ######################################## ?> 




<?php ################ START Order Total Modules ######################################## ?> 
<div id="order_total_modules" class="sm_layout_box">
    <h2><?php echo vam_get_sc_titles_number() . HEADING_TOTAL; ?></h2>
    <div class="contentText">
    <div style="float: right;">
    <table border="0" cellspacing="0" cellpadding="2">
    
    <?php
      if (MODULE_ORDER_TOTAL_INSTALLED) {
        echo $order_total_modules->output();
      }
    ?>
    </table>
    </div>
    </div>
	<p>&nbsp;</p>
</div><!--div end order_total_modules -->
<?php ################ END Order Total Modules ######################################## ?> 

<div class="line_space"></div>

<?php ################ START Conditions of Use ######################################## ?> 
<?php if (SC_CONDITIONS == 'true') { // customers must check checkbox to proceed ?>
<div id="conditions" class="sm_layout_box">


<script type="text/javascript">
    $(document).ready(function() {

    $("#agreement").fancybox({
            'titlePosition'     : 'inside',
            'transitionIn'      : 'none',
            'transitionOut'     : 'none'
        });
    });
    </script>


	<?php echo SC_CONDITION; ?>
	<a id="agreement" href="<?php echo DIR_WS_HTTP_CATALOG . DIR_WS_LANGUAGES . $_SESSION['language'] . '/conditions.html'; ?>"><?php echo SC_HEADING_CONDITIONS; ?></a>
	<?php echo SC_CONDITION_END; ?>
	
    <?php if (SC_LIVE_VALIDATION == 'false') { ?>
    	<?php echo vam_draw_checkbox_field('TermsAgree','1', false, 'id="t18"'); ?>
    <?php } else { ?>
		<?php echo vam_draw_checkbox_field('TermsAgree','1', false, 'id="t18"'); ?>
        <script type="text/javascript">
            var t18 = new LiveValidation('t18');
            t18.add(Validate.Acceptance );
        </script>
    <?php } ?>
	
 
</div><!--div end conditions --> 
<?php } ?>
<?php ################ END Conditions of Use ######################################## ?> 




<?php
  if (is_array($payment_modules->modules)) {
  //  echo $payment_modules->process_button();
  }



 // echo vam_draw_button(IMAGE_BUTTON_CONFIRM_ORDER, 'check', null, 'primary');
?>
<div id="confirm_order">
<p>&nbsp;</p>
  <div class="buttonSet">
    <div class="buttonAction">
		<?php 
		if (SC_CONFIRMATION_PAGE == 'true') { //got to confimration page
			echo vam_image_submit('submit.png', IMAGE_BUTTON_CONFIRMATION_PAGE);
		} else { //order now
			echo vam_image_submit('submit.png', IMAGE_BUTTON_CONFIRM_ORDER);
		}  ?>
    </div>
  </div>
</div>

</form>
</div><!-- Div end checkout -->
</div><!-- Div end checkout_container -->

<?php
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
