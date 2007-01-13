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
define('TEXT_NEW_FOLDER', 'Новая папка');
define('TEXT_NEW_FOLDER_INTRO', 'Введите название новой папки:');
define('TEXT_DELETE_INTRO', 'Вы действительно хотите удалить данный файл?');
define('TEXT_UPLOAD_INTRO', 'Выберите файл для загрузки.');

define('ERROR_DIRECTORY_NOT_WRITEABLE', 'Ошибка: Нет доступа на запись в данную директорию. Установите правильные права доступа на: %s');
define('ERROR_FILE_NOT_WRITEABLE', 'Ошибка: Нет доступа на запись в данный файл. Установите правильные права доступа на: %s');
define('ERROR_DIRECTORY_NOT_REMOVEABLE', 'Ошибка: Не могу удалить данную директорию. Установите правильные права доступа на: %s');
define('ERROR_FILE_NOT_REMOVEABLE', 'Ошибка: Не могу удалить данный файл. Установите правильные права доступа на: %s');
define('ERROR_DIRECTORY_DOES_NOT_EXIST', 'Ошибка: Директория не найдена: %s');
//======================
define('ICON_UNZIP', 'Разархивировать');
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
define('CIP_MANAGER_SUPPORT_FORUM','Форум поддержки данного модуля на официальном сайте магазина');
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

define('INIT_CONTRIB_INSTALLER_TEXT', 'Установка модулей');
define('CONTRIB_INSTALLER_TEXT', 'Установка модулей');

//=========================
define('ALL_CHANGES_WILL_BE_REMOVED_TEXT', 'Все сделанные изменения были изменены.');
//=========================
define('AUTHOR_TEXT', 'Автор: ');
define('FROM_INSTALL_FILE_TEXT', 'Установочный файл: ');
//=========================
define('INSTALLING_CONTRIBUTION_TEXT', 'Устанавливаем модуль: ');
define('REMOVING_CONTRIBUTION_TEXT', 'Удаляем модуль: ');
//=========================
define('CANT_CREATE_DIR_TEXT', 'Не могу создать директорию: ');
define('CANT_WRITE_TO_DIR_TEXT', 'Не могу записать в файл: ');
define('COLUDNT_REMOVE_DIR_TEXT', 'Не могу удалить директорию: ');
//=========================
define('REMOVING_DIRS_IN_BOLD', 'Удаляем директорию: ');
define('CREATING_DIRS_IN_BOLD', 'Создаём директорию: ');
//=========================
define('WRITE_PERMISSINS_NEEDED_TEXT', 'Необходимы права доступа на запись для: ');
define('ADD_CODE_IN_FILE_TEXT', 'Новый код в файле: ');
define('EXPRESSION_TEXT', 'Код: ');
define('AFTER_EXPRESSION_ADD_TEXT', 'Оригинальный код: ');
define('ORIGINAL_AFTER_EXPRESSION_ADD_TEXT', 'Новый код после оригинала: ');
define('UNDO_ADD_CODE_IN_FILE_TEXT', 'Отменить добавление кода в файл: ');
define('ORIGINAL_EXPRESSION_TEXT', 'Оригинальный код: ');
define('ORIGINAL_REPLACE_WITH_TEXT', 'Замена на: ');
//=========================
define('CONFLICT_IN_FILE_TEXT', 'Конфликт в файле: ');
define('CANT_READ_FILE', 'Файл отсутствует: ');
define('REMOVING_FILE_TEXT', 'Удаляем файл: ');
define('COULDNT_REMOVE_FILE_TEXT', 'Не могу удалить файл: ');
define('COULDNT_COPY_TO_TEXT', 'Не могу скопировать файл: ');

//=========================
define('COULDNT_FIND_TEXT', 'Не могу найти ');
//define('CANT_OPEN_FOR_WRITING_TEXT', 'Не могу открыть файл для записи: ');
//=========================
define('CONTRIBUTION_DIR_TEXT', 'Директория с модулями: ');
define('NO_CONTRIBUTION_NAME_TEXT', 'Не указано название модуля.');
//=========================
define('NO_FILE_TAG_IN_ADDFILE_SECTION_TEXT', 'Нет тэга file.');
define('NAME_OF_FILE_MISSING_IN_ADDFILE_SECTION_TEXT', 'Название отсутствующего файла.');

define('NO_QUERY_TAG_IN_SQL_SECTION_TEXT', 'Нет тэга query.');
define('NO_REMOVE_QUERY_NESSESARY_FOR_SQL_QUERY_TEXT', 'Нет необходимого запроса на удаление для SQL запроса: ');
define('RUN_SQL_REMOVE_QUERY_TEXT', 'Выполнить SQL запрос на удаление: ');
define('RUN_SQL_QUERY_TEXT', 'Выполнить SQL запрос: ');

//=========================
define('NO_DIR_TAG_IN_MAKE_DIR_SECTION_TEXT', 'Нет тэга dir.');
define('NAME_OF_DIR_MISSING_IN_MAKE_DIR_SECTION_TEXT', 'Название отсутствующей директории.');
define('NAME_OF_PARENT_DIR_MISSING_IN_MAKE_DIR_SECTION_TEXT', 'Значение для parent_dir отсутствует.');

