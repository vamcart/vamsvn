/**
 * mcimagemanager.js
 *
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 *
 * This file is to be included on all you pages that integrate with the mcimagemanager.
 */

function MCImageManager() {
	// Internal fields
	this.settings = new Array();
	this.inTinyMCE = false;
	this.callerWindow = null;

	// Get document base directory path
	baseDir = document.location.href;
	if (baseDir.indexOf('?') != -1)
		baseDir = baseDir.substring(0, baseDir.indexOf('?'));

	baseDir = baseDir.substring(0, baseDir.lastIndexOf('/') + 1);
	this.documentBasePath = baseDir;

	// Default URL options
	this.settings["document_base_url"] = unescape(baseDir);
	this.settings["relative_urls"] = false;
	this.settings["remove_script_host"] = false;
	this.settings["session_id"] = "";
	this.settings["path"] = "mce_clear";
	this.settings["rootpath"] = "mce_clear";
	this.settings["remember_last_path"] = true;
};

MCImageManager.prototype.getScriptPath = function() {
	var elements = document.getElementsByTagName('script');
	var baseDir = this.documentBasePath;

	for (var i=0; i<elements.length; i++) {
		if (elements[i].src && (elements[i].src.indexOf("mcimagemanager.js") != -1 || elements[i].src.indexOf("mcimagemanager_src.js") != -1)) {
			var src = elements[i].src;
			src = this.convertRelativeToAbsoluteURL(baseDir, src.substring(0, src.lastIndexOf('/')));

			return src;
		}
	}

	return null;
};

MCImageManager.prototype.init = function(settings) {
	for (var n in settings)
		this.settings[n] = settings[n];
};

MCImageManager.prototype.getParam = function(name, default_value) {
	var value = null;

	if (this.callSettings && typeof(this.callSettings[name]) != "undefined")
		value = this.callSettings[name];
	else
		value = (typeof(this.settings[name]) == "undefined") ? default_value : this.settings[name];

	// Fix bool values
	if (value == "true" || value == "false")
		return (value == "true");

	return value;
};

MCImageManager.prototype.openInIframe = function(iframe_id, form_name, element_names, file_url, js, settings) {
	if (typeof(settings) == "undefined")
		settings = new Array();

	settings['iframe'] = iframe_id;

	this.open(form_name, element_names, file_url, js, settings);
};

/**
 * Opens the dialog.
 */
MCImageManager.prototype.open = function(form_name, element_names, file_url, js, settings) {
	var doc;

	this.callSettings = settings;

	if (this.callerWindow != null && (typeof(settings) != "undefined" && settings['is_callback']))
		doc = this.callerWindow.document;
	else
		doc = document;

	var url = this.getScriptPath() + "/../images.php?a=b";
	var isMSIE = (navigator.appName == "Microsoft Internet Explorer");

	if (typeof(element_names) != "undefined") {
		// Poll url from field
		if (typeof(file_url) == "undefined" || file_url == '' || file_url == null) {
			if (element_names.indexOf(',') == -1)
				file_url = doc.forms[form_name].elements[element_names].value;
		}

		// Form url JS func
		this.targetForm = form_name;
		this.targetElementNames = element_names;

		if (typeof(js) == "undefined" || js == "")
			url += "&js=mcImageManager.insertFileToForm";
	}

	if (typeof(file_url) != "undefined" && file_url) {
		var pos, absUrl;

		absUrl = this.convertRelativeToAbsoluteURL(this.settings['document_base_url'], file_url);

		// Trim away HTTP
		if ((pos = absUrl.indexOf('://')) != -1) {
			absUrl = absUrl.substring(pos + 3);

			if ((pos = absUrl.indexOf('/')) != -1)
				absUrl = absUrl.substring(pos);
		}

		url += "&url=" + escape(absUrl);
	}

	if (typeof(js) != "undefined" && js)
		url += "&js=" + escape(js);

	url += "&initial_path=" + escape(this.getParam("path"));
	url += "&initial_rootpath=" + escape(this.getParam("rootpath"));
	url += "&remember=" + escape(this.getParam("remember_last_path") ? "true" : "false");

	if (this.getParam("custom_data") != "")
		url += "&custom_data=" + escape(this.getParam("custom_data"));

	if (this.getParam('session_id') != "")
		url += "&sessionid=" + escape(this.getParam('session_id'));
/*
	if (file_url)
		url += "#f_" + file_url.substring(file_url.lastIndexOf('/') + 1);
*/
	var width = 750;
	var height = 450;
	var x = parseInt(screen.width / 2.0) - (width / 2.0);
	var y = parseInt(screen.height / 2.0) - (height / 2.0);

	if (isMSIE) {
		// Pesky MSIE + XP SP2
		width += 15;
		height += 35;
	}

	if ((iframeID = this.getParam("iframe", "")) != "") {
		ife = document.getElementById(iframeID);
		ife.contentWindow.document.location = url;
	} else {
		var win = window.open(url, "MCImageManager", "top=" + y + ",left=" + x + ",scrollbars=no,width=" + width + ",height=" + height + ",resizable=yes");
		if (win == null) {
			alert('Sorry, but we have noticed that your popup-blocker has disabled a window that provides application functionality. You will need to disable popup blocking on this site in order to fully utilize this tool.');
			return;
		}

		try {
			win.focus();
		} catch (e) {
		}
	}
};

