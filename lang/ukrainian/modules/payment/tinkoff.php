<?php
/* -----------------------------------------------------------------------------------------
   $Id: webmoney_merchant.php 998 2009/05/07 13:24:46 VaM $

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

  define('MODULE_PAYMENT_TINKOFF_TEXT_TITLE', 'Тинькофф - Оплата карточкой');
  define('MODULE_PAYMENT_TINKOFF_TEXT_PUBLIC_TITLE', 'Тинькофф - Оплата карточкой');
  define('MODULE_PAYMENT_TINKOFF_TEXT_ADMIN_DESCRIPTION', 'Модуль Тинькофф - Оплата карточкой<br />Как правильно настроить модуль читайте <a href="http://blog.vamshop.ru/2020/04/17/%d0%b4%d0%be%d0%b1%d0%b0%d0%b2%d0%bb%d0%b5%d0%bd-%d0%bd%d0%be%d0%b2%d1%8b%d0%b9-%d0%bc%d0%be%d0%b4%d1%83%d0%bb%d1%8c-%d0%be%d0%bf%d0%bb%d0%b0%d1%82%d1%8b-%d1%82%d0%b8%d0%bd%d1%8c%d0%ba%d0%be%d1%84/" target="_blank"><u>здесь</u></a>.');
  define('MODULE_PAYMENT_TINKOFF_TEXT_DESCRIPTION', 'После нажатия кнопки Подтвердить заказ Вы перейдёте на сайт платёжной системы для оплаты заказа, после оплаты Ваш заказ будет выполнен.');

  define('MODULE_PAYMENT_TINKOFF_STATUS_TITLE' , 'Разрешить модуль Тинькофф');
  define('MODULE_PAYMENT_TINKOFF_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
  define('MODULE_PAYMENT_TINKOFF_ALLOWED_TITLE' , 'Разрешённые страны');
  define('MODULE_PAYMENT_TINKOFF_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
  define('MODULE_PAYMENT_TINKOFF_TERMINAL_KEY_TITLE' , 'Терминал:');
  define('MODULE_PAYMENT_TINKOFF_TERMINAL_KEY_DESC' , 'Укажите код Вашего терминала');
  define('MODULE_PAYMENT_TINKOFF_PASSWORD_TITLE' , 'Пароль:');
  define('MODULE_PAYMENT_TINKOFF_PASSWORD_DESC' , 'Укажите пароль Вашего терминала');

  define('MODULE_PAYMENT_TINKOFF_PAYMENT_ENABLED_TITLE' , 'Передавать данные для формирования чека');
  define('MODULE_PAYMENT_TINKOFF_PAYMENT_ENABLED_DESC' , '');
  define('MODULE_PAYMENT_TINKOFF_EMAIL_COMPANY_TITLE' , 'Email компании');
  define('MODULE_PAYMENT_TINKOFF_EMAIL_COMPANY_DESC' , '');
  define('MODULE_PAYMENT_TINKOFF_PAYMENT_TAXATION_TITLE' , 'Система налогообложения');
  define('MODULE_PAYMENT_TINKOFF_PAYMENT_TAXATION_DESC' , '');
  define('MODULE_PAYMENT_TINKOFF_PAYMENT_METHOD_TITLE' , 'Признак способа расчёта');
  define('MODULE_PAYMENT_TINKOFF_PAYMENT_METHOD_DESC' , '');
  define('MODULE_PAYMENT_TINKOFF_PAYMENT_OBJECT_TITLE' , 'Признак предмета расчёта');
  define('MODULE_PAYMENT_TINKOFF_PAYMENT_OBJECT_DESC' , '');
  define('MODULE_PAYMENT_TINKOFF_PAYMENT_SHIPPING_TITLE' , 'Налог для доставки');
  define('MODULE_PAYMENT_TINKOFF_PAYMENT_SHIPPING_DESC' , '');
  define('MODULE_PAYMENT_TINKOFF_PAYMENT_TAX_TITLE' , 'Налог для товара');
  define('MODULE_PAYMENT_TINKOFF_PAYMENT_TAX_DESC' , '');

  define('MODULE_PAYMENT_TINKOFF_SORT_ORDER_TITLE' , 'Порядок сортировки');
  define('MODULE_PAYMENT_TINKOFF_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
  define('MODULE_PAYMENT_TINKOFF_ZONE_TITLE' , 'Зона');
  define('MODULE_PAYMENT_TINKOFF_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
  define('MODULE_PAYMENT_TINKOFF_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
  define('MODULE_PAYMENT_TINKOFF_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');
  
?>