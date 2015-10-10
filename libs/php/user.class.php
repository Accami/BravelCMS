<?php

class User {
	
	public static function checkAuth() {
		global $db;
		global $db_config;
		if(isset($_COOKIE['authID']) && isset($_COOKIE['authHASH'])) {
			$query = $db->query("SELECT * FROM `".$db_config['prefix']."_users` WHERE `id` = ".$_COOKIE['authID']." LIMIT 1");
			if ($db->num_rows($query) !== 0) {
				$userArray = $db->fetch_array($query);
				if ($userArray['hash'] == $_COOKIE['authHASH']) {
					return true;
				}else {
					return false;
				}
			}else {
				return false;
			}
		}else {
			return false;
		}
	}
	
	public static function Auth($login, $pass) {
		global $db;
		global $utils;
		global $db_config;
		if (!self::checkAuth()) {
			$pass = md5($pass);
			$query = $db->query("SELECT * FROM `".$db_config['prefix']."_users` WHERE `login` = '".$login."' AND `pass` = '".$pass."' LIMIT 1");
			if ($db->num_rows($query) > 0) {
				$userArray = $db->fetch_array($query);
				$hash = self::randomHash();
				if ($query = $db->query("UPDATE `".$db_config['prefix']."_users` SET `hash` = '".$hash."' WHERE `id` = '".$userArray['id']."'")) {
					$utils->setCookie("authID", $userArray['id']);
					$utils->setCookie("authHASH", $hash);
					return true;
				}else {
					return false;
				}
			}else {
				return false;
			}
		}else {
			return false;
		}
	}
	
	public static function randomHash() {
		$chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
		$numChars = strlen($chars);
		$string = '';
		for ($i = 0; $i < $length; $i++) {
			$string .= substr($chars, rand(1, $numChars) - 1, 1);
		}
		return md5($string);
	}
	
	public static function logout() {
		global $utils;
		if (self::checkAuth()) {
			$utils->deleteCookie("authID");
			$utils->deleteCookie("authHASH");
			return true;
		}else {
			return false;
		}
	}
	
}


?>