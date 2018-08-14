<?php
/*
Class ContribInstallerBaseTag gives a basic functionality.
This class not used directly. Only for extending classes.

Made by Vlad Savitsky
    http://forums.oscommerce.com/index.php?showuser=20490
Support:
    http://forums.oscommerce.com/index.php?showtopic=156667
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class ContribInstallerBaseTag {
    var $contrib; //contrib name
    var $tag_name; //name of the tag used in xml-file
    var $data;//contain a value and used to store to database
    var $params;//array with attributes
	/**
	 * number of this type tag in xml
	 */
    var $id;
    /**
     * true if error
     */
    var $error;//true if error
    /**
     * priority in which this tag will be processed
     */
    var $priority = 0;
    /**
     * dependencie path for this tag
     */
    var $depend;
    /**
     * parent cip for this tag
     */
    var $cip;


// Class Constructor
    function ContribInstallerBaseTag($cip='', $id='', $xml_data='', $dep='') {
    	$this->cip = $cip;
        $this->contrib=$cip->cip_name;
        $this->id=$id+1;//For human understanding we add one.
        $this->table=DB_PREFIX."cip_".$this->tag_name;
        $this->depend = $dep;
        if ($xml_data)     $this->read_from_xml($xml_data);

        $this->add_log();
    }
//  Class Methods

    //Data
    //=======================================================================
    function get_contrib() {return $this->contrib;}
    function get_tag_name() {return $this->tag_name;}
    function get_id() {return $this->id;}
    function get_cip_id() {
        $query="select cip_id from ".TABLE_CIP." where cip_folder_name='".$this->contrib."' ";
        $result=cip_db_query($query);
        if ($result===false)     $this->error(sql_error($query));
        else {
            $installed=vam_db_fetch_array($result);
            return $installed['cip_id'];
        }
    }
    //=======================================================================
    function get_filename() {return $this->data['filename'];}

    function get_find() {return $this->data['find'];}
    function get_add() {return $this->data['add'];}
    function get_add_type() {return $this->data['add_type'];}
    function get_type() {
    	if(!isset($this->data['type']) || $this->data['type']=='') return 'php';
    	return $this->data['type'];
    }
    function get_start() {return $this->data['start'];}
    function get_end() {return $this->data['end'];}
    //findreplace
    function get_replace() {return $this->data['replace'];}
    function get_replace_type() {return $this->data['replace_type'];}
    //description
    function get_contrib_ref() {return $this->data['contrib_ref'];}
    function get_forum_ref() {return $this->data['forum_ref'];}
    function get_contrib_type() {return $this->data['contrib_type'];}
    function get_status() {return $this->data['status'];}
    function get_last_update() {return $this->data['last_update'];}
    function get_comments() {return $this->data['comments'];}
    function get_credits() {return $this->data['credits'];}
    //make_dir
    function get_parent_dir() {return $this->data['parent_dir'];}
    function get_dir() {return $this->data['dir'];}
    //sql
    function get_query() {return $this->data['query'];}
    function get_remove_query() {return $this->data['remove_query'];}
    //php
    function get_remove() {return $this->data['remove'];}
    function get_install() {return $this->data['install'];}
    //=======================================================================
    //extra data:
    //=======================================================================
    function fs_filename($id=0) {
    	if(is_array($this->data['filename'])){
    		return $this->get_fs_filename($this->data['filename'][$id]);
    	}
    	return $this->get_fs_filename($this->data['filename']);
    }

    function get_fs_filename($fname) {
        if($this->isJoscom()){
    		$fname = str_replace(DIR_WS_CATALOG,"",$fname);
    		$fname = str_replace(DIR_WS_ADMIN,"admin/",$fname);

			if (strpos($fname, "admin/") === false) {
				$filepath = DIR_FS_CATALOG;
			} else {
				$filepath = DIR_FS_ADMIN;
				$fname = substr($fname, 6);
			}
			return $filepath.$fname;
    	}else{
    		if ($fname)    return DIR_FS_CATALOG.$fname;
    	}
    }
    function isJoscom(){return ((defined("JOSCOM_VERSION")) ? true : false);}

    function add_str() {
        if ($this->data['add'])
            return  $this->linebreak_fixing($this->comment_string($this->data['add'], $this->data['add_type']));
    }
    function rep_str() {
        if ($this->data['replace'])
            return $this->linebreak_fixing($this->comment_string($this->data['replace'], $this->data['replace_type']));
    }
    function multi_search() {return (($this->data['type']=='continued') ? true : false);}
    //=======================================================================
   //error
    //=======================================================================
    function get_error() {return $this->error;}
    //=======================================================================
    //actions
    //=======================================================================
    function do_install() {return $this->error;}
    function do_remove() {return $this->error;}

    function permissions_check_for_install() {return $this->error;}
    function permissions_check_for_remove() {return $this->error;}

    function conflicts_check_for_install() {return $this->error;}
    function conflicts_check_for_remove() {return $this->error;}
    //=======================================================================
    //Database functions:
    //=======================================================================
    function create_database_table() {
        $query="CREATE TABLE IF NOT EXISTS  `".$this->table."` (
                            `cip_id` int(11) NOT NULL PRIMARY KEY,
                            `tag_id` int NOT NULL, ";
        foreach ($this->params as $columns=>$info)     $query.= '`'.$columns.'` '.$info['sql_type'].' NOT NULL, ';
        $query=substr($query, 0, -2) . ");";
        vam_db_query($query);
    }


    function delete_database_table() {cip_db_query("DROP TABLE IF EXISTS `".$this->table."`");}

    function is_database_table_exists() {
        $check_query=vam_db_query("SHOW TABLE STATUS");
        while ($table=vam_db_fetch_array($check_query))     if ($table['Name']==$this->table)    return true;
        return false;
    }


    function write_to_database() {
        if (!$this->is_database_table_exists())    $this->create_database_table();
        $data=$this->data;
        $data['cip_id']=$this->get_cip_id();
        $data['tag_id']=$this->get_id();
        vam_db_perform($this->table, $data);
    }


    function read_from_database() {
        if (!$this->is_database_table_exists())    return;
        $query="SELECT ";
        foreach (array_keys($data) as $columns) {$query .= 'tag.'.$columns.', ';}
        $query = substr($query, 0, -2) . " FROM ".$this->table." tag, ".TABLE_CIP." cip
                        WHERE tag_id=".$this->id." AND cip.cip_id=tag.cip_id AND cip.cip_folder_name=".$this->contrib;
        $data=vam_db_output(vam_db_fetch_array(vam_db_query($query)));

    }
    //=======================================================================
    //XML:
    //=======================================================================
    function get_data_from_xml_parser() {}
