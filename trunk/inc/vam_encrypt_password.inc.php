<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_encrypt_password.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(password_funcs.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_encrypt_password.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_encrypt_password.inc.php,v 1.4 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
  
// This function makes a new password from a plaintext password. 
  function vam_encrypt_password($plain) {

     $password=md5($plain);

    return $password;

  }
 ?>