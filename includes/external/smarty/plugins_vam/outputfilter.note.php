<?php
/* -----------------------------------------------------------------------------------------
   $Id: outputfilter.note.php 1262 2005-10-22 13:00:32Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru

   Copyright (c) 2006 VaM Shop 
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2005	 xt:Commerce (outputfilter.note.php,v 1.7 2005-09-30); www.xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

 function smarty_outputfilter_note($source, Smarty_Internal_Template $template) {

    /*
    The following copyright announcement is in compliance
    to section 2c of the GNU General Public License, and
    thus can not be removed, or can only be modified
    appropriately.
    */

 	$str='60, 100, 105, 118, 32, 105, 100, 61, 34, 99, 111, 112, 121, 114, 105, 103, 104, 116, 34, 62, 80, 111, 119, 101, 114, 101, 100, 32, 98, 121, 32, 60, 97, 32, 104, 114, 101, 102, 61, 34, 104, 116, 116, 112, 58, 47, 47, 118, 97, 109, 115, 104, 111, 112, 46, 114, 117, 34, 32, 116, 97, 114, 103, 101, 116, 61, 34, 95, 98, 108, 97, 110, 107, 34, 62, 86, 97, 77, 32, 83, 104, 111, 112, 60, 47, 97, 62, 60, 47, 100, 105, 118, 62, 60, 47, 98, 111, 100, 121, 62, 60, 47, 104, 116, 109, 108, 62';
	$str_arr=explode(',',$str);
	$cop=base64_decode('PGRpdiBpZD0iY29weXJpZ2h0Ij7QoNCw0LHQvtGC0LDQtdGCINC90LAg0L7RgdC90L7QstC1IDxhIGhyZWY9Imh0dHBzOi8vdmFtc2hvcC5ydSIgdGFyZ2V0PSJfYmxhbmsiIHJlbD0ibm9vcGVuZXIiPlZhbVNob3A8L2E+LiA8YSBocmVmPSJodHRwOi8vdmFtc2hvcC5ydSIgdGFyZ2V0PSJfYmxhbmsiIHJlbD0ibm9vcGVuZXIiPtCh0L7Qt9C00LDQvdC40LUg0LjQvdGC0LXRgNC90LXRgiDQvNCw0LPQsNC30LjQvdCwPC9hPi48L2Rpdj4=');
    return $source.$cop;

}

?>