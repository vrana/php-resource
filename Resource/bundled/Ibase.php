<?php
require_once dirname(__FILE__) . '/../Resource.php';

class Ibase extends Resource {
	protected static $prefix = 'ibase_';
	protected $destructor = 'close';
	protected $resources = array(
		'interbase link persistent' => '',
		'interbase blob' => 'blobClose',
		'interbase query' => 'freeQuery',
		'interbase result' => 'freeResult',
		'interbase transaction' => 'rollback',
	);
	
	protected function __construct($resource, $name, array $args) {
		parent::__construct($resource, $name, $args);
		if ($name == 'pconnect') {
			$this->destructor = '';
		}
	}
}
