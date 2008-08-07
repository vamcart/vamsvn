// Some global instances
var tinymce = null, tinyMCEPopup, tinyMCE;

tinyMCEPopup = {
	init : function() {
		var t = this, w = t.getWin(), ti;

		// Find API
		tinymce = w.tinymce;
		tinyMCE = w.tinyMCE;
		t.editor = tinymce.EditorManager.activeEditor;
		t.params = t.editor.windowManager.params;

		// Setup local DOM
		t.dom = t.editor.windowManager.createInstance('tinymce.dom.DOMUtils', document);
		t.dom.loadCSS(t.editor.settings.popup_css);

		// Setup on init listeners
		t.listeners = [];
		t.onInit = {
			add : function(f, s) {
				t.listeners.push({func : f, scope : s});
			}
		};

		t.isWindow = !t.getWindowArg('mce_inline');
		t.id = t.getWindowArg('mce_window_id');
		t.editor.windowManager.onOpen.dispatch(t.editor.windowManager, window);
	},

	getWin : function() {
		return window.dialogArguments || opener || parent || top;
	},

	getWindowArg : function(n, dv) {
		var v = this.params[n];

		return tinymce.is(v) ? v : dv;
	},

	getParam : function(n, dv) {
		return this.editor.getParam(n, dv);
	},

	getLang : function(n, dv) {
		return this.editor.getLang(n, dv);
	},

	execCommand : function(cmd, ui, val) {
		this.restoreSelection();
		return this.editor.execCommand(cmd, ui, val);
	},

	resizeToInnerSize : function() {
		var t = this, n, b = document.body, vp = t.dom.getViewPort(window), dw, dh;

		dw = t.getWindowArg('mce_width') - vp.w;
		dh = t.getWindowArg('mce_height') - vp.h;

		if (t.isWindow)
			window.resizeBy(dw, dh);
		else
			t.editor.windowManager.resizeBy(dw, dh, t.id);
	},

	executeOnLoad : function(s) {
		this.onInit.add(function() {
			eval(s);
		});
	},

	storeSelection : function() {
		this.editor.windowManager.bookmark = tinyMCEPopup.editor.selection.getBookmark('simple');
	},

	restoreSelection : function() {
		var t = tinyMCEPopup;

		if (!t.isWindow && tinymce.isIE)
			t.editor.selection.moveToBookmark(t.editor.windowManager.bookmark);
	},

	requireLangPack : function() {
		var u = this.getWindowArg('plugin_url') || this.getWindowArg('theme_url');

		if (u)
			document.write('<script type="text/javascript" src="' + u + '/langs/' + this.editor.settings.language + '_dlg.js' + '"></script>');
	},

	pickColor : function(e, element_id) {
		this.execCommand('mceColorPicker', true, {
			color : document.getElementById(element_id).value,
			func : function(c) {
				document.getElementById(element_id).value = c;

				if (tinymce.is(document.getElementById(element_id).onchange, 'function'))
					document.getElementById(element_id).onchange();
			}
		});
	},

	openBrowser : function(element_id, type, option) {
		tinyMCEPopup.restoreSelection();
		this.editor.execCallback('file_browser_callback', element_id, document.getElementById(element_id).value, type, window);
	},

	close : function() {
		var t = this;

		t.dom = t.dom.doc = null; // Cle