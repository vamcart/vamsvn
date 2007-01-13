<?php
/*
  cip_manager.php
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2003 osCommerce
  Released under the GNU General Public License
*/

if(defined('ESCOM_VERSION')){
	require(DIR_FS_ADMIN_INCLUDES.'application_top.php');
}else{
	if(!defined('DB_PREFIX')) define('DB_PREFIX', '');
	require('includes/application_top.php');
    require('includes/configure_ci.php');
}


if(!defined('TABLE_CIP')) {
    define('TABLE_CIP', (defined('DB_PREFIX') ? DB_PREFIX : '').'cip');
}



require_once(DIR_FS_ADMIN_CLASSES.'ci_cip.class.php');
require_once(DIR_FS_ADMIN_CLASSES.'ci_upload_cip.class.php');
require_once(DIR_FS_ADMIN_CLASSES.'ci_file_integrity.class.php');



//phpBB 2.0.19:
if (is_file(DIR_FS_ADMIN_CLASSES.'ci_phpbb_user.class.php') && !is_object($phpbb_user)) {
    require_once(DIR_FS_ADMIN_CLASSES.'ci_phpbb_user.class.php');
    $phpbb_user = new phpbb_user();
    $phpbb_user->check_error();
}


//set_current_path:

//if (defined('DIR_FS_CIP'))     $current_path=DIR_FS_CIP;
if (isset($_REQUEST['contrib_dir']))     $current_path=$_REQUEST['contrib_dir'];
if (isset($_REQUEST['goto']))     $current_path=$_REQUEST['goto'];

if (strstr($current_path, '..') or !is_dir($current_path) or (defined(DIR_FS_CIP) && !ereg('^' . DIR_FS_CIP, $current_path))) {
    $current_path = DIR_FS_CIP;
}

if (!xtc_session_is_registered('current_path')) {
    xtc_session_register('current_path');
}

$current_path=str_replace ('//', '/', $current_path);

// initialize the message stack for output messages
require_once(DIR_FS_ADMIN_CLASSES.'table_block.php');
require_once(DIR_FS_ADMIN_CLASSES.'ci_message.class.php');
$message=new message;

//Must be included after ci_phpbb_user.class.php AND ci_message.class.php:
require_once(DIR_FS_ADMIN_CLASSES.'ci_cip_manager.class.php');
$cip_manager= new cip_manager($current_path);

require_once(DIR_FS_ADMIN_FUNCTIONS . 'contrib_installer.php');


// Nessesary for self-install. We redirect from init_contrib_installer.php with this patameters:
if (!defined(DIR_FS_CIP) && $_REQUEST['contrib_dir'])     define ('DIR_FS_CIP', $_REQUEST['contrib_dir']);

//Check if ontrib Installer installed:
if (DIR_FS_CIP=='DIR_FS_CIP')     xtc_redirect(xtc_href_link(INIT_CONTRIB_INSTALLER));

//PrintArray($_REQUEST);

//Check if self-install was made:
if ($_REQUEST['cip']!=$cip_manager->ci_cip() && $_REQUEST['contrib_dir'] &&
    !$cip_manager->is_ci_installed())    xtc_redirect(xtc_href_link(INIT_CONTRIB_INSTALLER));

$cip_manager->check_action($_REQUEST['action']);

