<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Enchant extends Resource {
	protected static $prefix = 'enchant_';
	protected $destructor = 'brokerFree';
	protected $resources = array(
		'enchant_dict' => '',
	);
}
