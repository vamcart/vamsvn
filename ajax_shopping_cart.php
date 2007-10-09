<?php
/* -----------------------------------------------------------------------------------------
   $Id: ajax_shopping_cart.php 899 2007-06-30 20:14:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 Andrew Weretennikoff (ajax_shopping_cart.php,v 1.1 2007/03/17); medreces@yandex.ru 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  require('includes/application_top.php');

// Подключаем библиотеку поддержки.

  require_once('includes/classes/JsHttpRequest.php');

// Создаем главный объект библиотеки.
// Указываем кодировку страницы (обязательно!).

	$JsHttpRequest =& new JsHttpRequest('');

   foreach( $_REQUEST as $key => $value) $_POST[$key]=$value;

	$JsHttpRequest->setEncoding($_SESSION['language_charset']);

  $vamTemplate = new vamTemplate;

  require(DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes/' . 'shopping_cart.php');

  echo $box_shopping_cart;

?>