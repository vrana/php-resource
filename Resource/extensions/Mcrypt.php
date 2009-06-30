<?php
require_once dirname(__FILE__) . '/../Resource.php';

class Mcrypt extends Resource {
	protected static $prefix = 'mcrypt_';
	protected $destructor = 'moduleClose';
	
	static function __callStatic($name, array $args) {
		if ($name == 'decryptGeneric') {
			self::$prefix = 'mdecrypt_';
			$name = 'generic';
		}
		$return = parent::__callStatic($name, $args);
		self::$prefix = 'mcrypt_';
		return $return;
	}
}
