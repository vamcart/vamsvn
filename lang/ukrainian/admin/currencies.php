<?php
/* --------------------------------------------------------------
   $Id: currencies.php 899 2010-02-07 17:36:58 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(currencies.php,v 1.15 2003/05/02); www.oscommerce.com 
   (c) 2003	 nextcommerce (currencies.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2004	 xt:Commerce (currencies.php,v 1.4 2003/08/14); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
   
define('HEADING_TITLE', 'Валюты');

define('TABLE_HEADING_CURRENCY_NAME', 'Валюта');
define('TABLE_HEADING_CURRENCY_CODES', 'Код');
define('TABLE_HEADING_CURRENCY_VALUE', 'Величина');
define('TABLE_HEADING_ACTION', 'Действие');

define('TEXT_INFO_EDIT_INTRO', 'Пожалуйста, внесите необходимые изменения');
define('TEXT_INFO_CURRENCY_TITLE', 'Название:');
define('TEXT_INFO_CURRENCY_CODE', 'Код:');
define('TEXT_INFO_CURRENCY_SYMBOL_LEFT', 'Символ слева:');
define('TEXT_INFO_CURRENCY_SYMBOL_RIGHT', 'Символ справа:');
define('TEXT_INFO_CURRENCY_DECIMAL_POINT', 'Десятичный знак:');
define('TEXT_INFO_CURRENCY_THOUSANDS_POINT', 'Разделитель тысяч:');
define('TEXT_INFO_CURRENCY_DECIMAL_PLACES', 'Десятичные порядки:');
define('TEXT_INFO_CURRENCY_LAST_UPDATED', 'Последний раз скорректировано:');
define('TEXT_INFO_CURRENCY_VALUE', 'Величина:');
define('TEXT_INFO_CURRENCY_EXAMPLE', 'Пример:');
define('TEXT_INFO_INSERT_INTRO', 'Пожалуйста, введите данные для новой валюты');
define('TEXT_INFO_DELETE_INTRO', 'Вы действительно хотите удалить эту валюту?');
define('TEXT_INFO_HEADING_NEW_CURRENCY', 'Новая Валюта');
define('TEXT_INFO_HEADING_EDIT_CURRENCY', 'Изменить Валюту');
define('TEXT_INFO_HEADING_DELETE_CURRENCY', 'Удалить Валюту');
define('TEXT_INFO_SET_AS_DEFAULT', TEXT_SET_DEFAULT . ' (у валюты по умолчанию в опции величина должно быть указано 1, курсы (величина) остальных валют должны быть пересчитаны относительно валюты по умолчанию)');
define('TEXT_INFO_CURRENCY_UPDATED', 'Обменный курс для %s (%s) успешно обновлён с помощью %s.');

define('ERROR_REMOVE_DEFAULT_CURRENCY', 'Ошибка: Валюта, установленная по умолчанию не может быть удалена. Определите другую валюту по умолчанию и попробуйте снова.');
define('ERROR_CURRENCY_INVALID', 'Ошибка: Обменный курс для %s (%s) не был обновлён с помощью %s. Вы правильно указали код валюты? Чтобы обновить обменный курс, Вы должны быть подключены к интернету.');
?>