<?php
/* --------------------------------------------------------------
   $Id: customers_status.php 1062 2006-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(customers.php,v 1.76 2003/05/04); www.oscommerce.com
   (c) 2003	 nextcommerce (customers_status.php,v 1.12 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Группы клиентов');

define('ENTRY_CUSTOMERS_FSK18','Блокировать покупку товаров FSK18?');
define('ENTRY_CUSTOMERS_FSK18_DISPLAY','Блокировать покупку товаров FSK18?');
define('ENTRY_CUSTOMERS_STATUS_ADD_TAX','Показывать налог на странице подтверждения заказа');
define('ENTRY_CUSTOMERS_STATUS_MIN_ORDER','Минимальная сумма заказа:');
define('ENTRY_CUSTOMERS_STATUS_MAX_ORDER','Максимальная сумма заказа:');
define('ENTRY_CUSTOMERS_STATUS_BT_PERMISSION','Оплата через банковский перевод');
define('ENTRY_CUSTOMERS_STATUS_CC_PERMISSION','Оплата кредиткой');
define('ENTRY_CUSTOMERS_STATUS_COD_PERMISSION','Оплата наличными');
define('ENTRY_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES','Скидка');
define('ENTRY_CUSTOMERS_STATUS_PAYMENT_UNALLOWED','Укажите неразрешенные методы оплаты');
define('ENTRY_CUSTOMERS_STATUS_PUBLIC','Показывать в магазине бокс инфо (группа станет public)<br />');
define('ENTRY_CUSTOMERS_STATUS_SHIPPING_UNALLOWED','Укажите неразрешенные методы доставки');
define('ENTRY_CUSTOMERS_STATUS_SHOW_PRICE','Цена');
define('ENTRY_CUSTOMERS_STATUS_SHOW_PRICE_TAX','Цена включая налоги');
define('ENTRY_CUSTOMERS_STATUS_WRITE_REVIEWS','Разрешить этой группе клиентов писать отзывы?');
define('ENTRY_CUSTOMERS_STATUS_READ_REVIEWS','Разрешить этой группе клиентов читать отзывы?');
define('ENTRY_CUSTOMERS_STATUS_READ_REVIEWS_DISPLAY','Разрешить этой группе клиентов читать отзывы?');
define('ENTRY_GRADUATED_PRICES','Цены от количества');
define('ENTRY_NO','Нет');
define('ENTRY_OT_XMEMBER', 'Показывать скидку клиента на странице подтверждения товара ? :');
define('ENTRY_YES','Да');

define('ERROR_REMOVE_DEFAULT_CUSTOMER_STATUS', 'Ошибка: Группа по умолчанию не может быть удалена. Установите другую группу по умолчанию и попробуйте снова.');
define('ERROR_REMOVE_DEFAULT_CUSTOMERS_STATUS','ОШИБКА! Вы не можете удалить стандартные группы');
define('ERROR_STATUS_USED_IN_CUSTOMERS', 'Ошибка: Эта группа активна и в ней есть клиенты.');
define('ERROR_STATUS_USED_IN_HISTORY', 'Ошибка: Эта группа используется в истории заказов.');

define('YES','да');
define('NO','нет');

define('TABLE_HEADING_ACTION','Действие');
define('TABLE_HEADING_CUSTOMERS_GRADUATED','Цена от количества');
define('TABLE_HEADING_CUSTOMERS_STATUS','Группа');
define('TABLE_HEADING_CUSTOMERS_UNALLOW','Неразрешенные методы оплаты');
define('TABLE_HEADING_CUSTOMERS_UNALLOW_SHIPPING','Неразрешенные методы доставки');
define('TABLE_HEADING_DISCOUNT','Скидка');
define('TABLE_HEADING_TAX_PRICE','Показывать цены / включая налог');

define('TAX_NO','нет');
define('TAX_YES','да');

define('TEXT_DISPLAY_NUMBER_OF_CUSTOMERS_STATUS', 'Существующие группы клиентов:');

define('TEXT_INFO_CUSTOMERS_FSK18_DISPLAY_INTRO','<b>FSK18 товары</b>');
define('TEXT_INFO_CUSTOMERS_FSK18_INTRO','<b>FSK18 Заблокирован</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_ADD_TAX_INTRO','<b>Если цена включает налог, установите налог в = "нет"</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_MIN_ORDER_INTRO','Определите минимальную сумму заказа или оставьте поле пустым.');
define('TEXT_INFO_CUSTOMERS_STATUS_MAX_ORDER_INTRO','Определите максимальную сумму заказа или оставьте поле пустым.');
define('TEXT_INFO_CUSTOMERS_STATUS_BT_PERMISSION_INTRO', '<b>Разрешить покупателям этой группы оплату через банковский перевод?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_CC_PERMISSION_INTRO', '<b>Разрешить покупателям этой группы оплату кредитными картами?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_COD_PERMISSION_INTRO', '<b>Разрешить покупателям этой группы оплату наличными?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES_INTRO','<b>Скидка для атрибутов товара</b><br />(Макс. % скидки на единицу товара)');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_OT_XMEMBER_INTRO','<b>Показывать скидку на странице подтверждения заказа</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE', 'Скидка (от 0 до 100%):');
define('TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE_INTRO', 'Укажите скидку от 0 до 100%, которая будет применена к каждому товару.');
define('TEXT_INFO_CUSTOMERS_STATUS_GRADUATED_PRICES_INTRO','<b>Цены от количества</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_IMAGE','Картинка группы');
define('TEXT_INFO_CUSTOMERS_STATUS_NAME','<b>Название группы</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_PAYMENT_UNALLOWED_INTRO','<b>Неразрешенные методы оплаты</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_PUBLIC_INTRO','<b>Показывать инфо в магазине?</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_SHIPPING_UNALLOWED_INTRO','<b>Неразрешенные методы доставки</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_INTRO','<b>Показывать цены в магазине</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_TAX_INTRO','<b>Показывать цены с налогом или без</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_WRITE_REVIEWS_INTRO','<b>Написание отзывов</b>');
define('TEXT_INFO_CUSTOMERS_STATUS_READ_REVIEWS_INTRO', '<b>Чтение отзывов</b>');

define('TEXT_INFO_DELETE_INTRO', 'Вы действительно хотите удалить эту группу?');
define('TEXT_INFO_EDIT_INTRO', 'Пожалуйста, внесите необходимые изменения');
define('TEXT_INFO_INSERT_INTRO', 'Создайте новую группу.');

define('TEXT_INFO_HEADING_DELETE_CUSTOMERS_STATUS', 'Удаление группы');
define('TEXT_INFO_HEADING_EDIT_CUSTOMERS_STATUS','Редактирование группы');
define('TEXT_INFO_HEADING_NEW_CUSTOMERS_STATUS', 'Новая группа');

define('TEXT_INFO_CUSTOMERS_STATUS_BASE', '<b>Цена для группы</b>');
define('ENTRY_CUSTOMERS_STATUS_BASE', 'Какая цена будет показываться данной группе (Гость, Новый покупатель или Клиент). Если выбран Админ, то цены не показываются.');

?>