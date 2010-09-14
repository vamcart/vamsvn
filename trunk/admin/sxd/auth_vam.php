<?php
/**
 * @package dumper
 * @copyright Copyright 2005-2010 Andrew Berezin eCommerce-Service.com
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Copyright 2003-2010 http://sypex.net/
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: auth_zen.php 1.0 20.08.2010 11:25:57 AndrewBerezin $
 */
function zen_sdxErrorHandler($errno, $errstr, $errfile, $errline) {
  global $sxd_error_handler;
  if ($errno == E_NOTICE) {
    return null;
  }
  return $sxd_error_handler;
}
$sxd_error_handler = set_error_handler('zen_sdxErrorHandler', E_NOTICE);
chdir(dirname(__FILE__) . '/..');
$loaderPrefix = 'dumper';
require('includes/application_top.php');
chdir(dirname(__FILE__));
set_error_handler($sxd_error_handler);
if ($_SESSION['customers_status']['customers_status_id'] == 0) {
	$auth = 1;
  $this->CFG['my_host'] = DB_SERVER;
//  $this->CFG['my_port'] = ;
  $this->CFG['my_user'] = DB_SERVER_USERNAME;
  $this->CFG['my_pass'] = DB_SERVER_PASSWORD;
	$this->CFG['my_db']   = DB_DATABASE;
	$this->CFG['backup_path'] = DIR_FS_ADMIN . 'backups/';
  if (ENABLE_SSL_ADMIN == 'true') {
    $link = HTTPS_SERVER . DIR_WS_HTTPS_ADMIN;
  } else {
    $link = HTTP_SERVER . DIR_WS_ADMIN;
  }
	$this->CFG['backup_url'] = $link . 'backups/';
	$this->CFG['lang']    = $_SESSION['language_code'];
	$this->CFG['exitURL'] = vam_href_link(FILENAME_DEFAULT);
}

