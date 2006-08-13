<?php

/* -----------------------------------------------------------------------------------------
   $Id: cart_actions.php 1298 2005-10-09 13:14:44Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_top.php,v 1.273 2003/05/19); www.oscommerce.com
   (c) 2003         nextcommerce (application_top.php,v 1.54 2003/08/25); www.nextcommerce.org

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

// Shopping cart actions
if (isset ($_GET['action'])) {
	// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled
	if ($session_started == false) {
		xtc_redirect(xtc_href_link(FILENAME_COOKIE_USAGE));
	}

	if (DISPLAY_CART == 'true') {
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

			for ($i = 0, $n = sizeof($_POST['products_id']); $i < $n; $i++) {
					if (in_array($_POST['products_id'][$i], (is_array($_POST['cart_delete']) ? $_POST['cart_delete'] : array ()))) {
					$_SESSION['cart']->remove($_POST['products_id'][$i]);
				} else {
					if ($_POST['cart_quantity'][$i] > MAX_PRODUCTS_QTY)
						$_POST['cart_quantity'][$i] = MAX_PRODUCTS_QTY;
					$attributes = ($_POST['id'][$_POST['products_id'][$i]]) ? $_POST['id'][$_POST['products_id'][$i]] : '';
					$_SESSION['cart']->add_cart($_POST['products_id'][$i], xtc_remove_non_numeric($_POST['cart_quantity'][$i]), $attributes, false);
				}
			}
			xtc_redirect(xtc_href_link($goto, xtc_get_all_get_params($parameters)));
			break;
			// customer adds a product from the products page
		case 'add_product' :
			if (isset ($_POST['products_id']) && is_numeric($_POST['products_id'])) {
				if ($_POST['products_qty'] > MAX_PRODUCTS_QTY)
					$_POST['products_qty'] = MAX_PRODUCTS_QTY;
				$_SESSION['cart']->add_cart((int) $_POST['products_id'], $_SESSION['cart']->get_quantity(xtc_get_uprid($_POST['products_id'], $_POST['id'])) + xtc_remove_non_numeric($_POST['products_qty']), $_POST['id']);
			}
			xtc_redirect(xtc_href_link($goto, 'products_id=' . (int) $_POST['products_id'] . '&' . xtc_get_all_get_params($parameters)));
			break;

		case 'check_gift' :
			require_once (DIR_FS_INC . 'xtc_collect_posts.inc.php');
			xtc_collect_posts();
			break;

			// customer wants to add a quickie to the cart (called from a box)
		case 'add_a_quickie' :
			$quicky = addslashes($_POST['quickie']);
			if (GROUP_CHECK == 'true') {
				$group_check = "and group_permission_" . $_SESSION['customers_status']['customers_status_id'] . "=1 ";
			}

			$quickie_query = xtc_db_query("select
						                                        products_fsk18,
						                                        products_id from " . TABLE_PRODUCTS . "
						                                        where products_model = '" . $quicky . "' " . "AND products_status = '1' " . $group_check);

			if (!xtc_db_num_rows($quickie_query)) {
				if (GROUP_CHECK == 'true') {
					$group_check = "and group_permission_" . $_SESSION['customers_status']['customers_status_id'] . "=1 ";
				}
				$quickie_query = xtc_db_query("select
								                                                 products_fsk18,
								                                                 products_id from " . TABLE_PRODUCTS . "
								                                                 where products_model LIKE '%" . $quicky . "%' " . "AND products_status = '1' " . $group_check);
			}
			if (xtc_db_num_rows($quickie_query) != 1) {
				xtc_redirect(xtc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'keywords=' . $quicky, 'NONSSL'));
			}
			$quickie = xtc_db_fetch_array($quickie_query);
			if (xtc_has_product_attributes($quickie['products_id'])) {
				xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $quickie['products_id'], 'NONSSL'));
			} else {
				if ($quickie['products_fsk18'] == '1' && $_SESSION['customers_status']['customers_fsk18'] == '1') {
					xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $quickie['products_id'], 'NONSSL'));
				}
				if ($_SESSION['customers_status']['customers_fsk18_display'] == '0' && $quickie['products_fsk18'] == '1') {
					xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $quickie['products_id'], 'NONSSL'));
				}
				if ($_POST['quickie'] != '') {
					$act_qty = $_SESSION['cart']->get_quantity(xtc_get_uprid($quickie['products_id'], 1));
					if ($act_qty > MAX_PRODUCTS_QTY)
						$act_qty = MAX_PRODUCTS_QTY - 1;
					$_SESSION['cart']->add_cart($quickie['products_id'], $act_qty +1, 1);
					xtc_redirect(xtc_href_link($goto, xtc_get_all_get_params(array (
						'action'
					)), 'NONSSL'));
				} else {
					xtc_redirect(xtc_href_link(FILENAME_ADVANCED_SEARCH_RESULT, 'keywords=' . $quicky, 'NONSSL'));
				}
			}
			break;

			// performed by the 'buy now' button in product listings and review page
		case 'buy_now' :
			if (isset ($_GET['BUYproducts_id'])) {
				// check permission to view product

				$permission_query = xtc_db_query("SELECT group_permission_" . $_SESSION['customers_status']['customers_status_id'] . " as customer_group, products_fsk18 from " . TABLE_PRODUCTS . " where products_id='" . (int) $_GET['BUYproducts_id'] . "'");
				$permission = xtc_db_fetch_array($permission_query);

				// check for FSK18
				if ($permission['products_fsk18'] == '1' && $_SESSION['customers_status']['customers_fsk18'] == '1') {
					xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id'], 'NONSSL'));
				}
				if ($_SESSION['customers_status']['customers_fsk18_display'] == '0' && $permission['products_fsk18'] == '1') {
					xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id'], 'NONSSL'));
				}

				if (GROUP_CHECK == 'true') {

					if ($permission['customer_group'] != '1') {
						xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id']));
					}
				}
				if (xtc_has_product_attributes($_GET['BUYproducts_id'])) {
					xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['BUYproducts_id']));
				} else {
					if (isset ($_SESSION['cart'])) {
						$_SESSION['cart']->add_cart((int) $_GET['BUYproducts_id'], $_SESSION['cart']->get_quantity((int) $_GET['BUYproducts_id']) + 1);
					} else {
						xtc_redirect(xtc_href_link(FILENAME_DEFAULT));
					}
				}
			}
			xtc_redirect(xtc_href_link($goto, xtc_get_all_get_params(array (
				'action',
				'BUYproducts_id'
			))));
			break;
		case 'cust_order' :
			if (isset ($_SESSION['customer_id']) && isset ($_GET['pid'])) {
				if (xtc_has_product_attributes((int) $_GET['pid'])) {
					xtc_redirect(xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . (int) $_GET['pid']));
				} else {
					$_SESSION['cart']->add_cart((int) $_GET['pid'], $_SESSION['cart']->get_quantity((int) $_GET['pid']) + 1);
				}
			}
			xtc_redirect(xtc_href_link($goto, xtc_get_all_get_params($parameters)));
			break;
	}
}
?>