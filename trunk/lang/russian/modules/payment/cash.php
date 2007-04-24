<?php
/* -----------------------------------------------------------------------------------------
   $Id: cash.php 1102 2007/04/24 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cod.php,v 1.28 2003/02/14); www.oscommerce.com
   (c) 2003	 nextcommerce (invoice.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (invoice.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('MODULE_PAYMENT_CASH_TEXT_DESCRIPTION', 'ќплата наличными (самовывоз)');
define('MODULE_PAYMENT_CASH_TEXT_TITLE', 'ќплата наличными (самовывоз)');
define('MODULE_PAYMENT_CASH_TEXT_INFO', '');
define('MODULE_PAYMENT_CASH_STATUS_TITLE', '–азрешить модуль ќплата наличными');
define('MODULE_PAYMENT_CASH_STATUS_DESC', '¬ы хотите разрешить использование модул€ при оформлении заказов?<br />ћодуль будет доступен при оформлении заказа только если на странице выбора доставки был выбран модуль доставки самовывоз.');
define('MODULE_PAYMENT_CASH_ORDER_STATUS_ID_TITLE', '—татус заказа');
define('MODULE_PAYMENT_CASH_ORDER_STATUS_ID_DESC', '«аказы, оформленные с использованием данного модул€ оплаты будут принимать указанный статус.');
define('MODULE_PAYMENT_CASH_SORT_ORDER_TITLE', 'ѕор€док сортировки');
define('MODULE_PAYMENT_CASH_SORT_ORDER_DESC', 'ѕор€док сортировки модул€.');
define('MODULE_PAYMENT_CASH_ZONE_TITLE', '«она');
define('MODULE_PAYMENT_CASH_ZONE_DESC', '≈сли выбрана зона, то данный модуль оплаты будет виден только покупател€м из выбранной зоны.');
define('MODULE_PAYMENT_CASH_ALLOWED_TITLE', '–азрешЄнные страны');
define('MODULE_PAYMENT_CASH_ALLOWED_DESC', '”кажите коды стран, дл€ которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупател€м из любых стран))');
?>