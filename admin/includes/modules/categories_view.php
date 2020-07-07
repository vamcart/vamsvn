<?php
/* --------------------------------------------------------------
   $Id: categories_view.php 901 2010-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.140 2003/03/24); www.oscommerce.com
   (c) 2003  nextcommerce (categories.php,v 1.37 2003/08/18); www.nextcommerce.org
   (c) 2004 xt:Commerce (categories.php,v 1.37 2003/08/18); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contribution:
   Enable_Disable_Categories 1.3               Autor: Mikel Williams | mikel@ladykatcostumes.com
   New Attribute Manager v4b                   Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
   Category Descriptions (Version: 1.5 MS2)    Original Author:   Brian Lowe <blowe@wpcusrgrp.org> | Editor: Lord Illicious <shaolin-venoms@illicious.net>
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   --------------------------------------------------------------*/
 defined('_VALID_VAM') or die('Direct Access to this location is not allowed.');  
    // get sorting option and switch accordingly        
    if ($_GET['sorting']) {
    switch ($_GET['sorting']){
        case 'sort'         : 
            $catsort    = 'c.sort_order ASC';
            $prodsort   = 'p.products_sort ASC';
            break;
        case 'sort-desc'    :
            $catsort    = 'c.sort_order DESC';
            $prodsort   = 'p.products_sort DESC';
        case 'model'         : 
            $catsort    = 'c.sort_order ASC';
            $prodsort   = 'p.products_model ASC';
            break;
        case 'model-desc'    :
            $catsort    = 'c.sort_order DESC';
            $prodsort   = 'p.products_model DESC';
        case 'name'         :
            $catsort    = 'cd.categories_name ASC';
            $prodsort   = 'pd.products_name ASC';
            break;
        case 'name-desc'    :
            $catsort    = 'cd.categories_name DESC';
            $prodsort   = 'pd.products_name DESC';
            break;                  
        case 'status'       :
            $catsort    = 'c.categories_status ASC';
            $prodsort   = 'p.products_status ASC';
            break;
        case 'status-desc'  :
            $catsort    = 'c.categories_status DESC';
            $prodsort   = 'p.products_status DESC';
            break;             
        case 'price'        :
            $catsort    = 'c.sort_order ASC'; //default
            $prodsort   = 'p.products_price ASC';            
            break;
        case 'price-desc'   :
            $catsort    = 'c.sort_order ASC'; //default
            $prodsort   = 'p.products_price DESC';            
            break;            
        case 'stock'        :
            $catsort    = 'c.sort_order ASC'; //default
            $prodsort   = 'p.products_quantity ASC';            
            break;
        case 'stock-desc'   :
            $catsort    = 'c.sort_order ASC'; //default
            $prodsort   = 'p.products_quantity DESC';            
            break;            
        case 'discount'     :
            $catsort    = 'c.sort_order ASC'; //default
            $prodsort   = 'p.products_discount_allowed ASC';            
            break;  
        case 'discount-desc':
            $catsort    = 'c.sort_order ASC'; //default
            $prodsort   = 'p.products_discount_allowed DESC';            
            break;                                   
        default             :
            $catsort    = 'cd.categories_name ASC';
            $prodsort   = 'pd.products_name ASC';
            break;
    }
    } else {
            $catsort    = 'c.sort_order, cd.categories_name ASC';
            $prodsort   = 'p.products_sort, pd.products_name ASC';
    }       
?>

    <!-- categories_view HTML part begin -->

    <tr>
     <td>     
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
         <!-- categories & products column STARTS -->
         <td valign="top">
         
            <!-- categories and products table -->
            <table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
            <tr class="dataTableHeadingRow">
             <td class="dataTableHeadingContent" width="5%" align="center">
                <?php echo TABLE_HEADING_EDIT; ?>
                <input type="checkbox" onClick="javascript:CheckAll(this.checked);">
             </td>
             <td class="dataTableHeadingContent" align="center">
                <?php echo TABLE_HEADING_CATEGORIES_PRODUCTS.vam_sorting(FILENAME_CATEGORIES,'name'); ?>
             </td>
             <?php
             // check Produkt and attributes stock
             if (STOCK_CHECK == 'true') {
                    echo '<td class="dataTableHeadingContent" align="center">' . TABLE_HEADING_STOCK . vam_sorting(FILENAME_CATEGORIES,'stock') . '</td>';
             }
             ?>
             <td class="dataTableHeadingContent" align="center">
                <?php echo TABLE_HEADING_STATUS.vam_sorting(FILENAME_CATEGORIES,'status'); ?>
             </td>
             <td class="dataTableHeadingContent" align="center">
                <?php echo TABLE_HEADING_STARTPAGE.vam_sorting(FILENAME_CATEGORIES,'startpage'); ?>
             </td>
             <td class="dataTableHeadingContent" align="center">
                <?php echo TABLE_HEADING_XML.vam_sorting(FILENAME_CATEGORIES,'yandex'); ?>
             </td>
             <td class="dataTableHeadingContent" align="center">
                <?php echo TABLE_HEADING_MODEL.vam_sorting(FILENAME_CATEGORIES,'model'); ?>
             </td>
             <td class="dataTableHeadingContent" align="center">
                <?php echo TABLE_HEADING_PRICE.vam_sorting(FILENAME_CATEGORIES,'price'); ?>
             </td>
             <td class="dataTableHeadingContent" align="center">
                <?php echo TABLE_HEADING_SORT.vam_sorting(FILENAME_CATEGORIES,'sort'); ?>
             </td>
             <td class="dataTableHeadingContent" width="10%" align="center">
                <?php echo TABLE_HEADING_ACTION; ?>
             </td>
            </tr>
            
    <?php
            
    //multi-actions form STARTS
    if (vam_not_null($_POST['multi_categories']) || vam_not_null($_POST['multi_products'])) { 
        $action = "action=multi_action_confirm&" . vam_get_all_get_params(array('cPath', 'action')) . 'cPath=' . $cPath; 
    } else {
        $action = "action=multi_action&" . vam_get_all_get_params(array('cPath', 'action')) . 'cPath=' . $cPath;
    }
    echo vam_draw_form('multi_action_form', FILENAME_CATEGORIES, $action, 'post', 'onsubmit="javascript:return CheckMultiForm()"');
    //add current category id in $_POST
    echo '<input type="hidden" id="cPath" name="cPath" value="' . $cPath . '">';             
    
