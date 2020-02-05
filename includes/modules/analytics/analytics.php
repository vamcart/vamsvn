<?php
/*
==========================================================
	Include Google Analystics (beta) module for osCommerce
  	Original by Clement Nicolaescu (http://www.osCoders.biz) 
  	Updated by Tomas Hesseling (www.Boxershorts.nl) & Mathieu Burgerhout (www.seo-for-osc.com)
	v. 2.0.0 - 2008/01/09
==========================================================	

--------------------------------------------------
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2003 osCommerce
--------------------------------------------------

  Released under the GNU General Public License
*/

// ############## Google Analytics - start ###############

// Get order id
    $orders_query = vam_db_query("select orders_id from " . TABLE_ORDERS . " where customers_id = '" . (int)$_SESSION['customer_id'] . "' order by date_purchased desc limit 1");
    $orders = vam_db_fetch_array($orders_query);
	$order_id = $orders['orders_id'];

// Get order info for Analytics "Transaction line" (affiliation, city, state, country, total, tax and shipping)

// Set value for  "affiliation"

	$analytics_affiliation = STORE_NAME;


// Get info for "city", "state", "country"
    $orders_query = vam_db_query("select customers_city, customers_state, customers_country from " . TABLE_ORDERS . " where orders_id = '" . $order_id . "' AND customers_id = '" . (int)$_SESSION['customer_id'] . "'");
    $orders = vam_db_fetch_array($orders_query);

    $totals_query = vam_db_query("select value, class from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' order by sort_order");
// Set values for "total", "tax" and "shipping"
    $analytics_total = '';
    $analytics_tax = '';
    $analytics_shipping = '';
    
     while ($totals = vam_db_fetch_array($totals_query)) {

        if ($totals['class'] == 'ot_total') {
            $analytics_total = $totals['value'];
            $total_flag = 'true';
        } else if ($totals['class'] == 'ot_tax') {
            $analytics_tax = $totals['value'];
            $tax_flag = 'true';
        } else if ($totals['class'] == 'ot_shipping') {
            $analytics_shipping = $totals['value'];
			{ if ($analytics_shipping === "0.0000") $analytics_shipping = ''; }
            $shipping_flag = 'true';
        }

     }


// Prepare the Analytics "Transaction line" string

	$transaction_string = '
	
  "transaction_id": "' . $order_id . '",
  "affiliation": "' . STORE_NAME . '",
  "value": ' . $analytics_total . ',
  "currency": "' . $order->info['currency'] . '",
  "tax": ' . (($analytics_tax > 0) ? 0 : 0) . ',
  "shipping": ' . $analytics_shipping . ',
	
	';

// Get products info for Analytics "Item lines"

	$item_string = '';
    $items_query = vam_db_query("select products_id, products_model, products_name, final_price, products_quantity from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $order_id . "' order by products_name");
    while ($items = vam_db_fetch_array($items_query)) {
		$category_query = vam_db_query("select p2c.categories_id, cd.categories_name from " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where p2c.products_id = '" . $items['products_id'] . "' AND cd.categories_id = p2c.categories_id AND cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
		$category = vam_db_fetch_array($category_query);
		
	  $item_string .=  
	  
  '{'."\n".'
	  
      "id": "' . htmlspecialchars($items['products_model']) . '",
      "name": "' . htmlspecialchars($items['products_name']) . '",
      "category": "' . htmlspecialchars($category['categories_name']) . '",
      "quantity": ' . $items['products_quantity'] . ',
      "price": \'' . $items['final_price'] . '\'
	  
  },'."\n";


    }

// ############## Google Analytics - end ###############

?>