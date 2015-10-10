<? 

class Model_admin extends Model {

	public static function run() {
		
		if (User::checkAuth()) {
			View::load('index.tpl');
		}else {
			View::load('login.tpl');
		}
		
	}
	
}
