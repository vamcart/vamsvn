<?php
/* --------------------------------------------------------------
   $Id: russian.php 1213 2005-09-14 11:34:50Z VaM $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (english.php,v 1.8 2003/08/13); www.nextcommerce.org
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/
// Global

define('TEXT_FOOTER','Powered by <a href="http://oscommerce.su">VaM Shop</a>'); 
   
// Box names
define('BOX_LANGUAGE','Язык');
define('BOX_DB_CONNECTION','Соединение с базой данных') ;
define('BOX_WEBSERVER_SETTINGS','Настройки веб сервера');
define('BOX_DB_IMPORT','Импорт базы данных');
define('BOX_WRITE_CONFIG','Запись конфигурационных файлов');
define('BOX_ADMIN_CONFIG','Настройки администратора');
define('BOX_USERS_CONFIG','Настройки покупателей');

define('PULL_DOWN_DEFAULT','Выберите страну!');


// Error messages

 	// index.php
 	
	define('SELECT_LANGUAGE_ERROR','Выберите язык!');
	
	// step2,5.php
	
	define('TEXT_CONNECTION_ERROR','Соединение с базой данных не было установлено.');
	define('TEXT_CONNECTION_SUCCESS','Соединение с базой данных успешно установлено.');
	define('TEXT_DB_ERROR','Сообщение об ошибке:');
	define('TEXT_DB_ERROR_1','Нажмите Вернуться чтобы исправить допущенные ошибки.');
	define('TEXT_DB_ERROR_2','Если Вы не знаете информации для доступа к своей базе данных, свяжитесь с Вашим хостинг-провайдером.');
	
	// step6.php
	
	define('ENTRY_FIRST_NAME_ERROR','Имя слишком короткое');
	define('ENTRY_LAST_NAME_ERROR','Фамилия слишком короткая');
	define('ENTRY_EMAIL_ADDRESS_ERROR','Email слишком короткий');
	define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR','Проверьте формат Email');
	define('ENTRY_STREET_ADDRESS_ERROR','Улица слишком короткая');
	define('ENTRY_POST_CODE_ERROR','Почтовый индекс слишком короткий');
	define('ENTRY_CITY_ERROR','Город слишком короткий');
	define('ENTRY_COUNTRY_ERROR','Проверьте страну');
	define('ENTRY_STATE_ERROR','Проверьте регион');
	define('ENTRY_TELEPHONE_NUMBER_ERROR','Телефон слишком короткий');
	define('ENTRY_PASSWORD_ERROR','Проверьте пароль');
	define('ENTRY_STORE_NAME_ERROR','Название магазина слишком короткое');
	define('ENTRY_COMPANY_NAME_ERROR','Название компании слишком короткое');
	define('ENTRY_EMAIL_ADDRESS_FROM_ERROR','Поле Email от слишком короткое');
	define('ENTRY_EMAIL_ADDRESS_FROM_CHECK_ERROR','Проверьте формат Email от');
	define('SELECT_ZONE_SETUP_ERROR','Выберите регион');
	
	// step7.php

	define('ENTRY_DISCOUNT_ERROR','Гость - Скидки на товары');
	define('ENTRY_OT_DISCOUNT_ERROR','Гость - Скидки на странице подтверждения заказа');
	define('SELECT_OT_DISCOUNT_ERROR','Гость - Скидки на странице подтверждения заказа');
	define('SELECT_GRADUATED_ERROR','Гость - Скидки в зависимости от количества заказанных единиц товара');
	define('SELECT_PRICE_ERROR','Гость - Показывать цены');
	define('SELECT_TAX_ERROR','Гость - Показывать налог');
	define('ENTRY_DISCOUNT_ERROR2','По умолчанию - Скидки на товары');
	define('ENTRY_OT_DISCOUNT_ERROR2','По умолчанию - Скидки на странице подтверждения заказа');
	define('SELECT_OT_DISCOUNT_ERROR2','По умолчанию - Скидки на странице подтверждения заказа');
	define('SELECT_GRADUATED_ERROR2','По умолчанию - Скидки от количества заказанных единиц');
	define('SELECT_PRICE_ERROR2','По умолчанию - Показывать цены');
	define('SELECT_TAX_ERROR2','По умолчанию - Показывать налог');
	
	


	
	
// index.php

define('TITLE_SELECT_LANGUAGE','Выберите язык!');

define('TEXT_WELCOME_INDEX','VaM Shop - это интернет-магазин с открытым исходным кодом, разрабатываемый международным сообществом. Разрабатывается по модели открытых исходных кодов, установив VaM Shop, Вы получаете готовый к работе интернет-магазин.<br /><br />
      VaM Shop является открытой системой, работающей под управлением веб сервера Apache, в качестве базы данных используется MySQL, в качестве языка программирования используется PHP.<br /><br />
      VaM Shop может быть установлен на любой сервер, поддерживающий PHP и MySQL, в качестве операционной системы могут использоваться GNU/Linux, Solaris, BSD, либо Microsoft Windows.');
define('TEXT_WELCOME_STEP1','<b>Основные настройки доступа к базе данных и настройки веб сервера</b><br /><br />Укажите доступ к базе данных и настройки веб сервера.<br />');
define('TEXT_WELCOME_STEP2','<b>Установка базы данных</b><br /><br />VaM Shop автоматически установит базу данных магазина.');
define('TEXT_WELCOME_STEP3','<b>Импорт базы данных.</b><br /><br />');
define('TEXT_WELCOME_STEP4','<b>Настройка конфигурационных файлов VaM Shop</b><br /><br /><b>Если есть старые конфигурационные файлы от предыдущих установок, VaM Shop удалит их автоматически.</b><br /><br />Инсталлятор сконфигурирует основные параметры БД и структуру файлов.');
define('TEXT_WELCOME_STEP5','<b>Настройка веб сервера</b><br /><br />');
define('TEXT_WELCOME_STEP6','<b>Основные настройки магазина</b><br /><br />Инсталлятор создаст учётную запись администратора и выполнит обновление базы данных.<br />Информация о <b>Стране</b> и <b>Почтовом индексе</b> может использоваться при подсчете стоимости доставки и налогов.');
define('TEXT_WELCOME_STEP7','<b>Настройка групп покупателей</b><br /><br />VaM Shop предоставляет широкие возможности управления ценами и скидками.<br /><br />
<b>Скидка на товар</b><br />
Скидка может быть установлена как на каждый товар в отдельности, так и сразу на все товары путём установки скидки для группы покупателей.<br />
Если скидка на товар = 10.00% и скидка для группы = 5%, тогда будет использоваться скидка для группы, т.е. товар будет со скидкой 5%<br />
Если скидка на товар = 10.00% и скидка для группы = 15%, тогда будет использоваться скидка для товара, т.е. товар будет со скидкой 10%<br /><br />
<b>Скидка на странице подтверждения заказа</b><br />
Скидка от общей суммы заказа (после подсчёта налогов, доставки, пересчёта курса)<br /><br />
<b>Скидки в зависимости от количества заказанных единиц товара</b><br />
Скидка в зависимости от количества заказанных единиц товара может быть установлена как на каждый товар в отдельности, так и сразу на все товары путём установки скидки для группы покупателей.<br />
Вы можете комбинировать различные варианты, например:<br />
Группа покупателей 1 -> Стоимость товара Y в зависимости от количества заказанных единиц<br />
Группа покупателей 2 -> Скидка 10% на товар Y<br />
Группа покупателей 3 -> Специальная цена для данной группы покупателей на товар Y<br />
Группа покупателей 4 -> Стандартная цена на товар Y<br />
');
define('TEXT_WELCOME_FINISHED','<b>Установка VaM Shop успешно завершена!</b>');

// step1.php

define('TITLE_CUSTOM_SETTINGS','Настройки');
define('TEXT_IMPORT_DB','Импорт базы данных');
define('TEXT_IMPORT_DB_LONG','Импорт структуры базы данных VaM Shop.');
define('TEXT_AUTOMATIC','Автоматическая настройка');
define('TEXT_AUTOMATIC_LONG','Данные, которые Вы укажите, сохранятся в конфигурационных файлах каталога и администраторской часть магазина.');
define('TITLE_DATABASE_SETTINGS','Настройка базы данных');
define('TEXT_DATABASE_SERVER','Сервер базы данных');
define('TEXT_DATABASE_SERVER_LONG','Адрес либо IP-адрес сервера базы данных. Обычно сервер базы данных находится по адресу localhost, если Вы не знаете адрес сервера базы данных, свяжитесь со своим хостинг-провайдером.');
define('TEXT_USERNAME','Имя пользователя');
define('TEXT_USERNAME_LONG','Имя пользователя, используемое для подключения к базе данных.<br />Если Вы не знаете имя пользователя для доступа к базе данных, свяжитесь со своим хостинг-провайдером.');
define('TEXT_PASSWORD','Пароль');
define('TEXT_PASSWORD_LONG','Пароль, используемый для подключения к базе данных. <br />Если Вы не знаете пароль для доступа к базе данных, свяжитесь со своим хостинг-провайдером.');
define('TEXT_DATABASE','База данных');
define('TEXT_DATABASE_LONG','Название базы данных, которая будет использоваться для установки интернет-магазина.<br />Если Вы не знаете название базы данных, свяжитесь со своим хостинг-провайдером.');
define('TITLE_WEBSERVER_SETTINGS','Настройки веб сервера');
define('TEXT_WS_ROOT','Корневая директория веб-сервера');
define('TEXT_WS_ROOT_LONG','Полный путь до корневой директории, где находится html файлы, например <i>/home/myname/public_html</i><br /> В большинстве случаев, Вам не нужно прописывать путь до директории, скрипт установки автоматически определит местонахождение директории и пропишет путь автоматически.');
define('TEXT_WS_XTC','Директория интернет-магазина');
define('TEXT_WS_XTC_LONG','Путь до директории, где находится интернет-магазин, обычно <i>/</i> или <i>/home/myname/public_html/vamshop/</i><br /> В большинстве случаев, Вам не нужно прописывать путь до директории, скрипт установки автоматически определит местонахождение магазина и пропишет путь до директории автоматически.');
define('TEXT_WS_ADMIN','Директория админки интернет-магазина');
define('TEXT_WS_ADMIN_LONG','Путь до директории, где находится админка интернет-магазина, обычно <i>/admin/</i> или <i>/home/myname/public_html/vamshop/admin/</i><br /> В большинстве случаев, Вам не нужно прописывать путь до директории, скрипт установки автоматически определит местонахождение админки и пропишет путь до директории автоматически.');
define('TEXT_WS_CATALOG','Виртуальная директория интернет-магазина');
define('TEXT_WS_CATALOG_LONG','Виртуальная директория с магазином, например <i>/vamshop/</i><br /> В большинстве случаев, Вам не нужно прописывать директорию, скрипт установки автоматически определит местонахождение магазина и пропишет путь до виртуальной директории автоматически.');
define('TEXT_WS_ADMINTOOL','Виртуальная директория админки интернет-магазина');
define('TEXT_WS_ADMINTOOL_LONG','Виртуальная директория с админкой магазина, например <i>/vamshop/admin/</i><br /> В большинстве случаев, Вам не нужно прописывать директорию, скрипт установки автоматически определит местонахождение админки и пропишет путь до виртуальной директории автоматически.');

// step2.php

define('TEXT_PROCESS_1','Продолжайте установку, далее будет загружена база данных магазина.');
define('TEXT_PROCESS_2','Это важный этап установки магазина, не прерывайте его, в противном случае база данных может быть повреждена, либо загружена не полностью.');
define('TEXT_PROCESS_3','Файл базы данных должен находиться по следующему адресу: ');


// step3.php

define('TEXT_TITLE_ERROR','Произошла следующая ошибка:');
define('TEXT_TITLE_SUCCESS','База данных успешно импортирована!');

// step4.php

define('TITLE_WEBSERVER_CONFIGURATION','Настройка конфигурационных файлов:');
define('TITLE_STEP4_ERROR','Произошла следующая ошибка:');
define('TEXT_STEP4_ERROR','<b>Файлы настроек либо отсутствуют, либо установлены неверные права доступа.</b><br /><br />Установите права доступа 706 на следующий файл: ');
define('TEXT_STEP4_ERROR_1','Если <i>chmod 706</i> не выставляется, попробуйте <i>chmod 777</i>.');
define('TEXT_STEP4_ERROR_2','В операционной системе Windows вы просто должны убедиться, что данные файлы не имеют атрибут Только для чтения.');
define('TEXT_VALUES','Будут обновлены следующие конфигурационные файлы:');
define('TITLE_CHECK_CONFIGURATION','Пожалуйста, проверьте указанную информацию');
define('TEXT_HTTP','HTTP Сервер');
define('TEXT_HTTP_LONG','Название веб-сервера, например <i>http://www.myserver.com</i>, либо IP адрес сервера, например <i>http://192.168.0.1</i><br />В большинстве случаев, Вам не нужно прописывать адрес, скрипт установки автоматически определит адрес и пропишет его автоматически.');
define('TEXT_HTTPS','HTTPS Сервер');
define('TEXT_HTTPS_LONG','Название безопасного веб-сервера, например  <i>https://www.myserver.com</i>, либо IP адрес сервера, например <i>https://192.168.0.1</i><br />В большинстве случаев, Вам не нужно прописывать адрес, скрипт установки автоматически определит адрес и пропишет его автоматически.');
define('TEXT_SSL','Разрешить SSL подключения');
define('TEXT_SSL_LONG','Использовать соединение по безопасному протоколу SSL/HTTPS. Если Вы не знаете, что такое SSL, как настраивать данный протокол, настоятельно рекомендуется не использовать SSL, иначе интернет-магазин работать не будет.');
define('TITLE_CHECK_DATABASE','Пожалуйста, проверьте указанную информацию о базе данных');
define('TEXT_PERSIST','Разрешить постоянное подключение');
define('TEXT_PERSIST_LONG','Использовать постоянное подключение к базе данных.<br />Рекомендуется не включать данную опцию. Включайте данную опцию, если у Вас выделенный сервер.');
define('TEXT_SESS_FILE','Хранить сессии в файлах');
define('TEXT_SESS_DB','Хранить сессии в базе данных');
define('TEXT_SESS_LONG','Выберите, где хранить сессии: в файлах или в базе данных.');

// step5.php

define('TEXT_WS_CONFIGURATION_SUCCESS','<strong>VaM Shop</strong> - Настройка конфигурационных файлов успешно завершена!');

// step6.php

define('TITLE_ADMIN_CONFIG','Настройки администратора');
define('TEXT_REQU_INFORMATION','поля, отмеченные *, обязательны для заполнения');
define('TEXT_FIRSTNAME','Имя:');
define('TEXT_LASTNAME','Фамилия:');
define('TEXT_EMAIL','Email:');
define('TEXT_EMAIL_LONG','(для получения заказов)');				
define('TEXT_STREET','Адрес:');
define('TEXT_POSTCODE','Почтовый индекс:');
define('TEXT_CITY','Город:');
define('TEXT_STATE','Регион:');
define('TEXT_COUNTRY','Страна:');
define('TEXT_COUNTRY_LONG','Будет использоваться при подсчёте стоимости доставки и налогов');
define('TEXT_TEL','Телефон:');
define('TEXT_PASSWORD','Пароль:');
define('TEXT_PASSWORD_CONF','Подтверждение пароля:');
define('TITLE_SHOP_CONFIG','Настройки магазина');
define('TEXT_STORE','Название магазина:');
define('TEXT_STORE_LONG','(Название Вашего магазина)');
define('TEXT_EMAIL_FROM','Email от');
define('TEXT_EMAIL_FROM_LONG','(Email адрес, от которого будут отправлять все письма из магазина)');
define('TITLE_ZONE_CONFIG','Зоны');
define('TEXT_ZONE','Установить зоны Евросоюза?');
define('TITLE_ZONE_CONFIG_NOTE','* Замечание: VaM Shop может автоматически загрузить зоны Евросоюза в магазин.');
define('TITLE_SHOP_CONFIG_NOTE','* Замечание: Основные настройки магазина');
define('TITLE_ADMIN_CONFIG_NOTE','* Замечание: Настройки админа');
define('TEXT_ZONE_NO','Нет');
define('TEXT_ZONE_YES','Да');
define('TEXT_COMPANY','Название компании');



// step7

define('TITLE_GUEST_CONFIG','Настройки для гостей');
define('TITLE_GUEST_CONFIG_NOTE','* Замечание: Настройки для обычных посетителей магазина (не зарегистрированных посетителей)');
define('TITLE_CUSTOMERS_CONFIG','Настройки по умолчанию');
define('TITLE_CUSTOMERS_CONFIG_NOTE','* Замечание: Настройки для клиентов магазина (зарегистрированных покупателей)');
define('TEXT_STATUS_DISCOUNT','Скидка на товар');
define('TEXT_STATUS_DISCOUNT_LONG','Скидка на товар <i>(в процентах, например 10.00, 20.00)</i>');
define('TEXT_STATUS_OT_DISCOUNT_FLAG','Скидка на странице подтверждения заказа');
define('TEXT_STATUS_OT_DISCOUNT_FLAG_LONG','Разрешить посетителям получать скидку на странице подтверждения заказа');
define('TEXT_STATUS_OT_DISCOUNT','Скидка на странице подтверждения заказа');
define('TEXT_STATUS_OT_DISCOUNT_LONG','Скидка на странице подтверждения заказа <i>(в процентах, например 10.00, 20.00)</i>');
define('TEXT_STATUS_GRADUATED_PRICE','Цена в зависимости от количества заказанных единиц товара');
define('TEXT_STATUS_GRADUATED_PRICE_LONG','Разрешить посетителям видеть цены в зависимости от количества заказанных единиц товара');
define('TEXT_STATUS_SHOW_PRICE','Показывать цены');
define('TEXT_STATUS_SHOW_PRICE_LONG','Разрешить посетителям видеть цены в магазине');
define('TEXT_STATUS_SHOW_TAX','Показывать налог');
define('TEXT_STATUS_SHOW_TAX_LONG','Показывать цены с налогом (Да) или без налога (Нет)');


define('TITLE_CHMOD','Установка прав доступа на файлы');

// fnished.php

define('TEXT_SHOP_CONFIG_SUCCESS','Настройка магазина <strong>VaM Shop</strong> успешно завершена.');
define('TEXT_TEAM','<a href="http://oscommerce.su">Русская поддержка VaM Shop</a>');

// Сборка VaM

// step1

define('IMAGE_CONTINUE','Продолжить');
define('IMAGE_CANCEL','Отменить');
define('IMAGE_BACK','Вернуться');
define('IMAGE_RETRY','Повторить');
define('TEXT_RUSSIAN','Русский');
define('TEXT_ENGLISH','Английский');
define('TEXT_CHECKING','Проверка:');
define('TEXT_ATTENTION','Внимание:');
define('TITLE_INDEX','Установка VaM Shop - Добро пожаловать');
define('TITLE_STEP1','Установка VaM Shop - ШАГ 1 / Настройки');
define('TITLE_STEP2','Установка VaM Shop - ШАГ 2 / Подключение к базе данных');
define('TITLE_STEP3','Установка VaM Shop - ШАГ 3 / Импорт базы данных');
define('TITLE_STEP4','Установка VaM Shop - ШАГ 4 / Настройка веб сервера');
define('TITLE_STEP5','Установка VaM Shop - ШАГ 5 / Запись конфигурационных файлов');
define('TITLE_STEP6','Установка VaM Shop - ШАГ 6 / Создание админа');
define('TITLE_STEP7','Установка VaM Shop - ШАГ 7 / Настройка цен');
define('TITLE_FINISHED','Установка VaM Shop - Установка завершена');
define('CHARSET','windows-1251');
define('TEXT_INSTALL','Установка');
define('ERROR_PERMISSION','Неверные права доступа ');
define('TEXT_ERROR','ОШИБКА');
define('TEXT_FILE_PERMISSIONS','Права доступа файлов .............................. ');
define('TEXT_FOLDER_PERMISSIONS','Права доступа директорий .............................. ');
define('PHP_VERSION_ERROR','<b>Внимание!, Версия PHP слишком старая, для корректной работы VaM Shop необходим PHP 4.1.3 и выше.</b><br /><br />
                 Ваша версия PHP: <b><?php echo phpversion(); ?></b><br /><br />
                 VaM Shop не будет корректно работать на данном сервере, обновите PHP, либо смените сервер.');
define('TEXT_PHP_VERSION','Версия PHP .............................. ');
define('TEXT_GD_LIB_NOT_FOUND','ОШИБКА! БИБЛИОТЕКА GD НЕ НАЙДЕНА!');
//define('TEXT_GD_LIB_VERSION','Если версия GDlib < 2+ , нажмите для получения дополнительных инструкций');
define('TEXT_GD_LIB_VERSION','');
define('TEXT_GD_LIB_VERSION1','Версия GDlib .............................. ');
define('TEXT_GD_LIB_GIF_SUPPORT','Поддержка GIF в GDlib .............................. ');
define('TEXT_GD_LIB_GIF_SUPPORT_ERROR','<b><font color="ff0000">ОШИБКА</font></b><br />Установленная библиотека GDlib не поддерживает картинки в формате GIF, Вы не сможете использовать картинки GIF в магазине VaM Shop!');
define('TEXT_OK','Всё нормально');

//install_finished

define('TEXT_CATALOG','Каталог');

?>