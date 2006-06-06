<?php

/* --------------------------------------------------------------
   $Id: stats_sales_report.php 1311 2006-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(stats_sales_report.php,v 1.6 2002/03/30); www.oscommerce.com 
   (c) 2003	 nextcommerce (stats_sales_report.php,v 1.4 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
  

define('REPORT_DATE_FORMAT', 'Д. М. Г');

define('HEADING_TITLE', 'Статистика продаж');

define('REPORT_TYPE_YEARLY', 'По годам');
define('REPORT_TYPE_MONTHLY', 'По месячно');
define('REPORT_TYPE_WEEKLY', 'По недельно');
define('REPORT_TYPE_DAILY', 'По дням');
define('REPORT_START_DATE', 'От даты');
define('REPORT_END_DATE', 'по дату (включительно)');
define('REPORT_DETAIL', 'детали');
define('REPORT_MAX', 'показать лучшие');
define('REPORT_ALL', 'все');
define('REPORT_SORT', 'сортировка по');
define('REPORT_EXP', 'експорт');
define('REPORT_SEND', 'выполнить');
define('EXP_NORMAL', 'стандартно');
define('EXP_HTML', 'HTML только');
define('EXP_CSV', 'CSV');

define('TABLE_HEADING_DATE', 'Дата');
define('TABLE_HEADING_ORDERS', 'заказов');
define('TABLE_HEADING_ITEMS', 'товаров');
define('TABLE_HEADING_REVENUE', 'Прибыль');
define('TABLE_HEADING_SHIPPING', 'Доставка');

define('DET_HEAD_ONLY', 'нет деталей');
define('DET_DETAIL', 'показать детали');
define('DET_DETAIL_ONLY', 'детали с суммой');

define('SORT_VAL0', 'стандартно');
define('SORT_VAL1', 'описание');
define('SORT_VAL2', 'описание по убыванию');
define('SORT_VAL3', '№ товаров');
define('SORT_VAL4', '№ товаров по убыванию');
define('SORT_VAL5', 'Цена');
define('SORT_VAL6', 'Цена по убыванию');

define('REPORT_STATUS_FILTER', 'Статус');
define('REPORT_PAYMENT_FILTER','Тип оплаты');

define('SR_SEPARATOR1', ';');
define('SR_SEPARATOR2', ';');
define('SR_NEWLINE', '<br>');
?>