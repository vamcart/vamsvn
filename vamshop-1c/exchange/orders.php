<?php
//if (!defined('ABSPATH')) exit;

$lang = 1;
$_SESSION['language'] = 'russian';
$_SESSION['languages_id'] = 1;

function wc1c_orders_start_element_handler($is_full, $names, $depth, $name, $attrs) {
  global $wc1c_document;

  if (@$names[$depth - 1] == 'КоммерческаяИнформация' && $name == 'Документ') {
    $wc1c_document = array();
  }
  elseif (@$names[$depth - 1] == 'Документ' && $name == 'Контрагенты') {
    $wc1c_document['Контрагенты'] = array();
  }
  elseif (@$names[$depth - 1] == 'Контрагенты' && $name == 'Контрагент') {
    $wc1c_document['Контрагенты'][] = array();
  }
  elseif (@$names[$depth - 1] == 'Документ' && $name == 'Товары') {
    $wc1c_document['Товары'] = array();
  }
  elseif (@$names[$depth - 1] == 'Товары' && $name == 'Товар') {
    $wc1c_document['Товары'][] = array();
  }
  elseif (@$names[$depth - 1] == 'Товар' && $name == 'ЗначенияРеквизитов') {
    $i = count($wc1c_document['Товары']) - 1;
    $wc1c_document['Товары'][$i]['ЗначенияРеквизитов'] = array();
  }
  elseif (@$names[$depth - 2] == 'Товар' && @$names[$depth - 1] == 'ЗначенияРеквизитов' && $name == 'ЗначениеРеквизита') {
    $i = count($wc1c_document['Товары']) - 1;
    $wc1c_document['Товары'][$i]['ЗначенияРеквизитов'][] = array();
  }
  elseif (@$names[$depth - 1] == 'Товар' && $name == 'ХарактеристикиТовара') {
    $i = count($wc1c_document['Товары']) - 1;
    $wc1c_document['Товары'][$i]['ХарактеристикиТовара'] = array();
  }
  elseif (@$names[$depth - 2] == 'Товар' && @$names[$depth - 1] == 'ХарактеристикиТовара' && $name == 'ХарактеристикаТовара') {
    $i = count($wc1c_document['Товары']) - 1;
    $wc1c_document['Товары'][$i]['ХарактеристикиТовара'][] = array();
  }
  elseif (@$names[$depth - 1] == 'Документ' && $name == 'ЗначенияРеквизитов') {
    $wc1c_document['ЗначенияРеквизитов'] = array();
  }
  elseif (@$names[$depth - 1] == 'ЗначенияРеквизитов' && $name == 'ЗначениеРеквизита') {
    $wc1c_document['ЗначенияРеквизитов'][] = array();
  }
}

function wc1c_orders_character_data_handler($is_full, $names, $depth, $name, $data) {
  global $wc1c_document;

  if (@$names[$depth - 2] == 'КоммерческаяИнформация' && @$names[$depth - 1] == 'Документ' && !in_array($name, array('Контрагенты', 'Товары', 'ЗначенияРеквизитов'))) {
    @$wc1c_document[$name] .= $data;
  }
  elseif (@$names[$depth - 2] == 'Контрагенты' && @$names[$depth - 1] == 'Контрагент') {
    $i = count($wc1c_document['Контрагенты']) - 1;
    @$wc1c_document['Контрагенты'][$i][$name] .= $data;
  }
  elseif (@$names[$depth - 2] == 'Товары' && @$names[$depth - 1] == 'Товар' && !in_array($name, array('СтавкиНалогов', 'ЗначенияРеквизитов', 'ХарактеристикиТовара'))) {
    $i = count($wc1c_document['Товары']) - 1;
    @$wc1c_document['Товары'][$i][$name] .= $data;
  }
  elseif (@$names[$depth - 3] == 'Товар' && @$names[$depth - 2] == 'ЗначенияРеквизитов' && @$names[$depth - 1] == 'ЗначениеРеквизита') {
    $i = count($wc1c_document['Товары']) - 1;
    $j = count($wc1c_document['Товары'][$i]['ЗначенияРеквизитов']) - 1;
    @$wc1c_document['Товары'][$i]['ЗначенияРеквизитов'][$j][$name] .= $data;
  }
  elseif (@$names[$depth - 3] == 'Товар' && @$names[$depth - 2] == 'ХарактеристикиТовара' && @$names[$depth - 1] == 'ХарактеристикаТовара') {
    $i = count($wc1c_document['Товары']) - 1;
    $j = count($wc1c_document['Товары'][$i]['ХарактеристикиТовара']) - 1;
    @$wc1c_document['Товары'][$i]['ХарактеристикиТовара'][$j][$name] .= $data;
  }
  elseif (@$names[$depth - 3] == 'Документ' && @$names[$depth - 2] == 'ЗначенияРеквизитов' && @$names[$depth - 1] == 'ЗначениеРеквизита') {
    $i = count($wc1c_document['ЗначенияРеквизитов']) - 1;
    @$wc1c_document['ЗначенияРеквизитов'][$i][$name] .= $data;
  }
}

