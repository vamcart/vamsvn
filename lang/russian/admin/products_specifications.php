<?php
/*
  $Id: products_specifications.php v1.0 20090909 kymation $
  Based on: categories.php 1739 2011-12-21 00:52:16Z hpdl $
  $Loc: catalog/admin/includes/languages/english/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2011 osCommerce

  Released under the GNU General Public License
*/

// Headings
  define ('HEADING_TITLE_GROUPS', 'Группы');
  define ('HEADING_TITLE_SPECIFICATIONS', 'Спецификации в группе: ');
  define ('HEADING_TITLE_FILTERS', 'Фильтры в спецификации: ');
  define ('HEADING_TITLE_VALUES', 'Значения в спецификации: ');
  define ('HEADING_TITLE_SEARCH_GROUPS', 'Поиск группы:');
  define ('HEADING_TITLE_SEARCH_SPECIFICATIONS', 'Поиск спецификации:');
  define ('HEADING_TITLE_SEARCH_FILTERS', 'Поиск фильтра:');
  define ('HEADING_TITLE_SEARCH_VALUES', 'Поиск значений спецификации:');
  define ('HEADING_TITLE_GROUPS', 'Поиск: ');
  define ('HEADING_TITLE_GOTO', 'Перейти: ');

// Specification Groups
  // Table Headings
  define ('TABLE_HEADING_ID', 'ID');
  define ('TABLE_HEADING_GROUPS', 'Название группы');
  define ('TABLE_HEADING_SPECS', 'Спецификации');
  define ('TABLE_HEADING_FILTERS', 'Фильтры');
  define ('TABLE_HEADING_ACTION', 'Действие');
  define ('TABLE_HEADING_PRODUCTS', 'Показывать на странице карточки товара');
  define ('TABLE_HEADING_FILTER', 'Показывать фильтр');
  define ('TABLE_HEADING_IN_FILTER', 'Показывать в фильтре');
  define ('TABLE_HEADING_COMPARISON', 'Показывать страницу сравнения');
  define ('TABLE_HEADING_ON_COMPARISON', 'Показывать на странице сравнения');
  define ('TABLE_HEADING_SORT_ORDER', 'Порядок сортировки');
  define ('TABLE_HEADING_VALUES', 'Значение');
  
  define ('TEXT_GROUPS_TOTAL', 'Всего групп: ');
  define ('TEXT_SPECS_TOTAL', 'Всего спецификаций: ');
  define ('TEXT_FILTERS_TOTAL', 'Всего фильтров: ');
  define ('TEXT_VALUES_TOTAL', 'Всего значений: ');
  define ('TEXT_FILTERS_TOTAL_SPEC', 'Всего фильтров в данной спецификации: ');
  define ('TEXT_VALUES_TOTAL_SPEC', 'Всего значений для данной спецификации: ');
  define ('TEXT_SPECS_TOTAL_GROUP', 'Всего спецификаций в данной группе: ');
  define ('TEXT_FILTERS_TOTAL_GROUP', 'Всего фильтров в данной группе: ');
  define ('TEXT_VALUES_TOTAL_GROUP', 'Всего значений для данной группы: ');

  define ('TEXT_INFO_HEADING_NEW_GROUP', 'Новая группа');
  define ('TEXT_INFO_HEADING_EDIT_GROUP', 'Редактирование группы');
  define ('TEXT_NEW_GROUP_INTRO', 'Пожалуйста, заполните форму для создания новой группы.');
  define ('TEXT_GROUP_NAME', 'Название группы:');
  define ('TEXT_SHOW_COMPARISON', 'Показывать на странице сравнения:');
  define ('TEXT_SHOW_ON_PRODUCTS', 'Показывать на странице карточки товара');
  define ('TEXT_SHOW_FILTER', 'Показывать фильтр:');
  define ('TEXT_SHOW_FILTER_MAINPAGE', 'Показывать фильтр на главной странице:');
  define ('TEXT_SHOW', 'Да');
  define ('TEXT_DONT_SHOW', 'Нет');
  define ('TEXT_FILTER_CLASS', 'Класс фильтра');
  define ('TEXT_FILTER_DISPLAY', 'Показывать фильтр как');
  define ('TEXT_FILTER_SHOW_ALL', 'Фильтр показать все');
  define ('TEXT_ENTER_FILTER', 'Укажите фильтр');
  define ('TEXT_ENTER_VALUE', 'Вводить значения спецификаций как');

  define ('TEXT_INFO_HEADING_COPY_GROUP', 'Копирование группы');
  define ('TEXT_COPY_GROUP_INTRO', 'Сделать копию данной группы?<br>Копируется только группа, включая отмеченные опции.');
  define ('TEXT_COPY_QUERY_LINKS', 'Так же копируется ссылок на категории: %s');
  define ('TEXT_COPY_QUERY_SPECS', 'Так же копируется спецификаций: %s');
  define ('TEXT_COPY_QUERY_PRODUCTS', 'Так же копируется спецификаций товаров: %s');
  define ('TEXT_COPY_QUERY_FILTERS', 'Так же копируется фильтров: %s');
  define ('TEXT_COPY_QUERY_VALUES', 'Так же копируется значений спецификации: %s');
  define ('TEXT_INFO_CURRENT_GROUP', 'Текущая группа: ');
  define ('TEXT_GROUPS', 'Выберите новую группу:');
  define ('TEXT_NO_GROUP_SELECT', 'Группа не выбрана!');
  
  define ('TEXT_SPECIFICATIONS', 'Спецификации в данной группе: ');
  define ('TEXT_FILTERS_GROUP', 'Фильтры в данной группе: ');
  define ('TEXT_FILTERS_SPEC', 'Фильтры на данной спецификации: ');
  define ('TEXT_ALL_CATEGORIES', 'Всего групп спецификаций: ');
  define ('TEXT_ALL_SPECIFICATIONS', 'Всего спецификаций: ');
  define ('TEXT_ALL_FILTERS', 'Всего фильтров: ');
  define ('TEXT_LIST_CATEGORIES_LINKED', 'Привязана к категориям: ');

  define ('TEXT_INFO_HEADING_LINK_CATEGORY', 'Привязать данную группу спецификаций к категорию');
  define ('TEXT_LINK_CATEGORIES_INTRO', 'Выберите категорию, к которой необходимо добавить данную спецификацию.');
  define ('TEXT_LINK_TO', 'Категория: ');
  define ('TEXT_LINK_TO_SUBCATS', 'Включая все подкатегории');

  define ('TEXT_INFO_HEADING_LINK_ALL_CATEGORIES', 'Привязать ко всем категориям');
  define ('TEXT_LINK_ALL_INTRO', '<b>Внимание!</b> Привязать ко всем категориям всех уровней!');
  
  define ('TEXT_INFO_HEADING_UNLINK_CATEGORY', 'Снять с категории');
  define ('TEXT_UNLINK_INTRO', 'Выберите категорию, с которой снять привязку');
  define ('TEXT_UNLINK_CATEGORY', 'Категория: ');
  define ('TEXT_NO_CATEGORIES', 'Нет категорий!');
  
  define ('TEXT_INFO_HEADING_UNLINK_ALL_CATEGORIES', 'Снять со всех категорий');
  define ('TEXT_UNLINK_ALL_INTRO', '<b>Внимание!</b> Снимается привязка со всех категориий всех уровней!!');
  
  define ('TEXT_INFO_HEADING_DELETE_GROUP', 'Удалить группу');
  define ('TEXT_DELETE_GROUP_INTRO', 'Вы действительно хотите удалить группу?');
  define ('TEXT_DELETE_WARNING_SPECS', '<b>Внимание!</b> будет удалено спецификаций: %s!');
  define ('TEXT_DELETE_WARNING_PRODUCTS', '<b>Внимание!</b> будет удалено спецификаций товаров: %s!');
  define ('TEXT_DELETE_WARNING_FILTERS', '<b>Внимание!</b> будет удалено фильтров: %s!');

  define ('TEXT_INFO_HEADING_EMPTY_GROUP', 'Нет данных!');
  define ('TEXT_NO_GROUPS', 'Создайте группу спецификаций.');
  
  define ('TEXT_INFO_HEADING_EMPTY_SPECIFICATIONS', 'Нет данных!');
  define ('TEXT_NO_SPECIFICATIONS', 'Создайте спецификации в данной группе.');
  
  define ('TEXT_INFO_HEADING_EDIT_GROUP', 'Редактировать группу');
  define ('TEXT_INFO_HEADING_MOVE_GROUP', 'Переместить группу');

