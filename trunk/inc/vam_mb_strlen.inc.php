<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_mb_strlen.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

if (!function_exists('mb_strlen'))
{
	function mb_strlen($t, $encoding = 'UTF-8')
	{
		return strlen(utf8_decode($t));
	}
} 

?>