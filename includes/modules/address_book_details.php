<?php
/* -----------------------------------------------------------------------------------------
   $Id: address_book_details.php 1239 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(address_book_details.php,v 1.9 2003/05/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (address_book_details.php,v 1.9 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (address_book_details.php,v 1.9 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  // include needed functions
  $module=new vamTemplate;
  $module->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
  include_once(DIR_FS_INC.'vam_get_zone_name.inc.php');
  include_once(DIR_FS_INC.'vam_get_country_list.inc.php');

 
  if (!isset($process)) $process = false;


  if (ACCOUNT_GENDER == 'true') {
    $male = ($entry['entry_gender'] == 'm') ? true : false;
    $female = ($entry['entry_gender'] == 'f') ? true : false;

  $module->assign('gender','1');
  $module->assign('INPUT_MALE',vam_draw_radio_field(array('name'=>'gender','suffix'=>MALE.'&nbsp;'), 'm',$male, 'id="gender" checked="checked"'));
  $module->assign('INPUT_FEMALE',vam_draw_radio_field(array('name'=>'gender','suffix'=>FEMALE.'&nbsp;','text'=>(vam_not_null(ENTRY_GENDER_TEXT) ? '<span class="Requirement">&nbsp;' . ENTRY_GENDER_TEXT . '</span>': '')), 'f',$female, 'id="gender"'));

  }

  $module->assign('INPUT_FIRSTNAME',vam_draw_input_fieldNote(array('name'=>'firstname','text'=>'&nbsp;' . (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="Requirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': '')),$entry['entry_firstname'], 'id="firstname"'));
if (ACCOUNT_SECOND_NAME == 'true') {
	$module->assign('secondname', '1');
$module->assign('INPUT_SECONDNAME', vam_draw_input_fieldNote(array ('name' => 'secondname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_SECOND_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_SECOND_NAME_TEXT.'</span>' : '')),$entry['entry_secondname'], 'id="secondname"'));
}
if (ACCOUNT_LAST_NAME == 'true') {
	$module->assign('lastname', '1');
  $module->assign('INPUT_LASTNAME',vam_draw_input_fieldNote(array('name'=>'lastname','text'=>'&nbsp;' . (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="Requirement">' . ENTRY_LAST_NAME_TEXT . '</span>': '')),$entry['entry_lastname'], 'id="lastname"'));
}

  if (ACCOUNT_COMPANY == 'true') {
  $module->assign('company','1');
  $module->assign('INPUT_COMPANY',vam_draw_input_fieldNote(array('name'=>'company','text'=>'&nbsp;' . (vam_not_null(ENTRY_COMPANY_TEXT) ? '<span class="Requirement">' . ENTRY_COMPANY_TEXT . '</span>': '')), $entry['entry_company']));
  }

  if (ACCOUNT_STREET_ADDRESS == 'true') {
  $module->assign('street_address','1');
  $module->assign('INPUT_STREET',vam_draw_input_fieldNote(array('name'=>'street_address','text'=>'&nbsp;' . (vam_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="Requirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': '')), $entry['entry_street_address'], 'id="street_address"'));
  }

  if (ACCOUNT_SUBURB == 'true') {
  $module->assign('suburb','1');
  $module->assign('INPUT_SUBURB',vam_draw_input_fieldNote(array('name'=>'suburb','text'=>'&nbsp;' . (vam_not_null(ENTRY_SUBURB_TEXT) ? '<span class="Requirement">' . ENTRY_SUBURB_TEXT . '</span>': '')), $entry['entry_suburb']));

  }

  if (ACCOUNT_POSTCODE == 'true') {
  $module->assign('postcode','1');
  $module->assign('INPUT_CODE',vam_draw_input_fieldNote(array('name'=>'postcode','text'=>'&nbsp;' . (vam_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="Requirement">' . ENTRY_POST_CODE_TEXT . '</span>': '')), $entry['entry_postcode'], 'id="postcode"'));
  }

  if (ACCOUNT_CITY == 'true') {
  $module->assign('city','1');
  $module->assign('INPUT_CITY',vam_draw_input_fieldNote(array('name'=>'city','text'=>'&nbsp;' . (vam_not_null(ENTRY_CITY_TEXT) ? '<span class="Requirement">' . ENTRY_CITY_TEXT . '</span>': '')), $entry['entry_city'], 'id="city"'));
  }
  
if (ACCOUNT_STATE == 'true') {
	$module->assign('state', '1');

if (!isset($entry['entry_country_id'])) $entry['entry_country_id']  = STORE_COUNTRY;
if (!isset($entry['entry_zone_id'])) $entry['entry_zone_id']  = STORE_ZONE;

    if ($process != true) {

//	    $country = (isset($_POST['country']) ? vam_db_prepare_input($_POST['country']) : STORE_COUNTRY);
	    $zone_id = 0;
		 $check_query = vam_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".(int)$entry['entry_country_id']."'");
		 $check = vam_db_fetch_array($check_query);
		 $entry_state_has_zones = ($check['total'] > 0);
		 if ($entry_state_has_zones == true) {
			$zones_array = array ();
			$zones_query = vam_db_query("select zone_name from ".TABLE_ZONES." where zone_country_id = '".(int)$entry['entry_country_id']."' order by zone_name");
			while ($zones_values = vam_db_fetch_array($zones_query)) {
				$zones_array[] = array ('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
			}
			
			$zone = vam_db_query("select distinct zone_id, zone_name from ".TABLE_ZONES." where zone_country_id = '".(int)$entry['entry_country_id']."' and zone_code = '".vam_db_input($state)."'");

	      if (vam_db_num_rows($zone) > 0) {
	        $zone_id = $zone['zone_id'];
	        $zone_name = $zone['zone_name'];

	      } else {

		   $zone = vam_db_query("select distinct zone_id, zone_name from ".TABLE_ZONES." where zone_country_id = '".(int)$entry['entry_country_id']."' and zone_code = '".vam_db_input($state)."'");

	      if (vam_db_num_rows($zone) > 0) {
	          $zone_id = $zone['zone_id'];
	          $zone_name = $zone['zone_name'];
	        }
	      }
		}
	}

      if ($entry_state_has_zones == true) {
        $state_input = vam_draw_pull_down_menuNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), $zones_array, vam_get_zone_name($entry['entry_country_id'], $entry['entry_zone_id'], $entry['entry_state']), ' id="state"');

      } else {
		 $state_input = vam_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), vam_get_zone_name(STORE_COUNTRY, STORE_ZONE), ' id="state"');

      }
		
	$module->assign('INPUT_STATE', $state_input);
} else {
	$module->assign('state', '0');
}

  if ($_POST['country']){
  $selected = $_POST['country'];
  }else{
  $selected = $entry['entry_country_id'];
  }

if (ACCOUNT_COUNTRY == 'true') {

  $module->assign('country','1');
  
  
  if ($process == true) $entry['entry_country_id'] = (int)$_POST['country'];

   $module->assign('SELECT_COUNTRY', vam_get_country_list('country', $entry['entry_country_id'], 'id="country"') . (vam_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="Requirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''));

   $module->assign('SELECT_COUNTRY_NOSCRIPT', '<noscript><br />' . vam_image_submit('update.png', IMAGE_BUTTON_UPDATE, 'name=loadStateXML') . '<br />' . ENTRY_STATE_RELOAD . '</noscript>');

} else {
	$vamTemplate->assign('country', '0');
}

  if ((isset($_GET['edit']) && ($_SESSION['customer_default_address_id'] != $_GET['edit'])) || (isset($_GET['edit']) == false) ) {
  $module->assign('new','1');
  $module->assign('CHECKBOX_PRIMARY',vam_draw_checkbox_field('primary', 'on', false, 'id="primary"'));

  }

  $module->assign('language', $_SESSION['language']);
  $module->caching = 0;
  $main_content=$module->fetch(CURRENT_TEMPLATE . '/module/address_book_details.html');
  $vamTemplate->assign('MODULE_address_book_details',$main_content);
?>