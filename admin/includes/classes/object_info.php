<?php
/* --------------------------------------------------------------
   $Id: object_info.php 950 2007-02-08 12:17:21Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(object_info.php,v 1.5 2002/01/30); www.oscommerce.com 
   (c) 2003	 nextcommerce (object_info.php,v 1.5 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (object_info.php,v 1.5 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );
  class objectInfo {

    // class constructor
    function __construct($object_array) {
      foreach ($object_array as $key => $value) {
        $this->$key = vam_db_prepare_input($value);
      }
    }
    function objectInfo($object_array) {
      foreach ($object_array as $key => $value) {
        $this->$key = vam_db_prepare_input($value);
      }
    }
  }
?>