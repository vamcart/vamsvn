<?php
/* -----------------------------------------------------------------------------------------

VaM Shop - open source ecommerce solution
http://vamshop.ru
http://vamshop.com

Copyright (c) 2011 VaM Shop
-----------------------------------------------------------------------------------------
based on: 
(c) 2005	 Vetal metashop.ru

Released under the GNU General Public License 
---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_PLATRON_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_PLATRON_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_PLATRON_TEXT_ERROR_MESSAGE', 'Platron Payment Error.');

define('MODULE_PAYMENT_PLATRON_TEXT_TITLE', 'Платрон (более 20 методов оплаты)');
define('MODULE_PAYMENT_PLATRON_TEXT_DESCRIPTION', 'Платрон (более 20 методов оплаты)');

define('MODULE_PAYMENT_PLATRON_STATUS_TITLE','Разрешить модуль platron');
define('MODULE_PAYMENT_PLATRON_STATUS_DESC','Заполните необходимые данные в вашей админке после регистрации на www.platron.ru<br/> Включить модуль Платрон');

define('MODULE_PAYMENT_PLATRON_MERCHANT_ID_TITLE','Номер магазина');
define('MODULE_PAYMENT_PLATRON_MERCHANT_ID_DESC','Номер магазина можно найти в настройках магазина на сайте <a href="https://platron.ru/admin/merchants.php">platron</a>');

define('MODULE_PAYMENT_PLATRON_SECRET_KEY_TITLE','Секретный ключ');
define('MODULE_PAYMENT_PLATRON_SECRET_KEY_DESC','Секретный ключ, который будет использован для подписи запросов. Ищите в настройках магазина на сайте <a href="https://platron.ru/admin/merchants.php">platron</a>');

define('MODULE_PAYMENT_PLATRON_LIFETIME_TITLE','Время жизни счета');
define('MODULE_PAYMENT_PLATRON_LIFETIME_DESC','Указывается в минутах от 5 мин до 7 дней. Для ПС, которые не поддерживают проверку счета до оплаты или отмену платежа');

define('MODULE_PAYMENT_PLATRON_TEST_MODE_TITLE', 'Тестовый режим');
define('MODULE_PAYMENT_PLATRON_TEST_MODE_DESC', '');

define('MODULE_PAYMENT_PLATRON_SORT_ORDER_TITLE','Порядок сортировки');
define('MODULE_PAYMENT_PLATRON_SORT_ORDER_DESC','Порядок сортировки модуля.');

define('MODULE_PAYMENT_PLATRON_ORDER_STATUS_OK_ID_TITLE','Статус оплаченного заказа');
define('MODULE_PAYMENT_PLATRON_ORDER_STATUS_OK_ID_DESC','Статус, устанавливаемый заказу после успешной оплаты');

define('MODULE_PAYMENT_PLATRON_ORDER_STATUS_FAILED_ID_TITLE','Статус отклоненного заказа');
define('MODULE_PAYMENT_PLATRON_ORDER_STATUS_FAILED_ID_DESC','Статус, устанавливаемый заказу после отказа ПС');

define('MODULE_PAYMENT_PLATRON_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_PLATRON_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');

define('MODULE_PAYMENT_PLATRON_ORDER_STATUS_PENDING_ID_TITLE','Статус заказа, доступного для оплаты');
define('MODULE_PAYMENT_PLATRON_ORDER_STATUS_PENDING_ID_DESC','Статус, когда клиент сможет оплатить заказ. Надо оповещать сразу пользователя, что заказ будет доступен после проверки');

?>