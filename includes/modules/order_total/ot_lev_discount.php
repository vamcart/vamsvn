<?php
/*
<<<<<<< ot_lev_discount.php
  $Id: ot_lev_discount.php,v 1.0 2002/04/08 01:13:43 hpdl Exp $
=======
  $Id: ot_lev_discount.php,v 1.3 2002/09/04 22:49:11 wilt Exp $
  $Id: ot_lev_discount.php,v 2.4 2006/02/28 12:10:01 maniac101 Exp $
modified to calc discount correctly when tax is included in discount
>>>>>>> 2.4

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

  class ot_lev_discount {
    var $title, $output;

    function ot_lev_discount() {
      $this->code = 'ot_lev_discount';
      $this->title = MODULE_ORDER_TOTAL_LEV_DISCOUNT_TITLE;
      $this->description = MODULE_ORDER_TOTAL_LEV_DISCOUNT_DESCRIPTION;
      $this->enabled = ((MODULE_ORDER_TOTAL_LEV_DISCOUNT_STATUS == 'true') ? true : false);
      $this->sort_order = MODULE_ORDER_TOTAL_LEV_DISCOUNT_SORT_ORDER;
      $this->include_shipping = MODULE_ORDER_TOTAL_LEV_DISCOUNT_INC_SHIPPING;
      $this->include_tax = MODULE_ORDER_TOTAL_LEV_DISCOUNT_INC_TAX;
      $this->calculate_tax = MODULE_ORDER_TOTAL_LEV_DISCOUNT_CALC_TAX;
      $this->table = MODULE_ORDER_TOTAL_LEV_DISCOUNT_TABLE;
//      $this->credit_class = true;
      $this->output = array();
    }

    function process() {
      global $order, $ot_subtotal, $vamPrice;
      $od_amount = $this->calculate_credit($this->get_order_total());
      if ($od_amount>0) {
      $this->deduction = $od_amount;
      $this->output[] = array('title' => $this->title . ':',
                              'text' => '<b>' . $vamPrice->Format($od_amount,true) . '</b>',
                              'value' => $od_amount);
    $order->info['total'] = $order->info['total'] - $od_amount;
    if ($this->sort_order < $ot_subtotal->sort_order) {
      $order->info['subtotal'] = $order->info['subtotal'] - $od_amount;
    }
}
    }
     
   
  function calculate_credit($amount) {
    global $order;
    $od_amount=0;
    $table_cost = preg_split("/[:,]/" , MODULE_ORDER_TOTAL_LEV_DISCOUNT_TABLE);
    for ($i = 0; $i < count($table_cost); $i+=2) {
          if ($amount >= $table_cost[$i]) {
            $od_pc = $table_cost[$i+1];
          }
        }
// Calculate tax reduction if necessary
    if($this->calculate_tax == 'true') {
// Calculate main tax reduction
      $tod_amount = round($order->info['tax']*10)/10*$od_pc/100;
      $order->info['tax'] = $order->info['tax'] - $tod_amount;
// Calculate tax group deductions
      reset($order->info['tax_groups']);
      while (list($key, $value) = each($order->info['tax_groups'])) {
        $god_amount = round($value*10)/10*$od_pc/100;
        $order->info['tax_groups'][$key] = $order->info['tax_groups'][$key] - $god_amount;
      }  
    }
    $od_amount = round($amount*10)/10*$od_pc/100;
//    $od_amount = $od_amount + $tod_amount;
// maniac101 above line was adding tax back into discount incorrectly for me
    return $od_amount;
  }


  function get_order_total() {
    global  $order, $cart;
    $order_total = $order->info['total'];
// Check if gift voucher is in cart and adjust total
    $products = $_SESSION['cart']->get_products();
    for ($i=0; $i<sizeof($products); $i++) {
      $t_prid = vam_get_prid($products[$i]['id']);
      $gv_query = vam_db_query("select products_price, products_tax_class_id, products_model from " . TABLE_PRODUCTS . " where products_id = '" . $t_prid . "'");
      $gv_result = vam_db_fetch_array($gv_query);
      if (preg_match('/^GIFT/', addslashes($gv_result['products_model']))) { 
        $qty = $_SESSION['cart']->get_quantity($t_prid);
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
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_LEV_DISCOUNT_STATUS'");
        $this->check = vam_db_num_rows($check_query);
      }

      return $this->check;
    }

    function keys() {
      return array('MODULE_ORDER_TOTAL_LEV_DISCOUNT_STATUS', 'MODULE_ORDER_TOTAL_LEV_DISCOUNT_SORT_ORDER','MODULE_ORDER_TOTAL_LEV_DISCOUNT_TABLE', 'MODULE_ORDER_TOTAL_LEV_DISCOUNT_INC_SHIPPING', 'MODULE_ORDER_TOTAL_LEV_DISCOUNT_INC_TAX','MODULE_ORDER_TOTAL_LEV_DISCOUNT_CALC_TAX');
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_LEV_DISCOUNT_STATUS', 'true', '6', '1','vam_cfg_select_option(array(\'true\', \'false\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_LEV_DISCOUNT_SORT_ORDER', '98', '6', '2', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('MODULE_ORDER_TOTAL_LEV_DISCOUNT_INC_SHIPPING', 'true', '6', '3', 'vam_cfg_select_option(array(\'true\', \'false\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('MODULE_ORDER_TOTAL_LEV_DISCOUNT_INC_TAX', 'true', '6', '4','vam_cfg_select_option(array(\'true\', \'false\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function ,date_added) values ('MODULE_ORDER_TOTAL_LEV_DISCOUNT_CALC_TAX', 'false', '6', '5','vam_cfg_select_option(array(\'true\', \'false\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_LEV_DISCOUNT_TABLE', '100:7.5,250:10,500:12.5,1000:15', '6', '6', now())");
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