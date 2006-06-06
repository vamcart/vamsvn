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

define('TABLE_HEADING_CONFIGURATION_TITLE', 'Заголовок');
define('TABLE_HEADING_CONFIGURATION_VALUE', 'Значение');
define('TABLE_HEADING_ACTION', 'Действие');

define('TEXT_INFO_EDIT_INTRO', 'Пожалуйста, внесите необходимые изменения');
define('TEXT_INFO_DATE_ADDED', 'Дата добавления:');
define('TEXT_INFO_LAST_MODIFIED', 'Последнее изменение:');

// language definitions for config
define('STORE_NAME_TITLE' , 'Название магазина');
define('STORE_NAME_DESC' , 'Название моего магазина');
define('STORE_OWNER_TITLE' , 'Владелец');
define('STORE_OWNER_DESC' , 'Имя владельца');
define('STORE_OWNER_EMAIL_ADDRESS_TITLE' , 'E-Mail адрес');
define('STORE_OWNER_EMAIL_ADDRESS_DESC' , 'E-mail адрес владельца магазина');

define('EMAIL_FROM_TITLE' , 'E-Mail от');
define('EMAIL_FROM_DESC' , 'E-mail Adress в отсылаемых письмах.');

define('STORE_COUNTRY_TITLE' , 'Страна');
define('STORE_COUNTRY_DESC' , 'Страна где находится магазин <br /><br /><b>Заметка: Не забудьте обновить зоны.</b>');
define('STORE_ZONE_TITLE' , 'Зона');
define('STORE_ZONE_DESC' , 'Зона где находится магазин.');

define('EXPECTED_PRODUCTS_SORT_TITLE' , 'Порядок сортировки ожидаемых товаров');
define('EXPECTED_PRODUCTS_SORT_DESC' , 'Этот порядок сортировки устанавливается в разделе ожидаемых товаров.');
define('EXPECTED_PRODUCTS_FIELD_TITLE' , 'Раздел ожидаемых товаров');
define('EXPECTED_PRODUCTS_FIELD_DESC' , 'Выбор значения для сортировки.');

define('USE_DEFAULT_LANGUAGE_CURRENCY_TITLE' , 'Переключение на валюту языка');
define('USE_DEFAULT_LANGUAGE_CURRENCY_DESC' , 'Автоматическое переключение на валюту выбранного языка.');

define('SEND_EXTRA_ORDER_EMAILS_TO_TITLE' , 'Дополнительные E-mail с заказами:');
define('SEND_EXTRA_ORDER_EMAILS_TO_DESC' , 'Послать дополнительные письма с заказами по дополнительным адресам, в таком формате: Имя 1 &lt;email@adress1&gt;, Имя 2 &lt;email@adress2&gt;');

define('SEARCH_ENGINE_FRIENDLY_URLS_TITLE' , 'Использовать короткие URL совместимые с поисковиками?');
define('SEARCH_ENGINE_FRIENDLY_URLS_DESC' , 'Использовать короткие URL совместимые с поисковиками. говорят помогает (:');

define('DISPLAY_CART_TITLE' , 'Показывать корзину после добавления товара?');
define('DISPLAY_CART_DESC' , 'Показывать корзину после добавления товара или возвращаться на страницу товара?');

define('ALLOW_GUEST_TO_TELL_A_FRIEND_TITLE' , 'Разрешить гостям писать друзьям?');
define('ALLOW_GUEST_TO_TELL_A_FRIEND_DESC' , 'Разрешить гостям писать друзьям о товаре?');

define('ADVANCED_SEARCH_DEFAULT_OPERATOR_TITLE' , 'Оператор поиска по умолчанию');
define('ADVANCED_SEARCH_DEFAULT_OPERATOR_DESC' , 'Оператор поиска по умолчанию.');

define('STORE_NAME_ADDRESS_TITLE' , 'Адрес магазина и телефон');
define('STORE_NAME_ADDRESS_DESC' , 'Контактная информация которая отображается на сайте.');

define('SHOW_COUNTS_TITLE' , 'Показывать счетчик товаров?');
define('SHOW_COUNTS_DESC' , 'Показывать счетчик товаров в категориях в боксе Категории?');

define('DISPLAY_PRICE_WITH_TAX_TITLE' , 'Показывать цены с налогами?');
define('DISPLAY_PRICE_WITH_TAX_DESC' , 'Налог включать в цену (true) или добавлять в конце при оформлении? (false)');

define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_TITLE' , 'Статус людей из Администрации');
define('DEFAULT_CUSTOMERS_STATUS_ID_ADMIN_DESC' , 'Выберите статус людей из команды Администрации!');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_TITLE' , 'Статус покупателя Гость');
define('DEFAULT_CUSTOMERS_STATUS_ID_GUEST_DESC' , 'Каким будет по умолчанию статус Гостя перед регистрацией');
define('DEFAULT_CUSTOMERS_STATUS_ID_TITLE' , 'Статус покупателя для Нового клиента');
define('DEFAULT_CUSTOMERS_STATUS_ID_DESC' , 'Каким будет по умолчанию статус Нового клиента после регистрации');

define('ALLOW_ADD_TO_CART_TITLE' , 'Разрешить добавлять в корзину');
define('ALLOW_ADD_TO_CART_DESC' , 'Разрешить покупателю добавлять в корзину если его статус &quot;показывать цены&quot; выставлен в  0');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_TITLE' , 'Разрешить скидку на атрибуты товара?');
define('ALLOW_DISCOUNT_ON_PRODUCTS_ATTRIBUTES_DESC' , 'Разрешить покупателю получить скидку на товар с атрибутами (если основной товар не находится в разделе &quot;Спец.цена&quot;?)');
define('CURRENT_TEMPLATE_TITLE' , 'Шаблоны');
define('CURRENT_TEMPLATE_DESC' , 'Выберите основной шаблон для Вашего магазина. Который находится: www.Your-Domain.com/templates/');

define('CC_KEYCHAIN_TITLE','КК строка');
define('CC_KEYCHAIN_DESC','Строка для шифрования кредитной карты (CC number) (пожалуйста, измените!)');

