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
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
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

		<script type="text/javascript" src="../jscript/jquery/plugins/jqplot/jquery.jqplot.js"></script>
		<script type="text/javascript" src="../jscript/jquery/plugins/jqplot/plugins/jqplot.highlighter.min.js"></script>
		<script type="text/javascript" src="../jscript/jquery/plugins/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
		<script type="text/javascript" src="../jscript/jquery/plugins/jqplot/plugins/jqplot.barRenderer.min.js"></script>
		<script type="text/javascript" src="../jscript/jquery/plugins/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
		<link type="text/css" href="../jscript/jquery/plugins/jqplot/jquery.jqplot.min.css" rel="stylesheet" />	


<script>
<?php

  $report = isset($_GET['report']) ? $_GET['report'] : null;
  $report_type = isset($_GET['report_type']) ? $_GET['report_type'] : null;

  require_once(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/'.FILENAME_STATS_SALES_REPORT2);

  require_once(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  // default view (daily)
  $sales_report_default_view = 2;
  // report views (1: hourly 2: daily 3: weekly 4: monthly 5: yearly)
  $sales_report_view = $sales_report_default_view;
  if ( ($_GET['report']) && (vam_not_null($_GET['report'])) ) {
    $sales_report_view = $_GET['report'];
  }
  if ($sales_report_view > 5) {
    $sales_report_view = $sales_report_default_view;
  }

  if ($sales_report_view == 2) {
    $report = 2;
  }

  if ($report == 1) {
    $report_desc = REPORT_TYPE_HOURLY;
  } else if ($report == 2) {
    $report_desc = REPORT_TYPE_DAILY;
  } else if ($report == 3) {
    $report_desc = REPORT_TYPE_WEEKLY;
  } else if ($report == 4) {
    $report_desc = REPORT_TYPE_MONTHLY;
  } else if ($report == 5) {
    $report_desc = REPORT_TYPE_YEARLY;
  }

    $report_desc = BOX_SALES_REPORT . ' ' . $report_desc;

  // check start and end Date
  $startDate = "";
  if ( ($_GET['startDate']) && (vam_not_null($_GET['startDate'])) ) {
    $startDate = $_GET['startDate'];
  }
  $endDate = "";
  if ( ($_GET['endDate']) && (vam_not_null($_GET['endDate'])) ) {
    $endDate = $_GET['endDate'];
  }

  // check filters
  if (($_GET['filter']) && (vam_not_null($_GET['filter']))) {
    $sales_report_filter = $_GET['filter'];
    $sales_report_filter_link = "&filter=$sales_report_filter";
  }

  require_once(DIR_WS_CLASSES . 'sales_report2.php');
  $report = new sales_report($sales_report_view, $startDate, $endDate, $sales_report_filter);

  if (strlen($sales_report_filter) == 0) {
    $sales_report_filter = $report->filter;
    $sales_report_filter_link = "";
  }

$data_count = array();
$data_avg = array();
$data_sum = array();
$data_total = array();
$data_number = array();
for ($i = 0; $i < $report->size; $i++) { 

$data_count[] = $report->info[$i]['count'];
//$data_avg[] = $report->info[$i]['avg'];
$data_sum[] = number_format($report->info[$i]['sum'],0,'','');
$data_total[] = '["'.$report->info[$i]['text']. '",'.number_format($report->info[$i]['sum'],0,'','').']';
$data_number[] = '["'.$report->info[$i]['text']. '",'.number_format($report->info[$i]['count'],0,'','').']';
									
}

$data_date = array();
for ($i = 0; $i < $report->size; $i++) { 

$data_date[] = $report->info[$i]['text'];
									
}

?>
    $(document).ready(function() {
        $.jqplot.config.enablePlugins = true;

        var l1 = [<?php echo implode(",",$data_total); ?>];
        var l2 = [<?php echo implode(",",$data_number); ?>];

        var plot1 = $.jqplot("chart1", [l1, l2],  {
          animate: true,
          animateReplot: true,         	
          title: "<?php echo $report_desc; ?>",
          legend:{show:true,location:"se",labels:["<?php echo TABLE_HEADING_STAT_ORDERS; ?>","<?php echo TABLE_HEADING_CONVERSION; ?>"]},
          series:[
          {color:"#0077cc"},
          {yaxis:"y2axis",color:"#ffb82e"} 
          ],
          axesDefaults:{padMin: 1.5,useSeriesColor:true, rendererOptions: { alignTicks: true}},

      axes: {
        xaxis: {
          renderer: $.jqplot.DateAxisRenderer,
          labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
          tickRenderer: $.jqplot.CanvasAxisTickRenderer,
          tickInterval: "1 day",

          tickOptions: {
             formatString: "%e %b",
             angle: -30,
             textColor: '#000'
          },

           
        },
        y2axis: {
          tickOptions: {
              formatString: "%01.0f"
          }
           
        }
      },

          highlighter: {
          show: true,
          sizeAdjust: 7.5,
          tooltipLocation: "ne"
          },
          
          cursor: {
          show: false
          }          
        });

});
<?php 

  require_once(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/'.FILENAME_STATS_SALES_REPORT2);

  require_once(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  // default view (daily)
  $sales_report_default_view = 2;
  // report views (1: hourly 2: daily 3: weekly 4: monthly 5: yearly)
  $sales_report_view = $sales_report_default_view;
  if ( ($_GET['report']) && (vam_not_null($_GET['report'])) ) {
    $sales_report_view = $_GET['report'];
  }
  if ($sales_report_view > 5) {
    $sales_report_view = $sales_report_default_view;
  }

  if ($sales_report_view == 2) {
    $report = 2;
  }

    $report_desc = BOX_SALES_REPORT . ' ' . REPORT_TYPE_MONTHLY;

  require_once(DIR_WS_CLASSES . 'sales_report2.php');
  $report = new sales_report(4, $startDate, $endDate, $sales_report_filter);

$data_count = array();
$data_sum = array();
$data_total = array();
$data_number = array();
for ($i = 0; $i < $report->size; $i++) { 

$data_count[] = $report->info[$i]['count'];
$data_sum[] = number_format($report->info[$i]['sum'],0,'','');
$data_total[] = '["'.$report->info[$i]['text']. '",'.number_format($report->info[$i]['sum'],0,'','').']';
$data_number[] = '["'.$report->info[$i]['text']. '",'.number_format($report->info[$i]['count'],0,'','').']';
									
}

$data_date = array();
for ($i = 0; $i < $report->size; $i++) { 

$data_date[] = $report->info[$i]['text'];
									
}

?>
    $(document).ready(function() {
        $.jqplot.config.enablePlugins = true;

        var l1 = [<?php echo implode(",",$data_total); ?>];
        var l2 = [<?php echo implode(",",$data_number); ?>];

    plot2 = $.jqplot("chart2", [l1, l2], {
        legend: {
            show: true,
            location:"se"
        },
        // Turns on animatino for all series in this plot.
        animate: true,
        // Will animate plot on calls to plot1.replot({resetAxes:true})
        animateReplot: true,         	
        title: "<?php echo $report_desc; ?>",
        cursor: {
            show: true,
            zoom: true,
            looseZoom: true,
            showTooltip: false
        },
        seriesColors:['#ffb82e','#0077cc'],
        series:[
            {
                label: '<?php echo TABLE_HEADING_CONVERSION; ?>',
                pointLabels: {
                    show: true
                },
                renderer: $.jqplot.BarRenderer,
                showHighlight: true,
                yaxis: 'y2axis',
                rendererOptions: {
                    // Speed up the animation a little bit.
                    // This is a number of milliseconds.  
                    // Default for bar series is 3000.  
                    animation: {
                        speed: 2500
                    },
                    barWidth: 25,
                    barPadding: 0,
                    barMargin: 0,
                    highlightMouseOver: false
                }
            }, 
            {
                label: '<?php echo TABLE_HEADING_STAT_ORDERS; ?>',
                rendererOptions: {
                    // speed up the animation a little bit.
                    // This is a number of milliseconds.
                    // Default for a line series is 2500.
                    animation: {
                        speed: 2000
                    }
                }
            }
        ],
        axesDefaults:{padMin: 1.5,useSeriesColor:true, rendererOptions: { alignTicks: true}},
      axes: {
        xaxis: {
          renderer: $.jqplot.DateAxisRenderer,
          labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
          tickRenderer: $.jqplot.CanvasAxisTickRenderer,
          tickInterval: "1 month",
          tickOptions: {
             formatString: "%b",
             angle: -30,
             textColor: '#000',
          },
        },
        y2axis: {
          tickOptions: {
              formatString: "%01.0f"
          }
           
        }
      },
        highlighter: {
            show: true, 
            showLabel: true, 
            tooltipOffset: 5,
            tooltipAxes: 'y2',
            sizeAdjust: 7.5, 
            tooltipLocation : 'ne'
        }
    });
    
    $('.jqplot-highlighter-tooltip').addClass('panel');
   
});
</script>

		<script type="text/javascript" src="includes/css/bootstrap/bootstrap.min.js"></script>

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

			  
<?php
 
// We'll process this feed with all of the default options.
$url = 'http://blog.vamshop.ru/feed/';
$feed = new SimplePie();

// Set which feed to process.
 $feed->set_cache_location('../cache');
 
// Set which feed to process.
 $feed->set_feed_url($url);

// Run SimplePie.
$feed->init();

$feed->handle_content_type();
 
?>
 
   <ul>
 
	<?php
	/*
	Here, we'll loop through all of the items in the feed, and $item represents the current item in the loop.
	*/
	foreach ($feed->get_items(0,5) as $item):
	?>
 
		<li class="item">
			<h3><strong><a href="<?php echo $item->get_permalink(); ?>" target="_blank"><?php echo $item->get_title(); ?></a></strong></h3>
			<p><?php echo $item->get_description(); ?></p>
		</li>
 
	<?php endforeach; ?>
	
	</ul>

			  
			  
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