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

	header("HTTP/1.1 404 Not Found");

   $module= new vamTemplate;
   $module->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');

  if (GROUP_CHECK == 'true') {
  $group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
  }
  
  $category_query = "select
                                      cd.categories_description,
                                      cd.categories_name,
          cd.categories_heading_title,       
                                      c.categories_template,
                                      c.categories_image from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
                                      where c.categories_id = '".$current_category_id."'
                                      and cd.categories_id = '".$current_category_id."'
                                      ".$group_check."
                                      and cd.language_id = '".(int) $_SESSION['languages_id']."'";

  $category_query = vamDBquery($category_query);

  $category = vam_db_fetch_array($category_query, true);
  
  $module->assign('CATEGORIES_NAME', $category['categories_name']);
  $module->assign('CATEGORIES_DESCRIPTION', $category['categories_description']);

  $module->assign('language', $_SESSION['language']);
  $module->assign('ERROR',$error);
  $module->assign('BUTTON','<a class="button" href="javascript:history.back(1)">'. vam_image_button('back.png', IMAGE_BUTTON_CONTINUE).'</a>');
  $module->assign('language', $_SESSION['language']);

  // search field
  $module->assign('FORM_ACTION',vam_draw_form('new_find', vam_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get').vam_hide_session_id());
  $module->assign('INPUT_SEARCH',vam_draw_input_field('keywords', '', 'size="30" maxlength="30"'));
  $module->assign('BUTTON_SUBMIT',vam_image_submit('search.png', BOX_HEADING_SEARCH));
  $module->assign('LINK_ADVANCED',vam_href_link(FILENAME_ADVANCED_SEARCH));
  $module->assign('FORM_END', '</form>');



  $module->caching = 0;
  $module->caching = 0;
  $module= $module->fetch(CURRENT_TEMPLATE.'/module/error_message.html');

  if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO))  $product_info=$module;

  $vamTemplate->assign('main_content',$module);

?>