<?php
/* -----------------------------------------------------------------------------------------
  $Id: lendshop.php 1310 2010-07-12 19:20:03 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2010 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneyorder.php,v 1.8 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (webmoney.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_LENDSHOP_TEXT_TITLE', 'LendShop.Ru');
  define('MODULE_PAYMENT_LENDSHOP_TEXT_PUBLIC_TITLE', 'LendShop.Ru');
  define('MODULE_PAYMENT_LENDSHOP_TEXT_ADMIN_DESCRIPTION', 'Модуль оплаты LendShop.Ru.');
  define('MODULE_PAYMENT_LENDSHOP_TEXT_DESCRIPTION', 'После нажатия кнопки Подтвердить заказ Вы перейдёте на сайт платёжной системы для оплаты заказа, после оплаты Ваш заказ будет выполнен.');
  
define('MODULE_PAYMENT_LENDSHOP_STATUS_TITLE' , 'Разрешить модуль LendShop.Ru');
define('MODULE_PAYMENT_LENDSHOP_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_LENDSHOP_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_LENDSHOP_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_LENDSHOP_ID_TITLE' , 'LendShop ID:');
define('MODULE_PAYMENT_LENDSHOP_ID_DESC' , 'Укажите Ваш LendShop ID');
define('MODULE_PAYMENT_LENDSHOP_WMR_TITLE' , 'Ваш WMR кошелёк:');
define('MODULE_PAYMENT_LENDSHOP_WMR_DESC' , 'Укажите номер Вашего WMR кошелька');
define('MODULE_PAYMENT_LENDSHOP_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_LENDSHOP_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_LENDSHOP_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_LENDSHOP_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_LENDSHOP_SECRET_KEY_TITLE' , 'Секретный ключ');
define('MODULE_PAYMENT_LENDSHOP_SECRET_KEY_DESC' , 'В данной опции укажите Ваш ключ, указанный в опции Secret Key.');
define('MODULE_PAYMENT_LENDSHOP_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
define('MODULE_PAYMENT_LENDSHOP_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');
  
?>