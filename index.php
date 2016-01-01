<?php
// Отключаем вывод ошибок
// error_reporting (0);
// Записываем microtime
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

// Подключаем ядро
require_once('combiner.php');

// Считаем время загрузк
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<!-- Page generated in '.$total_time.' seconds. -->';
?>
