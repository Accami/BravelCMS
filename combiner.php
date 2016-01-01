<?php
// Константы
define("BASE", mb_substr($_SERVER["SCRIPT_FILENAME"], 0, mb_strrpos($_SERVER["SCRIPT_FILENAME"], "/")));

require_once "db-config.php";
require_once "libs/system.class.php";
require_once "libs/router.class.php";
require_once "libs/db.class.php";
require_once "libs/controller.class.php";
require_once "libs/core.class.php";

DB::init();
System::init();
Router::init();

$core = new Core();
$content = $core->run();

echo $content;

?>
