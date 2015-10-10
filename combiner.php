<?php

// ��������� ���������� � ����� ������
Database::connect($db_config['host'], $db_config['user'], $db_config['pass'], $db_config['base']);


$action = Model::getAction();

if ($action == "admin") {
	View::setPath('view/admin/');
}else{
	View::setPath('view/');
}

// �������� ������ ������
switch ($action) {
	case "admin":
		Model::load('admin');
		break;
	default:
		Model::load('default');
}

// ��������� ��������� ���������� � �������
$parse_array = array(
	'main' => array(
		'{title}' => "dsdfdfd"
	)
);

View::parse('str', array_keys($parse_array['main']), array_values($parse_array['main']));

// ����������� ������
echo View::compile();

// ��������� ���������� � ����� ������
Database::close();


?>