<?php
/* -----------------------------------------------------------------------------------------
   $Id: table.php 1002 2007-02-06 21:19:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(table.php,v 1.27 2003/02/05); www.oscommerce.com 
   (c) 2003	 nextcommerce (table.php,v 1.8 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (table.php,v 1.8 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


  class deliv {
    var $code, $title, $description, $icon, $enabled;


    function __construct() {
      global $order;

      $this->code = 'deliv';
      $this->title = MODULE_SHIPPING_DELIV_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_DELIV_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_DELIV_SORT_ORDER;
      $this->icon = '';
      $this->tax_class = MODULE_SHIPPING_DELIV_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_DELIV_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_DELIV_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_DELIV_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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


    function quote($method = '') {
      global $order, $shipping_weight, $shipping_num_boxes,$vamPrice;

      if (MODULE_SHIPPING_DELIV_MODE == 'price') {
        $order_total = $vamPrice->RemoveCurr($_SESSION['cart']->show_total());
      } else {
        $order_total = $shipping_weight;
      }

      $table_cost = preg_split("/[:,]/" , MODULE_SHIPPING_DELIV_COST);
      $size = sizeof($table_cost);
      for ($i=0, $n=$size; $i<$n; $i+=2) {
        if ($order_total <= $table_cost[$i]) {
          $shipping = $table_cost[$i+1];
          break;
        }
      }

      if (MODULE_SHIPPING_DELIV_MODE == 'weight') {
        $shipping = $shipping * $shipping_num_boxes;
      }

      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_DELIV_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_DELIV_TEXT_WAY,
                                                     'cost' => $shipping + MODULE_SHIPPING_DELIV_HANDLING)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_DELIV_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_DELIV_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DELIV_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DELIV_COST', '25:8.50,50:5.50,10000:0.00', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_DELIV_MODE', 'weight', '6', '0', 'vam_cfg_select_option(array(\'weight\', \'price\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DELIV_HANDLING', '0', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_DELIV_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_DELIV_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_DELIV_SORT_ORDER', '0', '6', '0', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_DELIV_STATUS', 'MODULE_SHIPPING_DELIV_COST', 'MODULE_SHIPPING_DELIV_MODE', 'MODULE_SHIPPING_DELIV_HANDLING','MODULE_SHIPPING_DELIV_ALLOWED', 'MODULE_SHIPPING_DELIV_TAX_CLASS', 'MODULE_SHIPPING_DELIV_ZONE', 'MODULE_SHIPPING_DELIV_SORT_ORDER');
    }
  }
?>