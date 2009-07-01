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
				// rewind, popen don't start with 'f'
				// copy, file, mkdir, readfile, rename, rmdir, unlink use context
				self::$prefix = '';
			}
		}
		$return = parent::__callStatic($name, $args);
		self::$prefix = 'f';
		return $return;
	}
	
	static function sockOpen($target, $port, &$errno = null, &$errstr = null, $timeout = null) {
		if (func_num_args() == 5) {
			$return = fsockopen($target, $port, $errno, $errstr, $timeout);
		} else {
			$return = fsockopen($target, $port, $errno, $errstr);
		}
		$args = func_get_args();
		return self::init($return, __FUNCTION__, $args);
	}
	
	static function pSockOpen($hostname, $port, &$errno = null, &$errstr = null, $timeout = null) {
		if (func_num_args() == 5) {
			$return = pfsockopen($hostname, $port, $errno, $errstr, $timeout);
		} else {
			$return = pfsockopen($hostname, $port, $errno, $errstr);
		}
		$args = func_get_args();
		return self::init($return, __FUNCTION__, $args);
	}
	
	function lock($operation, &$wouldblock = null) {
		return flock($this->resource, $operation, $wouldblock);
	}
	
	function scanF($format, &$arg1 = null, &$arg2 = null, &$arg3 = null, &$arg4 = null, &$arg5 = null, &$arg6 = null, &$arg7 = null, &$arg8 = null, &$arg9 = null, &$arg10 = null) {
		// can be rewritten with eval() but it would be even uglier
		switch (func_num_args() - 1) {
			default: trigger_error('File::scanF() supports up to 10 variables', E_USER_WARNING);
			case 10: return fscanf($this->resource, $format, $arg1, $arg2, $arg3, $arg4, $arg5, $arg6, $arg7, $arg8, $arg9, $arg10);
			case 9: return fscanf($this->resource, $format, $arg1, $arg2, $arg3, $arg4, $arg5, $arg6, $arg7, $arg8, $arg9);
			case 8: return fscanf($this->resource, $format, $arg1, $arg2, $arg3, $arg4, $arg5, $arg6, $arg7, $arg8);
			case 7: return fscanf($this->resource, $format, $arg1, $arg2, $arg3, $arg4, $arg5, $arg6, $arg7);
			case 6: return fscanf($this->resource, $format, $arg1, $arg2, $arg3, $arg4, $arg5, $arg6);
			case 5: return fscanf($this->resource, $format, $arg1, $arg2, $arg3, $arg4, $arg5);
			case 4: return fscanf($this->resource, $format, $arg1, $arg2, $arg3, $arg4);
			case 3: return fscanf($this->resource, $format, $arg1, $arg2, $arg3);
			case 2: return fscanf($this->resource, $format, $arg1, $arg2);
			case 1: return fscanf($this->resource, $format, $arg1);
			case 0:
			case -1: return fscanf($this->resource, $format);
		}
	}
}

class StreamContext extends Resource {
	protected static $prefix = 'stream_context_';
}

class StreamSocket extends Resource {
	protected static $prefix = 'stream_socket_';
	protected $destructor = 'shutdown';
	
	static function client($remote_socket, &$errno = null, &$errstr = null, $timeout = null, $flags = STREAM_CLIENT_CONNECT, $context = null) {
		if (func_num_args() >= 4) {
			if (is_object($context) && $context instanceof Resource) {
				$context = $context->resource;
			}
			$return = stream_socket_client($remote_socket, $errno, $errstr, $timeout, $flags, $context);
		} else {
			$return = stream_socket_client($remote_socket, $errno, $errstr);
		}
		$args = func_get_args();
		return self::init($return, __FUNCTION__, $args);
	}
	
	static function server($local_socket, &$errno = null, &$errstr = null, $timeout = null, $flags = 12, $context = null) { // 12 - STREAM_SERVER_BIND | STREAM_SERVER_LISTEN
		if (func_num_args() >= 4) {
			if (is_object($context) && $context instanceof Resource) {
				$context = $context->resource;
			}
			$return = stream_socket_client($local_socket, $errno, $errstr, $timeout, $flags, $context);
		} else {
			$return = stream_socket_client($local_socket, $errno, $errstr);
		}
		$args = func_get_args();
		return self::init($return, __FUNCTION__, $args);
	}
	
	function accept($timeout = null, &$peername = null) {
		if (func_num_args() >= 1) {
			$return = stream_socket_accept($this->resource, $timeout, $peername);
		} else {
			$return = stream_socket_accept($this->resource);
		}
		$args = func_get_args();
		return self::init($return, __FUNCTION__, $args);
	}
	
	function recvfrom($length, $flags = 0, &$address = null) {
		return stream_socket_recvfrom($this->resource, $length, $flags, $address);
	}
}
