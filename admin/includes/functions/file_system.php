<?php
/* --------------------------------------------------------------
 $Id: file_system.php 950 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2004 xt:Commerce (file_system.php,v 1.6 2003/08/20); xt-commerce.com

 Released under the GNU General Public License
 --------------------------------------------------------------*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * A filter for abstract pathnames.
 * This is default realization, which always return true.
 * Subclasses should define their own logic
 */
class FileFilter_I {

    /**
     * Tests whether or not the specified abstract pathname should be
     * included in a pathname list.
     *
     * @param  string pathname  The abstract pathname to be tested
     * @return  <code>true</code> if and only if <code>pathname</code>
     *          should be included
     */
     function accept($pathname){
         return true;
     }
     
     /**
      * Empty constructor
      * @return FileFilter_I
      */
     function FileFilter_I(){
     }

}

class FileFilter extends FileFilter_I{

    var $included_extensions;
    var $excluded_extensions;
    var $excluded_files;

    /**
     * This is default realization, which use supported-extensions of file and deprecated file-names (excluded)
     *
     * @param array $supported_extensions
     * @param array $excluded_files
     * @return FileFilter
     */
    function FileFilter($included_extensions = NULL, 
                        $excluded_extensions = NULL,
                        $excluded_files = NULL){
        if (!is_array($included_extensions)){
            $included_extensions = NULL;
        }
        if (!is_array($excluded_extensions)){
            $excluded_extensions = NULL;
        }
        if (!is_array($excluded_files)){
            $excluded_files = NULL;
        }
        $this->included_extensions = $included_extensions;
        $this->excluded_extensions = $excluded_extensions;
        $this->excluded_files = $excluded_files;
       
    }

    /**
     * @param string $pathName
     * @return true if fileName has supported extension and its name is not in the deprecated names
     */
    function accept ($pathName){
        $fileName = basename($pathName);
        return $this->isExtensionSupported($fileName) && !$this->fileInExcludedFileList ($fileName);
    }

    function isExtensionSupported ($fileName){
        $file_extension = substr($fileName, strrpos($fileName, '.')); 
        $included = true;
        if ($this->included_extensions != NULL){
            $included = in_array($file_extension, $this->included_extensions);
        }

        $excluded = false;
        if ($this->excluded_extensions != NULL){
            $excluded = in_array($file_extension, $this->excluded_extensions);
        }
        
        return $included && !$excluded;
    }


    function fileInExcludedFileList ($fileName){
        if ($this->excluded_files == NULL){
            return false;
        }
        return in_array($fileName, $this->excluded_files);
    }

}


function vam_get_filelist ($startdir, $includedExt = array (), $excludedFilenames = array()){
    return vam_get_filelist_func ($startdir, new FileFilter($includedExt, null, $excludedFilenames));
}


function vam_get_image_files ($startdir, $includedExt = array ('.jpg','.jpeg','.png','.gif')){
    return vam_get_filelist_func ($startdir, new FileFilter($includedExt));
}


/**
 * @return array array which contains file list starting from the $startdir
 */
function vam_get_filelist_func ($startdir,
                           $file_filter = NULL,
                           $dir_only = false, $subdir = '') {
    //      echo 'Directory: ' . $startdir . '  Subirectory: ' . $subdir . '<br />';
    if ($file_filter == null){
        $file_filter = new FileFilter_I();
    }

    $dirname = $startdir . $subdir;
    if ($dir = opendir($dirname)) {
        while ($file = readdir($dir)) {
            if (substr($file, 0, 1) != '.') {
                if (!$dir_only && is_file($dirname . $file)) {
                    if ($file_filter->accept($file)){
                        $files[] = array (
                            'id' => $subdir . $file,
                            'text' => $subdir . $file
                        );
                    }
                } elseif (is_dir($dirname . $file)) {
                    if ($dir_only) {
                        $files[] = array (
                            'id' => $subdir . $file . '/',
                            'text' => $subdir . $file . '/'
                        );
                    }
                    $files = vam_array_merge($files, vam_get_filelist_func ($startdir, $file_filter, $dir_only, $subdir . $file . '/'));
                }
            }
        }
        closedir($dir);
    }
    return ($files);
}

?>
