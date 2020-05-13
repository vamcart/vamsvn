<?php

require('includes/application_top.php');

$action = $_GET['action'];
$order_id = (int)$_GET['order_id'];

switch ($action) {
    case 'order' :
        duplicateOrder($order_id);
        header("Location: /checkout_success.php");
        die();
    case 'cart' :
        duplicateCart($order_id);
        header("Location: /shopping_cart.php");
        die();
}


function duplicateOrder($order_id) {

    $max_order_id = vam_db_query("SELECT orders_id FROM " . TABLE_ORDERS . " order by orders_id desc limit 1");
    $max_order_id = vam_db_fetch_array($max_order_id);
    $max_order_id = $max_order_id['orders_id'];
    $new_order_id = $max_order_id + 1;

    vam_db_query("CREATE TEMPORARY TABLE temp_table_orders AS SELECT * FROM " . TABLE_ORDERS . " WHERE orders_id=$order_id");
    vam_db_query("UPDATE temp_table_orders SET orders_status = 1, date_purchased = now(), last_modified=now(), orders_id=$new_order_id WHERE orders_id=$order_id");
    vam_db_query("INSERT INTO " . TABLE_ORDERS . " SELECT * FROM temp_table_orders");
    vam_db_query("DROP TEMPORARY TABLE temp_table_orders");


    vam_db_query("CREATE TEMPORARY TABLE temp_table_orders_total AS SELECT * FROM " . TABLE_ORDERS_TOTAL . " WHERE orders_id=$order_id");
    vam_db_query("UPDATE temp_table_orders_total SET orders_total_id=0, orders_id=$new_order_id WHERE orders_id=$order_id");
    vam_db_query("INSERT INTO " . TABLE_ORDERS_TOTAL . " SELECT * FROM temp_table_orders_total");
    vam_db_query("DROP TEMPORARY TABLE temp_table_orders_total");

    vam_db_query("CREATE TEMPORARY TABLE temp_table_orders_status_history AS SELECT * FROM " . TABLE_ORDERS_STATUS_HISTORY . " WHERE orders_id=$order_id");
    vam_db_query("UPDATE temp_table_orders_status_history SET orders_status_history_id=0, orders_id=$new_order_id WHERE orders_id=$order_id");
    $query = vam_db_query("SELECT * FROM temp_table_orders_status_history");
    while($result = vam_db_fetch_array($query)) {
       $values = implode(", ", array_map(function ($a) { return "'" . $a . "'"; }, array_values($result)));
       vam_db_query("INSERT INTO " . TABLE_ORDERS_STATUS_HISTORY . " VALUES(" . $values . ")");
    }
    vam_db_query("DROP TEMPORARY TABLE temp_table_orders_status_history");

    vam_db_query("CREATE TEMPORARY TABLE temp_table_orders_products AS SELECT * FROM " . TABLE_ORDERS_PRODUCTS . " WHERE orders_id=$order_id");
    $query = vam_db_query("SELECT * FROM temp_table_orders_products");
    $product_ids = [];
    while($result = vam_db_fetch_array($query)) {
        $product_ids[] = $result['orders_products_id'];
    }

    vam_db_query("UPDATE temp_table_orders_products SET orders_products_id=0, orders_id=$new_order_id WHERE orders_id=$order_id");
    $query = vam_db_query("SELECT * FROM temp_table_orders_products");

    $index = 0;
    while($result = vam_db_fetch_array($query)) {
        $values = implode(", ", array_map(function ($a) { return "'" . $a . "'"; }, array_values($result)));
        vam_db_query("INSERT INTO " . TABLE_ORDERS_PRODUCTS . " VALUES(" . $values . ")");
        $product_id = vam_db_insert_id();

        vam_db_query("CREATE TEMPORARY TABLE temp_table_orders_products_attributes AS SELECT * FROM " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " WHERE orders_products_id=" . $product_ids[$index]);
        vam_db_query("UPDATE temp_table_orders_products_attributes SET orders_products_attributes_id=0, orders_products_id=" . $product_id . " WHERE orders_products_id=" . $product_ids[$index]);
        $q = vam_db_query("SELECT * FROM temp_table_orders_products_attributes");
        while($res = vam_db_fetch_array($q)) {
           $values = implode(", ", array_map(function ($a) { return "'" . $a . "'"; }, array_values($res)));
           vam_db_query("INSERT INTO " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " VALUES(" . $values . ")");
        }
        vam_db_query("DROP TEMPORARY TABLE temp_table_orders_products_attributes");

        $index++;
    }

    vam_db_query("DROP TEMPORARY TABLE temp_table_orders_products");
}

function duplicateCart($order_id) {
    global $cart, $languages_id;

    $result = '';

    $query = vam_db_query("SELECT * FROM " . TABLE_ORDERS_PRODUCTS . " WHERE orders_id=$order_id");

    while ($ordered_product = vam_db_fetch_array($query)) {
        $attributes_query = vam_db_query("SELECT * FROM " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " WHERE orders_products_id=" . $ordered_product['orders_products_id']);
        $attributes = [];
        while ($attribute = vam_db_fetch_array($attributes_query)) {
            $option_id = vam_db_query("SELECT * FROM " . TABLE_PRODUCTS_OPTIONS . " WHERE products_options_name='" . $attribute['products_options'] . "'");
            $option_id = vam_db_fetch_array($option_id);
            $option = vam_db_query("SELECT * FROM " . TABLE_PRODUCTS_ATTRIBUTES . " as pa LEFT JOIN " . TABLE_PRODUCTS_OPTIONS_VALUES . " as pov ON pa.options_values_id=pov.products_options_values_id WHERE products_id =" . $ordered_product['products_id'] . " AND products_options_values_name='" . $attribute['products_options_values'] . "'");
            $option = vam_db_fetch_array($option);
            $attributes[$option_id['products_options_id']] = $option['products_options_values_id'];
        }
        $_SESSION['cart']->add_cart( (int) $ordered_product['products_id'], $_SESSION['cart']->get_quantity(vam_get_uprid($ordered_product['products_id'], $attributes)) 
            + vam_remove_non_numeric( (int) $ordered_product['products_quantity']), $attributes);
    }

}

?>