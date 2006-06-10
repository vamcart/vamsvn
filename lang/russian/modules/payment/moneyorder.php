<?php
/* -----------------------------------------------------------------------------------------
   $Id: moneyorder.php 998 2005-07-07 14:18:20Z VaM $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneyorder.php,v 1.8 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_MONEYORDER_TEXT_TITLE', 'Оплата чеком');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', 'Информация для оплаты:&nbsp;' . MODULE_PAYMENT_MONEYORDER_PAYTO . '<br />Почтовый адрес:<br /><br />' . nl2br(STORE_NAME_ADDRESS) . '<br /><br />' . 'Ваш заказ будет отправлен только после получения оплаты!');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', "Информация для оплаты: ". MODULE_PAYMENT_MONEYORDER_PAYTO . "\n\nПочтовый адрес:\n" . STORE_NAME_ADDRESS . "\n\n" . 'Ваш заказ будет отправлен только после получения оплаты!');
define('MODULE_PAYMENT_MONEYORDER_TEXT_INFO','');
  define('MODULE_PAYMENT_MONEYORDER_STATUS_TITLE' , 'Разрешить модуль Оплата чеком');
define('MODULE_PAYMENT_MONEYORDER_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_MONEYORDER_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_MONEYORDER_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_MONEYORDER_PAYTO_TITLE' , 'Информация для оплаты:');
define('MODULE_PAYMENT_MONEYORDER_PAYTO_DESC' , 'Кто должен получать оплату?');
define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_MONEYORDER_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_MONEYORDER_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_TITLE' , 'Статус заказа');
define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_DESC' , 'Заказы, оформленные с использованием данного модуля оплаты будут принимать указанный статус.');
?>
