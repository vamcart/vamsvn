<?php
/*
  $Id: paypal_standard.php 1778 2012-01-09 23:37:44Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2008 osCommerce

  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_PAYPAL_STANDARD_TEXT_TITLE', 'PayPal (Visa, MasterCard)');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_TEXT_PUBLIC_TITLE', 'PayPal (Visa, MasterCard)');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_TEXT_DESCRIPTION', '');

  define('MODULE_PAYMENT_PAYPAL_STANDARD_STATUS_TITLE', 'Разрешить модуль оплаты PayPal');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_STATUS_DESC', 'Разрешить приём оплаты через PayPal?');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_ALLOWED_TITLE', 'Разрешённые страны');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_ALLOWED_DESC', 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_ID_TITLE', 'E-Mail');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_ID_DESC', 'Ваш PayPal e-mail адрес для приёма платежей');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_SORT_ORDER_TITLE', 'Порядок сортировки');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_SORT_ORDER_DESC', 'Порядок сортировки модуля.');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_ZONE_TITLE', 'Зона');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_ZONE_DESC', 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_PREPARE_ORDER_STATUS_ID_TITLE', 'Статус неоплаченного заказа');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_PREPARE_ORDER_STATUS_ID_DESC', 'Статус неоплаченного заказа, оформленного через PayPal');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_ORDER_STATUS_ID_TITLE', 'Статус оплаченного заказа');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_ORDER_STATUS_ID_DESC', 'Укажите оплаченный статус заказа');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_GATEWAY_SERVER_TITLE', 'Сервер');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_GATEWAY_SERVER_DESC', 'Для тестирования (sandbox) или для рабочего режима (live)?');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_TRANSACTION_METHOD_TITLE', 'Способ обработки транзакций');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_TRANSACTION_METHOD_DESC', 'Способ обработки транзакций.');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_PAGE_STYLE_TITLE', 'Стиль страницы');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_PAGE_STYLE_DESC', 'Стиль paypal страницы (настраивается в Вашем PayPal профиле)');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_DEBUG_EMAIL_TITLE', 'E-Mail адрес для отладки');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_DEBUG_EMAIL_DESC', 'Вся отладочная информация будет отправляться на указанный email.');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_EWP_STATUS_TITLE', 'Разрешить шифрование платежей');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_EWP_STATUS_DESC', 'Вы хотите разрешить шифрование платежей?');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_EWP_PRIVATE_KEY_TITLE', 'Ваш приватный ключ');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_EWP_PRIVATE_KEY_DESC', 'Путь до Вашего приватного ключа. (*.pem)');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_EWP_PUBLIC_KEY_TITLE', 'Ваш публичный сертификат');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_EWP_PUBLIC_KEY_DESC', 'Путь до Вашего публичного сертификата. (*.pem)');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_EWP_PAYPAL_KEY_TITLE', 'Публичный сертификат PayPal');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_EWP_PAYPAL_KEY_DESC', 'Путь до публичного сертификата PayPal.');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_EWP_CERT_ID_TITLE', 'ID публичного сертификата PayPal');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_EWP_CERT_ID_DESC', 'ID публичного сертификата PayPal можно узнать в своём профиле на PayPal.');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_EWP_WORKING_DIRECTORY_TITLE', 'Рабочая директория');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_EWP_WORKING_DIRECTORY_DESC', 'Рабочая директория для временных файлов.');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_EWP_OPENSSL_TITLE', 'Расположение OpenSSL');
  define('MODULE_PAYMENT_PAYPAL_STANDARD_EWP_OPENSSL_DESC', 'Путь к исполняемому файлу openssl.');

?>