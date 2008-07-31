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

////////////////////////////////////////////////////////////////////////  
//include needed functions
require_once (DIR_FS_INC.'vam_get_products_mo_images.inc.php');
// BOF Add existing image
require_once(DIR_WS_FUNCTIONS . 'trumbnails_add_funcs.php');
// EOF Add existing image 	
require_once ('includes/classes/categories.php');
// show images
// BOF Add existing image

$file_list = vam_array_merge(array('0' => array('id' => '', 'text' => TEXT_SELECT_IMAGE)),vam_get_files_in_dir(DIR_FS_CATALOG_ORIGINAL_IMAGES));
// EOF Add existing image
	
 $filenames_list = array();	
 $image_list = array();	  
   ///////////////////   getting list of image filenames
    for($i=1;$i<sizeof($file_list);$i++) 
      {	 
	    $filenames_list[]=$file_list[$i]['text'];        
      }	  
   ///////////////////   getting list of products_image
    $img_list = vam_db_query("select p.products_image  from  products p where p.products_image<>'' ORDER BY p.products_image ");     
   	 while($image_row = mysql_fetch_array($img_list))
    {	        
		
		  $image_list[] = $image_row['products_image'];	 		    		
    }		
  
	///////////////////   getting list of unnessesary files
	$delete_list=array_diff($filenames_list, $image_list);
	$not_found=array_diff($image_list,$filenames_list);		
		
	// deleting unused images
	 if ($_GET['action'] == 'delete_img')
	 {	 
	 delete_unused_image_files($delete_list);  	
	// echo "Files have been removed";
	 vam_redirect(vam_href_link(FILENAME_CACHE));  	 
	 }	 
	 // deleting unused images		
	

///////////////////////////////////////////////////////////////////////
if (isset($_GET['action'])) {
  if ($_GET['action'] == 'unlink' and $_GET['action'] == 'delete_img') {
    vam_redirect(vam_href_link(FILENAME_CACHE));
  }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
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
    <td class="boxCenter" width="100%" valign="top">
    
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
echo '<input type="submit" class="button" name="unlink" value="' . TEXT_RESET_CACHE . '"/>'
. '</form>';
  } else {
    echo "<br />\n" . TEXT_NOCACHE_FILES;
}

?>	 

<br>
<?php	

	echo '<br />'.TEXT_FILES_TOTAL. sizeof($filenames_list).' <div style="overflow:auto;height:50px;padding:1em;border: 1px solid black;">';
   		while ($del=each($filenames_list)) 
	      {	 
		    echo $del[value]."<br />\n";
	      }	   
		 echo "</div><br />\n"; 	    
 	echo '<br>'.TEXT_IMAGES_TOTAL.sizeof($image_list).' <div style="overflow:auto;height:50px;padding:1em;border: 1px solid black;">';
  		 while ($del=each($image_list)) 
	      {	 
		    echo $del[value]."<br />\n";
	      }	 		
    echo "</div><br />\n"; 
	
	echo '<br>'.TEXT_NOT_FOUND.sizeof($not_found).' <div style="overflow:auto;height:50px;padding:1em;border: 1px solid black;">';
	   
		while ($del=each($not_found)) 
	      {	 
		    echo $del[value]."<br />\n";
	      }	   
		 echo "</div><br />\n"; 
		 
		 echo '<br>'.TEXT_EXTRA_TOTAL.sizeof($delete_list).' <div style="overflow:auto;height:50px;padding:1em;border: 1px solid black;">';
	   
		while ($del=each($delete_list)) 
	      {	 
		    echo $del[value]."<br />\n";
	      }	   
		 echo "</div><br />\n";
		 
		if (sizeof($delete_list) >= 1) {
		echo vam_draw_form('reset', FILENAME_CACHE, '', 'get'). vam_draw_hidden_field('action', 'delete_img');
		echo '<input type="submit" class="button" name="delete_img" value="' . DELETE_FILES . '"/>'
		. '</form>';
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