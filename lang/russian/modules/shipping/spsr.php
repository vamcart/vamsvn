<?php
/* -----------------------------------------------------------------------------------------
   $Id: spsr.php 899 2010/05/29 13:24:46 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(spsr.php,v 1.6 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (spsr.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (spsr.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_SPSR_TEXT_TITLE', 'СПСР Экспресс');
define('MODULE_SHIPPING_SPSR_TEXT_DESCRIPTION', 'СПСР Экспресс');

define('MODULE_SHIPPING_SPSR_TEXT_NOTE','Доставка курьерской службой СПСР Экспресс.');

define('MODULE_SHIPPING_SPSR_STATUS_TITLE' , 'Разрешить модуль СПСР Экспресс');
define('MODULE_SHIPPING_SPSR_STATUS_DESC' , 'Вы хотите разрешить модульСПСР Экспресс?');
define('MODULE_SHIPPING_SPSR_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_SHIPPING_SPSR_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_SHIPPING_SPSR_FROM_CITY_TITLE' , 'Город отправителя');
define('MODULE_SHIPPING_SPSR_FROM_CITY_DESC' , 'Название города, откуда осуществляется отправка.');
define('MODULE_SHIPPING_SPSR_FROM_LOGIN_TITLE' , 'Логин');
define('MODULE_SHIPPING_SPSR_FROM_LOGIN_DESC' , 'Ваш логин на сайте спср, если есть.');
define('MODULE_SHIPPING_SPSR_FROM_PASS_TITLE' , 'Пароль');
define('MODULE_SHIPPING_SPSR_FROM_PASS}_DESC' , 'Ваш пароль на сайте спср, если есть.');
define('MODULE_SHIPPING_SPSR_DISABLE_CITIES_TITLE' , 'Отключить для городов');
define('MODULE_SHIPPING_SPSR_DISABLE_CITIES_DESC' , 'Города, для которых этот способ доставки не показывать, через запятую.');
define('MODULE_SHIPPING_SPSR_OWN_CITY_DELIVERY_TITLE' , 'Включить доставку по своему городу?');
define('MODULE_SHIPPING_SPSR_OWN_CITY_DELIVERY_DESC' , '');
define('MODULE_SHIPPING_SPSR_OWN_REGION_DELIVERY_TITLE' , 'Включить доставку по своему региону?');
define('MODULE_SHIPPING_SPSR_OWN_REGION_DELIVERY_DESC' , '');
define('MODULE_SHIPPING_SPSR_DEFAULT_SHIPPING_WEIGHT_TITLE' , 'Вес товара по умолчанию');
define('MODULE_SHIPPING_SPSR_DEFAULT_SHIPPING_WEIGHT_DESC' , 'Если вес товара не установлен, то используем вес по умолчанию.');
define('MODULE_SHIPPING_SPSR_NATURE_TITLE' , 'Вид отправления');
define('MODULE_SHIPPING_SPSR_NATURE_DESC' , 'Вид отправления (число):<br />1 - документы<br />2 - мобильные телефоны<br />3 - бытовая и оргтехника<br />4 - ценные бумаги<br />5 - ювелирные изделия<br />6 - косметика<br />7 - одежда и текстильные изд.<br />8 – другое<br />');
define('MODULE_SHIPPING_SPSR_DEBUG_TITLE' , 'Включить режим отладки');
define('MODULE_SHIPPING_SPSR_DEBUG_DESC' , 'Будет выводиться отладочная информация.');
define('MODULE_SHIPPING_SPSR_TAX_CLASS_TITLE' , 'Налог');
define('MODULE_SHIPPING_SPSR_TAX_CLASS_DESC' , 'Использовать налог.');
define('MODULE_SHIPPING_SPSR_ZONE_TITLE' , 'Зона');
define('MODULE_SHIPPING_SPSR_ZONE_DESC' , 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.');
define('MODULE_SHIPPING_SPSR_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_SHIPPING_SPSR_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
?>