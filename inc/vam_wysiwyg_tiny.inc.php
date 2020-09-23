<?php
/* -----------------------------------------------------------------------------------------
    $Id: vam_wysiwyg_tiny.inc.php 923 2009-02-07 10:51:57 VaM $
   
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

$js_src = DIR_WS_INCLUDES .'javascript/tinymce/tinymce.min.js';

	switch($type) {
                // WYSIWYG editor latest news textarea named latest_news
                case 'latest_news':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
<script type="text/javascript">
tinymce.init({
  selector: "textarea:not(.notinymce)",
  height: 500,
  extended_valid_elements : "script[language|type|src],iframe[src|width|height|name|align|class]",
  image_advtab: true ,
  verify_html: false ,
  convert_urls : false,
  external_filemanager_path: "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/",
  filemanager_title:"VamShop" ,
  filemanager_access_key:"'. session_name() .'" ,
  external_plugins: { "filemanager" : "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/plugin.min.js"},
  autosave_ask_before_unload: false,
  image_class_list: [
      {title: "img-fluid", value: "img-fluid"}
  ],		  
  language : "'.$lang.'",
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code help fullscreen",
    "insertdatetime media table paste imagetools wordcount responsivefilemanager"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | help"
});


function toggleHTMLEditor(id) {
	if (!tinymce.get(id))
		tinymce.execCommand("mceAddEditor", false, id);
	else
		tinymce.execCommand("mceRemoveEditor", false, id);
}
                        	   	</script>
                        	   	';
                        break;

                // WYSIWYG editor faq textarea named faq
                case 'faq':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
<script type="text/javascript">
tinymce.init({
  selector: "textarea:not(.notinymce)",
  height: 500,
  extended_valid_elements : "script[language|type|src],iframe[src|width|height|name|align|class]",
  image_advtab: true ,
  verify_html: false ,
  convert_urls : false,
  external_filemanager_path: "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/",
  filemanager_title:"VamShop" ,
  filemanager_access_key:"'. session_name() .'" ,
  external_plugins: { "filemanager" : "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/plugin.min.js"},
  autosave_ask_before_unload: false,
  image_class_list: [
      {title: "img-fluid", value: "img-fluid"}
  ],		  
  language : "'.$lang.'",
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code help fullscreen",
    "insertdatetime media table paste imagetools wordcount responsivefilemanager"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | help"
});


function toggleHTMLEditor(id) {
	if (!tinymce.get(id))
		tinymce.execCommand("mceAddEditor", false, id);
	else
		tinymce.execCommand("mceRemoveEditor", false, id);
}
                        	   	</script>
                        	   	';
                        break;

                // WYSIWYG editor faq textarea named faq
                case 'faq1':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
<script type="text/javascript">
tinymce.init({
  selector: "textarea:not(.notinymce)",
  height: 500,
  extended_valid_elements : "script[language|type|src],iframe[src|width|height|name|align|class]",
  image_advtab: true ,
  verify_html: false ,
  convert_urls : false,
  external_filemanager_path: "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/",
  filemanager_title:"VamShop" ,
  filemanager_access_key:"'. session_name() .'" ,
  external_plugins: { "filemanager" : "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/plugin.min.js"},
  autosave_ask_before_unload: false,
  image_class_list: [
      {title: "img-fluid", value: "img-fluid"}
  ],		  
  language : "'.$lang.'",
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code help fullscreen",
    "insertdatetime media table paste imagetools wordcount responsivefilemanager"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | help"
});


function toggleHTMLEditor(id) {
	if (!tinymce.get(id))
		tinymce.execCommand("mceAddEditor", false, id);
	else
		tinymce.execCommand("mceRemoveEditor", false, id);
}
                        	   	</script>
                        	   	';
                        break;

                // WYSIWYG editor latest news textarea named articles_description
                case 'articles_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
<script type="text/javascript">
tinymce.init({
  selector: "textarea:not(.notinymce)",
  height: 500,
  extended_valid_elements : "script[language|type|src],iframe[src|width|height|name|align|class]",
  image_advtab: true ,
  verify_html: false ,
  convert_urls : false,
  external_filemanager_path: "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/",
  filemanager_title:"VamShop" ,
  filemanager_access_key:"'. session_name() .'" ,
  external_plugins: { "filemanager" : "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/plugin.min.js"},
  autosave_ask_before_unload: false,
  image_class_list: [
      {title: "img-fluid", value: "img-fluid"}
  ],		  
  language : "'.$lang.'",
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code help fullscreen",
    "insertdatetime media table paste imagetools wordcount responsivefilemanager"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | help"
});


function toggleHTMLEditor(id) {
	if (!tinymce.get(id))
		tinymce.execCommand("mceAddEditor", false, id);
	else
		tinymce.execCommand("mceRemoveEditor", false, id);
}
                        	   	</script>
                        	   	';
                        break;

                // WYSIWYG editor latest news textarea named topics_description
                case 'topics_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
<script type="text/javascript">
tinymce.init({
  selector: "textarea:not(.notinymce)",
  height: 500,
  extended_valid_elements : "script[language|type|src],iframe[src|width|height|name|align|class]",
  image_advtab: true ,
  verify_html: false ,
  convert_urls : false,
  external_filemanager_path: "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/",
  filemanager_title:"VamShop" ,
  filemanager_access_key:"'. session_name() .'" ,
  external_plugins: { "filemanager" : "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/plugin.min.js"},
  autosave_ask_before_unload: false,
  image_class_list: [
      {title: "img-fluid", value: "img-fluid"}
  ],		  
  language : "'.$lang.'",
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code help fullscreen",
    "insertdatetime media table paste imagetools wordcount responsivefilemanager"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | help"
});


function toggleHTMLEditor(id) {
	if (!tinymce.get(id))
		tinymce.execCommand("mceAddEditor", false, id);
	else
		tinymce.execCommand("mceRemoveEditor", false, id);
}
                        	   	</script>
                        	   	';
                        break;

                // WYSIWYG editor products description textarea named products_description
                case 'products_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
<script type="text/javascript">
tinymce.init({
  selector: "textarea:not(.notinymce)",
  height: 500,
  extended_valid_elements : "script[language|type|src],iframe[src|width|height|name|align|class]",
  image_advtab: true ,
  verify_html: false ,
  convert_urls : false,
  external_filemanager_path: "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/",
  filemanager_title:"VamShop" ,
  filemanager_access_key:"'. session_name() .'" ,
  external_plugins: { "filemanager" : "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/plugin.min.js"},
  autosave_ask_before_unload: false,
  image_class_list: [
      {title: "img-fluid", value: "img-fluid"}
  ],		  
  language : "'.$lang.'",
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code help fullscreen",
    "insertdatetime media table paste imagetools wordcount responsivefilemanager"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | help"
});


function toggleHTMLEditor(id) {
	if (!tinymce.get(id))
		tinymce.execCommand("mceAddEditor", false, id);
	else
		tinymce.execCommand("mceRemoveEditor", false, id);
}
                        	   	</script>
                        	   	';
                        break;

                // WYSIWYG editor products short description textarea named products_short_description
                case 'products_short_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
<script type="text/javascript">
tinymce.init({
  selector: "textarea:not(.notinymce)",
  height: 500,
  extended_valid_elements : "script[language|type|src],iframe[src|width|height|name|align|class]",
  image_advtab: true ,
  verify_html: false ,
  convert_urls : false,
  external_filemanager_path: "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/",
  filemanager_title:"VamShop" ,
  filemanager_access_key:"'. session_name() .'" ,
  external_plugins: { "filemanager" : "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/plugin.min.js"},
  autosave_ask_before_unload: false,
  image_class_list: [
      {title: "img-fluid", value: "img-fluid"}
  ],		  
  language : "'.$lang.'",
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code help fullscreen",
    "insertdatetime media table paste imagetools wordcount responsivefilemanager"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | help"
});


function toggleHTMLEditor(id) {
	if (!tinymce.get(id))
		tinymce.execCommand("mceAddEditor", false, id);
	else
		tinymce.execCommand("mceRemoveEditor", false, id);
}
                        	   	</script>
                        	   	';
                        break;

                // WYSIWYG editor content manager
                case 'content_manager':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
<script type="text/javascript">
tinymce.init({
  selector: "textarea:not(.notinymce)",
  height: 500,
  extended_valid_elements : "script[language|type|src],iframe[src|width|height|name|align|class]",
  image_advtab: true ,
  verify_html: false ,
  convert_urls : false,
  external_filemanager_path: "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/",
  filemanager_title:"VamShop" ,
  filemanager_access_key:"'. session_name() .'" ,
  external_plugins: { "filemanager" : "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/plugin.min.js"},
  autosave_ask_before_unload: false,
  image_class_list: [
      {title: "img-fluid", value: "img-fluid"}
  ],		  
  language : "'.$lang.'",
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code help fullscreen",
    "insertdatetime media table paste imagetools wordcount responsivefilemanager"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | help"
});


function toggleHTMLEditor(id) {
	if (!tinymce.get(id))
		tinymce.execCommand("mceAddEditor", false, id);
	else
		tinymce.execCommand("mceRemoveEditor", false, id);
}
                        	   	</script>
                        	   	';
                        break;

                // WYSIWYG editor content manager
                case 'products_content':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
<script type="text/javascript">
tinymce.init({
  selector: "textarea:not(.notinymce)",
  height: 500,
  extended_valid_elements : "script[language|type|src],iframe[src|width|height|name|align|class]",
  image_advtab: true ,
  verify_html: false ,
  convert_urls : false,
  external_filemanager_path: "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/",
  filemanager_title:"VamShop" ,
  filemanager_access_key:"'. session_name() .'" ,
  external_plugins: { "filemanager" : "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/plugin.min.js"},
  autosave_ask_before_unload: false,
  image_class_list: [
      {title: "img-fluid", value: "img-fluid"}
  ],		  
  language : "'.$lang.'",
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code help fullscreen",
    "insertdatetime media table paste imagetools wordcount responsivefilemanager"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | help"
});


function toggleHTMLEditor(id) {
	if (!tinymce.get(id))
		tinymce.execCommand("mceAddEditor", false, id);
	else
		tinymce.execCommand("mceRemoveEditor", false, id);
}
                        	   	</script>
                        	   	';
                        break;

                // WYSIWYG editor categories description
                case 'categories_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
<script type="text/javascript">
tinymce.init({
  selector: "textarea:not(.notinymce)",
  height: 500,
  extended_valid_elements : "script[language|type|src],iframe[src|width|height|name|align|class]",
  image_advtab: true ,
  verify_html: false ,
  convert_urls : false,
  external_filemanager_path: "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/",
  filemanager_title:"VamShop" ,
  filemanager_access_key:"'. session_name() .'" ,
  external_plugins: { "filemanager" : "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/plugin.min.js"},
  autosave_ask_before_unload: false,
  image_class_list: [
      {title: "img-fluid", value: "img-fluid"}
  ],		  
  language : "'.$lang.'",
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code help fullscreen",
    "insertdatetime media table paste imagetools wordcount responsivefilemanager"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | help"
});


function toggleHTMLEditor(id) {
	if (!tinymce.get(id))
		tinymce.execCommand("mceAddEditor", false, id);
	else
		tinymce.execCommand("mceRemoveEditor", false, id);
}
                        	   	</script>
                        	   	';
                        break;

                // WYSIWYG editor newsletter
                case 'manufacturers_description':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
<script type="text/javascript">
tinymce.init({
  selector: "textarea:not(.notinymce)",
  height: 500,
  extended_valid_elements : "script[language|type|src],iframe[src|width|height|name|align|class]",
  image_advtab: true ,
  verify_html: false ,
  convert_urls : false,
  external_filemanager_path: "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/",
  filemanager_title:"VamShop" ,
  filemanager_access_key:"'. session_name() .'" ,
  external_plugins: { "filemanager" : "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/plugin.min.js"},
  autosave_ask_before_unload: false,
  image_class_list: [
      {title: "img-fluid", value: "img-fluid"}
  ],		  
  language : "'.$lang.'",
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code help fullscreen",
    "insertdatetime media table paste imagetools wordcount responsivefilemanager"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | help"
});


function toggleHTMLEditor(id) {
	if (!tinymce.get(id))
		tinymce.execCommand("mceAddEditor", false, id);
	else
		tinymce.execCommand("mceRemoveEditor", false, id);
}
                        	   	</script>
                        	   	';
                        break;

                // WYSIWYG editor newsletter
                case 'mail':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
<script type="text/javascript">
tinymce.init({
  selector: "textarea:not(.notinymce)",
  height: 500,
  extended_valid_elements : "script[language|type|src],iframe[src|width|height|name|align|class]",
  image_advtab: true ,
  verify_html: false ,
  convert_urls : false,
  external_filemanager_path: "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/",
  filemanager_title:"VamShop" ,
  filemanager_access_key:"'. session_name() .'" ,
  external_plugins: { "filemanager" : "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/plugin.min.js"},
  autosave_ask_before_unload: false,
  image_class_list: [
      {title: "img-fluid", value: "img-fluid"}
  ],		  
  language : "'.$lang.'",
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code help fullscreen",
    "insertdatetime media table paste imagetools wordcount responsivefilemanager"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | help"
});


function toggleHTMLEditor(id) {
	if (!tinymce.get(id))
		tinymce.execCommand("mceAddEditor", false, id);
	else
		tinymce.execCommand("mceRemoveEditor", false, id);
}
                        	   	</script>
                        	   	';
                        break;

                // WYSIWYG editor gift voucher
                case 'gv_mail':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
<script type="text/javascript">
tinymce.init({
  selector: "textarea:not(.notinymce)",
  height: 500,
  extended_valid_elements : "script[language|type|src],iframe[src|width|height|name|align|class]",
  image_advtab: true ,
  verify_html: false ,
  convert_urls : false,
  external_filemanager_path: "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/",
  filemanager_title:"VamShop" ,
  filemanager_access_key:"'. session_name() .'" ,
  external_plugins: { "filemanager" : "'.HTTP_SERVER . DIR_WS_CATALOG.'admin/filemanager/plugin.min.js"},
  autosave_ask_before_unload: false,
  image_class_list: [
      {title: "img-fluid", value: "img-fluid"}
  ],		  
  language : "'.$lang.'",
  plugins: [
    "advlist autolink lists link image charmap print preview anchor",
    "searchreplace visualblocks code help fullscreen",
    "insertdatetime media table paste imagetools wordcount responsivefilemanager"
  ],
  toolbar: "insertfile undo redo | styleselect | bold italic underline forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code | help"
});


function toggleHTMLEditor(id) {
	if (!tinymce.get(id))
		tinymce.execCommand("mceAddEditor", false, id);
	else
		tinymce.execCommand("mceRemoveEditor", false, id);
}
                        	   	</script>
                        	   	';
                        break;

    }
    
   	return $val;

}
?>