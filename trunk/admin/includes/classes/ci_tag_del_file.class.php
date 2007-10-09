<?php
/*
Class Del_File operates with del_file tag from install.xml.
Made by Vlad Savitsky
    http://forums.oscommerce.com/index.php?showuser=20490
Support:
    http://forums.oscommerce.com/index.php?showtopic=156667
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_del_file extends ContribInstallerBaseTag {
    var $tag_name='del_file';
    var $data;
    var $params;//array with attributes
// Class Constructor
    function Tc_del_file($contrib='', $id='', $xml_data='', $dep='') {
        $this->params=array(
            'filename'=>array(
                                'sql_type'=>'varchar(255)',
                                'xml_error'=>NAME_OF_FILE_MISSING_IN_DEL_FILE_SECTION_TEXT
                                ),
        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }
//  Class Methods
    function get_data_from_xml_parser($xml_data='') {
    	$this->data['filename'] = $this->getTagAttr($xml_data,'file',0,'name');
    }

    function write_to_xml() {
        return '
        <'.$this->tag_name.'>
            <file name="'.$this->data['filename'].'" />
        </'.$this->tag_name.'>';
    }

    function do_install() {
        if (is_file($this->fs_filename())) {
            if (ALLOW_FILES_BACKUP=='false')     $this->backup_file();
            //save_md5 ($this->fs_filename(), $this->contrib);
            ci_remove($this->fs_filename());

        }
        return $this->error;
    }
    function do_remove() {
        if (ALLOW_FILES_RESTORE=='false')     $this->restore_file();
        return $this->error;
    }
    function permissions_check_for_install() {
        if (file_exists($this->fs_filename())) {
            if(!is_writable(dirname($this->fs_filename())))     $this->error(WRITE_PERMISSINS_NEEDED_TEXT.$this->fs_filename());
        }
        return $this->error;
    }
    function permissions_check_for_remove() {return $this->permissions_check_for_install();}

    function conflicts_check_for_install() {
        $cip_file=DIR_FS_CIP.'/'.$this->contrib.'/catalog/'.$this->data['filename'];
        $current_file=$this->fs_filename();
        $backup_file=DIR_FS_ADMIN_BACKUP.CONTRIB_INSTALLER_NAME."_".CONTRIB_INSTALLER_VERSION.'/'. $this->data['filename'];

        if (!file_exists($current_file))    return;
        //File was modified since Contrib Installer have been installed.
        //If ALLOW_OVERWRITE_MODIFIED set to FALSE we couldn't overwrite.
        if (ALLOW_OVERWRITE_MODIFIED==false) {
            if (!file_exists($backup_file)) {
                $this->error("Backup file ".$backup_file." is not exists. This file needed to check if file". $current_file. " was modified since Contrib Installer have been installed.
                <br><b>Advise</b>:<br>
                Set \"Allow Overwrite Existing Modified Files\" to TRUE and all modified files will be overwritten.
                All changes will be lost!<br>
                <i>or</i><br>
                Copy clean osCommerce files to     ".DIR_FS_CIP."/".CONTRIB_INSTALLER_NAME."_".CONTRIB_INSTALLER_VERSION. "/catalog/ and try again.");
            } elseif (md5_file($current_file) != md5_file($backup_file)) {
                $this->error("File ".$current_file." exists and was modified since Contrib Installer have been installed. Overwriting is not allowed.<br><b>Advise</b>:<br>Set \"Allow Overwrite Existing Modified Files\" to TRUE or change install.xml.");
            }
        }
        return $this->error;
    }

    function conflicts_check_for_remove() {
        $current_file=$this->fs_filename();
        if (!file_exists($current_file))    return;
        if (ALLOW_OVERWRITE_MODIFIED==false) {
            $this->error("File ".$current_file." exists and was modified since CIP have been installed. Overwriting is not allowed.<br><b>Advise</b>:<br>Set \"Allow Overwrite Existing Modified Files\" to TRUE or check what CIP added this file.");
        }
        return $this->error;
    }


}


/*
====================================================================
    [DEL_FILE] => Array
        (
            [0] => Array
                (
                    [@] =>
                    [FILE] => Array
                        (
                            [0] => Array
                                (
                                    [@] => Array
                                        (
                                            [NAME] => name.php
                                        )
                                    [#] =>
                                )
                        )
                )
        )
====================================================================
ToDO:
1.Store in database filenames and does file present in system.
    When we restore from backup we will know if it's an error if file not exists in backup.

*/

?>