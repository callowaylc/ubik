<?php // @author Christian Calloway callowaylc@gmail */
namespace PUnicorn;

use \PUnicorn\Logger;

/** Responsible for adding query arguments to php superglobal containers
 ** intended for query arguments
 **/
return function($request, $response = null) {

	// process request
	if (is_null($response)) {

		// for whatever reason php changes header name and places
		// into $_SERVER global variable; do the same here
		// @TODO obviously we need to determine type here.. 
		foreach($request->getQuery() as $name => $value) {
			Logger::log( "Registering uri query parameter $name: $value");
			$_REQUEST[$name] = $value;
		}

	// process response
	} else {


		
	}
};