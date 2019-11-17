<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_cookie($params, $template)
{
	if (!isset ($params['name'])) 
    $params['name'] = false;
	
   if (!$params['name']) return;	
	
	if (isset($_COOKIE[$params['name']])) {
		$result = $_COOKIE[$params['name']];
	} else {
		$result = false;
	}
	
	return $result;
}
?>