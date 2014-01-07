<?php /** @author Christian Calloway callowaylc@gmail.com */
namespace PUnicorn\Util;

/** Provides simple singleton functionality to implementing classes */
interface SingletonTrait {

	public static function singleton() {
		if (is_null(static::$_singleton)) { 
			// instantiate with dynamic argument set
			$args = func_get_args();

			$reflection = new \ReflectionClass(get_called_class());
			return $reflection->newInstanceArgs($args);

		}

		return static::$_singleton;
	}	

	protected static $_singleton;
}