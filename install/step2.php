<?php
  /* --------------------------------------------------------------
   $Id: step2.php 1119 2005-07-25 22:19:50Z novalis $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(step2.php,v 1.4 2002/08/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (step2.php,v 1.16 2003/08/1); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application.php');

  // include needed functions
  require_once(DIR_FS_INC.'xtc_redirect.inc.php');
  require_once(DIR_FS_INC.'xtc_href_link.inc.php');
  require_once(DIR_FS_INC.'xtc_not_null.inc.php');

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
  
  if (xtc_in_array('database', $_POST['install'])) {
   // do nothin  
  } else {
   xtc_redirect('step4.php');
  }
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo TITLE_STEP2; ?></title>
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
                <td>
                <?php                
                // test database connection and write permissions                                            
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
                        echo ('<img src="images/icons/x.jpg">');        
                       } else {
                        echo ('<img src="images/icons/ok.gif">');
                       }
                }
                
                ?>
                </td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                  &nbsp;&nbsp;&nbsp;<img src="images/icons/arrow02.gif" width="13" height="6"><?php echo BOX_DB_IMPORT; ?></font></td>
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
    <td align="center" valign="top" style="border-top: 1px solid; border-bottom: 1px solid; border-right: 1px solid; border-color: #6D6D6D;"> 
      <br />
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <?php echo TEXT_WELCOME_STEP2; ?></font></td>
        </tr>
      </table>

      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/break-el.gif" width="100%" height="1"></font></p>

      <table width="98%" border="0" cellpadding="0" cellspacing="0"> 
      <tr>
    <td> 
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
      <br />
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/icons/error.gif" width="16" height="16"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo TEXT_CONNECTION_ERROR; ?></strong></font></font></td>
          <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
        </tr>
      </table>
      <table width="98%">
<tr><td>
          <p>&nbsp;</p>
          <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_DB_ERROR; ?></font></p>
          <p class="boxme"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
          <table border="0" cellpadding="0" cellspacing="0" bgcolor="f3f3f3">
            <tr>
              <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo $db_error; ?></b></font></td>
  </tr>
</table>
          </font></p> 
          <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_DB_ERROR_1; ?></font></p>
          <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_DB_ERROR_2; ?></font></p>

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

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><a href="index.php"><img src="images/button_cancel.gif" border="0" alt="<?php echo IMAGE_CANCEL; ?>"></a></td>
    <td align="center"><input type="image" src="images/button_back.gif" border="0" alt="<?php echo IMAGE_BACK; ?>"></td>
  </tr>
</table>
</td></tr></table>
</form>
<?php
    } else {
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
      </b><strong><?php echo TEXT_CONNECTION_SUCCESS; ?></strong></font></td>
    <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
  </tr>
</table>
<p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_PROCESS_1; ?></font></p>
      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_PROCESS_2; ?></font></p>
      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_PROCESS_3; ?> <b><?php echo DIR_FS_CATALOG . 'install/vam.sql'; ?></b>.</font></p>

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

<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><a href="step1.php"><img src="images/button_cancel.gif" border="0" alt="<?php echo IMAGE_CANCEL; ?>"></a></td>
    <td align="center"><input type="image" src="images/button_continue.gif" border="0" alt="<?php echo IMAGE_CONTINUE; ?>"></td>
  </tr>
</table>

</form>


<?php
    }
  }
?>
              </td>
  </tr>
</table>
        <br />
        <img src="images/break-el.gif" width="100%" height="1">
                <br />
        <br />
        <br />
 
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