<?php
/* -----------------------------------------------------------------------------------------
   $Id: yandex_kassa.php 998 2009/02/07 13:24:46 VaM $

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

  define('MODULE_PAYMENT_YANDEX_KASSA_TEXT_TITLE', 'ЮКасса (Карточки Visa, MasterCard, Яндекс.Деньги)');
  define('MODULE_PAYMENT_YANDEX_KASSA_TEXT_PUBLIC_TITLE', 'ЮКасса (Карточки Visa, MasterCard, Яндекс.Деньги)');
  define('MODULE_PAYMENT_YANDEX_KASSA_TEXT_DESCRIPTION', 'После нажатия кнопки Подтвердить заказ Вы перейдёте на сайт платёжной системы для оплаты заказа, после оплаты Ваш заказ будет выполнен.');
  define('MODULE_PAYMENT_YANDEX_KASSA_TEXT_ADMIN_DESCRIPTION', 'Как правильно настроить модуль оплаты ЮКасса читайте в нашем <a href="http://blog.vamshop.ru/2019/08/18/%d0%bd%d0%b0%d1%81%d1%82%d1%80%d0%be%d0%b9%d0%ba%d0%b0-%d0%bc%d0%be%d0%b4%d1%83%d0%bb%d1%8f-%d0%be%d0%bf%d0%bb%d0%b0%d1%82%d1%8b-%d1%8f%d0%bd%d0%b4%d0%b5%d0%ba%d1%81-%d0%ba%d0%b0%d1%81%d1%81%d0%b0/"><u>блоге</u></a>.');
  
define('MODULE_PAYMENT_YANDEX_KASSA_STATUS_TITLE' , 'Разрешить модуль ЮКасса');
define('MODULE_PAYMENT_YANDEX_KASSA_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_YANDEX_KASSA_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_YANDEX_KASSA_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_YANDEX_KASSA_SHOP_ID_TITLE' , 'shopId:');
define('MODULE_PAYMENT_YANDEX_KASSA_SHOP_ID_DESC' , 'Идентификатор магазина.');
define('MODULE_PAYMENT_YANDEX_KASSA_SECRET_KEY_TITLE' , 'Секретный ключ');
define('MODULE_PAYMENT_YANDEX_KASSA_SECRET_KEY_DESC' , 'Секретный ключ для API.');
define('MODULE_PAYMENT_YANDEX_KASSA_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_YANDEX_KASSA_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_YANDEX_KASSA_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_YANDEX_KASSA_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_YANDEX_KASSA_TEST_TITLE','Режим работы');
define('MODULE_PAYMENT_YANDEX_KASSA_TEST_DESC','test - для тестирования работы модуля, production - для полноценного приёма оплаты.');
define('MODULE_PAYMENT_YANDEX_KASSA_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
define('MODULE_PAYMENT_YANDEX_KASSA_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');
define('MODULE_PAYMENT_YANDEX_KASSA_SEND_CHECK_TITLE' , 'Отправлять в ЮКасса данные для чеков (54-ФЗ)');
define('MODULE_PAYMENT_YANDEX_KASSA_SEND_CHECK_DESC' , 'Необходимо для работы онлайн-кассы через ЮКассау.');
define('MODULE_PAYMENT_YANDEX_KASSA_PAYMENT_TYPE_TITLE','Способ оплаты.');
define('MODULE_PAYMENT_YANDEX_KASSA_PAYMENT_TYPE_DESC','Выберите способ оплаты:<br />
Пустое значение - Выбор способа оплаты на стороне ЮКасса.<br />
PC - Оплата со счета Яндекс.Денег.<br />
АС - Оплата с произвольной банковской карты.<br />
MC - Платеж со счета мобильного телефона.<br />
GP - Оплата наличными через кассы и терминалы.<br />
WM - Оплата с кошелька в системе WebMoney.<br />
SB - Оплата через Сбербанк Онлайн.<br />
MP - Оплата через мобильный терминал (mPOS).<br />
AB - Оплата через Альфа-Клик.<br />
');
  
?>