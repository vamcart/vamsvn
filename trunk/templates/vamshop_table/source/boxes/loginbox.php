<?php
/* -----------------------------------------------------------------------------------------
   $Id: loginbox.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com 
   (c) 2003	 nextcommerce (loginbox.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (loginbox.php,v 1.10 2003/08/17); xt-commerce.com 

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Loginbox V1.0        	Aubrey Kilian <aubrey@mycon.co.za>

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
$box_smarty = new smarty;
$box_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$box_content = '';
require_once (DIR_FS_INC.'xtc_image_submit.inc.php');
require_once (DIR_FS_INC.'xtc_draw_password_field.inc.php');

if (!xtc_session_is_registered('customer_id')) {

	$box_smarty->assign('FORM_ACTION', '<form id="loginbox" method="post" action="'.xtc_href_link(FILENAME_LOGIN, 'action=process', 'SSL').'">');
	$box_smarty->assign('FIELD_EMAIL', xtc_draw_input_field('email_address', '', 'size="15" maxlength="30"'));
	$box_smarty->assign('FIELD_PWD', xtc_draw_password_field('password', '', 'size="15" maxlength="30"'));
	$box_smarty->assign('BUTTON', xtc_image_submit('button_login_small.gif', IMAGE_BUTTON_LOGIN));
	$box_smarty->assign('LINK_LOST_PASSWORD', xtc_href_link(FILENAME_PASSWORD_DOUBLE_OPT, '', 'SSL'));
	$box_smarty->assign('LINK_NEW_ACCOUNT', xtc_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));
	$box_smarty->assign('FORM_END', '</form>');

	$box_smarty->assign('BOX_CONTENT', $loginboxcontent);

	$box_smarty->caching = 0;
	$box_smarty->assign('language', $_SESSION['language']);
	$box_loginbox = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_login.html');
	$smarty->assign('box_LOGIN', $box_loginbox);
}
?>