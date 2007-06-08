<?php
/***************************************************************************\
| Sypex Dumper Lite          version 1.0.8b                                 |
| (c)2003-2006 zapimir       zapimir@zapimir.net       http://sypex.net/    |
| (c)2005-2006 BINOVATOR     info@sypex.net                                 |
|---------------------------------------------------------------------------|
|     created: 2003.09.02 19:07              modified: 2006.10.27 03:30     |
|---------------------------------------------------------------------------|
| This program is free software; you can redistribute it and/or             |
| modify it under the terms of the GNU General Public License               |
| as published by the Free Software Foundation; either version 2            |
| of the License, or (at your option) any later version.                    |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,USA. |
\***************************************************************************/

/* --------------------------------------------------------------
   $Id: backup.php 1023 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(backup.php,v 1.57 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (backup.php,v 1.11 2003/08/2); www.nextcommerce.org
   (c) 2004	 xt:Commerce (backup.php,v 1.11 2003/08/2); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<style type="text/css">
<!--
body{
	overflow: auto;
}
td {
	font: 11px tahoma, verdana, arial;
	cursor: default;
}
input, select, div {
	font: 11px tahoma, verdana, arial;
}
input.text, select {
	width: 100%;
}
fieldset {
	margin-bottom: 10px;
}
-->
</style>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'false') { ?>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<?php } ?>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>

<td>


<?php

// ["action"]=>  string(6) "backup"// ["db_backup"]=>  string(4) "oscd"// ["tables"]=>  string(0) ""// ["comp_method"]=>  string(1) "2"// ["comp_level"]=>  string(1) "9"// ["db_restore"]=>  string(4) "oscd"// ["file"]=>  string(1) "0"// ["add_prefix"]// ["update_time"]=>
// Путь и URL к файлам бекапа

define('PATH', 'backups/');
define('URL',  'backups/');

// Максимальное время выполнения скрипта в секундах
// 0 - без ограничений

define('TIME_LIMIT', 600);

// Ограничение размера данных доставаемых за одно обращения к БД (в мегабайтах)
// Нужно для ограничения количества памяти пожираемой сервером при дампе очень объемных таблиц

define('LIMIT', 1);

// mysql сервер

define('DBHOST', DB_SERVER);
//define('DBHOST', 'localhost:3306');

// Базы данных, если сервер не разрешает просматривать список баз данных,
// и ничего не показывается после авторизации. Перечислите названия через запятую

define('DBNAMES', DB_DATABASE);

// Кодировка соединения с MySQL
// auto - автоматический выбор (устанавливается кодировка таблицы), cp1251 - windows-1251, и т.п.

define('CHARSET', 'auto');

// Кодировка соединения с MySQL при восстановлении
// На случай переноса со старых версий MySQL (до 4.1), у которых не указана кодировка таблиц в дампе
// При добавлении 'forced->', к примеру 'forced->cp1251', кодировка таблиц при восстановлении будет принудительно заменена на cp1251
// Можно также указывать сравнение нужное к примеру 'cp1251_ukrainian_ci' или 'forced->cp1251_ukrainian_ci'

define('RESTORE_CHARSET', 'cp1251');

// Включить сохранение настроек и последних действий
// Для отключения установить значение 0

define('SC', 0);

// Типы таблиц у которых сохраняется только структура, разделенные запятой

define('ONLY_CREATE', 'MRG_MyISAM,MERGE,HEAP,MEMORY');

// Глобальная статистика
// Для отключения установить значение 0

define('GS', 0);

// Дальше ничего редактировать не нужно

$is_safe_mode = ini_get('safe_mode') == '1' ? 1 : 0;
if (!$is_safe_mode && function_exists('set_time_limit')) set_time_limit(TIME_LIMIT);

//header("Expires: Tue, 1 Jul 2003 05:00:00 GMT");
//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//header("Cache-Control: no-store, no-cache, must-revalidate");
//header("Pragma: no-cache");

$timer = array_sum(explode(' ', microtime()));
ob_implicit_flush();
error_reporting(E_ALL);

$auth = 0;
$error = '';
/*
if (!empty($_REQUEST['login']) && isset($_REQUEST['pass'])) {
	if (@mysql_connect(DBHOST, $_REQUEST['login'], $_REQUEST['pass'])){
		setcookie("sxd", base64_encode("SKD101:{$_REQUEST['login']}:{$_REQUEST['pass']}"));
		header("Location: dumper.php");
		mysql_close();
		exit;
	}
	else{
		$error = '#' . mysql_errno() . ': ' . mysql_error();
	}
}
elseif (!empty($_COOKIE['sxd'])) {
    $user = explode(":", base64_decode($_COOKIE['sxd']));
	if (@mysql_connect(DBHOST, $user[1], $user[2])){
		$auth = 1;
	}
	else{
		$error = '#' . mysql_errno() . ': ' . mysql_error();
	}
}
*/	
if (@mysql_connect(DBHOST, DB_SERVER_USERNAME, DB_SERVER_PASSWORD)){
	$auth = 1;
}
else{
	$error = '#' . mysql_errno() . ': ' . mysql_error();
}

