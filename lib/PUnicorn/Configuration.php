<?php /** @author Christian Calloway callowaylc@gmail */
namespace PUnicorn;

/** Provides punicorn configuration methods for config dsl */
class Configuration {

	use Util\SingletonTrait;

	/** Responsible for evaluating configuration file and
	 ** reporting (throwing exceptions) in the case of 
	 ** failure; this method along with singleton are meant
	 ** to be the ONLY public facing interface to configuration
	 **/
	public static function evaluate($file) {
		// @TODO obviously need to do more checks for
		// proper eval on configuration
		static::singleton($file)
	}

	/** Takes an external dsl and wraps within lambda; 
	 ** this way, dsl can resember a conventional config
	 ** file, but at its heart is truly php
	 **/
	function __construct($file) {
		// @TODO too much work right now to do dsl parse..
		// for right now we are going to copy file and wrap
		// in lambda a evaluate from instance context
		// @WTFPHP eval cannot evaluate a lambda by itself - 
		// we need to do the actual bind in the eval statement
		// itself
		eval('$lambda = function() {' . 
			file_get_contents($file) . 
		'};');

		// bind to this instance and then call
		$lambda->bindTo($this);
		$lambda();         


		// read contents to buffer and split into newlines
		//$lines = preg_split('\n', file_get_contents($file));
	}

	/** Used as setter in dsl */
	public function __call($name, $argument) {
		$this->config[$name] = array_pop($argument);
	}

	/** Used to retrieve values specified in config */
	public function __get($name) {
		if (isset($this->config[$name])) {
			return $this->config[$name];
		}

		throws(
			"Failed to retrieve '$name' configuration option"
		);
	}

	public function before_fork(callable $lambda) {
		// @PASS
	}

	public function after_fork(callable $lambda) {
		// @PASS
	}


	protected $config = [ ];
}