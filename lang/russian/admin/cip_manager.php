<?php
/*
  cip_manager.php
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2002 osCommerce
  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Установка модулей');

define('TABLE_HEADING_FILENAME', 'Название');
define('TABLE_HEADING_SIZE', 'Размер');
define('TABLE_HEADING_PERMISSIONS', 'Права доступа');
define('TABLE_HEADING_USER', 'Пользователь');
define('TABLE_HEADING_GROUP', 'Группа');
define('TABLE_HEADING_UPLOADED', 'Загружен');
define('TABLE_HEADING_ACTION', 'Действие');

define('TEXT_INFO_HEADING_UPLOAD', 'Загрузить');
define('TEXT_FILE_NAME', 'Имя файла:');
define('TEXT_FILE_SIZE', 'Размер:');
define('TEXT_FILE_CONTENTS', 'Содержимое:');
define('TEXT_LAST_MODIFIED', 'Последние изменения:');

define('TEXT_DELETE_INTRO', 'Вы действительно хотите удалить данный файл?');
define('TEXT_UPLOAD_INTRO', 'Выберите файл для загрузки.');

define('ERROR_DIRECTORY_NOT_WRITEABLE', 'Ошибка: Нет доступа на запись в данную директорию. Установите правильные права доступа на: %s');
define('ERROR_FILE_NOT_WRITEABLE', 'Ошибка: Нет доступа на запись в данный файл. Установите правильные права доступа на: %s');
//======================
define('ICON_UNZIP', 'Рахархивировать');
define('ICON_ZIP', 'Архивировать');
define('ICON_EDIT', 'Редактировать');
define('ICON_INSTALL', 'Установить');
define('ICON_REMOVE', 'Удалить модуль');
define('ICON_DELETE_MODULE', 'Удалить архив с модулем из магазина');
define('ICON_WITHOUT_DATA_REMOVING', 'сохранив изменения, произведённые модулем');
define('ICON_EMPTY', '');

define('ICON_INSTALLED_CURRENT_FOLDER', 'Текущая папка была установлена');

//Uploader:
define('ERROR_FILE_ALREADY_EXISTS','Файл %s  <b>уже существует</b>.');

define('CIP_MANAGER_SUPPORT','Поддержка: ');
define('CIP_MANAGER_UPLOADER','Модуль добавил: ');
define('CIP_MANAGER_SUPPORT_FORUM','Форум поддержки данного модуля на официальном сайте VaM Shop');
define('CIP_MANAGER_CONTRIBUTION_PAGE','Официальная страница модуля');
define('CIP_MANAGER_SUPPORT_FORUM_DEVELOPER','Форум поддержки данного модуля на сайте разработчика');
define('CIP_MANAGER_INFO','Информация о модуле: ');
define('CIP_MANAGER_INSTALLED','Модуль установлен');
define('CIP_MANAGER_NOT_INSTALLED','Модуль не был установлен');
define('CIP_MANAGER_UPLOAD_NOTE','Вы можете загружать <b>только ZIP архивы</b>, <br><b>не более 500Kb</b><br>и <b>только архивы с модулями для VaM Shop</b>.');
define('CIP_MANAGER_XML_NOT_FOUND',' не найден!');
define('CIP_MANAGER_GENERAL_INFO','Информация о файле: ');
define('CIP_MANAGER_IMAGE_PREVIEW','Картинка: ');
define('CIP_MANAGER_ENLARGE','Увеличить');
define('CIP_MANAGER_INSTALLED','Модуль <b>установлен!</b>');
define('CIP_MANAGER_REMOVED','Модуль <b>удалён!</b>');

?>