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
   (c) 2002-2003 osCommerce www.oscommerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

////
// Class to handle links between shipping and payment



  class ship2pay {
    var $modules;

// class constructor
    function ship2pay() {
      global $language, $PHP_SELF,$shipment,$GLOBALS;
      $this->modules = array();
      $q_ship2pay = vam_db_query("SELECT shipment, payments_allowed FROM ".TABLE_SHIP2PAY." where status=1");
      while ($mods = vam_db_fetch_array($q_ship2pay)) {
        $this->modules[$mods['shipment']] = $mods['payments_allowed'];
      }
    }
    
    function get_pay_modules($ship_module){
      return $this->modules[$ship_module];
    }
   }
?>
