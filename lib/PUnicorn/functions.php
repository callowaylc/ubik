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

/** The purpose of this function is to execute lambda within 
 ** child context 
 **/
function fork(callable $lambda) {
	$pid = pcntl_fork();
	
	// we are the child; execute/call lambda
	if (is_null($pid)) {
		$lambda();
	
	// we have failed to fork
	} else if ($pid == -1) {
	 throws('Failed to fu.. fork.. to much whiskey?');

	}

	// return process id regardless of context
	return $pid;
}