<?php

/* -----------------------------------------------------------------------------------------
   $Id: qenta.php

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   qenta v1.0          Andreas Oberzier <xtc@netz-designer.de>

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class qenta {
	var $code, $title, $description, $enabled, $auth_num, $transaction_id;
	var $qLanguages, $qCurrencies, $qPaymentTypes, $defCurr, $defLang;

	// class constructor
	function qenta() {
		global $order, $language;

		$this->code = 'qenta';
		$this->title = MODULE_PAYMENT_QENTA_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_QENTA_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_QENTA_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_QENTA_STATUS == 'True') ? true : false);
		$this->info = MODULE_PAYMENT_QENTA_TEXT_INFO;
		$this->auth_num = '';
		$this->transaction_id = '';

		$this->qLanguages = array ("en", "de");

		$this->qCurrencies = array ("EUR", "USD", "CHF", "CAD", "JPY");

		$this->qPaymentTypes = array ("3DSEC", "SET", "MOSET", "BAT", "PBX", "PSC", "EPSDP", "EPSELBA", "EPSNTP", "EPSPOP", "DELV");
		$this->defPaymentType = 'MOSET';

		$result = xtc_db_query("SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = 'DEFAULT_CURRENCY'");
		list ($this->defCurr) = mysql_fetch_row($result);
		if (!in_array($this->defCurr, $this->qCurrencies)) {
			$this->defCurr = "EUR";
		}

		$result = xtc_db_query("SELECT configuration_value FROM ".TABLE_CONFIGURATION." WHERE configuration_key = 'DEFAULT_LANGUAGE'");
		list ($this->defLang) = mysql_fetch_row($result);
		if (!in_array($this->defLang, $this->qLanguages)) {
			$this->defLang = "de";
		}

		if ((int) MODULE_PAYMENT_QENTA_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_QENTA_ORDER_STATUS_ID;
		}

		if (is_object($order))
			$this->update_status();

		$this->form_action_url = 'https://www.qenta.com/qpay/checkin.php';
	}

	////
	// Status update
	function update_status() {
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_QENTA_ZONE > 0)) {
			$check_flag = false;
			$check_query = xtc_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_IEB_ZONE."' and zone_country_id = '".$order->billing['country']['id']."' order by zone_id");
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

	function pre_confirmation_check() {
		return false;
	}

	function confirmation() {
		return false;
	}

	function process_button() {
		global $order, $order_total_modules, $currencies, $xtPrice;

		$result = xtc_db_query("SELECT code FROM languages WHERE languages_id = '".$_SESSION['languages_id']."'");
		list ($lang_code) = mysql_fetch_row($result);
		$qLanguage = $lang_code;
		if ($qLanguage == "us") {
			$qLanguage = "en";
		}
		if (!in_array($qLanguage, $this->qLanguages)) {
			$qLanguage = MODULE_PAYMENT_QENTA_LANGUAGE;
		}

		$qCurrency = $currency;
		if (!in_array($currency, $this->qCurrencies)) {
			$qCurrency = MODULE_PAYMENT_QENTA_CURRENCY;
		}

		$this->transaction_id = $this->generate_trid();
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
			$total = $order->info['total'] + $order->info['tax'];
		} else {
			$total = $order->info['total'];
		}
		$request_fingerprint = md5(MODULE_PAYMENT_QENTA_MERCHANTKEY.round($xtPrice->xtcCalculateCurrEx($total, $qCurrency), $xtPrice->get_decimal_places($qCurrency)).$qCurrency.$qLanguage.$this->transaction_id.'-'.$order->customer['firstname'].' '.$order->customer['lastname'].xtc_href_link(FILENAME_CHECKOUT_PROCESS, 'trid='.$this->transaction_id, 'NONSSL', false).xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error=qenta', 'SSL', true, false).xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false).xtc_href_link(FILENAME_CONTACT_US, '', 'NONSSL', true, false).MODULE_PAYMENT_QENTA_IMAGEURL.MODULE_PAYMENT_QENTA_SECRET);

		$result = xtc_db_query("INSERT INTO payment_qenta (q_TRID, q_DATE) VALUES ('$this->transaction_id', NOW())");

		$process_button_string = xtc_draw_hidden_field('merchantKey', MODULE_PAYMENT_QENTA_MERCHANTKEY).xtc_draw_hidden_field('amount', round($xtPrice->xtcCalculateCurrEx($total, $qCurrency), $xtPrice->get_decimal_places($qCurrency))).xtc_draw_hidden_field('currency', $qCurrency).xtc_draw_hidden_field('paymentType', MODULE_PAYMENT_QENTA_PAYMENTTYPE).xtc_draw_hidden_field('language', $qLanguage).xtc_draw_hidden_field('orderDescription', $this->transaction_id.'-'.$order->customer['firstname'].' '.$order->customer['lastname']).xtc_draw_hidden_field('successURL', xtc_href_link(FILENAME_CHECKOUT_PROCESS, 'trid='.$this->transaction_id, 'NONSSL', false)).xtc_draw_hidden_field('failureURL', xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error=qenta', 'SSL', true, false)).xtc_draw_hidden_field('cancelURL', xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL', true, false)).xtc_draw_hidden_field('serviceURL', xtc_href_link(FILENAME_CONTACT_US, '', 'NONSSL', true, false)).xtc_draw_hidden_field('ImageURL', MODULE_PAYMENT_QENTA_IMAGEURL).xtc_draw_hidden_field('requestFingerprint', $request_fingerprint).xtc_draw_hidden_field('orderDesc', $this->transaction_id.'-'.$order->customer['firstname'].' '.$order->customer['lastname']);

		// moneyboocers.com payment gateway does not accept accented characters!
		// Please feel free to add any other accented characters to the list.
		return strtr($process_button_string, "áéíóöõúüûÁÉÍÓÖÕÚÜÛ", "aeiooouuuAEIOOOUUU");
	}

	// manage returning data from moneybookers (errors, failures, success etc.)
	function before_process() {

		global $order;

		$this->transaction_id = $_GET["trid"];

		$amount = $_GET['amount'];
		$currency = $_GET['currency'];
		$paymentType = $_GET['paymentType'];
		$language = $_GET['language'];
		$orderNumber = $_GET['orderNumber'];
		$responseFingerprint = $_GET['responseFingerprint'];
		$orderDesc = $_GET['orderDesc'];

		$check_fingerprint = md5($amount.$currency.$language.$orderNumber.MODULE_PAYMENT_QENTA_SECRET);

		if ($check_fingerprint != $responseFingerprint) {
			xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error=qenta', 'SSL', true, false));
		} else {
			$result = xtc_db_query("UPDATE payment_qenta SET q_QTID='".$orderNumber."', q_ORDERDESC='".$orderDesc."', q_status='1' WHERE q_TRID='".$this->transaction_id."'");
		}
	}

	function after_process() {
		global $insert_id;
		// Finally, insert order ID into the Qenta table
		$result = xtc_db_query("UPDATE payment_qenta SET q_ORDERID = $insert_id WHERE q_TRID = '$this->transaction_id'");
		if ($this->order_status)
			xtc_db_query("UPDATE ".TABLE_ORDERS." SET orders_status='".$this->order_status."' WHERE orders_id='".$insert_id."'");

	}

	function get_error() {

		$error = array ('title' => MODULE_PAYMENT_QENTA_TEXT_ERROR, 'error' => MODULE_PAYMENT_QENTA_ERROR);

		return $error;
	}

	function check() {
		if (!isset ($this->_check)) {
			$check_query = xtc_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_QENTA_STATUS'");
			$this->_check = xtc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {

		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_QENTA_STATUS', 'True',  '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_QENTA_MERCHANTKEY', '',  '6', '2', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_QENTA_PAYMENTTYPE', '".$this->defPaymentType."', '6', '3', 'xtc_cfg_select_option(".$this->show_array($this->qPaymentTypes)."), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_QENTA_IMAGEURL', '',  '6', '4', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_QENTA_SECRET', '',  '6', '5', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_QENTA_SORT_ORDER', '0',  '6', '4', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_QENTA_CURRENCY', '".$this->defCurr."', '6', '7', 'xtc_cfg_select_option(".$this->show_array($this->qCurrencies)."), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_QENTA_LANGUAGE', '".$this->defLang."', '6', '8', 'xtc_cfg_select_option(".$this->show_array($this->qLanguages)."), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_QENTA_ZONE', '0',  '6', '9', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_QENTA_ORDER_STATUS_ID', '0',  '6', '10', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_QENTA_ALLOWED', '', '6', '0', now())");
	}

	function remove() {
		xtc_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
	}

	function keys() {
		return array ('MODULE_PAYMENT_QENTA_STATUS', 'MODULE_PAYMENT_QENTA_MERCHANTKEY', 'MODULE_PAYMENT_QENTA_PAYMENTTYPE', 'MODULE_PAYMENT_QENTA_IMAGEURL', 'MODULE_PAYMENT_QENTA_SECRET', 'MODULE_PAYMENT_QENTA_LANGUAGE', 'MODULE_PAYMENT_QENTA_CURRENCY', 'MODULE_PAYMENT_QENTA_SORT_ORDER', 'MODULE_PAYMENT_QENTA_ORDER_STATUS_ID', 'MODULE_PAYMENT_QENTA_ZONE');
	}

	// Parse the predefinied array to be 'module install' friendly
	// as it is used for select in the module's install() function
	function show_array($aArray) {
		$aFormatted = "array(";
		foreach ($aArray as $key => $sVal) {
			$aFormatted .= "\'$sVal\', ";
		}
		$aFormatted = substr($aFormatted, 0, strlen($aFormatted) - 2);
		return $aFormatted;
	}

	function generate_trid() {

		do {
			$trid = xtc_create_random_value(16, "mixed");
			$result = xtc_db_query("SELECT q_TRID FROM payment_qenta WHERE q_TRID = '$trid'");
		} while (mysql_num_rows($result));

		return $trid;

	}
}
?>