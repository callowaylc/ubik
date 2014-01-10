<?php /** Christian Calloway callowaylc@gmail.com */
namespace PUnicorn\HTTP;
use \PUnicorn\Util;

/** Provides delegator/proxy behavior to extending classes 
 ** @TODO support static/class methods 
 **/
class Response extends Util\Delegator {

	/** Though we are using composition, we are "overriding" this method
	 ** to provide buffering support to middleware layer; ie, we need to
	 ** be able to specify headers without the response being sent 
	 **/
  public function writeHead($status = 200, array $headers = array(), $buffer = false)
  {
  	if ($buffer) { 
  		$this->headers = array_merge($this->headers, $headers);
  	
  	} else { 
  		$headers = array_merge($this->headers, $headers);

	    if ($this->headWritten) {
	        throw new \Exception('Response head has already been written.');
	    }

	    if (isset($headers['Content-Length'])) {
	        $this->chunkedEncoding = false;
	    }

	    $headers = array_merge(
	        array('X-Powered-By' => 'React/alpha'),
	        $headers
	    );
	    if ($this->chunkedEncoding) {
	        $headers['Transfer-Encoding'] = 'chunked';
	    }

	    $data = $this->formatHead($status, $headers);
	    $this->conn->write($data);

	    $this->headWritten = true;
	  }
  }	

	private $headers = [ ];
}