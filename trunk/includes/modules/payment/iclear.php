<?php

/* -----------------------------------------------------------------------------------------
   $Id: iclear.php 998 2005-07-07 14:18:20Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(iclear.php,v 1.02); www.oscommerce.com

   Released under the GNU General Public License

   Third Party contribution:

************************************************************************
  Copyright (C) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers
       http://www.themedia.at & http://www.oscommerce.at

                    All rights reserved.

  This program is free software licensed under the GNU General Public License (GPL).

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307
  USA

**************************************************************************/

class iclear {
	var $code, $title, $description, $enabled;

	// class constructor
	function iclear() {
		$this->code = 'iclear';
		$this->title = MODULE_PAYMENT_ICLEAR_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_ICLEAR_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_ICLEAR_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_ICLEAR_STATUS == 'True') ? true : false);
		$this->info = MODULE_PAYMENT_ICLEAR_TEXT_INFO;
		if ((int) MODULE_PAYMENT_ICLEAR_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_ICLEAR_ORDER_STATUS_ID;
		}

		if (is_object($order))
			$this->update_status();

		$this->form_action_url = 'https://www.iclear.de/servlets/GenBuyTool';
	}

	// class methods
	function update_status() {
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_ICLEAR_ZONE > 0)) {
			$check_flag = false;
			$check_query = xtc_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_ICLEAR_ZONE."' and zone_country_id = '".$order->billing['country']['id']."' order by zone_id");
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
		global $order, $xtPrice, $currency, $shipping, $customer_id, $billto;

		$process_button_string = xtc_draw_hidden_field('ShopID', MODULE_PAYMENT_ICLEAR_ID).xtc_draw_hidden_field('BasketID', xtc_create_random_value(5, 'digits')).xtc_draw_hidden_field('Currency', $currency);

		$process_products_string = '';

		for ($i = 0; $i < sizeof($order->products); $i ++) {
			$process_products_string .= $order->products[$i]['name'].'::'.$order->products[$i]['model'].'::'.$order->products[$i]['qty'].'::'.$order->products[$i]['price'].'::'.round($order->products[$i]['price'], 2).'::'.round($order->products[$i]['tax'], 0).':::';
		}

		if (($order->info['shipping_method']) && ($_SESSION['shipping']['cost'] != '0')) {
			$process_products_string .= 'Versandkosten::Versand::1::'.round($_SESSION['shipping']['cost'], 2).'::'.round($order->info['shipping_cost'], 2).'::'.round(($order->info['shipping_cost'] / $_SESSION['shipping']['cost'] - 1) * 100, 0).':::';
		}

		$process_button_string .= xtc_draw_hidden_field('ProductIndex', $i).xtc_draw_hidden_field('Products', $process_products_string).xtc_draw_hidden_field('User_Def', '&'.xtc_session_name().'='.xtc_session_id());

		return $process_button_string;
	}

	function before_process() {
		global $_GET, $_SESSION, $order, $xtPrice, $cart, $customer_id;

		if ($_GET['StatusExist'] == 'failed') {
			xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(MODULE_PAYMENT_ICLEAR_TEXT_ERROR_MESSAGE), 'SSL', true, false));
		}

		if ($_GET['StatusExist'] == 'accepted') {

			// include needed functions
			require_once (DIR_FS_INC.'xtc_calculate_tax.inc.php');
			require_once (DIR_FS_INC.'xtc_address_label.inc.php');
			require_once (DIR_WS_CLASSES.'class.phpmailer.php');
			require_once (DIR_FS_INC.'xtc_php_mail.inc.php');
			require_once (DIR_FS_INC.'changedatain.inc.php');

			// initialize smarty
			$smarty = new Smarty;

			require (DIR_WS_CLASSES.'order_total.php');
			$order_total_modules = new order_total;

			$order_totals = $order_total_modules->process();

			$basket_id = $_GET['BasketID'];
			$customer_id_iclear = $_GET['Kundennummer'];
			$billing_string = explode("::", $_GET['Kundenadresse']);
			$delivery_string = explode("::", $_GET['Lieferadresse']);

			$billing_firstname = $billing_string[0];
			$billing_lastname = $billing_string[1];
			$billing_company = $billing_string[2];
			$billing_company1 = $billing_string[3];
			$billing_street = $billing_string[4];
			$billing_postcode = $billing_string[5];
			$billing_city = $billing_string[6];
			$billing_country = $billing_string[7];

			$delivery_firstname = $delivery_string[0];
			$delivery_lastname = $delivery_string[1];
			$delivery_company = $delivery_string[2];
			$delivery_company1 = $delivery_string[3];
			$delivery_street = $delivery_string[4];
			$delivery_postcode = $delivery_string[5];
			$delivery_city = $delivery_string[6];
			$delivery_country = $delivery_string[7];
			$delivery_telephone = $delivery_string[8];
			$delivery_email_address = $delivery_string[9];

			// New Value

			// BMC CC Mod Start
			if (strtolower(CC_ENC) == 'true') {
				$key = changeme;
				$plain_data = $order->info['cc_number'];
				$order->info['cc_number'] = changedatain($plain_data, $key);
			}
			// BMC CC Mod End

			if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
				$discount = $_SESSION['customers_status']['customers_status_ot_discount'];
			} else {
				$discount = '0.00';
			}
			if ($_SESSION['credit_covers'] != '1') {
				$sql_data_array = array ('customers_id' => $_SESSION['customer_id'], 'customers_name' => $order->customer['firstname'].' '.$order->customer['lastname'], 'customers_cid' => $order->customer['csID'], 'customers_company' => $order->customer['company'], 'customers_status' => $order['status'], 'customers_status_name' => $_SESSION['customers_status']['customers_status_name'], 'customers_status_image' => $order['status_image'], 'customers_status_discount' => $discount, 'customers_status' => $customer_status_value['customers_status'], 'customers_street_address' => $order->customer['street_address'], 'customers_suburb' => $order->customer['suburb'], 'customers_city' => $order->customer['city'], 'customers_postcode' => $order->customer['postcode'], 'customers_state' => $order->customer['state'], 'customers_country' => $order->customer['country']['title'], 'customers_telephone' => $order->customer['telephone'], 'customers_email_address' => $order->customer['email_address'], 'customers_address_format_id' => $order->customer['format_id'], 'delivery_name' => $delivery_firstname.' '.$delivery_lastname, 'delivery_company' => $delivery_company, 'delivery_street_address' => $delivery_street, 'delivery_suburb' => '', 'delivery_city' => $delivery_city, 'delivery_postcode' => $delivery_postcode, 'delivery_state' => '', 'delivery_country' => $delivery_country, 'delivery_address_format_id' => $order->customer['format_id'], 'billing_name' => $billing_firstname.' '.$billing_lastname, 'billing_company' => $billing_company, 'billing_street_address' => $billing_street, 'billing_suburb' => '', 'billing_city' => $billing_city, 'billing_postcode' => $billing_postcode, 'billing_state' => '', 'billing_country' => $billing_country, 'billing_address_format_id' => $order->customer['format_id'], 'payment_method' => $order->info['payment_method'], 'payment_class' => $order->info['payment_class'], 'shipping_method' => $order->info['shipping_method'], 'shipping_class' => $order->info['shipping_class'], 'cc_type' => $order->info['cc_type'], 'cc_owner' => $order->info['cc_owner'], 'cc_number' => $order->info['cc_number'], 'cc_expires' => $order->info['cc_expires'],
					// BMC CC Mod Start
	'cc_start' => $order->info['cc_start'], 'cc_cvv' => $order->info['cc_cvv'], 'cc_issue' => $order->info['cc_issue'],
					// BMC CC Mod End
	'date_purchased' => 'now()', 'orders_status' => $order->info['order_status'], 'currency' => $order->info['currency'], 'currency_value' => $order->info['currency_value'], 'customers_ip' => $_SERVER['REMOTE_ADDR'], 'language' => $_SESSION['language'], 'comments' => $order->info['comments']);
			} else {
				// free gift , no paymentaddress
				$sql_data_array = array ('customers_id' => $_SESSION['customer_id'], 'customers_name' => $order->customer['firstname'].' '.$order->customer['lastname'], 'customers_cid' => $order->customer['csID'], 'customers_company' => $order->customer['company'], 'customers_status' => $order['status'], 'customers_status_name' => $_SESSION['customers_status']['customers_status_name'], 'customers_status_image' => $order['status_image'], 'customers_status_discount' => $discount, 'customers_status' => $customer_status_value['customers_status'], 'customers_street_address' => $order->customer['street_address'], 'customers_suburb' => $order->customer['suburb'], 'customers_city' => $order->customer['city'], 'customers_postcode' => $order->customer['postcode'], 'customers_state' => $order->customer['state'], 'customers_country' => $order->customer['country']['title'], 'customers_telephone' => $order->customer['telephone'], 'customers_email_address' => $order->customer['email_address'], 'customers_address_format_id' => $order->customer['format_id'], 'delivery_name' => $delivery_firstname.' '.$delivery_lastname, 'delivery_company' => $delivery_company, 'delivery_street_address' => $delivery_street, 'delivery_suburb' => '', 'delivery_city' => $delivery_city, 'delivery_postcode' => $delivery_postcode, 'delivery_state' => '', 'delivery_country' => $delivery_country, 'delivery_address_format_id' => $order->customer['format_id'], 'payment_method' => $order->info['payment_method'], 'payment_class' => $order->info['payment_class'], 'shipping_method' => $order->info['shipping_method'], 'shipping_class' => $order->info['shipping_class'], 'cc_type' => $order->info['cc_type'], 'cc_owner' => $order->info['cc_owner'], 'cc_number' => $order->info['cc_number'], 'cc_expires' => $order->info['cc_expires'], 'date_purchased' => 'now()', 'orders_status' => $order->info['order_status'], 'currency' => $order->info['currency'], 'currency_value' => $order->info['currency_value'], 'customers_ip' => $_SERVER['REMOTE_ADDR'], 'comments' => $order->info['comments']);
			}

			xtc_db_perform(TABLE_ORDERS, $sql_data_array);
			$insert_id = xtc_db_insert_id();
			for ($i = 0, $n = sizeof($order_totals); $i < $n; $i ++) {
				$sql_data_array = array ('orders_id' => $insert_id, 'title' => $order_totals[$i]['title'], 'text' => $order_totals[$i]['text'], 'value' => $order_totals[$i]['value'], 'class' => $order_totals[$i]['code'], 'sort_order' => $order_totals[$i]['sort_order']);
				xtc_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
			}

			$customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';
			$sql_data_array = array ('orders_id' => $insert_id, 'orders_status_id' => $order->info['order_status'], 'date_added' => 'now()', 'customer_notified' => $customer_notification, 'comments' => $order->info['comments']);
			xtc_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

			// initialized for the email confirmation
			$products_ordered = '';
			$products_ordered_html = '';
			$subtotal = 0;
			$total_tax = 0;

			for ($i = 0, $n = sizeof($order->products); $i < $n; $i ++) {
				// Stock Update - Joao Correia
				if (STOCK_LIMITED == 'true') {
					if (DOWNLOAD_ENABLED == 'true') {
						$stock_query_raw = "SELECT products_quantity, pad.products_attributes_filename
						                            FROM ".TABLE_PRODUCTS." p
						                            LEFT JOIN ".TABLE_PRODUCTS_ATTRIBUTES." pa
						                             ON p.products_id=pa.products_id
						                            LEFT JOIN ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." pad
						                             ON pa.products_attributes_id=pad.products_attributes_id
						                            WHERE p.products_id = '".xtc_get_prid($order->products[$i]['id'])."'";
						// Will work with only one option for downloadable products
						// otherwise, we have to build the query dynamically with a loop
						$products_attributes = $order->products[$i]['attributes'];
						if (is_array($products_attributes)) {
							$stock_query_raw .= " AND pa.options_id = '".$products_attributes[0]['option_id']."' AND pa.options_values_id = '".$products_attributes[0]['value_id']."'";
						}
						$stock_query = xtc_db_query($stock_query_raw);
					} else {
						$stock_query = xtc_db_query("select products_quantity from ".TABLE_PRODUCTS." where products_id = '".xtc_get_prid($order->products[$i]['id'])."'");
					}
					if (xtc_db_num_rows($stock_query) > 0) {
						$stock_values = xtc_db_fetch_array($stock_query);
						// do not decrement quantities if products_attributes_filename exists
						if ((DOWNLOAD_ENABLED != 'true') || (!$stock_values['products_attributes_filename'])) {
							$stock_left = $stock_values['products_quantity'] - $order->products[$i]['qty'];
						} else {
							$stock_left = $stock_values['products_quantity'];
						}

						xtc_db_query("update ".TABLE_PRODUCTS." set products_quantity = '".$stock_left."' where products_id = '".xtc_get_prid($order->products[$i]['id'])."'");
						if (($stock_left < 1) && (STOCK_ALLOW_CHECKOUT == 'false')) {
							xtc_db_query("update ".TABLE_PRODUCTS." set products_status = '0' where products_id = '".xtc_get_prid($order->products[$i]['id'])."'");
						}
					}
				}

				// Update products_ordered (for bestsellers list)
				xtc_db_query("update ".TABLE_PRODUCTS." set products_ordered = products_ordered + ".sprintf('%d', $order->products[$i]['qty'])." where products_id = '".xtc_get_prid($order->products[$i]['id'])."'");

				$sql_data_array = array ('orders_id' => $insert_id, 'products_id' => xtc_get_prid($order->products[$i]['id']), 'products_model' => $order->products[$i]['model'], 'products_name' => $order->products[$i]['name'], 'products_price' => $order->products[$i]['price'], 'final_price' => $order->products[$i]['final_price'], 'products_tax' => $order->products[$i]['tax'], 'products_discount_made' => $order-> $products[$i]['discount_allowed'], 'products_quantity' => $order->products[$i]['qty'], 'allow_tax' => $_SESSION['customers_status']['customers_status_show_price_tax']);

				xtc_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);
				$order_products_id = xtc_db_insert_id();

				$order_total_modules->update_credit_account($i); // GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
				//------insert customer choosen option to order--------
				$attributes_exist = '0';
				$products_ordered_attributes = '';
				if (isset ($order->products[$i]['attributes'])) {
					$attributes_exist = '1';
					for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j ++) {
						if (DOWNLOAD_ENABLED == 'true') {
							$attributes_query = "select popt.products_options_name,
							                               poval.products_options_values_name,
							                               pa.options_values_price,
							                               pa.price_prefix,
							                               pad.products_attributes_maxdays,
							                               pad.products_attributes_maxcount,
							                               pad.products_attributes_filename
							                               from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_OPTIONS_VALUES." poval, ".TABLE_PRODUCTS_ATTRIBUTES." pa
							                               left join ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." pad
							                                on pa.products_attributes_id=pad.products_attributes_id
							                               where pa.products_id = '".$order->products[$i]['id']."'
							                                and pa.options_id = '".$order->products[$i]['attributes'][$j]['option_id']."'
							                                and pa.options_id = popt.products_options_id
							                                and pa.options_values_id = '".$order->products[$i]['attributes'][$j]['value_id']."'
							                                and pa.options_values_id = poval.products_options_values_id
							                                and popt.language_id = '".$_SESSION['languages_id']."'
							                                and poval.language_id = '".$_SESSION['languages_id']."'";
							$attributes = xtc_db_query($attributes_query);
						} else {
							$attributes = xtc_db_query("select popt.products_options_name,
							                                             poval.products_options_values_name,
							                                             pa.options_values_price,
							                                             pa.price_prefix
							                                             from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_OPTIONS_VALUES." poval, ".TABLE_PRODUCTS_ATTRIBUTES." pa
							                                             where pa.products_id = '".$order->products[$i]['id']."'
							                                             and pa.options_id = '".$order->products[$i]['attributes'][$j]['option_id']."'
							                                             and pa.options_id = popt.products_options_id
							                                             and pa.options_values_id = '".$order->products[$i]['attributes'][$j]['value_id']."'
							                                             and pa.options_values_id = poval.products_options_values_id
							                                             and popt.language_id = '".$_SESSION['languages_id']."'
							                                             and poval.language_id = '".$_SESSION['languages_id']."'");
						}
						// update attribute stock
						xtc_db_query("UPDATE ".TABLE_PRODUCTS_ATTRIBUTES." set
						                               attributes_stock=attributes_stock - '".$order->products[$i]['qty']."'
						                               where
						                               products_id='".$order->products[$i]['id']."'
						                               and options_values_id='".$order->products[$i]['attributes'][$j]['value_id']."'
						                               and options_id='".$order->products[$i]['attributes'][$j]['option_id']."'
						                               ");

						$attributes_values = xtc_db_fetch_array($attributes);

						$sql_data_array = array ('orders_id' => $insert_id, 'orders_products_id' => $order_products_id, 'products_options' => $attributes_values['products_options_name'], 'products_options_values' => $attributes_values['products_options_values_name'], 'options_values_price' => $attributes_values['options_values_price'], 'price_prefix' => $attributes_values['price_prefix']);
						xtc_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);

						if ((DOWNLOAD_ENABLED == 'true') && isset ($attributes_values['products_attributes_filename']) && xtc_not_null($attributes_values['products_attributes_filename'])) {
							$sql_data_array = array ('orders_id' => $insert_id, 'orders_products_id' => $order_products_id, 'orders_products_filename' => $attributes_values['products_attributes_filename'], 'download_maxdays' => $attributes_values['products_attributes_maxdays'], 'download_count' => $attributes_values['products_attributes_maxcount']);
							xtc_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
						}
					}
				}
				//------insert customer choosen option eof ----
				$total_weight += ($order->products[$i]['qty'] * $order->products[$i]['weight']);
				$total_tax += xtc_calculate_tax($total_products_price, $products_tax) * $order->products[$i]['qty'];
				$total_cost += $total_products_price;

			}

			// NEW EMAIL configuration !
			$order_totals = $order_total_modules->apply_credit();
			include ('send_order.php');

			// load the after_process function from the payment modules
			//$payment_modules->after_process();

			$_SESSION['cart']->reset(true);

			// unregister session variables used during checkout
			unset ($_SESSION['sendto']);
			unset ($_SESSION['billto']);
			unset ($_SESSION['shipping']);
			unset ($_SESSION['payment']);
			unset ($_SESSION['comments']);
			unset ($_SESSION['last_order']);
			$last_order = $insert_id;
			//GV Code Start
			if (isset ($_SESSION['credit_covers']))
				unset ($_SESSION['credit_covers']);
			$order_total_modules->clear_posts(); //ICW ADDED FOR CREDIT CLASS SYSTEM
			// GV Code End

			if (!isset ($mail_error)) {
				xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL'));
			} else {
				echo $mail_error;
			}

		}
	}

	function after_process() {
		global $insert_id;
		if ($this->order_status)
			xtc_db_query("UPDATE ".TABLE_ORDERS." SET orders_status='".$this->order_status."' WHERE orders_id='".$insert_id."'");

	}

	function output_error() {
		return false;
	}

	function check() {
		if (!isset ($this->_check)) {
			$check_query = xtc_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_ICLEAR_STATUS'");
			$this->_check = xtc_db_num_rows($check_query);
		}
		return $this->_check;
	}

	function install() {
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_ICLEAR_STATUS', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ICLEAR_ALLOWED', '', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ICLEAR_ID', 'yourbuisness', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ICLEAR_SORT_ORDER', '0', '6', '0', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_ICLEAR_ZONE', '0', '6', '0', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
		xtc_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_ICLEAR_ORDER_STATUS_ID', '0', '6', '0', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
	}

	function remove() {
		xtc_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
	}

	function keys() {
		return array ('MODULE_PAYMENT_ICLEAR_STATUS', 'MODULE_PAYMENT_ICLEAR_ID', 'MODULE_PAYMENT_ICLEAR_ZONE', 'MODULE_PAYMENT_ICLEAR_ORDER_STATUS_ID', 'MODULE_PAYMENT_ICLEAR_SORT_ORDER');
	}
}
?>