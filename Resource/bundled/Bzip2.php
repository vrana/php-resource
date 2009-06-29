<?php
require_once dirname(__FILE__) . '/../Resource.php';

class Bzip2 extends Resource {
	protected static $prefix = 'bz';
	protected $destructor = 'close';
}
