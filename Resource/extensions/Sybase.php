<?php
require_once dirname(__FILE__) . '/../Resource.php';

class Sybase extends Resource {
	protected static $prefix = 'sybase_';
	protected $destructor = 'close';
	protected $resources = array(
		'sybase-ct link persistent' => '',
		'sybase-ct result' => 'freeResult',
	);
}
