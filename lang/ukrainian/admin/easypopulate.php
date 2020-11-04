<?php
/* --------------------------------------------------------------
   $Id: easypopulate.php 899 2011-02-07 17:36:57 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2011 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2003	 osCommerce (easypopulate.php,v 1.4 2003/08/14); oscommerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Excel импорт/экспорт');

define('EASYPOPULATE_TAB_IMPORT','Импорт');
define('EASYPOPULATE_TAB_IMPORT_TEMP','Импорт из директории');
define('EASYPOPULATE_TAB_SPLIT','Разделить');
define('EASYPOPULATE_TAB_EXPORT','Экспорт');
define('EASYPOPULATE_TAB_QUICK_LINKS','Быстрые ссылки');
define('EASYPOPULATE_TAB_INFO','Информация');

define('TEXT_EASYPOPULATE_PLEASE','Пожалуйста,');
define('TEXT_EASYPOPULATE_BACKUP_TEXT','делайте резервные копии базы данных');
define('TEXT_EASYPOPULATE_BACKUP_TEXT1',', прежде чем работать с модулем!');

define('TEXT_EASYPOPULATE_BACKUP_BUTTON','Резервное копирование');

define('EASY_UPLOAD_EP_FILE', 'Импорт');
define('EASY_INSERT', 'Импортировать');

define('TEXT_EASYPOPULATE_NORMAL','Нормальный');
define('TEXT_EASYPOPULATE_ADD','Добавить новые');
define('TEXT_EASYPOPULATE_UPDATE','Обновление');
define('TEXT_EASYPOPULATE_DELETE','Удаление');

define('EASY_IMPORT_TEMP_DIR', 'Импортировать из директории');
define('EASY_SPLIT_EP_FILE', 'Загрузить и разделить файл на части');

define('EASYPOPULATE_BUTTON_SPLIT','Разделить');

define('TEXT_EASYPOPULATE_EXPORT','Экспорт');

define('TEXT_EASYPOPULATE_ON_THE_FLY','Скачать');
define('TEXT_EASYPOPULATE_CREATE_THEN_DOWNLOAD','Создать и затем скачать');
define('TEXT_EASYPOPULATE_CREATE_IN_TEMP','Создать в директории');
define('TEXT_EASYPOPULATE_TYPE','файл');
define('TEXT_EASYPOPULATE_COMPLETE','Полный');
define('TEXT_EASYPOPULATE_CUSTOM','Выборочный');
define('TEXT_EASYPOPULATE_PRICE_QTY','Цена/Количество');
define('TEXT_EASYPOPULATE_CATEGORIES','Категории');
define('TEXT_EASYPOPULATE_ATTRIBUTES','Атрибуты');
define('TEXT_EASYPOPULATE_FROOGLE','Фругл');
define('TEXT_EASYPOPULATE_FILE_FORMAT',' файл (артикул всегда добавляется в файл).');

define('TEXT_EASYPOPULATE_LABEL_NAME','название');
define('TEXT_EASYPOPULATE_LABEL_DESC','описание');
define('TEXT_EASYPOPULATE_LABEL_URL','url ссылка');
define('TEXT_EASYPOPULATE_LABEL_IMAGE','картинка');
define('TEXT_EASYPOPULATE_LABEL_ATTRIBUTES','атрибуты');
define('TEXT_EASYPOPULATE_LABEL_CATEGORIES','категория');
define('TEXT_EASYPOPULATE_LABEL_MANUFACTURERS','производитель');
define('TEXT_EASYPOPULATE_LABEL_PRICE','цена');
define('TEXT_EASYPOPULATE_LABEL_QUANTITY','количество');
define('TEXT_EASYPOPULATE_LABEL_WEIGHT','вес');
define('TEXT_EASYPOPULATE_LABEL_TAX_CLASS','налог');
define('TEXT_EASYPOPULATE_LABEL_AVAILABLE','дата доступности');
define('TEXT_EASYPOPULATE_LABEL_DATE_ADDED','дата создания');
define('TEXT_EASYPOPULATE_LABEL_STATUS','статус');
define('TEXT_EASYPOPULATE_LABEL_SPECIALS','скидки');
define('TEXT_EASYPOPULATE_LABEL_ADD_IMAGES','добавить картинки');
define('TEXT_EASYPOPULATE_LABEL_VENDOR','вендор');
define('TEXT_EASYPOPULATE_LABEL_XSELL','сопутствующие товары');
define('TEXT_EASYPOPULATE_LABEL_QUANTITY_MIN','минимум для заказа');
define('TEXT_EASYPOPULATE_LABEL_QUANTITY_MAX','максимум для заказа');
define('TEXT_EASYPOPULATE_LABEL_LENGTH','длина');
define('TEXT_EASYPOPULATE_LABEL_WIDTH','ширина');
define('TEXT_EASYPOPULATE_LABEL_HEIGHT','высота');
define('TEXT_EASYPOPULATE_LABEL_VOLUME','объём');
define('TEXT_EASYPOPULATE_LABEL_SORT','порядок сортировки');
define('TEXT_EASYPOPULATE_LABEL_PAGE_URL','seo url товара');
define('TEXT_EASYPOPULATE_LABEL_SHORT_DESCRIPTION','краткое описание');
define('TEXT_EASYPOPULATE_LABEL_KEYWORDS','тэги товара');
define('TEXT_EASYPOPULATE_LABEL_DISCOUNT_ALLOWED','максимальная скидка');
define('TEXT_EASYPOPULATE_LABEL_STARTPAGE','показывать на главной');
define('TEXT_EASYPOPULATE_LABEL_STARTPAGE_SORT','сортировка на главной');
define('TEXT_EASYPOPULATE_LABEL_XML','яндекс маркет');

define('TEXT_EASYPOPULATE_FILTER_BY','Фильтр: ');
define('TEXT_EASYPOPULATE_FILTER_CATEGORY','- Категория -');
define('TEXT_EASYPOPULATE_FILTER_MANUFACTURER','- Производитель -');
define('TEXT_EASYPOPULATE_FILTER_STATUS','- Статус -');
define('TEXT_EASYPOPULATE_FILTER_STATUS_ACTIVE','Активные');
define('TEXT_EASYPOPULATE_FILTER_STATUS_DISABLED','Неактивные');
define('TEXT_EASYPOPULATE_BUILD_BUTTON','Создать файл');

define('TEXT_EASYPOPULATE_QUICK_LINKS','Быстрые ссылки');
define('TEXT_EASYPOPULATE_QUICK_LINKS_1','Создать и затем скачать');
define('TEXT_EASYPOPULATE_QUICK_LINKS_2','Генерировать файл целиком и затем скачать.');
define('TEXT_EASYPOPULATE_QUICK_LINKS_3','Скачать <b>Полный');
define('TEXT_EASYPOPULATE_QUICK_LINKS_4',' с модулем SPPC');
define('TEXT_EASYPOPULATE_QUICK_LINKS_5','файл для редактирования');
define('TEXT_EASYPOPULATE_QUICK_LINKS_6','файл в директории');
define('TEXT_EASYPOPULATE_QUICK_LINKS_7','Скачать <b>Дополнительные поля</b>');
define('TEXT_EASYPOPULATE_QUICK_LINKS_8','Скачать <b>Артикул/Цена/Количество');
define('TEXT_EASYPOPULATE_QUICK_LINKS_9','Скачать <b>Артикул/Категория');
define('TEXT_EASYPOPULATE_QUICK_LINKS_10','Скачать <b>Фругл');
define('TEXT_EASYPOPULATE_QUICK_LINKS_11','Скачать <b>Артикул/Атрибуты');
define('TEXT_EASYPOPULATE_QUICK_LINKS_12','файл');
define('TEXT_EASYPOPULATE_QUICK_LINKS_13','Создать в директории');
define('TEXT_EASYPOPULATE_QUICK_LINKS_14','Генерировать файл и затем сохранить во временной директории.');
define('TEXT_EASYPOPULATE_QUICK_LINKS_15','Создать <b>Полный</b>');
define('TEXT_EASYPOPULATE_QUICK_LINKS_16','Создать <b>Артикул/Цена/Количество</b>');
define('TEXT_EASYPOPULATE_QUICK_LINKS_17','Создать <b>Артикул/Категория</b>');
define('TEXT_EASYPOPULATE_QUICK_LINKS_18','Создать <b>Фругл</b>');
define('TEXT_EASYPOPULATE_QUICK_LINKS_19','Создать <b>Артикул/Атрибуты</b>');
define('TEXT_EASYPOPULATE_QUICK_LINKS_20','Временная директория:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_21','Временная директория доступная для записи');
define('TEXT_EASYPOPULATE_QUICK_LINKS_22','Временная директория только для чтения, установите права доступа на запись');
define('TEXT_EASYPOPULATE_QUICK_LINKS_23','Значение опции magic_quotes:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_24','Значение опции register_globals:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_25','Разделять файл на части по:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_26','Размер поля артикул товара:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_27','Цена с налогом:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_28','Знаков после запятой:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_29','Заменять кавычки:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_30','Разделитель колонок:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_31','табулятор');
define('TEXT_EASYPOPULATE_QUICK_LINKS_32','запятая');
define('TEXT_EASYPOPULATE_QUICK_LINKS_33','точка с запятой');
define('TEXT_EASYPOPULATE_QUICK_LINKS_34','тильда');
define('TEXT_EASYPOPULATE_QUICK_LINKS_35','тире');
define('TEXT_EASYPOPULATE_QUICK_LINKS_36','звёздочка');
define('TEXT_EASYPOPULATE_QUICK_LINKS_37','Сохранение excel файла:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_38','Сохранять табулятор, перевод каретки:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_39','Глубина категорий:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_40','Разрешить атрибуты:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_41','SEO URL в Фругле:');
define('TEXT_EASYPOPULATE_QUICK_LINKS_42','вкл.');
define('TEXT_EASYPOPULATE_QUICK_LINKS_43','выкл.');
define('TEXT_EASYPOPULATE_QUICK_LINKS_44','записей');

define('EASY_ERROR_1', 'Странно, но язык по умолчанию не установлен... Ничего страшного, просто предупреждение... ');
define('EASY_FILE_LOCATE', 'Вы можете взять Ваш файл в папке ');

define('TEXT_EASYPOPULATE_CLEAR','Вернуться');

define('EASY_UPLOAD_FILE', 'Файл загружен. ');
define('EASY_UPLOAD_TEMP', 'Имя временного файла: ');
define('EASY_UPLOAD_USER_FILE', 'Имя файла пользователя: ');
define('EASY_SIZE', 'Размер: ');
define('EASY_FILENAME', 'Имя файла: ');

define('EASY_ERROR_7', 'Не могу открыть файл для чтения.<br />');

define('EASY_LABEL_FILE_COUNT_1', 'Создать файл EP_Split');

define('EASY_LABEL_LINE_COUNT_1', 'Добавлено ');
define('EASY_LABEL_LINE_COUNT_2', ' записей и файл закрыт... ');

define('EASY_SPLIT_DOWN', 'Вы можете импортировать разделённые файлы из папки');

define('EASY_TEXT_DELETED', 'Удалён товар ');
define('EASY_TEXT_DELETED1', '.');
define('EASY_TEXT_NOT_DELETE', 'Не удалён ');
define('EASY_TEXT_NOT_DELETE1', ' потому что товар не уникальный.');

define('EASY_ERROR_2', '... ОШИБКА! - Слишком много символов в поле код товара.<br>
			12 символов - это максимальное количество.<br>
			Максимальная длина поля product_model, установленная в настройках модуля: ');
define('EASY_ERROR_2A', ' <br>Вы можете либо укоротить код товара, либо увеличить длину поля в базе данных, а затем в /admin/easypopulate.php поменять значение опции EP_MODEL_NUMBER_SIZE.</font>');

define('EASY_LABEL_NEW_PRODUCT', "<font color=blue> Товар добавлен</font><br>");
define('EASY_LABEL_UPDATED', "<font color=green> Товар обновлён</font><br>");
define('EASY_LABEL_DELETE_STATUS_1', '<font color=red>Товар</font><font color=black> ');
define('EASY_LABEL_DELETE_STATUS_2', ' </font><font color=red> удалён!</font>');

define('EASY_LABEL_TEXT_NO_MODEL', 'Не найден артикул товара. Данная строка не импортирована: ');

define('EASY_EXTRA_FIELD_UPDATED', 'Дополнительные поля обновлены');
define('EASY_EXTRA_FIELD_ADDED', 'Дополнительные поля добавлены');

define('EASY_CATEGORIES_UPDATED', 'Категории обновлены');
define('EASY_CATEGORIES_ADDED', 'Категории добавлены');

define('TEXT_EASYPOPULATE_QUICK_LINKS_CATEGORIES','Скачать <b>Категории</b>');

?>