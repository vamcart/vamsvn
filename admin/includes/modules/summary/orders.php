<?php
/* -----------------------------------------------------------------------------------------
   $Id: orders.php 950 2007-02-08 12:51:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 osCommerce (orders.php,v 1.25 2003/08/19); oscommerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

defined('_VALID_VAM') or die('Direct Access to this location is not allowed.');

?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
				  <tr> 
				    <td colspan="5" class="pageHeading" width="100%">

    <h1 class="contentBoxHeading"><?php echo '<a href="' . vam_href_link(FILENAME_ORDERS, '', 'NONSSL') . '">' . TABLE_HEADING_ORDERS . '</a>'; ?></h1>
				    
				    </td>
				  </tr>

</table>
<table border="0" width="100%" cellspacing="2" cellpadding="0" class="table table-hover">				  

				<thead>
              <tr>
                <th><?php echo TABLE_HEADING_CUSTOMER; ?></th>
                <th><?php echo TABLE_HEADING_NUMBER; ?></th>
                <th><?php echo TABLE_HEADING_ORDER_TOTAL; ?></th>
                <th><?php echo TABLE_HEADING_STATUS; ?></th>
                <th><?php echo TABLE_HEADING_DATE; ?></th>
              </tr>
				</thead>

				<tbody>
<?php

		$orders_query_raw = "select o.orders_id, o.orders_status, o.customers_name, o.date_purchased, o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text as order_total from ".TABLE_ORDERS." o left join ".TABLE_ORDERS_TOTAL." ot on (o.orders_id = ot.orders_id), ".TABLE_ORDERS_STATUS." s where (o.orders_status = s.orders_status_id and s.language_id = '".$_SESSION['languages_id']."' and ot.class = 'ot_total') or (o.orders_status = '0' and ot.class = 'ot_total' and  s.orders_status_id = '1' and s.language_id = '".$_SESSION['languages_id']."') order by o.date_purchased desc limit 20";


	$customers_query_raw = "select
	                                c.customers_id,
	                                c.customers_lastname,
	                                c.customers_firstname,
	                                c.customers_date_added
	                                from
	                                ".TABLE_CUSTOMERS." c order by c.customers_date_added desc limit 5";

	$orders_query = vam_db_query($orders_query_raw);
	while ($orders = vam_db_fetch_array($orders_query)) {

        $rows++;

        if (($rows/2) == floor($rows/2)) {
          $css_class = 'view_data_even';
        } else {
          $css_class = 'view_data_odd';
        }
?>
              <tr>
                <td class="<?php echo $css_class; ?>" align="left"><a href="<?php echo vam_href_link(FILENAME_ORDERS, vam_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders['orders_id'] . '&action=edit'); ?>"><?php echo $orders['customers_name']; ?></a></td>
                <td class="<?php echo $css_class; ?>" align="center"><?php echo $orders['orders_id']; ?></td>
                <td class="<?php echo $css_class; ?>"><?php echo strip_tags($orders['order_total']); ?></td>
                <td class="<?php echo $css_class; ?>"><?php echo $orders['orders_status_name']; ?></td>
                <td class="<?php echo $css_class; ?>"><?php echo vam_datetime_short($orders['date_purchased']); ?></td>
              </tr>
<?php

	}
?>
				</tbody>

                </table>