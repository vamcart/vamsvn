<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_db_error.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(database.php,v 1.19 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_db_error.inc.php,v 1.4 2003/08/19); www.nextcommerce.org 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
//  function xtc_db_error($query, $errno, $error) { 
//    die('<font color="#000000"><b>' . $errno . ' - ' . $error . '<br /><br />' . $query . '<br /><br /><small><font color="#ff0000">[XT SQL Error]</font></small><br /><br /></b></font>');
//  }
  
function xtc_db_error($query, $errno, $error) {
// BOF db-error processing
   include(DIR_WS_LANGUAGES . 'russian/russian_db_error.php');
   $msg = "\n" . 'MYSQL QUERY ERROR REPORT' . "\n" . " - " . date("d/m/Y H:m:s",time()) . "\n" . '---------------------------------------' . "\n";
   $msg .= $errno . ' - ' . $error . "\n\n" . $query . "\n";
   $msg .= '---------------------------------------' . "\n";
   $msg .= 'Server Name   : ' . $_SERVER['SERVER_NAME'] . "\n";
   $msg .= 'Remote Address: ' . $_SERVER['REMOTE_ADDR'] . "\n";
   $msg .= 'Referer       : ' . $_SERVER["HTTP_REFERER"] . "\n";
   $msg .= 'Requested     : ' . $_SERVER["REQUEST_URI"] . "\n";
   $msg .= 'Trace Back    : ' . str_replace(DIR_FS_CATALOG, '', str_replace('\\', '/', implode(" => ", zen_trace_back('', 0 , 1, true))))."\n";;
   if(defined('DEBUG') && DEBUG == true) {
			echo(nl2br($msg));
			die('==========================================================================');
	 }
   $log = date("d/m/Y H:m:s",time()) . ' | ' . $errno . ' - ' . $error . ' | ' . $query . ' | ' . $_SERVER["REQUEST_URI"] . "\n";
	 error_log($log, 3, 'mysql_db_error.log');
   mail(DB_ERR_MAIL, '�������� � MySQL ��������!', $msg,
        'From: db_error@'.$_SERVER["SERVER_NAME"]);
if (!headers_sent() && file_exists('db_error.html') ) {
     header('Location: db_error.html');
     //include('db_error.html');
   }
   die(DB_ERR_MSG);
}

function zen_trace_back($backtrace=false, $from=0, $to=0, $get_call=true) {
	if (!$backtrace)
		$backtrace = debug_backtrace();
	$output = array();
	for ($i=count($backtrace)-1-$from;$i>$to-1;$i--) {
		$args = '';
		if ($get_call && is_array($backtrace[$i]['args'])){
			$args = str_replace("\n", "; ", zen_trace_vardump($backtrace[$i]['args']));
/*
			foreach ($backtrace[$i]['args'] as $a) {
				if (!empty($args))
					$args .= ', ';
				switch (gettype($a)) {
					case 'integer':
					case 'double':
						$args .= $a;
						break;
					case 'string':
						$a = substr($a, 0, 64).((strlen($a) > 64) ? '...' : '');
						$args .= "\"$a\"";
						break;
					case 'array':
						$args .= 'Array('.count($a).')';
						break;
					case 'object':
						$args .= 'Object('.get_class($a).')';
						break;
					case 'resource':
						$args .= 'Resource('.strstr($a, '#').')';
						break;
					case 'boolean':
						$args .= $a ? 'True' : 'False';
						break;
					case 'NULL':
						$args .= 'Null';
						break;
					default:
						$args .= 'Unknown';
				}
			}
*/
		}
		$output[] = $backtrace[$i]['file'].":".$backtrace[$i]['line'] . (($get_call) ? "(".$backtrace[$i]['class'].$backtrace[$i]['type'].$backtrace[$i]['function'].$args.")" : "");
	}
	return $output;
}

	function zen_trace_vardump($var){
		ob_start();
		var_dump($var);
		$out = ob_get_contents();
		ob_end_clean();
		return($out);
	}

// EOF db-error processing
  
 ?>