<?php

  class ot_discount_quant {
    var $title, $output;

    function ot_discount_quant() {
     $this->code = 'ot_discount_quant';
      $this->title = MODULE_ORDER_TOTAL_DISCOUNT_QUANT_TITLE;
      $this->description = MODULE_ORDER_TOTAL_DISCOUNT_QUANT_DESCRIPTION;
      $this->enabled = ((MODULE_ORDER_TOTAL_DISCOUNT_QUANT_STATUS == 'true') ? true : false);
      $this->sort_order = MODULE_ORDER_TOTAL_DISCOUNT_QUANT_SORT_ORDER;

      $this->output = array();
    }

   function process() {
       global $order, $vamPrice;
      //if the module is on, then apply a discount
      if(MODULE_ORDER_TOTAL_DISCOUNT_QUANT_STATUS == 'true'){ 
	  
	  $table_quant = preg_split("/[:,]/" , MODULE_ORDER_TOTAL_DISCOUNT_QUANT_PERCENT);
      $size = sizeof($table_quant);
      for ($i=0, $n=$size; $i<$n; $i+=2) {
        if ($_SESSION['cart']->count_contents() <= $table_quant[$i]) {
          $discount_quant_percent = $table_quant[$i+1];
          break;
        }	 
		if ($i>=($n-2))  $discount_quant_percent = $table_quant[$i+1];
      }
	  
        if($_SESSION['cart']->count_contents() >= MODULE_ORDER_TOTAL_DISCOUNT_QUANT_ITEMS){
          $discount_quant = $vamPrice->Format($order->info['subtotal'], false)/ 100 *  $discount_quant_percent ;
          $order->info['total'] -= $discount_quant;
          $this->output[] = array('title' => $this->title . " " .  $discount_quant_percent . '% :',
                                  'text' => '<font color="ff0000">'.$vamPrice->Format("-".$discount_quant, true).'</font>',
                                  'value' => $discount_quant);
        }
      }
    }	

    function check() {
      if (!isset($this->_check)) {
         $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_DISCOUNT_QUANT_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }

      return $this->_check;
    }

     function keys() {
      return array('MODULE_ORDER_TOTAL_DISCOUNT_QUANT_STATUS', 'MODULE_ORDER_TOTAL_DISCOUNT_QUANT_SORT_ORDER' ,'MODULE_ORDER_TOTAL_DISCOUNT_QUANT_ITEMS', 'MODULE_ORDER_TOTAL_DISCOUNT_QUANT_PERCENT');
    }

     function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_DISCOUNT_QUANT_STATUS', 'true',  '6', '1','vam_cfg_select_option(array(\'true\', \'false\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_DISCOUNT_QUANT_SORT_ORDER', '21', '6', '2', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_DISCOUNT_QUANT_ITEMS', '3', '6', '3', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_DISCOUNT_QUANT_PERCENT', '2:2,4:5', '6', '4', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }

  

?>