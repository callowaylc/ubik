<?php /** @author Christian Calloway callowaylc@gmail */
namespace PUnicorn;

/** Represents punicorn server; responsbie for encapsulating 
 ** details of server run 
 **/
class Server { 

	function __static() {
		$loop   = React\EventLoop\Factory::create();
		$socket = new React\Socket\Server($loop);
		$http   = new React\Http\Server($socket);		
	}
}

// I dont really like doing this; but the choice is to do an explicit
// call on __static or modify composer autoloader, which would present
// a whole lotta fun fucking times
Server::__static();