// ----------------------------------------------------------------------------------------------------- //    
// WHILE loop to display categories STARTS
// ----------------------------------------------------------------------------------------------------- //

    $categories_count = 0;
    $rows = 0;
    if ($_GET['search']) {
      $categories_query = vam_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.yml_enable, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "' and cd.categories_name like '%" . $_GET['search'] . "%' order by " . $catsort);
    } else {
      $categories_query = vam_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.yml_enable, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.parent_id = '" . $current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by " . $catsort);
    } 

    while ($categories = vam_db_fetch_array($categories_query)) {
        
        $categories_count++;
        $rows++;

        if (($rows/2) == floor($rows/2)) {
          $css_class = 'categories_view_data_even';
        } else {
          $css_class = 'categories_view_data_odd';
        }
        
        if ($_GET['search']) $cPath = $categories['parent_id'];
        if ( ((!$_GET['cID']) && (!$_GET['pID']) || (@$_GET['cID'] == $categories['categories_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 4) != 'new_') ) {
            $cInfo = new objectInfo($categories);
        }
      
        if ( (is_object($cInfo)) && ($categories['categories_id'] == $cInfo->categories_id) ) {
            echo '<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'">' . "\n";
        } else {
            echo '<tr class="dataTableRow '.$css_class.'" onmouseover="this.className=\'dataTableRowOver '.$css_class.'\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow '.$css_class.'\'">' . "\n";
        }
    ?>              
             <td class="<?php echo $css_class; ?>"><input type="checkbox" name="multi_categories[]" value="<?php echo $categories['categories_id'] . '" '; if (is_array($_POST['multi_categories'])) { if (in_array($categories['categories_id'], $_POST['multi_categories'])) { echo 'checked="checked"'; } } ?>></td>
             <td class="<?php echo $css_class; ?>" style="text-align: left; padding-left: 5px;">
             <?php 
                echo '<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . vam_get_path($categories['categories_id'])) . '">' . vam_image(DIR_WS_ICONS . 'folder.gif', ICON_FOLDER) . '<a>&nbsp;<b><a href="'.vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . vam_get_path($categories['categories_id'])) .'">' . $categories['categories_name'] . '</a></b>'; 
             ?>
             </td>
        
             <?php
             // check product and attributes stock
             if (STOCK_CHECK == 'true') {
                     echo '<td class="'.$css_class.'">--</td>';
             }
             ?>
        
             <td class="<?php echo $css_class; ?>">
             <?php
             //show status icons (green & red circle) with links
             if ($categories['categories_status'] == '1') {
                 echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'action=setcflag&flag=0&cID=' . $categories['categories_id'] . '&cPath=' . $cPath) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
             } else {
                 echo '<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'action=setcflag&flag=1&cID=' . $categories['categories_id'] . '&cPath=' . $cPath) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
             }
             ?>
             </td>
             <td class="<?php echo $css_class; ?>">--</td>
             <td class="<?php echo $css_class; ?>">
             <?php
             //show status icons (green & red circle) with links
             if ($categories['yml_enable'] == '1') {
                 echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'action=setcxml&flag=0&cID=' . $categories['categories_id'] . '&cPath=' . $cPath) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
             } else {
                 echo '<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'action=setcxml&flag=1&cID=' . $categories['categories_id'] . '&cPath=' . $cPath) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
             }
             ?>
             </td>
             <td class="<?php echo $css_class; ?>">--</td>
             <td class="<?php echo $css_class; ?>"><?php echo $categories['sort_order']; ?></td>
             <td class="<?php echo $css_class; ?>">
             <?php

			 	echo '<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&cID=' . $categories['categories_id'] . "&action=edit_category") . '">' . vam_image(DIR_WS_IMAGES . 'icons/edit.gif', BUTTON_EDIT,'16','16') . '</a> ';
			 	            
                //if active category, show arrow, else show symbol with link (action col)
                if ( (is_object($cInfo)) && ($categories['categories_id'] == $cInfo->categories_id) ) { 
                    echo vam_image(DIR_WS_IMAGES . 'icons/nav_forward.png', ''); 
                } else { 
                    echo '<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&cID=' . $categories['categories_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icons/info.png', IMAGE_ICON_INFO) . '</a>'; 
                } 
             ?>
             </td>
            </tr>

    <?php

// ----------------------------------------------------------------------------------------------------- //    
    } // WHILE loop to display categories ENDS    
