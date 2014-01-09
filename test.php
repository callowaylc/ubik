<?php

require_once 'vendor/autoload.php';

$i = 0;

$app = function ($request, $response) use (&$i) {
    $i++;
		$pid = getmypid();

    $text = "This is request number $i from process #$pid.\n";
    $headers = array('Content-Type' => 'text/plain');

    //$response->writeHead(200, $headers);
    $response->end($text);
    $response->writeHead(404, $headers);

    echo "hello";
};

$loop = React\EventLoop\Factory::create();
$socket = new React\Socket\Server($loop);
$http = new React\Http\Server($socket);
$socket->listen(1337);

echo getmypid() . "\n";


for ($counter = 0; $counter < 5; $counter++) { 
$pid = pcntl_fork();
if ($pid == -1) {
     die('could not fork');
} else if ($pid) {
     // we are the parent
     //pcntl_wait($status); //Protect against Zombie children
} else {
     // we are the child
$http->on('request', $app);

	$loop->run();
}
}
