<?php
/* -----------------------------------------------------------------------------------------
   $Id: prochange_merchant.php 998 2009/02/07 13:24:46 VaM $

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

  define('MODULE_PAYMENT_PROCHANGE_MERCHANT_TEXT_TITLE', 'Яндекс-деньги (Через ЯД Мерчант)');
  define('MODULE_PAYMENT_PROCHANGE_MERCHANT_TEXT_PUBLIC_TITLE', 'Яндекс-деньги (Через ЯД Мерчант)');
  define('MODULE_PAYMENT_PROCHANGE_MERCHANT_TEXT_DESCRIPTION', 'После нажатия кнопки Подтвердить заказ Вы перейдёте на сайт платёжной системы для оплаты заказа, после оплаты Ваш заказ будет выполнен.');
  define('MODULE_PAYMENT_PROCHANGE_MERCHANT_TEXT_ADMIN_DESCRIPTION', 'Модуль оплаты Яндекс-деньги (Через ЯД Мерчант)<br />Как правильно настроить модуль читайте <a href="http://vamshop.ru/faq.php/faq_id/71/question/Nastroika-modulya-oplaty-Yandeks-Dengi--YaD-Merchant-" target="_blank"><u>здесь</u></a>.');
  
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_STATUS_TITLE' , 'Разрешить модуль Яндекс-деньги');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_PRO_CLIENT_TITLE' , 'Идентификатор клиента №1:');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_PRO_CLIENT_DESC' , 'Укажите Ваш идентификатор номер 1. Присваивается после регистрации на http://www.prochange.ru/merchant.html');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_PRO_RA_TITLE' , 'Идентификатор клиента №2:');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_PRO_RA_DESC' , 'Укажите Ваш идентификатор номер 2. Присваивается после регистрации на http://www.prochange.ru/merchant.html');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_SECRET_KEY_TITLE' , 'Секретный ключ');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_SECRET_KEY_DESC' , 'В данной опции укажите Ваш ключ, указанный в опции Секретный ключ на сайте ЯД Мерчант (http://prochange.ru/merchant.html).');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
define('MODULE_PAYMENT_PROCHANGE_MERCHANT_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');
  
?>