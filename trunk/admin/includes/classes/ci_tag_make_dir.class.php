<?php
/*
Class Make_Dir operates with make-dir-tag from install.xml.
Made by Vlad Savitsky
    http://forums.oscommerce.com/index.php?showuser=20490
Support:
    http://forums.oscommerce.com/index.php?showtopic=156667
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_make_dir extends ContribInstallerBaseTag {
    var $tag_name='make_dir';
// Class Constructor
    function Tc_make_dir($contrib='', $id='', $xml_data='', $dep='') {
        $this->params=array(
            //Можно убрать этот параметр и использовать только dir:
            'parent_dir'=>array(
                                'sql_type'=>'varchar(255)',
                                'xml_error'=>''//NAME_OF_PARENT_DIR_MISSING_IN_MAKE_DIR_SECTION_TEXT
                                ),
            'dir'=>array(
                                'sql_type'=>'varchar(255)',
                                'xml_error'=>NAME_OF_DIR_MISSING_IN_MAKE_DIR_SECTION_TEXT
                                ),
        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }
//  Class Methods
    function get_data_from_xml_parser($xml_data='') {
        $this->data['parent_dir']   =$this->getTagAttr($xml_data,'parent_dir',0,'name');
        $this->data['dir']          =$this->getTagAttr($xml_data,'dir',0,'name');
    }

    function write_to_xml() {
        return '
        <'.$this->tag_name.'>
            <parent_dir name="'.$this->data['parent_dir'].'" />
            <dir name="'.$this->data['dir'].'" />
        </'.$this->tag_name.'>';
    }


    function do_install(){
        $this->recursive_mkdir(DIR_FS_CATALOG.$this->data['parent_dir'].$this->data['dir']);
        return $this->error;
    }


    function do_remove() {
        $directory=DIR_FS_CATALOG.$this->data['parent_dir'].$this->data['dir'];
        do {
            if(is_dir($directory)) {
                if(@!rmdir($directory))     return COLUDNT_REMOVE_DIR_TEXT.$directory;
            }
        } while (dirname(DIR_FS_CATALOG.$this->data['parent_dir'])!=dirname($directory=dirname($directory)));
        return $this->error;
    }


    function permissions_check_for_install() {
        if(!is_writable(DIR_FS_CATALOG.$this->data['parent_dir']))   $this->error(WRITE_PERMISSINS_NEEDED_TEXT.$this->data['parent_dir']);
        return $this->error;
    }


    function permissions_check_for_remove() {
        $this->permissions_check_for_install($this->data['parent_dir'], $this->data['dir']);
        if ($this->data['parent_dir']) {
            $directory=DIR_FS_CATALOG.$this->data['parent_dir'].$this->data['dir'];
            while (dirname($this->data['parent_dir'])!=($directory=dirname($directory))) {
                if(!is_writable($directory))   $this->error(WRITE_PERMISSINS_NEEDED_TEXT.$directory);
            }
        }
        return $this->error;
    }
}

/*
====================================================================
    [MAKE_DIR] => Array
        (
            [0] => Array
                (
                    [@] =>
                    [PARENT_DIR] => Array
                        (
                            [0] => Array
                                (
                                    [@] => Array
                                        (
                                            [NAME] =>
                                        )
                                    [#] =>
                                )
                        )
                    [DIR] => Array
                        (
                            [0] => Array
                                (
                                    [@] => Array
                                        (
                                            [NAME] => temp
                                        )
                                    [#] =>
                                )
                        )
                )
        )
====================================================================
*/
?>