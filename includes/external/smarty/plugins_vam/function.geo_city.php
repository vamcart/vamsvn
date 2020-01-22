<?php
/* -----------------------------------------------------------------------------------------
   VamShop - http://vamshop.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2014 VamSoft Ltd.
   License - http://vamshop.com/license.html
   ---------------------------------------------------------------------------------------*/

function smarty_function_geo_city($params, $template)
{
  global $content;
  require_once('vendor/GeoCity/SxGeo.php');
  $SxGeo= new SxGeo('vendor/GeoCity/SxGeo.dat');
  $city = $SxGeo->get($_SERVER['REMOTE_ADDR']);
  // Cloud flare original user ip
  if ($_SERVER['HTTP_CF_CONNECTING_IP'] != '') $city = $SxGeo->get($_SERVER['HTTP_CF_CONNECTING_IP']);
  
  $city_name = ($_SESSION['language'] == 'russian') ? $city['city']['name_ru'] : $city['city']['name_en'];

	return $city_name;
}
?>