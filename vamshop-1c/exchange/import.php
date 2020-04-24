<?php
if (!defined(ENABLE_1C_EXCHANGE) && ENABLE_1C_EXCHANGE != 'true') exit('Модуль интеграции VamShop и 1С:Предприятие выключен. Подробная информация <a href="https://forum.vamshop.ru/topic/16769-%D0%B8%D0%BD%D1%82%D0%B5%D0%B3%D1%80%D0%B0%D1%86%D0%B8%D1%8F-vamshop-%D0%B8-1%D1%81%D0%BF%D1%80%D0%B5%D0%B4%D0%BF%D1%80%D0%B8%D1%8F%D1%82%D0%B8%D0%B5/" target="_blank"><u>здесь</u></a>.');

//echo 'test';
//exit("test");

//require_once ABSPATH . "wp-admin/includes/media.php";
//require_once ABSPATH . "wp-admin/includes/file.php";
//require_once ABSPATH . "wp-admin/includes/image.php";

if (!defined('WC1C_PRODUCT_DESCRIPTION_TO_CONTENT')) define('WC1C_PRODUCT_DESCRIPTION_TO_CONTENT', false);
if (!defined('WC1C_PREVENT_CLEAN')) define('WC1C_PREVENT_CLEAN', false);

function wc1c_import_start_element_handler($is_full, $names, $depth, $name, $attrs) {
  global $wc1c_groups, $wc1c_group_depth, $wc1c_group_order, $wc1c_property, $wc1c_property_order, $wc1c_requisite_properties, $wc1c_product;

  if (!$depth && $name != 'КоммерческаяИнформация') {
    wc1c_error("XML parser misbehavior.");
  }
  elseif (@$names[$depth - 1] == 'Классификатор' && $name == 'Группы') {
    $wc1c_groups = array();
    $wc1c_group_depth = -1;
    $wc1c_group_order = 1;
  }
  elseif (@$names[$depth - 1] == 'Группы' && $name == 'Группа') {
    $wc1c_group_depth++;
    $wc1c_groups[] = array('ИдРодителя' => @$wc1c_groups[$wc1c_group_depth - 1]['Ид']);
  }
  elseif (@$names[$depth - 1] == 'Группа' && $name == 'Группы') {
    $result = wc1c_replace_group($is_full, $wc1c_groups[$wc1c_group_depth], $wc1c_group_order, $wc1c_groups);
    if ($result) $wc1c_group_order++;

    $wc1c_groups[$wc1c_group_depth]['Группы'] = true;
  }
  elseif (@$names[$depth - 1] == 'Классификатор' && $name == 'Свойства') {
    $wc1c_property_order = 1;
    $wc1c_requisite_properties = array();
  }
  elseif (@$names[$depth - 1] == 'Свойства' && $name == 'Свойство') {
    $wc1c_property = array();
  }
  elseif (@$names[$depth - 1] == 'Свойство' && $name == 'ВариантыЗначений') {
    $wc1c_property['ВариантыЗначений'] = array();
  }
  elseif (@$names[$depth - 1] == 'ВариантыЗначений' && $name == 'Справочник') {
    $wc1c_property['ВариантыЗначений'][] = array();
  }
  elseif (@$names[$depth - 1] == 'Товары' && $name == 'Товар') {
    $wc1c_product = array(
      'ХарактеристикиТовара' => array(),
      'ЗначенияСвойств' => array(),
      'ЗначенияРеквизитов' => array(),
    );
  }
  elseif (@$names[$depth - 1] == 'Товар' && $name == 'Группы') {
    $wc1c_product['Группы'] = array();
  }
  elseif (@$names[$depth - 1] == 'Группы' && $name == 'Ид') {
    $wc1c_product['Группы'][] = '';
  }
  elseif (@$names[$depth - 1] == 'Товар' && $name == 'Картинка') {
    if (!isset($wc1c_product['Картинка'])) $wc1c_product['Картинка'] = array();
    $wc1c_product['Картинка'][] = '';
  }
  elseif (@$names[$depth - 1] == 'Товар' && $name == 'Изготовитель') {
    $wc1c_product['Изготовитель'] = array();
  }
  elseif (@$names[$depth - 1] == 'ХарактеристикиТовара' && $name == 'ХарактеристикаТовара') {
    $wc1c_product['ХарактеристикиТовара'][] = array();
  }
  elseif (@$names[$depth - 1] == 'ЗначенияСвойств' && $name == 'ЗначенияСвойства') {
    $wc1c_product['ЗначенияСвойств'][] = array();
  }
  elseif (@$names[$depth - 1] == 'ЗначенияСвойства' && $name == 'Значение') {
    $i = count($wc1c_product['ЗначенияСвойств']) - 1;
    if (!isset($wc1c_product['ЗначенияСвойств'][$i]['Значение'])) $wc1c_product['ЗначенияСвойств'][$i]['Значение'] = array();
    $wc1c_product['ЗначенияСвойств'][$i]['Значение'][] = '';
  }
  elseif (@$names[$depth - 1] == 'ЗначенияРеквизитов' && $name == 'ЗначениеРеквизита') {
    $wc1c_product['ЗначенияРеквизитов'][] = array();
  }
  elseif (@$names[$depth - 1] == 'ЗначениеРеквизита' && $name == 'Значение') {
    $i = count($wc1c_product['ЗначенияРеквизитов']) - 1;
    if (!isset($wc1c_product['ЗначенияРеквизитов'][$i]['Значение'])) $wc1c_product['ЗначенияРеквизитов'][$i]['Значение'] = array();
    $wc1c_product['ЗначенияРеквизитов'][$i]['Значение'][] = '';
  }
}

function wc1c_import_character_data_handler($is_full, $names, $depth, $name, $data) {
  global $wc1c_groups, $wc1c_group_depth, $wc1c_property, $wc1c_product;

  if (@$names[$depth - 2] == 'Группы' && @$names[$depth - 1] == 'Группа' && $name != 'Группы') {
    @$wc1c_groups[$wc1c_group_depth][$name] .= $data;
  }
  elseif (@$names[$depth - 2] == 'Свойства' && @$names[$depth - 1] == 'Свойство' && $name != 'ВариантыЗначений') {
    @$wc1c_property[$name] .= $data;
  }
  elseif (@$names[$depth - 2] == 'ХарактеристикиТовара' && @$names[$depth - 1] == 'ХарактеристикаТовара') {
    $i = count($wc1c_product['ХарактеристикиТовара']) - 1;
    @$wc1c_product['ХарактеристикиТовара'][$i][$name] .= $data;
  }
  elseif (@$names[$depth - 2] == 'ВариантыЗначений' && @$names[$depth - 1] == 'Справочник') {
    $i = count($wc1c_property['ВариантыЗначений']) - 1;
    @$wc1c_property['ВариантыЗначений'][$i][$name] .= $data;
  }
  elseif (@$names[$depth - 2] == 'Товары' && @$names[$depth - 1] == 'Товар' && !in_array($name, array('Группы', 'Картинка', 'Изготовитель', 'ХарактеристикиТовара', 'ЗначенияСвойств', 'СтавкиНалогов', 'ЗначенияРеквизитов'))) {
    @$wc1c_product[$name] .= $data;
  }
  elseif (@$names[$depth - 2] == 'БазоваяЕдиница' && @$names[$depth - 1] == 'Пересчет') {
    @$wc1c_product['Пересчет'][$name] .= $data;
  }
  elseif (@$names[$depth - 2] == 'Товар' && @$names[$depth - 1] == 'Группы' && $name == 'Ид') {
    $i = count($wc1c_product['Группы']) - 1;
    @$wc1c_product['Группы'][$i] .= $data;
  }
  elseif (@$names[$depth - 2] == 'Товары' && @$names[$depth - 1] == 'Товар' && $name == 'Картинка') {
    $i = count($wc1c_product['Картинка']) - 1;
    @$wc1c_product['Картинка'][$i] .= $data;
  }
  elseif (@$names[$depth - 2] == 'Товар' && @$names[$depth - 1] == 'Изготовитель') {
    @$wc1c_product['Изготовитель'][$name] .= $data;
  }
  elseif (@$names[$depth - 2] == 'ЗначенияСвойств' && @$names[$depth - 1] == 'ЗначенияСвойства') {
    $i = count($wc1c_product['ЗначенияСвойств']) - 1;
    if ($name != 'Значение') {
      @$wc1c_product['ЗначенияСвойств'][$i][$name] .= $data;
    }
    else {
      $j = count($wc1c_product['ЗначенияСвойств'][$i]['Значение']) - 1;
      @$wc1c_product['ЗначенияСвойств'][$i]['Значение'][$j] .= $data;
    }
  }
  elseif (@$names[$depth - 2] == 'ЗначенияРеквизитов' && @$names[$depth - 1] == 'ЗначениеРеквизита') {
    $i = count($wc1c_product['ЗначенияРеквизитов']) - 1;
    if ($name != 'Значение') {
      @$wc1c_product['ЗначенияРеквизитов'][$i][$name] .= $data;
    }
    else {
      $j = count($wc1c_product['ЗначенияРеквизитов'][$i]['Значение']) - 1;
      @$wc1c_product['ЗначенияРеквизитов'][$i]['Значение'][$j] .= $data;
    }
  }
}

