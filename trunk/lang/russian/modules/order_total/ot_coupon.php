<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_coupon.php 899 2005-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(t_coupon.php,v 1.1.2.2 2003/05/15); www.oscommerce.com

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

  define('MODULE_ORDER_TOTAL_COUPON_TITLE', '�����');
  define('MODULE_ORDER_TOTAL_COUPON_HEADER', '�����������/������');
  define('MODULE_ORDER_TOTAL_COUPON_DESCRIPTION', '�����');
  define('SHIPPING_NOT_INCLUDED', ' [��������� �������� �� ��������]');
  define('TAX_NOT_INCLUDED', ' [����� �� �������]');
  define('MODULE_ORDER_TOTAL_COUPON_USER_PROMPT', '');
  define('ERROR_NO_INVALID_REDEEM_COUPON', '�������� ��� ������');
  define('ERROR_INVALID_STARTDATE_COUPON', '��������� ����� �� ����������');
  define('ERROR_INVALID_FINISDATE_COUPON', '� ������� ������ ���� ���� ��������');
  define('ERROR_INVALID_USES_COUPON', '����� ��� ��� ����������� ');  
  define('TIMES', ' ���.');
  define('ERROR_INVALID_USES_USER_COUPON', '�� ������������ ����� ����������� ��������� ���������� ���.'); 
  define('REDEEMED_COUPON', '����� ������ ');  
  define('REDEEMED_MIN_ORDER', '������ ���� ');  
  define('REDEEMED_RESTRICTIONS', ' [�������� ������ ���������� ���������� �����������]');  
  define('TEXT_ENTER_COUPON_CODE', '��� ���:&nbsp;&nbsp;');
  
  define('MODULE_ORDER_TOTAL_COUPON_STATUS_TITLE', '���������� �����');
  define('MODULE_ORDER_TOTAL_COUPON_STATUS_DESC', '�� ������ ���������� ������� ������?');
  define('MODULE_ORDER_TOTAL_COUPON_SORT_ORDER_TITLE', '������� ����������');
  define('MODULE_ORDER_TOTAL_COUPON_SORT_ORDER_DESC', '������� ���������� ������.');
  define('MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING_TITLE', '��������� ��������');
  define('MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING_DESC', '�������� � ������ ��������.');
  define('MODULE_ORDER_TOTAL_COUPON_INC_TAX_TITLE', '��������� �����');
  define('MODULE_ORDER_TOTAL_COUPON_INC_TAX_DESC', '�������� � ������ �����.');
  define('MODULE_ORDER_TOTAL_COUPON_CALC_TAX_TITLE', '������������� �����');
  define('MODULE_ORDER_TOTAL_COUPON_CALC_TAX_DESC', '������������� �����.');
  define('MODULE_ORDER_TOTAL_COUPON_TAX_CLASS_TITLE', '�����');
  define('MODULE_ORDER_TOTAL_COUPON_TAX_CLASS_DESC', '������������ ����� ��� �������.');
?>