<?php
	// Include your custom classes here
	// require_once("classes/Plugins/ExampleAuthenticatorImpl.class.php");
	// require_once("classes/Plugins/LoggingFileEventListener.class.php");

	// General options
	$mcImageManagerConfig['general.demo'] = false;
	$mcImageManagerConfig['general.demo_msg'] = "This application is running in demostration mode, this action is restricted.";
	$mcImageManagerConfig['general.theme'] = "default";
	$mcImageManagerConfig['general.toolbar'] = "createdir,upload,refresh"; // "filemanager" button if you have "filemanager.urlprefix" configured.
	$mcImageManagerConfig['general.user_friendly_paths'] = true;
	$mcImageManagerConfig['general.disabled_tools'] = "";
	$mcImageManagerConfig['general.debug'] = false;
	$mcImageManagerConfig['general.error_log'] = "";
	$mcImageManagerConfig['general.login_page'] = "login.php";
	$mcImageManagerConfig['general.language'] = "en"; // en, sv
	$mcImageManagerConfig['general.allow_override'] = "*";

	// Preview options
	$mcImageManagerConfig['preview'] = true;
	$mcImageManagerConfig['preview.wwwroot'] = ""; // absolute or relative from this script path, try to leave blank system figures it out.
	$mcImageManagerConfig['preview.urlprefix'] = "http://" . $_SERVER['HTTP_HOST'] . "/"; // domain name
	$mcImageManagerConfig['preview.urlsuffix'] = "";
	$mcImageManagerConfig['preview.allow_override'] = "*";

	// Create directory options
	$mcImageManagerConfig['createdir.include_directory_pattern'] = '';
	$mcImageManagerConfig['createdir.exclude_directory_pattern'] = '/[^a-z0-9_]/';
	$mcImageManagerConfig['createdir.invalid_directory_name_msg'] = "Error: The name of the directory is invalid.";
	$mcImageManagerConfig['createdir.allow_override'] = "*";

	// General filesystem options
	$mcImageManagerConfig['filesystem'] = "LocalFileImpl";
	$mcImageManagerConfig['filesystem.path'] = ''; // absolute or relative from this script path, optional.
	$mcImageManagerConfig['filesystem.rootpath'] = '../../../../../../images'; // absolute or relative from this script path, required.
	$mcImageManagerConfig['filesystem.datefmt'] = "Y-m-d H:i";
	$mcImageManagerConfig['filesystem.include_directory_pattern'] = '';
	$mcImageManagerConfig['filesystem.exclude_directory_pattern'] = '/^mcith$/i';
	$mcImageManagerConfig['filesystem.invalid_directory_name_msg'] = "Error: The name of the directory is invalid.";
	$mcImageManagerConfig['filesystem.include_file_pattern'] = '/\.jpg$|\.gif$|\.png$|\.bmp$/i';
	$mcImageManagerConfig['filesystem.exclude_file_pattern'] = '/([^a-zA-Z0-9_\-\.]|^mcic_)/i';
	$mcImageManagerConfig['filesystem.invalid_file_name_msg'] = "Error: The name of the file is invalid.";
	$mcImageManagerConfig['filesystem.extensions'] = "gif,jpg,png,bmp";
	$mcImageManagerConfig['filesystem.invalid_extension_msg'] = "Error: The extension of the file is invalid.";
	$mcImageManagerConfig['filesystem.file_event_listeners'] = "";
	$mcImageManagerConfig['filesystem.readable'] = "true";
	$mcImageManagerConfig['filesystem.writable'] = "true";
	$mcImageManagerConfig['filesystem.delete_recursive'] = "false";
	$mcImageManagerConfig['filesystem.directory_template'] = "";
	$mcImageManagerConfig['filesystem.force_directory_template'] = false;
	$mcImageManagerConfig['filesystem.allow_override'] = "*";

	// Dropdown filter pattern
	$mcImageManagerConfig['dropdown.include_path_pattern'] = '';
	$mcImageManagerConfig['dropdown.exclude_path_pattern'] = '';
	$mcImageManagerConfig['dropdown.cache'] = false;

	// Thumbnail options
	$mcImageManagerConfig['thumbnail.extension_image'] = true;
	$mcImageManagerConfig['thumbnail.width'] = "150"; // px
	$mcImageManagerConfig['thumbnail.height'] = "150"; // px
	$mcImageManagerConfig['thumbnail.scale_mode'] = "percentage"; // percentage,resize
	$mcImageManagerConfig['thumbnail.margin_around'] = "5"; // px
	$mcImageManagerConfig['thumbnail.border_style'] = "1px solid #CCCCCC";
	$mcImageManagerConfig['thumbnail.image_tools'] = "preview,info,delete,edit";
	$mcImageManagerConfig['thumbnail.insert'] = true;
	$mcImageManagerConfig['thumbnail.information'] = "width,height,type,size,scale";
	$mcImageManagerConfig['thumbnail.use_exif'] = false; // use exif th if avalible
	$mcImageManagerConfig['thumbnail.allow_override'] = "*";

	// Thumbnail generation with GD options
	$mcImageManagerConfig['thumbnail.gd.enabled'] = true; // false default, verify that you have GD on your server
	$mcImageManagerConfig['thumbnail.gd.auto_generate'] = true; // only if above is set to true
	$mcImageManagerConfig['thumbnail.gd.folder'] = "mcith"; // required, exclude this folder with file pattern '/^mcith$/i' if you don't want it to show
	$mcImageManagerConfig['thumbnail.gd.prefix'] = "mcith_"; // optional
	$mcImageManagerConfig['thumbnail.gd.delete'] = true; // delete th when original is deleted
	$mcImageManagerConfig['thumbnail.gd.jpeg_quality'] = 75; // quality of th image, note that this is not checked against when regenerating ths.
	$mcImageManagerConfig['thumbnail.gd.allow_override'] = "*";

	// Upload options
	$mcImageManagerConfig['upload.maxsize'] = "10MB";
	$mcImageManagerConfig['upload.include_file_pattern'] = '';
	$mcImageManagerConfig['upload.exclude_file_pattern'] = '/\.php$|\.shtm$/i';
	$mcImageManagerConfig['upload.invalid_file_name_msg'] = "Error: The file name is invalid, only a-z, 0-9 and _ characters are allowed.";
	$mcImageManagerConfig['upload.extensions'] = "gif,jpg,png,bmp";
	$mcImageManagerConfig['upload.invalid_extension_msg'] = "Error: Invalid extension: Valid extensions are: gif,jpg,png,bmp.";
	$mcImageManagerConfig['upload.create_thumbnail'] = false; // true/false, create thumbnail on upload
	$mcImageManagerConfig['upload.allow_override'] = "*";

	// Authenication with Session
	$mcImageManagerConfig['authenticator'] = "BaseAuthenticator";
	$mcImageManagerConfig['authenticator.session.logged_in_key'] = "isLoggedIn";
	$mcImageManagerConfig['authenticator.session.groups_key'] = "groups";
	$mcImageManagerConfig['authenticator.session.user_key'] = "user";
	$mcImageManagerConfig['authenticator.allow_override'] = "*";

	// Local filesystem options
	$mcImageManagerConfig['filesystem.local.file_mask'] = ""; // 0777 for full access
	$mcImageManagerConfig['filesystem.local.directory_mask'] = ""; // 0777 for full access
	$mcImageManagerConfig['filesystem.local.access_file_name'] = "mc_access";
	$mcImageManagerConfig['filesystem.local.allow_override'] = "*";

	// Filemanager configuration
	$mcImageManagerConfig['filemanager.urlprefix'] = "./"; // meed to add "filemanager" button to toolbar as well.

	// LoggingFileEventListener plugin options
	/*
	$mcImageManagerConfig['LoggingFileEventListener.path'] = ".";
	$mcImageManagerConfig['LoggingFileEventListener.prefix'] = "mcimagemanager";
	$mcImageManagerConfig['LoggingFileEventListener.max_size'] = "100k";
	$mcImageManagerConfig['LoggingFileEventListener.max_files'] = "10";
	*/
?>