function wc1c_import_end_element_handler($is_full, $names, $depth, $name) {
  global $wpdb, $wc1c_groups, $wc1c_group_depth, $wc1c_group_order, $wc1c_property, $wc1c_property_order, $wc1c_requisite_properties, $wc1c_product, $wc1c_subproducts;

  if (@$names[$depth - 1] == 'Группы' && $name == 'Группа') {
    if (empty($wc1c_groups[$wc1c_group_depth]['Группы'])) {
      $result = wc1c_replace_group($is_full, $wc1c_groups[$wc1c_group_depth], $wc1c_group_order, $wc1c_groups);
      if ($result) $wc1c_group_order++;
    }

    array_pop($wc1c_groups);
    $wc1c_group_depth--;
  }
  if (@$names[$depth - 1] == 'Классификатор' && $name == 'Группы') {
    wc1c_clean_woocommerce_categories($is_full);
  }
  elseif (@$names[$depth - 1] == 'Свойства' && $name == 'Свойство') {
    $result = wc1c_replace_property($is_full, $wc1c_property, $wc1c_property_order);
    if ($result) {
      $attribute_taxonomy = $result;
      $wc1c_property_order++;

      wc1c_clean_woocommerce_attribute_options($is_full, $attribute_taxonomy);
    }
    else {
      $wc1c_requisite_properties[$wc1c_property['Ид']] = $wc1c_property;
    }
  }
  elseif (@$names[$depth - 1] == 'Классификатор' && $name == 'Свойства') {
    wc1c_clean_woocommerce_attributes($is_full);

    delete_transient('wc_attribute_taxonomies');
  }
  elseif (@$names[$depth - 1] == 'Товары' && $name == 'Товар') {
    if ($wc1c_requisite_properties) {
      foreach ($wc1c_product['ЗначенияСвойств'] as $product_property) {
        if (!array_key_exists($product_property['Ид'], $wc1c_requisite_properties)) continue;

        $property = $wc1c_requisite_properties[$product_property['Ид']];
        $wc1c_product['ЗначенияРеквизитов'][] = array(
          'Наименование' => $property['Наименование'],
          'Значение' => $product_property['Значение'],
        );
      }
    }

    if (strpos($wc1c_product['Ид'], '#') === false || WC1C_DISABLE_VARIATIONS) {
      $guid = $wc1c_product['Ид'];
      wc1c_replace_product($is_full, $guid, $wc1c_product);
      $_post_id = wc1c_replace_product($is_full, $guid, $wc1c_product);
      if ($_post_id) {
        //$_product = wc_get_product($_post_id);
        //$_qnty = $_product->get_stock_quantity();
        //echo var_dump($_post_id);
        $get_stock_quantity_by_id_query = vam_db_query("select products_quantity from " . TABLE_PRODUCTS . " where products_id = '" . vam_db_input($_post_id) . "'");      
        $get_stock_quantity_by_id = vam_db_fetch_array($get_stock_quantity_by_id_query);
        $_qnty = $get_stock_quantity_by_id['products_quantity'];
        if (!$_qnty) {
          //update_post_meta($_post_id, '_stock_status', WC1C_OUTOFSTOCK_STATUS);
				$sql_data_array = array (
				'products_quantity' => $_qnty 
		       );
		
				vam_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', 'products_id = \''.$_post_id.'\'');
				          
        }
        //unset($_product, $_qnty);
      }
      unset($_post_id);
    }
    else {
      $guid = $wc1c_product['Ид'];
      list($product_guid, ) = explode('#', $guid, 2);

      if (empty($wc1c_subproducts) || $wc1c_subproducts[0]['product_guid'] != $product_guid) {
        if ($wc1c_subproducts) wc1c_replace_subproducts($is_full, $wc1c_subproducts);
        $wc1c_subproducts = array();
      }

      $wc1c_subproducts[] = array(
        'guid' => $wc1c_product['Ид'],
        'product_guid' => $product_guid,
        'characteristics' => $wc1c_product['ХарактеристикиТовара'],
        'is_full' => $is_full,
        'product' => $wc1c_product,
      );
    }
  }
  elseif (@$names[$depth - 1] == 'Каталог' && $name == 'Товары') {
    if ($wc1c_subproducts) wc1c_replace_subproducts($is_full, $wc1c_subproducts);

    wc1c_clean_products($is_full);
    wc1c_clean_product_terms();
  }
  elseif (!$depth && $name == 'КоммерческаяИнформация') {
    //$wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_%'");
    //wc1c_check_wpdb_error();

    //do_action('wc1c_post_import', $is_full);
  }
}

function wc1c_term_id_by_meta($key, $value) {
  //global $wpdb;

  //echo $key;
  //echo "<br />";
  $value = str_replace("product_cat::","",$value);
  //echo $value;
  //exit;

  if ($value === null) return;

  //$cache_key = "wc1c_term_id_by_meta-$key-$value";
  //$term_id = wp_cache_get($cache_key);
  //echo var_dump($term_id);
  //exit;
  
  $term_id = false;
  
  if ($term_id === false) {
  	
  	$get_categories_id_by_guid_query = vam_db_query("select categories_id from " . TABLE_CATEGORIES . " where guid = '" . vam_db_input($value) . "'");
  	$get_categories_id_by_guid = vam_db_fetch_array($get_categories_id_by_guid_query);
  	
    //$term_id = $wpdb->get_var($wpdb->prepare("SELECT tm.term_id FROM $wpdb->termmeta tm JOIN $wpdb->terms t ON tm.term_id = t.term_id WHERE meta_key = %s AND meta_value = %s", $key, $value));
    //wc1c_check_wpdb_error();

    //if ($term_id) wp_cache_set($cache_key, $term_id);
    
    if (vam_db_num_rows($get_categories_id_by_guid_query, true) > 0) $term_id = $get_categories_id_by_guid['categories_id'];
    
  //echo var_dump($term_id);
  
  //exit;

  }

  return $term_id;
}

