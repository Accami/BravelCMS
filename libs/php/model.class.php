
<?php

class Model {
	
	private static $index = 'index/follow';
	private static $content = '';
	private static $title = '';
	private static $info = '';
	
	public static function index($index = 2) {
		if($index != 2) {
			self::$index = !empty($index)?'index/follow':'noindex/nofollow';
		} else { return self::$index; }
	}
	
	public static function getTitle() { return self::$title; }
	public static function getContent() { return self::$content; }
	public static function getInfo() { return self::$info; }
	public static function setTitle($title) { self::$title = $title; }
	public static function setContent($content) { self::$content = $content; }
	public static function setInfo($info) { self::$info = $info; }
	
	public static function load($model, $callback = '') {
		require(BASE.'models/system/'.strtolower($model).'.model.php');
		if(!empty($callback)) { call_user_func($callback, 'Model_'.$model); }
		call_user_func(array('Model_'.$model, 'run'));
	}
	
	public static function getAction() {
		$model = Router::getUrl();
		return $model[0];
	}
	
}

?>