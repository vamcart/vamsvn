<?php
/* -----------------------------------------------------------------------------------------
   $Id: psigate.php 998 2005-07-07 14:18:20Z VaM $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(psigate.php,v 1.3 2002/11/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (psigate.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_PSIGATE_TEXT_TITLE', 'PSiGate');
  define('MODULE_PAYMENT_PSIGATE_TEXT_DESCRIPTION', 'Информация о кредитной карточке для теста:<br><br>Номер карточки: 4111111111111111<br>Действительна до: Любая дата');
  define('MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_OWNER', 'Владелец кредитной карточки:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_NUMBER', 'Номер кредитной карточки:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_CREDIT_CARD_EXPIRES', 'Действительна до:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_TYPE', 'Тип:');
  define('MODULE_PAYMENT_PSIGATE_TEXT_JS_CC_NUMBER', '* Номер кредитной карточки должен быть по крайней мере ' . CC_NUMBER_MIN_LENGTH . ' символов.\n');
  define('MODULE_PAYMENT_PSIGATE_TEXT_ERROR_MESSAGE', 'Ошибка при обработке Вашей кредитной карточки, пожалуйста, попытайтесь снова.');
  define('MODULE_PAYMENT_PSIGATE_TEXT_ERROR', 'Credit Card Error!');
define('MODULE_PAYMENT_PSIGATE_TEXT_INFO','');
  define('MODULE_PAYMENT_PSIGATE_STATUS_TITLE' , 'Enable PSiGate Module');
define('MODULE_PAYMENT_PSIGATE_STATUS_DESC' , 'Do you want to accept PSiGate payments?');
define('MODULE_PAYMENT_PSIGATE_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_PSIGATE_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_PSIGATE_MERCHANT_ID_TITLE' , 'Merchant ID');
define('MODULE_PAYMENT_PSIGATE_MERCHANT_ID_DESC' , 'Merchant ID used for the PSiGate service');
define('MODULE_PAYMENT_PSIGATE_TRANSACTION_MODE_TITLE' , 'Transaction Mode');
define('MODULE_PAYMENT_PSIGATE_TRANSACTION_MODE_DESC' , 'Transaction mode to use for the PSiGate service');
define('MODULE_PAYMENT_PSIGATE_TRANSACTION_TYPE_TITLE' , 'Transaction Type');
define('MODULE_PAYMENT_PSIGATE_TRANSACTION_TYPE_DESC' , 'Transaction type to use for the PSiGate service');
define('MODULE_PAYMENT_PSIGATE_INPUT_MODE_TITLE' , 'Credit Card Collection');
define('MODULE_PAYMENT_PSIGATE_INPUT_MODE_DESC' , 'Should the credit card details be collected locally or remotely at PSiGate?');
define('MODULE_PAYMENT_PSIGATE_CURRENCY_TITLE' , 'Transaction Currency');
define('MODULE_PAYMENT_PSIGATE_CURRENCY_DESC' , 'The currency to use for credit card transactions');
define('MODULE_PAYMENT_PSIGATE_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_PSIGATE_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_PSIGATE_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_PSIGATE_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_PSIGATE_ORDER_STATUS_ID_TITLE' , 'Статус заказа');
define('MODULE_PAYMENT_PSIGATE_ORDER_STATUS_ID_DESC' , 'Заказы, оформленные с использованием данного модуля оплаты будут принимать указанный статус.');
?>
