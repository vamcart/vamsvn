<?php
/*
Class contrib_installer_file_integrity.class.php
Made by Vlad Savitsky
    http://forums.oscommerce.com/index.php?showuser=20490
Support:
    http://forums.oscommerce.com/index.php?showtopic=156667
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

    function save_md5_for_all_files() {
        //This code run once on self install. Keeps more time to run (about 2000 files prosessed)
        //ONLY WHEN INIT
        $catalog_files=get_all_files_in_tree(DIR_FS_CATALOG, array(), array(basename(DIR_FS_CIP)));
        foreach($catalog_files as $file_path)     save_md5($file_path, 'original');
    }

/*
                            //Check file integrity
                            if (file_was_changed(DIR_FS_CATALOG . $t_array[$loop_index]['FILE'][0]['@']['NAME'])) {
                                return LINK_EXISTS_TEXT."<br>".FILE_EXISTS_AND_WAS_CHANGED_TEXT." (addfile): ".
                                            DIR_FS_CATALOG.$t_array[$loop_index]['FILE'][0]['@']['NAME']."<br>";
                            } else  ci_remove(DIR_FS_CATALOG.$t_array[$loop_index]['FILE'][0]['@']['NAME']);
                            Return all modifiers of that file.
*/


//Functions for checking file integrity:

    //Returns true if file was changes since Contrib Installer have been installed.
    function file_was_changed($file_path) {
        $result=vam_db_query("SELECT content_md5 FROM " . TABLE_CIP_FILE_INTEGRITY . "
                        WHERE path_md5='".(md5($file_path))."' AND contrib='original' ");
        $file_changer=vam_db_fetch_array($result);
        return ( $file_changer['content_md5']==md5_file($file_path)) ? false : true;
    }
    //Returns an array which consist all info from database about file $file_path.
    function file_changers($file_path) {
        $result=vam_db_query("
            SELECT content_md5, modification_date, contrib
            FROM " . TABLE_CIP_FILE_INTEGRITY . "
            WHERE path_md5='".md5($file_path)."'
            ORDER BY modification_date");
        while ($file_changer=vam_db_fetch_array($result)) {
            $array[]=array(
                'path_md5'=>$file_changer['path_md5'],
                'content_md5'=>$file_changer['content_md5'],
                'modification_date'=>$file_changer['modification_date'],
                'contrib'=>$file_changer['contrib'],
            );
        }
        return $array;
    }
    //Saves into database info about file after CIP made changes on them.
    function save_md5 ($file_path, $contrib=CONTRIB_INSTALLER_NAME){
        vam_db_perform('contrib_installer_files_integrity',
            array(
                'path_md5'=>md5($file_path),
                'content_md5'=>md5_file($file_path),
                'modification_date'=>'now()',
                'contrib'=>$contrib,
                 'path'=>str_replace(DIR_FS_CATALOG, '', $file_path),
            )
        );
    }
//===========================================================








class File_Integrity{

    // Class Constructor
    function File_Integrity() {
    }
    //  Class Methods


}
?>