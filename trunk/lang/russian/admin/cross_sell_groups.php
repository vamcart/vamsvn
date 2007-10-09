<?php
/* --------------------------------------------------------------
   $Id: cross_sell_groups.php 1231 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders_status.php,v 1.7 2002/01/30); www.oscommerce.com 
   (c) 2003	 nextcommerce (orders_status.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2004	 xt:Commerce (orders_status.php,v 1.4 2003/08/14); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Группы сопутствующих товаров');

define('TABLE_HEADING_XSELL_GROUP_NAME', 'Название группы');
define('TABLE_HEADING_ACTION', 'Действие');

define('TEXT_INFO_EDIT_INTRO', 'Внесите необходимые изменения');
define('TEXT_INFO_XSELL_GROUP_NAME', 'Название группы:');
define('TEXT_INFO_INSERT_INTRO', 'Укажите название группы');
define('TEXT_INFO_DELETE_INTRO', 'Вы действительно хотите удалить данные статус заказа?');
define('TEXT_INFO_HEADING_NEW_XSELL_GROUP', 'Новая группа');
define('TEXT_INFO_HEADING_EDIT_XSELL_GROUP', 'Редактировать группу');
define('TEXT_INFO_HEADING_DELETE_XSELL_GROUP', 'Удалить группу');

define('ERROR_STATUS_USED_IN_ORDERS', 'Ошибка: Данная группа уже используется в сопутствующих товарах в статьях.');
?>