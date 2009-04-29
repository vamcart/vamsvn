<?php 
/* --------------------------------------------------------------
   $Id: config.php 1167 2009-04-29 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2009 VaM Shop
   --------------------------------------------------------------
   Released under the GNU General Public License 
   --------------------------------------------------------------*/

	require_once("../includes/configure.php");
	/*
	define("DB_SERVER", "localhost");
	define("DB_DATABASE", "technoport");
	define("DB_SERVER_USERNAME", "root");
	define("DB_SERVER_PASSWORD", "");
	*/
	$link = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
	if (!$link)
	{
		die("Can't connect to database: ". mysql_error());
	}
	$db_selected = mysql_select_db(DB_DATABASE, $link);
	if (!$db_selected)
	{
		die ("Can't use DB: " . mysql_error());
	}

    @mysql_query("SET CHARACTER SET utf8");
    @mysql_query("SET NAMES utf8");
    @mysql_query("SET COLLATION utf8_general_ci"); 

?>