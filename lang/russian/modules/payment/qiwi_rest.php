<?php
/* -----------------------------------------------------------------------------------------
   $Id: qiwi_rest.php 2588 2010/04/13 13:24:46 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2010 VaMSoft Ltd.
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneyorder.php,v 1.8 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (webmoney.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_QIWI_REST_TEXT_TITLE', 'Киви');
  define('MODULE_PAYMENT_QIWI_REST_TEXT_PUBLIC_TITLE', 'Киви');
  define('MODULE_PAYMENT_QIWI_REST_TEXT_ADMIN_DESCRIPTION', 'Модуль оплаты Киви.<br />Как правильно настроить модуль читайте <a href="http://vamshop.ru/blog/2014/04/22/%d0%bd%d0%b0%d1%81%d1%82%d1%80%d0%be%d0%b9%d0%ba%d0%b0-%d0%bc%d0%be%d0%b4%d1%83%d0%bb%d1%8f-%d0%be%d0%bf%d0%bb%d0%b0%d1%82%d1%8b-%d0%ba%d0%b8%d0%b2%d0%b8-rest-%d0%bf%d1%80%d0%be%d1%82%d0%be%d0%ba/" target="_blank"><u>здесь</u></a>.');
  define('MODULE_PAYMENT_QIWI_REST_TEXT_DESCRIPTION', 'Для подтверждения заказа нажмите кнопку Подтвердить.<br /><br /><br /><br /><strong><span class="Requirement">Вам был выписан счёт для оплаты заказа в QIWI Кошельке, Вы можете оплатить счёт в любом терминале киви, в своём личном кабинете (киви кошелёк), либо через интернет-версию киви кошелька по адресу <a href="http://qiwi.ru">http://qiwi.ru</a></span></strong><br /><br />');
  
define('MODULE_PAYMENT_QIWI_REST_STATUS_TITLE' , 'Разрешить модуль Киви');
define('MODULE_PAYMENT_QIWI_REST_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_QIWI_REST_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_QIWI_REST_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_QIWI_REST_ID_TITLE' , 'Идентификатор магазина:');
define('MODULE_PAYMENT_QIWI_REST_ID_DESC' , 'Укажите идентификатор магазина Вашего магазина, из настроек Вашего магазина на сайте киви http://ishop.qiwi.com');
define('MODULE_PAYMENT_QIWI_REST_API_ID_TITLE' , 'API ID:');
define('MODULE_PAYMENT_QIWI_REST_API_ID_DESC' , 'Укажите значние API ID, из настроек Вашего магазина на сайте киви http://ishop.qiwi.com');
define('MODULE_PAYMENT_QIWI_REST_NOTIFY_PASS_TITLE' , 'Пароль оповещения:');
define('MODULE_PAYMENT_QIWI_REST_NOTIFY_PASS_DESC' , 'Укажите Ваш пароль оповещения, из настроек Вашего магазина на сайте киви http://ishop.qiwi.com');
define('MODULE_PAYMENT_QIWI_REST_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_QIWI_REST_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_QIWI_REST_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_QIWI_REST_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_QIWI_REST_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
define('MODULE_PAYMENT_QIWI_REST_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');

define('MODULE_PAYMENT_QIWI_REST_NAME_TITLE' , '');
define('MODULE_PAYMENT_QIWI_REST_NAME_DESC' , 'Укажите номер Вашего мобильного телефона.');
define('MODULE_PAYMENT_QIWI_REST_TELEPHONE' , 'Телефон: ');
define('MODULE_PAYMENT_QIWI_REST_TELEPHONE_HELP' , ' Пример: <strong>7916820XXXX</strong>');

define('MODULE_PAYMENT_QIWI_REST_EMAIL_SUBJECT' , 'КИВИ: Оплачен заказ номер {$nr}');
  
?>