// Specifications
  define ('TEXT_SPECIFICATION', 'Спецификация');
  define ('TEXT_SPEC_NAME', 'Название спецификации: ');
  define ('TEXT_SPEC_DESCRIPTION', 'Описание спецификации: ');
  define ('TEXT_SPEC_PREFIX', 'Префикс спецификации: ');
  define ('TEXT_SPEC_SUFFIX', 'Суффикс спецификации: ');
  define ('TEXT_SPEC_SORT_ORDER', 'Порядок сортировки: ');
  define ('TEXT_SPEC_COLUMN_NAME', 'Название колонки: ');
  define ('TEXT_SPEC_JUSTIFICATION', 'Выравнивание: ');
  define ('TEXT_SPECS_LEGEND', 'Легенда');
  define ('TEXT_SPECS_LEGEND_FILTERS', 'Раздел фильтров');
  define ('TEXT_SPECS_LEGEND_VALUES', 'Раздел значений спецификации');

  define ('TEXT_INFO_HEADING_NEW_SPECIFICATION', 'Новая спецификация в &quot;%s&quot;');
  define ('TEXT_NEW_SPECIFICATION_INTRO', 'Пожалуйста, заполните форму для создания новой спецификации в данном разделе.');
  define ('TEXT_SPECIFICATION_NAME', 'Название спецификации:');
  define ('TEXT_SPECIFICATION_DESCRIPTION', 'Описание спецификации:');

  define ('TEXT_SPECIFICATION_SEO_ACTIVE', 'Создавать автоматически SEO URL из названия спецификации');
  define ('TEXT_SPECIFICATION_SEO_ACTIVE_YES', 'Да');
  define ('TEXT_SPECIFICATION_SEO_ACTIVE_NO', 'Нет');
  define ('TEXT_SPECIFICATION_SEO_NAME', 'Задать уникальное SEO Название спецификации:');
  define ('TEXT_SPECIFICATION_SEO_URL', 'SEO URL:');

  define ('TEXT_SPECIFICATION_PREFIX', 'Префикс спецификации:');
  define ('TEXT_SPECIFICATION_SUFFIX', 'Суффикс спецификации:');
  define ('TEXT_EXISTING_FIELD', 'Использовать существующее в базе данных поле:');
  define ('TEXT_EXISTING_FIELD_NOTE', '<b>Замечание:</b> Если задана следующая опция, будут использованы данные из указанного поля.');
  
  define ('TEXT_INFO_HEADING_EDIT_SPECIFICATION', 'Редактирование спецификации');
  define ('TEXT_EDIT_INTRO', 'Внесите необходимые изменения');
  define ('TEXT_EDIT_SORT_ORDER', 'Порядок сортировки');
  define ('TEXT_COLUMN_JUSTIFY', 'Выравнивание');

  
  define ('TEXT_INFO_HEADING_COPY_SPECIFICATION', 'Копирование спецификации');
  define ('TEXT_INFO_COPY_SPECIFICATION_INTRO', 'Куда Вы хотите скопировать спецификацию %s?');
  define ('TEXT_COPY_SPECIFICATION_TO', 'Копировать в группу:');
  
  define ('TEXT_INFO_HEADING_MOVE_SPECIFICATION', 'Перемещение спецификации');
  define ('TEXT_MOVE_SPECIFICATION_INTRO', 'Куда Вы хотите переместить спецификацию %s?');
  define ('TEXT_MOVE_SPECIFICATION_TO', 'Переместить в группу:');
  define ('TEXT_MOVE', 'Переместить <b>%s</b> в:');

  define ('TEXT_INFO_HEADING_DELETE_SPECIFICATION', 'Удаление спецификации');
  define ('TEXT_DELETE_SPECIFICATION_INTRO', 'Вы действительно хотите удалить спецификацию?');
  
