<?php
/* --------------------------------------------------------------
   $Id: configuration.php 1125 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.40 2002/12/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/19); www.nextcommerce.org
   (c) 2004	 xt:Commerce (configuration.php,v 1.16 2003/08/19); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'save':

          $configuration_query = vam_db_query("select configuration_key,configuration_id, configuration_value, use_function,set_function from " . TABLE_CONFIGURATION . " where configuration_group_id = '" . (int)$_GET['gID'] . "' order by sort_order");

          while ($configuration = vam_db_fetch_array($configuration_query))
              vam_db_query("UPDATE ".TABLE_CONFIGURATION." SET configuration_value='".$_POST[$configuration['configuration_key']]."' where configuration_key='".$configuration['configuration_key']."'");

               vam_redirect(FILENAME_CONFIGURATION. '?gID=' . (int)$_GET['gID']);
        break;

    }
  }

  $cfg_group_query = vam_db_query("select configuration_group_key from " . TABLE_CONFIGURATION_GROUP . " where configuration_group_id = '" . (int)$_GET['gID'] . "'");
  $cfg_group = vam_db_fetch_array($cfg_group_query);
  
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'false') { ?>
    <td width="<?php echo BOX_WIDTH; ?>" align="left" valign="top">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </td>
<?php } ?>
<!-- body_text //-->
    <td class="boxCenter" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td class="main">
        
    <h1 class="contentBoxHeading"><?php echo BOX_CONFIGURATION . ' - ' . constant(strtoupper($cfg_group['configuration_group_key'].'_TITLE')); ?></h1>
            
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
         
          <tr>
            <td valign="top" align="right">
            
<?php echo vam_draw_form('configuration', FILENAME_CONFIGURATION, 'gID=' . (int)$_GET['gID'] . '&action=save', 'post', 'enctype="multipart/form-data" cf="true"'); ?>
            <table width="100%"  border="0" cellspacing="0" cellpadding="4">
<?php
  $configuration_query = vam_db_query("select configuration_key,configuration_id, configuration_value, use_function,set_function from " . TABLE_CONFIGURATION . " where configuration_group_id = '" . (int)$_GET['gID'] . "' order by sort_order");

	$rows = 0;
  while ($configuration = vam_db_fetch_array($configuration_query)) {
	$rows++;

        if (($rows/2) == floor($rows/2)) {
          $class = "even";
        } else {
          $class = "odd";
        }	
	  	
    if ($_GET['gID'] == 6) {
      switch ($configuration['configuration_key']) {
        case 'MODULE_PAYMENT_INSTALLED':
          if ($configuration['configuration_value'] != '') {
            $payment_installed = explode(';', $configuration['configuration_value']);
            for ($i = 0, $n = sizeof($payment_installed); $i < $n; $i++) {
              include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/payment/' . $payment_installed[$i]);
            }
          }
          break;

        case 'MODULE_SHIPPING_INSTALLED':
          if ($configuration['configuration_value'] != '') {
            $shipping_installed = explode(';', $configuration['configuration_value']);
            for ($i = 0, $n = sizeof($shipping_installed); $i < $n; $i++) {
              include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/shipping/' . $shipping_installed[$i]);			
            }
          }
          break;

        case 'MODULE_ORDER_TOTAL_INSTALLED':
          if ($configuration['configuration_value'] != '') {
            $ot_installed = explode(';', $configuration['configuration_value']);
            for ($i = 0, $n = sizeof($ot_installed); $i < $n; $i++) {
              include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/order_total/' . $ot_installed[$i]);			
            }
          }
          break;
      }
    }
    if (vam_not_null($configuration['use_function'])) {
      $use_function = $configuration['use_function'];
      if (preg_match('/->/', $use_function)) {
        $class_method = explode('->', $use_function);
        if (!is_object(${$class_method[0]})) {
          include(DIR_WS_CLASSES . $class_method[0] . '.php');
          ${$class_method[0]} = new $class_method[0]();
        }
        $cfgValue = vam_call_function($class_method[1], $configuration['configuration_value'], ${$class_method[0]});
      } else {
        $cfgValue = vam_call_function($use_function, $configuration['configuration_value']);
      }
    } else {
      $cfgValue = $configuration['configuration_value'];
    }

    if (((!$_GET['cID']) || (@$_GET['cID'] == $configuration['configuration_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $cfg_extra_query = vam_db_query("select configuration_key,configuration_value, date_added, last_modified, use_function, set_function from " . TABLE_CONFIGURATION . " where configuration_id = '" . $configuration['configuration_id'] . "'");
      $cfg_extra = vam_db_fetch_array($cfg_extra_query);

      $cInfo_array = vam_array_merge($configuration, $cfg_extra);
      $cInfo = new objectInfo($cInfo_array);
    }
    if ($configuration['set_function']) {
        eval('$value_field = ' . $configuration['set_function'] . '"' . htmlspecialchars($configuration['configuration_value']) . '");');
      } else {
        $value_field = vam_draw_input_field($configuration['configuration_key'], $configuration['configuration_value'],'size=40');
      }
   // add

   if (strstr($value_field,'configuration_value')) $value_field=str_replace('configuration_value',$configuration['configuration_key'],$value_field);

   echo '
  <tr>
    <td width="300" align="left" valign="top" class="dataTableContent-'.$class.'">'.constant(strtoupper($configuration['configuration_key'].'_TITLE')).' <a class="tooltip" title="'.constant(strtoupper( $configuration['configuration_key'].'_DESC')).'" href="#">' . vam_image(DIR_WS_IMAGES . 'icons/help.jpg') . '</a></td>
    <td valign="top" class="dataTableContent-'.$class.'">
    <table width="100%"  border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td class="main">'.$value_field.'</td>
      </tr>
    </table>
</td>
  </tr>
  ';

  }
?>
            </table>
<?php echo '<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span>'; ?></form>
            </td>

          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>