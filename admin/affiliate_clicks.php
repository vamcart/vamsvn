<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_clicks.php,v 1.1 2003/12/21 20:13:07 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_clicks.php, v 1.5 2003/02/12);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

  require('includes/application_top.php');

  if ($_GET['acID'] > 0) {
    $affiliate_clickthroughs_raw = "select ac.*, pd.products_name, a.affiliate_firstname, a.affiliate_lastname from " . TABLE_AFFILIATE_CLICKTHROUGHS . " ac left join " . TABLE_PRODUCTS . " p on (p.products_id = ac.affiliate_products_id) left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on (pd.products_id = p.products_id and pd.language_id = '" . $_SESSION['languages_id'] . "') left join " . TABLE_AFFILIATE . " a  on (a.affiliate_id = ac.affiliate_id) where a.affiliate_id = '" . $_GET['acID'] . "' ORDER BY ac.affiliate_clientdate desc";
//	"select * from " . TABLE_AFFILIATE_CLICKTHROUGHS . " where affiliate_id ='" . $_GET['acID'] . "' order by date desc";
    $affiliate_clickthroughs_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $affiliate_clickthroughs_raw, $affiliate_clickthroughs_numrows);
  } else {
    $affiliate_clickthroughs_raw = "select ac.*, pd.products_name, a.affiliate_firstname, a.affiliate_lastname from " . TABLE_AFFILIATE_CLICKTHROUGHS . " ac left join " . TABLE_PRODUCTS . " p on (p.products_id = ac.affiliate_products_id) left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on (pd.products_id = p.products_id and pd.language_id = '" . $_SESSION['languages_id'] . "') left join " . TABLE_AFFILIATE . " a  on (a.affiliate_id = ac.affiliate_id) ORDER BY ac.affiliate_clientdate desc";
    $affiliate_clickthroughs_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $affiliate_clickthroughs_raw, $affiliate_clickthroughs_numrows);
  }
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_AFFILIATE_USERNAME .'/<br>' . TABLE_HEADING_IPADDRESS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ENTRY_DATE .'/<br>' . TABLE_HEADING_REFERRAL_URL; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CLICKED_PRODUCT; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_BROWSER; ?></td>
              </tr>
<?php
  if ($affiliate_clickthroughs_numrows > 0) {
    $affiliate_clickthroughs_values = vam_db_query($affiliate_clickthroughs_raw);
    $number_of_clickthroughs = '0';
    while ($affiliate_clickthroughs = vam_db_fetch_array($affiliate_clickthroughs_values)) {
      $number_of_clickthroughs++;

      if ( ($number_of_clickthroughs / 2) == floor($number_of_clickthroughs / 2) ) {
        echo '                  <tr class="productListing-even">';
      } else {
        echo '                  <tr class="productListing-odd">';
      }
?>
                <td class="dataTableContent"><?php echo $affiliate_clickthroughs['affiliate_firstname'] . " " . $affiliate_clickthroughs['affiliate_lastname']; ?></td>
                <td class="dataTableContent" align="center"><?php echo vam_date_short($affiliate_clickthroughs['affiliate_clientdate']); ?></td>
<?php
      if ($affiliate_clickthroughs['affiliate_products_id'] > 0) $link_to = '<a href="' . vam_catalog_href_link(FILENAME_CATALOG_PRODUCT_INFO, 'products_id=' . $affiliate_clickthroughs['affiliate_products_id']) . '" target="_blank">' . $affiliate_clickthroughs['products_name'] . '</a>';
      else $link_to = "Startpage";
?>
                <td class="dataTableContent"><?php echo $link_to; ?></td>
                <td class="dataTableContent" align="center"><?php echo $affiliate_clickthroughs['affiliate_clientbrowser']; ?></td>
              </tr>
              <tr>
                <td class="dataTableContent"><?php echo $affiliate_clickthroughs['affiliate_clientip']; ?></td>
                <td class="dataTableContent" colspan="3"><?php  echo $affiliate_clickthroughs['affiliate_clientreferer']; ?></td>
              </tr>
              <tr>
                <td class="dataTableContent" colspan="4"><?php echo vam_draw_separator('pixel_black.gif', '100%', '1'); ?></td>
              </tr>
<?php
    }
  } else {
?>
              <tr class="productListing-odd">
                <td colspan="7" class="smallText"><?php echo TEXT_NO_CLICKS; ?></td>
              </tr>
<?php
  }
?>
              <tr>
                <td class="smallText" colspan="7"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $affiliate_clickthroughs_split->display_count($affiliate_clickthroughs_numrows,  MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CLICKS); ?></td>
                    <td class="smallText" align="right"><?php echo $affiliate_clickthroughs_split->display_links($affiliate_clickthroughs_numrows,  MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], vam_get_all_get_params(array('page', 'oID', 'action'))); ?></td>
                  </tr>
                </table></td>
              </tr>
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
