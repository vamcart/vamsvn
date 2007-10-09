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
        $old_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $count=substr_count($old_file, $find);
        if ($this->multi_search() or $count==1)     $new_file=str_replace($find, $this->rep_str(), $old_file);
        else {//if ($count>1)
            $file2array=explode("\r\n", $old_file);
            foreach($file2array as $id=>$string) {
                if ($id<($this->data['start']-1))     $start_piece.=$file2array[$id]."\r\n";
                else {
                    if ($id<=($this->data['end']-1))     $piece.=$file2array[$id]."\r\n";
                    else     $end_piece.=$file2array[$id]."\r\n";
                }
            }
            $new_file=$start_piece . str_replace($find, $this->rep_str(), $piece) . $end_piece;
        }
        $this->write_to_file($this->fs_filename(), $new_file);
        //save_md5 ($this->fs_filename(), $_GET['contrib']);
        return $this->error;
    }

    function do_remove() {
        $find=$this->linebreak_fixing(trim($this->data['find']));
        $old_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $new_file=str_replace($this->rep_str(), $find, $old_file);
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
        return $this->conflicts_check_for_install($this->rep_str());
    }


    function conflicts_check_for_install($find='') {
        if (!$find)     $find=$this->linebreak_fixing(trim($this->data['find']));
        $new_file=$this->linebreak_fixing(file_get_contents($this->fs_filename()));
        $this->write_to_file($this->fs_filename(), $new_file);
        $count=substr_count($new_file, $find);
        //We can also check a database records for conflicts.
        if ($count==0) {
        	// check if already replaced
        	if(substr_count($new_file, $this->rep_str())==0)
            $this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($find))."<br> ".IN_THE_FILE_TEXT. $this->fs_filename());
        } elseif ($count>1) {
            if (!$this->multi_search()) {
                $file2array=explode("\r\n", $new_file);
                for ($i=($this->data['start']-1); $i<=($this->data['end']-1); $i++)     $piece.=$file2array[$i];
                $count=substr_count($piece, $find);
                if ($count==0) {
                	if(substr_count($piece, $this->rep_str())==0)
                    $this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($find))."<br> ".IN_THE_FILE_TEXT. $this->fs_filename());
                } elseif ($count>1)     $this->error(TEXT_NOT_ORIGINAL_TEXT.TEXT_HAVE_BEEN_FOUND.$count.TEXT_TIMES);
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