<?php
/*
  ci_upload_cip.class.php

  Used class from osCommerce release but added following:
  1. Deny files with size more than 300Kb.
  2. Allow to upload only zip, tgz files

  Released under the GNU General Public License
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class upload_cip {
    var $file, $filename, $destination, $permissions, $extensions, $tmp_filename;

    function upload_cip($file = '', $destination = '', $permissions = '777', $extensions = '', $maxsize=MAX_UPLOADED_FILESIZE) {
        $this->file=$file;
        $this->destination=$destination;
        $this->maxsize=$maxsize;
        $this->permissions=octdec($permissions);
        if (vam_not_null($extensions)) {
            if (is_array($extensions))     $this->extensions = $extensions;
            else     $this->extensions = array($extensions);
        } else     $this->extensions = array();

        if (vam_not_null($this->file) && vam_not_null($this->destination)) {
            if (($this->parse()==true) && ($this->check_filesize()==true) && ($this->save()==true))     return true;
            else     return false;
        }
    }

    function parse() {
        global $message;

        if (isset($_FILES[$this->file])) {
            $file = array('name' => $_FILES[$this->file]['name'],
                        'type' => $_FILES[$this->file]['type'],
                        'size' => $_FILES[$this->file]['size'],
                        'tmp_name' => $_FILES[$this->file]['tmp_name']);
        } elseif (isset($GLOBALS['HTTP_POST_FILES'][$this->file])) {
            global $_FILES;
            $file = array('name' => $_FILES[$this->file]['name'],
                        'type' => $_FILES[$this->file]['type'],
                        'size' => $_FILES[$this->file]['size'],
                        'tmp_name' => $_FILES[$this->file]['tmp_name']);
        } else {
            $file = array('name' => (isset($GLOBALS[$this->file . '_name']) ? $GLOBALS[$this->file . '_name'] : ''),
                        'type' => (isset($GLOBALS[$this->file . '_type']) ? $GLOBALS[$this->file . '_type'] : ''),
                        'size' => (isset($GLOBALS[$this->file . '_size']) ? $GLOBALS[$this->file . '_size'] : ''),
                        'tmp_name' => (isset($GLOBALS[$this->file]) ? $GLOBALS[$this->file] : ''));
        }

        if ( vam_not_null($file['tmp_name']) && ($file['tmp_name'] != 'none') && is_uploaded_file($file['tmp_name']) ) {
            if (sizeof($this->extensions) > 0) {
                if (!in_array(strtolower(substr($file['name'], strrpos($file['name'], '.')+1)), $this->extensions)) {
                    $message->add('<b>'.$this->filename.'</b> '.ERROR_FILETYPE_NOT_ALLOWED, 'error');
                    return false;
                }
            }
            $this->file = $file;
            $this->filename=$file['name'];
            $this->tmp_filename=$file['tmp_name'];
            return $this->check_destination();
        } else {
            $message->add(WARNING_NO_FILE_UPLOADED, 'warning');
            return false;
        }
    }


    function check_filesize() {
        global $message;
        if ($this->file['size'] <=$this->maxsize)     return true;
        else {
            $message->add('<b>'.$this->filename.'</b> '.ERROR_FILE_SIZE_NOT_ALLOWED.($this->maxsize / 1024).' Kb.',  'error');
            return false;
        }
    }

    function save() {
        global $message;
        if (substr($this->destination, -1) != '/')    $this->destination .= '/';
        if (move_uploaded_file($this->file['tmp_name'], $this->destination . $this->filename)) {
            chmod($this->destination . $this->filename, $this->permissions);
            $message->add('<b>'.$this->filename.'</b> '.SUCCESS_FILE_SAVED_SUCCESSFULLY, 'success');
            return true;
        } else {
            $message->add('<b>'.$this->filename.'</b> '.ERROR_FILE_NOT_SAVED, 'error');
            return false;
        }
    }

    function check_destination() {
        global $message;
        if (substr($this->destination, -1) != '/')    $this->destination .= '/';
        if (is_file($this->destination . $this->filename)) {
            $message->add(sprintf(ERROR_FILE_ALREADY_EXISTS,$this->filename), 'error');
            return false;
        }

        if (!is_writeable($this->destination)) {
            if (is_dir($this->destination))   $message->add(sprintf(ERROR_DESTINATION_NOT_WRITEABLE, $this->destination));
            else     $message->add(sprintf(ERROR_DESTINATION_DOES_NOT_EXIST, $this->destination), 'error');
            return false;
        } else     return true;
    }

}
?>