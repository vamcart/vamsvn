<?php
/* --------------------------------------------------------------
   $Id: languages.php 1180 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(latest_news.php,v 1.33 2003/05/07); www.oscommerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once(DIR_FS_INC . 'vam_wysiwyg_tiny.inc.php');
  require_once (DIR_FS_INC.'vam_image_submit.inc.php');

  if ($_GET['action']) {
    switch ($_GET['action']) {

      case 'insert_review': //insert a new item.
        if ($_POST['reviews_text'] != '') {
        	
        	$date = date_create($_POST['date_added']);

        $avatar = '';
        $customers_avatar = new upload('customers_avatar');
        $customers_avatar->set_destination(DIR_FS_CATALOG_IMAGES .'avatars/');

        if ($customers_avatar->parse() && $customers_avatar->save()) {
            $avatar = vam_db_input($customers_avatar->filename);
        }

			if ($avatar == '' && $_POST['customers_avatar_name'] != '' && $avatar != $_POST['customers_avatar_name']) {
        $avatar = $_POST['customers_avatar_name'];
        }
        
			if ($_POST['customers_name_select'] != '') $_POST['customers_name'] = $_POST['customers_name_select'];         
        
          $sql_data_array = array('manufacturers_id'   => vam_db_prepare_input($_POST['manufacturers_id']),
                                  'customers_id'    => '0',
                                  'customers_name'    => vam_db_prepare_input($_POST['customers_name']),
                                  'customers_avatar'    => vam_db_prepare_input($avatar),
                                  'reviews_rating'    => vam_db_prepare_input($_POST['reviews_rating']),
                                  'date_added' => vam_db_prepare_input(date_format($date, 'Y-m-d H:i:s')), //uses the inbuilt mysql function 'now'
                                  'last_modified' => 'now()', //uses the inbuilt mysql function 'now'
                                  'reviews_read'     => '1' );
          vam_db_perform(TABLE_COMPANY_REVIEWS, $sql_data_array);
          $reviews_id = vam_db_insert_id(); //not actually used ATM -- just there in case

          $sql_data_array = array('reviews_id'   => $reviews_id,
                                  'languages_id'    => vam_db_prepare_input($_POST['item_language']),
                                  'reviews_text'    => vam_db_prepare_input($_POST['reviews_text']));
          vam_db_perform(TABLE_COMPANY_REVIEWS_DESCRIPTION, $sql_data_array);
          
        }
        vam_redirect(vam_href_link(FILENAME_COMPANY_REVIEWS));
        break;

    }
  }
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<!--<meta name="viewport" content="initial-scale=1.0, width=device-width" />-->
<meta http-equiv="Content-Type" content="text/html; charset="<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
<script type="text/javascript"><!--
$(document).ready(function() {
$( "#date-added" ).datepicker({ dateFormat: "dd-mm-yy" }).val();
});
//--></script>

<?php 
 $query=vam_db_query("SELECT code FROM ". TABLE_LANGUAGES ." WHERE languages_id='".$_SESSION['languages_id']."'");
 $data=vam_db_fetch_array($query);
 if ($_GET['action']=='add_review') echo vam_wysiwyg_tiny('latest_news',$data['code']); 
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'false') { ?>
    <td width="<?php echo BOX_WIDTH; ?>" align="left" valign="top">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </td>
<?php } ?>
<!-- body_text //-->
    <td class="boxCenter" valign="top">
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"></td>
          </tr>
        </table>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">

      <tr><?php echo vam_draw_form('add_review', FILENAME_COMPANY_REVIEWS_ADD, vam_get_all_get_params(array('action')) . 'action=insert_review', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" cellspacing="0" cellpadding="2" width="100%">
      
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo TEXT_REVIEWS_PRODUCT; ?></b> 
      
<?php

echo vam_draw_products_pull_down_company_review('manufacturers_id','class="select2"'); 

?>

</td>
          </tr>
        </table></td>
      </tr>      
      
      
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_FIRST_NAME; ?></b> <?php echo vam_draw_customers_pull_down("customers_name_select",'class="select2"'); ?> <b><?php echo ENTRY_NAME; ?></b> <?php echo vam_draw_input_field('customers_name', ''); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_AVATAR; ?></b> <?php echo vam_draw_file_field('customers_avatar'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_DATE; ?></b> <?php echo vam_draw_input_field('date_added', '', 'id="date-added"'); ?></td>
            <td class="main rating"><?php for ($i=1; $i<=5; $i++) echo vam_draw_radio_field('reviews_rating', $i, '', true, 'class="star-rating"'); ?>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_REVIEW; ?></b> <?php echo vam_draw_textarea_field('reviews_text', 'soft', '60', '15', ''); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main language" valign="top"><b><?php echo TEXT_REVIEWS_LANGUAGE; ?></b> 
      
<?php

  $languages = vam_get_languages();
  $languages_array = array();

  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                        
  if ($languages[$i]['id']==$reviews['language']) {
         $languages_selected=$languages[$i]['id'];
         $languages_id=$languages[$i]['id'];
        }               
    $languages_array[] = array('id' => $languages[$i]['id'],
               'text' => $languages[$i]['name']);

  } // for
  
echo vam_draw_pull_down_menu('item_language',$languages_array,$languages_selected); ?>

</td>
          </tr>
        </table></td>
      </tr>


        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right">
          <?php
            echo '<span class="button"><button type="submit" value="' . BUTTON_INSERT .'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' .BUTTON_INSERT . '</button></span>';
          ?>
        </td>
      </form></tr>

            </table></td>

          </tr>
        </table></td>
      </tr>

    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>