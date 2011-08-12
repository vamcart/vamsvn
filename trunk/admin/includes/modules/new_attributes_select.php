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

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
defined('_VALID_VAM') or die('Direct Access to this location is not allowed.');
$adminImages = DIR_WS_CATALOG . "lang/". $_SESSION['language'] ."/admin/images/buttons/";
?>
    <h1 class="contentBoxHeading"><?php echo $pageTitle; ?></h1>
   
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="SELECT_PRODUCT" method="post"><input type="hidden" name="action" value="edit">
<?php
echo vam_draw_hidden_field(vam_session_name(), vam_session_id());
  echo "<TR>";
  echo "<TD class=\"main\"><br /><B>".SELECT_PRODUCT."<br /></TD>";
  echo "</TR>";
  echo "<TR>";
  echo "<TD class=\"main\"><SELECT NAME=\"current_product_id\">";

  $query = "SELECT * FROM  ".TABLE_PRODUCTS_DESCRIPTION."  where products_id LIKE '%' AND language_id = '" . $_SESSION['languages_id'] . "' ORDER BY products_name ASC";

  $result = vam_db_query($query);

  $matches = vam_db_num_rows($result);

  if ($matches) {
    while ($line = vam_db_fetch_array($result)) {
      $title = $line['products_name'];
      $current_product_id = $line['products_id'];

      echo "<OPTION VALUE=\"" . $current_product_id . "\">" . $title;
    }
  } else {
    echo "You have no products at this time.";
  }

  echo "</SELECT>";
  echo "</TD></TR>";

  echo "<TR>";
  echo "<TD class=\"main\">";
  echo '<span class="button"><button type="submit" value="' . BUTTON_EDIT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</button></span>';

  echo "</TD>";
  echo "</TR>";
  // start change for Attribute Copy
?>
<br /><br />
<?php
  echo "<TR>";
  echo "<TD class=\"main\"><br /><B>".SELECT_COPY."<br /></TD>";
  echo "</TR>";
  echo "<TR>";
  echo "<TD class=\"main\"><SELECT NAME=\"copy_product_id\">";

  $copy_query = vam_db_query("SELECT pd.products_name, pd.products_id FROM  ".TABLE_PRODUCTS_DESCRIPTION."  pd, ".TABLE_PRODUCTS_ATTRIBUTES." pa where pa.products_id = pd.products_id AND pd.products_id LIKE '%' AND pd.language_id = '" . $_SESSION['languages_id'] . "' GROUP BY pd.products_id ORDER BY pd.products_name ASC");
  $copy_count = vam_db_num_rows($copy_query);

  if ($copy_count) {
      echo '<option value="0">no copy</option>';
      while ($copy_res = vam_db_fetch_array($copy_query)) {
          echo '<option value="' . $copy_res['products_id'] . '">' . $copy_res['products_name'] . '</option>';
      }
  }
  else {
      echo 'No products to copy attributes from';
  }
  echo '</select></td></tr>';
  echo "<TR>";
  echo "<TD class=\"main\">".'<span class="button"><button type="submit" value="' . BUTTON_EDIT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</button></span>'."</TD>";
  echo "</TR>";

?>
</form>
</table>