<?php /** @author Christian Calloway callowaylc@gmail */
namespace PUnicorn\Process;

/** Represents a single punicorn process **/
class AbstractProcess { 

	/** Serves as sole interface to a process; responsible 
	 ** for initiating process concerns; arguments will vary
	 ** enough between proceses that it will be necessary to
	 ** determine at runtime 
	 **/
	abstract public function static run($_arguments = null);
}