<?php
/* --------------------------------------------------------------
   $Id: accounting.php 1167 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards www.oscommerce.com 
   (c) 2003	 nextcommerce (accounting.php,v 1.27 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (accounting.php,v 1.27 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'save':


      // reset values before writing
       $admin_access_query = vam_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . (int)$_GET['cID'] . "'");
       $admin_access = vam_db_fetch_array($admin_access_query);

       $fields = vam_db_query("select * from ". TABLE_ADMIN_ACCESS); 
       $columns = mysqli_num_fields($fields);

		for ($i = 0; $i < $columns; $i++) {
             $field=mysqli_fetch_field_direct($fields, $i);
                    if ($field->name!='customers_id') {

                    vam_db_query("UPDATE ".TABLE_ADMIN_ACCESS." SET
                                  `".$field->name."`=0 where customers_id='".(int)$_GET['cID']."'");
    		}
        }



      $access_ids='';
        if(isset($_POST['access'])) foreach($_POST['access'] as $key){

        vam_db_query("UPDATE ".TABLE_ADMIN_ACCESS." SET `".$key."`=1 where customers_id='".(int)$_GET['cID']."'");

        }

        vam_redirect(vam_href_link(FILENAME_CUSTOMERS, 'cID=' . (int)$_GET['cID'], 'NONSSL'));
        break;
      }
    }
    if ($_GET['cID'] != '') {
      if ($_GET['cID'] == 1) {
        vam_redirect(vam_href_link(FILENAME_CUSTOMERS, 'cID=' . (int)$_GET['cID'], 'NONSSL'));
      } else {
        $allow_edit_query = vam_db_query("select customers_status, customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " where customers_id = '" . (int)$_GET['cID'] . "'");
        $allow_edit = vam_db_fetch_array($allow_edit_query);
        if ($allow_edit['customers_status'] != 0 || $allow_edit == '') {
          vam_redirect(vam_href_link(FILENAME_CUSTOMERS, 'cID=' . (int)$_GET['cID'], 'NONSSL'));
        }
      }
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
        <script type="text/javascript">
        var lastChecked = null;
 
        $(document).ready(function() {
                $('input:checkbox').click(function(event) {
                        if(!lastChecked) {
                                lastChecked = this;
                                return;
                        }
 
                        if(event.shiftKey) {
                                var start = $('input:checkbox').index(this);
                                var end = $('input:checkbox').index(lastChecked);
 
                                for(i=Math.min(start,end);i<=Math.max(start,end);i++) {
                                        $('input:checkbox')[i].checked = lastChecked.checked;
                                }
                        }
 
                        lastChecked = this;
                });
        });
        </script>
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
    <td class="boxCenter" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td class="main">
        
    <h1 class="contentBoxHeading"><?php echo TEXT_ACCOUNTING.' '.$allow_edit['customers_lastname'].' '.$allow_edit['customers_firstname']; ?></h1>
    
     <br /><?php echo TXT_GROUPS; ?><br />

      <table width="100%" cellpadding="0" cellspacing="2">
      <tr>
       <td style="border: 1px solid; border-color: #000000;" width="10" bgcolor="#FF6969" ><?php echo vam_draw_separator('pixel_trans.gif',15, 15); ?></td>
       <td width="100%" class="main"><?php echo TXT_SYSTEM; ?></td>
      </tr>
      <tr>
       <td style="border: 1px solid; border-color: #000000;" width="10" bgcolor="#69CDFF" ><?php echo vam_draw_separator('pixel_trans.gif',10, 15); ?></td>
       <td width="100%" class="main"><?php echo TXT_PRODUCTS; ?></td>
      </tr>
      <tr>
       <td style="border: 1px solid; border-color: #000000;" width="10" bgcolor="#6BFF7F" ><?php echo vam_draw_separator('pixel_trans.gif',15, 15); ?></td>
       <td width="100%" class="main"><?php echo TXT_CUSTOMERS; ?></td>
      </tr>
      <tr>
       <td style="border: 1px solid; border-color: #000000;" width="10" bgcolor="#BFA8FF" ><?php echo vam_draw_separator('pixel_trans.gif',15, 15); ?></td>
       <td width="100%" class="main"><?php echo TXT_STATISTICS; ?></td>
      </tr>
      <tr>
       <td style="border: 1px solid; border-color: #000000;" width="10" bgcolor="#FFE6A8" ><?php echo vam_draw_separator('pixel_trans.gif',15, 15); ?></td>
       <td width="100%" class="main"><?php echo TXT_TOOLS; ?></td>
      </tr>
      </table>
      <br />
      </td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent"><?php echo TEXT_ACCESS; ?></td>
            <td class="dataTableHeadingContent"><?php echo TEXT_ALLOWED; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr><table border="0" cellpadding="0" cellspacing="2">
<?php
 echo vam_draw_form('accounting', FILENAME_ACCOUNTING, 'cID=' . $_GET['cID']  . '&action=save', 'post', 'enctype="multipart/form-data"');

   $admin_access='';
    $customers_id = vam_db_prepare_input($_GET['cID']);
    $admin_access_query = vam_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . (int)$_GET['cID'] . "'");
    $admin_access = vam_db_fetch_array($admin_access_query);

    $group_query=vam_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = 'groups'");
    $group_access = vam_db_fetch_array($group_query);
    if ($admin_access == '') {
      vam_db_query("INSERT INTO " . TABLE_ADMIN_ACCESS . " (customers_id) VALUES ('" . (int)$_GET['cID'] . "')");
      $admin_access_query = vam_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = '" . (int)$_GET['cID'] . "'");
      $group_query=vam_db_query("select * from " . TABLE_ADMIN_ACCESS . " where customers_id = 'groups'");
      $group_access = vam_db_fetch_array($admin_access_query);
      $admin_access = vam_db_fetch_array($admin_access_query);
    }

$fields = vam_db_query("select * from ". TABLE_ADMIN_ACCESS); 
$columns = mysqli_num_fields($fields);
for ($i = 0; $i < $columns; $i++) {
    $field=mysqli_fetch_field_direct($fields, $i);
    if ($field->name!='customers_id') {
    $checked='';
    if ($admin_access[$field->name] == '1') $checked='checked';

    // colors
    switch ($group_access[$field->name]) {
            case '1':
            $color='#FF6969';
            break;
            case '2':
            $color='#69CDFF';
            break;
            case '3':
            $color='#6BFF7F';
            break;
            case '4':
            $color='#BFA8FF';
            break;
            case '5':
            $color='#FFE6A8';

    }
    echo '<tr class="dataTable">
    <td style="border: 1px solid; border-color: #000000;" width="10" bgcolor="'.$color.'" >'.vam_draw_separator('pixel_trans.gif',15, 15).'</td>
        <td width="100%" class="dataTableContentRow">
        <input type="checkbox" name="access[]" value="'.$field->name.'"'.$checked.'>
        <b>'.$field->name.'</b>: ' . constant(strtoupper('ACCESS_'.$field->name)).'</td>
        <td></td></tr>';
    }
}
?>
    </table>
<span class="button"><button type="submit" onClick="return confirm('<?php echo SAVE_ENTRY; ?>')" value="<?php echo BUTTON_SAVE; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_SAVE; ?></button></span>
</td>

<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>