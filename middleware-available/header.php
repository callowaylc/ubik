<?php // @author Christian Calloway callowaylc@gmail */
namespace PUnicorn;

/** Responsible for processing request/response headers in 
 ** mod_php fashion 
 **/
return function($request, $response = null) {

	$_SERVER = $_SERVER ?: [ ];

	// process request
	if (is_null($response)) {

		// for whatever reason php changes header name and places
		// into $_SERVER global variable; do the same here
		foreach($request->getHeaders() as $name => $value) {
			$name = 'HTTP_' . preg_replace('/-/', '_', $name);
			$_SERVER[$name] = $value;
		}

	// process response
	} else {

		// get all headers that have been defined in application and feed back
		// to my response
		$headers = [ ];

		foreach(headers_list() as $header) {
			// since header is sent back as single string, we will need to tokenize
			// the result
			list($name, $value) = str_split(':', $header);

			$headers[$name] = $value;
		}

		// write to response
		$response->writeHead(null, $headers, true);
		
	}
};