if (!$auth || (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] == 'reload')) {
	setcookie("sxd");
	echo tpl_page(tpl_auth($error ? tpl_error($error) : ''), "<script>if (jsEnabled) {document.write('<input type=submit class=button value=Применить>');}</script>");
	echo "<script>document.getElementById('timer').innerHTML = '" . round(array_sum(explode(' ', microtime())) - $timer, 4) . " сек.'</script>";
	exit;
}
if (!file_exists(PATH) && !$is_safe_mode) {
    mkdir(PATH, 0777) || trigger_error("Не удалось создать каталог для бекапа", E_USER_ERROR);
}

$SK = new dumper();
define('C_DEFAULT', 1);
define('C_RESULT', 2);
define('C_ERROR', 3);
define('C_WARNING', 4);

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
switch($action){
	case 'backup':
		$SK->backup();
		break;
	case 'restore':
		$SK->restore();
		break;
	default:
		$SK->main();
}

mysql_close();

echo "<script>document.getElementById('timer').innerHTML = '" . round(array_sum(explode(' ', microtime())) - $timer, 4) . " сек.'</script>";

class dumper {
	function dumper() {
		if (file_exists(PATH . "dumper.cfg.php")) {
		    include(PATH . "dumper.cfg.php");
		}
		else{
			$this->SET['last_action'] = 0;
			$this->SET['last_db_backup'] = '';
			$this->SET['tables'] = '';
			$this->SET['comp_method'] = 2;
			$this->SET['comp_level']  = 7;
			$this->SET['last_db_restore'] = '';
		}
		$this->tabs = 0;
		$this->records = 0;
		$this->size = 0;
		$this->comp = 0;

		// Версия MySQL вида 40101
		preg_match("/^(\d+)\.(\d+)\.(\d+)/", mysql_get_server_info(), $m);
		$this->mysql_version = sprintf("%d%02d%02d", $m[1], $m[2], $m[3]);

		$this->only_create = explode(',', ONLY_CREATE);
		$this->forced_charset  = false;
		$this->restore_charset = $this->restore_collate = '';
		if (preg_match("/^(forced->)?(([a-z0-9]+)(\_\w+)?)$/", RESTORE_CHARSET, $matches)) {
			$this->forced_charset  = $matches[1] == 'forced->';
			$this->restore_charset = $matches[3];
			$this->restore_collate = !empty($matches[4]) ? ' COLLATE ' . $matches[2] : '';
		}
	}

