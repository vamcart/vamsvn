<?php
	require_once("includes/general.php");
	require_once("classes/FileSystems/LocalFileImpl.php");

	// get some information about the image
	$path = getRequestParam("path", "");
	$width = getRequestParam("width", "");
	$height = getRequestParam("height", "");
	$ext = getRequestParam("ext", "");
	$th_folder = "";

	verifyAccess($mcImageManagerConfig);

	$rootpath = removeTrailingSlash(getRequestParam("rootpath", toUnixPath(getRealPath($mcImageManagerConfig, 'filesystem.rootpath'))));
	$fileFactory =& new FileFactory($mcImageManagerConfig, $rootPath);

	$file =& $fileFactory->getFile($path);
	$config = $file->getConfig();
	$imageutils = new $config['thumbnail'];
	$canEdit = $imageutils->_canEdit;

	$proceed = true;

	if (($config['thumbnail.use_exif'] == true) AND (exifExists())) {
		$image = @exif_thumbnail($file->getAbsolutePath(), $exif_width, $exif_height, $exif_type);

		if ($image !== false) {
		   header('Content-type: ' . image_type_to_mime_type($exif_type));
		   echo $image;
		   die();
		}
	}

	// Preview path
	$wwwroot = removeTrailingSlash(toUnixPath(getWWWRoot($config)));
	$urlprefix = removeTrailingSlash(toUnixPath($config['preview.urlprefix']));
	$urlsuffix = toUnixPath($config['preview.urlsuffix']);

	$pos = strpos($path, $wwwroot);
	if ($pos !== false && $pos == 0)
		$previewurl = $urlprefix . substr($path, strlen($wwwroot));
	else
		$previewurl = "";

	if (($config['thumbnail.gd.folder'] == "") OR ($config['thumbnail.gd.enabled'] == false))
		$proceed = false;

	// Check for GD support
	if (!$canEdit)
		$proceed = false;
	
	// Handle thumbnail generation

	// We need to verify that we are not already inside a Thumbnail folder.
	
	$parentFile = $file->getParentFile();
	if ($config['thumbnail.gd.folder'] == $parentFile->getName())
		$proceed = false;

	// if any of above fails, redirect them to original image
	if (!$proceed) {
		header("Location: ". $previewurl);
		die();
	}

	// Check for aleady made thumbnail.
	if ($config['thumbnail.gd.folder'] != "")
		$th_folder = "/". $config['thumbnail.gd.folder'];
	
	$th_folder = dirname($file->getAbsolutePath()) . $th_folder;

	$thFolder = $fileFactory->getFile($th_folder);

	if ((!$thFolder->exists()) AND ($config['thumbnail.gd.auto_generate'] == true))
		$thFolder->mkdir();

	$th_path = $thFolder->getAbsolutePath() . "/" . $config['thumbnail.gd.prefix'] . basename($file->getAbsolutePath());
	$th = $fileFactory->getFile($th_path);
	$th_result = false;
	$th_preview = $urlprefix . substr($th->getAbsolutePath(), strlen($wwwroot)) . $urlsuffix;
	$th_time = time();
	$th_quality = $config['thumbnail.gd.jpeg_quality'];

	if ($th->exists()) {
		$thSize = @getimagesize($th->getAbsolutePath());
		$th_width = $thSize[0];
		$th_height = $thSize[1];
		$th_type = $thSize[2];

		if (($th_height != $height) OR ($th_width != $width)) {
			$th->delete();
			$th_result = $imageutils->resizeImage($file->getAbsolutePath(), $th->getAbsolutePath(), $width, $height, $ext, $th_quality);
		}

		if ($file->lastModified() != $th->lastModified()) {
			$th->delete();
			$th_result = $imageutils->resizeImage($file->getAbsolutePath(), $th->getAbsolutePath(), $width, $height, $ext, $th_quality);
		}

		if ($th_result)
			$th->setLastModified($file->lastModified());

		// Output image
		streamImage($th->getAbsolutePath(), $th_type, $th_preview);
	} else if ((!$th->exists()) AND ($config['thumbnail.gd.auto_generate'] == true)) {
		$th_result = $imageutils->resizeImage($file->getAbsolutePath(), $th->getAbsolutePath(), $width, $height, $ext, $th_quality);

		if ($th_result && $th->exists()) {
			$thSize = @getimagesize($th->getAbsolutePath());
			$th_type = $thSize[2];
			$th->setLastModified($file->lastModified());
		}
	}

	// failsafe check
	if ($th->exists() && $th_type) {
		streamImage($th->getAbsolutePath(), $th_type, $th_preview);
	} else
		Header("Location: ". $previewurl);

	die();
?>