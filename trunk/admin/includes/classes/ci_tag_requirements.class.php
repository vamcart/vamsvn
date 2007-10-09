<?php

/**
Class Tc_requirements operates with requirements-tag from install.xml.
Made by Imrich Schindler <ischindl at progis.sk>
Released under GPL
**/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_requirements extends ContribInstallerBaseTag {
    var $tag_name='requirements';
	var $req = array();
	var $ver = array ();
    // Class Constructor
    function Tc_depend($contrib='', $id='', $xml_data='', $dep='') {
    	$this->params=array();
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }
//  Class Methods

    function get_data_from_xml_parser($xml_data='') {
        $tags = $xml_data->getElementsByTagName('require');
    	for($i=0 ;$i < $tags->getLength(); $i++){
    		$this->req[] = $this->getITagText($tags,$i);
			$this->ver[] = $this->getITagAttr($tags, $i, 'version');
    	}
    }

    function write_to_xml() {
       $tag = '<'.$this->tag_name.'>';
		for ($i = 0; $i < count($this->req); $i++) {
			$tag .= '<require' . ($this->ver[$i] == NULL ? '' : ' version="' . $this->ver[$i] . '"') . '>' . $this->req[$i] . '</require>';
       }
       $tag .= '</'.$this->tag_name.'>';
       return $tag;
    }

    //===============================================================
    function permissions_check_for_install() {
		foreach ($this->req as $id => $require) {
			if (strtolower($require) == 'jos_commerce') {
				if(!$this->isJoscom()){
					$this->error('This CIP is only for Jos-Commerce environment!');
	       			return $this->error;
				}
				continue;
			}
			if (strtolower($require) == 'os_commerce') {
				if($this->isJoscom()){
					$this->error('This CIP is only for OSCommerce environment!');
	       			return $this->error;
				}
				continue;
			}
			$query = 'select * from ' . TABLE_CIP . ' where cip_ident="' . $require . '"'.($this->ver[$id]!= NULL?' and cip_version="' . $this->ver[$id] . '"':''). ' and cip_installed=1';
    	    $result = cip_db_query($query,'return');
        	if(vam_db_num_rows($result)==0){
	       		//required CIP not installed
	       		$this->error('CIP '.$require.' is not installed and is required !');
	       		return $this->error;
        	}
		}
		return $this->error;
    }

	function xml_check(){
	}
	/**
	 * Insert all info about requirements of this CIP
	 */
    function do_install() {
		foreach ($this->req as $id => $require) {
			$query = 'replace into ' . TABLE_CIP_DEPEND . '(cip_ident, cip_ident_req, cip_req_type) values("' . $this->cip->getIdent() . '","' . $require . '",1)';
			vam_db_query($query);
		}
    }

	/**
	 * Remove all info about requirements of this CIP
	 */
    function do_remove() {
		foreach ($this->req as $id => $require) {
			$query = 'delete from ' . TABLE_CIP_DEPEND . ' where cip_ident = "' . $this->cip->getIdent() . '" and cip_ident_req= "' . $require . '" and cip_req_type=1';
			vam_db_query($query);
		}
    }

}

/*
====================================================================
<requirements>
	<reguire [version="1.2"]>ADMIN_BOXES</require>
	.
	.
<<<<<<< ci_tag_requirements.class.php
	<reguire>es_commerce</require>
=======
	<require>jos_commerce</require>
>>>>>>> 1.5
</requirements>
====================================================================
*/
?>