	function backup() {
		if (!isset($_REQUEST)) {$this->main();}
		set_error_handler("SXD_errorHandler");
		$buttons = "<a id=save href='' style='display: none;'>Скачать файл</a> &nbsp; <input id=back type=button class=button value='Вернуться' disabled onclick=\"history.back();\">";
		echo tpl_page(tpl_process("Создается резервная копия БД"), $buttons);

		$this->SET['last_action']     = 0;
		$this->SET['last_db_backup']  = isset($_REQUEST['db_backup']) ? $_REQUEST['db_backup'] : '';
		$this->SET['tables_exclude']  = !empty($_REQUEST['tables']) && $_REQUEST['tables']{0} == '^' ? 1 : 0;
		$this->SET['tables']          = isset($_REQUEST['tables']) ? $_REQUEST['tables'] : '';
		$this->SET['comp_method']     = isset($_REQUEST['comp_method']) ? intval($_REQUEST['comp_method']) : 0;
		$this->SET['comp_level']      = isset($_REQUEST['comp_level']) ? intval($_REQUEST['comp_level']) : 0;
		$this->fn_save();

		$this->SET['tables']          = explode(",", $this->SET['tables']);
		if (!empty($_REQUEST['tables'])) {
		    foreach($this->SET['tables'] AS $table){
    			$table = preg_replace("/[^\w*?^]/", "", $table);
				$pattern = array( "/\?/", "/\*/");
				$replace = array( ".", ".*?");
				$tbls[] = preg_replace($pattern, $replace, $table);
    		}
		}
		else{
			$this->SET['tables_exclude'] = 1;
		}

		if ($this->SET['comp_level'] == 0) {
		    $this->SET['comp_method'] = 0;
		}
		$db = $this->SET['last_db_backup'];

		if (!$db) {
			echo tpl_l("ОШИБКА! Не указана база данных!", C_ERROR);
			echo tpl_enableBack();
		    exit;
		}
		echo tpl_l("Подключение к БД `{$db}`.");
		mysql_select_db($db) or trigger_error ("Не удается выбрать базу данных.<br />" . mysql_error(), E_USER_ERROR);
		$tables = array();
        $result = mysql_query("SHOW tableS");
		$all = 0;
        while($row = mysql_fetch_array($result)) {
			$status = 0;
			if (!empty($tbls)) {
			    foreach($tbls AS $table){
    				$exclude = preg_match("/^\^/", $table) ? true : false;
    				if (!$exclude) {
    					if (preg_match("/^{$table}$/i", $row[0])) {
    					    $status = 1;
    					}
    					$all = 1;
    				}
    				if ($exclude && preg_match("/{$table}$/i", $row[0])) {
    				    $status = -1;
    				}
    			}
			}
			else {
				$status = 1;
			}
			if ($status >= $all) {
    			$tables[] = $row[0];
    		}
        }

		$tabs = count($tables);
		// Определение размеров таблиц
		$result = mysql_query("SHOW table STATUS");
		$tabinfo = array();
		$tab_charset = array();
		$tab_type = array();
		$tabinfo[0] = 0;
		$info = '';
		while($item = mysql_fetch_assoc($result)){
			//print_r($item);
			if(in_array($item['Name'], $tables)) {
				$item['Rows'] = empty($item['Rows']) ? 0 : $item['Rows'];
				$tabinfo[0] += $item['Rows'];
				$tabinfo[$item['Name']] = $item['Rows'];
				$this->size += $item['Data_length'];
				$tabsize[$item['Name']] = 1 + round(LIMIT * 1048576 / ($item['Avg_row_length'] + 1));
				if($item['Rows']) $info .= "|" . $item['Rows'];
				if (!empty($item['Collation']) && preg_match("/^([a-z0-9]+)_/i", $item['Collation'], $m)) {
					$tab_charset[$item['Name']] = $m[1];
				}
				$tab_type[$item['Name']] = isset($item['Engine']) ? $item['Engine'] : $item['Type'];
			}
		}
		$show = 10 + $tabinfo[0] / 50;
		$info = $tabinfo[0] . $info;
		$name = $db . '_' . date("Y-m-d_H-i");
        $fp = $this->fn_open($name, "w");
		echo tpl_l("Создание файла с резервной копией БД:<br />\\n  -  {$this->filename}");
		$this->fn_write($fp, "#SKD101|{$db}|{$tabs}|" . date("Y.m.d H:i:s") ."|{$info}\n\n");
		$t=0;
		echo tpl_l(str_repeat("-", 60));
		$result = mysql_query("SET SQL_QUOTE_SHOW_CREATE = 1");
		// Кодировка соединения по умолчанию
		if ($this->mysql_version > 40101 && CHARSET != 'auto') {
			mysql_query("SET NAMES '" . CHARSET . "'") or trigger_error ("Неудается изменить кодировку соединения.<br />" . mysql_error(), E_USER_ERROR);
			$last_charset = CHARSET;
		}
		else{
			$last_charset = '';
		}
        foreach ($tables AS $table){
			// Выставляем кодировку соединения соответствующую кодировке таблицы
			if ($this->mysql_version > 40101 && $tab_charset[$table] != $last_charset) {
				if (CHARSET == 'auto') {
					mysql_query("SET NAMES '" . $tab_charset[$table] . "'") or trigger_error ("Неудается изменить кодировку соединения.<br />" . mysql_error(), E_USER_ERROR);
					echo tpl_l("Установлена кодировка соединения `" . $tab_charset[$table] . "`.", C_WARNING);
					$last_charset = $tab_charset[$table];
				}
				else{
					echo tpl_l('Кодировка соединения и таблицы не совпадает:', C_ERROR);
					echo tpl_l('Таблица `'. $table .'` -> ' . $tab_charset[$table] . ' (соединение '  . CHARSET . ')', C_ERROR);
				}
			}
			echo tpl_l("Обработка таблицы `{$table}` [" . fn_int($tabinfo[$table]) . "].");
        	// Создание таблицы
			$result = mysql_query("SHOW CREATE table `{$table}`");
        	$tab = mysql_fetch_array($result);
			$tab = preg_replace('/(default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP|DEFAULT CHARSET=\w+|COLLATE=\w+|character set \w+|collate \w+)/i', '/*!40101 \\1 */', $tab);
        	$this->fn_write($fp, "DROP table IF EXISTS `{$table}`;\n{$tab[1]};\n\n");
        	// Проверяем нужно ли дампить данные
        	if (in_array($tab_type[$table], $this->only_create)) {
				continue;
			}
        	// Опредеделяем типы столбцов
            $NumericColumn = array();
            $result = mysql_query("SHOW COLUMNS FROM `{$table}`");
            $field = 0;
            while($col = mysql_fetch_row($result)) {
            	$NumericColumn[$field++] = preg_match("/^(\w*int|year)/", $col[1]) ? 1 : 0;
            }
			$fields = $field;
            $from = 0;
			$limit = $tabsize[$table];
			$limit2 = round($limit / 3);
			if ($tabinfo[$table] > 0) {
			if ($tabinfo[$table] > $limit2) {
			    echo tpl_s(0, $t / $tabinfo[0]);
			}
			$i = 0;
			$this->fn_write($fp, "INSERT INTO `{$table}` VALUES");
            while(($result = mysql_query("SELECT * FROM `{$table}` LIMIT {$from}, {$limit}")) && ($total = mysql_num_rows($result))){
            		while($row = mysql_fetch_row($result)) {
                    	$i++;
    					$t++;

						for($k = 0; $k < $fields; $k++){
                    		if ($NumericColumn[$k])
                    		    $row[$k] = isset($row[$k]) ? $row[$k] : "NULL";
                    		else
                    			$row[$k] = isset($row[$k]) ? "'" . mysql_escape_string($row[$k]) . "'" : "NULL";
                    	}

    					$this->fn_write($fp, ($i == 1 ? "" : ",") . "\n(" . implode(", ", $row) . ")");
    					if ($i % $limit2 == 0)
    						echo tpl_s($i / $tabinfo[$table], $t / $tabinfo[0]);
               		}
					mysql_free_result($result);
					if ($total < $limit) {
					    break;
					}
    				$from += $limit;
            }

			$this->fn_write($fp, ";\n\n");
    		echo tpl_s(1, $t / $tabinfo[0]);}
		}
		$this->tabs = $tabs;
		$this->records = $tabinfo[0];
		$this->comp = $this->SET['comp_method'] * 10 + $this->SET['comp_level'];
        echo tpl_s(1, 1);
        echo tpl_l(str_repeat("-", 60));
        $this->fn_close($fp);
		echo tpl_l("Резервная копия БД `{$db}` создана.", C_RESULT);
		echo tpl_l("Размер БД:       " . round($this->size / 1048576, 2) . " МБ", C_RESULT);
		$filesize = round(filesize(PATH . $this->filename) / 1048576, 2) . " МБ";
		echo tpl_l("Размер файла: {$filesize}", C_RESULT);
		echo tpl_l("Таблиц обработано: {$tabs}", C_RESULT);
		echo tpl_l("Строк обработано:   " . fn_int($tabinfo[0]), C_RESULT);
		echo "<script>with (document.getElementById('save')) {style.display = ''; innerHTML = 'Скачать файл ({$filesize})'; href = '" . URL . $this->filename . "'; }document.getElementById('back').disabled = 0;</script>";
		// Передача данных для глобальной статистики
		if (GS) echo "<script>document.getElementById('GS').src = 'http://sypex.net/gs.php?b={$this->tabs},{$this->records},{$this->size},{$this->comp},108';</script>";

	}

