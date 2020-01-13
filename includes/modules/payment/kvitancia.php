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
	function __construct() {
		$this->code = 'kvitancia';
		$this->title = MODULE_PAYMENT_KVITANCIA_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_KVITANCIA_TEXT_DESCRIPTION;
		$this->icon = DIR_WS_ICONS . 'kvitancia.png';
		$this->sort_order = MODULE_PAYMENT_KVITANCIA_SORT_ORDER;
		$this->info = MODULE_PAYMENT_KVITANCIA_TEXT_INFO;
		$this->enabled = ((MODULE_PAYMENT_KVITANCIA_STATUS == 'True') ? true : false);

		if ((int) MODULE_PAYMENT_KVITANCIA_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_KVITANCIA_ORDER_STATUS_ID;
		}

		if (is_object($order))
			$this->update_status();
	}
	
	function update_status() {
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_KVITANCIA_ZONE > 0)) {
			$check_flag = false;
			$check_query = vam_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_KVITANCIA_ZONE."' and zone_country_id = '".$order->delivery['country']['id']."' order by zone_id");
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
      global $order;

		if (vam_not_null($this->icon)) $icon = vam_image($this->icon, $this->title);		
		
		//$person_query = vam_db_query("select * from ".TABLE_PERSONS." where customers_id = '" . (int)$order->customer['id'] . "'");
		//$person_data = vam_db_fetch_array($payment_query);
		
      $selection = array('id' => $this->code,
                         'module' => $this->title,
                         'icon' => $icon,
                         'description'=>$this->info,
      	                 'fields' => array(array('title' => '<div id="kvitancia">'.MODULE_PAYMENT_KVITANCIA_NAME_TITLE,
      	                                         'field' => MODULE_PAYMENT_KVITANCIA_NAME_DESC),
      	                                   array('title' => MODULE_PAYMENT_KVITANCIA_NAME.'<br />',
      	                                         'field' => vam_draw_input_field('kvit_name', $order->customer['firstname'] . ' ' . $order->customer['lastname'])),
      	                                   array('title' => MODULE_PAYMENT_KVITANCIA_ADDRESS.'<br />',
      	                                         'field' => vam_draw_input_field('kvit_address',$order->customer['city'] . ', ' . $order->customer['street_address']) . '<br />' . MODULE_PAYMENT_KVITANCIA_ADDRESS_HELP.'</div>'),
      	                                   ));

		return $selection;
      	                                   
	}

	function pre_confirmation_check() {

        $this->name = vam_db_prepare_input($_SESSION['kvit_name']);
        $this->address = vam_db_prepare_input($_SESSION['kvit_address']);

	}

	// I take no credit for this, I just hunted down variables, the actual code was stolen from the 2checkout
	// module.  About 20 minutes of trouble shooting and poof, here it is. -- Thomas Keats
	function confirmation() {

		$confirmation = array ('title' => $this->title.': '.$this->check, 'fields' => array (array ('title' => MODULE_PAYMENT_KVITANCIA_TEXT_DESCRIPTION)), 'description' => $this->info);

		return $confirmation;
	}

	function process_button() {

      $process_button_string = vam_draw_hidden_field('kvit_name', $this->name) .
                               vam_draw_hidden_field('kvit_address', $this->address);

      return $process_button_string;

	}

	function before_process() {

    	 $this->pre_confirmation_check();
    	return false;

	}

	function after_process() {

      global $insert_id, $name, $address, $checkout_form_action, $checkout_form_submit;
      vam_db_query("INSERT INTO ".TABLE_PERSONS." (orders_id, customers_id, name, address) VALUES ('" . vam_db_prepare_input($insert_id) . "', '" . (int)$_SESSION['customer_id'] . "', '" . vam_db_prepare_input($_SESSION['kvit_name']) . "', '" . vam_db_prepare_input($_SESSION['kvit_address']) ."')");

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
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_KVITANCIA_8', 'Заказ номер',  '6', '1', now());");
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