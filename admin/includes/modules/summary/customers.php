<?php
/*
  $Id: customers.php 814 2006-08-27 15:28:23Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2005 osCommerce

  Released under the GNU General Public License
*/

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

?>
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
				  <tr> 
				    <td colspan="3" class="pageHeading">
				    
<table width="100%" border="0" cellpadding="0" cellspacing="0">  <tr>
    <td class="contentBoxHeading1"><img src="images/heading1.gif" border="0" alt="" /></td>
    <td height="14" class="contentBoxHeading1" width="100%"><?php echo TABLE_HEADING_CUSTOMERS; ?></td>
  </tr>
  <tr>
    <td class="line" width="100%" colspan="2"><img src="images/pixel_trans.gif" border="0" alt="" width="1" height="2" /></td>
  </tr>
  <tr>
    <td width="100%" colspan="2"><img src="images/pixel_trans.gif" border="0" alt="" width="1" height="1" /></td>
  </tr>
</table>				    
				    </td>
				  </tr>
              <tr class="dataTableHeadingRow">
                <td width="35%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_LASTNAME; ?></td>
                <td width="35%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_FIRSTNAME; ?></td>
                <td width="30%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_DATE; ?></td>
              </tr>

<?php
	$customers_query_raw = "select
	                                c.customers_id,
	                                c.customers_lastname,
	                                c.customers_firstname,
	                                c.customers_date_added
	                                from
	                                ".TABLE_CUSTOMERS." c order by c.customers_date_added desc limit 5";

	$customers_query = xtc_db_query($customers_query_raw);
	while ($customers = xtc_db_fetch_array($customers_query)) {


?>
              <tr>
                <td class="dataTableContent"><a href="<?php echo xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array ('cID')).'cID='.$customers['customers_id']); ?>"><?php echo $customers['customers_lastname']; ?></a></td>
                <td class="dataTableContent"><a href="<?php echo xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array ('cID')).'cID='.$customers['customers_id']); ?>"><?php echo $customers['customers_firstname']; ?></a></td>
                <td class="dataTableContent"><?php echo $customers['customers_date_added']; ?></td>
              </tr>
<?php

	}
?>

                </table></td>
              </tr>