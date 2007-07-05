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
                                'sql_type'=>"ENUM ('php', 'html')"
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
            'before'=>array(
                                'sql_type'=>"ENUM ('yes', 'no')"
                                )
        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }
//  Class Methods

    function get_data_from_xml_parser($xml_data='') {
       	$this->data['filename']	=$this->getTagAttr($xml_data,'file',0,'name');
       	$this->data['find']     =$this->getTagText($xml_data,'find',0);
       	$this->data['add']      =$this->getTagText($xml_data,'add',0);
       	$this->data['add_type'] =$this->getTagAttr($xml_data,'add',0,'type');
       	$this->data['before']   =$this->getTagAttr($xml_data,'add',0,'before','no');

        $this->data['type'] = $this->getTagAttr($xml_data,'findlinenumbers',0,'type');
        if(!isset($this->data['type']))$this->data['type'] = $this->getTagAttr($xml_data,'originallinenumbers',0,'type');

        $this->data['start'] = $this->getTagAttr($xml_data,'findlinenumbers',0,'start');
        if(!isset($this->data['start']))$this->data['start'] = $this->getTagAttr($xml_data,'originallinenumbers',0,'start');

        $this->data['end'] = $this->getTagAttr($xml_data,'findlinenumbers',0,'end');
        if(!isset($this->data['end']))$this->data['end'] = $this->getTagAttr($xml_data,'originallinenumbers',0,'end');
    }

	function before(){
		return (($this->data['before']=='yes') ? true : false);
	}

    function write_to_xml() {
        return '
        <'.$this->tag_name.'>
            <file name="'.$this->data['filename'].'" />'."\n".
            (($this->data['type']) ?
            '<findlinenumbers type="'.$this->data['type'].'"/>' :
            '<findlinenumbers start="'.$this->data['start'].'" end="'.$this->data['end'].'"/>')."\n".
            '<find><![CDATA['.$this->data['find'].']]></find>
            <add type="'.$this->data['add_type'].'" before="'.$this->data['before'].'"><![CDATA['.$this->data['add'].']]></add>
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
        return $this->conflicts_check_for_install(0);
    }
    function conflicts_check_for_install($inst=1) {
        if ($inst==1){
        	$find=$this->linebreak_fixing(trim($this->data['find']));
        	$addstr = $this->add_str();
        }else{
        	$addstr =$this->linebreak_fixing(trim($this->data['find']));
        	$find = $this->add_str();
        }
        $rfind = $this->cnv_to_regex($find);
        $raddstr = $this->cnv_to_regex($addstr);
        $new_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $this->write_to_file($this->fs_filename(), $new_file);
        //$count=substr_count($new_file, $find);
        $count = preg_match_all($rfind,$new_file,$matches);
        //We can also check a database records for conflicts.
        if ($count==0) {
        	// check if addcode is aplied
        	$count=preg_match_all($raddstr,$new_file,$matches);
        	if($count == 0){
            $this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($find)). "<br>". IN_THE_FILE_TEXT. $this->fs_filename());
        	}
        } elseif ($count>1) {
         /*   if (!$this->multi_search()) {
                preg_match_all('((?m)(^.*$))',$new_file,$m,PREG_OFFSET_CAPTURE);
            	$start = (int)$m[0][$this->get_real_start($new_file)-1][1];
            	$end = (int)$m[0][$this->get_real_end($new_file)][1];
            	$piece = substr($new_file,$start,$end-$start);
                $count=preg_match_all($rfind,$piece,$matches);
                if ($count==0) {
                	$count=preg_match_all($raddstr,$piece,$matches);
                	if($count == 0){
                    $this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($find))."<br> ".IN_THE_FILE_TEXT. $this->fs_filename(). " ". CIP_ON_LINES." ".CIP_ON_LINES_FROM." ".$this->data['start']." ".CIP_ON_LINES_TO." ".$this->data['end']);
    	            }
                } elseif ($count>1) {
                    $this->error(TEXT_NOT_ORIGINAL_TEXT.TEXT_HAVE_BEEN_FOUND.$count.TEXT_TIMES.'<br>'. IN_THE_FILE_TEXT. $this->fs_filename(). " ".CIP_ON_LINES." ".CIP_ON_LINES_FROM." ".$this->data['start']." ".CIP_ON_LINES_TO." ".$this->data['end']);
                }
            }*/
        }
        return $this->error;
    }

    //===============================================================
    function do_install() {
        $find=$this->linebreak_fixing(trim($this->data['find']));
        $addstr = $this->add_str();
        $rfind = $this->cnv_to_regex($find);
        $old_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $count = preg_match_all($rfind,$old_file,$matches,PREG_OFFSET_CAPTURE);
        if ($this->multi_search() || $count == 1){
        	$new_file = "";
        	$i = 0;
        	foreach($matches[0] as $ma){
        		$position = (int)$ma[1];
        		$new_file .= substr($old_file,$i,$position - $i);
        		if($this->before()){
        			$new_file .= $addstr . $ma[0];
        		}else{
        			$new_file .= $ma[0]. $addstr;
        		}
	            $i = $position + strlen($ma[0]);
        	}
        	$new_file .= substr($old_file,$i);
        } else {//if ($count>1)
/*            preg_match_all('((?m)(^.*$))',$old_file,$m,PREG_OFFSET_CAPTURE);
            $start = (int)$m[0][$this->get_real_start($old_file)-1][1];
            $end = (int)$m[0][$this->get_real_end($old_file)][1];
            $piece = substr($old_file,$start,$end-$start);
            preg_match_all($rfind,$piece,$matches,PREG_OFFSET_CAPTURE);
            $position=$start + (int)$matches[0][0][1]; //pos from begining of file
            if(!$this->before()) $position += strlen($matches[0][0][0]);
            $new_file = substr_replace($old_file, $addstr, $position, 0); //inserts string into another string
  */      }
        $this->write_to_file($this->fs_filename(), $new_file);
        //save_md5 ($this->fs_filename(), $_GET['contrib']);
        return $this->error;
    }

    function do_remove() {
        $old_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $new_file=str_replace($this->add_str(), '', $old_file);
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