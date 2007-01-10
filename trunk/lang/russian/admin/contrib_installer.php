<?php
/*
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2003 osCommerce
  Contrib Installer (c) 2005 Rinon
  Released under the GNU General Public License
*/

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

define('TEXT_HOW_TO_RESOVLE_CONFLICTS', '
This error message means that CIP (Contrib Installer Package) that you are installing tryes to change lines in file that was changed by another CIP before.<br>
If file was changed by hand you will see a message that says "Can\'t find...".<br>
<br>
<b>What to do?</b><br>
<br>
1.Open file from osCommerce and find lines that installed CIP tryes to change. <br>
You can see a comments above and below this lines.<br>
In comments you can find information about CIP that added/changes this lines.<br>
2. If CIP that make changes before don\'t really needed - remove them and install your CIP.<br>
If needed - read #3.<br>
<br>
3. Make a copy of CIP that you want to install.<br>
4. Change install.xml from copy of CIP.<br>
Use file from osCommerce that must be changed for that.<br>
<br>
May be you will find useful to compare 2 files <br>
use <i>diff /.../one_file.php /.../other_file.php -bu > 1.txt</i><br>
where<br>
other_file.php - file from osCommerce that have a conflict<br>
one_file.php - file from clear osCommerce or just remove CIP that changed lines that your CIP tryes change too.<br>
5. Try to install your new CIP.<br>
6. If all works. Add your name in install.xml an section "credits" and upload on oscommerce site :-)<br>
<br>
or<br>
<br>
ask a help on Contrib Installer forum.<br>');




//1.0.13:
define('PERMISSIONS_INFO_TEXT',
'Contribution page: <a target="_blank" href="http://www.oscommerce.com/community/contributions,3286">http://www.oscommerce.com/community/contributions,3286</a>
osCommerce Forums: <a target="_blank" href="http://forums.oscommerce.com/index.php?showtopic=156667">http://forums.oscommerce.com/index.php?showtopic=156667</a>

<h3>Credits:</h3>
<b>Rinon (culda_rinon@hotmail.com)</b>
modified from version 0.5 to '.CONTRIB_INSTALLER_VERSION.' by Vlad Savitsky (http://solti.com.ua)

<h3>What is Contrib Installer?</h3>
(from README.txt by Rinon)

In short, Contrib Installer is meant to be an easy way to install contributions for osCommerce.
To use Contrib Installer to install a contribution,
you must first have a package specially made for Contrib Installer.
Once you have a package for the contribution you want to install,
you can install and uninstall automatically.

<h3>How do I get Contrib Installer packages?</h3>
(from README.txt by Rinon)

Help us all out and make them yourself! No really, I need help making packages.
It\'s real easy, just have a look at the example_contribution included.
The important part is the install.xml file.
Once you\'ve made a package, email it to me please (culda_rinon@hotmail.com).

For those of you who don\'t want to make their own packages - I (and hopefully others) will be creating packages.
If you have a particular contribution you want to see in a Contrib Installer package,
please post on the Contrib Installer support thread (<a target="_blank" href="http://forums.oscommerce.com/index.php?showtopic=156667">http://forums.oscommerce.com/index.php?showtopic=156667</a>) on the forums.
Once these packages are made, I (and hopefully others) will post the packages under their respective contribution pages
and post an announcement in the Contrib Installer announcement thread (<a target="_blank" href="http://forums.oscommerce.com/index.php?showtopic=156668">http://forums.oscommerce.com/index.php?showtopic=156668</a>).

<h3>How To Install?</h3>
(How_To_Install.txt from Vlad Savitsky)

Contrib Installer just install yourself.
You need only copy Contrib Installer\'s files to correct place and open in browser
http://your site/admin/contrib_installer.php
than you will see a field with path for contribs.
Change it If you want and press "Continue".
You will see install log page (with or without errors).
If all OK - press "Back" and use it.


<h3>How To UpDate?</h3>
(How_To_UpDate.txt from Vlad Savitsky)

To update Contrib Installer You should:

1. Open in Admin Area - Tools/Contrib Installer
    or in browser go to http://your site/admin/contrib_installer.php

2. Remove all installed CIP\'s (Contrib Installer Package\'s)
    - because all info about installed CIP will be removed on step 4.

3. Remove installed Contrib Installer
    - you will see the initial page of Contrib Installer asking a path for contribs.

4. Leave your browser and open in any filemanager folder with your site

5. Copy new files from new version of Contrib Installer over old files (overwrite)

6. Go again to http://your site/admin/contrib_installer.php

7. Install Contrib Installer.


<h3>How To UpDate after Broken Install?</h3>
(How_To_UpDate_after_Broken_Install.txt from Vlad Savitsky)
To update Contrib Installer after broken installation
You should remove it by hands:

1. Remove folder with contributions

2. Files of Contrib Installer will be replaced so you don\'t need to remove them.

3. You should restore from folder /admin/backups/Contrib_Installer_<version> files
    which was modified by Contrib Installer.

4. In this folder also must be a database backup with "Contrib_Installer_<version>"  in the name.
    Restore database from this backup. Use osCommerce Admin/Tools/Database Backup or phpMyAdmin.

5. Now you have restored files and database which you have before you start installation of Contrib Installer.

<h3>How To Set Permissions?</h3>
(How_To_Set_Permissions.txt from Rinon)

!!IGNORE THIS STEP IF YOUR SERVER DOES NOT USE FILE PERMISSIONS (WINDOWS 98, 95)!!

Here\'s the tricky part...
You need to give the web server (probably apache)
permissions to alter your osCommerce files.
You can do this on a per-file basis
(Contrib Installer will tell you when it needs permissions),
or you can give the web server write access to the entire catalog directory
(I STRONGLY recommend the first option).
For the first option, just use your ftp client to change the permissions of the files
that Contrib Installer asks for to give everyone (aka world or other) write access.
Then after Contrib Installer is finished,
change the permissions back to their original values.

As an example of the second option
(again, I recommend setting the permissions as needed instead)
here are the commands that I use on a linux+apache server,
where www is the group that apache runs as, to give the web server write access
(these commands are executed in the directory above the catalog directory):

# chmod -R g+w catalog/
# chgrp -R www catalog/

After you finish installing whatever you want,
I run these commands but replace XXXX with whatever
the group was before you ran the first commands.

# chmod -R g-w catalog/
# chgrp -R XXXX catalog/

These commands are just what I use on linux, YMMV.


<h3>How To UnInstall?</h3>
(How_To_UnInstall.txt from Rinon)
You really don\'t want to use the Contrib Installer anymore?

OK, you\'ll need to
- go to admin/contrib_installer.php (in your web interface),
- choose Contrib Installer from the list,
- click "Remove",
- delete by hand files you\'ve added when install Contrib Installer.
');






//1.0.10


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

/*
define('

', '

');
define('

', '

');

*/
?>