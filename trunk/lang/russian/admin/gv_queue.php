<?php
/* -----------------------------------------------------------------------------------------
   $Id: gv_queue.php 899 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(gv_queue.php,v 1.2.2.1 2003/04/27); www.oscommerce.com
   (c) 2004	 xt:Commerce (gv_queue.php,v 1.2.2.1 2003/04/27); xt-commerce.com

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

define('HEADING_TITLE', 'Активация сертификатов');

define('TABLE_HEADING_CUSTOMERS', 'Покупатель');
define('TABLE_HEADING_ORDERS_ID', 'Номер заказа');
define('TABLE_HEADING_VOUCHER_VALUE', 'Сумма сертификата');
define('TABLE_HEADING_DATE_PURCHASED', 'Дата покупки');
define('TABLE_HEADING_ACTION', 'Действие');

define('TEXT_REDEEM_COUPON_MESSAGE_HEADER', 'Вы покупали сертификат в нашем интернет-магазине.' . "\n"
                                          . 'В целях безопасноти сертификат должен быть проверен администратором, прежде чем его можно будет использовать для совершения покупок в нашем интернет-магазине.' . "\n"
                                          . 'Рады сообщить, что Ваш сертификат проверен администратором и активизирован. Теперь Вы можете' . "\n"
                                          . 'с помощью своего сертификата совершать покупки в нашем интернет-магазине, либо можете подарить свой сертификат кому-либо ещё.' . "\n\n");

define('TEXT_REDEEM_COUPON_MESSAGE_AMOUNT', 'Сертификат на сумму %s' . "\n\n");

define('TEXT_REDEEM_COUPON_MESSAGE_BODY', '');
define('TEXT_REDEEM_COUPON_MESSAGE_FOOTER', '');
define('TEXT_REDEEM_COUPON_SUBJECT', 'Ваш сертификат проверен и активизирован!');
?>