<?php
/* --------------------------------------------------------------
   $Id: parameters_export.php 1167 2009-04-29 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2009 VaM Shop
   --------------------------------------------------------------
   Released under the GNU General Public License 
   --------------------------------------------------------------*/
   
require('includes/application_top.php');

ini_set('include_path', DIR_FS_DOCUMENT_ROOT.'excel/');

include("dataprovider.php");
include("exceldate.php");
include("excelfont.php");
include("excelparser.php");

function get_exel_data($file = "") {
	if (empty($file)) return false;

	$exc = new ExcelFileParser();
	$res = $exc->ParseFromFile( $file );

	switch ($res) {
		case 0: break;
		case 1: return ERROR_OPENFILE;
		case 2: return ERROR_SMALLFILE;
		case 3: return ERROR_HEADERFILE;
		case 4: return ERROR_READFILE;
		case 5: return ERROR_FORMATFILE;
		case 6: return ERROR_BADFILE;
		case 7: return ERROR_BADDATA;
		case 8: return ERROR_VERSIONFILE;

		default:
			return ERROR_UNKNOWN;
	}

	$ws = $exc->worksheet['data'][0];
	$data = array();
	foreach($exc->worksheet['data'] as $page_num => $page) {
		  if( $exc->worksheet['unicode'][$page_num] ) {
			  $page_name = uc2html($exc->worksheet['name'][$page_num]);
		  } else {
			  $page_name = $exc->worksheet['name'][$page_num];
		}
		$data[$page_num]["pagename"] = $page_name;
		$data[$page_num]["pagenum"] = $page_num;
		$data[$page_num]["rows"] = sizeof($page['cell']);
		foreach($page['cell'] as $row_num => $row) {
			if (sizeof($row) > $data[$page_num]["cells"]) $data[$page_num]["cells"] = sizeof($row)-1;
			if (sizeof($row) > $max_cells) $max_cells = sizeof($row)-1;
			foreach($row as $cell_num => $cell) {
				$data[$page_num]["data"][$row_num][$cell_num] = get_data($cell, $exc);
			}
		}
		foreach($data[$page_num]["data"] as $row_num => $cells) {
			reset($cells);
			$temp = array();
			for($i = 0; $i <= $max_cells; $i++) {
			   if (!isset($cells[$i])) {
				   $temp[$i] = "";
			   } else {
				   $temp[$i] = $cells[$i];
			   }
			   $data[$page_num]["data"][$row_num] = $temp;
			}

			ksort($data[$page_num]["data"][$row_num]);
		}
	}

	$data = convert_charcode($data, "win1251", "utf-8");
	return $data;
}


function uc2html($str) {
	$recode = array(
	0x0402,0x0403,0x201A,0x0453,0x201E,0x2026,0x2020,0x2021,
	0x20AC,0x2030,0x0409,0x2039,0x040A,0x040C,0x040B,0x040F,
	0x0452,0x2018,0x2019,0x201C,0x201D,0x2022,0x2013,0x2014,
	0x0000,0x2122,0x0459,0x203A,0x045A,0x045C,0x045B,0x045F,
	0x00A0,0x040E,0x045E,0x0408,0x00A4,0x0490,0x00A6,0x00A7,
	0x0401,0x00A9,0x0404,0x00AB,0x00AC,0x00AD,0x00AE,0x0407,
	0x00B0,0x00B1,0x0406,0x0456,0x0491,0x00B5,0x00B6,0x00B7,
	0x0451,0x2116,0x0454,0x00BB,0x0458,0x0405,0x0455,0x0457,
	0x0410,0x0411,0x0412,0x0413,0x0414,0x0415,0x0416,0x0417,
	0x0418,0x0419,0x041A,0x041B,0x041C,0x041D,0x041E,0x041F,
	0x0420,0x0421,0x0422,0x0423,0x0424,0x0425,0x0426,0x0427,
	0x0428,0x0429,0x042A,0x042B,0x042C,0x042D,0x042E,0x042F,
	0x0430,0x0431,0x0432,0x0433,0x0434,0x0435,0x0436,0x0437,
	0x0438,0x0439,0x043A,0x043B,0x043C,0x043D,0x043E,0x043F,
	0x0440,0x0441,0x0442,0x0443,0x0444,0x0445,0x0446,0x0447,
	0x0448,0x0449,0x044A,0x044B,0x044C,0x044D,0x044E,0x044F
	);

	$ret = '';
	for( $i=0; $i<strlen($str)/2; $i++ ) {
		$charcode = ord($str[$i*2])+256*ord($str[$i*2+1]);
		//$ret .= '&#'.$charcode;
		if ($charcode < 0x80) {
				$ret .= chr($charcode);
		} else {
				if (in_array($charcode, $recode)) {
					$ret .= chr(array_search($charcode,$recode)+128);
				}
		}

	}
	return $ret;
}

