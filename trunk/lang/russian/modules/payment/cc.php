<?php
/*------------------------------------------------------------------------------
  $Id: cc.php 1003 2007/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
  -----------------------------------------------------------------------------
  based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cc.php,v 1.28 2003/02/14); www.oscommerce.com
   (c) 2003	 nextcommerce (cc.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (cc.php,v 1.4 2003/08/13); xt-commerce.com

  Released under the GNU General Public License
------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_CC_TEXT_TITLE', '������ ��������� ���������');
  define('MODULE_PAYMENT_CC_TEXT_DESCRIPTION', '���������� � ��������� �������� ��� �����:<br><br>����� ��������: 4111111111111111<br>������������� ��: ����� ����');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_TYPE', '��� ��������� ��������:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_OWNER', '�������� ��������� ��������:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_NUMBER', '����� ��������� ��������:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_START', '���� ������:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_EXPIRES', '������������� ��:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_ISSUE', '���������� ����� ��������:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_CVV', '3 ��� 4 ������� ��� cvv:');      
  define('MODULE_PAYMENT_CC_TEXT_JS_CC_OWNER', '* ���� �������� ��������� �������� ������ ��������� ��� ������� ' . CC_OWNER_MIN_LENGTH . ' ��������.\n');
  define('MODULE_PAYMENT_CC_TEXT_JS_CC_NUMBER', '* ���� ����� ��������� �������� ������ ��������� ��� ������� ' . CC_NUMBER_MIN_LENGTH . ' ��������.\n');
  define('MODULE_PAYMENT_CC_TEXT_ERROR', '������!');
  define('TEXT_CARD_NOT_ACZEPTED','��������, �� �� �� ��������� ��������� �������� <b>%s</b>, ����������� ������ ��� ��������� ��������!<br />�� ��������� � ������ ��������� ��������� ��������: ');
  define('MODULE_PAYMENT_CC_TEXT_JS_CC_CVV', 'CVV ��� ������ ���� ����������� ������.\n ��� ���� ����� �������� ������.\n CVV ��� - ��� 3- ��� 4- (�������� American Express) ������� ��� �� ����� ��������� ��������.');
  define('MODULE_PAYMENT_CC_TEXT_CVV_LINK', '<u>[����� ������?]</u>');
  define('HEADING_CVV', '������');
  define('TEXT_CVV', '<span class="bold">�������� Visa, Mastercard, Discover ����� ���������� ��� �����������</span><br />��� ����� �����������, �� ������� � ������������ ������� ��������� ������ ���. ��� ����������� - ��� ���������� �����, ������������ �� �������� ������� ����� ��������. �� ��������� ������ ������ ��������� ��������.<br /><img src="images/cv_card.gif" alt="" /><br /><span class="bold">�������� American Express ����� 4 ������� ���</span><br />��� ����� �����������, �� ������� � ������������ ������� ��������� ������ ���. ��� ����������� - ��� ������������� �����, ������������ �� ��������. �� ��������� ���� � ������ ������ ��������� ��������.<br /><img src="images/cv_amex_card.gif" alt="" /><br />');
  define('TEXT_CLOSE_WINDOW', '<u>������� ����</u> [x]');
    define('MODULE_PAYMENT_CC_ACCEPTED_CARDS','�� ��������� � ������ ��������� ��������� ��������:');
  define('MODULE_PAYMENT_CC_TEXT_INFO','');
  define('MODULE_PAYMENT_CC_STATUS_TITLE', '��������� ������ ������ ��������� ���������');
  define('MODULE_PAYMENT_CC_STATUS_DESC', '�� ������ ��������� ������������� ������ ��� ���������� �������?');
  define('MODULE_PAYMENT_CC_ALLOWED_TITLE' , '����������� ������');
  define('MODULE_PAYMENT_CC_ALLOWED_DESC' , '������� ���� �����, ��� ������� ����� �������� ������ ������ (�������� RU,DE (�������� ���� ������, ���� ������ ��� � ������ ��� �������� ����������� �� ����� �����))');
  define('CC_VAL_TITLE', '��������� �������� ��������');
  define('CC_VAL_DESC', '�� ������ ��������� �������� ��������� ��������?');
  define('CC_BLACK_TITLE', '��������� �������� ������� ������');
  define('CC_BLACK_DESC', '�� ������ ��������� ������� ������� ������?');
  define('CC_ENC_TITLE', '���������� ���������� � ��������� ��������');
  define('CC_ENC_DESC', '�� ������ ���������� ���������� � ��������� ��������?');
  define('MODULE_PAYMENT_CC_SORT_ORDER_TITLE', '������� ����������');
  define('MODULE_PAYMENT_CC_SORT_ORDER_DESC', '������� ���������� ������.');
  define('MODULE_PAYMENT_CC_ZONE_TITLE', '����');
  define('MODULE_PAYMENT_CC_ZONE_DESC', '���� ������� ����, �� ������ ������ ������ ����� ����� ������ ����������� �� ��������� ����.');
  define('MODULE_PAYMENT_CC_ORDER_STATUS_ID_TITLE', '������ ������');
  define('MODULE_PAYMENT_CC_ORDER_STATUS_ID_DESC', '������, ����������� � �������������� ������� ������ ������ ����� ��������� ��������� ������.');
  define('USE_CC_CVV_TITLE', '�������� CVV ������');
  define('USE_CC_CVV_DESC', '�� ������ �������� CVV ������?');
  define('USE_CC_ISS_TITLE', '�������� ���������� ������');
  define('USE_CC_ISS_DESC', '�� ������ �������� ���������� ������?');
  define('USE_CC_START_TITLE', '�������� ���� ������');
  define('USE_CC_START_DESC', '�� ������ �������� ���� ������?');
  define('CC_CVV_MIN_LENGTH_TITLE', '����� CVV ����');
  define('CC_CVV_MIN_LENGTH_DESC', '���������� ����� CVV ����. �� ��������� ������� 3.');
  define('MODULE_PAYMENT_CC_EMAIL_TITLE', '��������� ����� ��������');
  define('MODULE_PAYMENT_CC_EMAIL_DESC', '���� ������ E-Mail, ������� ����� ������ ��������� �������� ����� ���������� �� ��������� E-Mail (��������� ����� ������ �������� � ���� ������, �� �����, ��� ���������� �� E-Mail, ����� �������� �� ������ ��������� ��������.');
define('TEXT_CCVAL_ERROR_INVALID_DATE', '���� "������������� ��" ��������� �����������.<br />���������� ��� ���.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', '���� "����� ��������� ��������", ��������� �����������.<br />���������� ��� ���.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', '������ 4 ����� ����� ��������� ��������: %s<br />���� �� ������� ����� ���������, �� �� �� ��������� � ������ ������ ��� ��������� ��������.<br />���������� ��� ���.');

  define('MODULE_PAYMENT_CC_ACCEPT_DINERSCLUB_TITLE', '��������� � ������ ��������� �������� DINERS CLUB');
  define('MODULE_PAYMENT_CC_ACCEPT_DINERSCLUB_DESC', '��������� � ������ ��������� �������� DINERS CLUB');
  define('MODULE_PAYMENT_CC_ACCEPT_AMERICANEXPRESS_TITLE', '��������� � ������ ��������� �������� AMERICAN EXPRESS');
  define('MODULE_PAYMENT_CC_ACCEPT_AMERICANEXPRESS_DESC', '��������� � ������ ��������� �������� AMERICAN EXPRESS');
  define('MODULE_PAYMENT_CC_ACCEPT_CARTEBLANCHE_TITLE', '��������� � ������ ��������� �������� CARTE BLANCHE');
  define('MODULE_PAYMENT_CC_ACCEPT_CARTEBLANCHE_DESC', '��������� � ������ ��������� �������� CARTE BLANCHE');
  define('MODULE_PAYMENT_CC_ACCEPT_OZBANKCARD_TITLE', '��������� � ������ ��������� �������� AUSTRALIAN BANKCARD');
  define('MODULE_PAYMENT_CC_ACCEPT_OZBANKCARD_DESC', '��������� � ������ ��������� �������� AUSTRALIAN BANKCARD');
  define('MODULE_PAYMENT_CC_ACCEPT_DISCOVERNOVUS_TITLE', '��������� � ������ ��������� �������� DISCOVER/NOVUS');
  define('MODULE_PAYMENT_CC_ACCEPT_DISCOVERNOVUS_DESC', '��������� � ������ ��������� �������� DISCOVER/NOVUS');
  define('MODULE_PAYMENT_CC_ACCEPT_DELTA_TITLE', '��������� � ������ ��������� �������� DELTA');
  define('MODULE_PAYMENT_CC_ACCEPT_DELTA_DESC', '��������� � ������ ��������� �������� DELTA');
  define('MODULE_PAYMENT_CC_ACCEPT_ELECTRON_TITLE', '��������� � ������ ��������� �������� ELECTRON');
  define('MODULE_PAYMENT_CC_ACCEPT_ELECTRON_DESC', '��������� � ������ ��������� �������� ELECTRON');
  define('MODULE_PAYMENT_CC_ACCEPT_MASTERCARD_TITLE', '��������� � ������ ��������� �������� MASTERCARD');
  define('MODULE_PAYMENT_CC_ACCEPT_MASTERCARD_DESC', '��������� � ������ ��������� �������� MASTERCARD');
  define('MODULE_PAYMENT_CC_ACCEPT_SWITCH_TITLE', '��������� � ������ ��������� �������� SWITCH');
  define('MODULE_PAYMENT_CC_ACCEPT_SWITCH_DESC', '��������� � ������ ��������� �������� SWITCH');
  define('MODULE_PAYMENT_CC_ACCEPT_SOLO_TITLE', '��������� � ������ ��������� �������� SOLO');
  define('MODULE_PAYMENT_CC_ACCEPT_SOLO_DESC', '��������� � ������ ��������� �������� SOLO');
  define('MODULE_PAYMENT_CC_ACCEPT_JCB_TITLE', '��������� � ������ ��������� �������� JCB');
  define('MODULE_PAYMENT_CC_ACCEPT_JCB_DESC', '��������� � ������ ��������� �������� JCB');
  define('MODULE_PAYMENT_CC_ACCEPT_MAESTRO_TITLE', '��������� � ������ ��������� �������� MAESTRO');
  define('MODULE_PAYMENT_CC_ACCEPT_MAESTRO_DESC', '��������� � ������ ��������� �������� MAESTRO');
  define('MODULE_PAYMENT_CC_ACCEPT_VISA_TITLE', '��������� � ������ ��������� �������� VISA');
  define('MODULE_PAYMENT_CC_ACCEPT_VISA_DESC', '��������� � ������ ��������� �������� VISA');
?>
