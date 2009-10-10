<?php
/* -----------------------------------------------------------------------------------------
   $Id: freeamount.php 1288 2007/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce( freeamount.php,v 1.01 2002/01/24 03:25:00); www.oscommerce.com 
   (c) 2003	 nextcommerce (freeamount.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (freeamount.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   freeamountv2-p1         	Autor:	dwk

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_FREEAMOUNT_TEXT_TITLE', 'Бесплатная доставка');
define('MODULE_SHIPPING_FREEAMOUNT_TEXT_DESCRIPTION', 'Модуль бесплатной доставки');
define('MODULE_SHIPPING_FREEAMOUNT_TEXT_WAY', 'Бесплатная доставка для заказов свыше: %s');
define('MODULE_SHIPPING_FREEAMOUNT_SORT_ORDER', 'Порядок сортировки');

define('MODULE_SHIPPING_FREEAMOUNT_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_SHIPPING_FREEAMOUNT_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_SHIPPING_FREEAMOUNT_STATUS_TITLE' , 'Разрешить бесплатную доставку');
define('MODULE_SHIPPING_FREEAMOUNT_STATUS_DESC' , 'Вы хотите разрешить модуль бесплатная доставка?');
define('MODULE_SHIPPING_FREEAMOUNT_DISPLAY_TITLE' , 'Показывать уведомление о бесплатной доставке');
define('MODULE_SHIPPING_FREEAMOUNT_DISPLAY_DESC' , 'Показывать текст уведомления о возможной бесплатной доставки заказа при достижении определённой суммы заказа?');
define('MODULE_SHIPPING_FREEAMOUNT_AMOUNT_TITLE' , 'Минимальная сумма заказа');
define('MODULE_SHIPPING_FREEAMOUNT_AMOUNT_DESC' , 'Минимальная сумма заказа для бесплатной доставки.');
define('MODULE_SHIPPING_FREEAMOUNT_TAX_CLASS_TITLE' , 'Налог');
define('MODULE_SHIPPING_FREEAMOUNT_TAX_CLASS_DESC' , 'Использовать налог.');
define('MODULE_SHIPPING_FREEAMOUNT_ZONE_TITLE' , 'Зона');
define('MODULE_SHIPPING_FREEAMOUNT_ZONE_DESC' , 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.');
define('MODULE_SHIPPING_FREEAMOUNT_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_SHIPPING_FREEAMOUNT_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
?>