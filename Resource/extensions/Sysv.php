<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Shm extends Resource {
	protected static $prefix = 'shm_';
	protected $destructor = 'detach';
}

class Msg extends Resource {
	protected static $prefix = 'msg_';
	protected $destructor = 'removeQueue';
	
	function receive($desiredmsgtype, &$msgtype, $maxsize, &$message, $unserialize = true, $flags = 0, &$errorcode = null) {
		return msg_receive($this->resource, $desiredmsgtype, $msgtype, $maxsize, $message, $unserialize, $flags, $errorcode);
	}
	
	function send($msgtype, $message, $serialize = true, $blocking = true, &$errorcode = null) {
		return msg_send($this->resource, $msgtype, $message, $serialize, $blocking, $errorcode);
	}
}

class Sem extends Resource {
	protected static $prefix = 'sem_';
	protected $destructor = 'release';
}
