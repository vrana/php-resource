<?php
abstract class Resource {
	protected static $prefix = '';
	protected static $suffix = '';
	private static $returnResource = false;
	public $initializing = false;
	protected $unshift = true;
	protected $destructor = '';
	protected $resources = array(); // resource_type => destructor
	private $resource;
	private $init = array();
	
	//! constants
	
	protected function __construct($resource, $name, array $args) {
		$this->resource = $resource;
		$this->init[] = array($name, $args);
	}
	
	public function __destruct() {
		$destructor = $this->destructor;
		if ($destructor) {
			$this->$destructor();
		}
	}
	
	public function __get($name) {
		return $this->$name;
	}
	
	public function __call($name, array $args) {
		if ($this->initializing) {
			$this->init[] = array($name, $args);
		}
		if ($this->unshift) {
			array_unshift($args, $this->resource);
		} else {
			$args[] = $this->resource;
		}
		return $this->__callStatic($name, $args);
	}
	
	static function __callStatic($name, array $args) {
		// map Resource objects back to resources
		$argsRes = array();
		foreach ($args as $arg) {
			if (is_object($arg) && $arg instanceof Resource) {
				$argsRes[] = $arg->resource;
			} else {
				$argsRes[] = $arg;
			}
		}
		
		$function = static::$prefix . ((substr(static::$prefix, -1) == '_') ? preg_replace('~[A-Z]~', '_\\0', $name) : $name) . static::$suffix;
		$return = call_user_func_array($function, $argsRes);
		
		// map resource to Resource object
		if (!self::$returnResource && is_resource($return)) {
			$object = new static($return, $name, $args);
			$type = get_resource_type($return);
			if (isset($object->resources[$type])) {
				$object->destructor = $object->resources[$type];
			}
			return $object;
		}
		
		return $return;
	}
	
	public function __toString() {
		return get_called_class() . " $this->resource";
	}
	
	public function __set_state($vars) {
		$init = array_shift($vars["init"]);
		$return = static::__callStatic($init[0], $init[1]);
		foreach ($vars["init"] as $init) {
			$return->__call($init[0], $init[1]);
		}
		foreach ($vars as $key => $val) {
			if ($key != 'resource') {
				$return->$key = $val;
			}
		}
		return $return;
	}
	
	public function __wakeup() {
		self::$returnResource = true;
		$init = $this->init[0];
		$this->resource = static::__callStatic($init[0], $init[1], true);
		self::$returnResource = false;
		$oldInitializing = $this->initializing;
		$this->initializing = false;
		foreach ($this->init as $i => $init) {
			if ($i) {
				$this->__call($init[0], $init[1]);
			}
		}
		$this->initializing = $oldInitializing;
	}
}
