<?php
/*
Class Tc_createtable operates with createtable-tag from install.xml.
Made by Imrich Scindler
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_changelangdef extends ContribInstallerBaseTag {
    var $tag_name='changelangdef';
    // Class Constructor
    function Tc_changelangdef($contrib='', $id='', $xml_data='', $dep='') {
        $this->params=array(
            'lng'=>array(
                                'sql_type'=>'varchar (255)',
                                'xml_error'=>"no language definition; "
                                ),
            'dir'=>array(
                                'sql_type'=>"ENUM ('admin', 'catalog')",
                                //'xml_error'=>"no table definition; " default - normal
                                ),
            'name'=>array(
                                'sql_type'=>'varchar (255)',
                                'xml_error'=>"no text const definition; "
                                ),

        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }

    function get_data_from_xml_parser($xml_data='') {
    	$this->data['lng'] = array();
    	$this->data['dir'] = array();
    	$this->data['name'] = array();
    	$this->data['newname'] = array();
    	$this->data['changevalue'] = array();
    	$this->data['value'] = array();
    	$tags = $xml_data->getElementsByTagName('lang');
    	for($i=0 ;$i < $tags->getLength(); $i++){
        	$this->data['lng'][]   		=$this->getITagAttr($tags,$i,'lng');
        	$this->data['dir'][]   		=$this->getITagAttr($tags,$i,'type');
        	$this->data['name'][]   	=$this->getITagAttr($tags,$i,'name');
        	$this->data['newname'][]   	=$this->getITagAttr($tags,$i,'newname');
        	$this->data['changevalue'][]=$this->getITagAttr($tags,$i,'changevalue');
        	$this->data['value'][]  	=$this->getITagText($tags,$i);
    	}
    }

    //===============================================================
    function permissions_check_for_remove() {
    	return $this->permissions_check_for_install();
    }

    function permissions_check_for_install() {
    	$oldlng= '';
		$oldlnga= '';
    	for($i=0; $i < count($this->data['lng']);$i++){
       	    $lng = $this->data['lng'][$i] . ".php";
       	    $lang = $this->data['lng'][$i];
			if (strlen($lng) == 4) {
				$lng = "english.php";
			}
			if ($this->data['dir'][$i] == 'admin') {
				if($oldlnga != $lng){
					$odllnga = $lng;
					$fname = $this->get_fs_filename("lang/" . $lang . '/admin/' . $lng);
			    	if (!file_exists($fname)){
			    		$this->error(CANT_READ_FILE.$fname);
			    		break;
			    	}
			    	elseif(!is_writable($fname)){
			    		$this->error(WRITE_PERMISSINS_NEEDED_TEXT.$fname);
			    		break;
			    	}
				}
			}else{
				if($oldlng != $lng){
					$odllng = $lng;
					$fname = $this->get_fs_filename("lang/" . $lang . '/' . $lng);
			    	if (!file_exists($fname)){
			    		$this->error(CANT_READ_FILE.$fname);
			    		break;
			    	}
			    	elseif(!is_writable($fname)){
			    		$this->error(WRITE_PERMISSINS_NEEDED_TEXT.$fname);
			    		break;
			    	}
				}
			}
    	}
        return $this->error;
    }


 //===============================================================
    function conflicts_check_for_remove() {
		$oldlng= '';
		$oldlnga= '';
    	for($i=0; $i < count($this->data['lng']);$i++){
       	    $lng = $this->data['lng'][$i] . ".php";
      	    $lang = $this->data['lng'][$i];
			if (strlen($lng) == 4) {
				$lng = "english.php";
			}
			if ($this->data['dir'][$i] == 'admin') {
				if($oldlnga != $lng){
					$oldlnga = $lng;
			    	$new_filea=file_get_contents($this->get_fs_filename("lang/" . $lang . '/admin/' . $lng));
				}
			    if($this->data['newname'][$i] != ''){
			    	$count=substr_count($new_filea, $this->data['newname'][$i]);
			    	if($count == 0){
			    		$this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($this->data['newname'][$i]))."<br> ".IN_THE_FILE_TEXT. $this->get_fs_filename("lang/" . $lang . '/admin/' . $lng));
			    		break;
			    	}

			    }else{
			    	$count=substr_count($new_filea, $this->data['name'][$i]);
			    	if($count == 0){
			    		$this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($this->data['name'][$i]))."<br> ".IN_THE_FILE_TEXT. $this->get_fs_filename("lang/" . $lang . '/admin/' . $lng));
			    		break;
			    	}
			    }
			}else{
				if($oldlng != $lng){
					$oldlng = $lng;
			    	$new_file=file_get_contents($this->get_fs_filename("lang/" . $lang . '/' . $lng));
				}
			    if($this->data['newname'][$i] != ''){
			    	$count=substr_count($new_file, $this->data['newname'][$i]);
			    	if($count == 0){
			    		$this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($this->data['newname'][$i]))."<br> ".IN_THE_FILE_TEXT. $this->get_fs_filename("lang/" . $lang . '/' . $lng));
			    		break;
			    	}
			    }else{
			    	$count=substr_count($new_file, $this->data['name'][$i]);
			    	if($count == 0){
			    		$this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($this->data['name'][$i]))."<br> ".IN_THE_FILE_TEXT. $this->get_fs_filename("lang/" . $lang . '/' . $lng));
			    		break;
			    	}
			    }
			}
    	}
        return $this->error;
    }

    function conflicts_check_for_install($find='') {
		$oldlng= '';
		$oldlnga= '';
    	for($i=0; $i < count($this->data['lng']);$i++){
       	    $lng = $this->data['lng'][$i] . ".php";
       	    $lang = $this->data['lng'][$i];
			if (strlen($lng) == 4) {
				$lng = "english.php";
			}
			if ($this->data['dir'][$i] == 'admin') {
				if($oldlnga != $lng){
					$oldlnga = $lng;
			    	$new_filea=file_get_contents($this->get_fs_filename("lang/" . $lang . '/admin/' . $lng));
				}
			    $count=substr_count($new_filea, $this->data['name'][$i]);
		    	if($count == 0){
		    		// check if already replaced
		    		$count=substr_count($new_filea, $this->data['newname'][$i]);
		    		if($count == 0){
		    		$this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($this->data['name'][$i]))."<br> ".IN_THE_FILE_TEXT. $this->get_fs_filename("lang/" . $lang . '/admin/' . $lng));
		    		break;
		    	}
		    	}
			}else{
				if($oldlng != $lng){
					$oldlng = $lng;
			    	$new_file=file_get_contents($this->get_fs_filename("lang/" . $lang . '/' . $lng));
				}
			    $count=substr_count($new_file, $this->data['name'][$i]);
		    	if($count == 0){
		    		// check if already replaced
		    		$count=substr_count($new_file, $this->data['newname'][$i]);
		    		if($count == 0){
		    		$this->error(COULDNT_FIND_TEXT.": ".nl2br(htmlspecialchars($this->data['name'][$i]))."<br> ".IN_THE_FILE_TEXT. $this->get_fs_filename("lang/" . $lang . '/' . $lng));
		    		break;
		    	}
			}
    	}
    	}
        return $this->error;
    }

    //===============================================================
    function do_install() {
		$oldlng = '';
		$change = false;
		$old_file = '';
		$oldlnga = '';
		$changea = false;
		$old_filea = '';
    	for($i=0; $i < count($this->data['lng']);$i++){
    		$lng = $this->data['lng'][$i] . ".php";
     	   $lang = $this->data['lng'][$i];
			if (strlen($lng) == 4) {
				$lng = "english.php";
			}
			$newline='';
			if ($this->data['dir'][$i] == 'admin') {
				if($oldlnga != $lng){
					if($changea){
						$this->write_to_file($this->get_fs_filename("lang/" . $lang . '/admin/' .$oldlnga), $old_filea);
						$changea=false;
					}
					$oldlnga = $lng;
					$old_filea=$this->linebreak_fixing(file_get_contents($this->get_fs_filename("lang/" . $lang . '/admin/' . $lng)));
				}
				$line  = $this->get_lang_file_line($old_filea,$this->data['name'][$i]);
				if($this->data['newname'][$i] != ''){
					if($this->data['changevalue'][$i] != ''){
						// change value and name
						$newline = "/*".$line."*/\ndefine('".$this->data['newname'][$i]."','".$this->data['value'][$i]."');";
