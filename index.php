<?php

session_start();

// Запускаем таймер загрузки 
$start = microtime(true);

require_once "bootstrap.php";
require_once "combiner.php";

// Останавливаем таймер загрузки, выводим на экран
echo PHP_EOL.'<!-- Page loading time: '.number_format(microtime(true)-$start, 2).' seconds -->';

?>
