<?php

// Константы
define('INC_CHECK', true);
define('BASE', str_replace('\\', '/', dirname(__FILE__)).'/');
define('PHPLIBS', BASE."libs/php/");
define('CONFIGS', BASE."data/configs/");
define('URI', "http://".$_SERVER['HTTP_HOST']);

// Проверка параметров сервера
$phpversion = explode('.', phpversion());
$phpversion = $phpversion[0].'.'.$phpversion[1];
if($phpversion > '5.2' || $phpversion == '5.2') {
	// ok...
} else { die('Ошибка! Версия PHP ниже <b>5.2</b>!'); }
$extensions = array('cURL', 'GD', 'iconv');
foreach($extensions as $extension) { if(!extension_loaded($extension)) { die('Ошибка! Расширение "<b>'.$extension.'</b>" не установлено!'); } }

// Подключаем библиотеки 
$phplibs = array(
	'utils.class.php',
	'database.class.php',
	'model.class.php',
	'user.class.php',
	'router.class.php',
	'view.class.php'
);

$configs = array(
	'config.php',
	'db_config.php'
);

foreach($phplibs as $fileName) { include(PHPLIBS.$fileName); }
foreach($configs as $fileName) { include(CONFIGS.$fileName); }

?>