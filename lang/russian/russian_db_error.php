<?php
/* -----------------------------------------------------------------------------------------
   $Id: russian_db_error.php 1260 2007/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// ��������� MySQL ������

define('DB_ERR_MAIL', '������������� </dev/null>'); // ������� E-Mail ����� � ��� ����������, ���� ����� ��������� ������ � ����������� �����������, � ������ ������������� ������� � MySQL ��������.
define('DB_ERR_MSG', "<br /><br /><center><font face=\"verdana,tahoma,arial\" size=\"2\" color=\"ff0000\"><b>"
                     ."��������-������� ������ �� ����������� ������������, �������� �����!</b><font></center>"); // ���������, ������� ����� ���������� ��� ������������� ������� � MySQL ��������.

define('MYSQL QUERY ERROR_TEXT', '�������� � MySQL');
define('MYSQL QUERY ERROR_SUBJECT', '�������� � MySQL ��������!');
define('MYSQL QUERY ERROR_SERVER_NAME', '������: ');
define('MYSQL QUERY ERROR_REMOTE_ADDR', '�����: ');
define('MYSQL QUERY ERROR_REFERER', '�������: ');
define('MYSQL QUERY ERROR_REQUESTED', '��������: ');
define('MYSQL QUERY ERROR_FROM', '��: db_error@');

?>