/*    function read_from_xml($xml_data=array()) {
        if (is_array($xml_data) and count($xml_data)>0)    $this->get_data_from_xml_parser($xml_data);
        else $this->error('No data from XML-file');
        $this->xml_check();
    }*/
    function read_from_xml($xml_data) {
        if (is_object($xml_data) and $xml_data->hasChildNodes())    $this->get_data_from_xml_parser($xml_data);
        else $this->error('No data from XML-file');
        $this->xml_check();
    }

    function xml_check() {
        foreach ($this->params as $tag=>$tag_data) {
            if (!isset($tag_data['xml_error']))     continue; //'addcode' and 'find'
            if ($tag=='start' or $tag=='end' or $tag=='type') {
                if (
                    ($this->data['start'] && $this->data['end'] && !$this->data['type'])
                    or
                    (!$this->data['start'] && !$this->data['end'] && $this->data['type'])
                ) {}
                else     $this->error($tag_data['xml_error']);
            } else if (!isset($this->data[$tag]) && isset($tag)) {
                $this->error($tag_data['xml_error']);
            }else if(is_array($this->data[$tag])){
				$pocet = count(array_values($this->data[$tag]));
				for($i=0;$i <$pocet; $i++){
					if(!isset($this->data[$tag][$i]))
						$this->error($tag_data['xml_error']." on ".$i. ". subtag");
				}
            }
        }
    }

    function data_range_check() {
        //For addcode and findreplace start<=end!!!!
        //Check if we have <find> between lines with numbers "start" and "end".


        //Range check:
        foreach (array_keys($this->params) as $tag_name) {
            $value=$this->data[$tag_name];
            if($value) {
                $pieces=strtolower(explode(" ", $this->params[$tag_name]['sql_type']));//get a first word
                $pos=strpos($pieces[0], '(');
                if ($pos) {
                    $type=substr($pieces[0], 0, $pos-1);
                    $type_value=substr($pieces[0], $pos - strlen($pieces[0]), 1); //without '(' and ')'
                } else    $type=$pieces[0];

                switch ($type[0]) {
                    case 'varchar':
                            if (strlen($value)>$type_value)     $this->error("value lenth must be less then ".$type_value);
                            break;
                    case 'text':
                            if (strlen($value)>65535)     $this->error("value lenth must be less then 65535");
                            break;
                    case 'enum':
                            $values=strtolower(explode(",",str_replace("'", "",$this->params[$tag_name]['sql_type']) ));
                            if (!in_array($value, $values))    $this->error("value must be ".implode (" or ", $values));
                            break;
                    case 'int':
                    case 'integer'://unsigned
                            if ($value>4294967295)     $this->error("value must be integer and less then 4294967295.");
                            break;
                    case 'tinyint'://unsigned
                            if ($value>255)     $this->error("value must be integer and less then 4294967295.");
                            break;
                    case 'smallint'://unsigned
                            if ($value>65535)     $this->error("value must be integer and less then 65535.");
                            break;
/*                    case 'datetime':
                            break;                            */

                }
            }
        }
    }
    //=======================================================================
    //Get or send data to/from web-page
    //=======================================================================
    function write_to_web() {}
    function read_from_web() {}
    //=======================================================================
    //Backup
    //=======================================================================
    function backup_file($filename=''){
        $filename=(($filename) ? $filename : (($this->data['filename']) ? $this->data['filename'] : ''));
        if(is_array($filename)){
        	$filenames= $filename;
        }else{
        	 $filenames[0] = $filename;
        }
        foreach($filenames as $filename){
	        $full_path=$this->get_fs_filename($filename);
	        if(!is_file($full_path) or is_link($full_path))     return;

	        $this->error($this->recursive_mkdir(dirname(DIR_FS_ADMIN_BACKUP.$this->contrib.'/'.$filename).'/'));
	        if($this->error)    return;

	        if(@!copy($full_path, DIR_FS_ADMIN_BACKUP.$this->contrib.'/'.$filename)) {
	            $this->error(COULDNT_COPY_TO_TEXT. $full_path.
	                                    " to ".DIR_FS_ADMIN_BACKUP.$this->contrib.'/'.$filename);
	        } elseif (file_exists(DIR_FS_ADMIN_BACKUP.$this->contrib.'/'.$filename)) {
	            chmod(DIR_FS_ADMIN_BACKUP.$this->contrib.'/'.$filename, 0777);
	        }
        }
    }

    function restore_file($filename=''){
        $filename=(($filename) ? $filename : (($this->data['filename']) ? $this->data['filename'] : ''));
        if (!$filename) return;
        if(is_array($filename))   $filenames= $filename;
        else   $filenames[0] = $filename;

        foreach($filenames as $filename){
		    $backup_file=DIR_FS_ADMIN_BACKUP.$this->contrib.'/'.$filename;
	        $current_file=$this->get_fs_filename($filename);
	        if(is_link($current_file))    return;
	//Remove current_file
            ci_remove($current_file);
	        if (!is_file($backup_file))    return;
	//Restore
	        if (!@ copy($backup_file, $current_file)) {
	                $this->error("Couldn't restore file ". $filename. " from ".$backup_file);
	        } else   ci_remove($backup_file);
        }
    }
    //=======================================================================
    //Helpfull functions:
    //=======================================================================
    function write_to_file($path, $content) {
        if (!is_file($path) or !$content)     return;
        if (!is_writable($path))      return;
        $file=fopen($path, 'w');
        fwrite($file, $content);
        fclose($file);
    }
    function linebreak_view($line) {return preg_replace( "/[[:space:]]*\n/i", "[r][n]\r\n",  preg_replace("/[[:space:]]*\r/i", "", $line));}

    function linebreak_fixing($line) {
		$line = str_replace("\r\n","\r",$line);
		$line = str_replace("\r","\n",$line);
		$line = str_replace("\n","\r\n",$line);
		return preg_replace( "/(?<=\S)[ \t]+\r\n/","\r\n",$line);
	}

   function remove_fl_linebreaks($line){
		$line =  preg_replace( "/^\r\n/","",$line);
		return preg_replace( "/\r\n$/","",$line);
   }

    function comment_string($str, $type="php") {
        switch ($type) {
            case 'html':
                    $start_com="\n<!-- ";
                    $end_com=" //-->";
                    break;
            default:
                    $start_com="\n/* ";
                    $end_com=" */";
                    break;
        }
        $back_part=$this->contrib." - installed by ".CONTRIB_INSTALLER_NAME.$end_com."\n";
        return  $start_com. "Begin ".$back_part. $this->remove_fl_linebreaks($str). $start_com."End ".$back_part ;
    }


    function recursive_mkdir($path) {
        if (!file_exists($path)) {
            if (is_dir($path))     recursive_permissions_check($path);
            else {
                $this->recursive_mkdir(dirname($path));
                if (!is_writeable(dirname($path))) {
                   return WRITE_PERMISSINS_NEEDED_TEXT.dirname($path).'/';
                }
                if(!@mkdir($path, 0777))     return CANT_CREATE_DIR_TEXT.$path;
                chmod($path, 0777);
            }
        }
    }

	function add_file_end($fname, $fpart) {
		global $message;
		$enter = false;
		$fs_fname = $this->get_fs_filename($fname);
		if (is_file($fs_fname)) {
			$old_file = file_get_contents($fs_fname);
			$position = strpos($old_file, $fpart);
			if ($position === false) {
				if($this->get_type() == 'php'){
					$count = preg_match_all("(\?>\s*$\s*)",$old_file,$matches,PREG_OFFSET_CAPTURE);
					if ($count == 0) { // if file no ends with \?\>
						$new_file = rtrim($old_file). "\n<?php " . $fpart . " ?>";
					}else{
						$new_file = substr_replace($old_file, $fpart, $matches[0][0][1], 0); //inserts string into another string
					}
				} else    $new_file = $old_file.$fpart;
				$this->write_to_file($fs_fname, $new_file);
			}
		} else    $message->add(FILE_NOT_EXISTS_TEXT . ": " . $fs_fname);
	}

	function remove_file_part($fname, $fpart) {
		global $message;
		$fs_fname = $this->get_fs_filename($fname);
		if (is_file($fs_fname)) {
			$old_file = file_get_contents($fs_fname);
			$position = strpos($old_file, "<?php " . $fpart . " ?>");
			if ($position === false) {
				$position = strpos($old_file, $fpart);
			}else{
				$fpart = "<?php " . $fpart . " ?>";
			}
			if ($position === false) {
				$output .= "<p class=\"error\">" . COULDNT_FIND_TEXT . ": " . nl2br(htmlentities($fpart)) .
				"</p>" . IN_THE_FILE_TEXT . $fs_fname . '</div>';
			} else {
				$length = strlen($fpart);
				$new_file = substr_replace($old_file, '', $position, $length);
				$this->write_to_file($fs_fname, $new_file);
    		}
		} else
			$message->add(FILE_NOT_EXISTS_TEXT . ": " . $fs_fname);
	}

	function replace_dbprefix($txt){
		return trim(str_replace("%DB_PREFIX%", DB_PREFIX,$txt));
	}

    function error($text='') {
        global $message, $cip;
        if ($text) {
            if ($cip->was_unpacked() && $cip->is_unpacked())     ci_remove(DIR_FS_CIP.'/'.$this->contrib);
            return $this->error=$message->add($text.
                "<br>&#060;<i>".$this->get_tag_name()."&#062; #".$this->get_id(). " ".$this->depend. "</i>" , 'error');
        }
    }

    function get_lang_file_encoding($fname) {
//		$encoding = "ISO-8859-1";
		$encoding = $_SESSION['language_charset'];
//		$fs_fname = $this->get_fs_filename($fname);
//		if (file_exists($fs_fname)) {
//			$old_file = file_get_contents($fs_fname);
//			$rx = "((?m)^[ ]*define\(.*CHARSET.*[\"'](.*?)[\"'].*\)[ ]*;)";
//			if (preg_match($rx, $old_file, $m)) {
//				$encoding = strtoupper($m[1]);
//			}
//		}
		return $encoding;
	}

    function equal_files($file1, $file2) {
        //2.0.4 b
        if (is_file($file1) && is_file($file2)) {
            return (md5_file($file1) == md5_file($file2));
        } else {
            if (!is_file($file1) && !is_file($file2))    return true;
            else    return false;
        }
        //2.0.4 e
    }


	function getITagAttr($tag, $tagpos,$attrname, $defval=NULL){
		if(is_object($tag->item($tagpos))){
			$rrer=$tag->item($tagpos);
			 return $rrer->getAttribute($attrname);
		}
    	return $defval;
	}

    function getTagAttr($xml_data,$tagname, $tagpos,$attrname,$defval=NULL){
    	if(is_object($xml_data)){
    		$obj = $xml_data->getElementsByTagName($tagname);
    		if(is_object($obj))
    			if(is_object($obj->item($tagpos))){
    				$rret = $obj->item($tagpos);
    				return $rret->getAttribute($attrname);
    			}
    	}
    	return $defval;
    }

	function getITagText($tag, $tagpos, $defval=NULL){
		if(is_object($tag->item($tagpos))){
			$rret = $tag->item($tagpos);
			return $rret->getText();
		}
    	return $defval;
	}

    function getTagText($xml_data,$tagname, $tagpos, $defval=NULL){
    	if(is_object($xml_data)){
    		$obj = $xml_data->getElementsByTagName($tagname);
    		if(is_object($obj))
    			if(is_object($obj->item($tagpos))){
    				$rret = $obj->item($tagpos);
    				return $rret->getText();
    			}
    	}
    	return $defval;
    }

    function isTagName($name){
    	return($this->tag_name == $name);
    }



    function add_log(){
      global $message;
      if(USE_LOG_SYSTEM!='true') return;
      if($this->data==null) return;
      foreach($this->data as $key=>$value) {
        if(is_array($value)) {
            $tag_data.="\r\n".$key." (Array):";
            foreach($value as $ky=>$val)    $tag_data.= "\r\n".$ky."=>".$this->linebreak_view($val)."\r\n";
        } elseif ($value) {
            if($this->linebreak_view($value)==$value) {
                $tag_data.= "\r\n".$key.": ".$this->linebreak_view($value);
            } else $tag_data.= "\r\n".$key.":\r\n".$this->linebreak_view($value);
        }
      }
      $message->add_log($this->get_contrib()."\r\n".$this->get_tag_name()."#".$this->get_id()."\r\n". $tag_data);
    }


	function cnv_to_regex($text){
		$lines = explode("\n",$text);
		$tt = "((?m)";
		$i=0;
		foreach ($lines as $line){
			$line = trim($line);
			if($i==0){
				$pos = strpos($line,'/* Begin');
				if($pos !== false)
			    	$tt .= '\/\* Begin [^-]* - installed by Contrib_Installer[^\*]* \*\/[\s]*';
			    else
			    	$tt .= preg_quote($line).'[\s]*';
			}else{
				$tt .= preg_quote($line).'[\s]*';
			}
			if(strlen($line)>0)$i++;
		}
		$tt = substr($tt,0,-5).")";
		return $tt;
	}

	function get_num_lines($text){
		return preg_match_all('((?m)(^.*$))',$text,$m);
	}

}
?>