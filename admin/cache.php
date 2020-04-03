<?php
/* --------------------------------------------------------------
   $Id: cache.php,v 1.1 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cache.php,v 1.13 2003/05/03); www.oscommerce.com
   (c) 2003	 nextcommerce (cache.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2004	 xt:Commerce (cache.php,v 1.4 2003/08/14); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require_once('includes/application_top.php');
  require_once (DIR_FS_INC.'vam_image_submit.inc.php');
  require_once(DIR_FS_INC . 'vam_format_filesize.inc.php');
  require_once(DIR_FS_INC . 'vam_delete_file.inc.php');


// check if the cache directory exists
  if (!is_dir(DIR_FS_CATALOG . DIR_FS_CACHE))
    $messageStack->add(ERROR_CACHE_DIRECTORY_DOES_NOT_EXIST, 'error');
    if (!is_writeable(DIR_FS_CATALOG . DIR_FS_CACHE))
   $messageStack->add(ERROR_CACHE_DIRECTORY_NOT_WRITEABLE, 'error');

$dir = DIR_FS_CATALOG . DIR_FS_CACHE . '/';

if ($d = opendir($dir)) {

  $i=0;
    while (false !== ($file = readdir($d))) {
      if ($file != "." && $file != ".." && $file !=".htaccess") {
  $i++;
          if ($_GET['action'] == 'unlink') {
            vam_delete_file($dir . $file);
          }
      }
    }

    closedir($d);
}

$dir_template_cache = DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/cache/';

if ($d_t = opendir($dir_template_cache)) {

  $i_t=0;
    while (false !== ($file_template = readdir($d_t))) {
      if ($file_template != "." && $file_template != ".." && $file_template !="index.html") {
  $i_t++;
          if ($_GET['action'] == 'unlink') {
            vam_delete_file($dir_template_cache . $file_template);
          }
      }
    }

    closedir($d_t);
}

if (isset($_GET['action'])) {
  if ($_GET['action'] == 'unlink') {
    vam_redirect(vam_href_link(FILENAME_CACHE));
  }
}

?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<!--<meta name="viewport" content="initial-scale=1.0, width=device-width" />-->
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
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
    
    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td>

<?php

  echo TEXT_CACHE_DIRECTORY . $dir."<br />\n";
  echo vam_spaceUsed($dir);
  echo USED_SPACE . vam_format_filesize($total)." including .htaccess<br />\n";

if ($i >= 1) {
  echo TEXT_TOTAL_FILES . $i."<br /><br />\n";

###### uncomment if you want to show cache files ######
/*
  echo TEXT_FILES."<br />\n";

  if ($d = opendir($dir)) {

  echo '<div style="overflow:auto;height:200px;border-style:inset;padding:1em;">';
    while (false !== ($file = readdir($d))) {
      if ($file != "." && $file != ".." && $file !=".htaccess") {
        echo $file."<br />\n";
      }
    }
  closedir($d);
  echo "</div><br />\n";
  }
*/
echo vam_draw_form('reset', FILENAME_CACHE, '', 'get'). vam_draw_hidden_field('action', 'unlink');
echo '<span class="button"><button type="submit" name="unlink" value="' . TEXT_RESET_CACHE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . TEXT_RESET_CACHE . '</button></span>'
. '</form>';
  } else {
    echo "<br />\n" . TEXT_NOCACHE_FILES;
}

?>	 

            </td>
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
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>