<?php
require_once dirname(__FILE__) . '/../Resource.php';

class SQLite extends Resource {
	protected static $prefix = 'sqlite_';
	protected $destructor = 'close';
	protected $resources = array(
		'sqlite database (persistent)' => '',
		'sqlite result' => '',
	);
}
