<?php
/*

$Id: assist.php,v 1.0 2006/01/15 15:10:00 mbs Exp $

  Released under the GNU General Public License

*/

define('MODULE_PAYMENT_ASSIST_TEXT_TITLE', 'Оплата кредитной карточкой через Assist.Ru');
define('MODULE_PAYMENT_ASSIST_TEXT_DESCRIPTION', 'Кредитная карта через Assist');
define('MODULE_PAYMENT_ASSIST_TEXT_ERROR_MESSAGE', 'Assist Payment Error.'); 
define('MODULE_PAYMENT_ASSIST_LANGUAGE', '0'); // код русского языка
define('MODULE_PAYMENT_ASSIST_COMMENT', 'Оплата заказа: '); 
define('MODULE_PAYMENT_ASSIST_URL', 'http://secure.assist.ru/shops/purchase.cfm'); 

define('MODULE_PAYMENT_ASSIST_STATUS_TITLE','Разрешить модуль оплаты Ассист');define('MODULE_PAYMENT_ASSIST_STATUS_DESC','Разрешить оплату заказов через assist.ru?');define('MODULE_PAYMENT_ASSIST_ALLOWED_TITLE','Разрешённые страны');define('MODULE_PAYMENT_ASSIST_ALLOWED_DESC','Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');define('MODULE_PAYMENT_ASSIST_SHOP_IDP_TITLE','ID номер магазина');define('MODULE_PAYMENT_ASSIST_SHOP_IDP_DESC','Укажите номер своего магазина в системе ассист (Shop_IDP).');define('MODULE_PAYMENT_ASSIST_SHOP_MODE_TITLE','Режим работы');define('MODULE_PAYMENT_ASSIST_SHOP_MODE_DESC','Выберите режим работы с ассист.');define('MODULE_PAYMENT_ASSIST_ZONE_TITLE','Зона');define('MODULE_PAYMENT_ASSIST_ZONE_DESC','Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');define('MODULE_PAYMENT_ASSIST_SORT_ORDER_TITLE','Порядок сортировки');define('MODULE_PAYMENT_ASSIST_SORT_ORDER_DESC','Порядок сортировки модуля.');define('MODULE_PAYMENT_ASSIST_ORDER_STATUS_ID_TITLE','Статус заказа');define('MODULE_PAYMENT_ASSIST_ORDER_STATUS_ID_DESC','Заказы, оформленные с использованием данного модуля оплаты будут принимать указанный статус.');
?>