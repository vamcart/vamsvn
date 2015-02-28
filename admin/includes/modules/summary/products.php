<?php
/* -----------------------------------------------------------------------------------------
   $Id: products.php 950 2007-02-08 12:51:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 osCommerce (products.php,v 1.25 2003/08/19); oscommerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

defined('_VALID_VAM') or die('Direct Access to this location is not allowed.');

require_once (DIR_WS_CLASSES.'currencies.php');

$currencies = new currencies();

?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
				  <tr> 
				    <td colspan="3" class="pageHeading" width="100%">

    <h1 class="contentBoxHeading"><?php echo '<a href="' . vam_href_link(FILENAME_CATEGORIES, '', 'NONSSL') . '">' . TABLE_HEADING_SUMMARY_PRODUCTS . '</a>'; ?></h1>
				    
				    </td>
				  </tr>
				  
</table>
<table class="table table-hover">				  
				  
				<thead>
              <tr class="dataTableHeadingRow">
                <th><?php echo TABLE_HEADING_PRODUCT_NAME; ?></th>
                <th><?php echo TABLE_HEADING_PRODUCT_PRICE; ?></th>
                <th><?php echo TABLE_HEADING_DATE; ?></th>
              </tr>
				</thead>

				<tbody>

<?php

        $products_query_raw = vam_db_query("
        SELECT 
        p.products_tax_class_id,
        p.products_id, 
        pd.products_name, 
        p.products_price, 
        p.products_date_added, 
        p.products_last_modified 
        FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd WHERE p.products_id = pd.products_id AND pd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by p.products_id desc limit 20");

	while ($products = vam_db_fetch_array($products_query_raw)) {

        $rows++;

        if (($rows/2) == floor($rows/2)) {
          $css_class = 'view_data_even';
        } else {
          $css_class = 'view_data_odd';
        }
        
            $price = $products['products_price'];
            $price = vam_round($price,PRICE_PRECISION);

?>
              <tr>
                <td class="<?php echo $css_class; ?>"><a href="<?php echo vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('pID', 'action')) . 'pID=' . $products['products_id'] . '&action=new_product'); ?>"><?php echo $products['products_name']; ?></a></td>
                <td class="<?php echo $css_class; ?>"><?php echo $currencies->format($price); ?></td>
                <td class="<?php echo $css_class; ?>"><?php echo $products['products_date_added']; ?></td>
              </tr>
<?php

	}
?>
				</tbody>

                </table>