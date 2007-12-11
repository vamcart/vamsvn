<?php
/* -----------------------------------------------------------------------------------------
   $Id: selfpickup.php 899 2007/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce( freeamount.php,v 1.01 2002/01/24 03:25:00); www.oscommerce.com 
   (c) 2003	 nextcommerce (freeamount.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (selfpickup.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   selfpickup         	Autor:	sebthom

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_SELFPICKUP_TEXT_TITLE', 'Самовывоз');
define('MODULE_SHIPPING_SELFPICKUP_TEXT_DESCRIPTION', 'Покупатель сам забирает свой заказ');
define('MODULE_SHIPPING_SELFPICKUP_SORT_ORDER', 'Порядок сортировки');

define('MODULE_SHIPPING_SELFPICKUP_TEXT_TITLE', 'Самовывоз');
define('MODULE_SHIPPING_SELFPICKUP_TEXT_WAY', 'Покупатель сам забирает свой заказ');
define('MODULE_SHIPPING_SELFPICKUP_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_SHIPPING_SELFPICKUP_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_SHIPPING_SELFPICKUP_STATUS_TITLE', 'Разрешить модуль самовывоз');
define('MODULE_SHIPPING_SELFPICKUP_STATUS_DESC', 'Вы хотите разрешить модуль самовывоз?');
define('MODULE_SHIPPING_SELFPICKUP_TAX_CLASS_TITLE' , 'Налог');
define('MODULE_SHIPPING_SELFPICKUP_TAX_CLASS_DESC' , 'Использовать налог.');
define('MODULE_SHIPPING_SELFPICKUP_ZONE_TITLE' , 'Зона');
define('MODULE_SHIPPING_SELFPICKUP_ZONE_DESC' , 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.');
define('MODULE_SHIPPING_SELFPICKUP_SORT_ORDER_TITLE', 'Порядок сортировки');
define('MODULE_SHIPPING_SELFPICKUP_SORT_ORDER_DESC', 'Порядок сортировки модуля.');
?>