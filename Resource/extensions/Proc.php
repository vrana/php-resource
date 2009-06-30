<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Proc extends Resource {
	protected static $prefix = 'proc_';
	protected $destructor = 'close';
}
