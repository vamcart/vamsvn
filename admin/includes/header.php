<?php
/* --------------------------------------------------------------
   $Id: header.php 1025 2007-05-23 12:09:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(header.php,v 1.19 2002/04/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (header.php,v 1.17 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (header.php,v 1.17 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  if ($messageStack->size > 0) {
    echo $messageStack->output();
  }

?>

<!--[if lte IE 6]>
		<script type="text/javascript" src="../jscript/jquery/jquery.js"></script>
		<script type="text/javascript" src="../jscript/jquery/plugins/bgiframe.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$(".nav")
			.find(">li:has(ul)")
				.mouseover(function(){
					$("ul", this).bgIframe({opacity:false});
				})
				.find("a")
					.focus(function(){
						$("ul", $(".nav>li:has(ul)")).bgIframe({opacity:false});
					});
		});
		</script>
<![endif]-->

<!-- шапка -->        
          <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="200" align="left">
              <?php echo vam_image(DIR_WS_IMAGES . 'logo.gif', 'VaM Shop', '160', '60'); ?>
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
              <div class="buttonadmin"><a class="shippingInfo" href="<?php echo vam_href_link(FILENAME_DEFAULT, '', 'NONSSL'); ?>"><?php echo TEXT_HEADER_DEFAULT; ?></a></div>              
              </td>
              <td align="center" valign="top"><img src="images/corners/corner_top_right.gif" width="3" height="3" align="right" hspace="0" /></td>
              <td width="5" align="center" valign="top" class="button1">&nbsp;</td>
              <td align="center" valign="top"><img src="images/corners/corner_top_left.gif" width="3" height="3" align="left" hspace="0" /></td>
              <td width="84" align="center" valign="top">
              <div class="buttonadmin"><a class="shippingInfo" href="../index.php" target="_blank"><?php echo TEXT_HEADER_SHOP; ?></a></div>              
              </td>
              <td align="center" valign="top"><img src="images/corners/corner_top_right.gif" width="3" height="3" align="right" hspace="0" /></td>
              <td width="5" align="center" valign="top" class="button1">&nbsp;</td>
              <td align="center" valign="top"><img src="images/corners/corner_top_left.gif" width="3" height="3" align="left" hspace="0" /></td>
              <td width="98" align="center" valign="top">
              <div class="buttonadmin"><a class="shippingInfo" href="../logoff.php"><?php echo BOX_HEADING_LOGOFF; ?></a></div>              
              </td>
              <td align="center" valign="top"><img src="images/corners/corner_top_right.gif" width="3" height="3" align="right" hspace="0" /></td>
            </tr>
          </table>
<!-- /кнопки -->

              </td>
              <td width="200">
              &nbsp;
              </td>
            </tr>
</table>

<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'true') { ?>

<div id="menu">

<?php

  $admin_access_query = vam_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . $_SESSION['customer_id'] . "'");
  $admin_access = vam_db_fetch_array($admin_access_query); 

?>

<ul class="nav" id="nav">

<!-- Настройки -->

<li><a href="<?php echo vam_href_link(FILENAME_CONFIGURATION, 'gID=1', 'NONSSL'); ?>"><span><?php echo BOX_HEADING_CONFIGURATION; ?></span><!--[if gte IE 7]><!--></a><!--<![endif]-->
	<!--[if	lte	IE 6]><table><tr><td><![endif]-->
	<ul>
	<li class="pad1"><b class="p7"></b><b class="p3"></b></li>
	<li><a class="fly" href="<?php echo vam_href_link(FILENAME_CONFIGURATION, 'gID=1', 'NONSSL'); ?>"><?php echo BOX_HEADING_CONFIGURATION_MAIN; ?><!--[if gte IE 7]><!--></a><b class="p4"></b><!--<![endif]-->
	<!--[if	lte	IE 6]><table><tr><td><![endif]-->

		<ul>
			<li class="pad1"><b class="p7"></b><b class="p3"></b></li>

<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=1', 'NONSSL') . '">' . BOX_CONFIGURATION_1 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=2', 'NONSSL') . '">' . BOX_CONFIGURATION_2 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=3', 'NONSSL') . '">' . BOX_CONFIGURATION_3 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=4', 'NONSSL') . '">' . BOX_CONFIGURATION_4 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=5', 'NONSSL') . '">' . BOX_CONFIGURATION_5 . '</a><b class="p4"></b></li>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=6', 'NONSSL') . '">' . BOX_CONFIGURATION_6 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=7', 'NONSSL') . '">' . BOX_CONFIGURATION_7 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=8', 'NONSSL') . '">' . BOX_CONFIGURATION_8 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=9', 'NONSSL') . '">' . BOX_CONFIGURATION_9 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=10', 'NONSSL') . '">' . BOX_CONFIGURATION_10 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=11', 'NONSSL') . '">' . BOX_CONFIGURATION_11 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['cache'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CACHE, '', 'NONSSL') . '">' . BOX_CACHE_FILES . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=12', 'NONSSL') . '">' . BOX_CONFIGURATION_12 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=13', 'NONSSL') . '">' . BOX_CONFIGURATION_13 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=14', 'NONSSL') . '">' . BOX_CONFIGURATION_14 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=15', 'NONSSL') . '">' . BOX_CONFIGURATION_15 . '</a><b class="p4"></b></li>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=18', 'NONSSL') . '">' . BOX_CONFIGURATION_18 . '</a><b class="p4"></b></li>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=20', 'NONSSL') . '">' . BOX_CONFIGURATION_20 . '</a><b class="p4"></b></li>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=21', 'NONSSL') . '">' . BOX_CONFIGURATION_21 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=22', 'NONSSL') . '">' . BOX_CONFIGURATION_22 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=24', 'NONSSL') . '">' . BOX_CONFIGURATION_24 . '</a><b class="p4"></b></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['configuration'] == '0')
 ) echo '<li><a href="#"></a><b class="p4"></b></li>'; 

?>

			<li class="pad2"><b class="p5"></b><b class="p6"></b></li>
		</ul>
	<!--[if	lte	IE 6]></td></tr></table></a><b class="p4"></b><![endif]-->
	</li>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['orders_status'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_ORDERS_STATUS, '', 'NONSSL') . '">' . BOX_ORDERS_STATUS . '</a><b class="p4"></b></li>' . "\n";
  if (ACTIVATE_SHIPPING_STATUS=='true') {
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['shipping_status'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_SHIPPING_STATUS, '', 'NONSSL') . '">' . BOX_SHIPPING_STATUS . '</a><b class="p4"></b></li>' . "\n";
  }
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_vpe'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_PRODUCTS_VPE, '', 'NONSSL') . '">' . BOX_PRODUCTS_VPE . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['campaigns'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CAMPAIGNS, '', 'NONSSL') . '">' . BOX_CAMPAIGNS . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['cross_sell_groups'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_XSELL_GROUPS, '', 'NONSSL') . '">' . BOX_ORDERS_XSELL_GROUP . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=19', 'NONSSL') . '">' . BOX_CONFIGURATION_19 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=23', 'NONSSL') . '">' . BOX_CONFIGURATION_23 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=25', 'NONSSL') . '">' . BOX_CONFIGURATION_25 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=27', 'NONSSL') . '">' . BOX_CONFIGURATION_27 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=17', 'NONSSL') . '">' . BOX_CONFIGURATION_17 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=16', 'NONSSL') . '">' . BOX_CONFIGURATION_16 . '</a><b class="p4"></b></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['orders_status'] == '0') && 
 ($admin_access['shipping_status'] == '0') && 
 ($admin_access['products_vpe'] == '0') && 
 ($admin_access['campaigns'] == '0') && 
 ($admin_access['configuration'] == '0') && 
 ($admin_access['cross_sell_groups'] == '0')
 ) echo '<li><a href="#"></a><b class="p4"></b></li>'; 
  
?>

	<li class="pad2"><b class="p5"></b><b class="p6"></b></li>
	</ul>
	<!--[if	lte	IE 6]></td></tr></table></a><![endif]-->
</li>

<!-- /Настройки -->

<!-- Каталог -->

<li><a href="<?php vam_href_link(FILENAME_CATEGORIES, '', 'NONSSL'); ?>"><span><?php echo BOX_HEADING_CATALOG; ?></span><!--[if gte IE 7]><!--></a><!--<![endif]-->
	<!--[if	lte	IE 6]><table><tr><td><![endif]-->
	<ul>
	<li class="pad1"><b class="p7"></b><b class="p3"></b></li>

<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['categories'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CATEGORIES, '', 'NONSSL') . '">' . BOX_CATEGORIES . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_options'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, '', 'NONSSL') . '">' . BOX_PRODUCTS_OPTIONS . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_attributes'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '', 'NONSSL') . '">' . BOX_PRODUCTS_ATTRIBUTES . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['new_attributes'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_NEW_ATTRIBUTES, '', 'NONSSL') . '">' . BOX_ATTRIBUTES_MANAGER . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['manufacturers'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_MANUFACTURERS, '', 'NONSSL') . '">' . BOX_MANUFACTURERS . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['reviews'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_REVIEWS, '', 'NONSSL') . '">' . BOX_REVIEWS . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['specials'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_SPECIALS, '', 'NONSSL') . '">' . BOX_SPECIALS . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['featured'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_FEATURED, '', 'NONSSL') . '">' . BOX_FEATURED . '</a><b class="p4"></b></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['categories'] == '0') && 
 ($admin_access['products_options'] == '0') && 
 ($admin_access['products_attributes'] == '0') && 
 ($admin_access['new_attributes'] == '0') && 
 ($admin_access['manufacturers'] == '0') && 
 ($admin_access['reviews'] == '0') && 
 ($admin_access['specials'] == '0') && 
 ($admin_access['featured'] == '0')
 ) echo '<li><a href="#"></a><b class="p4"></b></li>'; 

?>

	<li class="pad2"><b class="p5"></b><b class="p6"></b></li>
	</ul>
	<!--[if	lte	IE 6]></td></tr></table></a><![endif]-->
</li>

<!-- /Каталог -->

<!-- Покупатели -->

<li><a href="<?php vam_href_link(FILENAME_ORDERS, '', 'NONSSL'); ?>"><span><?php echo BOX_HEADING_CUSTOMERS; ?></span><!--[if gte IE 7]><!--></a><!--<![endif]-->
	<!--[if	lte	IE 6]><table><tr><td><![endif]-->
	<ul>
	<li class="pad1"><b class="p7"></b><b class="p3"></b></li>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customers'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CUSTOMERS, '', 'NONSSL') . '">' . BOX_CUSTOMERS . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customers_status'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CUSTOMERS_STATUS, '', 'NONSSL') . '">' . BOX_CUSTOMERS_STATUS . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['orders'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_ORDERS, '', 'NONSSL') . '">' . BOX_ORDERS . '</a><b class="p4"></b></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['customers'] == '0') && 
 ($admin_access['customers_status'] == '0') && 
 ($admin_access['orders'] == '0')
 ) echo '<li><a href="#"></a><b class="p4"></b></li>'; 

?>

	<li class="pad2"><b class="p5"></b><b class="p6"></b></li>
	</ul>
	<!--[if	lte	IE 6]></td></tr></table></a><![endif]-->
</li>

<!-- /Покупатели -->

<!-- Модули -->

<li><a href="<?php vam_href_link(FILENAME_MODULES, 'set=payment', 'NONSSL'); ?>"><span><?php echo BOX_HEADING_MODULES; ?></span><!--[if gte IE 7]><!--></a><!--<![endif]-->
	<!--[if	lte	IE 6]><table><tr><td><![endif]-->
	<ul>
	<li class="pad1"><b class="p7"></b><b class="p3"></b></li>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_MODULES, 'set=payment', 'NONSSL') . '">' . BOX_PAYMENT . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_MODULES, 'set=shipping', 'NONSSL') . '">' . BOX_SHIPPING . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal', 'NONSSL') . '">' . BOX_ORDER_TOTAL . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['module_export'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_MODULE_EXPORT) . '">' . BOX_MODULE_EXPORT . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['cip_manager'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CIP_MANAGER) . '">' . BOX_CONTRIBUTION_INSTALLER . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['ship2pay'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_SHIP2PAY) . '">' . BOX_MODULES_SHIP2PAY . '</a><b class="p4"></b></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['modules'] == '0') && 
 ($admin_access['module_export'] == '0') && 
 ($admin_access['cip_manager'] == '0') && 
 ($admin_access['ship2pay'] == '0')
 ) echo '<li><a href="#"></a><b class="p4"></b></li>'; 

?>

	<li class="pad2"><b class="p5"></b><b class="p6"></b></li>
	</ul>
	<!--[if	lte	IE 6]></td></tr></table></a><![endif]-->
</li>

<!-- /Модули -->

<!-- Разное -->

<li><a href="<?php echo vam_href_link(FILENAME_BACKUP, 'gID=1', 'NONSSL'); ?>"><span><?php echo BOX_HEADING_OTHER; ?></span><!--[if gte IE 7]><!--></a><!--<![endif]-->
	<!--[if	lte	IE 6]><table><tr><td><![endif]-->
	<ul>
	<li class="pad1"><b class="p7"></b><b class="p3"></b></li>

<!-- Инструменты -->
	<li><a class="fly" href="<?php echo vam_href_link(FILENAME_BACKUP, '', 'NONSSL'); ?>"><?php echo BOX_HEADING_TOOLS; ?><!--[if gte IE 7]><!--></a><b class="p4"></b><!--<![endif]-->
	<!--[if	lte	IE 6]><table><tr><td><![endif]-->

		<ul>
			<li class="pad1"><b class="p7"></b><b class="p3"></b></li>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['backup'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_BACKUP) . '">' . BOX_BACKUP . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['product_extra_fields'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS) . '">' . BOX_PRODUCT_EXTRA_FIELDS . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['content_manager'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CONTENT_MANAGER) . '">' . BOX_CONTENT . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['blacklist'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_BLACKLIST, '', 'NONSSL') . '">' . BOX_TOOLS_BLACKLIST . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['module_newsletter'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_MODULE_NEWSLETTER) . '">' . BOX_MODULE_NEWSLETTER . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['banner_manager'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_BANNER_MANAGER) . '">' . BOX_BANNER_MANAGER . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['server_info'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_SERVER_INFO) . '">' . BOX_SERVER_INFO . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['latest_news'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_LATEST_NEWS) . '">' . BOX_CATALOG_LATEST_NEWS . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['faq'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_FAQ) . '">' . BOX_CATALOG_FAQ . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['whos_online'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_WHOS_ONLINE) . '">' . BOX_WHOS_ONLINE . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['easypopulate'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_EASYPOPULATE, '', 'NONSSL') . '">' . BOX_EASY_POPULATE . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['csv_backend'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CSV_BACKEND, '', 'NONSSL') . '">' . BOX_IMPORT . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['quick_updates'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_QUICK_UPDATES, '', 'NONSSL') . '">' . BOX_CATALOG_QUICK_UPDATES . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['recover_cart_sales'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_RECOVER_CART_SALES) . '">' . BOX_TOOLS_RECOVER_CART . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['email_manager'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_EMAIL_MANAGER) . '">' . BOX_TOOLS_EMAIL_MANAGER . '</a><b class="p4"></b></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['backup'] == '0') && 
 ($admin_access['product_extra_fields'] == '0') && 
 ($admin_access['content_manager'] == '0') && 
 ($admin_access['blacklist'] == '0') && 
 ($admin_access['module_newsletter'] == '0') && 
 ($admin_access['banner_manager'] == '0') && 
 ($admin_access['server_info'] == '0') && 
 ($admin_access['latest_news'] == '0') && 
 ($admin_access['whos_online'] == '0') && 
 ($admin_access['easypopulate'] == '0') && 
 ($admin_access['csv_backend'] == '0') && 
 ($admin_access['quick_updates'] == '0') && 
 ($admin_access['recover_cart_sales'] == '0') && 
 ($admin_access['email_manager'] == '0')
 ) echo '<li><a href="#"></a><b class="p4"></b></li>'; 

?>

			<li class="pad2"><b class="p5"></b><b class="p6"></b></li>
		</ul>
	<!--[if	lte	IE 6]></td></tr></table></a><b class="p4"></b><![endif]-->
	</li>
<!-- /Инструменты -->

<!-- Страны -->
	<li><a class="fly" href="<?php echo vam_href_link(FILENAME_COUNTRIES, '', 'NONSSL'); ?>"><?php echo BOX_HEADING_LOCATION_AND_TAXES; ?><!--[if gte IE 7]><!--></a><b class="p4"></b><!--<![endif]-->
	<!--[if	lte	IE 6]><table><tr><td><![endif]-->

		<ul>
			<li class="pad1"><b class="p7"></b><b class="p3"></b></li>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['countries'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_COUNTRIES, '', 'NONSSL') . '">' . BOX_COUNTRIES . '</a><b class="p4"></b></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['zones'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_ZONES, '', 'NONSSL') . '">' . BOX_ZONES . '</a><b class="p4"></b></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['geo_zones'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_GEO_ZONES, '', 'NONSSL') . '">' . BOX_GEO_ZONES . '</a><b class="p4"></b></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['tax_classes'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_TAX_CLASSES, '', 'NONSSL') . '">' . BOX_TAX_CLASSES . '</a><b class="p4"></b></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['tax_rates'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_TAX_RATES, '', 'NONSSL') . '">' . BOX_TAX_RATES . '</a><b class="p4"></b></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['countries'] == '0') && 
 ($admin_access['zones'] == '0') && 
 ($admin_access['geo_zones'] == '0') &&
 ($admin_access['tax_classes'] == '0') &&
 ($admin_access['tax_rates'] == '0')
 ) echo '<li><a href="#"></a><b class="p4"></b></li>'; 
 
?>

			<li class="pad2"><b class="p5"></b><b class="p6"></b></li>
		</ul>
	<!--[if	lte	IE 6]></td></tr></table></a><b class="p4"></b><![endif]-->
	</li>
<!-- /Страны -->

<!-- Языки -->
	<li><a class="fly" href="<?php echo vam_href_link(FILENAME_CURRENCIES, '', 'NONSSL'); ?>"><?php echo BOX_HEADING_LOCALIZATION; ?><!--[if gte IE 7]><!--></a><b class="p4"></b><!--<![endif]-->
	<!--[if	lte	IE 6]><table><tr><td><![endif]-->

		<ul>
			<li class="pad1"><b class="p7"></b><b class="p3"></b></li>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['currencies'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CURRENCIES, '', 'NONSSL') . '">' . BOX_CURRENCIES . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['languages'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_LANGUAGES, '', 'NONSSL') . '">' . BOX_LANGUAGES . '</a><b class="p4"></b></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['currencies'] == '0') && 
 ($admin_access['languages'] == '0')
 ) echo '<li><a href="#"></a><b class="p4"></b></li>'; 
 
?>

			<li class="pad2"><b class="p5"></b><b class="p6"></b></li>
		</ul>
	<!--[if	lte	IE 6]></td></tr></table></a><b class="p4"></b><![endif]-->
	</li>
<!-- /Языки -->

<!-- Купоны -->
	<li><a class="fly" href="<?php echo vam_href_link(FILENAME_COUPON_ADMIN, '', 'NONSSL'); ?>"><?php echo BOX_HEADING_GV_ADMIN; ?><!--[if gte IE 7]><!--></a><b class="p4"></b><!--<![endif]-->
	<!--[if	lte	IE 6]><table><tr><td><![endif]-->

		<ul>
			<li class="pad1"><b class="p7"></b><b class="p3"></b></li>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['coupon_admin'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_COUPON_ADMIN, '', 'NONSSL') . '">' . BOX_COUPON_ADMIN . '</a><b class="p4"></b></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_queue'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_GV_QUEUE, '', 'NONSSL') . '">' . BOX_GV_ADMIN_QUEUE . '</a><b class="p4"></b></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_mail'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_GV_MAIL, '', 'NONSSL') . '">' . BOX_GV_ADMIN_MAIL . '</a><b class="p4"></b></li>' . "\n";

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_sent'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_GV_SENT, '', 'NONSSL') . '">' . BOX_GV_ADMIN_SENT . '</a><b class="p4"></b></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['coupon_admin'] == '0') && 
 ($admin_access['gv_queue'] == '0') && 
 ($admin_access['gv_mail'] == '0') && 
 ($admin_access['gv_sent'] == '0')
 ) echo '<li><a href="#"></a><b class="p4"></b></li>'; 

?>

			<li class="pad2"><b class="p5"></b><b class="p6"></b></li>
		</ul>
	<!--[if	lte	IE 6]></td></tr></table></a><b class="p4"></b><![endif]-->
	</li>
<!-- /Купоны -->

<!-- Статистика -->
	<li><a class="fly" href="<?php echo vam_href_link(FILENAME_STATS_SALES_REPORT2, '', 'NONSSL'); ?>"><?php echo BOX_HEADING_STATISTICS; ?><!--[if gte IE 7]><!--></a><b class="p4"></b><!--<![endif]-->
	<!--[if	lte	IE 6]><table><tr><td><![endif]-->

		<ul>
			<li class="pad1"><b class="p7"></b><b class="p3"></b></li>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_products_viewed'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_STATS_PRODUCTS_VIEWED, '', 'NONSSL') . '">' . BOX_PRODUCTS_VIEWED . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_products_purchased'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, '', 'NONSSL') . '">' . BOX_PRODUCTS_PURCHASED . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_customers'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_STATS_CUSTOMERS, '', 'NONSSL') . '">' . BOX_STATS_CUSTOMERS . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_sales_report'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_SALES_REPORT, '', 'NONSSL') . '">' . BOX_SALES_REPORT . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_sales_report2'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_STATS_SALES_REPORT2, '', 'NONSSL') . '">' . BOX_SALES_REPORT2 . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_campaigns'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_CAMPAIGNS_REPORT, '', 'NONSSL') . '">' . BOX_CAMPAIGNS_REPORT . '</a><b class="p4"></b></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['stats_products_viewed'] == '0') && 
 ($admin_access['stats_products_purchased'] == '0') && 
 ($admin_access['stats_sales_report'] == '0') && 
 ($admin_access['stats_sales_report2'] == '0') && 
 ($admin_access['stats_campaigns'] == '0')
 ) echo '<li><a href="#"></a><b class="p4"></b></li>'; 

?>

			<li class="pad2"><b class="p5"></b><b class="p6"></b></li>
		</ul>
	<!--[if	lte	IE 6]></td></tr></table></a><b class="p4"></b><![endif]-->
	</li>
<!-- /Статистика -->

<!-- Статьи -->
	<li><a class="fly" href="<?php echo vam_href_link(FILENAME_ARTICLES, '', 'NONSSL'); ?>"><?php echo BOX_HEADING_ARTICLES; ?><!--[if gte IE 7]><!--></a><b class="p4"></b><!--<![endif]-->
	<!--[if	lte	IE 6]><table><tr><td><![endif]-->

		<ul>
			<li class="pad1"><b class="p7"></b><b class="p3"></b></li>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['articles'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_ARTICLES, '', 'NONSSL') . '">' . BOX_TOPICS_ARTICLES . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['articles_config'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_ARTICLES_CONFIG, '', 'NONSSL') . '">' . BOX_ARTICLES_CONFIG . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['authors'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_AUTHORS, '', 'NONSSL') . '">' . BOX_ARTICLES_AUTHORS . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['articles_xsell'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_ARTICLES_XSELL, '', 'NONSSL') . '">' . BOX_ARTICLES_XSELL . '</a><b class="p4"></b></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['articles'] == '0') && 
 ($admin_access['articles_config'] == '0') && 
 ($admin_access['authors'] == '0') && 
 ($admin_access['articles_xsell'] == '0')
 ) echo '<li><a href="#"></a><b class="p4"></b></li>'; 

?>

			<li class="pad2"><b class="p5"></b><b class="p6"></b></li>
		</ul>
	<!--[if	lte	IE 6]></td></tr></table></a><b class="p4"></b><![endif]-->
	</li>
<!-- /Статьи -->

<!-- Помощь -->
	<li><a class="fly" href="#"><?php echo BOX_HEADING_HELP; ?><!--[if gte IE 7]><!--></a><b class="p4"></b><!--<![endif]-->
	<!--[if	lte	IE 6]><table><tr><td><![endif]-->

		<ul>
			<li class="pad1"><b class="p7"></b><b class="p3"></b></li>

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['languages'] == '1')) echo '<li><a href="http://vamshop.ru" target="_blank">' . BOX_SUPPORT_SITE . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['languages'] == '1')) echo '<li><a href="http://vamshop.ru/faq" target="_blank">' . BOX_SUPPORT_FAQ . '</a><b class="p4"></b></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['languages'] == '1')) echo '<li><a href="http://vamshop.ru/forum" target="_blank">' . BOX_SUPPORT_FORUM . '</a><b class="p4"></b></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['languages'] == '0')
 ) echo '<li><a href="#"></a><b class="p4"></b></li>'; 

?>

			<li class="pad2"><b class="p5"></b><b class="p6"></b></li>
		</ul>
	<!--[if	lte	IE 6]></td></tr></table></a><b class="p4"></b><![endif]-->
	</li>
<!-- /Помощь -->

<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['currencies'] == '1')) echo '<li><a href="' . vam_href_link(FILENAME_LOGOUT, '', 'NONSSL') . '">' . BOX_HEADING_LOGOFF . '</a><b class="p4"></b></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['currencies'] == '0')
 ) echo '<li><a href="#"></a><b class="p4"></b></li>'; 
  
?>

	<li class="pad2"><b class="p5"></b><b class="p6"></b></li>
	</ul>
	<!--[if	lte	IE 6]></td></tr></table></a><![endif]-->
</li>

<!-- /Разное -->

</ul>

<?php } ?>

</div>

<!-- /шапка -->
