<?php /** @author Christian Calloway callowaylc@gmail */
namespace PUnicorn\Process;
use \PUnicorn;
use \PUnicorn\HTTP;
use \PUnicorn\Logger;
use \PUnicorn\Util\State;

error_reporting(true);

/** Represents a punicorn child process
 **/
class Worker extends AbstractProcess { 

	/** Responsible for servicing request */
	public function service($request, $response) {
		Logger::log(sprintf(
			'Request %s:%s', 
			$request->getMethod(), 
			$request->getPath()
		));


		// get config instances
		$configuration = PUnicorn\Configuration::singleton();

		// wrap native response with punicorn variant; essentially acts as 
		// decorator and proxy; we need to do this to afford some functionality
		// required when running middleware chain
		$response = new HTTP\Response($response);		

		// determine middleware being employed - whether local
		// to web root or defined globally in server
		$middleware = State::persist(__FILE__ . __LINE__, function() use (
			$configuration
		) {
			$middleware = [ ];

			if (
				is_dir($dir = $configuration->root   . '/middleware-enabled') ||
				(isset($_ENV['PUNICORN_HOME']) && is_dir($dir = $_ENV['PUNICORN_HOME'] . '/middleware-enabled'))
			) {

				foreach(glob("$dir/*.php") as $file) {
					Logger::log( 'registering middleware: ' . $file );
					$middleware[] = require $file;
				}
			}

			return $middleware;
		});

		// how we run middleware loop to service/application
		// point
		foreach($middleware as $lambda) {
			$lambda($request);
		}

		// run application which involves ensuring we are root
		// path and requring file as described in request path
		chdir($configuration->root);

		ob_start();
		require $configuration->root . '/' . $request->getPath();
		$content = ob_get_clean();

		// signal our response code
		Logger::log( 'requested ' . $configuration->root . '/' . $request->getPath());


		// now reverse middleware and filter response through
		foreach(array_reverse($middleware) as $lambda) {
			$lambda($request, $response);
		}

		$response->writeHead(http_response_code(), [
			'Content-Type'   =>  'text/html',
			'Worker-Process' =>  getmypid(),
			'Memory-Usage'   => memory_get_usage()
		]);
		$response->write($content);

		// finally signal end of response
		$response->end(); 
	}
}