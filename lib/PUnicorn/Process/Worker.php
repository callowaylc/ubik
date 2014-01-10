<?php /** @author Christian Calloway callowaylc@gmail */
namespace PUnicorn\Process;
use \PUnicorn;
use \PUnicorn\HTTP;

/** Represents a punicorn child process
 **/
class Worker extends AbstractProcess { 

	/** Responsible for servicing request */
	public function service($request, $response) {

		// get config instances
		$configuration = PUnicorn\Configuration::singleton();

		// wrap native response with punicorn variant; essentially acts as 
		// decorator and proxy; we need to do this to afford some functionality
		// required when running middleware chain
		$response = new HTTP\Response($response);		

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

		// run application which involves ensuring we are root
		// path and requring file as described in request path
		chdir($configuration->root);

		ob_start();
		require $request->getPath();
		$content = ob_get_clean();

		// signal our response code

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