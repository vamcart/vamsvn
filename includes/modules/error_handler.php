<?php
/* -----------------------------------------------------------------------------------------
   $Id: error_handler.php 949 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2004	 xt:Commerce (error_handler.php,v 1.6 2003/08/13); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

   $module_smarty= new vamTemplate;
   $module_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');



  $module_smarty->assign('language', $_SESSION['language']);
  $module_smarty->assign('ERROR',$error);
  $module_smarty->assign('BUTTON','<a href="javascript:history.back(1)">'. vam_image_button('button_back.gif', IMAGE_BUTTON_CONTINUE).'</a>');
  $module_smarty->assign('language', $_SESSION['language']);

  // search field
  $module_smarty->assign('FORM_ACTION',vam_draw_form('new_find', vam_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get').vam_hide_session_id());
  $module_smarty->assign('INPUT_SEARCH',vam_draw_input_field('keywords', '', 'size="30" maxlength="30"'));
  $module_smarty->assign('BUTTON_SUBMIT',vam_image_submit('button_quick_find.gif', BOX_HEADING_SEARCH));
  $module_smarty->assign('LINK_ADVANCED',vam_href_link(FILENAME_ADVANCED_SEARCH));
  $module_smarty->assign('FORM_END', '</form>');



  $module_smarty->caching = 0;
  $module_smarty->caching = 0;
  $module= $module_smarty->fetch(CURRENT_TEMPLATE.'/module/error_message.html');

  if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO))  $product_info=$module;

  $smarty->assign('main_content',$module);
?>