<?php
/* --------------------------------------------------------------
   $Id: create_account.php 985 2006-04-29 02:40:57Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(create_account.php,v 1.13 2003/05/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (create_account.php,v 1.4 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('NAVBAR_TITLE', '������� �������');

define('HEADING_TITLE', '��� �������');

define('TEXT_ORIGIN_LOGIN', '<font color="#FF0000"><small><b>�������:</b></font></small> ���� � ��� ��� ���� � ����� �������� ������� ������, ���������� ������ ������� ����� <a href="%s"><u>�����</u></a>.');

define('EMAIL_SUBJECT', '����� ���������� � ' . STORE_NAME);
define('EMAIL_GREET_MR', '��������� ��������. ' . stripslashes($HTTP_POST_VARS['lastname']) . ',' . "\n\n");
define('EMAIL_GREET_MS', '��������� �������. ' . stripslashes($HTTP_POST_VARS['lastname']) . ',' . "\n\n");
define('EMAIL_GREET_NONE', '������� (��) ' . stripslashes($HTTP_POST_VARS['firstname']) . ',' . "\n\n");
define('EMAIL_WELCOME', '����� ���������� �  <b>' . STORE_NAME . '</b>.' . "\n\n");
define('EMAIL_TEXT', '�� ������ ������ ������������ <b>��������� ������ </b>, ������� �� ���������� ���. ��������� �� ����� ��������:'. "\n\n". '<li><b>��������� �������</b> - ����� ������ ����������� � ����� ������� ������� �������� ��� ���� �� �� ������� �� ��� �� �������� ��� ������ ��� ������.'. "\n". '<li><b>�������� �����</b> - �� ����� ������ ��������� ���� ������ �� ������ ������� ������ ����� ������ ���������! ��� �������� �����������, ����� �������� �������� ������� �� ��� �������� ��� � ����������, � ��������� � ��������� ���� �����!'. "\n". '<li><b>������� �������</b> - ������������� ���� ������� ������������, �������� �� ������� ����.'. "\n". '<li><b>������ � ������� � �������</b> - ��������� ����  ������ � ������ � ������� � ���������� ���� ������� � ������ ������� ���������.' . "\n\n");
define('EMAIL_CONTACT', '��� ������ � ������������� �����, ���� ���� �������� ��� ����������� � �������������, �� ������ ���������� � ��������� ��������: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>��������:</b> ��� e-mail ����� ��� ��� ��� ����� �� ����� ��������. ���� �� �� ������������� � �� ���������������� � �� ��������� �������� ������ ��������, ���������, ����������, e-mail ������������� ������ ��������, ����� ��� ����� ��� ������ ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");
define('ENTRY_PAYMENT_UNALLOWED','����������� ������ ������:');
define('ENTRY_SHIPPING_UNALLOWED','����������� ������ ��������:');
?>