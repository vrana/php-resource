<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Mssql extends Resource {
	protected static $prefix = 'mssql_';
	protected $destructor = 'close';
	protected $resources = array(
		'mssql link persistent' => '',
		'mssql statement' => 'freeStatement',
		'mssql result' => 'freeResult',
	);
	
	function bind($param_name, &$var, $type, $is_output = false, $is_null = false, $maxlen = -1) {
		return mssql_bind($this->resource, $param_name, $var, $type, $is_output, $is_null, $maxlen);
	}
}
