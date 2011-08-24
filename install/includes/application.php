<?php
/* --------------------------------------------------------------
   $Id: application.php 1119 2007-02-07 13:12:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application.php,v 1.4 2002/11/29); www.oscommerce.com
   (c) 2003	 nextcommerce (application.php,v 1.16 2003/08/13); www.nextcommerce.org 
   (c) 2004	 xt:Commerce (application.php,v 1.16 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
// Some FileSystem Directories

  $_www_location = 'http://' . $_SERVER['HTTP_HOST'];

  if (isset($_SERVER['REQUEST_URI']) && (empty($_SERVER['REQUEST_URI']) === false)) {
    $_www_location .= $_SERVER['REQUEST_URI'];
  } else {
    $_www_location .= $_SERVER['SCRIPT_FILENAME'];
  }

  $_www_location = substr($_www_location, 0, strpos($_www_location, 'install'));

  $dir = dirname(__FILE__) . '/../../';
  $_dir_fs_www_root = str_replace('\\', '/', realpath($dir)).'/';

  if (!defined('DIR_FS_CATALOG')) define('DIR_FS_CATALOG',$_dir_fs_www_root);
  if (!defined('DIR_FS_INC')) define('DIR_FS_INC', $_dir_fs_www_root.'inc/');
  



// include
  require(DIR_FS_CATALOG.'includes/classes/message_stack.php');
  require(DIR_FS_CATALOG.'includes/filenames.php');
  require(DIR_FS_CATALOG.'includes/database_tables.php');
  require_once(DIR_FS_CATALOG.'inc/vam_image.inc.php');
  
// Start the Install_Session
  session_start();
  
// Set the level of error reporting
  error_reporting(E_ALL & ~E_NOTICE);

  define('CR', "\n");
  define('BOX_BGCOLOR_HEADING', '#bbc3d3');
  define('BOX_BGCOLOR_CONTENTS', '#f8f8f9');
  define('BOX_SHADOW', '#b6b7cb');

  // include General functions
  require_once(DIR_FS_INC.'vam_set_time_limit.inc.php');
  require_once(DIR_FS_INC.'vam_check_agent.inc.php');
  require_once(DIR_FS_INC.'vam_in_array.inc.php');
  
  // Include Database functions for installer
  require_once(DIR_FS_INC.'vam_db_prepare_input.inc.php');
  require_once(DIR_FS_INC.'vam_db_connect_installer.inc.php');
  require_once(DIR_FS_INC.'vam_db_select_db.inc.php');
  require_once(DIR_FS_INC.'vam_db_close.inc.php');
  require_once(DIR_FS_INC.'vam_db_query_installer.inc.php');
  require_once(DIR_FS_INC.'vam_db_fetch_array.inc.php');
  require_once(DIR_FS_INC.'vam_db_num_rows.inc.php');
  require_once(DIR_FS_INC.'vam_db_data_seek.inc.php');
  require_once(DIR_FS_INC.'vam_db_insert_id.inc.php');
  require_once(DIR_FS_INC.'vam_db_free_result.inc.php');
  require_once(DIR_FS_INC.'vam_db_test_create_db_permission.inc.php');
  require_once(DIR_FS_INC.'vam_db_test_connection.inc.php');
  require_once(DIR_FS_INC.'vam_db_install.inc.php');

  // include Html output functions
  require_once(DIR_FS_INC.'vam_draw_input_field_installer.inc.php');
  require_once(DIR_FS_INC.'vam_draw_password_field_installer.inc.php');
  require_once(DIR_FS_INC.'vam_draw_hidden_field_installer.inc.php');
  require_once(DIR_FS_INC.'vam_draw_checkbox_field_installer.inc.php');
  require_once(DIR_FS_INC.'vam_draw_radio_field_installer.inc.php');
  require_once(DIR_FS_INC.'vam_draw_box_heading.inc.php');
  require_once(DIR_FS_INC.'vam_draw_box_contents.inc.php');
  require_once(DIR_FS_INC.'vam_draw_box_content_bullet.inc.php');
  require_once (DIR_FS_INC.'vam_output_string.inc.php');

  // iinclude check functions
  require_once(DIR_FS_INC .'vam_gdlib_check.inc.php');
  
   if (!defined('DIR_WS_ICONS')) define('DIR_WS_ICONS','images/');

  function vam_check_version($mini='4.1.2')
{
   $dummy=phpversion();
  sscanf($dummy,"%d.%d.%d%s",$v1,$v2,$v3,$v4);
  sscanf($mini,"%d.%d.%d%s",$m1,$m2,$m3,$m4);
  if($v1>$m1)
       return(1);
   elseif($v1<$m1)
     return(0);
   if($v2>$m2)
       return(1);
  elseif($v2<$m2)
       return(0);
   if($v3>$m3)
      return(1);
   elseif($v3<$m3)
       return(0);
  if((!$v4)&&(!$m4))
       return(1);
  if(($v4)&&(!$m4))
   {
      $dummy=strpos($v4,"pl");
       if(is_integer($dummy))
          return(1);
       return(0);
   }
  elseif((!$v4)&&($m4))
   {
      $dummy=strpos($m4,"rc");
       if(is_integer($dummy))
          return(1);
       return(0);
   }
   return(0);
}


?>