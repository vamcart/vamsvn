<?php
  /* --------------------------------------------------------------
   $Id: finished.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (finished.php,v 1.5 2003/08/17); www.nextcommerce.org
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/
  
  require('includes/application.php');
  require('../admin/includes/configure.php'); 
  
  include('language/'.$_SESSION['language'].'.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo TITLE_FINISHED; ?></title>
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
                  &nbsp;&nbsp;&nbsp;<img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_DB_CONNECTION; ?></font></td>
                <td><img src="images/icons/ok.gif"></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_WEBSERVER_SETTINGS; ?></font></td>
                <td><img src="images/icons/ok.gif"></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_WRITE_CONFIG; ?></font></td>
                <td><img src="images/icons/ok.gif"></td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_ADMIN_CONFIG; ?></font></td>
                <td><img src="images/icons/ok.gif"></td>
              </tr>
                                                  <tr>
                            <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_USERS_CONFIG; ?></font></td>
                <td><img src="images/icons/ok.gif"></td></tr>
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
            <?php echo TEXT_WELCOME_FINISHED; ?></font></td>
        </tr>
      </table>

      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/break-el.gif" width="100%" height="1"></font></p>

      <table width="98%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
                  <?php echo TITLE_SHOP_CONFIG; ?></b></font></td>
                <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
              </tr>
            </table>
                        
                        <p>&nbsp;</p>
            <p align="center"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_SHOP_CONFIG_SUCCESS; ?><br />
              <br />
              <?php echo TEXT_TEAM; ?><br />
              </font></p>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr> 
                <td align="center"><a href="<?php echo HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'index.php'; ?>" target="_blank"><img src="images/button_catalog.gif" border="0" alt="<?php echo TEXT_CATALOG; ?>"></a></td>
                
              </tr>
            </table>
            <p align="center"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><br />
              </font></p></td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></p>
    </td>
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