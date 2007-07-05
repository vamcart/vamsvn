<?php
/* -----------------------------------------------------------------------------------------
   $Id: nochex.php 998 2007-02-06 21:07:20 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(nochex.php,v 1.12 2003/01/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (nochex.php,v 1.8 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (nochex.php,v 1.8 2003/08/23); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

class nochex {
	var $code, $title, $description, $enabled;

	function nochex() {
		global $order;

		$this->code = 'nochex';
		$this->title = MODULE_PAYMENT_NOCHEX_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_NOCHEX_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_NOCHEX_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_NOCHEX_STATUS == 'True') ? true : false);
		$this->info = MODULE_PAYMENT_NOCHEX_TEXT_INFO;
		if ((int) MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID;
		}

		if (is_object($order))
			$this->update_status();

		$this->form_action_url = 'https://www.nochex.com/nochex.dll/checkout';
	}

	function update_status() {
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_NOCHEX_ZONE > 0)) {
			$check_flag = false;
			$check_query = vam_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_NOCHEX_ZONE."' and zone_country_id = '".$order->billing['country']['id']."' order by zone_id");
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

	function javascript_validation() {
		return false;
	}

	function selection() {
		return array ('id' => $this->code, 'module' => $this->title, 'description' => $this->info);
	}

	function pre_confirmation_check() {
		return false;
	}

	function confirmation() {
		return false;
	}

	function process_button() {
		global $order, $vamPrice;
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
			$total = $order->info['total'] + $order->info['tax'];
		} else {
			$total = $order->info['total'];
		}
		$process_button_string = vam_draw_hidden_field('cmd', '_xclick').vam_draw_hidden_field('email', MODULE_PAYMENT_NOCHEX_ID).vam_draw_hidden_field('amount', round($vamPrice->CalculateCurrEx($total, 'GBP'), $vamPrice->get_decimal_places('GBP'))).vam_draw_hidden_field('ordernumber', $_SESSION['customer_id'].'-'.date('Ymdhis')).vam_draw_hidden_field('returnurl', vam_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')).vam_draw_hidden_field('cancel_return', vam_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));

		return $process_button_string;
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
		if (!isset ($this->_check)) {
			$check_query = vam_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_NOCHEX_STATUS'");
			$this->_check = vam_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_NOCHEX_STATUS', 'True', '6', '3', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOCHEX_ALLOWED', '', '6', '0', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOCHEX_ID', 'you@yourbuisness.com', '6', '4', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_NOCHEX_SORT_ORDER', '0', '6', '0', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_NOCHEX_ZONE', '0',  '6', '2', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID', '0', '6', '0', 'vam_cfg_pull_down_order_statuses(', 'vam_get_order_status_name', now())");
	}

	function remove() {
		vam_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
	}

	function keys() {
		return array ('MODULE_PAYMENT_NOCHEX_STATUS', 'MODULE_PAYMENT_NOCHEX_ALLOWED', 'MODULE_PAYMENT_NOCHEX_ID', 'MODULE_PAYMENT_NOCHEX_ZONE', 'MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID', 'MODULE_PAYMENT_NOCHEX_SORT_ORDER');
	}
}
?>