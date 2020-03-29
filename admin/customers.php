<?php
/* --------------------------------------------------------------
   $Id: customers.php 1296 2013-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(customers.php,v 1.76 2003/05/04); www.oscommerce.com 
   (c) 2003	 nextcommerce (customers.php,v 1.22 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (customers.php,v 1.22 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------
   Third Party contribution:
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   --------------------------------------------------------------*/

require ('includes/application_top.php');
require_once (DIR_FS_INC.'vam_validate_vatid_status.inc.php');
require_once (DIR_FS_INC.'vam_get_geo_zone_code.inc.php');
require_once (DIR_FS_INC.'vam_encrypt_password.inc.php');
require_once (DIR_FS_INC.'vam_js_lang.php');

$customers_statuses_array = vam_get_customers_statuses();

if ($_GET['special'] == 'remove_memo') {
	$mID = vam_db_prepare_input($_GET['mID']);
	vam_db_query("DELETE FROM ".TABLE_CUSTOMERS_MEMO." WHERE memo_id = '".$mID."'");
	vam_redirect(vam_href_link(FILENAME_CUSTOMERS, 'cID='.(int) $_GET['cID'].'&action=edit'));
}


if ($_GET['special'] == 'remove_discount') {
	$mID = vam_db_prepare_input($_GET['mID']);
	vam_db_query("DELETE FROM ".TABLE_CUSTOMERS_TO_MANUFACTURERS_DISCOUNT." WHERE discount_id = '".$mID."'");
	vam_redirect(vam_href_link(FILENAME_CUSTOMERS, 'cID='.(int) $_GET['cID'].'&action=edit'));
}

if ($_GET['action'] == 'edit' || $_GET['action'] == 'update') {
	if ($_GET['cID'] == 1 && $_SESSION['customer_id'] == 1) {
	} else {
		if ($_GET['cID'] != 1) {
		} else {
			vam_redirect(vam_href_link(FILENAME_CUSTOMERS, ''));
		}
	}
}

// Start Batch Delete
if (isset($_POST['submit']) && isset($_POST['multi_customers'])){
	
// delete customers
 
 if (($_POST['submit'] == BUTTON_SUBMIT)){

  foreach ($_POST['multi_customers'] as $this_customerID){

    $customers_deleted = false;
			if ($this_customerID != 1) {
			vam_db_query("delete from ".TABLE_ADDRESS_BOOK." where customers_id = '".vam_db_input($this_customerID)."'");
			vam_db_query("delete from ".TABLE_CUSTOMERS." where customers_id = '".vam_db_input($this_customerID)."'");
			vam_db_query("delete from ".TABLE_CUSTOMERS_INFO." where customers_info_id = '".vam_db_input($this_customerID)."'");
			vam_db_query("delete from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".vam_db_input($this_customerID)."'");
			vam_db_query("delete from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where customers_id = '".vam_db_input($this_customerID)."'");
			vam_db_query("delete from ".TABLE_PRODUCTS_NOTIFICATIONS." where customers_id = '".vam_db_input($this_customerID)."'");
			vam_db_query("delete from ".TABLE_WHOS_ONLINE." where customer_id = '".vam_db_input($this_customerID)."'");
			vam_db_query("delete from ".TABLE_CUSTOMERS_STATUS_HISTORY." where customers_id = '".vam_db_input($this_customerID)."'");
			vam_db_query("delete from ".TABLE_CUSTOMERS_IP." where customers_id = '".vam_db_input($this_customerID)."'");
			vam_db_query("DELETE FROM ".TABLE_ADMIN_ACCESS." WHERE customers_id = '".vam_db_input($this_customerID)."'");

			vam_db_query("delete from " . TABLE_CUSTOMERS_TO_EXTRA_FIELDS . " where customers_id=" . (int)$this_customerID);

          $customers_deleted = true;
         }

        if ($customers_deleted == true) {
         $messageStack->add_session(BUS_CUSTOMER . $this_customerID . ' ' . BUS_DELETE_SUCCESS, 'success');
        } else {
          $messageStack->add_session(BUS_CUSTOMER . $this_customerID . ' ' . BUS_DELETE_WARNING, 'warning');
        }
  } // End foreach ID loop
 }

// /delete customers

   vam_redirect(vam_href_link(FILENAME_CUSTOMERS),vam_get_all_get_params());
}
// End Batch Delete

