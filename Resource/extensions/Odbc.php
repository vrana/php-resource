<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Odbc extends Resource {
	protected static $prefix = 'odbc_';
	protected $destructor = 'close';
	protected $resources = array(
		'odbc link persistent' => '',
		'odbc result' => 'freeResult',
	);
	
	function fetchInto(&$result_array, $rownumber = null) {
		switch (func_num_args()) {
			case 1: return odbc_fetch_into($this->resource, $result_array);
			case 2: return odbc_fetch_into($this->resource, $result_array, $rownumber);
		}
	}
}