// ----------------------------------------------------------------------------------------------------- //     

    //get products data 
    $products_count = 0;
    if ($_GET['search']) {
        $products_query = vam_db_query("
        SELECT
        p.products_tax_class_id,
        p.products_id,
        pd.products_name,
        p.products_sort,
        p.products_quantity,
        p.products_model,
        p.products_to_xml,
        p.products_image,
        p.products_price,
        p.products_discount_allowed,
        p.products_date_added,
        p.products_last_modified,
        p.products_date_available,
        p.products_status,
        p.products_startpage,
        p.products_startpage_sort,
        p2c.categories_id FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
        WHERE p.products_id = pd.products_id AND pd.language_id = '" . $_SESSION['languages_id'] . "' AND
        p.products_id = p2c.products_id AND (pd.products_name like '%" . $_GET['search'] . "%' OR
        p.products_model = '" . $_GET['search'] . "') ORDER BY " . $prodsort);
    } else {
        $products_query = vam_db_query("
        SELECT 
        p.products_tax_class_id,
        p.products_sort, 
        p.products_id, 
        pd.products_name, 
        p.products_quantity, 
        p.products_model,
        p.products_to_xml,
        p.products_image, 
        p.products_price, 
        p.products_discount_allowed, 
        p.products_date_added, 
        p.products_last_modified, 
        p.products_date_available, 
        p.products_status,
        p.products_startpage,
        p.products_startpage_sort, p2c.categories_id FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c 
        WHERE p.products_id = pd.products_id AND pd.language_id = '" . (int)$_SESSION['languages_id'] . "' AND 
        p.products_id = p2c.products_id AND p2c.categories_id = '" . $current_category_id . "' ORDER BY " . $prodsort);
    }

// VaM Shop admin paging start

$numr = vam_db_num_rows($products_query);
$products_count = 0;

if (!isset($_GET['page'])){$page=0;} else { $page = $_GET['page']; };

$max_count = MAX_DISPLAY_ADMIN_PAGE;

//opredeliaem stranicu tecuschego producta

	if ( (isset($product_id)) and ($numr>0) ){
	$pnum=1;

	while ($row=vam_db_fetch_array($products_query)){
		if ($row["products_id"]==$product_id){
								$pnum=($pnum/$max_count);
									if (strpos($pnum,".")>0){
									$pnum=substr($pnum,0,strpos($pnum,"."));
									} else{
									if ($pnum<>0){
											$pnum=$pnum-1;
												}
									}
									$page = $pnum*$max_count;
								break;
								}
	$pnum++;
								}
	}
//--------------------------------
			//formiruem stroku kol-va

    if ($_GET['search']) {
        $products_query = vam_db_query("
        SELECT
        p.products_tax_class_id,
        p.products_id,
        pd.products_name,
        p.products_sort,
        p.products_quantity,
        p.products_model,
        p.products_to_xml,
        p.products_image,
        p.products_price,
        p.products_discount_allowed,
        p.products_date_added,
        p.products_last_modified,
        p.products_date_available,
        p.products_status,
        p.products_startpage,
        p.products_startpage_sort,
        p2c.categories_id FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c
        WHERE p.products_id = pd.products_id AND pd.language_id = '" . $_SESSION['languages_id'] . "' AND
        p.products_id = p2c.products_id AND (pd.products_name like '%" . $_GET['search'] . "%' OR
        p.products_model = '" . $_GET['search'] . "') ORDER BY " . $prodsort . " limit ".$page.",".$max_count);
    } else {
        $products_query = vam_db_query("
        SELECT 
        p.products_tax_class_id,
        p.products_sort, 
        p.products_id, 
        pd.products_name, 
        p.products_quantity, 
        p.products_model,
        p.products_to_xml,
        p.products_image, 
        p.products_price, 
        p.products_discount_allowed, 
        p.products_date_added, 
        p.products_last_modified, 
        p.products_date_available, 
        p.products_status,
        p.products_startpage,
        p.products_startpage_sort, p2c.categories_id FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c 
        WHERE p.products_id = pd.products_id AND pd.language_id = '" . (int)$_SESSION['languages_id'] . "' AND 
        p.products_id = p2c.products_id AND p2c.categories_id = '" . $current_category_id . "' ORDER BY " . $prodsort . " limit ".$page.",".$max_count);

    }


if ($numr>$max_count){
			$kn=0;
			$stp= TEXT_PAGES;

			$im=1;$nk=0;
			while ($kn<$numr){
			if ($kn<>$page){
			$stp.='<a href="' . vam_href_link(FILENAME_CATEGORIES, 'cPath='.$cPath.'&page='.$kn.(isset($_GET['search']) ? '&search='.$_GET['search'] : null)) . '">'.$im.'</a>&nbsp';
			}else{
			$stp.='<font color="#CC0000">['.$im.']</font>&nbsp';
			}
			$kn=$kn+$max_count;
			$nk=$nk+$max_count;
			if ($nk>=$max_count*30){$stp.='<br />';$nk=0;}
			$im++;
			}
}
			//-----------------------

// VaM Shop admin paging end


// ----------------------------------------------------------------------------------------------------- //    
// WHILE loop to display products STARTS
// ----------------------------------------------------------------------------------------------------- //
    
    while ($products = vam_db_fetch_array($products_query)) {
      $products_count++;
      $rows++;


      // Get categories_id for product if search
      if ($_GET['search']) $cPath=$products['categories_id'];

      if ( ((!$_GET['pID']) && (!$_GET['cID']) || (@$_GET['pID'] == $products['products_id'])) && (!$pInfo) && (!$cInfo) && (substr($_GET['action'], 0, 4) != 'new_') ) {
        // find out the rating average from customer reviews
        $reviews_query = vam_db_query("select (avg(reviews_rating) / 5 * 100) as average_rating from " . TABLE_REVIEWS . " where products_id = '" . $products['products_id'] . "'");
        $reviews = vam_db_fetch_array($reviews_query);
        $pInfo_array = vam_array_merge($products, $reviews);
        $pInfo = new objectInfo($pInfo_array);
      }

        if (($rows/2) == floor($rows/2)) {
          $css_class = 'categories_view_data_even';
        } else {
          $css_class = 'categories_view_data_odd';
        }

      if ( (is_object($pInfo)) && ($products['products_id'] == $pInfo->products_id) ) {
        echo '<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" >' . "\n";
      } else {
        echo '<tr class="dataTableRow '.$css_class.'" onmouseover="this.className=\'dataTableRowOver '.$css_class.'\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow '.$css_class.'\'" >' . "\n";
      }

      ?>
      
      <?php
      //checkbox again after submit and before final submit 
      unset($is_checked);
      if (is_array($_POST['multi_products'])) { 
        if (in_array($products['products_id'], $_POST['multi_products'])) { 
            $is_checked = ' checked="checked"'; 
        }
      } 
      ?>      
      
      <td class="<?php echo $css_class; ?>">        
        <input type="checkbox" name="multi_products[]" value="<?php echo $products['products_id']; ?>" <?php echo $is_checked; ?>>
      </td>
      <td class="<?php echo $css_class; ?>" style="text-align: left; padding-left: 8px;">
        <?php echo '<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&pID=' . $products['products_id'] ) . '">' . vam_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '&nbsp;</a><a href="'.vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&pID=' . $products['products_id']) .'">' . $products['products_name']; ?></a>
      </td>          
      <?php
      // check product and attributes stock
      if (STOCK_CHECK == 'true') { ?>
        <td class="<?php echo $css_class; ?>">
        <?php echo check_stock($products['products_id']); ?>
        </td>
      <?php } ?>     
      <td class="<?php echo $css_class; ?>">
      <?php
            if ($products['products_status'] == '1') {
                echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'action=setpflag&flag=0&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
            } else {
                echo '<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'action=setpflag&flag=1&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
            }
      ?>
      </td>
      <td class="<?php echo $css_class; ?>">
      <?php
            if ($products['products_startpage'] == '1') {
                echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'action=setsflag&flag=0&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
            } else {
                echo '<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'action=setsflag&flag=1&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
            }
      ?>
      </td>
      <td class="<?php echo $css_class; ?>">
      <?php
            if ($products['products_to_xml'] == '1') {
                echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'action=setxml&flagxml=0&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
            } else {
                echo '<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'action=setxml&flagxml=1&pID=' . $products['products_id'] . '&cPath=' . $cPath) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
            }
      ?>
      </td>
      <td class="<?php echo $css_class; ?>">
      <?php
        //show model
        echo ($products['products_model'] != '') ? $products['products_model'] : '-';
      ?>
      </td>
      <td class="<?php echo $css_class; ?>">
      <?php
        //show price
        echo $currencies->format($products['products_price']);
      ?>
      </td>
      <td class="<?php echo $css_class; ?>">
        <?php 
        if ($current_category_id == 0){
        echo $products['products_startpage_sort'];
        } else {
        echo $products['products_sort'];
        }
         ?>
      </td>
      <td class="<?php echo $css_class; ?>">
      <?php 
      
	  echo '<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&pID=' . $products['products_id']) . '&action=new_product">' . vam_image(DIR_WS_IMAGES . 'icons/edit.gif', BUTTON_EDIT,'16','16') . '</a> ';
	  echo '<a href="'.vam_catalog_href_link('product_info.php', vam_product_link($products['products_id'], $products['products_name'])).'" target="_blank">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/link.png', TEXT_COPY_AS_LINK,'16','16') . '</a> ';
	        
        if ( (is_object($pInfo)) && ($products['products_id'] == $pInfo->products_id) ) { echo vam_image(DIR_WS_IMAGES . 'icons/nav_forward.png', ''); } else { echo '<a href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID')) . 'cPath=' . $cPath . '&pID=' . $products['products_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icons/info.png', IMAGE_ICON_INFO) . '</a>'; } 
      ?>
      </td>
     </tr>    
