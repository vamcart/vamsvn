<?php
/* --------------------------------------------------------------
   $Id: new_product.php 897 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.140 2003/03/24); www.oscommerce.com
   (c) 2003  nextcommerce (categories.php,v 1.37 2003/08/18); www.nextcommerce.org
   (c) 2004 xt:Commerce (new_product.php,v 1.9 2003/08/21); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contribution:
   Enable_Disable_Categories 1.3               Autor: Mikel Williams | mikel@ladykatcostumes.com
   New Attribute Manager v4b                   Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
   Category Descriptions (Version: 1.5 MS2)    Original Author:   Brian Lowe <blowe@wpcusrgrp.org> | Editor: Lord Illicious <shaolin-venoms@illicious.net>
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   --------------------------------------------------------------*/

if (($_GET['pID']) && (!$_POST)) {
        $product_query = vam_db_query("select *, date_format(p.products_date_available, '%Y-%m-%d') as products_date_available
                                       from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd
                                  where p.products_id = '".(int) $_GET['pID']."'
                                  and p.products_id = pd.products_id
                                  and pd.language_id = '".$_SESSION['languages_id']."'");

        $product = vam_db_fetch_array($product_query);
        $pInfo = new objectInfo($product);

      $products_extra_fields_query = vam_db_query("SELECT * FROM " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " WHERE products_id=" . (int)$_GET['pID']);
      while ($products_extra_fields = vam_db_fetch_array($products_extra_fields_query)) {
        $extra_field[$products_extra_fields['products_extra_fields_id']] = $products_extra_fields['products_extra_fields_value'];
      }
	  $extra_field_array=array('extra_field'=>$extra_field);
	  $pInfo->objectInfo($extra_field_array);

}
elseif ($_POST) {
        $pInfo = new objectInfo($_POST);
        $products_name = $_POST['products_name'];
        $products_description = $_POST['products_description'];
        $products_short_description = $_POST['products_short_description'];
        $products_keywords = $_POST['products_keywords'];
        $products_meta_title = $_POST['products_meta_title'];
        $products_meta_description = $_POST['products_meta_description'];
        $products_meta_keywords = $_POST['products_meta_keywords'];
// Start Products Specifications
      $products_spec = $_POST['products_spec'];
      $products_musthave = $_POST['products_musthave'];
      $products_extraimage = $_POST['products_extraimage'];
      $products_manual = $_POST['products_manual'];
      $products_extra1 = $_POST['products_extra1'];
      $products_moreinfo = $_POST['products_moreinfo'];
// End Products Specifications
        $products_url = $_POST['products_url'];
        // Products URL begin
        $products_page_url = $_POST['products_page_url'];
        // Products URL end
        $pInfo->products_startpage = $_POST['products_startpage'];
   $products_startpage_sort = $_POST['products_startpage_sort'];
} else {
        $pInfo = new objectInfo(array ());
}

    // BOF Bundled Products
    $bundle_array = array();
    if (isset($pInfo->products_bundle) && $pInfo->products_bundle == "yes") {
      // this product is a bundle so get contents data 
      $bundle_query = vam_db_query("SELECT distinct pb.subproduct_id, pb.subproduct_qty, pd.products_name FROM " . TABLE_PRODUCTS_DESCRIPTION . " pd INNER JOIN " . TABLE_PRODUCTS_BUNDLES . " pb ON pb.subproduct_id=pd.products_id WHERE pb.bundle_id = '" . (int)$_GET['pID'] . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'");
      while ($bundle_contents = vam_db_fetch_array($bundle_query)) {
        $bundle_array[] = array('id' => $bundle_contents['subproduct_id'],
                                'qty' => $bundle_contents['subproduct_qty'],
                                'name' => $bundle_contents['products_name']);
      }
    }
    $bundle_count = count($bundle_array);
    // EOF Bundled Products


$manufacturers_array = array (array ('id' => '', 'text' => TEXT_NONE));
$manufacturers_query = vam_db_query("select manufacturers_id, manufacturers_name from ".TABLE_MANUFACTURERS." order by manufacturers_name");
while ($manufacturers = vam_db_fetch_array($manufacturers_query)) {
        $manufacturers_array[] = array ('id' => $manufacturers['manufacturers_id'], 'text' => $manufacturers['manufacturers_name']);
}

$labels_array = array (array ('id' => '', 'text' => TEXT_NONE));
$labels_query = vam_db_query("select id, name from ".TABLE_PRODUCT_LABELS." order by sort_order asc");
while ($labels = vam_db_fetch_array($labels_query)) {
        $labels_array[] = array ('id' => $labels['id'], 'text' => $labels['name']);
}

$vpe_array = array (array ('id' => '', 'text' => TEXT_NONE));
$vpe_query = vam_db_query("select products_vpe_id, products_vpe_name from ".TABLE_PRODUCTS_VPE." WHERE language_id='".$_SESSION['languages_id']."' order by products_vpe_name");
while ($vpe = vam_db_fetch_array($vpe_query)) {
        $vpe_array[] = array ('id' => $vpe['products_vpe_id'], 'text' => $vpe['products_vpe_name']);
}

$tax_class_array = array (array ('id' => '0', 'text' => TEXT_NONE));
$tax_class_query = vam_db_query("select tax_class_id, tax_class_title from ".TABLE_TAX_CLASS." order by tax_class_title");
while ($tax_class = vam_db_fetch_array($tax_class_query)) {
        $tax_class_array[] = array ('id' => $tax_class['tax_class_id'], 'text' => $tax_class['tax_class_title']);
}
$shipping_statuses = array ();
$shipping_statuses = vam_get_shipping_status();
$languages = vam_get_languages();

switch ($pInfo->products_status) {
        case '0' :
                $status = false;
                $out_status = true;
                break;
        case '1' :
        default :
                $status = true;
                $out_status = false;
}

switch ($pInfo->products_to_xml) {
        case '0' :
                $in_xml = false;
                $out_xml = true;
                break;
        case '1' :
        default :
                $in_xml = true;
                $out_xml = false;
}


if ($pInfo->products_startpage == '1') { $startpage_checked = true; } else { $startpage_checked = false; }

?>
<link href="includes/javascript/date-picker/css/datepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/javascript/date-picker/js/datepicker.js"></script>

<script type="text/javascript" src="includes/javascript/modified.js"></script>
<?php if (ENABLE_TABS == 'true') { ?>
		<script type="text/javascript">
			$(function(){
				$('#tabs').tabs({ fx: { opacity: 'toggle', duration: 'fast' } });
			});
		</script>
<?php } ?>

<tr><td>
<?php 
$form_action = ($_GET['pID']) ? 'update_product' : 'insert_product';  
$manual_link = ($_GET['pID']) ? 'edit-product' : 'add-product';  
?>
<?php $fsk18_array=array(array('id'=>0,'text'=>NO),array('id'=>1,'text'=>YES)); ?>
<table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td>
            
            
<?php
    echo vam_draw_form('new_product', FILENAME_CATEGORIES, 'cPath=' . $_GET['cPath'] . '&pID=' . $_GET['pID'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '') . '&action='.$form_action, 'post', 'enctype="multipart/form-data" cf="true"');
    echo vam_draw_hidden_field('products_date_added', (($pInfo->products_date_added) ? $pInfo->products_date_added : date('Y-m-d')));
    echo vam_draw_hidden_field('products_id', $pInfo->products_id);
?>
    <span class="button"><button type="submit" value="<?php echo BUTTON_SAVE; ?>" cf="false"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_SAVE; ?></button></span>
    <a class="button" href="<?php echo vam_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $_GET['pID'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : '')); ?>"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12');?>&nbsp;<?php echo BUTTON_CANCEL; ?></span></a>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a class="button" href="<?php echo vam_href_link(FILENAME_NEW_ATTRIBUTES, 'action=edit' . '&current_product_id=' . $_GET['pID'] . '&cpath=' . $cPath); ?>"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_EDIT_ATTRIBUTES; ?></span></a>
    <a class="button" href="<?php echo vam_href_link(FILENAME_CATEGORIES, 'action=edit_crossselling' . '&current_product_id=' . $_GET['pID'] . '&cpath=' . $cPath); ?>"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_EDIT_CROSS_SELLING; ?></span></a>
            
            
            
            </td>
            <td align="right"><a class="button" href="<?php echo MANUAL_LINK_PRODUCTS.'#'.$manual_link; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>

<div id="tabs">

			<ul>
<?php
    for ($i=0; $i<sizeof($languages); $i++) {
?>
				<li><a href="#tab<?php echo $i; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/'.$languages[$i]['code'].'.png', '', '16', '16'); ?>&nbsp;<?php echo $languages[$i]['name']; ?></a></li>
<?php 
}
?>
				<li><a href="#data"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/edit.png', '', '16', '16'); ?>&nbsp;<?php echo TEXT_PRODUCTS_DATA; ?></a></li>
				<li><a href="#images"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/images.png', '', '16', '16'); ?>&nbsp;<?php echo strip_tags(HEADING_PRODUCT_IMAGES); ?></a></li>
				<li><a href="#options"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/calculator.png', '', '16', '16'); ?>&nbsp;<?php echo strip_tags(HEADING_PRICES_OPTIONS); ?></a></li>
				<li><a href="#attributes"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/attributes.png', '', '16', '16'); ?>&nbsp;<?php echo strip_tags(TEXT_PRODUCTS_ATTRIBUTES); ?></a></li>
<?php
    if (GROUP_CHECK == 'true') {
?>
				<li><a href="#groups"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/account.png', '', '16', '16'); ?>&nbsp;<?php echo ENTRY_CUSTOMERS_ACCESS; ?></a></li>
<?php 
}
?>
				<li><a href="#fields"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/other.png', '', '16', '16'); ?>&nbsp;<?php echo strip_tags(BOX_PRODUCT_EXTRA_FIELDS); ?></a></li>
				<li><a href="#specs"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/filter.png', '', '16', '16'); ?>&nbsp;<?php echo strip_tags(TEXT_TAB_SPECIFICATIONS); ?></a></li>
				<li><a href="#bundles"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/products.png', '', '16', '16'); ?>&nbsp;<?php echo strip_tags(TEXT_TAB_BUNDLES); ?></a></li>
			</ul>

<?php for ($i = 0, $n = sizeof($languages); $i < $n; $i++) { ?>
        <div id="tab<?php echo $i; ?>">
          <table border="0">
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_NAME; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_name[' . $languages[$i]['id'] . ']', (($products_name[$languages[$i]['id']]) ? stripslashes($products_name[$languages[$i]['id']]) : vam_get_products_name($pInfo->products_id, $languages[$i]['id'])),'size=60'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_DESCRIPTION; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_textarea_field('products_description_' . $languages[$i]['id'], 'soft', '95', '25', (($products_description[$languages[$i]['id']]) ? stripslashes($products_description[$languages[$i]['id']]) : vam_get_products_description($pInfo->products_id, $languages[$i]['id']))); ?><br /><a href="javascript:toggleHTMLEditor('<?php echo 'products_description_' . $languages[$i]['id'];?>');"><?php echo TEXT_TOGGLE_EDITOR; ?></a></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_SHORT_DESCRIPTION; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_textarea_field('products_short_description_' . $languages[$i]['id'], 'soft', '95', '25', (($products_short_description[$languages[$i]['id']]) ? stripslashes($products_short_description[$languages[$i]['id']]) : vam_get_products_short_description($pInfo->products_id, $languages[$i]['id']))); ?><br /><a href="javascript:toggleHTMLEditor('<?php echo 'products_short_description_' . $languages[$i]['id'];?>');"><?php echo TEXT_TOGGLE_EDITOR; ?></a></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_KEYWORDS; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_keywords[' . $languages[$i]['id'] . ']',(($products_keywords[$languages[$i]['id']]) ? stripslashes($products_keywords[$languages[$i]['id']]) : vam_get_products_keywords($pInfo->products_id, $languages[$i]['id'])), 'size=80 maxlenght=255'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_URL; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_url[' . $languages[$i]['id'] . ']', (($products_url[$languages[$i]['id']]) ? stripslashes($products_url[$languages[$i]['id']]) : vam_get_products_url($pInfo->products_id, $languages[$i]['id'])),'size=60') . '&nbsp;<small>' . TEXT_PRODUCTS_URL_WITHOUT_HTTP . '</small>'; ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_META_TITLE; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_meta_title[' . $languages[$i]['id'] . ']',(($products_meta_title[$languages[$i]['id']]) ? stripslashes($products_meta_title[$languages[$i]['id']]) : vam_get_products_meta_title($pInfo->products_id, $languages[$i]['id'])), 'size=80 maxlenght=50'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_META_DESCRIPTION; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_meta_description[' . $languages[$i]['id'] . ']',(($products_meta_description[$languages[$i]['id']]) ? stripslashes($products_meta_description[$languages[$i]['id']]) : vam_get_products_meta_description($pInfo->products_id, $languages[$i]['id'])), 'size=80 maxlenght=50'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_META_KEYWORDS; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_meta_keywords[' . $languages[$i]['id'] . ']', (($products_meta_keywords[$languages[$i]['id']]) ? stripslashes($products_meta_keywords[$languages[$i]['id']]) : vam_get_products_meta_keywords($pInfo->products_id, $languages[$i]['id'])), 'size=80 maxlenght=50'); ?></td>
          </tr>
          </table>
        </div>
<?php } ?>

<!-- info -->
        <div id="data">
          <table border="0">
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_STATUS; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_radio_field('products_status', '1', $status) . '&nbsp;' . TEXT_PRODUCT_AVAILABLE . '&nbsp;' . vam_draw_radio_field('products_status', '0', $out_status) . '&nbsp;' . TEXT_PRODUCT_NOT_AVAILABLE; ?></td>
            <td>&nbsp;&nbsp;</td>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_DATE_AVAILABLE; ?> <small>(YYYY-MM-DD)</small></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_date_available', $pInfo->products_date_available, 'size="10" class="format-y-m-d dividor-slash"'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_STARTPAGE; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_radio_field('products_startpage', '1', $startpage_checked) . '&nbsp;' . TEXT_PRODUCTS_STARTPAGE_YES . vam_draw_radio_field('products_startpage', '0', !$startpage_checked) . '&nbsp;' . TEXT_PRODUCTS_STARTPAGE_NO; ?></td>
            <td></td>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_STARTPAGE_SORT; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_startpage_sort', $pInfo->products_startpage_sort ,'size=3'); ?></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_SORT; ?></td>
            <td valign="top" class="main"><?php echo  vam_draw_input_field('products_sort', $pInfo->products_sort,'size=3'); ?></td>
          </tr>
<!--// Products URL begin //-->
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_PAGE_URL; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_page_url', $pInfo->products_page_url,'size=40'); ?></td>
          </tr>
<!--// Products URL end //-->
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_QUANTITY; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_quantity', $pInfo->products_quantity,'size=5'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_QUANTITY_MIN; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_quantity_min', ($pInfo->products_quantity_min=='' ? 1 : $pInfo->products_quantity_min)); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_QUANTITY_MAX; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_quantity_max', ($pInfo->products_quantity_max=='' ? 1000 : $pInfo->products_quantity_max)); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_WEIGHT; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_weight', $pInfo->products_weight,'size=4') . '&nbsp;' . TEXT_PRODUCTS_WEIGHT_INFO; ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_LENGTH; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_length', ($pInfo->products_length=='' ? 0 : $pInfo->products_length)); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_WIDTH; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_width', ($pInfo->products_width=='' ? 0 : $pInfo->products_width)); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_HEIGHT; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_height', ($pInfo->products_height=='' ? 0 : $pInfo->products_height)); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_VOLUME; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_volume', ($pInfo->products_volume=='' ? 0 : $pInfo->products_volume)); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_MODEL; ?></td>
            <td valign="top" class="main"><?php echo  vam_draw_input_field('products_model', $pInfo->products_model); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_EAN; ?></td>
            <td valign="top" class="main"><?php echo  vam_draw_input_field('products_ean', $pInfo->products_ean); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_MANUFACTURER; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_pull_down_menu('manufacturers_id', $manufacturers_array, $pInfo->manufacturers_id); ?>&nbsp;<a href="<?php echo vam_href_link(FILENAME_MANUFACTURERS, '', 'NONSSL', false); ?>"><?php echo TEXT_EDIT; ?></a></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_LABEL; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_pull_down_menu('label_id', $labels_array, $pInfo->label_id); ?>&nbsp;<a href="<?php echo vam_href_link(FILENAME_PRODUCT_LABELS, '', 'NONSSL', false); ?>"><?php echo TEXT_EDIT; ?></a></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_FSK18; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_pull_down_menu('fsk18', $fsk18_array, $pInfo->products_fsk18); ?></td>
          </tr>
          <tr>
          <?php if (ACTIVATE_SHIPPING_STATUS=='true') { ?>
          <tr>
            <td valign="top" class="main"><?php echo BOX_SHIPPING_STATUS.':'; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_pull_down_menu('shipping_status', $shipping_statuses, (isset($pInfo->products_shippingtime) ? $pInfo->products_shippingtime : DEFAULT_SHIPPING_STATUS_ID)); ?>&nbsp;<a href="<?php echo vam_href_link(FILENAME_SHIPPING_STATUS, '', 'NONSSL', false); ?>"><?php echo TEXT_EDIT; ?></a></td>
          </tr>
          <?php } ?>
      <tr>
