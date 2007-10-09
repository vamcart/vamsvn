<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_country_list.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_get_country_list.inc.php,v 1.5 2003/08/20); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_country_list.inc.php,v 1.5 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

// include needed functions
  include_once(DIR_FS_INC . 'vam_draw_pull_down_menu.inc.php');
  include_once(DIR_FS_INC . 'vam_get_countries.inc.php');
  
  function vam_get_country_list($name, $selected = '', $parameters = '') {
   $countries_array = array(array('id' => '', 'text' => PULL_DOWN_DEFAULT));
//    Probleme mit register_globals=off -> erstmal nur auskommentiert. Kann u.U. gelцscht werden.
    $countries = vam_get_countriesList();

    for ($i=0, $n=sizeof($countries); $i<$n; $i++) {
      $countries_array[] = array('id' => $countries[$i]['countries_id'], 'text' => $countries[$i]['countries_name']);
    }
	if (is_array($name)) return vam_draw_pull_down_menuNote($name, $countries_array, $selected, $parameters);
    return vam_draw_pull_down_menu($name, $countries_array, $selected, $parameters);
  }
  
  
 ?>