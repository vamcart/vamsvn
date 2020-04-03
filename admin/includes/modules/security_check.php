<?php
/* --------------------------------------------------------------
   $Id: security_check.php 1221 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (security_check.php,v 1.2 2003/08/23); www.nextcommerce.org
   (c) 2004 xt:Commerce (security_check.php,v 1.2 2003/08/23); xt-commerce.com
   
   Released under the GNU General Public License
   --------------------------------------------------------------*/
defined('_VALID_VAM') or die('Direct Access to this location is not allowed.');

$file_warning = '';
$demo_warning = '';

//if (!strpos(decoct(fileperms(DIR_FS_CATALOG.'includes/configure.php')), '444')) {
//	$file_warning .= '<br>'.DIR_FS_CATALOG.'includes/configure.php';
//}

//if (!strpos(decoct(fileperms(DIR_FS_CATALOG.'includes/configure.org.php')), '444')) {
//	$file_warning .= '<br>'.DIR_FS_CATALOG.'includes/configure.org.php';
//}

//if (!strpos(decoct(fileperms(DIR_FS_ADMIN.'includes/configure.php')), '444')) {
//	$file_warning .= '<br>'.DIR_FS_ADMIN.'includes/configure.php';
//}

//if (!strpos(decoct(fileperms(DIR_FS_ADMIN.'includes/configure.org.php')), '444')) {
//	$file_warning .= '<br>'.DIR_FS_ADMIN.'includes/configure.org.php';
//}

if (!strpos(decoct(fileperms(DIR_FS_CATALOG.'cache/')), '777') and !strpos(decoct(fileperms(DIR_FS_CATALOG.'cache/')), '755')) {
	$folder_warning .= '<br>'.DIR_FS_CATALOG.'cache/';
}

if (!strpos(decoct(fileperms(DIR_FS_CATALOG.'media/')), '777') and !strpos(decoct(fileperms(DIR_FS_CATALOG.'media/')), '755')) {
	$folder_warning .= '<br>'.DIR_FS_CATALOG.'media/';
}

if (!strpos(decoct(fileperms(DIR_FS_CATALOG.'media/content/')), '777') and !strpos(decoct(fileperms(DIR_FS_CATALOG.'media/content/')), '755')) {
	$folder_warning .= '<br>'.DIR_FS_CATALOG.'media/content/';
}

	$payment_query = vam_db_query("SELECT *
				FROM ".TABLE_CONFIGURATION."
				WHERE configuration_key = 'MODULE_PAYMENT_INSTALLED'");
	while ($payment_data = vam_db_fetch_array($payment_query)) {
		$installed_payment = $payment_data['configuration_value'];

	}

	$shipping_query = vam_db_query("SELECT *
				FROM ".TABLE_CONFIGURATION."
				WHERE configuration_key = 'MODULE_SHIPPING_INSTALLED'");
	while ($shipping_data = vam_db_fetch_array($shipping_query)) {
		$installed_shipping = $shipping_data['configuration_value'];

	}

if (SEND_EMAILS != 'true') {
	$demo_warning = WARNING_VAMSHOP_DEMO.'<br />';
}

if ($file_warning != '' or $folder_warning != '' or $installed_shipping == '' or $installed_payment == '' or $demo_warning != '') {
?>


<div class="notification">
              <?php

	if ($file_warning != '') {

		echo TEXT_FILE_WARNING;

		echo '<b>'.$file_warning.'</b><br>';
	}

	if ($demo_warning != '') {

		echo '<br />';

		echo '<b>'.$demo_warning.'</b>';
	}
	
	if ($folder_warning != '') {

		echo TEXT_FOLDER_WARNING;

		echo '<b>'.$folder_warning.'</b>';
	}

	if ($installed_payment == '') {
		echo '<br>'.TEXT_PAYMENT_ERROR;
	}

	if ($installed_shipping == '') {
		echo '<br>'.TEXT_SHIPPING_ERROR;
	}
?>
<br />
</div>
<?php

}
?>