	function restore(){
		if (!isset($_REQUEST)) {$this->main();}
		set_error_handler("SXD_errorHandler");
		$buttons = "<input id=back type=button class=button value='Вернуться' disabled onclick=\"history.back();\">";
		echo tpl_page(tpl_process("Восстановление БД из резервной копии"), $buttons);

		$this->SET['last_action']     = 1;
		$this->SET['last_db_restore'] = isset($_REQUEST['db_restore']) ? $_REQUEST['db_restore'] : '';
		$file						  = isset($_POST['file']) ? $_POST['file'] : '';
		$this->fn_save();
		$db = $this->SET['last_db_restore'];

		if (!$db) {
			echo tpl_l("ОШИБКА! Не указана база данных!", C_ERROR);
			echo tpl_enableBack();
		    exit;
		}
		echo tpl_l("Подключение к БД `{$db}`.");
		mysql_select_db($db) or trigger_error ("Не удается выбрать базу данных.<br />" . mysql_error(), E_USER_ERROR);

		// Определение формата файла
		if(preg_match("/^(.+?)\.sql(\.(bz2|gz))?$/", $file, $matches)) {
			if (isset($matches[3]) && $matches[3] == 'bz2') {
			    $this->SET['comp_method'] = 2;
			}
			elseif (isset($matches[2]) &&$matches[3] == 'gz'){
				$this->SET['comp_method'] = 1;
			}
			else{
				$this->SET['comp_method'] = 0;
			}
			$this->SET['comp_level'] = '';
			if (!file_exists(PATH . "/{$file}")) {
    		    echo tpl_l("ОШИБКА! Файл не найден!", C_ERROR);
				echo tpl_enableBack();
    		    exit;
    		}
			echo tpl_l("Чтение файла `{$file}`.");
			$file = $matches[1];
		}
		else{
			echo tpl_l("ОШИБКА! Не выбран файл!", C_ERROR);
			echo tpl_enableBack();
		    exit;
		}
		echo tpl_l(str_repeat("-", 60));
		$fp = $this->fn_open($file, "r");
		$this->file_cache = $sql = $table = $insert = '';
        $is_skd = $query_len = $execute = $q =$t = $i = $aff_rows = 0;
		$limit = 300;
        $index = 4;
		$tabs = 0;
		$cache = '';
		$info = array();

		// Установка кодировки соединения
		if ($this->mysql_version > 40101 && (CHARSET != 'auto' || $this->forced_charset)) { // Кодировка по умолчанию, если в дампе не указана кодировка
			mysql_query("SET NAMES '" . $this->restore_charset . "'") or trigger_error ("Неудается изменить кодировку соединения.<br />" . mysql_error(), E_USER_ERROR);
			echo tpl_l("Установлена кодировка соединения `" . $this->restore_charset . "`.", C_WARNING);
			$last_charset = $this->restore_charset;
		}
		else {
			$last_charset = '';
		}
		$last_showed = '';
		while(($str = $this->fn_read_str($fp)) !== false){
			if (empty($str) || preg_match("/^(#|--)/", $str)) {
				if (!$is_skd && preg_match("/^#SKD101\|/", $str)) {
				    $info = explode("|", $str);
					echo tpl_s(0, $t / $info[4]);
					$is_skd = 1;
				}
        	    continue;
        	}
			$query_len += strlen($str);

			if (!$insert && preg_match("/^(INSERT INTO `?([^` ]+)`? .*?VALUES)(.*)$/i", $str, $m)) {
				if ($table != $m[2]) {
				    $table = $m[2];
					$tabs++;
					$cache .= tpl_l("Таблица `{$table}`.");
					$last_showed = $table;
					$i = 0;
					if ($is_skd)
					    echo tpl_s(100 , $t / $info[4]);
				}
        	    $insert = $m[1] . ' ';
				$sql .= $m[3];
				$index++;
				$info[$index] = isset($info[$index]) ? $info[$index] : 0;
				$limit = round($info[$index] / 20);
				$limit = $limit < 300 ? 300 : $limit;
				if ($info[$index] > $limit){
					echo $cache;
					$cache = '';
					echo tpl_s(0 / $info[$index], $t / $info[4]);
				}
        	}
			else{
        		$sql .= $str;
				if ($insert) {
				    $i++;
    				$t++;
    				if ($is_skd && $info[$index] > $limit && $t % $limit == 0){
    					echo tpl_s($i / $info[$index], $t / $info[4]);
    				}
				}
        	}

			if (!$insert && preg_match("/^CREATE table (IF NOT EXISTS )?`?([^` ]+)`?/i", $str, $m) && $table != $m[2]){
				$table = $m[2];
				$insert = '';
				$tabs++;
				$is_create = true;
				$i = 0;
			}
			if ($sql) {
			    if (preg_match("/;$/", $str)) {
            		$sql = rtrim($insert . $sql, ";");
					if (empty($insert)) {
						if ($this->mysql_version < 40101) {
				    		$sql = preg_replace("/ENGINE\s?=/", "type=", $sql);
						}
						elseif (preg_match("/CREATE table/i", $sql)){
							// Выставляем кодировку соединения
							if (preg_match("/(CHARACTER SET|CHARSET)[=\s]+(\w+)/i", $sql, $charset)) {
								if (!$this->forced_charset && $charset[2] != $last_charset) {
									if (CHARSET == 'auto') {
										mysql_query("SET NAMES '" . $charset[2] . "'") or trigger_error ("Неудается изменить кодировку соединения.<br />{$sql}<br />" . mysql_error(), E_USER_ERROR);
										$cache .= tpl_l("Установлена кодировка соединения `" . $charset[2] . "`.", C_WARNING);
										$last_charset = $charset[2];
									}
									else{
										$cache .= tpl_l('Кодировка соединения и таблицы не совпадает:', C_ERROR);
										$cache .= tpl_l('Таблица `'. $table .'` -> ' . $charset[2] . ' (соединение '  . $this->restore_charset . ')', C_ERROR);
									}
								}
								// Меняем кодировку если указано форсировать кодировку
								if ($this->forced_charset) {
									$sql = preg_replace("/(\/\*!\d+\s)?((COLLATE)[=\s]+)\w+(\s+\*\/)?/i", '', $sql);
									$sql = preg_replace("/((CHARACTER SET|CHARSET)[=\s]+)\w+/i", "\\1" . $this->restore_charset . $this->restore_collate, $sql);
								}
							}
							elseif(CHARSET == 'auto'){ // Вставляем кодировку для таблиц, если она не указана и установлена auto кодировка
								$sql .= ' DEFAULT CHARSET=' . $this->restore_charset . $this->restore_collate;
								if ($this->restore_charset != $last_charset) {
									mysql_query("SET NAMES '" . $this->restore_charset . "'") or trigger_error ("Неудается изменить кодировку соединения.<br />{$sql}<br />" . mysql_error(), E_USER_ERROR);
									$cache .= tpl_l("Установлена кодировка соединения `" . $this->restore_charset . "`.", C_WARNING);
									$last_charset = $this->restore_charset;
								}
							}
						}
						if ($last_showed != $table) {$cache .= tpl_l("Таблица `{$table}`."); $last_showed = $table;}
					}
					elseif($this->mysql_version > 40101 && empty($last_charset)) { // Устанавливаем кодировку на случай если отсутствует CREATE table
						mysql_query("SET $this->restore_charset '" . $this->restore_charset . "'") or trigger_error ("Неудается изменить кодировку соединения.<br />{$sql}<br />" . mysql_error(), E_USER_ERROR);
						echo tpl_l("Установлена кодировка соединения `" . $this->restore_charset . "`.", C_WARNING);
						$last_charset = $this->restore_charset;
					}
            		$insert = '';
            	    $execute = 1;
            	}
            	if ($query_len >= 65536 && preg_match("/,$/", $str)) {
            		$sql = rtrim($insert . $sql, ",");
            	    $execute = 1;
            	}
    			if ($execute) {
            		$q++;
            		mysql_query($sql) or trigger_error ("Неправильный запрос.<br />" . mysql_error(), E_USER_ERROR);
					if (preg_match("/^insert/i", $sql)) {
            		    $aff_rows += mysql_affected_rows();
            		}
            		$sql = '';
            		$query_len = 0;
            		$execute = 0;
            	}
			}
		}
		echo $cache;
		echo tpl_s(1 , 1);
		echo tpl_l(str_repeat("-", 60));
		echo tpl_l("БД восстановлена из резервной копии.", C_RESULT);
		if (isset($info[3])) echo tpl_l("Дата создания копии: {$info[3]}", C_RESULT);
		echo tpl_l("Запросов к БД: {$q}", C_RESULT);
		echo tpl_l("Таблиц создано: {$tabs}", C_RESULT);
		echo tpl_l("Строк добавлено: {$aff_rows}", C_RESULT);

		$this->tabs = $tabs;
		$this->records = $aff_rows;
		$this->size = filesize(PATH . $this->filename);
		$this->comp = $this->SET['comp_method'] * 10 + $this->SET['comp_level'];
		echo "<script>document.getElementById('back').disabled = 0;</script>";
		// Передача данных для глобальной статистики
		if (GS) echo "<script>document.getElementById('GS').src = 'http://sypex.net/gs.php?r={$this->tabs},{$this->records},{$this->size},{$this->comp},108';</script>";

		$this->fn_close($fp);
	}

