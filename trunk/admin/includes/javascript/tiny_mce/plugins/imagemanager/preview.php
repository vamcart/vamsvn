<?php
	require_once("includes/general.php");
	require_once("classes/FileSystems/FileFactory.php");
	require_once("classes/FileSystems/LocalFileImpl.php");

	$data = array();
	verifyAccess($mcImageManagerConfig);
	$path = getRequestParam("path", toUnixPath(getRealPath($mcImageManagerConfig, 'filesystem.path')));
	$rootpath = getRequestParam("rootpath", toUnixPath(getRealPath($mcImageManagerConfig, 'filesystem.rootpath')));
	$fileFactory =& new FileFactory($mcImageManagerConfig, $rootpath);
	$targetFile =& $fileFactory->getFile($path);
	$targetFolder = $targetFile =& $targetFile->getParentFile();
	$config = $targetFile->getConfig();

	// Preview path
	$wwwroot = removeTrailingSlash(toUnixPath(getWWWRoot($config)));
	$urlprefix = removeTrailingSlash(toUnixPath($config['preview.urlprefix']));
	$urlsuffix = toUnixPath($config['preview.urlsuffix']);

	addFileEventListeners($fileFactory);

	// Get filtered files
	$fileFilter =& new BasicFileFilter();
	$fileFilter->setIncludeDirectoryPattern($config['filesystem.include_directory_pattern']);
	$fileFilter->setExcludeDirectoryPattern($config['filesystem.exclude_directory_pattern']);
	$fileFilter->setIncludeFilePattern($config['filesystem.include_file_pattern']);
	$fileFilter->setExcludeFilePattern($config['filesystem.exclude_file_pattern']);
	$fileFilter->setOnlyFiles(true);
	$files =& $targetFolder->listFilesFiltered($fileFilter);

	$fileList = array();
	$previous = array();
	$previous['width'] = 0;
	$previous['height'] = 0;
	$previous['path'] = "";

	$next = array();
	$next['width'] = 0;
	$next['height'] = 0;
	$next['path'] = "";

	$first = array();
	$first['width'] = 0;
	$first['height'] = 0;
	$first['path'] = "";

	$last = array();
	$last['width'] = 0;
	$last['height'] = 0;
	$last['path'] = "";
	
	$prevItem = $previous;

	$current = false;

	$count = 0;

	foreach ($files as $file) {
		if ($file->isDirectory())
			continue;

		$fileItem = array();
		$imageSize = array();

		$fileItem['margin'] = 0;

		$imageSize = getimagesize($file->getAbsolutePath());
		$fileItem['width'] = $imageSize[0] ? $imageSize[0] : 0;
		$fileItem['height'] = $imageSize[1] ? $imageSize[1] : 0;

		$fileItem['name'] = basename($file->getAbsolutePath());
		$fileItem['path'] = $file->getAbsolutePath();

		if ($count == 0)
			$first = $fileItem;

		if (($count+1) == count($files))
			$last = $fileItem;

		if ($current) {
			$next = $fileItem;
			$current = false;
		}

		if ($file->getAbsolutePath() == $path) {
			$previous = $prevItem;
			$current = true;
		}

		$prevItem = $fileItem;
		$count++;
	}

	function getInfo($filepath) {
		$info = array();
		$imageSize = getimagesize($filepath);
		$info['width'] = $imageSize[0] ? $imageSize[0] : 0;
		$into['height'] = $imageSize[1] ? $imageSize[1] : 0;
		return $info;
	}

	$imageinfo = getimagesize($path);

	$pos = strpos($path, $wwwroot);
	if ($pos !== false && $pos == 0)
		$data['previewurl'] = $urlprefix . substr($path, strlen($wwwroot)) . $urlsuffix;
	else
		$data['previewurl'] = "";

	$data['next'] = $next;
	$data['previous'] = $previous;
	$data['first'] = $first;
	$data['last'] = $last;
	$data['path'] = $path;
	$data['name'] = basename($path);
	$data['width'] = $imageinfo[0] ? $imageinfo[0] : 0;
	$data['height'] = $imageinfo[1] ? $imageinfo[1] : 0;
	$data['size'] = getSizeStr($targetFile->length());
	$data['errorMsg'] = "";

	// Render output
	renderPage("preview.tpl.php", $data);
?>
