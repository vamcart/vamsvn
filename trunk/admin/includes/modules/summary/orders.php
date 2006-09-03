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
				    <td colspan="5" class="pageHeading"><?php echo TABLE_HEADING_ORDERS; ?></td>
				  </tr>
              <tr class="dataTableHeadingRow">
                <td width="40%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMER; ?></td>
                <td width="10%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_NUMBER; ?></td>
                <td width="10%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></td>
                <td width="20%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td width="20%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_DATE; ?></td>
              </tr>

<?php

		$orders_query_raw = "select o.orders_id, o.orders_status, o.customers_name, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from ".TABLE_ORDERS." o left join ".TABLE_ORDERS_TOTAL." ot on (o.orders_id = ot.orders_id), ".TABLE_ORDERS_STATUS." s where (o.orders_status = s.orders_status_id and s.language_id = '".$_SESSION['languages_id']."' and ot.class = 'ot_total') or (o.orders_status = '0' and ot.class = 'ot_total' and  s.orders_status_id = '1' and s.language_id = '".$_SESSION['languages_id']."') order by o.date_purchased desc limit 5";


	$customers_query_raw = "select
	                                c.customers_id,
	                                c.customers_lastname,
	                                c.customers_firstname,
	                                c.customers_date_added
	                                from
	                                ".TABLE_CUSTOMERS." c order by c.customers_date_added desc limit 5";

	$orders_query = xtc_db_query($orders_query_raw);
	while ($orders = xtc_db_fetch_array($orders_query)) {


?>
              <tr>
                <td class="dataTableContent"><a href="<?php echo xtc_href_link(FILENAME_ORDERS, xtc_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders['orders_id'] . '&action=edit'); ?>"><?php echo $orders['customers_name']; ?></a></td>
                <td class="dataTableContent"><?php echo $orders['orders_id']; ?></td>
                <td class="dataTableContent"><?php echo strip_tags($orders['order_total']); ?></td>
                <td class="dataTableContent"><?php echo $orders['orders_status_name']; ?></td>
                <td class="dataTableContent"><?php echo xtc_datetime_short($orders['date_purchased']); ?></td>
              </tr>
<?php

	}
?>

                </table></td>
              </tr>