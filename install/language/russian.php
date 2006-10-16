<?php
/* --------------------------------------------------------------
   $Id: russian.php 1213 2005-09-14 11:34:50Z VaM $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (english.php,v 1.8 2003/08/13); www.nextcommerce.org
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/
// Global

define('TEXT_FOOTER','Powered by <a href="http://oscommerce.su">VaM Shop</a>'); 
   
// Box names
define('BOX_LANGUAGE','����');
define('BOX_DB_CONNECTION','���������� � ����� ������') ;
define('BOX_WEBSERVER_SETTINGS','��������� ��� �������');
define('BOX_DB_IMPORT','������ ���� ������');
define('BOX_WRITE_CONFIG','������ ���������������� ������');
define('BOX_ADMIN_CONFIG','��������� ��������������');
define('BOX_USERS_CONFIG','��������� �����������');

define('PULL_DOWN_DEFAULT','�������� ������!');


// Error messages

 	// index.php
 	
	define('SELECT_LANGUAGE_ERROR','�������� ����!');
	
	// step2,5.php
	
	define('TEXT_CONNECTION_ERROR','���������� � ����� ������ �� ���� �����������.');
	define('TEXT_CONNECTION_SUCCESS','���������� � ����� ������ ������� �����������.');
	define('TEXT_DB_ERROR','��������� �� ������:');
	define('TEXT_DB_ERROR_1','������� ��������� ����� ��������� ���������� ������.');
	define('TEXT_DB_ERROR_2','���� �� �� ������ ���������� ��� ������� � ����� ���� ������, ��������� � ����� �������-�����������.');
	
	// step6.php
	
	define('ENTRY_FIRST_NAME_ERROR','��� ������� ��������');
	define('ENTRY_LAST_NAME_ERROR','������� ������� ��������');
	define('ENTRY_EMAIL_ADDRESS_ERROR','Email ������� ��������');
	define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR','��������� ������ Email');
	define('ENTRY_STREET_ADDRESS_ERROR','����� ������� ��������');
	define('ENTRY_POST_CODE_ERROR','�������� ������ ������� ��������');
	define('ENTRY_CITY_ERROR','����� ������� ��������');
	define('ENTRY_COUNTRY_ERROR','��������� ������');
	define('ENTRY_STATE_ERROR','��������� ������');
	define('ENTRY_TELEPHONE_NUMBER_ERROR','������� ������� ��������');
	define('ENTRY_PASSWORD_ERROR','��������� ������');
	define('ENTRY_STORE_NAME_ERROR','�������� �������� ������� ��������');
	define('ENTRY_COMPANY_NAME_ERROR','�������� �������� ������� ��������');
	define('ENTRY_EMAIL_ADDRESS_FROM_ERROR','���� Email �� ������� ��������');
	define('ENTRY_EMAIL_ADDRESS_FROM_CHECK_ERROR','��������� ������ Email ��');
	define('SELECT_ZONE_SETUP_ERROR','�������� ������');
	
	// step7.php

	define('ENTRY_DISCOUNT_ERROR','����� - ������ �� ������');
	define('ENTRY_OT_DISCOUNT_ERROR','����� - ������ �� �������� ������������� ������');
	define('SELECT_OT_DISCOUNT_ERROR','����� - ������ �� �������� ������������� ������');
	define('SELECT_GRADUATED_ERROR','����� - ������ � ����������� �� ���������� ���������� ������ ������');
	define('SELECT_PRICE_ERROR','����� - ���������� ����');
	define('SELECT_TAX_ERROR','����� - ���������� �����');
	define('ENTRY_DISCOUNT_ERROR2','�� ��������� - ������ �� ������');
	define('ENTRY_OT_DISCOUNT_ERROR2','�� ��������� - ������ �� �������� ������������� ������');
	define('SELECT_OT_DISCOUNT_ERROR2','�� ��������� - ������ �� �������� ������������� ������');
	define('SELECT_GRADUATED_ERROR2','�� ��������� - ������ �� ���������� ���������� ������');
	define('SELECT_PRICE_ERROR2','�� ��������� - ���������� ����');
	define('SELECT_TAX_ERROR2','�� ��������� - ���������� �����');
	
	


	
	
// index.php

define('TITLE_SELECT_LANGUAGE','�������� ����!');

define('TEXT_WELCOME_INDEX','VaM Shop - ��� ��������-������� � �������� �������� �����, ��������������� ������������� �����������. ��������������� �� ������ �������� �������� �����, ��������� VaM Shop, �� ��������� ������� � ������ ��������-�������.<br /><br />
      VaM Shop �������� �������� ��������, ���������� ��� ����������� ��� ������� Apache, � �������� ���� ������ ������������ MySQL, � �������� ����� ���������������� ������������ PHP.<br /><br />
      VaM Shop ����� ���� ���������� �� ����� ������, �������������� PHP � MySQL, � �������� ������������ ������� ����� �������������� GNU/Linux, Solaris, BSD, ���� Microsoft Windows.');
define('TEXT_WELCOME_STEP1','<b>�������� ��������� ������� � ���� ������ � ��������� ��� �������</b><br /><br />������� ������ � ���� ������ � ��������� ��� �������.<br />');
define('TEXT_WELCOME_STEP2','<b>��������� ���� ������</b><br /><br />VaM Shop ������������� ��������� ���� ������ ��������.');
define('TEXT_WELCOME_STEP3','<b>������ ���� ������.</b><br /><br />');
define('TEXT_WELCOME_STEP4','<b>��������� ���������������� ������ VaM Shop</b><br /><br /><b>���� ���� ������ ���������������� ����� �� ���������� ���������, VaM Shop ������ �� �������������.</b><br /><br />����������� �������������� �������� ��������� �� � ��������� ������.');
define('TEXT_WELCOME_STEP5','<b>��������� ��� �������</b><br /><br />');
define('TEXT_WELCOME_STEP6','<b>�������� ��������� ��������</b><br /><br />����������� ������� ������� ������ �������������� � �������� ���������� ���� ������.<br />���������� � <b>������</b> � <b>�������� �������</b> ����� �������������� ��� �������� ��������� �������� � �������.');
define('TEXT_WELCOME_STEP7','<b>��������� ����� �����������</b><br /><br />VaM Shop ������������� ������� ����������� ���������� ������ � ��������.<br /><br />
<b>������ �� �����</b><br />
������ ����� ���� ����������� ��� �� ������ ����� � �����������, ��� � ����� �� ��� ������ ���� ��������� ������ ��� ������ �����������.<br />
���� ������ �� ����� = 10.00% � ������ ��� ������ = 5%, ����� ����� �������������� ������ ��� ������, �.�. ����� ����� �� ������� 5%<br />
���� ������ �� ����� = 10.00% � ������ ��� ������ = 15%, ����� ����� �������������� ������ ��� ������, �.�. ����� ����� �� ������� 10%<br /><br />
<b>������ �� �������� ������������� ������</b><br />
������ �� ����� ����� ������ (����� �������� �������, ��������, ��������� �����)<br /><br />
<b>������ � ����������� �� ���������� ���������� ������ ������</b><br />
������ � ����������� �� ���������� ���������� ������ ������ ����� ���� ����������� ��� �� ������ ����� � �����������, ��� � ����� �� ��� ������ ���� ��������� ������ ��� ������ �����������.<br />
�� ������ ������������� ��������� ��������, ��������:<br />
������ ����������� 1 -> ��������� ������ Y � ����������� �� ���������� ���������� ������<br />
������ ����������� 2 -> ������ 10% �� ����� Y<br />
������ ����������� 3 -> ����������� ���� ��� ������ ������ ����������� �� ����� Y<br />
������ ����������� 4 -> ����������� ���� �� ����� Y<br />
');
define('TEXT_WELCOME_FINISHED','<b>��������� VaM Shop ������� ���������!</b>');

// step1.php

define('TITLE_CUSTOM_SETTINGS','���������');
define('TEXT_IMPORT_DB','������ ���� ������');
define('TEXT_IMPORT_DB_LONG','������ ��������� ���� ������ VaM Shop.');
define('TEXT_AUTOMATIC','�������������� ���������');
define('TEXT_AUTOMATIC_LONG','������, ������� �� �������, ���������� � ���������������� ������ �������� � ����������������� ����� ��������.');
define('TITLE_DATABASE_SETTINGS','��������� ���� ������');
define('TEXT_DATABASE_SERVER','������ ���� ������');
define('TEXT_DATABASE_SERVER_LONG','����� ���� IP-����� ������� ���� ������. ������ ������ ���� ������ ��������� �� ������ localhost, ���� �� �� ������ ����� ������� ���� ������, ��������� �� ����� �������-�����������.');
define('TEXT_USERNAME','��� ������������');
define('TEXT_USERNAME_LONG','��� ������������, ������������ ��� ����������� � ���� ������.<br />���� �� �� ������ ��� ������������ ��� ������� � ���� ������, ��������� �� ����� �������-�����������.');
define('TEXT_PASSWORD','������');
define('TEXT_PASSWORD_LONG','������, ������������ ��� ����������� � ���� ������. <br />���� �� �� ������ ������ ��� ������� � ���� ������, ��������� �� ����� �������-�����������.');
define('TEXT_DATABASE','���� ������');
define('TEXT_DATABASE_LONG','�������� ���� ������, ������� ����� �������������� ��� ��������� ��������-��������.<br />���� �� �� ������ �������� ���� ������, ��������� �� ����� �������-�����������.');
define('TITLE_WEBSERVER_SETTINGS','��������� ��� �������');
define('TEXT_WS_ROOT','�������� ���������� ���-�������');
define('TEXT_WS_ROOT_LONG','������ ���� �� �������� ����������, ��� ��������� html �����, �������� <i>/home/myname/public_html</i><br /> � ����������� �������, ��� �� ����� ����������� ���� �� ����������, ������ ��������� ������������� ��������� ��������������� ���������� � �������� ���� �������������.');
define('TEXT_WS_XTC','���������� ��������-��������');
define('TEXT_WS_XTC_LONG','���� �� ����������, ��� ��������� ��������-�������, ������ <i>/</i> ��� <i>/home/myname/public_html/vamshop/</i><br /> � ����������� �������, ��� �� ����� ����������� ���� �� ����������, ������ ��������� ������������� ��������� ��������������� �������� � �������� ���� �� ���������� �������������.');
define('TEXT_WS_ADMIN','���������� ������� ��������-��������');
define('TEXT_WS_ADMIN_LONG','���� �� ����������, ��� ��������� ������� ��������-��������, ������ <i>/admin/</i> ��� <i>/home/myname/public_html/vamshop/admin/</i><br /> � ����������� �������, ��� �� ����� ����������� ���� �� ����������, ������ ��������� ������������� ��������� ��������������� ������� � �������� ���� �� ���������� �������������.');
define('TEXT_WS_CATALOG','����������� ���������� ��������-��������');
define('TEXT_WS_CATALOG_LONG','����������� ���������� � ���������, �������� <i>/vamshop/</i><br /> � ����������� �������, ��� �� ����� ����������� ����������, ������ ��������� ������������� ��������� ��������������� �������� � �������� ���� �� ����������� ���������� �������������.');
define('TEXT_WS_ADMINTOOL','����������� ���������� ������� ��������-��������');
define('TEXT_WS_ADMINTOOL_LONG','����������� ���������� � �������� ��������, �������� <i>/vamshop/admin/</i><br /> � ����������� �������, ��� �� ����� ����������� ����������, ������ ��������� ������������� ��������� ��������������� ������� � �������� ���� �� ����������� ���������� �������������.');

// step2.php

define('TEXT_PROCESS_1','����������� ���������, ����� ����� ��������� ���� ������ ��������.');
define('TEXT_PROCESS_2','��� ������ ���� ��������� ��������, �� ���������� ���, � ��������� ������ ���� ������ ����� ���� ����������, ���� ��������� �� ���������.');
define('TEXT_PROCESS_3','���� ���� ������ ������ ���������� �� ���������� ������: ');


// step3.php

define('TEXT_TITLE_ERROR','��������� ��������� ������:');
define('TEXT_TITLE_SUCCESS','���� ������ ������� �������������!');

// step4.php

define('TITLE_WEBSERVER_CONFIGURATION','��������� ���������������� ������:');
define('TITLE_STEP4_ERROR','��������� ��������� ������:');
define('TEXT_STEP4_ERROR','<b>����� �������� ���� �����������, ���� ����������� �������� ����� �������.</b><br /><br />���������� ����� ������� 706 �� ��������� ����: ');
define('TEXT_STEP4_ERROR_1','���� <i>chmod 706</i> �� ������������, ���������� <i>chmod 777</i>.');
define('TEXT_STEP4_ERROR_2','� ������������ ������� Windows �� ������ ������ ���������, ��� ������ ����� �� ����� ������� ������ ��� ������.');
define('TEXT_VALUES','����� ��������� ��������� ���������������� �����:');
define('TITLE_CHECK_CONFIGURATION','����������, ��������� ��������� ����������');
define('TEXT_HTTP','HTTP ������');
define('TEXT_HTTP_LONG','�������� ���-�������, �������� <i>http://www.myserver.com</i>, ���� IP ����� �������, �������� <i>http://192.168.0.1</i><br />� ����������� �������, ��� �� ����� ����������� �����, ������ ��������� ������������� ��������� ����� � �������� ��� �������������.');
define('TEXT_HTTPS','HTTPS ������');
define('TEXT_HTTPS_LONG','�������� ����������� ���-�������, ��������  <i>https://www.myserver.com</i>, ���� IP ����� �������, �������� <i>https://192.168.0.1</i><br />� ����������� �������, ��� �� ����� ����������� �����, ������ ��������� ������������� ��������� ����� � �������� ��� �������������.');
define('TEXT_SSL','��������� SSL �����������');
define('TEXT_SSL_LONG','������������ ���������� �� ����������� ��������� SSL/HTTPS. ���� �� �� ������, ��� ����� SSL, ��� ����������� ������ ��������, ������������ ������������� �� ������������ SSL, ����� ��������-������� �������� �� �����.');
define('TITLE_CHECK_DATABASE','����������, ��������� ��������� ���������� � ���� ������');
define('TEXT_PERSIST','��������� ���������� �����������');
define('TEXT_PERSIST_LONG','������������ ���������� ����������� � ���� ������.<br />������������� �� �������� ������ �����. ��������� ������ �����, ���� � ��� ���������� ������.');
define('TEXT_SESS_FILE','������� ������ � ������');
define('TEXT_SESS_DB','������� ������ � ���� ������');
define('TEXT_SESS_LONG','��������, ��� ������� ������: � ������ ��� � ���� ������.');

// step5.php

define('TEXT_WS_CONFIGURATION_SUCCESS','<strong>VaM Shop</strong> - ��������� ���������������� ������ ������� ���������!');

// step6.php

define('TITLE_ADMIN_CONFIG','��������� ��������������');
define('TEXT_REQU_INFORMATION','����, ���������� *, ����������� ��� ����������');
define('TEXT_FIRSTNAME','���:');
define('TEXT_LASTNAME','�������:');
define('TEXT_EMAIL','Email:');
define('TEXT_EMAIL_LONG','(��� ��������� �������)');				
define('TEXT_STREET','�����:');
define('TEXT_POSTCODE','�������� ������:');
define('TEXT_CITY','�����:');
define('TEXT_STATE','������:');
define('TEXT_COUNTRY','������:');
define('TEXT_COUNTRY_LONG','����� �������������� ��� �������� ��������� �������� � �������');
define('TEXT_TEL','�������:');
define('TEXT_PASSWORD','������:');
define('TEXT_PASSWORD_CONF','������������� ������:');
define('TITLE_SHOP_CONFIG','��������� ��������');
define('TEXT_STORE','�������� ��������:');
define('TEXT_STORE_LONG','(�������� ������ ��������)');
define('TEXT_EMAIL_FROM','Email ��');
define('TEXT_EMAIL_FROM_LONG','(Email �����, �� �������� ����� ���������� ��� ������ �� ��������)');
define('TITLE_ZONE_CONFIG','����');
define('TEXT_ZONE','���������� ���� ���������?');
define('TITLE_ZONE_CONFIG_NOTE','* ���������: VaM Shop ����� ������������� ��������� ���� ��������� � �������.');
define('TITLE_SHOP_CONFIG_NOTE','* ���������: �������� ��������� ��������');
define('TITLE_ADMIN_CONFIG_NOTE','* ���������: ��������� ������');
define('TEXT_ZONE_NO','���');
define('TEXT_ZONE_YES','��');
define('TEXT_COMPANY','�������� ��������');



// step7

define('TITLE_GUEST_CONFIG','��������� ��� ������');
define('TITLE_GUEST_CONFIG_NOTE','* ���������: ��������� ��� ������� ����������� �������� (�� ������������������ �����������)');
define('TITLE_CUSTOMERS_CONFIG','��������� �� ���������');
define('TITLE_CUSTOMERS_CONFIG_NOTE','* ���������: ��������� ��� �������� �������� (������������������ �����������)');
define('TEXT_STATUS_DISCOUNT','������ �� �����');
define('TEXT_STATUS_DISCOUNT_LONG','������ �� ����� <i>(� ���������, �������� 10.00, 20.00)</i>');
define('TEXT_STATUS_OT_DISCOUNT_FLAG','������ �� �������� ������������� ������');
define('TEXT_STATUS_OT_DISCOUNT_FLAG_LONG','��������� ����������� �������� ������ �� �������� ������������� ������');
define('TEXT_STATUS_OT_DISCOUNT','������ �� �������� ������������� ������');
define('TEXT_STATUS_OT_DISCOUNT_LONG','������ �� �������� ������������� ������ <i>(� ���������, �������� 10.00, 20.00)</i>');
define('TEXT_STATUS_GRADUATED_PRICE','���� � ����������� �� ���������� ���������� ������ ������');
define('TEXT_STATUS_GRADUATED_PRICE_LONG','��������� ����������� ������ ���� � ����������� �� ���������� ���������� ������ ������');
define('TEXT_STATUS_SHOW_PRICE','���������� ����');
define('TEXT_STATUS_SHOW_PRICE_LONG','��������� ����������� ������ ���� � ��������');
define('TEXT_STATUS_SHOW_TAX','���������� �����');
define('TEXT_STATUS_SHOW_TAX_LONG','���������� ���� � ������� (��) ��� ��� ������ (���)');


define('TITLE_CHMOD','��������� ���� ������� �� �����');

// fnished.php

define('TEXT_SHOP_CONFIG_SUCCESS','��������� �������� <strong>VaM Shop</strong> ������� ���������.');
define('TEXT_TEAM','<a href="http://oscommerce.su">������� ��������� VaM Shop</a>');

// ������ VaM

// step1

define('IMAGE_CONTINUE','����������');
define('IMAGE_CANCEL','��������');
define('IMAGE_BACK','���������');
define('IMAGE_RETRY','���������');
define('TEXT_RUSSIAN','�������');
define('TEXT_ENGLISH','����������');
define('TEXT_CHECKING','��������:');
define('TEXT_ATTENTION','��������:');
define('TITLE_INDEX','��������� VaM Shop - ����� ����������');
define('TITLE_STEP1','��������� VaM Shop - ��� 1 / ���������');
define('TITLE_STEP2','��������� VaM Shop - ��� 2 / ����������� � ���� ������');
define('TITLE_STEP3','��������� VaM Shop - ��� 3 / ������ ���� ������');
define('TITLE_STEP4','��������� VaM Shop - ��� 4 / ��������� ��� �������');
define('TITLE_STEP5','��������� VaM Shop - ��� 5 / ������ ���������������� ������');
define('TITLE_STEP6','��������� VaM Shop - ��� 6 / �������� ������');
define('TITLE_STEP7','��������� VaM Shop - ��� 7 / ��������� ���');
define('TITLE_FINISHED','��������� VaM Shop - ��������� ���������');
define('CHARSET','windows-1251');
define('TEXT_INSTALL','���������');
define('ERROR_PERMISSION','�������� ����� ������� ');
define('TEXT_ERROR','������');
define('TEXT_FILE_PERMISSIONS','����� ������� ������ .............................. ');
define('TEXT_FOLDER_PERMISSIONS','����� ������� ���������� .............................. ');
define('PHP_VERSION_ERROR','<b>��������!, ������ PHP ������� ������, ��� ���������� ������ VaM Shop ��������� PHP 4.1.3 � ����.</b><br /><br />
                 ���� ������ PHP: <b><?php echo phpversion(); ?></b><br /><br />
                 VaM Shop �� ����� ��������� �������� �� ������ �������, �������� PHP, ���� ������� ������.');
define('TEXT_PHP_VERSION','������ PHP .............................. ');
define('TEXT_GD_LIB_NOT_FOUND','������! ���������� GD �� �������!');
//define('TEXT_GD_LIB_VERSION','���� ������ GDlib < 2+ , ������� ��� ��������� �������������� ����������');
define('TEXT_GD_LIB_VERSION','');
define('TEXT_GD_LIB_VERSION1','������ GDlib .............................. ');
define('TEXT_GD_LIB_GIF_SUPPORT','��������� GIF � GDlib .............................. ');
define('TEXT_GD_LIB_GIF_SUPPORT_ERROR','<b><font color="ff0000">������</font></b><br />������������� ���������� GDlib �� ������������ �������� � ������� GIF, �� �� ������� ������������ �������� GIF � �������� VaM Shop!');
define('TEXT_OK','�� ���������');

//install_finished

define('TEXT_CATALOG','�������');

?>