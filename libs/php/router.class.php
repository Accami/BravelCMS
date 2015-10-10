<?php

class Router {
	
	public static function getUrl() {
		$url = [];
		if (isset($_GET['url'])) {
			$url = $_GET['url'];
			$url = rtrim($url, '/');
			$url = explode('/', $url);
			return $url;
		}else {
			return '';
		}
	}
	
}

?>