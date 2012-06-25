<?php
/*
  $Id: attributeManagerGeneralFunctions.inc.php,v 1.0 21/02/06 Sam West$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
  
  Copyright © 2006 Kangaroo Partners
  http://kangaroopartners.com
  osc@kangaroopartners.com
*/

function drawDropDownPrefix($params,$selected = '') {
	return vam_draw_pull_down_menu(
		"prefix",
		array(
			array('id'=>'','text'=>''),
			array('id'=>urlencode('+'),'text'=>'+'),
			array('id'=>'-','text'=>'-')
		),
		($selected == '+') ? urlencode('+') : $selected,
		$params
	);
}

function &amGetAttributeManagerInstance($get) {
	
	if (!is_numeric($get['products_id']) || AM_ATOMIC_PRODUCT_UPDATES) {

		// first time visiting the page - delete the session var and start again
		if('new_product' == $get[AM_PAGE_ACTION_NAME] && !vam_not_null($get[AM_ACTION_GET_VARIABLE])) 
			amSessionUnregister(AM_SESSION_VAR_NAME);	
			
			amSessionRegister(AM_SESSION_VAR_NAME, array());

// "=$" is depricated in newer versions of PHP	
//		$attributeManager =& new attributeManagerAtomic(amGetSesssionVariable(AM_SESSION_VAR_NAME));
		$attributeManager = new attributeManagerAtomic(amGetSesssionVariable(AM_SESSION_VAR_NAME));
	}
	else
//		$attributeManager =& new attributeManagerInstant($_GET['products_id']);
		$attributeManager = new attributeManagerInstant($_GET['products_id']);
		
	return $attributeManager;
}

?>