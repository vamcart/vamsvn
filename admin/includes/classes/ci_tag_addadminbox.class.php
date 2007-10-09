<?php


/**
Class AddAdminBox operates with addadminbox tag from install.xml.
If installed CIP Admin_boxes then this tag add new box(menu) to main menu else do nothing
Made by Imrich Schindler
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_addadminbox extends ContribInstallerBaseTag {
	var $tag_name = 'addadminbox';
//	var $data;
	//array with attributes
//	var $params;

	// Class Constructor
	function Tc_addadminbox($contrib = '', $id = '', $xml_data = '', $dep='') {
		$this->params = array (
			'parent' => array (
				'sql_type' => 'varchar(255)',
				'xml_error' => PARENT_OF_BOX_MISSING_IN_ADDADMINBOX_SECTION_TEXT
			),
			'child' => array (
				'sql_type' => 'varchar(255)',
				'xml_error' => CHILD_OF_BOX_MISSING_IN_ADDADMINBOX_SECTION_TEXT
			),
		);
		$this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
		$this->priority = 100;
	}
	//  Class Methods
	function get_data_from_xml_parser($xml_data = '') {
		if (defined('TABLE_ADMIN_BOXES')) {
			$this->data['parent'] = array();
			$this->data['child'] = array();
			$this->data['parent_id'] = array();
			$tags = $xml_data->getElementsByTagName('box');
			for ($i = 0; $i < $tags->getLength(); $i++) {
				$this->data['child'][$i] = $this->getITagAttr($tags,$i,'child');
				$this->data['parent'][$i] = $this->getITagAttr($tags,$i,'parent');
				if ($this->data['parent'][$i] == "" ||(!isset($this->data['parent'][$i]))) {
					$this->data['parent'][$i] = "";
					$this->data['parent_id'][$i] = 0;
				} else {
					$menu_query = vam_db_query("select box_id from " . TABLE_ADMIN_BOXES . " where box_name = '" . $this->data['parent'][$i] . "' and order by box_id, box_item_id limit 1");
					$menu = vam_db_fetch_array($menu_query);
					if (!$menu) {
						$menu_array = vam_db_fetch_array($menu_query);
						$this->data['parent_id'][$i] = $menu_array['box_id'];
					}
				}
			}
		}
	}

	function write_to_xml() {
		$tag = '<' . $this->tag_name . '>';
		for ($i = 0; $i < count($this->data['child']); $i++) {
			$tag .= '<box parent="' . $this->data['parent'][$i] . '" child="' . $this->data['child'][$i] . '" />';
		}
		$tag .= '</' . $this->tag_name . '>';
		return $tag;
	}

	function conflicts_check_for_install() {
		if (!defined('TABLE_ADMIN_BOXES')) return $this->error;
		for ($i = 0; $i < count($this->data['child']); $i++) {
			$menu_query = vam_db_query("select * from " . TABLE_ADMIN_BOXES . " where box_parent_id!='" . $this->data['parent_id'][$i] . "' and box_name = '" . $this->data['child'][$i] . "';");
			$menu = vam_db_fetch_array($menu_query);
			if ($menu) {
				//if exist this box as child for another parent
				$this->error("Box " . $this->data['child'][$i] . " is duplicated!");
				return $this->error;
			}

		}
		return $this->error;
	}

	function do_install() {
		if ($this->error)
			return;
		if (!defined('TABLE_ADMIN_BOXES')) return $this->error;
		for ($i = 0; $i < count($this->data['child']); $i++) {
			//insert menu
			$menu_query = vam_db_query("select * from " . TABLE_ADMIN_BOXES . " where box_parent_id='" . $this->data['parent_id'][$i] . "' and box_name = '" . $this->data['child'][$i] . "';");
			$menu = vam_db_fetch_array($menu_query);
			if (!$menu) {
				$menu_query = vam_db_query("select box_id from " . TABLE_ADMIN_BOXES . " where true order by box_id desc limit 1;");
				$menu_array = vam_db_fetch_array($menu_query);
				$box_id = (int) $menu_array['box_id'] + 1;
				vam_db_query("insert into " . TABLE_ADMIN_BOXES . " (box_parent_id,box_id,box_name) VALUES (" . $this->data['parent_id'][$i] . "," . $box_id . ",'" . $this->data['child'][$i] . "');");
			}
		}
		return $this->error;
	}

	function do_remove() {
		if ($this->error)
			return;
		if (!defined('TABLE_ADMIN_BOXES')) return $this->error;
		for ($i = 0; $i < count($this->data['child']); $i++) {
			$menu_query = vam_db_query("select box_id from " . TABLE_ADMIN_BOXES . " where box_name = '" . $this->data['child'][$i] . "';");
			$menu_array = vam_db_fetch_array($menu_query);
			if ($menu_array) {
				vam_db_query("delete from " . TABLE_ADMIN_BOXES_ITEMS . " where box_id=" . $menu_array['box_id'] . ";");
				vam_db_query("delete from " . TABLE_ADMIN_BOXES . " where box_id=" . $menu_array['box_id'] . ";");
			}
		}
		return $this->error;
	}

}

/*
====================================================================
    <addadminbox>
    	<box parent="" child="BOM"/>
    </addadminbox>

    if parent=="" then child is added to root of menu else is added as submenu
====================================================================
*/
?>