// Filters
  define ('TEXT_INFO_HEADING_FILTER', 'Класс фильтра: ');
  define ('TEXT_FILTER_VALUE', 'Фильтр: ');
  define ('TEXT_FILTER_SORT_ORDER', 'Порядок сортировки');
  define ('TEXT_INFO_HEADING_EMPTY_FILTERS', 'Пустой фильтр');
  define ('TEXT_NO_FILTERS', 'Вы можете создать один или несколько фильтров в данной спецификации.');
  
  define ('TEXT_INFO_HEADING_NEW_FILTER', 'Новый фильтр');
  define ('TEXT_NEW_FILTER_INTRO', 'Пожалуйста, заполните форму для создания нового фильтра.');
  define ('TEXT_NEW_FILTER', 'Фильтр');

  define ('TEXT_INFO_HEADING_EDIT_FILTER', 'Редактирование фильтра');
  define ('TEXT_EDIT_FILTER_INTRO', 'Внесите необходимые изменения');
  define ('TEXT_EDIT_FILTER', 'Фильтр');
  
  define ('TEXT_INFO_HEADING_COPY_FILTER', 'Копирование фильтра');
  define ('TEXT_COPY_FILTER_INTRO', 'В какую спецификацию Вы хотите скопировать данный фильтр?');
  define ('TEXT_COPY_FILTER_TO', 'Копировать фильтр <b>%s</b> в: ');

  define ('TEXT_INFO_HEADING_MOVE_FILTER', 'Перемещение фильтра');
  define ('TEXT_MOVE_FILTER_INTRO', 'Куда Вы хотите переместить данный фильтр?');
  define ('TEXT_MOVE_FILTER_TO', 'Переместить фильтр <b>%s</b> в: ');

  define ('TEXT_INFO_HEADING_DELETE_FILTER', 'Удаление фильтра');
  define ('TEXT_DELETE_FILTER_INTRO', 'Вы действительно хотите удалить данный фильтр?');
  