	function main(){
		$this->comp_levels = array('9' => '9 (максимальная)', '8' => '8', '7' => '7', '6' => '6', '5' => '5 (средняя)', '4' => '4', '3' => '3', '2' => '2', '1' => '1 (минимальная)','0' => 'Без сжатия');

		if (function_exists("bzopen")) {
		    $this->comp_methods[2] = 'BZip2';
		}
		if (function_exists("gzopen")) {
		    $this->comp_methods[1] = 'GZip';
		}
		$this->comp_methods[0] = 'Без сжатия';
		if (count($this->comp_methods) == 1) {
		    $this->comp_levels = array('0' =>'Без сжатия');
		}

		$dbs = $this->db_select();
		$this->vars['db_backup']    = $this->fn_select($dbs, $this->SET['last_db_backup']);
		$this->vars['db_restore']   = $this->fn_select($dbs, $this->SET['last_db_restore']);
		$this->vars['comp_levels']  = $this->fn_select($this->comp_levels, $this->SET['comp_level']);
		$this->vars['comp_methods'] = $this->fn_select($this->comp_methods, $this->SET['comp_method']);
		$this->vars['tables']       = $this->SET['tables'];
		$this->vars['files']        = $this->fn_select($this->file_select(), '');
		$buttons = "<input type=submit value=Применить>";
		echo tpl_page(tpl_main(), $buttons);
	}

