<?php
/* -----------------------------------------------------------------------------------------
   $Id: enot.php 998 2009/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneyorder.php,v 1.8 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (webmoney.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_ENOT_TEXT_TITLE', 'Enot (Visa, MasterCard, МИР)');
define('MODULE_PAYMENT_ENOT_TEXT_PUBLIC_TITLE', 'Enot (Visa, MasterCard, МИР)');
define('MODULE_PAYMENT_ENOT_TEXT_DESCRIPTION', '');
define('MODULE_PAYMENT_ENOT_TEXT_ADMIN_DESCRIPTION', 'Модуль приёма оплаты Enot для физ. лиц.');
  
define('MODULE_PAYMENT_ENOT_STATUS_TITLE' , 'Разрешить модуль Enot');
define('MODULE_PAYMENT_ENOT_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_ENOT_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_ENOT_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_ENOT_SHOP_ID_TITLE' , 'ID номер магазина');
define('MODULE_PAYMENT_ENOT_SHOP_ID_DESC' , 'Укажите Ваш ID номер магазина в enot.io.');
define('MODULE_PAYMENT_ENOT_SECRET_KEY_TITLE' , 'Секретный пароль');
define('MODULE_PAYMENT_ENOT_SECRET_KEY_DESC' , 'В данной опции укажите Секретный пароль.');
define('MODULE_PAYMENT_ENOT_SECRET_KEY2_TITLE' , 'Дополнительный пароль');
define('MODULE_PAYMENT_ENOT_SECRET_KEY2_DESC' , 'В данной опции укажите значение опции Дополнительный пароль в системе enot.io.');
define('MODULE_PAYMENT_ENOT_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_ENOT_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_ENOT_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_ENOT_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_ENOT_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
define('MODULE_PAYMENT_ENOT_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');
  
?>