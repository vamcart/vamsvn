<?php
/* -----------------------------------------------------------------------------------------
   $Id: checkout.php 867 2012-11-11 19:20:03 oleg_vamsoft $

   VamShop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2012 VamShop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(address_book.php,v 1.57 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (address_book.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (address_book.php,v 1.14 2003/08/17); xt-commerce.com
   (c) 2012	 STRUB

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

//description
//$_SESSION['sendto'] = is from db table ADRESS_BOOK the adress_book_id

require('includes/application_top.php');
//used for shipping
require('includes/classes/http_client.php');

// create smarty elements
$vamTemplate = new vamTemplate;

// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// assign data to template
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
		
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
require_once (DIR_FS_INC.'vam_check_stock.inc.php');

//START functions specific
function vam_get_sc_titles_number() {
	if (SC_COUNTER_ENABLED == 'true') {
		static $sc_count = 0;
		$sc_count++;
		return $sc_count . '.&nbsp;&nbsp;';
	}
}
//END functions specific

// Anti spam

		$spam_flag = false;

		if ( trim( $_POST['anti-bot-q'] ) != date('Y') ) { // answer is wrong - maybe spam
			$spam_flag = true;
			if ( empty( $_POST['anti-bot-q'] ) ) { // empty answer - maybe spam
				$antispam_error_message .= 'Error: empty answer. ['.$_POST['anti-bot-q'].']<br> ';
			} else {
				$antispam_error_message .= 'Error: answer is wrong. ['.$_POST['anti-bot-q'].']<br> ';
			}
		}
		if ( ! empty( $_POST['anti-bot-e-email-url'] ) ) { // field is not empty - maybe spam
			$spam_flag = true;
			$antispam_error_message .= 'Error: field should be empty. ['.$_POST['anti-bot-e-email-url'].']<br> ';
		}
		

// check if checkout is allowed

if ($_SESSION['cart']->show_total() > 0 ) {
 if ($_SESSION['cart']->show_total() < $_SESSION['customers_status']['customers_status_min_order'] ) {
  $_SESSION['allow_checkout'] = 'false';
 }
 if  ($_SESSION['customers_status']['customers_status_max_order'] != 0) {
  if ($_SESSION['cart']->show_total() > $_SESSION['customers_status']['customers_status_max_order'] ) {
  $_SESSION['allow_checkout'] = 'false';
  }
 }
}

if ($_SESSION['allow_checkout'] == 'false')
	vam_redirect(vam_href_link(FILENAME_SHOPPING_CART));


// Cart


	$hidden_options = '';
	$_SESSION['any_out_of_stock'] = 0;

	$products = $_SESSION['cart']->get_products();
	sort($products);
	for ($i = 0, $n = sizeof($products); $i < $n; $i ++) {
		// Push all attributes information in an array
		if (isset ($products[$i]['attributes'])) {
			foreach ($products[$i]['attributes'] as $option => $value) {
				//$hidden_options .= vam_draw_hidden_field('id['.$products[$i]['id'].']['.$option.']', $value);
				$attributes = vam_db_query("select popt.products_options_name, popt.products_options_type, poval.products_options_values_name, pa.options_values_price, pa.price_prefix,pa.attributes_stock,pa.products_attributes_id,pa.attributes_model
				                                      from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_OPTIONS_VALUES." poval, ".TABLE_PRODUCTS_ATTRIBUTES." pa
				                                      where pa.products_id = '".(int)$products[$i]['id']."'
				                                       and pa.options_id = '".(int)$option."'
				                                       and pa.options_id = popt.products_options_id
				                                       and pa.options_values_id = '".(int)$value."'
				                                       and pa.options_values_id = poval.products_options_values_id
				                                       and popt.language_id = '".(int) $_SESSION['languages_id']."'
				                                       and poval.language_id = '".(int) $_SESSION['languages_id']."'");
				$attributes_values = vam_db_fetch_array($attributes);

				if($attributes_values['products_options_type']=='2' || $attributes_values['products_options_type']=='3'){
					$hidden_options .= vam_draw_hidden_field('id[' . $products[$i]['id'] . '][txt_' . $option . '_'.$value.']',  $products[$i]['attributes_values'][$option]);
				    $attr_value = $products[$i]['attributes_values'][$option];
				}else{
					$hidden_options .= vam_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
				    $attr_value = $attributes_values['products_options_values_name'];
				}

				$products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
				$products[$i][$option]['options_values_id'] = $value;
				$products[$i][$option]['products_options_values_name'] = $attr_value;
				$products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
				$products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
				$products[$i][$option]['weight_prefix'] = $attributes_values['weight_prefix'];
				$products[$i][$option]['options_values_weight'] = $attributes_values['options_values_weight'];
				$products[$i][$option]['attributes_stock'] = $attributes_values['attributes_stock'];
				$products[$i][$option]['products_attributes_id'] = $attributes_values['products_attributes_id'];
				$products[$i][$option]['products_attributes_model'] = $attributes_values['products_attributes_model'];
			}
		}
	}

    // begin Bundled Products
    if (STOCK_CHECK == 'true') {
      $bundle_contents = array();
      $bundle_values = array();
      $product_ids_in_bundles = array();
      $bundle_qty_ordered = array();
      for ($i=0, $n=sizeof($products); $i<$n; $i++) {
        if ($products[$i]['bundle'] == "yes") {
          $tmp = get_all_bundle_products($products[$i]['id']);
          $bundle_values[$products[$i]['id']] = $products[$i]['final_price'];
          $bundle_contents[$products[$i]['id']] = $tmp;
          $bundle_qty_ordered[$products[$i]['id']] = $products[$i]['quantity'];
          foreach ($tmp as $id => $qty) {
            if (!in_array($id, $product_ids_in_bundles)) $product_ids_in_bundles[] = $id; // save unique ids
          }
        }
      }
      if (!empty($bundle_values)) { // if bundles exist in order
        arsort($bundle_values); // sort array so bundle ids with highest value come first
        $product_on_hand = array();
        $bundles_stock_check = array();
        foreach ($product_ids_in_bundles as $id) {
          // get quantity on hand for every product contained in bundles in this order
          $product_on_hand[$id] = vam_get_products_stock($id);
        }
        foreach ($bundle_values as $bid => $bprice) {
          $bundles_available = array();
          foreach ($bundle_contents[$bid] as $pid => $qty) {
            $bundles_available[] = intval($product_on_hand[$pid] / $qty);
          }
          $available = min($bundles_available); // max number of this bundle we can make with product on hand
          $bundles_stock_check[$bid] = '';
          if ($available <= 0) {
            $bundles_stock_check[$bid] = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '<br />' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . TEXT_NOT_AVAILABLEINSTOCK . '</span>';
          } elseif ($available < $bundle_qty_ordered[$bid]) {
            $bundles_stock_check[$bid] = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '<br />' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . TEXT_ONLY_THIS_AVAILABLEINSTOCK1 . $available . TEXT_ONLY_THIS_AVAILABLEINSTOCK2 . '</span>';
          }
          $deduct = min($available, $bundle_qty_ordered[$bid]); // assume we sell as many of the bundle as possible
          foreach ($bundle_contents[$bid] as $pid => $qty) {
            // reduce product left on hand by number sold in this bundle before checking next less expensive bundle
            // also lets us know how many we have left to sell individually
            $product_on_hand[$pid] -= ($deduct * $qty);
          }
        }
      }
    }
    $any_bundle_only = false;
    // end Bundled Products


	$vamTemplate->assign('HIDDEN_OPTIONS', $hidden_options);
	require_once (DIR_WS_MODULES.'order_details_checkout.php');

   if (ACTIVATE_GIFT_SYSTEM == 'true')
   require_once (DIR_WS_MODULES.'gift_cart.php');
	

if (isset($_POST['sc_shipping_address_show'])) { 
$sc_shipping_address_show = vam_db_prepare_input($_POST['sc_shipping_address_show']);
} else {
$sc_shipping_address_show = true;
}

if (isset($_POST['sc_shipping_modules_show'])) { 
$sc_shipping_modules_show = vam_db_prepare_input($_POST['sc_shipping_modules_show']);
} else {
$sc_shipping_modules_show = true; 
}


//used for the validation
if (isset($_POST['create_account'])) { 
	$create_account = vam_db_prepare_input($_POST['create_account']);
} else {
	$create_account = false; 
}

if (isset($_POST['sc_payment_address_show'])) { 
$sc_payment_address_show = vam_db_prepare_input($_POST['sc_payment_address_show']);
} else {
$sc_payment_address_show = true;
}

if (isset($_POST['sc_payment_modules_show'])) { 
$sc_payment_modules_show = vam_db_prepare_input($_POST['sc_payment_modules_show']);
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
$sc_guest_secondname = $_SESSION['sc_customers_secondname'];
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

      if (!$state) $state = vam_get_zone_name(STORE_COUNTRY, STORE_ZONE,'');
      if (!$_POST['state']) $_POST['state'] = vam_get_zone_name(STORE_COUNTRY, STORE_ZONE,'');

//////////////////  End Check //////////////////////////////

$payment_address_selected = vam_db_prepare_input($_POST['payment_adress']); //init if checkbox for payment address is checked or not
$shipping_count_modules = vam_db_prepare_input($_POST['shipping_count']); //needed for validation

if (!vam_session_is_registered('customer_id')) { //only for not logged in user
	if (!isset($_POST['action'])) {
		$password_selected = true; 
	} else {
		if (SC_CREATE_ACCOUNT_CHECKOUT_PAGE != 'true') {
			$password_selected = true;
		} else {
			$password_selected = vam_db_prepare_input($_POST['password_checkbox']); 
		}
	}
	
	if ($password_selected != '1') { //not selected 
		$create_account = true;
	} else { //is selected
		$create_account = false; //set to false in order to avoid validation
	}
}



############################# Validate start - NOT LOGGED ON #######################################

  if (!isset($_SESSION['qiwi_telephone'])) $_SESSION['qiwi_telephone'] = $_POST['qiwi_telephone'];

  $process = false;
  if (isset($_POST['action']) && ($_POST['action'] == 'not_logged_on') && isset($_POST['formid']) && ($_POST['formid'] == $sessiontoken) && $spam_flag == false) {
    $process = true;
	
	if ($sc_shipping_address_show == true) { //show shipping otpions 
    if (ACCOUNT_GENDER == 'true' or ACCOUNT_GENDER == 'optional') {
      if (isset($_POST['gender'])) {
        $gender = vam_db_prepare_input($_POST['gender']);
      } else {
        $gender = false;
      }
    }
    $firstname = vam_db_prepare_input($_POST['firstname']);
    if (ACCOUNT_SECOND_NAME == 'true' or ACCOUNT_SECOND_NAME == 'optional') $secondname = vam_db_prepare_input($_POST['secondname']);
    if (ACCOUNT_LAST_NAME == 'true' or ACCOUNT_LAST_NAME == 'optional') $lastname = vam_db_prepare_input($_POST['lastname']);
    if (ACCOUNT_DOB == 'true' or ACCOUNT_DOB == 'optional') $dob = vam_db_prepare_input($_POST['dob']);
    if (ACCOUNT_EMAIL == 'true' or ACCOUNT_EMAIL == 'optional') $email_address = vam_db_prepare_input($_POST['email_address']);
    if (ACCOUNT_COMPANY == 'true' or ACCOUNT_COMPANY == 'optional') $company = vam_db_prepare_input($_POST['company']);
    if (ACCOUNT_STREET_ADDRESS == 'true' or ACCOUNT_STREET_ADDRESS == 'optional') $street_address = vam_db_prepare_input($_POST['street_address']);
    if (ACCOUNT_SUBURB == 'true' or ACCOUNT_SUBURB == 'optional') $suburb = vam_db_prepare_input($_POST['suburb']);
    if (ACCOUNT_POSTCODE == 'true' or ACCOUNT_POSTCODE == 'optional') $postcode = vam_db_prepare_input($_POST['postcode']);
    if (ACCOUNT_CITY == 'true' or ACCOUNT_CITY == 'optional') $city = vam_db_prepare_input($_POST['city']);
    if (ACCOUNT_STATE == 'true' or ACCOUNT_STATE == 'optional') {
      $state = vam_db_prepare_input($_POST['state']);
      if (isset($_POST['zone_id'])) {
        $zone_id = vam_db_prepare_input($_POST['zone_id']);
      } else {
        $zone_id = false;
      }
    } else {
      $state = STORE_ZONE;
    }
    if (ACCOUNT_COUNTRY == 'true' or ACCOUNT_COUNTRY == 'optional') {
    $country = vam_db_prepare_input($_POST['country']);
    } else {
    $country = STORE_COUNTRY;
    }
    if (ACCOUNT_TELE == 'true' or ACCOUNT_TELE == 'optional') 
    $telephone = vam_db_prepare_input($_POST['telephone']);
    if (ACCOUNT_FAX == 'true' or ACCOUNT_FAX == 'optional') 
    $fax = vam_db_prepare_input($_POST['fax']);
    if (isset($_POST['newsletter'])) {
      $newsletter = vam_db_prepare_input($_POST['newsletter']);
    } else {
      //$newsletter = false;
      $newsletter = true;
    }

    $password = vam_RandomString(8);
    $confirmation = vam_db_prepare_input($_POST['confirmation']);
	
	//start with input validation for shipping address /////////
    $error = false;
	
		
    //if (ACCOUNT_GENDER == 'true') {
      //if ( ($gender != 'm') && ($gender != 'f') ) {
        //$error = true;

        //$messageStack->add('smart_checkout', ENTRY_GENDER_ERROR);
      //}
    //}

    //if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
      //$error = true;

      //$messageStack->add('smart_checkout', ENTRY_FIRST_NAME_ERROR);
    //}

    //if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
      //$error = true;

      //$messageStack->add('smart_checkout', ENTRY_LAST_NAME_ERROR);
    //}

    //if (ACCOUNT_DOB == 'true') {
      //if ((is_numeric(vam_date_raw($dob)) == false) || (@checkdate(substr(vam_date_raw($dob), 4, 2), substr(vam_date_raw($dob), 6, 2), substr(vam_date_raw($dob), 0, 4)) == false)) {
        //$error = true;

        //$messageStack->add('smart_checkout', ENTRY_DATE_OF_BIRTH_ERROR);
      //}
    //}


	//if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      //$error = true;

      //$messageStack->add('smart_checkout', ENTRY_EMAIL_ADDRESS_ERROR);
    //} elseif (vam_validate_email($email_address) == false) {
      //$error = true;

      //$messageStack->add('smart_checkout', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    //} else {
      //org
	  //$check_email_query = vam_db_query("select count(*) as total from " . TABLE_CUSTOMERS . " where customers_email_address = '" . vam_db_input($email_address) . "'");
	  
	  //new
      //$check_email_query = vam_db_query("select count(*) as total from " . TABLE_CUSTOMERS . " where customers_email_address = '" . vam_db_input($email_address) . "'");

      //$check_email = vam_db_fetch_array($check_email_query);
      //if ($check_email['total'] > 0) {
        //$error = true;
		

        //$messageStack->add('smart_checkout', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
      //}
    //}
    
    //if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
      //$error = true;

      //$messageStack->add('smart_checkout', ENTRY_STREET_ADDRESS_ERROR);
    //}

    //if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
      //$error = true;

      //$messageStack->add('smart_checkout', ENTRY_POST_CODE_ERROR);
    //}

    //if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
      //$error = true;

      //$messageStack->add('smart_checkout', ENTRY_CITY_ERROR);
    //}

    //if (is_numeric($country) == false) {
      //$error = true;

      //$messageStack->add('smart_checkout', ENTRY_COUNTRY_ERROR);
    //}

    //if (ACCOUNT_STATE == 'true') {
      $zone_id = 0;
      $check_query = vam_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "'");
      $check = vam_db_fetch_array($check_query);
      $entry_state_has_zones = ($check['total'] > 0);
      if ($entry_state_has_zones == true) {
        $zone_query = vam_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' and (zone_name = '" . vam_db_input($state) . "' or zone_code = '" . vam_db_input($state) . "')");
        //if (vam_db_num_rows($zone_query) == 1) {
          $zone = vam_db_fetch_array($zone_query);
          $zone_id = $zone['zone_id'];
        //} else {
          //$error = true;

          //$messageStack->add('smart_checkout', ENTRY_STATE_ERROR_SELECT);
        //}
      //} else {
        //if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
          //$error = true;

          //$messageStack->add('smart_checkout', ENTRY_STATE_ERROR);
        //}
      //}
    }

    //if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
      //$error = true;

      //$messageStack->add('smart_checkout', ENTRY_TELEPHONE_NUMBER_ERROR);
    //}
	
	//password validation
	//$password = vam_db_prepare_input($_POST['password']);
    //$confirmation = vam_db_prepare_input($_POST['confirmation']);
	//if ($create_account == true) {
		//if (!vam_session_is_registered('customer_id')) { //validate only for unregistered user
		 //if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
			  //$error = true;
	
			  //$messageStack->add('smart_checkout', ENTRY_PASSWORD_ERROR);
			//} elseif ($password != $confirmation) {
			  //$error = true;
	
			  //$messageStack->add('smart_checkout', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
			//}
		//}
	//}	
	
	//shipping validation
	$shipping_validation = vam_db_prepare_input($_POST['shipping']);
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
	$payment_validation = vam_db_prepare_input($_POST['payment']);
	if ($sc_payment_modules_show == true) { 
		if ($payment_validation == '') {
			$error = true;
			$messageStack->add('smart_checkout', PAYMENT_ERROR);
		}
	}

	//conditions validation
	$conditions_validation = vam_db_prepare_input($_POST['conditions']);
	if (($conditions_validation == '') && (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true')) {
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
      if (ACCOUNT_SECOND_NAME == 'true' or ACCOUNT_SECOND_NAME == 'optional') $secondname_payment = vam_db_prepare_input($_POST['secondname_payment']);
      if (ACCOUNT_LAST_NAME == 'true' or ACCOUNT_LAST_NAME == 'optional') $lastname_payment = vam_db_prepare_input($_POST['lastname_payment']);
      if (ACCOUNT_STREET_ADDRESS == 'true' or ACCOUNT_STREET_ADDRESS == 'optional') $street_address_payment = vam_db_prepare_input($_POST['street_address_payment']);
      if (ACCOUNT_SUBURB == 'true') $suburb_payment = vam_db_prepare_input($_POST['suburb_payment']);
      if (ACCOUNT_POSTCODE == 'true' or ACCOUNT_POSTCODE == 'optional') $postcode_payment = vam_db_prepare_input($_POST['postcode_payment']);
      if (ACCOUNT_CITY == 'true' or ACCOUNT_CITY == 'optional') $city_payment = vam_db_prepare_input($_POST['city_payment']);
      if (ACCOUNT_COUNTRY == 'true' or ACCOUNT_COUNTRY == 'optional') $country_payment = vam_db_prepare_input($_POST['country_payment']);
      if (ACCOUNT_STATE == 'true' or ACCOUNT_STATE == 'optional') {
        if (isset($_POST['zone_id'])) {
          $zone_id_payment = vam_db_prepare_input($_POST['zone_id_payment']);
        } else {
          $zone_id_payment = false;
        }
        $state_payment = vam_db_prepare_input($_POST['state_payment']);
      }

      //if (ACCOUNT_GENDER == 'true') {
        //if ( ($gender_payment != 'm') && ($gender_payment != 'f') ) {
          //$error = true;

          //$messageStack->add('smart_checkout', ENTRY_GENDER_ERROR);
        //}
      //}


      //if (strlen($firstname_payment) < ENTRY_FIRST_NAME_MIN_LENGTH) {
        //$error = true;

        //$messageStack->add('smart_checkout', ENTRY_FIRST_NAME_ERROR);
      //}

      //if (strlen($lastname_payment) < ENTRY_LAST_NAME_MIN_LENGTH) {
        //$error = true;

        //$messageStack->add('smart_checkout', ENTRY_LAST_NAME_ERROR);
      //}

      //if (strlen($street_address_payment) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
        //$error = true;

        //$messageStack->add('smart_checkout', ENTRY_STREET_ADDRESS_ERROR);
      //}

      //if (strlen($postcode_payment) < ENTRY_POSTCODE_MIN_LENGTH) {
        //$error = true;

        //$messageStack->add('smart_checkout', ENTRY_POST_CODE_ERROR);
      //}

      //if (strlen($city_payment) < ENTRY_CITY_MIN_LENGTH) {
        //$error = true;

        //$messageStack->add('smart_checkout', ENTRY_CITY_ERROR);
      //}

      //if (ACCOUNT_STATE == 'true') {
        //$zone_id_payment = 0;
        //$check_query = vam_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country_payment . "'");
        //$check = vam_db_fetch_array($check_query);
        //$entry_state_has_zones = ($check['total'] > 0);
        //if ($entry_state_has_zones == true) {
          //$zone_query = vam_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country_payment . "' and (zone_name = '" . vam_db_input($state_payment) . "' or zone_code = '" . vam_db_input($state_payment) . "')");
          //if (vam_db_num_rows($zone_query) == 1) {
            //$zone_payment = vam_db_fetch_array($zone_query);
            //$zone_id_payment = $zone_payment['zone_id'];
          //} else {
            //$error = true;

            //$messageStack->add('smart_checkout', ENTRY_STATE_ERROR_SELECT);
          //}
        //} else {
          //if (strlen($state_payment) < ENTRY_STATE_MIN_LENGTH) {
            //$error = true;

            //$messageStack->add('smart_checkout', ENTRY_STATE_ERROR);
          //}
        //}
      //}

      //if ( (is_numeric($country_payment) == false) || ($country_payment < 1) ) {
        //$error = true;

        //$messageStack->add('smart_checkout', ENTRY_COUNTRY_ERROR);
      //}
	 }
	} //END validate only if not free payment 
	 // End new payment address input validation /////

	$_SESSION['kvit_name'] = vam_db_prepare_input($_POST['kvit_name']);
	$_SESSION['kvit_address'] = vam_db_prepare_input($_POST['kvit_address']);

	$_SESSION['s_name'] = vam_db_prepare_input($_POST['s_name']);
	$_SESSION['s_inn'] = vam_db_prepare_input($_POST['s_inn']);
	$_SESSION['s_kpp'] = vam_db_prepare_input($_POST['s_kpp']);
	$_SESSION['s_ogrn'] = vam_db_prepare_input($_POST['s_ogrn']);
	$_SESSION['s_okpo'] = vam_db_prepare_input($_POST['s_okpo']);
	$_SESSION['s_rs'] = vam_db_prepare_input($_POST['s_rs']);
	$_SESSION['s_bank_name'] = vam_db_prepare_input($_POST['s_bank_name']);
	$_SESSION['s_bik'] = vam_db_prepare_input($_POST['s_bik']);
	$_SESSION['s_ks'] = vam_db_prepare_input($_POST['s_ks']);
	$_SESSION['s_address'] = vam_db_prepare_input($_POST['s_address']);
	$_SESSION['s_yur_address'] = vam_db_prepare_input($_POST['s_yur_address']);
	$_SESSION['s_fakt_address'] = vam_db_prepare_input($_POST['s_fakt_address']);
	$_SESSION['s_telephone'] = vam_db_prepare_input($_POST['s_telephone']);
	$_SESSION['s_fax'] = vam_db_prepare_input($_POST['s_fax']);
	$_SESSION['s_email'] = vam_db_prepare_input($_POST['s_email']);
	$_SESSION['s_director'] = vam_db_prepare_input($_POST['s_director']);
	$_SESSION['s_accountant'] = vam_db_prepare_input($_POST['s_accountant']);

}
//////////////////////////  Validation END - NOT LOGGED ON//////////////////////////////////



/////////////////// Validation for LOGGED ON ////////////////////////////////////////////
if (isset($_POST['action']) && ($_POST['action'] == 'logged_on') && isset($_POST['formid']) && ($_POST['formid'] == $sessiontoken) && $spam_flag == false) {

	$_SESSION['comments'] = vam_db_prepare_input($_POST['comments']);

	$_SESSION['kvit_name'] = vam_db_prepare_input($_POST['kvit_name']);
	$_SESSION['kvit_address'] = vam_db_prepare_input($_POST['kvit_address']);

	$_SESSION['s_name'] = vam_db_prepare_input($_POST['s_name']);
	$_SESSION['s_inn'] = vam_db_prepare_input($_POST['s_inn']);
	$_SESSION['s_kpp'] = vam_db_prepare_input($_POST['s_kpp']);
	$_SESSION['s_ogrn'] = vam_db_prepare_input($_POST['s_ogrn']);
	$_SESSION['s_okpo'] = vam_db_prepare_input($_POST['s_okpo']);
	$_SESSION['s_rs'] = vam_db_prepare_input($_POST['s_rs']);
	$_SESSION['s_bank_name'] = vam_db_prepare_input($_POST['s_bank_name']);
	$_SESSION['s_bik'] = vam_db_prepare_input($_POST['s_bik']);
	$_SESSION['s_ks'] = vam_db_prepare_input($_POST['s_ks']);
	$_SESSION['s_address'] = vam_db_prepare_input($_POST['s_address']);
	$_SESSION['s_yur_address'] = vam_db_prepare_input($_POST['s_yur_address']);
	$_SESSION['s_fakt_address'] = vam_db_prepare_input($_POST['s_fakt_address']);
	$_SESSION['s_telephone'] = vam_db_prepare_input($_POST['s_telephone']);
	$_SESSION['s_fax'] = vam_db_prepare_input($_POST['s_fax']);
	$_SESSION['s_email'] = vam_db_prepare_input($_POST['s_email']);
	$_SESSION['s_director'] = vam_db_prepare_input($_POST['s_director']);
	$_SESSION['s_accountant'] = vam_db_prepare_input($_POST['s_accountant']);
	
	// start with input validation /////////
    $error = false;
	
	//shipping validation
	$shipping_validation = vam_db_prepare_input($_POST['shipping']);
	if ($sc_shipping_modules_show == true) {
		if (($shipping_validation == '') && ($shipping_count_modules > 1)) {
			$error = true;
			$messageStack->add('smart_checkout', SHIPPING_ERROR);
		}
	}
	
	//payment validation
	$payment_validation = vam_db_prepare_input($_POST['payment']);
	if ($sc_payment_modules_show == true) { 
		if ($payment_validation == '') {
			$error = true;
			$messageStack->add('smart_checkout', PAYMENT_ERROR);
		}
	}
	
	//conditions validation
	$conditions_validation = vam_db_prepare_input($_POST['conditions']);
	if (($conditions_validation == '') && (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true')) {
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






if (!vam_session_is_registered('payment')) {vam_session_register('payment');}
if (!vam_session_is_registered('sendto')) {vam_session_register('sendto');} //need to set it otherwise in checkout_process.php we get redirected to checkout_shipping.php
if (!vam_session_is_registered('billto')) {vam_session_register('billto');} //need to set it otherwise in checkout_process.php we get redirected to payment_shipping.php
if (vam_session_is_registered('free_payment')) {vam_session_unregister('free_payment');} //hack for free payment unregister it if changing products

if (vam_session_is_registered('noaccount')) {vam_session_unregister('noaccount');} //used for order class - order.php
if (vam_session_is_registered('show_account_data')) {vam_session_unregister('show_account_data');} //used for confirmation page to show account data
if (vam_session_is_registered('create_account')) {vam_session_unregister('create_account');} //used for confirmation page to send email if account is created
if (vam_session_is_registered('hide_shipping_data')) {vam_session_unregister('hide_shipping_data');} //used for confirmation page to hide shipping data
if (vam_session_is_registered('hide_payment_data')) {vam_session_unregister('hide_payment_data');} //used for confirmation page to hide payment data





//Classes init need to set here
$order = new order;  



//set $selected_country_id
//if logged in set $selected_country_id from order class else from selected Post
if (vam_session_is_registered('customer_id')) {
	$selected_country_id = $order->delivery['country']['id'];

	if ($order->delivery['country']['iso_code_2'] != '') {
		$_SESSION['delivery_zone'] = $order->delivery['country']['iso_code_2'];
	} 
} else {
//$selected_country_id = vam_db_prepare_input($_POST['country']);
if (isset($_POST['country'])) {
  $selected_country_id = vam_db_prepare_input($_POST['country']);
} else {
  $selected_country_id = STORE_COUNTRY; //here you can set your default country ID
}

}



// country is selected
        $country_info = vam_get_countriesList($selected_country_id,true);
        $cache_state_prov_values = vam_db_fetch_array(vam_db_query("select zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$selected_country_id . "' and zone_name = '" . vam_db_input($_POST['state']) . "'"));
        $cache_state_prov_code = $cache_state_prov_values['zone_code'];
        if (!vam_session_is_registered('customer_id')) {
        $order->delivery = array('postcode' => vam_db_prepare_input($_POST['postcode']),
                                 'state' => vam_db_prepare_input($_POST['state']),
                                 'city' => vam_db_prepare_input($_POST['city']),
                                 'country' => array('id' => $selected_country_id, 'title' => $country_info['countries_name'], 'iso_code_2' => $country_info['countries_iso_code_2'], 'iso_code_3' =>  $country_info['countries_iso_code_3']),
                                 'country_id' => $selected_country_id,
//add state zone_id
                                 'zone_id' => $cache_state_prov_values['zone_id'],
                                 'format_id' => vam_get_address_format_id($selected_country_id));
// country is selected End					

if ($order->delivery['country']['iso_code_2'] != '') {
	$_SESSION['delivery_zone'] = $order->delivery['country']['iso_code_2'];
}

        }			 	  


  


$shipping_modules = new shipping; //set it after getting country_info otherwise it won't update shipping methods with jquery

$total_weight = $_SESSION['cart']->show_weight(); //set before $shipping is defined

$length = $_SESSION['cart']->show_length();
$width = $_SESSION['cart']->show_width();
$height = $_SESSION['cart']->show_height();
$volume = $_SESSION['cart']->show_volume();

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
//if (isset($_POST['shipping']) && vam_not_null($_POST['shipping'])){ //used THAT IT IS not 0 again
  //if ($_POST['shipping'] != 'undefined') { //to avoid setting Jquery send data which is undefined

  if (vam_count_shipping_modules() == 1) {
  		
  		list($module, $method) = explode('_', $_POST['shipping']);
		// get all available shipping quotes
		$quotes = $shipping_modules->quote($method, $module);

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

						//pickpoint start
								if ($_POST['shipping'] == 'pickpoint_pickpoint') {
						       //if ($_POST['pickpoint_address'] != '') {
								    $shipping['title'] = MODULE_SHIPPING_PICKPOINT_TEXT_TITLE . ': ' . MODULE_SHIPPING_PICKPOINT_TEXT_ADDRESS . $_POST['pickpoint_address'];
						       //} else {
								    //$shipping['title'] = 'test';
						       //}
						      }
						//pickpoint end

						//boxberry start
								if ($_POST['shipping'] == 'boxberry_boxberry') {
						       //if ($_POST['boxberry_address'] != '') {
								    $shipping['title'] = MODULE_SHIPPING_BOXBERRY_TEXT_TITLE . ': ' . MODULE_SHIPPING_BOXBERRY_TEXT_ADDRESS . $_POST['boxberry_address'];
						       //} else {
								    //$shipping['title'] = 'test';
						       //}
						      }
						//boxberry end
			
		} else {
		  //calculation first time ////////////
		  
			if ($order->content_type == 'virtual') {
				$shipping = false; //set it also in this case if only one shipping method is set
			}
			
			$order = new order;  //set it here again to calculate shipping method after $shipping is defined
			
			
			// country info for country change
					$country_info = vam_get_countriesList($selected_country_id,true);
					$cache_state_prov_values = vam_db_fetch_array(vam_db_query("select zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$selected_country_id . "' and zone_name = '" . vam_db_input($_POST['state']) . "'"));
					$cache_state_prov_code = $cache_state_prov_values['zone_code'];
					if (!vam_session_is_registered('customer_id')) {
					$order->delivery = array('postcode' => vam_db_prepare_input($_POST['postcode']),
											 'state' => vam_db_prepare_input($_POST['state']),
                                  'city' => vam_db_prepare_input($_POST['city']),
											 'country' => array('id' => $selected_country_id, 'title' => $country_info['countries_name'], 'iso_code_2' => $country_info['countries_iso_code_2'], 'iso_code_3' =>  $country_info['countries_iso_code_3']),
											 'country_id' => $selected_country_id,
			//add state zone_id
											 'zone_id' => $cache_state_prov_values['zone_id'],
											 'format_id' => vam_get_address_format_id($selected_country_id));
			// end country info for country change			

if ($order->delivery['country']['iso_code_2'] != '') {
	$_SESSION['delivery_zone'] = $order->delivery['country']['iso_code_2'];
}

					}					 	  
			  
		} //$shipping end test
  }
  
  //}
  //} 
// END - if only 1 shipping method is set ////  

if (isset ($_POST['cot_gv']))
	$_SESSION['cot_gv'] = true;
 
//Classes init ##########################################
$total_count = $_SESSION['cart']->count_contents();  

if (isset($_POST['payment'])){ $payment = $_POST['payment'];
$_SESSION['payment'] = $_POST['payment'];
} //payment post data assignment

//payment class
if ((!isset($_POST['payment'])) || ($error == true)) {
	$payment_modules = new payment();
} elseif (isset($_POST['payment'])) {
	$payment_modules = new payment($payment);
}


$order_total_modules = new order_total;

//Classes init end ##########################################



############# Shipping specific  ####################
/*
 // if no shipping destination address was selected, use the customers own address as default
  if (!vam_session_is_registered('sendto')) {
    vam_session_register('sendto');
    $_SESSION['sendto'] = $customer_default_address_id;
  } else {
// verify the selected shipping address
    if ( (is_array($_SESSION['sendto']) && empty($_SESSION['sendto'])) || is_numeric($_SESSION['sendto']) ) {
      $check_address_query = vam_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int)$customer_id . "' and address_book_id = '" . (int)$_SESSION['sendto'] . "'");
      $check_address = vam_db_fetch_array($check_address_query);

      if ($check_address['total'] != '1') {
        $_SESSION['sendto'] = $customer_default_address_id;
        if (vam_session_is_registered('shipping')) vam_session_unregister('shipping');
      }
    }
  }
*/

  
// register a random ID in the session to check throughout the checkout procedure
// against alterations in the shopping cart contents
  if (!vam_session_is_registered('cartID')) vam_session_register('cartID');
  $cartID = $_SESSION['cart']->cartID;

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($_SESSION['cart']->cartID) && vam_session_is_registered('cartID')) {
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
    if (!vam_session_is_registered('shipping')) vam_session_register('shipping');
    $shipping = false;
    $_SESSION['sendto'] = false;
	$checkout_possible = true; //avoid shipping validation
	
	$payment_address_selected = '1'; //hide payemt address validation
	$sc_is_virtual_product = true; // change Title
	if (!vam_session_is_registered('hide_shipping_data')) vam_session_register('hide_shipping_data'); //hide shipping data
	$sc_payment_address_show = false; // hide payemt address as shipping address is used for payment address
	$sc_shipping_modules_show = false; //hide shipping modules
	$create_account = true; //you need to create an account
	
	if (vam_session_is_registered('customer_id')) { //IS LOGGED ON - change shipping address to payment address
		$sc_payment_address_show = true;
		$sc_shipping_address_show = false;
		$create_account = false;
		//if (vam_session_is_registered('create_account')) {vam_session_unregister('create_account');} //is not possible
		if (!vam_session_is_registered('hide_shipping_data')) vam_session_register('hide_shipping_data'); //hide shipping data
	}
  }