MCImageManager.prototype.filebrowserCallBack = function(field_name, url, type, win) {
	var s;

	// Is file manager included, use that one on files
	if (typeof(mcFileManager) != "undefined" && type == "file") {
		mcFileManager.filebrowserCallBack(field_name, url, type, win);
		return;
	}

	// Convert URL to absolute
	url = tinyMCE.convertRelativeToAbsoluteURL(tinyMCE.settings['base_href'], url);

	// Save away
	this.field = field_name;
	this.callerWindow = win;
	this.inTinyMCE = true;

	// Setup instance specific settings
	s = {
		path : tinyMCE.getParam("imagemanager_path"),
		rootpath : tinyMCE.getParam("imagemanager_rootpath"),
		remember_last_path : tinyMCE.getParam("imagemanager_remember_last_path"),
		custom_data : tinyMCE.getParam("imagemanager_custom_data"),
		is_callback : true
	};

	// Open browser
	this.open(0, field_name, url, "mcImageManager.insertFileToTinyMCE", s);
};

MCImageManager.prototype.insertFileToTinyMCE = function(url) {
	if (this.inTinyMCE) {
		var url;

		// Handle old and new style
		if (typeof(TinyMCE_convertURL) != "undefined")
			url = TinyMCE_convertURL(url, null, true);
		else
			url = tinyMCE.convertURL(url, null, true);

		// Set URL
		this.callerWindow.document.forms[0].elements[this.field].value = url;

		// Try to fire the onchange event
		try {
			this.callerWindow.document.forms[0].elements[this.field].onchange();
		} catch (e) {
			// Skip it
		}
	}
};

MCImageManager.prototype.insertFileToForm = function(url) {
	var elements = this.targetElementNames.split(',');
	var relURLs = this.getParam("relative_urls");

	// Remove proto and host
	if (this.getParam("remove_script_host") || relURLs)
		url = this.removeHost(url);

	// Convert to relative
	if (relURLs)
		url = this.convertAbsoluteURLToRelativeURL(this.removeHost(this.getParam("document_base_url")), url);

	// Set URL to all form fields
	for (var i=0; i<elements.length; i++) {
		var elm = document.forms[this.targetForm].elements[elements[i]];

		if (elm && typeof elm != "undefined")
			elm.value = url;

		// Try to fire the onchange event
		try {
			elm.onchange();
		} catch (e) {
			// Skip it
		}
	}
};

MCImageManager.prototype.removeHost = function(url) {
	var pos = url.indexOf('://');

	if (pos != -1) {
		pos = url.indexOf('/', pos + 3);
		url = url.substring(pos);
	}

	return url;
};

/**
 * Parses a URL in to its diffrent components.
 */
MCImageManager.prototype.parseURL = function(url_str) {
	var urlParts = new Array();

	if (url_str) {
		var pos, lastPos;

		// Parse protocol part
		pos = url_str.indexOf('://');
		if (pos != -1) {
			urlParts['protocol'] = url_str.substring(0, pos);
			lastPos = pos + 3;
		}

		// Find port or path start
		for (var i=lastPos; i<url_str.length; i++) {
			var chr = url_str.charAt(i);

			if (chr == ':')
				break;

			if (chr == '/')
				break;
		}
		pos = i;

		// Get host
		urlParts['host'] = url_str.substring(lastPos, pos);

		// Get port
		lastPos = pos;
		if (url_str.charAt(pos) == ':') {
			pos = url_str.indexOf('/', lastPos);
			urlParts['port'] = url_str.substring(lastPos+1, pos);
		}

		// Get path
		lastPos = pos;
		pos = url_str.indexOf('?', lastPos);

		if (pos == -1)
			pos = url_str.indexOf('#', lastPos);

		if (pos == -1)
			pos = url_str.length;

		urlParts['path'] = url_str.substring(lastPos, pos);

		// Get query
		lastPos = pos;
		if (url_str.charAt(pos) == '?') {
			pos = url_str.indexOf('#');
			pos = (pos == -1) ? url_str.length : pos;
			urlParts['query'] = url_str.substring(lastPos+1, pos);
		}

		// Get anchor
		lastPos = pos;
		if (url_str.charAt(pos) == '#') {
			pos = url_str.length;
			urlParts['anchor'] = url_str.substring(lastPos+1, pos);
		}

		return urlParts;
	}

	return {path : '', port : '', host : '', query : '', anchor : ''};
};

