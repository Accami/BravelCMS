<?php
// Отключаем вывод ошибок
error_reporting (0);
// Записываем microtime
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

require_once "db-config.php";
require_once "libs/system.class.php";
require_once "libs/router.class.php";
require_once "libs/db.class.php";

DB::init();
System::init();
Router::init();

echo Router::get('name');

// Считаем время загрузк
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in '.$total_time.' seconds.'."\n";

?>
