<?php
require_once dirname(__FILE__) . '/Resource.php';

class Curl extends Resource {
	protected static $prefix = 'curl_';
	protected $destructor = 'close';
}
