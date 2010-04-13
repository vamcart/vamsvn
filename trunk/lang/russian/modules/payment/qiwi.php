<?php
/* -----------------------------------------------------------------------------------------
   $Id: qiwi.php 2588 2010/04/13 13:24:46 oleg_vamsoft $

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

  define('MODULE_PAYMENT_QIWI_TEXT_TITLE', 'Киви');
  define('MODULE_PAYMENT_QIWI_TEXT_PUBLIC_TITLE', 'Киви');
  define('MODULE_PAYMENT_QIWI_TEXT_ADMIN_DESCRIPTION', 'Модуль оплаты Киви.<br />Как правильно настроить модуль читайте <a href="http://vamshop.ru/Nastrojka-modulja-oplaty-kivi.html" target="_blank"><u>здесь</u></a>.');
  define('MODULE_PAYMENT_QIWI_TEXT_DESCRIPTION', 'Для подтверждения заказа нажмите кнопку Подтвердить.<br /><br /><br /><br /><strong><span class="Requirement">Вам был выписан счёт для оплаты заказа в QIWI Кошельке, Вы можете оплатить счёт в любом терминале киви, в своём личном кабинете (киви кошелёк), либо через интернет-версию киви кошелька по адресу <a href="http://mylk.qiwi.ru">http://mylk.qiwi.ru</a></span></strong><br /><br />');
  
define('MODULE_PAYMENT_QIWI_STATUS_TITLE' , 'Разрешить модуль Киви');
define('MODULE_PAYMENT_QIWI_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_QIWI_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_QIWI_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_QIWI_ID_TITLE' , 'ID номер магазина:');
define('MODULE_PAYMENT_QIWI_ID_DESC' , 'Укажите ID номер Вашего магазина');
define('MODULE_PAYMENT_QIWI_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_QIWI_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_QIWI_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_QIWI_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_QIWI_SECRET_KEY_TITLE' , 'Пароль');
define('MODULE_PAYMENT_QIWI_SECRET_KEY_DESC' , 'В данной опции укажите Ваш пароль.');
define('MODULE_PAYMENT_QIWI_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
define('MODULE_PAYMENT_QIWI_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');

define('MODULE_PAYMENT_QIWI_NAME_TITLE' , '');
define('MODULE_PAYMENT_QIWI_NAME_DESC' , 'Укажите номер Вашего мобильного телефона.');
define('MODULE_PAYMENT_QIWI_TELEPHONE' , 'Телефон: ');
define('MODULE_PAYMENT_QIWI_TELEPHONE_HELP' , ' Пример: <strong>916820XXXX</strong>');
  
?>