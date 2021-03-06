<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Curl extends Resource {
	protected static $prefix = 'curl_';
	protected $destructor = 'close';
}

class CurlMulti extends Resource {
	protected static $prefix = 'curl_multi_';
	protected $destructor = 'close';
	
	function exec(&$still_running = null) {
		return curl_multi_exec($this->resource, $still_running);
	}
}