function wc1c_unique_term_name($name, $taxonomy, $parent = null) {
  global $wpdb;

  $name = htmlspecialchars($name);

  //$sql = "SELECT * FROM $wpdb->terms NATURAL JOIN $wpdb->term_taxonomy WHERE name = %s AND taxonomy = %s AND parent = %d LIMIT 1";
  //if (!$parent) $parent = 0;
  //$term = $wpdb->get_row($wpdb->prepare($sql, $name, $taxonomy, $parent));
  //echo $name.$taxonomy.$parent;
  //exit;
  //wc1c_check_wpdb_error();
  //if (!$term) return $name;

  //$number = 2;
  //while (true) {
    //$new_name = "$name ($number)";
    //$number++;

    //$term = $wpdb->get_row($wpdb->prepare($sql, $new_name, $taxonomy, $parent));
    //wc1c_check_wpdb_error();
    //if (!$term) return $new_name;
  //}
   return $name;
}

function wc1c_unique_term_slug($slug, $taxonomy, $parent = null) {
  //global $wpdb;
  require_once(DIR_FS_INC . 'vam_make_alias.inc.php');
  
  $slug = make_alias($slug);
  
  return $slug;
  //echo $slug;
  //exit;

  //while (true) {
    //$sanitized_slug = sanitize_title($slug);
    //if (strlen($sanitized_slug) <= 195) break;

    //$slug = mb_substr($slug, 0, mb_strlen($slug) - 3);
  //}

  //$sql = "SELECT * FROM $wpdb->terms NATURAL JOIN $wpdb->term_taxonomy WHERE slug = %s AND taxonomy = %s AND parent = %d LIMIT 1";
  //if (!$parent) $parent = 0;
  //$term = $wpdb->get_row($wpdb->prepare($sql, $sanitized_slug, $taxonomy, $parent));
  //wc1c_check_wpdb_error();
  //if (!$term) return $slug;

  //$number = 2;
  //while (true) {
    //$new_slug = "$slug-$number";
    //$new_sanitized_slug = "$sanitized_slug-$number";
    //$number++;

    //$term = $wpdb->get_row($wpdb->prepare($sql, $new_sanitized_slug, $taxonomy, $parent));
    //wc1c_check_wpdb_error();
    //if (!$term) return $new_slug;
  //}
}

function wc1c_wp_unique_term_slug($slug, $term, $original_slug) {
  if (mb_strlen($slug) <= 200) return $slug;

  do {
    $slug = urldecode($slug);
    $slug = mb_substr($slug, 0, mb_strlen($slug) - 1);
    $slug = urlencode($slug);
    $slug = wp_unique_term_slug($slug, $term);
  }
  while (mb_strlen($slug) > 200);

  return $slug;
}
//add_filter('wp_unique_term_slug', 'wc1c_wp_unique_term_slug', 10, 3);

function wc1c_replace_term($is_full, $guid, $parent_guid, $name, $taxonomy, $order, $use_guid_as_slug = false) {
  global $wpdb;
  
  //echo var_dump($guid);
  //echo "<br />";
  //echo var_dump($parent_guid);
  //exit;

  //$term_id = wc1c_term_id_by_meta('wc1c_guid', "$taxonomy::$guid");
  $term_id = $guid;

  	$get_category_info_query = vam_db_query("select
                                      c.*,
                                      cd.* from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
                                      where c.guid = '".$term_id."'
                                      and cd.language_id = '".(int) $_SESSION['languages_id']."'");
  	$get_category_info = vam_db_fetch_array($get_category_info_query);

  	if (vam_db_num_rows($get_category_info_query) > 0) $term = $get_category_info;
  	
  	//echo var_dump($term);
  	//exit;
  	//$parent_id = false;
  
    $parent = $parent_guid ? wc1c_term_id_by_meta('wc1c_guid', $parent_guid) : null;
  	//else {
  	//$parent = null;
  	//}

  //$parent = $parent_guid ? $parent_id : null;
  
  //echo var_dump($term_id);
  //echo "<br />";
  //echo var_dump($term);
  //echo "<br />";
  //echo "<br />";
  //echo "<br />";
  //echo var_dump($parent);
  //echo "<br />";
  //echo "<br />";
  //echo "<br />";
  //exit;
  
  //$term = false;

  if (!$term_id || !$term) {
  	
  	
  //echo var_dump($guid);
  //echo "<br />";
  //echo var_dump($parent_guid);
  //echo "<br />";
  //echo var_dump($parent);
    	
  	//echo 'test';
  	//exit;
    $name = wc1c_unique_term_name($name, $taxonomy, $parent);
    $slug = wc1c_unique_term_slug($name, $taxonomy, $parent);
    //$args = array(
      //'slug' => $slug,
      //'parent' => $parent,
    //);
  //echo var_dump($name);
  //echo "<br />";
  //echo var_dump($taxonomy);
  //echo "<br />";
  //echo var_dump($parent);
  //echo "<br />";
  //echo var_dump($slug);
  //test();
    //exit;
    //if ($use_guid_as_slug) $args['slug'] = $guid;
    
    //$result = wp_insert_term($name, $taxonomy, $args);
    //wc1c_check_wpdb_error();
    //wc1c_check_wp_error($result);

    //$term_id = $result['term_id'];
    //update_term_meta($term_id, 'wc1c_guid', "$taxonomy::$guid");
    
		$sql_data_array = array (
		'categories_status' => 1, 
		'products_sorting' => vam_db_prepare_input("p.products_sort"), 
		'products_sorting2' => vam_db_prepare_input("ASC"), 
		'categories_template' => vam_db_prepare_input("default"), 
		'date_added' => vam_db_prepare_input(date("Y-m-d H:i:s")),
		'last_modified' => vam_db_prepare_input(date("Y-m-d H:i:s")),
		'listing_template' => vam_db_prepare_input("default"), 
		'parent_id' => vam_db_prepare_input($parent), 
		'guid' => $guid,
		'categories_url' => $slug,
		'yml_bid' => 0,
		'yml_cbid' => 0,
		'icon' => vam_db_prepare_input("fa fa-chevron-right")
       );

		vam_db_perform(TABLE_CATEGORIES, $sql_data_array);
		$categories_id = vam_db_insert_id();

		$sql_data_array = array (
		'language_id' => vam_db_prepare_input($_SESSION['languages_id']), 
		'categories_id' => $categories_id,
		'categories_name' => vam_db_prepare_input($name) 
		);

		vam_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array);

      //echo "new:";				    
		//echo $guid.'::'.$parent.'::'.$parent_guid.'<br />';
		
    $is_added = true;
  }

  if (empty($is_added)) {
    if (trim($name) != $term['categories_name']) $name = wc1c_unique_term_name($name, $taxonomy, $parent);
    //$parent = $parent_guid ? wc1c_term_id_by_meta('wc1c_guid', "$taxonomy::$parent_guid") : null;
    //$args = array(
      //'name' => $name,
      //'parent' => $parent,
    //);

  //echo var_dump($name);
  //echo var_dump($parent);
  //echo var_dump($term_id);
  //test1();

    //$result = wp_update_term($term_id, $taxonomy, $args);
    //wc1c_check_wp_error($result);

    $parent = $parent_guid ? wc1c_term_id_by_meta('wc1c_guid', $parent_guid) : null;
  	//else {
  	//$parent = null;
  	//}

		$sql_data_array = array (
		'categories_status' => 1, 
		'products_sorting' => vam_db_prepare_input("p.products_sort"), 
		'products_sorting2' => vam_db_prepare_input("ASC"), 
		'categories_template' => vam_db_prepare_input("default"), 
		'date_added' => vam_db_prepare_input(date("Y-m-d H:i:s")),
		'last_modified' => vam_db_prepare_input(date("Y-m-d H:i:s")),
		'listing_template' => vam_db_prepare_input("default"), 
		'parent_id' => vam_db_prepare_input($parent), 
		'guid' => $guid,
		'categories_url' => $slug,
		'yml_bid' => 0,
		'yml_cbid' => 0,
		'icon' => vam_db_prepare_input("fa fa-chevron-right")
       );

		vam_db_perform(TABLE_CATEGORIES, $sql_data_array, 'update', 'guid = \''.$guid.'\'');

		$get_categories_id_by_guid_query = vam_db_query("select categories_id from " . TABLE_CATEGORIES . " where guid = '" . vam_db_input($guid) . "'");
		$get_categories_id_by_guid = vam_db_fetch_array($get_categories_id_by_guid_query);
  	
		$sql_data_array = array (
		'language_id' => vam_db_prepare_input($_SESSION['languages_id']), 
		'categories_id' => $get_categories_id_by_guid['categories_id'],
		'categories_name' => vam_db_prepare_input($name) 
		);
		
		//echo var_dump($name);
		//echo var_dump($get_categories_id_by_guid['categories_id']);
		//exit("test");

		vam_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array, 'update', 'categories_id = \''.$get_categories_id_by_guid['categories_id'].'\'');

      //echo "update:";				    
		//echo $guid.'::'.$parent.'::'.$parent_guid.'<br />';

  }

  //if ($is_full) wc_set_term_order($term_id, $order, $taxonomy);

  //update_term_meta($term_id, 'wc1c_timestamp', WC1C_TIMESTAMP);
}

