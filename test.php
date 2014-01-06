<?php

set_include_path(
	get_include_path() . ':/' . __DIR__ . '/lib'
);
require_once 'vendor/autoload.php';
new \PUnicorn\Server;

exit('here');
$i = 0;

$app = function ($request, $response) use (&$i) {
    $i++;
    $pid = getmypid();

    $text = "This is request number $i for #$pid.\n";
    $text = var_export($response, true);
    $headers = array('Content-Type' => 'text/plain');

    $response->writeHead(200, $headers);
    $response->end($text);
};

$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server($loop);
$http = new React\Http\Server($socket);

$http->on('request', $app);

$socket->listen(1337);

// lets try multiple children
for ($counter = 0; $counter < 5; $counter++) { 
	$pid = pcntl_fork();

	if ($pid == -1) {
	     die('could not fork');
	} else if ($pid) {
	     // we are the parent
	     //pcntl_wait($status); //Protect against Zombie children

		//$loop->run();
	} else {
	     // we are the child
		$loop->run();
	}
}
