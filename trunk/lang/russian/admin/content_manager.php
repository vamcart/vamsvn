<?php
/* --------------------------------------------------------------
   $Id: content_manager.php 899 2006-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (content_manager.php,v 1.8 2003/08/25); www.nextcommerce.org
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/
   
 define('HEADING_TITLE','Содержание сайта');
 define('HEADING_CONTENT','Содержание сайта');
 define('HEADING_PRODUCTS_CONTENT','Информация к товару');
 define('TABLE_HEADING_CONTENT_ID','Link ID');
 define('TABLE_HEADING_CONTENT_TITLE','Заголовок');
 define('TABLE_HEADING_CONTENT_FILE','Файл');
 define('TABLE_HEADING_CONTENT_STATUS','Видим в боксе');
 define('TABLE_HEADING_CONTENT_BOX','Бокс');
 define('TABLE_HEADING_PRODUCTS_ID','ID');
 define('TABLE_HEADING_PRODUCTS','Товар');
 define('TABLE_HEADING_PRODUCTS_CONTENT_ID','ID');
 define('TABLE_HEADING_LANGUAGE','Язык');
 define('TABLE_HEADING_CONTENT_NAME','Название/Название файла');
 define('TABLE_HEADING_CONTENT_LINK','Ссылка');
 define('TABLE_HEADING_CONTENT_HITS','Просмотрен');
 define('TABLE_HEADING_CONTENT_GROUP','Группа');
 define('TABLE_HEADING_CONTENT_SORT','Порядок сорт.');
 define('TEXT_YES','Да');
 define('TEXT_NO','нет');
 define('TABLE_HEADING_CONTENT_ACTION','Действие');
 define('TEXT_DELETE','Удалить');
 define('TEXT_EDIT','Изменить');
 define('TEXT_PREVIEW','Просмотр');
 define('CONFIRM_DELETE','Удалить содержание ?');
 define('CONTENT_NOTE','Маркированное значком <span class="red">*</span> &#8212; часть системы и не может быть удалено!');


 // edit
 define('TEXT_LANGUAGE','Язык:');
 define('TEXT_STATUS','Показывать:');
 define('TEXT_STATUS_DESCRIPTION','Если отмечено, то ссылка на данный контент отображается в информационном боксе');
 define('TEXT_TITLE','Название (ссылка):');
 define('TEXT_TITLE_FILE','Название/Имя файла:');
 define('TEXT_SELECT','-Выберите-');
 define('TEXT_HEADING','Заголовок (документ):');
 define('TEXT_CONTENT','Текст:');
 define('TEXT_UPLOAD_FILE','Загрузить файл:');
 define('TEXT_UPLOAD_FILE_LOCAL','(с локальной системы)');
 define('TEXT_CHOOSE_FILE','Выберите файл:');
 define('TEXT_CHOOSE_FILE_DESC','Вы так-же можете выбрать из списка уже существующий файл.');
 define('TEXT_NO_FILE','Удалить отмеченное');
 define('TEXT_CHOOSE_FILE_SERVER','Если вы загрузили свои файлы через FTP в <i>(media/content)</i>, вы должны выбрать здесь файл.');
 define('TEXT_CURRENT_FILE','Текущий файл:');
 define('TEXT_FILE_DESCRIPTION','<b>Информация:</b><br />Вы также можете загружать <b>.html</b> или <b>.htm</b> файл и он будет отображаться в содержании, как есть.<br /> Если вы выбрали какой-то файл или загружаете его, то текст в боксе будет проигнорирован.<br />');
 define('ERROR_FILE','Неверный формат файла (только .html или .htm)');
 define('ERROR_TITLE','Пожалуйста, введите название');
 define('ERROR_COMMENT','Пожалуйста, введите описание файла!');
 define('TEXT_FILE_FLAG','Бокс:');
 define('TEXT_PARENT','Основной документ:');
 define('TEXT_PARENT_DESCRIPTION','Назначить к этому документу');
 define('TEXT_PRODUCT','Товар:');
 define('TEXT_LINK','Ссылка:');
 define('TEXT_SORT_ORDER','Сортировка:');
 define('TEXT_GROUP','Языковая группа:');
 define('TEXT_GROUP_DESC','С этим ID вы можете связать одинаковые темы в разных языках.');

 define('TEXT_CONTENT_DESCRIPTION','Здесь Вы можете добавить к Вашему товару файл любого типа, например &#8212; технические характеристики, описание товара, видео, фотографии товара. Всё это будет выведено на странице описания товара.<br /><br />');
 define('TEXT_FILENAME','Использованный файл:');
 define('TEXT_FILE_DESC','Описание:');
 define('USED_SPACE','Использованное место:');
 define('TABLE_HEADING_CONTENT_FILESIZE','Размер файла');


 ?>