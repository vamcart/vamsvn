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
<?php
  $admin_access_query = vam_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . $_SESSION['customer_id'] . "'");
  $admin_access = vam_db_fetch_array($admin_access_query); 
?>
		<div id="vamshop-menu" class="vamshop-menu">
		   <div class="vamshop-menu-overlay-box"></div>
			<div class="vamshop-menu-container">
<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'true') { ?>
				<header class="vamshop-menu-header">
					<div class="vamshop-menu-wrapper"> 
						<div class="vamshop-menu-right-header">
							<div class="vamshop-menu-rl-header"> 
							<div class="vamshop-menu-logo"> 
								<span class="logo-text"><a href="start.php"><?php echo vam_image(DIR_WS_IMAGES . 'logo-small.png', 'VamShop'); ?></a></span>
<?php

  $total_orders_query = vam_db_query("select count(*) as count from " . TABLE_ORDERS);
  $total_orders = vam_db_fetch_array($total_orders_query);

  $orders_pending_query = vam_db_query("select count(*) as count from " . TABLE_ORDERS . " where orders_status = '" . DEFAULT_ORDERS_STATUS_ID . "'");
  $orders_pending = vam_db_fetch_array($orders_pending_query);

  $total_sales_query = vam_db_query("SELECT sum(ot.value) as value, avg(ot.value) as avg, count(ot.value) as count FROM " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS . " o WHERE ot.orders_id = o.orders_id and ot.class = 'ot_subtotal'");
  $total_sales = vam_db_fetch_array($total_sales_query);

  $customers_query = vam_db_query("select count(*) as count from " . TABLE_CUSTOMERS);
  $customers = vam_db_fetch_array($customers_query);

?>
									<span class="pr-1">
										<a href="<?php echo vam_href_link(FILENAME_ORDERS, 'status='.DEFAULT_ORDERS_STATUS_ID, 'NONSSL'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo (($orders_pending['count'] > 0) ? TEXT_SUMMARY_PENDING_ORDERS.': '.$orders_pending['count'] : BOX_ORDERS) ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
											<?php echo (($orders_pending['count'] > 0) ? ' <sup class="badge badge-danger rounded-pill">'.$orders_pending['count'].'</sup>' : '') ?>
										</a>
									</span>
									<span class="pr-1">
										<a href="<?php echo vam_href_link(FILENAME_CUSTOMERS, '', 'NONSSL'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo BOX_CUSTOMERS; ?>"><i class="fas fa-users" aria-hidden="true"></i>
										</a>
									</span>
									<span class="pr-1">
										<a href="<?php echo vam_href_link(FILENAME_CATEGORIES, '', 'NONSSL'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo BOX_CATEGORIES; ?>"><i class="fa fa-book" aria-hidden="true"></i>
										</a>
									</span>
									<span class="pr-1">
										<a href="<?php echo vam_href_link(FILENAME_CONTENT_MANAGER, '', 'NONSSL'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo TEXT_HEADER_PAGES; ?>"><i class="far fa-file-alt" aria-hidden="true"></i>
										</a>
									</span>
									<span class="pr-1">
										<a href="<?php echo vam_href_link(FILENAME_ARTICLES, '', 'NONSSL'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo TEXT_HEADER_ARTICLES; ?>"><i class="far fa-newspaper" aria-hidden="true"></i>
										</a>
									</span>
									<span class="pr-1">
										<a href="<?php echo vam_href_link(FILENAME_LATEST_NEWS, '', 'NONSSL'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo TEXT_HEADER_NEWS; ?>"><i class="fa fa-rss" aria-hidden="true"></i>
										</a>
									</span>
									<span class="pr-1">
										<a href="<?php echo vam_href_link(FILENAME_CACHE, 'action=unlink', 'NONSSL'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo TEXT_CLEAR_CACHE; ?>"><i class="fa fa-trash-alt" aria-hidden="true"></i>
										</a>
									</span>
									<span class="pr-1">
										<a href="<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo TEXT_HEADER_SHOP; ?>"><i class="fa fa-store" aria-hidden="true"></i>
										</a>
									</span>
									<span class="pr-1">
										<a href="https://vamshop.ru" data-toggle="tooltip" data-placement="bottom" title="<?php echo TEXT_HEADER_SUPPORT; ?>"><i class="fas fa-question-circle" aria-hidden="true"></i>
										</a>
									</span>
									<span class="pr-1">
										<a href="../logoff.php" data-toggle="tooltip" data-placement="bottom" title="<?php echo BOX_HEADING_LOGOFF; ?>"><i class="fas fa-power-off" aria-hidden="true"></i>
										</a>
									</span>
							</div> 
							</div>
							<div class="vamshop-menu-rr-header">
							</div>
						</div>
					</div>
					<div class="vamshop-menubrand-xs">
						<div class="vamshop-menu-brand">
							<span class="menu-toggle"><a href="#"><i class="fa fa-bars"></i></a></span>
						</div>
					</div>
				</header>
<?php } else { ?>				
				<header class="vamshop-menu-header">
					<div class="vamshop-menu-wrapper"> 
						<div class="vamshop-menu-left-header"> 
								<div class="vamshop-menu-brand">
									<a href="start.php"><?php echo vam_image(DIR_WS_IMAGES . 'logo-small-vertical.png', 'VamShop'); ?></a>
									<span class="menu-toggle"><a href="#"><i class="icon-menu"></i></a></span>
								</div>
						</div>
						<div class="vamshop-menu-right-header"> 
							<div class="sidebar_toggle"><a href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="<?php echo TEXT_NAVIGATION; ?>"><i class="fa fa-bars"></i></a></div> 
							<div class="vamshop-menu-rl-header"> 
<?php

  $total_orders_query = vam_db_query("select count(*) as count from " . TABLE_ORDERS);
  $total_orders = vam_db_fetch_array($total_orders_query);

  $orders_pending_query = vam_db_query("select count(*) as count from " . TABLE_ORDERS . " where orders_status = '" . DEFAULT_ORDERS_STATUS_ID . "'");
  $orders_pending = vam_db_fetch_array($orders_pending_query);

  $total_sales_query = vam_db_query("SELECT sum(ot.value) as value, avg(ot.value) as avg, count(ot.value) as count FROM " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS . " o WHERE ot.orders_id = o.orders_id and ot.class = 'ot_subtotal'");
  $total_sales = vam_db_fetch_array($total_sales_query);

  $customers_query = vam_db_query("select count(*) as count from " . TABLE_CUSTOMERS);
  $customers = vam_db_fetch_array($customers_query);

?>
								<ul>
									<li class="icons">
										<a href="<?php echo vam_href_link(FILENAME_ORDERS, 'status='.DEFAULT_ORDERS_STATUS_ID, 'NONSSL'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo (($orders_pending['count'] > 0) ? TEXT_SUMMARY_PENDING_ORDERS.': '.$orders_pending['count'] : BOX_ORDERS) ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
											<?php echo (($orders_pending['count'] > 0) ? ' <span class="vamshop-menu-badge badge-danger">'.$orders_pending['count'].'</span>' : '') ?>
										</a>
									</li>
									<li class="icons">
										<a href="<?php echo vam_href_link(FILENAME_CUSTOMERS, '', 'NONSSL'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo BOX_CUSTOMERS; ?>"><i class="fas fa-users" aria-hidden="true"></i>
										</a>
									</li>
									<li class="icons">
										<a href="<?php echo vam_href_link(FILENAME_CATEGORIES, '', 'NONSSL'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo BOX_CATEGORIES; ?>"><i class="fa fa-book" aria-hidden="true"></i>
										</a>
									</li>
									<li class="icons">
										<a href="<?php echo vam_href_link(FILENAME_CONTENT_MANAGER, '', 'NONSSL'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo TEXT_HEADER_PAGES; ?>"><i class="far fa-file-alt" aria-hidden="true"></i>
										</a>
									</li>
									<li class="icons">
										<a href="<?php echo vam_href_link(FILENAME_ARTICLES, '', 'NONSSL'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo TEXT_HEADER_ARTICLES; ?>"><i class="far fa-newspaper" aria-hidden="true"></i>
										</a>
									</li>
									<li class="icons">
										<a href="<?php echo vam_href_link(FILENAME_LATEST_NEWS, '', 'NONSSL'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo TEXT_HEADER_NEWS; ?>"><i class="fa fa-rss" aria-hidden="true"></i>
										</a>
									</li>
									<li class="icons">
										<a href="<?php echo vam_href_link(FILENAME_CACHE, 'action=unlink', 'NONSSL'); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo TEXT_CLEAR_CACHE; ?>"><i class="fa fa-trash-alt" aria-hidden="true"></i>
										</a>
									</li>
									<li class="icons">
										<a href="<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo TEXT_HEADER_SHOP; ?>"><i class="fa fa-store" aria-hidden="true"></i>
										</a>
									</li>
									<li class="icons">
										<a href="https://vamshop.ru" data-toggle="tooltip" data-placement="bottom" title="<?php echo TEXT_HEADER_SUPPORT; ?>"><i class="fas fa-question-circle" aria-hidden="true"></i>
										</a>
									</li>
								</ul>
							</div>
							<div class="vamshop-menu-rr-header">
								<ul>
									<li class="icons">
										<a href="../logoff.php" data-toggle="tooltip" data-placement="bottom" title="<?php echo BOX_HEADING_LOGOFF; ?>">
											<i class="fas fa-power-off" aria-hidden="true"></i>
										</a>
									</li> 
								</ul>
							</div>
						</div>
					</div>
				</header>
<?php } ?>									
				<div class="vamshop-menu-main-container"> 
						<nav class="vamshop-menu-navbar">  
						<div class="vamshop-menu-wrapper">
							<div class="vamshop-menu-inner-navbar">
								<ul class="vamshop-menu-item vamshop-menu-left-item">
									<li class="">
										<a href="<?php echo vam_href_link(FILENAME_START, '', 'NONSSL'); ?>">
											<span class="vamshop-menu-micon"><i class="fas fa-home"></i></span>
											<span class="vamshop-menu-mtext"><?php echo TEXT_HEADER_DEFAULT; ?></span>
											<span class="vamshop-menu-mcaret"></span>
										</a>
									</li>
									
                <li class="vamshop-menu-hasmenu"><a href="javascript:void(0)" ><span class="vamshop-menu-micon"><i class="fas fa-shopping-cart"></i></span><span class="vamshop-menu-mtext"><?php echo BOX_HEADING_ORDERS; ?></span>
											<span class="vamshop-menu-mcaret"></span>
										</a>
										<ul class="vamshop-menu-submenu">
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['orders'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_ORDERS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_ORDERS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['exportorders'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_EXPORTORDERS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BUTTON_ORDERS_EXPORT  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['recover_cart_sales'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_RECOVER_CART_SALES) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_TOOLS_RECOVER_CART  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['orders_status'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_ORDERS_STATUS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_ORDERS_STATUS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (ACTIVATE_SHIPPING_STATUS=='true') {
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['shipping_status'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_SHIPPING_STATUS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_SHIPPING_STATUS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  }

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['orders'] == '0') && 
 ($admin_access['exportorders'] == '0') && 
 ($admin_access['recover_cart_sales'] == '0') && 
 ($admin_access['orders_status'] == '0') && 
 ($admin_access['shipping_status'] == '0')
 ) echo '<li class=" "><a href=""><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . TEXT_ACCESS_FORBIDDEN . '</span><span class="vamshop-menu-mcaret"></span></a></li>'; 

?>
                                										</ul>
									</li> 
                <li class="vamshop-menu-hasmenu"><a href="javascript:void(0)"><span class="vamshop-menu-micon"><i class="fas fa-chart-line"></i></span><span class="vamshop-menu-mtext"><?php echo BOX_HEADING_MARKETING; ?></span>
											<span class="vamshop-menu-mcaret"></span>
										</a>
										<ul class="vamshop-menu-submenu">  

<?php
  $admin_access_query = vam_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . $_SESSION['customer_id'] . "'");
  $admin_access = vam_db_fetch_array($admin_access_query); 
?>
                                
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['specials'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_SPECIALS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_SPECIALS . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['category_specials'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . TEXT_CATEGORY_DISCOUNT . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['manufacturer_specials'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MANUFACTURER_SPECIALS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . TEXT_MANUFACTURER_DISCOUNT . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['featured'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_FEATURED, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_FEATURED . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal&module=ot_discountpayment', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_1 . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal&module=ot_discountshipping', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_2 . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal&module=ot_surcharge', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_3 . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal&module=ot_surchargeshipping', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_4 . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal&module=ot_lev_discount', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_5 . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal&module=ot_discount_quant', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_6 . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CUSTOMERS, 'cID=1&action=edit', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_7 . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CUSTOMERS, 'cID=1&action=edit', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_8 . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="http://manual.vamshop.ru/ch07.html#idp19112040"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_9 . '</span><span class="vamshop-menu-mcaret"></span></a></li>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="http://manual.vamshop.ru/ch07s02.html"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_10 . '</span><span class="vamshop-menu-mcaret"></span></a></li>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="http://manual.vamshop.ru/ch07s03.html"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_11 . '</span><span class="vamshop-menu-mcaret"></span></a></li>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="http://manual.vamshop.ru/ch07s04.html"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_12 . '</span><span class="vamshop-menu-mcaret"></span></a></li>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="http://manual.vamshop.ru/ch05s03.html#idp16858336"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_13 . '</span><span class="vamshop-menu-mcaret"></span></a></li>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="http://manual.vamshop.ru/ch09s02.html"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_14 . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="http://manual.vamshop.ru/ch09.html"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_15 . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="http://manual.vamshop.ru/ch10.html"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MERKETING_16 . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['module_newsletter'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MODULE_NEWSLETTER) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MODULE_NEWSLETTER . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['ship2pay'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_SHIP2PAY) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_MODULES_SHIP2PAY . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['recover_cart_sales'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_RECOVER_CART_SALES) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_TOOLS_RECOVER_CART . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['specials'] == '0') && 
 ($admin_access['category_specials'] == '0') && 
 ($admin_access['manufacturer_specials'] == '0') && 
 ($admin_access['featured'] == '0') && 
 ($admin_access['modules'] == '0') && 
 ($admin_access['module_newsletter'] == '0') && 
 ($admin_access['ship2pay'] == '0') && 
 ($admin_access['recover_cart_sales'] == '0')
 ) echo '<li class=" "><a href=""><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . TEXT_ACCESS_FORBIDDEN . '</span><span class="vamshop-menu-mcaret"></span></a></li>'; 

?>

										</ul>
									</li>
                <li class="vamshop-menu-hasmenu"><a href="javascript:void(0)"><span class="vamshop-menu-micon"><i class="fas fa-book"></i></span><span class="vamshop-menu-mtext"><?php echo BOX_HEADING_CATALOG; ?></span>
											<span class="vamshop-menu-mcaret"></span>
										</a>
										<ul class="vamshop-menu-submenu">  
<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['categories'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CATEGORIES, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CATEGORIES  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_options'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_PRODUCTS_OPTIONS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_attributes'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_PRODUCTS_ATTRIBUTES, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_PRODUCTS_ATTRIBUTES  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['new_attributes'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_NEW_ATTRIBUTES, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_ATTRIBUTES_MANAGER  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['manufacturers'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MANUFACTURERS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_MANUFACTURERS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['reviews'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_REVIEWS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_REVIEWS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['site_reviews'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_SITE_REVIEWS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_SITE_REVIEWS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['company_reviews'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_COMPANY_REVIEWS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_COMPANY_REVIEWS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['article_reviews'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_ARTICLE_REVIEWS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_ARTICLE_REVIEWS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['author_reviews'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_AUTHOR_REVIEWS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_AUTHOR_REVIEWS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['specials'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_SPECIALS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_SPECIALS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['category_specials'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  TEXT_CATEGORY_DISCOUNT  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['manufacturer_specials'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MANUFACTURER_SPECIALS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  TEXT_MANUFACTURER_DISCOUNT  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['featured'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_FEATURED, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_FEATURED  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_specifications'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_PRODUCTS_SPECIFICATIONS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CATALOG_PRODUCTS_SPECIFICATIONS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['pin_loader'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_PIN_LOADER, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CATALOG_PIN_LOADER  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";

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
 ) echo '<li class=" "><a href=""><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . TEXT_ACCESS_FORBIDDEN . '</span><span class="vamshop-menu-mcaret"></span></a></li>'; 

?>
                                										</ul>
                                									</li>

                <li class="vamshop-menu-hasmenu"><a href="javascript:void(0)" ><span class="vamshop-menu-micon"><i class="fas fa-users"></i></span><span class="vamshop-menu-mtext"><?php echo BOX_HEADING_CUSTOMERS; ?></span>
											<span class="vamshop-menu-mcaret"></span>
										</a>
										<ul class="vamshop-menu-submenu">
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customers'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CUSTOMERS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CUSTOMERS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customers_status'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CUSTOMERS_STATUS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CUSTOMERS_STATUS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['customers'] == '0') && 
 ($admin_access['customers_status'] == '0')  
 ) echo '<li class=" "><a href=""><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . TEXT_ACCESS_FORBIDDEN . '</span><span class="vamshop-menu-mcaret"></span></a></li>'; 

?>
                                										</ul>
									</li>
                <li class="vamshop-menu-hasmenu"><a href="javascript:void(0)" ><span class="vamshop-menu-micon"><i class="fas fa-plug"></i></span><span class="vamshop-menu-mtext"><?php echo BOX_HEADING_MODULES; ?></span>
											<span class="vamshop-menu-mcaret"></span>
										</a>
										<ul class="vamshop-menu-submenu">
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MODULES, 'set=payment', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_PAYMENT  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MODULES, 'set=shipping', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_SHIPPING  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['modules'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MODULES, 'set=ordertotal', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_ORDER_TOTAL  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['module_export'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MODULE_EXPORT) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_MODULE_EXPORT  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['cip_manager'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CIP_MANAGER) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONTRIBUTION_INSTALLER  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['ship2pay'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_SHIP2PAY) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_MODULES_SHIP2PAY  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['modules'] == '0') && 
 ($admin_access['module_export'] == '0') && 
 ($admin_access['cip_manager'] == '0') && 
 ($admin_access['ship2pay'] == '0')
 ) echo '<li class=" "><a href=""><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . TEXT_ACCESS_FORBIDDEN . '</span><span class="vamshop-menu-mcaret"></span></a></li>'; 

?>
                                										</ul>
									</li>

									<li class="vamshop-menu-hasmenu">
										<a href="javascript:void(0)">
											<span class="vamshop-menu-micon"><i class="fas fa-tools"></i></span>
											<span class="vamshop-menu-mtext"><?php echo BOX_HEADING_OTHER; ?></span>
											<span class="vamshop-menu-mcaret"></span>
										</a>
										<ul class="vamshop-menu-submenu">
											<li class=" vamshop-menu-hasmenu">
												<a href="javascript:void(0)">
													<span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span>
													<span class="vamshop-menu-mtext"><?php echo BOX_HEADING_TOOLS; ?></span>
													<span class="vamshop-menu-mcaret"></span>
												</a>
												<ul class="vamshop-menu-submenu">
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['backup'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_BACKUP) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_BACKUP  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['product_extra_fields'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_PRODUCT_EXTRA_FIELDS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['customer_extra_fields'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_EXTRA_FIELDS) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_HEADING_CUSTOMER_EXTRA_FIELDS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['content_manager'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONTENT_MANAGER) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONTENT  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['module_newsletter'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_MODULE_NEWSLETTER) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_MODULE_NEWSLETTER  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['banner_manager'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_BANNER_MANAGER) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_BANNER_MANAGER  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['server_info'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_SERVER_INFO) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_SERVER_INFO  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['latest_news'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_LATEST_NEWS) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CATALOG_LATEST_NEWS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['faq'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_FAQ) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CATALOG_FAQ  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['whos_online'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_WHOS_ONLINE) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_WHOS_ONLINE  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['easypopulate'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_EASYPOPULATE, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_EASY_POPULATE  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['yml_import'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_YML_IMPORT, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_YML_IMPORT  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['quick_updates'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_QUICK_UPDATES, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CATALOG_QUICK_UPDATES  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['email_manager'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_EMAIL_MANAGER) . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_TOOLS_EMAIL_MANAGER  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";

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
 ) echo '<li class=" "><a href="">' . TEXT_ACCESS_FORBIDDEN . '</span><span class="vamshop-menu-mcaret"></span></a></li>'; 

?>
												</ul>
											</li>
											<li class=" vamshop-menu-hasmenu">
												<a href="javascript:void(0)">
													<span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span>
													<span class="vamshop-menu-mtext"><?php echo BOX_HEADING_LOCATION_AND_TAXES; ?></span>
													<span class="vamshop-menu-mcaret"></span>
												</a>
												<ul class="vamshop-menu-submenu">
<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['countries'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_COUNTRIES, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_COUNTRIES  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['zones'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_ZONES, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_ZONES  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['geo_zones'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_GEO_ZONES, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_GEO_ZONES  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['tax_classes'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_TAX_CLASSES, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_TAX_CLASSES  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['tax_rates'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_TAX_RATES, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_TAX_RATES  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['countries'] == '0') && 
 ($admin_access['zones'] == '0') && 
 ($admin_access['geo_zones'] == '0') &&
 ($admin_access['tax_classes'] == '0') &&
 ($admin_access['tax_rates'] == '0')
 ) echo '<li class=" "><a href="">' . TEXT_ACCESS_FORBIDDEN . '</span><span class="vamshop-menu-mcaret"></span></a></li>'; 
 
?>
												</ul>
											</li>
											<li class=" vamshop-menu-hasmenu">
												<a href="javascript:void(0)">
													<span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span>
													<span class="vamshop-menu-mtext"><?php echo BOX_HEADING_LOCALIZATION; ?></span>
													<span class="vamshop-menu-mcaret"></span>
												</a>
												<ul class="vamshop-menu-submenu">
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['currencies'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CURRENCIES, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CURRENCIES  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['languages'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_LANGUAGES, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_LANGUAGES  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['currencies'] == '0') && 
 ($admin_access['languages'] == '0')
 ) echo '<li class=" "><a href="">' . TEXT_ACCESS_FORBIDDEN . '</span><span class="vamshop-menu-mcaret"></span></a></li>'; 
 
?>
												</ul>
											</li>
											<li class=" vamshop-menu-hasmenu">
												<a href="javascript:void(0)">
													<span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span>
													<span class="vamshop-menu-mtext"><?php echo BOX_HEADING_GV_ADMIN; ?></span>
													<span class="vamshop-menu-mcaret"></span>
												</a>
												<ul class="vamshop-menu-submenu">
<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['coupon_admin'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_COUPON_ADMIN, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_COUPON_ADMIN  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_queue'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_GV_QUEUE, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_GV_ADMIN_QUEUE  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_mail'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_GV_MAIL, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_GV_ADMIN_MAIL  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['gv_sent'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_GV_SENT, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_GV_ADMIN_SENT  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['coupon_admin'] == '0') && 
 ($admin_access['gv_queue'] == '0') && 
 ($admin_access['gv_mail'] == '0') && 
 ($admin_access['gv_sent'] == '0')
 ) echo '<li class=" "><a href="">' . TEXT_ACCESS_FORBIDDEN . '</span><span class="vamshop-menu-mcaret"></span></a></li>'; 

?>
												</ul>
											</li>
											<li class=" vamshop-menu-hasmenu">
												<a href="javascript:void(0)">
													<span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span>
													<span class="vamshop-menu-mtext"><?php echo BOX_HEADING_STATISTICS; ?></span>
													<span class="vamshop-menu-mcaret"></span>
												</a>
												<ul class="vamshop-menu-submenu">
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_products_viewed'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_STATS_PRODUCTS_VIEWED, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_PRODUCTS_VIEWED  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_products_purchased'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_STATS_PRODUCTS_PURCHASED, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_PRODUCTS_PURCHASED  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['stats_customers'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_STATS_CUSTOMERS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_STATS_CUSTOMERS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['stats_products_viewed'] == '0') && 
 ($admin_access['stats_products_purchased'] == '0') && 
 ($admin_access['stats_sales_report'] == '0') && 
 ($admin_access['stats_sales_report2'] == '0') && 
 ($admin_access['stats_campaigns'] == '0')
 ) echo '<li class=" "><a href="">' . TEXT_ACCESS_FORBIDDEN . '</span><span class="vamshop-menu-mcaret"></span></a></li>'; 

?>
												</ul>
											</li>
											<li class=" vamshop-menu-hasmenu">
												<a href="javascript:void(0)">
													<span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span>
													<span class="vamshop-menu-mtext"><?php echo BOX_HEADING_ARTICLES; ?></span>
													<span class="vamshop-menu-mcaret"></span>
												</a>
												<ul class="vamshop-menu-submenu">
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['articles'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_ARTICLES, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_TOPICS_ARTICLES  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['articles_config'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_ARTICLES_CONFIG, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_ARTICLES_CONFIG  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['authors'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_AUTHORS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_ARTICLES_AUTHORS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['articles_xsell'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_ARTICLES_XSELL, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_ARTICLES_XSELL  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['articles'] == '0') && 
 ($admin_access['articles_config'] == '0') && 
 ($admin_access['authors'] == '0') && 
 ($admin_access['articles_xsell'] == '0')
 ) echo '<li class=" "><a href="">' . TEXT_ACCESS_FORBIDDEN . '</span><span class="vamshop-menu-mcaret"></span></a></li>'; 

?>
												</ul>
											</li>
											<li class=" vamshop-menu-hasmenu">
												<a href="javascript:void(0)">
													<span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span>
													<span class="vamshop-menu-mtext"><?php echo BOX_HEADING_AFFILIATE; ?></span>
													<span class="vamshop-menu-mcaret"></span>
												</a>
												<ul class="vamshop-menu-submenu">
<?php

  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=28', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_AFFILIATE_CONFIGURATION  . '</span><span class="vamshop-menu-mcaret"></span></a></li>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_affiliates'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_AFFILIATE, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_AFFILIATE  . '</span><span class="vamshop-menu-mcaret"></span></a></li>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_banners'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_AFFILIATE_BANNERS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_AFFILIATE_BANNERS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_clicks'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_AFFILIATE_CLICKS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_AFFILIATE_CLICKS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_contact'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_AFFILIATE_CONTACT, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_AFFILIATE_CONTACT  . '</span><span class="vamshop-menu-mcaret"></span></a></li>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_payment'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_AFFILIATE_PAYMENT, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_AFFILIATE_PAYMENT  . '</span><span class="vamshop-menu-mcaret"></span></a></li>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_sales'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_AFFILIATE_SALES, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_AFFILIATE_SALES  . '</span><span class="vamshop-menu-mcaret"></span></a></li>';
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_summary'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_AFFILIATE_SUMMARY  . '</span><span class="vamshop-menu-mcaret"></span></a></li>';

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['configuration'] == '0') && 
 ($admin_access['affiliate_affiliates'] == '0') && 
 ($admin_access['affiliate_banners'] == '0') && 
 ($admin_access['affiliate_clicks'] == '0') && 
 ($admin_access['affiliate_contact'] == '0') && 
 ($admin_access['affiliate_payment'] == '0') && 
 ($admin_access['affiliate_sales'] == '0') && 
 ($admin_access['affiliate_summary'] == '0')
 ) echo '<li class=" "><a href="">' . TEXT_ACCESS_FORBIDDEN . '</span><span class="vamshop-menu-mcaret"></span></a></li>'; 

?>
												</ul>
											</li>
										</ul>
									</li> 									
									<li class="vamshop-menu-hasmenu">
										<a href="javascript:void(0)">
											<span class="vamshop-menu-micon"><i class="fas fa-sliders-h"></i></span>
											<span class="vamshop-menu-mtext"><?php echo BOX_HEADING_CONFIGURATION; ?></span>
											<span class="vamshop-menu-mcaret"></span>
										</a>
										<ul class="vamshop-menu-submenu">
											<li class=" vamshop-menu-hasmenu">
												<a href="javascript:void(0)">
													<span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span>
													<span class="vamshop-menu-mtext"><?php echo BOX_HEADING_CONFIGURATION_MAIN; ?></span>
													<span class="vamshop-menu-mcaret"></span>
												</a>
												<ul class="vamshop-menu-submenu">
<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=1', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_1  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=100', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_100  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=2', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_2  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=3', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_3  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=4', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_4  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=5', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_5  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=6', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_6  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=7', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_7  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=8', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_8  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=9', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_9  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=10', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_10  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=11', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_11  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['cache'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CACHE, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CACHE_FILES  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=12', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_12  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=13', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_13  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=14', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_14  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=15', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_15  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=18', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_18  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=20', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_20  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
//  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=21', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_21  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=22', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_22  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=24', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_24  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['configuration'] == '0')
 ) echo '<li class=" "><a href="">' . TEXT_ACCESS_FORBIDDEN . '</span><span class="vamshop-menu-mcaret"></span></a></li>'; 
?>  
												</ul>
											</li>
											<li class=" vamshop-menu-hasmenu">
												<a href="javascript:void(0)">
													<span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span>
													<span class="vamshop-menu-mtext"><?php echo BOX_HEADING_OTHER; ?></span>
													<span class="vamshop-menu-mcaret"></span>
												</a>
												<ul class="vamshop-menu-submenu">
<?php
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['products_vpe'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_PRODUCTS_VPE, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_PRODUCTS_VPE  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['campaigns'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CAMPAIGNS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CAMPAIGNS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['cross_sell_groups'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_XSELL_GROUPS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_ORDERS_XSELL_GROUP  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['answer_templates'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_ANSWER_TEMPLATES, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_ANSWER_TEMPLATES  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['product_labels'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_PRODUCT_LABELS, '', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_PRODUCT_LABELS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=19', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_19  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=23', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_23  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=25', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_25  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=27', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_27  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=72', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_72  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=80', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_80  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=1610', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_1610  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=90', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_90  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=17', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_17  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=16', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_16  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<li class=" "><a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=29', 'NONSSL') . '"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' .  BOX_CONFIGURATION_29  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";

 if (($_SESSION['customers_status']['customers_status_id'] == '0') && 
 ($admin_access['products_vpe'] == '0') && 
 ($admin_access['campaigns'] == '0') && 
 ($admin_access['configuration'] == '0') && 
 ($admin_access['cross_sell_groups'] == '0')
 ) echo '<li class=" "><a href="">' . TEXT_ACCESS_FORBIDDEN . '</span><span class="vamshop-menu-mcaret"></span></a></li>'; 
?>
												</ul>
											</li>
										</ul>
									</li> 									

<!--                <li class="vamshop-menu-hasmenu"><a href="javascript:void(0)"><span class="vamshop-menu-micon"><i class="fas fa-question"></i></span><span class="vamshop-menu-mtext"><?php echo BOX_HEADING_HELP; ?></span>
											<span class="vamshop-menu-mcaret"></span>
										</a>
										<ul class="vamshop-menu-submenu">  
<?php

  echo '<li class=" "><a href="https://vamshop.ru" target="_blank"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_SUPPORT_SITE  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  echo '<li class=" "><a href="https://vamshop.ru/contact_us.html" target="_blank"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . HEADER_TITLE_ASK_A_QUESTION  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  echo '<li class=" "><a href="http://manual.vamshop.ru/" target="_blank"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . HEADER_TITLE_DOCS  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  echo '<li class=" "><a href="https://forum.vamshop.ru/forum/26-faq/" target="_blank"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_SUPPORT_FAQ  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";
  echo '<li class=" "><a href="https://forum.vamshop.ru/" target="_blank"><span class="vamshop-menu-micon"><i class="fas fa-angle-right"></i></span><span class="vamshop-menu-mtext">' . BOX_SUPPORT_FORUM  . '</span><span class="vamshop-menu-mcaret"></span></a></li>' . "\n";

?>
										</ul>
									</li>
									 
									<li class=" ">
										<a href="<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>">
											<span class="vamshop-menu-micon"><i class="fas fa-store"></i></span>
											<span class="vamshop-menu-mtext"><?php echo HEADER_TITLE_ONLINE_CATALOG; ?></span>
											<span class="vamshop-menu-mcaret"></span>
										</a> 
									</li>
									<li class=" ">
										<a href="../logoff.php">
											<span class="vamshop-menu-micon"><i class="fas fa-power-off"></i></span>
											<span class="vamshop-menu-mtext"><?php echo BOX_HEADING_LOGOFF; ?></span>
											<span class="vamshop-menu-mcaret"></span>
										</a>  
									</li>   
-->								</ul> 		
<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'true') { ?>
<?php

  $total_orders_query = vam_db_query("select count(*) as count from " . TABLE_ORDERS);
  $total_orders = vam_db_fetch_array($total_orders_query);

  $orders_pending_query = vam_db_query("select count(*) as count from " . TABLE_ORDERS . " where orders_status = '" . DEFAULT_ORDERS_STATUS_ID . "'");
  $orders_pending = vam_db_fetch_array($orders_pending_query);

  $total_sales_query = vam_db_query("SELECT sum(ot.value) as value, avg(ot.value) as avg, count(ot.value) as count FROM " . TABLE_ORDERS_TOTAL . " ot, " . TABLE_ORDERS . " o WHERE ot.orders_id = o.orders_id and ot.class = 'ot_subtotal'");
  $total_sales = vam_db_fetch_array($total_sales_query);

  $customers_query = vam_db_query("select count(*) as count from " . TABLE_CUSTOMERS);
  $customers = vam_db_fetch_array($customers_query);

?>
<!--
								<ul class="vamshop-menu-item vamshop-menu-right-item">
									<li class=" ">
										<a href="<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>">
											<span class="vamshop-menu-micon"><i class="fas fa-store"></i></span>
											<span class="vamshop-menu-mtext"><?php echo HEADER_TITLE_ONLINE_CATALOG; ?></span>
											<span class="vamshop-menu-mcaret"></span>
										</a> 
									</li>
									<li class=" ">
										<a href="../logoff.php">
											<span class="vamshop-menu-micon"><i class="fas fa-power-off"></i></span>
											<span class="vamshop-menu-mtext"><?php echo BOX_HEADING_LOGOFF; ?></span>
											<span class="vamshop-menu-mcaret"></span>
										</a>  
									</li>   
								</ul>
-->
<?php } ?>
							</div> 
						</nav> 
					<div class="vamshop-menu-content">
						<div class="vamshop-menu-wrapper">
							<div class="vamshop-menu-inner-content">
								<div class="row">
									<div class="col-md-12">	