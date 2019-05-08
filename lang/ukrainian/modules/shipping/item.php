<?php
/* -----------------------------------------------------------------------------------------
   $Id: item.php 899 2007/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(item.php,v 1.6 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (item.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (item.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_ITEM_TEXT_TITLE', 'На единицу');
define('MODULE_SHIPPING_ITEM_TEXT_DESCRIPTION', 'На единицу');
define('MODULE_SHIPPING_ITEM_TEXT_WAY', 'Лучший маршрут');

define('MODULE_SHIPPING_ITEM_STATUS_TITLE' , 'Разрешить модуль на единицу');
define('MODULE_SHIPPING_ITEM_STATUS_DESC' , 'Вы хотите разрешить модуль на единицу?');
define('MODULE_SHIPPING_ITEM_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_SHIPPING_ITEM_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_SHIPPING_ITEM_COST_TITLE' , 'Стоимость доставки');
define('MODULE_SHIPPING_ITEM_COST_DESC' , 'Стоимость доставки будет умножена на количество единиц товара в заказе.');
define('MODULE_SHIPPING_ITEM_HANDLING_TITLE' , 'Стоимость использования данного модуля');
define('MODULE_SHIPPING_ITEM_HANDLING_DESC' , 'Стоимость использования данного способа доставки.');
define('MODULE_SHIPPING_ITEM_TAX_CLASS_TITLE' , 'Налог');
define('MODULE_SHIPPING_ITEM_TAX_CLASS_DESC' , 'Использовать налог.');
define('MODULE_SHIPPING_ITEM_ZONE_TITLE' , 'Зона');
define('MODULE_SHIPPING_ITEM_ZONE_DESC' , 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.');
define('MODULE_SHIPPING_ITEM_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_SHIPPING_ITEM_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
?>