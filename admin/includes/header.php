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

<script type="text/javascript">
<!--

<?php
  $admin_access_query = xtc_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . $_SESSION['customer_id'] . "'");
  $admin_access = xtc_db_fetch_array($admin_access_query); 

  echo 'var administrationMenu =' . "\n" .
       '[' . "\n";

if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customers_status'] == '1')) {
    echo '    [null, \'' . addslashes(BOX_HEADING_CONFIGURATION) . '\', null, null, null,' . "\n" .
            '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_1) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=1', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_2) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=2', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_3) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=3', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_4) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=4', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_5) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=5', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_7) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=7', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_8) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=8', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_9) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=9', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_10) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=10', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_11) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=11', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_12) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=12', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_13) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=13', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_14) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=14', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_15) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=15', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_16) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=16', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_17) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=17', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_18) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=18', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_19) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=19', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_22) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=22', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_23) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=23', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/configure.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONFIGURATION_24) . '\', \'' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=24', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/status.png', '', '16', '16') . '\', \'' . addslashes(BOX_ORDERS_STATUS) . '\', \'' . xtc_href_link(FILENAME_ORDERS_STATUS, '', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/file_manager.png', '', '16', '16') . '\', \'' . addslashes(BOX_SHIPPING_STATUS) . '\', \'' . xtc_href_link(FILENAME_SHIPPING_STATUS, '', 'NONSSL') . '\', null, null],' . "\n";

      echo '        [\'' . xtc_image('images/icons/16x16/weight.png', '', '16', '16') . '\', \'' . addslashes(BOX_PRODUCTS_VPE) . '\', \'' . xtc_href_link(FILENAME_PRODUCTS_VPE, '', 'NONSSL') . '\', null, null],' . "\n";

    echo '        [\'' . xtc_image('images/icons/16x16/statistics.png', '', '16', '16') . '\', \'' . addslashes(BOX_CAMPAIGNS) . '\', \'' . xtc_href_link(FILENAME_CAMPAIGNS, '', 'NONSSL') . '\', null, null],' . "\n" .

         '        [\'' . xtc_image('images/icons/16x16/people.png', '', '16', '16') . '\', \'' . addslashes(BOX_ORDERS_XSELL_GROUP) . '\', \'' . xtc_href_link(FILENAME_XSELL_GROUPS, '', 'NONSSL') . '\', null, null]' . "\n" .
         '    ],' . "\n" .
         '    _cmSplit,' . "\n" .
         '    [null, \'' . addslashes(BOX_HEADING_CATALOG) . '\', null, null, null,' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/folder_red.png', '', '16', '16') . '\', \'' . addslashes(BOX_CATEGORIES) . '\', \'' . xtc_href_link(FILENAME_CATEGORIES, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/products.png', '', '16', '16') . '\', \'' . addslashes(BOX_ATTRIBUTES_MANAGER) . '\', \'' . xtc_href_link(FILENAME_NEW_ATTRIBUTES, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/attributes.png', '', '16', '16') . '\', \'' . addslashes(BOX_PRODUCTS_ATTRIBUTES) . '\', \'' . xtc_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '', 'NONSSL') . '\', \'\', null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/run.png', '', '16', '16') . '\', \'' . addslashes(BOX_MANUFACTURERS) . '\', \'' . xtc_href_link(FILENAME_MANUFACTURERS, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/write.png', '', '16', '16') . '\', \'' . addslashes(BOX_REVIEWS) . '\', \'' . xtc_href_link(FILENAME_REVIEWS, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/specials.png', '', '16', '16') . '\', \'' . addslashes(BOX_SPECIALS) . '\', \'' . xtc_href_link(FILENAME_SPECIALS, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/install.png', '', '16', '16') . '\', \'' . addslashes(BOX_FEATURED) . '\', \'' . xtc_href_link(FILENAME_FEATURED, '', 'NONSSL') . '\', null, null],' . "\n" .
         '    ],' . "\n" .
         '    _cmSplit,' . "\n" .
         '    [null, \'' . addslashes(BOX_HEADING_MODULES) . '\', null, null, null,' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/payment.png', '', '16', '16') . '\', \'' . addslashes(BOX_PAYMENT) . '\', \'' . xtc_href_link(FILENAME_MODULES, 'set=payment', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/install.png', '', '16', '16') . '\', \'' . addslashes(BOX_SHIPPING) . '\', \'' . xtc_href_link(FILENAME_MODULES, 'set=shipping', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/calculator.png', '', '16', '16') . '\', \'' . addslashes(BOX_ORDER_TOTAL) . '\', \'' . xtc_href_link(FILENAME_MODULES, 'set=ordertotal', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/date.png', '', '16', '16') . '\', \'' . addslashes(BOX_MODULE_EXPORT) . '\', \'' . xtc_href_link(FILENAME_MODULE_EXPORT) . '\', null, null]' . "\n" .
         '    ],' . "\n" .
         '    _cmSplit,' . "\n" .
         '    [null, \'' . addslashes(BOX_HEADING_CUSTOMERS) . '\', null, null, null,' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/people.png', '', '16', '16') . '\', \'' . addslashes(BOX_CUSTOMERS) . '\', \'' . xtc_href_link(FILENAME_CUSTOMERS, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/date.png', '', '16', '16') . '\', \'' . addslashes(BOX_CUSTOMERS_STATUS) . '\', \'' . xtc_href_link(FILENAME_CUSTOMERS_STATUS, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/orders.png', '', '16', '16') . '\', \'' . addslashes(BOX_ORDERS) . '\', \'' . xtc_href_link(FILENAME_ORDERS, '', 'NONSSL') . '\', null, null]' . "\n" .
         '    ],' . "\n" .
         '    _cmSplit,' . "\n" .
         '    [null, \'' . addslashes(BOX_HEADING_LOCATION_AND_TAXES) . '\', null, null, null,' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/world.png', '', '16', '16') . '\', \'' . addslashes(BOX_COUNTRIES) . '\', \'' . xtc_href_link(FILENAME_COUNTRIES, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/remote.png', '', '16', '16') . '\', \'' . addslashes(BOX_ZONES) . '\', \'' . xtc_href_link(FILENAME_ZONES, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/relationships.png', '', '16', '16') . '\', \'' . addslashes(BOX_GEO_ZONES) . '\', \'' . xtc_href_link(FILENAME_GEO_ZONES, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/classes.png', '', '16', '16') . '\', \'' . addslashes(BOX_TAX_CLASSES) . '\', \'' . xtc_href_link(FILENAME_TAX_CLASSES, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/calculator.png', '', '16', '16') . '\', \'' . addslashes(BOX_TAX_RATES) . '\', \'' . xtc_href_link(FILENAME_TAX_RATES, '', 'NONSSL') . '\', null, null],' . "\n" .
         '    ],' . "\n" .
         '    _cmSplit,' . "\n" .
         '    [null, \'' . addslashes(BOX_HEADING_LOCALIZATION) . '\', null, null, null,' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/currencies.png', '', '16', '16') . '\', \'' . addslashes(BOX_CURRENCIES) . '\', \'' . xtc_href_link(FILENAME_CURRENCIES, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/locale.png', '', '16', '16') . '\', \'' . addslashes(BOX_LANGUAGES) . '\', \'' . xtc_href_link(FILENAME_LANGUAGES, '', 'NONSSL') . '\', null, null],' . "\n" .
         '    ],' . "\n" .
         '    _cmSplit,' . "\n" .
         '    [null, \'' . addslashes(BOX_HEADING_STATISTICS) . '\', null, null, null,' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/file.png', '', '16', '16') . '\', \'' . addslashes(BOX_PRODUCTS_VIEWED) . '\', \'' . xtc_href_link(FILENAME_STATS_PRODUCTS_VIEWED, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/modules.png', '', '16', '16') . '\', \'' . addslashes(BOX_PRODUCTS_PURCHASED) . '\', \'' . xtc_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/windows.png', '', '16', '16') . '\', \'' . addslashes(BOX_STATS_CUSTOMERS) . '\', \'' . xtc_href_link(FILENAME_STATS_CUSTOMERS, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/people.png', '', '16', '16') . '\', \'' . addslashes(BOX_SALES_REPORT) . '\', \'' . xtc_href_link(FILENAME_SALES_REPORT, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/statistics.png', '', '16', '16') . '\', \'' . addslashes(BOX_CAMPAIGNS_REPORT) . '\', \'' . xtc_href_link(FILENAME_CAMPAIGNS_REPORT, '', 'NONSSL') . '\', null, null],' . "\n" .
         '    ],' . "\n" .
         '    _cmSplit,' . "\n" .
         '    [null, \'' . addslashes(BOX_HEADING_TOOLS) . '\', null, null, null,' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/tape.png', '', '16', '16') . '\', \'' . addslashes(BOX_BACKUP) . '\', \'' . xtc_href_link(FILENAME_BACKUP) . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/windows.png', '', '16', '16') . '\', \'' . addslashes(BOX_CONTENT) . '\', \'' . xtc_href_link(FILENAME_CONTENT_MANAGER) . '\', \'\', null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/log.png', '', '16', '16') . '\', \'' . addslashes(BOX_TOOLS_BLACKLIST) . '\', \'' . xtc_href_link(FILENAME_BLACKLIST, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/file_manager.png', '', '16', '16') . '\', \'' . addslashes(BOX_MODULE_NEWSLETTER) . '\', \'' . xtc_href_link(FILENAME_MODULE_NEWSLETTER) . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/email_send.png', '', '16', '16') . '\', \'' . addslashes(BOX_BANNER_MANAGER) . '\', \'' . xtc_href_link(FILENAME_BANNER_MANAGER) . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/server_info.png', '', '16', '16') . '\', \'' . addslashes(BOX_SERVER_INFO) . '\', \'' . xtc_href_link(FILENAME_SERVER_INFO) . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/remote.png', '', '16', '16') . '\', \'' . addslashes(BOX_CATALOG_LATEST_NEWS) . '\', \'' . xtc_href_link(FILENAME_LATEST_NEWS) . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/statistics.png', '', '16', '16') . '\', \'' . addslashes(BOX_WHOS_ONLINE) . '\', \'' . xtc_href_link(FILENAME_WHOS_ONLINE) . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/file.png', '', '16', '16') . '\', \'' . addslashes(BOX_EASY_POPULATE) . '\', \'' . xtc_href_link(FILENAME_EASYPOPULATE, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/calculator.png', '', '16', '16') . '\', \'' . addslashes(BOX_CATALOG_QUICK_UPDATES) . '\', \'' . xtc_href_link(FILENAME_QUICK_UPDATES, '', 'NONSSL') . '\', null, null],' . "\n" .
         '        [\'' . xtc_image('images/icons/16x16/people.png', '', '16', '16') . '\', \'' . addslashes(BOX_TOOLS_RECOVER_CART) . '\', \'' . xtc_href_link(FILENAME_RECOVER_CART_SALES) . '\', null, null]' . "\n" .
         '    ],' . "\n" .
         '    _cmSplit,' . "\n";
  }

  echo '    [null, \'' . addslashes(BOX_HEADING_HELP) . '\', null, null, null,' . "\n" .
       '        [\'' . xtc_image('images/icons/16x16/home.png', '', '16', '16') . '\', \'' . addslashes(BOX_SUPPORT_SITE) . '\', \'http://oscommerce.su\', \'_blank\', null],' . "\n" .
       '    ]' . "\n";

if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customers_status'] == '1')) {
    echo ',    _cmSplit,' . "\n" .
         '    [null, \'' . addslashes(BOX_HEADING_LOGOFF) . '\', \'' . xtc_href_link(FILENAME_LOGOUT, '', 'NONSSL') . '\', \'\', null]' . "\n";
  }

  echo '];' . "\n";
?>

//-->
</script>

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

<!-- шапка -->        
          <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="200" align="left">
              <?php echo xtc_image(DIR_WS_IMAGES . 'logo.gif', 'VaM Shop', '185', '95'); ?>
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
              <div class="buttonadmin"><a class="shippingInfo" href="http://oscommerce.su" target="_blank"><?php echo TEXT_HEADER_SUPPORT; ?></a></div>              
              </td>
              <td align="center" valign="top"><img src="images/corners/corner_top_right.gif" width="3" height="3" align="right" hspace="0" /></td>
              <td width="5" align="center" valign="top" class="button1">&nbsp;</td>
              <td align="center" valign="top"><img src="images/corners/corner_top_left.gif" width="3" height="3" align="left" hspace="0" /></td>
              <td width="98" align="center" valign="top">
              <div class="buttonadmin"><a class="shippingInfo" href="../index.php" target="_blank"><?php echo TEXT_HEADER_SHOP; ?></a></div>              
              </td>
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
<script type="text/javascript"><!--
  cmDraw('administrationMenuID', administrationMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
--></script>
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
