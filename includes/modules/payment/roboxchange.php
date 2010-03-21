<?php
/* -----------------------------------------------------------------------------------------
   $Id: secpay.php 998 2007-02-06 21:07:20 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2005 Vetal http://metashop.ru

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  class roboxchange {
    var $code, $title, $description, $enabled;

// class constructor
    function roboxchange() {
      global $order;

      $this->code = 'roboxchange';
      $this->title = MODULE_PAYMENT_ROBOXCHANGE_TEXT_TITLE;
      $this->description = MODULE_PAYMENT_ROBOXCHANGE_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_PAYMENT_ROBOXCHANGE_SORT_ORDER;
      $this->enabled = ((MODULE_PAYMENT_ROBOXCHANGE_STATUS == 'True') ? true : false);

//      $this->form_action_url = 'https://www.roboxchange.com/ssl/calc.asp';
    }

// class methods
    function update_status() {
      return false;
    }

    function javascript_validation() {
      return false;
    }

    function selection() {
      return array('id' => $this->code,
                   'module' => $this->title);
    }

    function pre_confirmation_check() {
      return false;
    }

    function confirmation() {
      return false;
    }

    function process_button() {
/*
      global $order, $currencies, $language;

      $inv_id='0';
      $inv_desc='';
      $out_summ=$order->info['total'];

      $crc = md5(MODULE_PAYMENT_ROBOXCHANGE_LOGIN.':'.$out_summ.':'.$inv_id.':'.MODULE_PAYMENT_ROBOXCHANGE_PASSWORD1);

      $process_button_string = vam_draw_hidden_field('mrh', MODULE_PAYMENT_ROBOXCHANGE_LOGIN) .
                               vam_draw_hidden_field('out_summ', $out_summ) .
                               vam_draw_hidden_field('inv_id', $inv_id) .
                               vam_draw_hidden_field('inv_desc', $inv_desc) .
                               vam_draw_hidden_field('p', 'vecher') .
                               vam_draw_hidden_field('lang', (($language=='russian')?'ru':'en')) .
                               vam_draw_hidden_field('crc', $crc);

      return $process_button_string;
*/
      return false;
    }

    function before_process() {
      return false;
    }

    function after_process() {
      global $insert_id, $vamPrice, $order, $language, $cart;
      $inv_id=$insert_id;
//      $out_summ=$order->info['total_value'];
      $out_summ=number_format($order->info['total'],0,'.',''); 
      $crc = md5(MODULE_PAYMENT_ROBOXCHANGE_LOGIN.':'.$out_summ.':'.$inv_id.':'.MODULE_PAYMENT_ROBOXCHANGE_PASSWORD1);

      $_SESSION['cart']->reset(true);
//      vam_session_unregister('sendto');
//      vam_session_unregister('billto');
      vam_session_unregister('shipping');
      vam_session_unregister('payment');
      vam_session_unregister('comments');
      vam_redirect('https://www.roboxchange.com/ssl/calc.asp?mrh='.MODULE_PAYMENT_ROBOXCHANGE_LOGIN.'&out_summ='.$out_summ.'&inv_id='.$inv_id.'&lang='.(($_SESSION['language']=='russian')?'ru':'en').'&crc='.$crc.'&p=vecher');
    }

    function output_error() {
      return false;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ROBOXCHANGE_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_ROBOXCHANGE_STATUS', 'False', '6', '3', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ROBOXCHANGE_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ROBOXCHANGE_LOGIN', '', '6', '4', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ROBOXCHANGE_PASSWORD1', '', '6', '5', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ROBOXCHANGE_SORT_ORDER', '0', '6', '7', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ROBOXCHANGE_PASSWORD2', '', '6', '5', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_ROBOXCHANGE_ORDER_STATUS', '0', '6', '8', 'vam_cfg_pull_down_order_statuses(', 'vam_get_order_status_name', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_ROBOXCHANGE_STATUS', 'MODULE_PAYMENT_ROBOXCHANGE_ALLOWED', 'MODULE_PAYMENT_ROBOXCHANGE_LOGIN', 'MODULE_PAYMENT_ROBOXCHANGE_PASSWORD1', 'MODULE_PAYMENT_ROBOXCHANGE_ORDER_STATUS', 'MODULE_PAYMENT_ROBOXCHANGE_PASSWORD2', 'MODULE_PAYMENT_ROBOXCHANGE_SORT_ORDER');
    }
  }
?>
