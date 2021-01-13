<?php
/* -----------------------------------------------------------------------------------------
   $Id: cart_actions.php 1298 2007-02-06 20:14:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_top.php,v 1.273 2003/05/19); www.oscommerce.com
   (c) 2003         nextcommerce (application_top.php,v 1.54 2003/08/25); www.nextcommerce.org
   (c) 2004         xt:Commerce (application_top.php,v 1.54 2003/08/25); xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:
   Add A Quickie v1.0 Autor  Harald Ponce de Leon

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

if (!is_object($_SESSION['cart'])) {
	$_SESSION['cart'] = new shoppingCart();
}

// Shopping cart actions
if (isset ($_GET['action'])) {
	// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled
	if ($session_started == false) {
		vam_redirect(vam_href_link(FILENAME_COOKIE_USAGE));
	}

	if (DISPLAY_CART == 'true' && AJAX_CART == 'false') {
		$goto = FILENAME_SHOPPING_CART;
		$parameters = array (
			'action',
			'cPath',
			'products_id',
			'pid'
		);
	} else {
		$goto = basename($PHP_SELF);
		if ($_GET['action'] == 'buy_now') {
			$parameters = array (
				'action',
				'pid',
				'products_id',
				'BUYproducts_id'
			);
		} else {
			$parameters = array (
				'action',
				'pid',
				'BUYproducts_id',
				'info'
			);
		}
	}
	switch ($_GET['action']) {
		// customer wants to update the product quantity in their shopping cart
		case 'update_product' :

       foreach( $_REQUEST as $key => $value) $_POST[$key]=$value;
			for ($i = 0, $n = sizeof($_POST['products_id']); $i < $n; $i++) {

				if (in_array($_POST['products_id'][$i], (is_array($_POST['cart_delete']) ? $_POST['cart_delete'] : array ()))) {
					$_SESSION['cart']->remove($_POST['products_id'][$i]);
				} else {
					if ($_POST['cart_quantity'][$i] > MAX_PRODUCTS_QTY)
						$_POST['cart_quantity'][$i] = MAX_PRODUCTS_QTY;
					$attributes = ($_POST['id'][$_POST['products_id'][$i]]) ? $_POST['id'][$_POST['products_id'][$i]] : '';

          if ( ($_POST['cart_quantity'][$i] >= vam_get_products_quantity_order_min((int)$_POST['products_id'][$i])) ) {

          if ( ($_POST['cart_quantity'][$i] <= vam_get_products_quantity_order_max((int)$_POST['products_id'][$i])) ) {

               unset($_SESSION['error_cart_msg']);
               
					$_SESSION['cart']->add_cart($_POST['products_id'][$i], vam_remove_non_numeric($_POST['cart_quantity'][$i]), $attributes, false);

          } else {
            $_SESSION['error_cart_msg'] = PRODUCTS_ORDER_QTY_MAX_TEXT_INFO . ' ' . vam_get_products_quantity_order_max((int)$_POST['products_id'][$i]);
          }

          } else {
            $_SESSION['error_cart_msg'] = PRODUCTS_ORDER_QTY_MIN_TEXT_INFO . ' ' . vam_get_products_quantity_order_min((int)$_POST['products_id'][$i]);
          }

				}
			}
			if (AJAX_CART == 'false') {
			vam_redirect(vam_href_link($goto, vam_get_all_get_params($parameters)));
			}
			break;
			// customer adds a product from the products page
		case 'add_product' :

          unset($_SESSION['error_cart_msg']);

       foreach( $_REQUEST as $key => $value) $_POST[$key]=$value;
			if (isset ($_POST['products_id']) && is_numeric($_POST['products_id'])) {
				if ($_POST['products_qty'] > MAX_PRODUCTS_QTY)
					$_POST['products_qty'] = MAX_PRODUCTS_QTY;

          unset($_SESSION['error_cart_msg']);

          if ( ($_POST['products_qty'] >= vam_get_products_quantity_order_min((int)$_POST['products_id'])) or ($_SESSION['cart']->get_quantity(vam_get_uprid($_POST['products_id'], $_POST['id'])) >= vam_get_products_quantity_order_min((int)$_POST['products_id']) ) ) {

          if ( ($_POST['products_qty'] <= vam_get_products_quantity_order_max((int)$_POST['products_id'])) or ($_SESSION['cart']->get_quantity(vam_get_uprid($_POST['products_id'], $_POST['id'])) >= vam_get_products_quantity_order_max((int)$_POST['products_id']) ) ) {
          
				$_SESSION['cart']->add_cart((int) $_POST['products_id'], $_SESSION['cart']->get_quantity(vam_get_uprid($_POST['products_id'], $_POST['id'])) + vam_remove_non_numeric($_POST['products_qty']), $_POST['id']);

          } else {
            $_SESSION['error_cart_msg'] = PRODUCTS_ORDER_QTY_MAX_TEXT_INFO . ' ' . vam_get_products_quantity_order_max((int)$_POST['products_id']);
          }

          } else {
            $_SESSION['error_cart_msg'] = PRODUCTS_ORDER_QTY_MIN_TEXT_INFO . ' ' . vam_get_products_quantity_order_min((int)$_POST['products_id']);
          }
          
			}
         if ( strlen($_SESSION['error_cart_msg'])==0 ) {
         if (AJAX_CART == 'false') {
			vam_redirect(vam_href_link($goto, 'products_id=' . (int) $_POST['products_id'] . '&' . vam_get_all_get_params($parameters)));
			}
			}
			break;

		case 'check_gift' :
			require_once (DIR_FS_INC . 'vam_collect_posts.inc.php');
			vam_collect_posts();
			break;

			// customer wants to add a quickie to the cart (called from a box)
		case 'add_a_quickie' :
			$quicky = addslashes($_POST['quickie']);
			if (GROUP_CHECK == 'true') {
				$group_check = "and group_permission_" . $_SESSION['customers_status']['customers_status_id'] . "=1 ";
			}

			$quickie_query = vam_db_query("select
						                                        products_fsk18,
						                                        products_id from " . TABLE_PRODUCTS . "
						                                        where products_model = '" . $quicky . "' " . "AND products_status = '1' " . $group_check);

			if (!vam_db_num_rows($quickie_query)) {
				if (GROUP_CHECK == 'true') {
					$group_check = "and group_permission_" . $_SESSION['customers_status']['customers_status_id'] . "=1 ";
				}
				$quickie_query = vam_db_query("select
								                                                 products_fsk18,
								                                                 products_id from " . TABLE_PRODUCTS . "
								                                                 where products_model LIKE '%" . $quicky . "%' " . "AND products_status = '1' " . $group_check);
			}
			if (vam_db_num_rows($quickie_query) != 1) {
				vam_redirect(vam_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'keywords=' . $quicky, 'NONSSL'));
			}
			$quickie = vam_db_fetch_array($quickie_query);
			if (vam_has_product_attributes($quickie['products_id'])) {
				vam_redirect(vam_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $quickie['products_id'], 'NONSSL'));
			} else {
				if ($quickie['products_fsk18'] == '1' && $_SESSION['customers_status']['customers_fsk18'] == '1') {
					vam_redirect(vam_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $quickie['products_id'], 'NONSSL'));
				}
				if ($_SESSION['customers_status']['customers_fsk18_display'] == '0' && $quickie['products_fsk18'] == '1') {
					vam_redirect(vam_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $quickie['products_id'], 'NONSSL'));
				}
				if ($_POST['quickie'] != '') {
					$act_qty = $_SESSION['cart']->get_quantity(vam_get_uprid($quickie['products_id'], 1));
					if ($act_qty > MAX_PRODUCTS_QTY)
						$act_qty = MAX_PRODUCTS_QTY - 1;
					$_SESSION['cart']->add_cart($quickie['products_id'], $act_qty +1, 1);
					vam_redirect(vam_href_link($goto, vam_get_all_get_params(array (
						'action'
					)), 'NONSSL'));
				} else {
					vam_redirect(vam_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'keywords=' . $quicky, 'NONSSL'));
				}
			}
			break;

			// performed by the 'buy now' button in product listings and review page
		case 'buy_now' :
			if (isset ($_GET['BUYproducts_id'])) {
				// check permission to view product

				$permission_query = vam_db_query("SELECT group_permission_" . $_SESSION['customers_status']['customers_status_id'] . " as customer_group, products_fsk18 from " . TABLE_PRODUCTS . " where products_id='" . (int) $_GET['BUYproducts_id'] . "'");
				$permission = vam_db_fetch_array($permission_query);

				// check for FSK18
				if ($permission['products_fsk18'] == '1' && $_SESSION['customers_status']['customers_fsk18'] == '1') {
					vam_redirect(vam_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id'], 'NONSSL'));
				}
				if ($_SESSION['customers_status']['customers_fsk18_display'] == '0' && $permission['products_fsk18'] == '1') {
					vam_redirect(vam_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id'], 'NONSSL'));
				}

				if (GROUP_CHECK == 'true') {

					if ($permission['customer_group'] != '1') {
						vam_redirect(vam_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id']));
					}
				}

            unset($_SESSION['error_cart_msg']);
            
          if ( (vam_get_products_quantity_order_min((int)$_GET['BUYproducts_id']) > 1)) {
            $_SESSION['error_cart_msg'] = PRODUCTS_ORDER_QTY_MIN_TEXT_INFO . ' ' . vam_get_products_quantity_order_min((int)$_GET['BUYproducts_id']);
					vam_redirect(vam_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id']));
          }

				if (vam_has_product_attributes($_GET['BUYproducts_id'])) {
					//if (AJAX_CART == 'false') {
					vam_redirect(vam_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id']));
					//} else {
					//$_POST['products_id'] = $_GET['BUYproducts_id'];
					//$_POST['products_qty'] = 1;
					//$_POST['id'] = array('1' => '1');
					//$_SESSION['cart']->add_cart((int) $_POST['products_id'], $_SESSION['cart']->get_quantity(vam_get_uprid($_POST['products_id'], $_POST['id'])) + vam_remove_non_numeric($_POST['products_qty']), $_POST['id']);
					//}
				} else {
					if (isset ($_SESSION['cart'])) {
						$_SESSION['cart']->add_cart((int) $_GET['BUYproducts_id'], $_SESSION['cart']->get_quantity((int) $_GET['BUYproducts_id']) + 1);
					} else {
						vam_redirect(vam_href_link(FILENAME_DEFAULT));
					}
				}
			}
				if (vam_has_product_attributes($_GET['BUYproducts_id'])) {
					if (AJAX_CART == 'false') {
					vam_redirect(vam_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id']));
					}
				} else {
			//vam_redirect(vam_href_link($goto, vam_get_all_get_params(array (
			//	'action',
			//	'BUYproducts_id'
			//))));
         }
			break;
		case 'cust_order' :
			if (isset ($_GET['pid'])) {
				$qty = (isset($_GET['products_qty']) && $_GET['products_qty']!='' ? $_GET['products_qty']:1);
            unset($_SESSION['error_cart_msg']);
            
          if ( (vam_get_products_quantity_order_min((int)$_GET['pid']) > 1)) {
            $_SESSION['error_cart_msg'] = PRODUCTS_ORDER_QTY_MIN_TEXT_INFO . ' ' . vam_get_products_quantity_order_min((int)$_GET['pid']);
         if (AJAX_CART == 'false') {
					vam_redirect(vam_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['pid']));
          } else {
             return;          
          }
          }
				
				
				if (vam_has_product_attributes((int) $_GET['pid'])) {
				//vam_redirect(vam_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['pid']));
					 
				//$attribut = preg_split('#{(.*?)}#u', $_GET['pid'], -1, PREG_SPLIT_DELIM_CAPTURE);
				//$attributes = array($attribut[1] => $attribut[2]);

				$attribut1 = str_replace('id['.$_GET['pid'].']','',$_GET['attributes']);
				
				//echo var_dump($attribut1);

				foreach($attribut1 as $v){
    				preg_match("/\[(.*)\]:(.*)/",$v,$matches);
    				$attributes1[$matches[1]] = $matches[2];
				}

				$_SESSION['cart']->add_cart((int)$_GET['pid'], (isset($_GET['update']) && $_GET['update']!='' ? $qty : $_SESSION['cart']->get_quantity($_GET['pid']) + $qty), $attributes1);
				
				} else {
					$_SESSION['cart']->add_cart((int)$_GET['pid'], (isset($_GET['update']) && $_GET['update']!='' ? $qty : $_SESSION['cart']->get_quantity((int) $_GET['pid']) + $qty));
				}
			}
         if ( strlen($_SESSION['error_cart_msg'])==0 ) {
         if (AJAX_CART == 'false') {
			vam_redirect(vam_href_link($goto, vam_get_all_get_params($parameters)));
			}
			}
			break;
	}
}
?>