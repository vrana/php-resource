<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Zip extends Resource {
	protected static $prefix = 'zip_';
	protected $destructor = 'close';
	protected $resources = array(
		'Zip Entry' => 'entryClose',
	);
}
