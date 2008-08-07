<?php
	require_once("includes/general.php");
	require_once("classes/FileSystems/LocalFileImpl.php");

	/**
	 * Calls the mcError class, returns true.
	 *
	 * @param Int $errno Number of the error.
	 * @param String $errstr Error message.
	 * @param String $errfile The file the error occured in.
	 * @param String $errline The line in the file where error occured.
	 * @param Array $errcontext Error context array, contains all variables.
	 * @return Bool Just return true for now.
	 */
	function mcErrorHandlerXML($errno, $errstr, $errfile, $errline, $errcontext) {
		global $mcImageManagerConfig;
		$data = array();

		// Just pass it through	to the class.
		$mcErr = new mcError($mcImageManagerConfig['general.error_log']);
		$data = $mcErr->handleError($errno, $errstr, $errfile, $errline, $errcontext);
		
		$data['backtrace'] = array();

		if ($mcImageManagerConfig['general.debug'] == true && function_exists(debug_backtrace))
			$data['backtrace'] = debug_backtrace();

		if ($data['break'])
			displayErrorXML($errstr, "An error has occured on line ". $errline ." in ". $errfile ."");

		return true;
	}

	function displayErrorXML($title, $message) {
		die("<result><error title=\"". $title ."\" msg=\"". $message ."\" /></result>");
	}

	set_error_handler("mcErrorHandlerXML");

	verifyAccess($mcImageManagerConfig);

	header('Content-Type: text/xml');
	header('Content-Encoding: UTF-8');

	$data = "";
	$action = getRequestParam("action");
	$path = getRequestParam("path");

	switch($action) {
		case "info":
			$fileFactory =& new FileFactory($mcImageManagerConfig, $mcImageManagerConfig['filesystem.rootpath']);
			$imageFile =& $fileFactory->getFile($path);
			$config = $imageFile->getConfig();

			$imageInfo = array();
			$imageSize = getimagesize($imageFile->getAbsolutePath());
			$imageInfo['real_width'] = $imageSize[0];
			$imageInfo['real_height'] = $imageSize[1];

			if ($config['thumbnail.scale_mode'] == "percentage") {
				if ($config['thumbnail.height'] > $config['thumbnail.width'])
					$target = $config['thumbnail.width'];
				else
					$target = $config['thumbnail.height'];

				$imageSize = imageResize($imageSize[0], $imageSize[1], $target);

				$imageInfo['width'] = $imageSize['width'];
				$imageInfo['height'] = $imageSize['height'];
				$imageInfo['scale'] = $imageSize['scale'];

				// Calculate margin
				if (($config['thumbnail.height'] - $imageSize['height']) > 0)
					$imageInfo['margin'] = (($config['thumbnail.height'] - $imageSize['height']) / 2);
		
			} else {
				$imageInfo['width'] = $config['thumbnail.width'];
				$imageInfo['height'] = $config['thumbnail.height'];
				$imageInfo['scale'] = 0;
			}

			$imageInfo['name'] = basename($imageFile->getAbsolutePath());
			$imageInfo['path'] = $imageFile->getAbsolutePath();
			$imageInfo['size'] = getSizeStr($imageFile->length());

			$fileType = getFileType($imageFile->getAbsolutePath());
			$imageInfo['icon'] = $fileType['icon'];
			$imageInfo['type'] = $fileType['type'];
			$imageInfo['ext'] = $fileType['ext'];
			
			$data = '<img width="'. $imageInfo['real_width'] .'" height="'. $imageInfo['real_height'] .'" path="'. $imageInfo['path'] .'" scale="'. $imageInfo['scale'] .'" type="'. $imageInfo['type'] .'" size="'. $imageInfo['size'] .'" ext="'. $imageInfo['ext'] .'" icon="'. $imageInfo['icon'] .'" />';
		break;
		case "delete":
			$filename = getRequestParam("filename");

			$fileFactory =& new FileFactory($mcImageManagerConfig, $mcImageManagerConfig['filesystem.rootpath']);
			$imageFile =& $fileFactory->getFile($path);
			$config = $imageFile->getConfig();

			$selectedFiles = array();
			foreach ($_REQUEST as $name => $value) {
				if (strpos($name, "file_") !== false || strpos($name, "dir_") !== false)
					$selectedFiles[] =& $fileFactory->getFile($value);
			}

			// No access, tool disabled
			if (!in_array("delete", explode(',', $config['thumbnail.image_tools']))) {
				displayErrorXML("", $mcLanguage['error_delete_failed']);
			}

			if (checkBool($config['general.demo']))
				displayErrorXML("", $config['general.demo_msg']);

			$canread = false;
			$canwrite = false;
			$th_deleted = false;
			foreach ($selectedFiles as $file) {
				$canread = $file->canRead() && checkBool($config["filesystem.readable"]) ? true : false;
				$canwrite = $file->canWrite() && checkBool($config["filesystem.writable"]) ? true : false;

				if ($canwrite) {
					// Check for Thumbnail
					if ($config['thumbnail.gd.delete'] == true) {
						$th_folder = "/". $config['thumbnail.gd.folder'];
						$th_folder = dirname($file->getAbsolutePath()) . $th_folder;
						$thFolder = $fileFactory->getFile($th_folder);
						if ($thFolder->exists()) {
							$th_path = $thFolder->getAbsolutePath() . "/" . $config['thumbnail.gd.prefix'] . basename($file->getAbsolutePath());
							$th = $fileFactory->getFile($th_path);

							if ($th->exists())
								$th->delete();

							$th_deleted = true;
						}
					}
					$file->delete();
					$data .= '<file path="'. $file->getAbsolutePath() .'" status="true" thumbnail="'. $th_deleted .'" filename="'. $filename .'" />';
				}
				else {
					$data .= '<file path="'. $file->getAbsolutePath() .'" status="false" thumbnail="false" msg="' . $mcLanguage['error_no_access'] . '" filename="'. $filename .'" />';
				}
			}
		break;
	}
?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<result>
	<?php echo $data; ?>
</result>
