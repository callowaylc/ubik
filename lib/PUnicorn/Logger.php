<?php /** @author Christian Calloway callowaylc@gmail */
namespace PUnicorn;

use Monolog;
use Monolog\Handler\StreamHandler;

/** Represents punicorn server; responsbie for encapsulating 
 ** details of server run 
 **/
class Logger { 

  protected $engine;
  private static $instance;

  public static function instance() {
    if (!isset(static::$instance)) {
      static::$instance = new Monolog\Logger( 'php.io' );
      static::$instance->pushHandler(new StreamHandler(
        '/tmp/php.io/application.log', Monolog\Logger::INFO
      ));
    }

    return static::$instance;
  }

  public static function log( $message, $type = 'info' ) {
    $method = 'add' . ucfirst( $type );
    static::instance()->$method( $message );
  }
}