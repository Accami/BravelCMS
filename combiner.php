<?php

// Открываем соединение с базой данных
Database::connect($db_config['host'], $db_config['user'], $db_config['pass'], $db_config['base']);


$action = Model::getAction();

if ($action == "admin") {
	View::setPath('view/admin/');
}else{
	View::setPath('view/');
}

// Загрузка нужной модели
switch ($action) {
	case "admin":
		Model::load('admin');
		break;
	default:
		Model::load('default');
}

// Обработка системных переменных в шаблоне
$parse_array = array(
	'main' => array(
		'{title}' => Database::getParam("site_name")." / ".Model::getTitle(),
		'{info}' => Model::getInfo(),
		'{theme}' => View::getPath()
	)
);

View::parse('str', array_keys($parse_array['main']), array_values($parse_array['main']));

// Компилируем шаблон
echo View::compile();

// Закрываем соединение с базой данных
Database::close();


?>