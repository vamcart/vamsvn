<?php
/* -----------------------------------------------------------------------------------------
   $Id: configuration.php 1286 2012-11-05 17:36:58 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.8 2002/01/04); www.oscommerce.com
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/25); www.nextcommerce.org 
   (c) 2004	 xt:Commerce (configuration.php,v 1.16 2003/08/25); xt-commerce.com

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
define('STORE_OWNER_EMAIL_ADDRESS_TITLE' , 'E-Mail адрес');
define('STORE_OWNER_EMAIL_ADDRESS_DESC' , 'E-Mail адрес владельца магазина');

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
define('ADMIN_DROP_DOWN_NAVIGATION_TITLE','Всплывающее меню навигации в админке');
define('ADMIN_DROP_DOWN_NAVIGATION_DESC','Drop-down меню сверху (true) или обычное меню слева (false).');
define('AJAX_CART_TITLE','Ajax корзина');
define('AJAX_CART_DESC','Использовать ajax корзину, т.е. добавление товара без перезагрузки страницы (true) или использовать обычную корзину (false).');

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
define('MAX_DISPLAY_ADMIN_PAGE_TITLE' , 'Товаров на одной странице в админке');
define('MAX_DISPLAY_ADMIN_PAGE_DESC', 'Количество товара, выводимого на одной странице в админке, при просмотре списка товаров');
define('MAX_DISPLAY_PAGE_LINKS_TITLE' , 'Ссылок на страницы');
define('MAX_DISPLAY_PAGE_LINKS_DESC', 'Количество ссылок на другие страницы');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE' , 'Специальные цены');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC', 'Максимальное количество товара, выводимого на странице Скидки');
define('MAX_DISPLAY_FEATURED_PRODUCTS_TITLE' , 'Рекомендуемые товары');
define('MAX_DISPLAY_FEATURED_PRODUCTS_DESC', 'Максимальное количество товара, выводимого на странице Рекомендуемые');
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
define('MAX_RANDOM_SELECT_FEATURED_TITLE' , 'Выбор случайного товара в боксе Рекомендуемые');
define('MAX_RANDOM_SELECT_FEATURED_DESC', 'Количество товара, среди которого будет выбран случайный товар и выведен в бокс Рекомендуемые, т.е. если указано число X, то товар, который будет показан в боксе Рекомендуемые будет выбран из этих X товаров');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE' , 'Количество категорий в строке');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC', 'Сколько категорий выводить в одной строке');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE' , 'Количество Новинок на странице');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC', 'Максимальное количество новинок, выводимых на одной странице в разделе Новинки');
define('MAX_DISPLAY_BESTSELLERS_TITLE' , 'Лидеры продаж');
define('MAX_DISPLAY_BESTSELLERS_DESC', 'Максимальное количество лидеров продаж, выводимых в боксе Лидеры продаж');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE' , 'Также заказали');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC', 'Максимальное количество товаров в блоке Наши покупатели также заказали, а также данная опция регулирует максимальное количество товара, выводимого в блоке связанных со статьёй товаров.');
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

define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_TITLE' , 'Маленькая картинка товара: Обрамление<br />');
define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_DESC' , 'Маленькая картинка товара: Обрамление<br /><br />По умолчанию: (8,FFCCCC,330000)<br /><br />Затененные скошенные края.<br /><br />Используется:<br />(ширина края,светлый цвет,темный цвет)');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_TITLE' , 'Маленькая картинка товара: Чёрно-белый<br />');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_DESC' , 'Маленькая картинка товара: Чёрно-белый<br /><br />По умолчанию: (32,22,22)<br /><br />Чёрно-белая картика.<br /><br />Используется:<br />(R (код красного оттенка),G (код зелёного оттенка),B (код синего оттенка))');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_TITLE' , 'Маленькая картинка товара: Эллипс<br />');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_DESC' , 'Маленькая картинка товара: Эллипс<br /><br />По умолчанию: (FFFFFF)<br /><br />Картинка будет вырезана в виде эллипса.<br /><br />Используется:<br />(цвет фона)');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_TITLE' , 'Маленькая картинка товара: Скругленные углы<br />');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_DESC' , 'Маленькая картинка товара: Скругленные углы<br /><br />По умолчанию: (5,FFFFFF,3)<br /><br />Округление углов картинки.<br /><br />Используется:<br />(радиус,фон,ширина сглаживания)');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_TITLE' , 'Маленькая картинка товара: Водяной знак<br />');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_DESC' , 'Маленькая картинка товара: Водяной знак<br /><br />По умолчанию: (overlay.gif,10,-50,60,FF0000)<br /><br />Водяной знак, накладываемый на картинку.<br /><br />Используется:<br />(файл картинки,отступ слева по x [отрицательное значение = отступ справа],отступ по y [отрицательное значение = нет отступа],прозрачность, цвет прозрачности)');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_TITLE' , 'Маленькая картинка товара: Рамка<br />');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_DESC' , 'Маленькая картинка товара: Рамка<br /><br />По умолчанию: <br /><br />Рамка картинки.<br /><br />Используется:<br />(светлый цвет,тёмный цвет,ширина рамки,цвет рамки [на выбор - обычно цвет в гамме между установленными светлым и тёмным цветами])');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_TITLE' , 'Маленькая картинка товара: Тень<br />');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_DESC' , 'Маленькая картинка товара: Тень<br /><br />По умолчанию: (3,333333,FFFFFF)<br /><br />Отбрасываемая картинкой тень.<br /><br />Используется:<br />(ширина тени,цвет тени,цвет фона)');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_TITLE' , 'Маленькая картинка товара: Размытие<br />');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_DESC' , 'Маленькая картинка товара: Размытие<br /><br />По умолчанию: (4,FFFFFF)<br /><br />Затухающие параллельные линии.<br /><br />Используется:<br />(количество линий,цвет фона)');

//And this is for the Images showing your products in single-view

define('PRODUCT_IMAGE_INFO_BEVEL_TITLE' , 'Картинка на странице товара: Обрамление');
define('PRODUCT_IMAGE_INFO_BEVEL_DESC' , 'Картинка на странице товара: Обрамление<br /><br />По умолчанию: (8,FFCCCC,330000)<br /><br />Затененные скошенные края.<br /><br />Используется:<br />(ширина края,светлый цвет,темный цвет)');
define('PRODUCT_IMAGE_INFO_GREYSCALE_TITLE' , 'Картинка на странице товара: Чёрно-белый');
define('PRODUCT_IMAGE_INFO_GREYSCALE_DESC' , 'Картинка на странице товара: Чёрно-белый<br /><br />По умолчанию: (32,22,22)<br /><br />Чёрно-белая картика.<br /><br />Используется:<br />(R (код красного оттенка),G (код зелёного оттенка),B (код синего оттенка))');
define('PRODUCT_IMAGE_INFO_ELLIPSE_TITLE' , 'Картинка на странице товара: Эллипс');
define('PRODUCT_IMAGE_INFO_ELLIPSE_DESC' , 'Картинка на странице товара: Эллипс<br /><br />По умолчанию: (FFFFFF)<br /><br />Картинка будет вырезана в виде эллипса.<br /><br />Используется:<br />(цвет фона)');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_TITLE' , 'Картинка на странице товара: Скругленные углы');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_DESC' , 'Картинка на странице товара: Скругленные углы<br /><br />По умолчанию: (5,FFFFFF,3)<br /><br />Округление углов картинки.<br /><br />Используется:<br />(радиус,фон,ширина сглаживания)');
define('PRODUCT_IMAGE_INFO_MERGE_TITLE' , 'Картинка на странице товара: Водяной знак');
define('PRODUCT_IMAGE_INFO_MERGE_DESC' , 'Картинка на странице товара: Водяной знак<br /><br />По умолчанию: (overlay.gif,10,-50,60,FF0000)<br /><br />Водяной знак, накладываемый на картинку.<br /><br />Используется:<br />(файл картинки,отступ слева по x [отрицательное значение = отступ справа],отступ по y [отрицательное значение = нет отступа],прозрачность, цвет прозрачности)');
define('PRODUCT_IMAGE_INFO_FRAME_TITLE' , 'Картинка на странице товара: Рамка');
define('PRODUCT_IMAGE_INFO_FRAME_DESC' , 'Маленькая картинка товара: Рамка<br /><br />По умолчанию: (FFFFFF,000000,3,EEEEEE)<br /><br />Рамка картинки.<br /><br />Используется:<br />(светлый цвет,тёмный цвет,ширина рамки,цвет рамки [на выбор - обычно цвет в гамме между установленными светлым и тёмным цветами])');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_TITLE' , 'Картинка на странице товара: Тень');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_DESC' , 'Картинка на странице товара: Тень<br /><br />По умолчанию: (3,333333,FFFFFF)<br /><br />Отбрасываемая картинкой тень.<br /><br />Используется:<br />(ширина тени,цвет тени,цвет фона)');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_TITLE' , 'Картинка на странице товара: Размытие');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_DESC' , 'Картинка на странице товара: Размытие<br /><br />По умолчанию: (4,FFFFFF)<br /><br />Затухающие параллельные линии.<br /><br />Используется:<br />(количество линий,цвет фона)');

//so this image is the biggest in the shop this

define('PRODUCT_IMAGE_POPUP_BEVEL_TITLE' , 'Картинка в pop-up окне: Обрамление');
define('PRODUCT_IMAGE_POPUP_BEVEL_DESC' , 'Картинка в pop-up окне: Обрамление<br /><br />По умолчанию: (8,FFCCCC,330000)<br /><br />Затененные скошенные края.<br /><br />Используется:<br />(ширина края,светлый цвет,темный цвет)');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_TITLE' , 'Картинка в pop-up окне: Чёрно-белый');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_DESC' , 'Картинка в pop-up окне: Чёрно-белый<br /><br />По умолчанию: (32,22,22)<br /><br />Чёрно-белая картика.<br /><br />Используется:<br />(R (код красного оттенка),G (код зелёного оттенка),B (код синего оттенка))');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_TITLE' , 'Картинка в pop-up окне: Эллипс');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_DESC' , 'Картинка в pop-up окне: Эллипс<br /><br />По умолчанию: (FFFFFF)<br /><br />Картинка будет вырезана в виде эллипса.<br /><br />Используется:<br />(цвет фона)');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_TITLE' , 'Картинка в pop-up окне: Скругленные углы');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_DESC' , 'Картинка в pop-up окне: Скругленные углы<br /><br />По умолчанию: (5,FFFFFF,3)<br /><br />Округление углов картинки.<br /><br />Используется:<br />(радиус,фон,ширина сглаживания)');
define('PRODUCT_IMAGE_POPUP_MERGE_TITLE' , 'Картинка в pop-up окне: Водяной знак');
define('PRODUCT_IMAGE_POPUP_MERGE_DESC' , 'Картинка в pop-up окне: Водяной знак<br /><br />По умолчанию: (overlay.gif,10,-50,60,FF0000)<br /><br />Водяной знак, накладываемый на картинку.<br /><br />Используется:<br />(файл картинки,отступ слева по x [отрицательное значение = отступ справа],отступ по y [отрицательное значение = нет отступа],прозрачность, цвет прозрачности)');
define('PRODUCT_IMAGE_POPUP_FRAME_TITLE' , 'Картинка в pop-up окне: Рамка');
define('PRODUCT_IMAGE_POPUP_FRAME_DESC' , 'Картинка в pop-up окне: Рамка<br /><br />По умолчанию: <br /><br />Рамка картинки.<br /><br />Используется:<br />(светлый цвет,тёмный цвет,ширина рамки,цвет рамки [на выбор - обычно цвет в гамме между установленными светлым и тёмным цветами])');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_TITLE' , 'Картинка в pop-up окне: Тень');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_DESC' , 'Картинка в pop-up окне: Тень<br /><br />По умолчанию: (3,333333,FFFFFF)<br /><br />Отбрасываемая картинкой тень.<br /><br />Используется:<br />(ширина тени,цвет тени,цвет фона)');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_TITLE' , 'Картинка в pop-up окне: Размытие');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_DESC' , 'Картинка в pop-up окне: Размытие<br /><br />По умолчанию: (4,FFFFFF)<br /><br />Затухающие параллельные линии.<br /><br />Используется:<br />(количество линий,цвет фона)');

define('MO_PICS_TITLE','Количество дополнительных картинок товара');
define('MO_PICS_DESC','Количество дополнительных картинок товара, не считая стандартную картинку.');

define('CATEGORIES_IMAGE_THUMBNAIL_ACTIVE_TITLE' , 'Разрешить генерацию картинки категории');
define('CATEGORIES_IMAGE_THUMBNAIL_ACTIVE_DESC' , 'Разрешить использование библиотеки GD для картинки категории. Если установлено false, то не забудьте вручную загрузить картинки через ftp.');
define('CATEGORIES_IMAGE_THUMBNAIL_WIDTH_TITLE' , 'Ширина превьюшки категории');
define('CATEGORIES_IMAGE_THUMBNAIL_WIDTH_DESC' , 'Ширина превьюшки категории в пикселах');
define('CATEGORIES_IMAGE_THUMBNAIL_HEIGHT_TITLE' , 'Высота превьюшки категории');
define('CATEGORIES_IMAGE_THUMBNAIL_HEIGHT_DESC' , 'Высота превьюшки категории в пикселах');

define('CATEGORIES_IMAGE_THUMBNAIL_BEVEL_TITLE' , 'Картинка категории: Обрамление<br />');
define('CATEGORIES_IMAGE_THUMBNAIL_BEVEL_DESC' , 'Картинка категории: Обрамление<br /><br />По умолчанию: (8,FFCCCC,330000)<br /><br />Затененные скошенные края.<br /><br />Используется:<br />(ширина края,светлый цвет,темный цвет)');
define('CATEGORIES_IMAGE_THUMBNAIL_GREYSCALE_TITLE' , 'Картинка категории: Чёрно-белый<br />');
define('CATEGORIES_IMAGE_THUMBNAIL_GREYSCALE_DESC' , 'Картинка категории: Чёрно-белый<br /><br />По умолчанию: (32,22,22)<br /><br />Чёрно-белая картика.<br /><br />Используется:<br />(R (код красного оттенка),G (код зелёного оттенка),B (код синего оттенка))');
define('CATEGORIES_IMAGE_THUMBNAIL_ELLIPSE_TITLE' , 'Картинка категории: Эллипс<br />');
define('CATEGORIES_IMAGE_THUMBNAIL_ELLIPSE_DESC' , 'Картинка категории: Эллипс<br /><br />По умолчанию: (FFFFFF)<br /><br />Картинка будет вырезана в виде эллипса.<br /><br />Используется:<br />(цвет фона)');
define('CATEGORIES_IMAGE_THUMBNAIL_ROUND_EDGES_TITLE' , 'Картинка категории: Скругленные углы<br />');
define('CATEGORIES_IMAGE_THUMBNAIL_ROUND_EDGES_DESC' , 'Картинка категории: Скругленные углы<br /><br />По умолчанию: (5,FFFFFF,3)<br /><br />Округление углов картинки.<br /><br />Используется:<br />(радиус,фон,ширина сглаживания)');
define('CATEGORIES_IMAGE_THUMBNAIL_MERGE_TITLE' , 'Картинка категории: Водяной знак<br />');
define('CATEGORIES_IMAGE_THUMBNAIL_MERGE_DESC' , 'Картинка категории: Водяной знак<br /><br />По умолчанию: (overlay.gif,10,-50,60,FF0000)<br /><br />Водяной знак, накладываемый на картинку.<br /><br />Используется:<br />(файл картинки,отступ слева по x [отрицательное значение = отступ справа],отступ по y [отрицательное значение = нет отступа],прозрачность, цвет прозрачности)');
define('CATEGORIES_IMAGE_THUMBNAIL_FRAME_TITLE' , 'Картинка категории: Рамка<br />');
define('CATEGORIES_IMAGE_THUMBNAIL_FRAME_DESC' , 'Картинка категории: Рамка<br /><br />По умолчанию: <br /><br />Рамка картинки.<br /><br />Используется:<br />(светлый цвет,тёмный цвет,ширина рамки,цвет рамки [на выбор - обычно цвет в гамме между установленными светлым и тёмным цветами])');
define('CATEGORIES_IMAGE_THUMBNAIL_DROP_SHADDOW_TITLE' , 'Картинка категории: Тень<br />');
define('CATEGORIES_IMAGE_THUMBNAIL_DROP_SHADDOW_DESC' , 'Картинка категории: Тень<br /><br />По умолчанию: (3,333333,FFFFFF)<br /><br />Отбрасываемая картинкой тень.<br /><br />Используется:<br />(ширина тени,цвет тени,цвет фона)');
define('CATEGORIES_IMAGE_THUMBNAIL_MOTION_BLUR_TITLE' , 'Картинка категории: Размытие<br />');
define('CATEGORIES_IMAGE_THUMBNAIL_MOTION_BLUR_DESC' , 'Картинка категории: Размытие<br /><br />По умолчанию: (4,FFFFFF)<br /><br />Затухающие параллельные линии.<br /><br />Используется:<br />(количество линий,цвет фона)');

define('IMAGE_MANIPULATOR_TITLE','Обработка картинок библиотекой GD');
define('IMAGE_MANIPULATOR_DESC','Автоматическая нарезка картинок и спец. эффекты с использованием библиотеки GD');

define('ACCOUNT_SECOND_NAME_TITLE' , 'Отчество');
define('ACCOUNT_SECOND_NAME_DESC', 'Показывать поле Отчество при регистрации покупателя в магазине и в адресной книге');
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
define('SHOW_SHIPPING_DESC' , 'Показывать ссылку +доставка возле цены');
define('SHOW_SHIPPING_TITLE' , 'Показывать условия доставки');
define('SHIPPING_INFOS_DESC' , 'ID код информационной страницы с информацией о доставке');
define('SHIPPING_INFOS_TITLE' , 'ID код страницы с информацией о доставке');

define('PRODUCT_LIST_FILTER_TITLE' , 'Показывать фильтр Категория/Производители (0=не показывать; 1=показывать)');
define('PRODUCT_LIST_FILTER_DESC', 'Показывать бокс(drop-down) меню, с помощью которого можно сортировать товар в какой-либо категории магазина по Производителю.');
define('PRODUCT_LIST_RECURSIVE_TITLE' , 'Показывать товары подкатегорий в родительской категории');
define('PRODUCT_LIST_RECURSIVE_DESC', 'Вместо ярлыков подкатегорий показывать товары этих подкатегорий в родительской категории');

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

define('STORE_DB_TRANSACTIONS_TITLE' , 'Сохранять запросы к базе данных');
define('STORE_DB_TRANSACTIONS_DESC', 'Сохранять все запросы к базе данных в файле, указанном в переменной Директория хранение логов (только для PHP4 и выше)');

define('USE_CACHE_TITLE' , 'Использовать кэш');
define('USE_CACHE_DESC', 'Использовать кэширование информации.');

define('DB_CACHE_TITLE','Кэширование запросов к БД');
define('DB_CACHE_DESC','Если установить true, магазин будет кэшировать запросы SELECT, что увеличит скорость работы магазина.');

define('DIR_FS_CACHE_TITLE' , 'Кэш директория');
define('DIR_FS_CACHE_DESC', 'Директория, куда будут записываться и сохраняться кэш-файлы.');

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
define('CONTACT_US_EMAIL_ADDRESS_TITLE' , 'Свяжитесь с нами - E-Mail адрес');
define('CONTACT_US_EMAIL_ADDRESS_DESC' , 'Пожалуйста, введите E-Mail адрес, на который будут отправляться письма из магазина, со страницы Свяжитесь с нами.<br />Это поле необходимо заполнить!');
define('CONTACT_US_NAME_TITLE' , 'Свяжитесь с нами - Имя получателя');
define('CONTACT_US_NAME_DESC' , 'Пожалуйста, введите Имя (поле: Кому), на которое будут отправляться письма из магазина, со страницы Свяжитесь с нами.<br />Можно написать название магазина или, например, контактное лицо (ФИО). В почтовой программе поле Кому будет выглядеть так: <b>Название магазина (email@адрес)</b><br />Это поле можно оставить пустым.');
define('CONTACT_US_FORWARDING_STRING_TITLE' , 'Свяжитесь с нами - адреса переадресации (через запятую)');
define('CONTACT_US_FORWARDING_STRING_DESC' , 'Введите E-Mail адреса (поле: Скрытая копия) разделенные запятой на которые также будут отправляться письма из магазина, со страницы Свяжитесь с нами.<br />Это поле можно оставить пустым.');
define('CONTACT_US_REPLY_ADDRESS_TITLE' , 'Свяжитесь с нами - Адрес для ответов');
define('CONTACT_US_REPLY_ADDRESS_DESC' , 'Пожалуйста, введите E-Mail адрес, на который клиенты будут отвечать. В почтовой программе это поле <b>Обратный адрес</b>.');
define('CONTACT_US_REPLY_ADDRESS_NAME_TITLE' , 'Свяжитесь с нами - Имя отвечающего');
define('CONTACT_US_REPLY_ADDRESS_NAME_DESC' , 'Имя в обратном адресе. Можно указать название Магазина.<br />Это поле не надо заполнять если не заполнено поле Адрес для ответов.');
define('CONTACT_US_EMAIL_SUBJECT_TITLE' , 'Свяжитесь с нами - Тема письма');
define('CONTACT_US_EMAIL_SUBJECT_DESC' , 'Введите тему, которая будет в письмах при отправке сообщения из магазина, со страницы Свяжитесь с нами.<br />Это поле рекомендуется заполнить.');

//Constants for support system
define('EMAIL_SUPPORT_ADDRESS_TITLE' , 'Служба поддержки - E-Mail адрес');
define('EMAIL_SUPPORT_ADDRESS_DESC' , 'Введите E-Mail адрес для писем в <b>Службу поддержки</b> (проблемы при оформлении заказа, потеря пароля).');
define('EMAIL_SUPPORT_NAME_TITLE' , 'Служба поддержки - Имя получателя');
define('EMAIL_SUPPORT_NAME_DESC' , 'Введите название  <b>Службы поддержки</b> (Проблемы при оформлении заказа, потеря пароля).');
define('EMAIL_SUPPORT_FORWARDING_STRING_TITLE' , 'Служба поддержки - адреса переадресации (через запятую)');
define('EMAIL_SUPPORT_FORWARDING_STRING_DESC' , 'Введите E-Mail адреса (поле: Скрытая копия) разделенные запятой на которые также будут отправляться письма в <b>Службу поддержки</b>.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_TITLE' , 'Служба поддержки - Адрес для ответов');
define('EMAIL_SUPPORT_REPLY_ADDRESS_DESC' , 'Пожалуйста, введите E-Mail адрес, на который клиенты будут отвечать. В почтовой программе это поле <b>Обратный адрес</b>.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_TITLE' , 'Служба поддержки - Имя отвечающего');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_DESC' , 'Имя в обратном адресе. Можно указать название Магазина.');
define('EMAIL_SUPPORT_SUBJECT_TITLE' , 'Служба поддержки - Тема письма');
define('EMAIL_SUPPORT_SUBJECT_DESC' , 'Введите тему для писем в <b>Службу поддержки</b> из магазина.');

//Constants for Billing system
define('EMAIL_BILLING_ADDRESS_TITLE' , 'Служба обработки счетов - E-Mail адрес');
define('EMAIL_BILLING_ADDRESS_DESC' , 'Введите E-Mail адрес для <b>Службы обработки счетов</b> (подтвержение заказа, изменение статуса...).');
define('EMAIL_BILLING_NAME_TITLE' , 'Служба обработки счетов - Имя получателя');
define('EMAIL_BILLING_NAME_DESC' , 'Введите название  <b>Службы обработки счетов</b> (подтверждение заказа, изменение статуса...).');
define('EMAIL_BILLING_FORWARDING_STRING_TITLE' , 'Служба обработки счетов - адрес на который отправится копия письма с заказом');
define('EMAIL_BILLING_FORWARDING_STRING_DESC' , 'Введите дополнительные адреса для <b>Службы обработки счетов</b> (подтвержение заказа, изменение статуса..) через запятую<br /> Укажите E-Mail Вашего мазина.');
define('EMAIL_BILLING_REPLY_ADDRESS_TITLE' , 'Служба обработки счетов - ответ по дополнительному адресу');
define('EMAIL_BILLING_REPLY_ADDRESS_DESC' , 'Введите дополнительный  E-Mail адрес получающий ответы для клиентов');
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
define('SESSION_WRITE_DIRECTORY_DESC', 'Если сессии хранятся в файлах, то здесь необходимо указать директорию, в которой будут храниться файлы сессий, директория должна быть на одном уровне с директориями магазина (admin, images и т.д.), по умолчанию tmp, это значит, что папка tmp должна находиться в корневой директории магазина.');
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

define('PRICE_IS_BRUTTO_TITLE','Брутто цены в админке');
define('PRICE_IS_BRUTTO_DESC','Использовать цены с налогом в админке.');

define('PRICE_PRECISION_TITLE','Точность цен');
define('PRICE_PRECISION_DESC','Точность цен до X знаков после разделителя.');
define('CHECK_CLIENT_AGENT_TITLE','Не показывать сессию в адресе паукам поисковых машин');
define('CHECK_CLIENT_AGENT_DESC','Не показывать сессии известным поисковым паукам. Список пауков в /inc/vam_check_agent.inc.php');
define('SHOW_IP_LOG_TITLE','Показывать IP адрес покупателя при оформлении заказа');
define('SHOW_IP_LOG_DESC','Показать текст &quot;Ваш IP адрес:&quot;, при оформлении заказа');

define('ACTIVATE_GIFT_SYSTEM_TITLE','Активировать систему подарочных сертификатов / купонов');
define('ACTIVATE_GIFT_SYSTEM_DESC','Разрешить покупать, использовать при оформлении заказов подарочные сертификаты и купоны');

define('ACTIVATE_SHIPPING_STATUS_TITLE','Время доставки');
define('ACTIVATE_SHIPPING_STATUS_DESC','Показывать время доставки на странице карточки товара, после активации появится значение: <b>Время доставки</b> на странице карточки товара.');

define('SECURITY_CODE_LENGTH_TITLE','Длина секретного кода');
define('SECURITY_CODE_LENGTH_DESC','Длина секретного кода (в подарочном сертификате)');

define('IMAGE_QUALITY_TITLE','Качество генерируемой картинки');
define('IMAGE_QUALITY_DESC','Вы можете указать значение от 0 до 100 (0 - максимальное сжатие, 100 - максимальное качество)');

define('GROUP_CHECK_TITLE','Настройка доступа');
define('GROUP_CHECK_DESC','Если true, то Вы можете настраивать доступ к создаваемым категориям и товарам, т.е. какие из групп пользователей могут просматривать категории и товары в каталоге (после активации появится закладка доступ при создании и редактировании категорий, товаров)');

define('ACTIVATE_REVERSE_CROSS_SELLING_TITLE','Обратные перекрёстные ссылки');
define('ACTIVATE_REVERSE_CROSS_SELLING_DESC','Активировать систему обратных перекрестных ссылок между товарами');

define('ACTIVATE_NAVIGATOR_TITLE','Включить навигацию по товару');
define('ACTIVATE_NAVIGATOR_DESC','Включить/выключить навигацию по товару на странице товара, (при большом количестве товара в системе, отключение данной возможности позволит быстрее выводить страницу товара)');

define('QUICKLINK_ACTIVATED_TITLE','Включить функцию множественного копирования');
define('QUICKLINK_ACTIVATED_DESC','Функция множественного копирования в админке.');

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
define('GOOGLE_CONVERSION_TITLE','Включить статистику Google Analytics');
define('GOOGLE_CONVERSION_DESC','Включить Google Analytics. Вы должны зарегистрироваться в системе Google Analytics - http://google.com/analytics/ru-RU/');
define('GOOGLE_CONVERSION_ID_TITLE','Ваш ID в Google Analytics');
define('GOOGLE_CONVERSION_ID_DESC','ID Вашего сайта в Google Analytics. Обычно в виде UA-XXXXXX-X');
define('GOOGLE_LANG_TITLE','Язык');
define('GOOGLE_LANG_DESC','Язык магазина (ru, en, fr, de...), можно не указывать, это необязательный параметр.');
define('YANDEX_METRIKA_ID_TITLE','Ваш ID в Яндекс Метрике');
define('YANDEX_METRIKA_ID_DESC','ID номер Вашего сайта в Яндекс Метрике.');
define('YANDEX_METRIKA_TITLE','Включить статистику Яндекс Метрика');
define('YANDEX_METRIKA_DESC','Включить Яндекс Метрику.');
define('GOOGLE_TAG_MANAGER_TITLE','Включить Google Tag Manager');define('GOOGLE_TAG_MANAGER_DESC','Включить Google Tag Manager.');
define('GOOGLE_TAG_MANAGER_CONTAINER_ID_TITLE','Укажите Ваш ID номер контейнера GTM');define('GOOGLE_TAG_MANAGER_CONTAINER_ID_DESC','Укажите Ваш ID номер контейнера GTM.');
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
define('YML_UTF8_TITLE' , 'Перекодировка в windows-1251');
define('YML_USE_CDATA_TITLE' , 'Использовать CDATA');
define('YML_SALES_NOTES_TITLE' , 'Тэг sales_notes');

define('YML_NAME_DESC' , 'Название магазина для Яндекс-Маркет. Если поле пустое, то используется STORE_NAME.');
define('YML_COMPANY_DESC' , 'Название компании для Яндекс-Маркет. Если поле пустое, то используется STORE_OWNER.');
define('YML_DELIVERYINCLUDED_DESC' , 'Доставка включена в стоимость товара?');
define('YML_AVAILABLE_DESC' , 'Товар в наличии или под заказ?');
define('YML_AUTH_USER_DESC' , 'Логин для доступа к YML');
define('YML_AUTH_PW_DESC' , 'Пароль для доступа к YML');
define('YML_REFERER_DESC' , 'Добавить в адрес товара параметр с ссылкой на User agent или ip?');
define('YML_STRIP_TAGS_DESC' , 'Убирать html-теги в строках?');
define('YML_UTF8_DESC' , 'Перекодировать в UTF-8?');
define('YML_USE_CDATA_DESC' , 'Использовать CDATA для названий и описаний товаров.');
define('YML_SALES_NOTES_DESC' , 'Текст для тэга sales_notes');

// Изменение цен

define('DISPLAY_MODEL_TITLE' , 'Показывать код товара');
define('MODIFY_MODEL_TITLE' , 'Изменение кода товара');
define('MODIFY_NAME_TITLE' , 'Показывать название товара');
define('DISPLAY_STATUT_TITLE' , 'Показывать статус товара');
define('DISPLAY_WEIGHT_TITLE' , 'Показывать вес товара');
define('DISPLAY_QUANTITY_TITLE' , 'Показывать количество товара');
define('DISPLAY_IMAGE_TITLE' , 'Показывать картинку товара');
define('DISPLAY_XML_TITLE' , 'Показывать колонку яндекс-маркет');
define('DISPLAY_SORT_TITLE' , 'Показывать порядок сортировки');
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
define('MODIFY_MODEL_DESC', 'Показывать/Не показывать изменение кода товара');
define('MODIFY_NAME_DESC', 'Показывать/Не показывать название товара');
define('DISPLAY_STATUT_DESC', 'Показывать/Не показывать статус товара');
define('DISPLAY_WEIGHT_DESC', 'Показывать/Не показывать вес товара');
define('DISPLAY_QUANTITY_DESC', 'Показывать/Не показывать количество товара');
define('DISPLAY_IMAGE_DESC', 'Показывать/Не показывать картинку товара');
define('DISPLAY_XML_DESC', 'Показывать/Не показывать колонку яндекс-маркет');
define('DISPLAY_SORT_DESC', 'Показывать/Не показывать порядок сортировки товара');
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
define('MAX_DISPLAY_CART_TITLE' , 'Максимум символов в названии товара в корзине');
define('MAX_DISPLAY_CART_DESC' , 'Количество символов, выводимых в названии товара в боксе корзина, что б товары с длинным названием не раятягивали корзину.');
define('MAX_DISPLAY_SHORT_DESCRIPTION_TITLE' , 'Максимум символов в кратком описании');
define('MAX_DISPLAY_SHORT_DESCRIPTION_DESC' , 'Количество символов, выводимых в кратком описании, что б объёмное описание на ломало дизайн.');

// Установка модулей

define('DIR_FS_CIP_TITLE' , 'Директория с модулями');
define('DIR_FS_CIP_DESC' , 'Директория, где будут находиться архивы с модулями');
define('ALLOW_SQL_BACKUP_TITLE' , 'Делать резервную копию базы данных перед установкой нового модуля');
define('ALLOW_SQL_BACKUP_DESC' , 'Если база данных большая, лучше поставить false.');
define('ALLOW_SQL_RESTORE_TITLE' , 'Восстанавливать резервную копию базы данных при удалении модуля');
define('ALLOW_SQL_RESTORE_DESC' , 'Ставьте true только для отладки и если Вы точно знаете, как и для чего работает данная опция.');
define('ALLOW_FILES_BACKUP_TITLE' , 'Делать резервные копии файлов перед установкой нового модуля');
define('ALLOW_FILES_BACKUP_DESC' , 'Сохраняются только файлы, которые изменяет установщик модулей, рекомендуется поставить true.');
define('ALLOW_FILES_RESTORE_TITLE' , 'Восстанавливать резервные копии файлов при удалении модуля');
define('ALLOW_FILES_RESTORE_DESC' , 'Ставьте true только для отладки и если Вы точно знаете, как и для чего работает данная опция.');
define('ALLOW_OVERWRITE_MODIFIED_TITLE' , 'Разрешить перезаписывать уже изменённые файлы');
define('ALLOW_OVERWRITE_MODIFIED_DESC' , 'Если true, то установщик модулей перезапишет уже изменённый при установке другого модуля файл. Ставьте true только для отладки и если Вы точно знаете, как и для чего работает данная опция.');
define('TEXT_LINK_FORUM_TITLE' , 'Ссылка на форум');
define('TEXT_LINK_FORUM_DESC' , 'Ссылка на форум поддежки');
define('TEXT_LINK_CONTR_TITLE' , 'Ссылка на каталог с модулями');
define('TEXT_LINK_CONTR_DESC' , 'URL каталога с доступными модулями для магазина.');
define('ALWAYS_DISPLAY_REMOVE_BUTTON_TITLE' , 'Всегда показывать кнопку удалить');
define('ALWAYS_DISPLAY_REMOVE_BUTTON_DESC' , 'Поставьте true и кнопка удалить будет показываться напротив каждого модуля, вне зависимости от того, установлен он или нет.');
define('ALWAYS_DISPLAY_INSTALL_BUTTON_TITLE' , 'Всегда показывать кнопку установить');
define('ALWAYS_DISPLAY_INSTALL_BUTTON_DESC' , 'Поставьте true и кнопка установить будет показываться напротив каждого модуля, вне зависимости от того, установлен он или нет.');
define('SHOW_PERMISSIONS_COLUMN_TITLE' , 'Показывать колонку права доступа');
define('SHOW_PERMISSIONS_COLUMN_DESC' , 'Выберите true и в списке модулей будет отображаться колонка права доступа.');
define('SHOW_USER_GROUP_COLUMN_TITLE' , 'Показывать колонку пользователь/группа');
define('SHOW_USER_GROUP_COLUMN_DESC' , 'Выберите true и в списке модулей будет отображаться колонка пользователь/группа.');
define('SHOW_UPLOADER_COLUMN_TITLE' , 'Показывать колонку автор модуля');
define('SHOW_UPLOADER_COLUMN_DESC' , 'Выберите true и в списке модулей будет отображаться колонка автор модуля.');
define('SHOW_UPLOADED_COLUMN_TITLE' , 'Показывать колонку дата');
define('SHOW_UPLOADED_COLUMN_DESC' , 'Выберите true и в списке модулей будет отображаться колонка дата.');
define('SHOW_SIZE_COLUMN_TITLE' , 'Показывать колонку размер');
define('SHOW_SIZE_COLUMN_DESC' , 'Выберите true и в списке модулей будет отображаться колонка размер.');
define('USE_LOG_SYSTEM_TITLE' , 'Вести лог');
define('USE_LOG_SYSTEM_DESC' , 'Если true, то всё действия установщика модулей будут записываться в папку backups.');
define('MAX_UPLOADED_FILESIZE_TITLE' , 'Максимальный размер загружаемых CIP модулей');
define('MAX_UPLOADED_FILESIZE_DESC' , 'Установите максимальный размер архивов, которые Вы можете загружать через браузер в установщике модулей.');

define('USE_EP_IMAGE_MANIPULATOR_TITLE','Разрешить обработку картинок в excel импорт/экспорт');
define('USE_EP_IMAGE_MANIPULATOR_DESC','Обрабатывать или нет картинки при загрузке товаров через модуль Excel импорт/экспорт');

define('LOGIN_NUM_TITLE','Количество попыток при входе');
define('LOGIN_NUM_DESC','Если пользователь пытается войти в магазин и в течение указанного количества попыток неправильно указывает свой e-mail и/или пароль, то появляется каптча, для того что б предотвратить попытки автоматического подбора паролей.');
define('LOGIN_TIME_TITLE','Время каптчи при входе');
define('LOGIN_TIME_DESC','Через сколько времени каптча перестанет показываться после удачной попытки входа.');

define('ENABLE_TABS_TITLE','Разрешить закладки в админке');
define('ENABLE_TABS_DESC','Использовать закладки в админке при добавлении/редактировании категорий, товаров, при редактировании заказов и т.д.');

define('YML_VENDOR_TITLE','Генерация vendor');
define('YML_VENDOR_DESC','Генерировать тэг vendor?');
define('YML_REF_ID_TITLE','Ссылка');
define('YML_REF_ID_DESC','Добавить в адрес товара параметр.');
define('YML_REF_IP_TITLE','Ссылка на IP');
define('YML_REF_IP_DESC','Добавить в адрес товара параметр ref_ip с адресом ip агента, запрашивающего yml.');

define('SESSION_TIMEOUT_ADMIN_TITLE','Сессия администратора');
define('SESSION_TIMEOUT_ADMIN_DESC','Время жизни сессии администратора (секунд).');
define('SESSION_TIMEOUT_CATALOG_TITLE','Сессия покупателя');
define('SESSION_TIMEOUT_CATALOG_DESC','Время жизни сессии покупателя (секунд).');

define('STAY_PAGE_EDIT_TITLE','Оставаться на странице редактирования');
define('STAY_PAGE_EDIT_DESC','После нажатия кнопки сохранить, оставаться на странице редактирования товара/категории (true) или возвращаться к списку товаров/категорий (false).');

define('MAX_THUMB_WIDTH_TITLE','Ширина картинки атрибута');
define('MAX_THUMB_WIDTH_DESC','Ширина картинки атрибута, отображаемого в каталоге.');

define('MAX_THUMB_HEIGHT_TITLE','Высота картинки атрибута');
define('MAX_THUMB_HEIGHT_DESC','Высота картинки атрибута, отображаемого в каталоге.');

define('MAX_ADMIN_WIDTH_TITLE','Ширина картинки атрибута в админке');
define('MAX_ADMIN_WIDTH_DESC','Ширина картинки атрибута, отображаемого в админке.');

define('MAX_ADMIN_HEIGHT_TITLE','Высота картинки атрибута в админке');
define('MAX_ADMIN_HEIGHT_DESC','Высота картинки атрибута, отображаемого в админке.');

define('MAX_BYTE_SIZE_TITLE','Максимально возможный размер картинки атрибута');
define('MAX_BYTE_SIZE_DESC','Размер файла картинки в байтах.');

define('MASTER_PASS_TITLE','Мастер пароль');
define('MASTER_PASS_DESC','С данным паролем Вы сможете входить в магазин под любым клиентом, указывая при входе email клиента и мастер пароль');

define('DOWN_FOR_MAINTENANCE_TITLE','Техническое обслуживание: Вкл./Выкл.');
define('DOWN_FOR_MAINTENANCE_DESC','Техническое обслуживание. Если включено, то в магазине нельзя будет делать заказы и будет выведено предупреждение о проведении технического обслуживания магазина.<br />true - Включено<br />false - Выключено');
define('EXCLUDE_ADMIN_IP_FOR_MAINTENANCE_TITLE','Техническое обслуживание: Исключить указанный IP адрес');
define('EXCLUDE_ADMIN_IP_FOR_MAINTENANCE_DESC','Для указанного IP адреса магазин будет доступен даже при включённом режиме Техническое обслуживание. Обычно здесь указывает IP адрес администратора магазина.');

define('MAX_DISPLAY_FAQ_TITLE' , 'Бокс вопросы и ответы');
define('MAX_DISPLAY_FAQ_DESC' , 'Количество вопросов, отображаемых в боксе');
define('MAX_DISPLAY_FAQ_PAGE_TITLE' , 'Вопросов на одной странице');
define('MAX_DISPLAY_FAQ_PAGE_DESC' , 'Количество вопросов, отображаемых на одной станице');
define('MAX_DISPLAY_FAQ_ANSWER_TITLE' , 'Вопросы кратко');
define('MAX_DISPLAY_FAQ_ANSWER_DESC' , 'Количество символов, отображаемых при предварительном просмотре вопросы');

require_once(DIR_FS_LANGUAGES . $_SESSION['language'].'/admin/'.'affiliate_configuration.php');

define('CG_MY_SHOP_TITLE', 'Мой магазин');
define('CG_MINIMAL_VALUES_TITLE', 'Минимальные');
define('CG_MAXIMAL_VALUES_TITLE', 'Максимальные');
define('CG_PICTURES_PARAMETERS_TITLE', 'Картинки');
define('CG_CUSTOMERS_TITLE', 'Данные покупателя');
define('CG_MODULES_TITLE', 'Модули');
define('CG_SHIPPING_TITLE', 'Доставка/Упаковка');
define('CG_PRODUCTS_TITLE', 'Вывод товара');
define('CG_WAREHOUSE_TITLE', 'Склад');
define('CG_LOGGING_TITLE', 'Логи');
define('CG_CACHE_TITLE', 'Кэш');
define('CG_EMAIL_TITLE', 'Настройка E-Mail');
define('CG_DOWNLOAD_TITLE', 'Скачивание');
define('CG_MY_GZIP_TITLE', 'GZip компрессия');
define('CG_MY_SESSIONS_TITLE', 'Сессии');
define('CG_META_TAGS_TITLE', 'Мета теги');
define('CG_VAT_ID_TITLE', 'Vat');
define('CG_GOOGLE_TITLE', 'Счётчики');
define('CG_IMPORT_EXPORT_TITLE', 'Импорт/Экспорт');
define('CG_AFTER_BUY_TITLE', 'Afterbuy');
define('CG_SEARCH_TITLE', 'Настройки поиска');
define('CG_YANDEX_MARKET_TITLE', 'Яндекс-Маркет');
define('CG_QUICK_PRICE_UPDATES_TITLE', 'Изменение цен');
define('CG_CIP_MANAGER_TITLE', 'Установка модулей');
define('CG_MAINTENANCE_TITLE', 'Тех. обслуживание');
define('CG_AFFILIATE_PROGRAM_TITLE', 'Партнёрская программа');
define('CG_BOXES_TITLE', 'Боксы');
define('_TITLE', 'Разное');

define('STORE_TELEPHONE_TITLE','Телефон');
define('STORE_TELEPHONE_DESC','Телефон магазина.');
define('STORE_ICQ_TITLE','ICQ');
define('STORE_ICQ_DESC','ICQ магазина.');
define('STORE_SKYPE_TITLE','Skype');
define('STORE_SKYPE_DESC','Skype магазина.');

define('XSELL_CART_TITLE','Сопутствующие товары в корзине');
define('XSELL_CART_DESC','Показывать сопутствующие товары в корзине?');

define('SET_BOX_CATEGORIES_TITLE', 'Разделы');
define('SET_BOX_FILTERS_TITLE', 'Фильтры');
define('SET_BOX_CONTENT_TITLE', 'Узнайте больше');
define('SET_BOX_INFORMATION_TITLE', 'Информация');
define('SET_BOX_ADD_QUICKIE_TITLE', 'Быстрый заказ');
define('SET_BOX_LAST_VIEWED_TITLE', 'Просмотренные товары');
define('SET_BOX_REVIEWS_TITLE', 'Отзывы');
define('SET_BOX_SEARCH_TITLE', 'Поиск');
define('SET_BOX_SPECIALS_TITLE', 'Скидки');
define('SET_BOX_FEATURED_TITLE', 'Рекомендуемые');
define('SET_BOX_LATESTNEWS_TITLE', 'Новости');
define('SET_BOX_ARTICLES_TITLE', 'Статьи');
define('SET_BOX_ARTICLESNEW_TITLE', 'Новые статьи');
define('SET_BOX_AUTHORS_TITLE', 'Авторы');
define('SET_BOX_CART_TITLE', 'Корзина');
define('SET_BOX_LOGIN_TITLE', 'Вход');
define('SET_BOX_ADMIN_TITLE', 'Статистика');
define('SET_BOX_DOWNLOADS_TITLE', 'Мои загрузки');
define('SET_BOX_AFFILIATE_TITLE', 'Партнёрская программа');
define('SET_BOX_WHATSNEW_TITLE', 'Новинки');
define('SET_BOX_NEWSLETTER_TITLE', 'Рассылка');
define('SET_BOX_BESTSELLERS_TITLE', 'Лучшие товары');
define('SET_BOX_INFOBOX_TITLE', 'Информация о группе');
define('SET_BOX_CURRENCIES_TITLE', 'Валюты');
define('SET_BOX_LANGUAGES_TITLE', 'Языки');
define('SET_BOX_MANUFACTURERS_TITLE', 'Производитель');
define('SET_BOX_MANUFACTURERS_INFO_TITLE', 'Информация о производителе');
define('SET_BOX_FAQ_TITLE', 'Вопросы и ответы');

define('SET_BOX_CATEGORIES_DESC', 'Включить/выключить бокс.');
define('SET_BOX_FILTERS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_CONTENT_DESC', 'Включить/выключить бокс.');
define('SET_BOX_INFORMATION_DESC', 'Включить/выключить бокс.');
define('SET_BOX_ADD_QUICKIE_DESC', 'Включить/выключить бокс.');
define('SET_BOX_LAST_VIEWED_DESC', 'Включить/выключить бокс.');
define('SET_BOX_REVIEWS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_SEARCH_DESC', 'Включить/выключить бокс.');
define('SET_BOX_SPECIALS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_FEATURED_DESC', 'Включить/выключить бокс.');
define('SET_BOX_LATESTNEWS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_ARTICLES_DESC', 'Включить/выключить бокс.');
define('SET_BOX_ARTICLESNEW_DESC', 'Включить/выключить бокс.');
define('SET_BOX_AUTHORS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_CART_DESC', 'Включить/выключить бокс.');
define('SET_BOX_LOGIN_DESC', 'Включить/выключить бокс.');
define('SET_BOX_ADMIN_DESC', 'Включить/выключить бокс.');
define('SET_BOX_DOWNLOADS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_AFFILIATE_DESC', 'Включить/выключить бокс.');
define('SET_BOX_WHATSNEW_DESC', 'Включить/выключить бокс.');
define('SET_BOX_NEWSLETTER_DESC', 'Включить/выключить бокс.');
define('SET_BOX_BESTSELLERS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_INFOBOX_DESC', 'Включить/выключить бокс.');
define('SET_BOX_CURRENCIES_DESC', 'Включить/выключить бокс.');
define('SET_BOX_LANGUAGES_DESC', 'Включить/выключить бокс.');
define('SET_BOX_MANUFACTURERS_DESC', 'Включить/выключить бокс.');
define('SET_BOX_MANUFACTURERS_INFO_DESC', 'Включить/выключить бокс.');
define('SET_BOX_FAQ_DESC', 'Включить/выключить бокс.');

define('DISPLAY_START_PAGE_TITLE', 'Показывать на главной странице');
define('DISPLAY_START_PAGE_DESC', 'Показывать/не показывать колонку на главной странице.');

define('ENABLE_MAP_TAB_TITLE','Показывать закладку карта на странице заказа');
define('ENABLE_MAP_TAB_DESC','Включить/Отключить закладку карта на странице заказа.');
define('MAP_API_KEY_TITLE','Яндекс карты API-Ключ');
define('MAP_API_KEY_DESC','Укажите Ваш API ключ.');

define('AUTOMATIC_SEO_URL_TITLE','Автоматически генерировать SEO URL');
define('AUTOMATIC_SEO_URL_DESC','Автоматически генерировать SEO URL из названий товаров, категорий, информационных страниц и т.д.');

define('CG_EDIT_ORDERS', 'Редактор заказов');
define('CG_EDIT_ORDERS_TITLE', 'Редактор заказов');
define('CG_EDIT_ORDERS_DESC', '');

define('ORDER_EDITOR_PAYMENT_DROPDOWN_TITLE','Показывать dropdown меню с модулями оплаты?');
define('ORDER_EDITOR_PAYMENT_DROPDOWN_DESC','Показывать способ оплаты заказа в виде drop-down меню (true), либо в виде input поля (false).');
define('ORDER_EDITOR_USE_SPPC_TITLE','Использовать возможности модуля SPPC (должно быть выключено)?');
define('ORDER_EDITOR_USE_SPPC_DESC','Данная опция должна быть выключена, т.к. на данный момент модуль SPPC не установлен.');
define('ORDER_EDITOR_USE_AJAX_TITLE','Использовать Ajax при редактировании заказа?');
define('ORDER_EDITOR_USE_AJAX_DESC','Если Ваш браузер не поддерживает JavaScript, установите false.');
define('ORDER_EDITOR_CREDIT_CARD_TITLE','Выбери способ оплаты кредитной карточкой');
define('ORDER_EDITOR_CREDIT_CARD_DESC','Редактор заказов выведет поля для указания информации о карточке когда будет выбран указанный в настройке способ оплаты.');

define('CG_PRODUCTS_SPECIFICATIONS', 'Спецификации товаров');
define('CG_PRODUCTS_SPECIFICATIONS_TITLE', 'Спецификации товаров');
define('CG_PRODUCTS_SPECIFICATIONS_DESC', '');

//Products Specifications

define('SPECIFICATIONS_PRODUCTS_HEAD_TITLE', '<b>Страница карточки товара</b>');
define('SPECIFICATIONS_PRODUCTS_HEAD_DESC', 'Страница карточки товара');
define('SPECIFICATIONS_MINIMUM_PRODUCTS_TITLE', 'Минимум спецификаций у товара');
define('SPECIFICATIONS_MINIMUM_PRODUCTS_DESC', 'Минимальное количество спецификаций, которое должно быть у товара, необходимое для отображение бокса спецификаций на странице карточки товара');
define('SPECIFICATIONS_SHOW_NAME_PRODUCTS_TITLE', 'Показывать название спецификации');
define('SPECIFICATIONS_SHOW_NAME_PRODUCTS_DESC', 'Показывать название спецификации в боксе');
define('SPECIFICATIONS_SHOW_TITLE_PRODUCTS_TITLE', 'Показывать заголовок спецификации');
define('SPECIFICATIONS_SHOW_TITLE_PRODUCTS_DESC', 'Показывать заголовок спецификации в боксе');
define('SPECIFICATIONS_BOX_FRAME_STYLE_TITLE', 'Стиль бокса спецификаций');
define('SPECIFICATIONS_BOX_FRAME_STYLE_DESC', 'Показывать спецификации в стандартном боксе (Stock), в простом боксе (Simple), без бокса (Plain), либо в виде закладок (Tabs)');
define('SPECIFICATIONS_REVIEWS_TAB_TITLE', 'Показывать закладку отзывы');
define('SPECIFICATIONS_REVIEWS_TAB_DESC', 'Показывать закладку отзывы');
define('SPECIFICATIONS_MAX_REVIEWS_TITLE', 'Максимум отзывов в закладке');
define('SPECIFICATIONS_MAX_REVIEWS_DESC', 'Максимальное количество отзывов, отображаемых в закладке отзывы');
define('SPECIFICATIONS_QUESTION_TAB_TITLE', 'Показывать закладку задать вопрос о товаре');
define('SPECIFICATIONS_QUESTION_TAB_DESC', 'Показывать закладку задать вопрос о товаре');

define('SPECIFICATIONS_COMPARISON_HEAD_TITLE', '<b>Страница сравнения</b>');
define('SPECIFICATIONS_COMPARISON_HEAD_DESC', 'Страница сравнения');
define('SPECIFICATIONS_MINIMUM_COMPARISON_TITLE', 'Минимум спецификаций для сравнения');
define('SPECIFICATIONS_MINIMUM_COMPARISON_DESC', 'Минимальное количество спецификаций, которое должно быть у товара, необходимое для возможности сравнения');
define('SPECIFICATIONS_COMP_LINK_TITLE', 'Ссылка сравнения на начальной странице');
define('SPECIFICATIONS_COMP_LINK_DESC', 'Показывать ссылку сравнения на начальной странице');
define('SPECIFICATIONS_COMP_TABLE_ROW_TITLE', 'Рядов в таблице сравнения');
define('SPECIFICATIONS_COMP_TABLE_ROW_DESC', 'Количество рядов в таблице сравнения');
define('SPECIFICATIONS_BOX_COMPARISON_TITLE', 'Показывать сравнение');
define('SPECIFICATIONS_BOX_COMPARISON_DESC', 'Показывать таблицу сравнения на отдельной странице');
define('SPECIFICATIONS_BOX_COMP_INDEX_TITLE', 'Сравнение на начальной странице');
define('SPECIFICATIONS_BOX_COMP_INDEX_DESC', 'Показывать таблицу сравнения на начальной странице вместо страницы списка товара');
define('SPECIFICATIONS_COMP_SUFFIX_TITLE', 'Суффикс сравнения в заголовке');
define('SPECIFICATIONS_COMP_SUFFIX_DESC', 'Показывать суффикс в заголовке таблицы сравнения');
define('SPECIFICATIONS_COMPARISON_STYLE_TITLE', 'Стиль бокса спецификаций');
define('SPECIFICATIONS_COMPARISON_STYLE_DESC', 'Показывать спецификации в стандартном боксе (Stock), в простом боксе (Simple), либо без бокса (Plain)');
define('SPECIFICATIONS_COMBO_MFR_TITLE', 'Показывать производителя');
define('SPECIFICATIONS_COMBO_MFR_DESC', 'Показывать производителя (0 = не показывать, 1-9 = порядок сортировки)');
define('SPECIFICATIONS_COMBO_WEIGHT_TITLE', 'Показывать вес');
define('SPECIFICATIONS_COMBO_WEIGHT_DESC', 'Показывать вес (0 = не показывать, 1-9 = порядок сортировки)');
define('SPECIFICATIONS_COMBO_PRICE_TITLE', 'Показывать стоимость');
define('SPECIFICATIONS_COMBO_PRICE_DESC', 'Показывать стоимость (0 = не показывать, 1-9 = порядок сортировки)');
define('SPECIFICATIONS_COMBO_MODEL_TITLE', 'Показывать код товара');
define('SPECIFICATIONS_COMBO_MODEL_DESC', 'Показывать код товара (0 = не показывать, 1-9 = порядок сортировки)');
define('SPECIFICATIONS_COMBO_IMAGE_TITLE', 'Показывать картинку товара');
define('SPECIFICATIONS_COMBO_IMAGE_DESC', 'Показывать картинку товара (0 = не показывать, 1-9 = порядок сортировки)');
define('SPECIFICATIONS_COMBO_NAME_TITLE', 'Показывать название товара');
define('SPECIFICATIONS_COMBO_NAME_DESC', 'Показывать название товара (0 = не показывать, 1-9 = порядок сортировки)');
define('SPECIFICATIONS_COMBO_BUY_NOW_TITLE', 'Показывать кнопку купить сейчас');
define('SPECIFICATIONS_COMBO_BUY_NOW_DESC', 'Показывать кнопку купить сейчас (0 = не показывать, 1-9 = порядок сортировки)');

define('SPECIFICATIONS_FILTERS_HEAD_TITLE', '<b>Фильтры товаров</b>');
define('SPECIFICATIONS_FILTERS_HEAD_DESC', 'Фильтры товаров');
define('SPECIFICATIONS_FILTERS_MODULE_TITLE', 'Показывать фильтры');
define('SPECIFICATIONS_FILTERS_MODULE_DESC', 'Показывать фильтры в центральной колонке (основной части страницы)');
define('SPECIFICATIONS_FILTERS_BOX_TITLE', 'Показывать бокс фильтры');
define('SPECIFICATIONS_FILTERS_BOX_DESC', 'Показывать сбоку бокс фильтры');
define('SPECIFICATIONS_FILTER_MINIMUM_TITLE', 'Минимум спецификаций для фильтра');
define('SPECIFICATIONS_FILTER_MINIMUM_DESC', 'Минимальное количество спецификаций, необходимое для отображения бокса фильтры');
define('SPECIFICATIONS_FILTER_SUBCATEGORIES_TITLE', 'Фильтры подкатегорий');
define('SPECIFICATIONS_FILTER_SUBCATEGORIES_DESC', 'Включать подкатегории в результаты фильтрации');
define('SPECIFICATIONS_FILTER_SHOW_COUNT_TITLE', 'Показывать счётчик товаров в фильтрах');
define('SPECIFICATIONS_FILTER_SHOW_COUNT_DESC', 'Показывать количество найденных товаров');
define('SPECIFICATIONS_FILTER_NO_RESULT_TITLE', 'Не найдено товаров при фильтрации');
define('SPECIFICATIONS_FILTER_NO_RESULT_DESC', 'Что будет отображаться в случае отсутствия найденных товаров при фильтрации.');
define('SPECIFICATIONS_FILTER_BREADCRUMB_TITLE', 'Показывать навигацию');
define('SPECIFICATIONS_FILTER_BREADCRUMB_DESC', 'Показывать текущие фильтры в навигации');
define('SPECIFICATIONS_FILTER_IMAGE_WIDTH_TITLE', 'Ширина картинки фильтров');
define('SPECIFICATIONS_FILTER_IMAGE_WIDTH_DESC', 'Установите ширину картинки, отображаемой в боксе фильтры.');
define('SPECIFICATIONS_FILTER_IMAGE_HEIGHT_TITLE', 'Высота картинки фильтров');
define('SPECIFICATIONS_FILTER_IMAGE_HEIGHT_DESC', 'Установите высоту картинки, отображаемой в боксе фильтры.');

define('AVISOSMS_EMAIL_TITLE','SMS Email Шлюз');
define('AVISOSMS_EMAIL_DESC','Укажите свой email ящик для sms уведомление покупателей. Подробнее о настройке SMS уведомлений читайте на форуме https://forum.vamshop.ru/topic/16979-н');

define('CG_SMART_CHECKOUT', 'Оформление заказов');
define('CG_SMART_CHECKOUT_TITLE', 'Оформление заказов');
define('CG_SMART_CHECKOUT_DESC', '');

define('SMART_CHECKOUT_TITLE', 'Разрешить быстрое оформление заказов');
define('SMART_CHECKOUT_DESC', 'Вы хотите активировать модуль быстрого оформления заказов?');
define('SC_CREATE_ACCOUNT_REQUIRED_TITLE', 'Создание аккаунта обязательно');
define('SC_CREATE_ACCOUNT_REQUIRED_DESC', 'Обязательное создание аккаунта для покупателя при быстром оформлении заказа');
define('SC_CREATE_ACCOUNT_CHECKOUT_PAGE_TITLE', 'Создание аккаунта на усмотрение покупателя');
define('SC_CREATE_ACCOUNT_CHECKOUT_PAGE_DESC', 'Создание аккаунта для покупателя при быстром оформлении заказа не является обязательным, появляется опция при быстром оформлении заказа');
define('SC_HIDE_SHIPPING_TITLE', 'Скрыть выбор способа доставки');
define('SC_HIDE_SHIPPING_DESC', 'Если у Вас активирован только один модуль доставки, нет необходимости покупателю показывать выбор доставки на странице быстрого оформления заказа. Выбор доставки не показывается только если включена данная опция и у Вас активен только один модуль доставки.');
define('SC_HIDE_COMMENT_TITLE', 'Скрыть комментарии');
define('SC_HIDE_COMMENT_DESC', 'Показывать покупателю блок с возможностью оставить комментарии к заказу?');
define('SC_COUNTER_ENABLED_TITLE', 'Шаги оформления');
define('SC_COUNTER_ENABLED_DESC', 'Показывать шаги быстрого оформления заказа');
define('SC_EMAIL_LOGIN_DATA_TITLE', 'Отправлять данные для входа');
define('SC_EMAIL_LOGIN_DATA_DESC', 'Если включена данная опция, то данные для входа в магазин отправляются покупателю на указанный при быстром оформлении заказа email.');
define('SC_CONFIRMATION_PAGE_TITLE', 'Страница подтверждения заказа');
define('SC_CONFIRMATION_PAGE_DESC', 'Включить переход на страницу подтверждения заказа?');

define('DADATA_API_KEY_TITLE', 'DaData.Ru API ключ подсказок');
define('DADATA_API_KEY_DESC', 'Укажите свой ключ для подсказок DaData.Ru. API ключ можно получить в своём кабинете на dadata.ru/suggestions');

define('PHONE_MASK_TITLE', 'Маска телефона');
define('PHONE_MASK_DESC', 'Укажите шаблон для ввода телефонного номера');

define('COMPANIES_TEXT_TITLE' , 'Текст для страницы компаний');
define('COMPANIES_TEXT_DESC' , '');

define('CG_COMPANY_TEXT_SETTINGS', 'Карточки компаний');
define('CG_COMPANY_TEXT_SETTINGS_TITLE', 'Карточки компаний');
define('CG_COMPANY_TEXT_SETTINGS_DESC', '');


define('COMPANY_PAYMENT_TEXT_TITLE', 'Общий текст оплаты на странице карточки компании');
define('COMPANY_PAYMENT_TEXT_DESC', '');

define('COMPANY_SHIPPING_TEXT_TITLE', 'Общий текст доставки на странице карточки компании');
define('COMPANY_SHIPPING_TEXT_DESC', '');

define('COMPANY_PAYMENT_3_MASK_TITLE', 'Шаблон для оплаты электронными деньгами');
define('COMPANY_PAYMENT_3_MASK_DESC', '');

define('COMPANY_PAYMENT_4_MASK_TITLE', 'Шаблон для безналичной оплаты');
define('COMPANY_PAYMENT_4_MASK_DESC', '');

define('DEFAULT_SLIDER_TITLE', 'Слайдер по умолчанию');
define('DEFAULT_SLIDER_DESC', 'Выберите вариант слайдера по умолчанию. Управление слайдерами в Админке - Разное - Управление баннерами');

define('ENABLE_SERVICE_WORKER_TITLE', 'Разрешить установку Service Worker');
define('ENABLE_SERVICE_WORKER_DESC', 'Разрешить установку Service Worker в браузере.');

define('SOCIAL_LOGIN_TITLE', 'Разрешить вход через соц. сети');
define('SOCIAL_LOGIN_DESC', 'Разрешить вход в магазин через соц. сети.');

define('CG_SOCIAL_NETWORKS', 'Социальные сети');
define('CG_SOCIAL_NETWORKS_TITLE', 'Социальные сети');
define('CG_SOCIAL_NETWORKS_DESC', '');

define('GOOGLE_OAUTH_CLIENT_ID_TITLE', 'Google OAuth ID Клиента');
define('GOOGLE_OAUTH_CLIENT_ID_DESC', 'Укажите Ваш OAuth ID номер.');
define('GOOGLE_OAUTH_SECRET_KEY_TITLE', 'Google OAuth Секретный Ключ');
define('GOOGLE_OAUTH_SECRET_KEY_DESC', 'Укажите Ваш секретный ключ Google OAuth.');
define('VK_OAUTH_CLIENT_ID_TITLE', 'ID номер приложения вконтакте');
define('VK_OAUTH_CLIENT_ID_DESC', 'Укажите Ваш ID номер приложения вконтакте');
define('VK_OAUTH_SECRET_KEY_TITLE', 'Защищённый ключ вконтакте');
define('VK_OAUTH_SECRET_KEY_DESC', 'Укажите Ваш защищённый ключ вконтакте.');
define('VK_OAUTH_SERVICE_KEY_TITLE', 'Сервисный ключ доступа вконтакте');
define('VK_OAUTH_SERVICE_KEY_DESC', 'Укажиет Ваш сервисный ключ доступа.');
define('FACEBOOK_OAUTH_CLIENT_ID_TITLE', 'Facebook OAuth ID приложения');
define('FACEBOOK_OAUTH_CLIENT_ID_DESC', 'Укажите Ваш OAuth ID номер приложения.');
define('FACEBOOK_OAUTH_SECRET_KEY_TITLE', 'Facebook OAuth Ключ приложения');
define('FACEBOOK_OAUTH_SECRET_KEY_DESC', 'Укажитие Ваш OAuth ключ приложения.');

define('DEFAULT_NAVIGATION_TITLE', 'Меню навигации по умолчанию');
define('DEFAULT_NAVIGATION_DESC', 'Выберите тип навигации по умолчанию.');

define('ENABLE_COOKIE_ALERT_TITLE', 'Показывать cookie уведомление');
define('ENABLE_COOKIE_ALERT_DESC', 'Показывать уведомление об использовании cookie файлов на сайте.');

define('PRODUCT_LISTING_ATTRIBUTES_TITLE' , 'Показывать атрибуты товара в списке товара внутри категорий');
define('PRODUCT_LISTING_ATTRIBUTES_DESC', 'В списке товара внутри категории выводить атрибуты товара.');

define('ALLOW_AUTOLOGON_TITLE' , 'Разрешить автологин');
define('ALLOW_AUTOLOGON_DESC', 'Разрешить зарегистрированным пользователям сохранять информацию в cookie и автоматически авторизоваться в магазине при входе.');

define('DISPLAY_LIKES_TITLE' , 'Показывать лайки');
define('DISPLAY_LIKES_DESC', 'Показывать лайки.');
define('DISPLAY_DISLIKES_TITLE' , 'Показывать дизлайки');
define('DISPLAY_DISLIKES_DESC', 'Показывать дизлайки.');

define('DISPLAY_LAST_VIEWED_TITLE' , 'Показывать последние просмотренные товары');
define('DISPLAY_LAST_VIEWED_DESC', 'Показывать последние просмотренные товары.');

define('SPECIFICATIONS_FILTERS_SEO_MAX_FILTER_IDS_TITLE', 'Максимум фильтров для SEO');
define('SPECIFICATIONS_FILTERS_SEO_MAX_FILTER_IDS_DESC', 'Максимальное количество фильтров, используемое для генерации статической страницы');
define('SPECIFICATIONS_FILTERS_SEO_MAX_FILTER_VALUES_TITLE', 'Максимум значений фильтра для SEO');
define('SPECIFICATIONS_FILTERS_SEO_MAX_FILTER_VALUES_DESC', 'Максимальное количество значений фильтра, используемое для генерации статической страницы');
define('SPECIFICATIONS_FILTERS_HIDE_EMPTY_FILTERS_GROUP_TITLE', 'Скрывать группы характеристик без самих характеристик');
define('SPECIFICATIONS_FILTERS_HIDE_EMPTY_FILTERS_GROUP_DESC', '');

define('ENABLE_1C_EXCHANGE_TITLE' , 'Разрешить двусторонний обмен заказами, ценами, остатками, номенклатурой между VamShop и 1С:Предприятие. Подробная информация <a href="https://forum.vamshop.ru/topic/16769-%D0%B8%D0%BD%D1%82%D0%B5%D0%B3%D1%80%D0%B0%D1%86%D0%B8%D1%8F-vamshop-%D0%B8-1%D1%81%D0%BF%D1%80%D0%B5%D0%B4%D0%BF%D1%80%D0%B8%D1%8F%D1%82%D0%B8%D0%B5/" target="_blank"><u>здесь</u></a>.');
define('ENABLE_1C_EXCHANGE_DESC', 'Разрешить двусторонний обмен заказами, ценами, остатками, номенклатурой между VamShop и 1С:Предприятие.');

define('CG_1C_EXCHANGE', '1С:Предприятие');
define('CG_1C_EXCHANGE_TITLE', '1С:Предприятие');
define('CG_1C_EXCHANGE_DESC', '');

define('ONE_CLICK_BUY_TITLE' , 'Разрешить модуль Купить в 1 клик');
define('ONE_CLICK_BUY_DESC', 'Показывать модуль Купить в 1 клик на странице карточки товара.');

define('DISPLAY_PRIVACY_TEXT_TITLE' , 'Показывать текст про защиту персональных данных');
define('DISPLAY_PRIVACY_TEXT_DESC', 'Показывать текст про защиту персональных данных.');

define('STORE_VK_TITLE' , 'ВКонтакте');
define('STORE_VK_DESC', 'Ваш аккаунт ВКонтакте.');
define('STORE_FACEBOOK_TITLE' , 'Facebook');
define('STORE_FACEBOOK_DESC', 'Ваш аккаунт Facebook.');
define('STORE_TELEGRAM_TITLE' , 'Telegram');
define('STORE_TELEGRAM_DESC', 'Ваш аккаунт Telegram.');
define('STORE_INSTAGRAM_TITLE' , 'Instagram');
define('STORE_INSTAGRAM_DESC', 'Ваш аккаунт Instagram.');
define('STORE_TWITTER_TITLE' , 'Twitter');
define('STORE_TWITTER_DESC', 'Ваш аккаунт Twitter.');
define('STORE_YOUTUBE_TITLE' , 'YouTube');
define('STORE_YOUTUBE_DESC', 'Ваш аккаунт YouTube.');
define('STORE_WHATSAPP_TITLE' , 'WhatsApp');
define('STORE_WHATSAPP_DESC', 'Ваш аккаунт WhatsApp.');
define('STORE_VIBER_TITLE' , 'Viber');
define('STORE_VIBER_DESC', 'Ваш аккаунт Viber.');

define('DISPLAY_CART_IN_CHECKOUT_TITLE' , 'Показывать корзину на странице оформления заказа');
define('DISPLAY_CART_IN_CHECKOUT_DESC', 'Показывать корзину на странице оформления заказа.');

define('DISPLAY_WHOS_ONLINE_TITLE' , 'Показывать блок Кто в онлайне? на главной админки');
define('DISPLAY_WHOS_ONLINE_DESC', 'Показывать блок Кто в онлайне? на главной админки');

define('ENABLE_LAZY_LOAD_TITLE' , 'Разрешить Lazy Load');
define('ENABLE_LAZY_LOAD_DESC', 'Разрешить отложенную загрузку.');

define('MAX_DISPLAY_TAGS_TITLE' , 'Бокс тэги');
define('MAX_DISPLAY_TAGS_DESC' , 'Количество тэгов, отображаемых в боксе');
define('MAX_DISPLAY_TAGS_PAGE_TITLE' , 'Тэгов на одной странице');
define('MAX_DISPLAY_TAGS_PAGE_DESC' , 'Количество тэгов, отображаемых на одной станице');
define('MAX_DISPLAY_TAGS_DESCRIPTION_TITLE' , 'Теги описание');
define('MAX_DISPLAY_TAGS_DESCRIPTION_DESC' , 'Количество символов, отображаемых при предварительном просмотре тэгов');

define('MODULE_ORDER_DAYS_TITLE' , 'Заказы старше X дней');
define('MODULE_ORDER_DAYS_DESC' , 'Заказы, оформленные в магазине более X дней назад, где X - это число. В данной опции указывайте просто число.');
define('MODULE_ORDER_STATUS_HAVE_TITLE' , 'Заказы имеющие статус');
define('MODULE_ORDER_STATUS_HAVE_DESC' , 'Заказы, у которых текущий статус равен указанному.');
define('MODULE_ORDER_STATUS_TITLE' , 'Новый статус заказа');
define('MODULE_ORDER_STATUS_DESC' , 'Заказы, у которых текущий статус равен указанному.Укажите новый статус заказа, который будет выставлен всем соответствующим настройке заказам.');

define('MODULE_ORDER_DAYS_2_TITLE' , 'Заказы старше X дней');
define('MODULE_ORDER_DAYS_2_DESC' , 'Заказы, оформленные в магазине более X дней назад, где X - это число. В данной опции указывайте просто число.');
define('MODULE_ORDER_STATUS_HAVE_2_TITLE' , 'Заказы имеющие статус');
define('MODULE_ORDER_STATUS_HAVE_2_DESC' , 'Заказы, у которых текущий статус равен указанному.');
define('MODULE_ORDER_STATUS_2_TITLE' , 'Новый статус заказа');
define('MODULE_ORDER_STATUS_2_DESC' , 'Заказы, у которых текущий статус равен указанному.Укажите новый статус заказа, который будет выставлен всем соответствующим настройке заказам.');

define('MODULE_ORDER_DAYS_3_TITLE' , 'Заказы старше X дней');
define('MODULE_ORDER_DAYS_3_DESC' , 'Заказы, оформленные в магазине более X дней назад, где X - это число. В данной опции указывайте просто число.');
define('MODULE_ORDER_STATUS_HAVE_3_TITLE' , 'Заказы имеющие статус');
define('MODULE_ORDER_STATUS_HAVE_3_DESC' , 'Заказы, у которых текущий статус равен указанному.');
define('MODULE_ORDER_STATUS_3_TITLE' , 'Новый статус заказа');
define('MODULE_ORDER_STATUS_3_DESC' , 'Заказы, у которых текущий статус равен указанному.Укажите новый статус заказа, который будет выставлен всем соответствующим настройке заказам.');

define('MODULE_ORDER_DAYS_4_TITLE' , 'Заказы старше X дней');
define('MODULE_ORDER_DAYS_4_DESC' , 'Заказы, оформленные в магазине более X дней назад, где X - это число. В данной опции указывайте просто число.');
define('MODULE_ORDER_STATUS_HAVE_4_TITLE' , 'Заказы имеющие статус');
define('MODULE_ORDER_STATUS_HAVE_4_DESC' , 'Заказы, у которых текущий статус равен указанному.');
define('MODULE_ORDER_STATUS_4_TITLE' , 'Новый статус заказа');
define('MODULE_ORDER_STATUS_4_DESC' , 'Заказы, у которых текущий статус равен указанному.Укажите новый статус заказа, который будет выставлен всем соответствующим настройке заказам.');

define('MODULE_ORDER_MINUTES_5_TITLE' , 'Заказы старше Y минут');
define('MODULE_ORDER_MINUTES_5_DESC' , 'Заказы, оформленные в магазине более Y минут назад, где Y - это число. В данной опции указывайте просто число.');
define('MODULE_ORDER_STATUS_HAVE_5_TITLE' , 'Заказы имеющие статус');
define('MODULE_ORDER_STATUS_HAVE_5_DESC' , 'Заказы, у которых текущий статус равен указанному.');
define('MODULE_ORDER_STATUS_5_TITLE' , 'Новый статус заказа');
define('MODULE_ORDER_STATUS_5_DESC' , 'Заказы, у которых текущий статус равен указанному.Укажите новый статус заказа, который будет выставлен всем соответствующим настройке заказам.');

define('MODULE_ORDER_MINUTES_6_TITLE' , 'Заказы старше Y минут');
define('MODULE_ORDER_MINUTES_6_DESC' , 'Заказы, оформленные в магазине более Y минут назад, где Y - это число. В данной опции указывайте просто число.');
define('MODULE_ORDER_STATUS_HAVE_6_TITLE' , 'Заказы имеющие статус');
define('MODULE_ORDER_STATUS_HAVE_6_DESC' , 'Заказы, у которых текущий статус равен указанному.');
define('MODULE_ORDER_STATUS_6_TITLE' , 'Новый статус заказа');
define('MODULE_ORDER_STATUS_6_DESC' , 'Заказы, у которых текущий статус равен указанному.Укажите новый статус заказа, который будет выставлен всем соответствующим настройке заказам.');

define('SIMILAR_PRODUCTS_TITLE' , 'Показывать модуль Похожие товары?');
define('SIMILAR_PRODUCTS_DESC' , 'Блок похожие товары выводится на странице карточки товара.');
define('SIMILAR_PRODUCTS_FULL_TITLE' , 'Количество выбираемых похожих товаров из всех найденых похожих товаров');
define('SIMILAR_PRODUCTS_FULL_DESC' , '');
define('SIMILAR_PRODUCTS_RAND_TITLE' , 'Количество похожих товаров которые будут выводится рандомно (из числа выбранных)');
define('SIMILAR_PRODUCTS_RAND_DESC' , '');

define('MAX_DISPLAY_REVIEW_TEXT_TITLE' , 'Максимум символов в отзывах');
define('MAX_DISPLAY_REVIEW_TEXT_DESC' , 'Количество символов, выводимых в отзывах, что б объёмное описание на ломало дизайн.');

define('DARK_THEME_TITLE' , 'Поддержка тёмной темы оформления');
define('DARK_THEME_DESC' , 'Если на смартфоне в настройках включена тёмная тема, то и VamShop по умолчанию будет в тёмном цвете, а так же будет переключатель тёмная/светлая тема.');

define('REVIEWS_IMAGES_UPLOAD_TITLE' , 'Разрешить загрузку картинок к отзывам');
define('REVIEWS_IMAGES_UPLOAD_DESC' , 'Разрешить загрузку картинок к отзывам.');

?>