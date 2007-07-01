<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_draw_box_content_bullet.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(output.php,v 1.3 2002/06/01); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_draw_box_content_bullet.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_draw_box_content_bullet.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
function vam_draw_box_content_bullet($bullet_text, $bullet_link = '') {
    global $page_file;

    $bullet = '      <tr>' . CR .
              '        <td><table border="0" cellspacing="0" cellpadding="0">' . CR .
              '          <tr>' . CR .
              '            <td width="12" class="boxText"><img src="images/icon_pointer.gif" border="0"></td>' . CR .
              '            <td class="infoboxText">';
    if ($bullet_link) {
      if ($bullet_link == $page_file) {
        $bullet .= '<font color="#0033cc"><b>' . $bullet_text . '</b></font>';
      } else {
        $bullet .= '<a href="' . $bullet_link . '">' . $bullet_text . '</a>';
      }
    } else {
      $bullet .= $bullet_text;
    }

    $bullet .= '</td>' . CR .
               '         </tr>' . CR .
               '       </table></td>' . CR .
               '     </tr>' . CR;

    return $bullet;
  }
 ?>