// Specification Values
  define ('TEXT_INFO_HEADING_VALUE', 'Значение спецификации');
  define ('TEXT_SPECIFICATION_VALUE', 'Значение спецификации: ');
  define ('TEXT_INFO_HEADING_EMPTY_VALUES', 'Пустое значение спецификации');
  define ('TEXT_NO_VALUES', 'Вы можете создать одно или несколько значений в данной спецификации.');

  define ('TEXT_INFO_HEADING_NEW_VALUE', 'Новое значение спецификации');
  define ('TEXT_NEW_VALUE_INTRO', 'Добавить новое значение для %s, используя класс %s');
  define ('TEXT_NEW_VALUE', 'Значение:');

  define ('TEXT_EDIT_VALUE_INTRO', 'Изменить значение для %s, используя класс %s');
  define ('TEXT_EDIT_VALUE', 'Значение:');
  define ('TEXT_VALUE_SORT_ORDER', 'Порядок сортировки значения:');

  define ('TEXT_INFO_HEADING_DELETE_VALUE', 'Удаление значения спецификации');
  define ('TEXT_DELETE_VALUE_INTRO', 'Вы действительно хотите удалить данное значение?');
  

  define ('TEXT_INFO_HEADING_EDIT_VALUE', 'Значение спецификации: ');
  define ('TEXT_VALUE', 'Значение: ');
  define ('TEXT_VALUE_SORT_ORDER', 'Порядок сортировки значения: ');

  define ('TEXT_INFO_HEADING_COPY_VALUE', 'Копирование значения');
  define ('TEXT_COPY_VALUE_INTRO', 'В какую спецификацию Вы хотите скопировать данное значение?');
  define ('TEXT_COPY_VALUE_TO', 'Копировать значение <b>%s</b> в:');

  define ('TEXT_INFO_HEADING_MOVE_VALUE', 'Перемещение значения');
  define ('TEXT_MOVE_VALUE_INTRO', 'В какую спецификацию Вы хотите переместить данное значение?');
  define ('TEXT_MOVE_VALUE_TO', 'Переместить значение <b>%s</b> в:');

