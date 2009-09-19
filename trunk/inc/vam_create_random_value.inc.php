<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_create_random_value.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_create_random_value.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_create_random_value.inc.php,v 1.5 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
// include needed functions
require_once(DIR_FS_INC . 'vam_rand.inc.php');
function vam_create_random_value($length, $type = 'mixed') {
    if ( ($type != 'mixed') && ($type != 'chars') && ($type != 'digits')) return false;

    $rand_value = '';
    while (strlen($rand_value) < $length) {
      if ($type == 'digits') {
        $char = vam_rand(0,9);
      } else {
        $char = chr(vam_rand(0,255));
      }
      if ($type == 'mixed') {
        if (preg_match('/^[a-z0-9]$/i', $char)) $rand_value .= $char;
      } elseif ($type == 'chars') {
        if (preg_match('/^[a-z]$/i', $char)) $rand_value .= $char;
      } elseif ($type == 'digits') {
        if (preg_match('/^[0-9]$/', $char)) $rand_value .= $char;
      }
    }

    return $rand_value;
  }
 ?>