define('ENTRY_FIRST_NAME_MIN_LENGTH_TITLE' , 'Имя');
define('ENTRY_FIRST_NAME_MIN_LENGTH_DESC' , 'Минимальная длина для имени');
define('ENTRY_LAST_NAME_MIN_LENGTH_TITLE' , 'Фамилия');
define('ENTRY_LAST_NAME_MIN_LENGTH_DESC' , 'Минимальная длина для фамилии');
define('ENTRY_DOB_MIN_LENGTH_TITLE' , 'Дата рождения');
define('ENTRY_DOB_MIN_LENGTH_DESC' , 'Минимальная длина для даты рождения');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_TITLE' , 'E-Mail адрес');
define('ENTRY_EMAIL_ADDRESS_MIN_LENGTH_DESC' , 'Минимальная длина для E-Mail адреса');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_TITLE' , 'Адрес');
define('ENTRY_STREET_ADDRESS_MIN_LENGTH_DESC' , 'Минимальная длина для адреса');
define('ENTRY_COMPANY_MIN_LENGTH_TITLE' , 'Компания');
define('ENTRY_COMPANY_MIN_LENGTH_DESC' , 'Минимальная длина для названия компании');
define('ENTRY_POSTCODE_MIN_LENGTH_TITLE' , 'Индекс');
define('ENTRY_POSTCODE_MIN_LENGTH_DESC' , 'Минимальная длина для индекса. Если оставить пустым, то поле будет не обязательным.');
define('ENTRY_CITY_MIN_LENGTH_TITLE' , 'Город');
define('ENTRY_CITY_MIN_LENGTH_DESC' , 'Минимальная длина для города. Если оставить пустым, то поле будет не обязательным.');
define('ENTRY_STATE_MIN_LENGTH_TITLE' , 'Область');
define('ENTRY_STATE_MIN_LENGTH_DESC' , 'Минимальная длина для области');
define('ENTRY_TELEPHONE_MIN_LENGTH_TITLE' , 'Телефон');
define('ENTRY_TELEPHONE_MIN_LENGTH_DESC' , 'Минимальная длина для телефона');
define('ENTRY_PASSWORD_MIN_LENGTH_TITLE' , 'Пароль');
define('ENTRY_PASSWORD_MIN_LENGTH_DESC' , 'Минимальная длина для пароля');

define('CC_OWNER_MIN_LENGTH_TITLE' , 'Вледелец кредитной карты');
define('CC_OWNER_MIN_LENGTH_DESC' , 'Минимальная длина для имени владельца');
define('CC_NUMBER_MIN_LENGTH_TITLE' , 'Номер кредитной карты');
define('CC_NUMBER_MIN_LENGTH_DESC' , 'Минимальная длина для номера кредитной карты');

define('REVIEW_TEXT_MIN_LENGTH_TITLE' , 'Текст отзыва');
define('REVIEW_TEXT_MIN_LENGTH_DESC' , 'Минимальная длина для отзыва');

define('MIN_DISPLAY_BESTSELLERS_TITLE' , 'Лидеры продаж');
define('MIN_DISPLAY_BESTSELLERS_DESC' , 'Минимальное значение для лидера продаж');
define('MIN_DISPLAY_ALSO_PURCHASED_TITLE' , 'Также заказали');
define('MIN_DISPLAY_ALSO_PURCHASED_DESC' , 'Минимальная длина для описания в боксе &quot;Наши клиенты также заказали&quot;');

define('MAX_ADDRESS_BOOK_ENTRIES_TITLE' , 'Записи в адресной книге');
define('MAX_ADDRESS_BOOK_ENTRIES_DESC' , 'Максимальное количество записей в адресной книге покупателя');
define('MAX_DISPLAY_SEARCH_RESULTS_TITLE' , 'Результаты поиска');
define('MAX_DISPLAY_SEARCH_RESULTS_DESC' , 'Вывод количества товаров после поиска на странице');
define('MAX_DISPLAY_PAGE_LINKS_TITLE' , 'Ссылки на страницы');
define('MAX_DISPLAY_PAGE_LINKS_DESC' , 'Количество ссылок на другие страницы');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE' , 'Специальные цены');
define('MAX_DISPLAY_SPECIAL_PRODUCTS_DESC' , 'Максимальное количество скидок при выводе');
define('MAX_DISPLAY_NEW_PRODUCTS_TITLE' , 'Новинки');
define('MAX_DISPLAY_NEW_PRODUCTS_DESC' , 'Максимальное количество новинок на главной');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_TITLE' , 'Ожидаемые товары');
define('MAX_DISPLAY_UPCOMING_PRODUCTS_DESC' , 'Максимальное количество ожидаемых товаров при выводе');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_TITLE' , 'Производители');
define('MAX_DISPLAY_MANUFACTURERS_IN_A_LIST_DESC' , 'Используется в боксе Производители; если число издательств превышает установленное число, тогда будет появлятся &quot;дроп-даун&quot; меню вместо списка');
define('MAX_MANUFACTURERS_LIST_TITLE' , 'Отображение Производителей');
define('MAX_MANUFACTURERS_LIST_DESC' , 'Используется в боксе производителей, когда &quot;дроп-даун&quot; меню. Данное значение будет влиять на высоту тега &lt;select&gt;, в частности size=&quot;число&quot;.');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_TITLE' , 'Название Производителя');
define('MAX_DISPLAY_MANUFACTURER_NAME_LEN_DESC' , 'Максимальная длина названий в боксе Производители. Если длина будет превышена, то название обрежится.');
define('MAX_DISPLAY_NEW_REVIEWS_TITLE' , 'Новые Отзывы');
define('MAX_DISPLAY_NEW_REVIEWS_DESC' , 'Максимальное количество показываемых Отзывов');
define('MAX_RANDOM_SELECT_REVIEWS_TITLE' , 'Выбор случайного показа Отзывов');
define('MAX_RANDOM_SELECT_REVIEWS_DESC' , 'Из какого количества выбирать случайных показ Отзывов');
define('MAX_RANDOM_SELECT_NEW_TITLE' , 'Выбор случайного показа Новинок');
define('MAX_RANDOM_SELECT_NEW_DESC' , 'Из какого количества выбирать случайных показ Новинок');
define('MAX_RANDOM_SELECT_SPECIALS_TITLE' , 'Выбор случайного показа Скидок');
define('MAX_RANDOM_SELECT_SPECIALS_DESC' , 'Из какого количества выбирать случайных показ Скидок');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_TITLE' , 'Количество категорий в строке');
define('MAX_DISPLAY_CATEGORIES_PER_ROW_DESC' , 'Максимальное количество категорий в строке');
define('MAX_DISPLAY_PRODUCTS_NEW_TITLE' , 'Листинг Новинок');
define('MAX_DISPLAY_PRODUCTS_NEW_DESC' , 'Максимальное количество новинок на странице Новинок');
define('MAX_DISPLAY_BESTSELLERS_TITLE' , 'Лидеры продаж');
define('MAX_DISPLAY_BESTSELLERS_DESC' , 'Максимальное количество записей в боксе Лидеров продаж');
define('MAX_DISPLAY_ALSO_PURCHASED_TITLE' , 'Также заказали');
define('MAX_DISPLAY_ALSO_PURCHASED_DESC' , 'Максимальное количество товаров в боксе &quot;Наши покупатели также заказали&quot;');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_TITLE' , 'Бокс истории заказов Покупателя ');
define('MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX_DESC' , 'Максимальное количество товаров в боксе историй');
define('MAX_DISPLAY_ORDER_HISTORY_TITLE' , 'История заказов');
define('MAX_DISPLAY_ORDER_HISTORY_DESC' , 'Максимальное количество заказов на странице истории заказов');
define('MAX_PRODUCTS_QTY_TITLE', 'Максимальное количество товаров');
define('MAX_PRODUCTS_QTY_DESC', 'Максимальное количество одинаковых товаров в корзине покупателя');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_TITLE' , 'Максимальное количество дней для нового товара');
define('MAX_DISPLAY_NEW_PRODUCTS_DAYS_DESC' , 'Сколько дней товар будет считаться новым и будет отображаться в новых товарах');


