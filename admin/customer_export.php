<?php
/* --------------------------------------------------------------
   $Id: customer_export.php 899 2011-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2011 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(define_language.php,v 1.6 2002/01/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (define_language.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2004	 xt:Commerce (define_language.php,v 1.4 2003/08/14); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

require('includes/application_top.php');

$customers_statuses_array = vam_get_customers_statuses();

if (!$_POST['submit'])
{
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
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
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr>
          <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
        </tr>
        <tr>
          <td><?php echo vam_draw_form(BOX_CUSTOMER_EXPORT, FILENAME_CUSTOMERS_EXPORT, '', 'post'); ?>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main"><?php echo TABLE_HEADING_CUSTOMER_EXPORT; ?></td>
              </tr>
              <tr>
                <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td class="main"><p><?php echo TEXT_CUSTOMER_EXPORT_ALL; ?></p>
                  <table border="0" width="100%" cellspacing="0" cellpadding="2">
                    <tr class="dataTableHeadingRow">
                      <td class="dataTableHeadingContent">cID</td>
                      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FIRSTNAME; ?></td>
                      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LASTNAME; ?></td>
                      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_EMAIL; ?></td>
                      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_GENDER; ?></td>
                      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_DOB; ?></td>
                      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_COMPANY; ?></td>
                      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_STREET; ?></td>
                      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ZIP; ?></td>
                      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CITY; ?></td>
                      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LOCATION; ?></td>
                      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_SUBURB; ?></td>
                      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_COUNTRY; ?></td>
                      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TELEPHONE; ?></td>
                      <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FAX; ?></td>
                    </tr>

                    <?php

    $customers_query_raw = "select c.customers_id,
    							  c.customers_status,
    							  c.customers_lastname,
    							  c.customers_firstname,
    							  c.customers_email_address,
    							  c.customers_gender,
    							  c.customers_dob,
    							  c.customers_telephone,
    							  c.customers_fax,
    							  a.entry_company,
    							  a.entry_street_address,
    							  a.entry_postcode,
    							  a.entry_city,
    							  a.entry_state,
    							  a.entry_suburb,

    							  co.countries_name
    							   from " . TABLE_CUSTOMERS . " c left join " . TABLE_ADDRESS_BOOK . " a on c.customers_id = a.customers_id and c.customers_default_address_id = a.address_book_id
    							   left join " . TABLE_COUNTRIES . " co on co.countries_id = a.entry_country_id
    							   order by c.customers_id";
    $customers_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS * 4, $customers_query_raw, $customers_query_numrows);
    $customers_query = vam_db_query($customers_query_raw);
    while ($customers = vam_db_fetch_array($customers_query)) {



?>

                 <tr class="dataTableRow">
                	  <td class="dataTableContent"><b><?php echo $customers['customers_id']; ?></b></td>
                      <td class="dataTableContent"><?php echo $customers['customers_firstname']; ?></td>
                      <td class="dataTableContent"><?php echo $customers['customers_lastname']; ?></td>
                      <td class="dataTableContent"><?php echo $customers['customers_email_address']; ?></td>
                      <td class="dataTableContent"><?php echo $customers['customers_gender']; ?></td>
                      <td class="dataTableContent"><?php echo vam_date_short($customers['customers_dob']); ?></td>
                      <td class="dataTableContent"><?php echo $customers['entry_company']; ?></td>
                      <td class="dataTableContent"><?php echo $customers['entry_street_address']; ?></td>
                      <td class="dataTableContent"><?php echo $customers['entry_postcode']; ?></td>
                      <td class="dataTableContent"><?php echo $customers['entry_city']; ?></td>
                      <td class="dataTableContent"><?php echo $customers['entry_state']; ?></td>
                      <td class="dataTableContent"><?php echo $customers['entry_suburb']; ?></td>
                      <td class="dataTableContent"><?php echo $customers['countries_name']; ?></td>
                      <td class="dataTableContent"><?php echo $customers['customers_telephone']; ?></td>

                      <td class="dataTableContent"><?php echo $customers['customers_fax']; ?></td>
                    </tr>


<?php
    }
?>

                  </table>

                  </td>
              </tr>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $customers_split->display_count($customers_query_numrows, MAX_DISPLAY_SEARCH_RESULTS * 4, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CUSTOMERS); ?></td>
                    <td class="smallText" align="right"><?php echo $customers_split->display_links($customers_query_numrows, MAX_DISPLAY_SEARCH_RESULTS * 4, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], vam_get_all_get_params(array('page', 'info', 'x', 'y', 'cID'))); ?></td>
                  </tr>
                 </td>
               </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              
<?php

	$select_data = array ();
	$select_data = array (array ('id' => '100', 'text' => TEXT_ALL_CUSTOMERS));
?>               
              <tr>
              <td class="smallText" ><?php echo HEADING_TITLE_STATUS . ' ' . vam_draw_pull_down_menu('status',vam_array_merge($select_data, $customers_statuses_array), '100'); ?><br /><?php echo TEXT_CUSTOMER_EXPORT_SEPARATOR; ?>: <input name="separator" type="text" value="\t" size="3">&nbsp;&nbsp;<span class="button"><button type="submit" name="submit" value="<?php echo TEXT_CUSTOMER_EXPORT; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_CUSTOMER_EXPORT; ?></button></span></td>
              </tr>
            </table>
            </form>
          </td>
        </tr>
      </table></td>
  </tr>
</table>
<!-- footer //-->
<center>
  <font color="#666666" size="2"></font>
</center>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php
}
else
{

	if($_POST['separator']!="") $sep=stripcslashes($_POST['separator']); else $sep="\t";
	$sep= str_replace('\t', "\011", $sep);

	$contents="customers_id".$sep."customers_lastname".$sep."customers_firstname".$sep."customers_email_address".$sep."customers_gender".$sep."customers_dob".$sep."entry_company".$sep."entry_street_address".$sep."entry_postcode".$sep."entry_city".$sep."entry_state".$sep."entry_suburb".$sep."countries_name".$sep."customers_telephone".$sep."customers_fax\n";

	if ($_POST['status'] && $_POST['status'] != '100' or $_POST['status'] == '0') {
		$status = vam_db_prepare_input($_POST['status']);
		//  echo $status;
		$search = "where c.customers_status = '".(int)$status."'";
	}

	$customers_query_raw = "select c.customers_id,
    							  c.customers_status,
    							  c.customers_lastname,
    							  c.customers_firstname,
    							  c.customers_email_address,
    							  c.customers_gender,
    							  c.customers_dob,
    							  c.customers_telephone,
    							  c.customers_fax,
    							  a.entry_company,
    							  a.entry_street_address,
    							  a.entry_postcode,
    							  a.entry_city,
    							  a.entry_state,
    							  a.entry_suburb,

    							  co.countries_name
    							   from " . TABLE_CUSTOMERS . " c left join " . TABLE_ADDRESS_BOOK . " a on c.customers_id = a.customers_id and c.customers_default_address_id = a.address_book_id
    							   left join " . TABLE_COUNTRIES . " co on co.countries_id = a.entry_country_id
    							   ".$search."
    							   order by c.customers_id";
    $customers_query = vam_db_query($customers_query_raw);
    while ($row = vam_db_fetch_array($customers_query)) {



		$contents.=$row['customers_id'].$sep;
		$contents.=$row['customers_lastname'].$sep;
		$contents.=$row['customers_firstname'].$sep;
		$contents.=$row['customers_email_address'].$sep;
		$contents.=$row['customers_gender'].$sep;
		$contents.=vam_date_short($row['customers_dob']).$sep;
		$contents.=$row['entry_company'].$sep;
		$contents.=$row['entry_street_address'].$sep;
		$contents.=$row['entry_postcode'].$sep;
		$contents.=$row['entry_city'].$sep;
		$contents.=$row['entry_state'].$sep;
		$contents.=$row['entry_suburb'].$sep;
		$contents.=$row['countries_name'].$sep;
        $contents.=$row['customers_telephone'].$sep;
		$contents.=$row['customers_fax']."\n";
	}
	/*Header("Content-Disposition: attachment; filename=export.txt");
	print $contents;*/

	 header("Content-Type: application/force-download\n");
                header("Content-disposition: attachment; filename=customers_export_" . date("Ymd") . ".txt");
				header("Pragma: no-cache");
				header("Expires: 0");
				echo $contents;
				die();
}
require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
