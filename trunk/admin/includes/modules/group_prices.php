<?php
/* --------------------------------------------------------------
   $Id: group_prices.php 1307 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(based on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35); www.oscommerce.com
   (c) 2003         nextcommerce (group_prices.php,v 1.16 2003/08/21); www.nextcommerce.org
   (c) 2004 xt:Commerce (group_prices.php,v 1.16 2003/08/21); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------
   based on Third Party contribution:
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   --------------------------------------------------------------*/

defined('_VALID_VAM') or die('Direct Access to this location is not allowed.');
require_once (DIR_FS_INC.'vam_get_tax_rate.inc.php');

require (DIR_FS_CATALOG.DIR_WS_CLASSES.'vam_price.php');
$vamPrice = new vamPrice(DEFAULT_CURRENCY, $_SESSION['customers_status']['customers_status_id']);

$i = 0;
$group_query = vam_db_query("SELECT
                                   customers_status_image,
                                   customers_status_id,
                                   customers_status_name
                               FROM
                                   ".TABLE_CUSTOMERS_STATUS."
                               WHERE
                                   language_id = '".$_SESSION['languages_id']."' AND customers_status_id != '0'");
while ($group_values = vam_db_fetch_array($group_query)) {
        // load data into array
        $i ++;
        $group_data[$i] = array ('STATUS_NAME' => $group_values['customers_status_name'], 'STATUS_IMAGE' => $group_values['customers_status_image'], 'STATUS_ID' => $group_values['customers_status_id']);
}
?>
          <tr>
            <td><?php echo TEXT_PRODUCTS_PRICE; ?></td>
<?php
// calculate brutto price for display

if (PRICE_IS_BRUTTO == 'true') {
        $products_price = vam_round($pInfo->products_price * ((100 + vam_get_tax_rate($pInfo->products_tax_class_id)) / 100), PRICE_PRECISION);
} else {
        $products_price = vam_round($pInfo->products_price, PRICE_PRECISION);
}
?>
            <td><?php echo vam_draw_input_field('products_price', $products_price); ?>
<?php
if (PRICE_IS_BRUTTO == 'true') {
        echo TEXT_NETTO.'<b>'.$vamPrice->Format($pInfo->products_price, false).'</b>  ';
}
?>
            </td>
          </tr>
<?php
for ($col = 0, $n = sizeof($group_data); $col < $n +1; $col ++) {
        if ($group_data[$col]['STATUS_NAME'] != '') {
?>
          <tr>
            <td><?php echo $group_data[$col]['STATUS_NAME']; ?></td>
<?php
                if (PRICE_IS_BRUTTO == 'true') {
                        $products_price = vam_round(get_group_price($group_data[$col]['STATUS_ID'], $pInfo->products_id) * ((100 + vam_get_tax_rate($pInfo->products_tax_class_id)) / 100), PRICE_PRECISION);
                } else {
                        $products_price = vam_round(get_group_price($group_data[$col]['STATUS_ID'], $pInfo->products_id), PRICE_PRECISION);
                }
?>
            <td><?php
                echo vam_draw_input_field('products_price_'.$group_data[$col]['STATUS_ID'], $products_price);
                if (PRICE_IS_BRUTTO == 'true' && get_group_price($group_data[$col]['STATUS_ID'], $pInfo->products_id) != '0') {
                        echo TEXT_NETTO.'<b>'.$vamPrice->Format(get_group_price($group_data[$col]['STATUS_ID'], $pInfo->products_id), false).'</b>  ';
                }
                if ($_GET['pID'] != '') {
                        echo ' '.TXT_STAFFELPREIS;
?> <img onMouseOver="javascript:this.style.cursor='hand';" alt="&darr;" src="images/arrow_down.gif" height="12" width="12" onClick="javascript:toggleBox('staffel_<?php echo $group_data[$col]['STATUS_ID']; ?>');">
<?php
                }
                if ($_GET['pID'] != '') {
                }
?><div id="staffel_<?php echo $group_data[$col]['STATUS_ID']; ?>" class="longDescription"><br><?php
                // ok, lets check if there is already a staffelpreis
                $staffel_query = vam_db_query("SELECT
                                                                         products_id,
                                                                         quantity,
                                                                         personal_offer
                                                                     FROM
                                                                         personal_offers_by_customers_status_".$group_data[$col]['STATUS_ID']."
                                                                     WHERE
                                                                         products_id = '".$pInfo->products_id."' AND quantity != 1
                                                                     ORDER BY quantity ASC");
                echo '<table width="247" border="0" cellpadding="0" cellspacing="0">';
                while ($staffel_values = vam_db_fetch_array($staffel_query)) {
                        // load data into array
?>
              <tr>
                <td><?php echo $staffel_values['quantity']; ?></td>
                <td width="5">&nbsp;</td>
                <td nowrap>
<?php
                        if (PRICE_IS_BRUTTO == 'true') {
                                $tax_query = vam_db_query("select tax_rate from ".TABLE_TAX_RATES." where tax_class_id = '".$pInfo->products_tax_class_id."' ");
                                $tax = vam_db_fetch_array($tax_query);
                                $products_price = vam_round($staffel_values['personal_offer'] * ((100 + $tax['tax_rate']) / 100), PRICE_PRECISION);

                        } else {
                                $products_price = vam_round($staffel_values['personal_offer'], PRICE_PRECISION);
                        }
                        echo $products_price;
                        if (PRICE_IS_BRUTTO == 'true') {
                                echo ' <br>'.TEXT_NETTO.'<b>'.$vamPrice->Format($staffel_values['personal_offer'], false).'</b>  ';
                        }
?>
 </td>
                <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?><a class="button" href="<?php echo vam_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&function=delete&quantity=' . $staffel_values['quantity'] . '&statusID=' . $group_data[$col]['STATUS_ID'] . '&action=new_product&pID=' . $_GET['pID']); ?>"><span><?php echo BUTTON_DELETE; ?></span></a></td>
              </tr>
<?php
                }
                echo '</table>';
                echo TXT_STK;
                echo vam_draw_small_input_field('products_quantity_staffel_'.$group_data[$col]['STATUS_ID'], 0);
                echo TXT_PRICE;
                echo vam_draw_input_field('products_price_staffel_'.$group_data[$col]['STATUS_ID'], 0);
                echo vam_draw_separator('pixel_trans.gif', '10', '10');
                echo '<span class="button"><button type="submit" onClick="return confirm(\''.SAVE_ENTRY.'\')" value="' . BUTTON_INSERT . '"/>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>';
?><br></td>
          </tr>
<?php } } ?>
</div>
          <tr>
            <td><?php echo TEXT_PRODUCTS_DISCOUNT_ALLOWED; ?></td>
            <td><?php echo vam_draw_input_field('products_discount_allowed', ($pInfo->products_discount_allowed=='' ? 100 : $pInfo->products_discount_allowed)); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCTS_TAX_CLASS; ?></td>
            <td class="main"><?php echo vam_draw_pull_down_menu('products_tax_class_id', $tax_class_array, $pInfo->products_tax_class_id); ?></td>
          </tr>
