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

   $module= new vamTemplate;
   $module->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');



  $module->assign('language', $_SESSION['language']);
  $module->assign('ERROR',$error);
  $module->assign('BUTTON','<a href="javascript:history.back(1)">'. vam_image_button('button_back.gif', IMAGE_BUTTON_CONTINUE).'</a>');
  $module->assign('language', $_SESSION['language']);

  // search field
  $module->assign('FORM_ACTION',vam_draw_form('new_find', vam_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get').vam_hide_session_id());
  $module->assign('INPUT_SEARCH',vam_draw_input_field('keywords', '', 'size="30" maxlength="30"'));
  $module->assign('BUTTON_SUBMIT',vam_image_submit('button_quick_find.gif', BOX_HEADING_SEARCH));
  $module->assign('LINK_ADVANCED',vam_href_link(FILENAME_ADVANCED_SEARCH));
  $module->assign('FORM_END', '</form>');



  $module->caching = 0;
  $module->caching = 0;
  $module= $module->fetch(CURRENT_TEMPLATE.'/module/error_message.html');

  if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO))  $product_info=$module;

  $vamTemplate->assign('main_content',$module);
  
  //header('HTTP/1.1 404 Not Found');
  
?>