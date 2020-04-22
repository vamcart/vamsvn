<?php
if (ENABLE_1C_EXCHANGE != 'true') exit('Модуль интеграции VamShop и 1С:Предприятие выключен. Подробная информация <a href="https://forum.vamshop.ru/topic/16769-%D0%B8%D0%BD%D1%82%D0%B5%D0%B3%D1%80%D0%B0%D1%86%D0%B8%D1%8F-vamshop-%D0%B8-1%D1%81%D0%BF%D1%80%D0%B5%D0%B4%D0%BF%D1%80%D0%B8%D1%8F%D1%82%D0%B8%D0%B5/" target="_blank"><u>здесь</u></a>.');

$lang = 1;
$_SESSION['language'] = 'russian';
$_SESSION['languages_id'] = 1;
require (DIR_WS_CLASSES.'order.php');

if (!defined('WC1C_CURRENCY')) define('WC1C_CURRENCY', DEFAULT_CURRENCY);

//WC();

$orders_statuses = array ();
$orders_status_array = array ();
$orders_status_query = vam_db_query("select orders_status_id, orders_status_name from ".TABLE_ORDERS_STATUS." where language_id = '".(int)$lang."'");
while ($orders_status = vam_db_fetch_array($orders_status_query)) {
	$orders_statuses[] = array ('id' => $orders_status['orders_status_id'], 'text' => $orders_status['orders_status_name']);
	$orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
}

$order_post_ids = array();
$documents = array();

$orders_query = vam_db_query("select o.*, ot.text as order_total from ".TABLE_ORDERS." o left join ".TABLE_ORDERS_TOTAL." ot on (ot.orders_id = o.orders_id) where ot.class = 'ot_total' order by o.orders_id DESC limit 50");
//echo vam_db_num_rows($orders_query);
if (!vam_db_num_rows($orders_query)) wc1c_error("Failed to get order");

