<?php
/* --------------------------------------------------------------
   $Id: contrib_installer.php 950 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2004 osCommerce (contrib_installer.php,v 1.6 2003/08/18); oscommerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

    // SQL begin ===========================================================
    function cip_db_query($query, $report='no', $link = 'db_link') {
        //     $report manage a way of error reporting and can be:
        //     no, direct, return, add_session, add
        global $$link, $logger, $message;
        $result = mysql_query($query, $$link);

        if (defined('STORE_DB_TRANSACTIONS') && (STORE_DB_TRANSACTIONS == 'true')) {
            if (!is_object($logger))     $logger = new logger;
            $logger->write($query, 'QUERY');
            if ($result===false)     $logger->write(mysql_error(), 'ERROR');
        }
        if ($result===false) {
            $error='SQL error :<b>'.mysql_errno().' - '.mysql_error().'<br>'.$query;

            if ($report=='direct')    echo $error;
            elseif ($report=='return')     $result=$error;
            elseif ($report=='add')     $message->add($error, 'error');
            elseif ($report=='add_session')     $message->add_session($error, 'error');
            return false;
        } else {
            //         Только для запросов SELECT, SHOW, EXPLAIN, DESCRIBE
            //         mysql_query() возвращает указатель на результат запроса
            return $result;
        }
    }

    function sql_error($query) {return 'SQL error : '.mysql_errno().' - '.mysql_error().'<br>'.$query;}


    /*
    Usage:
            $restore_query=file_get_contents($backup_file);
            $sql_array=parse_sql($restore_query);
            foreach ($sql_array as $query)     tep_db_query($query);
            //for ($i=0, $n=sizeof($sql_array); $i<$n; $i++)     tep_db_query($sql_array[$i]);
    */
    function parse_sql($restore_query='') {
        //tep_set_time_limit(0);

        if (!$restore_query)    return;
        //From backup.php (begin)
        $sql_array = array();
        $sql_length = strlen($restore_query);
        $pos = strpos($restore_query, ';');

        if (($sql_length-$pos)==1)     return array($restore_query);

        for ($i=$pos; $i<$sql_length; $i++) {
            if ($restore_query[0] == '#') {
                $restore_query = ltrim(substr($restore_query, strpos($restore_query, "\n")));
                $sql_length = strlen($restore_query);
                $i = strpos($restore_query, ';')-1;
                continue;
            }
 	    if (($sql_length-$i)==1){
		     $sql_array[] = $restore_query;
	    }else if ($restore_query[($i+1)] == "\n") {
                for ($j=($i+2); $j<$sql_length; $j++) {
                    if (trim($restore_query[$j]) != '') {
                    $next = substr($restore_query, $j, 6);
                        if ($next[0] == '#') {
                            // find out where the break position is so we can remove this line (#comment line)
                            for ($k=$j; $k<$sql_length; $k++)     if ($restore_query[$k] == "\n")    break;
                            $query = substr($restore_query, 0, $i+1);
                            $restore_query = substr($restore_query, $k);
                            // join the query before the comment appeared, with the rest of the dump
                            $restore_query = $query . $restore_query;
                            $sql_length = strlen($restore_query);
                            $i = strpos($restore_query, ';')-1;
                            continue 2;
                        }
                        break;
                    }
                }
                if ($next == '') { // get the last insert query
                    $next = 'insert';
                }
                if ((preg_match('/update/i', $next)) || (preg_match('/create/i', $next)) || (preg_match('/insert/i', $next)) || (preg_match('/drop t/i', $next)) ) {
                    $next = '';
                    $sql_array[] = substr($restore_query, 0, $i);
                    $restore_query = ltrim(substr($restore_query, $i+1));
                    $sql_length = strlen($restore_query);
                    $i = strpos($restore_query, ';')-1;
                }
            }
        }
        return $sql_array;
    }
    // SQL end =============================================================





    function ci_remove($source) {
        //Return true if error.
        global $message;

        if (!is_file($source) and !is_dir($source))    return;
        if (is_dir($source)) {
            $dir = dir($source);
            //if (!is_object($dir))    return;
            while ($file = $dir->read()) {
                if ( ($file!='.') && ($file!='..') ) {
                    if (is_writeable($source.'/'.$file)) {
                        if (ci_remove($source.'/'.$file))    return true;
                    } else {
                        $message->add(sprintf(ERROR_FILE_NOT_REMOVEABLE, $source.'/'.$file), 'error');
                        return true;
                    }
                }
            }
            $dir->close();
            if (is_writeable($source))     @rmdir($source);
            else {
                $message->add(sprintf(ERROR_DIRECTORY_NOT_REMOVEABLE, $source), 'error');
                return true;
             }
        } else {
            if (is_writeable($source))    @unlink($source);
            else {
                $message->add(sprintf(ERROR_FILE_NOT_REMOVEABLE, $source), 'error');
                return true;
            }
        }
    }



