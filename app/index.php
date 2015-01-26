<?php
# author: christian calloway callowaylc@gmail.com
# description: show off what a preforked long running process does

# require 

require_once './factorial.php';

# functions

# main

# get process id and start time for request 
# NOTE: hacky
$start = microtime( true ); 
$pid   = getmypid();

# set global counter if this is the first request to process
$counter = &$GLOBALS['counter'];
$counter += 1;

# generate a series of factorial; the point is to perform
# a relatively expensive operation and determine the differene
# between recreating this effort on each request vs storing in 
# runtime/volatile memory. also serves as a tongue-in-cheek reference
# to botched interview answer
foreach([ 1, 10, 100, 1000 ] as $number) { 
  factorial( $number );
}


echo "pid: $pid counter: $counter time: " . ( microtime( true ) - $start ); 
