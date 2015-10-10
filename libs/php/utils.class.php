<?php

class Utils {
	
	public static function setCookie($name, $value, $time = 2592000) {
		setcookie($name, $value, time()+$time, '/', $_SERVER['HTTP_HOST']);
	}
	
	public static function deleteCookie($name, $time = 2592000) {
		setcookie($name, null, time()-$time, '/', $_SERVER['HTTP_HOST']);
	}
	
	public static function header($uri) {
		header('Location: '.$uri);
		exit();
	}
	
	public static function contains($haystack, $needle) {
		if(stripos($haystack, $needle) == false) {
			return false;
		} else { return true; }
	}
	
}

?>