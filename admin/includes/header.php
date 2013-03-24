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
   (c) 2003     nextcommerce (header.php,v 1.17 2003/08/24); www.nextcommerce.org
   (c) 2004     xt:Commerce (header.php,v 1.17 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  if ($messageStack->size > 0) {
    echo $messageStack->output();
  }

?>

<!-- шапка -->        
          <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="200" align="left" class="header">
              <a href="start.php"><?php echo vam_image(DIR_WS_IMAGES . 'logo.png', 'VamShop'); ?></a>
              </td>
              <td width="370" align="center" class="header">
              &nbsp;
              </td>
              <td width="300" class="header">
              &nbsp;
              </td>
            </tr>
</table>

<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'true') { ?>

          <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>
              
    <div id="nav" class="nav">
        <div id="menu">
            <ul>
                <li class="level1"><a class="sub" href="<?php echo vam_href_link(FILENAME_ORDERS, '', 'NONSSL'); ?>" onclick="return false"><b><?php echo BOX_HEADING_ORDERS; ?></b><!--[if gte IE 7]><!--></a><!--<![endif]-->
                <!--[if lte IE 6]><table class="ie6"><tr><td><![endif]-->
                <div class="holder">
                    <div class="leftSide">
                        <div class="rightSide">
                        <table><tr>

                            <td>
                                <dl>
                                
<?php
  $admin_access_query = vam_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . $_SESSION['customer_id'] . "'");
  $admin_access = vam_db_fetch_array($admin_access_query); 
?>
                                
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['orders'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_ORDERS, '', 'NONSSL') . '">' . BOX_ORDERS . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['exportorders'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_EXPORTORDERS, '', 'NONSSL') . '">' . BUTTON_ORDERS_EXPORT . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['recover_cart_sales'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_RECOVER_CART_SALES) . '">' . BOX_TOOLS_RECOVER_CART . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['orders_status'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_ORDERS_STATUS, '', 'NONSSL') . '">' . BOX_ORDERS_STATUS . '</a></dd>' . "\n";
  if (ACTIVATE_SHIPPING_STATUS=='true') {
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['shipping_status'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_SHIPPING_STATUS, '', 'NONSSL') . '">' . BOX_SHIPPING_STATUS . '</a></dd>' . "\n";
  }

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['orders'] == '0') && 
 ($admin_access['exportorders'] == '0') && 
 ($admin_access['recover_cart_sales'] == '0') && 
 ($admin_access['orders_status'] == '0') && 
 ($admin_access['shipping_status'] == '0')
 ) echo '<dd>'.TEXT_ACCESS_FORBIDDEN.'</dd>'; 

?>
                                </dl>

                            </td>
                        </tr></table>
                        </div>
                    </div>
                </div>
                <!--[if lte IE 6]></td></tr></table></a><![endif]-->

                </li>                
                <li><a class="sub" href="<?php echo vam_href_link(FILENAME_CATEGORIES, '', 'NONSSL'); ?>" onclick="return false"><b><?php echo BOX_HEADING_CATALOG; ?></b><!--[if gte IE 7]><!--></a><!--<![endif]-->
                <!--[if lte IE 6]><table class="ie6"><tr><td><![endif]-->
                <div class="holder">
                    <div class="leftSide">
                        <div class="rightSide">
                        <table><tr>

                            <td>
                                <dl>