<?php
$files = array();
foreach (array('product_info', 'product_options') as $key) {
    if ($dir = opendir(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/'.$key.'/')) {
        while (($file = readdir($dir)) !== false) {
            if (is_file(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/'.$key.'/'.$file) and ($file != "index.html")) {
                $files[$key][] = array ('id' => $file, 'text' => $file);
            } //if
        } // while
        closedir($dir);
    }
    // set default value in dropdown!
    if ($content['content_file'] == '') {
        $files[$key] = array_merge(array(array('id' => 'default', 'text' => TEXT_SELECT)), $files[$key]);
    } else {
        $files[$key] = array_merge(array(array('id' => 'default', 'text' => TEXT_NO_FILE)), $files[$key]);
    }
}
?>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_CHOOSE_INFO_TEMPLATE; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_pull_down_menu('info_template', $files['product_info'], $pInfo->product_template); ?></td>
          <tr>
          </tr>
            <td valign="top" class="main"><?php echo TEXT_CHOOSE_OPTIONS_TEMPLATE.':'; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_pull_down_menu('options_template', $files['product_options'], $pInfo->options_template); ?></td>
          </tr>
          <tr>
            <td valign="top" colspan="2" class="main"><?php echo TEXT_YANDEX_MARKET; ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_TO_XML; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_radio_field('products_to_xml', '1', $in_xml) . '&nbsp;' . TEXT_PRODUCT_AVAILABLE_TO_XML . '&nbsp;' . vam_draw_radio_field('products_to_xml', '0', $out_xml) . '&nbsp;' . TEXT_PRODUCT_NOT_AVAILABLE_TO_XML; ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_YANDEX_MARKET_BID; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('yml_bid', $pInfo->yml_bid, 'size="2"'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_YANDEX_MARKET_CBID; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('yml_cbid', $pInfo->yml_cbid, 'size="2"'); ?></td>
          </tr>
          </table>
        </div>
<!-- info -->
<!-- images -->
        <div id="images">
        <table border="0" class="main">
        <?php include (DIR_WS_MODULES.'products_images.php'); ?>
        </table>
        </div>
<!-- images -->
<!-- price -->
        <div id="options">
        <table border="0" class="main">
          <?php include(DIR_WS_MODULES.'group_prices.php'); ?>
          <tr>
            <td colspan="4"><?php echo vam_draw_separator('pixel_black.gif', '100%', '1'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_VPE_VISIBLE; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_selection_field('products_vpe_status', 'checkbox', '1',$pInfo->products_vpe_status==1 ? true : false); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_VPE_VALUE; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('products_vpe_value', $pInfo->products_vpe_value,'size=4'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_VPE; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_pull_down_menu('products_vpe', $vpe_array, $pInfo->products_vpe='' ?  DEFAULT_PRODUCTS_VPE_ID : $pInfo->products_vpe); ?>&nbsp;<a href="<?php echo vam_href_link(FILENAME_PRODUCTS_VPE, '', 'NONSSL', false); ?>"><?php echo TEXT_EDIT; ?></a></td>
          </tr>
        </table>
        </div>
<!-- price -->
<!-- attributes-->
        <div id="attributes">
        <?php require_once( 'attributeManager/includes/attributeManagerPlaceHolder.inc.php' )?>
        </div>
<!-- /attributes-->
<!-- group check-->
<?php
    if (GROUP_CHECK == 'true') {
        $customers_statuses_array = vam_get_customers_statuses();
        $customers_statuses_array = array_merge(array (array ('id' => 'all', 'text' => TXT_ALL)), $customers_statuses_array);
?>
        <div id="groups">
<?php
    for ($i = 0; $n = sizeof($customers_statuses_array), $i < $n; $i ++) {
        $code = '$id=$pInfo->group_permission_'.$customers_statuses_array[$i]['id'].';';
        eval ($code);
        $checked = ($id==1) ? 'checked ' : '';
        echo '<input type="checkbox" name="groups[]" value="'.$customers_statuses_array[$i]['id'].'"'.$checked.'> '.$customers_statuses_array[$i]['text'].'<br />';
    }
?>
        </div>
<?php } ?>

        <div id="fields">
        <table border="0" class="main">

<?php
// START: Extra Fields Contribution (chapter 1.4)
      // Sort language by ID  
	  for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
	    $languages_array[$languages[$i]['id']]=$languages[$i];
	  }
      $extra_fields_query = vam_db_query("SELECT * FROM " . TABLE_PRODUCTS_EXTRA_FIELDS . " ORDER BY products_extra_fields_order");
      while ($extra_fields = vam_db_fetch_array($extra_fields_query)) {
	  // Display language icon or blank space
        if ($extra_fields['languages_id']==0) {
	      $m=vam_draw_separator('pixel_trans.gif', '24', '15');
	    } else $m= $languages_array[$extra_fields['languages_id']]['name'];
?>
          <tr>
            <td class="main"><?php echo $m . ' ' . $extra_fields['products_extra_fields_name']; ?>:</td>
            <td class="main"><?php echo vam_draw_input_field("extra_field[".$extra_fields['products_extra_fields_id']."]", $pInfo->extra_field[$extra_fields['products_extra_fields_id']]); ?></td>
          </tr>
<?php
}
?>

          <tr>
            <td colspan="2" class="main"><a href="<?php echo vam_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS, '', 'NONSSL', false); ?>"><?php echo TEXT_EDIT_FIELDS; ?></a></td>
          </tr>

<?php
	if (vam_db_num_rows($extra_fields_query) <= 0) {
?>

          <tr>
            <td colspan="2" class="main"><a href="<?php echo vam_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS, '', 'NONSSL', false); ?>"><?php echo TEXT_ADD_FIELDS; ?></a></td>
          </tr>

<?php
}
// END: Extra Fields Contribution
?>     
        
        </table>
        </div>

        <div id="specs">
        
          <table border="0" class="main">

          <tr>
            <td colspan=2>
<?php 
// Products Specifications
      require (DIR_WS_MODULES . FILENAME_PRODUCTS_SPECIFICATIONS_INPUT);
?>
          </table>
                  
        </div>
        
        
        <div id="bundles">
        
          <table border="0" class="main">

          <tr>
            <td colspan=2>

<!-- BOF Bundled Products -->
          <tr>
            <td valign="top" colspan="2">
            <?php if ($pInfo->sold_in_bundle_only == 'yes') { $sold_in_bundle_only_checked = true; } else { $sold_in_bundle_only_checked = false; } ?>
            <?php echo vam_draw_radio_field('sold_in_bundle_only', 'no', !$sold_in_bundle_only_checked) . ENTRY_AVAILABLE_SEPARATELY . '<br />' . vam_draw_radio_field('sold_in_bundle_only', 'yes', $sold_in_bundle_only_checked) . ENTRY_IN_BUNDLE_ONLY; ?>
            </td>
          </tr>
          <tr>
            <td valign="top">
              <?php echo TEXT_PRODUCTS_BUNDLE; ?>
              <?php echo '<br />' . vam_draw_pull_down_menu('products_bundle', array(array('id'=>'no','text'=>NO),array('id'=>'yes','text'=>YES)), $pInfo->products_bundle) . '<br />'; ?>
            </td>
          </tr>
          <tr>
            <td class="main" valign="top">
              <table>
                <tr>
                  <td  class="main" valign="top">
                    <?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '<a href="javascript:" onclick="addSubproduct()">' . TEXT_ADD_LINE . '</a><br />'; ?>
                  </td>
                  <td class="main" valign="top">
<script type="text/javascript"><!--
function fillCodes() {
  for (var n=0;n<100;n++) {
    var this_subproduct_id = eval("document.new_product.subproduct_" + n + "_id")
    var this_subproduct_name = eval("document.new_product.subproduct_" + n + "_name")
    var this_subproduct_qty = eval("document.new_product.subproduct_" + n + "_qty")
    if (this_subproduct_id.value == "") {
      this_subproduct_id.value = document.new_product.subproduct_selector.value
      this_subproduct_qty.value = "1"
      var name = document.new_product.subproduct_selector[document.new_product.subproduct_selector.selectedIndex].text
        this_subproduct_name.value = name
        document.returnValue = true;
        return true;
    }
  }
}

function clearSubproduct(n) {
  var this_subproduct_id = eval("document.new_product.subproduct_" + n + "_id");
  var this_subproduct_name = eval("document.new_product.subproduct_" + n + "_name");
  var this_subproduct_qty = eval("document.new_product.subproduct_" + n + "_qty");
  this_subproduct_id.value = "";
  this_subproduct_name.value = "";
  this_subproduct_qty.value = "";
}

function addSubproduct(){
  var n = parseInt(document.getElementById('bundled_subproducts_i').value);
  var HTML = document.getElementById('bundled_subproducts');
  currentElement = document.createElement("input");
  currentElement.setAttribute("disabled","");
  currentElement.setAttribute("size","30");
  currentElement.setAttribute("type", "text");
  currentElement.setAttribute("name", 'subproduct_' + n + '_name');
  currentElement.setAttribute("value", "");
  HTML.appendChild(currentElement);
  currentElement = document.createElement("input");
  currentElement.setAttribute("size","3");
  currentElement.setAttribute("type", "hidden");
  currentElement.setAttribute("name", 'subproduct_' + n + '_id');
  currentElement.setAttribute("value", "");
  HTML.appendChild(currentElement);
  currentElement = document.createTextNode(' ');
  HTML.appendChild(currentElement);
  currentElement = document.createElement("input");
  currentElement.setAttribute("size","3");
  currentElement.setAttribute("type", "text");
  currentElement.setAttribute("name", 'subproduct_' + n + '_qty');
  currentElement.setAttribute("value", "");
  HTML.appendChild(currentElement);
  document.createTextNode('&nbsp;');
  HTML.appendChild(currentElement);
  var myLink = document.createElement('a');
  var href = document.createAttribute('href');
  myLink.setAttribute('href','javascript:');
  myLink.setAttribute('onclick', 'clearSubproduct(' + n + ')');
  <?php echo "myLink.innerText = ' [x] " . TEXT_REMOVE_PRODUCT . "';\n"; ?>
  HTML.appendChild(myLink);
  currentElement = document.createElement("br");
  HTML.appendChild(currentElement);
  document.getElementById('bundled_subproducts_i').value = n + 1;
}
            //--></script>
                    <div id="bundled_subproducts">
<?php
    echo TEXT_BUNDLE_HEADING . "<br />\n";
    for ($i=0, $n = $bundle_count ? $bundle_count+1 : 3; $i<$n; $i++) {
      echo '<input type="text" disabled size="30" name="subproduct_' . $i . '_name" value="' . (isset($bundle_array[$i]['name']) ? vam_output_string($bundle_array[$i]['name']) : '') . '">' . "\n";
      echo '<input type="hidden" size="3" name="subproduct_' . $i . '_id" value="' . (isset($bundle_array[$i]['id']) ? $bundle_array[$i]['id'] : '') . '">' . "\n";
      echo '<input type="text" size="3" name="subproduct_' . $i . '_qty" value="' . (isset($bundle_array[$i]['id']) ? $bundle_array[$i]['qty'] : '') . '">' . "\n";
      echo '<a href="javascript:clearSubproduct(' . $i . ')">[x] ' . TEXT_REMOVE_PRODUCT . "</a><br />\n";
    }
?>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan=2 class="main">

      <input type="text" name="keywords" class="form-control" id="quick_find_keyword" placeholder="<?php echo HEADING_TITLE_SEARCH; ?>" />

<script>
// <![CDATA[
$(document).ready(function(){

  $("#quick_find_keyword").keyup(function(){
      var searchString = $("#quick_find_keyword").val(); 
      $.ajax({
      	url: "<?php echo DIR_WS_CATALOG; ?>index_ajax.php",             
      	dataType : "html",
      	type: "POST",
      	data: "q=admin/includes/modules/ajax/ajaxBundleFind.php&keywords="+searchString,
      	success: function(msg){$("#ajaxBundleFind").html(msg);}            
 });     
                           
                           
   });


})

// ]]>
</script>

<?php
    echo vam_draw_hidden_field('bundled_subproducts_i', $i,'id="bundled_subproducts_i"');
    echo TEXT_ADD_PRODUCT . '<select name="subproduct_selector" id="ajaxBundleFind" onChange="fillCodes()">';
    echo '<option name="null" value="" SELECTED></option>';
    //$where_str = '';
    //if (isset($_GET['pID'])) {
      //$bundle_check = bundle_avoid($_GET['pID']);
      //if (!empty($bundle_check)) {
        //$where_str = ' and (not (p.products_id in (' . implode(',', $bundle_check) . ')))';
      //}
     //}
    //$products = vam_db_query("select pd.products_name, p.products_id, p.products_model from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' and p.products_id <> " . (int)$_GET['pID'] . $where_str . " order by p.products_model");
    //while($products_values = vam_db_fetch_array($products)) {
      //echo "\n" . '<option name="' . $products_values['products_id'] . '" value="' . $products_values['products_id'] . '">' . $products_values['products_name'] . " (" . $products_values['products_model'] . ')</option>';
    //}
    echo '</select>';
?>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <!-- EOF Bundled Products -->


          </table>
                  
        </div>        
<!-- group check-->

</div>
<!-- ++++++++++ goooooooood ++++++++++ -->
</td></tr>
</form>