define('ERROR_IN_ADDCODE_SECTION_TEXT', 'Ошибка в <addcode>');
define('COPYING_TO_TEXT', 'Копируем в: ');
define('FIND_REPLACE_IN_FILE_TEXT', 'Поиск и замена в файле: ');
define('ERROR_IN_FINDREPLACE_SECTION_TEXT', 'Ошибка в <findreplace>');
define('UNDO_FIND_REPLACE_IN_FILE_TEXT', 'Отменить поиск и замену в файле: ');

define('REPLACE_WITH_TEXT', 'Заменить: ');
define('ON_LINE_TEXT', 'в строке ');
//=========================
define('UPDATE_BUTTON_TEXT', 'Обновить');
define('IN_THE_FILE_TEXT', 'в файле: ');

define('INSTALL_XML_FILE_IS_VALID_TEXT', 'Файл install.xml без ошибок.');
define('PERMISSIONS_IS_VALID_TEXT', 'Права доступа правильные.');

define('INSTALLATION_COMPLETE_TEXT', 'Установлен.');
define('REMOVING_COMPLETE_TEXT', 'Удалён.');


// Subheaders
define('COMMENTS_TEXT', 'Комментарии: ');
define('CHECKING_CONFIG_FILE_TEXT', 'Проверяем файл настроек: ');
define('CHECKING_PERMISSIONS_TEXT', 'Проверяем права доступа: ');
define('CHECKING_CONFLICTS_TEXT', 'Проверяем конфликты:');

//define('RUNNING_TEXT', 'Выполняем: ');
define('RUNNING_TEXT', 'Лог установки модулей: ');//1.0.4

define('STATUS_TEXT', 'Статус: ');

define('NO_CONFLICTS_TEXT', 'Нет конфликтов.');
define('PHP_INSTALL_TEXT', 'Устанавливаемый PHP код: ');
define('PHP_REMOVE_TEXT', 'Удаляемый PHP код: ');

define('PHP_RUNTIME_MESSAGES_TEXT', 'Сообщения PHP: ');

define('NO_INSTALL_TAG_IN_PHP_SECTION_TEXT', 'Нет тэга INSTALL.');
define('NO_REMOVE_TAG_IN_PHP_SECTION_TEXT', 'Нет тэга REMOVE.');


define('FILE_EXISTS_TEXT', 'Файл существует');
define('FILE_NOT_EXISTS_TEXT', 'Файл не найден');

define('LINK_EXISTS_TEXT', 'Ссылка существует.');



define('NAME_OF_FILE_MISSING_IN_DEL_FILE_SECTION_TEXT', 'Название отсутствующего файла.');
define('MD5_SUM_UPDATED_TEXT', 'MD5 сумма обновлена.');
define('MD5_SUM_REMOVED_TEXT', 'MD5 сумма удалена.');

define('FILE_EXISTS_AND_WAS_CHANGED_TEXT', 'Файл уже был изменён другим модулем. Вы должны: <br>
- сделать резервную копию файла,<br>
- вернуть оригинальный файл, без изменений,<br>
- установить модуль,<br>
- найти все изменения в файле в сравнении с оригиналом (отмечены комментариями),<br>
- перенести изменения из оригинального файла в файл, изменённый установщиком,<br>
- тестировать. <br>');
define('ERROR_COULD_NOT_OPEN_XML', 'Не могу открыть XML в: ');
define('ERROR_XML', 'Ошибка XML: ');
define('TEXT_AT_LINE', ' в строке ');

//1.0.6:
define('TEXT_NOT_ORIGINAL_TEXT', 'Не оригинальный текст find разделе. ');
define('TEXT_HAVE_BEEN_FOUND', 'был найден ');
define('TEXT_TIMES', ' раз!');

define('NO_COMMENTS_TAG_IN_DESCRIPTION_SECTION_TEXT', 'Нет тэга comments в разделе описания');
define('NO_CREDITS_TAG_IN_DESCRIPTION_SECTION_TEXT', 'Нет тэга credits в разделе описания');

define('NO_DETAILS_TAG_IN_DESCRIPTION_SECTION_TEXT', 'Нет тэга details в разделе описания');

define('NO_CONTRIB_REF_PARAMETER_IN_DETAILS_TAG_TEXT', 'Нет параметра contrib_ref в тэге details');
define('NO_FORUM_REF_PARAMETER_IN_DETAILS_TAG_TEXT', 'Нет параметра forum_ref в тэге details');
define('NO_CONTRIB_TYPE_PARAMETER_IN_DETAILS_TAG_TEXT', 'Нет параметра contrib_type в тэге details');
define('NO_STATUS_PARAMETER_IN_DETAILS_TAG_TEXT', 'Нет параметра status в тэге details');
define('NO_LAST_UPDATE_PARAMETER_IN_DETAILS_TAG_TEXT', 'Нет параметра last_update в тэге details');


//1.0.13
define('CHOOSE_A_CONTRIBUTION_TEXT', '
<a href="http://www.oscommerce.com/community?contributions=&search=Contrib+Installer&category=all" target=_blank">Искать модули на сайте osCommerce</a> или выберите модуль: ');


//1.0.14
define('IMAGE_BUTTON_INSTALL', 'Установить');
define('IMAGE_BUTTON_REMOVE', 'Удалить');

?>