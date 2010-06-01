<?php
/* -----------------------------------------------------------------------------------------
   $Id: onpay.php 998 2010/06/01 13:24:46 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2010 VaM Soft Ltd.
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneyorder.php,v 1.8 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (webmoney.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_ONPAY_TEXT_TITLE', 'OnPay');
  define('MODULE_PAYMENT_ONPAY_TEXT_PUBLIC_TITLE', 'OnPay');
  define('MODULE_PAYMENT_ONPAY_TEXT_ADMIN_DESCRIPTION', 'Модуль оплаты OnPay<br />Как правильно настроить модуль читайте <a href="http://vamshop.ru/faq.php/faq_id/70/question/Nastroika-modulya-oplaty-OnPay-Merchant" target="_blank"><u>здесь</u></a>.');
  define('MODULE_PAYMENT_ONPAY_TEXT_DESCRIPTION', 'После нажатия кнопки Подтвердить заказ Вы перейдёте на сайт платёжной системы для оплаты заказа, после оплаты Ваш заказ будет выполнен.');
  
	define('MODULE_PAYMENT_ONPAY_STATUS_TITLE' , 'Разрешить модуль OnPay');
	define('MODULE_PAYMENT_ONPAY_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
	define('MODULE_PAYMENT_ONPAY_ALLOWED_TITLE' , 'Разрешённые страны');
	define('MODULE_PAYMENT_ONPAY_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
	define('MODULE_PAYMENT_ONPAY_ID_TITLE' , 'Имя пользователя OnPay:');
	define('MODULE_PAYMENT_ONPAY_ID_DESC' , 'Ваш логин в системе OnPay');
	define('MODULE_PAYMENT_ONPAY_SORT_ORDER_TITLE' , 'Порядок сортировки');
	define('MODULE_PAYMENT_ONPAY_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
	define('MODULE_PAYMENT_ONPAY_ZONE_TITLE' , 'Зона');
	define('MODULE_PAYMENT_ONPAY_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
	define('MODULE_PAYMENT_ONPAY_SECRET_KEY_TITLE' , 'Пароль API IN');
	define('MODULE_PAYMENT_ONPAY_SECRET_KEY_DESC' , 'Ваш API IN (секретный ключ) в системе OnPay.');
	define('MODULE_PAYMENT_ONPAY_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
	define('MODULE_PAYMENT_ONPAY_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');
  
?>