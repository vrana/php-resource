<?php
require_once dirname(__FILE__) . '/../Resource.php';

class OpenSSL extends Resource {
	protected static $prefix = 'openssl_';
	protected $destructor = 'close';
	protected $resources = array(
		'OpenSSL key' => 'freeKey',
		'OpenSSL X.509' => 'x509Free',
		'OpenSSL X.509 CSR' => '',
	);
}
