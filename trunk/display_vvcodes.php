<?php
/* -----------------------------------------------------------------------------------------
  $Id: display_vvcodes.php 831 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2004  xt:Commerce (display_vvcodes.php,v 1.27 2003/08/24); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require ('includes/application_top.php');
require_once (DIR_FS_INC.'vam_render_vvcode.inc.php');
require_once (DIR_FS_INC.'vam_random_charcode.inc.php');

$visual_verify_code = vam_random_charcode(6);
$_SESSION['vvcode'] = $visual_verify_code;
$vvimg = vvcode_render_code($visual_verify_code);
?>