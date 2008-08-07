<?php
/* -----------------------------------------------------------------------------------------
    $Id: vam_wysiwyg_tiny.inc.php 923 2007-02-07 10:51:57 VaM $
   
   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (fckconfig.inc.php,v 1.4 2003/08/13); www.nextcommerce.org 
   (c) 2004 xt:Commerce (vam_wysiwyg.inc.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
---------------------------------------------------------------------------------------*/

function vam_wysiwyg_tiny($type, $lang, $langID = '') {

$js_src = DIR_WS_INCLUDES .'javascript/tiny_mce/tiny_mce.js';

	switch($type) {
                // WYSIWYG editor latest news textarea named latest_news
                case 'latest_news':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
tinyMCE.init({
		mode : "none",
      editor_deselector : "notinymce",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,paste,preview,searchreplace,print",
      elements : "ajaxfilemanager",
      file_browser_callback : "ajaxfilemanager",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup",
	   theme_advanced_container_top2 : "outdent,indent,bullist,numlist,separator,charmap,hr,visualaid,image,separator,link,unlink,anchor,separator,tablecontrols",
	   theme_advanced_container_top3 : "styleselect,formatselect,separator,fontselect,fontsizeselect",
	   theme_advanced_container_top4 : "print,emotions,iespell,flash,advhr,fullscreen,ltr,rtl,forecolor,backcolor",
	   theme_advanced_container_top1_class : "mceToolbarTop",
	   theme_advanced_container_top2_class : "mceToolbarTop",
	   theme_advanced_container_top3_class : "mceToolbarTop",
	   theme_advanced_container_top4_class : "mceToolbarTop",
	   theme_advanced_container_mceElementpath_class : "mcePathBottom",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
	   theme_advanced_resize_horizontal : true,
	   theme_advanced_resizing : true,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   convert_urls : false,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					ajaxfilemanagerurl += "?type=img";
					break;
				case "media":
					ajaxfilemanagerurl += "?type=media";
					break;
				case "flash": //for older versions of tinymce
					ajaxfilemanagerurl += "?type=media";
					break;
				case "file":
					ajaxfilemanagerurl += "?type=files";
					break;
				default:
					return false;
			}
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;
		}	
		
function toggleHTMLEditor(id) {
  var elm = document.getElementById(id);

  if (tinyMCE.getInstanceById(id) == null) {
    tinyMCE.execCommand("mceAddControl", false, id);
  } else {
    tinyMCE.execCommand("mceRemoveControl", false, id);
  }
}
                        	   	</script>';
                        break;

                // WYSIWYG editor faq textarea named faq
                case 'faq':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
tinyMCE.init({
		mode : "none",
      editor_deselector : "notinymce",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,paste,preview,searchreplace,print",
      elements : "ajaxfilemanager",
      file_browser_callback : "ajaxfilemanager",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup",
	   theme_advanced_container_top2 : "outdent,indent,bullist,numlist,separator,charmap,hr,visualaid,image,separator,link,unlink,anchor,separator,tablecontrols",
	   theme_advanced_container_top3 : "styleselect,formatselect,separator,fontselect,fontsizeselect",
	   theme_advanced_container_top4 : "print,emotions,iespell,flash,advhr,fullscreen,ltr,rtl,forecolor,backcolor",
	   theme_advanced_container_top1_class : "mceToolbarTop",
	   theme_advanced_container_top2_class : "mceToolbarTop",
	   theme_advanced_container_top3_class : "mceToolbarTop",
	   theme_advanced_container_top4_class : "mceToolbarTop",
	   theme_advanced_container_mceElementpath_class : "mcePathBottom",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
	   theme_advanced_resize_horizontal : true,
	   theme_advanced_resizing : true,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   convert_urls : false,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					ajaxfilemanagerurl += "?type=img";
					break;
				case "media":
					ajaxfilemanagerurl += "?type=media";
					break;
				case "flash": //for older versions of tinymce
					ajaxfilemanagerurl += "?type=media";
					break;
				case "file":
					ajaxfilemanagerurl += "?type=files";
					break;
				default:
					return false;
			}
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;
		}	
		
function toggleHTMLEditor(id) {
  var elm = document.getElementById(id);

  if (tinyMCE.getInstanceById(id) == null) {
    tinyMCE.execCommand("mceAddControl", false, id);
  } else {
    tinyMCE.execCommand("mceRemoveControl", false, id);
  }
}
                        	   	</script>';
                        break;

                // WYSIWYG editor latest news textarea named articles_description
                case 'articles_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
tinyMCE.init({
		mode : "none",
      editor_deselector : "notinymce",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,paste,preview,searchreplace,print",
      elements : "ajaxfilemanager",
      file_browser_callback : "ajaxfilemanager",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup",
	   theme_advanced_container_top2 : "outdent,indent,bullist,numlist,separator,charmap,hr,visualaid,image,separator,link,unlink,anchor,separator,tablecontrols",
	   theme_advanced_container_top3 : "styleselect,formatselect,separator,fontselect,fontsizeselect",
	   theme_advanced_container_top4 : "print,emotions,iespell,flash,advhr,fullscreen,ltr,rtl,forecolor,backcolor",
	   theme_advanced_container_top1_class : "mceToolbarTop",
	   theme_advanced_container_top2_class : "mceToolbarTop",
	   theme_advanced_container_top3_class : "mceToolbarTop",
	   theme_advanced_container_top4_class : "mceToolbarTop",
	   theme_advanced_container_mceElementpath_class : "mcePathBottom",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
	   theme_advanced_resize_horizontal : true,
	   theme_advanced_resizing : true,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   convert_urls : false,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					ajaxfilemanagerurl += "?type=img";
					break;
				case "media":
					ajaxfilemanagerurl += "?type=media";
					break;
				case "flash": //for older versions of tinymce
					ajaxfilemanagerurl += "?type=media";
					break;
				case "file":
					ajaxfilemanagerurl += "?type=files";
					break;
				default:
					return false;
			}
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;
		}	
		
function toggleHTMLEditor(id) {
  var elm = document.getElementById(id);

  if (tinyMCE.getInstanceById(id) == null) {
    tinyMCE.execCommand("mceAddControl", false, id);
  } else {
    tinyMCE.execCommand("mceRemoveControl", false, id);
  }
}
                        	   	</script>';
                        break;

                // WYSIWYG editor latest news textarea named topics_description
                case 'topics_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
tinyMCE.init({
		mode : "none",
      editor_deselector : "notinymce",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,paste,preview,searchreplace,print",
      elements : "ajaxfilemanager",
      file_browser_callback : "ajaxfilemanager",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup",
	   theme_advanced_container_top2 : "outdent,indent,bullist,numlist,separator,charmap,hr,visualaid,image,separator,link,unlink,anchor,separator,tablecontrols",
	   theme_advanced_container_top3 : "styleselect,formatselect,separator,fontselect,fontsizeselect",
	   theme_advanced_container_top4 : "print,emotions,iespell,flash,advhr,fullscreen,ltr,rtl,forecolor,backcolor",
	   theme_advanced_container_top1_class : "mceToolbarTop",
	   theme_advanced_container_top2_class : "mceToolbarTop",
	   theme_advanced_container_top3_class : "mceToolbarTop",
	   theme_advanced_container_top4_class : "mceToolbarTop",
	   theme_advanced_container_mceElementpath_class : "mcePathBottom",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
	   theme_advanced_resize_horizontal : true,
	   theme_advanced_resizing : true,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   convert_urls : false,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					ajaxfilemanagerurl += "?type=img";
					break;
				case "media":
					ajaxfilemanagerurl += "?type=media";
					break;
				case "flash": //for older versions of tinymce
					ajaxfilemanagerurl += "?type=media";
					break;
				case "file":
					ajaxfilemanagerurl += "?type=files";
					break;
				default:
					return false;
			}
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;
		}	
		
function toggleHTMLEditor(id) {
  var elm = document.getElementById(id);

  if (tinyMCE.getInstanceById(id) == null) {
    tinyMCE.execCommand("mceAddControl", false, id);
  } else {
    tinyMCE.execCommand("mceRemoveControl", false, id);
  }
}
                        	   	</script>';
                        break;

                // WYSIWYG editor products description textarea named products_description
                case 'products_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
tinyMCE.init({
		mode : "none",
      editor_deselector : "notinymce",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,paste,preview,searchreplace,print",
      elements : "ajaxfilemanager",
      file_browser_callback : "ajaxfilemanager",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup",
	   theme_advanced_container_top2 : "outdent,indent,bullist,numlist,separator,charmap,hr,visualaid,image,separator,link,unlink,anchor,separator,tablecontrols",
	   theme_advanced_container_top3 : "styleselect,formatselect,separator,fontselect,fontsizeselect",
	   theme_advanced_container_top4 : "print,emotions,iespell,flash,advhr,fullscreen,ltr,rtl,forecolor,backcolor",
	   theme_advanced_container_top1_class : "mceToolbarTop",
	   theme_advanced_container_top2_class : "mceToolbarTop",
	   theme_advanced_container_top3_class : "mceToolbarTop",
	   theme_advanced_container_top4_class : "mceToolbarTop",
	   theme_advanced_container_mceElementpath_class : "mcePathBottom",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
	   theme_advanced_resize_horizontal : true,
	   theme_advanced_resizing : true,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   convert_urls : false,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					ajaxfilemanagerurl += "?type=img";
					break;
				case "media":
					ajaxfilemanagerurl += "?type=media";
					break;
				case "flash": //for older versions of tinymce
					ajaxfilemanagerurl += "?type=media";
					break;
				case "file":
					ajaxfilemanagerurl += "?type=files";
					break;
				default:
					return false;
			}
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;
		}	
		
function toggleHTMLEditor(id) {
  var elm = document.getElementById(id);

  if (tinyMCE.getInstanceById(id) == null) {
    tinyMCE.execCommand("mceAddControl", false, id);
  } else {
    tinyMCE.execCommand("mceRemoveControl", false, id);
  }
}
                        	   	</script>';
                        break;

                // WYSIWYG editor products short description textarea named products_short_description
                case 'products_short_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
tinyMCE.init({
		mode : "none",
      editor_deselector : "notinymce",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,paste,preview,searchreplace,print",
      elements : "ajaxfilemanager",
      file_browser_callback : "ajaxfilemanager",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup",
	   theme_advanced_container_top2 : "outdent,indent,bullist,numlist,separator,charmap,hr,visualaid,image,separator,link,unlink,anchor,separator,tablecontrols",
	   theme_advanced_container_top3 : "styleselect,formatselect,separator,fontselect,fontsizeselect",
	   theme_advanced_container_top4 : "print,emotions,iespell,flash,advhr,fullscreen,ltr,rtl,forecolor,backcolor",
	   theme_advanced_container_top1_class : "mceToolbarTop",
	   theme_advanced_container_top2_class : "mceToolbarTop",
	   theme_advanced_container_top3_class : "mceToolbarTop",
	   theme_advanced_container_top4_class : "mceToolbarTop",
	   theme_advanced_container_mceElementpath_class : "mcePathBottom",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
	   theme_advanced_resize_horizontal : true,
	   theme_advanced_resizing : true,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   convert_urls : false,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					ajaxfilemanagerurl += "?type=img";
					break;
				case "media":
					ajaxfilemanagerurl += "?type=media";
					break;
				case "flash": //for older versions of tinymce
					ajaxfilemanagerurl += "?type=media";
					break;
				case "file":
					ajaxfilemanagerurl += "?type=files";
					break;
				default:
					return false;
			}
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;
		}	
		
function toggleHTMLEditor(id) {
  var elm = document.getElementById(id);

  if (tinyMCE.getInstanceById(id) == null) {
    tinyMCE.execCommand("mceAddControl", false, id);
  } else {
    tinyMCE.execCommand("mceRemoveControl", false, id);
  }
}
                        	   	</script>';
                        break;

                // WYSIWYG editor content manager
                case 'content_manager':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
tinyMCE.init({
		mode : "none",
      editor_deselector : "notinymce",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,paste,preview,searchreplace,print",
      elements : "ajaxfilemanager",
      file_browser_callback : "ajaxfilemanager",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup",
	   theme_advanced_container_top2 : "outdent,indent,bullist,numlist,separator,charmap,hr,visualaid,image,separator,link,unlink,anchor,separator,tablecontrols",
	   theme_advanced_container_top3 : "styleselect,formatselect,separator,fontselect,fontsizeselect",
	   theme_advanced_container_top4 : "print,emotions,iespell,flash,advhr,fullscreen,ltr,rtl,forecolor,backcolor",
	   theme_advanced_container_top1_class : "mceToolbarTop",
	   theme_advanced_container_top2_class : "mceToolbarTop",
	   theme_advanced_container_top3_class : "mceToolbarTop",
	   theme_advanced_container_top4_class : "mceToolbarTop",
	   theme_advanced_container_mceElementpath_class : "mcePathBottom",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
	   theme_advanced_resize_horizontal : true,
	   theme_advanced_resizing : true,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   convert_urls : false,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					ajaxfilemanagerurl += "?type=img";
					break;
				case "media":
					ajaxfilemanagerurl += "?type=media";
					break;
				case "flash": //for older versions of tinymce
					ajaxfilemanagerurl += "?type=media";
					break;
				case "file":
					ajaxfilemanagerurl += "?type=files";
					break;
				default:
					return false;
			}
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;
		}	
		
function toggleHTMLEditor(id) {
  var elm = document.getElementById(id);

  if (tinyMCE.getInstanceById(id) == null) {
    tinyMCE.execCommand("mceAddControl", false, id);
  } else {
    tinyMCE.execCommand("mceRemoveControl", false, id);
  }
}
                        	   	</script>';
                        break;

                // WYSIWYG editor products content manager
                case 'products_content':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
tinyMCE.init({
		mode : "none",
      editor_deselector : "notinymce",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,paste,preview,searchreplace,print",
      elements : "ajaxfilemanager",
      file_browser_callback : "ajaxfilemanager",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup",
	   theme_advanced_container_top2 : "outdent,indent,bullist,numlist,separator,charmap,hr,visualaid,image,separator,link,unlink,anchor,separator,tablecontrols",
	   theme_advanced_container_top3 : "styleselect,formatselect,separator,fontselect,fontsizeselect",
	   theme_advanced_container_top4 : "print,emotions,iespell,flash,advhr,fullscreen,ltr,rtl,forecolor,backcolor",
	   theme_advanced_container_top1_class : "mceToolbarTop",
	   theme_advanced_container_top2_class : "mceToolbarTop",
	   theme_advanced_container_top3_class : "mceToolbarTop",
	   theme_advanced_container_top4_class : "mceToolbarTop",
	   theme_advanced_container_mceElementpath_class : "mcePathBottom",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
	   theme_advanced_resize_horizontal : true,
	   theme_advanced_resizing : true,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   convert_urls : false,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					ajaxfilemanagerurl += "?type=img";
					break;
				case "media":
					ajaxfilemanagerurl += "?type=media";
					break;
				case "flash": //for older versions of tinymce
					ajaxfilemanagerurl += "?type=media";
					break;
				case "file":
					ajaxfilemanagerurl += "?type=files";
					break;
				default:
					return false;
			}
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;
		}	
		
function toggleHTMLEditor(id) {
  var elm = document.getElementById(id);

  if (tinyMCE.getInstanceById(id) == null) {
    tinyMCE.execCommand("mceAddControl", false, id);
  } else {
    tinyMCE.execCommand("mceRemoveControl", false, id);
  }
}
                        	   	</script>';
                        break;

                // WYSIWYG editor categories description
                case 'categories_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
tinyMCE.init({
		mode : "none",
      editor_deselector : "notinymce",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,paste,preview,searchreplace,print",
      elements : "ajaxfilemanager",
      file_browser_callback : "ajaxfilemanager",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup",
	   theme_advanced_container_top2 : "outdent,indent,bullist,numlist,separator,charmap,hr,visualaid,image,separator,link,unlink,anchor,separator,tablecontrols",
	   theme_advanced_container_top3 : "styleselect,formatselect,separator,fontselect,fontsizeselect",
	   theme_advanced_container_top4 : "print,emotions,iespell,flash,advhr,fullscreen,ltr,rtl,forecolor,backcolor",
	   theme_advanced_container_top1_class : "mceToolbarTop",
	   theme_advanced_container_top2_class : "mceToolbarTop",
	   theme_advanced_container_top3_class : "mceToolbarTop",
	   theme_advanced_container_top4_class : "mceToolbarTop",
	   theme_advanced_container_mceElementpath_class : "mcePathBottom",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
	   theme_advanced_resize_horizontal : true,
	   theme_advanced_resizing : true,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   convert_urls : false,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					ajaxfilemanagerurl += "?type=img";
					break;
				case "media":
					ajaxfilemanagerurl += "?type=media";
					break;
				case "flash": //for older versions of tinymce
					ajaxfilemanagerurl += "?type=media";
					break;
				case "file":
					ajaxfilemanagerurl += "?type=files";
					break;
				default:
					return false;
			}
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;
		}	
		
function toggleHTMLEditor(id) {
  var elm = document.getElementById(id);

  if (tinyMCE.getInstanceById(id) == null) {
    tinyMCE.execCommand("mceAddControl", false, id);
  } else {
    tinyMCE.execCommand("mceRemoveControl", false, id);
  }
}
                        	   	</script>';
                        break;

                // WYSIWYG editor newsletter
                case 'newsletter':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
tinyMCE.init({
		mode : "none",
      editor_deselector : "notinymce",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,paste,preview,searchreplace,print",
      elements : "ajaxfilemanager",
      file_browser_callback : "ajaxfilemanager",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup",
	   theme_advanced_container_top2 : "outdent,indent,bullist,numlist,separator,charmap,hr,visualaid,image,separator,link,unlink,anchor,separator,tablecontrols",
	   theme_advanced_container_top3 : "styleselect,formatselect,separator,fontselect,fontsizeselect",
	   theme_advanced_container_top4 : "print,emotions,iespell,flash,advhr,fullscreen,ltr,rtl,forecolor,backcolor",
	   theme_advanced_container_top1_class : "mceToolbarTop",
	   theme_advanced_container_top2_class : "mceToolbarTop",
	   theme_advanced_container_top3_class : "mceToolbarTop",
	   theme_advanced_container_top4_class : "mceToolbarTop",
	   theme_advanced_container_mceElementpath_class : "mcePathBottom",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
	   theme_advanced_resize_horizontal : true,
	   theme_advanced_resizing : true,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   convert_urls : false,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					ajaxfilemanagerurl += "?type=img";
					break;
				case "media":
					ajaxfilemanagerurl += "?type=media";
					break;
				case "flash": //for older versions of tinymce
					ajaxfilemanagerurl += "?type=media";
					break;
				case "file":
					ajaxfilemanagerurl += "?type=files";
					break;
				default:
					return false;
			}
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;
		}	
		
function toggleHTMLEditor(id) {
  var elm = document.getElementById(id);

  if (tinyMCE.getInstanceById(id) == null) {
    tinyMCE.execCommand("mceAddControl", false, id);
  } else {
    tinyMCE.execCommand("mceRemoveControl", false, id);
  }
}
                        	   	</script>';
                        break;

                // WYSIWYG editor newsletter
                case 'mail':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
tinyMCE.init({
		mode : "none",
      editor_deselector : "notinymce",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,paste,preview,searchreplace,print",
      elements : "ajaxfilemanager",
      file_browser_callback : "ajaxfilemanager",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup",
	   theme_advanced_container_top2 : "outdent,indent,bullist,numlist,separator,charmap,hr,visualaid,image,separator,link,unlink,anchor,separator,tablecontrols",
	   theme_advanced_container_top3 : "styleselect,formatselect,separator,fontselect,fontsizeselect",
	   theme_advanced_container_top4 : "print,emotions,iespell,flash,advhr,fullscreen,ltr,rtl,forecolor,backcolor",
	   theme_advanced_container_top1_class : "mceToolbarTop",
	   theme_advanced_container_top2_class : "mceToolbarTop",
	   theme_advanced_container_top3_class : "mceToolbarTop",
	   theme_advanced_container_top4_class : "mceToolbarTop",
	   theme_advanced_container_mceElementpath_class : "mcePathBottom",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
	   theme_advanced_resize_horizontal : true,
	   theme_advanced_resizing : true,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   convert_urls : false,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					ajaxfilemanagerurl += "?type=img";
					break;
				case "media":
					ajaxfilemanagerurl += "?type=media";
					break;
				case "flash": //for older versions of tinymce
					ajaxfilemanagerurl += "?type=media";
					break;
				case "file":
					ajaxfilemanagerurl += "?type=files";
					break;
				default:
					return false;
			}
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;
		}	
		
function toggleHTMLEditor(id) {
  var elm = document.getElementById(id);

  if (tinyMCE.getInstanceById(id) == null) {
    tinyMCE.execCommand("mceAddControl", false, id);
  } else {
    tinyMCE.execCommand("mceRemoveControl", false, id);
  }
}
                        	   	</script>';
                        break;

                // WYSIWYG editor gift voucher
                case 'gv_mail':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
tinyMCE.init({
		mode : "none",
      editor_deselector : "notinymce",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,paste,preview,searchreplace,print",
      elements : "ajaxfilemanager",
      file_browser_callback : "ajaxfilemanager",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup",
	   theme_advanced_container_top2 : "outdent,indent,bullist,numlist,separator,charmap,hr,visualaid,image,separator,link,unlink,anchor,separator,tablecontrols",
	   theme_advanced_container_top3 : "styleselect,formatselect,separator,fontselect,fontsizeselect",
	   theme_advanced_container_top4 : "print,emotions,iespell,flash,advhr,fullscreen,ltr,rtl,forecolor,backcolor",
	   theme_advanced_container_top1_class : "mceToolbarTop",
	   theme_advanced_container_top2_class : "mceToolbarTop",
	   theme_advanced_container_top3_class : "mceToolbarTop",
	   theme_advanced_container_top4_class : "mceToolbarTop",
	   theme_advanced_container_mceElementpath_class : "mcePathBottom",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
	   theme_advanced_resize_horizontal : true,
	   theme_advanced_resizing : true,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name|style],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   convert_urls : false,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					ajaxfilemanagerurl += "?type=img";
					break;
				case "media":
					ajaxfilemanagerurl += "?type=media";
					break;
				case "flash": //for older versions of tinymce
					ajaxfilemanagerurl += "?type=media";
					break;
				case "file":
					ajaxfilemanagerurl += "?type=files";
					break;
				default:
					return false;
			}
			var fileBrowserWindow = new Array();
			fileBrowserWindow["file"] = ajaxfilemanagerurl;
			fileBrowserWindow["title"] = "Ajax File Manager";
			fileBrowserWindow["width"] = "782";
			fileBrowserWindow["height"] = "440";
			fileBrowserWindow["close_previous"] = "no";
			tinyMCE.openWindow(fileBrowserWindow, {
			  window : win,
			  input : field_name,
			  resizable : "yes",
			  inline : "yes",
			  editor_id : tinyMCE.getWindowArg("editor_id")
			});
			
			return false;
		}	
		
function toggleHTMLEditor(id) {
  var elm = document.getElementById(id);

  if (tinyMCE.getInstanceById(id) == null) {
    tinyMCE.execCommand("mceAddControl", false, id);
  } else {
    tinyMCE.execCommand("mceRemoveControl", false, id);
  }
}
                        	   	</script>';
                        break;

    }
    
   	return $val;

}
?>