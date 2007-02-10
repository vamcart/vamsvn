<?php
/* -----------------------------------------------------------------------------------------
    $Id: xtc_wysiwyg.inc.php 923 2007-02-07 10:51:57 VaM $
   
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
                        	   				var oFCKeditor = new FCKeditor( \'cont\', \'750\', \'400\'  ) ;
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
                        	   				var oFCKeditor = new FCKeditor( \'content\', \'750\', \'400\'  ) ;
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
                        	   				var oFCKeditor = new FCKeditor( \'file_comment\', \'750\', \'400\'  ) ;
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
                        $val ='var oFCKeditor = new FCKeditor( \'categories_description['.$langID.']\', \'750\', \'300\' ) ;
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
                        $val ='var oFCKeditor = new FCKeditor( \'products_description_'.$langID.'\', \'750\', \'400\'  ) ;
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
                        $val ='var oFCKeditor = new FCKeditor( \'products_short_description_'.$langID.'\', \'750\', \'300\'  ) ;
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
                        	   				var oFCKeditor = new FCKeditor( \'newsletter_body\', \'750\', \'400\'  ) ;
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
                        	   				var oFCKeditor = new FCKeditor( \'message\', \'750\', \'400\' ) ;
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
                        	   				var oFCKeditor = new FCKeditor( \'message\', \'750\', \'400\' ) ;
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
