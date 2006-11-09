<?php
  /* --------------------------------------------------------------
   $Id: step4.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(step4.php,v 1.9 2002/08/19); www.oscommerce.com
   (c) 2003	 nextcommerce (step4.php,v 1.14 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
   require('includes/application.php');

   include('language/'.$_SESSION['language'].'.php');
  

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo TITLE_STEP4; ?></title>
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
          <td width="1" colspan="2"><img src="images/logo.gif"></td>
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
                <td><img src="images/icons/ok.gif"></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                  &nbsp;&nbsp;&nbsp;<img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_DB_IMPORT; ?></font></td>
                <td><img src="images/icons/ok.gif"></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_WEBSERVER_SETTINGS; ?></font></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_WRITE_CONFIG; ?></font></td>
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
            <?php echo TEXT_WELCOME_STEP4; ?></font></td>
        </tr>
      </table>

      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/break-el.gif" width="100%" height="1"></font></p>

      <table width="98%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td> <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
                  <?php echo TITLE_WEBSERVER_CONFIGURATION; ?></b></font></td>
                <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
              </tr>
            </table>
            <?php
  if ( ( (file_exists(DIR_FS_CATALOG . 'includes/configure.php')) && (!is_writeable(DIR_FS_CATALOG . 'includes/configure.php')) ) || ( (file_exists(DIR_FS_CATALOG . 'admin/includes/configure.php')) && (!is_writeable(DIR_FS_CATALOG . 'admin/includes/configure.php')) ) || ( (file_exists(DIR_FS_CATALOG . 'admin/includes/local/configure.php')) && (!is_writeable(DIR_FS_CATALOG . 'admin/includes/local/configure.php')) ) || ( (file_exists(DIR_FS_CATALOG . 'includes/local/configure.php')) && (!is_writeable(DIR_FS_CATALOG . 'includes/local/configure.php')) )) {
?>
            <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/error.gif" width="16" height="16"> 
              <strong><font color="#FF0000" size="2"><?php echo TITLE_STEP4_ERROR; ?></font></strong></font></p>
            <p>
            <div class="boxMe"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_STEP4_ERROR; ?></font>
              <ul class="boxMe">
                <li><font size="1" face="Verdana, Arial, Helvetica, sans-serif">cd <?php echo DIR_FS_CATALOG; ?>admin/includes/</font></li>
                <li><font size="1" face="Verdana, Arial, Helvetica, sans-serif">touch configure.php</font></li>
                <li><font size="1" face="Verdana, Arial, Helvetica, sans-serif">chmod 706 configure.php</font></li>
                <li><font size="1" face="Verdana, Arial, Helvetica, sans-serif">chmod 706 configure.org.php</font></li>
              </ul>
              <ul class="boxMe">
                <li><font size="1" face="Verdana, Arial, Helvetica, sans-serif">cd 
                  <?php echo DIR_FS_CATALOG; ?>includes/</font></li>
                <li><font size="1" face="Verdana, Arial, Helvetica, sans-serif">touch 
                  configure.php</font></li>

                <li><font size="1" face="Verdana, Arial, Helvetica, sans-serif">chmod
                  706 configure.php</font> </li>
                  <li><font size="1" face="Verdana, Arial, Helvetica, sans-serif">chmod 706 configure.org.php</font></li>
              </ul>
            </div>
            <font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; </font><font size="1">
<p class="noteBox"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_STEP4_ERROR_1; ?></font></p>
            <p class="noteBox"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_STEP4_ERROR_2; ?></font></p>
            </font>
            <form name="install" action="step4.php" method="post">
              <font size="1" face="Verdana, Arial, Helvetica, sans-serif">
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
              </font>
              <table border="0" width="100%" cellspacing="0" cellpadding="0">
                <tr> 
                  <td align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="index.php"><img src="images/button_cancel.gif" border="0" alt="<?php echo IMAGE_CANCEL; ?>"></a></font></td>
                  <td align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">
                    <input type="image" src="images/button_retry.gif" border="0" alt="<?php echo IMAGE_RETRY; ?>">
                    </font></td>
                </tr>
              </table>
            </form>
            <font size="1" face="Verdana, Arial, Helvetica, sans-serif">
            <?php
  } else {
?>
            </font>
            <form name="install" action="step5.php" method="post">
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_VALUES; ?><br />
                <br />
                includes/configure.php<br />
                includes/configure.org.php<br />
                admin/includes/configure.php<br />
                admin/includes/configure.org.php<br />
              </p>
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
                    <?php echo TITLE_CHECK_CONFIGURATION; ?></b></font></td>
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
                </tr>
              </table>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_HTTP; ?></b><br />
                <?php echo xtc_draw_input_field_installer('HTTP_SERVER', 'http://' . getenv('HTTP_HOST')); ?><br />
                <?php echo TEXT_HTTP_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_HTTPS; ?></b><br />
                <?php echo xtc_draw_input_field_installer('HTTPS_SERVER', 'https://' . getenv('HTTP_HOST')); ?><br />
                <?php echo TEXT_HTTPS_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_checkbox_field_installer('ENABLE_SSL', 'true'); ?> 
                <b><?php echo TEXT_SSL; ?></b><br />
               <?php echo TEXT_SSL_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_WS_ROOT; ?></b><br />
                <?php echo xtc_draw_input_field_installer('DIR_FS_DOCUMENT_ROOT'); ?><br />
                <?php echo TEXT_WS_ROOT_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_WS_XTC; ?></b><br />
                <?php echo xtc_draw_input_field_installer('DIR_FS_CATALOG'); ?><br />
                <?php echo TEXT_WS_XTC_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_WS_ADMIN; ?></b><br />
                <?php echo xtc_draw_input_field_installer('DIR_FS_ADMIN'); ?><br />
                <?php echo TEXT_WS_ADMIN_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_WS_CATALOG; ?></b><br />
                <?php echo xtc_draw_input_field_installer('DIR_WS_CATALOG'); ?><br />
                <?php echo TEXT_WS_CATALOG_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_WS_ADMINTOOL; ?></b><br />
                <?php echo xtc_draw_input_field_installer('DIR_WS_ADMIN'); ?><br />
                <?php echo TEXT_WS_ADMINTOOL_LONG; ?></font></p>
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
                    <?php echo TITLE_CHECK_DATABASE; ?></b></font></td>
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
                </tr>
              </table>
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
                <?php echo TEXT_DATABASE_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_checkbox_field_installer('USE_PCONNECT', 'true'); ?> 
                <b><?php echo TEXT_PERSIST; ?></b><br />
                <?php echo TEXT_PERSIST_LONG; ?></font></p>
              <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_radio_field_installer('STORE_SESSIONS', 'files', true); ?> 
                <b><?php echo TEXT_SESS_FILE; ?></b><br />
                <?php echo xtc_draw_radio_field_installer('STORE_SESSIONS', 'mysql'); ?> 
                <b><?php echo TEXT_SESS_DB; ?></b><br />
                <?php echo TEXT_SESS_LONG; ?></font></p>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><a href="index.php"><img src="images/button_cancel.gif" border="0" alt="<?php echo IMAGE_CANCEL; ?>"></a></td>
    <td align="center"><input type="hidden" name="install[]" value="configure"><input type="image" src="images/button_continue.gif" border="0" alt="<?php echo IMAGE_CONTINUE; ?>"></td>
  </tr>
</table>

</form>

<?php
  }
?>
                  
                  </td>
        </tr>
      </table>
      
    <p>&nbsp;</p></td>
  </tr>
</table>



<p align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_FOOTER; ?><br />
  </font></p>
<p align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
  </font></p>
</body>
</html>

</body>
</html>