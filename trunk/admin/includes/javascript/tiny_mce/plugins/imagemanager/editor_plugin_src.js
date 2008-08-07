// Setup file_browser_callback option
function TinyMCE_imagemanager_initInstance(inst) {
	inst.settings['file_browser_callback'] = 'mcImageManager.filebrowserCallBack';
};

function TinyMCE_imagemanager_getInfo() {
	return {
		longname : 'MCImageManager PHP',
		author : 'Moxiecode Systems',
		authorurl : 'http://tinymce.moxiecode.com',
		infourl : 'http://tinymce.moxiecode.com/paypal/item_imagemanager.php',
		version : "2.0"
	};
};

function TinyMCE_imagemanager_getTinyMCEBaseURL() {
	var nl, i, src;

	if (!tinyMCE.baseURL) {
		nl = document.getElementsByTagName('script');
		for (i=0; i<nl.length; i++) {
			src = "" + nl[i].src;

			if (/(tiny_mce\.js|tiny_mce_dev\.js|tiny_mce_gzip)/.test(src))
				return src = src.substring(0, src.lastIndexOf('/'));
		}
	}

	return tinyMCE.baseURL;
};

// Load mcimagemanager.js script
if (typeof(mcImageManager) == "undefined")
	document.write('<sc'+'ript language="javascript" type="text/javascript" src="' + TinyMCE_imagemanager_getTinyMCEBaseURL() + '/plugins/imagemanager/jscripts/mcimagemanager.js"></script>');
