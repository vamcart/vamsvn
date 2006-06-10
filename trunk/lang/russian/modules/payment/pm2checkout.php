<?php
/* -----------------------------------------------------------------------------------------
   $Id: pm2checkout.php 998 2005-07-07 14:18:20Z VaM $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(pm2checkout.php,v 1.4 2002/11/01); www.oscommerce.com 
   (c) 2003	 nextcommerce (pm2checkout.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_TITLE', '2CheckOut');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_DESCRIPTION', 'Информация о кредитной карточке для теста:<br><br>Номер карточки: 4111111111111111<br>Действительна до: Любая дата');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_TYPE', 'Тип:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_OWNER', 'Владелец кредитной карточки:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_OWNER_FIRST_NAME', 'Имя владельца кредитной карточки:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_OWNER_LAST_NAME', 'Фамилия владельца кредитной карточки:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_NUMBER', 'Номер кредитной карточки:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_EXPIRES', 'Действительна до:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER', 'Контрольный номер кредитной карточки:');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_CREDIT_CARD_CHECKNUMBER_LOCATION', '(на обратной стороне кредитной карточки рядом с подписью)');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_JS_CC_NUMBER', '* Номер кредитной карточки должен быть по крайней мере ' . CC_NUMBER_MIN_LENGTH . ' символов.\n');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_ERROR_MESSAGE', 'Ошибка при обработке кредитной карточки. Попробуйте ввести данные снова.');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_ERROR', 'Credit Card Error!');
  define('MODULE_PAYMENT_PM2CHECKOUT_TEXT_INFO','');
  define('MODULE_PAYMENT_PM2CHECKOUT_STATUS_TITLE' , 'Enable 2CheckOut Module');
define('MODULE_PAYMENT_PM2CHECKOUT_STATUS_DESC' , 'Do you want to accept 2CheckOut payments?');
define('MODULE_PAYMENT_PM2CHECKOUT_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_PM2CHECKOUT_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_PM2CHECKOUT_LOGIN_TITLE' , 'Login/Store Number');
define('MODULE_PAYMENT_PM2CHECKOUT_LOGIN_DESC' , 'Login/Store Number used for the 2CheckOut service');
define('MODULE_PAYMENT_PM2CHECKOUT_TESTMODE_TITLE' , 'Transaction Mode');
define('MODULE_PAYMENT_PM2CHECKOUT_TESTMODE_DESC' , 'Transaction mode used for the 2Checkout service');
define('MODULE_PAYMENT_PM2CHECKOUT_EMAIL_MERCHANT_TITLE' , 'Merchant Notifications');
define('MODULE_PAYMENT_PM2CHECKOUT_EMAIL_MERCHANT_DESC' , 'Should 2CheckOut eMail a receipt to the store owner?');
define('MODULE_PAYMENT_PM2CHECKOUT_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_PM2CHECKOUT_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_PM2CHECKOUT_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_PM2CHECKOUT_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID_TITLE' , 'Статус заказа');
define('MODULE_PAYMENT_PM2CHECKOUT_ORDER_STATUS_ID_DESC' , 'Заказы, оформленные с использованием данного модуля оплаты будут принимать указанный статус.');
?>