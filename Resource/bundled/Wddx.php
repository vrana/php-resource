<?php
require_once dirname(__FILE__) . '/../Resource.php';

class Wddx extends Resource {
	protected static $prefix = 'wddx_';
	protected $destructor = 'packetEnd';
}
