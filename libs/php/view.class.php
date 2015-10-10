<?php

if(!defined('INC_CHECK')) { die('Error!'); }

class View {
	
	private static $template = array();
	private static $path = '';
	private static $i;
	
	public static function setPath($path) {
		self::$path = $path;
	}
	
	public static function load($file, $exactly = 1) {
		if(!empty($exactly)) {
			if(self::$path != '') {
				if(is_dir(self::$path)) {
					if(file_exists(self::$path.$file)) {
						self::$template[$file] = file_get_contents(self::$path.$file);
					} else { echo 'ERROR: File <b>'.$file.'</b> not found!'; }
				} else { echo 'ERROR: Path <b>'.self::$path.'</b> is incorrect!'; }
			} else { echo 'ERROR: Unknown patch!'; }
		} else { self::$template[$file] = file_get_contents(BASE.$file); }
		self::$i = $file;
	}
	
	public static function parse($action, $search, $replace) {
		if(isset(self::$template[self::$i])) {
			switch($action) {
				case 'str': self::$template[self::$i] = str_replace($search, $replace, self::$template[self::$i]); break;
				case 'preg': self::$template[self::$i] = preg_replace($search, $replace, self::$template[self::$i]); break;
				case 'callback': self::$template[self::$i] = preg_replace_callback($search, $replace, self::$template[self::$i]); break;
			}
		}
	}
	
	public static function info($type, $message, $replace = array()) {
		self::load('info.tpl');
		switch($type) {
			case 'info':
				self::parse('preg', '~\[info\](.*?)\[/info\]~is', '$1');
				self::parse('preg', array('~\[error\](.*?)\[/error\]~is', '~\[success\](.*?)\[/success\]~is'), '');
			break;
			case 'success':
				self::parse('preg', '~\[success\](.*?)\[/success\]~is', '$1');
				self::parse('preg', array('~\[info\](.*?)\[/info\]~is', '~\[error\](.*?)\[/error\]~is'), '');
			break;
			case 'error':
				self::parse('preg', '~\[error\](.*?)\[/error\]~is', '$1');
				self::parse('preg', array('~\[info\](.*?)\[/info\]~is', '~\[success\](.*?)\[/success\]~is'), '');
			break;
		}
		self::parse('str', '{info}', $message);
		self::parse('str', array_keys($replace), array_values($replace));
		return self::compile();
	}
	
	public static function compile() {
		if(isset(self::$template[self::$i])) {
			return self::$template[self::$i];
			unset(self::$template[self::$i]);
		} else { echo 'ERROR: The <b>load()</b> function is not defined!'; }
		self::$i = '';
	}
	
}
?>