<?php
/*
Class PHP operates with php-tag from install.xml.
Made by Vlad Savitsky
    http://forums.oscommerce.com/index.php?showuser=20490
Support:
    http://forums.oscommerce.com/index.php?showtopic=156667
Released under GPL
*/

defined( '_VALID_XTC' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_php extends ContribInstallerBaseTag {
    var $tag_name='php';
// Class Constructor
    function Tc_php($contrib='', $id='', $xml_data='', $dep='') {
        $this->params=array(
            'install'=>array(
                                'sql_type'=>'text',
                                'xml_error'=>NO_INSTALL_TAG_IN_PHP_SECTION_TEXT
                                ),
            'remove'=>array(
                                'sql_type'=>'text',
                                'xml_error'=>NO_REMOVE_TAG_IN_PHP_SECTION_TEXT
                                ),
        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }
//  Class Methods
    function get_data_from_xml_parser($xml_data='') {
        $this->data['install']	=$this->replace_dbprefix($this->getTagText($xml_data,'install',0));
        $this->data['remove']   =$this->replace_dbprefix($this->getTagText($xml_data,'remove',0));
    }

    function write_to_xml() {
        return '
       <'.$this->tag_name.'>
            <install><![CDATA['.$this->data['install'].']]></install>
            <remove><![CDATA['.$this->data['remove'].']]></remove>
        </'.$this->tag_name.'>';
    }

    function do_install() {return $this->work($this->data['install']);}
    function do_remove() {return $this->work($this->data['remove']);}
    function work($code='') {
        if(!$code)    return;
        ob_start(); //While output buffering is active no output is sent from the script (other than headers)
        $result=@eval($code);
        //if(is_null($result)) {} //All ok. but we don't have a return in $this->data['install']
        //In PHP 3, eval() does not return a value.
        if ($result===false)     $this->error('Parse error in the evaluated code.');            ob_end_clean();//turn off
        return $this->error;
    }



}//Class end
/*
====================================================================
            [PHP] => Array
                (
                    [0] => Array
                        (
                            [@] =>
                            [INSTALL] => Array
                                (
                                    [0] => Array
                                        (
                                            [@] =>
                                            [#] =>
                                                mysql_query("INSERT INTO configuration_group VALUES (NULL, 'Contrib Installer', 'Configuration for the Contrib Installer', NULL, 1)");
                                        )
                                )
                            [REMOVE] => Array
                                (
                                    [0] => Array
                                        (
                                            [@] =>
                                            [#] =>echo "Done.";
                                        )
                                )
                        )
                )
====================================================================
*/
?>