define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_TITLE' , 'Ширина превьюшки на странице товара');
define('PRODUCT_IMAGE_THUMBNAIL_WIDTH_DESC' , 'Ширина превьюшки на странице товара в пикселах ');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_TITLE' , 'Высота превьюшки на странице товара');
define('PRODUCT_IMAGE_THUMBNAIL_HEIGHT_DESC' , 'Высота превьюшки на странице товара в пикселах');

define('PRODUCT_IMAGE_INFO_WIDTH_TITLE' , 'Ширина картинки на странице товара');
define('PRODUCT_IMAGE_INFO_WIDTH_DESC' , 'Ширина картинки на странице товара в пикселах');
define('PRODUCT_IMAGE_INFO_HEIGHT_TITLE' , 'Высота картинки на странице товара');
define('PRODUCT_IMAGE_INFO_HEIGHT_DESC' , 'Высота картинки на странице товара в пикселах');

define('PRODUCT_IMAGE_POPUP_WIDTH_TITLE' , 'Ширина POP-UP картинки');
define('PRODUCT_IMAGE_POPUP_WIDTH_DESC' , 'Ширина POP-UP картинки в пикселах (напр. <b>300</b>). Если значение оставить пустым, то картинка не будет создана совсем!');
define('PRODUCT_IMAGE_POPUP_HEIGHT_TITLE' , 'Высота POP-UP картинки');
define('PRODUCT_IMAGE_POPUP_HEIGHT_DESC' , 'Высота POP-UP картинки в пикселах');

define('SMALL_IMAGE_WIDTH_TITLE' , 'Ширина превью картинки');
define('SMALL_IMAGE_WIDTH_DESC' , 'Ширина превью картинки (в пикселах)');
define('SMALL_IMAGE_HEIGHT_TITLE' , 'Высота превью картинки');
define('SMALL_IMAGE_HEIGHT_DESC' , 'Высота превью картинки (в пикселах)');

define('HEADING_IMAGE_WIDTH_TITLE' , 'Ширина картинки категории');
define('HEADING_IMAGE_WIDTH_DESC' , 'Ширина картинки категории (в пикселах)');
define('HEADING_IMAGE_HEIGHT_TITLE' , 'Высота картинки категории');
define('HEADING_IMAGE_HEIGHT_DESC' , 'Высота картинки категории (в пикселах)');

define('SUBCATEGORY_IMAGE_WIDTH_TITLE' , 'Ширина картинки подкатегории');
define('SUBCATEGORY_IMAGE_WIDTH_DESC' , 'Ширина картинки подкатегории (в пикселах)');
define('SUBCATEGORY_IMAGE_HEIGHT_TITLE' , 'Высота картинки подкатегории');
define('SUBCATEGORY_IMAGE_HEIGHT_DESC' , 'Высота картинки подкатегории (в пикселах)');

define('CONFIG_CALCULATE_IMAGE_SIZE_TITLE' , 'Вычислять размер картинки');
define('CONFIG_CALCULATE_IMAGE_SIZE_DESC' , 'Вычислять размер картинки?');

define('IMAGE_REQUIRED_TITLE' , 'Картинку выводить в любом случае');
define('IMAGE_REQUIRED_DESC' , 'Используется для разработки.');

//This is for the Images showing your products for preview. All the small stuff.

define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_TITLE' , 'Превьюшка товара:Bevel<br /><img src="images/config_bevel.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_BEVEL_DESC' , 'Превьюшка товара:Bevel<br /><br />По умолчанию: (8,FFCCCC,330000)<br /><br />затененные скошенные края<br />Используется:<br />(край ширина,hex свелый цвет,hex темный цвет)');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_TITLE' , 'Превьюшка товара:Greyscale<br /><img src="images/config_greyscale.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_GREYSCALE_DESC' , 'Превьюшка товара:Greyscale<br /><br />По умолчанию: (32,22,22)<br /><br />basic black n white<br />Используется:<br />(int red,int green,int blue)');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_TITLE' , 'Превьюшка товара:Ellipse<br /><img src="images/config_eclipse.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_ELLIPSE_DESC' , 'Превьюшка товара:Ellipse<br /><br />По умолчанию: (FFFFFF)<br /><br />ellipse on bg colour<br />Используется:<br />(hex background colour)');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_TITLE' , 'Превьюшка товара:Round-edges<br /><img src="images/config_edge.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_ROUND_EDGES_DESC' , 'Превьюшка товара:Round-edges<br /><br />По умолчанию: (5,FFFFFF,3)<br /><br />corner trimming<br />Используется:<br />(edge_radius,background colour,anti-alias width)');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_TITLE' , 'Превьюшка товара:Merge<br /><img src="images/config_merge.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_MERGE_DESC' , 'Превьюшка товара:Merge<br /><br />По умолчанию: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Используется:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity, transparent colour on merge image)');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_TITLE' , 'Превьюшка товара:Frame<br /><img src="images/config_frame.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_FRAME_DESC' , 'Превьюшка товара:Frame<br /><br />По умолчанию: <br /><br />plain raised border<br />Используется:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_TITLE' , 'Превьюшка товара:Drop-Shadow<br /><img src="images/config_shadow.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_DROP_SHADDOW_DESC' , 'Превьюшка товара:Drop-Shadow<br /><br />По умолчанию: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Используется:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_TITLE' , 'Превьюшка товара:Motion-Blur<br /><img src="images/config_motion.gif" />');
define('PRODUCT_IMAGE_THUMBNAIL_MOTION_BLUR_DESC' , 'Превьюшка товара:Motion-Blur<br /><br />По умолчанию: (4,FFFFFF)<br /><br />fading parallel lines<br />Используется:<br />(int number of lines,hex background colour)');

//And this is for the Images showing your products in single-view