<?php
// ----------------------------------------------------------------------------------------------------- //
    } //WHILE loop to display products ENDS
// ----------------------------------------------------------------------------------------------------- //    

    if ($cPath_array) {
      unset($cPath_back);
      for($i = 0, $n = sizeof($cPath_array) - 1; $i < $n; $i++) {
        if ($cPath_back == '') {
          $cPath_back .= $cPath_array[$i];
        } else {
          $cPath_back .= '_' . $cPath_array[$i];
        }
      }
    }

    $cPath_back = ($cPath_back) ? 'cPath=' . $cPath_back : '';
?>

        </tr>
        </table>
        <!-- categories and products table ENDS -->
        
        <!-- bottom buttons -->
        <table border="0" width="100%" cellspacing="0" cellpadding="2" style="padding-top: 10px;">
        <tr>
         <td class="smallText">
            <?php echo TEXT_CATEGORIES . '&nbsp;' . $categories_count . '<br />' . TEXT_PRODUCTS . '&nbsp;' . $products_count; ?>
            <br />
            <?php echo TEXT_TOTAL_PRODUCTS . $numr; ?>
         </td>
         <td align="right" class="smallText">
         <?php
         	if ($cPath) echo '<a class="button" href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) .  $cPath_back . '&cID=' . $current_category_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . BUTTON_BACK . '</span></a>&nbsp;'; 
            echo '<a class="button" href="javascript:SwitchCheck()"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/reverse.png', '', '12', '12') . '&nbsp;' . BUTTON_REVERSE_SELECTION . '</span></a>&nbsp;';
            echo '<a class="button" href="javascript:SwitchProducts()"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/products.png', '', '12', '12') . '&nbsp;' . BUTTON_SWITCH_PRODUCTS . '</span></a>&nbsp;';
            echo '<a class="button" href="javascript:SwitchCategories()"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/categories.png', '', '12', '12') . '&nbsp;' . BUTTON_SWITCH_CATEGORIES . '</span></a>&nbsp;';                                           
         ?>
         </td>
        </tr>
<!-- // VaM Shop admin paging start -->
        <tr>
         <td colspan="2" class="smallText">
           <?php echo $stp; ?>
         </td>
        </tr>
<!-- // VaM Shop admin paging end -->
        </table>                
        
     </td>
     <!-- categories & products column ENDS -->
