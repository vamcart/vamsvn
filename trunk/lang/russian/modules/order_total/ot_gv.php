<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_gv.php 899 2007/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_gv.php,v 1.1.2.1 2003/05/15); www.oscommerce.com
   (c) 2004	 xt:Commerce (ot_gv.php,v 1.1.2.1 2003/05/15); xt-commerce.com

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

  define('MODULE_ORDER_TOTAL_GV_TITLE', 'Сертификат');
  define('MODULE_ORDER_TOTAL_GV_HEADER', 'Сертификаты/Купоны');
  define('MODULE_ORDER_TOTAL_GV_DESCRIPTION', 'Подарочные сертификаты');
  define('SHIPPING_NOT_INCLUDED', ' [Стоимость доставки не включена]');
  define('TAX_NOT_INCLUDED', ' [Налог не включён]');
  define('MODULE_ORDER_TOTAL_GV_USER_PROMPT', 'Использовать сертификат:&nbsp;');
  define('TEXT_ENTER_GV_CODE', 'Код сертификата&nbsp;&nbsp;');
  
  define('MODULE_ORDER_TOTAL_GV_STATUS_TITLE', 'Показывать всего');
  define('MODULE_ORDER_TOTAL_GV_STATUS_DESC', 'Вы хотите показывать номинал подарочного сертификата?');
  define('MODULE_ORDER_TOTAL_GV_SORT_ORDER_TITLE', 'Порядок сортировки');
  define('MODULE_ORDER_TOTAL_GV_SORT_ORDER_DESC', 'Порядок сортировки модуля.');
  define('MODULE_ORDER_TOTAL_GV_QUEUE_TITLE', 'Активация сертификатов');
  define('MODULE_ORDER_TOTAL_GV_QUEUE_DESC', 'Вы хотите вручную активировать купленные подарочные сертификаты?');
  define('MODULE_ORDER_TOTAL_GV_INC_SHIPPING_TITLE', 'Учитывать доставку');
  define('MODULE_ORDER_TOTAL_GV_INC_SHIPPING_DESC', 'Включать в расчёт доставку.');
  define('MODULE_ORDER_TOTAL_GV_INC_TAX_TITLE', 'Учитывать налог');
  define('MODULE_ORDER_TOTAL_GV_INC_TAX_DESC', 'Включать в расчёт налог.');
  define('MODULE_ORDER_TOTAL_GV_CALC_TAX_TITLE', 'Пересчитывать налог');
  define('MODULE_ORDER_TOTAL_GV_CALC_TAX_DESC', 'Пересчитывать налог.');
  define('MODULE_ORDER_TOTAL_GV_TAX_CLASS_TITLE', 'Налог');
  define('MODULE_ORDER_TOTAL_GV_TAX_CLASS_DESC', 'Использовать налог.');
  define('MODULE_ORDER_TOTAL_GV_CREDIT_TAX_TITLE', 'Налог сертификата');
  define('MODULE_ORDER_TOTAL_GV_CREDIT_TAX_DESC', 'Добавлять налог к купленным подарочным сертификатам.');
  define('MODULE_ORDER_TOTAL_GV_ORDER_STATUS_ID_TITLE', 'Статус заказа');
  define('MODULE_ORDER_TOTAL_GV_ORDER_STATUS_ID_DESC', 'Заказы, оформленные с использованием подарочного сертификата, покрывающего полную стоимость заказа, будут иметь указанный статус.');
?>