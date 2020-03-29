<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_affiliates.php,v 1.2 2005/05/25 18:20:23 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_affiliates.php, v 1.12 2003/07/12);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

  require('includes/application_top.php');
  
  // include used functions
  require_once(DIR_FS_INC . 'vam_add_tax.inc.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'update':
        $affiliate_id = vam_db_prepare_input($_GET['acID']);
        $affiliate_gender = vam_db_prepare_input($_POST['affiliate_gender']);
        $affiliate_firstname = vam_db_prepare_input($_POST['affiliate_firstname']);
        $affiliate_lastname = vam_db_prepare_input($_POST['affiliate_lastname']);
        $affiliate_dob = vam_db_prepare_input($_POST['affiliate_dob']);
        $affiliate_email_address = vam_db_prepare_input($_POST['affiliate_email_address']);
        $affiliate_company = vam_db_prepare_input($_POST['affiliate_company']);
        $affiliate_company_taxid = vam_db_prepare_input($_POST['affiliate_company_taxid']);
        $affiliate_payment_check = vam_db_prepare_input($_POST['affiliate_payment_check']);
        $affiliate_payment_paypal = vam_db_prepare_input($_POST['affiliate_payment_paypal']);
        $affiliate_payment_bank_name = vam_db_prepare_input($_POST['affiliate_payment_bank_name']);
        $affiliate_payment_bank_branch_number = vam_db_prepare_input($_POST['affiliate_payment_bank_branch_number']);
        $affiliate_payment_bank_swift_code = vam_db_prepare_input($_POST['affiliate_payment_bank_swift_code']);
        $affiliate_payment_bank_account_name = vam_db_prepare_input($_POST['affiliate_payment_bank_account_name']);
        $affiliate_payment_bank_account_number = vam_db_prepare_input($_POST['affiliate_payment_bank_account_number']);
        $affiliate_street_address = vam_db_prepare_input($_POST['affiliate_street_address']);
        $affiliate_suburb = vam_db_prepare_input($_POST['affiliate_suburb']);
        $affiliate_postcode=vam_db_prepare_input($_POST['affiliate_postcode']);
        $affiliate_city = vam_db_prepare_input($_POST['affiliate_city']);
        $affiliate_country_id=vam_db_prepare_input($_POST['affiliate_country_id']);
        $affiliate_telephone=vam_db_prepare_input($_POST['affiliate_telephone']);
        $affiliate_fax=vam_db_prepare_input($_POST['affiliate_fax']);
        $affiliate_homepage=vam_db_prepare_input($_POST['affiliate_homepage']);
        $affiliate_state = vam_db_prepare_input($_POST['affiliate_state']);
        $affiliatey_zone_id = vam_db_prepare_input($_POST['affiliate_zone_id']);
        $affiliate_commission_percent = vam_db_prepare_input($_POST['affiliate_commission_percent']);
        if ($affiliate_zone_id > 0) $affiliate_state = '';
        // If someone uses , instead of .
        $affiliate_commission_percent = str_replace (',' , '.' , $affiliate_commission_percent);

        $sql_data_array = array('affiliate_firstname' => $affiliate_firstname,
                                'affiliate_lastname' => $affiliate_lastname,
                                'affiliate_email_address' => $affiliate_email_address,
                                'affiliate_payment_check' => $affiliate_payment_check,
                                'affiliate_payment_paypal' => $affiliate_payment_paypal,
                                'affiliate_payment_bank_name' => $affiliate_payment_bank_name,
                                'affiliate_payment_bank_branch_number' => $affiliate_payment_bank_branch_number,
                                'affiliate_payment_bank_swift_code' => $affiliate_payment_bank_swift_code,
                                'affiliate_payment_bank_account_name' => $affiliate_payment_bank_account_name,
                                'affiliate_payment_bank_account_number' => $affiliate_payment_bank_account_number,
                                'affiliate_street_address' => $affiliate_street_address,
                                'affiliate_postcode' => $affiliate_postcode,
                                'affiliate_city' => $affiliate_city,
                                'affiliate_country_id' => $affiliate_country_id,
                                'affiliate_telephone' => $affiliate_telephone,
                                'affiliate_fax' => $affiliate_fax,
                                'affiliate_homepage' => $affiliate_homepage,
                                'affiliate_commission_percent' => $affiliate_commission_percent,
                                'affiliate_agb' => '1');

        if (ACCOUNT_DOB == 'true') $sql_data_array['affiliate_dob'] = vam_date_short($affiliate_dob);
        if (ACCOUNT_GENDER == 'true') $sql_data_array['affiliate_gender'] = $affiliate_gender;
        if (ACCOUNT_COMPANY == 'true') {
          $sql_data_array['affiliate_company'] = $affiliate_company;
          $sql_data_array['affiliate_company_taxid'] =  $affiliate_company_taxid;
        }
        if (ACCOUNT_SUBURB == 'true') $sql_data_array['affiliate_suburb'] = $affiliate_suburb;
        if (ACCOUNT_STATE == 'true') {
          $sql_data_array['affiliate_state'] = $affiliate_state;
          $sql_data_array['affiliate_zone_id'] = $affiliate_zone_id;
        }

        $sql_data_array['affiliate_date_account_last_modified'] = 'now()';

        vam_db_perform(TABLE_AFFILIATE, $sql_data_array, 'update', "affiliate_id = '" . vam_db_input($affiliate_id) . "'");

        vam_redirect(vam_href_link(FILENAME_AFFILIATE, vam_get_all_get_params(array('acID', 'action')) . 'acID=' . $affiliate_id));
        break;
      case 'deleteconfirm':
        $affiliate_id = vam_db_prepare_input($_GET['acID']);

        affiliate_delete(vam_db_input($affiliate_id));

        vam_redirect(vam_href_link(FILENAME_AFFILIATE, vam_get_all_get_params(array('acID', 'action'))));
        break;
    }
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
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ($_GET['action'] == 'edit') {
    $affiliate_query = vam_db_query("select * from " . TABLE_AFFILIATE . " where affiliate_id = '" . $_GET['acID'] . "'");
    $affiliate = vam_db_fetch_array($affiliate_query);
    $aInfo = new objectInfo($affiliate);
?>
      <tr><?php echo vam_draw_form('affiliate', FILENAME_AFFILIATE, vam_get_all_get_params(array('action')) . 'action=update', 'post', 'onSubmit="return check_form();"'); ?>
        <td class="formAreaTitle"><?php echo CATEGORY_PERSONAL; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
<?php
    if (ACCOUNT_GENDER == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_GENDER; ?></td>
            <td class="main"><?php echo vam_draw_radio_field('affiliate_gender', 'm', false, $aInfo->affiliate_gender) . '&nbsp;&nbsp;' . MALE . '&nbsp;&nbsp;' . vam_draw_radio_field('affiliate_gender', 'f', false, $aInfo->affiliate_gender) . '&nbsp;&nbsp;' . FEMALE; ?></td>
          </tr>
<?php
    }
?>
          <tr>
            <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_firstname', $aInfo->affiliate_firstname, 'maxlength="32"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_lastname', $aInfo->affiliate_lastname, 'maxlength="32"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_email_address', $aInfo->affiliate_email_address, 'maxlength="96"', true); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
   if (AFFILATE_INDIVIDUAL_PERCENTAGE == 'true') {
?>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_COMMISSION; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_COMMISSION; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_commission_percent', $aInfo->affiliate_commission_percent, 'maxlength="5"'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
    }
?>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_COMPANY; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_COMPANY; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_company', $aInfo->affiliate_company, 'maxlength="32"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_COMPANY_TAXID; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_company_taxid', $aInfo->affiliate_company_taxid, 'maxlength="64"'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_PAYMENT_DETAILS; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
<?php
  if (AFFILIATE_USE_CHECK == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_CHECK; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_payment_check', $aInfo->affiliate_payment_check, 'maxlength="100"'); ?></td>
          </tr>
<?php
  }
  if (AFFILIATE_USE_PAYPAL == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_PAYPAL; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_payment_paypal', $aInfo->affiliate_payment_paypal, 'maxlength="64"'); ?></td>
          </tr>
<?php
  }
  if (AFFILIATE_USE_BANK == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_NAME; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_payment_bank_name', $aInfo->affiliate_payment_bank_name, 'maxlength="64"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_payment_bank_branch_number', $aInfo->affiliate_payment_bank_branch_number, 'maxlength="64"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_payment_bank_swift_code', $aInfo->affiliate_payment_bank_swift_code, 'maxlength="64"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_payment_bank_account_name', $aInfo->affiliate_payment_bank_account_name, 'maxlength="64"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_payment_bank_account_number', $aInfo->affiliate_payment_bank_account_number, 'maxlength="64"'); ?></td>
          </tr>
<?php
  }
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_ADDRESS; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_street_address', $aInfo->affiliate_street_address, 'maxlength="64"', true); ?></td>
          </tr>
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_SUBURB; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_suburb', $aInfo->affiliate_suburb, 'maxlength="64"', false); ?></td>
          </tr>
<?php
  }
