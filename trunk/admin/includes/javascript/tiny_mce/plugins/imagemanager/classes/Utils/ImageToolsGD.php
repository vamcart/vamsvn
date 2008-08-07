<?php
/**
 * ImageToolsGD.php
 *
 * @package MCImageManager.utils
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

/**
 * This class handles XML language packs.
 *
 * @package MCImageManager.utils
 */
class ImageToolsGD {
	
	/* Internal variables */
	var $_source = "";
	var $_target = "";
	var $_width = 0;
	var $_height = 0;
	var $_ext = "";
	var $_quality = "";

	var $_top = 0;
	var $_left = 0;

	var $_canEdit = false;

	/**
	 * Constructor
	 */
	function ImageToolsGD() {
		// Constructor
		$this->_canEdit = $this->canEdit();
	}

	/**
	 * Generates a resized image as the target file, from the source file
	 * @param String $source Absolute source path.
	 * @param String $target Absolute source target.
	 * @param Int $height Height of image.
	 * @param Int $width Width of the image.
	 * @param String $ext Extension of the image.
	 * @param Int $quality Quality in percent, 0-100.
	 * @return Bool true or false depending on success or not.
	 */
	function resizeImage($source, $target, $width, $height, $ext, $quality="") {
		if (!$this->_canEdit)
			return false;

		$this->_quality = $quality;
		$this->_source = $source;
		$this->_target = $target;
		$this->_width = $width;
		$this->_height = $height;
		$this->_ext = $ext;

		switch ($ext) {
			case "gif":
				return $this->_resizeGif();
				break;
			case "jpg":
			case "jpe":
			case "jpeg":
				return $this->_resizeJpg();
				break;
			case "png":
				return $this->_resizePng();
				break;
			case "bmp":
				return false;
				break;
		}
		
		return false;
	}

	/**
	 * Generates a cropped image as the target file, from the source file
	 * @param String $source Absolute source path.
	 * @param String $target Absolute source target.
	 * @param Int $top Top of crop.
	 * @param Int $left Left of crop.
	 * @param Int $height Height of image.
	 * @param Int $width Width of the image.
	 * @param String $ext Extension of the image.
	 * @param Int $quality Quality in percent, 0-100.
	 * @return Bool true or false depending on success or not.
	 */
	function cropImage($source, $target, $top, $left, $width, $height, $ext, $quality="") {
		if (!$this->_canEdit)
			return false;

		$this->_left = $left;
		$this->_top = $top;
		$this->_quality = $quality;
		$this->_source = $source;
		$this->_target = $target;
		$this->_width = $width;
		$this->_height = $height;
		$this->_ext = $ext;

		switch ($ext) {
			case "gif":
				return $this->_cropGif();
				break;
			case "jpg":
			case "jpe":
			case "jpeg":
				return $this->_cropJpg();
				break;
			case "png":
				return $this->_cropPng();
				break;
			case "bmp":
				return false;
				break;
		}
	}

	/**
	 * Internal function for cropping gif images.
	 * @return Bool true or false depending on success or not.
	 */
	function _cropGif() {
		$source = ImagecreateFromGif($this->_source);
		$image = ImageCreate($this->_width, $this->_height);

		$transparent = imagecolorallocate($image, 255, 255, 255);

		imagefilledrectangle($image, 0, 0, $this->_width, $this->_width, $transparent);

		imagecolortransparent($image, $transparent);

		ImageCopyResampled($image, $source, 0, 0, $this->_left, $this->_top, $this->_width, $this->_height, $this->_width, $this->_height);

		$result = ImageGif($image, $this->_target);
		ImageDestroy($image);
		ImageDestroy($source);
		return $result; 
	}

	/**
	 * Internal function for cropping png images.
	 * @return Bool true or false depending on success or not.
	 */
	function _cropPng() {
		$source = ImagecreateFromPng($this->_source);
		$image = ImageCreateTrueColor($this->_width, $this->_height);

		imagealphablending($image, false);
		imagesavealpha($image, true);

		ImageCopyResampled($image, $source, 0, 0, $this->_left, $this->_top, $this->_width, $this->_height, $this->_width, $this->_height);

		$result = ImagePng($image, $this->_target);
		ImageDestroy($image);
		ImageDestroy($source);
		return $result;
	}

