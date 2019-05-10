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

define('NAVBAR_TITLE_1', 'Оформлення замовлення');
define('NAVBAR_TITLE_2', 'Оформлення замовлення');

define('HEADING_TITLE', 'Оформлення замовлення');

// error
define('SHIPPING_ERROR', 'Будь ласка, виберіть спосіб доставки.');
define('PAYMENT_ERROR', 'Будь ласка, виберіть спосіб оплати.');
define('CONDITIONS_ERROR', 'Ви повинні погодитися з умовами.');
// error end

//progess bar
define('SC_PROGRESS_CHECKOUT_PAGE', 'Оформлення замовлення');
define('SC_PROGRESS_CONFIRMATION_PAGE', 'Подтверження замовлення');
//progress bar end

define('TEXT_ORIGIN_LOGIN', 'Якщо Ви наш постійний клієнт, <b> <a href='.FILENAME_LOGIN.'> <u> введіть Ваші персональні дані </u> </a> </b> для входу. Або Ви можете оформити замовлення прямо зараз, заповнивши форму нижче. ');

define('CATEGORY_COMPANY', 'Організація');
define('CATEGORY_PERSONAL', 'Ваші персональні дані');
define('CATEGORY_ADDRESS', 'Ваша адреса');
define('CATEGORY_CONTACT', 'Контактна інформація');
define('CATEGORY_OPTIONS', 'Розсилка');
define('CATEGORY_PASSWORD', 'Ваш пароль');

define('ENTRY_COMPANY', 'Назва компанії:');
define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER', 'Стать:');
define('ENTRY_GENDER_ERROR', 'Ви повинні вказати свою стать.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME', 'Ім\'я:');
define('ENTRY_FIRST_NAME_ERROR', 'Поле Ім\'я повинно містити як мінімум'. ENTRY_FIRST_NAME_MIN_LENGTH. 'символу.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME', 'Прізвище:');
define('ENTRY_LAST_NAME_ERROR', 'Поле прізвище повинно містити як мінімум'. ENTRY_LAST_NAME_MIN_LENGTH. 'символів.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH', 'Дата народження:');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Дату народження необхідно вводити в такому форматі: DD / MM / YYYY (приклад 21/05/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (приклад 21/05/1970)');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail:');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Поле E-Mail повинно містити як мінімум'. ENTRY_EMAIL_ADDRESS_MIN_LENGTH. 'символів.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Ваша E-Mail адреса вказана неправильно, спробуйте ще раз.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Ваш E-Mail вже зареєстрований в нашому магазині, спробуйте вказати іншу E-Mail адресу.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS', 'Адреса:');
define('ENTRY_STREET_ADDRESS_ERROR', 'Поле Вулиця та номер будинку повинно містити як мінімум'. ENTRY_STREET_ADDRESS_MIN_LENGTH. 'символів.');
define('ENTRY_STREET_ADDRESS_TEXT', '* Приклад: вул. Незалежності 346, кв. 78');
define('ENTRY_SC_STREET_ADDRESS_TEXT', 'Приклад: вул. Незалежності 346, кв. 78');
define('ENTRY_SUBURB', 'Район:');
define('ENTRY_SUBURB_ERROR', '');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE', 'Поштовий індекс:');
define('ENTRY_POST_CODE_ERROR', 'Поле Поштовий індекс має містити як мінімум'. ENTRY_POSTCODE_MIN_LENGTH. 'символів.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY', 'Місто:');
define('ENTRY_CITY_ERROR', 'Поле Місто повинно містити як мінімум'. ENTRY_CITY_MIN_LENGTH. 'символів.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE', 'Регіон:');
define('ENTRY_STATE_ERROR', 'Поле Область має містити як мінімум'. ENTRY_STATE_MIN_LENGTH. 'символів.');
define('ENTRY_STATE_ERROR_SELECT', 'Виберіть область.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY', 'Країна:');
define('ENTRY_COUNTRY_ERROR', 'Виберіть країну.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER', 'Телефон:');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Поле Телефон має містити як мінімум'. ENTRY_TELEPHONE_MIN_LENGTH. 'символів.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER', 'Факс:');
define('ENTRY_FAX_NUMBER_ERROR', '');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER', 'Отримувати інформацію про знижки, призи, подарунки:');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_NEWSLETTER_YES', 'Підписатися');
define('ENTRY_NEWSLETTER_NO', 'Відмовитися від підписки');
define('ENTRY_NEWSLETTER_ERROR', '');
define('ENTRY_PASSWORD', 'Пароль:');
define('ENTRY_PASSWORD_ERROR', 'Ваш пароль повинен містити як мінімум'. ENTRY_PASSWORD_MIN_LENGTH. 'символів.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Поле Підтвердіть пароль має збігатися з полем Пароль.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION', 'Підтвердіть пароль:');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT', 'Поточний пароль:');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Поле Пароль має містити як мінімум'. ENTRY_PASSWORD_MIN_LENGTH. 'символів.');
define('ENTRY_PASSWORD_NEW', 'Новий пароль:');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Ваш Новий пароль повинен містити як мінімум'. ENTRY_PASSWORD_MIN_LENGTH. 'символів.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Поля Підтвердіть пароль і Новий пароль повинні збігатися.');
define('PASSWORD_HIDDEN', '--СКРИТ--');
define('FORM_REQUIRED_INFORMATION', '* обов\'язково до заповнення');


