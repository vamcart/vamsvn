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
   (c) 2004	 xt:Commerce (loginbox.php,v 1.10 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Loginbox V1.0        	Aubrey Kilian <aubrey@mycon.co.za>

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
$box = new vamTemplate;
$box->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$box_content = '';
require_once (DIR_FS_INC.'vam_image_submit.inc.php');
require_once (DIR_FS_INC.'vam_draw_password_field.inc.php');

if (!vam_session_is_registered('customer_id')) {

	$box->assign('FORM_ACTION', '<form id="loginbox" method="post" action="'.vam_href_link(FILENAME_LOGIN, 'action=process', 'SSL').'">');
	$box->assign('FIELD_EMAIL', vam_draw_input_field('email_address', '', ''));
	$box->assign('FIELD_PWD', vam_draw_password_field('password', '', ''));
	$box->assign('BUTTON', vam_image_submit('login.png', IMAGE_BUTTON_LOGIN));
	$box->assign('LINK_LOST_PASSWORD', vam_href_link(FILENAME_PASSWORD_DOUBLE_OPT, '', 'SSL'));
	$box->assign('LINK_NEW_ACCOUNT', vam_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));
	$box->assign('FORM_END', '</form>');

	$box->assign('BOX_CONTENT', $loginboxcontent);

	$box->caching = 0;
	$box->assign('language', $_SESSION['language']);
	$box_loginbox = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_login.html');
	$vamTemplate->assign('box_LOGIN', $box_loginbox);
}
?>