<?php

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_config_group extends ContribInstallerBaseTag {
	var $tag_name = 'config_group';
	// Class Constructor
	function Tc_config_group($contrib = '', $id = '', $xml_data = '', $dep = '') {
		$this->params = array (
			'title' => array (
				'sql_type' => 'varchar(64)',
				'xml_error' => NO_TITLE_TAG_IN_CONFIGURATION_SECTION_TEXT
			),
			'key' => array (
				'sql_type' => 'varchar(64)',
				'xml_error' => NO_KEY_TAG_IN_CONFIGURATION_SECTION_TEXT
			),
			'descr' => array (
				'sql_type' => 'varchar(255)',


			),
			'sort_order' => array (
				'sql_type' => 'int(5)',


			),
			'visible' => array (
				'sql_type' => 'int(1)',


			),
		);
		$this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
	}
	//  Class Methods
	function get_data_from_xml_parser($xml_data = '') {
		$this->data['title'] = $this->getTagText($xml_data, 'title', 0);
		$this->data['key'] = $this->getTagText($xml_data, 'key', 0);
		$this->data['descr'] = $this->getTagText($xml_data, 'descr', 0);
		if ($this->data['descr'] == NULL)
			$this->data['descr'] = '';
		$this->data['sort_order'] = $this->getTagText($xml_data, 'sort_order', 0);
		$this->data['visible'] = $this->getTagText($xml_data, 'visible', 0);
	}

	function write_to_xml() {
		$tag = '<' . $this->tag_name . '>' . "\n";
		$tag .= ' <title>' . $this->data['title'] . '</title>' . "\n";
		$tag .= ' <key>' . $this->data['key'] . '</key>' . "\n";
		if ($this->data['descr'] != NULL)
			$tag .= ' <descr>' . $this->data['descr'] . '</descr>' . "\n";
		if ($this->data['sort_order'] != NULL)
			$tag .= ' <sort_order>' . $this->data['sort_order'] . '</sort_order>' . "\n";
		if ($this->data['visible'] != NULL)
			$tag .= ' <visible>' . $this->data['visible'] . '</visible>' . "\n";
		$tag .= '</' . $this->tag_name . '>';
		return $tag;
	}

	function do_install() {
		$query = "select configuration_group_id from " . TABLE_CONFIGURATION_GROUP . " where configuration_group_key='" . $this->data['key'] . "'";
		$rs = vam_db_query($query);
		if (!vam_db_fetch_array($rs)) {
			$query = "insert into " . TABLE_CONFIGURATION_GROUP . " (configuration_group_id, configuration_group_title, configuration_group_key, configuration_group_description, sort_order,  visible) " .
			" values ('','" . $this->data['title'] . "','" . $this->data['key'] . "','" . $this->data['descr'] . "'," . ($this->data['sort_order'] == NULL ? "NULL" : $this->data['sort_order']) . "," . ($this->data['visible'] == NULL ? "NULL" : $this->data['visible']) . ")";
			vam_db_query($query);
			if($this->data['sort_order'] == NULL){
				$sid = vam_db_insert_id();
				$query = "update " . TABLE_CONFIGURATION_GROUP . " set sort_order=".$sid." where configuration_group_id=".$sid;
				vam_db_query($query);
			}
		}
	}

	function do_remove() {
		if ($_REQUEST['remove_data'] == '1') {
			if($this->cip->is_ci())return $this->error;
			vam_db_query("DELETE FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_key = '" . $this->data['key'] . "'");
		}
	}
}
?>