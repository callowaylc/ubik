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
    // reset globals to state prior to first request; remove anything that
    // has been introduced from included application

    // get initial GLOBALS state keys
    $keys = State::persist(__FILE__ . __LINE__, function() {
      return array_keys($GLOBALS);
    }); 

    foreach(array_diff(array_keys($GLOBALS), $keys) as $key) {
      unset($GLOBALS[$key]);
    }

    // reset php "horizontal" global (class static variables) to state
    // prior to first request
    $classes = State::persist(__FILE__ . __LINE__, function() {
      return get_declared_classes();
    });

    Logger::log(var_export(array_diff(get_declared_classes(), $classes), true));

    foreach (array_diff(get_declared_classes(), $classes) as $class) {
      // copy to /tmp and load 
      //$reflection = new \ReflectionClass($class);
      //copy(R, dest);
      //Logger::log(var_export($reflection->getDefaultProperties(), true));

      //foreach($reflection->getDefaultProperties() as $property) {
      //
      //}
    }




    // reset state of static properties
    // TODO!!

  // process response
  } else {

    
  }
};