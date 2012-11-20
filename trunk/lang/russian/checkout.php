<?php
/* -----------------------------------------------------------------------------------------
   $Id: checkout.php 867 2012-11-20 19:20:03 oleg_vamsoft $

   VamShop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2012 VamShop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(address_book.php,v 1.57 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (address_book.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (address_book.php,v 1.14 2003/08/17); xt-commerce.com
   (c) 2012	 STRUB

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('NAVBAR_TITLE_1', 'Оформление заказа');
define('NAVBAR_TITLE_2', 'Оформление заказа');

define('HEADING_TITLE', 'Оформление заказа');

//error
define('SHIPPING_ERROR', 'Пожалуйста, выберите способ доставки.');
define('PAYMENT_ERROR', 'Пожалуйста, выберите способ оплаты.');
define('CONDITIONS_ERROR', 'Вы должны согласиться с условиями.');
//error end


//progess bar
define('SC_PROGRESS_CHECKOUT_PAGE', 'Оформление заказа');
define('SC_PROGRESS_CONFIRMATION_PAGE', 'Подтверждение заказа');
//progress bar end

define('TEXT_ORIGIN_LOGIN', 'Если Вы наш постоянный клиент, <b><a href='.FILENAME_LOGIN.'><u> введите Ваши персональные данные</u></a></b> для входа. Либо Вы можете оформить  заказ прямо сейчас, заполнив форму ниже.');

define('CATEGORY_COMPANY', 'Организация');
define('CATEGORY_PERSONAL', 'Ваши персональные данные');
define('CATEGORY_ADDRESS', 'Ваш адрес');
define('CATEGORY_CONTACT', 'Контактная информация');
define('CATEGORY_OPTIONS', 'Рассылка');
define('CATEGORY_PASSWORD', 'Ваш пароль');

define('ENTRY_COMPANY', 'Название компании:');
define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Пол:');
define('ENTRY_GENDER_ERROR', 'Вы должны указать свой пол.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'Имя:');
define('ENTRY_FIRST_NAME_ERROR', 'Поле Имя должно содержать как минимум ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' символа.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Фамилия:');
define('ENTRY_LAST_NAME_ERROR', 'Поле Фамилия должно содержать как минимум ' . ENTRY_LAST_NAME_MIN_LENGTH . ' символа.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Дата рождения:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Дату рождения необходимо вводить в следующем формате: DD/MM/YYYY (пример 21/05/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (пример 21/05/1970)');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail:');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Поле E-Mail должно содержать как минимум ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' символов.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Ваш E-Mail адрес указан неправильно, попробуйте ещё раз.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Введённый Вами E-Mail уже зарегистрирован в нашем магазине, попробуйте указать другой E-Mail адрес.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', 'Адрес:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Поле Улица и номер дома должно содержать как минимум ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' символов.');
define('ENTRY_STREET_ADDRESS_TEXT', '* Пример: ул. Мира 346, кв. 78');
define('ENTRY_SC_STREET_ADDRESS_TEXT', 'Пример: ул. Мира 346, кв. 78');
define('ENTRY_SUBURB', 'Район:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Почтовый индекс:');
define('ENTRY_POST_CODE_ERROR', 'Поле Почтовый индекс должно содержать как минимум ' . ENTRY_POSTCODE_MIN_LENGTH . ' символа.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Город:');
define('ENTRY_CITY_ERROR', 'Поле Город должно содержать как минимум ' . ENTRY_CITY_MIN_LENGTH . ' символа.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Регион:');
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
define('ENTRY_NEWSLETTER', 'Получать информацию о скидках, призах, подарках:');
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

define('FORM_REQUIRED_INFORMATION', '* Обязательно для заполнения');

//site content
define('TEXT_SHIPPING_SAME_AS_PAYMENT', 'Адрес покупателя совпадает с адресом доставки.');
define('TEXT_NO_SHIPPING_AVAILABLE', 'Нет доступных способов доставки для выбранной страны.');
define('SC_TEXT_REDIRECT', 'Сейчас Вы будете перенаправлены на сайт платёжной системы для оплаты заказа.');
define('SC_ERROR_NO_SHIPPING_POSSIBLE', 'Доставка недоступна в выбранную страну.');

//site content end

//buttons
define('IMAGE_BUTTON_CONFIRMATION_PAGE', 'Продолжить');
//buttons end

//Start Conditions of use
define('SC_CONDITION', 'Я прочитал ');
define('SC_CONDITION_END', ' и согласен с ними: ');

define('SC_HEADING_CONDITIONS', '<strong>правила и условия</strong>');
//End Conditions of use

define('TEXT_DISCOUNT_CODE', 'Код купона или подарочного сертификата');

//Account optional
define('TEXT_CREATE_ACCOUNT_OPTIONAL', 'Я не хочу регистрировать аккаунт.');

//Account creation
define('SC_HEADING_CREATE_ACCOUNT', 'Регистрация аккаунта');
define('SC_HEADING_CREATE_ACCOUNT_INFORMATION', 'Информация');
define('SC_TEXT_VIRTUAL_PRODUCT', 'Для загрузки скачиваемых товаров Вы должны зарегистрировать аккаунт!');
define('SC_TEXT_PASSWORD_REQUIRED', 'Вы должны зарегистрировать аккаунт для оформления заказа!');

//email specific
define('EMAIL_USERNAME', 'Email: ' . stripslashes($_POST['email_address']) . "\n\n");
define('EMAIL_PASSWORD', 'Пароль: ' . stripslashes($_POST['password']) . "\n\n");

// CHECKOUT_SHIPPING

define('TABLE_HEADING_SHIPPING_ADDRESS', 'Адрес доставки');
define('TEXT_CHOOSE_SHIPPING_DESTINATION', 'Если Вы хотите изменить текущий адрес доставки, нажмите кнопку Изменить адрес, если текущий адрес доставки правильный, выбирайте наиболее подходящий Вам способ доставки и продолжайте оформлять заказ.');
define('TITLE_SHIPPING_ADDRESS', 'Текущий адрес доставки:');

define('TABLE_HEADING_SHIPPING_METHOD', 'Способ доставки');
define('TEXT_CHOOSE_SHIPPING_METHOD', 'Доступные способы доставки заказа.');
define('TITLE_PLEASE_SELECT', 'Выберите');
define('TEXT_ENTER_SHIPPING_INFORMATION', 'На данный момент доступен единственный способ доставки:');

define('TABLE_HEADING_COMMENTS', 'Комментарии к Вашему заказу');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Продолжить оформление заказа');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', 'Далее Вам нужно будет выбрать подходящий способ оплаты заказа.');

define('TEXT_ENTER_SHIPPING_NO_METHOD','Нет доступных способов доставки.');

// CHECKOUT_PAYMENT

define('TABLE_HEADING_BILLING_ADDRESS', 'Адрес покупателя');
define('TEXT_SELECTED_BILLING_DESTINATION', 'Пожалуйста, выберите адрес из Вашей адресной книги. Адрес покупателя необходим в случае потери заказа при доставке на адрес, который Вы указали ранее.');
define('TITLE_BILLING_ADDRESS', 'Текущий адрес:');

define('TABLE_HEADING_PAYMENT_METHOD', 'Способ оплаты');
define('TEXT_SELECT_PAYMENT_METHOD', 'Доступные способы оплаты заказа.');
define('TITLE_PLEASE_SELECT', 'Выберите предпочтительный способ');
define('TEXT_ENTER_PAYMENT_INFORMATION', 'На данный момент доступен единственный способ оплаты заказа, продолжайте оформлять заказ:');

define('TABLE_HEADING_COMMENTS', 'Комментарии к Вашему заказу');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Продолжить оформление заказа');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', 'Далее Вам нужно будет подтвердить свой заказ.');

// CHECKOUT_CONFIRMATION

define('HEADING_DELIVERY_ADDRESS', 'Адрес доставки');
define('HEADING_SHIPPING_METHOD', 'Способ доставки');
define('HEADING_PRODUCTS', 'Товар');
define('HEADING_TAX', 'Налоги');
define('HEADING_TOTAL', 'Сумма');
define('HEADING_BILLING_INFORMATION', 'Информация об оплате заказа');
define('HEADING_BILLING_ADDRESS', 'Адрес покупателя');
define('HEADING_PAYMENT_METHOD', 'Способ оплаты');
define('HEADING_PAYMENT_INFORMATION', 'Информация об оплате');
define('HEADING_ORDER_COMMENTS', 'Ваши комментарии');

define('TEXT_EDIT', 'Изменить');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Продолжить оформление заказа');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', 'Для завершения процедуры оформления заказа, Вы должны подтвердить свой заказ.');
