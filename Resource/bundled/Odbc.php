<?php
require_once dirname(__FILE__) . '/../Resource.php';

class Odbc extends Resource {
	protected static $prefix = 'odbc_';
	protected $destructor = 'close';
	protected $resources = array(
		'odbc link persistent' => '',
		'odbc result' => 'freeResult',
	);
}