function wc1c_replace_group($is_full, $group, $order, $groups) {
  $parent_groups = array_slice($groups, 0, -1);
  //$group = apply_filters('wc1c_import_group_xml', $group, $parent_groups, $is_full);
  if (!$group) return;

  $group_name = isset($group['Наименование']) ? $group['Наименование'] : $group['Ид'];
  wc1c_replace_term($is_full, $group['Ид'], $group['ИдРодителя'], $group_name, 'product_cat', $order);

  return true;
}

function wc1c_unique_woocommerce_attribute_name($attribute_label) {
  global $wpdb;

  $attribute_name = wc_sanitize_taxonomy_name($attribute_label);
  $max_length = 32 - strlen('pa_') - strlen('-00');
  while (strlen($attribute_name) > $max_length) {
    $attribute_name = mb_substr($attribute_name, 0, mb_strlen($attribute_name) - 1);
  }

  $sql = "SELECT * FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = %s";
  $attribute = $wpdb->get_row($wpdb->prepare($sql, $attribute_name));
  wc1c_check_wpdb_error();
  if (!$attribute) return $attribute_name;

  $number = 2;
  while (true) {
    $new_attribute_name = "$attribute_name-$number";
    $number++;

    $attribute = $wpdb->get_row($wpdb->prepare($sql, $new_attribute_name));
    if (!$attribute) return $new_attribute_name;
  }
}

function wc1c_replace_woocommerce_attribute($is_full, $guid, $attribute_label, $attribute_type, $order, $preserve_fields) {
  global $wpdb;

  $guids = get_option('wc1c_guid_attributes', array());
  $attribute_id = @$guids[$guid];

  if ($attribute_id) {
    $attribute_id = $wpdb->get_var($wpdb->prepare("SELECT attribute_id FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_id = %d", $attribute_id));
    wc1c_check_wpdb_error();
  }

  $data = compact('attribute_label', 'attribute_type');

  if (!$attribute_id) {
    $attribute_name = wc1c_unique_woocommerce_attribute_name($attribute_label);
    $data = array_merge($data, array(
      'attribute_name' => $attribute_name,
      'attribute_orderby' => 'menu_order',
    ));
    $wpdb->insert("{$wpdb->prefix}woocommerce_attribute_taxonomies", $data);
    wc1c_check_wpdb_error();

    $attribute_id = $wpdb->insert_id;
    $is_added = true;

    $guids[$guid] = $attribute_id;
    update_option('wc1c_guid_attributes', $guids);
  }

  if (empty($is_added)) {
    if (in_array('label', $preserve_fields)) unset($data['attribute_label']);
    if (in_array('type', $preserve_fields)) unset($data['attribute_type']);

    $wpdb->update("{$wpdb->prefix}woocommerce_attribute_taxonomies", $data, compact('attribute_id'));
    wc1c_check_wpdb_error();
  }

  if ($is_full) {
    $orders = get_option('wc1c_order_attributes', array());
    $order_index = array_search($attribute_id, $orders) or 0;
    if ($order_index !== false) unset($orders[$order_index]);
    array_splice($orders, $order, 0, $attribute_id);
    update_option('wc1c_order_attributes', $orders);
  }

  $timestamps = get_option('wc1c_timestamp_attributes', array());
  $timestamps[$guid] = WC1C_TIMESTAMP;
  update_option('wc1c_timestamp_attributes', $timestamps);

  return $attribute_id;
}

function wc1c_replace_property_option($property_option, $attribute_taxonomy, $order) {
  if (!isset($property_option['ИдЗначения'], $property_option['Значение'])) return;

  wc1c_replace_term(true, $property_option['ИдЗначения'], null, $property_option['Значение'], $attribute_taxonomy, $order, true);
}

function wc1c_replace_property($is_full, $property, $order) {
  $property = apply_filters('wc1c_import_property_xml', $property, $is_full);
  if (!$property) return;

  $preserve_fields = apply_filters('wc1c_import_preserve_property_fields', array(), $property, $is_full);

  $attribute_name = !empty($property['Наименование']) ? $property['Наименование'] : $property['Ид'];
  $attribute_type = (empty($property['ТипЗначений']) || $property['ТипЗначений'] == 'Справочник' || defined('WC1C_MULTIPLE_VALUES_DELIMETER')) ? 'select' : 'text';
  $attribute_id = wc1c_replace_woocommerce_attribute($is_full, $property['Ид'], $attribute_name, $attribute_type, $order, $preserve_fields);

  $attribute = wc1c_woocommerce_attribute_by_id($attribute_id);
  if (!$attribute) wc1c_error("Failed to get attribute");

  register_taxonomy($attribute['taxonomy'], null);

  if ($attribute_type == 'select' && !empty($property['ВариантыЗначений'])) {
    foreach ($property['ВариантыЗначений'] as $i => $property_option) {
      wc1c_replace_property_option($property_option, $attribute['taxonomy'], $i + 1);
    }
  }

  return $attribute['taxonomy'];
}

