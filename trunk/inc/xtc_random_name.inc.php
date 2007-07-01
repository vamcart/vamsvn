<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_random_name.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (vam_random_name.inc.php,v 1.1 2003/08/18); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_random_name.inc.php,v 1.1 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  // Returns a random name, 16 to 20 characters long
  // There are more than 10^28 combinations
  // The directory is "hidden", i.e. starts with '.'
  function vam_random_name() {
    $letters = 'abcdefghijklmnopqrstuvwxyz';
    $dirname = '.';
    $length = floor(vam_rand(16,20));
    for ($i = 1; $i <= $length; $i++) {
     $q = floor(vam_rand(1,26));
     $dirname .= $letters[$q];
    }
    return $dirname;
  }
 ?>