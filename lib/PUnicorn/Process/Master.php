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
			$lambda($process);
		}

		// finally return process
		return $process;
	}

	/** Checks worker health */
	public function check_workers() {
		echo "checking workers";
	}

	/** Forks master to worker process and calls lambda within
	 ** child context 
	 **/
	protected function fork(callable $lambda) {
		// responsible for managing forking of current
		// process
	}
}