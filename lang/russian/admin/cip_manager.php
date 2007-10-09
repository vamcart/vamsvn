<?php
/* --------------------------------------------------------------
   $Id: cip_manager.php 1249 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2005 Vlad Savitsky cip.net.ua

   Released under the GNU General Public License
   --------------------------------------------------------------*/

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
define('TEXT_UPLOAD_LIMITS','Вы можете загружать только <b>ZIP архивы</b>, не более <b>'.round(MAX_UPLOADED_FILESIZE/1024).'Kb</b> и только <b>архивы с модулями</b>!');

define('ERROR_DIRECTORY_NOT_WRITEABLE', 'Ошибка: Нет доступа на запись в данную директорию. Установите правильные права доступа на: %s');
define('ERROR_FILE_NOT_WRITEABLE', 'Ошибка: Нет доступа на запись в данный файл. Установите правильные права доступа на: %s');
define('ERROR_DIRECTORY_NOT_REMOVEABLE', 'Ошибка: Не могу удалить данную директорию. Установите правильные права доступа на: %s');
define('ERROR_FILE_NOT_REMOVEABLE', 'Ошибка: Не могу удалить данный файл. Установите правильные права доступа на: %s');
define('ERROR_FILE_ALREADY_EXISTS','Файл %s  <b>уже существует</b>.');

define('ICON_EDIT', 'Редактировать');
define('ICON_INSTALL', 'Установить');
define('ICON_REMOVE', 'Удалить модуль');
define('ICON_DELETE_MODULE', 'Удалить архив с модулем из магазина');
define('ICON_WITHOUT_DATA_REMOVING', 'сохранив изменения, произведённые модулем');
define('ICON_EMPTY', '');
define('ICON_INSTALLED_CURRENT_FOLDER', 'Текущая папка была установлена');

define('CIP_MANAGER_SUPPORT','Поддержка: ');
define('CIP_MANAGER_UPLOADER','Модуль добавил: ');
define('CIP_MANAGER_SUPPORT_FORUM','Форум поддержки для данного модуля на официальном сайте магазина');
define('CIP_MANAGER_CONTRIBUTION_PAGE','Официальная страница модуля');
define('CIP_MANAGER_SUPPORT_FORUM_DEVELOPER','Форум поддержки данного модуля на сайте разработчика');
define('CIP_MANAGER_INFO','Информация о модуле: ');
define('CIP_MANAGER_INSTALLED','Модуль установлен');
define('CIP_MANAGER_NOT_INSTALLED','Модуль не был установлен');
define('CIP_MANAGER_UPLOAD_NOTE','Вы можете загружать <b>только ZIP архивы</b>, <br><b>не более 500Kb</b><br>и <b>только архивы с модулями</b>.');
define('CIP_MANAGER_XML_NOT_FOUND',' не найден!');
define('CIP_MANAGER_GENERAL_INFO','Информация о файле: ');
define('CIP_MANAGER_IMAGE_PREVIEW','Картинка: ');
define('CIP_MANAGER_ENLARGE','Увеличить');
define('CIP_MANAGER_INSTALLED','Модуль <b>установлен!</b>');
define('CIP_MANAGER_REMOVED','Модуль <b>удалён!</b>');

define('CONTRIB_INSTALLER_NAME','Установка модулей');
define('CONTRIB_INSTALLER_VERSION','2.0.6');
define('CONFIG_FILENAME','install.xml');
define('INIT_CONTRIB_INSTALLER', 'contrib_installer.php');

define('CANT_CREATE_DIR_TEXT', 'Не могу создать директорию: ');
define('COLUDNT_REMOVE_DIR_TEXT', 'Не могу удалить директорию: ');
define('WRITE_PERMISSINS_NEEDED_TEXT', 'Необходимы права доступа на запись для: ');
define('COULDNT_REMOVE_FILE_TEXT', 'Не могу удалить файл: ');
define('COULDNT_COPY_TO_TEXT', 'Не могу скопировать файл: ');
define('COULDNT_FIND_TEXT', 'Не могу найти ');
define('NO_CONTRIBUTION_NAME_TEXT', 'Не указано название модуля.');
define('NAME_OF_FILE_MISSING_IN_ADDFILE_SECTION_TEXT', 'Название отсутствующего файла.');
define('NO_QUERY_TAG_IN_SQL_SECTION_TEXT', 'Нет тэга query.');
define('NO_REMOVE_QUERY_NESSESARY_FOR_SQL_QUERY_TEXT', 'Нет необходимого запроса на удаление для SQL запроса: ');
define('NAME_OF_DIR_MISSING_IN_MAKE_DIR_SECTION_TEXT', 'Название отсутствующей директории.');
define('IN_THE_FILE_TEXT', 'в файле: ');
define('NO_INSTALL_TAG_IN_PHP_SECTION_TEXT', 'Нет тэга INSTALL.');
define('NO_REMOVE_TAG_IN_PHP_SECTION_TEXT', 'Нет тэга REMOVE.');
define('FILE_NOT_EXISTS_TEXT', 'Файл не найден');
define('NAME_OF_FILE_MISSING_IN_DEL_FILE_SECTION_TEXT', 'Название отсутствующего файла.');
define('ERROR_COULD_NOT_OPEN_XML', 'Не могу открыть XML в: ');
define('TEXT_NOT_ORIGINAL_TEXT', 'Не оригинальный текст в find разделе. ');
define('TEXT_HAVE_BEEN_FOUND', 'был найден ');
define('TEXT_TIMES', ' раз!');
define('NO_COMMENTS_TAG_IN_DESCRIPTION_SECTION_TEXT', 'Нет тэга comments в разделе описания');
define('NO_CREDITS_TAG_IN_DESCRIPTION_SECTION_TEXT', 'Нет тэга credits в разделе описания');
define('NO_CONTRIB_REF_PARAMETER_IN_DETAILS_TAG_TEXT', 'Нет параметра contrib_ref в тэге details');
define('NO_FORUM_REF_PARAMETER_IN_DETAILS_TAG_TEXT', 'Нет параметра forum_ref в тэге details');
define('NO_CONTRIB_TYPE_PARAMETER_IN_DETAILS_TAG_TEXT', 'Нет параметра contrib_type в тэге details');
define('NO_STATUS_PARAMETER_IN_DETAILS_TAG_TEXT', 'Нет параметра status в тэге details');
define('NO_LAST_UPDATE_PARAMETER_IN_DETAILS_TAG_TEXT', 'Нет параметра last_update в тэге details');

define('TEXT_INFO_SUPPORT', 'Поддержка');
define('TEXT_INFO_CONTRIB', 'Информация о модуле');
define('CONTRIBS_PAGE_ALT','Официальная страница модуля');
define('CONTRIBS_PAGE','Официальная страница модуля');

define('CONTRIBS_FORUM_ALT','Форум поддержки данного модуля на официальном сайте магазина');
define('CONTRIBS_FORUM','Форум поддержки данного модуля на официальном сайте магазина');

define('CIP_STATUS_REMOVED_ALT', 'Модуль не был установлен');
define('CIP_STATUS_INSTALLED_ALT', 'Модуль установлен');

define('CIP_USES', 'CIP использует');
define('TEXT_DOESNT_EXISTS', ' не существует');

define('MSG_WAS_INSTALLED','Модуль установлен!');
define('MSG_WAS_APPLIED',' был также установлен!');
define('MSG_WAS_REMOVED','Модуль удалён!');

define('TEXT_POST_INSTALL_NOTES','Сообщение');

?>