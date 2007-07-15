<?php
/*
Class AddCode operates with addcode-tag from install.xml.
Made by Vlad Savitsky
    http://forums.oscommerce.com/index.php?showuser=20490
Support:
    http://forums.oscommerce.com/index.php?showtopic=156667
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_addmodbox extends ContribInstallerBaseTag {
    var $tag_name='addmodbox';
    // Class Constructor
    function Tc_addmodbox($contrib='', $id='', $xml_data='', $dep='') {
        $this->params=array(
            'filename'=>array(
                                'sql_type'=>'varchar (255)',
                                'xml_error'=>"no file name; "
                                ),
            'name'        =>array(
                                'sql_type'=>'text',
                                'xml_error'=>"no name section; "
                                ),
        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }
//  Class Methods

    function get_data_from_xml_parser($xml_data='') {
       	$this->data['filename']	=$this->getTagAttr($xml_data,'file',0,'name');
       	$this->data['name']     =$this->getTagText($xml_data,'file',0);
       	$this->data['add']	='      <option value="'.$this->getTagAttr($xml_data,'file',0,'name').'">'.$this->getTagText($xml_data,'file',0).'</option>';
       	$this->data['add_type'] = 'html';
    }

	function fs_filename(){
		return DIR_FS_ROOT.DIR_BASE_CATALOG.'modules/mod_josc_box.xml';
	}

    function write_to_xml() {
        return '
        <'.$this->tag_name.'>
            <file name="'.$this->data['filename'].'" >'.$this->data['name']."</file>\n".
        '</'.$this->tag_name.'>';
    }


    //===============================================================
    function permissions_check_for_install($name='') {
    	if(!$this->isJoscom()) return;
        if (!$name)  $name=$this->fs_filename();
        if (!file_exists($name))     $this->error(CANT_READ_FILE.$name);
        elseif(!is_writable($name))    $this->error(WRITE_PERMISSINS_NEEDED_TEXT.$name);
        return $this->error;
    }
    function permissions_check_for_remove() {
        return $this->permissions_check_for_install();
    }

    //===============================================================
    function do_install() {
    	if(!$this->isJoscom()) return;
        $find=$this->linebreak_fixing(trim('<param name="josc_module" type="list" default="categories" label="JOSC Module" description="Select which module to load.">'));
        $old_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $position=strpos($old_file, $find) + strlen($find); //pos from begining of file
        $new_file = substr_replace($old_file, $this->add_str(), $position, 0); //inserts string into another string
        $this->write_to_file($this->fs_filename(), $new_file);
        //save_md5 ($this->fs_filename(), $_GET['contrib']);
        return $this->error;
    }

    function do_remove() {
    	if(!$this->isJoscom()) return;
        $old_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $new_file=str_replace($this->add_str(), '', $old_file);
        $this->write_to_file($this->fs_filename(), $new_file);
        return $this->error;
    }
}

/*
====================================================================
<addmodbox>
	<file name="bomtreemenu">Bom tree</file>
</addmodbox>
====================================================================
*/
?>