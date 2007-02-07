<?php
/* -----------------------------------------------------------------------------------------
   $Id: newsletter.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(manufacturers.php,v 1.18 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (manufacturers.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (newsletter.php,v 1.9 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$box_smarty = new smarty;
$box_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/'); 
$box_content='';


$box_smarty->assign('FORM_ACTION', xtc_draw_form('sign_in', xtc_href_link(FILENAME_NEWSLETTER, '', 'NONSSL')));
$box_smarty->assign('FIELD_EMAIL',xtc_draw_input_field('email', '', ''));
$box_smarty->assign('BUTTON',xtc_image_submit('button_login_small.gif', IMAGE_BUTTON_LOGIN));
$box_smarty->assign('FORM_END','</form>');
	$box_smarty->assign('language', $_SESSION['language']);
       	  // set cache ID
   if (!CacheCheck()) {
  $box_smarty->caching = 0;
  $box_newsletter= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_newsletter.html');
  } else {
  $box_smarty->caching = 1;	
  $box_smarty->cache_lifetime=CACHE_LIFETIME;
  $box_smarty->cache_modified_check=CACHE_CHECK;
  $cache_id = $_SESSION['language'];
  $box_newsletter= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_newsletter.html',$cache_id);
  }

    $smarty->assign('box_NEWSLETTER',$box_newsletter);
?>