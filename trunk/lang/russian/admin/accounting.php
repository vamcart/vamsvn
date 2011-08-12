<?php
/* --------------------------------------------------------------
   $Id: accounting.php 1125 2011-08-09 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.40 2002/12/29); www.oscommerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('ACCESS_CONFIGURATION', 'Админка - Настройки');
define('ACCESS_MODULES', 'Админка - Модули');
define('ACCESS_COUNTRIES', 'Админка - Разное - Места/Налоги - Страны');
define('ACCESS_CURRENCIES', 'Админка - Разное - Языки/Валюты - Валюты');
define('ACCESS_ZONES', 'Админка - Разное - Места/Налоги - Географические зоны');
define('ACCESS_GEO_ZONES', 'Админка - Разное - Места/Налоги - Регионы');
define('ACCESS_TAX_CLASSES', 'Админка - Разное - Места/Налоги - Виды налогов');
define('ACCESS_TAX_RATES', 'Админка - Разное - Места/Налоги - Ставки налогов');
define('ACCESS_ACCOUNTING', 'Админка - Покупатели - Клиенты - Доступ в админку');
define('ACCESS_BACKUP', 'Админка - Разное - Инструменты - Резервное копирование');
define('ACCESS_CACHE', 'Админка - Настройки - Основные - Кэш');
define('ACCESS_SERVER_INFO', 'Админка - Разное - Инструменты - Сервер инфо');
define('ACCESS_WHOS_ONLINE', 'Админка - Разное - Инструменты - Кто в онлайн?');
define('ACCESS_LANGUAGES', 'Админка - Разное - Языки/Валюты - Языки');
define('ACCESS_DEFINE_LANGUAGE', 'Админка - Разное - Языки/Валюты - Определить языки');
define('ACCESS_ORDERS_STATUS', 'Админка - Настройки - Статусы заказа');
define('ACCESS_SHIPPING_STATUS', 'Админка - Настройки - Время доставки');
define('ACCESS_MODULE_EXPORT', 'Админка - Модули - XT-Модули - Пакетная обработка картинок');
define('ACCESS_CUSTOMERS', 'Админка - Покупатели - Клиенты');
define('ACCESS_CREATE_ACCOUNT', 'Админка - Покупатели - Клиенты - Создать покупателя');
define('ACCESS_CUSTOMERS_STATUS', 'Админка - Покупатели - Группы клиентов');
define('ACCESS_ORDERS', 'Админка - Покупатели - Заказы');
define('ACCESS_CAMPAIGNS', 'Админка - Настройки - Кампании');
define('ACCESS_PRINT_PACKINGSLIP', 'Админка - Покупатели - Заказы - Накладная');
define('ACCESS_PRINT_ORDER', 'Админка  - Покупатели - Заказы - Счёт');
define('ACCESS_POPUP_MEMO', 'Админка - Покупатели - Заказы - Заметки');
define('ACCESS_COUPON_ADMIN', 'Админка - Разное - Купоны - Управление купонами');
define('ACCESS_LISTCATEGORIES', 'Админка - Разное - Купоны - Управление купонами - Список категорий');
define('ACCESS_GV_QUEUE', 'Админка - Разное - Купоны - Активация сертификатов');
define('ACCESS_GV_MAIL', 'Админка - Разное - Купоны - Отправить сертификат');
define('ACCESS_GV_SENT', 'Админка - Разное - Купоны - Отправленные сертификаты');
define('ACCESS_VALIDPRODUCTS', 'Админка - Разное - Купоны - Управление купонами - Доступ к товарам');
define('ACCESS_VALIDCATEGORIES', 'Админка - Разное - Купоны - Управление купонами - Доступ к категориям');
define('ACCESS_MAIL', 'Админка - Покупатели - Клиенты - Отправить E-Mail');
define('ACCESS_CATEGORIES', 'Админка - Каталог');
define('ACCESS_NEW_ATTRIBUTES', 'Админка - Каталог - Атрибуты - Установка');
define('ACCESS_PRODUCTS_ATTRIBUTES', 'Админка - Каталог - Атрибуты - Значения');
define('ACCESS_MANUFACTURERS', 'Админка - Каталог - Производители');
define('ACCESS_REVIEWS', 'Админка - Каталог - Отзывы');
define('ACCESS_SPECIALS', 'Админка - Каталог - Скидки');
define('ACCESS_STATS_PRODUCTS_EXPECTED', 'Админка - Разное - Статистика - Ожидаемые товары');
define('ACCESS_STATS_PRODUCTS_VIEWED', 'Админка - Разное - Статистика - Просмотренные товары');
define('ACCESS_STATS_PRODUCTS_PURCHASED', 'Админка - Разное - Статистика - Заказанные товары');
define('ACCESS_STATS_CUSTOMERS', 'Админка - Разное - Статистика - Лучшие клиенты');
define('ACCESS_STATS_SALES_REPORT', 'Админка - Разное - Статистика - Статистика продаж');
define('ACCESS_STATS_CAMPAIGNS', 'Админка - Разное - Статистика - Отчёт по кампаниям');
define('ACCESS_BANNER_MANAGER', 'Админка - Разное - Инструменты - Управление баннерами');
define('ACCESS_BANNER_STATISTICS', 'Админка - Разное - Инструменты - Управление баннерами - Статистика');
define('ACCESS_MODULE_NEWSLETTER', 'Админка - Разное - Инструменты - Письмо с новостями');
define('ACCESS_START', 'Админка - Главная старница админки');
define('ACCESS_CONTENT_MANAGER', 'Админка - Разное - Инструменты - Информационные страницы');
define('ACCESS_CONTENT_PREVIEW', 'Админка - Разное - Инструменты - Информационные страницы - Предварительный просмотр');
define('ACCESS_CREDITS', 'Админка - Разное - Инструменты - Авторы');
define('ACCESS_BLACKLIST', 'Админка - Разное - Инструменты - Черный список кредитных карт');
define('ACCESS_ORDERS_EDIT', 'Админка - Покупатели - Заказы - Редактирование заказа');
define('ACCESS_POPUP_IMAGE', 'Админка - Каталог - Popup окно с картинкой');
define('ACCESS_CSV_BACKEND', 'Админка - Разное - Инструменты - CSV импорт/экспорт');
define('ACCESS_PRODUCTS_VPE', 'Админка - Настройки - Единица упаковки');
define('ACCESS_CROSS_SELL_GROUPS', 'Админка - Настройки - Сопутствующие');
define('ACCESS_FCK_WRAPPER', 'Админка - Каталог - HTML-редактор');
define('ACCESS_EASYPOPULATE', 'Админка - Разное - Инструменты - Excel импорт/экспорт');
define('ACCESS_QUICK_UPDATES', 'Админка - Разное - Инструменты - Изменение цен');
define('ACCESS_LATEST_NEWS', 'Админка - Разное - Инструменты - Новости');
define('ACCESS_RECOVER_CART_SALES', 'Админка - Разное - Инструменты - Незавершённые заказы');
define('ACCESS_FEATURED', 'Админка - Каталог - Рекомендуемые товары');
define('ACCESS_CIP_MANAGER', 'Админка - Модули - Установка модулей');
define('ACCESS_AUTHORS', 'Админка - Разное - Статьи - Авторы');
define('ACCESS_ARTICLES', 'Админка - Разное - Статьи - Статьи/Разделы');
define('ACCESS_ARTICLES_CONFIG', 'Админка - Статьи - Настройка');
define('ACCESS_STATS_SALES_REPORT2', 'Админка - Разное - Статистика - Статистика продаж 2');
define('ACCESS_CHART_DATA', 'Админка - Главная страница - Flash графики статистики');
define('ACCESS_ARTICLES_XSELL', 'Админка - Статьи - Товары-Статьи');
define('ACCESS_EMAIL_MANAGER', 'Админка - Разное - Инструменты - Шаблоны писем');
define('ACCESS_CATEGORY_SPECIALS', 'Админка - Каталог - Скидки');
define('ACCESS_PRODUCTS_OPTIONS', 'Админка - Каталог - Атрибуты - Названия');
define('ACCESS_PRODUCT_EXTRA_FIELDS', 'Админка - Разное - Инструменты - Дополнительные поля товаров');
define('ACCESS_SHIP2PAY', 'Админка - Модули - Доставка-Оплата');
define('ACCESS_FAQ', 'Админка - Разное - Инструменты - Вопросы и ответы');
define('ACCESS_AFFILIATE_AFFILIATES', 'Админка - Разное - Партнёрка - Партнёры');
define('ACCESS_AFFILIATE_BANNERS', 'Админка - Разное - Партнёрка - Баннеры');
define('ACCESS_AFFILIATE_CLICKS', 'Админка - Разное - Партнёрка - Клики');
define('ACCESS_AFFILIATE_CONTACT', 'Админка - Разное - Партнёрка - Обратная связь');
define('ACCESS_AFFILIATE_INVOICE', 'Админка - Разное - Партнёрка - Выплаты - Счёт');
define('ACCESS_AFFILIATE_PAYMENT', 'Админка - Разное - Партнёрка - Выплаты');
define('ACCESS_AFFILIATE_POPUP_IMAGE', 'Админка - Разное - Партнёрка - Общая статистика - Popup окно подсказки');
define('ACCESS_AFFILIATE_SALES', 'Админка - Разное - Партнёрка - Продажи');
define('ACCESS_AFFILIATE_STATISTICS', 'Админка - Разное - Партнёрка - Партнёры - Статистика');
define('ACCESS_AFFILIATE_SUMMARY', 'Админка - Разное - Партнёрка - Общая статистика');
define('ACCESS_CUSTOMER_EXTRA_FIELDS', 'Админка - Разное - Инструменты - Дополнительные поля покупателей');
define('ACCESS_PARAMETERS','Админка - Каталог - Параметры');
define('ACCESS_PARAMETERS_EXPORT','Админка - Каталог - Импорт/экспорт параметров');
define('ACCESS_SELECT_FEATURED','Админка - Каталог - Рекомендуемые - Поиск');
define('ACCESS_SELECT_SPECIAL','Админка - Каталог - Скидки - Поиск');
define('ACCESS_YML_IMPORT','Админка - Разное - Я-маркет импорт/экспорт');
define('ACCESS_CUSTOMER_EXPORT','Админка - Покупатели - Клиенты - Экспорт клиентов');
define('ACCESS_EXPORTORDERS','Админка - Покупатели - Заказы - Экспорт заказов');
define('ACCESS_PIN_LOADER','Админка - Каталог - PIN коды');
define('ACCESS_EDIT_ORDERS','Админка - Заказы - Редактор заказа');
define('ACCESS_EDIT_ORDERS_ADD_PRODUCT','Админка - Заказы - Редактор заказа - Добавление товара');
define('ACCESS_EDIT_ORDERS_AJAX','Админка - Заказы - Редактор заказа - Ajax редактор');
define('ACCESS_PRODUCTS_SPECIFICATIONS','Админка - Каталог - Спецификации товаров');

?>