<?php
/**
 * images.php
 *
 * @package MCImageManager.pages
 * @author Moxiecode
 * @copyright Copyright © 2006, Moxiecode Systems AB, All rights reserved.
 */

	require_once("includes/general.php");
	require_once("includes/toolbar.php");
	require_once("classes/FileSystems/LocalFileImpl.php");

	$errorMsg = getRequestParam("errorMsg", "");
	// Get path and config
	verifyAccess($mcImageManagerConfig);
	$path = $mcImageManagerConfig['filesystem.path'];
	$url = getRequestParam("url", "");
	$dropcache = getRequestParam("dropcache", false);
	$rootpath = $mcImageManagerConfig['filesystem.rootpath'];

	// Check rootpath, default to first in array.
	if ($rootpath == "_mc_unknown_root_path_") {
		$rootkeys = array_keys($mcImageManagerConfig['filesystem.rootpaths']);
		if (count($rootkeys) > 0) {
			$rootpath = $mcImageManagerConfig['filesystem.rootpaths'][$rootkeys[0]];
			$mcImageManagerConfig['filesystem.rootpath'] = $rootpath;
		} else
			trigger_error("Must configure at least one rootpath, check the <a href=\"docs\" target=\"_blank\">documentation</a> for more info.", FATAL);
	}

	$fileFactory =& new FileFactory($mcImageManagerConfig, $rootpath);
	$rootFile =& $fileFactory->getFile($rootpath);
	if (!$rootFile->exists())
		trigger_error("Could not find the defined root path.", FATAL);

	$_SESSION['mc_imagemanager_lastpath'] = is_file($path) ? dirname($path) : $path;

	// Invalid path, use root path
	if (!$fileFactory->verifyPath($path))
		$path = $rootpath;

	$targetFile =& $fileFactory->getFile($path);

	// Check if it's exits use root instead
	if (!$targetFile->exists()) {
		$targetFile = $rootFile;
		$dropcache = true;
	}

	if ($targetFile->isFile()) {
		$anchor = basename($path);
		$path = $targetFile->getParent();
		$targetFile =& $targetFile->getParentFile();
	} else
		$anchor = "none";

	$config = $targetFile->getConfig();
	$rootconfig = $rootFile->getConfig();
	addFileEventListeners($fileFactory);
	$imageutils = new $config['thumbnail'];

	// Save away path
	$_SESSION['mc_imagebrowser_lastpath'] = $path;
	$selectedPath = getUserFriendlyPath($path);

	// Get rest of input
	$action = getRequestParam("action");
	$value = getRequestParam("value", "");
	$formname = getRequestParam("formname", "");
	$elementnames = getRequestParam("elementnames", "");
	$isGD = $imageutils->_canEdit;

	$data = array();
	$data['rootpath'] = $rootpath;
	$data['category_dropdown'] = false;
	$data['rdirList'] = $config["filesystem.rootpaths"];
	
	if (count(array_keys($data['rdirList'])) > 1)
		$data['category_dropdown'] = true;

	if (isset($_SESSION['dropdown_rootpath']) && $_SESSION['dropdown_rootpath'] != $rootpath)
		$dropcache = true;

	// Cache stuff, we need to have cache cause dirlist can be really big. Or new rootpath
	if ($dropcache != false || (isset($_SESSION['dropdown_rootpath']))) {
		unset($_SESSION['dropdown']);
		unset($_SESSION['dropdown_rootpath']);
	}

	if (($config['dropdown.cache'] == true) && (isset($_SESSION['dropdown'])) && ($dropcache == false)) {
		$dirList = unserialize($_SESSION['dropdown']);
	} else {
		// Get filtered dirs, deep
		$fileFilter =& new BasicFileFilter();
		$fileFilter->setIncludeDirectoryPattern($rootconfig['filesystem.include_directory_pattern']);
		$fileFilter->setExcludeDirectoryPattern($rootconfig['filesystem.exclude_directory_pattern']);
		$fileFilter->setOnlyDirs(true);

		$treeHandler =& new ConfigFilteredFileTreeHandler();
		$treeHandler->setOnlyDirs(true);

		$rootFile->listTree($treeHandler);
		$dirsFiltered =& $treeHandler->getFileArray();
		// end

		if (!is_array($dirsFiltered))
			$dirsFiltered = array();

		$dirs = array();
		// End filter run

		$dirconfig = "";
		$dirList = array();
		$evenDir = true;
		
		foreach($dirsFiltered as $dir) {
			$dirconfig = $dir->getConfig();

			if (($dirconfig['dropdown.exclude_path_pattern']) && (preg_match($dirconfig['dropdown.exclude_path_pattern'], getUserFriendlyPath($dir->getAbsolutePath())))) {
				continue;
			}

			if (($dirconfig['dropdown.include_path_pattern']) && (!preg_match($dirconfig['dropdown.include_path_pattern'], getUserFriendlyPath($dir->getAbsolutePath())))) {
				continue;
			}

			$dirItem = array();
			
			$dirPath = $dir->getAbsolutePath();
			$dirItem['even'] = $evenDir;
			$dirItem['abs_path'] = $dirPath;
			$dirItem['path'] = getUserFriendlyPath($dirPath);

			$evenDir = !$evenDir;
			$dirList[] = $dirItem;
		}

		if (($config['dropdown.cache'] == true) && (!isset($_SESSION['dropdown']))) {
			$_SESSION['dropdown'] = serialize($dirList);
		}
	}

	if ($config['dropdown.cache'] == true)
		$_SESSION['dropdown_rootpath'] = $rootpath;

	// Check so that we have the current folder in the list, or its screwed.
	$valid_folder = false;
	foreach($dirList as $dirListItem) {
		if ($targetFile->getAbsolutePath() == $dirListItem['abs_path']) {
			$valid_folder = true;
			break;
		}
	}

	// Dir is not in droplist, use first one or root if the first one is gone too
	if ($valid_folder == false) {
		if (count($dirList) > 0) {
			$targetFile =& $fileFactory->getFile($dirList[0]['abs_path']);
			if (!$targetFile->exists())
				$targetFile = $rootFile;

			// Grab new config
			$config = $targetFile->getConfig();
		} else {
			$dirItem = array();
			$dirItem['even'] = false;
			$dirItem['abs_path'] = $targetFile->getAbsolutePath();
			$dirItem['path'] = getUserFriendlyPath($targetFile->getAbsolutePath());

			$dirList[] = $dirItem;
		}
	}


	$dirsFiltered = array();

	// Get filtered files
	$fileFilter =& new BasicFileFilter();
	$fileFilter->setIncludeDirectoryPattern($config['filesystem.include_directory_pattern']);
	$fileFilter->setExcludeDirectoryPattern($config['filesystem.exclude_directory_pattern']);
	$fileFilter->setIncludeFilePattern($config['filesystem.include_file_pattern']);
	$fileFilter->setExcludeFilePattern($config['filesystem.exclude_file_pattern']);
	$fileFilter->setIncludeExtensions($config['filesystem.extensions']);
	$fileFilter->setOnlyFiles(true);
	$files =& $targetFile->listFilesFiltered($fileFilter);

	$fileList = array();
	$even = true;

