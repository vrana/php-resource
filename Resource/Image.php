<?php
require_once dirname(__FILE__) . '/Resource.php';

class Image extends Resource {
	protected static $prefix = 'image';
	protected $destructor = 'destroy';
	protected $resources = array(
		'gd font' => '',
		'gd PS font' => 'psFreeFont',
	);
}
