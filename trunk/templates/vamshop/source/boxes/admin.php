<?php
/* -----------------------------------------------------------------------------------------
   $Id: admin.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com 
   (c) 2003	 nextcommerce (admin.php,v 1.12 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (admin.php,v 1.12 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

// reset var
$box_smarty = new vamTemplate;
$box_content='';
$flag='';
$box_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');

  // include needed functions
  require_once(DIR_FS_INC . 'vam_image_button.inc.php');

  $orders_contents = '';
  
  $orders_status_validating = vam_db_num_rows(vam_db_query("select orders_status from " . TABLE_ORDERS ." where orders_status ='0'"));
  $orders_contents .='<a href="' . vam_href_link_admin(FILENAME_ORDERS, 'selected_box=customers&amp;status=0', 'SSL') . '">' . TEXT_VALIDATING . '</a>: ' . $orders_status_validating . '<br />'; 
 
  
  $orders_status_query = vam_db_query("select orders_status_name, orders_status_id from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$_SESSION['languages_id'] . "'");
  while ($orders_status = vam_db_fetch_array($orders_status_query)) {
    $orders_pending_query = vam_db_query("select count(*) as count from " . TABLE_ORDERS . " where orders_status = '" . $orders_status['orders_status_id'] . "'");
    $orders_pending = vam_db_fetch_array($orders_pending_query);
    $orders_contents .= '<a href="' . vam_href_link_admin(FILENAME_ORDERS, 'selected_box=customers&amp;status=' . $orders_status['orders_status_id'], 'SSL') . '">' . $orders_status['orders_status_name'] . '</a>: ' . $orders_pending['count'] . '<br />';
  }
  $orders_contents = substr($orders_contents, 0, -6);

  $customers_query = vam_db_query("select count(*) as count from " . TABLE_CUSTOMERS);
  $customers = vam_db_fetch_array($customers_query);
  $products_query = vam_db_query("select count(*) as count from " . TABLE_PRODUCTS . " where products_status = '1'");
  $products = vam_db_fetch_array($products_query);
  $reviews_query = vam_db_query("select count(*) as count from " . TABLE_REVIEWS);
  $reviews = vam_db_fetch_array($reviews_query);
  $admin_image = '<p class="LoginContentLeft"><a href="' . vam_href_link_admin(FILENAME_START,'', 'SSL').'">'.vam_image_button('button_admin.gif', IMAGE_BUTTON_ADMIN).'</a></p>';
   if ($product->isProduct()) {
    $admin_link='<p class="LoginContentLeft"><a href="' . vam_href_link_admin(FILENAME_EDIT_PRODUCTS, 'cPath=' . $cPath . '&amp;pID=' . $product->data['products_id']) . '&amp;action=new_product' . '" onclick="window.open(this.href); return false;">' . vam_image_button('edit_product.gif', IMAGE_BUTTON_PRODUCT_EDIT) . '</a></p>';
  }

  $box_content= '<b>' . BOX_TITLE_STATISTICS . '</b><br />' . $orders_contents . '<br />' .
                                         BOX_ENTRY_CUSTOMERS . ' ' . $customers['count'] . '<br />' .
                                         BOX_ENTRY_PRODUCTS . ' ' . $products['count'] . '<br />' .
                                         BOX_ENTRY_REVIEWS . ' ' . $reviews['count'] .'<br />' .
                                         $admin_image . '<br />' .$admin_link;

    if ($flag==true) define('SEARCH_ENGINE_FRIENDLY_URLS',true);
    $box_smarty->assign('BOX_CONTENT', $box_content);

    $box_smarty->caching = 0;
    $box_smarty->assign('language', $_SESSION['language']);
    $box_admin= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_admin.html');
    $smarty->assign('box_ADMIN',$box_admin);

?>