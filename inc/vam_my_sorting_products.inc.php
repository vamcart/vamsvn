<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_my_sorting_products.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2008 VaM Shop
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
	function my_sorting_products($sorting_data) {
		global $sorting_data;
		static $sortingTypes = array('name', 'price', 'ordered', 'id', 'quantity');
		static $directionTypes = array('asc', 'desc');
		$sort = initGetVariable('sort', '');
		$direction = initGetVariable('direction', '');
		if( in_array($sort, $sortingTypes) && in_array($direction, $directionTypes) ) {
			//$sorting_data = array('products_sorting'=> 'products_quantity DESC, products_' . $sort, 'products_sorting2'=>$direction);
			$sorting_data = array('products_sorting'=> 'products_' . $sort, 'products_sorting2'=>$direction);
		}
	}
	function InitGetVariable($var, $value) {
		return isset($_GET[$var]) ? $_GET[$var] : $value;
	}
	function InitPostVariable($var, $value) {
		return isset($_POST[$var]) ? $_POST[$var] : $value;
	}
	function InitHttpVariable($var, $value) {
		return isset($_GET[$var]) ? $_GET[$var] : isset($_POST[$var]) ? $_POST[$var] : $value;
	}	
  
 ?>