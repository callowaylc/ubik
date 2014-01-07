<?php /** @author Christian Calloway callowaylc@gmail.com */
namespace PUnicorn\Util;

/** Provides simple singleton functionality to implementing classes */
interface SingletonTrait {

	public static function singleton() {
		if (is_null($instance = static::$_singleton)) { 
			// instantiate with dynamic argument set
			$args = func_get_args();

			$reflection = new \ReflectionClass(get_called_class());
			$instance   = $reflection->newInstanceArgs($args);
		}

		return $instance;
	}	

	protected static $_singleton;
}