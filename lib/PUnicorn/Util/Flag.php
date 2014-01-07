<?php /** Christian Calloway callowaylc@gmail.com */
namespace PUnicorn\Util;

/** Quick helper methods for command line parse
 **/
class Flag {

	public static function parse(callable $lambda) {
		// @TODO need a way to specify short and long
		// command line arguments
		$lambda($f = new \donatj\Flags);
		$f->parse();

		return $f->longs() + $f->shorts();
	}
}