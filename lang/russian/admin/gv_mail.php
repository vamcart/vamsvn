<?php
/* -----------------------------------------------------------------------------------------
   $Id: gv_mail.php 899 2006-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(gv_mail.php,v 1.5.2.2 2003/04/27); www.oscommerce.com

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

define('HEADING_TITLE', '��������� ���������� ���������� ��������');

define('TEXT_CUSTOMER', '������:');
define('TEXT_SUBJECT', '����:');
define('TEXT_FROM', '��:');
define('TEXT_TO', '����:');
define('TEXT_AMOUNT', '����� �����������');
define('TEXT_MESSAGE', '���������:');
define('TEXT_SINGLE_EMAIL', '<span class="smallText">����������� ������ ����, ����� ��������� ���������� � �� ������ E-Mail ������, ������� ��� � ������ ����.</span>');
define('TEXT_SELECT_CUSTOMER', '�������� �������');
define('TEXT_ALL_CUSTOMERS', '��� �������');
define('TEXT_NEWSLETTER_CUSTOMERS', '���� ����������� �������� ��������');

define('NOTICE_EMAIL_SENT_TO', '�����������: E-Mail ���������: %s');
define('ERROR_NO_CUSTOMER_SELECTED', '������: �� �� ������� �������.');
define('ERROR_NO_AMOUNT_SELECTED', '������: �� �� ������� ����� �����������.');

define('TEXT_GV_WORTH', '���������� �� ����� ');
define('TEXT_TO_REDEEM', '����� �������������� ����������, ������� �� ������ ���� � ������� ��� ����������� - ');
define('TEXT_WHICH_IS', '');
define('TEXT_IN_CASE', ' � ������ ���� � ��� ��������� � ���� ���������.');
define('TEXT_OR_VISIT', '��� ������� ��� ��������-������� �� ������ ');
define('TEXT_ENTER_CODE', ' � ������� ��� ����������� ������� ��� ���������� ������');

define ('TEXT_REDEEM_COUPON_MESSAGE_HEADER', '�� �������������� ���� ����������, �� ��� ����� ����� ������������ ��� ���������� ������� ������ ����� �������� ��������������� ��������, ��� ������� ������������� � ����� ������������. ��� ������ ���������� ����� �������� ���������������. �� �������� ����������� �� E-Mail.');
define ('TEXT_REDEEM_COUPON_MESSAGE_AMOUNT', "\n\n" . '���������� �� ����� %s');
define ('TEXT_REDEEM_COUPON_MESSAGE_BODY', "\n\n" . '�� ������ ��������� ���� ���������� ��� ����� ����� ����������� ����� �������� � �������.');
define ('TEXT_REDEEM_COUPON_MESSAGE_FOOTER', "\n\n");

?>