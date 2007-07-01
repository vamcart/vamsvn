<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_set_time_limit.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.3 2002/08/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_set_time_limit.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_set_time_limit.inc.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  // Sets timeout for the current script.
  // Can't be used in safe mode.
  function vam_set_time_limit($limit) {
    if (!get_cfg_var('safe_mode')) {
      set_time_limit($limit);
    }
  }
?>