//site content
define('TEXT_SHIPPING_SAME_AS_PAYMENT', 'Адреса покупця збігається з адресою доставки.');
define('TEXT_NO_SHIPPING_AVAILABLE', 'Немає доступних способів доставки для обраної країни.');
define('SC_TEXT_REDIRECT', 'Зараз Ви будете перенаправлені на сайт платіжної системи для оплати замовлення.');
define('SC_ERROR_NO_SHIPPING_POSSIBLE', 'Доставка недоступна в обрану країну.');
//site content end

//buttons
define('IMAGE_BUTTON_CONFIRMATION_PAGE', 'Продовжити');
//buttons end

//Start Conditions of use
define('SC_CONDITION', 'Я прочитала ');
define('SC_CONDITION_END', ' і згодна з ними: ');

define('SC_HEADING_CONDITIONS', '<strong>правила та умови</strong>');
//End Conditions of use

define('TEXT_DISCOUNT_CODE', 'Код купона або подарункового сертифіката');

// Account optional
define('TEXT_CREATE_ACCOUNT_OPTIONAL', 'Я не хочу реєструвати аккаунт.');

// Account creation
define('SC_HEADING_CREATE_ACCOUNT', 'Реєстрація аккаунта');
define('SC_HEADING_CREATE_ACCOUNT_INFORMATION', 'Інформація');
define('SC_TEXT_VIRTUAL_PRODUCT', 'Для завантаження скачуваних товарів Ви повинні зареєструвати акаунт!');
define('SC_TEXT_PASSWORD_REQUIRED', 'Ваш пароль для входу буде згенерований автоматично і відправлений на зазначений Е-mail.');

// email specific
define('EMAIL_USERNAME', 'Email:'. stripslashes($_POST['email_address']). "\n \n");
define('EMAIL_PASSWORD', 'Пароль:'. stripslashes($_POST['password']). "\n \n");

// CHECKOUT_SHIPPING

define('TABLE_HEADING_SHIPPING_ADDRESS', 'Адреса доставки');
define('TEXT_CHOOSE_SHIPPING_DESTINATION', 'Якщо Ви хочете змінити поточний адресу доставки, натисніть кнопку Змінити адресу, якщо поточний адресу доставки правильний, вибирайте найбільш зручний для Вас спосіб доставки і продовжуйте оформляти замовлення.');
define('TITLE_SHIPPING_ADDRESS', 'Поточна адреса доставки:');
define('TABLE_HEADING_SHIPPING_METHOD', 'Спосіб доставки');
define('TEXT_CHOOSE_SHIPPING_METHOD', 'Доступні способи доставки замовлення.');
define('TITLE_PLEASE_SELECT', 'Виберіть');
define('TEXT_ENTER_SHIPPING_INFORMATION', 'На даний момент доступний єдиний спосіб доставки:');

define('TABLE_HEADING_COMMENTS', 'Коментарі до Вашого замовлення');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Продовжити оформлення замовлення');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', 'Далі Вам потрібно буде вибрати відповідний спосіб оплати замовлення.');

define('TEXT_ENTER_SHIPPING_NO_METHOD', 'Немає доступних способів доставки.');

// CHECKOUT_PAYMENT

define('TABLE_HEADING_BILLING_ADDRESS', 'Адреса покупця');
define('TEXT_SELECTED_BILLING_DESTINATION', 'Будь ласка, виберіть адресу з Вашої адресної книги. Адреса покупця необхідний в разі втрати замовлення при доставці на адресу, яку Ви вказали раніше.');
define('TITLE_BILLING_ADDRESS', 'Поточна адреса:');
define('TABLE_HEADING_PAYMENT_METHOD', 'Спосіб оплати');
define('TEXT_SELECT_PAYMENT_METHOD', 'Доступні способи оплати замовлення.');
define('TITLE_PLEASE_SELECT', 'Виберіть бажаний спосіб');
define('TEXT_ENTER_PAYMENT_INFORMATION', 'На даний момент доступний єдиний спосіб оплати замовлення, продовжуйте оформляти замовлення:');
define('TABLE_HEADING_COMMENTS', 'Коментарі до Вашого замовлення');
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Продовжити оформлення замовлення');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', 'Далі Вам потрібно буде підтвердити своє замовлення.');

// CHECKOUT_CONFIRMATION

define('HEADING_DELIVERY_ADDRESS', 'Адреса доставки');
define('HEADING_SHIPPING_METHOD', 'Спосіб доставки');
define('HEADING_PRODUCTS', 'Товар');
define('HEADING_TAX', 'Податки');
define('HEADING_TOTAL', 'Сума');
define('HEADING_BILLING_INFORMATION', 'Інформація про оплату замовлення');
define('HEADING_BILLING_ADDRESS', 'Адреса покупця');
define('HEADING_PAYMENT_METHOD', 'Спосіб оплати');
define('HEADING_PAYMENT_INFORMATION', 'Інформація про оплату');
define('HEADING_ORDER_COMMENTS', 'Ваші коментарі');
define('TEXT_EDIT', 'Змінити');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Продовжити оформлення замовлення');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', 'Для завершення процедури оформлення замовлення, Ви повинні підтвердити своє замовлення.');