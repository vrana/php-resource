<?php
require_once dirname(__FILE__) . '/../Resource.php';

class Gzip extends Resource {
	protected static $prefix = 'gz';
	protected $destructor = 'close';
}
