<?php
/* -----------------------------------------------------------------------------------------
   $Id: kupivkredit.php 998 2009/05/07 13:24:46 VaM $

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

define('MODULE_PAYMENT_KUPIVKREDIT_TEXT_TITLE', 'КупиВкредит');
define('MODULE_PAYMENT_KUPIVKREDIT_TEXT_PUBLIC_TITLE', 'КупиВкредит');
define('MODULE_PAYMENT_KUPIVKREDIT_TEXT_ADMIN_DESCRIPTION', 'Модуль оплаты КупиВкредит.');
define('MODULE_PAYMENT_KUPIVKREDIT_TEXT_DESCRIPTION', '');

define('MODULE_PAYMENT_KUPIVKREDIT_STATUS_TITLE' , 'Разрешить модуль КупиВкредит');
define('MODULE_PAYMENT_KUPIVKREDIT_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_KUPIVKREDIT_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_KUPIVKREDIT_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_KUPIVKREDIT_ID_TITLE' , 'Идентификатор магазина:');
define('MODULE_PAYMENT_KUPIVKREDIT_ID_DESC' , 'Укажите идентификатор Вашего магазина в системе kupivkredit.ru.');
define('MODULE_PAYMENT_KUPIVKREDIT_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_KUPIVKREDIT_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_KUPIVKREDIT_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_KUPIVKREDIT_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_KUPIVKREDIT_SECRET_KEY_TITLE' , 'Секретная строка');
define('MODULE_PAYMENT_KUPIVKREDIT_SECRET_KEY_DESC' , 'В данной опции укажите значение опции секретная строка в системе kupivkredit.ru.');
define('MODULE_PAYMENT_KUPIVKREDIT_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
define('MODULE_PAYMENT_KUPIVKREDIT_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');
define('MODULE_PAYMENT_KUPIVKREDIT_TEST_TITLE','Режим работы');
define('MODULE_PAYMENT_KUPIVKREDIT_TEST_DESC','test - для тестирования работы модуля, production - для рабочего режима работы модуля.');
  
?>