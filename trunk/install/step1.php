<?php
/* --------------------------------------------------------------
   $Id: step1.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(install.php,v 1.7 2002/08/14); www.oscommerce.com 
   (c) 2003	 nextcommerce (step1.php,v 1.10 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
  
  require('includes/application.php');

  include('language/'.$_SESSION['language'].'.php');
  
  if (!$script_filename = str_replace('\\', '/', getenv('PATH_TRANSLATED'))) {
    $script_filename = getenv('SCRIPT_FILENAME');
  }
  $script_filename = str_replace('//', '/', $script_filename);

  if (!$request_uri = getenv('REQUEST_URI')) {
    if (!$request_uri = getenv('PATH_INFO')) {
      $request_uri = getenv('SCRIPT_NAME');
    }

    if (getenv('QUERY_STRING')) $request_uri .=  '?' . getenv('QUERY_STRING');
  }

  $dir_fs_www_root_array = explode('/', dirname($script_filename));
  $dir_fs_www_root = array();
  for ($i=0; $i<sizeof($dir_fs_www_root_array)-2; $i++) {
    $dir_fs_www_root[] = $dir_fs_www_root_array[$i];
  }
  $dir_fs_www_root = implode('/', $dir_fs_www_root);

  $dir_ws_www_root_array = explode('/', dirname($request_uri));
  $dir_ws_www_root = array();
  for ($i=0; $i<sizeof($dir_ws_www_root_array)-1; $i++) {
    $dir_ws_www_root[] = $dir_ws_www_root_array[$i];
  }
  $dir_ws_www_root = implode('/', $dir_ws_www_root);
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo TITLE_STEP1; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<style type="text/css">
<!--
.messageStackError, .messageStackWarning { font-family: Verdana, Arial, sans-serif; font-weight: bold; font-size: 10px; background-color: #; }
-->
</style>
</head>

<body>
<table width="800" height="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="95" colspan="2" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="1"><img src="images/logo.gif"></td>
          <td background="images/bg_top.jpg">&nbsp;</td>
        </tr>
      </table>
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
                <td width="135"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_LANGUAGE; ?></font></td>
                <td width="35"><img src="images/icons/ok.gif"></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_DB_CONNECTION; ?></font></td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_WEBSERVER_SETTINGS; ?></font></td>
                <td>&nbsp;</td>
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
            <?php echo TEXT_WELCOME_STEP1; ?></font></td>
        </tr>
      </table>

      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/break-el.gif" width="100%" height="1"></font></p>

      <form name="install" method="post" action="step2.php">
            <table width="98%" border="0" cellpadding="0" cellspacing="0">
          <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
                    </b></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TITLE_CUSTOM_SETTINGS; ?></b></font></td>
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
                </tr>
              </table>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_checkbox_field_installer('install[]', 'database', true); ?>
                <b><?php echo TEXT_IMPORT_DB; ?></b><br />
                <?php echo TEXT_IMPORT_DB_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_checkbox_field_installer('install[]', 'configure', true); ?> 
                <b><?php echo TEXT_AUTOMATIC; ?></b><br />
                <?php echo TEXT_AUTOMATIC_LONG; ?></font></p>

</td>
  </tr>
</table>
        <br />
        <img src="images/break-el.gif" width="100%" height="1">
                <br />
        <table width="98%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td>
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
                    </b></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TITLE_DATABASE_SETTINGS; ?></b></font></td>
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
                </tr>
              </table>
              <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b> 
                </b></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_DATABASE_SERVER; ?></b><br />
                <?php echo xtc_draw_input_field_installer('DB_SERVER'); ?><br />
                <?php echo TEXT_DATABASE_SERVER_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_USERNAME; ?></b><br />
                <?php echo xtc_draw_input_field_installer('DB_SERVER_USERNAME'); ?><br />
                <?php echo TEXT_USERNAME_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_PASSWORD; ?></b><br />
                <?php echo xtc_draw_input_field_installer('DB_SERVER_PASSWORD'); ?><br />
                <?php echo TEXT_PASSWORD_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_DATABASE; ?></b><br />
                <?php echo xtc_draw_input_field_installer('DB_DATABASE'); ?><br />
                <?php echo TEXT_DATABASE_LONG; ?></font></p></td>
          </tr>
        </table>
                <br />
                <img src="images/break-el.gif" width="100%" height="1">
                <br />
                <table width="98%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
                    <?php echo TITLE_WEBSERVER_SETTINGS; ?> </b></font></td>
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
                </tr>
              </table>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_WS_ROOT; ?></b><br />
                <?php echo xtc_draw_input_field_installer('DIR_FS_DOCUMENT_ROOT', $dir_fs_www_root,'','size=60'); ?><br />
                <?php echo TEXT_WS_ROOT_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_WS_XTC; ?></b><br />
                <?php echo xtc_draw_input_field_installer('DIR_FS_CATALOG', $local_install_path,'','size=60'); ?><br />
                <?php echo TEXT_WS_XTC_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_WS_ADMIN; ?></b><br />
                <?php echo xtc_draw_input_field_installer('DIR_FS_ADMIN', $local_install_path.'admin/','','size=60'); ?><br />
               <?php echo TEXT_WS_ADMIN_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b> <?php echo TEXT_WS_CATALOG; ?></b><br />
                <?php echo xtc_draw_input_field_installer('DIR_WS_CATALOG', $dir_ws_www_root . '/','','size=60'); ?><br />
                 <?php echo TEXT_WS_CATALOG_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b> <?php echo TEXT_WS_ADMINTOOL; ?></b><br />
                <?php echo xtc_draw_input_field_installer('DIR_WS_ADMIN', $dir_ws_www_root . '/admin/','','size=60'); ?><br />
                 <?php echo TEXT_WS_ADMINTOOL_LONG; ?></font></p></td>
          </tr>
        </table>
<br />
<img src="images/break-el.gif" width="100%" height="1">
<br />
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><a href="index.php"><img src="images/button_cancel.gif" border="0" alt="<?php echo IMAGE_CANCEL; ?>"></a></td>
    <td align="center"><input type="image" src="images/button_continue.gif" border="0" alt="<?php echo IMAGE_CONTINUE; ?>"></td>
  </tr>
</table>
</form>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></p>
    </td>
  </tr>
</table>



<p align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_FOOTER; ?>
  </font></p>
<p align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
  </font></p>
</body>
</html>

</body>
</html>