function wc1c_replace_post($guid, $post_type, $is_deleted, $is_draft, $post_title, $post_name, $post_excerpt, $post_content, $post_meta, $category_taxonomy, $category_guids, $preserve_fields) {
  $post_id = wc1c_post_id_by_meta('_wc1c_guid', $guid);
  
  //echo var_dump($post_id);
  //echo var_dump($post_excerpt);
  //echo var_dump($post_meta);
  //echo var_dump($post_title);
  //echo var_dump($post_name);
  //exit;

  if (!$post_excerpt) $post_excerpt = '';
  if (WC1C_PRODUCT_DESCRIPTION_TO_CONTENT) {
    $post_content = $post_excerpt;
    $post_excerpt = '';
  }

//echo var_dump($post_excerpt);
//echo var_dump($post_content);
//exit;


  $args = compact('post_type', 'post_title', 'post_excerpt', 'post_content');

//echo var_dump($args);
//exit;
    
  if (!$post_id) {
    $args = array_merge($args, array(
      'products_name' => $post_name,
      'products_status' => $is_draft ? '0' : '1',
    ));
    
    //echo var_dump($args);
    //exit;
    
    //$post_id = wp_insert_post($args, true);

		$sql_data_array = array (
		'guid' => vam_db_prepare_input($guid), 
		'products_model' => vam_db_prepare_input($post_meta['_sku']), 
		'products_weight' => vam_db_prepare_input($post_meta['products_weight']), 
		'products_width' => vam_db_prepare_input($post_meta['products_width']), 
		'products_height' => vam_db_prepare_input($post_meta['products_height']), 
		'products_length' => vam_db_prepare_input($post_meta['products_lengt']), 
		'products_volume' => vam_db_prepare_input($post_meta['products_width']*$post_meta['products_height']*$post_meta['products_length']/1000000), 
		'products_status' => vam_db_prepare_input($args['products_status']) 
       );

		vam_db_perform(TABLE_PRODUCTS, $sql_data_array);
		$products_id = vam_db_insert_id();

		$sql_data_array = array (
		'language_id' => vam_db_prepare_input($_SESSION['languages_id']), 
		'products_id' => $products_id,
		'products_name' => vam_db_prepare_input($args['products_name']), 
		'products_short_description' => vam_db_prepare_input($args['post_excerpt']), 
		'products_description' => vam_db_prepare_input($args['post_excerpt']) 
		);

		vam_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);

//echo var_dump($post_id);

    wc1c_check_wpdb_error();
    wc1c_check_wp_error($post_id);

    $is_added = true;
  }
  else {
    $is_added = false;
  }
  
  //echo var_dump($post_id);
  
  	$get_product_info_query = vam_db_query("select
                                      p.*,
                                      pd.* from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd
                                      where p.guid = '".$guid."'
                                      and pd.language_id = '".(int) $_SESSION['languages_id']."'");
  	$get_product_info = vam_db_fetch_array($get_product_info_query);

  	if (vam_db_num_rows($get_product_info_query) > 0) $post = $get_product_info;
  
//echo var_dump($post);

  //$post = get_post($post_id);
  if (!$post) wc1c_error("Failed to get post");

  if (!$is_added) {
    if (in_array('title', $preserve_fields)) unset($args['post_title']);
    if (in_array('excerpt', $preserve_fields)) unset($args['post_excerpt']);
    if (in_array('body', $preserve_fields)) unset($args['post_content']);
    
    //echo var_dump($args);

    foreach ($args as $key => $value) {
      if ($post[$key] == $value) continue;

      $is_changed = true;
      break;
    }
    
    //echo var_dump($is_changed);

    if (!empty($is_changed)) {
      $post_date = date("Y-m-d H:i:s");
      //$args = array_merge($args, array(
        //'ID' => $post_id,
        //'post_date' => $post_date,
        //'post_date_gmt' => get_gmt_from_date($post_date),
      //));
      //$post_id = wp_update_post($args, true);
      
		$sql_data_array = array (
		'products_last_modified' => $post_date, 
       );

		vam_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', 'products_id = \''.$post_id.'\'');
      
      wc1c_check_wp_error($post_id);
    }
  }

//echo var_dump($post);

  if ($is_deleted && $post['products_status'] != '0') {
    //wp_trash_post($post_id);
		$sql_data_array = array (
		'products_status' => 0, 
       );
		vam_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', 'products_id = \''.$post_id.'\'');
  }
  elseif (!$is_deleted && $post->post_status == '0') {
    //wp_untrash_post($post_id);
		$sql_data_array = array (
		'products_status' => 1, 
       );
		vam_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', 'products_id = \''.$post_id.'\'');
  }

  $current_post_meta = $post;
  //echo var_dump($current_post_meta);
  //echo var_dump($post_name);
  
  foreach ($current_post_meta as $meta_key => $meta_value) {
    $current_post_meta[$meta_key] = $meta_value[0];
  }

  foreach ($post_meta as $meta_key => $meta_value) {
  	//echo $meta_key.$meta_value;
  	//echo $post_meta['products_weight'].$post_meta['products_width'];
  	//exit;
  	//echo 'test';
  	//echo 'test';
    $current_meta_value = @$current_post_meta[$meta_key];
    if ($current_meta_value == $meta_value) continue;

		$sql_data_array = array (
		'products_model' => vam_db_prepare_input($post_meta['_sku']), 
		'products_weight' => vam_db_prepare_input($post_meta['products_weight']), 
		'products_width' => vam_db_prepare_input($post_meta['products_width']), 
		'products_height' => vam_db_prepare_input($post_meta['products_height']), 
		'products_length' => vam_db_prepare_input($post_meta['products_length']), 
		'products_volume' => vam_db_prepare_input($post_meta['products_width']*$post_meta['products_height']*$post_meta['products_length']/1000000) 
       );

		vam_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', 'products_id = \''.$post_id.'\'');
		
		$sql_data_array = array (
		'products_id' => $post_id, 
		'products_name' => $post_name, 
		'products_description' => $post_excerpt, 
		'products_short_description' => $post_excerpt, 
      );
		vam_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array, 'update', 'products_id = \''.$post_id.'\'');
		
				
//echo $meta_key;		
//echo "<br />";		
//echo $meta_value;		
		
    //update_post_meta($post_id, $meta_key, $meta_value);
  }

  if (!in_array('categories', $preserve_fields)) {
    //$current_category_ids = wp_get_post_terms($post_id, $category_taxonomy, "fields=ids");
    //wc1c_check_wp_error($current_category_ids);
    
    $get_categories_id_by_guid_query = vam_db_query("select categories_id from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . vam_db_input($post_id) . "'");      
    $get_categories_id_by_guid = vam_db_fetch_array($get_categories_id_by_guid_query);
    
    $current_category_ids[0] = $get_categories_id_by_guid['categories_id'];
  	    
    //echo var_dump($current_category_ids);

    $category_ids = array();
    if ($category_guids) {
      foreach ($category_guids as $category_guid) {
        $category_id = wc1c_term_id_by_meta('wc1c_guid', "product_cat::$category_guid");
        if ($category_id) $category_ids[] = $category_id;
      }
    }

    sort($current_category_ids);
    sort($category_ids);
    
//echo var_dump($current_category_ids);    
//echo var_dump($category_ids);    
    
    if ($current_category_ids != $category_ids) {
      //$result = wp_set_post_terms($post_id, $category_ids, $category_taxonomy);
      //wc1c_check_wp_error($result);

  	$get_products_id_by_guid_query = vam_db_query("select products_id from " . TABLE_PRODUCTS . " where guid = '" . vam_db_input($guid) . "'");
  	$get_products_id_by_guid = vam_db_fetch_array($get_products_id_by_guid_query);
  	
//echo var_dump($get_products_id_by_guid);  	
//echo "<br />";      
//echo var_dump($post_id);
//echo "<br />";      
//echo var_dump($guid);      
      
		$sql_data_array = array (
		'products_id' => $get_products_id_by_guid['products_id'], 
		'categories_id' => $category_ids[0]
       );

		vam_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, $sql_data_array);
		
		//exit;
      
      
    }
  }

  //update_post_meta($post_id, '_wc1c_timestamp', WC1C_TIMESTAMP);

  return array($is_added, $post_id, $current_post_meta);
}