//Prepare output:
if ($cip_manager->action()!='edit') {
    //Content for list:
    $contents = array();
    $contents=$cip_manager->folder_contents();
    if (is_array($contents)) {
        function xtc_cmp($a, $b) {return strcmp( ($a['is_dir'] ? 'D' : 'F') . $a['name'], ($b['is_dir'] ? 'D' : 'F') . $b['name']);}
        usort($contents, 'xtc_cmp');
    }

     $cip_list=$cip_manager->draw_cip_list();


}
$info=$cip_manager->draw_info();
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<?php if(!defined('ESCOM_VERSION')){ ?>
</head>
<body bgcolor="#E5E5E5">
<?php } ?>
<!-- header //-->
<?php require(DIR_FS_ADMIN_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
      <tr>
        <td width="100%">

    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
        
        </td>
      </tr>

  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
if ($cip_manager->action()=='edit') {
        ?>
       <tr><td><?php echo xtc_draw_separator('pixel_trans.gif', '1', '10');?></td></tr>
       <tr><?php echo xtc_draw_form('new_file', $cip_manager->script_name(), 'action=save');?>
            <td><table border="0" cellspacing="0" cellpadding="2">
            <tr>
                <td class="main"><?php echo TEXT_FILE_NAME;?></td>
                <td class="main"><?php echo  $cip_manager->cip() . xtc_draw_hidden_field('filename', $cip_manager->cip());?></td>
            </tr>
            <tr>
                <td class="main" valign="top"><?php echo TEXT_FILE_CONTENTS;?></td>
                <td class="main"><?php
                    $file_contents = '';
                    if ($file_array=file($cip_manager->current_path().'/'. $cip_manager->cip())) {
                        $file_contents = addslashes(implode('', $file_array));
                    }
                    echo xtc_draw_textarea_field('file_contents', 'soft', '100', '20', $file_contents,
                            (($cip_manager->file_writeable) ? '' : 'readonly'));
                ?></td>
            </tr>
            <tr><td colspan="2"><?php echo xtc_draw_separator('pixel_trans.gif', '1', '10');?></td></tr>
            <tr>
                <td align="right" class="main" colspan="2"><?php
                    if (!isset($cip_manager->file_writeable))    $cip_manager->file_writeable=true;
                    if ($cip_manager->file_writeable)     echo '<input type="submit" class="button" value="' . BUTTON_SAVE .'">&nbsp;';
                    echo '<a clas="button" href="'.xtc_href_link($cip_manager->script_name(), (isset($_REQUEST['cip']) ?
                        'cip='. urlencode($cip_manager->cip()) : '')).'">'.
                        BUTTON_CANCEL.'</a>';?>
                </td>
            </tr>
            </table></td>
        </form></tr>
    <?php
} else {
      ?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0" >
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="1" cellpadding="0">

              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php
                    echo TABLE_HEADING_FILENAME; ?></td>
<?php
    if ($cip_manager->cip_net_ua()) {
        echo '<td class="dataTableHeadingContent" align="center">'.'Downloads'.'</td>';
    }
?>
                <td class="dataTableHeadingContent" align="right"><?php
                    echo TABLE_HEADING_ACTION; ?>&nbsp;</td><?php

    if ($cip_manager->current_path==DIR_FS_CIP &&
        (SHOW_SIZE_COLUMN=='true' || $cip_manager->is_admin())) {
        echo '<td class="dataTableHeadingContent" align="right">'. TABLE_HEADING_SIZE.', Kb</td>';
    }
    if ($cip_manager->current_path==DIR_FS_CIP &&
        (SHOW_UPLOADER_COLUMN=='true' || $cip_manager->is_admin())) {
        echo '<td class="dataTableHeadingContent">Uploader</td>';
    }
    if ($cip_manager->current_path==DIR_FS_CIP && SHOW_UPLOADED_COLUMN=='true') {
        echo '<td class="dataTableHeadingContent">&nbsp; '. TABLE_HEADING_UPLOADED. '</td>';
    }

    if (SHOW_PERMISSIONS_COLUMN=='true' || $cip_manager->is_admin()) {
        echo '<td class="dataTableHeadingContent" align="center">'. TABLE_HEADING_PERMISSIONS. '</td>';
    }
    if (SHOW_USER_GROUP_COLUMN=='true' || $cip_manager->is_admin()) {
        echo '<td class="dataTableHeadingContent">'. TABLE_HEADING_USER.' / '.TABLE_HEADING_GROUP.'</td>';
    }
                ?>
                <td class="dataTableHeadingContent" align="right">&nbsp;</td>
              </tr><?php
echo $cip_list;
              ?>
            </table>
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
               <tr valign="top">
                 <td><?php
                    echo '<a class="button" href="' . xtc_href_link($cip_manager->script_name(), 'action=reset').'">'.
                     BUTTON_RESET . '</a>';
                    echo '&nbsp;';
                    echo '<a class="button" href="' . xtc_href_link($cip_manager->script_name(), 'action=upload').'">'.
                     BUTTON_UPLOAD . '</a>'; ?></td>
              </tr>
            </table>
            </td>
            <td style="pagging:1px;"></td>
            <?php
echo $info;
            ?>
          </tr>
        </table></td>
      </tr>
    <?php
}// end of list of CIP
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_FS_ADMIN_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<?php if(!defined('ESCOM_VERSION')){ ?>
</body>
</html>
<?php } ?>
<?php require(DIR_FS_ADMIN_INCLUDES . 'application_bottom.php'); ?>