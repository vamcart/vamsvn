<?php
/* --------------------------------------------------------------
   $Id: stats_campaigns.php 1179 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce coding standards; www.oscommerce.com
   (c) 2004	 xt:Commerce (stats_campaigns.php,1.5 2004/03/17); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contribution:

   stats_sales_report (c) Charly Wilhelm  charly@yoshi.ch

   Released under the GNU General Public License
   --------------------------------------------------------------*/

require ('includes/application_top.php');

require (DIR_WS_CLASSES.'currencies.php');
$currencies = new currencies();

require (DIR_WS_CLASSES.'campaigns.php');
$campaign = new campaigns($_GET);

$orders_statuses = array ();
$orders_status_array = array ();
$orders_status_query = vam_db_query("select orders_status_id, orders_status_name from ".TABLE_ORDERS_STATUS." where language_id = '".$_SESSION['languages_id']."'");
while ($orders_status = vam_db_fetch_array($orders_status_query)) {
	$orders_statuses[] = array ('id' => $orders_status['orders_status_id'], 'text' => $orders_status['orders_status_name']);
	$orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
}

$campaigns = array ();
$campaign_query = "SELECT * FROM ".TABLE_CAMPAIGNS;
$campaign_query = vam_db_query($campaign_query);
while ($campaign_data = vam_db_fetch_array($campaign_query)) {
	$campaigns[] = array ('id' => $campaign_data['campaigns_refID'], 'text' => $campaign_data['campaigns_name']);
}

// report views (1: yearly 2: monthly 3: weekly 4: daily)
if (($_GET['report']) && (vam_not_null($_GET['report']))) {
	$srView = $_GET['report'];
}
if ($srView < 1 || $srView > 4) {
	$srView = $srDefaultView;
}

// check start and end Date
$startDate = "";
$startDateG = 0;
if (($_GET['startD']) && (vam_not_null($_GET['startD']))) {
	$sDay = $_GET['startD'];
	$startDateG = 1;
} else {
	$sDay = 1;
}
if (($_GET['startM']) && (vam_not_null($_GET['startM']))) {
	$sMon = $_GET['startM'];
	$startDateG = 1;
} else {
	$sMon = 1;
}
if (($_GET['startY']) && (vam_not_null($_GET['startY']))) {
	$sYear = $_GET['startY'];
	$startDateG = 1;
} else {
	$sYear = date("Y");
}
if ($startDateG) {
	$startDate = mktime(0, 0, 0, $sMon, $sDay, $sYear);
} else {
	$startDate = mktime(0, 0, 0, date("m"), 1, date("Y"));
}

$endDate = "";
$endDateG = 0;
if (($_GET['endD']) && (vam_not_null($_GET['endD']))) {
	$eDay = $_GET['endD'];
	$endDateG = 1;
} else {
	$eDay = 1;
}
if (($_GET['endM']) && (vam_not_null($_GET['endM']))) {
	$eMon = $_GET['endM'];
	$endDateG = 1;
} else {
	$eMon = 1;
}
if (($_GET['endY']) && (vam_not_null($_GET['endY']))) {
	$eYear = $_GET['endY'];
	$endDateG = 1;
} else {
	$eYear = date("Y");
}
if ($endDateG) {
	$endDate = mktime(0, 0, 0, $eMon, $eDay +1, $eYear);
} else {
	$endDate = mktime(0, 0, 0, date("m"), date("d") + 1, date("Y"));
}
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<!--<meta name="viewport" content="initial-scale=1.0, width=device-width" />-->
<meta http-equiv="Content-Type" content="text/html; charset="<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<?php
require (DIR_WS_INCLUDES.'header.php');
?>
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
    <td class="boxCenter" valign="top">
    
    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php

