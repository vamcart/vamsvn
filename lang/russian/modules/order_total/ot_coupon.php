<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_coupon.php 899 2007/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_coupon.php,v 1.1.2.2 2003/05/15); www.oscommerce.com
   (c) 2004	 xt:Commerce (ot_coupon.php,v 1.1.2.2 2003/05/15); xt-commerce.com

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

  define('MODULE_ORDER_TOTAL_COUPON_TITLE', 'Купон');
  define('MODULE_ORDER_TOTAL_COUPON_HEADER', 'Сертификаты/Купоны');
  define('MODULE_ORDER_TOTAL_COUPON_DESCRIPTION', 'Купон');
  define('SHIPPING_NOT_INCLUDED', ' [Стоимость доставки не включена]');
  define('TAX_NOT_INCLUDED', ' [Налог не включён]');
  define('MODULE_ORDER_TOTAL_COUPON_USER_PROMPT', '');
  define('ERROR_NO_INVALID_REDEEM_COUPON', 'Неверный код купона');
  define('ERROR_INVALID_STARTDATE_COUPON', 'Указанный купон не существует');
  define('ERROR_INVALID_FINISDATE_COUPON', 'У данного купона истёк срок действия');
  define('ERROR_INVALID_USES_COUPON', 'Купон уже был использован ');  
  define('TIMES', ' раз.');
  define('ERROR_INVALID_USES_USER_COUPON', 'Вы использовали купон максимально возможное количество раз.'); 
  define('REDEEMED_COUPON', 'сумма купона ');  
  define('REDEEMED_MIN_ORDER', 'заказы выше ');  
  define('REDEEMED_RESTRICTIONS', ' [Действие купона ограничено следующими категориями]');  
  define('TEXT_ENTER_COUPON_CODE', 'Ваш код:&nbsp;&nbsp;');
  
  define('MODULE_ORDER_TOTAL_COUPON_STATUS_TITLE', 'Показывать всего');
  define('MODULE_ORDER_TOTAL_COUPON_STATUS_DESC', 'Вы хотите показывать номинал купона?');
  define('MODULE_ORDER_TOTAL_COUPON_SORT_ORDER_TITLE', 'Порядок сортировки');
  define('MODULE_ORDER_TOTAL_COUPON_SORT_ORDER_DESC', 'Порядок сортировки модуля.');
  define('MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING_TITLE', 'Учитывать доставку');
  define('MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING_DESC', 'Включать в расчёт доставку.');
  define('MODULE_ORDER_TOTAL_COUPON_INC_TAX_TITLE', 'Учитывать налог');
  define('MODULE_ORDER_TOTAL_COUPON_INC_TAX_DESC', 'Включать в расчёт налог.');
  define('MODULE_ORDER_TOTAL_COUPON_CALC_TAX_TITLE', 'Пересчитывать налог');
  define('MODULE_ORDER_TOTAL_COUPON_CALC_TAX_DESC', 'Пересчитывать налог.');
  define('MODULE_ORDER_TOTAL_COUPON_TAX_CLASS_TITLE', 'Налог');
  define('MODULE_ORDER_TOTAL_COUPON_TAX_CLASS_DESC', 'Использовать налог для купонов.');
?>