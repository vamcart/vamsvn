<?php
/* -----------------------------------------------------------------------------------------
   $Id: kvitancia.php 998 2007-02-06 21:07:20 VaM $   

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

class kvitancia {
	var $code, $title, $description, $enabled;

	// class constructor
	function kvitancia() {
		$this->code = 'kvitancia';
		$this->title = MODULE_PAYMENT_KVITANCIA_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_KVITANCIA_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_KVITANCIA_SORT_ORDER;
		$this->info = MODULE_PAYMENT_KVITANCIA_TEXT_INFO;
		$this->enabled = ((MODULE_PAYMENT_KVITANCIA_STATUS == 'True') ? true : false);

		if ((int) MODULE_PAYMENT_KVITANCIA_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_KVITANCIA_ORDER_STATUS_ID;
		}

	}
	
	function update_status() {
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_KVITANCIA_ZONE > 0)) {
			$check_flag = false;
			$check_query = vam_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_KVITANCIA_ZONE."' and zone_country_id = '".$order->billing['country']['id']."' order by zone_id");
			while ($check = vam_db_fetch_array($check_query)) {
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

		$confirmation = array ('title' => $this->title.': '.$this->check, 'fields' => array (array ('title' => MODULE_PAYMENT_KVITANCIA_TEXT_DESCRIPTION)), 'description' => $this->info);

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
			vam_db_query("UPDATE ".TABLE_ORDERS." SET orders_status='".$this->order_status."' WHERE orders_id='".$insert_id."'");

	}

	function output_error() {
		return false;
	}

	function check() {
		if (!isset ($this->check)) {
			$check_query = vam_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_KVITANCIA_STATUS'");
			$this->check = vam_db_num_rows($check_query);
		}
		return $this->check;
	}

	function install() {
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KVITANCIA_ALLOWED', '', '6', '0', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_KVITANCIA_STATUS', 'True', '6', '3', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KVITANCIA_1', '---',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KVITANCIA_2', '---', '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KVITANCIA_3', '---',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KVITANCIA_4', '---',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KVITANCIA_5', '---',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KVITANCIA_6', '---',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KVITANCIA_7', '---',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KVITANCIA_8', '����� �����',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KVITANCIA_SORT_ORDER', '0',  '6', '0', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_KVITANCIA_ZONE', '0',  '6', '2', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_KVITANCIA_ORDER_STATUS_ID', '0', '6', '0', 'vam_cfg_pull_down_order_statuses(', 'vam_get_order_status_name', now())");

	}

	function remove() {
		vam_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
	}

	function keys() {
		$keys = array ('MODULE_PAYMENT_KVITANCIA_STATUS', 'MODULE_PAYMENT_KVITANCIA_ALLOWED', 'MODULE_PAYMENT_KVITANCIA_1', 'MODULE_PAYMENT_KVITANCIA_2', 'MODULE_PAYMENT_KVITANCIA_3', 'MODULE_PAYMENT_KVITANCIA_4', 'MODULE_PAYMENT_KVITANCIA_5', 'MODULE_PAYMENT_KVITANCIA_6', 'MODULE_PAYMENT_KVITANCIA_7', 'MODULE_PAYMENT_KVITANCIA_8', 'MODULE_PAYMENT_KVITANCIA_SORT_ORDER', 'MODULE_PAYMENT_KVITANCIA_ZONE', 'MODULE_PAYMENT_KVITANCIA_ORDER_STATUS_ID');

		return $keys;
	}
}
?>