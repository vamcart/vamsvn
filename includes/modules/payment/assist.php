<?php
/* -----------------------------------------------------------------------------------------
   $Id: assist.php 998 2007-02-06 21:07:20 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2010 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(authorizenet.php,v 1.48 2003/04/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (authorizenet.php,v 1.9 2003/08/23); www.nextcommerce.org
   (c) 2004	 xt:Commerce (authorizenet.php,v 1.9 2003/08/23); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

 
  class assist {
  
    var $code, $title, $description, $enabled;

    function assist() {
    	
     $this->code = 'assist';     
      $this->title = MODULE_PAYMENT_ASSIST_TEXT_TITLE;      
      $this->description = MODULE_PAYMENT_ASSIST_TEXT_DESCRIPTION;      
      $this->sort_order = MODULE_PAYMENT_ASSIST_SORT_ORDER;
    
      $this->enabled = ((MODULE_PAYMENT_ASSIST_STATUS == 'True') ? true : false);
      $this->form_action_url = MODULE_PAYMENT_ASSIST_URL;
      if ((int)MODULE_PAYMENT_ASSIST_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_ASSIST_ORDER_STATUS_ID;
      }

      if (is_object($order)) $this->update_status();
    }

// class methods
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_ASSIST_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_ASSIST_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
        while ($check = vam_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
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
    function javascript_validation() {      return false;    }
    function selection() {      return array('id' => $this->code,                   'module' => $this->title);    }
    function pre_confirmation_check() {      return false;    }
    function confirmation() {      return false;    }
    function process_button() {      global $order, $vamPrice;
      // получаем следующий номер заказа      // по крайней мере пытаемся
            $my_query = 'SELECT MAX(orders_id) AS orders_id FROM ' . TABLE_ORDERS;
      $max_order_id = vam_db_query($my_query);
      $max_order_id_value = vam_db_fetch_array($max_order_id);
      $order_id_for_assist = $max_order_id_value['orders_id'] + 1;

      $process_button_string = vam_draw_hidden_field('Shop_IDP', MODULE_PAYMENT_ASSIST_SHOP_IDP) .                               vam_draw_hidden_field('Order_IDP', $order_id_for_assist) .
                               vam_draw_hidden_field('Subtotal_P', round($vamPrice->CalculateCurrEx($order->info['total'], $_SESSION['currency']), $vamPrice->get_decimal_places($_SESSION['currency']))) .
                               vam_draw_hidden_field('Language', MODULE_PAYMENT_ASSIST_LANGUAGE) .
                               vam_draw_hidden_field('URL_RETURN_OK', vam_href_link(DIR_WS_CATALOG . FILENAME_CHECKOUT_PROCESS, '', 'SSL')) .
                               vam_draw_hidden_field('URL_RETURN_NO', vam_href_link(DIR_WS_CATALOG . FILENAME_CHECKOUT_PAYMENT, 'error_message=' . MODULE_PAYMENT_ASSIST_TEXT_ERROR_MESSAGE, 'SSL')) .
                               vam_draw_hidden_field('Currency', $_SESSION['currency']) .
                               vam_draw_hidden_field('Comment', MODULE_PAYMENT_ASSIST_COMMENT . '#' . $order_id_for_assist);
                                     if (MODULE_PAYMENT_ASSIST_SHOP_MODE == 'Test') $process_button_string .= vam_draw_hidden_field('DemoResult', 'AS000');
      
      return $process_button_string;    }
    function before_process() {      global $_GET;
      if ($_GET['assist_error'] == 1) {        vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . MODULE_PAYMENT_ASSIST_TEXT_ERROR_MESSAGE, 'SSL', true, false));      }
    }
    function after_process() {      return false;    }
    function output_error() {      return false;    }
    function check() {      if (!isset($this->_check)) {        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ASSIST_STATUS'");        $this->_check = vam_db_num_rows($check_query);      }      return $this->_check;    }
    function install() {      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_ASSIST_STATUS', 'True', '6', '1', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ASSIST_ALLOWED', '', '6', '2', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ASSIST_SHOP_IDP', '', '6', '3', now())");      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_ASSIST_SHOP_MODE', 'Test', '6', '4', 'vam_cfg_select_option(array(\'Test\', \'Production\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_ASSIST_ZONE', '0', '6', '5', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ASSIST_SORT_ORDER', '0', '6', '6', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_ASSIST_ORDER_STATUS_ID', '0', '6', '7', 'vam_cfg_pull_down_order_statuses(', 'vam_get_order_status_name', now())");
    }
    function remove() {      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");    }
    function keys() {      return array('MODULE_PAYMENT_ASSIST_STATUS','MODULE_PAYMENT_ASSIST_ALLOWED','MODULE_PAYMENT_ASSIST_SHOP_IDP','MODULE_PAYMENT_ASSIST_SHOP_MODE','MODULE_PAYMENT_ASSIST_ZONE','MODULE_PAYMENT_ASSIST_SORT_ORDER','MODULE_PAYMENT_ASSIST_ORDER_STATUS_ID');    }  }
?>