while ($order_post = vam_db_fetch_array($orders_query)) {
  $order = new order($order_post['orders_id']);
  
  //echo var_dump($order);
  //echo var_dump($order->products);

  $order_post_ids[] = $order_post['orders_id'];

  $order_line_items = $order->products;
  
  //echo var_dump($order_line_items);

  // $has_missing_item = false;
  //foreach ($order_line_items as $key => $order_line_item) {
    //$product_id = $order_line_item['variation_id'] ? $order_line_item['variation_id'] : $order_line_item['product_id'];
    //$guid = get_post_meta($product_id, '_wc1c_guid', true);
    // if (!$guid) {
    //   $has_missing_item = true;
    //   break;
    // }

    //$order_line_items[$key]['wc1c_guid'] = $guid;
  //}
  // if ($has_missing_item) continue;

  //$order_shipping_items = $order->get_shipping_methods();

    $shipping_method_query = vam_db_query("select title, value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . vam_db_input($order_post['orders_id']) . "' and class = 'ot_shipping'");
	 $shipping_method = vam_db_fetch_array($shipping_method_query);

	 $order_payment = $order_post['payment_method'];

	 require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $order_payment .'.php');
	 $order_payment_text = constant(MODULE_PAYMENT_.strtoupper($order_payment)._TEXT_TITLE);


	 // Order History
	 $statuses_query = vam_db_query("select os.orders_status_name, osh.date_added, osh.comments from ".TABLE_ORDERS_STATUS." os, ".TABLE_ORDERS_STATUS_HISTORY." osh where osh.orders_id = '".vam_db_input($order_post['orders_id'])."' and osh.orders_status_id = os.orders_status_id and os.language_id = '".(int) $_SESSION['languages_id']."' order by orders_status_history_id ASC limit 1");
	 $statuses = vam_db_fetch_array($statuses_query);
	 $order_comment = (empty ($statuses['comments']) ? '' : nl2br(htmlspecialchars($statuses['comments'])));

  //$order_meta = get_post_meta($order_post->ID, null, true);
  //foreach ($order_meta as $meta_key => $meta_value) {
    //$order_meta[$meta_key] = $meta_value[0];
  //}

  $order_meta = $order_post;
  foreach ($order_meta as $meta_key => $meta_value) {
    $order_meta[$meta_key] = $meta_value;
  }

  $address_items = array(
    'postcode' => "Почтовый индекс",
    'country' => "Страна",
    'state' => "Регион",
    'city' => "Город",
  );
  $contact_items = array(
    'email_address' => "Почта",
    'telephone' => "ТелефонРабочий",
  );

  //$contragent_meta = get_post_meta($order_post->ID, 'wc1c_contragent', true);
  $contragents = array();
  foreach (array('customers', 'delivery') as $type) {
    $contragent = array();

    $name = array();
    foreach (array('lastname', 'firstname') as $name_key) {
      $meta_key = "{$type}_$name_key";
      if (empty($order_meta[$meta_key])) continue;

      $name[] = $order_meta[$meta_key];
      $contragent[$name_key] = $order_meta[$meta_key];
    }

    $name = implode(' ', $name);
    if (!$name) {
      $contragent['name'] = "Гость";
      $contragent['user_id'] = 0;
    }
    else {
      $contragent['name'] = $name;
      $contragent['user_id'] = $order_post['customers_id'];
    }

    if (!empty($order_meta["{$type}_country"])) {
      $country_code = $order_meta["{$type}_country"];
      $order_meta["{$type}_country"] = $country_code;
    }

    $full_address = array();
    foreach (array('postcode', 'country', 'state', 'city', 'street_address', 'suburb') as $address_key) {
      $meta_key = "{$type}_$address_key";
      if (!empty($order_meta[$meta_key])) $full_address[] = $order_meta[$meta_key];
    }
    $contragent['full_address'] = implode(", ", $full_address);

    $contragent['address'] = array();
    foreach ($address_items as $address_key => $address_item_name) {
      if (empty($order_meta["{$type}_$address_key"])) continue;

      $contragent['address'][$address_item_name] = $order_meta["{$type}_$address_key"];
    }

    $contragent['contacts'] = array();
    foreach ($contact_items as $contact_key => $contact_item_name) {
      if (empty($order_meta["{$type}_$contact_key"])) continue;

      $contragent['contacts'][$contact_item_name] = $order_meta["{$type}_$contact_key"];
    }

    $contragents[$type] = $contragent;
  }
  
  //echo var_dump($contragents);

  $products = array();
  foreach ($order_line_items as $order_line_item) {
    $products[] = array(
      'guid' => $order_line_item['id'],
      'name' => $order_line_item['name'],
      'price_per_item' => $order_line_item['price'],
      'quantity' => $order_line_item['qty'],
      'total' => $order_line_item['final_price'],
      'type' => "Товар",
    );
  }

  //foreach ($order_shipping_items as $order_shipping_item) {
    //if (!$shipping_method['value']) continue;

    $products[] = array(
      'guid' => 'ORDER_DELIVERY',
      'name' => $order->info['shipping_method'],
      'price_per_item' => $shipping_method['value'],
      'quantity' => 1,
      'total' => $shipping_method['value'],
      'type' => "Услуга",
    );
  //}

  //$statuses = array(
    //'cancelled' => "Отменен",
    //'trash' => "Удален",
  //);
  //$status = $order->get_status();
  //if (array_key_exists($status, $statuses)) {
    //$order_status_name = $statuses[$status];
  //}
  //else {
    $order_status_name = $orders_status_array[$order_post['orders_status']];
  //}

  if (DEFAULT_CURRENCY) $document_currency = DEFAULT_CURRENCY;
  else $document_currency = $order_post['currency'];

  $document = array(
    'order_id' => $order_post['orders_id'],
    'currency' => $document_currency,
    'total' => number_format($order->info['total_value'],2,'.',''),
    'comment' => $order_comment,
    'contragents' => $contragents,
    'products' => $products,
    'payment_method_title' => $order_payment_text,
    'status' => $order_post['orders_status'],
    'status_name' => $order_status_name,
    //'status_name' => vam_get_orders_status_name($order_post['orders_status']),
    'has_shipping' => 1,
    'modified_at' => ($order_post['last_modified'] != '') ? $order_post['last_modified'] : $order_post['date_purchased'],
  );
  list($document['date'], $document['time']) = explode(' ', $order_post['date_purchased'], 2);

  $documents[] = $document;
}

//echo var_dump($documents);