	function db_select(){
		if (DBNAMES != '') {
			$items = explode(',', trim(DBNAMES));
			foreach($items AS $item){
    			if (mysql_select_db($item)) {
    				$tables = mysql_query("SHOW tableS");
    				if ($tables) {
    	  			    $tabs = mysql_num_rows($tables);
    	  				$dbs[$item] = "{$item} ({$tabs})";
    	  			}
    			}
			}
		}
		else {
    		$result = mysql_query("SHOW DATABASES");
    		$dbs = array();
    		while($item = mysql_fetch_array($result)){
    			if (mysql_select_db($item[0])) {
    				$tables = mysql_query("SHOW tableS");
    				if ($tables) {
    	  			    $tabs = mysql_num_rows($tables);
    	  				$dbs[$item[0]] = "{$item[0]} ({$tabs})";
    	  			}
    			}
    		}
		}
	    return $dbs;
	}

	function file_select(){
		$files = array('' => ' ');
		if (is_dir(PATH) && $handle = opendir(PATH)) {
            while (false !== ($file = readdir($handle))) {
                if (preg_match("/^.+?\.sql(\.(gz|bz2))?$/", $file)) {
                    $files[$file] = $file;
                }
            }
            closedir($handle);
        }
        ksort($files);
		return $files;
	}

	function fn_open($name, $mode){
		if ($this->SET['comp_method'] == 2) {
			$this->filename = "{$name}.sql.bz2";
		    return bzopen(PATH . $this->filename, "{$mode}b{$this->SET['comp_level']}");
		}
		elseif ($this->SET['comp_method'] == 1) {
			$this->filename = "{$name}.sql.gz";
		    return gzopen(PATH . $this->filename, "{$mode}b{$this->SET['comp_level']}");
		}
		else{
			$this->filename = "{$name}.sql";
			return fopen(PATH . $this->filename, "{$mode}b");
		}
	}

