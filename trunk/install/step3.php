<?php
  /* --------------------------------------------------------------
   $Id: step3.php 899 2007-02-07 13:12:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(step3.php,v 1.6 2002/08/15); www.oscommerce.com 
   (c) 2004	 xt:Commerce (step3.php,v 1.6 2002/08/15); xt-commerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

   require('includes/application.php');
   require_once(DIR_FS_INC.'xtc_draw_separator.inc.php');

   include('language/'.$_SESSION['language'].'.php'); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title><?php echo TITLE_STEP3; ?></title>
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
<li class="current"><a href="step3.php"><span><?php echo STEP3; ?></span></a></li>
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
<h1><?php echo TITLE_STEP3; ?></h1>
<!-- /Заголовок страницы -->
<!-- Скругленные углы -->
<div class="page">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<!-- Содержимое страницы -->
<div class="pagecontent">

<p><?php echo TEXT_WELCOME_STEP3; ?></p>

            <?php
  if (xtc_in_array('database', $_POST['install'])) {
    $db = array();
    $db['DB_SERVER'] = trim(stripslashes($_POST['DB_SERVER']));
    $db['DB_SERVER_USERNAME'] = trim(stripslashes($_POST['DB_SERVER_USERNAME']));
    $db['DB_SERVER_PASSWORD'] = trim(stripslashes($_POST['DB_SERVER_PASSWORD']));
    $db['DB_DATABASE'] = trim(stripslashes($_POST['DB_DATABASE']));

    xtc_db_connect_installer($db['DB_SERVER'], $db['DB_SERVER_USERNAME'], $db['DB_SERVER_PASSWORD']);

    $db_error = false;
    $sql_file = DIR_FS_CATALOG . 'install/vam.sql';
    
    xtc_db_install($db['DB_DATABASE'], $sql_file);

    if ($db_error) {
?>

<p>
<?php echo TEXT_TITLE_ERROR; ?>
</p>

<div class="contacterror">
<b><?php echo $db_error; ?></b>
</div>

<form name="install" action="step3.php" method="post">

<?php
      reset($_POST);
      while (list($key, $value) = each($_POST)) {
        if ($key != 'x' && $key != 'y') {
          if (is_array($value)) {
            for ($i=0; $i<sizeof($value); $i++) {
              echo xtc_draw_hidden_field_installer($key . '[]', $value[$i]);
            }
          } else {
            echo xtc_draw_hidden_field_installer($key, $value);
          }
        }
      }
?>

<a href="index.php"><img src="images/button_cancel.gif" border="0" alt="<?php echo IMAGE_CANCEL; ?>" /></a>&nbsp;
<input type="image" src="images/button_retry.gif" alt="<?php echo IMAGE_RETRY; ?>" />

</form>

<?php
    } else {
?>

<p>
<?php echo TEXT_TITLE_SUCCESS; ?>
</p>

            <form name="install" action="step4.php" method="post">

<?php
      reset($_POST);
      while (list($key, $value) = each($_POST)) {
        if ($key != 'x' && $key != 'y') {
          if (is_array($value)) {
            for ($i=0; $i<sizeof($value); $i++) {
              echo xtc_draw_hidden_field_installer($key . '[]', $value[$i]);
            }
          } else {
            echo xtc_draw_hidden_field_installer($key, $value);
          }
        }
      }
?>

<p>
<?php
      if (xtc_in_array('configure', $_POST['install'])) {
?>
<input type="image" src="images/button_continue.gif" alt="<?php echo IMAGE_CONTINUE; ?>" />
<?php
      } else {
?>
<img src="images/button_continue.gif" border="0" alt="<?php echo IMAGE_CONTINUE; ?>" /></a>
<?php
      }
?>
</p>

</form>

<?php
    }
  }
?>

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

<div id="copyright">Powered by <a href="http://vamshop.ru" target="_blank">VaM Shop</a></div>

</body>
</html>