?>
          <tr>
            <td class="main"><?php echo ENTRY_CITY; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_city', $aInfo->affiliate_city, 'maxlength="32"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_POST_CODE; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_postcode', $aInfo->affiliate_postcode, 'maxlength="8"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
            <td class="main"><?php echo vam_draw_pull_down_menu('affiliate_country_id', vam_get_countries(), $aInfo->affiliate_country_id, 'onChange="update_zone(this.form);"'); ?></td>
          </tr>
<?php
    if (ACCOUNT_STATE == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_STATE; ?></td>
            <td class="main"><?php echo vam_draw_pull_down_menu('affiliate_zone_id', vam_prepare_country_zones_pull_down($aInfo->affiliate_country_id), $aInfo->affiliate_zone_id, 'onChange="resetStateText(this.form);"'); ?></td>
          </tr>
          <tr>
            <td class="main">&nbsp;</td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_state', $aInfo->affiliate_state, 'maxlength="32" onChange="resetZoneSelected(this.form);"'); ?></td>
          </tr>
<?php
    }
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_CONTACT; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_telephone', $aInfo->affiliate_telephone, 'maxlength="32"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_FAX_NUMBER; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_fax', $aInfo->affiliate_fax, 'maxlength="32"'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_AFFILIATE_HOMEPAGE; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_homepage', $aInfo->affiliate_homepage, 'maxlength="64"', true); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
       <tr>
        <td align="right" class="main"><?php echo '<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span><a class="button" href="' . vam_href_link(FILENAME_AFFILIATE, vam_get_all_get_params(array('action'))) .'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>';?></td>
      </tr></form>