define('PRODUCT_IMAGE_INFO_BEVEL_TITLE' , 'Страница товара-картинка:Bevel');
define('PRODUCT_IMAGE_INFO_BEVEL_DESC' , 'Страница товара-картинка:Bevel<br /><br />По умолчанию: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Используется:<br />(edge width, hex light colour, hex dark colour)');
define('PRODUCT_IMAGE_INFO_GREYSCALE_TITLE' , 'Страница товара-картинка:Greyscale');
define('PRODUCT_IMAGE_INFO_GREYSCALE_DESC' , 'Страница товара-картинка:Greyscale<br /><br />По умолчанию: (32,22,22)<br /><br />basic black n white<br />Используется:<br />(int red, int green, int blue)');
define('PRODUCT_IMAGE_INFO_ELLIPSE_TITLE' , 'Страница товара-картинка:Ellipse');
define('PRODUCT_IMAGE_INFO_ELLIPSE_DESC' , 'Страница товара-картинка:Ellipse<br /><br />По умолчанию: (FFFFFF)<br /><br />ellipse on bg colour<br />Используется:<br />(hex background colour)');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_TITLE' , 'Страница товара-картинка:Round-edges');
define('PRODUCT_IMAGE_INFO_ROUND_EDGES_DESC' , 'Страница товара-картинка:Round-edges<br /><br />По умолчанию: (5,FFFFFF,3)<br /><br />corner trimming<br />Используется:<br />( edge_radius, background colour, anti-alias width)');
define('PRODUCT_IMAGE_INFO_MERGE_TITLE' , 'Страница товара-картинка:Merge');
define('PRODUCT_IMAGE_INFO_MERGE_DESC' , 'Страница товара-картинка:Merge<br /><br />По умолчанию: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Используется:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('PRODUCT_IMAGE_INFO_FRAME_TITLE' , 'Страница товара-картинка:Frame');
define('PRODUCT_IMAGE_INFO_FRAME_DESC' , 'Страница товара-картинка:Frame<br /><br />По умолчанию: (FFFFFF,000000,3,EEEEEE)<br /><br />plain raised border<br />Используется:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_TITLE' , 'Страница товара-картинка:Drop-Shadow');
define('PRODUCT_IMAGE_INFO_DROP_SHADDOW_DESC' , 'Страница товара-картинка:Drop-Shadow<br /><br />По умолчанию: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Используется:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_TITLE' , 'Страница товара-картинка:Motion-Blur');
define('PRODUCT_IMAGE_INFO_MOTION_BLUR_DESC' , 'Страница товара-картинкаs:Motion-Blur<br /><br />По умолчанию: (4,FFFFFF)<br /><br />fading parallel lines<br />Используется:<br />(int number of lines,hex background colour)');

//so this image is the biggest in the shop this

define('PRODUCT_IMAGE_POPUP_BEVEL_TITLE' , 'Страница товара-РOРUP картинка:Bevel');
define('PRODUCT_IMAGE_POPUP_BEVEL_DESC' , 'Страница товара-РOРUP картинка:Bevel<br /><br />По умолчанию: (8,FFCCCC,330000)<br /><br />shaded bevelled edges<br />Используется:<br />(edge width,hex light colour,hex dark colour)');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_TITLE' , 'Страница товара-РOРUP картинка:Greyscale');
define('PRODUCT_IMAGE_POPUP_GREYSCALE_DESC' , 'Страница товара-РOРUP картинка:Greyscale<br /><br />По умолчанию: (32,22,22)<br /><br />basic black n white<br />Используется:<br />(int red,int green,int blue)');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_TITLE' , 'Страница товара-РOРUP картинка:Ellipse');
define('PRODUCT_IMAGE_POPUP_ELLIPSE_DESC' , 'Страница товара-РOРUP картинка:Ellipse<br /><br />По умолчанию: (FFFFFF)<br /><br />ellipse on bg colour<br />Используется:<br />(hex background colour)');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_TITLE' , 'Страница товара-РOРUP картинка:Round-edges');
define('PRODUCT_IMAGE_POPUP_ROUND_EDGES_DESC' , 'Страница товара-РOРUP картинка:Round-edges<br /><br />По умолчанию: (5,FFFFFF,3)<br /><br />corner trimming<br />Используется:<br />(edge_radius,background colour,anti-alias width)');
define('PRODUCT_IMAGE_POPUP_MERGE_TITLE' , 'Страница товара-РOРUP картинка:Merge');
define('PRODUCT_IMAGE_POPUP_MERGE_DESC' , 'Страница товара-РOРUP картинка:Merge<br /><br />По умолчанию: (overlay.gif,10,-50,60,FF0000)<br /><br />overlay merge image<br />Используется:<br />(merge image,x start [neg = from right],y start [neg = from base],opacity,transparent colour on merge image)');
define('PRODUCT_IMAGE_POPUP_FRAME_TITLE' , 'Страница товара-РOРUP картинка:Frame');
define('PRODUCT_IMAGE_POPUP_FRAME_DESC' , 'Страница товара-РOРUP картинка:Frame<br /><br />По умолчанию: <br /><br />plain raised border<br />Используется:<br />(hex light colour,hex dark colour,int width of mid bit,hex frame colour [optional - defaults to half way between light and dark edges])');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_TITLE' , 'Страница товара-РOРUP картинка:Drop-Shadow');
define('PRODUCT_IMAGE_POPUP_DROP_SHADDOW_DESC' , 'Страница товара-РOРUP картинка:Drop-Shadow<br /><br />По умолчанию: (3,333333,FFFFFF)<br /><br />more like a dodgy motion blur [semi buggy]<br />Usage:<br />(shadow width,hex shadow colour,hex background colour)');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_TITLE' , 'Страница товара-РOРUP картинка:Motion-Blur');
define('PRODUCT_IMAGE_POPUP_MOTION_BLUR_DESC' , 'Страница товара-РOРUP картинка:Motion-Blur<br /><br />По умолчанию: (4,FFFFFF)<br /><br />fading parallel lines<br />Используется:<br />(int number of lines,hex background colour)');

define('MO_PICS_TITLE','Кол-во картинок к продукту');
define('MO_PICS_DESC','Если кол-во установленно > 0 (бльше нуля), вы сможете загружать и отображать больше картинок к товару');

define('IMAGE_MANIPULATOR_TITLE','GDlib обработка');
define('IMAGE_MANIPULATOR_DESC','Манипулятор изображений для библиотеки GD2 или GD1');

define('ACCOUNT_GENDER_TITLE' , 'Пол');
define('ACCOUNT_GENDER_DESC' , 'Показывать пол в Клиентской записи');
define('ACCOUNT_DOB_TITLE' , 'Дата рождения');
define('ACCOUNT_DOB_DESC' , 'Показывать дату рождения в Клиентской записи');
define('ACCOUNT_COMPANY_TITLE' , 'Компания');
define('ACCOUNT_COMPANY_DESC' , 'Показывать Компанию в Клиентской записи');
define('ACCOUNT_SUBURB_TITLE' , 'Район (Suburb)');
define('ACCOUNT_SUBURB_DESC' , 'Показывать/запрашивать Район (Suburb) в Клиентской записи');
define('ACCOUNT_STATE_TITLE' , 'Регион (State)');
define('ACCOUNT_STATE_DESC' , 'Показывать/Регион (State) в Клиентской записи');

define('DEFAULT_CURRENCY_TITLE' , 'Валюта по умолчанию');
define('DEFAULT_CURRENCY_DESC' , 'Валюта используемая по умолчанию');
define('DEFAULT_LANGUAGE_TITLE' , 'Язык по умолчанию');
define('DEFAULT_LANGUAGE_DESC' , 'Язык используемый по умолчанию');
define('DEFAULT_ORDERS_STATUS_ID_TITLE' , 'Статус заказа по умолчанию');
define('DEFAULT_ORDERS_STATUS_ID_DESC' , 'Статус нового заказа по умолчанию');

define('SHIPPING_ORIGIN_COUNTRY_TITLE' , 'Страна магазина');
define('SHIPPING_ORIGIN_COUNTRY_DESC' , 'Выберите страну где находится магазин. Используется при доставке.');
define('SHIPPING_ORIGIN_ZIP_TITLE' , 'Почтовый индекс магазина');
define('SHIPPING_ORIGIN_ZIP_DESC' , 'Введите почтовый индекс магазина. Используется при доставке.');
define('SHIPPING_MAX_WEIGHT_TITLE' , 'Максимальный вес доставки');
define('SHIPPING_MAX_WEIGHT_DESC' , 'Почтовые службы имеют ограничение на вес для одиночной посылки. Этот параметр будет общим на все товары. (см. <a href="http://www.russianpost.ru/resp_engine.asp?Path=RU/Home/Tariffs/localmes" target="_blank" title="в новом окне www.russianpost.ru...">Почта России. Внутренние почтовые отправления</a>)');
define('SHIPPING_BOX_WEIGHT_TITLE' , 'Вес упаковки');
define('SHIPPING_BOX_WEIGHT_DESC' , 'Обычный вес от маленькой до средней упаковки?');
define('SHIPPING_BOX_PADDING_TITLE' , 'Процентное увеличение груза');
define('SHIPPING_BOX_PADDING_DESC' , 'Процентное увеличение груза. Для 10% запишите 10');
define('SHOW_SHIPPING_DESC' , 'Показывать линк стоимость доставки на стр. товара');
define('SHOW_SHIPPING_TITLE' , 'Стоимость доставки на стр. товара');
define('SHIPPING_INFOS_DESC' , 'Group ID of shippingcosts content.');
define('SHIPPING_INFOS_TITLE' , 'Group ID');

define('PRODUCT_LIST_FILTER_TITLE' , 'Показывать фильтр Категория/Производитель');
define('PRODUCT_LIST_FILTER_DESC' , 'Показывать в категориях/производителях фильтр по категориям/производителям?<br />1=да; 0=нет');

define('STOCK_CHECK_TITLE' , 'Проверка склада');
define('STOCK_CHECK_DESC' , 'Проверять наличие товара на складе');

define('ATTRIBUTE_STOCK_CHECK_TITLE' , 'Проверка атрибутов на складе');
define('ATTRIBUTE_STOCK_CHECK_DESC' , 'Проверять наличие атрибутов товара на складе');

define('STOCK_LIMITED_TITLE' , 'Вычитать со склада');
define('STOCK_LIMITED_DESC' , 'Вычитать товар со склада');
define('STOCK_ALLOW_CHECKOUT_TITLE' , 'Позволить перерасход');
define('STOCK_ALLOW_CHECKOUT_DESC' , 'Позволить перерасход товара на складе');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_TITLE' , 'Отмечать товары которых нет на складе');
define('STOCK_MARK_PRODUCT_OUT_OF_STOCK_DESC' , 'Здесь нужно ввести, как будут отмечаться товары, которых нет на складе');
define('STOCK_REORDER_LEVEL_TITLE' , 'Кол-во товара перед переучетом');
define('STOCK_REORDER_LEVEL_DESC' , 'Кол-во товара на складе перед переучетом');

define('STORE_PAGE_PARSE_TIME_TITLE' , 'Сохранять время парсинга страниц');
define('STORE_PAGE_PARSE_TIME_DESC' , 'Сохранять время парсинга страниц');
define('STORE_PAGE_PARSE_TIME_LOG_TITLE' , 'Лог-файл');
define('STORE_PAGE_PARSE_TIME_LOG_DESC' , 'Полный (абсолютный) путь до лог-файла');
define('STORE_PARSE_DATE_TIME_FORMAT_TITLE' , 'Формат даты лога');
define('STORE_PARSE_DATE_TIME_FORMAT_DESC' , 'Формат даты');

define('DISPLAY_PAGE_PARSE_TIME_TITLE' , 'Показывать время парсинга страниц');
define('DISPLAY_PAGE_PARSE_TIME_DESC' , 'Показывать время парсинга страниц (опция Сохранять время парсинга должна быть включена).');

define('STORE_DB_TRANSACTIONS_TITLE' , 'Сохранять запросы к базе данных');
define('STORE_DB_TRANSACTIONS_DESC' , 'Сохранять запросы к базе данныз в логе парсинга страниц (только для PHP4)');

define('USE_CACHE_TITLE' , 'Использовать Кэш');
define('USE_CACHE_DESC' , 'Использовать кэширование страниц. Если сайт изменяется часто, рекомендуется установить ниже минимальные значения.');

define('DB_CACHE_TITLE','Кэширование запросов к БД');
define('DB_CACHE_DESC','Если установить true, Магазин будет кэшировать запросы SELECT, что увеличит скорость обращения к БД');

define('DIR_FS_CACHE_TITLE' , 'Директоря Кэш');
define('DIR_FS_CACHE_DESC' , 'Каталог где будут сохраняться кэш файлы. Путь к каталогу начинается с '. DIR_FS_DOCUMENT_ROOT);

define('ACCOUNT_OPTIONS_TITLE','Вид регистрации');
define('ACCOUNT_OPTIONS_DESC','Как будут регистрироваться покупатели?<br />Вы можете выбрать между регистрацией Клиента с сохранением данных в БД (<b>account</b>) либо одноразовый Гостевой заказ (<b>guest</b>) без сохранения данных (данные о клиенте сохранятся, но клиент не будет информирован).<br />Можно выбрать оба (<b>both</b>) способа.');

define('EMAIL_TRANSPORT_TITLE' , 'Методы E-Mail доставки');
define('EMAIL_TRANSPORT_DESC' , 'Через локаль sendmail. Отправка почты через Сервера на Windows и MacOS отпрвляются через SMTP.');

define('EMAIL_LINEFEED_TITLE' , 'Перевод строки в письмах (E-Mail)');
define('EMAIL_LINEFEED_DESC' , 'Определите разделители для заголовков писем (LF это для Unix, CRLF для Windows).');
define('EMAIL_USE_HTML_TITLE' , 'Использовать HTML при отправке почты');
define('EMAIL_USE_HTML_DESC' , 'Послать e-mail в HTML формате');
define('ENTRY_EMAIL_ADDRESS_CHECK_TITLE' , 'Проверять E-Mail адреса через DNS');
define('ENTRY_EMAIL_ADDRESS_CHECK_DESC' , 'Проверять E-Mail адреса через DNS');
define('SEND_EMAILS_TITLE' , 'Посылать E-Mail');
define('SEND_EMAILS_DESC' , 'Отправлять письма');
define('SENDMAIL_PATH_TITLE' , 'Путь к sendmail');
define('SENDMAIL_PATH_DESC' , 'Если вы используете метод sendmail, то пропишите правильный путь (по умолчанию: /usr/bin/sendmail):');
define('SMTP_MAIN_SERVER_TITLE' , 'Адрес SMTP сервера');
define('SMTP_MAIN_SERVER_DESC' , '');
define('SMTP_BACKUP_SERVER_TITLE' , 'Адрес SMTP Backup Serverа');
define('SMTP_BACKUP_SERVER_DESC' , '');
define('SMTP_USERNAME_TITLE' , 'SMTP Username');
define('SMTP_USERNAME_DESC' , '');
define('SMTP_PASSWORD_TITLE' , 'SMTP Password');
define('SMTP_PASSWORD_DESC' , '');
define('SMTP_AUTH_TITLE' , 'SMTP AUTH');
define('SMTP_AUTH_DESC' , 'Нужна ли аутентификация на SMTP?');
define('SMTP_PORT_TITLE' , 'SMTP порт');
define('SMTP_PORT_DESC' , '(по умолчанию: 25)');

//Constants for contact_us
define('CONTACT_US_EMAIL_ADDRESS_TITLE' , 'Контакты (Contact Us) - E-Mail адрес');
define('CONTACT_US_EMAIL_ADDRESS_DESC' , 'Пожалуйста, введите E-Mail адрес, на который будут посылаться письма из магазина при отправке с сайта, через стандартную форму Contact Us в ваш офис. <p>Это поле необходимо заполнить!');
define('CONTACT_US_NAME_TITLE' , 'Контакты (Contact Us) - Имя получателя');
define('CONTACT_US_NAME_DESC' , 'Пожалуйста, введите Имя (поле: Кому) на которое будут посылаться письма из магазина при отправке с сайта, через стандартную форму Contact Us. <p>Можно написать название Магазина или, например Контактное лицо (ФИО). В почтовой программе поле Кому будет выглядеть так: <b>Name of Shop (info@your_site.com)</b> <p>Это поле можно оставить пустым.');
define('CONTACT_US_FORWARDING_STRING_TITLE' , 'Контакты - адреса переадресации (через запятую)');
define('CONTACT_US_FORWARDING_STRING_DESC' , 'Введите еmail адреса (поле: Скрытая копия) разделенные запятой на которые также будут отправляться письма из магазина при отправке с сайта, через стандартную форму Contact Us. <p>Это поле можно оставить пустым.');
define('CONTACT_US_REPLY_ADDRESS_TITLE' , 'Контакты (Contact Us) - Адрес для ответов');
define('CONTACT_US_REPLY_ADDRESS_DESC' , 'Пожалуйста, введите E-Mail адрес, на который клиенты будут отвечать. В почтовой программе это поле <b>Обратный адрес</b>. <p>Это поле не рекомендуется заполнять.');
define('CONTACT_US_REPLY_ADDRESS_NAME_TITLE' , 'Контакты (Contact Us) - Имя отвечающего');
define('CONTACT_US_REPLY_ADDRESS_NAME_DESC' , 'Имя в обратном адресе. Можно указать название Магазина. <p>Это поле ненадо заполнять если не заполнено поле Адрес для ответов.');
define('CONTACT_US_EMAIL_SUBJECT_TITLE' , 'Контакты (Contact Us) - Тема письма');
define('CONTACT_US_EMAIL_SUBJECT_DESC' , 'Введите тему которая будет в письмах при отправке с сайта, через стандартную форму Contact Us в ваш офис. <p>Это поле рекомендуется заполнить.');

//Constants for support system
define('EMAIL_SUPPORT_ADDRESS_TITLE' , 'Служба поддержки - E-Mail адрес');
define('EMAIL_SUPPORT_ADDRESS_DESC' , 'Введите email адрес для писем в <b>Службу поддержки</b> (проблемы при создании счетов, потеря пароля).');
define('EMAIL_SUPPORT_NAME_TITLE' , 'Служба поддержки - Имя получателя');
define('EMAIL_SUPPORT_NAME_DESC' , 'Введите название  <b>Службы поддержки</b> (проблемы при создании счетов , потеря пароля).');
define('EMAIL_SUPPORT_FORWARDING_STRING_TITLE' , 'Служба поддержки - адреса переадресации (через запятую)');
define('EMAIL_SUPPORT_FORWARDING_STRING_DESC' , 'Введите еmail адреса (поле: Скрытая копия) разделенные запятой на которые также будут отправляться письма в <b>Службу поддержки</b>.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_TITLE' , 'Служба поддержки - Адрес для ответов');
define('EMAIL_SUPPORT_REPLY_ADDRESS_DESC' , 'Please enter an eMail adress for replies of your customers.');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_TITLE' , 'Служба поддержки - ответ по дополнительному адресу, имя');
define('EMAIL_SUPPORT_REPLY_ADDRESS_NAME_DESC' , 'Please enter a sender name for the eMail adress for replies of your customers.');
define('EMAIL_SUPPORT_SUBJECT_TITLE' , 'Служба поддержки - Тема письма');
define('EMAIL_SUPPORT_SUBJECT_DESC' , 'Введите тему для писем в <b>Службу поддержки</b> из магазина.');

//Constants for Billing system
define('EMAIL_BILLING_ADDRESS_TITLE' , 'Billing Служба обработки счетов - E-Mail адрес');
define('EMAIL_BILLING_ADDRESS_DESC' , 'Введите email адрес для <b>Службы обработки счетов</b> (подтвержение заказа, изменение статуса,..).');
define('EMAIL_BILLING_NAME_TITLE' , 'Billing Служба обработки счетов - Имя получателя');
define('EMAIL_BILLING_NAME_DESC' , 'Введите название  <b>Службы обработки счетов</b> (подтверждение заказа, изменение статуса...).');
define('EMAIL_BILLING_FORWARDING_STRING_TITLE' , 'Billing Служба обработки счетов - адрес на кот. посыл. копия письма с заказом');
define('EMAIL_BILLING_FORWARDING_STRING_DESC' , 'Введите дополнительные адреса для <b>Службы обработки счетов</b> (подтвержение заказа, изменение статуса,..) через запятую<p>У меня это адрес, на который посылается копия заказа, т.е. заказ получает Клиент и магазин. Впишите email вашего мазина.');
define('EMAIL_BILLING_REPLY_ADDRESS_TITLE' , 'Billing Служба обработки счетов - ответ по дополнительному адресу');
define('EMAIL_BILLING_REPLY_ADDRESS_DESC' , 'Введите дополнительный  email адрес получающий ответы для клиентов');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_TITLE' , 'Billing Служба обработки счетов - ответы по дополнительным адресам, имя');
define('EMAIL_BILLING_REPLY_ADDRESS_NAME_DESC' , 'Введите имя для дополнительного адреса, получающего ответы для клиентов.');
define('EMAIL_BILLING_SUBJECT_TITLE' , 'Billing Служба обработки счетов - Тема письма');
define('EMAIL_BILLING_SUBJECT_DESC' , 'Введите Тему для письма в <b>Службу обработки счетов</b>');
define('EMAIL_BILLING_SUBJECT_ORDER_TITLE','Billing Служба обработки счетов - тема в заголовке заказа');
define('EMAIL_BILLING_SUBJECT_ORDER_DESC','Введите тему в заголовке для письма в <b>Службу обработки счетов</b> генерируемое из магазина. (например <b>наш заказ {$nr},{$date}</b>) Примечание: Вы можете использовать, {$nr},{$date},{$firstname},{$lastname}');


define('DOWNLOAD_ENABLED_TITLE' , 'Скачивание разрешено');
define('DOWNLOAD_ENABLED_DESC' , 'Разрешить товарам функцию скачивания.');
define('DOWNLOAD_BY_REDIRECT_TITLE' , 'Загрузка через редирект');
define('DOWNLOAD_BY_REDIRECT_DESC' , 'Использовать редирект для скачивания. Не работает в не-Unix системах.');
define('DOWNLOAD_MAX_DAYS_TITLE' , 'Истечение срока ссылки для скачивания (дни)');
define('DOWNLOAD_MAX_DAYS_DESC' , 'Установите кол/во дней разрешенных для скачивания. 0 - безлимит.');
define('DOWNLOAD_MAX_COUNT_TITLE' , 'Максимальное кол/во скачиваний');
define('DOWNLOAD_MAX_COUNT_DESC' , 'Установите максимальное кол/во скачиваний. 0 - безлимит');

define('GZIP_COMPRESSION_TITLE' , 'Разрешить GZip компрессию');
define('GZIP_COMPRESSION_DESC' , 'Разрешить HTTP GZip компрессию.');
define('GZIP_LEVEL_TITLE' , 'Уровень компресси');
define('GZIP_LEVEL_DESC' , 'Уровни бывают от 0 до 9 (0 = минимум, 9 = максимум).');

define('SESSION_WRITE_DIRECTORY_TITLE' , 'Директория сессий');
define('SESSION_WRITE_DIRECTORY_DESC' , 'Если сессии хранятся в файлах то укажите путь к этой директории. Напр. <b>tmp_sess</b>');
define('SESSION_FORCE_COOKIE_USE_TITLE' , 'Принудительное Cookie использование');
define('SESSION_FORCE_COOKIE_USE_DESC' , 'Принудительное использование cookies не стартует сессии. Если клиент без кук, то купить не сможет. Включайте только если сайт без корзины.');
define('SESSION_CHECK_SSL_SESSION_ID_TITLE' , 'Проверка SSL сессии ID');
define('SESSION_CHECK_SSL_SESSION_ID_DESC' , 'Проверять SSL_SESSION_ID при каждом защищенном запросе страницы HTTPS.');
define('SESSION_CHECK_USER_AGENT_TITLE' , 'Проверка юзер агента в сеансе');
define('SESSION_CHECK_USER_AGENT_DESC' , 'Проверять клиентский браузер при каждом запросе страницы. Усиленная идентификация пользователя, на случай если злоумышленик перехватит сессию будет проверяться и юзер-агент.');
define('SESSION_CHECK_IP_ADDRESS_TITLE' , 'Проверка IP адреса в сеансе');
define('SESSION_CHECK_IP_ADDRESS_DESC' , 'Проверять клиентский IP адрес при каждом запросе страницы. Усиленная идентификация пользователя, на случай если злоумышленик перехватит сессию будет проверяться и IP-адрес клиента.');
define('SESSION_RECREATE_TITLE' , 'Воссоздавать сессию');
define('SESSION_RECREATE_DESC' , 'Воссоздавать сессию при входе клиента в магазин либо при регистрации (только для PHP >=4.1).');

define('DISPLAY_CONDITIONS_ON_CHECKOUT_TITLE' , 'Показывать Соглашения с условиями при оформлении заказа?');
define('DISPLAY_CONDITIONS_ON_CHECKOUT_DESC' , 'При оформлении заказа, клиенту будет показано Соглашения с условиями, которое необходимо будет подтвердить, иначе он не сможет сделать заказ.');

define('META_MIN_KEYWORD_LENGTH_TITLE' , 'Минимальная meta-keyword длина');
define('META_MIN_KEYWORD_LENGTH_DESC' , 'Минимальная длина одного слова (генерируемого из products description)');
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
define('MODULE_PAYMENT_INSTALLED_DESC' , 'Список модулей оплаты по именам файлов разделенных точкой с запятой. Это обновляется автоматически. Нет необходимости редактировать. (Пример: cc.php;cod.php;paypal.php)');
define('MODULE_ORDER_TOTAL_INSTALLED_TITLE' , 'Установленные модули');
define('MODULE_ORDER_TOTAL_INSTALLED_DESC' , 'Список модулей order_total по именам файлов разделенных точкой с запятой. Это обновляется автоматически. Нет необходимости редактировать. (Пример: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)');
define('MODULE_SHIPPING_INSTALLED_TITLE' , 'Установленные модули доставки');
define('MODULE_SHIPPING_INSTALLED_DESC' , 'Список модулей(Пример: ups.php;flat.php;item.php)');

define('CACHE_LIFETIME_TITLE','Время жизни HTML Кэша');
define('CACHE_LIFETIME_DESC','Жизнь HTML Кеша в секундах. Т.е. если вы напр. добавили новость, то вы увидите её на сайте лишь через время указанное выше в секундах.');
define('CACHE_CHECK_TITLE','Проверять изменения Кэша');
define('CACHE_CHECK_DESC','Если true, тогда проверяется были ли изменены заголовки If-Modified-Since headers вместе с основным наполнением страницы, и соответсвующие HTTP заголовки посылаются в Кеш. В этом случае клиентской машине отдается не весь контент страницы с заголовками, а только основная часть, что сокращает время загрузки.');

define('DB_CACHE_EXPIRE_TITLE','Жизнь БД кэша');
define('DB_CACHE_EXPIRE_DESC','Время жизни БД кеша в секундах.');

define('PRODUCT_REVIEWS_VIEW_TITLE','Отзывы на странице описания товара');
define('PRODUCT_REVIEWS_VIEW_DESC','Количество отзывов на странице описания товара');

define('DELETE_GUEST_ACCOUNT_TITLE','Уничтожать гостевой аккаунт');
define('DELETE_GUEST_ACCOUNT_DESC','Уничтожать аккаунт гостя после заказа? (дата заказа будет сохранена)');

define('USE_WYSIWYG_TITLE','WYSIWYG редактор');
define('USE_WYSIWYG_DESC','Включить WYSIWYG редактор для CMS и описания товаров. true=вкл.; false=выкл.');

define('PRICE_IS_BRUTTO_TITLE','Брутто цены в Админе');
define('PRICE_IS_BRUTTO_DESC','Использовать цены с налогом в Админе');

define('PRICE_PRECISION_TITLE','Точность цен');
define('PRICE_PRECISION_DESC','Точность цен до X знаков после разделителя (точка | запятая)');
define('CHECK_CLIENT_AGENT_TITLE','Не показывать сессии в адресе паукам');
define('CHECK_CLIENT_AGENT_DESC','Не показывать сессии известным поисковым паукам. Список пауков в /inc/xtc_check_agent.inc.php и в /includes/spiders.txt');
define('SHOW_IP_LOG_TITLE','IP-Log при оформлении заказа?');
define('SHOW_IP_LOG_DESC','Показать текст &quot;Ваш IP-адрес запомнен&quot;, при офрмлении заказа?');

define('ACTIVATE_GIFT_SYSTEM_TITLE','Активировать систему Купонов (GIFT_SYSTEM)');
define('ACTIVATE_GIFT_SYSTEM_DESC','Активировать систему Подарочных купонов / сертификатов?');

define('ACTIVATE_SHIPPING_STATUS_TITLE','Статус доставки');
define('ACTIVATE_SHIPPING_STATUS_DESC','Показывать статус доставки? После активации в карточке товара появится пункт <b>Срок доставки</b>');

define('SECURITY_CODE_LENGTH_TITLE','Длина секретного кода');
define('SECURITY_CODE_LENGTH_DESC','Длина секретного кода (в подарочном ваучере)');

define('IMAGE_QUALITY_TITLE','Качество нарезаемой картинки');
define('IMAGE_QUALITY_DESC','(0 = максимальное сжатие, 100 = лучшее качество, но и размер картинки будет больше)');

define('GROUP_CHECK_TITLE','Проверка статуса покупателя для категорий');
define('GROUP_CHECK_DESC','Разрешает только зарегистрированым покупателям и имеющим доступ к конкретным категориям просматривать их (после активации появятся товары и категории');

define('ACTIVATE_REVERSE_CROSS_SELLING_TITLE','Обратный Кросс-селинг');
define('ACTIVATE_REVERSE_CROSS_SELLING_DESC','Активировать систему обратных перекрестных ссылок между товарами?');

define('ACTIVATE_NAVIGATOR_TITLE','Включить навигацию по товару?');
define('ACTIVATE_NAVIGATOR_DESC','Включить/выключить навигацию по товару на странице товара, (при большом количестве товара в системе отключение позволит быстрее выводить страницу товара)');

define('QUICKLINK_ACTIVATED_TITLE','Включить функцию множественного копирования?');
define('QUICKLINK_ACTIVATED_DESC','Функция множественного копирования в админе.');

define('DOWNLOAD_UNALLOWED_PAYMENT_TITLE', 'Не допустимые Модули оплаты для Загрузки');
define('DOWNLOAD_UNALLOWED_PAYMENT_DESC', 'Не допустимые Модули оплаты для скачивания. Список разделенный запятыми, напр. {banktransfer,cod,invoice,moneyorder}');
define('DOWNLOAD_MIN_ORDERS_STATUS_TITLE', 'Минимальный Статус заказа');
define('DOWNLOAD_MIN_ORDERS_STATUS_DESC', 'Минимальный Статус заказа, чтобы позволить скачать.');

// Vat Check
define('STORE_OWNER_VAT_ID_TITLE' , 'VAT ID of Shop Owner');
define('STORE_OWNER_VAT_ID_DESC' , 'The VAT ID of the Shop Owner');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_TITLE' , 'Customer-group - correct VAT ID (Foreign country)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_DESC' , 'Customers-group for customers with correct VAT ID, Shop country != customers country');
define('ACCOUNT_COMPANY_VAT_CHECK_TITLE' , 'Validate VAT ID');
define('ACCOUNT_COMPANY_VAT_CHECK_DESC' , 'Validate VAT ID (check correct syntax)');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_TITLE' , 'Validate VAT ID Live');
define('ACCOUNT_COMPANY_VAT_LIVE_CHECK_DESC' , 'Validate VAT ID live (if no syntax check available for country), live check will use validation gateway of germans "Bundesamt fпїЅr Finanzen"');
define('ACCOUNT_COMPANY_VAT_GROUP_TITLE' , 'automatic pruning ?');
define('ACCOUNT_COMPANY_VAT_GROUP_DESC' , 'Set to true, the customer-group will be changed automatically if a correct VAT ID is used.');
define('ACCOUNT_VAT_BLOCK_ERROR_TITLE' , 'Allow wrong UST ID?');
define('ACCOUNT_VAT_BLOCK_ERROR_DESC' , 'Set to true, only validated VAT IDs are acceptet.');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_TITLE','Customer-group - correct VAT ID (Shop country)');
define('DEFAULT_CUSTOMERS_VAT_STATUS_ID_LOCAL_DESC','Customers-group for customers with correct VAT ID, Shop country = customers country');
// Google Conversion
define('GOOGLE_CONVERSION_TITLE','Google конверсионная трассировка');
define('GOOGLE_CONVERSION_DESC','Отслеживать конверсионные ключевые слова в заказах');
define('GOOGLE_CONVERSION_ID_TITLE','ID преобразования');
define('GOOGLE_CONVERSION_ID_DESC','Ваш Google конверсионный ID');
define('GOOGLE_LANG_TITLE','Google язык');
define('GOOGLE_LANG_DESC','ISO код используемоего языка (ru, en, fr, de...)');

// Afterbuy
define('AFTERBUY_ACTIVATED_TITLE','Activ');
define('AFTERBUY_ACTIVATED_DESC','Activate afterbuy module');
define('AFTERBUY_PARTNERID_TITLE','Partner ID');
define('AFTERBUY_PARTNERID_DESC','Your Afterbuy Partner ID');
define('AFTERBUY_PARTNERPASS_TITLE','Partner Password');
define('AFTERBUY_PARTNERPASS_DESC','Your Partner Password for Afterbuy XML Module');
define('AFTERBUY_USERID_TITLE','User ID');
define('AFTERBUY_USERID_DESC','Your Afterbuy User ID');
define('AFTERBUY_ORDERSTATUS_TITLE','Orderstatus');
define('AFTERBUY_ORDERSTATUS_DESC','Orderstatus for exported orders');
define('AFTERBUY_URL','You will find a detailed Afterbuy info here: <a href="http://www.xt-commerce.com/modules/wfsection/dossier-65.html" target="new">http://www.xt-commerce.com/modules/wfsection/dossier-65.html</a>');

// Search-Options
define('SEARCH_IN_DESC_TITLE','Поиск в описании товаров');
define('SEARCH_IN_DESC_DESC','Разрешить поиск в описании товаров');
define('SEARCH_IN_ATTR_TITLE','Поиск а атрибутах товаров');
define('SEARCH_IN_ATTR_DESC','Разрешить поиск в атрибутах товаров');

?>