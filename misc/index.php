<?php
require_once './TestClass.php';

header("X-Favor: true");
$counter = &$GLOBALS['counter'];
$counter = is_null($counter)
  ? 0
  : $counter + 1;

echo "request # $counter\n";
echo TestIndex::test();
echo TestIndex::test();

