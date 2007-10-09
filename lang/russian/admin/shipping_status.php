<?php
/* --------------------------------------------------------------
   $Id: shipping_status.php 899 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders_status.php,v 1.7 2002/01/30); www.oscommerce.com 
   (c) 2003	 nextcommerce (orders_status.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2004	 xt:Commerce (shipping_status.php,v 1.4 2003/08/14); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Статус доставки');

define('TABLE_HEADING_SHIPPING_STATUS', 'Статус доставки');
define('TABLE_HEADING_ACTION', 'Действие');

define('TEXT_INFO_EDIT_INTRO', 'Сделайте необходимые изменения');
define('TEXT_INFO_SHIPPING_STATUS_NAME', 'Статус доставки:');
define('TEXT_INFO_INSERT_INTRO', 'Добавьте новый статус');
define('TEXT_INFO_DELETE_INTRO', 'Вы уверены что хотите удалить этот статус доставки?');
define('TEXT_INFO_HEADING_NEW_SHIPPING_STATUS', 'Новый статус доставки');
define('TEXT_INFO_HEADING_EDIT_SHIPPING_STATUS', 'Изменить статус доставки');
define('TEXT_INFO_SHIPPING_STATUS_IMAGE', 'Картинка:');
define('TEXT_INFO_HEADING_DELETE_SHIPPING_STATUS', 'Удалить статус доставки');

define('ERROR_REMOVE_DEFAULT_SHIPPING_STATUS', 'Ошибка: Статус по умолчанию не может быть удален.');
define('ERROR_STATUS_USED_IN_ORDERS', 'Ошибка: Этот статус доставки используется в товаре.');
define('ERROR_STATUS_USED_IN_HISTORY', 'Ошибка: Этот статус доставки используется в истории.');
?>