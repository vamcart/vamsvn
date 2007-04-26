<?php
  /* --------------------------------------------------------------
   $Id: step4.php 899 2007-02-07 13:12:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(step4.php,v 1.9 2002/08/19); www.oscommerce.com
   (c) 2003	 nextcommerce (step4.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (step4.php,v 1.14 2003/08/17); xt-commerce.com 

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
<title><?php echo TITLE_STEP4; ?></title>
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
<li class="current"><a href="step4.php"><span><?php echo STEP4; ?></span></a></li>
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
<h1><?php echo TITLE_STEP4; ?></h1>
<!-- /Заголовок страницы -->
<!-- Скругленные углы -->
<div class="page">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<!-- Содержимое страницы -->
<div class="pagecontent">

<p>
<?php echo TEXT_WELCOME_STEP4; ?>
</p>

<p>
<?php echo TITLE_WEBSERVER_CONFIGURATION; ?>
</p>

<?php  if ( ( (file_exists(DIR_FS_CATALOG . 'includes/configure.php')) && (!is_writeable(DIR_FS_CATALOG . 'includes/configure.php')) ) || ( (file_exists(DIR_FS_CATALOG . 'admin/includes/configure.php')) && (!is_writeable(DIR_FS_CATALOG . 'admin/includes/configure.php')) ) || ( (file_exists(DIR_FS_CATALOG . 'admin/includes/local/configure.php')) && (!is_writeable(DIR_FS_CATALOG . 'admin/includes/local/configure.php')) ) || ( (file_exists(DIR_FS_CATALOG . 'includes/local/configure.php')) && (!is_writeable(DIR_FS_CATALOG . 'includes/local/configure.php')) )) {
?>
<div class="contacterror">
<strong><?php echo TITLE_STEP4_ERROR; ?></strong>
</div>

<div class="boxMe"><?php echo TEXT_STEP4_ERROR; ?>
<ul class="boxMe">
<li>cd <?php echo DIR_FS_CATALOG; ?>admin/includes/</li>
<li>touch configure.php</li>
<li>chmod 706 configure.php</li>
<li>chmod 706 configure.org.php</li>
</ul>
<ul class="boxMe">
<li>cd <?php echo DIR_FS_CATALOG; ?>includes/</li>
<li>touch configure.php</li>
<li>chmod 706 configure.php </li>
<li>chmod 706 configure.org.php</li>
</ul>
</div>

<p class="noteBox">
<?php echo TEXT_STEP4_ERROR_1; ?>
</p>

<p class="noteBox">
<?php echo TEXT_STEP4_ERROR_2; ?>
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
              
<a href="index.php"><img src="images/button_cancel.gif" border="0" alt="<?php echo IMAGE_CANCEL; ?>" /></a>&nbsp;
<input type="image" src="images/button_retry.gif" alt="<?php echo IMAGE_RETRY; ?>" />
</form>

            <?php
  } else {
?>
            
<form name="install" action="step5.php" method="post">
<p>
<b><?php echo TEXT_VALUES; ?></b>
<br />
<br />
includes/configure.php<br />
includes/configure.org.php<br />
admin/includes/configure.php<br />
admin/includes/configure.org.php<br />
</p>

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

<fieldset class="form">
<legend><?php echo TITLE_DATABASE_SETTINGS; ?></legend>
<p><?php echo xtc_draw_checkbox_field_installer('USE_PCONNECT', 'true'); ?><b><?php echo TEXT_PERSIST; ?></b><br /><?php echo TEXT_PERSIST_LONG; ?></p>
<p><?php echo xtc_draw_radio_field_installer('STORE_SESSIONS', 'files', false); ?><b><?php echo TEXT_SESS_FILE; ?></b><br /><?php echo xtc_draw_radio_field_installer('STORE_SESSIONS', 'mysql',true); ?><b><?php echo TEXT_SESS_DB; ?></b><br /><?php echo TEXT_SESS_LONG; ?></p>
</fieldset>

<p>
<a href="index.php"><img src="images/button_cancel.gif" border="0" alt="<?php echo IMAGE_CANCEL; ?>" /></a>&nbsp;
<input type="hidden" name="install[]" value="configure" /><input type="image" src="images/button_continue.gif" alt="<?php echo IMAGE_CONTINUE; ?>" />
</p>

</form>

<?php
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