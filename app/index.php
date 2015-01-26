<?php
# author: christian calloway callowaylc@gmail.com
# description: show off what a preforked long running process does

# functions

function factorial($number) { 
  # use runtime cache to ensure previously calculated values 
  # can be used; cache will act as dict/hash data structure
  # using number as key
  if (!isset($GLOBALS['cache']))
    $cache = &$GLOBALS['cache'];
    $cache = [ ];
  }

  if ($number < 2) { 
    return 1; 
  } else {
    # NOTE: we have to pass number as string so that it can
    # be interpreted as dict key as opposed to numerical index
    if (!isset($cache["$number"])) {
      return ( $number * factorial($number-1) ); 
    }
  } 
}
# main

$pid = getmypid();

# set global counter if this is the first request to process
$counter = &$GLOBALS['counter'];
$counter += 1;

# generate a series of factorial; the point is to perform
# a relatively expensive operation and determine the differene
# between recreating this effort on each request vs storing in 
# runtime/volatile memory
factorial(1);
factorial(10);
factorial(100);


echo "pid: $pid counter: $counter"; 