if ($_GET['action']) {
	switch ($_GET['action']) {
		case 'new_order' :

			$customers1_query = vam_db_query("select * from ".TABLE_CUSTOMERS." where customers_id = '".$_GET['cID']."'");
			$customers1 = vam_db_fetch_array($customers1_query);

			$customers_query = vam_db_query("select * from ".TABLE_ADDRESS_BOOK." where customers_id = '".$_GET['cID']."'");
			$customers = vam_db_fetch_array($customers_query);

			$country_query = vam_db_query("select countries_name from ".TABLE_COUNTRIES." where status='1' and countries_id = '".$customers['entry_country_id']."'");
			$country = vam_db_fetch_array($country_query);

			$stat_query = vam_db_query("select * from ".TABLE_CUSTOMERS_STATUS." where customers_status_id = '".$customers1[customers_status]."' ");
			$stat = vam_db_fetch_array($stat_query);

			$sql_data_array = array ('customers_id' => vam_db_prepare_input($customers['customers_id']), 'customers_cid' => vam_db_prepare_input($customers1['customers_cid']), 'customers_vat_id' => vam_db_prepare_input($customers1['customers_vat_id']), 'customers_status' => vam_db_prepare_input($customers1['customers_status']), 'customers_status_name' => vam_db_prepare_input($stat['customers_status_name']), 'customers_status_image' => vam_db_prepare_input($stat['customers_status_image']), 'customers_status_discount' => vam_db_prepare_input($customers1[customers_personal_discount] ? $customers1[customers_personal_discount] : $stat['customers_status_discount']), 'customers_name' => vam_db_prepare_input($customers['entry_firstname'].' '.$customers['entry_secondname'].' '.$customers['entry_lastname']), 'customers_company' => vam_db_prepare_input($customers['entry_company']), 'customers_street_address' => vam_db_prepare_input($customers['entry_street_address']), 'customers_suburb' => vam_db_prepare_input($customers['entry_suburb']), 'customers_city' => vam_db_prepare_input($customers['entry_city']), 'customers_postcode' => vam_db_prepare_input($customers['entry_postcode']), 'customers_state' => vam_db_prepare_input($customers['entry_state']), 'customers_country' => vam_db_prepare_input($country['countries_name']), 'customers_telephone' => vam_db_prepare_input($customers1['customers_telephone']), 'customers_email_address' => vam_db_prepare_input($customers1['customers_email_address']), 'customers_address_format_id' => '5', 'customers_ip' => '0', 'delivery_name' => vam_db_prepare_input($customers['entry_firstname'].' '.$customers['entry_secondname'].' '.$customers['entry_lastname']), 'delivery_company' => vam_db_prepare_input($customers['entry_company']), 'delivery_street_address' => vam_db_prepare_input($customers['entry_street_address']), 'delivery_suburb' => vam_db_prepare_input($customers['entry_suburb']), 'delivery_city' => vam_db_prepare_input($customers['entry_city']), 'delivery_postcode' => vam_db_prepare_input($customers['entry_postcode']), 'delivery_state' => vam_db_prepare_input($customers['entry_state']), 'delivery_country' => vam_db_prepare_input($country['countries_name']), 'delivery_address_format_id' => '5', 'billing_name' => vam_db_prepare_input($customers['entry_firstname'].' '.$customers['entry_secondname'].' '.$customers['entry_lastname']), 'billing_company' => vam_db_prepare_input($customers['entry_company']), 'billing_street_address' => vam_db_prepare_input($customers['entry_street_address']), 'billing_suburb' => vam_db_prepare_input($customers['entry_suburb']), 'billing_city' => vam_db_prepare_input($customers['entry_city']), 'billing_postcode' => vam_db_prepare_input($customers['entry_postcode']), 'billing_state' => vam_db_prepare_input($customers['entry_state']), 'billing_country' => vam_db_prepare_input($country['countries_name']), 'billing_address_format_id' => '5', 'payment_method' => 'cod', 'cc_type' => '', 'cc_owner' => '', 'cc_number' => '', 'cc_expires' => '', 'cc_start' => '', 'cc_issue' => '', 'cc_cvv' => '', 'comments' => '', 'last_modified' => 'now()', 'date_purchased' => 'now()', 'orders_status' => '1', 'orders_date_finished' => '', 'currency' => DEFAULT_CURRENCY, 'currency_value' => '1.0000', 'account_type' => '0', 'payment_class' => 'cod', 'shipping_method' => SHIPPING_FLAT, 'shipping_class' => 'flat_flat', 'customers_ip' => '', 'language' => $_SESSION['language']);
			$insert_sql_data = array ('currency_value' => '1.0000');
			$sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
			vam_db_perform(TABLE_ORDERS, $sql_data_array);
			$orders_id = vam_db_insert_id();

			$sql_data_array = array ('orders_id' => $orders_id, 'title' => ORDER_TOTAL, 'text' => '0', 'value' => '0', 'class' => 'ot_total');

			$insert_sql_data = array ('sort_order' => MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER);
			$sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
			vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

			$sql_data_array = array ('orders_id' => $orders_id, 'title' => ORDER_SUBTOTAL, 'text' => '0', 'value' => '0', 'class' => 'ot_subtotal');

			$insert_sql_data = array ('sort_order' => MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER);
			$sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
			vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

			vam_redirect(vam_href_link(FILENAME_ORDERS, 'oID='.$orders_id.'&action=edit'));

			break;
		case 'statusconfirm' :
			$customers_id = vam_db_prepare_input($_GET['cID']);
			$customer_updated = false;
			$check_status_query = vam_db_query("select customers_firstname, customers_secondname, customers_lastname, customers_email_address , customers_status, member_flag from ".TABLE_CUSTOMERS." where customers_id = '".vam_db_input($_GET['cID'])."'");
			$check_status = vam_db_fetch_array($check_status_query);
			if ($check_status['customers_status'] != $status) {
				vam_db_query("update ".TABLE_CUSTOMERS." set customers_status = '".vam_db_input($_POST['status'])."' where customers_id = '".vam_db_input($_GET['cID'])."'");
				
				vam_db_query("update ".TABLE_NEWSLETTER_RECIPIENTS." set customers_status = '".vam_db_input($_POST['status'])."' where customers_id = '".vam_db_input($_GET['cID'])."'");

				// create insert for admin access table if customers status is set to 0
				if ($_POST['status'] == 0) {
               $q = vam_db_query("select * from ".TABLE_ADMIN_ACCESS." where customers_id='".vam_db_input($_GET['cID'])."'");
               if (!vam_db_num_rows($q))					
					vam_db_query("INSERT into ".TABLE_ADMIN_ACCESS." (customers_id,start) VALUES ('".vam_db_input($_GET['cID'])."','1')");
				} else {
					vam_db_query("DELETE FROM ".TABLE_ADMIN_ACCESS." WHERE customers_id = '".vam_db_input($_GET['cID'])."'");

				}
				//Temporarily set due to above commented lines
				$customer_notified = '0';
				vam_db_query("insert into ".TABLE_CUSTOMERS_STATUS_HISTORY." (customers_id, new_value, old_value, date_added, customer_notified) values ('".vam_db_input($_GET['cID'])."', '".vam_db_input($_POST['status'])."', '".$check_status['customers_status']."', now(), '".$customer_notified."')");
				$customer_updated = true;
			}
			vam_redirect(vam_href_link(FILENAME_CUSTOMERS, 'page='.$_GET['page'].'&cID='.$_GET['cID']));
			break;

		case 'update' :
			$customers_id = vam_db_prepare_input($_GET['cID']);
			$customers_cid = vam_db_prepare_input($_POST['csID']);
			$customers_vat_id = vam_db_prepare_input($_POST['customers_vat_id']);
			$customers_vat_id_status = vam_db_prepare_input($_POST['customers_vat_id_status']);
			$customers_firstname = vam_db_prepare_input($_POST['customers_firstname']);
			$customers_secondname = vam_db_prepare_input($_POST['customers_secondname']);
			$customers_lastname = vam_db_prepare_input($_POST['customers_lastname']);
			$customers_email_address = vam_db_prepare_input($_POST['customers_email_address']);
			$customers_telephone = vam_db_prepare_input($_POST['customers_telephone']);
			$customers_fax = vam_db_prepare_input($_POST['customers_fax']);
			$customers_newsletter = vam_db_prepare_input($_POST['customers_newsletter']);
			$customers_personal_discount = vam_db_prepare_input($_POST['customers_personal_discount']);
			$customers_manufacturer_discount_new = vam_db_prepare_input($_POST['manufacturer_discount_new']);
			$customers_manufacturer_discount_select = vam_db_prepare_input($_POST['manufacturer_discount_select']);

			$customers_gender = vam_db_prepare_input($_POST['customers_gender']);
			$customers_dob = vam_db_prepare_input($_POST['customers_dob']);

			$default_address_id = vam_db_prepare_input($_POST['default_address_id']);
			$entry_street_address = vam_db_prepare_input($_POST['entry_street_address']);
			$entry_suburb = vam_db_prepare_input($_POST['entry_suburb']);
			$entry_postcode = vam_db_prepare_input($_POST['entry_postcode']);
			$entry_city = vam_db_prepare_input($_POST['entry_city']);
			$entry_country_id = vam_db_prepare_input($_POST['entry_country_id']);

			$entry_company = vam_db_prepare_input($_POST['entry_company']);
			$entry_state = vam_db_prepare_input($_POST['entry_state']);
			$entry_zone_id = vam_db_prepare_input($_POST['entry_zone_id']);

			$memo_title = vam_db_prepare_input($_POST['memo_title']);
			$memo_text = vam_db_prepare_input($_POST['memo_text']);

			$payment_unallowed = vam_db_prepare_input($_POST['payment_unallowed']);
			$shipping_unallowed = vam_db_prepare_input($_POST['shipping_unallowed']);
			$password = vam_db_prepare_input($_POST['entry_password']);
			

			if ($memo_text != '' && $memo_title != '') {
				$sql_data_array = array ('customers_id' => $_GET['cID'], 'memo_date' => date("Y-m-d"), 'memo_title' => $memo_title, 'memo_text' => $memo_text, 'poster_id' => $_SESSION['customer_id']);
				vam_db_perform(TABLE_CUSTOMERS_MEMO, $sql_data_array);
			}

			if ($customers_manufacturer_discount_new != '') {
				$sql_data_array = array ('customers_id' => $_GET['cID'], 'manufacturers_id' => $customers_manufacturer_discount_select, 'discount' => $customers_manufacturer_discount_new);
				vam_db_perform(TABLE_CUSTOMERS_TO_MANUFACTURERS_DISCOUNT, $sql_data_array);
			}
			$error = false; // reset error flag

			if (strlen($customers_firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
				$error = true;
				$entry_firstname_error = true;
			} else {
				$entry_firstname_error = false;
			}

			if (strlen($customers_lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
				$error = true;
				$entry_lastname_error = true;
			} else {
				$entry_lastname_error = false;
			}

			if (ACCOUNT_DOB == 'true') {
				if (checkdate(substr(vam_date_raw($customers_dob), 4, 2), substr(vam_date_raw($customers_dob), 6, 2), substr(vam_date_raw($customers_dob), 0, 4))) {
					$entry_date_of_birth_error = false;
				} else {
					$error = true;
					$entry_date_of_birth_error = true;
				}
			}

// New VAT Check
	if (vam_get_geo_zone_code($entry_country_id) != '6') {
	require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'vat_validation.php');
	$vatID = new vat_validation($customers_vat_id, $customers_id, '', $entry_country_id);

	$customers_vat_id_status = $vatID->vat_info['vat_id_status'];
	$error = $vatID->vat_info['error'];

	if($error==1){
	$entry_vat_error = true;
	$error = true;
  }

  }
// New VAT CHECK END

			if (strlen($customers_email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
				$error = true;
				$entry_email_address_error = true;
			} else {
				$entry_email_address_error = false;
			}

			if (!vam_validate_email($customers_email_address)) {
				$error = true;
				$entry_email_address_check_error = true;
			} else {
				$entry_email_address_check_error = false;
			}

        if (ACCOUNT_STREET_ADDRESS == 'true') {
			if (strlen($entry_street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
				$error = true;
				$entry_street_address_error = true;
			} else {
				$entry_street_address_error = false;
			}
        }

        if (ACCOUNT_POSTCODE == 'true') {
			if (strlen($entry_postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
				$error = true;
				$entry_post_code_error = true;
			} else {
				$entry_post_code_error = false;
			}
		  }

        if (ACCOUNT_CITY == 'true') {
			if (strlen($entry_city) < ENTRY_CITY_MIN_LENGTH) {
				$error = true;
				$entry_city_error = true;
			} else {
				$entry_city_error = false;
			}
        }

		$entry_country_error = false;

if (isset($_POST['country'])) { $entry_country_id = $_POST['country']; } else { $entry_country_id = STORE_COUNTRY; }
$entry_state = $_POST['entry_state'];

	if (ACCOUNT_STATE == 'true') {
		if ($entry_country_error == true) {
			$entry_state_error = true;
		} else {
			$zone_id = 0;
			$entry_state_error = false;
			$check_query = vam_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".vam_db_input($entry_country_id)."'");
			$check_value = vam_db_fetch_array($check_query);
			$entry_state_has_zones = ($check_value['total'] > 0);
			if ($entry_state_has_zones == true) {
				$zone_query = vam_db_query("select zone_id from ".TABLE_ZONES." where zone_country_id = '".vam_db_input($entry_country_id)."' and zone_name = '".vam_db_input($entry_state)."'");
				if (vam_db_num_rows($zone_query) == 1) {
					$zone_values = vam_db_fetch_array($zone_query);
					$entry_zone_id = $zone_values['zone_id'];
				} else {
					$zone_query = vam_db_query("select zone_id from ".TABLE_ZONES." where zone_country_id = '".vam_db_input($entry_country)."' and zone_code = '".vam_db_input($entry_state)."'");
					if (vam_db_num_rows($zone_query) >= 1) {
						$zone_values = vam_db_fetch_array($zone_query);
						$zone_id = $zone_values['zone_id'];
					} else {
						$error = true;
						$entry_state_error = true;
					}
				}
			} else {
				if ($entry_state == false) {
					$error = true;
					$entry_state_error = true;
				}
			}
		}
	}


        if (ACCOUNT_TELE == 'true') {
			if (strlen($customers_telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
				$error = true;
				$entry_telephone_error = true;
			} else {
				$entry_telephone_error = false;
			}
        }

//			if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
//				$error = true;
//				$entry_password_error = true;
//			} else {
//				$entry_password_error = false;
//			}

			$check_email = vam_db_query("select customers_email_address from ".TABLE_CUSTOMERS." where customers_email_address = '".vam_db_input($customers_email_address)."' and customers_id <> '".vam_db_input($customers_id)."'");
			if (vam_db_num_rows($check_email)) {
				$error = true;
				$entry_email_address_exists = true;
			} else {
				$entry_email_address_exists = false;
			}

      $extra_fields_query = vam_db_query("select ce.fields_id, ce.fields_input_type, ce.fields_required_status, cei.fields_name, ce.fields_status, ce.fields_input_type, ce.fields_size from " . TABLE_EXTRA_FIELDS . " ce, " . TABLE_EXTRA_FIELDS_INFO . " cei where ce.fields_status=1 and ce.fields_required_status=1 and cei.fields_id=ce.fields_id and cei.languages_id =" . (int)$_SESSION['languages_id']);
      while($extra_fields = vam_db_fetch_array($extra_fields_query)){
        if(strlen($_POST['fields_' . $extra_fields['fields_id'] ])<$extra_fields['fields_size']){
          $error = true;
          $string_error=sprintf(ENTRY_EXTRA_FIELDS_ERROR,$extra_fields['fields_name'],$extra_fields['fields_size']);
          $messageStack->add($string_error);
        }
      }

			if ($error == false) {
				$sql_data_array = array ('customers_firstname' => $customers_firstname, 'customers_secondname' => $customers_secondname, 'customers_cid' => $customers_cid, 'customers_vat_id' => $customers_vat_id, 'customers_vat_id_status' => (int)$customers_vat_id_status, 'customers_lastname' => $customers_lastname, 'customers_email_address' => $customers_email_address, 'customers_telephone' => $customers_telephone, 'customers_fax' => $customers_fax, 'customers_personal_discount' => $customers_personal_discount, 'payment_unallowed' => $payment_unallowed, 'shipping_unallowed' => $shipping_unallowed, 'customers_newsletter' => $customers_newsletter,'customers_last_modified' => 'now()');

				// if new password is set
				if ($password != "") {			
					$sql_data_array=array_merge($sql_data_array,array('customers_password' => vam_encrypt_password($password)));						
				}

				if (ACCOUNT_GENDER == 'true')
					$sql_data_array['customers_gender'] = $customers_gender;
				if (ACCOUNT_DOB == 'true')
					$sql_data_array['customers_dob'] = vam_date_raw($customers_dob);

				vam_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '".vam_db_input($customers_id)."'");

				vam_db_query("update ".TABLE_CUSTOMERS_INFO." set customers_info_date_account_last_modified = now() where customers_info_id = '".vam_db_input($customers_id)."'");

				if ($entry_zone_id > 0)
					$entry_state = '';

				$sql_data_array = array ('entry_firstname' => $customers_firstname, 'entry_secondname' => $customers_secondname, 'entry_lastname' => $customers_lastname, 'entry_street_address' => $entry_street_address, 'entry_postcode' => $entry_postcode, 'entry_city' => $entry_city, 'entry_country_id' => (int)$entry_country_id,'address_last_modified' => 'now()');
				
				
				if (ACCOUNT_COMPANY == 'true')
					$sql_data_array['entry_company'] = $entry_company;
				if (ACCOUNT_SUBURB == 'true')
					$sql_data_array['entry_suburb'] = $entry_suburb;

				if (ACCOUNT_STATE == 'true') {
					if ($entry_zone_id > 0) {
						$sql_data_array['entry_zone_id'] = (int)$entry_zone_id;
						$sql_data_array['entry_state'] = '';
					} else {
						$sql_data_array['entry_zone_id'] = 0;
						$sql_data_array['entry_state'] = $entry_state;
					}
				}

				vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', "customers_id = '".vam_db_input($customers_id)."' and address_book_id = '".vam_db_input($default_address_id)."'");

        vam_db_query("delete from " . TABLE_CUSTOMERS_TO_EXTRA_FIELDS . " where customers_id=" . (int)$customers_id);
        $extra_fields_query =vam_db_query("select ce.fields_id from " . TABLE_EXTRA_FIELDS . " ce where ce.fields_status=1 ");
        while($extra_fields = vam_db_fetch_array($extra_fields_query)){
            $sql_data_array = array('customers_id' => (int)$customers_id,
                              'fields_id' => $extra_fields['fields_id'],
                              'value' => $_POST['fields_' . $extra_fields['fields_id'] ]);
            vam_db_perform(TABLE_CUSTOMERS_TO_EXTRA_FIELDS, $sql_data_array);
        }

				vam_redirect(vam_href_link(FILENAME_CUSTOMERS, vam_get_all_get_params(array ('cID', 'action')).'cID='.$customers_id));
			}
			elseif ($error == true) {
				$cInfo = new objectInfo($_POST);
				$processed = true;
			}

			break;
		case 'deleteconfirm' :
			$customers_id = vam_db_prepare_input($_GET['cID']);

			if ($_POST['delete_reviews'] == 'on') {
				$reviews_query = vam_db_query("select reviews_id from ".TABLE_REVIEWS." where customers_id = '".vam_db_input($customers_id)."'");
				while ($reviews = vam_db_fetch_array($reviews_query)) {
					vam_db_query("delete from ".TABLE_REVIEWS_DESCRIPTION." where reviews_id = '".$reviews['reviews_id']."'");
				}
				vam_db_query("delete from ".TABLE_REVIEWS." where customers_id = '".vam_db_input($customers_id)."'");
			} else {
				vam_db_query("update ".TABLE_REVIEWS." set customers_id = null where customers_id = '".vam_db_input($customers_id)."'");
			}

			vam_db_query("delete from ".TABLE_ADDRESS_BOOK." where customers_id = '".vam_db_input($customers_id)."'");
			vam_db_query("delete from ".TABLE_CUSTOMERS." where customers_id = '".vam_db_input($customers_id)."'");
			vam_db_query("delete from ".TABLE_CUSTOMERS_INFO." where customers_info_id = '".vam_db_input($customers_id)."'");
			vam_db_query("delete from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".vam_db_input($customers_id)."'");
			vam_db_query("delete from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where customers_id = '".vam_db_input($customers_id)."'");
			vam_db_query("delete from ".TABLE_PRODUCTS_NOTIFICATIONS." where customers_id = '".vam_db_input($customers_id)."'");
			vam_db_query("delete from ".TABLE_WHOS_ONLINE." where customer_id = '".vam_db_input($customers_id)."'");
			vam_db_query("delete from ".TABLE_CUSTOMERS_STATUS_HISTORY." where customers_id = '".vam_db_input($customers_id)."'");
			vam_db_query("delete from ".TABLE_CUSTOMERS_IP." where customers_id = '".vam_db_input($customers_id)."'");
			vam_db_query("DELETE FROM ".TABLE_ADMIN_ACCESS." WHERE customers_id = '".vam_db_input($customers_id)."'");

			vam_redirect(vam_href_link(FILENAME_CUSTOMERS, vam_get_all_get_params(array ('cID', 'action'))));
			break;

		default :
			$customers_query = vam_db_query("select c.customers_id,c.customers_cid, c.customers_gender, c.customers_firstname, c.customers_secondname, c.customers_lastname, c.customers_dob, c.customers_email_address, a.entry_company, a.entry_street_address, a.entry_suburb, a.entry_postcode, a.entry_city, a.entry_state, a.entry_zone_id, a.entry_country_id, c.customers_telephone, c.customers_fax, c.customers_newsletter, c.customers_default_address_id, c.customers_personal_discount from ".TABLE_CUSTOMERS." c left join ".TABLE_ADDRESS_BOOK." a on c.customers_default_address_id = a.address_book_id where a.customers_id = c.customers_id and c.customers_id = '".$_GET['cID']."'");
			$customers = vam_db_fetch_array($customers_query);
			$cInfo = new objectInfo($customers);
	}
}
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
		        <script type="text/javascript">
        var lastChecked = null;
 
        $(document).ready(function() {
                $('input:checkbox').click(function(event) {
                        if(!lastChecked) {
                                lastChecked = this;
                                return;
                        }
 
                        if(event.shiftKey) {
                                var start = $('input:checkbox').index(this);
                                var end = $('input:checkbox').index(lastChecked);
 
                                for(i=Math.min(start,end);i<=Math.max(start,end);i++) {
                                        $('input:checkbox')[i].checked = lastChecked.checked;
                                }
                        }
 
                        lastChecked = this;
                });
        });
        </script>
<?php

if ($_GET['action'] == 'edit' || $_GET['action'] == 'update') {
?>
<script type="text/javascript"><!--
function check_form() {
  var error = 0;
  var error_message = "<?php echo vam_js_lang(JS_ERROR); ?>";

  var customers_firstname = document.customers.customers_firstname.value;
  var customers_lastname = document.customers.customers_lastname.value;
<?php if (ACCOUNT_COMPANY == 'true') echo 'var entry_company = document.customers.entry_company.value;' . "\n"; ?>
<?php if (ACCOUNT_DOB == 'true') echo 'var customers_dob = document.customers.customers_dob.value;' . "\n"; ?>
  var customers_email_address = document.customers.customers_email_address.value;  
  var entry_street_address = document.customers.entry_street_address.value;
  var entry_postcode = document.customers.entry_postcode.value;
  var entry_city = document.customers.entry_city.value;
  var customers_telephone = document.customers.customers_telephone.value;
  var manufacturer_discount_select = document.customers.manufacturer_discount_select.value;


<?php 
$discount_query = vam_db_query("SELECT count(discount_id) as dcount FROM ".TABLE_CUSTOMERS_TO_MANUFACTURERS_DISCOUNT." WHERE customers_id = '" . $_GET['cID'] . "'");
$discount_data = vam_db_fetch_array($discount_query);
if ($discount_data['dcount'] > 0) {
  for ($i = 0; $i < $discount_data['dcount']; $i++) {
?>
    if (document.customers.manufacturer_discount_new.value != '' && manufacturer_discount_select == document.customers.manufacturer_<?php echo $i ?>.value) {
      error_message = error_message + "<?php echo vam_js_lang(JS_DISCOUNT); ?>";
      error = 1;
alert(unescape(error_message));
return false;
    }
<?php
  }
}
?>

<?php if (ACCOUNT_GENDER == 'true') { ?>
  if (document.customers.customers_gender[0].checked || document.customers.customers_gender[1].checked) {
  } else {
    error_message = error_message + "<?php echo vam_js_lang(JS_GENDER); ?>";
    error = 1;
  }
<?php } ?>

  if (customers_firstname == "" || customers_firstname.length < <?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo vam_js_lang(JS_FIRST_NAME); ?>";
    error = 1;
  }

  if (customers_lastname == "" || customers_lastname.length < <?php echo ENTRY_LAST_NAME_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo vam_js_lang(JS_LAST_NAME); ?>";
    error = 1;
  }

<?php if (ACCOUNT_DOB == 'true') { ?>
  if (customers_dob == "" || customers_dob.length < <?php echo ENTRY_DOB_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo vam_js_lang(JS_DOB); ?>";
    error = 1;
  }
<?php } ?>

  if (customers_email_address == "" || customers_email_address.length < <?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo vam_js_lang(JS_EMAIL_ADDRESS); ?>";
    error = 1;
  }

<?php if (ACCOUNT_STREET_ADDRESS == 'true') { ?>
  if (entry_street_address == "" || entry_street_address.length < <?php echo ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo vam_js_lang(JS_ADDRESS); ?>";
    error = 1;
  }
<?php } ?>

<?php if (ACCOUNT_POSTCODE == 'true') { ?>
  if (entry_postcode == "" || entry_postcode.length < <?php echo ENTRY_POSTCODE_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo vam_js_lang(JS_POST_CODE); ?>";
    error = 1;
  }
<?php } ?>

<?php if (ACCOUNT_CITY == 'true') { ?>
  if (entry_city == "" || entry_city.length < <?php echo ENTRY_CITY_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo vam_js_lang(JS_CITY); ?>";
    error = 1;
  }
<?php } ?>

<?php

	if (ACCOUNT_STATE == 'true') {
?>
  if (document.customers.elements['entry_state'].type != "hidden") {
    if (document.customers.entry_state.value == '' || document.customers.entry_state.value.length < <?php echo ENTRY_STATE_MIN_LENGTH; ?> ) {
       error_message = error_message + "<?php echo vam_js_lang(JS_STATE); ?>";
       error = 1;
    }
  }
<?php

	}
?>

<?php if (ACCOUNT_COUNTRY == 'true') { ?>
  if (document.customers.elements['entry_country_id'].type != "hidden") {
    if (document.customers.entry_country_id.value == 0) {
      error_message = error_message + "<?php echo vam_js_lang(JS_COUNTRY); ?>";
      error = 1;
    }
  }
<?php } ?>

<?php if (ACCOUNT_TELE == 'true') { ?>
  if (customers_telephone == "" || customers_telephone.length < <?php echo ENTRY_TELEPHONE_MIN_LENGTH; ?>) {
    error_message = error_message + "<?php echo vam_js_lang(JS_TELEPHONE); ?>";
    error = 1;
  }
<?php } ?>

  if (error == 1) {
    alert(unescape(error_message));
    return false;
  } else {
    return true;
  }
}
//--></script>
<?php

}
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'false') { ?>
    <td width="<?php echo BOX_WIDTH; ?>" align="left" valign="top">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </td>
<?php } ?>
<!-- body_text //-->
    <td class="boxCenter" valign="top">
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php

if ($_GET['action'] == 'edit' || $_GET['action'] == 'update') {
	$customers_query = vam_db_query("select c.payment_unallowed, c.shipping_unallowed, c.customers_gender, c.customers_vat_id, c.customers_status, c.member_flag, c.customers_firstname, c.customers_secondname,c.customers_cid, c.customers_lastname, c.customers_dob, c.customers_email_address, a.entry_company, a.entry_street_address, a.entry_suburb, a.entry_postcode, a.entry_city, a.entry_state, a.entry_zone_id, a.entry_country_id, c.customers_telephone, c.customers_fax, c.customers_newsletter, c.customers_default_address_id, c.customers_personal_discount from ".TABLE_CUSTOMERS." c left join ".TABLE_ADDRESS_BOOK." a on c.customers_default_address_id = a.address_book_id where a.customers_id = c.customers_id and c.customers_id = '".$_GET['cID']."'");

	$customers = vam_db_fetch_array($customers_query);
	$cInfo = new objectInfo($customers);
	$newsletter_array = array (array ('id' => '1', 'text' => ENTRY_NEWSLETTER_YES), array ('id' => '0', 'text' => ENTRY_NEWSLETTER_NO));
?>
    <td class="boxCenter" valign="top">
    <h1 class="contentBoxHeading"><?php echo $cInfo->customers_lastname.' '.$cInfo->customers_firstname.' '.$cInfo->customers_secondname; ?></h1>
  
  </td>
  </tr>

  <tr>
<!-- body_text //-->
    <td class="boxCenter" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="middle" class="pageHeading"><?php if ($customers_statuses_array[$customers['customers_status']]['csa_image'] != '') { echo vam_image(DIR_WS_ICONS . $customers_statuses_array[$customers['customers_status']]['csa_image'], ''); } ?></td>
            <td class="main"></td>
            <td class="pageHeading" align="right"><?php echo vam_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
          <tr>
            <td colspan="3" class="main"><?php echo HEADING_TITLE_STATUS  .': ' . $customers_statuses_array[$customers['customers_status']]['text'] ; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo vam_draw_form('customers', FILENAME_CUSTOMERS, vam_get_all_get_params(array('action')) . 'action=update', 'post', 'onSubmit="return check_form();"') . vam_draw_hidden_field('default_address_id', $cInfo->customers_default_address_id); ?>
        <td class="formAreaTitle"><?php echo CATEGORY_PERSONAL; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
<?php

	if (ACCOUNT_GENDER == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_GENDER; ?></td>
            <td class="main"><?php

		if ($error == true) {
			if ($entry_gender_error == true) {
				echo vam_draw_radio_field('customers_gender', 'm', false, $cInfo->customers_gender).'&nbsp;&nbsp;'.MALE.'&nbsp;&nbsp;'.vam_draw_radio_field('customers_gender', 'f', false, $cInfo->customers_gender).'&nbsp;&nbsp;'.FEMALE.'&nbsp;'.ENTRY_GENDER_ERROR;
			} else {
				echo ($cInfo->customers_gender == 'm') ? MALE : FEMALE;
				echo vam_draw_hidden_field('customers_gender');
			}
		} else {
			echo vam_draw_radio_field('customers_gender', 'm', false, $cInfo->customers_gender).'&nbsp;&nbsp;'.MALE.'&nbsp;&nbsp;'.vam_draw_radio_field('customers_gender', 'f', false, $cInfo->customers_gender).'&nbsp;&nbsp;'.FEMALE;
		}
?></td>
          </tr>
<?php


	}
?>
          <tr>
            <td class="main" bgcolor="#FFCC33"><?php echo ENTRY_CID; ?></td>
            <td class="main" width="100%" bgcolor="#FFCC33"><?php

	echo vam_draw_input_field('csID', $cInfo->customers_cid, 'maxlength="32"', false);
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
            <td class="main"><?php

	if ($entry_firstname_error == true) {
		echo vam_draw_input_field('customers_firstname', $cInfo->customers_firstname, 'maxlength="32"').'&nbsp;'.ENTRY_FIRST_NAME_ERROR;
	} else {
		echo vam_draw_input_field('customers_firstname', $cInfo->customers_firstname, 'maxlength="32"', true);
	}
?></td>
          </tr>
<?php

	if (ACCOUNT_SECOND_NAME == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_SECOND_NAME; ?></td>
            <td class="main"><?php

		echo vam_draw_input_field('customers_secondname', $cInfo->customers_secondname, 'maxlength="32"', false);

?></td>
          </tr>
<?php

	}
?>
          <tr>
            <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
            <td class="main"><?php

	if ($error == true) {
		if ($entry_lastname_error == true) {
			echo vam_draw_input_field('customers_lastname', $cInfo->customers_lastname, 'maxlength="32"').'&nbsp;'.ENTRY_LAST_NAME_ERROR;
		} else {
			echo $cInfo->customers_lastname.vam_draw_hidden_field('customers_lastname');
		}
	} else {
		echo vam_draw_input_field('customers_lastname', $cInfo->customers_lastname, 'maxlength="32"', true);
	}
?></td>
          </tr>
<?php

	if (ACCOUNT_DOB == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
            <td class="main"><?php

		if ($error == true) {
			if ($entry_date_of_birth_error == true) {
				echo vam_draw_input_field('customers_dob', vam_date_short($cInfo->customers_dob), 'maxlength="10"').'&nbsp;'.ENTRY_DATE_OF_BIRTH_ERROR;
			} else {
				echo $cInfo->customers_dob.vam_draw_hidden_field('customers_dob');
			}
		} else {
			echo vam_draw_input_field('customers_dob', vam_date_short($cInfo->customers_dob), 'maxlength="10"', true);
		}
?></td>
          </tr>
<?php

	}
?>
          <tr>
            <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
            <td class="main"><?php

	if ($error == true) {
		if ($entry_email_address_error == true) {
			echo vam_draw_input_field('customers_email_address', $cInfo->customers_email_address, 'maxlength="96"').'&nbsp;'.ENTRY_EMAIL_ADDRESS_ERROR;
		}
		elseif ($entry_email_address_check_error == true) {
			echo vam_draw_input_field('customers_email_address', $cInfo->customers_email_address, 'maxlength="96"').'&nbsp;'.ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
		}
		elseif ($entry_email_address_exists == true) {
			echo vam_draw_input_field('customers_email_address', $cInfo->customers_email_address, 'maxlength="96"').'&nbsp;'.ENTRY_EMAIL_ADDRESS_ERROR_EXISTS;
		} else {
			echo $customers_email_address.vam_draw_hidden_field('customers_email_address');
		}
	} else {
		echo vam_draw_input_field('customers_email_address', $cInfo->customers_email_address, 'maxlength="96"', true);
	}
?></td>
          </tr>
        </table></td>
      </tr>
<?php

	if (ACCOUNT_COMPANY == 'true') {
?>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_COMPANY; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_COMPANY; ?></td>
            <td class="main"><?php

		if ($error == true) {
			if ($entry_company_error == true) {
				echo vam_draw_input_field('entry_company', $cInfo->entry_company, 'maxlength="32"').'&nbsp;'.ENTRY_COMPANY_ERROR;
			} else {
				echo $cInfo->entry_company.vam_draw_hidden_field('entry_company');
			}
		} else {
			echo vam_draw_input_field('entry_company', $cInfo->entry_company, 'maxlength="32"');
		}
?></td>
          </tr>

<?php if(ACCOUNT_COMPANY_VAT_CHECK == 'true'){ ?>
          <tr>
            <td class="main"><?php echo ENTRY_VAT_ID; ?></td>
            <td class="main"><?php

		if ($error == true) {
			if ($entry_vat_error == true) {
				echo vam_draw_input_field('customers_vat_id', $cInfo->customers_vat_id, 'maxlength="32"').'&nbsp;'.ENTRY_VAT_ID_ERROR;
			} else {
				echo $cInfo->customers_vat_id.vam_draw_hidden_field('customers_vat_id');
			}
		} else {
			echo vam_draw_input_field('customers_vat_id', $cInfo->customers_vat_id, 'maxlength="32"');
		}
?></td>
          </tr>
<?php } ?>

        </table></td>
      </tr>
<?php

	}
?>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php

	if (ACCOUNT_STREET_ADDRESS == 'true') {
?>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_ADDRESS; ?></td>
      </tr>
<?php

	}
?>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
<?php

	if (ACCOUNT_STREET_ADDRESS == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>
            <td class="main"><?php

	if ($error == true) {
		if ($entry_street_address_error == true) {
			echo vam_draw_input_field('entry_street_address', $cInfo->entry_street_address, 'maxlength="64"').'&nbsp;'.ENTRY_STREET_ADDRESS_ERROR;
		} else {
			echo $cInfo->entry_street_address.vam_draw_hidden_field('entry_street_address');
		}
	} else {
		echo vam_draw_input_field('entry_street_address', $cInfo->entry_street_address, 'maxlength="64"', true);
	}
?></td>
          </tr>
<?php

	}
?>

<?php

	if (ACCOUNT_SUBURB == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_SUBURB; ?></td>
            <td class="main"><?php

		if ($error == true) {
			if ($entry_suburb_error == true) {
				echo vam_draw_input_field('suburb', $cInfo->entry_suburb, 'maxlength="32"').'&nbsp;'.ENTRY_SUBURB_ERROR;
			} else {
				echo $cInfo->entry_suburb.vam_draw_hidden_field('entry_suburb');
			}
		} else {
			echo vam_draw_input_field('entry_suburb', $cInfo->entry_suburb, 'maxlength="32"');
		}
?></td>
          </tr>
<?php

	}
?>
<?php

	if (ACCOUNT_POSTCODE == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_POST_CODE; ?></td>
            <td class="main"><?php

	if ($error == true) {
		if ($entry_post_code_error == true) {
			echo vam_draw_input_field('entry_postcode', $cInfo->entry_postcode, 'maxlength="8"').'&nbsp;'.ENTRY_POST_CODE_ERROR;
		} else {
			echo $cInfo->entry_postcode.vam_draw_hidden_field('entry_postcode');
		}
	} else {
		echo vam_draw_input_field('entry_postcode', $cInfo->entry_postcode, 'maxlength="8"', true);
	}
?></td>
          </tr>
<?php

	}
?>
<?php

	if (ACCOUNT_CITY == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_CITY; ?></td>
            <td class="main"><?php

	if ($error == true) {
		if ($entry_city_error == true) {
			echo vam_draw_input_field('entry_city', $cInfo->entry_city, 'maxlength="32"').'&nbsp;'.ENTRY_CITY_ERROR;
		} else {
			echo $cInfo->entry_city.vam_draw_hidden_field('entry_city');
		}
	} else {
		echo vam_draw_input_field('entry_city', $cInfo->entry_city, 'maxlength="32"', true);
	}
?></td>
          </tr>
<?php

	}
?>
<?php
  if (ACCOUNT_COUNTRY == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
                <td class="main"><?php echo vam_get_country_list('country',$cInfo->entry_country_id, 'onChange="changeselect();"') . '&nbsp;' . (defined(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  }
?>
<?php
if (ACCOUNT_STATE == 'true') {
?>
             <tr>
               <td class="main"><?php echo ENTRY_STATE;?></td>
            <td class="main">
<script language="javascript">
<!--
function changeselect(reg) {
//clear select
    document.customers.entry_state.length=0;
    var j=0;
    for (var i=0;i<zones.length;i++) {
      if (zones[i][0]==document.customers.country.value) {
   document.customers.entry_state.options[j]=new Option(zones[i][1],zones[i][1]);
   j++;
   }
      }
    if (j==0) {
      document.customers.entry_state.options[0]=new Option('-','-');
      }
    if (reg) { document.customers.entry_state.value = reg; }
}
   var zones = new Array(
   <?php
       $zones_query = vam_db_query("select zone_country_id,zone_name from " . TABLE_ZONES . " order by zone_name asc");
       $mas=array();
       while ($zones_values = vam_db_fetch_array($zones_query)) {
         $zones[] = 'new Array('.$zones_values['zone_country_id'].',"'.$zones_values['zone_name'].'")';
       }

        $zones_array1[] = 'new Array('.$cInfo->entry_country_id.',"'.vam_get_zone_name($cInfo->entry_country_id,$cInfo->entry_zone_id,'').'")';

        $zones = array_merge($zones_array1, $zones);

       echo implode(',',$zones);
       ?>
       );
document.write('<select name="entry_state">');
document.write('</select>');
changeselect("<?php echo vam_db_prepare_input($_POST['state']); ?>");
-->
</script>
</td>
             </tr>
<?php
}
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php

	if (ACCOUNT_TELE == 'true') {
?>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_CONTACT; ?></td>
      </tr>
<?php

	}
?>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
<?php

	if (ACCOUNT_TELE == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
            <td class="main"><?php

	if ($error == true) {
		if ($entry_telephone_error == true) {
			echo vam_draw_input_field('customers_telephone', $cInfo->customers_telephone, 'maxlength="32"').'&nbsp;'.ENTRY_TELEPHONE_NUMBER_ERROR;
		} else {
			echo $cInfo->customers_telephone.vam_draw_hidden_field('customers_telephone');
		}
	} else {
		echo vam_draw_input_field('customers_telephone', $cInfo->customers_telephone, 'maxlength="32"', true);
	}
?></td>
          </tr>
<?php

	}
?>
<?php

	if (ACCOUNT_FAX == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_FAX_NUMBER; ?></td>
            <td class="main"><?php

	if ($processed == true) {
		echo $cInfo->customers_fax.vam_draw_hidden_field('customers_fax');
	} else {
		echo vam_draw_input_field('customers_fax', $cInfo->customers_fax, 'maxlength="32"');
	}
?></td>
          </tr>
<?php

	}
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <?php echo vam_get_extra_fields($_GET['cID'],$_SESSION['languages_id']); ?>
      <tr>
        <td class="formAreaTitle"><?php echo ENTRY_DISCOUNT; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
        
                  <tr>
            <td class="main"><?php echo ENTRY_DISCOUNT_CUSTOMER; ?></td>
            <td class="main"><?php

	if ($processed == true) {
		echo $cInfo->discount.vam_draw_hidden_field('customers_personal_discount');
	} else {
		echo vam_draw_input_field('customers_personal_discount', $cInfo->customers_personal_discount, 'maxlength="5"');
	}
?>%</td>
          </tr>
          <tr>
          <?php include(DIR_WS_MODULES . FILENAME_CUSTOMER_TO_MANUFACTURER_DISCOUNT); ?>
          </tr>
          </table>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_OPTIONS; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
        
                  <tr>
            <td class="main"><?php echo ENTRY_PAYMENT_UNALLOWED; ?></td>
            <td class="main"><?php

	if ($processed == true) {
		echo $cInfo->payment_unallowed.vam_draw_hidden_field('payment_unallowed');
	} else {
		echo vam_draw_input_field('payment_unallowed', $cInfo->payment_unallowed, 'maxlength="255"');
	}
?></td>
          </tr>
                    <tr>
            <td class="main"><?php echo ENTRY_SHIPPING_UNALLOWED; ?></td>
            <td class="main"><?php

	if ($processed == true) {
		echo $cInfo->shipping_unallowed.vam_draw_hidden_field('shipping_unallowed');
	} else {
		echo vam_draw_input_field('shipping_unallowed', $cInfo->shipping_unallowed, 'maxlength="255"');
	}
?></td>
         </tr>
            <td class="main" bgcolor="#FFCC33"><?php echo ENTRY_NEW_PASSWORD; ?></td>
            <td class="main" bgcolor="#FFCC33"><?php

if ($error == true) {
	if ($entry_password_error == true) {
		echo vam_draw_input_field('entry_password', $customers_password).'&nbsp;'.ENTRY_PASSWORD_ERROR;
	} else {
		echo vam_draw_input_field('entry_password');
	}
} else {
	echo vam_draw_input_field('entry_password');
}
?></td>      
        
          <tr>
            <td class="main"><?php echo ENTRY_NEWSLETTER; ?></td>
            <td class="main"><?php

	if ($processed == true) {
		if ($cInfo->customers_newsletter == '1') {
			echo ENTRY_NEWSLETTER_YES;
		} else {
			echo ENTRY_NEWSLETTER_NO;
		}
		echo vam_draw_hidden_field('customers_newsletter');
	} else {
		echo vam_draw_pull_down_menu('customers_newsletter', $newsletter_array, $cInfo->customers_newsletter);
	}
?></td>
          </tr>
          <tr>
<?php include(DIR_WS_MODULES . FILENAME_CUSTOMER_MEMO); ?>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><span class="button"><button type="submit" value="<?php echo BUTTON_UPDATE; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_UPDATE; ?></button></span><?php echo ' <a class="button" href="' . vam_href_link(FILENAME_CUSTOMERS, vam_get_all_get_params(array('action'))) .'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?></td>
      </tr></form>
<?php

} else {
?>

  <tr>
	<td>  
  
          <table border="0" width="100%" cellspacing="0" cellpadding="0" class="pageHead">
        <tr>
         <td class="pageHeading" align="left">
         <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>   
         </td>
         <td align="right">

          <?php echo vam_draw_form('status', FILENAME_CUSTOMERS, '', 'get'); ?>
<?php

	$select_data = array ();
	$select_data = array (array ('id' => '99', 'text' => TEXT_SELECT), array ('id' => '100', 'text' => TEXT_ALL_CUSTOMERS));
?>          
            <?php echo HEADING_TITLE_STATUS . ' ' . vam_draw_pull_down_menu('status',vam_array_merge($select_data, $customers_statuses_array), '99', 'onChange="this.form.submit();"').vam_draw_hidden_field(vam_session_name(), vam_session_id()); ?>




          </form>
         </td>
         <td align="right">
<?php echo vam_draw_form('search', FILENAME_CUSTOMERS, '', 'get'); ?>
<?php echo HEADING_TITLE_SEARCH . ' ' . vam_draw_input_field('search').vam_draw_hidden_field(vam_session_name(), vam_session_id()); ?>
          </form>
         </td>
       </tr>
       </table>
       

  </tr>
      <tr>
        <td>
        
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading" align="left"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_CREATE_ACCOUNT) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/account.png', '', '12', '12') . '&nbsp;' . BUTTON_CREATE_ACCOUNT . '</span></a>'; ?>&nbsp;<?php echo '<a class="button" href="' . vam_href_link(FILENAME_CUSTOMERS_EXPORT) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/export.png', '', '12', '12') . '&nbsp;' . BUTTON_CUSTOMERS_EXPORT . '</span></a>'; ?></td>
            <td class="smallText" align="right"></tr>
        </table></td>
      </tr>
      <tr>
        <td>
<?php
echo vam_draw_form('multi_action_form', FILENAME_CUSTOMERS,vam_get_all_get_params());
?>        
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><input type="checkbox" onClick="javascript:CheckAll(this.checked);"></td>
                <td class="dataTableHeadingContent" width="40"><?php echo TABLE_HEADING_ACCOUNT_TYPE; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LASTNAME.vam_sorting(FILENAME_CUSTOMERS,'customers_lastname'); ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FIRSTNAME.vam_sorting(FILENAME_CUSTOMERS,'customers_firstname'); ?></td>
                <td class="dataTableHeadingContent" align="left"><?php echo HEADING_TITLE_STATUS; ?></td>
                <?php if (ACCOUNT_COMPANY_VAT_CHECK == 'true') {?>
                <td class="dataTableHeadingContent" align="left"><?php echo HEADING_TITLE_VAT; ?></td>
                <?php } ?>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACCOUNT_CREATED.vam_sorting(FILENAME_CUSTOMERS,'date_account_created'); ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php

	$search = '';
	if (($_GET['search']) && (vam_not_null($_GET['search']))) {
		$keywords = vam_db_input(vam_db_prepare_input($_GET['search']));
		$search = "and (c.customers_lastname like '%".$keywords."%' or c.customers_firstname like '%".$keywords."%' or c.customers_email_address like '%".$keywords."%' or c.customers_telephone like '%".$keywords."%')";
	}

	if ($_GET['status'] && $_GET['status'] != '100' or $_GET['status'] == '0') {
		$status = vam_db_prepare_input($_GET['status']);
		//  echo $status;
		$search = "and c.customers_status = '".$status."'";
	}

	$sort = 'order by ci.customers_info_date_account_created DESC';

	if ($_GET['sorting']) {
		switch ($_GET['sorting']) {

			case 'customers_firstname' :
				$sort = 'order by c.customers_firstname';
				break;

			case 'customers_firstname-desc' :
				$sort = 'order by c.customers_firstname DESC';
				break;

			case 'customers_lastname' :
				$sort = 'order by c.customers_lastname';
				break;

			case 'customers_lastname-desc' :
				$sort = 'order by c.customers_lastname DESC';
				break;

			case 'date_account_created' :
				$sort = 'order by ci.customers_info_date_account_created';
				break;

			case 'date_account_created-desc' :
				$sort = 'order by ci.customers_info_date_account_created DESC';
				break;
		}

	}

	$customers_query_raw = "select
	                                c.account_type,
	                                c.customers_id,
	                                c.customers_vat_id,
	                                c.customers_vat_id_status,
	                                c.customers_lastname,
	                                c.customers_firstname,
	                                c.customers_secondname,
	                                c.customers_email_address,
	                                a.entry_country_id,
	                                c.customers_status,
	                                c.member_flag,
	                                ci.customers_info_date_account_created
	                                from
	                                ".TABLE_CUSTOMERS." c ,
	                                ".TABLE_ADDRESS_BOOK." a,
	                                ".TABLE_CUSTOMERS_INFO." ci
	                                Where
	                                c.customers_id = a.customers_id
	                                and c.customers_default_address_id = a.address_book_id
	                                and ci.customers_info_id = c.customers_id
	                                ".$search."
	                                group by c.customers_id
	                                ".$sort;

	$customers_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $customers_query_raw, $customers_query_numrows);
	$customers_query = vam_db_query($customers_query_raw);
	while ($customers = vam_db_fetch_array($customers_query)) {
		$info_query = vam_db_query("select customers_info_date_account_created as date_account_created, customers_info_date_account_last_modified as date_account_last_modified, customers_info_date_of_last_logon as date_last_logon, customers_info_number_of_logons as number_of_logons from ".TABLE_CUSTOMERS_INFO." where customers_info_id = '".$customers['customers_id']."'");
		$info = vam_db_fetch_array($info_query);

		if (((!$_GET['cID']) || (@ $_GET['cID'] == $customers['customers_id'])) && (!$cInfo)) {
			$country_query = vam_db_query("select countries_name from ".TABLE_COUNTRIES." where countries_id = '".$customers['entry_country_id']."'");
			$country = vam_db_fetch_array($country_query);

			$reviews_query = vam_db_query("select count(*) as number_of_reviews from ".TABLE_REVIEWS." where customers_id = '".$customers['customers_id']."'");
			$reviews = vam_db_fetch_array($reviews_query);

        $customer_info = array_merge((array)$country, (array)$info, (array)$reviews);
        
			$cInfo_array = vam_array_merge($customers, $customer_info);
			$cInfo = new objectInfo($cInfo_array);
		}

        if ( (is_object($cInfo)) && ($customers['customers_id'] == $cInfo->customers_id) ) {
            echo '<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'">' . "\n";
        } else {
            echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";
        }		
?>
                <td class="dataTableContent" align="center"><input type="checkbox" name="multi_customers[]" value="<?php echo $customers['customers_id'];?>"></td>
<?php
		if ($customers['account_type'] == 1) {

			echo '<td class="dataTableContent">';
			echo TEXT_GUEST;

		} else {
			echo '<td class="dataTableContent">';
			echo TEXT_ACCOUNT;
		}
?></td>
                <td class="dataTableContent"><?php echo $customers['customers_lastname']; ?></td>
                <td class="dataTableContent"><?php echo $customers['customers_firstname']; ?></td>
                <td class="dataTableContent" align="left"><?php echo $customers_statuses_array[$customers['customers_status']]['text'] . ' (' . $customers['customers_status'] . ')' ; ?></td>
                <?php if (ACCOUNT_COMPANY_VAT_CHECK == 'true') {?>
                <td class="dataTableContent" align="left">&nbsp;
                <?php

		if ($customers['customers_vat_id']) {
			echo $customers['customers_vat_id'].'<br /><span style="font-size:8pt"><nobr>('.vam_validate_vatid_status($customers['customers_id']).')</nobr></span>';
		}
?>
                </td>
                <?php } ?>
                <td class="dataTableContent" align="right"><?php echo vam_date_short($info['date_account_created']); ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($cInfo)) && ($customers['customers_id'] == $cInfo->customers_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_CUSTOMERS, vam_get_all_get_params(array('cID')) . 'cID=' . $customers['customers_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php

	}
?>
<?php
echo '<tr class="dataTableContent" align="center"><td colspan="7" nobr="nobr" align="left">' .
     '<a class="button" href="javascript:SwitchCheck()"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/reverse.png', '', '12', '12') . '&nbsp;' . BUTTON_REVERSE_SELECTION . '</span></a>&nbsp;<span class="button"><button name="submit" type="submit" value="' . BUTTON_SUBMIT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUS_DELETE_CUSTOMERS . '</button></span></td></tr>';
?>
</form>
              <tr>
                <td colspan="7"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $customers_split->display_count($customers_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CUSTOMERS); ?></td>
                    <td class="smallText" align="right"><?php echo $customers_split->display_links($customers_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], vam_get_all_get_params(array('page', 'info', 'x', 'y', 'cID'))); ?></td>
                  </tr>
<?php

	if (vam_not_null($_GET['search'])) {
?>
                  <tr>
                    <td align="right" colspan="2"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_CUSTOMERS) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_RESET . '</span></a>'; ?></td>
                  </tr>
<?php

	}
?>
                </table></td>
              </tr>
            </table></td>
<?php

	$heading = array ();
	$contents = array ();
	switch ($_GET['action']) {
		case 'confirm' :
			$heading[] = array ('text' => '<b>'.TEXT_INFO_HEADING_DELETE_CUSTOMER.'</b>');

			$contents = array ('form' => vam_draw_form('customers', FILENAME_CUSTOMERS, vam_get_all_get_params(array ('cID', 'action')).'cID='.$cInfo->customers_id.'&action=deleteconfirm'));
			$contents[] = array ('text' => TEXT_DELETE_INTRO.'<br /><br /><b>'.$cInfo->customers_firstname.' '.$cInfo->customers_lastname.'</b>');
			if ($cInfo->number_of_reviews > 0)
				$contents[] = array ('text' => '<br />'.vam_draw_checkbox_field('delete_reviews', 'on', true).' '.sprintf(TEXT_DELETE_REVIEWS, $cInfo->number_of_reviews));
			$contents[] = array ('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="'.BUTTON_DELETE.'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span><a class="button" href="'.vam_href_link(FILENAME_CUSTOMERS, vam_get_all_get_params(array ('cID', 'action')).'cID='.$cInfo->customers_id).'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' .BUTTON_CANCEL.'</span></a>');
			break;

		case 'editstatus' :
			if ($_GET['cID'] != 1) {
				$customers_history_query = vam_db_query("select new_value, old_value, date_added, customer_notified from ".TABLE_CUSTOMERS_STATUS_HISTORY." where customers_id = '".vam_db_input($_GET['cID'])."' order by customers_status_history_id desc");
				$heading[] = array ('text' => '<b>'.TEXT_INFO_HEADING_STATUS_CUSTOMER.'</b>');
				$contents = array ('form' => vam_draw_form('customers', FILENAME_CUSTOMERS, vam_get_all_get_params(array ('cID', 'action')).'cID='.$cInfo->customers_id.'&action=statusconfirm'));
				$contents[] = array ('text' => '<br />'.vam_draw_pull_down_menu('status', $customers_statuses_array, $cInfo->customers_status));
				$contents[] = array ('text' => '<table nowrap border="0" cellspacing="0" cellpadding="0"><tr><td style="border-bottom: 1px solid; border-color: #000000;" nowrap class="smallText" align="center"><b>'.TABLE_HEADING_NEW_VALUE.' </b></td><td style="border-bottom: 1px solid; border-color: #000000;" nowrap class="smallText" align="center"><b>'.TABLE_HEADING_DATE_ADDED.'</b></td></tr>');

				if (vam_db_num_rows($customers_history_query)) {
					while ($customers_history = vam_db_fetch_array($customers_history_query)) {

						$contents[] = array ('text' => '<tr>'."\n".'<td class="smallText">'.$customers_statuses_array[$customers_history['new_value']]['text'].'</td>'."\n".'<td class="smallText" align="center">'.vam_datetime_short($customers_history['date_added']).'</td>'."\n".'<td class="smallText" align="center">');

						$contents[] = array ('text' => '</tr>'."\n");
					}
				} else {
					$contents[] = array ('text' => '<tr>'."\n".' <td class="smallText" colspan="2">'.TEXT_NO_CUSTOMER_HISTORY.'</td>'."\n".' </tr>'."\n");
				}
				$contents[] = array ('text' => '</table>');
				$contents[] = array ('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="'.BUTTON_UPDATE.'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_UPDATE . '</button></span><a class="button" href="'.vam_href_link(FILENAME_CUSTOMERS, vam_get_all_get_params(array ('cID', 'action')).'cID='.$cInfo->customers_id).'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' .BUTTON_CANCEL.'</span></a>');
				$status = vam_db_prepare_input($_POST['status']); // maybe this line not needed to recheck...
			}
			break;

		default :
			$customer_status = vam_get_customer_status($_GET['cID']);
			$cs_id = $customer_status['customers_status'];
			$cs_member_flag = $customer_status['member_flag'];
			$cs_name = $customer_status['customers_status_name'];
			$cs_image = $customer_status['customers_status_image'];
			if ($customer_status['customers_personal_discount'] > 0) {
			  $cs_discount = $customer_status['customers_personal_discount'];
			} else {
			  $cs_discount = $customer_status['customers_status_discount'];
			}
			$cs_ot_discount_flag = $customer_status['customers_status_ot_discount_flag'];
			$cs_ot_discount = $customer_status['customers_status_ot_discount'];
			$cs_staffelpreise = $customer_status['customers_status_staffelpreise'];
			$cs_payment_unallowed = $customer_status['customers_status_payment_unallowed'];

			//      echo 'customer_status ' . $cID . 'variables = ' . $cs_id . $cs_member_flag . $cs_name .  $cs_discount .  $cs_image . $cs_ot_discount;

			if (is_object($cInfo)) {
				$heading[] = array ('text' => '<b>'.$cInfo->customers_firstname.' '.$cInfo->customers_lastname.'</b>');
				if ($cInfo->customers_id != 1) {
					$contents[] = array ('align' => 'center', 'text' => '<a class="button" href="'.vam_href_link(FILENAME_CUSTOMERS, vam_get_all_get_params(array ('cID', 'action')).'cID='.$cInfo->customers_id.'&action=edit').'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' .BUTTON_EDIT.'</span></a>');
				}
				if ($cInfo->customers_id == 1 && $_SESSION['customer_id'] == 1) {
					$contents[] = array ('align' => 'center', 'text' => '<a class="button" href="'.vam_href_link(FILENAME_CUSTOMERS, vam_get_all_get_params(array ('cID', 'action')).'cID='.$cInfo->customers_id.'&action=edit').'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' .BUTTON_EDIT.'</span></a>');
				}
				if ($cInfo->customers_id != 1) {
					$contents[] = array ('align' => 'center', 'text' => '<a class="button" href="'.vam_href_link(FILENAME_CUSTOMERS, vam_get_all_get_params(array ('cID', 'action')).'cID='.$cInfo->customers_id.'&action=confirm').'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' .BUTTON_DELETE.'</span></a>');
				}
				if ($cInfo->customers_id != 1 /*&& $_SESSION['customer_id'] == 1*/
					) {
					$contents[] = array ('align' => 'center', 'text' => '<a class="button" href="'.vam_href_link(FILENAME_CUSTOMERS, vam_get_all_get_params(array ('cID', 'action')).'cID='.$cInfo->customers_id.'&action=editstatus').'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/customer_status.png', '', '12', '12') . '&nbsp;' .BUTTON_STATUS.'</span></a>');
				}
				// elari cs v3.x changed for added accounting module
				if ($cInfo->customers_id != 1) {
					$contents[] = array ('align' => 'center', 'text' => '<a class="button" ' . ($cs_id != 0 ? 'onClick="alert(\'Сначала определите пользователя в группу Админ (кнопка Статус покупателя)!\nДоступ в админку можно настраивать только для пользователей, состоящих в группе Админ.\');"' : '') . ' href="'.vam_href_link(FILENAME_ACCOUNTING, vam_get_all_get_params(array ('cID', 'action')).'cID='.$cInfo->customers_id).'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/gear.png', '', '12', '12') . '&nbsp;' .BUTTON_ACCOUNTING.'</span></a>');
				}
				// elari cs v3.x changed for added iplog module
				$contents[] = array ('align' => 'center', 'text' => '<table><tr><td style="text-align: center;"><a class="button" href="'.vam_href_link(FILENAME_ORDERS, 'cID='.$cInfo->customers_id).'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/categories.png', '', '12', '12') . '&nbsp;' .BUTTON_ORDERS.'</span></a></td><td style="text-align: center;"><a class="button" href="'.vam_href_link(FILENAME_MAIL, 'selected_box=tools&customer='.$cInfo->customers_email_address).'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/email.png', '', '12', '12') . '&nbsp;' .BUTTON_EMAIL.'</span></a></td></tr><tr><td style="text-align: center;"><a class="button" href="'.vam_href_link(FILENAME_CUSTOMERS, vam_get_all_get_params(array ('cID', 'action')).'cID='.$cInfo->customers_id.'&action=iplog').'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/ip.png', '', '12', '12') . '&nbsp;' .BUTTON_IPLOG.'</span></a></td><td style="text-align: center;"><a class="button" href="'.vam_href_link(FILENAME_CUSTOMERS, vam_get_all_get_params(array ('cID', 'action')).'cID='.$cInfo->customers_id.'&action=new_order').'" onClick="return confirm(\''.NEW_ORDER.'\')"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' .BUTTON_NEW_ORDER.'</span></a></td></tr></table>');

				$contents[] = array ('text' => '<br />'.TEXT_DATE_ACCOUNT_CREATED.' '.vam_date_short($cInfo->date_account_created));
				$contents[] = array ('text' => '<br />'.TEXT_DATE_ACCOUNT_LAST_MODIFIED.' '.vam_date_short($cInfo->date_account_last_modified));
				$contents[] = array ('text' => '<br />'.TEXT_INFO_DATE_LAST_LOGON.' '.vam_date_short($cInfo->date_last_logon));
				$contents[] = array ('text' => '<br />'.TEXT_INFO_NUMBER_OF_LOGONS.' '.$cInfo->number_of_logons);
				$contents[] = array ('text' => '<br />'.TEXT_INFO_COUNTRY.' '.$cInfo->countries_name);
				$contents[] = array ('text' => '<br />'.TEXT_INFO_NUMBER_OF_REVIEWS.' '.$cInfo->number_of_reviews);
			}

			if ($_GET['action'] == 'iplog') {
				if (isset ($_GET['cID'])) {
					$contents[] = array ('text' => '<br /><b>IPLOG :');
					$customers_id = vam_db_prepare_input($_GET['cID']);
					$customers_log_info_array = vam_get_user_info($customers_id);
					if (vam_db_num_rows($customers_log_info_array)) {
						while ($customers_log_info = vam_db_fetch_array($customers_log_info_array)) {
							$contents[] = array ('text' => '<tr>'."\n".'<td class="smallText">'.$customers_log_info['customers_ip_date'].' '.$customers_log_info['customers_ip'].' '.$customers_log_info['customers_advertiser']);
						}
					}
				}
				break;
			}
	}
	if ((vam_not_null($heading)) && (vam_not_null($contents))) {
		echo '            <td width="25%" valign="top">'."\n";

		$box = new box;
		echo $box->infoBox($heading, $contents);

		echo '            </td>'."\n";
	}
?>
          </tr>
        </table></td>
      </tr>
<?php

}
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>