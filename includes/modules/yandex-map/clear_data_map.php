<?php

// очистка таблицы геоадресов яндекс карт (когда начинают "двоится-троится" маркеры из-за того что меняется написание адресов)
//require('includes/application_top.php');	
		
vam_db_query("TRUNCATE TABLE markers_geocod");

?>