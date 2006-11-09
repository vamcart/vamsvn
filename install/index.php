<?php
  /* --------------------------------------------------------------
   $Id: index.php 1220 2005-09-16 15:53:13Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (index.php,v 1.18 2003/08/17); www.nextcommerce.org
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/
   
  require('includes/application.php');

  // include needed functions
  require_once(DIR_FS_INC.'xtc_image.inc.php');
  require_once(DIR_FS_INC.'xtc_draw_separator.inc.php');
  require_once(DIR_FS_INC.'xtc_redirect.inc.php');
  require_once(DIR_FS_INC.'xtc_href_link.inc.php');
  
  include('language/russian.php');

  // Include Developer - standard settings for installer
  //  require('developer_settings.php');  
  
 define('HTTP_SERVER','');
 define('HTTPS_SERVER','');
 define('DIR_WS_CATALOG','');

   $messageStack = new messageStack();

    $process = false;
  if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    $process = true;

        
        $_SESSION['language'] = xtc_db_prepare_input($_POST['LANGUAGE']);

    $error = false;


      if ( ($_SESSION['language'] != 'russian') && ($_SESSION['language'] != 'english') ) {
        $error = true;

        $messageStack->add('index', SELECT_LANGUAGE_ERROR);
        }
        

                    if ($error == false) {
                        xtc_redirect(xtc_href_link('step1.php', '', 'NONSSL'));
                }
        }


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo TITLE_INDEX; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<style type="text/css">
<!--
.messageStackError, .messageStackWarning { font-family: Verdana, Arial, sans-serif; font-weight: bold; font-size: 10px; background-color: #; }
-->
</style>
</head>

<body>
<table width="800" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="95" colspan="2" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="1" colspan="2"><img src="images/logo.gif"></td>
        </tr>
      </table>

    </td>
  </tr>
  <tr>
    <td width="180" valign="top" bgcolor="F3F3F3" style="border-bottom: 1px solid; border-left: 1px solid; border-right: 1px solid; border-color: #6D6D6D;">
      <table width="180" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="17" background="images/bg_left_blocktitle.gif">
<div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#999999"><?php echo TEXT_INSTALL; ?></font></b></font></div></td>
        </tr>
        <tr>
          <td bgcolor="F3F3F3" ><br />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="10">&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_LANGUAGE; ?></font></td>
              </tr>
            </table>
            <br /></td>
        </tr>
      </table>
    </td>
    <td align="right" valign="top" style="border-top: 1px solid; border-bottom: 1px solid; border-right: 1px solid; border-color: #6D6D6D;">
      <br />
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_WELCOME_INDEX; ?></font><br />
            <br /><br />
          </td>
        </tr>  
        <tr>
<?php
  // permission check to prevent DAU faults.
 $error_flag=false;
 $message='';
 $ok_message='';

 // config files
 if (!is_writeable(DIR_FS_CATALOG . 'includes/configure.php')) {
    $error_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'includes/configure.php<br />';
 }
  if (!is_writeable(DIR_FS_CATALOG . 'includes/configure.org.php')) {
    $error_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'includes/configure.org.php<br />';
 }
  if (!is_writeable(DIR_FS_CATALOG . 'admin/includes/configure.php')) {
    $error_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'admin/includes/configure.php<br />';
 }
  if (!is_writeable(DIR_FS_CATALOG . 'admin/includes/configure.org.php')) {
    $error_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'admin/includes/configure.org.php<br />';
 }
 $status = TEXT_OK;
 if ($error_flag==true) $status='<b><font color="ff0000">' . TEXT_ERROR . '</font></b>';
 $ok_message.=TEXT_FILE_PERMISSIONS . '' . $status.'<br /><hr noshade>';

 // smarty folders
 $folder_flag==false;
   if (!is_writeable(DIR_FS_CATALOG . 'templates_c/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'templates_c/<br />';
 }
    if (!is_writeable(DIR_FS_CATALOG . 'cache/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'cache/<br />';
 }

     if (!is_writeable(DIR_FS_CATALOG . 'admin/rss/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'admin/rss/<br />';
 }

      if (!is_writeable(DIR_FS_CATALOG . 'admin/images/graphs')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'admin/images/graphs<br />';
 }

    if (!is_writeable(DIR_FS_CATALOG . 'admin/backups/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'admin/backups/<br />';
 }

    if (!is_writeable(DIR_FS_CATALOG . 'tmp/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'tmp/<br />';
 }

    if (!is_writeable(DIR_FS_CATALOG . 'export/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'export/<br />';
 }

 // image folders
      if (!is_writeable(DIR_FS_CATALOG . 'images/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'images/<br />';
 }
     if (!is_writeable(DIR_FS_CATALOG . 'images/categories/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'images/categories/<br />';
 }
     if (!is_writeable(DIR_FS_CATALOG . 'images/banner/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'images/banner/<br />';
 }
     if (!is_writeable(DIR_FS_CATALOG . 'images/product_images/info_images/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'images/product_images/info_images/<br />';
 }
     if (!is_writeable(DIR_FS_CATALOG . 'images/product_images/original_images/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'images/product_images/original_images/<br />';
 }
     if (!is_writeable(DIR_FS_CATALOG . 'images/product_images/popup_images/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'images/product_images/popup_images/<br />';
 }
      if (!is_writeable(DIR_FS_CATALOG . 'images/product_images/thumbnail_images/')) {
    $error_flag=true;
    $folder_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'images/product_images/thumbnail_images/<br />';
 }
 
   if (!is_writeable(DIR_FS_CATALOG . 'admin/rss/xt-news.cache')) {
    $error_flag=true;
    $message .= ERROR_PERMISSION . '' . DIR_FS_CATALOG . 'admin/rss/xt-news.cache<br />';
 }

 $status = TEXT_OK;
 if ($folder_flag==true) $status='<b><font color="ff0000">' . TEXT_ERROR . '</font></b>';
 $ok_message.=TEXT_FOLDER_PERMISSIONS . '' . $status.'<br /><hr noshade>';

 // check PHP-Version

 $php_flag==false;
 if (xtc_check_version()!=1) {
     $error_flag=true;
     $php_flag=true;
    $message .= PHP_VERSION_ERROR;
 }

 $status = TEXT_OK;
 if ($php_flag==true) $status='<b><font color="ff0000">' . TEXT_ERROR . '</font></b>';
 $ok_message.= TEXT_PHP_VERSION . '' . $status.'<br /><hr noshade>';


 $gd=gd_info();

 if ($gd['GD Version']=='') $gd['GD Version']='<b><font color="ff0000">' . TEXT_GD_LIB_NOT_FOUND . '</font></b>';

// $status=$gd['GD Version'].' <br />' . TEXT_GD_LIB_VERSION;

 // display GDlibversion
 $ok_message.= TEXT_GD_LIB_VERSION1 . '' . $status.'<br /><hr noshade>';

 if ($gd['GIF Read Support']==1 or $gd['GIF Support']==1) {
 $status = TEXT_OK;
 } else {
 $status = TEXT_GD_LIB_GIF_SUPPORT_ERROR;
 }
 $ok_message.= TEXT_GD_LIB_GIF_SUPPORT . '' . $status.'<br /><hr noshade>';

if ($error_flag==true) {
?>
        <td style="border: 1px solid; border-color: #ff0000;" bgcolor="#FFCCCC">
<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_ATTENTION; ?><br /></b>
<?php echo $message; ?>
</font>
</td>
<?php } ?>
</tr>
<tr>
<?php
if ($ok_message!='') {
?>
<td height="20"></td></tr><tr>
<td style="border: 1px solid; border-color: #4CC534;" bgcolor="#C2FFB6">
<font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_CHECKING; ?><br /></b>
<?php echo $ok_message; ?>
</font>
</td>
<?php } ?>
</tr>

      </table>
      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/break-el.gif" width="100%" height="1"></font></p>


      <table width="98%" border="0" align="right" cellpadding="0" cellspacing="0">
        <tr>
          <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2"><img src="images/icons/arrow-setup.jpg" width="16" height="16">
            <?php echo TITLE_SELECT_LANGUAGE; ?></font></strong><br />
            <img src="images/break-el.gif" width="100%" height="1"><br />
                                                        <?php
  if ($messageStack->size('index') > 0) {
?><br />
<table border="0" cellpadding="0" cellspacing="0" bgcolor="f3f3f3">
            <tr>
              <td><?php echo $messageStack->output('index'); ?></td>
  </tr>
</table>


<?php
  }
?>
            </font> <form name="language" method="post" action="index.php">

              <table width="300" border="0" cellpadding="0" cellspacing="4">
                <tr>
                  <td width="98"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo TEXT_RUSSIAN; ?></font></td>
                  <td width="192"><img src="images/icons/icon-rus.gif" width="30" height="16">
                    <?php echo xtc_draw_radio_field_installer('LANGUAGE', 'russian'); ?>
                  </td>
                </tr>
                <tr>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo TEXT_ENGLISH; ?></font></td>
                  <td><img src="images/icons/icon-eng.gif" width="30" height="16">
                    <?php echo xtc_draw_radio_field_installer('LANGUAGE', 'english'); ?> </td>
                </tr>
              </table>

              <input type="hidden" name="action" value="process">
              <p> <?php if ($error_flag==false) { ?><input type="image" src="images/button_continue.gif" border="0" alt="<?php echo IMAGE_CONTINUE; ?>"> <?php } ?><br />
                <br />
              </p>
            </form>

          </td>
        </tr>
      </table></td>
  </tr>
</table>

<p align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_FOOTER; ?>  </font></p>
<p align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
  </font></p>
</body>
</html>