function wc1c_replace_post_attachments($post_id, $attachments) {
  $data_dir = WC1C_DATA_DIR . "catalog";

//echo var_dump($post_id);
//echo var_dump($attachments);

  $attachment_path_by_hash = array();
  foreach ($attachments as $attachment_path => $attachment) {
    $attachment_path = "$data_dir/$attachment_path";
    if (!file_exists($attachment_path)) continue;

    $attachment_hash = basename($attachment_path) . md5_file($attachment_path);
    $attachment_path_by_hash[$attachment_hash] = $attachment_path;
  }
  $attachment_hash_by_path = array_flip($attachment_path_by_hash);

  //$post_attachments = get_attached_media('image', $post_id);
  //echo var_dump($post_id);
  //exit;

  	$get_products_image_by_id_query = vam_db_query("select products_image from " . TABLE_PRODUCTS . " where products_id = '" . vam_db_input($post_id) . "'");
  	$get_products_image_by_id = vam_db_fetch_array($get_products_image_by_id_query);

  $post_attachments[] = $get_products_image_by_id['products_image'];
  
//echo var_dump($get_products_image_by_id['products_image']);  	
//echo var_dump($post_id);  
//echo var_dump($post_attachments);  
  
  $post_attachment_id_by_hash = array();
  foreach ($post_attachments as $post_attachment) {
    $post_attachment_path = DIR_FS_CATALOG.DIR_WS_THUMBNAIL_IMAGES.$post_attachment;
    //echo $post_attachment;
    //exit;
    if (file_exists($post_attachment_path)) {
      $post_attachment_hash = basename($post_attachment_path) . md5_file($post_attachment_path);
      $post_attachment_id_by_hash[$post_attachment_hash] = $post_attachment->ID;
      if (isset($attachment_path_by_hash[$post_attachment_hash])) {
        unset($attachment_path_by_hash[$post_attachment_hash]);
        continue;
      }
    }

     //echo 'test';
     //echo var_dump($post_attachment);
     //exit;
     
		$sql_data_array = array (
		'products_image' => '' 
      );
		vam_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', 'products_id = \''.$post_id.'\'');
		     
    //$result = wp_delete_attachment($post_attachment->ID);
    //if ($result === false) wc1c_error("Failed to delete post attachment");
  }

  $attachment_ids = array();
  foreach ($attachments as $attachment_path => $attachment) {
    $attachment_path = "$data_dir/$attachment_path";
    if (!file_exists($attachment_path)) continue;

    $attachment_hash = $attachment_hash_by_path[$attachment_path];
    $attachment_id = @$post_attachment_id_by_hash[$attachment_hash];

//echo var_dump($attachment_hash);
//echo "<br />";
//echo var_dump($attachment_id);

    if (!$attachment_id) {
      $file = array(
        'tmp_name' => $attachment_path,
        'name' => basename($attachment_path),
      );
      
  	$get_products_image_by_id_query = vam_db_query("select products_image from " . TABLE_PRODUCTS . " where products_id = '" . vam_db_input($post_id) . "'");
  	$get_products_image_by_id = vam_db_fetch_array($get_products_image_by_id_query);

   $attachment_id = $get_products_image_by_id['products_image'];
   
   //echo var_dump($attachment_id);
   
   if ($attachment_id == '') {

		$sql_data_array = array (
		'products_image' => $file['name'] 
       );

//echo $meta_key."::".$meta_value;
//echo 'test';
//echo var_dump($sql_data_array);

		vam_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', 'products_id = \''.$post_id.'\'');
		
		}        

        
      //$attachment_id = @media_handle_sideload($file, $post_id, @$attachment['description']);
      wc1c_check_wp_error($attachment_id);
      
      $uploaded_attachment_path_thumb = DIR_FS_CATALOG.DIR_WS_THUMBNAIL_IMAGES.$file['name'];
      $uploaded_attachment_path_info = DIR_FS_CATALOG.DIR_WS_INFO_IMAGES.$file['name'];
      $uploaded_attachment_path_popup = DIR_FS_CATALOG.DIR_WS_POPUP_IMAGES.$file['name'];
      $uploaded_attachment_path_original = DIR_FS_CATALOG.DIR_WS_ORIGINAL_IMAGES.$file['name'];
      
//echo var_dump($file);      
//echo var_dump($attachment_path);      
//echo var_dump($uploaded_attachment_path);
      
      if ($uploaded_attachment_path_thumb) {
      	copy($attachment_path, $uploaded_attachment_path_thumb);
      	//echo var_dump(copy($attachment_path, $uploaded_attachment_path_thumb));
      }

      if ($uploaded_attachment_path_info) {
      	copy($attachment_path, $uploaded_attachment_path_info);
      	//echo var_dump(copy($attachment_path, $uploaded_attachment_path_info));
      }

      if ($uploaded_attachment_path_popup) {
      	copy($attachment_path, $uploaded_attachment_path_popup);
      	//echo var_dump(copy($attachment_path, $uploaded_attachment_path_popup));
      }

      if ($uploaded_attachment_path_original) {
      	copy($attachment_path, $uploaded_attachment_path_original);
      	//echo var_dump(copy($attachment_path, $uploaded_attachment_path_original));
      }
    }

    $attachment_ids[] = $attachment_id;
  }

//echo var_dump($attachment_ids);

  return $attachment_ids;
}

function wc1c_replace_requisite_name_callback($matches) {
  return ' ' . mb_convert_case($matches[0], MB_CASE_LOWER, "UTF-8");
}

