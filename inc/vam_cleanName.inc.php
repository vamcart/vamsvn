<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_cleanName.inc.php 1319 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (vam_cleanName.inc.php); www.nextcommerce.org 
   (c) 2004 xt:Commerce (vam_cleanName.inc.php 2003/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


function vam_cleanName($name) {
//     $replace_param='/[^a-zA-Z0-9]/';
     $replace_param='/[^a-zA-Zа-яА-Я0-9]/';
     $cyrillic = array("ж", "ё", "й","ю", "ь","ч", "щ", "ц","у","к","е","н","г","ш", "з","х","ъ","ф","ы","в","а","п","р","о","л","д","э","я","с","м","и","т","б","Ё","Й","Ю","Ч","Ь","Щ","Ц","У","К","Е","Н","Г","Ш","З","Х","Ъ","Ф","Ы","В","А","П","Р","О","Л","Д","Ж","Э","Я","С","М","И","Т","Б","№");
     $translit = array("zh","yo","i","yu","","ch","sh","c","u","k","e","n","g","sh","z","h","",  "f",  "y",  "v",  "a",  "p",  "r",  "o",  "l",  "d",  "ye", "ya", "s",  "m",  "i",  "t",  "b",  "yo", "I",  "YU", "CH", "",  "SH", "C",  "U",  "K",  "E",  "N",  "G",  "SH", "Z",  "H",  "",  "F",  "Y",  "V",  "A",  "P",  "R",  "O",  "L",  "D",  "Zh", "Ye", "Ya", "S",  "M",  "I",  "T",  "B",  "#");
     $name = str_replace($cyrillic, $translit, $name);    
     $name=preg_replace($replace_param,'-',$name);
     $name = urlencode($name);    
     return $name;
}

?>
