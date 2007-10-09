<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_parse_category_path.inc.php 784 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_parse_category_path.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_parse_category_path.inc.php,v 1.5 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
 // include needed function
 require_once(DIR_FS_INC . 'vam_string_to_int.inc.php');
 // Parse and secure the cPath parameter values
  function vam_parse_category_path($cPath) {
    // make sure the category IDs are integers
    $cPath_array = array_map('vam_string_to_int', explode('_', $cPath));

    // make sure no duplicate category IDs exist which could lock the server in a loop
	return array_unique($cPath_array);
  }
 ?>
