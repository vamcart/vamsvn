<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_column_left.php,v 1.2 2005/05/25 18:20:23 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/
   
echo ('<div class="dataTableHeadingContent"><b>'.BOX_HEADING_AFFILIATE.'</b></div>');
if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['configuration'] == '1')) echo '<a href="' . vam_href_link(FILENAME_CONFIGURATION, 'gID=28', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE_CONFIGURATION . '</a><br>';
if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_affiliates'] == '1')) echo '<a href="' . vam_href_link(FILENAME_AFFILIATE, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE . '</a><br>';
if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_banners'] == '1')) echo '<a href="' . vam_href_link(FILENAME_AFFILIATE_BANNERS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE_BANNERS . '</a><br>';
if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_clicks'] == '1')) echo '<a href="' . vam_href_link(FILENAME_AFFILIATE_CLICKS, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE_CLICKS . '</a><br>';
if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_contact'] == '1')) echo '<a href="' . vam_href_link(FILENAME_AFFILIATE_CONTACT, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE_CONTACT . '</a><br>';
if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_payment'] == '1')) echo '<a href="' . vam_href_link(FILENAME_AFFILIATE_PAYMENT, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE_PAYMENT . '</a><br>';
if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_sales'] == '1')) echo '<a href="' . vam_href_link(FILENAME_AFFILIATE_SALES, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE_SALES . '</a><br>';
if (($_SESSION['customers_status']['customers_status_id'] == '0') && ($admin_access['affiliate_summary'] == '1')) echo '<a href="' . vam_href_link(FILENAME_AFFILIATE_SUMMARY, '', 'NONSSL') . '" class="menuBoxContentLink"> -' . BOX_AFFILIATE_SUMMARY . '</a><br>';
?>
