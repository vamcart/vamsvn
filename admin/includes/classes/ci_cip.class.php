<?php
/*
Made by Vlad Savitsky
    http://forums.oscommerce.com/index.php?showuser=20490
Support:
    http://forums.oscommerce.com/index.php?showtopic=156667
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class CIP {
	/**
	 * Name of contrib folder
	 */
    var $cip_name;
    /**
     * Name of the zip file with cip
     */
    var $zip_name;
    /**
     * True if CIP should be read from ZIP-file
     */
    var $is_cip_in_zip;
    /**
     * True if this is a Contrib Installer self-install.
     */
    var $is_ci;
    /**
     * tags data
     */
    var $contrib_data;
    /**
     * True if we have an error. error() sets this var
     */
    var $error=false;
    /**
     * Number of php tags in install.xml
     */
    var $count_php_tags=0;
    var $cip_id;
    /**
     * '1' if CIP was installed, '0' if not.
     */
    var $cip_installed;

    // Class Constructor
    function CIP($cip_name='') {
        if (!$cip_name or $cip_name=="." or $cip_name=="..")    $this->error(NO_CONTRIBUTION_NAME_TEXT);
        if ($this->error)    return;
        $this->include_tag_classes();
        if (substr($cip_name, -4)=='.zip') {
            $this->is_cip_in_zip=true;
            $this->zip_name=$cip_name;
            $this->cip_name=substr($this->zip_name, 0, -4); //name without extention
        } else {
            $this->is_cip_in_zip=false;
            $this->cip_name=$cip_name;
            $this->zip_name=$this->cip_name.'.zip';
        }
        $this->is_ci=(($this->cip_name==CONTRIB_INSTALLER_NAME. "_".
                                CONTRIB_INSTALLER_VERSION) ? 1:0);
        //Get id
        if ($this->is_ci)     return;
        $result=cip_db_query("select cip_id, cip_installed from ".TABLE_CIP.
                        " where cip_folder_name='".$this->cip_name."'; ");
        if ($result===false)     return;
        $installed=vam_db_fetch_array($result);
        $this->cip_id=$installed['cip_id'];
        $this->cip_installed=$installed['cip_installed'];
        if (!$this->cip_id) {
            //Register CIP in database:
                $this->register();
                global $$link;
                $this->cip_id=vam_db_insert_id();
                $this->cip_installed=0;
        }







    }
    //  Class Methods

    //==================================================================
    //Get class variables:
    //==================================================================
    function get_cip_name() {return $this->cip_name;}
    function get_zip_name() {return $this->zip_name;}
    function is_cip_in_zip() {return $this->is_cip_in_zip;}
    function get_contrib_data() {return $this->contrib_data;}
    function get_error() {return $this->error;}

    function get_cip_id() {return $this->cip_id;}

    function get_description_id()     {return $this->description_id;}
    function get_data($id)     {return $this->contrib_data[$id];}

    function is_ci() {return $this->is_ci;}
    //Post install notes:
    function post_install_notes() {return $this->contrib_data[$this->description_id]->data['post_install_notes'];}
    //=================================================
    // Stat
    //=================================================
    function get_count_php_tags() {return $this->count_php_tags;}









    //==================================================================
    //Archiver ZIP
    //==================================================================
    //True if we unpack. So we should delete
    function was_unpacked() {return $this->was_unpacked;}
    //True if  unpacked folder exists.
    function is_unpacked() {return (is_dir(DIR_FS_CIP.'/'.$this->cip_name));}
    //True if we have a zip for this CIP
    function is_zipped() {return (is_file(DIR_FS_CIP.'/'.$this->zip_name));}
    function full_path_to_zip() {return escapeshellcmd(DIR_FS_CIP.'/'.$this->zip_name);}

    function pack_cip($ext='zip') {
        if (!$this->is_unpacked() || $this->is_zipped())    return false;
        switch ($ext) {
            case 'gzip':
                if(CI_ARCHIVER_GZIP)    @ exec(CI_ARCHIVER_GZIP.' '.DIR_FS_CIP.'/'.escapeshellcmd($this->cip_name), $output);
                break;
            case 'zip':
	   	        require_once( DIR_FS_ADMIN_CLASSES. 'pclzip.lib.php' );
            	$zipfile = new PclZip($this->full_path_to_zip());
            	if($this->is_Windows()) {
					define('OS_WINDOWS',1);
	       		} else {
	       			define('OS_WINDOWS',0);
	       		}
	       		$ret = $zipfile->add(DIR_FS_CIP.'/'.escapeshellcmd($this->cip_name),"",DIR_FS_CIP."/");
	       		if($ret == 0) {
	       			$message->add('Unrecoverable error "'.$zipfile->errorName(true).'"' );
	       			return false;
	       		}
                break;
        }
        return true;
    }


    function unpack_cip($ext='zip') {
    	global $message;
//        unset($output);
 	  	switch ($ext) {
	        case 'zip':
	   	        require_once( DIR_FS_ADMIN_CLASSES. 'pclzip.lib.php' );
	       		$zipfile = new PclZip( $this->full_path_to_zip() );
	       		if($this->is_Windows()) {
	       			define('OS_WINDOWS',1);
	       		} else {
	       			define('OS_WINDOWS',0);
	       		}

	       		$ret = $zipfile->extract( PCLZIP_OPT_PATH, DIR_FS_CIP );
	       		if($ret == 0) {
	       			$message->add('Unrecoverable error "'.$zipfile->errorName(true).'"' );
	       			return false;
	       		}
                break;
            case 'tbz':
            case 'tbz2':
            case 'bz2':
            case 'bz':
                if(CI_ARCHIVER_BZIP2)    @ exec(CI_ARCHIVER_BZIP2.' '.$this->full_path_to_zip().' -d > '. DIR_FS_CIP.'/'.$this->cip_name, $output);
                break;
            case 'gz':
                //escapeshellarg()
                if(CI_ARCHIVER_GUNZIP)    @ exec(CI_ARCHIVER_GUNZIP.' '.$this->full_path_to_zip() .' -c > '. DIR_FS_CIP.'/'.$this->cip_name, $output);
                break;
        }
        //$this->untar_cip($filename);
        //$output - array that contain an output.
    }

    function untar_cip($filename) {
        $full_file_path=escapeshellarg(DIR_FS_CIP.'/'.$filename);
        if ($filename== "." || $filename== ".." || is_file($full_file_path)) return;
        $path_parts = pathinfo($this->cip_name);
        if ($path_parts['extension']=='tar' && CI_ARCHIVER_TAR) {
            exec(CI_ARCHIVER_TAR.' -xzvf '.$full_file_path);      // Says permission denied
            //unlink($full_file_path);
        }
    }



    //==================================================================
    //Database
    //==================================================================
    function write_to_database(){
        if (!$this->is_all_right())     return;
        foreach ($this->contrib_data as $id=>$tag) {
            if ($this->error=$tag->write_to_database())    break;
        }
    }

    function read_from_database(){
        if (!$this->is_all_right())     return;
        foreach ($this->contrib_data as $id=>$tag) {
            if ($this->error=$tag->read_from_database())    break;
        }
    }


    //==================================================================
    //Register
    //==================================================================

    function is_registered() {return (($this->cip_id) ? true : false);}

    function register() {
        cip_db_query("replace into ".TABLE_CIP." (cip_id, cip_folder_name, cip_installed, cip_ident, cip_version) values ('', '".$this->cip_name."', '0', '".$this->getIdent()."','".$this->getVersion()."')");
    }
    function unregister() {
        if (!$this->is_ci())     cip_db_query("DELETE FROM ".TABLE_CIP." WHERE cip_folder_name='".$this->cip_name."' ");
    }
    //==================================================================
    //Is installed?
    //==================================================================
    function is_installed() {
        if (!isset($this->cip_installed)) {
            $result=cip_db_query("select cip_installed from ".TABLE_CIP." where cip_folder_name='".$this->cip_name."'");
            if ($result===false)     return;
            $installed=vam_db_fetch_array($result);
            $this->cip_installed=$installed['cip_installed'];
        }
        return $this->cip_installed;
    }
    function unset_installed() {$this->set_installed('0');}
    function set_installed($status='1') {
        cip_db_query("UPDATE ".TABLE_CIP." SET cip_installed='".$status."', cip_ident='".$this->getIdent()."', cip_version='".$this->getVersion()."' WHERE cip_folder_name='".$this->cip_name."'");
    }



    function delete_tags_tables() {
        if ($this->is_all_right())
        foreach ($this->contrib_data as $id=>$tag) {
            if ($this->error=$tag->delete_database_table())    break;
        }
        //If we will create just an objects for tag-classes we could not use this function with new tags...
    }



    //==================================================================
    //XML
    //==================================================================
    function read_xml($delete_unpacked=true) {
    /*
    Return true if folder should be removed.
    $this->was_unpacked - true if this script unpack CIP
    $delete_unpacked -true if we should remove unpacked version of CIP
    */
        global $message;
        if (is_array($this->contrib_data) && count($this->contrib_data)>0)    return;

        if ($this->is_cip_in_zip && !$this->is_unpacked()) {
            //We unzip only if we get a zip-filename as a and do not have a unpacked version of CIP.
            $this->unpack_cip();
            $this->was_unpacked=true;
        }
        if ($this->is_unpacked()) {
            $this->read_from_xml();
            if ($this->get_error()) {
                $this->error('<b>'.(($this->is_cip_in_zip) ? $this->get_zip_name() : $this->get_cip_name())
                .'</b> havn\'t contained well formed XML-file: '.CONFIG_FILENAME);
                if ($this->was_unpacked()) {
                    //ci_remove(DIR_FS_CIP.'/'.$this->cip_name);
                    //$error=ci_remove(DIR_FS_CIP.'/'.$this->get_zip_name());
                    //$message->add(((!$error) ? $this->get_zip_name().' was removed.' : ''), 'warning');
                }
            }
            if ($this->was_unpacked() && $delete_unpacked)     ci_remove(DIR_FS_CIP.'/'.$this->get_cip_name());
        } elseif ($this->was_unpacked()) {
            $this->error('Couldn\'t unpack <b>'.$this->get_zip_name().'</b> to read data about CIP.');
            $error=ci_remove(DIR_FS_CIP.'/'.$this->get_zip_name());
            $message->add(((!$error) ? $this->get_zip_name().' was removed.' : ''), 'warning');
        }
        return $this->was_unpacked();
    }

    function read_from_xml() {
    	$tagcnt = array();
        if (!file_exists(DIR_FS_CIP.'/'.$this->cip_name.'/'.CONFIG_FILENAME)) {
            $this->error(ERROR_COULD_NOT_OPEN_XML. $this->cip_name.'/'.CONFIG_FILENAME);
            return;
        }
        require_once(DIR_FS_ADMIN_CLASSES.'xml_domit_parser.php');
        $xmlDoc = new DOMIT_Document();

		//parse XML
		$xmlDoc->loadXML(DIR_FS_CIP.'/'.$this->cip_name.'/'.CONFIG_FILENAME);
		foreach ($xmlDoc->documentElement->childNodes as $id=>$tag_data) {
	            // ignore xml comments
	            if ($tag_data->nodeName=='#comment') continue;
	            if(array_key_exists($tag_data->nodeName,$tagcnt)){
	            	$tagcnt[$tag_data->nodeName]++;
	            }else{
	            	$tagcnt[$tag_data->nodeName] = 0;
	            }
                if (strtolower($tag_data->nodeName)=='php')     $this->count_php_tags++;
                $clsname='Tc_'.strtolower($tag_data->nodeName);
                if (class_exists($clsname))    $this->contrib_data[]=new $clsname($this, $tagcnt[$tag_data->nodeName], $tag_data);
                else {
                    $this->error('Tag'.$tag_data->nodeName.' is not supported. Class '.$clsname.' does NOT exist.');
                    return;
                }
                if(strtoupper($tag_data->nodeName) == 'DESCRIPTION') {
                	$this->description_id=key($this->contrib_data);
                }
		}
    }

    function does_have_install_xml() {
        if (file_exists(DIR_FS_CIP.'/'.$this->cip_name.'/'.CONFIG_FILENAME))    return true;
        else {
            $this->error(ERROR_COULD_NOT_OPEN_XML. $this->cip_name.'/'. CONFIG_FILENAME);
            return false;
        }
    }

	function compare_tag_priority($a, $b){
		return $b->priority - $a->priority;
	}
    //==================================================================
    //Action
    //==================================================================
    function install() {
        $this->was_unpacked=$this->read_xml($delete_unpacked=false);
        if (!$this->is_all_right())     return;

        // sort install tags by priority
		//usort($this->contrib_data,'compare_tag_priority');


        $this->permissions_check_for_install();
        if ($this->error)    return;
        $this->conflicts_check_for_install();
        if ($this->error)     return;
        $this->total_backup();
        if ($this->error)     return;


        /*
        We passed by all checks. So if an error appears
        */
        foreach ($this->contrib_data as $id=>$tag){
        	if ($this->error=$tag->do_install())    break;
        }

        //If we had a problems at runtime we should remove this CIP.
        if ($this->error)     $this->remove($cleaning=true);
        else {
            if ($this->was_unpacked() && $this->is_unpacked()) {
                ci_remove(DIR_FS_CIP.'/'.$this->get_cip_name());
            }

            //Because if we not do it here CI will not be registered.
              if ($this->is_ci()) {
                  $this->register();
              }
            $this->set_installed();
        }
    }


    function remove($cleaning=false) {
//         $result=$this->read_xml($delete_unpacked=false);
//         if (!is_null($result))     $this->was_unpacked=$result;

        if (!$cleaning)     $this->was_unpacked=$this->read_xml($delete_unpacked=false);

        if (!$this->is_all_right() and !$cleaning)     return;
        $this->permissions_check_for_remove();
        if ($this->error and !$cleaning)     return;
        $this->conflicts_check_for_remove();
        if ($this->error and !$cleaning)     return;
        $this->total_restore();
        if ($this->error and !$cleaning)     return;

        foreach ($this->contrib_data as $id=>$tag){
        	if ($this->error=$tag->do_remove())  break;
        }
        if ($this->was_unpacked() && $this->is_unpacked()) {
            ci_remove(DIR_FS_CIP.'/'.$this->get_cip_name());
        }
        $this->unset_installed();
    }

	function compute_dependencies(){

        $this->was_unpacked=$this->read_xml($delete_unpacked=false);
        if (!$this->is_all_right())     return;

        // sort install tags by priority
		//usort($this->contrib_data,'compare_tag_priority');


        $this->permissions_check_for_install();
        if ($this->error)    return;
        $this->conflicts_check_for_install();
        if ($this->error)     return;

        /*
        We passed by all checks. So if an error appears
        */
        foreach ($this->contrib_data as $id=>$tag){
        	if($tag->isTagName('description') || $tag->isTagName('depend')){
	        	if ($this->error=$tag->do_install())    break;
        	}
        }

        //If we had a problems at runtime we should remove this CIP.
        if ($this->error)     $this->remove($cleaning=true);
        else {
            if ($this->was_unpacked() && $this->is_unpacked()) {
                ci_remove(DIR_FS_CIP.'/'.$this->get_cip_name());
            }
        }
    }

    //==================================================================
    //Backup
    //==================================================================


    function total_backup() {
        //prepare backup folder:
        if (!is_dir(DIR_FS_ADMIN_BACKUP.$this->cip_name)) {
            if (!@mkdir(DIR_FS_ADMIN_BACKUP.$this->cip_name, 0777)) {
                $this->error(WRITE_PERMISSINS_NEEDED_TEXT.DIR_FS_ADMIN_BACKUP.$this->cip_name);
            }
            if (is_dir(DIR_FS_ADMIN_BACKUP.$this->cip_name))    chmod(DIR_FS_ADMIN_BACKUP.$this->cip_name, 0777);
        }
        if (!$this->is_all_right())     return;
        //Backup Files:
        if ($this->is_ci())    $this->backup_all();
        elseif (ALLOW_FILES_BACKUP=='true')    $this->backup();
        if (!$this->is_all_right())     return;
        //Backup DataBase:
        if (ALLOW_SQL_BACKUP=='true' or $this->is_ci())     $this->sql_backup();
    }

    function total_restore() {
        if ($this->is_ci())     $this->restore_all();
        elseif (ALLOW_FILES_RESTORE=='true')     $this->restore();
        if (!$this->is_all_right())     return;
        //SQL restore;
        if (ALLOW_SQL_RESTORE=='true' or $this->is_ci())    $this->sql_restore();
        if (!$this->is_all_right())     return;
    }


    function backup_all() {
        $catalog_files=get_all_files_in_tree(DIR_FS_CATALOG, array(),
                    array(basename(DIR_FS_CIP), basename(DIR_FS_ADMIN_BACKUP)));
        foreach($catalog_files as $id=>$value) {
            $catalog_files[$id]=str_replace(DIR_FS_DOCUMENT_ROOT, '', $value);
        }
        $tag=$this->contrib_data[0];
        foreach($catalog_files as $file_path) {
            if ($this->error=$tag->backup_file($file_path))    break;
        }
    }

    function restore_all() {
        if (!$this->is_all_right())     return;
        $catalog_files=get_all_files_in_tree(DIR_FS_ADMIN_BACKUP.$this->cip_name.'/', array(), array());
        foreach($catalog_files as $id=>$value) {
            $catalog_files[$id]=str_replace(DIR_FS_ADMIN_BACKUP.$this->cip_name.'/', '', $value);
        }
        $tag=$this->contrib_data[0];
        foreach($catalog_files as $file_path) {
            if ($this->error=$tag->restore_file($file_path))    break;
        }
        ci_remove(DIR_FS_ADMIN_BACKUP.$this->cip_name);
    }


    function backup() {
        foreach ($this->contrib_data as $id=>$tag) {
            if ($this->error=$tag->backup_file())    break;
        }
    }

    function restore() {//on remove
        if (!$this->is_all_right())     return;
        foreach ($this->contrib_data as $id=>$tag) {
            if ($this->error=$tag->restore_file())    return;
        }
        ci_remove(DIR_FS_ADMIN_BACKUP.$this->cip_name);
    }


    function sql_restore() {
        vam_set_time_limit(0);
        $backup_file=DIR_FS_ADMIN_BACKUP.$this->cip_name.'.sql';
        $zip_file=$backup_file.'.gz';
        $restore_query='';
        if (!file_exists($backup_file)) {
            if(file_exists($zip_file)) {

            	$zd = gzopen($zip_file, "r");
            	while(!feof($zd)){
					$restore_query .= gzread($zd, 10000);
            	}
				gzclose($zd);
            }
        }else{
        	$restore_query=file_get_contents($backup_file);
        }
        if ($restore_query !='') {
            //Delete all tables from database:
            $tables_query=cip_db_query('show tables');
            while ($tables=mysqli_fetch_array($tables_query, MYSQLI_ASSOC)) {
                list(,$table)=each($tables);
                global $$link;
                mysqli_query($$link, 'DROP TABLE IF EXISTS '.$table);
            }
            if ($restore_query) {
                $sql_array = parse_sql($restore_query);
                foreach ($sql_array as $query)     cip_db_query($query);
            }
        }
        ci_remove($zip_file);
        ci_remove($backup_file);
    }


    function sql_backup() {
        vam_set_time_limit(0);
        $backup_file=DIR_FS_ADMIN_BACKUP.$this->cip_name.'.sql';
        // From original admin/backup.php:
        $fp=fopen($backup_file, 'w');
        $schema=
                  '# Contrib Installer.'."\n" .
                  '# Makes customizing VaM Shop "simple".' . "\n" .
                  '# Copyright (c) '.date('Y').' Vlad Savitsky'."\n" .
                  '# http://vamshop.ru' . "\n" .
                  '#' . "\n" .
                  '# Database Backup For ' . STORE_NAME . "\n" .
                  '#' . "\n" .
                  '# Database: ' . DB_DATABASE . "\n" .
                  '# Database Server: ' . DB_SERVER . "\n" .
                  '#' . "\n" .
                  '# Backup Date: ' . date(PHP_DATE_TIME_FORMAT) . "\n\n";
        fputs($fp, $schema);

        $tables_query = cip_db_query('show tables');
        while ($tables = vam_db_fetch_array($tables_query)) {
            $table = reset($tables);

            $schema = 'drop table if exists `' . $table . '`;' . "\n" . 'create table `' . $table . '` (' . "\n";

            $table_list = array();
            $fields_query = cip_db_query("show fields from `".$table."`");
            while ($fields=vam_db_fetch_array($fields_query)) {
                $table_list[]=$fields['Field'];
                $schema.='  `'.$fields['Field'].'` '.$fields['Type'];
                if (strlen($fields['Default']) > 0)    $schema.=' default \''.$fields['Default'].'\'';
                if ($fields['Null'] != 'YES')    $schema.=' not null';
                if (isset($fields['Extra']))    $schema.=' '.$fields['Extra'];
                $schema.=','."\n";
            }
            $schema = preg_replace("/,\n$/", '', $schema);
            // add the keys
            $index = array();
            $keys_query = cip_db_query("show keys from `".$table."`");
            while ($keys = vam_db_fetch_array($keys_query)) {
                $kname = $keys['Key_name'];
                if (!isset($index[$kname])) {
                    $index[$kname]=array('unique'=>!$keys['Non_unique'], 'columns'=>array());
                }
                $index[$kname]['columns'][]=$keys['Column_name'];
                $index[$kname]['sub_part'][]=$keys['Sub_part'];
            }
            while (list($kname, $info)=each($index)) {
                $schema.=','."\n";
                $columns='';
                foreach($info['columns'] as $id=>$col){
                	if($columns=='')
                		$columns.= "`".$col."`";
                	else
                		$columns.= ",`".$col."`";
                	if($info['sub_part'][$id] != NULL && $info['sub_part'][$id] != 'NULL')
                		$columns.= "(".$info['sub_part'][$id].")";
                }
                if ($kname=='PRIMARY')     $schema.='  PRIMARY KEY ('.$columns.')';
                elseif ($info['unique'])    $schema.='  UNIQUE `'.$kname.'` ('.$columns.')';
                else    $schema.='  KEY `'.$kname.'` ('.$columns.')';
            }
            $schema.="\n".');'."\n\n";
            fputs($fp, $schema);
    // dump the data
            $rows_query = cip_db_query("SELECT `".implode('`, `', $table_list)."` from `".$table."`");
            while ($rows = vam_db_fetch_array($rows_query)) {
                $schema = 'insert into `' . $table . '` (`' . implode('`, `', $table_list) . '`) values (';
                foreach ($table_list as $i) {
                    if (!isset($rows[$i]))    $schema .= 'NULL, ';
                    elseif (vam_not_null($rows[$i])) {
                        $row=addslashes($rows[$i]);
                        $row=preg_replace("/\n#/", "\n".'\#', $row);
                        $schema.='\''.$row.'\', ';
                    } else    $schema .= '\'\', ';
                }
                $schema=preg_replace('/, $/', '', $schema).');'."\n";
                fputs($fp, $schema);
            }
        }
        fclose($fp);
        gzcompressfile($backup_file);

        if (is_file($backup_file)) {
            //chmod($backup_file, 0777);
            ci_remove($backup_file);
        }
        if (file_exists($backup_file.'.gz'))    chmod($backup_file.'.gz', 0777);
    }






    //==================================================================
    //conflicts_check
    //==================================================================
    function conflicts_check_for_install() {
        if (!$this->is_all_right())     return;
        foreach ($this->contrib_data as $id=>$tag) {
            if ($this->error=$tag->conflicts_check_for_install())    break;
        }
    }


    function conflicts_check_for_remove() {
        if (!$this->is_all_right())     return;
        foreach ($this->contrib_data as $id=>$tag) {
            if ($this->error=$tag->conflicts_check_for_remove())    break;
        }
    }
    //==================================================================
    //permissions_check
    //==================================================================
    function permissions_check_for_install() {
        global $message;
        if (!$this->is_all_right())     return;
        foreach ($this->contrib_data as $id=>$tag) {
            $tag->permissions_check_for_install();
            if ($message->count_errors()) {
                $this->error=true;
                break;
            }
        }
    }


    function permissions_check_for_remove() {
        if (!$this->is_all_right())     return;
        foreach ($this->contrib_data as $id=>$tag) {
            if ($this->error=$tag->permissions_check_for_remove())    break;
        }
    }
    //==================================================================
    //Extra:
    //==================================================================

    //Checks if we have no error and have a data to work with:
    function is_all_right() {
        return ((($this->error) or (!is_array($this->contrib_data)) or
                      (is_array($this->contrib_data) && count($this->contrib_data)<1)) ? false : true);
    }
    function error($text='') {
        global $message;
        if ($text) {
            if ($this->was_unpacked() && $this->is_unpacked())     ci_remove(DIR_FS_CIP.'/'.$this->get_cip_name());
            return $this->error=$message->add($text, 'error');
        }
    }
    function check_error($stage='', $tag_name='', $id='', $text='') {
        if (!is_null($text)) $this->error($stage." at &#060;<i>".$tag_name."</i>&#062; #".$id.".<br><b>".$text."</b>");
        return $this->error; //true if we have an error!...
    }

    //==================================================================
    function include_tag_classes() {
        if (defined('TAG_LOADED'))    return;
        require_once(DIR_FS_ADMIN_CLASSES.'ci_tag.class.php');
        define('TAG_LOADED',1);
        $tag_files = glob(DIR_FS_ADMIN_CLASSES . 'ci_tag_*.class.php');
        for ($i = 0; $i < count($tag_files); $i++)     require($tag_files[$i]);
    }

    function is_Windows() {return ((strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') ? true : false);}

    function get_os() {
        if (substr(PHP_OS, 0, 3) == 'WIN')    return 'win';
        elseif (strpos($_SERVER[SERVER_SOFTWARE], 'Unix'))     return 'unix';
//         if (strpos($_SERVER[SERVER_SOFTWARE], 'Unix'))     return 'unix';
//         elseif (strpos($_SERVER[SERVER_SOFTWARE], 'Win'))    return 'win';
    }

	function getIdent(){
		return $this->contrib_data[$this->description_id]->data['ident'];
	}

	function getVersion(){
		return $this->contrib_data[$this->description_id]->data['version'];
	}

}
?>