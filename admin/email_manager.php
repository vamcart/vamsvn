<?php
/* --------------------------------------------------------------
   $Id: email_manager.php 1304 2007-12-30 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once (DIR_FS_INC.'vam_wysiwyg_tiny.inc.php');
?>
  
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<!--<meta name="viewport" content="initial-scale=1.0, width=device-width" />-->
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
<?php 
 $query=vam_db_query("SELECT code FROM ". TABLE_LANGUAGES ." WHERE languages_id='".$_SESSION['languages_id']."'");
 $data=vam_db_fetch_array($query);
 if (EMAIL_USE_HTML=='true') echo vam_wysiwyg_tiny('products_content',$data['code']); 
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php');?>

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

    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>

<!-- catalog email -->         

<br />
<?php echo TEXT_CATALOG_TEMPLATES; ?>
<br />

<?php
if (isset($_GET['file'])) {

$path_parts = pathinfo($_GET['file']);

$file = DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/mail/' . $_SESSION['language'] . '/' . $path_parts['basename'];

if (is_writable($file)) {
  $chmod = '<font color="Green">' . TEXT_YES . '</font>';
}else{
  $chmod = '<font color="Red">' . TEXT_NO . '</font>';
}

if(file_exists($file)) {
	$code = file_get_contents($file);
}else{
  $code = TEXT_FILE_SELECT;
}

}
?>
<?php echo vam_draw_form('select', FILENAME_EMAIL_MANAGER, '', 'get'); ?>

<?php

$file_list = vam_array_merge(array('0' => array('id' => '', 'text' => SELECT_FILE)),vam_getFiles(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/mail/' . $_SESSION['language'] . '/',array((EMAIL_USE_HTML=='true') ? '.html' : '.txt')));

echo vam_draw_pull_down_menu('file',$file_list,$_REQUEST['file']);

echo '&nbsp;<span class="button"><button type="submit" value="' . BUTTON_EDIT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</button></span>';

               
?>
<br /><br />
</form>
<?php echo vam_draw_form('edit', FILENAME_EMAIL_MANAGER, vam_get_all_get_params(), 'post'); ?>

<?php if($_POST['save'] && is_file($file)){ ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

<tr>
    <td>

<?php echo TEXT_FILE_SAVED; ?>
<br />

    </td>
</tr>

</table>

<?php } else { ?>

<?php if (isset($_GET['file'])) { ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
    <td valign="top">

		  <?php echo TEXT_FILE; ?> <b><?php echo $file ?></b><br /><?php echo TEXT_FILE_WRITABLE; ?> <b><?php echo $chmod ?></b><br />

      <textarea name="code" rows="20" cols="80">
      <?php echo $code ?>
      </textarea>

<br /><br />      
      
      <?php 
  if (is_writable($file)) {
	echo '<span class="button"><button type="submit" name="save" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span>'; 
  }
  ?>
        
    </td>
</tr>

</table>

<?php } ?>

<?php } ?>

<?

if($_POST['save'] && is_file($file)){

if (is_writable($file)) {

    if (!$handle = fopen($file, 'w')) {
         echo TEXT_FILE_OPEN_ERROR . " ($file)";
         exit;
    }

    if (fwrite($handle, stripslashes($_POST['code'])) === FALSE) {
        echo TEXT_FILE_WRITE_ERROR . " ($file)";
        exit;
    }
    
//    echo TEXT_FILE_WRITE_SUCCESS;
    
    fclose($handle);

} else {
    echo TEXT_FILE_PERMISSION_ERROR;
}

}
?>

<br /><br />

<?php if($_POST['save'] && is_file($file)){ ?>

<a class="button" href="<?php echo vam_href_link(FILENAME_EMAIL_MANAGER); ?>"><span><?php echo BUTTON_BACK; ?></span></a>

<?php } ?>

</form>

<!-- /catalog email -->         


<!-- admin email -->         

<br />
<?php echo TEXT_ADMIN_TEMPLATES; ?>
<br />

<?php
if (isset($_GET['file_admin'])) {

$path_parts_admin = pathinfo($_GET['file_admin']);

$file_admin = DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/admin/mail/' . $_SESSION['language'] . '/' . $path_parts_admin['basename'];

if (is_writable($file_admin)) {
  $chmod_admin = '<font color="Green">' . TEXT_YES . '</font>';
}else{
  $chmod_admin = '<font color="Red">' . TEXT_NO . '</font>';
}

if(file_exists($file_admin)) {
	$code_admin = file_get_contents($file_admin);
}else{
  $code_admin = TEXT_FILE_SELECT;
}

}
?>
<?php echo vam_draw_form('select_admin', FILENAME_EMAIL_MANAGER, '', 'get'); ?>

<?php

$file_list_admin = vam_array_merge(array('0' => array('id' => '', 'text' => SELECT_FILE)),vam_getFiles(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/admin/mail/' . $_SESSION['language'] . '/',array((EMAIL_USE_HTML=='true') ? '.html' : '.txt')));

echo vam_draw_pull_down_menu('file_admin',$file_list_admin,$_REQUEST['file_admin']);

echo '&nbsp;<span class="button"><button type="submit" value="' . BUTTON_EDIT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</button></span>';

               
?>
<br /><br />
</form>
<?php echo vam_draw_form('edit_admin', FILENAME_EMAIL_MANAGER, vam_get_all_get_params(), 'post'); ?>

<?php if($_POST['save'] && is_file($file_admin)){ ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">

<tr>
    <td>

<?php echo TEXT_FILE_SAVED; ?>
<br />

    </td>
</tr>

</table>

<?php } else { ?>

<?php if (isset($_GET['file_admin'])) { ?>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
    <td valign="top">

		  <?php echo TEXT_FILE; ?> <b><?php echo $file_admin ?></b><br /><?php echo TEXT_FILE_WRITABLE; ?> <b><?php echo $chmod_admin ?></b><br />

      <textarea name="code_admin" rows="20" cols="80">
      <?php echo $code_admin ?>
      </textarea>

<br /><br />      
      
      <?php 
  if (is_writable($file_admin)) {
	echo '<span class="button"><button type="submit" name="save" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span>'; 
  }
  ?>
        
    </td>
</tr>

</table>

<?php } ?>

<?php } ?>

<?

if($_POST['save'] && is_file($file_admin)){

if (is_writable($file_admin)) {

    if (!$handle = fopen($file_admin, 'w')) {
         echo TEXT_FILE_OPEN_ERROR . " ($file_admin)";
         exit;
    }

    if (fwrite($handle, stripslashes($_POST['code_admin'])) === FALSE) {
        echo TEXT_FILE_WRITE_ERROR . " ($file_admin)";
        exit;
    }
    
//    echo TEXT_FILE_WRITE_SUCCESS;
    
    fclose($handle);

} else {
    echo TEXT_FILE_PERMISSION_ERROR;
}

}
?>

<br /><br />

<?php if($_POST['save'] && is_file($file_admin)){ ?>

<a class="button" href="<?php echo vam_href_link(FILENAME_EMAIL_MANAGER); ?>"><span><?php echo BUTTON_BACK; ?></span></a>

<?php } ?>

</form>

<!-- /admin email -->         

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