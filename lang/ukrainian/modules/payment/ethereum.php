<?php
/* -----------------------------------------------------------------------------------------
   $Id: yandex.php 998 2007/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneyorder.php,v 1.8 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (yandex.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_ETHEREUM_TEXT_TITLE', 'Ethereum');

define('MODULE_PAYMENT_ETHEREUM_TEXT_DESCRIPTION', 'Информация для оплаты:<br /><br />Номер Ethereum кошелька: ' . MODULE_PAYMENT_ETHEREUM_ID . '<br /><br />');
define('MODULE_PAYMENT_ETHEREUM_TEXT_EMAIL_FOOTER', "Информация для оплаты:\n\nНомер нашего Ethereum: ". MODULE_PAYMENT_ETHEREUM_ID . "\n\n" . 'Ваш заказ будет выполнен только после получения оплаты!');

define('MODULE_PAYMENT_ETHEREUM_TEXT_INFO','');
define('MODULE_PAYMENT_ETHEREUM_STATUS_TITLE' , 'Разрешить модуль Ethereum');
define('MODULE_PAYMENT_ETHEREUM_STATUS_DESC' , 'Вы хотите разрешить использование модуля при оформлении заказов?');
define('MODULE_PAYMENT_ETHEREUM_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_PAYMENT_ETHEREUM_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_PAYMENT_ETHEREUM_ID_TITLE' , 'Номер кошелька:');
define('MODULE_PAYMENT_ETHEREUM_ID_DESC' , 'Укажите Ваш номер в Ethereum');
define('MODULE_PAYMENT_ETHEREUM_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_PAYMENT_ETHEREUM_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_PAYMENT_ETHEREUM_ZONE_TITLE' , 'Зона');
define('MODULE_PAYMENT_ETHEREUM_ZONE_DESC' , 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
define('MODULE_PAYMENT_ETHEREUM_ORDER_STATUS_ID_TITLE' , 'Статус заказа');
define('MODULE_PAYMENT_ETHEREUM_ORDER_STATUS_ID_DESC' , 'Заказы, оформленные с использованием данного модуля оплаты будут принимать указанный статус.');
?>