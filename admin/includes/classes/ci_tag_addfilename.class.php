<?php
/*
Class Tc_createtable operates with createtable-tag from install.xml.
Made by Imrich Scindler
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_addfilename extends ContribInstallerBaseTag {
    var $tag_name='addfilename';
    // Class Constructor
    function Tc_addfilename($contrib='', $id='', $xml_data='', $dep='') {
        $this->params=array(
            'filename'=>array(
                                'sql_type'=>'varchar (255)',
                                'xml_error'=>"no file definition; "
                                ),
            'dir'=>array(
                                'sql_type'=>"ENUM ('admin', 'catalog')",
                                //'xml_error'=>"no table definition; " default - normal
                                ),
            'name'=>array(
                                'sql_type'=>'varchar (255)',
                                'xml_error'=>"no file name definition; "
                                ),

        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }

    function get_data_from_xml_parser($xml_data='') {
    	$this->data['filename']=array();
        $this->data['dir']=array();
        $this->data['name']=array();
        $tags = $xml_data->getElementsByTagName('file');
    	for($i=0 ;$i < $tags->getLength(); $i++){
        	$this->data['filename'][]   =$this->getITagAttr($tags,$i,'name');
        	$this->data['dir'][]   		=$this->getITagAttr($tags,$i,'type');
        	$this->data['name'][]       =$this->getITagText($tags,$i);
  		}
    }
    //===============================================================
    function do_install() {
		$tblrowsa = "";
		$tblrows  = "";
    	for($i=0;$i < count($this->data['name']); $i++){
			$def = $this->data['filename'][$i];
			$val = $this->data['name'][$i];
			$pos = strpos($def, "FILENAME_");
			if ($pos !== false) {
				$def = substr($def, 9);
			}
			$pos = strpos($val, ".php");
			if ($pos > 0) {
				$val = substr($val, 0, $pos);
			}
			if ($this->data['dir'][$i]== 'admin'){
				$tblrowsa .= "  define('CONTENT_" . $def . "','" . $val . "');\n";
				$tblrowsa .= "  define('FILENAME_" . $def . "',CONTENT_" . $def . ".'.php');\n";
			}else{
				$tblrows .= "  define('CONTENT_" . $def . "','" . $val . "');\n";
				$tblrows .= "  define('FILENAME_" . $def . "',CONTENT_" . $def . ".'.php');\n";
			}
    	}
		if ($tblrows != '')
			$output .= $this->add_file_end("includes/filenames.php", $this->linebreak_fixing("\n" . $this->comment_string($tblrows)));
		if ($tblrowsa != '')
			$output .= $this->add_file_end("admin/includes/filenames.php", $this->linebreak_fixing("\n" . $this->comment_string($tblrowsa)));
        return $this->error;
    }

	function do_remove() {
		$tblrowsa = "";
		$tblrows  = "";
    	for($i=0;$i < count($this->data['name']); $i++){
			$def = $this->data['filename'][$i];
			$val = $this->data['name'][$i];
			$pos = strpos($def, "FILENAME_");
			if ($pos !== false) {
				$def = substr($def, 9);
			}
			$pos = strpos($val, ".php");
			if ($pos > 0) {
				$val = substr($val, 0, $pos);
			}
			if ($this->data['dir'][$i]== 'admin'){
				$tblrowsa .= "  define('CONTENT_" . $def . "','" . $val . "');\n";
				$tblrowsa .= "  define('FILENAME_" . $def . "',CONTENT_" . $def . ".'.php');\n";
			}else{
				$tblrows .= "  define('CONTENT_" . $def . "','" . $val . "');\n";
				$tblrows .= "  define('FILENAME_" . $def . "',CONTENT_" . $def . ".'.php');\n";
			}
    	}
		if ($tblrows != '')
			$output .= $this->remove_file_part("includes/filenames.php", $this->linebreak_fixing("\n" . $this->comment_string($tblrows)));
		if ($tblrowsa != '')
			$output .= $this->remove_file_part("admin/includes/filenames.php", $this->linebreak_fixing("\n" . $this->comment_string($tblrowsa)));
        return $this->error;
    }
}
?>