	function fn_write($fp, $str){
		if ($this->SET['comp_method'] == 2) {
		    bzwrite($fp, $str);
		}
		elseif ($this->SET['comp_method'] == 1) {
		    gzwrite($fp, $str);
		}
		else{
			fwrite($fp, $str);
		}
	}

	function fn_read($fp){
		if ($this->SET['comp_method'] == 2) {
		    return bzread($fp, 4096);
		}
		elseif ($this->SET['comp_method'] == 1) {
		    return gzread($fp, 4096);
		}
		else{
			return fread($fp, 4096);
		}
	}

	function fn_read_str($fp){
		$string = '';
		$this->file_cache = ltrim($this->file_cache);
		$pos = strpos($this->file_cache, "\n", 0);
		if ($pos < 1) {
			while (!$string && ($str = $this->fn_read($fp))){
    			$pos = strpos($str, "\n", 0);
    			if ($pos === false) {
    			    $this->file_cache .= $str;
    			}
    			else{
    				$string = $this->file_cache . substr($str, 0, $pos);
    				$this->file_cache = substr($str, $pos + 1);
    			}
    		}
			if (!$str) {
			    if ($this->file_cache) {
					$string = $this->file_cache;
					$this->file_cache = '';
				    return trim($string);
				}
			    return false;
			}
		}
		else {
  			$string = substr($this->file_cache, 0, $pos);
  			$this->file_cache = substr($this->file_cache, $pos + 1);
		}
		return trim($string);
	}

	function fn_close($fp){
		if ($this->SET['comp_method'] == 2) {
		    bzclose($fp);
		}
		elseif ($this->SET['comp_method'] == 1) {
		    gzclose($fp);
		}
		else{
			fclose($fp);
		}
		@chmod(PATH . $this->filename, 0666);
		$this->fn_index();
	}

	function fn_select($items, $selected){
		$select = '';
		foreach($items AS $key => $value){
			$select .= $key == $selected ? "<option value='{$key}' selected>{$value}" : "<option value='{$key}'>{$value}";
		}
		return $select;
	}

	function fn_save(){
		if (SC) {
			$ne = !file_exists(PATH . "dumper.cfg.php");
		    $fp = fopen(PATH . "dumper.cfg.php", "wb");
        	fwrite($fp, "<?php\n\$this->SET = " . fn_arr2str($this->SET) . "\n?>");
        	fclose($fp);
			if ($ne) @chmod(PATH . "dumper.cfg.php", 0666);
			$this->fn_index();
		}
	}

	function fn_index(){
		if (!file_exists(PATH . 'index.html')) {
		    $fh = fopen(PATH . 'index.html', 'wb');
			fwrite($fh, tpl_backup_index());
			fclose($fh);
			@chmod(PATH . 'index.html', 0666);
		}
	}
}

function fn_int($num){
	return number_format($num, 0, ',', ' ');
}

function fn_arr2str($array) {
	$str = "array(\n";
	foreach ($array as $key => $value) {
		if (is_array($value)) {
			$str .= "'$key' => " . fn_arr2str($value) . ",\n\n";
		}
		else {
			$str .= "'$key' => '" . str_replace("'", "\'", $value) . "',\n";
		}
	}
	return $str . ")";
}

// Шаблоны

function tpl_page($content = '', $buttons = ''){
return <<<HTML
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td height="60%" align="left" valign="middle">
<table width="360" border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="top" style="border: 1px solid #919B9C;">
<table width="100%" height="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
<form name="skb" method="post" action="backup.php">
<td valign="top" bgcolor="#F4F3EE" style="FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#FCFBFE,endColorStr=#F4F3EE); padding: 8px 8px;">
{$content}
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td style="color: #CECECE" id="timer"></td>
<td align="right">{$buttons}</td>
</tr>
</table></td>
</form>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table>
</td>
</tr>
</table>
HTML;
}

function tpl_main(){
global $SK;
return <<<HTML
<fieldset onclick="document.skb.action[0].checked = 1;">
<legend>
<input type="radio" name="action" value="backup">
Backup / Создание резервной копии БД&nbsp;</legend>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td width="35%">БД:</td>
<td width="65%"><select name="db_backup">
{$SK->vars['db_backup']}
</select></td>
</tr>
<tr>
<td>Фильтр таблиц:</td>
<td><input name="tables" type="text" class="text" value="{$SK->vars['tables']}"></td>
</tr>
<tr>
<td>Метод сжатия:</td>
<td><select name="comp_method">
{$SK->vars['comp_methods']}
</select></td>
</tr>
<tr>
<td>Степень сжатия:</td>
<td><select name="comp_level">
{$SK->vars['comp_levels']}
</select></td>
</tr>
</table>
</fieldset>
<fieldset onclick="document.skb.action[1].checked = 1;">
<legend>
<input type="radio" name="action" value="restore">
Restore / Восстановление БД из резервной копии&nbsp;</legend>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td>БД:</td>
<td><select name="db_restore">
{$SK->vars['db_restore']}
</select></td>
</tr>
<tr>
<td width="35%">Файл:</td>
<td width="65%"><select name="file">
{$SK->vars['files']}
</select></td>
</tr>
</table>
</fieldset>
</span>
<script>
document.skb.action[{$SK->SET['last_action']}].checked = 1;
</script>

HTML;
}

