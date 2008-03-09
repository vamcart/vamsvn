<?php
/*
Class AddFile operates with addfile tag from install.xml.
Made by Vlad Savitsky
    http://forums.oscommerce.com/index.php?showuser=20490
Support:
    http://forums.oscommerce.com/index.php?showtopic=156667
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_addfile extends ContribInstallerBaseTag {
    var $tag_name='addfile';
    var $data;
    var $params;//array with attributes
// Class Constructor
    function Tc_addfile($contrib='', $id='', $xml_data='', $dep='') {
        $this->params=array(
            'filename'=>array(
                                'sql_type'=>'varchar(255)',
                                'xml_error'=>NAME_OF_FILE_MISSING_IN_ADDFILE_SECTION_TEXT
                                ),
            'srcdir'=>array(
                                'sql_type'=>'varchar(255)',
                                ),
        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }
//  Class Methods
    function get_data_from_xml_parser($xml_data='') {
    	$this->data['filename']=array();
		$this->data['srcdir'] = array();
		$tags = $xml_data->getElementsByTagName('file');
		for ($i = 0; $i < $tags->getLength(); $i++) {
		   	$this->data['filename'][$i] = $this->getITagAttr($tags,$i,'name');
    		$this->data['srcdir'][$i] = $this->getITagAttr($tags,$i,'srcdir');
    		if($this->data['srcdir'][$i]==NULL)$this->data['srcdir'][$i] = 'catalog';
		}

    }

    function write_to_xml() {
        $tag =  '<'.$this->tag_name.'>';
        for($i = 0; $i < count($this->data['filename']);$i++){
            $tag .='<file name="'.$this->data['filename'][$i].'" srcdir="'.$this->data['srcdir'][$i].'"/>';
        }
        $tag.='</'.$this->tag_name.'>';
    }

    //2.0.4 b
    function permissions_check_for_remove() {
        //$this->permissions_check_for_install();
    }
    function permissions_check_for_install() {
        if ($this->error)    return;
        for($i = 0; $i < count($this->data['filename']);$i++){
            if(!is_dir(dirname($this->fs_filename($i))))    $this->recursive_mkdir(dirname($this->fs_filename($i)));
            if(!is_writable(dirname($this->fs_filename($i)))) {
                $this->error(WRITE_PERMISSINS_NEEDED_TEXT.dirname($this->fs_filename($i))."/");
                return $this->error;
            }
            if(file_exists($this->fs_filename($i)) && !is_writable($this->fs_filename($i))) {
                $this->error(WRITE_PERMISSINS_NEEDED_TEXT.$this->fs_filename($i));
                return $this->error;
        }
        }
        return $this->error;
    }
    //2.0.4 e

    function conflicts_check_for_install() {
        if ($this->error)    return;
	    for($i = 0; $i < count($this->data['filename']);$i++){
	        $cip_file=DIR_FS_CIP.'/'.$this->contrib.'/'.$this->data['srcdir'][$i].'/'.$this->data['filename'][$i];
	        $current_file=$this->fs_filename($i);
	        $backup_file=DIR_FS_ADMIN_BACKUP.CONTRIB_INSTALLER_NAME."_".CONTRIB_INSTALLER_VERSION.'/'. $this->data['filename'][$i];
        //echo md5_file($current_file) .'= '.md5_file($backup_file);
        //echo $cip_file."<br>".$current_file."<br>".$backup_file."<hr>";
	        // check if file is already copied
			if($this->equal_files($cip_file,$current_file)) continue;
        if (!file_exists($cip_file))    $this->error(FILE_NOT_EXISTS_TEXT.' '.$cip_file);
        //If file was modified since Contrib Installer have been installed and
        //ALLOW_OVERWRITE_MODIFIED set to FALSE we couldn't overwrite.

        if (ALLOW_OVERWRITE_MODIFIED=='false') {
            if (!is_file($cip_file)) {
                $this->error("Backup file ".$backup_file." is not exists. This file needed to check if file". $current_file. " was modified since Contrib Installer have been installed.
                <br><b>Advise</b>:<br>
                Set \"Allow Overwrite Existing Modified Files\" to TRUE and all modified files will be overwritten.
                All changes will be lost!<br>
                <i>or</i><br>
                Copy clean osCommerce files to     ".DIR_FS_CIP."/".CONTRIB_INSTALLER_NAME."_".CONTRIB_INSTALLER_VERSION. "/catalog/ and try again.");
	            } elseif (file_exists($current_file) && file_exists($backup_file)&& !$this->equal_files($current_file, $backup_file)) {
                $this->error("File ".$current_file." exists and was modified since Contrib Installer have been installed. Overwriting is not allowed.<br><b>Advise</b>:<br>Set \"Allow Overwrite Existing Modified Files\" to TRUE or change install.xml.");
	                return $this->error;
	            }
            }
        }
        return $this->error;
    }

    function conflicts_check_for_remove() {
        if ($this->error)    return;
        for($i = 0; $i < count($this->data['filename']);$i++){
	        $cip_file=DIR_FS_CIP.'/'.$this->contrib.'/'.$this->data['srcdir'][$i].'/'.$this->data['filename'][$i];
	        $current_file=$this->fs_filename($i);
	        $backup_file=DIR_FS_ADMIN_BACKUP.$this->contrib.'/'.$this->data['filename'][$i];

        //This is not an error because we could add new file:
        //if (!file_exists($backup_file))    $this->error(FILE_NOT_EXISTS_TEXT.' '. $backup_file);
        /*
        Если проверять бэкап-файл на наличие, то нужно проверить был ли он.
        Если был и не стало, то это ошибка.
        Можно проверить по СИ бэкапу, но с тех пор другой пакет мог удалить файл, а я выдам ошибку.
        Это может быть конфликт между пакетами.
        */


        //If file doesn't exists it's not an error and we will restore him.
        //An error if file exists and have been modified and ALLOW_OVERWRITE_MODIFIED=='false'
        if (!is_file($current_file))    return;
        //If file was modified since CIP have been installed and
        //ALLOW_OVERWRITE_MODIFIED set to FALSE we couldn't overwrite.

		if (ALLOW_OVERWRITE_MODIFIED=='false') {
			if (is_file($cip_file)) {
				if (!$this->equal_files($current_file, $cip_file)) {
					$this->error("File ".$current_file." exists and was modified since CIP have been installed. Overwriting is not allowed.<br><b>Advise</b>:<br>Set \"Allow Overwrite Existing Modified Files\" to TRUE or change install.xml.".$cip_file);
				}
			} else {
				$this->error("File ".$cip_file." needed to check if file". $current_file. " was modified since CIP have been installed.
				<br><b>Advise</b>:<br>
				Restore CIP files in Contributions folder and try again.<br>
				<i>or</i><br>
				Set \"Allow Overwrite Existing Modified Files\" to TRUE and all modified files will be overwritten.
				All changes will be lost!");
			}
		}
        }
        return $this->error;
    }



    function do_install() {
      if ($this->error)    return;
      for($i = 0; $i < count($this->data['filename']);$i++){
        $cip_file=DIR_FS_CIP.'/'.$this->contrib.'/'.$this->data['srcdir'][$i].'/'.$this->data['filename'][$i];
        if (is_file($this->fs_filename($i))) {
          //if file is copied
          if($this->equal_files($cip_file,$this->fs_filename($i))) continue;
          //If file exists we should backup them. Later we could restore him.
          //If we couldn't backup we should print an error and stop.
          //If Total_Backup havn't been done we should do it.
          if (ALLOW_FILES_BACKUP=='false')     $this->backup_file($this->data['filename'][$i]);
          ci_remove($this->fs_filename($i));
        }
        //We copy file to right location:
        if(@ !copy($cip_file, $this->fs_filename($i))) {
          $this->error("Run time error: ".COULDNT_COPY_TO_TEXT.$this->fs_filename($i));
          return $this->error;
        } elseif (file_exists($this->fs_filename($i)))    chmod($this->fs_filename($i), 0777);
      }
      return $this->error;
    }




    function do_remove() {
      if ($this->error)    return;
      for($i = 0; $i < count($this->data['filename']);$i++){
        $backup_file=DIR_FS_ADMIN_BACKUP.$this->contrib.'/'.$this->data['filename'][$i];
        if (!file_exists($backup_file)) @unlink($this->fs_filename($i));
        if (ALLOW_FILES_RESTORE=='false' && file_exists($backup_file))     $this->restore_file($this->data['filename'][$i]);
      }
      return $this->error;
    }



}

/*

ToDO:
1. I want to know which CIP added each file.
Comments is not working because we could add images.



How it works?

Install.
Contrib Installer will add your file.
But we don't want to lose any changes so we will do some checks.

CIP should contain file that you want to add. If file not exists you will get an error.

If file with the same name and location exists Contrib Installer
will check if file was modified since Contrib Installer have been installed.
For this check we use a file from Contrib Installer backup folder.

If file was modified and overwriting is not allowed Contrib Installer will stops with an error message.
If overwriting is allowed file will be overwriten.

File from shop will be backuped if:
- file exists and was not changed,
- file was modified and overwriting is allowed


Remove.

When removes ADDFILE changes we also check if file that we add to system was modified.
Contrib Installer compare file in shop with file in CIP folder to see if they differs.
If file was modified since CIP have been installed and overwriting is not allowed you will get an error message.

File will be restored from backup if:
- file wasn't changed
- file was modified but overwriting is allowed

So Contrib Installer will restore file that have been in shop before CIP installation if:
- file have been in shop,
- file added by CIP was not changed after CIP have been installed,
- file was changed but overwiting is allowed.

*/
?>