<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['categories'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CATEGORIES, '', 'NONSSL') . '">' . BOX_CATEGORIES . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_options'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, '', 'NONSSL') . '">' . BOX_PRODUCTS_OPTIONS . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_attributes'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '', 'NONSSL') . '">' . BOX_PRODUCTS_ATTRIBUTES . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['new_attributes'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_NEW_ATTRIBUTES, '', 'NONSSL') . '">' . BOX_ATTRIBUTES_MANAGER . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['manufacturers'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_MANUFACTURERS, '', 'NONSSL') . '">' . BOX_MANUFACTURERS . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['reviews'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_REVIEWS, '', 'NONSSL') . '">' . BOX_REVIEWS . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['specials'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_SPECIALS, '', 'NONSSL') . '">' . BOX_SPECIALS . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['featured'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_FEATURED, '', 'NONSSL') . '">' . BOX_FEATURED . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_specifications'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_PRODUCTS_SPECIFICATIONS, '', 'NONSSL') . '">' . BOX_CATALOG_PRODUCTS_SPECIFICATIONS . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['pin_loader'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_PIN_LOADER, '', 'NONSSL') . '">' . BOX_CATALOG_PIN_LOADER . '</a></dd>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['categories'] == '0') && 
 ($admin_access['products_options'] == '0') && 
 ($admin_access['products_attributes'] == '0') && 
 ($admin_access['new_attributes'] == '0') && 
 ($admin_access['manufacturers'] == '0') && 
 ($admin_access['reviews'] == '0') && 
 ($admin_access['specials'] == '0') && 
 ($admin_access['featured'] == '0') && 
 ($admin_access['pin_loader'] == '0')
 ) echo '<dd>'.TEXT_ACCESS_FORBIDDEN.'</dd>'; 

?>
                                </dl>

                            </td>
                        </tr></table>
                        </div>
                    </div>
                </div>
                <!--[if lte IE 6]></td></tr></table></a><![endif]-->

                </li>
                <li><a class="sub" href="<?php echo vam_href_link(FILENAME_CUSTOMERS, '', 'NONSSL'); ?>" onclick="return false"><b><?php echo BOX_HEADING_CUSTOMERS; ?></b><!--[if gte IE 7]><!--></a><!--<![endif]-->
                <!--[if lte IE 6]><table class="ie6"><tr><td><![endif]-->
                <div class="holder">
                    <div class="leftSide">
                        <div class="rightSide">
                        <table><tr>

                            <td>
                                <dl>
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customers'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CUSTOMERS, '', 'NONSSL') . '">' . BOX_CUSTOMERS . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customers_status'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CUSTOMERS_STATUS, '', 'NONSSL') . '">' . BOX_CUSTOMERS_STATUS . '</a></dd>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['customers'] == '0') && 
 ($admin_access['customers_status'] == '0')  
 ) echo '<dd>'.TEXT_ACCESS_FORBIDDEN.'</dd>'; 

?>
                                </dl>

                            </td>
                        </tr></table>
                        </div>
                    </div>
                </div>
                <!--[if lte IE 6]></td></tr></table></a><![endif]-->

                </li>
                <li><a class="sub" href="<?php echo vam_href_link(FILENAME_MODULES, 'set=payment', 'NONSSL'); ?>" onclick="return false"><b><?php echo BOX_HEADING_MODULES; ?></b><!--[if gte IE 7]><!--></a><!--<![endif]-->
                <!--[if lte IE 6]><table class="ie6"><tr><td><![endif]-->
                <div class="holder">
                    <div class="leftSide">
                        <div class="rightSide">
                        <table><tr>

                            <td>
                                <dl>
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_MODULES, 'set=payment', 'NONSSL') . '">' . BOX_PAYMENT . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_MODULES, 'set=shipping', 'NONSSL') . '">' . BOX_SHIPPING . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal', 'NONSSL') . '">' . BOX_ORDER_TOTAL . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['module_export'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_MODULE_EXPORT) . '">' . BOX_MODULE_EXPORT . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['cip_manager'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CIP_MANAGER) . '">' . BOX_CONTRIBUTION_INSTALLER . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['ship2pay'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_SHIP2PAY) . '">' . BOX_MODULES_SHIP2PAY . '</a></dd>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['modules'] == '0') && 
 ($admin_access['module_export'] == '0') && 
 ($admin_access['cip_manager'] == '0') && 
 ($admin_access['ship2pay'] == '0')
 ) echo '<dd>'.TEXT_ACCESS_FORBIDDEN.'</dd>'; 

