<?php
namespace Resource;

require_once dirname(__FILE__) . '/../Resource.php';

class Ibase extends Resource {
	protected static $prefix = 'ibase_';
	protected $destructor = 'close';
	protected $resources = array(
		'interbase link persistent' => '',
		'interbase blob' => 'blobClose',
		'interbase event' => 'freeEventHandler',
		'interbase query' => 'freeQuery',
		'interbase result' => 'freeResult',
		'interbase transaction' => 'rollback',
		'interbase service manager handle' => '',
	);
}
