<?php
/**
Class AddAdminMenu operates with addadminmenu tag from install.xml.
If installed CIP Admin_boxes then this tag add new menuitem to selected menu else do nothing
Made by Imrich Schindler
Released under GPL
*/

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

class Tc_addadminmenu extends ContribInstallerBaseTag {
	var $tag_name = 'addadminmenu';
//	var $data;
	//array with attributes
//	var $params;
	// Class Constructor
	function Tc_addadminmenu($contrib = '', $id = '', $xml_data = '', $dep='') {
		$this->params = array (
			'parent' => array (
				'sql_type' => 'varchar(255)',
				'xml_error' => PARENT_OF_MENU_MISSING_IN_ADDADMINMENU_SECTION_TEXT
			),
			'child' => array (
				'sql_type' => 'varchar(255)',
				'xml_error' => CHILD_OF_MENU_MISSING_IN_ADDADMINMENU_SECTION_TEXT
			),


		);
		$this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
	}
	//  Class Methods
	function get_data_from_xml_parser($xml_data = '') {
		if (defined('TABLE_ADMIN_BOXES')) {
			$this->data['parent']=array();
			$this->data['child'] = array();
			$tags = $xml_data->getElementsByTagName('menu');
			for ($i = 0; $i < $tags->getLength(); $i++) {
				$this->data['parent'][$i] = $this->getITagAttr($tags,$i,'parent');
				$this->data['child'][$i]  = $this->getITagAttr($tags,$i,'child');
				$this->data['type'][$i]  = $this->getITagAttr($tags,$i,'type');
				$this->data['url'][$i]  = $this->getITagAttr($tags,$i,'url');
			}
		}
	}

	function write_to_xml() {
		$tag='<' . $this->tag_name . '>';
		for($i = 0; $i < count($this->data['child']);$i++){
			$tag .='<box parent="' . $this->data['parent'][$i] . '" child="' . $this->data['child'][$i] . '" />';
		}
		$tag .='</' . $this->tag_name . '>';
		return $tag;
	}

	function do_install() {
		if ($this->error)return;
		if (!defined('TABLE_ADMIN_BOXES')) return $this->error;
		for($i = 0; $i < count($this->data['child']);$i++){

			$menu_query = vam_db_query("select abi.box_item_id , ab.box_id from " . TABLE_ADMIN_BOXES . " ab , " . TABLE_ADMIN_BOXES_ITEMS . " abi where ab.box_id = abi.box_id and ab.box_name = '" . $this->data['parent'][$i] . "' and abi.box_item_name = '" . $this->data['child'][$i] . "' order by box_id, box_item_id desc limit 1;");
			$menu = vam_db_fetch_array($menu_query);
			if (!$menu) {
				$parent_query = vam_db_query("select box_id from " . TABLE_ADMIN_BOXES . " where box_name = '" . $this->data['parent'][$i] . "';");
				$parent_array = vam_db_fetch_array($parent_query);
				if (!$parent_array) {
					//if exist this box as child for another parent
					$this->error("Box ".$this->data['parent'][$i]." does not exist!");
					return $this->error;
				}

				$menu_query = vam_db_query("select box_item_id from " . TABLE_ADMIN_BOXES_ITEMS . " where box_id = " . (int)$parent_array['box_id'] . " order by box_id, box_item_id desc limit 1;");
				$menu_array = vam_db_fetch_array($menu_query);
				$box_id = (int) $menu_array['box_item_id'] + 1;
				vam_db_query("insert into " . TABLE_ADMIN_BOXES_ITEMS . " (box_id,box_item_id,box_item_name, box_item_type, box_item_url, box_item_ssl) VALUES (" . $parent_array['box_id'] . "," . $box_id . ",'" . $this->data['child'][$i] . "','".$this->data['type'][$i]."','".$this->data['url'][$i]."',0);");
			}
		}
		return $this->error;
	}

	function do_remove() {
		if ($this->error) return;
		if (!defined('TABLE_ADMIN_BOXES')) return $this->error;
		for($i = 0; $i < count($this->data['child']);$i++){
			$menu_query = vam_db_query("select abi.box_item_id , ab.box_id from " . TABLE_ADMIN_BOXES . " ab , " . TABLE_ADMIN_BOXES_ITEMS . " abi where ab.box_id = abi.box_id and ab.box_name = '" . $this->data['parent'][$i] . "' and abi.box_item_name = '" . $this->data['child'][$i] . "' order by box_id, box_item_id desc limit 1;");
			$menu_array = vam_db_fetch_array($menu_query);
			if ($menu_array) {
				vam_db_query("delete from " . TABLE_ADMIN_BOXES_ITEMS . " where box_item_id=" . $menu_array['box_item_id'] . " and box_id=" . $menu_array['box_id'] . ";");
			}
		}
		return $this->error;
	}
}

/*
====================================================================
	<addadminmenu>
		<menu parent="BOM" child="BOMINSHOP_IMPORT"/>
	</addadminmenu>
    child is added as menu item to parent menu
====================================================================
*/
?>