//Mixed virtual products
  if ($order->content_type == 'mixed') {
	$create_account = true; //you need to create an account
	if (!vam_session_is_registered('create_account')) {vam_session_register('create_account');}
	$sc_is_mixed_product = true;
	if (vam_session_is_registered('customer_id')) { //IS LOGGED ON
		$create_account = false;
	}
  }

//Free products - could have shipping costs so payment is needed
  if ($order->info['subtotal'] == '0') {
	if (vam_session_is_registered('customer_id')) { //IS LOGGED ON
		$_SESSION['sendto'] = $customer_default_address_id; 
	}
  }


//Free products and free shipping
  /*if ($order->info['total'] == '0') {
	$payment_address_selected = '1'; //hide payemt address validation
	$sc_payment_address_show = false; // hide payemt address as shipping address is used for payment address
	$sc_payment_modules_show = false; //hide payment modules
	if (!vam_session_is_registered('free_payment')) {vam_session_register('free_payment');} //hack for free payment
	
	if (vam_session_is_registered('customer_id')) { //IS LOGGED ON
		$_SESSION['sendto'] = $customer_default_address_id; 
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
	  
	  if (vam_session_is_registered('customer_id')) { //IS LOGGED ON
		$_SESSION['sendto'] = $customer_default_address_id;
	  }
  }
  

//  

  
	
	
  if (SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true') {
  	//$create_account = true; //you need to create an account
	//if (!vam_session_is_registered('create_account')) {vam_session_register('create_account');}
	if (vam_session_is_registered('customer_id')) { //IS LOGGED ON
	//	if (vam_session_is_registered('create_account')) {vam_session_unregister('create_account');} //is not possible
	}
  }
  
  if (SC_CREATE_ACCOUNT_REQUIRED == 'true') {
  	$create_account = true; //you need to create an account
	if (!vam_session_is_registered('create_account')) {vam_session_register('create_account');}
	if (vam_session_is_registered('customer_id')) { //IS LOGGED ON
		$create_account = false;
	}
  }
  
  
  //register session to create account
  if (SC_CONFIRMATION_PAGE == 'true') {
  	if (vam_session_is_registered('customer_id')) {
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
if ($_SESSION['sendto'] == '') {
	$new_address_query = vam_db_query("select customers_default_address_id from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$customer_id . "'");
	$new_address = vam_db_fetch_array($new_address_query);   // Hole Language aus orders DB
	$_SESSION['sendto'] = $new_address['customers_default_address_id'];
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

						//pickpoint start
								if ($_POST['shipping'] == 'pickpoint_pickpoint') {
						       //if ($_POST['pickpoint_address'] != '') {
								    $shipping['title'] = MODULE_SHIPPING_PICKPOINT_TEXT_TITLE . ': ' . MODULE_SHIPPING_PICKPOINT_TEXT_ADDRESS . $_POST['pickpoint_address'];
						       //} else {
								    //$shipping['title'] = 'test';
						       //}
						      }
						//pickpoint end

						//boxberry start
								if ($_POST['shipping'] == 'boxberry_boxberry') {
						       //if ($_POST['boxberry_address'] != '') {
								    $shipping['title'] = MODULE_SHIPPING_BOXBERRY_TEXT_TITLE . ': ' . MODULE_SHIPPING_BOXBERRY_TEXT_ADDRESS . $_POST['boxberry_address'];
						       //} else {
								    //$shipping['title'] = 'test';
						       //}
						      }
						//boxberry end

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
//if (isset($_POST['action'])) {
//if ($checkout_possible != true) {
		//$error = true;
		//$messageStack->add('smart_checkout', SC_ERROR_NO_SHIPPING_POSSIBLE);
	//}
//}
//END CHECK if checkout is possible here after all calculations /////	
	

///////////////////  START PROCESS Button pressed for NO ACCOUNT onepage and confirmation page  ////////////////////////////////////////////
if (isset($_POST['action']) && (($_POST['action'] == 'not_logged_on') && ($create_account != true)) && isset($_POST['formid']) && ($_POST['formid'] == $sessiontoken) && $spam_flag == false) {
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
		$_SESSION['sc_customers_secondname'] = $secondname;
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
		$_SESSION['sc_customers_password'] = $password;
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
		
   	  	$extra_fields_query = vam_db_query("select ce.fields_id from " . TABLE_EXTRA_FIELDS . " ce where ce.fields_status=1 ");
    	  while($extra_fields = vam_db_fetch_array($extra_fields_query))
				{
				  if(isset($_POST['fields_' . $extra_fields['fields_id']])){
            $_SESSION['fields_' . $extra_fields['fields_id']] = $_POST['fields_' . $extra_fields['fields_id']];
       		}
       		}		
		
		//payment data only if different
		if ($payment_address_selected != '1') { //is unchecked - so payment address is different
		
			$_SESSION['sc_payment_gender'] = $gender_payment;
			$_SESSION['sc_payment_firstname'] = $firstname_payment;
			$_SESSION['sc_payment_secondname'] = $secondname_payment;
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
		if (isset($_POST['payment'])) $_SESSION['payment'] = $_POST['payment'];
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
if (isset($_POST['action']) && (($_POST['action'] == 'not_logged_on') && ($create_account == true)) && isset($_POST['formid']) && ($_POST['formid'] == $sessiontoken) && $spam_flag == false) {
//if no errors
    if ($error == false) {
		
	  $dbPass = vam_encrypt_password($password);

      $sql_data_array = array('customers_firstname' => $firstname,
                              'customers_status' => 2,
                              'customers_secondname' => $secondname,
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
      $customers_id = $customer_id;

   	  	$extra_fields_query = vam_db_query("select ce.fields_id from " . TABLE_EXTRA_FIELDS . " ce where ce.fields_status=1 ");
    	  while($extra_fields = vam_db_fetch_array($extra_fields_query))
				{
				  if(isset($_POST['fields_' . $extra_fields['fields_id']])){
            $sql_data_array = array('customers_id' => (int)$customers_id,
                              'fields_id' => $extra_fields['fields_id'],
                              'value' => $_POST['fields_' . $extra_fields['fields_id']]);
       		}
       		else
					{
					  $sql_data_array = array('customers_id' => (int)$customers_id,
                              'fields_id' => $extra_fields['fields_id'],
                              'value' => '');
						$is_add = false;
						for($i = 1; $i <= $_POST['fields_' . $extra_fields['fields_id'] . '_total']; $i++)
						{
							if(isset($_POST['fields_' . $extra_fields['fields_id'] . '_' . $i]))
							{
							  if($is_add)
							  {
                  $sql_data_array['value'] .= "\n";
								}
								else
								{
                  $is_add = true;
								}
              	$sql_data_array['value'] .= $_POST['fields_' . $extra_fields['fields_id'] . '_' . $i];
							}
						}
					}

					vam_db_perform(TABLE_CUSTOMERS_TO_EXTRA_FIELDS, $sql_data_array);
      	}

      $sql_data_array = array('customers_id' => $customer_id,
                              'entry_firstname' => $firstname,
                              'entry_secondname' => $secondname,
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
      $customer_last_name = $lastname;
      $customer_email_address = $email_address;
      $customer_default_address_id = $address_id;
      $customer_country_id = $country;
      $customer_zone_id = $zone_id;
      vam_session_register('customer_id');  
      vam_session_register('customer_first_name');
      vam_session_register('customer_last_name');
      vam_session_register('customer_email_address');
      vam_session_register('customer_default_address_id');
      vam_session_register('customer_country_id');
      vam_session_register('customer_zone_id');
      
// #CHAVEIRO14#  Autologon	
        if ((ALLOW_AUTOLOGON == 'false')) {
              vam_autologincookie(false);
		}
        else {
              vam_autologincookie(true);
		}
// #CHAVEIRO14#  Autologon	END
      
	  // Customers Data are stored into to DB table "customers" and "Adress_book"
############################# create_account End process #######################################

      if ($payment_address_selected != '1') { //is unchecked - so payment address is different or if virtual product
        $sql_data_array = array('customers_id' => $customer_id,
                                'entry_firstname' => $firstname_payment,
                                'entry_secondname' => $secondname_payment,
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
if (isset($_POST['payment'])) $_SESSION['payment'] = $_POST['payment'];
############################# process the selected payment method END ######################################

// set them here after $customer_default_address_id is created (ca. line 491)
$_SESSION['sendto'] = $customer_default_address_id;



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

		      $vamTemplate->assign('EMAIL_ADDRESS', $email_address);
		      $vamTemplate->assign('PASSWORD', $password);

			    if ($newsletter) {
			      $vlcode = vam_random_charcode(32);
			      $link = vam_href_link(FILENAME_NEWSLETTER, 'action=activate&email='.$email_address.'&key='.$vlcode, 'NONSSL');
			      $sql_data_array = array ('customers_email_address' => vam_db_input($email_address), 'customers_id' => vam_db_input($customer_id), 'customers_status' => 2, 'customers_firstname' => vam_db_input($firstname), 'customers_lastname' => vam_db_input($lastname), 'mail_status' => '1', 'mail_key' => vam_db_input($vlcode), 'date_added' => 'now()');
			      vam_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);
			      // assign vars
			      $vamTemplate->assign('LINK', $link);
			    } else {
			      $vamTemplate->assign('LINK', false);
			    }	
      
				$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.html');
				$vamTemplate->caching = 0;
				$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.txt');
		
				vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $email_address, $firstname.$lastname, EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', EMAIL_SUPPORT_SUBJECT, $html_mail, $txt_mail);

			  }
		
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

		      $vamTemplate->assign('EMAIL_ADDRESS', $email_address);
		      $vamTemplate->assign('PASSWORD', $password);

			    if ($newsletter) {
			      $vlcode = vam_random_charcode(32);
			      $link = vam_href_link(FILENAME_NEWSLETTER, 'action=activate&email='.$email_address.'&key='.$vlcode, 'NONSSL');
			      $sql_data_array = array ('customers_email_address' => vam_db_input($email_address), 'customers_id' => vam_db_input($customer_id), 'customers_status' => 2, 'customers_firstname' => vam_db_input($firstname), 'customers_lastname' => vam_db_input($lastname), 'mail_status' => '1', 'mail_key' => vam_db_input($vlcode), 'date_added' => 'now()');
			      vam_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);
			      // assign vars
			      $vamTemplate->assign('LINK', $link);
			    } else {
			      $vamTemplate->assign('LINK', false);
			    }	
      
				$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.html');
				$vamTemplate->caching = 0;
				$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.txt');
		
				vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $email_address, $firstname.$lastname, EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', EMAIL_SUPPORT_SUBJECT, $html_mail, $txt_mail);

			  }
		
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
if (isset($_POST['action']) && ($_POST['action'] == 'logged_on') && isset($_POST['formid']) && ($_POST['formid'] == $sessiontoken) && $spam_flag == false) {

	if ($error == false) {
	
	
	############################# process the selected payment method ######################################
	if (isset($_POST['payment'])) $payment = $_POST['payment'];
	if (isset($_POST['payment'])) $_SESSION['payment'] = $_POST['payment'];
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
 
$order_total_modules->process();

###################### payment url redirection START ###################################
//if payment method such as paypal is choosen,  repost process_button data
  if ((isset($$payment->form_action_url)) && ($sc_payment_url == true)) {
		
    $form_action_url = $$payment->form_action_url;
	$payment_fields .= vam_draw_form('checkoutUrl', $form_action_url, 'post');
   
  if (is_array($payment_modules->modules)) {
	$payment_modules->pre_confirmation_check();
  }

  if (is_array($payment_modules->modules)) {
	$payment_modules->confirmation();
  }  
  
  if (is_array($payment_modules->modules)) {
  $payment_fields .= $payment_modules->process_button();
  }

//////////  START  redirection page for payment modules such as paypal if no confirmation page ////////////
if ((isset($$payment->form_action_url)) && ($sc_payment_url == true)) { 

if (is_array($payment_modules->modules)) {
    if ($confirmation = $payment_modules->confirmation()) {

  //$payment_fields .= HEADING_PAYMENT_INFORMATION;

		$payment_fields .= $confirmation['title'];

      for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++) {

      $payment_fields .= $confirmation['fields'][$i]['title'];
      $payment_fields .= $confirmation['fields'][$i]['field'];

      }

    }
  }

$payment_fields .= SC_TEXT_REDIRECT;
$payment_fields .= '</form>';

$payment_fields .= '

<script type="text/javascript">
    document.checkoutUrl.submit();
</script>
<br />
<noscript><input class="btn button"type="submit" value="{$smarty.const.TEXT_CHECKOUT_PROCESS_PAYMENT}" /></noscript>

';

$vamTemplate->assign('PAYMENT_FIELDS', $payment_fields);
   
}
}
//////////  END  redirection page for payment modules such as paypal if no confirmation page ////////////


// vamTemplate Placeholders

$breadcrumb->add(HEADING_TITLE);

if ($messageStack->size('smart_checkout') > 0) {
	$vamTemplate->assign('error', $messageStack->output('smart_checkout'));

}

if (!vam_session_is_registered('customer_id')) {
$vamTemplate->assign('TEXT_ORIGIN_LOGIN', (vam_session_is_registered('customer_id')) ? null : sprintf(TEXT_ORIGIN_LOGIN, vam_href_link(FILENAME_LOGIN, vam_get_all_get_params(), 'SSL')));
}

//Draw form for pressing button "confirm order"
//first check input fields and check for payment choosen
$form_action_url = vam_href_link(FILENAME_CHECKOUT, '', 'SSL');
//$smart_checkout_form .= vam_draw_form('smart_checkout', $form_action_url, 'post', 'onsubmit="return check_form(smart_checkout);"', true);
$smart_checkout_form .= vam_draw_form('smart_checkout', $form_action_url, 'post', '', true);
 
 
// draw process hidden field
if (vam_session_is_registered('customer_id')) {  //logged on - process another action = 'logged_on'
	$smart_checkout_form .= vam_draw_hidden_field('action', 'logged_on');
} else { //is not logged on - process another action = 'process'
	//not logged on
	$smart_checkout_form .= vam_draw_hidden_field('action', 'not_logged_on');
}

$smart_checkout_form .= vam_draw_hidden_field('shipping_count', $shipping_count); //need to post it for validation
$smart_checkout_form .= vam_draw_hidden_field('sc_payment_address_show', $sc_payment_address_show); //need to post it for validation
$smart_checkout_form .= vam_draw_hidden_field('sc_payment_modules_show', $sc_payment_modules_show); //need to post it for validation
$smart_checkout_form .= vam_draw_hidden_field('create_account', $create_account); //need to post it for validation
$smart_checkout_form .= vam_draw_hidden_field('sc_shipping_modules_show', $sc_shipping_modules_show); //need to post it for validation
$smart_checkout_form .= vam_draw_hidden_field('sc_shipping_address_show', $sc_shipping_address_show); //need to post it for validation
$smart_checkout_form .= vam_draw_hidden_field('checkout_possible', $checkout_possible); //need to post it for validation

$vamTemplate->assign('FORM_ACTION', $smart_checkout_form);
$vamTemplate->assign('FORM_END', '</form>');

if ($sc_shipping_address_show == true) { //show shipping options



if (($sc_is_virtual_product == true) && ($sc_is_free_virtual_product == false)) { 
$smart_checkout_title_shipping .= vam_get_sc_titles_number() . TABLE_HEADING_BILLING_ADDRESS; 
} elseif (($sc_is_virtual_product == true) && ($sc_is_free_virtual_product == true)) {
$smart_checkout_title_shipping .=  vam_get_sc_titles_number(). SC_HEADING_CREATE_ACCOUNT_INFORMATION; 
} else {
$smart_checkout_title_shipping .=  vam_get_sc_titles_number() . TABLE_HEADING_SHIPPING_ADDRESS; 
} 

$vamTemplate->assign('TITLE_SHIPPING_ADDRESS', $smart_checkout_title_shipping);

################ START Shipping Information - LOGGED ON ########################################

if (vam_session_is_registered('customer_id')) {

$vamTemplate->assign('ADDRESS_LABEL_SHIPPING_ADDRESS', vam_address_label($customer_id, $_SESSION['sendto'], true, ' ', '<br />'));
$vamTemplate->assign('BUTTON_SHIPPING_ADDRESS', '<a class="button" href="'.vam_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL').'">'.vam_image_button('edit.png', IMAGE_BUTTON_CHANGE_ADDRESS).'</a>');	

} else { //no account
################ END Shipping Information - LOGGED ON ########################################


################ START Shipping Information - NO ACCOUNT ########################################

if (ACCOUNT_GENDER == 'true' or ACCOUNT_GENDER == 'optional') {
	$vamTemplate->assign('gender', '1');

	$vamTemplate->assign('INPUT_MALE', vam_draw_radio_field(array ('name' => 'gender', 'suffix' => MALE.'&nbsp;'), 'm', '', 'class="form-check-input" id="gender" checked="checked"'));
	$vamTemplate->assign('INPUT_FEMALE', vam_draw_radio_field(array ('name' => 'gender', 'suffix' => FEMALE.'&nbsp;', 'text' => (vam_not_null(ENTRY_GENDER_TEXT) ? '<span class="Requirement">'.ENTRY_GENDER_TEXT.'</span>' : '')), 'f', '', 'class="form-check-input" id="gender"'));

} else {
	$vamTemplate->assign('gender', '0');
}

if (ACCOUNT_COMPANY == 'true' or ACCOUNT_COMPANY == 'optional') {
	$vamTemplate->assign('company', '1');
	$vamTemplate->assign('INPUT_COMPANY', vam_draw_input_fieldNote(array ('name' => 'company', 'text' => '&nbsp;'. (vam_not_null(ENTRY_COMPANY_TEXT) ? '<span class="Requirement">'.ENTRY_COMPANY_TEXT.'</span>' : '')),$sc_guest_company));
} else {
	$vamTemplate->assign('company', '0');
}

$vamTemplate->assign('INPUT_FIRSTNAME', vam_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_FIRST_NAME_TEXT.'</span>' : '')), $sc_guest_firstname, 'class="form-control" id="firstname"'));
if (ACCOUNT_SECOND_NAME == 'true' or ACCOUNT_SECOND_NAME == 'optional') {
	$vamTemplate->assign('secondname', '1');
$vamTemplate->assign('INPUT_SECONDNAME', vam_draw_input_fieldNote(array ('name' => 'secondname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_SECOND_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_SECOND_NAME_TEXT.'</span>' : '')), $sc_guest_secondname, 'class="form-control" id="secondname"'));
}
if (ACCOUNT_LAST_NAME == 'true' or ACCOUNT_LAST_NAME == 'optional') {
	$vamTemplate->assign('lastname', '1');
$vamTemplate->assign('INPUT_LASTNAME', vam_draw_input_fieldNote(array ('name' => 'lastname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_LAST_NAME_TEXT.'</span>' : '')), $sc_guest_lastname, 'class="form-control" id="lastname"'));
}
if (ACCOUNT_DOB == 'true' or ACCOUNT_DOB == 'optional') {
	$vamTemplate->assign('birthdate', '1');

	$vamTemplate->assign('INPUT_DOB', vam_draw_input_fieldNote(array ('name' => 'dob', 'text' => '&nbsp;'. (vam_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="Requirement">'.ENTRY_DATE_OF_BIRTH_TEXT.'</span>' : '')), $sc_guest_dob, 'class="form-control" id="dob"'));

} else {
	$vamTemplate->assign('birthdate', '0');
}

if (ACCOUNT_STREET_ADDRESS == 'true' or ACCOUNT_STREET_ADDRESS == 'optional') {
   $vamTemplate->assign('street_address', '1');
   $vamTemplate->assign('INPUT_STREET', vam_draw_input_fieldNote(array ('name' => 'street_address', 'text' => '&nbsp;'. (vam_not_null(ENTRY_SC_STREET_ADDRESS_TEXT) ? '<span class="Requirement">'.ENTRY_SC_STREET_ADDRESS_TEXT.'</span>' : '')), $sc_guest_street_address, 'class="form-control" id="street_address"'));
} else {
	$vamTemplate->assign('street_address', '0');
}

if (ACCOUNT_SUBURB == 'true' or ACCOUNT_SUBURB == 'optional') {
	$vamTemplate->assign('suburb', '1');
	$vamTemplate->assign('INPUT_SUBURB', vam_draw_input_fieldNote(array ('name' => 'suburb', 'text' => '&nbsp;'. (vam_not_null(ENTRY_SUBURB_TEXT) ? '<span class="Requirement">'.ENTRY_SUBURB_TEXT.'</span>' : '')),$sc_guest_suburb));
} else {
	$vamTemplate->assign('suburb', '0');
}

if (ACCOUNT_POSTCODE == 'true'or ACCOUNT_POSTCODE == 'optional') {
   $vamTemplate->assign('postcode', '1');
   $vamTemplate->assign('INPUT_CODE', vam_draw_input_fieldNote(array ('name' => 'postcode', 'text' => '&nbsp;'. (vam_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="Requirement">'.ENTRY_POST_CODE_TEXT.'</span>' : '')), $sc_guest_postcode, 'class="form-control" id="postcode"'));
} else {
	$vamTemplate->assign('postcode', '0');
}

if (ACCOUNT_CITY == 'true' or ACCOUNT_CITY == 'optional') {
   $vamTemplate->assign('city', '1');
   $vamTemplate->assign('INPUT_CITY', vam_draw_input_fieldNote(array ('name' => 'city', 'text' => '&nbsp;'. (vam_not_null(ENTRY_CITY_TEXT) ? '<span class="Requirement">'.ENTRY_CITY_TEXT.'</span>' : '')), $sc_guest_city, 'class="form-control" id="city"'));
} else {
	$vamTemplate->assign('city', '0');
}

if (ACCOUNT_STATE == 'true' or ACCOUNT_STATE == 'optional') {
	$vamTemplate->assign('state', '1');

	    $country = (isset($_POST['country']) ? vam_db_prepare_input($_POST['country']) : STORE_COUNTRY);
	    $zone_id = 0;
		 $check_query = vam_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".(int) $country."'");
		 $check = vam_db_fetch_array($check_query);
		 $entry_state_has_zones = ($check['total'] > 0);
		 if ($entry_state_has_zones == true) {
			$zones_array = array ();
			$zones_query = vam_db_query("select zone_name from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' order by zone_name");
			while ($zones_values = vam_db_fetch_array($zones_query)) {
				$zones_array[] = array ('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
			}

		}

      if ($entry_state_has_zones == true) {
        $state_input = vam_draw_pull_down_menuNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), $zones_array, (isset($state)) ? $state : vam_get_zone_name(STORE_COUNTRY, STORE_ZONE,''), ' class="form-control" id="state"');
      } else {
		$state_input = vam_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), '', 'class="form-control" id="state"');
      }

	$vamTemplate->assign('INPUT_STATE', $state_input);
} else {
	$vamTemplate->assign('state', '0');
}

if (ACCOUNT_COUNTRY == 'true' or ACCOUNT_COUNTRY == 'optional') {
	$vamTemplate->assign('country', '1');

   $vamTemplate->assign('SELECT_COUNTRY', vam_get_country_list(array ('name' => 'country', 'text' => '&nbsp;'. (vam_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="Requirement">'.ENTRY_COUNTRY_TEXT.'</span>' : '')), $selected_country_id, 'class="form-control" id="country"'));

} else {
	$vamTemplate->assign('country', '0');
}

} //end no account
################ END Shipping Information - NO ACCOUNT ########################################


} //END show shipping otpions 

if ($sc_payment_address_show == true) { // hide payment if there is a virtual product because we use shipping address for payment address

$vamTemplate->assign('sc_payment_address_show', $sc_payment_address_show);

$vamTemplate->assign('TITLE_PAYMENT_ADDRESS', vam_get_sc_titles_number() . TABLE_HEADING_BILLING_ADDRESS);

################ START Payment Information - LOGGED ON ########################################

if (vam_session_is_registered('customer_id')) {
	
$vamTemplate->assign('ADDRESS_LABEL_PAYMENT_ADDRESS', vam_address_label($customer_id, $billto, true, ' ', '<br />'));
$vamTemplate->assign('BUTTON_PAYMENT_ADDRESS', '<a class="button" href="' . vam_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL') . '">' . vam_image_button('edit.png', IMAGE_BUTTON_CHANGE_ADDRESS) . '</a>');	

} else { //no account

################ END Payment Information - LOGGED ON ########################################


################ START Payment Information - NO ACCOUNT ######################################## 

   if (($error == '1') && ($payment_address_selected != '1')) { //is not selected - otherwise payment address is same as shipping address
        
        $vamTemplate->assign('PAYMENT_ADDRESS_CHECKBOX', vam_draw_checkbox_field('payment_adress', '1', false, 'class="form-check-input" id="pay_show"') . '&nbsp;' . (vam_not_null(ENTRY_NEWSLETTER_TEXT) ? '<span class="inputRequirement">' . ENTRY_NEWSLETTER_TEXT . '</span>': ''));
        
        } else { //is selected
        
        $vamTemplate->assign('PAYMENT_ADDRESS_CHECKBOX', vam_draw_checkbox_field('payment_adress', '1', true, 'class="form-check-input" id="pay_show"') . '&nbsp;' . (vam_not_null(ENTRY_NEWSLETTER_TEXT) ? '<span class="inputRequirement">' . ENTRY_NEWSLETTER_TEXT . '</span>': ''));
        
        }


if (ACCOUNT_GENDER == 'true' or ACCOUNT_GENDER == 'optional') {
	$vamTemplate->assign('gender_payment', '1');

	$vamTemplate->assign('INPUT_MALE_PAYMENT', vam_draw_radio_field(array ('name' => 'gender_payment', 'suffix' => MALE.'&nbsp;'), 'm', '', 'class="form-check-input" id="gender_payment" checked="checked"'));
	$vamTemplate->assign('INPUT_FEMALE_PAYMENT', vam_draw_radio_field(array ('name' => 'gender_payment', 'suffix' => FEMALE.'&nbsp;', 'text' => (vam_not_null(ENTRY_GENDER_TEXT) ? '<span class="Requirement">'.ENTRY_GENDER_TEXT.'</span>' : '')), 'f', '', 'class="form-check-input" id="gender_payment"'));

} else {
	$vamTemplate->assign('gender_payment', '0');
}

if (ACCOUNT_COMPANY == 'true' or ACCOUNT_COMPANY == 'optional') {
	$vamTemplate->assign('company_payment', '1');
	$vamTemplate->assign('INPUT_COMPANY_PAYMENT', vam_draw_input_fieldNote(array ('name' => 'company_payment', 'text' => '&nbsp;'. (vam_not_null(ENTRY_COMPANY_TEXT) ? '<span class="Requirement">'.ENTRY_COMPANY_TEXT.'</span>' : '')),$sc_guest_company));
} else {
	$vamTemplate->assign('company_payment', '0');
}

$vamTemplate->assign('INPUT_FIRSTNAME_PAYMENT', vam_draw_input_fieldNote(array ('name' => 'firstname_payment', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_FIRST_NAME_TEXT.'</span>' : '')), $sc_guest_firstname, 'class="form-control" id="firstname_payment"'));
if (ACCOUNT_SECOND_NAME == 'true' or ACCOUNT_SECOND_NAME == 'optional') {
	$vamTemplate->assign('secondname_payment', '1');
$vamTemplate->assign('INPUT_SECONDNAME_PAYMENT', vam_draw_input_fieldNote(array ('name' => 'secondname_payment', 'text' => '&nbsp;'. (vam_not_null(ENTRY_SECOND_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_SECOND_NAME_TEXT.'</span>' : '')), $sc_guest_secondname, 'class="form-control" id="secondname_payment"'));
}
if (ACCOUNT_LAST_NAME == 'true' or ACCOUNT_LAST_NAME == 'optional') {
	$vamTemplate->assign('lastname_payment', '1');
$vamTemplate->assign('INPUT_LASTNAME_PAYMENT', vam_draw_input_fieldNote(array ('name' => 'lastname_payment', 'text' => '&nbsp;'. (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_LAST_NAME_TEXT.'</span>' : '')), $sc_guest_lastname, 'class="form-control" id="lastname_payment"'));
}
if (ACCOUNT_DOB == 'true' or ACCOUNT_DOB == 'optional') {
	$vamTemplate->assign('birthdate_payment', '1');

	$vamTemplate->assign('INPUT_DOB_PAYMENT', vam_draw_input_fieldNote(array ('name' => 'dob_payment', 'text' => '&nbsp;'. (vam_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="Requirement">'.ENTRY_DATE_OF_BIRTH_TEXT.'</span>' : '')), $sc_guest_dob, 'class="form-control" id="dob_payment"'));

} else {
	$vamTemplate->assign('birthdate_payment', '0');
}

if (ACCOUNT_STREET_ADDRESS == 'true' or ACCOUNT_STREET_ADDRESS == 'optional') {
   $vamTemplate->assign('street_address_payment', '1');
   $vamTemplate->assign('INPUT_STREET_PAYMENT', vam_draw_input_fieldNote(array ('name' => 'street_address_payment', 'text' => '&nbsp;'. (vam_not_null(ENTRY_SC_STREET_ADDRESS_TEXT) ? '<span class="Requirement">'.ENTRY_SC_STREET_ADDRESS_TEXT.'</span>' : '')), $sc_guest_street_address, 'class="form-control" id="street_address_payment"'));
} else {
	$vamTemplate->assign('street_address_payment', '0');
}

if (ACCOUNT_SUBURB == 'true' or ACCOUNT_SUBURB == 'optional') {
	$vamTemplate->assign('suburb_payment', '1');
	$vamTemplate->assign('INPUT_SUBURB_PAYMENT', vam_draw_input_fieldNote(array ('name' => 'suburb_payment', 'text' => '&nbsp;'. (vam_not_null(ENTRY_SUBURB_TEXT) ? '<span class="Requirement">'.ENTRY_SUBURB_TEXT.'</span>' : '')),$sc_guest_suburb));
} else {
	$vamTemplate->assign('suburb_payment', '0');
}

if (ACCOUNT_POSTCODE == 'true' or ACCOUNT_POSTCODE == 'optional') {
   $vamTemplate->assign('postcode_payment', '1');
   $vamTemplate->assign('INPUT_CODE_PAYMENT', vam_draw_input_fieldNote(array ('name' => 'postcode_payment', 'text' => '&nbsp;'. (vam_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="Requirement">'.ENTRY_POST_CODE_TEXT.'</span>' : '')), $sc_guest_postcode, 'class="form-control" id="postcode_payment"'));
} else {
	$vamTemplate->assign('postcode_payment', '0');
}

if (ACCOUNT_CITY == 'true' or ACCOUNT_CITY == 'optional') {
   $vamTemplate->assign('city_payment', '1');
   $vamTemplate->assign('INPUT_CITY_PAYMENT', vam_draw_input_fieldNote(array ('name' => 'city_payment', 'text' => '&nbsp;'. (vam_not_null(ENTRY_CITY_TEXT) ? '<span class="Requirement">'.ENTRY_CITY_TEXT.'</span>' : '')), $sc_guest_city, 'class="form-control" id="city_payment"'));
} else {
	$vamTemplate->assign('city_payment', '0');
}

if (ACCOUNT_STATE == 'true' or ACCOUNT_STATE == 'optional') {
	$vamTemplate->assign('state_payment', '1');

	    $country = (isset($_POST['country']) ? vam_db_prepare_input($_POST['country']) : STORE_COUNTRY);
	    $zone_id = 0;
		 $check_query = vam_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".(int) $country."'");
		 $check = vam_db_fetch_array($check_query);
		 $entry_state_has_zones = ($check['total'] > 0);
		 if ($entry_state_has_zones == true) {
			$zones_array = array ();
			$zones_query = vam_db_query("select zone_name from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' order by zone_name");
			while ($zones_values = vam_db_fetch_array($zones_query)) {
				$zones_array[] = array ('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
			}

		}

      if ($entry_state_has_zones == true) {
        $state_input = vam_draw_pull_down_menuNote(array ('name' => 'state_payment', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), $zones_array, (isset($state)) ? $state : vam_get_zone_name(STORE_COUNTRY, STORE_ZONE,''), ' class="form-control" id="state_payment"');
      } else {
		$state_input = vam_draw_input_fieldNote(array ('name' => 'state_payment', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), '', 'class="form-control" id="state_payment"');
      }

	$vamTemplate->assign('INPUT_STATE_PAYMENT', $state_input);
} else {
	$vamTemplate->assign('state_payment', '0');
}

if (ACCOUNT_COUNTRY == 'true' or ACCOUNT_COUNTRY == 'optional') {
	$vamTemplate->assign('country_payment', '1');

   $vamTemplate->assign('SELECT_COUNTRY_PAYMENT', vam_get_country_list(array ('name' => 'country_payment', 'text' => '&nbsp;'. (vam_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="Requirement">'.ENTRY_COUNTRY_TEXT.'</span>' : '')), $selected_country_id, 'class="form-control" id="country_payment"'));

} else {
	$vamTemplate->assign('country_payment', '0');
}


} //end no account
} //END hide payment if there is a virtual product because we use shipping address for payment address
################ END Payment Information - NO ACCOUNT ########################################

if (!vam_session_is_registered('customer_id')) { //IS NOT LOGGED ON
################ START Contact Information - NO ACCOUNT ########################################

$vamTemplate->assign('TITLE_CONTACT_ADDRESS', vam_get_sc_titles_number() . CATEGORY_CONTACT.vam_draw_hidden_field('guest', 'guest'));

if (ACCOUNT_EMAIL == 'true' or ACCOUNT_EMAIL == 'optional') {
	$vamTemplate->assign('email', '1');
$vamTemplate->assign('INPUT_EMAIL', vam_draw_input_fieldNote(array ('name' => 'email_address', 'text' => '&nbsp;'. (vam_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="Requirement">'.ENTRY_EMAIL_ADDRESS_TEXT.'</span>' : '')), $sc_guest_email_address, 'class="form-control" id="email_address"'));
}

if (ACCOUNT_TELE == 'true' or ACCOUNT_TELE == 'optional') {
   $vamTemplate->assign('telephone', '1');
   $vamTemplate->assign('INPUT_TEL', vam_draw_input_fieldNote(array ('name' => 'telephone', 'text' => '&nbsp;'. (vam_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="Requirement">'.ENTRY_TELEPHONE_NUMBER_TEXT.'</span>' : '')), $sc_guest_telephone, 'class="form-control" id="telephone"'));
} else {
	$vamTemplate->assign('telephone', '0');
}

if (ACCOUNT_FAX == 'true' or ACCOUNT_FAX == 'optional') {
   $vamTemplate->assign('fax', '1');
   $vamTemplate->assign('INPUT_FAX', vam_draw_input_fieldNote(array ('name' => 'fax', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="Requirement">'.ENTRY_FAX_NUMBER_TEXT.'</span>' : '')),$sc_guest_fax));
} else {
	$vamTemplate->assign('fax', '0');
}

	$vamTemplate->assign('customers_extra_fileds', '1');
   $vamTemplate->assign('INPUT_CUSTOMERS_EXTRA_FIELDS', vam_get_extra_fields($_SESSION['customer_id'],$_SESSION['languages_id']));
   
################ END Contact Information - NO ACCOUNT ######################################## 
} //End IS NOT LOGGED ON


################ START Password - NO ACCOUNT ########################################
//if ($create_account == true) { 
 if (!vam_session_is_registered('customer_id')) { //IS NOT LOGGED ON 

  if (($sc_is_virtual_product == true) || ($sc_is_mixed_product == true) || (SC_CREATE_ACCOUNT_REQUIRED == 'true') || (SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true')) {

$vamTemplate->assign('TITLE_CONTACT_PASSWORD', vam_get_sc_titles_number() . SC_HEADING_CREATE_ACCOUNT);

$vamTemplate->assign('TEXT_CONTACT_PASSWORD', SC_TEXT_PASSWORD_REQUIRED); //show message that you need to create an account


################ START Password - optional ######################################## 
if (SC_CREATE_ACCOUNT_REQUIRED == 'true') {
	//show nothing
//} elseif ((SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true') && (($sc_is_virtual_product != true) || ($sc_is_mixed_product != true))) {
} elseif (SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true') {
	if (($sc_is_virtual_product == true) || ($sc_is_mixed_product == true)) {
	} else {  

if (($error == '1') && ($password_selected != '1')) { //is not selected
        
$vamTemplate->assign('PASSWORD_CHECKBOX', vam_draw_checkbox_field('password_checkbox', '1', false, 'class="form-check-input" id="pw_show"') . '&nbsp;&nbsp;' . TEXT_CREATE_ACCOUNT_OPTIONAL);
        
} else { //is selected
        
$vamTemplate->assign('PASSWORD_CHECKBOX', vam_draw_checkbox_field('password_checkbox', '1', true, 'class="form-check-input" id="pw_show"') . '&nbsp;&nbsp;' . TEXT_CREATE_ACCOUNT_OPTIONAL);
        
        }

}
} ################ End Password - optional ########################################
	$vamTemplate->assign('create_password', 1);
	$vamTemplate->assign('INPUT_PASSWORD', vam_draw_password_fieldNote(array ('name' => 'password', 'text' => '&nbsp;'. (vam_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="Requirement">'.ENTRY_PASSWORD_TEXT.'</span>' : '')), '', 'class="form-control" id="pass"'));
	$vamTemplate->assign('INPUT_CONFIRMATION', vam_draw_password_fieldNote(array ('name' => 'confirmation', 'text' => '&nbsp;'. (vam_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="Requirement">'.ENTRY_PASSWORD_CONFIRMATION_TEXT.'</span>' : '')), '', 'class="form-control" id="confirmation"'));

 } //end (($sc_is_virtual_product == true) || ($sc_is_mixed_product == true))
} //End IS NOT LOGGED ON 
################ END Password - NO ACCOUNT ########################################

################ START Shipping Modules ########################################
$vamTemplate->assign('shipping', true);     
if ($sc_shipping_modules_show == true) { //hide shipping modules - used for virtual products

if ((SC_HIDE_SHIPPING == 'true') && (vam_count_shipping_modules() <= 1)) { 
//if 0 or 1 shipping method and in admin hide shipping is set to true, hide shipping box 
//but we still need the divs in order to work with jquery update

$vamTemplate->assign('shipping', false);     

} //end hide shipping modules
else { // show shipping modules

$vamTemplate->assign('TITLE_SHIPPING_MODULES', vam_get_sc_titles_number() . TABLE_HEADING_SHIPPING_METHOD);

$module = new vamTemplate;

if (vam_count_shipping_modules() > 0) {

	$showtax = $_SESSION['customers_status']['customers_status_show_price_tax'];

	$module->assign('FREE_SHIPPING', $free_shipping);

	# free shipping or not...

	if ($free_shipping == true) {

		$module->assign('FREE_SHIPPING_TITLE', FREE_SHIPPING_TITLE);

		$module->assign('FREE_SHIPPING_DESCRIPTION', sprintf(FREE_SHIPPING_DESCRIPTION, $vamPrice->Format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER, true, 0, true)).vam_draw_hidden_field('shipping', 'free_free'));

		$module->assign('FREE_SHIPPING_ICON', '');

	} else {

		$radio_buttons = 0;
		for ($i = 0, $n = sizeof($quotes); $i < $n; $i ++) {

			if (!isset ($quotes[$i]['error'])) {

				for ($j = 0, $n2 = sizeof($quotes[$i]['methods']); $j < $n2; $j ++) {

					# set the radio button to be checked if it is the method chosen

					$quotes[$i]['methods'][$j]['radio_buttons'] = $radio_buttons;

					$checked = (($quotes[$i]['id'].'_'.$quotes[$i]['methods'][$j]['id'] == $_SESSION['shipping']['id']) ? true : false);

					if (($checked == true) || ($n == 1 && $n2 == 1)) {

						$quotes[$i]['methods'][$j]['checked'] = 1;

					}

					if (($n >= 1) || ($n2 >= 1)) {
						if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0)
							$quotes[$i]['tax'] = '';
						if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0)
							$quotes[$i]['tax'] = 0;

						$quotes[$i]['methods'][$j]['price'] = $vamPrice->Format(vam_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax']), true, 0, true);

						$quotes[$i]['methods'][$j]['radio_field'] = vam_draw_radio_field('shipping', $quotes[$i]['id'].'_'.$quotes[$i]['methods'][$j]['id'], $checked,'class="form-check-input" id="'.$quotes[$i]['methods'][$j]['id'].'"');
						$quotes[$i]['methods'][$j]['id'] = $quotes[$i]['methods'][$j]['id'];

					} else {
						if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0)
							$quotes[$i]['tax'] = 0;

						$quotes[$i]['methods'][$j]['price'] = $vamPrice->Format(vam_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax']), true, 0, true).vam_draw_hidden_field('shipping', $quotes[$i]['id'].'_'.$quotes[$i]['methods'][$j]['id']);

					}

					$radio_buttons ++;

				}

			}

		}

		$module->assign('module_content', $quotes);

	}
	$module->caching = 0;
	$shipping_block = $module->fetch(CURRENT_TEMPLATE.'/module/checkout_shipping_block.html');

  } //end (vam_count_shipping_modules()
$vamTemplate->assign('SHIPPING_BLOCK', $shipping_block);

   } // end hide shipping 
  
} //END hide shipping modules - used for virtual products
################ END Shipping Modules ########################################

################ START Payment Modules ######################################## 
if ($sc_payment_modules_show == true) { // hide payment modules

$vamTemplate->assign('TITLE_PAYMENT_MODULES', vam_get_sc_titles_number() . TABLE_HEADING_PAYMENT_METHOD);

if ($sc_payment_modules_process == true) {

$module = new vamTemplate;
	if (isset ($_GET['payment_error']) && is_object(${ $_GET['payment_error'] }) && ($error = ${$_GET['payment_error']}->get_error())) {

		$vamTemplate->assign('error', htmlspecialchars($error['error']));

	}

	$selection = $payment_modules->selection();

	$radio_buttons = 0;
	for ($i = 0, $n = sizeof($selection); $i < $n; $i++) {

		$selection[$i]['radio_buttons'] = $radio_buttons;
		if (($selection[$i]['id'] == $payment) || ($n == 1)) {
			$selection[$i]['checked'] = 1;
		}

		if (sizeof($selection) > 1) {
			$selection[$i]['selection'] = vam_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $selection[0]['id']), 'class="form-check-input" id="'.$selection[$i]['id'].'"');
		} else {
			$selection[$i]['selection'] = vam_draw_hidden_field('payment', $selection[$i]['id']);
		}

			$selection[$i]['id'] = $selection[$i]['id'];

		if (isset ($selection[$i]['error'])) {

		} else {

			$radio_buttons++;
		}
	}

	$module->assign('module_content', $selection);

$module->caching = 0;
$payment_block = $module->fetch(CURRENT_TEMPLATE . '/module/checkout_payment_block.html');

$vamTemplate->assign('PAYMENT_BLOCK', $payment_block);

} // End sc_payment_modules_process

} //End hide payment modules
################ END Payment Modules ######################################## 

################ START Comment box ########################################
$vamTemplate->assign('comments', 0);     
if (SC_HIDE_COMMENT != 'true') {
$vamTemplate->assign('comments', 1);     
$vamTemplate->assign('TITLE_COMMENTS', vam_get_sc_titles_number() . TABLE_HEADING_COMMENTS);
$vamTemplate->assign('COMMENTS', vam_draw_textarea_field('comments', 'soft', '60', '5', $comments));
}
################ END Comment box ########################################




################ START Order Total Modules ########################################

$vamTemplate->assign('TITLE_TOTALS', vam_get_sc_titles_number() . HEADING_TOTAL);
    
if (MODULE_ORDER_TOTAL_INSTALLED) {
$vamTemplate->assign('ORDER_TOTALS', $order_total_modules->output());
}

################ END Order Total Modules ########################################

################ START Conditions of Use ######################################## 
$vamTemplate->assign('conditions', 'false');

if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') { // customers must check checkbox to proceed

$vamTemplate->assign('conditions', 'true');

$vamTemplate->assign('AGB_LINK', $main->getContentLink(3, SC_HEADING_CONDITIONS));
$vamTemplate->assign('AGB_checkbox', vam_draw_checkbox_field('conditions','1', true));

}
################ END Conditions of Use ########################################


$data_products = '<table border="0" cellspacing="0" cellpadding="0">';
for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {

	$data_products .= '<tr>' . "\n" . '            <td class="main" align="left" valign="top">' . $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . '</td>' . "\n" . '                <td class="main" align="right" valign="top">' . $vamPrice->Format($order->products[$i]['final_price'], true) . '</td></tr>' . "\n";
	if (ACTIVATE_SHIPPING_STATUS == 'true') {

		$data_products .= '<tr>
							<td class="main" align="left" valign="top">
							<small>' . SHIPPING_TIME . $order->products[$i]['shipping_time'] . '
							</small></td>
							<td class="main" align="right" valign="top">&nbsp;</td></tr>';

	}
	if ((isset ($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0)) {
		for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++) {
			$data_products .= '<tr>
								<td class="main" align="left" valign="top">
								<small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . '
								</i></small></td>
								<td class="main" align="right" valign="top">&nbsp;</td></tr>';
		}
	}

	$data_products .= '' . "\n";

	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		if (sizeof($order->info['tax_groups']) > 1)
			$data_products .= '            <td class="main" valign="top" align="right">' . vam_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n";
	}
	$data_products .= '</tr>' . "\n";
}
$data_products .= '</table>';
$vamTemplate->assign('PRODUCTS_BLOCK', $data_products);

if (ACTIVATE_GIFT_SYSTEM == 'true') {
	$vamTemplate->assign('module_gift', $order_total_modules->credit_selection());
}

if (SC_CONFIRMATION_PAGE == 'true') { //got to confimration page
$vamTemplate->assign('BUTTON_CONTINUE', vam_image_submit('submit.png', IMAGE_BUTTON_CONTINUE));
} else {
$vamTemplate->assign('BUTTON_CONTINUE', vam_image_submit('submit.png', IMAGE_BUTTON_CHECKOUT));
}

require (DIR_WS_INCLUDES.'header.php');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/checkout.html');
$vamTemplate->assign('main_content', $main_content);
if (!defined(RM))$vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_CHECKOUT.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_CHECKOUT.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>