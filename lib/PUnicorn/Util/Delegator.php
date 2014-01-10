<?php /** Christian Calloway callowaylc@gmail.com */
namespace PUnicorn\Util;
use \PUnicorn;

/** Provides delegator/proxy behavior to extending classes 
 ** @TODO support static/class methods 
 **/
class Delegator {

	function __construct($delegated) {
		is_object($delegated) or throws("Delegated argument must be an object");

		$this->delegated
	}

	/** If the method cannot be determined, lookup will pass to delegated object */
	public function __call($name, $arguments) {
		return call_user_func_array(
			[$this->delegated, $name], $arguments
		);
	}

	private $delegated;
}