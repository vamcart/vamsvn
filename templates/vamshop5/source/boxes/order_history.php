<?php
/* -----------------------------------------------------------------------------------------
   $Id: order_history.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(order_history.php,v 1.4 2003/02/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (order_history.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (order_history.php,v 1.9 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
$box = new vamTemplate;
$box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/'); 
$box_content='';
  // include needed functions
  require_once(DIR_FS_INC . 'vam_get_all_get_params.inc.php');

  if (isset($_SESSION['customer_id'])) {
    // retreive the last x products purchased
    $orders_query = vam_db_query("select distinct op.products_id from " . TABLE_ORDERS . " o, " . TABLE_ORDERS_PRODUCTS . " op, " . TABLE_PRODUCTS . " p where o.customers_id = '" . (int)$_SESSION['customer_id'] . "' and o.orders_id = op.orders_id and op.products_id = p.products_id and p.products_status = '1' group by products_id order by o.date_purchased desc limit " . MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX);
    if (vam_db_num_rows($orders_query)) {



      $product_ids = '';
      while ($orders = vam_db_fetch_array($orders_query)) {
        $product_ids .= $orders['products_id'] . ',';
      }
      $product_ids = substr($product_ids, 0, -1);

      $customer_orders_string = '<table border="0" width="100%" cellspacing="0" cellpadding="1">';
      $products_query = vam_db_query("select products_id, products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id in (" . $product_ids . ") and language_id = '" . (int)$_SESSION['languages_id'] . "' order by products_name");
      while ($products = vam_db_fetch_array($products_query)) {
        $customer_orders_string .= '  <tr>' .
                                   '    <td class="infoBoxContents"><a href="' . vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($products['products_id'],$products['products_name'])) . '">' . $products['products_name'] . '</a></td>' .
                                   '    <td class="infoBoxContents" align="right" valign="top"><a href="' . vam_href_link(basename($PHP_SELF), vam_get_all_get_params(array('action')) . 'action=cust_order&pid=' . $products['products_id']) . '">' . vam_image(DIR_WS_ICONS . 'cart.gif', ICON_CART) . '</a></td>' .
                                   '  </tr>';
      }
      $customer_orders_string .= '</table>';


    }
  }


    $box->assign('BOX_CONTENT', $customer_orders_string);

    $box->caching = 0;
    $box->assign('language', $_SESSION['language']);
    $box_order_history= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_order_history.html');
    $vamTemplate->assign('box_HISTORY',$box_order_history);
    
  ?>