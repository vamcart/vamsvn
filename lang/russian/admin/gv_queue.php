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

define('HEADING_TITLE', '��������� ������������');

define('TABLE_HEADING_CUSTOMERS', '����������');
define('TABLE_HEADING_ORDERS_ID', '����� ������');
define('TABLE_HEADING_VOUCHER_VALUE', '����� �����������');
define('TABLE_HEADING_DATE_PURCHASED', '���� �������');
define('TABLE_HEADING_ACTION', '��������');

define('TEXT_REDEEM_COUPON_MESSAGE_HEADER', '�� �������� ���������� � ����� ��������-��������.' . "\n"
                                          . '� ����� ����������� ���������� ������ ���� �������� ���������������, ������ ��� ��� ����� ����� ������������ ��� ���������� ������� � ����� ��������-��������.' . "\n"
                                          . '���� ��������, ��� ��� ���������� �������� ��������������� � �������������. ������ �� ������' . "\n"
                                          . '� ������� ������ ����������� ��������� ������� � ����� ��������-��������, ���� ������ �������� ���� ���������� ����-���� ���.' . "\n\n");

define('TEXT_REDEEM_COUPON_MESSAGE_AMOUNT', '���������� �� ����� %s' . "\n\n");

define('TEXT_REDEEM_COUPON_MESSAGE_BODY', '');
define('TEXT_REDEEM_COUPON_MESSAGE_FOOTER', '');
define('TEXT_REDEEM_COUPON_SUBJECT', '��� ���������� �������� � �������������!');
?>