function wc1c_orders_end_element_handler($is_full, $names, $depth, $name) {
  global $wpdb, $wc1c_document;

  if (@$names[$depth - 1] == 'КоммерческаяИнформация' && $name == 'Документ') {
    wc1c_replace_document($wc1c_document);
  }
/*  elseif (!$depth && $name == 'КоммерческаяИнформация') {
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_%'");
    wc1c_check_wpdb_error();

    do_action('wc1c_post_orders', $is_full);
  }*/
}

function wc1c_replace_document_products($order, $document_products) {
  //echo var_dump($order);
  $line_items = $order->products;
  //echo var_dump($line_items);
  //echo var_dump($document_products);
  $line_item_ids = array();
  foreach ($document_products as $i => $document_product) {
	 // Get product id by name
	 $products_id_query = vam_db_query("select p.*, pd.* from ".TABLE_PRODUCTS_DESCRIPTION." p left join ".TABLE_PRODUCTS_DESCRIPTION." pd on pd.products_id = p.products_id where pd.products_name = '".vam_db_input($document_product['Наименование'])."' and pd.language_id = '".(int) $_SESSION['languages_id']."' order by pd.products_id DESC limit 1");
	 $products_id = vam_db_fetch_array($products_id_query);

	 //echo var_dump($products_id);
	   	
    $product_id = $products_id['products_id'];
    //echo var_dump($product_id);
    if (!$product_id) continue;

    $product = $products_id;
    
    if (!$product) wc1c_error("Failed to get product");
    
    //echo var_dump($document_products[$i]);

    $document_products[$i]['product'] = $product;

    //echo var_dump($document_products[$i]);
    
    $current_line_item_id = null;
    foreach ($line_items as $line_item_id => $line_item) {
      if ($line_item['id'] != $product['products_id']) continue;

      $current_line_item_id = $product['products_id'];
      break;
    }
    
    //echo var_dump($current_line_item_id);
    
    $document_products[$i]['line_item_id'] = $current_line_item_id;

    //echo var_dump($document_products[$i]);

    if ($current_line_item_id) $line_item_ids[] = $current_line_item_id;
  }

//echo var_dump($line_items);
//echo var_dump($line_items_ids);

  $old_line_item_ids = array_diff(array_keys($line_items), $line_item_ids);
  
//echo var_dump($old_line_item_ids);
  
  if ($old_line_item_ids) {
    //$order->remove_order_items('line_item');

    foreach ($document_products as $i => $document_product) {
      //$document_products[$i]['line_item_id'] = null;
    }
  }
  
  //echo var_dump($document_products);
  $i =0;

  foreach ($document_products as $document_product) {
  	
  //echo var_dump($document_product);
    	
    $quantity = isset($document_product['Количество']) ? wc1c_parse_decimal($document_product['Количество']) : 1;
    $coefficient = isset($document_product['Коэффициент']) ? wc1c_parse_decimal($document_product['Коэффициент']) : 1;
    $quantity *= $coefficient;

    if (!empty($document_product['Сумма'])) {
      $price = wc1c_parse_decimal(@$document_product['ЦенаЗаЕдиницу']);
      $total = wc1c_parse_decimal($document_product['Сумма']);
    }
    else {
      $price = wc1c_parse_decimal(@$document_product['ЦенаЗаЕдиницу']);
      $total = $price * $quantity;
    }

    $args = array(
      'totals' => array(
        'subtotal' => $total,
        'total' => $total,
      ),
    );

    if (!isset($document_product['product'])) continue;
    $product = $document_product['product'];

/*    if ($product->variation_id) {
      $attributes = $product->get_variation_attributes();
      $variation = array();
      foreach ($attributes as $attribute_key => $attribute_value) {
        $variation[urldecode($attribute_key)] = urldecode($attribute_value);
      }
      $args['variation'] = $variation;
    }*/

    $line_item_id = $document_product['line_item_id'];
    
    //echo var_dump($line_item_id);
    
    
    //echo var_dump($line_item_id);
    if (!$line_item_id) {
      //$line_item_id = $order->add_product($product, $quantity, $args);
      //if (!$line_item_id) wc1c_error("Failed to add product to the order");
      
      //echo var_dump($product);
      //echo var_dump($quantity);
      //echo var_dump($args);
      
        $sql_data_array = array('orders_id' => vam_db_prepare_input($order->info['id']),
                                'products_id' => vam_db_prepare_input($product['products_id']),
                                'products_name' => vam_db_prepare_input($product['products_name']),
                                'products_model' => vam_db_prepare_input($product['products_model']),
                                'products_price' => vam_db_prepare_input($price),
                                'final_price' => vam_db_prepare_input($total),
                                'allow_tax' => 1,
                                'products_quantity' => vam_db_prepare_input($quantity)
                                );
        vam_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);

//echo var_dump($sql_data_array);
              
    }
    else {
      $args['qty'] = $quantity;
      //$result = $order->update_product($line_item_id, $product, $args);
      //if (!$result) wc1c_error("Failed to update product in the order");
      
      //echo var_dump($product);
      //echo var_dump($quantity);
      //echo var_dump($args);
      
        $sql_data_array = array('orders_id' => vam_db_prepare_input($order->info['id']),
                                'products_id' => vam_db_prepare_input($product['products_id']),
                                'products_name' => vam_db_prepare_input($product['products_name']),
                                'products_model' => vam_db_prepare_input($product['products_model']),
                                'products_price' => vam_db_prepare_input($price),
                                'final_price' => vam_db_prepare_input($total),
                                'allow_tax' => 1,
                                'products_quantity' => vam_db_prepare_input($quantity)
                                );
			vam_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_id = \''.$order->info['id'].'\' and products_id = \''.$product['products_id'].'\'');

//echo var_dump($sql_data_array);
              
    }
  }


  $order_subtotal_query = vam_db_query("select final_price from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . vam_db_input($order->info['id']) . "'");
  //$order_subtotal = vam_db_fetch_array($order_subtotal_query);
  
  $order_products_sum = 0;
  while ($order_subtotal = vam_db_fetch_array($order_subtotal_query)) {
  	$order_products_sum += $order_subtotal['final_price'];
  }  
  
//echo var_dump($order_products_sum);


        $sql_data_array = array('orders_id' => vam_db_prepare_input($order->info['id']),
                                'text' => vam_db_prepare_input($order_products_sum-$order_subtotal['final_price']),
                                'value' => vam_db_prepare_input($order_products_sum-$order_subtotal['final_price'])
                                );

			//echo var_dump($sql_data_array);

			vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', 'orders_id = \''.$order->info['id'].'\' and class = \'ot_subtotal\'');
  
  
}

