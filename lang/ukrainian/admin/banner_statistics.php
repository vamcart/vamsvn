<?php
/* --------------------------------------------------------------
   $Id: banner_statistics.php 899 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner_statistics.php,v 1.3 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (banner_statistics.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2004	 xt:Commerce (banner_statistics.php,v 1.4 2003/08/14); xt-commerce.com

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