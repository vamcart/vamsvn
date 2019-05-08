<?php
/*
  $Id: edit_orders.php v5.0 08/05/2007 djmonkey1 Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/

define('HEADING_TITLE', 'Редактирование заказа номер %s от %s');
define('ADDING_TITLE', 'Добавляем товар к заказу номер %s');

define('ENTRY_UPDATE_TO_CC', '');
define('TABLE_HEADING_COMMENTS', 'Комментарии');
define('TABLE_HEADING_STATUS', 'Статус');
define('TABLE_HEADING_NEW_STATUS', 'Новый статус');
define('TABLE_HEADING_ACTION', 'Действие');
define('TABLE_HEADING_DELETE', 'Удалить?');
define('TABLE_HEADING_QUANTITY', 'Количество');
define('TABLE_HEADING_PRODUCTS_MODEL', 'Код');
define('TABLE_HEADING_PRODUCTS', 'Товары');
define('TABLE_HEADING_TAX', 'Налог');
define('TABLE_HEADING_TOTAL', 'Всего');
define('TABLE_HEADING_BASE_PRICE', 'Цена<br>(за единицу)');
define('TABLE_HEADING_UNIT_PRICE', 'Цена<br>(без налога)');
define('TABLE_HEADING_UNIT_PRICE_TAXED', 'Цена<br>(с налогом)');
define('TABLE_HEADING_TOTAL_PRICE', 'Сумма<br>(без налога)');
define('TABLE_HEADING_TOTAL_PRICE_TAXED', 'Сумма<br>(с налогом)');
define('TABLE_HEADING_OT_TOTALS', 'Сумма заказа:');
define('TABLE_HEADING_OT_VALUES', 'Значение:');
define('TABLE_HEADING_SHIPPING_QUOTES', 'Доставка:');
define('TABLE_HEADING_NO_SHIPPING_QUOTES', 'Нет информации!');

define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Покупатель уведомлён');
define('TABLE_HEADING_DATE_ADDED', 'Дата');

define('ENTRY_CUSTOMER', 'Покупатель');
define('ENTRY_NAME', 'Имя:');
define('ENTRY_CITY_STATE', 'Город:');
define('ENTRY_SHIPPING_ADDRESS', 'Адрес доставки');
define('ENTRY_BILLING_ADDRESS', 'Адрес покупателя');
define('ENTRY_PAYMENT_METHOD', 'Способ оплаты');
define('ENTRY_CREDIT_CARD_TYPE', 'Тип карточки:');
define('ENTRY_CREDIT_CARD_OWNER', 'Владелец карточки:');
define('ENTRY_CREDIT_CARD_NUMBER', 'Номер карточки:');
define('ENTRY_CREDIT_CARD_EXPIRES', 'Действительна до:');
define('ENTRY_SUB_TOTAL', 'Стоимость товара:');

//the definition of ENTRY_TAX is important when dealing with certain tax components and scenarios
define('ENTRY_TAX', 'Налог');
//do not use a colon (:) in the defintion, ie 'VAT' is ok, but 'VAT:' is not

define('ENTRY_SHIPPING', 'Доставка:');
define('ENTRY_TOTAL', 'Всего:');
define('ENTRY_STATUS', 'Статус:');
define('ENTRY_NOTIFY_CUSTOMER', 'Уведомить покупателя:');
define('ENTRY_NOTIFY_COMMENTS', 'Отправить комментарии:');
define('ENTRY_CURRENCY_TYPE', 'Валюта');
define('ENTRY_CURRENCY_VALUE', 'Значение');

define('TEXT_INFO_PAYMENT_METHOD', 'Способ оплаты:');
define('TEXT_NO_ORDER_PRODUCTS', 'В данном заказе нет товаров');
define('TEXT_ADD_NEW_PRODUCT', 'Добавить товар');
define('TEXT_PACKAGE_WEIGHT_COUNT', 'Вес: %s  |  Количество единиц товара: %s');

define('TEXT_STEP_1', '<b>Шаг 1:</b>');
define('TEXT_STEP_2', '<b>Шаг 2:</b>');
define('TEXT_STEP_3', '<b>Шаг 3:</b>');
define('TEXT_STEP_4', '<b>Шаг 4:</b>');
define('TEXT_SELECT_CATEGORY', '- Выберите категорию -');
define('TEXT_PRODUCT_SEARCH', '<b>- или введите ключевые слова для поиска -</b>');
define('TEXT_ALL_CATEGORIES', 'Все категории/Все товары');
define('TEXT_SELECT_PRODUCT', '- Выберите товар -');
define('TEXT_BUTTON_SELECT_OPTIONS', 'Выберите атрибуты');
define('TEXT_BUTTON_SELECT_CATEGORY', 'Выбрать данную категорию');
define('TEXT_BUTTON_SELECT_PRODUCT', 'Выбрать данный товар');
define('TEXT_SKIP_NO_OPTIONS', '<em>Нет атрибутов - Пропущено...</em>');
define('TEXT_QUANTITY', 'Количество:');
define('TEXT_BUTTON_ADD_PRODUCT', 'Добавить к заказу');
define('TEXT_CLOSE_POPUP', '<u>Закрыть окно</u> [x]');
define('TEXT_ADD_PRODUCT_INSTRUCTIONS', 'Продолжайте добавлять товар, когда будет добавлен весь необходимый товар, просто закройте окно.');
define('TEXT_PRODUCT_NOT_FOUND', '<b>Товар не найден<b>');
define('TEXT_SHIPPING_SAME_AS_BILLING', 'Адрес доставки и адрес покупателя совпадают');
define('TEXT_BILLING_SAME_AS_CUSTOMER', 'Адреса одинаковые');

define('IMAGE_ADD_NEW_OT', 'Укажите новую запись заказ итого');
define('IMAGE_REMOVE_NEW_OT', 'Удалить данную строку');
define('IMAGE_NEW_ORDER_EMAIL', 'Отправить e-mail с информацией о заказе');

define('TEXT_NO_ORDER_HISTORY', 'Нет истории заказа');

define('PLEASE_SELECT', 'Выберите');

define('EMAIL_SEPARATOR', '------------------------------------------------------');
define('EMAIL_TEXT_SUBJECT', 'Ваш заказ был обновлён');
define('EMAIL_TEXT_ORDER_NUMBER', 'Номер заказа:');
define('EMAIL_TEXT_INVOICE_URL', 'Подробная информация о заказе:');
define('EMAIL_TEXT_DATE_ORDERED', 'Дата заказа:');
define('EMAIL_TEXT_STATUS_UPDATE', 'Спасибо за Ваш заказ!' . "\n\n" . 'Статус Вашего заказа был изменён.' . "\n\n" . 'Новый статус: %s' . "\n\n");
define('EMAIL_TEXT_STATUS_UPDATE2', 'Если у Вас есть вопросы, задайте их нам в ответном письме.' . "\n\n" . 'С уважением, ' . STORE_NAME . "\n");
define('EMAIL_TEXT_COMMENTS_UPDATE', 'Комментарии к Вашему заказу:' . "\n\n%s\n\n");

define('ERROR_ORDER_DOES_NOT_EXIST', 'Ошибка: Заказ %s не найден.');
define('SUCCESS_ORDER_UPDATED', 'Успешно: Заказ был успешно обновлён.');
define('WARNING_ORDER_NOT_UPDATED', 'Предупреждение: Никаких изменений сделано не было.');
define('SUCCESS_EMAIL_SENT', 'Завершено: Информация о заказе отправлена на email.');

//the hints
define('HINT_UPDATE_TO_CC', '');
define('HINT_UPDATE_CURRENCY', 'При смене валюты заказа будут пересчитаны все итоговые суммы заказа.');
define('HINT_SHIPPING_ADDRESS', 'При смене региона, почтового индекса или страны Вы увидите предупреждение, пересчитать или нет итоговую стоимость заказа.');
define('HINT_TOTALS', 'Вы можете указывать скидки, добавляя отрицательные значения. Поля стоимость товара, налог и всего редактировать нельзя.');
define('HINT_PRESS_UPDATE', 'Нажмите Обновить для сохранения внесённых изменёний.');
define('HINT_BASE_PRICE', 'Цена (за единицу) - это цена единицы товара без учёта атрибутов товара');
define('HINT_PRICE_EXCL', 'Цены (без налога) - это цена товара, включающая в себя атрибуты, но без налога');
define('HINT_PRICE_INCL', 'Цена (с налогом) - это цена товара + налог');
define('HINT_TOTAL_EXCL', 'Сумма (без налога) - это цена товара * на количество товара, но без налога.');
define('HINT_TOTAL_INCL', 'Сумма (с налогом) - это цена товара * на количество товара, включая налог.');
//end hints

//new order confirmation email- this is a separate email from order status update
define('ENTRY_SEND_NEW_ORDER_CONFIRMATION', 'Отправить E-Mail:');
define('EMAIL_TEXT_DATE_MODIFIED', 'Дата:');
define('EMAIL_TEXT_PRODUCTS', 'Товары');
define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Адрес доставки');
define('EMAIL_TEXT_BILLING_ADDRESS', 'Адрес покупателя');
define('EMAIL_TEXT_PAYMENT_METHOD', 'Способ оплаты');
// If you want to include extra payment information, enter text below (use <br> for line breaks):
//define('EMAIL_TEXT_PAYMENT_INFO', ''); //why would this be useful???
// If you want to include footer text, enter text below (use <br> for line breaks):
define('EMAIL_TEXT_FOOTER', '');
//end email

//add-on for downloads
define('ENTRY_DOWNLOAD_COUNT', 'Загрузка ');
define('ENTRY_DOWNLOAD_FILENAME', 'Имя файла');
define('ENTRY_DOWNLOAD_MAXDAYS', 'Ссылка активна (дней)');
define('ENTRY_DOWNLOAD_MAXCOUNT', 'Максимум загрузок');

//add-on for Ajax
define('AJAX_CONFIRM_PRODUCT_DELETE', 'Вы действительно хотите удалить данный товар из заказа?');
define('AJAX_CONFIRM_COMMENT_DELETE', 'Вы действительно хотите удалить данный комментарий из истории заказа?');
define('AJAX_MESSAGE_STACK_SUCCESS', 'Выполнено! \' + %s + \' обновлено');
define('AJAX_CONFIRM_RELOAD_TOTALS', 'Вы изменили информацию о доставке. Хотите чтобы были пересчитаны итоговые суммы заказа?');
define('AJAX_CANNOT_CREATE_XMLHTTP', 'Не могу создать XMLHTTP');
define('AJAX_SUBMIT_COMMENT', 'Добавить новые комментарии и/или статус');
define('AJAX_NO_QUOTES', 'Нет информации.');
define('AJAX_SELECTED_NO_SHIPPING', 'Вы выбрали новый способ доставки, хотите чтобы были пересчитаны итоговые суммы заказа?');
define('AJAX_RELOAD_TOTALS', 'Новая единица была добавлена в заказ, но итоговые суммы не были пересчитаны. Нажмите обновить.');
define('AJAX_NEW_ORDER_EMAIL', 'Вы действительно хотите отправить e-mail покупателю с информацией о сделанных изменениях в заказе?');
define('AJAX_INPUT_NEW_EMAIL_COMMENTS', 'Укажите комментарии, либо оставьте поле пустым, если не хотите добавлять комментарии. Нажимая enter, Вы сохраняете введённый текст.');
define('AJAX_SUCCESS_EMAIL_SENT', 'Выполнено! Информация о заказе отправлена %s');
define('AJAX_WORKING', 'Загрузка, пожалуйста, подождите....');

define('EMAIL_ACC_DISCOUNT_INTRO_OWNER', 'Один из ваших клиентов достиг предела накопительной скидки и был переведен в новую группу. ' . "\n\n" . 'Детали:');
define('EMAIL_TEXT_LIMIT', 'Достигнутый предел: ');
define('EMAIL_TEXT_CURRENT_GROUP', 'Новая группа: ');
define('EMAIL_TEXT_DISCOUNT', 'Скидка: ');
define('EMAIL_ACC_SUBJECT', 'Накопительная скидка');
define('EMAIL_ACC_INTRO_CUSTOMER', 'Поздравляем, Вы получили новую накопительную скидку. Все детали ниже:');
define('EMAIL_ACC_FOOTER', 'Теперь Вы можете сэкономить, делая покупки в нашем интернет-магазине.');

define('EMAIL_TEXT_CUSTOMER_NAME', 'Покупатель:');
define('EMAIL_TEXT_CUSTOMER_EMAIL_ADDRESS', 'Email:');
define('EMAIL_TEXT_CUSTOMER_TELEPHONE', 'Телефон:');

define('TEXT_ORDER_COMMENTS', 'Комментарий к заказу');

define('ENTRY_TYPE_BELOW', 'Выберите'); 
define('ERROR_NO_ORDER_SELECTED', 'Вы не выбрали заказ для редактирования, либо не указан ID номер заказа для редактирования.');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Выберите');
define('TYPE_BELOW', 'Выберите ниже');

define('JS_ERROR', 'Ошибки при заполнении формы!\n\nИсправьте пожалуйста:\n\n');

define('JS_GENDER', '* Вы должны указать свой пол.\n');
define('JS_FIRST_NAME', '* Поле Имя должно содержать как минимум ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' символа.\n');
define('JS_LAST_NAME', '* Поле Фамилия должно содержать как минимум ' . ENTRY_LAST_NAME_MIN_LENGTH . ' символа.\n');
define('JS_DOB', '* Дату рождения необходимо вводить в следующем формате: MM/DD/YYYY (пример 05/21/1970)\n');
define('JS_EMAIL_ADDRESS', '* Поле E-Mail должно содержать как минимум ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' символов.\n');
define('JS_ADDRESS', '* Поле Улица и номер дома должно содержать как минимум ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' символов.\n');
define('JS_POST_CODE', '* Поле Почтовый индекс должно содержать как минимум ' . ENTRY_POSTCODE_MIN_LENGTH . ' символа.\n');
define('JS_CITY', '* Поле Город должно содержать как минимум ' . ENTRY_CITY_MIN_LENGTH . ' символа.\n');
define('JS_STATE', '* Поле Район должно быть заполнено.\n');
define('JS_STATE_SELECT', '-- Выберите выше --');
define('JS_ZONE', '* Поле Регион должно быть заполнено.\n');
define('JS_COUNTRY', '* Поле Район должно быть заполнено.\n');
define('JS_TELEPHONE', '* Поле Телефон должно содержать как минимум ' . ENTRY_TELEPHONE_MIN_LENGTH . ' символа.\n');
define('JS_PASSWORD', '* Поле Подтвердите пароль должно совпадать с полем Пароль и должно содержать как минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.\n');

define('CATEGORY_COMPANY', 'Организация');
define('CATEGORY_PERSONAL', 'Ваши персональные данные');
define('CATEGORY_ADDRESS', 'Ваш адрес');
define('CATEGORY_CONTACT', 'Контактная информация');
define('CATEGORY_OPTIONS', 'Рассылка');
define('CATEGORY_PASSWORD', 'Ваш пароль');
define('CATEGORY_CORRECT', 'Если покупатель выбран правильно, нажмите кнопку Подтвердить, которая находится ниже.');
define('ENTRY_CUSTOMERS_ID', 'ID:');
define('ENTRY_CUSTOMERS_ID_TEXT', '&nbsp;<small><font color="red">обязательно</font></small>');
define('ENTRY_COMPANY', 'Название компании:');
define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Пол:');
define('ENTRY_GENDER_ERROR', '&nbsp;<small><font color="red">обязательно</font></small>');
define('ENTRY_GENDER_TEXT', '&nbsp;<small><font color="red">обязательно</font></small>');
define('ENTRY_FIRST_NAME', 'Имя:');
define('ENTRY_FIRST_NAME_ERROR', 'Поле Имя должно содержать как минимум ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' символа.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Фамилия:');
define('ENTRY_LAST_NAME_ERROR', 'Поле Фамилия должно содержать как минимум ' . ENTRY_LAST_NAME_MIN_LENGTH . ' символа.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Дата рождения:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Дату рождения необходимо вводить в следующем формате: MM/DD/YYYY (пример 05/21/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (пример 05/21/1970)');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail:');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Поле E-Mail должно содержать как минимум ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' символов.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Ваш E-Mail адрес указан неправильно, попробуйте ещё раз.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Введённый Вами E-Mail уже зарегистрирован в нашем магазине, попробуйте указать другой E-Mail адрес.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', 'Улица и номер дома:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Поле Улица и номер дома должно содержать как минимум ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' символов.');
define('ENTRY_STREET_ADDRESS_TEXT', '*');
define('ENTRY_SUBURB', 'Район:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Почтовый индекс:');
define('ENTRY_POST_CODE_ERROR', 'Поле Почтовый индекс должно содержать как минимум ' . ENTRY_POSTCODE_MIN_LENGTH . ' символа.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Город:');
define('ENTRY_CITY_ERROR', 'Поле Город должно содержать как минимум ' . ENTRY_CITY_MIN_LENGTH . ' символа.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Область:');
define('ENTRY_STATE_ERROR', 'Поле Область должно содержать как минимум ' . ENTRY_STATE_MIN_LENGTH . ' символа.');
define('ENTRY_STATE_ERROR_SELECT', 'Выберите область.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY', 'Страна:');
define('ENTRY_COUNTRY_ERROR', 'Выберите страну.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Телефон:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Поле Телефон должно содержать как минимум ' . ENTRY_TELEPHONE_MIN_LENGTH . ' символа.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Факс:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Новости магазина:');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'Подписаться');
define('ENTRY_NEWSLETTER_NO', 'Отказаться от подписки');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Пароль:');
define('ENTRY_PASSWORD_ERROR', 'Ваш пароль должен содержать как минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Поле Подтвердите пароль должно совпадать с полем Пароль.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION', 'Подтвердите пароль:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Текущий пароль:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Поле Пароль должно содержать как минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.');
define('ENTRY_PASSWORD_NEW', 'Новый пароль:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Ваш Новый пароль должен содержать как минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Поля Подтвердите пароль и Новый пароль должны совпадать.');
define('PASSWORD_HIDDEN', '--СКРЫТ--');

// manual order box text in includes/boxes/manual_order.php
define('BOX_HEADING_MANUAL_ORDER', 'Создание заказов через админку');
define('BOX_MANUAL_ORDER_CREATE_ACCOUNT', 'Регистрация клиента');
define('BOX_MANUAL_ORDER_CREATE_ORDER', 'Создать заказ');

define('EDIT_ORDER_TAB_CUSTOMER','Покупатель');
define('EDIT_ORDER_TAB_PAYMENT','Оплата');
define('EDIT_ORDER_TAB_PRODUCTS','Товары/Доставка');
define('EDIT_ORDER_TAB_COMMENTS','Комментарии');

define('BUTTON_BACK_TO_ORDER','Вернуться к заказу');
define('BUTTON_BACK_TO_ORDERS_LIST','Вернуться к списку заказов');

?>