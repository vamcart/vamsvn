<?php
/* -----------------------------------------------------------------------------------------
   $Id: shipping.php 1305 2007-02-06 20:23:03 VaM $ 

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(shipping.php,v 1.22 2003/05/08); www.oscommerce.com 
   (c) 2003	 nextcommerce (shipping.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (shipping.php,v 1.9 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  require_once(DIR_FS_INC . 'vam_in_array.inc.php');
  class shipping {
    var $modules;

    // class constructor
    function __construct($module = '') {
      global $PHP_SELF,$order;

      if (defined('MODULE_SHIPPING_INSTALLED') && vam_not_null(MODULE_SHIPPING_INSTALLED)) {
        $this->modules = explode(';', MODULE_SHIPPING_INSTALLED);

        $include_modules = array();

        if ( (vam_not_null($module)) && (in_array(substr($module['id'], 0, strpos($module['id'], '_')) . '.' . substr($PHP_SELF, (strrpos($PHP_SELF, '.')+1)), $this->modules)) ) {
          $include_modules[] = array('class' => substr($module['id'], 0, strpos($module['id'], '_')), 'file' => substr($module['id'], 0, strpos($module['id'], '_')) . '.' . substr($PHP_SELF, (strrpos($PHP_SELF, '.')+1)));
        } else {
          foreach ($this->modules as $value) {
            $class = substr($value, 0, strrpos($value, '.'));
            $include_modules[] = array('class' => $class, 'file' => $value);
          }
        }
        // load unallowed modules into array
        $unallowed_modules = explode(',',$_SESSION['customers_status']['customers_status_shipping_unallowed'].','.$order->customer['shipping_unallowed']);
        for ($i = 0, $n = sizeof($include_modules); $i < $n; $i++) {
          if (vam_in_array(str_replace('.php', '', $include_modules[$i]['file']), $unallowed_modules) != 'false') {
            // check if zone is alowed to see module
            if (constant(MODULE_SHIPPING_ . strtoupper(str_replace('.php', '', $include_modules[$i]['file'])) . _ALLOWED) != '') {
              $unallowed_zones = explode(',', constant(MODULE_SHIPPING_ . strtoupper(str_replace('.php', '', $include_modules[$i]['file'])) . _ALLOWED));
            } else {
              $unallowed_zones = array();
            }
            if (in_array($_SESSION['delivery_zone'], $unallowed_zones) == true || count($unallowed_zones) == 0) {
              include(DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/shipping/' . $include_modules[$i]['file']);
              include(DIR_WS_MODULES . 'shipping/' . $include_modules[$i]['file']);

              $GLOBALS[$include_modules[$i]['class']] = new $include_modules[$i]['class'];
            }
          }
        }
      }
    }

    function quote($method = '', $module = '') {
      global $total_weight, $shipping_weight, $shipping_quoted, $shipping_num_boxes, $length, $width, $height, $volume;

      $quotes_array = array();

      if (is_array($this->modules)) {
        $shipping_quoted = '';
        $shipping_num_boxes = 1;
        $shipping_weight = $total_weight;

        if (SHIPPING_BOX_WEIGHT >= $shipping_weight*SHIPPING_BOX_PADDING/100) {
          $shipping_weight = $shipping_weight+SHIPPING_BOX_WEIGHT;
        } else {
          $shipping_weight = $shipping_weight + ($shipping_weight*SHIPPING_BOX_PADDING/100);
        }

        if ($shipping_weight > SHIPPING_MAX_WEIGHT) { // Split into many boxes
          $shipping_num_boxes = ceil($shipping_weight/SHIPPING_MAX_WEIGHT);
          $shipping_weight = $shipping_weight/$shipping_num_boxes;
        }

        $include_quotes = array();

        foreach ($this->modules as $value) {
          $class = substr($value, 0, strrpos($value, '.'));
          if (vam_not_null($module)) {
            if ( ($module == $class) && ($GLOBALS[$class]->enabled) ) {
              $include_quotes[] = $class;
            }
          } elseif ($GLOBALS[$class]->enabled) {
            $include_quotes[] = $class;
          }
        }

        $size = sizeof($include_quotes);
        for ($i=0; $i<$size; $i++) {
          $quotes = $GLOBALS[$include_quotes[$i]]->quote($method);
          if (is_array($quotes)) $quotes_array[] = $quotes;
        }
      }

      return $quotes_array;
    }

    function cheapest() {

      if (is_array($this->modules)) {
        $rates = array();

        foreach ($this->modules as $value) {
          $class = substr($value, 0, strrpos($value, '.'));
          if ($GLOBALS[$class]->enabled) {
            $quotes = $GLOBALS[$class]->quotes;
            $size = sizeof($quotes['methods']);
            for ($i=0; $i<$size; $i++) {
            if(array_key_exists("cost",$quotes['methods'][$i])) {
                $rates[] = array('id' => $quotes['id'] . '_' . $quotes['methods'][$i]['id'],
                                 'title' => $quotes['module'] . ' (' . $quotes['methods'][$i]['title'] . ')',
                                 'cost' => $quotes['methods'][$i]['cost']);
                                // echo $quotes['methods'][$i]['cost'];

              }
            }
          }
        }

        $cheapest = false;
        $size = sizeof($rates);
        for ($i=0; $i<$size; $i++) {
          if (is_array($cheapest)) {
            if ($rates[$i]['cost'] < $cheapest['cost']) {
              $cheapest = $rates[$i];
            }
          } else {
            $cheapest = $rates[$i];
          }
        }
        return $cheapest;

      }

    }
  }
?>