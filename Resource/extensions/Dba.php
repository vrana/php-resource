<?php
require_once dirname(__FILE__) . '/../Resource.php';

class Dba extends Resource {
	protected static $prefix = 'dba_';
	protected $unshift = false;
	protected $destructor = 'close';
	protected $resources = array(
		'dba persistent' => '',
	);
}
