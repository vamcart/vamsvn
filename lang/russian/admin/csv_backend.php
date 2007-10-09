<?php
/* --------------------------------------------------------------
   $Id: cvs_backend.php 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2004	 xt:Commerce (csv_backend.php,v 1.4 2003/08/14); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

   define('TITLE','CSV');
   define('HEADING_TITLE','CSV импорт/экспорт');

   define('IMPORT','Импорт');
   define('EXPORT','Экспорт');
   define('UPLOAD','Загрузить файл');
   define('SELECT','Выберите файл для импорта (папка /import)');
   define('SAVE','Сохранить файл в папку /export');
   define('LOAD','Отправить файл в браузер');
   define('CSV_TEXTSIGN_TITLE','Поля заключены в');
   define('CSV_TEXTSIGN_DESC','Текстовое поле в CSV-файле. Обычно двойная (например ") или одинарная кавычка.');
   define('CSV_SEPERATOR_TITLE','Разделитель полей');
   define('CSV_SEPERATOR_DESC','Символ, используемый для определения окончания поля, например ;');
   define('COMPRESS_EXPORT_TITLE','Сжатие');
   define('COMPRESS_EXPORT_DESC','Сжать экспортируемый файл');
   define('CSV_SETUP','Настройка');
   define('TEXT_IMPORT','');
   define('TEXT_PRODUCTS','Товары');
   define('TEXT_EXPORT','Создать файл и сохранить его в папке /export');

?>