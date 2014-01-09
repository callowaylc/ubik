<?php /** Christian Calloway callowaylc@gmail.com */
namespace PUnicorn;

/** Shortcut for throwing exception */
function throws($exception = null) {

	// @TODO we need to do tighter checks here to
	// determine exception type; if null, this is usually
	// a @PASS for debugging sake and we determine file + line #
	if (is_null($exception)) {
		$trace     = debug_backtrace()[0];
		$exception = "{$trace['file']} @ #{$trace['line']}";
	}

	// if exception is string, wrap in standard exception
	is_string($exception) && $exception = new \Exception($exception);

	throw $exception;
}

function fork(callable $lambda) {
	$pid = pcntl_fork();
	if ($pid == -1) {
	     die('could not fork');
	} else if ($pid) {
	     // we are the parent
	     pcntl_wait($status); //Protect against Zombie children
	} else {
	     // we are the child
	}
}