// List files
	foreach ($files as $file) {
		if ($file->isDirectory())
			continue;

		$fileItem = array();
		$imageSize = array();
		$filepath = $file->getAbsolutePath();
		$fileItem['margin'] = 0;

		$imageSize = getimagesize($file->getAbsolutePath());
		$fileItem['real_width'] = $imageSize[0] ? $imageSize[0] : 0;
		$fileItem['real_height'] = $imageSize[1] ? $imageSize[1] : 0;

		// calculate percentage width and height
		if ($config['thumbnail.scale_mode'] == "percentage") {
			if ($config['thumbnail.height'] > $config['thumbnail.width'])
				$target = $config['thumbnail.width'];
			else
				$target = $config['thumbnail.height'];

			$imageSize = imageResize($imageSize[0], $imageSize[1], $target);

			$fileItem['width'] = $imageSize['width'];
			$fileItem['height'] = $imageSize['height'];

			// Calculate margin
			if (($config['thumbnail.height'] - $imageSize['height']) > 0)
				$fileItem['margin'] = (($config['thumbnail.height'] - $imageSize['height']) / 2);
	
		} else {
			$fileItem['width'] = $config['thumbnail.width'];
			$fileItem['height'] = $config['thumbnail.height'];
		}

		$fileItem['name'] = basename($file->getAbsolutePath());
		$fileItem['path'] = $file->getAbsolutePath();
		$fileItem['modificationdate'] = date($config['filesystem.datefmt'], $file->lastModified());
		$fileItem['even'] = $even;
		$fileItem['hasReadAccess'] = $file->canRead() && checkBool($config["filesystem.readable"]) ? "true" : "false";
		$fileItem['hasWriteAccess'] = $file->canWrite() && checkBool($config["filesystem.writable"]) ? "true" : "false";

		// File info
		$fileType = getFileType($file->getAbsolutePath());
		$fileItem['icon'] = $fileType['icon'];
		$fileItem['type'] = $fileType['type'];
		$fileItem['ext'] = $fileType['ext'];
		$fileItem['editable'] = $isGD && ($fileType['ext'] == "gif" || $fileType['ext'] == "jpg" || $fileType['ext'] == "jpeg" || $fileType['ext'] == "png");

		// Preview path
		$wwwroot = removeTrailingSlash(toUnixPath(getWWWRoot($config)));
		$urlprefix = removeTrailingSlash(toUnixPath($config['preview.urlprefix']));
		$urlsuffix = toUnixPath($config['preview.urlsuffix']);

		$fileItem['previewurl'] = "";
		$pos = strpos($filepath, $wwwroot);
		if ($pos !== false && $pos == 0)
			$fileItem['previewurl'] = $urlprefix . substr($filepath, strlen($wwwroot)) . $urlsuffix;
		else
			$fileItem['previewurl'] = "ERROR IN PATH";

		if (($fileItem['editable'] == true) AND (checkBool($config['thumbnail.gd.enabled']) == true))
			$fileItem['url'] = "thumbnail.php?path=". $fileItem['path'] ."&width=". $fileItem['width'] ."&height=". $fileItem['height'] ."&ext=". $fileItem['ext'];
		else
			$fileItem['url'] = $fileItem['previewurl'];

		$even = !$even;
		$fileList[] = $fileItem;
	}

	$data['files'] = $fileList;
	$data['path'] = $path;
	$data['hasReadAccess'] = $targetFile->canRead() && checkBool($config["filesystem.readable"]) ? "true" : "false";
	$data['hasWriteAccess'] = $targetFile->canWrite() && checkBool($config["filesystem.writable"]) ? "true" : "false";

	$toolbarCommands = explode(',', $config['general.toolbar']);
	$tools = array();
	foreach ($toolbarCommands as $command) {
		foreach ($toolbar as $tool) {
			if ($tool['command'] == $command)
				$tools[] = $tool;
		}
	}

	$imageTools = array();
	$imageTools = explode(',', $config['thumbnail.image_tools']);

	$information = array();
	$information = explode(',', $config['thumbnail.information']);

	$data['js'] = getRequestParam("js", "");
	$data['formname'] = getRequestParam("formname", "");
	$data['elementnames'] = getRequestParam("elementnames", "");
	$data['disabled_tools'] = $config['general.disabled_tools'];
	$data['image_tools'] = $imageTools;
	$data['toolbar'] = $tools;
	$data['full_path'] = $path;
	$data['root_path'] = $rootpath;
	$data['errorMsg'] = "dfdf"; //addslashes($errorMsg);
	$data['selectedPath'] = $selectedPath;
	$data['dirlist'] = $dirList;
	$data['anchor'] = $anchor;
	$data['exif_support'] = exifExists();
	$data['gd_support'] = $isGD;
	$data['edit_enabled'] = checkBool($config["thumbnail.gd.enabled"]);
	$data['demo'] = checkBool($config["general.demo"]);
	$data['demo_msg'] = $config["general.demo_msg"];
	$data['information'] = $information;
	$data['extension_image'] = checkBool($config["thumbnail.extension_image"]);
	$data['insert'] = checkBool($config["thumbnail.insert"]);
	$data['filemanager_urlprefix'] = removeTrailingSlash($config["filemanager.urlprefix"]);
	$data['thumbnail_width'] = $config['thumbnail.width'];
	$data['thumbnail_height'] = $config['thumbnail.height'];
	$data['thumbnail_border_style'] = $config['thumbnail.border_style'];
	$data['thumbnail_margin_around'] = $config['thumbnail.margin_around'];

	renderPage("images.tpl.php", $data);
?>