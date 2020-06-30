<?php
/* --------------------------------------------------------------
   $Id: latest_news.php 899 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2003	 osCommerce (latest_news.php,v 1.4 2003/08/14); oscommerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Шаблоны ответов');

define('TABLE_HEADING_ANSWER_TEMPLATES_NAME', 'Название');
define('TABLE_HEADING_ANSWER_TEMPLATES_ACTION', 'Действие');
define('TABLE_HEADING_ANSWER_TEMPLATES_STATUS', 'Статус');

define('TEXT_ITEMS', 'Количество ответов:');
define('TEXT_INFO_HEADING_DELETE_ITEM', 'Удалить ответ');
define('TEXT_DELETE_ITEM_INTRO', 'Вы уверены, что хотите удалить этот ответ?');

define('TEXT_ANSWER_TEMPLATES_NAME', 'Название');
define('TEXT_ANSWER_TEMPLATES_CONTENT', 'Ответ');

define('IMAGE_NEW_NEWS_ITEM', 'Добавить ответ');
define('IMAGE_EDIT_NEWS_ITEM', 'Изменить ответ');
define('TEXT_ANSWER_TEMPLATES_LANGUAGE', 'Язык');
define('TEXT_ANSWER_TEMPLATES_DATE', 'Дата');

// Сборка VaM

define('IMAGE_ICON_STATUS_GREEN', 'Активна');
define('IMAGE_ICON_STATUS_GREEN_LIGHT', 'Активизировать');
define('IMAGE_ICON_STATUS_RED', 'Неактивен');
define('IMAGE_ICON_STATUS_RED_LIGHT', 'Сделать неактивным');

define('EMPTY_CATEGORY', 'Нет ответов');
define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 'Добавьте ответ');

define('TEXT_AVAILABLE_PLACEHOLDERS', 'Доступные метки:');
define('TEXT_NAME', '{$NAME} - Имя покупателя.');
define('TEXT_FIRST_NAME', '{$FIRST_NAME} - Только имя покупателя.');
define('TEXT_LAST_NAME', '{$LAST_NAME} - Только фамилия покупателя.');
define('TEXT_ORDER_NR', '{$ORDER_NR} - Номер заказа.');
define('TEXT_ORDER_TOTAL', '{$ORDER_TOTAL} - Сумма заказа.');
define('TEXT_ORDER_LINK', '{$ORDER_LINK} - Ссылка на страницу заказа.');
define('TEXT_ORDER_DATE', '{$ORDER_DATE} - Дата заказа.');
define('TEXT_ORDER_STATUS', '{$ORDER_STATUS} - Статус заказа.');
define('TEXT_DELIVERY_NAME', '{$DELIVERY_NAME} - Имя получателя заказа.');
define('TEXT_DELIVERY_STREET_ADDRESS', '{$DELIVERY_STREET_ADDRESS} - Адрес.');
define('TEXT_DELIVERY_CITY', '{$DELIVERY_CITY} - Город.');
define('TEXT_DELIVERY_POSTCODE', '{$DELIVERY_POSTCODE} - Почтовый индекс.');
define('TEXT_DELIVERY_STATE', '{$DELIVERY_STATE} - Регион.');
define('TEXT_DELIVERY_COUNTRY', '{$DELIVERY_COUNTRY} - Страна.');
define('TEXT_CUSTOMERS_TELEPHONE', '{$CUSTOMERS_TELEPHONE} - Телефон.');
define('TEXT_CUSTOMERS_EMAIL_ADDRESS', '{$CUSTOMERS_EMAIL_ADDRESS} - Email.');
define('TEXT_PAYMENT_METHOD', '{$PAYMENT_METHOD} - Способ оплаты.');
define('TEXT_SHIPPING_METHOD', '{$SHIPPING_METHOD} - Способ доставки.');

?>