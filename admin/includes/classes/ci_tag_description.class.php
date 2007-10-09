<?php
/*
Class Description operates with description-tag from install.xml.
Made by Vlad Savitsky
    http://forums.oscommerce.com/index.php?showuser=20490
Support:
    http://forums.oscommerce.com/index.php?showtopic=156667
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_description extends ContribInstallerBaseTag {
    function Tc_description($contrib='', $id='', $xml_data='', $dep='') {
    	$this->tag_name='description';
        $this->params=array(
            'contrib_ref'=>array(
                                'sql_type'=>'smallint unsigned',
                                'xml_error'=>NO_CONTRIB_REF_PARAMETER_IN_DETAILS_TAG_TEXT
                                ),
            'forum_ref'=>array(
                                'sql_type'=>'smallint unsigned',
                                'xml_error'=>NO_FORUM_REF_PARAMETER_IN_DETAILS_TAG_TEXT
                                ),
            'contrib_type'=>array(
                                'sql_type'=>'varchar(100)',
                                'xml_error'=>NO_CONTRIB_TYPE_PARAMETER_IN_DETAILS_TAG_TEXT
                                ),
            'status'=>array(
                                'sql_type'=>'tinyint unsigned',
                                'xml_error'=>''//NO_STATUS_PARAMETER_IN_DETAILS_TAG_TEXT
                                ),
            'last_update'=>array(
                                'sql_type'=>'varchar(30)',
                                'xml_error'=>NO_LAST_UPDATE_PARAMETER_IN_DETAILS_TAG_TEXT
                                ),
            'comments'=>array(
                                'sql_type'=>'text',
                                'xml_error'=>NO_COMMENTS_TAG_IN_DESCRIPTION_SECTION_TEXT
                                ),
            'credits'=>array(
                                'sql_type'=>'text',
                                'xml_error'=>NO_CREDITS_TAG_IN_DESCRIPTION_SECTION_TEXT
                                ),
            'ident'=>array(
                                'sql_type'=>'varchar(255)',
                                ),
            'version'=>array(
                                'sql_type'=>'varchar(20)',
                                ),
            'post_install_notes'=>array(
                                'sql_type'=>'text',
                                ),

        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep='');
    }
//Class Methods
//=============================================================
    function get_data_from_xml_parser($xml_data='') {
        $this->data['contrib_ref']    =$this->getTagAttr($xml_data,'details',0,'contrib_ref');
        $this->data['forum_ref']      =$this->getTagAttr($xml_data,'details',0,'forum_ref');
        $this->data['contrib_type']   =$this->getTagAttr($xml_data,'details',0,'contrib_type');
        $this->data['status']         =$this->getTagAttr($xml_data,'details',0,'status');
        $this->data['last_update']    =$this->getTagAttr($xml_data,'details',0,'last_update');
        $this->data['comments']       =$this->getTagText($xml_data,'comments',0);
        $this->data['credits']        =$this->getTagText($xml_data,'credits',0);
        $this->data['ident']          =$this->getTagText($xml_data,'ident',0);
        $this->data['version']        =$this->getTagText($xml_data,'version',0);
        if($this->data['ident']==NULL)$this->data['ident'] = $this->contrib;
        if($this->data['version']==NULL)$this->data['version'] = '1.0';
        $this->data['post_install_notes']        =$this->getTagText($xml_data,'post_install_notes',0);
    }


    function write_to_xml() {
        return '
        <'.$this->tag_name.'>
            <details contrib_ref="'.$this->data['contrib_ref'].'" forum_ref="'.$this->data['forum_ref'].'"
              contrib_type="'.$this->data['contrib_type'].'" status="'.$this->data['status'].'" last_update="'.$this->data['last_update'].'"/>
            <comments><![CDATA['.$this->data['comments'].']]></comments>
            <credits><![CDATA['.$this->data['credits'].']]></credits>
        	<ident>'.$this->data['ident'].'</ident>
        	<version>'.$this->data['version'].'</version>
            <post_install_notes>'.$this->data['post_install'].'</post_install_notes>
        </'.$this->tag_name.'>';
    }

    function conflicts_check_for_remove() {
    	if($this->cip->is_ci())return $this->error;
    	$query = 'select * from '.TABLE_CIP_DEPEND.' where cip_ident_req="'.$this->data['ident'].'" and cip_req_type=1';
    	$rs = vam_db_query($query);
    	$cips = '';
    	while($cp = vam_db_fetch_array($rs)){
    		if($cips=='')$cips = $cp['cip_ident'];
    		else $cips = ','.$cp['cip_ident'];
    	}
    	if($cips!=''){
    		$this->error("Some another CIP's requires this CIP and it can't be removed! (".$cips.")");
    	}
    	return $this->error;
    }
}


/*
====================================================================
<description>
	<details contrib_ref="" forum_ref="" contrib_type="" status="" last_update=""/>
	<comments><![CDATA[ ... ]]></comments>
	<credits><![CDATA[ ... ]]></credits>
	<ident>ADMIN_BOXES</ident> - identifier of CIP for require and depend tags
	<version>1.0</version> - identifier of CIP version for require and depend tags
    <post_install_notes>God bless you!</post_install_notes> - message that will be shown after install
</description>
====================================================================
*/
?>