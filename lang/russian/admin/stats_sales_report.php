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

define('REPORT_TYPE_YEARLY', 'Годовая');
define('REPORT_TYPE_MONTHLY', 'Месячная');
define('REPORT_TYPE_WEEKLY', 'Недельная');
define('REPORT_TYPE_DAILY', 'Дневная');
define('REPORT_START_DATE', 'Дата от');
define('REPORT_END_DATE', 'до (включительно)');
define('REPORT_DETAIL', 'Подробнее');
define('REPORT_MAX', 'Показать лучшие');
define('REPORT_ALL', 'Все');
define('REPORT_SORT', 'Сортировка по');
define('REPORT_EXP', 'Экспорт');
define('REPORT_SEND', 'Выполнить');
define('EXP_NORMAL', 'Стандартно');
define('EXP_HTML', 'Только HTML');
define('EXP_CSV', 'CSV');

define('TABLE_HEADING_DATE', 'Дата');
define('TABLE_HEADING_ORDERS', 'Заказов');
define('TABLE_HEADING_ITEMS', 'Товаров');
define('TABLE_HEADING_REVENUE', 'Сумма');
define('TABLE_HEADING_SHIPPING', 'Доставка');

define('DET_HEAD_ONLY', 'Нет подробностей');
define('DET_DETAIL', 'Показать подробности');
define('DET_DETAIL_ONLY', 'Подробности с суммой');

define('SORT_VAL0', 'стандартно');
define('SORT_VAL1', 'описание');
define('SORT_VAL2', 'описание по убыванию');
define('SORT_VAL3', '№ товаров');
define('SORT_VAL4', '№ товаров по убыванию');
define('SORT_VAL5', 'Цена');
define('SORT_VAL6', 'Цена по убыванию');

define('REPORT_STATUS_FILTER', 'Статусы заказов');
define('REPORT_PAYMENT_FILTER','Способ оплаты');

define('SR_SEPARATOR1', ';');
define('SR_SEPARATOR2', ';');
define('SR_NEWLINE', '<br>');
?>