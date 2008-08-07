<?php
	/* *
	 * Default configuration.
	 *
	 */

	// Include your custom classes here
	// require_once("classes/Plugins/ExampleAuthenticatorImpl.class.php");

	// Setup the config array
	$mcImageManagerConfig = array();

	// General options
	$mcImageManagerConfig['general.demo'] = false;
	$mcImageManagerConfig['general.demo_msg'] = "This application is running in demostration mode, this action is restricted.";
	$mcImageManagerConfig['general.theme'] = "default";
	$mcImageManagerConfig['general.language'] = "en";
	$mcImageManagerConfig['general.toolbar'] = "createdir,upload,refresh";
	$mcImageManagerConfig['general.user_friendly_paths'] = true;
	$mcImageManagerConfig['general.disabled_tools'] = "";
	$mcImageManagerConfig['general.error_log'] = false;
	$mcImageManagerConfig['general.debug'] = false;
	$mcImageManagerConfig['general.login_page'] = "login.php";
	$mcImageManagerConfig['general.allow_override'] = "disabled_tools";

	// Preview options
	$mcImageManagerConfig['preview'] = true;
	$mcImageManagerConfig['preview.wwwroot'] = "";
	$mcImageManagerConfig['preview.urlprefix'] = "http://" . $_SERVER['HTTP_HOST'] . "/";
	$mcImageManagerConfig['preview.urlsuffix'] = "";
	$mcImageManagerConfig['preview.allow_override'] = "*";

	// Create directory options
	$mcImageManagerConfig['createdir.include_directory_pattern'] = '';
	$mcImageManagerConfig['createdir.exclude_directory_pattern'] = '/[^a-z0-9_]/';
	$mcImageManagerConfig['createdir.invalid_directory_name_msg'] = "Error: The name of the directory is invalid.";
	$mcImageManagerConfig['createdir.allow_override'] = "*";

	// General filesystem options
	$mcImageManagerConfig['filesystem'] = "LocalFileImpl";
	$mcImageManagerConfig['filesystem.path'] = "images";
	$mcImageManagerConfig['filesystem.rootpath'] = "images";
	$mcImageManagerConfig['filesystem.datefmt'] = "Y-m-d H:i";
	$mcImageManagerConfig['filesystem.include_directory_pattern'] = '';
	$mcImageManagerConfig['filesystem.exclude_directory_pattern'] = '';
	$mcImageManagerConfig['filesystem.invalid_directory_name_msg'] = "Error: The name of the directory is invalid.";
	$mcImageManagerConfig['filesystem.include_file_pattern'] = '/\.jpg$|\.gif$|\.png$/i';
	$mcImageManagerConfig['filesystem.exclude_file_pattern'] = '/([^a-zA-Z0-9_\-\.]|^mcic_)/i';
	$mcImageManagerConfig['filesystem.invalid_file_name_msg'] = "Error: The name of the file is invalid.";
	$mcImageManagerConfig['filesystem.extensions'] = "gif,jpg,png,bmp";
	$mcImageManagerConfig['filesystem.invalid_extension_msg'] = "Error: The extension of the file is invalid.";
	$mcImageManagerConfig['filesystem.file_event_listeners'] = "";
	$mcImageManagerConfig['filesystem.readable'] = "true";
	$mcImageManagerConfig['filesystem.writable'] = "true";
	$mcImageManagerConfig['filesystem.delete_recursive'] = "false";
	$mcImageManagerConfig['filesystem.directory_templates'] = "";
	$mcImageManagerConfig['filesystem.force_directory_template'] = false;
	$mcImageManagerConfig['filesystem.allow_override'] = "*";

	// Dropdown filter pattern
	$mcImageManagerConfig['dropdown.include_path_pattern'] = '';
	$mcImageManagerConfig['dropdown.exclude_path_pattern'] = '';
	$mcImageManagerConfig['dropdown.cache'] = false;

	// Thumbnail options
	$mcImageManagerConfig['thumbnail'] = "ImageToolsGD";
	$mcImageManagerConfig['thumbnail.extension_image'] = true;
	$mcImageManagerConfig['thumbnail.width'] = "150"; // px
	$mcImageManagerConfig['thumbnail.height'] = "150"; // px
	$mcImageManagerConfig['thumbnail.scale_mode'] = "percentage"; // percentage,resize
	$mcImageManagerConfig['thumbnail.margin_around'] = "5"; // px
	$mcImageManagerConfig['thumbnail.border_style'] = "1px solid #CCCCCC";
	$mcImageManagerConfig['thumbnail.image_tools'] = "preview,info,delete,e2dit";
	$mcImageManagerConfig['thumbnail.insert'] = true;
	$mcImageManagerConfig['thumbnail.information'] = "width,height,type,size,scale";
	$mcImageManagerConfig['thumbnail.use_exif'] = false;
	$mcImageManagerConfig['thumbnail.allow_override'] = "*";

	// Thumbnail generation with GD options
	$mcImageManagerConfig['thumbnail.gd.enabled'] = false;
	$mcImageManagerConfig['thumbnail.gd.auto_generate'] = true;
	$mcImageManagerConfig['thumbnail.gd.folder'] = "mcith";
	$mcImageManagerConfig['thumbnail.gd.prefix'] = "mcith_";
	$mcImageManagerConfig['thumbnail.gd.delete'] = true;
	$mcImageManagerConfig['thumbnail.gd.jpeg_quality'] = 75;
	$mcImageManagerConfig['thumbnail.gd.allow_override'] = "*";

	// Upload options
	$mcImageManagerConfig['upload.maxsize'] = "10MB";
	$mcImageManagerConfig['upload.include_file_pattern'] = '';
	$mcImageManagerConfig['upload.exclude_file_pattern'] = '/\.php$|\.shtm$/i';
	$mcImageManagerConfig['upload.invalid_file_name_msg'] = "Error: The file name is invalid, only a-z, 0-9 and _ characters are allowed.";
	$mcImageManagerConfig['upload.extensions'] = "gif,jpg,png,bmp";
	$mcImageManagerConfig['upload.invalid_extension_msg'] = "Error: Invalid extension: Valid extensions are: gif,jpg,png,bmp.";
	$mcImageManagerConfig['upload.create_thumbnail'] = false;
	$mcImageManagerConfig['upload.allow_override'] = "*";

	// Authenication with Session
	$mcImageManagerConfig['authenticator'] = "BaseAuthenticator";
	$mcImageManagerConfig['authenticator.session.logged_in_key'] = "isLoggedIn";
	$mcImageManagerConfig['authenticator.session.groups_key'] = "groups";
	$mcImageManagerConfig['authenticator.allow_override'] = "*";

	// Local filesystem options
	$mcImageManagerConfig['filesystem.local.access_file_name'] = "mc_access";
	$mcImageManagerConfig['filesystem.local.file_mask'] = "";
	$mcImageManagerConfig['filesystem.local.directory_mask'] = "";
	$mcImageManagerConfig['filesystem.local.file_owner'] = "";
	$mcImageManagerConfig['filesystem.local.directory_owner'] = "";
	$mcImageManagerConfig['filesystem.local.allow_override'] = "*";

	// Filemanager configuration
	$mcImageManagerConfig['filemanager.urlprefix'] = "../filemanager";

?>