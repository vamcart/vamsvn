<?php
/* --------------------------------------------------------------
   $Id: content_manager.php 1304 2010-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards www.oscommerce.com 
   (c) 2003	 nextcommerce (content_manager.php,v 1.18 2003/08/25); www.nextcommerce.org
   (c) 2004	 xt:Commerce (content_manager.php,v 1.18 2003/08/25); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contribution:
   SPAW PHP WYSIWYG editor  Copyright: Solmetra (c)2003 All rights reserved. | www.solmetra.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once(DIR_FS_INC . 'vam_format_filesize.inc.php');
  require_once(DIR_FS_INC . 'vam_filesize.inc.php');
  require_once(DIR_FS_INC . 'vam_wysiwyg_tiny.inc.php');
  
  
  $languages = vam_get_languages();

 
 if ($_GET['special']=='delete') {
 
 vam_db_query("DELETE FROM ".TABLE_CONTENT_MANAGER." where content_id='".(int)$_GET['coID']."'");
 vam_redirect(vam_href_link(FILENAME_CONTENT_MANAGER));
} // if get special

 if ($_GET['special']=='delete_product') {
 
 vam_db_query("DELETE FROM ".TABLE_PRODUCTS_CONTENT." where content_id='".(int)$_GET['coID']."'");
 vam_redirect(vam_href_link(FILENAME_CONTENT_MANAGER,'pID='.(int)$_GET['pID']));
} // if get special

 if ($_GET['id']=='update' or $_GET['id']=='insert') {
        
         // set allowed c.groups
        $group_ids='';
        if(isset($_POST['groups'])) foreach($_POST['groups'] as $b){
        $group_ids .= 'c_'.$b."_group ,";
        }
        $customers_statuses_array=vam_get_customers_statuses();
        if (strpos($group_ids,'c_all_group')) {
        $group_ids='c_all_group,';
         for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++) {
            $group_ids .='c_'.$customers_statuses_array[$i]['id'].'_group,';
         }
        }
        
        $content_title=vam_db_prepare_input($_POST['cont_title']);
        $content_header=vam_db_prepare_input($_POST['cont_heading']);
        $content_url=vam_db_prepare_input($_POST['cont_url']);
        // Content URL begin

      $content_page_url = vam_db_prepare_input($_POST['cont_page_url']);
      // Content URL begin

               if ($content_page_url == '' && file_exists(DIR_FS_CATALOG . '.htaccess') && AUTOMATIC_SEO_URL == 'true') {
                   $alias = $content_title;
                  $alias = make_alias($alias);
                        $content_page_url = $alias;
               } else {
                        $content_page_url = vam_db_prepare_input($_POST['cont_page_url']);
               }
               
        // Content URL end
        $content_text=vam_db_prepare_input($_POST['cont']);
        $coID=vam_db_prepare_input($_POST['coID']);
        $upload_file=vam_db_prepare_input($_POST['file_upload']);
        $content_status=vam_db_prepare_input($_POST['status']);
        $content_language=vam_db_prepare_input($_POST['language']);
        $select_file=vam_db_prepare_input($_POST['select_file']);
        $file_flag=vam_db_prepare_input($_POST['file_flag']);
        $parent_check=vam_db_prepare_input($_POST['parent_check']);
        $parent_id=vam_db_prepare_input($_POST['parent']);
        $group_id=vam_db_prepare_input($_POST['content_group']);
        $group_ids = $group_ids;
        $sort_order=vam_db_prepare_input($_POST['sort_order']);
        $content_meta_title = vam_db_prepare_input($_POST['cont_meta_title']);
        $content_meta_description = vam_db_prepare_input($_POST['cont_meta_description']);
        $content_meta_keywords = vam_db_prepare_input($_POST['cont_meta_keywords']);
        
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                if ($languages[$i]['code']==$content_language) $content_language=$languages[$i]['id'];
        } // for
        
        $error=false; // reset error flag
        if (strlen($content_title) < 1) {
          $error = true;
          $messageStack->add(ERROR_TITLE,'error');
        }  // if

        if ($content_status=='yes'){
        $content_status=1;
        } else{
        $content_status=0;
        }  // if

        if ($parent_check=='yes'){
        $parent_id=$parent_id;
        } else{
        $parent_id='0';
        }  // if
        


      if ($error == false) {
        // file upload
      if ($select_file!='default') $content_file_name=$select_file;
      
      if ($content_file = &vam_try_upload('file_upload', DIR_FS_CATALOG.'media/content/')) {
        $content_file_name=$content_file->filename;
      }  // if
     

        // update data in table 
        
          $sql_data_array = array(
                                'languages_id' => $content_language,
                                'content_title' => $content_title,
                                'content_heading' => $content_header,
                                // Content URL begin
                                'content_page_url' => $content_page_url,
                                // Content URL end
                                'content_url' => $content_url,
                                'content_text' => $content_text,
                                'content_file' => $content_file_name,
                                'content_status' => $content_status,
                                'parent_id' => $parent_id,
                                'group_ids' => $group_ids,
                                'content_group' => $group_id,
                                'sort_order' => $sort_order,
                                'file_flag' => $file_flag,
         						     'content_meta_title' => $content_meta_title,
                                'content_meta_description' => $content_meta_description,
                                'content_meta_keywords' => $content_meta_keywords);
         if ($_GET['id']=='update') {
         vam_db_perform(TABLE_CONTENT_MANAGER, $sql_data_array, 'update', "content_id = '" . $coID . "'");
        } else {
         vam_db_perform(TABLE_CONTENT_MANAGER, $sql_data_array);
        } // if get id
        vam_redirect(vam_href_link(FILENAME_CONTENT_MANAGER));
        } // if error
        } // if 
 
 if ($_GET['id']=='update_product' or $_GET['id']=='insert_product') {
        
          // set allowed c.groups
        $group_ids='';
        if(isset($_POST['groups'])) foreach($_POST['groups'] as $b){
        $group_ids .= 'c_'.$b."_group ,";
        }
        $customers_statuses_array=vam_get_customers_statuses();
        if (strpos($group_ids,'c_all_group')) {
        $group_ids='c_all_group,';
         for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++) {
            $group_ids .='c_'.$customers_statuses_array[$i]['id'].'_group,';
         }
        }
        
        $content_title=vam_db_prepare_input($_POST['cont_title']);
        $content_link=vam_db_prepare_input($_POST['cont_link']);
        $content_language=vam_db_prepare_input($_POST['language']);
        $product=vam_db_prepare_input($_POST['product']);
        $upload_file=vam_db_prepare_input($_POST['file_upload']);
        $filename=vam_db_prepare_input($_POST['file_name']);
        $coID=vam_db_prepare_input($_POST['coID']);
        $file_comment=vam_db_prepare_input($_POST['file_comment']);
        $select_file=vam_db_prepare_input($_POST['select_file']);
        $group_ids = $group_ids;
        
        $error=false; // reset error flag
        
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                if ($languages[$i]['code']==$content_language) $content_language=$languages[$i]['id'];
        } // for
        
        if (strlen($content_title) < 1) {
          $error = true;
          $messageStack->add(ERROR_TITLE,'error');
        }  // if
        
        
        if ($error == false) {
        	
/* mkdir() wont work with php in safe_mode
        if  (!is_dir(DIR_FS_CATALOG.'media/products/'.$product.'/')) {
        
        $old_umask = umask(0);
	vam_mkdirs(DIR_FS_CATALOG.'media/products/'.$product.'/',0777);
        umask($old_umask);

        }
*/        
if ($select_file=='default') {
        
        if ($content_file = &vam_try_upload('file_upload', DIR_FS_CATALOG.'media/products/')) {
        $content_file_name=$content_file->filename;
        $old_filename=$content_file->filename;
        $timestamp=str_replace('.','',microtime());
        $timestamp=str_replace(' ','',$timestamp);
        $content_file_name=$timestamp.strstr($content_file_name,'.');
        $rename_string=DIR_FS_CATALOG.'media/products/'.$content_file_name;
        rename(DIR_FS_CATALOG.'media/products/'.$old_filename,$rename_string);
        copy($rename_string,DIR_FS_CATALOG.'media/products/backup/'.$content_file_name);
        } 
        if ($content_file_name=='') $content_file_name=$filename;
 } else {
  $content_file_name=$select_file;
}     
         // if
                
           // update data in table

        // set allowed c.groups
        $group_ids='';
        if(isset($_POST['groups'])) foreach($_POST['groups'] as $b){
        $group_ids .= 'c_'.$b."_group ,";
        }
        $customers_statuses_array=vam_get_customers_statuses();
        if (strpos($group_ids,'c_all_group')) {
        $group_ids='c_all_group,';
         for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++) {
            $group_ids .='c_'.$customers_statuses_array[$i]['id'].'_group,';
         }
        }
        
          $sql_data_array = array(
                                'products_id' => $product,
                                'group_ids' => $group_ids, 
                                'content_name' => $content_title,
                                'content_file' => $content_file_name,
                                'content_link' => $content_link,
                                'file_comment' => $file_comment,
                                'languages_id' => $content_language);
        
         if ($_GET['id']=='update_product') {
         vam_db_perform(TABLE_PRODUCTS_CONTENT, $sql_data_array, 'update', "content_id = '" . $coID . "'");
         $content_id = vam_db_insert_id();
        } else {
         vam_db_perform(TABLE_PRODUCTS_CONTENT, $sql_data_array);
         $content_id = vam_db_insert_id();        
        } // if get id
        
        // rename filename
        
        
        
        
        vam_redirect(vam_href_link(FILENAME_CONTENT_MANAGER,'pID='.$product));
        }// if error

        
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
<?php if (ENABLE_TABS == 'true') { ?>
		<script type="text/javascript">
			$(function(){
				$('#tabs').tabs({ fx: { opacity: 'toggle', duration: 'fast' } });
			});
		</script>
<?php } ?>
<?php 
 $query=vam_db_query("SELECT code FROM ". TABLE_LANGUAGES ." WHERE languages_id='".$_SESSION['languages_id']."'");
 $data=vam_db_fetch_array($query);
 if ($_GET['action']!='new_products_content' && $_GET['action']!='') echo vam_wysiwyg_tiny('content_manager',$data['code']);
 if ($_GET['action']=='new_products_content') echo vam_wysiwyg_tiny('products_content',$data['code']);
 if ($_GET['action']=='edit_products_content') echo vam_wysiwyg_tiny('products_content',$data['code']); 
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
    
