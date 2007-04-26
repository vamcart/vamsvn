<?php
  /* --------------------------------------------------------------
   $Id: step2.php 1119 2007-02-07 13:12:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(step2.php,v 1.4 2002/08/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (step2.php,v 1.16 2003/08/1); www.nextcommerce.org
   (c) 2004	 xt:Commerce (step2.php,v 1.16 2003/08/1); xt-commerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application.php');

  // include needed functions
  require_once(DIR_FS_INC.'xtc_redirect.inc.php');
  require_once(DIR_FS_INC.'xtc_href_link.inc.php');
  require_once(DIR_FS_INC.'xtc_not_null.inc.php');
  require_once(DIR_FS_INC.'xtc_draw_separator.inc.php');

  include('language/'.$_SESSION['language'].'.php');
  

  if (xtc_in_array('database', $_POST['install'])) {
   // do nothin  
  } else {
   xtc_redirect('step4.php');
  }
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title><?php echo TITLE_STEP2; ?></title>
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
<li class="current"><a href="step2.php"><span><?php echo STEP2; ?></span></a></li>
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
<h1><?php echo TITLE_STEP2; ?></h1>
<!-- /Заголовок страницы -->
<!-- Скругленные углы -->
<div class="page">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<!-- Содержимое страницы -->
<div class="pagecontent">

<p><?php echo TEXT_WELCOME_STEP2; ?></p>

      <?php
  if (xtc_in_array('database', $_POST['install'])) {
    $db = array();
    $db['DB_SERVER'] = trim(stripslashes($_POST['DB_SERVER']));
    $db['DB_SERVER_USERNAME'] = trim(stripslashes($_POST['DB_SERVER_USERNAME']));
    $db['DB_SERVER_PASSWORD'] = trim(stripslashes($_POST['DB_SERVER_PASSWORD']));
    $db['DB_DATABASE'] = trim(stripslashes($_POST['DB_DATABASE']));

    $db_error = false;
    xtc_db_connect_installer($db['DB_SERVER'], $db['DB_SERVER_USERNAME'], $db['DB_SERVER_PASSWORD']);

    if (!$db_error) {
      xtc_db_test_create_db_permission($db['DB_DATABASE']);
    }

    if ($db_error) {
?>

<p>
<?php echo TEXT_CONNECTION_ERROR; ?>
</p>

<p>
<?php echo TEXT_DB_ERROR; ?>
</p>

<div class="contacterror">
<b><?php echo $db_error; ?></b>
</div>

<p><?php echo TEXT_DB_ERROR_1; ?></p>
<p><?php echo TEXT_DB_ERROR_2; ?></p>

<form name="install" action="step1.php" method="post">

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
<a href="index.php"><img src="images/button_cancel.gif" border="0" alt="<?php echo IMAGE_CANCEL; ?>" /></a>&nbsp;
<input type="image" src="images/button_back.gif" alt="<?php echo IMAGE_BACK; ?>" />
</p>

</form>

<?php
    } else {
?>

<div class="ok">
<?php echo TEXT_CONNECTION_SUCCESS; ?>
</div>

<p><?php echo TEXT_PROCESS_1; ?></p>
<p><?php echo TEXT_PROCESS_2; ?></p>


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

<p>
<a href="step1.php"><img src="images/button_cancel.gif" border="0" alt="<?php echo IMAGE_CANCEL; ?>" /></a>&nbsp;
<input type="image" src="images/button_continue.gif" alt="<?php echo IMAGE_CONTINUE; ?>" />
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