//=================================================
/**
 * Function to print an array within pre tags, debug use
 * @author Bobby Easland
 * @version 1.0
 * @param mixed $array
 */
	function PrintArray($array, $heading = ''){
		echo '<fieldset style="border:solid 1px silver;">' . "\n";
		echo '<legend style="background-color:#FFFFCC; border-style:solid; border-width:1px;">' . $heading . '</legend>' . "\n";
		echo '<pre style="text-align:left;">' . "\n";
		print_r($array);
		echo '</pre>' . "\n";
		echo '</fieldset><br/>' . "\n";
	} # end function


    function echo_array($array, $tab='') {    // Тест ЛЮБОГО массива
            $tab=$tab.'<img width="20"> ';
            if (is_array($array) ) {
                foreach ($array as $key =>$value) {
                    if (is_array($value) ) {
                        echo $tab."<br>".$key." (array): <br>";
                        echo_array($value, $tab);
                    } else echo $tab.$key." =>  ".linebreak_view($value)."<br>";
                }
            } else echo htmlentities(linebreak_view($array));
            echo "<hr>";
    }










//============================================================

    function unicode2win_old($str, $charset='cp1251') {

        //return unicode_russian($str);//win1251

        return $str;//win1251
        //return htmlentities($str);
        //return html_entity_decode($str, ENT_COMPAT, $charset);//old
    }

	function unicode2win($str, $charset = 'UTF-8') {
		if (function_exists('iconv') && 'UTF-8' != strtoupper($charset)) {
			$str = iconv("UTF-8", $charset, $str);
		}
	return $str;
}


//http://ua2.php.net/manual/en/function.convert-cyr-string.php
// Modificated by tapin13
 // Corrected by Timuretis
 // Convert win-1251 to utf-8



  function unicode_russian($str) {
      $encode = "";
      for ($ii=0;$ii<strlen($str);$ii++) {
          $xchr=substr($str,$ii,1);
          if (ord($xchr)>191) {
              $xchr=ord($xchr)+848;
              $xchr="&#" . $xchr . ";";
          }
          if(ord($xchr) == 168)     $xchr = "&#1025;";
          if(ord($xchr) == 184)     $xchr = "&#1105;";
          $encode=$encode . $xchr;
    }
      return $encode;
 }



 //http://ua2.php.net/manual/en/function.convert-cyr-string.php
function Encode($str, $type ){
  // $type:
 // 'w' - encodes from UTF to win
  // 'u' - encodes from win to UTF

    static $conv='';
        if (!is_array ( $conv )) {
            $conv=array ();
            for ( $x=128; $x <=143; $x++ ) {
            $conv['utf'][]=chr(209).chr($x);
            $conv['win'][]=chr($x+112);
            }

            for ( $x=144; $x <=191; $x++ ) {
                    $conv['utf'][]=chr(208).chr($x);
                    $conv['win'][]=chr($x+48);
            }
            $conv['utf'][]=chr(208).chr(129);
            $conv['win'][]=chr(168);
            $conv['utf'][]=chr(209).chr(145);
            $conv['win'][]=chr(184);
      }
      if ( $type=='w' )    return str_replace ( $conv['utf'], $conv['win'], $str );
      elseif ( $type=='u' )    return str_replace ( $conv['win'], $conv['utf'], $str );
      else    return $str;
   }















