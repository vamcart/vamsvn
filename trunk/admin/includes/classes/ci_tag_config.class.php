<?php
/*
Class configuration operates with configuration-tag from install.xml.
Made by Vlad Savitsky
    http://forums.oscommerce.com/index.php?showuser=20490
Support:
    http://forums.oscommerce.com/index.php?showtopic=156667
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_config extends ContribInstallerBaseTag {
	var $tag_name = 'config';
	// Class Constructor
	function Tc_config($contrib = '', $id = '', $xml_data = '', $dep = '') {
		$this->params = array (
			'title' => array (
				'sql_type' => 'varchar(64)',
				'xml_error' => NO_TITLE_TAG_IN_CONFIG_SECTION_TEXT
			),
			'key' => array (
				'sql_type' => 'varchar(64)',
				'xml_error' => NO_KEY_TAG_IN_CONFIG_SECTION_TEXT
			),
			'value' => array (
				'sql_type' => 'varchar(255)',


			),
			'descr' => array (
				'sql_type' => 'varchar(255)',


			),
			'group_key' => array (
				'sql_type' => 'varchar(255)',
				'xml_error' => NO_GROUPKEY_TAG_IN_CONFIG_SECTION_TEXT
			),
			'sort_order' => array (
				'sql_type' => 'int(5)',


			),
			'use_function' => array (
				'sql_type' => 'varchar(255)',


			),
			'set_function' => array (
				'sql_type' => 'varchar(255)',


			),
			'lang' => array (
				'sql_type' => 'varchar(64)',


			),
		);
		$this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
	}
	//  Class Methods
	function get_data_from_xml_parser($xml_data = '') {
		$this->data['title'] = $this->getTagText($xml_data, 'title', 0);
		$this->data['key'] = $this->getTagText($xml_data, 'key', 0);
		$this->data['value_type'] = $this->getTagAttr($xml_data, 'value', 0,'type');
		$this->data['value'] = $this->getTagText($xml_data, 'value', 0);
		if ($this->data['value'] == NULL)
			$this->data['value'] = '';
		if($this->data['value_type']=="php"){
			$this->data['value'] = eval("return ".$this->data['value']);
		}
		$this->data['descr'] = $this->getTagText($xml_data, 'descr', 0);
		if ($this->data['descr'] == NULL)
			$this->data['descr'] = '';
		$this->data['group_key'] = $this->getTagText($xml_data, 'group_key', 0);
		$this->data['sort_order'] = $this->getTagText($xml_data, 'sort_order', 0);
		$this->data['use_function'] = $this->getTagText($xml_data, 'use_function', 0);
		$this->data['set_function'] = $this->getTagText($xml_data, 'set_function', 0);
		$this->data['lang'] = $this->getTagText($xml_data, 'lang', 0);
		if ($this->data['lang'] == NULL)
			$this->data['lang'] = 'english';
		$this->data['add'] = "define('TEXT_CONF_".$this->data['key']."','".$this->data['title']."');\ndefine('TEXT_CONF_DESC_".$this->data['key']."','".$this->data['descr']."');";
		$this->data['filename'] = 'lang/'.$this->data['lang'].'/admin/configuration.php';
	}

	function write_to_xml() {
		$tag = '<' . $this->tag_name . '>' . "\n";
		$tag .= ' <title>' . $this->data['title'] . '</title>' . "\n";
		$tag .= ' <key>' . $this->data['key'] . '</key>' . "\n";
		$tag .= ' <group_key>' . $this->data['group_key'] . '</group_key>' . "\n";
		if ($this->data['value'] != NULL)
			$tag .= ' <value'.($this->data['value_type'] != NULL?' type="'.$this->data['value_type'].'"':'').'>' . $this->data['value'] . '</value>' . "\n";
		if ($this->data['descr'] != NULL)
			$tag .= ' <descr>' . $this->data['descr'] . '</descr>' . "\n";
		if ($this->data['sort_order'] != NULL)
			$tag .= ' <sort_order>' . $this->data['sort_order'] . '</sort_order>' . "\n";
		if ($this->data['use_function'] != NULL)
			$tag .= ' <use_function>' . $this->data['use_function'] . '</use_function>' . "\n";
		if ($this->data['set_function'] != NULL)
			$tag .= ' <set_function>' . $this->data['set_function'] . '</set_function>' . "\n";
		$tag .= ' <lang>' . $this->data['lang'] . '</lang>' . "\n";
		$tag .= '</' . $this->tag_name . '>';
		return $tag;
	}

	function do_install() {
		$query = "select configuration_group_id as gid from " . TABLE_CONFIGURATION_GROUP . " where configuration_group_key='" . $this->data['group_key'] . "'";
		$rs = vam_db_query($query);
		if (!($row = vam_db_fetch_array($rs))) {
			$this->error('Configuration group with key: ' . $this->data['group_key'] . ' does not exists !');
		}else{
			$this->data['gid'] = $row['gid'];
		}
		$query = "select configuration_id from " . TABLE_CONFIGURATION . " where configuration_key='" . $this->data['key'] . "'";
		$rs = vam_db_query($query);
		if (!vam_db_fetch_array($rs)) {
			$query = "insert into " . TABLE_CONFIGURATION . "(configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) " .
			" values ('','" . $this->data['title'] . "','" . $this->data['key'] . "','" . $this->data['value'] . "','" . $this->data['descr'] . "'," . $this->data['gid'] . "," . ($this->data['sort_order'] == NULL ? "NULL" : $this->data['sort_order']) . ",now(),now()," . ($this->data['use_function'] == NULL ? "NULL" : "'".$this->data['use_function']."'") . "," . ($this->data['set_function'] == NULL ? "NULL" : "'".$this->data['set_function']."'") . ")";
			vam_db_query($query);
		}
		if(file_exists($this->fs_filename()))  $this->add_file_end($this->data['filename'],$this->add_str());
	}


	function do_remove() {
		if ($_REQUEST['remove_data'] == '1' && $this->data['lang'] == 'russian') {
			if($this->cip->is_ci())return $this->error;
			vam_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = '" . $this->data['key'] . "'");
		}
		if(file_exists($this->fs_filename())) $this->remove_file_part($this->data['filename'],$this->add_str());
	}
}

/*
====================================================================
<config>
 <title></title>
 <key></key>
 <group_key></group_key>
 [<value></value>]
 [<descr></descr>]
 [<sort_order></sort_order>]
 [<use_function></use_function>]
 [<set_function></set_function>]
 [<lang></lang>]
</config>
====================================================================
*/
?>