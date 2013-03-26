<?php

defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

/*
Class Tc_createtable operates with createtable-tag from install.xml.
Made by Imrich Scindler
Released under GPL
*/

class Tc_createtable extends ContribInstallerBaseTag {
	var $tag_name = 'createtable';
	// Class Constructor
	function Tc_createtable($contrib = '', $id = '', $xml_data = '', $dep = '') {
		$this->params = array (
			'tablename' => array (
				'sql_type' => 'varchar (255)',
				'xml_error' => "no table name; "
			),
			'data' => array (
				'sql_type' => 'text',
				'xml_error' => "no table definition; "
			),

		);
		$this->ContribInstallerBaseTag($contrib, $id, $xml_data, $dep);
	}

	function get_data_from_xml_parser($xml_data = '') {
		$this->data['tablename'] = $this->getTagAttr($xml_data, 'table', 0, 'name');
		$this->data['data'] = $this->getTagText($xml_data, 'table', 0);
	}
	//===============================================================
	function do_install() {
		$sqlq = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . $this->data['tablename'] . "` " . $this->data['data'] . ";";
		if (cip_db_query($sqlq) === false) {
			global $$link;
			$this->error('SQL error :<b>' . mysqli_errno($$link) . ' - ' . mysqli_error($$link) . '<br>' . $this->data['tablename']);
			return;
		}

		$tblrows .= "  define('TABLE_" . strtoupper($this->data['tablename']) . "',
		        (defined('DB_PREFIX') ? DB_PREFIX : '').'" . strtolower($this->data['tablename']) . "');\n";
		$add_str = $this->linebreak_fixing("\n" . $this->comment_string($tblrows));
		$output .= $this->add_file_end("includes/database_tables.php", $add_str);
		if (!$this->isJoscom()) {
			$output .= $this->add_file_end("admin/includes/database_tables.php", $add_str);
		}
		return $this->error;
	}

	function do_remove() {
		if ($_REQUEST['remove_data'] == '1') {
			$sqlq = "DROP TABLE IF EXISTS `" . DB_PREFIX . $this->data['tablename'] . "`;";
			//$output .= "<div class=\"section\"><font class=\"section-title\">" . RUN_SQL_REMOVE_QUERY_TEXT . "</font><p class=\"sql_code\">" .
			//nl2br(htmlentities($sqlq)) . "</p></div>";
			if (cip_db_query($sqlq) === false) {
				global $$link;
				$this->error('SQL error :<b>' . mysqli_errno($$link) . ' - ' . mysqli_error($$link) . '<br>' . $this->data['tablename']);
			}
		}
		$tblrows .= "  define('TABLE_" . strtoupper($this->data['tablename']) . "', (defined('DB_PREFIX') ? DB_PREFIX : '').'" . strtolower($this->data['tablename']) . "');\n";

		$add_str = $this->linebreak_fixing("\n" . $this->comment_string($tblrows));
		$output .= $this->remove_file_part("includes/database_tables.php", $add_str);
		if (!$this->isJoscom()) {
			$output .= $this->remove_file_part("admin/includes/database_tables.php", $add_str);
		}
		return $this->error;
	}
}
?>