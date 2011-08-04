<?php
/* -----------------------------------------------------------------------------------------
   $Id: freedownload.php 1003 2007-02-06 21:07:20 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cod.php,v 1.28 2003/02/14); www.oscommerce.com 
   (c) 2003	 nextcommerce (cod.php,v 1.7 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (cod.php,v 1.7 2003/08/23); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

class freedownload {

	var $code, $title, $description, $enabled;

	function freedownload() {
		global $order,$vamPrice;

		$this->code = 'freedownload';
		$this->title = MODULE_PAYMENT_FREEDOWNLOAD_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_FREEDOWNLOAD_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_FREEDOWNLOAD_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_FREEDOWNLOAD_STATUS == 'True') ? true : false);
		$this->info = MODULE_PAYMENT_FREEDOWNLOAD_TEXT_INFO;
		$this->cost;

		if ((int) MODULE_PAYMENT_FREEDOWNLOAD_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_FREEDOWNLOAD_ORDER_STATUS_ID;
		}

		if (is_object($order))
			$this->update_status();
	}

	function update_status() {
		global $order, $vamPrice;
		if (!is_object($_SESSION['cart'])) {
		if ($_SESSION['cart']->get_content_type() != 'virtual' || $_SESSION['cart']->show_total() != 0) {
			$this->enabled = false;
		}
		}
		if (($this->enabled == true) && ((int) MODULE_PAYMENT_FREEDOWNLOAD_ZONE > 0)) {
			$check_flag = false;
			$check_query = vam_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_FREEDOWNLOAD_ZONE."' and zone_country_id = '".$order->delivery['country']['id']."' order by zone_id");
			while ($check = vam_db_fetch_array($check_query)) {
				if ($check['zone_id'] < 1) {
					$check_flag = true;
					break;
				}
				elseif ($check['zone_id'] == $order->delivery['zone_id']) {
					$check_flag = true;
					break;
				}
			}

			if ($check_flag == false) {
				$this->enabled = false;
			}
		}

	}

	function javascript_validation() {
		return false;
	}

	function selection() {
		global $vamPrice,$order;
		
		return array ('id' => $this->code, 'module' => $this->title, 'description' => $this->info,'module_cost'=>$this->cost);
	}

	function pre_confirmation_check() {
		return false;
	}

	function confirmation() {
		return false;
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

	function get_error() {
		return false;
	}

	function check() {
		if (!isset ($this->_check)) {
			$check_query = vam_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_FREEDOWNLOAD_STATUS'");
			$this->_check = vam_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_FREEDOWNLOAD_STATUS', 'True',  '6', '1', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_FREEDOWNLOAD_ALLOWED', '', '6', '0', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_FREEDOWNLOAD_ZONE', '0', '6', '2', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_FREEDOWNLOAD_SORT_ORDER', '0',  '6', '0', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_FREEDOWNLOAD_ORDER_STATUS_ID', '0','6', '0', 'vam_cfg_pull_down_order_statuses(', 'vam_get_order_status_name', now())");
	}

	function remove() {
		vam_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
	}

	function keys() {
		return array ('MODULE_PAYMENT_FREEDOWNLOAD_STATUS', 'MODULE_PAYMENT_FREEDOWNLOAD_ALLOWED', 'MODULE_PAYMENT_FREEDOWNLOAD_ZONE', 'MODULE_PAYMENT_FREEDOWNLOAD_ORDER_STATUS_ID', 'MODULE_PAYMENT_FREEDOWNLOAD_SORT_ORDER');
	}
}
?>