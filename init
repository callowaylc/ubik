<?php

require_once 'vendor/autoload.php';
new \PUnicorn\Server;
echo getenv('PUNICORN_HOME');
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
