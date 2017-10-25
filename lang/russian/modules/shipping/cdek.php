<?php
/* -----------------------------------------------------------------------------------------
   $Id: flat.php 899 2009/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(flat.php,v 1.6 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (flat.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (flat.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_CDEK_TEXT_TITLE', 'СДЭК');
define('MODULE_SHIPPING_CDEK_TEXT_DESCRIPTION', 'СДЭК. Расчёт доставки СДЭК с помощью API СДЭК.');

define('MODULE_SHIPPING_CDEK_STATUS_TITLE' , 'Разрешить модуль СДЭК');
define('MODULE_SHIPPING_CDEK_STATUS_DESC' , 'Вы хотите разрешить модуль СДЭК?');
define('MODULE_SHIPPING_CDEK_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_SHIPPING_CDEK_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_SHIPPING_CDEK_COST_TITLE' , 'Стоимость доставки');
define('MODULE_SHIPPING_CDEK_COST_DESC' , 'Стоимость доставки данным способом.');
define('MODULE_SHIPPING_CDEK_API_KEY_TITLE' , 'API Ключ');
define('MODULE_SHIPPING_CDEK_API_KEY_DESC' , 'Ваш API Ключ СДЭК');
define('MODULE_SHIPPING_CDEK_API_PASSWORD_TITLE' , 'API Пароль');
define('MODULE_SHIPPING_CDEK_API_PASSWORD_DESC' , 'Ваш API Пароль СДЭК');
define('MODULE_SHIPPING_CDEK_SENDER_CITY_TITLE' , 'Город отправителя');
define('MODULE_SHIPPING_CDEK_SENDER_CITY_DESC' , 'Укажите город отправителя.');
define('MODULE_SHIPPING_CDEK_TAX_CLASS_TITLE' , 'Налог');
define('MODULE_SHIPPING_CDEK_TAX_CLASS_DESC' , 'Использовать налог.');
define('MODULE_SHIPPING_CDEK_ZONE_TITLE' , 'Зона');
define('MODULE_SHIPPING_CDEK_ZONE_DESC' , 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.');
define('MODULE_SHIPPING_CDEK_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_SHIPPING_CDEK_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
?>