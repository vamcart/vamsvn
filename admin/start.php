<?php
/* --------------------------------------------------------------
   $Id: start.php 1235 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project 
   (c) 2002-2003 osCommerce coding standards (a typical file) www.oscommerce.com
   (c) 2003      nextcommerce (start.php,1.5 2004/03/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (start.php,1.5 2004/03/17); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

require ('includes/application_top.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<?php if (ENABLE_TABS == 'true') { ?>
		<link type="text/css" href="../jscript/jquery/plugins/ui/css/smoothness/jquery-ui.css" rel="stylesheet" />	
		<script type="text/javascript" src="../jscript/jquery/jquery.js"></script>
		<script type="text/javascript" src="../jscript/jquery/plugins/ui/jquery-ui-min.js"></script>
		<script type="text/javascript">
			$(function(){
				$('#tabs').tabs({ fx: { opacity: 'toggle', duration: 'fast' } });
				$('#news').tabs({ fx: { opacity: 'toggle', duration: 'fast' } });
				$('#sales').tabs({ fx: { opacity: 'toggle', duration: 'fast' } });
			});
		</script>
<?php } ?>
		<script type="text/javascript" src="../jscript/jquery/plugins/rss/jquery.rss.js"></script>
		<script type="text/javascript" src="includes/css/bootstrap/bootstrap.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function () {
				$("#vamshop-rss").rss("http://blog.vamshop.ru/feed/", {
			          limit: 10
			        })
			});
		</script>

<link rel="stylesheet" type="text/css" href="includes/css/bootstrap/bootstrap.css">
<link rel="stylesheet" type="text/css" href="includes/css/bootstrap/bootstrap-responsive.css">
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'false') { ?>
    <td width="<?php echo BOX_WIDTH; ?>" align="left" valign="top">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </td>
<?php } ?>
<!-- body_text //-->
    <td class="boxCenter" valign="top">
    
        <?php include(DIR_WS_MODULES.FILENAME_SECURITY_CHECK); ?>

      <br />

        <table border="0" width="100%" cellspacing="4" cellpadding="6">
          <tr>
            <td>
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

      <div class="row-fluid">
      <div class="span5">

			<div class="row-fluid">
			<div class="panel panel-default span4">
			  <div class="panel-heading">
			    <h3 class="panel-title"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/orders.png', '', '16', '16'); ?>&nbsp;<?php echo TEXT_SUMMARY_TOTAL_ORDERS; ?></h3>
			  </div>
			  <div class="panel-body text-center">
			    <h4><?php echo (($total_orders['count'] > 0) ? $total_orders['count'] : 0) . (($orders_pending['count'] > 0) ? ' <sup><span title="'.TEXT_SUMMARY_PENDING_ORDERS.': '.$orders_pending['count'].'" class="badge badge-important"> <a href="' . vam_href_link(FILENAME_ORDERS, 'status='.DEFAULT_ORDERS_STATUS_ID, 'NONSSL') . '">'.$orders_pending['count'].'</a> </span></sup>' : '') ?></h4>
			  </div>
			</div>
			<div class="panel panel-default span4">
			  <div class="panel-heading">
			    <h3 class="panel-title"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/calculator.png', '', '16', '16'); ?>&nbsp;<?php echo TEXT_SUMMARY_TOTAL_SALES; ?></h3>
			  </div>
			  <div class="panel-body text-center">
			    <h4><?php echo ($total_sales['value'] > 0) ? number_format($total_sales['value'], 0) : 0; ?></h4>
			  </div>
			</div>
			<div class="panel panel-default span4">
			  <div class="panel-heading">
			    <h3 class="panel-title"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/customer.png', '', '16', '16'); ?>&nbsp;<?php echo TEXT_SUMMARY_TOTAL_CUSTOMERS; ?></h3>
			  </div>
			  <div class="panel-body text-center">
			    <h4><?php echo  ($customers['count'] > 0) ? $customers['count'] : 0; ?></h4>
			  </div>
			</div>
			</div>

		<div id="tabs">
			<ul>
				<li><a href="#orders"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/orders.png', '', '16', '16'); ?>&nbsp;<?php echo TEXT_SUMMARY_ORDERS; ?></a></li>
				<li><a href="#customers"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/customer.png', '', '16', '16'); ?>&nbsp;<?php echo TEXT_SUMMARY_CUSTOMERS; ?></a></li>
				<li><a href="#products"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/products.png', '', '16', '16'); ?>&nbsp;<?php echo TEXT_SUMMARY_PRODUCTS; ?></a></li>
			</ul>
			<div id="orders">
			<?php include(DIR_WS_MODULES . 'summary/orders.php'); ?>
			</div>
			<div id="customers">
			<?php include(DIR_WS_MODULES . 'summary/customers.php'); ?>
			</div>
			<div id="products">
			<?php include(DIR_WS_MODULES . 'summary/products.php'); ?>
			</div>
		</div>
      </div>
      <div class="span4">
		<div id="sales">
			<ul>
				<li><a href="#stat"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/stat.png', '', '16', '16'); ?>&nbsp;<?php echo TEXT_SUMMARY_STAT; ?></a></li>
			</ul>
			<div id="stat">
			  <?php include(DIR_WS_MODULES . 'summary/statistics.php'); ?>
			</div>
		</div>
      </div>
      <div class="span3">
		<div id="news">
			<ul>
				<li><a href="#stat"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/comment.png', '', '16', '16'); ?>&nbsp;<?php echo TEXT_SUMMARY_VAMSHOP_NEWS; ?></a></li>
			</ul>
			<div id="rss-news">
			  <div id="vamshop-rss"></div>
			</div>
		</div>
      </div>
      </div>

</td>
          </tr>
        </table>
  
<!-- body_text_eof //-->
</td>
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>