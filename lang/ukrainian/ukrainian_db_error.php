<?php
/* -----------------------------------------------------------------------------------------
   $Id: russian_db_error.php 1260 2015/03/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// Обработка MySQL ошибок

define('DB_ERR_MAIL', 'Администратор </dev/null>'); // Укажите E-Mail адрес и имя получателя, куда будут приходить письма с технической информацией, в случае возникновения проблем с MySQL сервером.
define('DB_ERR_MSG', "<br /><br /><center><font face=\"verdana,tahoma,arial\" size=\"2\" color=\"ff0000\"><b>"
                     ."Интернет-магазин закрыт на техническое обслуживание, заходите позже!</b></font><br /><br /><a href=\"http://forum.vamshop.ru/topic/8398-%D0%B2-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD%D0%B5-%D0%B2%D1%8B%D0%B2%D0%BE%D0%B4%D0%B8%D1%82%D1%81%D1%8F-%D1%81%D0%BE%D0%BE%D0%B1%D1%89%D0%B5%D0%BD%D0%B8%D0%B5-%D0%B8%D0%BD%D1%82%D0%B5%D1%80%D0%BD%D0%B5%D1%82-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7/\" target=\"_blank\"><u>Проблема с MySQL. Как узнать причину ошибки. </u></a></center>"); // Сообщение, которое будет выводиться при возникновении проблем с MySQL сервером.

define('MYSQL QUERY ERROR_TEXT', 'Проблемы с MySQL');
define('MYSQL QUERY ERROR_SUBJECT', 'Проблемы с MySQL сервером!');
define('MYSQL QUERY ERROR_SERVER_NAME', 'Сервер: ');
define('MYSQL QUERY ERROR_REMOTE_ADDR', 'Адрес: ');
define('MYSQL QUERY ERROR_REFERER', 'Реферер: ');
define('MYSQL QUERY ERROR_REQUESTED', 'Страница: ');
define('MYSQL QUERY ERROR_FROM', 'От: db_error@');

?>