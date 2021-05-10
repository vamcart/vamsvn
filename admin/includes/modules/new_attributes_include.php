<?php
/* --------------------------------------------------------------
   $Id: new_attributes_include.php 901 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_attributes_functions); www.oscommerce.com 
   (c) 2003	 nextcommerce (new_attributes_include.php,v 1.11 2003/08/21); www.nextcommerce.org
   (c) 2004 xt:Commerce (new_attributes_include.php,v 1.11 2003/08/21); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------
   Third Party contributions:
   New Attribute Manager v4b				Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
   Multiple attributes change (all items of category)   Author: DaneSoul | http://danesoul.info

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
defined('_VALID_VAM') or die('Direct Access to this location is not allowed.');
   // include needed functions

   require_once(DIR_FS_INC .'vam_get_tax_rate.inc.php');
   require_once(DIR_FS_INC .'vam_get_tax_class_id.inc.php');
   require(DIR_FS_CATALOG.DIR_WS_CLASSES . 'vam_price.php');
   $vamPrice = new vamPrice(DEFAULT_CURRENCY,$_SESSION['customers_status']['customers_status_id'],$_SESSION['customer_id'] ? $_SESSION['customer_id'] : "");
?>
    <h1 class="contentBoxHeading"><?php echo $pageTitle; ?></h1>
   
    <table border="0" width="100%" cellspacing="0" cellpadding="2">

    
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="SUBMIT_ATTRIBUTES" enctype="multipart/form-data"><input type="hidden" name="current_product_id" value="<?php echo $_POST['current_product_id']; ?>"><input type="hidden" name="cpath" value="<?php echo $_GET['cpath']; ?>"><input type="hidden" name="action" value="change">
<?php
if(isset($_POST['category'])){
	echo "<input type='hidden' name='category' value='true'>";
	// to define item as category in new_attributes_change.php
}


echo vam_draw_hidden_field(vam_session_name(), vam_session_id());
  if ($cPath) echo '<input type="hidden" name="cPathID" value="' . $cPath . '">';

  require(DIR_WS_MODULES . 'new_attributes_functions.php');

  // Temp id for text input contribution.. I'll put them in a seperate array.
  $tempTextID = '1999043';

  // Lets get all of the possible options
  $query = "SELECT * FROM ".TABLE_PRODUCTS_OPTIONS." where products_options_id LIKE '%' AND language_id = '" . $_SESSION['languages_id'] . "'";
  $result = vam_db_query($query);
  $matches = vam_db_num_rows($result);

  if ($matches) {
    while ($line = vam_db_fetch_array($result)) {
      $current_product_option_name = $line['products_options_name'];
      $current_product_option_id = $line['products_options_id'];
      // Print the Option Name
      echo "<TR class=\"dataTableHeadingRow\">";
      echo "<TD class=\"dataTableHeadingContent\"><B>" . $current_product_option_name . "</B></TD>";
      echo "<TD class=\"dataTableHeadingContent\"><B>".SORT_ORDER."</B></TD>";
      echo "<TD class=\"dataTableHeadingContent\"><B>".ATTR_MODEL."</B></TD>";
      echo "<TD class=\"dataTableHeadingContent\"><B>".ATTR_STOCK."</B></TD>";
      echo "<TD class=\"dataTableHeadingContent\"><B>".ATTR_WEIGHT."</B></TD>";
      echo "<TD class=\"dataTableHeadingContent\"><B>".ATTR_PREFIXWEIGHT."</B></TD>";
      echo "<TD class=\"dataTableHeadingContent\"><B>".ATTR_PRICE."</B></TD>";
      echo "<TD class=\"dataTableHeadingContent\"><B>".ATTR_PREFIXPRICE."</B></TD>";

      echo "</TR>";

      // Find all of the Current Option's Available Values
      $query2 = "SELECT * FROM ".TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS." povto
	  LEFT JOIN ".TABLE_PRODUCTS_OPTIONS_VALUES." pov ON povto.products_options_values_id=pov.products_options_values_id 
	  WHERE povto.products_options_id = '" . $current_product_option_id . "' AND language_id = '" . $_SESSION['languages_id'] . "' ORDER BY pov.products_options_values_name ASC";
      $result2 = vam_db_query($query2);
      $matches2 = vam_db_num_rows($result2);

      if ($matches2) {
        $i = '0';
        while ($line = vam_db_fetch_array($result2)) {
          $i++;
          $rowClass = rowClass($i);
          $current_value_id = $line['products_options_values_id'];
          $isSelected = checkAttribute($current_value_id, $_POST['current_product_id'], $current_product_option_id);
          if ($isSelected) {
            $CHECKED = ' CHECKED';
          } else {
            $CHECKED = '';
          }

          $query3 = "SELECT * FROM ".TABLE_PRODUCTS_OPTIONS_VALUES." WHERE products_options_values_id = '" . $current_value_id . "' AND language_id = '" . $_SESSION['languages_id'] . "'";
          $result3 = vam_db_query($query3);
          while($line = vam_db_fetch_array($result3)) {
            $current_value_name = $line['products_options_values_name'];
            // Print the Current Value Name
            echo "<TR class=\"" . $rowClass . "\">";
            echo "<TD class=\"main\">";
            echo "<label><input type=\"checkbox\" name=\"optionValues[]\" value=\"" . $current_value_id . "\"" . $CHECKED . ">&nbsp;&nbsp;" . $current_value_name . "&nbsp;&nbsp;</label>";
            echo "</TD>";
            echo "<TD class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_sortorder\" value=\"" . $sortorder . "\" size=\"4\"></TD>";
            echo "<TD class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_model\" value=\"" . $attribute_value_model . "\" size=\"15\"></TD>";
            echo "<TD class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_stock\" value=\"" . $attribute_value_stock . "\" size=\"4\"></TD>";
            echo "<TD class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_weight\" value=\"" . $attribute_value_weight . "\" size=\"10\"></TD>";
            echo "<TD class=\"main\" align=\"left\"><SELECT name=\"" . $current_value_id . "_weight_prefix\"><OPTION value=\"+\"" . $posCheck_weight . ">+<OPTION value=\"-\"" . $negCheck_weight . ">-</SELECT></TD>";

            // brutto Admin
            if (PRICE_IS_BRUTTO=='true'){
            $attribute_value_price_calculate = $vamPrice->Format(vam_round($attribute_value_price*((100+(vam_get_tax_rate(vam_get_tax_class_id($_POST['current_product_id']))))/100),PRICE_PRECISION),false);
            } else {
            $attribute_value_price_calculate = vam_round($attribute_value_price,PRICE_PRECISION);
            }
            echo "<TD class=\"main\" align=\"left\"><input type=\"text\" name=\"" . $current_value_id . "_price\" value=\"" . $attribute_value_price_calculate . "\" size=\"10\">";
            // brutto Admin
            if (PRICE_IS_BRUTTO=='true'){
             echo TEXT_NETTO .'<b>'.$vamPrice->Format(vam_round($attribute_value_price,PRICE_PRECISION),true).'</b>  ';
            }

            echo "</TD>";

              echo "<TD class=\"main\" align=\"left\"><SELECT name=\"" . $current_value_id . "_prefix\"> <OPTION value=\"+\"" . $posCheck . ">+<OPTION value=\"-\"" . $negCheck . ">-</SELECT></TD>";



            echo "</TR>";
            // Download function start
            if(DOWNLOAD_ENABLED == 'true') {

                $file_list = vam_array_merge(array('0' => array('id' => '', 'text' => SELECT_FILE)),vam_getFiles(DIR_FS_CATALOG.'download/'));

                echo "<tr>";

               // echo "<td colspan=\"2\">File: <input type=\"file\" name=\"" . $current_value_id . "_download_file\"></td>";
//                echo "<td colspan=\"2\" class=\"main\">&nbsp;" . DL_FILE . "<br>" . vam_draw_pull_down_menu($current_value_id . '_download_file', vam_getDownloads(), $attribute_value_download_filename, '')."</td>";
                echo "<td colspan=\"2\" class=\"main\">&nbsp;" . DL_FILE . "<br>" . vam_draw_pull_down_menu($current_value_id . '_download_file',$file_list,$attribute_value_download_filename)."</td>";                echo "<td class=\"main\">&nbsp;". DL_COUNT . "<br><input type=\"text\" name=\"" . $current_value_id . "_download_count\" value=\"" . $attribute_value_download_count . "\"></td>";                echo "<td class=\"main\">&nbsp;". DL_EXPIRE . "<br><input type=\"text\" name=\"" . $current_value_id . "_download_expire\" value=\"" . $attribute_value_download_expire . "\"></td>";
                ?>
                 <td class="main" align="left"><?php echo TABLE_TEXT_IS_PIN; ?> <?php echo vam_draw_checkbox_field($current_value_id . '_ispin', $products_attributes_is_pin,  $products_attributes_is_pin); ?>&nbsp;</td>
                <?php
                echo "</tr>";
            }
            // Download function end
          }
          if ($i == $matches2 ) $i = '0';
        }
      } else {
        echo "<TR>";
        echo "<TD class=\"main\"><SMALL>No values under this option.</SMALL></TD>";
        echo "</TR>";
      }
    }
  }
?>
  <tr>
    <td colspan="10" class="main"><br>
<?php
echo '<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span>' . '&nbsp;';
echo '<a class="button" href="javascript:history.back()"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>';
?>
</td>
  </tr>
</form>
</table>