<?php /** @author Christian Calloway callowaylc@gmail */
namespace PUnicorn\Process;
use \PUnicorn;

/** Represents the punicorn master process
 **/
class Master extends AbstractProcess { 
	
	public static function run(callable $lambda = null) {
		// create a new instance of self
		$process = new static;

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
	public function fork(callable $lambda) {
		$process = new Worker;

		$this->pids[] = ($pid = PUnicorn\fork(function() use ($process, $lambda) {
			$lambda($process);
		}));

		// write fork pid to ./tmp/pids
		`echo $pid >> ./tmp/pids/servers.pid`;

	}

	private $pids = [ ]; // forked process ids
}