<?php
/* --------------------------------------------------------------
   $Id: step1.php 899 2007-02-07 13:12:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(install.php,v 1.7 2002/08/14); www.oscommerce.com
   (c) 2003	 nextcommerce (step1.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (step1.php,v 1.10 2003/08/17); xt-commerce.com 

   Released under the GNU General Public License
   --------------------------------------------------------------*/
  
  require('includes/application.php');

  if (!isset($_SESSION['language']) ) $_SESSION['language'] = 'russian';
  include('language/'.$_SESSION['language'].'.php');
  require_once(DIR_FS_INC.'xtc_image.inc.php');
  require_once(DIR_FS_INC.'xtc_draw_separator.inc.php');
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title><?php echo TITLE_STEP1; ?></title>
<link rel="stylesheet" type="text/css" href="includes/style.css" />
</head>
<body>


<!-- Контейнер -->
<div id="container">

<!-- Шапка -->
<div id="header">
<img src="images/logo.gif" alt="VaM Shop" />
</div>
<!-- /Шапка -->

<div id="menu">
<ul>
<li><a href="index.php"><span><?php echo START; ?></span></a></li>
<li class="current"><a href="step1.php"><span><?php echo STEP1; ?></span></a></li>
<li><a href=""><span><?php echo STEP2; ?></span></a></li>
<li><a href=""><span><?php echo STEP3; ?></span></a></li>
<li><a href=""><span><?php echo STEP4; ?></span></a></li>
<li><a href=""><span><?php echo STEP5; ?></span></a></li>
<li><a href=""><span><?php echo STEP6; ?></span></a></li>
<li><a href=""><span><?php echo END; ?></span></a></li>
</ul>
</div>

<!-- Навигация -->
<div id="navigation">
<span><?php echo TEXT_INSTALL; ?></span>
</div>
<!-- /Навигация -->

<!-- Центр -->
<div id="wrapper">
<div id="content">

<!-- Заголовок страницы -->
<h1><?php echo TITLE_STEP1; ?></h1>
<!-- /Заголовок страницы -->
<!-- Скругленные углы -->
<div class="page">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<!-- Содержимое страницы -->
<div class="pagecontent">

<form name="install" method="post" action="step2.php">

<span><?php echo TEXT_WELCOME_STEP1; ?></span>

<fieldset class="form">
<legend><?php echo TITLE_CUSTOM_SETTINGS; ?></legend>
<p><?php echo xtc_draw_checkbox_field_installer('install[]', 'database', true); ?><b><?php echo TEXT_IMPORT_DB; ?></b><br /><?php echo TEXT_IMPORT_DB_LONG; ?></p>
<p><?php echo xtc_draw_checkbox_field_installer('install[]', 'configure', true); ?><b><?php echo TEXT_AUTOMATIC; ?></b><br /><?php echo TEXT_AUTOMATIC_LONG; ?></p>
</fieldset>

<fieldset class="form">
<legend><?php echo TITLE_DATABASE_SETTINGS; ?></legend>
<p><b><?php echo TEXT_DATABASE_SERVER; ?></b><br /><?php echo xtc_draw_input_field_installer('DB_SERVER', '', 'text'); ?><br /><?php echo TEXT_DATABASE_SERVER_LONG; ?></p>
<p><b><?php echo TEXT_USERNAME; ?></b><br /><?php echo xtc_draw_input_field_installer('DB_SERVER_USERNAME', '', 'text'); ?><br /><?php echo TEXT_USERNAME_LONG; ?></p>
<p><b><?php echo TEXT_PASSWORD; ?></b><br /><?php echo xtc_draw_input_field_installer('DB_SERVER_PASSWORD', '', 'text'); ?><br /><?php echo TEXT_PASSWORD_LONG; ?></p>
<p><b><?php echo TEXT_DATABASE; ?></b><br /><?php echo xtc_draw_input_field_installer('DB_DATABASE', '', 'text'); ?><br /><?php echo TEXT_DATABASE_LONG; ?></p>
</fieldset>

<fieldset class="form">
<legend><?php echo TITLE_WEBSERVER_SETTINGS; ?></legend>
<p><b><?php echo TEXT_WWW; ?></b><br /><?php echo xtc_draw_input_field_installer('WWW_ADDRESS', $_www_location,'text','size="60"'); ?><br /></p>
<p><b><?php echo TEXT_WS_ROOT; ?></b><br /><?php echo xtc_draw_input_field_installer('DIR_FS_WWW_ROOT', $_dir_fs_www_root,'text','size="60"'); ?><br /><?php echo TEXT_WS_ROOT_LONG; ?></p>
</fieldset>

<p>
<a href="index.php"><img src="images/button_cancel.gif" border="0" alt="<?php echo IMAGE_CANCEL; ?>" /></a>&nbsp;
<input type="image" src="images/button_continue.gif" alt="<?php echo IMAGE_CONTINUE; ?>" />
</p>

</form>

</div>
<!-- /Содержимое страницы -->
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
<!-- /Скругленные углы -->

</div>
<p></p>

</div>
</div>
<!-- /Центр -->

<!-- Левая колонка -->
<div id="left">
&nbsp;
</div>
<!-- /Левая колонка -->

<!-- Правая колонка -->
<div id="right">
&nbsp;
</div>
<!-- /Правая колонка -->

<!-- Низ -->
<div id="footer">
&nbsp;
</div>
<!-- /Низ -->

</div>
<!-- /Контейнер -->

<div class="copyright">eCommerce Engine ©2007 <a href="http://xt-commerce.com" target="_blank">xt:Commerce</a></div>
<div id="copyright">Powered by <a href="http://vamshop.ru" target="_blank">VaM Shop</a></div>

</body>
</html>