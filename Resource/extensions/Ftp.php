<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Ftp extends Resource {
	protected static $prefix = 'ftp_';
	protected $destructor = 'close';
}
