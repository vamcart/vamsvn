<?php
/* -----------------------------------------------------------------------------------------
   $Id: webpay.php 998 2011/02/07 13:24:47 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2011 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2005	 Vetal metashop.ru

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_WEBPAY_TEXT_TITLE', 'WebPay.By');
  define('MODULE_PAYMENT_WEBPAY_TEXT_DESCRIPTION', 'WebPay.By');
  
  define('MODULE_PAYMENT_WEBPAY_STATUS_TITLE','Разрешить модуль webpay');
  define('MODULE_PAYMENT_WEBPAY_STATUS_DESC','');
  define('MODULE_PAYMENT_WEBPAY_ALLOWED_TITLE' , 'Разрешённые страны');
  define('MODULE_PAYMENT_WEBPAY_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
  define('MODULE_PAYMENT_WEBPAY_LOGIN_TITLE','ID номер магазина');
  define('MODULE_PAYMENT_WEBPAY_LOGIN_DESC','Ваш идентификатор магазина в системе webpay');
  define('MODULE_PAYMENT_WEBPAY_SECRET_KEY_TITLE','Секретный ключ');
  define('MODULE_PAYMENT_WEBPAY_SECRET_KEY_DESC','Укажите свой секретный ключ в системе webpay');
  define('MODULE_PAYMENT_WEBPAY_SORT_ORDER_TITLE','Порядок сортировки');
  define('MODULE_PAYMENT_WEBPAY_SORT_ORDER_DESC','Порядок сортировки модуля.');
  define('MODULE_PAYMENT_WEBPAY_ORDER_STATUS_ID_TITLE','Статус оплаченного заказа');
  define('MODULE_PAYMENT_WEBPAY_ORDER_STATUS_ID_DESC','Статус, устанавливаемый заказу после успешной оплаты');
  define('MODULE_PAYMENT_WEBPAY_ZONE_TITLE' , 'Зона');
  define('MODULE_PAYMENT_WEBPAY_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');

  define('MODULE_PAYMENT_WEBPAY_TEST_TITLE','Режим работы');
  define('MODULE_PAYMENT_WEBPAY_TEST_DESC','test - для тестирования работы модуля, production - для полноценного приёма оплаты.');
  
?>