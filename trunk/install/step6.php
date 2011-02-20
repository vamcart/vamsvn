<?php
  /* --------------------------------------------------------------
   $Id: step6.php 941 2007-02-07 13:12:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (step6.php,v 1.29 2003/08/20); www.nextcommerce.org
   (c) 2004	 xt:Commerce (step6.php,v 1.29 2003/08/20); xt-commerce.com 

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('../includes/configure.php');
  
  require('includes/application.php');
  require_once(DIR_FS_INC.'vam_draw_separator.inc.php');
  
  require_once(DIR_FS_INC . 'vam_rand.inc.php');
  require_once(DIR_FS_INC . 'vam_encrypt_password.inc.php');
  require_once(DIR_FS_INC . 'vam_db_connect.inc.php');
  require_once(DIR_FS_INC . 'vam_db_query.inc.php');
  require_once(DIR_FS_INC . 'vam_db_fetch_array.inc.php');
  require_once(DIR_FS_INC .'vam_validate_email.inc.php');
  require_once(DIR_FS_INC .'vam_db_input.inc.php');
  require_once(DIR_FS_INC .'vam_db_perform.inc.php');
  require_once(DIR_FS_INC .'vam_db_num_rows.inc.php');
  require_once(DIR_FS_INC .'vam_redirect.inc.php');
  require_once(DIR_FS_INC .'vam_href_link.inc.php');
  require_once(DIR_FS_INC . 'vam_draw_pull_down_menu.inc.php');
  require_once(DIR_FS_INC . 'vam_draw_input_field.inc.php');
  require_once(DIR_FS_INC . 'vam_get_country_list.inc.php');

  include_once(DIR_FS_INC . 'vam_draw_pull_down_menu.inc.php');
  include_once(DIR_FS_INC . 'vam_get_countries.inc.php');
  
  if (!function_exists('vam_get_country_list')) { 
  function vam_get_country_list($name, $selected = '', $parameters = '') {
   $countries_array = array(array('id' => '', 'text' => PULL_DOWN_DEFAULT));
//    Probleme mit register_globals=off -> erstmal nur auskommentiert. Kann u.U. gelцscht werden.
    $countries = vam_get_countriesList();

    for ($i=0, $n=sizeof($countries); $i<$n; $i++) {
      $countries_array[] = array('id' => $countries[$i]['countries_id'], 'text' => $countries[$i]['countries_name']);
    }
	if (is_array($name)) return vam_draw_pull_down_menuNote($name, $countries_array, $selected, $parameters);
    return vam_draw_pull_down_menu($name, $countries_array, $selected, $parameters);
  }
  }

    include('language/'.$_SESSION['language'].'.php');
  
  // connect do database
  vam_db_connect() or die('Unable to connect to database server!'); 
    

  
  // get configuration data
  $configuration_query = vam_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
  while ($configuration = vam_db_fetch_array($configuration_query)) {
    define($configuration['cfgKey'], $configuration['cfgValue']);
  }

   $messageStack = new messageStack();
  
    $process = false;
  if (isset($_POST['action']) && (($_POST['action'] == 'process') || ($_POST['action'] == 'refresh'))) {
    if ($_POST['action'] == 'process')  $process = true;


    $firstname = vam_db_prepare_input($_POST['FIRST_NAME']);
    $lastname = vam_db_prepare_input($_POST['LAST_NAME']);
	$email_address = vam_db_prepare_input($_POST['EMAIL_ADRESS']);
	$street_address = vam_db_prepare_input($_POST['STREET_ADRESS']);
	$postcode = vam_db_prepare_input($_POST['POST_CODE']);
    $city = vam_db_prepare_input($_POST['CITY']);
    $zone_id = vam_db_prepare_input($_POST['zone_id']);
    $state = vam_db_prepare_input($_POST['state']);
	$country = vam_db_prepare_input($_POST['country']);
    $telephone = vam_db_prepare_input($_POST['TELEPHONE']);
    $password = vam_db_prepare_input($_POST['PASSWORD']);
    $confirmation = vam_db_prepare_input($_POST['PASSWORD_CONFIRMATION']);
    $store_name = vam_db_prepare_input($_POST['STORE_NAME']);
	$email_from = vam_db_prepare_input($_POST['EMAIL_ADRESS_FROM']);
	$company = vam_db_prepare_input($_POST['COMPANY']);

if ($process) {
		
    $error = false;


    if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('step6', ENTRY_FIRST_NAME_ERROR);
    }

    if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
      $error = true;

      $messageStack->add('step6', ENTRY_LAST_NAME_ERROR);
    }
	
    if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('step6', ENTRY_EMAIL_ADDRESS_ERROR);
    } elseif (vam_validate_email($email_address) == false) {
      $error = true;

      $messageStack->add('step6', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    } 
    


 if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('step6', ENTRY_STREET_ADDRESS_ERROR);
    }

    if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
      $error = true;

      $messageStack->add('step6', ENTRY_POST_CODE_ERROR);
    }

    if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
      $error = true;

      $messageStack->add('step6', ENTRY_CITY_ERROR);
    }

    if (ACCOUNT_COUNTRY == 'true') {
	    if (is_numeric($country) == false) {
      $error = true;

      $messageStack->add('step6', ENTRY_COUNTRY_ERROR);
    }
}

    if (ACCOUNT_STATE == 'true') {
      $zone_id = 0;
      $check_query = vam_db_query("select count(*) as total from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "'");
      $check = vam_db_fetch_array($check_query);
      $entry_state_has_zones = ($check['total'] > 0);
      if ($entry_state_has_zones == true) {
        $zone_query = vam_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' and zone_name = '" . vam_db_input($state) . "'");
        if (vam_db_num_rows($zone_query) == 1) {
          $zone = vam_db_fetch_array($zone_query);
          $zone_id = $zone['zone_id'];
        } else {
          $error = true;

          $messageStack->add('step6', ENTRY_STATE_ERROR_SELECT);
        }
      } else {
        if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
          $error = true;

          $messageStack->add('step6', ENTRY_STATE_ERROR);
        }
      }
    }

    if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
      $error = true;

      $messageStack->add('step6', ENTRY_TELEPHONE_NUMBER_ERROR);
    }


    if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
      $error = true;

      $messageStack->add('step6', ENTRY_PASSWORD_ERROR);
    } elseif ($password != $confirmation) {
      $error = true;

      $messageStack->add('step6', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
    }
	
	    if (strlen($store_name) < '3') {
      $error = true;

      $messageStack->add('step6', ENTRY_STORE_NAME_ERROR);
    }
	if (strlen($company) < '2') {
      $error = true;

      $messageStack->add('step6', ENTRY_COMPANY_NAME_ERROR);
    }
	
    if (strlen($email_from) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
      $error = true;

      $messageStack->add('step6', ENTRY_EMAIL_ADDRESS_FROM_ERROR);
    } elseif (vam_validate_email($email_from) == false) {
      $error = true;

      $messageStack->add('step6', ENTRY_EMAIL_ADDRESS_FROM_CHECK_ERROR);
    } 

	    if ($error == false) {
$customer_query = vam_db_query("select c.customers_id, ci.customers_info_id, ab.customers_id from " . TABLE_CUSTOMERS . " c, " . TABLE_CUSTOMERS_INFO . " ci, " . TABLE_ADDRESS_BOOK . " ab ");
if (vam_db_num_rows($customer_query) >= 1) {
  $db_action = "update";
} else {
    $db_action = "insert";
  }

vam_db_perform(TABLE_CUSTOMERS, array(
              'customers_id' => '1',
              'customers_status' => '0',
              'customers_firstname' => $firstname,
              'customers_lastname' => $lastname,
              'customers_email_address' => $email_address,
              'customers_default_address_id' => '1',
              'customers_telephone' => $telephone,
              'customers_password' => vam_encrypt_password($password),
              'delete_user' => '0',
              'customers_date_added' => 'now()',
              'customers_last_modified' => 'now()',),
              $db_action, 'customers_id = 1'
              );

vam_db_perform(TABLE_CUSTOMERS_INFO, array(
              'customers_info_id' => '1',
              'customers_info_date_of_last_logon' => 'now()',
              'customers_info_number_of_logons' => '0',
              'customers_info_date_account_created' => 'now()',
              'customers_info_date_account_last_modified' => 'now()',
              'global_product_notifications' => '0'),
              $db_action, 'customers_info_id = 1'
              );

vam_db_perform(TABLE_ADDRESS_BOOK, array(
              'customers_id' => '1',
              'entry_company' => ($company),
              'entry_firstname' => ($firstname),
              'entry_lastname' => ($lastname),
              'entry_street_address' => ($street_address),
              'entry_postcode' => ($postcode),
              'entry_city' => ($city),
              'entry_state' => ($state),
              'entry_country_id' => ($country),
              'entry_zone_id' => ((isset($zone_id) ? 0 : $zone_id)),
              'address_date_added' => 'now()',
              'address_last_modified' => 'now()'),
              $db_action, 'customers_id = 1'
              );



vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_address). "' WHERE configuration_key = 'STORE_OWNER_EMAIL_ADDRESS'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($store_name). "' WHERE configuration_key = 'STORE_NAME'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'EMAIL_FROM'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($country). "' WHERE configuration_key = 'SHIPPING_ORIGIN_COUNTRY'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($postcode). "' WHERE configuration_key = 'SHIPPING_ORIGIN_ZIP'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($company). "' WHERE configuration_key = 'STORE_OWNER'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'EMAIL_BILLING_FORWARDING_STRING'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'EMAIL_BILLING_ADDRESS'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'CONTACT_US_EMAIL_ADDRESS'");
vam_db_query("UPDATE " .TABLE_CONFIGURATION . " SET configuration_value='". ($email_from). "' WHERE configuration_key = 'EMAIL_SUPPORT_ADDRESS'");

	      vam_redirect(vam_href_link('install/finished.php', '', 'NONSSL'));
		}
 }

if (!isset($country)) $country = STORE_COUNTRY;
if (!isset($state)) $state = STORE_ZONE;

 }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title><?php echo TITLE_STEP6; ?></title>
<link rel="stylesheet" type="text/css" href="includes/style.css" />
<script language="javascript"><!--
var form = "";
var submitted = false;
var error = false;
var error_message = "";

<?php // +Country-State Selector ?>
function refresh_form(form_name) {
   form_name.action.value = 'refresh';
   form_name.submit();
   return true;
   }
<?php // -Country-State Selector ?>

//--></script>
</head>
<body>


<!-- Контейнер -->
<div id="container">

<!-- Шапка -->
<div id="header">
<img src="images/logo.png" alt="VaM Shop" />
</div>
<!-- /Шапка -->

<div id="menu">
<ul>
<li><a href="step6.php"><span><?php echo START; ?></span></a></li>
<li><a href="step6.php"><span><?php echo STEP1; ?></span></a></li>
<li><a href="step6.php"><span><?php echo STEP2; ?></span></a></li>
<li><a href="step6.php"><span><?php echo STEP3; ?></span></a></li>
<li><a href="step6.php"><span><?php echo STEP4; ?></span></a></li>
<li><a href="step6.php"><span><?php echo STEP5; ?></span></a></li>
<li class="current"><a href="step6.php"><span><?php echo STEP6; ?></span></a></li>
<li><a href="step6.php"><span><?php echo END; ?></span></a></li>
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
<h1><?php echo TITLE_STEP6; ?></h1>
<!-- /Заголовок страницы -->
<!-- Скругленные углы -->
<div class="page">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<!-- Содержимое страницы -->
<div class="pagecontent">

<p>
<?php echo TEXT_WELCOME_STEP6; ?>
</p>

<?php             
if ($messageStack->size('step6') > 0) {
?>
<div class="formerror">
<?php echo $messageStack->output('step6'); ?>
</div>
<?php } ?>

<form name="install" action="step6.php" method="post" onsubmit="return check_form(step6);">
<input name="action" type="hidden" value="process" />

<fieldset class="form">
<legend><?php echo TITLE_ADMIN_CONFIG; ?></legend>
<p><?php echo TEXT_FIRSTNAME; ?>&nbsp;<?php echo vam_draw_input_field_installer('FIRST_NAME'); ?></p>
<p><?php echo TEXT_LASTNAME; ?>&nbsp;<?php echo vam_draw_input_field_installer('LAST_NAME'); ?></p>
<p><?php echo TEXT_EMAIL; ?>&nbsp;<?php echo vam_draw_input_field_installer('EMAIL_ADRESS'); ?></p>
<p><?php echo TEXT_STREET; ?>&nbsp;<?php echo vam_draw_input_field_installer('STREET_ADRESS'); ?>&nbsp;<?php echo ENTRY_STREET_ADDRESS_TEXT; ?></p>
<p><?php echo TEXT_POSTCODE; ?>&nbsp;<?php echo vam_draw_input_field_installer('POST_CODE'); ?></p>
<p><?php echo TEXT_CITY; ?>&nbsp;<?php echo vam_draw_input_field_installer('CITY'); ?></p>
<p><?php echo TEXT_COUNTRY; ?>&nbsp;<?php echo vam_get_country_list('country',STORE_COUNTRY, 'onChange="changeselect();"') . '&nbsp;'; ?></p>
<p><?php echo TEXT_STATE; ?>&nbsp;
<script language="javascript">
<!--
function changeselect(reg) {
//clear select
    document.install.state.length=0;
    var j=0;
    for (var i=0;i<zones.length;i++) {
      if (zones[i][0]==document.install.country.value) {
   document.install.state.options[j]=new Option(zones[i][1],zones[i][1]);
   j++;
   }
      }
    if (j==0) {
      document.install.state.options[0]=new Option('---','---');
      }
    if (reg) { document.install.state.value = reg; }
}
   var zones = new Array(
   <?php
       $zones_query = vam_db_query("select zone_country_id,zone_name from " . TABLE_ZONES . " order by zone_name asc");
       $mas=array();
       while ($zones_values = vam_db_fetch_array($zones_query)) {
         $zones[] = 'new Array('.$zones_values['zone_country_id'].',"'.$zones_values['zone_name'].'")';
       }
       echo implode(',',$zones);
       ?>
       );
document.write('<select name="state">');
document.write('</select>');
changeselect("<?php echo vam_db_prepare_input($_POST['state']); ?>");
-->
</script>
</p>
<p><?php echo TEXT_TEL; ?>&nbsp;<?php echo vam_draw_input_field_installer('TELEPHONE'); ?></p>
<p><?php echo TEXT_PASSWORD; ?>&nbsp;<?php echo vam_draw_password_field_installer('PASSWORD'); ?></p>
<p><?php echo TEXT_PASSWORD_CONF; ?>&nbsp;<?php echo vam_draw_password_field_installer('PASSWORD_CONFIRMATION'); ?></p>
</fieldset>

<fieldset class="form">
<legend><?php echo TITLE_SHOP_CONFIG; ?></legend>
<p><?php echo TEXT_STORE; ?>&nbsp;<?php echo vam_draw_input_field_installer('STORE_NAME'); ?></p>
<p><?php echo TEXT_COMPANY; ?>&nbsp;<?php echo vam_draw_input_field_installer('COMPANY'); ?></p>
<p><?php echo TEXT_EMAIL_FROM; ?>&nbsp;<?php echo vam_draw_input_field_installer('EMAIL_ADRESS_FROM'); ?></p>
</fieldset>

<p>
<input name="image" type="image" src="images/button_continue.gif" alt="<?php echo IMAGE_CONTINUE; ?>" />
</p>

</form>

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