function get_data($data, $exc) {
	   switch ($data['type']) {
		// строка
		case 0:
			$ind = $data['data'];
			if( $exc->sst['unicode'][$ind] ) {
				$s = $exc->sst['data'][$ind];
				$s = uc2html($s);
			} else
				$s = $exc->sst['data'][$ind];
			if( strlen(trim($s))==0 )
				$s = "&nbsp;";
			break;
		//целое число
		case 1:
			$s = (int)($data['data']);
			break;
		//вещественное число
		case 2:
			$s = (float)($data['data']);
			break;
		// дата
		case 3:
			$ret = $exc->getDateArray($data['data']);
			$s = sprintf ("%s-%s-%s",$ret['day'], $ret['month'], $ret['year']);
			break;
	   }
	   return $s;
}

function utf_to_win($str,$to = "w") {
	if (function_exists('iconv'))
	{
		return iconv("UTF-8", $to == 'w' ? "WINDOWS-1251" : "KOI8-R", $str);
	}
	if (function_exists('mb_convert_encoding'))
	{
		return mb_convert_encoding($str, $to == 'w' ? "WINDOWS-1251" : "KOI8-R", "UTF-8");
	}

	$outstr='';
	$recode=array();
	$recode['k']=array(
	0x2500,0x2502,0x250c,0x2510,0x2514,0x2518,0x251c,0x2524,
	0x252c,0x2534,0x253c,0x2580,0x2584,0x2588,0x258c,0x2590,
	0x2591,0x2592,0x2593,0x2320,0x25a0,0x2219,0x221a,0x2248,
	0x2264,0x2265,0x00a0,0x2321,0x00b0,0x00b2,0x00b7,0x00f7,
	0x2550,0x2551,0x2552,0x0451,0x2553,0x2554,0x2555,0x2556,
	0x2557,0x2558,0x2559,0x255a,0x255b,0x255c,0x255d,0x255e,
	0x255f,0x2560,0x2561,0x0401,0x2562,0x2563,0x2564,0x2565,
	0x2566,0x2567,0x2568,0x2569,0x256a,0x256b,0x256c,0x00a9,
	0x044e,0x0430,0x0431,0x0446,0x0434,0x0435,0x0444,0x0433,
	0x0445,0x0438,0x0439,0x043a,0x043b,0x043c,0x043d,0x043e,
	0x043f,0x044f,0x0440,0x0441,0x0442,0x0443,0x0436,0x0432,
	0x044c,0x044b,0x0437,0x0448,0x044d,0x0449,0x0447,0x044a,
	0x042e,0x0410,0x0411,0x0426,0x0414,0x0415,0x0424,0x0413,
	0x0425,0x0418,0x0419,0x041a,0x041b,0x041c,0x041d,0x041e,
	0x041f,0x042f,0x0420,0x0421,0x0422,0x0423,0x0416,0x0412,
	0x042c,0x042b,0x0417,0x0428,0x042d,0x0429,0x0427,0x042a
	);
	$recode['w']=array(
	0x0402,0x0403,0x201A,0x0453,0x201E,0x2026,0x2020,0x2021,
	0x20AC,0x2030,0x0409,0x2039,0x040A,0x040C,0x040B,0x040F,
	0x0452,0x2018,0x2019,0x201C,0x201D,0x2022,0x2013,0x2014,
	0x0000,0x2122,0x0459,0x203A,0x045A,0x045C,0x045B,0x045F,
	0x00A0,0x040E,0x045E,0x0408,0x00A4,0x0490,0x00A6,0x00A7,
	0x0401,0x00A9,0x0404,0x00AB,0x00AC,0x00AD,0x00AE,0x0407,
	0x00B0,0x00B1,0x0406,0x0456,0x0491,0x00B5,0x00B6,0x00B7,
	0x0451,0x2116,0x0454,0x00BB,0x0458,0x0405,0x0455,0x0457,
	0x0410,0x0411,0x0412,0x0413,0x0414,0x0415,0x0416,0x0417,
	0x0418,0x0419,0x041A,0x041B,0x041C,0x041D,0x041E,0x041F,
	0x0420,0x0421,0x0422,0x0423,0x0424,0x0425,0x0426,0x0427,
	0x0428,0x0429,0x042A,0x042B,0x042C,0x042D,0x042E,0x042F,
	0x0430,0x0431,0x0432,0x0433,0x0434,0x0435,0x0436,0x0437,
	0x0438,0x0439,0x043A,0x043B,0x043C,0x043D,0x043E,0x043F,
	0x0440,0x0441,0x0442,0x0443,0x0444,0x0445,0x0446,0x0447,
	0x0448,0x0449,0x044A,0x044B,0x044C,0x044D,0x044E,0x044F
	);
	$recode['i']=array(
	0x0080,0x0081,0x0082,0x0083,0x0084,0x0085,0x0086,0x0087,
	0x0088,0x0089,0x008A,0x008B,0x008C,0x008D,0x008E,0x008F,
	0x0090,0x0091,0x0092,0x0093,0x0094,0x0095,0x0096,0x0097,
	0x0098,0x0099,0x009A,0x009B,0x009C,0x009D,0x009E,0x009F,
	0x00A0,0x0401,0x0402,0x0403,0x0404,0x0405,0x0406,0x0407,
	0x0408,0x0409,0x040A,0x040B,0x040C,0x00AD,0x040E,0x040F,
	0x0410,0x0411,0x0412,0x0413,0x0414,0x0415,0x0416,0x0417,
	0x0418,0x0419,0x041A,0x041B,0x041C,0x041D,0x041E,0x041F,
	0x0420,0x0421,0x0422,0x0423,0x0424,0x0425,0x0426,0x0427,
	0x0428,0x0429,0x042A,0x042B,0x042C,0x042D,0x042E,0x042F,
	0x0430,0x0431,0x0432,0x0433,0x0434,0x0435,0x0436,0x0437,
	0x0438,0x0439,0x043A,0x043B,0x043C,0x043D,0x043E,0x043F,
	0x0440,0x0441,0x0442,0x0443,0x0444,0x0445,0x0446,0x0447,
	0x0448,0x0449,0x044A,0x044B,0x044C,0x044D,0x044E,0x044F,
	0x2116,0x0451,0x0452,0x0453,0x0454,0x0455,0x0456,0x0457,
	0x0458,0x0459,0x045A,0x045B,0x045C,0x00A7,0x045E,0x045F
	);
	$recode['a']=array(
	0x0410,0x0411,0x0412,0x0413,0x0414,0x0415,0x0416,0x0417,
	0x0418,0x0419,0x041a,0x041b,0x041c,0x041d,0x041e,0x041f,
	0x0420,0x0421,0x0422,0x0423,0x0424,0x0425,0x0426,0x0427,
	0x0428,0x0429,0x042a,0x042b,0x042c,0x042d,0x042e,0x042f,
	0x0430,0x0431,0x0432,0x0433,0x0434,0x0435,0x0436,0x0437,
	0x0438,0x0439,0x043a,0x043b,0x043c,0x043d,0x043e,0x043f,
	0x2591,0x2592,0x2593,0x2502,0x2524,0x2561,0x2562,0x2556,
	0x2555,0x2563,0x2551,0x2557,0x255d,0x255c,0x255b,0x2510,
	0x2514,0x2534,0x252c,0x251c,0x2500,0x253c,0x255e,0x255f,
	0x255a,0x2554,0x2569,0x2566,0x2560,0x2550,0x256c,0x2567,
	0x2568,0x2564,0x2565,0x2559,0x2558,0x2552,0x2553,0x256b,
	0x256a,0x2518,0x250c,0x2588,0x2584,0x258c,0x2590,0x2580,
	0x0440,0x0441,0x0442,0x0443,0x0444,0x0445,0x0446,0x0447,
	0x0448,0x0449,0x044a,0x044b,0x044c,0x044d,0x044e,0x044f,
	0x0401,0x0451,0x0404,0x0454,0x0407,0x0457,0x040e,0x045e,
	0x00b0,0x2219,0x00b7,0x221a,0x2116,0x00a4,0x25a0,0x00a0
	);
	$recode['d']=$recode['a'];
	$recode['m']=array(
	0x0410,0x0411,0x0412,0x0413,0x0414,0x0415,0x0416,0x0417,
	0x0418,0x0419,0x041A,0x041B,0x041C,0x041D,0x041E,0x041F,
	0x0420,0x0421,0x0422,0x0423,0x0424,0x0425,0x0426,0x0427,
	0x0428,0x0429,0x042A,0x042B,0x042C,0x042D,0x042E,0x042F,
	0x2020,0x00B0,0x00A2,0x00A3,0x00A7,0x2022,0x00B6,0x0406,
	0x00AE,0x00A9,0x2122,0x0402,0x0452,0x2260,0x0403,0x0453,
	0x221E,0x00B1,0x2264,0x2265,0x0456,0x00B5,0x2202,0x0408,
	0x0404,0x0454,0x0407,0x0457,0x0409,0x0459,0x040A,0x045A,
	0x0458,0x0405,0x00AC,0x221A,0x0192,0x2248,0x2206,0x00AB,
	0x00BB,0x2026,0x00A0,0x040B,0x045B,0x040C,0x045C,0x0455,
	0x2013,0x2014,0x201C,0x201D,0x2018,0x2019,0x00F7,0x201E,
	0x040E,0x045E,0x040F,0x045F,0x2116,0x0401,0x0451,0x044F,
	0x0430,0x0431,0x0432,0x0433,0x0434,0x0435,0x0436,0x0437,
	0x0438,0x0439,0x043A,0x043B,0x043C,0x043D,0x043E,0x043F,
	0x0440,0x0441,0x0442,0x0443,0x0444,0x0445,0x0446,0x0447,
	0x0448,0x0449,0x044A,0x044B,0x044C,0x044D,0x044E,0x00A4
	);
	$and=0x3F;
	for ($i=0;$i<strlen($str);$i++) {
		$letter=0x0;
		$octet=array();
		$octet[0]=ord($str[$i]);
		$octets=1;
		$andfirst=0x7F;
		if (($octet[0]>>1)==0x7E) {
			$octets=6;
			$andfirst=0x1;
		} elseif (($octet[0]>>2)==0x3E) {
			$octets=5;
			$andfirst=0x3;
		} elseif (($octet[0]>>3)==0x1E) {
			$octets=4;
			$andfirst=0x7;
		} elseif (($octet[0]>>4)==0xE) {
			$octets=3;
			$andfirst=0xF;
		} elseif (($octet[0]>>5)==0x6) {
			$octets=2;
			$andfirst=0x1F;
		}
		$octet[0]=$octet[0] & $andfirst;
		$octet[0]=$octet[0] << ($octets-1)*6;
		$letter+=$octet[0];
		for ($j=1;$j<$octets;$j++) {
			$i++;
			$octet[$j]=ord($str[$i]) & $and;
			$octet[$j]=$octet[$j] << ($octets-1-$j)*6;
			$letter+=$octet[$j];
		}
		if ($letter<0x80) {
			$outstr.=chr($letter);
		} else {
			if (in_array($letter,$recode[$to])) {
				$outstr.=chr(array_search($letter,$recode[$to])+128);
			}
		}
	}
	return($outstr);
}

