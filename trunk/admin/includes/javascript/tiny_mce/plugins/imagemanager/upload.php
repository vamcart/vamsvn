<?php
/**
 * upload.php
 *
 * @package MCFileManager.pages
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

	require_once("includes/general.php");
	require_once("classes/FileSystems/LocalFileImpl.php");

	@set_time_limit(20*60); // 20 minutes execution time

	$data = array();
	verifyAccess($mcImageManagerConfig);
	$path = getRequestParam("path", toUnixPath(getRealPath($mcImageManagerConfig, 'filesystem.path')));
	$numfiles = getRequestParam("numfiles", "0");
	$rootpath = getRequestParam("rootpath", toUnixPath(getRealPath($mcImageManagerConfig, 'filesystem.rootpath')));
	$fileFactory =& new FileFactory($mcImageManagerConfig, $rootpath);
	$targetFile =& $fileFactory->getFile($path);
	$config = $targetFile->getConfig();

	addFileEventListeners($fileFactory);

	$data['errorMsg'] = "";
	$data['path'] = $path;
	$data['short_path'] = getUserFriendlyPath($path, 30);
	$data['full_path'] = getUserFriendlyPath($path);
	$data['filename0'] = "";
	$data['demo'] = checkBool($config['general.demo']) ? "true" : "false";
	$data['demo_msg'] = $config['general.demo_msg'];

	// Output these to do JS ext check
	$data['filesystem.extensions'] = $config['filesystem.extensions'];
	$data['filesystem.invalid_extension_msg'] = $config['filesystem.invalid_extension_msg'];
	$data['upload.extensions'] = $config['upload.extensions'];
	$data['upload.invalid_extension_msg'] = $config['upload.invalid_extension_msg'];
	$data['numfiles'] = $numfiles;

	// Merge a valid extensions string
	$fileSysExtArr = preg_split('/,/', $config['filesystem.extensions'], -1, PREG_SPLIT_NO_EMPTY);
	$uploadExtArr = preg_split('/,/', $config['upload.extensions'], -1, PREG_SPLIT_NO_EMPTY);
	$validExtArr = array();

	// Add upload extentions
	if ($config['upload.extensions'] != "" && $config['upload.extensions'] != "*") {
		$fileSysAll = $config['filesystem.extensions'] == "" || $config['filesystem.extensions'] == "*";
		foreach ($uploadExtArr as $upExt) {
			if (!in_array($upExt, $validExtArr) && (in_array($upExt, $fileSysExtArr) || $fileSysAll))
				$validExtArr[] = $upExt;
		}
	} else {
		foreach ($fileSysExtArr as $sExt) {
			if (!in_array($sExt, $validExtArr))
				$validExtArr[] = $sExt;
		}
	}

	$data['valid_extensions'] = implode(', ', $validExtArr);

	// Check file size
	$maxSize = preg_replace("/[^0-9]/", "", $config["upload.maxsize"]);
	$maxSizeBytes = $maxSize;
	$prefix = " bytes";

	// Is KB
	if (strpos((strtolower($config["upload.maxsize"])), "k") > 0) {
		$maxSizeBytes *= 1024;
		$prefix = " KB";
	}

	// Is MB
	if (strpos((strtolower($config["upload.maxsize"])), "m") > 0) {
		$maxSizeBytes *= (1024 * 1024);
		$prefix = " MB";
	}

	$data['max_file_size'] = getSizeStr($maxSizeBytes);

	// Always create a local file instance
	for ($i=0; isset($_FILES['file' . $i]['tmp_name']); $i++) {
		// Do nothing in demo mode
		if (checkBool($config['general.demo']))
			trigger_error($config['general.demo_msg'], WARNING);

		// No access, tool disabled
		if (in_array("upload", explode(',', $config['general.disabled_tools'])))
			trigger_error("You don't have access to perform the requested action.", FATAL);

		$filename = getRequestParam("filename" . $i, false);
		$data['filename' . $i] = $filename;

		// Get the god damned extension
		$ext = "";
		if (strpos(basename($_FILES['file' . $i]['name']), ".") > 0) {
			$ar = explode('.', basename($_FILES['file' . $i]['name']));
			$ext = array_pop($ar);
		}

		$file =& new LocalFileImpl($fileFactory, $path, $filename . "." . $ext);

		if (is_uploaded_file($_FILES['file' . $i]['tmp_name'])) {
			// Exists?
			if ($file->exists()) {
				@unlink($_FILES['file' . $i]['tmp_name']);
				$data['errorMsg'] = "error_exists";
				renderPage("upload.tpl.php", $data);
			}

			// Hack attempt
			if ($filename == $config['filesystem.local.access_file_name']) {
				@unlink($_FILES['file' . $i]['tmp_name']);
				$data['errorMsg'] = "Error: You can not upload a access file.";
				renderPage("upload.tpl.php", $data);
			}

			move_uploaded_file($_FILES['file' . $i]['tmp_name'], $file->getAbsolutePath());
			
			// Dispatch add event
			$file->importFile();

			// Setup first filter
			$fileFilterA =& new BasicFileFilter();
			$fileFilterA->setIncludeFilePattern($config['filesystem.include_file_pattern']);
			$fileFilterA->setExcludeFilePattern($config['filesystem.exclude_file_pattern']);
			$fileFilterA->setIncludeExtensions($config['filesystem.extensions']);
			if (!$fileFilterA->accept($file)) {
				if ($fileFilterA->getReason() == _BASIC_FILEFILTER_INVALID_EXTENSION)
					$msg = $config['filesystem.invalid_extension_msg'];
				else
					$msg = $config['filesystem.invalid_file_name_msg'];
			}

			// Setup second filter
			$fileFilterB =& new BasicFileFilter();
			$fileFilterB->setIncludeFilePattern($config['upload.include_file_pattern']);
			$fileFilterB->setExcludeFilePattern($config['upload.exclude_file_pattern']);
			$fileFilterB->setIncludeExtensions($config['upload.extensions']);
			if (!$fileFilterB->accept($file)) {
				if ($fileFilterB->getReason() == _BASIC_FILEFILTER_INVALID_EXTENSION)
					$msg = $config['upload.invalid_extension_msg'];
				else
					$msg = $config['upload.invalid_file_name_msg'];
			}

			$toBig = filesize($file->getAbsolutePath()) > $maxSizeBytes;
			if ($toBig)
				$msg = "error_to_large";

			// Verify uploaded file, if it fails delete it
			if (!$fileFilterA->accept($file) || !$fileFilterB->accept($file) || $toBig) {
				$file->delete();
				$data['errorMsg'] = $msg;
			} else {
				$thumbnailArray = array();
				$thumbnailArray[] = "jpeg";
				$thumbnailArray[] = "jpg";
				$thumbnailArray[] = "gif";
				$thumbnailArray[] = "png";

				$fileInfo = $file->getInfo();
				$ext = $fileInfo['extension'];

				if (in_array(strtolower($ext), $thumbnailArray)) {
					if (($config['upload.create_thumbnail'] == true) AND ($config['thumbnail.gd.enabled'] == true) AND ($config['thumbnail.gd.folder'] != "")) {
						$imageutils = new $config['thumbnail'];
						// if use_exif is enabled and present, dont generate an image.
						if (($config['thumbnail.use_exif'] == true) AND (exifExists())) {
							$exif = @exif_read_data($file->getAbsolutePath(), "THUMBNAIL", true, false);

							if ($exit !== false)
								continue;
						}

						if ($config['thumbnail.scale_mode'] == "percentage") {
							if ($config['thumbnail.height'] > $config['thumbnail.width'])
								$target = $config['thumbnail.width'];
							else
								$target = $config['thumbnail.height'];
							
							$imageSize = @getimagesize($file->getAbsolutePath());

							$width = $imageSize['width'];
							$height = $imageSize['height'];
						} else {
							$width = $config['thumbnail.width'];
							$height = $config['thumbnail.height'];
						}

						// We need to verify that we are not already inside a Thumbnail folder.
						$parentFile = $file->getParentFile();
						if ($config['thumbnail.gd.folder'] == $parentFile->getName())
							continue;

						// Check for aleady made thumbnail.
						if ($config['thumbnail.gd.folder'] != "")
							$th_folder = "/". $config['thumbnail.gd.folder'];
						
						$th_folder = dirname($file->getAbsolutePath()) . $th_folder;

						$thFolder = $fileFactory->getFile($th_folder);

						if (!$thFolder->exists())
							$thFolder->mkdir();

						$th_path = $thFolder->getAbsolutePath() . "/" . $config['thumbnail.gd.prefix'] . basename($file->getAbsolutePath());
						$th = $fileFactory->getFile($th_path);
						$th_result = false;
						$th_time = time();
						$th_quality = $config['thumbnail.gd.jpeg_quality'];

						if ($th->exists()) {
							$th->delete();
							$th_result = $imageutils->resizeImage($file->getAbsolutePath(), $th->getAbsolutePath(), $width, $height, $ext, $th_quality);

							if ($th_result) {
								$th->importFile();
								$th->setLastModified($file->lastModified());
							}
						} else if (!$th->exists()) {
							$th_result = $imageutils->resizeImage($file->getAbsolutePath(), $th->getAbsolutePath(), $width, $height, $ext, $th_quality);

							if ($th_result) {
								$th->importFile();
								$th->setLastModified($file->lastModified());
							}
						}
					}
				}
			}
		}
	}

	// Render output
	renderPage("upload.tpl.php", $data);
?>
