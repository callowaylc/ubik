<?php /** @author Christian Calloway callowaylc@gmail */
namespace PUnicorn\Process;

/** Represents the punicorn master process
 **/
class Master extends AbstractProcess { 
	
	public static function run(callable $lambda = null) {
		// create a new instance of self
		$process = new static;

		// fork process

		// if lambda is available, bind to process instance
		// and run
		if (!is_null($lambda)) {
			$lambda = $lambda->bindTo($process);
			$lambda();
		}

		// finally return process
		return $process;
	}

	public function check_workers() {
		echo "checking workers";
	}

	private function fork() {
		// responsible for managing forking of current
		// process
	}
}