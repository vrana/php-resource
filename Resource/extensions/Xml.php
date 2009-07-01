<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Xml extends Resource {
	protected static $prefix = 'xml_';
	protected $destructor = 'parserFree';
	
	function parseIntoStruct($data, &$values, &$index = null) {
		return xml_parse_into_struct($this->resource, $data, $values, $index);
	}
}
