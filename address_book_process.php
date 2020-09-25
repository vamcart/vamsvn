<?php
/* -----------------------------------------------------------------------------------------
   $Id: address_book_process.php 1218 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(address_book_process.php,v 1.77 2003/05/27); www.oscommerce.com
   (c) 2003	 nextcommerce (address_book_process.php,v 1.13 2003/08/17); www.nextcommerce.org 
   (c) 2004	 xt:Commerce (address_book_process.php,v 1.13 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'vam_count_customer_address_book_entries.inc.php');
require_once (DIR_FS_INC.'vam_address_label.inc.php');
require_once (DIR_FS_INC.'vam_get_country_name.inc.php');

if (!isset ($_SESSION['customer_id']))
	vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL'));

if (isset ($_GET['action']) && ($_GET['action'] == 'deleteconfirm') && isset ($_GET['delete']) && is_numeric($_GET['delete'])) {
	vam_db_query("delete from ".TABLE_ADDRESS_BOOK." where address_book_id = '".(int) $_GET['delete']."' and customers_id = '".(int) $_SESSION['customer_id']."'");

	$messageStack->add_session('addressbook', SUCCESS_ADDRESS_BOOK_ENTRY_DELETED, 'success');

	vam_redirect(vam_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
}

// error checking when updating or adding an entry
$process = false;
if (isset ($_POST['action']) && (($_POST['action'] == 'process') || ($_POST['action'] == 'update'))) {
	$process = true;
	$error = false;

	if (ACCOUNT_GENDER == 'true' or ACCOUNT_GENDER == 'optional')
		$gender = vam_db_prepare_input($_POST['gender']);
	if (ACCOUNT_COMPANY == 'true' or ACCOUNT_COMPANY == 'optional')
		$company = vam_db_prepare_input($_POST['company']);
		$firstname = vam_db_prepare_input($_POST['firstname']);
	if (ACCOUNT_SECOND_NAME == 'true' or ACCOUNT_SECOND_NAME == 'optional')
		$secondname = vam_db_prepare_input($_POST['secondname']);
	if (ACCOUNT_LAST_NAME == 'true' or ACCOUNT_LAST_NAME == 'optional')
		$lastname = vam_db_prepare_input($_POST['lastname']);
   if (ACCOUNT_STREET_ADDRESS == 'true' or ACCOUNT_STREET_ADDRESS == 'optional')
	   $street_address = vam_db_prepare_input($_POST['street_address']);
	if (ACCOUNT_SUBURB == 'true' or ACCOUNT_SUBURB == 'optional')
		$suburb = vam_db_prepare_input($_POST['suburb']);
   if (ACCOUNT_POSTCODE == 'true' or ACCOUNT_POSTCODE == 'optional')
	   $postcode = vam_db_prepare_input($_POST['postcode']);
	if (ACCOUNT_CITY == 'true' or ACCOUNT_CITY == 'optional')
	   $city = vam_db_prepare_input($_POST['city']);
   if (ACCOUNT_COUNTRY == 'true' or ACCOUNT_COUNTRY == 'optional') {
	   $country = vam_db_prepare_input($_POST['country']);
	} else {
      $country = STORE_COUNTRY;
	}
	if (ACCOUNT_STATE == 'true' or ACCOUNT_STATE == 'optional') {
		$zone_id = vam_db_prepare_input($_POST['zone_id']);
		$state = vam_db_prepare_input($_POST['state']);
	}

	if (ACCOUNT_GENDER == 'true') {
		if (($gender != 'm') && ($gender != 'f')) {
			$error = true;

			$messageStack->add('addressbook', ENTRY_GENDER_ERROR);
		}
	}

	if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
		$error = true;

		$messageStack->add('addressbook', ENTRY_FIRST_NAME_ERROR);
	}

	if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
		$error = true;

		$messageStack->add('addressbook', ENTRY_LAST_NAME_ERROR);
	}

   if (ACCOUNT_STREET_ADDRESS == 'true') {
	if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
		$error = true;

		$messageStack->add('addressbook', ENTRY_STREET_ADDRESS_ERROR);
	}
  }

   if (ACCOUNT_POSTCODE == 'true') {
	if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
		$error = true;

		$messageStack->add('addressbook', ENTRY_POST_CODE_ERROR);
	}
  }

   if (ACCOUNT_CITY == 'true') {
	if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
		$error = true;

		$messageStack->add('addressbook', ENTRY_CITY_ERROR);
	}
  }

   if (ACCOUNT_COUNTRY == 'true') {
	if (is_numeric($country) == false) {
		$error = true;

		$messageStack->add('addressbook', ENTRY_COUNTRY_ERROR);
	}
  }

	if (ACCOUNT_STATE == 'true') {
		$zone_id = 0;
		$check_query = vam_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".(int) $country."'");
		$check = vam_db_fetch_array($check_query);
		$entry_state_has_zones = ($check['total'] > 0);
		if ($entry_state_has_zones == true) {
			$zone_query = vam_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' and zone_name = '" . vam_db_input($state) . "'"); 
			if (vam_db_num_rows($zone_query) == 1) {
				$zone = vam_db_fetch_array($zone_query);
				$zone_id = $zone['zone_id'];
			} else {
				$error = true;

				$messageStack->add('addressbook', ENTRY_STATE_ERROR_SELECT);
			}
		} else {
			if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
				$error = true;

				$messageStack->add('addressbook', ENTRY_STATE_ERROR);
			}
		}
	}

	if ($error == false) {
		$sql_data_array = array ('entry_firstname' => $firstname, 'entry_secondname' => $secondname, 'entry_lastname' => $lastname, 'entry_street_address' => $street_address, 'entry_postcode' => $postcode, 'entry_city' => $city, 'entry_country_id' => (int) $country,'address_last_modified' => 'now()');

		if (ACCOUNT_GENDER == 'true')
			$sql_data_array['entry_gender'] = $gender;
		if (ACCOUNT_COMPANY == 'true')
			$sql_data_array['entry_company'] = $company;
		if (ACCOUNT_SUBURB == 'true')
			$sql_data_array['entry_suburb'] = $suburb;
		if (ACCOUNT_STATE == 'true') {
			if ($zone_id > 0) {
				$sql_data_array['entry_zone_id'] = (int) $zone_id;
				$sql_data_array['entry_state'] = '';
			} else {
				$sql_data_array['entry_zone_id'] = '0';
				$sql_data_array['entry_state'] = $state;
			}
		}

		if ($_POST['action'] == 'update') {
			vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array, 'update', "address_book_id = '".(int) $_GET['edit']."' and customers_id ='".(int) $_SESSION['customer_id']."'");

			// reregister session variables
			if ((isset ($_POST['primary']) && ($_POST['primary'] == 'on')) || ($_GET['edit'] == $_SESSION['customer_default_address_id'])) {
				$_SESSION['customer_first_name'] = $firstname;
				$_SESSION['customer_second_name'] = $secondname;
				$_SESSION['customer_country_id'] = $country_id;
				$_SESSION['customer_zone_id'] = (($zone_id > 0) ? (int) $zone_id : '0');
				$_SESSION['customer_default_address_id'] = (int) $_GET['edit'];

				$sql_data_array = array ('customers_firstname' => $firstname, 'customers_secondname' => $secondname, 'customers_lastname' => $lastname, 'customers_default_address_id' => (int) $_GET['edit'],'customers_last_modified' => 'now()');

				if (ACCOUNT_GENDER == 'true')
					$sql_data_array['customers_gender'] = $gender;

				vam_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '".(int) $_SESSION['customer_id']."'");
			}
		} else {
			$sql_data_array['customers_id'] = (int) $_SESSION['customer_id'];
			$sql_data_array['address_date_added'] = 'now()';
			vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

			$new_address_book_id = vam_db_insert_id();

			// reregister session variables
			if (isset ($_POST['primary']) && ($_POST['primary'] == 'on')) {
				$_SESSION['customer_first_name'] = $firstname;
				$_SESSION['customer_second_name'] = $secondname;
				$_SESSION['customer_country_id'] = $country_id;
				$_SESSION['customer_zone_id'] = (($zone_id > 0) ? (int) $zone_id : '0');
				if (isset ($_POST['primary']) && ($_POST['primary'] == 'on'))
					$_SESSION['customer_default_address_id'] = $new_address_book_id;

				$sql_data_array = array ('customers_firstname' => $firstname, 'customers_secondname' => $secondname, 'customers_lastname' => $lastname,'customers_last_modified' => 'now()','customers_date_added' => 'now()');

				if (ACCOUNT_GENDER == 'true')
					$sql_data_array['customers_gender'] = $gender;
				if (isset ($_POST['primary']) && ($_POST['primary'] == 'on'))
					$sql_data_array['customers_default_address_id'] = $new_address_book_id;

				vam_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '".(int) $_SESSION['customer_id']."'");
			}
		}

		$messageStack->add_session('addressbook', SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED, 'success');

		vam_redirect(vam_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
	}
}

if (isset ($_GET['edit']) && is_numeric($_GET['edit'])) {
	$entry_query = vam_db_query("select entry_gender, entry_company, entry_firstname, entry_secondname, entry_lastname, entry_street_address, entry_suburb, entry_postcode, entry_city, entry_state, entry_zone_id, entry_country_id from ".TABLE_ADDRESS_BOOK." where customers_id = '".(int) $_SESSION['customer_id']."' and address_book_id = '".(int) $_GET['edit']."'");

	if (vam_db_num_rows($entry_query) == false) {
		$messageStack->add_session('addressbook', ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY);

		vam_redirect(vam_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
	}

	$entry = vam_db_fetch_array($entry_query);
}
elseif (isset ($_GET['delete']) && is_numeric($_GET['delete'])) {
	if ($_GET['delete'] == $_SESSION['customer_default_address_id']) {
		$messageStack->add_session('addressbook', WARNING_PRIMARY_ADDRESS_DELETION, 'warning');

		vam_redirect(vam_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
	} else {
		$check_query = vam_db_query("select count(*) as total from ".TABLE_ADDRESS_BOOK." where address_book_id = '".(int) $_GET['delete']."' and customers_id = '".(int) $_SESSION['customer_id']."'");
		$check = vam_db_fetch_array($check_query);

		if ($check['total'] < 1) {
			$messageStack->add_session('addressbook', ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY);

			vam_redirect(vam_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
		}
	}
} else {
	$entry = array ();
}

if (!isset ($_GET['delete']) && !isset ($_GET['edit'])) {
	if (vam_count_customer_address_book_entries() >= MAX_ADDRESS_BOOK_ENTRIES) {
		$messageStack->add_session('addressbook', ERROR_ADDRESS_BOOK_FULL);

		vam_redirect(vam_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
	}
}

$breadcrumb->add(NAVBAR_TITLE_1_ADDRESS_BOOK_PROCESS, vam_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ADDRESS_BOOK_PROCESS, vam_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));

if (isset ($_GET['edit']) && is_numeric($_GET['edit'])) {
	$breadcrumb->add(NAVBAR_TITLE_MODIFY_ENTRY_ADDRESS_BOOK_PROCESS, vam_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit='.$_GET['edit'], 'SSL'));
}
elseif (isset ($_GET['delete']) && is_numeric($_GET['delete'])) {
	$breadcrumb->add(NAVBAR_TITLE_DELETE_ENTRY_ADDRESS_BOOK_PROCESS, vam_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete='.$_GET['delete'], 'SSL'));
} else {
	$breadcrumb->add(NAVBAR_TITLE_ADD_ENTRY_ADDRESS_BOOK_PROCESS, vam_href_link(FILENAME_ADDRESS_BOOK_PROCESS, '', 'SSL'));
}

require (DIR_WS_INCLUDES.'header.php');
if (isset ($_GET['delete']) == false)
	$action = vam_draw_form('addressbook', vam_href_link(FILENAME_ADDRESS_BOOK_PROCESS, (isset ($_GET['edit']) ? 'edit='.$_GET['edit'] : ''), 'SSL'), 'post', 'onsubmit="return checkform(this);"') . vam_draw_hidden_field('required', 'gender,firstname,lastname,address,postcode,city,state,country', 'id="required"');

$vamTemplate->assign('FORM_ACTION', $action);
if ($messageStack->size('addressbook') > 0) {
	$vamTemplate->assign('error', $messageStack->output('addressbook'));

}

if (isset ($_GET['delete'])) {
	$vamTemplate->assign('delete', '1');
	$vamTemplate->assign('ADDRESS', vam_address_label($_SESSION['customer_id'], $_GET['delete'], true, ' ', '<br />'));

	$vamTemplate->assign('BUTTON_BACK', '<a class="button" href="'.vam_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL').'">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');
	$vamTemplate->assign('BUTTON_DELETE', '<a class="button" href="'.vam_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete='.$_GET['delete'].'&action=deleteconfirm', 'SSL').'">'.vam_image_button('delete.png', IMAGE_BUTTON_DELETE).'</a>');
} else {

	include (DIR_WS_MODULES.'address_book_details.php');

	if (isset ($_GET['edit']) && is_numeric($_GET['edit'])) {
		$vamTemplate->assign('BUTTON_BACK', '<a class="button" href="'.vam_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL').'">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');
		$vamTemplate->assign('BUTTON_UPDATE', vam_draw_hidden_field('action', 'update').vam_draw_hidden_field('edit', $_GET['edit']).vam_image_submit('update.png', IMAGE_BUTTON_UPDATE));

	} else {
		if (sizeof($_SESSION['navigation']->snapshot) > 0) {
			$back_link = vam_href_link($_SESSION['navigation']->snapshot['page'], vam_array_to_string($_SESSION['navigation']->snapshot['get'], array (vam_session_name())), $_SESSION['navigation']->snapshot['mode']);
		} else {
			$back_link = vam_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL');
		}
		$vamTemplate->assign('BUTTON_BACK', '<a class="button" href="'.$back_link.'">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');
		$vamTemplate->assign('BUTTON_UPDATE', vam_draw_hidden_field('action', 'process').vam_image_submit('submit.png',  IMAGE_BUTTON_CONTINUE));

	}
	$vamTemplate->assign('FORM_END', '</form>');

}

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/address_book_process.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_ADDRESS_BOOK_PROCESS.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_ADDRESS_BOOK_PROCESS.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>