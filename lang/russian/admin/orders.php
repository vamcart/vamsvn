<?php
/* --------------------------------------------------------------
   $Id: orders.php 1193 2010-10-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders.php,v 1.27 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (orders.php,v 1.7 2003/08/14); www.nextcommerce.org
   (c) 2004	 xt:Commerce (orders.php,v 1.7 2003/08/14); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
   
define('TEXT_BANK', 'Список банков');
define('TEXT_BANK_OWNER', 'Владелец счёта:');
define('TEXT_BANK_NUMBER', 'Номер счёта:');
define('TEXT_BANK_BLZ', 'Код банка:');
define('TEXT_BANK_NAME', 'Банк:');
define('TEXT_BANK_FAX', 'Collect Authorization will be approved via Fax');
define('TEXT_BANK_STATUS', 'Проверка статуса:');
define('TEXT_BANK_PRZ', 'Метод проверки:');

define('TEXT_BANK_ERROR_1', 'Accountnumber and Bank Code are not compatible!<br />Please try again!');
define('TEXT_BANK_ERROR_2', 'Sorry, we are unable to proof this account number!');
define('TEXT_BANK_ERROR_3', 'Account number not proofable! Method of Verify not implemented');
define('TEXT_BANK_ERROR_4', 'Account number technically not proofable!<br />Please try again!');
define('TEXT_BANK_ERROR_5', 'Bank Code not found!<br />Please try again.!');
define('TEXT_BANK_ERROR_8', 'No match for your Bank Code or Bank Code not given!');
define('TEXT_BANK_ERROR_9', 'No account number given!');
define('TEXT_BANK_ERRORCODE', 'Код ошибки:');

define('HEADING_TITLE', 'Список заказов');
define('HEADING_TITLE_SEARCH', 'Поиск по номеру заказа');
define('HEADING_TITLE_STATUS', 'Статус:');

define('TABLE_HEADING_COMMENTS', 'Комментарий');
define('TABLE_HEADING_CUSTOMER', 'Покупатель');
define('TABLE_HEADING_ORDER_TOTAL', 'Сумма заказа');
define('TABLE_HEADING_DATE_PURCHASED', 'Дата покупки');
define('TABLE_HEADING_STATUS', 'Состояние');
define('TABLE_HEADING_ACTION', 'Действие');
define('TABLE_HEADING_QUANTITY', 'Количество');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Код товара');
define('TABLE_HEADING_PRODUCTS', 'Товары');
define('TABLE_HEADING_TAX', 'Налог');
define('TABLE_HEADING_TOTAL', 'Всего');
define('TABLE_HEADING_STATUS', 'Статус');
define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Цена (не включая налог)');
define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Цена');
define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Общая (не включая налог)');
define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Всего');
define('TABLE_HEADING_AFTERBUY','Afterbuy');

define('TABLE_HEADING_STATUS', 'Статус');
define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Клиент уведомлён');
define('TABLE_HEADING_DATE_ADDED', 'Добавлен');

define('ENTRY_CUSTOMER', 'Клиент:');
define('ENTRY_SOLD_TO', 'ПОКУПАТЕЛЬ:');
define('ENTRY_STREET_ADDRESS', 'Адрес:');
define('ENTRY_SUBURB', 'Район:');
define('ENTRY_CITY', 'Город:');
define('ENTRY_POST_CODE', 'Почтовый индекс:');
define('ENTRY_STATE', 'Регион:');
define('ENTRY_COUNTRY', 'Страна:');
define('ENTRY_TELEPHONE', 'Телефон:');
define('ENTRY_EMAIL_ADDRESS', 'Email:');
define('ENTRY_DELIVERY_TO', 'Адрес:');
define('ENTRY_SHIP_TO', 'АДРЕС ДОСТАВКИ:');
define('ENTRY_SHIPPING_ADDRESS', 'Адрес доставки:');
define('ENTRY_BILLING_ADDRESS', 'Адрес покупателя:');
define('ENTRY_PAYMENT_METHOD', 'Способ оплаты:');
define('ENTRY_SHIPPING_METHOD', 'Способ доставки:');
define('ENTRY_CREDIT_CARD_TYPE', 'Тип кредитной карточки:');
define('ENTRY_CREDIT_CARD_OWNER', 'Владелец кредитной карточки:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Номер кредитной карточки:');
define('ENTRY_CREDIT_CARD_CVV', 'Код (CVV)):');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Карточка действительна до:');
define('ENTRY_SUB_TOTAL', 'Стоимость товара:');
define('ENTRY_TAX', 'Налог:');
define('ENTRY_SHIPPING', 'Доставка:');
define('ENTRY_TOTAL', 'Всего:');
define('ENTRY_DATE_PURCHASED', 'Дата покупки:');
define('ENTRY_STATUS', 'Состояние:');
define('ENTRY_DATE_LAST_UPDATED', 'Последнее изменение:');
define('ENTRY_NOTIFY_CUSTOMER', 'Уведомить Клиента:'); 
define('ENTRY_NOTIFY_COMMENTS', 'Добавить комментарии:');
define('ENTRY_PRINTABLE', 'Напечатать счёт');

define('TEXT_INFO_HEADING_DELETE_ORDER', 'Удалить заказ');
define('TEXT_INFO_DELETE_INTRO', 'Вы действительно хотите удалить этот заказ?');
define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Пересчитать количество товара на складе');
define('TEXT_DATE_ORDER_CREATED', 'Дата Создания:');
define('TEXT_DATE_ORDER_LAST_MODIFIED', 'Последние Изменения:');
define('TEXT_INFO_PAYMENT_METHOD', 'Способ Оплаты:');

define('TEXT_ALL_ORDERS', 'Все заказы');
define('TEXT_NO_ORDER_HISTORY', 'История заказа отсутствует');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Статус Вашего заказа изменён');
define('EMAIL_TEXT_ORDER_NUMBER', 'Номер заказа:');
define('EMAIL_TEXT_INVOICE_URL', 'Информация о заказе:');
define('EMAIL_TEXT_DATE_ORDERED', 'Дата заказа:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Статус Вашего заказа изменён.' . "\n\n" . 'Новый статус: %s' . "\n\n" . 'Если у Вас возникли вопросы, просто задайте нам их в ответном письме.' . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Комментарии к Вашему заказу' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', 'Ошибка: Заказ не существует.');
define('SUCCESS_ORDER_UPDATED', 'Выполнено: Заказ успешно обновлён.');
define('WARNING_ORDER_NOT_UPDATED', 'Внимание: Изменять нечего. Заказ НЕ обновлён.');

define('TABLE_HEADING_DISCOUNT','Скидка');
define('ENTRY_CUSTOMERS_GROUP','Группа клиентов:');
define('ENTRY_CUSTOMERS_VAT_ID','VAT-ID:');
define('TEXT_VALIDATING','Не проверен');

// VaM сборка

define('TEXT_NUMBER',', заказ номер ');
define('TABLE_HEADING_NUMBER','Номер');
define('TEXT_PRODUCTS',' товар (ов) ');

define('ENTRY_ORIGINAL_REFERER', 'Реферер:');
define('ENTRY_ORDER_NUMBER', 'Номер заказа:');

define('EMAIL_ACC_SUBJECT', 'Накопительная скидка');

define('TEXT_ORDER_SUMMARY','Информация');
define('TEXT_ORDER_PAYMENT','Оплата / Доставка');
define('TEXT_ORDER_PRODUCTS','Товары');
define('TEXT_ORDER_STATUS','Статус');

define('BUS_HEADING_TITLE','Смена статуса');
define('BUS_TEXT_NEW_STATUS', 'Выберите новый статус');
define('BUS_NOTIFY_CUSTOMERS', 'Уведомить покупателя (ей)');
define('BUS_ORDER','Заказ номер ');
define('BUS_SUCCESS','обновлён!');
define('BUS_WARNING','не обновлён!');
define('BUS_DELETE_SUCCESS','удалён!');
define('BUS_DELETE_WARNING','не удалён!');
define('BUS_DELETE_ORDERS','Удалить выбранные заказы');

define('TEXT_QTY','склад: ');
define('TEXT_UNITS',' шт.');

define('TEXT_ORDER_MAP','Карта');
define('MAP_API_KEY_ERROR','Зарегистрируйте ключ на <a href=\"http://api.yandex.ru/maps/form.xml\" target=\"_blank\">http://api.yandex.ru/maps/form.xml</a> и укажите Ваш ключ в Админке - Настройки - Разное - Яндекс карты API-Ключ. <br /> Ошибка:');

define('BUTTON_ORDERS_EXPORT','Экспорт заказов');

define('ENTRY_ANSWER_TEMPLATE', 'Шаблон ответа:');

define('TEXT_ORDER_HISTORY','История');
define('TEXT_COPY_ORDER','Копировать заказ');
define('TEXT_NEW_ORDER_FOR_CUSTOMER','Создать новый заказ для данного клиента');

define('TEXT_ORDER_LOG_NAME','Имя');
define('TEXT_ORDER_LOG_ACTION','Действие');
define('TEXT_ORDER_LOG_VALUE','Значение');
define('TEXT_ORDER_LOG_DATE','Дата');


?>