<? 

class Model_admin extends Model {

	public static function run() {
		
		if (User::checkAuth()) {
			View::load('index.tpl');
			self::setTitle("Админ панель");
		}else {
			self::setTitle("Вход в админ панель");
			self::setInfo(View::info("info", "Вход не выполнен"));
			View::load('login.tpl');
		}
		
	}
	
}
