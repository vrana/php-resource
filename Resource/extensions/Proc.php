<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Proc extends Resource {
	protected static $prefix = 'proc_';
	protected $destructor = 'close';
	
	static function open($cmd, $descriptorspec, &$pipes, $cwd = null, $env = array(), $other_options = array()) {
		$return = proc_open($cmd, $descriptorspec, $pipes, $cwd, $env, $other_options);
		if (is_resource($return)) {
			$args = func_get_args();
			return new self($return, __FUNCTION__, $args);
		}
		return $return;
	}
}
