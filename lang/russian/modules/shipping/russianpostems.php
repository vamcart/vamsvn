<?php
/* -----------------------------------------------------------------------------------------
   $Id: russianpostems.php 899 2010/05/29 13:24:46 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(russianpostems.php,v 1.6 2003/02/16); www.oscommerce.com
   (c) 2003	 nextcommerce (russianpostems.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (russianpostems.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_RUSSIANPOSTEMS_TEXT_TITLE', 'EMS Почта России');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_TEXT_DESCRIPTION', 'EMS Почта России');

define('MODULE_SHIPPING_RUSSIANPOSTEMS_TEXT_NOTE','Доставка курьерской службой EMS Почта России.');

define('MODULE_SHIPPING_RUSSIANPOSTEMS_STATUS_TITLE' , 'Разрешить модуль на единицу');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_STATUS_DESC' , 'Вы хотите разрешить модуль на единицу?');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_CITY_TITLE' , 'Почтовый индекс места отправки');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_CITY_DESC' , 'Почтовый индекс места отправки посылок.');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_HANDLING_TITLE' , 'Стоимость использования данного модуля');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_HANDLING_DESC' , 'Стоимость использования данного способа доставки.');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_TAX_CLASS_TITLE' , 'Налог');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_TAX_CLASS_DESC' , 'Использовать налог.');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_ZONE_TITLE' , 'Зона');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_ZONE_DESC' , 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_DCVAL_PERCENT_TITLE' , 'Процентная ставка для объявленной ценности.');
define('MODULE_SHIPPING_RUSSIANPOSTEMS_DCVAL_PERCENT_DESC' , '0 - не учитывать, 1-100 - текущая процентная ставка из расчета суммы заказа');
?>