function wc1c_replace_document_services($order, $document_services) {
  //static $shipping_methods;
  
  //echo var_dump($order);
  //echo var_dump($document_services);

  $shipping_method_query = vam_db_query("select title, value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . vam_db_input($order->info['id']) . "' and class = 'ot_shipping'");
  $shipping_method = vam_db_fetch_array($shipping_method_query);
  
  //echo var_dump($shipping_method);


  $shipping_items = $shipping_method;

  //if ($shipping_items && !$document_services) {
    //$order->remove_order_items('shipping');
    //return;
  //}

  //if (!$shipping_methods) {
    //$shipping = @WC()->shipping;
    //$shipping->load_shipping_methods();
    //$shipping_methods = $shipping->get_shipping_methods();
  //}

  $shipping_cost_sum = 0;
  foreach ($document_services as $document_service) {
    //foreach ($shipping_methods as $shipping_method_id => $shipping_method) {
      //if ($document_service['Наименование'] != $shipping_method['title']) continue;

      $shipping_cost = wc1c_parse_decimal($document_service['Сумма']);
      $shipping_cost_sum += $shipping_cost;
      
      //echo var_dump($shipping_cost);

      //$method_title = isset($shipping_method->method_title) ? $shipping_method->method_title : '';
      //$args = array(
        //'method_id' => $shipping_method->id,
        //'method_title' => $method_title,
        //'cost' => $shipping_cost,
      //);

      //if (!$shipping_items) {
        //$shipping_rate = new WC_Shipping_Rate($args['method_id'], $args['method_title'], $args['method_title'], null, $args['method_id']);

        //$shipping_item_id = $order->add_shipping($shipping_rate);
        //if (!$shipping_item_id) wc1c_error("Failed to add shippin to the order");
      //}
      //else //{
        //$shipping_item_id = key($shipping_items);

        $sql_data_array = array('orders_id' => vam_db_prepare_input($order->info['id']),
                                'shipping_method' => vam_db_prepare_input(($document_service['Наименование'] != $shipping_method['title'] ? $document_service['Наименование'] : $shipping_method['title'])),
                                'shipping_class' => vam_db_prepare_input(($document_service['Наименование'] != $shipping_method['title'] ? $document_service['Наименование'] : $shipping_method['title']))
                                );
			vam_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id = \''.$order->info['id'].'\'');
			
			//echo var_dump($sql_data_array);

        $sql_data_array = array('orders_id' => vam_db_prepare_input($order->info['id']),
                                'title' => vam_db_prepare_input(($document_service['Наименование'] != $shipping_method['title'] ? $document_service['Наименование'] : $shipping_method['title'])),
                                'text' => vam_db_prepare_input($shipping_cost),
                                'value' => vam_db_prepare_input($shipping_cost)
                                );

			//echo var_dump($sql_data_array);

			vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', 'orders_id = \''.$order->info['id'].'\' and class = \'ot_shipping\'');

        //$products_total_query = vam_db_query("select title, value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . vam_db_input($order->info['id']) . "' and class = 'ot_subtotal'");
        //$products_total_method = vam_db_fetch_array($shipping_method_query);


        $sql_data_array = array('orders_id' => vam_db_prepare_input($order->info['id']),
                                'text' => vam_db_prepare_input($order->info['total']-$shipping_method['value']+$shipping_cost),
                                'value' => vam_db_prepare_input($order->info['total']-$shipping_method['value']+$shipping_cost)
                                );

			//echo var_dump($sql_data_array);

			vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', 'orders_id = \''.$order->info['id'].'\' and class = \'ot_total\'');


        //$result = $order->update_shipping($shipping_item_id, $args);
        //if (!$result) wc1c_error("Failed to add shippin to the order");
      //}

      break;
    //}
  }

  return $shipping_cost_sum;
}

