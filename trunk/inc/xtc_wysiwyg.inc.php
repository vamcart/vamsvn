<?php
/* -----------------------------------------------------------------------------------------
    $Id: fckconfig.inc.php 923 2005-05-08 03:32:43Z hhgag $   
   
    XT-Commerce - community made shopping
    http://www.xt-commerce.com/
    
    H.H.G. group
    Hasan H. Gürsoy
	 
    Copyright (c) 2005 XT-Commerce & H.H.G. group
		   
    Released under the GNU General Public License 
---------------------------------------------------------------------------------------*/

function xtc_wysiwyg($type, $lang, $langID = '') {

$js_src = DIR_WS_MODULES .'fckeditor/fckeditor.js';
$path = DIR_WS_MODULES .'fckeditor/';
$filemanager = DIR_WS_ADMIN.'fck_wrapper.php?Connector='.DIR_WS_FILEMANAGER.'connectors/php/connector.php&ServerPath='. DIR_WS_CATALOG;
$file_path = '&Type=media';
$image_path = '&Type=images';

	switch($type) {
                // WYSIWYG editor content manager textarea named cont
                case 'content_manager':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
                        	   		window.onload = function()
                        	   			{
                        	   				var oFCKeditor = new FCKeditor( \'cont\', \'100%\', \'400\'  ) ;
                        	   				oFCKeditor.BasePath = "'.$path.'" ;
                        	   				oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.'" ;
                        	   				oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.'" ;
                        	   				oFCKeditor.Config["AutoDetectLanguage"] = false ;
                        	   				oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                        	   				oFCKeditor.ReplaceTextarea() ;
                        	   			}
                        	   	</script>';
                        break;
                // WYSIWYG editor latest news textarea named content
                case 'latest_news':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
                        	   		window.onload = function()
                        	   			{
                        	   				var oFCKeditor = new FCKeditor( \'content\', \'100%\', \'400\'  ) ;
                        	   				oFCKeditor.BasePath = "'.$path.'" ;
                        	   				oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.'" ;
                        	   				oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.'" ;
                        	   				oFCKeditor.Config["AutoDetectLanguage"] = false ;
                        	   				oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                        	   				oFCKeditor.ReplaceTextarea() ;
                        	   			}
                        	   	</script>';
                        break;
                // WYSIWYG editor content manager products content section textarea named file_comment
                case 'products_content':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
                        	   		window.onload = function()
                        	   			{
                        	   				var oFCKeditor = new FCKeditor( \'file_comment\', \'100%\', \'400\'  ) ;
                        	   				oFCKeditor.BasePath = "'.$path.'" ;
                        	   				oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.'" ;
                        	   				oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.'" ;
                        	   				oFCKeditor.Config["AutoDetectLanguage"] = false ;
                        	   				oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                        	   				oFCKeditor.ReplaceTextarea() ;
                        	   			}
                        	   	</script>';
                        break;
                // WYSIWYG editor categories_description textarea named categories_description[langID]
                case 'categories_description':
                        $val ='var oFCKeditor = new FCKeditor( \'categories_description['.$langID.']\', \'550\', \'300\' ) ;
                        	   oFCKeditor.BasePath = "'.$path.'" ;
                        	   oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.'" ;
                        	   oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.'" ;
                        	   oFCKeditor.Config["AutoDetectLanguage"] = false ;
                        	   oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                        	   oFCKeditor.ReplaceTextarea() ;
                        	   ';
                        break;
                // WYSIWYG editor products_description textarea named products_description_langID
                case 'products_description':
                        $val ='var oFCKeditor = new FCKeditor( \'products_description_'.$langID.'\', \'100%\', \'400\'  ) ;
                        	   oFCKeditor.BasePath = "'.$path.'" ;
                        	   oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.'" ;
                        	   oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.'" ;
                        	   oFCKeditor.Config["AutoDetectLanguage"] = false ;
                        	   oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                        	   oFCKeditor.ReplaceTextarea() ;
                        	   ';
                        break;
                // WYSIWYG editor products short description textarea named products_short_description_langID
                case 'products_short_description':
                        $val ='var oFCKeditor = new FCKeditor( \'products_short_description_'.$langID.'\', \'550\', \'300\'  ) ;
                        	   oFCKeditor.BasePath = "'.$path.'" ;
                        	   oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.'" ;
                        	   oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.'" ;
                        	   oFCKeditor.Config["AutoDetectLanguage"] = false ;
                        	   oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                        	   oFCKeditor.ReplaceTextarea() ;
                        	   ';
                        break;
                // WYSIWYG editor newsletter textarea named newsletter_body
                case 'newsletter':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
                        	   		window.onload = function()
                        	   			{
                        	   				var oFCKeditor = new FCKeditor( \'newsletter_body\', \'100%\', \'400\'  ) ;
                        	   				oFCKeditor.BasePath = "'.$path.'" ;
                        	   				oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.'" ;
                        	   				oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.'" ;
                        	   				oFCKeditor.Config["AutoDetectLanguage"] = false ;
                        	   				oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                        	   				oFCKeditor.ReplaceTextarea() ;
                        	   			}
                        	   	</script>';
                        break;
                // WYSIWYG editor mail textarea named message
                case 'mail':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
                        	   		window.onload = function()
                        	   			{
                        	   				var oFCKeditor = new FCKeditor( \'message\', \'700\', \'400\' ) ;
                        	   				oFCKeditor.BasePath = "'.$path.'" ;
                        	   				oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.'" ;
                        	   				oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.'" ;
                        	   				oFCKeditor.Config["AutoDetectLanguage"] = false ;
                        	   				oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                        	   				oFCKeditor.ReplaceTextarea() ;
                        	   			}
                        	   	</script>';
                        break;
                // WYSIWYG editor gv_mail textarea named message
                case 'gv_mail':
                        $val ='<script type="text/javascript" src="'.$js_src.'"></script>
                        	   <script type="text/javascript">
                        	   		window.onload = function()
                        	   			{
                        	   				var oFCKeditor = new FCKeditor( \'message\', \'700\', \'400\' ) ;
                        	   				oFCKeditor.BasePath = "'.$path.'" ;
                        	   				oFCKeditor.Config["LinkBrowserURL"] = "'.$filemanager.$file_path.'" ;
                        	   				oFCKeditor.Config["ImageBrowserURL"] = "'.$filemanager.$image_path.'" ;
                        	   				oFCKeditor.Config["AutoDetectLanguage"] = false ;
                        	   				oFCKeditor.Config["DefaultLanguage"] = "'.$lang.'" ;
                        	   				oFCKeditor.ReplaceTextarea() ;
                        	   			}
                        	   	</script>';
                        break;
    }
    
   	return $val;

}
?>
