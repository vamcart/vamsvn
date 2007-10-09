<?php
/* -----------------------------------------------------------------------------------------
   $Id: gv_mail.php 899 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(gv_mail.php,v 1.5.2.2 2003/04/27); www.oscommerce.com
   (c) 2004	 xt:Commerce (gv_mail.php,v 1.5.2.2 2003/04/27); xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

define('HEADING_TITLE', 'Отправить подарочный сертификат клиентам');

define('TEXT_CUSTOMER', 'Клиент:');
define('TEXT_SUBJECT', 'Тема:');
define('TEXT_FROM', 'От:');
define('TEXT_TO', 'Кому:');
define('TEXT_AMOUNT', 'Сумма сертификата');
define('TEXT_MESSAGE', 'Сообщение:');
define('TEXT_SINGLE_EMAIL', '<span class="smallText">Используйте данное поле, чтобы отправить сертификат и на другие E-Mail адреса, которых нет в списке выше.</span>');
define('TEXT_SELECT_CUSTOMER', 'Выберите клиента');
define('TEXT_ALL_CUSTOMERS', 'Все клиенты');
define('TEXT_NEWSLETTER_CUSTOMERS', 'Всем подписчикам рассылки магазина');

define('NOTICE_EMAIL_SENT_TO', 'Уведомление: E-Mail отправлен: %s');
define('ERROR_NO_CUSTOMER_SELECTED', 'Ошибка: Вы не выбрали клиента.');
define('ERROR_NO_AMOUNT_SELECTED', 'Ошибка: Вы не указали сумму сертификата.');

define('TEXT_GV_WORTH', 'Сертификат на сумму ');
define('TEXT_TO_REDEEM', 'Чтобы активизировать сертификат, нажмите на ссылку ниже и укажите код сертификата - ');
define('TEXT_WHICH_IS', '');
define('TEXT_IN_CASE', ' в случае если у Вас возникнут с этим трудности.');
define('TEXT_OR_VISIT', 'или посетив наш интернет-магазин по адресу ');
define('TEXT_ENTER_CODE', ' и введите код Подарочного Ваучера при оформлении заказа');

define ('TEXT_REDEEM_COUPON_MESSAGE_HEADER', 'Вы активизировали свой сертификат, но его можно будет использовать при совершении покупок только после проверки администратором магазина, это сделано исключительно в целях безопасности. Как только сертификат будет проверен администратором. Вы получите уведомление на E-Mail.');
define ('TEXT_REDEEM_COUPON_MESSAGE_AMOUNT', "\n\n" . 'Сертификат на сумму %s');
define ('TEXT_REDEEM_COUPON_MESSAGE_BODY', "\n\n" . 'Вы можете отправить свой сертификат или часть суммы сертификата своим знакомым и друзьям.');
define ('TEXT_REDEEM_COUPON_MESSAGE_FOOTER', "\n\n");

?>