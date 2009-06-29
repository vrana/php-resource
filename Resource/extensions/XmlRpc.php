<?php
require_once dirname(__FILE__) . '/../Resource.php';

class XmlRpcServer extends Resource {
	protected static $prefix = 'xmlrpc_server_';
	protected $destructor = 'destroy';
}