?>
                                </dl>

                            </td>
                        </tr></table>
                        </div>
                    </div>
                </div>
                <!--[if lte IE 6]></td></tr></table></a><![endif]-->

                </li>
                <li><a class="sub" href="<?php echo vam_href_link(FILENAME_BACKUP, 'gID=1', 'NONSSL'); ?>" onclick="return false"><b><?php echo BOX_HEADING_OTHER; ?></b><!--[if gte IE 7]><!--></a><!--<![endif]-->
                <!--[if lte IE 6]><table class="ie6"><tr><td><![endif]-->
                <div class="holder">

                    <div class="leftSide">
                        <div class="rightSide">
                        <table><tr>
                            <td>
                                <dl>
                                    <dt><?php echo BOX_HEADING_TOOLS; ?></dt>
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['backup'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_BACKUP) . '">' . BOX_BACKUP . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['product_extra_fields'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS) . '">' . BOX_PRODUCT_EXTRA_FIELDS . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customer_extra_fields'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_EXTRA_FIELDS) . '">' . BOX_HEADING_CUSTOMER_EXTRA_FIELDS . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['content_manager'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONTENT_MANAGER) . '">' . BOX_CONTENT . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['module_newsletter'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_MODULE_NEWSLETTER) . '">' . BOX_MODULE_NEWSLETTER . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['banner_manager'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_BANNER_MANAGER) . '">' . BOX_BANNER_MANAGER . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['server_info'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_SERVER_INFO) . '">' . BOX_SERVER_INFO . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['latest_news'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_LATEST_NEWS) . '">' . BOX_CATALOG_LATEST_NEWS . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['faq'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_FAQ) . '">' . BOX_CATALOG_FAQ . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['whos_online'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_WHOS_ONLINE) . '">' . BOX_WHOS_ONLINE . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['easypopulate'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_EASYPOPULATE, '', 'NONSSL') . '">' . BOX_EASY_POPULATE . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['yml_import'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_YML_IMPORT, '', 'NONSSL') . '">' . BOX_YML_IMPORT . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['quick_updates'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_QUICK_UPDATES, '', 'NONSSL') . '">' . BOX_CATALOG_QUICK_UPDATES . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['email_manager'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_EMAIL_MANAGER) . '">' . BOX_TOOLS_EMAIL_MANAGER . '</a></dd>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['backup'] == '0') && 
 ($admin_access['product_extra_fields'] == '0') && 
 ($admin_access['content_manager'] == '0') && 
 ($admin_access['module_newsletter'] == '0') && 
 ($admin_access['banner_manager'] == '0') && 
 ($admin_access['server_info'] == '0') && 
 ($admin_access['latest_news'] == '0') && 
 ($admin_access['whos_online'] == '0') && 
 ($admin_access['easypopulate'] == '0') && 
 ($admin_access['csv_backend'] == '0') && 
 ($admin_access['quick_updates'] == '0') && 
 ($admin_access['email_manager'] == '0')
 ) echo '<dd>'.TEXT_ACCESS_FORBIDDEN.'</dd>'; 

?>
                                </dl>
                            </td>
                            <td>
                                <dl>
                                    <dt><?php echo BOX_HEADING_LOCATION_AND_TAXES; ?></dt>
<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['countries'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_COUNTRIES, '', 'NONSSL') . '">' . BOX_COUNTRIES . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['zones'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_ZONES, '', 'NONSSL') . '">' . BOX_ZONES . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['geo_zones'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_GEO_ZONES, '', 'NONSSL') . '">' . BOX_GEO_ZONES . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['tax_classes'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_TAX_CLASSES, '', 'NONSSL') . '">' . BOX_TAX_CLASSES . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['tax_rates'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_TAX_RATES, '', 'NONSSL') . '">' . BOX_TAX_RATES . '</a></dd>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['countries'] == '0') && 
 ($admin_access['zones'] == '0') && 
 ($admin_access['geo_zones'] == '0') &&
 ($admin_access['tax_classes'] == '0') &&
 ($admin_access['tax_rates'] == '0')
 ) echo '<dd>'.TEXT_ACCESS_FORBIDDEN.'</dd>'; 
 
