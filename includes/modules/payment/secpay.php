<?php

/* -----------------------------------------------------------------------------------------
   $Id: secpay.php 998 2005-07-07 14:18:20Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(secpay.php,v 1.31 2003/01/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (secpay.php,v 1.8 2003/08/24); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

class secpay {
	var $code, $title, $description, $enabled;

	function secpay() {
		global $order;

		$this->code = 'secpay';
		$this->title = MODULE_PAYMENT_SECPAY_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_SECPAY_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_SECPAY_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_SECPAY_STATUS == 'True') ? true : false);
		$this->info = MODULE_PAYMENT_SECPAY_TEXT_INFO;
		if ((int) MODULE_PAYMENT_SECPAY_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_SECPAY_ORDER_STATUS_ID;
		}

		if (is_object($order))
			$this->update_status();

		$this->form_action_url = 'https://www.secpay.com/java-bin/ValCard';
	}

	function update_status() {
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_SECPAY_ZONE > 0)) {
			$check_flag = false;
			$check_query = xtc_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_SECPAY_ZONE."' and zone_country_id = '".$order->billing['country']['id']."' order by zone_id");
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
		global $order, $xtPrice;

		switch (MODULE_PAYMENT_SECPAY_CURRENCY) {
			case 'Default Currency' :
				$sec_currency = DEFAULT_CURRENCY;
				break;
			case 'Any Currency' :
			default :
				$sec_currency = $_SESSION['currency'];
				break;
		}

		switch (MODULE_PAYMENT_SECPAY_TEST_STATUS) {
			case 'Always Fail' :
				$test_status = 'false';
				break;
			case 'Production' :
				$test_status = 'live';
				break;
			case 'Always Successful' :
			default :
				$test_status = 'true';
				break;
		}
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
			$total = $order->info['total'] + $order->info['tax'];
		} else {
			$total = $order->info['total'];
		}
		$process_button_string = xtc_draw_hidden_field('merchant', MODULE_PAYMENT_SECPAY_MERCHANT_ID).xtc_draw_hidden_field('trans_id', STORE_NAME.date('Ymdhis')).xtc_draw_hidden_field('amount', round($xtPrice->xtcCalculateCurrEx($total, $sec_currency), $xtPrice->get_decimal_places($sec_currency))).xtc_draw_hidden_field('bill_name', $order->billing['firstname'].' '.$order->billing['lastname']).xtc_draw_hidden_field('bill_addr_1', $order->billing['street_address']).xtc_draw_hidden_field('bill_addr_2', $order->billing['suburb']).xtc_draw_hidden_field('bill_city', $order->billing['city']).xtc_draw_hidden_field('bill_state', $order->billing['state']).xtc_draw_hidden_field('bill_post_code', $order->billing['postcode']).xtc_draw_hidden_field('bill_country', $order->billing['country']['title']).xtc_draw_hidden_field('bill_tel', $order->customer['telephone']).xtc_draw_hidden_field('bill_email', $order->customer['email_address']).xtc_draw_hidden_field('ship_name', $order->delivery['firstname'].' '.$order->delivery['lastname']).xtc_draw_hidden_field('ship_addr_1', $order->delivery['street_address']).xtc_draw_hidden_field('ship_addr_2', $order->delivery['suburb']).xtc_draw_hidden_field('ship_city', $order->delivery['city']).xtc_draw_hidden_field('ship_state', $order->delivery['state']).xtc_draw_hidden_field('ship_post_code', $order->delivery['postcode']).xtc_draw_hidden_field('ship_country', $order->delivery['country']['title']).xtc_draw_hidden_field('currency', $sec_currency).xtc_draw_hidden_field('callback', xtc_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL', false).';'.xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error='.$this->code, 'SSL', false)).xtc_draw_hidden_field(xtc_session_name(), xtc_session_id()).xtc_draw_hidden_field('options', 'test_status='.$test_status.',dups=false,cb_post=true,cb_flds='.xtc_session_name());

		return $process_button_string;
	}

	function before_process() {

		if ($_POST['valid'] == 'true') {
			if ($remote_host = getenv('REMOTE_HOST')) {
				if ($remote_host != 'secpay.com') {
					$remote_host = gethostbyaddr($remote_host);
				}
				if ($remote_host != 'secpay.com') {
					xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, xtc_session_name().'='.$_POST[xtc_session_name()].'&payment_error='.$this->code, 'SSL', false, false));
				}
			} else {
				xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, xtc_session_name().'='.$_POST[xtc_session_name()].'&payment_error='.$this->code, 'SSL', false, false));
			}
		}
	}

	function after_process() {
		global $insert_id;
		if ($this->order_status)
			xtc_db_query("UPDATE ".TABLE_ORDERS." SET orders_status='".$this->order_status."' WHERE orders_id='".$insert_id."'");

	}

	function get_error() {

		if (isset ($_GET['message']) && (strlen($_GET['message']) > 0)) {
			$error = stripslashes(urldecode($_GET['message']));
		} else {
			$error = MODULE_PAYMENT_SECPAY_TEXT_ERROR_MESSAGE;
		}

		return array ('title' => MODULE_PAYMENT_SECPAY_TEXT_ERROR, 'error' => $error);
	}

	function check() {
		if (!isset ($this->_check)) {
			$check_query = xtc_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_SECPAY_STATUS'");
			$this->_check = xtc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_SECPAY_STATUS', 'True', '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SECPAY_ALLOWED', '', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SECPAY_MERCHANT_ID', 'secpay',  '6', '2', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_SECPAY_CURRENCY', 'Any Currency',  '6', '3', 'xtc_cfg_select_option(array(\'Any Currency\', \'Default Currency\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_SECPAY_TEST_STATUS', 'Always Successful','6', '4', 'xtc_cfg_select_option(array(\'Always Successful\', \'Always Fail\', \'Production\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SECPAY_SORT_ORDER', '0',  '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_SECPAY_ZONE', '0',  '6', '2', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_SECPAY_ORDER_STATUS_ID', '0',  '6', '0', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
	}

	function remove() {
		xtc_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
	}

	function keys() {
		return array ('MODULE_PAYMENT_SECPAY_STATUS', 'MODULE_PAYMENT_SECPAY_ALLOWED', 'MODULE_PAYMENT_SECPAY_MERCHANT_ID', 'MODULE_PAYMENT_SECPAY_CURRENCY', 'MODULE_PAYMENT_SECPAY_TEST_STATUS', 'MODULE_PAYMENT_SECPAY_ZONE', 'MODULE_PAYMENT_SECPAY_ORDER_STATUS_ID', 'MODULE_PAYMENT_SECPAY_SORT_ORDER');
	}
}
?>