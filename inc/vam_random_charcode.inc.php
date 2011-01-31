<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_random_charcode.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (vam_random_charcode.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_random_charcode.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  // build to generate a random charcode
  function vam_random_charcode($length) {
 $arraysize = 10; 
// $chars = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9');
 $chars = array('0','1','2','3','4','5','6','7','8','9');

  $code = '';
    for ($i = 1; $i <= $length; $i++) {
    $j = floor(vam_rand(0,$arraysize));
    $code .= $chars[$j];
    }
    return  $code;
    }
 ?>