<?php
require_once dirname(__FILE__) . '/Resource.php';

class Mssql extends Resource {
	protected static $prefix = 'mssql_';
	protected $destructor = 'close';
	protected $resources = array(
		'mssql link persistent' => '',
		'mssql result' => 'freeResult',
	);
}
