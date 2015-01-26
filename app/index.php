<?php
# author: christian calloway callowaylc@gmail.com
# description: show off what a preforked long running process does

$pid = getmypid();

# set global counter if this is the first request to process
$counter = &$GLOBALS['counter'];
$counter += 1;
#!isset($GLOBALS['counter']) && $GLOBALS['counter'] = 0;

# iterate counter 
#$counter += 1;


echo "pid: $pid counter: $counter"; 
