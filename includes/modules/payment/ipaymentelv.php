<?php

/* -----------------------------------------------------------------------------------------
   $Id: ipaymentelv.php 998 2005-07-07 14:18:20Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ipayment.php,v 1.32 2003/01/29); www.oscommerce.com
   (c) 2003	 nextcommerce (ipayment.php,v 1.9 2003/08/24); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

class ipaymentelv {
	var $code, $title, $description, $enabled;

	function ipaymentelv() {
		global $order;

		$this->code = 'ipaymentelv';
		$this->title = MODULE_PAYMENT_IPAYMENTELV_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_IPAYMENTELV_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_IPAYMENTELV_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_IPAYMENTELV_STATUS == 'True') ? true : false);
		$this->info = MODULE_PAYMENT_EUTRANSFER_TEXT_INFO;
		if ((int) MODULE_PAYMENT_IPAYMENTELV_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_IPAYMENTELV_ORDER_STATUS_ID;
		}

		if (is_object($order))
			$this->update_status();

		$this->form_action_url = 'https://ipayment.de/merchant/'.MODULE_PAYMENT_IPAYMENTELV_ID.'/processor.php';
	}

	function update_status() {
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_IPAYMENTELV_ZONE > 0)) {
			$check_flag = false;
			$check_query = xtc_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_IPAYMENTELV_ZONE."' and zone_country_id = '".$order->billing['country']['id']."' order by zone_id");
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
		$js = '  if (payment_value == "'.$this->code.'") {'."\n".'    var bank_owner = document.getElementById("checkout_payment").ipayment_owner.value;'."\n".'    var bank_name = document.getElementById("checkout_payment").ipayment_bank_name.value;'."\n".'    var bank_id = document.getElementById("checkout_payment").ipayment_bank_code.value;'."\n".'    var bank_account = document.getElementById("checkout_payment").ipayment_bank_account.value;'."\n".'    var bank_iban = document.getElementById("checkout_payment").ipayment_bank_iban.value;'."\n".'    if (bank_owner == "" || bank_owner.length < 2) {'."\n".'      error_message = error_message + "'.MODULE_PAYMENT_IPAYMENTELV_TEXT_JS_BANK_OWNER.'";'."\n".'      error = 1;'."\n".'    }'."\n".'    if (bank_name == "" || bank_name.length < 2) {'."\n".'      error_message = error_message + "'.MODULE_PAYMENT_IPAYMENTELV_TEXT_JS_BANK_NAME.'";'."\n".'      error = 1;'."\n".'    }'."\n".'    if (bank_id == "" && bank_account == "" && bank_iban == "") {'."\n".'      error_message = error_message + "'.MODULE_PAYMENT_IPAYMENTELV_TEXT_JS_BANK_ALL_ERROR.'";'."\n".'      error = 1;'."\n".'    }'."\n".'    if (bank_id != "" && bank_account == "" && bank_iban == "") {'."\n".'      error_message = error_message + "'.MODULE_PAYMENT_IPAYMENTELV_TEXT_JS_BANK_ACCOUNT_ERROR.'";'."\n".'      error = 1;'."\n".'    }'."\n".'    if (bank_id == "" && bank_account != "" && bank_iban == "") {'."\n".'      error_message = error_message + "'.MODULE_PAYMENT_IPAYMENTELV_TEXT_JS_BANK_BLZ_ERROR.'";'."\n".'      error = 1;'."\n".'    }'."\n".'  }'."\n";

		return $js;
	}

	function selection() {
		global $order;

		for ($i = 1; $i < 13; $i ++) {
			$expires_month[] = array ('id' => sprintf('%02d', $i), 'text' => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)));
		}

		$today = getdate();
		for ($i = $today['year']; $i < $today['year'] + 10; $i ++) {
			$expires_year[] = array ('id' => strftime('%y', mktime(0, 0, 0, 1, 1, $i)), 'text' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)));
		}

		$selection = array ('id' => $this->code, 'module' => $this->title, 'fields' => array (array ('title' => MODULE_PAYMENT_IPAYMENTELV_TEXT_BANK_OWNER, 'field' => xtc_draw_input_field('ipayment_owner', $order->billing['firstname'].' '.$order->billing['lastname'])), array ('title' => MODULE_PAYMENT_IPAYMENTELV_TEXT_BANK_NAME, 'field' => xtc_draw_input_field('ipayment_bank_name')), array ('title' => MODULE_PAYMENT_IPAYMENTELV_TEXT_BANK_BLZ, 'field' => xtc_draw_input_field('ipayment_bank_code')), array ('title' => MODULE_PAYMENT_IPAYMENTELV_TEXT_BANK_NUMBER, 'field' => xtc_draw_input_field('ipayment_bank_account')), array ('title' => MODULE_PAYMENT_IPAYMENTELV_TEXT_BANK_IBAN, 'field' => xtc_draw_input_field('ipayment_bank_iban')), array ('field' => '&nbsp;<small>'.MODULE_PAYMENT_IPAYMENTELV_TEXT_IBAN.'</small>')), 'description' => $this->info);

		return $selection;
	}

	function pre_confirmation_check() {

		return false;
	}

	function confirmation() {

		$confirmation = array ('title' => $this->title.': ', 'fields' => array (array ('title' => MODULE_PAYMENT_IPAYMENTELV_TEXT_BANK_OWNER, 'field' => $_POST['ipayment_owner']), array ('title' => MODULE_PAYMENT_IPAYMENTELV_TEXT_BANK_NAME, 'field' => $_POST['ipayment_bank_name']), array ('title' => MODULE_PAYMENT_IPAYMENTELV_TEXT_BANK_BLZ, 'field' => $_POST['ipayment_bank_code']), array ('title' => MODULE_PAYMENT_IPAYMENTELV_TEXT_BANK_NUMBER, 'field' => $_POST['ipayment_bank_account']), array ('title' => MODULE_PAYMENT_IPAYMENTELV_TEXT_BANK_IBAN, 'field' => $_POST['ipayment_bank_iban'])));

		return $confirmation;
	}

	function process_button() {
		global $order, $xtPrice;

		switch (MODULE_PAYMENT_IPAYMENTELV_CURRENCY) {
			case 'Always EUR' :
				$trx_currency = 'EUR';
				break;
			case 'Always USD' :
				$trx_currency = 'USD';
				break;
			case 'Either EUR or USD, else EUR' :
				if (($_SESSION['currency'] == 'EUR') || ($_SESSION['currency'] == 'USD')) {
					$trx_currency = $_SESSION['currency'];
				} else {
					$trx_currency = 'EUR';
				}
				break;
			case 'Either EUR or USD, else USD' :
				if (($_SESSION['currency'] == 'EUR') || ($_SESSION['currency'] == 'USD')) {
					$trx_currency = $_SESSION['currency'];
				} else {
					$trx_currency = 'USD';
				}
				break;
		}
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
			$total = $order->info['total'] + $order->info['tax'];
		} else {
			$total = $order->info['total'];
		}
		if ($_SESSION['currency'] == $trx_currency) {
			$amount = $total;
		} else {
			$amount = $xtPrice->xtcCalculateCurrEx($total, $trx_currency);
		}

		$process_button_string = xtc_draw_hidden_field('silent', '1').xtc_draw_hidden_field('trx_paymenttyp', 'elv').xtc_draw_hidden_field('trxuser_id', MODULE_PAYMENT_IPAYMENTELV_USER_ID).xtc_draw_hidden_field('trxpassword', MODULE_PAYMENT_IPAYMENTELV_PASSWORD).xtc_draw_hidden_field('item_name', STORE_NAME).xtc_draw_hidden_field('trx_currency', $trx_currency).xtc_draw_hidden_field('trx_amount', round($amount * 100, 0)).xtc_draw_hidden_field('bank_name', $_POST['ipayment_bank_name']).xtc_draw_hidden_field('bank_code', $_POST['ipayment_bank_code']).xtc_draw_hidden_field('bank_accountnumber', $_POST['ipayment_bank_account']).xtc_draw_hidden_field('bank_iban', $_POST['ipayment_bank_iban']).xtc_draw_hidden_field('addr_name', $_POST['ipayment_owner']).xtc_draw_hidden_field('addr_street', $order->customer['street_address']).xtc_draw_hidden_field('addr_street2', '').xtc_draw_hidden_field('addr_zip', $order->customer['postcode']).xtc_draw_hidden_field('addr_city', $order->customer['city']).xtc_draw_hidden_field('addr_country', $order->customer['country']['iso_code_2']).xtc_draw_hidden_field('addr_email', $order->customer['email_address']).xtc_draw_hidden_field('addr_telefon', $order->customer['telephone']).xtc_draw_hidden_field('addr_telefax', '').xtc_draw_hidden_field('addr_state', $order->customer['state']).xtc_draw_hidden_field('redirect_url', xtc_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL', true)).xtc_draw_hidden_field('silent_error_url', xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error='.$this->code.'&ipayment_owner='.urlencode($_POST['ipayment_owner']), 'SSL', true));

		return $process_button_string;
	}

	function before_process() {
		return false;
	}

	function after_process() {
		return false;
	}

	function get_error() {

		$error = array ('title' => IPAYMENTELV_ERROR_HEADING, 'error' => ((isset ($_GET['ret_errormsg'])) ? stripslashes(urldecode($_GET['ret_errormsg'])) : IPAYMENTELV_ERROR_MESSAGE));

		return $error;
	}

	function check() {
		if (!isset ($this->_check)) {
			$check_query = xtc_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_IPAYMENTELV_STATUS'");
			$this->_check = xtc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_IPAYMENTELV_STATUS', 'True', '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_IPAYMENTELV_ALLOWED', '', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_IPAYMENTELV_ID', '99999', '6', '2', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_IPAYMENTELV_USER_ID', '99999', '6', '3', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_IPAYMENTELV_PASSWORD', '0', '6', '4', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_IPAYMENTELV_CURRENCY', 'Either EUR or USD, else EUR','6', '5', 'xtc_cfg_select_option(array(\'Always EUR\', \'Always USD\', \'Either EUR or USD, else EUR\', \'Either EUR or USD, else USD\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_IPAYMENTELV_SORT_ORDER', '0', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_IPAYMENTELV_ZONE', '0', '6', '2', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_IPAYMENTELV_ORDER_STATUS_ID', '0','6', '0', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
	}

	function remove() {
		xtc_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
	}

	function keys() {
		return array ('MODULE_PAYMENT_IPAYMENTELV_STATUS', 'MODULE_PAYMENT_IPAYMENTELV_ALLOWED', 'MODULE_PAYMENT_IPAYMENTELV_ID', 'MODULE_PAYMENT_IPAYMENTELV_USER_ID', 'MODULE_PAYMENT_IPAYMENTELV_PASSWORD', 'MODULE_PAYMENT_IPAYMENTELV_CURRENCY', 'MODULE_PAYMENT_IPAYMENTELV_ZONE', 'MODULE_PAYMENT_IPAYMENTELV_ORDER_STATUS_ID', 'MODULE_PAYMENT_IPAYMENTELV_SORT_ORDER');
	}
}
?>