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
  require_once(DIR_FS_INC.'xtc_image.inc.php');
  require_once(DIR_FS_INC.'xtc_draw_separator.inc.php');
  require_once(DIR_FS_INC.'xtc_redirect.inc.php');
  require_once(DIR_FS_INC.'xtc_href_link.inc.php');
  
  include('language/russian.php');


 define('HTTP_SERVER','');
 define('HTTPS_SERVER','');
 define('DIR_WS_CATALOG','');

   $messageStack = new messageStack();

    $process = false;
  if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    $process = true;

        
        $_SESSION['language'] = xtc_db_prepare_input($_POST['LANGUAGE']);

    $error = false;


      if ( ($_SESSION['language'] != 'russian') ) {
        $error = true;

        $messageStack->add('index', SELECT_LANGUAGE_ERROR);
        }
        

                    if ($error == false) {
                        xtc_redirect(xtc_href_link('step1.php', '', 'NONSSL'));
                }
        }


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title><?php echo TITLE_INDEX; ?></title>
<link rel="stylesheet" type="text/css" href="includes/style.css" />
</head>
<body>


<!-- ��������� -->
<div id="container">

<!-- ����� -->
<div id="header">
<img src="images/logo.gif" alt="VaM Shop" />
</div>
<!-- /����� -->

<div id="menu">
<ul>
<li class="current"><a href="index.php"><span><?php echo START; ?></span></a></li>
<li><a href=""><span><?php echo STEP1; ?></span></a></li>
<li><a href=""><span><?php echo STEP2; ?></span></a></li>
<li><a href=""><span><?php echo STEP3; ?></span></a></li>
<li><a href=""><span><?php echo STEP4; ?></span></a></li>
<li><a href=""><span><?php echo STEP5; ?></span></a></li>
<li><a href=""><span><?php echo STEP6; ?></span></a></li>
<li><a href=""><span><?php echo END; ?></span></a></li>
</ul>
</div>

<!-- ��������� -->
<div id="navigation">
<span><?php echo TEXT_INSTALL; ?></span>
</div>
<!-- /��������� -->

<!-- ����� -->
<div id="wrapper">
<div id="content">

<!-- ��������� �������� -->
<h1><?php echo TITLE_INDEX; ?></h1>
<!-- /��������� �������� -->
<!-- ����������� ���� -->
<div class="page">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<!-- ���������� �������� -->
<div class="pagecontent">

<p>
<?php echo TEXT_WELCOME_INDEX; ?>
</p>