if ($srExp < 1) {
?>
        <tr>
          <td colspan="2">
            <form action="" method="get">
              <table border="0" style="border: 1px solid; border-color: #cccccc;" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="left" rowspan="2" class="menuBoxHeading">
                    <input type="radio" name="report" value="1" <?php if ($srView == 1) echo "checked"; ?>><?php echo REPORT_TYPE_YEARLY; ?><br />
                    <input type="radio" name="report" value="2" <?php if ($srView == 2) echo "checked"; ?>><?php echo REPORT_TYPE_MONTHLY; ?><br />
                    <input type="radio" name="report" value="3" <?php if ($srView == 3) echo "checked"; ?>><?php echo REPORT_TYPE_WEEKLY; ?><br />
                    <input type="radio" name="report" value="4" <?php if ($srView == 4) echo "checked"; ?>><?php echo REPORT_TYPE_DAILY; ?><br />
                  </td>
                  <td class="menuBoxHeading">
<?php echo REPORT_START_DATE; ?><br />
                    <select name="startD" size="1">
<?php

	if ($startDate) {
		$j = date("j", $startDate);
	} else {
		$j = 1;
	}
	for ($i = 1; $i < 32; $i ++) {
?>
                        <option<?php if ($j == $i) echo " selected"; ?>><?php echo $i; ?></option>
<?php

	}
?>
                    </select>
                    <select name="startM" size="1">
<?php

	if ($startDate) {
		$m = date("n", $startDate);
	} else {
		$m = 1;
	}
	for ($i = 1; $i < 13; $i ++) {
?>
                      <option<?php if ($m == $i) echo " selected"; ?> value="<?php echo $i; ?>"><?php echo strftime("%B", mktime(0, 0, 0, $i, 1)); ?></option>
<?php

	}
?>
                    </select>
                    <select name="startY" size="1">
<?php

	if ($startDate) {
		$y = date("Y") - date("Y", $startDate);
	} else {
		$y = 0;
	}
	for ($i = 10; $i >= 0; $i --) {
?>
                      <option<?php if ($y == $i) echo " selected"; ?>><?php echo date("Y") - $i; ?></option>
<?php

	}
?>
                    </select>
                  </td>
                  <td rowspan="2" align="left" class="menuBoxHeading"> <?php echo REPORT_STATUS_FILTER; ?><br /> 
                    <?php echo vam_draw_pull_down_menu('status', array_merge(array(array('id' => '0', 'text' => REPORT_ALL)), $orders_statuses), $_GET['status']); ?> 
                    
                    <br><?php echo REPORT_CAMPAIGN_FILTER; ?><br /> 
<?php echo vam_draw_pull_down_menu('campaign', array_merge(array(array('id' => '0', 'text' => REPORT_ALL)), $campaigns), $_GET['campaign']); ?> 
                    
                    </td>
                  <td rowspan="2" align="left" class="menuBoxHeading"><br />
                  </td>
                  <td rowspan="2" align="left" class="menuBoxHeading"> <br />
                  </td>
                </tr>
                <tr>
                  <td class="menuBoxHeading">
<?php echo REPORT_END_DATE; ?><br />
                    <select name="endD" size="1">
<?php

	if ($endDate) {
		$j = date("j", $endDate -60 * 60 * 24);
	} else {
		$j = date("j");
	}
	for ($i = 1; $i < 32; $i ++) {
?>
                      <option<?php if ($j == $i) echo " selected"; ?>><?php echo $i; ?></option>
<?php

	}
?>
                    </select>
                    <select name="endM" size="1">
<?php

	if ($endDate) {
		$m = date("n", $endDate -60 * 60 * 24);
	} else {
		$m = date("n");
	}
	for ($i = 1; $i < 13; $i ++) {
?>
                      <option<?php if ($m == $i) echo " selected"; ?> value="<?php echo $i; ?>"><?php echo strftime("%B", mktime(0, 0, 0, $i, 1)); ?></option>
<?php

	}
?>
                    </select>
                    <select name="endY" size="1">
<?php

	if ($endDate) {
		$y = date("Y") - date("Y", $endDate -60 * 60 * 24);
	} else {
		$y = 0;
	}
	for ($i = 10; $i >= 0; $i --) {
?>
                      <option<?php if ($y == $i) echo " selected"; ?>><?php

		echo date("Y") - $i;
?></option><?php

	}
?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="5" class="menuBoxHeading" align="right">
                  <?php echo '<span class="button"><button type="submit" value="' . BUTTON_UPDATE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>'; ?>
                  </td>
              </table>
            </form>
          </td>
        </tr>
<?php

} // end of ($srExp < 1)
?>
        <tr>
          <td width=100% valign=top>
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td valign="top">
 <?php

