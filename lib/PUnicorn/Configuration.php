<?php /** @author Christian Calloway callowaylc@gmail */
namespace PUnicorn;

/** Provides punicorn configuration methods for config dsl */
class Configuration {

	use Util\SingletonTrait;

	/** Takes an external dsl and wraps within lambda; 
	 ** this way, dsl can resember a conventional config
	 ** file, but at its heart is truly php
	 **/
	function __construct($file) {
		// @TODO too much work right now to do dsl parse..
		// for right now we are going to copy file and wrap
		// in lambda a evaluate from instance context
		$lambda = eval($definition = 'function() {' . 
			file_get_contents($file) . 
		'}');

		// bind to this instance and then call
		$lambda->bindTo($this);
		$lambda();         


		// read contents to buffer and split into newlines
		//$lines = preg_split('\n', file_get_contents($file));
 

	}

	public function __call($name, $argument) {
		static::$config[$name] = array_pop($argument);
	}

	public function before_fork(callable $lambda) {
		// @PASS
	}

	public function after_fork(callable $lambda) {
		// @PASS
	}


	protected $config = [ ];
}