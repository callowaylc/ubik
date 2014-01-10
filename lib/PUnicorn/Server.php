<?php /** @author Christian Calloway callowaylc@gmail */
namespace PUnicorn;

/** Represents punicorn server; responsbie for encapsulating 
 ** details of server run 
 **/
class Server { 

	/** Uhh, starts the server */
	public function start() {

		// @WTFPHP FUCKING PHP! lambdas can't be defined within
		// static scope though this method has to be static according
		// to interfae, so the the below is necessary to do so
		if (!isset($this)) {
			return (new static)->start();
		}

		// retrieve singleton instance of configuration
		$configuration = Configuration::singleton();

		// create react loop and socket instances, which will
		// be used for pull connectivity and reactor pattern,
		// respectively
		$loop   = \React\EventLoop\Factory::create();
		$socket = new \React\Socket\Server($loop);
		$http   = new \React\Http\Server($socket);	

		// bind socket to port/sock-file determined in 
		// conf
		$socket->listen($configuration->listen);

		// now start master process
		try { 
			$process = Process\Master::run(function($master) 
				use ($loop, $http, $configuration, $socket) {
				
				// define generic handler for http request
				for ($counter = 0; $counter < (int)$configuration->worker_processes; $counter++) {			
					// fork our process and define a motherfucking handler for request on worker
					// process
					$master->fork(function($worker) use ($http, $loop) {
						// define handler for request
						$http->on('request', function($request, $response) use ($worker) {
							$worker->service($request, $response);
						});

						// run loop in child context - this will effectively halt child
						// process run
						$loop->run();
					});
				}

				// add a periodic timer to check worker health
				$loop->addPeriodicTimer($configuration->health_check_interval, function($timer) use ($master) {
					$master->check_workers();
				});	

				// finally run loop as master
				$socket->shutdown();
				$loop->run();			

			});

			// 

		} catch(\Exception $e) {
			throws($e);
		}
	}

	public static function stop() {
		// @PASS 
	}
}