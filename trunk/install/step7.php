<?php
  /* --------------------------------------------------------------
   $Id: step7.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   Released under the GNU General Public License
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (step7.php,v 1.26 2003/08/17); www.nextcommerce.org
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('../includes/configure.php'); 
  
  require('includes/application.php');
  
  require_once(DIR_FS_INC . 'xtc_rand.inc.php');
  require_once(DIR_FS_INC . 'xtc_encrypt_password.inc.php');   
  require_once(DIR_FS_INC . 'xtc_db_connect.inc.php');
  require_once(DIR_FS_INC . 'xtc_db_query.inc.php');
  require_once(DIR_FS_INC . 'xtc_db_fetch_array.inc.php');
  require_once(DIR_FS_INC . 'xtc_validate_email.inc.php');
  require_once(DIR_FS_INC . 'xtc_db_input.inc.php');
  require_once(DIR_FS_INC . 'xtc_db_num_rows.inc.php');
  require_once(DIR_FS_INC . 'xtc_redirect.inc.php');
  require_once(DIR_FS_INC . 'xtc_href_link.inc.php');
  require_once(DIR_FS_INC . 'xtc_draw_pull_down_menu.inc.php');
  require_once(DIR_FS_INC . 'xtc_draw_input_field.inc.php');
  require_once(DIR_FS_INC . 'xtc_get_country_list.inc.php');

  include('language/'.$_SESSION['language'].'.php');
  
  // connect do database
  xtc_db_connect() or die('Unable to connect to database server!'); 
 
  // get configuration data
  $configuration_query = xtc_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
  while ($configuration = xtc_db_fetch_array($configuration_query)) {
    define($configuration['cfgKey'], $configuration['cfgValue']);
  }

   $messageStack = new messageStack();
  
    $process = false;
  if (isset($_POST['action']) && ($_POST['action'] == 'process')) {
    $process = true;
        
                $status_discount = xtc_db_prepare_input($_POST['STATUS_DISCOUNT']);
                $status_ot_discount_flag = xtc_db_prepare_input($_POST['STATUS_OT_DISCOUNT_FLAG']);
                $status_ot_discount = xtc_db_prepare_input($_POST['STATUS_OT_DISCOUNT']);
                $graduated_price = xtc_db_prepare_input($_POST['STATUS_GRADUATED_PRICE']);
                $show_price = xtc_db_prepare_input($_POST['STATUS_SHOW_PRICE']);
                $show_tax = xtc_db_prepare_input($_POST['STATUS_SHOW_TAX']);

        
                $status_discount2 = xtc_db_prepare_input($_POST['STATUS_DISCOUNT2']);
                $status_ot_discount_flag2 = xtc_db_prepare_input($_POST['STATUS_OT_DISCOUNT_FLAG2']);
                $status_ot_discount2 = xtc_db_prepare_input($_POST['STATUS_OT_DISCOUNT2']);
                $graduated_price2 = xtc_db_prepare_input($_POST['STATUS_GRADUATED_PRICE2']);
                $show_price2 = xtc_db_prepare_input($_POST['STATUS_SHOW_PRICE2']);
                $show_tax2 = xtc_db_prepare_input($_POST['STATUS_SHOW_TAX2']);

    $error = false;
        // default guests    
     if (strlen($status_discount) < '3') {
        $error = true;
        $messageStack->add('step7', ENTRY_DISCOUNT_ERROR);
        }
     if (strlen($status_ot_discount) < '3') {
        $error = true;
        $messageStack->add('step7', ENTRY_OT_DISCOUNT_ERROR);
        }
     if ( ($status_ot_discount_flag != '1') && ($status_ot_discount_flag != '0') ) {
        $error = true;

        $messageStack->add('step7', SELECT_OT_DISCOUNT_ERROR);
        }
     if ( ($graduated_price != '1') && ($graduated_price != '0') ) {
        $error = true;
        $messageStack->add('step7', SELECT_GRADUATED_ERROR);
        }
     if ( ($show_price != '1') && ($show_price != '0') ) {
        $error = true;
        $messageStack->add('step7', SELECT_PRICE_ERROR);
        }
     if ( ($show_tax != '1') && ($show_tax != '0') ) {
        $error = true;
        $messageStack->add('step7', SELECT_TAX_ERROR);
        }
        
        // default customers
     if (strlen($status_discount2) < '3') {
        $error = true;
      $messageStack->add('step7', ENTRY_DISCOUNT_ERROR2);
        }        
     if (strlen($status_ot_discount2) < '3') {
          $error = true;
          $messageStack->add('step7', ENTRY_OT_DISCOUNT_ERROR2);
        }
     if ( ($status_ot_discount_flag2 != '1') && ($status_ot_discount_flag2 != '0') ) {
        $error = true;
        $messageStack->add('step7', SELECT_OT_DISCOUNT_ERROR2);
        }
     if ( ($graduated_price2 != '1') && ($graduated_price2 != '0') ) {
        $error = true;
        $messageStack->add('step7', SELECT_GRADUATED_ERROR2);
        }
     if ( ($show_price2 != '1') && ($show_price2 != '0') ) {
        $error = true;
        $messageStack->add('step7', SELECT_PRICE_ERROR2);
        }
     if ( ($show_tax2 != '1') && ($show_tax2 != '0') ) {
        $error = true;
        $messageStack->add('step7', SELECT_TAX_ERROR2);
        }
        
if ($error == false) {
                
// admin
xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES ('0', '1', 'Админ', 1, 'admin_status.gif', '0.00', '1', '0.00', '1', '1', '1')");
xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES ('0', '2', 'Admin', 1, 'admin_status.gif', '0.00', '1', '0.00', '1', '1', '1')");

// status Guest
xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES (1, 1, 'Посетитель', 1, 'guest_status.gif', '".$status_discount."', '".$status_ot_discount_flag."', '".$status_ot_discount."', '".$graduated_price."', '".$show_price."', '".$show_tax."')");
xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES (1, 2, 'Guest', 1, 'guest_status.gif', '".$status_discount."', '".$status_ot_discount_flag."', '".$status_ot_discount."', '".$graduated_price."', '".$show_price."', '".$show_tax."')");
// status New customer
xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES (2, 1, 'Покупатель', 1, 'customer_status.gif', '".$status_discount2."', '".$status_ot_discount_flag2."', '".$status_ot_discount2."', '".$graduated_price2."', '".$show_price2."', '".$show_tax2."')");
xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES (2, 2, 'New customer', 1, 'customer_status.gif', '".$status_discount2."', '".$status_ot_discount_flag2."', '".$status_ot_discount2."', '".$graduated_price2."', '".$show_price2."', '".$show_tax2."')");

// status Merchant
xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES (3, 1, 'Оптовый покупатель', 1, 'merchant_status.gif', '0.00', '0', '0.00', '1', 1, 0)");
xtc_db_query("INSERT INTO customers_status (customers_status_id, language_id, customers_status_name, customers_status_public, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_graduated_prices, customers_status_show_price, customers_status_show_price_tax) VALUES (3, 2, 'Merchant', 1, 'merchant_status.gif', '0.00', '0', '0.00', '1', 1, 0)");


// create Group prices (Admin wont get own status!)

xtc_db_query("create table personal_offers_by_customers_status_1 (price_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,products_id int NOT NULL,quantity int, personal_offer decimal(15,4)) ");
xtc_db_query("create table personal_offers_by_customers_status_2 (price_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,products_id int NOT NULL,quantity int, personal_offer decimal(15,4)) ");
xtc_db_query("create table personal_offers_by_customers_status_0 (price_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,products_id int NOT NULL,quantity int, personal_offer decimal(15,4)) ");
xtc_db_query("create table personal_offers_by_customers_status_3 (price_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,products_id int NOT NULL,quantity int, personal_offer decimal(15,4)) ");
              xtc_redirect(xtc_href_link('install/finished.php', '', 'NONSSL'));
                }                       
        }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo TITLE_STEP7; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<?php require('includes/form_check.js.php'); ?>
<style type="text/css">
<!--
.messageBox {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 1;
}
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
          <td bgcolor="F3F3F3" ><br> 
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
                <td>&nbsp;</td>
              </tr>
                                      <?php
  if ($messageStack->size('step7') > 0) {
?>
<tr><td style="border-bottom: 1px solid; border-color: #cccccc;" colspan="3">&nbsp;</td>
<tr><td colspan="3">
             <table border="0" cellpadding="0" cellspacing="0" bgcolor="f3f3f3">
              <tr> 
                <td><?php echo $messageStack->output('step7'); ?></td>
              </tr>
            </table>
</td></tr>
            <?php
  }
?>
            </table>
            <br></td>
        </tr>
      </table>
    </td>
    <td align="right" valign="top" style="border-top: 1px solid; border-bottom: 1px solid; border-right: 1px solid; border-color: #6D6D6D;"> 
      <br>
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td>
            <?php echo TEXT_WELCOME_STEP7; ?></font></td>
        </tr>
      </table> 
      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/break-el.gif" width="100%" height="1"></font></p>
      <table width="98%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td>
             

             <form name="install" action="step7.php" method="post" onSubmit="return check_form(step6);">
              <input name="action" type="hidden" value="process">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
                    <?php echo TITLE_GUEST_CONFIG; ?> </b></font><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <b><?php echo TEXT_REQU_INFORMATION; ?></b></font></td>
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
                </tr>
              </table>
                          <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TITLE_GUEST_CONFIG_NOTE; ?></font>
              <table width="100%" border="0">
                <tr> 
                  <td><p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_STATUS_DISCOUNT; ?></b><br>
                      <?php echo xtc_draw_input_field_installer('STATUS_DISCOUNT','0.00'); ?><br>
                      <?php echo TEXT_STATUS_DISCOUNT_LONG; ?></font></p>
                    <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_STATUS_OT_DISCOUNT_FLAG; ?></b><br>
                      <?php echo  TEXT_ZONE_YES; ?> </font><?php echo xtc_draw_radio_field_installer('STATUS_OT_DISCOUNT_FLAG', '1'); ?><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TEXT_ZONE_NO; ?></font>
                      <?php echo xtc_draw_radio_field_installer('STATUS_OT_DISCOUNT_FLAG', '0', 'true'); ?><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                      <?php echo TEXT_STATUS_OT_DISCOUNT_FLAG_LONG; ?></font></p>
                    <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_STATUS_OT_DISCOUNT; ?></b><br>
                      <?php echo xtc_draw_input_field_installer('STATUS_OT_DISCOUNT','0.00'); ?><br>
                      <?php echo TEXT_STATUS_OT_DISCOUNT_LONG; ?></font></p>
                    <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_STATUS_GRADUATED_PRICE; ?></b><br>
                      <?php echo  TEXT_ZONE_YES; ?> </font><?php echo xtc_draw_radio_field_installer('STATUS_GRADUATED_PRICE', '1'); ?>
                      <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TEXT_ZONE_NO; ?></font> 
                      <?php echo xtc_draw_radio_field_installer('STATUS_GRADUATED_PRICE', '0', 'true'); ?><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                      <?php echo TEXT_STATUS_GRADUATED_PRICE_LONG; ?></font></p>
                    <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                      <b><?php echo TEXT_STATUS_SHOW_PRICE; ?></b><br>
                      <?php echo  TEXT_ZONE_YES; ?> </font><?php echo xtc_draw_radio_field_installer('STATUS_SHOW_PRICE', '1', 'true'); ?>
                      <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TEXT_ZONE_NO; ?></font> 
                      <?php echo xtc_draw_radio_field_installer('STATUS_SHOW_PRICE', '0'); ?><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                      <?php echo TEXT_STATUS_SHOW_PRICE_LONG; ?></font></p>
                    <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_STATUS_SHOW_TAX; ?></b><br>
                      <?php echo  TEXT_ZONE_YES; ?> </font><?php echo xtc_draw_radio_field_installer('STATUS_SHOW_TAX', '1', 'true'); ?>
                      <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TEXT_ZONE_NO; ?></font> 
                      <?php echo xtc_draw_radio_field_installer('STATUS_SHOW_TAX', '0'); ?><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                      <?php echo TEXT_STATUS_SHOW_TAX_LONG; ?></font></p></td>     
                </tr>
              </table>
              <p>&nbsp;</p>
                          <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
                  <?php echo TITLE_CUSTOMERS_CONFIG; ?> </b></font><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                  <b><?php echo TEXT_REQU_INFORMATION; ?></b></font></td>
                <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
              </tr>
            </table>
              <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TITLE_CUSTOMERS_CONFIG_NOTE; ?></font><br>
              <table width="100%" border="0">
                <tr> 
                  <td><p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_STATUS_DISCOUNT; ?></b><br>
                      <?php echo xtc_draw_input_field_installer('STATUS_DISCOUNT2','0.00'); ?><br>
                      <?php echo TEXT_STATUS_DISCOUNT_LONG; ?></font></p>
                    <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_STATUS_OT_DISCOUNT_FLAG; ?></b><br>
                      <?php echo  TEXT_ZONE_YES; ?> </font><?php echo xtc_draw_radio_field_installer('STATUS_OT_DISCOUNT_FLAG2', '1'); ?>
                      <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TEXT_ZONE_NO; ?></font> 
                      <?php echo xtc_draw_radio_field_installer('STATUS_OT_DISCOUNT_FLAG2', '0', 'true'); ?><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                      <?php echo TEXT_STATUS_OT_DISCOUNT_FLAG_LONG; ?></font></p>
                    <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_STATUS_OT_DISCOUNT; ?></b><br>
                      <?php echo xtc_draw_input_field_installer('STATUS_OT_DISCOUNT2','0.00'); ?><br>
                      <?php echo TEXT_STATUS_OT_DISCOUNT_LONG; ?></font></p>
                    <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_STATUS_GRADUATED_PRICE; ?></b><br>
                      <?php echo  TEXT_ZONE_YES; ?> </font><?php echo xtc_draw_radio_field_installer('STATUS_GRADUATED_PRICE2', '1', 'true'); ?>
                      <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TEXT_ZONE_NO; ?></font> 
                      <?php echo xtc_draw_radio_field_installer('STATUS_GRADUATED_PRICE2', '0'); ?><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                      <?php echo TEXT_STATUS_GRADUATED_PRICE_LONG; ?></font></p>
                    <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                      <b><?php echo TEXT_STATUS_SHOW_PRICE; ?></b><br>
                      <?php echo  TEXT_ZONE_YES; ?> </font><?php echo xtc_draw_radio_field_installer('STATUS_SHOW_PRICE2', '1', 'true'); ?>
                      <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TEXT_ZONE_NO; ?></font> 
                      <?php echo xtc_draw_radio_field_installer('STATUS_SHOW_PRICE2', '0'); ?><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                      <?php echo TEXT_STATUS_SHOW_PRICE_LONG; ?></font></p>
                    <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo TEXT_STATUS_SHOW_TAX; ?></b><br>
                      <?php echo  TEXT_ZONE_YES; ?> </font><?php echo xtc_draw_radio_field_installer('STATUS_SHOW_TAX2', '1', 'true'); ?>
                      <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TEXT_ZONE_NO; ?></font> 
                      <?php echo xtc_draw_radio_field_installer('STATUS_SHOW_TAX2', '0'); ?><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><br>
                      <?php echo TEXT_STATUS_SHOW_TAX_LONG; ?></font></p></td>
                    
                </tr>
              </table>
                          <p><br>
              </p>
              <center>
                <input name="image" type="image" src="images/button_continue.gif" alt="<?php echo IMAGE_CONTINUE; ?>" align="middle" border="0">
                <br>
              </center>
            </form></td>
        </tr>
      </table> 
      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/break-el.gif" width="100%" height="1"></font></p>

      <p>&nbsp;</p>
    </td>
  </tr>
</table>


<p align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_FOOTER; ?><br>
  </font></p>
<p align="center">&nbsp;</p>
</body>
</html>