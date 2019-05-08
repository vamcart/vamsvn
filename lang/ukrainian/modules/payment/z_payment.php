<?php
/* -----------------------------------------------------------------------------------------
   $Id: z_payment.php 998 2007/02/07 13:24:46 VaM $

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

  define('MODULE_PAYMENT_Z_PAYMENT_TEXT_TITLE', 'Z-Payment');
  define('MODULE_PAYMENT_Z_PAYMENT_TEXT_PUBLIC_TITLE', 'Z-Payment');
  define('MODULE_PAYMENT_Z_PAYMENT_TEXT_DESCRIPTION', 'После нажатия кнопки Подтвердить заказ Вы перейдёте на сайт платёжной системы, где будут доступны инструкции для оплаты Вашего заказа. После подтверждения оплаты Ваш заказ будет выполнен.');

define('MODULE_PAYMENT_Z_PAYMENT_STATUS_TITLE' , 'Разрешить модуль Z-Payment');
define('MODULE_PAYMENT_Z_PAYMENT_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_Z_PAYMENT_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_Z_PAYMENT_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_Z_PAYMENT_ID_TITLE' , 'ID номер магазина в Z-Payment');
define('MODULE_PAYMENT_Z_PAYMENT_ID_DESC' , 'Укажите id номер Вашего магазина.');
define('MODULE_PAYMENT_Z_PAYMENT_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_Z_PAYMENT_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_Z_PAYMENT_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_Z_PAYMENT_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_Z_PAYMENT_SECRET_KEY_TITLE' , 'Секретный ключ');
define('MODULE_PAYMENT_Z_PAYMENT_SECRET_KEY_DESC' , 'В данной опции укажите Ваш ключ, указанный в опции Secret Key на сайте Z-Payment.');
define('MODULE_PAYMENT_Z_PAYMENT_PREPARE_ORDER_STATUS_ID_TITLE' , 'Укажите статус заказа, ожидающий оплаты');
define('MODULE_PAYMENT_Z_PAYMENT_PREPARE_ORDER_STATUS_ID_DESC' , 'Укажите статус заказа, ожидающий оплаты.');
define('MODULE_PAYMENT_Z_PAYMENT_ORDER_STATUS_ID_TITLE' , 'Укажите оплаченный статус заказа');
define('MODULE_PAYMENT_Z_PAYMENT_ORDER_STATUS_ID_DESC' , 'Укажите оплаченный статус заказа.');
  
?>