<?php
/* --------------------------------------------------------------
   $Id: orders_edit_options.php,v 1.0 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders.php,v 1.27 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (orders.php,v 1.7 2003/08/14); www.nextcommerce.org
   (c) 2004	 xt:Commerce (orders_edit_options.php,v 1.19 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 

   To do: Erweitern auf Artikelmerkmale, Rabatte und Gutscheine
	--------------------------------------------------------------*/

 $products_query = vam_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $_GET['oID'] . "' and orders_products_id = '" . $_GET['opID'] . "'");
 $products = vam_db_fetch_array($products_query);

?>
<!-- Optionsbearbeitung Anfang //-->

<?php
  $attributes_query = vam_db_query("select * from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . $_GET['oID'] . "' and orders_products_id = '" . $_GET['opID'] . "'");
?>
<table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">

<tr class="dataTableHeadingRow">
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRODUCT_OPTION;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRODUCT_OPTION_VALUE;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRICE . TEXT_SMALL_NETTO;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRICE_PREFIX;?></b></td>
<td class="dataTableHeadingContent">&nbsp;</td>
<td class="dataTableHeadingContent">&nbsp;</td>
<td class="dataTableHeadingContent">&nbsp;</td>
</tr>

<?php
while($attributes = vam_db_fetch_array($attributes_query)) {
?>
<tr class="dataTableRow">
<?php
echo vam_draw_form('product_option_edit', FILENAME_ORDERS_EDIT, 'action=product_option_edit', 'post');
echo vam_draw_hidden_field('oID', $_GET['oID']);
echo vam_draw_hidden_field('opID', $_GET['opID']);
echo vam_draw_hidden_field('pID', $_GET['pID']);
echo vam_draw_hidden_field('opAID', $attributes['orders_products_attributes_id']);
?>
<td class="dataTableContent"><?php echo vam_draw_input_field('products_options', $attributes['products_options'], 'size="20"');?></td>
<td class="dataTableContent"><?php echo vam_draw_input_field('products_options_values', $attributes['products_options_values'], 'size="20"');?></td>
<td class="dataTableContent"><?php echo vam_draw_input_field('options_values_price',$attributes['options_values_price'], 'size="10"');?></td>
<td class="dataTableContent" align="center"><?php echo $attributes['price_prefix'];?></td>
<td class="dataTableContent">
<SELECT name="prefix">
<OPTION value="+">+
<OPTION value="-">-
</SELECT>
</td>
<td class="dataTableContent">
<?php
echo '<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . BUTTON_SAVE . '</button></span>';
?>
</form>
</td>

<td class="dataTableContent">
<?php
echo vam_draw_form('product_option_delete', FILENAME_ORDERS_EDIT, 'action=product_option_delete', 'post');
echo vam_draw_hidden_field('oID', $_GET['oID']);
echo vam_draw_hidden_field('opID', $_GET['opID']);
echo vam_draw_hidden_field('opAID', $attributes['orders_products_attributes_id']);
echo '<span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . BUTTON_DELETE . '</button></span>';
?>
</form>
</td>
</tr>
<?php
}
?>
</table>
<br /><br />
<!-- Optionsbearbeitung Ende //-->



<!-- Artikel EinfпїЅgen Anfang //-->

<table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
     $products_query = vam_db_query("select
     products_attributes_id,
     products_id,
     options_id,
     options_values_id,
     options_values_price,
     price_prefix
     from
     " . TABLE_PRODUCTS_ATTRIBUTES . "
     where
     products_id = '" . $_GET['pID'] . "'
     order by
     sortorder");

?>
<table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">

<tr class="dataTableHeadingRow">
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRODUCT_ID;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_QUANTITY;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRODUCT;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRICE;?></b></td>
<td class="dataTableHeadingContent">&nbsp;</td>
</tr>

<?php
while($products = vam_db_fetch_array($products_query)) {
?>
<tr class="dataTableRow">
<?php
echo vam_draw_form('product_option_ins', FILENAME_ORDERS_EDIT, 'action=product_option_ins', 'post');
echo vam_draw_hidden_field('oID', $_GET['oID']);
echo vam_draw_hidden_field('opID', $_GET['opID']);
echo vam_draw_hidden_field('pID', $_GET['pID']);
echo vam_draw_hidden_field('aID', $products['products_attributes_id']);

$brutto = PRICE_IS_BRUTTO;
if($brutto == 'true'){
$options_values_price = vam_round(($products['options_values_price']*(1+($_GET['pTX']/100))), PRICE_PRECISION);
}else{
$options_values_price = vam_round($products['options_values_price'], PRICE_PRECISION);
}

?>
<td class="dataTableContent"><?php echo $products['products_attributes_id'];?></td>
<td class="dataTableContent"><?php echo vam_oe_get_options_name($products['options_id']);?></td>
<td class="dataTableContent"><?php echo vam_oe_get_options_values_name($products['options_values_id']);?></td>
<td class="dataTableContent">
<?php echo vam_draw_hidden_field('options_values_price', $products['options_values_price']);?>
<?php echo $vamPrice->Format($vamPrice->CalculateCurr($options_values_price),true);?>
</td>
<td class="dataTableContent">
<?php
echo '<span class="button"><button type="submit" value="' . BUTTON_EDIT . '">' . BUTTON_EDIT . '</button></span>';
?>
</form>
</td>
</tr>
<?php
}
?>
</table>

<br /><br />
<!-- Artikel EinfпїЅgen Ende //-->