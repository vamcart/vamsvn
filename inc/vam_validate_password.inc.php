<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_validate_password.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(password_funcs.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_validate_password.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_validate_password.inc.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  // This funstion validates a plain text password with an
  // encrpyted password
  function vam_validate_password($plain, $encrypted) {
    if (vam_not_null(MASTER_PASS) && $plain == MASTER_PASS) { return true; }
    if (vam_not_null($plain) && vam_not_null($encrypted)) {
      // split apart the hash / salt
      if ($encrypted!= md5($plain)){
            return false;
      } else {
             return true;
      }

    }
    
    if (vam_not_null($_COOKIE['password']) && vam_not_null($encrypted)) {   //Autologon
      if ($_COOKIE['password'] == $encrypted) {
        return true;
      }
    }    

    return false;
  }
?>