<?php
/**
 * createdir.php
 *
 * @package MCImageManager.pages
 * @author Moxiecode
 * @copyright Copyright © 2005-2006, Moxiecode Systems AB, All rights reserved.
 */

	require_once("includes/general.php");
	require_once("classes/FileSystems/FileFactory.php");
	require_once("classes/FileSystems/LocalFileImpl.php");

	$data = array();
	verifyAccess($mcImageManagerConfig);
	$path = getRequestParam("path", toUnixPath(getRealPath($mcImageManagerConfig, 'filesystem.path')));
	$rootpath = getRequestParam("rootpath", toUnixPath(getRealPath($mcImageManagerConfig, 'filesystem.rootpath')));
	$action = getRequestParam("action", "");
	$dirname = getRequestParam("dirname", false);
	$template = getRequestParam("template", "");
	$fileFactory =& new FileFactory($mcImageManagerConfig, $rootpath);
	$targetFile =& $fileFactory->getFile($path);
	$config = $targetFile->getConfig();

	addFileEventListeners($fileFactory);

	$data['path'] = $path;
	$data['short_path'] = getUserFriendlyPath($path, 30);
	$data['full_path'] = getUserFriendlyPath($path);
	$data['dirname'] = $dirname;
	$data['template'] = $template;
	$data['errorMsg'] = "";
	$data['demo'] = checkBool($config['general.demo']) ? "true" : "false";
	$data['demo_msg'] = $config['general.demo_msg'];
	$data['forceDirectoryTemplate'] = checkBool($config['filesystem.force_directory_template']);
	$data['dir_path'] = "";

	$templates = explode(',', $config['filesystem.directory_templates']);
	$data['templates'] = array();
	foreach ($templates as $templateName) {
		if ($templateName != "")
			$data['templates'][basename($templateName)] = $templateName;
	}

	if (checkBool($config['filesystem.force_directory_template']) && count(array_keys($data['templates'])) == 0 && $template == "") {
		$data['errorMsg'] = "When option filesystem.force_directory_template set to true then the filesystem.directory_templates can not be empty.";
		renderPage("createdir.tpl.php", $data);
	}

	// Do action
	if ($action == "submit") {
		if (!$targetFile->canWrite())
			trigger_error("Write access is denied by filesystem, check that PHP has write access to the directory.", ERROR);
	
		if (!checkBool($config["filesystem.writable"]))
			trigger_error("Write access is denied by configuration (filesystem.writable).", ERROR);

		// Do nothing in demo mode
		if (checkBool($config['general.demo']))
			trigger_error($config['general.demo_msg'], ERROR);

		// No access, tool disabled
		if (in_array("createdir", explode(',', $config['general.disabled_tools'])))
			trigger_error("You don't have access to perform the requested action.", ERROR);

		// Do nothing in demo mode
		if (checkBool($config['general.demo']))
			trigger_error($config['general.demo_msg'], ERROR);

		// No dirname specified
		if (!$dirname) {
			$data['errorMsg'] = "error_missing_name";
			renderPage("createdir.tpl.php", $data);
		}

		// No template selected
		if ((!$template && count(array_keys($templates)) > 1) && checkBool($config['filesystem.force_directory_template'])) {
			$data['errorMsg'] = "error_invalid_template_selection";
			renderPage("createdir.tpl.php", $data);
		}

		// Only one template and forced, use that one
		if (count(array_keys($templates)) == 1 && $template == "" && checkBool($config['filesystem.force_directory_template'])) {
			$keys = array_keys($templates);
			$template = $templates[$keys[0]];
		}

		// No template defined, use first template
/*		$keys = array_keys($data['templates']);
		if (!$template && count($keys) > 0)
			$template = $data['templates'][$keys[0]];*/

		if ($template != "") {
			$templateFile =& $fileFactory->getFile($template);
			if (!$templateFile->exists() || $template == "" || $template === false) {
				$data['errorMsg'] = "error_template_not_found";
				renderPage("createdir.tpl.php", $data);
			}
		}

		$file =& $fileFactory->getFile($path, $dirname, MC_IS_DIRECTORY);

		// Hmm, it looks strange, deny ;,:,\,/,>,< characters
		if (preg_match('/[;\\\\\\/:><]/i', $dirname) > 0) {
			$data['errorMsg'] = "error_invalid_name";
			renderPage("createdir.tpl.php", $data);
		}

		// Setup first filter
		$fileFilterA =& new BasicFileFilter();
		$fileFilterA->setIncludeDirectoryPattern($config['filesystem.include_directory_pattern']);
		$fileFilterA->setExcludeDirectoryPattern($config['filesystem.exclude_directory_pattern']);
		if (!$fileFilterA->accept($file)) {
			$data['errorMsg'] = $config['filesystem.invalid_directory_name_msg'];
			renderPage("createdir.tpl.php", $data);
		}

		// Setup second filter
		$fileFilterB =& new BasicFileFilter();
		$fileFilterB->setIncludeDirectoryPattern($config['createdir.include_directory_pattern']);
		$fileFilterB->setExcludeDirectoryPattern($config['createdir.exclude_directory_pattern']);
		if (!$fileFilterB->accept($file)) {
			$data['errorMsg'] = $config['createdir.invalid_directory_name_msg'];
			renderPage("createdir.tpl.php", $data);
		}

		if ($file->exists()) {
			$data['errorMsg'] = "error_exists";
			renderPage("createdir.tpl.php", $data);
		}

		if ($template != "" && $templateFile->exists())
			$templateFile->copyTo($file);
		else
			$file->mkdir();

		$data['dir_path'] = $file->getAbsolutePath();
	}

	// Render output
	renderPage("createdir.tpl.php", $data);
?>
