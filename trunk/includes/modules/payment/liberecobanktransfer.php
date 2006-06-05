<?php

/* -----------------------------------------------------------------------------------------
   $Id: liberecobanktransfer.php 998 2005-07-07 14:18:20Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banktransfer.php,v 1.16 2003/03/02 22:01:50); www.oscommerce.com
   (c) 2003         nextcommerce (banktransfer.php,v 1.9 2003/08/24); www.nextcommerce.org

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   OSC German Banktransfer v0.85a               Autor:        Dominik Guder <osc@guder.org>

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class liberecobanktransfer {
	var $code, $title, $description, $enabled;

	// class constructor
	function liberecobanktransfer() {
		global $order;

		$this->code = 'liberecobanktransfer';
		$this->title = MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_LIBERECO_BANKTRANSFER_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_LIBERECO_BANKTRANSFER_STATUS == 'True') ? true : false);
		$this->info = MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_INFO;
		if ((int) MODULE_PAYMENT_LIBERECO_BANKTRANSFER_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_LIBERECO_BANKTRANSFER_ORDER_STATUS_ID;
		}
		if (is_object($order))
			$this->update_status();

		$this->form_action_url = 'https://payment.libereco.net/servlet/RegistrationForm';

		if ($_POST['banktransfer_fax'] == "on")
			$this->email_footer = MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_EMAIL_FOOTER;
	}

	// class methods
	function update_status() {
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_LIBERECO_BANKTRANSFER_ZONE > 0)) {
			$check_flag = false;
			$check_query = xtc_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_LIBERECO_BANKTRANSFER_ZONE."' and zone_country_id = '".$order->billing['country']['id']."' order by zone_id");
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
		// disable the module if the order only contains virtual products
	}

	function javascript_validation() {
		$js = 'if (payment_value == "'.$this->code.'") {'."\n".'  var banktransfer_blz    = document.getElementById("checkout_payment").banktransfer_blz.value;'."\n".'  var banktransfer_number = document.getElementById("checkout_payment").banktransfer_number.value;'."\n".'  var banktransfer_owner  = document.getElementById("checkout_payment").banktransfer_owner.value;'."\n".'  if (document.getElementById("checkout_payment").banktransfer_fax) {'."\n".'   var banktransfer_fax = document.getElementById("checkout_payment").banktransfer_fax.checked;'."\n".'  } else { banktransfer_fax = false; }'."\n".'  if (banktransfer_fax == false) {'."\n".'    if (banktransfer_blz == "") {'."\n".'      error_message = error_message + "'.JS_BANK_BLZ.'";'."\n".'      error = 1;'."\n".'    }'."\n".'    if (banktransfer_number == "") {'."\n".'      error_message = error_message + "'.JS_BANK_NUMBER.'";'."\n".'      error = 1;'."\n".'    }'."\n".'    if (banktransfer_owner == "") {'."\n".'      error_message = error_message + "'.JS_BANK_OWNER.'";'."\n".'      error = 1;'."\n".'    }'."\n".'  }'."\n".'}'."\n";
		return $js;
	}

	function selection() {
		global $order, $_POST;

		$selection = array ('id' => $this->code, 'module' => $this->title, 'fields' => array (array ('title' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_NOTE, 'field' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_INFO), array ('title' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_OWNER, 'field' => xtc_draw_input_field('banktransfer_owner', $order->billing['firstname'].' '.$order->billing['lastname'])), array ('title' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_BLZ, 'field' => xtc_draw_input_field('banktransfer_blz', '', 'size="8" maxlength="8"')), array ('title' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_NUMBER, 'field' => xtc_draw_input_field('banktransfer_number', '', 'size="16" maxlength="32"')), array ('title' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_NAME, 'field' => xtc_draw_input_field('banktransfer_bankname')), array ('title' => '', 'field' => xtc_draw_hidden_field('recheckok', $_POST['recheckok']))), 'description' => $this->info);

		if (MODULE_PAYMENT_LIBERECO_BANKTRANSFER_FAX_CONFIRMATION == 'true') {
			$selection['fields'][] = array ('title' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_NOTE, 'field' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_NOTE2.'<a href="'.MODULE_PAYMENT_LIBERECO_BANKTRANSFER_URL_NOTE.'" target="_blank"><b>'.MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_NOTE3.'</b></a>'.MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_NOTE4);
			$selection['fields'][] = array ('title' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_FAX, 'field' => xtc_draw_checkbox_field('banktransfer_fax', 'on'));

		}

		return $selection;
	}

	function pre_confirmation_check() {
		global $_POST;
		global $banktransfer_number, $banktransfer_blz;

		if ($_POST['banktransfer_fax'] == false) {
			include (DIR_WS_CLASSES.'banktransfer_validation.php');

			$banktransfer_validation = new AccountCheck;
			$banktransfer_result = $banktransfer_validation->CheckAccount($banktransfer_number, $banktransfer_blz);

			if ($banktransfer_result > 0 || $_POST['banktransfer_owner'] == '') {
				if ($_POST['banktransfer_owner'] == '') {
					$error = 'Name des Kontoinhabers fehlt!';
					$recheckok = '';
				} else {
					switch ($banktransfer_result) {
						case 1 : // number & blz not ok
							$error = MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_1;
							$recheckok = 'true';
							break;
						case 5 : // BLZ not found
							$error = MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_5;
							$recheckok = 'true';
							break;
						case 8 : // no blz entered
							$error = MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_8;
							$recheckok = '';
							break;
						case 9 : // no number entered
							$error = MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_9;
							$recheckok = '';
							break;
						default :
							$error = MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR_4;
							$recheckok = 'true';
							break;
					}
				}

				if ($_POST['recheckok'] != 'true') {
					$payment_error_return = 'payment_error='.$this->code.'&error='.urlencode($error).'&banktransfer_owner='.urlencode($_POST['banktransfer_owner']).'&banktransfer_number='.urlencode($_POST['banktransfer_number']).'&banktransfer_blz='.urlencode($_POST['banktransfer_blz']).'&banktransfer_bankname='.urlencode($_POST['banktransfer_bankname']).'&recheckok='.$recheckok;

					xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
				}
			}
			$this->banktransfer_owner = $_POST['banktransfer_owner'];
			$this->banktransfer_blz = $_POST['banktransfer_blz'];
			$this->banktransfer_number = $_POST['banktransfer_number'];
			$this->banktransfer_prz = $banktransfer_validation->PRZ;
			$this->banktransfer_status = $banktransfer_result;
			if ($banktransfer_validation->Bankname != '')
				$this->banktransfer_bankname = $banktransfer_validation->Bankname;
			else
				$this->banktransfer_bankname = $_POST['banktransfer_bankname'];
		}
	}

	function confirmation() {
		global $_POST, $banktransfer_val, $banktransfer_owner, $banktransfer_bankname, $banktransfer_blz, $banktransfer_number, $checkout_form_action, $checkout_form_submit;

		if (!$_POST['banktransfer_owner'] == '') {
			$confirmation = array ('title' => $this->title, 'fields' => array (array ('title' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_OWNER, 'field' => $this->banktransfer_owner), array ('title' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_BLZ, 'field' => $this->banktransfer_blz), array ('title' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_NUMBER, 'field' => $this->banktransfer_number), array ('title' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_NAME, 'field' => $this->banktransfer_bankname)));
		}
		if ($_POST['banktransfer_fax'] == "on") {
			$confirmation = array ('fields' => array (array ('title' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_FAX)));
			$this->banktransfer_fax = "on";
		}
		return $confirmation;
	}

	function process_button() {
		global $_POST, $order, $customer_id, $currency, $language;

		if ($language == "german") {
			$dvd_lang = "DE";
		} else {
			$dvd_lang = "EN";
		}

		$dvd_cdob_array = xtc_db_query("select customers_dob from customers where customers_id=$customer_id");
		$dvd_cdob_result = xtc_db_fetch_array($dvd_cdob_array);
		$dvd_cdob = explode(" ", $dvd_cdob_result['customers_dob']);
		$dvd_cdob_parts = explode("-", $dvd_cdob[0]);

		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
			$total = $order->info['total'] + $order->info['tax'];
		} else {
			$total = $order->info['total'];
		}
		$process_button_string = xtc_draw_hidden_field('PAGENUMBER', MODULE_PAYMENT_LIBERECO_BANKTRANSFER_PAGENUMBER).
			//			       xtc_draw_hidden_field('TESTSIGNUP', 'true') .
	xtc_draw_hidden_field('USERNR', $customer_id).xtc_draw_hidden_field('TANR', date(YmdHms)).xtc_draw_hidden_field('LANGUAGE', $dvd_lang).xtc_draw_hidden_field('PAYMENTTYPE', 'DD').xtc_draw_hidden_field('CURRENCY', $currency).xtc_draw_hidden_field('AMOUNT', sprintf("%0.2f", $total = '')).xtc_draw_hidden_field('INFO_FIELD', 'Bestellung bei FutureJam Media BV').xtc_draw_hidden_field('FIRSTNAME', $order->customer['firstname']).xtc_draw_hidden_field('LASTNAME', $order->customer['lastname']).xtc_draw_hidden_field('BIRTHDAY', $dvd_cdob_parts[2]).xtc_draw_hidden_field('BIRTHMONTH', $dvd_cdob_parts[1]).xtc_draw_hidden_field('BIRTHYEAR', $dvd_cdob_parts[0]).xtc_draw_hidden_field('EMAIL', $order->customer['email_address']).xtc_draw_hidden_field('STREET', $order->customer['street_address']).xtc_draw_hidden_field('ZIPCODE', $order->customer['postcode']).xtc_draw_hidden_field('CITY', $order->customer['city']).xtc_draw_hidden_field('COUNTRY', $order->customer['country']['iso_code_2']).xtc_draw_hidden_field('INTERNAL_INFORMATION', xtc_session_id()).xtc_draw_hidden_field('BANKCODE', $this->banktransfer_blz).xtc_draw_hidden_field('banktransfer_bankname', $this->banktransfer_bankname).xtc_draw_hidden_field('ACCOUNTNUMBER', $this->banktransfer_number).xtc_draw_hidden_field('ACCOUNTHOLDER', $this->banktransfer_owner).xtc_draw_hidden_field('banktransfer_status', $this->banktransfer_status).xtc_draw_hidden_field('banktransfer_prz', $this->banktransfer_prz).xtc_draw_hidden_field('banktransfer_fax', $this->banktransfer_fax);

		return $process_button_string;

	}

	function before_process() {
		return false;
	}

	function after_process() {
		global $insert_id, $_POST, $banktransfer_val, $banktransfer_owner, $banktransfer_bankname, $banktransfer_blz, $banktransfer_number, $banktransfer_status, $banktransfer_prz, $banktransfer_fax, $checkout_form_action, $checkout_form_submit;
		xtc_db_query("INSERT INTO banktransfer (orders_id, banktransfer_blz, banktransfer_bankname, banktransfer_number, banktransfer_owner, banktransfer_status, banktransfer_prz) VALUES ('".$insert_id."', '".$_POST['banktransfer_blz']."', '".$_POST['banktransfer_bankname']."', '".$_POST['banktransfer_number']."', '".$_POST['banktransfer_owner']."', '".$_POST['banktransfer_status']."', '".$_POST['banktransfer_prz']."')");
		if ($_POST['banktransfer_fax'])
			xtc_db_query("update banktransfer set banktransfer_fax = '".$_POST['banktransfer_fax']."' where orders_id = '".$insert_id."'");

		if ($this->order_status)
			xtc_db_query("UPDATE ".TABLE_ORDERS." SET orders_status='".$this->order_status."' WHERE orders_id='".$insert_id."'");

	}

	function get_error() {
		global $HTTP_GET_VARS;

		$error = array ('title' => MODULE_PAYMENT_LIBERECO_BANKTRANSFER_TEXT_BANK_ERROR, 'error' => stripslashes(urldecode($HTTP_GET_VARS['error'])));

		return $error;
	}

	function check() {
		if (!isset ($this->_check)) {
			$check_query = xtc_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_LIBERECO_BANKTRANSFER_STATUS'");
			$this->_check = xtc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_STATUS', 'True', '6', '1', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_ZONE', '0', '6', '2', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_LIBERECOBANKTRANSFER_ALLOWED', '', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_PAGENUMBER', '', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_SORT_ORDER', '0', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_ORDER_STATUS_ID', '0', '6', '0', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_FAX_CONFIRMATION', 'false', '6', '2', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_DATABASE_BLZ', 'false', '6', '0', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_URL_NOTE', 'fax.html','6', '0', now())");
		xtc_db_query("CREATE TABLE IF NOT EXISTS banktransfer (orders_id int(11) NOT NULL default '0', banktransfer_owner varchar(64) default NULL, banktransfer_number varchar(24) default NULL, banktransfer_bankname varchar(64) default NULL, banktransfer_blz varchar(8) default NULL, banktransfer_status int(11) default NULL, banktransfer_prz char(2) default NULL, banktransfer_fax char(2) default NULL, KEY orders_id(orders_id))");
	}

	function remove() {
		xtc_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
	}

	function keys() {
		return array ('MODULE_PAYMENT_LIBERECO_BANKTRANSFER_STATUS', 'MODULE_PAYMENT_LIBERECOBANKTRANSFER_ALLOWED', 'MODULE_PAYMENT_LIBERECO_BANKTRANSFER_PAGENUMBER', 'MODULE_PAYMENT_LIBERECO_BANKTRANSFER_ZONE', 'MODULE_PAYMENT_LIBERECO_BANKTRANSFER_ORDER_STATUS_ID', 'MODULE_PAYMENT_LIBERECO_BANKTRANSFER_SORT_ORDER', 'MODULE_PAYMENT_LIBERECO_BANKTRANSFER_DATABASE_BLZ', 'MODULE_PAYMENT_LIBERECO_BANKTRANSFER_FAX_CONFIRMATION', 'MODULE_PAYMENT_LIBERECO_BANKTRANSFER_URL_NOTE');
	}
}
?>

