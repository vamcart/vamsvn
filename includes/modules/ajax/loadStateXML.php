<?php
/* -----------------------------------------------------------------------------------------
   $Id: loadStateXML.php 1243 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 Andrew Berezin (loadStateXML.php,v 1.9 2003/08/17); zen-cart.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$country = $_REQUEST['country_id'];

	if ( isset($_REQUEST['country_id']) && vam_not_null($_REQUEST['country_id']) ) {
		$zones_array = array();
		$zones_query = vam_db_query("select zone_name from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' order by zone_name");

		if(vam_db_num_rows($zones_query) > 0) {
			if(vam_db_num_rows($zones_query) > 1) {
			while ($zones_values = vam_db_fetch_array($zones_query)) {
				$zones_array[] = array ('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
				}
				echo vam_draw_pull_down_menuNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), $zones_array, $zone_name, 'id="state"');
			} else {
				echo vam_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), $zones_values['zone_name'], 'id="state"');
			}
		} else {
			echo vam_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), '', 'id="state"');
		}
	} else {
		echo vam_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), '', 'id="state"');
	}
?>