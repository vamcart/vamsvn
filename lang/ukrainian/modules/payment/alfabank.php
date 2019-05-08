<?php
/* -----------------------------------------------------------------------------------------
   $Id: alfabank.php 998 2009/02/07 13:24:46 VaM $

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

  define('MODULE_PAYMENT_ALFABANK_TEXT_TITLE', 'Альфа-Банк - Оплата карточкой');
  define('MODULE_PAYMENT_ALFABANK_TEXT_PUBLIC_TITLE', 'Альфа-Банк - Оплата карточкой');
  define('MODULE_PAYMENT_ALFABANK_TEXT_DESCRIPTION', 'После нажатия кнопки Подтвердить заказ Вы перейдёте на сайт платёжной системы для оплаты заказа, после оплаты Ваш заказ будет выполнен.');
  define('MODULE_PAYMENT_ALFABANK_TEXT_ADMIN_DESCRIPTION', 'Модуль оплаты Альфа-Банк.');
  
define('MODULE_PAYMENT_ALFABANK_STATUS_TITLE' , 'Разрешить модуль Альфа-Банк');
define('MODULE_PAYMENT_ALFABANK_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_ALFABANK_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_ALFABANK_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_ALFABANK_API_LOGIN_TITLE' , 'API логин:');
define('MODULE_PAYMENT_ALFABANK_API_LOGIN_DESC' , 'Ваш логин.');
define('MODULE_PAYMENT_ALFABANK_API_PASS_TITLE' , 'API пароль:');
define('MODULE_PAYMENT_ALFABANK_API_PASS_DESC' , 'Ваш пароль.');
define('MODULE_PAYMENT_ALFABANK_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_ALFABANK_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_ALFABANK_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_ALFABANK_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_ALFABANK_TEST_TITLE','Режим работы');
define('MODULE_PAYMENT_ALFABANK_TEST_DESC','test - для тестирования работы модуля, production - для полноценного приёма оплаты.');
define('MODULE_PAYMENT_ALFABANK_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
define('MODULE_PAYMENT_ALFABANK_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');
  
?>