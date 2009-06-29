<?php
require_once dirname(__FILE__) . '/../Resource.php';

class MySQL extends Resource {
	protected static $prefix = 'mysql_';
	protected $unshift = false;
	protected $destructor = 'close';
	protected $resources = array(
		'mysql link persistent' => '',
		'mysql result' => 'freeResult',
	);
	
	protected function __construct($resource, $name, array $args) {
		parent::__construct($resource, $name, $args);
		if (get_resource_type($resource) == 'mysql result') {
			$this->unshift = true;
		}
	}
}
