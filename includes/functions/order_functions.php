<?php

require('includes/application_top.php');

$action = $_GET['action'];
$order_id = $_GET['order_id'];

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
    $db = new mysqli(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE); 

    if ($db->connect_error) { die("Невозможно подключиться к БД: {$db->connect_error}"); }

    $max_order_id = $db->query("SELECT orders_id FROM " . TABLE_ORDERS . " order by orders_id desc limit 1")->fetch_assoc()['orders_id'];
    $new_order_id = $max_order_id + 1;

    $db->autocommit(FALSE);

    $db->query("CREATE TEMPORARY TABLE temp_table_orders AS SELECT * FROM " . TABLE_ORDERS . " WHERE orders_id=$order_id");
    $db->query("UPDATE temp_table_orders SET orders_status = 1, orders_id=$new_order_id WHERE orders_id=$order_id");
    $db->query("INSERT INTO " . TABLE_ORDERS . " SELECT * FROM temp_table_orders");
    $db->query("DROP TEMPORARY TABLE temp_table_orders");


    $db->query("CREATE TEMPORARY TABLE temp_table_orders_total AS SELECT * FROM " . TABLE_ORDERS_TOTAL . " WHERE orders_id=$order_id");
    $db->query("UPDATE temp_table_orders_total SET orders_total_id=0, orders_id=$new_order_id WHERE orders_id=$order_id");
    $db->query("INSERT INTO " . TABLE_ORDERS_TOTAL . " SELECT * FROM temp_table_orders_total");
    $db->query("DROP TEMPORARY TABLE temp_table_orders_total");

    $db->query("CREATE TEMPORARY TABLE temp_table_orders_status_history AS SELECT * FROM " . TABLE_ORDERS_STATUS_HISTORY . " WHERE orders_id=$order_id");
    $db->query("UPDATE temp_table_orders_status_history SET orders_status_history_id=0, orders_id=$new_order_id WHERE orders_id=$order_id");
    $query = $db->query("SELECT * FROM temp_table_orders_status_history");
    while($result = $query->fetch_assoc()) {
       $values = implode(", ", array_map(function ($a) { return "'" . $a . "'"; }, array_values($result)));
       $db->query("INSERT INTO " . TABLE_ORDERS_STATUS_HISTORY . " VALUES(" . $values . ")");
    }
    $db->query("DROP TEMPORARY TABLE temp_table_orders_status_history");

    $db->query("CREATE TEMPORARY TABLE temp_table_orders_products AS SELECT * FROM " . TABLE_ORDERS_PRODUCTS . " WHERE orders_id=$order_id");
    $query = $db->query("SELECT * FROM temp_table_orders_products");
    $product_ids = [];
    while($result = $query->fetch_assoc()) {
        $product_ids[] = $result['orders_products_id'];
    }

    $db->query("UPDATE temp_table_orders_products SET orders_products_id=0, orders_id=$new_order_id WHERE orders_id=$order_id");
    $query = $db->query("SELECT * FROM temp_table_orders_products");

    $index = 0;
    while($result = $query->fetch_assoc()) {
        $values = implode(", ", array_map(function ($a) { return "'" . $a . "'"; }, array_values($result)));
        $db->query("INSERT INTO " . TABLE_ORDERS_PRODUCTS . " VALUES(" . $values . ")");
        $product_id = $db->insert_id;

        $db->query("CREATE TEMPORARY TABLE temp_table_orders_products_attributes AS SELECT * FROM " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " WHERE orders_products_id=" . $product_ids[$index]);
        $db->query("UPDATE temp_table_orders_products_attributes SET orders_products_attributes_id=0, orders_products_id=" . $product_id . " WHERE orders_products_id=" . $product_ids[$index]);
        $q = $db->query("SELECT * FROM temp_table_orders_products_attributes");
        while($res = $q->fetch_assoc()) {
           $values = implode(", ", array_map(function ($a) { return "'" . $a . "'"; }, array_values($res)));
           $db->query("INSERT INTO " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " VALUES(" . $values . ")");
        }
        $db->query("DROP TEMPORARY TABLE temp_table_orders_products_attributes");

        $index++;
    }

    $db->query("DROP TEMPORARY TABLE temp_table_orders_products");

    $db->commit();

    $db->close();
}

function duplicateCart($order_id) {
    global $cart, $languages_id;

    $result = '';
    $db = new mysqli(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE); 

    if ($db->connect_error) { die("Невозможно подключиться к БД: {$db->connect_error}"); }

    $query = $db->query("SELECT * FROM " . TABLE_ORDERS_PRODUCTS . " WHERE orders_id=$order_id");

    while ($ordered_product = $query->fetch_assoc()) {
        $attributes_query = $db->query("SELECT * FROM " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " WHERE orders_products_id=" . $ordered_product['orders_products_id']);
        $attributes = [];
        while ($attribute = $attributes_query->fetch_assoc()) {
            $option_id = $db->query("SELECT * FROM " . TABLE_PRODUCTS_OPTIONS . " WHERE products_options_name='" . $attribute['products_options'] . "'")->fetch_assoc();
            $option = $db->query("SELECT * FROM " . TABLE_PRODUCTS_ATTRIBUTES . " as pa LEFT JOIN " . TABLE_PRODUCTS_OPTIONS_VALUES . " as pov ON pa.options_values_id=pov.products_options_values_id WHERE products_id =" . $ordered_product['products_id'] . " AND products_options_values_name='" . $attribute['products_options_values'] . "'")->fetch_assoc();
            $attributes[$option_id['products_options_id']] = $option['products_options_values_id'];
        }
        $_SESSION['cart']->add_cart( (int) $ordered_product['products_id'], $_SESSION['cart']->get_quantity(vam_get_uprid($ordered_product['products_id'], $attributes)) 
            + vam_remove_non_numeric( (int) $ordered_product['products_quantity']), $attributes);
    }

    $db->close();
}

?>