function win_to_utf($str, $from = "w") {
	if (function_exists('iconv'))
	{
		return iconv($from == 'w' ? "WINDOWS-1251" : "KOI8-R", "UTF-8", $str);
	}
	if (function_exists('mb_convert_encoding'))
	{
		return mb_convert_encoding($str, "UTF-8", $from == 'w' ? "WINDOWS-1251" : "KOI8-R");
	}

	$recode['w']=array(
	0x0402,0x0403,0x201A,0x0453,0x201E,0x2026,0x2020,0x2021,
	0x20AC,0x2030,0x0409,0x2039,0x040A,0x040C,0x040B,0x040F,
	0x0452,0x2018,0x2019,0x201C,0x201D,0x2022,0x2013,0x2014,
	0x0000,0x2122,0x0459,0x203A,0x045A,0x045C,0x045B,0x045F,
	0x00A0,0x040E,0x045E,0x0408,0x00A4,0x0490,0x00A6,0x00A7,
	0x0401,0x00A9,0x0404,0x00AB,0x00AC,0x00AD,0x00AE,0x0407,
	0x00B0,0x00B1,0x0406,0x0456,0x0491,0x00B5,0x00B6,0x00B7,
	0x0451,0x2116,0x0454,0x00BB,0x0458,0x0405,0x0455,0x0457,
	0x0410,0x0411,0x0412,0x0413,0x0414,0x0415,0x0416,0x0417,
	0x0418,0x0419,0x041A,0x041B,0x041C,0x041D,0x041E,0x041F,
	0x0420,0x0421,0x0422,0x0423,0x0424,0x0425,0x0426,0x0427,
	0x0428,0x0429,0x042A,0x042B,0x042C,0x042D,0x042E,0x042F,
	0x0430,0x0431,0x0432,0x0433,0x0434,0x0435,0x0436,0x0437,
	0x0438,0x0439,0x043A,0x043B,0x043C,0x043D,0x043E,0x043F,
	0x0440,0x0441,0x0442,0x0443,0x0444,0x0445,0x0446,0x0447,
	0x0448,0x0449,0x044A,0x044B,0x044C,0x044D,0x044E,0x044F
	);

	$recode['k']=array(
	0x2500,0x2502,0x250c,0x2510,0x2514,0x2518,0x251c,0x2524,
	0x252c,0x2534,0x253c,0x2580,0x2584,0x2588,0x258c,0x2590,
	0x2591,0x2592,0x2593,0x2320,0x25a0,0x2219,0x221a,0x2248,
	0x2264,0x2265,0x00a0,0x2321,0x00b0,0x00b2,0x00b7,0x00f7,
	0x2550,0x2551,0x2552,0x0451,0x2553,0x2554,0x2555,0x2556,
	0x2557,0x2558,0x2559,0x255a,0x255b,0x255c,0x255d,0x255e,
	0x255f,0x2560,0x2561,0x0401,0x2562,0x2563,0x2564,0x2565,
	0x2566,0x2567,0x2568,0x2569,0x256a,0x256b,0x256c,0x00a9,
	0x044e,0x0430,0x0431,0x0446,0x0434,0x0435,0x0444,0x0433,
	0x0445,0x0438,0x0439,0x043a,0x043b,0x043c,0x043d,0x043e,
	0x043f,0x044f,0x0440,0x0441,0x0442,0x0443,0x0436,0x0432,
	0x044c,0x044b,0x0437,0x0448,0x044d,0x0449,0x0447,0x044a,
	0x042e,0x0410,0x0411,0x0426,0x0414,0x0415,0x0424,0x0413,
	0x0425,0x0418,0x0419,0x041a,0x041b,0x041c,0x041d,0x041e,
	0x041f,0x042f,0x0420,0x0421,0x0422,0x0423,0x0416,0x0412,
	0x042c,0x042b,0x0417,0x0428,0x042d,0x0429,0x0427,0x042a
	);

	for ($i=0;$i<strlen($str);$i++) {
		$letter = ord($str[$i]);
		if ($letter>=0x80) {
		   $letter -= 128;
		   $c2 = "10111111" & "10".substr(decbin($recode[$from][$letter]), -6);
		   $c1 = "11011111" & "110".str_repeat("0", 5-strlen(substr(decbin($recode[$from][$letter]), 0, -6))).substr(decbin($recode[$from][$letter]), 0, -6);
		   $res .= chr(bindec($c1));
		   $res .= chr(bindec($c2));
		} else {
		   $res .= $str[$i];
		}
	}
	return $res;
}


