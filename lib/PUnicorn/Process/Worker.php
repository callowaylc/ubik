<?php /** @author Christian Calloway callowaylc@gmail */
namespace PUnicorn\Process;
use \PUnicorn;

/** Represents a punicorn child process
 **/
class Worker extends AbstractProcess { 

	/** Responsible for servicing request */
	public function service($request, $response) {

		// get config instances
		$configuration = PUnicorn\Configuration::singleton();

		// determine middleware being employed - whether local
		// to web root or defined globally in server
		(
			is_dir($dir = $configuration->root   . '/middleware-enabled') ||
			is_dir($dir = $_ENV['PUNICORN_HOME'] . '/middleware-enabled')

		) || PUnicorn\throws(
			'Failed to find middleware-enabled directory'
		);

		// get all middleware components, require them and iterate
		// through them
		$middleware = [ ];

		foreach(glob("$dir/*.php") as $file) {
			$middleware[] = require $file;
		}

		// how we run middleware loop to service/application
		// point
		foreach($middleware as $lambda) {
			$lambda($request);
		}

		// load application and service request.. dont know how to do this yet
		$response->writeHead(200, [
			'Content-Type'   =>  'text/html',
			'Worker-Process' =>  getmypid(),
			'Memory-Usage'   => memory_get_usage()
		]);
		$response->write('suck it');

		// now reverse middleware and filter response through
		foreach(array_reverse($middleware) as $lambda) {
			$lambda($request, $response);
		}

		// finally signal end of response
		$response->end(); 
	}
}