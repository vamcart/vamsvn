<?php
/* -----------------------------------------------------------------------------------------
   $Id: boxberry.php 899 2009/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(boxberry.php,v 1.6 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (boxberry.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (boxberry.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_BOXBERRY_TEXT_TITLE', 'Boxberry');
define('MODULE_SHIPPING_BOXBERRY_TEXT_DESCRIPTION', 'Boxberry');

define('MODULE_SHIPPING_BOXBERRY_TEXT_SELECT_ADDRESS','Выбрать пункт выдачи на карте');
define('MODULE_SHIPPING_BOXBERRY_TEXT_ADDRESS_HELP','(откроется во всплывающем окне)');
define('MODULE_SHIPPING_BOXBERRY_TEXT_ADDRESS','Ваш заказ доставят в выбранный ПВЗ ');
define('MODULE_SHIPPING_BOXBERRY_TEXT_ANOTHER_ADDRESS','Выбрать другой адрес');

define('MODULE_SHIPPING_BOXBERRY_TEXT_WAY', 'Заказ будет доставлен в выбранный пункт выдачи');

define('MODULE_SHIPPING_BOXBERRY_STATUS_TITLE' , 'Разрешить модуль boxberry');
define('MODULE_SHIPPING_BOXBERRY_STATUS_DESC' , 'Вы хотите разрешить модуль boxberry?');
define('MODULE_SHIPPING_BOXBERRY_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_SHIPPING_BOXBERRY_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_SHIPPING_BOXBERRY_COST_TITLE' , 'Стоимость доставки');
define('MODULE_SHIPPING_BOXBERRY_COST_DESC' , 'Стоимость доставки данным способом.');
define('MODULE_SHIPPING_BOXBERRY_TAX_CLASS_TITLE' , 'Налог');
define('MODULE_SHIPPING_BOXBERRY_TAX_CLASS_DESC' , 'Использовать налог.');
define('MODULE_SHIPPING_BOXBERRY_ZONE_TITLE' , 'Зона');
define('MODULE_SHIPPING_BOXBERRY_ZONE_DESC' , 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.');
define('MODULE_SHIPPING_BOXBERRY_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_SHIPPING_BOXBERRY_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_SHIPPING_BOXBERRY_TOKEN_TITLE' , 'Boxberry токен');
define('MODULE_SHIPPING_BOXBERRY_TOKEN_DESC' , 'Укажите ваш токен (API ключ).');

?>