<?php
/*
  $Id: customers.php 814 2006-08-27 15:28:23Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2005 osCommerce

  Released under the GNU General Public License
*/

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

require_once (DIR_WS_CLASSES.'currencies.php');

$currencies = new currencies();

?>
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
				  <tr> 
				    <td colspan="3" class="pageHeading" width="100%">

    <h1 class="contentBoxHeading"><?php echo TABLE_HEADING_PRODUCTS; ?></h1>
				    
				    </td>
				  </tr>
              <tr class="dataTableHeadingRow">
                <td width="35%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCT_NAME; ?></td>
                <td width="35%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCT_PRICE; ?></td>
                <td width="30%" class="dataTableHeadingContent"><?php echo TABLE_HEADING_DATE; ?></td>
              </tr>

<?php

        $products_query_raw = xtc_db_query("
        SELECT 
        p.products_tax_class_id,
        p.products_id, 
        pd.products_name, 
        p.products_price, 
        p.products_date_added, 
        p.products_last_modified 
        FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd WHERE p.products_id = pd.products_id AND pd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by p.products_last_modified, pd.products_name desc limit 5");

	while ($products = xtc_db_fetch_array($products_query_raw)) {

            $price = $products['products_price'];
            $price = xtc_round($price,PRICE_PRECISION);

?>
              <tr>
                <td class="dataTableContent"><a href="<?php echo xtc_href_link(FILENAME_CATEGORIES, xtc_get_all_get_params(array('pID', 'action')) . 'pID=' . $products['products_id'] . '&action=new_product'); ?>"><?php echo $products['products_name']; ?></a></td>
                <td class="dataTableContent"><?php echo $currencies->format($price); ?></td>
                <td class="dataTableContent"><?php echo $products['products_date_added']; ?></td>
              </tr>
<?php

	}
?>

                </table></td>
              </tr>