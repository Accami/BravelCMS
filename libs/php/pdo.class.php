<?php
if(!defined('INC_CHECK')) { die('Scat!'); }

class Database {
	
	private static $db;
	
	public function connect($address, $username, $password, $base) {
		try {
			$host = $address; $port = false;
			if(Utils::contains($address, ':')) { list($host, $port) = explode(':', $address); }
			self::$db = new PDO(
				'mysql:host='.$host.($port?';port='.$port:'').';dbname='.$base,
				$username, $password, array(
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'utf8\'',
				)
			);
			self::query('SET `time_zone`=\''.date('P').'\'');
		} catch(PDOException $e) { die('Database connection error:<br>'.PHP_EOL.'<b>'.$e->getMessage().'</b>'); }
	}
	
	public static function query($string) { try { return self::$db->query($string); } catch(PDOException $e) { echo $e->getMessage(); } }
	
	public static function result($object) { try { return $object->fetchColumn(); } catch(PDOException $e) { echo $e->getMessage(); } }
	
	public static function num_rows($object) { try { return $object->rowCount(); } catch(PDOException $e) { echo $e->getMessage(); } }
	
	public static function fetch_array($object) { try { return $object->fetch(PDO::FETCH_BOTH); } catch(PDOException $e) { echo $e->getMessage(); } }
	
	public static function fetch_row($object) { try { return $object->fetch(PDO::FETCH_NUM); } catch(PDOException $e) { echo $e->getMessage(); } }
	
	public static function close() { self::$db = null; }
	
}
?>