function wc1c_woocommerce_new_order_data($order_data) {
  global $wc1c_document;

  $order_data['import_id'] = $wc1c_document['Номер'];

  return $order_data;
}
//add_filter('woocommerce_new_order_data', 'wc1c_woocommerce_new_order_data');

function wc1c_replace_document($document) {
  global $wpdb;
  require (DIR_WS_CLASSES.'order.php');

  if ($document['ХозОперация'] != "Заказ товара" || $document['Роль'] != "Продавец") return;

  $order = new order($document['Номер']);
  
  //echo var_dump($order);
  //echo var_dump($document['Номер']);
  
  if (!$order) {
    wc1c_error("Failed to get order");
  }
  else {
    // Заказ не оплачен, ставим статус по умолчанию Ожидает проверки на стороне VamShop
    $set_order_status = '1';
  	
    $is_paid = false;
    foreach ($document['ЗначенияРеквизитов'] as $requisite) {
      if (!in_array($requisite['Наименование'], array("Дата оплаты по 1С", "Дата отгрузки по 1С"))) continue;
        
      $is_paid = true;
      break;
    }
    // Заказ оплачен, ставим статус заказу Выполняется на стороне VamShop
    if ($is_paid) $set_order_status = '4';

    $is_passed = false;
    foreach ($document['ЗначенияРеквизитов'] as $requisite) {
      if ($requisite['Наименование'] != 'Проведен' || $requisite['Значение'] != 'true') continue;
        
      $is_passed = true;
      break;
    }
    // Заказ оплачен, ставим статус заказу Доставлен на стороне VamShop
    if ($is_passed) $set_order_status = '6';

    //$order = wc_update_order($args);
    //echo $set_order_status;
    
    $sql_data_array = array('orders_id' => vam_db_prepare_input($order->info['id']),
                            'orders_status' => vam_db_prepare_input($set_order_status)
                           );
                                
    //echo var_dump($sql_data_array);                                
                                
    vam_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id = \''.$order->info['id'].'\'');

    $sql_data_array = array('orders_id' => vam_db_prepare_input($order->info['id']),
                            'orders_status_id' => vam_db_prepare_input($set_order_status),
                            'date_added' => vam_db_prepare_input(date("Y-m-d H:i:s")),
                            'customer_notified' => 0
                           );
                                
    //echo var_dump($sql_data_array);                                
                                
    vam_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
    
    
    wc1c_check_wp_error($order);
  }

  $is_deleted = false;
  foreach ($document['ЗначенияРеквизитов'] as $requisite) {
    if ($requisite['Наименование'] != 'ПометкаУдаления' || $requisite['Значение'] != 'true') continue;
      
    $is_deleted = true;
    break;
  }

  //if ($is_deleted && $order->post_status != 'trash') {
    //wp_trash_post($order->id);
  //}
  //elseif (!$is_deleted && $order->post_status == 'trash') {
    //wp_untrash_post($order->id);
  //}

  $post_meta = array();
  if (isset($document['Валюта'])) $post_meta['_order_currency'] = $document['Валюта'];
  if (isset($document['Сумма'])) $post_meta['_order_total'] = wc1c_parse_decimal($document['Сумма']);

  $document_products = array();
  $document_services = array();
  if (isset($document['Товары'])) {
    foreach ($document['Товары'] as $i => $document_product) {
      foreach ($document_product['ЗначенияРеквизитов'] as $document_product_requisite) {
        if ($document_product_requisite['Наименование'] != 'ТипНоменклатуры') continue;

        if ($document_product_requisite['Значение'] == 'Услуга') {
          $document_services[] = $document_product;
        }
        else {
          $document_products[] = $document_product;
        }
        break;
      }
    }
  }

  wc1c_replace_document_products($order, $document_products);
  wc1c_replace_document_services($order, $document_services);

/*  $current_post_meta = get_post_meta($order->id);
  foreach ($current_post_meta as $meta_key => $meta_value) {
    $current_post_meta[$meta_key] = $meta_value[0];
  }
 
  foreach ($post_meta as $meta_key => $meta_value) {
    $current_meta_value = @$current_post_meta[$meta_key];
    if ($current_meta_value == $meta_value) continue;

    update_post_meta($order->id, $meta_key, $meta_value);
  }*/
}
