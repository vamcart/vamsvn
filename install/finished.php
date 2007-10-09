<?php
  /* --------------------------------------------------------------
   $Id: index.php 1220 2007-02-07 13:12:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (index.php,v 1.18 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (index.php,v 1.18 2003/08/17); xt-commerce.com 
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/
   
  require('includes/application.php');

  // include needed functions
  require_once(DIR_FS_INC.'vam_image.inc.php');
  require_once(DIR_FS_INC.'vam_draw_separator.inc.php');
  require_once(DIR_FS_INC.'vam_redirect.inc.php');
  require_once(DIR_FS_INC.'vam_href_link.inc.php');
  
  include('language/russian.php');


 define('HTTP_SERVER','');
 define('HTTPS_SERVER','');
 define('DIR_WS_CATALOG','');

   $messageStack = new messageStack();

    $process = false;
  if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    $process = true;

        
        $_SESSION['language'] = vam_db_prepare_input($_POST['LANGUAGE']);

    $error = false;


      if ( ($_SESSION['language'] != 'russian') ) {
        $error = true;

        $messageStack->add('index', SELECT_LANGUAGE_ERROR);
        }
        

                    if ($error == false) {
                        vam_redirect(vam_href_link('step1.php', '', 'NONSSL'));
                }
        }


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title><?php echo TITLE_FINISHED; ?></title>
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
<li><a href="step1.php"><span><?php echo STEP1; ?></span></a></li>
<li><a href="step2.php"><span><?php echo STEP2; ?></span></a></li>
<li><a href="step3.php"><span><?php echo STEP3; ?></span></a></li>
<li><a href="step4.php"><span><?php echo STEP4; ?></span></a></li>
<li><a href="step5.php"><span><?php echo STEP5; ?></span></a></li>
<li><a href="step6.php"><span><?php echo STEP6; ?></span></a></li>
<li class="current"><a href="finished.php"><span><?php echo END; ?></span></a></li>
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
<h1><?php echo TITLE_FINISHED; ?></h1>
<!-- /Заголовок страницы -->
<!-- Скругленные углы -->
<div class="page">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<!-- Содержимое страницы -->
<div class="pagecontent">

<p>
<?php echo TEXT_WELCOME_FINISHED; ?>
</p>

<p>
<?php echo TEXT_SHOP_CONFIG_SUCCESS; ?>
</p>

<p>
<?php echo TEXT_TEAM; ?>
</p>

<p>
<a href="<?php echo '../index.php'; ?>" target="_blank"><img src="images/button_catalog.gif" border="0" alt="<?php echo TEXT_CATALOG; ?>" /></a>
</p>

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