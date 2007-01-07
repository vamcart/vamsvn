<?php
/*
Class AddCode operates with addcode-tag from install.xml.
Made by Vlad Savitsky
    http://forums.oscommerce.com/index.php?showuser=20490
Support:
    http://forums.oscommerce.com/index.php?showtopic=156667
Released under GPL
*/

defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_addcode extends ContribInstallerBaseTag {
    var $tag_name='addcode';
    // Class Constructor
    function Tc_addcode($contrib='', $id='', $xml_data='', $dep='') {
        $this->params=array(
            'filename'=>array(
                                'sql_type'=>'varchar (255)',
                                'xml_error'=>"no file name; "
                                ),
            'find'        =>array(
                                'sql_type'=>'text',
                                'xml_error'=>"no find section; "
                                ),
            'add'=>array(
                                'sql_type'=>'text',
                                'xml_error'=>"no add section; "
                                ),
            'add_type'=>array(
                                'sql_type'=>"ENUM ('php', 'html')",
//                                'xml_error'=>''//not nessesary. default is 'php'
                                ),
            'type'=>array(
                                'sql_type'=>"ENUM ('continued', 'new')",
                                'xml_error'=>"no linenumbers type; "
                                ),
            'start'=>array(
                                'sql_type'=>'SMALLINT UNSIGNED',
                                'xml_error'=>"no linenumbers start; "
                                ),
            'end'=>array(
                                'sql_type'=>'SMALLINT UNSIGNED',
                                'xml_error'=>"no linenumbers end; "
                                ),
        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }
//  Class Methods

    function get_data_from_xml_parser($xml_data='') {
       	$this->data['filename']	=$this->getTagAttr($xml_data,'file',0,'name');
       	$this->data['find']     =$this->getTagText($xml_data,'find',0);
       	$this->data['add']      =$this->getTagText($xml_data,'add',0);
       	$this->data['add_type'] =$this->getTagAttr($xml_data,'add',0,'type');

        $this->data['type'] = $this->getTagAttr($xml_data,'findlinenumbers',0,'type');
        if(!isset($this->data['type']))$this->data['type'] = $this->getTagAttr($xml_data,'originallinenumbers',0,'type');

        $this->data['start'] = $this->getTagAttr($xml_data,'findlinenumbers',0,'start');
        if(!isset($this->data['start']))$this->data['start'] = $this->getTagAttr($xml_data,'originallinenumbers',0,'start');

        $this->data['end'] = $this->getTagAttr($xml_data,'findlinenumbers',0,'end');
        if(!isset($this->data['end']))$this->data['end'] = $this->getTagAttr($xml_data,'originallinenumbers',0,'end');
    }


    function write_to_xml() {
        return '
        <'.$this->tag_name.'>
            <file name="'.$this->data['filename'].'" />'."\n".
            (($this->data['type']) ?
            '<findlinenumbers type="'.$this->data['type'].'"/>' :
            '<findlinenumbers start="'.$this->data['start'].'" end="'.$this->data['end'].'"/>')."\n".
            '<find><![CDATA['.$this->data['find'].']]></find>
            <add type="'.$this->data['add_type'].'"><![CDATA['.$this->data['add'].']]></add>
        </'.$this->tag_name.'>';
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
        return $this->conflicts_check_for_install($this->add_str());
    }
    function conflicts_check_for_install($find='') {
        if (!$find)     $find=$this->linebreak_fixing(trim($this->data['find']));
        $new_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $this->write_to_file($this->fs_filename(), $new_file);
        $count=substr_count($new_file, $find);
        //We can also check a database records for conflicts.
        if ($count==0) {
        	// check if addcode is aplied
        	$count=substr_count($new_file, $this->add_str());
        	if($count == 0){
            $this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($find)). "<br>". IN_THE_FILE_TEXT. $this->fs_filename());
        	}
        } elseif ($count>1) {
            if (!$this->multi_search()) {
                $file2array=explode("\r\n", $new_file);
                for ($i=($this->data['start']-1); $i<=($this->data['end']-1); $i++)     $piece.=$file2array[$i];
                $count=substr_count($piece, $find);
                if ($count==0) {
                	$count=substr_count($piece, $this->add_str());
                	if($count == 0){
                    $this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($find))."<br> ".IN_THE_FILE_TEXT. $this->fs_filename());
    	            }
                } elseif ($count>1) {
                    $this->error(TEXT_NOT_ORIGINAL_TEXT.TEXT_HAVE_BEEN_FOUND.$count.TEXT_TIMES.'<br>'. IN_THE_FILE_TEXT. $this->fs_filename());
                }
            }
        }
        return $this->error;
    }

    //===============================================================
    function do_install() {
        $find=$this->linebreak_fixing(trim($this->data['find']));
        $old_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $count=substr_count($old_file, $find);
        if ($this->multi_search())     $new_file=str_replace($find, $this->add_str(), $old_file);
        elseif ($count==1) {
            $position=strpos($old_file, $find) + strlen($find); //pos from begining of file
            $new_file = substr_replace($old_file, $this->add_str(), $position, 0); //inserts string into another string
        } else {//if ($count>1)
            $file2array=explode("\r\n", $old_file);
            foreach($file2array as $id=>$string) {
                if ($id<($this->data['start']-1))     $start_piece.=$file2array[$id]."\r\n";
                else {
                    if ($id<=($this->data['end']-1))     $piece.=$file2array[$id]."\r\n";
                    else     break;
                }
            }
            //echo strpos($piece, $find);
            $position=(strlen($start_piece)) + (strpos($piece, $find)) + (strlen($find)); //pos from begining of file
            $new_file = substr_replace($old_file, $this->add_str(), $position, 0); //inserts string into another string
        }
        $this->write_to_file($this->fs_filename(), $new_file);
        //save_md5 ($this->fs_filename(), $_GET['contrib']);
        return $this->error;
    }

    function do_remove() {
        $old_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $new_file=str_replace($this->add_str(false), '', $old_file);
        $this->write_to_file($this->fs_filename(), $new_file);
        return $this->error;
    }
}

/*
====================================================================
            [ADDCODE] => Array
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
                                                    [NAME] => admin/index.php
                                                )
                                            [#] =>
                                        )
                                )
                            [FINDLINENUMBERS] => Array
                                (
                                    [0] => Array
                                        (
                                            [@] => Array
                                                (
                                                    [START] => 46
                                                    [END] => 50
                                                )
                                            [#] =>
                                        )
                                )
                            [FIND] => Array
                                (
                                    [0] => Array
                                        (
                                            [@] =>
                                            [#] =>text...
                                        )
                                )
                            [ADD] => Array
                                (
                                    [0] => Array
                                        (
                                            [@] => Array
                                                (
                                                    [TYPE] => php
                                                )
                                            [#] =>text...
                                        )
                                )
                        )
                )
====================================================================
*/
?>