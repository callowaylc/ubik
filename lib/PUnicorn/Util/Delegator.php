<?php /** Christian Calloway callowaylc@gmail.com */
namespace PUnicorn\Util;
use \PUnicorn;

/** Provides delegator/proxy behavior to extending classes 
 ** @TODO support static/class methods 
 **/
class Delegator {

	function __construct($delegated) {
		is_object($delegated) or throws("Delegated argument must be an object");

		$this->delegated = $delegated;
	}

	public function __get($name) {
		// use reflection to make sure we can access the property
		// @TODO obviously we need stricter checks here
		$class    = new \ReflectionClass($this->delegated);
		$property = $class->getProperty($name);
		$property->setAccessible(true);	

		// finally return value
		// @TODO can we use references here?
		return $property->getValue();
	}

	public function __set($name, $value) {
		// use reflection to make sure we can access the property
		// @TODO obviously we need stricter checks here
		$class    = new \ReflectionClass($this->delegated);
		$property = $class->getProperty($name);
		$property->setAccessible(true);	

		// finally return value
		return $property->setValue($value);		
	}

	/** If the method cannot be determined, lookup will pass to delegated object */
	public function __call($name, $arguments) {
		$method = new ReflectionMethod($this->delegated, $name);
		$method->setAccessible(true);

		return $method->invokeArgs($arguments);
	}

	private $delegated;
}