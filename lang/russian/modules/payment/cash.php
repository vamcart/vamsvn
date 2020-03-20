<?php
/* -----------------------------------------------------------------------------------------
   $Id: cash.php 1102 2007/04/24 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cod.php,v 1.28 2003/02/14); www.oscommerce.com
   (c) 2003	 nextcommerce (invoice.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (invoice.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_CASH_TEXT_DESCRIPTION', 'Оплата наличными при получении');
define('MODULE_PAYMENT_CASH_TEXT_TITLE', 'Оплата наличными при получении');
define('MODULE_PAYMENT_CASH_TEXT_INFO', '');
define('MODULE_PAYMENT_CASH_STATUS_TITLE', 'Разрешить модуль Оплата наличными');
define('MODULE_PAYMENT_CASH_STATUS_DESC', 'Вы хотите разрешить использование модуля при оформлении заказов?<br />Модуль будет доступен при оформлении заказа только если на странице выбора доставки был выбран модуль доставки самовывоз.');
define('MODULE_PAYMENT_CASH_ORDER_STATUS_ID_TITLE', 'Статус заказа');
define('MODULE_PAYMENT_CASH_ORDER_STATUS_ID_DESC', 'Заказы, оформленные с использованием данного модуля оплаты будут принимать указанный статус.');
define('MODULE_PAYMENT_CASH_SORT_ORDER_TITLE', 'Порядок сортировки');
define('MODULE_PAYMENT_CASH_SORT_ORDER_DESC', 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_CASH_ZONE_TITLE', 'Зона');
define('MODULE_PAYMENT_CASH_ZONE_DESC', 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_CASH_ALLOWED_TITLE', 'Разрешённые страны');
define('MODULE_PAYMENT_CASH_ALLOWED_DESC', 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
?>