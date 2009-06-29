<?php
require_once dirname(__FILE__) . '/Resource.php';

class File extends Resource {
	protected static $prefix = 'f';
	protected $destructor = 'close';
	
	static function __callStatic($name, array $args) {
		if ($name == 'file' || $name == 'pOpen' || $name == 'rewind' || $name == 'pSockOpen') {
			self::$prefix = '';
			if ($name == 'pSockOpen') {
				$name = 'pFSockOpen';
			}
			if ($name == 'pOpen') {
				$return->destructor = 'pClose';
			}
		} elseif (function_exists("file$name")) {
			self::$prefix = 'file';
		} elseif (function_exists("file_" . preg_replace('~[A-Z]~', '_\\0', $name))) {
			self::$prefix = 'file_';
		}
		$return = parent::__callStatic($name, $args);
		self::$prefix = 'f';
		return $return;
	}
}

class Dir extends Resource {
	protected static $suffix = 'dir';
	protected $destructor = 'close';
}

class StreamContext extends Resource {
	protected static $prefix = 'stream_context_';
}