<?php
    $heading = array();
    $contents = array();
    
    switch ($_GET['action']) {        

      case 'copy_to':
        //close multi-action form, not needed here
        $heading[] = array('text' => '</form><b>' . TEXT_INFO_HEADING_COPY_TO . '</b>');

        $contents   = array('form' => vam_draw_form('copy_to', FILENAME_CATEGORIES, 'action=copy_to_confirm&cPath=' . $cPath) . vam_draw_hidden_field('products_id', $pInfo->products_id));
        $contents[] = array('text' => TEXT_INFO_COPY_TO_INTRO);
        $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENT_CATEGORIES . '<br /><b>' . vam_output_generated_category_path($pInfo->products_id, 'product') . '</b>');

		if (QUICKLINK_ACTIVATED=='true') {
        $contents[] = array('text' => '<hr noshade>');
        $contents[] = array('text' => '<b>'.TEXT_MULTICOPY.'</b><br />'.TEXT_MULTICOPY_DESC);
        $cat_tree=vam_get_category_tree();
        $tree='';
        for ($i=0;$n=sizeof($cat_tree),$i<$n;$i++) {
        $tree .='<input type="checkbox" name="cat_ids[]" value="'.$cat_tree[$i]['id'].'"><font size="1">'.$cat_tree[$i]['text'].'</font><br />';
        }
        $contents[] = array('text' => $tree.'<br /><hr noshade>');
        $contents[] = array('text' => '<b>'.TEXT_SINGLECOPY.'</b><br />'.TEXT_SINGLECOPY_DESC);
        }
        $contents[] = array('text' => '<br />' . TEXT_CATEGORIES . '<br />' . vam_draw_pull_down_menu('categories_id', vam_get_category_tree(), $current_category_id));
        $contents[] = array('text' => '<br />' . TEXT_HOW_TO_COPY . '<br />' . vam_draw_radio_field('copy_as', 'link', true) . ' ' . TEXT_COPY_AS_LINK . '<br />' . vam_draw_radio_field('copy_as', 'duplicate') . ' ' . TEXT_COPY_AS_DUPLICATE);
        $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_COPY . '"/>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_COPY . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&pID=' . $pInfo->products_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;
        
      case 'multi_action':
      
        // --------------------
        // multi_move confirm
        // --------------------
        if (vam_not_null($_POST['multi_move'])) {     
            $heading[]  = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_ELEMENTS . '</b>');
            $contents[] = array('text' => '<table width="100%" border="0">');
            
            if (is_array($_POST['multi_categories'])) {
                foreach ($_POST['multi_categories'] AS $multi_category) {
                    $category_query = vam_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $multi_category . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
                    $category = vam_db_fetch_array($category_query);
                    $category_childs   = array('childs_count'   => $catfunc->count_category_childs($multi_category));
                    $category_products = array('products_count' => $catfunc->count_category_products($multi_category, true));
                    $cInfo_array = vam_array_merge($category, $category_childs, $category_products);
                    $cInfo = new objectInfo($cInfo_array);                    
                    $contents[] = array('text' => '<tr><td style="border-bottom: 1px solid Black; margin-bottom: 10px;" class="infoBoxContent"><b>' . $cInfo->categories_name . '</b></td></tr>');
                    if ($cInfo->childs_count > 0)   $contents[] = array('text' => '<tr><td class="infoBoxContent">' . sprintf(TEXT_MOVE_WARNING_CHILDS, $cInfo->childs_count) . '</td></tr>');
                    if ($cInfo->products_count > 0) $contents[] = array('text' => '<tr><td class="infoBoxContent">' . sprintf(TEXT_MOVE_WARNING_PRODUCTS, $cInfo->products_count) . '</td></tr>');            
                }                
            }  
            
            if (is_array($_POST['multi_products'])) {
                foreach ($_POST['multi_products'] AS $multi_product) {
                
                    $contents[] = array('text' => '<tr><td style="border-bottom: 1px solid Black; margin-bottom: 10px;" class="infoBoxContent"><b>' . vam_get_products_name($multi_product) . '</b></td></tr>');    
                    $product_categories_string = '';
                    $product_categories = vam_output_generated_category_path($multi_product, 'product');
                    $product_categories_string = '<tr><td class="infoBoxContent">' . $product_categories . '</td></tr>';
                    $contents[] = array('text' => $product_categories_string); 
                }
            }                     
            
            $contents[] = array('text' => '<tr><td class="infoBoxContent"><strong>' . TEXT_MOVE_ALL . '</strong></td></tr><tr><td>' . vam_draw_pull_down_menu('move_to_category_id', vam_get_category_tree(), $current_category_id) . '</td></tr>');
            //close list table
            $contents[] = array('text' => '</table>');
            //add current category id, for moving products    
            $contents[] = array('text' => '<input type="hidden" name="src_category_id" value="' . $current_category_id . '">');
            $contents[] = array('align' => 'center', 'text' => '<span class="button"><button type="submit" name="multi_move_confirm" value="' . BUTTON_MOVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/move.png', '', '12', '12') . '&nbsp;' . BUTTON_MOVE . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&cID=' . $cInfo->categories_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');            
            //close multi-action form
            $contents[] = array('text' => '</form>'); 
        }
        // multi_move confirm ENDS        
        
        // --------------------
        // multi_delete confirm
        // --------------------
        if (vam_not_null($_POST['multi_delete'])) {
            $heading[]  = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ELEMENTS . '</b>');
            $contents[] = array('text' => '<table width="100%" border="0">');
            
            if (is_array($_POST['multi_categories'])) {
                foreach ($_POST['multi_categories'] AS $multi_category) {
                    $category_query = vam_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $multi_category . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
                    $category = vam_db_fetch_array($category_query);
                    $category_childs   = array('childs_count'   => $catfunc->count_category_childs($multi_category));
                    $category_products = array('products_count' => $catfunc->count_category_products($multi_category, true));
                    $cInfo_array = vam_array_merge($category, $category_childs, $category_products);
                    $cInfo = new objectInfo($cInfo_array);                    
                    $contents[] = array('text' => '<tr><td style="border-bottom: 1px solid Black; margin-bottom: 10px;" class="infoBoxContent"><b>' . $cInfo->categories_name . '</b></td></tr>');
                    if ($cInfo->childs_count > 0)   $contents[] = array('text' => '<tr><td class="infoBoxContent">' . sprintf(TEXT_DELETE_WARNING_CHILDS, $cInfo->childs_count) . '</td></tr>');
                    if ($cInfo->products_count > 0) $contents[] = array('text' => '<tr><td class="infoBoxContent">' . sprintf(TEXT_DELETE_WARNING_PRODUCTS, $cInfo->products_count) . '</td></tr>');            
                }                
            }
            
            if (is_array($_POST['multi_products'])) {
                foreach ($_POST['multi_products'] AS $multi_product) {                
                    $contents[] = array('text' => '<tr><td style="border-bottom: 1px solid Black; margin-bottom: 10px;" class="infoBoxContent"><b>' . vam_get_products_name($multi_product) . '</b></td></tr>');    
                    $product_categories_string = '';
                    $product_categories = vam_generate_category_path($multi_product, 'product');
                    for ($i = 0, $n = sizeof($product_categories); $i < $n; $i++) {
                      $category_path = '';
                      for ($j = 0, $k = sizeof($product_categories[$i]); $j < $k; $j++) {
                        $category_path .= $product_categories[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
                      }
                      $category_path = substr($category_path, 0, -16);
                      $product_categories_string .= vam_draw_checkbox_field('multi_products_categories['.$multi_product.'][]', $product_categories[$i][sizeof($product_categories[$i])-1]['id'], true) . '&nbsp;' . $category_path . '<br />';
                    }
                    $product_categories_string = substr($product_categories_string, 0, -4);
                    $product_categories_string = '<tr><td class="infoBoxContent">' . $product_categories_string . '</td></tr>';
                    $contents[] = array('text' => $product_categories_string); 
                }
            }
            
            //close list table
            $contents[] = array('text' => '</table>');            
            $contents[] = array('align' => 'center', 'text' => '<span class="button"><button type="submit" name="multi_delete_confirm" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&cID=' . $cInfo->categories_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
            //close multi-action form
            $contents[] = array('text' => '</form>');            
        }
        // multi_delete confirm ENDS
        
        // --------------------
        // multi_copy confirm
        // --------------------
        if (vam_not_null($_POST['multi_copy'])) {     
            $heading[]  = array('text' => '<b>' . TEXT_INFO_HEADING_COPY_TO . '</b>');
            $contents[] = array('text' => '<table width="100%" border="0">');
            
            if (is_array($_POST['multi_categories'])) {
                foreach ($_POST['multi_categories'] AS $multi_category) {
                    $category_query = vam_db_query("select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = '" . $multi_category . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
                    $category = vam_db_fetch_array($category_query);
                    $category_childs   = array('childs_count'   => $catfunc->count_category_childs($multi_category));
                    $category_products = array('products_count' => $catfunc->count_category_products($multi_category, true));
                    $cInfo_array = vam_array_merge($category, $category_childs, $category_products);
                    $cInfo = new objectInfo($cInfo_array);                    
                    $contents[] = array('text' => '<tr><td style="border-bottom: 1px solid Black; margin-bottom: 10px;" class="infoBoxContent"><b>' . $cInfo->categories_name . '</b></td></tr>');
                    if ($cInfo->childs_count > 0)   $contents[] = array('text' => '<tr><td class="infoBoxContent">' . sprintf(TEXT_MOVE_WARNING_CHILDS, $cInfo->childs_count) . '</td></tr>');
                    if ($cInfo->products_count > 0) $contents[] = array('text' => '<tr><td class="infoBoxContent">' . sprintf(TEXT_MOVE_WARNING_PRODUCTS, $cInfo->products_count) . '</td></tr>');            
                }                
            }  
            
            if (is_array($_POST['multi_products'])) {
                foreach ($_POST['multi_products'] AS $multi_product) {
                
                    $contents[] = array('text' => '<tr><td style="border-bottom: 1px solid Black; margin-bottom: 10px;" class="infoBoxContent"><b>' . vam_get_products_name($multi_product) . '</b></td></tr>');    
                    $product_categories_string = '';
                    $product_categories = vam_output_generated_category_path($multi_product, 'product');
                    $product_categories_string = '<tr><td class="infoBoxContent">' . $product_categories . '</td></tr>';
                    $contents[] = array('text' => $product_categories_string); 
                }
            }                     
            
            //close list table
            $contents[] = array('text' => '</table>');
    		if (QUICKLINK_ACTIVATED=='true') {
                $contents[] = array('text' => '<hr noshade>');
                $contents[] = array('text' => '<b>'.TEXT_MULTICOPY.'</b><br />'.TEXT_MULTICOPY_DESC);
                $cat_tree=vam_get_category_tree();
                $tree='';
                for ($i=0;$n=sizeof($cat_tree),$i<$n;$i++) {
                    $tree .= '<input type="checkbox" name="dest_cat_ids[]" value="'.$cat_tree[$i]['id'].'"><font size="1">'.$cat_tree[$i]['text'].'</font><br />';
                }
                $contents[] = array('text' => $tree.'<br /><hr noshade>');
                $contents[] = array('text' => '<b>'.TEXT_SINGLECOPY.'</b><br />'.TEXT_SINGLECOPY_DESC);
            }
            $contents[] = array('text' => '<br />' . TEXT_SINGLECOPY_CATEGORY . '<br />' . vam_draw_pull_down_menu('dest_category_id', vam_get_category_tree(), $current_category_id) . '<br /><hr noshade>');
            $contents[] = array('text' => '<strong>' . TEXT_HOW_TO_COPY . '</strong><br />' . vam_draw_radio_field('copy_as', 'link', true) . ' ' . TEXT_COPY_AS_LINK . '<br />' . vam_draw_radio_field('copy_as', 'duplicate') . ' ' . TEXT_COPY_AS_DUPLICATE . '<br /><hr noshade>');
            $contents[] = array('align' => 'center', 'text' => '<span class="button"><button type="submit" name="multi_copy_confirm" value="' . BUTTON_COPY . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/copy.png', '', '12', '12') . '&nbsp;' . BUTTON_COPY . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&cID=' . $cInfo->categories_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');            
            //close multi-action form
            $contents[] = array('text' => '</form>'); 
        }
        // multi_copy confirm ENDS                        
        break;        

      default:
        if ($rows > 0) {
          if (is_object($cInfo)) { 
            // category info box contents
            $heading[]  = array('align' => 'center', 'text' => '<b>' . $cInfo->categories_name . '</b>');
            //Multi Element Actions
            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%;">' . TEXT_MARKED_ELEMENTS . '</div>');
            $contents[] = array('align' => 'center', 'text' => '<table border=0><tr><td align="center"><span class="button"><button type="submit" name="multi_delete" value="'. BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span></td></tr><tr><td align="center"><span class="button"><button type="submit" name="multi_move" value="' . BUTTON_MOVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/move.png', '', '12', '12') . '&nbsp;' . BUTTON_MOVE . '</button></span></td></tr><tr><td align="center"><span class="button"><button type="submit" name="multi_copy" value="' . BUTTON_COPY . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/copy.png', '', '12', '12') . '&nbsp;' . BUTTON_COPY . '</button></span></td></tr></table>');
            $contents[] = array('align' => 'center', 'text' => '<table border=0><tr><td align="center"><span class="button"><button type="submit" name="multi_status_on" value="'. BUTTON_STATUS_ON . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_STATUS_ON . '</button></span></td></tr><tr><td align="center"><span class="button"><button type="submit" name="multi_status_off" value="' . BUTTON_STATUS_OFF . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_STATUS_OFF . '</button></span></td></tr></table>');
            $contents[] = array('text'  => '</form>');
            //Single Element Actions
            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%; margin-top: 5px;">' . TEXT_ACTIVE_ELEMENT . '</div>');
            $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&cID=' . $cInfo->categories_id . '&action=edit_category') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a>');
            //Insert new Element Actions
            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%; margin-top: 5px;">' . TEXT_INSERT_ELEMENT . '</div>');
            if (!$_GET['search']) {
            	$contents[] = array('align' => 'center', 'text' => '<table border=0><tr><td align="center"><a class="button" href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&action=new_category') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/categories.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_CATEGORIES . '</span></a></td></tr><tr><td align="center"><a class="button" href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&action=new_product') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/products.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_PRODUCTS . '</span></a></td></tr></table>');            
            }
            //Informations
            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%; margin-top: 5px;">' . TEXT_INFORMATIONS . '</div>');
            $contents[] = array('text'  => '<div style="padding-left: 50px;">' . TEXT_DATE_ADDED . ' ' . vam_date_short($cInfo->date_added) . '</div>');
            if (vam_not_null($cInfo->last_modified)) $contents[] = array('text' => '<div style="padding-left: 50px;">' . TEXT_LAST_MODIFIED . ' ' . vam_date_short($cInfo->last_modified) . '</div>');            
            $contents[] = array('align' => 'center', 'text' => '<div style="padding: 10px;">' . vam_info_image_c($cInfo->categories_image, $cInfo->categories_name, 100, 100)  . '</div><div style="padding-bottom: 10px;">' . $cInfo->categories_image . '</div>');            
          } elseif (is_object($pInfo)) { 
            // product info box contents
            $heading[]  = array('align' => 'center', 'text' => '<b>' . vam_get_products_name($pInfo->products_id, $_SESSION['languages_id']) . '</b>');
            //Multi Element Actions
            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%;">' . TEXT_MARKED_ELEMENTS . '</div>');
            $contents[] = array('align' => 'center', 'text' => '<table border=0><tr><td align="center">' . '<span class="button"><button type="submit" value="' . BUTTON_DELETE . '" name="multi_delete">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span>'.'</td></tr><tr><td>'.'<span class="button"><button type="submit" value="' . BUTTON_MOVE . '" name="multi_move">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/move.png', '', '12', '12') . '&nbsp;' . BUTTON_MOVE . '</button></span>'.'</td></tr><tr><td align="center">'.'<span class="button"><button type="submit" value="' . BUTTON_COPY . '" name="multi_copy">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/copy.png', '', '12', '12') . '&nbsp;' . BUTTON_COPY . '</button></span>'.'</td></tr></table>');
            $contents[] = array('align' => 'center', 'text' => '<table border=0><tr><td align="center"><span class="button"><button type="submit" name="multi_status_on" value="'. BUTTON_STATUS_ON . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_STATUS_ON . '</button></span></td></tr><tr><td align="center"><span class="button"><button type="submit" name="multi_status_off" value="' . BUTTON_STATUS_OFF . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_STATUS_OFF . '</button></span></td></tr></table>');
            $contents[] = array('text'  => '</form>');            
            //Single Product Actions
            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%; margin-top: 5px;">' . TEXT_ACTIVE_ELEMENT . '</div>');
            $contents[] = array('align' => 'center', 'text' => '<table border=0><tr><td align="center"><a class="button" href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&pID=' . $pInfo->products_id . '&action=new_product') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a></td></tr><tr><td align="center"><form action="' . FILENAME_NEW_ATTRIBUTES . '" name="edit_attributes" method="post"><input type="hidden" name="action" value="edit"><input type="hidden" name="current_product_id" value="' . $pInfo->products_id . '"><input type="hidden" name="cpath" value="' . $cPath . '"><span class="button"><button type="submit" value="' . BUTTON_EDIT_ATTRIBUTES . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT_ATTRIBUTES . '</button></span></form></td></tr><tr><td align="center" style="text-align: center;"><form action="' . FILENAME_CATEGORIES . '" name="edit_crossselling" method="GET"><input type="hidden" name="action" value="edit_crossselling"><input type="hidden" name="current_product_id" value="' . $pInfo->products_id . '"><input type="hidden" name="cpath" value="' . $cPath  . '"><span class="button"><button type="submit" value="' . BUTTON_EDIT_CROSS_SELLING . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT_CROSS_SELLING . '</button></span></form></td></tr></table>');
            //Insert new Element Actions
            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%; margin-top: 5px;">' . TEXT_INSERT_ELEMENT . '</div>');
            if (!$_GET['search']) {
            	$contents[] = array('align' => 'center', 'text' => '<table border=0><tr><td align="center"><a class="button" href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&action=new_category') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/categories.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_CATEGORIES . '</span></a></td></tr><tr><td align="center"><a class="button" href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&action=new_product') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/products.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_PRODUCTS . '</span></a></td></tr></table>');            
            }            
            //Informations
            $contents[] = array('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; width: 90%; margin-top: 5px;">' . TEXT_INFORMATIONS . '</div>');
            $contents[] = array('text'  => '<div style="padding-left: 30px;">' . TEXT_DATE_ADDED . ' ' . vam_date_short($pInfo->products_date_added) . '</div>');
            if (vam_not_null($pInfo->products_last_modified))    $contents[] = array('text' => '<div style="padding-left: 30px;">' . TEXT_LAST_MODIFIED . '&nbsp;' . vam_date_short($pInfo->products_last_modified) . '</div>');
            if (date('Y-m-d') < $pInfo->products_date_available) $contents[] = array('text' => '<div style="padding-left: 30px;">' . TEXT_DATE_AVAILABLE . ' ' . vam_date_short($pInfo->products_date_available) . '</div>');            
            
            // START IN-SOLUTION Berechung des Bruttopreises
            $price = $pInfo->products_price;
            $price = vam_round($price,PRICE_PRECISION);
            $price_string = '' . TEXT_PRODUCTS_PRICE_INFO . '&nbsp;' . $currencies->format($price);
            if (PRICE_IS_BRUTTO=='true' && ($_GET['read'] == 'only' || $_GET['action'] != 'new_product_preview') ){
                $price_netto = vam_round($price,PRICE_PRECISION);
                $tax_query = vam_db_query("select tax_rate from " . TABLE_TAX_RATES . " where tax_class_id = '" . $pInfo->products_tax_class_id . "' ");
                $tax = vam_db_fetch_array($tax_query);
                $price = ($price*($tax[tax_rate]+100)/100);
                $price_string = '' . TEXT_PRODUCTS_PRICE_INFO . '&nbsp;' . $currencies->format($price) . ' - ' . TXT_NETTO . $currencies->format($price_netto);
            }
            $contents[] = array('text' => '<div style="padding-left: 30px;">' . $price_string.  '</div><div style="padding-left: 30px;">' . TEXT_PRODUCTS_DISCOUNT_ALLOWED_INFO . '&nbsp;' . $pInfo->products_discount_allowed . '</div><div style="padding-left: 30px;">' .  TEXT_PRODUCTS_QUANTITY_INFO . '&nbsp;' . $pInfo->products_quantity . '</div>');            
            // END IN-SOLUTION

            //$contents[] = array('text' => '<br />' . TEXT_PRODUCTS_PRICE_INFO . ' ' . $currencies->format($pInfo->products_price) . '<br />' . TEXT_PRODUCTS_QUANTITY_INFO . ' ' . $pInfo->products_quantity);
            $contents[] = array('text' => '<div style="padding-left: 30px; padding-bottom: 10px;">' . TEXT_PRODUCTS_AVERAGE_RATING . ' ' . number_format($pInfo->average_rating, 2) . ' %</div>');
            $contents[] = array('text' => '<div style="padding-left: 30px; padding-bottom: 10px;">' . TEXT_PRODUCT_LINKED_TO . '<br />' . vam_output_generated_category_path($pInfo->products_id, 'product') . '</div>');
            $contents[] = array('text' => '<div style="padding-left: 30px; padding-bottom: 10px;"><a href="'.vam_catalog_href_link('product_info.php', vam_product_link($pInfo->products_id, $pInfo->products_name)).'">' . TEXT_COPY_AS_LINK . ' ' . '</a></div>');
            $contents[] = array('align' => 'center', 'text' => '<div style="padding: 10px;">' . vam_product_thumb_image($pInfo->products_image, $pInfo->products_name)  . '</div><div style="padding-bottom: 10px;">' . $pInfo->products_image.'</div>');
          }          
        } else { 
          // create category/product info
          $heading[] = array('text' => '<b>' . EMPTY_CATEGORY . '</b>');
          $contents[] = array('text' => sprintf(TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS, vam_get_categories_name($current_category_id, $_SESSION['languages_id'])));
          $contents[] = array('align' => 'center', 'text' => '<table border=0><tr><td align="center"><a class="button" href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&action=new_category') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/categories.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_CATEGORIES . '</span></a></td></tr><tr><td align="center"><a class="button" href="' . vam_href_link(FILENAME_CATEGORIES, vam_get_all_get_params(array('cPath', 'action', 'pID', 'cID', 'search')) . 'cPath=' . $cPath . '&action=new_product') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/products.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_PRODUCTS . '</span></a></td></tr></table>');
        }
        break;
    }

    if ((vam_not_null($heading)) && (vam_not_null($contents))) {
      //display info box
      echo '<td valign="top">' . "\n";
      $box = new box;
      echo $box->infoBox($heading, $contents);
      echo '</td>' . "\n";
    }
?>
        </tr>
        </table>
     </td>
    </tr>
    <tr>
     <td>