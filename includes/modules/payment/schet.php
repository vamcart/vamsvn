<?php
/* -----------------------------------------------------------------------------------------
   $Id: schet.php 998 2007-02-06 21:07:20 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ptebanktransfer.php,v 1.4.1 2003/09/25 19:57:14); www.oscommerce.com
   (c) 2004	 xt:Commerce (eustandardtransfer.php,v 1.7 2003/08/23); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class schet {
	var $code, $title, $description, $enabled;

	// class constructor
	function schet() {
		$this->code = 'schet';
		$this->title = MODULE_PAYMENT_SCHET_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_SCHET_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_SCHET_SORT_ORDER;
		$this->info = MODULE_PAYMENT_SCHET_TEXT_INFO;
		$this->enabled = ((MODULE_PAYMENT_SCHET_STATUS == 'True') ? true : false);

		if ((int) MODULE_PAYMENT_SCHET_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_SCHET_ORDER_STATUS_ID;
		}

	}
	
	function update_status() {
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_SCHET_ZONE > 0)) {
			$check_flag = false;
			$check_query = xtc_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_SCHET_ZONE."' and zone_country_id = '".$order->billing['country']['id']."' order by zone_id");
			while ($check = xtc_db_fetch_array($check_query)) {
				if ($check['zone_id'] < 1) {
					$check_flag = true;
					break;
				}
				elseif ($check['zone_id'] == $order->billing['zone_id']) {
					$check_flag = true;
					break;
				}
			}

			if ($check_flag == false) {
				$this->enabled = false;
			}
		}
	}
	
	// class methods
	function javascript_validation() {
		return false;
	}

	function selection() {
		return array ('id' => $this->code, 'module' => $this->title, 'description' => $this->info);
	}
	//    function selection() {
	//      return false;
	//    }

	function pre_confirmation_check() {
		return false;
	}

	// I take no credit for this, I just hunted down variables, the actual code was stolen from the 2checkout
	// module.  About 20 minutes of trouble shooting and poof, here it is. -- Thomas Keats
	function confirmation() {
		global $_POST;

		$confirmation = array ('title' => $this->title.': '.$this->check, 'fields' => array (array ('title' => MODULE_PAYMENT_SCHET_TEXT_DESCRIPTION)), 'description' => $this->info);

		return $confirmation;
	}

	function process_button() {
		return false;
	}

	function before_process() {
		return false;
	}

	function after_process() {
		global $insert_id;
		if ($this->order_status)
			xtc_db_query("UPDATE ".TABLE_ORDERS." SET orders_status='".$this->order_status."' WHERE orders_id='".$insert_id."'");

	}

	function output_error() {
		return false;
	}

	function check() {
		if (!isset ($this->check)) {
			$check_query = xtc_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_SCHET_STATUS'");
			$this->check = xtc_db_num_rows($check_query);
		}
		return $this->check;
	}

	function install() {
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_ALLOWED', '', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_SCHET_STATUS', 'True', '6', '3', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now());");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_1', 'ООО \"Рога и копыта\"',  '6', '1', now());");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_2', 'Россия, 123456, г. Ставрополь, проспект Кулакова 8б, офис 130', '6', '1', now());");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_3', '(865)1234567',  '6', '1', now());");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_4', '(865)7654321',  '6', '1', now());");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_5', '1234567890',  '6', '1', now());");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_6', 'Росбанк',  '6', '1', now());");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_7', '0987654321',  '6', '1', now());");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_8', '123456',  '6', '1', now());");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_9', '87654321',  '6', '1', now());");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_10', '222222222',  '6', '1', now());");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_11', '11111111111111',  '6', '1', now());");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_12', '222222222222',  '6', '1', now());");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_SORT_ORDER', '0',  '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_SCHET_ZONE', '0',  '6', '2', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_SCHET_ORDER_STATUS_ID', '0', '6', '0', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");

	}

	function remove() {
		xtc_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
	}

	function keys() {
		$keys = array ('MODULE_PAYMENT_SCHET_STATUS', 'MODULE_PAYMENT_SCHET_ALLOWED', 'MODULE_PAYMENT_SCHET_1', 'MODULE_PAYMENT_SCHET_2', 'MODULE_PAYMENT_SCHET_3', 'MODULE_PAYMENT_SCHET_4', 'MODULE_PAYMENT_SCHET_5', 'MODULE_PAYMENT_SCHET_6', 'MODULE_PAYMENT_SCHET_7', 'MODULE_PAYMENT_SCHET_8', 'MODULE_PAYMENT_SCHET_9', 'MODULE_PAYMENT_SCHET_10', 'MODULE_PAYMENT_SCHET_11', 'MODULE_PAYMENT_SCHET_12', 'MODULE_PAYMENT_SCHET_SORT_ORDER', 'MODULE_PAYMENT_SCHET_ZONE', 'MODULE_PAYMENT_SCHET_ORDER_STATUS_ID');

		return $keys;
	}
}
?>