/**
 * Converts an absolute path to relative path.
 */
MCImageManager.prototype.convertAbsoluteURLToRelativeURL = function(base_url, url_to_relative) {
	var strTok1;
	var strTok2;
	var breakPoint = 0;
	var outputString = "";

	// Crop away last path part
	base_url = base_url.substring(0, base_url.lastIndexOf('/'));
	strTok1 = base_url.split('/');
	strTok2 = url_to_relative.split('/');

	if (strTok1.length >= strTok2.length) {
		for (var i=0; i<strTok1.length; i++) {
			if (i >= strTok2.length || strTok1[i] != strTok2[i]) {
				breakPoint = i + 1;
				break;
			}
		}
	}

	if (strTok1.length < strTok2.length) {
		for (var i=0; i<strTok2.length; i++) {
			if (i >= strTok1.length || strTok1[i] != strTok2[i]) {
				breakPoint = i + 1;
				break;
			}
		}
	}

	if (breakPoint == 1)
		return url_to_relative;

	for (var i=0; i<(strTok1.length-(breakPoint-1)); i++)
		outputString += "../";

	for (var i=breakPoint-1; i<strTok2.length; i++) {
		if (i != (breakPoint-1))
			outputString += "/" + strTok2[i];
		else
			outputString += strTok2[i];
	}

	return outputString;
};

MCImageManager.prototype.convertRelativeToAbsoluteURL = function(base_url, relative_url) {
	var baseURL = this.parseURL(base_url);
	var relURL = this.parseURL(relative_url);

	if (relative_url == "" || relative_url.charAt(0) == '/' || relative_url.indexOf('://') != -1 || relative_url.indexOf('mailto:') != -1 || relative_url.indexOf('javascript:') != -1 || relative_url.replace(/[ \t\r\n\+]|%20/, '', 'g').charAt(0) == "#")
		return relative_url;

	// Split parts
	baseURLParts = baseURL['path'].split('/');
	relURLParts = relURL['path'].split('/');

	// Remove empty chunks
	var newBaseURLParts = new Array();
	for (var i=baseURLParts.length-1; i>=0; i--) {
		if (baseURLParts[i].length == 0)
			continue;

		newBaseURLParts[newBaseURLParts.length] = baseURLParts[i];
	}
	baseURLParts = newBaseURLParts.reverse();

	// Merge relURLParts chunks
	var newRelURLParts = new Array();
	var numBack = 0;
	for (var i=relURLParts.length-1; i>=0; i--) {
		if (relURLParts[i].length == 0 || relURLParts[i] == ".")
			continue;

		if (relURLParts[i] == '..') {
			numBack++;
			continue;
		}

		if (numBack > 0) {
			numBack--;
			continue;
		}

		newRelURLParts[newRelURLParts.length] = relURLParts[i];
	}

	relURLParts = newRelURLParts.reverse();

	// Remove end from absolute path
	var len = baseURLParts.length-numBack;
	var absPath = (len <= 0 ? "" : "/") + baseURLParts.slice(0, len).join('/') + "/" + relURLParts.join('/');
	var start = "", end = "";

	// Build start part
	if (baseURL['protocol'])
		start += baseURL['protocol'] + "://";

	if (baseURL['host'])
		start += baseURL['host'];

	if (baseURL['port'])
		start += ":" + baseURL['port'];

	// Build end part
	if (relURL['query'])
		end += "?" + relURL['query'];

	if (relURL['anchor'])
		end += "#" + relURL['anchor'];

	// Re-add trailing slash if it's removed
	if (relative_url.charAt(relative_url.length-1) == "/")
		end += "/";

	return start + absPath + end;
};

// Global instance
var mcImageManager = new MCImageManager();
