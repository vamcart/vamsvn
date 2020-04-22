<?php
if (ENABLE_1C_EXCHANGE != 'true') exit('Модуль интеграции VamShop и 1С:Предприятие выключен. Подробная информация <a href="https://forum.vamshop.ru/topic/16769-%D0%B8%D0%BD%D1%82%D0%B5%D0%B3%D1%80%D0%B0%D1%86%D0%B8%D1%8F-vamshop-%D0%B8-1%D1%81%D0%BF%D1%80%D0%B5%D0%B4%D0%BF%D1%80%D0%B8%D1%8F%D1%82%D0%B8%D0%B5/" target="_blank"><u>здесь</u></a>.');

/*$order_statuses = array_keys(wc_get_order_statuses());
$order_posts = get_posts(array(
  'post_type' => 'shop_order',
  'post_status' => $order_statuses,
  'meta_query' => array(
    array(
      'key' => 'wc1c_querying',
      'value' => 1,
    ),
    array(
      'key' => 'wc1c_queried',
      'compare' => "NOT EXISTS",
    ),
  ),
));

foreach ($order_posts as $order_post) {
  update_post_meta($order_post->ID, 'wc1c_queried', 1);
}
*/