<?php
/* -----------------------------------------------------------------------------------------
   $Id: aviso.php 2588 2011/08/04 13:24:46 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2011 VaMSoft Ltd.
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneyorder.php,v 1.8 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (webmoney.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_AVISO_TEXT_TITLE', 'AvisoSMS (Оплата с баланса мобильного телефона)');
  define('MODULE_PAYMENT_AVISO_TEXT_PUBLIC_TITLE', 'AvisoSMS (Оплата с баланса мобильного телефона)');
  define('MODULE_PAYMENT_AVISO_TEXT_ADMIN_DESCRIPTION', 'Модуль оплаты AvisoSMS<br />Как правильно настроить модуль читайте <a href="http://vamshop.ru/blog/2011/08/04/%d0%bd%d0%b0%d1%81%d1%82%d1%80%d0%b0%d0%b8%d0%b2%d0%b0%d0%b5%d1%82-avisosms-%d0%bc%d0%be%d0%b1%d0%b8%d0%bb%d1%8c%d0%bd%d0%b0%d1%8f-%d0%ba%d0%be%d0%bc%d0%bc%d0%b5%d1%80%d1%86%d0%b8%d1%8f-%d0%b2-vamshop/" target="_blank"><u>здесь</u></a>.');
  define('MODULE_PAYMENT_AVISO_TEXT_DESCRIPTION', 'После нажатия кнопки Подтвердить заказ Вы перейдёте на сайт платёжной системы для оплаты заказа, после оплаты Ваш заказ будет выполнен.');
  
define('MODULE_PAYMENT_AVISO_STATUS_TITLE' , 'Разрешить модуль AvisoSMS');
define('MODULE_PAYMENT_AVISO_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_AVISO_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_AVISO_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_AVISO_ID_TITLE' , 'Ваш логин в AvisoSMS:');
define('MODULE_PAYMENT_AVISO_ID_DESC' , 'Укажите Ваше имя пользователя в системе AvisoSMS Мобильная коммерция.');
define('MODULE_PAYMENT_AVISO_ACCESS_KEY_TITLE' , 'Ключ доступа:');
define('MODULE_PAYMENT_AVISO_ACCESS_KEY_DESC' , 'Укажите ключ доступа (В личном кабинете AvisoSMS указывается, в разделе Настройки - Настройки удалённого доступа)');
define('MODULE_PAYMENT_AVISO_SECURE_HASH_TITLE' , 'SECURE_HASH:');
define('MODULE_PAYMENT_AVISO_SECURE_HASH_DESC' , 'Укажите Ваше значение опции SECURE_HASH');
define('MODULE_PAYMENT_AVISO_SERVICE_ID_TITLE' , 'ID номер магазина:');
define('MODULE_PAYMENT_AVISO_SERVICE_ID_DESC' , 'Укажите ID номер Вашего магазина (ID номер виден в личном кабинете AvisoSMS, в разделе Биллинг - Мобильная коммерция, в списке магазинов виден ID номер)');
define('MODULE_PAYMENT_AVISO_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_AVISO_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_AVISO_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_AVISO_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_AVISO_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
define('MODULE_PAYMENT_AVISO_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');

define('MODULE_PAYMENT_AVISO_NAME_TITLE' , '');
define('MODULE_PAYMENT_AVISO_NAME_DESC' , 'Укажите номер Вашего мобильного телефона.');
define('MODULE_PAYMENT_AVISO_TELEPHONE' , 'Телефон: ');
define('MODULE_PAYMENT_AVISO_TELEPHONE_HELP' , ' Пример: <strong>7916820XXXX</strong>');

define('MODULE_PAYMENT_AVISO_EMAIL_SUBJECT' , 'AvisoSMS: Оплачен заказ номер {$nr}');
  
?>