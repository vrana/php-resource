<?php
require_once dirname(__FILE__) . '/../Resource.php';

class Socket extends Resource {
	protected static $prefix = 'socket_';
	protected $destructor = 'close';
}
