<?php
/*------------------------------------------------------------------------------
  $Id: aviso.php 1310 2009-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
  -----------------------------------------------------------------------------
   based on:
   (c) 2005 Vetal (robox.php,v 1.48 2003/05/27); metashop.ru

  Released under the GNU General Public License
------------------------------------------------------------------------------*/

    // logging
$fp = fopen('1.log', 'a+');
$str=date('Y-m-d H:i:s').' - ';
foreach ($_REQUEST as $vn=>$vv) {
  $str.=$vn.'='.$vv.';';
}

  $str.='test'.var_dump($response);
fwrite($fp, $str."\n");
fclose($fp);


?>