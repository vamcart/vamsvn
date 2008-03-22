<?php
/* --------------------------------------------------------------
   $Id: ship2pay.php 1025 2007-03-24 12:09:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(shipping.php,v 1.19 2002/04/13); www.oscommerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  class shipping {
    var $modules;
    
// class constructor
    function shipping() {

      if (defined('MODULE_SHIPPING_INSTALLED') && vam_not_null(MODULE_SHIPPING_INSTALLED)) {
        $allmods = explode(';', MODULE_SHIPPING_INSTALLED);
        
        $this->modules = array();
        
        for ($i = 0, $n = sizeof($allmods); $i < $n; $i++) {
          $file = $allmods[$i];
          $class = substr($file, 0, strrpos($file, '.'));
          $this->modules[$i] = array();
          $this->modules[$i]['class'] = $class;
          $this->modules[$i]['file'] = $file;
        }
      }
    }
    
    function get_modules(){
      return $this->modules;
    }
    
    function shipping_select($parameters, $selected = '') {
      echo $selected;
      $select_string = '<select ' . $parameters . '>';
      for ($i = 0, $n = sizeof($this->modules); $i < $n; $i++) {
        $select_string .= '<option value="' . $this->modules[$i]['class'] . '"';
        if ($selected == $this->modules[$i]['class']) $select_string .= ' SELECTED';
        $select_string .= '>' . $this->modules[$i]['class'] . '</option>';
      }
      $select_string .= '</select>';
      return $select_string;
    }
  }
?>
