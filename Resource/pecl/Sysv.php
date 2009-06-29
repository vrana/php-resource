<?php
require_once dirname(__FILE__) . '/../Resource.php';

class Shm extends Resource {
	protected static $prefix = 'shm_';
	protected $destructor = 'detach';
}

class Msg extends Resource {
	protected static $prefix = 'msg_';
	protected $destructor = 'removeQueue';
}

class Sem extends Resource {
	protected static $prefix = 'sem_';
	protected $destructor = 'release';
}
