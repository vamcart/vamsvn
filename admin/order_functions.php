<?php

require('includes/application_top.php');

$action = $_GET['action'];
$order_id = (int)$_GET['order_id'];

switch ($action) {
    case 'order' :
    
    $max_order_id = vam_db_query("SELECT orders_id FROM " . TABLE_ORDERS . " order by orders_id desc limit 1");
    $max_order_id = vam_db_fetch_array($max_order_id);
    $max_order_id = $max_order_id['orders_id'];
    $new_order_id = $max_order_id + 1;
        
        duplicateOrder($order_id);
        header("Location: admin/orders.php?oID=".$new_order_id."&action=edit");
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

?>