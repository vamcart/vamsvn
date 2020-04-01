<?php
/* -----------------------------------------------------------------------------------------
   $Id: image_processing.php 950 2007-02-08 12:51:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cod.php,v 1.28 2003/02/14); www.oscommerce.com 
   (c) 2003	 nextcommerce (invoice.php,v 1.6 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (image_processing.php,v 1.25 2003/08/19); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

define('MODULE_IMAGE_PROCESS_TEXT_DESCRIPTION', 'Пакетная обработка изображений');
define('MODULE_IMAGE_PROCESS_TEXT_TITLE', 'Пакетная обработка изображений');
define('MODULE_IMAGE_PROCESS_STATUS_DESC','Статус модуля');
define('MODULE_IMAGE_PROCESS_STATUS_TITLE','Статус');
define('IMAGE_EXPORT','Нажмите [Одобрить] для начала пакетной обработки изображений, этот процесс может длиться некоторое время, ничего не трогайте и не прерывайте!');
define('IMAGE_EXPORT_TYPE','<hr noshade><b>Пакетная обработка:</b>');


  class image_processing {
    var $code, $title, $description, $enabled;


    function __construct() {
      global $order;

      $this->code = 'image_processing';
      $this->title = MODULE_IMAGE_PROCESS_TEXT_TITLE;
      $this->description = MODULE_IMAGE_PROCESS_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_IMAGE_PROCESS_SORT_ORDER;
      $this->enabled = ((MODULE_IMAGE_PROCESS_STATUS == 'True') ? true : false);

    }


    function process($file) {
         // include needed functions
include ('includes/classes/'.FILENAME_IMAGEMANIPULATOR);  
        @vam_set_time_limit(0);

        // action
        // get images in original_images folder
        $files=array();
// BOF Subdirectory support
			require_once(DIR_WS_FUNCTIONS . 'trumbnails_add_funcs.php');
			$files = vam_get_files_in_dir(DIR_FS_CATALOG_ORIGINAL_IMAGES);
//			echo '<pre>';var_dump($files);echo '</pre>';
/*
			if ($dir= opendir(DIR_FS_CATALOG_ORIGINAL_IMAGES)){
				while  ($file = readdir($dir)) {
					if (is_file(DIR_FS_CATALOG_ORIGINAL_IMAGES.$file) and ($file !="index.html") and (strtolower($file) != "thumbs.db")){
						$files[]=array(
													 'id' => $file,
													 'text' =>$file);
					}
				}
				closedir($dir);
			}
*/
// EOF Subdirectory support
			for ($i=0;$n=sizeof($files),$i<$n;$i++) {

				$products_image_name = $files[$i]['text'];
				if ($files[$i]['text'] != 'Thumbs.db' &&  $files[$i]['text'] != 'Index.html') {
					require(DIR_WS_INCLUDES . 'product_thumbnail_images.php');
					require(DIR_WS_INCLUDES . 'product_info_images.php');
					require(DIR_WS_INCLUDES . 'product_popup_images.php');
				}
			}

		}

		function display() {
			return array('text' =>
														IMAGE_EXPORT_TYPE.'<br>'.
														IMAGE_EXPORT.'<br>'.
														'<br>' . vam_button(BUTTON_REVIEW_APPROVE) . '&nbsp;' .
														vam_button_link(BUTTON_CANCEL, vam_href_link(FILENAME_MODULE_EXPORT, 'set=' . $_GET['set'] . '&module=image_processing')));

    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_IMAGE_PROCESS_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_IMAGE_PROCESS_STATUS', 'True',  '6', '1', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
}

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_IMAGE_PROCESS_STATUS');
    }

  }
?>