<?php
require_once dirname(__FILE__) . '/../Resource.php';

class PgSQL extends Resource {
	protected static $prefix = 'pg_';
	protected $destructor = 'close';
	protected $resources = array(
		'pgsql link persistent' => '',
		'pgsql result' => 'freeResult',
		'pgsql large object' => 'loClose',
	);
}