//Vlad Savitsky:
/*
    function recursive_permissions_check($path) {
    //if not writeable returns path to unwriteable folder
    //if all is writeable returns 0 (zero)
        if ($path!='/' && $path) {
            $result=recursive_permissions_check(dirname($path));
            //Displays all unwritable folders in path:
            //chmod($path, 0777);
            if(!is_writable($path) && is_dir($path))     return $result."<br>".$path."/";
            return $result;

            //Displays one uppest unwritable folder:
//            if (!$result)     if(!is_writable($path)) return $result."<br>".$path
//            else return $result;

        }
    }
*/

//php.net:

//Not used:
function recurse_chown_chgrp($mypath, $uid, $gid) {
    $d = opendir ($mypath) ;
    while(($file = readdir($d)) !== false) {
        if ($file != "." && $file != "..") {
            $typepath = $mypath . "/" . $file ;
            //print $typepath. " : " . filetype ($typepath). "<BR>" ;
            if (filetype ($typepath) == 'dir')     recurse_chown_chgrp ($typepath, $uid, $gid);
            chown($typepath, $uid);
            chgrp($typepath, $gid);
        }
    }
}

//Not used:
function recursive_chmod($path, $mod=0777) {
    if (is_dir($path) && $path!='/') {
        recursive_chmod(dirname($path));
        //echo "chmod: ".$path." - ".$mod."<br>";
        chmod($path, $mod);
    }
}




//Vlad Savitsky:

    function get_all_files_in_tree( $dir='', $exclude_files=array(), $exclude_folders=array()) {
        if (!$dir)    $dir=DIR_FS_CURRENT;
        $files=array();
        $all_folders=get_all_folders_in_tree($dir, $exclude_folders);
        foreach ($all_folders as $folder) {
            $inner_files=get_all_files_in_dir($folder, $exclude_files);
            if (count($inner_files)>0)     foreach ($inner_files as $file)     $files[]=$folder.$file;
        }
        return $files;
    }


    function get_all_folders_in_tree($dir='', $exclude_folders=array()) {
    //Исключаются папки содержащие лунакод.

        if (!$dir)    $dir=DIR_FS_CURRENT;
        $folders[0]=$dir;
        for ($i=0; $i<=count($folders); $i++) {
            if(isset($folders[$i])) {
                if ($folders[$i])      $inner_folders=get_all_folders_in_dir($folders[$i], $exclude_folders);
                if (count($inner_folders)>0) {
                    foreach ($inner_folders as $folder)     $folders[]=$folders[$i]. $folder."/";
                }
            }
        }
        return $folders;
    }

    function get_all_folders_in_dir($dir='', $exclude_folders=array()) {
        if (!$dir)    $dir=DIR_FS_CURRENT;
        $dirs=array();
        if ($dir!=DIR_FS_CURRENT)     if (!is_dir($dir))     return array();
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                $firstchar=substr($file, 0, 1);
                if($file!=".." && !in_array($file, $exclude_folders) && $firstchar!="_" && $firstchar!="."  ) {
                    if (is_dir($dir.$file))     $dirs[]= $file;
                }
            }
            closedir($dh);
        }
        return $dirs;
    }

    function get_all_files_in_dir($dir='', $exclude_files=array()) {
        $files=array();
        if (!$dir)    $dir=DIR_FS_CURRENT;
        if ($dir!=DIR_FS_CURRENT)     if (!is_dir($dir))     return array();
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if (!in_array($file, $exclude_files) && substr($file, 0, 1)!="_" ) {
                    if (is_file($dir.$file))     $files[]= $file;
                }
            }
            closedir($dh);
        }
        return $files;
    }

	function gzcompressfile($source,$level=false){
	   $dest=$source.'.gz';
	   $mode='wb'.$level;
	   $error=false;
	   if($fp_out=gzopen($dest,$mode)){
	       if($fp_in=fopen($source,'rb')){
	           while(!feof($fp_in))
	               gzwrite($fp_out,fread($fp_in,1024*512));
	           fclose($fp_in);
	           }
	         else $error=true;
	       gzclose($fp_out);
	       }
	     else $error=true;
	   if($error) return false;
	     else return $dest;
	}
?>