<?php
require_once dirname(__FILE__) . '/Resource.php';

class Ldap extends Resource {
	protected static $prefix = 'ldap_';
	protected $destructor = 'close';
	protected $resources = array(
		'ldap result' => 'freeResult',
		'ldap result entry' => '',
	);
}
