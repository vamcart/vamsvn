<?php
/*
Class Tc_createtable operates with createtable-tag from install.xml.
Made by Imrich Scindler
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_modifytable extends ContribInstallerBaseTag {
    var $tag_name='modifytable';
    // Class Constructor
    function Tc_modifytable($contrib='', $id='', $xml_data='', $dep='') {
        $this->params=array(
            'tablename'=>array(
                                'sql_type'=>'varchar (255)',
                                'xml_error'=>"no table name; "
                                ),
            'data'=>array(
                                'sql_type'=>'text',
                                'xml_error'=>"no data definition; "
                                ),
             'action'=>array(
                                'sql_type'=>"ENUM ('addcol')",
                                'xml_error'=>"no action definition; "
                                ),
            'after'=>array(
                                'sql_type'=>'varchar (255)',
                                ),
            
        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }

    function get_data_from_xml_parser($xml_data='') {
        $this->data['tablename'] =$this->getTagAttr($xml_data,'table',0,'name');
        $this->data['colname']    =$this->getTagAttr($xml_data,'column',0,'name');
        $this->data['action']    =$this->getTagAttr($xml_data,'column',0,'action');
        $this->data['data']      =$this->getTagText($xml_data,'column',0);
        $this->data['after']     =$this->getTagAttr($xml_data,'column',0,'after');
    }
    //===============================================================
    function do_install() {
    	switch ($this->data['action']){
    		case 'addcol':
    			$iscol = false;
    			$query = "show fields from `". DB_PREFIX . $this->data['tablename']."`";
    			$rs = vam_db_query($query);
    			while($row = vam_db_fetch_array($rs)){
    				if($row['Field']==$this->data['colname'] ){
    					$iscol = true;
    					break;
    				}
	   			}
    			if($iscol){
	   				$sqlq = "alter table `" . DB_PREFIX . $this->data['tablename'] . "` change `".$this->data['colname']."` `".$this->data['colname']."` ".$this->data['data'];
    			}else{
    				$sqlq = "alter table `" . DB_PREFIX . $this->data['tablename'] . "` add `".$this->data['colname']."` ".$this->data['data'].($this->data['after']!=""?" AFTER ".$this->data['after']:"");
    			}
    			if(cip_db_query($sqlq)=== false){
    				global $$link;
					$this->error('SQL error :<b>'.mysqli_errno($$link).' - '.mysqli_error($$link).'<br>'.$this->data['tablename']);
					return $this->error;
    			}
    		break;
    	}
        return $this->error;
    }

	function do_remove() {
    	switch ($this->data['action']){
    		case 'addcol':
    			$iscol = false;
    			$query = "show fields from `" . DB_PREFIX . $this->data['tablename']."`";
    			$rs = vam_db_query($query);
    			while($row = vam_db_fetch_array($rs)){
    				if($row['Field']==$this->data['colname'] ){
    					$iscol = true;
    					break;
    				}
	   			}
    			if($iscol){
	   				$sqlq = "alter table `" . DB_PREFIX . $this->data['tablename'] . "` drop `".$this->data['colname']."`";
    				if(cip_db_query($sqlq)=== false){
    					global $$link;
						$this->error('SQL error :<b>'.mysqli_errno($$link).' - '.mysqli_error($$link).'<br>'.$this->data['tablename']);
						return $this->error;
    				}
    			}
    		break;
    	}
        return $this->error;
    }
}
?>