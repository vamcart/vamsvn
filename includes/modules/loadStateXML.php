<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: loadStateXML.php,v 1.0.0 08.03.2006 12:29 Andrew Berezin $
//

$country = $_REQUEST['country_id'];

	if ( isset($_REQUEST['country_id']) && xtc_not_null($_REQUEST['country_id']) ) {
		$zones_array = array();
		$zones_query = xtc_db_query("select zone_name from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' order by zone_name");

		if(xtc_db_num_rows($zones_query) > 0) {
			if(xtc_db_num_rows($zones_query) > 1) {
			while ($zones_values = xtc_db_fetch_array($zones_query)) {
				$zones_array[] = array ('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
				}
				$_RESULT = array("stateXML" => xtc_draw_pull_down_menu('state', $zones_array, $zone_name));
			} else {
				$_RESULT = array("stateXML" => xtc_draw_input_field('state', $zones_values['zone_name']));
			}
		} else {
			$_RESULT = array("stateXML" => xtc_draw_input_field('state', ''));
		}
	} else {
		$_RESULT = array("stateXML" => xtc_draw_input_field('state', ''));
	}
?>