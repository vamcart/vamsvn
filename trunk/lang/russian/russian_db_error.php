<?php
// Обработка MySQL ошибок

define('DB_ERR_MAIL', 'Администратор </dev/null>'); // Укажите e-mail адрес и имя получателя, куда будут тприходить пиьсма с технической информацией, в случае возникновения проблем с MySQL сервером.
define('DB_ERR_MSG', "<br /><br /><center><font face=\"verdana,tahoma,arial\" size=\"2\" color=\"ff0000\"><b>"
                     ."Интернет-магазин закрыт на техническое обслуживание, заходите позже!</b><font></center>"); // Сообщение, которое будет выводиться при возникновении проблем с MySQL сервером.

define('MYSQL QUERY ERROR_TEXT', 'Проблемы с MySQL');
define('MYSQL QUERY ERROR_SUBJECT', 'Проблемы с MySQL сервером!');
define('MYSQL QUERY ERROR_SERVER_NAME', 'Сервер: ');
define('MYSQL QUERY ERROR_REMOTE_ADDR', 'Адрес: ');
define('MYSQL QUERY ERROR_REFERER', 'Реферер: ');
define('MYSQL QUERY ERROR_REQUESTED', 'Страница: ');
define('MYSQL QUERY ERROR_FROM', 'От: db_error@');

?>