	/**
	 * Internal function for cropping Jpg images.
	 * @return Bool true or false depending on success or not.
	 */
	function _cropJpg() {
		$source = ImagecreateFromJpeg($this->_source);
		$image = ImageCreateTrueColor($this->_width, $this->_height);

		ImageCopyResampled($image, $source, 0, 0, $this->_left, $this->_top, $this->_width, $this->_height, $this->_width, $this->_height);

		// this should set it to same file
		if ($this->_quality != "")
			$result = ImageJpeg($image, $this->_target, $this->_quality);
		else
			$result = ImageJpeg($image, $this->_target);

		ImageDestroy($image);
		ImageDestroy($source);
		
		return $result;
	}

	/**
	 * Internal function for resizing gif images.
	 * @return Bool true or false depending on success or not.
	 */
	function _resizeGif() {
		$source = ImagecreateFromGif($this->_source);
		$image = ImageCreate($this->_width, $this->_height);

		//imagealphablending($thumbnail, true);
		//imagesavealpha($thumbnail,true);

		$transparent = imagecolorallocate($image, 255, 255, 255);

		imagefilledrectangle($image, 0, 0, $this->_width, $this->_height, $transparent);

		imagecolortransparent($image, $transparent);

		ImageCopyResampled($image, $source, 0, 0, 0, 0, $this->_width, $this->_height, ImageSX($source), ImageSY($source));
		$result = ImageGif($image, $this->_target);
		ImageDestroy($image);
		ImageDestroy($source);
		return $result;
	}

	/**
	 * Internal function for resizing png images.
	 * @return Bool true or false depending on success or not.
	 */
	function _resizePng() {
		$source = ImagecreateFromPng($this->_source);
		$image = ImageCreate($this->_width, $this->_height);

		imagealphablending($image, true);
		imagesavealpha($image, true);

		$transparent = imagecolorallocatealpha($image, 255, 255, 255, 0);

		imagefilledrectangle($image, 0, 0, $this->_width, $this->_height, $transparent);

		imagecolortransparent($image, $transparent);

		ImageCopyResampled($image, $source, 0, 0, 0, 0, $this->_width, $this->_height, ImageSX($source), ImageSY($source));
		$result = ImagePng($image, $this->_target);
		ImageDestroy($image);
		ImageDestroy($source);
		return $result;
	}

	/**
	 * Internal function for resizing jpg images.
	 * @return Bool true or false depending on success or not.
	 */
	function _resizeJpg() {
		$source = ImageCreateFromJpeg($this->_source);
		$image = ImageCreateTrueColor($this->_width, $this->_height);
		ImageCopyResampled($image, $source, 0, 0, 0, 0, $this->_width, $this->_height, ImageSX($source), ImageSY($source));

		$result = false;

		// this should set it to same file
		if ($this->_quality != "")
			$result = ImageJpeg($image, $this->_target, $this->_quality);
		else
			$result = ImageJpeg($image, $this->_target);

		ImageDestroy($source);
		ImageDestroy($image);

		return $result;
	}

	/**
	 * Check for the GD functions that are beeing used.
	 * @return Bool true or false depending on success or not.
	 */
	function canEdit() {
		// just make a quick check, we dont need to loop if we can't find GD at all.
		if (!function_exists("gd_info"))
			return false;

		// list the functions
		$gdUsedFunctions = array();
		$gdUsedFunctions[] = "ImagecreateFromJpeg";
		$gdUsedFunctions[] = "ImagecreateFromPng";
		$gdUsedFunctions[] = "ImagecreateFromGif";
		$gdUsedFunctions[] = "ImageJpeg";
		$gdUsedFunctions[] = "ImagePng";
		$gdUsedFunctions[] = "ImageGif";
		$gdUsedFunctions[] = "ImageCopyResized";
		$gdUsedFunctions[] = "imageCopyResampled";
		$gdUsedFunctions[] = "ImageColorTransparent";
		$gdUsedFunctions[] = "ImageCreateTrueColor";
		$gdUsedFunctions[] = "ImageSX";
		$gdUsedFunctions[] = "ImageSY";

		// check so that each function exists
		foreach($gdUsedFunctions as $function) {
			if (!function_exists($function))
				return false;
		}

		return true;
	}
}
?>