function convert_charcode($data, $from, $to) {
	if (is_string($data)) {
		$data = trim($data);
		switch(true) {
		   case $to == "utf-8" && $from == "win1251":
				$data = win_to_utf($data);
				break;
		   case $to == "utf-8" && $from == "koi8r":
				$data = win_to_utf($data, "k");
				break;
		   case $to == "win1251" && $from == "utf-8":
				$data = utf_to_win($data);
				break;
		   case $to == "win1251" && $from == "koi8r":
				$data = convert_cyr_string($data, "k", "w");
				break;
		}
		return $data;
	} elseif(is_array($data) || is_object($data)) {
		foreach($data as $key => $value) {
			$data[$key] = convert_charcode($value, $from, $to);
		}
	}
	return $data;
}


function to_translit($str) {
	$transchars =array (
	"E1"=>"A",
	"E2"=>"B",
	"F7"=>"V",
	"E7"=>"G",
	"E4"=>"D",
	"E5"=>"E",
	"B3"=>"Jo",
	"F6"=>"Zh",
	"FA"=>"Z",
	"E9"=>"I",
	"EA"=>"I",
	"EB"=>"K",
	"EC"=>"L",
	"ED"=>"M",
	"EE"=>"N",
	"EF"=>"O",
	"F0"=>"P",
	"F2"=>"R",
	"F3"=>"S",
	"F4"=>"T",
	"F5"=>"U",
	"E6"=>"F",
	"E8"=>"H",
	"E3"=>"C",
	"FE"=>"Ch",
	"FB"=>"Sh",
	"FD"=>"W",
	"FF"=>"X",
	"F9"=>"Y",
	"F8"=>"Q",
	"FC"=>"Eh",
	"E0"=>"Ju",
	"F1"=>"Ja",

	"C1"=>"a",
	"C2"=>"b",
	"D7"=>"v",
	"C7"=>"g",
	"C4"=>"d",
	"C5"=>"e",
	"A3"=>"jo",
	"D6"=>"zh",
	"DA"=>"z",
	"C9"=>"i",
	"CA"=>"i",
	"CB"=>"k",
	"CC"=>"l",
	"CD"=>"m",
	"CE"=>"n",
	"CF"=>"o",
	"D0"=>"p",
	"D2"=>"r",
	"D3"=>"s",
	"D4"=>"t",
	"D5"=>"u",
	"C6"=>"f",
	"C8"=>"h",
	"C3"=>"c",
	"DE"=>"ch",
	"DB"=>"sh",
	"DD"=>"w",
	"DF"=>"x",
	"D9"=>"y",
	"D8"=>"",
	"DC"=>"eh",
	"C0"=>"ju",
	"D1"=>"ja",
	);

	$str = html_entity_decode($str);
	$str = preg_replace("!<script[^>]{0,}>.*</script>!Uis", "", $str);
	$str = strip_tags($str);
	$str = preg_replace("![^абвгдеёжзийклмнопрстуфхцчшщьыъэюяАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЬЫЪЭЮЯa-z0-9 ]!i", " ", $str);
	$str = preg_replace("![\s]{2,}!", " ", $str);
	$str = trim($str);
	$ns = convert_cyr_string($str, "w", "k");
	for ($i=0;$i<strlen($ns);$i++) {
		$c=substr($ns,$i,1);
		$a=strtoupper(dechex(ord($c)));
		if (isset($transchars[$a])) {
			$a=$transchars[$a];
		} else if (preg_match('/^[a-z0-9]*$/i', $c)){
			$a=$c;
		} else if (preg_match('/^[\s]*$/i', $c)){
			$a='-';
		} else {
			$a='';
		}


		$b.=$a;
	}
	return $b;
}

