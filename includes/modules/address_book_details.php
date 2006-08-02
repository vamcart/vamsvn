<?php
/* -----------------------------------------------------------------------------------------
   $Id: address_book_details.php 1239 2005-09-24 20:09:56Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(address_book_details.php,v 1.9 2003/05/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (address_book_details.php,v 1.9 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------/-----*/

  // include needed functions
  $module_smarty=new Smarty;
  $module_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
  include_once('inc/xtc_get_zone_name.inc.php');
  include_once('inc/xtc_get_country_list.inc.php');

 
  if (!isset($process)) $process = false;


  if (ACCOUNT_GENDER == 'true') {
    $male = ($entry['entry_gender'] == 'm') ? true : false;
    $female = ($entry['entry_gender'] == 'f') ? true : false;

  $module_smarty->assign('gender','1');
  $module_smarty->assign('INPUT_MALE',xtc_draw_radio_field(array('name'=>'gender','suffix'=>MALE.'&nbsp;'), 'm',$male));
  $module_smarty->assign('INPUT_FEMALE',xtc_draw_radio_field(array('name'=>'gender','suffix'=>FEMALE.'&nbsp;','text'=>(xtc_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">&nbsp;' . ENTRY_GENDER_TEXT . '</span>': '')), 'f',$female));


  }

  $module_smarty->assign('INPUT_FIRSTNAME',xtc_draw_input_fieldNote(array('name'=>'firstname','text'=>'&nbsp;' . (xtc_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': '')),$entry['entry_firstname']));
  $module_smarty->assign('INPUT_LASTNAME',xtc_draw_input_fieldNote(array('name'=>'lastname','text'=>'&nbsp;' . (xtc_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': '')),$entry['entry_lastname']));


  if (ACCOUNT_COMPANY == 'true') {
  $module_smarty->assign('company','1');
  $module_smarty->assign('INPUT_COMPANY',xtc_draw_input_fieldNote(array('name'=>'company','text'=>'&nbsp;' . (xtc_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': '')), $entry['entry_company']));


  }


  if (ACCOUNT_STREET_ADDRESS == 'true') {
  $module_smarty->assign('street_address','1');
  $module_smarty->assign('INPUT_STREET',xtc_draw_input_fieldNote(array('name'=>'street_address','text'=>'&nbsp;' . (xtc_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': '')), $entry['entry_street_address']));
  }

  if (ACCOUNT_SUBURB == 'true') {
  $module_smarty->assign('suburb','1');
  $module_smarty->assign('INPUT_SUBURB',xtc_draw_input_fieldNote(array('name'=>'suburb','text'=>'&nbsp;' . (xtc_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': '')), $entry['entry_suburb']));

  }

  if (ACCOUNT_POSTCODE == 'true') {
  $module_smarty->assign('postcode','1');
  $module_smarty->assign('INPUT_CODE',xtc_draw_input_fieldNote(array('name'=>'postcode','text'=>'&nbsp;' . (xtc_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': '')), $entry['entry_postcode']));
  }

  if (ACCOUNT_CITY == 'true') {
  $module_smarty->assign('city','1');
  $module_smarty->assign('INPUT_CITY',xtc_draw_input_fieldNote(array('name'=>'city','text'=>'&nbsp;' . (xtc_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': '')), $entry['entry_city']));
  }
  
if (ACCOUNT_STATE == 'true') {
	$module_smarty->assign('state', '1');

    if ($process != true) {

//	    $country = (isset($_POST['country']) ? xtc_db_prepare_input($_POST['country']) : STORE_COUNTRY);
	    $zone_id = 0;
		 $check_query = xtc_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".(int)$entry['entry_country_id']."'");
		 $check = xtc_db_fetch_array($check_query);
		 $entry_state_has_zones = ($check['total'] > 0);
		 if ($entry_state_has_zones == true) {
			$zones_array = array ();
			$zones_query = xtc_db_query("select zone_name from ".TABLE_ZONES." where zone_country_id = '".(int)$entry['entry_country_id']."' order by zone_name");
			while ($zones_values = xtc_db_fetch_array($zones_query)) {
				$zones_array[] = array ('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
			}
			
			$zone = xtc_db_query("select distinct zone_id, zone_name from ".TABLE_ZONES." where zone_country_id = '".(int)$entry['entry_country_id']."' and zone_code = '".xtc_db_input($state)."'");

	      if (xtc_db_num_rows($zone) > 0) {
	        $zone_id = $zone['zone_id'];
	        $zone_name = $zone['zone_name'];

	      } else {

		   $zone = xtc_db_query("select distinct zone_id, zone_name from ".TABLE_ZONES." where zone_country_id = '".(int)$entry['entry_country_id']."' and (zone_name like '".xtc_db_input($state)."%' or zone_code like '%".xtc_db_input($state)."%')");

	      if (xtc_db_num_rows($zone) > 0) {
	          $zone_id = $zone['zone_id'];
	          $zone_name = $zone['zone_name'];
	        }
	      }
		}
	}

      if ($entry_state_has_zones == true) {
        $state_input = xtc_draw_pull_down_menuNote(array ('name' => 'state', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">'.ENTRY_STATE_TEXT.'</span>' : '')), $zones_array, $zone_name, ' id="state"');

      } else {
		 $state_input = xtc_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">'.ENTRY_STATE_TEXT.'</span>' : '')), xtc_get_zone_name($entry['entry_country_id'], $entry['entry_zone_id'], $entry['entry_state']), ' id="state"');

      }
		
	$module_smarty->assign('INPUT_STATE', $state_input);
} else {
	$module_smarty->assign('state', '0');
}

  if ($_POST['country']){
  $selected = $_POST['country'];
  }else{
  $selected = $entry['entry_country_id'];
  }

if (ACCOUNT_COUNTRY == 'true') {

  $module_smarty->assign('country','1');
  
  
  if ($process == true) $entry['entry_country_id'] = (int)$_POST['country'];

   $module_smarty->assign('SELECT_COUNTRY', xtc_get_country_list('country', $entry['entry_country_id'], 'id="country", onChange="document.getElementById(\'stateXML\').innerHTML = \'' . ENTRY_STATEXML_LOADING . '\';loadXMLDoc(\'loadStateXML\',{country_id: this.value});"') . (xtc_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="alert">' . ENTRY_COUNTRY_TEXT . '</span>': ''));

   $module_smarty->assign('SELECT_COUNTRY_NOSCRIPT', '<noscript><br />' . xtc_image_submit('button_update.gif', IMAGE_BUTTON_UPDATE, 'name=loadStateXML') . '<br />' . ENTRY_STATE_RELOAD . '</noscript>');

} else {
	$smarty->assign('country', '0');
}

  if ((isset($_GET['edit']) && ($_SESSION['customer_default_address_id'] != $_GET['edit'])) || (isset($_GET['edit']) == false) ) {
  $module_smarty->assign('new','1');
  $module_smarty->assign('CHECKBOX_PRIMARY',xtc_draw_checkbox_field('primary', 'on', false, 'id="primary"'));

  }

  $module_smarty->assign('language', $_SESSION['language']);
  $module_smarty->caching = 0;
  $main_content=$module_smarty->fetch(CURRENT_TEMPLATE . '/module/address_book_details.html');
  $smarty->assign('MODULE_address_book_details',$main_content);
?>