<?php
/*
Class SQL operates with sql-tag from install.xml.
Made by Vlad Savitsky
    http://forums.oscommerce.com/index.php?showuser=20490
Support:
    http://forums.oscommerce.com/index.php?showtopic=156667
Released under GPL
*/
/*
Now you could use some SQL-statments into one <sql>-tag.
They must be separated by ";".
For example:
<sql>
    <query><![CDATA[
        INSERT INTO %DB_PREFIX%configuration_group
                VALUES (NULL, 'Contrib Installer', 'Configuration for the Contrib Installer', NULL, 1);
        UPDATE %DB_PREFIX%configuration_group
                SET sort_order=LAST_INSERT_ID()
                WHERE configuration_group_id=LAST_INSERT_ID();
    ]]></query>
    <remove_query><![CDATA[
        DELETE FROM %DB_PREFIX%configuration_group WHERE configuration_group_title = 'Contrib Installer';
    ]]></remove_query>
<sql>



also you could use another syntaxs. This code should work faster but I do not test it.
<sql>
    <query><![CDATA[
        INSERT INTO %DB_PREFIX%configuration_group
                VALUES (NULL, 'Contrib Installer', 'Configuration for the Contrib Installer', NULL, 1);
    ]]></query>
    <query><![CDATA[
        UPDATE %DB_PREFIX%configuration_group
                SET sort_order=LAST_INSERT_ID()
                WHERE configuration_group_id=LAST_INSERT_ID();
    ]]></query>
    <remove_query><![CDATA[
        DELETE FROM %DB_PREFIX%configuration_group WHERE configuration_group_title = 'Contrib Installer';
    ]]></remove_query>
<sql>


*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_sql extends ContribInstallerBaseTag {
    var $tag_name='sql';

    var $priority = 200;

// Class Constructor
    function Tc_sql($contrib='', $id='', $xml_data='', $dep='') {
        $this->params=array(
            'query'=>array(
                                'sql_type'=>'text',
                                'xml_error'=>NO_QUERY_TAG_IN_SQL_SECTION_TEXT
                                ),
            'remove_query'=>array(
                                'sql_type'=>'text',
                                'xml_error'=>NO_REMOVE_QUERY_NESSESARY_FOR_SQL_QUERY_TEXT
                                ),
        );
        $this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
    }
//  Class Methods
    function get_data_from_xml_parser($xml_data='') {
    	$this->data['query'] = array();
    	$this->data['remove_query'] = array();
    	$tags = $xml_data->getElementsByTagName('query');
    	for($i=0 ;$i < $tags->getLength(); $i++){
    		$this->data['query'][]  =$this->replace_dbprefix($this->getITagText($tags,$i));
    	}
    	$tags = $xml_data->getElementsByTagName('remove_query');
    	for($i=0 ;$i < $tags->getLength(); $i++){
        	$this->data['remove_query'][] =$this->replace_dbprefix($this->getITagText($tags,$i));
    	}
    }

    function write_to_xml() {
        $tag = '<'.$this->tag_name.'>';
        for($i=0; $i < count($this->data['query']);$i++){
           	$tag.= '<query><![CDATA['.(($this->data['query'][$i]) ? $this->data['query'][$i] : 'SELECT 1;').']]></query>';
        }
     	for($i=0; $i < count($this->data['remove_query']);$i++){
	        $tag.='<remove_query><![CDATA['.(($this->data['remove_query']) ? $this->data['remove_query'] : 'SELECT 1;').']]></remove_query>';
     	}
        $tag .= '</'.$this->tag_name.'>';
        return $tag;
    }

    function do_install($data='') {
        if (!$data)    $data=$this->data['query'];
        foreach ($data as $value){
            $sql_array=parse_sql($value);
            foreach ($sql_array as $query) {
                if(cip_db_query($query)===false) {
                	 global $$link;
                   $this->error('SQL error :<b>'.mysqli_errno($$link).' - '.mysqli_error($$link).'<br>'.$query);
                   return $this->error;
                }
            }
        }
        return $this->error;
    }

    function do_remove() {
    	if($this->data['remove_query'])
    		return $this->do_install($this->data['remove_query']);
    }

}

/*
====================================================================
            [SQL] => Array
                (
                    [2] => Array
                        (
                            [@] =>
                            [QUERY] => Array
                                (
                                    [0] => Array
                                        (
                                            [@] =>
                                            [#] => INSERT INTO configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (5000, 'Misc.', 'other configs', 20, 1)
                                        )
                                )
                            [REMOVE_QUERY] => Array
                                (
                                    [0] => Array
                                        (
                                            [@] =>
                                            [#] => DELETE FROM configuration_group WHERE configuration_group_title = 'Misc.'
                                        )
                                )
                        )
                )
            )
====================================================================
*/
?>