<?php

 $error_flag=false;
 $message='';
 $ok_message='';

 // config files
 if (!is_writeable(DIR_FS_CATALOG . 'includes/configure.php')) {
    $error_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'includes/configure.php</div>';
 }
  if (!is_writeable(DIR_FS_CATALOG . 'includes/configure.org.php')) {
    $error_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'includes/configure.org.php</div>';
 }
  if (!is_writeable(DIR_FS_CATALOG . 'admin/includes/configure.php')) {
    $error_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'admin/includes/configure.php</div>';
 }
  if (!is_writeable(DIR_FS_CATALOG . 'admin/includes/configure.org.php')) {
    $error_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'admin/includes/configure.org.php</div>';
 }
 $status = TEXT_OK;
 if ($error_flag==true) { $class='error'; } else { $class = 'ok'; }
 if ($error_flag==true) $status='<span class="errorText">' . TEXT_ERROR . '</span>';
 $ok_message.= '<div class="' . $class . '">' . TEXT_FILE_PERMISSIONS . '' . $status.'</div>';

 // smarty folders
 $folder_flag==false;
   if (!is_writeable(DIR_FS_CATALOG . 'templates_c/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'templates_c/</div>';
 }
    if (!is_writeable(DIR_FS_CATALOG . 'cache/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'cache/</div>';
 }

      if (!is_writeable(DIR_FS_CATALOG . 'admin/images/graphs')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'admin/images/graphs</div>';
 }

    if (!is_writeable(DIR_FS_CATALOG . 'admin/backups/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'admin/backups/</div>';
 }

    if (!is_writeable(DIR_FS_CATALOG . 'admin/contributions/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'admin/contributions/</div>';
 }

    if (!is_writeable(DIR_FS_CATALOG . 'tmp/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'tmp/</div>';
 }

    if (!is_writeable(DIR_FS_CATALOG . 'export/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'export/</div>';
 }

 // image folders
      if (!is_writeable(DIR_FS_CATALOG . 'images/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'images/</div>';
 }
     if (!is_writeable(DIR_FS_CATALOG . 'images/categories/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'images/categories/</div>';
 }
     if (!is_writeable(DIR_FS_CATALOG . 'images/banner/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'images/banner/</div>';
 }
     if (!is_writeable(DIR_FS_CATALOG . 'images/product_images/info_images/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'images/product_images/info_images/</div>';
 }
     if (!is_writeable(DIR_FS_CATALOG . 'images/product_images/original_images/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'images/product_images/original_images/</div>';
 }
     if (!is_writeable(DIR_FS_CATALOG . 'images/product_images/popup_images/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'images/product_images/popup_images/</div>';
 }
      if (!is_writeable(DIR_FS_CATALOG . 'images/product_images/thumbnail_images/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= '<div class="error">' . ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'images/product_images/thumbnail_images/</div>';
 }
 
 $status = TEXT_OK;
 if ($folder_flag==true) { $class='error'; } else { $class = 'ok'; }
 if ($error_flag==true & $folder_flag==true) $status='<span class="errorText">' . TEXT_ERROR . '</span>';
 $ok_message.= '<div class="' . $class . '">' . TEXT_FOLDER_PERMISSIONS . '' . $status.'</div>';

 // check PHP-Version

 $php_flag==false;
 if (xtc_check_version()!=1) {
     $error_flag=true;
     $php_flag=true;
    $message .= PHP_VERSION_ERROR;
 }

 $status = TEXT_OK;
 if ($php_flag==true) { $class='error'; } else { $class = 'ok'; }
 if ($php_flag==true) $status='<span class="errorText">' . TEXT_ERROR . '</span>';
 $ok_message.= '<div class="' . $class . '">' . TEXT_PHP_VERSION . '' . $status.'</div>';


 $gd=gd_info();

 if ($gd['GD Version']=='') $gd['GD Version']='<span class="errorText">' . TEXT_GD_LIB_NOT_FOUND . '</span>';

// $status=$gd['GD Version'].' <br />' . TEXT_GD_LIB_VERSION;

 // display GDlibversion
 $ok_message.= '<div class="ok">' . TEXT_GD_LIB_VERSION1 . '' . $status.'</div>';

 if ($gd['GIF Read Support']==1 or $gd['GIF Support']==1) {
 $status = TEXT_OK;
 $class='ok';
 } else {
 $status = TEXT_GD_LIB_GIF_SUPPORT_ERROR;
 $class='error';
 }
 $ok_message.= '<div class="' . $class . '">' . TEXT_GD_LIB_GIF_SUPPORT . '' . $status.'</div>';

if ($error_flag==true) {
?>
<span class="errorText"><?php echo TEXT_ATTENTION; ?></span><br />
<?php echo $message; ?>
<?php } ?>
<?php
if ($ok_message!='') {
?>
<span class="errorText"><?php echo TEXT_CHECKING; ?></span><br />
<?php echo $ok_message; ?>
<?php } ?>

<p>
<span class="errorText">
<?php echo TITLE_SELECT_LANGUAGE; ?>
</span>
<br />
<?php
  if ($messageStack->size('index') > 0) {
?><br />
<?php echo $messageStack->output('index'); ?></td>

<?php
  }
?>
</p>

<form name="language" method="post" action="index.php">
<p>
<?php echo TEXT_RUSSIAN; ?>  <img src="images/icons/icon-rus.gif" width="30" height="16" alt="" /> <?php echo xtc_draw_radio_field_installer('LANGUAGE', 'russian'); ?>
</p>

<input type="hidden" name="action" value="process" />
<p>
<?php if ($error_flag==false) { ?>
<input type="image" src="images/button_continue.gif" alt="<?php echo IMAGE_CONTINUE; ?>" />
<?php } ?>
<br />
<br />
</p>
</form>

</div>
<!-- /���������� �������� -->
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
<!-- /����������� ���� -->

</div>
<p></p>

</div>
</div>
<!-- /����� -->

<!-- ����� ������� -->
<div id="left">
&nbsp;
</div>
<!-- /����� ������� -->

<!-- ������ ������� -->
<div id="right">
&nbsp;
</div>
<!-- /������ ������� -->

<!-- ��� -->
<div id="footer">
&nbsp;
</div>
<!-- /��� -->

</div>
<!-- /��������� -->

<div id="copyright">Powered by <a href="http://vamshop.ru" target="_blank">VaM Shop</a></div>

</body>
</html>