<?php
/* --------------------------------------------------------------
   $Id: customer_memo.php 955 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (customer_memo.php,v 1.6 2003/08/18); www.nextcommerce.org
   (c) 2004 xt:Commerce (customer_memo.php,v 1.6 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

?>
    <td valign="top" class="main"><?php echo ENTRY_MEMO; ?></td>
    <td class="main"><?php
  $memo_query = vam_db_query("SELECT
                                  *
                              FROM
                                  " . TABLE_CUSTOMERS_MEMO . "
                              WHERE
                                  customers_id = '" . $_GET['cID'] . "'
                              ORDER BY
                                  memo_date DESC");
  while ($memo_values = vam_db_fetch_array($memo_query)) {
    $poster_query = vam_db_query("SELECT customers_firstname, customers_lastname FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . $memo_values['poster_id'] . "'");
    $poster_values = vam_db_fetch_array($poster_query);
?><table width="100%">
      <tr>
        <td class="main"><b><?php echo TEXT_DATE; ?></b>: <i><?php echo $memo_values['memo_date']; ?></i> <b><?php echo TEXT_TITLE; ?></b>: <?php echo $memo_values['memo_title']; ?><b>  <?php echo TEXT_POSTER; ?></b>: <?php echo $poster_values['customers_lastname']; ?> <?php echo $poster_values['customers_firstname']; ?></td>
      </tr>
      <tr>
        <td width="142" class="main" style="border: 1px solid; border-color: #cccccc;"><?php echo $memo_values['memo_text']; ?></td>
      </tr>
      <tr>
        <td><a class="button" href="<?php echo vam_href_link(FILENAME_CUSTOMERS, 'cID=' . $_GET['cID'] . '&action=edit&special=remove_memo&mID=' . $memo_values['memo_id']); ?>" onClick="return confirm('<?php echo DELETE_ENTRY; ?>')"><span><?php echo BUTTON_DELETE; ?></span></a></td>
      </tr>
    </table>
<?php
  }
?>
    <table width="100%">
      <tr>
        <td class="main" style="border-top: 1px solid; border-color: #cccccc;"><b><?php echo TEXT_TITLE ?></b>: <?php echo vam_draw_input_field('memo_title'); ?><br><?php echo vam_draw_textarea_field('memo_text', 'soft', '80', '5'); ?><br><span class="button"><button type="submit" value="<?php echo BUTTON_INSERT; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12');?> &nbsp;<?php echo BUTTON_INSERT; ?></button></span></td>
      </tr>
    </table></td>