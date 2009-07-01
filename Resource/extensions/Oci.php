<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Oci extends Resource {
	protected static $prefix = 'oci_';
	protected $destructor = 'close';
	protected $resources = array(
		'oci8 persistent connection' => '',
		'oci8 persistent session pool' => '',
		'oci8 statement' => 'freeStatement',
	);
	
	function bindArrayByName($name, &$var_array,$max_table_length, $max_item_length = -1, $type = SQLT_AFC) {
		return oci_bind_array_by_name($this->resource, $name, $var_array,$max_table_length, $max_item_length, $type);
	}
	
	function bindByName($ph_name, &$variable, $maxlength = -1, $type = SQLT_CHR) {
		return oci_bind_by_name($this->resource, $ph_name, $variable, $maxlength, $type);
	}
	
	function defineByName($column_name, &$variable, $type = SQLT_CHR) {
		return oci_define_by_name($this->resource, $column_name, $variable, $type);
	}
	
	function fetchAll(&$output, $skip = 0, $maxrows = -1, $flags = 0) {
		return oci_fetch_all($this->resource, $output, $skip, $maxrows, $flags);
	}
}
