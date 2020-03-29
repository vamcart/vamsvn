<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_statistics.php,v 1.1 2003/12/21 20:13:07 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_statistics.php, v 1.9 2003/07/13);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $affiliate_banner_history_raw = "select sum(affiliate_banners_shown) as count from " . TABLE_AFFILIATE_BANNERS_HISTORY .  " where affiliate_banners_affiliate_id  = '" .  $_GET['acID'] . "'";
  $affiliate_banner_history_query = vam_db_query($affiliate_banner_history_raw);
  $affiliate_banner_history = vam_db_fetch_array($affiliate_banner_history_query);
  $affiliate_impressions = $affiliate_banner_history['count'];
  if ($affiliate_impressions == 0) $affiliate_impressions = "n/a"; 
  
  $affiliate_query = vam_db_query("select * from " . TABLE_AFFILIATE . " where affiliate_id ='" . $_GET['acID'] . "'");
 
  $affiliate = vam_db_fetch_array($affiliate_query);
  $affiliate_percent = 0;
  $affiliate_percent = $affiliate['affiliate_commission_percent'];
  if ($affiliate_percent < AFFILIATE_PERCENT) $affiliate_percent = AFFILIATE_PERCENT;
  
  $affiliate_clickthroughs_raw = "select count(*) as count from " . TABLE_AFFILIATE_CLICKTHROUGHS . " where affiliate_id = '" . $_GET['acID'] . "'";
  $affiliate_clickthroughs_query = vam_db_query($affiliate_clickthroughs_raw);
  $affiliate_clickthroughs = vam_db_fetch_array($affiliate_clickthroughs_query);
  $affiliate_clickthroughs = $affiliate_clickthroughs['count'];

  $affiliate_sales_raw = "
    select count(*) as count, sum(affiliate_value) as total, sum(affiliate_payment) as payment from " . TABLE_AFFILIATE_SALES . " a 
    left join " . TABLE_ORDERS . " o on (a.affiliate_orders_id=o.orders_id) 
    where a.affiliate_id = '" . $_GET['acID'] . "' and o.orders_status >= " . AFFILIATE_PAYMENT_ORDER_MIN_STATUS . "
    ";
  $affiliate_sales_query = vam_db_query($affiliate_sales_raw);
  $affiliate_sales = vam_db_fetch_array($affiliate_sales_query);

  $affiliate_transactions=$affiliate_sales['count'];
  if ($affiliate_clickthroughs > 0) {
	  $affiliate_conversions = vam_round(($affiliate_transactions / $affiliate_clickthroughs)*100,2) . "%";
  } else {
    $affiliate_conversions = "n/a";
  }

  if ($affiliate_sales['total'] > 0) {
    $affiliate_average = $affiliate_sales['total'] / $affiliate_sales['count'];
  } else {
    $affiliate_average = 0;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset="<?php echo $_SESSION['language_charset']; ?>">
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

        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><a class="button" href="<?php echo MANUAL_LINK_AFFILIATE; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>
        
        </td>
      </tr>

  <tr>
<!-- body_text //-->
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TEXT_SUMMARY_TITLE; ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellpadding="4" cellspacing="2" class="dataTableContent">
              <center>
                <tr>
                  <td width="35%" align="right" class="dataTableContent"><b><?php echo TEXT_AFFILIATE_NAME; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td width="15%" class="dataTableContent"><?php echo $affiliate['affiliate_firstname'] . ' ' . $affiliate['affiliate_lastname']; ?></td>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_AFFILIATE_JOINDATE; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                  <td width="15%" class="dataTableContent"><?php echo vam_date_short($affiliate['affiliate_date_account_created']); ?></td>
                </tr>
                <tr>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_IMPRESSIONS; ?><?php echo '<a href="javascript:popupWindow(\'' . (HTTP_SERVER . DIR_WS_CATALOG . FILENAME_AFFILIATE_HELP_1) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="dataTableContent"><?php echo $affiliate_impressions; ?></td>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_VISITS; ?><?php echo '<a href="javascript:popupWindow(\'' . (HTTP_SERVER . DIR_WS_CATALOG . FILENAME_AFFILIATE_HELP_2) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="dataTableContent"><?php echo $affiliate_clickthroughs; ?></td>
                </tr>
                <tr>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_TRANSACTIONS; ?><?php echo '<a href="javascript:popupWindow(\'' . (HTTP_SERVER . DIR_WS_CATALOG . FILENAME_AFFILIATE_HELP_3) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="dataTableContent"><?php echo $affiliate_sales['count']; ?></td>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_CONVERSION; ?><?php echo '<a href="javascript:popupWindow(\'' . (HTTP_SERVER . DIR_WS_CATALOG . FILENAME_AFFILIATE_HELP_4) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="dataTableContent"><?php echo $affiliate_conversions.' %';?></td>
                </tr>
                <tr>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_AMOUNT; ?><?php echo '<a href="javascript:popupWindow(\'' . (HTTP_SERVER . DIR_WS_CATALOG . FILENAME_AFFILIATE_HELP_5) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="dataTableContent"><?php echo $currencies->display_price($affiliate_sales['total'], ''); ?></td>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_AVERAGE; ?><?php echo '<a href="javascript:popupWindow(\'' . (HTTP_SERVER . DIR_WS_CATALOG . FILENAME_AFFILIATE_HELP_6) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="dataTableContent"><?php echo $currencies->display_price($affiliate_average, ''); ?></td>
                </tr>
                <tr>
                  <td width="35%" align="right" class="dataTableContent"><?php echo TEXT_COMMISSION_RATE; ?><?php echo '<a href="javascript:popupWindow(\'' . (HTTP_SERVER . DIR_WS_CATALOG . FILENAME_AFFILIATE_HELP_7) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></td>
                  <td width="15%" class="dataTableContent"><?php echo $affiliate_percent, ' %'; ?></td>
                  <td width="35%" align="right" class="dataTableContent"><b><?php echo TEXT_COMMISSION; ?><?php echo '<a href="javascript:popupWindow(\'' . (HTTP_SERVER . DIR_WS_CATALOG . FILENAME_AFFILIATE_HELP_8) . '\')">' . TEXT_SUMMARY_HELP . '</a>'; ?></b></td>
                  <td width="15%" class="dataTableContent"><b><?php echo $currencies->display_price($affiliate_sales['payment'], ''); ?></b></td>
                </tr>
                <tr>
                  <td colspan="4"><?php echo vam_draw_separator(); ?></td>
                </tr>
                <tr>
                  <td align="center" class="dataTableContent" colspan="4"><b><?php echo TEXT_SUMMARY; ?></b></td>
                </tr>
                <tr>
                  <td colspan="4"><?php echo vam_draw_separator(); ?></td>
                </tr>
                <tr>
                  <td align="right" class="dataTableContent" colspan="4"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_AFFILIATE_CLICKS, 'acID=' . $_GET['acID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12') . '&nbsp;' . IMAGE_CLICKTHROUGHS . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_AFFILIATE_SALES, 'acID=' . $_GET['acID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12') . '&nbsp;' . IMAGE_SALES . '</span></a>'; ?></td>
                </tr>
              </center>
            </table></td>
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
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php');?>
