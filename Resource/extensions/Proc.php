<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Proc extends Resource {
	protected static $prefix = 'proc_';
	protected $destructor = 'close';
	
	static function open($cmd, $descriptorspec, &$pipes, $cwd = null, $env = array(), $other_options = array()) {
		$return = proc_open($cmd, $descriptorspec, $pipes, $cwd, $env, $other_options);
		$args = func_get_args();
		return self::init($return, __FUNCTION__, $args);
	}
}
