<?php
/*
Class FindReplace operates with findreplace-tag from install.xml.
Made by Vlad Savitsky
    http://forums.oscommerce.com/index.php?showuser=20490
Support:
    http://forums.oscommerce.com/index.php?showtopic=156667
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_findreplace extends ContribInstallerBaseTag {
    var $tag_name='findreplace';
// Class Constructor
    function Tc_findreplace($contrib='', $id='', $xml_data='', $dep='') {
        $this->params=array(
            'filename'=>array(
                                'sql_type'=>'varchar (255)',
                                'xml_error'=>"no file name; "
                                ),
            'find'        =>array(
                                'sql_type'=>'text',
                                'xml_error'=>"no find section; "
                                ),
            'replace'=>array(
                                'sql_type'=>'text',
                                'xml_error'=>"no replace section; "
                                ),
            'replace_type'=>array(
                                'sql_type'=>"ENUM ('php', 'html')",
//                                'xml_error'=>''//not nessesary. default is 'php'
                                ),
            'type'=>array(
                                'sql_type'=>"ENUM ('continued')",
                                'xml_error'=>"no linenumbers; "
                                ),
            'start'=>array(
                                'sql_type'=>'SMALLINT UNSIGNED',
                                'xml_error'=>"no linenumbers; "
                                ),
            'end'=>array(
                                'sql_type'=>'SMALLINT UNSIGNED',
                                'xml_error'=>"no linenumbers; "
                                ),
        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }
//  Class Methods
    function get_data_from_xml_parser($xml_data='') {
        $this->data['filename']         =$this->getTagAttr($xml_data,'file',0,'name');
        $this->data['find']             =$this->getTagText($xml_data,'find',0);
        $this->data['replace']          =$this->getTagText($xml_data,'replace',0);
        $this->data['replace_type']     =$this->getTagAttr($xml_data,'replace',0,'type');

        $this->data['type'] = $this->getTagAttr($xml_data,'findlinenumbers',0,'type');
        if(!isset($this->data['type']))$this->data['type'] = $this->getTagAttr($xml_data,'originallinenumbers',0,'type');

        $this->data['start'] = $this->getTagAttr($xml_data,'findlinenumbers',0,'start');
        if(!isset($this->data['start']))$this->data['start'] = $this->getTagAttr($xml_data,'originallinenumbers',0,'start');

        $this->data['end'] = $this->getTagAttr($xml_data,'findlinenumbers',0,'end');
        if(!isset($this->data['end']))$this->data['end'] = $this->getTagAttr($xml_data,'originallinenumbers',0,'end');
    }


    function write_to_xml() {
        $tag='
        <'.$this->tag_name.'>
            <file name="'.$this->data['filename'].'" />';
            if ($this->data['type'])    $tag.='<originallinenumbers start="'.$this->data['start'].'" end="'.$this->data['end'].'"/>';
            else $tag.='<originallinenumbers type="'.$this->data['type'].'"/>';
        $tag.='<find><![CDATA['.$this->data['find'].']]></find>
            <replace type="'.$this->data['replace_type'].'"><![CDATA['.$this->data['replace'].']]></replace>
      </'.$this->tag_name.'>';
      return $tag;
    }


    function do_install() {
        $find=$this->linebreak_fixing(trim($this->data['find']));
        $repstr = $this->rep_str();
        $rfind = $this->cnv_to_regex($find);
        $old_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $count = preg_match_all($rfind,$old_file,$matches,PREG_OFFSET_CAPTURE);
        if ($this->multi_search() or $count==1)     $new_file=preg_replace($rfind, $repstr, $old_file);
        else {//if ($count>1)
            preg_match_all('((?m)(^.*$))',$old_file,$m,PREG_OFFSET_CAPTURE);
            $start = (int)$m[0][$this->get_real_start($old_file)-1][1];
            $end = (int)$m[0][$this->get_real_end($old_file)][1];
            $start_piece = substr($old_file,0,$start);
            $piece = substr($old_file,$start,$end-$start);
            $end_piece = substr($old_file,$end);
            $new_file=$start_piece . preg_replace($rfind, $repstr, $piece) . $end_piece;
        }
        $this->write_to_file($this->fs_filename(), $new_file);
        //save_md5 ($this->fs_filename(), $_GET['contrib']);
        return $this->error;
    }

    function do_remove() {
        $find=$this->linebreak_fixing(trim($this->data['find']));
        $old_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $new_file=preg_replace($this->cnv_to_regex($this->rep_str($this->get_num_lines($find))), $find, $old_file);
        $this->write_to_file($this->fs_filename(), $new_file);
        return $this->error;
    }


    function permissions_check_for_remove() {
        return $this->permissions_check_for_install($this->filename);
    }
    function permissions_check_for_install() {
        if (!file_exists($this->fs_filename()))    $this->error(CANT_READ_FILE.$this->fs_filename());
        elseif(!is_writable($this->fs_filename()))    $this->error(WRITE_PERMISSINS_NEEDED_TEXT.$this->fs_filename());
        return $this->error;
    }





    function conflicts_check_for_remove() {
        return $this->conflicts_check_for_install(0);
    }


    function conflicts_check_for_install($inst=1) {
        if (inst==1){
        	$find=$this->linebreak_fixing(trim($this->data['find']));
        	$repstr = $this->rep_str($this->get_num_lines($find));
        }else{
        	$repstr=$this->linebreak_fixing(trim($this->data['find']));
        	$find = $this->rep_str($this->get_num_lines($repstr));
        }
        $rfind = $this->cnv_to_regex($find);
        $rrepstr = $this->cnv_to_regex($repstr);
        $new_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $this->write_to_file($this->fs_filename(), $new_file);
        $count = preg_match_all($rfind,$new_file,$matches);
        //We can also check a database records for conflicts.
        if ($count==0) {
        	// check if already replaced
        	$count=preg_match_all($rrepstr,$new_file,$matches);
        	if($count == 0){
            $this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($find))."<br> ".IN_THE_FILE_TEXT. $this->fs_filename());
        	}
        } elseif ($count>1) {
            if (!$this->multi_search()) {
                preg_match_all('((?m)(^.*$))',$new_file,$m,PREG_OFFSET_CAPTURE);
            	$start = (int)$m[0][$this->get_real_start($new_file)-1][1];
            	$end = (int)$m[0][$this->get_real_end($new_file)][1];
            	$piece = substr($new_file,$start,$end-$start);
                $count=preg_match_all($rfind,$piece,$matches);
                if ($count==0) {
                	$count=preg_match_all($rrepstr,$piece,$matches);
                	if($count == 0){
	                    $this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($find))."<br> ".IN_THE_FILE_TEXT. $this->fs_filename(). " ".CIP_ON_LINES." ".CIP_ON_LINES_FROM." ".$this->data['start']." ".CIP_ON_LINES_TO." ".$this->data['end']);
    	            }
                } elseif ($count>1)     $this->error(TEXT_NOT_ORIGINAL_TEXT.TEXT_HAVE_BEEN_FOUND.$count.TEXT_TIMES.'<br>'. IN_THE_FILE_TEXT. $this->fs_filename(). " ".CIP_ON_LINES." ".CIP_ON_LINES_FROM." ".$this->data['start']." ".CIP_ON_LINES_TO." ".$this->data['end']);
            }
        }
        return $this->error;
    }







}
/*
====================================================================
            [FINDREPLACE] => Array
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
                                                    [NAME] => admin/includes/boxes/tools.php
                                                )

                                            [#] =>
                                        )

                                )

                            [ORIGINALLINENUMBERS] => Array
                                (
                                    [0] => Array
                                        (
                                            [@] => Array
                                                (
                                                    [START] => 21
                                                    [END] => 21
                                                )

                                            [#] =>
                                        )

                                )

                            [FIND] => Array
                                (
                                    [0] => Array
                                        (
                                            [@] =>
                                            [#] => 'link'  => vam_href_link(FILENAME_BACKUP, 'selected_box=tools'));

                                        )

                                )

                            [REPLACE] => Array
                                (
                                    [0] => Array
                                        (
                                            [@] => Array
                                                (
                                                    [TYPE] => php
                                                )

                                            [#] =>
'link'  => vam_href_link(FILENAME_CONTRIB_INSTALLER, 'selected_box=tools'));

                                        )

                                )
====================================================================
*/

?>