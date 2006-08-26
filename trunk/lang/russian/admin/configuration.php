<?php
/* -----------------------------------------------------------------------------------------
   $Id: configuration.php 1286 2006-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.8 2002/01/04); www.oscommerce.com
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/25); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('TABLE_HEADING_CONFIGURATION_TITLE', 'Название');
define('TABLE_HEADING_CONFIGURATION_VALUE', 'Значение');
define('TABLE_HEADING_ACTION', 'Действие');

define('TEXT_INFO_EDIT_INTRO', 'Пожалуйста, внесите необходимые изменения');
define('TEXT_INFO_DATE_ADDED', 'Дата добавления:');
define('TEXT_INFO_LAST_MODIFIED', 'Последнее изменение:');

// language definitions for config
define('STORE_NAME_TITLE' , 'Название магазина');
define('STORE_NAME_DESC' , 'Название Вашего магазина');
define('STORE_OWNER_TITLE' , 'Владелец');
define('STORE_OWNER_DESC' , 'Владелец интернет-магазина');
define('STORE_OWNER_EMAIL_ADDRESS_TITLE' , 'Email адрес');
define('STORE_OWNER_EMAIL_ADDRESS_DESC' , 'Email адрес владельца магазина');

define('EMAIL_FROM_TITLE' , 'E-Mail от');
define('EMAIL_FROM_DESC' , 'E-mail в отправляемых из магазина письмах.');

define('STORE_COUNTRY_TITLE' , 'Страна');
define('STORE_COUNTRY_DESC' , 'Местонахождение магазина.<br /><br /><b>Замечание: Не забудьте выбрать регион.</b>');
define('STORE_ZONE_TITLE' , 'Регион');
define('STORE_ZONE_DESC' , 'Регион магазина.');

define('EXPECTED_PRODUCTS_SORT_TITLE' , 'Порядок сортировки ожидаемых товаров');
define('EXPECTED_PRODUCTS_SORT_DESC' , 'Укажите порядок сортировки для ожидаемых товаров, по возрастанию - asc или по убыванию - desc.');
define('EXPECTED_PRODUCTS_FIELD_TITLE' , 'Сортировка ожидаемых товаров');
define('EXPECTED_PRODUCTS_FIELD_DESC' , 'По какому значению будут сортироваться ожидаемые товары.');

define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE' , 'Переключение на валюту текущего языка');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC' , 'Автоматическое переключение цен в магазине на валюту текущего языка.');

define('SEND_EXTRA_ORDER_EMAILS_TO_TITLE' , 'Отправка копий писем с заказом:');
define('SEND_EXTRA_ORDER_EMAILS_TO_DESC' , 'Если Вы хотите получать письма с заказами, т.е. такие же письма, что и получает клиент после оформления заказа, укажите e-mail адрес для получения копий писем в следующем формате: Имя 1 &lt;email@address1&gt;, Имя 2 &lt;email@address2&gt;');

define('SEARCH_ENGINE_FRIENDLY_URLS_TITLE' , 'Использовать короткие URL адреса');
define('SEARCH_ENGINE_FRIENDLY_URLS_DESC' , 'Использовать короткие URL адреса в магазине');

define('DISPLAY_CART_TITLE' , 'Переходить в корзину после добавления товара');
define('DISPLAY_CART_DESC' , 'Переходить в корзину после добавления товара в корзину или оставаться на той же странице.');

define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE' , 'Разрешить гостям использовать функцию Рассказать другу');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC' , 'Позволить гостям использовать функцию магазина Рассказать другу, если нет, то данной функцией могут пользоваться только зарегистрированные пользователи магазина.');

define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE' , 'Оператор поиска по умолчанию');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC' , 'Укажите, какой оператор будет использоваться по умолчанию при осуществлении посетителем поиска в магазине.');

define('STORE_NAME_ADDRESS_TITLE' , 'Адрес и телефон магазина');
define('STORE_NAME_ADDRESS_DESC' , 'Здесь Вы можете указать адрес и телефон магазина.');

define('SHOW_COUNTS_TITLE' , 'Показывать счётчик товаров');
define('SHOW_COUNTS_DESC' , 'Показывает количество товара в каждой категории. При большом количестве товара в магазина рекомендуется отключать счётчик - false, чтобы снизить нагрузку на MySQL сервер, тем самых скорость загрузки страницы Вашего магазина увеличится.');

define('DISPLAY_PRICE_WITH_TAX_TITLE' , 'Показывать цены с налогами');
define('DISPLAY_PRICE_WITH_TAX_DESC' , 'Показывать цены в магазине с налогами (true) или показывать налог только на заключительном этапе оформления заказа (false)');

define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_TITLE' , 'Статус людей из Администрации');
define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_DESC' , 'Выберите статус людей из команды Администрации!');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_TITLE' , 'Статус покупателя Посетитель');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_DESC' , 'Каким будет по умолчанию статус Посетителя перед регистрацией');
define('DEFAULT_CUSTOMERS_STATUS_ID_TITLE' , 'Статус покупателя для Покупателя');
define('DEFAULT_CUSTOMERS_STATUS_ID_DESC' , 'Каким будет по умолчанию статус Покупателя после регистрации');

define('ALLOW_ADD_TO_CART_TITLE' , 'Разрешить добавлять в корзину');
define('ALLOW_ADD_TO_CART_DESC' , 'Разрешить покупателю добавлять товар в корзину если его статус &quot;показывать цены&quot; выставлен в 0');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_TITLE' , 'Разрешить скидку на атрибуты товара');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_DESC' , 'Разрешить покупателю получить скидку на товар с атрибутами (если основной товар не находится в разделе &quot;Спец. цена&quot;)');
define('CURRENT_TEMPLATE_TITLE' , 'Шаблоны');
define('CURRENT_TEMPLATE_DESC' , 'Выберите шаблон по умолчанию. Шаблоны находятся в папке /templates');

define('CC_KEYCHAIN_TITLE','Шифрование номера кредитной карты');
define('CC_KEYCHAIN_DESC','Строка для шифрования номера кредитной карты (пожалуйста, измените!)');

define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE' , 'Имя');
define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC', 'Минимальное количество символов поля Имя');
define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE' , 'Фамилия');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC', 'Минимальное количество символов поля Фамилия');
define('ENTRY_DOB_MIN_LENGTH_TITLE' , 'Дата рождения');
define('ENTRY_DOB_MIN_LENGTH_DESC', 'Минимальное количество символов поля Дата рождения');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE' , 'E-Mail адрес');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC', 'Минимальное количество символов поля E-Mail адрес');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE' , 'Адрес');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC', 'Минимальное количество символов поля Адрес');
define('ENTRY_COMPANY_MIN_LENGTH_TITLE' , 'Компания');
define('ENTRY_COMPANY_MIN_LENGTH_DESC', 'Минимальное количество символов поля Компания');
define('ENTRY_POSTCODE_MIN_LENGTH_TITLE' , 'Почтовый индекс');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC', 'Минимальное количество символов поля Почтовый индекс');
define('ENTRY_CITY_MIN_LENGTH_TITLE' , 'Город');
define('ENTRY_CITY_MIN_LENGTH_DESC', 'Минимальное количество символов поля Город');
define('ENTRY_STATE_MIN_LENGTH_TITLE' , 'Регион');
define('ENTRY_STATE_MIN_LENGTH_DESC', 'Минимальное количество символов поля Регион');
define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE' , 'Телефон');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC', 'Минимальное количество символов поля Телефон');
define('ENTRY_PASSWORD_MIN_LENGTH_TITLE' , 'Пароль');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC', 'Минимальное количество символов поля Пароль');

define('CC_OWNER_MIN_LENGTH_TITLE' , 'Владелец кредитной карточки');
define('CC_NUMBER_MIN_LENGTH_TITLE' , 'Номер кредитной карточки');
define('CC_OWNER_MIN_LENGTH_DESC', 'Минимальное количество символов поля Владелец кредитной карточки');
define('CC_NUMBER_MIN_LENGTH_DESC', 'Минимальное количество символов поля Номер кредитной карточки');

define('REVIEW_TEXT_MIN_LENGTH_TITLE' , 'Текст отзыва');
define('REVIEW_TEXT_MIN_LENGTH_DESC', 'Минимальное количество символов для отызов');

define('MIN_DISPLAY_BESTSELLERS_TITLE' , 'Лидеры продаж');
define('MIN_DISPLAY_BESTSELLERS_DESC', 'Минимальное количество товара, выводимого в блоке Лидеры продаж');
define('MIN_DISPLAY_ALSO_PURCHASED_TITLE' , 'Также заказали');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC', 'Минимальное количество товара, выводимого в боксе Также заказали');

define('MAX_ADDRESS_BOOK_ENTRIES_TITLE' , 'Записи в адресной книге');
define('MAX_ADDRESS_BOOK_ENTRIES_DESC', 'Максимальное количество записей, которые может сделать покупатель в своей адресной книге');
define('MAX_DISPLAY_SEARCH_RESULTS_TITLE' , 'Товаров на одной странице в каталоге');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC', 'Количество товара, выводимого на одной странице');
define('MAX_DISPLAY_PAGE_LINKS_TITLE' , 'Ссылок на страницы');
define('MAX_DISPLAY_PAGE_LINKS_DESC', 'Количество ссылок на другие страницы');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE' , 'Специальные цены');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC', 'Максимальное количество товара, выводимого на странице Скидки');
define('MAX_DISPLAY_NEW_PRODUCTS_TITLE' , 'Новинки');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC', 'Максимальное количество товара, выводимых в боксе Новинки');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE' , 'Ожидаемые товары');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC', 'Максимальное количество товара, выводимого в блоке Ожидаемые товары');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE' , 'Список производителей');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC', 'Данная опция используется для настройки бокса производителей, если число производителей превышает указанное в данной опции, список производителей будет выводиться в виде drop-down списка, если число производителей меньше указанного в данной опции, производители будут выводиться в виде списка.');
define('MAX_MANUFACTURERS_LIST_TITLE' , 'Производители в виде развёрнутого меню');
define('MAX_MANUFACTURERS_LIST_DESC', 'Данная опция используется для настройки бокса производителей, если указана цифра \'1\', то список производителей выводится в виде стандартного drop-down списка. Если указана любая другая цифра, то выводится только X производителей в виде развёрнутого меню.');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE' , 'Ограничение длины названия производителя');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC', 'Данная опция используется для настройки бокса производителей, Вы указываете количество символов, выводимого в боксе производителей, если название производителя будет состоять из большего количества символов, то будут выведены первые X символов названия');
define('MAX_DISPLAY_NEW_REVIEWS_TITLE' , 'Новые отзывы');
define('MAX_DISPLAY_NEW_REVIEWS_DESC', 'Максимальное количество выводимых новых отзывов');
define('MAX_RANDOM_SELECT_REVIEWS_TITLE' , 'Выбор случайных отзывов');
define('MAX_RANDOM_SELECT_REVIEWS_DESC', 'Количество отзывов, которое будет использоваться для вывода случайного, т.е. если указано X - число отзывов, то случайный отзыв будет выбран из этих X отзывов');
define('MAX_RANDOM_SELECT_NEW_TITLE' , 'Выбор случайного товара в боксе Новинки');
define('MAX_RANDOM_SELECT_NEW_DESC', 'Количество товара, среди которого будет выбран случайный товар и выведен в бокс Новинок, т.е. если указано число X, то новый товар, который будет показан в боксе Новинок будет выбран из этих X новых товаров');
define('MAX_RANDOM_SELECT_SPECIALS_TITLE' , 'Выбор случайного товара в боксе Скидки');
define('MAX_RANDOM_SELECT_SPECIALS_DESC', 'Количество товара, среди которого будет выбран случайный товар и выведен в бокс Скидки, т.е. если указано число X, то товар, который будет показан в боксе Скидки будет выбран из этих X товаров');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE' , 'Количество категорий в строке');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC', 'Сколько категорий выводить в одной строке');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE' , 'Количество Новинок на странице');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC', 'Максимальное количество новинок, выводимых на одной странице в разделе Новинки');
define('MAX_DISPLAY_BESTSELLERS_TITLE' , 'Лидеры продаж');
define('MAX_DISPLAY_BESTSELLERS_DESC', 'Максимальное количество лидеров продаж, выводимых в боксе Лидеры продаж');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE' , 'Также заказали');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC', 'Максимальное количество товаров в боксе Наши покупатели также заказали');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE' , 'Бокс История заказов');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC', 'Максимальное количество товаров, выводимых в боксе История заказов');
define('MAX_DISPLAY_ORDER_HISTORY_TITLE' , 'История заказов');
define('MAX_DISPLAY_ORDER_HISTORY_DESC', 'Максимальное количество заказов, выводимых на странице История заказов');
define('MAX_PRODUCTS_QTY_TITLE', 'Максимальное количество товаров');
define('MAX_PRODUCTS_QTY_DESC', 'Максимальное количество одинаковых товаров в корзине покупателя');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_TITLE' , 'Максимальное количество дней для нового товара');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_DESC' , 'Сколько дней товар будет считаться новым и будет отображаться в новых товарах');


define('PRODUCT_IMAGE_THUMBNAIL_ACTIVE_TITLE' , 'Разрешить генерацию картинки на странице списка товаров в категории');
define('PRODUCT_IMAGE_THUMBNAIL_ACTIVE_DESC' , 'Разрешить использование библиотеки GD для картинки на странице списка товаров в категории. Если установлено false, то не забудьте вручную загрузить картинки через ftp.');
define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_TITLE' , 'Ширина превьюшки на странице списка товаров в категории');
define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_DESC' , 'Ширина превьюшки на странице списка товаров в категории в пикселах');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_TITLE' , 'Высота превьюшки на странице списка товаров в категории');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_DESC' , 'Высота превьюшки на странице списка товаров в категории в пикселах');

define('PRODUCT_IMAGE_INFO_ACTIVE_TITLE' , 'Разрешить генерацию картинки на странице карточки товара');
define('PRODUCT_IMAGE_INFO_ACTIVE_DESC' , 'Разрешить использование библиотеки GD для картинки на странице карточки товара. Если установлено false, то не забудьте вручную загрузить картинки через ftp.');
define('PRODUCT_IMAGE_INFO_WIDTH_TITLE' , 'Ширина картинки на странице карточки товара');
define('PRODUCT_IMAGE_INFO_WIDTH_DESC' , 'Ширина картинки на странице карточки товара в пикселах');
define('PRODUCT_IMAGE_INFO_HEIGHT_TITLE' , 'Высота картинки на странице карточки товара');
define('PRODUCT_IMAGE_INFO_HEIGHT_DESC' , 'Высота картинки на странице карточки товара в пикселах');

define('PRODUCT_IMAGE_POPUP_ACTIVE_TITLE' , 'Разрешить генерацию картинки в pop-up окне');
define('PRODUCT_IMAGE_POPUP_ACTIVE_DESC' , 'Разрешить использование библиотеки GD для картинки в pop-up окне. Если установлено false, то не забудьте вручную загрузить картинки через ftp.');
define('PRODUCT_IMAGE_POPUP_WIDTH_TITLE' , 'Ширина картинки в pop-up окне');
define('PRODUCT_IMAGE_POPUP_WIDTH_DESC' , 'Ширина картинки в pop-up окне в пикселах (например 300). Если значение оставить пустым, то картинка не будет создана совсем!');
define('PRODUCT_IMAGE_POPUP_HEIGHT_TITLE' , 'Высота картинки в pop-up окне');
define('PRODUCT_IMAGE_POPUP_HEIGHT_DESC' , 'Высота картинки в pop-up окне в пикселах');

define('SMALL_IMAGE_WIDTH_TITLE' , 'Ширина маленькой картинки');
define('SMALL_IMAGE_WIDTH_DESC' , 'Ширина маленькой картинки (в пикселах)');
define('SMALL_IMAGE_HEIGHT_TITLE' , 'Высота маленькой картинки');
define('SMALL_IMAGE_HEIGHT_DESC' , 'Высота маленькой картинки (в пикселах)');

define('HEADING_IMAGE_WIDTH_TITLE' , 'Ширина картинки категории');
define('HEADING_IMAGE_WIDTH_DESC' , 'Ширина картинки категории (в пикселах)');
define('HEADING_IMAGE_HEIGHT_TITLE' , 'Высота картинки категории');
define('HEADING_IMAGE_HEIGHT_DESC' , 'Высота картинки категории (в пикселах)');

define('SUBCATEGORY_IMAGE_WIDTH_TITLE' , 'Ширина картинки подкатегории');
define('SUBCATEGORY_IMAGE_WIDTH_DESC' , 'Ширина картинки подкатегории (в пикселах)');
define('SUBCATEGORY_IMAGE_HEIGHT_TITLE' , 'Высота картинки подкатегории');
define('SUBCATEGORY_IMAGE_HEIGHT_DESC' , 'Высота картинки подкатегории (в пикселах)');

define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE' , 'Вычислять размер картинки');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC' , 'Вычислять размер картинки');

define('IMAGE_REQUIRED_TITLE' , 'Показывать картинку в любом случае');
define('IMAGE_REQUIRED_DESC' , 'Необходимо для поиска ошибок, в случае, если картинка не выводится.');

//This is for the Images showing your products for preview. All the small stuff.

define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_TITLE' , 'Маленькая картинка товара:Bevel<br /><img src="images/config_bevel.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_DESC' , 'Маленькая картинка товара:Bevel<br /><br />По умолчанию: (8,FFCCCC,330000)<br /><br />затененные скошенные края<br />Используется:<br />(край ширина,hex свелый цвет,hex темный цвет)');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_TITLE' , 'Маленькая картинка товара:Greyscale<br /><img src="images/config_greyscale.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_DESC' , 'Маленькая картинка товара:Greyscale<br /><br />По умолчанию: (32,22,22)<br /><br />basic black n white<br />Используется:<br />(int red,int green,int blue)');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_TITLE' , 'Маленькая картинка товара:Ellipse<br /><img src="images/config_eclipse.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_DESC' , 'Маленькая картинка товара:Ellipse<br /><br />По умолчанию: (FFFFFF)<br /><br />ellipse on bg colour<br />Используется:<br />(hex background colour)');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_TITLE' , 'Маленькая картинка товара:Round-edges<br /><img src="images/config_edge.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_DESC' , 'Маленькая картинка товара:Round-edges<br /><br />По умолчанию: (5,FFFFFF,3)<br /><br />corner trimming<br />Используется:<br />(edge_radius,background colour,anti-alias width)');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_TITLE' , 'Маленькая картинка товара:Merge<br /><img src="images/config_merge.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_DESC' , 'Маленькая картинка товара:Merge<br /><br />По умолчанию: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Используется:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity, transparent colour on merge image)');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_TITLE' , 'Маленькая картинка товара:Frame<br /><img src="images/config_frame.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_DESC' , 'Маленькая картинка товара:Frame<br /><br />По умолчанию: <br /><br />plain raised border<br />Используется:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_TITLE' , 'Маленькая картинка товара:Drop-Shadow<br /><img src="images/config_shadow.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_DESC' , 'Маленькая картинка товара:Drop-Shadow<br /><br />По умолчанию: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Используется:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_TITLE' , 'Маленькая картинка товара:Motion-Blur<br /><img src="images/config_motion.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_DESC' , 'Маленькая картинка товара:Motion-Blur<br /><br />По умолчанию: (4,FFFFFF)<br /><br />fading parallel lines<br />Используется:<br />(int number of lines,hex background colour)');

//And this is for the Images showing your products in single-view

define('PRODUCT_IMAGE_INFO_BEVEL_TITLE' , 'Картинка на странице товара:Bevel');
define('PRODUCT_IMAGE_INFO_BEVEL_DESC' , 'Картинка на странице товара:Bevel<br /><br />По умолчанию: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Используется:<br />(edge width, hex light colour, hex dark colour)');
define('PRODUCT_IMAGE_INFO_GREYSCALE_TITLE' , 'Картинка на странице товара:Greyscale');
define('PRODUCT_IMAGE_INFO_GREYSCALE_DESC' , 'Картинка на странице товара:Greyscale<br /><br />По умолчанию: (32,22,22)<br /><br />basic black n white<br />Используется:<br />(int red, int green, int blue)');
define('PRODUCT_IMAGE_INFO_ELLIPSE_TITLE' , 'Картинка на странице товара:Ellipse');
define('PRODUCT_IMAGE_INFO_ELLIPSE_DESC' , 'Картинка на странице товара:Ellipse<br /><br />По умолчанию: (FFFFFF)<br /><br />ellipse on bg colour<br />Используется:<br />(hex background colour)');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_TITLE' , 'Картинка на странице товара:Round-edges');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_DESC' , 'Картинка на странице товара:Round-edges<br /><br />По умолчанию: (5,FFFFFF,3)<br /><br />corner trimming<br />Используется:<br />( edge_radius, background colour, anti-alias width)');
define('PRODUCT_IMAGE_INFO_MERGE_TITLE' , 'Картинка на странице товара:Merge');
define('PRODUCT_IMAGE_INFO_MERGE_DESC' , 'Картинка на странице товара:Merge<br /><br />По умолчанию: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Используется:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('PRODUCT_IMAGE_INFO_FRAME_TITLE' , 'Картинка на странице товара:Frame');
define('PRODUCT_IMAGE_INFO_FRAME_DESC' , 'Картинка на странице товара:Frame<br /><br />По умолчанию: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Используется:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_TITLE' , 'Картинка на странице товара:Drop-Shadow');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_DESC' , 'Картинка на странице товара:Drop-Shadow<br /><br />По умолчанию: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Используется:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_TITLE' , 'Картинка на странице товара:Motion-Blur');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_DESC' , 'Картинка на странице товара:Motion-Blur<br /><br />По умолчанию: (4,FFFFFF)<br /><br />fading parallel lines<br />Используется:<br />(int number of lines,hex background colour)');

//so this image is the biggest in the shop this

define('PRODUCT_IMAGE_POPUP_BEVEL_TITLE' , 'Картинка в pop-up окне:Bevel');
define('PRODUCT_IMAGE_POPUP_BEVEL_DESC' , 'Картинка в pop-up окне:Bevel<br /><br />По умолчанию: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Используется:<br />(edge width,hex light colour,hex dark colour)');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_TITLE' , 'Картинка в pop-up окне:Greyscale');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_DESC' , 'Картинка в pop-up окне:Greyscale<br /><br />По умолчанию: (32,22,22)<br /><br />basic black n white<br />Используется:<br />(int red,int green,int blue)');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_TITLE' , 'Картинка в pop-up окне:Ellipse');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_DESC' , 'Картинка в pop-up окне:Ellipse<br /><br />По умолчанию: (FFFFFF)<br /><br />ellipse on bg colour<br />Используется:<br />(hex background colour)');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_TITLE' , 'Картинка в pop-up окне:Round-edges');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_DESC' , 'Картинка в pop-up окне:Round-edges<br /><br />По умолчанию: (5,FFFFFF,3)<br /><br />corner trimming<br />Используется:<br />(edge_radius,background colour,anti-alias width)');
define('PRODUCT_IMAGE_POPUP_MERGE_TITLE' , 'Картинка в pop-up окне:Merge');
define('PRODUCT_IMAGE_POPUP_MERGE_DESC' , 'Картинка в pop-up окне:Merge<br /><br />По умолчанию: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Используется:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('PRODUCT_IMAGE_POPUP_FRAME_TITLE' , 'Картинка в pop-up окне:Frame');
define('PRODUCT_IMAGE_POPUP_FRAME_DESC' , 'Картинка в pop-up окне:Frame<br /><br />По умолчанию: <br /><br />plain raised border<br />Используется:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_TITLE' , 'Картинка в pop-up окне:Drop-Shadow');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_DESC' , 'Картинка в pop-up окне:Drop-Shadow<br /><br />По умолчанию: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Usage:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_TITLE' , 'Картинка в pop-up окне:Motion-Blur');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_DESC' , 'Картинка в pop-up окне:Motion-Blur<br /><br />По умолчанию: (4,FFFFFF)<br /><br />fading parallel lines<br />Используется:<br />(int number of lines,hex background colour)');

define('MO_PICS_TITLE','Количество дополнительных картинок товара');
define('MO_PICS_DESC','Количество дополнительных картинок товара, не считая стандартную картинку.');

define('IMAGE_MANIPULATOR_TITLE','Обработка картинок библиотекой GD');
define('IMAGE_MANIPULATOR_DESC','Автоматическая нарезка картинок и спец. эффекты с использованием библиотеки GD');

define('ACCOUNT_GENDER_TITLE' , 'Пол');
define('ACCOUNT_GENDER_DESC', 'Показывать поле Пол при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_DOB_TITLE' , 'Дата рождения');
define('ACCOUNT_DOB_DESC', 'Показывать поле Дата рождения при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_COMPANY_TITLE' , 'Компания');
define('ACCOUNT_COMPANY_DESC', 'Показывать поле Компания при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_STREET_ADDRESS_TITLE' , 'Адрес');
define('ACCOUNT_STREET_ADDRESS_DESC', 'Показывать поле Адрес при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_CITY_TITLE' , 'Город');
define('ACCOUNT_CITY_DESC', 'Показывать поле Город при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_POSTCODE_TITLE' , 'Почтовый индекс');
define('ACCOUNT_POSTCODE_DESC', 'Показывать поле Почтовый индекс при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_COUNTRY_TITLE' , 'Страна');
define('ACCOUNT_COUNTRY_DESC', 'Показывать поле Страна при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_TELE_TITLE' , 'Телефон');
define('ACCOUNT_TELE_DESC', 'Показывать поле Телефон при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_FAX_TITLE' , 'Факс');
define('ACCOUNT_FAX_DESC', 'Показывать поле Факс при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_SUBURB_TITLE' , 'Район');
define('ACCOUNT_SUBURB_DESC', 'Показывать поле Район при регистрации покупателя в магазине и в адресной книге');
define('ACCOUNT_STATE_TITLE' , 'Регион');
define('ACCOUNT_STATE_DESC', 'Показывать поле Регион при регистрации покупателя в магазине и в адресной книге');

define('DEFAULT_CURRENCY_TITLE' , 'Валюта по умолчанию');
define('DEFAULT_CURRENCY_DESC' , 'Валюта, используемая по умолчанию, все цены должны указывать в валюте по умолчанию');
define('DEFAULT_LANGUAGE_TITLE' , 'Язык по умолчанию');
define('DEFAULT_LANGUAGE_DESC' , 'Язык, используемый в магазине по умолчанию');
define('DEFAULT_ORDERS_STATUS_ID_TITLE' , 'Статус заказа по умолчанию');
define('DEFAULT_ORDERS_STATUS_ID_DESC' , 'Статус, который присвается заказу сразу после оформления');

define('SHIPPING_ORIGIN_COUNTRY_TITLE' , 'Страна магазина');
define('SHIPPING_ORIGIN_COUNTRY_DESC', 'Страна, где находится магазин. Необходимо для некоторых модулей доставки.');
define('SHIPPING_ORIGIN_ZIP_TITLE' , 'Почтовый индекс магазина');
define('SHIPPING_ORIGIN_ZIP_DESC', 'Укажите почтовый индекс магазина. Необходимо для некоторых модулей доставки.');
define('SHIPPING_MAX_WEIGHT_TITLE' , 'Максимальный вес доставки');
define('SHIPPING_MAX_WEIGHT_DESC', 'Вы можете указать максимальный вес доставки, свыше которого заказы не доставляются. Необходимо для некоторых модулей доставки.');
define('SHIPPING_BOX_WEIGHT_TITLE' , 'Минимальный вес упаковки');
define('SHIPPING_BOX_WEIGHT_DESC', 'Вы можете указать вес упаковки.');
define('SHIPPING_BOX_PADDING_TITLE' , 'Вес упаковки в процентах'); 
define('SHIPPING_BOX_PADDING_DESC', 'Доставка заказов, вес которых больше указанного в переменной Максимальный вес доставки, увеличивается на указанный процент. Если Вы хотите увелить стоимость на 10%, пишите - 10');
define('SHOW_SHIPPING_DESC' , 'Показывать ссылку стоимость доставки на странице товара');
define('SHOW_SHIPPING_TITLE' , 'Стоимость доставки на странице товара');
define('SHIPPING_INFOS_DESC' , 'ID код группы стоимости доставки.');
define('SHIPPING_INFOS_TITLE' , 'ID код группы');

define('PRODUCT_LIST_FILTER_TITLE' , 'Показывать фильтр Категория/Производители (0=не показывать; 1=показывать)');
define('PRODUCT_LIST_FILTER_DESC', 'Показывать бокс(drop-down) меню, с помощью которого можно сортировать товар в какой-либо категории магазина по Производителю.');

define('STOCK_CHECK_TITLE' , 'Проверять наличие товара на складе');
define('STOCK_CHECK_DESC', 'Проверять, есть ли необходимое количество товара на складе при оформлении заказа');

define('ATTRIBUTE_STOCK_CHECK_TITLE' , 'Проверка атрибутов на складе');
define('ATTRIBUTE_STOCK_CHECK_DESC' , 'Проверять наличие атрибутов товара на складе');

define('STOCK_LIMITED_TITLE' , 'Вычитать товар со склада');
define('STOCK_LIMITED_DESC', 'Вычитать со склада то количество товара, которое будет заказываться в интернет-магазине');
define('STOCK_ALLOW_CHECKOUT_TITLE' , 'Разрешить оформление заказа');
define('STOCK_ALLOW_CHECKOUT_DESC', 'Разрешить покупателям оформлять заказ, даже если на складе нет достаточного количества единиц заказываемого товара');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE' , 'Отмечать товар, отсутствующий на складе');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC', 'Показывать покупателю маркер напротив товара при оформлении заказа, если на складе нет необходимого количества единиц заказываемого товара');
define('STOCK_REORDER_LEVEL_TITLE' , 'Лимит количества товара на складе');
define('STOCK_REORDER_LEVEL_DESC', 'Если количество товара на складе меньше, чем указанное число в данной переменной, то в корзине выводится предупреждение о недостаточном количестве товара на складе для выполнения заказа.');

define('STORE_PAGE_PARSE_TIME_TITLE' , 'Сохранять время парсинга страниц');
define('STORE_PAGE_PARSE_TIME_DESC', 'Хранить время, затраченное на генерацию(парсинг) страниц магазина.');
define('STORE_PAGE_PARSE_TIME_LOG_TITLE' , 'Директория хранения логов');
define('STORE_PAGE_PARSE_TIME_LOG_DESC', 'Полный путь до директории и файла, в который будет записываться лог парсинга страниц.');
define('STORE_PARSE_DATE_TIME_FORMAT_TITLE' , 'Формат даты логов');
define('STORE_PARSE_DATE_TIME_FORMAT_DESC', 'Формат даты');

define('DISPLAY_PAGE_PARSE_TIME_TITLE' , 'Показывать время парсинга страниц');
define('DISPLAY_PAGE_PARSE_TIME_DESC', 'Показывать время парсинга страницы в интернет-магазине (опция Сохранять время парсинга страниц должна быть включена)');

define('STORE_DB_TRANSACTIONS_TITLE' , 'Сохранять запросы к базе дынных');
define('STORE_DB_TRANSACTIONS_DESC', 'Сохранять все запросы к базе данных в файле, указанном в переменной Директория хранение логов (только для PHP4 и выше)');

define('USE_CACHE_TITLE' , 'Использовать кэш');
define('USE_CACHE_DESC', 'Использовать кэширование информации.');

define('DB_CACHE_TITLE','Кэширование запросов к БД');
define('DB_CACHE_DESC','Если установить true, магазин будет кэшировать запросы SELECT, что увеличит скорость работы магазина.');

define('DIR_FS_CACHE_TITLE' , 'Кэш директория');
define('DIR_FS_CACHE_DESC', 'Директория, куда будут записываться и сохраняться кэш-файлы.');

define('ACCOUNT_OPTIONS_TITLE','Вид регистрации');
define('ACCOUNT_OPTIONS_DESC','Как будут регистрироваться покупатели?<br />Вы можете выбрать между регистрацией клиента с сохранением данных в БД (<b>account</b>), либо одноразовый Гостевой заказ (<b>guest</b>) без сохранения данных (данные о клиенте сохранятся, но клиент не будет информирован).<br />Можно выбрать оба (<b>both</b>) способа.');

define('EMAIL_TRANSPORT_TITLE' , 'Способ отправки E-Mail');
define('EMAIL_TRANSPORT_DESC', 'Укажите, какой способ отправки писем из магазина будет использоваться.');

define('EMAIL_LINEFEED_TITLE' , 'Разделитель строк в E-Mail');
define('EMAIL_LINEFEED_DESC', 'Используемая последовательность символов для разделения заголовков в письме.');
define('EMAIL_USE_HTML_TITLE' , 'Использовать HTML формат при отправке писем');
define('EMAIL_USE_HTML_DESC', 'Отправлять письма из магазина в HTML формате.');
define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE' , 'Проверять E-Mail адрес через DNS');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC', 'Проверять, верные ли e-mail адреса указываются при регистрации в интернет-магазине. Для проверки используется DNS.');
define('SEND_EMAILS_TITLE' , 'Отправлять письма из магазина');
define('SEND_EMAILS_DESC', 'Отправлять письма из магазина.');
define('SENDMAIL_PATH_TITLE' , 'Путь к sendmail');
define('SENDMAIL_PATH_DESC' , 'Если Вы используете метод sendmail, укажите правильный путь до sendmail (по умолчанию: /usr/bin/sendmail):');
define('SMTP_MAIN_SERVER_TITLE' , 'Адрес SMTP сервера');
define('SMTP_MAIN_SERVER_DESC' , 'Если Вы используете метод smtp, укажите правильный smtp сервер.');
define('SMTP_BACKUP_SERVER_TITLE' , 'Адрес резервного SMTP сервера');
define('SMTP_BACKUP_SERVER_DESC' , 'Если Вы используете метод smtp, Вы можете указать адрес резервного smtp сервера.');
define('SMTP_USERNAME_TITLE' , 'Имя пользователя smtp');
define('SMTP_USERNAME_DESC' , 'Имя пользователя для подключения к smtp серверу');
define('SMTP_PASSWORD_TITLE' , 'Пароль smtp');
define('SMTP_PASSWORD_DESC' , 'Пароль для подключения к smtp серверу');
define('SMTP_AUTH_TITLE' , 'Аутентификация smtp');
define('SMTP_AUTH_DESC' , 'Нужна ли аутентификация на smtp?');
define('SMTP_PORT_TITLE' , 'Порт smtp сервера');
define('SMTP_PORT_DESC' , 'Укажите порт smtp сервера (по умолчанию 25)');

//Constants for contact_us
define('CONTACT_US_EMAIL_ADDRESS_TITLE' , 'Свяжитесь с нами - Email адрес');
define('CONTACT_US_EMAIL_ADDRESS_DESC' , 'Пожалуйста, введите Email адрес, на который будут отправляться письма из магазина, со страницы Свяжитесь с нами.<br />Это поле необходимо заполнить!');
define('CONTACT_US_NAME_TITLE' , 'Свяжитесь с нами - Имя получателя');
define('CONTACT_US_NAME_DESC' , 'Пожалуйста, введите Имя (поле: Кому), на которое будут отправляться письма из магазина, со страницы Свяжитесь с нами.<br />Можно написать название магазина или, например, контактное лицо (ФИО). В почтовой программе поле Кому будет выглядеть так: <b>Название магазина (email@адрес)</b><br />Это поле можно оставить пустым.');
define('CONTACT_US_FORWARDING_STRING_TITLE' , 'Свяжитесь с нами - адреса переадресации (через запятую)');
define('CONTACT_US_FORWARDING_STRING_DESC' , 'Введите еmail адреса (поле: Скрытая копия) разделенные запятой на которые также будут отправляться письма из магазина, со страницы Свяжитесь с нами.<br />Это поле можно оставить пустым.');
define('CONTACT_US_REPLY_ADDRESS_TITLE' , 'Свяжитесь с нами - Адрес для ответов');
define('CONTACT_US_REPLY_ADDRESS_DESC' , 'Пожалуйста, введите E-Mail адрес, на который клиенты будут отвечать. В почтовой программе это поле <b>Обратный адрес</b>.<br />Это поле не рекомендуется заполнять.');
define('CONTACT_US_REPLY_ADDRESS_NAME_TITLE' , 'Свяжитесь с нами - Имя отвечающего');
define('CONTACT_US_REPLY_ADDRESS_NAME_DESC' , 'Имя в обратном адресе. Можно указать название Магазина.<br />Это поле не надо заполнять если не заполнено поле Адрес для ответов.');
define('CONTACT_US_EMAIL_SUBJECT_TITLE' , 'Свяжитесь с нами - Тема письма');
define('CONTACT_US_EMAIL_SUBJECT_DESC' , 'Введите тему, которая будет в письмах при отправке сообщения из магазина, со страницы Свяжитесь с нами.<br />Это поле рекомендуется заполнить.');

//Constants for support system
define('EMAIL_SUPPORT_ADDRESS_TITLE' , 'Служба поддержки - E-Mail адрес');
define('EMAIL_SUPPORT_ADDRESS_DESC' , 'Введите email адрес для писем в <b>Службу поддержки</b> (проблемы при оформлении заказа, потеря пароля).');
define('EMAIL_SUPPORT_NAME_TITLE' , 'Служба поддержки - Имя получателя');
define('EMAIL_SUPPORT_NAME_DESC' , 'Введите название  <b>Службы поддержки</b> (роблемы при оформлении заказа, потеря пароля).');
define('EMAIL_SUPPORT_FORWARDING_STRING_TITLE' , 'Служба поддержки - адреса переадресации (через запятую)');
define('EMAIL_SUPPORT_FORWARDING_STRING_DESC' , 'Введите еmail адреса (поле: Скрытая копия) разделенные запятой на которые также будут отправляться письма в <b>Службу поддержки</b>.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_TITLE' , 'Служба поддержки - Адрес для ответов');
define('EMAIL_SUPPORT_REPLY_ADDRESS_DESC' , 'Пожалуйста, введите E-Mail адрес, на который клиенты будут отвечать. В почтовой программе это поле <b>Обратный адрес</b>.<br />Это поле не рекомендуется заполнять.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_TITLE' , 'Служба поддержки - Имя отвечающего');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_DESC' , 'Имя в обратном адресе. Можно указать название Магазина.');
define('EMAIL_SUPPORT_SUBJECT_TITLE' , 'Служба поддержки - Тема письма');
define('EMAIL_SUPPORT_SUBJECT_DESC' , 'Введите тему для писем в <b>Службу поддержки</b> из магазина.');

//Constants for Billing system
define('EMAIL_BILLING_ADDRESS_TITLE' , 'Служба обработки счетов - E-Mail адрес');
define('EMAIL_BILLING_ADDRESS_DESC' , 'Введите email адрес для <b>Службы обработки счетов</b> (подтвержение заказа, изменение статуса...).');
define('EMAIL_BILLING_NAME_TITLE' , 'Служба обработки счетов - Имя получателя');
define('EMAIL_BILLING_NAME_DESC' , 'Введите название  <b>Службы обработки счетов</b> (подтверждение заказа, изменение статуса...).');
define('EMAIL_BILLING_FORWARDING_STRING_TITLE' , 'Служба обработки счетов - адрес на который отправится копия письма с заказом');
define('EMAIL_BILLING_FORWARDING_STRING_DESC' , 'Введите дополнительные адреса для <b>Службы обработки счетов</b> (подтвержение заказа, изменение статуса..) через запятую<br /> Укажите Email Вашего мазина.');
define('EMAIL_BILLING_REPLY_ADDRESS_TITLE' , 'Служба обработки счетов - ответ по дополнительному адресу');
define('EMAIL_BILLING_REPLY_ADDRESS_DESC' , 'Введите дополнительный  email адрес получающий ответы для клиентов');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_TITLE' , 'Служба обработки счетов - ответы по дополнительным адресам, имя');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_DESC' , 'Введите имя для дополнительного адреса, получающего ответы для клиентов.');
define('EMAIL_BILLING_SUBJECT_TITLE' , 'Служба обработки счетов - Тема письма');
define('EMAIL_BILLING_SUBJECT_DESC' , 'Введите Тему для письма в <b>Службу обработки счетов</b>');
define('EMAIL_BILLING_SUBJECT_ORDER_TITLE','Служба обработки счетов - тема в заголовке заказа');
define('EMAIL_BILLING_SUBJECT_ORDER_DESC','Введите тему в заголовке для письма в <b>Службу обработки счетов</b>, генерируемое из магазина. (например <b>Ваш заказ {$nr}, {$date}</b>) Примечание: Вы можете использовать, {$nr},{$date},{$firstname},{$lastname}');


define('DOWNLOAD_ENABLED_TITLE' , 'Разрешить функцию скачивания товаров');
define('DOWNLOAD_ENABLED_DESC', 'Разрешить функцию скачивания товаров.');
define('DOWNLOAD_BY_REDIRECT_TITLE' , 'Использовать перенаправление при скачивании');
define('DOWNLOAD_BY_REDIRECT_DESC', 'Использовать перенаправление в браузере для скачивания товара. Для не Unix систем(Windows, Mac OS и т.д.) должно стоять false.');
define('DOWNLOAD_MAX_DAYS_TITLE' , 'Срок существования ссылки для скачивания (дней)');
define('DOWNLOAD_MAX_DAYS_DESC', 'Установите количество дней, в течение которых покупатель может скачать свой товар. Если укажите 0, тогда срок существования ссылки для скачивания ограничен не будет.');
define('DOWNLOAD_MAX_COUNT_TITLE' , 'Максимальное количество скачиваний');
define('DOWNLOAD_MAX_COUNT_DESC', 'Установите максимальное количество скачиваний для одного товара. Если укажите 0, тогда никаких ограничений по количеству скачиваний не будет.');

define('GZIP_COMPRESSION_TITLE' , 'Разрешить GZip компрессию');
define('GZIP_COMPRESSION_DESC', 'Разрешить HTTP GZip компрессию.');
define('GZIP_LEVEL_TITLE' , 'Уровень компрессии');
define('GZIP_LEVEL_DESC', 'Вы можете указать уровень компрессии от 0 до 9 (0 = минимум, 9 = максимум).');

define('SESSION_WRITE_DIRECTORY_TITLE' , 'Директория сессий');
define('SESSION_WRITE_DIRECTORY_DESC', 'Если сессии хранятся в файлах, то здесь необходимо указать директорию, в которой будут храниться файлы сессий, дериктория должна быть на одном уровне с директориями магазина (admin, images и т.д.), по умолчанию tmp, это значит, что папка tmp должна находиться в корневой директории магазина.');
define('SESSION_FORCE_COOKIE_USE_TITLE' , 'Принудительное использование Cookie');
define('SESSION_FORCE_COOKIE_USE_DESC', 'Принудительно использовать сессии, только когда в браузере активированы cookies.');
define('SESSION_CHECK_SSL_SESSION_ID_TITLE' , 'Проверять ID SSL сессии');
define('SESSION_CHECK_SSL_SESSION_ID_DESC', 'Проверять  SSL_SESSION_ID при каждом обращении к странице, защищённой протоколом HTTPS.');
define('SESSION_CHECK_USER_AGENT_TITLE' , 'Проверять переменную User Agent');
define('SESSION_CHECK_USER_AGENT_DESC', 'Проверять переменную бразура user agent при каждом обращении к страницам интернет-магазина.');
define('SESSION_CHECK_IP_ADDRESS_TITLE' , 'Проверять IP адрес');
define('SESSION_CHECK_IP_ADDRESS_DESC', 'Проверять IP адреса клиентов при каждом обращении к страницам интернет-магазина.');
define('SESSION_RECREATE_TITLE' , 'Воссоздавать сессию');
define('SESSION_RECREATE_DESC', 'Воссоздавать сессию для генерации нового ID кода сессии при входе зарегистрированного покупателя в магазин, либо при регистрации нового покупателя (Только для PHP 4.1 и выше).');

define('DISPLAY_CONDITIONS_ON_CHECKOUT_TITLE' , 'Показывать условия при оформлении заказа?');
define('DISPLAY_CONDITIONS_ON_CHECKOUT_DESC' , 'При оформлении заказа, клиенту будут показаны условия, которые необходимо будет подтвердить, иначе он не сможет оформить заказ.');

define('META_MIN_KEYWORD_LENGTH_TITLE' , 'Минимальная meta-keyword длина');
define('META_MIN_KEYWORD_LENGTH_DESC' , 'Минимальная длина одного слова (генерируемого из описания товара)');
define('META_KEYWORDS_NUMBER_TITLE' , 'Количество meta-keywords');
define('META_KEYWORDS_NUMBER_DESC' , 'Количество ключевых слов');
define('META_AUTHOR_TITLE' , 'author');
define('META_AUTHOR_DESC' , '&lt;meta name=&quot;author&quot;&gt;');
define('META_PUBLISHER_TITLE' , 'publisher');
define('META_PUBLISHER_DESC' , '&lt;meta name=&quot;publisher&quot;&gt;');
define('META_COMPANY_TITLE' , 'company');
define('META_COMPANY_DESC' , '&lt;meta name=&quot;company&quot;&gt;');
define('META_TOPIC_TITLE' , 'page-topic');
define('META_TOPIC_DESC' , '&lt;meta name=&quot;page-topic&quot;&gt;');
define('META_REPLY_TO_TITLE' , 'reply-to');
define('META_REPLY_TO_DESC' , '&lt;meta name=&quot;reply-to&quot;&gt;');
define('META_REVISIT_AFTER_TITLE' , 'revisit-after');
define('META_REVISIT_AFTER_DESC' , '&lt;meta name=&quot;revisit-after&quot;&gt;');
define('META_ROBOTS_TITLE' , 'robots');
define('META_ROBOTS_DESC' , '&lt;meta name=&quot;robots&quot;&gt;');
define('META_DESCRIPTION_TITLE' , 'Description');
define('META_DESCRIPTION_DESC' , '&lt;meta name=&quot;description&quot;&gt;');
define('META_KEYWORDS_TITLE' , 'Keywords');
define('META_KEYWORDS_DESC' , '&lt;meta name=&quot;keywords&quot;&gt;');

define('MODULE_PAYMENT_INSTALLED_TITLE' , 'Установленные модули оплаты');
define('MODULE_PAYMENT_INSTALLED_DESC' , 'Список модулей оплаты, список файлов, разделенных точкой с запятой. Список обновляется автоматически в зависимости от установленных модулей. (Пример: cc.php;cod.php;paypal.php)');
define('MODULE_ORDER_TOTAL_INSTALLED_TITLE' , 'Установленные модули итого');
define('MODULE_ORDER_TOTAL_INSTALLED_DESC' , 'Список модулей итого по именам файлов, разделенных точкой с запятой. Список обновляется автоматически в зависимости от установленных модулей (Пример: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)');
define('MODULE_SHIPPING_INSTALLED_TITLE' , 'Установленные модули доставки');
define('MODULE_SHIPPING_INSTALLED_DESC' , 'Список модулей доставки, список файлов, разделенных точкой с запятой. Список обновляется автоматически в зависимости от установленных модулей. (Пример: ups.php;flat.php;item.php)');

define('CACHE_LIFETIME_TITLE','Срок жизни кэша');
define('CACHE_LIFETIME_DESC','Как долго кэшировать страницы (в секундах).');
define('CACHE_CHECK_TITLE','Проверять изменения кэша');
define('CACHE_CHECK_DESC','Если true, тогда проверяется, были ли изменены заголовки If-Modified-Since headers вместе с основным наполнением страницы, и соответсвующие HTTP заголовки отправляются в кэш. В этом случае клиентской машине отдаётся не весь контент страницы с заголовками, а только основная часть, что сокращает время загрузки.');

define('DB_CACHE_EXPIRE_TITLE','Срок жизни кэша базы данных');
define('DB_CACHE_EXPIRE_DESC','Как долго кэшировать запросы к базе данных (в секундах).');

define('PRODUCT_REVIEWS_VIEW_TITLE','Отзывы на странице описания товара');
define('PRODUCT_REVIEWS_VIEW_DESC','Количество отзывов на странице описания товара');

define('DELETE_GUEST_ACCOUNT_TITLE','Удалять гостевые записи');
define('DELETE_GUEST_ACCOUNT_DESC','Удалять запись гостя после заказа (дата заказа будет сохранена).');

define('USE_WYSIWYG_TITLE','HTML-редактор');
define('USE_WYSIWYG_DESC','Включить HTML-редактор FCKEditor для информационных страниц, категорий, товаров.');

define('PRICE_IS_BRUTTO_TITLE','Брутто цены в админке');
define('PRICE_IS_BRUTTO_DESC','Использовать цены с налогом в админке.');

define('PRICE_PRECISION_TITLE','Точность цен');
define('PRICE_PRECISION_DESC','Точность цен до X знаков после разделителя.');
define('CHECK_CLIENT_AGENT_TITLE','Не показывать сессию в адресе паукам поисковых машин');
define('CHECK_CLIENT_AGENT_DESC','Не показывать сессии известным поисковым паукам. Список пауков в /inc/xtc_check_agent.inc.php');
define('SHOW_IP_LOG_TITLE','Показывать IP адрес покупателя при оформлении заказа');
define('SHOW_IP_LOG_DESC','Показать текст &quot;Ваш IP адрес:&quot;, при оформлении заказа');

define('ACTIVATE_GIFT_SYSTEM_TITLE','Активировать систему подарочных сертификатов / купонов');
define('ACTIVATE_GIFT_SYSTEM_DESC','Разрешить покупать, использовать при оформлении заказов подарочные сертификаты и купоны');

define('ACTIVATE_SHIPPING_STATUS_TITLE','Время доставки');
define('ACTIVATE_SHIPPING_STATUS_DESC','Показывать статус доставки? После активации на странице товара появится пункт <b>Время доставки</b>');

define('SECURITY_CODE_LENGTH_TITLE','Длина секретного кода');
define('SECURITY_CODE_LENGTH_DESC','Длина секретного кода (в подарочном сертификате)');

define('IMAGE_QUALITY_TITLE','Качество генерируемой картинки');
define('IMAGE_QUALITY_DESC','Вы можете указать значение от 0 до 100 (0 - максимальное сжатие, 100 - максимальное качество)');

define('GROUP_CHECK_TITLE','Проверка статуса покупателя для категорий');
define('GROUP_CHECK_DESC','Разрешает только зарегистрированым покупателям и имеющим доступ к конкретным категориям просматривать их (после активации появятся товары и категории');

define('ACTIVATE_REVERSE_CROSS_SELLING_TITLE','Обратные перекрёстные ссылки');
define('ACTIVATE_REVERSE_CROSS_SELLING_DESC','Активировать систему обратных перекрестных ссылок между товарами');

define('ACTIVATE_NAVIGATOR_TITLE','Включить навигацию по товару');
define('ACTIVATE_NAVIGATOR_DESC','Включить/выключить навигацию по товару на странице товара, (при большом количестве товара в системе, отключение данной возможности позволит быстрее выводить страницу товара)');

define('QUICKLINK_ACTIVATED_TITLE','Включить функцию множественного копирования');
define('QUICKLINK_ACTIVATED_DESC','Функция множественного копирования в админе.');

define('DOWNLOAD_UNALLOWED_PAYMENT_TITLE', 'Запрещённые модули оплаты для виртуальных товаров');
define('DOWNLOAD_UNALLOWED_PAYMENT_DESC', 'Запрещённые модули оплаты для виртуальных товаров (т.е. для товаров, которые имеют файлы для загрузки). Список разделённый запятыми, например: cod,cc');
define('DOWNLOAD_MIN_ORDERS_STATUS_TITLE', 'Минимальный cтатус заказа');
define('DOWNLOAD_MIN_ORDERS_STATUS_DESC', 'Скачивание разрешается только заказам, имеющим указанный статус и выше. Это нужно для того что б загрузка товаров была доступна только оплаченным заказам.');

// Vat Check
define('STORE_OWNER_VAT_ID_TITLE' , 'VAT код владельца магазина');
define('STORE_OWNER_VAT_ID_DESC' , 'VAT код владельца магазина');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_TITLE' , 'Группа покупателей - правильный VAT код (Страна, отличная от страны магазина)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_DESC' , 'Группа для покупателей с правильно указанным VAT кодом, страна магазина != стране покупателя');
define('ACCOUNT_COMPANY_VAT_CHECK_TITLE' , 'Проверять VAT код');
define('ACCOUNT_COMPANY_VAT_CHECK_DESC' , 'Проверять правильно ли указан VAT код (проверка синтаксиса)');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_TITLE' , 'Проверять VAT код через внешний сервер');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_DESC' , 'Проверять VAT код через внешний сервер');
define('ACCOUNT_COMPANY_VAT_GROUP_TITLE' , 'Автоматическая смена группы');
define('ACCOUNT_COMPANY_VAT_GROUP_DESC' , 'Установите в true, если Вы хотите, что б группа покупателя изменялась автоматически при правильно указанном VAT коде.');
define('ACCOUNT_VAT_BLOCK_ERROR_TITLE' , 'Разрешить неправильные UST коды');
define('ACCOUNT_VAT_BLOCK_ERROR_DESC' , 'Установите в true, на данный момент проверяются только VAT коды.');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_TITLE','Группа покупателей - правильный VAT код (Страна, аналогичная стране магазина)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_DESC','Группа для покупателей с правильно указанным VAT кодом, страна магазина = стране покупателя');
// Google Conversion
define('GOOGLE_CONVERSION_TITLE','Google конверсионная трассировка');
define('GOOGLE_CONVERSION_DESC','Отслеживать конверсионные ключевые слова в заказах');
define('GOOGLE_CONVERSION_ID_TITLE','ID преобразования');
define('GOOGLE_CONVERSION_ID_DESC','Ваш Google конверсионный ID');
define('GOOGLE_LANG_TITLE','Google язык');
define('GOOGLE_LANG_DESC','ISO код используемоего языка (ru, en, fr, de...)');

// Afterbuy
define('AFTERBUY_ACTIVATED_TITLE','Активировать');
define('AFTERBUY_ACTIVATED_DESC','Активировать модуль afterbuy');
define('AFTERBUY_PARTNERID_TITLE','ID код партнёра');
define('AFTERBUY_PARTNERID_DESC','Ваш партнёрский afterbuy id код');
define('AFTERBUY_PARTNERPASS_TITLE','Пароль партнёра');
define('AFTERBUY_PARTNERPASS_DESC','Ваш пароль для модуля Afterbuy XML');
define('AFTERBUY_USERID_TITLE','ID код пользователя');
define('AFTERBUY_USERID_DESC','Ваш ID код пользователя');
define('AFTERBUY_ORDERSTATUS_TITLE','Статус заказа');
define('AFTERBUY_ORDERSTATUS_DESC','Статус заказа, устанавливаемый для экспортируемых заказов');
define('AFTERBUY_URL','Подробная информация о модуле Afterbuy доступна по адресу: <a href="http://www.xt-commerce.com/modules/wfsection/dossier-65.html" target="new">http://www.xt-commerce.com/modules/wfsection/dossier-65.html</a>');

// Search-Options
define('SEARCH_IN_DESC_TITLE','Поиск в описании товаров');
define('SEARCH_IN_DESC_DESC','Разрешить поиск в описании товаров');
define('SEARCH_IN_ATTR_TITLE','Поиск а атрибутах товаров');
define('SEARCH_IN_ATTR_DESC','Разрешить поиск в атрибутах товаров');

define('SEARCH_ENGINE_FRIENDLY_URLSX_TITLE' , 'Использовать короткие URL SEFLT?');
define('SEARCH_ENGINE_FRIENDLY_URLSX_DESC' , 'Использовать короткие URL SEFLT');

// Сборка VaM

// Яндекс маркет

define('YML_NAME_TITLE' , 'Название магазина');
define('YML_COMPANY_TITLE' , 'Название компании');
define('YML_DELIVERYINCLUDED_TITLE' , 'Доставка включена');
define('YML_AVAILABLE_TITLE' , 'Товар в наличии');
define('YML_AUTH_USER_TITLE' , 'Логин');
define('YML_AUTH_PW_TITLE' , 'Пароль');
define('YML_REFERER_TITLE' , 'Ссылка');
define('YML_STRIP_TAGS_TITLE' , 'Теги');
define('YML_UTF8_TITLE' , 'Перекодировка в UTF-8');

define('YML_NAME_DESC' , 'Название магазина для Яндекс-Маркет. Если поле пустое, то используется STORE_NAME.');
define('YML_COMPANY_DESC' , 'Название компании для Яндекс-Маркет. Если поле пустое, то используется STORE_OWNER.');
define('YML_DELIVERYINCLUDED_DESC' , 'Доставка включена в стоимость товара?');
define('YML_AVAILABLE_DESC' , 'Товар в наличии или под заказ?');
define('YML_AUTH_USER_DESC' , 'Логин для доступа к YML');
define('YML_AUTH_PW_DESC' , 'Пароль для доступа к YML');
define('YML_REFERER_DESC' , 'Добавить в адрес товара параметр с ссылкой на User agent или ip?');
define('YML_STRIP_TAGS_DESC' , 'Убирать html-теги в строках?');
define('YML_UTF8_DESC' , 'Перекодировать в UTF-8?');

// Изменение цен

define('DISPLAY_MODEL_TITLE' , 'Показывать код товара');
define('MODIFY_MODEL_TITLE' , 'Показывать код товара');
define('MODIFY_NAME_TITLE' , 'Показывать название товара');
define('DISPLAY_STATUT_TITLE' , 'Показывать статус товара');
define('DISPLAY_WEIGHT_TITLE' , 'Показывать вес товара');
define('DISPLAY_QUANTITY_TITLE' , 'Показывать количество товара');
define('DISPLAY_IMAGE_TITLE' , 'Показывать картинку товара');
define('DISPLAY_MANUFACTURER_TITLE' , 'Показывать производителя');
define('MODIFY_MANUFACTURER_TITLE' , 'Изменение производителя товара');
define('DISPLAY_TAX_TITLE' , 'Показывать налог');
define('MODIFY_TAX_TITLE' , 'Показывать налог');
define('DISPLAY_TVA_OVER_TITLE' , 'Показывать цены с налогами');
define('DISPLAY_TVA_UP_TITLE' , 'Показывать цены с налогами при изменении цены');
define('DISPLAY_PREVIEW_TITLE' , 'Показывать ссылку на описание товара');
define('DISPLAY_EDIT_TITLE' , 'Показывать ссылку на редактирование товара');
define('ACTIVATE_COMMERCIAL_MARGIN_TITLE' , 'Показывать возможность массового изменения цен');

define('DISPLAY_MODEL_DESC', 'Показывать/Не показывать код товара');
define('MODIFY_MODEL_DESC', 'Показывать/Не показывать код товара');
define('MODIFY_NAME_DESC', 'Показывать/Не показывать название товара');
define('DISPLAY_STATUT_DESC', 'Показывать/Не показывать статус товара');
define('DISPLAY_WEIGHT_DESC', 'Показывать/Не показывать вес товара');
define('DISPLAY_QUANTITY_DESC', 'Показывать/Не показывать количество товара');
define('DISPLAY_IMAGE_DESC', 'Показывать/Не показывать картинку товара');
define('MODIFY_MANUFACTURER_DESC', 'Показывать/Не показывать изменение производителя товара');
define('MODIFY_TAX_DESC', 'Показывать/Не показывать налог');
define('DISPLAY_TVA_OVER_DESC', 'Показывать/Не показывать цены с налогами');
define('DISPLAY_TVA_UP_DESC', 'Показывать/Не показывать цены с налогами при изменении цены');
define('DISPLAY_PREVIEW_DESC', 'Показывать/Не показывать ссылку на описание товара');
define('DISPLAY_EDIT_DESC', 'Показывать/Не показывать ссылку на редактирование товара');
define('DISPLAY_MANUFACTURER_DESC', 'Показывать/Не показывать производителя');
define('DISPLAY_TAX_DESC', 'Показывать/Не показывать налог');
define('ACTIVATE_COMMERCIAL_MARGIN_DESC', 'Показывать/Не показывать возможность массового  изменения цен');

define('REVOCATION_ID_TITLE','ID код информационной страницы с условиями возврата заказа');
define('REVOCATION_ID_DESC','ID код информационной страницы с информацией о возврате заказа, которая будет показана на странице подтверждения заказа');
define('DISPLAY_REVOCATION_ON_CHECKOUT_TITLE','Показывать текст с информацией о возврате заказа на странице подтверждения?');
define('DISPLAY_REVOCATION_ON_CHECKOUT_DESC','Показывать текст с информацией о возврате заказа на странице подтверждения?');

define('MAX_DISPLAY_LATEST_NEWS_TITLE' , 'Бокс новостей');
define('MAX_DISPLAY_LATEST_NEWS_DESC' , 'Количество новостей, отображаемых в боксе');
define('MAX_DISPLAY_LATEST_NEWS_PAGE_TITLE' , 'Новостей на одной странице');
define('MAX_DISPLAY_LATEST_NEWS_PAGE_DESC' , 'Количество новостей, отображаемых на одной станице');
define('MAX_DISPLAY_LATEST_NEWS_CONTENT_TITLE' , 'Новости кратко');
define('MAX_DISPLAY_LATEST_NEWS_CONTENT_DESC' , 'Количество символов, отображаемых при предварительном просмотре новости');

?>