?>
                                    <dt><?php echo BOX_HEADING_LOCALIZATION; ?></dt>
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['currencies'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CURRENCIES, '', 'NONSSL') . '">' . BOX_CURRENCIES . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['languages'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_LANGUAGES, '', 'NONSSL') . '">' . BOX_LANGUAGES . '</a></dd>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['currencies'] == '0') && 
 ($admin_access['languages'] == '0')
 ) echo '<dd>'.TEXT_ACCESS_FORBIDDEN.'</dd>'; 
 
?>
                                    <dt><?php echo BOX_HEADING_GV_ADMIN; ?></dt>
<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['coupon_admin'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_COUPON_ADMIN, '', 'NONSSL') . '">' . BOX_COUPON_ADMIN . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_queue'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_GV_QUEUE, '', 'NONSSL') . '">' . BOX_GV_ADMIN_QUEUE . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_mail'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_GV_MAIL, '', 'NONSSL') . '">' . BOX_GV_ADMIN_MAIL . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_sent'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_GV_SENT, '', 'NONSSL') . '">' . BOX_GV_ADMIN_SENT . '</a></dd>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['coupon_admin'] == '0') && 
 ($admin_access['gv_queue'] == '0') && 
 ($admin_access['gv_mail'] == '0') && 
 ($admin_access['gv_sent'] == '0')
 ) echo '<dd>'.TEXT_ACCESS_FORBIDDEN.'</dd>'; 

?>
                                    <dt><?php echo BOX_HEADING_STATISTICS; ?></dt>
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_products_viewed'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_STATS_PRODUCTS_VIEWED, '', 'NONSSL') . '">' . BOX_PRODUCTS_VIEWED . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_products_purchased'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, '', 'NONSSL') . '">' . BOX_PRODUCTS_PURCHASED . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_customers'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_STATS_CUSTOMERS, '', 'NONSSL') . '">' . BOX_STATS_CUSTOMERS . '</a></dd>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['stats_products_viewed'] == '0') && 
 ($admin_access['stats_products_purchased'] == '0') && 
 ($admin_access['stats_sales_report'] == '0') && 
 ($admin_access['stats_sales_report2'] == '0') && 
 ($admin_access['stats_campaigns'] == '0')
 ) echo '<dd>'.TEXT_ACCESS_FORBIDDEN.'</dd>'; 

?>
                                </dl>

                            </td>
                            <td>
                                <dl>
<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_sales_report'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_SALES_REPORT, '', 'NONSSL') . '">' . BOX_SALES_REPORT . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_sales_report2'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_STATS_SALES_REPORT2, '', 'NONSSL') . '">' . BOX_SALES_REPORT2 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_campaigns'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CAMPAIGNS_REPORT, '', 'NONSSL') . '">' . BOX_CAMPAIGNS_REPORT . '</a></dd>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['stats_products_viewed'] == '0') && 
 ($admin_access['stats_products_purchased'] == '0') && 
 ($admin_access['stats_sales_report'] == '0') && 
 ($admin_access['stats_sales_report2'] == '0') && 
 ($admin_access['stats_campaigns'] == '0')
 ) echo '<dd>'.TEXT_ACCESS_FORBIDDEN.'</dd>'; 

?>

                                    <dt><?php echo BOX_HEADING_ARTICLES; ?></dt>
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['articles'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_ARTICLES, '', 'NONSSL') . '">' . BOX_TOPICS_ARTICLES . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['articles_config'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_ARTICLES_CONFIG, '', 'NONSSL') . '">' . BOX_ARTICLES_CONFIG . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['authors'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_AUTHORS, '', 'NONSSL') . '">' . BOX_ARTICLES_AUTHORS . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['articles_xsell'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_ARTICLES_XSELL, '', 'NONSSL') . '">' . BOX_ARTICLES_XSELL . '</a></dd>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['articles'] == '0') && 
 ($admin_access['articles_config'] == '0') && 
 ($admin_access['authors'] == '0') && 
 ($admin_access['articles_xsell'] == '0')
 ) echo '<dd>'.TEXT_ACCESS_FORBIDDEN.'</dd>'; 

