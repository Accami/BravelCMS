<? 
$user = new User();
if ($user->checkAuth()) {
	$view->load('index.tpl');
	$pageData['id'] = 1;
	$pageData['title'] = $config['site_name']." - Админ панель";
}else {
	$view->load('login.tpl');
	$pageData['id'] = 1;
	$pageData['title'] = $config['site_name']." - Вход в админ панель";
}
