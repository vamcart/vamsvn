<?php
/*
Class depend operates with depend-tag from install.xml.
Made by Imrich Schindler <ischindl at progis.sk>
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_depend extends ContribInstallerBaseTag {
    var $tag_name='depend';
    var $count_php_tags = 0;
    var $contrib_data = array();

    // Class Constructor
    function Tc_depend($contrib='', $id='', $xml_data='', $dep='') {
        $this->params=array(
            'cip_ident'=>array(
                                'sql_type'=>'varchar (255)',
                                'xml_error'=>"no CIP ident"
                                ),
            'cip_version'=>array(
                                'sql_type'=>'varchar (255)',
                                ),
        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }
//  Class Methods

    function get_data_from_xml_parser($xml_data='') {
        $this->data['cip_ident']   =$this->getTagText($xml_data,'cip',0);
        $this->data['cip_version'] =$this->getTagAttr($xml_data,'cip',0,'version');

        $active = false;
        if($this->data['cip_ident'] == 'jos_commerce'){
			if($this->isJoscom()) $active = true;
        }else{
	        $query = 'select * from '.TABLE_CIP. ' where cip_ident="'.$this->data['cip_ident'].'"'.($this->data['cip_version']==NULL?'':' and cip_version="'.$this->data['cip_version'].'"').' and cip_installed=1';
    	    $result = cip_db_query($query,'return');
        	$active =(vam_db_num_rows($result)>0);
	    }
        if($active){
        	//if cip installed
        	$obj = $xml_data->getElementsByTagName('active');
        	if(is_object($obj))$mtag = $obj->item(0);
        }else{
        	$obj = $xml_data->getElementsByTagName('inactive');
        	if(is_object($obj))$mtag = $obj->item(0);
        }
        if(is_object($mtag)) $this->getSubTags($mtag);
    }


    function write_to_xml() {
        $tag = '
        <'.$this->tag_name.'>
            <cip' . ($this->data['cip_version'] == NULL ? '' : ' version="' . $this->data['cip_version'] . '"') . '>'.$this->data['cip_ident'].'</cip>
            <active>'. $this->data['active']. '</active>
            <inactive>'. $this->data['inactive']. '</inactive>
        </'.$this->tag_name.'>';
       return $tag;
    }

	function permissions_check_for_install() {
		foreach ($this->contrib_data as $tag)     if ($this->error=$tag->permissions_check_for_install())    break;
		return $this->error;
	}

	function permissions_check_for_remove() {
    	foreach ($this->contrib_data as $tag)     if ($this->error=$tag->permissions_check_for_remove())    break;
		return $this->error;
	}

	function conflicts_check_for_remove() {
    	foreach ($this->contrib_data as $tag)     if ($this->error=$tag->conflicts_check_for_remove())    break;
		return $this->error;
	}
	function conflicts_check_for_install() {
		foreach ($this->contrib_data as $tag)     if ($this->error=$tag->conflicts_check_for_install())    break;
		return $this->error;
	}

    //===============================================================
    function do_install() {
    	$query = 'replace into ' . TABLE_CIP_DEPEND . '(cip_ident, cip_ident_req, cip_req_type) values("' . $this->cip->getIdent() . '","' . $this->data['cip_ident'] . '",2)';
		vam_db_query($query);
        foreach ($this->contrib_data as $tag)     if ($this->error=$tag->do_install())    break;
        return $this->error;
    }

    function do_remove() {
    	$query = 'delete from ' . TABLE_CIP_DEPEND . ' where cip_ident = "' . $this->cip->getIdent() . '" and cip_ident_req= "' . $this->data['cip_ident'] . '" and cip_req_type=2';
		vam_db_query($query);
        foreach ($this->contrib_data as $tag)     if ($this->error=$tag->do_remove())    break;
        return $this->error;
    }

    function getSubTags($mtag){
    	$tagcnt = array();
    	foreach ($mtag->childNodes as $id=>$tag_data) {
            if(sizeof($tag_data)==0) continue;
            // ignore xml comments
            if ($tag_data->nodeName=='#comment') continue;
            if(array_key_exists($tag_data->nodeName,$tagcnt)){
	          	$tagcnt[$tag_data->nodeName]++;
	        }else{
	           	$tagcnt[$tag_data->nodeName] = 0;
	        }
			if (strtolower($tag_data->nodeName)=='php')     $this->count_php_tags++;
	        $clsname='Tc_'.strtolower($tag_data->nodeName);
            if (class_exists($clsname)){
            	$this->contrib_data[] = new $clsname($this->cip, $tagcnt[$tag_data->nodeName], $tag_data," in depend #".$this->id. $this->depend);
            }else {
            	$this->error('Tag'.$tag_data->nodeName.' is not supported. Class '.$clsname.' does NOT exist.');
            	return;
            }
        }

    }
}
/*
====================================================================
<depend>
	<cip [version="1.0"]>ADMIN_BOXES</cip>
	<active>
	.
	.
	</active>
	<inactive>
	.
	.
	</inactive>
</depend>

====================================================================
*/
?>