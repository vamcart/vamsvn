<?php
/**
 * LanguageReader.php
 *
 * @package MCFileManager.filesystems
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

/**
 * This class handles XML language packs.
 *
 * @package MCFileManager.utils
 */
class LanguageReader {
	var $_items;
	var $_parser;
	var $_curTarget;
	var $_curItem;

	function LanguageReader() {
		$this->_items = array();
		$this->_curTarget = "";
		$this->_curItem = "";
	}

	/**
	 * Returns the encoding of a XML file or UTF-8 if it wasn't found.
	 *
	 * @param $file File to get XML encoding from.
	 * @return encoding of a XML file or UTF-8 if it wasn't found
	 */
	function getEncoding($file) {
		if (($fp = fopen($file, "r"))) {
			while (!feof($fp)) {
				$line = fgets($fp);

				preg_match('/<?xml.*encoding=[\'"](.*?)[\'"].*?>/m', $line, $matches);

				// Found XML encoding
				if (count($matches) > 1) {
					fclose($fp);
					return strtoupper($matches[1]);
				}
			}

			fclose($fp);
		}

		return 'UTF-8';
	}

	function loadXML($file) {
		$this->_parser = xml_parser_create($this->getEncoding($file)); // Auto detect for PHP4/PHP5
		xml_set_object($this->_parser, $this);
		xml_set_element_handler($this->_parser, "_saxStartElement", "_saxEndElement");
		xml_set_character_data_handler($this->_parser, "_saxCharacterData");
		xml_parser_set_option($this->_parser, XML_OPTION_TARGET_ENCODING, "UTF-8");

		if (($fp = fopen($file, "r"))) {
			$data = '';

			while (!feof($fp))
				$data .= fread($fp, 8192);

			fclose($fp);

			// Strip slashes
				if (ini_get("magic_quotes_gpc"))
					$data = stripslashes($data);

			// XML parse
			if (!xml_parse($this->_parser, $data, true)) {
				trigger_error(sprintf("Language pack loading failed, XML error: %s at line %d.", xml_error_string(xml_get_error_code($this->_parser)), xml_get_current_line_number($this->_parser)), FATAL);
			}
		} else
			trigger_error("Could not open XML language pack: " . $file, FATAL);

		xml_parser_free($this->_parser);
	}

	function get($target, $name) {
		return isset($this->_items[$target][$name]) ? $this->_items[$target][$name] : ("$" . $name . "$");
	}

	// * * Private methods

	function _saxStartElement($parser, $name, $attrs) {
		if ($name == "GROUP") {
			$this->_curTarget = $attrs["TARGET"];
			if (!isset($this->_items[$this->_curTarget]))
				$this->_items[$this->_curTarget] = array();
		}

		if ($name == "ITEM")
			$this->_curItem = $attrs["NAME"];
	}

	function _saxEndElement($parser, $name) {
		if ($name == "GROUP")
			$this->_curTarget = "";

		if ($name == "ITEM")
			$this->_curItem = "";
	}

	function _saxCharacterData($parser, $data) {
		if ($this->_curTarget != "" && $this->_curItem != "") {
			if (!isset($this->_items[$this->_curTarget][$this->_curItem]))
				$this->_items[$this->_curTarget][$this->_curItem] = "";

			$this->_items[$this->_curTarget][$this->_curItem] .= $data;
		}
	}
}
?>