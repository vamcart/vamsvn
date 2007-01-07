<?php
/**
Class add2end operates with add2end-tag from install.xml.
Made by Imrich Schindler <ischindl at progis.sk>
Released under GPL
*/

defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_add2end extends ContribInstallerBaseTag {
    var $tag_name='add2end';
    // Class Constructor
    function Tc_add2end($contrib='', $id='', $xml_data='', $dep='') {
        $this->params=array(
            'filename'=>array(
                                'sql_type'=>'varchar (255)',
                                'xml_error'=>"no file name; "
                                ),
            'add'=>array(
                                'sql_type'=>'text',
                                'xml_error'=>"no add section; "
                                ),
            'type'=>array(
                                'sql_type'=>"ENUM ('php', 'html')",
                                ),
        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }
//  Class Methods

    function get_data_from_xml_parser($xml_data='') {
    	$this->data['filename'] = $this->getTagAttr($xml_data,'file',0,'name');
       	$this->data['add']      = $this->getTagText($xml_data,'add',0);
       	$this->data['type'] = $this->getTagAttr($xml_data,'add',0,'type');
        if($this->data['find']==''){
			$this->data['end'] = 1;
			$this->data['start'] =1;
        }
    }


    function write_to_xml() {
        $tag = '
        <'.$this->tag_name.'>
            <file name="'.$this->data['filename'].'" />
            <add '. (($this->data['type']) ? 'type="'.$this->data['type'].'"' : '') .'><![CDATA['. $this->data['add']. ']]></add>
        </'.$this->tag_name.'>';
       return $tag;
    }
    //===============================================================
    function permissions_check_for_install($name='') {
        if (!$name)  $name=$this->fs_filename();
        if (!file_exists($name))     $this->error(CANT_READ_FILE.$name);
        elseif(!is_writable($name))    $this->error(WRITE_PERMISSINS_NEEDED_TEXT.$name);
        return $this->error;
    }

    function permissions_check_for_remove() {
        return $this->permissions_check_for_install($this->fs_filename());
    }
    //===============================================================
    function conflicts_check_for_remove() {
        $find=$this->add_str();
        $new_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $this->write_to_file($this->fs_filename(), $new_file);
        $count=substr_count($new_file, $find);
        //We can also check a database records for conflicts.
        if ($count==0) {
            $this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($find)). "<br>". IN_THE_FILE_TEXT. $this->fs_filename());
        } elseif ($count>1) {
            if (!$this->multi_search()) {
                $file2array=explode("\r\n", $new_file);
                for ($i=($this->data['start']-1); $i<=($this->data['end']-1); $i++)     $piece.=$file2array[$i];
                $count=substr_count($piece, $find);
                if ($count==0) {
                    $this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($find))."<br> ".IN_THE_FILE_TEXT. $this->fs_filename());
                } elseif ($count>1)     $this->error(TEXT_NOT_ORIGINAL_TEXT.TEXT_HAVE_BEEN_FOUND.$count.TEXT_TIMES);
            }
        }
        return $this->error;
    }
    function conflicts_check_for_install() {return $this->error;}

    //===============================================================
    function do_install() {
        $find=$this->linebreak_fixing(trim($this->data['find']));
        $old_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $this->add_file_end($this->data['filename'],$this->add_str());
        return $this->error;
    }

    function do_remove() {
        $old_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $new_file=str_replace($this->add_str(), "\n", $old_file);
        $this->write_to_file($this->fs_filename(), $new_file);
        return $this->error;
    }
}

/*
====================================================================
<add2end>
	<file name="filename.php"/>
	<add type="php"><![CDATA[ ... ]]></add>
</add2end>
====================================================================
*/
?>