?>

                                    <dt><?php echo BOX_HEADING_AFFILIATE; ?></dt>
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=28', 'NONSSL') . '">' . BOX_AFFILIATE_CONFIGURATION . '</a></dd>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_affiliates'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_AFFILIATE, '', 'NONSSL') . '">' . BOX_AFFILIATE . '</a></dd>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_banners'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_AFFILIATE_BANNERS, '', 'NONSSL') . '">' . BOX_AFFILIATE_BANNERS . '</a></dd>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_clicks'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_AFFILIATE_CLICKS, '', 'NONSSL') . '">' . BOX_AFFILIATE_CLICKS . '</a></dd>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_contact'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_AFFILIATE_CONTACT, '', 'NONSSL') . '">' . BOX_AFFILIATE_CONTACT . '</a></dd>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_payment'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_AFFILIATE_PAYMENT, '', 'NONSSL') . '">' . BOX_AFFILIATE_PAYMENT . '</a></dd>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_sales'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_AFFILIATE_SALES, '', 'NONSSL') . '">' . BOX_AFFILIATE_SALES . '</a></dd>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_summary'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'NONSSL') . '">' . BOX_AFFILIATE_SUMMARY . '</a></dd>';

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['configuration'] == '0') && 
 ($admin_access['affiliate_affiliates'] == '0') && 
 ($admin_access['affiliate_banners'] == '0') && 
 ($admin_access['affiliate_clicks'] == '0') && 
 ($admin_access['affiliate_contact'] == '0') && 
 ($admin_access['affiliate_payment'] == '0') && 
 ($admin_access['affiliate_sales'] == '0') && 
 ($admin_access['affiliate_summary'] == '0')
 ) echo '<dd>'.TEXT_ACCESS_FORBIDDEN.'</dd>'; 

?>

                                </dl>
                            </td>
                        </tr></table>
                        </div>

                    </div>
                </div>
                <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                </li>

                <li><a class="sub" href="<?php echo vam_href_link(FILENAME_CONFIGURATION, 'gID=1', 'NONSSL'); ?>" onclick="return false"><b><?php echo BOX_HEADING_CONFIGURATION; ?></b><!--[if gte IE 7]><!--></a><!--<![endif]-->

                <!--[if lte IE 6]><table class="ie6"><tr><td><![endif]-->
                <div class="holder">
                    <div class="leftSide">
                        <div class="rightSide">
                        <table><tr>
                        <td>
                            <dl>
                                <dt><?php echo BOX_HEADING_CONFIGURATION_MAIN; ?></dt>

<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=1', 'NONSSL') . '">' . BOX_CONFIGURATION_1 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=2', 'NONSSL') . '">' . BOX_CONFIGURATION_2 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=3', 'NONSSL') . '">' . BOX_CONFIGURATION_3 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=4', 'NONSSL') . '">' . BOX_CONFIGURATION_4 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=5', 'NONSSL') . '">' . BOX_CONFIGURATION_5 . '</a></dd>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=6', 'NONSSL') . '">' . BOX_CONFIGURATION_6 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=7', 'NONSSL') . '">' . BOX_CONFIGURATION_7 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=8', 'NONSSL') . '">' . BOX_CONFIGURATION_8 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=9', 'NONSSL') . '">' . BOX_CONFIGURATION_9 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=10', 'NONSSL') . '">' . BOX_CONFIGURATION_10 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=11', 'NONSSL') . '">' . BOX_CONFIGURATION_11 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['cache'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CACHE, '', 'NONSSL') . '">' . BOX_CACHE_FILES . '</a></dd>' . "\n";
?>  
                            </dl>
                        </td>

                        <td>
                            <dl>

<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=12', 'NONSSL') . '">' . BOX_CONFIGURATION_12 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=13', 'NONSSL') . '">' . BOX_CONFIGURATION_13 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=14', 'NONSSL') . '">' . BOX_CONFIGURATION_14 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=15', 'NONSSL') . '">' . BOX_CONFIGURATION_15 . '</a></dd>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=18', 'NONSSL') . '">' . BOX_CONFIGURATION_18 . '</a></dd>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=20', 'NONSSL') . '">' . BOX_CONFIGURATION_20 . '</a></dd>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=21', 'NONSSL') . '">' . BOX_CONFIGURATION_21 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=22', 'NONSSL') . '">' . BOX_CONFIGURATION_22 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=24', 'NONSSL') . '">' . BOX_CONFIGURATION_24 . '</a></dd>' . "\n";
?>
                                <dt><?php echo BOX_HEADING_OTHER; ?></dt>

