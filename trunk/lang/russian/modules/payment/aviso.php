<?php
/* -----------------------------------------------------------------------------------------
   $Id: aviso.php 998 2009/05/07 13:24:46 VaM $

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

  define('MODULE_PAYMENT_AVISOTEXT_TITLE', 'AvisoSMS (мобильная коммерация - оплата с мобильного телефона)');
  define('MODULE_PAYMENT_AVISOTEXT_PUBLIC_TITLE', 'AvisoSMS (мобильная коммерация - оплата с мобильного телефона)');
  define('MODULE_PAYMENT_AVISOTEXT_ADMIN_DESCRIPTION', 'Модуль оплаты AvisoSMS<br />Как правильно настроить модуль читайте <a href="http://vamshop.ru/faq.php/faq_id/70/question/Nastroika-modulya-oplaty-WebMoney-Merchant" target="_blank"><u>здесь</u></a>.');
  define('MODULE_PAYMENT_AVISOTEXT_DESCRIPTION', 'После нажатия кнопки Подтвердить заказ Вы перейдёте на сайт платёжной системы для оплаты заказа, после оплаты Ваш заказ будет выполнен.');
  
  define('MODULE_PAYMENT_WEBMONEYMERCHANT_TEXT_TYPE','Способ оплаты:');
  define('MODULE_PAYMENT_WEBMONEYMERCHANT_TEXT_WMZ','WMZ');
  define('MODULE_PAYMENT_WEBMONEYMERCHANT_TEXT_WMR','WMR');

define('MODULE_PAYMENT_AVISOSTATUS_TITLE' , 'Разрешить модуль WebMoney');
define('MODULE_PAYMENT_AVISOSTATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_AVISOALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_AVISOALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_AVISOID_TITLE' , 'WM ID:');
define('MODULE_PAYMENT_AVISOID_DESC' , 'Укажите Ваш WM ID');
define('MODULE_PAYMENT_AVISOWMR_TITLE' , 'Ваш WMR кошелёк:');
define('MODULE_PAYMENT_AVISOWMR_DESC' , 'Укажите номер Вашего WMR кошелька');
define('MODULE_PAYMENT_AVISOSORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_AVISOSORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_AVISOZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_AVISOZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_AVISOSECRET_KEY_TITLE' , 'Секретный ключ');
define('MODULE_PAYMENT_AVISOSECRET_KEY_DESC' , 'В данной опции укажите Ваш ключ, указанный в опции Secret Key на сайте AvisoSMS.');
define('MODULE_PAYMENT_AVISOORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
define('MODULE_PAYMENT_AVISOORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');
  
?>