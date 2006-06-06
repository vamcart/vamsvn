<?php
/* --------------------------------------------------------------
   $Id: banner_statistics.php 899 2006-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner_statistics.php,v 1.3 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (banner_statistics.php,v 1.4 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Статистика Баннера');

define('TABLE_HEADING_SOURCE', 'Источник');
define('TABLE_HEADING_VIEWS', 'Показы');
define('TABLE_HEADING_CLICKS', 'Клики');

define('TEXT_BANNERS_DATA', 'Д<br>а<br>т<br>а');
define('TEXT_BANNERS_DAILY_STATISTICS', '%s Ежедневная статистика за %s %s');
define('TEXT_BANNERS_MONTHLY_STATISTICS', '%s Ежемесячная статистика за %s');
define('TEXT_BANNERS_YEARLY_STATISTICS', '%s Статистика за год');

define('STATISTICS_TYPE_DAILY', 'За день');
define('STATISTICS_TYPE_MONTHLY', 'За месяц');
define('STATISTICS_TYPE_YEARLY', 'За год');

define('TITLE_TYPE', 'Тип:');
define('TITLE_YEAR', 'Год:');
define('TITLE_MONTH', 'Месяц:');

define('ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST', 'Ошибка: Директория для баннеров отсутствует. Создайте поддиректорию \'graphs\' в директории \'images\'.');
define('ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE', 'Ошибка: Директория имеет неверные права доступа.');
?>