<?php 
$manual_link = 'add-infopage';
if ($_GET['action'] == 'edit') {
$manual_link = 'edit-infopage';
}  
?>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php if ($_GET['action'] != 'new') { ?><?php if ($_GET['action'] != 'edit') { ?><a class="button" href="<?php echo vam_href_link(FILENAME_CONTENT_MANAGER,'action=new'); ?>"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_NEW_CONTENT;  ?></span></a><?php } } ?>&nbsp;<a class="button" href="<?php echo MANUAL_LINK_INFOPAGES.'#'.$manual_link; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>
    
<?php
if (!$_GET['action']) {
?>
<div class="main"><?php echo CONTENT_NOTE; ?></div>
 <?php
 vam_spaceUsed(DIR_FS_CATALOG.'media/content/');
echo '<div class="main">'.USED_SPACE.vam_format_filesize($total).'</div>';
?>

<div id="tabs">

			<ul>
<?php
    for ($i=0; $i<sizeof($languages); $i++) {
?>
				<li><a href="#tab<?php echo $i; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/'.$languages[$i]['code'].'.png', '', '16', '16'); ?>&nbsp;<?php echo $languages[$i]['name']; ?></a></li>
<?php 
}
?>
			</ul>

<?php
// Display Content
for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $content=array();


         $content_query=vam_db_query("SELECT
                                        content_id,
                                        categories_id,
                                        parent_id,
                                        group_ids,
                                        languages_id,
                                        content_title,
                                        content_heading,
                                        content_url,
                                        content_text,
                                        sort_order,
                                        file_flag,
                                        content_file,
                                        content_status,
                                        content_group,
                                        content_delete,
             							       content_meta_title,
                                        content_meta_description,
                                        content_meta_keywords
                                        FROM ".TABLE_CONTENT_MANAGER."
                                        WHERE languages_id='".$languages[$i]['id']."'
                                        order by sort_order 
                                        ");
        while ($content_data=vam_db_fetch_array($content_query)) {
        
         $content[]=array(
                        'CONTENT_ID' =>$content_data['content_id'] ,
                        'PARENT_ID' => $content_data['parent_id'],
                        'GROUP_IDS' => $content_data['group_ids'],
                        'LANGUAGES_ID' => $content_data['languages_id'],
                        'CONTENT_TITLE' => $content_data['content_title'],
                        'CONTENT_HEADING' => $content_data['content_heading'],
                        'CONTENT_URL' => $content_data['content_url'],
                        'CONTENT_TEXT' => $content_data['content_text'],
                        'SORT_ORDER' => $content_data['sort_order'],
                        'FILE_FLAG' => $content_data['file_flag'],
                        'CONTENT_FILE' => $content_data['content_file'],
                        'CONTENT_DELETE' => $content_data['content_delete'],
                        'CONTENT_GROUP' => $content_data['content_group'],
                        'CONTENT_STATUS' => $content_data['content_status'],
                        'CONTENT_META_TITLE' => $content_data['content_meta_title'],
                        'CONTENT_META_DESCRIPTION' => $content_data['content_meta_description'],
                        'CONTENT_META_KEYWORDS' => $content_data['content_meta_keywords']);
                                
        } // while content_data
        
        
?>
        <div id="tab<?php echo $i; ?>">

<table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" width="10" ><?php echo TABLE_HEADING_CONTENT_ID; ?></td>
                <td class="dataTableHeadingContent" width="10" >&nbsp;</td>
                <td class="dataTableHeadingContent" width="30%" align="left"><?php echo TABLE_HEADING_CONTENT_TITLE; ?></td>
                <td class="dataTableHeadingContent" width="1%" align="middle"><?php echo TABLE_HEADING_CONTENT_GROUP; ?></td>
                <td class="dataTableHeadingContent" width="1%" align="middle"><?php echo TABLE_HEADING_CONTENT_SORT; ?></td>
                <td class="dataTableHeadingContent" width="25%"align="left"><?php echo TABLE_HEADING_CONTENT_FILE; ?></td>
                <td class="dataTableHeadingContent" nowrap width="5%" align="left"><?php echo TABLE_HEADING_CONTENT_STATUS; ?></td>
                <td class="dataTableHeadingContent" nowrap width="" align="middle"><?php echo TABLE_HEADING_CONTENT_BOX; ?></td>
                <td class="dataTableHeadingContent" width="30%" align="middle"><?php echo TABLE_HEADING_CONTENT_ACTION; ?>&nbsp;</td>
              </tr>
 <?php
for ($ii = 0, $nn = sizeof($content); $ii < $nn; $ii++) {
 $file_flag_sql = vam_db_query("SELECT file_flag_name FROM " . TABLE_CM_FILE_FLAGS . " WHERE file_flag=" . $content[$ii]['FILE_FLAG']);
 $file_flag_result = vam_db_fetch_array($file_flag_sql);
 echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";
 if ($content[$ii]['CONTENT_FILE']=='') $content[$ii]['CONTENT_FILE']='database';
 ?>
 <td class="dataTableContent" align="left"><?php echo $content[$ii]['CONTENT_ID']; ?></td>
 <td bgcolor="<?php echo substr((6543216554/$content[$ii]['CONTENT_GROUP']),0,6); ?>" class="dataTableContent" align="left">&nbsp;</td>
 <td class="dataTableContent" align="left"><?php echo $content[$ii]['CONTENT_TITLE']; ?>
 <?php
 if ($content[$ii]['CONTENT_DELETE']=='0'){
 echo '<font color="ff0000">*</font>';
} ?>
 </td>
 <td class="dataTableContent" align="middle"><?php echo $content[$ii]['CONTENT_GROUP']; ?></td>
 <td class="dataTableContent" align="middle"><?php echo $content[$ii]['SORT_ORDER']; ?>&nbsp;</td>
 <td class="dataTableContent" align="left"><?php echo $content[$ii]['CONTENT_FILE']; ?></td>
 <td class="dataTableContent" align="middle"><?php if ($content[$ii]['CONTENT_STATUS']==0) { echo TEXT_NO; } else { echo TEXT_YES; } ?></td>
 <td class="dataTableContent" align="middle"><?php echo $file_flag_result['file_flag_name']; ?></td>
 <td class="dataTableContent" align="right">
 <a href="">
<?php
 if ($content[$ii]['CONTENT_DELETE']=='1'){
?>
 <a href="<?php echo vam_href_link(FILENAME_CONTENT_MANAGER,'special=delete&coID='.$content[$ii]['CONTENT_ID']); ?>" onClick="return confirm('<?php echo CONFIRM_DELETE; ?>')">
 <?php echo vam_image(DIR_WS_ICONS.'delete.gif','','','','style="cursor:pointer" onClick="return confirm(\''.DELETE_ENTRY.'\')"').'  '.TEXT_DELETE.'</a>&nbsp;&nbsp;';
} // if content
?>
 <a href="<?php echo vam_href_link(FILENAME_CONTENT_MANAGER,'action=edit&coID='.$content[$ii]['CONTENT_ID']); ?>">
<?php echo vam_image(DIR_WS_ICONS.'icon_edit.gif','','','','style="cursor:pointer"').'  '.TEXT_EDIT.'</a>'; ?>
 <a style="cursor:pointer" onClick="javascript:window.open('<?php echo vam_href_link(FILENAME_CONTENT_PREVIEW,'coID='.$content[$ii]['CONTENT_ID']); ?>', 'popup', 'toolbar=0, width=640, height=600')"><?php echo vam_image(DIR_WS_ICONS.'preview.gif','','','','style="cursor:pointer"').'&nbsp;&nbsp;'.TEXT_PREVIEW.'</a>'; ?>
 </td>
 </tr>
 
 <?php
 $content_1=array();
         $content_1_query=vam_db_query("SELECT
                                        content_id,
                                        categories_id,
                                        parent_id,
                                        group_ids,
                                        languages_id,
                                        content_title,
                                        content_heading,
                                        content_url,
                                        content_text,
                                        file_flag,
                                        content_file,
                                        content_status,
                                        content_delete,
             							       content_meta_title,
                                        content_meta_description,
                                        content_meta_keywords
                                        FROM ".TABLE_CONTENT_MANAGER."
                                        WHERE languages_id='".$i."'
                                        AND parent_id='".$content[$ii]['CONTENT_ID']."'
                                        order by sort_order
                                         ");
        while ($content_1_data=vam_db_fetch_array($content_1_query)) {
        
         $content_1[]=array(
                        'CONTENT_ID' =>$content_1_data['content_id'] ,
                        'PARENT_ID' => $content_1_data['parent_id'],
                        'GROUP_IDS' => $content_1_data['group_ids'],
                        'LANGUAGES_ID' => $content_1_data['languages_id'],
                        'CONTENT_TITLE' => $content_1_data['content_title'],
                        'CONTENT_HEADING' => $content_1_data['content_heading'],
                        'CONTENT_URL' => $content_1_data['content_url'],
                        'CONTENT_TEXT' => $content_1_data['content_text'],
                        'SORT_ORDER' => $content_1_data['sort_order'],
                        'FILE_FLAG' => $content_1_data['file_flag'],
                        'CONTENT_FILE' => $content_1_data['content_file'],
                        'CONTENT_DELETE' => $content_1_data['content_delete'],
                        'CONTENT_STATUS' => $content_data['content_status'],
                        'CONTENT_META_TITLE' => $content_data['content_meta_title'],
                        'CONTENT_META_DESCRIPTION' => $content_data['content_meta_description'],
                        'CONTENT_META_KEYWORDS' => $content_data['content_meta_keywords']);
 }      
for ($a = 0, $x = sizeof($content_1); $a < $x; $a++) {
if ($content_1[$a]!='') {
 $file_flag_sql = vam_db_query("SELECT file_flag_name FROM " . TABLE_CM_FILE_FLAGS . " WHERE file_flag=" . $content_1[$a]['FILE_FLAG']);
 $file_flag_result = vam_db_fetch_array($file_flag_sql);
 echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";
 
 if ($content_1[$a]['CONTENT_FILE']=='') $content_1[$a]['CONTENT_FILE']='database';
 ?>
 <td class="dataTableContent" align="left"><?php echo $content_1[$a]['CONTENT_ID']; ?></td>
 <td class="dataTableContent" align="left">--<?php echo $content_1[$a]['CONTENT_TITLE']; ?></td>
 <td class="dataTableContent" align="left"><?php echo $content_1[$a]['CONTENT_FILE']; ?></td>
 <td class="dataTableContent" align="middle"><?php if ($content_1[$a]['CONTENT_STATUS']==0) { echo TEXT_NO; } else { echo TEXT_YES; } ?></td>
 <td class="dataTableContent" align="middle"><?php echo $file_flag_result['file_flag_name']; ?></td>
 <td class="dataTableContent" align="right">
 <a href="">
<?php
 if ($content_1[$a]['CONTENT_DELETE']=='1'){
?>
 <a href="<?php echo vam_href_link(FILENAME_CONTENT_MANAGER,'special=delete&coID='.$content_1[$a]['CONTENT_ID']); ?>" onClick="return confirm('<?php echo CONFIRM_DELETE; ?>')">
 <?php echo vam_image(DIR_WS_ICONS.'delete.gif','','','','style="cursor:pointer" onClick="return confirm(\''.DELETE_ENTRY.'\')"').'  '.TEXT_DELETE.'</a>&nbsp;&nbsp;';
} // if content
?>
 <a href="<?php echo vam_href_link(FILENAME_CONTENT_MANAGER,'action=edit&coID='.$content_1[$a]['CONTENT_ID']); ?>">
<?php echo vam_image(DIR_WS_ICONS.'icon_edit.gif','','','','style="cursor:pointer"').'  '.TEXT_EDIT.'</a>'; ?>
 <a style="cursor:pointer" onClick="javascript:window.open('<?php echo vam_href_link(FILENAME_CONTENT_PREVIEW,'coID='.$content_1[$a]['CONTENT_ID']); ?>', 'popup', 'toolbar=0, width=640, height=600')"
 
 
 ><?php echo vam_image(DIR_WS_ICONS.'preview.gif','','','','style="cursor:pointer"').'&nbsp;&nbsp;'.TEXT_PREVIEW.'</a>'; ?>
 </td>
 </tr> 
 
 
<?php
}
} // for content
} // for language
?>
</table>
</div>

<?php
}
?>
</div>
<?php
} else {

switch ($_GET['action']) {
// Diplay Editmask
 case 'new':    
 case 'edit':
 if ($_GET['action']!='new') {
        // Content URL begin
        $content_query=vam_db_query("SELECT
                                        content_id,
                                        categories_id,
                                        parent_id,
                                        group_ids,
                                        languages_id,
                                        content_title,
                                        content_heading,
                                        content_url,
                                        content_page_url,
                                        content_text,
                                        sort_order,
                                        file_flag,
                                        content_file,
                                        content_status,
                                        content_group,
                                        content_delete,
                                        content_meta_title,
                                        content_meta_description,
                                        content_meta_keywords
                                        FROM ".TABLE_CONTENT_MANAGER."
                                        WHERE content_id='".(int)$_GET['coID']."'");

        // Content URL end
        $content=vam_db_fetch_array($content_query);
}
        $languages_array = array();


        
  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                        
  if ($languages[$i]['id']==$content['languages_id']) {
         $languages_selected=$languages[$i]['code'];
         $languages_id=$languages[$i]['id'];
        }               
    $languages_array[] = array('id' => $languages[$i]['code'],
               'text' => $languages[$i]['name']);

  } // for
  if ($languages_id!='') $query_string='languages_id='.$languages_id.' AND';
    $categories_query=vam_db_query("SELECT
                                        content_id,
                                        content_title
                                        FROM ".TABLE_CONTENT_MANAGER."
                                        WHERE ".$query_string." content_id!='".(int)$_GET['coID']."'");
  while ($categories_data=vam_db_fetch_array($categories_query)) {
  
  $categories_array[]=array(
                        'id'=>$categories_data['content_id'],
                        'text'=>$categories_data['content_title']);
 }   
?>
<br /><br />
<?php
 if ($_GET['action']!='new') {
echo vam_draw_form('edit_content',FILENAME_CONTENT_MANAGER,'action=edit&id=update&coID='.$_GET['coID'],'post','enctype="multipart/form-data"').vam_draw_hidden_field('coID',$_GET['coID']);
} else {
echo vam_draw_form('edit_content',FILENAME_CONTENT_MANAGER,'action=edit&id=insert','post','enctype="multipart/form-data"').vam_draw_hidden_field('coID',$_GET['coID']);
} ?>
<table class="main" width="100%" border="0">
   <tr> 
      <td width="10%"><?php echo TEXT_LANGUAGE; ?></td>
      <td width="90%"><?php echo vam_draw_pull_down_menu('language',$languages_array,$languages_selected); ?></td>
   </tr>
<?php
if ($content['content_delete']!=0 or $_GET['action']=='new') {

           $next_id_query = vam_db_query("select max(content_id) as max_content_id from " . TABLE_CONTENT_MANAGER . "");
            $next_id = vam_db_fetch_array($next_id_query);
            $next_id = $next_id['max_content_id'] + 1;
?>   
      <tr> 
      <td width="10%"><?php echo TEXT_GROUP; ?></td>
      <td width="90%"><?php echo vam_draw_input_field('content_group',(isset($content['content_group']) ? $content['content_group'] : $next_id),'size="5"'); ?><?php echo TEXT_GROUP_DESC; ?></td>
   </tr>
<?php
} else {
echo vam_draw_hidden_field('content_group',$content['content_group']);
?>
      <tr>
      <td width="10%"><?php echo TEXT_GROUP; ?></td>
      <td width="90%"><?php echo $content['content_group']; ?></td>
   </tr>
<?php
}
$file_flag_sql = vam_db_query("SELECT file_flag as id, file_flag_name as text FROM " . TABLE_CM_FILE_FLAGS);
while($file_flag = vam_db_fetch_array($file_flag_sql)) {
	$file_flag_array[] = array('id' => $file_flag['id'], 'text' => $file_flag['text']);
}
?>	
      <tr> 
      <td width="10%"><?php echo TEXT_FILE_FLAG; ?></td>
      <td width="90%"><?php echo vam_draw_pull_down_menu('file_flag',$file_flag_array,$content['file_flag']); ?></td>
   </tr>

      <tr>
      <td width="10%"><?php echo TEXT_PARENT; ?></td>
      <td width="90%"><?php echo vam_draw_pull_down_menu('parent',$categories_array,$content['parent_id']); ?><?php echo vam_draw_checkbox_field('parent_check', 'yes',false).' '.TEXT_PARENT_DESCRIPTION; ?></td>
   </tr>

    <tr>
      <td width="10%"><?php echo TEXT_SORT_ORDER; ?></td>
      <td width="90%"><?php echo vam_draw_input_field('sort_order',$content['sort_order'],'size="5"'); ?></td>
    </tr>

      <tr> 
      <td valign="top" width="10%"><?php echo TEXT_STATUS; ?></td>
      <td width="90%"><?php
      if ($content['content_status']=='1') {
      echo vam_draw_checkbox_field('status', 'yes',true).' '.TEXT_STATUS_DESCRIPTION;
      } else {
      echo vam_draw_checkbox_field('status', 'yes',false).' '.TEXT_STATUS_DESCRIPTION;
      }

      ?><br /><br /></td>
   </tr>

          <?php
if (GROUP_CHECK=='true') {
$customers_statuses_array = vam_get_customers_statuses();
$customers_statuses_array=array_merge(array(array('id'=>'all','text'=>TXT_ALL)),$customers_statuses_array);
?>
<tr>
<td style="border-top: 1px solid; border-color: #ff0000;" valign="top" class="main" ><?php echo ENTRY_CUSTOMERS_STATUS; ?></td>
<td style="border-top: 1px solid; border-left: 1px solid; border-color: #ff0000;" style="border-top: 1px solid; border-right: 1px solid; border-color: #ff0000;" style="border-top: 1px solid; border-bottom: 1px solid; border-color: #ff0000;" bgcolor="#FFCC33" class="main">
<?php

for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++) {
if (strstr($content['group_ids'],'c_'.$customers_statuses_array[$i]['id'].'_group')) {

$checked='checked ';
} else {
$checked='';
}
$check_all = '';
if ($customers_statuses_array[$i]['id'] == 'all') $check_all = 'onClick="javascript:CheckAllContent(this.checked);"';
echo '<input type="checkbox" '.$check_all.' name="groups[]" value="'.$customers_statuses_array[$i]['id'].'"'.$checked.'> '.$customers_statuses_array[$i]['text'].'<br />';
}
?>
</td>
</tr>
<?php
}
?>


   <tr>
      <td width="10%"><?php echo TEXT_TITLE; ?></td>
      <td width="90%"><?php echo vam_draw_input_field('cont_title',$content['content_title'],'size="60"'); ?></td>
   </tr>
<!--// Content URL begin //-->
   <tr>
      <td width="10%"><?php echo TEXT_PAGE_URL; ?></td>
      <td width="90%"><?php echo vam_draw_input_field('cont_page_url',$content['content_page_url'],'size="60"'); ?></td>
   </tr>
<!--// Content URL end //-->


   <tr> 
      <td width="10%"><?php echo TEXT_HEADING; ?></td>
      <td width="90%"><?php echo vam_draw_input_field('cont_heading',$content['content_heading'],'size="60"'); ?></td>
   </tr>

   <tr>
   	   <td width="10%"><?php echo TEXT_META_TITLE; ?></td>
      <td width="90%"><?php echo vam_draw_input_field('cont_meta_title',$content['content_meta_title'],'size="60"'); ?></td>
   </tr>

   <tr> 
      <td width="10%"><?php echo TEXT_META_DESCRIPTION; ?></td>
      <td width="90%"><?php echo vam_draw_input_field('cont_meta_description',$content['content_meta_description'],'size="60"'); ?></td>
   </tr>

   <tr> 
      <td width="10%"><?php echo TEXT_META_KEYWORDS; ?></td>
      <td width="90%"><?php echo vam_draw_input_field('cont_meta_keywords',$content['content_meta_keywords'],'size="60"'); ?></td>
   </tr>

   <tr> 
      <td width="10%" valign="top"><?php echo TEXT_UPLOAD_FILE; ?></td>
      <td width="90%"><?php echo vam_draw_file_field('file_upload').' '.TEXT_UPLOAD_FILE_LOCAL; ?></td>
   </tr> 
         <tr> 
      <td width="10%" valign="top"><?php echo TEXT_CHOOSE_FILE; ?></td>
      <td width="90%">
<?php
    //subfolders in media added  (Modified by Andreaz)
    require_once(DIR_WS_FUNCTIONS.'file_system.php');
    $files = vam_get_filelist(DIR_FS_CATALOG.'media/content/','', array('index.html'));
    //subfolders in media added  (Modified by Andreaz)

 // set default value in dropdown!
if ($content['content_file']=='') {
    $default_array[]=array('id' => 'default','text' => TEXT_SELECT);
    $default_value='default';
    if (count($files) == 0)
    {
    $files = $default_array;
    }
    else
    {
    $files=vam_array_merge($default_array,$files);
    }
} else {
$default_array[]=array('id' => 'default','text' => TEXT_NO_FILE);
$default_value=$content['content_file'];
    if (count($files) == 0)
    {
    $files = $default_array;
    }
    else
    {
    $files=array_merge($default_array,$files);
    }
}
echo '<br />'.TEXT_CHOOSE_FILE_SERVER.'</br>';
echo vam_draw_pull_down_menu('select_file',$files,$default_value);
      if ($content['content_file']!='') {
        echo TEXT_CURRENT_FILE.' <b>'.$content['content_file'].'</b><br />';
        }



?>
      </td>
      </td>
   </tr> 
   <tr> 
      <td width="10%" valign="top"></td>
      <td colspan="90%" valign="top"><br /><?php echo TEXT_FILE_DESCRIPTION; ?></td>
   </tr> 
   <tr> 
      <td width="10%" valign="top"><?php echo TEXT_CONTENT; ?></td>
      
      <td width="90%">
   <?php
echo vam_draw_textarea_field('cont','','100%','35',$content['content_text']);
?><br /><a href="javascript:toggleHTMLEditor('cont');"><?php echo TEXT_TOGGLE_EDITOR; ?></a>
      </td>
   </tr>
  
     <tr> 
      <td width="10%"><?php echo TEXT_URL; ?></td>
      <td width="90%"><?php echo vam_draw_input_field('cont_url',$content['content_url'],'size="60"'); ?></td>
   </tr>
 
    <tr>
        <td colspan="2" align="right" class="main"><?php echo '<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span>'; ?><a class="button" href="<?php echo vam_href_link(FILENAME_CONTENT_MANAGER); ?>"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_BACK; ?></span></a></td>
   </tr>
</table>
</form>
<?php
 break;
 
 case 'edit_products_content':
 case 'new_products_content':
 
  if ($_GET['action']=='edit_products_content') {
        $content_query=vam_db_query("SELECT
                                        content_id,
                                        products_id,
                                        group_ids,
                                        content_name,
                                        content_file,
                                        content_link,
                                        languages_id,
                                        file_comment,
                                        content_read

                                        FROM ".TABLE_PRODUCTS_CONTENT."
                                        WHERE content_id='".(int)$_GET['coID']."'");

        $content=vam_db_fetch_array($content_query);
}
 
 // get products names.
 $products_query=vam_db_query("SELECT
                                products_id,
                                products_name
                                FROM ".TABLE_PRODUCTS_DESCRIPTION."
                                WHERE language_id='".(int)$_SESSION['languages_id']."' order by products_name");

 while ($products_data=vam_db_fetch_array($products_query)) {
 
 $products_array[]=array(
                        'id' => $products_data['products_id'],  
                        'text' => $products_data['products_name']);
}

 // get languages
 $languages_array = array();


        
  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                        
  if ($languages[$i]['id']==$content['languages_id']) {
         $languages_selected=$languages[$i]['code'];
         $languages_id=$languages[$i]['id'];
        }               
    $languages_array[] = array('id' => $languages[$i]['code'],
               'text' => $languages[$i]['name']);

  } // for
 
  // get used content files
  $content_files_query=vam_db_query("SELECT DISTINCT
                                content_name,
                                content_file
                                FROM ".TABLE_PRODUCTS_CONTENT."
                                WHERE content_file!=''");
 $content_files=array();

 while ($content_files_data=vam_db_fetch_array($content_files_query)) {

     $content_files[]=array(
     'id' => $content_files_data['content_file'],
     'text' => $content_files_data['content_name']);
 }

 // add default value to array
 $default_array[]=array('id' => 'default','text' => TEXT_SELECT);
 $default_value='default';
 $content_files=array_merge($default_array,$content_files);
 // mask for product content
 
 if ($_GET['action']!='new_products_content') {
 ?>     
 <?php echo vam_draw_form('edit_content',FILENAME_CONTENT_MANAGER,'action=edit_products_content&id=update_product&coID='.$_GET['coID'],'post','enctype="multipart/form-data"').vam_draw_hidden_field('coID',$_GET['coID']); ?>
<?php
} else {
?>
<?php echo vam_draw_form('edit_content',FILENAME_CONTENT_MANAGER,'action=edit_products_content&id=insert_product','post','enctype="multipart/form-data"');   ?>
<?php
}
?>
 <div class="main"><?php echo TEXT_CONTENT_DESCRIPTION; ?></div>
 <table class="main" width="100%" border="0">
   <tr>
      <td width="10%"><?php echo TEXT_PRODUCT; ?></td>
      <td width="90%"><?php echo vam_draw_pull_down_menu('product',$products_array,$content['products_id']); ?></td>
   </tr>
      <tr> 
      <td width="10%"><?php echo TEXT_LANGUAGE; ?></td>
      <td width="90%"><?php echo vam_draw_pull_down_menu('language',$languages_array,$languages_selected); ?></td>
   </tr>

          <?php
if (GROUP_CHECK=='true') {
$customers_statuses_array = vam_get_customers_statuses();
$customers_statuses_array=array_merge(array(array('id'=>'all','text'=>TXT_ALL)),$customers_statuses_array);
?>
<tr>
<td style="border-top: 1px solid; border-color: #ff0000;" valign="top" class="main" ><?php echo ENTRY_CUSTOMERS_STATUS; ?></td>
<td style="border-top: 1px solid; border-left: 1px solid; border-color: #ff0000;" style="border-top: 1px solid; border-right: 1px solid; border-color: #ff0000;" style="border-top: 1px solid; border-bottom: 1px solid; border-color: #ff0000;" bgcolor="#FFCC33" class="main">
<?php

for ($i=0;$n=sizeof($customers_statuses_array),$i<$n;$i++) {
if (strstr($content['group_ids'],'c_'.$customers_statuses_array[$i]['id'].'_group')) {

$checked='checked ';
} else {
$checked='';
}
$check_all = '';
if ($customers_statuses_array[$i]['id'] == 'all') $check_all = 'onClick="javascript:CheckAllContent(this.checked);"';
echo '<input type="checkbox" '.$check_all.' name="groups[]" value="'.$customers_statuses_array[$i]['id'].'"'.$checked.'> '.$customers_statuses_array[$i]['text'].'<br />';
}
?>
</td>
</tr>
<?php
}
?>

      <tr>
      <td width="10%"><?php echo TEXT_TITLE_FILE; ?></td>
      <td width="90%"><?php echo vam_draw_input_field('cont_title',$content['content_name'],'size="60"'); ?></td>
   </tr>
      <tr> 
      <td width="10%"><?php echo TEXT_LINK; ?></td>
      <td width="90%"><?php  echo vam_draw_input_field('cont_link',$content['content_link'],'size="60"'); ?></td>
   </tr>

      <tr>
      <td width="10%" valign="top"><?php echo TEXT_FILE_DESC; ?></td>
      <td width="90%"><?php
          echo vam_draw_textarea_field('file_comment','','100','30',$content['file_comment']);
        ?><br /><a href="javascript:toggleHTMLEditor('file_comment');"><?php echo TEXT_TOGGLE_EDITOR; ?></a></td>
   </tr>
         <tr> 
      <td width="10%" valign="top"><?php echo TEXT_CHOOSE_FILE; ?></td>
      <td width="90%">
<?php
    //subfolders in media added  (Modified by Andreaz)
    require_once(DIR_WS_FUNCTIONS.'file_system.php');
    $files = vam_get_filelist(DIR_FS_CATALOG.'media/products/','', array('index.html'));
    //subfolders in media added  (Modified by Andreaz)

    // set default value in dropdown!
    unset ($default_array);
    if ($content['content_file']=='') {
         $default_array[]=array('id' => 'default','text' => TEXT_SELECT);
         $default_value='default';
    } else {
         $default_array[]=array('id' => 'default','text' => TEXT_NO_FILE);
         $default_value=$content['content_file'];
    }
    $files=vam_array_merge($default_array, $files);
 
    echo '<br />'.TEXT_CHOOSE_FILE_SERVER_PRODUCTS.'</br>';
    echo vam_draw_pull_down_menu('select_file',$files,$default_value);
    if ($content['content_file']!='') {
       echo TEXT_CURRENT_FILE.' <b>'.$content['content_file'].'</b><br />';
    }

?>
      </td>
      </td>
   </tr> 
      <tr> 
      <td width="10%" valign="top"><?php echo TEXT_UPLOAD_FILE; ?></td>
      <td width="90%"><?php echo vam_draw_file_field('file_upload').' '.TEXT_UPLOAD_FILE_LOCAL; ?></td>
   </tr> 
 <?php
 if ($content['content_file']!='') {
 ?>
    <tr> 
      <td width="10%"><?php echo TEXT_FILENAME; ?></td>
      <td width="90%" valign="top"><?php echo vam_draw_hidden_field('file_name',$content['content_file']).vam_image(DIR_WS_CATALOG.'admin/images/icons/icon_'.str_replace('.','',strstr($content['content_file'],'.')).'.gif').$content['content_file']; ?></td>
    </tr>
  <?php
}
?>
       <tr>
        <td colspan="2" align="right" class="main"><?php echo '<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span>'; ?><a class="button" href="<?php echo vam_href_link(FILENAME_CONTENT_MANAGER); ?>"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_BACK; ?></span></a></td>
   </tr>
   </form>
   </table>
 
 <?php
 
 break;
 

}
}

if (!$_GET['action']) {
?>
<br />
<a class="button" href="<?php echo vam_href_link(FILENAME_CONTENT_MANAGER,'action=new'); ?>"><span><?php echo  vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_NEW_CONTENT; ?></span></a>
<?php
}
?>
</td>
          </tr>                 
        </table>
 <?php
 if (!$_GET['action']) {
 // products content
 // load products_ids into array
 
 $products_id_query=vam_db_query("SELECT DISTINCT
                                pc.products_id,
                                pd.products_name
                                FROM ".TABLE_PRODUCTS_CONTENT." pc, ".TABLE_PRODUCTS_DESCRIPTION." pd
                                WHERE pd.products_id=pc.products_id and pd.language_id='".(int)$_SESSION['languages_id']."'");
 
 $products_ids=array();
 while ($products_id_data=vam_db_fetch_array($products_id_query)) {
        
        $products_ids[]=array(
                        'id'=>$products_id_data['products_id'],
                        'name'=>$products_id_data['products_name']);
        
        } // while
        
        
 ?>
 <div class="pageHeading"><br /><?php echo HEADING_PRODUCTS_CONTENT; ?><br /></div>
  <?php
 vam_spaceUsed(DIR_FS_CATALOG.'media/products/');
echo '<div class="main">'.USED_SPACE.vam_format_filesize($total).'</div></br>';
?>      
<table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
    <tr class="dataTableHeadingRow">
     <td class="dataTableHeadingContent" nowrap width="5%" ><?php echo TABLE_HEADING_PRODUCTS_ID; ?></td>
     <td class="dataTableHeadingContent" width="95%" align="left"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
</tr>
<?php

for ($i=0,$n=sizeof($products_ids); $i<$n; $i++) {
 echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";
 
 ?>
 <td class="dataTableContent_products" align="left"><?php echo $products_ids[$i]['id']; ?></td>
 <td class="dataTableContent_products" align="left"><b><?php echo vam_image(DIR_WS_CATALOG.'images/icons/arrow.gif'); ?><a href="<?php echo vam_href_link(FILENAME_CONTENT_MANAGER,'pID='.$products_ids[$i]['id']);?>"><?php echo $products_ids[$i]['name']; ?></a></b></td>
 </tr>
<?php
if ($_GET['pID']) {
// display content elements
        $content_query=vam_db_query("SELECT
                                        content_id,
                                        content_name,
                                        content_file,
                                        content_link,
                                        languages_id,
                                        file_comment,
                                        content_read
                                        FROM ".TABLE_PRODUCTS_CONTENT."
                                        WHERE products_id='".$_GET['pID']."' order by content_name");
        $content_array='';
        while ($content_data=vam_db_fetch_array($content_query)) {
                
                $content_array[]=array(
                                        'id'=> $content_data['content_id'],
                                        'name'=> $content_data['content_name'],
                                        'file'=> $content_data['content_file'],
                                        'link'=> $content_data['content_link'],
                                        'comment'=> $content_data['file_comment'],
                                        'languages_id'=> $content_data['languages_id'],
                                        'read'=> $content_data['content_read']);
                                        
                } // while content data

if ($_GET['pID']==$products_ids[$i]['id']){
?>

<tr>
 <td class="dataTableContent" align="left"></td>
 <td class="dataTableContent" align="left">

<table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
    <tr class="dataTableHeadingRow">
    <td class="dataTableHeadingContent" nowrap width="2%" ><?php echo TABLE_HEADING_PRODUCTS_CONTENT_ID; ?></td>
    <td class="dataTableHeadingContent" nowrap width="2%" >&nbsp;</td>
    <td class="dataTableHeadingContent" nowrap width="5%" ><?php echo TABLE_HEADING_LANGUAGE; ?></td>
    <td class="dataTableHeadingContent" nowrap width="15%" ><?php echo TABLE_HEADING_CONTENT_NAME; ?></td>
    <td class="dataTableHeadingContent" nowrap width="30%" ><?php echo TABLE_HEADING_CONTENT_FILE; ?></td>
    <td class="dataTableHeadingContent" nowrap width="1%" ><?php echo TABLE_HEADING_CONTENT_FILESIZE; ?></td>
    <td class="dataTableHeadingContent" nowrap align="middle" width="20%" ><?php echo TABLE_HEADING_CONTENT_LINK; ?></td>
    <td class="dataTableHeadingContent" nowrap width="5%" ><?php echo TABLE_HEADING_CONTENT_HITS; ?></td>
    <td class="dataTableHeadingContent" nowrap width="20%" ><?php echo TABLE_HEADING_CONTENT_ACTION; ?></td>
    </tr>  

<?php
 
 for ($ii=0,$nn=sizeof($content_array); $ii<$nn; $ii++) {

 echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";
 
 ?>
 <td class="dataTableContent" align="left"><?php echo  $content_array[$ii]['id']; ?> </td>
 <td class="dataTableContent" align="left"><?php
 
 
 
 if ($content_array[$ii]['file']!='') {
 
 echo vam_image(DIR_WS_CATALOG.'admin/images/icons/icon_'.str_replace('.','',strstr($content_array[$ii]['file'],'.')).'.gif');
} else {
echo vam_image(DIR_WS_CATALOG.'admin/images/icons/icon_link.gif');
}

for ($xx=0,$zz=sizeof($languages); $xx<$zz;$xx++){
	if ($languages[$xx]['id']==$content_array[$ii]['languages_id']) {
	$lang_dir=$languages[$xx]['directory'];	
	break;
	}	
}

?>
</td>
 <td class="dataTableContent" align="left"><?php echo vam_image(DIR_WS_CATALOG.'lang/'.$lang_dir.'/admin/images/icon.gif'); ?></td>
 <td class="dataTableContent" align="left"><?php echo $content_array[$ii]['name']; ?></td>
 <td class="dataTableContent" align="left"><?php echo $content_array[$ii]['file']; ?></td>
 <td class="dataTableContent" align="left"><?php echo vam_filesize($content_array[$ii]['file']); ?></td>
 <td class="dataTableContent" align="left" align="middle"><?php
 if ($content_array[$ii]['link']!='') {
 echo '<a href="'.$content_array[$ii]['link'].'" target="new">'.$content_array[$ii]['link'].'</a>';
} 
 ?>
  &nbsp;</td>
 <td class="dataTableContent" align="left"><?php echo $content_array[$ii]['read']; ?></td>
 <td class="dataTableContent" align="left">
 
  <a href="<?php echo vam_href_link(FILENAME_CONTENT_MANAGER,'special=delete_product&coID='.$content_array[$ii]['id']).'&pID='.$products_ids[$i]['id']; ?>" onClick="return confirm('<?php echo CONFIRM_DELETE; ?>')">
 <?php
 
 echo vam_image(DIR_WS_ICONS.'delete.gif','','','','style="cursor:pointer" onClick="return confirm(\''.DELETE_ENTRY.'\')"').'  '.TEXT_DELETE.'</a>&nbsp;&nbsp;';

?>
 <a href="<?php echo vam_href_link(FILENAME_CONTENT_MANAGER,'action=edit_products_content&coID='.$content_array[$ii]['id']); ?>">
<?php echo vam_image(DIR_WS_ICONS.'icon_edit.gif','','','','style="cursor:pointer"').'  '.TEXT_EDIT.'</a>'; ?>

<?php
// display preview button if filetype 
// .gif,.jpg,.png,.html,.htm,.txt,.tif,.bmp
if (	preg_match('/.gif/i',$content_array[$ii]['file'])
	or
	preg_match('/.jpg/i',$content_array[$ii]['file'])
	or
	preg_match('/.png/i',$content_array[$ii]['file'])
	or
	preg_match('/.html/i',$content_array[$ii]['file'])
	or
	preg_match('/.htm/i',$content_array[$ii]['file'])
	or
	preg_match('/.txti/',$content_array[$ii]['file'])
	or
	preg_match('/.bmp/i',$content_array[$ii]['file'])
	) {
?>
 <a style="cursor:pointer" onClick="javascript:window.open('<?php echo vam_href_link(FILENAME_CONTENT_PREVIEW,'pID=media&coID='.$content_array[$ii]['id']); ?>', 'popup', 'toolbar=0, width=640, height=600')"
 
 
 ><?php echo vam_image(DIR_WS_ICONS.'preview.gif','','','',' style="cursor:pointer"').'&nbsp;&nbsp;'.TEXT_PREVIEW.'</a>'; ?> 
<?php
}
?> 
 
 
 
 </td>
 </tr>

<?php 

} // for content_array
echo '</table></td></tr>';
}
} // for
}
?> 

       
 </table>
 <br />
 <a class="button" href="<?php echo vam_href_link(FILENAME_CONTENT_MANAGER,'action=new_products_content'); ?>"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_NEW_CONTENT; ?></span></a>                 
 <?php
} // if !$_GET['action']
?>       
        
        </td>
      </tr>
    </table></td>
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