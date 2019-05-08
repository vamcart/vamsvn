<?php
/* -----------------------------------------------------------------------------------------
   $Id: nextpay.php 998 2009/02/07 13:24:46 VaM $

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

define('MODULE_PAYMENT_NEXTPAY_TEXT_TITLE', 'Оплата картой через NextPay');
define('MODULE_PAYMENT_NEXTPAY_TEXT_PUBLIC_TITLE', 'Оплата картой через NextPay');
define('MODULE_PAYMENT_NEXTPAY_TEXT_DESCRIPTION', '');
define('MODULE_PAYMENT_NEXTPAY_TEXT_ADMIN_DESCRIPTION', 'Модуль приёма оплаты NextPay. Как настраивать модуль NextPay, читайте в нашем блоге <a href="http://blog.vamshop.ru/2017/06/18/%D0%B4%D0%BE%D0%B1%D0%B0%D0%B2%D0%BB%D0%B5%D0%BD-%D0%BD%D0%BE%D0%B2%D1%8B%D0%B9-%D0%BC%D0%BE%D0%B4%D1%83%D0%BB%D1%8C-%D0%BE%D0%BF%D0%BB%D0%B0%D1%82%D1%8B-nextpay/">http://blog.vamshop.ru</a>');
  
define('MODULE_PAYMENT_NEXTPAY_STATUS_TITLE' , 'Разрешить модуль NextPay');
define('MODULE_PAYMENT_NEXTPAY_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_NEXTPAY_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_NEXTPAY_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_NEXTPAY_PRODUCT_ID_TITLE' , 'ID Продукта');
define('MODULE_PAYMENT_NEXTPAY_PRODUCT_ID_DESC' , 'Укажите ID номер продукта в Ваших настройках на сайте nextpay.');
define('MODULE_PAYMENT_NEXTPAY_SECRET_KEY_TITLE' , 'Секретное слово');
define('MODULE_PAYMENT_NEXTPAY_SECRET_KEY_DESC' , 'В данной опции укажите Секретное слово из настроек на сайте NextPay.');
define('MODULE_PAYMENT_NEXTPAY_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_NEXTPAY_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_NEXTPAY_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_NEXTPAY_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_NEXTPAY_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
define('MODULE_PAYMENT_NEXTPAY_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');
  
?>