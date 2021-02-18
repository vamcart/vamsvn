<?php
/* -----------------------------------------------------------------------------------------
   $Id: yoomoney_fizlico.php 998 2009/05/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneyorder.php,v 1.8 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (yoomoney_fizlico.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_TEXT_TITLE', 'ЮMoney - Оплата карточкой Visa, MasterCard, МИР');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_TEXT_PUBLIC_TITLE', 'ЮMoney - Оплата карточкой Visa, MasterCard, МИР');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_TEXT_ADMIN_DESCRIPTION', 'Модуль оплаты ЮMoney<br />Как правильно настроить модуль читайте <a href="https://blog.vamshop.ru/2021/02/18/%d0%bd%d0%be%d0%b2%d1%8b%d0%b9-%d0%bc%d0%be%d0%b4%d1%83%d0%bb%d1%8c-%d0%be%d0%bf%d0%bb%d0%b0%d1%82%d1%8b-%d1%8emoney/" target="_blank"><u>здесь</u></a>.');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_TEXT_DESCRIPTION', 'После нажатия кнопки Подтвердить заказ Вы перейдёте на сайт платёжной системы для оплаты заказа, после оплаты Ваш заказ будет выполнен.');
  
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_STATUS_TITLE' , 'Разрешить модуль ЮMoney');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_ALLOWED_TITLE' , 'Разрешённые страны');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_ID_TITLE' , 'Номер кошелька ЮMoney:');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_ID_DESC' , 'Укажите номер Вашего кошелька ЮMoney');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_SORT_ORDER_TITLE' , 'Порядок сортировки');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_ZONE_TITLE' , 'Зона');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_SECRET_KEY_TITLE' , 'Секретное слово');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_SECRET_KEY_DESC' , 'В данной опции укажите Секретное слово из настроек на сайте юmoney, необходимо для уведомлений и автоматический смены статуса заказа.');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
  define('MODULE_PAYMENT_YOOMONEY_FIZLICO_ORDER_STATUS_ID_DESC' , 'В случае успешной оплаты статус заказа будет автоматически изменён на указанный.');
  
?>