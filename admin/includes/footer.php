<?php
/* --------------------------------------------------------------
   $Id: footer.php 899 2007-02-08 12:09:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(footer.php,v 1.12 2003/02/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (footer.php,v 1.11 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (footer.php,v 1.11 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
?>
<br>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td align="center" class="smallText"><?php
/*
  The following copyright announcement is in compliance
  to section 2c of the GNU General Public License, and
  thus can not be removed, or can only be modified
  appropriately.

  For more information please read the osCommerce
  Copyright Policy at:

  http://www.oscommerce.com/about/copyright

  Please leave this comment intact together with the
  following copyright announcement.
*/
?>
<p>
<?php echo VAMSHOP_SUPPORT_KEY_TEXT; ?>
<?php echo VAMSHOP_SUPPORT_KEY; ?>
</p>
E-Commerce Engine Copyright &copy; 2003 <a href="http://www.oscommerce.com" target="_blank">osCommerce</a> Portions Copyright &copy; 2003 - 2005 <a href="http://xt-commerce.com" target="_blank">xt:Commerce</a>, &copy; 2005-<?php echo date("Y"); ?> <a href="http://vamshop.ru" target="_blank">VamShop</a><br />
osCommerce provides no warranty and is redistributable under the <a href="http://www.fsf.org/licenses/gpl.txt" target="_blank">GNU General Public License</a><br>
<a href="http://vamshop.ru" target="_blank">VamShop</a> provides no warranty except as to associated support contracts<br />which are limited by and to the Service Level Agreement.<br />
  </td>
  </tr>
</table>

<script src="<?php echo DIR_WS_CATALOG; ?>jscript/jquery/plugins/scrollup/jquery.scrollup.min.js"></script>
<script src="<?php echo DIR_WS_ADMIN; ?>includes/javascript/vamshop.js"></script>
<?php
include(DIR_FS_ADMIN.DIR_WS_INCLUDES.'/javascript/script_footer_local.php');
include(DIR_FS_ADMIN.DIR_WS_INCLUDES.'/javascript/script_footer.php');
include(DIR_FS_ADMIN.DIR_WS_INCLUDES.'/css/css_footer_local.php');
include(DIR_FS_ADMIN.DIR_WS_INCLUDES.'/css/css_footer.php');
?>