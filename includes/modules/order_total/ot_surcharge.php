<?php
/*
  $Id: ot_surcharge.php,v 1.0 2003/06/19 01:13:43 hpdl wib $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  class ot_surcharge {
    var $title, $output;

    function ot_surcharge() {
      $this->code = 'ot_surcharge';
      $this->title = MODULE_PAYMENT_TITLE;
      $this->description = MODULE_PAYMENT_DESCRIPTION;
      $this->enabled = MODULE_PAYMENT_STATUS;
      $this->sort_order = MODULE_PAYMENT_SORT_ORDER;
      $this->include_shipping = MODULE_PAYMENT_INC_SHIPPING;
      $this->include_tax = MODULE_PAYMENT_INC_TAX;
      $this->percentage = MODULE_PAYMENT_PERCENTAGE;
      $this->minimum = MODULE_PAYMENT_MINIMUM;
      $this->calculate_tax = MODULE_PAYMENT_CALC_TAX;
//      $this->credit_class = true;
      $this->output = array();
    }

    function process() {
     global $order, $vamPrice;

      $od_amount = $this->calculate_fee($this->get_order_total());
      if ($od_amount>0) {
      $this->addition = $od_amount;
      $this->output[] = array('title' => $this->title . ':',
                              'text' => '<b>' . $vamPrice->format($od_amount,true) . '</b>',
                              'value' => $od_amount);
    $order->info['total'] = $order->info['total'] + $od_amount;  
}
    }
    

  function calculate_fee($amount) {
    global $order;
    $customer_id = $_SESSION['customer_id'];
    $payment = $_SESSION['payment'];
    $od_amount=0;
    $od_pc = $this->percentage; //this is percentage plus the base fee
    $do = false;
    if ($amount > $this->minimum) {
    $table = preg_split("[,]" , MODULE_PAYMENT_TYPE);
    for ($i = 0; $i < count($table); $i++) {
          if ($payment == $table[$i]) $do = true;
        }
    if ($do) {
// Calculate tax reduction if necessary
    if($this->calculate_tax == 'true') {
// Calculate main tax reduction
      $tod_amount = round($order->info['tax']*10)/10*$od_pc/100;
      $order->info['tax'] = $order->info['tax'] + $tod_amount;
// Calculate tax group deductions
      reset($order->info['tax_groups']);
      while (list($key, $value) = each($order->info['tax_groups'])) {
        $god_amount = round($value*10)/10*$od_pc/100;
        $order->info['tax_groups'][$key] = $order->info['tax_groups'][$key] + $god_amount;
      }  
    }
    $od_amount = round($amount*10)/10*$od_pc/100;
    $od_amount = $od_amount + $tod_amount;
    }
    }
    return $od_amount;
  }

   
  function get_order_total() {
    global  $order;
    $cart = $_SESSION['cart'];
    $order_total = $order->info['total'];
// Check if gift voucher is in cart and adjust total
    $products = $cart->get_products();
    for ($i=0; $i<sizeof($products); $i++) {
      $t_prid = vam_get_prid($products[$i]['id']);
      $gv_query = vam_db_query("select products_price, products_tax_class_id, products_model from " . TABLE_PRODUCTS . " where products_id = '" . $t_prid . "'");
      $gv_result = vam_db_fetch_array($gv_query);
      if (preg_match('/^GIFT/', addslashes($gv_result['products_model']))) { 
        $qty = $cart->get_quantity($t_prid);
        $products_tax = vam_get_tax_rate($gv_result['products_tax_class_id']);
        if ($this->include_tax =='false') {
           $gv_amount = $gv_result['products_price'] * $qty;
        } else {
          $gv_amount = ($gv_result['products_price'] + vam_calculate_tax($gv_result['products_price'],$products_tax)) * $qty;
        }
        $order_total=$order_total - $gv_amount;
      }
    }
    if ($this->include_tax == 'false') $order_total=$order_total-$order->info['tax'];
    if ($this->include_shipping == 'false') $order_total=$order_total-$order->info['shipping_cost'];
    return $order_total;
  }  

    
    function check() {
      if (!isset($this->check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_STATUS'");
        $this->check = vam_db_num_rows($check_query);
      }

      return $this->check;
    }

    function keys() {
      return array('MODULE_PAYMENT_STATUS', 'MODULE_PAYMENT_SORT_ORDER','MODULE_PAYMENT_PERCENTAGE','MODULE_PAYMENT_MINIMUM', 'MODULE_PAYMENT_TYPE', 'MODULE_PAYMENT_INC_SHIPPING', 'MODULE_PAYMENT_INC_TAX', 'MODULE_PAYMENT_CALC_TAX');
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_STATUS', 'true', '6', '1','vam_cfg_select_option(array(\'true\', \'false\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SORT_ORDER', '90', '6', '2', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('MODULE_PAYMENT_INC_SHIPPING', 'true', '6', '5', 'vam_cfg_select_option(array(\'true\', \'false\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('MODULE_PAYMENT_INC_TAX', 'true', '6', '6','vam_cfg_select_option(array(\'true\', \'false\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_PERCENTAGE', '3', '6', '7', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('MODULE_PAYMENT_CALC_TAX', 'false', '6', '5','vam_cfg_select_option(array(\'true\', \'false\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_MINIMUM', '', '6', '2', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_TYPE', 'moneyorder', '6', '2', now())");
    }

    function remove() {
      $keys = '';
      $keys_array = $this->keys();
      for ($i=0; $i<sizeof($keys_array); $i++) {
        $keys .= "'" . $keys_array[$i] . "',";
      }
      $keys = substr($keys, 0, -1);

      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in (" . $keys . ")");
    }
  }
?>