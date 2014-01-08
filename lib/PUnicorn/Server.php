<?php /** @author Christian Calloway callowaylc@gmail */
namespace PUnicorn;

/** Represents punicorn server; responsbie for encapsulating 
 ** details of server run 
 **/
class Server { 

	/** Uhh, starts the server */
	public static function start() {
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
			$process = Process\Master::run(function() 
				use ($loop, $configuration) {

				$loop->addPeriodTimer($configuration->health_check_interval, function($timer) {
					$this->check_workers();
				});
			});

		} catch(\Exception $e) {
			throws($e);
		}

		$loop->run();
	}

	public static function stop() {
		// @PASS 
	}
}