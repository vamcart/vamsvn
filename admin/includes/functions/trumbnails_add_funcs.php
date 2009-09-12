<?php
/* --------------------------------------------------------------
	 $Id: trumbnails_add_funcs.php 950 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
	 --------------------------------------------------------------
	 based on:
	 (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
	 (c) 2002-2003 osCommerce(languages.php,v 1.5 2002/11/22); www.oscommerce.com
	 (c) 2003	 nextcommerce (languages.php,v 1.6 2003/08/18); www.nextcommerce.org
    (c) 2004 xt:Commerce (trumbnails_add_funcs.php,v 1.7 2003/08/18); xt-commerce.com

	 Released under the GNU General Public License
	 --------------------------------------------------------------*/
defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );
	function vam_mkdir_recursive($basedir, $subdir) {
		global $messageStack;
		if(!is_dir($basedir . $subdir)) {
			$mkdir_array = explode('/', $subdir);
			$mkdir = $basedir;
			for($i=0, $n=sizeof($mkdir_array); $i<$n; $i++) {
				$mkdir .= $mkdir_array[$i].'/';
				if(!is_dir($mkdir)) {
					if(!mkdir($mkdir)) {
						$messageStack->add(ERROR_IMAGE_DIRECTORY_CREATE . $mkdir, 'error');
						return false;
					} else {
						$messageStack->add(TEXT_IMAGE_DIRECTORY_CREATE . $mkdir, 'success');
					}
				}
			}
		}
	}

  function vam_get_image_size($src, $width, $height) {
      if ( (CONFIG_CALCULATE_IMAGE_SIZE == 'true')  ) {
         if ($image_size = @getimagesize($src)) {
             if (vam_not_null($width) && vam_not_null($height)) {
            $ratio = $width / $height;
            $src_ratio = $image_size[0] / $image_size[1];
              if ($ratio < $src_ratio) {
                $height = $width / $src_ratio;
             }
             else {
                $width = $height * $src_ratio;
             }
            }  elseif (!vam_not_null($width) && vam_not_null($height)) {
               $ratio = $height / $image_size[1];
               $width = $image_size[0] * $ratio;
            } elseif (vam_not_null($width) && !vam_not_null($height)) {
               $ratio = $width / $image_size[0];
               $height = $image_size[1] * $ratio;
            } elseif (!vam_not_null($width) && !vam_not_null($height) or $width > $image_size[0] or $height > $image_size[1]) {
               $width = $image_size[0];
               $height = $image_size[1];
            }
         }
      }
      return(array((int)$width, (int)$height));
   }

	function vam_get_files_in_dir($startdir, $ext=array('.jpg', '.jpeg', '.png', '.gif', '.JPG', '.bmp'), $dir_only=false, $subdir = '') {
//		echo 'Directory: ' . $startdir . '  Subirectory: ' . $subdir . '<br />';
		if(!is_array($ext)) $ext=array();
		$dirname = $startdir . $subdir;
		if ($dir= opendir($dirname)){
			while (false !== ($file = readdir($dir)) ) { 
				if(substr($file, 0, 1) != '.') {
					if (is_file($dirname.$file) && !$dir_only) {
						if (in_array(substr($file, strrpos($file, '.')), $ext)) {
//							echo '&nbsp;&nbsp;File: ' . $subdir.$file . '<br />';
							$files[]=array('id' => $subdir.$file,
														 'text' => $subdir.$file);
							array_multisort ($files, SORT_ASC);
						}
					} elseif (is_dir($dirname.$file)) {
						if($dir_only) {
							$files[]=array('id' => $subdir.$file.'/',
														 'text' => $subdir.$file.'/');
							array_multisort ($files, SORT_ASC);
						}
						$files = vam_array_merge($files, vam_get_files_in_dir($startdir, $ext, $dir_only, $subdir.$file.'/'));
					}
				}
			}
			closedir($dir);
		}
		return($files);
	}
?>