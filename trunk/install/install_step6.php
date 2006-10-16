<?php
  /* --------------------------------------------------------------
   $Id: install_step6.php 941 2005-05-11 19:49:53Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   Released under the GNU General Public License 
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (install_step6.php,v 1.29 2003/08/20); www.nextcommerce.org
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('../includes/configure.php');
  
  require('includes/application.php');
  
  require_once(DIR_FS_INC . 'xtc_rand.inc.php');
  require_once(DIR_FS_INC . 'xtc_encrypt_password.inc.php');
  require_once(DIR_FS_INC . 'xtc_db_connect.inc.php');
  require_once(DIR_FS_INC . 'xtc_db_query.inc.php');
  require_once(DIR_FS_INC . 'xtc_db_fetch_array.inc.php');
  require_once(DIR_FS_INC .'xtc_validate_email.inc.php');
  require_once(DIR_FS_INC .'xtc_db_input.inc.php');
  require_once(DIR_FS_INC .'xtc_db_num_rows.inc.php');
  require_once(DIR_FS_INC .'xtc_redirect.inc.php');
  require_once(DIR_FS_INC .'xtc_href_link.inc.php');
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


    $firstname = xtc_db_prepare_input($_POST['FIRST_NAME']);
    $lastname = xtc_db_prepare_input($_POST['LAST_NAME']);
	$email_address = xtc_db_prepare_input($_POST['EMAIL_ADRESS']);
	$street_address = xtc_db_prepare_input($_POST['STREET_ADRESS']);
	$postcode = xtc_db_prepare_input($_POST['POST_CODE']);
    $city = xtc_db_prepare_input($_POST['CITY']);
    $zone_id = xtc_db_prepare_input($_POST['zone_id']);
    $state = xtc_db_prepare_input($_POST['STATE']);
	$country = xtc_db_prepare_input($_POST['COUNTRY']);
    $telephone = xtc_db_prepare_input($_POST['TELEPHONE']);
    $password = xtc_db_prepare_input($_POST['PASSWORD']);
    $confirmation = xtc_db_prepare_input($_POST['PASSWORD_CONFIRMATION']);
    $store_name = xtc_db_prepare_input($_POST['STORE_NAME']);
	$email_from = xtc_db_prepare_input($_POST['EMAIL_ADRESS_FROM']);
	$zone_setup = xtc_db_prepare_input($_POST['ZONE_SETUP']);
	$company = xtc_db_prepare_input($_POST['COMPANY']);
		
    $error = false;


    if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_FIRST_NAME_ERROR);
    }

    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_LAST_NAME_ERROR);
    }
	
    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_EMAIL_ADDRESS_ERROR);
    } elseif (xtc_validate_email($email_address) == false) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    } 
    


 if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_STREET_ADDRESS_ERROR);
    }

    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_POST_CODE_ERROR);
    }

    if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_CITY_ERROR);
    }

    if (is_numeric($country) == false) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_COUNTRY_ERROR);
    }

    if (ACCOUNT_STATE == 'true') {
      $zone_id = 0;
      $check_query = xtc_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "'");
      $check = xtc_db_fetch_array($check_query);
      $entry_state_has_zones = ($check['total'] > 0);
      if ($entry_state_has_zones == true) {
        $zone_query = xtc_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' and (zone_name like '" . xtc_db_input($state) . "%' or zone_code like '%" . xtc_db_input($state) . "%')");
        if (xtc_db_num_rows($zone_query) > 0) {
          $zone = xtc_db_fetch_array($zone_query);
          $zone_id = $zone['zone_id'];
        } else {
          $error = true;

          $messageStack->add('install_step6', ENTRY_STATE_ERROR_SELECT);
        }
      } else {
        if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
          $error = true;

          $messageStack->add('install_step6', ENTRY_STATE_ERROR);
        }
      }
    }

    if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_TELEPHONE_NUMBER_ERROR);
    }


    if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_PASSWORD_ERROR);
    } elseif ($password != $confirmation) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
    }
	
	    if (strlen($store_name) < '3') {
      $error = true;

      $messageStack->add('install_step6', ENTRY_STORE_NAME_ERROR);
    }
	if (strlen($company) < '2') {
      $error = true;

      $messageStack->add('install_step6', ENTRY_COMPANY_NAME_ERROR);
    }
	
    if (strlen($email_from) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_EMAIL_ADDRESS_FROM_ERROR);
    } elseif (xtc_validate_email($email_from) == false) {
      $error = true;

      $messageStack->add('install_step6', ENTRY_EMAIL_ADDRESS_FROM_CHECK_ERROR);
    } 
	if ( ($zone_setup != 'yes') && ($zone_setup != 'no') ) {
        $error = true;

        $messageStack->add('install_step6', SELECT_ZONE_SETUP_ERROR);
	}
    
	
	    if ($error == false) {
		
xtc_db_query("insert into " . TABLE_CUSTOMERS . " (
										customers_id,
										customers_status,
										customers_firstname,
										customers_lastname,
										customers_email_address,
										customers_default_address_id,
										customers_telephone,
										customers_password,
										delete_user) VALUES
										('1',
										'0',
										'".$firstname."',
										'".$lastname."',
										'".$email_address."',
										'1',
										'".$telephone."',
										'".xtc_encrypt_password($password)."',
										'0')");

xtc_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (
										customers_info_id,
										customers_info_date_of_last_logon, 
										customers_info_number_of_logons, 
										customers_info_date_account_created,
										customers_info_date_account_last_modified,
										global_product_notifications) VALUES
										('1','','','','','')");
xtc_db_query("insert into " .TABLE_ADDRESS_BOOK . " (
										customers_id,
										entry_company,
   										entry_firstname,
   										entry_lastname,
   										entry_street_address,
   										entry_postcode,
   										entry_city,
   										entry_state,
   										entry_country_id,
   										entry_zone_id) VALUES
										('1',
										'".($company)."',
										'".($firstname)."',
										'".($lastname)."',
										'".($street_address)."',
										'".($postcode)."',
										'".($city)."',
										'".($state)."',
										'".($country)."',
										'".($zone_id)."'
										)");
										
										 
 

xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_address). "' WHERE configuration_key = 'STORE_OWNER_EMAIL_ADDRESS'");
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($store_name). "' WHERE configuration_key = 'STORE_NAME'");
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'EMAIL_FROM'");
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($country). "' WHERE configuration_key = 'SHIPPING_ORIGIN_COUNTRY'");
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($postcode). "' WHERE configuration_key = 'SHIPPING_ORIGIN_ZIP'");
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($company). "' WHERE configuration_key = 'STORE_OWNER'");
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'EMAIL_BILLING_FORWARDING_STRING'");
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'EMAIL_BILLING_ADDRESS'");
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'CONTACT_US_EMAIL_ADDRESS'");
xtc_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'EMAIL_SUPPORT_ADDRESS'");



	      xtc_redirect(xtc_href_link('install/install_step7.php', '', 'NONSSL'));
		}
			
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo TITLE_STEP6; ?></title>
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
<div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="FFAF00">xtc:</font><font color="#999999"><?php echo TEXT_INSTALL; ?></font></b></font></div></td>
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
                <td>&nbsp;</td>
              </tr>
			              <?php
  if ($messageStack->size('install_step6') > 0) {
?>
<tr><td style="border-bottom: 1px solid; border-color: #cccccc;" colspan="3">&nbsp;</td>
<tr><td colspan="3">
             <table border="0" cellpadding="0" cellspacing="0" bgcolor="f3f3f3">
              <tr> 
                <td><?php echo $messageStack->output('install_step6'); ?></td>
              </tr>
            </table>
</td></tr>
            <?php
  }
?>
            </table>
            <br /></td>
        </tr>
      </table>
    </td>
    <td align="right" valign="top" style="border-top: 1px solid; border-bottom: 1px solid; border-right: 1px solid; border-color: #6D6D6D;"> 
      <br />
      <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> <img src="images/title_index.gif" width="586" height="100" border="0"><br />
            <br />
            <br />
            <?php echo TEXT_WELCOME_STEP6; ?></font></td>
        </tr>
      </table> 
      <br />
      <table width="98%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td>
             

             <form name="install" action="install_step6.php" method="post" onSubmit="return check_form(install_step6);">
              <input name="action" type="hidden" value="process">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
                    <?php echo TITLE_ADMIN_CONFIG; ?> </b></font><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                    <b><?php echo TEXT_REQU_INFORMATION; ?></b></font></td>
                  <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
                </tr>
              </table>
			  <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo   TITLE_ADMIN_CONFIG_NOTE; ?></font>
              <table width="100%" border="0">
                <tr> 
                  <td width="26%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo TEXT_FIRSTNAME; ?></strong></font></td>
                  <td width="74%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_input_field_installer('FIRST_NAME'); ?> 
                    <font color="#FF0000">*</font> </font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_LASTNAME; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_input_field_installer('LAST_NAME'); ?> 
                    <font color="#FF0000">*</font> </font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_EMAIL; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_input_field_installer('EMAIL_ADRESS'); ?> 
                    <font color="#FF0000">*<font color="#000000"> </font><strong><?php echo TEXT_EMAIL_LONG; ?></strong></font></font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_STREET; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_input_field_installer('STREET_ADRESS'); ?> 
                    <font color="#FF0000">*</font></font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_POSTCODE; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_input_field_installer('POST_CODE'); ?> 
                    <font color="#FF0000">*</font></font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_CITY; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_input_field_installer('CITY'); ?> 
                    <font color="#FF0000">*</font></font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_COUNTRY; ?></font></strong></td>
                  <td><?php echo xtc_get_country_list('COUNTRY'); ?><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp; 
                    </font><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">*<strong> 
                    <?php echo TEXT_COUNTRY_LONG; ?></strong></font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_TEL; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_input_field_installer('TELEPHONE'); ?> 
                    <font color="#FF0000">*</font></font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_PASSWORD; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_password_field_installer('PASSWORD'); ?>
                    <font color="#FF0000">*</font></font></td>
                </tr>
                <tr> 
                  <td><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_PASSWORD_CONF; ?></font></strong></td>
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo xtc_draw_password_field_installer('PASSWORD_CONFIRMATION'); ?>
                    <font color="#FF0000">*</font></font></td>
                </tr>
              </table>
              <p>&nbsp;</p>
			  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td style="border-bottom: 1px solid; border-color: #CFCFCF"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><img src="images/icons/arrow-setup.jpg" width="16" height="16"> 
                  <?php echo TITLE_SHOP_CONFIG; ?> </b></font><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">
                  <b><?php echo TEXT_REQU_INFORMATION; ?></b></font></td>
                <td style="border-bottom: 1px solid; border-color: #CFCFCF">&nbsp;</td>
              </tr>
            </table>
              <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo  TITLE_SHOP_CONFIG_NOTE; ?></font><br />
              <table width="100%" border="0">
                <tr> 
                  <td width="26%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo  TEXT_STORE; ?></strong></font></td>
                  <td width="74%"><?php echo xtc_draw_input_field_installer('STORE_NAME'); ?><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                    *<font color="#000000"> </font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo  TEXT_STORE_LONG; ?></strong></font></font></td>
                </tr>
                <tr> 
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo  TEXT_COMPANY; ?></strong></font></td>
                  <td><?php echo xtc_draw_input_field_installer('COMPANY'); ?><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                    *<font color="#000000"> </font><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></font><font size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></font></td>
                </tr>
                <tr> 
                  <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo  TEXT_EMAIL_FROM; ?></strong></font></td>
                  <td><?php echo xtc_draw_input_field_installer('EMAIL_ADRESS_FROM'); ?><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                    *<font color="#000000"> </font><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo  TEXT_EMAIL_FROM_LONG; ?></strong></font></font></font></td>
                </tr>
              </table>
              <?php echo xtc_draw_hidden_field_installer('ZONE_SETUP', 'no'); ?>
              <p><br />
              </p>
              <center>
                <input name="image" type="image" src="images/button_continue.gif" alt="<?php echo IMAGE_CONTINUE; ?>" align="middle" border="0">
                <br />
              </center>
            </form></td>
        </tr>
      </table> 
      <p><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/break-el.gif" width="100%" height="1"></font></p>

      <p>&nbsp;</p>
    </td>
  </tr>
</table>



<p align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo TEXT_FOOTER; ?><br />
  </font></p>
<p align="center">&nbsp;</p>
</body>
</html>

</body>
</html>