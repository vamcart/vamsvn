<?php
/* -----------------------------------------------------------------------------------------
   $Id: checkout_new_address.php 1239 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(checkout_new_address.php,v 1.3 2003/05/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (checkout_new_address.php,v 1.8 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (checkout_new_address.php,v 1.8 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$module_smarty = new vamTemplate;
$module_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
// include needed functions

  include_once('inc/vam_get_zone_name.inc.php');
  include_once('inc/vam_get_country_list.inc.php');

if (!isset ($process))
	$process = false;

if (ACCOUNT_GENDER == 'true') {
	$male = ($gender == 'm') ? true : false;
	$female = ($gender == 'f') ? true : false;
	$module_smarty->assign('gender', '1');
	$module_smarty->assign('INPUT_MALE', vam_draw_radio_field(array ('name' => 'gender', 'suffix' => MALE), 'm', '', 'id="gender"'));
	$module_smarty->assign('INPUT_FEMALE', vam_draw_radio_field(array ('name' => 'gender', 'suffix' => FEMALE, 'text' => (vam_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">'.ENTRY_GENDER_TEXT.'</span>' : '')), 'f', '', 'id="gender"'));
   $module_smarty->assign('ENTRY_GENDER_ERROR', ENTRY_GENDER_ERROR);

}
$module_smarty->assign('INPUT_FIRSTNAME', vam_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">'.ENTRY_FIRST_NAME_TEXT.'</span>' : '')), '', 'id="firstname"'));
$module_smarty->assign('ENTRY_FIRST_NAME_ERROR', ENTRY_FIRST_NAME_ERROR);
$module_smarty->assign('INPUT_LASTNAME', vam_draw_input_fieldNote(array ('name' => 'lastname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">'.ENTRY_LAST_NAME_TEXT.'</span>' : '')), '', 'id="lastname"'));
$module_smarty->assign('ENTRY_LAST_NAME_ERROR', ENTRY_LAST_NAME_ERROR);

if (ACCOUNT_COMPANY == 'true') {
	$module_smarty->assign('company', '1');
	$module_smarty->assign('INPUT_COMPANY', vam_draw_input_fieldNote(array ('name' => 'company', 'text' => '&nbsp;'. (vam_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">'.ENTRY_COMPANY_TEXT.'</span>' : ''))));
} else {
	$module_smarty->assign('company', '0');
	//  }

}
if (ACCOUNT_STREET_ADDRESS == 'true') {
$module_smarty->assign('street_address', '1');
$module_smarty->assign('INPUT_STREET', vam_draw_input_fieldNote(array ('name' => 'street_address', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">'.ENTRY_STREET_ADDRESS_TEXT.'</span>' : '')), '', 'id="address"'));
$module_smarty->assign('ENTRY_STREET_ADDRESS_ERROR', ENTRY_STREET_ADDRESS_ERROR);
} else {
$module_smarty->assign('street_address', '0');
}

if (ACCOUNT_SUBURB == 'true') {
	$module_smarty->assign('suburb', '1');
	$module_smarty->assign('INPUT_SUBURB', vam_draw_input_fieldNote(array ('name' => 'suburb', 'text' => '&nbsp;'. (vam_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">'.ENTRY_SUBURB_TEXT.'</span>' : ''))));
} else {
	$module_smarty->assign('suburb', '0');
}

if (ACCOUNT_POSTCODE == 'true') {
$module_smarty->assign('postcode', '1');
$module_smarty->assign('INPUT_CODE', vam_draw_input_fieldNote(array ('name' => 'postcode', 'text' => '&nbsp;'. (vam_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">'.ENTRY_POST_CODE_TEXT.'</span>' : '')), '', 'id="postcode"'));
$module_smarty->assign('ENTRY_POST_CODE_ERROR', ENTRY_POST_CODE_ERROR);
} else {
$module_smarty->assign('postcode', '0');
}

if (ACCOUNT_CITY == 'true') {
$module_smarty->assign('city', '1');
$module_smarty->assign('INPUT_CITY', vam_draw_input_fieldNote(array ('name' => 'city', 'text' => '&nbsp;'. (vam_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">'.ENTRY_CITY_TEXT.'</span>' : '')), '', 'id="city"'));
$module_smarty->assign('ENTRY_CITY_ERROR', ENTRY_CITY_ERROR);
} else {
$module_smarty->assign('city', '0');
}

if (ACCOUNT_STATE == 'true') {
	$module_smarty->assign('state', '1');

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

		   $zone = vam_db_query("select distinct zone_id, zone_name from ".TABLE_ZONES." where zone_country_id = '".(int)$entry['entry_country_id']."' and (zone_name like '".vam_db_input($state)."%' or zone_code like '%".vam_db_input($state)."%')");

	      if (vam_db_num_rows($zone) > 0) {
	          $zone_id = $zone['zone_id'];
	          $zone_name = $zone['zone_name'];
	        }
	      }
		}
	}

      if ($entry_state_has_zones == true) {
        $state_input = vam_draw_pull_down_menuNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">'.ENTRY_STATE_TEXT.'</span>' : '')), $zones_array, $zone_name, ' id="state"');

      } else {
		 $state_input = vam_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">'.ENTRY_STATE_TEXT.'</span>' : '')), vam_get_zone_name($entry['entry_country_id'], $entry['entry_zone_id'], $entry['entry_state']), ' id="state"');

      }
		
	$module_smarty->assign('INPUT_STATE', $state_input);
   $module_smarty->assign('ENTRY_STATE_ERROR_SELECT', ENTRY_STATE_ERROR_SELECT);
} else {
	$module_smarty->assign('state', '0');
}

if (ACCOUNT_COUNTRY == 'true') {

  $module_smarty->assign('country','1');
  
  
  if ($process == true) $entry['entry_country_id'] = (int)$_POST['country'];

   $module_smarty->assign('SELECT_COUNTRY', vam_get_country_list('country', $entry['entry_country_id'], 'id="country", onChange="document.getElementById(\'stateXML\').innerHTML = \'' . ENTRY_STATEXML_LOADING . '\';loadXMLDoc(\'loadStateXML\',{country_id: this.value});"') . (vam_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="alert">' . ENTRY_COUNTRY_TEXT . '</span>': ''));

   $module_smarty->assign('SELECT_COUNTRY_NOSCRIPT', '<noscript><br />' . vam_image_submit('button_update.gif', IMAGE_BUTTON_UPDATE, 'name=loadStateXML') . '<br />' . ENTRY_STATE_RELOAD . '</noscript>');

   $module_smarty->assign('ENTRY_COUNTRY_ERROR', ENTRY_COUNTRY_ERROR);

} else {
	$smarty->assign('country', '0');
}

$module_smarty->assign('language', $_SESSION['language']);

$module_smarty->caching = 0;
$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/checkout_new_address.html');

$smarty->assign('MODULE_new_address', $module);
?>