<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr><?php echo vam_draw_form('search', FILENAME_AFFILIATE, '', 'get'); ?>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo vam_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . vam_draw_input_field('search'); ?></td>
          </form></tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_AFFILIATE_ID; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LASTNAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FIRSTNAME; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_COMMISSION; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACCOUNT; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_USERHOMEPAGE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $search = '';
    if ( ($_GET['search']) && (vam_not_null($_GET['search'])) ) {
      $keywords = vam_db_input(vam_db_prepare_input($_GET['search']));
      $search = " where affiliate_id like '" . $keywords . "' or affiliate_firstname like '" . $keywords . "' or affiliate_lastname like '" . $keywords . "' or affiliate_email_address like '" . $keywords . "'";
    }
    $affiliate_query_raw = "select * from " . TABLE_AFFILIATE . $search . " order by affiliate_id DESC";
    $affiliate_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE,
    $affiliate_query_raw, $affiliate_query_numrows);
    $affiliate_query = vam_db_query($affiliate_query_raw);
    while ($affiliate = vam_db_fetch_array($affiliate_query)) {
      $info_query = vam_db_query("select affiliate_commission_percent, affiliate_date_account_created as date_account_created, affiliate_date_account_last_modified as date_account_last_modified, affiliate_date_of_last_logon as date_last_logon, affiliate_number_of_logons as number_of_logons from " . TABLE_AFFILIATE . " where affiliate_id = '" . $affiliate['affiliate_id'] . "'");
      $info = vam_db_fetch_array($info_query);

      if (((!$_GET['acID']) || (@$_GET['acID'] == $affiliate['affiliate_id'])) && (!$aInfo)) {
        $country_query = vam_db_query("select countries_name from " . TABLE_COUNTRIES . " where countries_id = '" . $affiliate['affiliate_country_id'] . "'");
        $country = vam_db_fetch_array($country_query);

        $affiliate_info = array_merge((array)$country, $info);

        $aInfo_array = array_merge($affiliate, (array)$affiliate_info);
        $aInfo = new objectInfo($aInfo_array);
      }
      
      // get the aktual amount of account
      $time = mktime(1, 1, 1, date("m"), date("d") - AFFILIATE_BILLING_TIME, date("Y"));
      $oldday = date("Y-m-d", $time);
      $acnt_value = vam_db_query("SELECT sum(a.affiliate_payment) as amount FROM " . TABLE_AFFILIATE_SALES . " a, " . TABLE_ORDERS . " o
          WHERE a.affiliate_billing_status != 1 and a.affiliate_orders_id = o.orders_id and o.orders_status >= " . AFFILIATE_PAYMENT_ORDER_MIN_STATUS . " and a.affiliate_id = '" . $affiliate['affiliate_id'] . "' and a.affiliate_date <= '" . $oldday . "'");
      $acnt_res = vam_db_fetch_array($acnt_value);

      if ( (is_object($aInfo)) && ($affiliate['affiliate_id'] == $aInfo->affiliate_id) ) {
        echo '          <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_AFFILIATE, vam_get_all_get_params(array('acID', 'action')) . 'acID=' . $aInfo->affiliate_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '          <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_AFFILIATE, vam_get_all_get_params(array('acID')) . 'acID=' . $affiliate['affiliate_id']) . '\'">' . "\n";
      }
      if (substr($affiliate['affiliate_homepage'],0,7) != "http://") $affiliate['affiliate_homepage']="http://".$affiliate['affiliate_homepage'];
?>
                <td class="dataTableContent"><?php echo $affiliate['affiliate_id']; ?></td>        
                <td class="dataTableContent"><?php echo $affiliate['affiliate_lastname']; ?></td>
                <td class="dataTableContent"><?php echo $affiliate['affiliate_firstname']; ?></td>
                <td class="dataTableContent" align="right"><?php if($affiliate['affiliate_commission_percent'] > AFFILIATE_PERCENT) echo $affiliate['affiliate_commission_percent']; else echo  AFFILIATE_PERCENT; ?> %</td>
                <td class="dataTableContent" align="right"><?php echo $currencies->display_price($acnt_res['amount'],''); ?></td>
                <td class="dataTableContent"><?php echo '<a href="' . $affiliate['affiliate_homepage'] . '" target="_blank">' . $affiliate['affiliate_homepage'] . '</a>'; ?></td>
                <td class="dataTableContent" align="right"><?php echo '<a href="' . vam_href_link(FILENAME_AFFILIATE, vam_get_all_get_params(array('acID', 'action')) . 'acID=' . $affiliate['affiliate_id'] . '&action=edit') . '">' . vam_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a><a href="' . vam_href_link(FILENAME_AFFILIATE_STATISTICS, vam_get_all_get_params(array('acID')) . 'acID=' . $affiliate['affiliate_id']) . '">' . vam_image(DIR_WS_ICONS . 'statistics.gif', ICON_STATISTICS) . '</a>&nbsp;'; if ( (is_object($aInfo)) && ($affiliate['affiliate_id'] == $aInfo->affiliate_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_AFFILIATE, vam_get_all_get_params(array('acID')) . 'acID=' . $affiliate['affiliate_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="7"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $affiliate_split->display_count($affiliate_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_AFFILIATES); ?></td>
                    <td class="smallText" align="right"><?php echo $affiliate_split->display_links($affiliate_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], vam_get_all_get_params(array('page', 'info', 'x', 'y', 'acID'))); ?></td>
                  </tr>