$categories_id = intval($_GET["category"]);

//$_POST["load"] = "1";
//$_FILES["excell"]["tmp_name"] = "C:/shop_items_24_07_2007.xls";
if (isset($_POST["load"]))
{
	if (!empty($_FILES["excell"]["tmp_name"]) && is_file($_FILES["excell"]["tmp_name"]))
	{
		if ($_FILES["excell"]["error"] == 0)
		{
			$data = get_exel_data($_FILES["excell"]["tmp_name"]);
			if (is_array($data) && sizeof($data))
			{
				foreach($data as $pagenum => $page)
				{
					if (sizeof($page["data"]) > 0)
					{
						$temp = array();
						foreach($page["data"] as $rownum => $row)
						{
							$temp[] = $row;
						}
						$page["data"] = $temp;
						foreach($page["data"] as $rownum => $row)
						{
							foreach($row as $cellnum => $cell)
							{
								if (get_magic_quotes_runtime()) $cell = stripslashes($cell);
								$cell = $cell == "&nbsp;" ? "" : $cell;
								$page["data"][$rownum][$cellnum] = empty($cell) ? "" : $cell;
							}
						}
					}
				}

				if (sizeof($page["data"]) > 1)
				{
					for($i = 1; $i < sizeof($page["data"]); $i++)
					{
						if (preg_match("!^\[([\d]+)\]!", $page["data"][$i][0], $regs))
						{
							$item = mysql_fetch_assoc(mysql_query("select products_id from products where products_id = ".intval($regs[1])));
							if ($item["products_id"] > 0)
							{
								$category = mysql_fetch_assoc(mysql_query("select categories_id from products_to_categories where products_id = ".$item["products_id"]));
								if ($category["categories_id"] > 0)
								{
									$category = $category["categories_id"];
									break;
								}
							}
						}
						$category = 0;
					}

					if ($category > 0)
					{
						$parameters = array();
						foreach($page["data"][0] as $num => $cell)
						{
							if ($num > 0)
							{
								if (preg_match("!^\[([\d]+)\]!", $cell, $reg))
								{
									$temp = mysql_fetch_assoc(mysql_query("select products_parameters_id from products_parameters where products_parameters_id = ".intval($reg[1])));
									$parameter_id = intval($temp["products_parameters_id"]);
								}
								else
								{
									$temp = mysql_fetch_assoc(mysql_query("select products_parameters_id from products_parameters where products_parameters_name = '".addslashes($cell)."'"));
									$parameter_id = intval($temp["products_parameters_id"]);
								}

								if ($parameter_id < 1)
								{
									mysql_query("insert into products_parameters (products_parameters_name, products_parameters_title, categories_id, products_parameters_type)
																		  values ('".addslashes($cell)."', '".addslashes($cell)."', ".$category.", 'p')");
									$parameter_id = mysql_insert_id();
									$added_params++;
								}
								else
								$found_params++;

								$page["data"][0][$num] = $parameter_id;
							}
						}

						// перебираем строки с товарами
						for($i = 1; $i < sizeof($page["data"]); $i++)
						{
							if (preg_match("!^\[([\d]+)\]!", $page["data"][$i][0], $regs))
							{
								$found_items++;
								$item = mysql_fetch_assoc(mysql_query("select products_id from products where products_id = ".intval($regs[1])));
								if ($item["products_id"] > 0)
								{
									// перебираем параметры, $num - номер, $cell - ID параметра
									foreach($page["data"][0] as $num => $cell)
									{
										if ($num > 0)
										{
											$p2i = mysql_fetch_assoc(mysql_query("select count(*) as `count` from products_parameters2products where products_parameters_id = '".$cell."' and products_id = '".$item["products_id"]."'"));
											if ($p2i["count"] > 0)
											{
												mysql_query("update products_parameters2products set products_parameters2products_value = '".addslashes($page["data"][$i][$num])."', products_parameters2products_md5 = MD5('".addslashes($page["data"][$i][$num])."') where products_parameters_id = '".intval($cell)."' and products_id = '".intval($item["products_id"])."'");
												if (mysql_error())
													$update_params_value_error++;
												else
													$update_params_value++;
											}
											elseif (!empty($page["data"][$i][$num]))
											{
												mysql_query("insert into products_parameters2products (products_parameters_id, products_id, products_parameters2products_value, products_parameters2products_md5)
												values ('".intval($cell)."', '".intval($item["products_id"])."', '".addslashes($page["data"][$i][$num])."', MD5('".addslashes($page["data"][$i][$num])."'))");
												if (mysql_error())
													$added_params_value_error++;
												else
													$added_params_value++;
											}
										}
									}
								}
							}
							else
							$found_items_error++;
						}

						$_report_mesage .= REPORT_WORKPR_TITLE." ".intval($found_items).'<br />';
						$_report_mesage .= REPORT_NOTFOUND_TITLE." ".intval($found_items_error).'<br />';
						$_report_mesage .= REPORT_WORKPAR_TITLE." ".intval($found_params+$added_params).'<br />';
						$_report_mesage .= REPORT_ADDEDPAR_TITLE." ".intval($added_params).'<br />';
					}
					else
					$_report_mesage = "<P style=\"color: red\">".ERROR_CNOTFOUND."</P>";
				}
		   }
	   }
	   else
	   $_report_mesage = "<P style=\"color: red\">".ERROR_UPLERROR."</P>";
	}
	else
	$_report_mesage = "<P style=\"color: red\">".ERROR_UPLEMPTY."</P>";
}
elseif ($categories_id > 0)
{
	$b = ob_start();
error_reporting(E_ALL ^ E_NOTICE);
ini_set("display_errors", "on");
error_reporting(0);
set_time_limit(600);
	//error_reporting(0);
	require_once('Writer.php');

	//$excelFileName = DIR_FS_DOCUMENT_ROOT.'tmp/items.xls';
	$d = dir(DIR_FS_DOCUMENT_ROOT.'tmp');
	while (false !== ($entry = $d->read())) {
	   if (substr($entry, 0, 11) == 'shop_items_')
		unlink(DIR_FS_DOCUMENT_ROOT.'tmp/'.$entry);
	}
	$d->close();

	$excelFileName = DIR_FS_DOCUMENT_ROOT.'tmp/shop_items_'.date("j_m_Y").'.xls';
	if (file_exists($excelFileName)) unlink($excelFileName);


	$res = mysql_query("select * from products_to_categories where categories_id = ".$categories_id);
	$items_ids = array();
	while($category = mysql_fetch_assoc($res))
	{
		$items_ids[] = $category["products_id"];
	}

	if (sizeof($items_ids) > 0)
	{
		$workbook = new Spreadsheet_Excel_Writer($excelFileName);
		$worksheet = $workbook->addWorksheet('New');

		$res = mysql_query("select products.products_id, products_ean, products_name from products left join products_description using (products_id) where products.products_id in (".implode(", ", $items_ids).") order by products_name");
		$items = $ids = array();
		while($item = mysql_fetch_assoc($res))
		{
			$items[$item["products_id"]] = $item;
		}
		$xls_title = array(EXCELL_NAME_TITLE);

		$res = mysql_query("select products_parameters_id, products_parameters_title from products_parameters where categories_id = ".$categories_id." and products_parameters_type = 'p' order by products_parameters_order");
		$parameters = array();
		while($parameter = mysql_fetch_assoc($res))
		{
			$parameters[$parameter["products_parameters_id"]] = $parameter;
			$parameters_ids[] = $parameter["products_parameters_id"];
			$xls_title[] = "[".$parameter["products_parameters_id"]."] ".$parameter["products_parameters_title"];
		}

		$res = mysql_query("select products_parameters_id, products_id, products_parameters2products_value from products_parameters2products where products_parameters_id in (".implode(", ", $parameters_ids).") and products_id in (".implode(", ", $items_ids).")");
		while($value = mysql_fetch_assoc($res))
		{
			$values[$value["products_parameters_id"]][$value["products_id"]] = $value["products_parameters2products_value"];
		}

		$xls_title = convert_charcode($xls_title, "utf-8", "win1251");
		for ($i = 0; $i < sizeof($xls_title); $i++)
		{
			$worksheet->writeString(0, $i, $xls_title[$i]);
		}
		$excelId = 1;

		$items = convert_charcode($items, "utf-8", "win1251");
		$values = convert_charcode($values, "utf-8", "win1251");
		foreach($items as $id => $item)
		{
			$cell = 0;
			$worksheet->writeString($excelId, $cell, "[".$item["products_id"]."] ".$item["products_name"]);
			foreach($parameters as $pid => $parameter)
			{
				$cell++;
				$worksheet->writeString($excelId, $cell, $values[$pid][$id]);
			}
			$excelId++;
		}

		$workbook->close();

		ob_end_clean();
		header('Location: /tmp/shop_items_'.date("j_m_Y").'.xls');
		/*
		$content = file_get_contents($excelFileName);
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header("Accept-Ranges: bytes");
		header("Content-Length: ".strlen($content));
		header("Content-Type: application/octet-stream");
		header('Content-Disposition: attachment; filename="shop_items_'.date("j_m_Y").'.xls"');
		header("Connection: Close");
		echo $content;
		*/
		/*
		$fp = fopen($excelFileName, 'rb');
		header("Content-Length: " . filesize($excelFileName));
		header("Content-Type: application/octet-stream; charset=windows-1251");
		header('Content-Disposition: attachment; filename="shop_items_'.date("j_m_Y").'.xls"');
		header("Accept-Ranges: bytes");
		fpassthru($fp);
		*/
		exit;
	}
	else
		$_report_mesage = "<P style=\"color: red\">".ERROR_CATEMPTY."</P>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body width="100%" //-->
<table border="0"  cellspacing="2" cellpadding="2">
  <tr>
		<td width="100%">

	<h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>

  </td>
  </tr>
  <tr>
<!-- body_text  width="100%" //-->
	<td class="boxCenter" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
	  <tr>
		<td><table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
			<td valign="top">
				<?php echo $_report_mesage; ?>

				<?php echo DOWNLOAD_TITLE; ?>:<br>
				<form>
				<?php
				echo vam_draw_pull_down_menu('category', vam_get_category_tree('','',0));
				?>
				<span class="button"><button type="submit" value="<?php echo DOWNLOAD_BUTTON_TITLE; ?>" name="load"><?php echo DOWNLOAD_BUTTON_TITLE; ?></button></span>
				</form>

				<br><br>

				<?php echo UPLOAD_TITLE; ?>:<br>
				<form name="editForm" method="POST" enctype="multipart/form-data">
				<input type="file" name="excell" value="" style="width: 300px;"><br>
				<span class="button"><button type="submit" value="<?php echo UPLOAD_BUTTON_TITLE; ?>" name="load"><?php echo UPLOAD_BUTTON_TITLE; ?></button></span>
				</form>

			</td>

		  </tr>
		</table></td>
	  </tr>
	</table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>