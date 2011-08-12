<?php
/* --------------------------------------------------------------
   $Id: customer_to_manufacturer_discount.php 2009-06-14 12:00:00 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

?>
    <td valign="top" class="main"><?php echo ENTRY_DISCOUNT_CUSTOMER_TO_MANUFACTURER; ?></td>
    <td class="main"><?php
  $manufacturer_query = vam_db_query("SELECT manufacturers_id, manufacturers_name FROM " . TABLE_MANUFACTURERS);

  $discount_query = vam_db_query("SELECT * FROM " 
                                  . TABLE_CUSTOMERS_TO_MANUFACTURERS_DISCOUNT . " AS d 
                                  LEFT JOIN ". TABLE_MANUFACTURERS. " AS m 
                                  ON d.manufacturers_id=m.manufacturers_id
                                  WHERE d.customers_id = '" . $_GET['cID'] . "'");

  $select_string="<select name='manufacturer_discount_select'>";

  while ($manufacturer_values = vam_db_fetch_array($manufacturer_query)) {
    $select_string .= '<option value="'.$manufacturer_values['manufacturers_id'].'">'.$manufacturer_values['manufacturers_name'].'</option>';
  }
  $select_string .= '</select>';
  
  $i=0;
  while ($discount_values = vam_db_fetch_array($discount_query)) {
?><table width="100%">
      <tr>
        <td class="main">
            <?php
		echo vam_draw_input_field('discount_m_'.$i, $discount_values['discount'], 'disabled' );
	    ?>%
        </td>
        <td class="main">
            <?php 
		echo vam_draw_input_field('manufacturer_name_'.$i, $discount_values['manufacturers_name'], 'disabled' );
		echo vam_draw_hidden_field('manufacturer_'.$i, $discount_values['manufacturers_id'] );
            ?>
        </td>
        <td><a class="button" href="<?php echo vam_href_link(FILENAME_CUSTOMERS, 'cID=' . $_GET['cID'] . '&action=edit&special=remove_discount&mID=' . $discount_values['discount_id']); ?>" onClick="return confirm('<?php echo DELETE_ENTRY; ?>')"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12');?>&nbsp;<?php echo BUTTON_DELETE; ?></span></a></td>
      </tr>
    </table>
<?php
  $i++;
  }
?>
    <table width="100%">
      <tr>
        <td class="main"><?php echo vam_draw_input_field('manufacturer_discount_new'); ?>%
        <?php echo $select_string; ?>
        <span class="button"><button type="submit" value="<?php echo BUTTON_INSERT; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_INSERT; ?></button></span></td>
      </tr>
    </table></td>
    