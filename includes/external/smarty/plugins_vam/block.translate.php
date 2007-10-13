<?php
/* -----------------------------------------------------------------------------------------
   $Id: block.translate.php 899 2007-10-13 20:14:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 John (AZTEK) Downey (block.translate.php,v 1.1 2003/03/17); 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
$xml = array();

function smarty_block_translate($params, $string, &$smarty) {
foreach($params as $key => $value) {
$params["%$key"] = $value;
unset($params[$key]);
}
print(t($string, $params));
}

function t($string, $args = array()) {
global $xml;

if(empty($xml)) {
if(file_exists("lang/{$_SESSION['language']}/{$_SESSION['language']}.xml")) {
$xml = getXmlTree("lang/{$_SESSION['language']}/{$_SESSION['language']}.xml");
} else {
return strtr($string, $args);
}
}

foreach($xml[0]['children'] as $tag) {
if($tag['tag'] == "MESSAGE") {
if($tag['children'][0]['value'] == $string) {
if($tag['children'][1]['value'] != "") {
return strtr($tag['children'][1]['value'], $args);
}
}
}
}

return strtr($string, $args);
}

function getChildren($vals, &$i) {
$children = array();

if(!isset($vals[$i]['attributes'])) {
$vals[$i]['attributes'] = "";
}

while(++$i < count($vals)) {
if(!isset($vals[$i]['attributes'])) {
$vals[$i]['attributes'] = "";
}

if(!isset($vals[$i]['value'])) {
$vals[$i]['value'] = "";
}

switch ($vals[$i]['type']) {
case 'complete':
array_push($children, array('tag' => $vals[$i]['tag'], 'attributes' => $vals[$i]['attributes'], 'value' => $vals[$i]['value']));
break;
case 'open':
array_push($children, array('tag' => $vals[$i]['tag'], 'attributes' => $vals[$i]['attributes'], 'children' => getChildren($vals, $i)));
break;
case 'close':
return $children;
break;
}
}

return $children;
}

function getXmlTree($file) {
$data = implode("", file($file));
$xml = xml_parser_create();
xml_parser_set_option($xml, XML_OPTION_SKIP_WHITE, 1);
xml_parse_into_struct($xml, $data, $vals, $index);
xml_parser_free($xml);

$tree = array();
$i = 0;
array_push($tree, array('tag' => $vals[$i]['tag'], 'attributes' => $vals[$i]['attributes'], 'children' => getChildren($vals, $i)));

return $tree;
}
?>