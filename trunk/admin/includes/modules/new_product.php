<?php

/* --------------------------------------------------------------
   $Id: new_product.php 897 2005-04-28 21:36:55Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.140 2003/03/24); www.oscommerce.com
   (c) 2003  nextcommerce (categories.php,v 1.37 2003/08/18); www.nextcommerce.org

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
        $product_query = xtc_db_query("select *, date_format(p.products_date_available, '%Y-%m-%d') as products_date_available
                                       from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd
                                  where p.products_id = '".(int) $_GET['pID']."'
                                  and p.products_id = pd.products_id
                                  and pd.language_id = '".$_SESSION['languages_id']."'");

        $product = xtc_db_fetch_array($product_query);
        $pInfo = new objectInfo($product);

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
        $products_url = $_POST['products_url'];
        $pInfo->products_startpage = $_POST['products_startpage'];
   $products_startpage_sort = $_POST['products_startpage_sort'];
} else {
        $pInfo = new objectInfo(array ());
}

$manufacturers_array = array (array ('id' => '', 'text' => TEXT_NONE));
$manufacturers_query = xtc_db_query("select manufacturers_id, manufacturers_name from ".TABLE_MANUFACTURERS." order by manufacturers_name");
while ($manufacturers = xtc_db_fetch_array($manufacturers_query)) {
        $manufacturers_array[] = array ('id' => $manufacturers['manufacturers_id'], 'text' => $manufacturers['manufacturers_name']);
}

$vpe_array = array (array ('id' => '', 'text' => TEXT_NONE));
$vpe_query = xtc_db_query("select products_vpe_id, products_vpe_name from ".TABLE_PRODUCTS_VPE." WHERE language_id='".$_SESSION['languages_id']."' order by products_vpe_name");
while ($vpe = xtc_db_fetch_array($vpe_query)) {
        $vpe_array[] = array ('id' => $vpe['products_vpe_id'], 'text' => $vpe['products_vpe_name']);
}

$tax_class_array = array (array ('id' => '0', 'text' => TEXT_NONE));
$tax_class_query = xtc_db_query("select tax_class_id, tax_class_title from ".TABLE_TAX_CLASS." order by tax_class_title");
while ($tax_class = xtc_db_fetch_array($tax_class_query)) {
        $tax_class_array[] = array ('id' => $tax_class['tax_class_id'], 'text' => $tax_class['tax_class_title']);
}
$shipping_statuses = array ();
$shipping_statuses = xtc_get_shipping_status();
$languages = xtc_get_languages();

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
<link rel="stylesheet" type="text/css" href="includes/javascript/tabsheets.css">
<link href="includes/javascript/date-picker/css/datepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/javascript/date-picker/js/datepicker.js"></script>
<script type="text/javascript" src="includes/javascript/tabsheets.js"></script>
<script type="text/javascript" src="includes/javascript/modified.js"></script>

<tr><td>
<?php $form_action = ($_GET['pID']) ? 'update_product' : 'insert_product'; ?>
<?php $fsk18_array=array(array('id'=>0,'text'=>NO),array('id'=>1,'text'=>YES)); ?>
<span class="pageHeading"><?php echo sprintf(TEXT_NEW_PRODUCT, xtc_output_generated_category_path($current_category_id)); ?></span><br />
<?php
    echo xtc_draw_form('new_product', FILENAME_CATEGORIES, 'cPath=' . $_GET['cPath'] . '&pID=' . $_GET['pID'] . '&action='.$form_action, 'post', 'enctype="multipart/form-data" cf="true"');
    echo xtc_draw_hidden_field('products_date_added', (($pInfo->products_date_added) ? $pInfo->products_date_added : date('Y-m-d')));
    echo xtc_draw_hidden_field('products_id', $pInfo->products_id);
?>
<div class="tabsheets">
    <input id="btn_save" type="submit" class="button" value="<?php echo BUTTON_SAVE; ?>" cf="false">
    <a class="button" href="<?php echo xtc_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&pID=' . $_GET['pID']); ?>"><?php echo BUTTON_CANCEL; ?></a>
    &nbsp;&nbsp;|&nbsp;&nbsp;
    <a class="button" href="<?php echo xtc_href_link(FILENAME_NEW_ATTRIBUTES, 'action=edit' . '&current_product_id=' . $_GET['pID'] . '&cpath=' . $cPath); ?>"><?php echo BUTTON_EDIT_ATTRIBUTES; ?></a>
    <a class="button" href="<?php echo xtc_href_link(FILENAME_CATEGORIES, 'action=edit_crossselling' . '&current_product_id=' . $_GET['pID'] . '&cpath=' . $cPath); ?>"><?php echo BUTTON_EDIT_CROSS_SELLING; ?></a>

    <dl class="tabsheets">
<?php for ($i = 0, $n = sizeof($languages); $i < $n; $i++) { ?>
        <dt><?php echo $languages[$i]['name']; ?></dt>
        <dd><div class="reducer">
          <table border="0">
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_NAME; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_input_field('products_name[' . $languages[$i]['id'] . ']', (($products_name[$languages[$i]['id']]) ? stripslashes($products_name[$languages[$i]['id']]) : xtc_get_products_name($pInfo->products_id, $languages[$i]['id'])),'size=60'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_URL; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_input_field('products_url[' . $languages[$i]['id'] . ']', (($products_url[$languages[$i]['id']]) ? stripslashes($products_url[$languages[$i]['id']]) : xtc_get_products_url($pInfo->products_id, $languages[$i]['id'])),'size=60') . '&nbsp;<small>' . TEXT_PRODUCTS_URL_WITHOUT_HTTP . '</small>'; ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_DESCRIPTION; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_textarea_field('products_description_' . $languages[$i]['id'], 'soft', '103', '15', (($products_description[$languages[$i]['id']]) ? stripslashes($products_description[$languages[$i]['id']]) : xtc_get_products_description($pInfo->products_id, $languages[$i]['id']))); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_SHORT_DESCRIPTION; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_textarea_field('products_short_description_' . $languages[$i]['id'], 'soft', '103', '15', (($products_short_description[$languages[$i]['id']]) ? stripslashes($products_short_description[$languages[$i]['id']]) : xtc_get_products_short_description($pInfo->products_id, $languages[$i]['id']))); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_KEYWORDS; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_input_field('products_keywords[' . $languages[$i]['id'] . ']',(($products_keywords[$languages[$i]['id']]) ? stripslashes($products_keywords[$languages[$i]['id']]) : xtc_get_products_keywords($pInfo->products_id, $languages[$i]['id'])), 'size=80 maxlenght=255'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_META_TITLE; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_input_field('products_meta_title[' . $languages[$i]['id'] . ']',(($products_meta_title[$languages[$i]['id']]) ? stripslashes($products_meta_title[$languages[$i]['id']]) : xtc_get_products_meta_title($pInfo->products_id, $languages[$i]['id'])), 'size=80 maxlenght=50'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_META_DESCRIPTION; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_input_field('products_meta_description[' . $languages[$i]['id'] . ']',(($products_meta_description[$languages[$i]['id']]) ? stripslashes($products_meta_description[$languages[$i]['id']]) : xtc_get_products_meta_description($pInfo->products_id, $languages[$i]['id'])), 'size=80 maxlenght=50'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_META_KEYWORDS; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_input_field('products_meta_keywords[' . $languages[$i]['id'] . ']', (($products_meta_keywords[$languages[$i]['id']]) ? stripslashes($products_meta_keywords[$languages[$i]['id']]) : xtc_get_products_meta_keywords($pInfo->products_id, $languages[$i]['id'])), 'size=80 maxlenght=50'); ?></td>
          </tr>
          </table>
        </div></dd>
<?php } ?>

<!-- info -->
        <dt><?php echo TEXT_PRODUCTS_DATA; ?></dt>
        <dd><div class="reducer">
          <table border="0">
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_STATUS; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_radio_field('products_status', '1', $status) . '&nbsp;' . TEXT_PRODUCT_AVAILABLE . '&nbsp;' . xtc_draw_radio_field('products_status', '0', $out_status) . '&nbsp;' . TEXT_PRODUCT_NOT_AVAILABLE; ?></td>
            <td>&nbsp;&nbsp;</td>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_DATE_AVAILABLE; ?> <small>(YYYY-MM-DD)</small></td>
            <td valign="top" class="main"><?php echo xtc_draw_input_field('products_date_available', $pInfo->products_date_available, 'size="10" class="format-y-m-d dividor-slash"'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_STARTPAGE; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_radio_field('products_startpage', '1', $startpage_checked) . '&nbsp;' . TEXT_PRODUCTS_STARTPAGE_YES . xtc_draw_radio_field('products_startpage', '0', !$startpage_checked) . '&nbsp;' . TEXT_PRODUCTS_STARTPAGE_NO; ?></td>
            <td></td>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_STARTPAGE_SORT; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_input_field('products_startpage_sort', $pInfo->products_startpage_sort ,'size=3'); ?></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_SORT; ?></td>
            <td valign="top" class="main"><?php echo  xtc_draw_input_field('products_sort', $pInfo->products_sort,'size=3'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_QUANTITY; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_input_field('products_quantity', $pInfo->products_quantity,'size=5'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_WEIGHT; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_input_field('products_weight', $pInfo->products_weight,'size=4') . '&nbsp;' . TEXT_PRODUCTS_WEIGHT_INFO; ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_MODEL; ?></td>
            <td valign="top" class="main"><?php echo  xtc_draw_input_field('products_model', $pInfo->products_model); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_EAN; ?></td>
            <td valign="top" class="main"><?php echo  xtc_draw_input_field('products_ean', $pInfo->products_ean); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_MANUFACTURER; ?> <a href="<?php echo FILENAME_MANUFACTURERS; ?>"><?php echo TEXT_EDIT; ?></a></td>
            <td valign="top" class="main"><?php echo xtc_draw_pull_down_menu('manufacturers_id', $manufacturers_array, $pInfo->manufacturers_id); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_FSK18; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_pull_down_menu('fsk18', $fsk18_array, $pInfo->products_fsk18); ?></td>
          </tr>
          <tr>
          <?php if (ACTIVATE_SHIPPING_STATUS=='true') { ?>
          <tr>
            <td valign="top" class="main"><?php echo BOX_SHIPPING_STATUS.':'; ?> <a href="<?php echo FILENAME_SHIPPING_STATUS; ?>"><?php echo TEXT_EDIT; ?></a></td>
            <td valign="top" class="main"><?php echo xtc_draw_pull_down_menu('shipping_status', $shipping_statuses, $pInfo->products_shippingtime); ?></td>
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
            <td valign="top" class="main"><?php echo xtc_draw_pull_down_menu('info_template', $files['product_info'], $pInfo->product_template); ?></td>
          <tr>
          </tr>
            <td valign="top" class="main"><?php echo TEXT_CHOOSE_OPTIONS_TEMPLATE.':'; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_pull_down_menu('options_template', $files['product_options'], $pInfo->options_template); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_TO_XML; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_radio_field('products_to_xml', '1', $in_xml) . '&nbsp;' . TEXT_PRODUCT_AVAILABLE_TO_XML . '&nbsp;' . xtc_draw_radio_field('products_to_xml', '0', $out_xml) . '&nbsp;' . TEXT_PRODUCT_NOT_AVAILABLE_TO_XML; ?></td>
          </tr>
          </table>
        </div></dd>
<!-- info -->
<!-- images -->
        <dt><?php echo strip_tags(HEADING_PRODUCT_IMAGES); ?></dt>
        <dd><div class="reducer">
        <table border="0" class="main">
        <?php include (DIR_WS_MODULES.'products_images.php'); ?>
        </table>
        </div></dd>
<!-- images -->
<!-- price -->
        <dt><?php echo strip_tags(HEADING_PRICES_OPTIONS); ?></dt>
        <dd><div class="reducer">
        <table border="0" class="main">
          <?php include(DIR_WS_MODULES.'group_prices.php'); ?>
          <tr>
            <td colspan="4"><? echo xtc_draw_separator('pixel_black.gif', '100%', '1'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_VPE_VISIBLE; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_selection_field('products_vpe_status', 'checkbox', '1',$pInfo->products_vpe_status==1 ? true : false); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_VPE_VALUE; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_input_field('products_vpe_value', $pInfo->products_vpe_value,'size=4'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_PRODUCTS_VPE; ?></td>
            <td valign="top" class="main"><?php echo xtc_draw_pull_down_menu('products_vpe', $vpe_array, $pInfo->products_vpe='' ?  DEFAULT_PRODUCTS_VPE_ID : $pInfo->products_vpe); ?></td>
          </tr>
        </table>
        </div></dd>
<!-- price -->
<!-- group check-->
<?php
    if (GROUP_CHECK == 'true') {
        $customers_statuses_array = xtc_get_customers_statuses();
        $customers_statuses_array = array_merge(array (array ('id' => 'all', 'text' => TXT_ALL)), $customers_statuses_array);
?>
        <dt><?php echo ENTRY_CUSTOMERS_STATUS; ?></dt>
        <dd><div class="reducer">
<?php
    for ($i = 0; $n = sizeof($customers_statuses_array), $i < $n; $i ++) {
        $code = '$id=$pInfo->group_permission_'.$customers_statuses_array[$i]['id'].';';
        eval ($code);
        $checked = ($id==1) ? 'checked ' : '';
        echo '<input type="checkbox" name="groups[]" value="'.$customers_statuses_array[$i]['id'].'"'.$checked.'> '.$customers_statuses_array[$i]['text'].'<br />';
    }
?>
        </div></dd>
<?php } ?>
<!-- group check-->
    </dl>
</div>

</div>
<!-- ++++++++++ goooooooood ++++++++++ -->
</td></tr>
</form>