<?php
# author: christian calloway callowaylc@gmail.com
# description: show off what a preforked long running process does

$pid = getmypid();

if (!isset($counter)) {
  $counter = 0;
}

echo "pid: $pid counter: $counter"; 
