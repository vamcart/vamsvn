<?php
/* --------------------------------------------------------------
	 $Id: languages.php 950 2005-05-14 16:45:21Z mz $

	 XT-Commerce - community made shopping
	 http://www.xt-commerce.com

	 Copyright (c) 2003 XT-Commerce
	 --------------------------------------------------------------
	 based on:
	 (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
	 (c) 2002-2003 osCommerce(languages.php,v 1.5 2002/11/22); www.oscommerce.com
	 (c) 2003	 nextcommerce (languages.php,v 1.6 2003/08/18); www.nextcommerce.org

	 Released under the GNU General Public License
	 --------------------------------------------------------------*/
defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );
	function xtc_mkdir_recursive($basedir, $subdir) {
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

	function xtc_get_image_size($src, $width, $height) {
		if ( (CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height)) ) {
			if ($image_size = @getimagesize($src)) {
				if (!xtc_not_null($width) && xtc_not_null($height)) {
					$ratio = $height / $image_size[1];
					$width = $image_size[0] * $ratio;
				} elseif (xtc_not_null($width) && !xtc_not_null($height)) {
					$ratio = $width / $image_size[0];
					$height = $image_size[1] * $ratio;
				} elseif (!xtc_not_null($width) && !xtc_not_null($height)) {
					$width = $image_size[0];
					$height = $image_size[1];
				}
			}
		}
		return(array((int)$width, (int)$height));
	}

	function xtc_get_files_in_dir($startdir, $ext=array('.jpg', '.jpeg', '.png', '.gif'), $dir_only=false, $subdir = '') {
//		echo 'Directory: ' . $startdir . '  Subirectory: ' . $subdir . '<br />';
		if(!is_array($ext)) $ext=array();
		$dirname = $startdir . $subdir;
		if ($dir= opendir($dirname)){
			while ($file = readdir($dir)) {
				if(substr($file, 0, 1) != '.') {
					if (is_file($dirname.$file) && !$dir_only) {
						if (in_array(substr($file, strrpos($file, '.')), $ext)) {
//							echo '&nbsp;&nbsp;File: ' . $subdir.$file . '<br />';
							$files[]=array('id' => $subdir.$file,
														 'text' => $subdir.$file);
						}
					} elseif (is_dir($dirname.$file)) {
						if($dir_only) {
							$files[]=array('id' => $subdir.$file.'/',
														 'text' => $subdir.$file.'/');
						}
						$files = xtc_array_merge($files, xtc_get_files_in_dir($startdir, $ext, $dir_only, $subdir.$file.'/'));
					}
				}
			}
			closedir($dir);
		}
		return($files);
	}
?>