<?php
    if (vam_not_null($_GET['search'])) {
?>
                  <tr>
                    <td align="right" colspan="2"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_AFFILIATE) . '"><span>' . BUTTON_RESET . '</span></a>'; ?></td>
                  </tr>
<?php
    }
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'confirm':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CUSTOMER . '</b>');

      $contents = array('form' => vam_draw_form('affiliate', FILENAME_AFFILIATE, vam_get_all_get_params(array('acID', 'action')) . 'acID=' . $aInfo->affiliate_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO . '<br><br><b>' . $aInfo->affiliate_firstname . ' ' . $aInfo->affiliate_lastname . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br><span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span><a class="button" href="' . vam_href_link(FILENAME_AFFILIATE, vam_get_all_get_params(array('acID', 'action')) . 'acID=' . $aInfo->affiliate_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;
    default:
      if (is_object($aInfo)) {
        $heading[] = array('text' => '<b>' . $aInfo->affiliate_firstname . ' ' . $aInfo->affiliate_lastname . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_AFFILIATE, vam_get_all_get_params(array('acID', 'action')) . 'acID=' . $aInfo->affiliate_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_AFFILIATE, vam_get_all_get_params(array('acID', 'action')) . 'acID=' . $aInfo->affiliate_id . '&action=confirm') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_AFFILIATE_CONTACT, 'selected_box=affiliate&affiliate=' . $aInfo->affiliate_email_address) . '"><span>' . BUTTON_SEND_EMAIL . '</span></a>');

        $affiliate_sales_raw = "select count(*) as count, sum(affiliate_value) as total, sum(affiliate_payment) as payment from " . TABLE_AFFILIATE_SALES . " a left join " . TABLE_ORDERS . " o on (a.affiliate_orders_id=o.orders_id) where o.orders_status >= " . AFFILIATE_PAYMENT_ORDER_MIN_STATUS . " and  affiliate_id = '" . $aInfo->affiliate_id . "'";
        $affiliate_sales_values = vam_db_query($affiliate_sales_raw);
        $affiliate_sales = vam_db_fetch_array($affiliate_sales_values);

        $contents[] = array('text' => '<br>' . TEXT_DATE_ACCOUNT_CREATED . ' ' . vam_date_short($aInfo->date_account_created));
        $contents[] = array('text' => '' . TEXT_DATE_ACCOUNT_LAST_MODIFIED . ' ' . vam_date_short($aInfo->date_account_last_modified));
        $contents[] = array('text' => '' . TEXT_INFO_DATE_LAST_LOGON . ' '  . vam_date_short($aInfo->date_last_logon));
        $contents[] = array('text' => '' . TEXT_INFO_NUMBER_OF_LOGONS . ' ' . $aInfo->number_of_logons);
        $contents[] = array('text' => '' . TEXT_INFO_COMMISSION . ' ' . $aInfo->affiliate_commission_percent . ' %');
        $contents[] = array('text' => '' . TEXT_INFO_COUNTRY . ' ' . $aInfo->countries_name);
        $contents[] = array('text' => '' . TEXT_INFO_NUMBER_OF_SALES . ' ' . $affiliate_sales['count'],'');
        $contents[] = array('text' => '' . TEXT_INFO_SALES_TOTAL . ' ' . $currencies->display_price($affiliate_sales['total'],''));
        $contents[] = array('text' => '' . TEXT_INFO_AFFILIATE_TOTAL . ' ' . $currencies->display_price($affiliate_sales['payment'],''));
      }
      break;
  }

  if ( (vam_not_null($heading)) && (vam_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
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
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>