if (count($campaign->result)) {
?>               
                
                
    
    
    
<table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
 
   <tr class="dataTableHeadingRow"> 
    <td class="dataTableHeadingContent" colspan="2" width="25%"><?php echo HEADING_TOTAL; ?></td>
    <td class="dataTableHeadingContent" width="10%">&nbsp;</td>
    <td class="dataTableHeadingContent" width="15%"><?php echo $campaign->total['leads']; ?></td>
    <td class="dataTableHeadingContent" colspan="2" width="30%"><?php echo $campaign->total['sells']; ?></td>
    <td class="dataTableHeadingContent" width="20%"><?php echo $campaign->total['sum']; ?></td>
  </tr>
  <tr class="dataTableHeadingRow"> 
    <td class="dataTableHeadingContent" colspan="2" width="25%">&nbsp;</td>
    <td class="dataTableHeadingContent" width="10%"><?php echo HEADING_HITS; ?></td>
    <td class="dataTableHeadingContent" width="15%"><?php echo HEADING_LEADS; ?></td>
    <td class="dataTableHeadingContent" width="15%"><?php echo HEADING_SELLS; ?></td>
    <td class="dataTableHeadingContent" width="15%"><?php echo HEADING_LATESELLS; ?></td>
    <td class="dataTableHeadingContent" width="20%"><?php echo HEADING_SUM; ?></td>
  </tr>
  
 <?php

	// show campaigns

	for ($n = 0; $n < count($campaign->result); $n ++) {
?>
  
  
  
  
  <tr class="dataTableRow"> 
    <td class="main" colspan="7" style="border-bottom: 2px solid;"><br><?php echo $campaign->result[$n]['text'].' '.TEXT_REFERER .' ('.$campaign->result[$n]['id'].')'; ?></td>
  </tr>
  
  <?php
		// show values
		for ($nn = 0; $nn < count($campaign->result[$n]['result']); $nn ++) {
?>
  
  <tr class="dataTableRow"> 
    <td class="dataTableContent">&nbsp;</td>
    <td class="dataTableContent"><?php echo $campaign->result[$n]['result'][$nn]['range']; ?></td>
    <td class="dataTableContent"><?php echo $campaign->result[$n]['result'][$nn]['hits']; ?></td>
    <td class="dataTableContent"><?php echo $campaign->result[$n]['result'][$nn]['leads'].' ('.$campaign->result[$n]['result'][$nn]['leads_p'].'%)'; ?></td>
    <td class="dataTableContent"><?php echo $campaign->result[$n]['result'][$nn]['sells'].' ('.$campaign->result[$n]['result'][$nn]['sells_p'].'%)'; ?></td>
    <td class="dataTableContent"><?php echo $campaign->result[$n]['result'][$nn]['late_sells'].' ('.$campaign->result[$n]['result'][$nn]['late_sells_p'].'%)'; ?></td>
    <td class="dataTableContent"><?php echo $campaign->result[$n]['result'][$nn]['sum'].' ('.$campaign->result[$n]['result'][$nn]['sum_p'].'%)'; ?></td>
 </tr>
  
  <?php

		}
?>
  
  
    <tr class="dataTableRow"> 
    <td class="dataTableContent"><b><?php echo HEADING_SUM; ?></b></td>
    <td class="dataTableContent">&nbsp;</td>
    <td class="dataTableContent"><b><?php echo $campaign->result[$n]['hits_s']; ?></b></td>
    <td class="dataTableContent"><b><?php echo $campaign->result[$n]['leads_s'].' ('.($campaign->total['leads']> 0 ? ($campaign->result[$n]['leads_s']/$campaign->total['leads']*100):'0').'%)'; ?></b></td>
    <td class="dataTableContent"><b><?php echo $campaign->result[$n]['sells_s'].' ('.($campaign->total['sells']> 0 ? ($campaign->result[$n]['sells_s']/$campaign->total['sells']*100):'0').'%)'; ?></b></td>
    <td class="dataTableContent"><b><?php echo $campaign->result[$n]['late_sells_s'].' ('.($campaign->total['sells']> 0 ? ($campaign->result[$n]['late_sells_s']/$campaign->total['sells']*100):'0').'%)'; ?></b></td>
    <td class="dataTableContent"><b><?php echo $campaign->result[$n]['sum_s'].' ('.($campaign->total['sum_plain']> 0 ? round(($campaign->result[$n]['sum_s']/$campaign->total['sum_plain']*100),0):'0').'%)'; ?></b></td>
  </tr>
  
  
  <?
	}
?>
</table>
<?php } ?>
                &nbsp; </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php


	require (DIR_WS_INCLUDES.'footer.php');
?>
<!-- footer_eof //-->
</body>
</html>
<?php

	require (DIR_WS_INCLUDES.'application_bottom.php');
?>