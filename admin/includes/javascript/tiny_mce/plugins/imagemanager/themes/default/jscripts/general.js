/**
 * general.js
 *
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

function autoResize() {
	var isMSIE = (navigator.appName == "Microsoft Internet Explorer");
	var isOpera = (navigator.userAgent.indexOf("Opera") != -1);

	if (isOpera)
		return;

	if (isMSIE) {
		window.resizeTo(10, 10);

		var elm = document.body;
		var width = elm.offsetWidth;
		var height = elm.offsetHeight;
		var dx = (elm.scrollWidth - width) + 4;
		var dy = elm.scrollHeight - height;

		window.resizeBy(dx, dy);
	} else {
		window.scrollBy(1000, 1000);
		if (window.scrollX > 0 || window.scrollY > 0) {
			window.resizeBy(window.innerWidth * 2, window.innerHeight * 2);
			window.sizeToContent();
			window.scrollTo(0, 0);
			var x = parseInt(screen.width / 2.0) - (window.outerWidth / 2.0);
			var y = parseInt(screen.height / 2.0) - (window.outerHeight / 2.0);
			window.moveTo(x, y);
		}
	}
}

function switchClass(element_id, class_name) {
	var element = document.getElementById(element_id);
	if (element != null && !element.classLock) {
		element.oldClassName = element.className;
		element.className = class_name;
	}
}

function restoreClass(element_id) {
	var element = document.getElementById(element_id);
	if (element != null && element.oldClassName && !element.classLock) {
		element.className = element.oldClassName;
		element.oldClassName = null;
	}
}

function setClassLock(element_id, lock_state) {
	var element = document.getElementById(element_id);
	if (element != null)
		element.classLock = lock_state;
}

// Due to some stange MSIE bug this script was needed
function fixImagesBug() {
	var isMSIE = (navigator.appName == "Microsoft Internet Explorer");

	if (isMSIE) {
		var elements = document.getElementsByTagName("img");

		for (var i=0; i<elements.length; i++) {
			if (!elements[i].complete)
				elements[i].src = elements[i].src;
		}
	}
}

function cleanFileName(filename) {
	var outfile = "";

	for (var i=0; i<filename.length; i++) {
		var chr = filename.charAt(i).toLowerCase();

		if (chr == ' ')
			chr = "_";

		if (chr == '\xE5' || chr == '\xE4')
			chr = "a";

		if (chr == '\xF6')
			chr = "o";

		if (chr == ' ')
			chr = "_";

		if ((chr >= 'a' && chr <= 'z') || (chr >= '0' && chr <= '9') || chr == "_" || chr == ".")
			outfile += chr;
	}

	return outfile;
}

function openPop(url, width, height, scroll) {
	var isMSIE = (navigator.appName == "Microsoft Internet Explorer");
	var x = parseInt(screen.width / 2.0) - (width / 2.0);
	var y = parseInt(screen.height / 2.0) - (height / 2.0);

	if (typeof(scroll) == "undefined")
		scroll = "no";

	if (isMSIE) {
		// Pesky MSIE + XP SP2
		width += 15;
		height += 35;

		//var features = "resizable:no;scroll:no;status:no;center:yes;help:no;dialogWidth:" + width + "px;dialogHeight:" + height + "px;";
		//window.showModalDialog(url, window, features);
	}

	var win = window.open(url, "MCImageManagerPopup", "top=" + y + ",left=" + x + ",scrollbars="+ scroll +",modal=yes,width=" + width + ",height=" + height + ",resizable=yes");
	win.focus();
}

function openImageEditor(path) {
	width = 680;
	height = 540;

	if (parseFloat(navigator.appVersion) >= 4.0) {
		pos_x = parseInt(screen.width / 2.0) - (width / 2.0);
		pos_y = parseInt(screen.height / 2.0) - (height / 2.0);
	}

	var win = window.open('edit_image.php?path=' + escape(path), "mcCropTool" + width + "x" + height, "width=" + width + ",height=" + height + ",left=" + pos_x + ",top=" + pos_y + ",resizable=no,scrollbars=no");
	try {
		win.focus();
		win.moveTo(pos_x, pos_y);
	} catch (e) {
		// Could I care less!!
	}
}

// Fix for DIVs with scroll:auto
if (window.addEventListener) {
	window.addEventListener("load", function() {
		var divs = document.getElementsByTagName("div");
		for (var i=0; i<divs.length; i++) {
			divs[i].addEventListener('DOMMouseScroll', function(e) {
				var st = e.currentTarget.scrollTop + (e.detail * 12);

				e.currentTarget.scrollTop = st < 0 ? 0 : st;
				e.preventDefault();				
			}, false);
		}
	}, false);
}

function insertURL(url) {
	var win, close = false;

	if (window.opener) {
		win = window.opener;
		close = true;
	} else
		win = parent;

	// Crop away query
	if ((pos = url.indexOf('?')) != -1)
		url = url.substring(0, url.indexOf('?'));

	// Handle custom js call
	if (win && js != "") {
		eval("win." + js + "(url);");

		if (close)
			top.close();

		return;
	}

	// Handle form item call
	if (win && formname != "") {
		var elements = elementnames.split(',');

		for (var i=0; i<elements.length; i++) {
			var elm = win.document.forms[formname].elements[elements[i]];
			if (elm && typeof elm != "undefined")
				elm.value = url;
		}

		if (close)
			top.close();
	}

	if (close)
		top.close();
} 

function selectPath(select) {
	var value = select.options[select.selectedIndex].value;
	document.location.href = "images.php?path="+ escape(value) +"&formname="+ formname +"&elementnames="+ elementnames + "&js="+ js +"";
}

function imagePreview(width, height, path) {
	if (width < 200)
		width = 200;

	if (height < 200)
		height = 200;

	openPop("preview.php?path="+ escape(path), width, height, "yes");
}

function imageDelete(filename, del_path) {
	if (!demo) {
		if (confirm(deleteConfirm)) {
			ajax.get("ajax.php?action=delete&path="+ escape(full_path) +"&file_01="+ escape(del_path) +"&filename="+ escape(filename), imageDeleteCallback);
			//document.location.href = "images.php?action=delete&path="+ full_path +"&file_01="+ del_path +"&formname="+ formname +"&elementnames="+ elementnames + "&js="+ js +"&time="+ new Date().getTime();
		}
		else
			return;
	} else
		alert(demo_msg);
}

function checkAjaxError(xml) {
	var er = xml.getElementsByTagName("error");
	var title, msg, str;

	str = "";

	if (er && er.length > 0) {
		title = er[0].getAttribute("title");
		msg = er[0].getAttribute("msg")
		if (title != "")
			str += title + "\n\n";

		str += msg;

		alert(str);
		return false;
	}
	return true;
}

function imageDeleteCallback(xml) {
	if (!checkAjaxError(xml))
		return;

	var name, path, status, msg;

	var nl = xml.getElementsByTagName("file");
	for (i=0; i<nl.length; i++) {
		name = nl[i].getAttribute("filename");
		path = nl[i].getAttribute("path");
		status = nl[i].getAttribute("status");
		thumbnail = nl[i].getAttribute("thumbnail");

		if (status == "true") {
			var ielm = document.getElementById("th_"+ name);
			ielm.parentNode.removeChild(ielm);
		}
	}
}

function imageEdit(path) {
	if (!hasWriteAccess) {
		alert(editNoWriteAccess);
		return;
	}

	if (path != "")
		openImageEditor(path);
}

function gotoAnchor(anchor) {
	if ((typeof(anchor) != "undefined") || (anchor != ""))
		document.location.href = "#f_"+ anchor +"";
}

function getImageData(name, path) {
	var parent = document.getElementById("th_"+ name);
	var imgdiv = document.getElementById("imginfo");
	var loadinfo = document.getElementById("loadinfo");
	var infowrap = document.getElementById("infowrap");

	moveDivTo(imgdiv, getAbsPosition(parent).absLeft+1, getAbsPosition(parent).absTop+20);

	if (current == name) {
		imgdiv.style.display = 'block';
		return;
	} else {
		current = name;
		imgdiv.style.display = 'none';
	}

	// Get data
	infowrap.style.display = 'none';
	loadinfo.style.display = 'block';
	imgdiv.style.display = 'block';
	ajax.get("ajax.php?action=info&path="+ path, showImageData);
}

function showImageData(xml) {
	var i;
	var imgdiv = document.getElementById("imginfo");
	var loadinfo = document.getElementById("loadinfo");
	var infowrap = document.getElementById("infowrap");

	if (!checkAjaxError(xml))
		return;

	infowrap.style.display = 'block';
	loadinfo.style.display = 'none';

	var nl = xml.getElementsByTagName("img");

	var welm = document.getElementById("img_width");
	var helm = document.getElementById("img_height");
	var telm = document.getElementById("img_type");
	var sielm = document.getElementById("img_size");
	var scelm = document.getElementById("img_scale");

	if (welm)
		welm.innerHTML = "&nbsp;";

	if (helm)
		helm.innerHTML = "&nbsp;";

	if (telm)
		telm.innerHTML = "&nbsp;";

	if (sielm)
		sielm.innerHTML = "&nbsp;";

	if (scelm)
		scelm.innerHTML = "&nbsp;";

	for (i=0; i<nl.length; i++) {
		if (welm)
			welm.innerHTML = nl[i].getAttribute("width") ? nl[i].getAttribute("width") +" px" : "n/a";
		
		if (helm)
			helm.innerHTML = nl[i].getAttribute("height") ? nl[i].getAttribute("height") +" px" : "n/a";
		
		if (telm)
			telm.innerHTML = nl[i].getAttribute("type").toUpperCase();

		if (sielm)
			sielm.innerHTML = nl[i].getAttribute("size");

		if (scelm)
			scelm.innerHTML = nl[i].getAttribute("scale") + "%";

		if (nl[i].getAttribute("name") != current)
			return;
	}

	imgdiv.style.display = 'block';
}

function hideImageData(name) {
	var imgdiv = document.getElementById("imginfo");
	imgdiv.style.display = 'none';
}

function getAbsPosition(n) {
	var p = {absLeft : 0, absTop : 0};

	while (n) {
		p.absLeft += n.offsetLeft;
		p.absTop += n.offsetTop;
		n = n.offsetParent;
	}

	return p;
}

function moveDivTo(n, x, y) {

	var elm = document.getElementById("thwrapperdiv");

	n.style.left = (x - elm.scrollLeft) + "px";
	n.style.top = (y - elm.scrollTop) + "px";

	// window.status = "X: " + x + ", Y: " + y;
}