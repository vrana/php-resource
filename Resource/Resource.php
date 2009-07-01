<?php
namespace Resource;

/** Wrapper around the PHP data type resource allowing serialize() and var_export()
* @link http://code.google.com/p/php-resource/
* @author Jakub Vrana, http://php.vrana.cz/
* @copyright 2009 Jakub Vrana
* @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
*/
abstract class Resource {
	protected static $prefix = ''; // end by '_' if functions use '_' as word separator
	private static $returnResource = false; // used in __wakeup()
	public $initializing = false; // set to true before initialization, set back to false after it
	protected $unshift = true; // resource is the first parameter of functions
	protected $destructor = '';
	protected $resources = array(); // resource_type => destructor
	private $resource;
	private $type;
	private $init = array(); // initialization commands, values: array($name, $args)
	
	protected function __construct($resource, $name, array $args) {
		$this->resource = $resource;
		$this->type = get_resource_type($resource);
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
		
		$function = static::$prefix . ((substr(static::$prefix, -1) == '_') ? preg_replace('~[A-Z]~', '_\\0', $name) : $name);
		$return = call_user_func_array($function, $argsRes); //! doesn't work with reference parameters (set_state and wakeup)
		
		// map resource to Resource object
		if (!self::$returnResource && is_resource($return)) {
			$object = new static($return, $name, $args);
			if (isset($object->resources[$object->type])) {
				$object->destructor = $object->resources[$object->type];
			}
			return $object;
		}
		
		return $return;
	}
	
	public function __toString() {
		return "$this->type $this->resource";
	}
	
	public function __set_state($vars) {
		$init = array_shift($vars["init"]);
		$return = static::__callStatic($init[0], $init[1]);
		foreach ($vars["init"] as $init) {
			$return->__call($init[0], $init[1]);
		}
		foreach ($vars as $key => $val) {
			if ($key != 'resource') { // contains null
				$return->$key = $val;
			}
		}
		return $return;
	}
	
	public function __wakeup() {
		self::$returnResource = true;
		$init = $this->init[0];
		$this->resource = static::__callStatic($init[0], $init[1]);
		self::$returnResource = false;
		$oldInitializing = $this->initializing;
		$this->initializing = false; // don't overwrite
		foreach ($this->init as $i => $init) {
			if ($i) {
				$this->__call($init[0], $init[1]);
			}
		}
		$this->initializing = $oldInitializing;
	}
}

//! store functions with reference parameters to $init
