<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_create_password.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (vam_create_password.inc.php,v 1.5 2003/08/13); www.nextcommerce.org  
   (c) 2004 xt:Commerce (vam_create_password.inc.php,v 1.5 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

     function vam_RandomString($length) {
       $chars = array( 'a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',  'k', 'K', 'l', 'L', 'm', 'M', 'n','N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T',  'u', 'U', 'v','V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');

       $max_chars = count($chars) - 1;
       srand( (double) microtime()*1000000);

       $rand_str = '';
       for($i=0;$i<$length;$i++)
       {
         $rand_str = ( $i == 0 ) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
       }

         return $rand_str;
       }

  function vam_create_password($length) {

  	$pass=vam_RandomString($length);
    return md5($pass);
  }
  
  ?>