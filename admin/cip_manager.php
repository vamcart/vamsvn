<?php
/* --------------------------------------------------------------
   $Id: cip_manager.php 1117 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce coding standards; www.oscommerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

if(defined('JOSCOM_VERSION')){
	require(DIR_FS_ADMIN_INCLUDES.'application_top.php');
}else{
	if(!defined('DB_PREFIX')) define('DB_PREFIX', '');
	require('includes/application_top.php');
    require('includes/configure_ci.php');
}

$current_path=DIR_FS_CIP;

if(!defined('TABLE_CIP')) {
    define('TABLE_CIP', (defined('DB_PREFIX') ? DB_PREFIX : '').'cip');
}


require_once(DIR_FS_ADMIN_CLASSES.'ci_cip.class.php');
require_once(DIR_FS_ADMIN_CLASSES.'ci_upload_cip.class.php');
require_once(DIR_FS_ADMIN_CLASSES.'ci_file_integrity.class.php');


// initialize the message stack for output messages
require_once(DIR_FS_ADMIN_CLASSES.'table_block.php');
require_once(DIR_FS_ADMIN_CLASSES.'ci_message.class.php');
$message=new message;
//Must be included after ci_message.class.php:
require_once(DIR_FS_ADMIN_CLASSES.'ci_cip_manager.class.php');
$cip_manager= new cip_manager($current_path);
require_once(DIR_FS_ADMIN_FUNCTIONS . 'contrib_installer.php');


//set_current_path:

//if (defined('DIR_FS_CIP'))     $current_path=DIR_FS_CIP;

//This must protect contrib_dir parameter
if (isset($_REQUEST['contrib_dir']) && $_REQUEST['action']=='install'
&& $_REQUEST['cip']==$cip_manager->ci_cip() && is_dir($_REQUEST['contrib_dir']) ){
  $current_path=$_REQUEST['contrib_dir'];
}

if (strstr($current_path, '..') or !is_dir($current_path) or (defined(DIR_FS_CIP) && !preg_match('/^/' . DIR_FS_CIP, $current_path))) {
    $current_path = DIR_FS_CIP;
}

if (!vam_session_is_registered('current_path'))   vam_session_register('current_path');
$current_path=str_replace ('//', '/', $current_path);


// Nessesary for self-install. We redirect from init_contrib_installer.php with this patameters:
if (!defined(DIR_FS_CIP) && $_REQUEST['contrib_dir'])     define ('DIR_FS_CIP', $_REQUEST['contrib_dir']);

//Check if ontrib Installer installed:
if (DIR_FS_CIP=='DIR_FS_CIP')     vam_redirect(vam_href_link(INIT_CONTRIB_INSTALLER));

//Check if self-install was made:
if ($_REQUEST['cip']!=$cip_manager->ci_cip() && $_REQUEST['contrib_dir'] && !$cip_manager->is_ci_installed()) {
  vam_redirect(vam_href_link(INIT_CONTRIB_INSTALLER));
}

$cip_manager->check_action($_REQUEST['action']);



//Content for list:
$contents = array();
$contents=$cip_manager->folder_contents();
if (is_array($contents)) {
  function vam_cmp($a, $b) {return strcmp( ($a['is_dir'] ? 'D' : 'F') . $a['name'], ($b['is_dir'] ? 'D' : 'F') . $b['name']);}
  usort($contents, 'vam_cmp');
}

  $cip_list=$cip_manager->draw_cip_list();


$info=$cip_manager->draw_info();
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
<link rel="stylesheet" type="text/css" href="includes/contrib_installer.css">
<script LANGUAGE="JavaScript">
<!--
function confirmSubmit()
{
var agree=confirm("<?php echo TEXT_DELETE_INTRO;?>");
if (agree)  return true ;
else  return false ;
}
// -->
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
    <td class="boxCenter" valign="top">
    
    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
    
    <?php echo $message->output(); ?>    
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
<?php
if ($_REQUEST['action']!='upload') {
?>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION;?>&nbsp;</td>
                <td class="dataTableHeadingContent" width="90%"><?php echo TABLE_HEADING_FILENAME; ?></td>
    <?php
    if ($cip_manager->current_path==DIR_FS_CIP && SHOW_SIZE_COLUMN=='true') {
        echo '<td class="dataTableHeadingContent" align="right">'. TABLE_HEADING_SIZE.', Kb</td>';
    }?>
                <td class="dataTableHeadingContent" align="right">&nbsp;</td>
              </tr>
<?php
echo $cip_list;
?>
            </table>
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
               <tr valign="top">
                 <td><?php
                    echo '<a class="button" href="' . vam_href_link($cip_manager->script_name(), 'action=upload').'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_UPLOAD . '</span></a>'; ?></td>
              </tr>
            </table>
            </td>
            <td style="pagging:1px;"></td>
<?php
}
echo $info;
?>
          </tr>
        </table></td>
      </tr>
    <?php
// end of list of CIP
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_FS_ADMIN_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_FS_ADMIN_INCLUDES . 'application_bottom.php'); ?>