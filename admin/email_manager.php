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
  
?>
  
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<?php if (ENABLE_TABS == 'true') { ?>
<script type="text/javascript" src="includes/javascript/tabber.js"></script>
<link rel="stylesheet" href="includes/javascript/tabber.css" TYPE="text/css" MEDIA="screen">
<link rel="stylesheet" href="includes/javascript/tabber-print.css" TYPE="text/css" MEDIA="print">
<?php } ?>
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
    <td class="boxCenter" width="100%" valign="top">
    
    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>

<?php

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
?>
<?php echo vam_draw_form('select', FILENAME_EMAIL_MANAGER, '', 'get'); ?>

<?php

$file_list = vam_array_merge(array('0' => array('id' => '', 'text' => SELECT_FILE)),vam_getFiles(DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/mail/russian/',array('.txt','.html')));

echo vam_draw_pull_down_menu('file',$file_list,$_REQUEST['file']);

echo '&nbsp;<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_EDIT . '"/>';

               
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
	echo '<input type="submit" name="save" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>'; 
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

<a class="button" onClick="this.blur();" href="<?php echo vam_href_link(FILENAME_EMAIL_MANAGER); ?>"><?php echo BUTTON_BACK; ?></a>

<?php } ?>

</form>
         
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