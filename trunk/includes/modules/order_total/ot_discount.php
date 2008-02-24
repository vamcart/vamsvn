<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_discount.php 1277 2007-02-06 21:01:37 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_subtotal.php,v 1.7 2003/02/13); www.oscommerce.com
   (c) 2003	 nextcommerce (ot_discount.php,v 1.11 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (ot_discount.php,v 1.11 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  class ot_discount {
    var $title, $output;

    function ot_discount() {
    	global $vamPrice;
      $this->code = 'ot_discount';
      $this->title = MODULE_ORDER_TOTAL_DISCOUNT_TITLE;
      $this->description = MODULE_ORDER_TOTAL_DISCOUNT_DESCRIPTION;
      $this->enabled = ((MODULE_ORDER_TOTAL_DISCOUNT_STATUS == 'true') ? true : false);
      $this->sort_order = MODULE_ORDER_TOTAL_DISCOUNT_SORT_ORDER;


      $this->output = array();
    }

    function process() {
      global $order, $vamPrice;
//      echo 'xx';
      $this->title = SUB_TITLE_OT_DISCOUNT . ' ' . $_SESSION['customers_status']['customers_status_ot_discount'] . '%';
      if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1' && $_SESSION['customers_status']['customers_status_ot_discount']!='0.00') {
        $discount_price = $vamPrice->Format($order->info['subtotal'], false) / 100 * $_SESSION['customers_status']['customers_status_ot_discount']*-1;
        $this->output[] = array('title' => $this->title . ':',
                                'text' => '<font color="ff0000">'.$vamPrice->Format($discount_price,true).'</font>',
                                'value' => $discount_price);
      }
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_DISCOUNT_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }

      return $this->_check;
    }

    function keys() {
      return array('MODULE_ORDER_TOTAL_DISCOUNT_STATUS', 'MODULE_ORDER_TOTAL_DISCOUNT_SORT_ORDER');
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_DISCOUNT_STATUS', 'true','6', '1','vam_cfg_select_option(array(\'true\', \'false\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_DISCOUNT_SORT_ORDER', '2', '7', '2', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }
?>