function wc1c_replace_product($is_full, $guid, $product) {
  global $wc1c_is_moysklad;
  
  //echo var_dump($product);

  //$product = apply_filters('wc1c_import_product_xml', $product, $is_full);
  if (!$product) return;

  //$preserve_fields = apply_filters('wc1c_import_preserve_product_fields', array(), $product, $is_full);

  $is_deleted = @$product['Статус'] == 'Удален';
  $is_draft = @$product['Статус'] == 'Черновик';

  $post_title = @$product['Наименование'];
  if (!$post_title) return;

  $post_content = '';

  $post_meta = array(
    '_sku' => @$product['Артикул'],
    '_manage_stock' => 'yes',
  );

  foreach ($product['ЗначенияРеквизитов'] as $i => $requisite) {
    $value = @$requisite['Значение'][0];
	if (!$value) continue;
    if ($requisite['Наименование'] == "Полное наименование") {
      if ($wc1c_is_moysklad) $post_content = $value;
      else $post_title = $value;
      unset($product['ЗначенияРеквизитов'][$i]);
    }
    elseif ($requisite['Наименование'] == "ОписаниеВФорматеHTML") {
      $post_content = $value;
      unset($product['ЗначенияРеквизитов'][$i]);
    }
    elseif ($requisite['Наименование'] == "Длина") {
      $post_meta['products_length'] = floatval($value);
      unset($product['ЗначенияРеквизитов'][$i]);
    }
    elseif ($requisite['Наименование'] == "Ширина") {
      $post_meta['products_width'] = floatval($value);
      unset($product['ЗначенияРеквизитов'][$i]);
    }
    elseif ($requisite['Наименование'] == "Высота") {
      $post_meta['products_height'] = floatval($value);
      unset($product['ЗначенияРеквизитов'][$i]);
    }
    elseif ($requisite['Наименование'] == "Вес") {
      $post_meta['products_weight'] = floatval($value);
      unset($product['ЗначенияРеквизитов'][$i]);
    }
  }

  $post_name = vam_db_input($post_title);
  //$post_name = apply_filters('wc1c_import_product_slug', $post_name, $product, $is_full);
  
  //echo var_dump($post_name);

  $description = isset($product['Описание']) ? $product['Описание'] : '';
  list($is_added, $post_id, $post_meta) = wc1c_replace_post($guid, 'product', $is_deleted, $is_draft, $post_title, $post_name, $description, $post_content, $post_meta, 'product_cat', @$product['Группы'], $preserve_fields);

  // if (isset($product['Пересчет']['Единица'])) {
  //   $quantity = wc1c_parse_decimal($product['Пересчет']['Единица']);
  //   if (isset($product['Пересчет']['Коэффициент'])) $quantity *= wc1c_parse_decimal($product['Пересчет']['Коэффициент']);
  //   wc_update_product_stock($post_id, $quantity);
  //
  //   $stock_status = $quantity > 0 ? 'instock' : WC1C_OUTOFSTOCK_STATUS;
  //   wc_update_product_stock_status($post_id, $stock_status);
  // }

  $current_product_attributes = isset($post_meta['_product_attributes']) ? maybe_unserialize($post_meta['_product_attributes']) : array();

  $current_product_attribute_variations = array(); 
  foreach ($current_product_attributes as $current_product_attribute_key => $current_product_attribute) {
    if (!$current_product_attribute['is_variation']) continue;

    unset($current_product_attributes[$current_product_attribute_key]);
    $current_product_attribute_variations[$current_product_attribute_key] = $current_product_attribute;
  }

  $product_attributes = array();

  $product_attribute_values = array();
  if (!empty($product['Изготовитель']['Наименование'])) $product_attribute_values["Наименование изготовителя"] = $product['Изготовитель']['Наименование'];
  if (!empty($product['БазоваяЕдиница']) && trim($product['БазоваяЕдиница'])) $product_attribute_values["Базовая единица"] = trim($product['БазоваяЕдиница']);

  foreach ($product_attribute_values as $product_attribute_name => $product_attribute_value) {
    $product_attribute_key = sanitize_title($product_attribute_name);
    $product_attribute_position = count($product_attributes);
    $product_attributes[$product_attribute_key] = array(
      'name' => wc_clean($product_attribute_name),
      'value' => $product_attribute_value,
      'position' => $product_attribute_position,
      'is_visible' => 0,
      'is_variation' => 0,
      'is_taxonomy' => 0,
    );
  }

  if ($product['ЗначенияСвойств']) {
    $attribute_guids = get_option('wc1c_guid_attributes', array());
    $terms = array();
    foreach ($product['ЗначенияСвойств'] as $property) {
      $attribute_guid = $property['Ид'];
      $attribute_id = @$attribute_guids[$attribute_guid];
      if (!$attribute_id) continue;

      $attribute = wc1c_woocommerce_attribute_by_id($attribute_id);
      if (!$attribute) wc1c_error("Failed to get attribute");

      $attribute_terms = array();
      $attribute_values = array();
      $property_values = @$property['Значение'];
      if ($property_values) {
        foreach ($property_values as $property_value) {
          if (!$property_value) continue;

          if ($attribute['attribute_type'] == 'select' && preg_match("/^\w+-\w+-\w+-\w+-\w+$/", $property_value)) {
            $term_id = wc1c_term_id_by_meta('wc1c_guid', "{$attribute['taxonomy']}::$property_value");
            if ($term_id) $attribute_terms[] = (int) $term_id;
          }
          else {
            if (!defined('WC1C_MULTIPLE_VALUES_DELIMETER')) {
              $attribute_values[] = $property_value;
            }
            else {
              $term_names = explode(WC1C_MULTIPLE_VALUES_DELIMETER, $property_value);
              $term_names = array_map('trim', $term_names);
              foreach ($term_names as $term_name) {
                $result = get_term_by('name', $term_name, $attribute['taxonomy'], ARRAY_A);
                if (!$result) {
                  $slug = wc1c_unique_term_slug($term_name, $attribute['taxonomy']);
                  $args = array(
                    'slug' => $slug,
                  );
                  $result = wp_insert_term($term_name, $attribute['taxonomy'], $args);
                  wc1c_check_wpdb_error();
                  wc1c_check_wp_error($result);
                }
                $attribute_terms[] = $result['term_id'];
              }
            }
          }
        }
      }

      if ($attribute_terms || $attribute_values) {
        $product_attribute = array(
          'name' => null,
          'value' => '',
          'position' => count($product_attributes),
          'is_visible' => 1,
          'is_variation' => 0,
          'is_taxonomy' => 0,
        );

        if ($attribute_terms) {
          $product_attribute['name'] = $attribute['taxonomy'];
          $product_attribute['is_taxonomy'] = 1;
        }
        elseif ($attribute_values) {
          $product_attribute['name'] = $attribute['attribute_label'];
          $product_attribute['value'] = implode(" | ", $attribute_values);
        }

        $product_attribute_key = sanitize_title($attribute['taxonomy']);
        $product_attributes[$product_attribute_key] = $product_attribute;
      }

      if ($attribute_terms) {
        if (!isset($terms[$attribute['taxonomy']])) $terms[$attribute['taxonomy']] = array();
        $terms[$attribute['taxonomy']] = array_merge($terms[$attribute['taxonomy']], $attribute_terms);
      }
    }

    foreach ($terms as $attribute_taxonomy => $attribute_terms) {
      register_taxonomy($attribute_taxonomy, null);
      $result = wp_set_post_terms($post_id, $attribute_terms, $attribute_taxonomy);
      wc1c_check_wp_error($result);
    }
  }

  foreach ($product['ЗначенияРеквизитов'] as $requisite) {
    $attribute_values = @$requisite['Значение'];
    if (!$attribute_values) continue;
    if (strpos($attribute_values[0], "import_files/") === 0) continue;

    $requisite_name = $requisite['Наименование'];
    $product_attribute_name = strpos($requisite_name, ' ') === false ? preg_replace_callback("/(?<!^)\p{Lu}/u", 'wc1c_replace_requisite_name_callback', $requisite_name) : $requisite_name;
    $product_attribute_key = vam_db_input($requisite_name);
    $product_attribute_position = count($product_attributes);
    $product_attributes[$product_attribute_key] = array(
      'name' => vam_db_input($product_attribute_name),
      'value' => implode(" | ", $attribute_values),
      'position' => $product_attribute_position,
      'is_visible' => 0,
      'is_variation' => 0,
      'is_taxonomy' => 0,
    );
  }

/*  foreach ($product['ХарактеристикиТовара'] as $characteristic) {
    $attribute_value = @$characteristic['Значение'];
    if (!$attribute_value) continue;

    $product_attribute_name = $characteristic['Наименование'];
    $product_attribute_key = sanitize_title($product_attribute_name);
    $product_attribute_position = count($product_attributes);
    $product_attributes[$product_attribute_key] = array(
      'name' => wc_clean($product_attribute_name),
      'value' => $attribute_value,
      'position' => $product_attribute_position,
      'is_visible' => 1,
      'is_variation' => 0,
      'is_taxonomy' => 0,
    );
  }

  if (!in_array('attributes', $preserve_fields)) {
    $old_product_attributes = array_diff_key($current_product_attributes, $product_attributes);
    $old_taxonomies = array();
    foreach ($old_product_attributes as $old_product_attribute) {
      if ($old_product_attribute['is_taxonomy']) {
        $old_taxonomies[] = $old_product_attribute['name'];
      }
      else {
        $key = array_search($old_product_attribute, $product_attributes);
        if ($key !== false) unset($product_attributes[$key]);
      }
    }
    foreach ($old_taxonomies as $old_taxonomy) {
      register_taxonomy($old_taxonomy, null);
    }
    wp_delete_object_term_relationships($post_id, $old_taxonomies);

    ksort($current_product_attributes);
    $product_attributes_copy = $product_attributes;
    ksort($product_attributes_copy);
    if ($current_product_attributes != $product_attributes_copy) {
      $product_attributes = array_merge($product_attributes, $current_product_attribute_variations);
      update_post_meta($post_id, '_product_attributes', $product_attributes);
    }
  }*/

  if (!in_array('attachments', $preserve_fields)) {
    $attachments = array();
    if (!empty($product['Картинка'])) {
      $attachments = array_filter($product['Картинка']);
      $attachments = array_fill_keys($attachments, array());
    }

    if ($product['ЗначенияРеквизитов']) {
      $attachment_keys = array(
        'ОписаниеФайла' => 'description',
      );
      foreach ($product['ЗначенияРеквизитов'] as $requisite) {
        $attribute_name = $requisite['Наименование'];
        if (!isset($attachment_keys[$attribute_name])) continue;

        $attribute_values = @$requisite['Значение'];
        if (!$attribute_values) continue;
        
        $attribute_value = $attribute_values[0];
        if (strpos($attribute_value, "import_files/") !== 0) continue;
          
        list($picture_path, $attribute_value) = explode('#', $attribute_value, 2);
        if (!isset($attachments[$picture_path])) continue;

        $attachment_key = $attachment_keys[$attribute_name];
        $attachments[$picture_path][$attachment_key] = $attribute_value;
        //echo var_dump($attachments);
      }
    }

    if ($attachments) {
    	//echo var_dump($attachments);
    	//exit;
      $attachment_ids = wc1c_replace_post_attachments($post_id, $attachments);
      
      //echo var_dump($attachment_ids);

      $new_post_meta = array(
        //'_product_image_gallery' => implode(',', array_slice($attachment_ids, 1)),
        'products_image' => @$attachment_ids[0],
      );
      
      //echo var_dump($post_id);
      //echo var_dump($post_meta);
      //echo var_dump($new_post_meta);
      foreach ($new_post_meta as $meta_key => $meta_value) {
        if ($meta_value != @$post_meta[$meta_key]) {

		$sql_data_array = array (
		'products_image' => @$attachment_ids[0] 
       );

//echo $meta_key."::".$meta_value;
//echo 'test';
//echo var_dump($sql_data_array);

		vam_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', 'products_id = \''.$post_id.'\'');        

      //update_post_meta($post_id, $meta_key, $meta_value);
        
        } 
      }
    }
  }

  //do_action('wc1c_post_product', $post_id, $is_added, $product, $is_full);

  return $post_id;
}

