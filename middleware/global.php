<?php // @author Christian Calloway callowaylc@gmail */
namespace PUnicorn;
use \PUnicorn\Util\State;
use \PUnicorn\Logger;

/** Responsible for resetting state of globals after every
 ** request
 **/
return function($request, $response = null) {
  global $GLOBALS;

  // process request
  if (is_null($response)) {
    // get initial GLOBALS state
    $keys = State::persist(__FILE__ . __LINE__, function() {
      return array_keys($GLOBALS);
    }); 

    foreach ($GLOBALS as $key => $name) {
      if(!in_array($key, $keys)) {
        unset($GLOBALS[$key]);
      }
    }

    Logger::log(var_export(array_keys($GLOBALS), true));


    // reset state of static properties
    // TODO!!

  // process response
  } else {

    
  }
};