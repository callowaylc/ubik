<?php /** @author Christian Calloway callowaylc@gmail */
namespace PUnicorn\Util;

/** Utility class used to manage "state" within a singular
 ** process runtime
 **/
class State {

  protected static $store = [ ];

  public static function persist($key, callable $lambda) {
    if (!isset(static::$store[$key])) {
      static::$store[$key] = $lambda($key);
    }

    return static::$store[$key];
  }
}
