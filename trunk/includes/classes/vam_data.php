<?php

require_once (HOME_DIR . '/includes/external/adodb/adodb.inc.php');

$dbdriver = 'mysql';
$charset = 'utf-8';
$server = 'localhost';
$user = 'root';
$password = '';
$database = 'vam-cms';

$vamData = ADONewConnection($dbdriver);
$vamData->debug = false;
$vamData->charset = $charset;
//$vamData->cacheSecs = 3600*24;
$vamData->Connect($server, $user, $password, $database);

?>