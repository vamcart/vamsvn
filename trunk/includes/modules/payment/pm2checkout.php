<?php
/* -----------------------------------------------------------------------------------------
   $Id: pm2checkout.php 998 2007-02-06 21:07:20 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(pm2checkout.php,v 1.19 2003/01/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (pm2checkout.php,v 1.8 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (pm2checkout.php,v 1.8 2003/08/23); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

class pm2checkout {
	var $code, $title, $description, $enabled;

	function pm2checkout() {
		global $order;

		$this->code = 'pm2checkout';
		$this->title = MODULE_PAYMENT_PM2CHECKOUT_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_PM2CHECKOUT_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_PM2CHECKOUT_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_PM2CHECKOUT_STATUS == 'True') ? true : false);
		$this->info = MODULE_PAYMENT_PM2CHECKOUT_TEXT_INFO;
		if ((int) MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID;
		}

		if (is_object($order))
			$this->update_status();

		$this->form_action_url = 'https://www.2checkout.com/cgi-bin/Abuyers/purchase.2c';
	}

	function update_status() {
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_PM2CHECKOUT_ZONE > 0)) {
			$check_flag = false;
			$check_query = vam_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_PM2CHECKOUT_ZONE."' and zone_country_id = '".$order->billing['country']['id']."' order by zone_id");
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
		$js = '  if (payment_value == "'.$this->code.'") {'."\n".'    var cc_number = document.getElementById("checkout_payment").pm_2checkout_cc_number.value;'."\n".'    if (cc_number == "" || cc_number.length < '.CC_NUMBER_MIN_LENGTH.') {'."\n".'      error_message = error_message + "'.MODULE_PAYMENT_PM2CHECKOUT_TEXT_JS_CC_NUMBER.'";'."\n".'      error = 1;'."\n".'    }'."\n".'  }'."\n";

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

		$selection = array ('id' => $this->code, 'module' => $this->title, 'description' => $this->info, 'fields' => array (array ('title' => MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_OWNER_FIRST_NAME, 'field' => vam_draw_input_field('pm_2checkout_cc_owner_firstname', $order->billing['firstname'])), array ('title' => MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_OWNER_LAST_NAME, 'field' => vam_draw_input_field('pm_2checkout_cc_owner_lastname', $order->billing['lastname'])), array ('title' => MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_NUMBER, 'field' => vam_draw_input_field('pm_2checkout_cc_number')), array ('title' => MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_EXPIRES, 'field' => vam_draw_pull_down_menu('pm_2checkout_cc_expires_month', $expires_month).'&nbsp;'.vam_draw_pull_down_menu('pm_2checkout_cc_expires_year', $expires_year)), array ('title' => MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER, 'field' => vam_draw_input_field('pm_2checkout_cc_cvv', '', 'size="4" maxlength="3"').'&nbsp;<small>'.MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION.'</small>')));

		return $selection;
	}

	function pre_confirmation_check() {

		include (DIR_WS_CLASSES.'cc_validation.php');

		$cc_validation = new cc_validation();
		$result = $cc_validation->validate($_POST['pm_2checkout_cc_number'], $_POST['pm_2checkout_cc_expires_month'], $_POST['pm_2checkout_cc_expires_year']);

		$error = '';
		switch ($result) {
			case -1 :
				$error = sprintf(TEXT_CCVAL_ERROR_UNKNOWN_CARD, substr($cc_validation->cc_number, 0, 4));
				break;
			case -2 :
			case -3 :
			case -4 :
				$error = TEXT_CCVAL_ERROR_INVALID_DATE;
				break;
			case false :
				$error = TEXT_CCVAL_ERROR_INVALID_NUMBER;
				break;
		}

		if (($result == false) || ($result < 1)) {
			$payment_error_return = 'payment_error='.$this->code.'&error='.urlencode($error).'&pm_2checkout_cc_owner_firstname='.urlencode($_POST['pm_2checkout_cc_owner_firstname']).'&pm_2checkout_cc_owner_lastname='.urlencode($_POST['pm_2checkout_cc_owner_lastname']).'&pm_2checkout_cc_expires_month='.$_POST['pm_2checkout_cc_expires_month'].'&pm_2checkout_cc_expires_year='.$_POST['pm_2checkout_cc_expires_year'];

			vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, $payment_error_return, 'SSL', true, false));
		}

		$this->cc_card_type = $cc_validation->cc_type;
		$this->cc_card_number = $cc_validation->cc_number;
		$this->cc_expiry_month = $cc_validation->cc_expiry_month;
		$this->cc_expiry_year = $cc_validation->cc_expiry_year;
	}

	function confirmation() {

		$confirmation = array ('title' => $this->title.': '.$this->cc_card_type, 'fields' => array (array ('title' => MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_OWNER, 'field' => $_POST['pm_2checkout_cc_owner_firstname'].' '.$_POST['pm_2checkout_cc_owner_lastname']), array ('title' => MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_NUMBER, 'field' => substr($this->cc_card_number, 0, 4).str_repeat('X', (strlen($this->cc_card_number) - 8)).substr($this->cc_card_number, -4)), array ('title' => MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_EXPIRES, 'field' => strftime('%B, %Y', mktime(0, 0, 0, $_POST['pm_2checkout_cc_expires_month'], 1, '20'.$_POST['pm_2checkout_cc_expires_year'])))));

		return $confirmation;
	}

	function process_button() {
		global $order;
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
			$total = $order->info['total'] + $order->info['tax'];
		} else {
			$total = $order->info['total'];
		}
		$process_button_string = vam_draw_hidden_field('x_login', MODULE_PAYMENT_PM2CHECKOUT_LOGIN).vam_draw_hidden_field('x_amount', round($total, 2)).vam_draw_hidden_field('x_invoice_num', date('YmdHis')).vam_draw_hidden_field('x_test_request', ((MODULE_PAYMENT_PM2CHECKOUT_TESTMODE == 'Test') ? 'Y' : 'N')).vam_draw_hidden_field('x_card_num', $this->cc_card_number).vam_draw_hidden_field('cvv', $_POST['pm_2checkout_cc_cvv']).vam_draw_hidden_field('x_exp_date', $this->cc_expiry_month.substr($this->cc_expiry_year, -2)).vam_draw_hidden_field('x_first_name', $_POST['pm_2checkout_cc_owner_firstname']).vam_draw_hidden_field('x_last_name', $_POST['pm_2checkout_cc_owner_lastname']).vam_draw_hidden_field('x_address', $order->customer['street_address']).vam_draw_hidden_field('x_city', $order->customer['city']).vam_draw_hidden_field('x_state', $order->customer['state']).vam_draw_hidden_field('x_zip', $order->customer['postcode']).vam_draw_hidden_field('x_country', $order->customer['country']['title']).vam_draw_hidden_field('x_email', $order->customer['email_address']).vam_draw_hidden_field('x_phone', $order->customer['telephone']).vam_draw_hidden_field('x_ship_to_first_name', $order->delivery['firstname']).vam_draw_hidden_field('x_ship_to_last_name', $order->delivery['lastname']).vam_draw_hidden_field('x_ship_to_address', $order->delivery['street_address']).vam_draw_hidden_field('x_ship_to_city', $order->delivery['city']).vam_draw_hidden_field('x_ship_to_state', $order->delivery['state']).vam_draw_hidden_field('x_ship_to_zip', $order->delivery['postcode']).vam_draw_hidden_field('x_ship_to_country', $order->delivery['country']['title']).vam_draw_hidden_field('x_receipt_link_url', vam_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')).vam_draw_hidden_field('x_email_merchant', ((MODULE_PAYMENT_PM2CHECKOUT_EMAIL_MERCHANT == 'True') ? 'TRUE' : 'FALSE'));

		return $process_button_string;
	}

	function before_process() {

		if ($_POST['x_response_code'] != '1') {
			vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(MODULE_PAYMENT_PM2CHECKOUT_TEXT_ERROR_MESSAGE), 'SSL', true, false));
		}
	}

	function after_process() {
		global $insert_id;
		if ($this->order_status)
			vam_db_query("UPDATE ".TABLE_ORDERS." SET orders_status='".$this->order_status."' WHERE orders_id='".$insert_id."'");

	}

	function get_error() {

		$error = array ('title' => MODULE_PAYMENT_PM2CHECKOUT_TEXT_ERROR, 'error' => stripslashes(urldecode($_GET['error'])));

		return $error;
	}

	function check() {
		if (!isset ($this->_check)) {
			$check_query = vam_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_PM2CHECKOUT_STATUS'");
			$this->_check = vam_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_ALLOWED', '',  '6', '0', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_LOGIN', '',  '6', '0', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_TESTMODE', 'Test', '6', '0', 'vam_cfg_select_option(array(\'Test\', \'Production\'), ', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_EMAIL_MERCHANT', 'True',  '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_SORT_ORDER', '0',  '6', '0', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_ZONE', '0',  '6', '2', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID', '0',  '6', '0', 'vam_cfg_pull_down_order_statuses(', 'vam_get_order_status_name', now())");
	}

	function remove() {
		vam_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
	}

	function keys() {
		return array ('MODULE_PAYMENT_PM2CHECKOUT_STATUS', 'MODULE_PAYMENT_PM2CHECKOUT_ALLOWED', 'MODULE_PAYMENT_PM2CHECKOUT_LOGIN', 'MODULE_PAYMENT_PM2CHECKOUT_TESTMODE', 'MODULE_PAYMENT_PM2CHECKOUT_EMAIL_MERCHANT', 'MODULE_PAYMENT_PM2CHECKOUT_ZONE', 'MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID', 'MODULE_PAYMENT_PM2CHECKOUT_SORT_ORDER');
	}
}
?>