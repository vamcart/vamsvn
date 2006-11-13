<?php
/* --------------------------------------------------------------
 $Id: file_system.php 2006-11-13

 XT-Commerce - community made shopping
 http://www.xt-commerce.com

 Released under the GNU General Public License
 --------------------------------------------------------------*/


class fileFilter {

    var $included_extensions;
    var $excluded_files;
    
    function fileFilter($included_extensions = array (),
                        $excluded_files = array ()){
        if (!is_array($included_extensions)){
            $included_extensions = array();
        }
        $this->included_extensions = $included_extensions;
        $this->excluded_files = $excluded_files;
    }
    
    
    function includeFile ($fileName){
        if (count($this->included_extensions) == 0){
            return true;
        }

        $file_extension = substr($fileName, strrpos($file, '.'));
        return in_array($file_extension, $this->included_extensions);
    }
    
    function excludeFile ($fileName){
        if (count($this->excluded_files) == 0){
            return false;
        }

        return in_array($fileName, $this->excluded_files);
    }
}

function xtc_get_filelist ($startdir, $includedExt = array (), $excludedFilenames = array()){
    return xtc_get_filelist_func ($startdir, new fileFilter($includedExt, $excludedFilenames));
}


function xtc_get_image_files ($startdir, $includedExt = array ('.jpg','.jpeg','.png','.gif')){
    return xtc_get_filelist_func ($startdir, new fileFilter($includedExt));
}


/**
 * @return array array which contains file list starting from the $startdir
 */
function xtc_get_filelist_func ($startdir, 
                           $file_filter = NULL,
                           $dir_only = false, $subdir = '') {
    //      echo 'Directory: ' . $startdir . '  Subirectory: ' . $subdir . '<br />';
    if ($file_filter == null){
        $file_filter = new fileFilter();
    }
    
    $dirname = $startdir . $subdir;
    if ($dir = opendir($dirname)) {
        while ($file = readdir($dir)) {
            if (substr($file, 0, 1) != '.') {
                if (!$dir_only && is_file($dirname . $file)) {
                    if ($file_filter->includeFile($file) && !$file_filter->excludeFile($file)){
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
                    $files = xtc_array_merge($files, xtc_get_filelist_func ($startdir, $file_filter, $dir_only, $subdir . $file . '/'));
                }
            }
        }
        closedir($dir);
    }
    return ($files);
}

?>
