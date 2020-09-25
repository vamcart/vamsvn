<?php
/* -----------------------------------------------------------------------------------------
   $Id: account_edit.php 1314 2007-02-06 19:20:03 VaM $
   
   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(account_edit.php,v 1.63 2003/05/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (account_edit.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (account_edit.php,v 1.14 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'vam_date_short.inc.php');
require_once (DIR_FS_INC.'vam_image_button.inc.php');
require_once (DIR_FS_INC.'vam_validate_email.inc.php');
require_once (DIR_FS_INC.'vam_get_geo_zone_code.inc.php');
require_once (DIR_FS_INC.'vam_get_customers_country.inc.php');

if (!isset ($_SESSION['customer_id']))
	vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL'));
	
if ($_SESSION['customers_status']['customers_status_id']==0)
	vam_redirect(vam_href_link_admin(FILENAME_CUSTOMERS, 'cID='.$_SESSION['customer_id'].'&action=edit', 'SSL'));

if (isset ($_POST['action']) && ($_POST['action'] == 'process')) {
	if (ACCOUNT_GENDER == 'true')
		$gender = vam_db_prepare_input($_POST['gender']);
	$firstname = vam_db_prepare_input($_POST['firstname']);
	if (ACCOUNT_SECOND_NAME == 'true' or ACCOUNT_SECOND_NAME == 'optional')
	$secondname = vam_db_prepare_input($_POST['secondname']);
	if (ACCOUNT_LAST_NAME == 'true' or ACCOUNT_LAST_NAME == 'optional')
	$lastname = vam_db_prepare_input($_POST['lastname']);
	if (ACCOUNT_DOB == 'true')
		$dob = vam_db_prepare_input($_POST['dob']);
	if (ACCOUNT_COMPANY_VAT_CHECK == 'true')
		$vat = vam_db_prepare_input($_POST['vat']);
	if (ACCOUNT_EMAIL == 'true' or ACCOUNT_EMAIL == 'optional')
	$email_address = vam_db_prepare_input($_POST['email_address']);
	$telephone = vam_db_prepare_input($_POST['telephone']);
	$fax = vam_db_prepare_input($_POST['fax']);
    vam_get_extra_fields($_SESSION['customer_id'], $_SESSION['languages_id']);

	$error = false;

	if (ACCOUNT_GENDER == 'true') {
		if (($gender != 'm') && ($gender != 'f')) {
			$error = true;
			$messageStack->add('account_edit', ENTRY_GENDER_ERROR);
		}
	}

	if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
		$error = true;
		$messageStack->add('account_edit', ENTRY_FIRST_NAME_ERROR);
	}

	if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
		$error = true;
		$messageStack->add('account_edit', ENTRY_LAST_NAME_ERROR);
	}

	if (ACCOUNT_DOB == 'true') {
		if (checkdate(substr(vam_date_raw($dob), 4, 2), substr(vam_date_raw($dob), 6, 2), substr(vam_date_raw($dob), 0, 4)) == false) {
			$error = true;
			$messageStack->add('account_edit', ENTRY_DATE_OF_BIRTH_ERROR);
		}
	}

	// New VAT Check
	$country = vam_get_customers_country($_SESSION['customer_id']);
	require_once(DIR_WS_CLASSES.'vat_validation.php');
	$vatID = new vat_validation($vat, $_SESSION['customer_id'], '', $country);

	$customers_status = $vatID->vat_info['status'];
	$customers_vat_id_status = $vatID->vat_info['vat_id_status'];
	$error = $vatID->vat_info['error'];

	if($error==1){
	$messageStack->add('account_edit', ENTRY_VAT_ERROR);
	$error = true;
  }

// New VAT CHECK END


	if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
		$error = true;
		$messageStack->add('account_edit', ENTRY_EMAIL_ADDRESS_ERROR);
	}

//	if (vam_validate_email($email_address) == false) {
//		$error = true;
//		$messageStack->add('account_edit', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
//	} else {
//		$check_email_query = vam_db_query("select count(*) as total from ".TABLE_CUSTOMERS." where customers_email_address = '".vam_db_input($email_address)."' and account_type = '0'");
//		$check_email = vam_db_fetch_array($check_email_query);
//		if ($check_email['total'] > 0) {
//			$error = true;
//
//			$messageStack->add('account_edit', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
//		}
//	}

	if (ACCOUNT_TELE == 'true') {
	if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
		$error = true;
		$messageStack->add('account_edit', ENTRY_TELEPHONE_NUMBER_ERROR);
	}
  }

        $extra_fields_query = vamDBquery("select ce.fields_id, ce.fields_input_type, ce.fields_required_status, cei.fields_name, ce.fields_status, ce.fields_input_type, ce.fields_size from " . TABLE_EXTRA_FIELDS . " ce, " . TABLE_EXTRA_FIELDS_INFO . " cei where ce.fields_status=1 and ce.fields_required_status=1 and cei.fields_id=ce.fields_id and cei.languages_id =" . $_SESSION['languages_id']);

   while($extra_fields = vam_db_fetch_array($extra_fields_query,true)){
   
    if(strlen($_POST['fields_' . $extra_fields['fields_id'] ])<$extra_fields['fields_size']){
      $error = true;
      $string_error=sprintf(ENTRY_EXTRA_FIELDS_ERROR,$extra_fields['fields_name'],$extra_fields['fields_size']);
      $messageStack->add('account_edit', $string_error);
    }
  }

	if ($error == false) {
		$sql_data_array = array ('customers_vat_id' => $vat, 'customers_vat_id_status' => (int) $customers_vat_id_status, 'customers_firstname' => $firstname, 'customers_secondname' => $secondname, 'customers_lastname' => $lastname, 'customers_email_address' => $email_address, 'customers_telephone' => $telephone, 'customers_fax' => $fax,'customers_last_modified' => 'now()');

		if (ACCOUNT_GENDER == 'true')
			$sql_data_array['customers_gender'] = $gender;
		if (ACCOUNT_DOB == 'true')
			$sql_data_array['customers_dob'] = vam_date_raw($dob);

		vam_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '".(int) $_SESSION['customer_id']."'");

		vam_db_query("update ".TABLE_CUSTOMERS_INFO." set customers_info_date_account_last_modified = now() where customers_info_id = '".(int) $_SESSION['customer_id']."'");

     $customers_id = (int)$_SESSION['customer_id'];
      vam_db_query("delete from " . TABLE_CUSTOMERS_TO_EXTRA_FIELDS . " where customers_id=" . (int)$customers_id);
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

// #CHAVEIRO14# Autologon
      vam_autologincookie(true);
// #CHAVEIRO14# Autologon END

		// reset the session variables
		$customer_first_name = $firstname;
		$messageStack->add_session('account', SUCCESS_ACCOUNT_UPDATED, 'success');
		vam_redirect(vam_href_link(FILENAME_ACCOUNT, '', 'SSL'));
	}
} else {
	$account_query = vam_db_query("select customers_gender, customers_cid, customers_vat_id, customers_vat_id_status, customers_firstname, customers_secondname, customers_lastname, customers_dob, customers_email_address, customers_telephone, customers_fax from ".TABLE_CUSTOMERS." where customers_id = '".(int) $_SESSION['customer_id']."'");
	$account = vam_db_fetch_array($account_query);
}

$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_EDIT, vam_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_EDIT, vam_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'));

require (DIR_WS_INCLUDES.'header.php');
$vamTemplate->assign('FORM_ACTION', vam_draw_form('account_edit', vam_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'), 'post').vam_draw_hidden_field('action', 'process'));

if ($messageStack->size('account_edit') > 0)
	$vamTemplate->assign('error', $messageStack->output('account_edit'));

if (ACCOUNT_GENDER == 'true') {
	$vamTemplate->assign('gender', '1');
	$male = ($account['customers_gender'] == 'm') ? true : false;
	$female = !$male;
	$vamTemplate->assign('INPUT_MALE', vam_draw_radio_field(array ('name' => 'gender', 'suffix' => MALE.'&nbsp;'), 'm', $male, 'id="gender" checked="checked"'));
	$vamTemplate->assign('INPUT_FEMALE', vam_draw_radio_field(array ('name' => 'gender', 'suffix' => FEMALE.'&nbsp;', 'text' => (vam_not_null(ENTRY_GENDER_TEXT) ? '<span class="Requirement">'.ENTRY_GENDER_TEXT.'</span>' : '')), 'f', $female, 'id="gender"'));
}

if (ACCOUNT_COMPANY_VAT_CHECK == 'true') {
	$vamTemplate->assign('vat', '1');
	$vamTemplate->assign('INPUT_VAT', vam_draw_input_fieldNote(array ('name' => 'vat', 'text' => '&nbsp;'. (vam_not_null(ENTRY_VAT_TEXT) ? '<span class="Requirement">'.ENTRY_VAT_TEXT.'</span>' : '')), $account['customers_vat_id']));
} else {
	$vamTemplate->assign('vat', '0');
}

$vamTemplate->assign('INPUT_FIRSTNAME', vam_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_FIRST_NAME_TEXT.'</span>' : '')), $account['customers_firstname'], 'id="firstname"'));
if (ACCOUNT_SECOND_NAME == 'true' or ACCOUNT_SECOND_NAME == 'optional') {
	$vamTemplate->assign('secondname', '1');
$vamTemplate->assign('INPUT_SECONDNAME', vam_draw_input_fieldNote(array ('name' => 'secondname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_SECOND_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_SECOND_NAME_TEXT.'</span>' : '')), $account['customers_secondname'], 'id="secondname"'));
}
if (ACCOUNT_LAST_NAME == 'true' or ACCOUNT_LAST_NAME == 'optional') {
	$vamTemplate->assign('lastname', '1');
$vamTemplate->assign('INPUT_LASTNAME', vam_draw_input_fieldNote(array ('name' => 'lastname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_LAST_NAME_TEXT.'</span>' : '')), $account['customers_lastname'], 'id="lastname"'));
$vamTemplate->assign('csID', $account['customers_cid']);
}
if (ACCOUNT_DOB == 'true') {
	$vamTemplate->assign('birthdate', '1');
	$vamTemplate->assign('INPUT_DOB', vam_draw_input_fieldNote(array ('name' => 'dob', 'text' => '&nbsp;'. (vam_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="Requirement">'.ENTRY_DATE_OF_BIRTH_TEXT.'</span>' : '')), vam_date_short($account['customers_dob']), 'id="dob"'));
}

if (ACCOUNT_EMAIL == 'true' or ACCOUNT_EMAIL == 'optional') {
	$vamTemplate->assign('email', '1');
$vamTemplate->assign('INPUT_EMAIL', vam_draw_input_fieldNote(array ('name' => 'email_address', 'text' => '&nbsp;'. (vam_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="Requirement">'.ENTRY_EMAIL_ADDRESS_TEXT.'</span>' : '')), $account['customers_email_address'], 'id="email_address"'));
}

if (ACCOUNT_TELE == 'true') {
	$vamTemplate->assign('telephone', '1');
   $vamTemplate->assign('INPUT_TEL', vam_draw_input_fieldNote(array ('name' => 'telephone', 'text' => '&nbsp;'. (vam_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="Requirement">'.ENTRY_TELEPHONE_NUMBER_TEXT.'</span>' : '')), $account['customers_telephone'], 'id="telephone"'));
}

if (ACCOUNT_FAX == 'true') {
	$vamTemplate->assign('fax', '1');
   $vamTemplate->assign('INPUT_FAX', vam_draw_input_fieldNote(array ('name' => 'fax', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="Requirement">'.ENTRY_FAX_NUMBER_TEXT.'</span>' : '')), $account['customers_fax']));
}

	$vamTemplate->assign('customers_extra_fileds', '1');
   $vamTemplate->assign('INPUT_CUSTOMERS_EXTRA_FIELDS', vam_get_extra_fields($_SESSION['customer_id'],$_SESSION['languages_id']));

$vamTemplate->assign('BUTTON_BACK', '<a class="button" href="'.vam_href_link(FILENAME_ACCOUNT, '', 'SSL').'">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');
$vamTemplate->assign('BUTTON_SUBMIT', vam_image_submit('submit.png',  IMAGE_BUTTON_CONTINUE));
$vamTemplate->assign('FORM_END', '</form>');
$vamTemplate->assign('language', $_SESSION['language']);

$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/account_edit.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_ACCOUNT_EDIT.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_ACCOUNT_EDIT.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>