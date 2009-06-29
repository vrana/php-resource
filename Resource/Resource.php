<?php
class ResourceException extends Exception {
}

abstract class Resource {
	protected static $prefix = '';
	protected static $suffix = '';
	protected $unshift = true;
	protected $destructor = '';
	protected $resources = array(); // resource_type => destructor
	private $readonly = array('resource' => null);
	
	protected function __construct($resource) {
		$this->readonly['resource'] = $resource;
	}
	
	public function __destruct() {
		$destructor = $this->destructor;
		if ($destructor) {
			$this->$destructor();
		}
	}
	
	public function __get($name) {
		return $this->readonly[$name];
	}
	
	public function __set($name, $value) {
		throw new ResourceException("Unable to write to read-only property");
	}
	
	public function __call($name, array $args) {
		if ($this->unshift) {
			array_unshift($args, $this->resource);
		} else {
			$args[] = $this->resource;
		}
		return $this->__callStatic($name, $args);
	}
	
	static function __callStatic($name, array $args) {
		// map Resource objects back to resources
		foreach ($args as &$arg) {
			if (is_object($arg) && $arg instanceof Resource) {
				$arg = $arg->resource;
			}
		}
		unset($arg);
		
		$function = static::$prefix . ((substr(static::$prefix, -1) == '_') ? preg_replace('~[A-Z]~', '_\\0', $name) : $name) . static::$suffix;
		$return = call_user_func_array($function, $args);
		
		// map resource to Resource object
		if (is_resource($return)) {
			$object = new static($return);
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
	
	//! __set_state, __sleep
}
