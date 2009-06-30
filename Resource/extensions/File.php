<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class File extends Resource {
	protected static $prefix = 'f';
	protected $destructor = 'close';
	protected $resources = array(
		'stream filter' => 'streamFilterRemove',
	);

	protected function __construct($resource, $name, array $args) {
		parent::__construct($resource, $name, $args);
		if ($name == 'pOpen') {
			$this->destructor = 'pClose';
		}
	}
	
	static function __callStatic($name, array $args) {
		if (!function_exists("f$name")) {
			if (function_exists("file$name")) {
				self::$prefix = 'file';
			} elseif (function_exists("file_" . preg_replace('~[A-Z]~', '_\\0', $name))) {
				self::$prefix = 'file_';
			} else {
				if ($name == 'pSockOpen') {
					$name = 'pFSockOpen';
				}
				// rewind, popen don't start with 'f'
				// copy, file, mkdir, readfile, rename, rmdir, unlink use context
				self::$prefix = '';
			}
		}
		$return = parent::__callStatic($name, $args);
		self::$prefix = 'f';
		return $return;
	}
}

class StreamContext extends Resource {
	protected static $prefix = 'stream_context_';
}

class StreamSocket extends Resource {
	protected static $prefix = 'stream_socket_';
	protected $destructor = 'shutdown';
}
