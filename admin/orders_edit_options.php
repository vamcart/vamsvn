<?php
/* --------------------------------------------------------------
   $Id: orders_edit.php,v 1.0

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   XTC-Bestellbearbeitung:
   http://www.xtc-webservice.de / Matthias Hinsche
   info@xtc-webservice.de

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders.php,v 1.27 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (orders.php,v 1.7 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 

   To do: Erweitern auf Artikelmerkmale, Rabatte und Gutscheine
	--------------------------------------------------------------*/

 $products_query = xtc_db_query("select * from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $_GET['oID'] . "' and orders_products_id = '" . $_GET['opID'] . "'");
 $products = xtc_db_fetch_array($products_query);

?>
<!-- Optionsbearbeitung Anfang //-->

<?php
  $attributes_query = xtc_db_query("select * from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . $_GET['oID'] . "' and orders_products_id = '" . $_GET['opID'] . "'");
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">

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
while($attributes = xtc_db_fetch_array($attributes_query)) {
?>
<tr class="dataTableRow">
<?php
echo xtc_draw_form('product_option_edit', FILENAME_ORDERS_EDIT, 'action=product_option_edit', 'post');
echo xtc_draw_hidden_field('oID', $_GET['oID']);
echo xtc_draw_hidden_field('opID', $_GET['opID']);
echo xtc_draw_hidden_field('pID', $_GET['pID']);
echo xtc_draw_hidden_field('opAID', $attributes['orders_products_attributes_id']);
?>
<td class="dataTableContent"><?php echo xtc_draw_input_field('products_options', $attributes['products_options'], 'size="20"');?></td>
<td class="dataTableContent"><?php echo xtc_draw_input_field('products_options_values', $attributes['products_options_values'], 'size="20"');?></td>
<td class="dataTableContent"><?php echo xtc_draw_input_field('options_values_price',$attributes['options_values_price'], 'size="10"');?></td>
<td class="dataTableContent" align="center"><?php echo $attributes['price_prefix'];?></td>
<td class="dataTableContent">
<SELECT name="prefix">
<OPTION value="+">+
<OPTION value="-">-
</SELECT>
</td>
<td class="dataTableContent">
<?php
echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>';
?>
</form>
</td>

<td class="dataTableContent">
<?php
echo xtc_draw_form('product_option_delete', FILENAME_ORDERS_EDIT, 'action=product_option_delete', 'post');
echo xtc_draw_hidden_field('oID', $_GET['oID']);
echo xtc_draw_hidden_field('opID', $_GET['opID']);
echo xtc_draw_hidden_field('opAID', $attributes['orders_products_attributes_id']);
echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_DELETE . '"/>';
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



<!-- Artikel Einf�gen Anfang //-->

<table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
     $products_query = xtc_db_query("select
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
<table border="0" width="100%" cellspacing="0" cellpadding="2">

<tr class="dataTableHeadingRow">
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRODUCT_ID;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_QUANTITY;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRODUCT;?></b></td>
<td class="dataTableHeadingContent"><b><?php echo TEXT_PRICE;?></b></td>
<td class="dataTableHeadingContent">&nbsp;</td>
</tr>

<?php
while($products = xtc_db_fetch_array($products_query)) {
?>
<tr class="dataTableRow">
<?php
echo xtc_draw_form('product_option_ins', FILENAME_ORDERS_EDIT, 'action=product_option_ins', 'post');
echo xtc_draw_hidden_field('oID', $_GET['oID']);
echo xtc_draw_hidden_field('opID', $_GET['opID']);
echo xtc_draw_hidden_field('pID', $_GET['pID']);
echo xtc_draw_hidden_field('aID', $products['products_attributes_id']);

$brutto = PRICE_IS_BRUTTO;
if($brutto == 'true'){
$options_values_price = xtc_round(($products['options_values_price']*(1+($_GET['pTX']/100))), PRICE_PRECISION);
}else{
$options_values_price = xtc_round($products['options_values_price'], PRICE_PRECISION);
}

?>
<td class="dataTableContent"><?php echo $products['products_attributes_id'];?></td>
<td class="dataTableContent"><?php echo xtc_oe_get_options_name($products['options_id']);?></td>
<td class="dataTableContent"><?php echo xtc_oe_get_options_values_name($products['options_values_id']);?></td>
<td class="dataTableContent">
<?php echo xtc_draw_hidden_field('options_values_price', $products['options_values_price']);?>
<?php echo $xtPrice->xtcFormat($xtPrice->xtcCalculateCurr($options_values_price),true);?>
</td>
<td class="dataTableContent">
<?php
echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_EDIT . '"/>';
?>
</form>
</td>
</tr>
<?php
}
?>
</table>

<br /><br />
<!-- Artikel Einf�gen Ende //-->









