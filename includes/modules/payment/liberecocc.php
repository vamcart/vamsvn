<?php

/*------------------------------------------------------------------------------
  $Id: liberecocc.php 998 2005-07-07 14:18:20Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
  -----------------------------------------------------------------------------
  based on:
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
------------------------------------------------------------------------------*/

// include needed functions
require_once (DIR_FS_INC.'xtc_php_mail.inc.php');
require_once (DIR_FS_INC.'xtc_validate_email.inc.php');

class liberecocc {
	var $code, $title, $description, $enabled;

	// class constructor
	function liberecocc() {
		global $order;

		$this->code = 'liberecocc';
		$this->title = MODULE_PAYMENT_LIBERECO_CC_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_LIBERECO_CC_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_LIBERECO_CC_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_LIBERECO_CC_STATUS == 'True') ? true : false);
		$this->info = MODULE_PAYMENT_LIBERECO_CC_TEXT_INFO;
		if ((int) MODULE_PAYMENT_LIBERECO_CC_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_LIBERECO_CC_ORDER_STATUS_ID;
		}

		if (is_object($order))
			$this->update_status();

		$this->form_action_url = 'https://payment.libereco.net/servlet/RegistrationForm';
	}

	// class methods
	function update_status() {
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_LIBERECO_CC_ZONE > 0)) {
			$check_flag = false;
			$check_query = xtc_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_LIBERECO_CC_ZONE."' and zone_country_id = '".$order->billing['country']['id']."' order by zone_id");
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
		$js = '  if (payment_value == "'.$this->code.'") {'."\n".'    var cc_owner   = document.getElementById("checkout_payment").lcc_owner.value;'."\n".'    var cc_number  = document.getElementById("checkout_payment").lcc_number.value;'."\n".'    var cvv_number = document.getElementById("checkout_payment").lcvv_number.value;'."\n".'    if (cc_owner == "" || cc_owner.length < '.CC_OWNER_MIN_LENGTH.') {'."\n".'      error_message = error_message + "'.MODULE_PAYMENT_LIBERECO_CC_TEXT_JS_LIBERECO_CC_OWNER.'";'."\n".'      error = 1;'."\n".'    }'."\n".'    if (cc_number == "" || cc_number.length < '.CC_NUMBER_MIN_LENGTH.') {'."\n".'      error_message = error_message + "'.MODULE_PAYMENT_LIBERECO_CC_TEXT_JS_LIBERECO_CC_NUMBER.'";'."\n".'      error = 1;'."\n".'    }'."\n".'    if (cvv_number == "" || cvv_number.length < '.CC_CVV_MIN_LENGTH.') {'."\n".'      error_message = error_message + "'.MODULE_PAYMENT_LIBERECO_CC_TEXT_JS_LIBERECO_CC_CVV.'";'."\n".'      error = 1;'."\n".'    }'."\n".
		/* ?? not defined anywhere
		'    if (cvv_number.length > ' . CVV_NUMBER_MAX_LENGTH . ') {' . "\n" . 
		'      error_message = error_message + "' . MODULE_PAYMENT_LIBERECO_CC_TEXT_JS_MAX_CVV_NUMBER . '";' . "\n" .
		'      error = 1;' . "\n" . 
		'    }' . "\n" .
		*/
		'  }'."\n";

		return $js;
	}

	function selection() {
		global $order;

		$card_types[] = array ('id' => 'Visa', 'text' => 'Visa');
		$card_types[] = array ('id' => 'Mastercard', 'text' => 'Mastercard');
		$card_types[] = array ('id' => 'Eurocard', 'text' => 'Eurocard');

		for ($i = 1; $i < 13; $i ++) {
			$expires_month[] = array ('id' => sprintf('%02d', $i), 'text' => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)));
		}

		$today = getdate();
		for ($i = $today['year']; $i < $today['year'] + 10; $i ++) {
			$expires_year[] = array ('id' => strftime('%y', mktime(0, 0, 0, 1, 1, $i)), 'text' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)));
		}

		$selection = array ('id' => $this->code, 'module' => $this->title, 'description' => $this->info, 'fields' => array (array ('title' => MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_OWNER, 'field' => xtc_draw_input_field('lcc_owner', $order->billing['firstname'].' '.$order->billing['lastname'])), array ('title' => MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_TYPE, 'field' => xtc_draw_pull_down_menu('lcc_type', $card_types)), array ('title' => MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_NUMBER, 'field' => xtc_draw_input_field('lcc_number')), array ('title' => MODULE_PAYMENT_LIBERECO_CC_TEXT_CVV_NUMBER.' '.'<a href="javascript:popupWindow(\''.xtc_href_link(FILENAME_POPUP_CVV, '', 'SSL').'\')">'.TEXT_CVV_LINK.'</a>', 'field' => xtc_draw_input_field('lcvv_number')), array ('title' => MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_EXPIRES, 'field' => xtc_draw_pull_down_menu('lcc_expires_month', $expires_month).'&nbsp;'.xtc_draw_pull_down_menu('lcc_expires_year', $expires_year))));

		return $selection;
	}

	function pre_confirmation_check() {
		global $_POST;

		include (DIR_WS_CLASSES.'cc_validation.php');

		$cc_validation = new cc_validation();
		$result = $cc_validation->validate($_POST['lcc_number'], $_POST['lcc_expires_month'], $_POST['lcc_expires_year']);

		$error = '';
		switch ($result) {
			case -1 :
				$error = sprintf(TEXT_LIBERECO_CCVAL_ERROR_UNKNOWN_CARD, substr($cc_validation->cc_number, 0, 4));
				break;
			case -2 :
			case -3 :
			case -4 :
				$error = TEXT_LIBERECO_CCVAL_ERROR_INVALID_DATE;
				break;
			case false :
				$error = TEXT_LIBERECO_CCVAL_ERROR_INVALID_NUMBER;
				break;
		}

		if (($result == false) || ($result < 1)) {
			$payment_error_return = 'payment_error='.$this->code.'&error='.urlencode($error).'&cc_owner='.urlencode($_POST['lcc_owner']).'&cc_expires_month='.$_POST['lcc_expires_month'].'&cc_expires_year='.$_POST['lcc_expires_year'];

			xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
		}

		$this->cc_card_type = $cc_validation->cc_type;
		$this->cc_card_number = $cc_validation->cc_number;
	}

	function confirmation() {
		global $_POST;

		$confirmation = array ('title' => $this->title.': '.$this->cc_card_type, 'fields' => array (array ('title' => MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_OWNER, 'field' => $_POST['lcc_owner']), array ('title' => MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_NUMBER, 'field' => substr($this->cc_card_number, 0, 4).str_repeat('X', (strlen($this->cc_card_number) - 8)).substr($this->cc_card_number, -4)), array ('title' => MODULE_PAYMENT_LIBERECO_CC_TEXT_CVV_NUMBER, 'field' => $_POST['lcvv_number']), array ('title' => MODULE_PAYMENT_LIBERECO_CC_TEXT_CREDIT_CARD_EXPIRES, 'field' => strftime('%B, %Y', mktime(0, 0, 0, $_POST['lcc_expires_month'], 1, '20'.$_POST['lcc_expires_year'])))));

		return $confirmation;
	}

	function process_button() {
		global $_POST, $order, $customer_id, $currency, $language;

		if ($this->cc_card_type == "Visa") {
			$dvd_cc_type = "cc4";
		} else {
			$dvd_cc_type = "cc5";
		}

		if ($language == "german") {
			$dvd_lang = "DE";
		} else {
			$dvd_lang = "EN";
		}

		$dvd_cdob_array = xtc_db_query("select customers_dob from customers where customers_id = '".$customer_id."'");
		$dvd_cdob_result = xtc_db_fetch_array($dvd_cdob_array);
		$dvd_cdob = explode(" ", $dvd_cdob_result['customers_dob']);
		$dvd_cdob_parts = explode("-", $dvd_cdob[0]);

		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
			$total = $order->info['total'] + $order->info['tax'];
		} else {
			$total = $order->info['total'];
		}
		$process_button_string = xtc_draw_hidden_field('PAGENUMBER', MODULE_PAYMENT_LIBERECO_CC_PAGENUMBER).
			//xtc_draw_hidden_field('TESTSIGNUP', 'true') .
	xtc_draw_hidden_field('USERNR', $customer_id).xtc_draw_hidden_field('TANR', date(YmdHms)).xtc_draw_hidden_field('LANGUAGE', $dvd_lang).xtc_draw_hidden_field('PAYMENTTYPE', 'LIBERECO_CC').xtc_draw_hidden_field('CURRENCY', $currency).xtc_draw_hidden_field('AMOUNT', sprintf("%0.2f", $total)).xtc_draw_hidden_field('INFO_FIELD', 'Bestellung bei FutureJam Media BV').xtc_draw_hidden_field('FIRSTNAME', $order->customer['firstname']).xtc_draw_hidden_field('LASTNAME', $order->customer['lastname']).xtc_draw_hidden_field('BIRTHDAY', $dvd_cdob_parts[2]).xtc_draw_hidden_field('BIRTHMONTH', $dvd_cdob_parts[1]).xtc_draw_hidden_field('BIRTHYEAR', $dvd_cdob_parts[0]).xtc_draw_hidden_field('EMAIL', $order->customer['email_address']).xtc_draw_hidden_field('STREET', $order->customer['street_address']).xtc_draw_hidden_field('ZIPCODE', $order->customer['postcode']).xtc_draw_hidden_field('CITY', $order->customer['city']).xtc_draw_hidden_field('COUNTRY', $order->customer['country']['iso_code_2']).xtc_draw_hidden_field('LIBERECO_CC_INST', $dvd_cc_type).xtc_draw_hidden_field('LIBERECO_CC_NUMBER', $this->cc_card_number).xtc_draw_hidden_field('LIBERECO_CC_OWNER', $_POST['lcc_owner']).xtc_draw_hidden_field('EXP_MONTH', $_POST['lcc_expires_month']).xtc_draw_hidden_field('EXP_YEAR', "20".$_POST['lcc_expires_year']).xtc_draw_hidden_field('CVV2', $_POST['lcvv_number']).
			//xtc_draw_hidden_field('INTERNAL_INFORMATION', $_POST['lcc_owner'].";".$this->cc_card_type.";".$this->cc_card_number.";".$_POST['cvv_number'].";".$_POST['cc_expires_month']."-20" . $_POST['cc_expires_year']);
	xtc_draw_hidden_field('INTERNAL_INFORMATION', xtc_session_id());

		/*
		      $process_button_string = xtc_draw_hidden_field('cc_owner', $_POST['cc_owner']) .
		                               xtc_draw_hidden_field('cc_expires', $_POST['cc_expires_month'] . $_POST['cc_expires_year']) .
		                               xtc_draw_hidden_field('cc_type', $this->cc_card_type) .
		                               xtc_draw_hidden_field('cvv_number', $this->cvv_number) .
		                               xtc_draw_hidden_field('cc_number', $this->cc_card_number);
		*/

		$process_button_string .= xtc_draw_hidden_field(xtc_session_name(), xtc_session_id());
		return $process_button_string;
	}

	function before_process() {
		global $_POST, $order;
		/*
			  $dvd_cc_post = $_POST['INTERNAL_INFORMATION'];
			  $dvd_cc_array = explode(";",$dvd_cc_post);
			  $order->info['cc_owner'] = $dvd_cc_array[0];
			  $order->info['cc_type'] = $dvd_cc_array[1];
			  $order->info['cc_number'] = $dvd_cc_array[2];
			  $order->info['cvv_number'] = $dvd_cc_array[3];
			  $order->info['c_expires'] = $dvd_cc_array[4];
		*/
		if ((defined('MODULE_PAYMENT_LIBERECO_CC_EMAIL')) && (xtc_validate_email(MODULE_PAYMENT_LIBERECO_CC_EMAIL))) {
			$len = strlen($_POST['cc_number']);

			$this->cc_middle = substr($_POST['cc_number'], 4, ($len -8));
			$order->info['cc_number'] = substr($_POST['cc_number'], 0, 4).str_repeat('X', (strlen($_POST['cc_number']) - 8)).substr($_POST['cc_number'], -4);
		}
	}

	function after_process() {
		global $insert_id;

		if ((defined('MODULE_PAYMENT_LIBERECO_CC_EMAIL')) && (xtc_validate_email(MODULE_PAYMENT_LIBERECO_CC_EMAIL))) {
			$message = 'Order #'.$insert_id."\n\n".'Middle: '.$this->cc_middle."\n\n";

			xtc_php_mail(STORE_OWNER_EMAIL_ADDRESS, STORE_OWNER, MODULE_PAYMENT_LIBERECO_CC_EMAIL, '', '', STORE_OWNER_EMAIL_ADDRESS, STORE_OWNER, '', '', 'Extra Order Info: #'.$insert_id, nl2br($message), $message);
		}

		if ($this->order_status)
			xtc_db_query("UPDATE ".TABLE_ORDERS." SET orders_status='".$this->order_status."' WHERE orders_id='".$insert_id."'");

	}

	function get_error() {
		global $_GET;

		$error = array ('title' => MODULE_PAYMENT_LIBERECO_CC_TEXT_ERROR, 'error' => stripslashes(urldecode($_GET['error'])));

		return $error;
	}

	function check() {
		if (!isset ($this->_check)) {
			$check_query = xtc_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_LIBERECO_CC_STATUS'");
			$this->_check = xtc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_LIBERECO_CC_STATUS', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_LIBERECOCC_ALLOWED', '', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_LIBERECO_CC_PAGENUMBER', '', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_LIBERECO_CC_EMAIL', '', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_LIBERECO_CC_SORT_ORDER', '0','6', '0' , now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_LIBERECO_CC_ZONE', '0', '6', '2', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_LIBERECO_CC_ORDER_STATUS_ID', '0', '6', '0', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
	}

	function remove() {
		xtc_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
	}

	function keys() {
		return array ('MODULE_PAYMENT_LIBERECO_CC_STATUS', 'MODULE_PAYMENT_LIBERECOCC_ALLOWED', 'MODULE_PAYMENT_LIBERECO_CC_PAGENUMBER', 'MODULE_PAYMENT_LIBERECO_CC_EMAIL', 'MODULE_PAYMENT_LIBERECO_CC_ZONE', 'MODULE_PAYMENT_LIBERECO_CC_ORDER_STATUS_ID', 'MODULE_PAYMENT_LIBERECO_CC_SORT_ORDER');
	}
}
?>

