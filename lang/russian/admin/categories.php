<?php
/* --------------------------------------------------------------
   $Id: categories.php 1249 2009-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.22 2002/08/17); www.oscommerce.com
   (c) 2003	 nextcommerce (categories.php,v 1.10 2003/08/14); www.nextcommerce.org
   (c) 2004	 xt:Commerce (categories.php,v 1.10 2003/08/14); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/
 
define('TEXT_EDIT_STATUS', 'Статус');
define('HEADING_TITLE', 'Категории / Товары');
define('HEADING_TITLE_SEARCH', 'Поиск:');
define('HEADING_TITLE_GOTO', 'Перейти в:');

define('TABLE_HEADING_ID', 'ID код');
define('TABLE_HEADING_CATEGORIES_PRODUCTS', 'Категории / Товары');
define('TABLE_HEADING_ACTION', 'Действие');
define('TABLE_HEADING_STATUS', 'Статус');
define('TABLE_HEADING_STARTPAGE', 'На главной');
define('TABLE_HEADING_STOCK','Склад');
define('TABLE_HEADING_SORT','Порядок');
define('TABLE_HEADING_EDIT','');

define('TEXT_ACTIVE_ELEMENT','Активный элемент');
define('TEXT_INFORMATIONS','Информация');
define('TEXT_MARKED_ELEMENTS','Отмеченные элементы');
define('TEXT_INSERT_ELEMENT','Новый элемент');

define('TEXT_WARN_MAIN','0');
define('TEXT_NEW_PRODUCT', 'Новый товар в &quot;%s&quot;');
define('TEXT_CATEGORIES', 'Категории:');
define('TEXT_PRODUCTS', 'Товаров на странице:');
define('TEXT_PRODUCTS_PRICE_INFO', 'Цены:');
define('TEXT_PRODUCTS_TAX_CLASS', 'Класс налогов:');
define('TEXT_PRODUCTS_AVERAGE_RATING', 'Средний рейтинг:');
define('TEXT_PRODUCTS_QUANTITY_INFO', 'Количество:');
define('TEXT_PRODUCTS_DISCOUNT_ALLOWED_INFO', 'Максимальная скидка');
define('TEXT_DATE_ADDED', 'Добавлено:');
define('TEXT_DATE_AVAILABLE', 'Доступно:');
define('TEXT_LAST_MODIFIED', 'Изменено:');
define('TEXT_IMAGE_NONEXISTENT', 'Картинка отсутствует');
define('TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 'Пожалуйста, добавьте категорию или товар <br />&nbsp;<br /><b>%s</b>');
define('TEXT_PRODUCT_MORE_INFORMATION', 'Для получения дополнительной информации, пожалуйста, посетите эту <a href="http://%s" target="blank"><u>страницу</u></a>.');
define('TEXT_PRODUCT_DATE_ADDED', 'Этот товар добавлен в наш каталог %s.');
define('TEXT_PRODUCT_DATE_AVAILABLE', 'Этот товар появится в продаже %s.');
define('TEXT_CHOOSE_INFO_TEMPLATE', 'Шаблон страницы товара:');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE', 'Шаблон атрибутов товара:');
define('TEXT_SELECT', 'Выберите:');

define('TEXT_EDIT_INTRO', 'Пожалуйста, внесите необходимые изменения');
define('TEXT_EDIT_CATEGORIES_ID', 'ID категории:');
define('TEXT_EDIT_CATEGORIES_NAME', 'Название категории:');
define('TEXT_EDIT_CATEGORIES_HEADING_TITLE', 'Заголовок категории:');
define('TEXT_EDIT_CATEGORIES_DESCRIPTION', 'Описание категории:');
define('TEXT_EDIT_CATEGORIES_IMAGE', 'Картинка категории:');

define('TEXT_EDIT_SORT_ORDER', 'Порядок сортировки:');

define('TEXT_INFO_COPY_TO_INTRO', 'Пожалуйста, выберите новую категорию, в которую Вы желаете скопировать этот товар');
define('TEXT_INFO_CURRENT_CATEGORIES', 'Текущая категория:');

define('TEXT_INFO_HEADING_NEW_CATEGORY', 'Новая категория');
define('TEXT_INFO_HEADING_EDIT_CATEGORY', 'Редактировать категорию');
define('TEXT_INFO_HEADING_DELETE_CATEGORY', 'Удалить категорию');
define('TEXT_INFO_HEADING_MOVE_CATEGORY', 'Перенести категорию');
define('TEXT_INFO_HEADING_DELETE_PRODUCT', 'Удалить товар');
define('TEXT_INFO_HEADING_MOVE_PRODUCT', 'Переместить товар');
define('TEXT_INFO_HEADING_COPY_TO', 'Копировать в');
define('TEXT_INFO_HEADING_MOVE_ELEMENTS', 'Переместить элементы');
define('TEXT_INFO_HEADING_DELETE_ELEMENTS', 'Удалить элементы');

define('TEXT_DELETE_CATEGORY_INTRO', 'Вы согласны удалить эту категорию?');
define('TEXT_DELETE_PRODUCT_INTRO', 'Отметьте Категории из которых надо удалить данный товар. Вы согласны навсегда удалить эти товары?');

define('TEXT_DELETE_WARNING_CHILDS', '<b>ВНИМАНИЕ:</b> С данной категорий связано %s подкатегорий!');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>ВНИМАНИЕ:</b> С данной категорий связано %s товаров!');

define('TEXT_MOVE_WARNING_CHILDS', '<b>Информация:</b> С данной категорий связано %s подкатегорий!');
define('TEXT_MOVE_WARNING_PRODUCTS', '<b>Информация:</b> С данной категорий связано %s товаров!');

define('TEXT_MOVE_PRODUCTS_INTRO', 'Выберите категорию, в которую Вы хотите переместить <b>%s</b>');
define('TEXT_MOVE_CATEGORIES_INTRO', 'Выберите категорию, в которую Вы хотите переместить <b>%s</b>');
define('TEXT_MOVE', 'Перенести <b>%s</b> в:');
define('TEXT_MOVE_ALL', 'Переместить всё в:');

define('TEXT_NEW_CATEGORY_INTRO', 'Введите всю необходимую информацию для новой категории.');
define('TEXT_CATEGORIES_NAME', 'Название категории:');
define('TEXT_CATEGORIES_IMAGE', 'Картинка категории:');

define('TEXT_META_TITLE', 'Meta Title:');
define('TEXT_META_DESCRIPTION', 'Meta Description:');
define('TEXT_META_KEYWORDS', 'Meta Keywords:');

define('TEXT_SORT_ORDER', 'Порядок сортировки:');

define('TEXT_PRODUCTS_STATUS', 'Статус:');
define('TEXT_PRODUCTS_STARTPAGE', 'На главной странице:');
define('TEXT_PRODUCTS_STARTPAGE_YES', 'Да');
define('TEXT_PRODUCTS_STARTPAGE_NO', 'Нет');
define('TEXT_PRODUCTS_STARTPAGE_SORT', 'Сортировка (на главной):');
define('TEXT_PRODUCTS_DATE_AVAILABLE', 'Дата доступности:');
define('TEXT_PRODUCT_AVAILABLE', 'Активен');
define('TEXT_PRODUCT_NOT_AVAILABLE', 'Неактивен');
define('TEXT_PRODUCTS_MANUFACTURER', 'Производитель:');
define('TEXT_PRODUCTS_LABEL', 'Ярлык товара:');
define('TEXT_PRODUCTS_NAME', 'Название товара:');
define('TEXT_PRODUCTS_DESCRIPTION', 'Описание товара:');
define('TEXT_PRODUCTS_QUANTITY', 'Количество товара:');
define('TEXT_PRODUCTS_MODEL', 'Артикул товара:');
define('TEXT_PRODUCTS_IMAGE', 'Картинка товара');
define('TEXT_PRODUCTS_URL', 'URL товара:');
define('TEXT_PRODUCTS_URL_WITHOUT_HTTP', '(без http://)');
define('TEXT_PRODUCTS_PRICE', 'Цена товара:');
define('TEXT_PRODUCTS_WEIGHT', 'Вес товара:');
define('TEXT_PRODUCTS_LENGTH', 'Длина:');
define('TEXT_PRODUCTS_WIDTH', 'Ширина:');
define('TEXT_PRODUCTS_HEIGHT', 'Высота:');
define('TEXT_PRODUCTS_VOLUME', 'Объём:');
define('TEXT_PRODUCTS_EAN','Штрих-код:');
define('TEXT_PRODUCT_LINKED_TO','Ссылается на:');

define('TEXT_DELETE', 'Удалить');

define('EMPTY_CATEGORY', 'Пустая категория');

define('TEXT_HOW_TO_COPY', 'Способ копирования:');
define('TEXT_COPY_AS_LINK', 'Ссылка на товар');
define('TEXT_COPY_AS_DUPLICATE', 'Копия товара');

define('ERROR_CANNOT_LINK_TO_SAME_CATEGORY', 'Ошибка: Вы не можете создавать ссылку на товар в той же категории, что и сам товар.');
define('ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE', 'Ошибка: Директория картинок закрыта на запись: ' . DIR_FS_CATALOG_IMAGES);
define('ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST', 'Ошибка: Директория картинок отсутствует: ' . DIR_FS_CATALOG_IMAGES);

define('TEXT_PRODUCTS_DISCOUNT_ALLOWED','Максимально возможная скидка:');
define('HEADING_PRICES_OPTIONS','<b>Цены</b>');
define('HEADING_PRODUCT_IMAGES','<b>Картинки товара</b>');
define('TEXT_PRODUCTS_WEIGHT_INFO','<small>(кг.)</small>');
define('TEXT_PRODUCTS_SHORT_DESCRIPTION','Краткое описание:');
define('TEXT_PRODUCTS_KEYWORDS', 'Тэги:');
define('TXT_STK','Количество: ');
define('TXT_PRICE','Цена:');
define('TXT_NETTO','Цена с налогом: ');
define('TEXT_NETTO','Налог: ');
define('TXT_STAFFELPREIS','Цена от количества');

define('HEADING_PRODUCTS_MEDIA','<b>Картинки товара</b>');
define('TABLE_HEADING_PRICE','Цена');

define('TEXT_CHOOSE_INFO_TEMPLATE','Шаблон информации о товаре');
define('TEXT_SELECT','--Выберите--');
define('TEXT_CHOOSE_OPTIONS_TEMPLATE','Шаблон атрибутов товара');
define('SAVE_ENTRY','Сохранить ?');

define('TEXT_FSK18','товар до 18 лет:');
define('TEXT_CHOOSE_INFO_TEMPLATE_CATEGORIE','Шаблон для списка категорий');
define('TEXT_CHOOSE_INFO_TEMPLATE_LISTING','Шаблон для списка товаров');
define('TEXT_PRODUCTS_SORT','Порядок:');
define('TEXT_EDIT_PRODUCT_SORT_ORDER','Сортировка товара');
define('TXT_PRICES','Цена');
define('TXT_NAME','Название товара');
define('TXT_ORDERED','Заказанное количество товара');
define('TXT_SORT','Порядок');
define('TXT_WEIGHT','Вес');
define('TXT_QTY','Количество на складе');

define('TEXT_MULTICOPY','Массовое копирование');
define('TEXT_MULTICOPY_DESC','Копировать элементы в следующие категории (Если выбрано, настройка Один будет игнорирована.)');
define('TEXT_SINGLECOPY','Один');
define('TEXT_SINGLECOPY_DESC','Копировать элементы в следующую категорию');
define('TEXT_SINGLECOPY_CATEGORY','Категория:');

define('TEXT_PRODUCTS_VPE','Единица: ');
define('TEXT_PRODUCTS_VPE_VISIBLE','Показывать единицу упаковки: ');
define('TEXT_PRODUCTS_VPE_VALUE',' Значение: ');

define('CROSS_SELLING','Сопутствующие товары');
define('CROSS_SELLING_SEARCH','Поиск товара:');
define('BUTTON_EDIT_CROSS_SELLING','Сопутствующие');
define('HEADING_DEL','удалить');
define('HEADING_SORTING','сортировать');
define('HEADING_MODEL','код');
define('HEADING_NAME','статья');
define('HEADING_CATEGORY','категория');
define('HEADING_ADD','Добавить?');
define('HEADING_GROUP','Группа');

// Сборка VaM

define('IMAGE_ICON_STATUS_GREEN', 'Активна');
define('IMAGE_ICON_STATUS_GREEN_STOCK', 'единиц на складе');
define('IMAGE_ICON_STATUS_GREEN_LIGHT', 'Активизировать');
define('IMAGE_ICON_STATUS_RED', 'Неактивна');
define('IMAGE_ICON_STATUS_RED_LIGHT', 'Сделать неактивной');
define('TABLE_HEADING_MAX_DISCOUNT', 'Максимально возможная скидка');

define('TEXT_PRODUCTS_IMAGE_UPLOAD_DIRECTORY', 'Директория загрузки:');
define('TEXT_PRODUCTS_IMAGE_GET_FILE', 'Использовать загруженный файл:');
define('TEXT_STANDART_IMAGE', 'Картинка');
define('TEXT_SELECT_DIRECTORY', '-- Выберите поддиректорию --');
define('TEXT_SELECT_IMAGE', '-- Выберите файл --');

define('TABLE_HEADING_XML', 'XML');
define('TABLE_HEADING_MODEL', 'Артикул');
define('TEXT_PRODUCTS_TO_XML', 'Яндекс-маркет:');
define('TEXT_PRODUCT_AVAILABLE_TO_XML', 'Включить');
define('TEXT_PRODUCT_NOT_AVAILABLE_TO_XML', 'Не включать');

define('TEXT_EDIT','[редактировать]');
define('TEXT_PRODUCTS_DATA','Дополнительно');
define('TEXT_TAB_CATEGORIES_IMAGE', 'Картинка категории');

define('ENTRY_CUSTOMERS_ACCESS','Доступ');

define('TEXT_PAGES', 'Страницы: ');
define('TEXT_TOTAL_PRODUCTS', 'Всего товаров: ');

define('TEXT_YANDEX_MARKET','<br />Настройки для яндекс-маркет:<br />');
define('TEXT_YANDEX_MARKET_BID','Основная ставка (bid):');
define('TEXT_YANDEX_MARKET_CBID','Ставка для карточек (cbid):');

// Categories/Products URL begin
define('TEXT_EDIT_CATEGORY_URL', 'SEO URL категории:');
define('TEXT_PRODUCTS_PAGE_URL', 'SEO URL товара:');
// Categories/Products URL end

define('TEXT_PRODUCTS_QUANTITY_MIN', 'Мин. количество для заказа:');
define('TEXT_PRODUCTS_QUANTITY_MAX', 'Макс. количество для заказа:');

// Start Products Specifications
  define ('TEXT_TAB_DESCRIPTION', 'Описание');
  define ('TEXT_TAB_SPECIFICATIONS', 'Спецификации');
  define ('TEXT_TAB_1', 'Руководства');
  define ('TEXT_TAB_2', 'Видео');
  define ('TEXT_TAB_3', 'Аксессуары');
  define ('TEXT_TAB_4', 'Отзывы');
  define ('TEXT_TAB_5', 'Гарантия');
  define ('TEXT_TAB_6', 'Доставка');
  define ('TEXT_TITLE_1', 'Руководства');
  define ('TEXT_TITLE_2', 'Видео');
  define ('TEXT_TITLE_3', 'Аксессуары');
  define ('TEXT_TITLE_4', 'Отзывы');
  define ('TEXT_TITLE_5', 'Гарантия');
  define ('TEXT_TITLE_6', 'Доставка');
  define ('SPECIFICATION_TITLE_PRODUCTS', '&nbsp;Спецификации:');
  define ('SPECIFICATIONS_TEXT_ALL', 'Все');
// End Products Specifications

define('TEXT_IMAGE_DESCRIPTION', 'Описание картинки: ');

define('TEXT_PRODUCTS_BUNDLE', 'Добавить комплект:');
define('TEXT_ADD_LINE', 'Добавить строку');
define('TEXT_ADD_PRODUCT', 'Добавить к комплекту: ');
define('TEXT_REMOVE_PRODUCT', 'Удалить из комплекта');
define('TEXT_BUNDLE_HEADING', 'Название товара&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Количество&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;выберите товар из dropdown меню ниже');
define('TEXT_PRODUCTS_BY_BUNDLE', 'Данный комплект состоит из следующих товаров:');
define('TEXT_RATE_COSTS', 'Стоимость товара:');
define('TEXT_IT_SAVE', 'Вы экономите');
define('ENTRY_AVAILABLE_SEPARATELY', 'Данный товар может быть оформлен как отдельная единица.');
define('ENTRY_IN_BUNDLE_ONLY', 'Данный товар может быть оформлен только в составе комплекта.');
define('TEXT_SOLD_IN_BUNDLE', 'Данный товар может быть оформлен только в составе комплекта:');

define ('TEXT_TAB_BUNDLES', 'Комплекты');

define('TEXT_EDIT_LABEL', 'Ярлык категории:');
define('TEXT_EDIT_ICON', 'Иконка категории:');

?>