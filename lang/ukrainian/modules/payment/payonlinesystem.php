<?php
/*------------------------------------------------------------------------------
  $Id: payonlinesystem.php 1310 2010-06-19 19:20:03 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2010 VaMSoft Ltd.
  -----------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneyorder.php,v 1.8 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (webmoney.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_PAYONLINESYSTEM_TEXT_TITLE', 'PayOnline System (Visa, Mastercard)');
define('MODULE_PAYMENT_PAYONLINESYSTEM_TEXT_PUBLIC_TITLE', 'PayOnline System (Visa, Mastercard)');
define('MODULE_PAYMENT_PAYONLINESYSTEM_TEXT_ADMIN_DESCRIPTION', 'Модуль оплаты PayOnline System<br />Как правильно настроить модуль читайте <a href="http://vamshop.ru/blog/2010/06/19/подключаем-vam-shop-к-payonlinesytem-ru/" target="_blank"><u>здесь</u></a>.');
define('MODULE_PAYMENT_PAYONLINESYSTEM_TEXT_DESCRIPTION', 'После нажатия кнопки Подтвердить заказ Вы перейдёте на сайт платёжной системы для оплаты заказа, после оплаты Ваш заказ будет выполнен.');
  
define('MODULE_PAYMENT_PAYONLINESYSTEM_STATUS_TITLE' , 'Разрешить модуль PayOnline System');
define('MODULE_PAYMENT_PAYONLINESYSTEM_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_PAYONLINESYSTEM_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_PAYONLINESYSTEM_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_PAYONLINESYSTEM_ID_TITLE' , 'Merchant ID:');
define('MODULE_PAYMENT_PAYONLINESYSTEM_ID_DESC' , 'Укажите Ваш Merchant ID');
define('MODULE_PAYMENT_PAYONLINESYSTEM_SECRET_KEY_TITLE' , 'Секретный ключ');
define('MODULE_PAYMENT_PAYONLINESYSTEM_SECRET_KEY_DESC' , 'В данной опции укажите Ваш секретный ключ.');
define('MODULE_PAYMENT_PAYONLINESYSTEM_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_PAYONLINESYSTEM_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_PAYONLINESYSTEM_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_PAYONLINESYSTEM_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_PAYONLINESYSTEM_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
define('MODULE_PAYMENT_PAYONLINESYSTEM_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');
  
?>