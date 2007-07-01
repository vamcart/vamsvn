<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_count_payment_modules.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_count_payment_modules.inc.php,v 1.5 2003/08/13); www.nextcommerce.org 
   (c) 2004 xt:Commerce (vam_count_payment_modules.inc.php,v 1.5 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
  // include needed functions
  require_once(DIR_FS_INC . 'vam_count_modules.inc.php');
  function vam_count_payment_modules() {
    return vam_count_modules(MODULE_PAYMENT_INSTALLED);
  }
 ?>
