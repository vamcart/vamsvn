<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_cleanName.inc.php 1319 2005-10-23 10:35:15Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


function xtc_cleanName($name) {
//     $replace_param='/[^a-zA-Z0-9]/';
     $replace_param='/[^a-zA-Zà-ÿÀ-ß0-9]/';
     $cyrillic = array("æ", "¸", "é","þ", "ü","÷", "ù", "ö","ó","ê","å","í","ã","ø", "ç","õ","ú","ô","û","â","à","ï","ð","î","ë","ä","ý","ÿ","ñ","ì","è","ò","á","¨","É","Þ","×","Ü","Ù","Ö","Ó","Ê","Å","Í","Ã","Ø","Ç","Õ","Ú","Ô","Û","Â","À","Ï","Ð","Î","Ë","Ä","Æ","Ý","ß","Ñ","Ì","È","Ò","Á");
     $translit = array("zh","yo","i","yu","'","ch","sh","c","u","k","e","n","g","sh","z","h","'",  "f",  "y",  "v",  "a",  "p",  "r",  "o",  "l",  "d",  "yå", "jà", "s",  "m",  "i",  "t",  "b",  "yo", "I",  "YU", "CH", "'",  "SH", "C",  "U",  "K",  "E",  "N",  "G",  "SH", "Z",  "H",  "'",  "F",  "Y",  "V",  "A",  "P",  "R",  "O",  "L",  "D",  "Zh", "Ye", "Ja", "S",  "M",  "I",  "T",  "B");
     $name = str_replace($cyrillic, $translit, $name);    
     $name=preg_replace($replace_param,'-',$name);    
     return $name;
}

?>
