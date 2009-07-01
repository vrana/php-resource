<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Socket extends Resource {
	protected static $prefix = 'socket_';
	protected $destructor = 'close';
	
	function getpeername(&$addr, &$port = null) {
		return socket_getpeername($this->resource, $addr, $port);
	}
	
	function recv(&$buf, $len, $flags) {
		return socket_recv($this->resource, $buf, $len, $flags);
	}
	
	function recvfrom(&$buf, $len, $flags, &$name, &$port = null) {
		return socket_recvfrom($this->resource, $buf, $len, $flags, $name, $port);
	}
}
