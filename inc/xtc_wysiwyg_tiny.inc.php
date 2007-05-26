<?php
/* -----------------------------------------------------------------------------------------
    $Id: xtc_wysiwyg_tiny.inc.php 923 2007-02-07 10:51:57 VaM $
   
   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (fckconfig.inc.php,v 1.4 2003/08/13); www.nextcommerce.org 
   (c) 2004 xt:Commerce (xtc_wysiwyg.inc.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
---------------------------------------------------------------------------------------*/

function xtc_wysiwyg_tiny($type, $lang, $langID = '') {

$js_src = DIR_WS_MODULES .'tiny_mce/tiny_mce.js';

	switch($type) {
                // WYSIWYG editor latest news textarea named latest_news
                case 'latest_news':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,caption,paste,preview,zoom,flash,searchreplace,print,contextmenu",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup,separator,help",
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
	   theme_advanced_resize_horizontal : false,
	   theme_advanced_resizing : false,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   paste_auto_cleanup_on_paste : true,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
	   paste_insert_word_content_callback : "convertWord",	
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
	});
                        	   	</script>';
                        break;

                // WYSIWYG editor latest news textarea named articles_description
                case 'articles_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,caption,paste,preview,zoom,flash,searchreplace,print,contextmenu",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup,separator,help",
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
	   theme_advanced_resize_horizontal : false,
	   theme_advanced_resizing : false,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   paste_auto_cleanup_on_paste : true,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
	   paste_insert_word_content_callback : "convertWord",	
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
	});
                        	   	</script>';
                        break;

                // WYSIWYG editor latest news textarea named topics_description
                case 'topics_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,caption,paste,preview,zoom,flash,searchreplace,print,contextmenu",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup,separator,help",
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
	   theme_advanced_resize_horizontal : false,
	   theme_advanced_resizing : false,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   paste_auto_cleanup_on_paste : true,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
	   paste_insert_word_content_callback : "convertWord",	
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
	});
                        	   	</script>';
                        break;

                // WYSIWYG editor products description textarea named products_description
                case 'products_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,caption,paste,preview,zoom,flash,searchreplace,print,contextmenu",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup,separator,help",
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
	   theme_advanced_resize_horizontal : false,
	   theme_advanced_resizing : false,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   paste_auto_cleanup_on_paste : true,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
	   paste_insert_word_content_callback : "convertWord",	
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
	});
                        	   	</script>';
                        break;

                // WYSIWYG editor products short description textarea named products_short_description
                case 'products_short_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,caption,paste,preview,zoom,flash,searchreplace,print,contextmenu",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup,separator,help",
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
	   theme_advanced_resize_horizontal : false,
	   theme_advanced_resizing : false,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   paste_auto_cleanup_on_paste : true,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
	   paste_insert_word_content_callback : "convertWord",	
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
	});
                        	   	</script>';
                        break;

                // WYSIWYG editor content manager
                case 'content_manager':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,caption,paste,preview,zoom,flash,searchreplace,print,contextmenu",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup,separator,help",
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
	   theme_advanced_resize_horizontal : false,
	   theme_advanced_resizing : false,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   paste_auto_cleanup_on_paste : true,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
	   paste_insert_word_content_callback : "convertWord",	
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
	});
                        	   	</script>';
                        break;

                // WYSIWYG editor products content manager
                case 'products_content':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,caption,paste,preview,zoom,flash,searchreplace,print,contextmenu",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup,separator,help",
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
	   theme_advanced_resize_horizontal : false,
	   theme_advanced_resizing : false,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   paste_auto_cleanup_on_paste : true,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
	   paste_insert_word_content_callback : "convertWord",	
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
	});
                        	   	</script>';
                        break;

                // WYSIWYG editor categories description
                case 'categories_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,caption,paste,preview,zoom,flash,searchreplace,print,contextmenu",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup,separator,help",
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
	   theme_advanced_resize_horizontal : false,
	   theme_advanced_resizing : false,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   paste_auto_cleanup_on_paste : true,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
	   paste_insert_word_content_callback : "convertWord",	
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
	});
                        	   	</script>';
                        break;

                // WYSIWYG editor newsletter
                case 'newsletter':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,caption,paste,preview,zoom,flash,searchreplace,print,contextmenu",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup,separator,help",
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
	   theme_advanced_resize_horizontal : false,
	   theme_advanced_resizing : false,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   paste_auto_cleanup_on_paste : true,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
	   paste_insert_word_content_callback : "convertWord",	
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
	});
                        	   	</script>';
                        break;

                // WYSIWYG editor newsletter
                case 'mail':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,caption,paste,preview,zoom,flash,searchreplace,print,contextmenu",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup,separator,help",
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
	   theme_advanced_resize_horizontal : false,
	   theme_advanced_resizing : false,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   paste_auto_cleanup_on_paste : true,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
	   paste_insert_word_content_callback : "convertWord",	
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
	});
                        	   	</script>';
                        break;

                // WYSIWYG editor gift voucher
                case 'gv_mail':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		language : "'.$lang.'",
		plugins : "table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,caption,paste,preview,zoom,flash,searchreplace,print,contextmenu",
	   theme_advanced_layout_manager : "RowLayout",
	   theme_advanced_containers : "top1,top2,top3,top4,mceEditor,mceElementpath",
	   theme_advanced_containers_default_class : "mceToolbar",
	   theme_advanced_containers_default_align : "center",
	   theme_advanced_container_top1_align : "left",
	   theme_advanced_container_top2_align : "left",
	   theme_advanced_container_top3_align : "left",
	   theme_advanced_container_top4_align : "left",
	   theme_advanced_container_top1 : "save,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,undo,redo,cut,copy,paste,pastetext,pasteword,selectall,separator,code,removeformat,cleanup,search,replace,separator,sub,sup,separator,help",
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
	   theme_advanced_resize_horizontal : false,
	   theme_advanced_resizing : false,	
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	   paste_create_paragraphs : false,
	   paste_create_linebreaks : false,
	   paste_use_dialog : true,
	   paste_auto_cleanup_on_paste : true,
	   paste_convert_middot_lists : false,
	   paste_unindented_list_class : "unindentedList",
	   paste_convert_headers_to_strong : true,
	   paste_insert_word_content_callback : "convertWord",	
		external_link_list_url : "example_data/example_link_list.js",
		external_image_list_url : "example_data/example_image_list.js",
		flash_external_list_url : "example_data/example_flash_list.js"  
	});
                        	   	</script>';
                        break;

    }
    
   	return $val;

}
?>