function wc1c_replace_subproducts($is_full, $subproducts) {
  require_once sprintf(WC1C_PLUGIN_DIR . "exchange/offers.php");

  wc1c_replace_suboffers($is_full, $subproducts, true);
}

function wc1c_clean_woocommerce_categories($is_full) {
  //global $wpdb;

  //if (!$is_full || WC1C_PREVENT_CLEAN) return;

  //$term_ids = $wpdb->get_col($wpdb->prepare("SELECT tm.term_id FROM $wpdb->termmeta tm JOIN $wpdb->term_taxonomy tt ON tm.term_id = tt.term_id WHERE taxonomy = 'product_cat' AND meta_key = 'wc1c_timestamp' AND meta_value != %d", WC1C_TIMESTAMP));
  //wc1c_check_wpdb_error();

  //$term_ids = apply_filters('wc1c_clean_categories', $term_ids);
  //if (!$term_ids) return;

  //foreach ($term_ids as $term_id) {
    //$result = wp_delete_term($term_id, 'product_cat');
    //wc1c_check_wp_error($result);
  //}
}

function wc1c_clean_woocommerce_attributes($is_full) {
  global $wpdb;

  if (!$is_full || WC1C_PREVENT_CLEAN) return;

  $timestamps = get_option('wc1c_timestamp_attributes', array());
  if (!$timestamps) return;

  $guids = get_option('wc1c_guid_attributes', array());

  $attribute_ids = array();
  foreach ($timestamps as $guid => $timestamp) {
    if ($timestamp != WC1C_TIMESTAMP) $attribute_ids[] = $guids[$guid];
  }

  $attribute_ids = apply_filters('wc1c_clean_attributes', $attribute_ids);
  if (!$attribute_ids) return;

  foreach ($attribute_ids as $attribute_id) {
    $attribute = wc1c_woocommerce_attribute_by_id($attribute_id);
    if (!$attribute) continue;

    wc1c_delete_woocommerce_attribute($attribute_id);
    
    unset($guids[$guid]);
    unset($timestamps[$guid]);

    $is_deleted = true;
  }

  if (!empty($is_deleted)) {
    $orders = get_option('wc1c_order_attributes', array());
    $order_index = array_search($attribute_id, $orders);
    if ($order_index !== false) {
      unset($orders[$order_index]);
      update_option('wc1c_order_attributes', $orders);
    }

    update_option('wc1c_guid_attributes', $guids);
    update_option('wc1c_timestamp_attributes', $timestamps);
  }
}

function wc1c_clean_woocommerce_attribute_options($is_full, $attribute_taxonomy) {
  global $wpdb;

  if (!$is_full || WC1C_PREVENT_CLEAN) return;

  $term_ids = $wpdb->get_col($wpdb->prepare("SELECT tm.term_id FROM $wpdb->termmeta tm JOIN $wpdb->term_taxonomy tt ON tm.term_id = tt.term_id WHERE taxonomy = %s AND meta_key = 'wc1c_timestamp' AND meta_value != %d", $attribute_taxonomy, WC1C_TIMESTAMP));
  wc1c_check_wpdb_error();

  foreach ($term_ids as $term_id) {
    $result = wp_delete_term($term_id, $attribute_taxonomy);
    wc1c_check_wp_error($result);
  }
}

function wc1c_clean_posts($post_type) {
  global $wpdb;
  
  //echo var_dump($post_type);

  //$post_ids = $wpdb->get_col($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta JOIN $wpdb->posts ON post_id = ID WHERE post_type = %s AND meta_key = '_wc1c_timestamp' AND meta_value != %d", $post_type, WC1C_TIMESTAMP));
  //wc1c_check_wpdb_error();

  //foreach ($post_ids as $post_id) {
    //wp_trash_post($post_id);
  //}
}

function wc1c_clean_products($is_full) {
  if (!$is_full || WC1C_PREVENT_CLEAN) return;

  wc1c_clean_posts('product');
}

function wc1c_clean_product_terms() {
  global $wpdb;

  //$wpdb->query("UPDATE $wpdb->term_taxonomy tt SET count = (SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id = tt.term_taxonomy_id) WHERE taxonomy LIKE 'pa_%'");
  //wc1c_check_wpdb_error();

  //$rows = $wpdb->get_results("SELECT tm.term_id, taxonomy FROM $wpdb->term_taxonomy tt LEFT JOIN $wpdb->termmeta tm ON tt.term_id = tm.term_id AND meta_key = 'wc1c_guid' WHERE meta_value IS NULL AND taxonomy LIKE 'pa_%' AND count = 0");
  //wc1c_check_wpdb_error();

  //foreach ($rows as $row) {
    //register_taxonomy($row->taxonomy, null);
    //$result = wp_delete_term($row->term_id, $row->taxonomy);
    //wc1c_check_wp_error($result);
  //}
}