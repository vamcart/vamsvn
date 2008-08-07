<?php
	require_once("includes/general.php");
	require_once("classes/FileSystems/LocalFileImpl.php");

	@set_time_limit(20*60); // 20 minutes execution time

	$orgWidth = getRequestParam("orgwidth");
	$orgHeight = getRequestParam("orgheight");
	$newWidth = getRequestParam("newwidth");
	$newHeight = getRequestParam("newheight");
	$left = getRequestParam("left");
	$top = getRequestParam("top");
	$action = getRequestParam("action");
	$path = getRequestParam("path");
	$orgpath = getRequestParam("orgpath", "");
	$filename = getRequestParam("filename", "");

	$msg = "";

	if ($orgpath == "")
		$orgpath = $path;

	$temp_image = "mcic_". session_id() ."";

	verifyAccess($mcImageManagerConfig);

	$rootpath = removeTrailingSlash(getRequestParam("rootpath", toUnixPath(getRealPath($mcImageManagerConfig, 'filesystem.rootpath'))));
	$fileFactory =& new FileFactory($mcImageManagerConfig, $rootPath);


	addFileEventListeners($fileFactory);

	$file =& $fileFactory->getFile($path);
	$config = $file->getConfig();
	$demo = checkBool($config['general.demo']) ? "true" : "false";
	$imageutils = new $config['thumbnail'];

	$tools = explode(',', $config['thumbnail.image_tools']);
	if (!in_array("edit", $tools))
		trigger_error("The thumbnail.image_tools needs to include edit.", WARNING);

	// File info
	$fileInfo = getFileType($file->getAbsolutePath());
	$file_icon = $fileInfo['icon'];
	$file_type = $fileInfo['type'];
	$file_ext = $fileInfo['ext'];

	$tempFile =& $fileFactory->getFile(dirname($file->getAbsolutePath()) . "/" . $temp_image .".". $file_ext);
	$tempFile->setTriggerEvents(false);

	switch ($action) {
		case "resize":
			$status = $imageutils->resizeImage($file->getAbsolutePath(), $tempFile->getAbsolutePath(), $newWidth, $newHeight, $file_ext);
			if ($status)
				$tempFile->importFile();

			$outpath = $tempFile->getAbsolutePath();
			$outstatus = "processed";
		break;

		case "crop":
			$status = $imageutils->cropImage($file->getAbsolutePath(), $tempFile->getAbsolutePath(), $top, $left, $newWidth, $newHeight, $file_ext);
			if ($status)
				$tempFile->importFile();

			$outpath = $tempFile->getAbsolutePath();
			$outstatus = "processed";
		break;

		case "save":
			// Skip save on demo
			if ($demo == "true")
				break;

			$orgFile =& $fileFactory->getFile(dirname($orgpath) . "/" . $filename);
			if ($orgFile->exists())
				$orgFile->delete();

			// Setup first filter
			$fileFilterA =& new BasicFileFilter();
			$fileFilterA->setIncludeFilePattern($config['filesystem.include_file_pattern']);
			$fileFilterA->setExcludeFilePattern($config['filesystem.exclude_file_pattern']);
			$fileFilterA->setIncludeExtensions($config['filesystem.extensions']);
			if (!$fileFilterA->accept($orgFile)) {
				if ($fileFilterA->getReason() == _BASIC_FILEFILTER_INVALID_EXTENSION)
					$msg = $config['filesystem.invalid_extension_msg'];
				else
					$msg = $config['filesystem.invalid_file_name_msg'];

				$outpath = $file->getAbsolutePath();
				$outstatus = "processed";
			} else {
				$file->setTriggerEvents(false);
				$file->renameTo($orgFile);
				$orgFile->importFile();
				$outpath = $orgFile->getAbsolutePath();
				$outstatus = "saved";
			}
		break;

		default :
			trigger_error("No action was specified, this error should not happen in normal cases.", WARNING);
	}

	header("Location: edit_image.php?path=". $outpath ."&orgpath=". $orgpath ."&action=". $action ."&status=". $outstatus . "&msg=" . $msg);
?>