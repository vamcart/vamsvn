<?php
/* -----------------------------------------------------------------------------------------
   $Id: checkout.php 1260 2012/08/09 13:25:47 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(german.php,v 1.119 2003/05/19); www.oscommerce.com
   (c) 2003  nextcommerce (german.php,v 1.25 2003/08/25); www.nextcommerce.org
   (c) 2004	 xt:Commerce (russian.php,v 1.25 2003/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('NAVBAR_TITLE_1', 'Checkout');
define('NAVBAR_TITLE_2', 'Checkout');

define('HEADING_TITLE', 'Checkout');

//error
define('SHIPPING_ERROR', 'Please select a shipping method.');
define('PAYMENT_ERROR', 'Please select a payment method.');
define('CONDITIONS_ERROR', 'Please agree to our Terms and Conditions Agreement.');
//error end


//progess bar
define('SC_PROGRESS_CHECKOUT_PAGE', 'Checkout');
define('SC_PROGRESS_CONFIRMATION_PAGE', 'Order Confirmation');
//progress bar end


//site content
define('TEXT_SHIPPING_SAME_AS_PAYMENT', 'Billing address is the same as shipping address.');
define('TEXT_NO_SHIPPING_AVAILABLE', 'No shipping available to the selected country.');
define('SC_TEXT_REDIRECT', 'You will be redirected to payment page.');
define('SC_ERROR_NO_SHIPPING_POSSIBLE', 'No shipping available to the selected country.');

//site content end

//buttons
define('IMAGE_BUTTON_CONFIRMATION_PAGE', 'Go to confirmation page');
//buttons end



//Start Conditions of use
define('SC_CONDITION', 'I have read the ');
define('SC_CONDITION_END', ' and I agree to them: ');

define('SC_HEADING_CONDITIONS', '<strong>Terms and Conditions Agreement</strong>');
//End Conditions of use


//Account optional
define('TEXT_CREATE_ACCOUNT_OPTIONAL', 'I do not want to create an account.');

//Account creation
define('SC_HEADING_CREATE_ACCOUNT', 'Create account');
define('SC_HEADING_CREATE_ACCOUNT_INFORMATION', 'Account Information');
define('SC_TEXT_VIRTUAL_PRODUCT', 'You need to create an account in order to download virtual products!');
define('SC_TEXT_PASSWORD_REQUIRED', 'You need to create an account in order to purchase products!');


//email specific
define('EMAIL_USERNAME', 'Your username is: ' . stripslashes($_POST['email_address']) . "\n\n");
define('EMAIL_PASSWORD', 'Your password is: ' . stripslashes($_POST['password']) . "\n\n");

// CHECKOUT_SHIPPING

define('NAVBAR_TITLE_1', 'Оформление заказа');
define('NAVBAR_TITLE_2', 'Способ доставки');

define('HEADING_TITLE', 'Информация о доставке заказа');

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

define('NAVBAR_TITLE_1', 'Оформление заказа');
define('NAVBAR_TITLE_2', 'Способ оплаты заказа');

define('HEADING_TITLE', 'Способ оплаты заказа');

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

define('NAVBAR_TITLE_1', 'Оформление заказа');
define('NAVBAR_TITLE_2', 'Подтвердить');

define('HEADING_TITLE', 'Подтверждение заказа!');

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
