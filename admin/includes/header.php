<?php
/* --------------------------------------------------------------
   $Id: header.php 1025 2005-07-14 11:57:54Z gwinger $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(header.php,v 1.19 2002/04/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (header.php,v 1.17 2003/08/24); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  if ($messageStack->size > 0) {
    echo $messageStack->output();
  }

?>


<script language="javascript" src="external/jscookmenu/JSCookMenu.js"></script>
<link rel="stylesheet" href="external/jscookmenu/ThemeOffice/theme.css" type="text/css">
<script language="javascript" src="external/jscookmenu/ThemeOffice/theme.js"></script>

<!-- шапка -->        
          <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="200" align="left">
              <?php echo xtc_image(DIR_WS_IMAGES . 'logo.gif', 'VaM Shop', '160', '60'); ?>
              </td>
              <td width="470" align="center">
              &nbsp;
              </td>
              <td width="200">
              &nbsp;
              </td>
            </tr>

            <tr>
              <td width="200" align="left">
              &nbsp;
              </td>
              <td width="470" align="center">
<!-- кнопки -->
          <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr class="buttonadmin">
              <td width="5" align="center" valign="top" class="button1">&nbsp;</td>
              <td align="center" valign="top"><img src="images/corners/corner_top_left.gif" width="3" height="3" align="left" hspace="0" /></td>
              <td width="89" align="center" valign="top">
              <div class="buttonadmin"><a class="shippingInfo" href="<?php echo xtc_href_link(FILENAME_DEFAULT, '', 'NONSSL'); ?>"><?php echo TEXT_HEADER_DEFAULT; ?></a></div>              
              </td>
              <td align="center" valign="top"><img src="images/corners/corner_top_right.gif" width="3" height="3" align="right" hspace="0" /></td>
              <td width="5" align="center" valign="top" class="button1">&nbsp;</td>
              <td align="center" valign="top"><img src="images/corners/corner_top_left.gif" width="3" height="3" align="left" hspace="0" /></td>
              <td width="84" align="center" valign="top">
              <div class="buttonadmin"><a class="shippingInfo" href="http://vamshop.ru" target="_blank"><?php echo TEXT_HEADER_SUPPORT; ?></a></div>              
              </td>
              <td align="center" valign="top"><img src="images/corners/corner_top_right.gif" width="3" height="3" align="right" hspace="0" /></td>
              <td width="5" align="center" valign="top" class="button1">&nbsp;</td>
              <td align="center" valign="top"><img src="images/corners/corner_top_left.gif" width="3" height="3" align="left" hspace="0" /></td>
              <td width="98" align="center" valign="top">
              <div class="buttonadmin"><a class="shippingInfo" href="../index.php" target="_blank"><?php echo TEXT_HEADER_SHOP; ?></a></div>              
              </td>
<?php 

# Выбор языка в админке, автор незнама

  if (!isset($lng) && !is_object($lng)) {
    include(DIR_WS_CLASSES . 'language.php');
    $lng = new language;
  }

# dir with images. I dont't use it
# xtc_image(DIR_FS_CATALOG.'lang/' .  $value['directory'] .'/' . $value['image'], $value['name'])

  $languages_string = '';
  $count_lng='';
  reset($lng->catalog_languages);
  while (list($key, $value) = each($lng->catalog_languages)) {
  $count_lng++;
    $languages_string .= '
              <td align="center" valign="top"><img src="images/corners/corner_top_right.gif" width="3" height="3" align="right" hspace="0" /></td>
              <td width="5" align="center" valign="top" class="button1">&nbsp;</td>
              <td align="center" valign="top"><img src="images/corners/corner_top_left.gif" width="3" height="3" align="left" hspace="0" /></td>
              <td width="85" align="center" valign="top">
              <div class="buttonadmin"><a class="shippingInfo" href="' . xtc_href_link(basename($_SERVER["SCRIPT_NAME"]), 'language=' . $key.'&'.xtc_get_all_get_params(array('language', 'currency')), 'NONSSL') . '">' . $value['name'] . '</a></div>              
              </td>
 ';
  }
  
# /Выбор языка в админке, автор незнама
?>
              <?php if ($count_lng > 1 ) { echo $languages_string; } ?>
              <td align="center" valign="top"><img src="images/corners/corner_top_right.gif" width="3" height="3" align="right" hspace="0" /></td>
            </tr>
          </table>
<!-- /кнопки -->

              </td>
              <td width="200">
              &nbsp;
              </td>
            </tr>
<tr>
<td colspan="3" valign="top" align="center" class="buttonadmin"><img src="images/pixel_trans.gif" border="0" alt="" width="0" height="3"></td>
</tr>

<tr>
<td colspan="3" valign="top" align="center" class="navigationTop"><img src="images/pixel_trans.gif" border="0" alt="" width="0" height="1"></td>
</tr>

<tr>
<td colspan="3" valign="top" align="center" class="navigation"><img src="images/pixel_trans.gif" border="0" alt="" width="0" height="4"></td>
</tr>

<tr>
<td colspan="3" class="navigation" align="left" id="administrationMenuID">

<?php

  $admin_access_query = xtc_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . $_SESSION['customer_id'] . "'");
  $admin_access = xtc_db_fetch_array($admin_access_query); 

?>

<div id="administrationMenu">
  <ul style="visibility: hidden">


    <li><span></span><span><?php echo BOX_HEADING_CONFIGURATION; ?></span>
      <ul>
        <?php echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=1', 'NONSSL') . '">' . BOX_HEADING_CONFIGURATION . '</a>' . "\n"; ?>
          <ul>
<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=1', 'NONSSL') . '">' . BOX_CONFIGURATION_1 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=2', 'NONSSL') . '">' . BOX_CONFIGURATION_2 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=3', 'NONSSL') . '">' . BOX_CONFIGURATION_3 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=4', 'NONSSL') . '">' . BOX_CONFIGURATION_4 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=5', 'NONSSL') . '">' . BOX_CONFIGURATION_5 . '</a></li>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=6', 'NONSSL') . '">' . BOX_CONFIGURATION_6 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=7', 'NONSSL') . '">' . BOX_CONFIGURATION_7 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=8', 'NONSSL') . '">' . BOX_CONFIGURATION_8 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=9', 'NONSSL') . '">' . BOX_CONFIGURATION_9 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=10', 'NONSSL') . '">' . BOX_CONFIGURATION_10 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=11', 'NONSSL') . '">' . BOX_CONFIGURATION_11 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=12', 'NONSSL') . '">' . BOX_CONFIGURATION_12 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=13', 'NONSSL') . '">' . BOX_CONFIGURATION_13 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=14', 'NONSSL') . '">' . BOX_CONFIGURATION_14 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=15', 'NONSSL') . '">' . BOX_CONFIGURATION_15 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=16', 'NONSSL') . '">' . BOX_CONFIGURATION_16 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=17', 'NONSSL') . '">' . BOX_CONFIGURATION_17 . '</a></li>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=18', 'NONSSL') . '">' . BOX_CONFIGURATION_18 . '</a></li>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=19', 'NONSSL') . '">' . BOX_CONFIGURATION_19 . '</a></li>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=20', 'NONSSL') . '">' . BOX_CONFIGURATION_20 . '</a></li>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=21', 'NONSSL') . '">' . BOX_CONFIGURATION_21 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=22', 'NONSSL') . '">' . BOX_CONFIGURATION_22 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=23', 'NONSSL') . '">' . BOX_CONFIGURATION_23 . '</a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><span><img src="images/icons/16x16/configure.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=24', 'NONSSL') . '">' . BOX_CONFIGURATION_24 . '</a></li>' . "\n";
?>

          </ul>
        </li>
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['orders_status'] == '1')) echo '<li><span><img src="images/icons/16x16/status.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_ORDERS_STATUS, '', 'NONSSL') . '">' . BOX_ORDERS_STATUS . '</a></li>' . "\n";

  if (ACTIVATE_SHIPPING_STATUS=='true') {
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['shipping_status'] == '1')) echo '<li><span><img src="images/icons/16x16/file_manager.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_SHIPPING_STATUS, '', 'NONSSL') . '">' . BOX_SHIPPING_STATUS . '</a></li>' . "\n";
  }

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_vpe'] == '1')) echo '<li><span><img src="images/icons/16x16/weight.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_PRODUCTS_VPE, '', 'NONSSL') . '">' . BOX_PRODUCTS_VPE . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['campaigns'] == '1')) echo '<li><span><img src="images/icons/16x16/statistics.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CAMPAIGNS, '', 'NONSSL') . '">' . BOX_CAMPAIGNS . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['cross_sell_groups'] == '1')) echo '<li><span><img src="images/icons/16x16/people.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_XSELL_GROUPS, '', 'NONSSL') . '">' . BOX_ORDERS_XSELL_GROUP . '</a></li>' . "\n";
  
?>

      </ul>
    </li>    
<li></li>  

    <li><span></span><span><?php echo BOX_HEADING_CATALOG; ?></span>
      <ul>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['categories'] == '1')) echo '<li><span><img src="images/icons/16x16/folder_red.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CATEGORIES, '', 'NONSSL') . '">' . BOX_CATEGORIES . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['new_attributes'] == '1')) echo '<li><span><img src="images/icons/16x16/products.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_NEW_ATTRIBUTES, '', 'NONSSL') . '">' . BOX_ATTRIBUTES_MANAGER . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_attributes'] == '1')) echo '<li><span><img src="images/icons/16x16/attributes.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '', 'NONSSL') . '">' . BOX_PRODUCTS_ATTRIBUTES . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['manufacturers'] == '1')) echo '<li><span><img src="images/icons/16x16/run.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_MANUFACTURERS, '', 'NONSSL') . '">' . BOX_MANUFACTURERS . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['reviews'] == '1')) echo '<li><span><img src="images/icons/16x16/write.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_REVIEWS, '', 'NONSSL') . '">' . BOX_REVIEWS . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['specials'] == '1')) echo '<li><span><img src="images/icons/16x16/specials.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_SPECIALS, '', 'NONSSL') . '">' . BOX_SPECIALS . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['featured'] == '1')) echo '<li><span><img src="images/icons/16x16/install.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_FEATURED, '', 'NONSSL') . '">' . BOX_FEATURED . '</a></li>' . "\n";

?>

      </ul>
    </li>    
<li></li>

    <li><span></span><span><?php echo BOX_HEADING_MODULES; ?></span>
      <ul>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li><span><img src="images/icons/16x16/payment.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_MODULES, 'set=payment', 'NONSSL') . '">' . BOX_PAYMENT . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li><span><img src="images/icons/16x16/install.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_MODULES, 'set=shipping', 'NONSSL') . '">' . BOX_SHIPPING . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li><span><img src="images/icons/16x16/calculator.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_MODULES, 'set=ordertotal', 'NONSSL') . '">' . BOX_ORDER_TOTAL . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['module_export'] == '1')) echo '<li><span><img src="images/icons/16x16/date.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_MODULE_EXPORT) . '">' . BOX_MODULE_EXPORT . '</a></li>' . "\n";

?>

      </ul>
    </li>    
<li></li>

    <li><span></span><span><?php echo BOX_HEADING_CUSTOMERS; ?></span>
      <ul>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customers'] == '1')) echo '<li><span><img src="images/icons/16x16/people.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CUSTOMERS, '', 'NONSSL') . '">' . BOX_CUSTOMERS . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customers_status'] == '1')) echo '<li><span><img src="images/icons/16x16/date.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CUSTOMERS_STATUS, '', 'NONSSL') . '">' . BOX_CUSTOMERS_STATUS . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['orders'] == '1')) echo '<li><span><img src="images/icons/16x16/orders.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_ORDERS, '', 'NONSSL') . '">' . BOX_ORDERS . '</a></li>' . "\n";

?>

      </ul>
    </li>    
<li></li>

    <li><span></span><span><?php echo BOX_HEADING_LOCATION_AND_TAXES; ?></span>
      <ul>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['countries'] == '1')) echo '<li><span><img src="images/icons/16x16/world.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_COUNTRIES, '', 'NONSSL') . '">' . BOX_COUNTRIES . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['zones'] == '1')) echo '<li><span><img src="images/icons/16x16/remote.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_ZONES, '', 'NONSSL') . '">' . BOX_ZONES . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['geo_zones'] == '1')) echo '<li><span><img src="images/icons/16x16/relationships.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_GEO_ZONES, '', 'NONSSL') . '">' . BOX_GEO_ZONES . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['tax_classes'] == '1')) echo '<li><span><img src="images/icons/16x16/classes.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_TAX_CLASSES, '', 'NONSSL') . '">' . BOX_TAX_CLASSES . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['tax_rates'] == '1')) echo '<li><span><img src="images/icons/16x16/calculator.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_TAX_RATES, '', 'NONSSL') . '">' . BOX_TAX_RATES . '</a></li>' . "\n";

?>

      </ul>
    </li>    
<li></li>

    <li><span></span><span><?php echo BOX_HEADING_LOCALIZATION; ?></span>
      <ul>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['currencies'] == '1')) echo '<li><span><img src="images/icons/16x16/currencies.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CURRENCIES, '', 'NONSSL') . '">' . BOX_CURRENCIES . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['languages'] == '1')) echo '<li><span><img src="images/icons/16x16/locale.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_LANGUAGES, '', 'NONSSL') . '">' . BOX_LANGUAGES . '</a></li>' . "\n";

?>

      </ul>
    </li>    
<li></li>

    <li><span></span><span><?php echo BOX_HEADING_GV_ADMIN; ?></span>
      <ul>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['coupon_admin'] == '1')) echo '<li><span><img src="images/icons/16x16/orders.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_COUPON_ADMIN, '', 'NONSSL') . '">' . BOX_COUPON_ADMIN . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_queue'] == '1')) echo '<li><span><img src="images/icons/16x16/status.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_GV_QUEUE, '', 'NONSSL') . '">' . BOX_GV_ADMIN_QUEUE . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_mail'] == '1')) echo '<li><span><img src="images/icons/16x16/file_manager.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_GV_MAIL, '', 'NONSSL') . '">' . BOX_GV_ADMIN_MAIL . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_sent'] == '1')) echo '<li><span><img src="images/icons/16x16/world.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_GV_SENT, '', 'NONSSL') . '">' . BOX_GV_ADMIN_SENT . '</a></li>' . "\n";

?>

      </ul>
    </li>    
<li></li>

    <li><span></span><span><?php echo BOX_HEADING_STATISTICS; ?></span>
      <ul>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_products_viewed'] == '1')) echo '<li><span><img src="images/icons/16x16/file.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_STATS_PRODUCTS_VIEWED, '', 'NONSSL') . '">' . BOX_PRODUCTS_VIEWED . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_products_purchased'] == '1')) echo '<li><span><img src="images/icons/16x16/modules.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, '', 'NONSSL') . '">' . BOX_PRODUCTS_PURCHASED . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_customers'] == '1')) echo '<li><span><img src="images/icons/16x16/windows.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_STATS_CUSTOMERS, '', 'NONSSL') . '">' . BOX_STATS_CUSTOMERS . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_sales_report'] == '1')) echo '<li><span><img src="images/icons/16x16/people.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_SALES_REPORT, '', 'NONSSL') . '">' . BOX_SALES_REPORT . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_campaigns'] == '1')) echo '<li><span><img src="images/icons/16x16/statistics.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CAMPAIGNS_REPORT, '', 'NONSSL') . '">' . BOX_CAMPAIGNS_REPORT . '</a></li>' . "\n";

?>

      </ul>
    </li>    
<li></li>

    <li><span></span><span><?php echo BOX_HEADING_TOOLS; ?></span>
      <ul>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['backup'] == '1')) echo '<li><span><img src="images/icons/16x16/tape.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_BACKUP) . '">' . BOX_BACKUP . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['content_manager'] == '1')) echo '<li><span><img src="images/icons/16x16/windows.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_CONTENT_MANAGER) . '">' . BOX_CONTENT . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['blacklist'] == '1')) echo '<li><span><img src="images/icons/16x16/log.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_BLACKLIST, '', 'NONSSL') . '">' . BOX_TOOLS_BLACKLIST . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['module_newsletter'] == '1')) echo '<li><span><img src="images/icons/16x16/file_manager.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_MODULE_NEWSLETTER) . '">' . BOX_MODULE_NEWSLETTER . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['banner_manager'] == '1')) echo '<li><span><img src="images/icons/16x16/email_send.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_BANNER_MANAGER) . '">' . BOX_BANNER_MANAGER . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['server_info'] == '1')) echo '<li><span><img src="images/icons/16x16/server_info.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_SERVER_INFO) . '">' . BOX_SERVER_INFO . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['latest_news'] == '1')) echo '<li><span><img src="images/icons/16x16/remote.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_LATEST_NEWS) . '">' . BOX_CATALOG_LATEST_NEWS . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['whos_online'] == '1')) echo '<li><span><img src="images/icons/16x16/statistics.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_WHOS_ONLINE) . '">' . BOX_WHOS_ONLINE . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['easypopulate'] == '1')) echo '<li><span><img src="images/icons/16x16/file.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_EASYPOPULATE, '', 'NONSSL') . '">' . BOX_EASY_POPULATE . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['quick_updates'] == '1')) echo '<li><span><img src="images/icons/16x16/calculator.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_QUICK_UPDATES, '', 'NONSSL') . '">' . BOX_CATALOG_QUICK_UPDATES . '</a></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['recover_cart_sales'] == '1')) echo '<li><span><img src="images/icons/16x16/people.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_RECOVER_CART_SALES) . '">' . BOX_TOOLS_RECOVER_CART . '</a></li>' . "\n";

?>

      </ul>
    </li>    
<li></li>

    <li><span></span><span><?php echo BOX_HEADING_HELP; ?></span>
      <ul>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['languages'] == '1')) echo '<li><span><img src="images/icons/16x16/home.png" border="0" alt=""></span><a href="http://vamshop.ru" target="_blank">' . BOX_SUPPORT_SITE . '</a></li>' . "\n";

?>

      </ul>
    </li>    
<li></li>

    <li><span></span><span><?php echo BOX_HEADING_LOGOFF; ?></span>
      <ul>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['currencies'] == '1')) echo '<li><span><img src="images/icons/16x16/people.png" border="0" alt=""></span><a href="' . xtc_href_link(FILENAME_LOGOUT, '', 'NONSSL') . '">' . BOX_HEADING_LOGOFF . '</a></li>' . "\n";

?>

      </ul>
    </li>    
<li></li>

  </ul>
</div>

<script type="text/javascript"><!--
  cmDrawFromText('administrationMenu', 'hbr', cmThemeOffice, 'ThemeOffice');
//--></script>

</td>
</tr>

<tr>
<td colspan="3" valign="top" align="center" class="navigation"><img src="images/pixel_trans.gif" border="0" alt="" width="0" height="4"></td>
</tr>

<tr>
<td colspan="3" valign="top" align="center" class="navigationTop"><img src="images/pixel_trans.gif" border="0" alt="" width="0" height="1"></td>
</tr>

<tr>
<td colspan="3" valign="top" align="center"><img src="images/pixel_trans.gif" border="0" alt="" width="0" height="10"></td>
</tr>

          </table>
<!-- /шапка -->
