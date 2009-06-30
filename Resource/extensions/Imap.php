<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Imap extends Resource {
	protected static $prefix = 'imap_';
	protected $destructor = 'close';
}