function tpl_process($title){
return <<<HTML
<fieldset>
<legend>{$title}&nbsp;</legend>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr><td colspan="2"><div id="logarea" style="width: 100%; height: 140px; border: 1px solid #7F9DB9; padding: 3px; overflow: auto;"></div></td></tr>
<tr><td width="31%">Статус таблицы:</td><td width="69%"><table width="100%" border="1" cellpadding="0" cellspacing="0">
<tr><td bgcolor="#FFFFFF"><table width="1" border="0" cellpadding="0" cellspacing="0" bgcolor="#5555CC" id="st_tab"
style="FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#CCCCFF,endColorStr=#5555CC);
border-right: 1px solid #AAAAAA"><tr><td height="12"></td></tr></table></td></tr></table></td></tr>
<tr><td>Общий статус:</td><td><table width="100%" border="1" cellspacing="0" cellpadding="0">
<tr><td bgcolor="#FFFFFF"><table width="1" border="0" cellpadding="0" cellspacing="0" bgcolor="#00AA00" id="so_tab"
style="FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#CCFFCC,endColorStr=#00AA00);
border-right: 1px solid #AAAAAA"><tr><td height="12"></td></tr></table></td>
</tr></table></td></tr></table>
</fieldset>
<script>
var WidthLocked = false;
function s(st, so){
	document.getElementById('st_tab').width = st ? st + '%' : '1';
	document.getElementById('so_tab').width = so ? so + '%' : '1';
}
function l(str, color){
	switch(color){
		case 2: color = 'navy'; break;
		case 3: color = 'red'; break;
		case 4: color = 'maroon'; break;
		default: color = 'black';
	}
	with(document.getElementById('logarea')){
		if (!WidthLocked){
			style.width = clientWidth;
			WidthLocked = true;
		}
		str = '<font color=' + color + '>' + str + '</font>';
		innerHTML += innerHTML ? "<br />\\n" + str : str;
		scrollTop += 14;
	}
}
</script>
HTML;
}

function tpl_auth($error){
return <<<HTML
<span id="error">
<fieldset>
<legend>Ошибка</legend>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td>Для работы Sypex Dumper Lite требуется:<br /> - Internet Explorer 5.5+, Mozilla либо Opera 8+ (<span id="sie">-</span>)<br /> - включено выполнение JavaScript скриптов (<span id="sjs">-</span>)</td>
</tr>
</table>
</fieldset>
</span>
<span id="body" style="display: none;">
{$error}
<fieldset>
<legend>Введите логин и пароль</legend>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td width="41%">Логин:</td>
<td width="59%"><input name="login" type="text" class="text"></td>
</tr>
<tr>
<td>Пароль:</td>
<td><input name="pass" type="password" class="text"></td>
</tr>
</table>
</fieldset>
</span>
<script>
document.getElementById('sjs').innerHTML = '+';
document.getElementById('body').style.display = '';
document.getElementById('error').style.display = 'none';
var jsEnabled = true;
</script>
HTML;
}

function tpl_l($str, $color = C_DEFAULT){
$str = preg_replace("/\s{2}/", " &nbsp;", $str);
return <<<HTML
<script>l('{$str}', $color);</script>

HTML;
}

function tpl_enableBack(){
return <<<HTML
<script>document.getElementById('back').disabled = 0;</script>

HTML;
}

function tpl_s($st, $so){
$st = round($st * 100);
$st = $st > 100 ? 100 : $st;
$so = round($so * 100);
$so = $so > 100 ? 100 : $so;
return <<<HTML
<script>s({$st},{$so});</script>

HTML;
}

function tpl_backup_index(){
return <<<HTML
<center>
<h1>У вас нет прав для просмотра этого каталога</h1>
</center>

HTML;
}

function tpl_error($error){
return <<<HTML
<fieldset>
<legend>Ошибка при подключении к БД</legend>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
<tr>
<td align="center">{$error}</td>
</tr>
</table>
</fieldset>

HTML;
}

function SXD_errorHandler($errno, $errmsg, $filename, $linenum, $vars) {
	if ($errno == 2048) return true;
	if (preg_match("/chmod\(\).*?: Operation not permitted/", $errmsg)) return true;
    $dt = date("Y.m.d H:i:s");
    $errmsg = addslashes($errmsg);

	echo tpl_l("{$dt}<br /><b>Возникла ошибка!</b>", C_ERROR);
	echo tpl_l("{$errmsg} ({$errno})", C_ERROR);
	echo tpl_enableBack();
	die();
}
?>

</td>

          </tr>
        </table></td>
      </tr>

<tr>
<td align="center">
Powered by <a href=http://sypex.net/products/dumper/>Sypex Dumper Lite</a>
</td>
</tr>
     
    </table></td>
<!-- body_text_eof //-->
  </tr>
      
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>