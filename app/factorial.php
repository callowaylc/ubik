<?php
# author: christian calloway callowaylc@gmail.com
# description: factorial implementation using memoization via global cache 

function factorial($number) {
  # use runtime cache to ensure previously calculated values
  # can be used; cache will act as dict/hash data structure
  # using number as key
  if (!isset($GLOBALS['cache'])) {
    $cache = &$GLOBALS['cache'];
    $cache = [ ];
  }

  if ($number < 2) {
    return 1;
  } else {
    # NOTE: we have to pass number as string so that it can
    # be interpreted as dict key as opposed to numerical index
    if (!isset($cache["$number"])) {
      $cache["$number"] = ( $number * factorial($number-1) );
    }

    return $cache["$number"];
  }
}
