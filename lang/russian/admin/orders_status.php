<?php
/* --------------------------------------------------------------
   $Id: orders_status.php 899 2007-02-07 17:36:57 VaM $

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

define('HEADING_TITLE', 'Статус заказов');

define('TABLE_HEADING_ORDERS_STATUS', 'Статус заказов');
define('TABLE_HEADING_ANSWER_TEMPLATE', 'Шаблон ответа');
define('TABLE_HEADING_RESTOCK', 'Склад');
define('TABLE_HEADING_ACTION', 'Действие');

define('TEXT_INFO_EDIT_INTRO', 'Пожалуйста, внесите необходимые изменения');
define('TEXT_INFO_ORDERS_STATUS_NAME', 'Статус заказов:');
define('TEXT_INFO_INSERT_INTRO', 'Введите, пожалуйста, новый статус заказа, на основе исходных данных');
define('TEXT_INFO_DELETE_INTRO', 'Вы действительно хотите удалить статус этого заказа?');
define('TEXT_INFO_HEADING_NEW_ORDERS_STATUS', 'Новый статус заказа');
define('TEXT_INFO_HEADING_EDIT_ORDERS_STATUS', 'Редактировать статус заказа');
define('TEXT_INFO_HEADING_DELETE_ORDERS_STATUS', 'Удалить статус заказа');

define('ERROR_REMOVE_DEFAULT_ORDER_STATUS', 'Ошибка: Статус заказа по умолчанию не может быть удален, измените статус и попробуйте снова.');
define('ERROR_STATUS_USED_IN_ORDERS', 'Ошибка: Этот статус используется в настоящее время.');
define('ERROR_STATUS_USED_IN_HISTORY', 'Ошибка: Этот статус используется сейчас в истории заказов.');

define('ENTRY_ANSWER_TEMPLATE', 'Шаблон ответа:');
define('ENTRY_RESTOCK', 'Склад:');
define('ENTRY_RESTOCK_0', 'Вычитать со склада');
define('ENTRY_RESTOCK_1', 'Добавлять на склад');

?>