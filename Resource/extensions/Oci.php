<?php
require_once dirname(__FILE__) . '/../Resource.php';

class Oci extends Resource {
	protected static $prefix = 'oci_';
	protected $destructor = 'close';
	protected $resources = array(
		'oci8 persistent connection' => '',
		'oci8 persistent session pool' => '',
		'oci8 statement' => 'freeStatement',
	);
}
