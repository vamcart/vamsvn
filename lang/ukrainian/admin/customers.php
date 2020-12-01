<?php
/* --------------------------------------------------------------
   $Id: customers.php 1295 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(customers.php,v 1.13 2002/06/15); www.oscommerce.com 
   (c) 2003	 nextcommerce (customers.php,v 1.8 2003/08/15); www.nextcommerce.org
   (c) 2004	 xt:Commerce (customers.php,v 1.8 2003/08/15); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Клиенты');
define('HEADING_TITLE_SEARCH', 'Поиск:');

define('TABLE_HEADING_FIRSTNAME', 'Имя');
define('TABLE_HEADING_LASTNAME', 'Фамилия');
define('TABLE_HEADING_ACCOUNT_CREATED', 'Дата регистрации');
define('TABLE_HEADING_ACTION', 'Действие');
define('TEXT_DATE_ACCOUNT_CREATED', 'Дата регистрации:');
define('TEXT_DATE_ACCOUNT_LAST_MODIFIED', 'Последние изменения:');
define('TEXT_INFO_DATE_LAST_LOGON', 'Последний вход:');
define('TEXT_INFO_NUMBER_OF_LOGONS', 'Количество входов:');
define('TEXT_INFO_COUNTRY', 'Страна:');
define('TEXT_INFO_NUMBER_OF_REVIEWS', 'Кол-во отзывов:');
define('TEXT_DELETE_INTRO', 'Вы действительно желаете удалить этого клиента?');
define('TEXT_DELETE_REVIEWS', 'Удалить %s отзыв(ы)');
define('TEXT_INFO_HEADING_DELETE_CUSTOMER', 'Удалить клиента');
define('TYPE_BELOW', 'Введите ниже');
define('PLEASE_SELECT', 'Выберите');
define('HEADING_TITLE_STATUS','Группы клиентов:');
define('TEXT_ALL_CUSTOMERS','все группы');
define('TEXT_INFO_HEADING_STATUS_CUSTOMER','Группы клиентов');
define('TABLE_HEADING_NEW_VALUE','Новый статус');
define('TABLE_HEADING_DATE_ADDED','Дата');
define('TEXT_NO_CUSTOMER_HISTORY','-пока нет изменений-');
define('TABLE_HEADING_GROUPIMAGE','Иконка');
define('ENTRY_MEMO','Заметки:');
define('TEXT_DATE','Дата');
define('TEXT_TITLE','Заголовок');
define('TEXT_POSTER','Автор');
define('ENTRY_PASSWORD_CUSTOMER','Пароль:');
define('TEXT_SELECT','-Выберите-');
define('TABLE_HEADING_ACCOUNT_TYPE','Зарегистрирован');
define('TEXT_ACCOUNT','Да');
define('TEXT_GUEST','Нет');
define('NEW_ORDER','Новый заказ');
define('ENTRY_DISCOUNT','Скидки клиента (заменяют групповую скидку):');
define('ENTRY_DISCOUNT_CUSTOMER','Личная скидка клиента:');
define('ENTRY_DISCOUNT_CUSTOMER_TO_MANUFACTURER','Скидка клиента на производителя:');
define('ENTRY_PAYMENT_UNALLOWED','Запрещённые модули оплаты:');
define('ENTRY_SHIPPING_UNALLOWED','Запрещённые модули доставки:');
define('ENTRY_NEW_PASSWORD','Новый пароль:');

define('TEXT_INFO_ORIGINAL_REFERER', 'Реферер:');

define('SHIPPING_FLAT','Курьерская доставка');
define('ORDER_TOTAL','<b>Всего:</b>');
define('ORDER_SUBTOTAL','<b>Стоимость товара:</b>');

define('CATEGORY_EXTRA_FIELDS','Дополнительная информация');

define('PULL_DOWN_DEFAULT','Выберите');

define('BUTTON_CUSTOMERS_EXPORT','Экспорт клиентов');

define('BUS_CUSTOMER','Покупатель номер ');
define('BUS_SUCCESS','обновлён!');
define('BUS_WARNING','не обновлён!');
define('BUS_DELETE_SUCCESS','удалён!');
define('BUS_DELETE_WARNING','не удалён!');
define('BUS_DELETE_CUSTOMERS','Удалить выбранных покупателей');

define('TEXT_TRANSFER_ORDERS_1','Передать заказы с аккаунта');
define('TEXT_TRANSFER_ORDERS_2','Кому передать заказы');
define('TEXT_TRANSFER_ORDERS_3','ID номер');
define('TEXT_TRANSFER_ORDERS_4','Имя');
define('TEXT_TRANSFER_ORDERS_5','Email');
define('TEXT_TRANSFER_ORDERS_6','Телефон');
define('TEXT_TRANSFER_ORDERS_7','Укажите <strong>ID номер</strong> клиента, которому должны быть переданы заказы:');
define('TEXT_TRANSFER_ORDERS_8','Передать заказы');
define('TEXT_TRANSFER_ORDERS_9','Передать заказы на другой аккаунт');

?>