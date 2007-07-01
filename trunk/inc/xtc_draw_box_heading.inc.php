<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_draw_box_heading.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(output.php,v 1.3 2002/06/01); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_draw_box_heading.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_draw_box_heading.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
function vam_draw_box_heading($heading_title, $left_corner = false, $right_corner = false) {
    $heading = '<table cellspacing="0" cellpadding="0" width="100%" border="0">' . CR .
               '  <tr valign="middle" bgcolor="' . BOX_BGCOLOR_HEADING . '">' . CR .
               '    <td>';
    if ($left_corner) {
      $heading .= '<img src="images/main_page/box_corner_left.gif" alt="" />';
    } else {
      $heading .= '<img src="images/main_page/box_corner_right_left.gif" alt="" />';
    }

    $heading .= '</td>' . CR .
                '    <td class="infoBoxHeading">' . $heading_title . '</td>' . CR;

    if ($right_corner) {
      $heading .= '    <td class="infoBoxHeading"><img src="images/main_page/box_corner_right.gif" alt="" /></td>' . CR;
    }

    $heading .= '  </tr>' . CR .
                '</table>' . CR;

    return $heading;
  }
 ?>