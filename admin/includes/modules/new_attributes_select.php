<?php
/* --------------------------------------------------------------
   $Id: new_attributes_select.php 901 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_attributes_select.php); www.oscommerce.com 
   (c) 2003	 nextcommerce (new_attributes_select.php,v 1.9 2003/08/21); www.nextcommerce.org
   (c) 2004 xt:Commerce (new_attributes_select.php,v 1.9 2003/08/21); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------
   Third Party contributions:
   New Attribute Manager v4b				Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
   copy attributes                          Autor: Hubi | http://www.netz-designer.de
	Multiple attributes change (all items of category)   Author: DaneSoul | http://danesoul.info

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
defined('_VALID_VAM') or die('Direct Access to this location is not allowed.');
$adminImages = DIR_WS_CATALOG . "lang/". $_SESSION['language'] ."/admin/images/buttons/";
?>
    <h1 class="contentBoxHeading"><?php echo $pageTitle; ?></h1>

<div align='left'>

<!-- START FORM -->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="SELECT_PRODUCT" method="post"><input type="hidden" name="action" value="edit">

<?php
	// HIDDEN FIELD
echo vam_draw_hidden_field(vam_session_name(), vam_session_id());
	// <input type="hidden" name="sid" value="d11f22b93719bcd78f0c9030c184a70f">

if(isset($_GET['category'])){
		// http://_vamshop/admin/new_attributes.php?group=true
	echo "<input type='hidden' name='category' value='true'>";		
		
	echo '<h2>Выберите категорию, для которой задаете атрибуты</h2>';		
	  
	  // FIRST SELECT LIST START (CATEGORIES)	
   $catsort    = 'c.sort_order, cd.categories_name ASC';	  
	
	// SELECT ALL CATEGORIES (not only for current parent)  
	$categories_query = "select c.categories_id, cd.categories_name, c.categories_image, c.parent_id, c.sort_order, c.date_added, c.last_modified, c.yml_enable, c.categories_status from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_id = cd.categories_id and cd.language_id = '" . (int)$_SESSION['languages_id'] . "' order by " . $catsort;
	// echo 	$categories_query; //--DEBUG
	  
   $categories_result = vam_db_query($categories_query);
 
	echo "<SELECT NAME=\"current_product_id\">";
	// USE same name as for items, to avoid changing new_attributes_include.php
	// So category name is passed to new_attributes_change as itm name
	// Special <input type="hidden" name="category" value="true"> passed for use item as category
 	
   $categories_matches = vam_db_num_rows($categories_result);
   
 	if ($categories_matches) {
	    while ($categories_line = vam_db_fetch_array($categories_result)) {
	      	//$title = $line['products_name'];
	      	//$current_product_id = $line['products_id'];
	
	      	echo '<OPTION VALUE="' . $categories_line['categories_id'] . '">' . 
	      									$categories_line['categories_name'] .'</OPTION>';     	
	      	
	      	//echo('<pre>'); print_r($categories_line);  echo('</pre>');
	    }
	  } else {
	    		echo "You have no categories at this time / У Вас нет категорий в данный момент";
	  } 
	  
	 echo "</SELECT>";    
}
else{
	  echo '<h2>Выберите товар, для которого задаете атрибуты</h2>';		
	
	  // FIRST SELECT LIST START (ITEMS)
	  echo "<SELECT NAME=\"current_product_id\">";
	
	  $item_query = "SELECT * FROM  ".TABLE_PRODUCTS_DESCRIPTION."  where products_id LIKE '%' AND language_id = '" . $_SESSION['languages_id'] . "' ORDER BY products_name ASC";
	
	  $item_result = vam_db_query($item_query);
	
	  $item_matches = vam_db_num_rows($item_result);
	
	  if ($item_matches) {
	    while ($item_line = vam_db_fetch_array($item_result)) {
	
	      echo "<OPTION VALUE=\"" . $item_line['products_id'] . "\">" . $item_line['products_name'] .'</OPTION>';
	    }
	  } else {
	      echo "You have no products at this time / У Вас нет продуктов в данный момент";
	  }
	
	  echo "</SELECT>";	
}


?>

<br /><br />

<?php
  echo '<h2>Выберите товар, с которого копируете атрибуты</h2>';	

// SECOND SELECT LIST START
  echo "<SELECT NAME=\"copy_product_id\">";

  $copy_query = vam_db_query("SELECT pd.products_name, pd.products_id FROM  ".TABLE_PRODUCTS_DESCRIPTION."  pd, ".TABLE_PRODUCTS_ATTRIBUTES." pa where pa.products_id = pd.products_id AND pd.products_id LIKE '%' AND pd.language_id = '" . $_SESSION['languages_id'] . "' GROUP BY pd.products_id ORDER BY pd.products_name ASC");
  $copy_count = vam_db_num_rows($copy_query);

  if ($copy_count) {
      echo '<option value="0">no copy</option>';
      while ($copy_res = vam_db_fetch_array($copy_query)) {
          echo '<option value="' . $copy_res['products_id'] . '">' . $copy_res['products_name'] . '</option>';
      }
  }
  else {
      echo 'No products to copy attributes from / Нет продуктов с которых копировать атрибты';
  }
  echo '</select>';
  
  
  	// SINGLE SUBMIT BUTTON
	  echo '<br><span class="button"><button type="submit" value="' . BUTTON_EDIT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</button></span>';

if(!isset($_GET['category'])){
	
  echo '<h2>Установка атрибутов категории</h2>';	

	  echo '<a class="button" href="' . vam_href_link(FILENAME_NEW_ATTRIBUTES, 'category=true', 'NONSSL')  .'"><span>'.vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' .BOX_ATTRIBUTES_MANAGER_CATEGORIES.'</span></a>';

}
?>
</form>
</div>