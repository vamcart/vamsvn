<?php
/* --------------------------------------------------------------
   $Id: russian.php 1231 2017-11-07 17:37:58 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(german.php,v 1.99 2003/05/28); www.oscommerce.com 
   (c) 2003	 nextcommerce (german.php,v 1.24 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (english.php,v 1.4 2003/08/14); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contributions:
   Customers Status v3.x (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

// look in your $PATH_LOCALE/locale directory for available locales..
// on RedHat6.0 I used 'en_US'
// on FreeBSD 4.0 I use 'en_US.ISO_8859-1'
// this may not work under win32 environments..

@setlocale(LC_TIME, 'en_US');
define('DATE_FORMAT_SHORT', '%d/%m/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd/m/Y'); // this is used for date()
define('PHP_DATE_TIME_FORMAT', 'd/m/Y H:i:s'); // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');

// Global entries for the <html> tag
define('HTML_PARAMS','dir="ltr" lang="ru"');


// page title
define('TITLE', 'Админка - '. PROJECT_VERSION .' - '.STORE_NAME);

// header text in includes/header.php
define('HEADER_TITLE_TOP', 'Администрирование');
define('HEADER_TITLE_SUPPORT_SITE', 'Сайт поддержки');
define('HEADER_TITLE_DOCS', 'Документация');
define('HEADER_TITLE_ASK_A_QUESTION', 'Задать вопрос');
define('HEADER_TITLE_ONLINE_CATALOG', 'Магазин');
define('HEADER_TITLE_ADMINISTRATION', 'Администрация');

// text for gender
define('MALE', 'Мужской');
define('FEMALE', 'Женский');

// text for date of birth example
define('DOB_FORMAT_STRING', 'dd/mm/yyyy');

// configuration box text in includes/boxes/configuration.php

define('BOX_HEADING_CONFIGURATION','Настройки');
define('BOX_HEADING_CONFIGURATION_MAIN','Основные');
define('BOX_HEADING_MODULES','Модули');
define('BOX_HEADING_ZONE','Регионы/Налоги');
define('BOX_HEADING_CUSTOMERS','Покупатели');
define('BOX_HEADING_PRODUCTS','Каталог');
define('BOX_HEADING_OTHER','Разное');
define('BOX_HEADING_STATISTICS','Статистика');
define('BOX_HEADING_TOOLS','Инструменты');
define('BOX_HEADING_LOGOFF','Выход');
define('BOX_HEADING_HELP','Помощь');

define('BOX_CONTENT','Информационные страницы');
define('TEXT_ALLOWED', 'Разрешено');
define('TEXT_ACCESS', 'Доступ');
define('BOX_CONFIGURATION', 'Настройки');
define('BOX_CONFIGURATION_1', 'Мой магазин');
define('BOX_CONFIGURATION_2', 'Минимальные');
define('BOX_CONFIGURATION_3', 'Максимальные');
define('BOX_CONFIGURATION_4', 'Картинки');
define('BOX_CONFIGURATION_5', 'Данные покупателя');
define('BOX_CONFIGURATION_6', 'Модули');
define('BOX_CONFIGURATION_7', 'Доставка/Упаковка');
define('BOX_CONFIGURATION_8', 'Вывод товара');
define('BOX_CONFIGURATION_9', 'Склад');
define('BOX_CONFIGURATION_10', 'Логи');
define('BOX_CONFIGURATION_11', 'Кэш');
define('BOX_CONFIGURATION_12', 'Настройка E-Mail');
define('BOX_CONFIGURATION_13', 'Скачивание');
define('BOX_CONFIGURATION_14', 'GZip компрессия');
define('BOX_CONFIGURATION_15', 'Сессии');
define('BOX_CONFIGURATION_16', 'Мета теги');
define('BOX_CONFIGURATION_17', 'Разное');
define('BOX_CONFIGURATION_19', 'Счётчики');
define('BOX_CONFIGURATION_22', 'Настройки поиска');
define('BOX_CONFIGURATION_23', 'Яндекс-Маркет');
define('BOX_CONFIGURATION_24', 'Изменение цен');
define('BOX_CONFIGURATION_25', 'Установка модулей');
define('BOX_CONFIGURATION_27', 'Тех. обслуживание');
define('BOX_CONFIGURATION_29', 'Боксы');
define('BOX_CONFIGURATION_72', 'Редактор заказов');
define('BOX_CONFIGURATION_80', 'Оформление заказов');
define('BOX_CONFIGURATION_90', 'Социальные сети');
define('BOX_CONFIGURATION_100', '1С:Предприятие');
define('BOX_CONFIGURATION_1610', 'Спецификации товаров');

define('BOX_MODULES', 'Оплата/Доставка/Счета');
define('BOX_PAYMENT', 'Модули оплаты');
define('BOX_SHIPPING', 'Модули доставки');
define('BOX_ORDER_TOTAL', 'Модули итого');
define('BOX_CATEGORIES', 'Категории / Товары');
define('BOX_PRODUCTS_ATTRIBUTES', 'Атрибуты - Значения');
define('BOX_MANUFACTURERS', 'Производители');
define('BOX_REVIEWS', 'Отзывы о товарах');
define('BOX_CAMPAIGNS', 'Кампании');
define('BOX_XSELL_PRODUCTS', 'Сопутствующие товары');
define('BOX_SPECIALS', 'Скидки');
define('BOX_PRODUCTS_EXPECTED', 'Ожидаемые товары');
define('BOX_CUSTOMERS', 'Клиенты');
define('BOX_ACCOUNTING', 'Доступ админа');
define('BOX_CUSTOMERS_STATUS','Группы клиентов');
define('BOX_ORDERS', 'Заказы');
define('BOX_COUNTRIES', 'Страны');
define('BOX_ZONES', 'Регионы');
define('BOX_GEO_ZONES', 'Географические зоны');
define('BOX_TAX_CLASSES', 'Виды налогов');
define('BOX_TAX_RATES', 'Ставки налогов');
define('BOX_HEADING_REPORTS', 'Отчёты');
define('BOX_PRODUCTS_VIEWED', 'Просмотренные товары');
define('BOX_STOCK_WARNING','Информация о складе');
define('BOX_PRODUCTS_PURCHASED', 'Заказанные товары');
define('BOX_STATS_CUSTOMERS', 'Лучшие клиенты');
define('BOX_BACKUP', 'Резервное копирование');
define('BOX_BANNER_MANAGER', 'Управление баннерми');
define('BOX_CACHE', 'Кэш');
define('BOX_DEFINE_LANGUAGE', 'Языковые константы');
define('BOX_FILE_MANAGER', 'Файл менеджер');
define('BOX_MAIL', 'E-Mail центр');
define('BOX_NEWSLETTERS', 'Почтовые уведомления');
define('BOX_SERVER_INFO', 'Сервер инфо');
define('BOX_WHOS_ONLINE', 'Кто в оn-line?');
define('BOX_TPL_BOXES','Порядок сортировки боксов');
define('BOX_CURRENCIES', 'Валюты');
define('BOX_LANGUAGES', 'Языки');
define('BOX_ORDERS_STATUS', 'Статусы заказа');
define('BOX_ATTRIBUTES_MANAGER','Атрибуты - Установка');
define('BOX_PRODUCTS_ATTRIBUTES','Группы-Опции');
define('BOX_MODULE_NEWSLETTER','Письмо с новостями');
define('BOX_ORDERS_STATUS','Статус заказа');
define('BOX_SHIPPING_STATUS','Время доставки');
define('BOX_SALES_REPORT','Статистика продаж');
define('BOX_MODULE_EXPORT','XT-Модули');
define('BOX_HEADING_GV_ADMIN', 'Купоны');
define('BOX_GV_ADMIN_QUEUE', 'Активация сертификатов');
define('BOX_GV_ADMIN_MAIL', 'Отправить сертификат');
define('BOX_GV_ADMIN_SENT', 'Отправленные');
define('BOX_COUPON_ADMIN','Управление купонами');
define('BOX_TOOLS_BLACKLIST','Чёрный список карточек');
define('BOX_IMPORT','CSV импорт/экспорт');
define('BOX_PRODUCTS_VPE','Единица упаковки');
define('BOX_CAMPAIGNS_REPORT','Отчёт по кампаниям');
define('BOX_ORDERS_XSELL_GROUP','Сопутствующие');
define('BOX_SUPPORT_SITE','Сайт поддержки');
define('BOX_SUPPORT_FAQ','Вопросы и ответы');
define('BOX_SUPPORT_FORUM','Форум');
define('BOX_CONTRIBUTION_INSTALLER','Установка модулей');

define('TXT_GROUPS','<b>Группы</b>:');
define('TXT_SYSTEM','Система');
define('TXT_CUSTOMERS','Клиенты/Заказы');
define('TXT_PRODUCTS','Товары/Категории');
define('TXT_STATISTICS','Статистика');
define('TXT_TOOLS','Инструменты');
define('TEXT_ACCOUNTING','Доступ админа:');

//Dividers text for menu

define('BOX_HEADING_MODULES', 'Модули');
define('BOX_HEADING_LOCALIZATION', 'Языки/Валюты');
define('BOX_HEADING_TEMPLATES','Шаблоны');
define('BOX_HEADING_TOOLS', 'Инструменты');
define('BOX_HEADING_LOCATION_AND_TAXES', 'Места / Налоги');
define('BOX_HEADING_CUSTOMERS', 'Клиенты');
define('BOX_HEADING_CATALOG', 'Каталог');
define('BOX_MODULE_NEWSLETTER','Рассылка');

// javascript messages
define('JS_ERROR', 'При заполнении формы Вы допустили ошибки!\nСделайте, пожалуйста, следующие исправления:\n\n');

define('JS_OPTIONS_VALUE_PRICE', '* Новый атрибут товара дожен иметь цену\n');
define('JS_OPTIONS_VALUE_PRICE_PREFIX', '* Новый атрибут товара дожен иметь ценовой префикс\n');

define('JS_PRODUCTS_NAME', '* Для нового товара должно быть указано наименование\n');
define('JS_PRODUCTS_DESCRIPTION', '* Для нового товара должно быть указано описание\n');
define('JS_PRODUCTS_PRICE', '* Для нового товара должна быть указана цена\n');
define('JS_PRODUCTS_WEIGHT', '* Для нового товара должен быть указан вес\n');
define('JS_PRODUCTS_QUANTITY', '* Для нового товара должно быть указано количество\n');
define('JS_PRODUCTS_MODEL', '* Для нового товара должен быть указан код товара\n');
define('JS_PRODUCTS_IMAGE', '* Для нового товара должна быть картинка\n');

define('JS_SPECIALS_PRODUCTS_PRICE', '* Для этого товара должна быть установлена новая цена\n');

define('JS_GENDER', '* Поле \'Пол\' должно быть выбрано.\n');
define('JS_FIRST_NAME', '* Поле \'Имя\' должно содержать не менее ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' символов.\n');
define('JS_LAST_NAME', '* Поле \'Фамилия\' должно содержать не менее ' . ENTRY_LAST_NAME_MIN_LENGTH . ' символов.\n');
define('JS_DOB', '* Поле \'День рождения\' должно иметь формат: xx/xx/xxxx (день/месяц/год).\n');
define('JS_EMAIL_ADDRESS', '* Поле \'E-Mail адрес\' должно содержать не менее ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' символов.\n');
define('JS_ADDRESS', '* Поле \'Адрес\' должно содержать не менее ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' символов.\n');
define('JS_POST_CODE', '* Поле \'Индекс\' должно содержать не менее ' . ENTRY_POSTCODE_MIN_LENGTH . ' символов.\n');
define('JS_CITY', '* Поле \'Город\' должно содержать не менее ' . ENTRY_CITY_MIN_LENGTH . ' символов.\n');
define('JS_STATE', '* Поле \'Регион\' должно быть выбрано.\n');
define('JS_STATE_SELECT', '-- Выберите выше --');
define('JS_ZONE', '* Поле \'Регион\' должно соответствовать выбраной стране.');
define('JS_COUNTRY', '* Поле \'Страна\' дожно быть заполнено.\n');
define('JS_TELEPHONE', '* Поле \'Телефон\' должно содержать не менее ' . ENTRY_TELEPHONE_MIN_LENGTH . ' символов.\n');
define('JS_PASSWORD', '* Поля \'Пароль\' и \'Подтверждение\' должны совпадать и содержать не менее ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.\n');
define('JS_DISCOUNT', '* Поле производителя при выборе скидки не должно совпадать с предыдущими значениями.\n');

define('JS_ORDER_DOES_NOT_EXIST', 'Заказ номер %s не найден!');

define('CATEGORY_PERSONAL', 'Персональные данные');
define('CATEGORY_ADDRESS', 'Адрес');
define('CATEGORY_CONTACT', 'Для контакта');
define('CATEGORY_COMPANY', 'Компания');
define('CATEGORY_OPTIONS', 'Настройки');

define('ENTRY_SECOND_NAME', 'Отчество:');
define('ENTRY_GENDER', 'Пол:');
define('ENTRY_GENDER_ERROR', '&nbsp;<span class="errorText">обязательно</span>');
define('ENTRY_FIRST_NAME', 'Имя:');
define('ENTRY_FIRST_NAME_ERROR', '&nbsp;<span class="errorText">минимум ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' символов</span>');
define('ENTRY_LAST_NAME', 'Фамилия:');
define('ENTRY_LAST_NAME_ERROR', '&nbsp;<span class="errorText">минимум ' . ENTRY_LAST_NAME_MIN_LENGTH . ' символов</span>');
define('ENTRY_DATE_OF_BIRTH', 'Дата рождения:');
define('ENTRY_DATE_OF_BIRTH_ERROR', '&nbsp;<span class="errorText">(пример 21/05/1970)</span>');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail Адрес:');
define('ENTRY_EMAIL_ADDRESS_ERROR', '&nbsp;<span class="errorText">минимум ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' символов</span>');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', '&nbsp;<span class="errorText">Вы ввели неверный E-Mail адрес!</span>');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', '&nbsp;<span class="errorText">Данный E-Mail адрес уже зарегистрирован!</span>');
define('ENTRY_COMPANY', 'Компания:');
define('ENTRY_STREET_ADDRESS', 'Адрес:');
define('ENTRY_STREET_ADDRESS_ERROR', '&nbsp;<span class="errorText">минимум ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' символов</span>');
define('ENTRY_SUBURB', 'Район:');
define('ENTRY_POST_CODE', 'Индекс:');
define('ENTRY_POST_CODE_ERROR', '&nbsp;<span class="errorText">минимум ' . ENTRY_POSTCODE_MIN_LENGTH . ' символов</span>');
define('ENTRY_CITY', 'Город:');
define('ENTRY_CITY_ERROR', '&nbsp;<span class="errorText">минимум ' . ENTRY_CITY_MIN_LENGTH . ' символов</span>');
define('ENTRY_STATE', 'Регион:');
define('ENTRY_STATE_ERROR', '&nbsp;<span class="errorText">обязательно</span>');
define('ENTRY_COUNTRY', 'Страна:');
define('ENTRY_TELEPHONE_NUMBER', 'Телефон:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', '&nbsp;<span class="errorText">минимум ' . ENTRY_TELEPHONE_MIN_LENGTH . ' символов</span>');
define('ENTRY_FAX_NUMBER', 'Факс:');
define('ENTRY_NEWSLETTER', 'Рассылка:');
define('ENTRY_CUSTOMERS_STATUS', 'Статус клиента:');
define('ENTRY_NEWSLETTER_YES', 'Подписан');
define('ENTRY_NEWSLETTER_NO', 'Не подписан');
define('ENTRY_MAIL_ERROR','&nbsp;<span class="errorText">Выберите опцию</span>');
define('ENTRY_PASSWORD','Пароль (сгенерирован)');
define('ENTRY_PASSWORD_ERROR','&nbsp;<span class="errorText">минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов</span>');
define('ENTRY_MAIL_COMMENTS','Дополнительный текст в E-Mail:');

define('ENTRY_MAIL','Отправить письмо с паролем клиенту?');
define('YES','да');
define('NO','нет');
define('SAVE_ENTRY','Сохранить изменения?');
define('TEXT_CHOOSE_INFO_TEMPLATE','Шаблон для описания товара:');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE','Шаблон для атрибутов товара');
define('TEXT_SELECT','-- Выберите --');
define('TEXT_RESTOCK_0','Вычитать со склада');
define('TEXT_RESTOCK_1','Добавлять на склад');

// Icons
define('ICON_CROSS', 'Недействительно');
define('ICON_CURRENT_FOLDER', 'Текущая директория');
define('ICON_DELETE', 'Удалить');
define('ICON_ERROR', 'Ошибка:');
define('ICON_FILE', 'Файл');
define('ICON_FILE_DOWNLOAD', 'Загрузка');
define('ICON_FOLDER', 'Папка');
define('ICON_LOCKED', 'Заблокировать');
define('ICON_PREVIOUS_LEVEL', 'Предыдущий уровень');
define('ICON_PREVIEW', 'Выделить');
define('ICON_STATISTICS', 'Статистика');
define('ICON_SUCCESS', 'Выполнено');
define('ICON_TICK', 'Истина');
define('ICON_UNLOCKED', 'Разблокировать');
define('ICON_WARNING', 'ВНИМАНИЕ');

// constants for use in tep_prev_next_display 
define('TEXT_RESULT_PAGE', 'Страница %s из %d');
define('TEXT_DISPLAY_NUMBER_OF_BANNERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> баннеров)');
define('TEXT_DISPLAY_NUMBER_OF_COUNTRIES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> стран)');
define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> клиентов)');
define('TEXT_DISPLAY_NUMBER_OF_CURRENCIES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> валют)');
define('TEXT_DISPLAY_NUMBER_OF_LANGUAGES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> языков)');
define('TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> производителей)');
define('TEXT_DISPLAY_NUMBER_OF_NEWSLETTERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> писем)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> заказов)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS_STATUS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> статусов заказов)');
define('TEXT_DISPLAY_NUMBER_OF_XSELL_GROUP', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> групп сопутствующих товаров)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_VPE', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> упаковочных единиц)');
define('TEXT_DISPLAY_NUMBER_OF_SHIPPING_STATUS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> статусов доставок)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> товаров)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_EXPECTED', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> ожидаемых товаров)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> отзывов)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> скидок)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_CLASSES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> налоговых классов)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_ZONES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> налоговых зон)');
define('TEXT_DISPLAY_NUMBER_OF_TAX_RATES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> налоговых ставок)');
define('TEXT_DISPLAY_NUMBER_OF_ZONES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> регионов)');
define('TEXT_DISPLAY_NUMBER_OF_FEATURED', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> рекомендуемых товаров)');
define('TEXT_DISPLAY_NUMBER_OF_FAQS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> вопросов и ответов)');
define('TEXT_DISPLAY_NUMBER_OF_FAQ1S', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> вопросов посетителей)');
define('TEXT_DISPLAY_NUMBER_OF_NEWS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> новостей)');
define('TEXT_DISPLAY_NUMBER_OF_BLOCKS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> страниц)');
define('TEXT_DISPLAY_NUMBER_OF_ITEMS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> записей)');
define('TEXT_DISPLAY_NUMBER_OF_TAGS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> тэгов)');

define('PREVNEXT_BUTTON_PREV', 'Предыдущая');
define('PREVNEXT_BUTTON_NEXT', 'Следующая');

define('TEXT_DEFAULT', 'по умолчанию');
define('TEXT_SET_DEFAULT', 'Установить по умолчанию');
define('TEXT_FIELD_REQUIRED', '&nbsp;<span class="fieldRequired">* Обязательно</span>');

define('ERROR_NO_DEFAULT_CURRENCY_DEFINED', 'Ошибка: К настоящему времени ни одна валюта не была установлена по умолчанию. Пожалуйста, установите одну из них в: Локализация -> Валюта');

define('TEXT_CACHE_CATEGORIES', 'Бокс категорий');
define('TEXT_CACHE_MANUFACTURERS', 'Бокс производителей');
define('TEXT_CACHE_ALSO_PURCHASED', 'Бокс также заказывают'); 

define('TEXT_NONE', '--нет--');
define('TEXT_TOP', 'Начало');

define('ERROR_DESTINATION_DOES_NOT_EXIST', 'Ошибка: Каталог не существует.');
define('ERROR_DESTINATION_NOT_WRITEABLE', 'Ошибка: Каталог защищён от записи, установите необходимые права доступа.');
define('ERROR_FILE_NOT_SAVED', 'Ошибка: Файл не был загружен.');
define('ERROR_FILETYPE_NOT_ALLOWED', 'Ошибка: Нельзя закачивать файлы данного типа.');
define('SUCCESS_FILE_SAVED_SUCCESSFULLY', 'Выполнено: Файл успешно загружен.');
define('WARNING_NO_FILE_UPLOADED', 'Предупреждение: Ни одного файла не загружено.');

define('DELETE_ENTRY','Удалить запись?');
define('TEXT_PAYMENT_ERROR','<b>ПРЕДУПРЕЖДЕНИЕ:</b><br />Активируйте модули оплаты!');
define('TEXT_SHIPPING_ERROR','<b>ПРЕДУПРЕЖДЕНИЕ:</b><br />Активируйте модули доставки!');

define('TEXT_NETTO',' без налогов: ');

define('ENTRY_CID','Номер клиента:');
define('IP','IP заказа:');
define('CUSTOMERS_MEMO','Заметки:');
define('DISPLAY_MEMOS','Показать/написать');
define('TITLE_MEMO','Заметки');
define('ENTRY_LANGUAGE','Язык:');
define('CATEGORIE_NOT_FOUND','Категория не найдена!');

define('IMAGE_RELEASE', 'Активировать сертификат');

define('_JANUARY', 'Январь');
define('_FEBRUARY', 'Февраль');
define('_MARCH', 'Март');
define('_APRIL', 'Апрель');
define('_MAY', 'Май');
define('_JUNE', 'Июнь');
define('_JULY', 'Июль');
define('_AUGUST', 'Август');
define('_SEPTEMBER', 'Сентябрь');
define('_OCTOBER', 'Октябрь');
define('_NOVEMBER', 'Ноябрь');
define('_DECEMBER', 'Декабрь');

define('TEXT_DISPLAY_NUMBER_OF_GIFT_VOUCHERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> подарочных сертификатов)');
define('TEXT_DISPLAY_NUMBER_OF_COUPONS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> купонов)');

define('TEXT_VALID_PRODUCTS_LIST', 'Список товаров');
define('TEXT_VALID_PRODUCTS_ID', 'ID товара');
define('TEXT_VALID_PRODUCTS_NAME', 'Название  товара');
define('TEXT_VALID_PRODUCTS_MODEL', 'Модель товара');

define('TEXT_VALID_CATEGORIES_LIST', 'Список категорий');
define('TEXT_VALID_CATEGORIES_ID', 'ID категории');
define('TEXT_VALID_CATEGORIES_NAME', 'Название категории');

define('SECURITY_CODE_LENGTH_TITLE', 'Длина кода подарочного сертификата');
define('SECURITY_CODE_LENGTH_DESC', 'Введите длину кода подарочного купона');

define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_TITLE', 'Подарочный сертификат');
define('NEW_SIGNUP_GIFT_VOUCHER_AMOUNT_DESC', 'Если Вы не собираетесь отправлять посетителям после регистрации в магазине подарочный сертификат, укажите 0, либо укажите номинал подарочного сертификата, который будут получать посетители после регитсрации в интернет-магазине, например 10.00 или 50.00.');
define('NEW_SIGNUP_DISCOUNT_COUPON_TITLE', 'Код купона');
define('NEW_SIGNUP_DISCOUNT_COUPON_DESC', 'Если Вы не хотите отправлять посетителям после регистрации в магазине купон, не заполняйте данное поле. Если Вы хотите, что б посетитель после регистрации получал купон, укажите код существующего купона, который получит каждый зарегистрированный в интернет-магазине покупатель.');

define('TXT_ALL','Все');

// UST ID
define('BOX_CONFIGURATION_18', 'Vat код');
define('HEADING_TITLE_VAT','Vat код');
define('HEADING_TITLE_VAT','Vat код');
define('ENTRY_VAT_ID','Vat код');
define('TEXT_VAT_FALSE','<font color="FF0000">Проверен/Ошибка!</font>');
define('TEXT_VAT_TRUE','<font color="FF0000">Проверен/Всё правильно!</font>');
define('TEXT_VAT_UNKNOWN_COUNTRY','<font color="FF0000">Не проверен/Неизвестная страна!</font>');
define('TEXT_VAT_UNKNOWN_ALGORITHM','<font color="FF0000">Не проверен/Проверка недоступна!</font>');
define('ENTRY_VAT_ID_ERROR', '<font color="FF0000">* Ваш Vat код неправильный!</font>');

define('ERROR_GIF_MERGE','Отсутствует GDlib GIF-поддержка, соеденить картинки неудалось');
define('ERROR_GIF_UPLOAD','Отсутствует GDlib Gif-поддержка, обработка картинки GIF неудалась');

define('TEXT_REFERER','Реферер: ');

define('IMAGE_ICON_INFO','');
define('ERROR_IMAGE_DIRECTORY_CREATE', 'Ошибка: Ошибка при создании директории ');
define('TEXT_IMAGE_DIRECTORY_CREATE', 'Информация: Создана директория ');

//Сборка VaM

define('BOX_EASY_POPULATE','Excel импорт/экспорт');
define('BOX_CATALOG_QUICK_UPDATES', 'Изменение цен');

define('BOX_CATALOG_LATEST_NEWS', 'Новости');
define('BOX_CATALOG_BLOCK', 'Закрыть от индексации');
define('IMAGE_NEW_NEWS_ITEM', 'Добавить новость');

define('TABLE_HEADING_CUSTOMERS', 'Последние покупатели');
define('TABLE_HEADING_LASTNAME', 'Фамилия');
define('TABLE_HEADING_FIRSTNAME', 'Имя');
define('TABLE_HEADING_DATE', 'Дата');

define('TABLE_HEADING_ORDERS', 'Последние заказы');
define('TABLE_HEADING_CUSTOMER', 'Покупатель');
define('TABLE_HEADING_NUMBER', 'Номер заказа');
define('TABLE_HEADING_ORDER_TOTAL', 'Сумма');
define('TABLE_HEADING_STATUS', 'Статус');

define('TABLE_HEADING_SUMMARY_PRODUCTS', 'Последние товары');
define('TABLE_HEADING_PRODUCT_NAME', 'Товары');
define('TABLE_HEADING_PRODUCT_PRICE', 'Стоимость');

define('TABLE_HEADING_NEWS', 'Последние новости');

define('BOX_TOOLS_RECOVER_CART', 'Незавершённые заказы');

define('BOX_FEATURED', 'Рекомендуемые товары');

define('TEXT_HEADER_DEFAULT','Главная');
define('TEXT_HEADER_SUPPORT','Поддержка');
define('TEXT_HEADER_SHOP','Магазин');
define('TEXT_HEADER_LOGOFF','Выход');
define('TEXT_HEADER_PAGES','Страницы');
define('TEXT_HEADER_ARTICLES','Статьи');
define('TEXT_HEADER_NEWS','Новости');

define('BOX_CACHE_FILES', 'Контроль кэша');

define('BOX_HEADING_ARTICLES', 'Статьи');
define('BOX_TOPICS_ARTICLES', 'Статьи/Разделы');
define('BOX_ARTICLES_CONFIG', 'Настройка');
define('BOX_ARTICLES_AUTHORS', 'Авторы');
define('BOX_ARTICLES_REVIEWS', 'Отзывы'); 
define('BOX_ARTICLE_REVIEWS', 'Отзывы о статьях'); 
define('BOX_AUTHOR_REVIEWS', 'Отзывы об авторах'); 
define('BOX_ARTICLES_XSELL', 'Товары-Статьи');
define('IMAGE_NEW_TOPIC', 'Новый раздел');
define('IMAGE_NEW_ARTICLE', 'Новая статья');
define('TEXT_DISPLAY_NUMBER_OF_AUTHORS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> авторов)'); 

define('TEXT_SUMMARY_STAT','Статистика');
define('TEXT_SUMMARY_CUSTOMERS','Покупатели');
define('TEXT_SUMMARY_ORDERS','Заказы');
define('TEXT_SUMMARY_PRODUCTS','Товары');
define('TEXT_SUMMARY_NEWS','Новости');

define('BOX_SALES_REPORT2','Статистика продаж 2');

define('TEXT_PHP_MAILER_ERROR','Не удалось отправить email.<br />');
define('TEXT_PHP_MAILER_ERROR1','Ошибка: ');

define('BOX_TOOLS_EMAIL_MANAGER','Шаблоны писем');

define('BOX_CATEGORY_SPECIALS', 'Категории со скидками');
define('TEXT_DISPLAY_NUMBER_OF_SPECIAL_CATEGORY', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> категорий со скидками)');

define('IMAGE_ICON_STATUS_GREEN', 'Активна');
define('IMAGE_ICON_STATUS_GREEN_LIGHT', 'Активизировать');
define('IMAGE_ICON_STATUS_RED', 'Неактивна');
define('IMAGE_ICON_STATUS_RED_LIGHT', 'Сделать неактивной');

define('TEXT_IMAGE_NONEXISTENT','Нет картинки!');

define('TEXT_TOGGLE_EDITOR', 'Включить/Выключить HTML-редактор');

define('WARNING_MODULES_SORT_ORDER','ВНИМАНИЕ: Значение опции порядок сортировки у модулей не должно повторяться!');

define('BOX_PRODUCTS_OPTIONS', 'Атрибуты - Названия');

define('BOX_MODULES_SHIP2PAY','Доставка-оплата');
define('TEXT_DISPLAY_NUMBER_OF_PAYMENTS','Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> зависимостей)');

define('BOX_PRODUCT_EXTRA_FIELDS','Доп. поля товаров');
define('TEXT_EDIT_FIELDS','Редактировать дополнительные поля товаров.');
define('TEXT_ADD_FIELDS','Добавить дополнительные поля товаров.');

define('BOX_CATALOG_FAQ', 'Вопросы и ответы');
define('BOX_CATALOG_FAQ1', 'Вопросы посетителей');

require_once(DIR_FS_LANGUAGES . $_SESSION['language'].'/admin/'.'affiliate_' . $_SESSION['language'] .'.php');

define('BOX_HEADING_CUSTOMER_EXTRA_FIELDS', 'Доп. поля покупателей');
define('ENTRY_EXTRA_FIELDS_ERROR', 'Поле %s должно содержать как минимум %d символов');
define('TEXT_DISPLAY_NUMBER_OF_FIELDS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> полей)');

define('VAMSHOP_SUPPORT_KEY_TEXT','<a href="http://vamshop.ru/key.php" target="_blank"><u>Ключ поддержки:</u></a>');
define('VAMSHOP_REGISTER_SUPPORT_KEY','<a href="http://vamshop.ru/key.php" target="_blank">получить бесплатный ключ</a>.');
define('VAMSHOP_SUPPORT_KEY',(file_exists(DIR_FS_CATALOG .'vamshop.key') ? implode('', file(DIR_FS_CATALOG .'vamshop.key')) : VAMSHOP_REGISTER_SUPPORT_KEY));

define('WARNING_VAMSHOP_DEMO', 'Демонстрационная версия VamShop. Оформите заказ на полноценную, неограниченную версию VamShop с технической поддержкой и обновлениями в официальном магазине <a href="https://vamshop.ru/vamshop.html" target="_blank">https://vamshop.ru/vamshop.html</a>');

define('TEXT_ACCESS_FORBIDDEN','Нет доступа');

define('TEXT_MANUAL_LINK','Справка');
define('MANUAL_LINK_EDIT_CATEGORY','http://manual.vamshop.ru/ch05.html#edit-category');
define('MANUAL_LINK_NEW_CATEGORY','http://manual.vamshop.ru/ch05.html#new-category');
define('MANUAL_LINK_PRODUCTS','http://manual.vamshop.ru/ch05s03.html');
define('MANUAL_LINK_MANUFACTURERS','http://manual.vamshop.ru/ch05s02.html');
define('MANUAL_LINK_EASYPOPULATE','http://manual.vamshop.ru/catalog.html#easypopulate');
define('MANUAL_LINK_ATTRIBUTE','http://manual.vamshop.ru/ch05s05.html');
define('MANUAL_LINK_TAX','http://manual.vamshop.ru/ch05s06.html');
define('MANUAL_LINK_FILTERS','http://manual.vamshop.ru/ch05s07.html');
define('MANUAL_LINK_GV','http://manual.vamshop.ru/ch09.html');
define('MANUAL_LINK_COUPONS','http://manual.vamshop.ru/ch09s02.html');
define('MANUAL_LINK_AFFILIATE','http://manual.vamshop.ru/ch10.html');
define('MANUAL_LINK_NEWSLETTER','http://manual.vamshop.ru/ch12.html#id2647059');
define('MANUAL_LINK_RCS','http://manual.vamshop.ru/ch12s03.html');
define('MANUAL_LINK_NEWS','http://manual.vamshop.ru/ch13.html');
define('MANUAL_LINK_INFOPAGES','http://manual.vamshop.ru/ch13s02.html');
define('MANUAL_LINK_FAQ','http://manual.vamshop.ru/ch13s03.html');
define('MANUAL_LINK_ARTICLES','http://manual.vamshop.ru/ch13s04.html');
define('MANUAL_LINK_BACKUP','http://manual.vamshop.ru/ch13s06.html');
define('MANUAL_LINK_TAGS','http://manual.vamshop.ru');

define('TXT_FREE','<span class="Requirement"><strong>free</strong></span>');

define('TEXT_PRINT_EAN','Штрих-код');

define('text_zero', 'ноль');
define('text_three', 'три');
define('text_four', 'четыре');
define('text_five', 'пять');
define('text_six', 'шесть');
define('text_seven', 'семь');
define('text_eight', 'восемь');
define('text_nine', 'девять');
define('text_ten', 'десять');
define('text_eleven', 'одиннадцать');
define('text_twelve', 'двенадцать');
define('text_thirteen', 'тринадцать');
define('text_fourteen', 'четырнадцать');
define('text_fifteen', 'пятнадцать');
define('text_sixteen', 'шестнадцать');
define('text_seventeen', 'семнадцать');
define('text_eighteen', 'восемнадцать');
define('text_nineteen', 'девятнадцать');
define('text_twenty', 'двадцать');
define('text_thirty', 'тридцать');
define('text_forty', 'сорок');
define('text_fifty', 'пятьдесят');
define('text_sixty', 'шестьдесят');
define('text_seventy', 'семьдесят');
define('text_eighty', 'восемьдесят');
define('text_ninety', 'девяносто');
define('text_hundred', 'сто');
define('text_two_hundred', 'двести');
define('text_three_hundred', 'триста');
define('text_four_hundred', 'четыреста');
define('text_five_hundred', 'пятьсот');
define('text_six_hundred', 'шестьсот');
define('text_seven_hundred', 'семьсот');
define('text_eight_hundred', 'восемьсот');
define('text_nine_hundred', 'девятьсот');
define('text_penny', 'копейки');
define('text_kopecks', 'копеек');
define('text_single_kopek', 'одна копейка');
define('text_two_penny', 'две копейки');
define('text_ruble', 'рубля');
define('text_rubles', 'рублей');
define('text_one_ruble', 'один рубль');
define('text_two_rubles', 'два рубля');
define('text_thousands', 'тысячи');
define('text_thousand', 'тысяч');
define('text_one_thousand', 'одна тысяча');
define('text_two_thousand', 'две тысячи');
define('text_million', 'миллиона');
define('text_millions', 'миллионов');
define('text_one_million', 'один миллион');
define('text_two_million', 'два миллиона');
define('text_billion', 'миллиарда');
define('text_billions', 'миллиардов');
define('text_one_billion', 'один миллиард');
define('text_two_billion', 'два миллиарда');
define('text_trillion', 'триллиона');
define('text_trillions', 'триллионов');
define('text_one_trillion', 'один триллион');
define('text_two_trillion', 'два триллиона');

define('BOX_YML_IMPORT','Я-маркет импорт/экспорт');

define('TABLE_TEXT_IS_PIN','Товар имеет PIN код');
define('BOX_CATALOG_PIN_LOADER','PIN коды');

// Products Specifications
define('BOX_CATALOG_PRODUCTS_SPECIFICATIONS', 'Спецификации товаров');

define('BOX_HEADING_ORDERS','Заказы');
define('BUTTON_ORDERS_EXPORT','Экспорт заказов');

define('BOX_ATTRIBUTES_MANAGER_CATEGORIES','Установка атрибутов категории');

define('TEXT_PRODUCTS_ATTRIBUTES','Атрибуты товара');

define('BOX_ANSWER_TEMPLATES','Шаблоны ответов');
define('BOX_PRODUCT_LABELS','Ярлыки товаров');
define('TEXT_LABEL','Ярлык');

define('BOX_COMPANY_REVIEWS', 'Отзывы о производителях');

define('BOX_SITE_REVIEWS', 'Отзывы о магазине');

define('BOX_CONFIGURATION_1611', 'Карточки компаний');

define('CG_COMPANY_TEXT_SETTINGS', 'Карточки компаний');
define('CG_COMPANY_TEXT_SETTINGS_TITLE', 'Карточки компаний');
define('CG_COMPANY_TEXT_SETTINGS_DESC', '');

define('TEXT_ADD_REVIEW', 'Добавить отзыв');

define('TEXT_CATEGORY_DISCOUNT', 'Скидки по категориям');
define('TEXT_MANUFACTURER_DISCOUNT', 'Скидки по брэндам');
define('TEXT_DISPLAY_NUMBER_OF_SPECIAL_MANUFACTURER', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> брэндов со скидками)');

define('BOX_HEADING_MARKETING', 'Маркетинг');

define('BOX_MERKETING_1', 'Скидка на способ оплаты');
define('BOX_MERKETING_2', 'Скидка на способ доставки');
define('BOX_MERKETING_3', 'Наценка на способ оплаты');
define('BOX_MERKETING_4', 'Наценка на способ доставки');
define('BOX_MERKETING_5', 'Скидка на сумму заказа');
define('BOX_MERKETING_6', 'Скидка от количества единиц в заказе');
define('BOX_MERKETING_7', 'Индивидуальная скидка покупателя');
define('BOX_MERKETING_8', 'Индивидуальная скидка покупателя на брэнд');
define('BOX_MERKETING_9', 'Скидка от суммы заказа для групп');
define('BOX_MERKETING_10', 'Скидка от количества единиц товара для групп');
define('BOX_MERKETING_11', 'Скидка группам покупателей');
define('BOX_MERKETING_12', 'Накопительная система скидок');
define('BOX_MERKETING_13', 'Максимально возможная скидка');
define('BOX_MERKETING_14', 'Купоны');
define('BOX_MERKETING_15', 'Подарочные сертификаты');
define('BOX_MERKETING_16', 'Партнёрская программа');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Выберите');
define('TEXT_NOT_FOUND', 'Не найдено.');

define('TEXT_NAVIGATION', 'Навигация');

define('TEXT_SUMMARY_VAMSHOP_NEWS','Новости VamShop');
define('TEXT_SUMMARY_TOTAL_ORDERS','Всего заказов');
define('TEXT_SUMMARY_TOTAL_SALES','Сумма продаж');
define('TEXT_SUMMARY_TOTAL_CUSTOMERS','Всего клиентов');
define('TEXT_SUMMARY_PENDING_ORDERS','Новых заказов');

define('TEXT_CLEAR_CACHE','Очистить кэш');

define('BOX_HEADING_CONTENT', 'Контент');

define('BOX_TAGS', 'Плитка тэгов');

define('TEXT_DELETE','удалить');

define('RATING_STAR_5','Отличный');
define('RATING_STAR_4','Хороший');
define('RATING_STAR_3','Нормальный');
define('RATING_STAR_2','Так себе');
define('RATING_STAR_1','Плохой');

define('TEXT_STAR_5','5 звёзд');
define('TEXT_STAR_4','4 звезды');
define('TEXT_STAR_3','3 звезды');
define('TEXT_STAR_2','2 звезды');
define('TEXT_STAR_1','1 звезда');

define('ANSWER_SUBJECT','Добавлен ответ на Ваш вопрос!');

define('TEXT_SCHET_1','Поставщик');
define('TEXT_SCHET_2','Адрес');
define('TEXT_SCHET_3','Телефон');
define('TEXT_SCHET_4','Факс');
define('TEXT_SCHET_5','Р/с');
define('TEXT_SCHET_6','в банке');
define('TEXT_SCHET_7','К/с');
define('TEXT_SCHET_8','БИК');
define('TEXT_SCHET_9','ИНН');
define('TEXT_SCHET_10','КПП');
define('TEXT_SCHET_11','ОГРН');
define('TEXT_SCHET_12','Код по ОКПО');
define('TEXT_SCHET_13','Покупатель');
define('TEXT_SCHET_14','Доставка:');
define('TEXT_SCHET_15','Телефон:');
define('TEXT_SCHET_16','E-Mail:');
define('TEXT_SCHET_17','Счет №');
define('TEXT_SCHET_18','№ п/п');
define('TEXT_SCHET_19','Н/номер');
define('TEXT_SCHET_20','Наименование товара, услуг');
define('TEXT_SCHET_21','Количество');
define('TEXT_SCHET_22','Цена');
define('TEXT_SCHET_23','Сумма руб.');
define('TEXT_SCHET_24','Сумма прописью:');
define('TEXT_SCHET_25','Без НДС.');
define('TEXT_SCHET_26','Директор');
define('TEXT_SCHET_27','Фамилия');
define('TEXT_SCHET_28','Главный бухгалтер');
define('TEXT_SCHET_29','МП');
define('TEXT_SCHET_30','от');

define('TEXT_PACKINGSLIP_1','Отправитель:');
define('TEXT_PACKINGSLIP_2','Адрес');
define('TEXT_PACKINGSLIP_3','Телефон');
define('TEXT_PACKINGSLIP_4','Факс');
define('TEXT_PACKINGSLIP_5','Р/с');
define('TEXT_PACKINGSLIP_6','в банке');
define('TEXT_PACKINGSLIP_7','К/с');
define('TEXT_PACKINGSLIP_8','БИК');
define('TEXT_PACKINGSLIP_9','ИНН');
define('TEXT_PACKINGSLIP_10','КПП');
define('TEXT_PACKINGSLIP_11','ОГРН');
define('TEXT_PACKINGSLIP_12','Код по ОКПО');
define('TEXT_PACKINGSLIP_13','Покупатель');
define('TEXT_PACKINGSLIP_14','Доставка:');
define('TEXT_PACKINGSLIP_15','Телефон:');
define('TEXT_PACKINGSLIP_16','E-Mail:');
define('TEXT_PACKINGSLIP_17','Накладная №');
define('TEXT_PACKINGSLIP_18','№ п/п');
define('TEXT_PACKINGSLIP_19','Артикул');
define('TEXT_PACKINGSLIP_20','Наименование товара, услуг');
define('TEXT_PACKINGSLIP_21','Количество');
define('TEXT_PACKINGSLIP_22','Цена');
define('TEXT_PACKINGSLIP_23','Сумма руб.');
define('TEXT_PACKINGSLIP_24','Сумма прописью:');
define('TEXT_PACKINGSLIP_25','Без НДС.');
define('TEXT_PACKINGSLIP_26','Отпустил');
define('TEXT_PACKINGSLIP_27','Фамилия');
define('TEXT_PACKINGSLIP_28','Получил');
define('TEXT_PACKINGSLIP_29','МП');
define('TEXT_PACKINGSLIP_30','Получатель:');
define('TEXT_PACKINGSLIP_31','от');

?>