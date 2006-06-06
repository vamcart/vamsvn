<?php
/* --------------------------------------------------------------
   $Id: backup.php 899 2006-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(backup.php,v 1.21 2002/06/15); www.oscommerce.com
   (c) 2003	 nextcommerce (backup.php,v 1.4 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Резервное копирование');

define('TABLE_HEADING_TITLE', 'Имя');
define('TABLE_HEADING_FILE_DATE', 'Дата');
define('TABLE_HEADING_FILE_SIZE', 'Размер');
define('TABLE_HEADING_ACTION', 'Действие');

define('TEXT_INFO_HEADING_NEW_BACKUP', 'Сохранить заново');
define('TEXT_INFO_HEADING_RESTORE_LOCAL', 'Восстановить локально');
define('TEXT_INFO_NEW_BACKUP', 'Не прерывайте процесс, который может занять пару минут.');
define('TEXT_INFO_UNPACK', '<br><br>(после распаковки файла из архива)');
define('TEXT_INFO_RESTORE', 'Не прерывайте процесс восстановления.<br><br>Большая база данных, более долгий процесс!<br><br>Если возможно, используйте shell команды.<br><br>Например:<br><br><b>mysql -h' . DB_SERVER . ' -u' . DB_SERVER_USERNAME . ' -p ' . DB_DATABASE . ' < %s </b> %s');
define('TEXT_INFO_RESTORE_LOCAL', 'Не прерывайте процесс восстановления.<br><br>Большая база данных, более долгий процесс!');
define('TEXT_INFO_RESTORE_LOCAL_RAW_FILE', 'Загруженный файл должен быть текстовым файлом sql.');
define('TEXT_INFO_DATE', 'Дата:');
define('TEXT_INFO_SIZE', 'Размер:');
define('TEXT_INFO_COMPRESSION', 'Сжатие:');
define('TEXT_INFO_USE_GZIP', 'Использовать GZIP');
define('TEXT_INFO_USE_ZIP', 'Использовать ZIP');
define('TEXT_INFO_USE_NO_COMPRESSION', 'Без сжатия (Просто SQL)');
define('TEXT_INFO_DOWNLOAD_ONLY', 'Только загрузка (Не загружайте на удаленный сервер)');
define('TEXT_INFO_BEST_THROUGH_HTTPS', 'Наилучший вариант - связь через HTTPS');
define('TEXT_DELETE_INTRO', 'Вы действительно хотите удалить эту копию?');
define('TEXT_NO_EXTENSION', 'Нет');
define('TEXT_BACKUP_DIRECTORY', 'Резервная Директория:');
define('TEXT_LAST_RESTORATION', 'Последнее Восстановление:');
define('TEXT_FORGET', '(<u>забыть</u>)');

define('ERROR_BACKUP_DIRECTORY_DOES_NOT_EXIST', 'Ошибка: Директория для резервного копирования не существует.');
define('ERROR_BACKUP_DIRECTORY_NOT_WRITEABLE', 'Ошибка: Директория для резервного копирования защищена от записи, установите верные права доступа.');  
define('ERROR_DOWNLOAD_LINK_NOT_ACCEPTABLE', 'Ошибка: Ссылка для загрузки не приемлема.');

define('SUCCESS_LAST_RESTORE_CLEARED', 'Выполнено: Последняя дата восстановления очищена.');
define('SUCCESS_DATABASE_SAVED', 'Выполнено: База данных сохранена.');
define('SUCCESS_DATABASE_RESTORED', 'Выполнено: База данных восстановлена.');
define('SUCCESS_BACKUP_DELETED', 'Выполнено: Копия удалена.');
?>