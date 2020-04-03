<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_invoice.php,v 1.3 2005/05/25 18:20:23 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_invoice.php, v 1.7 2003/02/17);
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

  $payments_query = vam_db_query("select * from " . TABLE_AFFILIATE_PAYMENT . " where affiliate_payment_id = '" . $_GET['pID'] . "'");
  $payments = vam_db_fetch_array($payments_query);

  $affiliate_address['firstname'] = $payments['affiliate_firstname'];
  $affiliate_address['lastname'] = $payments['affiliate_lastname'];
  $affiliate_address['street_address'] = $payments['affiliate_street_address'];
  $affiliate_address['suburb'] = $payments['affiliate_suburb'];
  $affiliate_address['city'] = $payments['affiliate_city'];
  $affiliate_address['state'] = $payments['affiliate_state'];
  $affiliate_address['country'] = $payments['affiliate_country'];
  $affiliate_address['postcode'] = $payments['affiliate_postcode']
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

<!-- body_text //-->
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
    <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td class="pageHeading"><?php echo nl2br(STORE_NAME_ADDRESS); ?></td>
        <td class="pageHeading" align="center"><?php echo HEADING_TITLE; ?></td>
        <td class="pageHeading" align="right"><?php echo vam_image(DIR_WS_IMAGES . 'logo.gif', 'neXTCommerce', '185', '95'); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td><?php echo vam_draw_separator(); ?></td>
      </tr>
      <tr>
        <td valign="top"><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" valign="top"><b><?php echo TEXT_AFFILIATE; ?></b></td>
            <td class="main"><?php echo vam_address_format($payments['affiliate_address_format_id'], $affiliate_address, 1, '&nbsp;', '<br>'); ?></td>
          </tr>
          <tr>
            <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
          </tr>
	      <tr>
             <td class="main"><b><?php echo TEXT_AFFILIATE_PAYMENT; ?></b></td>
             <td class="main">&nbsp;<?php echo $currencies->format($payments['affiliate_payment_total']); ?></td>
          </tr>
          <tr>
             <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
          </tr>
          <tr>
             <td class="main"><b><?php echo TEXT_AFFILIATE_BILLED; ?></b></td>
             <td class="main">&nbsp;<?php echo vam_date_short($payments['affiliate_payment_date']); ?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '20'); ?></td>
  </tr>
  <tr>
    <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDER_ID; ?></td>
        <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ORDER_DATE; ?></td>
        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDER_VALUE; ?></td>
        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_COMMISSION_RATE; ?></td>
        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_COMMISSION_VALUE; ?></td>
      </tr>
<?php
  $affiliate_payment_query = vam_db_query("select * from " . TABLE_AFFILIATE_PAYMENT . " where affiliate_payment_id = '" . $_GET['pID'] . "'");
  $affiliate_payment = vam_db_fetch_array($affiliate_payment_query);
  $affiliate_sales_query = vam_db_query("select * from " . TABLE_AFFILIATE_SALES . " where affiliate_payment_id = '" . $payments['affiliate_payment_id'] . "' order by affiliate_payment_date desc");
  while ($affiliate_sales = vam_db_fetch_array($affiliate_sales_query)) {
?>

      <tr class="dataTableRow">
        <td class="dataTableContent" align="right" valign="top"><?php echo $affiliate_sales['affiliate_orders_id']; ?></td>
        <td class="dataTableContent" align="center" valign="top"><?php echo vam_date_short($affiliate_sales['affiliate_date']); ?></td>
        <td class="dataTableContent" align="right" valign="top"><b><?php echo $currencies->display_price($affiliate_sales['affiliate_value'], ''); ?></b></td>
        <td class="dataTableContent" align="right" valign="top"><?php echo $affiliate_sales['affiliate_percent']; ?><?php echo ENTRY_PERCENT; ?></td>
        <td class="dataTableContent" align="right" valign="top"><b><?php echo $currencies->display_price($affiliate_sales['affiliate_payment'], ''); ?></b></td>
      </tr>
<?php
  }
?>
    </table></td>
  </tr>
  <tr>
    <td align="right" colspan="5"><table border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td align="right" class="smallText"><?php echo TEXT_SUB_TOTAL; ?></td>
        <td align="right" class="smallText"><?php echo $currencies->display_price($affiliate_payment['affiliate_payment'], ''); ?></td>
      </tr>
      <tr>
        <td align="right" class="smallText"><?php echo TEXT_TAX; ?></td>
        <td align="right" class="smallText"><?php echo $currencies->display_price($affiliate_payment['affiliate_payment_tax'], ''); ?></td>
      </tr>
      <tr>
        <td align="right" class="smallText"><b><?php echo TEXT_TOTAL; ?></b></td>
        <td align="right" class="smallText"><b><?php echo $currencies->display_price($affiliate_payment['affiliate_payment_total'], ''); ?></b></td>
      </tr>
    </table></td>
  </tr>
</table>
<!-- body_text_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php');?>