//						$newline = "/*".$line."*/\ndefine('".$this->data['newname'][$i]."','".unicode2win($this->data['value'][$i])."');";
					}else{
						// change only name
						$newline = str_replace($this->data['name'][$i],$this->data['newname'][$i],$line);
					}
				}else if($this->data['changevalue'][$i] != ''){
					// change only value - for example better translation
					$newline = "/*".$line."*/\ndefine('".$this->data['name'][$i]."','".$this->data['value'][$i]."');";
//					$newline = "/*".$line."*/\ndefine('".$this->data['name'][$i]."','".unicode2win($this->data['value'][$i])."');";
				}
				if ($newline != '') {
					$old_filea = str_replace($line,$this->linebreak_fixing("\n" . $this->comment_string($newline)),$old_filea);
					$changea = true;
				}
			}else{
				if($oldlng != $lng){
					if($change){
						$this->write_to_file($this->get_fs_filename("lang/" . $lang . '/' .$oldlng), $old_file);
						$change=false;
					}
					$oldlng = $lng;
					$old_file=$this->linebreak_fixing(file_get_contents($this->get_fs_filename("lang/" . $lang . '/admin/' . $lng)));
				}
				$line  = $this->get_lang_file_line($old_file,$this->data['name'][$i]);
				if($this->data['newname'][$i] != ''){
					if($this->data['changevalue'][$i] != ''){
						// change value and name
						$newline = "/*".$line."*/\ndefine('".$this->data['newname'][$i]."','".$this->data['value'][$i]."');";
//						$newline = "/*".$line."*/\ndefine('".$this->data['newname'][$i]."','".unicode2win($this->data['value'][$i])."');";
					}else{
						// change only name
						$newline = str_replace($this->data['name'][$i],$this->data['newname'][$i],$line);
					}
				}else if($this->data['changevalue'][$i] != ''){
					// change only value - for example better translation
					$newline = "/*".$line."*/\ndefine('".$this->data['name'][$i]."','".$this->data['value'][$i]."');";
//					$newline = "/*".$line."*/\ndefine('".$this->data['name'][$i]."','".unicode2win($this->data['value'][$i])."');";
				}
				if ($newline != '' && $line != '') {
					$old_file = str_replace($line,$this->linebreak_fixing("\n" . $this->comment_string($newline)),$old_file);
					$change = true;
				}
			}
    	}
    	if($changea){
			$this->write_to_file($this->get_fs_filename("lang/" . $lang . '/admin/' .$oldlnga), $old_filea);
    	}
    	if($change){
			$this->write_to_file($this->get_fs_filename("lang/" . $lang . '/' .$oldlng), $old_file);
    	}
        return $this->error;
    }
	function do_remove() {
		$oldlng = '';
		$change = false;
		$old_file = '';
		$oldlnga = '';
		$changea = false;
		$old_filea = '';
    	for($i=0; $i < count($this->data['lng']);$i++){
    		$lng = $this->data['lng'][$i] . ".php";
      	$lang = $this->data['lng'][$i];
			if (strlen($lng) == 4) {
				$lng = "english.php";
			}
			$newline='';
			if ($this->data['dir'][$i] == 'admin') {
				if($oldlnga != $lng){
					if($changea){
						$this->write_to_file($this->get_fs_filename("lang/" . $lang . '/admin/' .$oldlnga), $old_filea);
						$changea=false;
					}
					$old_filea=$this->linebreak_fixing(file_get_contents($this->get_fs_filename("lang/" . $lang . '/admin/' . $lng)));
					$oldlnga = $lng;
				}
				if($this->data['newname'][$i] != ''){
					$rx = "((?m)(/\* Begin.*[^\*]*\*/\s+(.*\s+)(.*".$this->data['newname'][$i].".*)\s+/\*.*))";
				}else{
					$rx = "((?m)(/\* Begin.*[^\*]*\*/\s+(.*\s+)(.*".$this->data['name'][$i].".*)\s+/\*.*))";
				}
				if (preg_match($rx, $old_filea, $m)) {
					$part = $m[1];
					$orgline = $m[2];
					$line = $m[3];
				}
				if($this->data['changevalue'][$i] != ''){
					// change value and name
					$newline = substr($orgline,2,-2);
				}else if($this->data['newname'][$i] != ''){
					// change only name
					$newline = str_replace($this->data['newname'][$i],$this->data['name'][$i],$line);
				}
				if ($newline != '') {
					$old_filea = str_replace($part,$newline,$old_filea);
					$changea = true;
				}
			}else{
				if($oldlng != $lng){
					if($change){
						$this->write_to_file($this->get_fs_filename("lang/" . $lang . '/' .$oldlng), $old_file);
						$change=false;
					}
					$old_file=$this->linebreak_fixing(file_get_contents($this->get_fs_filename("lang/" . $lang . '/' . $lng)));
					$oldlng = $lng;
				}
				if($this->data['newname'][$i] != ''){
					$rx = "((?m)(/\* Begin.*[^\*]*\*/\s+(.*\s+)(.*".$this->data['newname'][$i].".*)\s+/\*.*))";
				}else{
					$rx = "((?m)(/\* Begin.*[^\*]*\*/\s+(.*\s+)(.*".$this->data['name'][$i].".*)\s+/\*.*))";
				}
				if (preg_match($rx, $old_file, $m)) {
					$part = $m[1];
					$orgline = $m[2];
					$line = $m[3];
				}
				if($this->data['changevalue'][$i] != ''){
					// change value and name
					$newline = substr($orgline,2,-2);
				}else if($this->data['newname'][$i] != ''){
					// change only name
					$newline = str_replace($this->data['newname'][$i],$this->data['name'][$i],$line);
				}
				if ($newline != '') {
					$old_file = str_replace($part,$newline,$old_file);
					$changea = true;
				}
			}
    	}
    	if($changea){
			$this->write_to_file($this->get_fs_filename("lang/" . $lang . '/admin/' .$oldlnga), $old_filea);
    	}
    	if($change){
			$this->write_to_file($this->get_fs_filename("lang/" . $lang . '/' .$oldlng), $old_file);
    	}
        return $this->error;
    }


	function get_lang_file_line($txt, $name) {
		$rx = "((?m)^[ ]*define\(.*".$name.".*[\"'](.*?)[\"'].*\)[ ]*;)";
		if (preg_match($rx, $txt, $m)) {
			return $m[0];
		}
		return '';
	}
}
?>