<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_vpe'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_PRODUCTS_VPE, '', 'NONSSL') . '">' . BOX_PRODUCTS_VPE . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['campaigns'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CAMPAIGNS, '', 'NONSSL') . '">' . BOX_CAMPAIGNS . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['cross_sell_groups'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_XSELL_GROUPS, '', 'NONSSL') . '">' . BOX_ORDERS_XSELL_GROUP . '</a></dd>' . "\n";
?>

                            </dl>
                        </td>

                        <td>
                            <dl>

<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=19', 'NONSSL') . '">' . BOX_CONFIGURATION_19 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=23', 'NONSSL') . '">' . BOX_CONFIGURATION_23 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=25', 'NONSSL') . '">' . BOX_CONFIGURATION_25 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=27', 'NONSSL') . '">' . BOX_CONFIGURATION_27 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=72', 'NONSSL') . '">' . BOX_CONFIGURATION_72 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=80', 'NONSSL') . '">' . BOX_CONFIGURATION_80 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=1610', 'NONSSL') . '">' . BOX_CONFIGURATION_1610 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=17', 'NONSSL') . '">' . BOX_CONFIGURATION_17 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=16', 'NONSSL') . '">' . BOX_CONFIGURATION_16 . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<dd><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=29', 'NONSSL') . '">' . BOX_CONFIGURATION_29 . '</a></dd>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['products_vpe'] == '0') && 
 ($admin_access['campaigns'] == '0') && 
 ($admin_access['configuration'] == '0') && 
 ($admin_access['cross_sell_groups'] == '0')
 ) echo '<dd>'.TEXT_ACCESS_FORBIDDEN.'</dd>'; 

?>

                            </dl>
                        </td>
                        </tr></table>
                        </div>
                    </div>
                </div>

                <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                </li>
                                
                <li><a class="sub" href="http://vamshop.ru" target="_blank" onclick="return false"><b><?php echo BOX_HEADING_HELP; ?></b><!--[if gte IE 7]><!--></a><!--<![endif]-->
                <!--[if lte IE 6]><table class="ie6"><tr><td><![endif]-->
                <div class="holder">

                    <div class="leftSide">
                        <div class="rightSide">
                        <table><tr>
                            <td>
                                <dl>
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['languages'] == '1')) echo '<dd><a href="http://vamshop.ru" target="_blank">' . BOX_SUPPORT_SITE . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['languages'] == '1')) echo '<dd><a href="http://vamshop.ru/manual/" target="_blank">' . HEADER_TITLE_DOCS . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['languages'] == '1')) echo '<dd><a href="http://vamshop.ru/forum/forum/26-faq/" target="_blank">' . BOX_SUPPORT_FAQ . '</a></dd>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['languages'] == '1')) echo '<dd><a href="http://vamshop.ru/forum/" target="_blank">' . BOX_SUPPORT_FORUM . '</a></dd>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['languages'] == '0')
 ) echo '<dd>'.TEXT_ACCESS_FORBIDDEN.'</dd>'; 

?>
                                </dl>

                            </td>
                        </tr></table>
                        </div>

                    </div>
                </div>
                <!--[if lte IE 6]></td></tr></table></a><![endif]-->
                </li>
                <li class="level1"><a href="<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>"  target="_blank"><b><?php echo HEADER_TITLE_ONLINE_CATALOG; ?></b></a></li>
                <li class="level1"><a href="<?php echo vam_href_link(FILENAME_LOGOUT, '', 'NONSSL'); ?>"><b><?php echo BOX_HEADING_LOGOFF; ?></b></a></li>
            </ul>
        </div>

    </div>

<div class="clear">

              </td>
            </tr>
</table>

<?php } ?>
    
<!-- /шапка -->
