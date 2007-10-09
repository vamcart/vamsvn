<?php
/* --------------------------------------------------------------
   $Id: recover_cart_sales.php 899 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2003	 JM Ivler (recover_cart_sales.php,v 1.4 2003/08/14); oscommerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('MESSAGE_STACK_CUSTOMER_ID', 'Незавершённый заказ покупателя (id код ');
define('MESSAGE_STACK_DELETE_SUCCESS', ') успешно удалён.');
define('HEADING_TITLE_RECOVER', 'Незавершённые заказы');
define('HEADING_EMAIL_SENT', 'Отчёт об отправке писем');
define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Сообщение от Интернет-магазина '.  STORE_NAME );
define('DAYS_FIELD_PREFIX', 'Показать заказы за последние ');
define('DAYS_FIELD_POSTFIX', ' дней ');
define('DAYS_FIELD_BUTTON', 'Смотреть');
define('TABLE_HEADING_DATE', 'Дата');
define('TABLE_HEADING_CONTACT', 'Уведомлён');
define('TABLE_HEADING_CUSTOMER', 'Имя покупателя');
define('TABLE_HEADING_EMAIL', 'E-mail адрес');
define('TABLE_HEADING_PHONE', 'Телефон');
define('TABLE_HEADING_MODEL', 'Код');
define('TABLE_HEADING_DESCRIPTION', 'Товар');
define('TABLE_HEADING_QUANTY', 'Количество');
define('TABLE_HEADING_PRICE', 'Стоимость');
define('TABLE_HEADING_TOTAL', 'Всего');
define('TABLE_GRAND_TOTAL', 'Общая стоимость незавершённых заказов: ');
define('TABLE_CART_TOTAL', 'Стоимость заказа: ');
define('TEXT_CURRENT_CUSTOMER', 'Покупатель');
define('TEXT_SEND_EMAIL', 'Отправить E-mail');
define('TEXT_RETURN', 'Вернуться назад');
define('TEXT_NOT_CONTACTED', 'Не уведомлён');
define('PSMSG', 'Дополнительное сообщение: ');
?>