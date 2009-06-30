<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Xml extends Resource {
	protected static $prefix = 'xml_';
	protected $destructor = 'parserFree';
}