// General
  define ('IMAGE_LINK', 'Прикрепить к категории');
  define ('IMAGE_LINK_ALL', 'Прикрепить ко всем категориям');
  define ('IMAGE_UNLINK', 'Снять с категории');
  define ('IMAGE_NEW_FILTER', 'Добавить новый фильтр');
  define ('IMAGE_NEW_VALUE', 'Добавить новое значение');
  define ('IMAGE_IMPORT_MANUFACTURERS', 'Импорт всех производителей');
  define ('ICON_BLANK', '');
  
  define ('TEXT_NONE', 'Нет');
  define ('TEXT_COMBI', 'Комбинация');
  define ('TEXT_BUY_NOW', 'Купить');
  define ('TEXT_PRODUCTS_MODEL', 'Код товара');
  define ('TEXT_PRODUCTS_IMAGE', 'Картинка товара');
  define ('TEXT_PRODUCTS_PRICE', 'Цена');
  define ('TEXT_PRODUCTS_WEIGHT', 'Вес');
  define ('TEXT_PRODUCTS_MANUFACTURER', 'Производитель');
  define ('TEXT_PRODUCTS_NAME', 'Название товара');
  define ('TEXT_LEFT', 'Слева');
  define ('TEXT_CENTER', 'Центр');
  define ('TEXT_RIGHT', 'Справа');
  define ('TEXT_NO_FILTER', 'Нет фильтра');
  define ('TEXT_EXACT', 'Точный');
  define ('TEXT_MULTIPLE', 'Составной');
  define ('TEXT_RANGE', 'Диапазон');
  define ('TEXT_REVERSE', 'Обратный');
  define ('TEXT_START', 'Стартовый');
  define ('TEXT_PARTIAL', 'Частичный');
  define ('TEXT_LIKE', 'Похожий');
  define ('TEXT_PULLDOWN', 'Dropdown меню');
  define ('TEXT_RADIO', 'Радио кнопки');
  define ('TEXT_LINKS', 'Список ссылок');
  define ('TEXT_TEXT_BOX', 'Текст');
  define ('TEXT_MULTI', 'Мульти dropdown');
  define ('TEXT_CHECK_BOXES', 'Чек боксы');
  define ('TEXT_IMAGES', 'Картинки');
  define ('TEXT_MULTI_IMAGE', 'Мульти картинки');
  define ('TEXT_FINAL_PRICE', 'Сумма');

define('IMAGE_NEW_SPECIFICATION_GROUP','Новая группа спецификаций');
define('IMAGE_BACK','Вернуться');
define('IMAGE_CANCEL','Отменить');
define('IMAGE_NEW_PRODUCT','Новая спецификация');
define('IMAGE_NEW_FILTER','Новый фильтр');
define('IMAGE_NEW_VALUE','Новое значение');
define('IMAGE_SAVE','Сохранить');
define('IMAGE_EDIT','Изменить');
define('IMAGE_DELETE','Удалить');
define('IMAGE_MOVE','Переместить');
define('IMAGE_COPY','Копировать');
define('IMAGE_LINK','Привязать к категории');
define('IMAGE_LINK_ALL','Привязать ко всем категориям');
define('IMAGE_UNLINK','Снять с категории');
define('IMAGE_UNLINK_ALL','Снять со всех категорий');
define('IMAGE_SORT','Сортировать');
define('IMAGE_IMPORT_MANUFACTURERS','Импорт производителей');

?>