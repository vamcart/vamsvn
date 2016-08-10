<?php
/*
  $Id: pm2checkout.php 1813 2008-01-13 12:53:40Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2008 osCommerce

  Released under the GNU General Public License
*/

  class pm2checkout {
    var $code, $title, $description, $enabled;

// class constructor
    function __construct() {
      global $order;

      $this->signature = '2checkout|pm2checkout|1.1|2.2';

      $this->code = 'pm2checkout';
      $this->title = MODULE_PAYMENT_PM2CHECKOUT_TEXT_TITLE;
      $this->public_title = MODULE_PAYMENT_PM2CHECKOUT_TEXT_PUBLIC_TITLE;
      $this->description = MODULE_PAYMENT_PM2CHECKOUT_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_PM2CHECKOUT_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_PM2CHECKOUT_STATUS == 'True') ? true : false);

      if ((int)MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();

      $this->form_action_url = 'https://www.2checkout.com/2co/buyer/purchase';
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_PM2CHECKOUT_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_PM2CHECKOUT_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");
        while ($check = vam_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->billing['zone_id']) {
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
      return array('id' => $this->code,
                   'module' => $this->public_title . (strlen(MODULE_PAYMENT_PM2CHECKOUT_TEXT_PUBLIC_DESCRIPTION) > 0 ? ' (' . MODULE_PAYMENT_PM2CHECKOUT_TEXT_PUBLIC_DESCRIPTION . ')' : ''));
    }

    function pre_confirmation_check() {
      return false;
    }

    function confirmation() {
      return false;
    }

    function process_button() {
      global $currencies, $currency, $order;

      $process_button_string = vam_draw_hidden_field('sid', MODULE_PAYMENT_PM2CHECKOUT_LOGIN) .
                               vam_draw_hidden_field('total', number_format($order->info['total'], 2)) .
                               vam_draw_hidden_field('cart_order_id', date('YmdHis')) .
                               vam_draw_hidden_field('fixed', 'Y') .
                               vam_draw_hidden_field('card_holder_name', $order->billing['firstname'] . ' ' . $order->billing['lastname']) .
                               vam_draw_hidden_field('street_address', $order->billing['street_address']) .
                               vam_draw_hidden_field('city', $order->billing['city']) .
                               vam_draw_hidden_field('state', $order->billing['state']) .
                               vam_draw_hidden_field('zip', $order->billing['postcode']) .
                               vam_draw_hidden_field('country', $order->billing['country']['title']) .
                               vam_draw_hidden_field('email', $order->customer['email_address']) .
                               vam_draw_hidden_field('phone', $order->customer['telephone']) .
                               vam_draw_hidden_field('ship_street_address', $order->delivery['street_address']) .
                               vam_draw_hidden_field('ship_city', $order->delivery['city']) .
                               vam_draw_hidden_field('ship_state', $order->delivery['state']) .
                               vam_draw_hidden_field('ship_zip', $order->delivery['postcode']) .
                               vam_draw_hidden_field('ship_country', $order->delivery['country']['title']);

      for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
        $process_button_string .= vam_draw_hidden_field('c_prod_' . ($i+1), (int)$order->products[$i]['id'] . ',' . (int)$order->products[$i]['qty']) .
                                  vam_draw_hidden_field('c_name_' . ($i+1), $order->products[$i]['name']) .
                                  vam_draw_hidden_field('c_description_' . ($i+1), $order->products[$i]['name']) .
                                  vam_draw_hidden_field('c_price_' . ($i+1), number_format(vam_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']), $currencies->currencies[$currency]['decimal_places']));
      }

      $process_button_string .= vam_draw_hidden_field('id_type', '1');

      if (MODULE_PAYMENT_PM2CHECKOUT_TESTMODE == 'Test') {
        $process_button_string .= vam_draw_hidden_field('demo', 'Y');
      }

      $process_button_string .= vam_draw_hidden_field('return_url', vam_href_link(FILENAME_SHOPPING_CART));

      $lang_query = vam_db_query("select code from " . TABLE_LANGUAGES . " where languages_id = '" . (int)$_SESSION['languages_id'] . "'");
      $lang = vam_db_fetch_array($lang_query);

      switch (strtolower($lang['code'])) {
        case 'es':
          $process_button_string .= vam_draw_hidden_field('lang', 'sp');
          break;
      }

      $process_button_string .= vam_draw_hidden_field('cart_brand_name', 'oscommerce') .
                                vam_draw_hidden_field('cart_version_name', PROJECT_VERSION);

      return $process_button_string;
    }

    function before_process() {

      if ($_POST['credit_card_processed'] != 'Y') {
        vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(MODULE_PAYMENT_PM2CHECKOUT_TEXT_ERROR_MESSAGE), 'SSL', true, false));
      }
    }

    function after_process() {
      global $order, $insert_id;

      if (MODULE_PAYMENT_PM2CHECKOUT_TESTMODE == 'Test') {
        $sql_data_array = array('orders_id' => (int)$insert_id, 
                                'orders_status_id' => (int)$order->info['order_status'], 
                                'date_added' => 'now()', 
                                'customer_notified' => '0',
                                'comments' => MODULE_PAYMENT_PM2CHECKOUT_TEXT_WARNING_DEMO_MODE);

        vam_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
      }

      if (vam_not_null(MODULE_PAYMENT_PM2CHECKOUT_SECRET_WORD) && (MODULE_PAYMENT_PM2CHECKOUT_TESTMODE == 'Production')) {
        if (md5(MODULE_PAYMENT_PM2CHECKOUT_SECRET_WORD . MODULE_PAYMENT_PM2CHECKOUT_LOGIN . $_POST['order_number'] . number_format($order->info['total'], 2)) != $_POST['key']) {
          $sql_data_array = array('orders_id' => (int)$insert_id, 
                                  'orders_status_id' => (int)$order->info['order_status'], 
                                  'date_added' => 'now()', 
                                  'customer_notified' => '0',
                                  'comments' => MODULE_PAYMENT_PM2CHECKOUT_TEXT_WARNING_TRANSACTION_ORDER);

          vam_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
        }
      }
    }

    function get_error() {
      return false;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_PM2CHECKOUT_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_LOGIN', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_TESTMODE', 'Test', '6', '0', 'vam_cfg_select_option(array(\'Test\', \'Production\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_SECRET_WORD', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_SORT_ORDER', '0', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_ZONE', '0', '6', '2', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID', '0', '6', '0', 'vam_cfg_pull_down_order_statuses(', 'vam_get_order_status_name', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_PM2CHECKOUT_STATUS', 'MODULE_PAYMENT_PM2CHECKOUT_ALLOWED', 'MODULE_PAYMENT_PM2CHECKOUT_LOGIN', 'MODULE_PAYMENT_PM2CHECKOUT_TESTMODE', 'MODULE_PAYMENT_PM2CHECKOUT_SECRET_WORD', 'MODULE_PAYMENT_PM2CHECKOUT_ZONE', 'MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID', 'MODULE_PAYMENT_PM2CHECKOUT_SORT_ORDER');
    }
  }
?>
