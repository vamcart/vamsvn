<?php
/*------------------------------------------------------------------------------
  $Id: pay2pay.php 1400 2011-12-10 10:40:00 VaM $

   Pay2Pay - receiving payments on-line
   http://pay2pay.com

   Copyright (c) 2007 Pay2Pay
------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_PAY2PAY_TEXT_TITLE', 'Pay2Pay');
define('MODULE_PAYMENT_PAY2PAY_TEXT_PUBLIC_TITLE', 'Pay2Pay');
define('MODULE_PAYMENT_PAY2PAY_TEXT_ADMIN_DESCRIPTION', 'Модуль оплаты Pay2Pay.');
define('MODULE_PAYMENT_PAY2PAY_TEXT_DESCRIPTION', 'После нажатия кнопки Подтвердить заказ Вы перейдёте на сайт платёжной системы для оплаты заказа, после оплаты Ваш заказ будет выполнен.');
  
define('MODULE_PAYMENT_PAY2PAY_STATUS_TITLE' , 'Разрешить модуль Pay2Pay');
define('MODULE_PAYMENT_PAY2PAY_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_PAY2PAY_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_PAY2PAY_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_PAY2PAY_ID_TITLE' , 'Мерчант ID');
define('MODULE_PAYMENT_PAY2PAY_ID_DESC' , 'Укажите Ваш идентификационныый номер (Merchant Id).');
define('MODULE_PAYMENT_PAY2PAY_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_PAY2PAY_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_PAY2PAY_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_PAY2PAY_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_PAY2PAY_SECRET_KEY_TITLE' , 'Секретный ключ');
define('MODULE_PAYMENT_PAY2PAY_SECRET_KEY_DESC' , 'В данной опции укажите секретный ключ, указанный в настройках на сайте Pay2Pay.');
define('MODULE_PAYMENT_PAY2PAY_HIDDEN_KEY_TITLE' , 'Скрытый ключ');
define('MODULE_PAYMENT_PAY2PAY_HIDDEN_KEY_DESC' , 'В данной опции укажите скрытый ключ, указанный в настройках на сайте Pay2Pay.');
define('MODULE_PAYMENT_PAY2PAY_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
define('MODULE_PAYMENT_PAY2PAY_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');
define('MODULE_PAYMENT_PAY2PAY_TESTMODE_TITLE' , 'Тестовый режим');
define('MODULE_PAYMENT_PAY2PAY_TESTMODE_DESC' , 'Укажите в каком режиме будет работать модуль.');  
?>