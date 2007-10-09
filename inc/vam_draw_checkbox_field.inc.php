<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_draw_checkbox_field.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_draw_checkbox_field.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_draw_checkbox_field.inc.php,v 1.5 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

   require_once(DIR_FS_INC . 'vam_draw_selection_field.inc.php');
   
// Output a form checkbox field
  function vam_draw_checkbox_field($name, $value = '', $checked = false, $parameters = '') {
    return vam_draw_selection_field($name, 'checkbox', $value, $checked, $parameters);
  }
 ?>