//$documents = apply_filters('wc1c_query_documents', $documents);

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<КоммерческаяИнформация ВерсияСхемы="2.05" ДатаФормирования="<?php echo date("Y-m-dTH:i:s", WC1C_TIMESTAMP) ?>">
  <?php foreach ($documents as $document): ?>
    <Документ>
      <Ид>wc1c#order#<?php echo $document['order_id'] ?></Ид>
      <Номер><?php echo $document['order_id'] ?></Номер>
      <Дата><?php echo $document['date'] ?></Дата>
      <Время><?php echo $document['time'] ?></Время>
      <ХозОперация>Заказ товара</ХозОперация>
      <Роль>Продавец</Роль>
      <Валюта><?php echo $document['currency'] ?></Валюта>
      <Сумма><?php echo $document['total'] ?></Сумма>
      <Комментарий><?php echo $document['comment'] ?></Комментарий>
      <Контрагенты>
        <?php foreach ($document['contragents'] as $type => $contragent): ?>
          <Контрагент>
            <Ид>wc1c#user#<?php echo $contragent['user_id'] ?></Ид>
            <Роль><?php echo $type == 'customers' ? "Плательщик" : "Получатель" ?></Роль>
            <?php if (!empty($contragent['name'])): ?>
              <Наименование><?php echo $contragent['name'] ?></Наименование>
              <ПолноеНаименование><?php echo $contragent['name'] ?></ПолноеНаименование>
            <?php endif ?>
            <?php if (!empty($contragent['firstname'])): ?>
              <Имя><?php echo $contragent['firstname'] ?></Имя>
            <?php endif ?>
            <?php if (!empty($contragent['lastname'])): ?>
              <Фамилия><?php echo $contragent['lastname'] ?></Фамилия>
            <?php endif ?>
            <?php if (!empty($contragent['full_address']) || $contragent['address']): ?>
              <АдресРегистрации>
                <?php if (!empty($contragent['full_address'])): ?>
                  <Представление><?php echo $contragent['full_address'] ?></Представление>  
                <?php endif ?>
                <?php foreach ($contragent['address'] as $address_item_name => $address_item_value): ?>
                  <АдресноеПоле>
                    <Тип><?php echo $address_item_name ?></Тип>
                    <Значение><?php echo $address_item_value ?></Значение>
                  </АдресноеПоле>
                <?php endforeach ?>
              </АдресРегистрации>
            <?php endif ?>
            <Контакты>
              <?php foreach ($contragent['contacts'] as $contact_item_name => $contact_item_value): ?>
                <Контакт>
                  <Тип><?php echo $contact_item_name ?></Тип>
                  <Значение><?php echo $contact_item_value ?></Значение>
                </Контакт>
              <?php endforeach ?>
            </Контакты>
            <?php /*
            <Представители>
              <Представитель>
                <Контрагент>
                  <Отношение>Контактное лицо</Отношение>
                  <Ид><?php echo md5($contragent['user_id']) ?></Ид>
                  <?php if ($contragent['full_name']): ?>
                    <Наименование><?php echo $contragent['full_name'] ?></Наименование>
                  <?php endif ?>
                </Контрагент>
              </Представитель>
            </Представители>
            */ ?>
          </Контрагент>
        <?php endforeach ?>
      </Контрагенты>
      <Товары>
        <?php foreach ($document['products'] as $product): ?>
          <Товар>
            <?php if (!empty($product['guid'])): ?>
              <Ид><?php echo $product['guid'] ?></Ид>
            <?php endif ?>
            <Наименование><?php echo $product['name'] ?></Наименование>
            <БазоваяЕдиница Код="796" НаименованиеПолное="Штука" МеждународноеСокращение="PCE">шт</БазоваяЕдиница>
            <ЦенаЗаЕдиницу><?php echo $product['price_per_item'] ?></ЦенаЗаЕдиницу>
            <Количество><?php echo $product['quantity'] ?></Количество>
            <Сумма><?php echo $product['total'] ?></Сумма>
            <ЗначенияРеквизитов>
              <ЗначениеРеквизита>
                <Наименование>ТипНоменклатуры</Наименование>
                <Значение><?php echo $product['type'] ?></Значение>
              </ЗначениеРеквизита>
            </ЗначенияРеквизитов>
          </Товар>
        <?php endforeach ?>
      </Товары>
      <ЗначенияРеквизитов>
        <?php
        $requisites = array(
          'Заказ оплачен' => !in_array($document['status'], array('1', '2', '3')) ? 'true' : 'false',
          'Доставка разрешена' => $document['has_shipping'] ? 'true' : 'false',
          'Отменен' => $document['status'] == '3' ? 'true' : 'false',
          'Финальный статус' => !in_array($document['status'], array('1', '2', '3', '4', '5')) ? 'true' : 'false',
          'Статус заказа' => $document['status_name'],
          'Дата изменения статуса' => $document['modified_at'],
        );
        if ($document['payment_method_title']) $requisites['Метод оплаты'] = $document['payment_method_title'];
        //$requisites = apply_filters('wc1c_query_order_requisites', $requisites, $document);
        foreach ($requisites as $requisite_key => $requisite_value): ?>
          <ЗначениеРеквизита>
            <Наименование><?php echo $requisite_key ?></Наименование>
            <Значение><?php echo $requisite_value ?></Значение>
          </ЗначениеРеквизита>
        <?php endforeach; ?>
      </ЗначенияРеквизитов>
    </Документ>
  <?php endforeach ?>
</КоммерческаяИнформация>

<?php
//foreach ($order_post_ids as $order_post_id) {
  //update_post_meta($order_post_id, 'wc1c_querying', 1);
//}
?>
