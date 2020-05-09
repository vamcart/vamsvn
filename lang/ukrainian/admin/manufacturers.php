<?php
/* --------------------------------------------------------------
   $Id: manufacturers.php 899 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(manufacturers.php,v 1.14 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (manufacturers.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2004	 xt:Commerce (manufacturers.php,v 1.4 2003/08/14); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Производители');

define('TABLE_HEADING_MANUFACTURERS', 'Производители');
define('TABLE_HEADING_SORT_ORDER', 'Порядок сортировки');
define('TABLE_HEADING_ACTION', 'Действие');

define('TEXT_HEADING_NEW_MANUFACTURER', 'Новый Производитель');
define('TEXT_HEADING_EDIT_MANUFACTURER', 'Изменить Производителя');
define('TEXT_HEADING_DELETE_MANUFACTURER', 'Удалить Производителя');

define('TEXT_MANUFACTURERS', 'Производители:');
define('TEXT_DATE_ADDED', 'Дата Добавления:');
define('TEXT_LAST_MODIFIED', 'Последнее Изменение:');
define('TEXT_PRODUCTS', 'Товары:');
define('TEXT_IMAGE_NONEXISTENT', 'КАРТИНКА ОТСУТСТВУЕТ');

define('TEXT_NEW_INTRO', 'Пожалуйста, внесите требуемую информацию для нового производителя');
define('TEXT_EDIT_INTRO', 'Пожалуйста, внесите необходимые изменения');

define('TEXT_MANUFACTURERS_NAME', 'Название Производителя:');
define('TEXT_MANUFACTURERS_IMAGE', 'Картинка Производителя:');
define('TEXT_MANUFACTURERS_URL', 'URL Производителя (с http://):');

define('TEXT_DELETE_INTRO', 'Вы действительно хотите удалить этого производителя?'); 
define('TEXT_DELETE_IMAGE', 'Удалить фото производителя?');
define('TEXT_DELETE_PRODUCTS', 'Удалить товары этого производителя? (включая отзывы, специальные предложения и предстоящие поступления)');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>ПРЕДУПРЕЖДЕНИЕ:</b> %s наименований товара связаны с данным производителем!');  

define('ERROR_DIRECTORY_NOT_WRITEABLE', 'Ошибка: В эту директорию невозможно записать. Смените права доступа для: %s');
define('ERROR_DIRECTORY_DOES_NOT_EXIST', 'Ошибка: Директория не существует: %s');

define('TEXT_MANUFACTURERS_META_TITLE', 'Meta title:');
define('TEXT_MANUFACTURERS_META_KEYWORDS', 'Meta keywords:');
define('TEXT_MANUFACTURERS_META_DESCRIPTION', 'Meta description:');
define('TEXT_MANUFACTURERS_DESCRIPTION','Описание производителя:');

define('TEXT_MANUFACTURERS_PAGE_URL', 'SEO URL производителя:');
define('TEXT_MANUFACTURERS_SORT_ORDER', 'Порядок сортировки:');

define('TEXT_MANUFACTURERS_STATUS', 'Бренд активен:');
define('TABLE_HEADING_STATUS', 'Статус');

?>