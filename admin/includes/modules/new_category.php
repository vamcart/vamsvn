<?php
/* --------------------------------------------------------------
   $Id: new_category.php 799 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.140 2003/03/24); www.oscommerce.com
   (c) 2003  nextcommerce (categories.php,v 1.37 2003/08/18); www.nextcommerce.org
   (c) 2004 xt:Commerce (new_category.php,v 1.9 2003/08/21); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contribution:
   Enable_Disable_Categories 1.3               Autor: Mikel Williams | mikel@ladykatcostumes.com
   New Attribute Manager v4b                   Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
   Category Descriptions (Version: 1.5 MS2)    Original Author:   Brian Lowe <blowe@wpcusrgrp.org> | Editor: Lord Illicious <shaolin-venoms@illicious.net>
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   --------------------------------------------------------------*/
    if ( ($_GET['cID']) && (!$_POST) ) {
      $category_query = vam_db_query("select * from " .
                                      TABLE_CATEGORIES . " c, " .
                                      TABLE_CATEGORIES_DESCRIPTION . " cd
                                      where c.categories_id = cd.categories_id
                                      and c.categories_id = '" . $_GET['cID'] . "'");

      $category = vam_db_fetch_array($category_query);

      $cInfo = new objectInfo($category);
    } elseif ($_POST) {
      $cInfo = new objectInfo($_POST);
      $categories_name = $_POST['categories_name'];
      $categories_heading_title = $_POST['categories_heading_title'];
      $categories_description = $_POST['categories_description'];
      $categories_meta_title = $_POST['categories_meta_title'];
      $categories_meta_description = $_POST['categories_meta_description'];
      $categories_meta_keywords = $_POST['categories_meta_keywords'];
    } else {
      $cInfo = new objectInfo(array());
    }

    $languages = vam_get_languages();

    $text_new_or_edit = ($_GET['action']=='new_category_ACD') ? TEXT_INFO_HEADING_NEW_CATEGORY : TEXT_INFO_HEADING_EDIT_CATEGORY;

    $manual_link = ($_GET['action']=='new_category') ? MANUAL_LINK_NEW_CATEGORY : MANUAL_LINK_EDIT_CATEGORY;

    $labels_array = array (array ('id' => '', 'text' => TEXT_NONE));
    $labels_query = vam_db_query("select id, name from ".TABLE_PRODUCT_LABELS." order by sort_order asc");
    while ($labels = vam_db_fetch_array($labels_query)) {
        $labels_array[] = array ('id' => $labels['id'], 'text' => $labels['name']);
    }

?>

<script type="text/javascript" src="includes/javascript/modified.js"></script>
<?php if (ENABLE_TABS == 'true') { ?>
		<script type="text/javascript">
			$(function(){
				$('#tabs').tabs({ fx: { opacity: 'toggle', duration: 'fast' } });
			});
		</script>
<?php } ?>

      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td>
            
 <?php
$form_action = ($_GET['cID']) ? 'update_category' : 'insert_category'; 

    echo vam_draw_form('new_category', FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $_GET['cID'] . '&action='.$form_action, 'post', 'enctype="multipart/form-data" cf="true"'); ?>
    
        	<span class="button"><button type="submit" value="<?php echo BUTTON_SAVE; ?>" cf="false"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_SAVE; ?></button></span>&nbsp;&nbsp;<a class="button" href="<?php echo vam_href_link(FILENAME_CATEGORIES, 'cPath=' . $cPath . '&cID=' . $_GET['cID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?>
        	
        	</td>
            <td align="right"><a class="button" href="<?php echo $manual_link; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table></td>
      </tr>

<tr>
<td>
    
<div id="tabs">

			<ul>
<?php
    for ($i=0; $i<sizeof($languages); $i++) {
?>
				<li><a href="#tab<?php echo $i; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/'.$languages[$i]['code'].'.png', '', '16', '16'); ?>&nbsp;<?php echo $languages[$i]['name']; ?></a></li>
<?php 
}
?>
				<li><a href="#data"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/other.png', '', '16', '16'); ?>&nbsp;<?php echo TEXT_PRODUCTS_DATA; ?></a></li>
				<li><a href="#image"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/images.png', '', '16', '16'); ?>&nbsp;<?php echo TEXT_TAB_CATEGORIES_IMAGE; ?></a></li>
<?php
    if (GROUP_CHECK == 'true') {
?>
				<li><a href="#groups"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/account.png', '', '16', '16'); ?>&nbsp;<?php echo ENTRY_CUSTOMERS_ACCESS; ?></a></li>
<?php 
}
?>
			</ul>

<?php for ($i = 0, $n = sizeof($languages); $i < $n; $i++) { ?>
<!-- категории -->
        <div id="tab<?php echo $i; ?>">
          <table border="0" class="main">

          <tr>
            <td valign="top" class="main"><?php echo TEXT_EDIT_CATEGORIES_NAME; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('categories_name[' . $languages[$i]['id'] . ']', (($categories_name[$languages[$i]['id']]) ? stripslashes($categories_name[$languages[$i]['id']]) : vam_get_categories_name($cInfo->categories_id, $languages[$i]['id']))); ?></td>
          </tr>

          <tr>
            <td valign="top" class="main"><?php echo TEXT_EDIT_CATEGORIES_HEADING_TITLE; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('categories_heading_title[' . $languages[$i]['id'] . ']', (($categories_name[$languages[$i]['id']]) ? stripslashes($categories_name[$languages[$i]['id']]) : vam_get_categories_heading_title($cInfo->categories_id, $languages[$i]['id']))); ?></td>
          </tr>

          <tr>
            <td valign="top" class="main"><?php echo TEXT_EDIT_CATEGORIES_DESCRIPTION; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_textarea_field('categories_description[' . $languages[$i]['id'] . ']', 'soft', '95', '25', (($categories_description[$languages[$i]['id']]) ? stripslashes($categories_description[$languages[$i]['id']]) : vam_get_categories_description($cInfo->categories_id, $languages[$i]['id']))); ?><br /><a href="javascript:toggleHTMLEditor('<?php echo 'categories_description[' . $languages[$i]['id'] . ']';?>');"><?php echo TEXT_TOGGLE_EDITOR; ?></a></td>
          </tr>

          <tr>
            <td valign="top" class="main"><?php echo TEXT_META_TITLE; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('categories_meta_title[' . $languages[$i]['id'] . ']',(($categories_meta_title[$languages[$i]['id']]) ? stripslashes($categories_meta_title[$languages[$i]['id']]) : vam_get_categories_meta_title($cInfo->categories_id, $languages[$i]['id'])), 'size=50'); ?></td>
          </tr>

          <tr>
            <td valign="top" class="main"><?php echo TEXT_META_DESCRIPTION; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('categories_meta_description[' . $languages[$i]['id'] . ']', (($categories_meta_description[$languages[$i]['id']]) ? stripslashes($categories_meta_description[$languages[$i]['id']]) : vam_get_categories_meta_description($cInfo->categories_id, $languages[$i]['id'])),'size=50'); ?></td>
          </tr>

          <tr>
            <td valign="top" class="main"><?php echo TEXT_META_KEYWORDS; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('categories_meta_keywords[' . $languages[$i]['id'] . ']',(($categories_meta_keywords[$languages[$i]['id']]) ? stripslashes($categories_meta_keywords[$languages[$i]['id']]) : vam_get_categories_meta_keywords($cInfo->categories_id, $languages[$i]['id'])),'size=50'); ?></td>
          </tr>

          </table>
        </div>
<?php } ?>
<!-- /категории -->

<!-- info -->
        <div id="data">
          <table border="0" class="main">
<!--// Categories URL begin //-->
            <tr>
              <td valign="top" class="main"><?php echo TEXT_EDIT_CATEGORY_URL; ?></td>
              <td valign="top" class="main"><?php echo vam_draw_input_field('categories_url', $cInfo->categories_url, 'size="40"'); ?></td>
            </tr>
<!--// Categories URL end //-->
            <tr>
            
          <?php
        $files=array();
 if ($dir= opendir(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/product_listing/')){
 while  (($file = readdir($dir)) !==false) {
        if (is_file( DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/product_listing/'.$file) and ($file !="index.html")){
        $files[]=array(
                        'id' => $file,
                        'text' => $file);
        }//if
        } // while
        closedir($dir);
 }
 $default_array=array();
 // set default value in dropdown!
if ($content['content_file']=='') {
$default_array[]=array('id' => 'default','text' => TEXT_SELECT);
$default_value=$cInfo->listing_template;
$files=array_merge($default_array,$files);
} else {
$default_array[]=array('id' => 'default','text' => TEXT_NO_FILE);
$default_value=$cInfo->listing_template;
$files=array_merge($default_array,$files);
}
echo '<td valign="top" class="main">'.TEXT_CHOOSE_INFO_TEMPLATE_LISTING.':</td>';
echo '<td><span class="main">'.vam_draw_pull_down_menu('listing_template',$files,$default_value);
?>
        </span></td>
      </tr>
                      <tr>
          <?php
        $files=array();
 if ($dir= opendir(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/categorie_listing/')){
 while  (($file = readdir($dir)) !==false) {
        if (is_file( DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/module/categorie_listing/'.$file) and ($file !="index.html")){
        $files[]=array(
                        'id' => $file,
                        'text' => $file);
        }//if
        } // while
        closedir($dir);
 }
 $default_array=array();
 // set default value in dropdown!
if ($content['content_file']=='') {
$default_array[]=array('id' => 'default','text' => TEXT_SELECT);
$default_value=$cInfo->categories_template;
$files=array_merge($default_array,$files);
} else {
$default_array[]=array('id' => 'default','text' => TEXT_NO_FILE);
$default_value=$cInfo->categories_template;
$files=array_merge($default_array,$files);
}
echo '<td valign="top" class="main">'.TEXT_CHOOSE_INFO_TEMPLATE_CATEGORIE.':</td>';
echo '<td><span class="main">'.vam_draw_pull_down_menu('categories_template',$files,$default_value);
?>
        </span></td>
      </tr>
      <tr>
<?php
$order_array='';
$order_array=array(array('id' => 'p.products_price','text'=>TXT_PRICES),
                   array('id' => 'pd.products_name','text'=>TXT_NAME),
                   array('id' => 'p.products_ordered','text'=>TXT_ORDERED),
                   array('id' => 'p.products_sort','text'=>TXT_SORT),
                   array('id' => 'p.products_weight','text'=>TXT_WEIGHT),
                   array('id' => 'p.products_quantity','text'=>TXT_QTY));
$default_value='pd.products_name';
?>
            <td valign="top" class="main"><?php echo TEXT_EDIT_PRODUCT_SORT_ORDER; ?>:</td>
            <td valign="top" class="main"><?php echo vam_draw_pull_down_menu('products_sorting',$order_array,$cInfo->products_sorting); ?></td>
          </tr>
          <tr>
<?php
if ($cInfo->categories_status == NULL) $cInfo->categories_status = 1;
$order_array='';
$order_array=array(array('id' => 'ASC','text'=>'ASC (1 first)'),
                   array('id' => 'DESC','text'=>'DESC (1 last)'));
?>
          <td valign="top" class="main"><?php echo TEXT_EDIT_PRODUCT_SORT_ORDER; ?>:</td>
            <td valign="top" class="main"><?php echo vam_draw_pull_down_menu('products_sorting2',$order_array,$cInfo->products_sorting2); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_EDIT_SORT_ORDER; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('sort_order', $cInfo->sort_order, 'size="2"'); ?></td>
          </tr>
        	 <tr>
            <td class="main"><?php echo TEXT_EDIT_STATUS; ?>:</td>
            <td class="main"><?php echo vam_draw_selection_field('status', 'checkbox', '1',$cInfo->categories_status==1 ? true : false); ?></td>
          </tr>

          <tr>
            <td colspan="4"><?php echo vam_draw_separator('pixel_trans.gif', '100%', '1'); ?></td>
          </tr>

          <tr>
            <td valign="top" class="main"><?php echo TEXT_EDIT_LABEL; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_pull_down_menu('label_id', $labels_array, $cInfo->label_id); ?>&nbsp;<a href="<?php echo vam_href_link(FILENAME_PRODUCT_LABELS, '', 'NONSSL', false); ?>"><?php echo TEXT_EDIT; ?></a></td>
          </tr>

          <tr>
            <td valign="top" class="main"><?php echo TEXT_EDIT_ICON; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('icon', $cInfo->icon, 'size="40"'); ?></td>
          </tr>
            
          <tr>
            <td valign="top" colspan="2" class="main"><?php echo TEXT_YANDEX_MARKET; ?></td>
          </tr>

          <tr>
            <td valign="top" class="main"><?php echo TEXT_YANDEX_MARKET_BID; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('yml_bid', $cInfo->yml_bid, 'size="2"'); ?></td>
          </tr>
          <tr>
            <td valign="top" class="main"><?php echo TEXT_YANDEX_MARKET_CBID; ?></td>
            <td valign="top" class="main"><?php echo vam_draw_input_field('yml_cbid', $cInfo->yml_cbid, 'size="2"'); ?></td>
          </tr>

        </table>
        </div>
<!-- info -->

<!-- картинка -->
        <div id="image">
          <table border="0">

           <tr>
            <td class="main" width="200" valign="top"><?php echo TEXT_EDIT_CATEGORIES_IMAGE; ?></td>
            <td class="top"><?php echo vam_draw_file_field('categories_image') . '<br />' . vam_draw_separator('pixel_trans.gif', '24', '15') . vam_draw_hidden_field('categories_previous_image', $cInfo->categories_image); ?>
            <?php
            if ($cInfo->categories_image) {
            	?>
            <br><img src="<?php echo DIR_WS_CATALOG.'images/categories/'.$cInfo->categories_image; ?>">
            <br><?php echo '&nbsp;' .$cInfo->categories_image;
            echo vam_draw_selection_field('del_cat_pic', 'checkbox', 'yes').TEXT_DELETE;
            
            } ?>
            </td>
          </tr>

          </table>
        </div>
<!-- images -->

<?php

if (GROUP_CHECK=='true') {
$customers_statuses_array = vam_get_customers_statuses();
$customers_statuses_array=array_merge(array(array('id'=>'all','text'=>TXT_ALL)),$customers_statuses_array);
?>
        <div id="groups">
          <table border="0">

           <tr>
            <td class="main" width="200" valign="top">        
<?php

for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++) {

if ($category['group_permission_'.$customers_statuses_array[$i]['id']] == 1) {

$checked='checked ';
} else {
$checked='';
}
echo '<input type="checkbox" name="groups[]" value="'.$customers_statuses_array[$i]['id'].'"'.$checked.'> '.$customers_statuses_array[$i]['text'].'<br />';
}
?>
</td>
</tr>
<?php
}
?>

          </table>
        </div>

</div>

   
</td>
      </tr>

        	<?php echo vam_draw_hidden_field('categories_date_added', (($cInfo->date_added) ? $cInfo->date_added : date('Y-m-d'))) . vam_draw_hidden_field('parent_id', $cInfo->parent_id); ?> 
        	<?php echo vam_draw_hidden_field('categories_id', $cInfo->categories_id); ?> 

</form>